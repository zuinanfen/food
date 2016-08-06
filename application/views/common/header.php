<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title><?php echo $title?></title>
	<link rel="stylesheet" href="<?php echo $_cdn_host?>/resource/css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $_cdn_host?>/resource/css/dashboard.css" type="text/css" />
	<script src="<?php echo $_cdn_host?>/resource/js/jquery-2.2.4.min.js"></script>
	<script src="<?php echo $_cdn_host?>/resource/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
	  <div class="navbar-header">
		<a class="navbar-brand" href="#">醉南粉</a>
	  </div>
	  <div class="navbar-collapse collapse">
		<ul class="nav navbar-nav">
		<!-- <li <?php if($funcname=='index'):?>class="active"<?php endif?>><a href="#">经营状况</a></li> -->
		<li <?php if($funcname=='user'):?>class="active"<?php endif?>><a href="../user/index">用户管理</a></li>
		<li <?php if($funcname=='dish'):?>class="active"<?php endif?>><a href="../dish/index">菜单管理</a></li>
		<!-- <li <?php if($funcname=='order'):?>class="active"<?php endif?>><a href="../order/index">订单管理</a></li> -->
		<!-- <li <?php if($funcname=='config'):?>class="active"<?php endif?>><a href="#">配置</a></li> -->
		<li <?php if($funcname=='report'):?>class="active"<?php endif?>><a href="../report/index">数据报表</a></li>
		</ul>
		<a href="/index.php/logon/logout" class="glyphicon glyphicon-log-out" style="float:right;padding:15px">退出</a>
	  </div>
	</div>
</nav>
<div class="container-fluid">
<div class="row">
