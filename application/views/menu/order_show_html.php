<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/h5_top', array (
	'title' => '订单详情' ,
	'funcname'=> 'menu'
));
?>
<div class="header clearfix">
<nav>
   <ul class="nav nav-pills pull-right navi">
	<li><a href="index">点菜</a></li>
	<li><a href="order">订单列表</a></li>
  </ul>
</nav>
</div>

<h3>菜品列表</h3>
<table class="table table-condensed table-striped">
	<thead>
		<tr>
			<th>菜名</th>
			<th>单价</th>
			<th>结算价</th>
			<th style="width:55px;">状态</th>
			<th>操作</th>
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
			<td style="color:<?if($v['status']==0){?>#337ab7<?}elseif($v['status']==1){?>#ec971f<?}?>;">
			<?php echo $v['statusName'] ?></td>
			<td>
				<?if($v['status']==0){?>
					<button type="button" data-dishkey="<?=$v['dish_key']?>" data-id="<?=$v['id']?>" data-orderid="<?=$v['order_id']?>" class="btn btn-sm btn-danger del_dish">删除</button>
				<?}?>
			</td>
			
		</tr>
		<tr>
			<td colspan="5">
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
	        <td>菜品数量</td>
	        <td><b><?php echo $detail['dish_num']?></b></td>
	    </tr>
	      <tr>
	        <td>订单总金额</td>
	        <td><b><?php echo $detail['amount']?></b></td>
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
        <td><b style="color:<?if($detail['status']==0){?>#337ab7<?}elseif($detail['status']==1){?>#ec971f<?}?>;"><?php echo $detail['statusName']?></b></td>
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

<script type="text/javascript">
	$(function(){
		OrderShow.init();
	});
</script>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
