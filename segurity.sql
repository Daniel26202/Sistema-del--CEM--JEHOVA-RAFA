-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 21-04-2026 a las 18:46:14
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
-- Base de datos: `segurity`
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
(0, 1, 'inicio sesion', 'Ha iniciado una session', '2025-06-08 11:42:55'),
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
(251, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-15 11:59:34'),
(252, 1, 'insumo', 'Ha Insertado un insumo', '2025-05-22 12:49:23'),
(253, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-05-22 12:49:56'),
(254, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-05-22 14:02:01'),
(255, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-22 20:23:40'),
(256, 1, 'cerrar session', 'Ha cerrado la session ', '2025-05-23 08:10:11'),
(257, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-23 08:10:27'),
(258, 1, 'cerrar session', 'Ha cerrado la session ', '2025-05-23 08:10:44'),
(259, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-23 08:16:29'),
(260, 1, 'cerrar session', 'Ha cerrado la session ', '2025-05-23 08:17:03'),
(261, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-23 08:17:14'),
(262, 1, 'cerrar session', 'Ha cerrado la session ', '2025-05-23 08:17:32'),
(263, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-23 08:17:42'),
(264, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-05-23 08:19:25'),
(265, 1, 'Consultas', 'Ha añadido un servicio medico a un doctor', '2025-05-23 09:05:29'),
(266, 1, 'cerrar session', 'Ha cerrado la session ', '2025-05-24 09:39:07'),
(267, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-24 11:09:46'),
(268, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-25 21:03:46'),
(269, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-26 19:08:40'),
(270, 1, 'inicio sesion', 'Ha iniciado una session', '2025-05-27 15:18:09'),
(271, 1, 'cita', 'Ha Insertado una  cita', '2025-05-27 14:10:10'),
(272, 1, 'cita', 'Ha Insertado una  cita', '2025-05-27 15:11:35'),
(273, 1, 'cita', 'Ha Insertado una  cita', '2025-05-27 15:21:09'),
(274, 1, 'cita', 'Ha Insertado una  cita', '2025-05-27 15:23:28'),
(275, 1, 'cita', 'Ha Insertado una  cita', '2025-05-27 15:30:42'),
(276, 1, 'cita', 'Ha Insertado una  cita', '2025-05-27 15:40:57'),
(277, 1, 'cerrar session', 'Ha cerrado la session ', '2025-06-08 11:58:27'),
(278, 1, 'inicio sesion', 'Ha iniciado una session', '2025-06-08 16:34:47'),
(279, 1, 'Perfil', 'Ha modificado un perfil', '2025-06-08 17:09:30'),
(280, 1, 'inicio sesion', 'Ha iniciado una session', '2025-06-08 17:09:34'),
(281, 1, 'inicio sesion', 'Ha iniciado una session', '2025-06-09 09:22:48'),
(282, 1, 'inicio sesion', 'Ha iniciado una session', '2025-06-27 11:22:30'),
(283, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-06-27 15:46:30'),
(284, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-06-27 15:47:27'),
(285, 1, 'inicio sesion', 'Ha iniciado una session', '2025-06-27 18:57:44'),
(286, 1, 'patologia', 'Ha eliminado una patologia', '2025-06-27 18:59:30'),
(287, 1, 'patologia', 'Ha restablecido una patologia', '2025-06-27 19:00:00'),
(288, 1, 'patologia', 'Ha eliminado una patologia', '2025-06-27 19:00:14'),
(289, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-06-27 19:05:19'),
(290, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-06-27 19:07:27'),
(291, 1, 'cerrar session', 'Ha cerrado la session ', '2025-06-27 23:39:02'),
(292, 1, 'inicio sesion', 'Ha iniciado una session', '2025-06-27 23:39:18'),
(293, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-06-27 23:41:09'),
(294, 1, 'paciente', 'Ha modificado un paciente', '2025-06-27 23:41:59'),
(295, 1, 'paciente', 'Ha modificado un paciente', '2025-06-27 23:42:23'),
(296, 1, 'mantenimiento', 'Se ha restablecido la base de datos(bd-2025-06-27.zip) desde el respaldo', '2025-06-29 19:20:14'),
(297, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-06-29 19:30:56'),
(298, 1, 'inicio sesion', 'Ha iniciado una session', '2025-06-30 15:14:18'),
(299, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-06-30 15:14:50'),
(300, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-06-30 16:33:23'),
(301, 1, 'inicio sesion', 'Ha iniciado una session', '2025-07-02 16:01:51'),
(302, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-07-02 16:02:40'),
(303, 1, 'inicio sesion', 'Ha iniciado una session', '2025-07-03 14:43:51'),
(304, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-07-03 14:44:35'),
(305, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-07-03 14:49:19'),
(306, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-07-03 14:49:52'),
(307, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-07-03 16:52:12'),
(308, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-07-03 16:52:52'),
(309, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-07-03 16:53:01'),
(310, 1, 'inicio sesion', 'Ha iniciado una session', '2025-07-04 10:57:51'),
(311, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-07-04 10:58:22'),
(312, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-07-04 11:10:57'),
(313, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-07-04 11:20:33'),
(314, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-07-04 11:52:58'),
(315, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-07-04 11:53:29'),
(316, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-07-04 11:54:55'),
(317, 1, 'cerrar session', 'Ha cerrado la session ', '2025-07-04 12:32:22'),
(318, 1, 'inicio sesion', 'Ha iniciado una session', '2025-07-04 12:32:34'),
(319, 1, 'cerrar session', 'Ha cerrado la session ', '2025-07-04 12:33:10'),
(320, 1, 'inicio sesion', 'Ha iniciado una session', '2025-07-04 12:33:28'),
(321, 1, 'mantenimiento', 'Se ha restablecido la base de datos(bd-2025-07-04) desde el respaldo', '2025-09-04 16:04:16'),
(322, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-09-04 16:04:50'),
(323, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-04 16:04:59'),
(324, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-04 16:04:59'),
(325, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-04 16:28:41'),
(326, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-04 16:28:50'),
(327, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-04 16:29:08'),
(328, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-04 16:29:13'),
(329, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-04 16:29:20'),
(330, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-04 16:29:31'),
(331, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-06 12:25:10'),
(332, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-06 12:27:46'),
(333, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-06 12:27:56'),
(334, 1, 'hospitalizacion', 'Ha eliminado una hospitalizacion', '2025-09-06 12:28:00'),
(335, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-09-06 13:26:40'),
(336, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-06 13:27:30'),
(337, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-06 13:27:51'),
(338, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-08 11:19:34'),
(339, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-08 11:19:52'),
(340, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-08 11:19:58'),
(341, 1, 'hospitalizacion', 'Ha eliminado una hospitalizacion', '2025-09-08 12:34:46'),
(342, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-08 13:14:48'),
(343, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-08 13:14:59'),
(344, 1, 'hospitalizacion', 'Ha eliminado una hospitalizacion', '2025-09-08 13:15:43'),
(345, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-12 11:22:52'),
(346, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-09-12 11:23:16'),
(347, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-12 11:23:44'),
(348, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-12 11:23:52'),
(349, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-12 11:24:03'),
(350, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-12 11:25:16'),
(351, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-12 11:25:23'),
(352, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-12 15:44:20'),
(353, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-14 14:34:54'),
(354, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-14 14:35:56'),
(355, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-14 14:36:50'),
(356, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-09-14 14:37:03'),
(357, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-09-14 14:38:02'),
(358, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-14 14:38:36'),
(359, 1, 'hospitalizacion', 'Ha eliminado una hospitalizacion', '2025-09-14 14:38:39'),
(360, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-15 12:48:00'),
(361, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-09-15 12:48:52'),
(362, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-17 14:07:44'),
(363, 1, 'paciente', 'Ha Insertado un nuevo paciente', '2025-09-17 14:13:22'),
(364, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-09-17 14:17:19'),
(365, 1, 'cita', 'Ha Insertado una  cita', '2025-09-17 12:23:20'),
(366, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-19 17:10:57'),
(367, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-09-19 17:12:31'),
(368, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-09-19 17:13:32'),
(369, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-19 17:21:51'),
(370, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-19 17:21:55'),
(371, 1, 'cerrar session', 'Ha cerrado la session ', '2025-09-19 17:45:40'),
(372, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-19 17:45:48'),
(373, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-19 17:50:49'),
(374, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-19 17:50:54'),
(375, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-19 17:57:33'),
(376, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-19 17:58:00'),
(377, 1, 'hospitalizacion', 'Ha eliminado una hospitalizacion', '2025-09-19 18:04:07'),
(378, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-09-19 18:06:04'),
(379, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-19 18:07:14'),
(380, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-19 18:07:21'),
(381, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-19 18:07:38'),
(382, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-19 18:08:02'),
(383, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-19 18:08:18'),
(384, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-19 18:09:08'),
(385, 1, 'hospitalizacion', 'Ha modificado una hospitalizacion', '2025-09-19 18:09:34'),
(386, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-26 11:28:00'),
(387, 1, 'hospitalizacion', 'Ha eliminado una hospitalizacion', '2025-09-26 11:35:05'),
(388, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-09-26 11:36:00'),
(389, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-09-26 11:37:36'),
(390, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-09-26 11:41:58'),
(391, 1, 'control', 'Ha Insertado un nuevo  control medico', '2025-09-26 11:46:27'),
(392, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-29 16:47:07'),
(393, 1, 'Perfil', 'Ha modificado un perfil', '2025-09-29 16:47:22'),
(394, 1, 'Perfil', 'Ha modificado un perfil', '2025-09-29 16:47:38'),
(395, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-29 17:22:46'),
(396, 1, 'paciente', 'Ha modificado un paciente', '2025-09-29 17:25:18'),
(397, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-29 22:53:59'),
(398, 1, 'paciente', 'Ha modificado un paciente', '2025-09-29 23:22:11'),
(399, 1, 'paciente', 'Ha Insertado un nuevo paciente', '2025-09-29 23:24:47'),
(400, 1, 'sintomas', 'Ha eliminado un  sintoma', '2025-09-29 23:33:18'),
(401, 1, 'sintomas', 'Ha eliminado un  sintoma', '2025-09-29 23:33:29'),
(402, 1, 'sintomas', 'Ha Insertado un  sintoma', '2025-09-29 23:34:50'),
(403, 1, 'sintomas', 'Ha eliminado un  sintoma', '2025-09-29 23:34:56'),
(404, 1, 'sintomas', 'Ha Insertado un  sintoma', '2025-09-29 23:35:21'),
(405, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-30 11:48:08'),
(406, 1, 'paciente', 'Ha modificado un paciente', '2025-09-30 11:50:16'),
(407, 1, 'sintomas', 'Ha eliminado un  sintoma', '2025-09-30 12:41:40'),
(408, 1, 'sintomas', 'Ha Insertado un  sintoma', '2025-09-30 12:42:13'),
(409, 1, 'sintomas', 'Ha eliminado un  sintoma', '2025-09-30 12:42:17'),
(410, 1, 'paciente', 'Ha modificado un paciente', '2025-09-30 12:44:10'),
(411, 1, 'paciente', 'Ha Insertado un nuevo paciente', '2025-09-30 12:45:23'),
(412, 1, 'paciente', 'Ha restablecido un paciente', '2025-09-30 12:46:00'),
(413, 1, 'paciente', 'Ha eliminado un  paciente', '2025-09-30 12:46:20'),
(414, 1, 'patologia', 'Ha eliminado una patologia', '2025-09-30 12:51:30'),
(415, 1, 'patologia', 'Ha eliminado una patologia', '2025-09-30 12:52:14'),
(416, 1, 'patologia', 'Ha eliminado una patologia', '2025-09-30 12:52:53'),
(417, 1, 'patologia', 'Ha Insertado una patologia', '2025-09-30 12:53:09'),
(418, 1, 'entrada', 'Ha eliminado una entrada', '2025-09-30 12:59:47'),
(419, 1, 'entrada', 'Ha eliminado una entrada', '2025-09-30 13:10:08'),
(420, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:10:45'),
(421, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:11:00'),
(422, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:11:11'),
(423, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:11:25'),
(424, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:11:43'),
(425, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:13:24'),
(426, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:13:40'),
(427, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:18:42'),
(428, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:18:53'),
(429, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:19:13'),
(430, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:19:36'),
(431, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:19:50'),
(432, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:20:06'),
(433, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:20:18'),
(434, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:20:26'),
(435, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:20:44'),
(436, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:21:43'),
(437, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:22:40'),
(438, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:22:57'),
(439, 1, 'entrada', 'Ha eliminado una entrada', '2025-09-30 13:23:13'),
(440, 1, 'entrada', 'Ha eliminado una entrada', '2025-09-30 13:28:15'),
(441, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:34:23'),
(442, 1, 'entrada', 'Ha insertado una entrada', '2025-09-30 13:34:36'),
(443, 1, 'entrada', 'Ha eliminado una entrada', '2025-09-30 13:34:50'),
(444, 1, 'entrada', 'Ha restablecido una entrada', '2025-09-30 14:11:44'),
(445, 1, 'entrada', 'Ha eliminado una entrada', '2025-09-30 14:11:57'),
(446, 1, 'doctor', 'Ha eliminado un doctor', '2025-09-30 14:17:32'),
(447, 1, 'doctor', 'Ha Insertado un doctor', '2025-09-30 14:35:57'),
(448, 1, 'doctor', 'Ha Insertado un doctor', '2025-09-30 14:37:45'),
(449, 1, 'doctor', 'Ha eliminado un doctor', '2025-09-30 14:45:36'),
(450, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-30 18:32:23'),
(451, 1, 'cerrar session', 'Ha cerrado la session ', '2025-09-30 19:22:38'),
(452, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-30 19:55:03'),
(453, 1, 'cerrar session', 'Ha cerrado la session ', '2025-09-30 20:53:24'),
(454, 1, 'inicio sesion', 'Ha iniciado una session', '2025-09-30 21:06:56'),
(455, 1, 'patologia', 'Ha Insertado una patologia', '2025-10-01 00:31:24'),
(456, 1, 'patologia', 'Ha eliminado una patologia', '2025-10-01 00:51:22'),
(457, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-01 08:44:30'),
(458, 1, 'patologia', 'Ha eliminado una patologia', '2025-10-01 08:47:47'),
(459, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-10-01 08:51:26'),
(460, 1, 'doctor', 'Ha modificado un doctor', '2025-10-01 09:13:12'),
(461, 1, 'Consultas', 'Ha añadido un servicio medico a un doctor', '2025-10-01 09:18:41'),
(462, 1, 'cita', 'Ha Insertado una  cita', '2025-10-01 07:42:02'),
(463, 1, 'cita', 'Ha Insertado una  cita', '2025-09-24 07:51:33'),
(464, 1, 'cita', 'Ha Insertado una  cita', '2025-09-24 07:54:41'),
(465, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-01 15:02:54'),
(466, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-02 10:40:51'),
(467, 1, 'servicioMedico', 'Ha modificadp un servicio medico', '2025-10-02 10:55:28'),
(468, 1, 'servicioMedico', 'Ha restablecido un servicio medico', '2025-10-02 10:55:52'),
(469, 1, 'servicioMedico', 'Ha eliminado un   servicio medico', '2025-10-02 10:55:59'),
(470, 1, 'doctor', 'Ha modificado un doctor', '2025-10-02 11:16:07'),
(471, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-02 14:50:10'),
(472, 1, 'insumo', 'Ha Insertado un insumo', '2025-10-02 14:57:12'),
(473, 1, 'insumo', 'Ha modificado un insumo', '2025-10-02 14:59:49'),
(474, 1, 'insumo', 'Ha modificado un insumo', '2025-10-02 15:00:53'),
(475, 1, 'entrada', 'Ha insertado una entrada', '2025-10-02 16:14:17'),
(476, 1, 'proveedor', 'Ha modificado un proveedor', '2025-10-02 23:03:38'),
(477, 1, 'proveedor', 'Ha modificado un proveedor', '2025-10-02 23:03:45'),
(478, 1, 'proveedor', 'Ha modificado un proveedor', '2025-10-02 23:03:55'),
(479, 1, 'proveedor', 'Ha insertado un proveedor', '2025-10-02 23:09:42'),
(480, 1, 'proveedor', 'Ha modificado un proveedor', '2025-10-02 23:10:47'),
(481, 1, 'proveedor', 'Ha modificado un proveedor', '2025-10-02 23:10:54'),
(482, 1, 'proveedor', 'Ha modificado un proveedor', '2025-10-02 23:12:45'),
(483, 1, 'proveedor', 'Ha modificado un proveedor', '2025-10-02 23:14:00'),
(484, 1, 'proveedor', 'Ha eliminado un proveedor', '2025-10-02 23:14:08'),
(485, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-05 22:17:07'),
(486, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-05 23:08:20'),
(487, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-06 00:08:29'),
(488, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-06 17:29:24'),
(489, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-06 17:31:52'),
(490, 1, 'servicioMedico', 'Ha eliminado un   servicio medico', '2025-10-07 19:30:08'),
(491, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-08 08:25:31'),
(492, 1, 'paciente', 'Ha Insertado un nuevo paciente', '2025-10-08 08:53:46'),
(493, 1, 'paciente', 'Ha modificado un paciente', '2025-10-08 08:54:04'),
(494, 1, 'paciente', 'Ha modificado un paciente', '2025-10-08 08:54:28'),
(495, 1, 'paciente', 'Ha eliminado un  paciente', '2025-10-08 08:55:28'),
(496, 1, 'Consultas', 'Ha añadido un servicio medico a un doctor', '2025-10-08 09:01:35'),
(497, 1, 'categoria_servicio', 'Ha Insertado una nueva  categoria', '2025-10-08 09:03:33'),
(498, 1, 'categoria_servicio', 'Ha eliminado una  categoria', '2025-10-08 09:06:23'),
(499, 1, 'categoria_servicio', 'Ha Insertado una nueva  categoria', '2025-10-08 09:07:11'),
(500, 1, 'servicioMedico', 'Ha Insertado un nuevo  servicio medico', '2025-10-08 09:09:56'),
(501, 1, 'Consultas', 'Ha añadido un servicio medico a un doctor', '2025-10-08 09:11:11'),
(502, 1, 'Consultas', 'Ha añadido un servicio medico a un doctor', '2025-10-08 09:12:34'),
(503, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-10-08 09:24:55'),
(504, 1, 'paciente', 'Ha Insertado un nuevo paciente', '2025-10-08 09:27:35'),
(505, 1, 'cita', 'Ha Insertado una  cita', '2025-10-08 07:29:46'),
(506, 1, 'cita', 'Ha Insertado una  cita', '2025-10-08 07:43:54'),
(507, 1, 'control', 'Ha Insertado un nuevo  control medico', '2025-10-08 09:50:47'),
(508, 1, 'control', 'Ha Insertado un nuevo  control medico', '2025-10-08 09:55:55'),
(509, 1, 'doctor', 'Ha Insertado un doctor', '2025-10-08 09:59:56'),
(510, 1, 'Consultas', 'Ha añadido un servicio medico a un doctor', '2025-10-08 10:00:29'),
(511, 1, 'control', 'Ha Insertado un nuevo  control medico', '2025-10-08 10:01:40'),
(512, 1, 'cerrar session', 'Ha cerrado la session ', '2025-10-08 10:02:22'),
(513, 52, 'inicio sesion', 'Ha iniciado una session', '2025-10-08 10:02:46'),
(514, 52, 'cerrar session', 'Ha cerrado la session ', '2025-10-08 10:03:21'),
(515, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-08 10:03:40'),
(516, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-08 10:05:15'),
(517, 1, 'cerrar session', 'Ha cerrado la session ', '2025-10-08 10:05:19'),
(518, 52, 'inicio sesion', 'Ha iniciado una session', '2025-10-08 10:05:28'),
(519, 52, 'cerrar session', 'Ha cerrado la session ', '2025-10-08 10:05:48'),
(520, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-08 10:05:59'),
(521, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-08 10:06:20'),
(522, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-13 11:11:31'),
(523, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-14 12:41:30'),
(524, 1, 'doctor', 'Ha modificado un doctor', '2025-10-14 12:42:05'),
(525, 1, 'doctor', 'Ha modificado un doctor', '2025-10-14 12:42:19'),
(526, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-14 12:51:02'),
(527, 1, 'doctor', 'Ha modificado un doctor', '2025-10-14 13:05:58'),
(528, 1, 'doctor', 'Ha modificado un doctor', '2025-10-14 13:06:08'),
(529, 1, 'cita', 'Ha Insertado una  cita', '2025-10-14 11:10:32'),
(530, 1, 'cita', 'Ha Insertado una  cita', '2025-10-14 12:22:48'),
(531, 1, 'cita', 'Ha modificado una  cita', '2025-10-14 12:42:06'),
(532, 1, 'cita', 'Ha modificado una  cita', '2025-10-14 12:42:12'),
(533, 1, 'cita', 'Ha modificado una  cita', '2025-10-14 12:42:56'),
(534, 1, 'cita', 'Ha modificado una  cita', '2025-10-14 12:43:03'),
(535, 1, 'cita', 'Ha modificado una  cita', '2025-10-14 12:43:12'),
(536, 1, 'cita', 'Ha modificado una  cita', '2025-10-14 12:43:19'),
(537, 1, 'cita', 'Ha modificado una  cita', '2025-10-14 12:43:51'),
(538, 1, 'factura', 'Ha facturado servicios y/o insumos', '2025-10-14 19:48:46'),
(539, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-14 23:51:48'),
(540, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-14 23:54:24'),
(541, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-14 23:55:17'),
(542, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:00:22'),
(543, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:00:32'),
(544, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:00:51'),
(545, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:01:08'),
(546, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:02:20'),
(547, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:03:28'),
(548, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:05:02'),
(549, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:05:26'),
(550, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:05:50'),
(551, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:06:00'),
(552, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:08:37'),
(553, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:08:47'),
(554, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:09:05'),
(555, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:17:17'),
(556, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:17:37'),
(557, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:17:50'),
(558, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:18:14'),
(559, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:18:33'),
(560, 1, 'Roles', 'Ha Modiicado un rol', '2025-10-15 00:18:47'),
(561, 1, 'cerrar session', 'Ha cerrado la session ', '2025-10-15 00:19:10'),
(562, 52, 'inicio sesion', 'Ha iniciado una session', '2025-10-15 00:19:22'),
(563, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-19 21:15:49'),
(564, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-10-19 22:16:19'),
(565, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-20 11:33:50'),
(566, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-30 18:34:35'),
(567, 1, 'doctor', 'Ha modificado un doctor', '2025-10-30 18:41:17'),
(568, 1, 'doctor', 'Ha modificado un doctor', '2025-10-30 18:41:36'),
(569, 1, 'Consultas', 'Ha añadido un servicio medico a un doctor', '2025-10-30 18:41:50'),
(570, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-10-30 18:43:23'),
(571, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-10-30 18:46:30'),
(572, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-10-30 18:46:30'),
(573, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-10-30 18:47:04'),
(574, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-10-30 19:28:30'),
(575, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-10-30 20:12:38'),
(576, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-10-30 20:25:13'),
(577, 1, 'mantenimiento', 'Se ha realizado una descarga del respaldo de la base de datos', '2025-10-30 20:35:21'),
(578, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-31 16:39:07'),
(579, 1, 'cerrar session', 'Ha cerrado la session ', '2025-10-31 18:49:23'),
(580, 1, 'inicio sesion', 'Ha iniciado una session', '2025-10-31 18:54:28'),
(581, 1, 'inicio sesion', 'Ha iniciado una session', '2025-11-01 11:28:05'),
(582, 1, 'hospitalizacion', 'Ha Insertado una hospitalizacion', '2025-11-01 11:30:25'),
(583, 1, 'hospitalizacion', 'Ha eliminado una hospitalizacion', '2025-11-01 11:30:40'),
(584, 1, 'hospitalizacion', 'Ha eliminado una hospitalizacion', '2025-11-01 11:30:54'),
(585, 1, 'hospitalizacion', 'Ha eliminado una hospitalizacion', '2025-11-01 11:32:30'),
(586, 1, 'inicio sesion', 'Ha iniciado una session', '2026-02-28 10:01:36'),
(587, 1, 'inicio sesion', 'Ha iniciado una session', '2026-02-28 10:15:57'),
(588, 1, 'insumo', 'Ha modificado un insumo', '2026-02-28 10:16:43'),
(589, 1, 'insumo', 'Ha modificado un insumo', '2026-02-28 10:17:08'),
(590, 1, 'insumo', 'Ha modificado un insumo', '2026-02-28 10:17:21'),
(591, 1, 'insumo', 'Ha modificado un insumo', '2026-02-28 10:17:35'),
(592, 1, 'insumo', 'Ha modificado un insumo', '2026-02-28 10:17:45'),
(593, 1, 'insumo', 'Ha modificado un insumo', '2026-02-28 10:19:42'),
(594, 1, 'insumo', 'Ha modificado un insumo', '2026-02-28 10:20:07'),
(595, 1, 'insumo', 'Ha modificado un insumo', '2026-02-28 10:20:19'),
(596, 1, 'insumo', 'Ha modificado un insumo', '2026-02-28 10:21:18'),
(597, 1, 'insumo', 'Ha modificado un insumo', '2026-02-28 10:21:44'),
(598, 1, 'insumo', 'Ha modificado un insumo', '2026-02-28 10:22:07'),
(599, 1, 'insumo', 'Ha modificado un insumo', '2026-02-28 10:22:23'),
(600, 1, 'Perfil', 'Ha modificado un perfil', '2026-02-28 10:23:34'),
(601, 1, 'paciente', 'Ha Insertado un nuevo paciente', '2026-02-28 10:27:38'),
(602, 1, 'paciente', 'Ha modificado un paciente', '2026-02-28 10:28:43'),
(603, 1, 'patologia', 'Ha restablecido una  patologia', '2026-02-28 10:29:08'),
(604, 1, 'cita', 'Ha Insertado una  cita', '2026-02-28 10:45:03'),
(605, 1, 'control', 'Ha Insertado un nuevo  control medico', '2026-02-28 10:46:37'),
(606, 1, 'control', 'Ha modificado un  control medico', '2026-02-28 10:46:55'),
(607, 1, 'sintomas', 'Ha Insertado un  sintoma', '2026-02-28 10:47:08'),
(608, 1, 'sintomas', 'Ha Insertado un  sintoma', '2026-02-28 10:47:19'),
(609, 1, 'sintomas', 'Ha Insertado un  sintoma', '2026-02-28 10:47:31'),
(610, 1, 'sintomas', 'Ha Insertado un  sintoma', '2026-02-28 10:47:42'),
(611, 1, 'sintomas', 'Ha Insertado un  sintoma', '2026-02-28 10:47:55'),
(612, 1, 'sintomas', 'Ha eliminado un  sintoma', '2026-02-28 10:48:01'),
(613, 1, 'cerrar session', 'Ha cerrado la session', '2026-02-28 10:50:00'),
(614, 1, 'inicio sesion', 'Ha iniciado una session', '2026-02-28 10:50:03'),
(615, 1, 'inicio sesion', 'Ha iniciado una session', '2026-02-28 15:05:19'),
(616, 1, 'factura', 'Ha facturado servicios y/o insumos', '2026-02-28 15:24:03'),
(617, 1, 'inicio sesion', 'Ha iniciado una session', '2026-02-28 16:04:01'),
(618, 1, 'inicio sesion', 'Ha iniciado una session', '2026-02-28 17:10:46'),
(619, 1, 'Perfil', 'Ha modificado un perfil', '2026-02-28 17:22:47'),
(620, 1, 'inicio sesion', 'Ha iniciado una session', '2026-02-28 17:30:24'),
(621, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-01 04:17:08'),
(622, 1, 'Servicio Medico', 'Ha asignado un servicio medico a un doctor', '2026-03-01 06:07:41'),
(623, 1, 'Servicio Medico', 'Ha asignado un servicio medico a un doctor', '2026-03-01 06:09:18'),
(624, 1, 'Servicio Medico', 'Ha asignado un servicio medico a un doctor', '2026-03-01 06:11:33'),
(625, 1, 'cita', 'Ha Insertado una  cita', '2026-03-01 06:12:06'),
(626, 1, 'cerrar session', 'Ha cerrado la session', '2026-03-01 06:47:48'),
(627, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-01 12:45:55'),
(628, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-01 14:50:00'),
(629, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-01 15:36:19'),
(630, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-02 14:47:19'),
(631, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-03 05:21:14'),
(632, 1, 'factura', 'Ha anulado una factura', '2026-03-03 06:29:23'),
(633, 1, 'factura', 'Ha anulado una factura', '2026-03-03 06:29:34'),
(634, 1, 'factura', 'Ha anulado una factura', '2026-03-03 06:30:36'),
(635, 1, 'factura', 'Ha anulado una factura', '2026-03-03 06:30:46'),
(636, 1, 'factura', 'Ha anulado una factura', '2026-03-03 06:31:38'),
(637, 1, 'factura', 'Ha anulado una factura', '2026-03-03 06:32:03'),
(638, 1, 'factura', 'Ha anulado una factura', '2026-03-03 06:32:50'),
(639, 1, 'factura', 'Ha anulado una factura', '2026-03-03 06:33:24'),
(640, 1, 'factura', 'Ha anulado una factura', '2026-03-03 06:33:34'),
(641, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-03 08:58:56'),
(642, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-03 15:14:41'),
(643, 1, 'paciente', 'Ha modificado un paciente', '2026-03-03 15:15:12'),
(644, 1, 'paciente', 'Ha modificado un paciente', '2026-03-03 15:15:19'),
(645, 1, 'factura', 'Ha facturado servicios y/o insumos', '2026-03-03 15:31:25'),
(646, 1, 'factura', 'Ha facturado servicios y/o insumos', '2026-03-03 15:33:04'),
(647, 1, 'factura', 'Ha facturado servicios y/o insumos', '2026-03-03 15:39:11'),
(648, 1, 'cerrar session', 'Ha cerrado la session', '2026-03-03 15:56:24'),
(649, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-03 15:56:26'),
(650, 1, 'paciente', 'Ha eliminado un  paciente', '2026-03-03 16:04:36'),
(651, 1, 'paciente', 'Ha restablecido un paciente', '2026-03-03 16:05:14'),
(652, 1, 'Perfil', 'Ha modificado un perfil', '2026-03-03 16:21:15'),
(653, 1, 'paciente', 'Ha modificado un paciente', '2026-03-03 16:22:00'),
(654, 1, 'paciente', 'Ha eliminado un  paciente', '2026-03-03 16:22:05'),
(655, 1, 'paciente', 'Ha restablecido un paciente', '2026-03-03 16:22:11'),
(656, 1, 'cliente', 'Ha eliminado un cliente', '2026-03-03 16:22:17'),
(657, 1, 'cliente', 'Ha restablecido un cliente', '2026-03-03 16:22:25'),
(658, 1, 'patologia', 'Ha eliminado una  patologia', '2026-03-03 16:22:32'),
(659, 1, 'patologia', 'Ha Insertado un nuevo patologia', '2026-03-03 16:22:44');
INSERT INTO `bitacora` (`id_bitacora`, `id_usuario`, `tabla`, `actividad`, `fecha_hora`) VALUES
(660, 1, 'patologia', 'Ha eliminado una  patologia', '2026-03-03 16:22:50'),
(661, 1, 'factura', 'Ha facturado servicios y/o insumos', '2026-03-03 16:25:31'),
(662, 1, 'cita', 'Ha Insertado una  cita', '2026-03-03 16:25:57'),
(663, 1, 'cita', 'Ha Modificado una  cita', '2026-03-03 16:26:05'),
(664, 1, 'cita', 'Ha eliminado una  cita', '2026-03-03 16:26:09'),
(665, 1, 'Categoria de servicio medico', 'Ha eliminado una categoria', '2026-03-03 16:27:13'),
(666, 1, 'control', 'Ha Insertado un nuevo  control medico', '2026-03-03 16:29:27'),
(667, 1, 'control', 'Ha modificado un  control medico', '2026-03-03 16:29:53'),
(668, 1, 'sintomas', 'Ha eliminado un  sintoma', '2026-03-03 16:30:00'),
(669, 1, 'insumo', 'Ha modificado un insumo', '2026-03-03 16:30:23'),
(670, 1, 'usuario', 'Ha modificado un  usuario', '2026-03-03 16:34:00'),
(671, 1, 'usuario', 'Ha modificado un  usuario', '2026-03-03 16:34:20'),
(672, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-04 04:21:02'),
(673, 1, 'Roles', 'Ha Insertado un nuevo rol', '2026-03-04 05:21:35'),
(674, 1, 'Roles', 'Ha Insertado un nuevo rol', '2026-03-04 05:23:11'),
(675, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-04 07:08:34'),
(676, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-04 12:25:21'),
(677, 1, 'Roles', 'Ha Modificado un rol', '2026-03-04 13:34:57'),
(678, 1, 'Roles', 'Ha Modificado un rol', '2026-03-04 13:35:15'),
(679, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-25 21:56:29'),
(680, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-26 06:24:04'),
(681, 1, 'paciente', 'Ha modificado un paciente', '2026-03-26 06:47:34'),
(682, 1, 'paciente', 'Ha modificado un paciente', '2026-03-26 06:56:46'),
(683, 1, 'cita', 'Ha Insertado una  cita', '2026-03-26 07:13:06'),
(684, 1, 'paciente', 'Ha modificado un paciente', '2026-03-26 07:18:49'),
(685, 1, 'paciente', 'Ha modificado un paciente', '2026-03-26 07:19:39'),
(686, 1, 'cliente', 'Ha modificado un cliente', '2026-03-26 07:24:54'),
(687, 1, 'Perfil', 'Ha modificado un perfil', '2026-03-26 07:29:18'),
(688, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-26 09:17:48'),
(689, 1, 'cerrar session', 'Ha cerrado la session', '2026-03-26 09:17:58'),
(690, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-26 09:17:59'),
(691, 1, 'cerrar session', 'Ha cerrado la session', '2026-03-26 09:18:08'),
(692, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-26 09:18:13'),
(693, 1, 'Categoria de servicio medico', 'Ha Insertado una nueva  categoria', '2026-03-26 10:02:39'),
(694, 1, 'paciente', 'Ha Insertado un nuevo paciente', '2026-03-26 10:58:48'),
(695, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-28 09:05:58'),
(696, 1, 'paciente', 'Ha Insertado un nuevo paciente', '2026-03-28 09:26:12'),
(697, 1, 'cita', 'Ha Insertado una  cita', '2026-03-28 09:26:33'),
(698, 1, 'paciente', 'Ha Insertado un nuevo paciente', '2026-03-28 10:12:04'),
(699, 1, 'paciente', 'Ha Insertado un nuevo paciente', '2026-03-28 10:12:48'),
(700, 1, 'paciente', 'Ha Insertado un nuevo paciente', '2026-03-28 10:17:01'),
(701, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-28 16:50:38'),
(702, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-28 17:10:36'),
(703, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-28 19:57:51'),
(704, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-28 20:42:10'),
(705, 1, 'cerrar session', 'Ha cerrado la session', '2026-03-28 20:42:17'),
(706, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-28 20:42:19'),
(707, 1, 'cerrar session', 'Ha cerrado la session', '2026-03-28 20:42:28'),
(708, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-28 20:42:30'),
(709, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-28 20:57:42'),
(710, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-29 10:16:08'),
(711, 1, 'usuario', 'Ha modificado un  usuario', '2026-03-29 10:43:13'),
(712, 1, 'modulo', 'Ha eliminado un  modulo del sistema', '2026-03-29 11:12:59'),
(713, 1, 'modulo', 'Ha Insertado un nuevo  modulo', '2026-03-29 11:53:03'),
(714, 1, 'modulo', 'Ha eliminado un  modulo del sistema', '2026-03-29 11:53:10'),
(715, 1, 'inicio sesion', 'Ha iniciado una session', '2026-03-30 07:57:44'),
(716, 1, 'modulo', 'Ha Insertado un nuevo  modulo', '2026-03-30 09:38:41'),
(717, 1, 'Roles', 'Ha Insertado un nuevo rol', '2026-03-30 09:56:18'),
(718, 1, 'Roles', 'Ha Modificado un rol', '2026-03-30 10:00:21'),
(719, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-13 15:40:51'),
(720, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-13 16:03:10'),
(721, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-13 16:03:19'),
(722, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-13 16:07:00'),
(723, 1, 'cliente', 'Ha Insertado un nuevo cliente', '2026-04-13 16:11:31'),
(724, 1, 'cliente', 'Ha Insertado un nuevo cliente', '2026-04-13 16:12:53'),
(725, 1, 'cliente', 'Ha Insertado un nuevo cliente', '2026-04-13 16:15:43'),
(726, 1, 'patologia', 'Ha Insertado un nuevo patologia', '2026-04-13 16:22:23'),
(727, 1, 'patologia', 'Ha Insertado un nuevo patologia', '2026-04-13 16:22:43'),
(728, 1, 'patologia', 'Ha Insertado un nuevo patologia', '2026-04-13 16:22:49'),
(729, 1, 'patologia', 'Ha Insertado un nuevo patologia', '2026-04-13 16:24:13'),
(730, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-13 20:20:55'),
(731, 1, 'cita', 'Ha Insertado una  cita', '2026-04-13 20:28:19'),
(732, 1, 'cita', 'Ha Insertado una  cita', '2026-04-13 20:29:33'),
(733, 1, 'doctor', 'Ha Insertado un nuevo doctor', '2026-04-13 20:34:45'),
(734, 1, 'control', 'Ha Insertado un nuevo  control medico', '2026-04-13 20:44:46'),
(735, 1, 'sintomas', 'Ha Insertado un  sintoma', '2026-04-13 20:49:25'),
(736, 1, 'insumo', 'Ha Insertado un insumo', '2026-04-13 21:02:26'),
(737, 1, 'insumo', 'Ha modificado un insumo', '2026-04-13 21:08:14'),
(738, 1, 'entrada', 'Ha insertado una entrada', '2026-04-13 21:10:19'),
(739, 1, 'entrada', 'Ha modificado una entrada', '2026-04-13 21:10:33'),
(740, 1, 'proveedor', 'Ha insertado un proveedor', '2026-04-13 21:13:57'),
(741, 1, 'proveedor', 'Ha modificado un proveedor', '2026-04-13 21:14:18'),
(742, 1, 'Perfil', 'Ha modificado un perfil', '2026-04-13 21:34:26'),
(743, 1, 'Perfil', 'Ha modificado un perfil', '2026-04-13 21:34:37'),
(744, 1, 'Perfil', 'Ha modificado un perfil', '2026-04-13 21:34:48'),
(745, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-13 21:35:14'),
(746, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-13 21:37:58'),
(747, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-13 21:38:08'),
(748, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-13 21:38:10'),
(749, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-13 21:38:25'),
(750, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-13 21:38:26'),
(751, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-13 21:39:05'),
(752, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-13 21:39:11'),
(753, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-13 21:39:16'),
(754, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-13 21:39:28'),
(755, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-14 06:21:59'),
(756, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-14 06:23:21'),
(757, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-14 06:23:24'),
(758, 1, 'paciente', 'Ha restablecido un paciente', '2026-04-14 06:28:45'),
(759, 1, 'cliente', 'Ha eliminado un cliente', '2026-04-14 06:29:12'),
(760, 1, 'cliente', 'Ha restablecido un cliente', '2026-04-14 06:30:12'),
(761, 1, 'cliente', 'Ha eliminado un cliente', '2026-04-14 07:23:25'),
(762, 1, 'factura', 'Ha anulado una factura', '2026-04-14 07:25:50'),
(763, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-14 10:09:45'),
(764, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-14 10:11:38'),
(765, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-14 10:11:47'),
(766, 1, 'patologia', 'Ha Insertado un nuevo patologia', '2026-04-14 10:12:10'),
(767, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-14 12:01:33'),
(768, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-14 12:01:41'),
(769, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-14 12:02:23'),
(770, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-14 12:07:19'),
(771, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-14 12:43:42'),
(772, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-14 12:43:48'),
(773, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-14 12:48:31'),
(774, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-14 12:48:37'),
(775, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-14 12:51:14'),
(776, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-14 12:56:54'),
(777, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-14 12:56:55'),
(778, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-21 10:32:00'),
(779, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-21 10:32:02'),
(780, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-21 10:32:18'),
(781, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-21 10:32:22'),
(782, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-21 10:32:28'),
(783, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-21 10:42:20'),
(784, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-21 11:19:49'),
(785, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-21 11:39:48'),
(786, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-21 11:57:15'),
(787, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-21 11:57:18'),
(788, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-21 12:05:40'),
(789, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-21 12:21:47'),
(790, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-21 12:21:56'),
(791, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-21 12:33:54'),
(792, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-21 12:44:59'),
(793, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-21 12:45:14'),
(794, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-21 12:46:35'),
(795, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-21 13:01:33'),
(796, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-21 13:01:40'),
(797, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-21 14:16:41'),
(798, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-21 14:17:54'),
(799, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-21 14:17:55'),
(800, 1, 'cerrar session', 'Ha cerrado la session', '2026-04-21 14:19:26'),
(801, 1, 'inicio sesion', 'Ha iniciado una session', '2026-04-21 14:19:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intentos_login`
--

CREATE TABLE `intentos_login` (
  `ip_usuario` varchar(45) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `cantidad_intentos` int(11) DEFAULT 1,
  `ultimo_intento` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bloqueado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `intentos_login`
--

INSERT INTO `intentos_login` (`ip_usuario`, `id_usuario`, `cantidad_intentos`, `ultimo_intento`, `bloqueado`) VALUES
('127.0.0.1', 1, 3, '2026-04-21 18:28:38', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `estado` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id_modulo`, `nombre`, `estado`) VALUES
(1, 'Pacientes', 'ACT'),
(2, 'Clientes', 'ACT'),
(3, 'Patologias', 'ACT'),
(4, 'Factura', 'ACT'),
(5, 'Citas', 'ACT'),
(6, 'Doctores', 'ACT'),
(7, 'Control', 'ACT'),
(8, 'Hospitalizacion', 'ACT'),
(9, 'Insumos', 'ACT'),
(10, 'Entrada', 'ACT'),
(11, 'Proveedores', 'ACT'),
(12, 'Usuarios', 'ACT'),
(13, 'Roles', 'ACT'),
(14, 'Reportes', 'ACT'),
(15, 'Estadisticas', 'ACT'),
(16, 'Mantenimiento', 'ACT'),
(17, 'Servicios', 'ACT'),
(18, 'David', 'DES'),
(19, 'Dsss', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `permisos` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `permisos`) VALUES
(30, 'consultar'),
(31, 'guardar'),
(32, 'eliminar'),
(33, 'editar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_de_rol`
--

CREATE TABLE `permisos_de_rol` (
  `id_permisos_de_rol` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos_de_rol`
--

INSERT INTO `permisos_de_rol` (`id_permisos_de_rol`, `id_rol`, `id_permiso`, `id_modulo`) VALUES
(1, 10, 30, 1),
(2, 10, 31, 1),
(3, 10, 33, 1),
(4, 10, 32, 1),
(8, 10, 30, 2),
(9, 10, 31, 2),
(10, 10, 32, 2),
(11, 10, 33, 2),
(12, 10, 30, 3),
(13, 10, 31, 3),
(14, 10, 32, 3),
(15, 10, 33, 3),
(16, 10, 30, 4),
(17, 10, 31, 4),
(18, 10, 32, 4),
(19, 10, 33, 4),
(20, 10, 30, 5),
(21, 10, 31, 5),
(22, 10, 32, 5),
(23, 10, 33, 5),
(24, 10, 30, 6),
(25, 10, 31, 6),
(26, 10, 32, 6),
(27, 10, 33, 6),
(28, 10, 30, 7),
(29, 10, 31, 7),
(30, 10, 32, 7),
(31, 10, 33, 7),
(32, 10, 30, 8),
(33, 10, 31, 8),
(34, 10, 32, 8),
(35, 10, 33, 8),
(36, 10, 30, 9),
(37, 10, 31, 9),
(38, 10, 32, 9),
(39, 10, 33, 9),
(40, 10, 30, 10),
(41, 10, 31, 10),
(42, 10, 32, 10),
(43, 10, 33, 10),
(44, 10, 30, 11),
(45, 10, 31, 11),
(46, 10, 32, 11),
(47, 10, 33, 11),
(48, 10, 30, 12),
(49, 10, 31, 12),
(50, 10, 32, 12),
(51, 10, 33, 12),
(52, 10, 30, 13),
(53, 10, 31, 13),
(54, 10, 32, 13),
(55, 10, 33, 13),
(56, 10, 30, 14),
(57, 10, 31, 14),
(58, 10, 32, 14),
(59, 10, 33, 14),
(60, 10, 30, 15),
(61, 10, 31, 15),
(62, 10, 32, 15),
(63, 10, 33, 15),
(64, 10, 30, 16),
(65, 10, 31, 16),
(66, 10, 32, 16),
(67, 10, 33, 16),
(68, 10, 30, 17),
(69, 10, 31, 17),
(70, 10, 32, 17),
(71, 10, 33, 17),
(72, 11, 30, 12),
(73, 11, 31, 12),
(74, 11, 33, 12),
(75, 11, 30, 9),
(76, 11, 31, 9),
(77, 11, 30, 4),
(78, 11, 31, 4),
(79, 11, 32, 4),
(80, 12, 30, 12),
(81, 12, 31, 12),
(82, 12, 32, 12),
(83, 12, 33, 12),
(84, 12, 30, 13),
(85, 12, 31, 13),
(86, 12, 32, 13),
(87, 12, 33, 13),
(88, 12, 30, 16),
(89, 12, 31, 16),
(90, 12, 32, 16),
(91, 12, 33, 16),
(95, 8, 30, 12),
(96, 8, 31, 12),
(97, 8, 32, 12),
(98, 8, 31, 13),
(99, 8, 32, 13),
(100, 13, 30, 12),
(101, 13, 31, 12),
(102, 13, 32, 12),
(103, 13, 30, 16),
(104, 13, 31, 16),
(105, 1, 30, 12),
(106, 1, 31, 12);

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
(1, 'Administrador', 'ACT', 'Administrador'),
(5, 'Rol', 'DES', 'este es un permiso par los doctores'),
(6, 'Propio', 'DES', 'descripcio'),
(7, 'Carlos', 'DES', 'jfhfdsjddjs'),
(8, 'Doctor', 'ACT', 'En un rol para los doctores'),
(9, 'Roletazo', 'DES', 'es un permiso de pruebas'),
(10, 'Superadmin', 'ACT', 'lsafdfjfd'),
(11, 'You', 'ACT', 'Es un antinflamatorio son derivados'),
(12, 'Xxx', 'ACT', 'Es una descipcion'),
(13, 'República', 'ACT', 'Qwwweeweee');

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
(1, 10, 'dragon-ball-z-super-3840x2160-13878.jpg', 'WDaniel123', 'correco@gmail.com', '$2y$10$1bMoW4177.FH45HrSHx/KOVV.LBAbDXnaGn1nMx3OtJ3MAah2NYnq', 'ACT'),
(42, 8, 'img30.png', 'Usuario123', 'WDaniel123@gmail.com', '$2y$10$1bMoW4177.FH45HrSHx/KOVV.LBAbDXnaGn1nMx3OtJ3MAah2NYnq', 'DES'),
(43, 8, 'arte-dragon-ball-super-goku-and-black-goku_7680x4320_xtrafondos.com.jpg', 'Usuario123', 'WDaniel143@gmail.com', '$2y$10$80gqRMUNCdZY2z7rKB7CxeCTQtH2zSJ/WdNBtaQ1/pHVyLWqNZvOW', 'ACT'),
(45, 8, 'doctor.png', 'yuE23', 'wbaez975@gmail.com', '$2y$10$ohxfRe.SGkI.b83el1Sqxu9eFyeA4IyFIjLafFnlaosIxMLvschm.', 'DES'),
(46, 8, 'doctor.png', 'weq', 'wbaez975@gmail.com', '$2y$10$WAANXp7gXMUe5ZixhhN4IOOfGrqKYsv7PeHzhf8cgf8xd56nTbqly', 'ACT'),
(52, 8, 'doctor.png', 'WDaniel1', 'wbaez975@gmail.com', '$2y$10$PYYiGKo3RDTI3JN6eiR6lexHNG90m0WWC1VgAg0cmhKfw3LCmXdaS', 'ACT'),
(53, 8, 'goku-kintoun-cloud-kame-house-island-dragon-ball-2k-wallpaper-uhdpaper.com-706@5@h.jpg', 'WDaniel000', 'correo@gmail.com', '$2y$10$eDqE5UYML.46g9jv9sK2iusuF4nqXEeCHFd6Ck/yLi1xRRCT/HIc.', 'ACT'),
(54, 11, 'goku-ultra-instinct-transformacion-dragon-ball-super_1920x1080_xtrafondos.com.jpg', 'WDaniel123', 'correco@gmail.com', '$2y$10$i5q.9zYhTYnZmeFnD0triO4f5KwPK/pYU8AK841A.m554dHmnG.ea', 'ACT');

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
-- Indices de la tabla `intentos_login`
--
ALTER TABLE `intentos_login`
  ADD PRIMARY KEY (`ip_usuario`),
  ADD KEY `fk_intento_usuario` (`id_usuario`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `permisos_de_rol`
--
ALTER TABLE `permisos_de_rol`
  ADD PRIMARY KEY (`id_permisos_de_rol`),
  ADD KEY `id_rol` (`id_rol`,`id_permiso`),
  ADD KEY `id_permiso` (`id_permiso`),
  ADD KEY `id_modulo` (`id_modulo`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

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
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=802;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `permisos_de_rol`
--
ALTER TABLE `permisos_de_rol`
  MODIFY `id_permisos_de_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `bitacora_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `intentos_login`
--
ALTER TABLE `intentos_login`
  ADD CONSTRAINT `fk_intento_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `permisos_de_rol`
--
ALTER TABLE `permisos_de_rol`
  ADD CONSTRAINT `permisos_de_rol_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`),
  ADD CONSTRAINT `permisos_de_rol_ibfk_2` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permiso`),
  ADD CONSTRAINT `permisos_de_rol_ibfk_3` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
