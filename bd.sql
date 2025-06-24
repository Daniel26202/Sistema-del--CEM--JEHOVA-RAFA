-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-06-2025 a las 09:57:44
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

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

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `DescontarLotes` (IN `insumo_id` INT, IN `cantidad_requerida` INT)   BEGIN
    DECLARE cantidad_restante INT DEFAULT cantidad_requerida;
    DECLARE lote_id INT;
    DECLARE lote_cantidad INT;

    DECLARE done INT DEFAULT FALSE;
    DECLARE lote_cursor CURSOR FOR
        SELECT ei.id_entradaDeInsumo, ei.cantidad_disponible
        FROM entrada_insumo ei INNER JOIN entrada e 
        ON e.id_entrada = ei.id_entrada
        WHERE ei.id_insumo = insumo_id AND ei.cantidad_disponible > 0
        ORDER BY e.fechaDeIngreso ASC; -- FIFO

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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `devolver_cantidad_insumos` (IN `id_factura` INT)   BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE entrada_id INT; -- Cambié el nombre de la variable para evitar confusiones
    DECLARE cantidad_en_factura  INT;

    -- Cursor para recorrer las entradas de insumos
    DECLARE insumo_cursor CURSOR FOR 
        SELECT id_entradaDeInsumo, cantidad FROM bd.factura_has_inventario WHERE factura_id_factura = id_factura;

    -- Manejo de excepciones para el cursor
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Abrir el cursor
    OPEN insumo_cursor;

    -- Bucle para recorrer las entradas de insumos
    read_loop: LOOP
        FETCH insumo_cursor INTO entrada_id, cantidad_en_factura;

        IF done THEN
            LEAVE read_loop; -- Salir del bucle si no hay más filas
        END IF;
        
        update bd.entrada_insumo set cantidad_disponible = cantidad_disponible + cantidad_en_factura where id_entradaDeInsumo = entrada_id;
    END LOOP;

    -- Cerrar el cursor
    CLOSE insumo_cursor;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_entrada` (IN `id_insumo` INT, IN `id_proveedor` INT, IN `fechaDeIngreso` DATE, IN `fechaDeVecimiento` DATE, IN `precio` FLOAT, IN `cantidad` INT, IN `lote` TEXT)   BEGIN
    declare id_entrada int;
    
    INSERT INTO entrada VALUES (null, id_proveedor, lote, fechaDeIngreso, 'ACT');
    set id_entrada =  last_insert_id();
    
    INSERT INTO entrada_insumo VALUES (null, id_insumo, id_entrada,fechaDeVecimiento,precio, cantidad, cantidad);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_insumo` (IN `imagen` TEXT, IN `nombre` TEXT, IN `id_proveedor` INT, IN `descripcion` TEXT, IN `fechaDeIngreso` DATE, IN `fechaDeVecimiento` DATE, IN `precio` FLOAT, IN `cantidad` INT, IN `stockMinimo` INT, IN `lote` TEXT, IN `marca` TEXT, IN `medida` TEXT)   BEGIN
	declare id_insumo int;
    declare id_entrada int;
    
	INSERT INTO insumo VALUES (null, imagen, nombre, descripcion, marca, medida, precio , 'ACT',stockMinimo);
    set id_insumo = last_insert_id();
    
    INSERT INTO entrada VALUES (null, id_proveedor, lote, fechaDeIngreso, 'ACT');
    set id_entrada =  last_insert_id();
    
    INSERT INTO entrada_insumo VALUES (null, id_insumo, id_entrada,fechaDeVecimiento,precio, cantidad, cantidad);
END$$

