<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('member', 'header_t'); ?>
<?php include template('member', 'header_f'); ?>
<style>
.pay-btn{
    margin-top: 5px;
}
</style>
<!-- main -->
<main class="w1200 user-center" id="main">
    <div class="u-left">
        <div class="u-title">账号管理</div>
        <ul>
            <li>
                <a <?php  if(isset($_GET['c']) && $_GET['c']=='index' && empty($_GET['a'])){ ?>class="active"<?php } ?> href="/index.php?m=member&c=index" >账号信息</a>
            </li>
            <li>
                <a <?php  if(isset($_GET['a']) && $_GET['a']=='account_manage_password'){ ?>class="active"<?php } ?>  href="/index.php?m=member&c=index&a=account_manage_password&t=1">修改密码</a>
            </li>
            <li>
                <a <?php  if(isset($_GET['a']) && ($_GET['a']=='pay' || $_GET['a']=='pay_recharge')){ ?>class="active"<?php } ?> href="/index.php?m=pay&c=deposit&a=pay">在线充值</a>
            </li>
            <li>
                <a <?php  if(isset($_GET['a']) && $_GET['a']=='init'){ ?>class="active"<?php } ?> href="/index.php?m=pay&c=deposit&a=init">支付记录</a>
            </li>
            <li>
                <a <?php  if(isset($_GET['a']) && $_GET['a']=='change_credit'){ ?>class="active"<?php } ?> href="/index.php?m=member&c=index&a=change_credit">积分兑换</a>
            </li>
            <li>
                <a <?php  if(isset($_GET['a']) && $_GET['a']=='account_manage_upgrade'){ ?>class="active"<?php } ?> href="/index.php?m=member&c=index&a=account_manage_upgrade&t=1">会员自助升级</a>
            </li>
            <li>
                <a <?php  if(isset($_GET['a']) && $_GET['a']=='promote'){ ?>class="active"<?php } ?> href="/index.php?m=member&c=index&a=promote">代理推广</a>
                <span class="icon">积分获取</span>
            </li>
        </ul>
    </div>
    <div class="u-box">

        <div class="r1" id="pwd">
            <div class="u-r-title">
                支付记录
            </div>

            <table width="100%" cellspacing="0"  class="table-list" style="margin-top: 20px;">
                <thead>
                <tr>
                    <th width="20%">支付单号</th>
                    <th width="15%">支付方式</th>
                    <th width="8%">存入金额</th>
                    <th width="15%">支付状态</th>
                </tr>
                </thead>
                <tbody>
                <?php $n=1;if(is_array($infos)) foreach($infos AS $info) { ?>
                <tr>
                    <td width="20%" align="center"><?php echo $info['trade_sn'];?></td>
                    <td width="15%" align="center"><?php echo $info['payment'];?></td>
                    <td width="8%" align="center"><?php echo $info['money'];?> <?php echo $info['type']==1 ? '元':'点'?></td>
                    <td width="15%" align="center"><?php echo L($info['status']);?> </a>
                </tr>
                <?php $n++;}unset($n); ?>
                </tbody>
            </table>
            <div id="pages"> <?php echo $pages;?></div>

        </div>

    </div>


</main>

<?php include template('member', 'footer_t'); ?>
<?php include template('member', 'footer_f'); ?>