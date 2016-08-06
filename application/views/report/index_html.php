<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/header', array (
	'title' => '数据报表' ,
	'funcname'=> 'report'
));
?>
<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li class="active"><a href="index">每日统计</a></li>
		<!-- <li><a href="add">添加用户</a></li> -->
	</ul>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div>
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
<table class="table table-striped">
      <thead>
        <tr>
          <th>日期</th>
          <th>等待</th>
          <th>处理中</th>
          <th>完成</th>
          <th>撤销</th>
          <th>总数</th>
          <th>应收款</th>
        </tr>
      </thead>
      <tbody>
      <?foreach($list as $k=>$v){?>
        <tr>
          <td><?=$k?></td>
          <td><?=$v['waitNum']?></td>
          <td><?=$v['doNum']?></td>
          <td><?=$v['doneNum']?></td>
          <td><?=$v['cancelNum']?></td>
          <td><?=$v['orderNum']?></td>
          <td><?=$v['amountNum']?></td>
        </tr>
        <?}?>
      </tbody>
    </table>
<script src="<?php echo $_cdn_host?>/resource/js/admin.js"></script>

<script type="text/javascript">
	$('#submit_btn').click(function(){
		var startTime = $('#startTime').val();
		var endTime = $('#endTime').val();
		window.location.href = '/index.php/report/index?startTime='+startTime+'&endTime='+endTime;
		// Report.dateReport(startTime,endTime);
	});



</script>
<?php $this->load->view ( 'common/footer' )?> 
