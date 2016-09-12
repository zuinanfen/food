-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 09 月 12 日 13:41
-- 服务器版本: 5.1.39
-- PHP 版本: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- 数据库: `food`
--

-- --------------------------------------------------------

--
-- 表的结构 `t_dish`
--

CREATE TABLE IF NOT EXISTS `t_dish` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '名称',
  `price` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT '单价',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `option` varchar(256) NOT NULL DEFAULT '' COMMENT '定制菜单',
  `oper` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外键，操作人ID',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `mtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `shop_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`),
  KEY `status` (`status`),
  KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_dish_option`
--

CREATE TABLE IF NOT EXISTS `t_dish_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dish_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外键，菜单ID',
  `oper` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外键，操作人ID',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `mtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `name` varchar(32) NOT NULL COMMENT '定制项名称',
  `price` decimal(16,2) NOT NULL COMMENT '价格变动，是加还是减',
  `status` tinyint(4) NOT NULL COMMENT '定制项状态',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '定制项排序',
  `shop_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `dish` (`dish_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=90 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_income`
--

CREATE TABLE IF NOT EXISTS `t_income` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ctime` datetime NOT NULL,
  `mtime` datetime NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` varchar(32) NOT NULL,
  `type_id` int(11) NOT NULL,
  `type_name` varchar(32) NOT NULL,
  `date` date NOT NULL COMMENT '结算日期',
  `amount` decimal(16,2) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `username` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`),
  KEY `date` (`date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='收入表' AUTO_INCREMENT=171 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_invoice`
--

CREATE TABLE IF NOT EXISTS `t_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ctime` datetime NOT NULL,
  `mtime` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `desc` text NOT NULL,
  `amount` decimal(16,2) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '报销类型',
  `date` date NOT NULL COMMENT '报销发生日期',
  `files` text NOT NULL COMMENT '附件',
  `title` varchar(128) NOT NULL COMMENT '标题',
  `shop_id` int(11) NOT NULL,
  `checkTime` datetime NOT NULL COMMENT '审核通过时间',
  `doneTime` datetime NOT NULL COMMENT '报销结束时间',
  `check_user` int(11) NOT NULL COMMENT '审核用户',
  `done_user` int(11) NOT NULL COMMENT '结算用户',
  PRIMARY KEY (`id`),
  KEY `ctime` (`ctime`),
  KEY `status` (`status`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='报销表' AUTO_INCREMENT=73 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_order`
--

CREATE TABLE IF NOT EXISTS `t_order` (
  `id` varchar(32) NOT NULL,
  `src` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单来源',
  `table_id` varchar(64) NOT NULL COMMENT '桌号',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `dish_num` int(11) NOT NULL DEFAULT '0' COMMENT '点菜总数',
  `seat_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '就餐人数',
  `remark` text NOT NULL,
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT '总价',
  `discount` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT '折扣',
  `pay_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付类型',
  `pay_amount` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT '支付总额',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `mtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `uid` varchar(32) NOT NULL COMMENT '下单用户id',
  `shop_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_order_dish`
--

CREATE TABLE IF NOT EXISTS `t_order_dish` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(32) NOT NULL COMMENT '外键，订单ID',
  `dish_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外键，菜单ID',
  `uid` varchar(32) NOT NULL COMMENT '下单用户id',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `mtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `name` varchar(64) NOT NULL COMMENT '菜品名称',
  `price` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT '单价',
  `total_price` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT '包含附加选项总价',
  `select_options` text NOT NULL COMMENT '已经选中的附加选项',
  `status` tinyint(4) NOT NULL COMMENT '状态',
  `dish_key` varchar(64) NOT NULL COMMENT '外键，菜品key，为了识别同一个菜单，有相同的菜品',
  `shop_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `dish_id` (`dish_id`),
  KEY `mtime` (`mtime`),
  KEY `status` (`status`),
  KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1955 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_reserve`
--

CREATE TABLE IF NOT EXISTS `t_reserve` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ctime` datetime NOT NULL,
  `mtime` datetime NOT NULL,
  `phone` varchar(16) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `name` varchar(16) NOT NULL,
  `desc` text NOT NULL,
  `addr` text NOT NULL,
  `express` tinyint(4) NOT NULL,
  `expressNumber` varchar(32) NOT NULL,
  `amount` decimal(16,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ctime` (`ctime`),
  KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_shop`
--

CREATE TABLE IF NOT EXISTS `t_shop` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `ctime` datetime NOT NULL,
  `mtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_user`
--

CREATE TABLE IF NOT EXISTS `t_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '姓名',
  `password` varchar(64) NOT NULL DEFAULT '',
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外键，角色ID',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `oper` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外键，操作人ID',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `mtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `uid` varchar(32) NOT NULL COMMENT '登陆账号',
  `shop_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `status` (`status`),
  KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;
