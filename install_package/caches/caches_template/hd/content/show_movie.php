<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header_t"); ?>
<link rel="stylesheet" href="<?php echo WEB_PATH;?>statics/hd/css/video-js.min.css">
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
                    <li><?php echo $CAT['catname'];?></li>
                    <li><?php echo $title;?></li>
                </ul>
            </div>
            <div class="no-player" >

                <!-- 已登录 -->



                    <video style="width:100%; height:100%; object-fit: fill;" id="myVideo" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="300" height="250">
                        <source id="source" src="<?php echo $musource;?>" type="application/x-mpegURL">
                    </video>


            </div>
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

        <!--   banner 1  and  mobile -->
        <div class="banner-img mo-banner">
            <a href="#">
                <img src="<?php echo WEB_PATH;?>statics/hd/images/image-advertise1.png" alt="">
            </a>
        </div>


        <!--   banner 1  and  mobile -->
        <div class="banner-img mo-banner">
            <a href="#">
                <img src="<?php echo WEB_PATH;?>statics/hd/images/image-advertise1.png" alt="">
            </a>
        </div>


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
<script>
    // videojs 简单使用
    videojs('myVideo', {
        bigPlayButton: true,
        textTrackDisplay: false,
        posterImage: false,
        errorDisplay: false
    })
    function changeVideo(url){
        var player = videojs('myVideo');
        player.pause();
        player.dispose();
        document.getElementById('videobox').innerHTML = '';
        var str2 = '<video id="myVideo" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="300" height="250">'+
            '<source id="source" src="${url}" type="application/x-mpegURL">'+
            '</video>';
        document.getElementById('videobox').innerHTML = str2;

        videojs('myVideo', {
            bigPlayButton: true,
            textTrackDisplay: false,
            posterImage: false,
            errorDisplay: false
        },function(){
            this.play();
        })
    }
</script>
<?php include template("content","foot_f"); ?>
