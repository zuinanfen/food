<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/admin_top', array (
	'title' => '报销列表' ,
	'funcname'=> 'invoice',
));
?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" style="margin-bottom:10px">
	<div>
		<div class="input-group" style="margin:8px 0;">
	      <span class="input-group-addon">报销状态</span>
	      <select id="status" class="form-control">
	      	<option value="all" <?if($status==='all'){?> selected<?}?>>全部</option>
	      	<?foreach($invoiceStatus as $k=>$v){?>
	      	<option value="<?=$k?>" <?if($status===$k){?> selected<?}?>><?=$v?></option>
	      	<?}?>
	      </select>
	    </div>
      <div class="input-group" style="margin:8px 0;">
        <span class="input-group-addon">报销类型</span>
        <select id="type" class="form-control">
          <option value="0">全部</option>
          <?foreach($invoiceType as $k=>$v){?>
          <option value="<?=$k?>" <?if($type==$k){?> selected<?}?>><?=$v?></option>
          <?}?>
        </select>
      </div>
      <div class="input-group" style="margin:8px 0;">
        <span class="input-group-addon">提单用户</span>
        <select id="user_id" class="form-control">
          <option value="0" >全部</option>
          <?foreach($user_list as $k=>$v){?>
          <option value="<?=$k?>" <?if($user_id===$k){?> selected<?}?>><?=$v?></option>
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
		<button type="button" class="btn btn-primary btn-block" id="submit_btn" >提交</button>
	</div>
	
</div>



<?foreach($list as $k=>$v){?>
<div class="bs-example" data-id="<?=$v['id']?>">
    <table class="table ">
      <thead>
        <tr>
          <th><?=$v['invoiceTypeName']?></th>
          <th style="color:<?=$v['invoiceStatusColor']?>"><?=$v['invoiceStatusName']?></th>
          <th><?=$v['username']?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>金额：<?=$v['amount']?></td>
          <td colspan="2"><?=$v['ctime']?></td>
        </tr>
        <tr>
          <td colspan="3">事由：<?=$v['title']?></td>
        </tr>
      </tbody>
    </table>
</div>
<?}?>
<!-- <div><a href="/index.php/invoice/download" target="_blank">下载</a></div>-->
 <div id="pagination"></div>
<script src="<?php echo $_cdn_host?>/resource/js/admin.js"></script>

<script type="text/javascript">
	$('#submit_btn').click(function(){
		var startTime = $('#startTime').val();
		var endTime = $('#endTime').val();
		var type = $('#type').val();
    var status = $('#status').val();
    var user_id = $('#user_id').val();
		window.location.href = '/index.php/invoice/listall?startTime='+startTime+'&endTime='+endTime+'&type='+type+'&status='+status+'&user_id='+user_id;
	});
  $('.bs-example').click(function(){
    var id = $(this).data('id');
    window.location.href='/index.php/invoice/show?id='+id;
  });
  $(function() {
      var paramString = 'startTime=<?=$startTime?>&endTime=<?=$endTime?>&type=<?=$type?>&status=<?=$status?>&user_id=<?=$user_id?>&page=';
      
      Page.init({
          items: <?=$allNum?>,
          itemsOnPage:<?=$sysData['perPage']?>,
          currentPage:<?=$page?>,
          hrefTextPrefix:'/index.php/invoice/listall?'+paramString
      });
  });


</script>
<?php $this->load->view ( 'common/footer' )?> 
