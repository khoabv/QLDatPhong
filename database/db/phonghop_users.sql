-- MySQL dump 10.13  Distrib 8.0.13, for Win64 (x86_64)
--
-- Host: localhost    Database: phonghop
-- ------------------------------------------------------
-- Server version	8.0.13

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (5,'Đoàn Cảnh Thống 1','admin@gmail.com','$2y$10$Rp6DMu2JL1MYJUoWiVvH1.zKWsPH96lf8oRBSgeTDRztfelLrwP6a','user',NULL,'2020-03-25 09:59:43','2020-03-29 11:57:27'),(10,'3AE Shop','admin333@gmail.com','$2y$10$o12juS7CLmgh5X61Jel0CuwtBSjqJAzq/RYJNrq.1pcuI0n6rJ4j2','user',NULL,'2020-03-25 10:20:15','2020-03-25 10:20:15'),(11,'NGUYỄN VĂN THIỆN222','admin1@gmail.com11111','$2y$10$m4iO7xmrsISmN5IwueTJzeePHafXpFxbkHUK5kw8h23v.fcZfH/sy','user',NULL,'2020-03-25 10:21:27','2020-03-25 10:21:27'),(14,'Đoàn Cảnh Thống222','admin1122@gmail.com','$2y$10$5KjC730NDrTYZxjEOJLKuOSB7IIDR.c0A3.UNc4BcpOREOEbfg/7.','user',NULL,'2020-03-25 10:24:37','2020-03-25 10:24:37'),(15,'Đoàn Cảnh Thống222','admin11222@gmail.com','$2y$10$5KjC730NDrTYZxjEOJLKuOSB7IIDR.c0A3.UNc4BcpOREOEbfg/7.','user','','2020-03-25 10:24:37','2020-03-25 10:24:37'),(16,'Chu Dai Admin','admin12@gmail.com','$2y$10$Ty7oCPZCWeZSoLbEXeBEPelV19qwFBVXfZbYcqkn1kLjxcTkjSVc2','admin','','2020-03-17 08:57:43','2020-03-17 08:57:43'),(17,'Đoàn Cảnh Thống','admin13@gmail.com','$2y$10$754GVeBX1RvnJVQI.naDFeFBqNIO2xplML1EhMZ0k6pgc16IAveQi','user','','2020-03-25 09:59:43','2020-03-25 09:59:43'),(18,'3AE Shop','admin14@gmail.com','$2y$10$DzISZZr9Ypezw.HS./x3K.az/2ELSHI2rsEErZfe8/ZTYRmN8Ypai','user','','2020-03-25 10:15:43','2020-03-25 10:15:43'),(19,'3AE Shop','admin15@gmail.com','$2y$10$o12juS7CLmgh5X61Jel0CuwtBSjqJAzq/RYJNrq.1pcuI0n6rJ4j2','user','','2020-03-25 10:20:15','2020-03-25 10:20:15'),(20,'NGUYỄN VĂN THIỆN222','admin16@gmail.com','$2y$10$m4iO7xmrsISmN5IwueTJzeePHafXpFxbkHUK5kw8h23v.fcZfH/sy','user','','2020-03-25 10:21:27','2020-03-25 10:21:27'),(21,'Đoàn Cảnh Thống222','admin17@gmail.com','$2y$10$5KjC730NDrTYZxjEOJLKuOSB7IIDR.c0A3.UNc4BcpOREOEbfg/7.','user','','2020-03-25 10:24:37','2020-03-25 10:24:37'),(22,'Đoàn Cảnh Thống222','admin18@gmail.com','$2y$10$5KjC730NDrTYZxjEOJLKuOSB7IIDR.c0A3.UNc4BcpOREOEbfg/7.','user','','2020-03-25 10:24:37','2020-03-25 10:24:37'),(23,'Người dùng 1','nguoidung1@gmail.com','$2y$10$hd4P2ycs4QnDQ9wDox2Xxun4tzqEh7BLDPzWjuExaZck6ItRoICbm','user',NULL,'2020-03-28 05:25:33','2020-03-28 05:25:33'),(24,'nguyễn văn a1','nuguyenvana@gmail.com','$2y$10$QnG5Be6PpYll6IHvyetmi.NKHemQOo.KJ3/I/TtK4ZqJuQleWS3Xe','user',NULL,'2020-03-29 10:44:45','2020-03-29 10:45:54'),(25,'aaaaaaaaa','adminaaaaaa@gmail.com','$2y$10$WG3Rq7/Bsx5//92buYnPIeVUGEXYrnjQslON72/7UQcpb8jhAWqo6','user',NULL,'2020-04-15 11:27:28','2020-04-15 11:27:28');
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

-- Dump completed on 2020-04-25 20:59:51
