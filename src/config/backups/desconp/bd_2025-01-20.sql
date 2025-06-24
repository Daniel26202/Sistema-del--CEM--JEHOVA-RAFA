-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bd
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

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
-- Table structure for table `categoria_servicio`
--

DROP TABLE IF EXISTS `categoria_servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria_servicio` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) NOT NULL,
  `estado` varchar(25) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria_servicio`
--

LOCK TABLES `categoria_servicio` WRITE;
/*!40000 ALTER TABLE `categoria_servicio` DISABLE KEYS */;
INSERT INTO `categoria_servicio` VALUES (1,'CARDIOLOGIA','ACT'),(2,'ONCOLOGIA','ACT'),(9,'RADIOGRAFIA','DES'),(100,'CONSULTA GENERAL','ACT'),(101,'Emergencia','ACT'),(102,'Acupuntura','ACT'),(103,'Oftalmología','ACT'),(104,'Odontología','ACT');
/*!40000 ALTER TABLE `categoria_servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cita`
--

DROP TABLE IF EXISTS `cita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cita` (
  `id_cita` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `serviciomedico_id_servicioMedico` int(11) NOT NULL,
  `paciente_id_paciente` int(11) NOT NULL,
  `hora_salida` time NOT NULL,
  PRIMARY KEY (`id_cita`,`paciente_id_paciente`),
  KEY `fk_cita_serviciomedico1_idx` (`serviciomedico_id_servicioMedico`),
  KEY `fk_cita_paciente1_idx` (`paciente_id_paciente`),
  CONSTRAINT `fk_cita_paciente1` FOREIGN KEY (`paciente_id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cita_serviciomedico1` FOREIGN KEY (`serviciomedico_id_servicioMedico`) REFERENCES `serviciomedico` (`id_servicioMedico`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cita`
--

