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
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `rut` varchar(15) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `Usuario` varchar(20) DEFAULT NULL,
  `clave` varchar(64) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `Id_Rol` int(11) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `supervisor` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`rut`),
  KEY `fk_usuario_roles` (`Id_Rol`),
  KEY `fk_usuario_cargo` (`id_cargo`),
  CONSTRAINT `fk_usuario_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_usuario_roles` FOREIGN KEY (`Id_Rol`) REFERENCES `roles` (`Id_Rol`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES ('10.588.245-4','Marcelo Bielsa Sculini','marcelo.bielsa','0d9d09e157f7c29a43c02e57f081915d6fe2f10da1710672086f8ad73bb95cb2','2024-09-16',NULL,3,'19.478.524-4'),('14.587.522-3','Albertina Lara Bustamante',NULL,NULL,'2024-09-17',NULL,2,NULL),('14.754.145-7','Juan Roa Lucra',NULL,NULL,'2024-09-10',NULL,3,'19.478.524-4'),('15.234.685-5','Miguel Roa Iturra',NULL,NULL,'2024-09-11',NULL,3,'14.587.522-3'),('19.478.524-4','Joaquin Flores Rodriguez','jo.flores','0d9d09e157f7c29a43c02e57f081915d6fe2f10da1710672086f8ad73bb95cb2','2024-09-13',2,2,NULL),('20.362.114-0','Michael Nuñez Velozo','mic.nunez','71a026cd7933debf0230c529bf5d0caa3314440d160ea99f2428d3c310ec68c1','2024-09-13',1,5,NULL),('20.478.452-7','Matias Quiñones Varela','ma.quinones','0d9d09e157f7c29a43c02e57f081915d6fe2f10da1710672086f8ad73bb95cb2','2024-09-13',3,2,NULL),('7.528.684-5','Juan Alberto Lara Silva','juan.lara','0d9d09e157f7c29a43c02e57f081915d6fe2f10da1710672086f8ad73bb95cb2','2024-09-26',3,3,'20.478.452-7');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
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
