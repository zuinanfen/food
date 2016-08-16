<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/header', array (
	'title' => '订单编辑' ,
	'funcname'=> 'order'
));
?>
<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li class="active"><a href="index">订单列表</a></li>
	</ul>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div class="panel panel-default">
		<div class="panel-heading">
		<h3 class="panel-title">订单ID: <?php echo $detail->id?></h3>
		</div>
		<div class="panel-body">
			<div class="form-horizontal">
			  <div class="form-group">
				<label for="src" class="col-sm-2 control-label">订单来源：</label>
				<div class="col-sm-5">
					<select class="form-control col-sm-2" id="src">
						<?php foreach ($src_type as $id=>$name): ?>
						<option value="<?php echo $id?>"><?php echo $name?></option> 
						<?php endforeach; ?>
					</select>
				</div>
			  </div>
			  <div class="form-group">
				<label for="table_id" class="col-sm-2 control-label">桌号：</label>
				<div class="col-sm-5">
				  <input type="text" class="form-control" id="table_id" placeholder="" value="<?php echo $detail->table_id?>">
				</div>
			  </div>
			  <div class="form-group">
				<label for="order_time" class="col-sm-2 control-label">下单时间 ：</label>
				<div class="col-sm-5">
				<input type="text" class="form-control" id="order_time" placeholder="" value="<?php echo $detail->order_time?>">
				</div>
			  </div>
			  <div class="form-group">
				<label for="order_user" class="col-sm-2 control-label">点菜员：</label>
				<div class="col-sm-5">
				<input type="text" class="form-control" id="order_user" placeholder="" value="<?php echo $detail->order_user?>">
				</div>
			  </div>
			  <div class="form-group">
				<label class="col-sm-2 control-label">点菜列表</label>
				<div class="col-sm-7">
					<table class="table table-bordered table-condensed">
					<tr><th>菜名</th><th>定制项</th><th>数量</th></tr>
			
					</table>
				</div>
			  </div>
			  <div class="form-group">
				<label for="discount" class="col-sm-2 control-label">折扣：</label>
				<div class="col-sm-5">
				<input type="text" class="form-control" id="discount" placeholder="" value="<?php echo $detail->discount?>">
				</div>
			  </div>
			  <div class="form-group">
				<label for="pay_type" class="col-sm-2 control-label">支付类型：</label>
				<div class="col-sm-5">
					<select class="form-control col-sm-2" id="pay_type">
						<?php foreach ($pay_type as $id=>$name): ?>
						<option value="<?php echo $id?>"><?php echo $name?></option> 
						<?php endforeach; ?>
					</select>
				</div>
			  </div>
			  <div class="form-group">
				<label for="pay_amount" class="col-sm-2 control-label">支付金额：</label>
				<div class="col-sm-5">
				<input type="text" class="form-control" id="pay_amount" placeholder="" value="<?php echo $detail->pay_amount?>">
				</div>
			  </div>
			  <div class="form-group">
				<label for="remark" class="col-sm-2 control-label">备注：</label>
				<div class="col-sm-5">
				<input type="text" class="form-control" id="remark" placeholder="" value="<?php echo $detail->remark?>">
				</div>
			  </div>
			  <div class="form-group">
				<label for="status" class="col-sm-2 control-label">状态：</label>
				<div class="col-sm-5">
					<select class="form-control" id="status">
						<?php foreach ($status_list as $id=>$name): ?>
						<option value="<?php echo $id?>"><?php echo $name?></option> 
						<?php endforeach; ?>
					</select>
				</div>
			  </div>
			  <div class="form-group">
				<div class="col-sm-offset-2 col-sm-7">
				  <button id="submit" class="btn btn-primary">编辑</button>
				  <button id="back" class="btn btn-warning">返回</button>
				</div>
			  </div>
			</div>
		</div>
	</div>
</div>
<script>
$(function(){
	$('#src_type').val('<?php echo $detail->src?>');
	$('#pay_type').val('<?php echo $detail->pay_type?>');
	$('#status').val('<?php echo $detail->status?>');
	$('#back').click(function(){
		history.go(-1);
	});
	$('#submit').click(function(){
		//console.log(custom_list);	
		$.post('set', {
			id:<?php echo $detail->id?>,
			src:$('#src').val(),
			table_id:$('#table_id').val(),
			order_time:$('#order_time').val(),
			order_user:$('#order_user').val(),
			remark:$('#remark').val(),
			amount:$('#amount').val(),
			discount:$('#discount').val(),
			pay_type:$('#pay_type').val(),
			pay_amount:$('#pay_amount').val(),
			status:$('#status').val()
		}, function(data){
			if (data._ret == 0) {
				alert('编辑成功');
				location.href = 'index';
			} else {
				alert("编辑失败，原因："+data._log);
			}
		});
	});
});
</script>
<?php $this->load->view ( 'common/footer' )?> 
