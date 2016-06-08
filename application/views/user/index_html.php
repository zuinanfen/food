<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/header', array (
	'title' => '用户管理' ,
	'funcname'=> 'welcome/message'
));
?>
	<div id="body">
	<div class="col-sm-3">
	  <div class="list-group">
		<a href="index" class="list-group-item active">用户列表</a>
		<a href="add" class="list-group-item">添加用户</a>
		<a href="#" class="list-group-item">用户编辑</a>
	  </div>
	</div>
	<div class="col-sm-9">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>姓名</th>
					<th>角色ID</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($list as $obj): ?>
				<tr>
					<td><?php echo $obj->id ?></td>
					<td><?php echo $obj->name ?></td>
					<td><?php echo $obj->role_id?></td>
					<td><?php echo $obj->status ?></td>
					<td><a href="edit?id=<?php echo $obj->id ?>"><button type="button" class="btn btn-xs btn-success">编辑</button></a></td>
				</tr>
			<?php endforeach ?>
			</tbody>
			<tfoot>
			</tfoot>
		</table>
	</div>
	</div>
<?php $this->load->view ( 'common/footer' )?> 
