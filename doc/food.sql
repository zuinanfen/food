-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 08 月 06 日 16:39
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `t_dish`
--

INSERT INTO `t_dish` (`id`, `type`, `name`, `price`, `sort`, `status`, `option`, `oper`, `ctime`, `mtime`) VALUES
(1, 0, '牛肉粉', '20.01', 0, 0, '["1","2","3","6","7","8","9"]', 0, '2016-06-18 01:00:42', '2016-07-23 12:59:15'),
(2, 0, '醉南粉', '22.00', 0, 0, '["1","2","5","6"]', 0, '2016-06-18 01:03:40', '2016-06-18 01:03:40'),
(3, 0, '这是个名字很长的菜，看看会怎样', '99999.00', 9, 0, '["3","4"]', 0, '2016-06-18 16:35:08', '2016-06-18 16:35:08'),
(4, 0, '打包盒', '0.10', 0, 0, '[]', 0, '2016-06-20 18:23:20', '2016-07-24 13:03:17'),
(6, 0, 'xxxxx', '22.00', 34, 1, '', 0, '2016-07-23 16:37:45', '2016-07-23 16:37:45');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `t_dish_option`
--

INSERT INTO `t_dish_option` (`id`, `dish_id`, `oper`, `ctime`, `mtime`, `name`, `price`, `status`, `sort`) VALUES
(1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '少粉', '-12.02', 0, 1),
(2, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '多香菜', '5.01', 0, 10),
(4, 1, 0, '2016-07-23 12:45:36', '2016-07-23 16:30:49', '1111', '11.00', 1, 1),
(5, 1, 0, '2016-07-23 15:47:17', '2016-07-23 15:47:17', 'aaaaaxx', '-2.00', 0, 45),
(6, 3, 0, '2016-07-24 13:37:26', '2016-07-24 13:37:26', '11', '11.00', 0, 11),
(7, 3, 0, '2016-07-24 13:37:31', '2016-07-24 13:37:31', '22', '22.00', 0, 22),
(8, 1, 0, '2016-07-25 20:27:40', '2016-07-25 20:27:40', '多粉', '-1.00', 0, 2),
(9, 1, 0, '2016-07-25 20:27:57', '2016-07-25 20:27:57', '多卤汁', '0.00', 0, 1),
(10, 1, 0, '2016-07-25 20:28:07', '2016-07-25 20:28:07', '少香菜', '1.00', 0, 1),
(11, 1, 0, '2016-07-25 20:28:43', '2016-07-25 20:28:43', '去花生', '2.00', 0, 0),
(12, 1, 0, '2016-07-25 20:28:50', '2016-07-25 20:28:50', '去酸笋', '1.00', 0, 0),
(13, 1, 0, '2016-07-25 20:29:06', '2016-07-25 20:29:06', '去蒜头油', '3.00', 0, 0),
(14, 1, 0, '2016-07-25 20:29:16', '2016-07-25 20:29:16', '去白芝麻', '3.00', 0, 0),
(15, 1, 0, '2016-07-25 20:36:02', '2016-07-25 20:36:02', '多豆芽', '2.00', 0, 0),
(16, 1, 0, '2016-07-25 20:36:12', '2016-07-25 20:36:12', '去豆芽', '1.00', 0, 0),
(17, 1, 0, '2016-07-25 20:36:36', '2016-07-25 20:36:36', '少酸笋', '0.00', 0, 0),
(18, 1, 0, '2016-07-25 20:36:44', '2016-07-25 20:36:44', '去香菜', '0.00', 0, 0),
(19, 1, 0, '2016-07-25 20:37:47', '2016-07-25 20:37:47', '去粉', '1.00', 0, 0),
(20, 1, 0, '2016-07-25 20:37:54', '2016-07-25 20:37:54', '去卤汁', '1.00', 0, 0),
(21, 3, 0, '2016-07-30 15:09:02', '2016-07-30 15:09:02', '多酸菜', '5.00', 0, 0);

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
  `id` varchar(32) NOT NULL,
  `src` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单来源',
  `table_id` varchar(64) NOT NULL COMMENT '桌号',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `dish_list` text NOT NULL COMMENT '点菜列表，json',
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
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_order`
--

INSERT INTO `t_order` (`id`, `src`, `table_id`, `status`, `dish_list`, `dish_num`, `seat_num`, `remark`, `amount`, `discount`, `pay_type`, `pay_amount`, `ctime`, `mtime`, `uid`) VALUES
('147041253968495A9ACBDC', 3, '', 8, '{"dish_1470412533182_469141":{"dishId":"1","name":"\\u725b\\u8089\\u7c89","dishPrice":"20.01","options":[8,9,17,14]},"dish_1470412536609_820114":{"dishId":"2","name":"\\u9189\\u5357\\u7c89","dishPrice":"22.00","options":[]}}', 1, 0, '', '22.00', '0.00', 0, '0.00', '2016-08-05 23:55:39', '2016-08-06 13:53:10', '2'),
('14704629095518C2EB9381', 3, '', 8, '{"dish_1470462900774_154584":{"dishId":"4","name":"\\u6253\\u5305\\u76d2","dishPrice":"0.10","options":[]},"dish_1470462901208_215696":{"dishId":"2","name":"\\u9189\\u5357\\u7c89","dishPrice":"22.00","options":[]},"dish_1470462901639_831015":{"dishId":"1","name":"\\u725b\\u8089\\u7c89","dishPrice":"20.01","options":[8,9,17]},"dish_1470462904366_766229":{"dishId":"3","name":"\\u8fd9\\u662f\\u4e2a\\u540d\\u5b57\\u5f88\\u957f\\u7684\\u83dc\\uff0c\\u770b\\u770b\\u4f1a\\u600e\\u6837","dishPrice":"99999.00","options":[7,6]}}', 3, 0, '', '0.00', '0.00', 0, '0.00', '2016-08-06 13:55:09', '2016-08-06 13:55:31', '2'),
('14704629836086A1F47EE4', 4, '', 8, '{"dish_1470462977744_127321":{"dishId":"4","name":"\\u6253\\u5305\\u76d2","dishPrice":"0.10","options":[]},"dish_1470462978120_743665":{"dishId":"2","name":"\\u9189\\u5357\\u7c89","dishPrice":"22.00","options":[]},"dish_1470462979032_150394":{"dishId":"2","name":"\\u9189\\u5357\\u7c89","dishPrice":"22.00","options":[]},"dish_1470462979520_582093":{"dishId":"4","name":"\\u6253\\u5305\\u76d2","dishPrice":"0.10","options":[]}}', 0, 0, '', '0.00', '0.00', 0, '0.00', '2016-08-06 13:56:23', '2016-08-06 13:56:35', '2'),
('14704630831942C08A904F', 3, '', 2, '{"dish_1470463079961_888018":{"dishId":"2","name":"\\u9189\\u5357\\u7c89","dishPrice":"22.00","options":[]},"dish_1470463080299_34156":{"dishId":"4","name":"\\u6253\\u5305\\u76d2","dishPrice":"0.10","options":[]}}', 1, 0, '', '0.10', '0.00', 0, '0.00', '2016-08-06 13:58:03', '2016-08-06 16:37:44', '2'),
('147046913913843E91E298', 2, '', 2, '{"dish_1470469002265_5134":{"dishId":"1","name":"\\u725b\\u8089\\u7c89","dishPrice":"20.01","options":[14,11]}}', 1, 0, '', '25.01', '0.00', 0, '0.00', '2016-08-06 15:38:59', '2016-08-06 16:21:26', '11');

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
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `dish_id` (`dish_id`),
  KEY `mtime` (`mtime`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `t_order_dish`
--

INSERT INTO `t_order_dish` (`id`, `order_id`, `dish_id`, `uid`, `ctime`, `mtime`, `name`, `price`, `total_price`, `select_options`, `status`, `dish_key`) VALUES
(1, '147041253968495A9ACBDC', 1, '2', '2016-08-05 23:55:39', '2016-08-06 13:29:33', '牛肉粉', '20.01', '22.01', '[{"id":"8","dish_id":"1","oper":"0","ctime":"2016-07-25 20:27:40","mtime":"2016-07-25 20:27:40","name":"\\u591a\\u7c89","price":"-1.00","status":"0","sort":"2"},{"id":"9","dish_id":"1","oper":"0","ctime":"2016-07-25 20:27:57","mtime":"2016-07-25 20:27:57","name":"\\u591a\\u5364\\u6c41","price":"0.00","status":"0","sort":"1"},{"id":"17","dish_id":"1","oper":"0","ctime":"2016-07-25 20:36:36","mtime":"2016-07-25 20:36:36","name":"\\u5c11\\u9178\\u7b0b","price":"0.00","status":"0","sort":"0"},{"id":"14","dish_id":"1","oper":"0","ctime":"2016-07-25 20:29:16","mtime":"2016-07-25 20:29:16","name":"\\u53bb\\u767d\\u829d\\u9ebb","price":"3.00","status":"0","sort":"0"}]', 8, 'dish_1470412533182_469141'),
(2, '147041253968495A9ACBDC', 2, '2', '2016-08-05 23:55:39', '2016-08-06 13:53:10', '醉南粉', '22.00', '22.00', '[]', 8, 'dish_1470412536609_820114'),
(3, '14704629095518C2EB9381', 4, '2', '2016-08-06 13:55:09', '2016-08-06 13:55:31', '打包盒', '0.10', '0.10', '[]', 8, 'dish_1470462900774_154584'),
(4, '14704629095518C2EB9381', 2, '2', '2016-08-06 13:55:09', '2016-08-06 13:55:31', '醉南粉', '22.00', '22.00', '[]', 8, 'dish_1470462901208_215696'),
(5, '14704629095518C2EB9381', 1, '2', '2016-08-06 13:55:09', '2016-08-06 13:55:31', '牛肉粉', '20.01', '19.01', '[{"id":"8","dish_id":"1","oper":"0","ctime":"2016-07-25 20:27:40","mtime":"2016-07-25 20:27:40","name":"\\u591a\\u7c89","price":"-1.00","status":"0","sort":"2"},{"id":"9","dish_id":"1","oper":"0","ctime":"2016-07-25 20:27:57","mtime":"2016-07-25 20:27:57","name":"\\u591a\\u5364\\u6c41","price":"0.00","status":"0","sort":"1"},{"id":"17","dish_id":"1","oper":"0","ctime":"2016-07-25 20:36:36","mtime":"2016-07-25 20:36:36","name":"\\u5c11\\u9178\\u7b0b","price":"0.00","status":"0","sort":"0"}]', 8, 'dish_1470462901639_831015'),
(6, '14704629095518C2EB9381', 3, '2', '2016-08-06 13:55:09', '2016-08-06 13:55:26', '这是个名字很长的菜，看看会怎样', '99999.00', '100032.00', '[{"id":"7","dish_id":"3","oper":"0","ctime":"2016-07-24 13:37:31","mtime":"2016-07-24 13:37:31","name":"22","price":"22.00","status":"0","sort":"22"},{"id":"6","dish_id":"3","oper":"0","ctime":"2016-07-24 13:37:26","mtime":"2016-07-24 13:37:26","name":"11","price":"11.00","status":"0","sort":"11"}]', 8, 'dish_1470462904366_766229'),
(7, '14704629836086A1F47EE4', 4, '2', '2016-08-06 13:56:23', '2016-08-06 13:56:28', '打包盒', '0.10', '0.10', '[]', 8, 'dish_1470462977744_127321'),
(8, '14704629836086A1F47EE4', 2, '2', '2016-08-06 13:56:23', '2016-08-06 13:56:35', '醉南粉', '22.00', '22.00', '[]', 8, 'dish_1470462978120_743665'),
(9, '14704629836086A1F47EE4', 2, '2', '2016-08-06 13:56:23', '2016-08-06 13:56:35', '醉南粉', '22.00', '22.00', '[]', 8, 'dish_1470462979032_150394'),
(10, '14704629836086A1F47EE4', 4, '2', '2016-08-06 13:56:23', '2016-08-06 13:56:35', '打包盒', '0.10', '0.10', '[]', 8, 'dish_1470462979520_582093'),
(11, '14704630831942C08A904F', 2, '2', '2016-08-06 13:58:03', '2016-08-06 16:17:49', '醉南粉', '22.00', '22.00', '[]', 8, 'dish_1470463079961_888018'),
(12, '14704630831942C08A904F', 4, '2', '2016-08-06 13:58:03', '2016-08-06 16:37:44', '打包盒', '0.10', '0.10', '[]', 2, 'dish_1470463080299_34156'),
(13, '147046913913843E91E298', 1, '11', '2016-08-06 15:38:59', '2016-08-06 16:21:26', '牛肉粉', '20.01', '25.01', '[{"id":"14","dish_id":"1","oper":"0","ctime":"2016-07-25 20:29:16","mtime":"2016-07-25 20:29:16","name":"\\u53bb\\u767d\\u829d\\u9ebb","price":"3.00","status":"0","sort":"0"},{"id":"11","dish_id":"1","oper":"0","ctime":"2016-07-25 20:28:43","mtime":"2016-07-25 20:28:43","name":"\\u53bb\\u82b1\\u751f","price":"2.00","status":"0","sort":"0"}]', 2, 'dish_1470469002265_5134');

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
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `t_user`
--

INSERT INTO `t_user` (`id`, `name`, `password`, `role_id`, `status`, `oper`, `ctime`, `mtime`, `uid`) VALUES
(10, '花满楼', 'c6e5be3dee1a9839068579e378980811', 1, 0, 0, '2016-08-06 15:01:19', '2016-08-06 15:17:30', 'nick'),
(11, 'test111', 'd76b2d0809511258a37ea7b20003bc04', 1, 0, 0, '2016-08-06 15:02:02', '2016-08-06 15:02:25', 'test'),
(12, '厨师', 'd76b2d0809511258a37ea7b20003bc04', 2, 0, 0, '2016-08-06 15:28:33', '2016-08-06 15:30:53', 'chushi'),
(13, '上菜', 'd76b2d0809511258a37ea7b20003bc04', 4, 0, 0, '2016-08-06 15:28:52', '2016-08-06 15:30:55', 'shangcai'),
(14, '点餐', 'd76b2d0809511258a37ea7b20003bc04', 3, 0, 0, '2016-08-06 15:29:04', '2016-08-06 15:30:56', 'diancan');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
