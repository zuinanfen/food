<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['secretKey']  = 'zuinanfen!@#$123' ; //站点通用秘钥

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
$config['autoUpdateDishNum'] = 3;

//用戶角色
$config['roleType']  = array(
	0 => '未分配',
	1 => '系统管理员',

	2 => '厨师',
	3 => '点餐员',
	4 => '上菜员',



);
//用戶狀態
$config['roleStatus'] = array(
	0 => '正常',
	1 => '冻结',
);


//用户权限表, 白名单方法，若controller未定义，则拦截，若action未定义，则放行，定义的则白名单，
$config['privilegeList'] = array(
	1   => array(  //系统管理员
			'dish'         => array(),
			'dishoption'   => array(),
			'logon'        => array(),
			'menu'         => array(),
			'option'       => array(),
			'order'        => array(),
			'user'         => array(),
			'report'       => array(),
		),
	2   => array(  //厨师
			'logon'        => array(),
			'menu'         => array(),
			'dishoption'   => array(),
			'order'        => array('add','delDish','cancelOrder','doneDish'),
		
		),
	3   => array( //点餐员
			'logon'        => array(),
			'menu'         => array(),
			'dishoption'   => array(),
			'order'        => array('add','delDish','cancelOrder','doneDish'),


		),
	4   => array( //上菜
			'logon'        => array(),
			'menu'         => array(),
			'dishoption'   => array(),
			'order'        => array('add','delDish','cancelOrder','doneDish'),
		),
);