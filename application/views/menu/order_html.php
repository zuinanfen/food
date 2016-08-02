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
	<li><a href="index">点菜</a></li>
	<!-- <li class="active"><a href="cart">当前订单</a></li> -->
	<li class="active"><a href="#">订单列表</a></li>
  </ul>
</nav>
</div>
<table class="table table-condensed table-striped">
	<thead>
		<tr>
			<th>来源</th>
			<th>菜品数</th>
			<th>结算价</th>
			<th>下单时间</th>
			<th>操作</th>
		</tr>
	<tr>
	</thead>
	<tbody id="dishList">
	
	</tbody>
	<tfoot>
		
	</tfoot>
</table>
<footer class="footer"></footer>
<script id="dishListHtml" type="text/html">
	<%if(list.length<1){%>
		<tr>
			<td colspan="5" align="center"><b>还未点菜</b></td>
		</tr>
	<%}else{%>
		<%for(i=0;i<list.length;i++){var data=list[i]%>
		<tr id="<%=data.id%>">
			<td><%=data.sourceName%><%if(data.src==1){%>(<%=data.table_id%>)<%}%></td>
			<td><%=data.dish_num%></td>
			<td><%=data.amount%></td>
			<td><%=data.orderTime%></td>
			<td>
				<a href="order_show?orderId=<%=data.id%>"><button type="button"  class="btn btn-sm btn-success">查看</button></a>
			</td>
		</tr>
		
		<%}%>
	<%}%>
</script>

<script type="text/javascript">
	$(function(){
		Order.init();
	});
</script>
<?php $this->load->view ( 'common/h5_bottom' ); ?>