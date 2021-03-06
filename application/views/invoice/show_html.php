<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/admin_top', array (
	'title' => '查看报销' ,
	'funcname'=> 'invoice'
));
?>

<h3>报销明细</h3>
<table class="table table-striped" style="border:1px solid #ccc">
    <tbody>
		<tr>
			<td style="width:80px;">标题</td>
			<td><?=$detail['title']?></td>
		</tr>
		<tr>
			<td>状态</td>
			<td><b style="color:<?=$detail['invoiceStatusColor']?>"><?=$detail['invoiceStatusName']?></b></td>
		</tr>
		<tr>
			<td>报销类型</td>
			<td><?=$detail['invoiceTypeName']?></td>
		</tr>

		<tr>
			<td>发生时间</td>
			<td><?=$detail['date']?></td>
		</tr>

		<tr>
			<td>报销金额</td>
			<td><b><?=$detail['amount']?></b></td>
		</tr>
		<tr>
			<td>说明</td>
			<td><?=$detail['desc']?></td>
		</tr>


    </tbody>
  </table>
<h3>报销状态变更</h3>
<table class="table table-striped" style="border:1px solid #ccc">
    <tbody>
    	<tr>
			<td>单号id</td>
			<td><b><?=$detail['id']?></b></td>
		</tr>
    	<tr>
			<td>提单用户</td>
			<td><?=$detail['username']?></td>
		</tr>
		<tr>
			<td>提单时间</td>
			<td><?=$detail['ctime']?></td>
		</tr>
		<?if($detail['checkTime']!='0000-00-00 00:00:00'){?>
		<tr>
			<td>审核时间</td>
			<td><b><?=$detail['checkTime']?></b></td>
		</tr>
		<tr>
			<td>审核用户</td>
			<td><b><?=$detail['check_username']?></b></td>
		</tr>
		<?}?>
		<?if($detail['doneTime']!='0000-00-00 00:00:00'){?>
		<tr>
			<td>结算时间</td>
			<td><b><?=$detail['doneTime']?></b></td>
		</tr>

		<tr>
			<td>结算用户</td>
			<td><b><?=$detail['done_username']?></b></td>
		</tr>
		<?}?>

    </tbody>
  </table>
<div style="height:20px;"></div>
 	<div class="marketing">
	  	<?if($detail['user_id']==$sysData['user_id'] && in_array($detail['status'],array(0,1,4))){?>
		<div style="display:inline-block;width:48%">
			<button type="button" data-id="<?=$detail['id']?>" class="btn btn-danger btn-block" id="cancelInvoice">撤回该单</button>
		</div>
		<?}?>
		<?if($detail['status']==0){?>
		<div style="display:inline-block;width:48%">
			<button type="button" class="btn btn-warning btn-block" id="checkOrder">通过审核</button>
		</div>
		<?}elseif($detail['status']==1&&$sysData['role_id']==90){?>
		<div style="display:inline-block;width:48%">
		<button type="button" data-id="<?=$detail['id']?>" class="btn btn-warning btn-block" id="doneOrder">结算订单</button>
		</div>
		<?}?>
	</div>
<script src="<?php echo $_cdn_host?>/resource/js/admin.js?v=<?=$sysData['version']?>"></script>
<script type="text/javascript">
	$('#cancelInvoice').click(function(){
		if(confirm("确定撤销该报销单？")){
			var id = $(this).data('id');
			Invoice.cancel(id);
		}
		
	});
	$('#doneOrder').click(function(){
		if(confirm("确定结算该报销单？请先付款后再修改状态")){
			var id = $(this).data('id');
			Invoice.done(id);
		}
		
	});
</script>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
