<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header_t"); ?>
<style>
    .load-more a{
        display: inline-block;
        padding: 0 5px;
        height: 26px;
        line-height: 26px;
        border: 1px solid;
    }
    .load-more span{
        display: inline-block;
        padding: 0 5px;
        height: 26px;
        line-height: 26px;
        border: 1px solid;
    }
</style>
<?php include template("content","header_f"); ?>
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

            <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=81e99ffb60e56afb23e6fb1f6fef04ff&action=lists&catid=%24catid&num=16&order=id+DESC&page=%24page&moreinfo=1\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$pagesize = 16;$page = intval($page) ? intval($page) : 1;if($page<=0){$page=1;}$offset = ($page - 1) * $pagesize;$content_total = $content_tag->count(array('catid'=>$catid,'order'=>'id DESC','moreinfo'=>'1','limit'=>$offset.",".$pagesize,'action'=>'lists',));$pages = pages($content_total, $page, $pagesize, $urlrule);$data = $content_tag->lists(array('catid'=>$catid,'order'=>'id DESC','moreinfo'=>'1','limit'=>$offset.",".$pagesize,'action'=>'lists',));}?>
            <?php
            if(count($data)>8){
                $ondata=array_slice($data,0,8);
                $twdata=array_slice($data,8,(count($data)-1));
            }else{
                if(count($data)==0){
                    $ondata=array();
                }else{
                    $ondata=array_slice($data,0,(count($data)-1));
                }
                $twdata=array();
            }
            ?>
            <?php $n=1;if(is_array($ondata)) foreach($ondata AS $r) { ?>
            <div class="item">
                <a href="<?php echo $r['url'];?>">
                    <img src="<?php echo $r['thumb'];?>" class="thumb" alt="">
                    <header>
                        <h1 class="text-over"><?php echo $r['title'];?></h1>
                        <?php if(!empty($r[readpoint]) && $r[readpoint]>0){?>
                        <div class="color-orange">需要积分：<?php echo $r['readpoint'];?></div>
                        <?php }else{ ?>
                        <div>游客观看</div>
                        <?php } ?>
                    </header>
                </a>
            </div>
            <?php $n++;}unset($n); ?>
        </div><!-- end list -->


        <!-- banner -->
        <div class="banner-img mo-banner mb30">
            <a href="#">
                <img src="<?php echo WEB_PATH;?>statics/hd/images/image-advertise2.png" alt="">
            </a>
        </div>

        <?php if(!empty($twdata)){  ?>
        <div class="clearfix list"><!--  list start -->
            <?php $n=1;if(is_array($twdata)) foreach($twdata AS $r) { ?>
            <div class="item">
                <a href="<?php echo $r['url'];?>">
                    <img src="<?php echo $r['thumb'];?>" class="thumb" alt="">
                    <header>
                        <h1 class="text-over"><?php echo $r['title'];?></h1>
                        <?php if(!empty($r[readpoint]) && $r[readpoint]>0){?>
                        <div class="color-orange">需要积分：<?php echo $r['readpoint'];?></div>
                        <?php }else{ ?>
                        <div>游客观看</div>
                        <?php } ?>
                    </header>
                </a>
            </div>
            <?php $n++;}unset($n); ?>
        </div><!-- end list -->
        <?php } ?>
        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

        <!-- 加载更多 -->
        <div class="load-more"><?php echo $pages;?></div>

    </div>



</main>
<?php include template("content","foot_t"); ?>
<?php include template("content","foot_f"); ?>

