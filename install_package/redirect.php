<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 2018/10/16
 * Time: 上午10:37
 */
define('PHPCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php';
header("Location: ".APP_PATH.'index.php?m=member&c=index');