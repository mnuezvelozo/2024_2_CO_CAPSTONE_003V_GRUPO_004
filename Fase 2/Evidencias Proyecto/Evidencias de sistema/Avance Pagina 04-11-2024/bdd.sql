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
-- Table structure for table `auditoria`
--

DROP TABLE IF EXISTS `auditoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auditoria` (
  `id_auditoria` int(11) NOT NULL AUTO_INCREMENT,
  `patente` varchar(8) NOT NULL,
  `rut_responsable` varchar(15) NOT NULL,
  `fecha` date NOT NULL,
  `danos` varchar(10) DEFAULT NULL,
  `documentos` varchar(10) DEFAULT NULL,
  `funcionamiento` varchar(10) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` enum('Pendiente','Completada') DEFAULT 'Pendiente',
  PRIMARY KEY (`id_auditoria`),
  KEY `patente` (`patente`),
  KEY `rut_responsable` (`rut_responsable`),
  CONSTRAINT `auditoria_ibfk_1` FOREIGN KEY (`patente`) REFERENCES `vehiculo` (`patente`),
  CONSTRAINT `auditoria_ibfk_2` FOREIGN KEY (`rut_responsable`) REFERENCES `usuario` (`rut`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auditoria`
--

LOCK TABLES `auditoria` WRITE;
/*!40000 ALTER TABLE `auditoria` DISABLE KEYS */;
INSERT INTO `auditoria` VALUES (1,'JHJG13','11.111.111-1','2024-11-04','No','Sí','No','','Completada'),(2,'JHJG13','19.157.302-1','2024-11-04','Sí','Sí','Sí',NULL,'Pendiente'),(3,'HYJB29','11.111.111-1','2024-11-04','Sí','Sí','Sí',NULL,'Pendiente'),(4,'YTGB67','11.111.111-1','2024-11-04',NULL,NULL,NULL,NULL,'Pendiente'),(5,'CWKV75','20.478.452-7','2024-11-04',NULL,NULL,NULL,NULL,'Pendiente');
/*!40000 ALTER TABLE `auditoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargo`
--

DROP TABLE IF EXISTS `cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_cargo` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_cargo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargo`
--

LOCK TABLES `cargo` WRITE;
/*!40000 ALTER TABLE `cargo` DISABLE KEYS */;
INSERT INTO `cargo` VALUES (1,'Jefe Operacional'),(2,'Jefe Modulo'),(3,'Tecnico'),(4,'Analista'),(5,'Jefe de TI');
/*!40000 ALTER TABLE `cargo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chofer_historial`
--

DROP TABLE IF EXISTS `chofer_historial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chofer_historial` (
  `id_historial` int(11) NOT NULL AUTO_INCREMENT,
  `patente` varchar(8) DEFAULT NULL,
  `rut_chofer` varchar(15) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `kilometraje_inicio` int(11) DEFAULT NULL,
  `fecha_termino` date DEFAULT NULL,
  `kilometraje_termino` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_historial`),
  KEY `patente` (`patente`),
  KEY `rut_chofer` (`rut_chofer`),
  CONSTRAINT `chofer_historial_ibfk_1` FOREIGN KEY (`patente`) REFERENCES `vehiculo` (`patente`),
  CONSTRAINT `chofer_historial_ibfk_2` FOREIGN KEY (`rut_chofer`) REFERENCES `usuario` (`rut`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chofer_historial`
--

LOCK TABLES `chofer_historial` WRITE;
/*!40000 ALTER TABLE `chofer_historial` DISABLE KEYS */;
INSERT INTO `chofer_historial` VALUES (1,'PSPC14','19.157.302-1','2024-10-27',40000,'2024-10-27',45000),(2,'PSPC14','19.478.524-4','2024-10-27',45000,'2024-10-28',44997),(3,'YTGB67','20.478.452-7','2024-10-28',27000,'2024-10-28',27000),(4,'YTGB67','20.362.114-0','2024-10-28',27000,'2024-11-04',28500),(5,'PSPC14','20.362.114-0','2024-10-28',44997,NULL,NULL),(6,'CWKV75','7.528.684-5','2024-10-28',15100,'2024-10-28',27500),(7,'CWKV75','20.478.452-7','2024-10-28',27500,'2024-10-28',27500),(8,'HYJB29','15.234.685-5','2024-10-28',7000,'2024-11-04',8000),(9,'HGWZ58','20.362.114-0','2024-10-28',20000,NULL,NULL),(10,'CWKV75','19.157.302-1','2024-10-28',27500,'2024-11-04',27500),(11,'FKXV38','20.478.452-7','2024-10-28',17500,NULL,NULL),(12,'JHJG13','11.111.111-1','2024-11-04',28600,'2024-11-04',28600),(13,'JHJG13','19.157.302-1','2024-11-04',28600,NULL,NULL),(14,'HYJB29','11.111.111-1','2024-11-04',8000,NULL,NULL),(15,'YTGB67','11.111.111-1','2024-11-04',28500,NULL,NULL),(16,'CWKV75','20.478.452-7','2024-11-04',27500,NULL,NULL);
/*!40000 ALTER TABLE `chofer_historial` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `km_historial`
--

LOCK TABLES `km_historial` WRITE;
/*!40000 ALTER TABLE `km_historial` DISABLE KEYS */;
INSERT INTO `km_historial` VALUES (14,'JGYP14',17900,'2024-09-23','Michael Nuñez Velozo'),(15,'JGYP14',17950,'2024-09-23','Joaquin Flores Rodriguez'),(16,'JHJG13',24600,'2024-09-23','Michael Nuñez Velozo'),(17,'PSPC14',10501,'2024-09-23','Michael Nuñez Velozo'),(18,'PSPC14',10505,'2024-09-23','Michael Nuñez Velozo'),(19,'PSPC14',25000,'2024-09-24','Michael Nuñez Velozo'),(20,'PSPC14',34000,'2024-09-24','Michael Nuñez Velozo'),(21,'PSPC14',36000,'2024-10-01','Michael Núñez Velozo'),(22,'PSPC14',37000,'2024-10-10','Michael Núñez Velozo'),(23,'PSPC14',38000,'2024-10-15','Joaquin Flores Rodriguez'),(24,'PSPC14',39000,'2024-10-20','Michael Núñez Velozo'),(25,'PSPC14',40000,'2024-10-25','Michael Núñez Velozo'),(26,'HLYH97',25000,'2024-09-20','Michael Núñez Velozo'),(27,'HLYH97',26000,'2024-09-25','Michael Núñez Velozo'),(28,'HLYH97',27000,'2024-10-01','Joaquin Flores Rodriguez'),(29,'HLYH97',28000,'2024-10-05','Michael Núñez Velozo'),(30,'HLYH97',29000,'2024-10-10','Michael Núñez Velozo'),(31,'HLYH97',30000,'2024-10-15','Michael Núñez Velozo'),(32,'HLYH97',31000,'2024-10-20','Michael Núñez Velozo'),(38,'JGYP14',18500,'2024-09-26','Joaquin Flores Rodriguez'),(39,'JGYP14',19000,'2024-09-30','Michael Núñez Velozo'),(40,'JGYP14',19500,'2024-10-05','Michael Núñez Velozo'),(41,'JGYP14',20000,'2024-10-10','Michael Núñez Velozo'),(42,'JGYP14',20500,'2024-10-15','Joaquin Flores Rodriguez'),(43,'JHJG13',25000,'2024-09-23','Michael Núñez Velozo'),(44,'JHJG13',26000,'2024-09-30','Michael Núñez Velozo'),(45,'JHJG13',27000,'2024-10-05','Joaquin Flores Rodriguez'),(46,'JHJG13',28000,'2024-10-10','Michael Núñez Velozo'),(47,'JHJG13',28500,'2024-10-15','Michael Núñez Velozo'),(48,'CWKV75',18000,'2024-09-15','Michael Núñez Velozo'),(49,'CWKV75',19000,'2024-09-22','Michael Núñez Velozo'),(50,'CWKV75',20000,'2024-09-28','Joaquin Flores Rodriguez'),(51,'CWKV75',21000,'2024-10-01','Michael Núñez Velozo'),(52,'CWKV75',22000,'2024-10-10','Michael Núñez Velozo'),(56,'HGWZ58',20000,'2024-10-02','Michael Nuñez Velozo'),(57,'FKXV38',14000,'2024-10-27','Michael Nuñez Velozo'),(58,'FKXV38',14500,'2024-10-27','Michael Nuñez Velozo'),(61,'FKXV38',16500,'2024-10-27','Michael Nuñez Velozo'),(68,'PSPC14',37000,'2024-10-27','Joaquin Flores Rodriguez'),(72,'PSPC14',37500,'2024-10-27','Joaquin Flores Rodriguez'),(74,'PSPC14',40000,'2024-10-27','Joaquin Flores Rodriguez'),(76,'PSPC14',45000,'2024-10-27','Joaquin Flores Rodriguez'),(77,'PSPC14',44997,'2024-10-28','Michael Nuñez Velozo'),(80,'YTGB67',27000,'2024-10-28','Michael Nuñez Velozo'),(82,'YTGB67',28000,'2024-10-28','Miguel Roa Iturra'),(83,'PSPC14',44997,'2024-10-28','Miguel Roa Iturra'),(88,'CWKV75',23000,'2024-10-28','Michael Nuñez Velozo'),(89,'YTGB67',28100,'2024-10-28','Michael Nuñez Velozo'),(90,'PSPC14',45077,'2024-10-28','Michael Nuñez Velozo'),(91,'FKXV38',17500,'2024-10-28','Michael Nuñez Velozo'),(92,'CWKV75',24000,'2024-10-28','Michael Nuñez Velozo'),(93,'CWKV75',25000,'2024-10-28','Michael Nuñez Velozo'),(94,'HLYH97',10000,'2024-10-28','Michael Nuñez Velozo'),(95,'HLYH97',15000,'2024-10-28','Michael Nuñez Velozo'),(96,'PSPC14',47077,'2024-10-28','Michael Nuñez Velozo'),(98,'CWKV75',27500,'2024-10-28','Michael Nuñez Velozo'),(99,'PSPC14',48077,'2024-10-28','Michael Nuñez Velozo'),(100,'CWKV75',27500,'2024-10-28','Joaquin Flores Rodriguez'),(101,'HYJB29',7000,'2024-10-28','Michael Nuñez Velozo'),(102,'JHJG13',28600,'2024-10-28','Miguel Roa Iturra'),(103,'HGWZ58',20000,'2024-10-28','Michael Nuñez Velozo'),(104,'CWKV75',27500,'2024-10-28','Michael Nuñez Velozo'),(105,'FKXV38',17500,'2024-10-28','Michael Nuñez Velozo'),(106,'HYJB29',8000,'2024-10-29','Michael Nuñez Velozo'),(107,'HLYH97',16000,'2024-10-29','Michael Nuñez Velozo'),(108,'JHJG13',28600,'2024-11-04','Joaquin Flores Rodriguez'),(109,'JHJG13',28600,'2024-11-04','Michael Nuñez Velozo'),(110,'HYJB29',8000,'2024-11-04','Michael Nuñez Velozo'),(111,'YTGB67',28500,'2024-11-04','Michael Nuñez Velozo'),(112,'CWKV75',27500,'2024-11-04','Michael Nuñez Velozo');
/*!40000 ALTER TABLE `km_historial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `Id_Rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Id_Rol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin'),(2,'Supervisor'),(3,'Chofer');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

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
  `costo` decimal(10,2) DEFAULT 0.00,
  PRIMARY KEY (`id_siniestro`),
  KEY `fk_siniestro_vehiculo_new` (`patente`),
  KEY `fk_siniestro_tipo_siniestro_new` (`id_tipo_siniestro`),
  CONSTRAINT `fk_siniestro_tipo_siniestro_new` FOREIGN KEY (`id_tipo_siniestro`) REFERENCES `tipo_siniestro` (`id_tipo_siniestro`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_siniestro_vehiculo_new` FOREIGN KEY (`patente`) REFERENCES `vehiculo` (`patente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siniestro`
--

LOCK TABLES `siniestro` WRITE;
/*!40000 ALTER TABLE `siniestro` DISABLE KEYS */;
INSERT INTO `siniestro` VALUES (1,'CWKV75','2024-10-20',1,'Daño en puerta.',40000.00),(2,'HLYH97','2024-10-20',3,'Daño en retrovisor.',50000.00),(3,'HYJB29','2024-09-10',3,'Daño parachoques frontal.',30000.00),(4,'FKXV38','2024-10-27',3,'Daños en puerta delantera derecha',20000.00),(6,'PSPC14','2024-10-28',1,'Puerta Lateral con abolladura',100000.00),(7,'PSPC14','2024-10-28',1,'Daño colateral minimo parachoque suelto',12000.00),(8,'CWKV75','2024-10-28',2,'Puerta trasera caída ',0.00);
/*!40000 ALTER TABLE `siniestro` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud_combustible`
--

LOCK TABLES `solicitud_combustible` WRITE;
/*!40000 ALTER TABLE `solicitud_combustible` DISABLE KEYS */;
INSERT INTO `solicitud_combustible` VALUES (13,'JHJG13','20.478.452-7','2024-09-30',24600,25000.00,'Denegada','20.362.114-0'),(15,'JHJG13','20.478.452-7','2024-09-30',47000,35000.00,'Aprobada','20.362.114-0'),(16,'JGYP14','20.362.114-0','2024-09-30',17944,5000.00,'Denegada','20.362.114-0'),(17,'HYJB29','20.362.114-0','2024-09-30',4999,20000.00,'Denegada','20.362.114-0'),(18,'HYJB29','20.362.114-0','2024-09-30',4997,50000.00,'Denegada','20.362.114-0'),(19,'HYJB29','20.362.114-0','2024-09-30',20,50000.00,'Denegada','20.362.114-0'),(20,'HLYH97','20.362.114-0','2024-09-30',8701,25000.00,'Denegada','20.362.114-0'),(21,'CWKV75','20.362.114-0','2024-10-02',15000,25000.00,'Denegada','20.362.114-0'),(22,'JHJG13','20.478.452-7','2024-10-02',24800,15000.00,'Denegada','15.234.685-5'),(23,'HGWZ58','10.588.245-4','2024-10-02',20000,30000.00,'Denegada','19.478.524-4'),(24,'HGWZ58','10.588.245-4','2024-10-02',20300,25000.00,'Denegada','19.478.524-4'),(25,'JHJG13','20.478.452-7','2024-10-02',24600,82000.00,'Denegada','15.234.685-5'),(26,'HGWZ58','10.588.245-4','2024-10-02',20000,25000.00,'Aprobada','19.478.524-4'),(27,'PSPC14','19.478.524-4','2024-10-02',34000,52000.00,'Aprobada','20.362.114-0'),(28,'HGWZ58','10.588.245-4','2024-10-02',20000,52000.00,'Denegada','19.478.524-4'),(29,'PSPC14','19.478.524-4','2024-10-06',34000,50000.00,'Denegada','20.362.114-0'),(30,'FKXV38','20.362.114-0','2024-10-27',14000,20000.00,'Aprobada','20.362.114-0'),(31,'FKXV38','20.362.114-0','2024-10-27',15000,30000.00,'Aprobada','20.362.114-0'),(32,'FKXV38','20.362.114-0','2024-10-27',15500,50000.00,'Aprobada','20.362.114-0'),(33,'FKXV38','20.362.114-0','2024-10-27',16000,20000.00,'Aprobada','20.362.114-0'),(34,'PSPC14','19.478.524-4','2024-10-27',34500,50000.00,'Aprobada','19.157.302-1'),(35,'PSPC14','19.478.524-4','2024-10-27',35000,30000.00,'Aprobada','19.157.302-1'),(36,'PSPC14','19.478.524-4','2024-10-27',35500,15000.00,'Denegada','19.157.302-1'),(37,'PSPC14','19.478.524-4','2024-10-27',36000,15000.00,'Aprobada','19.157.302-1'),(38,'PSPC14','19.478.524-4','2024-10-27',36500,40000.00,'Aprobada','19.157.302-1'),(39,'PSPC14','19.478.524-4','2024-10-27',37000,50000.00,'Aprobada','19.157.302-1'),(40,'PSPC14','19.157.302-1','2024-10-27',37500,30000.00,'Aprobada','20.362.114-0'),(41,'CWKV75','20.362.114-0','2024-10-27',15100,10000.00,'Aprobada','20.362.114-0'),(42,'PSPC14','19.478.524-4','2024-10-27',40000,50000.00,'Aprobada','19.157.302-1'),(43,'PSPC14','19.157.302-1','2024-10-27',45000,30000.00,'Aprobada','20.362.114-0'),(44,'JHJG13','20.478.452-7','2024-10-28',26600,50000.00,'Aprobada','20.362.114-0'),(45,'JHJG13','20.478.452-7','2024-10-28',27600,20000.00,'Aprobada','20.362.114-0'),(46,'CWKV75','7.528.684-5','2024-10-28',15500,15000.00,'Aprobada','20.362.114-0'),(47,'PSPC14','20.362.114-0','2024-10-28',45077,20000.00,'Aprobada','20.362.114-0'),(48,'FKXV38','20.362.114-0','2024-10-28',17500,15000.00,'Aprobada','20.362.114-0'),(49,'JGYP14','20.362.114-0','2024-10-28',18950,10000.00,'Denegada','20.362.114-0'),(50,'JGYP14','20.362.114-0','2024-10-28',19950,10000.00,'Denegada','20.362.114-0'),(51,'JGYP14','20.362.114-0','2024-10-28',20950,10000.00,'Denegada','20.362.114-0'),(52,'JGYP14','20.362.114-0','2024-10-28',21950,10000.00,'Denegada','20.362.114-0'),(53,'CWKV75','7.528.684-5','2024-10-28',24000,10000.00,'Aprobada','20.362.114-0'),(54,'CWKV75','7.528.684-5','2024-10-28',25000,20000.00,'Aprobada','20.362.114-0'),(55,'YTGB67','20.362.114-0','2024-10-28',28500,15000.00,'Denegada','20.362.114-0'),(56,'HLYH97','20.362.114-0','2024-10-28',10000,10000.00,'Aprobada','20.362.114-0'),(57,'CWKV75','7.528.684-5','2024-10-28',25500,15000.00,'Denegada','20.362.114-0'),(59,'JGYP14','20.362.114-0','2024-10-28',22950,10000.00,'Denegada','20.362.114-0'),(60,'HLYH97','20.362.114-0','2024-10-28',15000,15000.00,'Aprobada','20.362.114-0'),(61,'HYJB29','20.362.114-0','2024-10-28',7000,5000.00,'Denegada','20.362.114-0'),(62,'JGYP14','20.362.114-0','2024-10-28',30000,15000.00,'Denegada','20.362.114-0'),(63,'PSPC14','20.362.114-0','2024-10-28',47077,10000.00,'Aprobada','20.362.114-0'),(64,'CWKV75','7.528.684-5','2024-10-28',26500,10000.00,'Denegada','20.362.114-0'),(65,'CWKV75','7.528.684-5','2024-10-28',26500,5000.00,'Denegada','20.362.114-0'),(66,'CWKV75','7.528.684-5','2024-10-28',26500,5000.00,'Denegada','20.362.114-0'),(67,'CWKV75','7.528.684-5','2024-10-28',26500,12000.00,'Aprobada','20.362.114-0'),(68,'CWKV75','7.528.684-5','2024-10-28',27500,12000.00,'Denegada','20.362.114-0'),(69,'CWKV75','7.528.684-5','2024-10-28',27500,10000.00,'Aprobada','20.362.114-0'),(70,'PSPC14','20.362.114-0','2024-10-28',50077,50000.00,'Denegada','20.362.114-0'),(71,'PSPC14','20.362.114-0','2024-10-28',48077,10000.00,'Aprobada','20.362.114-0'),(72,'JHJG13','20.478.452-7','2024-10-28',28600,12000.00,'Aprobada','15.234.685-5'),(73,'HYJB29','15.234.685-5','2024-10-28',7000,2000.00,'Denegada','20.362.114-0'),(74,'HYJB29','15.234.685-5','2024-10-29',8000,20000.00,'Aprobada','20.362.114-0'),(75,'HLYH97','20.362.114-0','2024-10-29',16000,10000.00,'Aprobada','20.362.114-0'),(76,'CWKV75','19.157.302-1','2024-10-29',28500,15000.00,'Pendiente',NULL);
/*!40000 ALTER TABLE `solicitud_combustible` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_siniestro`
--

DROP TABLE IF EXISTS `tipo_siniestro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_siniestro` (
  `id_tipo_siniestro` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_siniestro`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_siniestro`
--

LOCK TABLES `tipo_siniestro` WRITE;
/*!40000 ALTER TABLE `tipo_siniestro` DISABLE KEYS */;
INSERT INTO `tipo_siniestro` VALUES (1,'Reparado'),(2,'Pendiente'),(3,'En Reparación'),(4,'Perdida Total');
/*!40000 ALTER TABLE `tipo_siniestro` ENABLE KEYS */;
UNLOCK TABLES;

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
  `fecha_termino` date DEFAULT NULL,
  `Id_Rol` int(11) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `supervisor` varchar(15) DEFAULT NULL,
  `activo` varchar(5) DEFAULT NULL,
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
INSERT INTO `usuario` VALUES ('10.588.245-4','Marcelo Bielsa Sculini',NULL,NULL,'2024-09-16','2024-10-28',NULL,NULL,NULL,'No'),('11.111.111-1','Joaquin Flores Rodriguez','joa.flores','dd2743da95456f614f9e40bbf34bdc972490082928bff87b5a7e5ac8224e6eab','2024-11-04',NULL,3,3,'19.157.302-1','Si'),('14.587.522-3','Albertina Lara Bustamante',NULL,NULL,'2024-09-17','2024-10-28',NULL,NULL,NULL,'No'),('14.754.145-7','Juan Roa Lucra',NULL,NULL,'2024-09-10',NULL,NULL,3,NULL,'Si'),('15.234.685-5','Miguel Roa Iturra','miguel.roa','0d9d09e157f7c29a43c02e57f081915d6fe2f10da1710672086f8ad73bb95cb2','2024-09-11',NULL,2,3,'20.362.114-0','Si'),('19.157.302-1','Joaquin Flores Rodriguez','jo.flores','71a026cd7933debf0230c529bf5d0caa3314440d160ea99f2428d3c310ec68c1','2024-10-20',NULL,2,4,NULL,'Si'),('19.478.524-4','Joaquin Werner Mori',NULL,NULL,'2024-09-13','2024-10-28',NULL,NULL,NULL,'No'),('20.362.114-0','Michael Nuñez Velozo','mic.nunez','71a026cd7933debf0230c529bf5d0caa3314440d160ea99f2428d3c310ec68c1','2024-09-13',NULL,1,5,NULL,'Si'),('20.478.452-7','Matias Quiñones Varela','ma.quinones','0d9d09e157f7c29a43c02e57f081915d6fe2f10da1710672086f8ad73bb95cb2','2024-09-13',NULL,3,2,'19.157.302-1','Si'),('7.528.684-5','Juan Alberto Lara Silva','juan.lara','0d9d09e157f7c29a43c02e57f081915d6fe2f10da1710672086f8ad73bb95cb2','2024-09-26',NULL,3,3,'19.157.302-1','Si'),('7.580.035-5','Tomas Monsalves Roa','to.monsalves','0d9d09e157f7c29a43c02e57f081915d6fe2f10da1710672086f8ad73bb95cb2','2024-10-21',NULL,3,3,'19.157.302-1','Si');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `vehiculo` VALUES ('BKJW98','Chevrolet','Aveo',2009,157000,'2024-11-24',NULL,'no'),('CWKV75','Citroen','Berlingo',2022,27500,'2024-11-21','20.478.452-7','Si'),('FKXV38','Citroen','Berlingo',2022,17500,'2024-11-21','20.478.452-7','Si'),('HGWZ58','Citroen','Berlingo',2022,20000,'2024-11-21','20.362.114-0','Si'),('HLYH97','Peugeot','Partner',2023,16000,'2024-10-18','20.362.114-0','Si'),('HYJB29','Peugeot','Partner',2023,8000,'2024-10-18','11.111.111-1','Si'),('JGYP14','Peugeot','Partner',2023,22950,'2024-10-18','20.362.114-0','Si'),('JHJG13','Peugeot','Partner',2023,28600,'2024-10-14','19.157.302-1','Si'),('PSPC14','Citroen','Berlingo',2021,48077,'2024-11-21','20.362.114-0','Si'),('YTGB67','Peugeot','Partner',2023,28500,'2024-09-15','11.111.111-1','Si');
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

-- Dump completed on 2024-11-04 17:05:52
