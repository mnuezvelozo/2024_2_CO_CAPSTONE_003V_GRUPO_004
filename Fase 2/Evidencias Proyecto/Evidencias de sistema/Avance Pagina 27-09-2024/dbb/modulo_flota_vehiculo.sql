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
-- Table structure for table `vehiculo`
--

DROP TABLE IF EXISTS `vehiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehiculo` (
  `patente` varchar(8) NOT NULL,
  `marca` varchar(20) DEFAULT NULL,
  `modelo` varchar(20) DEFAULT NULL,
  `año` int(11) DEFAULT NULL,
  `km_actual` int(11) DEFAULT NULL,
  `fecha_revision_tecnica` date DEFAULT NULL,
  `rut` varchar(15) DEFAULT NULL,
  `activo` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`patente`),
  KEY `fk_vehiculo_usuario` (`rut`),
  CONSTRAINT `fk_vehiculo_usuario` FOREIGN KEY (`rut`) REFERENCES `usuario` (`rut`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehiculo`
--

LOCK TABLES `vehiculo` WRITE;
/*!40000 ALTER TABLE `vehiculo` DISABLE KEYS */;
INSERT INTO `vehiculo` VALUES ('BKJW98','Chevrolet','Aveo',2009,157000,'2024-11-24',NULL,'no'),('BVCX32','Suzuki','Vitara',2022,20000,'2024-11-08','19.478.524-4','Si'),('CWKV75','Citroen','Berlingo',2022,15000,'2024-11-21','20.362.114-0','Si'),('FKXV38','Citroen','Berlingo',2022,13000,'2024-11-21','20.362.114-0','Si'),('FRDE56','Toyota','Corolla',2022,12000,'2024-11-20','19.478.524-4','Si'),('HGWZ58','Citroen','Berlingo',2022,20000,'2024-11-21','20.362.114-0','Si'),('HLYH97','Peugeot','Partner',2023,8700,'2024-10-18','20.362.114-0','Si'),('HYJB29','Peugeot','Partner',2023,5000,'2024-10-18','20.362.114-0','Si'),('JGYP14','Peugeot','Partner',2023,17950,'2024-10-18','20.362.114-0','Si'),('JHJG13','Peugeot','Partner',2023,24600,'2024-10-14','20.478.452-7','Si'),('JKLD23','Toyota','Hilux',2023,5000,'2024-11-15','20.362.114-0','Si'),('LKJD34','Chevrolet','D-Max',2022,40000,'2024-10-11','20.362.114-0','Si'),('LKPO83','Ford','EcoSport',2021,35000,'2024-09-22','20.478.452-7','Si'),('LOPM76','Chevrolet','Sail',2023,15000,'2024-12-18','20.362.114-0','Si'),('MJHG89','Ford','Ranger',2021,35000,'2024-10-12','19.478.524-4','Si'),('NMKL98','Jeep','Cherokee',2021,42000,'2024-11-12','7.528.684-5','no'),('OPTR91','Renault','Kangoo',2022,22000,'2024-12-01','7.528.684-5','no'),('PLKM29','Volkswagen','Amarok',2023,18000,'2024-10-29','20.362.114-0','no'),('PQOA45','Nissan','Navara',2020,60000,'2024-09-30','20.478.452-7','no'),('PSPC14','Citroen','Berlingo',2021,34000,'2024-11-21','19.478.524-4','no'),('QWAS11','Honda','CR-V',2023,9000,'2024-12-05','20.478.452-7','Si'),('QWER12','Kia','Sorento',2023,10000,'2024-11-18','20.362.114-0','Si'),('REDF22','Subaru','Forester',2022,30000,'2024-10-17','20.362.114-0','Si'),('TREW54','Toyota','Rav4',2020,47000,'2024-09-28','7.528.684-5','Si'),('VBNM54','Hyundai','Santa Fe',2021,38000,'2024-10-05','20.478.452-7','Si'),('YTGB67','Peugeot','Partner',2023,25000,'2024-09-15','20.362.114-0','Si'),('YUIO91','Hyundai','Tucson',2021,33000,'2024-10-10','20.478.452-7','Si'),('ZXCV87','Mazda','CX-5',2020,55000,'2024-08-15','19.478.524-4','Si'),('ZXTY76','Mitsubishi','L200',2019,80000,'2024-08-25','10.588.245-4','Si');
/*!40000 ALTER TABLE `vehiculo` ENABLE KEYS */;
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
