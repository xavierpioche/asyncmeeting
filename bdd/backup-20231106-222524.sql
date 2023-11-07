-- MySQL dump 10.13  Distrib 8.0.35, for Linux (x86_64)
--
-- Host: localhost    Database: asyncmeeting
-- ------------------------------------------------------
-- Server version	8.0.35-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agendum`
--

DROP TABLE IF EXISTS `agendum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agendum` (
  `agendum_id` int NOT NULL AUTO_INCREMENT,
  `meeting_id` int NOT NULL,
  `agendum_label` varchar(255) NOT NULL,
  `is_default` tinyint DEFAULT '0',
  PRIMARY KEY (`agendum_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agendum`
--

LOCK TABLES `agendum` WRITE;
/*!40000 ALTER TABLE `agendum` DISABLE KEYS */;
INSERT INTO `agendum` VALUES (17,17,'summary',1),(18,17,'prerequis',0),(19,17,'architecture',0),(20,17,'implementation',0),(21,18,'summary',0),(24,19,'summary',1),(25,19,'kick-off',0),(26,19,'vabf',0),(27,20,'other videos',1),(28,20,'archi',0),(29,20,'imple',0),(30,20,'run',0),(31,21,'summary',1),(32,21,'sujet1',0),(35,21,'un nouveau',0);
/*!40000 ALTER TABLE `agendum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agendum_videos`
--

DROP TABLE IF EXISTS `agendum_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agendum_videos` (
  `ag_video_id` int NOT NULL AUTO_INCREMENT,
  `ag_video_link` varchar(500) DEFAULT NULL,
  `agendum_id` int NOT NULL,
  `is_default` tinyint DEFAULT '0',
  PRIMARY KEY (`ag_video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agendum_videos`
--

LOCK TABLES `agendum_videos` WRITE;
/*!40000 ALTER TABLE `agendum_videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `agendum_videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `languages` (
  `id_label` int NOT NULL,
  `id_language` int NOT NULL,
  `label` text,
  PRIMARY KEY (`id_label`,`id_language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (10,0,'sign-in'),(11,0,'login'),(12,0,'password'),(13,0,'enter'),(14,0,'password must be 8 to 15 characters long which contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character'),(15,0,'back'),(16,0,'verify password'),(17,0,'create your account'),(18,0,'email'),(19,0,'dashboard'),(20,0,'responsible'),(21,0,'accountable'),(22,0,'consulted'),(23,0,'informed'),(24,0,'create a meeting'),(25,0,'agendum'),(26,0,'participants'),(27,0,'meeting name'),(28,0,'meeting already exists'),(29,0,'meeting created'),(30,0,'you are invited in'),(31,0,'show meeting'),(32,0,'submit'),(33,0,'summary'),(34,0,'show videos'),(35,0,'save'),(36,0,'all videos'),(37,0,'insert a video link'),(38,0,'are you sure you want to delete this video?'),(39,0,'record a video'),(40,0,'comments'),(41,0,'new comments'),(42,0,'in'),(43,0,'select an agendum in the left pane');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meeting_roles`
--

DROP TABLE IF EXISTS `meeting_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meeting_roles` (
  `m_role_id` int NOT NULL,
  `m_role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`m_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting_roles`
--

