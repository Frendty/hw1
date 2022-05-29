-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: hw1
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `post` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `comment_post` (`post`),
  KEY `comment_user` (`user`),
  CONSTRAINT `comment_post` FOREIGN KEY (`post`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comment_user` FOREIGN KEY (`user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,1,12,'aaaa','2022-05-29 14:53:49'),(2,1,12,'djosiadjoisa','2022-05-29 14:58:23'),(3,1,12,'ciaooo','2022-05-29 15:03:45'),(4,1,12,'bbbbb','2022-05-29 15:04:31'),(5,1,12,'ddddd','2022-05-29 15:05:56'),(6,1,12,'mannaggia','2022-05-29 15:06:41'),(7,1,12,'cccc','2022-05-29 15:14:31'),(8,1,12,'dddd','2022-05-29 15:15:45'),(9,1,12,'ffffff','2022-05-29 15:17:44'),(10,1,12,'gggg','2022-05-29 15:37:37'),(11,1,13,'Stupenda!','2022-05-29 17:17:26'),(12,1,13,'Stupenda!','2022-05-29 17:17:29'),(13,1,13,'Stupenda!','2022-05-29 17:17:34'),(14,1,13,'Stupenda!','2022-05-29 17:17:34'),(15,1,13,'Stupenda!','2022-05-29 17:17:34'),(16,1,13,'Stupenda!','2022-05-29 17:17:35'),(17,1,13,'Bella','2022-05-29 17:18:31'),(18,1,13,'Fantastica!','2022-05-29 17:19:23'),(19,1,13,'Bellissimaaaa','2022-05-29 17:23:15'),(20,1,13,'Prova','2022-05-29 18:42:49'),(21,1,13,'Prova 1','2022-05-29 18:53:04'),(22,1,13,'Prova 3','2022-05-29 18:53:53'),(23,1,12,'hhhhh','2022-05-29 18:54:42'),(24,1,12,'iiiiii','2022-05-29 18:55:28'),(25,1,13,'Prova 2','2022-05-29 18:56:14'),(26,1,13,'Prova 4','2022-05-29 19:01:46'),(27,1,13,'Prova 5','2022-05-29 19:02:51'),(28,1,13,'Prova prova','2022-05-29 19:06:57'),(29,1,13,'Provaaaaaaaaaaaaaa','2022-05-29 19:08:47'),(30,1,13,'Provaaaaaaaaaaaaaa2','2022-05-29 19:08:58'),(31,1,10,'Windsurfff','2022-05-29 19:30:15'),(32,1,9,'Stadiooo','2022-05-29 19:30:41'),(33,1,2,'Cat','2022-05-29 19:31:34');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `updateComments` AFTER INSERT ON `comments` FOR EACH ROW BEGIN

	UPDATE posts 

	SET posts.ncomments = posts.ncomments + 1

	WHERE posts.id = new.post;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends` (
  `user` int(11) NOT NULL,
  `user_friend` int(11) NOT NULL,
  PRIMARY KEY (`user`,`user_friend`),
  KEY `user` (`user`,`user_friend`),
  KEY `friends_user_friend` (`user_friend`),
  CONSTRAINT `friends_user` FOREIGN KEY (`user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `friends_user_friend` FOREIGN KEY (`user_friend`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends`
--

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
INSERT INTO `friends` VALUES (1,1),(1,2),(2,1);
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `user` int(11) NOT NULL,
  `post` int(11) NOT NULL,
  PRIMARY KEY (`user`,`post`),
  KEY `user` (`user`,`post`),
  KEY `like_post` (`post`),
  CONSTRAINT `like_post` FOREIGN KEY (`post`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `like_user` FOREIGN KEY (`user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (1,4),(1,12),(1,13);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `updateLikes` AFTER INSERT ON `likes` FOR EACH ROW BEGIN

	UPDATE posts 

	SET posts.nlikes = posts.nlikes + 1

	WHERE posts.id = new.post;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `removeLikes` AFTER DELETE ON `likes` FOR EACH ROW BEGIN

    UPDATE posts 

    SET posts.nlikes = posts.nlikes - 1

    WHERE posts.id = old.post;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `nlikes` int(11) NOT NULL DEFAULT 0,
  `ncomments` int(11) NOT NULL DEFAULT 0,
  `url_image` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_post` (`user`),
  CONSTRAINT `user_post` FOREIGN KEY (`user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,1,0,0,'https://siviaggia.it/wp-content/uploads/sites/2/2019/02/la-terra-di-mezzo-del-signore-degli-anelli-arriva-in-scozia.jpg','Immagine Terra di Mezzo','2022-05-25 15:48:10'),(2,1,0,1,'https://mypetandme.elanco.com/sites/g/files/adhwdz651/files/styles/paragraph_image/public/2020-04/immagine_gatto_generica_0.jpg?itok=VNB7I_8H','Gatto','2022-05-25 15:48:10'),(3,1,0,0,'https://images.unsplash.com/photo-1526336024174-e58f5cdd8e13?ixid=MnwzMzIzMTl8MHwxfHNlYXJjaHwxfHxjYXR8ZW58MHx8fHwxNjUzNzQ3MDcy&ixlib=rb-1.2.1','Che bel gatto!','2022-05-28 16:21:16'),(4,1,1,0,'https://images.unsplash.com/photo-1587300003388-59208cc962cb?ixid=MnwzMzIzMTl8MHwxfHNlYXJjaHw2fHxkb2d8ZW58MHx8fHwxNjUzNzQ0NjMy&ixlib=rb-1.2.1','Doggo!','2022-05-28 16:25:10'),(5,1,0,0,'https://images.unsplash.com/photo-1552053831-71594a27632d?ixid=MnwzMzIzMTl8MHwxfHNlYXJjaHwzfHxkb2d8ZW58MHx8fHwxNjUzNzQ0NjMy&ixlib=rb-1.2.1','Doggo 2!','2022-05-28 16:29:43'),(6,1,0,0,'https://images.unsplash.com/photo-1530824395616-b1ec7fac4aff?ixid=MnwzMzIzMTl8MHwxfHNlYXJjaHw2fHxHaXJhZmZlfGVufDB8fHx8MTY1Mzc1NjIzMw&ixlib=rb-1.2.1','Beautiful Giraffa!!!','2022-05-28 16:44:38'),(7,1,0,0,'https://images.unsplash.com/photo-1572155935026-e6fbec6a2697?ixid=MnwzMzIzMTl8MHwxfHNlYXJjaHw5fHxDYW1lbHxlbnwwfHx8fDE2NTM3NTYzOTA&ixlib=rb-1.2.1','','2022-05-28 16:46:55'),(8,1,0,0,'https://images.unsplash.com/photo-1621693884514-98bac2d52542?ixid=MnwzMzIzMTl8MHwxfHNlYXJjaHw1fHxTY3JlYW0lMjBmaWxtfGVufDB8fHx8MTY1Mzc1NjY2Mg&ixlib=rb-1.2.1','Bellaaa (cit.)','2022-05-28 16:51:54'),(9,1,0,1,'https://images.unsplash.com/photo-1517747614396-d21a78b850e8?ixid=MnwzMzIzMTl8MHwxfHNlYXJjaHwzfHxTb2NjZXJ8ZW58MHx8fHwxNjUzNzU2Nzg3&ixlib=rb-1.2.1','','2022-05-28 16:53:18'),(10,1,0,1,'https://images.unsplash.com/photo-1533607837082-2f5aeab12801?ixid=MnwzMzIzMTl8MHwxfHNlYXJjaHwxfHxXaW5kc3VyZnxlbnwwfHx8fDE2NTM3NTcwMDQ&ixlib=rb-1.2.1','','2022-05-28 16:56:59'),(11,2,0,0,'https://images.unsplash.com/photo-1579825141687-6cd69ce6f9cd?ixid=MnwzMzIzMTl8MHwxfHNlYXJjaHwxfHxDaGFtcGlvbnN8ZW58MHx8fHwxNjUzNzYyMTAy&ixlib=rb-1.2.1','Campioniiiiii','2022-05-28 18:22:04'),(12,2,1,12,'https://images.unsplash.com/photo-1580674571597-618e1004b923?ixid=MnwzMzIzMTl8MHwxfHNlYXJjaHwxfHxGcmFuY298ZW58MHx8fHwxNjUzNzYyMjI4&ixlib=rb-1.2.1','Franco?','2022-05-28 18:24:06'),(13,2,1,18,'https://images.unsplash.com/photo-1614314107768-6018061b5b72?ixid=MnwzMzIzMTl8MHwxfHNlYXJjaHwxfHxQbHV0b3xlbnwwfHx8fDE2NTM3NjIzNDg&ixlib=rb-1.2.1','','2022-05-28 18:26:23'),(14,1,0,0,'https://images.unsplash.com/photo-1570481662006-a3a1374699e8?ixid=MnwzMzIzMTl8MHwxfHNlYXJjaHwyfHxkb2xwaGlufGVufDB8fHx8MTY1Mzg1NTI3NQ&ixlib=rb-1.2.1','che belloooo','2022-05-29 20:14:58'),(15,1,0,0,'https://images.unsplash.com/photo-1495360010541-f48722b34f7d?ixid=MnwzMzIzMTl8MHwxfHNlYXJjaHwzfHxjYXR8ZW58MHx8fHwxNjUzNzQ3MDcy&ixlib=rb-1.2.1','','2022-05-29 20:15:50'),(16,1,0,0,'https://images.unsplash.com/photo-1523670982602-6bb44fd1586e?ixid=MnwzMzIzMTl8MHwxfHNlYXJjaHwzfHxEb2xwaGlufGVufDB8fHx8MTY1Mzg1NTM4Mw&ixlib=rb-1.2.1','Wow!','2022-05-29 20:16:41');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT '/images/avatars/unknown.png',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Federico','Ragusa','Fred','federicoragusa@hotmail.com','$2y$10$ZW0cDOZGqmq04B3BYOmvrue6cfDiRlWZJhWMjlj7caYZiXZa/O.Bm','/images/avatars/unknown.png'),(2,'Francesco','Giorgio','FraGeorge','fraggiorgio@gmail.com','$2y$10$TdEKKpG6bbuoKvMPkEe/H.rkT59QYwWcpGAMVK22GHw5qp9AC2tJK','/images/avatars/unknown.png');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-29 23:30:25

DELIMITER //
CREATE TRIGGER `removeLikes` AFTER DELETE ON `likes`
 FOR EACH ROW BEGIN
    UPDATE posts 
    SET posts.nlikes = posts.nlikes - 1
    WHERE posts.id = old.post;
END //

DELIMITER ;

DELIMITER //
CREATE TRIGGER `updateComments` AFTER INSERT ON `comments`
 FOR EACH ROW BEGIN
	UPDATE posts 
	SET posts.ncomments = posts.ncomments + 1
	WHERE posts.id = new.post;
END //

DELIMITER ;

DELIMITER //
CREATE TRIGGER `updateLikes` AFTER INSERT ON `likes`
 FOR EACH ROW BEGIN
	UPDATE posts 
	SET posts.nlikes = posts.nlikes + 1
	WHERE posts.id = new.post;
END //

DELIMITER ;