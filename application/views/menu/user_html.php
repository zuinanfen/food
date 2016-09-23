<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view ( 'common/admin_top', array (
	'title' => '醉南粉点餐系统' ,
	'funcname'=> 'menu'
));
?>
<h3 style="text-align:center;margin:25px 0;">修改密码</h3>
<div class="bs-glyphicons">
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div class="input-group" >
      <span class="input-group-addon">登录账号</span>
      <input type="text" disabled=""  class="form-control" value="<?=$info['uid']?>" />
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">用户姓名</span>
      <input type="text" disabled=""  class="form-control" value="<?=$info['name']?>" />
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">用户权限</span>
      <input type="text" disabled=""  class="form-control" value="<?=$roleType[$info['role_id']]?>" />
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">老密码</span>
      <input type="password" id="oldPwd" class="form-control" placeholder="输入老密码" />
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">新密码</span>
      <input type="password" id="newPwd" class="form-control" placeholder="输入新密码"/>
    </div>
    <div class="input-group" style="margin-top:8px">
      <span class="input-group-addon">新密码</span>
      <input type="password" id="checkPwd" class="form-control"  placeholder="再输入新密码" />
    </div>

	<button type="button" class="btn btn-info btn-block" style="margin-top:8px" id="submit_btn">修改密码</button>
	<a href="/index.php/logon/logout"><button type="button" class="btn btn-danger btn-block" style="margin-top:8px">退出登录</button></a>
</div>
  </div>
<h6 class="text-center" style="bottom:0;position:absolute;width:100%">
<script>
	$('#submit_btn').click(function(){
		var oldPwd = $.trim($('#oldPwd').val());
		var newPwd = $.trim($('#newPwd').val());
		var checkPwd = $.trim($('#checkPwd').val());
		if(oldPwd.length<1){
			alert('老密码不能为空！');
			return false;
		}
		if(newPwd.length<1){
			alert('新密码不能为空！');
			return false;
		}
		if(checkPwd != newPwd){
			alert('两次输入新密码不一致！');
			return false;
		$.post('/index.php/menu/edit_user', {
			oldPwd: oldPwd,
			newPwd: newPwd
		}, function(data){
			if (data._ret == 0) {
				alert('修改密码成功，请重新登录！');
				location.href = '/index.php/logon/logout';
			} else {
				alert("修改失败，原因："+data._log);
			}
		});
	});
</script>

<?php $this->load->view ( 'common/h5_bottom' ); ?>