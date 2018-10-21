<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('member', 'header'); ?>
<div id="memberArea">
<?php include template('member', 'left'); ?>
<div class="col-auto">
<div class="col-1 ">
<h5 class="title">支付确认</h5>
<div class="content">
<table width="100%" cellspacing="0" class="table-list nHover">
<tr>
<td  width="120">费用：</td> 
<td><?php echo $factory_info['money'];?>元</td>
</tr>

<?php if($logistics_fee) { ?>
<tr>
<td  width="120">配送费用：</td> 
<td><?php echo $logistics_fee;?> 元</td>
</tr>
<?php } ?>
<?php if($discount>0) { ?>
<tr>
<td  width="120">折扣/涨价：</td> 
<td><?php echo $discount;?> 元</td>
</tr>
<?php } ?>

<?php if($pay_fee) { ?>
<tr>
<td  width="120">手续费：</td> 
<td><?php echo $pay_fee;?>元</td>
</tr>
<?php } ?>
<tr>
<td  width="120">合计：</td> 
<td><font style="color:#F00; font-size:22px;font-family:Georgia,Arial; font-weight:700"><?php echo $factory_info['price'];?></font>  元</td>
</tr>

<tr>
<td  width="120">支付方式：</td> 
<td><?php echo $factory_info['payment'];?></td>
</tr>
</table>
<div class="bk10"></div>
<?php echo $code;?>
</div>
</div>
</div>
</div>
<?php include template('member', 'footer'); ?>