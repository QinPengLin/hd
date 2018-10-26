<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 2018/10/17
 * Time: 上午10:30
 */
defined('IN_PHPCMS') or exit('No permission resources.');
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    $modules[$i]['code']    = basename(__FILE__, '.class.php');
    $modules[$i]['name']    = L('iiiapi', '', 'pay');
    $modules[$i]['desc']    = L('iiiapi_tip', '', 'pay');
    $modules[$i]['is_cod']  = '0';
    $modules[$i]['is_online']  = '1';
    $modules[$i]['author']  = 'PHPCMS开发团队';
    $modules[$i]['website'] = 'https://a.iiiapi.com/';
    $modules[$i]['version'] = '1.0.0';
    $modules[$i]['config']  = array(
        array('name' => 'iiiapi_account','type' => 'text','value' => ''),
        array('name' => 'iiiapi_privateKey','type' => 'text','value' => ''),
        array('name' => 'service_type','type' => 'select','value' => '0'),
        array('name' => 'iiiapi_api_url','type' => 'text','value' => ''),
    );

    return;
}
pc_base::load_app_class('pay_abstract','pay','0');
class Iiiapi extends paymentabstract{

    public function __construct($config = array()) {
        if (!empty($config)) $this->set_config($config);
        $this->config['gateway_url'] =APP_PATH.'index.php?m=pay&c=deposit&a=pay_iiiapi';
        $this->config['gateway_method'] = 'POST';
        $this->config['notify_url'] = APP_PATH.'notify.php';
        $this->config['return_url'] = APP_PATH.'redirect.php';
        pc_base::load_app_func('alipay');
    }

    public function getpreparedata() {
        //订单信息
        $prepare_data['v_oid'] = $this->order_info['id'];
        return $prepare_data;
    }
    /**
     * GET接收数据
     * 状态码说明  （0 交易完成 1 交易失败 2 交易超时 3 交易处理中 4 交易未支付5交易取消6交易发生错误）
     */
    public function receive() {

    }
    /**
     * POST接收数据
     * 状态码说明  （0 交易完成 1 交易失败 2 交易超时 3 交易处理中 4 交易未支付 5交易取消6交易发生错误）
     */
    public function notify() {
        $receive_data=$_POST;
        if(isset($receive_data['trade_no']) && !empty($receive_data['trade_no']) && isset($receive_data['sign']) && !empty($receive_data['sign'])) {
            $return_data['order_id'] = $receive_data['trade_no'];
            $return_data['order_total'] = 0;
            $return_data['price'] = $receive_data['money'];
//        switch ($receive_data['trade_status']) {
//            case 'WAIT_BUYER_PAY': $return_data['order_status'] = 3; break;
//            case 'WAIT_SELLER_SEND_GOODS': $return_data['order_status'] = 3; break;
//            case 'WAIT_BUYER_CONFIRM_GOODS': $return_data['order_status'] = 3; break;
//            case 'TRADE_CLOSED': $return_data['order_status'] = 5; break;
//            case 'TRADE_FINISHED': $return_data['order_status'] = 0; break;
//            case 'TRADE_SUCCESS': $return_data['order_status'] = 0; break;
//            default:
//                $return_data['order_status'] = 5;
//        }
            if ($receive_data['finish'] < time()) {
                $return_data['order_status'] = 0;
            } else {
                $return_data['order_status'] = 4;
            }
            return $return_data;
        }else{
            return false;
        }
    }
    /**
     * 相应服务器应答状态
     * @param $result
     */
    public function response($result) {
        if (FALSE == $result) echo 'FAIL';
        else echo 'SUCCESS';
    }
    }