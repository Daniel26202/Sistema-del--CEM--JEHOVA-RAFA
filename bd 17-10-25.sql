-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-10-2025 a las 00:09:24
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




END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `devolever_insumos_hospitalizacion` (IN `id_hospitalizacion` INT)   BEGIN
	 DECLARE done INT DEFAULT FALSE;
    DECLARE entrada_id INT;
    DECLARE cantidad_en_hospitalizacion INT;

    -- Cursor para recorrer las entradas de insumos
    DECLARE insumo_cursor CURSOR FOR 
        SELECT id_inventario, cantidad FROM bd.insumodehospitalizacion WHERE id_hospitalizacion = id_hospitalizacion;

    -- Manejo de excepciones para el cursor
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Abrir el cursor
    OPEN insumo_cursor;

    -- Bucle para recorrer las entradas de insumos
    read_loop: LOOP
        FETCH insumo_cursor INTO entrada_id, cantidad_en_hospitalizacion;

        IF done THEN
            LEAVE read_loop; -- Salir del bucle si no hay más filas
        END IF;

        -- Actualizar la cantidad disponible en la tabla de entrada de insumos
        UPDATE bd.entrada_insumo SET cantidad_disponible = cantidad_disponible + cantidad_en_hospitalizacion WHERE id_entradaDeInsumo = entrada_id;
    END LOOP;

    -- Cerrar el cursor
    CLOSE insumo_cursor;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `devolver_cantidad_insumos` (IN `id_factura` INT)   BEGIN




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




END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_entrada` (IN `id_insumo` INT, IN `id_proveedor` INT, IN `fechaDeIngreso` DATE, IN `fechaDeVecimiento` DATE, IN `precio` FLOAT, IN `cantidad` INT, IN `lote` TEXT)   BEGIN




    declare id_entrada int;




    




    INSERT INTO entrada VALUES (null, id_proveedor, lote, fechaDeIngreso, 'ACT');




    set id_entrada =  last_insert_id();




    




    INSERT INTO entrada_insumo VALUES (null, id_insumo, id_entrada,fechaDeVecimiento,precio, cantidad, cantidad);




END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_insumo` (IN `imagen` TEXT, IN `nombre` TEXT, IN `id_proveedor` INT, IN `descripcion` TEXT, IN `fechaDeIngreso` DATE, IN `fechaDeVecimiento` DATE, IN `precio` FLOAT, IN `cantidad` INT, IN `stockMinimo` INT, IN `lote` TEXT, IN `marca` TEXT, IN `medida` TEXT, IN `iva` BOOLEAN)   BEGIN




	declare id_insumo int;




    declare id_entrada int;




    




	INSERT INTO insumo VALUES (null, imagen, nombre, descripcion, marca, medida, precio , 'ACT',stockMinimo, iva);




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
(104, 'Odontología', 'ACT'),
(105, 'Hello', 'ACT'),
(106, 'Categorizacion', 'DES');

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
  `hora_salida` time NOT NULL,
  `doctor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id_cita`, `fecha`, `hora`, `estado`, `serviciomedico_id_servicioMedico`, `paciente_id_paciente`, `hora_salida`, `doctor`) VALUES
