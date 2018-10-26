<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 2018/10/16
 * Time: 上午10:37
 */
define('PHPCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php';
$param = pc_base::load_sys_class('param');
$_userid = param::get_cookie('_userid');
pc_base::load_app_class_iiiapi('respond', 'pay', 0);
pc_base::load_app_class_iiiapi('functions/global.func', 'pay', 0);
$respond = new respond();//respond_iiipi
$respond->respond_iiipi();