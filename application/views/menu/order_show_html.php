<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/h5_top', array (
	'title' => '订单详情' ,
	'funcname'=> 'menu'
));
?>
<div class="header clearfix">
<nav>
   <ul class="nav nav-pills pull-right">
	<li><a href="index">点菜</a></li>
	<li><a href="order">订单列表</a></li>
  </ul>
</nav>
</div>

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
	// Cart.init();
});

</script>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
