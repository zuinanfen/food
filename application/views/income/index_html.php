<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/admin_top', array (
	'title' => '收入记账' ,
	'funcname'=> 'income',
));
?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div>
		<div class="input-group" style="margin:8px 0;">
	      <span class="input-group-addon">收款方式</span>
	      <select id="type" class="form-control" disabled="">
	      	<option value="0">全部</option>
	      	<?foreach($incomeType as $k=>$v){?>
	      	<option value="<?=$k?>" <?if($type==$k){?> selected<?}?>><?=$v?></option>
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
<table class="table table-striped">
      <thead>
        <tr>
          <th>日期</th>
          <!-- <th>等待</th>
          <th>处理中</th> -->
          <th>完成单</th>
          <th>撤销单</th>
          <th>单面结算</th>
          <th>应收</th>
          <!-- <th>入账类型</th> -->
          <th>实收</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
      <?foreach($list as $k=>$v){?>
        <tr>
          <td><?=$k?></td>
          <!--<td><?=$v['report']['waitNum']?></td>
          <td><?=$v['report']['doNum']?></td>-->
          <td><?=$v['report']['doneNum']?></td>
          <td><?=$v['report']['cancelNum']?></td>
          <td><?=$v['report']['amountNum']?></td>
          <td <?if($v['report']['pay_amount']!=$v['report']['amountNum']){?> style="color:red"<?}?>><?=$v['report']['pay_amount']?></td>
          <!--<td><?=$typeName?></td>-->
          <td <?if($v['report']['pay_amount'] !=$v['totalNum']){?>style="color:orange"<?}?>><?=$v['totalNum']?></td>
          <td>
          <a href="show?date=<?=$k?>"><button type="button" class="btn btn-sm btn-success">看</button></a>
          </td>
        </tr>
        <?}?>
        <tr style="font-weight:bold"> 
          <td>总计</td>
          <td><?=$count['countDoneNum']?></td>
          <td><?=$count['countCancelNum']?></td>
          <td><?=$count['countAmountNum']?></td>
          <td <?if($count['countAmountNum']!=$count['countPay_amount']){?> style="color:red"<?}?>><?=$count['countPay_amount']?></td>
          <td <?if($count['countTotalNum']!=$count['countPay_amount']){?> style="color:orange"<?}?>><?=$count['countTotalNum']?></td>
          <td>
          
          </td>
          </tr>
      </tbody>
    </table>
<script src="<?php echo $_cdn_host?>/resource/js/admin.js?v=<?=$sysData['version']?>"></script>

<script type="text/javascript">
	$('#submit_btn').click(function(){
		var startTime = $('#startTime').val();
		var endTime = $('#endTime').val();
		var type = $('#type').val();
		window.location.href = '/index.php/income/index?startTime='+startTime+'&endTime='+endTime+'&type='+type;
		// Report.dateReport(startTime,endTime);
	});



</script>
<?php $this->load->view ( 'common/footer' )?> 
