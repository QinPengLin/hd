<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header_t"); ?>
<style>
    .pagination span{
        border: 1px solid rgba(249,187,116,1);
        display: inline-block;
        color: #fff;
        padding: 0 10px;
        height: 27px;
        line-height: 27px;
    }
</style>
<?php include template("content","header_f"); ?>

<!-- main -->
<main class="w1200 detail" id="main">

    <!--   banner 1  and  mobile -->
    <div class="banner-img mo-banner detail-mo-banner">
        <a href="#">
            <img src="<?php echo WEB_PATH;?>statics/hd/images/image-advertise1.png" alt="">
        </a>
    </div>

    <div id="content" class="clearfix ">
        <div class="fl d-left">
            <a href="#">
                <img src="<?php echo WEB_PATH;?>statics/hd/images/image-advertise10.png" alt="">
            </a>
        </div>

        <div class="fl d-center">
            <div class="breadcrumb">
                <ul>
                    <li><a target="_blank" style="color: #fff;" href="<?php echo $CAT['url'];?>"><?php echo $CAT['catname'];?></a></li>
                    <li><?php echo $title;?></li>
                </ul>
            </div>

            <!-- 未登录或无权限 不显示-->
            <!-- <div class="pages-box">
                <a class="active" href="#">第一章</a>
                <a href="#">第二章</a>
                <a href="#">第三章</a>
                <a href="#">第四章</a>
                <span>...</span>
                <a href="#">第九十章</a>
                <a href="#">第九十一章</a>
            </div> -->


            <h1 class="f-title">
                <?php echo $title;?>
            </h1>


            <?php if($allow_visitor==1) { ?>
            <!-- 未登录或无权限 不显示-->
            <div class="f-content">
                <?php echo $content;?>
             </div>
             <div class="pagination">
                 <?php echo $pages;?>
            </div>
            <div class="pages-box">
                <a href="<?php echo $previous_page['url'];?>"><?php echo $previous_page['title'];?></a>
                <a class="active" href="#"><?php echo $title;?></a>
                <a href="<?php echo $next_page['url'];?>"><?php echo $next_page['title'];?></a>
            </div>
            <?php if($voteid) { ?>
            <script language="javascript" src="<?php echo APP_PATH;?>index.php?m=vote&c=index&a=show&action=js&subjectid=<?php echo $voteid;?>&type=2"></script>
            <?php } ?>
            <?php } else { ?>
            <!-- 未登录时 显示  内容只有部分 -->
            <div class="f-content no-login">
                <?php echo $lure;?>
            </div>
            <div class="f-no-login">
                观看本小说之前需要支付
                <span><?php echo $readpoint;?> <?php if($paytype) { ?>元<?php } else { ?>点<?php } ?></span>
                ,
                <a href="<?php echo APP_PATH;?>index.php?m=content&c=readpoint&allow_visitor=<?php echo $allow_visitor;?>">支付</a>
            </div>
            <?php } ?>
        </div>
        <div class="fr d-right">
            <a href="#">
                <img src="<?php echo WEB_PATH;?>statics/hd/images/image-advertise10.png" alt="">
            </a>
        </div>
    </div>

    <div class="row mt20">
        <!--   banner 1  and  mobile -->
        <div class="banner-img mo-banner">
            <a href="#">
                <img src="<?php echo WEB_PATH;?>statics/hd/images/image-advertise1.png" alt="">
            </a>
        </div>

    </div>

</main>
<?php include template("content","foot_t"); ?>
<script src="<?php echo WEB_PATH;?>statics/hd/js/video.min.js"></script>
<?php include template("content","foot_f"); ?>