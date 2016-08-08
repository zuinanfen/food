<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/h5_top', array (
	'title' => '我的餐盘' ,
	'funcname'=> 'menu'
));
?>
<table class="table table-condensed table-striped">
	<thead>
		<tr>
			<th>来源</th>
			<th>菜品数</th>
			<th>下单时间</th>
			<th>状态</th>
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
			<td><%=data.sourceName%><%if(data.src==1){%>(<%=data.table_id%>号)<%}%></td>
			<td><%=data.dish_num%></td>
			<td><%=data.orderTime%></td>
			<td style="color:<%if(data.status==0){%>#337ab7<%}else if(data.status==1){%>#ec971f<%}%>;"><%=data.statusName%></td>
			
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
