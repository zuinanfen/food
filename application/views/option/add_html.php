<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/header', array (
	'title' => '添加定制项' ,
	'funcname'=> 'option'
));
?>
<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li><a href="../dish/index">菜单管理</a></li>
		<li><a href="../dish/add">添加菜单</a></li>
		<li><a href="index">定制项管理</a></li>
		<li class="active"><a href="add">添加定制项</a></li>
	</ul>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">新的定制项</h3>
		</div>
		<div class="panel-body">
			<div class="form-horizontal">
			  <div class="form-group">
				<label for="name" class="col-sm-2 control-label">名称：</label>
				<div class="col-sm-5">
				  <input type="text" class="form-control" id="name" placeholder="例如：加粉">
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
				  <input type="text" class="form-control" id="price" placeholder="例如：1">
				</div>
				<label class="col-sm-1 control-label">元</label>
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
				  <button id="submit" class="btn btn-primary">添加</button>
				  <button id="back" class="btn btn-warning">返回</button>
				</div>
			  </div>
		  </div>
	  </div>
	</div>
</div>
<script>
$(function(){
	$('#back').click(function(){
		history.go(-1);
	});
	$('#submit').click(function(){
		$.post('insert', {
			name:$('#name').val(),
			price:$('#price').val()*$('#symble').val(),
			status:$('#status').val()
		}, function(data){
			if (data._ret == 0) {
				alert('添加成功');
				location.href = 'index';
			} else {
				alert("添加失败，原因："+data._log);
			}
		});
	});
});
</script>
<?php $this->load->view ( 'common/footer' )?> 
