<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/h5_top', array (
	'title' => '订单列表' ,
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
		<?foreach($list as $k=>$v){?>
		<tr id="<?=$v['id']?>">
			<td><?=$v['sourceName']?><?if($v['src']==1){?>(<?=$v['table_id']?>号)<?}?></td>
			<td><?=$v['dish_num']?></td>
			<td><?=$v['orderTime']?></td>
			<td style="color:<?=$orderStatusColor[$v['status']]?>;"><?=$v['statusName']?></td>
			
			<td>
				<a href="order_show?orderId=<?=$v['id']?>"><button type="button"  class="btn btn-sm btn-success">查看</button></a>
			</td>
		</tr>
		
		<?}?>
	</tbody>
	<tfoot>
		
	</tfoot>
</table>
<footer class="footer"></footer>
 <div id="pagination"></div>

<script src="<?php echo $_cdn_host?>/resource/js/admin.js"></script>
<script type="text/javascript">
	var paramString = '?page=';

	$(function(){
		//Order.init();
		Page.init({
			items: <?=$allNum?>,
			itemsOnPage:<?=$sysData['perPage']?>,
			currentPage:<?=$page?>,
			hrefTextPrefix:'/index.php/menu/order'+paramString
		});
	});
	
</script>
<?php $this->load->view ( 'common/h5_bottom' ); ?>
