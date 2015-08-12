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
-- Table structure for table `xmail_stats`
--

DROP TABLE IF EXISTS `xmail_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xmail_stats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Record ID',
  `list_id` int(11) unsigned DEFAULT NULL COMMENT 'Mail list',
  `subject` varchar(255) NOT NULL DEFAULT '' COMMENT 'Subscriber name',
  `status` enum('ok','pending','failed','abort') NOT NULL DEFAULT 'pending' COMMENT 'Mailing status',
  `date_start` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Mailing start date',
  `date_finish` datetime DEFAULT NULL COMMENT 'Mailing finish date',
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_date_start` (`date_start`),
  KEY `idx_date_finish` (`date_finish`),
  KEY `idx_status_date_start` (`status`,`date_start`),
  KEY `idx_status_date_finish` (`status`,`date_finish`),
  KEY `fk_list_id` (`list_id`),
  CONSTRAINT `fk_list_id` FOREIGN KEY (`list_id`) REFERENCES `xmail_lists` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='Mailing status table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xmail_stats`
--

LOCK TABLES `xmail_stats` WRITE;
/*!40000 ALTER TABLE `xmail_stats` DISABLE KEYS */;
INSERT INTO `xmail_stats` VALUES (1,1,'MailSubject','pending','2015-07-11 02:18:05',NULL),(2,1,'MailSubject 7','pending','2015-07-11 02:18:05',NULL),(3,2,'MailSubject2','pending','2015-07-11 02:18:05',NULL),(4,3,'MailSubject3','ok','2015-07-11 02:18:05',NULL),(5,1,'MailSubject4','abort','2015-08-11 02:18:05',NULL),(6,2,'MailSubject5','pending','2015-07-11 02:18:05',NULL),(7,3,'MailSubject6','pending','2015-09-11 02:18:05',NULL);
/*!40000 ALTER TABLE `xmail_stats` ENABLE KEYS */;
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
