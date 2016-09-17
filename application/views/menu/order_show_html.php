<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/h5_top', array (
	'title' => '订单详情' ,
	'funcname'=> 'menu'
));
?>

<h3>菜品列表</h3>
<table class="table table-condensed table-striped"  data-orderid="<?=$detail['id']?>">
	<thead>
		<tr>
			<th>菜名</th>
			<th>单价</th>
			<th>结算价</th>
			<th>实收</th>
			<th style="width:55px;">状态</th>
			<th>操作</th>
		</tr>
	<tr>
	</thead>
	<tbody id="dishList">
	<?if(count($dishList)>0){?>
		<? foreach($dishList as $k=>$v){?>
		<tr">
			<td><strong><?=$v['name']?></strong></td>
			<td><?=$v['price']?></td>
			<td><b class="total_price"><?=$v['total_price'] ?><b></td>
			<td>
				<input type="number" class="pay_amount" style="width:65px;" value="<?=$v['total_price']?>" />
				<button data-id="<?=$v['id']?>" type="button" class="btn btn-xs btn-danger change_amount">改</button>
			</td>
			<td style="color:<?=$dishStatusColor[$v['status']]?>;">
			<?=$v['statusName'] ?></td>
			<td>
				<?if($v['status']==0 || $v['status']==1){?>
					<button type="button" data-dishkey="<?=$v['dish_key']?>" data-id="<?=$v['id']?>" data-orderid="<?=$v['order_id']?>" class="btn btn-sm btn-danger del_dish">撤销</button>
				<?}?>
			</td>
			
		</tr>
		<tr>
			<td colspan="6">
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
	<?if(in_array($detail['status'],array(0,1,2))){?>
	<div class="btn-group btn-group-m" data-orderid="<?=$detail['id']?>" id="addDishBtn" style="margin:0 10%;width:80%">
        <button class="btn btn-info" style="width:100%"><span class="glyphicon glyphicon-plus"></span> 加菜</button>
    </div>
    <?}?>
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
	        <td>结算金额</td>
	        <td><?php echo $detail['amount']?></td>
	      </tr>
	     <tr>
	        <td>需支付金额</td>
	        <td><b style="color:red"><?php echo $detail['pay_amount']?></b></td>
	    </tr>
	    <tr>
	        <td>结算折扣</td>
	        <td><b><?php echo $detail['discount']?></b></td>
	    </tr>
      <tr>
        <td>订单来源</td>
        <td><?php echo $detail['sourceName']?></td>
    </tr>
    <?if($detail['src']==1){?>
	    <tr>
	        <td>台号</td>
	        <td><b><?php echo $detail['table_id']?></b></td>
	    </tr>
	<?}?>
      <tr>
        <td>订单状态</td>
        <td><b style="color:<?=$orderStatusColor[$detail['status']]?>;"><?php echo $detail['statusName']?></b></td>
      </tr>
      <tr>
        <td>下单用户</td>
        <td><?php echo $detail['username']?></td>
      </tr>
      <tr>
        <td>下单时间</td>
        <td><?php echo $detail['ctime']?></td>
      </tr>
      <tr>
        <td>订单更新时间</td>
        <td><?php echo $detail['mtime']?></td>
      </tr>
    </tbody>
  </table>
<div style="height:20px;"></div>
  <div class="marketing">
		<div style="display:inline-block;width:48%">
			<button type="button" data-id=<?=$detail['id']?> class="btn <?if($detail['status']!=8){?>btn-danger<?}?> btn-block" <?if(in_array($detail['status'],array(2,3,8))){?>disabled=""<?}?>  id="cancelOrder">
			撤销订单</button>
		</div>

		<div style="display:inline-block;width:48%">
			<button type="button" class="btn btn-warning btn-block" id="checkOrder">打印订单</button>
		</div>
	</div>

<script type="text/javascript">
	$(function(){
		OrderShow.init();
	});
</script>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
