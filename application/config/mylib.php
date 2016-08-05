<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//订单状态
$config['orderStatus']	= array(  
		0 => '待处理',
		1 => '处理中',
		2 => '菜上齐',
		3 => '已付款',


		8 => '已撤销'
);

//单个菜品状态
$config['dishStatus'] = array(
		0 => '待处理',
		1 => '处理中',
		2 => '已上菜',
		3 => '已付款',

		8 => '已撤销'
);

//订单来源配置
$config['orderSource'] = array(
		1 => '堂食',
		2 => '百度外卖',
		3 => '美团外卖',
		4 => '饿了么外卖',
		5 => '打包',
);

//支付手段
$config['payType'] =  array(
		0 => '现金',
		1 => '支付宝',
		2 => '微信',
		3 => '外卖App',

		8 => '其他',
);

//自动标注几个菜为制作中
$config['autoUpdateDishNum'] = 4;