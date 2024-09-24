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
-- Table structure for table `siniestro`
--

DROP TABLE IF EXISTS `siniestro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `siniestro` (
  `id_siniestro` int(11) NOT NULL AUTO_INCREMENT,
  `patente` varchar(8) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `id_tipo_siniestro` int(11) DEFAULT NULL,
  `daño` text DEFAULT NULL,
  `rut` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_siniestro`),
  KEY `fk_siniestro_vehiculo_new` (`patente`),
  KEY `fk_siniestro_tipo_siniestro_new` (`id_tipo_siniestro`),
  KEY `fk_siniestro_usuario_new` (`rut`),
  CONSTRAINT `fk_siniestro_tipo_siniestro_new` FOREIGN KEY (`id_tipo_siniestro`) REFERENCES `tipo_siniestro` (`id_tipo_siniestro`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_siniestro_usuario_new` FOREIGN KEY (`rut`) REFERENCES `usuario` (`rut`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_siniestro_vehiculo_new` FOREIGN KEY (`patente`) REFERENCES `vehiculo` (`patente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siniestro`
--

LOCK TABLES `siniestro` WRITE;
/*!40000 ALTER TABLE `siniestro` DISABLE KEYS */;
INSERT INTO `siniestro` VALUES (1,'CWKV75','2024-09-24',2,'daño colateral producido por un accidente multiple','19.478.524-4'),(2,'CWKV75','2024-09-24',1,'Se reparo!','19.478.524-4'),(3,'CWKV75','2024-09-24',3,'Murio gg','19.478.524-4'),(4,'CWKV75','2024-09-24',2,'Seguimos esperanding','19.478.524-4'),(5,'PSPC14','2024-09-18',2,'Daño producido por un choque en el espejo lateral izquierdo','20.362.114-0'),(6,'PSPC14','2024-09-24',1,'Vehículo reparado desde taller , quedando en buenas condiciones ','20.362.114-0'),(7,'HLYH97','2024-09-20',2,'Se murio el motor gg nt wp','20.478.452-7');
/*!40000 ALTER TABLE `siniestro` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-24 16:47:15
