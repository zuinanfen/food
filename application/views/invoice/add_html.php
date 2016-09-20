<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/admin_top', array (
	'title' => '我要报销' ,
	'funcname'=> 'invoice',
));
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h3>添加报销</h3>
	<div class="input-group" >
      <span class="input-group-addon">报销标题</span>
      <input type="text" id="title" class="form-control" placeholder="输入报销标题">
    </div>
	 <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">费用类型</span>
      <select id="invoiceType" class="form-control">
      		<option value="0">请选择</option>
      		<?foreach($invoiceType as $k=>$v){?>
      	      	<option value="<?=$k?>"><?=$v?></option>
      	    <?}?>
      </select>
    </div>
	<div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">发生时间</span>
      <input type="date" id="date" class="form-control" value="">
    </div>
   
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">费用金额</span>
      <input type="number" id="amount" class="form-control" placeholder="输入金额">
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">费用说明</span>
      <textarea rows="4" id="desc" class="form-control" placeholder="输入报销详细说明"></textarea>
    </div>
	<button type="button" class="btn btn-warning btn-block" style="margin-top:8px" id="add_btn">提交</button>
</div>

<script src="<?php echo $_cdn_host?>/resource/js/admin.js?v=<?=$sysData['version']?>"></script>

<script type="text/javascript">
	$('#add_btn').click(function(){
		var title = $('#title').val();
		var invoiceType = $('#invoiceType').val();
		var date = $('#date').val();
		var amount = $('#amount').val();
		var desc = $('#desc').val();

		if(title==''){
			alert('请输入标题！');
			return ;
		}
		if(invoiceType==0){
			alert('请选择报销类型！');
			return ;
		}
		if(date==''){
			alert('请选择费用发生时间！');
			return;
		}
		if(desc==''){
			alert('请输入报销详细说明！');
			return;
		}

		var data = {
			title:$.trim(title),
			invoiceType: $.trim(invoiceType),
			date:date,
			amount:$.trim(amount),
			desc:$.trim(desc)
		}
		Invoice.add(data);
	});


</script>
<?php $this->load->view ( 'common/footer' )?> 



