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
          <input type="date" value="<?=date('Y-m-d')?>" id="startTime" class="form-control" />
        </div>

        <div class="input-group" style="margin:8px 0;">
          <input type="date" value="<?=date('Y-m-d')?>" id="endTime" class="form-control" />
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">结束日期</button>
          </span>
        </div>
		<button type="button" class="btn btn-primary btn-block" id="submit_btn" >提交</button>
	</div>
	
</div>
<script src="<?php echo $_cdn_host?>/resource/js/admin.js"></script>

<script type="text/javascript">
	$('#submit_btn').click(function(){
		var startTime = $('#startTime').val();
		var endTime = $('#endTime').val();
		Report.dateReport(startTime,endTime);
	});



</script>
<?php $this->load->view ( 'common/footer' )?> 
