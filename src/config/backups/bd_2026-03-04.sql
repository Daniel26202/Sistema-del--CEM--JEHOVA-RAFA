-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bd
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria_servicio`
--

LOCK TABLES `categoria_servicio` WRITE;
/*!40000 ALTER TABLE `categoria_servicio` DISABLE KEYS */;
INSERT INTO `categoria_servicio` VALUES (1,'CARDIOLOGIA','ACT'),(2,'ONCOLOGIA','ACT'),(9,'RADIOGRAFIA','DES'),(100,'CONSULTA GENERAL','ACT'),(101,'Emergencia','ACT'),(102,'Acupuntura','ACT'),(103,'Oftalmología','ACT'),(104,'Odontología','ACT'),(105,'Hello','ACT');
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
  `doctor` int(11) NOT NULL,
  PRIMARY KEY (`id_cita`,`paciente_id_paciente`),
  KEY `fk_cita_serviciomedico1_idx` (`serviciomedico_id_servicioMedico`),
  KEY `fk_cita_paciente1_idx` (`paciente_id_paciente`),
  CONSTRAINT `fk_cita_paciente1` FOREIGN KEY (`paciente_id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cita_serviciomedico1` FOREIGN KEY (`serviciomedico_id_servicioMedico`) REFERENCES `serviciomedico` (`id_servicioMedico`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cita`
--

LOCK TABLES `cita` WRITE;
/*!40000 ALTER TABLE `cita` DISABLE KEYS */;
INSERT INTO `cita` VALUES (41,'2025-04-02','12:33:00','ACT',24,23,'00:00:00',0),(42,'2025-04-02','12:33:00','ACT',25,23,'00:00:00',0),(43,'2025-04-02','12:33:00','ACT',22,23,'00:00:00',0),(44,'2025-04-02','12:33:00','ACT',22,23,'00:00:00',0),(45,'2025-04-21','22:00:00','Realizadas',26,25,'00:00:00',0),(46,'2025-04-25','12:00:00','Pendiente',27,25,'00:00:00',0),(47,'2025-05-05','20:00:00','Realizadas',26,25,'00:00:00',0),(48,'2025-05-12','20:00:00','Pendiente',26,23,'00:00:00',0),(49,'2025-06-02','20:00:00','Pendiente',24,25,'21:00:00',0),(50,'2025-06-02','21:00:00','Pendiente',24,25,'21:00:00',0),(51,'2025-06-02','22:00:00','Pendiente',24,25,'22:05:00',0),(52,'2025-06-02','22:10:00','Pendiente',24,25,'23:05:00',0),(53,'2025-06-09','20:00:00','Pendiente',24,25,'21:05:00',0),(54,'2025-06-09','21:11:00','Pendiente',24,25,'22:05:00',0),(55,'2025-06-16','20:00:00','Pendiente',24,34,'21:06:00',0),(56,'2025-06-20','10:05:00','Pendiente',24,25,'11:06:00',0),(57,'2025-06-27','10:00:00','Pendiente',24,25,'11:06:00',0),(58,'2025-06-27','11:07:00','Pendiente',24,25,'12:06:00',0),(59,'2025-06-27','12:07:00','Pendiente',24,25,'13:06:00',0),(60,'2025-07-04','10:00:00','Pendiente',24,25,'11:06:00',0),(61,'2025-07-04','11:07:00','Pendiente',24,25,'12:06:00',0),(62,'2025-07-11','10:00:00','Pendiente',24,25,'11:06:00',0),(63,'2025-07-28','20:00:00','Pendiente',24,25,'21:06:00',19),(64,'2025-07-25','10:00:00','Pendiente',24,25,'11:06:00',20);
/*!40000 ALTER TABLE `cita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nacionalidad` varchar(12) NOT NULL,
  `cedula` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `apellido` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `telefono` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `direccion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fn` date NOT NULL,
  `genero` varchar(16) NOT NULL,
  `estado` varchar(5) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'V','12098234','Jose','Lara','04123213212','esuna direccion','2005-10-02','Masculino','ACT'),(2,'V','2000002','Editado','Modificado','04123454320','en su casa','2002-02-20','Masculino','ACT'),(3,'V','3722999','Pedro','Perez','04123454327','en su casa','2002-02-20','Masculino','ACT'),(4,'V','30554144','Carlos','Hernadéz','04121232343','Eb su casa','2012-02-11','masculino','ACT');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
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
  `severidad` enum('LEVE','MODERADA','GRAVE') DEFAULT 'LEVE',
  PRIMARY KEY (`id_control`),
  KEY `id_paciente` (`id_paciente`,`id_usuario`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `control_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `control`
--

LOCK TABLES `control` WRITE;
/*!40000 ALTER TABLE `control` DISABLE KEYS */;
INSERT INTO `control` VALUES (26,23,1,'El chico presenta dificultad para respirar, hinchazón en el cuerpo y dolores de cabeza','Cetirizina\r\nSalbutamol\r\nAcetaminofén','2025-04-02 14:37:34','2025-04-26','Debe hacerse hematología completa','historia denose','ACT','LEVE'),(27,24,1,'La paciente presenta severos dolores de cabeza, lo cual da a entender que tiene episodios de jaqueca, a su vez también presenta problemas con la visión y mareos\r\nTomar mucha agua','Diclofenac potasico\r\nCafeína\r\nViajesan','2025-04-02 14:45:09','2025-04-23','Tomar mucha agua','historiaclinica','ACT','LEVE'),(28,25,43,'diagnostico','indicaciones','2025-06-10 10:11:51','2026-06-24','nota','historial\r\n\r\n','ACT','LEVE'),(29,25,42,'jfsdjfsdnfds','indicaciones','2025-06-10 20:07:54','2026-06-18','alguito','mhnfdjg algo mas','ACT','LEVE'),(30,25,43,'diagnostivo','indicaciones','2025-06-19 20:29:30','2025-07-06','nota','historial clinico  de algo no se \r\n','ACT','LEVE'),(31,89,42,'este enfermedad crónica','es una indicacion','2025-06-27 19:24:28','2025-06-29','es una nota','este en un historial','ACT','LEVE');
/*!40000 ALTER TABLE `control` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `SALUDABLE` AFTER INSERT ON `control` FOR EACH ROW IF NEW.diagnostico LIKE '%alta médica%' THEN
    UPDATE paciente SET estado_salud = 'SALUDABLE'
    WHERE id_paciente = NEW.id_paciente;
END IF */;;
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
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `after_control_insert` AFTER INSERT ON `control` FOR EACH ROW BEGIN
    DECLARE enfermedad_cronica BOOLEAN;
    
    
    SET enfermedad_cronica = (NEW.diagnostico LIKE '%crónic%' OR NEW.diagnostico LIKE '%permanente%');
    
    
    IF NEW.severidad = 'GRAVE' OR enfermedad_cronica THEN
        UPDATE paciente 
        SET estado_salud = IF(enfermedad_cronica, 'CRONICO', 'ENFERMO')
        WHERE id_paciente = NEW.id_paciente;
    ELSEIF NEW.severidad IN ('LEVE', 'MODERADA') THEN
        UPDATE paciente 
        SET estado_salud = 'ENFERMO'
        WHERE id_paciente = NEW.id_paciente;
    END IF;
    
    
    INSERT INTO historial_estados (id_paciente, estado_anterior, estado_nuevo, fecha_cambio)
    VALUES (NEW.id_paciente, 
            (SELECT estado_salud FROM paciente WHERE id_paciente = NEW.id_paciente),
            IF(NEW.severidad = 'GRAVE' OR enfermedad_cronica, 
               IF(enfermedad_cronica, 'CRONICO', 'ENFERMO'),
               'ENFERMO'),
            NOW());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `detalle_factura`
