# ************************************************************
# Sequel Pro SQL dump
# Версия 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Адрес: 127.0.0.1 (MySQL 5.6.22)
# Схема: phalcon.local
# Время создания: 2015-04-21 15:05:26 +0000
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

INSERT INTO `categories` (`id`, `title`, `description`, `alias`, `parent_id`, `lft`, `rgt`, `sort`, `engine_id`, `date_create`, `date_update`)
VALUES
	(1,'Авто','','auto',NULL,NULL,NULL,1,1,'2015-04-18 06:08:31','2015-04-21 12:35:58'),
	(2,'Телефоны','','phones',NULL,NULL,NULL,2,1,'2015-04-18 06:09:19','2015-04-21 12:35:59'),
	(3,'Ноутбуки','','notebooks',NULL,NULL,NULL,3,1,'2015-04-18 06:09:11','2015-04-21 12:35:59'),
	(4,'Техника','','equipment',NULL,NULL,NULL,4,1,'2015-04-21 12:29:52','2015-04-21 12:35:35'),
	(5,'Спорт','','sport',NULL,NULL,NULL,5,1,'2015-04-21 12:30:26','2015-04-21 12:35:36'),
	(6,'Мода','','fashion',NULL,NULL,NULL,6,1,'2015-04-21 12:30:58','2015-04-21 12:35:37'),
	(7,'Детский','','baby',NULL,NULL,NULL,7,1,'2015-04-21 12:31:19','2015-04-21 12:35:37'),
	(8,'Дом','','house',NULL,NULL,NULL,8,1,'2015-04-21 12:31:28','2015-04-21 12:35:38'),
	(9,'Коллекции','','collections',NULL,NULL,NULL,9,1,'2015-04-21 12:31:44','2015-04-21 12:35:38'),
	(10,'Спец проекты','','special',NULL,NULL,NULL,10,1,'2015-04-21 12:32:00','2015-04-21 12:35:40');

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
	(23,'TO_MANY_REQUESTS','Request limit is exhausted ');

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
	(119,'Rest',2,'Too Many Requests\n              IP: 127.0.0.1\n              Refer: \n              Method: GET\n              URI: http://phalcon.local/api/v1/engines/1/categories?columns=id,host',1429620820);

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
	(11,'$2a$08$XcFbIHeCC1qMqefmCbZsa.10ao.wriPQdxdn0hqqzJ/nxl.VrJR3m','2015-04-28 12:29:24'),
	(14,'e95b8b637146bc43325c9df2fd1a0ab4','2015-03-16 05:45:43'),
	(15,'$2a$08$gW4wX1YrBqYNsba74nutb.dcSSpLIaktNcmceaSHR/SffVbgPRUZe','2015-04-28 12:29:24'),
	(16,'643bd3a1ce3090d14f9a59d0c45ad354','2015-03-16 05:51:12'),
	(17,'1c94392e83ea494e4060b6a3ac651e6c','2015-03-16 05:54:21'),
	(18,'685c2403f2e977a5e02f8ed36c0e22d0','2015-03-16 05:55:23'),
	(19,'283108b3ee610cef11e51aa12cb697fc','2015-03-16 05:57:00'),
	(20,'27906fadb0f3bdade5a0cb8d3846611c','2015-03-16 05:59:14'),
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
	(123,'$2a$08$7ZnO9rG0Rnnj7iUXj0nNiuZdVjV1Hdhmm12phZYUz.D4BO9y7kVy.','2015-04-26 02:55:03'),
	(124,'$2a$08$WCD7bvIu5FWIppK98f5.DOgbilt0ssnbFidBGZ/LMmPbjq327s2Iq','2015-04-26 02:55:37'),
	(125,'$2a$08$YJNb2dTXwk0NzOyzAGaT2.oZyKkVdUjgyvJb59v9QDjPX8kq.v/B2','2015-04-26 02:55:47'),
	(126,'$2a$08$eMBTN45f8wAVVvHWGyXyB.jA4Kr3MdRHY5M8yHHoLX3vz8xczLUi6','2015-04-26 02:55:47'),
	(133,'$2a$08$uclXWMLAzEFXEKONDgzrL.s4zu2GLk7bK3cn5YlAh9NksJuzLNk8a','2015-04-27 10:25:45'),
	(144,'$2a$08$iczce69iCM.gNIPgH4m5C.20iwSlypMB8duMvWfz3z7Y6jcQu95tS','2015-04-28 12:17:44');

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
	(11,'user@gmail.com','stanisovw@gmail.com','','$2a$08$n9WNEktlDCbVqPZ8faZzVOvPuoi4XZr2beSusccYt6GKpatmPsTT2',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-02-21 04:31:14','2015-04-21 12:29:24'),
	(12,'userundefined@gmail.com','TestRestoreUser','','$2a$08$f/P0oTrRU9Zyzz2cCStAj.m5PbiZzCYGID/0kESInWhOAB98goGVK',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36','2015-02-22 13:37:59','2015-04-02 12:31:13'),
	(13,'380954916517','stanisov3@gmail.com','','$2a$08$I6hHlg0Vu2DVofpgsK.15enr.6K2X7MrIBATNDtvBwoef/AsFmgL2',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36','2015-02-22 14:36:52','2015-04-02 17:10:38'),
	(14,'stanisov4@gmail.com','dcdcdcdcdc','','wwwwww',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.76 Safari/537.36','2015-03-09 05:45:43','2015-03-09 05:45:43'),
	(15,'admin@admin.ua','AdminTester','','$2a$08$GpGWBJuVavKO2/NOYaM45eSOyi1MiygFUEMDecvppWtCR5xsWN8RC',1,'0',0,2130706433,'Symfony2 BrowserKit','2015-03-09 05:48:23','2015-04-21 12:29:24'),
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
	(44,'logoutuser@logoutuser.com','LogoutUser','','$2a$08$3uCl4QlMluTR/4TX8qwmeeaVI.PSHVJsTw8OPwthwVamoCJ8j7dJm',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-03-31 17:30:47','2015-04-21 12:29:19'),
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
	(146,'400157745@598426829.com','CodeceptionTester','','$2a$08$sng.pKcLKmAU8iIJitmKbejDwyWVlJ/aD.B2OFwgskbx2YrCdUIp.',0,'0',0,2130706433,'Symfony2 BrowserKit','2015-04-21 15:29:19','2015-04-21 12:29:19');

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
