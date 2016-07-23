-- phpMyAdmin SQL Dump
-- version 3.4.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 07 月 23 日 12:02
-- 服务器版本: 5.1.39
-- PHP 版本: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `t_dish`
--

INSERT INTO `t_dish` (`id`, `type`, `name`, `price`, `sort`, `status`, `option`, `oper`, `ctime`, `mtime`) VALUES
(1, 0, '牛肉粉', '20.01', 0, 0, '["1","2","3","6","7","8","9"]', 0, '2016-06-18 01:00:42', '2016-07-22 17:22:36'),
(2, 0, '醉南粉', '22.00', 0, 0, '["1","2","5","6"]', 0, '2016-06-18 01:03:40', '2016-06-18 01:03:40'),
(3, 0, '这是个名字很长的菜，看看会怎样', '99999.00', 9, 0, '["3","4"]', 0, '2016-06-18 16:35:08', '2016-06-18 16:35:08'),
(4, 0, '打包盒', '0.10', 0, 0, '[]', 0, '2016-06-20 18:23:20', '2016-06-20 18:23:20');

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
  PRIMARY KEY (`id`),
  KEY `dish` (`dish_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `t_dish_option`
--

INSERT INTO `t_dish_option` (`id`, `dish_id`, `oper`, `ctime`, `mtime`, `name`, `price`, `status`, `sort`) VALUES
(1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '少粉', '-12.02', 0, 1),
(2, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '多香菜', '5.01', 0, 10);

-- --------------------------------------------------------

--
-- 表的结构 `t_option`
--

CREATE TABLE IF NOT EXISTS `t_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '选项名称',
  `price` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT '加价',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `oper` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外键，操作人ID',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `mtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `t_option`
--

INSERT INTO `t_option` (`id`, `name`, `price`, `status`, `oper`, `ctime`, `mtime`) VALUES
(1, '111', '11.00', 0, 0, '2016-06-17 21:47:41', '2016-07-22 20:21:26'),
(2, '少香菜', '-0.10', 0, 0, '2016-06-17 22:11:57', '2016-06-17 22:11:57'),
(3, '加牛肉', '10.00', 0, 0, '2016-06-17 22:12:12', '2016-06-17 22:12:12'),
(4, '加个名字长点的看看效果', '999.00', 0, 0, '2016-06-17 22:25:44', '2016-06-17 22:25:44'),
(5, '少牛肉', '-5.00', 0, 0, '2016-06-17 22:27:06', '2016-06-17 22:27:06'),
(6, '少粉', '-2.00', 0, 0, '2016-06-17 22:27:21', '2016-06-17 22:27:21'),
(7, '多咸菜', '0.00', 0, 0, '2016-06-17 22:27:48', '2016-06-17 22:27:48'),
(8, '少咸菜', '0.00', 0, 0, '2016-06-17 22:27:56', '2016-06-17 22:27:56'),
(9, '加辣', '0.00', 0, 0, '2016-06-19 12:43:57', '2016-06-19 12:43:57');

-- --------------------------------------------------------

--
-- 表的结构 `t_order`
--

CREATE TABLE IF NOT EXISTS `t_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `src` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单来源',
  `table_id` varchar(64) NOT NULL DEFAULT '' COMMENT '桌号',
  `order_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '下单时间',
  `order_user` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `dish_list` varchar(1024) NOT NULL DEFAULT '' COMMENT '点菜列表，json',
  `dish_num` int(11) NOT NULL DEFAULT '0' COMMENT '点菜总数',
  `seat_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '就餐人数',
  `remark` text NOT NULL,
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT '总价',
  `discount` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT '折扣',
  `pay_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付类型',
  `pay_amount` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT '支付总额',
  `oper` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外键，操作人ID',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `mtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `status` (`status`),
  KEY `order_user` (`order_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `t_order`
--

INSERT INTO `t_order` (`id`, `type`, `src`, `table_id`, `order_time`, `order_user`, `status`, `dish_list`, `dish_num`, `seat_num`, `remark`, `amount`, `discount`, `pay_type`, `pay_amount`, `oper`, `ctime`, `mtime`) VALUES
(1, 0, 0, '1', '2016-06-14 12:01:02', 1, 0, '', 0, 0, '222', '0.00', '0.00', 0, '100.00', 0, '2016-06-14 23:13:57', '2016-06-14 23:13:57');

-- --------------------------------------------------------

--
-- 表的结构 `t_order_dish`
--

CREATE TABLE IF NOT EXISTS `t_order_dish` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外键，订单ID',
  `dish_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外键，菜单ID',
  `order_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '下单时间',
  `order_user` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外键，下单人ID',
  `oper` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外键，操作人ID',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `mtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `t_user`
--

INSERT INTO `t_user` (`id`, `name`, `password`, `role_id`, `status`, `oper`, `ctime`, `mtime`) VALUES
(1, 'FELIX', 'cdb52c63ddef6815c27a569bc04ceeb6', 1, 0, 0, '2016-06-15 22:24:07', '2016-06-15 23:11:23'),
(2, 'TEST', '22b75d6007e06f4a959d1b1d69b4c4bd', 2, 0, 0, '2016-06-15 22:38:30', '2016-06-15 23:11:23'),
(3, 'TEST2', 'f68337eb380b5f5161807535c29da0a6', 3, 1, 0, '2016-06-18 09:53:12', '2016-06-18 09:59:09'),
(4, 'TEST3', 'ffb9e559fb466f3e3d9919ddf377ee06', 3, 1, 0, '2016-06-18 10:12:11', '2016-06-18 10:12:11');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
