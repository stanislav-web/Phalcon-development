-- MySQL dump 10.13  Distrib 5.7.8-rc, for Linux (x86_64)
--
-- Host: localhost    Database: backend.local
-- ------------------------------------------------------
-- Server version	5.7.8-rc-log

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
-- Table structure for table `xmail_subscribers`
--

DROP TABLE IF EXISTS `xmail_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xmail_subscribers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Subscriber ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Subscriber name',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT 'Subscriber email',
  `state` enum('disabled','active','moderated') NOT NULL DEFAULT 'disabled' COMMENT 'Activity state, 0 - disabled, 1 - active, 2 - moderated',
  `date_registration` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Default subscriber reg date',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_email` (`email`),
  KEY `idx_state` (`state`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Subscriber''s list';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xmail_subscribers`
--

LOCK TABLES `xmail_subscribers` WRITE;
/*!40000 ALTER TABLE `xmail_subscribers` DISABLE KEYS */;
INSERT INTO `xmail_subscribers` VALUES (1,'Stanislav','stanisov@gmail.com','active','2015-07-11 02:18:05'),(2,'Administrator','admin@admin.ua	','disabled','2015-07-11 02:18:05'),(3,'Moderator	','realwmz@list.ru','active','2015-07-11 02:18:05'),(4,'Real','realwm@list.ru','active','2015-07-11 02:18:05'),(5,'Reds','reds@reds.go','disabled','2015-07-11 02:18:05');
/*!40000 ALTER TABLE `xmail_subscribers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-12  3:40:11
