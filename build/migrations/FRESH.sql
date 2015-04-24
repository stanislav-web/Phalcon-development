# ************************************************************
# Sequel Pro SQL dump
# Версия 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Адрес: 127.0.0.1 (MySQL 5.6.22)
# Схема: phalcon.local
# Время создания: 2015-04-24 17:43:32 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Дамп таблицы categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

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
  UNIQUE KEY `uni_alias` (`alias`),
  KEY `idx_rgt` (`rgt`),
  KEY `idx_lft` (`lft`),
  KEY `fk_category_engine_idx` (`engine_id`),
  CONSTRAINT `fk_category_engine` FOREIGN KEY (`engine_id`) REFERENCES `engines` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `title`, `description`, `alias`, `parent_id`, `lft`, `rgt`, `sort`, `translate`, `engine_id`, `date_create`, `date_update`)
VALUES
	(1,'Авто','','auto',NULL,1,28,1,'AUTO',1,'2015-04-18 06:08:31','2015-04-24 20:40:32'),
	(2,'Телефоны','','phones',NULL,29,34,2,'PHONES',1,'2015-04-18 06:09:19','2015-04-24 20:40:35'),
	(3,'Ноутбуки','','notebooks',NULL,35,36,3,'NOTEBOOKS',1,'2015-04-18 06:09:11','2015-04-24 20:40:39'),
	(4,'Техника','','equipment',NULL,37,38,4,'EQUIPMENT',1,'2015-04-21 12:29:52','2015-04-24 20:40:47'),
	(5,'Спорт','','sport',NULL,39,40,5,'SPORT',1,'2015-04-21 12:30:26','2015-04-24 20:40:50'),
	(6,'Мода','','fashion',NULL,41,42,6,'FASHION',1,'2015-04-21 12:30:58','2015-04-24 20:40:55'),
	(7,'Детский','','baby',NULL,43,44,7,'BABY',1,'2015-04-21 12:31:19','2015-04-24 20:41:02'),
	(8,'Дом','','house',NULL,45,46,8,'HOUSE',1,'2015-04-21 12:31:28','2015-04-24 20:41:04'),
	(9,'Коллекции','','collections',NULL,47,48,9,'COLLECTIONS',1,'2015-04-21 12:31:44','2015-04-24 20:41:09'),
	(10,'Спец проекты','','special',NULL,49,50,10,'SPECIAL',1,'2015-04-21 12:32:00','2015-04-24 20:41:13'),
	(11,'Видеорегистраторы','','dvrs',1,2,3,1,'DVRS',1,'2015-04-24 18:22:46','2015-04-24 20:41:17'),
	(12,'GPS устройства','','gps_devices',1,4,5,2,'GPS',1,'2015-04-24 18:23:12','2015-04-24 20:41:21'),
	(13,'Автомагнитолы','','receivers',1,6,7,3,'RECEIVERS',1,'2015-04-24 18:23:47','2015-04-24 20:41:28'),
	(14,'Светотехника','','lighting_engineering',1,8,9,4,'LIGHTING_ENGINEERING',1,'2015-04-24 18:24:08','2015-04-24 20:41:41'),
	(15,'Шины','','tires',1,10,11,5,'TIRES',1,'2015-04-24 18:24:40','2015-04-24 20:41:46'),
	(16,'Диски, колпаки','','wheels-dust_shields',1,12,13,6,'WHEELS',1,'2015-04-24 18:25:06','2015-04-24 20:41:50'),
	(17,'Электрика, автоприборы','','electrician-autodevice',1,14,15,7,'AUTODEVICES',1,'2015-04-24 18:26:08','2015-04-24 20:42:00'),
	(18,'Аудио-Видео, автозвук','','audio-video_car_audio',1,16,17,8,'AUDIO-VIDEO',1,'2015-04-24 18:26:50','2015-04-24 20:42:08'),
	(19,'Оборудование для СТО','','service_station_equipment',1,18,19,9,'SERVICE_STATION',1,'2015-04-24 18:27:27','2015-04-24 20:42:17'),
	(20,'Автозапчасти','','autospare_parts',1,20,21,10,'AUTOSPARE_PARTS',1,'2015-04-24 18:28:01','2015-04-24 20:42:25'),
	(21,'Автоаксессуары','','accessories',1,22,23,11,'ACCESSORIES',1,'2015-04-24 18:28:25','2015-04-24 20:42:30'),
	(22,'Мототовары','','supplies',1,24,25,12,'SUPPLIES',1,'2015-04-24 18:28:43','2015-04-24 20:42:34'),
	(23,'Тюнинг','','tuning',1,26,27,13,'TUNNING',1,'2015-04-24 18:30:02','2015-04-24 20:42:39'),
	(24,'Телефоны, смартфоны','','phones_smart_phones',2,30,31,1,'PHONES_SMARTPHONES',1,'2015-04-24 18:31:30','2015-04-24 20:42:48'),
	(25,'Аксессуары и комплектующие','','accessories_components',2,32,33,2,'ACCESSORIES_COMPONENTS',1,'2015-04-24 18:31:58','2015-04-24 20:42:57');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы currency
# ------------------------------------------------------------

DROP TABLE IF EXISTS `currency`;

