<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/header', array (
	'title' => '定制项编辑' ,
	'funcname'=> 'dish'
));
?>
<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li><a href="../dish/index">菜单管理</a></li>
		<li><a href="../dish/add">添加菜单</a></li>
		<li class="active"><a href="index">定制项管理</a></li>
		<li><a href="add">添加定制项</a></li>
	</ul>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div class="panel panel-default">
		<div class="panel-heading">
		<h3 class="panel-title">定制项ID: <?php echo $detail->id?></h3>
		</div>
		<div class="panel-body">
			<div class="form-horizontal">
			  <div class="form-group">
				<label for="name" class="col-sm-2 control-label">名称：</label>
				<div class="col-sm-5">
				<input type="text" class="form-control" id="name" value="<?php echo $detail->name ?>">
				</div>
			  </div>
			  <div class="form-group">
				<label for="price" class="col-sm-2 control-label">价格：</label>
				<div class="col-sm-1">
					<select class="form-control" id="symble">
						<option value="1">+</option>
						<option value="-1">-</option>
					</select>
				</div>
				<div class="col-sm-2">
				  <input type="text" class="form-control" id="price" value="<?php echo abs($detail->price)?>">
				</div>
				<label class="col-sm-2 control-label">元</label>
			  </div>
			  <div class="form-group">
				<label for="status" class="col-sm-2 control-label">状态：</label>
				<div class="col-sm-3">
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
	$('#status').val('<?php echo $detail->status?>');
	$('#symble').val('<?php echo $detail->price?>'.charAt(0)=='-'?-1:1);
	$('#back').click(function(){
		history.go(-1);
	});
	$('#submit').click(function(){
		$.post('set', {
			id:<?php echo $detail->id?>,
			name:$('#name').val(),
			price:$('#price').val()*$('#symble').val(),
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
