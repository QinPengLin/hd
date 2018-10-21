<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 2018/9/7
 * Time: 下午1:49
 */
function VerifyKey($url='/api.php?op=add_content',$timestamp,$key){
    $time=$timestamp;
    $time_s=date("s",$time);
    $time_i=date("i",$time);
    $number=intval(($time_s+$time_i)/$time_i);
    $server_key='';
    $i=0;
    while ($i<$number){
        $server_key=md5($server_key.$url.$number.$time_s.$i);
        $i++;
    }
    if($server_key==$key){
        return true;
    }
    return false;
}

defined('IN_PHPCMS') or exit('No permission resources.');
$headers = array();
foreach ($_SERVER as $key => $value) {
    if ('HTTP_' == substr($key, 0, 5)) {
        $headers[str_replace('_', '-', substr($key, 5))] = $value;
    }
}
if(!isset($headers['KEY']) || !isset($headers['TIMESTAMP'])){
    echo json_encode(array('error'=>'A1'));
    exit();
}
//$server_time=time();
//if(($headers['TIMESTAMP']>($server_time+360)) || ($headers['TIMESTAMP']<($server_time-360))){
//    echo json_encode(array('error'=>'A3'));
//    exit();
//}
if(!VerifyKey('/api.php?op=add_content',$headers['TIMESTAMP'],$headers['KEY'])){//验证合法性
    echo json_encode(array('error'=>'A2'));
    exit();
}

$db = pc_base::load_model('content_model');
$categorys = getcache('category_content_'.get_siteid(),'commons');
$post=$_POST;
if(isset($post['dosubmit'])) {
    define('INDEX_HTML', true);
    $catid = $post['info']['catid'] = intval($post['info']['catid']);
    if (trim($post['info']['title']) == '') showmessage(L('title_is_empty'));
    $category = $categorys[$catid];
    if($category['type']==0) {
        $modelid = $categorys[$catid]['modelid'];
        $db->set_model($modelid);
        $setting = string2array($category['setting']);
        $workflowid = $setting['workflowid'];
        if($workflowid && $_POST['status']!=99) {
            $post['info']['status'] =  1;
        }else{
            $post['info']['status'] = 99;
        }
        $re=$db->add_content($post['info']);
        echo json_encode(array('re'=> $re));
    }
}
