<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/header', array (
	'title' => '菜单编辑' ,
	'funcname'=> 'dish'
));
?>
	<div id="body">
	<div class="col-sm-3">
	  <div class="list-group">
		<a href="index" class="list-group-item">菜单列表</a>
		<a href="add" class="list-group-item">添加菜单</a>
		<a href="#" class="list-group-item active">菜单编辑</a>
	  </div>
	</div>
	<div class="col-sm-9">
		<div class="panel panel-default">
			<div class="panel-body">
<div class="form-horizontal">
  <div class="form-group">
	<label for="name" class="col-sm-2 control-label">菜品名称：</label>
	<div class="col-sm-7">
	<input type="text" class="form-control" id="name" placeholder="例如：牛肉粉" value="<?php echo $detail->name ?>">
	</div>
  </div>
  <div class="form-group">
	<label for="password1" class="col-sm-2 control-label">单价：</label>
	<div class="col-sm-5">
	  <input type="text" class="form-control" id="price" placeholder="例如：10.0" value="<?php echo $detail->price?>">
	</div>
	<label class="col-sm-2 control-label">元</label>
  </div>
  <div class="form-group">
	<label for="password1" class="col-sm-2 control-label">排序：</label>
	<div class="col-sm-5">
	<input type="text" class="form-control" id="sort" placeholder="数值越大越靠前" value="<?php echo $detail->sort?>">
	</div>
  </div>
  <?php foreach ($detail->custom as $name=>$val): ?>
  <div class="form-group">
  <label for="role" class="col-sm-2 control-label"><?php echo $name?>：</label>
	<div class="col-sm-7">
	<input type="text" class="form-control" rel="custom" val="<?php echo $name?>" value="<?php echo $val?>">
	</div>
  </div>
  <?php endforeach?>
  <div class="form-group">
	<label for="role" class="col-sm-2 control-label">状态：</label>
	<div class="col-sm-7">
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
	</div>
<script>
$(function(){
	$('#status').val('<?php echo $detail->status?>');
	$('#back').click(function(){
		history.go(-1);
	});
	$('#submit').click(function(){
		var custom_list = {};
		$('input[rel="custom"]').each(function(){
			custom_list[$(this).attr('val')] = $(this).val();
		});
		//console.log(custom_list);	
		$.post('set', {
			id:<?php echo $detail->id?>,
			name:$('#name').val(),
			price:$('#price').val(),
			sort:$('#sort').val(),
			custom:JSON.stringify(custom_list),
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