CREATE TABLE `currency` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Currency ID',
  `code` char(3) NOT NULL COMMENT 'Currency Code',
  `name` varchar(45) NOT NULL,
  `symbol` varchar(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_code` (`code`) COMMENT 'Unique code'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;

INSERT INTO `currency` (`id`, `code`, `name`, `symbol`)
VALUES
	(1,'USD','USA Dollar','$'),
	(2,'RUR','Российский рубль','руб.'),
	(3,'EUR','Euro','€'),
	(4,'UAH','Украинская гривна','₴'),
	(5,'GBP','British Pound','£'),
	(6,'JPY','Японская иена','¥');

/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы engines
# ------------------------------------------------------------

DROP TABLE IF EXISTS `engines`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 MAX_ROWS=10;

LOCK TABLES `engines` WRITE;
/*!40000 ALTER TABLE `engines` DISABLE KEYS */;

INSERT INTO `engines` (`id`, `name`, `description`, `host`, `code`, `logo`, `currency_id`, `status`, `date_create`, `date_update`)
VALUES
	(1,'Phalcon Shop','<p>This is the simple Phalcon Shop</p>','phalcon.local','PHL','logo-mysql-110x57.png',4,1,'2015-01-03 02:27:22','2015-03-21 14:50:11'),
	(10,'eBay','<p>ebay Description2</p>','ebay.com','EBY','eBay-Logo.gif',1,2,'2015-03-06 12:24:17','2015-03-06 23:23:31');

/*!40000 ALTER TABLE `engines` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы errors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `errors`;

CREATE TABLE `errors` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Error ID',
  `code` varchar(65) NOT NULL DEFAULT '' COMMENT 'Error Code',
  `description` text NOT NULL COMMENT 'Description',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_code` (`code`) COMMENT 'Unique code'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `errors` WRITE;
/*!40000 ALTER TABLE `errors` DISABLE KEYS */;

INSERT INTO `errors` (`id`, `code`, `description`)
VALUES
	(1,'RECORDS_NOT_FOUND','Means that the requested record does not exist'),
	(2,'FILTERS_IS_NOT_SUPPORT','Means that you can not use this filter in the query string'),
	(3,'LANGUAGE_IS_NOT_SUPPORT','Means that you specify the localization is not used in our system'),
	(4,'EMPTY_PARAMETER_IN_URI','Means that you can not use the argument of the query string without its value'),
	(5,'INVALID_COLUMNS','Means that in a query, you can not do the sample for the specified fields'),
	(6,'INVALID_REQUIRED_FIELDS','Means that in a query, you must use the specified fields'),
	(7,'LONG_REQUEST','Means that the query string is too big for the request'),
	(8,'CONTENT_IS_NOT_SUPPORT','Means that you requested content type is not supported in the system'),
	(9,'AUTH_ACCESS_REQUIRED','Means that the requested resource requires authorization by token'),
	(10,'ACCESS_DENIED','Means that the need for the requested resource rights that you do not have'),
	(11,'UNAUTHORIZED_REQUEST','Means that the server rejected your request because you are not using the correct data authorization\n'),
	(12,'USER_NOT_FOUND','Means that the user you have requested the system does not have'),
	(13,'USER_EXIST','Means that you are trying to add a user to a system that already exists in'),
	(14,'LOGIN_REQUIRED','Means that the login is absolutely necessary'),
	(15,'PASSWORD_REQUIRED','Means that the password is absolutely necessary'),
	(16,'LOGIN_MAX_INVALID','Means that the login is too large'),
	(17,'LOGIN_MIX_INVALID','Means that the login is too small'),
	(18,'NAME_MAX_INVALID','Means that the name is too large'),
	(19,'NAME_MIN_INVALID','Means that the name is too small'),
	(20,'LOGIN_FORMAT_INVALID','Means that the login have not correct format. Note the error message and bring it to the specified format'),
	(21,'FIELD_IS_REQUIRED','Means that you may have missed the parameters that are necessary to update or add records'),
	(22,'RECOVERY_ACCESS_FAILED','Fail restore user access. May be service temporary unavailable. Try again later'),
	(23,'TO_MANY_REQUESTS','Request limit is exhausted '),
	(24,'HOST_NOT_FOUND','Requested host not found');

/*!40000 ALTER TABLE `errors` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `logs`;

CREATE TABLE `logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `content` varchar(512) NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=ARCHIVE DEFAULT CHARSET=utf8;

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;

INSERT INTO `logs` (`id`, `name`, `type`, `content`, `created_at`)
VALUES
	(55,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/logs',1429609016),
	(56,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/ErrorMapper.php Line:39',1429612147),
	(57,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/ErrorMapper.php Line:39',1429612659),
	(58,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/categories/103',1429612996),
	(59,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429613002),
	(60,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429613002),
	(61,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429613003),
	(62,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429613003),
	(63,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429613003),
	(64,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429613003),
	(65,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429613003),
	(66,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/categories/103',1429613095),
	(67,'Rest',1,'Call to undefined method Application\\Services\\Mappers\\EngineMapper::define() File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Services/RestSecurityService.php Line:248',1429613096),
	(68,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429613096),
	(69,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429613096),
	(70,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429613096),
	(71,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429613096),
	(72,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429613096),
	(73,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429613096),
	(74,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429613096),
	(75,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/sign',1429613148),
	(76,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/sign?login=stanisov@gmail.com&password=stanisov@gmail.com',1429613153),
	(77,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/sign?login=admin@admin.ua&password=stanisov@gmail.com',1429613165),
	(78,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429613225),
	(79,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429613225),
	(80,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429613225),
	(81,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429613225),
	(82,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429613225),
	(83,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429613225),
	(84,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429613225),
	(85,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Resultset\\Simple::$id File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:68',1429613313),
	(86,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/1/categories/2345',1429618576),
	(87,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/users/144',1429618670),
	(88,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/ErrorMapper.php Line:39',1429618740),
	(89,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/ErrorMapper.php Line:39',1429618740),
	(90,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/ErrorMapper.php Line:39',1429618740),
	(91,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/ErrorMapper.php Line:39',1429618743),
	(92,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/ErrorMapper.php Line:39',1429618744),
	(93,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/ErrorMapper.php Line:39',1429618778),
	(94,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages?columns=345435',1429618787),
	(95,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Row::$logo File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:78',1429619358),
	(96,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429619363),
	(97,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429619364),
	(98,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429619364),
	(99,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429619364),
	(100,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429619364),
	(101,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429619364),
	(102,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429619364),
	(103,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages?columns=titleskdaskjdklasjdklasjdklasdjklasjdklasdjalskdjklasdjaskldjaskldjaslkdjaskldasdasdasdasdasdasdasdasdasdasda',1429619624),
	(104,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages?titleskdaskjdklasjdklasjdklasdjklasjdklasdjalskdjklasdjaskldjaskldjassdsdsdsdsdslkdjaskldasdasdasdasdasdasdasdasdasdasda',1429619633),
	(105,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages?columns=title,id,dffd',1429619767),
	(106,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/1/categories/1?columns=34',1429619904),
	(107,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Row::$logo File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:78',1429619909),
	(108,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Row::$logo File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:78',1429620295),
	(109,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Row::$logo File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:78',1429620386),
	(110,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Row::$logo File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:78',1429620397),
	(111,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Row::$logo File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:78',1429620431),
	(112,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Row::$logo File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:78',1429620449),
	(113,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Row::$logo File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:78',1429620562),
	(114,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Row::$logo File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:78',1429620563),
	(115,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/ErrorMapper.php Line:39',1429620679),
	(116,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/ErrorMapper.php Line:39',1429620680),
	(117,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/1/categories?columns=id,host',1429620820),
	(118,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/1/categories?columns=id,host',1429620820),
	(119,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/1/categories?columns=id,host',1429620820),
	(120,'Global',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://api.phalcon.local/',1429779200),
	(121,'Global',2,'Not Found\n              IP: 127.0.0.1\n              Refer: http://front.local/\n              Method: OPTIONS\n              URI: http://api.phalcon.local/api/v1/engines/1/categories',1429803044),
	(122,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://api.phalcon.local/api/v1/engines/1/categories',1429803077),
	(123,'Global',2,'Not Found\n              IP: 127.0.0.1\n              Refer: http://front.local/\n              Method: OPTIONS\n              URI: http://api.phalcon.local/api/v1/engines/1/categories',1429803226),
	(124,'Global',2,'Not Found\n              IP: 127.0.0.1\n              Refer: http://front.local/\n              Method: OPTIONS\n              URI: http://api.phalcon.local/api/v1/venues/1',1429804107),
	(125,'Global',2,'Not Found\n              IP: 127.0.0.1\n              Refer: http://front.local/\n              Method: OPTIONS\n              URI: http://api.phalcon.local/api/v1/venues/1',1429804241),
	(126,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: http://front.local/\n              Method: GET\n              URI: http://api.phalcon.local/api/v1/venues/1',1429804314),
	(127,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: http://front.local/\n              Method: GET\n              URI: http://api.phalcon.local/api/v1/engines/1',1429804342),
	(128,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: http://front.local/\n              Method: GET\n              URI: http://api.phalcon.local/api/v1/engines/1',1429804440),
	(129,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: http://front.local/\n              Method: GET\n              URI: http://api.phalcon.local/api/v1/engines/1',1429804469),
	(130,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: http://front.local/\n              Method: GET\n              URI: http://api.phalcon.local/api/v1/engines/1',1429804524),
	(131,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: http://front.local/\n              Method: GET\n              URI: http://api.phalcon.local/api/v1/engines/1',1429804550),
	(132,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: http://front.local/\n              Method: GET\n              URI: http://api.phalcon.local/api/v1/engines/1',1429804588),
	(133,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: http://front.local/\n              Method: GET\n              URI: http://api.phalcon.local/api/v1/engines/1',1429804596),
	(134,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/categories?limit=1',1429813695),
	(135,'Rest',1,'Class \'Application\\Services\\Mappers\\NotFoundException\' not found File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:83',1429814206),
	(136,'Rest',1,'Class \'Application\\Services\\Mappers\\NotFoundException\' not found File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:83',1429814245),
	(137,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/categories',1429814311),
	(138,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/categories',1429814662),
	(139,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429815235),
	(140,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429815236),
	(141,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429815236),
	(142,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429815236),
	(143,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429815236),
	(144,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429815236),
	(145,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429815236),
	(146,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/errors?limit=3&columns=title',1429815757),
	(147,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429815786),
	(148,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429815786),
	(149,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429815786),
	(150,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429815786),
	(151,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429815787),
	(152,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429815787),
	(153,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429815787),
	(154,'Rest',2,'Service \'modelsCache\' was not found in the dependency injection container\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/errors?limit=3',1429816444),
	(155,'Rest',2,'Service \'modelsCache\' was not found in the dependency injection container\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/errors?limit=3',1429816446),
	(156,'Rest',2,'Service \'modelsCache\' was not found in the dependency injection container\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/errors?limit=3',1429816475),
	(157,'Rest',2,'Service \'modelsCache\' was not found in the dependency injection container\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/errors?limit=3',1429816537),
	(158,'Rest',2,'Service \'modelsCache\' was not found in the dependency injection container\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/errors?limit=3',1429816538),
	(159,'Rest',2,'Service \'modelsCache\' was not found in the dependency injection container\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/errors',1429816546),
	(160,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:167',1429816643),
	(161,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:167',1429816643),
	(162,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429816648),
	(163,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429816648),
	(164,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429816648),
	(165,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429816648),
	(166,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429816648),
	(167,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429816648),
	(168,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429816649),
	(169,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:167',1429816649),
	(170,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:167',1429816649),
	(171,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/logs',1429816828),
	(172,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/logs',1429816831),
	(173,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/logs',1429816832),
	(174,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:167',1429816847),
	(175,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:167',1429816847),
	(176,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429816850),
	(177,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429816850),
	(178,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429816851),
	(179,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429816851),
	(180,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429816851),
	(181,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429816851),
	(182,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429816851),
	(183,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:167',1429816851),
	(184,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:167',1429816851),
	(185,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429816898),
	(186,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429816898),
	(187,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429816898),
	(188,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429816898),
	(189,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429816898),
	(190,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429816898),
	(191,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:169',1429816977),
	(192,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:169',1429816978),
	(193,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429816982),
	(194,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429816982),
	(195,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429816983),
	(196,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429816983),
	(197,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429816983),
	(198,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429816983),
	(199,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429816983),
	(200,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:169',1429816983),
	(201,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:169',1429816983),
	(202,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:169',1429817053),
	(203,'Rest',1,'syntax error, unexpected \')\' File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:166',1429817171),
	(204,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:169',1429817339),
	(205,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:172',1429817370),
	(206,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429817374),
	(207,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429817374),
	(208,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429817374),
	(209,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429817374),
	(210,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429817374),
	(211,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429817374),
	(212,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429817374),
	(213,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/logs/1',1429817397),
	(214,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/sign?login=admin@admin.uam&password=admin@admin.ua',1429817413),
	(215,'Rest',1,'Call to a member function count() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:172',1429817431),
	(216,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/logs/1',1429817475),
	(217,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/logs/1',1429817543),
	(218,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/logs/1',1429817548),
	(219,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/logs/1',1429817647),
	(220,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=admin%40admin.ua&password=admin%40admin.ua\n              Method: GET\n              URI: http://phalcon.local/api/v1/logs/1',1429817677),
	(221,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429817680),
	(222,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429817680),
	(223,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429817680),
	(224,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429817680),
	(225,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429817680),
	(226,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429817680),
	(227,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429817680),
	(228,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429817763),
	(229,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429817763),
	(230,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429817763),
	(231,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429817763),
	(232,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429817763),
	(233,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429817763),
	(234,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429817763),
	(235,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/logs/55',1429818689),
	(236,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/logs/55',1429819460),
	(237,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/logs',1429868048),
	(238,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429868518),
	(239,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429868519),
	(240,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:161',1429868522),
	(241,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:161',1429868552),
	(242,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429868554),
	(243,'Rest',1,'Class Application\\Services\\Mappers\\CategoryMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/CategoryMapper.php Line:18',1429869086),
	(244,'Rest',1,'Class Application\\Services\\Mappers\\CategoryMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/CategoryMapper.php Line:18',1429869087),
	(245,'Rest',1,'Class Application\\Services\\Mappers\\CategoryMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/CategoryMapper.php Line:319',1429869087),
	(246,'Rest',1,'Class Application\\Services\\Mappers\\CategoryMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/CategoryMapper.php Line:319',1429869087),
	(247,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869087),
	(248,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869087),
	(249,'Rest',1,'Class Application\\Services\\Mappers\\PageMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/PageMapper.php Line:18',1429869087),
	(250,'Rest',1,'Class Application\\Services\\Mappers\\PageMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/PageMapper.php Line:18',1429869087),
	(251,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869087),
	(252,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869087),
	(253,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869087),
	(254,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869087),
	(255,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869087),
	(256,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869088),
	(257,'Rest',1,'Class Application\\Services\\Mappers\\PageMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/PageMapper.php Line:18',1429869088),
	(258,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869088),
	(259,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869088),
	(260,'Rest',1,'Call to undefined method Application\\Services\\Mappers\\ErrorMapper::getError() File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Services/RestExceptionHandler.php Line:140',1429869088),
	(261,'Rest',1,'Call to undefined method Application\\Services\\Mappers\\ErrorMapper::getError() File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Services/RestExceptionHandler.php Line:140',1429869088),
	(262,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429869088),
	(263,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869088),
	(264,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869088),
	(265,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869088),
	(266,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869088),
	(267,'Rest',1,'Class Application\\Services\\Mappers\\CategoryMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/CategoryMapper.php Line:18',1429869127),
	(268,'Rest',1,'Class \'Application\\Services\\Mappers\\NotFoundException\' not found File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/CategoryMapper.php Line:45',1429869386),
	(269,'Rest',1,'Call to undefined method Application\\Services\\Mappers\\ErrorMapper::getError() File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Services/RestExceptionHandler.php Line:140',1429869407),
	(270,'Rest',1,'Call to undefined method Application\\Services\\Mappers\\ErrorMapper::getError() File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Services/RestExceptionHandler.php Line:140',1429869408),
	(271,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/categories/123',1429869491),
	(272,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429869514),
	(273,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429869514),
	(274,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429869514),
	(275,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869569),
	(276,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869569),
	(277,'Rest',1,'Class Application\\Services\\Mappers\\PageMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/PageMapper.php Line:18',1429869569),
	(278,'Rest',1,'Class Application\\Services\\Mappers\\PageMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/PageMapper.php Line:18',1429869569),
	(279,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869569),
	(280,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869569),
	(281,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869569),
	(282,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869569),
	(283,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869569),
	(284,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869570),
	(285,'Rest',1,'Class Application\\Services\\Mappers\\PageMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/PageMapper.php Line:18',1429869570),
	(286,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869570),
	(287,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869570),
	(288,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429869570),
	(289,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429869570),
	(290,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429869570),
	(291,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869570),
	(292,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869570),
	(293,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869570),
	(294,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429869570),
	(295,'Rest',1,'Class Application\\Services\\Mappers\\PageMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/PageMapper.php Line:18',1429869615),
	(296,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/12',1429869881),
	(297,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages/1',1429869995),
	(298,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages/1',1429869999),
	(299,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages/1',1429870000),
	(300,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages/1',1429870000),
	(301,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages/1',1429870001),
	(302,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages/1',1429870001),
	(303,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages/1',1429870001),
	(304,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages/1',1429870001),
	(305,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages/1',1429870001),
	(306,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429870031),
	(307,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429870031),
	(308,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429870031),
	(309,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429870031),
	(310,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429870032),
	(311,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429870032),
	(312,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429870032),
	(313,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429870032),
	(314,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429870032),
	(315,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429870032),
	(316,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429870032),
	(317,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429870032),
	(318,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429870032),
	(319,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429870032),
	(320,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429870032),
	(321,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429870032),
	(322,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429870032),
	(323,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429870032),
	(324,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429871140),
	(325,'Rest',1,'Class Application\\Services\\Mappers\\UserMapper contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractModelCrud::read) File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/UserMapper.php Line:22',1429871141),
	(326,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871461),
	(327,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871461),
	(328,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871461),
	(329,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871461),
	(330,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871462),
	(331,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871462),
	(332,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871462),
	(333,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871462),
	(334,'Rest',1,'Call to a member function toArray() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:155',1429871466),
	(335,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429871466),
	(336,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871466),
	(337,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871467),
	(338,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429871467),
	(339,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429871467),
	(340,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429871467),
	(341,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429871467),
	(342,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429871467),
	(343,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871467),
	(344,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871467),
	(345,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871477),
	(346,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871477),
	(347,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871477),
	(348,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871478),
	(349,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871478),
	(350,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871478),
	(351,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871478),
	(352,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871478),
	(353,'Rest',1,'Call to a member function toArray() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:155',1429871481),
	(354,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429871481),
	(355,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871481),
	(356,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871481),
	(357,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429871481),
	(358,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429871481),
	(359,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429871481),
	(360,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429871481),
	(361,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429871481),
	(362,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871481),
	(363,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429871481),
	(364,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/logs',1429871505),
	(365,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:161',1429871538),
	(366,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:161',1429871720),
	(367,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:161',1429871753),
	(368,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:161',1429871884),
	(369,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:161',1429871890),
	(370,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:161',1429871891),
	(371,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429872751),
	(372,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429872751),
	(373,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429872751),
	(374,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429872751),
	(375,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429872751),
	(376,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429872752),
	(377,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429872752),
	(378,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429872752),
	(379,'Rest',1,'Call to a member function toArray() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:155',1429872755),
	(380,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429872755),
	(381,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429872755),
	(382,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429872756),
	(383,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429872756),
	(384,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429872756),
	(385,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429872756),
	(386,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429872756),
	(387,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429872756),
	(388,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429872756),
	(389,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429872756),
	(390,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/sign?login=stanisov@gmail.com&password=stanisov@gmail.com',1429872773),
	(391,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429872791),
	(392,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429873025),
	(393,'Rest',1,'Call to a member function toArray() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:155',1429873025),
	(394,'Rest',1,'Call to a member function toArray() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:155',1429873025),
	(395,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429873025),
	(396,'Rest',1,'Call to a member function toArray() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:155',1429873025),
	(397,'Rest',1,'Call to a member function toArray() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:155',1429873028),
	(398,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429873028),
	(399,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429873028),
	(400,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429873031),
	(401,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429873031),
	(402,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429873031),
	(403,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429873031),
	(404,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429873031),
	(405,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429877505),
	(406,'Rest',1,'Call to a member function toArray() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:155',1429877505),
	(407,'Rest',1,'Call to a member function toArray() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:155',1429877506),
	(408,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:170',1429877506),
	(409,'Rest',1,'Call to a member function toArray() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:155',1429877506),
	(410,'Rest',1,'Call to a member function toArray() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:155',1429877510),
	(411,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429877510),
	(412,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429877510),
	(413,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429877510),
	(414,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429877510),
	(415,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429877510),
	(416,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429877510),
	(417,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429877510),
	(418,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: DELETE\n              URI: http://phalcon.local/api/v1/sign/1',1429877597),
	(419,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: DELETE\n              URI: http://phalcon.local/api/v1/sign/10',1429877602),
	(420,'Rest',1,'Call to a member function toArray() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:155',1429877607),
	(421,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: DELETE\n              URI: http://phalcon.local/api/v1/sign/15',1429877683),
	(422,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: DELETE\n              URI: http://phalcon.local/api/v1/sign/18',1429877697),
	(423,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: DELETE\n              URI: http://phalcon.local/api/v1/sign/18',1429877775),
	(424,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:171',1429877972),
	(425,'Rest',1,'Undefined variable: response File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:177',1429877972),
	(426,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:171',1429877972),
	(427,'Rest',1,'Undefined variable: response File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:177',1429877972),
	(428,'Rest',1,'Call to a member function toArray() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:156',1429877975),
	(429,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429877975),
	(430,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429877975),
	(431,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429877976),
	(432,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429877976),
	(433,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429877976),
	(434,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429877976),
	(435,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429877976),
	(436,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:171',1429877996),
	(437,'Rest',1,'Undefined variable: response File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:175',1429878054),
	(438,'Rest',2,'Conflict\n              IP: 127.0.0.1\n              Refer: \n              Method: POST\n              URI: http://phalcon.local/api/v1/sign',1429878116),
	(439,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:171',1429878125),
	(440,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:171',1429878273),
	(441,'Rest',1,'Argument 1 passed to Application\\Modules\\Rest\\DTO\\UserDTO::setUsers() must be an instance of Phalcon\\Mvc\\Model\\Resultset\\Simple, instance of Application\\Models\\Users given, called in /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Services/RestSecurityService.php on line 113 and defined File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/UserDTO.php Line:38',1429878570),
	(442,'Rest',2,'Conflict\n              IP: 127.0.0.1\n              Refer: \n              Method: POST\n              URI: http://phalcon.local/api/v1/sign',1429878632),
	(443,'Rest',1,'Call to undefined method Application\\Modules\\Rest\\DTO\\UserDTO::getFirst() File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:105',1429878641),
	(444,'Rest',2,'Conflict\n              IP: 127.0.0.1\n              Refer: \n              Method: POST\n              URI: http://phalcon.local/api/v1/sign',1429879013),
	(445,'Rest',2,'Conflict\n              IP: 127.0.0.1\n              Refer: \n              Method: POST\n              URI: http://phalcon.local/api/v1/sign',1429879471),
	(446,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: POST\n              URI: http://phalcon.local/api/v1/sign',1429879609),
	(447,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429879744),
	(448,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429879744),
	(449,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429879744),
	(450,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429879744),
	(451,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429879744),
	(452,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429879744),
	(453,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429879744),
	(454,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429879812),
	(455,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429879813),
	(456,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429879813),
	(457,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429879813),
	(458,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429879813),
	(459,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429879813),
	(460,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429879813),
	(461,'Rest',2,'SmsUkraine: errors:Error in Alpha-name.errors:Not enough money\n              IP: 127.0.0.1\n              Refer: \n              Method: PUT\n              URI: http://phalcon.local/api/v1/sign',1429880783),
	(462,'Rest',2,'BulkSMS: FAILED_USERCREDITS\n              IP: 127.0.0.1\n              Refer: \n              Method: PUT\n              URI: http://phalcon.local/api/v1/sign',1429881113),
	(463,'Rest',2,'Nexmo: Quota Exceeded - rejected\n              IP: 127.0.0.1\n              Refer: \n              Method: PUT\n              URI: http://phalcon.local/api/v1/sign',1429881148),
	(464,'Rest',2,'SmsAero: empty field. reject\n              IP: 127.0.0.1\n              Refer: \n              Method: PUT\n              URI: http://phalcon.local/api/v1/sign',1429881169),
	(465,'Rest',2,'SMSC: no money\n              IP: 127.0.0.1\n              Refer: \n              Method: PUT\n              URI: http://phalcon.local/api/v1/sign',1429881181),
	(466,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages/2',1429882003),
	(467,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages/3',1429882007),
	(468,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages/3',1429882007),
	(469,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages/3',1429882008),
	(470,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/pages/3',1429882008),
	(471,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: POST\n              URI: http://phalcon.local/api/v1/sign',1429882467),
	(472,'Rest',2,'Conflict\n              IP: 127.0.0.1\n              Refer: \n              Method: POST\n              URI: http://phalcon.local/api/v1/sign',1429882540),
	(473,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: DELETE\n              URI: http://phalcon.local/api/v1/sign/1',1429882789),
	(474,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: DELETE\n              URI: http://phalcon.local/api/v1/sign/123',1429882795),
	(475,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: DELETE\n              URI: http://phalcon.local/api/v1/sign/123',1429882798),
	(476,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/categories',1429883090),
	(477,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: DELETE\n              URI: http://phalcon.local/api/v1/sign/123',1429884139),
	(478,'Rest',2,'SMSRu: Не хватает средств на лицевом счету\n              IP: 127.0.0.1\n              Refer: \n              Method: PUT\n              URI: http://phalcon.local/api/v1/sign',1429884368),
	(479,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429884548),
	(480,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429884549),
	(481,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429884549),
	(482,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429884549),
	(483,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429884549),
	(484,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429884549),
	(485,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429884589),
	(486,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429884589),
	(487,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429884589),
	(488,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429884589),
	(489,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429884589),
	(490,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429884589),
	(491,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429885139),
	(492,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429885140),
	(493,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429885140),
	(494,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429885140),
	(495,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429885140),
	(496,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429885140),
	(497,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429885140),
	(498,'Rest',1,'Undefined variable: response File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:242',1429885267),
	(499,'Rest',1,'Call to a member function toArray() on a non-object File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:243',1429885316),
	(500,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429885342),
	(501,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429885342),
	(502,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429885342),
	(503,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429885342),
	(504,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429885342),
	(505,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429885342),
	(506,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429885342),
	(507,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Resultset\\Simple::$currencyRel File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:70',1429885669),
	(508,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Resultset\\Simple::$currency_id File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:70',1429885740),
	(509,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Resultset\\Simple::$currencyRel File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:75',1429885767),
	(510,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Resultset\\Simple::$currencyRel File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:75',1429885783),
	(511,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Resultset\\Simple::$currencyRel File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:75',1429885809),
	(512,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Resultset\\Simple::$currencyRel File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:71',1429885821),
	(513,'Rest',1,'Undefined property: Phalcon\\Mvc\\Model\\Resultset\\Simple::$currencyRel File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:77',1429885950),
	(514,'Rest',1,'Argument 1 passed to Application\\Modules\\Rest\\DTO\\EngineDTO::setCurrencies() must be an instance of Phalcon\\Mvc\\Model\\Resultset\\Simple, instance of Application\\Models\\Currency given, called in /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php on line 79 and defined File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/EngineDTO.php Line:61',1429886080),
	(515,'Rest',1,'Argument 1 passed to Application\\Aware\\AbstractDTO::total() must be an instance of Phalcon\\Mvc\\Model\\Resultset\\Simple, instance of Application\\Models\\Currency given, called in /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/EngineDTO.php on line 64 and defined File: /Users/stanislavmenshykh/phalcon.local/Application/Aware/AbstractDTO.php Line:23',1429886128),
	(516,'Rest',1,'Argument 1 passed to Application\\Aware\\AbstractDTO::total() must be an instance of Phalcon\\Mvc\\Model\\Resultset\\Simple, instance of Application\\Models\\Currency given, called in /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/EngineDTO.php on line 64 and defined File: /Users/stanislavmenshykh/phalcon.local/Application/Aware/AbstractDTO.php Line:23',1429886463),
	(517,'Rest',1,'Argument 1 passed to Application\\Aware\\AbstractDTO::total() must be an instance of Phalcon\\Mvc\\Model\\Resultset\\Simple, instance of Application\\Models\\Currency given, called in /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/EngineDTO.php on line 63 and defined File: /Users/stanislavmenshykh/phalcon.local/Application/Aware/AbstractDTO.php Line:23',1429886532),
	(518,'Rest',1,'Argument 1 passed to Application\\Aware\\AbstractDTO::total() must be an instance of Phalcon\\Mvc\\Model\\Resultset\\Simple, instance of Application\\Models\\Currency given, called in /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/EngineDTO.php on line 63 and defined File: /Users/stanislavmenshykh/phalcon.local/Application/Aware/AbstractDTO.php Line:23',1429886543),
	(519,'Rest',2,'The method \"setfetchmode\" doesn\'t exist on model \"Application\\Models\\Currency\"\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/1',1429886689),
	(520,'Rest',2,'The method \"setfetchmode\" doesn\'t exist on model \"Application\\Models\\Currency\"\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/1',1429886703),
	(521,'Rest',2,'The method \"getFirst\" doesn\'t exist on model \"Application\\Models\\Currency\"\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/1',1429886837),
	(522,'Rest',2,'The method \"getFirst\" doesn\'t exist on model \"Application\\Models\\Currency\"\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/1',1429886847),
	(523,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:178',1429887171),
	(524,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:178',1429887180),
	(525,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:178',1429887181),
	(526,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:178',1429887193),
	(527,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:178',1429887194),
	(528,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:178',1429887242),
	(529,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:179',1429887290),
	(530,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:181',1429887302),
	(531,'Rest',1,'Undefined index: offset File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:181',1429887312),
	(532,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/12',1429887508),
	(533,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/2',1429887512),
	(534,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/3',1429887515),
	(535,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/4',1429887518),
	(536,'Rest',1,'Argument 1 passed to Application\\Modules\\Rest\\DTO\\EngineDTO::setCurrencies() must be an instance of Application\\Models\\Currency, null given, called in /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php on line 79 and defined File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/EngineDTO.php Line:61',1429887783),
	(537,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429887788),
	(538,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429887788),
	(539,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429887789),
	(540,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429887789),
	(541,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429887789),
	(542,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429887789),
	(543,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429887789),
	(544,'Rest',1,'Argument 1 passed to Application\\Modules\\Rest\\DTO\\EngineDTO::setCurrencies() must be an instance of Application\\Models\\Currency, null given, called in /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php on line 79 and defined File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/EngineDTO.php Line:61',1429887807),
	(545,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429887811),
	(546,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429887811),
	(547,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429887811),
	(548,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429887811),
	(549,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429887811),
	(550,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429887811),
	(551,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429887811),
	(552,'Rest',1,'Argument 1 passed to Application\\Modules\\Rest\\DTO\\EngineDTO::setCurrencies() must be an instance of Application\\Models\\Currency, null given, called in /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php on line 79 and defined File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/EngineDTO.php Line:61',1429887851),
	(553,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429887854),
	(554,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429887854),
	(555,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429887855),
	(556,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429887855),
	(557,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429887855),
	(558,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429887855),
	(559,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429887855),
	(560,'Rest',1,'Argument 1 passed to Application\\Modules\\Rest\\DTO\\EngineDTO::setCurrencies() must be an instance of Application\\Models\\Currency, null given, called in /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php on line 79 and defined File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/EngineDTO.php Line:61',1429887887),
	(561,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429888072),
	(562,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429888072),
	(563,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429888072),
	(564,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429888072),
	(565,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429888072),
	(566,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429888072),
	(567,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429888072),
	(568,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429890347),
	(569,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429890347),
	(570,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429890347),
	(571,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429890347),
	(572,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429890347),
	(573,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429890347),
	(574,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429890347),
	(575,'Rest',2,'Column \'engine_id\' doesn\'t belong to any of the selected models (1), when preparing: SELECT [Application\\Models\\Currency].* FROM [Application\\Models\\Currency] WHERE [engine_id] = ?0 LIMIT 1\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/1',1429890548),
	(576,'Rest',2,'Column \'engine_id\' doesn\'t belong to any of the selected models (1), when preparing: SELECT [Application\\Models\\Currency].* FROM [Application\\Models\\Currency] WHERE [engine_id] = ?0 LIMIT 1\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/1',1429890549),
	(577,'Rest',2,'Column \'engine_id\' doesn\'t belong to any of the selected models (1), when preparing: SELECT [Application\\Models\\Currency].* FROM [Application\\Models\\Currency] WHERE [engine_id] = ?0 LIMIT 1\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/1',1429890566),
	(578,'Rest',2,'Column \'engine_id\' doesn\'t belong to any of the selected models (1), when preparing: SELECT [Application\\Models\\Currency].* FROM [Application\\Models\\Currency] WHERE [engine_id] = ?0 LIMIT 1\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/1',1429890624),
	(579,'Rest',1,'Undefined index: par_id File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/CategoryMapper.php Line:63',1429891477),
	(580,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/1/categories',1429892597),
	(581,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/1/categories',1429894122),
	(582,'Rest',1,'Call to undefined function Application\\Modules\\Rest\\DTO\\object_to_array() File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/EngineDTO.php Line:96',1429894443),
	(583,'Rest',1,'Call to undefined function Application\\Modules\\Rest\\DTO\\object_to_array() File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/EngineDTO.php Line:96',1429894459),
	(584,'Rest',1,'Call to undefined function Application\\Modules\\Rest\\DTO\\object_to_array() File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/EngineDTO.php Line:96',1429894461),
	(585,'Rest',1,'Call to undefined method Application\\Modules\\Rest\\DTO\\EngineDTO::object_to_array() File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/EngineDTO.php Line:91',1429894779),
	(586,'Rest',1,'Call to undefined method Application\\Services\\Mappers\\EngineMapper::prepareRelatedConditions() File: /Users/stanislavmenshykh/phalcon.local/Application/Aware/AbstractModelCrud.php Line:72',1429895734),
	(587,'Rest',1,'Call to undefined method Application\\Services\\Mappers\\EngineMapper::prepareRelatedConditions() File: /Users/stanislavmenshykh/phalcon.local/Application/Aware/AbstractModelCrud.php Line:72',1429895741),
	(588,'Rest',1,'Call to private method Application\\Services\\Mappers\\EngineMapper::prepareRelatedConditions() from context \'Application\\Aware\\AbstractModelCrud\' File: /Users/stanislavmenshykh/phalcon.local/Application/Aware/AbstractModelCrud.php Line:72',1429895785),
	(589,'Rest',1,'Argument 1 passed to Application\\Services\\Mappers\\EngineMapper::prepareRelatedConditions() must be an instance of Application\\Services\\Mappers\\Resultset, instance of Phalcon\\Mvc\\Model\\Resultset\\Simple given, called in /Users/stanislavmenshykh/phalcon.local/Application/Aware/AbstractModelCrud.php on line 72 and defined File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:100',1429895794),
	(590,'Rest',1,'Argument 1 passed to Application\\Services\\Mappers\\EngineMapper::prepareRelatedConditions() must be an instance of Application\\Services\\Mappers\\Resultset, instance of Phalcon\\Mvc\\Model\\Resultset\\Simple given, called in /Users/stanislavmenshykh/phalcon.local/Application/Aware/AbstractModelCrud.php on line 72 and defined File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:100',1429895800),
	(591,'Rest',1,'Argument 1 passed to Application\\Services\\Mappers\\EngineMapper::prepareRelatedConditions() must be an instance of Application\\Services\\Mappers\\Resultset, instance of Phalcon\\Mvc\\Model\\Resultset\\Simple given, called in /Users/stanislavmenshykh/phalcon.local/Application/Aware/AbstractModelCrud.php on line 72 and defined File: /Users/stanislavmenshykh/phalcon.local/Application/Services/Mappers/EngineMapper.php Line:100',1429895811),
	(592,'Rest',1,'Class Application\\Modules\\Rest\\DTO\\UserDTO contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractDTO::asRealArray) File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/UserDTO.php Line:17',1429895890),
	(593,'Rest',2,'Conflict\n              IP: 127.0.0.1\n              Refer: \n              Method: POST\n              URI: http://phalcon.local/api/v1/sign',1429895900),
	(594,'Rest',1,'Class Application\\Modules\\Rest\\DTO\\UserDTO contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractDTO::asRealArray) File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/UserDTO.php Line:17',1429895903),
	(595,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: POST\n              URI: http://phalcon.local/api/v1/sign',1429896359),
	(596,'Rest',1,'Class Application\\Modules\\Rest\\DTO\\UserDTO contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Application\\Aware\\AbstractDTO::asRealArray) File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/DTO/UserDTO.php Line:17',1429896364),
	(597,'Rest',2,'Conflict\n              IP: 127.0.0.1\n              Refer: \n              Method: POST\n              URI: http://phalcon.local/api/v1/sign',1429896415),
	(598,'Rest',1,'Undefined index: currency File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:189',1429896722),
	(599,'Rest',1,'Undefined index: currency File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:189',1429896727),
	(600,'Rest',1,'Undefined index: currency File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:189',1429896749),
	(601,'Rest',1,'Undefined index: currency File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:189',1429896758),
	(602,'Rest',1,'Undefined index: currency File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:189',1429896770),
	(603,'Rest',1,'Undefined index: engines File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Rest/Validators/ResultSetValidator.php Line:188',1429896775),
	(604,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=id%2Ctitle%2Cwrong',1429896852),
	(605,'Rest',2,'Forbidden\n              IP: 127.0.0.1\n              Refer: http://phalcon.local/api/v1/sign?login=user%40gmail.com&password=user%40gmail.com\n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429896852),
	(606,'Rest',2,'Request URI Too Long\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1429896852),
	(607,'Rest',2,'Not Acceptable\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429896852),
	(608,'Rest',2,'Not Found\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/undefined/page',1429896852),
	(609,'Rest',2,'Bad Request\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/sign',1429896852),
	(610,'Rest',2,'Unauthorized\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local//api/v1/users',1429896852);

/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы pages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Title of page',
  `content` text NOT NULL COMMENT 'HTML content',
  `alias` varchar(32) NOT NULL DEFAULT '' COMMENT 'URL slug',
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Create date',
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Update date',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `ful_content` (`content`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;

INSERT INTO `pages` (`id`, `title`, `content`, `alias`, `date_create`, `date_update`)
VALUES
	(1,'About','<p>This is about page content. I am edit storage text. EDITED2</p>','/pages/about','2015-01-22 00:30:05','2015-03-23 12:26:25'),
	(2,'Agreement','This is agreement page content','/pages/agreement','2015-01-22 00:32:41','2015-03-23 12:26:27'),
	(4,'Contacts','<p>This is contacs page content. EDITED</p>','/pages/contacts','2015-01-22 00:34:22','2015-03-23 12:26:30'),
	(5,'Help','<p>This is the help page</p>','/pages/help','2015-01-22 02:53:07','2015-03-23 12:26:32');

/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы user_access
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_access`;

CREATE TABLE `user_access` (
  `user_id` int(11) unsigned NOT NULL,
  `token` varchar(255) NOT NULL,
  `expire_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `user_access_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_access` WRITE;
/*!40000 ALTER TABLE `user_access` DISABLE KEYS */;

INSERT INTO `user_access` (`user_id`, `token`, `expire_date`)
VALUES
	(11,'$2a$08$k6sgsJGvNpzpGQm3FKxx9ea9YH6992hjWU7QW9NBqEkiSTd5olTTe','2015-05-01 17:34:12'),
	(14,'e95b8b637146bc43325c9df2fd1a0ab4','2015-03-16 05:45:43'),
	(15,'$2a$08$9IwlUY0roTWClrt1yYX60uHtGNRRx9d.8dOlgQZvI3v2e62GOxDlu','2015-05-01 17:34:13'),
	(16,'643bd3a1ce3090d14f9a59d0c45ad354','2015-03-16 05:51:12'),
	(21,'70accea75c068e1ed0e9adc4aa99acd9','2015-03-16 06:03:03'),
	(22,'6b67c6230eb9d646d583a29d19292bd8','2015-03-16 06:34:23'),
	(23,'ffbd44b314d83a442a49c56ef9f74af7','2015-03-16 07:01:05'),
	(24,'627761113ed88e4a56eb6189def3e651','2015-03-16 07:02:25'),
	(25,'f222918ddb53cc11d5905c45c865dc78','2015-03-16 07:04:33'),
	(26,'073626d8d6b3bacd3c4ad040406979d6','2015-03-16 07:05:48'),
	(30,'632a7cc5792dfe4c57106bd821402bf4','2015-03-16 07:20:57'),
	(31,'3fe372c2f39619966384ab84f6894518','2015-03-16 07:43:18'),
	(32,'210056b2ac1fc6071520c0c0b2b5f979','2015-03-19 02:13:37'),
	(33,'d2516319f860cd17283f8ffae47d47f6','2015-03-16 21:57:41'),
	(34,'$2a$08$PbKDhDPHitTnswhak8W//exO4CLiefSt3aR72pNWKXO0WJ.jFfpni','2015-04-07 11:23:17'),
	(35,'$2a$08$/PFLE8I5mYUj.HIoGfs6luEiVn9zTrPmUYgHiqqnUWmwXzEmgDAxy','2015-04-07 11:24:06'),
	(36,'$2a$08$6EupB84BZeBK6BZLQSjTXecMQ/Eg.dYNo962d9eYn7zrpxibK85/O','2015-04-07 12:21:21'),
	(37,'$2a$08$wN//uhFgWnchQAdiKOp9eO7pM5GlNm2x3pZHgBNT7yYPnkWZcAepS','2015-04-07 12:24:12'),
	(38,'$2a$08$aLsi3TaKmFFJc5Y4VCmwbe4esiRRwtYRhEfDyYg3SPw9qXnd9U/b2','2015-04-07 14:27:55'),
	(39,'$2a$08$MLfJr8pGzNos5CrzDrrDeusE5ZH.11BsQbM7AhOcwZ/Qo3bL3Wt4.','2015-04-07 14:28:30'),
	(40,'$2a$08$qnFlgvZtNBy..anoepICP.9QygytLA81CvQxbbg5Yji/qq01ONDn2','2015-04-07 14:28:54'),
	(42,'$2a$08$9CUJ6aCg7rn9kDAOF/vmje/VhnpnkbKzyGKKsd2hjFUa1VOG5l3Km','2015-04-07 14:29:46'),
	(45,'$2a$08$1iONIkKmmbz63VktW3O4nOpm/szsn682DH39qPRE8SwkAyPh92Zbu','2015-04-07 14:30:53'),
	(46,'$2a$08$JofjRtUGBnSvd6OyJRFdF.Eh764wWyFNCEuaFKxmgy9XzmRaetFJu','2015-04-07 15:43:05'),
	(47,'$2a$08$HgQqN2FJfaifmm2HhiCmV.ZCyABm5yqqLVCFyXMjtVBU43c6tmOVy','2015-04-07 15:52:37'),
	(48,'$2a$08$/12JHmfWhs9IZJQu9BMiEOukEFxabPNifRhmbTr7A667MLR/F3t/y','2015-04-07 17:29:13'),
	(49,'$2a$08$kh.3Ej.yqyvM5PcE0NLsdOr1d8NVmjOsTYBxIDT.e8wB7srMxCXXq','2015-04-08 00:07:38'),
	(50,'$2a$08$H/QpOznNOsZnF6wJYdTEueIeZCrPsKk4iFE9Jmv6trFfM4FBZV.Ia','2015-04-08 00:15:13'),
	(51,'$2a$08$3Nw17yjWTLiSD.rAlzbLoOqk/J1gG7SnII.bmfDFPdWAm8h0IlA8u','2015-04-08 00:16:48'),
	(52,'$2a$08$49qBrk6Sj8NvEnLK0.Bj1eCyeJRA6V/6LcD2OdZ36KHKvR2nrjDye','2015-04-08 09:04:14'),
	(53,'$2a$08$RMKkqxPG7I8meczlIguXw.ybcZr.UNNrWVuXU4owhI0vATo4NL0s.','2015-04-08 09:08:21'),
	(54,'$2a$08$1A3aInSSV8NeoC5KpznesOgOBLWTJD3P2XzXSDEu64NQTSKkwu/AK','2015-04-08 09:08:53'),
	(55,'$2a$08$/8QcV9x0icpsbDNl19zSxObOOViZ7v9nILGCwlaDTvJiPzr8HnqH2','2015-04-08 09:09:05'),
	(56,'$2a$08$XSXzztVhYcR8mvhrhKS/Tes8vHn6AEaqBklyptCDzkoTnQgUCsOvy','2015-04-08 09:12:05'),
	(57,'$2a$08$WVlWq1n56MA.XWKrJTC.NeNnkXQAb.nHKrO81Y7gAIupz0jVJw1oq','2015-04-08 09:12:22'),
	(58,'$2a$08$tIRB9V/Bad9TQvcZrRNEYOb3EMZ9UDczm8SuJ4quDggQgzo2R3Usm','2015-04-08 09:30:53'),
	(59,'$2a$08$XP6RYGO7tixZL25uv4tOnejfJbwU3xcFv6WpnAOPcGn8STN2RqtFq','2015-04-08 09:31:32'),
	(60,'$2a$08$jx.bHNzSPbPxNfla3s5Y0ePnXgfDkVNUmiUzlMKGiqnI/cFFIqeM2','2015-04-08 09:32:33'),
	(61,'$2a$08$H/jJXnL/yhHst8nAzvtGqOude0kmUHAkXsvOV5HnJp0VZ8bB9Jyk2','2015-04-08 09:32:55'),
	(62,'$2a$08$iaYDfXYEmYexjvxMcHz9PedAOJXdxqjWtFzXQNKk0JndnZyv08RP6','2015-04-08 09:35:09'),
	(63,'$2a$08$Zh3KvvRo3x1MrPZ0jTckWOq6gV5c9AJq/Bk8ncO8MuO81V0KiXsya','2015-04-08 09:35:48'),
	(64,'$2a$08$6B6SYeBS0NBdTqdSQGrileHFaVnD5p2te3Ki5PmvjJQpb4Dd6Z5nC','2015-04-09 08:15:01'),
	(65,'$2a$08$au41d6XKOnO4cf9I17xQ/.fyDdXOtn2Tq1ywRPPNZKaWFCvgdiEkW','2015-04-09 09:27:08'),
	(66,'$2a$08$.wytX.4kwxY6zntOOAtvaOtZlJKp4ecakdbrxc9BLbIyKb1MWMxp2','2015-04-09 09:29:20'),
	(67,'$2a$08$OMMdK7HW92n.XJhVFZul/uZ/qBuQUglbAaGpSVpTvCmNmcviGfOU6','2015-04-09 09:29:46'),
	(68,'$2a$08$vBgaXF1.CwshWPWm4iut/OpsJwSwtUfGN7JicBk17uYOllfuNnPrK','2015-04-09 09:34:27'),
	(69,'$2a$08$jws7N6Mx.IttmHgX0IENmOzN3Gy3h31Se6lKgQBwJVmQsIwoQ5tJ2','2015-04-09 11:18:01'),
	(70,'$2a$08$BcNgpylVGB0hcxxro.UJxOjRl79vL..sjc2CcOdd0K1VpIJ1cJCUS','2015-04-09 11:24:03'),
	(71,'$2a$08$WkU0TH2XzBgEknVSBAp6yOJySH0AHWPBE7xf80kt3TXZgbtw03kAu','2015-04-09 11:25:35'),
	(72,'$2a$08$foOVh8.lGUmeDqsdCQs8Z.5XAEDqbUkU3H8nh8nPjnHiz6bV98lsa','2015-04-09 11:26:11'),
	(73,'$2a$08$0S/OqB36ghCu7rF5gQfnduBkqO9WgDX9A0jVle3Q1SGvCBVLGh3se','2015-04-09 14:05:52'),
	(74,'$2a$08$BYlaKpZPNncLh2uiA.nPxOgpH8WT1Ri8wQYJvCtDXUkcLtKSIhGlG','2015-04-09 15:26:29'),
	(75,'$2a$08$vuQyXdOGGYBJauzCsSxof.CTcOsGW5FwIilGHgK7.cxCCQcD1AR5W','2015-04-23 09:07:04'),
	(76,'$2a$08$hb69DNueFa6VfY9apBDLPetGxNskFiBzmIQ3UgudlwamObRWHr2g2','2015-04-23 09:07:57'),
	(77,'$2a$08$is/SNbL3dRKVx7oWqWc5IeOf/C3p5NdlYMM5BZ9Q087h533k9gqfm','2015-04-23 09:08:59'),
	(78,'$2a$08$h6vicHw6D0v5h5ODVIyqG.BZtGMbJ3dALviGiJgPqhFjbJ5WaT5iS','2015-04-23 09:11:37'),
	(80,'$2a$08$eKt.5Tb9eciaqGTkesXdcuXmHPpCsQBtSfsh3n.2zt81cR1NqZyFK','2015-04-23 09:14:45'),
	(82,'$2a$08$EUcLZIPaghAD/va4kzWU.uhDGz11uCr3h4niPiSycpGTwA90jLYgy','2015-04-23 09:24:17'),
	(84,'$2a$08$KA5joy3JjcFfYNzKaqBfNuWGrUJsyvT2426OQ9uB/UDUyNKXdS0Fu','2015-04-23 09:24:32'),
	(86,'$2a$08$GWcwCvgIzB3yPC/9rv8GM.upLout5mTUdGtVPpcT4yAq5sRtVxxNu','2015-04-23 09:27:50'),
	(88,'$2a$08$hRWTX40m/pZCzD4NwRHk1OmFajIhawZ5hvox71V2N7K1kCx9.GcEq','2015-04-23 09:28:06'),
	(90,'$2a$08$S8n23hNNt7XiCYPPv2SvZukjVyFjkdRNa6s69ljKhlfuA4pasSxaG','2015-04-23 09:28:33'),
	(92,'$2a$08$9QIqMrOvYQpDEWs/9fuMI.SOuHCWEs/NsBcESizSdvbgmq0QSiony','2015-04-23 09:33:08'),
	(94,'$2a$08$M.ktkIl01MT2P0DiBKgis.tBx8i579Cj1ng8XN3GWAx1SSsOeBZEi','2015-04-23 09:34:57'),
	(96,'$2a$08$vwTz8Ya5IzWYg.Fd5jJ9c.gWgjzaCoZ/6abt3lGqjuQFdS0IZQXnm','2015-04-23 09:35:10'),
	(98,'$2a$08$RLdCwuMn75X6axAMWPommuvvzWJUcN2WyCkYXj4PBkuQorkw50tTO','2015-04-24 02:48:47'),
	(100,'$2a$08$tdfxgQkLPtLnIbXo9T21n.enNcquV7nyKBi9HkE7WQFfDIW15iHEO','2015-04-24 02:49:56'),
	(102,'$2a$08$jAOXDQmW0R6nb7BHmv5Ia.ke8ASeU2Sctb30TVt8IeM.WgbMYnjOK','2015-04-24 02:52:31'),
	(104,'$2a$08$ScvikOmsqtNZQWMsEj1mxe16zdaSXX3ths7FJ3UuLBMic2VkBmJnq','2015-04-24 02:58:38'),
	(106,'$2a$08$dB.Uypr6U11Umh2LQQLMiOwpTwBm/5an227uh21TXFabmjtU6UaKi','2015-04-25 01:45:50'),
	(109,'$2a$08$pm/Ukv5W.naB9Vzz4WeyV..cgwLCpQr.iA7Ma5/lNmmcDrtG4N6ai','2015-04-25 19:25:36'),
	(110,'$2a$08$59MkwvNltnFvSo6Zc92rgOeTYN0/pDkftzlrtuQVNNgyMcAFqg8Zy','2015-04-25 19:25:36'),
	(111,'$2a$08$MnMGhBxkwSwfAU9GADbSDOgblwJTzB.DxoKI83og1M.ybSaiMFgGq','2015-04-26 02:43:37'),
	(112,'$2a$08$wJlg1pSadtujVF1z.tvkzuARb5ZmX9JgInXWH1rIR7S4.KcIMpoF6','2015-04-26 02:43:38'),
	(113,'$2a$08$5Va.81ibJt5ubZSkOgBVi.jBbHEccS9o4ICvdcCS1ZmPPZq28LDri','2015-04-26 02:44:16'),
	(114,'$2a$08$N.s/u5N9KQ/O/i7hohEaT.kPtXOQXlISSeo/4sRKzR/KIU9BWzb7W','2015-04-26 02:44:16'),
	(115,'$2a$08$Td.WR/1KsS8ThXbYLNvKiOPGn/y5z9la1B4pZxuz8Ac6gJ9PGVhN2','2015-04-26 02:45:01'),
	(116,'$2a$08$hQ3b1cUFJliKGuCfQfaD9e9VUyB1.E.gLFArBXWCiQvYo.018Z0rK','2015-04-26 02:45:01'),
	(117,'$2a$08$qz35pa0Pf3QD3v.SLj9kyO.xwxktIOxrqdbQl2ErX36cCCMzzeBna','2015-04-26 02:45:55'),
	(118,'$2a$08$nh7ijnbnuHdzIRHeiD/kVeeNAIovNP/160koB3RNmAwylovYB/ge2','2015-04-26 02:45:55'),
	(119,'$2a$08$U1dDRMqvJb34R6uXaLDaIe3eB3gMHdCwu/1EFuoFDqPOG36ZMpCQS','2015-04-26 02:47:37'),
	(120,'$2a$08$Q6ZNXEO6GHIJZWNyFOqypekFpVuazjxdfXse1AZm8D2AKzlkxZpfm','2015-04-26 02:52:49'),
	(121,'$2a$08$PwwQcU6iX2rYvVAuta4tz.HBFttTtfTOeEAJ5YNckN9l3T84ihPz6','2015-04-26 02:53:48'),
	(122,'$2a$08$NIocNBngz2gmgKWemzgQ6uaabF.aF7loWFCuPMNOWcp4i.GitxGcy','2015-04-26 02:54:02'),
	(124,'$2a$08$WCD7bvIu5FWIppK98f5.DOgbilt0ssnbFidBGZ/LMmPbjq327s2Iq','2015-04-26 02:55:37'),
	(125,'$2a$08$YJNb2dTXwk0NzOyzAGaT2.oZyKkVdUjgyvJb59v9QDjPX8kq.v/B2','2015-04-26 02:55:47'),
	(126,'$2a$08$eMBTN45f8wAVVvHWGyXyB.jA4Kr3MdRHY5M8yHHoLX3vz8xczLUi6','2015-04-26 02:55:47'),
	(133,'$2a$08$uclXWMLAzEFXEKONDgzrL.s4zu2GLk7bK3cn5YlAh9NksJuzLNk8a','2015-04-27 10:25:45'),
	(155,'$2a$08$tNtAlE8swQB60o3BYYhm3uaytspNKZ39wk5fSE1Z.huGu2vOcBsFm','2015-04-30 19:21:35'),
	(156,'$2a$08$wYQm/1PJesAFzIrMUdpE8u/hP9W4FcCXdhRyD3jnUCui7chc.GFce','2015-04-30 19:21:35'),
	(165,'$2a$08$MuplGJlcfsRn4jgJHByy6.2kK.rmOjntfB1t1kbJfOiEMb772L/Dm','2015-05-01 10:31:02'),
	(166,'$2a$08$IMwVLZd.ieNquSnqCzBByu/HKpzUxWRnVba3NySbgRX7pSMHbHgyC','2015-05-01 10:31:02'),
	(167,'$2a$08$C8yBMqWeLpeKeAQCXl2cE.PM0lKi87gDOgkUeSZH9Tl74gU8oOh0S','2015-05-01 10:31:18'),
	(169,'$2a$08$V2xO7l04iqqSecriSjjabutgVIz4SdoniGthNH8MUoqMiM1USgFcm','2015-05-01 10:52:31'),
	(170,'$2a$08$q6WYUEpxoIoMSC6q6sL2cuBDDl7VFEe0iAcga5lq3HLS5ynUP4Puy','2015-05-01 10:52:32'),
	(177,'$2a$08$JYwab05gADcykkfMWpEKAe9QHzSSFueyfvpbmtm0jSRaPqdWlw44K','2015-05-01 12:19:56'),
	(178,'$2a$08$vMchFkknT5igFDRCvWn8k.VBQLitPSg3kf13IdPXqoHW1y8MDmzim','2015-05-01 12:20:54'),
	(179,'$2a$08$yrBp7h9pYx4jA9K6sRTMq.a8W3OcouWU.sJUUytG5xDPcTxzDzRBS','2015-05-01 12:21:59'),
	(180,'$2a$08$mAK1Q.MFwS6WogLYyr.cz.iigQjhXSciXIHQe2qePNrqtQDgx7IiG','2015-05-01 12:22:05'),
	(181,'$2a$08$M26L8vBRqoqhayvdmZvos.w28LLu.VYumVeblU3KoEYeFB27uQMqu','2015-05-01 12:24:33'),
	(182,'$2a$08$ZAZ.F2kRpw12hq1HTtPIv..na19PZG.aEr82LYsugo2En2eS/KyI2','2015-05-01 12:25:22'),
	(183,'$2a$08$jk2OeGr3Lmv1S6sHmHJNuuriEU9Fbq36tZQtHI17anq/VC4S2HD7S','2015-05-01 12:26:10'),
	(184,'$2a$08$RhkpcgdnY/Hr8q4ZtX0nJ.YeQZMLuL0tSTP.lQHCL8Q.WmoUrJVba','2015-05-01 12:29:30'),
	(185,'$2a$08$4UgL08Rg7lFO/peTQ8dMse30Kmkn4wbdjEINxG1qc64KJk2azjULq','2015-05-01 12:29:42'),
	(186,'$2a$08$IBqucEur8XyCAgaLQfzM0un5fss1i/3T44GAvvJvSzpCsdzhNw1yq','2015-05-01 12:30:41'),
	(187,'$2a$08$2pSx1Wh717P2TPGd6.tiIuBH.ScBilgLxGXji.Zm9xGn2gTyM2jq2','2015-05-01 12:30:48'),
	(188,'$2a$08$BJW546RjqzFix9RJAmWJ0.T4aoRM62nCeI1tugYFUvWrzb7fvD6Ue','2015-05-01 12:32:31'),
	(189,'$2a$08$pFtD3eD4cXIK1JJ1REHn6uUnO6PytIisCGlf3dw7jSX.7fJNSIH5q','2015-05-01 12:35:25'),
	(190,'$2a$08$2kGfzlJLBv9TCKy5u4PSOuoEQU5og87i.CAS0rIDTiUMOxt7T/KeG','2015-05-01 12:36:56'),
	(191,'$2a$08$cBq2n6w9vFOAm7afCpHpS.2A88eVGsmW79Uz6EhVFjMvb4h9NksJi','2015-05-01 12:39:45'),
	(192,'$2a$08$xrQAI0idD0uyuwJdG6LCdeXwghj7LQ.ssb2vK6.RLT8mah7DdSBCK','2015-05-01 12:40:43'),
	(193,'$2a$08$2FQ7UkYHfV5/OnkZskjkMe414J6oXDUrPKFNpdwpZWEWxaTIiX4gi','2015-05-01 12:42:07'),
	(194,'$2a$08$kd8udztM.70NtV/NczJx7e4CaTKhDAdjq79Gymq3/qmSyoKFU.Fke','2015-05-01 12:42:13'),
	(195,'$2a$08$NN02MHOr3w40pNJaDCk4.eLXCETYJ9Y/OaNFUFHWEnZHPHoFZ4.xO','2015-05-01 12:43:29'),
	(196,'$2a$08$XQzPhlQcx.Oq0fywGd/4I.5QEnZId8UdTQRbDAwR8WnwcsCNtz4qy','2015-05-01 12:44:34'),
	(197,'$2a$08$YKfX1Ywkxjb9A8K0DIYkMetoRpzDu2bArvyLfxX7Qjwnq7j/qrjYO','2015-05-01 12:46:13'),
	(198,'$2a$08$BWh2YhykNvgtWnkDzt3XduQjjhvqTFEiCBs/FhT6U3epVV47KNKsC','2015-05-01 12:46:24'),
	(205,'$2a$08$TxMuGsd4pWvBfABTxdiv7eIiFBwaL9FLr2PxwUKg/BvVpEkjQNJci','2015-05-01 13:05:37'),
	(206,'$2a$08$U1ih1l.v8JJv8SxhfmB7RuvSxuk3M3KLhjdbM1bWn2KVwly4e9neW','2015-05-01 13:27:13'),
	(207,'$2a$08$f7jKMI4TRRmG6Wv6kPLSOuQhbTGn7fSP0J5f6LRT024lgruGur1y.','2015-05-01 13:30:05'),
	(208,'$2a$08$X0ltaPcn3cVZZ7yhIW43H.X32y.DOnTsxTGER4Zj/yx/cxDThaufG','2015-05-01 13:32:06'),
	(209,'$2a$08$uYMcR.k4CdBgTd7kJGawC.SC.obG7oox.Yh/CVHsdkpdHUjvbq6.W','2015-05-01 13:32:45'),
	(210,'$2a$08$tKtCwMfi4FIx7iLr.CI2/.sBgxGm1SBkqBUQAwf06CqhgiwW.aiFW','2015-05-01 13:34:04'),
	(211,'$2a$08$d8kGxD7eCCF2YUknRc8pVO6jqGVHECmk93Ok7hjMxCzGoTFFNmykK','2015-05-01 13:34:33'),
	(212,'$2a$08$RphiMx4Xha0LzTh.VSX6u.tuuOvKreiBe5CV.srJAyS6wkZg2NrgS','2015-05-01 13:35:02'),
	(213,'$2a$08$bLEgWRf3WmBfGkv5rcvYIegNMLAc47nF89moJrNfrcSwb54ISvRjK','2015-05-01 13:35:22'),
	(214,'$2a$08$YYhf.oueJvjKX7jWraoJNuITOr7WEYBMS1zCOIxpI2n8MbIW.f9/6','2015-05-01 13:35:43'),
	(215,'$2a$08$nLnaaC8rIiFgqqeVXqCDLeIEAMYcSAkEamdQc.FfaFzL7x9lrIgGC','2015-05-01 13:36:11'),
	(216,'$2a$08$Z7BVjYTpUSs7xiztC6NUcu4pU7Z3gBDWEjz9tvJU42iMJO97NynB.','2015-05-01 13:36:38'),
	(217,'$2a$08$SxEk6uG2vlCji7MabEErveIZCEMFd9RUCAsXMR1WFEk4V0v4lZeKa','2015-05-01 13:37:01'),
	(218,'$2a$08$bCymk2x2jmgYEfd99wcJVube3/XmLl2iBD3hcLPEuUngdrxQOMpRO','2015-05-01 13:37:41'),
	(219,'$2a$08$21yO3ZmiaMZUaIArdm/vluE6nJ3l1vLP0CZU7NlycnQAN/eNKL9oy','2015-05-01 13:38:16'),
	(220,'$2a$08$SwOaVhRr9UYV89.AMqCp3.oJKZPYBIIuDg3koejjebCkgDhVuhZNm','2015-05-01 14:09:04'),
	(221,'$2a$08$YkweBab9ap7ly8ngRvrxFOUuVWVpKU.mS9VHhu.7t7TODc9g4xCS6','2015-05-01 14:09:04'),
	(222,'$2a$08$pLGBolzgMCD2eZ1U10VAK.gIh0ibwpIXCYe8Ag4CI/ANhRx7wyfXC','2015-05-01 14:09:46'),
	(223,'$2a$08$UAW40vQgrpRh9QofD81ayOAnkleFN3kya1fcShFdmEKp2kxQHSRa2','2015-05-01 14:09:46'),
	(238,'$2a$08$gcbXfTy43gVxqgkGHX2TheE6ZRfuMDUJnQbNiOZtWzCMFMrCAlx3a','2015-05-01 17:18:10'),
	(239,'$2a$08$Bcz6wsw8g781Hxg3yzR9ZeZJkiH9CLqpE6BWnKpYNBdfai.1rcySq','2015-05-01 17:18:23'),
	(240,'$2a$08$yEYmsgJY1rbi4irilr6/Du6ONCyqlQ9lyQxv68/8AMODq.6pcLIrq','2015-05-01 17:26:04'),
	(241,'$2a$08$TuwXLXkBKq0Rb3gLOAtdMOROP.ulf0HRWpJQSF27EHS.0oMN67lj2','2015-05-01 17:26:44');

/*!40000 ALTER TABLE `user_access` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы user_roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles` (
  `id` tinyint(1) unsigned NOT NULL,
  `name` varchar(45) DEFAULT NULL COMMENT 'User Roles table',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 MAX_ROWS=5;

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;

INSERT INTO `user_roles` (`id`, `name`)
VALUES
	(0,'User'),
	(1,'Admin');

/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `login` varchar(40) NOT NULL DEFAULT '' COMMENT 'User login',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT 'User name',
  `surname` varchar(40) NOT NULL DEFAULT '' COMMENT 'User surname',
  `password` varchar(150) NOT NULL DEFAULT '' COMMENT 'Password hash',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Common users table';

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `login`, `name`, `surname`, `password`, `role`, `state`, `rating`, `ip`, `ua`, `date_registration`, `date_lastvisit`)
VALUES
	(11,'user@gmail.com','stanisovw@gmail.com','','$2a$08$n9WNEktlDCbVqPZ8faZzVOvPuoi4XZr2beSusccYt6GKpatmPsTT2',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-02-21 04:31:14','2015-04-24 17:34:12'),
	(12,'userundefined@gmail.com','TestRestoreUser','','$2a$08$u2JwylpmT1kQe7F5THPFGukEJowTpPRpTuy/oC/JgIAat5luLLEV6',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36','2015-02-22 13:37:59','2015-04-02 12:31:13'),
	(13,'380954916517','stanisov3@gmail.com','','$2a$08$UjZozSsEDc7svQDWWC4w/e/VEFO9tPvfKNSfYmFntiUFgR80UCMQ.',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36','2015-02-22 14:36:52','2015-04-02 17:10:38'),
	(14,'stanisov4@gmail.com','dcdcdcdcdc','','wwwwww',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 05:45:43','2015-03-09 05:45:43'),
	(15,'admin@admin.ua','AdminTester','','$2a$08$GpGWBJuVavKO2/NOYaM45eSOyi1MiygFUEMDecvppWtCR5xsWN8RC',1,'0',0,2130706433,'Symfony2 BrowserKit','2015-03-09 05:48:23','2015-04-24 17:34:13'),
	(16,'qstanisov@gmail.com','qqqqqq','','qqqqqq',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 05:51:12','2015-03-09 05:51:12'),
	(17,'ssss@mail.ua','ssss@mail.ua','','ssss@mail.ua',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 05:54:21','2015-03-09 05:54:21'),
	(18,'sss2@mail.ua','ssss@mail.ua','','ssss@mail.ua',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 05:55:23','2015-03-09 05:55:23'),
	(19,'stanisov44@gmail.com','stanisov4@gmail.com','','stanisov4@gmail.com',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 05:57:00','2015-03-09 05:57:00'),
	(20,'sssdsd2@msdsd.uA','sssdsd2@msdsd.uA','','sssdsd2@msdsd.uA',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 05:59:14','2015-03-09 05:59:14'),
	(21,'asasas@mail.fj','asasas@mail.fj','','asasas@mail.fj',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 06:03:03','2015-03-09 06:03:03'),
	(22,'asasa@sdsdsd.er','asasa@sdsdsd.er','','asasa@sdsdsd.er',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 06:34:23','2015-03-09 06:34:23'),
	(23,'asassfdf@sds.ua','asassfdf@sds.ua','','$2a$08$yWl8VCT1yCfkac8a5gVfeuLnLnAlmpobG7euC6w2BV85NaJjEBrym',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:01:05','2015-03-09 07:01:05'),
	(24,'credential@sdsdsd.ua','$credential@sdsdsd.ua','','$2a$08$70SWdTIlqfBx.59c1GpvQORFGOrj5H6p83BQbCBUABjJcoEa6O8mi',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:02:25','2015-03-09 07:02:25'),
	(25,'stanisovddddd@mail.ewe','stanisovddddd@mail.ewe','','$2a$08$y4P38MNLvUl3k3L0OmF6LeYd0N1bA4pGKEkO54fuOxjzYuKSO7Nv2',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:04:33','2015-03-09 07:04:33'),
	(26,'sdsfgfgfl@ksds.ua','sdsfgfgfl@ksds.ua','','$2a$08$XRFx3poEIMT7wn0dKoMiyeSNynu/BAfgAQbbG95LL0G4Psp/QOHQ2',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:05:48','2015-03-09 07:05:48'),
	(27,'dsdsffgfg@mail.cu','dsdsffgfg@mail.cu','','$2a$08$XdG3lDu.o0XVRN/lOp0zyOyDGxY/TDLmtVjO7GwJQMqTioU8.HKG.',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:07:36','2015-03-09 07:07:36'),
	(28,'gfhgfh@dfdfd.ia','gfhgfh@dfdfd.ia','','$2a$08$WiKNINxRZGHm8cD1esGtieRfNnqA2PgaGi729KPvDBhnazoah/O.e',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:14:58','2015-03-09 07:14:58'),
	(29,'rer@erer2.ua','rer@erer','','$2a$08$eW3FlhO32GSrTgclk3evQOUMzdBx0VqTTBYIxAuRUGFJ6tszn6FLO',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:17:51','2015-03-09 07:17:51'),
	(30,'fdsgf@asdsa.ua','fdsgf@asdsa.ua','','$2a$08$QNBEocj/fytqlnM2x3qNkeiRh2uRnLnCgEz2eKr9gZZ4ahKJP6sSC',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:20:57','2015-03-09 07:20:57'),
	(31,'ddffff@mail.ru','ddffff@mail.ru','','$2a$08$vzeuVMFudlFKdi/wERuR4Ov4Dy6BH8Zn2Qf1IDnGburGzsLWQaYUe',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:22:46','2015-03-09 07:22:46'),
	(32,'ddffff@mail.ru2','ddffff@mail.ru2','','$2a$08$G1DYLGCUb14lr5hNy/e83uOPYK3VlRmpAXPDiDcSXNUi1VLjdPQJe',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:43:32','2015-03-12 02:13:37'),
	(33,'ddffff@mail.ru22','ddffff@mail.ru22','','$2a$08$V.SUyESC46HEmOtvmEXRLeiX.6TLxYcClLR93x42KkNT/m2AQy8rS',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 07:45:37','2015-03-09 07:45:37'),
	(34,'stanisovwewwew@gmail.com','stanisov@gmail.com','','$2a$08$M.NVYcQeTbp7NBNwR4qTdOKmg.0KYBriIvmhpT/M2Aiz52aEP1.7C',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-03-31 14:23:17','2015-03-31 14:23:17'),
	(35,'1980634175@1469152825.com','CodeceptionTester','','$2a$08$I1Mq.lVWgM7ScFnLIdSnTOR4qq0xw.EOUX1PYqWIy.MSBg.UDa5Om',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-03-31 14:24:06','2015-03-31 14:24:06'),
	(36,'stanisov2@wewgmail.com','stanisov@gmail.com','','$2a$08$7JjHP0/vp9zGGDbKnl3dZOGA9l3syPjR1nm0KTvL.bYc5EpjLltqq',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-03-31 15:21:21','2015-03-31 15:21:21'),
	(37,'stanis2ov2@wewgmail.com','stanisov@gmail.com','','$2a$08$J0UJFK2p9ZHpJPLYRIjHTO68LtqoTUuXxrojOf92HlCYDR1ru.wCS',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-03-31 15:24:12','2015-03-31 15:24:12'),
	(38,'stanisov232@wewgmail.com','stanisov@gmail.com','','$2a$08$e7wSzmRRlAIs.9SIWuuMr.TaPJ8wgF09dtwdFLPaoboqb7C1OwSIK',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-03-31 17:27:55','2015-03-31 17:27:55'),
	(39,'stanisov2232@wewgmail.com','stanisov@gmail.com','','$2a$08$gsPEBHk0HJH/meaJgdE2keAL/rgXwfWZLvK2g5nWAKI4kEYWtfzXG',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-03-31 17:28:30','2015-03-31 17:28:30'),
	(40,'stanisov22232@wewgmail.com','stanisov@gmail.com','','$2a$08$ydcK5r5tWRE967qyGcmjDeFGJHdyPOMlVFJaVknqcuz6J0OpZ25Am',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-03-31 17:28:54','2015-03-31 17:28:54'),
	(41,'stanis1ov22232@wewgmail.com','stanisov@gmail.com','','$2a$08$Ixua.kzkRevn5/9nqOLwXeYNOohodv3QthiolVYU3vJ5qy2Xu2B/W',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-03-31 17:29:12','2015-03-31 17:29:12'),
	(42,'stanis1ov22232@we3wgmail.com','stanisov@gmail.com','','$2a$08$zRmkBEq5mZYBPLcUlgHxZeE3jMt8HkYr7rzEJPk10L3dAtR8YJuWO',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-03-31 17:29:46','2015-03-31 17:29:46'),
	(43,'stnis1ov22232@we3wgmail.com','stanisov@gmail.com','','$2a$08$5LdfVKXBdATLpQHVzwt4JO95oK/4LaWAGjBD1QQS7TwODChbQUZZO',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-03-31 17:30:15','2015-03-31 17:30:15'),
	(44,'logoutuser@logoutuser.com','LogoutUser','','$2a$08$3uCl4QlMluTR/4TX8qwmeeaVI.PSHVJsTw8OPwthwVamoCJ8j7dJm',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-03-31 17:30:47','2015-04-24 12:11:45'),
	(45,'stnis12ov222332@we3wgmail.com','stanisov@gmail.com','','$2a$08$dCRUlbFlG0u7bP6gH7MTm.mDHo/nArE.ZkeSYx3PbVMDRsKSPfLD6',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-03-31 17:30:53','2015-03-31 17:30:53'),
	(46,'1356546924@38359461.com','CodeceptionTester','','$2a$08$bk3I53NsgEcl8cHhaovcZukQNXDrduPsXkhKnrytuTA9gDmBUTfNC',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-03-31 18:43:05','2015-03-31 18:43:05'),
	(47,'1503413079@1472169146.com','CodeceptionTester','','$2a$08$ex20i7n9dS8vu2UrNNkDieTRFB47VLZo.n/Eu7igaqJQ.8Q3vvKPC',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-03-31 18:52:37','2015-03-31 18:52:37'),
	(48,'151669929@625129123.com','CodeceptionTester','','$2a$08$Qn7JisY1iboqIFO7BPH.gOo4DbaggKld0nFe.jcdJTSid.B1fjGoK',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-03-31 20:29:13','2015-03-31 20:29:13'),
	(49,'test@mail.ruww','StanislavTester','','$2a$08$zj5uVbwNahlGr9Y5lXr2x.4GYcT0Yh69srrYw69BkBeSs7fB7ng6S',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-04-01 00:07:38','2015-04-01 00:07:38'),
	(50,'teqqst@mail.ruww','StanislavTesqter','','$2a$08$09KhAvZOmEfmwT3cwj8S5.AHf6L9ncHT88VXFg2ZORT.rT7tsD5DO',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-04-01 00:15:13','2015-04-01 00:15:13'),
	(51,'testuser@qmail.ru','StanislavTester','','$2a$08$jixQpjJtU69X6QUQYk1wP.hESGHGsUZqBe4LKB7DEZ2x4GpttXk1G',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-04-01 00:16:48','2015-04-01 00:16:48'),
	(52,'1417103358@957110347.com','CodeceptionTester','','$2a$08$th6LMvTQ6aS9OI0DSEJPmuXAJv0gAoFeEGeMSBq60KoAw1jqkk75i',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-01 12:04:14','2015-04-01 12:04:14'),
	(53,'1883971273@965515154.com','CodeceptionTester','','$2a$08$ZM.Ts9SDRbpMOJkRw2McYOx1TZ6.z4Q/ZeufavRabqsptavMlIgXe',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-01 12:08:21','2015-04-01 12:08:21'),
	(54,'599324794@1242578991.com','CodeceptionTester','','$2a$08$eCQQSc0XLmH2.arJhQmQ8u8yjwpN9mDVIvAUXa6CzPYmG7kLP7POC',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-01 12:08:53','2015-04-01 12:08:53'),
	(55,'1385637827@1482547037.com','CodeceptionTester','','$2a$08$/AkpUH26kdz2SnIIJOqg.OhRE2KM5lqcqXXXor0IfFhMBNlwls7B2',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-01 12:09:05','2015-04-01 12:09:05'),
	(56,'1798900866@256465155.com','CodeceptionTester','','$2a$08$Xhb2lMPcYAjubb1VdpFWiu/adPeFTkjJn3HUJVZgvKoHZ4ISTo5RS',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-01 12:12:05','2015-04-01 12:12:05'),
	(57,'1987628893@1804164931.com','CodeceptionTester','','$2a$08$6x0dGRws5n.lUzAUSzSKQu.ALoppnsu4LqqEcn6RVnaNesSz3nIue',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-01 12:12:22','2015-04-01 12:12:22'),
	(58,'1158649052@1032212238.com','CodeceptionTester','','$2a$08$xzZ2KFM.iUl.RbuHHjeUL.lbdybdLhvk0q6507/FSMduqTnsyQlhi',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-01 12:30:53','2015-04-01 12:30:53'),
	(59,'stanisov3442@wewgmail.com','stanisov@gmail.com','','$2a$08$1sYYENbzVfNG97L5FQqsIeIFcHYluxqO5MAy43VCCEFSJs8XB367a',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-04-01 12:31:32','2015-04-01 12:31:32'),
	(60,'stanisov3442@wewgmail.com34','stanisov@gmail.com','','$2a$08$/4ITunQ241qCxTmAhtf4AOEnb1BhPWGty.J5D21nGF3QMCTMmlGHq',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-04-01 12:32:33','2015-04-01 12:32:33'),
	(61,'stanisovwe3442@wewgmail.com34','stanisov@gmail.com','','$2a$08$YtdkkJHVlT2HLcXjUPG8KO7MxsQk9gerZOjNtUbMO775vzfMXUoFa',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-04-01 12:32:55','2015-04-01 12:32:55'),
	(62,'stweanisov2@wewgmail.com','stanisov@gmail.com','','$2a$08$c9mXmFL0zBgwU2Wt1UfEY.jAdBSIULnfEo/jNc24cgsIKL385htNa',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-04-01 12:35:09','2015-04-01 12:35:09'),
	(63,'stwean34isov2@wewgmail.com','stanisov@gmail.com','','$2a$08$m4Oj3RqemvYbo5gLopZ3BeDkCi5fLpu1RYpodg2d0gfVqg5S2fK7m',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-04-01 12:35:48','2015-04-01 12:35:48'),
	(64,'2066202914@877925423.com','CodeceptionTester','','$2a$08$pATQm7CywkUzDUG4ErnPRusIOzaf.CnY1Jw4toumgr2OdDBrW7/QS',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-02 11:15:01','2015-04-02 11:15:01'),
	(65,'1646309651@705864297.com','CodeceptionTester','','$2a$08$jFoLJ4VzgKs4pLvMxoLDKOCyomeS19cMP3wFlkzzQ2Yg55qQTNJ3S',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-02 12:27:08','2015-04-02 12:27:08'),
	(66,'1913148572@828523189.com','CodeceptionTester','','$2a$08$T/2oi0aJSyuzgjBx1RPTGe.eKRS9HfA.vr7k4Kaf67GzJcgzmfX1C',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-02 12:29:20','2015-04-02 12:29:20'),
	(67,'629973120@1027920468.com','CodeceptionTester','','$2a$08$.xnNvP4cRbaOYcijYqaTDuD0wttFdYOcpuiUQLHP8aeylnEIAFvpy',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-02 12:29:46','2015-04-02 12:29:46'),
	(68,'1135672924@1464491270.com','CodeceptionTester','','$2a$08$mSst7ifuJx6wu2F3IDSQ1eNzFiLBopzkY6M1nlAkkFhHNkFTUl43C',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-02 12:34:27','2015-04-02 12:34:27'),
	(69,'565160853@371120871.com','CodeceptionTester','','$2a$08$XKnT2Bfa8EnJI0pcTv3JtOp6foo7/A3d8a2OQNRMKwQ67CMNxpIRa',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-02 14:18:01','2015-04-02 14:18:01'),
	(70,'1488014298@1877584569.com','CodeceptionTester','','$2a$08$OIwa8ur0RxLSqH3RYtGlgOOBAb4Xe6.P2x6jwxQNSEI5mx.Mv8ucG',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-02 14:24:03','2015-04-02 14:24:03'),
	(71,'514448206@1870936479.com','CodeceptionTester','','$2a$08$dZ3dPK/EKVvPRLsQdHo33OaZZGWLEpVi1AYJ0AhMqIrlShECwZ/zq',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-02 14:25:35','2015-04-02 14:25:35'),
	(72,'1768311384@1493860176.com','CodeceptionTester','','$2a$08$G1o5sP8ukqFJs6cc93H70ei0.2nFPl0g7W7uiFR7WsTB/dQx3YJ36',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-02 14:26:11','2015-04-02 14:26:11'),
	(73,'stanisov@gmail.com','StasTester','','$2a$08$/mPxVhZxTo2Rq4ntGxXpA.dZVQXtfv8lI7xzwHHZnZ/bESAY60gdC',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-04-02 14:37:04','2015-04-02 14:05:52'),
	(74,'stanisov2ss2@wewgmail.com','stanisov@gmail.com','','$2a$08$zgxULopmZJy89u2AWv5naO7i9ueits0dDeso4Laaqsk8b3utXH3EC',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36','2015-04-02 18:26:29','2015-04-02 18:26:29'),
	(75,'57442569@2060335552.com','CodeceptionTester','','$2a$08$Pckax0vjrgN2e3GFZmxybuen3H5QGzexldGaB7LdadPVnP.BKl57S',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:07:04','2015-04-16 12:07:04'),
	(76,'825234704@524936265.com','CodeceptionTester','','$2a$08$qE7qt1zDiZnRCDQwzO2rR.0lX7WjTH8J6m0Nolh3OklafBNvTPjUG',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:07:57','2015-04-16 12:07:57'),
	(77,'stanisov23@wewgmail.com','stanisov@gmail.com','','$2a$08$fXVBzblKwegZ3YefOmg5ROKwM948tfb2TeLroA6UhNWYNfydzexQq',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36','2015-04-16 12:08:59','2015-04-16 12:08:59'),
	(78,'stanisov223@wewgmail.com','stanisov@gmail.com','','$2a$08$uCi94q0TViXNfCrEZtvk0OIWIIbbtEeplbWNeTnY.bkd5B30.1cLq',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36','2015-04-16 12:11:37','2015-04-16 12:11:37'),
	(79,'1373893319@307293671.com','CodeceptionTester','','$2a$08$NObUpvUT1z7uimGX0rZJoeuKpP4BpS26Z4ZnnQh6AW75tZi1djrz.',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:14:45','2015-04-16 12:14:45'),
	(80,'2121273921@478597088.com','CodeceptionTester','','$2a$08$BZddGrMnwm2ujxwckG/xgOE520H7rO.jn4SIxbXNaelLzgGzVHFF6',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:14:45','2015-04-16 12:14:45'),
	(81,'1174442596@122444204.com','CodeceptionTester','','$2a$08$2VKrHs1AgHW7wjx5Nmy/GuxyYY7Z/WNSkIfBLRYWvBu8Y6Qv47ALC',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:24:16','2015-04-16 12:24:16'),
	(82,'745443902@520376167.com','CodeceptionTester','','$2a$08$ofXmQGvtx2gokmBuL3xFNuqx53VPv5863nnTz18ZDpYOreHTez89a',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:24:17','2015-04-16 12:24:17'),
	(83,'1946581401@1250589184.com','CodeceptionTester','','$2a$08$E4uyrJtcUhhG2OEkvWJ1ze6t3IQjy6O/oNUxMH9fFz751/Q8mf43G',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:24:32','2015-04-16 12:24:32'),
	(84,'1042556367@465801202.com','CodeceptionTester','','$2a$08$FZ7JsR2gEB8OSjah1KqoTOS/KxXaArs3bQcVYqbdDwJjF3txXZD6m',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:24:32','2015-04-16 12:24:32'),
	(85,'794626886@608752202.com','CodeceptionTester','','$2a$08$Sn5NxVd5jau4RtNcqXujGuwnNnvuIqRpF1F.i.d3DiFG9UgH9tuyG',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:27:50','2015-04-16 12:27:50'),
	(86,'622549494@1500424487.com','CodeceptionTester','','$2a$08$oq0OC8lRaACRuauaUj6oJu6ljAwIH16RfOyXUhVWfXM72NWzSEGCq',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:27:50','2015-04-16 12:27:50'),
	(87,'1590360942@1147790028.com','CodeceptionTester','','$2a$08$3e8yRpxTngK8pUu8k9SImOexdkXo4iXAWu75KWkJhYlYdbYilbksy',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:28:06','2015-04-16 12:28:06'),
	(88,'916274800@1961177705.com','CodeceptionTester','','$2a$08$qGOXYRzdMplz9OElesx0XuI/ribUEIpXylthIrZKWAfEtAiGH71.W',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:28:06','2015-04-16 12:28:06'),
	(89,'1702449101@1489017720.com','CodeceptionTester','','$2a$08$tXpNn1SvLS/x7dg7z0L1QeHKaYvUUx/aB6y2UMrgB36fTj21LVLMK',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:28:33','2015-04-16 12:28:33'),
	(90,'1047775485@128051290.com','CodeceptionTester','','$2a$08$ReAAPnO6tzrX5M2Ubi4Kk.lTd1m7M6OEQndKk4rFfMDVTVibFwM/O',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:28:33','2015-04-16 12:28:33'),
	(91,'81097064@2028848052.com','CodeceptionTester','','$2a$08$nQ1hn3U9ESveV3q7iaVjUOEEQTiAbBtH174t0hkLXesgHFBhI5RH.',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:33:08','2015-04-16 12:33:08'),
	(92,'202755125@2112196877.com','CodeceptionTester','','$2a$08$64L1THamgglPbKb0geX4.O/dhCDAX0RvhiYcHlxhFolGDLGKBcxOm',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:33:08','2015-04-16 12:33:08'),
	(93,'2059369560@867502096.com','CodeceptionTester','','$2a$08$BLDQsKUvtOhShXbpp7rs8OgnAFTTjy8henwrrlJrPK/5hrtaHwEJi',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:34:56','2015-04-16 12:34:56'),
	(94,'1513640278@1311701320.com','CodeceptionTester','','$2a$08$vtDC.elbVVad1kS3gqV4L.Qyjsp7K0KNDd9Nmbf4F8pF9NiLeKFxC',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:34:57','2015-04-16 12:34:57'),
	(95,'1775257485@944163275.com','CodeceptionTester','','$2a$08$7iJENS3Y2NSz0ssy1VZHfO/uHwhuflwo8kig35sVmHoPatyoaNvH2',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:35:10','2015-04-16 12:35:10'),
	(96,'1467145428@1461509071.com','CodeceptionTester','','$2a$08$Te1Bn2xVNOqZy5.JHY2jKu3i6jjpK3WboDyGhnxORhr86Thw.TzDC',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-16 12:35:10','2015-04-16 12:35:10'),
	(97,'59496791@950391181.com','CodeceptionTester','','$2a$08$fIo7tNoUCSIegiT.XDzeL.zwt5aszBolO3FjGwIJntrNVZDStQxgC',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-17 02:48:17','2015-04-17 02:48:17'),
	(98,'1998426951@1569881514.com','CodeceptionTester','','$2a$08$Q8.cNTSgZIVrVvfvdWNrJ.VNbLlqCVRPkoM/xQUhayCTorVQkI4gW',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-17 02:48:47','2015-04-17 02:48:47'),
	(99,'440826326@1326631060.com','CodeceptionTester','','$2a$08$aFn2F6P6X2uRgwWVXEZIb.n2yARCsd4tDdvyiDW4U/r2DT5QvDZfi',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-17 02:49:55','2015-04-17 02:49:55'),
	(100,'1839375091@1700313000.com','CodeceptionTester','','$2a$08$NWoXbhnq35mZeOugG/XXg.F9NnSHVYdC7yfsvb30KlD7ergiGxab2',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-17 02:49:56','2015-04-17 02:49:56'),
	(101,'208523123@2037795655.com','CodeceptionTester','','$2a$08$TVdWDMDVS2LyEOdrysa3K.VblkEKTJX8.agoA9Fd8u3jpu8BuFzVy',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-17 02:52:30','2015-04-17 02:52:30'),
	(102,'855078851@283530983.com','CodeceptionTester','','$2a$08$SOnZW.qRsFCjztO3J7hHbe2qNb8rPQXF3zdY2Q59en0.GZKbx/HM2',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-17 02:52:31','2015-04-17 02:52:31'),
	(103,'708480338@2061022113.com','CodeceptionTester','','$2a$08$J35zTgA4eGWU31YqmaxVwOR2JYFuYExkv0yyS/Bp5z9hZR0aSBFDu',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-17 02:58:37','2015-04-17 02:58:37'),
	(104,'1674082755@216467577.com','CodeceptionTester','','$2a$08$DnvCoW2htAJZIa5PgjRwaeOMv1gVRJXnLa1dSC3mfxsFu7v6.iYV6',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-17 02:58:38','2015-04-17 02:58:38'),
	(105,'1228996104@1963959294.com','CodeceptionTester','','$2a$08$m50NZeKZtbSP9yvF72GreeOKHqyrq1F7D3mrXHySFgsLg2H.FjIOa',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-18 01:45:49','2015-04-18 01:45:49'),
	(106,'1961831367@297724556.com','CodeceptionTester','','$2a$08$jPYymcEaP/lTbz5.tJFzWuBfC9wYjRilOYuFQN1Imb27BiNttDMca',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-18 01:45:50','2015-04-18 01:45:50'),
	(107,'1637685479@1199215737.com','CodeceptionTester','','$2a$08$j3O2IIK7pEqnJYTASk0gQeSdwOfCEURQ8Kd/bxXSCr2u9T3hh.hMa',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-18 06:24:11','2015-04-18 06:24:11'),
	(108,'1472634448@2061460716.com','CodeceptionTester','','$2a$08$3pezVdGwaWxzgUYtPLOsXeCZHYmZHCarpuHHoM671gDID75lPRxD2',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-18 06:24:12','2015-04-18 06:24:12'),
	(109,'783506319@1026300277.com','CodeceptionTester','','$2a$08$4dd4sUrfBURA9g7iyvwZQeQVZC4wt277gfafW15ASANc2nKeT15yy',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-18 19:25:36','2015-04-18 19:25:36'),
	(110,'1903275735@1724382253.com','CodeceptionTester','','$2a$08$HH8Jid3eL0itaUNcRXSiMOMg4x22RfQS3HeRsLlzoFEdw2TUuQjvC',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-18 19:25:36','2015-04-18 19:25:36'),
	(111,'1258303594@148538325.com','CodeceptionTester','','$2a$08$d3fErm3acl4G/L0mxKeXteAH/r8eQtRq/ZocX7D4562pyE.oGveo2',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 02:43:37','2015-04-19 02:43:37'),
	(112,'115569353@240817650.com','CodeceptionTester','','$2a$08$Gwl4oRR1qe7OJ3CBRqhid.e8xib5yaJRr6Iob97PjlFYrED65z9Lq',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 02:43:38','2015-04-19 02:43:38'),
	(113,'1001242681@661539662.com','CodeceptionTester','','$2a$08$6OGJ8XfCL7BxT3hydHvfB.c28u3iUOebjtlylM.zQSPixFVvqPSAy',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 02:44:16','2015-04-19 02:44:16'),
	(114,'1168794865@1725413190.com','CodeceptionTester','','$2a$08$2m59UXD8wuGtwUWCS/dmnuWed5DL7PzktSAMn6T7H68ttIwQXy2Py',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 02:44:16','2015-04-19 02:44:16'),
	(115,'817212973@808593109.com','CodeceptionTester','','$2a$08$0qkGKW1PJH.nN92xMq9cYuBQiEl0lEgyQux8H3.c0ORYznzoww4SW',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 02:45:01','2015-04-19 02:45:01'),
	(116,'2130810358@2014662788.com','CodeceptionTester','','$2a$08$7WF4F0LaBKIPeVWlTG1PB.0n1fBTanAiun.d64wIPNTc7BpW9q6Ce',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 02:45:01','2015-04-19 02:45:01'),
	(117,'820452697@857339321.com','CodeceptionTester','','$2a$08$gbmVtNq0D5dJSxEmQK1gOeYwsiRsURIX91LTi0jf2yDkWto4My6va',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 02:45:55','2015-04-19 02:45:55'),
	(118,'561146262@978617770.com','CodeceptionTester','','$2a$08$KAYaKjSFzmrlaR/PWCIbiuVTzwMk9VGjkeMNz9rNoK.w3w2uC1BfC',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 02:45:55','2015-04-19 02:45:55'),
	(119,'testuser@qmail8.ru','StanislavTester','','$2a$08$nv6wu.1zh4ezyOqkCD38qOZbrfZDvYCJtaDr5bCdaFvthgDF2oliy',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36','2015-04-19 02:47:37','2015-04-19 02:47:37'),
	(120,'591591315@65375068.com','CodeceptionTester','','$2a$08$L4nbDfj2dY8nP2HYgrmGXu/4YWrz10XERdeMzV.MySOLN/hHoh.BC',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 02:52:48','2015-04-19 02:52:48'),
	(121,'1488919939@1161739986.com','CodeceptionTester','','$2a$08$.t94xAypcP.2xd5RTKKBNe6cMZu5UjZTzLKM0rg4P06mMrDWvH5hu',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 02:53:48','2015-04-19 02:53:48'),
	(122,'723402998@1577618321.com','CodeceptionTester','','$2a$08$ZAu46TV.jDMTlgsQFLMhSeVkxlJHvTQCCufh8EI5jDJzOGZdLF2p2',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 02:54:02','2015-04-19 02:54:02'),
	(123,'7234029982@1577618321.com','CodeceptionTester','','$2a$08$b8nVoJ4uKa9.zqHsBnWf4uVpA9lpRMYBgkX4hYRBfjTTwJDfC/gE.',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36','2015-04-19 02:55:03','2015-04-19 02:55:03'),
	(124,'348458057@1680787871.com','CodeceptionTester','','$2a$08$EldRk0hjTodsjpXBDmLRnu9kDNlTTTiozsQzE9igBtfU3HziLUAUm',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 02:55:37','2015-04-19 02:55:37'),
	(125,'1538109218@597104817.com','CodeceptionTester','','$2a$08$nl1T.ySRvId/NJKrdhuR6uE2XBqDKBi.bzp9mPfgvL61dBKm9tcL2',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 02:55:47','2015-04-19 02:55:47'),
	(126,'1471099169@1941071111.com','CodeceptionTester','','$2a$08$Vnugt7I.Cyus5QgmS85A7uNVsNzmRcF4K2VZnJETfV9wbCl2rFMnW',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 02:55:47','2015-04-19 02:55:47'),
	(127,'414791748@1462067812.com','CodeceptionTester','','$2a$08$ym8YtkbMBedIt3FdoJrcbu/cHwEbb39AFPJd7ojB2VItz148MTYuu',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 03:01:49','2015-04-19 03:01:50'),
	(128,'2115009308@1995102413.com','CodeceptionTester','','$2a$08$cXOMfVjpnDCKsA2mrFnj4OkMeVanG714NXXlSFcWlDg0YyMzhXAE6',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 03:01:50','2015-04-19 03:01:50'),
	(129,'432445912@102496857.com','CodeceptionTester','','$2a$08$rCE80ZQYSZLYZIesBMVcj.IKaxdEqHdECLYUitfnP8EcKbRhgx11y',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 22:39:08','2015-04-19 22:39:09'),
	(130,'1207651669@1411510032.com','CodeceptionTester','','$2a$08$ejX6u5J0NfafPS9UASt8p.sbnsmcqpDMSU8JHZPr0JpqM4IOosmxy',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-19 22:39:09','2015-04-19 22:39:09'),
	(131,'986482928@824034296.com','CodeceptionTester','','$2a$08$5AnmBziE5MCqYz6tCxc80ugGsBQPaxjQYliG5a1dHNd3pQ/FzkQp.',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-20 10:23:21','2015-04-20 10:23:21'),
	(132,'1909729420@1189397387.com','CodeceptionTester','','$2a$08$vHPVD5.faS9vgqZcmfElFuhDHeAs5I1nGmf6xdt0TvpBvp4ij1Z.a',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-20 10:23:22','2015-04-20 10:23:22'),
	(133,'tes3tuser@qmail.ru','StanislavTester','','$2a$08$DHY5ka5lnLn3kOBAh/bVMO5QGUxJbRPMwbdbw2NYScuISSxMboSfu',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-20 10:25:45','2015-04-20 10:25:45'),
	(134,'1392190207@96450592.com','CodeceptionTester','','$2a$08$6vpKU5NXOtMtSWabgAhiwuapZoMDcUQBbRcXTMFNob.3apO7YGqda',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-21 10:09:00','2015-04-21 10:09:01'),
	(135,'151855928@431028898.com','CodeceptionTester','','$2a$08$7944myWuQ9h8eLslOhNfgeP9dGm5EPDp.TihiIVVxA/2MdOi4K4fO',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-21 10:09:02','2015-04-21 10:09:02'),
	(136,'1742367426@872974597.com','CodeceptionTester','','$2a$08$NAAnA9DIlBq3/mdJE4WlGOZPoRf/JYxRHaWRvoKeo6A5ZvTwGsQJm',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-21 10:11:56','2015-04-21 10:11:56'),
	(137,'1982837673@1531364421.com','CodeceptionTester','','$2a$08$OMas2zUUoTrTTIkCc3a4cuL.RrisBBX18iiojsUDBYCUSuOCZ7HGO',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-21 10:11:57','2015-04-21 10:11:57'),
	(138,'176595077@45849659.com','CodeceptionTester','','$2a$08$laKGd2Npd4lL4PVHJuMyxOIqA/wFI8MqCDRt1KHNSlbmmmaaGeYwO',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-21 13:43:17','2015-04-21 10:43:17'),
	(139,'1197451729@1588205564.com','CodeceptionTester','','$2a$08$rIE.H2/fo4J/YJMaAzxkau8JHIzvL9hu.rVp3Uukl.wdOzQzIsbXa',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-21 13:43:17','2015-04-21 10:43:17'),
	(140,'10741485@1779436365.com','CodeceptionTester','','$2a$08$rs6nUYuUtP4ydK1tPmC4JecnJl1PFBsUIxmKy6VkX4NnQpHGwIfdm',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-21 13:44:56','2015-04-21 10:44:56'),
	(141,'945916769@470307922.com','CodeceptionTester','','$2a$08$GBiwDeSqRs0F7jPZ6lhcUO27Nr4ty0EvSb0WtSiLHtnb9TE8LWIEK',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-21 13:44:56','2015-04-21 10:44:56'),
	(142,'257346641@266736192.com','CodeceptionTester','','$2a$08$PanV9ZcoSE0n62TROiBat.j3Mmj4fTTUgkntJ02T/XmSOsMDY7ns.',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-21 13:47:02','2015-04-21 10:47:02'),
	(143,'1161532438@1124080764.com','CodeceptionTester','','$2a$08$XJlears7FuUXLfOhnM2/S.PyXy3lsQR0j6Q.ymkebmOu3b2wGTTQ.',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-21 13:47:02','2015-04-21 10:47:02'),
	(144,'stanisov234@wewgmail.com','stanisov@gmail.com','','$2a$08$KPPrk6h2koo7KK5bkLaHLux1FAAkav.3jsO62PdEyYQvMO6FZM1Zi',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-21 15:17:44','2015-04-21 15:17:44'),
	(145,'1533518461@105560871.com','CodeceptionTester','','$2a$08$Ew7rYag4pcLnD5crXCew4uVmUopj8XIiz14DZ81vi4BNZVPR6YNZu',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-21 15:29:19','2015-04-21 12:29:19'),
	(146,'400157745@598426829.com','CodeceptionTester','','$2a$08$sng.pKcLKmAU8iIJitmKbejDwyWVlJ/aD.B2OFwgskbx2YrCdUIp.',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-21 15:29:19','2015-04-21 12:29:19'),
	(147,'1760937205@1325430184.com','CodeceptionTester','','$2a$08$ifJHCeeTOgFnDHcLNjkpgOhCtJMjRLDT6gZnD4v8m1cd2APxmw8Iu',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 21:53:51','2015-04-23 18:53:51'),
	(148,'1939667851@1118288304.com','CodeceptionTester','','$2a$08$.JQXH7gnzVhHOpeYOFlymeLF2nv2XOrl12teD8fX28ZlyT5GT.o8.',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 21:53:51','2015-04-23 18:53:51'),
	(149,'1158890553@1737183688.com','CodeceptionTester','','$2a$08$/JXxTT5J0pdR5fxD0FHOs.WtjULs37oLrK04YPCI6zfFB0Nek.s4G',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 22:03:02','2015-04-23 19:03:02'),
	(150,'489229389@1011367326.com','CodeceptionTester','','$2a$08$ijUh.RRJnegokStgrAUYXu5i0MnGadGIyJGwQEouhch.7rh1UfzQa',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 22:03:02','2015-04-23 19:03:02'),
	(151,'2017656960@523097429.com','CodeceptionTester','','$2a$08$PfZe9p6kzF4DMMhHEIJ1yOhUBlevfvprQp7UMUlgHos6qYQrKvbvS',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 22:17:23','2015-04-23 19:17:23'),
	(152,'1112214541@1046625610.com','CodeceptionTester','','$2a$08$EMPl855upeEJZ4IgD4Pe1u/r59WW68sDEKtFOcVAlaZtNbDylu2OS',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 22:17:23','2015-04-23 19:17:24'),
	(153,'173631370@987492423.com','CodeceptionTester','','$2a$08$AQmIIoxgl60RKHxRvzfgAOaBEph5CZG8qgwKHCm.WhSzKA7fDRvsC',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 22:20:47','2015-04-23 19:20:47'),
	(154,'1561639272@1237689349.com','CodeceptionTester','','$2a$08$gfxNzyXWWbIeeOC/EWzAN.Cv2eobtF78HeuameBQ5CVFZYZd0dn6e',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 22:20:47','2015-04-23 19:20:48'),
	(155,'1781509215@1696122191.com','CodeceptionTester','','$2a$08$w9.16KkYUXkYUg2e22SLfOS/ddUbVkvMIR7YAWQ4MUMWjH3YmBzwe',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 22:21:35','2015-04-23 19:21:35'),
	(156,'1335043945@387933456.com','CodeceptionTester','','$2a$08$0B8rJCRfl/7ZPOLHEsnGZupBwT3.dcVgsgyRGd.CqUS.RzGtxXQDK',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 22:21:35','2015-04-23 22:21:35'),
	(157,'632440917@1265562040.com','CodeceptionTester','','$2a$08$/L7wwTC18oh2TCKI.fH7au/EQtN7J/yovsDvvYorVwsdygXLkjRDq',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 22:22:58','2015-04-23 19:22:58'),
	(158,'1806234@2064311949.com','CodeceptionTester','','$2a$08$i98aGwfAydlGynbaqQfPv.ZGQYfIHGbR5pyCqEQ0wOwSvVA/0ELma',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 22:22:58','2015-04-23 19:22:58'),
	(159,'206183203@1155767187.com','CodeceptionTester','','$2a$08$zDH1z.8e756ypJtS1nxdM.90.Ef0XXWolRATNLKV9r7wuwlTvDWc6',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 22:29:30','2015-04-23 19:29:30'),
	(160,'2001072591@1048011343.com','CodeceptionTester','','$2a$08$qBxd5LZawZzcMaPB37w/MuGlb3GD5LBOMO.X22QutwvqOv8tM7Ktu',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 22:29:30','2015-04-23 19:29:30'),
	(161,'547224719@2018040374.com','CodeceptionTester','','$2a$08$gusHBGtVH/uYGlzE/P3RNe9FXHSltOcSh5S7IR3qkElsf1/e6Zj4e',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 22:34:37','2015-04-23 19:34:37'),
	(162,'1104640551@967417467.com','CodeceptionTester','','$2a$08$LdODRcnBCpiWZDOhkgPrZOGlCGc/ewyJN9H6Vp3R9bySmW/UyXoE6',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 22:34:37','2015-04-23 19:34:37'),
	(163,'1515932916@315760728.com','CodeceptionTester','','$2a$08$DpPdZJPgFq0z/gBeHYCrtezIwYlaCMTE2AkrcquZW.9D62iyhMfQa',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 22:36:00','2015-04-23 19:36:00'),
	(164,'1976762743@428381267.com','CodeceptionTester','','$2a$08$JuTW/p3eI..aXbPIsXX5EOYAZXLCnVqCVCtOEIjdV587wtIk/D5f6',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-23 22:36:00','2015-04-23 19:36:00'),
	(165,'1444009533@1327692093.com','CodeceptionTester','','$2a$08$93b7ghjcNCXzNqSn9km54unH0y/N98KxH9DS3WpOWYQkm4UrM1BEi',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 13:31:01','2015-04-24 10:31:02'),
	(166,'2038890994@1121294975.com','CodeceptionTester','','$2a$08$1OI9B80wDssxBUaEMOJTqOqj3f98sYhdz8ysNgjz4eTVTOUTYKz3e',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 13:31:02','2015-04-24 10:31:02'),
	(167,'1491553702@674141583.com','CodeceptionTester','','$2a$08$9EkM3CS7HYJMd/q/T16hZ.Cfsycd9EY9cJx.UzDVtHx/h1EKH/G1K',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 13:31:17','2015-04-24 10:31:18'),
	(168,'86460032@179985735.com','CodeceptionTester','','$2a$08$fs/6Wh0BGgaRj389gXd2QO/hCROFb53HN2RGs9.7Af0EaWJgKl4p6',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 13:31:18','2015-04-24 10:31:18'),
	(169,'642228023@554220848.com','CodeceptionTester','','$2a$08$xCyTBUm5QUsQvI0u84cf9Oc.ipA7hzBGqyEYfjcG3MBSzBIQF4HjW',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 13:52:31','2015-04-24 10:52:31'),
	(170,'299455713@1703673347.com','CodeceptionTester','','$2a$08$Zsr3i3J4wQ8eGW3f2Audv..R6A9DVvmRNP92HXbjYbKinGYPKYzOu',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 13:52:32','2015-04-24 10:52:32'),
	(171,'1656768876@1255720523.com','CodeceptionTester','','$2a$08$hvx9Nc1KEN51ixM.S70pn.dgvRXpOHwWCSkP.bnEtXq8BpnGqjz4y',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 13:57:05','2015-04-24 10:57:05'),
	(172,'423513305@1264737414.com','CodeceptionTester','','$2a$08$WkzbgeOJuULVsfQfU/FGR.6AsogS3djiTg94YgYo26j2ni6K22peS',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 13:57:05','2015-04-24 10:57:05'),
	(173,'1410266160@1281049244.com','CodeceptionTester','','$2a$08$peTsldUeoR74mIyX24.ka.WC09SRsG/1SEFgOr19/WLTUP3B4QV6S',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 15:11:45','2015-04-24 12:11:45'),
	(174,'813015077@1247894620.com','CodeceptionTester','','$2a$08$bPxqpMVLpAiLdbTzPeRk6e3jFa4kpxyD62fFPWXXJuwLPNKYSktzK',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 15:11:46','2015-04-24 12:11:46'),
	(175,'342216588@842716623.com','CodeceptionTester','','$2a$08$E4LW0UZNGAlcKJhHgSTF2.ZpP3uIMmqpW.NcpuWu8Fpd2F5zpQTPK',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 15:19:32','2015-04-24 12:19:32'),
	(176,'2029363441@1104931001.com','CodeceptionTester','','$2a$08$Rbiwmw3VcyLcXxJDPi9pm.Awb9U201k.cUwGb8rm8EDHekJbEjleG',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 15:19:32','2015-04-24 12:19:32'),
	(177,'staneisov2@wewgmail.com','stanisov@gmail.com','','$2a$08$h6rtRU5XcZmyd9.m2iqeLuwLOEwvDdviyT6yk5f.Iu0qykXXk2Joy',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:19:56','2015-04-24 15:19:56'),
	(178,'stane2isov2@wewgmail.com','stanisov@gmail.com','','$2a$08$N/m6fsWZbi/IN50/QzgSdO2tj5xg76D4bFvWzR0hJO34IW8VB5lv6',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:20:54','2015-04-24 15:20:54'),
	(179,'stwane2isov2@wewgmail.com','stanisov@gmail.com','','$2a$08$oWjJXTHJ43614P6gbky3w.Z9Exux.5t2o7sI1o1gEC10oAkAD9AZK',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:21:59','2015-04-24 15:21:59'),
	(180,'stwane2isov2@w4ewgmail.com','stanisov@gmail.com','','$2a$08$tYlXI1Ih4GEkG8mZf.WyieT9360bm7HlxqCN/4XY/puc1aHkQ1VSa',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:22:05','2015-04-24 15:22:05'),
	(181,'stwaner2isov2@w4ewgmail.com','stanisov@gmail.com','','$2a$08$o6mgwppd1n66KEKbxm7JdupRLFen7j8IjLh.8WsqEmd4S0.rB7Wqy',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:24:33','2015-04-24 15:24:33'),
	(182,'stewaner2isov2@w4ewgmail.com','stanisov@gmail.com','','$2a$08$8wqc1fW/OUWpXiEpn/ItE.Ja4m6YeL6LMp82GEVuwun4O/GXAZFFS',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:25:22','2015-04-24 15:25:22'),
	(183,'stewaner2isov2@we.com','stanisov@gmail.com','','$2a$08$tMFybOFhr4lUDwdNvzhdLewIPNTlHhSe.NuSRcGEvjon2wH9Wbdgi',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:26:10','2015-04-24 15:26:10'),
	(184,'stewaner2isov2@wey.com','stanisov@gmail.com','','$2a$08$dteUVWtNWnlNOapWK0VBF.7lRNA/2AGdrSjfngh5J0mkR/uiFzGXK',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:29:30','2015-04-24 15:29:30'),
	(185,'stewwaner2isov2@wey.com','stanisov@gmail.com','','$2a$08$NMvw1kSnzM27KDw6NdWoEuvXcIBQDaDEjS/sh0/Ku7dcNXjCVmPFm',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:29:42','2015-04-24 15:29:42'),
	(186,'sdtewwaner2isov2@wey.com','stanisov@gmail.com','','$2a$08$3D7OmFIn6cfV5Iqey3GjSuQyUwcrdPqHdPoc05HiQ4n0pNAspKGRe',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:30:41','2015-04-24 15:30:41'),
	(187,'sdteewwaner2isov2@wey.com','stanisov@gmail.com','','$2a$08$Aknb6qmBUfxJCPONGh3rv.CDXz2jLJ4/aUvs6R6RPCcTPoKMrs/x6',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:30:48','2015-04-24 15:30:48'),
	(188,'sdser2isov2@wey.com','stanisov@gmail.com','','$2a$08$nGt0w.VdwnwCWdTbv9FH2.AE6aKJkxY9Z2Kjgyt1pb1yfCv8h7YgW',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:32:31','2015-04-24 15:32:31'),
	(189,'sdser2isov2@weey.com','stanisov@gmail.com','','$2a$08$Md7SjopigLXwqubV9RZ6O.G2UqxiKOZqMyCBn/VIlC4MlMZ7OcL0W',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:35:25','2015-04-24 15:35:25'),
	(190,'sdseer2isov2@weey.com','stanisov@gmail.com','','$2a$08$ET7DxExIAbSgjt8plS685.Y6G1QDCS0rVvyxbi8mCj8BqjMwws2V6',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:36:56','2015-04-24 15:36:56'),
	(191,'sdseeer2isov2@weey.com','stanisov@gmail.com','','$2a$08$Xl/J39YM3cm4WVlEGMxF2eWEd2IpkwdnQ6zyAJeqYDQmXM/xHsS0C',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:39:45','2015-04-24 15:39:45'),
	(192,'sddseeer2isov2@weey.com','stanisov@gmail.com','','$2a$08$rXvQoGokhtQB8CyzXeBkAuMep32532WS0lUfKtonDJwyHtrI7hnhW',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:40:43','2015-04-24 15:40:43'),
	(193,'sfveer2isov2@weey.com','stanisov@gmail.com','','$2a$08$hLVnmtdaMBRWssWrKn9VDucjUexQYHE0/x9g6BHwPA1zqt0CgR38S',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:42:07','2015-04-24 15:42:07'),
	(194,'sfw2isov2@weey.com','stanisov@gmail.com','','$2a$08$aXkGbEZSWYFg9XlhrBtUSuyKTUS6rl.rHmsUgstDmFWVikAdo5BF2',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:42:13','2015-04-24 15:42:13'),
	(195,'sfw2isover2@weey.com','stanisov@gmail.com','','$2a$08$kUcC3pKVeh/LbhQ5tYV0/.nrSHIpYCv0TMGMQgpCpS6fNUOk/S.oy',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:43:29','2015-04-24 15:43:29'),
	(196,'sfew2isover2@weey.com','stanisov@gmail.com','','$2a$08$jrj11xs3EPsfPC3iBnopOO04VdCCVHeXJljTB5cBRE.WF7q6BdCEW',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:44:34','2015-04-24 15:44:34'),
	(197,'sfeerw2isover2@weey.com','stanisov@gmail.com','','$2a$08$Hu6FLYnoIOTB9sBJvXCtTePVfSQVtbwxXEER1C1jWRAPWIPRCrYa2',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:46:13','2015-04-24 15:46:13'),
	(198,'sfeerw2isovser2@weey.com','stanisov@gmail.com','','$2a$08$BicX5jZf8DyAZP3gOSj6.e/.54R5klMjpPiR9XjssSEPEhpPkFEem',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:46:24','2015-04-24 15:46:24'),
	(199,'sfeeerw2isovser2@weey.com','stanisov@gmail.com','','$2a$08$xOEsfkC8lEUuTOulMsVyO./3AbYR/xglcDTbTm13w5SnAm3wmnO5S',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:47:06','2015-04-24 15:47:06'),
	(200,'sfeeerw2risovser2@weey.com','stanisov@gmail.com','','$2a$08$wrRnHBFDXxm7.vDy2smZU.xaUwwW055gC3FDuXFP0mjpkcf6ukaG.',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 15:48:05','2015-04-24 15:48:05'),
	(201,'918408621@995191298.com','CodeceptionTester','','$2a$08$EkN55u6GFzEaS37yeE0GeOkhSGjPXblfNs0vYhOK3wMaU51KTeLi6',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 15:48:59','2015-04-24 12:48:59'),
	(202,'402409684@407162873.com','CodeceptionTester','','$2a$08$MMh.DHRyOcw8.qin19myGu1y.hYVRCGhH7miSXt6aFu6HQSltAZiq',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 15:49:00','2015-04-24 12:49:00'),
	(203,'1824977321@636785116.com','CodeceptionTester','','$2a$08$AtT3oD2HiYaa7p0vaRvixOfb6ndSbBaczB04SgmOR/rwjl2b4JiZ.',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 15:50:09','2015-04-24 12:50:09'),
	(204,'715167735@339900206.com','CodeceptionTester','','$2a$08$4lqbxP6rJTxwsi/Y0erNvuJgLxjufkNkJMsdTfMWD6SjgVriaMtA6',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 15:50:10','2015-04-24 12:50:10'),
	(205,'staniwefsxsov2@wewgmail.com','stanisov@gmail.com','','$2a$08$Cii6KBzR1FxCph/0FqlIue.kFjo1bJJbh1yYcSftjsYLFIdPuA4Te',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 16:05:37','2015-04-24 16:05:37'),
	(206,'sertanisov2@wewgmail.com','stanisov@gmail.com','','$2a$08$/Z9wLLNd6kVzs/s4rUJzJOkAKWYOBGpKFuKe71fCUzzRmVeqda.kW',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 16:27:13','2015-04-24 16:27:13'),
	(207,'sertanisoewdv2@wewgmail.com','stanisov@gmail.com','','$2a$08$n3TAXv8N4c7mY4yptVCRBeEMwaFUMdgSW9d4w/7jdWe4JYuBd77sG',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 16:30:05','2015-04-24 16:30:05'),
	(208,'sertanisoewdv2@wewgm5ail.com','stanisov@gmail.com','','$2a$08$7hP9LNaHmR5FwZBXR4QZh.D.1Uvo57X7Ivrpa8dx7hNFhreWMY85u',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 16:32:06','2015-04-24 16:32:06'),
	(209,'sertanisoewdv2@wewgm5ail.come','stanisov@gmail.com','','$2a$08$D9kFDZlAm8S0hs01Br7nSOMZ3TUL.eOyahQuVFEdLbKYqEJosVZIm',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 16:32:45','2015-04-24 16:32:45'),
	(210,'seertanisoewdv2@wewgm5ail.come','stanisov@gmail.com','','$2a$08$60NmbElF/nyhdSyLy7zo7eL2lYH7ILYxdIx/2YjuOdaW32r1ttvKi',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 16:34:04','2015-04-24 16:34:04'),
	(211,'we@wewgm5ail.come','stanisov@gmail.com','','$2a$08$rIdM2NnTlqW/I2XOpJdHIesYS9XvB.Sy4F3tTRAj/q0.nOJ9D3JV2',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 16:34:33','2015-04-24 16:34:33'),
	(212,'we3@wewgm5ail.come','stanisov@gmail.com','','$2a$08$9TJj2RczMQTSDdgC24zG3uwBdPPj0RL0.uBgcXIYU76yxRb8VIAyS',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 16:35:02','2015-04-24 16:35:02'),
	(213,'wwe3@wewgm5ail.come','stanisov@gmail.com','','$2a$08$LP9mlaAUgV06ixM33A/ec.fz4/upihu/RjruGsB2y91vcgF28OnFK',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 16:35:22','2015-04-24 16:35:22'),
	(214,'ewwe3@wewgm5ail.come','stanisov@gmail.com','','$2a$08$rzMM7tMVeaRFGgBHJXTvRukh8uEWnNHQDjD23y0IhWRvuCmbl88CK',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 16:35:43','2015-04-24 16:35:43'),
	(215,'ewwee3@wewgm5ail.come','stanisov@gmail.com','','$2a$08$Bfbej2nhs3leMKz5vziWTeead78S0p9eGGm3lislnaTauunLtVXja',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 16:36:11','2015-04-24 16:36:11'),
	(216,'ewweer3@wewgm5ail.come','stanisov@gmail.com','','$2a$08$BrV0CgnwffEy1hTPw6Sy5eIuQq08zy7dPyxW1ebP7S7T1gBrH7RIO',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 16:36:38','2015-04-24 16:36:38'),
	(217,'ewweer3e@wewgm5ail.come','stanisov@gmail.com','','$2a$08$.SQ5YmF2S1dpnh8BzIWbBOB8Rsa0IgrRte5JnNekqATduvdT7T5au',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 16:37:01','2015-04-24 16:37:01'),
	(218,'ewweeer3e@wewgm5ail.come','stanisov@gmail.com','','$2a$08$GxjJAIrKDtJgDPODC/pd7.oe/ZUYUPrr8EhKzVs4HVfaqqvPu9hi6',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 16:37:41','2015-04-24 16:37:41'),
	(219,'ewweeeer3e@wewgm5ail.come','stanisov@gmail.com','','$2a$08$VZq0Ei3hAebvT9CM.CtaR.aM.ff0YJxzDQ5DC9M6VHiCfZXc6lwwW',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 16:38:16','2015-04-24 16:38:16'),
	(220,'531886265@186840330.com','CodeceptionTester','','$2a$08$XT0A4khJIzTa/P.pfW97RuI.gBM6nS0pD8Ercyk4xmb0ZpNRGDRwq',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 17:09:04','2015-04-24 14:09:04'),
	(221,'1933711756@995788890.com','CodeceptionTester','','$2a$08$KPgHfpdNzi98yVO7rni4G.kK3kncnRgeOYqwYxTJWrMTa0yWrhMqq',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 17:09:04','2015-04-24 14:09:04'),
	(222,'1084462086@1218792536.com','CodeceptionTester','','$2a$08$WQtJkd6gPAVDbzqo8dYvxecw2gYv.uQZ9ywBImBpFzVQDqPWBGm6K',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 17:09:46','2015-04-24 14:09:46'),
	(223,'1273290608@2105758376.com','CodeceptionTester','','$2a$08$FaP0UwAwNxPb.XJGpnxBzOMPEAjA9IHd/UOyeYiBYW.lMRVB/5CMW',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 17:09:46','2015-04-24 14:09:46'),
	(224,'70745682@825206076.com','CodeceptionTester','','$2a$08$yi.alUWUQ3YKAmnrc0Z11O.t0Ne/VkmKbL9md56GaNc8JTes9N032',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 17:18:55','2015-04-24 14:18:55'),
	(225,'1834428141@100625566.com','CodeceptionTester','','$2a$08$MTIDIwV4ei9zqlj9rc77DuqHJXQpcbdnxaGbI2hgIdTJMt7F6TOmW',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 17:18:55','2015-04-24 14:18:56'),
	(226,'1468911264@714004352.com','CodeceptionTester','','$2a$08$Qt5eDiEN1MxjzwDTeHNPAO0xmtcZ7yjMNecE8sWkIXNo5od79KiFG',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 17:22:19','2015-04-24 14:22:19'),
	(227,'399267201@915186066.com','CodeceptionTester','','$2a$08$ge8NNGj2uBgPm7/nps9VAeOCP2AZIZ2kYgUkfoYXyzr8R6RJY6XP2',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 17:22:19','2015-04-24 14:22:19'),
	(228,'675733839@440949366.com','CodeceptionTester','','$2a$08$wYZdCjDhs3lh88p/NQ446ut0T/PngGW3c3WJUGmBrKThFOk/AkyO2',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 18:03:04','2015-04-24 15:03:04'),
	(229,'1153187031@234706758.com','CodeceptionTester','','$2a$08$ZTkui7lClEYfdUHEphRd9uwCB3Qs3mGFQWuT24rHeIXGgC9Hg1Xgu',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 18:03:04','2015-04-24 15:03:04'),
	(230,'1842217580@1352984571.com','CodeceptionTester','','$2a$08$sS/ii3mLdFpjCk6WtffXxutxIL4cIZsb5pXgufF7rrR1qv.wRYuYC',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 18:03:28','2015-04-24 15:03:28'),
	(231,'1065739515@984059884.com','CodeceptionTester','','$2a$08$KHFbvBSRCko6uCQ.QaQOreUef7O7ROwojtrn6Jcz1QmMAtRqKViVK',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 18:03:28','2015-04-24 15:03:28'),
	(232,'598726496@1768216037.com','CodeceptionTester','','$2a$08$dzm7cz07l9vuSEVzL74acuLeOnIH8VTKpS5qSv9tclyHZybMKF7tG',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 18:04:11','2015-04-24 15:04:11'),
	(233,'277261388@1963154185.com','CodeceptionTester','','$2a$08$rIyhcM0QAtQegBdgiZhfK.Qjj9cCFU6QIHYLn2DaP.iJGwMJ.WnAm',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 18:04:11','2015-04-24 15:04:11'),
	(234,'940974037@77409814.com','CodeceptionTester','','$2a$08$TBkbEkpAu0k6cA/OF1MJO.m6RCBRND0k1YbxEkRGysf9oHJUWStfS',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 18:07:49','2015-04-24 15:07:49'),
	(235,'637342101@1246785736.com','CodeceptionTester','','$2a$08$2xlVficPmqsoI1BWK.DMo.LY4v5pPErvLvRUeU4vNP35hKTxvWP5G',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 18:07:49','2015-04-24 15:07:49'),
	(236,'1873822462@1023908587.com','CodeceptionTester','','$2a$08$AYwqnmeO8qxVNmAN7XPjYOjioXn28NdIrRSFuYN5lD6PTS0dD7AFK',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 18:45:42','2015-04-24 15:45:42'),
	(237,'1717239607@385317914.com','CodeceptionTester','','$2a$08$8s/3crKwtpWRrietGnOjCeDaGi980eJVXEsiR8ofIylKu0dUhfRJq',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 18:45:42','2015-04-24 15:45:42'),
	(238,'stanisov2wewf34@wewgmail.com','stanisov@gmail.com','','$2a$08$SA5dsqnlQp3wVAcfbFEq6Oj5YbDq3lssIGpUtl8Hrosd3J7Bg3c6i',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 20:18:10','2015-04-24 20:18:10'),
	(239,'staniwesov2wewf34@wewgmail.com','stanisov@gmail.com','','$2a$08$Oo5NgVcqfHGM/dWcI2lrmuEF/XxWGJong8EOR4UFG7EB6.bqevcJa',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 20:18:23','2015-04-24 20:18:23'),
	(240,'ewe@wewgmail.com','stanisov@gmail.com','','$2a$08$Qg2XBUSVR6zfjDIo22IMV.lMYEdXRT031lFA0m1QIDGL7lAVZYNG2',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 20:26:04','2015-04-24 20:26:04'),
	(241,'ewe43we@wewgmail.com','stanisov@gmail.com','','$2a$08$e1MF9AE.lXYMA1yY6ea94Ortf4p1vEaLaX.j4RVKM.1aAMPuoG072',0,'0',0,2130706433,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36','2015-04-24 20:26:44','2015-04-24 20:26:44'),
	(242,'1510215813@1100033094.com','CodeceptionTester','','$2a$08$k5T1Vni8SOy0JvM2fHsWfO25vHnUGmRNdiwhJRnW5NX4n5R4wGCLq',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 20:34:07','2015-04-24 17:34:08'),
	(243,'1779986010@1575693011.com','CodeceptionTester','','$2a$08$RwbkSmTf22daQ6T/qkkaTOTZVpD6pE.I/GxhrG7Ew9VmD6OLnHmHe',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-24 20:34:08','2015-04-24 17:34:08');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



--
-- Dumping routines (FUNCTION) for database 'phalcon.local'
--
DELIMITER ;;

# Dump of FUNCTION REBUILD_TREE
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `REBUILD_TREE` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `REBUILD_TREE`() RETURNS int(11)
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
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
DELIMITER ;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
