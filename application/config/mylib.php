<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['secretKey']  = 'zuinanfen!@#$123' ; //站点通用秘钥
//自动标注几个菜为制作中
$config['autoUpdateDishNum'] = 3;
//登录有效时间
$config['logonTime'] = 60*60*24*10; //10天有效
//每页多少条数据
$config['perPage'] = 20;
//订单状态
$config['orderStatus']	= array(  
		0 => '待处理',
		1 => '处理中',
		2 => '菜上齐',
		3 => '已付款',


		8 => '已撤销'
);

//订单状态颜色
$config['orderStatusColor']	= array(  
		0 => '#337ab7',
		1 => '#449d44',
		2 => '#000000',
		3 => '#dff0d8',


		8 => '#d44950'
);

//单个菜品状态
$config['dishStatus'] = array(
		0 => '待处理',
		1 => '处理中',
		2 => '已上菜',
		3 => '已付款',

		8 => '已撤销'
);

//菜品状态颜色
$config['dishStatusColor']	= array(  
		0 => '#337ab7',
		1 => '#449d44',
		2 => '#000000',
		3 => '#dff0d8',


		8 => '#d44950'
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



//用戶角色
$config['roleType']  = array(
	0 => '未分配',
	1 => '店铺管理员',

	2 => '厨师',
	3 => '点餐员',
	4 => '上菜员',

	90 => '财务',
	100 => '系统管理员',



);
//用戶狀態
$config['roleStatus'] = array(
	0 => '正常',
	1 => '冻结',
);

//入账类型
$config['incomeType'] = array(
	1 => '现金',
	2 => '支付宝',
	3 => '大众优惠买单',
	4 => '大众团购券',
	5 => '美团外卖',
	6 => '百度外卖',
	7 => '饿了么外卖',
	8 => '乐惠',
	9 => '一阳指',
	10 => '百度糯米',
	100 => '银行卡',
);
//店铺名称
$config['shopList'] = array(
	1 => '醉南粉',
	2 => '醉南鸡',
);
//报销状态
$config['invoiceStatus'] = array(
	0  => '待审核',
	1  => '待结算',
	2  => '已结算',
	3  => '撤销申请',
	4  => '审核未通过'
);
//报销状态
$config['invoiceStatusColor'] = array(
	0 => '#337ab7',
	1 => '#449d44',
	2 => '#000000',
	3 => '#dff0d8',


	4 => '#d44950'
);
//报销类型
$config['invoiceType'] = array(
	1  => '采购费',
	2  => '交通费',
	3  => '餐饮费',
	4  => '通讯费',
	5  => '住宿费',
	6  => '办证费',
	7  => '装修费',
	8  => '活动费',
	100=> '其他',
);


//用户权限表, 白名单方法，若controller未定义，则拦截，若action未定义，则放行，定义的则白名单，
$config['privilegeList'] = array(
	100   => array(  //开发者
			'dish'         => array(),
			'dishoption'   => array(),
			'logon'        => array(),
			'menu'         => array(),
			'option'       => array(),
			'order'        => array(),
			'user'         => array(),
			'report'       => array(),
			'income'       => array(),
			'invoice'       => array(),
		),
	90   => array(  //财务
			'logon'        => array(),
			'menu'         => array(),
			'report'       => array(),
			'income'       => array(),
			'invoice'      => array(),
		),
	1   => array(  //店长
			'dish'         => array(),
			'dishoption'   => array(),
			'logon'        => array(),
			'menu'         => array(),
			'option'       => array(),
			'order'        => array(),
			// 'user'         => array(),
			'report'       => array(),
			'income'       => array(),
			'invoice'       => array(),
		),
	2   => array(  //厨师
			'logon'        => array(),
			'menu'         => array(),
			'dishoption'   => array(),
			'order'        => array('add','delDish','cancelOrder','doneDish','addDish'),
		
		),
	3   => array( //点餐员
			'logon'        => array(),
			'menu'         => array(),
			'dishoption'   => array(),
			'order'        => array('add','delDish','cancelOrder','doneDish','addDish'),


		),
	4   => array( //上菜
			'logon'        => array(),
			'menu'         => array(),
			'dishoption'   => array(),
			'order'        => array('add','delDish','cancelOrder','doneDish','addDish'),
		),
);