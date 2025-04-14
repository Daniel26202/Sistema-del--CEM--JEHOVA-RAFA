-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-04-2025 a las 16:44:41
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
-- Base de datos: `bd`
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
(24, 1, 'Roles', 'Ha Insertado un nuevo rol', '2025-04-14 10:40:11');

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
(9, 'RADIOGRAFIA', 'ACT'),
(100, 'CONSULTA GENERAL', 'ACT'),
(101, 'Emergencia', 'ACT');

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
(44, '2025-04-02', '12:33:00', 'ACT', 22, 23);

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
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `control`
--

INSERT INTO `control` (`id_control`, `id_paciente`, `id_usuario`, `diagnostico`, `medicamentosRecetados`, `fecha_control`, `fechaRegreso`, `nota`, `estado`) VALUES
(26, 23, 1, 'El chico presenta dificultad para respirar, hinchazón en el cuerpo y dolores de cabeza', 'Cetirizina\r\nSalbutamol\r\nAcetaminofén', '2025-04-02 14:37:34', '2025-04-26', 'Debe hacerse hematología completa', 'ACT'),
(27, 24, 1, 'La paciente presenta severos dolores de cabeza, lo cual da a entender que tiene episodios de jaqueca, a su vez también presenta problemas con la visión y mareos\r\nTomar mucha agua', 'Diclofenac potasico\r\nCafeína\r\nViajesan', '2025-04-02 14:45:09', '2025-04-23', 'Tomar mucha agua', 'ACT');

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
(39, 7, 2, '2025-04-06', 'ACT');

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

--
-- Volcado de datos para la tabla `entrada_insumo`
--

INSERT INTO `entrada_insumo` (`id_entradaDeInsumo`, `id_insumo`, `id_entrada`, `fechaDeVencimiento`, `precio`, `cantidad_entrante`, `cantidad_disponible`) VALUES
(32, 24, 38, '2030-04-01', 64.00, 25, 25),
(33, 25, 39, '2030-04-01', 44.00, 25, 25);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_has_inventario`
--

CREATE TABLE `factura_has_inventario` (
  `factura_id_factura` int(11) NOT NULL,
  `inventario_id_inventario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `diaslaborables` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hospitalizacion`
--

CREATE TABLE `hospitalizacion` (
  `id_hospitalizacion` int(11) NOT NULL,
  `duracion` int(25) NOT NULL,
  `precio_horas` float NOT NULL,
  `total` float NOT NULL,
  `historiaclinica` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo`
--

