<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta name="renderer" content="webkit">
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?php echo WEB_PATH;?>statics/hd/images/favicon.ico">
    <title><?php if(isset($SEO['title']) && !empty($SEO['title'])) { ?><?php echo $SEO['title'];?><?php } ?><?php echo $SEO['site_title'];?></title>
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/hd/css/base.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/hd/css/style.css">