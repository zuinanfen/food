-- MySQL dump 10.16  Distrib 10.1.13-MariaDB, for osx10.6 (i386)
--
-- Host: localhost    Database: food
-- ------------------------------------------------------
-- Server version	10.1.13-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `t_custom`
--

DROP TABLE IF EXISTS `t_custom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_custom` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '名称',
  `ex` varchar(64) NOT NULL DEFAULT '',
  `oper` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外键，操作人ID',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `mtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_custom`
--

LOCK TABLES `t_custom` WRITE;
/*!40000 ALTER TABLE `t_custom` DISABLE KEYS */;
INSERT INTO `t_custom` VALUES (1,'去除可选项','葱|香菜|芝麻',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'多加可选项','葱|香菜|粉',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'少加可选项','葱|香菜|粉',0,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `t_custom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_dish`
--

DROP TABLE IF EXISTS `t_dish`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_dish` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '名称',
  `price` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT '单价',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `custom` text NOT NULL COMMENT '定制菜单',
  `oper` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外键，操作人ID',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `mtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_dish`
--

LOCK TABLES `t_dish` WRITE;
/*!40000 ALTER TABLE `t_dish` DISABLE KEYS */;
INSERT INTO `t_dish` VALUES (1,0,'醉南粉',24.00,9,2,'{\"去除可选项\":\"葱|香菜|芝麻22\",\"多加可选项\":\"葱|香菜|粉\",\"少加可选项\":\"葱|香菜|粉\"}',0,'2016-06-10 18:46:27','2016-06-11 08:43:17'),(2,0,'醉南粉',24.00,9,1,'{\"去除可选项\":\"葱|香菜|芝麻\",\"多加可选项\":\"葱|香菜|粉\",\"少加可选项\":\"葱|香菜|粉\"}',0,'0000-00-00 00:00:00','2016-06-10 19:54:21'),(3,0,'醉南粉',24.00,9,1,'{\"去除可选项\":\"葱|香菜|芝麻\",\"多加可选项\":\"葱|香菜|粉\",\"少加可选项\":\"葱|香菜|粉\"}',0,'0000-00-00 00:00:00','2016-06-10 19:54:27'),(4,0,'',0.00,0,0,'',0,'0000-00-00 00:00:00','2016-06-10 19:54:32'),(5,0,'醉南粉',24.00,9,1,'{\"去除可选项\":\"葱|香菜|芝麻\",\"多加可选项\":\"葱|香菜|粉\",\"少加可选项\":\"葱|香菜|粉\"}',0,'0000-00-00 00:00:00','2016-06-10 19:55:50');
/*!40000 ALTER TABLE `t_dish` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_order_dish`
--

DROP TABLE IF EXISTS `t_order_dish`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_order_dish` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL DEFAULT '0',
  `dish_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `order_user` int(10) unsigned NOT NULL DEFAULT '0',
  `oper` int(10) unsigned NOT NULL DEFAULT '0',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_order_dish`
--

LOCK TABLES `t_order_dish` WRITE;
/*!40000 ALTER TABLE `t_order_dish` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_order_dish` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_order_info`
--

DROP TABLE IF EXISTS `t_order_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_order_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `src` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单来源',
  `table_id` varchar(64) NOT NULL DEFAULT '' COMMENT '桌号',
  `order_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '下单时间',
  `order_user` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `dish_list` varchar(1024) NOT NULL DEFAULT '' COMMENT '点菜列表，json',
  `dish_num` int(11) NOT NULL DEFAULT '0' COMMENT '点菜总数',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_order_info`
--

LOCK TABLES `t_order_info` WRITE;
/*!40000 ALTER TABLE `t_order_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_order_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_role`
--

DROP TABLE IF EXISTS `t_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '名称',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `oper` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外键，操作人ID',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `mtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_role`
--

LOCK TABLES `t_role` WRITE;
/*!40000 ALTER TABLE `t_role` DISABLE KEYS */;
INSERT INTO `t_role` VALUES (1,0,'系统管理员',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,0,'厨师',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,0,'点菜员',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,0,'上菜员',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `t_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_user`
--

DROP TABLE IF EXISTS `t_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_user` (
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_user`
--

LOCK TABLES `t_user` WRITE;
/*!40000 ALTER TABLE `t_user` DISABLE KEYS */;
INSERT INTO `t_user` VALUES (1,'test','',3,1,0,'2016-06-04 19:20:11','2016-06-10 14:14:34'),(2,'test222','',4,0,0,'2016-06-04 19:20:12','2016-06-10 14:14:50'),(3,'test','',0,0,0,'2016-06-04 19:20:14','2016-06-09 23:28:04'),(4,'test','',2,1,0,'2016-06-04 20:28:31','2016-06-10 14:14:26'),(5,'test','',0,1,0,'2016-06-04 20:28:32','2016-06-09 23:26:51'),(6,'test','',1,0,0,'2016-06-07 22:18:41','2016-06-09 23:27:58'),(7,'AAA','',0,0,0,'2016-06-09 22:41:27','2016-06-09 23:37:34'),(8,'BBB','',1,0,0,'2016-06-09 22:42:42','2016-06-09 22:42:42'),(9,'CCC','',0,0,0,'2016-06-09 23:37:57','2016-06-09 23:37:57'),(26,'CYY','123456',0,1,0,'2016-06-10 00:40:35','2016-06-10 00:40:35'),(27,'CY222','123456',0,1,0,'2016-06-10 00:41:13','2016-06-10 00:41:13'),(28,'CYY3','123456',3,1,0,'2016-06-10 00:42:03','2016-06-10 00:42:03');
/*!40000 ALTER TABLE `t_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-11 21:25:04
