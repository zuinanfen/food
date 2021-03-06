<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/admin_top', array (
	'title' => '查看订单' ,
	'funcname'=> 'reserve'
));
?>

<h3>订单明细</h3>
<table class="table table-striped" style="border:1px solid #ccc">
    <tbody>
    	<tr>
			<td style="width:80px;">预订单ID</td>
			<td><b><?=$detail['id']?></b></td>
		</tr>
		<tr>
			<td style="width:80px;">收货姓名</td>
			<td><input type="text" <?if($detail['status']!=0){?>disabled<?}?> id="name" value="<?=$detail['name']?>" class="form-control" placeholder="输入收货人姓名"></td>
		</tr>
		<tr>
			<td style="width:80px;">收货号码</td>
			<td><input type="text" <?if($detail['status']!=0){?>disabled<?}?> id="phone" value="<?=$detail['phone']?>" class="form-control" placeholder="输入收货人手机号码"></td>
		</tr>
		<tr>
			<td style="width:80px;">收货地址</td>
			<td><textarea rows="3" <?if($detail['status']!=0){?>disabled<?}?> id="addr" class="form-control" placeholder="输入收货地址"><?=$detail['addr']?></textarea></td>
		</tr>
		<tr>
			<td style="width:80px;">菜品描述</td>
			<td><textarea rows="3" <?if($detail['status']!=0){?>disabled<?}?> id="desc" class="form-control" placeholder="输入菜品描述"><?=$detail['desc']?></textarea></td>
		</tr>
		<tr>
			<td style="width:80px;">发货日期</td>
			<td><input type="date" <?if($detail['status']!=0){?>disabled<?}?> id="sendtime" value="<?=$detail['sendtime']?>" class="form-control" placeholder="输入收货人姓名"></td>
		</tr>
		<!-- <tr>
			<td>订单金额</td>
			<td><b><?=$detail['amount']?></b></td>
		</tr> -->
		<tr>
			<td>状态</td>
			<td><b style="color:<?=$detail['reserveStatusColor']?>"><?=$detail['reserveStatusName']?></b></td>
		</tr>

		<tr>
			<td>创建时间</td>
			<td><?=$detail['ctime']?></td>
		</tr>
		<tr>
			<td>下单用户</td>
			<td><?=$detail['username']?></td>
		</tr>
		 <?if($detail['status']==2){?>
			<tr>
				<td>快递名称</td>
				<td><b><?=$express[$detail['express']]?></b></td>
			</tr>
	    	<tr>
				<td>快递单号</td>
				<td><?=$detail['expressNumber']?></td>
			</tr>
			<tr>
				<td>快递详情</td>
				<td id="express_show"></td>
			</tr>
		<?}?>

    </tbody>
  </table>
 <?if($detail['status']==1&&$sysData['role_id']!=10){?>
<h3>物流信息</h3>
<div class="main" style="margin-bottom:10px">
	<div>
		<div class="input-group" style="margin:8px 0;">
	      <span class="input-group-addon">快递名称</span>
	      <select id="express" class="form-control">
	      <?foreach ($express as $key => $value) {?>
  		      	<option value="<?=$key?>"><?=$value?></option>
	      <?}?>
	      </select>
	    </div>
     
		<div class="input-group">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">快递单号</button>
          </span>
          <input type="text" value="" id="expressNumber" class="form-control">
        </div>

       
		<button  data-id="<?=$detail['id']?>"  style="margin:10px 0" type="button" class="btn btn-primary btn-block" id="send_btn">确认发货</button>
	</div>
	
</div>
  <?}?>
<?if($detail['user_id']==$sysData['user_id']&&$detail['status']==0){?>
<button  data-id="<?=$detail['id']?>"  style="margin:10px 0" type="button" class="btn btn-primary btn-block" id="save_btn">保存修改</button>
<?}?>
<div style="height:20px;"></div>
 	<div class="marketing">
	  	<?if(in_array($detail['status'],array(0,1))){?>
		<div style="display:inline-block;width:48%">
			<button type="button" data-id="<?=$detail['id']?>" class="btn btn-danger btn-block" id="cancelReserve">撤销该单</button>
		</div>
		<?}?>

		<?if($detail['status']==0&&$sysData['role_id']!=10){?>
		<div style="display:inline-block;width:48%">
			<button type="button" data-id="<?=$detail['id']?>" class="btn btn-warning btn-block" id="checkOrder">确认该单</button>
		</div>
		<?}?>
	</div>
<script src="<?php echo $_cdn_host?>/resource/js/admin.js?v=<?=$sysData['version']?>"></script>
<script type="text/javascript">
	$('#cancelReserve').click(function(){
		if(confirm("确定撤销该单？")){
			var id = $(this).data('id');
			Reverve.cancel(id);
		}
		
	});
	$('#checkOrder').click(function(){
		if(confirm("确定已向下单用户确认订单？")){
			var id = $(this).data('id');
			Reverve.done(id);
		}
		
	});
	$('#send_btn').click(function(){
		var data = {
			id: $(this).data('id'),
			express: $('#express').val(),
			expressNumber: $('#expressNumber').val()
		}
		Reverve.send(data);
	});
	$('#save_btn').click(function(){
		var phone = $('#phone').val();
		var name = $('#name').val();
		var addr = $('#addr').val();
		var desc = $('#desc').val();
		var sendtime = $('#sendtime').val();

		if(phone==''){
			alert('请输入手机号码！');
			return ;
		}
		if(name==''){
			alert('请输入收货人姓名！');
			return ;
		}
		if(desc==''){
			alert('请输入菜品详细说明！');
			return;
		}
		if(sendtime==''){
			alert('请选择发货日期！');
			return;
		}
		var data = {
			id: $(this).data('id'),
			phone:$.trim(phone),
			name: $.trim(name),
			addr:addr,
			desc:$.trim(desc),
			sendtime:sendtime
		}
		if(confirm('确定修改该预订单？')){
			Reverve.edit(data);
		}
	});

	<?if($detail['status']==2){?>
		Reverve.getExpress('<?=$detail['express']?>','<?=$detail['expressNumber']?>');
	<?}?>
</script>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