LOCK TABLES `cita` WRITE;
/*!40000 ALTER TABLE `cita` DISABLE KEYS */;
INSERT INTO `cita` VALUES (41,'2025-04-02','12:33:00','ACT',24,23,'00:00:00'),(42,'2025-04-02','12:33:00','ACT',25,23,'00:00:00'),(43,'2025-04-02','12:33:00','ACT',22,23,'00:00:00'),(44,'2025-04-02','12:33:00','ACT',22,23,'00:00:00'),(45,'2025-04-21','22:00:00','Realizadas',26,25,'00:00:00'),(46,'2025-04-25','12:00:00','Pendiente',27,25,'00:00:00'),(47,'2025-05-05','20:00:00','Realizadas',26,25,'00:00:00'),(48,'2025-05-12','20:00:00','Pendiente',26,23,'00:00:00'),(49,'2025-06-02','20:00:00','Pendiente',24,25,'21:00:00'),(50,'2025-06-02','21:00:00','Pendiente',24,25,'21:00:00'),(51,'2025-06-02','22:00:00','Pendiente',24,25,'22:05:00'),(52,'2025-06-02','22:10:00','Pendiente',24,25,'23:05:00'),(53,'2025-06-09','20:00:00','Pendiente',24,25,'21:05:00'),(54,'2025-06-09','21:11:00','Pendiente',24,25,'22:05:00'),(55,'2025-06-16','20:00:00','Pendiente',24,34,'21:06:00');
/*!40000 ALTER TABLE `cita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `control`
--

DROP TABLE IF EXISTS `control`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `control` (
  `id_control` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `diagnostico` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `medicamentosRecetados` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fecha_control` datetime NOT NULL,
  `fechaRegreso` date NOT NULL,
  `nota` varchar(40) NOT NULL,
  `historiaclinica` text NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_control`),
  KEY `id_paciente` (`id_paciente`,`id_usuario`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `control_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `control`
--

LOCK TABLES `control` WRITE;
/*!40000 ALTER TABLE `control` DISABLE KEYS */;
INSERT INTO `control` VALUES (26,23,1,'El chico presenta dificultad para respirar, hinchazón en el cuerpo y dolores de cabeza','Cetirizina\r\nSalbutamol\r\nAcetaminofén','2025-04-02 14:37:34','2025-04-26','Debe hacerse hematología completa','historia','ACT'),(27,24,1,'La paciente presenta severos dolores de cabeza, lo cual da a entender que tiene episodios de jaqueca, a su vez también presenta problemas con la visión y mareos\r\nTomar mucha agua','Diclofenac potasico\r\nCafeína\r\nViajesan','2025-04-02 14:45:09','2025-04-23','Tomar mucha agua','historiaclinica','ACT'),(28,25,43,'diagnostico','indicaciones','2025-06-10 10:11:51','2026-06-24','nota','historial\r\n\r\n','ACT'),(29,25,42,'jfsdjfsdnfds','indicaciones','2025-06-10 20:07:54','2026-06-18','alguito','mhnfdjg algo mas','ACT');
/*!40000 ALTER TABLE `control` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `distribucion_edad_genero`
--

DROP TABLE IF EXISTS `distribucion_edad_genero`;
/*!50001 DROP VIEW IF EXISTS `distribucion_edad_genero`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `distribucion_edad_genero` AS SELECT
 1 AS `rango_edad`,
  1 AS `masculino`,
  1 AS `femenino`,
  1 AS `total`,
  1 AS `total_masculino`,
  1 AS `total_femenino` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `entrada`
--

DROP TABLE IF EXISTS `entrada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entrada` (
  `id_entrada` int(11) NOT NULL AUTO_INCREMENT,
  `id_proveedor` int(11) NOT NULL,
  `numero_de_lote` int(16) NOT NULL,
  `fechaDeIngreso` date NOT NULL,
  `estado` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_entrada`),
  KEY `id_proveedor` (`id_proveedor`),
  CONSTRAINT `entrada_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entrada`
--

LOCK TABLES `entrada` WRITE;
/*!40000 ALTER TABLE `entrada` DISABLE KEYS */;
INSERT INTO `entrada` VALUES (38,6,1,'2025-04-05','ACT'),(39,7,2,'2025-04-06','ACT'),(40,6,3435,'2025-04-21','ACT'),(41,6,3435,'2025-04-21','ACT'),(42,7,3456,'2025-04-21','ACT'),(43,6,1233,'2025-04-21','ACT'),(44,7,3232,'2025-04-29','ACT'),(45,7,3232,'2025-04-29','ACT'),(46,7,3232,'2025-04-29','ACT'),(47,7,3232,'2025-04-29','ACT'),(48,6,3232,'2025-05-02','ACT'),(49,7,1212,'2025-05-02','ACT'),(50,6,2334,'2025-05-02','ACT'),(51,7,2323,'2025-05-05','ACT'),(52,7,4553,'2025-05-05','ACT'),(53,7,4553,'2025-05-05','DES'),(54,7,2323,'2025-05-07','ACT'),(55,6,2323,'2025-05-08','ACT'),(56,6,2323,'2025-05-08','ACT'),(57,6,1212,'2025-05-08','ACT'),(58,6,5664,'2025-05-22','ACT'),(59,7,8098,'2025-06-10','ACT');
/*!40000 ALTER TABLE `entrada` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entrada_insumo`
--

DROP TABLE IF EXISTS `entrada_insumo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entrada_insumo` (
  `id_entradaDeInsumo` int(11) NOT NULL AUTO_INCREMENT,
  `id_insumo` int(11) NOT NULL,
  `id_entrada` int(11) NOT NULL,
  `fechaDeVencimiento` date NOT NULL,
  `precio` decimal(12,2) NOT NULL,
  `cantidad_entrante` int(12) NOT NULL,
  `cantidad_disponible` int(12) NOT NULL,
  PRIMARY KEY (`id_entradaDeInsumo`),
  KEY `id_insumo` (`id_insumo`),
  KEY `id_entrada` (`id_entrada`),
  CONSTRAINT `entrada_insumo_ibfk_1` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`id_insumo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `entrada_insumo_ibfk_2` FOREIGN KEY (`id_entrada`) REFERENCES `entrada` (`id_entrada`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entrada_insumo`
--

LOCK TABLES `entrada_insumo` WRITE;
/*!40000 ALTER TABLE `entrada_insumo` DISABLE KEYS */;
INSERT INTO `entrada_insumo` VALUES (52,37,58,'2025-05-25',9.00,89,88),(53,36,59,'2026-02-11',79.00,34,34);
/*!40000 ALTER TABLE `entrada_insumo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especialidad`
--

DROP TABLE IF EXISTS `especialidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `especialidad` (
  `id_especialidad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`id_especialidad`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidad`
--

LOCK TABLES `especialidad` WRITE;
/*!40000 ALTER TABLE `especialidad` DISABLE KEYS */;
INSERT INTO `especialidad` VALUES (3,'Cardiología','ACT'),(4,'Paramedico','ACT'),(5,'Enfermeria','ACT'),(6,'administrador','DES'),(7,'Cirugia','ACT');
/*!40000 ALTER TABLE `especialidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `especialidades_solicitadas`
--

DROP TABLE IF EXISTS `especialidades_solicitadas`;
/*!50001 DROP VIEW IF EXISTS `especialidades_solicitadas`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `especialidades_solicitadas` AS SELECT
 1 AS `especialidad`,
  1 AS `fecha`,
  1 AS `total_solicitudes` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `factura`
--

DROP TABLE IF EXISTS `factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura` (
  `id_factura` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `total` float(12,2) NOT NULL,
  `estado` varchar(10) NOT NULL,
  `paciente_id_paciente` int(11) NOT NULL,
  PRIMARY KEY (`id_factura`,`paciente_id_paciente`),
  KEY `fk_factura_paciente1_idx` (`paciente_id_paciente`),
  CONSTRAINT `fk_factura_paciente1` FOREIGN KEY (`paciente_id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
INSERT INTO `factura` VALUES (57,'2025-04-14',1000.00,'ACT',25),(58,'2025-04-14',1000.00,'ACT',25),(61,'2025-04-21',1123.00,'ACT',25),(62,'2025-04-15',1000.00,'ACT',25),(63,'2025-04-15',1000.00,'ACT',25),(64,'2025-04-16',125.00,'ACT',25),(65,'2025-04-16',125.00,'ACT',25),(66,'2025-04-17',125.00,'ACT',25),(67,'2025-04-17',415.00,'ACT',25),(68,'2025-04-17',158.00,'ACT',25),(69,'2025-04-17',330.00,'ACT',25),(70,'2025-04-17',25.00,'ACT',25),(71,'2025-04-17',430.00,'ACT',25),(72,'2025-04-17',199.00,'ACT',25),(73,'2025-04-17',58.00,'ACT',25),(74,'2025-04-17',58.00,'ACT',25),(75,'2025-04-17',58.00,'ACT',25),(76,'2025-04-17',50.00,'ACT',25),(77,'2025-04-17',75.00,'ACT',25),(78,'2025-04-21',25.00,'ACT',25),(79,'2025-04-21',123.96,'ACT',25),(80,'2025-04-21',103.30,'ACT',25),(81,'2025-04-21',123.96,'ACT',25),(82,'2025-04-21',123.96,'ACT',25),(83,'2025-04-21',10.33,'ACT',25),(84,'2025-04-21',30.99,'ACT',25),(85,'2025-04-21',22.77,'ACT',25),(86,'2025-04-21',16.55,'ACT',25),(87,'2025-04-21',16.55,'ACT',25),(88,'2025-04-21',125.30,'ACT',25),(89,'2025-04-21',35.80,'ACT',25),(90,'2025-04-21',17.90,'ACT',25),(91,'2025-05-01',2129.30,'ACT',23),(92,'2025-05-01',1127.20,'ACT',23),(93,'2025-05-01',1123.00,'ACT',23),(94,'2025-05-01',2.10,'ACT',23),(95,'2025-05-03',182.12,'ACT',25),(96,'2025-05-03',1000.00,'ACT',25),(97,'2025-05-05',129.00,'ACT',25),(98,'2025-05-07',1.20,'ACT',25),(99,'2025-05-07',29.56,'ACT',25),(100,'2025-05-07',30.16,'ACT',25),(101,'2025-05-07',0.60,'ACT',25),(102,'2025-05-07',1230.00,'ACT',25),(103,'2025-05-22',1.00,'ACT',24),(104,'2025-06-09',1000.00,'ACT',25);
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura_has_inventario`
--

DROP TABLE IF EXISTS `factura_has_inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura_has_inventario` (
  `factura_id_factura` int(11) NOT NULL,
  `inventario_id_inventario` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` varchar(5) NOT NULL,
  KEY `fk_factura_has_inventario_inventario1_idx` (`inventario_id_inventario`),
  KEY `fk_factura_has_inventario_factura1_idx` (`factura_id_factura`),
  CONSTRAINT `factura_has_inventario_ibfk_2` FOREIGN KEY (`factura_id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `factura_has_inventario_ibfk_3` FOREIGN KEY (`inventario_id_inventario`) REFERENCES `entrada_insumo` (`id_entradaDeInsumo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_has_inventario`
--

LOCK TABLES `factura_has_inventario` WRITE;
/*!40000 ALTER TABLE `factura_has_inventario` DISABLE KEYS */;
/*!40000 ALTER TABLE `factura_has_inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horario`
--

DROP TABLE IF EXISTS `horario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL AUTO_INCREMENT,
  `diaslaborables` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_horario`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horario`
--

LOCK TABLES `horario` WRITE;
/*!40000 ALTER TABLE `horario` DISABLE KEYS */;
INSERT INTO `horario` VALUES (8,'domingo'),(9,'lunes'),(10,'martes'),(11,'miércoles'),(12,'jueves'),(13,'viernes'),(14,'sábado');
/*!40000 ALTER TABLE `horario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horarioydoctor`
--

DROP TABLE IF EXISTS `horarioydoctor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horarioydoctor` (
  `id_horarioydoctor` int(11) NOT NULL AUTO_INCREMENT,
  `id_personal` int(11) NOT NULL,
  `id_horario` int(11) NOT NULL,
  `horaDeEntrada` time NOT NULL,
  `horaDeSalida` time NOT NULL,
  PRIMARY KEY (`id_horarioydoctor`),
  KEY `id_doctor` (`id_personal`),
  KEY `id_horario` (`id_horario`),
  CONSTRAINT `horarioydoctor_ibfk_1` FOREIGN KEY (`id_personal`) REFERENCES `personal` (`id_personal`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `horarioydoctor_ibfk_2` FOREIGN KEY (`id_horario`) REFERENCES `horario` (`id_horario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horarioydoctor`
--

LOCK TABLES `horarioydoctor` WRITE;
/*!40000 ALTER TABLE `horarioydoctor` DISABLE KEYS */;
INSERT INTO `horarioydoctor` VALUES (30,19,9,'20:00:00','23:00:00'),(31,20,13,'10:00:00','13:00:00'),(32,21,9,'10:00:00','12:00:00'),(33,21,11,'11:00:00','17:00:00'),(34,22,9,'10:00:00','13:00:00'),(35,22,10,'14:00:00','16:00:00'),(36,23,13,'09:00:00','10:01:00');
/*!40000 ALTER TABLE `horarioydoctor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hospitalizacion`
--

DROP TABLE IF EXISTS `hospitalizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hospitalizacion` (
  `id_hospitalizacion` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_hora_inicio` datetime NOT NULL,
  `precio_horas` float DEFAULT NULL,
  `precio_horas_MoEx` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `total_MoEx` float DEFAULT NULL,
  `id_control` int(11) NOT NULL,
  `fecha_hora_final` datetime DEFAULT NULL,
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_hospitalizacion`),
  KEY `id_control` (`id_control`),
  CONSTRAINT `hospitalizacion_ibfk_1` FOREIGN KEY (`id_control`) REFERENCES `control` (`id_control`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospitalizacion`
--

LOCK TABLES `hospitalizacion` WRITE;
/*!40000 ALTER TABLE `hospitalizacion` DISABLE KEYS */;
INSERT INTO `hospitalizacion` VALUES (12,'2025-04-28 18:42:13',0,NULL,0,NULL,26,'0000-00-00 00:00:00','DES'),(13,'2025-04-29 07:32:00',0,NULL,1,NULL,27,'0000-00-00 00:00:00','Realizadas'),(14,'2025-05-23 08:17:49',0,0,0,0,26,'0000-00-00 00:00:00','Pendiente'),(15,'2025-06-10 20:20:19',0,0,0,0,29,'0000-00-00 00:00:00','Pendiente');
/*!40000 ALTER TABLE `hospitalizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insumo`
--

DROP TABLE IF EXISTS `insumo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `insumo` (
  `id_insumo` int(11) NOT NULL AUTO_INCREMENT,
  `imagen` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `descripcion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `marca` varchar(35) NOT NULL,
  `medida` varchar(35) NOT NULL,
  `precio` float(12,2) NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `stockMinimo` int(11) NOT NULL,
  PRIMARY KEY (`id_insumo`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insumo`
--

LOCK TABLES `insumo` WRITE;
/*!40000 ALTER TABLE `insumo` DISABLE KEYS */;
INSERT INTO `insumo` VALUES (24,'','Paracetamol','El paracetamol, también conocido como acetaminofén o acetaminofeno, es un fármaco con propiedades analgésicas y antipiréticas utilizado principalmente para tratar la fiebre y el dolor leve y moderado','','',10.33,'DES',0),(25,'','Ibuprofeno','El ibuprofeno es un antinflamatorio no esteroideo (AINE) que pertenece al subgrupo de fármacos derivados del ácido propiónico.','','',17.90,'DES',0),(29,'2025-04-29_1745911425_WhatsApp Image 2025-04-03 at 11.51.47 PM.jpeg','Ibuprofeno','descripción','','',2.10,'DES',0),(30,'2025-05-02_1746200226_9amALQfcTkJsr2zlMRcpi99AnctFZBjlnRxibrip.jpg','Ibuprofeno','descripción','','',2.10,'DES',0),(31,'2025-05-02_1746216592_img27.jpg','Insumo','Es un antinflamatorio son derivados del ácido propiónico.','Tecno spar 30212 ','400 ml',29.56,'ACT',1),(32,'2025-05-05_1746489843_img23.jpg','Lobo','Es un lobo malvado','Tecno spar 30212 ','400 ml',0.60,'DES',1),(33,'2025-05-07_1746668110_img16.jpg','Spidermas','Es un antinflamatorio son derivados del ácido propiónico.','Tecno spar 30212 ','600 ml',123.00,'ACT',1),(34,'2025-05-08_1746714309_img5.jpg','Caballero','El ibuprofeno es un antinflamaupo de fármacos derivados del ácido propiónico.','Tecno spar 30212','600 ml',2040.00,'DES',1),(35,'2025-05-08_1746715177_img29.jpg','Insumodolar','Es un antinflamatorio son derivados del ácido propiónico.','Tecno spar 30212 ','200 ml',870.00,'DES',5),(36,'2025-05-08_1746715431_img7.jpg','Ansumo','El ibuprofeno e','Tecno spar 3022 ','400 ml',80.00,'ACT',2),(37,'2025-05-22_1747932563_img16.jpg','Spiderman','descripcio1','Spidermas','100 g',9.00,'ACT',1);
/*!40000 ALTER TABLE `insumo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insumodehospitalizacion`
--

DROP TABLE IF EXISTS `insumodehospitalizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `insumodehospitalizacion` (
  `id_insumoDeHospitalizacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_hospitalizacion` int(11) NOT NULL,
  `id_inventario` int(11) NOT NULL,
  `cantidad` int(13) NOT NULL,
  PRIMARY KEY (`id_insumoDeHospitalizacion`),
  KEY `id_hospitalizacion` (`id_hospitalizacion`),
  KEY `id_insumo` (`id_inventario`),
  CONSTRAINT `insumodehospitalizacion_ibfk_1` FOREIGN KEY (`id_hospitalizacion`) REFERENCES `hospitalizacion` (`id_hospitalizacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `insumodehospitalizacion_ibfk_2` FOREIGN KEY (`id_inventario`) REFERENCES `entrada_insumo` (`id_entradaDeInsumo`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insumodehospitalizacion`
--

LOCK TABLES `insumodehospitalizacion` WRITE;
/*!40000 ALTER TABLE `insumodehospitalizacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `insumodehospitalizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `insumos`
--

DROP TABLE IF EXISTS `insumos`;
/*!50001 DROP VIEW IF EXISTS `insumos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `insumos` AS SELECT
 1 AS `nombre_insumo`,
  1 AS `total_usado` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `paciente`
--

DROP TABLE IF EXISTS `paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paciente` (
  `id_paciente` int(11) NOT NULL AUTO_INCREMENT,
  `nacionalidad` varchar(12) NOT NULL,
  `cedula` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `apellido` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `telefono` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `direccion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fn` date NOT NULL,
  `genero` varchar(16) NOT NULL,
  `estado` varchar(5) NOT NULL,
  PRIMARY KEY (`id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente`
--

LOCK TABLES `paciente` WRITE;
/*!40000 ALTER TABLE `paciente` DISABLE KEYS */;
INSERT INTO `paciente` VALUES (23,'V','28150004','Juan','Silva','04121338031','Calle 10 entre 3 y 7','2001-09-22','masculino','ACT'),(24,'V','28329224','Rocio','Rodriguez','04121338031','URB EL BOSQUE CALLE 12','2025-04-02','femenino','ACT'),(25,'V','30554144','Carlos','Hernadéz','04121232343','Eb su casa','2012-02-11','masculino','ACT'),(26,'V','17664525','Sofia','Sofia','4121338031','Direccion','2001-09-22','Femenino','ACT'),(27,'V','158961','Aaaa','Aaaa','4121338032','Direccion','2001-09-22','Masculino','ACT'),(28,'V','2000001','Argentina','Apellido_1','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(29,'V','2000002','Brasil','Apellido_2','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(30,'V','2000003','Chile','Apellido_3','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(31,'V','2000004','Colombia','Apellido_4','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(32,'V','2000005','México','Apellido_5','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(33,'V','2000006','Perú','Apellido_6','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(34,'V','2000007','Uruguay','Apellido_7','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(35,'V','2000008','Venezuela','Apellido_8','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(36,'V','2000009','Ecuador','Apellido_9','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(37,'V','2000010','Bolivia','Apellido_10','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(38,'V','2000011','Paraguay','Apellido_11','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(39,'V','2000012','Panamá','Apellido_12','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(40,'V','2000013','Costa Rica','Apellido_13','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(41,'V','2000014','Guatemala','Apellido_14','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(42,'V','2000015','El Salvador','Apellido_15','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(43,'V','2000016','Honduras','Apellido_16','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(44,'V','2000017','Nicaragua','Apellido_17','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(45,'V','2000018','Cuba','Apellido_18','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(46,'V','2000019','República Dominicana','Apellido_19','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(47,'V','2000020','Puerto Rico','Apellido_20','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(48,'V','2000021','Canadá','Apellido_21','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(49,'V','2000022','España','Apellido_22','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(50,'V','2000023','Francia','Apellido_23','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(51,'V','2000024','Italia','Apellido_24','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(52,'V','2000025','Alemania','Apellido_25','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(53,'V','2000026','Portugal','Apellido_26','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(54,'V','2000027','Grecia','Apellido_27','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(55,'V','2000028','Rusia','Apellido_28','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(56,'V','2000029','China','Apellido_29','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(57,'V','2000030','Japón','Apellido_30','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(58,'V','2000031','Corea del Sur','Apellido_31','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(59,'V','2000032','India','Apellido_32','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(60,'V','2000033','Australia','Apellido_33','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(61,'V','2000034','Nueva Zelanda','Apellido_34','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(62,'V','2000035','Egipto','Apellido_35','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(63,'V','2000036','Sudáfrica','Apellido_36','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(64,'V','2000037','Nigeria','Apellido_37','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(65,'V','2000038','Kenia','Apellido_38','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(66,'V','2000039','Senegal','Apellido_39','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(67,'V','2000040','Túnez','Apellido_40','04121338031','Dirección genérica','2000-01-01','femenino','ACT'),(68,'V','2000041','Argentina','Apellido_41','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(69,'V','2000042','Brasil','Apellido_42','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(70,'V','2000043','Chile','Apellido_43','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(71,'V','2000044','Colombia','Apellido_44','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(72,'V','2000045','México','Apellido_45','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(73,'V','2000046','Perú','Apellido_46','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(74,'V','2000047','Uruguay','Apellido_47','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(75,'V','2000048','Venezuela','Apellido_48','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(76,'V','2000049','Ecuador','Apellido_49','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(77,'V','2000050','Bolivia','Apellido_50','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(78,'V','2000051','Paraguay','Apellido_51','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(79,'V','2000052','Panamá','Apellido_52','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(80,'V','2000053','Costa Rica','Apellido_53','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(81,'V','2000054','Guatemala','Apellido_54','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(82,'V','2000055','El Salvador','Apellido_55','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(83,'V','2000056','Honduras','Apellido_56','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(84,'V','2000057','Nicaragua','Apellido_57','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(85,'V','2000058','Cuba','Apellido_58','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(86,'V','2000059','República Dominicana','Apellido_59','04121338031','Dirección genérica','2000-01-01','masculino','ACT'),(87,'V','2000060','Puerto Rico','Apellido_60','04121338031','Dirección genérica','2000-01-01','masculino','ACT');
/*!40000 ALTER TABLE `paciente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pago`
--

DROP TABLE IF EXISTS `pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pago` (
  `id_pago` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago`
--

LOCK TABLES `pago` WRITE;
/*!40000 ALTER TABLE `pago` DISABLE KEYS */;
INSERT INTO `pago` VALUES (5,'Efectivo'),(6,'Pago Movil'),(7,'Transferencia'),(8,'Divisas');
/*!40000 ALTER TABLE `pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagodefactura`
--

DROP TABLE IF EXISTS `pagodefactura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagodefactura` (
  `id_pagoDeFactura` int(11) NOT NULL AUTO_INCREMENT,
  `id_pago` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `referencia` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `monto` float(12,2) NOT NULL,
  PRIMARY KEY (`id_pagoDeFactura`),
  KEY `id_pago` (`id_pago`),
  KEY `id_factura` (`id_factura`),
  CONSTRAINT `pagodefactura_ibfk_1` FOREIGN KEY (`id_pago`) REFERENCES `pago` (`id_pago`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pagodefactura_ibfk_2` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagodefactura`
--

LOCK TABLES `pagodefactura` WRITE;
/*!40000 ALTER TABLE `pagodefactura` DISABLE KEYS */;
INSERT INTO `pagodefactura` VALUES (72,5,57,'',1000.00),(73,5,58,'',1000.00),(74,5,61,'1234',1000.00),(75,7,61,'1234',123.00),(76,5,62,'1221',100.00),(77,8,62,'1221',600.00),(78,6,62,'1221',300.00),(79,5,63,'1233',300.00),(80,8,63,'1233',300.00),(81,6,63,'1233',400.00),(82,5,64,'1334',100.00),(83,6,64,'1334',25.00),(84,5,65,'1334',100.00),(85,6,65,'1334',25.00),(86,5,66,'1223',25.00),(87,6,66,'1223',100.00),(88,5,67,'',415.00),(89,5,68,'',158.00),(90,5,69,'',330.00),(91,5,70,'',25.00),(92,5,71,'',430.00),(93,5,72,'',199.00),(94,5,73,'',58.00),(95,5,74,'',58.00),(96,5,75,'',58.00),(97,5,76,'',50.00),(98,5,77,'',75.00),(99,5,78,'',25.00),(100,5,79,'',123.96),(101,5,80,'',103.30),(102,5,81,'',123.96),(103,5,82,'',123.96),(104,5,83,'',10.33),(105,5,84,'',30.99),(106,7,84,'',0.00),(107,5,85,'',22.77),(108,5,86,'',16.55),(109,5,87,'',16.55),(110,5,88,'',125.30),(111,5,89,'',35.80),(112,5,90,'',17.90),(113,5,91,'2312',129.30),(114,8,91,'2312',1000.00),(115,6,91,'2312',1000.00),(116,5,92,'',1127.20),(117,8,92,'',0.00),(118,5,93,'',1123.00),(119,5,94,'',2.10),(120,6,94,'',0.00),(121,5,95,'1234',100.00),(122,6,95,'1234',82.12),(123,5,96,'7897',500.00),(124,6,96,'7897',500.00),(125,5,97,'',129.00),(126,5,98,'2321',1.00),(127,6,98,'2321',0.20),(128,5,99,'',29.56),(129,5,100,'',29.56),(130,5,101,'',0.60),(131,5,102,'',1230.00),(132,5,103,'',1.00),(133,5,104,'',1000.00);
/*!40000 ALTER TABLE `pagodefactura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patologia`
--

DROP TABLE IF EXISTS `patologia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patologia` (
  `id_patologia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_patologia` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `estado` varchar(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_patologia`)
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patologia`
--

LOCK TABLES `patologia` WRITE;
/*!40000 ALTER TABLE `patologia` DISABLE KEYS */;
INSERT INTO `patologia` VALUES (2,'DIABETES TIPO 1','ACT'),(3,'DIABETES TIPO 2','ACT'),(5,'EPOC','ACT'),(6,'ARTRITIS REUMATOIDE','ACT'),(7,'ENFERMEDAD CELÍACA','ACT'),(8,'OBESIDAD','ACT'),(9,'DEPRESIÓN','ACT'),(10,'ANSIEDAD','ACT'),(11,'ENFERMEDAD DE CROHN','ACT'),(12,'COLITIS ULCEROSA','ACT'),(13,'ASMA','1'),(14,'Patologia','ACT'),(15,'Algo','ACT'),(16,'HIPERTIROIDISMO','ACT'),(17,'OSTEOPOROSIS','ACT'),(18,'EPILEPSIA','ACT'),(19,'MIGRAÑA','ACT'),(20,'ALZHEIMER','ACT'),(44,'HEPATITIS B','ACT'),(186,'Hipertensión','ACT'),(189,'Bronquitis','ACT'),(190,'Neumonía','ACT'),(191,'Migraña','ACT'),(192,'Gastritis','ACT'),(193,'Hepatitis A','ACT'),(194,'Hepatitis B','ACT'),(195,'Anemia','ACT'),(196,'Artritis','ACT'),(197,'Obesidad','ACT'),(198,'Epilepsia','ACT'),(199,'Depresión','ACT'),(200,'Ansiedad','ACT'),(201,'Dermatitis','ACT'),(202,'Sinusitis','ACT'),(203,'COVID-19','ACT'),(204,'Tuberculosis','ACT'),(205,'Insuficiencia renal','ACT');
/*!40000 ALTER TABLE `patologia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patologiadepaciente`
--

DROP TABLE IF EXISTS `patologiadepaciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patologiadepaciente` (
  `id_patologiaDePaciente` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` int(11) DEFAULT NULL,
  `id_patologia` int(11) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL,
  PRIMARY KEY (`id_patologiaDePaciente`),
  KEY `id_paciente` (`id_paciente`),
  KEY `id_patologia` (`id_patologia`),
  CONSTRAINT `id_paciente ` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `id_patologia` FOREIGN KEY (`id_patologia`) REFERENCES `patologia` (`id_patologia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patologiadepaciente`
--

LOCK TABLES `patologiadepaciente` WRITE;
/*!40000 ALTER TABLE `patologiadepaciente` DISABLE KEYS */;
INSERT INTO `patologiadepaciente` VALUES (16,23,13,'2025-04-02 20:13:12'),(17,23,13,'2025-04-02 20:13:46'),(18,26,15,'2025-05-15 17:26:49'),(19,26,13,'2025-05-15 18:18:42'),(20,24,13,'2025-05-15 18:18:51'),(21,25,13,'2025-05-15 18:18:51'),(102,25,5,'2025-04-01 10:15:00'),(157,28,8,'2025-04-03 09:30:00'),(176,70,20,'2025-04-20 16:30:00'),(177,67,18,'2025-04-18 14:15:00'),(178,49,17,'2025-04-17 13:05:00'),(179,55,16,'2025-04-16 11:35:00'),(180,47,13,'2025-04-15 10:10:00'),(181,48,15,'2025-04-14 09:45:00'),(183,28,11,'2025-04-12 08:50:00'),(193,23,9,'2025-04-11 17:00:00'),(194,27,2,'2025-04-10 12:00:00'),(195,27,6,'2025-04-09 15:25:00'),(196,48,10,'2025-04-08 10:40:00'),(202,29,14,'2025-04-06 16:00:00'),(207,28,8,'2025-04-03 09:30:00'),(208,26,3,'2025-04-04 11:20:00'),(209,62,6,'2025-05-15 19:42:53'),(210,59,20,'2025-05-15 19:43:28'),(211,60,11,'2025-05-15 19:43:28'),(212,87,2,'2025-05-15 19:43:56'),(213,38,191,'2025-05-15 19:43:56'),(214,87,20,'2025-05-15 19:44:11'),(215,86,7,'2025-05-15 19:44:11'),(216,29,205,'2025-05-15 19:44:21'),(217,23,18,'2025-05-15 19:44:21'),(218,51,14,'2025-05-15 19:44:51'),(219,58,14,'2025-05-15 19:44:51'),(220,46,14,'2025-05-15 19:45:12'),(221,35,9,'2025-05-15 19:45:12'),(222,25,6,'2025-06-10 10:11:51'),(223,25,8,'2025-06-10 10:11:51'),(224,25,5,'2025-06-10 20:07:54'),(225,25,6,'2025-06-10 20:07:54'),(226,25,7,'2025-06-10 20:07:54'),(227,25,8,'2025-06-10 20:07:54'),(228,25,9,'2025-06-10 20:07:54');
/*!40000 ALTER TABLE `patologiadepaciente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal`
--

DROP TABLE IF EXISTS `personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal` (
  `id_personal` int(11) NOT NULL AUTO_INCREMENT,
  `nacionalidad` varchar(5) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `apellido` varchar(25) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `tipodecategoria` varchar(25) NOT NULL,
  `id_especialidad` int(11) DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_personal`),
  UNIQUE KEY `cedula` (`cedula`),
  KEY `id_especialidad` (`id_especialidad`),
  CONSTRAINT `personal_ibfk_1` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidad` (`id_especialidad`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal`
--

LOCK TABLES `personal` WRITE;
/*!40000 ALTER TABLE `personal` DISABLE KEYS */;
INSERT INTO `personal` VALUES (18,'V','30554053','Wilmer','Baez','04145378010','Administrador',NULL,1),(19,'V','1232233','David','Carlos','04142323233','',7,42),(20,'V','12123343','Carlos','Garcia','04244546565','',7,43),(21,'V','12020333','Ana','Bracho','04122323422','',6,45),(22,'V','6755654','Julian','Valdez','04122323212','',4,46),(23,'V','867548','Jaun','Edlkfjfdsk','04243943432','',5,49);
/*!40000 ALTER TABLE `personal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_has_serviciomedico`
--

DROP TABLE IF EXISTS `personal_has_serviciomedico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_has_serviciomedico` (
  `personal_id_personal` int(11) NOT NULL,
  `serviciomedico_id_servicioMedico` int(11) NOT NULL,
  PRIMARY KEY (`personal_id_personal`,`serviciomedico_id_servicioMedico`),
  KEY `fk_personal_has_serviciomedico_serviciomedico1_idx` (`serviciomedico_id_servicioMedico`),
  KEY `fk_personal_has_serviciomedico_personal1_idx` (`personal_id_personal`),
  CONSTRAINT `personal_has_serviciomedico_ibfk_1` FOREIGN KEY (`personal_id_personal`) REFERENCES `personal` (`id_personal`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `personal_has_serviciomedico_ibfk_2` FOREIGN KEY (`serviciomedico_id_servicioMedico`) REFERENCES `serviciomedico` (`id_servicioMedico`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_has_serviciomedico`
--

LOCK TABLES `personal_has_serviciomedico` WRITE;
/*!40000 ALTER TABLE `personal_has_serviciomedico` DISABLE KEYS */;
INSERT INTO `personal_has_serviciomedico` VALUES (18,25),(19,24),(19,26),(19,29),(19,30),(19,32),(19,33),(20,24),(20,27),(20,28),(20,31);
/*!40000 ALTER TABLE `personal_has_serviciomedico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `rif` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `telefono` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(40) NOT NULL,
  `direccion` text NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (6,'Juan Jose','281500045','04121338031','depanajuaner@gmail.com','en su casa','ACT'),(7,'Ricardo Perez','296236571','04124466999','sisisi@gmail.com','hfygh','ACT');
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `serviciomedico`
--

DROP TABLE IF EXISTS `serviciomedico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `serviciomedico` (
  `id_servicioMedico` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `precio` float(12,2) NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_servicioMedico`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `serviciomedico_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_servicio` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `serviciomedico`
--

LOCK TABLES `serviciomedico` WRITE;
/*!40000 ALTER TABLE `serviciomedico` DISABLE KEYS */;
INSERT INTO `serviciomedico` VALUES (22,9,2200.00,'ACT'),(23,100,1500.00,'ACT'),(24,1,3000.00,'ACT'),(25,101,1000.00,'ACT'),(26,2,123.00,'DES'),(27,2,123.00,'DES'),(28,1,31395.00,'DES'),(29,1,16905.00,'DES'),(30,1,169.05,'DES'),(31,101,12.00,'DES'),(32,1,479.78,'DES'),(33,100,1.07,'DES'),(34,104,24.95,'ACT'),(35,103,60.66,'ACT'),(36,102,46.81,'ACT');
/*!40000 ALTER TABLE `serviciomedico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `serviciomedico_has_factura`
--

DROP TABLE IF EXISTS `serviciomedico_has_factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `serviciomedico_has_factura` (
  `serviciomedico_id_servicioMedico` int(11) NOT NULL,
  `factura_id_factura` int(11) NOT NULL,
  KEY `id_servicio` (`serviciomedico_id_servicioMedico`),
  KEY `id_factura` (`factura_id_factura`),
  CONSTRAINT `serviciomedico_has_factura_ibfk_1` FOREIGN KEY (`serviciomedico_id_servicioMedico`) REFERENCES `serviciomedico` (`id_servicioMedico`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `serviciomedico_has_factura_ibfk_2` FOREIGN KEY (`factura_id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `serviciomedico_has_factura`
--

LOCK TABLES `serviciomedico_has_factura` WRITE;
/*!40000 ALTER TABLE `serviciomedico_has_factura` DISABLE KEYS */;
INSERT INTO `serviciomedico_has_factura` VALUES (25,58),(26,61),(25,61),(25,62),(25,63),(25,91),(26,91),(25,91),(25,92),(26,92),(25,93),(26,93),(27,95),(25,96),(26,97),(25,104);
/*!40000 ALTER TABLE `serviciomedico_has_factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sintomas`
--

DROP TABLE IF EXISTS `sintomas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sintomas` (
  `id_sintomas` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) NOT NULL,
  `estado` varchar(5) NOT NULL,
  PRIMARY KEY (`id_sintomas`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sintomas`
--

LOCK TABLES `sintomas` WRITE;
/*!40000 ALTER TABLE `sintomas` DISABLE KEYS */;
INSERT INTO `sintomas` VALUES (5,'Disnea','ACT'),(6,'Fiebre','ACT'),(7,'Vomito','DES'),(8,'Dolor de cabeza','ACT'),(9,'Malestar general','ACT'),(10,'Inchazon','ACT'),(11,'Enrojecimiento','ACT'),(12,'Piel Amarilla','ACT'),(13,'Dolor de higado','ACT'),(14,'Encias sangrantes','ACT'),(15,'sintoma','DES');
/*!40000 ALTER TABLE `sintomas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sintomas_control`
--

DROP TABLE IF EXISTS `sintomas_control`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sintomas_control` (
  `id_sintomas_control` int(11) NOT NULL AUTO_INCREMENT,
  `id_sintomas` int(11) NOT NULL,
  `id_control` int(11) NOT NULL,
  PRIMARY KEY (`id_sintomas_control`),
  KEY `id_sintomas` (`id_sintomas`),
  KEY `id_control` (`id_control`),
  CONSTRAINT `sintomas_control_ibfk_1` FOREIGN KEY (`id_sintomas`) REFERENCES `sintomas` (`id_sintomas`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sintomas_control_ibfk_2` FOREIGN KEY (`id_control`) REFERENCES `control` (`id_control`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sintomas_control`
--

LOCK TABLES `sintomas_control` WRITE;
/*!40000 ALTER TABLE `sintomas_control` DISABLE KEYS */;
INSERT INTO `sintomas_control` VALUES (37,5,26),(38,10,26),(39,8,26),(40,8,27),(41,9,27),(42,7,27),(43,5,28),(44,6,28),(45,7,28),(46,5,29),(47,6,29),(48,8,29);
/*!40000 ALTER TABLE `sintomas_control` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `tasa_morbilidad`
--

DROP TABLE IF EXISTS `tasa_morbilidad`;
/*!50001 DROP VIEW IF EXISTS `tasa_morbilidad`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `tasa_morbilidad` AS SELECT
 1 AS `nombre_patologia`,
  1 AS `casos`,
  1 AS `tasa_por_1000` */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `distribucion_edad_genero`
--

/*!50001 DROP VIEW IF EXISTS `distribucion_edad_genero`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `distribucion_edad_genero` AS select `sub`.`rango_edad` AS `rango_edad`,sum(case when `sub`.`genero` = 'masculino' then `sub`.`cantidad` else 0 end) AS `masculino`,sum(case when `sub`.`genero` = 'femenino' then `sub`.`cantidad` else 0 end) AS `femenino`,sum(`sub`.`cantidad`) AS `total`,(select count(0) from `paciente` where `paciente`.`genero` = 'masculino') AS `total_masculino`,(select count(0) from `paciente` where `paciente`.`genero` = 'femenino') AS `total_femenino` from (select case when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 0 and 12 then '0-12' when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 13 and 19 then '13-19' when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 20 and 35 then '20-35' when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 36 and 50 then '36-50' when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 51 and 65 then '51-65' else '66+' end AS `rango_edad`,`paciente`.`genero` AS `genero`,count(0) AS `cantidad` from `paciente` group by case when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 0 and 12 then '0-12' when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 13 and 19 then '13-19' when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 20 and 35 then '20-35' when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 36 and 50 then '36-50' when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 51 and 65 then '51-65' else '66+' end,`paciente`.`genero`) `sub` group by `sub`.`rango_edad` order by `sub`.`rango_edad` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `especialidades_solicitadas`
--

/*!50001 DROP VIEW IF EXISTS `especialidades_solicitadas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `especialidades_solicitadas` AS select `cs`.`nombre` AS `especialidad`,`c`.`fecha` AS `fecha`,count(`c`.`id_cita`) AS `total_solicitudes` from ((`cita` `c` join `serviciomedico` `sm` on(`c`.`serviciomedico_id_servicioMedico` = `sm`.`id_servicioMedico`)) join `categoria_servicio` `cs` on(`sm`.`id_categoria` = `cs`.`id_categoria`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `insumos`
--

/*!50001 DROP VIEW IF EXISTS `insumos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `insumos` AS select `i`.`nombre` AS `nombre_insumo`,sum(`fhi`.`cantidad`) AS `total_usado` from ((`factura_has_inventario` `fhi` join `entrada_insumo` `inv` on(`fhi`.`inventario_id_inventario` = `inv`.`id_entradaDeInsumo`)) join `insumo` `i` on(`inv`.`id_insumo` = `i`.`id_insumo`)) group by `i`.`id_insumo` order by sum(`fhi`.`cantidad`) desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `tasa_morbilidad`
--

/*!50001 DROP VIEW IF EXISTS `tasa_morbilidad`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `tasa_morbilidad` AS select `p`.`nombre_patologia` AS `nombre_patologia`,count(distinct `pp`.`id_paciente`) AS `casos`,round(count(distinct `pp`.`id_paciente`) / (select count(0) from `paciente`) * 1000,2) AS `tasa_por_1000` from (`patologiadepaciente` `pp` join `patologia` `p` on(`pp`.`id_patologia` = `p`.`id_patologia`)) group by `pp`.`id_patologia` order by count(distinct `pp`.`id_paciente`) desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-23 17:12:10
