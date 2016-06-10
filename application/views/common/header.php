<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title><?php echo $title?></title>
	<link rel="stylesheet" href="<?php echo $_cdn_host?>/resource/css/bootstrap.min.css" type="text/css" />
	<script src="<?php echo $_cdn_host?>/resource/js/jquery-2.2.4.min.js"></script>
	<script src="<?php echo $_cdn_host?>/resource/js/bootstrap.min.js"></script>
</head>
<body>
<div id="container" class="container-fluid">
		<nav class="navbar navbar-inverse">
		<div class="container">
		  <div class="navbar-header">
			<a class="navbar-brand" href="#">醉南粉</a>
		  </div>
		  <div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
			<li <?php if($funcname=='user'):?>class="active"<?php endif?>><a href="../user/index">用户</a></li>
			<li <?php if($funcname=='dish'):?>class="active"<?php endif?>><a href="../dish/index">菜单</a></li>
			<li <?php if($funcname=='order'):?>class="active"<?php endif?>><a href="#">订单</a></li>
			<li <?php if($funcname=='config'):?>class="active"<?php endif?>><a href="#">配置</a></li>
			<li <?php if($funcname=='stat'):?>class="active"<?php endif?>><a href="#">报表</a></li>
			</ul>
		  </div>
		</div>
      </nav>
