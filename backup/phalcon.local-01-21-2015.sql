-- MySQL dump 10.13  Distrib 5.7.5-m15, for Linux (x86_64)
--
-- Host: localhost    Database: phalcon.local
-- ------------------------------------------------------
-- Server version	5.7.5-m15

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Category id',
  `title` varchar(255) DEFAULT NULL COMMENT 'Category title',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT 'Category description',
  `alias` varchar(64) NOT NULL DEFAULT '' COMMENT 'Category alias',
  `parent_id` tinyint(3) unsigned DEFAULT NULL COMMENT 'Parent category',
  `lft` smallint(5) unsigned DEFAULT NULL COMMENT 'Left padding',
  `rgt` smallint(5) unsigned DEFAULT NULL COMMENT 'Right padding',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'Sort index',
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Create date',
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Update date',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_alias` (`alias`),
  KEY `idx_rgt` (`rgt`),
  KEY `idx_lft` (`lft`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (22,'First category','my first category','first_category',NULL,1,8,0,'2014-11-20 00:00:00','2014-12-01 01:53:00'),(23,'Second category','My second category','second_category',NULL,9,16,0,'2014-11-18 00:00:00','2014-12-01 01:53:00'),(24,'Third category','My third category','third_category',NULL,17,24,0,'2014-11-17 00:00:00','2014-12-01 01:53:00'),(25,'Child of first 1','Description of child','child_first1',22,2,3,0,'2014-11-25 00:00:00','2014-12-01 01:53:00'),(26,'Child of first 2','Description of child','child_first2',22,4,5,0,'2014-11-04 00:00:00','2014-12-01 01:53:00'),(27,'Child of first 3','Description of child','child_first3',22,6,7,0,'2014-11-16 00:00:00','2014-12-01 01:53:00'),(28,'Child of second 2','Description of second','child_second2',23,10,11,0,'2014-11-18 00:00:00','2014-12-01 01:53:00'),(29,'Child of second 3','Description of second','child_second3',23,12,13,0,'0000-00-00 00:00:00','2014-12-01 01:53:00'),(30,'Child of second 1','Description of second','child_second1',23,14,15,0,'2014-11-18 00:00:00','2014-12-01 01:53:00'),(31,'Child of third 1','Description of third','child_third1',24,18,19,0,'2014-11-12 00:00:00','2014-12-01 01:53:00'),(32,'Child of third 2','Description of third','child_third2',24,20,21,0,'2014-11-08 00:00:00','2014-12-01 01:53:00'),(33,'Child of third 3','Description of third','child_third3',24,22,23,0,'2014-11-08 00:00:00','2014-12-01 01:53:00');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Currency ID',
  `code` char(3) NOT NULL COMMENT 'Currency Code',
  `name` varchar(45) DEFAULT NULL COMMENT 'Currency name',
  `symbol` varchar(4) DEFAULT NULL COMMENT 'Currency symbol',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_code` (`code`) COMMENT 'Unique code'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES (1,'USD','USA Dollar','$'),(2,'RUR','Российский рубль','руб.'),(3,'EUR','Euro','€'),(4,'UAH','Украинская гривна','₴'),(5,'GBP','Pound','£');
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `engines`
--

DROP TABLE IF EXISTS `engines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `engines` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Engine ID',
  `name` varchar(45) NOT NULL COMMENT 'Engine name',
  `description` varchar(512) NOT NULL COMMENT 'Engine description',
  `host` varchar(45) DEFAULT NULL COMMENT 'identity host name',
  `code` char(3) NOT NULL COMMENT 'Engine short code',
  `logo` varchar(255) NOT NULL DEFAULT '' COMMENT 'Engine logo',
  `currency_id` tinyint(3) unsigned DEFAULT NULL COMMENT 'Relation to `currency` table',
  `status` tinyint(1) NOT NULL COMMENT 'enabled/disabled',
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_code` (`code`) COMMENT 'Unique value of code',
  UNIQUE KEY `uni_host` (`host`),
  KEY `fk_currency_id` (`currency_id`),
  CONSTRAINT `fk_currency_id` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 MAX_ROWS=10;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `engines`
--

LOCK TABLES `engines` WRITE;
/*!40000 ALTER TABLE `engines` DISABLE KEYS */;
INSERT INTO `engines` VALUES (32,'Phalcon Shop','<p>This is the simple Phalcon Shop</p>','phalcon.local','PHL','',4,1,'2015-01-03 02:27:22','2015-01-03 00:28:00');
/*!40000 ALTER TABLE `engines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `engines_categories_rel`
--

DROP TABLE IF EXISTS `engines_categories_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `engines_categories_rel` (
  `engine_id` tinyint(2) unsigned DEFAULT NULL COMMENT 'to engines.id rel',
  `category_id` tinyint(3) unsigned DEFAULT NULL COMMENT 'to categories.id rel',
  KEY `idx_category_id` (`category_id`),
  KEY `idx_engine_id` (`engine_id`),
  CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_engine_id` FOREIGN KEY (`engine_id`) REFERENCES `engines` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `engines_categories_rel`
--

LOCK TABLES `engines_categories_rel` WRITE;
/*!40000 ALTER TABLE `engines_categories_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `engines_categories_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL COMMENT 'User ID',
  `login` varchar(40) NOT NULL DEFAULT '' COMMENT 'User login',
  `name` varchar(40) NOT NULL COMMENT 'User name',
  `surname` varchar(40) NOT NULL COMMENT 'User surname',
  `password` varchar(150) NOT NULL DEFAULT '' COMMENT 'Password hash',
  `token` varchar(255) NOT NULL COMMENT 'Security token',
  `state` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT 'Activity state, 0 - disabled, 1 - active, 2 - banned',
  `rating` decimal(10,0) unsigned NOT NULL DEFAULT '0' COMMENT 'User rating',
  `date_registration` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Registration date',
  `date_lastvisit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Last visit date',
  `ip` int(10) unsigned DEFAULT NULL COMMENT 'IP addres',
  `ua` varchar(255) NOT NULL DEFAULT '' COMMENT 'User agent',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_token` (`token`),
  UNIQUE KEY `uni_login` (`login`),
  KEY `idx_state` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Common users table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'stanisov@gmail.com','Stanislav','WEB','$2a$08$TgS2ceKI2/p2oYBBHhdpze5dCPnG3Hm6JAFOVZg5BXyiZjsyvIbI.','0123456789','2',0,'2007-12-31 23:59:59','2015-01-20 03:28:56',2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.99 Safari/537.36'),(2,'moderator@gmail.com','Moder','Site','$2a$08$i8eF./itFwHjirh2A5Qq.OPfa3I1T/mut.Q3uHBXbw9BCMWQoVcda','0123456789w','2',1,'2007-12-31 23:59:59','2007-12-31 23:59:59',3232235521,'USER AGENT');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-21  3:05:04
