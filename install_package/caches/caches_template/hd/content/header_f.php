<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?></head>
<body class="bg_343 pb100">
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
            <a href="/index.php?m=member&c=index">
                <span>D</span>个人中心
            </a>
        </div>

        <!-- 导航 -->
        <nav class="fr" id="nav">
            <ul>
                <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=3d1411ab8b12cafb4cbf853b70b80a09&action=category&catid=0&num=8&order=listorder+ASC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>'0','order'=>'listorder ASC','limit'=>'8',));}?>
                <div style="display: none">
                    <?php print_r($data); ?>
                </div>
                <?php $n=1; if(is_array($data)) foreach($data AS $key => $val) { ?>
                <li
                <?php if(empty($catid) && $key==9){ ?>  class="active"  <?php } ?>
                <?php if($key==$catid){ ?>  class="active"  <?php } ?>
                ><!--  active 选中 -->
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
                <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=3d1411ab8b12cafb4cbf853b70b80a09&action=category&catid=0&num=8&order=listorder+ASC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>'0','order'=>'listorder ASC','limit'=>'8',));}?>
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
            <a href="/index.php?m=member&c=index" class="btn-user is-login">

                <img src="<?php echo WEB_PATH;?>statics/hd/images/icon/icon-personal.png" alt="user" class="icon">

               <span>D</span>
            </a>
        </div>

    </div>

</header>