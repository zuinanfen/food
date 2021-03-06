<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>醉南粉点单系统登录</title>
	<link rel="stylesheet" href="resource/css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="resource/css/signin.css" type="text/css" />
  </head>
  <body>
    <div class="container">
      <div class="form-signin">
        <h2 class="form-signin-heading">请登录</h2>
        <label for="inputEmail" class="sr-only">账号</label>
        <input id="uid" class="form-control" placeholder="请输入登陆账号/手机号" required autofocus>
        <label for="inputPassword" class="sr-only">密码</label>
        <input type="password" id="password" class="form-control" placeholder="密码" required>
        <!-- <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me" disabled=disabled> 记住用户名
          </label>
        </div> -->
        <button class="btn btn-lg btn-primary btn-block" id="submit">登录</button>
      </div>
    </div> <!-- /container -->
<script src="resource/js/jquery-2.2.4.min.js"></script>
<!-- <script src="resource/js/jquery.md5.js"></script> -->
<script>
$(function(){
	$('#submit').click(function(){
		$.post('/index.php/logon/get_user', {
			uid:$('#uid').val(),
			password:$('#password').val(),
      shop_id: '<?=$shop_id?>'
		}, function(data){
			if (data._ret == 0) {
				location.href = data.location? data.location : '';
			} else {
				alert("登录失败，原因："+data._log);
			}
		});
	});
});
</script>
	</body>
</html>
