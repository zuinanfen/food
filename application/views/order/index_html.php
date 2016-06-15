<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/header', array (
	'title' => '订单管理' ,
	'funcname'=> 'order'
));
?>
<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li class="active"><a href="index">订单列表</a></li>
		<li><a href="add">添加订单</a></li>
		<li class="disabled"><a href="#">订单编辑</a></li>
	</ul>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>ID</th>
				<th>来源</th>
				<th>台号</th>
				<th>下单时间</th>
				<th>点菜员</th>
				<th>菜单内容</th>
				<th>总金额</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($list as $obj): ?>
			<tr>
				<td><?php echo $obj->id ?></td>
				<td><?php echo $src_type[$obj->src] ?></td>
				<td><?php echo $obj->table_id ?></td>
				<td><?php echo $obj->order_time ?></td>
				<td><?php echo $obj->order_user ?></td>
				<td><?php echo $obj->dish_list ?></td>
				<td><?php echo $obj->amount ?></td>
				<td>
					<?php if($obj->status==0): ?><button type="button" class="btn btn-xs btn-danger" name="status" rel=0 val="<?php echo $obj->id?>">未处理</button></a><?php endif ?>
					<?php if($obj->status==1): ?><button type="button" class="btn btn-xs btn-warning" name="status" rel=1 val="<?php echo $obj->id?>">制作中</button></a><?php endif ?>
					<?php if($obj->status==2): ?><button type="button" class="btn btn-xs btn-success" name="status" rel=2 val="<?php echo $obj->id?>">已上菜</button></a><?php endif ?>
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

	$("button[name='status']").click(function(){set_status($(this).attr('val'), ()$(this).attr('rel')+1)%3)});
});
</script>
<?php $this->load->view ( 'common/footer' )?> 
