<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><script src="<?php echo WEB_PATH;?>statics/hd/js/jquery.min.js"></script>
<script src="<?php echo WEB_PATH;?>statics/hd/js/clipboard.min.js"></script>
<script src="<?php echo WEB_PATH;?>statics/hd/js/index.js"></script>
<script>
    $(function(){
        $("a.is-login").on('click', function(){
            $('.h-center-menu').slideToggle();
        });


        function cpoyFc(){
            var clipboard = new ClipboardJS('.btn-copy');
            clipboard.on('success', function(e) {
                showToast('复制成功');
                e.clearSelection();
            });

            clipboard.on('error', function(e) {
                showToast('复制失败，请手动复制链接');
            });

        }
        cpoyFc();
    })
</script>