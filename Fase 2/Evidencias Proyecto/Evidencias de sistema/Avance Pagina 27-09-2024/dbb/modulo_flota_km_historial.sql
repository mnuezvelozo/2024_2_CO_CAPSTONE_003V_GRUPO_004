-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: modulo_flota
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `km_historial`
--

DROP TABLE IF EXISTS `km_historial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `km_historial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patente` varchar(8) NOT NULL,
  `km` int(11) NOT NULL,
  `fecha_actualizacion` date NOT NULL,
  `actualizado_por` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patente` (`patente`),
  CONSTRAINT `km_historial_ibfk_1` FOREIGN KEY (`patente`) REFERENCES `vehiculo` (`patente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `km_historial`
--

LOCK TABLES `km_historial` WRITE;
/*!40000 ALTER TABLE `km_historial` DISABLE KEYS */;
INSERT INTO `km_historial` VALUES (1,'PSPC14',10100,'2024-09-23','Nombre del Usuario'),(2,'PSPC14',10200,'2024-09-23','Nombre del Usuario'),(3,'JHJG13',24500,'2024-09-23','Nombre del Usuario'),(4,'JGYP14',17000,'2024-09-23',NULL),(5,'JGYP14',17500,'2024-09-23',NULL),(6,'JGYP14',17600,'2024-09-23',NULL),(7,'PSPC14',10400,'2024-09-23',NULL),(8,'PSPC14',10400,'2024-09-23',NULL),(9,'PSPC14',10400,'2024-09-23',NULL),(10,'PSPC14',10400,'2024-09-23',NULL),(11,'PSPC14',10500,'2024-09-23',NULL),(12,'JHJG13',24500,'2024-09-23','Desconocido'),(13,'JGYP14',17700,'2024-09-23','Desconocido'),(14,'JGYP14',17900,'2024-09-23','Michael Nuñez Velozo'),(15,'JGYP14',17950,'2024-09-23','Joaquin Flores Rodriguez'),(16,'JHJG13',24600,'2024-09-23','Michael Nuñez Velozo'),(17,'PSPC14',10501,'2024-09-23','Michael Nuñez Velozo'),(18,'PSPC14',10505,'2024-09-23','Michael Nuñez Velozo'),(19,'PSPC14',25000,'2024-09-24','Michael Nuñez Velozo'),(20,'PSPC14',34000,'2024-09-24','Michael Nuñez Velozo'),(21,'PSPC14',36000,'2024-10-01','Michael Núñez Velozo'),(22,'PSPC14',37000,'2024-10-10','Michael Núñez Velozo'),(23,'PSPC14',38000,'2024-10-15','Joaquin Flores Rodriguez'),(24,'PSPC14',39000,'2024-10-20','Michael Núñez Velozo'),(25,'PSPC14',40000,'2024-10-25','Michael Núñez Velozo'),(26,'HLYH97',25000,'2024-09-20','Michael Núñez Velozo'),(27,'HLYH97',26000,'2024-09-25','Michael Núñez Velozo'),(28,'HLYH97',27000,'2024-10-01','Joaquin Flores Rodriguez'),(29,'HLYH97',28000,'2024-10-05','Michael Núñez Velozo'),(30,'HLYH97',29000,'2024-10-10','Michael Núñez Velozo'),(31,'HLYH97',30000,'2024-10-15','Michael Núñez Velozo'),(32,'HLYH97',31000,'2024-10-20','Michael Núñez Velozo'),(38,'JGYP14',18500,'2024-09-26','Joaquin Flores Rodriguez'),(39,'JGYP14',19000,'2024-09-30','Michael Núñez Velozo'),(40,'JGYP14',19500,'2024-10-05','Michael Núñez Velozo'),(41,'JGYP14',20000,'2024-10-10','Michael Núñez Velozo'),(42,'JGYP14',20500,'2024-10-15','Joaquin Flores Rodriguez'),(43,'JHJG13',25000,'2024-09-23','Michael Núñez Velozo'),(44,'JHJG13',26000,'2024-09-30','Michael Núñez Velozo'),(45,'JHJG13',27000,'2024-10-05','Joaquin Flores Rodriguez'),(46,'JHJG13',28000,'2024-10-10','Michael Núñez Velozo'),(47,'JHJG13',29000,'2024-10-15','Michael Núñez Velozo'),(48,'CWKV75',18000,'2024-09-15','Michael Núñez Velozo'),(49,'CWKV75',19000,'2024-09-22','Michael Núñez Velozo'),(50,'CWKV75',20000,'2024-09-28','Joaquin Flores Rodriguez'),(51,'CWKV75',21000,'2024-10-01','Michael Núñez Velozo'),(52,'CWKV75',22000,'2024-10-10','Michael Núñez Velozo'),(53,'ZXTY76',70000,'2024-09-27','Michael Nuñez Velozo'),(54,'ZXTY76',80000,'2024-09-27','Michael Nuñez Velozo');
/*!40000 ALTER TABLE `km_historial` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-27 16:30:12
