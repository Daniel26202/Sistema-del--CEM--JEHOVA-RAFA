-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-05-2025 a las 05:44:21
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdlista`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id_bitacora` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tabla` varchar(30) NOT NULL,
  `actividad` text NOT NULL,
  `fecha_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id_bitacora`, `id_usuario`, `tabla`, `actividad`, `fecha_hora`) VALUES
(6, 1, 'inicio sesion', 'Ha iniciado una session', '2025-03-31 11:14:41'),
(7, 1, 'inicio sesion', 'Ha iniciado una session', '2025-03-31 12:05:23'),
(8, 1, 'inicio sesion', 'Ha iniciado una session', '2025-03-31 12:22:08'),
(9, 1, 'inicio sesion', 'Ha iniciado una session', '2025-03-31 12:54:08'),
(10, 1, 'cerrar session', 'Ha cerrado la session ', '2025-03-31 12:54:37'),
(11, 1, 'inicio sesion', 'Ha iniciado una session', '2025-03-31 12:56:04'),
(12, 1, 'cerrar session', 'Ha cerrado la session ', '2025-03-31 13:32:42'),
(13, 1, 'inicio sesion', 'Ha iniciado una session', '2025-03-31 13:32:52'),
(14, 1, 'inicio sesion', 'Ha iniciado una session', '2025-03-31 13:47:10'),
(15, 1, 'inicio sesion', 'Ha iniciado una session', '2025-03-31 16:10:52'),
(16, 1, 'inicio sesion', 'Ha iniciado una session', '2025-03-31 17:04:02'),
(17, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-02 10:05:43'),
(18, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-02 11:30:21'),
(19, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-02 11:54:59'),
(20, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-03 20:46:16'),
(21, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-04 17:18:31'),
(22, 1, 'cerrar session', 'Ha cerrado la session ', '2025-04-04 23:20:21'),
(23, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-05 09:18:47'),
(24, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-14 19:18:06'),
(25, 1, 'paciente', 'Ha Insertado un nuevo paciente', '2025-04-14 19:20:24'),
(26, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-14 19:25:47'),
(27, 1, 'Roles', 'Ha Insertado un nuevo rol', '2025-04-14 20:33:40'),
(28, 1, 'Roles', 'Ha Insertado un nuevo rol', '2025-04-14 20:35:37'),
(29, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-14 20:35:49'),
(30, 1, 'Roles', 'Ha Eliminado un rol', '2025-04-14 20:36:00'),
(31, 1, 'Roles', 'Ha Eliminado un rol', '2025-04-14 20:36:17'),
(32, 1, 'Roles', 'Ha Eliminado un rol', '2025-04-14 20:36:24'),
(33, 1, 'Roles', 'Ha Insertado un nuevo rol', '2025-04-14 20:36:54'),
(34, 1, 'doctor', 'Ha Insertado un doctor', '2025-04-14 20:39:06'),
(35, 1, 'servicioMedico', 'Ha Insertado un nuevo  servicio medico', '2025-04-14 20:39:21'),
(36, 1, 'cita', 'Ha Insertado una  cita', '2025-04-14 18:40:33'),
(37, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-15 10:05:28'),
(38, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-21 10:58:40'),
(39, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-15 15:39:07'),
(40, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-15 19:39:17'),
(41, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-15 21:13:58'),
(42, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-15 21:17:22'),
(43, 1, 'cerrar session', 'Ha cerrado la session ', '2025-04-15 21:32:10'),
(44, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-15 21:35:22'),
(45, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-16 08:27:48'),
(46, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-16 09:02:09'),
(47, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-16 19:16:15'),
(48, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-17 10:30:25'),
(49, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-17 10:47:58'),
(50, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-17 11:41:58'),
(51, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-17 11:42:22'),
(52, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-17 15:14:04'),
(53, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-17 15:27:56'),
(54, 1, 'cerrar session', 'Ha cerrado la session ', '2025-04-17 16:16:48'),
(55, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-17 16:16:56'),
(56, 1, 'cerrar session', 'Ha cerrado la session ', '2025-04-17 17:05:12'),
(57, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-17 17:05:56'),
(58, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-18 10:40:46'),
(59, 1, 'doctor', 'Ha Insertado un doctor', '2025-04-18 10:53:27'),
(60, 1, 'servicioMedico', 'Ha Insertado un nuevo  servicio medico', '2025-04-18 10:56:52'),
(61, 1, 'cita', 'Ha Insertado una  cita', '2025-04-18 09:01:22'),
(62, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-19 10:54:18'),
(63, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-19 11:17:57'),
(64, 1, 'cerrar session', 'Ha cerrado la session ', '2025-04-19 11:58:37'),
(65, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-19 21:09:28'),
(66, 1, 'cerrar session', 'Ha cerrado la session ', '2025-04-19 21:11:06'),
(67, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-19 21:17:04'),
(68, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-20 10:04:51'),
(69, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 10:19:51'),
(70, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 10:20:18'),
(71, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 10:35:40'),
(72, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 10:49:30'),
(73, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 10:50:25'),
(74, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 10:52:12'),
(75, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 10:52:59'),
(76, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 10:53:02'),
(77, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 10:54:04'),
(78, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 10:54:36'),
(79, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 10:54:48'),
(80, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 10:54:53'),
(81, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 10:55:11'),
(82, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 11:07:04'),
(83, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 11:07:27'),
(84, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 11:08:45'),
(85, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 11:09:04'),
(86, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 11:09:19'),
(87, 1, 'Roles', 'Ha Insertado un nuevo rol', '2025-04-20 11:13:53'),
(88, 1, 'Roles', 'Ha Eliminado un rol', '2025-04-20 11:14:09'),
(89, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 11:17:33'),
(90, 1, 'Roles', 'Ha Modiicado un rol', '2025-04-20 11:17:42'),
(91, 1, 'categoria_servicio', 'Ha eliminado una  categoria', '2025-04-20 11:24:29'),
(92, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-21 16:13:23'),
(93, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-21 16:46:06'),
(94, 1, 'entrada', 'Ha insertado una entrada', '2025-04-21 16:48:42'),
(95, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-21 17:15:28'),
(96, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-21 17:16:21'),
(97, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-21 17:30:59'),
(98, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-21 19:31:34'),
(99, 1, 'entrada', 'Ha insertado una entrada', '2025-04-21 19:39:46'),
(100, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-21 19:41:28'),
(101, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-21 19:51:30'),
(102, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-21 19:54:51'),
(103, 1, 'entrada', 'Ha insertado una entrada', '2025-04-21 19:59:19'),
(104, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-21 20:00:00'),
(105, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-21 20:03:13'),
(106, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-04-21 20:05:17'),
(107, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-21 20:08:29'),
(108, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-22 10:45:39'),
(109, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-22 10:47:29'),
(110, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-22 11:09:02'),
(111, 1, 'proveedor', 'Ha modificado un proveedor', '2025-04-22 11:28:19'),
(112, 1, 'Roles', 'Ha Insertado un nuevo rol', '2025-04-22 12:41:55'),
(113, 1, 'cerrar session', 'Ha cerrado la session ', '2025-04-22 12:42:49'),
(114, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-22 12:43:20'),
(115, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-27 21:00:54'),
(116, 1, 'cerrar session', 'Ha cerrado la session ', '2025-04-27 21:03:03'),
(117, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-27 21:26:17'),
(118, 1, 'cerrar session', 'Ha cerrado la session ', '2025-04-27 21:28:33'),
(119, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-27 21:28:43'),
(120, 1, 'control', 'Ha modificado un  control medico', '2025-04-27 21:33:26'),
(121, 1, 'control', 'Ha modificado un  control medico', '2025-04-27 21:33:39'),
(122, 1, 'sintomas', 'Ha Insertado un  sintoma', '2025-04-27 21:37:41'),
(123, 1, 'sintomas', 'Ha eliminado un  sintoma', '2025-04-27 21:37:49'),
(124, 1, 'cerrar session', 'Ha cerrado la session ', '2025-04-27 21:56:58'),
(125, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-27 21:57:29'),
(126, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-28 14:37:36'),
(127, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-04-28 14:38:01'),
(128, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-04-28 14:38:29'),
(129, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-04-28 14:42:27'),
(130, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-29 01:41:48'),
(131, 1, 'hospitalizacion', 'Ha eliminado una hospitalizacion', '2025-04-29 02:54:29'),
(132, 1, 'hospitalizacion', 'Ha eliminado una hospitalizacion', '2025-04-29 02:54:38'),
(133, 1, 'insumo', 'Ha Insertado un insumo', '2025-04-29 03:23:45'),
(134, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-04-29 03:32:05'),
(135, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-04-29 03:32:17'),
(136, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-29 11:38:32'),
(137, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-29 12:25:47'),
(138, 1, 'cerrar session', 'Ha cerrado la session ', '2025-04-29 12:29:02'),
(139, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-29 12:29:39'),
(140, 1, 'cerrar session', 'Ha cerrado la session ', '2025-04-29 12:35:09'),
(141, 1, 'inicio sesion', 'Ha iniciado una session', '2025-04-29 12:35:32'),
(142, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-01 11:11:28'),
(143, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-01 14:35:55'),
(144, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-05-01 15:12:29'),
(145, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-05-01 15:22:06'),
(146, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-05-01 15:22:47'),
(147, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-05-01 15:54:12'),
(148, 1, 'cerrar session', 'Ha cerrado la session ', '2025-05-01 16:23:01'),
(149, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-01 16:55:24'),
(150, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-01 18:01:42'),
(151, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-02 09:14:38'),
(152, 1, 'Roles', 'Ha Modiicado un rol', '2025-05-02 09:46:35'),
(153, 1, 'cerrar session', 'Ha cerrado la session ', '2025-05-02 09:46:41'),
(154, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-02 09:47:54'),
(155, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-05-02 11:09:19'),
(156, 1, 'insumo', 'Ha Insertado un insumo', '2025-05-02 11:37:07'),
(157, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-02 15:39:42'),
(158, 1, 'insumo', 'Ha eliminado un insumo', '2025-05-02 15:49:40'),
(159, 1, 'insumo', 'Ha eliminado un insumo', '2025-05-02 15:49:46'),
(160, 1, 'insumo', 'Ha Insertado un insumo', '2025-05-02 15:51:38'),
(161, 1, 'insumo', 'Ha eliminado un insumo', '2025-05-02 15:52:48'),
(162, 1, 'insumo', 'Ha eliminado un insumo', '2025-05-02 15:52:56'),
(163, 1, 'entrada', 'Ha insertado una entrada', '2025-05-02 15:59:16'),
(164, 1, 'insumo', 'Ha modificado un insumo', '2025-05-02 16:01:29'),
(165, 1, 'insumo', 'Ha modificado un insumo', '2025-05-02 16:01:50'),
(166, 1, 'insumo', 'Ha modificado un insumo', '2025-05-02 16:05:15'),
(167, 1, 'insumo', 'Ha modificado un insumo', '2025-05-02 16:08:31'),
(168, 1, 'insumo', 'Ha modificado un insumo', '2025-05-02 16:09:52'),
(169, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-03 08:08:17'),
(170, 1, 'cita', 'Ha Insertado una  cita', '2025-05-03 08:02:42'),
(171, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-05-03 10:03:37'),
(172, 1, 'cerrar session', 'Ha cerrado la session ', '2025-05-03 10:03:50'),
(173, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-03 10:04:05'),
(174, 42, 'inicio sesion', 'Ha iniciado una session', '2025-05-03 10:05:34'),
(175, 42, 'cerrar session', 'Ha cerrado la session ', '2025-05-03 10:18:27'),
(176, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-03 11:06:03'),
(177, 1, 'cita', 'Ha Insertado una  cita', '2025-05-03 09:18:06'),
(178, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-05-03 11:42:13'),
(179, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-03 20:05:34'),
(180, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-03 20:28:49'),
(181, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-03 21:10:14'),
(182, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-04 20:33:30'),
(183, 1, 'patologia', 'Ha Insertado una patologia', '2025-05-04 20:37:52'),
(184, 1, 'paciente', 'Ha modificado un paciente', '2025-05-04 20:45:17'),
(185, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-05 09:35:01'),
(186, 1, 'servicioMedico', 'Ha Insertado un nuevo  servicio medico', '2025-05-05 09:56:34'),
(187, 1, 'servicioMedico', 'Ha Insertado un nuevo  servicio medico', '2025-05-05 09:58:17'),
(188, 1, 'servicioMedico', 'Ha Insertado un nuevo  servicio medico', '2025-05-05 10:06:56'),
(189, 1, 'servicioMedico', 'Ha Insertado un nuevo  servicio medico', '2025-05-05 10:08:30'),
(190, 1, 'servicioMedico', 'Ha eliminado un   servicio medico', '2025-05-05 10:19:39'),
(191, 1, 'servicioMedico', 'Ha eliminado un   servicio medico', '2025-05-05 10:19:42'),
(192, 1, 'servicioMedico', 'Ha eliminado un   servicio medico', '2025-05-05 10:19:46'),
(193, 1, 'servicioMedico', 'Ha eliminado un   servicio medico', '2025-05-05 10:19:50'),
(194, 1, 'servicioMedico', 'Ha eliminado un   servicio medico', '2025-05-05 10:19:53'),
(195, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-05 19:24:49'),
(196, 1, 'insumo', 'Ha Insertado un insumo', '2025-05-05 20:04:03'),
(197, 1, 'entrada', 'Ha insertado una entrada', '2025-05-05 20:08:16'),
(198, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-05-05 20:10:41'),
(199, 1, 'entrada', 'Ha eliminado una entrada', '2025-05-05 20:16:24'),
(200, 1, 'servicioMedico', 'Ha Insertado un nuevo  servicio medico', '2025-05-05 20:39:13'),
(201, 1, 'servicioMedico', 'Ha modificadp un servicio medico', '2025-05-05 20:42:53'),
(202, 1, 'servicioMedico', 'Ha eliminado un   servicio medico', '2025-05-05 20:43:12'),
(203, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-07 16:16:11'),
(204, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-05-07 21:27:14'),
(205, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-05-07 21:30:01'),
(206, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-05-07 21:30:49'),
(207, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-05-07 21:31:45'),
(208, 1, 'insumo', 'Ha eliminado un insumo', '2025-05-07 21:32:10'),
(209, 1, 'insumo', 'Ha Insertado un insumo', '2025-05-07 21:35:10'),
(210, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-05-07 21:35:50'),
(211, 1, 'servicioMedico', 'Ha Insertado un nuevo  servicio medico', '2025-05-07 21:39:45'),
(212, 1, 'servicioMedico', 'Ha modificadp un servicio medico', '2025-05-07 22:14:16'),
(213, 1, 'proveedor', 'Ha modificado un proveedor', '2025-05-07 22:23:23'),
(214, 1, 'cerrar session', 'Ha cerrado la session ', '2025-05-07 22:25:18'),
(215, 42, 'inicio sesion', 'Ha iniciado una session', '2025-05-07 22:25:22'),
(216, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-07 22:25:39'),
(217, 1, 'cerrar session', 'Ha cerrado la session ', '2025-05-07 22:25:56'),
(218, 42, 'inicio sesion', 'Ha iniciado una session', '2025-05-07 22:25:59'),
(219, 42, 'patologia', 'Ha Insertado una patologia', '2025-05-07 22:26:27'),
(220, 42, 'cerrar session', 'Ha cerrado la session ', '2025-05-07 22:26:33'),
(221, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-07 22:26:36'),
(222, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-08 09:58:46'),
(223, 1, 'insumo', 'Ha Insertado un insumo', '2025-05-08 10:25:09'),
(224, 1, 'insumo', 'Ha eliminado un insumo', '2025-05-08 10:25:48'),
(225, 1, 'insumo', 'Ha Insertado un insumo', '2025-05-08 10:39:37'),
(226, 1, 'insumo', 'Ha Insertado un insumo', '2025-05-08 10:43:52'),
(227, 1, 'insumo', 'Ha eliminado un insumo', '2025-05-08 10:43:59'),
(228, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-09 10:48:22'),
(229, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-12 09:28:51'),
(230, 1, 'cerrar session', 'Ha cerrado la session ', '2025-05-12 11:20:25'),
(231, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-12 11:23:03'),
(232, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-12 11:27:59'),
(233, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-12 11:33:54'),
(234, 1, 'servicioMedico', 'Ha modificadp un servicio medico', '2025-05-12 13:07:37'),
(235, 1, 'Roles', 'Ha Modiicado un rol', '2025-05-12 13:49:08'),
(236, 1, 'Roles', 'Ha Modiicado un rol', '2025-05-12 13:50:19'),
(237, 1, 'cerrar session', 'Ha cerrado la session ', '2025-05-12 13:50:35'),
(238, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-12 13:50:38'),
(239, 1, 'categoria_servicio', 'Ha Insertado una nueva  categoria', '2025-05-12 14:50:13'),
(240, 1, 'categoria_servicio', 'Ha Insertado una nueva  categoria', '2025-05-12 14:50:24'),
(241, 1, 'categoria_servicio', 'Ha Insertado una nueva  categoria', '2025-05-12 14:51:02'),
(242, 1, 'servicioMedico', 'Ha Insertado un nuevo  servicio medico', '2025-05-12 14:51:11'),
(243, 1, 'servicioMedico', 'Ha Insertado un nuevo  servicio medico', '2025-05-12 14:51:18'),
(244, 1, 'servicioMedico', 'Ha Insertado un nuevo  servicio medico', '2025-05-12 14:51:26'),
(245, 1, 'servicioMedico', 'Ha eliminado un   servicio medico', '2025-05-12 14:51:33'),
(246, 1, 'servicioMedico', 'Ha eliminado un   servicio medico', '2025-05-12 14:51:40'),
(247, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-15 09:49:59'),
(248, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-15 09:57:46'),
(249, 1, 'paciente', 'Ha Insertado un nuevo paciente', '2025-05-15 10:20:04'),
(250, 1, 'paciente', 'Ha Insertado un nuevo paciente', '2025-05-15 10:20:50'),
(251, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-15 11:59:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_servicio`
--

