<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>申请会员卡--醉南粉</title>
		<link rel="stylesheet" href="<?= $_cdn_host?>/resource/css/bootstrap.min.css" type="text/css" />
  </head>
  <body>
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

	  	<div class="input-group" style="margin-top:8px">
	      <span class="input-group-addon">昵称</span>
	  		<input type="text" id="name" class="form-control" placeholder="输入收货姓名">
		</div>
		<div class="input-group" style="margin-top:8px" >
	      <span class="input-group-addon">手机号码</span>
	      <input type="text" id="phone" class="form-control" placeholder="输入收货人手机号码">
	    </div>
	    <img src="/index.php/card/showcode" />
		<button type="button" class="btn btn-warning btn-block" style="margin-top:8px" id="add_btn">提交</button>
	</div>

</body>
</html>