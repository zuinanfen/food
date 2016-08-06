<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/h5_top', array (
	'title' => '我要点餐' ,
	'funcname'=> 'menu'
));
?>

<table class="table table-condensed" style="padding-bottom:30px;">
	<thead>
		<!--<tr class="success">
			<th>
				<select id="order_src">
						<?php foreach ($src_type as $id=>$name): ?>
						<option value="<?php echo $id?>"><?php echo $name?></option> 
						<?php endforeach; ?>
				</select>
			</th>
			<th colspan="4" nowrap=nowrap>
				<div id="order_table_seat" rel="order_table" class="show">
					桌号：<input rel="table_id" size="3">
					人数：<input rel="seat_num" max-length=3 size="3">
				</div>
				<div id="order_table_takeout" rel="order_table" class="hide">
					用户：<input rel="table_id" type="number" placeholder="手机号或者联系方式">
					<input rel="seat_num" value="0" type="hidden">
				</div>
			</th>
		</tr>-->
		<tr>
			<th colspan="3">菜名</th>
			<th nowrap=nowrap>单价</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($list as $obj): ?>
	<tr class="warning" id="dish_<?php echo $obj->id ?>">
		<td colspan="3"><strong class="dishName"><?php echo $obj->name?></strong></td>
		<td class="dishPrice"><?php echo $obj->price?></td>
		<td style="position:relative">
			<button type="button"  class="btn btn-s btn-success add_dish" val="<?php echo $obj->id ?>">添加</button>
		</td>
	</tr>
	<?php endforeach ?>
	</tbody>
</table>
<div class="marketing">
	<div id="dish_num"><img src="<?php echo $_cdn_host?>/resource/images/buy.png" /> <span><span> </div>
	<div style="display:inline-block;width:68%">
		<button type="button" class="btn btn-warning btn-block" id="checkOrder">下订单</button>
	</div>
</div>
<footer class="footer">
	<p></p>
</footer>
<script>

$(document).ready(function(){
	Dish.init();
	$('.add_dish').click(function(){
		var id = $(this).attr('val');
		Dish.add(id);
	});
	$('#checkOrder').click(function(){
		var dishNum = $('#dish_num').find('span').text();
		if(parseInt(dishNum)<1){
			alert('您还未选择菜品！');
		}else{
			window.location.href = 'cart';
		}
	});
});


</script>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
