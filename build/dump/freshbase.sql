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
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (84,'Авто','<p>Авто мото запчасти</p>','-',NULL,1,8,0,'2015-03-01 15:59:11','2015-03-02 22:07:42',1),(85,'Test Category','<p>adsdsdsd</p>','myAlias',84,2,3,2,'2015-03-01 18:12:56','2015-03-02 22:07:42',1),(86,'My Category','<p>asasas</p>','my-category',84,4,5,2,'2015-03-01 19:33:01','2015-03-02 22:07:42',1),(87,'Test Category','<p>Description</p>','my-alias2',84,6,7,0,'2015-03-01 19:41:22','2015-03-02 22:07:42',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES (1,'USD','USA Dollar','$'),(2,'RUR','Российский рубль','руб.'),(3,'EUR','Euro','€'),(4,'UAH','Украинская гривна','₴'),(5,'GBP','British Pound','£');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 MAX_ROWS=10;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `engines`
--

LOCK TABLES `engines` WRITE;
/*!40000 ALTER TABLE `engines` DISABLE KEYS */;
INSERT INTO `engines` VALUES (1,'Phalcon Shop','<p>This is the simple Phalcon Shop</p>','phalcon.local','PHL','logo-mysql-110x57.png',4,1,'2015-01-03 02:27:22','2015-02-23 00:58:12'),(6,'Test','<p>Desdc</p>','sss','SSS','',1,1,'2015-02-23 02:53:12','2015-02-23 00:53:12'),(7,'WWWW','<p>WWWWW</p>','WWWW','WWW','logo-mysql-110x57.png',1,1,'2015-02-23 02:53:59','2015-02-23 00:53:59');
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
INSERT INTO `engines_categories_rel` VALUES (1,84),(6,84),(1,85),(1,86),(1,87);
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
) ENGINE=ARCHIVE AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;


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
INSERT INTO `pages` VALUES (1,'About','<p>This is about page content. I am edit storage text. EDITED</p>','about','2015-01-22 00:30:05','2015-02-16 01:27:59'),(2,'Agreement','This is agreement page content','agreement','2015-01-22 00:32:41','2015-01-21 22:35:39'),(4,'Contacts','<p>This is contacs page content. EDITED</p>','contacts','2015-01-22 00:34:22','2015-02-16 01:31:18'),(5,'Help','<p>This is the help page</p>','help','2015-01-22 02:53:07','2015-01-22 00:54:47');
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
INSERT INTO `user_access` VALUES (10,'98d3e093ffdcc85479ff48d0a2a2aa6a','2015-02-24 00:35:41'),(11,'f0318c6e5aff1fbed8ad7412e103bc0b','2015-02-14 04:48:17'),(12,'78df0928b91ec774abb2a651d8c1ffab','2015-03-01 13:37:59'),(13,'c26e866b05c4b60b48968a55154187da','2015-02-15 14:36:58');
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='Common users table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (10,'stanisov@gmail.com','Stanislav','','$2a$08$FVBqaIVvJNT.vH.cG9SDFO.1MEEC6Bs8fKyBOvncO.d0ZOwZIR0BG','5700e9bc64cd54fe2d8993b09c3ff7a8',1,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36','2015-02-02 12:30:28','2015-02-22 21:11:36'),(11,'stanisovw@gmail.com','stanisovw@gmail.com','','$2a$08$gAQeAhVAYIPcaY9pTRYGMeStAuoPw29y5JnMjM9qSSlrofGz3ILO6','52c91b18128a854d7ba1d4b11290da83',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36','2015-02-21 04:31:14','2015-02-21 02:31:14'),(12,'stanisov2@gmail.com','stanisov2@gmail.com','','$2a$08$WLHJJKcAFndE7mtuqcEYeOaIIjcGikfK1zNjGAGcmDiWEU.ya9mSy','0f216e751ac2a739709108eebc8a40aa',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36','2015-02-22 13:37:59','2015-02-22 11:37:59'),(13,'stanisov3@gmail.com','stanisov3@gmail.com','','$2a$08$ffWFo.DHPzZC1El/tlDfb.e4v6eG1/UgtacL/adtjCAf0wXcRqbNK','45707bf7ff673c44cba7957ed9482b77',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36','2015-02-22 14:36:52','2015-02-22 12:36:52');
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

-- Dump completed on 2015-03-03  1:43:55
