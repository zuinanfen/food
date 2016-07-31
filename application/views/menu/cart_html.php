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
	<li  class="active"><a href="index">点菜</a></li>
	<!-- <li class="active"><a href="cart">当前订单</a></li> -->
	<li><a href="#">订单列表</a></li>
  </ul>
</nav>
</div>
<table class="table table-condensed">
	<thead>
		<tr class="success">
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
					<!-- 人数：<input rel="seat_num" max-length=3 size="3"> -->
				</div>
				
			</th>
		</tr>
	<tr>
	</thead>
	<tbody>
	</tbody>
</table>
<table class="table table-condensed table-striped">
	<thead>
		<tr>
			<th colspan="3">菜名</th>
			<th >结算价</th>
			<th>操作</th>
		</tr>
	<tr>
	</thead>
	<tbody id="dishList">
	
	</tbody>
	<tfoot>
		
	</tfoot>
</table>
<div class="marketing clearfix">
	<div class="pull-right">
		<button id="submit" type="button" class="btn btn-warning btn-lg">下单</button>
		<a href="index" ><button id="back" type="button" class="btn btn-default btn-lg">返回</button></a>
	</div>
</div>
<footer class="footer">
</footer>
<script id="dishListHtml" type="text/html">
	<%if(list.length<1){%>
		<tr>
			<td colspan="5" align="center"><b>还未点菜</b></td>
		</tr>
	<%}else{%>
		<%for(i=0;i<list.length;i++){var data=list[i]%>
		<tr id="<%=data.id%>" class="<%=data.id%>" data-dishid="<%=data.dishId%>">
			<td colspan="3" class="dishName"><strong><%=data.name%></strong></td>
			<td class="newPrice"><b><%=data.newPrice%><b></td>
			<td style="position:relative">
				<button type="button"  class="btn btn-sm btn-success edit_dish" val="">修改</button>
				<button type="button"  class="btn btn-sm btn-danger del_dish">删除</button>
			</td>
		</tr>
		<tr class="<%=data.id%>">
			<td colspan="5">
			<%for(j=0;j<data.options.length;j++){%>
				&nbsp;<%=data.options[j].name%>
				<%if(data.options[j].price!=0){%>
				(<%=data.options[j].price%>)
				<%}%>
				&nbsp;
			<%}%>
			</td>
		</tr>
		<%}%>
	<%}%>
</script>
<script>
$(document).ready(function(){
	Cart.init();
});
/*$(function(){
	var order_dish = {};
	var amount = 0;
	if ($.fn.cookie('order_src')) {
		$('#order_src').val($.fn.cookie('order_src'));
	}
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
			amount += tr.attr('price') * obj.num;
		});
		$('#amount').html(amount);
	} else {
		alert('餐盘为空，请先点餐')
		location.href = 'index';
		return;
	}

	$('#back').click(function(){
		history.go(-1);
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
		var dish_num = 0;
		$('tr[rel=dish_list]').each(function(){
			var self = $(this);
			var id = self.attr('val');
			var num = self.find('input[rel=num]').val();
			if(num<=0) {
				delete order_dish[id];
			} else {
				order_dish[id] = {
					id:id,
					num:$(this).find('input[rel=num]').val(),
					option:order_dish[id].option
				};
				dish_num += num;
			}
		});
		//console.log(order_dish);
		if (dish_num <= 0) {
			alert('餐盘为空，请先点餐');
			location.href = 'index';
			return;
		}
		
		$.post('../order/insert', {
			src:$('#order_src').val(),
			table_id:$('#order_table_id').html(),
			seat_num:$('#order_seat_num').html(),
			dish_list:JSON.stringify(order_dish),
			dish_num:dish_num,
			amount:amount,
			remark:$('#remark').val()
		}, function(data){
			if (data._ret == 0) {
				$.fn.cookie('order_dish', null);
				$.fn.cookie('order_src', null);
				$.fn.cookie('order_table_id', null);
				$.fn.cookie('order_seat_num', null);
				alert('下单成功');
				location.href = 'index';
			} else {
				alert("保存失败，原因："+data._log);
			}
		})
	});
});*/
</script>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
