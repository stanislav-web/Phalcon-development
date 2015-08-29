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
) ENGINE=ARCHIVE DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (1,'Rest',1,'Undefined property: stdClass::$full File: /var/www/backend.local/Application/Services/Advanced/ImageService.php Line:64',1439163016),(2,'Rest',5,'{\"exception\":\"TestLogger\",\"ip\":\"127.0.0.1\",\"refer\":\"\",\"method\":\"POST\",\"message\":\"Test insert to logger\"}',1439163016),(3,'Rest',2,'{\"exception\":\"Bad Request : 400\",\"ip\":\"127.0.0.1\",\"refer\":\"\",\"method\":\"GET\",\"uri\":\"http:\\/\\/backend.local\\/\\/api\\/v1\\/pages?columns=id,title,wrong\",\"message\":\"INVALID_COLUMNS=The columns: `wrong` does not provide by this filter&developer=http:\\/\\/backend.local\\/api\\/v1\\/errors\\/5\"}',1439163022),(4,'Rest',2,'{\"exception\":\"Forbidden : 403\",\"ip\":\"127.0.0.1\",\"refer\":\"http:\\/\\/backend.local\\/api\\/v1\\/sign?login=2101708869%401132632888.com&password=1073501028\",\"method\":\"GET\",\"uri\":\"http:\\/\\/backend.local\\/\\/api\\/v1\\/users\",\"message\":\"ACCESS_DENIED=Here you access denied&developer=http:\\/\\/backend.local\\/api\\/v1\\/errors\\/10\"}',1439163022),(5,'Rest',2,'{\"exception\":\"Request URI Too Long : 414\",\"ip\":\"127.0.0.1\",\"refer\":\"\",\"method\":\"GET\",\"uri\":\"http:\\/\\/backend.local\\/\\/api\\/v1\\/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx\",\"message\":\"LONG_REQUEST=Too many parameters in the query string&developer=http:\\/\\/backend.local\\/api\\/v1\\/errors\\/7\"}',1439163023),(6,'Rest',2,'{\"exception\":\"Not Acceptable : 406\",\"ip\":\"127.0.0.1\",\"refer\":\"\",\"method\":\"GET\",\"uri\":\"http:\\/\\/backend.local\\/\\/api\\/v1\\/users\",\"message\":\"CONTENT_IS_NOT_SUPPORT=This content type is not support&developer=http:\\/\\/backend.local\\/api\\/v1\\/errors\\/8\"}',1439163023),(7,'Rest',2,'{\"exception\":\"Not Found : 404\",\"ip\":\"127.0.0.1\",\"refer\":\"\",\"method\":\"GET\",\"uri\":\"http:\\/\\/backend.local\\/\\/api\\/v1\\/undefined\\/page\"}',1439163023),(8,'Rest',2,'{\"exception\":\"Bad Request : 400\",\"ip\":\"127.0.0.1\",\"refer\":\"\",\"method\":\"GET\",\"uri\":\"http:\\/\\/backend.local\\/\\/api\\/v1\\/sign\",\"message\":\"INVALID_REQUIRED_FIELDS=The fields: `login,password` is required&developer=http:\\/\\/backend.local\\/api\\/v1\\/errors\\/6\"}',1439163023),(9,'Rest',2,'{\"exception\":\"Unauthorized : 401\",\"ip\":\"127.0.0.1\",\"refer\":\"\",\"method\":\"GET\",\"uri\":\"http:\\/\\/backend.local\\/\\/api\\/v1\\/users\",\"message\":\"AUTH_ACCESS_REQUIRED=Only for authenticated users&developer=http:\\/\\/backend.local\\/api\\/v1\\/errors\\/9\"}',1439163023);
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-13  2:22:34
