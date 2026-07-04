-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 04-07-2026 a las 23:30:51
-- Versión del servidor: 10.4.32-MariaDB-log
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `devolver_insumo_hospitalizacion` (IN `p_id_insumo` INT, IN `p_cantidad` INT)   BEGIN
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
(1, 'CARDIOLOGIA', 'DES'),
(2, 'ONCOLOGIA', 'ACT'),
(9, 'RADIOGRAFIA', 'DES'),
(100, 'CONSULTA GENERAL', 'ACT'),
(101, 'Emergencia', 'ACT'),
(102, 'Acupuntura', 'ACT'),
(103, 'Oftalmología', 'ACT'),
(104, 'Odontología', 'ACT'),
(105, 'Hello', 'ACT'),
(106, 'Categorizacion', 'DES'),
(109, 'Xxx', 'ACT'),
(110, 'ASS', 'ACT'),
(111, 'Aqw', 'ACT'),
(112, 'Qss', 'ACT');

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
  `doctor` int(11) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id_cita`, `fecha`, `hora`, `estado`, `serviciomedico_id_servicioMedico`, `paciente_id_paciente`, `hora_salida`, `doctor`, `creado_en`) VALUES
(41, '2025-04-02', '12:33:00', 'ACT', 24, 23, '00:00:00', 0, '2026-06-03 20:07:05'),
(42, '2025-04-02', '12:33:00', 'ACT', 25, 23, '00:00:00', 0, '2026-06-03 20:07:05'),
(43, '2025-04-02', '12:33:00', 'ACT', 22, 23, '00:00:00', 0, '2026-06-03 20:07:05'),
(44, '2025-04-02', '12:33:00', 'ACT', 22, 23, '00:00:00', 0, '2026-06-03 20:07:05'),
(45, '2025-04-21', '22:00:00', 'Realizadas', 26, 25, '00:00:00', 0, '2026-06-03 20:07:05'),
(46, '2025-04-25', '12:00:00', 'Pendiente', 27, 25, '00:00:00', 0, '2026-06-03 20:07:05'),
(47, '2025-05-05', '20:00:00', 'Realizadas', 26, 25, '00:00:00', 0, '2026-06-03 20:07:05'),
(48, '2025-05-12', '20:00:00', 'Pendiente', 26, 23, '00:00:00', 0, '2026-06-03 20:07:05'),
(49, '2025-06-02', '20:00:00', 'Pendiente', 24, 25, '21:00:00', 0, '2026-06-03 20:07:05'),
(50, '2025-06-02', '21:00:00', 'Pendiente', 24, 25, '21:00:00', 0, '2026-06-03 20:07:05'),
(51, '2025-06-02', '22:00:00', 'Pendiente', 24, 25, '22:05:00', 0, '2026-06-03 20:07:05'),
(52, '2025-06-02', '22:10:00', 'Pendiente', 24, 25, '23:05:00', 0, '2026-06-03 20:07:05'),
(53, '2025-06-09', '20:00:00', 'Pendiente', 24, 25, '21:05:00', 0, '2026-06-03 20:07:05'),
(54, '2025-06-09', '21:11:00', 'Pendiente', 24, 25, '22:05:00', 0, '2026-06-03 20:07:05'),
(55, '2025-06-16', '20:00:00', 'Pendiente', 24, 34, '21:06:00', 0, '2026-06-03 20:07:05'),
(56, '2025-06-20', '10:05:00', 'Pendiente', 24, 25, '11:06:00', 0, '2026-06-03 20:07:05'),
(57, '2025-06-27', '10:00:00', 'Pendiente', 24, 25, '11:06:00', 0, '2026-06-03 20:07:05'),
(58, '2025-06-27', '11:07:00', 'Pendiente', 24, 25, '12:06:00', 0, '2026-06-03 20:07:05'),
(59, '2025-06-27', '12:07:00', 'Pendiente', 24, 25, '13:06:00', 0, '2026-06-03 20:07:05'),
(60, '2025-07-04', '10:00:00', 'Pendiente', 24, 25, '11:06:00', 0, '2026-06-03 20:07:05'),
(61, '2025-07-04', '11:07:00', 'Pendiente', 24, 25, '12:06:00', 0, '2026-06-03 20:07:05'),
(62, '2025-07-11', '10:00:00', 'Pendiente', 24, 25, '11:06:00', 0, '2026-06-03 20:07:05'),
(63, '2025-07-28', '20:00:00', 'Pendiente', 24, 25, '21:06:00', 19, '2026-06-03 20:07:05'),
(64, '2025-07-25', '10:00:00', 'Pendiente', 24, 25, '11:06:00', 20, '2026-06-03 20:07:05'),
(65, '2025-09-29', '20:00:00', 'Pendiente', 24, 25, '21:09:00', 19, '2026-06-03 20:07:05'),
(66, '2025-10-20', '20:00:00', 'DES', 24, 25, '21:10:00', 19, '2026-06-03 20:07:05'),
(67, '2025-10-24', '10:01:00', 'Realizadas', 24, 25, '11:10:00', 20, '2026-06-03 20:07:05'),
(68, '2025-10-06', '20:00:00', 'Pendiente', 24, 25, '21:10:00', 19, '2026-06-03 20:07:05'),
(69, '2025-10-27', '20:00:00', 'DES', 24, 25, '21:10:00', 19, '2026-06-12 01:42:01'),
(70, '2025-10-06', '20:00:00', 'Pendiente', 24, 25, '21:11:00', 19, '2026-06-03 20:07:05'),
(71, '2026-03-30', '20:00:00', 'Pendiente', 24, 25, '21:00:00', 19, '2026-06-03 20:07:05'),
(72, '2026-03-31', '14:00:00', 'Pendiente', 25, 104, '15:00:00', 22, '2026-06-03 20:07:05'),
(74, '2026-06-08', '20:00:00', 'Expirado', 24, 25, '21:00:00', 19, '2026-06-03 20:47:25'),
(75, '2026-06-22', '20:00:00', 'Expirado', 26, 104, '21:00:00', 19, '2026-06-03 20:53:25'),
(76, '2026-06-22', '20:00:00', 'Pendiente', 26, 104, '21:00:00', 19, '2026-06-12 01:20:43'),
(77, '2026-06-15', '20:00:00', 'Expirado', 24, 104, '21:00:00', 19, '2026-06-03 20:58:25'),
(78, '2026-06-15', '21:00:00', 'Expirado', 24, 104, '22:00:00', 19, '2026-06-03 20:59:25'),
(79, '2026-06-08', '20:00:00', 'Expirado', 24, 25, '21:00:00', 19, '2026-06-03 21:14:25'),
(80, '2026-06-08', '21:00:00', 'Expirado', 24, 25, '22:00:00', 19, '2026-06-03 21:15:25'),
(81, '2026-06-08', '20:00:00', 'Expirado', 24, 25, '21:00:00', 19, '2026-06-03 21:26:25'),
(82, '2026-06-15', '20:00:00', 'Expirado', 24, 25, '21:00:00', 19, '2026-06-03 21:37:25'),
(83, '2026-06-15', '21:00:00', 'Expirado', 24, 25, '22:00:00', 19, '2026-06-03 21:37:25'),
(84, '2026-06-08', '20:00:00', 'Expirado', 26, 104, '21:00:00', 19, '2026-06-03 21:46:25'),
(85, '2026-06-15', '20:00:00', 'Expirado', 24, 25, '21:00:00', 19, '2026-06-03 21:52:25'),
(86, '2026-06-08', '20:00:00', 'Expirado', 24, 92, '21:00:00', 19, '2026-06-03 21:58:25'),
(87, '2026-06-08', '21:00:00', 'Expirado', 24, 25, '22:00:00', 19, '2026-06-03 21:59:25'),
(88, '2026-06-15', '20:00:00', 'Expirado', 24, 25, '21:00:00', 19, '2026-06-03 22:04:25'),
(89, '2026-06-15', '21:00:00', 'Expirado', 24, 25, '22:00:00', 19, '2026-06-03 22:07:25'),
(90, '2026-06-22', '22:00:00', 'Expirado', 24, 25, '23:00:00', 19, '2026-06-03 22:09:25'),
(91, '2026-06-11', '05:00:00', 'DES', 24, 25, '06:00:00', 20, '2026-06-12 01:20:57'),
(92, '2026-06-15', '21:00:00', 'Pendiente', 24, 108, '22:00:00', 19, '2026-06-05 00:55:25'),
(93, '2026-06-15', '22:00:00', 'Pendiente', 24, 25, '23:00:00', 19, '2026-06-05 00:55:05'),
(94, '2026-06-22', '21:00:00', 'Pendiente', 24, 25, '22:00:00', 19, '2026-06-12 01:11:58');

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
(1, 'V', '12098234', 'Jose', 'Lara', '04123213212', 'esuna direccion', '2005-10-02', 'Masculino', 'ACT'),
(2, 'V', '2000002', 'Editado', 'Modificado', '04123454320', 'en su casa', '2002-02-20', 'Masculino', 'ACT'),
(3, 'V', '3722999', 'Pedro', 'Perez', '04123454327', 'en su casa', '2002-02-20', 'Masculino', 'ACT'),
(4, 'V', '30554144', 'Carlos', 'Hernadéz', '04121232343', 'Eb su casa', '2012-02-11', 'Masculino', 'ACT'),
(5, 'V', '30554145', 'Dixon', 'Bastias', '04142232333', 'En el Tocuyo', '2004-10-08', 'Masculino', 'ACT');

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
(27, 24, 1, 'La paciente presenta severos dolores de cabeza, lo cual da a entender que tiene episodios de jaqueca, a su vez también presenta problemas con la visión y mareos\r\nTomar mucha agua', 'Diclofenac potasicoCafeínaViajesan', '2025-04-02 14:45:09', '2025-04-23', 'Tomar mucha agua', 'Historia bbba', 'ACT', 'LEVE'),
(28, 25, 43, 'diagnostico', 'indicaciones', '2025-06-10 10:11:51', '2026-06-24', 'nota', 'historial\r\n\r\n', 'ACT', 'LEVE'),
(29, 25, 42, 'jfsdjfsdnfds', 'indicaciones', '2025-06-10 20:07:54', '2026-06-18', 'alguito', 'mhnfdjg algo mas', 'ACT', 'LEVE'),
(30, 25, 43, 'diagnostivo', 'indicaciones', '2025-06-19 20:29:30', '2025-07-06', 'nota', 'historial clinico  de algo no se', 'ACT', 'LEVE'),
(31, 89, 42, 'este enfermedad crónica', 'es una indicacion', '2025-06-27 19:24:28', '2025-06-29', 'es una nota', 'este en un historialssskjklk', 'ACT', 'LEVE'),
(32, 25, 43, 'dgdgdgff', 'gdfgd', '2025-09-25 20:24:37', '2025-10-12', 'fghfh', 'sddsds', 'ACT', 'LEVE'),
(33, 25, 1, 'diagnostico', 'indicaciones', '2025-10-03 11:23:02', '2025-11-01', 'nota', 'historial', 'ACT', 'LEVE'),
(34, 25, 1, 'diagnostico', 'indicaciones', '2025-10-03 11:23:41', '2025-11-01', 'nota editada', 'historial', 'ACT', 'LEVE'),
(40, 25, 43, 'diagnostico', 'sqssssas', '2025-10-30 20:12:15', '2025-10-31', 'sqssa', 'historialsaaaaaasdaslñq', 'ACT', 'LEVE'),
(41, 25, 46, 'sidasd', '', '2025-11-01 11:30:10', '0000-00-00', '', 'historial', 'DES', 'LEVE'),
(42, 26, 46, 'fewefewf3r', 'w3r3w', '2025-11-03 14:22:41', '2025-11-04', 'r3wr', 'edqwdwefw', 'ACT', 'MODERADA'),
(43, 102, 43, 'dcsdcsdc', 'dcsdc', '2025-11-03 14:37:35', '2025-11-11', 'zd', 'dcsdcsd', 'ACT', 'LEVE'),
(44, 23, 42, ':diagnostico', ':indicaciones', '2025-11-03 14:48:38', '2025-11-22', ':nota', ':histoarial', 'ACT', 'LEVE'),
(45, 102, 1, 'sdasd', 'asdas', '2025-11-03 15:00:02', '2025-11-11', 'sadas', 'wdawd', 'ACT', 'LEVE'),
(46, 102, 1, 'sdakjk', 'sdakjsjd', '2025-11-03 15:01:59', '2025-11-04', 'skadaksd', 'sadsd', 'ACT', 'LEVE'),
(47, 102, 42, 'efwfe', 'efwef', '2025-11-03 17:12:57', '2025-11-22', 'edwe', 'fewf', 'ACT', 'LEVE'),
(48, 102, 1, 'jkjhjkjkjk', 'jkjjkjk', '2025-11-03 17:15:47', '2025-11-19', 'hjhjhjjhjhj', 'jkjjkjk', 'ACT', 'LEVE'),
(49, 102, 46, 'jkhhuhu', 'hjhjhj', '2025-11-03 17:18:04', '2025-11-19', 'bkkuk', 'hhjhjhjsiiiiioijoijiiojjjjjjjjj', 'ACT', 'LEVE'),
(50, 102, 1, 'cdsdcsd', 'vfvffvfv', '2025-11-03 17:32:51', '2025-11-26', 'cds', 'vfvf', 'ACT', 'LEVE'),
(51, 102, 43, 'xwxxw', 'xwxwxw', '2025-11-03 17:34:08', '2025-11-26', 'wxqx', 'xwxqx', 'ACT', 'MODERADA'),
(52, 102, 1, 'nmnmmnmn', 'm,m,m,m,mnmn', '2025-11-03 17:43:31', '2025-11-14', 'mhhhj', 'mnmnmn', 'ACT', 'LEVE'),
(53, 102, 1, 'pppppp', 'pppppp', '2025-11-04 10:07:56', '2025-11-12', 'ppppppp', 'ppppp', 'ACT', 'LEVE'),
(54, 102, 43, 'dcsdf', 'dsfsdf', '2025-11-04 13:11:48', '2025-11-27', 'kdslkdl', 'dfsf', 'ACT', 'MODERADA'),
(55, 102, 46, 'wdddw', 'swssw', '2025-11-04 13:37:49', '2025-12-05', 'swsws', 'dfsfwd', 'DES', 'LEVE'),
(56, 92, 42, 'Diagnostivo', '', '2026-06-21 09:38:55', '0000-00-00', '', 'Hoddddfdfds', 'DES', 'MODERADA'),
(57, 92, 46, 'Sdsdfdfdfds sdds', '', '2026-06-24 11:03:10', '0000-00-00', '', 'Goadsffdff fdsnfdsf', 'DES', 'GRAVE'),
(58, 25, 42, 'Aqui bien trabajando', '', '2026-06-27 17:16:58', '0000-00-00', '', 'Historial hola', 'DES', 'LEVE'),
(59, 25, 42, 'Diagnsoti ', '', '2026-06-28 09:44:52', '0000-00-00', '', 'Historial xf', 'DES', 'MODERADA'),
(60, 92, 42, 'Dioangdsfd', '', '2026-06-28 10:16:18', '0000-00-00', '', 'Hoal fdsdsx', 'DES', 'MODERADA'),
(61, 25, 42, 'Diagnost', '', '2026-07-02 06:56:35', '0000-00-00', '', 'Sddstorial', 'DES', 'MODERADA');

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

--
-- Volcado de datos para la tabla `detalle_factura`
--

INSERT INTO `detalle_factura` (`id_datelle_factura`, `id_factura`, `tipo`, `cantidad`, `precio_unitario`, `subtotal`, `hospitalizacion_id_hospitalizacion`, `serviciomedico_id_servicioMedico`, `entrada_insumo_id_entradaDeInsumo`) VALUES
(16, 213, 'Servicio', 1, 1000.00, 1000.00, NULL, 25, NULL);

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
(81, 6, 21233, '2026-06-13', 'ACT'),
(82, 6, 2123, '2026-06-14', 'ACT'),
(83, 6, 2123, '2026-06-28', 'ACT'),
(84, 6, 21233, '2026-06-28', 'ACT');

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
(73, 49, 81, '2029-06-11', 10000.00, 1, 0),
(74, 50, 82, '2026-06-24', 100.00, 12, 0),
(75, 49, 83, '2029-07-12', 650.00, 10, 1),
(76, 49, 84, '2026-07-12', 65000.00, 20, 18);

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
(3, 'Cardiología', 'DES'),
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
(213, '2026-06-09', 0.00, 'ACT', 5);

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
(41, 29, 10, '00:00:02', '10:00:00'),
(42, 20, 12, '02:00:00', '23:00:00'),
(43, 22, 12, '01:00:00', '23:00:00'),
(44, 32, 8, '00:00:00', '01:00:00');

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
  `estado` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `personal_id_personal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `hospitalizacion`
