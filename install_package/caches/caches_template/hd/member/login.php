<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>黄逗 - <?php echo L('member','','member').L('manage_center');?></title>
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/hd/css/base.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/hd/css/style.css">
    <link rel="shortcut icon" href="<?php echo WEB_PATH;?>statics/hd/images/favicon.ico">
</head>
<body class="login">

<div class="login-left">
    <img src="<?php echo WEB_PATH;?>statics/hd/images/icon/icon-logo-big.png" class="icon-login">
    <form method="post" action=""  id="myform" name="myform">
        <input type="hidden" name="forward" id="forward" value="<?php echo $forward;?>">
        <input type="hidden" name="dosubmit" value="登录" />
    <div class="r1">
        <div class="row">
            <!-- 添加class show 显示 -->
            <div class="label" id="username_txt"></div>
            <input type="text" name="username" maxlength="50" i="0" id="username" class="in" placeholder="请输入用户"/>
        </div>

        <div class="row">
            <div class="label" id="password_txt"></div>
            <input type="password" name="password" id="password" maxlength="50" i="0" class="in" placeholder="请输入密码"/>
        </div>

        <div class="row">
            <div class="label" id="code_txt"></div>
            <input type="text" name="code" maxlength="9" i="0" id="code" class="in" placeholder="请输入验证码"/>
            <a href="javascript:;" class="get-yzm yzm-img">
                <?php echo form::checkcode('code_img', '5', '14', 120, 26);?>
            </a>
        </div>

        <div class="r2 tr">
            <a href="#" class="btn-get-pwd">忘记密码？</a>
        </div>

        <div class="r3">
            <button id="sb" class="btn-login">登陆</button>
            <button onClick='window.location.href="/index.php?m=member&c=index&a=register";return false;' class="btn-reg">注册</button>
        </div>
    </div>
    </form>

    <a href="#" class="u-login">游客登陆</a>

</div>

<div class="main">
    <div class="tr top">
        <p>请输入用户名及密码</p>
        <p>完成登陆</p>
    </div>

    <div class="bottom">
        <p>欢迎来到</p>
        <div>
            <span>黄逗</span>社区
        </div>
    </div>
</div>


<!-- 注册成功！ -->
<!-- 添加 class  show 显示 -->
<div class="login-success ">
    <img src="<?php echo WEB_PATH;?>statics/hd/images/icon/icon-logo-big.png" class="icon-logo" alt="">
    <p>注册成功！</p>
</div>




<script src="<?php echo WEB_PATH;?>statics/hd/js/jquery.min.js"></script>
<script src="<?php echo WEB_PATH;?>statics/hd/js/index.js"></script>
<script>
    function ck_username(){
        $('#username').attr('i',0);
        var username_val=$('#username').val();
        if(username_val.length<2 || username_val.length>20){
            $('#username_txt').removeClass('label_g');
            $('#username_txt').addClass('label');
            $('#username_txt').addClass('show');//label_g
            $('#username_txt').text('用户名在2-20位字符之间');
        }else {
            $('#username_txt').removeClass('show');
            $('#username_txt').removeClass('label');
            $('#username_txt').addClass('label_g');
            $('#username_txt').text('验证成功！');
            $('#username_txt').addClass('show');
            $('#username').attr('i', 1);
        }
    }
    function ck_password(){
        $('#password').attr('i',0);
        var password_val=$('#password').val();
        if(password_val.length<6 || password_val.length>20){
            $('#password_txt').removeClass('label_g');
            $('#password_txt').addClass('label');
            $('#password_txt').addClass('show');//label_g
            $('#password_txt').text('密码在2-20位字符之间！');
        }else {
            $('#password_txt').removeClass('show');
            $('#password_txt').removeClass('label');
            $('#password_txt').addClass('label_g');
            $('#password_txt').text('验证成功！');
            $('#password_txt').addClass('show');
            $('#password').attr('i',1);
        }
    }
    function ck_code(){
        $('#code').attr('i',0);
        var password_val=$('#code').val();
        if(password_val.length!=5){
            $('#code_txt').removeClass('label_g');
            $('#code_txt').addClass('label');
            $('#code_txt').addClass('show');//label_g
            $('#code_txt').text('验证码长度为5位！');
        }else {
            $('#code_txt').removeClass('show');
            $('#code_txt').removeClass('label');
            $('#code_txt').addClass('label_g');
            $('#code_txt').text('验证成功！');
            $('#code_txt').addClass('show');
            $('#code').attr('i',1);
        }
    }
    $(function(){
        $('#username').blur(function () {
            ck_username();
        });
        $('#password').blur(function () {
            ck_password();
        });
        $('#code').blur(function () {
            ck_code();
        });
        $('#sb').click(function(){//
            var username_i=$('#username').attr('i');
            var password_i=$('#password').attr('i');
            var code_i=$('#code').attr('i');
            if(username_i==0){
                ck_username();
                return false;
            }
            if(password_i==0){
                ck_password();
                return false;
            }
            if(code_i==0){
                ck_code();
                return false;
            }
            $('#myform').submit();
        });
    })
</script>
</body>
</html>