CREATE TABLE `insumo` (
  `id_insumo` int(11) NOT NULL,
  `imagen` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `descripcion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `precio` float(12,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `stockMinimo` int(11) NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `insumo`
--

INSERT INTO `insumo` (`id_insumo`, `imagen`, `nombre`, `descripcion`, `precio`, `cantidad`, `stockMinimo`, `estado`) VALUES
(24, '', 'Paracetamol', 'El paracetamol, también conocido como acetaminofén o acetaminofeno, es un fármaco con propiedades analgésicas y antipiréticas utilizado principalmente para tratar la fiebre y el dolor leve y moderado', 25.00, 25, 1, 'ACT'),
(25, '', 'Ibuprofeno', 'El ibuprofeno es un antinflamatorio no esteroideo (AINE) que pertenece al subgrupo de fármacos derivados del ácido propiónico.', 33.00, 25, 1, 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumodehospitalizacion`
--

CREATE TABLE `insumodehospitalizacion` (
  `id_insumoDeHospitalizacion` int(11) NOT NULL,
  `id_hospitalizacion` int(11) NOT NULL,
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
  `fachaVencimiento` date NOT NULL,
  `numero_de_lote` int(16) NOT NULL,
  `insumodehospitalizacion_id_insumoDeHospitalizacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `estado` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`id_paciente`, `nacionalidad`, `cedula`, `nombre`, `apellido`, `telefono`, `direccion`, `fn`, `estado`) VALUES
(23, 'V', '28150004', 'Juan', 'Silva', '04121338031', 'Calle 10 entre 3 y 7', '2001-09-22', 'ACT'),
(24, 'V', '28329224', 'Rocio', 'Rodriguez', '04121338031', 'URB EL BOSQUE CALLE 12', '2025-04-02', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id_pago` int(11) NOT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(13, 'ASMA', '1');

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
(17, 23, 13, '2025-04-02 20:13:46');

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
(1, 1, 'sjdasoidjsaoijdasoijdisosadsoiajdsaoijdasoid,.sakdiosapdksapodkaspod', 'pacientes'),
(2, 5, 'consultar,guardar,editar,eliminar', 'Pacientes'),
(3, 5, 'consultar,guardar,editar,eliminar', 'Patologias');

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
(18, 'V', '30554145', 'Dixon', 'Bastias', '04145378241', 'Administrador', NULL, 1);

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
(18, 25);

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
(6, 'Juan Jose', '281500045', '04121338031', 'depanajuaner@gmail.com', '', 'ACT'),
(7, 'Ricardo Perez', '296236571', '04124466999', 'sisisi@gmail.com', '', 'ACT');

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
(4, 'Doctor', 'ACT', 'Descripcion'),
(5, 'Agua', 'ACT', 'ghjjiuhj');

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
(25, 101, 1000.00, 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serviciomedico_has_factura`
--

CREATE TABLE `serviciomedico_has_factura` (
  `serviciomedico_id_servicioMedico` int(11) NOT NULL,
  `factura_id_factura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(14, 'Encias sangrantes', 'ACT');

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
(1, 1, '', 'WD', 'depanajuaner@gmail.com', '$2y$10$RTM.OZavxr3atFI8TENRHODY69HaCo94cURs9qwiMjKzEsBP3jmDO', 'ACT');

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
  ADD PRIMARY KEY (`factura_id_factura`,`inventario_id_inventario`),
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
  ADD PRIMARY KEY (`id_hospitalizacion`);

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
  ADD KEY `id_hospitalizacion` (`id_hospitalizacion`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_inventario`,`insumodehospitalizacion_id_insumoDeHospitalizacion`),
  ADD KEY `id_entrada` (`id_insumo`),
  ADD KEY `fk_inventario_insumodehospitalizacion1_idx` (`insumodehospitalizacion_id_insumoDeHospitalizacion`);

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
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `categoria_servicio`
--
ALTER TABLE `categoria_servicio`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `control`
--
ALTER TABLE `control`
  MODIFY `id_control` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `entrada`
--
ALTER TABLE `entrada`
  MODIFY `id_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `entrada_insumo`
--
ALTER TABLE `entrada_insumo`
  MODIFY `id_entradaDeInsumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `id_especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

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
  MODIFY `id_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `id_patologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `patologiadepaciente`
--
ALTER TABLE `patologiadepaciente`
  MODIFY `id_patologiaDePaciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idpermisos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id_personal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `serviciomedico`
--
ALTER TABLE `serviciomedico`
  MODIFY `id_servicioMedico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `sintomas`
--
ALTER TABLE `sintomas`
  MODIFY `id_sintomas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `sintomas_control`
--
ALTER TABLE `sintomas_control`
  MODIFY `id_sintomas_control` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
  ADD CONSTRAINT `entrada_insumo_ibfk_1` FOREIGN KEY (`id_insumo`) REFERENCES `insumo` (`id_insumo`),
  ADD CONSTRAINT `entrada_insumo_ibfk_2` FOREIGN KEY (`id_entrada`) REFERENCES `entrada` (`id_entrada`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_factura_paciente1` FOREIGN KEY (`paciente_id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_has_inventario`
--
ALTER TABLE `factura_has_inventario`
  ADD CONSTRAINT `fk_factura_has_inventario_factura1` FOREIGN KEY (`factura_id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_has_inventario_inventario1` FOREIGN KEY (`inventario_id_inventario`) REFERENCES `inventario` (`id_inventario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `horarioydoctor`
--
ALTER TABLE `horarioydoctor`
  ADD CONSTRAINT `horarioydoctor_ibfk_1` FOREIGN KEY (`id_horario`) REFERENCES `horario` (`id_horario`),
  ADD CONSTRAINT `horarioydoctor_ibfk_2` FOREIGN KEY (`id_personal`) REFERENCES `personal` (`id_personal`);

--
-- Filtros para la tabla `insumodehospitalizacion`
--
ALTER TABLE `insumodehospitalizacion`
  ADD CONSTRAINT `insumodehospitalizacion_ibfk_2` FOREIGN KEY (`id_hospitalizacion`) REFERENCES `hospitalizacion` (`id_hospitalizacion`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `fk_inventario_insumodehospitalizacion1` FOREIGN KEY (`insumodehospitalizacion_id_insumoDeHospitalizacion`) REFERENCES `insumodehospitalizacion` (`id_insumoDeHospitalizacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `id_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `personal_ibfk_1` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidad` (`id_especialidad`),
  ADD CONSTRAINT `personal_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `personal_has_serviciomedico`
--
ALTER TABLE `personal_has_serviciomedico`
  ADD CONSTRAINT `fk_personal_has_serviciomedico_personal1` FOREIGN KEY (`personal_id_personal`) REFERENCES `personal` (`id_personal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_personal_has_serviciomedico_serviciomedico1` FOREIGN KEY (`serviciomedico_id_servicioMedico`) REFERENCES `serviciomedico` (`id_servicioMedico`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `serviciomedico`
--
ALTER TABLE `serviciomedico`
  ADD CONSTRAINT `serviciomedico_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_servicio` (`id_categoria`);

--
-- Filtros para la tabla `serviciomedico_has_factura`
--
ALTER TABLE `serviciomedico_has_factura`
  ADD CONSTRAINT `id_factura` FOREIGN KEY (`factura_id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_servicio` FOREIGN KEY (`serviciomedico_id_servicioMedico`) REFERENCES `serviciomedico` (`id_servicioMedico`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
