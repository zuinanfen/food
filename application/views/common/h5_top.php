<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title><?php echo $title?></title>
	<link rel="stylesheet" href="<?php echo $_cdn_host?>/resource/css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $_cdn_host?>/resource/css/narrow.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $_cdn_host?>/resource/js/artDialog/skins/twitter.css" type="text/css" />
	<!--<script src="<?php echo $_cdn_host?>/resource/js/zepto.min.js"></script>
	<script src="<?php echo $_cdn_host?>/resource/js/zepto.cookie.min.js"></script>-->
	<script src="<?php echo $_cdn_host?>/resource/js/jquery-2.2.4.min.js"></script>
	<script src="<?php echo $_cdn_host?>/resource/js/artDialog/jquery.artDialog.min.js?skin=twitter"></script>
	<script src="<?php echo $_cdn_host?>/resource/js/template-native.js"></script>
	<script src="<?php echo $_cdn_host?>/resource/js/dish.js"></script>
	
</head>
<body>
<div class="container-fluid">
<div class="row">



<div class="header clearfix">
<div style="float:left;margin-top:10px">
	<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
	<?=$sysData['username']?> <a href="/index.php/logon/logout">退出</a>
</div>
<nav>
  <ul class="nav nav-pills pull-right navi">
	<li <?if($sysData['controller']=='menu' && in_array($sysData['action'],array('index','cart'))){?>class="active"<?}?>><a href="index">点菜</a></li>
	<li <?if($sysData['controller']=='menu' && $sysData['action']=='order'){?>class="active"<?}?>><a href="order">订单列表</a></li>
  </ul>
</nav>
</div>