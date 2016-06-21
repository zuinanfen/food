<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/header', array (
	'title' => '菜单编辑' ,
	'funcname'=> 'dish'
));
?>
<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li class="active"><a href="index">菜单列表</a></li>
		<li><a href="add">添加菜单</a></li>
		<li><a href="../option/index">定制项管理</a></li>
		<li><a href="../option/add">添加定制项</a></li>
	</ul>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div class="panel panel-default">
		<div class="panel-heading">
		<h3 class="panel-title">菜单ID: <?php echo $detail->id?></h3>
		</div>
		<div class="panel-body">
			<div class="form-horizontal">
			  <div class="form-group">
				<label for="name" class="col-sm-2 control-label">菜品名称：</label>
				<div class="col-sm-5">
				<input type="text" class="form-control" id="name" value="<?php echo $detail->name ?>">
				</div>
			  </div>
			  <div class="form-group">
				<label for="price" class="col-sm-2 control-label">单价：</label>
				<div class="col-sm-3">
				  <input type="text" class="form-control" id="price" value="<?php echo $detail->price?>">
				</div>
				<label class="col-sm-1 control-label">元</label>
			  </div>
			  <div class="form-group">
				<label for="sort" class="col-sm-2 control-label">排序：</label>
				<div class="col-sm-3">
				<input type="text" class="form-control" id="sort" value="<?php echo $detail->sort?>">
				</div>
			  </div>
			  <div class="form-group">
				<label class="col-sm-2 control-label">可用定制项：</label>
				<div class="col-sm-7">
					<div class="row">
						<?php foreach ($option_list as $i=>$obj): if($i>0&&$i%4==0)echo'</div><div class="row">';?>
						<label class="col-sm-3"><?php echo $obj->name?>：
							<input type="checkbox"  name="option" value="<?php echo $obj->id?>">
						</label>
						<?php endforeach?>
					</div>
				</div>
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
	var option = <?php echo $detail->option?>;
	$('#status').val('<?php echo $detail->status?>');
	$('input[name="option"]').each(function(){
		if(option.indexOf($(this).val()) >= 0) {
			$(this).attr('checked', true);
		}
	});
	$('#back').click(function(){
		history.go(-1);
	});
	$('#submit').click(function(){
		var option_list = [];
		$('input[name="option"]:checked').each(function(){
			option_list.push($(this).val());
		});
		$.post('set', {
			id:<?php echo $detail->id?>,
			name:$('#name').val(),
			price:$('#price').val(),
			sort:$('#sort').val(),
			option:JSON.stringify(option_list),
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
