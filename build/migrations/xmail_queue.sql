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
-- Table structure for table `xmail_queue`
--

DROP TABLE IF EXISTS `xmail_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xmail_queue` (
  `pid` int(11) unsigned DEFAULT NULL COMMENT 'Queue ID',
  `storage` varchar(32) NOT NULL DEFAULT '' COMMENT 'Used storage adapter',
  `broker` varchar(32) NOT NULL DEFAULT '' COMMENT 'Used queue adapter',
  `mail` varchar(32) NOT NULL DEFAULT '' COMMENT 'Used mail adapter',
  `priority` tinyint(2) unsigned DEFAULT '0' COMMENT 'Queue priority',
  `date_activation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Activation date',
  UNIQUE KEY `pid` (`pid`,`storage`,`broker`,`mail`),
  KEY `idx_adapters` (`storage`,`broker`,`mail`),
  KEY `idx_priority` (`priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Mail queue list';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xmail_queue`
--

LOCK TABLES `xmail_queue` WRITE;
/*!40000 ALTER TABLE `xmail_queue` DISABLE KEYS */;
INSERT INTO `xmail_queue` VALUES (84493,'MySQL','Native','GMail',0,'2015-08-10 22:42:15');
/*!40000 ALTER TABLE `xmail_queue` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-12  3:57:59
