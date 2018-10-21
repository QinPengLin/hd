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

    <form method="post" action="" id="myform">
        <div class="r1">
            <input type="hidden" id="nickname" name="nickname" value="" size="36" />
            <input type="hidden" name="siteid" value="<?php echo $siteid;?>" />

            <?php if($member_setting['choosemodel'] && count($modellist)>1) { ?>
            <?php } else { ?>
            <?php $n=1; if(is_array($modellist)) foreach($modellist AS $k => $v) { ?>
            <input name="modelid" type="hidden" value="<?php echo $k;?>"/>
            <?php $n++;}unset($n); ?>
            <?php } ?>
            <input type="hidden" name="dosubmit" value="同意注册协议，提交注册" />

            <div class="row">
                <!-- 添加class show 显示 -->
                <div id="username_txt" class="label"></div>
                <input type="text" i="0" id="username" name="username" maxlength="50" class="in" placeholder="请输入用户"/>
            </div>

            <div class="row">
                <div id="email_txt" class="label"></div>
                <input type="email" i="0" id="email" name="email" maxlength="50" class="in" placeholder="请输入邮箱"/>
            </div>

            <div class="row">
                <div class="label" id="password_txt"></div>
                <input type="password" id="password" name="password" i="0" maxlength="50" class="in" placeholder="请输入密码"/>
            </div>

            <div class="row">
                <div class="label" id="pwdconfirm_txt"></div>
                <input type="password" i="0" name="pwdconfirm" id="pwdconfirm" maxlength="50" class="in" placeholder="请再次输入密码"/>
            </div>

            <div class="r3">
                <button type="button" id="sb" class="btn-login">注册</button>
            </div>

        </div>
    </form>

    <a href="/index.php?m=member&c=index&a=login" class="u-login">登陆</a>

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
            $.ajax({
                url:'/index.php?m=member&c=index&a=public_checkname_ajax',
                type:'GET', //GET
                async:false,    //或false,是否异步
                data:{
                    clientid:'username',
                    username:username_val
                },
                timeout:5000,    //超时时间
                dataType:'script',    //返回的数据格式：json/xml/html/script/jsonp/text

                success:function(data,textStatus,jqXHR){
                    if (data==1){
                        $('#username_txt').removeClass('show');
                        $('#username_txt').removeClass('label');
                        $('#username_txt').addClass('label_g');
                        $('#username_txt').text('验证成功！');
                        $('#username_txt').addClass('show');
                        $('#username').attr('i',1);
                        $('#nickname').val(username_val);
                    }
                    if (data==0){
                        $('#username_txt').removeClass('show');
                        $('#username_txt').removeClass('label_g');
                        $('#username_txt').addClass('label');
                        $('#username_txt').text('用户名已经存在！');
                        $('#username_txt').addClass('show');
                    }
                },
                error:function(xhr,textStatus){
                    console.log('错误');
                }
            })
        }
    }
    function ck_email(){
        $('#email').attr('i',0);
        var email_val=$('#email').val();
        var filter = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
        if(!filter.test(email_val)){
            $('#email_txt').removeClass('label_g');
            $('#email_txt').addClass('label');
            $('#email_txt').addClass('show');//label_g
            $('#email_txt').text('邮箱格式错误！');
        }else {
            $.ajax({
                url:'/index.php?m=member&c=index&a=public_checkemail_ajax',
                type:'GET', //GET
                async:false,    //或false,是否异步
                data:{
                    clientid:'email',
                    email:email_val
                },
                timeout:5000,    //超时时间
                dataType:'script',    //返回的数据格式：json/xml/html/script/jsonp/text

                success:function(data,textStatus,jqXHR){
                    if (data==1){
                        $('#email_txt').removeClass('show');
                        $('#email_txt').removeClass('label');
                        $('#email_txt').addClass('label_g');
                        $('#email_txt').text('验证成功！');
                        $('#email_txt').addClass('show');
                        $('#email').attr('i',1);
                    }
                    if (data==0){
                        $('#email_txt').removeClass('show');
                        $('#email_txt').removeClass('label_g');
                        $('#email_txt').addClass('label');
                        $('#email_txt').text('邮箱被使用或者禁用！');
                        $('#email_txt').addClass('show');
                    }
                },
                error:function(xhr,textStatus){
                    console.log('错误');
                }
            })
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
    function ck_pwdconfirm(){
        $('#pwdconfirm').attr('i',0);
        var pwdconfirm_val=$('#pwdconfirm').val();
        var password_val=$('#password').val();
        if(pwdconfirm_val==password_val){
            $('#pwdconfirm_txt').removeClass('show');
            $('#pwdconfirm_txt').removeClass('label');
            $('#pwdconfirm_txt').addClass('label_g');
            $('#pwdconfirm_txt').text('验证成功！');
            $('#pwdconfirm_txt').addClass('show');
            $('#pwdconfirm').attr('i',1);
        }else {
            $('#pwdconfirm_txt').removeClass('label_g');
            $('#pwdconfirm_txt').addClass('label');
            $('#pwdconfirm_txt').addClass('show');//label_g
            $('#pwdconfirm_txt').text('两次密码不同！');
        }
    }
    $(function(){
        $('#username').blur(function () {
            ck_username();
        });

        $('#email').blur(function () {
            ck_email();
        });
        $('#password').blur(function () {
            ck_password();
        });
        $('#pwdconfirm').blur(function () {
            ck_pwdconfirm();
        });
        $('#sb').click(function(){//
            var username_i=$('#username').attr('i');
            var email_i=$('#email').attr('i');
            var password_i=$('#password').attr('i');
            var pwdconfirm_i=$('#pwdconfirm').attr('i');
            if(username_i==0){
                ck_username();
                return;
            }
            if(email_i==0){
                ck_email();
                return;
            }
            if(password_i==0){
                ck_password();
                return;
            }
            if(pwdconfirm_i==0){
                ck_pwdconfirm();
                return;
            }
            $('#myform').submit();
        });
    })
</script>
</body>
</html>
