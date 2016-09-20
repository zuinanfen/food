<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/admin_top', array (
	'title' => '收入记账' ,
	'funcname'=> 'income',
));
?>

<table class="table table-striped">
  <thead>
    <tr>
      <th>结算日期</th>
      <th>收款方式</th>
      <th>收款金额</th>
      <th>记账人</th>
    </tr>
  </thead>
  <tbody>
  <?if(!empty($list)){?>
    <?foreach($list as $k=>$v){?>
    <tr>
      <td><?=$v['date']?></td>
      <td><?=$v['type_name']?></td>
      <td><?=$v['amount']?></td>
      <td><?=$v['username']?></td>
    </tr>
    <?}?>
  <?}?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="4" style="text-align:right;font-weight:bold">总计：<?=$totalNum?></td>
    </tr>
  </tfoot>
</table>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h3>添加条目</h3>
	<div class="input-group">
      <span class="input-group-addon">结算日期</span>
      <input type="date" id="date" class="form-control" disabled="" value="<?=$date?>" />
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">收款方式</span>
      <select id="incomeType" class="form-control">
      	<?foreach($incomeType as $k=>$v){?>
      	<option value="<?=$k?>"><?=$v?></option>
      	<?}?>
      </select>
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">收款金额</span>
      <input type="number" id="amount" class="form-control" placeholder="收款金额" />
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">记账人员</span>
      <input type="text" id="username" disabled="" class="form-control" value="<?=$sysData['username']?>"/>
    </div>
	<button type="button" class="btn btn-warning btn-block" style="margin-top:8px" id="add_btn">录入</button>
</div>



<script src="<?php echo $_cdn_host?>/resource/js/admin.js?v=<?=$sysData['version']?>"></script>

<script type="text/javascript">
	$('#add_btn').click(function(){
		  if(confirm('确认金额和日期无误，要提交该笔记录？')){
        var data = {
          date: $('#date').val(),
          incomeType: $('#incomeType').val(),
          amount: $('#amount').val(),
          incomeType_name: $('#incomeType').find('option:selected').text()


        }
        Income.add(data);
      }
	});
</script>
<?php $this->load->view ( 'common/h5_bottom' )?> 
