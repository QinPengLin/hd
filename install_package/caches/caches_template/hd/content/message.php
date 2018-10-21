<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=7" />
    <title>提示信息</title>

    <style type="text/css">
        *{ padding:0; margin:0; font-size:12px}ul,li{list-style: none;}
        .showMsg .guery {white-space: pre-wrap; /* css-3 */white-space: -moz-pre-wrap; /* Mozilla, since 1999 */white-space: -pre-wrap; /* Opera 4-6 */white-space: -o-pre-wrap; /* Opera 7 */  word-wrap: break-word; /* Internet Explorer 5.5+ */}
        a:link,a:visited{text-decoration:none;color:#0068a6}
        a:hover,a:active{color:#ff6600;text-decoration: underline}
        .showMsg{border: 1px solid rgba(247,212,104,1); zoom:1; width:450px; height:auto;position:absolute;top:30%;left:50%;margin:-87px 0 0 -225px}
        .showMsg h5{background: rgba(247,212,104,1); color:#fff; height:45px; line-height:45px;*line-height:45px; overflow:hidden; font-size:18px; text-align:center;}
        .showMsg .content{ padding:46px 12px 10px 45px; font-size:16px;font-weight: 600;height:66px;}
        .showMsg .bottom{ background:/*#e4ecf7*/none; margin: 0 1px 30px 1px;line-height:45px; *line-height:45px; height:45px; text-align:center}
        .showMsg .ok,.showMsg .guery{background: url(<?php echo IMG_PATH?>/msg_img/msg_bg.png) no-repeat 0px -560px;}
        .showMsg .guery{background-position: left -460px;}
        /**/
        .btndialog{display: inline-block;width: 100%;}
        .btndialog li.fl{float: left;padding-left: 50px;}
        .btndialog li.fr{float: right;padding-right: 50px;}
        .btndialog a{text-decoration: none;border:rgba(247,212,104,1) solid 1px;color: #1054ff;display: inline-block;width: 110px;text-align: center;line-height: 45px;font-size: 16px;}
        .btndialog .link{-moz-border-radius: 5px;-webkit-border-radius: 5px;border-radius: 5px;color: #0D0A0A;}
        .btndialog a.goindex{background: rgba(247,212,104,1);color: #FFF;}
        .btndialog a:hover{background: rgba(247,212,104,1);color: #FFF;border-color:rgba(247,212,104,1);}
    </style>
    <script type="text/javaScript" src="<?php echo JS_PATH;?>jquery.min.js"></script>
    <script language="JavaScript" src="<?php echo JS_PATH;?>admin_common.js"></script>
</head>
<body>
<div class="showMsg" style="text-align:center">
    <h5>提示信息</h5>
    <div class="content guery" style="display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline; max-width:280px"><?php echo $msg;?></div>
    <div class="bottom">
        <?php if($url_forward=='goback' || $url_forward=='') { ?>
        <ul class="btndialog">
            <li class="fl"><a class="link" href="javascript:history.back();">返回上一页</a></li>
            <li class="fr"><a class="link goindex" href="/">返回首页</a></li>
        </ul>
        <?php } elseif ($url_forward=="close") { ?>
        <ul class="btndialog">
            <li class="fl"><a class="link" onClick="window.close();">关闭</a></li>
            <li class="fr"><a class="link goindex" href="/">返回首页</a></li>
        </ul>
        <?php } elseif ($url_forward=="blank") { ?>
        <?php } elseif ($url_forward) { ?>
        <ul class="btndialog">
            <li class="fl"><a class="link" href="<?php echo strip_tags($url_forward);?>">返回上一页</a></li>
            <li class="fr"><a class="link goindex" href="/">返回首页</a></li>
        </ul>

        <script language="javascript">
            setTimeout("redirect('<?php echo strip_tags($url_forward);?>');",<?php echo $ms;?>);
        </script>
        <?php } ?>
        <?php if($dialog) { ?>
        <script style="text/javascript">
            window.top.location.reload();
            window.top.art.dialog({id:"<?php echo $dialog;?>"}).close();
        </script>
        <?php } ?>
        </div>
        </div>
        <script style="text/javascript">
            function close_dialog() {
                window.top.location.reload();
                window.top.art.dialog({id:"<?php echo $dialog?>"}).close();
            }
        </script>
</body>
</html>