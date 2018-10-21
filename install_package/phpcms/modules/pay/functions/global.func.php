<?php 
/**
 * 生成流水号
 */
function create_sn(){
	mt_srand((double )microtime() * 1000000 );
	return date("YmdHis" ).str_pad( mt_rand( 1, 99999 ), 5, "0", STR_PAD_LEFT );
}
/**
 * 返回响应地址
 */
function return_url($code, $is_api = 0){
	if($is_api){
		return APP_PATH.'index.php?m=pay&c=respond&a=respond_post&code='.$code;
	}
	else {
		return APP_PATH.'index.php?m=pay&c=respond&a=respond_get&code='.$code;
	}
}
	
function unserialize_config($cfg){
        if (is_string($cfg) ) {
            $arr = string2array($cfg);
		$config = array();
		foreach ($arr AS $key => $val) {
			$config[$key] = $val['value'];
		}
		return $config;
	} else {
		return false;
	}
}
/**
 * 返回订单状态
 */
function return_status($status) {
	$trade_status = array('0'=>'succ', '1'=>'failed', '2'=>'timeout', '3'=>'progress', '4'=>'unpay', '5'=>'cancel','6'=>'error');
	return $trade_status[$status];
}
/**
 * 返回订单手续费
 * @param  $amount 订单价格
 * @param  $fee 手续费比率
 * @param  $method 手续费方式
 */
function pay_fee($amount, $fee=0, $method=0) {
    $pay_fee = 0;
    if($method == 0) {
    	$val = floatval($fee) / 100;
    	$pay_fee = $val > 0 ? $amount * $val : 0;
    } elseif($method == 1) {
        $pay_fee = $fee;
    }
    return round($pay_fee, 2);
}

/**
 * 生成支付按钮
 * @param $data 按钮数据
 * @param $attr 按钮属性 如样式等
 * @param $ishow 是否显示描述
 */
function mk_pay_btn($data,$attr='class="payment-show"',$ishow='1') {
	$pay_type = '';
	if(is_array($data)){
		foreach ($data as $v) {
			$pay_type .= '<label '.$attr.'>';
			$pay_type .='<input name="pay_type" type="radio" value="'.$v['pay_id'].'"> <em>'.$v['name'].'</em>';
			$pay_type .=$ishow ? '<span class="payment-desc">'.$v['pay_desc'].'</span>' :'';
			$pay_type .= '</label>';
		}
	}
	return $pay_type;
}

//获取https的GET请求结果
function httpGet($url,$timeout=30){
    //
    $curl = curl_init(); // 启动一个CURL会话

    $ua = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3080.5 Safari/537.36';

    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $ua); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    //curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    //curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回

    $result = curl_exec($curl); // 执行操作
    //print_r($result); echo $url;

    if (curl_errno($curl)) {
        echo 'Errno'.curl_error($curl);//捕抓异常
    }

    curl_close($curl); // 关闭CURL会话

    return $result; // 返回数据
}

//获取https的POST请求结果
function httpPost($url,$data,$timeout=30){
    //
    $curl = curl_init(); // 启动一个CURL会话

    $ua = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3080.5 Safari/537.36';

    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $ua); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回

    $result = curl_exec($curl); // 执行操作
    //print_r($result); echo $url;

    if (curl_errno($curl)) {
        echo 'Errno'.curl_error($curl);//捕抓异常
    }

    curl_close($curl); // 关闭CURL会话

    return $result; // 返回数据
}

//输出JSON格式
function ajaxReturn($data){
    //
    header('Access-Control-Allow-Origin: *');
    header('Content-type:text/json');
    echo json_encode($data);
    exit;
}

//检查空参数
function checkEmpty($value) {

    if(!isset($value)){
        return true;
    }

    if($value === null){
        return true;
    }

    if(trim($value)===""){
        return true;
    }

    return false;
}

//转换字符编码
function toUtf8($data,$encoding) {

    if (!empty($data)) {

        $target = "UTF-8";
        if(strcasecmp($encoding,$target)!=0){
            $data = mb_convert_encoding($data,$target,$encoding);
        }
    }

    return $data;
}

//生成数据签名
function genSign($param,$secret){

    //键值按字典序排序
    ksort($param);

    //拼接字符串，过滤空参数,得到若干组键值对
    //如key=ep2018010524109872 method=easypay.trade.pay money=1 tradeNo=SN180120132430123456
    $kvs = array();

    foreach($param as $k => $v) {

        //空参数不参与签名
        if (false === checkEmpty($v)) {
            array_push($kvs,"$k=$v");
        }
    }

    unset($k, $v);

    //将所有键值对用&连接起来,得到临时字符串
    //如key=ep2018xxx&method=easypay.trade.pay&money=1&tradeNo=SN180120132430123456
    $kvs = implode("&",$kvs);

    //拼接应用私钥,得到用于签名的最终字符串
    //如key=ep2018xxx&method=easypay.trade.pay&money=1&tradeNo=SN180120132430123456&secret=xxxxxx
    $kvs = $kvs."&secret=".$secret;

    //将最终字符串MD5(32位，小写字母)，得到数据签名
    $sign = strtolower(md5($kvs));

    return $sign;
}

?>