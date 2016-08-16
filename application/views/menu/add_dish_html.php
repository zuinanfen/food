<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/h5_top', array (
	'title' => '添加菜品' ,
	'funcname'=> 'menu'
));
?>
<h3>新增菜品</h3>
<table class="table table-condensed table-striped">
	<thead>
		<tr>
			<th>菜名</th>
			<th>结算价</th>
		</tr>
	<tr>
	</thead>
	<tbody id="dishList">

	</tbody>
	<tfoot>
		
	</tfoot>
</table>

<div style="width:99%;text-align:center">
	<button type="button" data-orderid="<?=$detail['id']?>" id="cancel_add" class="btn btn-default" style="display:inline-block;width:48%">放弃</button>
	<button type="button" data-orderid="<?=$detail['id']?>" id="add_dish_submit" class="btn btn-warning" style="display:inline-block;width:48%">确定加菜</button>
</div>

<h3>原有菜品列表</h3>
<table class="table table-condensed table-striped">
	<thead>
		<tr>
			<th>菜名</th>
			<th>单价</th>
			<th>结算价</th>
			<th style="width:55px;">状态</th>
		</tr>
	<tr>
	</thead>
	<tbody id="dishList">
	<?if(count($dishList)>0){?>
		<? foreach($dishList as $k=>$v){?>
		<tr>
			<td><strong><?php echo $v['name']?></strong></td>
			<td><?php echo $v['price']?></td>
			<td><b><?php echo $v['total_price'] ?><b></td>
			<td style="color:<?=$dishStatusColor[$v['status']]?>;">
			<?php echo $v['statusName'] ?></td>
			
			
		</tr>
		<tr>
			<td colspan="4">
			<?php foreach ($v['select_options'] as $key => $value) {?>
				<?php echo $value['name']?>
				<?php if($value['price']!=0){?>
					(<?php echo $value['price']?>)
				<?php }?>
				&nbsp;
			<?php }?>
			
			</td>

		</tr>
		<? }?>
	<?}?>
	</tbody>
	<tfoot>
		
	</tfoot>
</table>
<hr>
<h3>订单信息</h3>
<table class="table table-striped" style="border:1px solid #ccc">
  
    <tbody>
	    <tr>
	        <td>订单号</td>
	        <td><b><?php echo $detail['id']?></b></td>
	      </tr>
	       <tr>
	        <td>订单总金额</td>
	        <td><b><?php echo $detail['amount']?></b></td>
	      </tr>
      
    	<tr>
	        <td>菜品数量</td>
	        <td><b><?php echo $detail['dish_num']?></b></td>
	    </tr>
	     
      <tr>
        <td>订单来源</td>
        <td><b><?php echo $detail['sourceName']?></b></td>
    </tr>
    <?if($detail['src']==1){?>
	    <tr>
	        <td>台号</td>
	        <td><b><?php echo $detail['table_id']?></b></td>
	    </tr>
	<?}?>
      <tr>
        <td>订单状态</td>
        <td><b style="color:<?=$orderStatusColor[$detail['status']]?>;"><?=$detail['statusName']?></b></td>
      </tr>
      <tr>
        <td>下单用户</td>
        <td><b><?php echo $detail['username']?></b></td>
      </tr>
      <tr>
        <td>下单时间</td>
        <td><b><?php echo $detail['ctime']?></b></td>
      </tr>
      <tr>
        <td>订单更新时间</td>
        <td><b><?php echo $detail['mtime']?></b></td>
      </tr>
    </tbody>
  </table>

<script id="dishListHtml" type="text/html">
	<%if(list.length<1){%>
		<tr>
			<td colspan="2" align="center"><b>还未点菜</b></td>
		</tr>
	<%}else{%>
		<%for(i=0;i<list.length;i++){var data=list[i]%>
		<tr id="<%=data.id%>" class="<%=data.id%>" data-dishid="<%=data.dishId%>">
			<td class="dishName"><strong><%=data.name%></strong></td>
			<td class="totalPrice"><b><%=data.totalPrice%><b></td>
		
		</tr>
		<tr class="<%=data.id%>">
			<td colspan="2">
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

<script type="text/javascript">
	$(function(){
		OrderShow.addDishInit();
	});
</script>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
