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
-- Table structure for table `solicitud_combustible`
--

DROP TABLE IF EXISTS `solicitud_combustible`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitud_combustible` (
  `id_solicitud` int(11) NOT NULL AUTO_INCREMENT,
  `patente` varchar(8) NOT NULL,
  `rut` varchar(15) NOT NULL,
  `fecha` date NOT NULL,
  `kilometraje` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `estado` enum('Pendiente','Aprobada','Denegada') DEFAULT 'Pendiente',
  `rut_autorizador` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_solicitud`),
  KEY `patente` (`patente`),
  KEY `rut` (`rut`),
  CONSTRAINT `solicitud_combustible_ibfk_1` FOREIGN KEY (`patente`) REFERENCES `vehiculo` (`patente`),
  CONSTRAINT `solicitud_combustible_ibfk_2` FOREIGN KEY (`rut`) REFERENCES `usuario` (`rut`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud_combustible`
--

LOCK TABLES `solicitud_combustible` WRITE;
/*!40000 ALTER TABLE `solicitud_combustible` DISABLE KEYS */;
INSERT INTO `solicitud_combustible` VALUES (10,'FRDE56','19.157.302-1','2024-09-30',1500,50000.00,'Denegada','20.362.114-0'),(11,'ZXCV87','19.157.302-1','2024-09-30',4000,45000.00,'Aprobada','20.362.114-0'),(12,'ZXTY76','11.111.111-1','2024-09-30',5000,35000.00,'Aprobada','20.362.114-0');
/*!40000 ALTER TABLE `solicitud_combustible` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-30 12:28:12
