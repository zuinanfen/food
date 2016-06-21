<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/h5_top', array (
	'title' => '我的餐盘' ,
	'funcname'=> 'menu'
));
?>
<div class="header clearfix">
<nav>
  <ul class="nav nav-pills pull-right">
	<li role="presentation"><a href="index">我要点餐</a></li>
	<li role="presentation" class="active"><a href="cart">我的餐盘</a></li>
	<li role="presentation"><a href="#">关于醉南粉</a></li>
  </ul>
</nav>
</div>
<table class="table table-condensed">
	<thead>
		<tr class="success">
			<th>桌号：</th><th id="order_table_id"></th><th>人数：</th><th id="order_seat_num"></th>
		</tr>
	<tr>
	</thead>
	<tbody>
	<?php foreach($cart_list as $id=>$obj): if(isset($dish_list[$id])): ?>
	<tr class="warning" rel="dish_list" val="<?php echo $id ?>">
		<td colspan="3"><strong rel="name"><?php echo $dish_list[$id]->name?></strong>
			<?php if($obj->option): ?>
			（<?php foreach ($obj->option as $i=>$id): if($i>0&&$i%4==0)echo'</div><div>'; ?>
				<small><?php echo $option_list[$id]->name?></small>
			<?php endforeach?>）
			<?php endif?>
		</td>
		<td nowrap=nowrap>
				<span class="glyphicon glyphicon-minus"></span>
				<input rel="num" size="1" maxlength="3" value="0">
				<span class="glyphicon glyphicon-plus"></span>
		</td>
	</tr>
	<?php endif;endforeach ?>
	</tbody>
	<tfoot>
		<tr><td colspan="4" class="h5 text-right">
			总金额：<span id="amount">0</span> 元
		</td></tr>
	</tfoot>
</table>
<div class="marketing clearfix">
	<div class="pull-right">
		<button id="submit" type="button" class="btn btn-warning btn-lg">下单</button>
		<button id="submit" type="button" class="btn btn-default btn-lg">返回</button>
	</div>
</div>
<footer class="footer">
	<p>&copy; 2016 醉南粉餐饮有限管理公司.</p>
</footer>
<script>
$(function(){
	var order_dish = {};
	var amount = 0;
	var dish_list = <?php echo json_encode($dish_list) ?>;
	if ($.fn.cookie('order_table_id')) {
		$('#order_table_id').html($.fn.cookie('order_table_id'));
	}
	if ($.fn.cookie('order_seat_num')) {
		$('#order_seat_num').html($.fn.cookie('order_seat_num'));
	}
	if ($.fn.cookie('order_dish')) {
		order_dish = JSON.parse($.fn.cookie('order_dish'));
		$.each(order_dish, function(id,obj){
			//console.log(obj)
			if (obj.num <= 0) {
				return;
			}
			var tr = $('tr[rel="dish_list"][val="'+id+'"]');
			tr.find('input[rel=num]').val(obj.num);
			amount += dish_list[id].price * obj.num;
		});
		$('#amount').html(amount);
	}

	$('.glyphicon-plus').click(function(){
		var num = $(this).prev().val();
		if (num<99) {
			$(this).prev().val(parseInt(num)+1);
		}
	});
	$('.glyphicon-minus').click(function(){
		var num = $(this).next().val();
		if (num>0) {
			$(this).next().val(parseInt(num)-1);
		}
	});

	$('#submit').click(function(){
		var amount = 0;
		$('tr[rel=dish_list]').each(function(){
			var self = $(this);
			var id = self.attr('val');
			amount += $(this).find('input[rel=num]').val();
			order_dish[id] = {
				id:id,
				num:$(this).find('input[rel=num]').val(),
			};
			if(order_dish[id].num<=0) {
				delete order_dish[id];
			}
		});
		//console.log(order_dish);
		alert("下单成功");
		location.href = 'cart';
		/*
		$.post('add', {
			src:0,
			table_id:0,
			seat_num:0,
			dish_list:order_dish,
			dish_num:amount,
			remark:''
		}, function(data){
			if (data._ret == 0) {
				alert('保存成功');
				location.href = 'index';
			} else {
				alert("保存失败，原因："+data._log);
			}
		})*/
	});
});
</script>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
