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
	<li class="active"><a href="index">点菜</a></li>
	<!-- <li role="presentation"><a href="cart">当前订单</a></li> -->
	<li><a href="order">订单列表</a></li>
  </ul>
</nav>
</div>
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

/*var order_dish = {};
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
var get_option = function(dish_id){
	var option = [{id:1,name:'AA',price:2.34,sort:1},{id:2,name:'BB',price:-12.34,sort:9}];
	return option;
}

$('input[name="option"]').click(function(){
	update_dish_price();
	});

$('.glyphicon-plus').click(function(){
	var num = $(this).prev().val();
	if (num<99) {
		$(this).prev().val(parseInt(num)+1);
		if (num==0) {
		//显示附加项
			var dish = $(this).parent().parent();
			var option = get_option(dish.val());
			if (option.length > 0) {
				var optionStr = '<tr><td colspan="5"><div>';
				for (var i=0;i<option.length;i++) {
					var v = option[i];
					if (i>0&&i%4==0) optionStr+='</div></div>';
					optionStr+='<label><small>'+v.name+'</small>';
					optionStr+='<input type="checkbox" name="option" value="'+v.id+'" price="'+v.price+'"></label>';
				}
				optionStr+='</div></td></tr>';
				$(optionStr).insertAfter(dish);
			}
		}
	}
});
$('.glyphicon-minus').click(function(){
	var num = $(this).next().val();
	if (num>0) {
		$(this).next().val(parseInt(num)-1);
		if (num==1) {
		//隐藏附加项
		}
	}
});

$('#order_src').change(function(){
	if($(this).val()==0) {
		$("#order_table_seat").addClass("show").removeClass("hide");
		$("#order_table_takeout").addClass("hide").removeClass("show");
		$('#order_table_seat input[rel="table_id"').val('');
	} else {
		$("#order_table_seat").addClass("hide").removeClass("show");
		$("#order_table_takeout").addClass("show").removeClass("hide");
		$('#order_table_takeout input[rel="seat_num"').val(0);
	}
});

$('#submit').click(function(){
	$.fn.cookie('order_src', $('#order_src').val());
	$.fn.cookie('order_table_id', $('div.show[rel="order_table"] input[rel="table_id"').val());
	$.fn.cookie('order_seat_num', $('div.show[rel="order_table"] input[rel="seat_num"').val());
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

$(function(){
	if ($.fn.cookie('order_src')) {
		$('#order_src').val($.fn.cookie('order_src'));
	}
	if ($.fn.cookie('order_table_id')) {
		$('input[rel="table_id"]').val($.fn.cookie('order_table_id'));
	}
	if ($.fn.cookie('order_seat_num')) {
		$('input[rel="seat_num"]').val($.fn.cookie('order_seat_num'));
	}
	$('#order_src').change();

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
});*/



</script>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
