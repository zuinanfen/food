<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/header', array (
	'title' => '用户管理' ,
	'funcname'=> 'user'
));
?>
	<div id="body">
	<div class="col-sm-3">
	  <div class="list-group">
		<a href="index" class="list-group-item active">用户列表</a>
		<a href="add" class="list-group-item">添加用户</a>
		<a href="#" class="list-group-item disabled">用户编辑</a>
	  </div>
	</div>
	<div class="col-sm-9 table-responsive">
		<table class="table table-striped table-condensed">
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
					<td><?php echo isset($role_list[$obj->role_id])? $role_list[$obj->role_id]->name : '未分配'?></td>
					<td>
						<?php if($obj->status==1): ?><button type="button" class="btn btn-xs btn-danger" rel="status_on" val="<?php echo $obj->id?>">未激活</button></a><?php endif ?>
						<?php if($obj->status==0): ?><button type="button" class="btn btn-xs btn-success" rel="status_off" val="<?php echo $obj->id?>">已激活</button></a><?php endif ?>
					</td>
					<td>
						<a href="edit?id=<?php echo $obj->id?>"><button type="button" class="btn btn-xs btn-primary">编辑</button></a>
					</td>
				</tr>
			<?php endforeach ?>
			</tbody>
			<tfoot>
			</tfoot>
		</table>
	</div>
	</div>
<script>
$(function(){
	var set_status = function(id, status){
		$.post('set', {id:id, status:status}, function(data){
			if (data._ret == 0) {
				location.reload();
			} else {
				alert("修改失败，原因："+data._log);
			}
		});
	};

	$("button[rel='status_on']").click(function(){set_status($(this).attr('val'), 0)});
	$("button[rel='status_off']").click(function(){set_status($(this).attr('val'), 1)});
});
</script>
<?php $this->load->view ( 'common/footer' )?> 
