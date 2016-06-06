<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title><?php echo $title?></title>
	<link rel="stylesheet" href="<?php echo $_cdn_host?>/resource/css/bootstrap.min.css" type="text/css" />
</head>
<body>
<div id="container" class="container-fluid">
		<nav class="navbar navbar-inverse">
		<div class="container">
		  <div class="navbar-header">
			<a class="navbar-brand" href="#">角色管理</a>
		  </div>
		  <div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
			  <li class="active"><a href="#">所有角色</a></li>
			  <li><a href="#about">添加</a></li>
			</ul>
		  </div>
		</div>
      </nav>
