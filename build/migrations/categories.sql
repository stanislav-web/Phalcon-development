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
  `translate` varchar(32) DEFAULT NULL COMMENT 'Translate category',
  `engine_id` tinyint(2) unsigned NOT NULL COMMENT 'Engine ID rel',
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Create date',
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Update date',
  PRIMARY KEY (`id`),
  KEY `idx_rgt` (`rgt`),
  KEY `idx_lft` (`lft`),
  KEY `fk_category_engine_idx` (`engine_id`),
  KEY `idx_alias` (`alias`),
  CONSTRAINT `fk_category_engine` FOREIGN KEY (`engine_id`) REFERENCES `engines` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COMMENT='Display categories tree for each engine';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Недвижимость','Содержит базы агентств недвижимости Харькова и доску объявлений по продаже и аренде квартир, домов, земельных участков, коммерческих объектов в Харьковской области, и обмену жилья.','nedvizhimost',NULL,1,28,1,'REAL_ESTATE',1,'2015-04-18 06:08:31','2015-05-31 22:01:08'),(2,'Работа','Найти работу в Харькове теперь просто. Поиск вакансий по запросу, разделам, рассылка новых вакансий.','rabota',NULL,29,60,2,'WORK',1,'2015-04-18 06:09:19','2015-05-31 22:02:25'),(3,'Транспорт','Объявления о купле продаже любых транспортных систем в Харькове и области','transport',NULL,61,84,3,'TRANSPORT',1,'2015-04-18 06:09:11','2015-05-31 22:04:29'),(4,'Электроника','Продажа бытовой техники. На доске объявлений легко и быстро можно купить бытовую технику б/у. Покупай лучшую технику для дома','electronica',NULL,85,96,4,'ELECTRONICS',1,'2015-04-21 12:29:52','2015-05-31 22:06:20'),(5,'Спорт','','sport',NULL,97,98,5,'SPORT',1,'2015-04-21 12:30:26','2015-05-01 23:41:01'),(6,'Мода','','fashion',NULL,99,100,6,'FASHION',1,'2015-04-21 12:30:58','2015-05-01 23:41:01'),(7,'Детский мир','','baby',NULL,101,102,7,'BABY',1,'2015-04-21 12:31:19','2015-05-04 21:23:09'),(8,'Дом и досуг','','house',NULL,103,104,8,'HOUSE',1,'2015-04-21 12:31:28','2015-05-04 21:24:07'),(9,'Коллекции','','collections',NULL,105,106,9,'COLLECTIONS',1,'2015-04-21 12:31:44','2015-05-01 23:41:01'),(10,'Спец проекты','','special',NULL,107,108,10,'SPECIAL',1,'2015-04-21 12:32:00','2015-05-01 23:41:01'),(11,'Видеорегистраторы','','dvrs',1,2,3,1,'DVRS',1,'2015-04-24 18:22:46','2015-05-01 23:41:01'),(12,'GPS устройства','','gps_devices',1,4,5,2,'GPS',1,'2015-04-24 18:23:12','2015-05-01 23:41:01'),(13,'Автомагнитолы','','receivers',1,6,7,3,'RECEIVERS',1,'2015-04-24 18:23:47','2015-05-01 23:41:01'),(14,'Светотехника','','lighting_engineering',1,8,9,4,'LIGHTING_ENGINEERING',1,'2015-04-24 18:24:08','2015-05-01 23:41:01'),(15,'Шины','','tires',1,10,11,5,'TIRES',1,'2015-04-24 18:24:40','2015-05-01 23:41:01'),(16,'Диски, колпаки','','wheels-dust_shields',1,12,13,6,'WHEELS',1,'2015-04-24 18:25:06','2015-05-01 23:41:01'),(17,'Электрика, автоприборы','','electrician-autodevice',1,14,15,7,'AUTODEVICES',1,'2015-04-24 18:26:08','2015-05-01 23:41:01'),(18,'Аудио-Видео, автозвук','','audio-video_car_audio',1,16,17,8,'AUDIO-VIDEO',1,'2015-04-24 18:26:50','2015-05-01 23:41:01'),(19,'Оборудование для СТО','','service_station_equipment',1,18,19,9,'SERVICE_STATION',1,'2015-04-24 18:27:27','2015-05-01 23:41:01'),(20,'Автозапчасти','','autospare_parts',1,20,21,10,'AUTOSPARE_PARTS',1,'2015-04-24 18:28:01','2015-05-01 23:41:01'),(21,'Автоаксессуары','','accessories',1,22,23,11,'ACCESSORIES',1,'2015-04-24 18:28:25','2015-05-01 23:41:01'),(22,'Мототовары','','supplies',1,24,25,12,'SUPPLIES',1,'2015-04-24 18:28:43','2015-05-01 23:41:01'),(23,'Тюнинг','','tuning',1,26,27,13,'TUNNING',1,'2015-04-24 18:30:02','2015-05-01 23:41:01'),(24,'Телефоны, смартфоны','','phones_smart_phones',2,30,49,1,'PHONES_SMARTPHONES',1,'2015-04-24 18:31:30','2015-05-01 23:41:01'),(25,'Аксессуары и комплектующие','','accessories_components',2,50,59,2,'ACCESSORIES_COMPONENTS',1,'2015-04-24 18:31:58','2015-05-01 23:41:01'),(26,'Планшеты','','tablet',3,62,63,0,'TABLET_PC',1,'2015-04-28 13:48:15','2015-05-01 23:41:01'),(27,'Аксессуары к планшетам','','accessories_tablet',3,64,65,0,'ACCESSORIES_TABLET',1,'2015-04-28 13:48:54','2015-05-01 23:41:01'),(28,'Ноутбуки','','notebooks1',3,66,67,0,'NOTEBOOKS',1,'2015-04-28 13:49:32','2015-05-01 23:41:01'),(29,'Комплектующие для ноутбуков','','notebooks_components',3,68,69,0,'NOTEBOOKS_COMPONENTS',1,'2015-04-28 13:50:02','2015-05-01 23:41:01'),(30,'Системные блоки, ПК','','systems',3,70,71,0,'SYSTEMS',1,'2015-04-28 13:50:26','2015-05-01 23:41:01'),(31,'Мониторы','','monitors',3,72,73,0,'MONITORS',1,'2015-04-28 13:50:46','2015-05-01 23:41:01'),(32,'Мыши и клавиатуры','','mouses_keyboards',3,74,75,0,'MOUSES_KEYBOARDS',1,'2015-04-28 13:51:07','2015-05-01 23:41:01'),(33,'Комплектующие для ПК','','pc_components',3,76,77,0,'PC_COMPONENTS',1,'2015-04-28 13:51:34','2015-05-01 23:41:01'),(34,'Сетевое оборудование','','network_equipments',3,78,79,0,'NETWORK_EQUIPMENTS',1,'2015-04-28 13:52:01','2015-05-01 23:41:01'),(35,'Флешки, внешние HDD','','flash_memories',3,80,81,0,'FLASH_MEMORIES_HDD',1,'2015-04-28 13:52:33','2015-05-01 23:41:01'),(36,'PlayStation, Xbox','','playstation_xbox',3,82,83,0,'PLAYSTATION',1,'2015-04-28 13:52:53','2015-05-01 23:41:01'),(37,'Apple iPhone','','apple_iphone',24,31,32,0,'APPLE_IPHONE',1,'2015-05-02 02:26:37','2015-05-01 23:41:01'),(38,'Lenovo','','lenovo',24,33,34,0,'LENOVO',1,'2015-05-02 02:26:37','2015-05-01 23:41:01'),(39,'Nokia','','nokia',24,35,36,0,'NOKIA',1,'2015-05-02 02:26:37','2015-05-01 23:41:01'),(40,'Samsung','','samsung',24,37,38,0,'SAMSUNG',1,'2015-05-02 02:26:37','2015-05-01 23:41:01'),(41,'HTC','','htc',24,39,40,0,'HTC',1,'2015-05-02 02:26:37','2015-05-01 23:41:01'),(42,'Jiayu','','jiayu',24,41,42,0,'JIAYU',1,'2015-05-02 02:26:37','2015-05-01 23:41:01'),(43,'Motorola','','motorola',24,43,44,0,'MOTOROLLA',1,'2015-05-02 02:26:37','2015-07-20 23:05:30'),(44,'LG','','lg',24,45,46,0,'LG',1,'2015-05-02 02:26:37','2015-05-01 23:41:01'),(45,'Sony Ericsson','','sony_ericsson',24,47,48,0,'SONY ERICSSON',1,'2015-05-02 02:26:37','2015-05-01 23:41:01'),(46,'Чехлы и футляры','','covers_and_cases',25,51,52,0,'COVERS_AND_CASES',1,'2015-05-02 02:26:37','2015-05-01 23:41:01'),(47,'Карты памяти','','memory_cards',25,53,54,0,'MEMORY_CARDS',1,'2015-05-02 02:26:37','2015-05-01 23:41:01'),(48,'Дисплеи, сенсорные экраны','','displays_and_touchpads',25,55,56,0,'DISPLAYS_AND_TOUCHPADS',1,'2015-05-02 02:26:37','2015-05-01 23:41:01'),(49,'Аккумуляторы','','batteries',25,57,58,0,'BATTERIES',1,'2015-05-02 02:26:37','2015-07-20 23:05:30'),(50,'Бытовая техника','','white_goods',4,86,87,0,'WHITE_GOODS',1,'2015-05-02 02:26:37','2015-07-20 23:05:30'),(51,'ТВ, Видео','','tv_and_video',4,88,89,0,'TV_AND_VIDEO',1,'2015-05-02 02:26:37','2015-05-01 23:41:01'),(52,'Аудио, Радио','','audio_and_radio',4,90,91,0,'AUDIO_RADIO',1,'2015-05-02 02:26:37','2015-05-01 23:41:01'),(53,'Фототехника и Оптика','','photographic_and_optics',4,92,93,0,'PHOTOGRAPHIC_AND_OPTICS',1,'2015-05-02 02:26:37','2015-05-01 23:41:01'),(54,'Музыкальные инструменты','','musical_instruments',4,94,95,0,'MUSICAL_INSTRUMENTS',1,'2015-05-02 02:26:37','2015-05-01 23:41:01'),(55,'Дом, интерьер','','house_interier',8,NULL,NULL,0,'HOUSE_INTERIER',1,'2015-05-05 00:34:09','2015-05-04 21:34:09'),(56,'Всё для ремонта, инструменты','','repair_instruments',8,NULL,NULL,0,'REPAIR_INSTRUMENTS',1,'2015-05-05 00:34:09','2015-05-04 21:34:09'),(57,'Рукоделие','','handmade',8,NULL,NULL,0,'HANDMADE',1,'2015-05-05 00:34:09','2015-05-04 21:34:09'),(58,'Дача сад огород','','bower',8,NULL,NULL,0,'BOWER',1,'2015-05-05 00:34:09','2015-05-04 21:34:09'),(59,'Животные и растения','','animals',8,NULL,NULL,0,'ANIMALS',1,'2015-05-05 00:34:09','2015-05-04 21:34:09'),(60,'Сувениры и канцтовары','','gifts_stationery',8,NULL,NULL,0,'GIFTS',1,'2015-05-05 00:34:09','2015-05-04 21:34:09'),(61,'Музыка фильмы видео','','music_films_video',8,NULL,NULL,0,'MUSIC_FILMS_VIDEO',1,'2015-05-05 00:34:09','2015-05-04 21:34:09'),(62,'Все для кухни','','kitchen',8,NULL,NULL,0,'KITCHEN',1,'2015-05-05 00:34:09','2015-05-04 21:34:09'),(63,'Мебель','','furniture',8,NULL,NULL,0,'FURNITURE',1,'2015-05-05 00:34:09','2015-05-04 21:34:09'),(64,'Электроинструменты','','power',8,NULL,NULL,0,'POWER',1,'2015-05-05 00:34:09','2015-05-04 21:34:09');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-09  3:22:37
