-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: segurity
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
-- Table structure for table `bitacora`
--

DROP TABLE IF EXISTS `bitacora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bitacora` (
  `id_bitacora` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tabla` varchar(30) NOT NULL,
  `actividad` text NOT NULL,
  `fecha_hora` datetime NOT NULL,
  PRIMARY KEY (`id_bitacora`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `bitacora_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=282 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bitacora`
--

LOCK TABLES `bitacora` WRITE;
/*!40000 ALTER TABLE `bitacora` DISABLE KEYS */;
INSERT INTO `bitacora` VALUES (0,1,'inicio sesion','Ha iniciado una session','2025-06-08 11:42:55'),(6,1,'inicio sesion','Ha iniciado una session','2025-03-31 11:14:41'),(7,1,'inicio sesion','Ha iniciado una session','2025-03-31 12:05:23'),(8,1,'inicio sesion','Ha iniciado una session','2025-03-31 12:22:08'),(9,1,'inicio sesion','Ha iniciado una session','2025-03-31 12:54:08'),(10,1,'cerrar session','Ha cerrado la session ','2025-03-31 12:54:37'),(11,1,'inicio sesion','Ha iniciado una session','2025-03-31 12:56:04'),(12,1,'cerrar session','Ha cerrado la session ','2025-03-31 13:32:42'),(13,1,'inicio sesion','Ha iniciado una session','2025-03-31 13:32:52'),(14,1,'inicio sesion','Ha iniciado una session','2025-03-31 13:47:10'),(15,1,'inicio sesion','Ha iniciado una session','2025-03-31 16:10:52'),(16,1,'inicio sesion','Ha iniciado una session','2025-03-31 17:04:02'),(17,1,'inicio sesion','Ha iniciado una session','2025-04-02 10:05:43'),(18,1,'inicio sesion','Ha iniciado una session','2025-04-02 11:30:21'),(19,1,'inicio sesion','Ha iniciado una session','2025-04-02 11:54:59'),(20,1,'inicio sesion','Ha iniciado una session','2025-04-03 20:46:16'),(21,1,'inicio sesion','Ha iniciado una session','2025-04-04 17:18:31'),(22,1,'cerrar session','Ha cerrado la session ','2025-04-04 23:20:21'),(23,1,'inicio sesion','Ha iniciado una session','2025-04-05 09:18:47'),(24,1,'inicio sesion','Ha iniciado una session','2025-04-14 19:18:06'),(25,1,'paciente','Ha Insertado un nuevo paciente','2025-04-14 19:20:24'),(26,1,'factura','Ha facturado servicios y/o insumos','2025-04-14 19:25:47'),(27,1,'Roles','Ha Insertado un nuevo rol','2025-04-14 20:33:40'),(28,1,'Roles','Ha Insertado un nuevo rol','2025-04-14 20:35:37'),(29,1,'Roles','Ha Modiicado un rol','2025-04-14 20:35:49'),(30,1,'Roles','Ha Eliminado un rol','2025-04-14 20:36:00'),(31,1,'Roles','Ha Eliminado un rol','2025-04-14 20:36:17'),(32,1,'Roles','Ha Eliminado un rol','2025-04-14 20:36:24'),(33,1,'Roles','Ha Insertado un nuevo rol','2025-04-14 20:36:54'),(34,1,'doctor','Ha Insertado un doctor','2025-04-14 20:39:06'),(35,1,'servicioMedico','Ha Insertado un nuevo  servicio medico','2025-04-14 20:39:21'),(36,1,'cita','Ha Insertado una  cita','2025-04-14 18:40:33'),(37,1,'inicio sesion','Ha iniciado una session','2025-04-15 10:05:28'),(38,1,'factura','Ha facturado servicios y/o insumos','2025-04-21 10:58:40'),(39,1,'inicio sesion','Ha iniciado una session','2025-04-15 15:39:07'),(40,1,'inicio sesion','Ha iniciado una session','2025-04-15 19:39:17'),(41,1,'factura','Ha facturado servicios y/o insumos','2025-04-15 21:13:58'),(42,1,'factura','Ha facturado servicios y/o insumos','2025-04-15 21:17:22'),(43,1,'cerrar session','Ha cerrado la session ','2025-04-15 21:32:10'),(44,1,'inicio sesion','Ha iniciado una session','2025-04-15 21:35:22'),(45,1,'inicio sesion','Ha iniciado una session','2025-04-16 08:27:48'),(46,1,'factura','Ha facturado servicios y/o insumos','2025-04-16 09:02:09'),(47,1,'inicio sesion','Ha iniciado una session','2025-04-16 19:16:15'),(48,1,'inicio sesion','Ha iniciado una session','2025-04-17 10:30:25'),(49,1,'factura','Ha facturado servicios y/o insumos','2025-04-17 10:47:58'),(50,1,'factura','Ha facturado servicios y/o insumos','2025-04-17 11:41:58'),(51,1,'factura','Ha facturado servicios y/o insumos','2025-04-17 11:42:22'),(52,1,'inicio sesion','Ha iniciado una session','2025-04-17 15:14:04'),(53,1,'factura','Ha facturado servicios y/o insumos','2025-04-17 15:27:56'),(54,1,'cerrar session','Ha cerrado la session ','2025-04-17 16:16:48'),(55,1,'inicio sesion','Ha iniciado una session','2025-04-17 16:16:56'),(56,1,'cerrar session','Ha cerrado la session ','2025-04-17 17:05:12'),(57,1,'inicio sesion','Ha iniciado una session','2025-04-17 17:05:56'),(58,1,'inicio sesion','Ha iniciado una session','2025-04-18 10:40:46'),(59,1,'doctor','Ha Insertado un doctor','2025-04-18 10:53:27'),(60,1,'servicioMedico','Ha Insertado un nuevo  servicio medico','2025-04-18 10:56:52'),(61,1,'cita','Ha Insertado una  cita','2025-04-18 09:01:22'),(62,1,'inicio sesion','Ha iniciado una session','2025-04-19 10:54:18'),(63,1,'inicio sesion','Ha iniciado una session','2025-04-19 11:17:57'),(64,1,'cerrar session','Ha cerrado la session ','2025-04-19 11:58:37'),(65,1,'inicio sesion','Ha iniciado una session','2025-04-19 21:09:28'),(66,1,'cerrar session','Ha cerrado la session ','2025-04-19 21:11:06'),(67,1,'inicio sesion','Ha iniciado una session','2025-04-19 21:17:04'),(68,1,'inicio sesion','Ha iniciado una session','2025-04-20 10:04:51'),(69,1,'Roles','Ha Modiicado un rol','2025-04-20 10:19:51'),(70,1,'Roles','Ha Modiicado un rol','2025-04-20 10:20:18'),(71,1,'Roles','Ha Modiicado un rol','2025-04-20 10:35:40'),(72,1,'Roles','Ha Modiicado un rol','2025-04-20 10:49:30'),(73,1,'Roles','Ha Modiicado un rol','2025-04-20 10:50:25'),(74,1,'Roles','Ha Modiicado un rol','2025-04-20 10:52:12'),(75,1,'Roles','Ha Modiicado un rol','2025-04-20 10:52:59'),(76,1,'Roles','Ha Modiicado un rol','2025-04-20 10:53:02'),(77,1,'Roles','Ha Modiicado un rol','2025-04-20 10:54:04'),(78,1,'Roles','Ha Modiicado un rol','2025-04-20 10:54:36'),(79,1,'Roles','Ha Modiicado un rol','2025-04-20 10:54:48'),(80,1,'Roles','Ha Modiicado un rol','2025-04-20 10:54:53'),(81,1,'Roles','Ha Modiicado un rol','2025-04-20 10:55:11'),(82,1,'Roles','Ha Modiicado un rol','2025-04-20 11:07:04'),(83,1,'Roles','Ha Modiicado un rol','2025-04-20 11:07:27'),(84,1,'Roles','Ha Modiicado un rol','2025-04-20 11:08:45'),(85,1,'Roles','Ha Modiicado un rol','2025-04-20 11:09:04'),(86,1,'Roles','Ha Modiicado un rol','2025-04-20 11:09:19'),(87,1,'Roles','Ha Insertado un nuevo rol','2025-04-20 11:13:53'),(88,1,'Roles','Ha Eliminado un rol','2025-04-20 11:14:09'),(89,1,'Roles','Ha Modiicado un rol','2025-04-20 11:17:33'),(90,1,'Roles','Ha Modiicado un rol','2025-04-20 11:17:42'),(91,1,'categoria_servicio','Ha eliminado una  categoria','2025-04-20 11:24:29'),(92,1,'inicio sesion','Ha iniciado una session','2025-04-21 16:13:23'),(93,1,'factura','Ha facturado servicios y/o insumos','2025-04-21 16:46:06'),(94,1,'entrada','Ha insertado una entrada','2025-04-21 16:48:42'),(95,1,'factura','Ha facturado servicios y/o insumos','2025-04-21 17:15:28'),(96,1,'factura','Ha facturado servicios y/o insumos','2025-04-21 17:16:21'),(97,1,'factura','Ha facturado servicios y/o insumos','2025-04-21 17:30:59'),(98,1,'inicio sesion','Ha iniciado una session','2025-04-21 19:31:34'),(99,1,'entrada','Ha insertado una entrada','2025-04-21 19:39:46'),(100,1,'factura','Ha facturado servicios y/o insumos','2025-04-21 19:41:28'),(101,1,'factura','Ha facturado servicios y/o insumos','2025-04-21 19:51:30'),(102,1,'factura','Ha facturado servicios y/o insumos','2025-04-21 19:54:51'),(103,1,'entrada','Ha insertado una entrada','2025-04-21 19:59:19'),(104,1,'factura','Ha facturado servicios y/o insumos','2025-04-21 20:00:00'),(105,1,'factura','Ha facturado servicios y/o insumos','2025-04-21 20:03:13'),(106,1,'factura','Ha facturado servicios y/o insumos','2025-04-21 20:05:17'),(107,1,'inicio sesion','Ha iniciado una session','2025-04-21 20:08:29'),(108,1,'inicio sesion','Ha iniciado una session','2025-04-22 10:45:39'),(109,1,'inicio sesion','Ha iniciado una session','2025-04-22 10:47:29'),(110,1,'inicio sesion','Ha iniciado una session','2025-04-22 11:09:02'),(111,1,'proveedor','Ha modificado un proveedor','2025-04-22 11:28:19'),(112,1,'Roles','Ha Insertado un nuevo rol','2025-04-22 12:41:55'),(113,1,'cerrar session','Ha cerrado la session ','2025-04-22 12:42:49'),(114,1,'inicio sesion','Ha iniciado una session','2025-04-22 12:43:20'),(115,1,'inicio sesion','Ha iniciado una session','2025-04-27 21:00:54'),(116,1,'cerrar session','Ha cerrado la session ','2025-04-27 21:03:03'),(117,1,'inicio sesion','Ha iniciado una session','2025-04-27 21:26:17'),(118,1,'cerrar session','Ha cerrado la session ','2025-04-27 21:28:33'),(119,1,'inicio sesion','Ha iniciado una session','2025-04-27 21:28:43'),(120,1,'control','Ha modificado un  control medico','2025-04-27 21:33:26'),(121,1,'control','Ha modificado un  control medico','2025-04-27 21:33:39'),(122,1,'sintomas','Ha Insertado un  sintoma','2025-04-27 21:37:41'),(123,1,'sintomas','Ha eliminado un  sintoma','2025-04-27 21:37:49'),(124,1,'cerrar session','Ha cerrado la session ','2025-04-27 21:56:58'),(125,1,'inicio sesion','Ha iniciado una session','2025-04-27 21:57:29'),(126,1,'inicio sesion','Ha iniciado una session','2025-04-28 14:37:36'),(127,1,'hospitalizacion','Ha Insertado una hospitalizacion','2025-04-28 14:38:01'),(128,1,'hospitalizacion','Ha modificado una hospitalizacion','2025-04-28 14:38:29'),(129,1,'hospitalizacion','Ha Insertado una hospitalizacion','2025-04-28 14:42:27'),(130,1,'inicio sesion','Ha iniciado una session','2025-04-29 01:41:48'),(131,1,'hospitalizacion','Ha eliminado una hospitalizacion','2025-04-29 02:54:29'),(132,1,'hospitalizacion','Ha eliminado una hospitalizacion','2025-04-29 02:54:38'),(133,1,'insumo','Ha Insertado un insumo','2025-04-29 03:23:45'),(134,1,'hospitalizacion','Ha Insertado una hospitalizacion','2025-04-29 03:32:05'),(135,1,'hospitalizacion','Ha modificado una hospitalizacion','2025-04-29 03:32:17'),(136,1,'inicio sesion','Ha iniciado una session','2025-04-29 11:38:32'),(137,1,'inicio sesion','Ha iniciado una session','2025-04-29 12:25:47'),(138,1,'cerrar session','Ha cerrado la session ','2025-04-29 12:29:02'),(139,1,'inicio sesion','Ha iniciado una session','2025-04-29 12:29:39'),(140,1,'cerrar session','Ha cerrado la session ','2025-04-29 12:35:09'),(141,1,'inicio sesion','Ha iniciado una session','2025-04-29 12:35:32'),(142,1,'inicio sesion','Ha iniciado una session','2025-05-01 11:11:28'),(143,1,'inicio sesion','Ha iniciado una session','2025-05-01 14:35:55'),(144,1,'factura','Ha facturado servicios y/o insumos','2025-05-01 15:12:29'),(145,1,'factura','Ha facturado servicios y/o insumos','2025-05-01 15:22:06'),(146,1,'factura','Ha facturado servicios y/o insumos','2025-05-01 15:22:47'),(147,1,'factura','Ha facturado servicios y/o insumos','2025-05-01 15:54:12'),(148,1,'cerrar session','Ha cerrado la session ','2025-05-01 16:23:01'),(149,1,'inicio sesion','Ha iniciado una session','2025-05-01 16:55:24'),(150,1,'inicio sesion','Ha iniciado una session','2025-05-01 18:01:42'),(151,1,'inicio sesion','Ha iniciado una session','2025-05-02 09:14:38'),(152,1,'Roles','Ha Modiicado un rol','2025-05-02 09:46:35'),(153,1,'cerrar session','Ha cerrado la session ','2025-05-02 09:46:41'),(154,1,'inicio sesion','Ha iniciado una session','2025-05-02 09:47:54'),(155,1,'hospitalizacion','Ha modificado una hospitalizacion','2025-05-02 11:09:19'),(156,1,'insumo','Ha Insertado un insumo','2025-05-02 11:37:07'),(157,1,'inicio sesion','Ha iniciado una session','2025-05-02 15:39:42'),(158,1,'insumo','Ha eliminado un insumo','2025-05-02 15:49:40'),(159,1,'insumo','Ha eliminado un insumo','2025-05-02 15:49:46'),(160,1,'insumo','Ha Insertado un insumo','2025-05-02 15:51:38'),(161,1,'insumo','Ha eliminado un insumo','2025-05-02 15:52:48'),(162,1,'insumo','Ha eliminado un insumo','2025-05-02 15:52:56'),(163,1,'entrada','Ha insertado una entrada','2025-05-02 15:59:16'),(164,1,'insumo','Ha modificado un insumo','2025-05-02 16:01:29'),(165,1,'insumo','Ha modificado un insumo','2025-05-02 16:01:50'),(166,1,'insumo','Ha modificado un insumo','2025-05-02 16:05:15'),(167,1,'insumo','Ha modificado un insumo','2025-05-02 16:08:31'),(168,1,'insumo','Ha modificado un insumo','2025-05-02 16:09:52'),(169,1,'inicio sesion','Ha iniciado una session','2025-05-03 08:08:17'),(170,1,'cita','Ha Insertado una  cita','2025-05-03 08:02:42'),(171,1,'factura','Ha facturado servicios y/o insumos','2025-05-03 10:03:37'),(172,1,'cerrar session','Ha cerrado la session ','2025-05-03 10:03:50'),(173,1,'inicio sesion','Ha iniciado una session','2025-05-03 10:04:05'),(174,42,'inicio sesion','Ha iniciado una session','2025-05-03 10:05:34'),(175,42,'cerrar session','Ha cerrado la session ','2025-05-03 10:18:27'),(176,1,'inicio sesion','Ha iniciado una session','2025-05-03 11:06:03'),(177,1,'cita','Ha Insertado una  cita','2025-05-03 09:18:06'),(178,1,'factura','Ha facturado servicios y/o insumos','2025-05-03 11:42:13'),(179,1,'inicio sesion','Ha iniciado una session','2025-05-03 20:05:34'),(180,1,'inicio sesion','Ha iniciado una session','2025-05-03 20:28:49'),(181,1,'inicio sesion','Ha iniciado una session','2025-05-03 21:10:14'),(182,1,'inicio sesion','Ha iniciado una session','2025-05-04 20:33:30'),(183,1,'patologia','Ha Insertado una patologia','2025-05-04 20:37:52'),(184,1,'paciente','Ha modificado un paciente','2025-05-04 20:45:17'),(185,1,'inicio sesion','Ha iniciado una session','2025-05-05 09:35:01'),(186,1,'servicioMedico','Ha Insertado un nuevo  servicio medico','2025-05-05 09:56:34'),(187,1,'servicioMedico','Ha Insertado un nuevo  servicio medico','2025-05-05 09:58:17'),(188,1,'servicioMedico','Ha Insertado un nuevo  servicio medico','2025-05-05 10:06:56'),(189,1,'servicioMedico','Ha Insertado un nuevo  servicio medico','2025-05-05 10:08:30'),(190,1,'servicioMedico','Ha eliminado un   servicio medico','2025-05-05 10:19:39'),(191,1,'servicioMedico','Ha eliminado un   servicio medico','2025-05-05 10:19:42'),(192,1,'servicioMedico','Ha eliminado un   servicio medico','2025-05-05 10:19:46'),(193,1,'servicioMedico','Ha eliminado un   servicio medico','2025-05-05 10:19:50'),(194,1,'servicioMedico','Ha eliminado un   servicio medico','2025-05-05 10:19:53'),(195,1,'inicio sesion','Ha iniciado una session','2025-05-05 19:24:49'),(196,1,'insumo','Ha Insertado un insumo','2025-05-05 20:04:03'),(197,1,'entrada','Ha insertado una entrada','2025-05-05 20:08:16'),(198,1,'factura','Ha facturado servicios y/o insumos','2025-05-05 20:10:41'),(199,1,'entrada','Ha eliminado una entrada','2025-05-05 20:16:24'),(200,1,'servicioMedico','Ha Insertado un nuevo  servicio medico','2025-05-05 20:39:13'),(201,1,'servicioMedico','Ha modificadp un servicio medico','2025-05-05 20:42:53'),(202,1,'servicioMedico','Ha eliminado un   servicio medico','2025-05-05 20:43:12'),(203,1,'inicio sesion','Ha iniciado una session','2025-05-07 16:16:11'),(204,1,'factura','Ha facturado servicios y/o insumos','2025-05-07 21:27:14'),(205,1,'factura','Ha facturado servicios y/o insumos','2025-05-07 21:30:01'),(206,1,'factura','Ha facturado servicios y/o insumos','2025-05-07 21:30:49'),(207,1,'factura','Ha facturado servicios y/o insumos','2025-05-07 21:31:45'),(208,1,'insumo','Ha eliminado un insumo','2025-05-07 21:32:10'),(209,1,'insumo','Ha Insertado un insumo','2025-05-07 21:35:10'),(210,1,'factura','Ha facturado servicios y/o insumos','2025-05-07 21:35:50'),(211,1,'servicioMedico','Ha Insertado un nuevo  servicio medico','2025-05-07 21:39:45'),(212,1,'servicioMedico','Ha modificadp un servicio medico','2025-05-07 22:14:16'),(213,1,'proveedor','Ha modificado un proveedor','2025-05-07 22:23:23'),(214,1,'cerrar session','Ha cerrado la session ','2025-05-07 22:25:18'),(215,42,'inicio sesion','Ha iniciado una session','2025-05-07 22:25:22'),(216,1,'inicio sesion','Ha iniciado una session','2025-05-07 22:25:39'),(217,1,'cerrar session','Ha cerrado la session ','2025-05-07 22:25:56'),(218,42,'inicio sesion','Ha iniciado una session','2025-05-07 22:25:59'),(219,42,'patologia','Ha Insertado una patologia','2025-05-07 22:26:27'),(220,42,'cerrar session','Ha cerrado la session ','2025-05-07 22:26:33'),(221,1,'inicio sesion','Ha iniciado una session','2025-05-07 22:26:36'),(222,1,'inicio sesion','Ha iniciado una session','2025-05-08 09:58:46'),(223,1,'insumo','Ha Insertado un insumo','2025-05-08 10:25:09'),(224,1,'insumo','Ha eliminado un insumo','2025-05-08 10:25:48'),(225,1,'insumo','Ha Insertado un insumo','2025-05-08 10:39:37'),(226,1,'insumo','Ha Insertado un insumo','2025-05-08 10:43:52'),(227,1,'insumo','Ha eliminado un insumo','2025-05-08 10:43:59'),(228,1,'inicio sesion','Ha iniciado una session','2025-05-09 10:48:22'),(229,1,'inicio sesion','Ha iniciado una session','2025-05-12 09:28:51'),(230,1,'cerrar session','Ha cerrado la session ','2025-05-12 11:20:25'),(231,1,'inicio sesion','Ha iniciado una session','2025-05-12 11:23:03'),(232,1,'inicio sesion','Ha iniciado una session','2025-05-12 11:27:59'),(233,1,'inicio sesion','Ha iniciado una session','2025-05-12 11:33:54'),(234,1,'servicioMedico','Ha modificadp un servicio medico','2025-05-12 13:07:37'),(235,1,'Roles','Ha Modiicado un rol','2025-05-12 13:49:08'),(236,1,'Roles','Ha Modiicado un rol','2025-05-12 13:50:19'),(237,1,'cerrar session','Ha cerrado la session ','2025-05-12 13:50:35'),(238,1,'inicio sesion','Ha iniciado una session','2025-05-12 13:50:38'),(239,1,'categoria_servicio','Ha Insertado una nueva  categoria','2025-05-12 14:50:13'),(240,1,'categoria_servicio','Ha Insertado una nueva  categoria','2025-05-12 14:50:24'),(241,1,'categoria_servicio','Ha Insertado una nueva  categoria','2025-05-12 14:51:02'),(242,1,'servicioMedico','Ha Insertado un nuevo  servicio medico','2025-05-12 14:51:11'),(243,1,'servicioMedico','Ha Insertado un nuevo  servicio medico','2025-05-12 14:51:18'),(244,1,'servicioMedico','Ha Insertado un nuevo  servicio medico','2025-05-12 14:51:26'),(245,1,'servicioMedico','Ha eliminado un   servicio medico','2025-05-12 14:51:33'),(246,1,'servicioMedico','Ha eliminado un   servicio medico','2025-05-12 14:51:40'),(247,1,'inicio sesion','Ha iniciado una session','2025-05-15 09:49:59'),(248,1,'inicio sesion','Ha iniciado una session','2025-05-15 09:57:46'),(249,1,'paciente','Ha Insertado un nuevo paciente','2025-05-15 10:20:04'),(250,1,'paciente','Ha Insertado un nuevo paciente','2025-05-15 10:20:50'),(251,1,'inicio sesion','Ha iniciado una session','2025-05-15 11:59:34'),(252,1,'insumo','Ha Insertado un insumo','2025-05-22 12:49:23'),(253,1,'hospitalizacion','Ha modificado una hospitalizacion','2025-05-22 12:49:56'),(254,1,'factura','Ha facturado servicios y/o insumos','2025-05-22 14:02:01'),(255,1,'inicio sesion','Ha iniciado una session','2025-05-22 20:23:40'),(256,1,'cerrar session','Ha cerrado la session ','2025-05-23 08:10:11'),(257,1,'inicio sesion','Ha iniciado una session','2025-05-23 08:10:27'),(258,1,'cerrar session','Ha cerrado la session ','2025-05-23 08:10:44'),(259,1,'inicio sesion','Ha iniciado una session','2025-05-23 08:16:29'),(260,1,'cerrar session','Ha cerrado la session ','2025-05-23 08:17:03'),(261,1,'inicio sesion','Ha iniciado una session','2025-05-23 08:17:14'),(262,1,'cerrar session','Ha cerrado la session ','2025-05-23 08:17:32'),(263,1,'inicio sesion','Ha iniciado una session','2025-05-23 08:17:42'),(264,1,'hospitalizacion','Ha Insertado una hospitalizacion','2025-05-23 08:19:25'),(265,1,'Consultas','Ha añadido un servicio medico a un doctor','2025-05-23 09:05:29'),(266,1,'cerrar session','Ha cerrado la session ','2025-05-24 09:39:07'),(267,1,'inicio sesion','Ha iniciado una session','2025-05-24 11:09:46'),(268,1,'inicio sesion','Ha iniciado una session','2025-05-25 21:03:46'),(269,1,'inicio sesion','Ha iniciado una session','2025-05-26 19:08:40'),(270,1,'inicio sesion','Ha iniciado una session','2025-05-27 15:18:09'),(271,1,'cita','Ha Insertado una  cita','2025-05-27 14:10:10'),(272,1,'cita','Ha Insertado una  cita','2025-05-27 15:11:35'),(273,1,'cita','Ha Insertado una  cita','2025-05-27 15:21:09'),(274,1,'cita','Ha Insertado una  cita','2025-05-27 15:23:28'),(275,1,'cita','Ha Insertado una  cita','2025-05-27 15:30:42'),(276,1,'cita','Ha Insertado una  cita','2025-05-27 15:40:57'),(277,1,'cerrar session','Ha cerrado la session ','2025-06-08 11:58:27'),(278,1,'inicio sesion','Ha iniciado una session','2025-06-08 16:34:47'),(279,1,'Perfil','Ha modificado un perfil','2025-06-08 17:09:30'),(280,1,'inicio sesion','Ha iniciado una session','2025-06-08 17:09:34'),(281,1,'inicio sesion','Ha iniciado una session','2025-06-09 09:22:48');
/*!40000 ALTER TABLE `bitacora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permisos`
--

DROP TABLE IF EXISTS `permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permisos` (
  `idpermisos` int(11) NOT NULL AUTO_INCREMENT,
  `id_rol` int(11) NOT NULL,
  `permisos` varchar(200) NOT NULL,
  `modulo` varchar(50) NOT NULL,
  PRIMARY KEY (`idpermisos`),
  KEY `id_rol` (`id_rol`),
  CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos`
--

LOCK TABLES `permisos` WRITE;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
INSERT INTO `permisos` VALUES (1,1,'consultar,guardar,editar,eliminar','Pacientes'),(2,5,'consultar','Pacientes'),(3,6,'consultar,guardar','Pacientes'),(4,7,'consultar,guardar','Pacientes'),(5,7,'consultar,guardar,editar,eliminar','Patologias'),(6,8,'consultar,guardar,editar,eliminar','Pacientes'),(7,8,'consultar,guardar,eliminar','Patologias'),(8,9,'consultar,guardar,editar,eliminar','Pacientes'),(9,9,'consultar,guardar,eliminar','Patologias'),(10,1,'consultar,guardar,editar,eliminar','Roles'),(11,1,'consultar,guardar,editar,eliminar','Usuarios'),(12,10,'consultar,guardar,editar,eliminar','Pacientes'),(13,10,'consultar,guardar,editar,eliminar','Patologias'),(14,10,'consultar,guardar,editar,eliminar','Factura'),(15,10,'consultar,guardar,editar,eliminar','Citas'),(16,10,'consultar,guardar,editar,eliminar','Consultas'),(17,10,'consultar,guardar,editar,eliminar','Doctores'),(18,10,'consultar,guardar,editar,eliminar','Control'),(19,10,'consultar,guardar,editar,eliminar','Hospitalizacion'),(20,10,'consultar,guardar,editar,eliminar','Insumos'),(21,10,'consultar,guardar,editar,eliminar','Entrada'),(22,10,'consultar,guardar,editar,eliminar','Proveedores'),(23,10,'consultar,guardar,editar,eliminar','Usuarios'),(24,10,'consultar,guardar,editar,eliminar','Roles'),(25,10,'consultar,guardar,editar,eliminar','Reportes'),(26,10,'consultar,guardar,editar,eliminar','Estadisticas'),(27,10,'consultar,guardar,editar,eliminar','Mantenimiento');
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `estado` varchar(45) NOT NULL,
  `descripción` varchar(45) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'administrador','ACT','administrador'),(5,'Rol','DES','este es un permiso par los doctores'),(6,'Propio','DES','descripcio'),(7,'Carlos','DES','jfhfdsjddjs'),(8,'Doctor','ACT','en un rol para los doctores'),(9,'Roletazo','DES','es un permiso de pruebas'),(10,'Superadmin','ACT','lsafdfjfd');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_rol` int(11) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `usuario` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `id_rol` (`id_rol`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,10,'','WDaniel123','wbaez975@gmail.com','$2y$10$1bMoW4177.FH45HrSHx/KOVV.LBAbDXnaGn1nMx3OtJ3MAah2NYnq','ACT'),(42,8,'img30.png','Usuario123','WDaniel123@gmail.com','$2y$10$1bMoW4177.FH45HrSHx/KOVV.LBAbDXnaGn1nMx3OtJ3MAah2NYnq','ACT'),(43,8,'img23.jpg','Usuario','WDaniel143@gmail.com','$2y$10$80gqRMUNCdZY2z7rKB7CxeCTQtH2zSJ/WdNBtaQ1/pHVyLWqNZvOW','ACT');
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

-- Dump completed on 2025-06-23 17:12:11
