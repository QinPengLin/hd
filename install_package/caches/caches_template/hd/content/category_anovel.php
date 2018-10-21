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
    <div id="content" class="fiction">
        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=5afd6a33e5d7548cb4439c97fcc34ca6&action=lists&catid=%24catid&num=15&order=id+DESC&page=%24page&moreinfo=1\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$pagesize = 15;$page = intval($page) ? intval($page) : 1;if($page<=0){$page=1;}$offset = ($page - 1) * $pagesize;$content_total = $content_tag->count(array('catid'=>$catid,'order'=>'id DESC','moreinfo'=>'1','limit'=>$offset.",".$pagesize,'action'=>'lists',));$pages = pages($content_total, $page, $pagesize, $urlrule);$data = $content_tag->lists(array('catid'=>$catid,'order'=>'id DESC','moreinfo'=>'1','limit'=>$offset.",".$pagesize,'action'=>'lists',));}?>
        <div class="clearfix list"><!--  list start -->
            <table>
                <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                <tr>
                    <td>
                        <a href="<?php echo $r['url'];?>" target="_blank"><span><?php echo $r['title'];?></span></a>
                        <?php if(!empty($r[readpoint]) && $r[readpoint]>0){?>
                        <em>（会员支付<?php echo $r['readpoint'];?>观看）</em>
                        <?php } ?>
                    </td>
                </tr>
                <?php $n++;}unset($n); ?>
            </table>
        </div><!-- end list -->

        <!-- 加载更多 -->
        <div class="load-more">
            <?php echo $pages;?>
        </div>
        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

    </div>



</main>

<?php include template("content","foot_t"); ?>
<script>
    $(function(){
        var isScroll = true; //是否可以滚动
        // var loadMore = $(".load-more");

        $(window).scroll(function(e){
            var scrollTop = $(window).scrollTop();
            var dh = $(document).outerHeight();
            var wh = $(window).height();

            if(dh - wh - scrollTop <= 120 && isScroll){
                isScroll = false;
                loadData();
            }else if(dh - wh - scrollTop > 230 && !isScroll){
                isScroll = true;
                //loadMore.text('加载中...');
            }

        })
    })
</script>
<?php include template("content","foot_f"); ?>
