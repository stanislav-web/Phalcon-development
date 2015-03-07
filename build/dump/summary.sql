# ************************************************************
# Sequel Pro SQL dump
# Версия 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Адрес: 127.0.0.1 (MySQL 5.6.22)
# Схема: phalcon.local
# Время создания: 2015-03-07 05:53:50 +0000
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
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Create date',
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Update date',
  `visibility` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_alias` (`alias`),
  KEY `idx_rgt` (`rgt`),
  KEY `idx_lft` (`lft`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `title`, `description`, `alias`, `parent_id`, `lft`, `rgt`, `sort`, `date_create`, `date_update`, `visibility`)
VALUES
	(103,'2323','<p>2323232323232322322323232323322323232323323323</p>','233232323',NULL,1,2,23,'2015-03-06 23:46:29','2015-03-06 23:46:29',1);

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
	(1,'Phalcon Shop','<p>This is the simple Phalcon Shop</p>','phalcon.local','PHL','logo-mysql-110x57.png',4,1,'2015-01-03 02:27:22','2015-02-23 02:58:12'),
	(10,'eBay','<p>ebay Description2</p>','ebay.com','EBY','eBay-Logo.gif',1,2,'2015-03-06 12:24:17','2015-03-06 23:23:31'),
	(11,'Add new engine','<p>sdsdsdsdsds</p>','weee','wee','phpnw.png',5,2,'2015-03-06 21:24:05','2015-03-06 23:24:05');

/*!40000 ALTER TABLE `engines` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы engines_categories_rel
# ------------------------------------------------------------

DROP TABLE IF EXISTS `engines_categories_rel`;

CREATE TABLE `engines_categories_rel` (
  `engine_id` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'to engines.id rel',
  `category_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'to categories.id rel',
  PRIMARY KEY (`engine_id`,`category_id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_engine_id` (`engine_id`),
  CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `engines_categories_rel` WRITE;
/*!40000 ALTER TABLE `engines_categories_rel` DISABLE KEYS */;

INSERT INTO `engines_categories_rel` (`engine_id`, `category_id`)
VALUES
	(1,103);

/*!40000 ALTER TABLE `engines_categories_rel` ENABLE KEYS */;
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
	(1,'Backend',1,'There is no active transaction File: /Users/stanislavmenshykh/phalcon.local/Application/Models/Categories.php Line:514',1425398607),
	(2,'Backend',6,'Delete category #96 by 127.0.0.1',1425461727),
	(3,'Backend',6,'Delete category #94 by 127.0.0.1',1425461730),
	(4,'Backend',6,'Delete category #95 by 127.0.0.1',1425461733),
	(5,'Backend',1,'SQLSTATE[22001]: String data, right truncated: 1406 Data too long for column \'description\' at row 1 File: /Users/stanislavmenshykh/phalcon.local/Application/Models/Categories.php Line:436',1425462079),
	(6,'Backend',1,'SQLSTATE[22001]: String data, right truncated: 1406 Data too long for column \'description\' at row 1 File: /Users/stanislavmenshykh/phalcon.local/Application/Models/Categories.php Line:436',1425462082),
	(7,'Backend',1,'SQLSTATE[22001]: String data, right truncated: 1406 Data too long for column \'description\' at row 1 File: /Users/stanislavmenshykh/phalcon.local/Application/Models/Categories.php Line:401',1425462283),
	(8,'Backend',1,'Transaction aborted File: /Users/stanislavmenshykh/phalcon.local/Application/Services/CategoriesService.php Line:115',1425494033),
	(9,'Backend',1,'Transaction aborted File: /Users/stanislavmenshykh/phalcon.local/Application/Services/CategoriesService.php Line:116',1425502446),
	(10,'Frontend',4,'Пользователь не найден IP: 127.0.0.1',1425502506),
	(11,'Frontend',4,'Не верный пароль IP: 127.0.0.1',1425502551),
	(12,'Frontend',4,'Не верный пароль IP: 127.0.0.1',1425502571),
	(13,'Frontend',4,'Не верный пароль IP: 127.0.0.1',1425502576),
	(14,'Frontend',4,'Не верный пароль IP: 127.0.0.1',1425502576),
	(15,'Frontend',4,'Не верный пароль IP: 127.0.0.1',1425502577),
	(16,'Frontend',4,'Не верный пароль IP: 127.0.0.1',1425502589),
	(17,'Backend',1,'Transaction aborted File: /Users/stanislavmenshykh/phalcon.local/Application/Services/CategoriesService.php Line:117',1425547689),
	(18,'Backend',1,'There is no active transaction File: /Users/stanislavmenshykh/phalcon.local/Application/Services/CategoriesService.php Line:164',1425560958),
	(19,'Backend',6,'Delete category #99 by 127.0.0.1',1425561513),
	(20,'Backend',1,'SQLSTATE[42S22]: Column not found: 1054 Unknown column \'category_id\' in \'where clause\' File: /Users/stanislavmenshykh/phalcon.local/Application/Models/Categories.php Line:462',1425567565),
	(21,'Backend',1,'SQLSTATE[22001]: String data, right truncated: 1406 Data too long for column \'description\' at row 1 File: /Users/stanislavmenshykh/phalcon.local/Application/Services/EngineService.php Line:128',1425644534),
	(22,'Backend',1,'SQLSTATE[22001]: String data, right truncated: 1406 Data too long for column \'description\' at row 1 File: /Users/stanislavmenshykh/phalcon.local/Application/Services/EngineService.php Line:128',1425644537),
	(23,'Backend',1,'SQLSTATE[22001]: String data, right truncated: 1406 Data too long for column \'description\' at row 1 File: /Users/stanislavmenshykh/phalcon.local/Application/Services/EngineService.php Line:128',1425644537),
	(24,'Backend',1,'SQLSTATE[22001]: String data, right truncated: 1406 Data too long for column \'description\' at row 1 File: /Users/stanislavmenshykh/phalcon.local/Application/Services/EngineService.php Line:128',1425644538),
	(25,'Backend',1,'SQLSTATE[22001]: String data, right truncated: 1406 Data too long for column \'description\' at row 1 File: /Users/stanislavmenshykh/phalcon.local/Application/Services/EngineService.php Line:128',1425644538),
	(26,'Backend',1,'SQLSTATE[22001]: String data, right truncated: 1406 Data too long for column \'description\' at row 1 File: /Users/stanislavmenshykh/phalcon.local/Application/Services/EngineService.php Line:128',1425644538),
	(27,'Backend',1,'Column \'sss\' doesn\'t belong to any of the selected models (1), when preparing: SELECT id, sss FROM [Application\\Models\\Categories] File: /Users/stanislavmenshykh/phalcon.local/Application/Services/CategoriesService.php Line:284',1425678367),
	(28,'Backend',1,'Service \'EnginesService\' was not found in the dependency injection container File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/Controllers/CategoriesController.php Line:162',1425678666),
	(29,'Backend',1,'Service \'EnginesService\' was not found in the dependency injection container File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/Controllers/CategoriesController.php Line:162',1425678862),
	(30,'Backend',1,'Service \'EnginesService\' was not found in the dependency injection container File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/Controllers/CategoriesController.php Line:162',1425678862),
	(31,'Backend',1,'Service \'EnginesService\' was not found in the dependency injection container File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/Controllers/CategoriesController.php Line:162',1425678863),
	(32,'Backend',1,'Service \'EnginesService\' was not found in the dependency injection container File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/Controllers/CategoriesController.php Line:162',1425678863),
	(33,'Backend',1,'Service \'EnginesService\' was not found in the dependency injection container File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/Controllers/CategoriesController.php Line:162',1425678863),
	(34,'Backend',1,'Service \'EnginesService\' was not found in the dependency injection container File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/Controllers/CategoriesController.php Line:162',1425678895),
	(35,'Backend',1,'Service \'EnginesService\' was not found in the dependency injection container File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/Controllers/CategoriesController.php Line:162',1425678896),
	(36,'Backend',1,'Service \'EnginesService\' was not found in the dependency injection container File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/Controllers/CategoriesController.php Line:162',1425678896),
	(37,'Backend',1,'Service \'EnginesService\' was not found in the dependency injection container File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/Controllers/CategoriesController.php Line:162',1425678896),
	(38,'Backend',1,'Service \'CurrencyService\' was not found in the dependency injection container File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/Controllers/CurrenciesController.php Line:39',1425680263),
	(39,'Backend',1,'Service \'CurrencyService\' was not found in the dependency injection container File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/Controllers/EnginesController.php Line:101',1425680883),
	(40,'Backend',1,'Service \'CurrencyService\' was not found in the dependency injection container File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/Controllers/EnginesController.php Line:101',1425680912),
	(41,'Backend',1,'Service \'CurrencyService\' was not found in the dependency injection container File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/Controllers/EnginesController.php Line:101',1425680913),
	(42,'Backend',1,'Service \'CurrencyService\' was not found in the dependency injection container File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/Controllers/EnginesController.php Line:101',1425680913),
	(43,'Backend',1,'Service \'CurrencyService\' was not found in the dependency injection container File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/Controllers/EnginesController.php Line:101',1425680913),
	(44,'Backend',1,'The method \"getDescription\" doesn\'t exist on model \"Application\\Models\\Currency\" File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/views/currencies/index.phtml Line:49',1425681029),
	(45,'Backend',1,'The method \"getDescription\" doesn\'t exist on model \"Application\\Models\\Currency\" File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/views/currencies/index.phtml Line:49',1425681036),
	(46,'Backend',1,'The method \"getDescription\" doesn\'t exist on model \"Application\\Models\\Currency\" File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/views/currencies/index.phtml Line:49',1425681305),
	(47,'Backend',1,'The method \"getDescription\" doesn\'t exist on model \"Application\\Models\\Currency\" File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/views/currencies/index.phtml Line:49',1425681307),
	(48,'Backend',1,'Element with ID=description is not a part of the form File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/views/currencies/add.phtml Line:36',1425682257),
	(49,'Backend',1,'Element with ID=description is not a part of the form File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/views/currencies/add.phtml Line:36',1425682322),
	(50,'Backend',1,'Element with ID=description is not a part of the form File: /Users/stanislavmenshykh/phalcon.local/Application/Modules/Backend/views/currencies/edit.phtml Line:36',1425682797);

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
	(1,'About','<p>This is about page content. I am edit storage text. EDITED2</p>','about','2015-01-22 00:30:05','2015-03-05 19:29:31'),
	(2,'Agreement','This is agreement page content','agreement','2015-01-22 00:32:41','2015-01-22 00:35:39'),
	(4,'Contacts','<p>This is contacs page content. EDITED</p>','contacts','2015-01-22 00:34:22','2015-02-16 03:31:18'),
	(5,'Help','<p>This is the help page</p>','help','2015-01-22 02:53:07','2015-01-22 02:54:47');

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
	(10,'83c214641b909be369ddde9854a8d4ed','2015-03-13 08:41:05'),
	(11,'f0318c6e5aff1fbed8ad7412e103bc0b','2015-02-14 04:48:17'),
	(12,'78df0928b91ec774abb2a651d8c1ffab','2015-03-01 13:37:59'),
	(13,'c26e866b05c4b60b48968a55154187da','2015-02-15 14:36:58');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Common users table';

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `login`, `name`, `surname`, `password`, `salt`, `role`, `state`, `rating`, `ip`, `ua`, `date_registration`, `date_lastvisit`)
VALUES
	(10,'stanisov@gmail.com','Stanislav','','$2a$08$FVBqaIVvJNT.vH.cG9SDFO.1MEEC6Bs8fKyBOvncO.d0ZOwZIR0BG','5700e9bc64cd54fe2d8993b09c3ff7a8',1,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36','2015-02-02 12:30:28','2015-02-22 23:11:36'),
	(11,'stanisovw@gmail.com','stanisovw@gmail.com','','$2a$08$gAQeAhVAYIPcaY9pTRYGMeStAuoPw29y5JnMjM9qSSlrofGz3ILO6','52c91b18128a854d7ba1d4b11290da83',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36','2015-02-21 04:31:14','2015-02-21 04:31:14'),
	(12,'stanisov2@gmail.com','stanisov2@gmail.com','','$2a$08$WLHJJKcAFndE7mtuqcEYeOaIIjcGikfK1zNjGAGcmDiWEU.ya9mSy','0f216e751ac2a739709108eebc8a40aa',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36','2015-02-22 13:37:59','2015-02-22 13:37:59'),
	(13,'stanisov3@gmail.com','stanisov3@gmail.com','','$2a$08$ffWFo.DHPzZC1El/tlDfb.e4v6eG1/UgtacL/adtjCAf0wXcRqbNK','45707bf7ff673c44cba7957ed9482b77',0,'0',0,2130706433,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36','2015-02-22 14:36:52','2015-02-22 14:36:52');

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
