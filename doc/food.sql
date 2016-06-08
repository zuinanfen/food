CREATE DATABASE food;
use food;
set names utf8;

/*用户*/
CREATE TABLE t_user
(
	id int unsigned not null auto_increment,
	name varchar(64) not null default '' COMMENT '姓名',
	role_id int unsigned not null default 0 COMMENT '外键，角色ID',
	status tinyint not null default 0 COMMENT '状态',
	oper int unsigned not null default 0 COMMENT '外键，操作人ID',
	ctime datetime not null default 0 COMMENT '创建时间',
	mtime datetime not null default 0 COMMENT '修改时间',
	PRIMARY KEY (id),
	KEY role_id (role_id),
	KEY status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*角色*/
CREATE TABLE t_role
(
	id int unsigned not null auto_increment,
	type tinyint not null default 0 COMMENT '类型',
	name varchar(64) not null default '' COMMENT '名称',
	status tinyint not null default 0 COMMENT '状态',
	oper int unsigned not null default 0 COMMENT '外键，操作人ID',
	ctime datetime not null default 0 COMMENT '创建时间',
	mtime datetime not null default 0 COMMENT '修改时间',
	PRIMARY KEY(id),
	INDEX type(type),
	INDEX status(status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*菜单*/
CREATE TABLE t_dish
(
	id int unsigned not null auto_increment,
	type tinyint not null default 0 COMMENT '类型',
	name varchar(64) not null default '' COMMENT '名称',
	price decimal(16,2) not null default 0.00 COMMENT '单价',
	sort int unsigned not null default 0 COMMENT '排序',
	status tinyint not null default 0 COMMENT '状态',
	oper int unsigned not null default 0 COMMENT '外键，操作人ID',
	ctime datetime not null default 0 COMMENT '创建时间',
	mtime datetime not null default 0 COMMENT '修改时间',
	PRIMARY KEY(id),
	INDEX sort(sort),
	INDEX status(status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*订单信息*/
CREATE TABLE t_order_info
(
	id int unsigned not null auto_increment,
	type tinyint not null default 0 COMMENT '类型',
	src tinyint not null default 0 COMMENT '订单来源',
	table_id varchar(64) not null default '' COMMENT '桌号',
	order_time datetime not null default 0 COMMENT '下单时间',
	order_user int unsigned default 0 COMMENT '外键，下单人ID',
	status tinyint not null default 0 COMMENT '状态',
	dish_list varchar(1024) not null default '' COMMENT '点菜列表，json',
	dish_num int not null default 0 COMMENT '点菜总数',
	remark varchar(1024) not null default '' COMMENT '下单备注',
	amount decimal(16,2) not null default 0.00 COMMENT '总价',
	discount decimal(16,2) not null default 0.00 COMMENT '折扣',
	pay_type tinyint not null default 0 COMMENT '支付类型',
	pay_amount decimal(16,2) not null default 0.00 COMMENT '支付总额',
	oper int unsigned not null default 0 COMMENT '外键，操作人ID',
	ctime datetime not null default 0 COMMENT '创建时间',
	mtime datetime not null default 0 COMMENT '修改时间',
	PRIMARY KEY(id),
	INDEX type(type),
	INDEX status(status),
	INDEX order_user(order_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
