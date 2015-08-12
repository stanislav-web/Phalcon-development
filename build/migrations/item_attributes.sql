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
-- Table structure for table `item_attributes`
--

DROP TABLE IF EXISTS `item_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_attributes` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT 'Item attributes table',
  `translate` varchar(32) DEFAULT NULL,
  `integer` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `decimal` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `varchar` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_integer` (`integer`),
  KEY `idx_decimal` (`decimal`),
  KEY `idx_varchar` (`varchar`),
  KEY `idx_date` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_attributes`
--

LOCK TABLES `item_attributes` WRITE;
/*!40000 ALTER TABLE `item_attributes` DISABLE KEYS */;
INSERT INTO `item_attributes` VALUES (1,'Цвет','COLOR',0,0,1,0,'2015-05-05 01:10:52','2015-05-04 22:29:08'),(2,'Город','CITY',0,0,1,0,'2015-05-05 01:19:09','2015-05-04 22:29:08'),(3,'Срок годности','EXPIRATION_DATE',1,0,0,0,'2015-05-05 01:19:09','2015-05-04 22:29:08'),(4,'Материал','MATERIAL',0,0,1,0,'2015-05-05 01:19:09','2015-05-04 22:29:08'),(5,'Тип','TYPE',0,0,1,0,'2015-05-05 01:19:09','2015-05-04 22:29:08'),(6,'Формат','FORMAT',0,0,1,0,'2015-05-05 01:19:09','2015-05-04 22:29:08'),(7,'Прочность','STRENGTH',0,0,1,0,'2015-05-05 01:19:09','2015-05-04 22:29:08'),(8,'Плотность','DENSITY',0,0,1,0,'2015-05-05 01:19:09','2015-05-04 22:29:08'),(9,'Дата изготовления','MANUFACTURE_DATE',0,0,0,1,'2015-05-05 01:19:09','2015-05-04 22:29:08'),(10,'Породая','BREED',0,0,1,0,'2015-05-05 01:19:09','2015-05-04 22:29:08'),(11,'Камера','CAMERA',0,0,1,0,'2015-05-05 01:19:09','2015-05-04 22:29:08'),(12,'Дагональ','DIAGONAL',0,0,1,0,'2015-05-05 01:19:09','2015-05-04 22:29:31'),(13,'Крепления','FIXING',0,0,1,0,'2015-05-05 01:19:09','2015-05-04 22:29:40'),(14,'Совместимость','COMPABILITY',0,0,1,0,'2015-05-05 01:19:09','2015-05-04 22:29:08'),(15,'Марка','MARK',0,0,1,0,'2015-05-05 01:19:09','2015-05-04 22:29:08'),(16,'Модель','MODEL',0,0,1,0,'2015-05-05 01:19:09','2015-05-04 22:29:08');
/*!40000 ALTER TABLE `item_attributes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-12  3:40:12
