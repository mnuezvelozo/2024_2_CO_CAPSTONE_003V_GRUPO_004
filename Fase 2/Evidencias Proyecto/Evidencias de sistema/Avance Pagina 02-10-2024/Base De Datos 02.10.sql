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
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `km_historial`
--

LOCK TABLES `km_historial` WRITE;
/*!40000 ALTER TABLE `km_historial` DISABLE KEYS */;
INSERT INTO `km_historial` VALUES (1,'PSPC14',10100,'2024-09-23','Nombre del Usuario'),(2,'PSPC14',10200,'2024-09-23','Nombre del Usuario'),(3,'JHJG13',24500,'2024-09-23','Nombre del Usuario'),(4,'JGYP14',17000,'2024-09-23',NULL),(5,'JGYP14',17500,'2024-09-23',NULL),(6,'JGYP14',17600,'2024-09-23',NULL),(7,'PSPC14',10400,'2024-09-23',NULL),(8,'PSPC14',10400,'2024-09-23',NULL),(9,'PSPC14',10400,'2024-09-23',NULL),(10,'PSPC14',10400,'2024-09-23',NULL),(11,'PSPC14',10500,'2024-09-23',NULL),(12,'JHJG13',24500,'2024-09-23','Desconocido'),(13,'JGYP14',17700,'2024-09-23','Desconocido'),(14,'JGYP14',17900,'2024-09-23','Michael Nuñez Velozo'),(15,'JGYP14',17950,'2024-09-23','Joaquin Flores Rodriguez'),(16,'JHJG13',24600,'2024-09-23','Michael Nuñez Velozo'),(17,'PSPC14',10501,'2024-09-23','Michael Nuñez Velozo'),(18,'PSPC14',10505,'2024-09-23','Michael Nuñez Velozo'),(19,'PSPC14',25000,'2024-09-24','Michael Nuñez Velozo'),(20,'PSPC14',34000,'2024-09-24','Michael Nuñez Velozo'),(21,'PSPC14',36000,'2024-10-01','Michael Núñez Velozo'),(22,'PSPC14',37000,'2024-10-10','Michael Núñez Velozo'),(23,'PSPC14',38000,'2024-10-15','Joaquin Flores Rodriguez'),(24,'PSPC14',39000,'2024-10-20','Michael Núñez Velozo'),(25,'PSPC14',40000,'2024-10-25','Michael Núñez Velozo'),(26,'HLYH97',25000,'2024-09-20','Michael Núñez Velozo'),(27,'HLYH97',26000,'2024-09-25','Michael Núñez Velozo'),(28,'HLYH97',27000,'2024-10-01','Joaquin Flores Rodriguez'),(29,'HLYH97',28000,'2024-10-05','Michael Núñez Velozo'),(30,'HLYH97',29000,'2024-10-10','Michael Núñez Velozo'),(31,'HLYH97',30000,'2024-10-15','Michael Núñez Velozo'),(32,'HLYH97',31000,'2024-10-20','Michael Núñez Velozo'),(38,'JGYP14',18500,'2024-09-26','Joaquin Flores Rodriguez'),(39,'JGYP14',19000,'2024-09-30','Michael Núñez Velozo'),(40,'JGYP14',19500,'2024-10-05','Michael Núñez Velozo'),(41,'JGYP14',20000,'2024-10-10','Michael Núñez Velozo'),(42,'JGYP14',20500,'2024-10-15','Joaquin Flores Rodriguez'),(43,'JHJG13',25000,'2024-09-23','Michael Núñez Velozo'),(44,'JHJG13',26000,'2024-09-30','Michael Núñez Velozo'),(45,'JHJG13',27000,'2024-10-05','Joaquin Flores Rodriguez'),(46,'JHJG13',28000,'2024-10-10','Michael Núñez Velozo'),(47,'JHJG13',29000,'2024-10-15','Michael Núñez Velozo'),(48,'CWKV75',18000,'2024-09-15','Michael Núñez Velozo'),(49,'CWKV75',19000,'2024-09-22','Michael Núñez Velozo'),(50,'CWKV75',20000,'2024-09-28','Joaquin Flores Rodriguez'),(51,'CWKV75',21000,'2024-10-01','Michael Núñez Velozo'),(52,'CWKV75',22000,'2024-10-10','Michael Núñez Velozo'),(56,'HGWZ58',20000,'2024-10-02','Michael Nuñez Velozo');
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
  `rut` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_siniestro`),
  KEY `fk_siniestro_vehiculo_new` (`patente`),
  KEY `fk_siniestro_tipo_siniestro_new` (`id_tipo_siniestro`),
  KEY `fk_siniestro_usuario_new` (`rut`),
  CONSTRAINT `fk_siniestro_tipo_siniestro_new` FOREIGN KEY (`id_tipo_siniestro`) REFERENCES `tipo_siniestro` (`id_tipo_siniestro`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_siniestro_usuario_new` FOREIGN KEY (`rut`) REFERENCES `usuario` (`rut`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_siniestro_vehiculo_new` FOREIGN KEY (`patente`) REFERENCES `vehiculo` (`patente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siniestro`
--

LOCK TABLES `siniestro` WRITE;
/*!40000 ALTER TABLE `siniestro` DISABLE KEYS */;
INSERT INTO `siniestro` VALUES (1,'CWKV75','2024-09-24',2,'daño colateral producido por un accidente multiple','19.478.524-4'),(2,'CWKV75','2024-09-24',1,'Se reparo!','19.478.524-4'),(3,'CWKV75','2024-09-24',3,'Murio gg','19.478.524-4'),(4,'CWKV75','2024-09-24',2,'Seguimos esperanding','19.478.524-4'),(5,'PSPC14','2024-09-18',2,'Daño producido por un choque en el espejo lateral izquierdo','20.362.114-0'),(6,'PSPC14','2024-09-24',1,'Vehículo reparado desde taller , quedando en buenas condiciones ','20.362.114-0'),(7,'HLYH97','2024-09-20',2,'Se murio el motor gg nt wp','20.478.452-7'),(8,'PSPC14','2024-09-13',4,'Murio','20.478.452-7'),(9,'PSPC14','2022-02-12',1,'se aerreglooooo','20.478.452-7'),(10,'PSPC14','2024-09-19',3,'Murio dnb gg','7.528.684-5'),(11,'PSPC14','2024-09-13',4,'ahora si gg','20.478.452-7'),(12,'PSPC14','2024-10-04',1,'no me pregunten como se arreglo ','20.478.452-7'),(13,'HLYH97','2024-05-04',2,'Prueba','20.478.452-7'),(14,'HGWZ58','2024-01-04',2,'Prueba','20.478.452-7'),(15,'HGWZ58','2024-02-04',2,'Prueba','20.478.452-7'),(16,'FKXV38','2024-03-04',2,'Prueba','20.478.452-7'),(17,'FKXV38','2024-04-04',2,'Prueba','7.528.684-5'),(18,'FKXV38','2024-06-04',1,'Prueba','7.528.684-5'),(19,'CWKV75','2024-07-04',2,'Prueba','7.528.684-5'),(20,'JGYP14','2024-08-04',1,'Prueba','7.528.684-5'),(21,'JGYP14','2024-10-04',2,'Prueba','7.528.684-5'),(22,'JGYP14','2024-11-04',2,'Prueba','7.528.684-5'),(23,'JGYP14','2024-12-04',1,'Prueba','7.528.684-5'),(52,'CWKV75','2024-01-05',2,'Leve daño en puerta trasera','19.478.524-4'),(53,'PSPC14','2024-01-11',1,'Reparación completada, motor funcionando','20.362.114-0'),(54,'HLYH97','2024-01-15',3,'Fallo en sistema de frenos','20.478.452-7'),(55,'CWKV75','2024-01-19',4,'Accidente severo en autopista','7.528.684-5'),(56,'PSPC14','2024-01-22',1,'Daño leve en capó','20.362.114-0'),(57,'CWKV75','2024-01-26',3,'Problemas con batería, vehículo detenido','19.478.524-4'),(58,'HLYH97','2024-01-29',2,'Reparación de faro delantero','20.478.452-7'),(59,'CWKV75','2024-02-03',2,'Problema con el embrague','19.478.524-4'),(60,'PSPC14','2024-02-08',1,'Revisión de motor, ajuste de piezas','20.362.114-0'),(61,'HLYH97','2024-02-12',3,'Accidente menor, rasguños en la carrocería','20.478.452-7'),(62,'CWKV75','2024-02-15',4,'Chasis doblado por impacto trasero','7.528.684-5'),(63,'PSPC14','2024-02-18',1,'Ajuste de suspensión delantera','20.362.114-0'),(64,'CWKV75','2024-02-22',3,'Problema eléctrico, luces no funcionan','19.478.524-4'),(65,'HLYH97','2024-02-25',2,'Reparación de espejos laterales','20.478.452-7'),(66,'PSPC14','2024-02-27',1,'Mantenimiento general del vehículo','20.362.114-0'),(67,'CWKV75','2024-02-28',3,'Daño por lluvia, techo mojado','19.478.524-4'),(68,'CWKV75','2024-03-01',2,'Choque en estacionamiento','19.478.524-4'),(69,'PSPC14','2024-03-07',1,'Golpe en parte trasera, luces rotas','20.362.114-0'),(70,'HLYH97','2024-03-11',3,'Problema con frenos, vehículo detenido','20.478.452-7'),(71,'CWKV75','2024-03-14',4,'Accidente de gravedad, daños severos','7.528.684-5'),(72,'PSPC14','2024-03-18',1,'Reparación de tren delantero','20.362.114-0'),(73,'CWKV75','2024-03-22',3,'Revisión de batería y cambio','19.478.524-4'),(74,'HLYH97','2024-03-28',2,'Daños en retrovisores por impacto','20.478.452-7'),(75,'CWKV75','2024-04-03',2,'Problema con la dirección asistida','19.478.524-4'),(76,'PSPC14','2024-04-06',1,'Revisión de frenos y ajuste de pastillas','20.362.114-0'),(77,'HLYH97','2024-04-10',3,'Golpe leve en parachoques trasero','20.478.452-7'),(78,'CWKV75','2024-04-13',4,'Fallo en sistema de encendido, motor no arranca','7.528.684-5'),(79,'PSPC14','2024-04-16',1,'Rotura del parabrisas por impacto de piedra','20.362.114-0'),(80,'CWKV75','2024-04-19',3,'Daño en faro delantero, necesita reemplazo','19.478.524-4'),(81,'HLYH97','2024-04-23',2,'Problemas con la caja de cambios','20.478.452-7'),(82,'PSPC14','2024-04-28',1,'Revisión general del vehículo','20.362.114-0'),(83,'CWKV75','2024-05-02',2,'Fallo en el sistema de frenos, requiere cambio','19.478.524-4'),(84,'PSPC14','2024-05-08',1,'Daños menores en la carrocería','20.362.114-0'),(85,'HLYH97','2024-05-12',3,'Accidente leve, pintura dañada','20.478.452-7'),(86,'CWKV75','2024-05-15',4,'Choque contra un poste, capó doblado','7.528.684-5'),(87,'PSPC14','2024-05-18',1,'Vehículo en mantenimiento preventivo','20.362.114-0'),(88,'CWKV75','2024-05-21',3,'Rotura del retrovisor, necesita cambio','19.478.524-4'),(89,'HLYH97','2024-05-26',2,'Problema con el radiador, sobrecalentamiento','20.478.452-7'),(90,'PSPC14','2024-05-30',1,'Revisión y ajuste del motor','20.362.114-0'),(91,'CWKV75','2024-06-03',2,'Golpe en la parte lateral, daños en la puerta','19.478.524-4'),(92,'PSPC14','2024-06-06',1,'Falla en el sistema eléctrico, luces intermitentes','20.362.114-0'),(93,'HLYH97','2024-06-10',3,'Frenos desgastados, vehículo fuera de servicio','20.478.452-7'),(94,'CWKV75','2024-06-15',4,'Accidente grave, daños severos en el tren delantero','7.528.684-5'),(95,'PSPC14','2024-06-18',1,'Reparación de llantas y balanceo','20.362.114-0'),(96,'CWKV75','2024-06-21',3,'Daño en el chasis, golpe fuerte','19.478.524-4'),(97,'HLYH97','2024-06-26',2,'Problema con el alternador, necesita reparación','20.478.452-7'),(98,'PSPC14','2024-06-30',1,'Cambio de aceite y mantenimiento general','20.362.114-0'),(99,'CWKV75','2024-07-02',2,'Fallo en el sistema de refrigeración','19.478.524-4'),(100,'PSPC14','2024-07-08',1,'Pequeño choque, rasguños en la pintura','20.362.114-0'),(101,'HLYH97','2024-07-12',3,'Problema con la caja de transmisión','20.478.452-7'),(102,'CWKV75','2024-07-15',4,'Choque con otro vehículo, daños en parachoques','7.528.684-5'),(103,'PSPC14','2024-07-18',1,'Rotura del parabrisas, reemplazo necesario','20.362.114-0'),(104,'CWKV75','2024-07-22',3,'Daño en el tubo de escape, reemplazo requerido','19.478.524-4'),(105,'HLYH97','2024-07-28',2,'Problema con la dirección hidráulica','20.478.452-7'),(106,'PSPC14','2024-07-30',1,'Mantenimiento preventivo completado','20.362.114-0'),(107,'CWKV75','2024-08-03',2,'Choque con otro vehículo en la autopista','19.478.524-4'),(108,'PSPC14','2024-08-06',1,'Golpe leve en la parte delantera, parachoques roto','20.362.114-0'),(109,'HLYH97','2024-08-10',3,'Fallo en los frenos, requiere reparación inmediata','20.478.452-7'),(110,'CWKV75','2024-08-15',4,'Accidente en intersección, daños severos en lateral','7.528.684-5'),(111,'PSPC14','2024-08-18',1,'Mantenimiento preventivo, revisión de motor','20.362.114-0'),(112,'CWKV75','2024-08-21',3,'Problema con el alternador, reemplazo necesario','19.478.524-4'),(113,'HLYH97','2024-08-26',2,'Choque con un poste, daños en capó y luces','20.478.452-7'),(114,'PSPC14','2024-08-30',1,'Cambio de llantas y ajuste de suspensión','20.362.114-0'),(115,'CWKV75','2024-09-02',2,'Fallo en el sistema eléctrico, luces no funcionan','19.478.524-4'),(116,'PSPC14','2024-09-08',1,'Pequeño golpe en la puerta lateral, pintura dañada','20.362.114-0'),(117,'HLYH97','2024-09-12',3,'Daño en la transmisión, requiere ajuste','20.478.452-7'),(118,'CWKV75','2024-09-15',4,'Choque en estacionamiento, daños en parachoques trasero','7.528.684-5'),(119,'PSPC14','2024-09-19',1,'Revisión de frenos y ajuste','20.362.114-0'),(120,'CWKV75','2024-09-22',3,'Reemplazo de batería, problema de encendido','19.478.524-4'),(121,'HLYH97','2024-09-27',2,'Problema con el sistema de escape','20.478.452-7'),(122,'PSPC14','2024-09-30',1,'Mantenimiento general completado','20.362.114-0'),(123,'CWKV75','2024-10-03',2,'Choque con otro vehículo en la intersección','19.478.524-4'),(124,'PSPC14','2024-10-07',1,'Daños leves en el parachoques trasero','20.362.114-0'),(125,'HLYH97','2024-10-12',3,'Fallo en el motor, revisión necesaria','20.478.452-7'),(126,'CWKV75','2024-10-15',4,'Golpe fuerte en la puerta del conductor, rasguños severos','7.528.684-5'),(127,'PSPC14','2024-10-19',1,'Cambio de frenos y ajuste de suspensión','20.362.114-0'),(128,'CWKV75','2024-10-22',3,'Problema con la dirección, requiere reparación','19.478.524-4'),(129,'HLYH97','2024-10-26',2,'Accidente en carretera, daños severos en la parte trasera','20.478.452-7'),(130,'PSPC14','2024-10-30',1,'Revisión completa del vehículo','20.362.114-0'),(131,'CWKV75','2024-11-02',2,'Accidente leve, daño en el parachoques delantero','19.478.524-4'),(132,'PSPC14','2024-11-07',1,'Problemas en el sistema de frenos','20.362.114-0'),(133,'HLYH97','2024-11-11',3,'Revisión de motor, fallo en encendido','20.478.452-7'),(134,'CWKV75','2024-11-14',4,'Golpe en estacionamiento, pintura dañada','7.528.684-5'),(135,'PSPC14','2024-11-18',1,'Daños leves en el espejo lateral','20.362.114-0'),(136,'CWKV75','2024-11-22',3,'Problema en la caja de cambios','19.478.524-4'),(137,'HLYH97','2024-11-27',2,'Choque menor en la autopista, daño leve en la parte trasera','20.478.452-7'),(138,'PSPC14','2024-11-30',1,'Mantenimiento y cambio de aceite','20.362.114-0'),(139,'CWKV75','2024-12-01',2,'Problema con los frenos, necesita ajuste','19.478.524-4'),(140,'PSPC14','2024-12-07',1,'Accidente menor, rayones en la parte lateral','20.362.114-0'),(141,'HLYH97','2024-12-11',3,'Daño en el tren trasero por impacto leve','20.478.452-7'),(142,'CWKV75','2024-12-15',4,'Golpe fuerte en la parte trasera, parachoques roto','7.528.684-5'),(143,'PSPC14','2024-12-19',1,'Revisión de suspensión y llantas','20.362.114-0'),(144,'CWKV75','2024-12-22',3,'Problema en el sistema eléctrico, luces intermitentes','19.478.524-4'),(145,'HLYH97','2024-12-27',2,'Golpe leve en el estacionamiento, espejo roto','20.478.452-7'),(146,'PSPC14','2024-12-30',1,'Mantenimiento final del año, sin problemas mayores','20.362.114-0');
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud_combustible`
--

LOCK TABLES `solicitud_combustible` WRITE;
/*!40000 ALTER TABLE `solicitud_combustible` DISABLE KEYS */;
INSERT INTO `solicitud_combustible` VALUES (13,'JHJG13','20.478.452-7','2024-09-30',24600,25000.00,'Denegada','20.362.114-0'),(15,'JHJG13','20.478.452-7','2024-09-30',47000,35000.00,'Aprobada','20.362.114-0'),(16,'JGYP14','20.362.114-0','2024-09-30',17944,5000.00,'Denegada','20.362.114-0'),(17,'HYJB29','20.362.114-0','2024-09-30',4999,20000.00,'Denegada','20.362.114-0'),(18,'HYJB29','20.362.114-0','2024-09-30',4997,50000.00,'Denegada','20.362.114-0'),(19,'HYJB29','20.362.114-0','2024-09-30',20,50000.00,'Denegada','20.362.114-0'),(20,'HLYH97','20.362.114-0','2024-09-30',8701,25000.00,'Denegada','20.362.114-0'),(21,'CWKV75','20.362.114-0','2024-10-02',15000,25000.00,'Denegada','20.362.114-0'),(22,'JHJG13','20.478.452-7','2024-10-02',24800,15000.00,'Denegada','15.234.685-5'),(23,'HGWZ58','10.588.245-4','2024-10-02',20000,30000.00,'Denegada','19.478.524-4'),(24,'HGWZ58','10.588.245-4','2024-10-02',20300,25000.00,'Denegada','19.478.524-4'),(25,'JHJG13','20.478.452-7','2024-10-02',24600,82000.00,'Denegada','15.234.685-5'),(26,'HGWZ58','10.588.245-4','2024-10-02',20000,25000.00,'Aprobada','19.478.524-4'),(27,'PSPC14','19.478.524-4','2024-10-02',34000,52000.00,'Aprobada','20.362.114-0'),(28,'HGWZ58','10.588.245-4','2024-10-02',20000,52000.00,'Denegada','19.478.524-4');
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
INSERT INTO `usuario` VALUES ('10.588.245-4','Marcelo Bielsa Sculini','marcelo.bielsa','0d9d09e157f7c29a43c02e57f081915d6fe2f10da1710672086f8ad73bb95cb2','2024-09-16',3,3,'19.478.524-4'),('14.587.522-3','Albertina Lara Bustamante',NULL,NULL,'2024-09-17',NULL,2,NULL),('14.754.145-7','Juan Roa Lucra',NULL,NULL,'2024-09-10',NULL,3,'19.478.524-4'),('15.234.685-5','Miguel Roa Iturra','miguel.roa','0d9d09e157f7c29a43c02e57f081915d6fe2f10da1710672086f8ad73bb95cb2','2024-09-11',2,3,'20.362.114-0'),('19.478.524-4','Joaquin Flores Rodriguez','jo.flores','0d9d09e157f7c29a43c02e57f081915d6fe2f10da1710672086f8ad73bb95cb2','2024-09-13',2,1,NULL),('20.362.114-0','Michael Nuñez Velozo','mic.nunez','71a026cd7933debf0230c529bf5d0caa3314440d160ea99f2428d3c310ec68c1','2024-09-13',1,5,NULL),('20.478.452-7','Matias Quiñones Varela','ma.quinones','0d9d09e157f7c29a43c02e57f081915d6fe2f10da1710672086f8ad73bb95cb2','2024-09-13',3,2,'15.234.685-5'),('7.528.684-5','Juan Alberto Lara Silva','juan.lara','0d9d09e157f7c29a43c02e57f081915d6fe2f10da1710672086f8ad73bb95cb2','2024-09-26',3,3,'14.587.522-3');
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
INSERT INTO `vehiculo` VALUES ('BKJW98','Chevrolet','Aveo',2009,157000,'2024-11-24',NULL,'no'),('CWKV75','Citroen','Berlingo',2022,15000,'2024-11-21','20.362.114-0','Si'),('FKXV38','Citroen','Berlingo',2022,13000,'2024-11-21','20.362.114-0','Si'),('HGWZ58','Citroen','Berlingo',2022,20000,'2024-11-21','10.588.245-4','Si'),('HLYH97','Peugeot','Partner',2023,8700,'2024-10-18','20.362.114-0','Si'),('HYJB29','Peugeot','Partner',2023,5000,'2024-10-18','20.362.114-0','Si'),('JGYP14','Peugeot','Partner',2023,17950,'2024-10-18','20.362.114-0','Si'),('JHJG13','Peugeot','Partner',2023,24600,'2024-10-14','20.478.452-7','Si'),('PSPC14','Citroen','Berlingo',2021,34000,'2024-11-21','19.478.524-4','Si'),('YTGB67','Peugeot','Partner',2023,25000,'2024-09-15','20.362.114-0','Si');
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

-- Dump completed on 2024-10-02 17:13:12
