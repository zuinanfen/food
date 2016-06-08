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
		<a href="add" class="list-group-item">添加用户</a>
		<a href="#" class="list-group-item active">用户编辑</a>
	  </div>
	</div>
	<div class="col-sm-9">
		<div class="panel panel-default">
			<div class="panel-heading">
			<h3 class="panel-title">用户ID: <?php echo $detail->id?></h3>
			</div>
			<div class="panel-body">
<form class="form-horizontal">
  <div class="form-group">
	<label for="name" class="col-sm-2 control-label">姓名：</label>
	<div class="col-sm-7">
	  <input type="text" class="form-control" id="name" placeholder="张三" value="<?php echo $detail->name ?>">
	</div>
  </div>
  <div class="form-group">
	<label for="password1" class="col-sm-2 control-label" value="">密码：</label>
	<div class="col-sm-7">
	  <input type="password" class="form-control" id="password1" placeholder="可以不填">
	</div>
  </div>
  <div class="form-group">
	<label for="role" class="col-sm-2 control-label">角色：</label>
	<div class="col-sm-7">
		<select class="form-control" id="role">
			<option>未分配</option> 
			<?php foreach ($role_list as $obj ): ?>
			<option><?php echo $obj->name?></option> 
			<?php endforeach; ?>
		</select>
	</div>
  </div>
  <div class="form-group">
	<label for="status" class="col-sm-2 control-label">状态：</label>
	<div class="col-sm-7">
		<select class="form-control" id="status">
			<option>正常</option> 
			<option>冻结</option> 
		</select>
	</div>
  </div>
  <div class="form-group">
	<div class="col-sm-offset-2 col-sm-7">
	  <button type="submit" class="btn btn-default">保存</button>
	</div>
  </div>
</form>
		  </div>
		</div>
		</div>
<?php $this->load->view ( 'common/footer' )?> 
