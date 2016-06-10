<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/header', array (
	'title' => '用户编辑' ,
	'funcname'=> 'welcome/message'
));
?>
	<div id="body">
	<div class="col-sm-3">
	  <div class="list-group">
		<a href="index" class="list-group-item">用户列表</a>
		<a href="add" class="list-group-item active">添加用户</a>
		<a href="#" class="list-group-item disabled">用户编辑</a>
	  </div>
	</div>
	<div class="col-sm-9">
		<div class="panel panel-default">
			<div class="panel-body">
<div class="form-horizontal">
  <div class="form-group">
	<label for="name" class="col-sm-2 control-label">姓名：</label>
	<div class="col-sm-7">
	  <input type="text" class="form-control" id="name" placeholder="例如：张三">
	</div>
  </div>
  <div class="form-group">
	<label for="password1" class="col-sm-2 control-label">密码：</label>
	<div class="col-sm-7">
	  <input type="password" class="form-control" id="password1" placeholder="暂时不填">
	</div>
  </div>
  <div class="form-group">
	<label for="role" class="col-sm-2 control-label">角色：</label>
	<div class="col-sm-7">
		<select class="form-control" id="role_id">
			<option value="0">未分配</option> 
			<?php foreach ($role_list as $obj ): ?>
			<option value="<?php echo $obj->id?>"><?php echo $obj->name?></option> 
			<?php endforeach; ?>
		</select>
	</div>
  </div>
  <div class="form-group">
	<div class="col-sm-offset-2 col-sm-7">
	  <button id="submit" class="btn btn-primary">添加</button>
	</div>
  </div>
</div>
			</div>
		</div>
	</div>
	</div>
<script>
$(function(){
	$('#submit').click(function(){
		$.post('insert', {
			name:$('#name').val(),
			password:$('#password1').val(),
			role_id:$('#role_id').val(),
			status:1
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
