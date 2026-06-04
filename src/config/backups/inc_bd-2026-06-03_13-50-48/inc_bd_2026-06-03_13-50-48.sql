-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: bd
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `categoria_servicio`
--

LOCK TABLES `categoria_servicio` WRITE;
/*!40000 ALTER TABLE `categoria_servicio` DISABLE KEYS */;
INSERT INTO `categoria_servicio` VALUES (1,'CARDIOLOGIA','ACT'),(2,'ONCOLOGIA','ACT'),(9,'RADIOGRAFIA','DES'),(100,'CONSULTA GENERAL','ACT'),(101,'Emergencia','ACT'),(102,'Acupuntura','ACT'),(103,'Oftalmología','ACT'),(104,'Odontología','ACT'),(105,'Hello','ACT'),(106,'Categorizacion','DES'),(109,'Xxx','ACT');
/*!40000 ALTER TABLE `categoria_servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `cita`
--

LOCK TABLES `cita` WRITE;
/*!40000 ALTER TABLE `cita` DISABLE KEYS */;
INSERT INTO `cita` VALUES (41,'2025-04-02','12:33:00','ACT',24,23,'00:00:00',0),(42,'2025-04-02','12:33:00','ACT',25,23,'00:00:00',0),(43,'2025-04-02','12:33:00','ACT',22,23,'00:00:00',0),(44,'2025-04-02','12:33:00','ACT',22,23,'00:00:00',0),(45,'2025-04-21','22:00:00','Realizadas',26,25,'00:00:00',0),(46,'2025-04-25','12:00:00','Pendiente',27,25,'00:00:00',0),(47,'2025-05-05','20:00:00','Realizadas',26,25,'00:00:00',0),(48,'2025-05-12','20:00:00','Pendiente',26,23,'00:00:00',0),(49,'2025-06-02','20:00:00','Pendiente',24,25,'21:00:00',0),(50,'2025-06-02','21:00:00','Pendiente',24,25,'21:00:00',0),(51,'2025-06-02','22:00:00','Pendiente',24,25,'22:05:00',0),(52,'2025-06-02','22:10:00','Pendiente',24,25,'23:05:00',0),(53,'2025-06-09','20:00:00','Pendiente',24,25,'21:05:00',0),(54,'2025-06-09','21:11:00','Pendiente',24,25,'22:05:00',0),(55,'2025-06-16','20:00:00','Pendiente',24,34,'21:06:00',0),(56,'2025-06-20','10:05:00','Pendiente',24,25,'11:06:00',0),(57,'2025-06-27','10:00:00','Pendiente',24,25,'11:06:00',0),(58,'2025-06-27','11:07:00','Pendiente',24,25,'12:06:00',0),(59,'2025-06-27','12:07:00','Pendiente',24,25,'13:06:00',0),(60,'2025-07-04','10:00:00','Pendiente',24,25,'11:06:00',0),(61,'2025-07-04','11:07:00','Pendiente',24,25,'12:06:00',0),(62,'2025-07-11','10:00:00','Pendiente',24,25,'11:06:00',0),(63,'2025-07-28','20:00:00','Pendiente',24,25,'21:06:00',19),(64,'2025-07-25','10:00:00','Pendiente',24,25,'11:06:00',20),(65,'2025-09-29','20:00:00','Pendiente',24,25,'21:09:00',19),(66,'2025-10-20','20:00:00','DES',24,25,'21:10:00',19),(67,'2025-10-24','10:01:00','Realizadas',24,25,'11:10:00',20),(68,'2025-10-06','20:00:00','Pendiente',24,25,'21:10:00',19),(69,'2025-10-27','20:00:00','Realizadas',24,25,'21:10:00',19),(70,'2025-10-06','20:00:00','Pendiente',24,25,'21:11:00',19),(71,'2026-03-30','20:00:00','Pendiente',24,25,'21:00:00',19),(72,'2026-03-31','14:00:00','Pendiente',25,104,'15:00:00',22);
/*!40000 ALTER TABLE `cita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'V','12098234','Jose','Lara','04123213212','esuna direccion','2005-10-02','Masculino','ACT'),(2,'V','2000002','Editado','Modificado','04123454320','en su casa','2002-02-20','Masculino','ACT'),(3,'V','3722999','Pedro','Perez','04123454327','en su casa','2002-02-20','Masculino','ACT'),(4,'V','30554144','Carlos','Hernadéz','04121232343','Eb su casa','2012-02-11','Masculino','ACT');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `control`
--

LOCK TABLES `control` WRITE;
/*!40000 ALTER TABLE `control` DISABLE KEYS */;
INSERT INTO `control` VALUES (26,23,1,'El chico presenta dificultad para respirar, hinchazón en el cuerpo y dolores de cabeza','Cetirizina\r\nSalbutamol\r\nAcetaminofén','2025-04-02 14:37:34','2025-04-26','Debe hacerse hematología completa','2wd','ACT','LEVE'),(27,24,1,'La paciente presenta severos dolores de cabeza, lo cual da a entender que tiene episodios de jaqueca, a su vez también presenta problemas con la visión y mareos\r\nTomar mucha agua','Diclofenac potasicoCafeínaViajesan','2025-04-02 14:45:09','2025-04-23','Tomar mucha agua','Historia bbba','ACT','LEVE'),(28,25,43,'diagnostico','indicaciones','2025-06-10 10:11:51','2026-06-24','nota','historial\r\n\r\n','ACT','LEVE'),(29,25,42,'jfsdjfsdnfds','indicaciones','2025-06-10 20:07:54','2026-06-18','alguito','mhnfdjg algo mas','ACT','LEVE'),(30,25,43,'diagnostivo','indicaciones','2025-06-19 20:29:30','2025-07-06','nota','historial clinico  de algo no se','ACT','LEVE'),(31,89,42,'este enfermedad crónica','es una indicacion','2025-06-27 19:24:28','2025-06-29','es una nota','este en un historialssskjklk','ACT','LEVE'),(32,25,43,'dgdgdgff','gdfgd','2025-09-25 20:24:37','2025-10-12','fghfh','sddsds','ACT','LEVE'),(33,25,1,'diagnostico','indicaciones','2025-10-03 11:23:02','2025-11-01','nota','historial','ACT','LEVE'),(34,25,1,'diagnostico','indicaciones','2025-10-03 11:23:41','2025-11-01','nota editada','historial','ACT','LEVE'),(40,25,43,'diagnostico','sqssssas','2025-10-30 20:12:15','2025-10-31','sqssa','historialsaaaaaasdaslñq','ACT','LEVE'),(41,25,46,'sidasd','','2025-11-01 11:30:10','0000-00-00','','historial','DES','LEVE'),(42,26,46,'fewefewf3r','w3r3w','2025-11-03 14:22:41','2025-11-04','r3wr','edqwdwefw','ACT','MODERADA'),(43,102,43,'dcsdcsdc','dcsdc','2025-11-03 14:37:35','2025-11-11','zd','dcsdcsd','ACT','LEVE'),(44,23,42,':diagnostico',':indicaciones','2025-11-03 14:48:38','2025-11-22',':nota',':histoarial','ACT','LEVE'),(45,102,1,'sdasd','asdas','2025-11-03 15:00:02','2025-11-11','sadas','wdawd','ACT','LEVE'),(46,102,1,'sdakjk','sdakjsjd','2025-11-03 15:01:59','2025-11-04','skadaksd','sadsd','ACT','LEVE'),(47,102,42,'efwfe','efwef','2025-11-03 17:12:57','2025-11-22','edwe','fewf','ACT','LEVE'),(48,102,1,'jkjhjkjkjk','jkjjkjk','2025-11-03 17:15:47','2025-11-19','hjhjhjjhjhj','jkjjkjk','ACT','LEVE'),(49,102,46,'jkhhuhu','hjhjhj','2025-11-03 17:18:04','2025-11-19','bkkuk','hhjhjhjsiiiiioijoijiiojjjjjjjjj','ACT','LEVE'),(50,102,1,'cdsdcsd','vfvffvfv','2025-11-03 17:32:51','2025-11-26','cds','vfvf','ACT','LEVE'),(51,102,43,'xwxxw','xwxwxw','2025-11-03 17:34:08','2025-11-26','wxqx','xwxqx','ACT','MODERADA'),(52,102,1,'nmnmmnmn','m,m,m,m,mnmn','2025-11-03 17:43:31','2025-11-14','mhhhj','mnmnmn','ACT','LEVE'),(53,102,1,'pppppp','pppppp','2025-11-04 10:07:56','2025-11-12','ppppppp','ppppp','ACT','LEVE'),(54,102,43,'dcsdf','dsfsdf','2025-11-04 13:11:48','2025-11-27','kdslkdl','dfsf','ACT','MODERADA'),(55,102,46,'wdddw','swssw','2025-11-04 13:37:49','2025-12-05','swsws','dfsfwd','DES','LEVE');
/*!40000 ALTER TABLE `control` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `detalle_factura`
--

LOCK TABLES `detalle_factura` WRITE;
/*!40000 ALTER TABLE `detalle_factura` DISABLE KEYS */;
INSERT INTO `detalle_factura` VALUES (1,197,'',1,1000.00,1000.00,NULL,25,NULL),(2,198,'Servicio',1,1000.00,1000.00,NULL,25,NULL),(3,199,'Servicio',1,1000.00,1000.00,NULL,25,NULL),(4,200,'Servicio',1,1000.00,1000.00,NULL,25,NULL),(5,204,'Insumo',1,80.00,80.00,NULL,NULL,53),(6,207,'Servicio',1,3000.00,3000.00,NULL,24,NULL),(7,208,'Hospitalizacion',1,474844.00,474844.00,27,NULL,NULL),(8,209,'Insumo',3,80.00,240.00,NULL,NULL,53),(9,210,'Insumo',1,9.00,9.00,NULL,NULL,52),(10,210,'Insumo',2,9.00,18.00,NULL,NULL,54),(11,211,'Servicio',1,1000.00,1000.00,NULL,25,NULL),(12,211,'Insumo',1,80.00,80.00,NULL,NULL,53),(13,211,'Insumo',1,9.00,9.00,NULL,NULL,54),(14,211,'Insumo',1,5.60,5.60,NULL,NULL,64);
/*!40000 ALTER TABLE `detalle_factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `entrada`
--

LOCK TABLES `entrada` WRITE;
/*!40000 ALTER TABLE `entrada` DISABLE KEYS */;
INSERT INTO `entrada` VALUES (38,6,1,'2025-04-05','ACT'),(39,7,2,'2025-04-06','ACT'),(40,6,3435,'2025-04-21','ACT'),(41,6,3435,'2025-04-21','ACT'),(42,7,3456,'2025-04-21','ACT'),(43,6,1233,'2025-04-21','ACT'),(44,7,3232,'2025-04-29','ACT'),(45,7,3232,'2025-04-29','ACT'),(46,7,3232,'2025-04-29','ACT'),(47,7,3232,'2025-04-29','ACT'),(48,6,3232,'2025-05-02','ACT'),(49,7,1212,'2025-05-02','ACT'),(50,6,2334,'2025-05-02','ACT'),(51,7,2323,'2025-05-05','ACT'),(52,7,4553,'2025-05-05','ACT'),(53,7,4553,'2025-05-05','DES'),(54,7,2323,'2025-05-07','ACT'),(55,6,2323,'2025-05-08','ACT'),(56,6,2323,'2025-05-08','ACT'),(57,6,1212,'2025-05-08','ACT'),(58,6,5664,'2025-05-22','ACT'),(59,7,8098,'2025-06-10','ACT'),(61,7,5656,'2025-06-20','ACT'),(62,7,1234,'2025-06-21','ACT'),(63,6,5651,'2025-06-21','ACT'),(64,7,2134,'2025-06-21','ACT'),(65,7,2134,'2025-06-21','ACT'),(66,6,2134,'2025-06-21','DES'),(67,7,3012,'2025-06-21','ACT'),(68,7,4532,'2025-06-21','ACT'),(69,7,2342,'2025-06-21','ACT'),(70,7,1223,'2025-06-21','ACT'),(71,6,4564,'2025-06-21','ACT'),(72,7,5656,'2025-06-29','ACT'),(73,7,5656,'2025-06-29','ACT'),(74,6,123456789,'2025-01-01','ACT'),(75,6,123456789,'2025-10-03','ACT'),(76,6,12345679,'2025-10-03','DES'),(77,7,8099,'2025-10-09','DES'),(78,6,1212,'2026-06-02','ACT');
/*!40000 ALTER TABLE `entrada` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `entrada_insumo`
--

LOCK TABLES `entrada_insumo` WRITE;
/*!40000 ALTER TABLE `entrada_insumo` DISABLE KEYS */;
INSERT INTO `entrada_insumo` VALUES (52,37,58,'2025-05-25',9.00,89,67),(53,36,59,'2026-02-11',750000.00,34,3),(54,41,62,'2026-06-29',9.00,20,11),(55,42,63,'2025-06-27',8.00,12,12),(56,36,64,'2026-06-21',12.00,1,1),(57,36,65,'2026-06-21',12.00,1,1),(58,31,66,'2026-06-21',12.00,1,0),(59,37,67,'2025-06-29',13.00,2,2),(60,31,68,'2027-06-21',120.00,9,0),(61,41,69,'2025-06-29',12.00,5,5),(62,36,70,'2025-06-29',12.00,2,2),(63,36,71,'2025-06-29',190.00,1,1),(64,43,72,'2026-07-06',8.00,12,9),(65,44,73,'2027-06-30',2.80,12,0),(66,45,74,'2025-12-31',100.00,50,50),(67,44,75,'2025-12-29',100.00,1,1),(68,44,76,'2025-12-31',100.00,1,1),(69,36,77,'2026-02-11',7900.00,34,34),(70,46,78,'2026-07-01',1.00,10,10);
/*!40000 ALTER TABLE `entrada_insumo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `especialidad`
--

LOCK TABLES `especialidad` WRITE;
/*!40000 ALTER TABLE `especialidad` DISABLE KEYS */;
INSERT INTO `especialidad` VALUES (3,'Cardiología','ACT'),(4,'Paramedico','ACT'),(5,'Enfermeria','ACT'),(6,'administrador','DES'),(7,'Cirugia','ACT'),(8,'Especialidad','DES');
/*!40000 ALTER TABLE `especialidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
INSERT INTO `factura` VALUES (109,'2025-06-15',4000.00,'ACT',1),(110,'2025-06-16',240.00,'ACT',1),(111,'2025-06-16',240.00,'ACT',1),(112,'2025-06-16',240.00,'ACT',1),(113,'2025-06-16',240.00,'ACT',1),(114,'2025-06-16',80.00,'ACT',1),(115,'2025-06-16',80.00,'ACT',1),(116,'2025-06-16',80.00,'ACT',1),(117,'2025-06-16',9.00,'ACT',1),(118,'2025-06-16',240.00,'ACT',1),(119,'2025-06-16',63.00,'ACT',1),(120,'2025-06-16',36.00,'ACT',1),(121,'2025-06-16',80.00,'ACT',1),(122,'2025-06-16',9.00,'ACT',1),(123,'2025-06-16',240.00,'ACT',1),(124,'2025-06-16',240.00,'ACT',1),(125,'2025-06-16',240.00,'ACT',1),(126,'2025-06-16',240.00,'ACT',1),(127,'2025-06-16',240.00,'ACT',1),(128,'2025-06-16',240.00,'ACT',1),(129,'2025-06-16',240.00,'ACT',1),(130,'2025-06-16',240.00,'ACT',1),(131,'2025-06-16',240.00,'ACT',1),(132,'2025-06-16',240.00,'ACT',1),(133,'2025-06-16',240.00,'ACT',1),(134,'2025-06-17',240.00,'ACT',1),(135,'2025-06-17',240.00,'ACT',1),(136,'2025-06-17',80.00,'ACT',1),(137,'2025-06-18',80.00,'ACT',1),(138,'2025-06-18',80.00,'ACT',1),(139,'2025-06-18',80.00,'ACT',1),(140,'2025-06-18',160.00,'ACT',1),(141,'2025-06-18',36.00,'ACT',1),(142,'2025-06-18',80.00,'ACT',1),(143,'2025-06-18',80.00,'ACT',1),(144,'2025-06-18',116.00,'ACT',1),(145,'2025-06-18',80.00,'ACT',1),(146,'2025-06-18',98.00,'ACT',1),(147,'2025-06-19',560.00,'ACT',1),(148,'2025-06-21',9.00,'ACT',1),(149,'2025-06-21',160.00,'ACT',1),(150,'2025-06-22',1000.00,'ACT',1),(151,'2025-06-22',240.00,'Anulada',1),(152,'2025-06-24',29.56,'ACT',1),(153,'2025-06-27',9.00,'ACT',1),(154,'2025-06-28',29.56,'Anulada',1),(155,'2025-06-28',1080.00,'ACT',1),(156,'2025-06-28',29.56,'ACT',1),(157,'2025-06-29',478692.00,'ACT',1),(158,'2025-06-29',123.00,'ACT',1),(159,'2025-06-29',1.88,'ACT',1),(160,'2025-06-29',17.00,'ACT',1),(161,'2025-06-30',3000.00,'ACT',1),(162,'2025-06-30',6000.00,'ACT',1),(163,'2025-06-30',6000.00,'ACT',1),(164,'2025-06-30',6000.00,'ACT',1),(165,'2025-06-30',6000.00,'ACT',1),(166,'2025-06-30',6000.00,'ACT',1),(167,'2025-06-30',6000.00,'ACT',1),(168,'2025-06-30',6000.00,'ACT',1),(169,'2025-06-30',6000.00,'ACT',1),(170,'2025-06-30',6000.00,'ACT',1),(171,'2025-06-30',6000.00,'ACT',1),(172,'2025-06-30',6000.00,'ACT',1),(173,'2025-06-30',51.89,'ACT',1),(174,'2025-09-14',570.33,'ACT',1),(175,'2025-09-25',29.56,'Anulada',1),(176,'2025-09-26',160.00,'ACT',1),(177,'2025-09-26',1018.00,'ACT',1),(178,'2025-09-26',29.56,'ACT',1),(179,'2025-09-27',1000.00,'ACT',1),(180,'2025-10-02',1000.00,'ACT',1),(181,'2025-10-02',1000.00,'ACT',1),(182,'2025-10-02',1080.00,'ACT',1),(183,'2025-10-13',246.12,'ACT',1),(184,'2025-10-13',1000.00,'ACT',1),(185,'2025-10-19',1000.00,'ACT',1),(186,'2025-10-19',1000.00,'ACT',1),(187,'2025-10-19',1000.00,'ACT',1),(188,'2025-10-19',1000.00,'ACT',1),(189,'2025-10-19',1000.00,'ACT',1),(190,'2025-10-19',1000.00,'ACT',1),(191,'2025-10-19',1000.00,'ACT',1),(192,'2025-10-19',1000.00,'ACT',1),(193,'2025-10-19',1000.00,'ACT',1),(194,'2025-10-19',1000.00,'ACT',1),(195,'2025-10-19',1000.00,'ACT',1),(196,'2025-10-19',1000.00,'ACT',1),(197,'2025-10-19',1000.00,'ACT',1),(198,'2025-10-19',1000.00,'ACT',1),(199,'2025-10-19',1000.00,'ACT',1),(200,'2025-10-19',1000.00,'ACT',1),(202,'2025-10-20',80.00,'ACT',4),(203,'2025-10-20',80.00,'ACT',4),(204,'2025-10-20',80.00,'ACT',4),(205,'2025-10-24',3000.00,'ACT',4),(206,'2025-10-24',3000.00,'ACT',4),(207,'2025-10-27',3000.00,'ACT',4),(208,'2025-10-20',474874.00,'ACT',4),(209,'2025-10-21',240.00,'ACT',4),(210,'2025-10-21',27.00,'ACT',4),(211,'2025-10-22',1094.60,'ACT',4);
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `horario`
--

LOCK TABLES `horario` WRITE;
/*!40000 ALTER TABLE `horario` DISABLE KEYS */;
INSERT INTO `horario` VALUES (8,'domingo'),(9,'lunes'),(10,'martes'),(11,'miércoles'),(12,'jueves'),(13,'viernes'),(14,'sábado');
/*!40000 ALTER TABLE `horario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `horarioydoctor`
--

LOCK TABLES `horarioydoctor` WRITE;
/*!40000 ALTER TABLE `horarioydoctor` DISABLE KEYS */;
INSERT INTO `horarioydoctor` VALUES (30,19,9,'20:00:00','23:00:00'),(31,20,13,'10:00:00','13:00:00'),(32,21,9,'10:00:00','12:00:00'),(33,21,11,'11:00:00','17:00:00'),(34,22,9,'10:00:00','13:00:00'),(35,22,10,'14:00:00','16:00:00'),(36,23,13,'09:00:00','10:01:00'),(41,29,10,'00:00:02','10:00:00'),(42,20,12,'02:00:00','23:00:00'),(43,22,12,'01:00:00','23:00:00');
/*!40000 ALTER TABLE `horarioydoctor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `hospitalizacion`
--

LOCK TABLES `hospitalizacion` WRITE;
/*!40000 ALTER TABLE `hospitalizacion` DISABLE KEYS */;
INSERT INTO `hospitalizacion` VALUES (11,'2025-04-28 18:37:52',0,NULL,0,NULL,25,'0000-00-00 00:00:00','DES',19),(12,'2025-04-28 18:42:13',0,NULL,0,NULL,25,'0000-00-00 00:00:00','DES',19),(13,'2025-04-29 07:32:00',0,NULL,1,NULL,25,'0000-00-00 00:00:00','Realizadas',19),(14,'2025-05-23 08:17:49',478692,4447.81,478692,4447.81,25,'2025-06-29 03:51:35','Realizada',19),(15,'2025-06-10 20:20:19',0,0,0,0,25,'0000-00-00 00:00:00','DES',19),(16,'2025-06-21 19:36:00',0,0,0,0,25,'0000-00-00 00:00:00','DES',19),(17,'2025-06-21 19:48:25',0,0,0,0,25,'0000-00-00 00:00:00','DES',19),(18,'2025-06-29 19:26:13',0,0,123,0,25,'2025-06-29 14:02:01','Realizada',19),(19,'2025-06-29 20:11:25',1.88073,0.017475,1.88073,0.017475,25,'2025-06-29 14:11:37','Realizada',19),(20,'2025-06-30 15:14:39',42.89,0.4,51.89,0.48,25,'2025-06-30 16:31:51','Realizada',19),(21,'2025-09-04 16:04:35',0,0,0,0,25,'0000-00-00 00:00:00','DES',19),(22,'2025-09-06 13:26:28',0,0,0,0,25,'0000-00-00 00:00:00','DES',19),(23,'0000-00-00 00:00:00',0,0,0,0,25,'0000-00-00 00:00:00','DES',19),(24,'2025-09-12 11:22:59',540.77,3.56,570.33,3.75,25,'2025-09-14 14:36:51','Realizada',19),(25,'2025-09-14 14:37:52',0,0,0,0,25,'0000-00-00 00:00:00','DES',19),(26,'2025-09-15 20:17:53',0,0,0,0,25,'0000-00-00 00:00:00','DES',19),(27,'2025-09-24 19:58:31',474844,2407.37,474874,2407.52,25,'2025-10-14 21:26:57','Realizada',19),(34,'2025-10-30 20:12:15',217.91,1.01,220.71,1.02,25,'2025-10-30 22:55:44','DES',20),(35,'2025-11-01 11:30:10',0,0,0,0,25,'0000-00-00 00:00:00','DES',22),(36,'2025-11-03 14:22:41',1.34,0.01,19.34,0.09,26,'2025-11-03 14:23:45','Pendiente',22),(37,'2025-11-04 13:37:49',379.91,1.76,382.71,1.77,102,'2025-11-04 18:23:02','Pendiente',22);
/*!40000 ALTER TABLE `hospitalizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `insumo`
--

LOCK TABLES `insumo` WRITE;
/*!40000 ALTER TABLE `insumo` DISABLE KEYS */;
INSERT INTO `insumo` VALUES (24,'','Paracetamol','El paracetamol, también conocido como acetaminofén o acetaminofeno, es un fármaco con propiedades analgésicas y antipiréticas utilizado principalmente para tratar la fiebre y el dolor leve y moderado','','',10.33,'DES',0,0),(25,'','Ibuprofeno','El ibuprofeno es un antinflamatorio no esteroideo (AINE) que pertenece al subgrupo de fármacos derivados del ácido propiónico.','','',17.90,'DES',0,0),(29,'2025-04-29_1745911425_WhatsApp Image 2025-04-03 at 11.51.47 PM.jpeg','Ibuprofeno','descripción','','',2.10,'DES',0,0),(30,'2025-05-02_1746200226_9amALQfcTkJsr2zlMRcpi99AnctFZBjlnRxibrip.jpg','Ibuprofeno','descripción','','',2.10,'DES',0,0),(31,'2025-05-02_1746216592_img27.jpg','Insumo','Es un antinflamatorio son derivados del ácido propiónico.','Tecno spar 30212 ','400 ml',29.56,'ACT',1,0),(32,'2025-05-05_1746489843_img23.jpg','Lobo','Es un lobo malvado','Tecno spar 30212 ','400 ml',0.60,'DES',1,0),(33,'2025-05-07_1746668110_img16.jpg','Spidermas','Es un antinflamatorio son derivados del ácido propiónico.','Tecno spar 30212 ','600 ml',123.00,'ACT',1,0),(34,'2025-05-08_1746714309_img5.jpg','Caballero','El ibuprofeno es un antinflamaupo de fármacos derivados del ácido propiónico.','Tecno spar 30212','600 ml',2040.00,'DES',1,0),(35,'2025-05-08_1746715177_img29.jpg','Insumodolar','Es un antinflamatorio son derivados del ácido propiónico.','Tecno spar 30212 ','200 ml',870.00,'DES',5,0),(36,'2025-06-21_1750492799_img30.png','Ansumo','El ibuprofeno e','Tecno spar 3022 ','400 ml',80.00,'ACT',2,0),(37,'2025-09-15_1757981940_darsox-anime-1.jpg','Spiderman','descripcio1','Spidermas','100 g',9.00,'ACT',1,0),(39,'2025-06-20_1750445529_4992462.jpg','Carlos','es un SO ','Microsoft','1 g',5.00,'ACT',1,0),(40,'2025-06-21_1750492468_Neon03.jpg','Disparador','es una descripcion','Lenovo','1 g',9.00,'ACT',5,0),(41,'2025-06-21_1750492543_Neon03.jpg','Disparador','es una descripcion','Lenovo','1 g',9.00,'ACT',5,0),(42,'2025-06-21_1750492723_1259289.jpg','Card','es una descripcion','Microsoft','1 g',8.00,'DES',5,0),(43,'2025-06-29_1751222978_img5.jpg','Julio','es un SO ','Microsoft','1 g',8.00,'ACT',1,1),(44,'2025-09-15_1757981960_descargar2.jpg','Preuva','es un SO ','Microsoft','1 g',2.80,'ACT',3,1),(45,'2025-10-03_1759535262_Big Sur Ligh.jpg','Insumophpinit','descripcion prueba editando','MarcaX','100 g',100.00,'DES',10,1),(46,'2026-06-02_1780448376_code.png','Asds','Ssdsaasdsasadd','Marca','200 ml',1.00,'ACT',1,0);
/*!40000 ALTER TABLE `insumo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `insumodehospitalizacion`
--

LOCK TABLES `insumodehospitalizacion` WRITE;
/*!40000 ALTER TABLE `insumodehospitalizacion` DISABLE KEYS */;
INSERT INTO `insumodehospitalizacion` VALUES (13,16,58,1),(14,17,52,2),(15,18,60,1),(16,20,54,1),(17,21,64,1),(18,21,52,5),(19,22,52,6),(20,22,61,1),(22,23,58,23),(26,24,60,1),(27,25,60,2),(28,26,53,1),(29,27,60,1),(35,34,65,1),(36,35,65,1),(37,36,54,2),(38,37,65,1);
/*!40000 ALTER TABLE `insumodehospitalizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `paciente`
--

LOCK TABLES `paciente` WRITE;
/*!40000 ALTER TABLE `paciente` DISABLE KEYS */;
INSERT INTO `paciente` VALUES (23,'V','28150004','Juan','Silva','04121338031','Calle 10 entre 3 y 7','2001-09-22','Masculino','ACT','SALUDABLE'),(24,'V','28329224','Rocio','Rodriguez','04121338031','URB EL BOSQUE CALLE 12','2025-04-02','Femenino','ACT','SALUDABLE'),(25,'V','30554144','Carlos','Hernadéz','04121232340','Eb su casa','2012-02-11','Masculino','ACT','ENFERMO'),(26,'V','17664525','Sofia','Sofia','4121338031','undefined','2001-03-30','Masculino','ACT','SALUDABLE'),(27,'V','158961','Aaaa','Aaaa','4121338032','Direccion','2001-09-22','Masculino','DES','SALUDABLE'),(28,'V','2000001','Argentina','Apellido_1','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(29,'V','2000002','Editado','Modificado','04123454320','en su casa','2002-02-20','Masculino','ACT','SALUDABLE'),(30,'V','2000003','Chile','Apellido_3','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(31,'V','2000004','Colombia','Apellido_4','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(32,'V','2000005','México','Apellido_5','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(33,'V','2000006','Perú','Apellido_6','04121338031','Dirección genérica','2024-01-01','Masculino','ACT','SALUDABLE'),(34,'V','2000007','Uruguay','Apellido_7','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(35,'V','2000008','Venezuela','Apellido_8','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(36,'V','2000009','Ecuador','Apellido_9','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(37,'V','2000010','Bolivia','Apellido_10','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(38,'V','2000011','Paraguay','Apellido_11','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(39,'V','2000012','Panamá','Apellido_12','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(40,'V','2000013','Costa Rica','Apellido_13','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(41,'V','2000014','Guatemala','Apellido_14','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(42,'V','2000015','El Salvador','Apellido_15','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(43,'V','2000016','Honduras','Apellido_16','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(44,'V','2000017','Nicaragua','Apellido_17','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(45,'V','2000018','Cuba','Apellido_18','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(46,'V','20000190','República','Apellido','04121338031','Direccion generica','2000-01-01','Femenino','ACT','SALUDABLE'),(47,'V','2000020','Puerto Rico','Apellido_20','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(48,'V','2000021','Canadá','Apellido_21','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(49,'V','2000022','España','Apellido_22','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(50,'V','2000023','Francia','Apellido_23','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(51,'V','2000024','Italia','Apellido_24','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(52,'V','2000025','Alemania','Apellido_25','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(53,'V','2000026','Portugal','Apellido_26','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(54,'V','2000027','Grecia','Apellido_27','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(55,'V','2000028','Rusia','Apellido_28','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(56,'V','2000029','China','Apellido_29','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(57,'V','2000030','Japón','Apellido_30','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(58,'V','2000031','Corea del Sur','Apellido_31','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(59,'V','2000032','India','Apellido_32','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(60,'V','2000033','Australia','Apellido_33','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(61,'V','2000034','Nueva Zelanda','Apellido_34','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(62,'V','2000035','Egipto','Apellido_35','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(63,'V','2000036','Sudáfrica','Apellido_36','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(64,'V','2000037','Nigeria','Apellido_37','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(65,'V','2000038','Kenia','Apellido_38','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(66,'V','2000039','Senegal','Apellido_39','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(67,'V','2000040','Túnez','Apellido_40','04121338031','Dirección genérica','2000-01-01','Femenino','ACT','SALUDABLE'),(68,'V','2000041','Argentina','Apellido_41','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(69,'V','2000042','Brasil','Apellido_42','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(70,'V','2000043','Chile','Apellido_43','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(71,'V','2000044','Colombia','Apellido_44','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(72,'V','2000045','México','Apellido_45','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(73,'V','2000046','Perú','Apellido_46','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(74,'V','2000047','Uruguay','Apellido_47','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(75,'V','2000048','Venezuela','Apellido_48','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(76,'V','2000049','Ecuador','Apellido_49','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(77,'V','2000050','Bolivia','Apellido_50','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(78,'V','2000051','Paraguay','Apellido_51','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(79,'V','2000052','Panamá','Apellido_52','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(80,'V','2000053','Costa Rica','Apellido_53','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(81,'V','2000054','Guatemala','Apellido_54','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(82,'V','2000055','El Salvador','Apellido_55','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(83,'V','2000056','Honduras','Apellido_56','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(84,'V','2000057','Nicaragua','Apellido_57','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(85,'V','2000058','Cuba','Apellido_58','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(86,'V','20000590','República','Apellido','04121338031','Direccin genrica','2000-01-01','Masculino','ACT','SALUDABLE'),(87,'V','2000060','Puerto Rico','Apellido_60','04121338031','Dirección genérica','2000-01-01','Masculino','ACT','SALUDABLE'),(88,'V','1480973','Liam','Hendrick','04128649495','En su casa ','1997-06-28','Femenino','DES','SALUDABLE'),(89,'V','341234','Gol','Peterson','04123433454','California','2000-06-05','Masculino','DES','CRONICO'),(90,'V','20321830','Yuletxy','Colmenarez','04128892449','El tocuyo','1992-02-10','Femenino','ACT','SALUDABLE'),(91,'V','344233','Perdo','Msdms','04142322323','en su cas','2009-11-11','Masculino','ACT','SALUDABLE'),(92,'V','3055414','Mdfgdf','Ssdds','04142320233','SMDSDMDS','2007-02-11','Femenino','ACT','SALUDABLE'),(93,'V','303439','Awqwkq','Qmasm','04123434322','wenew sdnsd','2025-09-02','Masculino','ACT','SALUDABLE'),(94,'V','3055415','Adsad','Asdsd','04122343323','em sfdnfdhf','2025-09-15','Femenino','ACT','SALUDABLE'),(98,'V','3722999','Pedro','Perez','04123454327','en su casa','2002-02-20','Masculino','ACT','SALUDABLE'),(100,'V','534534','Wewd','Xas','04122323222','en su casssa','2001-09-30','Masculino','ACT','SALUDABLE'),(102,'V','13197426','Piolin','Paralo','04122323212','wdqwdqwd','2000-02-21','Masculino','ACT','SALUDABLE'),(103,'V','1212122','Colombia','Apellido','04141322333','Direccin genrica','2026-03-24','Masculino','ACT','SALUDABLE'),(104,'V','30554145','Dixon','Bastias','04142232333','En el Tocuyo','2004-10-08','Masculino','ACT','SALUDABLE'),(105,'V','23421321','Venezuela','Apellido','04121338031','wewewqwew','2001-03-23','Masculino','ACT','SALUDABLE'),(106,'V','6789089','Venezuela','Apellido','04121338031','wewewqwew','2009-03-31','Femenino','ACT','SALUDABLE'),(107,'V','5665566','Venezuela','Apellido','04121338031','wewewqwew','2000-03-17','Femenino','ACT','SALUDABLE');
/*!40000 ALTER TABLE `paciente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `pago`
--

LOCK TABLES `pago` WRITE;
/*!40000 ALTER TABLE `pago` DISABLE KEYS */;
INSERT INTO `pago` VALUES (5,'Efectivo'),(6,'Pago Movil'),(7,'Transferencia'),(8,'Divisas');
/*!40000 ALTER TABLE `pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `pagodefactura`
--

LOCK TABLES `pagodefactura` WRITE;
/*!40000 ALTER TABLE `pagodefactura` DISABLE KEYS */;
INSERT INTO `pagodefactura` VALUES (138,5,109,'1257',3000.00),(139,6,109,'1257',1000.00),(140,5,110,'',240.00),(141,5,111,'',240.00),(142,5,112,'',240.00),(143,5,113,'',240.00),(144,5,114,'',80.00),(145,5,115,'',80.00),(146,5,116,'',80.00),(147,5,117,'',9.00),(148,5,118,'',240.00),(149,5,119,'',63.00),(150,5,120,'',36.00),(151,5,121,'',80.00),(152,5,122,'',9.00),(153,5,123,'',240.00),(154,5,124,'',240.00),(155,5,125,'',240.00),(156,5,126,'',240.00),(157,5,127,'',240.00),(158,5,128,'',240.00),(159,5,129,'',240.00),(160,5,130,'',240.00),(161,5,131,'',240.00),(162,5,132,'',240.00),(163,5,133,'',240.00),(164,5,134,'',240.00),(165,5,135,'',240.00),(166,5,136,'',80.00),(167,5,137,'',80.00),(168,5,138,'',80.00),(169,5,139,'',80.00),(170,5,140,'',160.00),(171,5,141,'',36.00),(172,5,142,'',80.00),(173,5,143,'',80.00),(174,5,144,'',116.00),(175,5,145,'',80.00),(176,5,146,'',98.00),(177,5,147,'',560.00),(178,5,148,'',9.00),(179,5,149,'',160.00),(180,5,150,'',1000.00),(181,5,151,'',240.00),(182,6,152,'1234',29.56),(183,5,153,'',9.00),(184,5,154,'',29.56),(185,6,154,'',0.00),(186,5,155,'4326',200.00),(187,6,155,'4326',880.00),(188,5,156,'',29.56),(189,5,157,'',478692.00),(190,5,158,'',123.00),(191,5,159,'',1.88),(192,5,160,'',17.00),(193,5,161,'',3000.00),(194,5,162,'',6000.00),(195,5,163,'',6000.00),(196,5,164,'',6000.00),(197,5,165,'',6000.00),(198,5,166,'',6000.00),(199,5,167,'',6000.00),(200,5,168,'',6000.00),(201,5,169,'',6000.00),(202,5,170,'',6000.00),(203,5,171,'',6000.00),(204,5,172,'',6000.00),(205,5,173,'3000',32.00),(206,6,173,'3000',19.89),(207,5,174,'',570.33),(208,5,175,'',29.56),(209,5,176,'',160.00),(210,5,177,'5678',1000.00),(211,6,177,'5678',18.00),(212,5,178,'',29.56),(213,5,179,'2323',120.00),(214,7,179,'2323',880.00),(215,5,180,NULL,1080.00),(216,5,181,NULL,1080.00),(217,5,182,'',1080.00),(218,5,183,'',246.12),(219,6,184,'1213',1000.00),(220,5,185,'',1000.00),(221,5,186,'',1000.00),(222,5,187,'',1000.00),(223,5,188,'',1000.00),(224,5,189,'',1000.00),(225,5,190,'',1000.00),(226,5,191,'',1000.00),(227,5,192,'',1000.00),(228,5,193,'',1000.00),(229,5,194,'',1000.00),(230,5,195,'',1000.00),(231,5,196,'',1000.00),(232,5,197,'',1000.00),(233,5,198,'',1000.00),(234,5,199,'',1000.00),(235,5,200,'',1000.00),(236,5,202,'',80.00),(237,5,203,'',80.00),(238,5,204,'',80.00),(239,5,205,'',3000.00),(240,5,206,'',3000.00),(241,5,207,'',3000.00),(242,5,208,'',474874.00),(243,5,209,'',240.00),(244,5,210,'',27.00),(245,5,211,'',1094.60);
/*!40000 ALTER TABLE `pagodefactura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `patologia`
--

LOCK TABLES `patologia` WRITE;
/*!40000 ALTER TABLE `patologia` DISABLE KEYS */;
INSERT INTO `patologia` VALUES (2,'DIABETES TIPO 1','DES'),(3,'DIABETES TIPO 2','DES'),(5,'EPOC','ACT'),(6,'ARTRITIS REUMATOIDE','ACT'),(7,'ENFERMEDAD CELÍACA','ACT'),(8,'OBESIDAD','ACT'),(11,'ENFERMEDAD DE CROHN','ACT'),(12,'COLITIS ULCEROSA','ACT'),(13,'ASMA','1'),(14,'Patologia','ACT'),(15,'Algo','ACT'),(16,'HIPERTIROIDISMO','ACT'),(17,'OSTEOPOROSIS','ACT'),(19,'MIGRAÑA','ACT'),(20,'ALZHEIMER','ACT'),(186,'Hipertensión','ACT'),(189,'Bronquitis','ACT'),(190,'Neumonía','ACT'),(192,'Gastritis','ACT'),(193,'Hepatitis A','ACT'),(194,'Hepatitis B','ACT'),(195,'Anemia','ACT'),(196,'Artritis','ACT'),(198,'Epilepsia','ACT'),(199,'Depresión','ACT'),(200,'Ansiedad','ACT'),(201,'Dermatitis','ACT'),(202,'Sinusitis','ACT'),(203,'COVID-19','ACT'),(204,'Tuberculosis','ACT'),(205,'Insuficiencia renal','ACT'),(207,'Generica','ACT');
/*!40000 ALTER TABLE `patologia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `patologiadepaciente`
--

LOCK TABLES `patologiadepaciente` WRITE;
/*!40000 ALTER TABLE `patologiadepaciente` DISABLE KEYS */;
INSERT INTO `patologiadepaciente` VALUES (16,23,13,'2025-04-02 20:13:12'),(17,23,13,'2025-04-02 20:13:46'),(18,26,15,'2025-05-15 17:26:49'),(19,26,13,'2025-05-15 18:18:42'),(20,24,13,'2025-05-15 18:18:51'),(21,25,13,'2025-05-15 18:18:51'),(102,25,5,'2025-04-01 10:15:00'),(157,28,8,'2025-04-03 09:30:00'),(176,70,20,'2025-04-20 16:30:00'),(178,49,17,'2025-04-17 13:05:00'),(179,55,16,'2025-04-16 11:35:00'),(180,47,13,'2025-04-15 10:10:00'),(181,48,15,'2025-04-14 09:45:00'),(183,28,11,'2025-04-12 08:50:00'),(194,27,2,'2025-04-10 12:00:00'),(195,27,6,'2025-04-09 15:25:00'),(202,29,14,'2025-04-06 16:00:00'),(207,28,8,'2025-04-03 09:30:00'),(208,26,3,'2025-04-04 11:20:00'),(209,62,6,'2025-05-15 19:42:53'),(210,59,20,'2025-05-15 19:43:28'),(211,60,11,'2025-05-15 19:43:28'),(212,87,2,'2025-05-15 19:43:56'),(214,87,20,'2025-05-15 19:44:11'),(215,86,7,'2025-05-15 19:44:11'),(216,29,205,'2025-05-15 19:44:21'),(218,51,14,'2025-05-15 19:44:51'),(219,58,14,'2025-05-15 19:44:51'),(220,46,14,'2025-05-15 19:45:12'),(222,25,6,'2025-06-10 10:11:51'),(223,25,8,'2025-06-10 10:11:51'),(224,25,5,'2025-06-10 20:07:54'),(225,25,6,'2025-06-10 20:07:54'),(226,25,7,'2025-06-10 20:07:54'),(227,25,8,'2025-06-10 20:07:54'),(229,25,5,'2025-06-19 20:29:30'),(230,25,6,'2025-06-19 20:29:30'),(231,25,7,'2025-06-19 20:29:30'),(232,25,8,'2025-06-19 20:29:30'),(234,25,186,'2025-06-19 20:29:30'),(235,25,190,'2025-06-19 20:29:30'),(236,25,192,'2025-06-19 20:29:30'),(237,89,5,'2025-06-27 19:24:28'),(238,89,7,'2025-06-27 19:24:28'),(239,25,5,'2025-09-25 20:24:37'),(240,25,7,'2025-09-25 20:24:37'),(241,25,5,'2025-10-03 11:23:02'),(242,25,7,'2025-10-03 11:23:02'),(243,25,5,'2025-10-03 11:23:41'),(244,25,7,'2025-10-03 11:23:41'),(245,26,5,'2025-11-03 14:23:45'),(246,102,5,'2025-11-03 14:37:35'),(247,23,20,'2025-11-03 14:46:59'),(248,102,5,'2025-11-03 15:00:02'),(249,102,11,'2025-11-03 15:01:59'),(250,102,190,'2025-11-03 17:18:04'),(251,102,17,'2025-11-04 10:07:56'),(252,102,7,'2025-11-04 13:11:48'),(253,102,5,'2025-11-04 13:41:16'),(254,102,5,'2025-11-04 17:31:58'),(255,102,5,'2025-11-04 18:23:02');
/*!40000 ALTER TABLE `patologiadepaciente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `personal`
--

LOCK TABLES `personal` WRITE;
/*!40000 ALTER TABLE `personal` DISABLE KEYS */;
INSERT INTO `personal` VALUES (18,'V','30554053','Wilmer','Baez','04145378608','Administrador',NULL,1),(19,'V','1232233','David','Carlos','04142323233','',7,42),(20,'V','12123343','Carlos','Garcia','04244546565','',7,43),(21,'V','12020333','Ana','Bracho','04122323422','',6,45),(22,'V','6755654','Julian','Valdez','04122323212','',4,46),(23,'V','867548','Jaun','Edlkfjfdsk','04243943432','',5,49),(24,'V','1223211','Auto','Auto','04122232323','Administrador',NULL,50),(25,'V','5675324','Alen','Alenrere','04123434343','Administrador',NULL,51),(29,'V','2000002','Editado','Modificado','04123454320','',NULL,47);
/*!40000 ALTER TABLE `personal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `personal_has_serviciomedico`
--

LOCK TABLES `personal_has_serviciomedico` WRITE;
/*!40000 ALTER TABLE `personal_has_serviciomedico` DISABLE KEYS */;
INSERT INTO `personal_has_serviciomedico` VALUES (18,25),(19,24),(19,26),(19,29),(19,30),(19,32),(19,33),(19,36),(20,24),(20,27),(20,28),(20,31),(22,25);
/*!40000 ALTER TABLE `personal_has_serviciomedico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (6,'Juan Jose','281500045','04121338909','depanajuaner@gmail.com','en su casa','ACT'),(7,'Ricardo Perez','296236571','04124466999','sisisi@gmail.com','hfygh','ACT'),(8,'Luis Empresa','J122334','0424354556','luis12345@gmail.com','El Tocuyo','ACT'),(11,'Juanx','ffreer','04122323232','dix2334antias@gmail.com','dffdf','ACT');
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `serviciomedico`
--

LOCK TABLES `serviciomedico` WRITE;
/*!40000 ALTER TABLE `serviciomedico` DISABLE KEYS */;
INSERT INTO `serviciomedico` VALUES (22,9,2200.00,'ACT','Examenes'),(23,100,1500.00,'ACT','Cita'),(24,1,3000.00,'ACT','Cita'),(25,101,1000.00,'ACT','Examenes'),(26,2,120.00,'ACT','Cita'),(27,2,123.00,'DES',''),(28,1,31395.00,'DES',''),(29,1,16905.00,'DES',''),(30,1,169.05,'DES',''),(31,101,12.00,'DES',''),(32,1,479.78,'DES',''),(33,100,1.07,'DES',''),(34,104,24.95,'ACT','Cita'),(35,103,60.66,'ACT','Cita'),(36,102,46.81,'ACT','Cita'),(37,105,5.48,'ACT','Examenes'),(38,9,100.00,'ACT','Cita');
/*!40000 ALTER TABLE `serviciomedico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `servicios_hospitalizacion`
--

LOCK TABLES `servicios_hospitalizacion` WRITE;
/*!40000 ALTER TABLE `servicios_hospitalizacion` DISABLE KEYS */;
INSERT INTO `servicios_hospitalizacion` VALUES (9,34,25,1),(10,35,25,1),(11,36,25,2),(13,37,25,1);
/*!40000 ALTER TABLE `servicios_hospitalizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `sintomas`
--

LOCK TABLES `sintomas` WRITE;
/*!40000 ALTER TABLE `sintomas` DISABLE KEYS */;
INSERT INTO `sintomas` VALUES (5,'Disnea','DES'),(6,'Fiebre','ACT'),(7,'Vomito','DES'),(8,'Dolor de cabeza','ACT'),(9,'Malestar general','ACT'),(10,'Inchazon','ACT'),(11,'Enrojecimiento','ACT'),(12,'Piel Amarilla','ACT'),(13,'Dolor de higado','ACT'),(14,'Encias sangrantes','ACT'),(15,'sintoma','DES'),(16,'Xxxxxx','DES'),(17,'Sin n n','DES');
/*!40000 ALTER TABLE `sintomas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `sintomas_control`
--

LOCK TABLES `sintomas_control` WRITE;
/*!40000 ALTER TABLE `sintomas_control` DISABLE KEYS */;
INSERT INTO `sintomas_control` VALUES (37,5,26),(38,10,26),(39,8,26),(40,8,27),(41,9,27),(42,7,27),(43,5,28),(44,6,28),(45,7,28),(46,5,29),(47,6,29),(48,8,29),(49,5,30),(50,6,30),(51,6,31),(52,8,31),(53,6,32),(54,8,32),(55,6,33),(56,8,33),(57,6,34),(58,8,34),(59,6,40),(60,6,42),(61,9,42),(62,6,43),(63,6,45),(64,8,46),(65,6,47),(66,8,48),(67,6,49),(68,8,50),(69,8,51),(70,6,52),(71,6,53),(72,6,54),(73,6,55),(74,9,55),(75,6,55),(76,8,55);
/*!40000 ALTER TABLE `sintomas_control` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-03  7:50:48
