<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/hd/css/base.css">
<link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/hd/css/video-js.min.css">
<link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/hd/css/style.css">
<link rel="shortcut icon" href="<?php echo WEB_PATH;?>statics/hd/images/favicon.ico">
</head>
<body class="bg_343  h100over">
<!-- 头部 -->
<header id="header">

    <!-- pc header -->
    <div class="row w1200 header-box">
        <div class="fl login2">
            <a href="/" >
                <!-- logo -->
                <img src="<?php echo WEB_PATH;?>statics/hd/images/icon/icon-logo-big.png" alt="黄逗">
            </a>
        </div>

        <!-- 登录注册 -->
        <!-- <div class="fr row btn-box">
            <a class="btn-login" href="#">登录</a>
            <a class="btn-register" href="#">注册</a>
        </div> -->

        <!-- 已登陆 -->
        <div class="fr row is-login-pc">
            <a href="javascript:;">
                <span>D</span><?php echo L('hellow');?> <?php echo get_nickname();?>
            </a>
        </div>

        <!-- 导航 -->
        <nav class="fr" id="nav">
            <ul>
                <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=e89f1974866f71e9af13b534d945fbf7&action=category&catid=0&num=8&order=listorder+ASC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>'0','order'=>'listorder ASC','limit'=>'8',));}?>
                <?php $n=1; if(is_array($data)) foreach($data AS $key => $val) { ?>
                <li>
                    <a href="<?php echo $val['url'];?>"><?php echo $val['catname'];?></a>
                </li>
                <?php $n++;}unset($n); ?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            </ul>
        </nav>
    </div>

    <!-- mobile header -->
    <div class="mo-header">
        <div class="menu-box">
            <ul>
                <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=e89f1974866f71e9af13b534d945fbf7&action=category&catid=0&num=8&order=listorder+ASC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>'0','order'=>'listorder ASC','limit'=>'8',));}?>
                <?php $n=1; if(is_array($data)) foreach($data AS $key => $val) { ?>
                <li>
                    <a href="<?php echo $val['url'];?>"><?php echo $val['catname'];?></a>
                </li>
                <?php $n++;}unset($n); ?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            </ul>
        </div>
        <div class="mo-h-box">
            <a href="javascript:;" class="menu">
                <img src="<?php echo WEB_PATH;?>statics/hd/images/icon/icon-menu.png" alt="" class="icon-menu">
                <img src="<?php echo WEB_PATH;?>statics/hd/images/icon/icon-cancel.png" alt="" class="icon-close">
            </a>

            <img src="<?php echo WEB_PATH;?>statics/hd/images/icon/icon-logo.png" alt="logo" class="icon-logo">

            <!--已登录 添加class  is-login 否则删除 -->
            <a href="javascript:;" class="btn-user is-login">

                <img src="<?php echo WEB_PATH;?>statics/hd/images/icon/icon-personal.png" alt="user" class="icon">

                <span>D</span>
            </a>

            <div class="h-center-menu">
                <a <?php  if(isset($_GET['c']) && $_GET['c']=='index' && empty($_GET['a'])){ ?>class="active"<?php } ?> href="/index.php?m=member&c=index" >账号信息</a>
                <a <?php  if(isset($_GET['a']) && $_GET['a']=='account_manage_password'){ ?>class="active"<?php } ?>  href="/index.php?m=member&c=index&a=account_manage_password&t=1">修改密码</a>
                <a <?php  if(isset($_GET['a']) && ($_GET['a']=='pay' || $_GET['a']=='pay_recharge')){ ?>class="active"<?php } ?> href="/index.php?m=pay&c=deposit&a=pay">在线充值</a>
                <a <?php  if(isset($_GET['a']) && $_GET['a']=='init'){ ?>class="active"<?php } ?> href="/index.php?m=pay&c=deposit&a=init">支付记录</a>
                <a <?php  if(isset($_GET['a']) && $_GET['a']=='change_credit'){ ?>class="active"<?php } ?> href="/index.php?m=member&c=index&a=change_credit">积分兑换</a>
                <a <?php  if(isset($_GET['a']) && $_GET['a']=='account_manage_upgrade'){ ?>class="active"<?php } ?> href="/index.php?m=member&c=index&a=account_manage_upgrade&t=1">会员自助升级</a>
                <a <?php  if(isset($_GET['a']) && $_GET['a']=='promote'){ ?>class="active"<?php } ?> href="/index.php?m=member&c=index&a=promote">代理推广</a>
            </div>
        </div>

    </div>

</header>