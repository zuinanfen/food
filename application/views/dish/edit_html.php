<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/header', array (
	'title' => '菜单编辑' ,
	'funcname'=> 'dish'
));
?>
<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li class="active"><a href="index">菜单列表</a></li>
		<li><a href="add">添加菜单</a></li>
		<li><a href="../option/index">定制项管理</a></li>
		<li><a href="../option/add">添加定制项</a></li>
	</ul>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div class="panel panel-default">
		<div class="panel-heading">
		<h3 class="panel-title">菜单ID: <?php echo $detail->id?></h3>
		</div>
		<div class="panel-body">
			<div class="form-horizontal">
			  <div class="form-group">
				<label for="name" class="col-sm-2 control-label">菜品名称：</label>
				<div class="col-sm-5">
				<input type="text" class="form-control" id="name" value="<?php echo $detail->name ?>">
				</div>
			  </div>
			  <div class="form-group">
				<label for="price" class="col-sm-2 control-label">单价：</label>
				<div class="col-sm-3">
				  <input type="text" class="form-control" id="price" value="<?php echo $detail->price?>">
				</div>
				<label class="col-sm-1 control-label">元</label>
			  </div>
			  <div class="form-group">
				<label for="sort" class="col-sm-2 control-label">排序：</label>
				<div class="col-sm-3">
				<input type="text" class="form-control" id="sort" value="<?php echo $detail->sort?>">
				</div>
			  </div>
			  <div class="form-group">
				<label class="col-sm-2 control-label">可用定制项：</label>
				<div class="col-sm-5">
					<div class="row">
					<table class="table table-striped table-condensed">
						<thead>
						<tr>
							<th>名称</th>
							<th>价格（元）</th>
							<th>排序</th>
							<th>操作 <button type="button" data-toggle="modal" data-target="#addOptionModal" id="addOption" class="btn btn-xs btn-info">添加</button></th>
						</tr>
						</thead>
						<tbody>
						<?php foreach($option_list as $obj){?>
						<tr>
						<td><?php echo $obj['name']?></td>
						<td><?php echo ($obj['price']>=0?'+ ':'- ') . abs($obj['price']) ?></td>
						<td><?php echo $obj['sort']?></td>
						<td>
							<button onclick="editOption('<?php echo $obj['id']?>')" type="button" class="btn btn-xs btn-primary">编辑</button>
							<button onclick="delOption('<?php echo $obj['id']?>')" type="button" class="btn btn-xs btn-danger">删除</button>
						</td>
						</tr>
						<?php }?>
						</tbody>
						</table>
					</div>
				</div>
			  </div>
			  <div class="form-group">
				<label for="status" class="col-sm-2 control-label">状态：</label>
				<div class="col-sm-3">
					<select class="form-control" id="status">
						<?php foreach ($status_list as $id=>$name): ?>
						<option value="<?php echo $id?>"><?php echo $name?></option> 
						<?php endforeach; ?>
					</select>
				</div>
			  </div>
			  <div class="form-group">
				<div class="col-sm-offset-2 col-sm-7">
				  <button id="submit" class="btn btn-primary">编辑</button>
				  <button id="back" class="btn btn-warning">返回</button>
				</div>
			  </div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="addOptionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">选项配置</h4>
      </div>
      <div class="modal-body form-horizontal" >
      	<div class="form-group">
			<label for="name" class="col-sm-3 control-label">选项名称：</label>
			<div class="col-sm-5">
				<input type="text" class="form-control" id="option-name" value=""  />
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-3 control-label">价格增减：</label>
			<div class="col-sm-5">
				<input type="text" class="form-control" id="option-price" value=""  />
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-3 control-label">排序：</label>
			<div class="col-sm-5">
				<input type="text" class="form-control" id="option-sort" value=""  />
			</div>
		</div>
		<input type="hidden" id="option-id" value=""  />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" id="addOption-save">保存</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<script>
$(function(){
	var dishId = '<?php echo $dish_id?>';
	var option = <?php echo $detail->option?>;
	$('#status').val('<?php echo $detail->status?>');
	$('input[name="option"]').each(function(){
		if(option.indexOf($(this).val()) >= 0) {
			$(this).attr('checked', true);
		}
	});
	$('#back').click(function(){
		history.go(-1);
	});
	$('#submit').click(function(){
		var option_list = [];
		$('input[name="option"]:checked').each(function(){
			option_list.push($(this).val());
		});
		$.post('set', {
			id:<?php echo $detail->id?>,
			name:$('#name').val(),
			price:$('#price').val(),
			sort:$('#sort').val(),
			option:JSON.stringify(option_list),
			status:$('#status').val()
		}, function(data){
			if (data._ret == 0) {
				alert('编辑成功');
				location.href = 'index';
			} else {
				alert("编辑失败，原因："+data._log);
			}
		});
	});
	$('#addOptionModal').on('shown.bs.modal', function () {
	 	
	});
	$('#addOption-save').click(function(){
		var optionData = {
			name:$('#option-name').val(),
			price:$('#option-price').val(),
			sort:$('#option-sort').val()
		}
		var optionId = $('#option-id').val();
		if(optionId.length>0){ //假如id不为空，则编辑
			optionData.optionId = optionId;
			optionId.status = 'edit';
		}else{
			optionData.status = 'del';
		}
		$.post('/dishoption/edit', optionData, function(data){
			if (data._ret == 0) {
				alert('操作成功');
				window.location.reload();
			} else {
				alert("操作失败！"+data._log);
			}
		});


	});
});
function editOption(optionId){
	$.post('/dishoption/getDetail', {
			optionId: optionId
		}, function(data){
			if (data._ret == 0) {
				var detail = data.detail;
				$('#option-name').val(detail.name);
				$('#option-price').val(detail.price);
				$('#option-sort').val(detail.sort);
				$('#option-id').val(detail.id);
			} else {
				alert("系统异常，请联系管理员！");
			}
		});
	$('#addOptionModal').modal('show',function () {
	 	alert(11);
	});
}
</script>
<?php $this->load->view ( 'common/footer' )?> 
