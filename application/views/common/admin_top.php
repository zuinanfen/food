<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title><?= $title?></title>
	<?php
		$this->load->view ( 'common/css_js');
	?>
	
</head>
<body>
<div class="container-fluid">
<div class="row">



<div class="header clearfix">
<div style="float:left;margin-top:10px">
	<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
	<a href="/index.php/menu/logon">首页</a>
	<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
	<a href="/index.php/menu/user"><?=$sysData['username']?></a>
</div>


<?if($sysData['action']=='logon'){?>
<div style="float:right;margin-top:5px;"><span class="glyphicon glyphicon-check" aria-hidden="true"></span>
	<?=$sysData['role_type']?></div>
<?}?>

<?if($funcname=='income'){?>
<nav>
  <ul class="nav nav-pills pull-right navi">
	<li <?if($sysData['action']=='index'){?>class="active"<?}?>><a href="index">账目报表</a></li>
  </ul>
</nav>
<?}?>
<?if($funcname=='invoice'){?>
<nav>
  <ul class="nav nav-pills pull-right navi">
	<li <?if($sysData['action']=='index'){?>class="active"<?}?>><a href="index">我的报销</a></li>
	<?if($sysData['role_id']==1 || $sysData['role_id']==100|| $sysData['role_id']==90){?>
		<li <?if($sysData['action']=='listall'){?>class="active"<?}?>><a href="listall">报销列表</a></li>
	<?}?>
  </ul>
</nav>
<?}?>

<?if($funcname=='reserve'){?>
<nav>
  <ul class="nav nav-pills pull-right navi">
	<li <?if($sysData['action']=='index'){?>class="active"<?}?>><a href="index">预定列表</a></li>
	<li <?if($sysData['action']=='add'){?>class="active"<?}?>><a href="add">添加订单</a></li>
  </ul>
</nav>
<?}?>
<?if($funcname=='discount'){?>
<nav>
  <ul class="nav nav-pills pull-right navi">
	<?if($sysData['role_id']==100){?><li <?if($sysData['action']=='index'){?>class="active"<?}?>><a href="index">创建卡券</a></li><?}?>
	<li <?if($sysData['action']=='listall'){?>class="active"<?}?>><a href="listall">卡券列表</a></li>
  </ul>
</nav>
<?}?>


</div>