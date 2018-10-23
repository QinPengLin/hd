<?php 
defined('IN_PHPCMS') or exit('No permission resources.'); 
$session_storage = 'session_'.pc_base::load_config('system','session_storage');
pc_base::load_sys_class($session_storage);
pc_base::load_app_class('foreground','member');
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);
pc_base::load_app_func('global');

class deposit extends foreground {
	private $pay_db,$member_db,$account_db;
	function __construct() {
		if (!module_exists(ROUTE_M)) showmessage(L('module_not_exists')); 
		parent::__construct();
		$this->pay_db = pc_base::load_model('pay_payment_model');
		$this->account_db = pc_base::load_model('pay_account_model');
		$this->_username = param::get_cookie('_username');
		$this->_userid = intval(param::get_cookie('_userid'));
		$this->handle = pc_base::load_app_class('pay_deposit');
	}

	public function init() {
		pc_base::load_app_class('pay_factory','',0);
		$where = '';
		$page = $_GET['page'] ? intval($_GET['page']) : '1';
		$where = "AND `userid` = '$this->_userid'";
		$start = $end = $status = '';
		if($_GET['dosubmit']){
			$start_addtime = $_GET['info']['start_addtime'];
			$end_addtime = $_GET['info']['end_addtime'];
			$status = safe_replace($_GET['info']['status']);
			if($start_addtime && $end_addtime) {
				$start = strtotime($start_addtime.' 00:00:00');
				$end = strtotime($end_addtime.' 23:59:59');
				$where .= "AND `addtime` >= '$start' AND  `addtime` <= '$end'";				
			}
			if($status) $where .= "AND `status` LIKE '%$status%' ";			
		}
		if($where) $where = substr($where, 3);
		$infos = $this->account_db->listinfo($where, 'addtime DESC', $page, '15');
		if (is_array($infos) && !empty($infos)) {
			foreach($infos as $key=>$info) {
				if($info['status']=='unpay' && $info['pay_id']!= 0 && $info['pay_id']) {
					$payment = $this->handle->get_payment($info['pay_id']);
					$cfg = unserialize_config($payment['config']);
					$pay_name = ucwords($payment['pay_code']);
					
					$pay_fee = pay_fee($info['money'],$payment['pay_fee'],$payment['pay_method']);
					$logistics_fee = $info['logistics_fee'];
					$discount = $info['discount'];			
					// calculate amount
					$info['price'] = $info['money'] + $pay_fee + $logistics_fee + $discount;			
					// add order info
					$order_info['id']	= $info['trade_sn'];
					$order_info['quantity']	= $info['quantity'];
					$order_info['buyer_email']	= $info['email'];
					$order_info['order_time']	= $info['addtime'];
					
					//add product info
					$product_info['name'] = $info['contactname'];
					$product_info['body'] = $info['usernote'];
					$product_info['price'] = $info['price'];
					
					//add set_customerinfo
					$customerinfo['telephone'] = $info['telephone'];
					if($payment['is_online'] === '1') {
						$payment_handler = new pay_factory($pay_name, $cfg);		
						$payment_handler->set_productinfo($product_info)->set_orderinfo($order_info)->set_customerinfo($customer_info);
						$infos[$key]['pay_btn'] = $payment_handler->get_code('value="'.L('pay_btn').'" class="pay-btn"');					
					}
					if($payment['pay_code']=='Iiiapi'){//禁止直付再次发起支付
                        $infos[$key]['pay_btn'] = '';
                    }
					
				} else {
					$infos[$key]['pay_btn'] = '';
				}
			}
		}
		foreach(L('select') as $key=>$value) {
			$trade_status[$key] = $value;
		}
		$pages = $this->account_db->pages;
		include template('pay', 'pay_list');		
	}
	
	public function pay() {	
		$memberinfo = $this->memberinfo;
		$pay_types = $this->handle->get_paytype();
		$trade_sn = create_sn();
		param::set_cookie('trade_sn',$trade_sn);
		$show_validator = 1;
		include template('pay', 'deposit');
	}
	
