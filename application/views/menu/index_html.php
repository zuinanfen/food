<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/h5_top', array (
	'title' => '我要点餐' ,
	'funcname'=> 'menu'
));
?>

<table class="table table-condensed" style="padding-bottom:30px;">
	<thead>
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
	<div id="dish_num"><img src="<?php echo $_cdn_host?>/resource/images/buy.png" /> <span></span></div>
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
			//判断是点菜还是加菜
			var orderId = Data.get('orderId','string');
			if(orderId==null || orderId==''){
				window.location.href = 'cart';
			}else{
				Data.del('orderId');
				window.location.href = 'add_dish?orderId='+orderId;
			}

		}
	});
});


</script>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
