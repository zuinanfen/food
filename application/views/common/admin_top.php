<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title><?= $title?></title>
	<link rel="shortcut icon" href="<?= $_cdn_host?>/resource/images/favicon.ico"/>
	<link rel="stylesheet" href="<?= $_cdn_host?>/resource/css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="<?= $_cdn_host?>/resource/css/narrow.css" type="text/css" />
	<link rel="stylesheet" href="<?= $_cdn_host?>/resource/js/artDialog/skins/twitter.css" type="text/css" />
	<!--<script src="<?= $_cdn_host?>/resource/js/zepto.min.js"></script>
	<script src="<?= $_cdn_host?>/resource/js/zepto.cookie.min.js"></script>-->
	<script src="<?= $_cdn_host?>/resource/js/jquery-2.2.4.min.js"></script>
	<script src="<?= $_cdn_host?>/resource/js/artDialog/jquery.artDialog.min.js?skin=twitter"></script>
	<script src="<?= $_cdn_host?>/resource/js/template-native.js"></script>
	<script src="<?= $_cdn_host?>/resource/js/dish.js"></script>
	
</head>
<body>
<div class="container-fluid">
<div class="row">



<div class="header clearfix">
<div style="float:left;margin-top:10px">
	<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
	<a href="/index.php/menu/logon">首页</a>
	<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
	<a href="/index.php/logon/logout"><?=$sysData['username']?></a>
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
	<?if($sysData['role_id']==1 || $sysData['role_id']==100){?>
		<li <?if($sysData['action']=='listall'){?>class="active"<?}?>><a href="listall">报销列表</a></li>
	<?}?>
  </ul>
</nav>
<?}?>



</div>