CREATE TABLE `categoria_servicio` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `estado` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria_servicio`
--

INSERT INTO `categoria_servicio` (`id_categoria`, `nombre`, `estado`) VALUES
(1, 'CARDIOLOGIA', 'ACT'),
(2, 'ONCOLOGIA', 'ACT'),
(9, 'RADIOGRAFIA', 'DES'),
(100, 'CONSULTA GENERAL', 'ACT'),
(101, 'Emergencia', 'ACT'),
(102, 'Acupuntura', 'ACT'),
(103, 'Oftalmología', 'ACT'),
(104, 'Odontología', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `id_cita` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `serviciomedico_id_servicioMedico` int(11) NOT NULL,
  `paciente_id_paciente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id_cita`, `fecha`, `hora`, `estado`, `serviciomedico_id_servicioMedico`, `paciente_id_paciente`) VALUES
(41, '2025-04-02', '12:33:00', 'ACT', 24, 23),
(42, '2025-04-02', '12:33:00', 'ACT', 25, 23),
(43, '2025-04-02', '12:33:00', 'ACT', 22, 23),
(44, '2025-04-02', '12:33:00', 'ACT', 22, 23),
(45, '2025-04-21', '22:00:00', 'Realizadas', 26, 25),
(46, '2025-04-25', '12:00:00', 'Pendiente', 27, 25),
(47, '2025-05-05', '20:00:00', 'Realizadas', 26, 25),
(48, '2025-05-12', '20:00:00', 'Pendiente', 26, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control`
--

