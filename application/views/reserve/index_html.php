<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/admin_top', array (
	'title' => '预定列表' ,
	'funcname'=> 'reserve',
));
?>
<div class="main" style="margin-bottom:10px">
	<div>
		<div class="input-group" style="margin:8px 0;">
	      <span class="input-group-addon">订单状态</span>
	      <select id="status" class="form-control">
	      	<option value="all" <?if($status==='all'){?> selected<?}?>>全部</option>
	      	<?foreach($reserveStatus as $k=>$v){?>
	      	<option value="<?=$k?>" <?if($status===$k){?> selected<?}?>><?=$v?></option>
	      	<?}?>
	      </select>
	    </div>
		<div class="input-group">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">开始日期</button>
          </span>
          <input type="date" value="<?=date('Y-m-d',strtotime($startTime))?>" id="startTime" class="form-control" />
        </div>

        <div class="input-group" style="margin:8px 0;">
          <input type="date" value="<?=date('Y-m-d',strtotime($endTime))?>" id="endTime" class="form-control" />
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">结束日期</button>
          </span>
        </div>
		<button type="button" class="btn btn-primary btn-block" id="submit_btn" >查询</button>
    <!-- <button type="button" class="btn btn-info btn-block" id="down_btn" >导出excel</button> -->
	</div>
	
</div>



<?foreach($list as $k=>$v){?>
<div class="bs-example" data-id="<?=$v['id']?>">
    <table class="table ">
      <thead>
        <tr>
          <th><?=$v['name']?></th>
          <th><?=$v['ctime']?></th>
          <th style="color:<?=$v['reserveStatusColor']?>"><?=$v['reserveStatusName']?></th>

        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="3">地址：<?=$v['addr']?></td>
        </tr>
        <tr>
          <td colspan="3">描述：<?=$v['desc']?></td>
        </tr>
        <tr>
          <td colspan="3">发货：<?=$v['sendtime']?></td>
        </tr>
      </tbody>
    </table>
</div>
<?}?>
 <div id="pagination"></div>
<script src="<?php echo $_cdn_host?>/resource/js/admin.js?v=<?=$sysData['version']?>"></script>

<script type="text/javascript">
  var paramString = 'startTime=<?=$startTime?>&endTime=<?=$endTime?>&status=<?=$status?>&page=';
	$('#submit_btn').click(function(){
		var startTime = $('#startTime').val();
		var endTime = $('#endTime').val();
    	var status = $('#status').val();
		window.location.href = '/index.php/reserve/index?startTime='+startTime+'&endTime='+endTime+'&status='+status;
	});
  $('.bs-example').click(function(){
    var id = $(this).data('id');
    window.location.href='/index.php/reserve/show?id='+id;
  });
  $('#down_btn').click(function(){
    window.open('/index.php/reserve/download?'+paramString);
  });
  $(function() {
      Page.init({
          items: <?=$allNum?>,
          itemsOnPage:<?=$sysData['perPage']?>,
          currentPage:<?=$page?>,
          hrefTextPrefix:'/index.php/reserve/index?'+paramString
      });
  });


</script>
<?php $this->load->view ( 'common/footer' )?> 