--

DROP TABLE IF EXISTS `detalle_factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_factura` (
  `id_datelle_factura` int(11) NOT NULL AUTO_INCREMENT,
  `id_factura` int(11) NOT NULL,
  `tipo` varchar(35) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` float(12,2) NOT NULL,
  `subtotal` float(12,2) NOT NULL,
  `hospitalizacion_id_hospitalizacion` int(11) DEFAULT NULL,
  `serviciomedico_id_servicioMedico` int(11) DEFAULT NULL,
  `entrada_insumo_id_entradaDeInsumo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_datelle_factura`),
  KEY `id_factura` (`id_factura`),
  KEY `hospitalizacion_id_hospitalizacion` (`hospitalizacion_id_hospitalizacion`,`serviciomedico_id_servicioMedico`,`entrada_insumo_id_entradaDeInsumo`),
  KEY `entrada_insumo_id_entradaDeInsumo` (`entrada_insumo_id_entradaDeInsumo`),
  KEY `serviciomedico_id_servicioMedico` (`serviciomedico_id_servicioMedico`),
  CONSTRAINT `detalle_factura_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`),
  CONSTRAINT `detalle_factura_ibfk_2` FOREIGN KEY (`hospitalizacion_id_hospitalizacion`) REFERENCES `hospitalizacion` (`id_hospitalizacion`),
  CONSTRAINT `detalle_factura_ibfk_3` FOREIGN KEY (`entrada_insumo_id_entradaDeInsumo`) REFERENCES `entrada_insumo` (`id_entradaDeInsumo`),
  CONSTRAINT `detalle_factura_ibfk_4` FOREIGN KEY (`serviciomedico_id_servicioMedico`) REFERENCES `serviciomedico` (`id_servicioMedico`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_factura`
--

LOCK TABLES `detalle_factura` WRITE;
/*!40000 ALTER TABLE `detalle_factura` DISABLE KEYS */;
INSERT INTO `detalle_factura` VALUES (1,197,'',1,1000.00,1000.00,NULL,25,NULL),(2,198,'Servicio',1,1000.00,1000.00,NULL,25,NULL),(3,199,'Servicio',1,1000.00,1000.00,NULL,25,NULL),(4,200,'Servicio',1,1000.00,1000.00,NULL,25,NULL),(5,204,'Insumo',1,80.00,80.00,NULL,NULL,53),(6,207,'Servicio',1,3000.00,3000.00,NULL,24,NULL),(7,208,'Hospitalizacion',1,474844.00,474844.00,27,NULL,NULL),(8,209,'Insumo',3,80.00,240.00,NULL,NULL,53),(9,210,'Insumo',1,9.00,9.00,NULL,NULL,52),(10,210,'Insumo',2,9.00,18.00,NULL,NULL,54),(11,211,'Servicio',1,1000.00,1000.00,NULL,25,NULL),(12,211,'Insumo',1,80.00,80.00,NULL,NULL,53),(13,211,'Insumo',1,9.00,9.00,NULL,NULL,54),(14,211,'Insumo',1,5.60,5.60,NULL,NULL,64);
/*!40000 ALTER TABLE `detalle_factura` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entrada`
--

LOCK TABLES `entrada` WRITE;
/*!40000 ALTER TABLE `entrada` DISABLE KEYS */;
INSERT INTO `entrada` VALUES (38,6,1,'2025-04-05','ACT'),(39,7,2,'2025-04-06','ACT'),(40,6,3435,'2025-04-21','ACT'),(41,6,3435,'2025-04-21','ACT'),(42,7,3456,'2025-04-21','ACT'),(43,6,1233,'2025-04-21','ACT'),(44,7,3232,'2025-04-29','ACT'),(45,7,3232,'2025-04-29','ACT'),(46,7,3232,'2025-04-29','ACT'),(47,7,3232,'2025-04-29','ACT'),(48,6,3232,'2025-05-02','ACT'),(49,7,1212,'2025-05-02','ACT'),(50,6,2334,'2025-05-02','ACT'),(51,7,2323,'2025-05-05','ACT'),(52,7,4553,'2025-05-05','ACT'),(53,7,4553,'2025-05-05','DES'),(54,7,2323,'2025-05-07','ACT'),(55,6,2323,'2025-05-08','ACT'),(56,6,2323,'2025-05-08','ACT'),(57,6,1212,'2025-05-08','ACT'),(58,6,5664,'2025-05-22','ACT'),(59,7,8098,'2025-06-10','ACT'),(61,7,5656,'2025-06-20','ACT'),(62,7,1234,'2025-06-21','ACT'),(63,6,5651,'2025-06-21','ACT'),(64,7,2134,'2025-06-21','ACT'),(65,7,2134,'2025-06-21','ACT'),(66,6,2134,'2025-06-21','ACT'),(67,7,3012,'2025-06-21','ACT'),(68,7,4532,'2025-06-21','ACT'),(69,7,2342,'2025-06-21','ACT'),(70,7,1223,'2025-06-21','ACT'),(71,6,4564,'2025-06-21','DES'),(72,7,5656,'2025-06-29','ACT'),(73,7,5656,'2025-06-29','ACT');
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
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entrada_insumo`
--

LOCK TABLES `entrada_insumo` WRITE;
/*!40000 ALTER TABLE `entrada_insumo` DISABLE KEYS */;
INSERT INTO `entrada_insumo` VALUES (52,37,58,'2025-05-25',9.00,89,84),(53,36,59,'2026-02-11',79.00,34,17),(54,41,62,'2026-06-29',9.00,20,17),(55,42,63,'2025-06-27',8.00,12,12),(56,36,64,'2026-06-21',12.00,1,1),(57,36,65,'2026-06-21',12.00,1,1),(58,31,66,'2026-06-21',12.00,1,0),(59,37,67,'2025-06-29',13.00,2,2),(60,31,68,'2027-06-21',120.00,9,6),(61,41,69,'2025-06-29',12.00,5,5),(62,36,70,'2025-06-29',12.00,2,2),(63,36,71,'2025-06-29',190.00,1,1),(64,43,72,'2026-07-06',8.00,12,11),(65,44,73,'2027-06-30',2.80,12,12);
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
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
INSERT INTO `factura` VALUES (57,'2025-04-14',1000.00,'ACT',25),(58,'2025-04-14',1000.00,'ACT',25),(61,'2025-04-21',1123.00,'ACT',25),(62,'2025-04-15',1000.00,'ACT',25),(63,'2025-04-15',1000.00,'ACT',25),(64,'2025-04-16',125.00,'ACT',25),(65,'2025-04-16',125.00,'ACT',25),(66,'2025-04-17',125.00,'ACT',25),(67,'2025-04-17',415.00,'ACT',25),(68,'2025-04-17',158.00,'ACT',25),(69,'2025-04-17',330.00,'ACT',25),(70,'2025-04-17',25.00,'ACT',25),(71,'2025-04-17',430.00,'ACT',25),(72,'2025-04-17',199.00,'ACT',25),(73,'2025-04-17',58.00,'ACT',25),(74,'2025-04-17',58.00,'ACT',25),(75,'2025-04-17',58.00,'ACT',25),(76,'2025-04-17',50.00,'ACT',25),(77,'2025-04-17',75.00,'ACT',25),(78,'2025-04-21',25.00,'ACT',25),(79,'2025-04-21',123.96,'ACT',25),(80,'2025-04-21',103.30,'ACT',25),(81,'2025-04-21',123.96,'ACT',25),(82,'2025-04-21',123.96,'ACT',25),(83,'2025-04-21',10.33,'ACT',25),(84,'2025-04-21',30.99,'ACT',25),(85,'2025-04-21',22.77,'ACT',25),(86,'2025-04-21',16.55,'ACT',25),(87,'2025-04-21',16.55,'ACT',25),(88,'2025-04-21',125.30,'ACT',25),(89,'2025-04-21',35.80,'ACT',25),(90,'2025-04-21',17.90,'ACT',25),(91,'2025-05-01',2129.30,'ACT',23),(92,'2025-05-01',1127.20,'ACT',23),(93,'2025-05-01',1123.00,'ACT',23),(94,'2025-05-01',2.10,'ACT',23),(95,'2025-05-03',182.12,'ACT',25),(96,'2025-05-03',1000.00,'ACT',25),(97,'2025-05-05',129.00,'ACT',25),(98,'2025-05-07',1.20,'ACT',25),(99,'2025-05-07',29.56,'ACT',25),(100,'2025-05-07',30.16,'ACT',25),(101,'2025-05-07',0.60,'ACT',25),(102,'2025-05-07',1230.00,'ACT',25),(103,'2025-05-22',1.00,'ACT',24),(104,'2025-06-09',1000.00,'ACT',25),(105,'2025-06-14',1000.00,'ACT',25),(106,'2025-06-14',1000.00,'ACT',25),(107,'2025-06-14',3000.00,'ACT',25),(108,'2025-06-15',80.00,'ACT',25),(109,'2025-06-15',4000.00,'ACT',25),(110,'2025-06-16',240.00,'ACT',25),(111,'2025-06-16',240.00,'ACT',25),(112,'2025-06-16',240.00,'ACT',25),(113,'2025-06-16',240.00,'ACT',25),(114,'2025-06-16',80.00,'ACT',25),(115,'2025-06-16',80.00,'ACT',25),(116,'2025-06-16',80.00,'ACT',25),(117,'2025-06-16',9.00,'ACT',25),(118,'2025-06-16',240.00,'ACT',25),(119,'2025-06-16',63.00,'ACT',25),(120,'2025-06-16',36.00,'ACT',25),(121,'2025-06-16',80.00,'ACT',25),(122,'2025-06-16',9.00,'ACT',25),(123,'2025-06-16',240.00,'ACT',25),(124,'2025-06-16',240.00,'ACT',25),(125,'2025-06-16',240.00,'ACT',25),(126,'2025-06-16',240.00,'ACT',25),(127,'2025-06-16',240.00,'ACT',25),(128,'2025-06-16',240.00,'ACT',25),(129,'2025-06-16',240.00,'ACT',25),(130,'2025-06-16',240.00,'ACT',25),(131,'2025-06-16',240.00,'ACT',25),(132,'2025-06-16',240.00,'ACT',25),(133,'2025-06-16',240.00,'ACT',25),(134,'2025-06-17',240.00,'ACT',25),(135,'2025-06-17',240.00,'ACT',25),(136,'2025-06-17',80.00,'ACT',25),(137,'2025-06-18',80.00,'ACT',25),(138,'2025-06-18',80.00,'ACT',25),(139,'2025-06-18',80.00,'ACT',25),(140,'2025-06-18',160.00,'ACT',25),(141,'2025-06-18',36.00,'ACT',25),(142,'2025-06-18',80.00,'ACT',25),(143,'2025-06-18',80.00,'ACT',25),(144,'2025-06-18',116.00,'ACT',25),(145,'2025-06-18',80.00,'ACT',25),(146,'2025-06-18',98.00,'ACT',25),(147,'2025-06-19',560.00,'ACT',25),(148,'2025-06-21',9.00,'ACT',25),(149,'2025-06-21',160.00,'ACT',25),(150,'2025-06-22',1000.00,'ACT',25),(151,'2025-06-22',240.00,'Anulada',25),(152,'2025-06-24',29.56,'ACT',25),(153,'2025-06-27',9.00,'ACT',25),(154,'2025-06-28',29.56,'Anulada',25),(155,'2025-06-28',1080.00,'ACT',25),(156,'2025-06-28',29.56,'ACT',25),(157,'2025-06-29',478692.00,'ACT',23),(158,'2025-06-29',123.00,'ACT',25),(159,'2025-06-29',1.88,'ACT',25),(160,'2025-06-29',17.00,'ACT',25),(161,'2025-06-30',3000.00,'ACT',25),(162,'2025-06-30',6000.00,'ACT',25),(163,'2025-06-30',6000.00,'ACT',25),(164,'2025-06-30',6000.00,'ACT',25),(165,'2025-06-30',6000.00,'ACT',25),(166,'2025-06-30',6000.00,'ACT',25),(167,'2025-06-30',6000.00,'ACT',25),(168,'2025-06-30',6000.00,'ACT',25),(169,'2025-06-30',6000.00,'ACT',25),(170,'2025-06-30',6000.00,'ACT',25),(171,'2025-06-30',6000.00,'ACT',25),(172,'2025-06-30',6000.00,'ACT',25),(173,'2025-06-30',51.89,'ACT',24);
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
  `id_entradaDeInsumo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` varchar(5) NOT NULL,
  KEY `fk_factura_has_inventario_factura1_idx` (`factura_id_factura`),
  KEY `id_entradaDeInsumo` (`id_entradaDeInsumo`),
  CONSTRAINT `factura_has_inventario_ibfk_2` FOREIGN KEY (`factura_id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `factura_has_inventario_ibfk_3` FOREIGN KEY (`id_entradaDeInsumo`) REFERENCES `entrada_insumo` (`id_entradaDeInsumo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_has_inventario`
--

LOCK TABLES `factura_has_inventario` WRITE;
/*!40000 ALTER TABLE `factura_has_inventario` DISABLE KEYS */;
INSERT INTO `factura_has_inventario` VALUES (117,52,1,'ACT'),(118,52,3,'ACT'),(119,52,3,'ACT'),(119,52,1,'ACT'),(130,53,3,'ACT'),(132,53,3,'ACT'),(133,53,3,'ACT'),(134,53,3,'ACT'),(135,53,3,'ACT'),(136,53,1,'ACT'),(137,53,1,'ACT'),(138,53,1,'ACT'),(139,53,1,'ACT'),(140,53,2,'ACT'),(143,53,1,'ACT'),(144,53,1,'ACT'),(144,52,4,'ACT'),(146,53,1,'ACT'),(146,52,2,'ACT'),(147,53,7,'ACT'),(148,54,1,'ACT'),(149,53,2,'ACT'),(151,53,3,'ACT'),(152,60,1,'ACT'),(153,52,1,'ACT'),(154,60,1,'ACT'),(155,53,1,'ACT'),(156,60,1,'ACT'),(160,54,1,'ACT'),(160,64,1,'ACT');
/*!40000 ALTER TABLE `factura_has_inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_estados`
--

DROP TABLE IF EXISTS `historial_estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historial_estados` (
  `id_historial` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` int(11) NOT NULL,
  `estado_anterior` varchar(20) DEFAULT NULL,
  `estado_nuevo` varchar(20) NOT NULL,
  `fecha_cambio` datetime NOT NULL,
  `id_control` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_historial`),
  KEY `id_paciente` (`id_paciente`),
  KEY `id_control` (`id_control`),
  CONSTRAINT `historial_estados_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`),
  CONSTRAINT `historial_estados_ibfk_2` FOREIGN KEY (`id_control`) REFERENCES `control` (`id_control`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_estados`
--

LOCK TABLES `historial_estados` WRITE;
/*!40000 ALTER TABLE `historial_estados` DISABLE KEYS */;
INSERT INTO `historial_estados` VALUES (1,89,'CRONICO','CRONICO','2025-06-27 19:24:28',NULL,NULL);
/*!40000 ALTER TABLE `historial_estados` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospitalizacion`
--

LOCK TABLES `hospitalizacion` WRITE;
/*!40000 ALTER TABLE `hospitalizacion` DISABLE KEYS */;
INSERT INTO `hospitalizacion` VALUES (11,'2025-04-28 18:37:52',0,NULL,0,NULL,27,'0000-00-00 00:00:00','DES'),(12,'2025-04-28 18:42:13',0,NULL,0,NULL,26,'0000-00-00 00:00:00','DES'),(13,'2025-04-29 07:32:00',0,NULL,1,NULL,27,'0000-00-00 00:00:00','Realizadas'),(14,'2025-05-23 08:17:49',478692,4447.81,478692,4447.81,26,'2025-06-29 03:51:35','Realizada'),(15,'2025-06-10 20:20:19',0,0,0,0,29,'0000-00-00 00:00:00','DES'),(16,'2025-06-21 19:36:00',0,0,0,0,30,'0000-00-00 00:00:00','DES'),(17,'2025-06-21 19:48:25',0,0,0,0,30,'0000-00-00 00:00:00','DES'),(18,'2025-06-29 19:26:13',0,0,123,0,30,'2025-06-29 14:02:01','Realizada'),(19,'2025-06-29 20:11:25',1.88073,0.017475,1.88073,0.017475,30,'2025-06-29 14:11:37','Realizada'),(20,'2025-06-30 15:14:39',42.89,0.4,51.89,0.48,27,'2025-06-30 16:31:51','Realizada');
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
  `iva` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_insumo`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insumo`
--

LOCK TABLES `insumo` WRITE;
/*!40000 ALTER TABLE `insumo` DISABLE KEYS */;
INSERT INTO `insumo` VALUES (24,'','Paracetamol','El paracetamol, también conocido como acetaminofén o acetaminofeno, es un fármaco con propiedades analgésicas y antipiréticas utilizado principalmente para tratar la fiebre y el dolor leve y moderado','','',10.33,'DES',0,0),(25,'','Ibuprofeno','El ibuprofeno es un antinflamatorio no esteroideo (AINE) que pertenece al subgrupo de fármacos derivados del ácido propiónico.','','',17.90,'DES',0,0),(29,'2025-04-29_1745911425_WhatsApp Image 2025-04-03 at 11.51.47 PM.jpeg','Ibuprofeno','descripción','','',2.10,'DES',0,0),(30,'2025-05-02_1746200226_9amALQfcTkJsr2zlMRcpi99AnctFZBjlnRxibrip.jpg','Ibuprofeno','descripción','','',2.10,'DES',0,0),(31,'2025-05-02_1746216592_img27.jpg','Insumo','Es un antinflamatorio son derivados del ácido propiónico.','Tecno spar 30212 ','400 ml',29.56,'ACT',1,0),(32,'2025-05-05_1746489843_img23.jpg','Lobo','Es un lobo malvado','Tecno spar 30212 ','400 ml',0.60,'DES',1,0),(33,'2025-05-07_1746668110_img16.jpg','Spidermas','Es un antinflamatorio son derivados del ácido propiónico.','Tecno spar 30212 ','600 ml',123.00,'ACT',1,0),(34,'2025-05-08_1746714309_img5.jpg','Caballero','El ibuprofeno es un antinflamaupo de fármacos derivados del ácido propiónico.','Tecno spar 30212','600 ml',2040.00,'DES',1,0),(35,'2025-05-08_1746715177_img29.jpg','Insumodolar','Es un antinflamatorio son derivados del ácido propiónico.','Tecno spar 30212 ','200 ml',870.00,'DES',5,0),(36,'2025-06-21_1750492799_img30.png','Ansumo','El ibuprofeno e','Tecno spar 3022 ','400 ml',80.00,'ACT',2,0),(37,'2025-05-22_1747932563_img16.jpg','Spiderman','descripcio1','Spidermas','100 g',9.00,'ACT',1,0),(39,'2025-06-20_1750445529_4992462.jpg','Carlos','es un SO ','Microsoft','1 g',5.00,'ACT',1,0),(40,'2025-06-21_1750492468_Neon03.jpg','Disparador','es una descripcion','Lenovo','1 g',9.00,'ACT',5,0),(41,'2025-06-21_1750492543_Neon03.jpg','Disparador','es una descripcion','Lenovo','1 g',9.00,'ACT',5,0),(42,'2025-06-21_1750492723_1259289.jpg','Card','es una descripcion','Microsoft','1 g',8.00,'DES',5,0),(43,'2025-06-29_1751222978_img5.jpg','Julio','es un SO ','Microsoft','1 g',8.00,'ACT',1,1),(44,'2025-06-29_1751228448_img16.jpg','Preuva','es un SO ','Microsoft','1 g',2.80,'ACT',3,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insumodehospitalizacion`
--

LOCK TABLES `insumodehospitalizacion` WRITE;
/*!40000 ALTER TABLE `insumodehospitalizacion` DISABLE KEYS */;
INSERT INTO `insumodehospitalizacion` VALUES (13,16,58,1),(14,17,52,2),(15,18,60,1),(16,20,54,1);
/*!40000 ALTER TABLE `insumodehospitalizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `insumos_estadisticas`
--

DROP TABLE IF EXISTS `insumos_estadisticas`;
/*!50001 DROP VIEW IF EXISTS `insumos_estadisticas`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `insumos_estadisticas` AS SELECT
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
  `estado_salud` enum('SALUDABLE','ENFERMO','CRONICO') DEFAULT 'SALUDABLE',
  PRIMARY KEY (`id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente`
--

LOCK TABLES `paciente` WRITE;
/*!40000 ALTER TABLE `paciente` DISABLE KEYS */;
INSERT INTO `paciente` VALUES (23,'V','28150004','Juan','Silva','04121338031','Calle 10 entre 3 y 7','2001-09-22','masculino','ACT','SALUDABLE'),(24,'V','28329224','Rocio','Rodriguez','04121338031','URB EL BOSQUE CALLE 12','2025-04-02','femenino','ACT','SALUDABLE'),(25,'V','30554144','Carlos','Hernadéz','04121232343','Eb su casa','2012-02-11','masculino','ACT','SALUDABLE'),(26,'V','17664525','Sofia','Sofia','4121338031','Direccion','2001-09-22','','ACT','SALUDABLE'),(27,'V','158961','Aaaa','Aaaa','4121338032','Direccion','2001-09-22','Masculino','DES','SALUDABLE'),(28,'V','2000001','Argentina','Apellido_1','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(29,'V','2000002','Brasil','Apellido_2','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(30,'V','2000003','Chile','Apellido_3','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(31,'V','2000004','Colombia','Apellido_4','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(32,'V','2000005','México','Apellido_5','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(33,'V','2000006','Perú','Apellido_6','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(34,'V','2000007','Uruguay','Apellido_7','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(35,'V','2000008','Venezuela','Apellido_8','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(36,'V','2000009','Ecuador','Apellido_9','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(37,'V','2000010','Bolivia','Apellido_10','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(38,'V','2000011','Paraguay','Apellido_11','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(39,'V','2000012','Panamá','Apellido_12','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(40,'V','2000013','Costa Rica','Apellido_13','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(41,'V','2000014','Guatemala','Apellido_14','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(42,'V','2000015','El Salvador','Apellido_15','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(43,'V','2000016','Honduras','Apellido_16','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(44,'V','2000017','Nicaragua','Apellido_17','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(45,'V','2000018','Cuba','Apellido_18','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(46,'V','2000019','República Dominicana','Apellido_19','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(47,'V','2000020','Puerto Rico','Apellido_20','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(48,'V','2000021','Canadá','Apellido_21','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(49,'V','2000022','España','Apellido_22','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(50,'V','2000023','Francia','Apellido_23','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(51,'V','2000024','Italia','Apellido_24','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(52,'V','2000025','Alemania','Apellido_25','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(53,'V','2000026','Portugal','Apellido_26','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(54,'V','2000027','Grecia','Apellido_27','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(55,'V','2000028','Rusia','Apellido_28','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(56,'V','2000029','China','Apellido_29','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(57,'V','2000030','Japón','Apellido_30','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(58,'V','2000031','Corea del Sur','Apellido_31','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(59,'V','2000032','India','Apellido_32','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(60,'V','2000033','Australia','Apellido_33','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(61,'V','2000034','Nueva Zelanda','Apellido_34','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(62,'V','2000035','Egipto','Apellido_35','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(63,'V','2000036','Sudáfrica','Apellido_36','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(64,'V','2000037','Nigeria','Apellido_37','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(65,'V','2000038','Kenia','Apellido_38','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(66,'V','2000039','Senegal','Apellido_39','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(67,'V','2000040','Túnez','Apellido_40','04121338031','Dirección genérica','2000-01-01','femenino','ACT','SALUDABLE'),(68,'V','2000041','Argentina','Apellido_41','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(69,'V','2000042','Brasil','Apellido_42','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(70,'V','2000043','Chile','Apellido_43','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(71,'V','2000044','Colombia','Apellido_44','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(72,'V','2000045','México','Apellido_45','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(73,'V','2000046','Perú','Apellido_46','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(74,'V','2000047','Uruguay','Apellido_47','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(75,'V','2000048','Venezuela','Apellido_48','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(76,'V','2000049','Ecuador','Apellido_49','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(77,'V','2000050','Bolivia','Apellido_50','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(78,'V','2000051','Paraguay','Apellido_51','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(79,'V','2000052','Panamá','Apellido_52','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(80,'V','2000053','Costa Rica','Apellido_53','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(81,'V','2000054','Guatemala','Apellido_54','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(82,'V','2000055','El Salvador','Apellido_55','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(83,'V','2000056','Honduras','Apellido_56','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(84,'V','2000057','Nicaragua','Apellido_57','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(85,'V','2000058','Cuba','Apellido_58','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(86,'V','2000059','República Dominicana','Apellido_59','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(87,'V','2000060','Puerto Rico','Apellido_60','04121338031','Dirección genérica','2000-01-01','masculino','ACT','SALUDABLE'),(88,'V','1480973','Liam','Hendrick','04128649495','En su casa ','1997-06-28','Femenino','DES','SALUDABLE'),(89,'V','341234','Gol','Peterson','04123433454','California','2000-06-05','Masculino','ACT','CRONICO');
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
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagodefactura`
--

LOCK TABLES `pagodefactura` WRITE;
/*!40000 ALTER TABLE `pagodefactura` DISABLE KEYS */;
INSERT INTO `pagodefactura` VALUES (72,5,57,'',1000.00),(73,5,58,'',1000.00),(74,5,61,'1234',1000.00),(75,7,61,'1234',123.00),(76,5,62,'1221',100.00),(77,8,62,'1221',600.00),(78,6,62,'1221',300.00),(79,5,63,'1233',300.00),(80,8,63,'1233',300.00),(81,6,63,'1233',400.00),(82,5,64,'1334',100.00),(83,6,64,'1334',25.00),(84,5,65,'1334',100.00),(85,6,65,'1334',25.00),(86,5,66,'1223',25.00),(87,6,66,'1223',100.00),(88,5,67,'',415.00),(89,5,68,'',158.00),(90,5,69,'',330.00),(91,5,70,'',25.00),(92,5,71,'',430.00),(93,5,72,'',199.00),(94,5,73,'',58.00),(95,5,74,'',58.00),(96,5,75,'',58.00),(97,5,76,'',50.00),(98,5,77,'',75.00),(99,5,78,'',25.00),(100,5,79,'',123.96),(101,5,80,'',103.30),(102,5,81,'',123.96),(103,5,82,'',123.96),(104,5,83,'',10.33),(105,5,84,'',30.99),(106,7,84,'',0.00),(107,5,85,'',22.77),(108,5,86,'',16.55),(109,5,87,'',16.55),(110,5,88,'',125.30),(111,5,89,'',35.80),(112,5,90,'',17.90),(113,5,91,'2312',129.30),(114,8,91,'2312',1000.00),(115,6,91,'2312',1000.00),(116,5,92,'',1127.20),(117,8,92,'',0.00),(118,5,93,'',1123.00),(119,5,94,'',2.10),(120,6,94,'',0.00),(121,5,95,'1234',100.00),(122,6,95,'1234',82.12),(123,5,96,'7897',500.00),(124,6,96,'7897',500.00),(125,5,97,'',129.00),(126,5,98,'2321',1.00),(127,6,98,'2321',0.20),(128,5,99,'',29.56),(129,5,100,'',29.56),(130,5,101,'',0.60),(131,5,102,'',1230.00),(132,5,103,'',1.00),(133,5,104,'',1000.00),(134,5,105,'',1000.00),(135,5,106,'',1000.00),(136,5,107,'',3000.00),(137,5,108,'',80.00),(138,5,109,'1257',3000.00),(139,6,109,'1257',1000.00),(140,5,110,'',240.00),(141,5,111,'',240.00),(142,5,112,'',240.00),(143,5,113,'',240.00),(144,5,114,'',80.00),(145,5,115,'',80.00),(146,5,116,'',80.00),(147,5,117,'',9.00),(148,5,118,'',240.00),(149,5,119,'',63.00),(150,5,120,'',36.00),(151,5,121,'',80.00),(152,5,122,'',9.00),(153,5,123,'',240.00),(154,5,124,'',240.00),(155,5,125,'',240.00),(156,5,126,'',240.00),(157,5,127,'',240.00),(158,5,128,'',240.00),(159,5,129,'',240.00),(160,5,130,'',240.00),(161,5,131,'',240.00),(162,5,132,'',240.00),(163,5,133,'',240.00),(164,5,134,'',240.00),(165,5,135,'',240.00),(166,5,136,'',80.00),(167,5,137,'',80.00),(168,5,138,'',80.00),(169,5,139,'',80.00),(170,5,140,'',160.00),(171,5,141,'',36.00),(172,5,142,'',80.00),(173,5,143,'',80.00),(174,5,144,'',116.00),(175,5,145,'',80.00),(176,5,146,'',98.00),(177,5,147,'',560.00),(178,5,148,'',9.00),(179,5,149,'',160.00),(180,5,150,'',1000.00),(181,5,151,'',240.00),(182,6,152,'1234',29.56),(183,5,153,'',9.00),(184,5,154,'',29.56),(185,6,154,'',0.00),(186,5,155,'4326',200.00),(187,6,155,'4326',880.00),(188,5,156,'',29.56),(189,5,157,'',478692.00),(190,5,158,'',123.00),(191,5,159,'',1.88),(192,5,160,'',17.00),(193,5,161,'',3000.00),(194,5,162,'',6000.00),(195,5,163,'',6000.00),(196,5,164,'',6000.00),(197,5,165,'',6000.00),(198,5,166,'',6000.00),(199,5,167,'',6000.00),(200,5,168,'',6000.00),(201,5,169,'',6000.00),(202,5,170,'',6000.00),(203,5,171,'',6000.00),(204,5,172,'',6000.00),(205,5,173,'3000',32.00),(206,6,173,'3000',19.89);
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
INSERT INTO `patologia` VALUES (2,'DIABETES TIPO 1','DES'),(3,'DIABETES TIPO 2','DES'),(5,'EPOC','ACT'),(6,'ARTRITIS REUMATOIDE','ACT'),(7,'ENFERMEDAD CELÍACA','ACT'),(8,'OBESIDAD','ACT'),(9,'DEPRESIÓN','ACT'),(10,'ANSIEDAD','ACT'),(11,'ENFERMEDAD DE CROHN','ACT'),(12,'COLITIS ULCEROSA','ACT'),(13,'ASMA','1'),(14,'Patologia','ACT'),(15,'Algo','ACT'),(16,'HIPERTIROIDISMO','ACT'),(17,'OSTEOPOROSIS','ACT'),(18,'EPILEPSIA','ACT'),(19,'MIGRAÑA','ACT'),(20,'ALZHEIMER','ACT'),(44,'HEPATITIS B','ACT'),(186,'Hipertensión','ACT'),(189,'Bronquitis','ACT'),(190,'Neumonía','ACT'),(191,'Migraña','ACT'),(192,'Gastritis','ACT'),(193,'Hepatitis A','ACT'),(194,'Hepatitis B','ACT'),(195,'Anemia','ACT'),(196,'Artritis','ACT'),(197,'Obesidad','ACT'),(198,'Epilepsia','ACT'),(199,'Depresión','ACT'),(200,'Ansiedad','ACT'),(201,'Dermatitis','ACT'),(202,'Sinusitis','ACT'),(203,'COVID-19','ACT'),(204,'Tuberculosis','ACT'),(205,'Insuficiencia renal','ACT');
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
) ENGINE=InnoDB AUTO_INCREMENT=239 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patologiadepaciente`
--

LOCK TABLES `patologiadepaciente` WRITE;
/*!40000 ALTER TABLE `patologiadepaciente` DISABLE KEYS */;
INSERT INTO `patologiadepaciente` VALUES (16,23,13,'2025-04-02 20:13:12'),(17,23,13,'2025-04-02 20:13:46'),(18,26,15,'2025-05-15 17:26:49'),(19,26,13,'2025-05-15 18:18:42'),(20,24,13,'2025-05-15 18:18:51'),(21,25,13,'2025-05-15 18:18:51'),(102,25,5,'2025-04-01 10:15:00'),(157,28,8,'2025-04-03 09:30:00'),(176,70,20,'2025-04-20 16:30:00'),(177,67,18,'2025-04-18 14:15:00'),(178,49,17,'2025-04-17 13:05:00'),(179,55,16,'2025-04-16 11:35:00'),(180,47,13,'2025-04-15 10:10:00'),(181,48,15,'2025-04-14 09:45:00'),(183,28,11,'2025-04-12 08:50:00'),(193,23,9,'2025-04-11 17:00:00'),(194,27,2,'2025-04-10 12:00:00'),(195,27,6,'2025-04-09 15:25:00'),(196,48,10,'2025-04-08 10:40:00'),(202,29,14,'2025-04-06 16:00:00'),(207,28,8,'2025-04-03 09:30:00'),(208,26,3,'2025-04-04 11:20:00'),(209,62,6,'2025-05-15 19:42:53'),(210,59,20,'2025-05-15 19:43:28'),(211,60,11,'2025-05-15 19:43:28'),(212,87,2,'2025-05-15 19:43:56'),(213,38,191,'2025-05-15 19:43:56'),(214,87,20,'2025-05-15 19:44:11'),(215,86,7,'2025-05-15 19:44:11'),(216,29,205,'2025-05-15 19:44:21'),(217,23,18,'2025-05-15 19:44:21'),(218,51,14,'2025-05-15 19:44:51'),(219,58,14,'2025-05-15 19:44:51'),(220,46,14,'2025-05-15 19:45:12'),(221,35,9,'2025-05-15 19:45:12'),(222,25,6,'2025-06-10 10:11:51'),(223,25,8,'2025-06-10 10:11:51'),(224,25,5,'2025-06-10 20:07:54'),(225,25,6,'2025-06-10 20:07:54'),(226,25,7,'2025-06-10 20:07:54'),(227,25,8,'2025-06-10 20:07:54'),(228,25,9,'2025-06-10 20:07:54'),(229,25,5,'2025-06-19 20:29:30'),(230,25,6,'2025-06-19 20:29:30'),(231,25,7,'2025-06-19 20:29:30'),(232,25,8,'2025-06-19 20:29:30'),(233,25,9,'2025-06-19 20:29:30'),(234,25,186,'2025-06-19 20:29:30'),(235,25,190,'2025-06-19 20:29:30'),(236,25,192,'2025-06-19 20:29:30'),(237,89,5,'2025-06-27 19:24:28'),(238,89,7,'2025-06-27 19:24:28');
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal`
--

LOCK TABLES `personal` WRITE;
/*!40000 ALTER TABLE `personal` DISABLE KEYS */;
INSERT INTO `personal` VALUES (18,'V','30554053','Wilmer','Baez','04145378608','Administrador',NULL,1),(19,'V','1232233','David','Carlos','04142323233','',7,42),(20,'V','12123343','Carlos','Garcia','04244546565','',7,43),(21,'V','12020333','Ana','Bracho','04122323422','',6,45),(22,'V','6755654','Julian','Valdez','04122323212','',4,46),(23,'V','867548','Jaun','Edlkfjfdsk','04243943432','',5,49),(24,'V','1223211','Auto','Auto','04122232323','Administrador',NULL,50),(25,'V','5675324','Alen','Alenrere','04123434343','Administrador',NULL,51);
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
INSERT INTO `personal_has_serviciomedico` VALUES (18,25),(19,24),(19,26),(19,29),(19,30),(19,32),(19,33),(19,36),(20,24),(20,27),(20,28),(20,31);
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
  `tipo` varchar(25) NOT NULL,
  PRIMARY KEY (`id_servicioMedico`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `serviciomedico_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_servicio` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `serviciomedico`
--

LOCK TABLES `serviciomedico` WRITE;
/*!40000 ALTER TABLE `serviciomedico` DISABLE KEYS */;
INSERT INTO `serviciomedico` VALUES (22,9,2200.00,'ACT','Examenes'),(23,100,1500.00,'ACT','Cita'),(24,1,3000.00,'ACT','Cita'),(25,101,1000.00,'ACT','Examenes'),(26,2,123.00,'DES',''),(27,2,123.00,'DES',''),(28,1,31395.00,'DES',''),(29,1,16905.00,'DES',''),(30,1,169.05,'DES',''),(31,101,12.00,'DES',''),(32,1,479.78,'DES',''),(33,100,1.07,'DES',''),(34,104,24.95,'ACT','Cita'),(35,103,60.66,'ACT','Cita'),(36,102,46.81,'ACT','Cita'),(37,105,5.48,'ACT','Examenes');
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
  `doctor` int(11) NOT NULL,
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
INSERT INTO `serviciomedico_has_factura` VALUES (25,58,0),(26,61,0),(25,61,0),(25,62,0),(25,63,0),(25,91,0),(26,91,0),(25,91,0),(25,92,0),(26,92,0),(25,93,0),(26,93,0),(27,95,0),(25,96,0),(26,97,0),(25,104,0),(25,105,0),(25,106,0),(24,107,0),(24,109,0),(25,109,0),(25,150,0),(25,155,0),(24,170,19),(24,170,20),(24,171,19),(24,171,20),(24,172,19),(24,172,20);
/*!40000 ALTER TABLE `serviciomedico_has_factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicios_hospitalizacion`
--

DROP TABLE IF EXISTS `servicios_hospitalizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicios_hospitalizacion` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `id_hospitalizacion` int(11) NOT NULL,
  `id_servicioMedico` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `id_hospitalizacion` (`id_hospitalizacion`,`id_servicioMedico`),
  KEY `id_servicioMedico` (`id_servicioMedico`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicios_hospitalizacion`
--

LOCK TABLES `servicios_hospitalizacion` WRITE;
/*!40000 ALTER TABLE `servicios_hospitalizacion` DISABLE KEYS */;
INSERT INTO `servicios_hospitalizacion` VALUES (9,34,25,1),(10,35,25,1),(11,39,25,2),(12,40,25,2),(14,41,25,1),(15,42,25,1);
/*!40000 ALTER TABLE `servicios_hospitalizacion` ENABLE KEYS */;
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
INSERT INTO `sintomas` VALUES (5,'Disnea','DES'),(6,'Fiebre','ACT'),(7,'Vomito','DES'),(8,'Dolor de cabeza','ACT'),(9,'Malestar general','ACT'),(10,'Inchazon','ACT'),(11,'Enrojecimiento','ACT'),(12,'Piel Amarilla','ACT'),(13,'Dolor de higado','ACT'),(14,'Encias sangrantes','ACT'),(15,'sintoma','DES');
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
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sintomas_control`
--

LOCK TABLES `sintomas_control` WRITE;
/*!40000 ALTER TABLE `sintomas_control` DISABLE KEYS */;
INSERT INTO `sintomas_control` VALUES (37,5,26),(38,10,26),(39,8,26),(40,8,27),(41,9,27),(42,7,27),(43,5,28),(44,6,28),(45,7,28),(46,5,29),(47,6,29),(48,8,29),(49,5,30),(50,6,30),(51,6,31),(52,8,31);
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
-- Dumping events for database 'bd'
--

--
-- Dumping routines for database 'bd'
--
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `DescontarLotes` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `DescontarLotes`(IN `insumo_id` INT, IN `cantidad_requerida` INT)
BEGIN







    DECLARE cantidad_restante INT DEFAULT cantidad_requerida;







    DECLARE lote_id INT;







    DECLARE lote_cantidad INT;















    DECLARE done INT DEFAULT FALSE;







    DECLARE lote_cursor CURSOR FOR







        SELECT ei.id_entradaDeInsumo, ei.cantidad_disponible







        FROM entrada_insumo ei INNER JOIN entrada e 







        ON e.id_entrada = ei.id_entrada







        WHERE ei.id_insumo = insumo_id AND ei.cantidad_disponible > 0







        ORDER BY e.fechaDeIngreso ASC; 














    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;















    OPEN lote_cursor;















    lectura_lote: LOOP







        FETCH lote_cursor INTO lote_id, lote_cantidad;







        IF done THEN







            LEAVE lectura_lote;







        END IF;















        IF cantidad_restante <= lote_cantidad THEN







            UPDATE entrada_insumo







            SET cantidad_disponible = cantidad_disponible - cantidad_restante







            WHERE id_entradaDeInsumo = lote_id;







            SET cantidad_restante = 0;







            LEAVE lectura_lote;







        ELSE







            UPDATE entrada_insumo







            SET cantidad_disponible = 0







            WHERE id_entradaDeInsumo = lote_id;







            SET cantidad_restante = cantidad_restante - lote_cantidad;







        END IF;







    END LOOP;















    CLOSE lote_cursor;







END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `devolver_cantidad_insumos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `devolver_cantidad_insumos`(IN `id_factura` INT)
BEGIN







    DECLARE done INT DEFAULT FALSE;







    DECLARE entrada_id INT; 






    DECLARE cantidad_en_factura  INT;















    






    DECLARE insumo_cursor CURSOR FOR 







        SELECT id_entradaDeInsumo, cantidad FROM bd.factura_has_inventario WHERE factura_id_factura = id_factura;















    






    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;















    






    OPEN insumo_cursor;















    






    read_loop: LOOP







        FETCH insumo_cursor INTO entrada_id, cantidad_en_factura;















        IF done THEN







            LEAVE read_loop; 






        END IF;







        







        update bd.entrada_insumo set cantidad_disponible = cantidad_disponible + cantidad_en_factura where id_entradaDeInsumo = entrada_id;







    END LOOP;















    






    CLOSE insumo_cursor;







END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `devolver_insumos_hospitalizacion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `devolver_insumos_hospitalizacion`(IN `p_id_insumo` INT, IN `p_cantidad` INT)
BEGIN

    DECLARE v_idEntrada INT;



    

    SELECT ei.id_entradaDeInsumo

    INTO v_idEntrada

    FROM entrada_insumo ei

    WHERE ei.id_insumo = p_id_insumo

    ORDER BY ei.fechaDeVencimiento DESC

    LIMIT 1;



    

    UPDATE entrada_insumo

    SET cantidad_disponible = p_cantidad

    WHERE id_entradaDeInsumo = v_idEntrada;



    

    SELECT v_idEntrada AS idEntrada_actualizada;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insert_entrada` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_entrada`(IN `id_insumo` INT, IN `id_proveedor` INT, IN `fechaDeIngreso` DATE, IN `fechaDeVecimiento` DATE, IN `precio` FLOAT, IN `cantidad` INT, IN `lote` TEXT)
BEGIN







    declare id_entrada int;







    







    INSERT INTO entrada VALUES (null, id_proveedor, lote, fechaDeIngreso, 'ACT');







    set id_entrada =  last_insert_id();







    







    INSERT INTO entrada_insumo VALUES (null, id_insumo, id_entrada,fechaDeVecimiento,precio, cantidad, cantidad);







END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insert_insumo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_insumo`(IN `imagen` TEXT, IN `nombre` TEXT, IN `id_proveedor` INT, IN `descripcion` TEXT, IN `fechaDeIngreso` DATE, IN `fechaDeVecimiento` DATE, IN `precio` FLOAT, IN `cantidad` INT, IN `stockMinimo` INT, IN `lote` TEXT, IN `marca` TEXT, IN `medida` TEXT, IN `iva` BOOLEAN)
BEGIN







	declare id_insumo int;







    declare id_entrada int;







    







	INSERT INTO insumo VALUES (null, imagen, nombre, descripcion, marca, medida, precio , 'ACT',stockMinimo, iva);







    set id_insumo = last_insert_id();







    







    INSERT INTO entrada VALUES (null, id_proveedor, lote, fechaDeIngreso, 'ACT');







    set id_entrada =  last_insert_id();







    







    INSERT INTO entrada_insumo VALUES (null, id_insumo, id_entrada,fechaDeVecimiento,precio, cantidad, cantidad);







END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
-- Final view structure for view `insumos_estadisticas`
--

/*!50001 DROP VIEW IF EXISTS `insumos_estadisticas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `insumos_estadisticas` AS select `i`.`nombre` AS `nombre_insumo`,sum(`fhi`.`cantidad`) AS `total_usado` from ((`factura_has_inventario` `fhi` join `entrada_insumo` `inv` on(`fhi`.`id_entradaDeInsumo` = `inv`.`id_entradaDeInsumo`)) join `insumo` `i` on(`inv`.`id_insumo` = `i`.`id_insumo`)) group by `i`.`id_insumo` order by sum(`fhi`.`cantidad`) desc */;
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

-- Dump completed on 2026-03-04 14:02:14
