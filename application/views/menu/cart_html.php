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
			<th colspan="4" id="order_table_seat" style="display:none" >
				<div class="show">
					桌号：<input size="3">
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
	<div id="dish_num"><img src="<?php echo $_cdn_host?>/resource/images/buy.png" /> <span><span> </div>
	<div style="display:inline-block;width:68%">
		<a href="index" ><button type="button" class="btn btn-default btn-block" style="display:inline-block;width:48%">加菜</button></a>
		<button type="button" class="btn btn-warning btn-block" style="display:inline-block;width:48%" id="checkOrder">提交并打印</button>
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
			<td class="totalPrice"><b><%=data.totalPrice%><b></td>
			<td style="position:relative">
				<button type="button"  class="btn btn-sm btn-success edit_dish" val="">附加项</button>
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

</script>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
