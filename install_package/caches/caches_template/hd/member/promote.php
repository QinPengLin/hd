<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('member', 'header_t'); ?>
<?php include template('member', 'header_f'); ?>
<!-- main -->
<main class="w1200 user-center" id="main">
    <div class="u-left">
        <div class="u-title">账号管理</div>
        <ul>
            <li>
                <a <?php  if(isset($_GET['c']) && $_GET['c']=='index' && empty($_GET['a'])){ ?>class="active"<?php } ?> href="/index.php?m=member&c=index" >账号信息</a>
            </li>
            <li>
                <a <?php  if(isset($_GET['a']) && $_GET['a']=='account_manage_password'){ ?>class="active"<?php } ?>  href="/index.php?m=member&c=index&a=account_manage_password&t=1">修改密码</a>
            </li>
            <li>
                <a href="#pay">充值升级</a>
            </li>
            <li>
                <a <?php  if(isset($_GET['a']) && $_GET['a']=='promote'){ ?>class="active"<?php } ?> href="/index.php?m=member&c=index&a=promote">代理推广</a>
                <span class="icon">积分获取</span>
            </li>
        </ul>
    </div>
    <div class="u-box">
        <div class="r1" id="dai">
            <div class="u-r-title">
                代理推广
            </div>
            <div class="u-r-con tui-box">
                <span>推广链接：<span id="url"><?php echo $url_f;?></span></span>
                <a href="javascript:;" data-clipboard-target="#url" class="btn-copy">复制链接</a>

                <div class="tips">
                    <p>推广网站只需将此链接发给其他用户即可 </p>
                    <p>其他用户若是通过此链接进入注册，并且注册成功，一名用户将为您带来<?php echo $memberinfo['promote_point'];?>积分的奖励</p>
                </div>
            </div>
        </div>
    </div>


</main>
<?php include template('member', 'footer_t'); ?>
<?php include template('member', 'footer_f'); ?>