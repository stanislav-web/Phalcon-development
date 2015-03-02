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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (1,'app',5,'Authenticate success from 127.0.0.1',1424219327),(2,'app',5,'Authenticate success from 127.0.0.1',1424219627),(3,'app',5,'Authenticate to CP success from 127.0.0.1',1424221311),(1,'app',4,'Authenticate failed from 127.0.0.1',1424463016),(2,'app',4,'Authenticate failed from 127.0.0.1',1424463023),(3,'app',4,'Invalid token has been catches by 127.0.0.1',1424471001),(4,'app',4,'Authenticate failed from 127.0.0.1',1424473899),(5,'app',4,'Authenticate failed from 127.0.0.1',1424473908),(6,'app',1,'DateTime::setTimezone() expects parameter 1 to be DateTimeZone, string given',1424473912),(7,'app',1,'DateTime::setTimezone() expects parameter 1 to be DateTimeZone, string given',1424473913),(8,'app',1,'DateTime::setTimezone() expects parameter 1 to be DateTimeZone, string given',1424473913),(9,'app',1,'DateTime::setTimezone() expects parameter 1 to be DateTimeZone, string given',1424473929),(10,'app',1,'DateTime::setTimezone() expects parameter 1 to be DateTimeZone, string given File: /var/www/phalcon.local/Application/Models/UserAccess.php Line:105',1424474154),(11,'app',1,'DateTime::setTimezone() expects parameter 1 to be DateTimeZone, string given File: /var/www/phalcon.local/Application/Models/UserAccess.php Line:108',1424474413),(12,'app',1,'DateTime::setTimezone() expects parameter 1 to be DateTimeZone, string given File: /var/www/phalcon.local/Application/Models/UserAccess.php Line:108',1424474435),(13,'app',1,'DateTime::setTimezone() expects parameter 1 to be DateTimeZone, string given File: /var/www/phalcon.local/Application/Models/UserAccess.php Line:107',1424474448),(14,'app',1,'Undefined property: Application\\Services\\AuthService::$message File: /var/www/phalcon.local/Application/Services/AuthService.php Line:342',1424474518),(15,'app',4,'Authenticate failed from 127.0.0.1',1424474579),(16,'app',4,'Authenticate failed from 127.0.0.1',1424474628),(17,'app',4,'Authenticate failed from 127.0.0.1',1424475195),(18,'app',4,'Authenticate failed from 127.0.0.1',1424475205),(19,'app',4,'Authenticate failed from 127.0.0.1',1424475716),(20,'app',4,'Authenticate failed from 127.0.0.1',1424475727),(21,'app',4,'Authenticate failed from 127.0.0.1',1424475728),(22,'app',4,'Authenticate failed from 127.0.0.1',1424475760),(23,'app',4,'Authenticate failed from 127.0.0.1',1424475761),(24,'app',4,'Authenticate failed from 127.0.0.1',1424475986),(25,'app',4,'Authenticate failed from 127.0.0.1',1424475992),(26,'app',4,'Authenticate failed from 127.0.0.1',1424476008),(27,'app',4,'Authenticate failed from 127.0.0.1',1424476014),(28,'app',4,'Authenticate failed from 127.0.0.1',1424476148),(29,'app',4,'Authenticate failed from 127.0.0.1',1424476150),(30,'app',4,'Authenticate failed from 127.0.0.1',1424476276),(31,'app',4,'Authenticate failed from 127.0.0.1',1424476276),(32,'app',4,'Authenticate failed from 127.0.0.1',1424476277),(33,'app',4,'Authenticate failed from 127.0.0.1',1424476277),(34,'app',4,'Authenticate failed from 127.0.0.1',1424476278),(35,'app',4,'Authenticate failed from 127.0.0.1',1424477157),(36,'app',4,'Authenticate failed from 127.0.0.1',1424477158),(37,'app',4,'Authenticate failed from 127.0.0.1',1424477199),(38,'app',4,'Authenticate failed from 127.0.0.1',1424477200),(39,'app',4,'Authenticate failed from 127.0.0.1',1424477205),(40,'app',4,'Authenticate failed from 127.0.0.1',1424477840),(41,'app',4,'Authenticate failed from 127.0.0.1',1424477854),(42,'app',4,'Authenticate failed from 127.0.0.1',1424477865),(43,'app',4,'Authenticate failed from 127.0.0.1',1424477883),(44,'app',4,'Authenticate failed from 127.0.0.1',1424477884),(45,'app',4,'Authenticate failed from 127.0.0.1',1424477911),(46,'app',4,'Authenticate failed from 127.0.0.1',1424477915),(47,'app',5,'Authenticate success from 127.0.0.1',1424477920),(48,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477921),(49,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477925),(50,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477926),(51,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477926),(52,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477927),(53,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477927),(54,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477927),(55,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477927),(56,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477927),(57,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477936),(58,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477936),(59,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477937),(60,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477937),(61,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477954),(62,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477955),(63,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477955),(64,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477959),(65,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477959),(66,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424477959),(67,'app',4,'Authenticate failed from 127.0.0.1',1424481648),(68,'app',4,'Authenticate failed from 127.0.0.1',1424481653),(69,'app',5,'Authenticate success from 127.0.0.1',1424481662),(70,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424481662),(71,'app',4,'Invalid token has been catches by 127.0.0.1',1424481996),(72,'app',4,'Authenticate failed from 127.0.0.1',1424482879),(73,'app',5,'Authenticate success from 127.0.0.1',1424482904),(74,'app',4,'Authenticate failed from 127.0.0.1',1424483037),(75,'app',5,'Authenticate success from 127.0.0.1',1424483055),(76,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424483055),(77,'app',4,'Authenticate failed from 127.0.0.1',1424483091),(78,'app',5,'Authenticate success from 127.0.0.1',1424483098),(79,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424483098),(80,'app',4,'Authenticate failed from 127.0.0.1',1424483182),(81,'app',4,'Authenticate failed from 127.0.0.1',1424483184),(82,'app',4,'Authenticate failed from 127.0.0.1',1424483187),(83,'app',4,'Authenticate failed from 127.0.0.1',1424483191),(84,'app',5,'Authenticate success from 127.0.0.1',1424483198),(85,'app',1,'array_key_exists() expects parameter 2 to be array, string given File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:146',1424483198),(86,'app',4,'Authenticate failed from 127.0.0.1',1424483762),(87,'app',5,'Authenticate success from 127.0.0.1',1424483767),(1,'app',4,'Registration failed from 127.0.0.1. CSRF attack',1424605029),(2,'app',4,'Registration failed from 127.0.0.1. CSRF attack',1424605033),(3,'app',4,'Registration failed from 127.0.0.1. CSRF attack',1424605046),(4,'app',4,'Registration failed from 127.0.0.1',1424605069),(5,'app',5,'Registration success from 127.0.0.1. User: 12',1424605079),(6,'app',1,'Could not find translate signature File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:152',1424606495),(7,'app',4,'Не верный токен! Перезагрузите пожалуйста',1424607914),(8,'app',4,'Пользователь не найден',1424607961),(9,'app',4,'Не верный пароль',1424607966),(10,'app',4,'Такой пользователь уже зарегистрирован IP: 127.0.0.1',1424608524),(11,'app',4,'NOT_FOUND IP: 127.0.0.1',1424612478),(12,'app',4,'NOT_FOUND IP: 127.0.0.1',1424612482),(13,'app',4,'NOT_FOUND IP: 127.0.0.1',1424612579),(14,'app',4,'Пользователь не найден IP: 127.0.0.1',1424612624),(15,'app',1,'View \'emails/restore_password\' was not found in the views directory File: /var/www/phalcon.local/vendor/phalcon/incubator/Library/Phalcon/Mailer/Manager.php Line:317',1424612714),(16,'app',1,'View \'phl/emails/restore_password\' was not found in the views directory File: /var/www/phalcon.local/vendor/phalcon/incubator/Library/Phalcon/Mailer/Manager.php Line:317',1424612768),(17,'app',1,'View \'views/phl/emails/restore_password\' was not found in the views directory File: /var/www/phalcon.local/vendor/phalcon/incubator/Library/Phalcon/Mailer/Manager.php Line:317',1424612778),(18,'app',1,'Argument 1 passed to Application\\Services\\ViewService::__construct() must be an instance of Application\\Models\\Engines, none given File: /var/www/phalcon.local/Application/Services/ViewService.php Line:38',1424612849),(19,'app',1,'View \'emails/restore_password\' was not found in the views directory File: /var/www/phalcon.local/vendor/phalcon/incubator/Library/Phalcon/Mailer/Manager.php Line:317',1424612879),(20,'app',1,'Expected response code 235 but got code \"535\", with message \"535-5.7.8 Username and Password not accepted. Learn more at\r\n535 5.7.8 http://support.google.com/mail/bin/answer.py?answer=14257 f9sm6621366laa.20 - gsmtp\r\n\" File: /var/www/phalcon.local/Application/Services/MailSMTPExceptions.php Line:62',1424612888),(21,'app',4,'Вы оставили пустым логин IP: 127.0.0.1',1424615838),(22,'app',4,'Логин должен быть не менее 3 символов IP: 127.0.0.1',1424615838),(23,'app',4,'Имя не должно быть менее 2 символов IP: 127.0.0.1',1424615838),(24,'app',4,'Логин должен быть как электронная почта или телефонный номер IP: 127.0.0.1',1424615838),(25,'app',4,'Вы оставили пустым логин IP: 127.0.0.1',1424615847),(26,'app',4,'Логин должен быть не менее 3 символов IP: 127.0.0.1',1424615847),(27,'app',4,'Имя не должно быть менее 2 символов IP: 127.0.0.1',1424615847),(28,'app',4,'Логин должен быть как электронная почта или телефонный номер IP: 127.0.0.1',1424615847),(29,'app',4,'Record cannot be updated because it does not exist IP: 127.0.0.1',1424615917),(30,'app',4,'Record cannot be updated because it does not exist IP: 127.0.0.1',1424616031),(31,'app',4,'Не верный пароль IP: 127.0.0.1',1424616126),(32,'app',4,'Пользователь не найден IP: 127.0.0.1',1424616619),(33,'app',4,'Не удолось восстановить доступ. Проблемы с отправкой сообщений IP: 127.0.0.1',1424616945),(34,'app',1,'The collection does not exist in the manager File: /var/www/phalcon.local/Application/Modules/Frontend/views/phl/layout.phtml Line:28',1424617527),(35,'app',1,'The collection does not exist in the manager File: /var/www/phalcon.local/Application/Modules/Frontend/views/phl/layout.phtml Line:28',1424617800),(36,'app',1,'The collection does not exist in the manager File: /var/www/phalcon.local/Application/Modules/Frontend/views/phl/layout.phtml Line:28',1424617837),(37,'app',1,'The collection does not exist in the manager File: /var/www/phalcon.local/Application/Modules/Frontend/views/phl/layout.phtml Line:28',1424617850),(38,'app',1,'The collection does not exist in the manager File: /var/www/phalcon.local/Application/Modules/Frontend/views/phl/layout.phtml Line:28',1424618049),(39,'app',1,'The collection does not exist in the manager File: /var/www/phalcon.local/Application/Modules/Frontend/views/phl/layout.phtml Line:28',1424618085),(40,'app',1,'The collection does not exist in the manager File: /var/www/phalcon.local/Application/Modules/Frontend/views/phl/layout.phtml Line:28',1424618208),(41,'app',1,'The collection does not exist in the manager File: /var/www/phalcon.local/Application/Modules/Frontend/views/phl/layout.phtml Line:28',1424618310),(42,'app',1,'The collection does not exist in the manager File: /var/www/phalcon.local/Application/Modules/Frontend/views/phl/layout.phtml Line:28',1424618326),(43,'app',1,'Array to string conversion File: /var/www/phalcon.local/Application/Services/AuthService.php Line:618',1424618401),(44,'app',1,'Array to string conversion File: /var/www/phalcon.local/Application/Services/AuthService.php Line:618',1424618418),(45,'app',4,'Не удолось восстановить доступ. Проблемы с отправкой сообщений IP: 127.0.0.1',1424618545),(1,'app',1,'Expected response code 235 but got code \"535\", with message \"535-5.7.8 Username and Password not accepted. Learn more at\r\n535 5.7.8 http://support.google.com/mail/bin/answer.py?answer=14257 wt7sm922372lbb.24 - gsmtp\r\n\" File: /var/www/phalcon.local/Application/Services/MailSMTPExceptions.php Line:62',1424639424),(2,'app',1,'Expected response code 235 but got code \"535\", with message \"535-5.7.8 Username and Password not accepted. Learn more at\r\n535 5.7.8 http://support.google.com/mail/bin/answer.py?answer=14257 ch1sm6819323lbb.40 - gsmtp\r\n\" File: /var/www/phalcon.local/Application/Services/MailSMTPExceptions.php Line:62',1424639432),(3,'app',4,'Не верный пароль IP: 127.0.0.1',1424646835),(4,'app',4,'Не верный пароль IP: 127.0.0.1',1424646840),(5,'app',4,'Пользователь не найден IP: 127.0.0.1',1424646843),(6,'app',4,'Не верный пароль IP: 127.0.0.1',1424646886),(7,'app',4,'Не верный пароль IP: 127.0.0.1',1424646888),(8,'app',4,'Не верный пароль IP: 127.0.0.1',1424646889),(9,'app',4,'Не верный пароль IP: 127.0.0.1',1424646895),(10,'app',6,'Engine `asasas`` assigned by 127.0.0.1',1424652631),(11,'app',6,'Engine `Test`` assigned by 127.0.0.1',1424652792),(12,'app',6,'Engine `WWWW`` assigned by 127.0.0.1',1424652839),(13,'app',3,'404 Page detected: /agreement from IP: 127.0.0.1',1424653443),(14,'app',3,'404 Page detected: /error/notfound from IP: 127.0.0.1',1424653443),(15,'app',3,'404 Page detected: /help from IP: 127.0.0.1',1424653445),(16,'app',3,'404 Page detected: /error/notfound from IP: 127.0.0.1',1424653445),(17,'app',3,'404 Page detected: /contacts from IP: 127.0.0.1',1424653447),(18,'app',3,'404 Page detected: /error/notfound from IP: 127.0.0.1',1424653447),(19,'app',3,'404 Page detected: /error/notfound from IP: 127.0.0.1',1424730334),(20,'Backend',4,'Не верный пароль IP: 127.0.0.1',1424730900),(21,'Backend',4,'Не верный пароль IP: 127.0.0.1',1424731043),(22,'Backend',4,'Не верный пароль IP: 127.0.0.1',1424731109),(23,'Backend',4,'Не верный пароль IP: 127.0.0.1',1424731464),(24,'Backend',4,'Не верный пароль IP: 127.0.0.1',1424731488),(25,'Backend',4,'Не верный пароль IP: 127.0.0.1',1424731490),(26,'Backend',4,'Не верный пароль IP: 127.0.0.1',1424731492),(27,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735242),(28,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735242),(29,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735243),(30,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735243),(31,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735273),(32,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735273),(33,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735273),(34,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735273),(35,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735280),(36,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735280),(37,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735280),(38,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735280),(39,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735296),(40,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735296),(41,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735296),(42,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735296),(43,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735332),(44,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735332),(45,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735332),(46,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735332),(47,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735334),(48,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735334),(49,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735334),(50,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735334),(51,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735344),(52,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735344),(53,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735344),(54,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735344),(55,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735419),(56,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735419),(57,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735419),(58,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735419),(59,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735446),(60,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735446),(61,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735446),(62,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735446),(63,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735447),(64,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735447),(65,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735447),(66,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735447),(67,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735472),(68,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735472),(69,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735472),(70,'Frontend',3,'404 Page detected: /assets/plugins/datatable/swf/copy_csv_xls_pdf.swf from IP: 127.0.0.1',1424735472),(71,'Backend',4,'Не верный пароль IP: 127.0.0.1',1425075119),(72,'Backend',6,'Delete category #29 by 127.0.0.1',1425075826),(73,'Backend',6,'Delete category #30 by 127.0.0.1',1425075833),(74,'Backend',6,'Delete category #22 by 127.0.0.1',1425075841),(75,'Backend',6,'Delete category #23 by 127.0.0.1',1425075846),(76,'Backend',6,'Delete category #24 by 127.0.0.1',1425075851),(77,'Backend',6,'Delete category #28 by 127.0.0.1',1425077665),(78,'Backend',6,'Delete category #31 by 127.0.0.1',1425081355),(1,'Frontend',3,'404 Page detected: /error/notfound from IP: 127.0.0.1',1425333951),(2,'Frontend',3,'404 Page detected: /error/notfound from IP: 127.0.0.1',1425333952),(3,'Frontend',3,'404 Page detected: /error/notfound from IP: 127.0.0.1',1425333952),(4,'Frontend',3,'404 Page detected: /error/notfound from IP: 127.0.0.1',1425333952),(5,'Frontend',3,'404 Page detected: /error/notfound from IP: 127.0.0.1',1425333953),(6,'Frontend',3,'404 Page detected: /error/notfound from IP: 127.0.0.1',1425333953),(7,'Backend',4,'Не верный пароль IP: 127.0.0.1',1425333961),(8,'Frontend',4,'Не верный пароль IP: 127.0.0.1',1425335789),(9,'Frontend',4,'Не верный пароль IP: 127.0.0.1',1425335802),(10,'Frontend',4,'Invalid request token! Reload please IP: 127.0.0.1',1425338082),(11,'Frontend',1,'Could not find translate signature File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:152',1425338621),(12,'Frontend',1,'Could not find translate signature File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:152',1425338639),(13,'Frontend',4,'Invalid request token! Reload please IP: 127.0.0.1',1425338709),(14,'Frontend',1,'Could not find translate signature File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:152',1425338845),(15,'Frontend',1,'Could not find translate signature File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:152',1425339079),(16,'Frontend',1,'Could not find translate signature File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:152',1425339131),(17,'Frontend',4,'Invalid request token! Reload please IP: 127.0.0.1',1425339231),(18,'Frontend',4,'Invalid request token! Reload please IP: 127.0.0.1',1425339313),(19,'Frontend',4,'Invalid request token! Reload please IP: 127.0.0.1',1425339429),(20,'Frontend',4,'Invalid request token! Reload please IP: 127.0.0.1',1425339440),(21,'Frontend',4,'Invalid request token! Reload please IP: 127.0.0.1',1425339450),(22,'Frontend',4,'Invalid request token! Reload please IP: 127.0.0.1',1425339464),(23,'Frontend',4,'Не верный токен! Перезагрузите пожалуйста IP: 127.0.0.1',1425339480),(24,'Frontend',1,'Could not find translate signature File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:152',1425339492),(25,'Frontend',1,'Could not find translate signature File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:152',1425339499),(26,'Frontend',1,'Could not find translate signature File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:152',1425339507),(27,'Frontend',1,'Could not find translate signature File: /var/www/phalcon.local/vendor/stanislav-web/phalcon-translate/src/Translate/Translator.php Line:152',1425339519),(28,'Frontend',4,'Не верный токен! Перезагрузите пожалуйста IP: 127.0.0.1',1425339532),(29,'Frontend',4,'Invalid request token! Reload please IP: 127.0.0.1',1425339545),(30,'Frontend',4,'Invalid request token! Reload please IP: 127.0.0.1',1425339610),(31,'Frontend',4,'Invalid request token! Reload please IP: 127.0.0.1',1425339622),(32,'Frontend',4,'Invalid request token! Reload please IP: 127.0.0.1',1425339644),(33,'Frontend',4,'Invalid request token! Reload please IP: 127.0.0.1',1425339676),(34,'Frontend',4,'Invalid request token! Reload please IP: 127.0.0.1',1425339724);
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