	/*
	 * 充值方式支付
	 */
	public function pay_recharge() {
		if(isset($_POST['dosubmit'])) {
			$code = isset($_POST['code']) && trim($_POST['code']) ? trim($_POST['code']) : showmessage(L('input_code'), HTTP_REFERER);
			if ($_SESSION['code'] != strtolower($code)) {
					showmessage(L('code_error'), HTTP_REFERER);
			}
			$pay_id = $_POST['pay_type'];
			if(!$pay_id) showmessage(L('illegal_pay_method'));
			$_POST['info']['name'] = safe_replace($_POST['info']['name']);
			$payment = $this->handle->get_payment($pay_id);
			$cfg = unserialize_config($payment['config']);
			$pay_name = ucwords($payment['pay_code']);
			if(!param::get_cookie('trade_sn')) {showmessage(L('illegal_creat_sn'));}
			
			$trade_sn	= param::get_cookie('trade_sn');
			if(preg_match('![^a-zA-Z0-9/+=]!', $trade_sn)) showmessage(L('illegal_creat_sn'));

			$usernote = $_POST['info']['usernote'] ? $_POST['info']['name'].'['.$trade_sn.']'.'-'.new_html_special_chars(trim($_POST['info']['usernote'])) : $_POST['info']['name'].'['.$trade_sn.']';
			
			$surplus = array(
					'userid'      => $this->_userid,
					'username'    => $this->_username,
					'money'       => trim(floatval($_POST['info']['price'])),
					'quantity'    => $_POST['quantity'] ? trim(intval($_POST['quantity'])) : 1,
					'telephone'   => preg_match('/[^0-9\-]+/', $_POST['info']['telephone']) ? '' : trim($_POST['info']['telephone']),
					'contactname' => $_POST['info']['name'] ? trim($_POST['info']['name']).L('recharge') : $this->_username.L('recharge'),
					'email'       => is_email($_POST['info']['email']) ? trim($_POST['info']['email']) : '',
					'addtime'	  => SYS_TIME,
					'ip'		  => ip(),
					'pay_type'	  => 'recharge',
					'pay_id'      => $payment['pay_id'],		
					'payment'     => trim($payment['pay_name']),
					'ispay'		  => '1',
					'usernote'    => $usernote,
					'trade_sn'	  => $trade_sn,
			);
			
			$recordid = $this->handle->set_record($surplus);
			
			$factory_info = $this->handle->get_record($recordid);
			if(!$factory_info) showmessage(L('order_closed_or_finish'));
			$pay_fee = pay_fee($factory_info['money'],$payment['pay_fee'],$payment['pay_method']);
			$logistics_fee = $factory_info['logistics_fee'];
			$discount = $factory_info['discount'];
			
			// calculate amount
			$factory_info['price'] = $factory_info['money'] + $pay_fee + $logistics_fee + $discount;
			
			// add order info
			$order_info['id']	= $factory_info['trade_sn'];
			$order_info['quantity']	= $factory_info['quantity'];
			$order_info['buyer_email']	= $factory_info['email'];
			$order_info['order_time']	= $factory_info['addtime'];
			
			//add product info
			$product_info['name'] = $factory_info['contactname'];
			$product_info['body'] = $factory_info['usernote'];
			$product_info['price'] = $factory_info['price'];
			
			//add set_customerinfo
			$customerinfo['telephone'] = $factory_info['telephone'];
			if($payment['is_online'] === '1') {
				pc_base::load_app_class('pay_factory','',0);
				$payment_handler = new pay_factory($pay_name, $cfg);
				$payment_handler->set_productinfo($product_info)->set_orderinfo($order_info)->set_customerinfo($customer_info);
				$code = $payment_handler->get_code('value="'.L('confirm_pay').'" class="btn-sub"');
			} else {
				$this->account_db->update(array('status'=>'waitting','pay_type'=>'offline'),array('id'=>$recordid));
				$code = '<div class="point">'.L('pay_tip').'</div>';
			}
		}
		include template('pay', 'payment_cofirm');		
	}

    /**
     * 直付发起支付，返回支付二维码
     */
    public function pay_iiiapi(){
        date_default_timezone_set('Asia/Chongqing');
        $data=$_POST;
        //$data=$_GET;
        if(isset($data['v_oid']) && !empty($data['v_oid'])){
            $oder_data=$this->account_db->get_one(array('trade_sn'=>$data['v_oid']));
            $ment_data=$this->pay_db->get_one(array('pay_id'=>$oder_data['pay_id']));
            $cf=unserialize_config($ment_data['config']);
            //应用私钥(必填),登录后台获取
            $secret = $cf['iiiapi_privateKey'];
            //接口名称(必填),固定值
            $method = "easypay.trade.pay";
            //商户订单号(必填),请确保在本应用内没有重复
            //最大长度为20个字符,仅支付大小写字符，数字或下划线
            //建议以特定标记开头,以便于后台查询
            $tradeNo = $oder_data['trade_sn'];
            //商品名称(必填)，最大长度为40个字符
            $title = "会员充值/二维码收款";
            //订单备注(可选)，最大长度为40个字符
            $memo = $oder_data['contactname'];
            //订单总金额(必填),单位为分
            $money = intval($oder_data['money']*100);
            //支付平台(必填)，目前仅支持支付宝(alipay),计划支持微信(weixin)
            $platform = "alipay";
            $mobile = 'N';
            //时间戳(必填),格式:YYYYmmddHHiiss,如20180109123256
            $timestamp = date("YmdHis");
            //异步通知地址(必填),用于接收支付结果回调，请确保外网可以正常访问
            $notify = APP_PATH.'notify.php';
            //支付返回地址(必填),支付成功时跳转到此地址，请确保外网可以正常访问
            //网页(H5)支付时,此参数必填,其他情况下,请设置为与notify参数相同
            $redirect = APP_PATH.'redirect.php';
            //收集支付数据
            $data = array(
                "key"       =>  $cf['iiiapi_account'],
                "method"    =>  $method,
                "trade_no"  =>  $tradeNo,
                "title"     =>  $title,
                "memo"      =>  $memo,
                "money"     =>  $money,
                "platform"  =>  $platform,
                "mobile"    =>  $mobile,
                "timestamp" =>  $timestamp,
                "notify"    =>  $notify,
                "redirect"  =>  $redirect
            );
            //生成数据签名,具体步骤请查看genSign内的注释
            $sign = genSign($data,$secret);
            //加入数据签名
            $data["sign"] = $sign;
            $payid = http_build_query($data);
            $url = $cf['iiiapi_api_url']."?_____t=".time()."&".$payid;
            $retval = httpPost($url,$data);
            print_r($retval);
            $json = json_decode($retval,true);
            if($json["status"]==="SUCCESS"){
                header("Location: ".$json["page_url"]);
            }
        }
    }
	public function public_checkcode() {
		$code = $_GET['code'];
		if($_SESSION['code'] != strtolower($code)) {
			exit('0');
		} else {
			exit('1');
		}
	}
}
?>