CREATE TABLE `control` (
  `id_control` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `diagnostico` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `medicamentosRecetados` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fecha_control` datetime NOT NULL,
  `fechaRegreso` date NOT NULL,
  `nota` varchar(40) NOT NULL,
  `historiaclinica` text NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `control`
--

INSERT INTO `control` (`id_control`, `id_paciente`, `id_usuario`, `diagnostico`, `medicamentosRecetados`, `fecha_control`, `fechaRegreso`, `nota`, `historiaclinica`, `estado`) VALUES
(26, 23, 1, 'El chico presenta dificultad para respirar, hinchazón en el cuerpo y dolores de cabeza', 'Cetirizina\r\nSalbutamol\r\nAcetaminofén', '2025-04-02 14:37:34', '2025-04-26', 'Debe hacerse hematología completa', '', 'ACT'),
(27, 24, 1, 'La paciente presenta severos dolores de cabeza, lo cual da a entender que tiene episodios de jaqueca, a su vez también presenta problemas con la visión y mareos\r\nTomar mucha agua', 'Diclofenac potasico\r\nCafeína\r\nViajesan', '2025-04-02 14:45:09', '2025-04-23', 'Tomar mucha agua', 'historiaclinica', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada`
--

CREATE TABLE `entrada` (
  `id_entrada` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `numero_de_lote` int(16) NOT NULL,
  `fechaDeIngreso` date NOT NULL,
  `estado` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `entrada`
--

INSERT INTO `entrada` (`id_entrada`, `id_proveedor`, `numero_de_lote`, `fechaDeIngreso`, `estado`) VALUES
(38, 6, 1, '2025-04-05', 'ACT'),
(39, 7, 2, '2025-04-06', 'ACT'),
(40, 6, 3435, '2025-04-21', 'ACT'),
(41, 6, 3435, '2025-04-21', 'ACT'),
(42, 7, 3456, '2025-04-21', 'ACT'),
(43, 6, 1233, '2025-04-21', 'ACT'),
(44, 7, 3232, '2025-04-29', 'ACT'),
(45, 7, 3232, '2025-04-29', 'ACT'),
(46, 7, 3232, '2025-04-29', 'ACT'),
(47, 7, 3232, '2025-04-29', 'ACT'),
(48, 6, 3232, '2025-05-02', 'ACT'),
(49, 7, 1212, '2025-05-02', 'ACT'),
(50, 6, 2334, '2025-05-02', 'ACT'),
(51, 7, 2323, '2025-05-05', 'ACT'),
(52, 7, 4553, '2025-05-05', 'ACT'),
(53, 7, 4553, '2025-05-05', 'DES'),
(54, 7, 2323, '2025-05-07', 'ACT'),
(55, 6, 2323, '2025-05-08', 'ACT'),
(56, 6, 2323, '2025-05-08', 'ACT'),
(57, 6, 1212, '2025-05-08', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_insumo`
--

CREATE TABLE `entrada_insumo` (
  `id_entradaDeInsumo` int(11) NOT NULL,
  `id_insumo` int(11) NOT NULL,
  `id_entrada` int(11) NOT NULL,
  `fechaDeVencimiento` date NOT NULL,
  `precio` decimal(12,2) NOT NULL,
  `cantidad_entrante` int(12) NOT NULL,
  `cantidad_disponible` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `id_especialidad` int(11) NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`id_especialidad`, `nombre`, `estado`) VALUES
(3, 'Cardiología', 'ACT'),
(4, 'Paramedico', 'ACT'),
(5, 'Enfermeria', 'ACT'),
(6, 'administrador', 'ACT'),
(7, 'Cirugia', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `total` float(12,2) NOT NULL,
  `estado` varchar(10) NOT NULL,
  `paciente_id_paciente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_factura`, `fecha`, `total`, `estado`, `paciente_id_paciente`) VALUES
(57, '2025-04-14', 1000.00, 'ACT', 25),
(58, '2025-04-14', 1000.00, 'ACT', 25),
(61, '2025-04-21', 1123.00, 'ACT', 25),
(62, '2025-04-15', 1000.00, 'ACT', 25),
(63, '2025-04-15', 1000.00, 'ACT', 25),
(64, '2025-04-16', 125.00, 'ACT', 25),
(65, '2025-04-16', 125.00, 'ACT', 25),
(66, '2025-04-17', 125.00, 'ACT', 25),
(67, '2025-04-17', 415.00, 'ACT', 25),
(68, '2025-04-17', 158.00, 'ACT', 25),
(69, '2025-04-17', 330.00, 'ACT', 25),
(70, '2025-04-17', 25.00, 'ACT', 25),
(71, '2025-04-17', 430.00, 'ACT', 25),
(72, '2025-04-17', 199.00, 'ACT', 25),
(73, '2025-04-17', 58.00, 'ACT', 25),
(74, '2025-04-17', 58.00, 'ACT', 25),
(75, '2025-04-17', 58.00, 'ACT', 25),
(76, '2025-04-17', 50.00, 'ACT', 25),
(77, '2025-04-17', 75.00, 'ACT', 25),
(78, '2025-04-21', 25.00, 'ACT', 25),
(79, '2025-04-21', 123.96, 'ACT', 25),
(80, '2025-04-21', 103.30, 'ACT', 25),
(81, '2025-04-21', 123.96, 'ACT', 25),
(82, '2025-04-21', 123.96, 'ACT', 25),
(83, '2025-04-21', 10.33, 'ACT', 25),
(84, '2025-04-21', 30.99, 'ACT', 25),
(85, '2025-04-21', 22.77, 'ACT', 25),
(86, '2025-04-21', 16.55, 'ACT', 25),
(87, '2025-04-21', 16.55, 'ACT', 25),
(88, '2025-04-21', 125.30, 'ACT', 25),
(89, '2025-04-21', 35.80, 'ACT', 25),
(90, '2025-04-21', 17.90, 'ACT', 25),
(91, '2025-05-01', 2129.30, 'ACT', 23),
(92, '2025-05-01', 1127.20, 'ACT', 23),
(93, '2025-05-01', 1123.00, 'ACT', 23),
(94, '2025-05-01', 2.10, 'ACT', 23),
(95, '2025-05-03', 182.12, 'ACT', 25),
(96, '2025-05-03', 1000.00, 'ACT', 25),
(97, '2025-05-05', 129.00, 'ACT', 25),
(98, '2025-05-07', 1.20, 'ACT', 25),
(99, '2025-05-07', 29.56, 'ACT', 25),
(100, '2025-05-07', 30.16, 'ACT', 25),
(101, '2025-05-07', 0.60, 'ACT', 25),
(102, '2025-05-07', 1230.00, 'ACT', 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_has_inventario`
--

CREATE TABLE `factura_has_inventario` (
  `factura_id_factura` int(11) NOT NULL,
  `inventario_id_inventario` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `factura_has_inventario`
--

INSERT INTO `factura_has_inventario` (`factura_id_factura`, `inventario_id_inventario`, `cantidad`, `estado`) VALUES
(65, 1, 5, 'ACT'),
(66, 1, 5, 'ACT'),
(67, 2, 4, 'ACT'),
(68, 2, 1, 'ACT'),
(69, 2, 10, 'ACT'),
(70, 1, 1, 'ACT'),
(71, 2, 10, 'ACT'),
(72, 2, 3, 'ACT'),
(73, 2, 1, 'ACT'),
(74, 2, 1, 'ACT'),
(75, 2, 1, 'ACT'),
(76, 1, 1, 'ACT'),
(77, 1, 1, 'ACT'),
(77, 1, 2, 'ACT'),
(78, 1, 1, 'ACT'),
(80, 1, 10, 'ACT'),
(81, 1, 1, 'ACT'),
(82, 1, 1, 'ACT'),
(82, 3, 1, 'ACT'),
(82, 3, 1, 'ACT'),
(82, 1, 11, 'ACT'),
(82, 3, 11, 'ACT'),
(82, 3, 11, 'ACT'),
(83, 1, 1, 'ACT'),
(83, 3, 1, 'ACT'),
(84, 1, 1, 'ACT'),
(84, 3, 1, 'ACT'),
(84, 1, 2, 'ACT'),
(84, 3, 2, 'ACT'),
(85, 1, 1, 'ACT'),
(85, 3, 1, 'ACT'),
(85, 2, 2, 'ACT'),
(85, 4, 2, 'ACT'),
(86, 1, 1, 'ACT'),
(86, 3, 1, 'ACT'),
(86, 2, 1, 'ACT'),
(86, 4, 1, 'ACT'),
(87, 1, 1, 'ACT'),
(87, 2, 1, 'ACT'),
(88, 5, 7, 'ACT'),
(88, 4, 7, 'ACT'),
(89, 4, 1, 'ACT'),
(89, 4, 1, 'ACT'),
(90, 4, 1, 'ACT'),
(65, 1, 5, 'ACT'),
(66, 1, 5, 'ACT'),
(67, 2, 4, 'ACT'),
(68, 2, 1, 'ACT'),
(69, 2, 10, 'ACT'),
(70, 1, 1, 'ACT'),
(71, 2, 10, 'ACT'),
(72, 2, 3, 'ACT'),
(73, 2, 1, 'ACT'),
(74, 2, 1, 'ACT'),
(75, 2, 1, 'ACT'),
(76, 1, 1, 'ACT'),
(77, 1, 1, 'ACT'),
(77, 1, 2, 'ACT'),
(78, 1, 1, 'ACT'),
(80, 1, 10, 'ACT'),
(81, 1, 1, 'ACT'),
(82, 1, 1, 'ACT'),
(82, 3, 1, 'ACT'),
(82, 3, 1, 'ACT'),
(82, 1, 11, 'ACT'),
(82, 3, 11, 'ACT'),
(82, 3, 11, 'ACT'),
(83, 1, 1, 'ACT'),
(83, 3, 1, 'ACT'),
(84, 1, 1, 'ACT'),
(84, 3, 1, 'ACT'),
(84, 1, 2, 'ACT'),
(84, 3, 2, 'ACT'),
(85, 1, 1, 'ACT'),
(85, 3, 1, 'ACT'),
(85, 2, 2, 'ACT'),
(85, 4, 2, 'ACT'),
(86, 1, 1, 'ACT'),
(86, 3, 1, 'ACT'),
(86, 2, 1, 'ACT'),
(86, 4, 1, 'ACT'),
(87, 1, 1, 'ACT'),
(87, 2, 1, 'ACT'),
(88, 5, 7, 'ACT'),
(88, 4, 7, 'ACT'),
(89, 4, 1, 'ACT'),
(89, 4, 1, 'ACT'),
(90, 4, 1, 'ACT'),
(91, 6, 3, 'ACT'),
(92, 6, 2, 'ACT'),
(94, 6, 1, 'ACT'),
(95, 8, 2, 'ACT'),
(97, 10, 10, 'ACT'),
(98, 10, 2, 'ACT'),
(99, 8, 1, 'ACT'),
(100, 8, 1, 'ACT'),
(100, 10, 1, 'ACT'),
(101, 10, 1, 'ACT'),
(102, 12, 10, 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `diaslaborables` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id_horario`, `diaslaborables`) VALUES
(8, 'domingo'),
(9, 'lunes'),
(10, 'martes'),
(11, 'miércoles'),
(12, 'jueves'),
(13, 'viernes'),
(14, 'sábado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarioydoctor`
--

CREATE TABLE `horarioydoctor` (
  `id_horarioydoctor` int(11) NOT NULL,
  `id_personal` int(11) NOT NULL,
  `id_horario` int(11) NOT NULL,
  `horaDeEntrada` time NOT NULL,
  `horaDeSalida` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `horarioydoctor`
--

INSERT INTO `horarioydoctor` (`id_horarioydoctor`, `id_personal`, `id_horario`, `horaDeEntrada`, `horaDeSalida`) VALUES
(30, 19, 9, '20:00:00', '22:00:00'),
(31, 20, 13, '10:00:00', '13:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hospitalizacion`
--

CREATE TABLE `hospitalizacion` (
  `id_hospitalizacion` int(11) NOT NULL,
  `fecha_hora_inicio` datetime NOT NULL,
  `precio_horas` float DEFAULT NULL,
  `precio_horas_MoEx` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `total_MoEx` float DEFAULT NULL,
  `id_control` int(11) NOT NULL,
  `fecha_hora_final` datetime DEFAULT NULL,
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `hospitalizacion`
--

INSERT INTO `hospitalizacion` (`id_hospitalizacion`, `fecha_hora_inicio`, `precio_horas`, `precio_horas_MoEx`, `total`, `total_MoEx`, `id_control`, `fecha_hora_final`, `estado`) VALUES
(11, '2025-04-28 18:37:52', 0, NULL, 0, NULL, 27, '0000-00-00 00:00:00', 'DES'),
(12, '2025-04-28 18:42:13', 0, NULL, 0, NULL, 26, '0000-00-00 00:00:00', 'DES'),
(13, '2025-04-29 07:32:00', 0, NULL, 0, NULL, 27, '0000-00-00 00:00:00', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo`
--

CREATE TABLE `insumo` (
  `id_insumo` int(11) NOT NULL,
  `imagen` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `descripcion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `marca` varchar(35) NOT NULL,
  `medida` varchar(35) NOT NULL,
  `precio` float(12,2) NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `stockMinimo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `insumo`
--

INSERT INTO `insumo` (`id_insumo`, `imagen`, `nombre`, `descripcion`, `marca`, `medida`, `precio`, `estado`, `stockMinimo`) VALUES
(24, '', 'Paracetamol', 'El paracetamol, también conocido como acetaminofén o acetaminofeno, es un fármaco con propiedades analgésicas y antipiréticas utilizado principalmente para tratar la fiebre y el dolor leve y moderado', '', '', 10.33, 'DES', 0),
(25, '', 'Ibuprofeno', 'El ibuprofeno es un antinflamatorio no esteroideo (AINE) que pertenece al subgrupo de fármacos derivados del ácido propiónico.', '', '', 17.90, 'DES', 0),
(29, '2025-04-29_1745911425_WhatsApp Image 2025-04-03 at 11.51.47 PM.jpeg', 'Ibuprofeno', 'descripción', '', '', 2.10, 'DES', 0),
(30, '2025-05-02_1746200226_9amALQfcTkJsr2zlMRcpi99AnctFZBjlnRxibrip.jpg', 'Ibuprofeno', 'descripción', '', '', 2.10, 'DES', 0),
(31, '2025-05-02_1746216592_img27.jpg', 'Insumo', 'Es un antinflamatorio son derivados del ácido propiónico.', 'Tecno spar 30212 ', '400 ml', 29.56, 'ACT', 1),
(32, '2025-05-05_1746489843_img23.jpg', 'Lobo', 'Es un lobo malvado', 'Tecno spar 30212 ', '400 ml', 0.60, 'DES', 1),
(33, '2025-05-07_1746668110_img16.jpg', 'Spidermas', 'Es un antinflamatorio son derivados del ácido propiónico.', 'Tecno spar 30212 ', '600 ml', 123.00, 'ACT', 1),
(34, '2025-05-08_1746714309_img5.jpg', 'Caballero', 'El ibuprofeno es un antinflamaupo de fármacos derivados del ácido propiónico.', 'Tecno spar 30212', '600 ml', 2040.00, 'DES', 1),
(35, '2025-05-08_1746715177_img29.jpg', 'Insumodolar', 'Es un antinflamatorio son derivados del ácido propiónico.', 'Tecno spar 30212 ', '200 ml', 870.00, 'DES', 5),
(36, '2025-05-08_1746715431_img7.jpg', 'Ansumo', 'El ibuprofeno e', 'Tecno spar 3022 ', '400 ml', 80.00, 'ACT', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumodehospitalizacion`
--

CREATE TABLE `insumodehospitalizacion` (
  `id_insumoDeHospitalizacion` int(11) NOT NULL,
  `id_hospitalizacion` int(11) NOT NULL,
  `id_inventario` int(11) NOT NULL,
  `cantidad` int(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_inventario` int(11) NOT NULL,
  `id_insumo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fechaDeVencimiento` date NOT NULL,
  `numero_de_lote` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id_inventario`, `id_insumo`, `cantidad`, `fechaDeVencimiento`, `numero_de_lote`) VALUES
(1, 24, 0, '2030-04-01', 1),
(2, 25, 0, '2030-04-01', 2),
(3, 24, 0, '2025-11-11', 3435),
(4, 25, 0, '2025-12-12', 3456),
(5, 25, 0, '2034-02-11', 1233),
(6, 29, 4, '2025-05-10', 3232),
(7, 30, 10, '2025-05-29', 3232),
(8, 31, 28, '2025-05-31', 1212),
(9, 31, 28, '2025-05-31', 2334),
(10, 32, 20, '2025-05-31', 2323),
(11, 32, 20, '2029-02-12', 4553),
(12, 33, 0, '2025-05-12', 2323),
(13, 34, 12, '2025-05-25', 2323),
(14, 35, 12, '2026-05-31', 2323),
(15, 36, 20, '2029-05-08', 1212);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `id_paciente` int(11) NOT NULL,
  `nacionalidad` varchar(12) NOT NULL,
  `cedula` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `apellido` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `telefono` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `direccion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fn` date NOT NULL,
  `genero` varchar(16) NOT NULL,
  `estado` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`id_paciente`, `nacionalidad`, `cedula`, `nombre`, `apellido`, `telefono`, `direccion`, `fn`, `genero`, `estado`) VALUES
(23, 'V', '28150004', 'Juan', 'Silva', '04121338031', 'Calle 10 entre 3 y 7', '2001-09-22', 'masculino', 'ACT'),
(24, 'V', '28329224', 'Rocio', 'Rodriguez', '04121338031', 'URB EL BOSQUE CALLE 12', '2025-04-02', 'femenino', 'ACT'),
(25, 'V', '30554144', 'Carlos', 'Hernadéz', '04121232343', 'Eb su casa', '2012-02-11', 'masculino', 'ACT'),
(26, 'V', '17664525', 'Sofia', 'Sofia', '4121338031', 'Direccion', '2001-09-22', 'Femenino', 'ACT'),
(27, 'V', '158961', 'Aaaa', 'Aaaa', '4121338032', 'Direccion', '2001-09-22', 'Masculino', 'ACT'),
(28, 'V', '2000001', 'Argentina', 'Apellido_1', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(29, 'V', '2000002', 'Brasil', 'Apellido_2', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(30, 'V', '2000003', 'Chile', 'Apellido_3', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(31, 'V', '2000004', 'Colombia', 'Apellido_4', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(32, 'V', '2000005', 'México', 'Apellido_5', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(33, 'V', '2000006', 'Perú', 'Apellido_6', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(34, 'V', '2000007', 'Uruguay', 'Apellido_7', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(35, 'V', '2000008', 'Venezuela', 'Apellido_8', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(36, 'V', '2000009', 'Ecuador', 'Apellido_9', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(37, 'V', '2000010', 'Bolivia', 'Apellido_10', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(38, 'V', '2000011', 'Paraguay', 'Apellido_11', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(39, 'V', '2000012', 'Panamá', 'Apellido_12', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(40, 'V', '2000013', 'Costa Rica', 'Apellido_13', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(41, 'V', '2000014', 'Guatemala', 'Apellido_14', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(42, 'V', '2000015', 'El Salvador', 'Apellido_15', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(43, 'V', '2000016', 'Honduras', 'Apellido_16', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(44, 'V', '2000017', 'Nicaragua', 'Apellido_17', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(45, 'V', '2000018', 'Cuba', 'Apellido_18', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(46, 'V', '2000019', 'República Dominicana', 'Apellido_19', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(47, 'V', '2000020', 'Puerto Rico', 'Apellido_20', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(48, 'V', '2000021', 'Canadá', 'Apellido_21', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(49, 'V', '2000022', 'España', 'Apellido_22', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(50, 'V', '2000023', 'Francia', 'Apellido_23', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(51, 'V', '2000024', 'Italia', 'Apellido_24', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(52, 'V', '2000025', 'Alemania', 'Apellido_25', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(53, 'V', '2000026', 'Portugal', 'Apellido_26', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(54, 'V', '2000027', 'Grecia', 'Apellido_27', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(55, 'V', '2000028', 'Rusia', 'Apellido_28', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(56, 'V', '2000029', 'China', 'Apellido_29', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(57, 'V', '2000030', 'Japón', 'Apellido_30', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(58, 'V', '2000031', 'Corea del Sur', 'Apellido_31', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(59, 'V', '2000032', 'India', 'Apellido_32', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(60, 'V', '2000033', 'Australia', 'Apellido_33', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(61, 'V', '2000034', 'Nueva Zelanda', 'Apellido_34', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(62, 'V', '2000035', 'Egipto', 'Apellido_35', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(63, 'V', '2000036', 'Sudáfrica', 'Apellido_36', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(64, 'V', '2000037', 'Nigeria', 'Apellido_37', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(65, 'V', '2000038', 'Kenia', 'Apellido_38', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(66, 'V', '2000039', 'Senegal', 'Apellido_39', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(67, 'V', '2000040', 'Túnez', 'Apellido_40', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT'),
(68, 'V', '2000041', 'Argentina', 'Apellido_41', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(69, 'V', '2000042', 'Brasil', 'Apellido_42', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(70, 'V', '2000043', 'Chile', 'Apellido_43', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(71, 'V', '2000044', 'Colombia', 'Apellido_44', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(72, 'V', '2000045', 'México', 'Apellido_45', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(73, 'V', '2000046', 'Perú', 'Apellido_46', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(74, 'V', '2000047', 'Uruguay', 'Apellido_47', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(75, 'V', '2000048', 'Venezuela', 'Apellido_48', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(76, 'V', '2000049', 'Ecuador', 'Apellido_49', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(77, 'V', '2000050', 'Bolivia', 'Apellido_50', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(78, 'V', '2000051', 'Paraguay', 'Apellido_51', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(79, 'V', '2000052', 'Panamá', 'Apellido_52', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(80, 'V', '2000053', 'Costa Rica', 'Apellido_53', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(81, 'V', '2000054', 'Guatemala', 'Apellido_54', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(82, 'V', '2000055', 'El Salvador', 'Apellido_55', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(83, 'V', '2000056', 'Honduras', 'Apellido_56', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(84, 'V', '2000057', 'Nicaragua', 'Apellido_57', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(85, 'V', '2000058', 'Cuba', 'Apellido_58', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(86, 'V', '2000059', 'República Dominicana', 'Apellido_59', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(87, 'V', '2000060', 'Puerto Rico', 'Apellido_60', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id_pago` int(11) NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id_pago`, `nombre`) VALUES
(5, 'Efectivo'),
(6, 'Pago Movil'),
(7, 'Transferencia'),
(8, 'Divisas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagodefactura`
--

CREATE TABLE `pagodefactura` (
  `id_pagoDeFactura` int(11) NOT NULL,
  `id_pago` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `referencia` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `monto` float(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pagodefactura`
--

INSERT INTO `pagodefactura` (`id_pagoDeFactura`, `id_pago`, `id_factura`, `referencia`, `monto`) VALUES
(72, 5, 57, '', 1000.00),
(73, 5, 58, '', 1000.00),
(74, 5, 61, '1234', 1000.00),
(75, 7, 61, '1234', 123.00),
(76, 5, 62, '1221', 100.00),
(77, 8, 62, '1221', 600.00),
(78, 6, 62, '1221', 300.00),
(79, 5, 63, '1233', 300.00),
(80, 8, 63, '1233', 300.00),
(81, 6, 63, '1233', 400.00),
(82, 5, 64, '1334', 100.00),
(83, 6, 64, '1334', 25.00),
(84, 5, 65, '1334', 100.00),
(85, 6, 65, '1334', 25.00),
(86, 5, 66, '1223', 25.00),
(87, 6, 66, '1223', 100.00),
(88, 5, 67, '', 415.00),
(89, 5, 68, '', 158.00),
(90, 5, 69, '', 330.00),
(91, 5, 70, '', 25.00),
(92, 5, 71, '', 430.00),
(93, 5, 72, '', 199.00),
(94, 5, 73, '', 58.00),
(95, 5, 74, '', 58.00),
(96, 5, 75, '', 58.00),
(97, 5, 76, '', 50.00),
(98, 5, 77, '', 75.00),
(99, 5, 78, '', 25.00),
(100, 5, 79, '', 123.96),
(101, 5, 80, '', 103.30),
(102, 5, 81, '', 123.96),
(103, 5, 82, '', 123.96),
(104, 5, 83, '', 10.33),
(105, 5, 84, '', 30.99),
(106, 7, 84, '', 0.00),
(107, 5, 85, '', 22.77),
(108, 5, 86, '', 16.55),
(109, 5, 87, '', 16.55),
(110, 5, 88, '', 125.30),
(111, 5, 89, '', 35.80),
(112, 5, 90, '', 17.90),
(113, 5, 91, '2312', 129.30),
(114, 8, 91, '2312', 1000.00),
(115, 6, 91, '2312', 1000.00),
(116, 5, 92, '', 1127.20),
(117, 8, 92, '', 0.00),
(118, 5, 93, '', 1123.00),
(119, 5, 94, '', 2.10),
(120, 6, 94, '', 0.00),
(121, 5, 95, '1234', 100.00),
(122, 6, 95, '1234', 82.12),
(123, 5, 96, '7897', 500.00),
(124, 6, 96, '7897', 500.00),
(125, 5, 97, '', 129.00),
(126, 5, 98, '2321', 1.00),
(127, 6, 98, '2321', 0.20),
(128, 5, 99, '', 29.56),
(129, 5, 100, '', 29.56),
(130, 5, 101, '', 0.60),
(131, 5, 102, '', 1230.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patologia`
--

CREATE TABLE `patologia` (
  `id_patologia` int(11) NOT NULL,
  `nombre_patologia` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `estado` varchar(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `patologia`
--

INSERT INTO `patologia` (`id_patologia`, `nombre_patologia`, `estado`) VALUES
(2, 'DIABETES TIPO 1', 'ACT'),
(3, 'DIABETES TIPO 2', 'ACT'),
(5, 'EPOC', 'ACT'),
(6, 'ARTRITIS REUMATOIDE', 'ACT'),
(7, 'ENFERMEDAD CELÍACA', 'ACT'),
(8, 'OBESIDAD', 'ACT'),
(9, 'DEPRESIÓN', 'ACT'),
(10, 'ANSIEDAD', 'ACT'),
(11, 'ENFERMEDAD DE CROHN', 'ACT'),
(12, 'COLITIS ULCEROSA', 'ACT'),
(13, 'ASMA', '1'),
(14, 'Patologia', 'ACT'),
(15, 'Algo', 'ACT'),
(16, 'HIPERTIROIDISMO', 'ACT'),
(17, 'OSTEOPOROSIS', 'ACT'),
(18, 'EPILEPSIA', 'ACT'),
(19, 'MIGRAÑA', 'ACT'),
(20, 'ALZHEIMER', 'ACT'),
(44, 'HEPATITIS B', 'ACT'),
(186, 'Hipertensión', 'ACT'),
(189, 'Bronquitis', 'ACT'),
(190, 'Neumonía', 'ACT'),
(191, 'Migraña', 'ACT'),
(192, 'Gastritis', 'ACT'),
(193, 'Hepatitis A', 'ACT'),
(194, 'Hepatitis B', 'ACT'),
(195, 'Anemia', 'ACT'),
(196, 'Artritis', 'ACT'),
(197, 'Obesidad', 'ACT'),
(198, 'Epilepsia', 'ACT'),
(199, 'Depresión', 'ACT'),
(200, 'Ansiedad', 'ACT'),
(201, 'Dermatitis', 'ACT'),
(202, 'Sinusitis', 'ACT'),
(203, 'COVID-19', 'ACT'),
(204, 'Tuberculosis', 'ACT'),
(205, 'Insuficiencia renal', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patologiadepaciente`
--

CREATE TABLE `patologiadepaciente` (
  `id_patologiaDePaciente` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `id_patologia` int(11) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `patologiadepaciente`
--

INSERT INTO `patologiadepaciente` (`id_patologiaDePaciente`, `id_paciente`, `id_patologia`, `fecha_registro`) VALUES
(16, 23, 13, '2025-04-02 20:13:12'),
(17, 23, 13, '2025-04-02 20:13:46'),
(18, 26, 15, '2025-05-15 17:26:49'),
(19, 26, 13, '2025-05-15 18:18:42'),
(20, 24, 13, '2025-05-15 18:18:51'),
(21, 25, 13, '2025-05-15 18:18:51'),
(102, 25, 5, '2025-04-01 10:15:00'),
(157, 28, 8, '2025-04-03 09:30:00'),
(176, 70, 20, '2025-04-20 16:30:00'),
(177, 67, 18, '2025-04-18 14:15:00'),
(178, 49, 17, '2025-04-17 13:05:00'),
(179, 55, 16, '2025-04-16 11:35:00'),
(180, 47, 13, '2025-04-15 10:10:00'),
(181, 48, 15, '2025-04-14 09:45:00'),
(183, 28, 11, '2025-04-12 08:50:00'),
(193, 23, 9, '2025-04-11 17:00:00'),
(194, 27, 2, '2025-04-10 12:00:00'),
(195, 27, 6, '2025-04-09 15:25:00'),
(196, 48, 10, '2025-04-08 10:40:00'),
(202, 29, 14, '2025-04-06 16:00:00'),
(207, 28, 8, '2025-04-03 09:30:00'),
(208, 26, 3, '2025-04-04 11:20:00'),
(209, 62, 6, '2025-05-15 19:42:53'),
(210, 59, 20, '2025-05-15 19:43:28'),
(211, 60, 11, '2025-05-15 19:43:28'),
(212, 87, 2, '2025-05-15 19:43:56'),
(213, 38, 191, '2025-05-15 19:43:56'),
(214, 87, 20, '2025-05-15 19:44:11'),
(215, 86, 7, '2025-05-15 19:44:11'),
(216, 29, 205, '2025-05-15 19:44:21'),
(217, 23, 18, '2025-05-15 19:44:21'),
(218, 51, 14, '2025-05-15 19:44:51'),
(219, 58, 14, '2025-05-15 19:44:51'),
(220, 46, 14, '2025-05-15 19:45:12'),
(221, 35, 9, '2025-05-15 19:45:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `idpermisos` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `permisos` varchar(200) NOT NULL,
  `modulo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`idpermisos`, `id_rol`, `permisos`, `modulo`) VALUES
(1, 1, 'consultar,guardar,editar,eliminar', 'Pacientes'),
(2, 5, 'consultar', 'Pacientes'),
(3, 6, 'consultar,guardar', 'Pacientes'),
(4, 7, 'consultar,guardar', 'Pacientes'),
(5, 7, 'consultar,guardar,editar,eliminar', 'Patologias'),
(6, 8, 'consultar,guardar,editar,eliminar', 'Pacientes'),
(7, 8, 'consultar,guardar,eliminar', 'Patologias'),
(8, 9, 'consultar,guardar,editar,eliminar', 'Pacientes'),
(9, 9, 'consultar,guardar,eliminar', 'Patologias'),
(10, 1, 'consultar,guardar,editar,eliminar', 'Roles'),
(11, 1, 'consultar,guardar,editar,eliminar', 'Usuarios'),
(12, 10, 'consultar,guardar,editar,eliminar', 'Pacientes'),
(13, 10, 'consultar,guardar,editar,eliminar', 'Patologias'),
(14, 10, 'consultar,guardar,editar,eliminar', 'Factura'),
(15, 10, 'consultar,guardar,editar,eliminar', 'Citas'),
(16, 10, 'consultar,guardar,editar,eliminar', 'Consultas'),
(17, 10, 'consultar,guardar,editar,eliminar', 'Doctores'),
(18, 10, 'consultar,guardar,editar,eliminar', 'Control'),
(19, 10, 'consultar,guardar,editar,eliminar', 'Hospitalizacion'),
(20, 10, 'consultar,guardar,editar,eliminar', 'Insumos'),
(21, 10, 'consultar,guardar,editar,eliminar', 'Entrada'),
(22, 10, 'consultar,guardar,editar,eliminar', 'Proveedores'),
(23, 10, 'consultar,guardar,editar,eliminar', 'Usuarios'),
(24, 10, 'consultar,guardar,editar,eliminar', 'Roles'),
(25, 10, 'consultar,guardar,editar,eliminar', 'Reportes'),
(26, 10, 'consultar,guardar,editar,eliminar', 'Estadisticas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `id_personal` int(11) NOT NULL,
  `nacionalidad` varchar(5) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `apellido` varchar(25) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `tipodecategoria` varchar(25) NOT NULL,
  `id_especialidad` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`id_personal`, `nacionalidad`, `cedula`, `nombre`, `apellido`, `telefono`, `tipodecategoria`, `id_especialidad`, `id_usuario`) VALUES
(18, 'V', '30554145', 'Dixon', 'Bastias', '04145378241', 'Administrador', NULL, 1),
(19, 'V', '1232233', 'David', 'Carlos', '04142323233', '', 7, 42),
(20, 'V', '12123343', 'Carlos', 'Garcia', '04244546565', '', 7, 43);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_has_serviciomedico`
--

CREATE TABLE `personal_has_serviciomedico` (
  `personal_id_personal` int(11) NOT NULL,
  `serviciomedico_id_servicioMedico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `personal_has_serviciomedico`
--

INSERT INTO `personal_has_serviciomedico` (`personal_id_personal`, `serviciomedico_id_servicioMedico`) VALUES
(18, 25),
(19, 26),
(19, 29),
(19, 30),
(19, 32),
(19, 33),
(20, 27),
(20, 28),
(20, 31);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `rif` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `telefono` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(40) NOT NULL,
  `direccion` text NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre`, `rif`, `telefono`, `email`, `direccion`, `estado`) VALUES
(6, 'Juan Jose', '281500045', '04121338031', 'depanajuaner@gmail.com', 'en su casa', 'ACT'),
(7, 'Ricardo Perez', '296236571', '04124466999', 'sisisi@gmail.com', 'hfygh', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `estado` varchar(45) NOT NULL,
  `descripción` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`, `estado`, `descripción`) VALUES
(1, 'administrador', 'ACT', 'administrador'),
(5, 'Rol', 'DES', 'este es un permiso par los doctores'),
(6, 'Propio', 'DES', 'descripcio'),
(7, 'Carlos', 'DES', 'jfhfdsjddjs'),
(8, 'Doctor', 'ACT', 'en un rol para los doctores'),
(9, 'Roletazo', 'DES', 'es un permiso de pruebas'),
(10, 'Superadmin', 'ACT', 'lsafdfjfd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serviciomedico`
--

CREATE TABLE `serviciomedico` (
  `id_servicioMedico` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `precio` float(12,2) NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `serviciomedico`
--

INSERT INTO `serviciomedico` (`id_servicioMedico`, `id_categoria`, `precio`, `estado`) VALUES
(22, 9, 2200.00, 'ACT'),
(23, 100, 1500.00, 'ACT'),
(24, 1, 3000.00, 'ACT'),
(25, 101, 1000.00, 'ACT'),
(26, 2, 123.00, 'DES'),
(27, 2, 123.00, 'DES'),
(28, 1, 31395.00, 'DES'),
(29, 1, 16905.00, 'DES'),
(30, 1, 169.05, 'DES'),
(31, 101, 12.00, 'DES'),
(32, 1, 479.78, 'DES'),
(33, 100, 1.07, 'DES'),
(34, 104, 24.95, 'ACT'),
(35, 103, 60.66, 'ACT'),
(36, 102, 46.81, 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serviciomedico_has_factura`
--

CREATE TABLE `serviciomedico_has_factura` (
  `serviciomedico_id_servicioMedico` int(11) NOT NULL,
  `factura_id_factura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `serviciomedico_has_factura`
--

INSERT INTO `serviciomedico_has_factura` (`serviciomedico_id_servicioMedico`, `factura_id_factura`) VALUES
(25, 58),
(26, 61),
(25, 61),
(25, 62),
(25, 63),
(25, 91),
(26, 91),
(25, 91),
(25, 92),
(26, 92),
(25, 93),
(26, 93),
(27, 95),
(25, 96),
(26, 97);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sintomas`
--

CREATE TABLE `sintomas` (
  `id_sintomas` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `estado` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sintomas`
--

INSERT INTO `sintomas` (`id_sintomas`, `nombre`, `estado`) VALUES
(5, 'Disnea', 'ACT'),
(6, 'Fiebre', 'ACT'),
(7, 'Vomito', 'ACT'),
(8, 'Dolor de cabeza', 'ACT'),
(9, 'Malestar general', 'ACT'),
(10, 'Inchazon', 'ACT'),
(11, 'Enrojecimiento', 'ACT'),
(12, 'Piel Amarilla', 'ACT'),
(13, 'Dolor de higado', 'ACT'),
(14, 'Encias sangrantes', 'ACT'),
(15, 'sintoma', 'DES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sintomas_control`
--

CREATE TABLE `sintomas_control` (
  `id_sintomas_control` int(11) NOT NULL,
  `id_sintomas` int(11) NOT NULL,
  `id_control` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sintomas_control`
--

INSERT INTO `sintomas_control` (`id_sintomas_control`, `id_sintomas`, `id_control`) VALUES
(37, 5, 26),
(38, 10, 26),
(39, 8, 26),
(40, 8, 27),
(41, 9, 27),
(42, 7, 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `usuario` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `id_rol`, `imagen`, `usuario`, `correo`, `password`, `estado`) VALUES
(1, 10, '', 'WDaniel123', 'wbaez975@gmail.com', '$2y$10$1bMoW4177.FH45HrSHx/KOVV.LBAbDXnaGn1nMx3OtJ3MAah2NYnq', 'ACT'),
(42, 8, 'img30.png', 'Usuario123', 'WDaniel123@gmail.com', '$2y$10$1bMoW4177.FH45HrSHx/KOVV.LBAbDXnaGn1nMx3OtJ3MAah2NYnq', 'ACT'),
(43, 8, 'img23.jpg', 'Usuario', 'WDaniel143@gmail.com', '$2y$10$80gqRMUNCdZY2z7rKB7CxeCTQtH2zSJ/WdNBtaQ1/pHVyLWqNZvOW', 'ACT');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id_bitacora`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `categoria_servicio`
--
ALTER TABLE `categoria_servicio`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id_cita`,`paciente_id_paciente`),
  ADD KEY `fk_cita_serviciomedico1_idx` (`serviciomedico_id_servicioMedico`),
  ADD KEY `fk_cita_paciente1_idx` (`paciente_id_paciente`);

--
-- Indices de la tabla `control`
--
ALTER TABLE `control`
  ADD PRIMARY KEY (`id_control`),
  ADD KEY `id_paciente` (`id_paciente`,`id_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `entrada`
--
ALTER TABLE `entrada`
  ADD PRIMARY KEY (`id_entrada`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `entrada_insumo`
--
ALTER TABLE `entrada_insumo`
  ADD PRIMARY KEY (`id_entradaDeInsumo`),
  ADD KEY `id_insumo` (`id_insumo`),
  ADD KEY `id_entrada` (`id_entrada`);

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`id_especialidad`) USING BTREE;

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`,`paciente_id_paciente`),
  ADD KEY `fk_factura_paciente1_idx` (`paciente_id_paciente`);

--
-- Indices de la tabla `factura_has_inventario`
--
ALTER TABLE `factura_has_inventario`
  ADD KEY `fk_factura_has_inventario_inventario1_idx` (`inventario_id_inventario`),
  ADD KEY `fk_factura_has_inventario_factura1_idx` (`factura_id_factura`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id_horario`);

--
-- Indices de la tabla `horarioydoctor`
--
ALTER TABLE `horarioydoctor`
  ADD PRIMARY KEY (`id_horarioydoctor`),
  ADD KEY `id_doctor` (`id_personal`),
  ADD KEY `id_horario` (`id_horario`);

--
-- Indices de la tabla `hospitalizacion`
--
ALTER TABLE `hospitalizacion`
  ADD PRIMARY KEY (`id_hospitalizacion`),
  ADD KEY `id_control` (`id_control`);

--
-- Indices de la tabla `insumo`
--
ALTER TABLE `insumo`
  ADD PRIMARY KEY (`id_insumo`);

--
-- Indices de la tabla `insumodehospitalizacion`
--
ALTER TABLE `insumodehospitalizacion`
  ADD PRIMARY KEY (`id_insumoDeHospitalizacion`),
  ADD KEY `id_hospitalizacion` (`id_hospitalizacion`),
  ADD KEY `id_insumo` (`id_inventario`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_inventario`),
  ADD KEY `id_insumo` (`id_insumo`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id_paciente`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id_pago`);

--
-- Indices de la tabla `pagodefactura`
--
ALTER TABLE `pagodefactura`
  ADD PRIMARY KEY (`id_pagoDeFactura`),
  ADD KEY `id_pago` (`id_pago`),
  ADD KEY `id_factura` (`id_factura`);

--
-- Indices de la tabla `patologia`
--
ALTER TABLE `patologia`
  ADD PRIMARY KEY (`id_patologia`);

--
-- Indices de la tabla `patologiadepaciente`
--
ALTER TABLE `patologiadepaciente`
  ADD PRIMARY KEY (`id_patologiaDePaciente`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_patologia` (`id_patologia`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`idpermisos`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id_personal`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD KEY `id_especialidad` (`id_especialidad`,`id_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `personal_has_serviciomedico`
--
ALTER TABLE `personal_has_serviciomedico`
  ADD PRIMARY KEY (`personal_id_personal`,`serviciomedico_id_servicioMedico`),
  ADD KEY `fk_personal_has_serviciomedico_serviciomedico1_idx` (`serviciomedico_id_servicioMedico`),
  ADD KEY `fk_personal_has_serviciomedico_personal1_idx` (`personal_id_personal`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `serviciomedico`
--
ALTER TABLE `serviciomedico`
  ADD PRIMARY KEY (`id_servicioMedico`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `serviciomedico_has_factura`
--
ALTER TABLE `serviciomedico_has_factura`
  ADD KEY `id_servicio` (`serviciomedico_id_servicioMedico`),
  ADD KEY `id_factura` (`factura_id_factura`);

--
-- Indices de la tabla `sintomas`
--
ALTER TABLE `sintomas`
  ADD PRIMARY KEY (`id_sintomas`);

--
-- Indices de la tabla `sintomas_control`
--
ALTER TABLE `sintomas_control`
  ADD PRIMARY KEY (`id_sintomas_control`),
  ADD KEY `id_sintomas` (`id_sintomas`),
  ADD KEY `id_control` (`id_control`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT de la tabla `categoria_servicio`
--
ALTER TABLE `categoria_servicio`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `control`
--
ALTER TABLE `control`
  MODIFY `id_control` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `entrada`
--
ALTER TABLE `entrada`
  MODIFY `id_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `entrada_insumo`
--
ALTER TABLE `entrada_insumo`
  MODIFY `id_entradaDeInsumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `id_especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `horarioydoctor`
--
ALTER TABLE `horarioydoctor`
  MODIFY `id_horarioydoctor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `hospitalizacion`
--
ALTER TABLE `hospitalizacion`
  MODIFY `id_hospitalizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `insumo`
--
ALTER TABLE `insumo`
  MODIFY `id_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `insumodehospitalizacion`
--
ALTER TABLE `insumodehospitalizacion`
  MODIFY `id_insumoDeHospitalizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_inventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pagodefactura`
--
ALTER TABLE `pagodefactura`
  MODIFY `id_pagoDeFactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT de la tabla `patologia`
--
ALTER TABLE `patologia`
  MODIFY `id_patologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT de la tabla `patologiadepaciente`
--
ALTER TABLE `patologiadepaciente`
  MODIFY `id_patologiaDePaciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idpermisos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id_personal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `serviciomedico`
--
ALTER TABLE `serviciomedico`
  MODIFY `id_servicioMedico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `sintomas`
--
ALTER TABLE `sintomas`
  MODIFY `id_sintomas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `sintomas_control`
--
ALTER TABLE `sintomas_control`
  MODIFY `id_sintomas_control` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `bitacora_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `fk_cita_paciente1` FOREIGN KEY (`paciente_id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_serviciomedico1` FOREIGN KEY (`serviciomedico_id_servicioMedico`) REFERENCES `serviciomedico` (`id_servicioMedico`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `control`
--
ALTER TABLE `control`
  ADD CONSTRAINT `control_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`),
  ADD CONSTRAINT `control_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `entrada`
--
ALTER TABLE `entrada`
  ADD CONSTRAINT `entrada_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`);

--
-- Filtros para la tabla `entrada_insumo`
--
ALTER TABLE `entrada_insumo`
  ADD CONSTRAINT `entrada_insumo_ibfk_1` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`id_insumo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entrada_insumo_ibfk_2` FOREIGN KEY (`id_entrada`) REFERENCES `entrada` (`id_entrada`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_factura_paciente1` FOREIGN KEY (`paciente_id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_has_inventario`
--
ALTER TABLE `factura_has_inventario`
  ADD CONSTRAINT `factura_has_inventario_ibfk_1` FOREIGN KEY (`inventario_id_inventario`) REFERENCES `inventario` (`id_inventario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_has_inventario_ibfk_2` FOREIGN KEY (`factura_id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `horarioydoctor`
--
ALTER TABLE `horarioydoctor`
  ADD CONSTRAINT `horarioydoctor_ibfk_1` FOREIGN KEY (`id_personal`) REFERENCES `personal` (`id_personal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `horarioydoctor_ibfk_2` FOREIGN KEY (`id_horario`) REFERENCES `horario` (`id_horario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `hospitalizacion`
--
ALTER TABLE `hospitalizacion`
  ADD CONSTRAINT `hospitalizacion_ibfk_1` FOREIGN KEY (`id_control`) REFERENCES `control` (`id_control`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `insumodehospitalizacion`
--
ALTER TABLE `insumodehospitalizacion`
  ADD CONSTRAINT `insumodehospitalizacion_ibfk_1` FOREIGN KEY (`id_hospitalizacion`) REFERENCES `hospitalizacion` (`id_hospitalizacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `insumodehospitalizacion_ibfk_2` FOREIGN KEY (`id_inventario`) REFERENCES `inventario` (`id_inventario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`id_insumo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagodefactura`
--
ALTER TABLE `pagodefactura`
  ADD CONSTRAINT `pagodefactura_ibfk_1` FOREIGN KEY (`id_pago`) REFERENCES `pago` (`id_pago`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pagodefactura_ibfk_2` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `patologiadepaciente`
--
ALTER TABLE `patologiadepaciente`
  ADD CONSTRAINT `id_paciente ` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_patologia` FOREIGN KEY (`id_patologia`) REFERENCES `patologia` (`id_patologia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `personal_ibfk_1` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidad` (`id_especialidad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `personal_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `personal_has_serviciomedico`
--
ALTER TABLE `personal_has_serviciomedico`
  ADD CONSTRAINT `personal_has_serviciomedico_ibfk_1` FOREIGN KEY (`personal_id_personal`) REFERENCES `personal` (`id_personal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `personal_has_serviciomedico_ibfk_2` FOREIGN KEY (`serviciomedico_id_servicioMedico`) REFERENCES `serviciomedico` (`id_servicioMedico`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `serviciomedico`
--
ALTER TABLE `serviciomedico`
  ADD CONSTRAINT `serviciomedico_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_servicio` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `serviciomedico_has_factura`
--
ALTER TABLE `serviciomedico_has_factura`
  ADD CONSTRAINT `serviciomedico_has_factura_ibfk_1` FOREIGN KEY (`serviciomedico_id_servicioMedico`) REFERENCES `serviciomedico` (`id_servicioMedico`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `serviciomedico_has_factura_ibfk_2` FOREIGN KEY (`factura_id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sintomas_control`
--
ALTER TABLE `sintomas_control`
  ADD CONSTRAINT `sintomas_control_ibfk_1` FOREIGN KEY (`id_sintomas`) REFERENCES `sintomas` (`id_sintomas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sintomas_control_ibfk_2` FOREIGN KEY (`id_control`) REFERENCES `control` (`id_control`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
