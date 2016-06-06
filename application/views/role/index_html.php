<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/header', array (
	'title' => '角色管理' ,
	'funcname'=> 'welcome/message'
));
?>
	<div id="body">
<div class="col-sm-3">
	  <div class="list-group">
		<a href="#" class="list-group-item active">
		  Cras justo odio
		</a>
		<a href="#" class="list-group-item">Dapibus ac facilisis in</a>
		<a href="#" class="list-group-item">Morbi leo risus</a>
		<a href="#" class="list-group-item">Porta ac consectetur ac</a>
		<a href="#" class="list-group-item">Vestibulum at eros</a>
	  </div>
	</div>
	<div class="col-sm-9">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>角色名</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($list as $obj): ?>
				<tr>
					<td><?php echo $obj->id ?></td>
					<td><?php echo $obj->name ?></td>
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
