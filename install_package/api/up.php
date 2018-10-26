<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 2018/10/24
 * Time: 上午11:53
 */
$data=file_get_contents("php://input");

$img=$data;

$file_name = 'api'.date('Ymd').'/';
$destination_folder='update/'.$file_name; //上传文件路径
if(!file_exists($destination_folder)){
    mkdir($destination_folder);
    //chmod($destination_folder,777);
}
$filename = date('YmdHis').rand(10000,99999);
$file_data = $destination_folder.$filename.".jpg"; //完成路径
if (!file_put_contents($file_data,$img)){//写入文件中！
    echo 'no';
}else{
    echo $_SERVER['SERVER_NAME'].'/'.$file_data;
}