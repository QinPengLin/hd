<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('member', 'header'); ?>
<div id="memberArea">
	<?php include template('member', 'left'); ?>
	<div class="col-auto">
		<div class="col-1 ">
			<h5 class="title"><?php echo L('buy_point');?></h5>
			<div class="content">
			<form method="post" action="" id="myform" name="myform">
			<table width="100%" cellspacing="0" class="table_form">
				<tr>
					<th width="100"><?php echo L('account_remain');?>：</th> 
					<td>	
						<font style="color:#F00; font-size:18px;font-family:Georgia,Arial; font-weight:700"><?php echo $memberinfo['amount'];?></font><?php echo L('unit_yuan');?>，
						<font style="color:#F00; font-size:12px;font-family:Georgia,Arial; font-weight:700"><?php echo $memberinfo['point'];?></font><?php echo L('unit_point');?>
					</td>
				</tr>
				<tr>
				<script language="JavaScript">
				<!--
				$(document).ready(function() {
					$("#point").html($("#money").val()*<?php if(!empty($member_setting['rmb_point_rate'])) { ?><?php echo $member_setting['rmb_point_rate'];?><?php } else { ?>10<?php } ?>);
					$("#money").keyup(function() {
						$(this).val($(this).val().replace(/[^\d]/g,''));
						$("#point").html($("#money").val()*<?php if(!empty($member_setting['rmb_point_rate'])) { ?><?php echo $member_setting['rmb_point_rate'];?><?php } else { ?>10<?php } ?>);
						if(<?php echo $memberinfo['amount'];?> < $(this).val()) {
							$("#alert").html('<?php echo L('not_sufficient_funds');?>');
						} else {
							$("#alert").html('');
						}
					});
				});
				//-->
				</script>
					<th width="100"><?php echo L('cost');?>：</th> 
					<td>	
						<input type="text" class="input-text" name="money" id="money" size="4"><?php echo L('unit_yuan');?>
						<?php echo L('can_change_point_num');?>：<font id="point" style="color:#F00; font-size:12px;font-family:Georgia,Arial; font-weight:700">0</font><?php echo L('unit_point');?>
						<font id="alert" style="color:#F00; font-size:12px;font-family:Georgia,Arial; font-weight:700"></font>
					</td>
				</tr>

				<tr>
					<th width="100"></th> 
					<td>			
						<input type="submit" class="button" name="buy" value="兑换">
					</td>
				</tr>
			</table>
			</form>
			
			</div>
			<span class="o1"></span><span class="o2"></span><span class="o3"></span><span class="o4"></span>
		</div>
		<div class="bk10"></div>

<?php if($member_setting['showapppoint']) { ?>
		<div class="col-1 ">
			<h5 class="title"><?php echo L('app_each').L('credit_change');?></h5>
			<div class="content">
			
			<form method="post" action="" id="myform" name="myform">
			<table width="100%" cellspacing="0" class="table_form">
				<tr>
					<th width="100"><?php echo L('cost');?>：</th> 
					<td>	
						<input type="text" class="input-text" name="fromvalue">
						<select name="from">
							<?php $n=1; if(is_array($credit_list)) foreach($credit_list AS $k => $v) { ?>
								<option value="<?php echo $k;?>">
								<?php echo $v['0'];?>
								</option>
							<?php $n++;}unset($n); ?>
						</select>
					</td>
				</tr>


				<tr>
					<th width="100"><?php echo L('cost');?>：</th> 
					<td>			
						<select name="to">
							<?php $n=1; if(is_array($outcredit)) foreach($outcredit AS $k => $v) { ?>
								<option value="<?php echo $v['toid'];?>_<?php echo $v['to'];?>">
								<?php echo $applist[$v['toid']]['name'];?>[<?php echo $v['toname'];?>]
								</option>
							<?php $n++;}unset($n); ?>
						</select>
					</td>
				</tr>
				<tr>
					<th width="100"></th> 
					<td>			
						<input type="submit" class="button" name="dosubmit" value="兑换">
					</td>
				</tr>
			</table>
			</form>
			
			</div>
			<span class="o1"></span><span class="o2"></span><span class="o3"></span><span class="o4"></span>
		</div>
<?php } ?>

	</div>
</div>
<div class="clear"></div>
<?php include template('member', 'footer'); ?>