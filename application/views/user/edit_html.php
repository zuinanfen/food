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
		<div class="panel panel-default">
			<div class="panel-heading">
			<h3 class="panel-title">用户ID: <?php echo $detail->id?></h3>
			</div>
			<div class="panel-body">
				<div class="col-md-6">
				  <table class="table">
					<thead>
					  <tr>
						<td>姓名:</td>
						<td><?php echo $detail->name ?></td>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<th>角色:</th>
						<td><?php echo $detail->role_id ?></td>
					  </tr>
					  <tr>
						<th>状态:</th>
						<td><?php echo $detail->status ?></td>
					  </tr>
					</tbody>
				  </table>
				</div>
			</div>
	  </div>
	</div>
</div>
<?php $this->load->view ( 'common/footer' )?> 
