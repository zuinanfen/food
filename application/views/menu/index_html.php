<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/h5_top', array (
	'title' => '我要点餐' ,
	'funcname'=> 'menu'
));
?>
<div class="header clearfix">
<nav>
  <ul class="nav nav-pills pull-right">
	<li role="presentation" class="active"><a href="index">我要点餐</a></li>
	<li role="presentation"><a href="cart">我的餐盘</a></li>
	<li role="presentation"><a href="#">关于醉南粉</a></li>
  </ul>
</nav>
</div>
<table class="table table-condensed">
	<thead>
		<tr class="success">
			<th>桌号：</th><td><input id="order_table_id" size="10"></td><th>人数：</th><td><input id="order_seat_num" max-length=3 size="3"></td>
		</tr>
	<tr>
		<th colspan="2">菜名</th>
		<th nowrap=nowrap>单价（元）</th>
		<th>数量</th>
	  </tr>
	</thead>
	<tbody>
	<?php foreach($list as $obj): ?>
	<tr class="warning" rel="dish_list" val="<?php echo$obj->id ?>">
		<td colspan="2"><strong rel="name"><?php echo $obj->name?></strong></td>
		<td nowrap=nowrap rel="price" val="<?php echo $obj->price ?>"><?php echo $obj->price?></td>
		<td nowrap=nowrap>
				<span class="glyphicon glyphicon-minus"></span>
				<input rel="num" size="1" maxlength="3" value="0">
				<span class="glyphicon glyphicon-plus"></span>
		</td>
	</tr>
	<?php if($obj->option):$option = json_decode($obj->option, TRUE); ?>
	<tr>
		<td colspan="4">
			<div>
			<?php foreach ($option as $i=>$id): if($i>0&&$i%4==0)echo'</div><div>'; ?>
			<label><small><?php echo $option_list[$id]->name?></small>
				<input type="checkbox" name="option" value="<?php echo $option_list[$id]->id?>" price="<?php echo $option_list[$id]->price?>">
			</label>
			<?php endforeach?>
			</div>
		</td>
	</tr>
	<?php endif?>
	<?php endforeach ?>
	</tbody>
</table>
<div class="marketing">
	<button id="submit" type="button" class="btn btn-warning btn-block">保存至我的餐盘</button>
</div>
<footer class="footer">
	<p>&copy; 2016 醉南粉餐饮有限管理公司.</p>
</footer>
<script>
var update_dish_price = function() {
	$('tr[rel="dish_list"]').each(function(){
		var self = $(this);
		var price = self.find('td[rel=price]').attr('val') * 1;
		self.next().find('input[name="option"]:checked').each(function(){
			price += ($(this).attr('price')*1);
		});
		if (price<0)price = 0;
		self.find('td[rel=price]').html(Math.round(price*100)/100);
	});
};

$(function(){
	var order_table_id = '';
	var order_seat_num = 0;
	var order_dish = {};
	if ($.fn.cookie('order_table_id')) {
		$('#order_table_id').val($.fn.cookie('order_table_id'));
	}
	if ($.fn.cookie('order_seat_num')) {
		$('#order_seat_num').val($.fn.cookie('order_seat_num'));
	}
	if ($.fn.cookie('order_dish')) {
		order_dish = JSON.parse($.fn.cookie('order_dish'));
		$.each(order_dish, function(id,obj){
			console.log(obj);
			if (obj.num <= 0) {
				return;
			}
			var tr = $('tr[rel="dish_list"][val="'+id+'"]');
			tr.find('input[rel=num]').val(obj.num);
			if (obj.option.length > 0) {
				tr.next().find('input[name="option"]').filter(function(){return obj.option.indexOf($(this).val())>=0}).attr('checked', true);
			}
		});
		update_dish_price();
	}

	$('input[name="option"]').click(function(){
		update_dish_price();
	});

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
		$.fn.cookie('order_table_id', $('#order_table_id').val());
		$.fn.cookie('order_seat_num', $('#order_seat_num').val());
		$('tr[rel=dish_list]').each(function(){
			var self = $(this);
			var id = self.attr('val');
			order_dish[id] = {
				id:id,
				num:$(this).find('input[rel=num]').val(),
				price:$(this).find('td[rel=price]').html(),
				option:function(){
					var dish_option = [];
					self.next().find('input[name="option"]:checked').each(function(){
						dish_option.push($(this).val())
					});
					return dish_option;
				}()
			};
			if(order_dish[id].num<=0) {
				delete order_dish[id];
			}
		});
		//console.log(order_dish);
		$.fn.cookie('order_dish', JSON.stringify(order_dish));
		location.href = 'cart';
	});
});
</script>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
