<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header_t"); ?>
<?php include template("content","header_f"); ?>
<?php

   $frst=indexFreeSh(10,10);
   $frsto=$frst[0];
   $frstt=$frst[1];
?>
<!-- main -->
<main class="w1200" id="main">

    <!--   banner 1  and  mobile -->
    <div class="banner-img mo-banner">
        <a href="#">
            <img src="<?php echo WEB_PATH;?>statics/hd/images/image-advertise1.png" alt="">
        </a>
    </div>

    <!--  banner2  -->
    <div class="banner-img">
        <a href="#">
            <img src="<?php echo WEB_PATH;?>statics/hd/images/image-advertise2.png" alt="">
        </a>
    </div>

    <div class="i-con">
        <div class="con1"></div>
        <div class="con2"></div>
    </div>
    <div id="content">

        <div class="clearfix list"><!--  list start -->
            <?php
            foreach ($frsto as $r) {
            ?>
            <div class="item">
                <a href="<?php
                echo $r['url'];
                ?>">
                    <img src="<?php echo $r['thumb'][0]; ?>" class="thumb" alt="">
                    <header>
                        <h1 class="text-over"><?php echo $r['cntitle']; ?></h1>
                        <div class="color-orange">游客观看</div>
                        <div class="color-orange">时长<?php echo $r['durString']; ?></div>
                    </header>
                </a>
            </div>
            <?php } ?>
        </div><!-- end list -->

        <!-- banner -->
        <div class="banner-img mo-banner mb30">
            <a href="#">
                <img src="<?php echo WEB_PATH;?>statics/hd/images/image-advertise2.png" alt="">
            </a>
        </div>
        <div class="clearfix list"><!--  list start -->
            <?php
            foreach ($frstt as $r) {
            ?>
            <div class="item">
                <a href="<?php
                echo $r['url'];
                ?>">
                    <img src="<?php echo $r['thumb'][0]; ?>" class="thumb" alt="">
                    <header>
                        <h1 class="text-over"><?php echo $r['cntitle']; ?></h1>
                        <div class="color-orange">会员观看</div>
                        <div class="color-orange">时长<?php echo $r['durString']; ?></div>
                    </header>
                </a>
            </div>
            <?php } ?>
        </div>


        <!-- 加载更多 -->
        <div class="load-more"></div>

    </div>



</main>
<?php include template("content","foot_t"); ?>
<?php include template("content","foot_f"); ?>

