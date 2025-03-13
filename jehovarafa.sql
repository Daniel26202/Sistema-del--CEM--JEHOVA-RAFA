-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-03-2025 a las 02:21:54
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `jehova_rafa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id_bitacora` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tabla` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actividad` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `bitacora`:
--   `id_usuario`
--       `usuario` -> `id_usuario`
--

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id_bitacora`, `id_usuario`, `tabla`, `actividad`, `fecha_hora`) VALUES
(1, 1, 'paciente', 'Ha Insertado un nuevo paciente', '2025-03-04 16:08:23'),
(2, 1, 'paciente', 'Ha modificado un paciente', '2025-03-04 16:17:04'),
(3, 1, 'paciente', 'Ha eliminado un  paciente', '2025-03-04 16:18:17'),
(4, 1, 'paciente', 'Ha restablecido un paciente', '2025-03-04 16:20:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_servicio`
--

CREATE TABLE `categoria_servicio` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `estado` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `categoria_servicio`:
--

--
-- Volcado de datos para la tabla `categoria_servicio`
--

INSERT INTO `categoria_servicio` (`id_categoria`, `nombre`, `estado`) VALUES
(1, 'Consulta', 'ACT'),
(2, 'Eco', 'ACT'),
(3, 'RX', 'ACT'),
(4, 'Emergencia', 'ACT'),
(5, 'Electros', 'ACT'),
(6, 'Hospitalizacion', 'DES'),
(7, 'Masajes', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `id_cita` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_servicioMedico` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `cita`:
--   `id_paciente`
--       `paciente` -> `id_paciente`
--   `id_servicioMedico`
--       `serviciomedico` -> `id_servicioMedico`
--

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id_cita`, `id_paciente`, `id_servicioMedico`, `fecha`, `hora`, `estado`) VALUES
(30, 2, 16, '2024-11-22', '12:37:00', 'Realizadas'),
(31, 2, 16, '2024-11-29', '13:56:00', 'Pendiente'),
(32, 2, 16, '2024-11-22', '14:00:00', 'Pendiente'),
(33, 2, 16, '2024-11-22', '15:00:00', 'Pendiente'),
(34, 2, 16, '2024-11-29', '07:10:00', 'Pendiente'),
(35, 2, 16, '2024-11-23', '01:00:00', 'Pendiente'),
(36, 2, 16, '2024-11-23', '19:07:00', 'Pendiente'),
(37, 2, 16, '2024-11-23', '17:00:00', 'Realizadas'),
(38, 2, 16, '2024-11-29', '07:34:00', 'Pendiente'),
(39, 2, 16, '2024-11-30', '21:18:00', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control`
--

CREATE TABLE `control` (
  `id_control` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `diagnostico` text CHARACTER SET latin1 NOT NULL,
  `medicamentosRecetados` text CHARACTER SET latin1 NOT NULL,
  `fecha_control` datetime NOT NULL,
  `fechaRegreso` date NOT NULL,
  `nota` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `control`:
--   `id_paciente`
--       `paciente` -> `id_paciente`
--   `id_usuario`
--       `usuario` -> `id_usuario`
--

--
-- Volcado de datos para la tabla `control`
--

INSERT INTO `control` (`id_control`, `id_paciente`, `id_usuario`, `diagnostico`, `medicamentosRecetados`, `fecha_control`, `fechaRegreso`, `nota`, `estado`) VALUES
(20, 5, 7, 'sddssdds', 'sdsdsd121212', '2024-11-18 18:32:28', '2024-11-21', '', 'ACT'),
(21, 5, 4, 'diagnos', 'prescrip', '2024-11-18 17:43:49', '2024-11-26', 'looo', 'ACT'),
(22, 5, 4, 'diagn', 'prescrip', '2024-11-18 17:46:03', '2024-11-20', 'hh', 'ACT'),
(23, 2, 2, 'Infeccion', 'Antibioticos 100mg', '2024-11-22 21:21:05', '2024-11-27', '', 'ACT'),
(24, 2, 2, 'Dolor abdominal', 'buscapina', '2024-11-22 21:26:12', '2024-11-25', '', 'ACT'),
(25, 1, 2, 'dwdwdd', 'dwdwd', '2024-11-23 01:18:16', '2024-12-05', '', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada`
--

CREATE TABLE `entrada` (
  `id_entrada` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `numero_de_lote` int(16) NOT NULL,
  `fechaDeIngreso` date NOT NULL,
  `estado` varchar(10) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `entrada`:
--   `id_proveedor`
--       `proveedor` -> `id_proveedor`
--

--
-- Volcado de datos para la tabla `entrada`
--

INSERT INTO `entrada` (`id_entrada`, `id_proveedor`, `numero_de_lote`, `fechaDeIngreso`, `estado`) VALUES
(5, 1, 12345678, '2024-11-12', 'VEC'),
(6, 1, 12345670, '2024-11-12', 'VEC'),
(7, 1, 0, '2024-11-12', 'VEC'),
(8, 1, 12305678, '2024-11-12', 'VEC'),
(9, 1, 12345668, '2024-11-12', 'VEC'),
(10, 1, 11145678, '2024-11-12', 'VEC'),
(11, 1, 12345778, '2024-11-12', 'VEC'),
(12, 2, 52345678, '2024-11-14', 'VEC'),
(13, 2, 22345678, '2024-11-14', 'VEC'),
(14, 1, 32345678, '2024-11-14', 'VEC'),
(15, 1, 12345688, '2024-11-14', 'VEC'),
(16, 1, 16345679, '2024-11-14', 'VEC'),
(17, 1, 12245678, '2002-11-15', 'VEC'),
(18, 1, 12345671, '2010-11-15', 'VEC'),
(19, 2, 12345677, '2024-11-20', 'VEC'),
(20, 2, 12346578, '2007-05-06', 'VEC'),
(22, 1, 987654321, '2021-11-18', 'VEC'),
(23, 2, 111222333, '2024-11-18', 'VEC'),
(24, 1, 10101, '2024-11-18', 'VEC'),
(25, 2, 1111, '2024-11-18', 'VEC'),
(26, 1, 101010, '2011-05-06', 'VEC'),
(27, 2, 21212, '2024-11-22', 'ACT'),
(28, 2, 21212, '2024-11-22', 'VEC'),
(29, 1, 1111, '2024-11-22', 'VEC'),
(30, 1, 1111, '2024-11-22', 'VEC'),
(31, 2, 3333, '2024-11-22', 'VEC'),
(32, 1, 10101, '2024-11-22', 'VEC'),
(33, 2, 2222, '2024-11-22', 'VEC'),
(34, 1, 4546, '2024-11-23', 'VEC'),
(35, 1, 10101, '2024-11-23', 'VEC'),
(36, 4, 1234, '2025-01-18', 'ACT'),
(37, 3, 3243, '2025-02-17', 'ACT');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `entrada_insumo`:
--   `id_insumo`
--       `insumo` -> `id_insumo`
--   `id_entrada`
--       `entrada` -> `id_entrada`
--

--
-- Volcado de datos para la tabla `entrada_insumo`
--

INSERT INTO `entrada_insumo` (`id_entradaDeInsumo`, `id_insumo`, `id_entrada`, `fechaDeVencimiento`, `precio`, `cantidad_entrante`, `cantidad_disponible`) VALUES
(30, 22, 36, '2025-02-18', '130.00', 90, 90),
(31, 23, 37, '2025-02-23', '120.00', 100, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `id_especialidad` int(11) NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `especialidad`:
--

--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`id_especialidad`, `nombre`, `estado`) VALUES
(1, 'Medicina General', 'ACT'),
(2, 'Cardiologia', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(11) NOT NULL,
  `id_cita` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `total` float(12,2) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `id_hospitalizacion` int(11) DEFAULT NULL,
  `estado` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `factura`:
--   `id_cita`
--       `cita` -> `id_cita`
--   `id_paciente`
--       `paciente` -> `id_paciente`
--   `id_hospitalizacion`
--       `hospitalizacion` -> `id_hospitalizacion`
--

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_factura`, `id_cita`, `fecha`, `total`, `id_paciente`, `id_hospitalizacion`, `estado`) VALUES
(1, NULL, '2024-11-09', 39.68, 3, NULL, 'Anulada'),
(2, NULL, '2024-11-09', 23.00, 3, NULL, 'ACT'),
(3, NULL, '2024-11-09', 23.00, 3, NULL, 'ACT'),
(4, NULL, '2024-11-09', 101.00, 3, NULL, 'ACT'),
(5, NULL, '2024-11-09', 15.29, 3, NULL, 'ACT'),
(6, NULL, '2024-11-09', 23.00, 8, NULL, 'ACT'),
(7, NULL, '2024-11-09', 12.00, 3, NULL, 'ACT'),
(8, NULL, '2024-11-09', 16.68, 5, NULL, 'ACT'),
(9, NULL, '2024-11-09', 2.78, 5, NULL, 'ACT'),
(10, NULL, '2024-11-09', 37.50, 5, NULL, 'ACT'),
(11, NULL, '2024-11-11', 140.00, 3, NULL, 'ACT'),
(12, NULL, '2024-11-11', 140.00, 3, NULL, 'ACT'),
(13, NULL, '2024-11-11', 143.00, 5, NULL, 'ACT'),
(14, NULL, '2024-11-12', 15.00, 8, NULL, 'ACT'),
(15, NULL, '2024-11-13', 142.40, 5, NULL, 'ACT'),
(16, NULL, '2024-11-13', 142.40, 5, NULL, 'ACT'),
(17, NULL, '2024-11-14', 16.44, 5, NULL, 'ACT'),
(18, NULL, '2024-11-14', 17.64, 5, NULL, 'Anulada'),
(19, NULL, '2024-11-14', 142.00, 5, NULL, 'ACT'),
(20, NULL, '2024-11-14', 142.00, 5, NULL, 'ACT'),
(21, NULL, '2024-11-14', 142.00, 1, NULL, 'ACT'),
(22, NULL, '2024-11-14', 12.00, 5, NULL, 'ACT'),
(23, NULL, '2024-11-14', 128.00, 3, NULL, 'ACT'),
(24, NULL, '2024-11-14', 6.08, 3, NULL, 'ACT'),
(25, NULL, '2024-11-14', 154.00, 5, NULL, 'ACT'),
(26, NULL, '2024-11-14', 158.48, 2, NULL, 'ACT'),
(27, NULL, '2024-11-14', 142.44, 3, NULL, 'ACT'),
(28, NULL, '2024-11-14', 142.44, 3, NULL, 'ACT'),
(29, NULL, '2024-11-14', 163.88, 5, NULL, 'ACT'),
(30, NULL, '2024-11-14', 151.88, 1, NULL, 'ACT'),
(31, NULL, '2024-11-14', 24.40, 1, NULL, 'ACT'),
(32, NULL, '2024-11-14', 67.86, 1, NULL, 'ACT'),
(33, NULL, '2024-11-14', 1.00, 1, NULL, 'ACT'),
(34, NULL, '2024-11-14', 141.00, 5, NULL, 'ACT'),
(35, NULL, '2024-11-14', 128.20, 1, NULL, 'ACT'),
(36, NULL, '2024-11-14', 12.00, 5, NULL, 'ACT'),
(37, NULL, '2011-05-06', 50.00, NULL, 2, 'ACT'),
(38, NULL, '2011-05-06', 328.00, NULL, 3, 'ACT'),
(39, NULL, '2011-05-06', 242.00, NULL, 4, 'ACT'),
(40, NULL, '2011-05-06', 129.79, 5, NULL, 'ACT'),
(41, NULL, '2011-05-06', 160.00, 5, NULL, 'ACT'),
(42, NULL, '2024-11-22', 70.81, 2, NULL, 'ACT'),
(43, NULL, '2024-11-22', 123.00, 2, NULL, 'Anulada'),
(44, NULL, '2024-11-22', 15.26, 2, NULL, 'Anulada'),
(45, 30, '2024-11-22', 27.23, 2, NULL, 'Anulada'),
(46, NULL, '2024-11-23', 50.36, NULL, 8, 'ACT'),
(47, NULL, '2024-11-23', 50.36, NULL, 8, 'ACT'),
(48, NULL, '2024-11-23', 50.36, NULL, 8, 'ACT'),
(49, NULL, '2024-11-23', 50.36, NULL, 8, 'ACT'),
(50, NULL, '2024-11-23', 1504.92, NULL, 9, 'ACT'),
(51, 37, '2024-11-23', 22.00, 2, NULL, 'ACT'),
(52, 37, '2024-11-23', 14.44, 2, NULL, 'ACT'),
(53, 37, '2024-11-23', 14.44, 2, NULL, 'ACT'),
(54, NULL, '2024-11-23', 101.00, NULL, 10, 'ACT'),
(55, NULL, '2024-11-23', 101.00, NULL, 10, 'ACT'),
(56, NULL, '2024-11-23', 101.00, NULL, 10, 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturadeservicio`
--

CREATE TABLE `facturadeservicio` (
  `id_facturaDeServicio` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `id_servicioMedico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `facturadeservicio`:
--   `id_servicioMedico`
--       `serviciomedico` -> `id_servicioMedico`
--   `id_factura`
--       `factura` -> `id_factura`
--

--
-- Volcado de datos para la tabla `facturadeservicio`
--

INSERT INTO `facturadeservicio` (`id_facturaDeServicio`, `id_factura`, `id_servicioMedico`) VALUES
(37, 42, 17),
(38, 44, 17),
(39, 45, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horacostohospitalizacion`
--

CREATE TABLE `horacostohospitalizacion` (
  `id_horacostohospitalizacion` int(11) NOT NULL,
  `hora` int(11) NOT NULL,
  `costo` float(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `horacostohospitalizacion`:
--

--
-- Volcado de datos para la tabla `horacostohospitalizacion`
--

INSERT INTO `horacostohospitalizacion` (`id_horacostohospitalizacion`, `hora`, `costo`) VALUES
(1, 2, 100.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `diaslaborables` varchar(100) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `horario`:
--

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id_horario`, `diaslaborables`) VALUES
(1, 'Domingo'),
(2, 'Lunes'),
(3, 'Martes'),
(4, 'Miércoles'),
(5, 'Jueves'),
(6, 'Viernes'),
(7, 'Sábado');

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
-- RELACIONES PARA LA TABLA `horarioydoctor`:
--   `id_horario`
--       `horario` -> `id_horario`
--   `id_personal`
--       `personal` -> `id_personal`
--

--
-- Volcado de datos para la tabla `horarioydoctor`
--

INSERT INTO `horarioydoctor` (`id_horarioydoctor`, `id_personal`, `id_horario`, `horaDeEntrada`, `horaDeSalida`) VALUES
(19, 1, 6, '07:00:00', '12:00:00'),
(20, 1, 7, '12:00:00', '05:30:00'),
(21, 2, 1, '08:11:00', '14:14:00'),
(23, 9, 4, '14:00:00', '16:40:00'),
(24, 9, 5, '08:00:00', '10:40:00'),
(27, 15, 2, '16:30:00', '18:30:00'),
(28, 15, 3, '00:00:00', '00:00:00'),
(29, 15, 6, '18:30:00', '22:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hospitalizacion`
--

CREATE TABLE `hospitalizacion` (
  `id_hospitalizacion` int(11) NOT NULL,
  `id_control` int(11) NOT NULL,
  `id_horacostohospitalizacion` int(11) NOT NULL,
  `duracion` int(25) NOT NULL,
  `precio_horas` float NOT NULL,
  `total` float NOT NULL,
  `historiaclinica` text CHARACTER SET latin1 NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `hospitalizacion`:
--   `id_control`
--       `control` -> `id_control`
--   `id_horacostohospitalizacion`
--       `horacostohospitalizacion` -> `id_horacostohospitalizacion`
--

--
-- Volcado de datos para la tabla `hospitalizacion`
--

INSERT INTO `hospitalizacion` (`id_hospitalizacion`, `id_control`, `id_horacostohospitalizacion`, `duracion`, `precio_horas`, `total`, `historiaclinica`, `fecha_hora`, `estado`) VALUES
(2, 20, 1, 1, 50, 50, 'historial clicnico', '2011-05-06 01:52:27', 'Realizada'),
(3, 20, 1, 4, 200, 200, 'histial medico de el paciente', '2011-05-06 01:17:28', 'Realizada'),
(4, 20, 1, 2, 100, 100, 'jfesf dfbdsf', '2011-05-06 01:28:53', 'Realizada'),
(5, 24, 1, 50, 2500, 2504, 'historia', '2024-11-23 01:15:48', 'DES'),
(6, 24, 1, 9, 450, 452.06, '2', '2024-11-23 01:17:05', 'DES'),
(7, 25, 1, 332, 16600, 16600, 'hisr', '2024-11-23 01:18:57', 'DES'),
(8, 24, 1, 1, 50, 50.36, 'a', '2024-11-23 15:31:34', 'Realizada'),
(9, 25, 1, 30, 1500, 1504.92, '323', '2024-11-23 16:35:33', 'Realizada'),
(10, 24, 1, 2, 100, 101, 'medico', '2024-11-23 21:23:06', 'Realizada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo`
--

CREATE TABLE `insumo` (
  `id_insumo` int(11) NOT NULL,
  `imagen` varchar(500) CHARACTER SET latin1 NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 NOT NULL,
  `descripcion` text CHARACTER SET latin1 NOT NULL,
  `precio` float(12,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `stockMinimo` int(11) NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `insumo`:
--

--
-- Volcado de datos para la tabla `insumo`
--

INSERT INTO `insumo` (`id_insumo`, `imagen`, `nombre`, `descripcion`, `precio`, `cantidad`, `stockMinimo`, `estado`) VALUES
(3, '2024-11-12_1731435793_El-virus-de-Epstein-Barr-podria-ser-la-causa-principal-de-la-esclerosis-multiple.png', 'Neuronas', 'No-aplica', 1.20, -3, 5, 'DES'),
(4, '2024-11-12_1731435958_diagnostico-enfmeria-tipos-1200x600.jpg', 'Insumo', 'No-aplica', 0.78, 0, 5, 'DES'),
(5, '2024-11-12_1731436014_Portadas-post-quassar-la-M-300x188.jpg', 'Neuronas', 'descripcion', 2.53, 34, 3, 'DES'),
(6, '2024-11-14_1731598045_Portadas-post-quassar-la-M-300x188.jpg', 'Virus', 'descropcion', 0.35, 0, 5, 'DES'),
(7, '2024-11-15_1731681205_diagnostico-enfmeria-tipos-1200x600.jpg', 'Algo', 'descripcioncbfghfg bnb', 1.27, 14, 10, 'DES'),
(8, '2024-11-18_1731956244_santiana5.PNG', 'Acetaminofen', 'descripcion', 0.13, 100, 5, 'DES'),
(9, '2024-11-18_1731956620_El-virus-de-Epstein-Barr-podria-ser-la-causa-principal-de-la-esclerosis-multiple.png', 'Neurovion', 'descipcion', 0.20, 100, 10, 'DES'),
(10, '2024-11-18_1731956677_El-virus-de-Epstein-Barr-podria-ser-la-causa-principal-de-la-esclerosis-multiple.png', 'Neurovion', 'descipcion', 0.20, 100, 10, 'DES'),
(11, '2024-11-18_1731957196_diagnostico-enfmeria-tipos-1200x600.jpg', 'Vitamina', 'sdsfcd', 0.60, 0, 10, 'DES'),
(12, '2024-11-18_1731957971_gettyimages-713781677-612x612.jpg', 'Luciano', 'fvfdddf', 10.00, -10101, 2, 'DES'),
(13, '2024-11-18_1731958143_istockphoto-1218146095-612x612.jpg', 'Virulacion', 'descripc', 2.00, 0, 4, 'DES'),
(14, '2011-05-06_1304641799_sancocho-de-gallina.jpg', 'Sopa', 'esta descripcion', 1.00, 0, 1, 'DES'),
(17, 'insumoGenerico.png', 'Medico', 'sadfndb', 1.03, 0, 5, 'DES'),
(18, 'insumoGenerico.png', 'Insumo', 'descripcion', 1.23, 0, 5, 'DES'),
(19, 'insumoGenerico.png', 'Prueba', 'descripcion', 0.18, 0, 4, 'DES'),
(20, '2024-11-23_1732390747_El-virus-de-Epstein-Barr-podria-ser-la-causa-principal-de-la-esclerosis-multiple.png', 'Algodon', 'No-aplica', 0.12, 0, 20, 'DES'),
(21, '2024-11-23_1732396768_gettyimages-713781677-612x612.jpg', 'Lucianito', 'No-aplica', 0.82, 0, 4, 'DES'),
(22, '2025-01-18_1737211860_img3.jpg', 'Uno', 'Descripcion de medicamento', 1.44, 0, 10, 'ACT'),
(23, '2025-02-17_1739775038_Screenshot_10.png', 'Dos', 'descripcio', 1.20, 0, 5, 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumodefactura`
--

CREATE TABLE `insumodefactura` (
  `id_insumoDeFactura` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `id_inventario` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `insumodefactura`:
--   `id_factura`
--       `factura` -> `id_factura`
--   `id_inventario`
--       `inventario` -> `id_inventario`
--

--
-- Volcado de datos para la tabla `insumodefactura`
--

INSERT INTO `insumodefactura` (`id_insumoDeFactura`, `id_factura`, `id_inventario`, `cantidad`, `estado`) VALUES
(26, 43, 4, 100, 'ACT'),
(27, 44, 4, 1, 'ACT'),
(28, 44, 1, 1, 'ACT'),
(29, 45, 4, 1, 'ACT'),
(35, 51, 2, 15, 'ACT'),
(36, 52, 6, 12, 'ACT'),
(37, 53, 6, 12, 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumodehospitalizacion`
--

CREATE TABLE `insumodehospitalizacion` (
  `id_insumoDeHospitalizacion` int(11) NOT NULL,
  `id_hospitalizacion` int(11) NOT NULL,
  `id_insumo` int(11) NOT NULL,
  `cantidad` int(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `insumodehospitalizacion`:
--   `id_insumo`
--       `insumo` -> `id_insumo`
--   `id_hospitalizacion`
--       `hospitalizacion` -> `id_hospitalizacion`
--

--
-- Volcado de datos para la tabla `insumodehospitalizacion`
--

INSERT INTO `insumodehospitalizacion` (`id_insumoDeHospitalizacion`, `id_hospitalizacion`, `id_insumo`, `cantidad`) VALUES
(1, 5, 18, 4),
(2, 6, 17, 2),
(4, 9, 18, 4),
(5, 8, 19, 2),
(6, 10, 17, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_inventario` int(11) NOT NULL,
  `id_insumo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fachaVencimiento` date NOT NULL,
  `numero_de_lote` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `inventario`:
--   `id_insumo`
--       `insumo` -> `id_insumo`
--

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id_inventario`, `id_insumo`, `cantidad`, `fachaVencimiento`, `numero_de_lote`) VALUES
(1, 17, 120, '2024-11-23', 21212),
(2, 11, 45, '2024-12-02', 1111),
(3, 17, 25, '2024-11-26', 3333),
(4, 18, 100, '2024-11-29', 10101),
(5, 19, 250, '2024-12-07', 2222),
(6, 20, 100, '2024-11-24', 4546),
(7, 21, 150, '2024-11-25', 10101),
(8, 17, 1, '2024-12-12', 112345),
(9, 22, 100, '2025-02-18', 1234),
(10, 23, 100, '2025-02-23', 3243);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `id_paciente` int(11) NOT NULL,
  `nacionalidad` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cedula` varchar(25) CHARACTER SET latin1 NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 NOT NULL,
  `apellido` varchar(25) CHARACTER SET latin1 NOT NULL,
  `telefono` varchar(25) CHARACTER SET latin1 NOT NULL,
  `direccion` text CHARACTER SET latin1 NOT NULL,
  `fn` date NOT NULL,
  `estado` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `paciente`:
--

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`id_paciente`, `nacionalidad`, `cedula`, `nombre`, `apellido`, `telefono`, `direccion`, `fn`, `estado`) VALUES
(1, 'V', '10956121', 'Lissettee', 'Torrealba', '04164852843', 'La Lagunita', '2024-11-12', 'ACT'),
(2, 'V', '30554088', 'Luciano', 'Guedez', '04164852843', 'La Lagunita Calle 1', '2024-10-12', 'ACT'),
(3, 'V', '10956122', 'Dixon', 'Bastias', '04245120942', 'La otra Banda', '2004-10-08', 'ACT'),
(4, 'V', '35004765', 'Ana', 'Leal', '04123345236', 'El Tocuyo', '1999-04-13', 'ACT'),
(5, 'V', '30558234', 'Pedro', 'Gil', '04123454123', 'El cementerio', '2001-02-22', 'ACT'),
(6, 'V', '13456567', 'Arturo', 'Carlos', '0412345345', 'su direccion', '2000-11-07', 'DES'),
(8, 'V', '30554142', 'Rosimar', 'Pernaletes', '04121758305', 'Los palmares', '2003-05-30', 'DES'),
(9, 'V', '29506862', 'Surelys', 'Perez', '04244982882', 'Valencia', '0000-00-00', 'ACT'),
(10, 'V', '30554145', 'Asdsd', 'Sddss', '04164852843', 'La Lagunita', '2024-11-30', 'ACT'),
(11, 'V', '2599627', 'Pablo', 'Perez', '04125872132', 'La planta', '2024-11-29', 'ACT'),
(12, 'V', '67687823', 'Sinfo', 'Ape', '04124322121', 'La lag', '2024-11-21', 'DES'),
(13, 'V', '12123445', 'Juan', 'Carlos', '04123454321', 'La Lagunita', '2024-11-22', 'ACT'),
(14, 'V', '30553129', 'Pedro', 'Aguilar', '04123454321', 'En su casa', '2010-01-02', 'ACT'),
(15, 'V', '30554148', 'Pedro', 'Aguilar', '04123232321', 'En su casa', '2009-03-04', 'ACT'),
(16, 'V', '30334145', 'Pedro', 'Aguilar', '04122222212', 'En su casa', '2011-03-04', 'ACT'),
(17, 'V', '30551111', 'Pablo', 'Guedez', '04123453435', 'Su direccion es', '2000-03-30', 'ACT'),
(18, 'V', '30553122', 'Juan', 'Antoja', '04123243333', 'Su direccion es', '2011-02-27', 'ACT'),
(19, 'V', '423231', 'Juniel', 'Perez', '04122323211', 'En su direccion', '2011-03-13', 'ACT'),
(20, 'V', '1111114', 'Esteban', 'Peralta', '04123443234', 'Alli mismo', '2005-03-15', 'ACT'),
(21, 'V', '3011213', 'Pablo', 'Vega', '04121212213', 'Dsgfdgrdfdv', '2011-03-01', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id_pago` int(11) NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `pago`:
--

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id_pago`, `nombre`) VALUES
(1, 'Efectivo'),
(2, 'Transferencia'),
(3, 'Pago Movil'),
(4, 'Divisas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagodefactura`
--

CREATE TABLE `pagodefactura` (
  `id_pagoDeFactura` int(11) NOT NULL,
  `id_pago` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `referencia` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `monto` float(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `pagodefactura`:
--   `id_factura`
--       `factura` -> `id_factura`
--   `id_pago`
--       `pago` -> `id_pago`
--

--
-- Volcado de datos para la tabla `pagodefactura`
--

INSERT INTO `pagodefactura` (`id_pagoDeFactura`, `id_pago`, `id_factura`, `referencia`, `monto`) VALUES
(57, 1, 42, '', 70.81),
(58, 1, 43, '', 123.00),
(59, 1, 44, '', 15.26),
(60, 1, 45, '', 27.23),
(61, 1, 46, '', 50.36),
(62, 1, 47, '', 50.36),
(63, 1, 48, '', 50.36),
(64, 1, 49, '', 50.36),
(65, 1, 50, '', 1504.92),
(66, 1, 51, '', 22.00),
(67, 1, 52, '', 14.44),
(68, 1, 53, '', 14.44),
(69, 1, 54, '', 101.00),
(70, 1, 55, '', 101.00),
(71, 1, 56, '', 101.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patologia`
--

CREATE TABLE `patologia` (
  `id_patologia` int(11) NOT NULL,
  `nombre_patologia` varchar(25) CHARACTER SET latin1 NOT NULL,
  `estado` varchar(12) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `patologia`:
--

--
-- Volcado de datos para la tabla `patologia`
--

INSERT INTO `patologia` (`id_patologia`, `nombre_patologia`, `estado`) VALUES
(1, 'hipertenso', 'ACT'),
(2, 'ipertension', 'DES'),
(3, 'HA', 'DES'),
(4, 'Hipertension Arteria', 'ACT'),
(5, 'Artritis', 'ACT'),
(6, 'Ninguna', 'DES'),
(7, 'Diabetes', 'ACT'),
(8, 'Migraña', 'ACT'),
(9, 'Sas', 'ACT'),
(10, 'Asd', 'DES'),
(11, 'Ninguna', 'DES'),
(12, 'Asd', 'ACT');

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
-- RELACIONES PARA LA TABLA `patologiadepaciente`:
--   `id_patologia`
--       `patologia` -> `id_patologia`
--   `id_paciente`
--       `paciente` -> `id_paciente`
--

--
-- Volcado de datos para la tabla `patologiadepaciente`
--

INSERT INTO `patologiadepaciente` (`id_patologiaDePaciente`, `id_paciente`, `id_patologia`, `fecha_registro`) VALUES
(11, 5, 6, '2024-11-18 17:46:03'),
(12, 2, 8, '2024-11-22 21:21:05'),
(13, 2, 8, '2024-11-22 21:26:12'),
(14, 2, 9, '2024-11-22 21:26:12'),
(15, 1, 1, '2024-11-23 01:18:16');

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
  `email` varchar(25) NOT NULL,
  `tipodecategoria` varchar(25) NOT NULL,
  `id_especialidad` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `personal`:
--   `id_especialidad`
--       `especialidad` -> `id_especialidad`
--   `id_usuario`
--       `usuario` -> `id_usuario`
--

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`id_personal`, `nacionalidad`, `cedula`, `nombre`, `apellido`, `telefono`, `email`, `tipodecategoria`, `id_especialidad`, `id_usuario`) VALUES
(1, 'V', '30554088', 'Luciano', 'Guedez', '04245259901', 'lucianogp2004@gmail.com', 'Doctor', 1, 2),
(2, 'V', '3055555', 'DD424j. d', 'Dfsf', '04122223233', 'a@hh.com', 'Doctor', 2, 19),
(3, 'V', '30554086', 'lucian', 'hsjdh', '63472364', 'ksajdkljlk@gmail.com', 'Administrador', NULL, 22),
(4, 'V', '30342123', 'David', 'Perez', '04123423123', 'Surelita@gmail.com', 'Administrador', NULL, 23),
(5, 'V', '30554145', 'Pedroe', 'Julio', '04123422345', 'Hola@gmail.com', 'Administrador', NULL, 24),
(6, 'V', '1223342', 'David', 'Julio', '04123432123', 'Gato@gmail.com', 'Administrador', NULL, 25),
(8, 'V', '30554144', 'Luciano', 'Guedez', '04164852843', 'Gato@gmail.com', 'Administrador', NULL, 27),
(9, 'V', '16118637', 'Dsag23.,', 'Peralda', '04123342567', 'del@gmail.com', 'Doctor', 2, 28),
(10, 'V', '33751355', 'Wilmer', 'Perez', '04164852843', 'Hola@gmail.com', 'Administrador', NULL, 29),
(11, 'V', '20366382', 'Pablo', 'Guedez', '04123452435', 'Hola@gmail.com', 'Administrador', NULL, 30),
(14, 'V', '10956121', 'David', 'Rodriguez', '04123453456', 'Patata@gmail.com', 'Administrador', NULL, 39),
(15, 'V', '12234123', 'Isabel', 'Angulo', '04123453453', 'correo@gmail.com', 'Doctor', 1, 40),
(16, 'V', '30111345', 'Carlos', 'Hernandez', '04123454512', 'carlos123@gmail.com', 'doctor', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 NOT NULL,
  `rif` varchar(25) CHARACTER SET latin1 NOT NULL,
  `telefono` varchar(25) CHARACTER SET latin1 NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `proveedor`:
--

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre`, `rif`, `telefono`, `email`, `direccion`, `estado`) VALUES
(1, 'Luciano', 'E-123484634', '0412345678', '', '', 'DES'),
(2, 'Santiago', 'G-21312399', '04248782712', 'Hola@gmail.com', 'La Lagunita', 'ACT'),
(3, 'Luciano', 'G-43214532', '04123421234', 'Luciano@gmail.com', 'La Lagunita', 'ACT'),
(4, 'Wilmer', 'G-21312334', '04164567890', 'Hola@gmail.com', 'La Lagunita', 'ACT'),
(5, 'Carlos', 'J-61312399', '04164852843', 'Gato@gmail.com', 'La Lagunita', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recuperar_contr`
--

CREATE TABLE `recuperar_contr` (
  `id_recuperar_contr` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `codigo` varchar(55) NOT NULL,
  `fecha_expiracion` datetime NOT NULL,
  `intentos_fallidos` int(11) DEFAULT '0',
  `fecha_desbloqueo` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `recuperar_contr`:
--   `id_usuario`
--       `usuario` -> `id_usuario`
--

--
-- Volcado de datos para la tabla `recuperar_contr`
--

INSERT INTO `recuperar_contr` (`id_recuperar_contr`, `id_usuario`, `codigo`, `fecha_expiracion`, `intentos_fallidos`, `fecha_desbloqueo`) VALUES
(26, 1, '345819', '2025-02-22 16:52:03', 0, '0000-00-00 00:00:00'),
(27, 2, '142412', '2025-02-22 17:11:40', 0, '0000-00-00 00:00:00'),
(28, 1, '438044', '2025-02-22 18:08:37', 4, '0000-00-00 00:00:00'),
(29, 1, '194745', '2025-02-22 18:37:49', 0, '0000-00-00 00:00:00'),
(30, 1, '134250', '2025-02-22 18:37:52', 0, '0000-00-00 00:00:00'),
(31, 1, '945319', '2025-02-22 18:42:08', 0, '0000-00-00 00:00:00'),
(32, 1, '220318', '2025-02-22 18:42:51', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `rol`:
--

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`) VALUES
(1, 'administrador'),
(2, 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serviciomedico`
--

CREATE TABLE `serviciomedico` (
  `id_servicioMedico` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_personal` int(11) NOT NULL,
  `precio` float(12,2) NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `serviciomedico`:
--   `id_categoria`
--       `categoria_servicio` -> `id_categoria`
--   `id_personal`
--       `personal` -> `id_personal`
--

--
-- Volcado de datos para la tabla `serviciomedico`
--

INSERT INTO `serviciomedico` (`id_servicioMedico`, `id_categoria`, `id_personal`, `precio`, `estado`) VALUES
(16, 1, 1, 13.00, 'ACT'),
(17, 2, 1, 13.00, 'ACT'),
(18, 3, 2, 60.00, 'ACT'),
(19, 4, 1, 23.00, 'DES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sintomas`
--

CREATE TABLE `sintomas` (
  `id_sintomas` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `estado` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `sintomas`:
--

--
-- Volcado de datos para la tabla `sintomas`
--

INSERT INTO `sintomas` (`id_sintomas`, `nombre`, `estado`) VALUES
(1, 'Tos', 'ACT'),
(2, 'Gripe', 'ACT'),
(3, 'Fiebre', 'ACT'),
(4, 'Dolor', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sintomas_control`
--

CREATE TABLE `sintomas_control` (
  `id_sintomas_control` int(11) NOT NULL,
  `id_sintomas` int(11) NOT NULL,
  `id_control` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `sintomas_control`:
--   `id_control`
--       `control` -> `id_control`
--   `id_sintomas`
--       `sintomas` -> `id_sintomas`
--

--
-- Volcado de datos para la tabla `sintomas_control`
--

INSERT INTO `sintomas_control` (`id_sintomas_control`, `id_sintomas`, `id_control`) VALUES
(30, 1, 21),
(31, 1, 22),
(32, 3, 22),
(33, 3, 23),
(34, 1, 24),
(35, 2, 25),
(36, 3, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `correo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONES PARA LA TABLA `usuario`:
--   `id_rol`
--       `rol` -> `id_rol`
--

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `id_rol`, `imagen`, `usuario`, `correo`, `password`, `estado`) VALUES
(1, 1, 'doctor (1).png', 'WD', 'correo@gmail.com', '$2y$10$RVbIe0Zmcp42b8SrcROiK.8Vd7PnpfSGrnXJbkPYgg6NdaLhXMioS', 'ACT'),
(2, 2, 'doctor (1).png', 'Lucianogp', '', 'Tocuyo*15', 'ACT'),
(3, 2, 'diagnostico-enfmeria-tipos-1200x600.jpg', 'Julian.123', '', 'Julian.12', 'ACT'),
(4, 2, 'diagnostico-enfmeria-tipos-1200x600.jpg', 'Avila123', '', 'Avila.30', 'ACT'),
(5, 2, 'Adenopata_200x223.png', 'MariRon', '', 'Sistema.30', 'ACT'),
(6, 2, 'gettyimages-713781677-612x612.jpg', 'Carlosjj', '', 'Sistema.30', 'ACT'),
(7, 2, 'Adenopata_200x223.png', 'lii123', '', 'Sistema.20', 'ACT'),
(8, 2, 'unnamed.jpg', 'Usuario', '', 'Usuqw123*', 'ACT'),
(9, 2, 'doctor.png', 'Corre123', '', 'Correo123*', 'ACT'),
(10, 2, 'images (1).jpg', 'Usua12', '', 'Dixon123*', 'ACT'),
(11, 2, 'doctor.png', 'Correo123', '', 'Corre432^*', 'ACT'),
(12, 2, 'doctor.png', 'CDA123', '', 'CD123**1', 'ACT'),
(13, 2, 'doctor.png', 'Usu123', '', 'Usuario12*', 'ACT'),
(14, 2, 'doctor.png', 'Dox123', '', 'Cod123^**', 'ACT'),
(15, 2, 'doctor.png', 'SSS123', '', 'David321*', 'ACT'),
(16, 2, 'doctor.png', 'SSS123', '', 'David321*', 'ACT'),
(17, 2, 'doctor.png', 'Moreno123', '', 'Moreno123**', 'ACT'),
(18, 2, 'doctor.png', 'Sotille1', '', 'Sotille123*', 'ACT'),
(19, 2, 'doctor.png', 'Lucianogp2003', '', 'Tocuyo*16', 'DES'),
(20, 1, 'Array', 'kdkhfjks', '', 'kshdksjjfd', 'ACT'),
(21, 1, 'evidencia5.png', 'kdkhfjks', '', 'kshdksjjfd', 'ACT'),
(22, 1, 'evidencia5.png', 'kdkhfjks', '', 'kshdksjjfd', 'DES'),
(23, 1, 'El-virus-de-Epstein-Barr-podria-ser-la-causa-', 'usuario45', '', 'Dixon123*', 'DES'),
(24, 1, 'gettyimages-713781677-612x612.jpg', 'usuario123*45', '', 'Usuar456*2', 'DES'),
(25, 1, 'El-virus-de-Epstein-Barr-podria-ser-la-causa-', 'Usuadb123*', '', 'Queso567*', 'DES'),
(26, 1, 'doctor.png', 'usuario123', '', 'Usua1123*', 'ACT'),
(27, 1, 'doctor.png', 'usuario123', '', '123', 'ACT'),
(28, 2, 'doctor.png', 'usuario', '', 'Dsag23.,', 'ACT'),
(29, 1, 'doctor.png', 'usuariol', '', 'Sin.303240', 'ACT'),
(30, 1, 'doctor.png', 'usuario', '', 'Dw.,3455677', 'ACT'),
(31, 1, 'doctor.png', 'usuario123', '', '123', 'ACT'),
(32, 1, 'doctor.png', ' usuario123', '', '3212', 'ACT'),
(33, 1, 'doctor.png', ' usuario123', '', 'shsa', 'ACT'),
(34, 1, 'doctor.png', 'usuario123', '', '243wd', 'ACT'),
(35, 1, 'doctor.png', 'usuario123**', '', 'Pedro123', 'ACT'),
(36, 1, 'doctor.png', 'usuario123**', '', '', 'ACT'),
(37, 1, 'doctor.png', 'usuario123', '', 'Dixon123', 'ACT'),
(38, 1, 'doctor.png', 'usuario123', '', 'usuario123', 'ACT'),
(39, 1, 'doctor.png', 'usuario789*', '', 'Queso123*', 'ACT'),
(40, 2, 'doctor.png', 'Isa123', '', 'Isabel123]A', 'ACT');

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
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_servicioMedico` (`id_servicioMedico`);

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
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_cita` (`id_cita`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_hospitalizacion` (`id_hospitalizacion`);

--
-- Indices de la tabla `facturadeservicio`
--
ALTER TABLE `facturadeservicio`
  ADD PRIMARY KEY (`id_facturaDeServicio`),
  ADD KEY `id_factura` (`id_factura`,`id_servicioMedico`),
  ADD KEY `id_servicioMedico` (`id_servicioMedico`);

--
-- Indices de la tabla `horacostohospitalizacion`
--
ALTER TABLE `horacostohospitalizacion`
  ADD PRIMARY KEY (`id_horacostohospitalizacion`);

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
  ADD KEY `id_control` (`id_control`),
  ADD KEY `id_horacostohospitalizacion` (`id_horacostohospitalizacion`);

--
-- Indices de la tabla `insumo`
--
ALTER TABLE `insumo`
  ADD PRIMARY KEY (`id_insumo`);

--
-- Indices de la tabla `insumodefactura`
--
ALTER TABLE `insumodefactura`
  ADD PRIMARY KEY (`id_insumoDeFactura`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `id_insumo` (`id_inventario`);

--
-- Indices de la tabla `insumodehospitalizacion`
--
ALTER TABLE `insumodehospitalizacion`
  ADD PRIMARY KEY (`id_insumoDeHospitalizacion`),
  ADD KEY `id_hospitalizacion` (`id_hospitalizacion`),
  ADD KEY `id_insumo` (`id_insumo`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_inventario`),
  ADD KEY `id_entrada` (`id_insumo`);

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
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id_personal`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD KEY `id_especialidad` (`id_especialidad`,`id_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `recuperar_contr`
--
ALTER TABLE `recuperar_contr`
  ADD PRIMARY KEY (`id_recuperar_contr`),
  ADD KEY `id_usuario` (`id_usuario`);

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
  ADD KEY `id_doctor` (`id_personal`),
  ADD KEY `id_categoria` (`id_categoria`);

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
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `categoria_servicio`
--
ALTER TABLE `categoria_servicio`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `control`
--
ALTER TABLE `control`
  MODIFY `id_control` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `entrada`
--
ALTER TABLE `entrada`
  MODIFY `id_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `entrada_insumo`
--
ALTER TABLE `entrada_insumo`
  MODIFY `id_entradaDeInsumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `id_especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `facturadeservicio`
--
ALTER TABLE `facturadeservicio`
  MODIFY `id_facturaDeServicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `horacostohospitalizacion`
--
ALTER TABLE `horacostohospitalizacion`
  MODIFY `id_horacostohospitalizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `horarioydoctor`
--
ALTER TABLE `horarioydoctor`
  MODIFY `id_horarioydoctor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `hospitalizacion`
--
ALTER TABLE `hospitalizacion`
  MODIFY `id_hospitalizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `insumo`
--
ALTER TABLE `insumo`
  MODIFY `id_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `insumodefactura`
--
ALTER TABLE `insumodefactura`
  MODIFY `id_insumoDeFactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `insumodehospitalizacion`
--
ALTER TABLE `insumodehospitalizacion`
  MODIFY `id_insumoDeHospitalizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_inventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pagodefactura`
--
ALTER TABLE `pagodefactura`
  MODIFY `id_pagoDeFactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `patologia`
--
ALTER TABLE `patologia`
  MODIFY `id_patologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `patologiadepaciente`
--
ALTER TABLE `patologiadepaciente`
  MODIFY `id_patologiaDePaciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id_personal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `recuperar_contr`
--
ALTER TABLE `recuperar_contr`
  MODIFY `id_recuperar_contr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `serviciomedico`
--
ALTER TABLE `serviciomedico`
  MODIFY `id_servicioMedico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `sintomas`
--
ALTER TABLE `sintomas`
  MODIFY `id_sintomas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sintomas_control`
--
ALTER TABLE `sintomas_control`
  MODIFY `id_sintomas_control` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
  ADD CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`),
  ADD CONSTRAINT `cita_ibfk_3` FOREIGN KEY (`id_servicioMedico`) REFERENCES `serviciomedico` (`id_servicioMedico`);

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
  ADD CONSTRAINT `entrada_insumo_ibfk_1` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`id_insumo`),
  ADD CONSTRAINT `entrada_insumo_ibfk_2` FOREIGN KEY (`id_entrada`) REFERENCES `entrada` (`id_entrada`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_4` FOREIGN KEY (`id_cita`) REFERENCES `cita` (`id_cita`),
  ADD CONSTRAINT `factura_ibfk_5` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`),
  ADD CONSTRAINT `factura_ibfk_6` FOREIGN KEY (`id_hospitalizacion`) REFERENCES `hospitalizacion` (`id_hospitalizacion`);

--
-- Filtros para la tabla `facturadeservicio`
--
ALTER TABLE `facturadeservicio`
  ADD CONSTRAINT `facturadeservicio_ibfk_1` FOREIGN KEY (`id_servicioMedico`) REFERENCES `serviciomedico` (`id_servicioMedico`),
  ADD CONSTRAINT `facturadeservicio_ibfk_2` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`);

--
-- Filtros para la tabla `horarioydoctor`
--
ALTER TABLE `horarioydoctor`
  ADD CONSTRAINT `horarioydoctor_ibfk_1` FOREIGN KEY (`id_horario`) REFERENCES `horario` (`id_horario`),
  ADD CONSTRAINT `horarioydoctor_ibfk_2` FOREIGN KEY (`id_personal`) REFERENCES `personal` (`id_personal`);

--
-- Filtros para la tabla `hospitalizacion`
--
ALTER TABLE `hospitalizacion`
  ADD CONSTRAINT `hospitalizacion_ibfk_1` FOREIGN KEY (`id_control`) REFERENCES `control` (`id_control`),
  ADD CONSTRAINT `hospitalizacion_ibfk_2` FOREIGN KEY (`id_horacostohospitalizacion`) REFERENCES `horacostohospitalizacion` (`id_horacostohospitalizacion`);

--
-- Filtros para la tabla `insumodefactura`
--
ALTER TABLE `insumodefactura`
  ADD CONSTRAINT `insumodefactura_ibfk_2` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`),
  ADD CONSTRAINT `insumodefactura_ibfk_3` FOREIGN KEY (`id_inventario`) REFERENCES `inventario` (`id_inventario`);

--
-- Filtros para la tabla `insumodehospitalizacion`
--
ALTER TABLE `insumodehospitalizacion`
  ADD CONSTRAINT `insumodehospitalizacion_ibfk_1` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`id_insumo`),
  ADD CONSTRAINT `insumodehospitalizacion_ibfk_2` FOREIGN KEY (`id_hospitalizacion`) REFERENCES `hospitalizacion` (`id_hospitalizacion`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`id_insumo`);

--
-- Filtros para la tabla `pagodefactura`
--
ALTER TABLE `pagodefactura`
  ADD CONSTRAINT `pagodefactura_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`),
  ADD CONSTRAINT `pagodefactura_ibfk_2` FOREIGN KEY (`id_pago`) REFERENCES `pago` (`id_pago`);

--
-- Filtros para la tabla `patologiadepaciente`
--
ALTER TABLE `patologiadepaciente`
  ADD CONSTRAINT `patologiadepaciente_ibfk_1` FOREIGN KEY (`id_patologia`) REFERENCES `patologia` (`id_patologia`),
  ADD CONSTRAINT `patologiadepaciente_ibfk_2` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`);

--
-- Filtros para la tabla `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `personal_ibfk_1` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidad` (`id_especialidad`),
  ADD CONSTRAINT `personal_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `recuperar_contr`
--
ALTER TABLE `recuperar_contr`
  ADD CONSTRAINT `recuperar_contr_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `serviciomedico`
--
ALTER TABLE `serviciomedico`
  ADD CONSTRAINT `serviciomedico_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_servicio` (`id_categoria`),
  ADD CONSTRAINT `serviciomedico_ibfk_3` FOREIGN KEY (`id_personal`) REFERENCES `personal` (`id_personal`);

--
-- Filtros para la tabla `sintomas_control`
--
ALTER TABLE `sintomas_control`
  ADD CONSTRAINT `sintomas_control_ibfk_1` FOREIGN KEY (`id_control`) REFERENCES `control` (`id_control`),
  ADD CONSTRAINT `sintomas_control_ibfk_2` FOREIGN KEY (`id_sintomas`) REFERENCES `sintomas` (`id_sintomas`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
