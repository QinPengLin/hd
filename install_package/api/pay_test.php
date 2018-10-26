<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 2018/10/16
 * Time: 上午10:28
 */


date_default_timezone_set('Asia/Chongqing');

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

//注意，注意，注意，支付接口只接受UTF8编码的数据
//如果当前文件或从客户端得到的数据不是UTF8编码
//请先用toUtf8函数转换成UTF8编码,否则将会出现不可预知的错误
//示例:$v=toUtf8($v, "GB2312");

//应用ID(必填),登录后台获取
$key = "ep2018100961079631";
//应用私钥(必填),登录后台获取
$secret = "c0eb697e5da4c70775dc3107d17dfc7fc4235bbd";

//接口名称(必填),固定值
$method = "easypay.trade.pay";

//商户订单号(必填),请确保在本应用内没有重复
//最大长度为20个字符,仅支付大小写字符，数字或下划线
//建议以特定标记开头,以便于后台查询
$tradeNo = "SN".date("ymdHis").sprintf("%06d", rand(0, 999999));
//商品名称(必填)，最大长度为40个字符
$title = "个人转账/二维码收款测试";
//订单备注(可选)，最大长度为40个字符
$memo = "小小意思,不成敬意";
//订单总金额(必填),单位为分
$money = intval($_GET["money"]);
//支付平台(必填)，目前仅支持支付宝(alipay),计划支持微信(weixin)
$platform = "alipay";
$mobile = trim($_GET["mobile"]);
//时间戳(必填),格式:YYYYmmddHHiiss,如20180109123256
$timestamp = date("YmdHis");
//异步通知地址(必填),用于接收支付结果回调，请确保外网可以正常访问
$notify = "http://hd.qinpl.cn/api/notify.php";
//支付返回地址(必填),支付成功时跳转到此地址，请确保外网可以正常访问
//网页(H5)支付时,此参数必填,其他情况下,请设置为与notify参数相同
$redirect = "http://hd.qinpl.cn/api/redirect.php";

//收集支付数据
$data = array(
    "key"       =>  $key,
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

$payid = http_build_query($data);var_dump($data);var_dump($payid);

$url = "https://8229e88a.skztwy.com/gateway.php?_____t=".time()."&".$payid;

$retval = httpPost($url,$data);var_dump($url);var_dump($retval);

$json = json_decode($retval,true);

//ajaxReturn($json);
if($json["status"]==="SUCCESS"){
    header("Location: ".$json["page_url"]);exit;
}

?>
