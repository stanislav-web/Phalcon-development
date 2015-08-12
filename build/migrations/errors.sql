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
-- Table structure for table `errors`
--

DROP TABLE IF EXISTS `errors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `errors` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Error ID',
  `code` varchar(65) NOT NULL DEFAULT '' COMMENT 'Error Code',
  `description` text NOT NULL COMMENT 'Description',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_code` (`code`) COMMENT 'Unique code'
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COMMENT='Description table for error reports';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `errors`
--

LOCK TABLES `errors` WRITE;
/*!40000 ALTER TABLE `errors` DISABLE KEYS */;
INSERT INTO `errors` VALUES (1,'RECORDS_NOT_FOUND','Means that the requested record does not exist'),(2,'FILTERS_IS_NOT_SUPPORT','Means that you can not use this filter in the query string'),(3,'LANGUAGE_IS_NOT_SUPPORT','Means that you specify the localization is not used in our system'),(4,'EMPTY_PARAMETER_IN_URI','Means that you can not use the argument of the query string without its value'),(5,'INVALID_COLUMNS','Means that in a query, you can not do the sample for the specified fields'),(6,'INVALID_REQUIRED_FIELDS','Means that in a query, you must use the specified fields'),(7,'LONG_REQUEST','Means that the query string is too big for the request'),(8,'CONTENT_IS_NOT_SUPPORT','Means that you requested content type is not supported in the system'),(9,'AUTH_ACCESS_REQUIRED','Means that the requested resource requires authorization by token'),(10,'ACCESS_DENIED','Means that the need for the requested resource rights that you do not have'),(11,'UNAUTHORIZED_REQUEST','Means that the server rejected your request because you are not using the correct data authorization'),(12,'USER_NOT_FOUND','Means that the user you have requested the system does not have'),(13,'USER_EXIST','Means that you are trying to add a user to a system that already exists in'),(14,'LOGIN_REQUIRED','Means that the login is absolutely necessary'),(15,'USER_PASSWORD_REQUIRED','Means that the password is absolutely necessary'),(16,'LOGIN_MAX_INVALID','Means that the login is too large'),(17,'LOGIN_MIX_INVALID','Means that the login is too small'),(18,'USERNAME_MAX_INVALID','Means that the name is too large'),(19,'USERNAME_MIN_INVALID','Means that the name is too small'),(20,'LOGIN_FORMAT_INVALID','Means that the login have not correct format. Note the error message and bring it to the specified format'),(21,'FIELD_IS_REQUIRED','Means that you may have missed the parameters that are necessary to update or add records'),(22,'RECOVERY_ACCESS_FAILED','Fail restore user access. May be service temporary unavailable. Try again later'),(23,'TO_MANY_REQUESTS','Request limit is exhausted '),(24,'HOST_NOT_FOUND','Requested host not found'),(25,'RECORD_CAN_NOT_BE_CREATED','The record can not be created'),(26,'LOG_CODE_NOT_FOUND','Log code is undefined'),(27,'RELATED_RECORDS_NOT_FOUND','That mean that related records not found in system'),(28,'UPLOAD_FILE_ERROR','No comprehensive data for upload'),(29,'EMPTY_UPLOAD_PARAM','Empty adjacent to the discharge parameters'),(30,'HANDLER_MAPPER_NOT_EXIST','The handle mapper for upload does not exist'),(31,'PRIMARY_KEY_NOT_EXIST','Do not set a primary key'),(32,'ABOUT_MAX_INVALID','The about is too long'),(33,'UPDATE_PROFILE_PHOTO_FAILED','Can not update profile photo'),(34,'SUBSCRIBER_EMAIL_REQUIRED','Email address is required'),(35,'SUBSCRIBER_EMAIL_INVALID','Email address invalid'),(36,'SUBSCRIBER_EMAIL_EXIST','This email address already exist'),(37,'HOST_EXIST','This host already exist in list'),(38,'CODE_EXIST','This code already exist in list'),(39,'ENGINE_NAME_REQUIRED','The engine name is required'),(40,'ENGINE_HOST_REQUIRED','The engine host is required'),(41,'ENGINE_CODE_REQUIRED','The engine code is required'),(42,'CATEGORY_ALIAS_ALREADY_EXIST','This alias already exist'),(43,'CATEGORY_DESCRIPTION_MAX_INVALID','Description must have maximum 512 characters'),(44,'CATEGORY_DESCRIPTION_MIN_INVALID','Description must have minimum 15 characters'),(45,'CATEGORY_TITLE_REQUIRED','The category title is required'),(46,'CATEGORY_DESCRIPTION_REQUIRED','The category description is required'),(47,'SURNAME_MIN_INVALID','The surname is too short'),(48,'SURNAME_MAX_INVALID','The surname name is too long'),(49,'VIEW_SERVICE_NOT_DEFINED','The `view` service is not defined');
/*!40000 ALTER TABLE `errors` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-12  3:58:00