(41, '2025-04-02', '12:33:00', 'ACT', 24, 23, '00:00:00', 0),
(42, '2025-04-02', '12:33:00', 'ACT', 25, 23, '00:00:00', 0),
(43, '2025-04-02', '12:33:00', 'ACT', 22, 23, '00:00:00', 0),
(44, '2025-04-02', '12:33:00', 'ACT', 22, 23, '00:00:00', 0),
(45, '2025-04-21', '22:00:00', 'Realizadas', 26, 25, '00:00:00', 0),
(46, '2025-04-25', '12:00:00', 'Pendiente', 27, 25, '00:00:00', 0),
(47, '2025-05-05', '20:00:00', 'Realizadas', 26, 25, '00:00:00', 0),
(48, '2025-05-12', '20:00:00', 'Pendiente', 26, 23, '00:00:00', 0),
(49, '2025-06-02', '20:00:00', 'Pendiente', 24, 25, '21:00:00', 0),
(50, '2025-06-02', '21:00:00', 'Pendiente', 24, 25, '21:00:00', 0),
(51, '2025-06-02', '22:00:00', 'Pendiente', 24, 25, '22:05:00', 0),
(52, '2025-06-02', '22:10:00', 'Pendiente', 24, 25, '23:05:00', 0),
(53, '2025-06-09', '20:00:00', 'Pendiente', 24, 25, '21:05:00', 0),
(54, '2025-06-09', '21:11:00', 'Pendiente', 24, 25, '22:05:00', 0),
(55, '2025-06-16', '20:00:00', 'Pendiente', 24, 34, '21:06:00', 0),
(56, '2025-06-20', '10:05:00', 'Pendiente', 24, 25, '11:06:00', 0),
(57, '2025-06-27', '10:00:00', 'Pendiente', 24, 25, '11:06:00', 0),
(58, '2025-06-27', '11:07:00', 'Pendiente', 24, 25, '12:06:00', 0),
(59, '2025-06-27', '12:07:00', 'Pendiente', 24, 25, '13:06:00', 0),
(60, '2025-07-04', '10:00:00', 'Pendiente', 24, 25, '11:06:00', 0),
(61, '2025-07-04', '11:07:00', 'Pendiente', 24, 25, '12:06:00', 0),
(62, '2025-07-11', '10:00:00', 'Pendiente', 24, 25, '11:06:00', 0),
(63, '2025-07-28', '20:00:00', 'Pendiente', 24, 25, '21:06:00', 19),
(64, '2025-07-25', '10:00:00', 'Pendiente', 24, 25, '11:06:00', 20),
(65, '2025-09-29', '20:00:00', 'Pendiente', 24, 25, '21:09:00', 19),
(66, '2025-10-20', '20:00:00', 'DES', 24, 25, '21:10:00', 19),
(67, '2025-10-24', '10:01:00', 'Pendiente', 24, 25, '11:10:00', 20),
(68, '2025-10-06', '20:00:00', 'Pendiente', 24, 25, '21:10:00', 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
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
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nacionalidad`, `cedula`, `nombre`, `apellido`, `telefono`, `direccion`, `fn`, `genero`, `estado`) VALUES
(1, 'V', '12098234', 'Jose', 'Lara', '04123213212', 'esuna direccion', '2005-10-02', 'Masculino', 'ACT');

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
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `severidad` enum('LEVE','MODERADA','GRAVE') DEFAULT 'LEVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `control`
--

INSERT INTO `control` (`id_control`, `id_paciente`, `id_usuario`, `diagnostico`, `medicamentosRecetados`, `fecha_control`, `fechaRegreso`, `nota`, `historiaclinica`, `estado`, `severidad`) VALUES
(26, 23, 1, 'El chico presenta dificultad para respirar, hinchazón en el cuerpo y dolores de cabeza', 'Cetirizina\r\nSalbutamol\r\nAcetaminofén', '2025-04-02 14:37:34', '2025-04-26', 'Debe hacerse hematología completa', '2wd', 'ACT', 'LEVE'),
(27, 24, 1, 'La paciente presenta severos dolores de cabeza, lo cual da a entender que tiene episodios de jaqueca, a su vez también presenta problemas con la visión y mareos\r\nTomar mucha agua', 'Diclofenac potasicoCafeínaViajesan', '2025-04-02 14:45:09', '2025-04-23', 'Tomar mucha agua', 'Historia bbb', 'ACT', 'LEVE'),
(28, 25, 43, 'diagnostico', 'indicaciones', '2025-06-10 10:11:51', '2026-06-24', 'nota', 'historial\r\n\r\n', 'ACT', 'LEVE'),
(29, 25, 42, 'jfsdjfsdnfds', 'indicaciones', '2025-06-10 20:07:54', '2026-06-18', 'alguito', 'mhnfdjg algo mas', 'ACT', 'LEVE'),
(30, 25, 43, 'diagnostivo', 'indicaciones', '2025-06-19 20:29:30', '2025-07-06', 'nota', 'historial clinico  de algo no se', 'ACT', 'LEVE'),
(31, 89, 42, 'este enfermedad crónica', 'es una indicacion', '2025-06-27 19:24:28', '2025-06-29', 'es una nota', 'este en un historial', 'ACT', 'LEVE'),
(32, 25, 43, 'dgdgdgff', 'gdfgd', '2025-09-25 20:24:37', '2025-10-12', 'fghfh', 'sddsds', 'ACT', 'LEVE'),
(33, 25, 1, 'diagnostico', 'indicaciones', '2025-10-03 11:23:02', '2025-11-01', 'nota', 'historial', 'ACT', 'LEVE'),
(34, 25, 1, 'diagnostico', 'indicaciones', '2025-10-03 11:23:41', '2025-11-01', 'nota editada', 'historial', 'ACT', 'LEVE');

--
-- Disparadores `control`
--
DELIMITER $$
CREATE TRIGGER `SALUDABLE` AFTER INSERT ON `control` FOR EACH ROW IF NEW.diagnostico LIKE '%alta médica%' THEN




    UPDATE paciente SET estado_salud = 'SALUDABLE'




    WHERE id_paciente = NEW.id_paciente;




END IF
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_control_insert` AFTER INSERT ON `control` FOR EACH ROW BEGIN




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




END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `id_datelle_factura` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `tipo` varchar(35) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` float(12,2) NOT NULL,
  `subtotal` float(12,2) NOT NULL,
  `hospitalizacion_id_hospitalizacion` int(11) DEFAULT NULL,
  `serviciomedico_id_servicioMedico` int(11) DEFAULT NULL,
  `entrada_insumo_id_entradaDeInsumo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_hospitalizacion`
--

CREATE TABLE `detalle_hospitalizacion` (
  `id_detalle` int(11) NOT NULL,
  `id_hospitalizacion` int(11) NOT NULL,
  `id_servicioMedico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(66, 6, 2134, '2025-06-21', 'DES'),
(67, 7, 3012, '2025-06-21', 'ACT'),
(68, 7, 4532, '2025-06-21', 'ACT'),
(69, 7, 2342, '2025-06-21', 'ACT'),
(70, 7, 1223, '2025-06-21', 'ACT'),
(71, 6, 4564, '2025-06-21', 'ACT'),
(72, 7, 5656, '2025-06-29', 'ACT'),
(73, 7, 5656, '2025-06-29', 'ACT'),
(74, 6, 123456789, '2025-01-01', 'ACT'),
(75, 6, 123456789, '2025-10-03', 'ACT'),
(76, 6, 12345679, '2025-10-03', 'DES'),
(77, 7, 8099, '2025-10-09', 'DES');

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
(52, 37, 58, '2025-05-25', 9.00, 89, 68),
(53, 36, 59, '2026-02-11', 750000.00, 34, 8),
(54, 41, 62, '2026-06-29', 9.00, 20, 16),
(55, 42, 63, '2025-06-27', 8.00, 12, 12),
(56, 36, 64, '2026-06-21', 12.00, 1, 1),
(57, 36, 65, '2026-06-21', 12.00, 1, 1),
(58, 31, 66, '2026-06-21', 12.00, 1, 0),
(59, 37, 67, '2025-06-29', 13.00, 2, 2),
(60, 31, 68, '2027-06-21', 120.00, 9, 0),
(61, 41, 69, '2025-06-29', 12.00, 5, 5),
(62, 36, 70, '2025-06-29', 12.00, 2, 2),
(63, 36, 71, '2025-06-29', 190.00, 1, 1),
(64, 43, 72, '2026-07-06', 8.00, 12, 10),
(65, 44, 73, '2027-06-30', 2.80, 12, 12),
(66, 45, 74, '2025-12-31', 100.00, 50, 50),
(67, 44, 75, '2025-12-29', 100.00, 1, 1),
(68, 44, 76, '2025-12-31', 100.00, 1, 1),
(69, 36, 77, '2026-02-11', 7900.00, 34, 34);

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
(7, 'Cirugia', 'ACT'),
(8, 'Especialidad', 'DES');

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
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_factura`, `fecha`, `total`, `estado`, `id_cliente`) VALUES
(109, '2025-06-15', 4000.00, 'ACT', 1),
(110, '2025-06-16', 240.00, 'ACT', 1),
(111, '2025-06-16', 240.00, 'ACT', 1),
(112, '2025-06-16', 240.00, 'ACT', 1),
(113, '2025-06-16', 240.00, 'ACT', 1),
(114, '2025-06-16', 80.00, 'ACT', 1),
(115, '2025-06-16', 80.00, 'ACT', 1),
(116, '2025-06-16', 80.00, 'ACT', 1),
(117, '2025-06-16', 9.00, 'ACT', 1),
(118, '2025-06-16', 240.00, 'ACT', 1),
(119, '2025-06-16', 63.00, 'ACT', 1),
(120, '2025-06-16', 36.00, 'ACT', 1),
(121, '2025-06-16', 80.00, 'ACT', 1),
(122, '2025-06-16', 9.00, 'ACT', 1),
(123, '2025-06-16', 240.00, 'ACT', 1),
(124, '2025-06-16', 240.00, 'ACT', 1),
(125, '2025-06-16', 240.00, 'ACT', 1),
(126, '2025-06-16', 240.00, 'ACT', 1),
(127, '2025-06-16', 240.00, 'ACT', 1),
(128, '2025-06-16', 240.00, 'ACT', 1),
(129, '2025-06-16', 240.00, 'ACT', 1),
(130, '2025-06-16', 240.00, 'ACT', 1),
(131, '2025-06-16', 240.00, 'ACT', 1),
(132, '2025-06-16', 240.00, 'ACT', 1),
(133, '2025-06-16', 240.00, 'ACT', 1),
(134, '2025-06-17', 240.00, 'ACT', 1),
(135, '2025-06-17', 240.00, 'ACT', 1),
(136, '2025-06-17', 80.00, 'ACT', 1),
(137, '2025-06-18', 80.00, 'ACT', 1),
(138, '2025-06-18', 80.00, 'ACT', 1),
(139, '2025-06-18', 80.00, 'ACT', 1),
(140, '2025-06-18', 160.00, 'ACT', 1),
(141, '2025-06-18', 36.00, 'ACT', 1),
(142, '2025-06-18', 80.00, 'ACT', 1),
(143, '2025-06-18', 80.00, 'ACT', 1),
(144, '2025-06-18', 116.00, 'ACT', 1),
(145, '2025-06-18', 80.00, 'ACT', 1),
(146, '2025-06-18', 98.00, 'ACT', 1),
(147, '2025-06-19', 560.00, 'ACT', 1),
(148, '2025-06-21', 9.00, 'ACT', 1),
(149, '2025-06-21', 160.00, 'ACT', 1),
(150, '2025-06-22', 1000.00, 'ACT', 1),
(151, '2025-06-22', 240.00, 'Anulada', 1),
(152, '2025-06-24', 29.56, 'ACT', 1),
(153, '2025-06-27', 9.00, 'ACT', 1),
(154, '2025-06-28', 29.56, 'Anulada', 1),
(155, '2025-06-28', 1080.00, 'ACT', 1),
(156, '2025-06-28', 29.56, 'ACT', 1),
(157, '2025-06-29', 478692.00, 'ACT', 1),
(158, '2025-06-29', 123.00, 'ACT', 1),
(159, '2025-06-29', 1.88, 'ACT', 1),
(160, '2025-06-29', 17.00, 'ACT', 1),
(161, '2025-06-30', 3000.00, 'ACT', 1),
(162, '2025-06-30', 6000.00, 'ACT', 1),
(163, '2025-06-30', 6000.00, 'ACT', 1),
(164, '2025-06-30', 6000.00, 'ACT', 1),
(165, '2025-06-30', 6000.00, 'ACT', 1),
(166, '2025-06-30', 6000.00, 'ACT', 1),
(167, '2025-06-30', 6000.00, 'ACT', 1),
(168, '2025-06-30', 6000.00, 'ACT', 1),
(169, '2025-06-30', 6000.00, 'ACT', 1),
(170, '2025-06-30', 6000.00, 'ACT', 1),
(171, '2025-06-30', 6000.00, 'ACT', 1),
(172, '2025-06-30', 6000.00, 'ACT', 1),
(173, '2025-06-30', 51.89, 'ACT', 1),
(174, '2025-09-14', 570.33, 'ACT', 1),
(175, '2025-09-25', 29.56, 'Anulada', 1),
(176, '2025-09-26', 160.00, 'ACT', 1),
(177, '2025-09-26', 1018.00, 'ACT', 1),
(178, '2025-09-26', 29.56, 'ACT', 1),
(179, '2025-09-27', 1000.00, 'ACT', 1),
(180, '2025-10-02', 1000.00, 'ACT', 1),
(181, '2025-10-02', 1000.00, 'ACT', 1),
(182, '2025-10-02', 1080.00, 'ACT', 1),
(183, '2025-10-13', 246.12, 'ACT', 1),
(184, '2025-10-13', 1000.00, 'ACT', 1);

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
(36, 23, 13, '09:00:00', '10:01:00'),
(41, 29, 10, '00:00:02', '10:00:00');

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
  `id_paciente` int(11) NOT NULL,
  `fecha_hora_final` datetime DEFAULT NULL,
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `hospitalizacion`
--

INSERT INTO `hospitalizacion` (`id_hospitalizacion`, `fecha_hora_inicio`, `precio_horas`, `precio_horas_MoEx`, `total`, `total_MoEx`, `id_paciente`, `fecha_hora_final`, `estado`) VALUES
(11, '2025-04-28 18:37:52', 0, NULL, 0, NULL, 25, '0000-00-00 00:00:00', 'DES'),
(12, '2025-04-28 18:42:13', 0, NULL, 0, NULL, 25, '0000-00-00 00:00:00', 'DES'),
(13, '2025-04-29 07:32:00', 0, NULL, 1, NULL, 25, '0000-00-00 00:00:00', 'Realizadas'),
(14, '2025-05-23 08:17:49', 478692, 4447.81, 478692, 4447.81, 25, '2025-06-29 03:51:35', 'Realizada'),
(15, '2025-06-10 20:20:19', 0, 0, 0, 0, 25, '0000-00-00 00:00:00', 'DES'),
(16, '2025-06-21 19:36:00', 0, 0, 0, 0, 25, '0000-00-00 00:00:00', 'DES'),
(17, '2025-06-21 19:48:25', 0, 0, 0, 0, 25, '0000-00-00 00:00:00', 'DES'),
(18, '2025-06-29 19:26:13', 0, 0, 123, 0, 25, '2025-06-29 14:02:01', 'Realizada'),
(19, '2025-06-29 20:11:25', 1.88073, 0.017475, 1.88073, 0.017475, 25, '2025-06-29 14:11:37', 'Realizada'),
(20, '2025-06-30 15:14:39', 42.89, 0.4, 51.89, 0.48, 25, '2025-06-30 16:31:51', 'Realizada'),
(21, '2025-09-04 16:04:35', 0, 0, 0, 0, 25, '0000-00-00 00:00:00', 'DES'),
(22, '2025-09-06 13:26:28', 0, 0, 0, 0, 25, '0000-00-00 00:00:00', 'DES'),
(23, '0000-00-00 00:00:00', 0, 0, 0, 0, 25, '0000-00-00 00:00:00', 'DES'),
(24, '2025-09-12 11:22:59', 540.77, 3.56, 570.33, 3.75, 25, '2025-09-14 14:36:51', 'Realizada'),
(25, '2025-09-14 14:37:52', 0, 0, 0, 0, 25, '0000-00-00 00:00:00', 'DES'),
(26, '2025-09-15 20:17:53', 0, 0, 0, 0, 25, '0000-00-00 00:00:00', 'DES'),
(27, '2025-09-24 19:58:31', 474844, 2407.37, 474874, 2407.52, 25, '2025-10-14 21:26:57', 'Pendiente');

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
  `stockMinimo` int(11) NOT NULL,
  `iva` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `insumo`
--

INSERT INTO `insumo` (`id_insumo`, `imagen`, `nombre`, `descripcion`, `marca`, `medida`, `precio`, `estado`, `stockMinimo`, `iva`) VALUES
(24, '', 'Paracetamol', 'El paracetamol, también conocido como acetaminofén o acetaminofeno, es un fármaco con propiedades analgésicas y antipiréticas utilizado principalmente para tratar la fiebre y el dolor leve y moderado', '', '', 10.33, 'DES', 0, 0),
(25, '', 'Ibuprofeno', 'El ibuprofeno es un antinflamatorio no esteroideo (AINE) que pertenece al subgrupo de fármacos derivados del ácido propiónico.', '', '', 17.90, 'DES', 0, 0),
(29, '2025-04-29_1745911425_WhatsApp Image 2025-04-03 at 11.51.47 PM.jpeg', 'Ibuprofeno', 'descripción', '', '', 2.10, 'DES', 0, 0),
(30, '2025-05-02_1746200226_9amALQfcTkJsr2zlMRcpi99AnctFZBjlnRxibrip.jpg', 'Ibuprofeno', 'descripción', '', '', 2.10, 'DES', 0, 0),
(31, '2025-05-02_1746216592_img27.jpg', 'Insumo', 'Es un antinflamatorio son derivados del ácido propiónico.', 'Tecno spar 30212 ', '400 ml', 29.56, 'ACT', 1, 0),
(32, '2025-05-05_1746489843_img23.jpg', 'Lobo', 'Es un lobo malvado', 'Tecno spar 30212 ', '400 ml', 0.60, 'DES', 1, 0),
(33, '2025-05-07_1746668110_img16.jpg', 'Spidermas', 'Es un antinflamatorio son derivados del ácido propiónico.', 'Tecno spar 30212 ', '600 ml', 123.00, 'ACT', 1, 0),
(34, '2025-05-08_1746714309_img5.jpg', 'Caballero', 'El ibuprofeno es un antinflamaupo de fármacos derivados del ácido propiónico.', 'Tecno spar 30212', '600 ml', 2040.00, 'DES', 1, 0),
(35, '2025-05-08_1746715177_img29.jpg', 'Insumodolar', 'Es un antinflamatorio son derivados del ácido propiónico.', 'Tecno spar 30212 ', '200 ml', 870.00, 'DES', 5, 0),
(36, '2025-06-21_1750492799_img30.png', 'Ansumo', 'El ibuprofeno e', 'Tecno spar 3022 ', '400 ml', 80.00, 'ACT', 2, 0),
(37, '2025-09-15_1757981940_darsox-anime-1.jpg', 'Spiderman', 'descripcio1', 'Spidermas', '100 g', 9.00, 'ACT', 1, 0),
(39, '2025-06-20_1750445529_4992462.jpg', 'Carlos', 'es un SO ', 'Microsoft', '1 g', 5.00, 'ACT', 1, 0),
(40, '2025-06-21_1750492468_Neon03.jpg', 'Disparador', 'es una descripcion', 'Lenovo', '1 g', 9.00, 'ACT', 5, 0),
(41, '2025-06-21_1750492543_Neon03.jpg', 'Disparador', 'es una descripcion', 'Lenovo', '1 g', 9.00, 'ACT', 5, 0),
(42, '2025-06-21_1750492723_1259289.jpg', 'Card', 'es una descripcion', 'Microsoft', '1 g', 8.00, 'DES', 5, 0),
(43, '2025-06-29_1751222978_img5.jpg', 'Julio', 'es un SO ', 'Microsoft', '1 g', 8.00, 'ACT', 1, 1),
(44, '2025-09-15_1757981960_descargar2.jpg', 'Preuva', 'es un SO ', 'Microsoft', '1 g', 2.80, 'ACT', 3, 1),
(45, '2025-10-03_1759535262_Big Sur Ligh.jpg', 'Insumophpinit', 'descripcion prueba editando', 'MarcaX', '100 g', 100.00, 'DES', 10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumodehospitalizacion`
--

CREATE TABLE `insumodehospitalizacion` (
  `id_insumoDeHospitalizacion` int(11) NOT NULL,
  `id_hospitalizacion` int(11) NOT NULL,
  `id_entradaDeInsumo` int(11) NOT NULL,
  `cantidad` int(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `insumodehospitalizacion`
--

INSERT INTO `insumodehospitalizacion` (`id_insumoDeHospitalizacion`, `id_hospitalizacion`, `id_entradaDeInsumo`, `cantidad`) VALUES
(13, 16, 58, 1),
(14, 17, 52, 2),
(15, 18, 60, 1),
(16, 20, 54, 1),
(17, 21, 64, 1),
(18, 21, 52, 5),
(19, 22, 52, 6),
(20, 22, 61, 1),
(22, 23, 58, 23),
(26, 24, 60, 1),
(27, 25, 60, 2),
(28, 26, 53, 1),
(29, 27, 60, 1);

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
  `estado` varchar(5) NOT NULL,
  `estado_salud` enum('SALUDABLE','ENFERMO','CRONICO') DEFAULT 'SALUDABLE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`id_paciente`, `nacionalidad`, `cedula`, `nombre`, `apellido`, `telefono`, `direccion`, `fn`, `genero`, `estado`, `estado_salud`) VALUES
(23, 'V', '28150004', 'Juan', 'Silva', '04121338031', 'Calle 10 entre 3 y 7', '2001-09-22', 'masculino', 'ACT', 'SALUDABLE'),
(24, 'V', '28329224', 'Rocio', 'Rodriguez', '04121338031', 'URB EL BOSQUE CALLE 12', '2025-04-02', 'femenino', 'ACT', 'SALUDABLE'),
(25, 'V', '30554144', 'Carlos', 'Hernadéz', '04121232343', 'Eb su casa', '2012-02-11', 'masculino', 'ACT', 'ENFERMO'),
(26, 'V', '17664525', 'Sofia', 'Sofia', '4121338031', 'Direccion', '2001-09-22', '', 'ACT', 'SALUDABLE'),
(27, 'V', '158961', 'Aaaa', 'Aaaa', '4121338032', 'Direccion', '2001-09-22', 'Masculino', 'DES', 'SALUDABLE'),
(28, 'V', '2000001', 'Argentina', 'Apellido_1', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(29, 'V', '2000002', 'Editado', 'Modificado', '04123454320', 'en su casa', '2002-02-20', 'Masculino', 'ACT', 'SALUDABLE'),
(30, 'V', '2000003', 'Chile', 'Apellido_3', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(31, 'V', '2000004', 'Colombia', 'Apellido_4', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(32, 'V', '2000005', 'México', 'Apellido_5', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(33, 'V', '2000006', 'Perú', 'Apellido_6', '04121338031', 'Dirección genérica', '2024-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(34, 'V', '2000007', 'Uruguay', 'Apellido_7', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(35, 'V', '2000008', 'Venezuela', 'Apellido_8', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(36, 'V', '2000009', 'Ecuador', 'Apellido_9', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(37, 'V', '2000010', 'Bolivia', 'Apellido_10', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(38, 'V', '2000011', 'Paraguay', 'Apellido_11', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(39, 'V', '2000012', 'Panamá', 'Apellido_12', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(40, 'V', '2000013', 'Costa Rica', 'Apellido_13', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(41, 'V', '2000014', 'Guatemala', 'Apellido_14', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(42, 'V', '2000015', 'El Salvador', 'Apellido_15', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(43, 'V', '2000016', 'Honduras', 'Apellido_16', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(44, 'V', '2000017', 'Nicaragua', 'Apellido_17', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(45, 'V', '2000018', 'Cuba', 'Apellido_18', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(46, 'V', '2000019', 'República Dominicana', 'Apellido_19', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(47, 'V', '2000020', 'Puerto Rico', 'Apellido_20', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(48, 'V', '2000021', 'Canadá', 'Apellido_21', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(49, 'V', '2000022', 'España', 'Apellido_22', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(50, 'V', '2000023', 'Francia', 'Apellido_23', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(51, 'V', '2000024', 'Italia', 'Apellido_24', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(52, 'V', '2000025', 'Alemania', 'Apellido_25', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(53, 'V', '2000026', 'Portugal', 'Apellido_26', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(54, 'V', '2000027', 'Grecia', 'Apellido_27', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(55, 'V', '2000028', 'Rusia', 'Apellido_28', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(56, 'V', '2000029', 'China', 'Apellido_29', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(57, 'V', '2000030', 'Japón', 'Apellido_30', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(58, 'V', '2000031', 'Corea del Sur', 'Apellido_31', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(59, 'V', '2000032', 'India', 'Apellido_32', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(60, 'V', '2000033', 'Australia', 'Apellido_33', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(61, 'V', '2000034', 'Nueva Zelanda', 'Apellido_34', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(62, 'V', '2000035', 'Egipto', 'Apellido_35', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(63, 'V', '2000036', 'Sudáfrica', 'Apellido_36', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(64, 'V', '2000037', 'Nigeria', 'Apellido_37', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(65, 'V', '2000038', 'Kenia', 'Apellido_38', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(66, 'V', '2000039', 'Senegal', 'Apellido_39', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(67, 'V', '2000040', 'Túnez', 'Apellido_40', '04121338031', 'Dirección genérica', '2000-01-01', 'femenino', 'ACT', 'SALUDABLE'),
(68, 'V', '2000041', 'Argentina', 'Apellido_41', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(69, 'V', '2000042', 'Brasil', 'Apellido_42', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(70, 'V', '2000043', 'Chile', 'Apellido_43', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(71, 'V', '2000044', 'Colombia', 'Apellido_44', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(72, 'V', '2000045', 'México', 'Apellido_45', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(73, 'V', '2000046', 'Perú', 'Apellido_46', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(74, 'V', '2000047', 'Uruguay', 'Apellido_47', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(75, 'V', '2000048', 'Venezuela', 'Apellido_48', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(76, 'V', '2000049', 'Ecuador', 'Apellido_49', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(77, 'V', '2000050', 'Bolivia', 'Apellido_50', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(78, 'V', '2000051', 'Paraguay', 'Apellido_51', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(79, 'V', '2000052', 'Panamá', 'Apellido_52', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(80, 'V', '2000053', 'Costa Rica', 'Apellido_53', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(81, 'V', '2000054', 'Guatemala', 'Apellido_54', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(82, 'V', '2000055', 'El Salvador', 'Apellido_55', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(83, 'V', '2000056', 'Honduras', 'Apellido_56', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(84, 'V', '2000057', 'Nicaragua', 'Apellido_57', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(85, 'V', '2000058', 'Cuba', 'Apellido_58', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(86, 'V', '2000059', 'República Dominicana', 'Apellido_59', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(87, 'V', '2000060', 'Puerto Rico', 'Apellido_60', '04121338031', 'Dirección genérica', '2000-01-01', 'masculino', 'ACT', 'SALUDABLE'),
(88, 'V', '1480973', 'Liam', 'Hendrick', '04128649495', 'En su casa ', '1997-06-28', 'Femenino', 'DES', 'SALUDABLE'),
(89, 'V', '341234', 'Gol', 'Peterson', '04123433454', 'California', '2000-06-05', 'Masculino', 'DES', 'CRONICO'),
(90, 'V', '20321830', 'Yuletxy', 'Colmenarez', '04128892449', 'El tocuyo', '1992-02-10', 'Femenino', 'ACT', 'SALUDABLE'),
(91, 'V', '344233', 'Perdo', 'Msdms', '04142322323', 'en su cas', '2009-11-11', 'Masculino', 'ACT', 'SALUDABLE'),
(92, 'V', '3055414', 'Mdfgdf', 'Ssdds', '04142320233', 'SMDSDMDS', '2007-02-11', 'Femenino', 'ACT', 'SALUDABLE'),
(93, 'V', '303439', 'Awqwkq', 'Qmasm', '04123434322', 'wenew sdnsd', '2025-09-02', 'Masculino', 'ACT', 'SALUDABLE'),
(94, 'V', '3055415', 'Adsad', 'Asdsd', '04122343323', 'em sfdnfdhf', '2025-09-15', 'Femenino', 'ACT', 'SALUDABLE'),
(98, 'V', '3722999', 'Pedro', 'Perez', '04123454327', 'en su casa', '2002-02-20', 'Masculino', 'ACT', 'SALUDABLE');

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
(181, 5, 151, '', 240.00),
(182, 6, 152, '1234', 29.56),
(183, 5, 153, '', 9.00),
(184, 5, 154, '', 29.56),
(185, 6, 154, '', 0.00),
(186, 5, 155, '4326', 200.00),
(187, 6, 155, '4326', 880.00),
(188, 5, 156, '', 29.56),
(189, 5, 157, '', 478692.00),
(190, 5, 158, '', 123.00),
(191, 5, 159, '', 1.88),
(192, 5, 160, '', 17.00),
(193, 5, 161, '', 3000.00),
(194, 5, 162, '', 6000.00),
(195, 5, 163, '', 6000.00),
(196, 5, 164, '', 6000.00),
(197, 5, 165, '', 6000.00),
(198, 5, 166, '', 6000.00),
(199, 5, 167, '', 6000.00),
(200, 5, 168, '', 6000.00),
(201, 5, 169, '', 6000.00),
(202, 5, 170, '', 6000.00),
(203, 5, 171, '', 6000.00),
(204, 5, 172, '', 6000.00),
(205, 5, 173, '3000', 32.00),
(206, 6, 173, '3000', 19.89),
(207, 5, 174, '', 570.33),
(208, 5, 175, '', 29.56),
(209, 5, 176, '', 160.00),
(210, 5, 177, '5678', 1000.00),
(211, 6, 177, '5678', 18.00),
(212, 5, 178, '', 29.56),
(213, 5, 179, '2323', 120.00),
(214, 7, 179, '2323', 880.00),
(215, 5, 180, NULL, 1080.00),
(216, 5, 181, NULL, 1080.00),
(217, 5, 182, '', 1080.00),
(218, 5, 183, '', 246.12),
(219, 6, 184, '1213', 1000.00);

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
(3, 'DIABETES TIPO 2', 'DES'),
(5, 'EPOC', 'ACT'),
(6, 'ARTRITIS REUMATOIDE', 'ACT'),
(7, 'ENFERMEDAD CELÍACA', 'ACT'),
(8, 'OBESIDAD', 'ACT'),
(11, 'ENFERMEDAD DE CROHN', 'ACT'),
(12, 'COLITIS ULCEROSA', 'ACT'),
(13, 'ASMA', '1'),
(14, 'Patologia', 'ACT'),
(15, 'Algo', 'ACT'),
(16, 'HIPERTIROIDISMO', 'ACT'),
(17, 'OSTEOPOROSIS', 'ACT'),
(19, 'MIGRAÑA', 'ACT'),
(20, 'ALZHEIMER', 'ACT'),
(186, 'Hipertensión', 'ACT'),
(189, 'Bronquitis', 'ACT'),
(190, 'Neumonía', 'ACT'),
(192, 'Gastritis', 'ACT'),
(193, 'Hepatitis A', 'ACT'),
(194, 'Hepatitis B', 'ACT'),
(195, 'Anemia', 'ACT'),
(196, 'Artritis', 'ACT'),
(198, 'Epilepsia', 'ACT'),
(199, 'Depresión', 'ACT'),
(200, 'Ansiedad', 'ACT'),
(201, 'Dermatitis', 'ACT'),
(202, 'Sinusitis', 'ACT'),
(203, 'COVID-19', 'ACT'),
(204, 'Tuberculosis', 'ACT'),
(205, 'Insuficiencia renal', 'ACT'),
(207, 'Generica', 'ACT');

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
(178, 49, 17, '2025-04-17 13:05:00'),
(179, 55, 16, '2025-04-16 11:35:00'),
(180, 47, 13, '2025-04-15 10:10:00'),
(181, 48, 15, '2025-04-14 09:45:00'),
(183, 28, 11, '2025-04-12 08:50:00'),
(194, 27, 2, '2025-04-10 12:00:00'),
(195, 27, 6, '2025-04-09 15:25:00'),
(202, 29, 14, '2025-04-06 16:00:00'),
(207, 28, 8, '2025-04-03 09:30:00'),
(208, 26, 3, '2025-04-04 11:20:00'),
(209, 62, 6, '2025-05-15 19:42:53'),
(210, 59, 20, '2025-05-15 19:43:28'),
(211, 60, 11, '2025-05-15 19:43:28'),
(212, 87, 2, '2025-05-15 19:43:56'),
(214, 87, 20, '2025-05-15 19:44:11'),
(215, 86, 7, '2025-05-15 19:44:11'),
(216, 29, 205, '2025-05-15 19:44:21'),
(218, 51, 14, '2025-05-15 19:44:51'),
(219, 58, 14, '2025-05-15 19:44:51'),
(220, 46, 14, '2025-05-15 19:45:12'),
(222, 25, 6, '2025-06-10 10:11:51'),
(223, 25, 8, '2025-06-10 10:11:51'),
(224, 25, 5, '2025-06-10 20:07:54'),
(225, 25, 6, '2025-06-10 20:07:54'),
(226, 25, 7, '2025-06-10 20:07:54'),
(227, 25, 8, '2025-06-10 20:07:54'),
(229, 25, 5, '2025-06-19 20:29:30'),
(230, 25, 6, '2025-06-19 20:29:30'),
(231, 25, 7, '2025-06-19 20:29:30'),
(232, 25, 8, '2025-06-19 20:29:30'),
(234, 25, 186, '2025-06-19 20:29:30'),
(235, 25, 190, '2025-06-19 20:29:30'),
(236, 25, 192, '2025-06-19 20:29:30'),
(237, 89, 5, '2025-06-27 19:24:28'),
(238, 89, 7, '2025-06-27 19:24:28'),
(239, 25, 5, '2025-09-25 20:24:37'),
(240, 25, 7, '2025-09-25 20:24:37'),
(241, 25, 5, '2025-10-03 11:23:02'),
(242, 25, 7, '2025-10-03 11:23:02'),
(243, 25, 5, '2025-10-03 11:23:41'),
(244, 25, 7, '2025-10-03 11:23:41');

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
(18, 'V', '30554053', 'Wilmer', 'Baez', '04145378608', 'Administrador', NULL, 1),
(19, 'V', '1232233', 'David', 'Carlos', '04142323233', '', 7, 42),
(20, 'V', '12123343', 'Carlos', 'Garcia', '04244546565', '', 7, 43),
(21, 'V', '12020333', 'Ana', 'Bracho', '04122323422', '', 6, 45),
(22, 'V', '6755654', 'Julian', 'Valdez', '04122323212', '', 4, 46),
(23, 'V', '867548', 'Jaun', 'Edlkfjfdsk', '04243943432', '', 5, 49),
(24, 'V', '1223211', 'Auto', 'Auto', '04122232323', 'Administrador', NULL, 50),
(25, 'V', '5675324', 'Alen', 'Alenrere', '04123434343', 'Administrador', NULL, 51),
(29, 'V', '2000002', 'Editado', 'Modificado', '04123454320', '', NULL, 47);

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
(6, 'Juan Jose', '281500045', '04121338909', 'depanajuaner@gmail.com', 'en su casa', 'ACT'),
(7, 'Ricardo Perez', '296236571', '04124466999', 'sisisi@gmail.com', 'hfygh', 'ACT'),
(8, 'Luis Empresa', 'J122334', '0424354556', 'luis12345@gmail.com', 'El Tocuyo', 'ACT'),
(11, 'Juanx', 'ffreer', '04122323232', 'dix2334antias@gmail.com', 'dffdf', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serviciomedico`
--

CREATE TABLE `serviciomedico` (
  `id_servicioMedico` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `precio` float(12,2) NOT NULL,
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tipo` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `serviciomedico`
--

INSERT INTO `serviciomedico` (`id_servicioMedico`, `id_categoria`, `precio`, `estado`, `tipo`) VALUES
(22, 9, 2200.00, 'ACT', 'Examenes'),
(23, 100, 1500.00, 'ACT', 'Cita'),
(24, 1, 3000.00, 'ACT', 'Cita'),
(25, 101, 1000.00, 'ACT', 'Examenes'),
(26, 2, 120.00, 'ACT', 'Cita'),
(27, 2, 123.00, 'DES', ''),
(28, 1, 31395.00, 'DES', ''),
(29, 1, 16905.00, 'DES', ''),
(30, 1, 169.05, 'DES', ''),
(31, 101, 12.00, 'DES', ''),
(32, 1, 479.78, 'DES', ''),
(33, 100, 1.07, 'DES', ''),
(34, 104, 24.95, 'ACT', 'Cita'),
(35, 103, 60.66, 'ACT', 'Cita'),
(36, 102, 46.81, 'ACT', 'Cita'),
(37, 105, 5.48, 'ACT', 'Examenes'),
(38, 9, 100.00, 'ACT', 'Cita');

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
(15, 'sintoma', 'DES'),
(16, 'Xxxxxx', 'DES'),
(17, 'Sin n n', 'DES');

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
(50, 6, 30),
(51, 6, 31),
(52, 8, 31),
(53, 6, 32),
(54, 8, 32),
(55, 6, 33),
(56, 8, 33),
(57, 6, 34),
(58, 8, 34);

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
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id_cita`,`paciente_id_paciente`),
  ADD KEY `fk_cita_serviciomedico1_idx` (`serviciomedico_id_servicioMedico`),
  ADD KEY `fk_cita_paciente1_idx` (`paciente_id_paciente`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `control`
--
ALTER TABLE `control`
  ADD PRIMARY KEY (`id_control`),
  ADD KEY `id_paciente` (`id_paciente`,`id_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`id_datelle_factura`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `hospitalizacion_id_hospitalizacion` (`hospitalizacion_id_hospitalizacion`,`serviciomedico_id_servicioMedico`,`entrada_insumo_id_entradaDeInsumo`),
  ADD KEY `entrada_insumo_id_entradaDeInsumo` (`entrada_insumo_id_entradaDeInsumo`),
  ADD KEY `serviciomedico_id_servicioMedico` (`serviciomedico_id_servicioMedico`);

--
-- Indices de la tabla `detalle_hospitalizacion`
--
ALTER TABLE `detalle_hospitalizacion`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_hospitalizacion` (`id_hospitalizacion`,`id_servicioMedico`),
  ADD KEY `id_servicioMedico` (`id_servicioMedico`);

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
  ADD PRIMARY KEY (`id_especialidad`) USING BTREE,
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`,`id_cliente`),
  ADD KEY `id_cliente` (`id_cliente`);

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
  ADD KEY `id_control` (`id_paciente`),
  ADD KEY `id_paciente` (`id_paciente`);

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
  ADD KEY `id_insumo` (`id_entradaDeInsumo`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id_paciente`),
  ADD UNIQUE KEY `cedula` (`cedula`);

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
  ADD PRIMARY KEY (`id_patologia`),
  ADD UNIQUE KEY `nombre_patologia` (`nombre_patologia`);

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
  ADD PRIMARY KEY (`id_proveedor`),
  ADD UNIQUE KEY `rif` (`rif`);

--
-- Indices de la tabla `serviciomedico`
--
ALTER TABLE `serviciomedico`
  ADD PRIMARY KEY (`id_servicioMedico`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `sintomas`
--
ALTER TABLE `sintomas`
  ADD PRIMARY KEY (`id_sintomas`),
  ADD UNIQUE KEY `nombre` (`nombre`);

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
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `control`
--
ALTER TABLE `control`
  MODIFY `id_control` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `id_datelle_factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_hospitalizacion`
--
ALTER TABLE `detalle_hospitalizacion`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entrada`
--
ALTER TABLE `entrada`
  MODIFY `id_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de la tabla `entrada_insumo`
--
ALTER TABLE `entrada_insumo`
  MODIFY `id_entradaDeInsumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `id_especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `horarioydoctor`
--
ALTER TABLE `horarioydoctor`
  MODIFY `id_horarioydoctor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `hospitalizacion`
--
ALTER TABLE `hospitalizacion`
  MODIFY `id_hospitalizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `insumo`
--
ALTER TABLE `insumo`
  MODIFY `id_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `insumodehospitalizacion`
--
ALTER TABLE `insumodehospitalizacion`
  MODIFY `id_insumoDeHospitalizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pagodefactura`
--
ALTER TABLE `pagodefactura`
  MODIFY `id_pagoDeFactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT de la tabla `patologia`
--
ALTER TABLE `patologia`
  MODIFY `id_patologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT de la tabla `patologiadepaciente`
--
ALTER TABLE `patologiadepaciente`
  MODIFY `id_patologiaDePaciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id_personal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `serviciomedico`
--
ALTER TABLE `serviciomedico`
  MODIFY `id_servicioMedico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `sintomas`
--
ALTER TABLE `sintomas`
  MODIFY `id_sintomas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `sintomas_control`
--
ALTER TABLE `sintomas_control`
  MODIFY `id_sintomas_control` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

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
-- Filtros para la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD CONSTRAINT `detalle_factura_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`),
  ADD CONSTRAINT `detalle_factura_ibfk_2` FOREIGN KEY (`hospitalizacion_id_hospitalizacion`) REFERENCES `hospitalizacion` (`id_hospitalizacion`),
  ADD CONSTRAINT `detalle_factura_ibfk_3` FOREIGN KEY (`entrada_insumo_id_entradaDeInsumo`) REFERENCES `entrada_insumo` (`id_entradaDeInsumo`),
  ADD CONSTRAINT `detalle_factura_ibfk_4` FOREIGN KEY (`serviciomedico_id_servicioMedico`) REFERENCES `serviciomedico` (`id_servicioMedico`);

--
-- Filtros para la tabla `detalle_hospitalizacion`
--
ALTER TABLE `detalle_hospitalizacion`
  ADD CONSTRAINT `detalle_hospitalizacion_ibfk_1` FOREIGN KEY (`id_hospitalizacion`) REFERENCES `hospitalizacion` (`id_hospitalizacion`),
  ADD CONSTRAINT `detalle_hospitalizacion_ibfk_2` FOREIGN KEY (`id_servicioMedico`) REFERENCES `serviciomedico` (`id_servicioMedico`);

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
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`);

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
  ADD CONSTRAINT `hospitalizacion_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`);

--
-- Filtros para la tabla `insumodehospitalizacion`
--
ALTER TABLE `insumodehospitalizacion`
  ADD CONSTRAINT `insumodehospitalizacion_ibfk_1` FOREIGN KEY (`id_hospitalizacion`) REFERENCES `hospitalizacion` (`id_hospitalizacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `insumodehospitalizacion_ibfk_2` FOREIGN KEY (`id_entradaDeInsumo`) REFERENCES `entrada_insumo` (`id_entradaDeInsumo`);

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
-- Filtros para la tabla `sintomas_control`
--
ALTER TABLE `sintomas_control`
  ADD CONSTRAINT `sintomas_control_ibfk_1` FOREIGN KEY (`id_sintomas`) REFERENCES `sintomas` (`id_sintomas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sintomas_control_ibfk_2` FOREIGN KEY (`id_control`) REFERENCES `control` (`id_control`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