LOCK TABLES `meeting_roles` WRITE;
/*!40000 ALTER TABLE `meeting_roles` DISABLE KEYS */;
INSERT INTO `meeting_roles` VALUES (0,'responsible'),(1,'accountable'),(2,'consulted'),(3,'informed');
/*!40000 ALTER TABLE `meeting_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meeting_roles_by_users`
--

DROP TABLE IF EXISTS `meeting_roles_by_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meeting_roles_by_users` (
  `meeting_id` int NOT NULL,
  `user_id` int NOT NULL,
  `m_role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting_roles_by_users`
--

LOCK TABLES `meeting_roles_by_users` WRITE;
/*!40000 ALTER TABLE `meeting_roles_by_users` DISABLE KEYS */;
INSERT INTO `meeting_roles_by_users` VALUES (17,14,0),(18,14,0),(19,14,0),(20,15,0),(21,17,0),(21,16,1);
/*!40000 ALTER TABLE `meeting_roles_by_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meetings`
--

DROP TABLE IF EXISTS `meetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meetings` (
  `meeting_id` int NOT NULL AUTO_INCREMENT,
  `meeting_name` varchar(255) NOT NULL,
  `meeting_owner` int NOT NULL,
  PRIMARY KEY (`meeting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meetings`
--

LOCK TABLES `meetings` WRITE;
/*!40000 ALTER TABLE `meetings` DISABLE KEYS */;
INSERT INTO `meetings` VALUES (17,'migration erp',14),(18,'migration dcrm',14),(19,'exemple 3',14),(20,'test',15),(21,'usa',17);
/*!40000 ALTER TABLE `meetings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participants`
--

DROP TABLE IF EXISTS `participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `participants` (
  `meeting_id` int NOT NULL,
  `participant_id` int NOT NULL,
  `role_id` int NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participants`
--

LOCK TABLES `participants` WRITE;
/*!40000 ALTER TABLE `participants` DISABLE KEYS */;
/*!40000 ALTER TABLE `participants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participants_invite`
--

DROP TABLE IF EXISTS `participants_invite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `participants_invite` (
  `meeting_id` int NOT NULL,
  `participant_email` varchar(500) NOT NULL,
  `role_id` int NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participants_invite`
--

LOCK TABLES `participants_invite` WRITE;
/*!40000 ALTER TABLE `participants_invite` DISABLE KEYS */;
INSERT INTO `participants_invite` VALUES (17,'stephane@stephane.com',2),(17,'laury@laury.com',2),(17,'clara@clara.com',1),(18,'stephane@stephane.com',1),(19,'zfzfzefzefez',2),(20,'rgeg@greg.com',0),(20,'sissiy@sissi.com',0);
/*!40000 ALTER TABLE `participants_invite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_users`
--

DROP TABLE IF EXISTS `system_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_users` (
  `user_id` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(500) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `activation_expire` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_users`
--

LOCK TABLES `system_users` WRITE;
/*!40000 ALTER TABLE `system_users` DISABLE KEYS */;
INSERT INTO `system_users` VALUES (14,'toto@gmail.com',NULL,NULL,'$2y$10$TRoEYRVF6QiZrcuChn3ZcOpnDsKDVDxlJbDJOTaz8SpiUnVlHDqNy','5c43e34b96f9096652eb2a491504b6e0','2023-11-04 10:49:10',0),(15,'xavier.pioche@laposte.net',NULL,NULL,'$2y$10$zGVGB9qRgspwEPkyA/jQ0.cGDgPj2XerQKbYS9KNZD/Suj35osDNq','2e4b25ed3335fa2d958fb03ec6f0ce97','2023-11-05 15:15:52',0),(16,'stephane@stephane.com',NULL,NULL,'$2y$10$pUyUukLpQj4hzc9.BrzWfu.NVzLPLwon0jFJkFJrgrGHQ4KkC5KjW','9da46a1b57f52481658cbc8e0786b9b3','2023-11-06 19:36:02',0),(17,'mimi@gmail.com',NULL,NULL,'$2y$10$kGHG4yXDniVpz4gnexSyzOUJG5T0MwZTz1QEbK2UmBhsN/y8Dtp.K','7942c780634a77d301c9ce82c5ea2c00','2023-11-06 19:46:04',0);
/*!40000 ALTER TABLE `system_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `todo_list`
--

DROP TABLE IF EXISTS `todo_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `todo_list` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `content` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `todo_list`
--

LOCK TABLES `todo_list` WRITE;
/*!40000 ALTER TABLE `todo_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `todo_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `video_id` int NOT NULL AUTO_INCREMENT,
  `meeting_id` int NOT NULL,
  `agendum_id` int DEFAULT NULL,
  `video_owner` int DEFAULT NULL,
  `video_link` varchar(500) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `video_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`video_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` VALUES (8,19,24,14,'https://raw.githubusercontent.com/Ahmetaksungur/aksvideoplayer/main/videos/video-360.mp4',0,'archi'),(9,21,31,17,'https://raw.githubusercontent.com/Ahmetaksungur/aksvideoplayer/main/videos/video-360.mp4',0,'intro');
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos_comments`
--

DROP TABLE IF EXISTS `videos_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos_comments` (
  `comment_id` int NOT NULL AUTO_INCREMENT,
  `comment_videolink` int DEFAULT NULL,
  `comment_time` time DEFAULT NULL,
  `comment_value` varchar(255) DEFAULT NULL,
  `comment_owner` int DEFAULT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos_comments`
--

LOCK TABLES `videos_comments` WRITE;
/*!40000 ALTER TABLE `videos_comments` DISABLE KEYS */;
INSERT INTO `videos_comments` VALUES (12,9,'00:00:07',' le temps',NULL),(14,8,'00:00:11','je modifie encore',NULL),(15,8,'00:00:35','et celui la',NULL);
/*!40000 ALTER TABLE `videos_comments` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-06 22:25:24
