<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/admin_top', array (
	'title' => '添加预定' ,
	'funcname'=> 'reserve',
));
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h3>添加订单</h3>
	<div class="input-group" >
      <span class="input-group-addon">手机号码</span>
      <input type="text" id="phone" class="form-control" placeholder="输入收货人手机号码">
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">收货姓名</span>
      <input type="text" id="name" class="form-control" placeholder="输入收货姓名">
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">收货地址</span>
      <textarea rows="3" id="addr" class="form-control" placeholder="输入收货地址"></textarea>
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">菜品描述</span>
      <textarea rows="3" id="desc" class="form-control" placeholder="输入菜品描述"></textarea>
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">发货日期</span>
      <input type="date" id="sendtime" class="form-control" value="<?=date('Y-m-d',time())?>" placeholder="选择发货日期">
    </div>
    <!-- <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">费用金额</span>
      <input type="number" id="amount" class="form-control" placeholder="输入金额">
    </div>
	 -->
	<button type="button" class="btn btn-warning btn-block" style="margin-top:8px" id="add_btn">提交</button>
</div>

<script src="<?php echo $_cdn_host?>/resource/js/admin.js"></script>

<script type="text/javascript">
	$('#add_btn').click(function(){
		var phone = $('#phone').val();
		var name = $('#name').val();
		var addr = $('#addr').val();
		var desc = $('#desc').val();
		var amount = $('#amount').val();
		var sendtime = $('#sendtime').val();

		if(phone==''){
			alert('请输入手机号码！');
			return ;
		}
		if(name==''){
			alert('请输入收货人姓名！');
			return ;
		}
		if(desc==''){
			alert('请输入菜品详细说明！');
			return;
		}
		if(sendtime==''){
			alert('请选择发货日期！');
			return;
		}
		// if(amount==''){
		// 	alert('请输入订单金额！');
		// 	return;
		// }

		var data = {
			phone:$.trim(phone),
			name: $.trim(name),
			addr:addr,
			amount:0,
			desc:$.trim(desc),
			sendtime: sendtime
		}
		if(confirm('确定提交该预订单？')){
			Reverve.add(data);
		}
	});


</script>
<?php $this->load->view ( 'common/footer' )?> 