--

INSERT INTO `hospitalizacion` (`id_hospitalizacion`, `fecha_hora_inicio`, `precio_horas`, `precio_horas_MoEx`, `total`, `total_MoEx`, `id_paciente`, `fecha_hora_final`, `estado`, `personal_id_personal`) VALUES
(41, '2026-06-21 09:38:55', 0, 0, 0, 0, 92, '0000-00-00 00:00:00', 'Realizada', 19),
(45, '2026-06-27 17:16:58', 0, 0, 0, 0, 25, '0000-00-00 00:00:00', 'DES', 19),
(46, '2026-06-28 09:44:52', 0, 0, 0, 0, 25, '0000-00-00 00:00:00', '', 19),
(47, '2026-06-28 10:16:18', 0, 0, 0, 0, 92, '0000-00-00 00:00:00', 'DES', 19),
(48, '2026-07-02 06:56:35', 0, 0, 0, 0, 25, '0000-00-00 00:00:00', 'Pendiente', 19);

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
(49, '2026-06-13_1781401388_Viernes de escritorio 2.jpg', 'Wilmer', 'Aaasdms dsffdsjfsd fdsmf dsmfsf', 'Marca', '200 ml', 100.00, 'ACT', 2, 0),
(50, '2026-06-21_1782090385_4k-minimalist-wallpaper-14.jpg', 'Assssss', 'Aaasdms dsffdsjfsd fdsmf dsmfsf', 'Marca', '100 ml', 100.00, 'ACT', 1, 0);

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
(52, 47, 75, 1),
(53, 48, 75, 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `insumos_estadisticas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `insumos_estadisticas` (
`nombre_insumo` varchar(25)
,`total_usado` decimal(32,0)
);

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
(23, 'V', '28150004', 'Juan', 'Silva', '04121338031', 'Calle 10 entre 3 y 7', '2001-09-22', 'Masculino', 'DES', 'SALUDABLE'),
(24, 'V', '28329224', 'Rocio', 'Rodriguez', '04121338031', 'URB EL BOSQUE CALLE 12', '2025-04-02', 'Femenino', 'DES', 'SALUDABLE'),
(25, 'V', '30554144', 'Carlos', 'Hernadéz', '04121232340', 'Eb su casa', '2012-02-11', 'Masculino', 'ACT', 'ENFERMO'),
(26, 'V', '17664525', 'Sofia', 'Sofia', '4121338031', 'undefined', '2001-03-30', 'Masculino', 'DES', 'SALUDABLE'),
(27, 'V', '158961', 'Aaaa', 'Aaaa', '4121338032', 'Direccion', '2001-09-22', 'Masculino', 'DES', 'SALUDABLE'),
(28, 'V', '2000001', 'Argentina', 'Apellido_1', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'DES', 'SALUDABLE'),
(29, 'V', '2000002', 'Editado', 'Modificado', '04123454320', 'en su casa', '2002-02-20', 'Masculino', 'DES', 'SALUDABLE'),
(30, 'V', '2000003', 'Chile', 'Apellido_3', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'DES', 'SALUDABLE'),
(31, 'V', '2000004', 'Colombia', 'Apellido_4', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(32, 'V', '2000005', 'México', 'Apellido_5', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(33, 'V', '2000006', 'Perú', 'Apellido_6', '04121338031', 'Dirección genérica', '2024-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(34, 'V', '2000007', 'Uruguay', 'Apellido_7', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(35, 'V', '2000008', 'Venezuela', 'Apellido_8', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'DES', 'SALUDABLE'),
(36, 'V', '2000009', 'Ecuador', 'Apellido_9', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(37, 'V', '2000010', 'Bolivia', 'Apellido_10', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(38, 'V', '2000011', 'Paraguay', 'Apellido_11', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'DES', 'SALUDABLE'),
(39, 'V', '2000012', 'Panamá', 'Apellido_12', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(40, 'V', '2000013', 'Costa Rica', 'Apellido_13', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(41, 'V', '2000014', 'Guatemala', 'Apellido_14', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(42, 'V', '2000015', 'El Salvador', 'Apellido_15', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(43, 'V', '2000016', 'Honduras', 'Apellido_16', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(44, 'V', '2000017', 'Nicaragua', 'Apellido_17', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(45, 'V', '2000018', 'Cuba', 'Apellido_18', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(46, 'V', '20000190', 'República', 'Apellido', '04121338031', 'Direccion generica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(47, 'V', '2000020', 'Puerto Rico', 'Apellido_20', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(48, 'V', '2000021', 'Canadá', 'Apellido_21', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(49, 'V', '2000022', 'España', 'Apellido_22', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(50, 'V', '2000023', 'Francia', 'Apellido_23', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(51, 'V', '2000024', 'Italia', 'Apellido_24', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(52, 'V', '2000025', 'Alemania', 'Apellido_25', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(53, 'V', '2000026', 'Portugal', 'Apellido_26', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(54, 'V', '2000027', 'Grecia', 'Apellido_27', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(55, 'V', '2000028', 'Rusia', 'Apellido_28', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(56, 'V', '2000029', 'China', 'Apellido_29', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(57, 'V', '2000030', 'Japón', 'Apellido_30', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(58, 'V', '2000031', 'Corea del Sur', 'Apellido_31', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(59, 'V', '2000032', 'India', 'Apellido_32', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(60, 'V', '2000033', 'Australia', 'Apellido_33', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(61, 'V', '2000034', 'Nueva Zelanda', 'Apellido_34', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(62, 'V', '2000035', 'Egipto', 'Apellido_35', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(63, 'V', '2000036', 'Sudáfrica', 'Apellido_36', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(64, 'V', '2000037', 'Nigeria', 'Apellido_37', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(65, 'V', '2000038', 'Kenia', 'Apellido_38', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(66, 'V', '2000039', 'Senegal', 'Apellido_39', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(67, 'V', '2000040', 'Túnez', 'Apellido_40', '04121338031', 'Dirección genérica', '2000-01-01', 'Femenino', 'ACT', 'SALUDABLE'),
(68, 'V', '2000041', 'Argentina', 'Apellido_41', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(69, 'V', '2000042', 'Brasil', 'Apellido_42', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(70, 'V', '2000043', 'Chile', 'Apellido_43', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(71, 'V', '2000044', 'Colombia', 'Apellido_44', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(72, 'V', '2000045', 'México', 'Apellido_45', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(73, 'V', '2000046', 'Perú', 'Apellido_46', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(74, 'V', '2000047', 'Uruguay', 'Apellido_47', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(75, 'V', '2000048', 'Venezuela', 'Apellido_48', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(76, 'V', '2000049', 'Ecuador', 'Apellido_49', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(77, 'V', '2000050', 'Bolivia', 'Apellido_50', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(78, 'V', '2000051', 'Paraguay', 'Apellido_51', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(79, 'V', '2000052', 'Panamá', 'Apellido_52', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(80, 'V', '2000053', 'Costa Rica', 'Apellido_53', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(81, 'V', '2000054', 'Guatemala', 'Apellido_54', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(82, 'V', '2000055', 'El Salvador', 'Apellido_55', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(83, 'V', '2000056', 'Honduras', 'Apellido_56', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(84, 'V', '2000057', 'Nicaragua', 'Apellido_57', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(85, 'V', '2000058', 'Cuba', 'Apellido_58', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(86, 'V', '20000590', 'República', 'Apellido', '04121338031', 'Direccin genrica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(87, 'V', '2000060', 'Puerto Rico', 'Apellido_60', '04121338031', 'Dirección genérica', '2000-01-01', 'Masculino', 'ACT', 'SALUDABLE'),
(88, 'V', '1480973', 'Liam', 'Hendrick', '04128649495', 'En su casa ', '1997-06-28', 'Femenino', 'DES', 'SALUDABLE'),
(89, 'V', '341234', 'Gol', 'Peterson', '04123433454', 'California', '2000-06-05', 'Masculino', 'DES', 'CRONICO'),
(90, 'V', '20321830', 'Yuletxy', 'Colmenarez', '04128892449', 'El tocuyo', '1992-02-10', 'Femenino', 'ACT', 'SALUDABLE'),
(91, 'V', '344233', 'Perdo', 'Msdms', '04142322323', 'en su cas', '2009-11-11', 'Masculino', 'ACT', 'SALUDABLE'),
(92, 'V', '3055414', 'Mdfgdf', 'Ssdds', '04142320233', 'SMDSDMDS', '2007-02-11', 'Femenino', 'ACT', 'SALUDABLE'),
(93, 'V', '303439', 'Awqwkq', 'Qmasm', '04123434322', 'wenew sdnsd', '2025-09-02', 'Masculino', 'ACT', 'SALUDABLE'),
(94, 'V', '3055415', 'Adsad', 'Asdsd', '04122343323', 'em sfdnfdhf', '2025-09-15', 'Femenino', 'ACT', 'SALUDABLE'),
(98, 'V', '3722999', 'Pedro', 'Perez', '04123454327', 'en su casa', '2002-02-20', 'Masculino', 'ACT', 'SALUDABLE'),
(100, 'V', '534534', 'Wewd', 'Xas', '04122323222', 'en su casssa', '2001-09-30', 'Masculino', 'ACT', 'SALUDABLE'),
(102, 'V', '13197426', 'Piolin', 'Paralo', '04122323212', 'wdqwdqwd', '2000-02-21', 'Masculino', 'DES', 'SALUDABLE'),
(103, 'V', '1212122', 'Colombia', 'Apellido', '04141322333', 'Direccin genrica', '2026-03-24', 'Masculino', 'DES', 'SALUDABLE'),
(104, 'V', '30554145', 'Dixon', 'Bastias', '04142232333', 'En el Tocuyo', '2004-10-07', 'Masculino', 'ACT', 'SALUDABLE'),
(105, 'V', '23421321', 'Venezuela', 'Apellido', '04121338031', 'wewewqwew', '2001-03-23', 'Masculino', 'ACT', 'SALUDABLE'),
(106, 'V', '6789089', 'Venezuela', 'Apellido', '04121338031', 'wewewqwew', '2009-03-31', 'Femenino', 'DES', 'SALUDABLE'),
(107, 'V', '5665566', 'Venezuela', 'Apellido', '04121338031', 'wewewqwew', '2000-03-17', 'Femenino', 'DES', 'SALUDABLE'),
(108, 'V', '3055413', 'Asss', 'Sddds', '04123222222', 'En su casa', '2011-06-16', 'Masculino', 'DES', 'SALUDABLE'),
(109, 'V', '12121212', 'Wilmer', 'Baez', '04123232323', 'en su casa', '2000-07-29', 'Masculino', 'ACT', 'SALUDABLE'),
(110, 'V', '1414141', 'Culeba', 'Bastias', '04123232323', 'en su casa', '2000-07-30', 'Femenino', 'ACT', 'SALUDABLE');

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
(247, 5, 213, '0', 0.00);

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
(3, 'DIABETES TIPO 2', 'DES'),
(5, 'EPOC', 'ACT'),
(6, 'ARTRITIS REUMATOIDE', 'DES'),
(7, 'ENFERMEDAD CELÍACA', 'DES'),
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
(198, 'Epilepsia', 'DES'),
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
(244, 25, 7, '2025-10-03 11:23:41'),
(245, 26, 5, '2025-11-03 14:23:45'),
(246, 102, 5, '2025-11-03 14:37:35'),
(247, 23, 20, '2025-11-03 14:46:59'),
(248, 102, 5, '2025-11-03 15:00:02'),
(249, 102, 11, '2025-11-03 15:01:59'),
(250, 102, 190, '2025-11-03 17:18:04'),
(251, 102, 17, '2025-11-04 10:07:56'),
(252, 102, 7, '2025-11-04 13:11:48'),
(253, 102, 5, '2025-11-04 13:41:16'),
(254, 102, 5, '2025-11-04 17:31:58'),
(255, 102, 5, '2025-11-04 18:23:02');

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
(29, 'V', '2000002', 'Editado', 'Modificado', '04123454320', '', NULL, 47),
(32, 'V', '30554145', 'Dixon', 'Bastias', '04141232333', 'Doctor', 5, 55);

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
(20, 31),
(22, 25);

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
(24, 1, 3000.00, 'DES', 'Cita'),
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
(36, 102, 4681.00, 'ACT', 'Examenes'),
(37, 105, 5.48, 'ACT', 'Examenes'),
(38, 9, 100.00, 'ACT', 'Cita');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_hospitalizacion`
--

CREATE TABLE `servicios_hospitalizacion` (
  `id_detalle` int(11) NOT NULL,
  `id_hospitalizacion` int(11) NOT NULL,
  `id_servicioMedico` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios_hospitalizacion`
--

INSERT INTO `servicios_hospitalizacion` (`id_detalle`, `id_hospitalizacion`, `id_servicioMedico`, `cantidad`) VALUES
(17, 48, 36, 2),
(18, 48, 25, 1);

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
(6, 'Fiebre', 'DES'),
(7, 'Vomito', 'DES'),
(8, 'Dolor de cabeza', 'ACT'),
(9, 'Malestar general', 'ACT'),
(10, 'Inchazon', 'ACT'),
(11, 'Enrojecimiento', 'ACT'),
(12, 'Piel Amarilla', 'ACT'),
(13, 'Dolor de higado', 'ACT'),
(14, 'Encias sangrantes', 'DES'),
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
(58, 8, 34),
(59, 6, 40),
(60, 6, 42),
(61, 9, 42),
(62, 6, 43),
(63, 6, 45),
(64, 8, 46),
(65, 6, 47),
(66, 8, 48),
(67, 6, 49),
(68, 8, 50),
(69, 8, 51),
(70, 6, 52),
(71, 6, 53),
(72, 6, 54),
(73, 6, 55),
(74, 9, 55),
(75, 6, 55),
(76, 8, 55);

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
-- Estructura Stand-in para la vista `view_detalle_entradas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_detalle_entradas` (
`fechaDeVencimiento` date
,`id_entradaDeInsumo` int(11)
,`imagen` varchar(500)
,`nombre` varchar(25)
,`descripcion` text
,`marca` varchar(35)
,`medida` varchar(35)
,`precio` float(12,2)
,`stockMinimo` int(11)
,`iva` tinyint(1)
,`id_insumo_e` int(11)
,`id_entrada` int(11)
,`id_proveedor` int(11)
,`numero_de_lote` int(16)
,`fechaDeIngreso` date
,`estado` varchar(10)
,`cantidad_entrada` int(12)
,`precio_entrada` decimal(12,2)
,`proveedor` varchar(25)
,`correo` varchar(40)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_factura`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_factura` (
`id_factura` int(11)
,`fecha` date
,`total` float(12,2)
,`id_cliente` int(11)
,`nombre_p` varchar(25)
,`apellido_p` varchar(25)
,`nacionalidad` varchar(12)
,`cedula_p` varchar(25)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_paciente_hospitalizado`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_paciente_hospitalizado` (
`indice` bigint(22)
,`id_hospitalizacion` int(11)
,`fecha_hora_inicio` datetime
,`precio_horas` float
,`fecha_hora_final` datetime
,`total` float
,`id_control` int(11)
,`diagnostico` text
,`historiaclinica` text
,`id_paciente` int(11)
,`nacionalidad` varchar(12)
,`cedula` varchar(25)
,`nombre` varchar(25)
,`apellido` varchar(25)
,`id_usuario` int(11)
,`nombredoc` varchar(25)
,`apellidodoc` varchar(25)
,`estado_usuario` varchar(25)
,`estado_hospitalizacion` varchar(25)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_resumen_insumos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_resumen_insumos` (
`id_insumo` int(11)
,`imagen` varchar(500)
,`nombre` varchar(25)
,`descripcion` text
,`marca` varchar(35)
,`medida` varchar(35)
,`precio` float(12,2)
,`stockMinimo` int(11)
,`iva` tinyint(1)
,`disponible` decimal(33,0)
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
-- Estructura para la vista `insumos_estadisticas`
--
DROP TABLE IF EXISTS `insumos_estadisticas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `insumos_estadisticas`  AS SELECT `i`.`nombre` AS `nombre_insumo`, sum(`df`.`cantidad`) AS `total_usado` FROM ((`detalle_factura` `df` join `entrada_insumo` `ei` on(`ei`.`id_entradaDeInsumo` = `df`.`entrada_insumo_id_entradaDeInsumo`)) join `insumo` `i` on(`i`.`id_insumo` = `ei`.`id_insumo`)) WHERE `df`.`entrada_insumo_id_entradaDeInsumo` is not null GROUP BY `ei`.`id_insumo` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `tasa_morbilidad`
--
DROP TABLE IF EXISTS `tasa_morbilidad`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tasa_morbilidad`  AS SELECT `p`.`nombre_patologia` AS `nombre_patologia`, count(distinct `pp`.`id_paciente`) AS `casos`, round(count(distinct `pp`.`id_paciente`) / (select count(0) from `paciente`) * 1000,2) AS `tasa_por_1000` FROM (`patologiadepaciente` `pp` join `patologia` `p` on(`pp`.`id_patologia` = `p`.`id_patologia`)) GROUP BY `pp`.`id_patologia` ORDER BY count(distinct `pp`.`id_paciente`) DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_detalle_entradas`
--
DROP TABLE IF EXISTS `view_detalle_entradas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_detalle_entradas`  AS SELECT `ei`.`fechaDeVencimiento` AS `fechaDeVencimiento`, `ei`.`id_entradaDeInsumo` AS `id_entradaDeInsumo`, `i`.`imagen` AS `imagen`, `i`.`nombre` AS `nombre`, `i`.`descripcion` AS `descripcion`, `i`.`marca` AS `marca`, `i`.`medida` AS `medida`, `i`.`precio` AS `precio`, `i`.`stockMinimo` AS `stockMinimo`, `i`.`iva` AS `iva`, `i`.`id_insumo` AS `id_insumo_e`, `e`.`id_entrada` AS `id_entrada`, `e`.`id_proveedor` AS `id_proveedor`, `e`.`numero_de_lote` AS `numero_de_lote`, `e`.`fechaDeIngreso` AS `fechaDeIngreso`, `e`.`estado` AS `estado`, `ei`.`cantidad_entrante` AS `cantidad_entrada`, `ei`.`precio` AS `precio_entrada`, `p`.`nombre` AS `proveedor`, `p`.`email` AS `correo` FROM (((`entrada_insumo` `ei` join `insumo` `i` on(`i`.`id_insumo` = `ei`.`id_insumo`)) join `entrada` `e` on(`e`.`id_entrada` = `ei`.`id_entrada`)) join `proveedor` `p` on(`p`.`id_proveedor` = `e`.`id_proveedor`)) WHERE `i`.`estado` = 'ACT' AND `ei`.`fechaDeVencimiento` > curdate() ORDER BY `ei`.`fechaDeVencimiento` ASC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_factura`
--
DROP TABLE IF EXISTS `view_factura`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_factura`  AS SELECT `f`.`id_factura` AS `id_factura`, `f`.`fecha` AS `fecha`, `f`.`total` AS `total`, `f`.`id_cliente` AS `id_cliente`, `p`.`nombre` AS `nombre_p`, `p`.`apellido` AS `apellido_p`, `p`.`nacionalidad` AS `nacionalidad`, `p`.`cedula` AS `cedula_p` FROM (`factura` `f` join `cliente` `p` on(`p`.`id_cliente` = `f`.`id_cliente`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_paciente_hospitalizado`
--
DROP TABLE IF EXISTS `view_paciente_hospitalizado`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_paciente_hospitalizado`  AS SELECT row_number() over ( order by `h`.`id_hospitalizacion`) - 1 AS `indice`, `h`.`id_hospitalizacion` AS `id_hospitalizacion`, `h`.`fecha_hora_inicio` AS `fecha_hora_inicio`, `h`.`precio_horas` AS `precio_horas`, `h`.`fecha_hora_final` AS `fecha_hora_final`, `h`.`total` AS `total`, `con`.`id_control` AS `id_control`, `con`.`diagnostico` AS `diagnostico`, `con`.`historiaclinica` AS `historiaclinica`, `pac`.`id_paciente` AS `id_paciente`, `pac`.`nacionalidad` AS `nacionalidad`, `pac`.`cedula` AS `cedula`, `pac`.`nombre` AS `nombre`, `pac`.`apellido` AS `apellido`, `u`.`id_usuario` AS `id_usuario`, `pe`.`nombre` AS `nombredoc`, `pe`.`apellido` AS `apellidodoc`, `u`.`estado` AS `estado_usuario`, `h`.`estado` AS `estado_hospitalizacion` FROM ((((((`hospitalizacion` `h` join `paciente` `pac` on(`h`.`id_paciente` = `pac`.`id_paciente`)) join `control` `con` on(`con`.`id_control` = (select `con2`.`id_control` from `control` `con2` where `con2`.`id_paciente` = `pac`.`id_paciente` and `con2`.`estado` = 'DES' order by `con2`.`id_control` desc limit 1))) join `segurity`.`usuario` `u` on(`con`.`id_usuario` = `u`.`id_usuario`)) join `personal` `pe` on(`pe`.`usuario` = `u`.`id_usuario`)) join `personal_has_serviciomedico` `psm` on(`psm`.`personal_id_personal` = `pe`.`id_personal`)) join `serviciomedico` `sm` on(`sm`.`id_servicioMedico` = `psm`.`serviciomedico_id_servicioMedico`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_resumen_insumos`
--
DROP TABLE IF EXISTS `view_resumen_insumos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_resumen_insumos`  AS SELECT `i`.`id_insumo` AS `id_insumo`, `i`.`imagen` AS `imagen`, `i`.`nombre` AS `nombre`, `i`.`descripcion` AS `descripcion`, `i`.`marca` AS `marca`, `i`.`medida` AS `medida`, `i`.`precio` AS `precio`, `i`.`stockMinimo` AS `stockMinimo`, `i`.`iva` AS `iva`, sum(`ei`.`cantidad_disponible`) AS `disponible` FROM ((`entrada_insumo` `ei` join `insumo` `i` on(`i`.`id_insumo` = `ei`.`id_insumo`)) join `entrada` `e` on(`e`.`id_entrada` = `ei`.`id_entrada`)) WHERE `i`.`estado` = 'ACT' AND `e`.`estado` = 'ACT' AND `ei`.`fechaDeVencimiento` > curdate() GROUP BY `i`.`id_insumo` ;

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
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `personal_id_personal` (`personal_id_personal`);

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
-- Indices de la tabla `servicios_hospitalizacion`
--
ALTER TABLE `servicios_hospitalizacion`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_hospitalizacion` (`id_hospitalizacion`,`id_servicioMedico`),
  ADD KEY `id_servicioMedico` (`id_servicioMedico`);

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
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `control`
--
ALTER TABLE `control`
  MODIFY `id_control` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `id_datelle_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `entrada`
--
ALTER TABLE `entrada`
  MODIFY `id_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `entrada_insumo`
--
ALTER TABLE `entrada_insumo`
  MODIFY `id_entradaDeInsumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `id_especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `horarioydoctor`
--
ALTER TABLE `horarioydoctor`
  MODIFY `id_horarioydoctor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `hospitalizacion`
--
ALTER TABLE `hospitalizacion`
  MODIFY `id_hospitalizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `insumo`
--
ALTER TABLE `insumo`
  MODIFY `id_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `insumodehospitalizacion`
--
ALTER TABLE `insumodehospitalizacion`
  MODIFY `id_insumoDeHospitalizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pagodefactura`
--
ALTER TABLE `pagodefactura`
  MODIFY `id_pagoDeFactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT de la tabla `patologia`
--
ALTER TABLE `patologia`
  MODIFY `id_patologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT de la tabla `patologiadepaciente`
--
ALTER TABLE `patologiadepaciente`
  MODIFY `id_patologiaDePaciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id_personal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
-- AUTO_INCREMENT de la tabla `servicios_hospitalizacion`
--
ALTER TABLE `servicios_hospitalizacion`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `sintomas`
--
ALTER TABLE `sintomas`
  MODIFY `id_sintomas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `sintomas_control`
--
ALTER TABLE `sintomas_control`
  MODIFY `id_sintomas_control` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

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
  ADD CONSTRAINT `hospitalizacion_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`),
  ADD CONSTRAINT `hospitalizacion_ibfk_2` FOREIGN KEY (`personal_id_personal`) REFERENCES `personal` (`id_personal`);

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
  ADD CONSTRAINT `personal_has_serviciomedico_ibfk_1` FOREIGN KEY (`serviciomedico_id_servicioMedico`) REFERENCES `serviciomedico` (`id_servicioMedico`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `personal_has_serviciomedico_ibfk_2` FOREIGN KEY (`personal_id_personal`) REFERENCES `personal` (`id_personal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `serviciomedico`
--
ALTER TABLE `serviciomedico`
  ADD CONSTRAINT `serviciomedico_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_servicio` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicios_hospitalizacion`
--
ALTER TABLE `servicios_hospitalizacion`
  ADD CONSTRAINT `servicios_hospitalizacion_ibfk_1` FOREIGN KEY (`id_hospitalizacion`) REFERENCES `hospitalizacion` (`id_hospitalizacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `servicios_hospitalizacion_ibfk_2` FOREIGN KEY (`id_servicioMedico`) REFERENCES `serviciomedico` (`id_servicioMedico`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sintomas_control`
--
ALTER TABLE `sintomas_control`
  ADD CONSTRAINT `sintomas_control_ibfk_1` FOREIGN KEY (`id_sintomas`) REFERENCES `sintomas` (`id_sintomas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sintomas_control_ibfk_2` FOREIGN KEY (`id_control`) REFERENCES `control` (`id_control`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `limpiar_reservas_vencidas` ON SCHEDULE EVERY 1 MINUTE STARTS '2026-06-03 16:08:25' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE cita 
  SET estado = 'Expirado' 
  WHERE estado = 'Reservado' 
    AND creado_en < NOW() - INTERVAL 5 MINUTE$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
