-- MySQL dump 10.13  Distrib 5.6.19, for linux-glibc2.5 (x86_64)
--
-- Host: 127.0.0.1    Database: phalcon.local
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
  `visibility` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_alias` (`alias`),
  KEY `idx_rgt` (`rgt`),
  KEY `idx_lft` (`lft`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (103,'2323','<p>2323232323232322322323232323322323232323323323</p>','233232323',NULL,1,2,23,'2015-03-06 23:46:29','2015-03-06 21:46:29',1);
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
  `name` varchar(45) NOT NULL,
  `symbol` varchar(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_code` (`code`) COMMENT 'Unique code'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES (1,'USD','USA Dollar','$'),(2,'RUR','Российский рубль','руб.'),(3,'EUR','Euro','€'),(4,'UAH','Украинская гривна','₴'),(5,'GBP','British Pound','£'),(6,'JPY','Японская иена','¥');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 MAX_ROWS=10;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `engines`
--

LOCK TABLES `engines` WRITE;
/*!40000 ALTER TABLE `engines` DISABLE KEYS */;
INSERT INTO `engines` VALUES (1,'Phalcon Shop','<p>This is the simple Phalcon Shop</p>','phalcon.local','PHL','logo-mysql-110x57.png',4,1,'2015-01-03 02:27:22','2015-02-23 00:58:12'),(10,'eBay','<p>ebay Description2</p>','ebay.com','EBY','eBay-Logo.gif',1,2,'2015-03-06 12:24:17','2015-03-06 21:23:31');
/*!40000 ALTER TABLE `engines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `engines_categories_rel`
--

DROP TABLE IF EXISTS `engines_categories_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `engines_categories_rel` (
  `engine_id` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'to engines.id rel',
  `category_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'to categories.id rel',
  PRIMARY KEY (`engine_id`,`category_id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_engine_id` (`engine_id`),
  CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `engines_categories_rel`
--

LOCK TABLES `engines_categories_rel` WRITE;
/*!40000 ALTER TABLE `engines_categories_rel` DISABLE KEYS */;
INSERT INTO `engines_categories_rel` VALUES (1,103);
/*!40000 ALTER TABLE `engines_categories_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `content` varchar(512) NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=ARCHIVE AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (1,NULL,1,'Internal Server Error File: /var/www/phalcon.local/Application/Modules/Rest/Rest.php Line:130',1426435654),(2,'Rest',1,'Call to undefined method Application\\Modules\\Rest\\V1\\Controllers\\UserController::getUnd() File: /var/www/phalcon.local/Application/Modules/Rest/V1/Controllers/UserController.php Line:20',1426436255),(3,'Rest',1,'Call to undefined method Application\\Modules\\Rest\\Services\\JsonRestService::getDi() File: /var/www/phalcon.local/Application/Modules/Rest/Services/JsonRestService.php Line:124',1426436378),(4,'Rest',1,'Call to undefined method Application\\Modules\\Rest\\Services\\JsonRestService::getDi() File: /var/www/phalcon.local/Application/Modules/Rest/Services/JsonRestService.php Line:124',1426436380),(5,'Rest',1,'Call to undefined method Application\\Modules\\Rest\\Services\\JsonRestService::getDi() File: /var/www/phalcon.local/Application/Modules/Rest/Services/JsonRestService.php Line:124',1426436402),(6,'Rest',1,'Call to a member function get() on a non-object File: /var/www/phalcon.local/Application/Modules/Rest/Services/JsonRestService.php Line:150',1426436550),(7,'Rest',1,'Undefined property: stdClass::$methods File: /var/www/phalcon.local/Application/Modules/Rest/Services/JsonRestService.php Line:186',1426436839),(8,'Rest',1,'Undefined property: stdClass::$methods File: /var/www/phalcon.local/Application/Modules/Rest/Services/JsonRestService.php Line:186',1426436851),(9,'Rest',1,'syntax error, unexpected \'if\' (T_IF) File: /var/www/phalcon.local/Application/Modules/Rest/Services/JsonRestService.php Line:173',1426437607),(10,'Rest',1,'Undefined property: Application\\Modules\\Rest\\Services\\JsonRestService::$debug File: /var/www/phalcon.local/Application/Modules/Rest/Services/JsonRestService.php Line:172',1426437642),(1,'Rest',1,'PHP Startup: Unable to load dynamic library \'/usr/lib/php5/20121212/phalcon.so\' - /usr/lib/php5/20121212/phalcon.so: undefined symbol: php_json_decode_ex File: Unknown Line:0',1426633483),(2,'Rest',1,'PHP Startup: Unable to load dynamic library \'/usr/lib/php5/20121212/phalcon.so\' - /usr/lib/php5/20121212/phalcon.so: undefined symbol: php_json_decode_ex File: Unknown Line:0',1426633485),(3,'Rest',1,'PHP Startup: Unable to load dynamic library \'/usr/lib/php5/20121212/phalcon.so\' - /usr/lib/php5/20121212/phalcon.so: undefined symbol: php_json_decode_ex File: Unknown Line:0',1426640682),(4,'Rest',1,'PHP Startup: Unable to load dynamic library \'/usr/lib/php5/20121212/phalcon.so\' - /usr/lib/php5/20121212/phalcon.so: undefined symbol: php_json_decode_ex File: Unknown Line:0',1426640682),(5,'Rest',1,'PHP Startup: Unable to load dynamic library \'/usr/lib/php5/20121212/phalcon.so\' - /usr/lib/php5/20121212/phalcon.so: undefined symbol: php_json_decode_ex File: Unknown Line:0',1426640682),(6,'Rest',1,'PHP Startup: Unable to load dynamic library \'/usr/lib/php5/20121212/phalcon.so\' - /usr/lib/php5/20121212/phalcon.so: undefined symbol: php_json_decode_ex File: Unknown Line:0',1426640683),(7,'Rest',1,'PHP Startup: Unable to load dynamic library \'/usr/lib/php5/20121212/phalcon.so\' - /usr/lib/php5/20121212/phalcon.so: undefined symbol: php_json_decode_ex File: Unknown Line:0',1426640703),(8,'Rest',1,'PHP Startup: Unable to load dynamic library \'/usr/lib/php5/20121212/phalcon.so\' - /usr/lib/php5/20121212/phalcon.so: undefined symbol: php_json_decode_ex File: Unknown Line:0',1426640704),(9,'Rest',1,'PHP Startup: Unable to load dynamic library \'/usr/lib/php5/20121212/phalcon.so\' - /usr/lib/php5/20121212/phalcon.so: undefined symbol: php_json_decode_ex File: Unknown Line:0',1426640704),(10,'Rest',1,'PHP Startup: Unable to load dynamic library \'/usr/lib/php5/20121212/phalcon.so\' - /usr/lib/php5/20121212/phalcon.so: undefined symbol: php_json_decode_ex File: Unknown Line:0',1426640705),(11,'Rest',1,'PHP Startup: Unable to load dynamic library \'/usr/lib/php5/20121212/phalcon.so\' - /usr/lib/php5/20121212/phalcon.so: undefined symbol: php_json_decode_ex File: Unknown Line:0',1426640705),(12,'Rest',1,'PHP Startup: Unable to load dynamic library \'/usr/lib/php5/20121212/phalcon.so\' - /usr/lib/php5/20121212/phalcon.so: undefined symbol: php_json_decode_ex File: Unknown Line:0',1426640706),(13,'Rest',1,'PHP Startup: Unable to load dynamic library \'/usr/lib/php5/20121212/phalcon.so\' - /usr/lib/php5/20121212/phalcon.so: undefined symbol: php_json_decode_ex File: Unknown Line:0',1426640706),(14,'Rest',1,'PHP Startup: Unable to load dynamic library \'/usr/lib/php5/20121212/phalcon.so\' - /usr/lib/php5/20121212/phalcon.so: undefined symbol: php_json_decode_ex File: Unknown Line:0',1426640706),(15,'Rest',1,'PHP Startup: Unable to load dynamic library \'/usr/lib/php5/20121212/phalcon.so\' - /usr/lib/php5/20121212/phalcon.so: undefined symbol: php_json_decode_ex File: Unknown Line:0',1426640724),(16,'Rest',1,'PHP Startup: Unable to load dynamic library \'/usr/lib/php5/20121212/phalcon.so\' - /usr/lib/php5/20121212/phalcon.so: undefined symbol: php_json_decode_ex File: Unknown Line:0',1426640764),(17,'Rest',1,'Undefined variable: h File: /var/www/phalcon.local/Application/Modules/Rest/Services/SecurityService.php Line:50',1426640923),(18,'Rest',1,'Undefined variable: h File: /var/www/phalcon.local/Application/Modules/Rest/Services/SecurityService.php Line:50',1426640933);
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Title of page',
  `content` text NOT NULL COMMENT 'HTML content',
  `alias` varchar(32) NOT NULL DEFAULT '' COMMENT 'URL slug',
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Create date',
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Update date',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `ful_content` (`content`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'About','<p>This is about page content. I am edit storage text. EDITED2</p>','about','2015-01-22 00:30:05','2015-03-05 17:29:31'),(2,'Agreement','This is agreement page content','agreement','2015-01-22 00:32:41','2015-01-21 22:35:39'),(4,'Contacts','<p>This is contacs page content. EDITED</p>','contacts','2015-01-22 00:34:22','2015-02-16 01:31:18'),(5,'Help','<p>This is the help page</p>','help','2015-01-22 02:53:07','2015-01-22 00:54:47');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_access`
--

DROP TABLE IF EXISTS `user_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_access` (
  `user_id` int(11) unsigned NOT NULL,
  `token` varchar(255) NOT NULL,
  `expire_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `user_access_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_access`
--

LOCK TABLES `user_access` WRITE;
/*!40000 ALTER TABLE `user_access` DISABLE KEYS */;
INSERT INTO `user_access` VALUES (10,'$2a$08$fcLrP9TCQ1bikcqnW46vLORDcI9UlDGs/ABs9FcYfi3hP/DDgjhv6','2015-03-23 02:57:12'),(11,'f0318c6e5aff1fbed8ad7412e103bc0b','2015-02-14 04:48:17'),(12,'78df0928b91ec774abb2a651d8c1ffab','2015-03-01 13:37:59'),(13,'c26e866b05c4b60b48968a55154187da','2015-02-15 14:36:58'),(14,'e95b8b637146bc43325c9df2fd1a0ab4','2015-03-16 05:45:43'),(15,'3928c95e57ec4b61d2af55b36cfd6e01','2015-03-16 05:48:23'),(16,'643bd3a1ce3090d14f9a59d0c45ad354','2015-03-16 05:51:12'),(17,'1c94392e83ea494e4060b6a3ac651e6c','2015-03-16 05:54:21'),(18,'685c2403f2e977a5e02f8ed36c0e22d0','2015-03-16 05:55:23'),(19,'283108b3ee610cef11e51aa12cb697fc','2015-03-16 05:57:00'),(20,'27906fadb0f3bdade5a0cb8d3846611c','2015-03-16 05:59:14'),(21,'70accea75c068e1ed0e9adc4aa99acd9','2015-03-16 06:03:03'),(22,'6b67c6230eb9d646d583a29d19292bd8','2015-03-16 06:34:23'),(23,'ffbd44b314d83a442a49c56ef9f74af7','2015-03-16 07:01:05'),(24,'627761113ed88e4a56eb6189def3e651','2015-03-16 07:02:25'),(25,'f222918ddb53cc11d5905c45c865dc78','2015-03-16 07:04:33'),(26,'073626d8d6b3bacd3c4ad040406979d6','2015-03-16 07:05:48'),(30,'632a7cc5792dfe4c57106bd821402bf4','2015-03-16 07:20:57'),(31,'3fe372c2f39619966384ab84f6894518','2015-03-16 07:43:18'),(32,'210056b2ac1fc6071520c0c0b2b5f979','2015-03-19 02:13:37'),(33,'d2516319f860cd17283f8ffae47d47f6','2015-03-16 21:57:41');
/*!40000 ALTER TABLE `user_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_roles` (
  `id` tinyint(1) unsigned NOT NULL,
  `name` varchar(45) DEFAULT NULL COMMENT 'User Roles table',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 MAX_ROWS=5;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (0,'User'),(1,'Admin');
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `login` varchar(40) NOT NULL DEFAULT '' COMMENT 'User login',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT 'User name',
  `surname` varchar(40) NOT NULL DEFAULT '' COMMENT 'User surname',
  `password` varchar(150) NOT NULL DEFAULT '' COMMENT 'Password hash',
  `salt` varchar(255) NOT NULL COMMENT 'Password salt',
  `role` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `state` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT 'Activity state, 0 - disabled, 1 - active, 2 - banned',
  `rating` decimal(10,0) unsigned NOT NULL DEFAULT '0' COMMENT 'User rating',
  `ip` int(10) unsigned NOT NULL COMMENT 'IP addres',
  `ua` varchar(255) NOT NULL COMMENT 'User agent',
  `date_registration` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Registration date',
  `date_lastvisit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last visit date',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_login` (`login`),
  KEY `idx_state` (`state`),
  KEY `idx_role` (`role`) USING BTREE,
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `user_roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='Common users table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (10,'stanisov@gmail.com','Stanislav','','$2a$08$Zig/WYRWuXvpVUBwscXFbOBsIPNvoUAL/SlpkPTvOXLFfhovxvthS','5700e9bc64cd54fe2d8993b09c3ff7a8',1,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36','2015-02-02 12:30:28','2015-03-09 03:42:20'),(11,'stanisovw@gmail.com','stanisovw@gmail.com','','$2a$08$gAQeAhVAYIPcaY9pTRYGMeStAuoPw29y5JnMjM9qSSlrofGz3ILO6','52c91b18128a854d7ba1d4b11290da83',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36','2015-02-21 04:31:14','2015-02-21 02:31:14'),(12,'stanisov2@gmail.com','stanisov2@gmail.com','','$2a$08$WLHJJKcAFndE7mtuqcEYeOaIIjcGikfK1zNjGAGcmDiWEU.ya9mSy','0f216e751ac2a739709108eebc8a40aa',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36','2015-02-22 13:37:59','2015-02-22 11:37:59'),(13,'stanisov3@gmail.com','stanisov3@gmail.com','','$2a$08$ffWFo.DHPzZC1El/tlDfb.e4v6eG1/UgtacL/adtjCAf0wXcRqbNK','45707bf7ff673c44cba7957ed9482b77',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36','2015-02-22 14:36:52','2015-02-22 12:36:52'),(14,'stanisov4@gmail.com','dcdcdcdcdc','','wwwwww','7ccef5599a50e608af1721efc7918fa8',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 05:45:43','2015-03-09 03:45:43'),(15,'sdsdsdsd@sdsdsd.ua','sssssss','','sssssss','7ccef5599a50e608af1721efc7918fa8',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 05:48:23','2015-03-09 03:48:23'),(16,'qstanisov@gmail.com','qqqqqq','','qqqqqq','3c437b87ec578130d752ab8f831220d8',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 05:51:12','2015-03-09 03:51:12'),(17,'ssss@mail.ua','ssss@mail.ua','','ssss@mail.ua','a6a01868a42a6518492a8d3490d38647',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 05:54:21','2015-03-09 03:54:21'),(18,'sss2@mail.ua','ssss@mail.ua','','ssss@mail.ua','9c2c16a09223e1fae9e4b18feba3aece',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 05:55:23','2015-03-09 03:55:23'),(19,'stanisov44@gmail.com','stanisov4@gmail.com','','stanisov4@gmail.com','8a08276e9022aaaf1026d4957ad9d62a',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 05:57:00','2015-03-09 03:57:00'),(20,'sssdsd2@msdsd.uA','sssdsd2@msdsd.uA','','sssdsd2@msdsd.uA','f0390e87d5fb0cec44b53bab32204a92',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 05:59:14','2015-03-09 03:59:14'),(21,'asasas@mail.fj','asasas@mail.fj','','asasas@mail.fj','bb6b3091b9daab9858ded7b849477d08',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 06:03:03','2015-03-09 04:03:03'),(22,'asasa@sdsdsd.er','asasa@sdsdsd.er','','asasa@sdsdsd.er','f0fd9baed90ea85907f41778d25af39f',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 06:34:23','2015-03-09 04:34:23'),(23,'asassfdf@sds.ua','asassfdf@sds.ua','','$2a$08$yWl8VCT1yCfkac8a5gVfeuLnLnAlmpobG7euC6w2BV85NaJjEBrym','312f44aabf9a4d4724134adba01003f2',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:01:05','2015-03-09 05:01:05'),(24,'credential@sdsdsd.ua','$credential@sdsdsd.ua','','$2a$08$70SWdTIlqfBx.59c1GpvQORFGOrj5H6p83BQbCBUABjJcoEa6O8mi','fed3c06503fa1f1b3eadc5e5c5ab5f35',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:02:25','2015-03-09 05:02:25'),(25,'stanisovddddd@mail.ewe','stanisovddddd@mail.ewe','','$2a$08$y4P38MNLvUl3k3L0OmF6LeYd0N1bA4pGKEkO54fuOxjzYuKSO7Nv2','6d79afaeae02c4fc1b64e590ee9485ff',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:04:33','2015-03-09 05:04:33'),(26,'sdsfgfgfl@ksds.ua','sdsfgfgfl@ksds.ua','','$2a$08$XRFx3poEIMT7wn0dKoMiyeSNynu/BAfgAQbbG95LL0G4Psp/QOHQ2','f163aa889fac60a1b1a7342ff30cb624',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:05:48','2015-03-09 05:05:48'),(27,'dsdsffgfg@mail.cu','dsdsffgfg@mail.cu','','$2a$08$XdG3lDu.o0XVRN/lOp0zyOyDGxY/TDLmtVjO7GwJQMqTioU8.HKG.','95ea38a2a06eb56f5eb72b9927c7c9ea',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:07:36','2015-03-09 05:07:36'),(28,'gfhgfh@dfdfd.ia','gfhgfh@dfdfd.ia','','$2a$08$WiKNINxRZGHm8cD1esGtieRfNnqA2PgaGi729KPvDBhnazoah/O.e','f4b0c7382d956283a5c8179237fa93c8',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:14:58','2015-03-09 05:14:58'),(29,'rer@erer2.ua','rer@erer','','$2a$08$eW3FlhO32GSrTgclk3evQOUMzdBx0VqTTBYIxAuRUGFJ6tszn6FLO','41d55abc08a0e7688a4252e4c63c3b6f',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:17:51','2015-03-09 05:17:51'),(30,'fdsgf@asdsa.ua','fdsgf@asdsa.ua','','$2a$08$QNBEocj/fytqlnM2x3qNkeiRh2uRnLnCgEz2eKr9gZZ4ahKJP6sSC','a1cba59c0c3a6f70e38f7894f3c7e551',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:20:57','2015-03-09 05:20:57'),(31,'ddffff@mail.ru','ddffff@mail.ru','','$2a$08$vzeuVMFudlFKdi/wERuR4Ov4Dy6BH8Zn2Qf1IDnGburGzsLWQaYUe','409450f3b9708644dbb9070fb71e4c0a',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:22:46','2015-03-09 05:22:46'),(32,'ddffff@mail.ru2','ddffff@mail.ru2','','$2a$08$G1DYLGCUb14lr5hNy/e83uOPYK3VlRmpAXPDiDcSXNUi1VLjdPQJe','b8d82a43a35b7e3cc841de87e9d0b159',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:43:32','2015-03-12 00:13:37'),(33,'ddffff@mail.ru22','ddffff@mail.ru22','','$2a$08$V.SUyESC46HEmOtvmEXRLeiX.6TLxYcClLR93x42KkNT/m2AQy8rS','fe7d32e169e4f9d00f1ee7beef55ae68',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:45:37','2015-03-09 05:45:37');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'phalcon.local'
--

--
-- Dumping routines for database 'phalcon.local'
--
/*!50003 DROP FUNCTION IF EXISTS `REBUILD_TREE` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `REBUILD_TREE`() RETURNS int(11)
    MODIFIES SQL DATA
    DETERMINISTIC
BEGIN
    -- Изначально сбрасываем все границы в NULL
    UPDATE categories t SET lft = NULL, rgt = NULL;
    
    -- Устанавливаем границы корневым элементам
    SET @i := 0;
    UPDATE categories t SET lft = (@i := @i + 1), rgt = (@i := @i + 1)
    WHERE t.parent_id IS NULL;

    forever: LOOP
        -- Находим элемент с минимальной правой границей -- самый левый в дереве
        SET @parent_id := NULL;
        SELECT t.id, t.rgt FROM categories t, categories tc
        WHERE t.id = tc.parent_id AND tc.lft IS NULL AND t.rgt IS NOT NULL
        ORDER BY t.rgt LIMIT 1 INTO @parent_id, @parent_right;

        -- Выходим из бесконечности, когда у нас уже нет незаполненных элементов
        IF @parent_id IS NULL THEN LEAVE forever; END IF;

        -- Сохраняем левую границу текущего ряда
        SET @current_left := @parent_right;

        -- Вычисляем максимальную правую границу текущего ряда
        SELECT @current_left + COUNT(*) * 2 FROM categories
        WHERE parent_id = @parent_id INTO @parent_right;

        -- Вычисляем длину текущего ряда
        SET @current_length := @parent_right - @current_left;

        -- Обновляем правые границы всех элементов, которые правее
        UPDATE categories t SET rgt = rgt + @current_length
        WHERE rgt >= @current_left ORDER BY rgt;

        -- Обновляем левые границы всех элементов, которые правее
        UPDATE categories t SET lft = lft + @current_length
        WHERE lft > @current_left ORDER BY lft;

        -- И только сейчас обновляем границы текущего ряда
        SET @i := (@current_left - 1);
        UPDATE categories t SET lft = (@i := @i + 1), rgt = (@i := @i + 1)
        WHERE parent_id = @parent_id ORDER BY id;
    END LOOP;

    -- Возвращаем самый самую правую границу для дальнейшего использования
    RETURN (SELECT MAX(rgt) FROM categories t);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-18  3:13:15
