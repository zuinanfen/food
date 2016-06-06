<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/header', array (
	'title' => '用户管理' ,
	'funcname'=> 'welcome/message'
));
?>
	<div id="body">
		<nav class="navbar navbar-inverse">
		<div class="container">
		  <div class="navbar-header">
			<a class="navbar-brand" href="#">用户管理</a>
		  </div>
		  <div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
			  <li class="active"><a href="#">所有用户</a></li>
			  <li><a href="#about">添加</a></li>
			</ul>
		  </div>
		</div>
      </nav>
	<div class="col-md-12">
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
				<td><button type="button" class="btn btn-xs btn-success">编辑</button></td>
				</tr>
			<?php endforeach ?>
			</tbody>
			<tfoot>
			</tfoot>
		</table>
	</div>
	</div>
<?php $this->load->view ( 'common/footer' )?> 