DELIMITER ;

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
  `paciente_id_paciente` int(11) NOT NULL,
  `hora_salida` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id_cita`, `fecha`, `hora`, `estado`, `serviciomedico_id_servicioMedico`, `paciente_id_paciente`, `hora_salida`) VALUES
(41, '2025-04-02', '12:33:00', 'ACT', 24, 23, '00:00:00'),
(42, '2025-04-02', '12:33:00', 'ACT', 25, 23, '00:00:00'),
(43, '2025-04-02', '12:33:00', 'ACT', 22, 23, '00:00:00'),
(44, '2025-04-02', '12:33:00', 'ACT', 22, 23, '00:00:00'),
(45, '2025-04-21', '22:00:00', 'Realizadas', 26, 25, '00:00:00'),
(46, '2025-04-25', '12:00:00', 'Pendiente', 27, 25, '00:00:00'),
(47, '2025-05-05', '20:00:00', 'Realizadas', 26, 25, '00:00:00'),
(48, '2025-05-12', '20:00:00', 'Pendiente', 26, 23, '00:00:00'),
(49, '2025-06-02', '20:00:00', 'Pendiente', 24, 25, '21:00:00'),
(50, '2025-06-02', '21:00:00', 'Pendiente', 24, 25, '21:00:00'),
(51, '2025-06-02', '22:00:00', 'Pendiente', 24, 25, '22:05:00'),
(52, '2025-06-02', '22:10:00', 'Pendiente', 24, 25, '23:05:00'),
(53, '2025-06-09', '20:00:00', 'Pendiente', 24, 25, '21:05:00'),
(54, '2025-06-09', '21:11:00', 'Pendiente', 24, 25, '22:05:00'),
(55, '2025-06-16', '20:00:00', 'Pendiente', 24, 34, '21:06:00'),
(56, '2025-06-20', '10:05:00', 'Pendiente', 24, 25, '11:06:00'),
(57, '2025-06-27', '10:00:00', 'Pendiente', 24, 25, '11:06:00'),
(58, '2025-06-27', '11:07:00', 'Pendiente', 24, 25, '12:06:00'),
(59, '2025-06-27', '12:07:00', 'Pendiente', 24, 25, '13:06:00'),
(60, '2025-07-04', '10:00:00', 'Pendiente', 24, 25, '11:06:00'),
(61, '2025-07-04', '11:07:00', 'Pendiente', 24, 25, '12:06:00'),
(62, '2025-07-11', '10:00:00', 'Pendiente', 24, 25, '11:06:00');

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
(26, 23, 1, 'El chico presenta dificultad para respirar, hinchazón en el cuerpo y dolores de cabeza', 'Cetirizina\r\nSalbutamol\r\nAcetaminofén', '2025-04-02 14:37:34', '2025-04-26', 'Debe hacerse hematología completa', 'historia denose', 'ACT'),
(27, 24, 1, 'La paciente presenta severos dolores de cabeza, lo cual da a entender que tiene episodios de jaqueca, a su vez también presenta problemas con la visión y mareos\r\nTomar mucha agua', 'Diclofenac potasico\r\nCafeína\r\nViajesan', '2025-04-02 14:45:09', '2025-04-23', 'Tomar mucha agua', 'historiaclinica', 'ACT'),
(28, 25, 43, 'diagnostico', 'indicaciones', '2025-06-10 10:11:51', '2026-06-24', 'nota', 'historial\r\n\r\n', 'ACT'),
(29, 25, 42, 'jfsdjfsdnfds', 'indicaciones', '2025-06-10 20:07:54', '2026-06-18', 'alguito', 'mhnfdjg algo mas', 'ACT'),
(30, 25, 43, 'diagnostivo', 'indicaciones', '2025-06-19 20:29:30', '2025-07-06', 'nota', 'historial clinico  de algo', 'ACT');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `distribucion_edad_genero`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `distribucion_edad_genero` (
`rango_edad` varchar(5)
,`masculino` decimal(42,0)
,`femenino` decimal(42,0)
,`total` decimal(42,0)
,`total_masculino` bigint(21)
,`total_femenino` bigint(21)
);

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
(57, 6, 1212, '2025-05-08', 'ACT'),
(58, 6, 5664, '2025-05-22', 'ACT'),
(59, 7, 8098, '2025-06-10', 'ACT'),
(61, 7, 5656, '2025-06-20', 'ACT'),
(62, 7, 1234, '2025-06-21', 'ACT'),
(63, 6, 5651, '2025-06-21', 'ACT'),
(64, 7, 2134, '2025-06-21', 'ACT'),
(65, 7, 2134, '2025-06-21', 'ACT'),
(66, 6, 2134, '2025-06-21', 'ACT'),
(67, 7, 3012, '2025-06-21', 'ACT'),
(68, 7, 4532, '2025-06-21', 'ACT'),
(69, 7, 2342, '2025-06-21', 'ACT'),
(70, 7, 1223, '2025-06-21', 'ACT'),
(71, 6, 4564, '2025-06-21', 'ACT');

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
(52, 37, 58, '2025-05-25', 9.00, 89, 85),
(53, 36, 59, '2026-02-11', 79.00, 34, 18),
(54, 41, 62, '2026-06-29', 9.00, 20, 19),
(55, 42, 63, '2025-06-27', 8.00, 12, 12),
(56, 36, 64, '2026-06-21', 12.00, 1, 1),
(57, 36, 65, '2026-06-21', 12.00, 1, 1),
(58, 31, 66, '2026-06-21', 12.00, 1, 0),
(59, 37, 67, '2025-06-29', 13.00, 2, 2),
(60, 31, 68, '2027-06-21', 120.00, 9, 9),
(61, 41, 69, '2025-06-29', 12.00, 5, 5),
(62, 36, 70, '2025-06-29', 12.00, 2, 2),
(63, 36, 71, '2025-06-29', 190.00, 1, 1);

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
(6, 'administrador', 'DES'),
(7, 'Cirugia', 'ACT');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `especialidades_solicitadas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `especialidades_solicitadas` (
`especialidad` varchar(25)
,`fecha` date
,`total_solicitudes` bigint(21)
);

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
(102, '2025-05-07', 1230.00, 'ACT', 25),
(103, '2025-05-22', 1.00, 'ACT', 24),
(104, '2025-06-09', 1000.00, 'ACT', 25),
(105, '2025-06-14', 1000.00, 'ACT', 25),
(106, '2025-06-14', 1000.00, 'ACT', 25),
(107, '2025-06-14', 3000.00, 'ACT', 25),
(108, '2025-06-15', 80.00, 'ACT', 25),
(109, '2025-06-15', 4000.00, 'ACT', 25),
(110, '2025-06-16', 240.00, 'ACT', 25),
(111, '2025-06-16', 240.00, 'ACT', 25),
(112, '2025-06-16', 240.00, 'ACT', 25),
(113, '2025-06-16', 240.00, 'ACT', 25),
(114, '2025-06-16', 80.00, 'ACT', 25),
(115, '2025-06-16', 80.00, 'ACT', 25),
(116, '2025-06-16', 80.00, 'ACT', 25),
(117, '2025-06-16', 9.00, 'ACT', 25),
(118, '2025-06-16', 240.00, 'ACT', 25),
(119, '2025-06-16', 63.00, 'ACT', 25),
(120, '2025-06-16', 36.00, 'ACT', 25),
(121, '2025-06-16', 80.00, 'ACT', 25),
(122, '2025-06-16', 9.00, 'ACT', 25),
(123, '2025-06-16', 240.00, 'ACT', 25),
(124, '2025-06-16', 240.00, 'ACT', 25),
(125, '2025-06-16', 240.00, 'ACT', 25),
(126, '2025-06-16', 240.00, 'ACT', 25),
(127, '2025-06-16', 240.00, 'ACT', 25),
(128, '2025-06-16', 240.00, 'ACT', 25),
(129, '2025-06-16', 240.00, 'ACT', 25),
(130, '2025-06-16', 240.00, 'ACT', 25),
(131, '2025-06-16', 240.00, 'ACT', 25),
(132, '2025-06-16', 240.00, 'ACT', 25),
(133, '2025-06-16', 240.00, 'ACT', 25),
(134, '2025-06-17', 240.00, 'ACT', 25),
(135, '2025-06-17', 240.00, 'ACT', 25),
(136, '2025-06-17', 80.00, 'ACT', 25),
(137, '2025-06-18', 80.00, 'ACT', 25),
(138, '2025-06-18', 80.00, 'ACT', 25),
(139, '2025-06-18', 80.00, 'ACT', 25),
(140, '2025-06-18', 160.00, 'ACT', 25),
(141, '2025-06-18', 36.00, 'ACT', 25),
(142, '2025-06-18', 80.00, 'ACT', 25),
(143, '2025-06-18', 80.00, 'ACT', 25),
(144, '2025-06-18', 116.00, 'ACT', 25),
(145, '2025-06-18', 80.00, 'ACT', 25),
(146, '2025-06-18', 98.00, 'ACT', 25),
(147, '2025-06-19', 560.00, 'ACT', 25),
(148, '2025-06-21', 9.00, 'ACT', 25),
(149, '2025-06-21', 160.00, 'ACT', 25),
(150, '2025-06-22', 1000.00, 'ACT', 25),
(151, '2025-06-22', 240.00, 'Anulada', 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_has_inventario`
--

CREATE TABLE `factura_has_inventario` (
  `factura_id_factura` int(11) NOT NULL,
  `id_entradaDeInsumo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `factura_has_inventario`
--

INSERT INTO `factura_has_inventario` (`factura_id_factura`, `id_entradaDeInsumo`, `cantidad`, `estado`) VALUES
(117, 52, 1, 'ACT'),
(118, 52, 3, 'ACT'),
(119, 52, 3, 'ACT'),
(119, 52, 1, 'ACT'),
(130, 53, 3, 'ACT'),
(132, 53, 3, 'ACT'),
(133, 53, 3, 'ACT'),
(134, 53, 3, 'ACT'),
(135, 53, 3, 'ACT'),
(136, 53, 1, 'ACT'),
(137, 53, 1, 'ACT'),
(138, 53, 1, 'ACT'),
(139, 53, 1, 'ACT'),
(140, 53, 2, 'ACT'),
(143, 53, 1, 'ACT'),
(144, 53, 1, 'ACT'),
(144, 52, 4, 'ACT'),
(146, 53, 1, 'ACT'),
(146, 52, 2, 'ACT'),
(147, 53, 7, 'ACT'),
(148, 54, 1, 'ACT'),
(149, 53, 2, 'ACT'),
(151, 53, 3, 'ACT');

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
(30, 19, 9, '20:00:00', '23:00:00'),
(31, 20, 13, '10:00:00', '13:00:00'),
(32, 21, 9, '10:00:00', '12:00:00'),
(33, 21, 11, '11:00:00', '17:00:00'),
(34, 22, 9, '10:00:00', '13:00:00'),
(35, 22, 10, '14:00:00', '16:00:00'),
(36, 23, 13, '09:00:00', '10:01:00');

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
(13, '2025-04-29 07:32:00', 0, NULL, 1, NULL, 27, '0000-00-00 00:00:00', 'Realizadas'),
(14, '2025-05-23 08:17:49', 0, 0, 0, 0, 26, '0000-00-00 00:00:00', 'Pendiente'),
(15, '2025-06-10 20:20:19', 0, 0, 0, 0, 29, '0000-00-00 00:00:00', 'DES'),
(16, '2025-06-21 19:36:00', 0, 0, 0, 0, 30, '0000-00-00 00:00:00', 'DES'),
(17, '2025-06-21 19:48:25', 0, 0, 0, 0, 30, '0000-00-00 00:00:00', 'DES');

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
(36, '2025-06-21_1750492799_img30.png', 'Ansumo', 'El ibuprofeno e', 'Tecno spar 3022 ', '400 ml', 80.00, 'ACT', 2),
(37, '2025-05-22_1747932563_img16.jpg', 'Spiderman', 'descripcio1', 'Spidermas', '100 g', 9.00, 'ACT', 1),
(39, '2025-06-20_1750445529_4992462.jpg', 'Carlos', 'es un SO ', 'Microsoft', '1 g', 5.00, 'ACT', 1),
(40, '2025-06-21_1750492468_Neon03.jpg', 'Disparador', 'es una descripcion', 'Lenovo', '1 g', 9.00, 'ACT', 5),
(41, '2025-06-21_1750492543_Neon03.jpg', 'Disparador', 'es una descripcion', 'Lenovo', '1 g', 9.00, 'ACT', 5),
(42, '2025-06-21_1750492723_1259289.jpg', 'Card', 'es una descripcion', 'Microsoft', '1 g', 8.00, 'ACT', 5);

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

--
-- Volcado de datos para la tabla `insumodehospitalizacion`
--

INSERT INTO `insumodehospitalizacion` (`id_insumoDeHospitalizacion`, `id_hospitalizacion`, `id_inventario`, `cantidad`) VALUES
(13, 16, 58, 1),
(14, 17, 52, 2);

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
(27, 'V', '158961', 'Aaaa', 'Aaaa', '4121338032', 'Direccion', '2001-09-22', 'Masculino', 'DES'),
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
(87, 'V', '2000060', 'Puerto Rico', 'Apellido_60', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT'),
(88, 'V', '1480973', 'Liam', 'Hendrick', '04128649495', 'En su casa ', '1997-06-28', 'Masculino', 'ACT');

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
(131, 5, 102, '', 1230.00),
(132, 5, 103, '', 1.00),
(133, 5, 104, '', 1000.00),
(134, 5, 105, '', 1000.00),
(135, 5, 106, '', 1000.00),
(136, 5, 107, '', 3000.00),
(137, 5, 108, '', 80.00),
(138, 5, 109, '1257', 3000.00),
(139, 6, 109, '1257', 1000.00),
(140, 5, 110, '', 240.00),
(141, 5, 111, '', 240.00),
(142, 5, 112, '', 240.00),
(143, 5, 113, '', 240.00),
(144, 5, 114, '', 80.00),
(145, 5, 115, '', 80.00),
(146, 5, 116, '', 80.00),
(147, 5, 117, '', 9.00),
(148, 5, 118, '', 240.00),
(149, 5, 119, '', 63.00),
(150, 5, 120, '', 36.00),
(151, 5, 121, '', 80.00),
(152, 5, 122, '', 9.00),
(153, 5, 123, '', 240.00),
(154, 5, 124, '', 240.00),
(155, 5, 125, '', 240.00),
(156, 5, 126, '', 240.00),
(157, 5, 127, '', 240.00),
(158, 5, 128, '', 240.00),
(159, 5, 129, '', 240.00),
(160, 5, 130, '', 240.00),
(161, 5, 131, '', 240.00),
(162, 5, 132, '', 240.00),
(163, 5, 133, '', 240.00),
(164, 5, 134, '', 240.00),
(165, 5, 135, '', 240.00),
(166, 5, 136, '', 80.00),
(167, 5, 137, '', 80.00),
(168, 5, 138, '', 80.00),
(169, 5, 139, '', 80.00),
(170, 5, 140, '', 160.00),
(171, 5, 141, '', 36.00),
(172, 5, 142, '', 80.00),
(173, 5, 143, '', 80.00),
(174, 5, 144, '', 116.00),
(175, 5, 145, '', 80.00),
(176, 5, 146, '', 98.00),
(177, 5, 147, '', 560.00),
(178, 5, 148, '', 9.00),
(179, 5, 149, '', 160.00),
(180, 5, 150, '', 1000.00),
(181, 5, 151, '', 240.00);

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
(2, 'DIABETES TIPO 1', 'DES'),
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
(221, 35, 9, '2025-05-15 19:45:12'),
(222, 25, 6, '2025-06-10 10:11:51'),
(223, 25, 8, '2025-06-10 10:11:51'),
(224, 25, 5, '2025-06-10 20:07:54'),
(225, 25, 6, '2025-06-10 20:07:54'),
(226, 25, 7, '2025-06-10 20:07:54'),
(227, 25, 8, '2025-06-10 20:07:54'),
(228, 25, 9, '2025-06-10 20:07:54'),
(229, 25, 5, '2025-06-19 20:29:30'),
(230, 25, 6, '2025-06-19 20:29:30'),
(231, 25, 7, '2025-06-19 20:29:30'),
(232, 25, 8, '2025-06-19 20:29:30'),
(233, 25, 9, '2025-06-19 20:29:30'),
(234, 25, 186, '2025-06-19 20:29:30'),
(235, 25, 190, '2025-06-19 20:29:30'),
(236, 25, 192, '2025-06-19 20:29:30');

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
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`id_personal`, `nacionalidad`, `cedula`, `nombre`, `apellido`, `telefono`, `tipodecategoria`, `id_especialidad`, `usuario`) VALUES
(18, 'V', '30554053', 'Wilmer', 'Baez', '04145378699', 'Administrador', NULL, 1),
(19, 'V', '1232233', 'David', 'Carlos', '04142323233', '', 7, 42),
(20, 'V', '12123343', 'Carlos', 'Garcia', '04244546565', '', 7, 43),
(21, 'V', '12020333', 'Ana', 'Bracho', '04122323422', '', 6, 45),
(22, 'V', '6755654', 'Julian', 'Valdez', '04122323212', '', 4, 46),
(23, 'V', '867548', 'Jaun', 'Edlkfjfdsk', '04243943432', '', 5, 49),
(24, 'V', '1223211', 'Auto', 'Auto', '04122232323', 'Administrador', NULL, 50);

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
(19, 24),
(19, 26),
(19, 29),
(19, 30),
(19, 32),
(19, 33),
(19, 36),
(20, 24),
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
(26, 97),
(25, 104),
(25, 105),
(25, 106),
(24, 107),
(24, 109),
(25, 109),
(25, 150);

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
(5, 'Disnea', 'DES'),
(6, 'Fiebre', 'ACT'),
(7, 'Vomito', 'DES'),
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
(42, 7, 27),
(43, 5, 28),
(44, 6, 28),
(45, 7, 28),
(46, 5, 29),
(47, 6, 29),
(48, 8, 29),
(49, 5, 30),
(50, 6, 30);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `tasa_morbilidad`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `tasa_morbilidad` (
`nombre_patologia` varchar(25)
,`casos` bigint(21)
,`tasa_por_1000` decimal(27,2)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `distribucion_edad_genero`
--
DROP TABLE IF EXISTS `distribucion_edad_genero`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `distribucion_edad_genero`  AS SELECT `sub`.`rango_edad` AS `rango_edad`, sum(case when `sub`.`genero` = 'masculino' then `sub`.`cantidad` else 0 end) AS `masculino`, sum(case when `sub`.`genero` = 'femenino' then `sub`.`cantidad` else 0 end) AS `femenino`, sum(`sub`.`cantidad`) AS `total`, (select count(0) from `paciente` where `paciente`.`genero` = 'masculino') AS `total_masculino`, (select count(0) from `paciente` where `paciente`.`genero` = 'femenino') AS `total_femenino` FROM (select case when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 0 and 12 then '0-12' when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 13 and 19 then '13-19' when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 20 and 35 then '20-35' when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 36 and 50 then '36-50' when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 51 and 65 then '51-65' else '66+' end AS `rango_edad`,`paciente`.`genero` AS `genero`,count(0) AS `cantidad` from `paciente` group by case when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 0 and 12 then '0-12' when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 13 and 19 then '13-19' when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 20 and 35 then '20-35' when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 36 and 50 then '36-50' when timestampdiff(YEAR,`paciente`.`fn`,curdate()) between 51 and 65 then '51-65' else '66+' end,`paciente`.`genero`) AS `sub` GROUP BY `sub`.`rango_edad` ORDER BY `sub`.`rango_edad` ASC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `especialidades_solicitadas`
--
DROP TABLE IF EXISTS `especialidades_solicitadas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `especialidades_solicitadas`  AS SELECT `cs`.`nombre` AS `especialidad`, `c`.`fecha` AS `fecha`, count(`c`.`id_cita`) AS `total_solicitudes` FROM ((`cita` `c` join `serviciomedico` `sm` on(`c`.`serviciomedico_id_servicioMedico` = `sm`.`id_servicioMedico`)) join `categoria_servicio` `cs` on(`sm`.`id_categoria` = `cs`.`id_categoria`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `tasa_morbilidad`
--
DROP TABLE IF EXISTS `tasa_morbilidad`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tasa_morbilidad`  AS SELECT `p`.`nombre_patologia` AS `nombre_patologia`, count(distinct `pp`.`id_paciente`) AS `casos`, round(count(distinct `pp`.`id_paciente`) / (select count(0) from `paciente`) * 1000,2) AS `tasa_por_1000` FROM (`patologiadepaciente` `pp` join `patologia` `p` on(`pp`.`id_patologia` = `p`.`id_patologia`)) GROUP BY `pp`.`id_patologia` ORDER BY count(distinct `pp`.`id_paciente`) DESC ;

--
-- Índices para tablas volcadas
--

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
  ADD KEY `fk_factura_has_inventario_factura1_idx` (`factura_id_factura`),
  ADD KEY `id_entradaDeInsumo` (`id_entradaDeInsumo`);

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
  ADD KEY `id_especialidad` (`id_especialidad`);

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria_servicio`
--
ALTER TABLE `categoria_servicio`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `control`
--
ALTER TABLE `control`
  MODIFY `id_control` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `entrada`
--
ALTER TABLE `entrada`
  MODIFY `id_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `entrada_insumo`
--
ALTER TABLE `entrada_insumo`
  MODIFY `id_entradaDeInsumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `id_especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `horarioydoctor`
--
ALTER TABLE `horarioydoctor`
  MODIFY `id_horarioydoctor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `hospitalizacion`
--
ALTER TABLE `hospitalizacion`
  MODIFY `id_hospitalizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `insumo`
--
ALTER TABLE `insumo`
  MODIFY `id_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `insumodehospitalizacion`
--
ALTER TABLE `insumodehospitalizacion`
  MODIFY `id_insumoDeHospitalizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pagodefactura`
--
ALTER TABLE `pagodefactura`
  MODIFY `id_pagoDeFactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT de la tabla `patologia`
--
ALTER TABLE `patologia`
  MODIFY `id_patologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT de la tabla `patologiadepaciente`
--
ALTER TABLE `patologiadepaciente`
  MODIFY `id_patologiaDePaciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id_personal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id_sintomas_control` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Restricciones para tablas volcadas
--

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
  ADD CONSTRAINT `control_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`);

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
  ADD CONSTRAINT `factura_has_inventario_ibfk_2` FOREIGN KEY (`factura_id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_has_inventario_ibfk_3` FOREIGN KEY (`id_entradaDeInsumo`) REFERENCES `entrada_insumo` (`id_entradaDeInsumo`);

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
  ADD CONSTRAINT `insumodehospitalizacion_ibfk_2` FOREIGN KEY (`id_inventario`) REFERENCES `entrada_insumo` (`id_entradaDeInsumo`);

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
-- Filtros para la tabla `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `personal_ibfk_1` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidad` (`id_especialidad`) ON DELETE CASCADE ON UPDATE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
