<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/header', array (
	'title' => '定制项管理' ,
	'funcname'=> 'option'
));
?>
<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li><a href="../dish/index">菜单管理</a></li>
		<li><a href="../dish/add">添加菜单</a></li>
		<li class="active"><a href="index">定制项管理</a></li>
		<li><a href="add">添加定制项</a></li>
	</ul>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>ID</th>
				<th>定制项名称</th>
				<th>价格（元）</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($list as $obj): ?>
			<tr>
				<td><?php echo $obj->id ?></td>
				<td><?php echo $obj->name ?></td>
				<td><?php echo ($obj->price>=0?'+ ':'- ') . abs($obj->price) ?></td>
				<td>
					<?php if($obj->status!=0): ?><button type="button" class="btn btn-xs btn-danger" rel="status_on" val="<?php echo $obj->id?>">禁用</button></a><?php endif ?>
					<?php if($obj->status==0): ?><button type="button" class="btn btn-xs btn-success" rel="status_off" val="<?php echo $obj->id?>">正常</button></a><?php endif ?>
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
