<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header_t"); ?>
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
        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=4ceab54e4e7b0c63878c4b4a1b7d0c37&action=lists&catid=9&num=8&order=id+DESC&return=info\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$info = $content_tag->lists(array('catid'=>'9','order'=>'id DESC','limit'=>'8',));}?>
        <div class="clearfix list"><!--  list start -->
            <?php $n=1;if(is_array($info)) foreach($info AS $r) { ?>
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
        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

        <!-- banner -->
        <div class="banner-img mo-banner mb30">
            <a href="#">
                <img src="<?php echo WEB_PATH;?>statics/hd/images/image-advertise2.png" alt="">
            </a>
        </div>


        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=c3aef55f32dd8418b476f2f84b841560&action=lists&catid=12&num=8&order=id+DESC&return=infos\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$infos = $content_tag->lists(array('catid'=>'12','order'=>'id DESC','limit'=>'8',));}?>
        <div class="clearfix list"><!--  list start -->
            <?php $n=1;if(is_array($infos)) foreach($infos AS $r) { ?>
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
        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

        <!-- 加载更多 -->
        <div class="load-more"></div>

    </div>



</main>
<?php include template("content","foot_t"); ?>
<?php include template("content","foot_f"); ?>

