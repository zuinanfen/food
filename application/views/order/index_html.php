<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/header', array (
	'title' => '订单管理' ,
	'funcname'=> 'order'
));
?>
	<div id="body">
	<div class="col-sm-3">
	  <div class="list-group">
		<a href="index" class="list-group-item active">订单列表</a>
		<a href="view" class="list-group-item">订单详情</a>
	  </div>
	</div>
	<div class="col-sm-9 table-responsive">
		<table class="table table-striped table-condensed text-center">
			<thead>
				<tr>
					<th>ID</th>
					<th>菜品名称</th>
					<th>价格</th>
					<th>排序</th>
					<th>定制项</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($list as $obj): ?>
				<tr>
					<td><?php echo $obj->id ?></td>
					<td><?php echo $obj->name ?></td>
					<td><?php echo $obj->price ?></td>
					<td><?php echo $obj->sort ?></td>
					<td><?php echo $obj->custom ?></td>
					<td class="<?php if($obj->status==0): ?>success<?php else:?>danger<?php endif?>"><?php echo $status_list[$obj->status]?></td>
					<td>
						<a href="edit?id=<?php echo $obj->id?>"><button type="button" class="btn btn-xs btn-primary">编辑</button></a>
						<?php if($obj->status!=0): ?><button type="button" class="btn btn-xs btn-success" rel="status_on" val="<?php echo $obj->id?>">上架</button></a><?php endif ?>
						<?php if($obj->status==0): ?><button type="button" class="btn btn-xs btn-danger" rel="status_off" val="<?php echo $obj->id?>">下架</button></a><?php endif ?>
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
				alert("修改成功");
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
