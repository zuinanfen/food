<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/header', array (
	'title' => '用户编辑' ,
	'funcname'=> 'user'
));
?>
<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li class="active"><a href="index">用户列表</a></li>
		<li><a href="add">添加用户</a></li>
	</ul>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div class="panel panel-default">
		<div class="panel-heading">
		<h3 class="panel-title">用户ID: <?php echo $detail->id?></h3>
		</div>
		<div class="panel-body">
			<div class="form-horizontal">
			<div class="form-group">
				<label for="uid" class="col-sm-2 control-label">账号：</label>
				<div class="col-sm-5">
				  <input type="text" class="form-control" id="uid" value="<?php echo $detail->uid ?>">
				</div>
			  </div>
			  <div class="form-group">
				<label for="name" class="col-sm-2 control-label">姓名：</label>
				<div class="col-sm-5">
				  <input type="text" class="form-control" id="name" value="<?php echo $detail->name ?>">
				</div>
			  </div>
			  <!-- <div class="form-group">
				<label for="password1" class="col-sm-2 control-label" value="">原始密码：</label>
				<div class="col-sm-5">
				  <input type="password" class="form-control" id="password1" placeholder="可以不填">
				</div>
			  </div> -->
			  <div class="form-group">
				<label for="password1" class="col-sm-2 control-label" value="">新密码：</label>
				<div class="col-sm-5">
				  <input type="password" class="form-control" id="password2" placeholder="可以不填">
				</div>
			  </div>
			  <div class="form-group">
				<label for="role_id" class="col-sm-2 control-label">角色：</label>
				<div class="col-sm-5">
					<select class="form-control" id="role_id">
						<?php foreach ($role_list as $id=>$name): ?>
						<option value="<?php echo $id?>"><?php echo $name?></option> 
						<?php endforeach; ?>
					</select>
				</div>
			  </div>
			  <div class="form-group">
				<div class="col-sm-offset-2 col-sm-7">
				  <button id="submit" class="btn btn-primary">保存</button>
				  <button id="back" class="btn btn-warning">返回</button>
				</div>
			  </div>
			</div>
	  </div>
	</div>
</div>
<script>
$(function(){
	$('#role_id').val('<?php echo $detail->role_id?>');
	$('#back').click(function(){
		history.go(-1);
	});
	$('#submit').click(function(){
		$.post('set', {
			id:<?php echo $detail->id?>,
			name:$('#name').val(),
			uid:$('#uid').val(),
			// password:$('#password1').val(),
			newpassword:$('#password2').val(),
			role_id:$('#role_id').val()
		}, function(data){
			if (data._ret == 0) {
				alert('更新成功');
				location.href = 'index';
			} else {
				alert("更新失败，原因："+data._log);
			}
		});
	});
});
</script>
<?php $this->load->view ( 'common/footer' )?> 
