-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2025 a las 23:12:28
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
-- Base de datos: `memoria_juego`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cartas`
--

CREATE TABLE `cartas` (
  `id` int(11) NOT NULL,
  `id_mazo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `imagen_frente` varchar(255) NOT NULL,
  `imagen_atras` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cartas`
--

INSERT INTO `cartas` (`id`, `id_mazo`, `nombre`, `imagen_frente`, `imagen_atras`) VALUES
(59, 7, 'Captura de pantalla 2025-08-03 112904.png', 'cards/1764897018_0_Captura de pantalla 2025-08-03 112904.png', 'cards/1764897018_0_Captura de pantalla 2025-08-03 112904.png'),
(60, 7, 'Captura de pantalla 2025-08-03 113039.png', 'cards/1764897018_1_Captura de pantalla 2025-08-03 113039.png', 'cards/1764897018_1_Captura de pantalla 2025-08-03 113039.png'),
(61, 7, 'Captura de pantalla 2025-09-10 100927.png', 'cards/1764897018_2_Captura de pantalla 2025-09-10 100927.png', 'cards/1764897018_2_Captura de pantalla 2025-09-10 100927.png'),
(62, 7, 'Captura de pantalla 2025-10-14 114035 - copia.png', 'cards/1764897018_3_Captura de pantalla 2025-10-14 114035 - copia.png', 'cards/1764897018_3_Captura de pantalla 2025-10-14 114035 - copia.png'),
(63, 7, 'Captura de pantalla 2025-10-15 151739.png', 'cards/1764897018_4_Captura de pantalla 2025-10-15 151739.png', 'cards/1764897018_4_Captura de pantalla 2025-10-15 151739.png'),
(64, 7, 'Captura de pantalla 2025-10-21 161053.png', 'cards/1764897018_5_Captura de pantalla 2025-10-21 161053.png', 'cards/1764897018_5_Captura de pantalla 2025-10-21 161053.png'),
(65, 7, 'Captura de pantalla 2025-10-30 162216 - copia.png', 'cards/1764897018_6_Captura de pantalla 2025-10-30 162216 - copia.png', 'cards/1764897018_6_Captura de pantalla 2025-10-30 162216 - copia.png'),
(66, 7, 'Captura de pantalla 2025-10-28 145254 - copia (2).png', 'cards/1764898110_0_Captura de pantalla 2025-10-28 145254 - copia (2).png', 'cards/1764898110_0_Captura de pantalla 2025-10-28 145254 - copia (2).png'),
(67, 7, 'Captura de pantalla 2025-10-28 145254 - copia.png', 'cards/1764898110_1_Captura de pantalla 2025-10-28 145254 - copia.png', 'cards/1764898110_1_Captura de pantalla 2025-10-28 145254 - copia.png'),
(68, 8, 'Captura de pantalla 2025-03-08 190940 - copia.png', 'cards/1764969418_0_Captura de pantalla 2025-03-08 190940 - copia.png', 'cards/1764969418_0_Captura de pantalla 2025-03-08 190940 - copia.png'),
(69, 8, 'Captura de pantalla 2025-03-08 190940.png', 'cards/1764969418_1_Captura de pantalla 2025-03-08 190940.png', 'cards/1764969418_1_Captura de pantalla 2025-03-08 190940.png'),
(70, 8, 'Captura de pantalla 2025-03-08 191949 - copia.png', 'cards/1764969418_2_Captura de pantalla 2025-03-08 191949 - copia.png', 'cards/1764969418_2_Captura de pantalla 2025-03-08 191949 - copia.png'),
(71, 8, 'Captura de pantalla 2025-03-08 193445.png', 'cards/1764969418_3_Captura de pantalla 2025-03-08 193445.png', 'cards/1764969418_3_Captura de pantalla 2025-03-08 193445.png'),
(72, 8, 'Captura de pantalla 2025-03-08 194753.png', 'cards/1764969418_4_Captura de pantalla 2025-03-08 194753.png', 'cards/1764969418_4_Captura de pantalla 2025-03-08 194753.png'),
(73, 8, 'Captura de pantalla 2025-03-08 194845.png', 'cards/1764969418_5_Captura de pantalla 2025-03-08 194845.png', 'cards/1764969418_5_Captura de pantalla 2025-03-08 194845.png'),
(74, 8, 'Captura de pantalla 2025-03-08 191949 - copia.png', 'cards/1764969431_0_Captura de pantalla 2025-03-08 191949 - copia.png', 'cards/1764969431_0_Captura de pantalla 2025-03-08 191949 - copia.png'),
(75, 9, 'Captura de pantalla 2025-03-08 194845.png', 'cards/1765054891_0_Captura de pantalla 2025-03-08 194845.png', 'cards/1765054891_0_Captura de pantalla 2025-03-08 194845.png'),
(76, 9, 'Captura de pantalla 2025-03-08 195012.png', 'cards/1765054891_1_Captura de pantalla 2025-03-08 195012.png', 'cards/1765054891_1_Captura de pantalla 2025-03-08 195012.png'),
(77, 9, 'Captura de pantalla 2025-04-05 132052.png', 'cards/1765054891_2_Captura de pantalla 2025-04-05 132052.png', 'cards/1765054891_2_Captura de pantalla 2025-04-05 132052.png'),
(78, 9, 'Captura de pantalla 2025-07-23 102924 - copia (2).png', 'cards/1765054891_3_Captura de pantalla 2025-07-23 102924 - copia (2).png', 'cards/1765054891_3_Captura de pantalla 2025-07-23 102924 - copia (2).png'),
(79, 9, 'Captura de pantalla 2025-07-23 105500.png', 'cards/1765054891_4_Captura de pantalla 2025-07-23 105500.png', 'cards/1765054891_4_Captura de pantalla 2025-07-23 105500.png'),
(80, 9, 'Captura de pantalla 2025-07-23 105521.png', 'cards/1765054891_5_Captura de pantalla 2025-07-23 105521.png', 'cards/1765054891_5_Captura de pantalla 2025-07-23 105521.png'),
(81, 10, 'Captura de pantalla 2025-07-23 105621.png', 'cards/1765320442_0_Captura de pantalla 2025-07-23 105621.png', 'cards/1765320442_0_Captura de pantalla 2025-07-23 105621.png'),
(82, 10, 'Captura de pantalla 2025-08-03 112646.png', 'cards/1765320442_1_Captura de pantalla 2025-08-03 112646.png', 'cards/1765320442_1_Captura de pantalla 2025-08-03 112646.png'),
(83, 10, 'Captura de pantalla 2025-08-03 112752.png', 'cards/1765320442_2_Captura de pantalla 2025-08-03 112752.png', 'cards/1765320442_2_Captura de pantalla 2025-08-03 112752.png'),
(84, 10, 'Captura de pantalla 2025-08-03 112904 - copia.png', 'cards/1765320442_3_Captura de pantalla 2025-08-03 112904 - copia.png', 'cards/1765320442_3_Captura de pantalla 2025-08-03 112904 - copia.png'),
(85, 10, 'Captura de pantalla 2025-08-03 112944.png', 'cards/1765320442_4_Captura de pantalla 2025-08-03 112944.png', 'cards/1765320442_4_Captura de pantalla 2025-08-03 112944.png'),
(86, 10, 'Captura de pantalla 2025-08-03 113039 - copia.png', 'cards/1765320442_5_Captura de pantalla 2025-08-03 113039 - copia.png', 'cards/1765320442_5_Captura de pantalla 2025-08-03 113039 - copia.png'),
(87, 10, 'Captura de pantalla 2025-09-10 095540.png', 'cards/1765320442_6_Captura de pantalla 2025-09-10 095540.png', 'cards/1765320442_6_Captura de pantalla 2025-09-10 095540.png'),
(88, 10, 'Captura de pantalla 2025-09-10 095640.png', 'cards/1765320442_7_Captura de pantalla 2025-09-10 095640.png', 'cards/1765320442_7_Captura de pantalla 2025-09-10 095640.png'),
(89, 10, 'Captura de pantalla 2025-09-10 100833.png', 'cards/1765320442_8_Captura de pantalla 2025-09-10 100833.png', 'cards/1765320442_8_Captura de pantalla 2025-09-10 100833.png'),
(90, 10, 'Captura de pantalla 2025-10-14 114035 - copia.png', 'cards/1765320442_9_Captura de pantalla 2025-10-14 114035 - copia.png', 'cards/1765320442_9_Captura de pantalla 2025-10-14 114035 - copia.png'),
(91, 10, 'Captura de pantalla 2025-10-14 121315 - copia.png', 'cards/1765320442_10_Captura de pantalla 2025-10-14 121315 - copia.png', 'cards/1765320442_10_Captura de pantalla 2025-10-14 121315 - copia.png'),
(92, 10, 'Captura de pantalla 2025-10-22 201913.png', 'cards/1765320442_11_Captura de pantalla 2025-10-22 201913.png', 'cards/1765320442_11_Captura de pantalla 2025-10-22 201913.png'),
(93, 10, 'Captura de pantalla 2025-10-22 202745 - copia.png', 'cards/1765320442_12_Captura de pantalla 2025-10-22 202745 - copia.png', 'cards/1765320442_12_Captura de pantalla 2025-10-22 202745 - copia.png'),
(94, 10, 'Captura de pantalla 2025-10-30 162216.png', 'cards/1765320442_13_Captura de pantalla 2025-10-30 162216.png', 'cards/1765320442_13_Captura de pantalla 2025-10-30 162216.png'),
(95, 10, 'Captura de pantalla 2025-03-08 193227 - copia - copia.png', 'cards/1765321464_0_Captura de pantalla 2025-03-08 193227 - copia - copia.png', 'cards/1765321464_0_Captura de pantalla 2025-03-08 193227 - copia - copia.png'),
(96, 10, 'Captura de pantalla 2025-03-08 193227 - copia (2).png', 'cards/1765321464_1_Captura de pantalla 2025-03-08 193227 - copia (2).png', 'cards/1765321464_1_Captura de pantalla 2025-03-08 193227 - copia (2).png'),
(97, 10, 'Captura de pantalla 2025-03-08 193325 - copia.png', 'cards/1765321464_2_Captura de pantalla 2025-03-08 193325 - copia.png', 'cards/1765321464_2_Captura de pantalla 2025-03-08 193325 - copia.png'),
(98, 10, 'Captura de pantalla 2025-03-08 193325.png', 'cards/1765321464_3_Captura de pantalla 2025-03-08 193325.png', 'cards/1765321464_3_Captura de pantalla 2025-03-08 193325.png'),
(99, 10, 'Captura de pantalla 2025-03-08 193445 - copia.png', 'cards/1765321464_4_Captura de pantalla 2025-03-08 193445 - copia.png', 'cards/1765321464_4_Captura de pantalla 2025-03-08 193445 - copia.png'),
(100, 10, 'Captura de pantalla 2025-03-08 194753 - copia - copia.png', 'cards/1765321464_5_Captura de pantalla 2025-03-08 194753 - copia - copia.png', 'cards/1765321464_5_Captura de pantalla 2025-03-08 194753 - copia - copia.png'),
(101, 10, 'Captura de pantalla 2025-04-05 132005 - copia (3).png', 'cards/1765321464_6_Captura de pantalla 2025-04-05 132005 - copia (3).png', 'cards/1765321464_6_Captura de pantalla 2025-04-05 132005 - copia (3).png'),
(102, 10, 'Captura de pantalla 2025-04-05 132030 - copia (2) - copia.png', 'cards/1765321464_7_Captura de pantalla 2025-04-05 132030 - copia (2) - copia.png', 'cards/1765321464_7_Captura de pantalla 2025-04-05 132030 - copia (2) - copia.png'),
(103, 10, 'Captura de pantalla 2025-04-05 132030 - copia (3) - copia.png', 'cards/1765321464_8_Captura de pantalla 2025-04-05 132030 - copia (3) - copia.png', 'cards/1765321464_8_Captura de pantalla 2025-04-05 132030 - copia (3) - copia.png'),
(104, 7, 'Captura de pantalla 2025-03-08 193227.png', 'cards/1765327856_0_Captura de pantalla 2025-03-08 193227.png', 'cards/1765327856_0_Captura de pantalla 2025-03-08 193227.png'),
(105, 7, 'Captura de pantalla 2025-03-08 195012.png', 'cards/1765327856_1_Captura de pantalla 2025-03-08 195012.png', 'cards/1765327856_1_Captura de pantalla 2025-03-08 195012.png'),
(124, 14, 'Captura de pantalla 2025-07-23 105621.png', 'cards/1765487325_0_Captura de pantalla 2025-07-23 105621.png', 'cards/1765487325_0_Captura de pantalla 2025-07-23 105621.png'),
(125, 14, 'Captura de pantalla 2025-08-03 112752.png', 'cards/1765487325_1_Captura de pantalla 2025-08-03 112752.png', 'cards/1765487325_1_Captura de pantalla 2025-08-03 112752.png'),
(126, 14, 'Captura de pantalla 2025-08-03 112904.png', 'cards/1765487325_2_Captura de pantalla 2025-08-03 112904.png', 'cards/1765487325_2_Captura de pantalla 2025-08-03 112904.png'),
(127, 14, 'Captura de pantalla 2025-08-03 112944.png', 'cards/1765487325_3_Captura de pantalla 2025-08-03 112944.png', 'cards/1765487325_3_Captura de pantalla 2025-08-03 112944.png'),
(128, 14, 'Captura de pantalla 2025-08-03 113039.png', 'cards/1765487325_4_Captura de pantalla 2025-08-03 113039.png', 'cards/1765487325_4_Captura de pantalla 2025-08-03 113039.png'),
(129, 15, 'Captura de pantalla 2025-10-14 114224 - copia.png', 'cards/1765487431_0_Captura de pantalla 2025-10-14 114224 - copia.png', 'cards/1765487431_0_Captura de pantalla 2025-10-14 114224 - copia.png'),
(130, 15, 'Captura de pantalla 2025-10-14 121315 - copia.png', 'cards/1765487431_1_Captura de pantalla 2025-10-14 121315 - copia.png', 'cards/1765487431_1_Captura de pantalla 2025-10-14 121315 - copia.png'),
(131, 15, 'Captura de pantalla 2025-10-14 121315.png', 'cards/1765487431_2_Captura de pantalla 2025-10-14 121315.png', 'cards/1765487431_2_Captura de pantalla 2025-10-14 121315.png'),
(132, 15, 'Captura de pantalla 2025-10-14 172437.png', 'cards/1765487431_3_Captura de pantalla 2025-10-14 172437.png', 'cards/1765487431_3_Captura de pantalla 2025-10-14 172437.png'),
(133, 15, 'Captura de pantalla 2025-10-15 151739.png', 'cards/1765487431_4_Captura de pantalla 2025-10-15 151739.png', 'cards/1765487431_4_Captura de pantalla 2025-10-15 151739.png'),
(134, 15, 'Captura de pantalla 2025-10-22 201913.png', 'cards/1765487431_5_Captura de pantalla 2025-10-22 201913.png', 'cards/1765487431_5_Captura de pantalla 2025-10-22 201913.png'),
(135, 14, 'Captura de pantalla 2025-10-30 162216 - copia.png', 'cards/1765572660_0_Captura de pantalla 2025-10-30 162216 - copia.png', 'cards/1765572660_0_Captura de pantalla 2025-10-30 162216 - copia.png'),
(136, 14, 'Captura de pantalla 2025-10-30 162216.png', 'cards/1765572660_1_Captura de pantalla 2025-10-30 162216.png', 'cards/1765572660_1_Captura de pantalla 2025-10-30 162216.png'),
(137, 14, 'Captura de pantalla 2025-11-04 164447.png', 'cards/1765572660_2_Captura de pantalla 2025-11-04 164447.png', 'cards/1765572660_2_Captura de pantalla 2025-11-04 164447.png'),
(138, 14, 'Captura de pantalla 2025-11-20 170921.png', 'cards/1765572660_3_Captura de pantalla 2025-11-20 170921.png', 'cards/1765572660_3_Captura de pantalla 2025-11-20 170921.png'),
(139, 14, 'Captura de pantalla 2025-11-30 211826.png', 'cards/1765572660_4_Captura de pantalla 2025-11-30 211826.png', 'cards/1765572660_4_Captura de pantalla 2025-11-30 211826.png'),
(140, 14, 'Captura de pantalla 2025-11-30 211910.png', 'cards/1765572660_5_Captura de pantalla 2025-11-30 211910.png', 'cards/1765572660_5_Captura de pantalla 2025-11-30 211910.png'),
(141, 14, 'Captura de pantalla 2025-12-04 204018.png', 'cards/1765572660_6_Captura de pantalla 2025-12-04 204018.png', 'cards/1765572660_6_Captura de pantalla 2025-12-04 204018.png'),
(142, 14, 'Captura de pantalla 2025-12-10 175255.png', 'cards/1765572660_7_Captura de pantalla 2025-12-10 175255.png', 'cards/1765572660_7_Captura de pantalla 2025-12-10 175255.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mazos`
--

CREATE TABLE `mazos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mazos`
--

INSERT INTO `mazos` (`id`, `nombre`, `descripcion`, `estado`) VALUES
(7, 'frutas', '1', ''),
(8, 'ealado', '1', ''),
(9, 'melo', '1', ''),
(10, 'frutas', '2', ''),
(11, 'frutas', '1', ''),
(12, 'frutassssssssssss', '2cassssssssssss', ''),
(13, '3', '3', ''),
(14, 'prueba', '1', 'eliminado'),
(15, 'segunda prieba', '1', 'eliminado'),
(16, '4', '4', 'eliminado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidas`
--

CREATE TABLE `partidas` (
  `id` int(11) NOT NULL,
  `id_jugador` int(11) NOT NULL,
  `id_mazo` int(11) NOT NULL,
  `dificultad` enum('facil','medio','dificil') NOT NULL,
  `puntaje_obtenido` int(11) NOT NULL DEFAULT 0,
  `movimientos` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partidas`
--

INSERT INTO `partidas` (`id`, `id_jugador`, `id_mazo`, `dificultad`, `puntaje_obtenido`, `movimientos`, `fecha`) VALUES
(1, 1, 7, 'facil', 130, 27, '2025-12-04 20:29:43'),
(2, 3, 7, 'facil', 115, 21, '2025-12-04 20:31:25'),
(3, 1, 7, 'medio', 110, 23, '2025-12-05 16:01:34'),
(4, 1, 10, 'facil', 120, 22, '2025-12-09 17:56:34'),
(5, 1, 10, 'facil', 70, 15, '2025-12-09 19:45:51'),
(6, 1, 10, 'facil', 80, 11, '2025-12-09 20:02:12'),
(7, 1, 13, 'facil', 85, 12, '2025-12-11 10:50:55'),
(8, 2, 13, 'facil', 80, 21, '2025-12-11 11:26:44'),
(9, 2, 13, 'facil', 40, 23, '2025-12-11 11:27:57'),
(10, 1, 14, 'facil', 90, 7, '2025-12-11 16:09:06'),
(11, 1, 15, 'facil', 70, 12, '2025-12-11 16:11:01'),
(12, 2, 14, 'facil', 65, 14, '2025-12-11 16:30:24'),
(13, 2, 14, 'facil', 75, 13, '2025-12-11 16:32:57'),
(14, 2, 14, 'facil', 70, 12, '2025-12-11 16:34:36'),
(15, 2, 14, 'facil', 85, 9, '2025-12-11 16:36:22'),
(16, 2, 14, 'facil', 70, 14, '2025-12-11 16:47:22'),
(17, 1, 14, 'facil', 90, 9, '2025-12-12 15:50:11'),
(18, 1, 14, 'dificil', 75, 66, '2025-12-12 15:54:02'),
(19, 1, 14, 'medio', 110, 23, '2025-12-12 15:55:24'),
(20, 2, 14, 'facil', 70, 14, '2025-12-12 15:59:10'),
(21, 1, 14, 'facil', 65, 16, '2025-12-12 16:13:32'),
(22, 9, 14, 'medio', 105, 24, '2025-12-12 16:20:38'),
(23, 9, 14, 'facil', 70, 19, '2025-12-12 16:21:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(120) NOT NULL,
  `numero_ficha` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rol` enum('admin','jugador') NOT NULL DEFAULT 'jugador',
  `puntaje_total` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `numero_ficha`, `password`, `rol`, `puntaje_total`) VALUES
(1, 'jerosn estiven bdoya', '1@gmail.com', '1', '$2a$12$/s9BpHEbpgEo3w4yhDInT.NwjltINC8CJalAI86TdjcUm2QSQxP1i', 'admin', 1095),
(2, 'usurario3', 'usuario@gmail.com', '2', '2', 'jugador', 435),
(3, '4', '2@gmail.com', '1', NULL, 'jugador', 115),
(5, 'Administrador', 'admin@serviplus.com', '1', NULL, 'jugador', 333),
(6, 'exel', 'exel@gamil.com', '1', NULL, 'jugador', 0),
(8, 'Administrador', 'Administrador@xn--gmaic-rta.om', NULL, '$2y$10$benmfyV9rJeFAsEE9q8cD.D3E3y6x0YZXOJ5UPq4/.VdbVWJyVlN2', 'admin', 0),
(9, 'exel', 'CCASA@gamil.com', '3', '3', 'jugador', 175);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cartas`
--
ALTER TABLE `cartas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mazo` (`id_mazo`);

--
-- Indices de la tabla `mazos`
--
ALTER TABLE `mazos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_jugador` (`id_jugador`),
  ADD KEY `id_mazo` (`id_mazo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cartas`
--
ALTER TABLE `cartas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT de la tabla `mazos`
--
ALTER TABLE `mazos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `partidas`
--
ALTER TABLE `partidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cartas`
--
ALTER TABLE `cartas`
  ADD CONSTRAINT `cartas_ibfk_1` FOREIGN KEY (`id_mazo`) REFERENCES `mazos` (`id`);

--
-- Filtros para la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD CONSTRAINT `partidas_ibfk_1` FOREIGN KEY (`id_jugador`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `partidas_ibfk_2` FOREIGN KEY (`id_mazo`) REFERENCES `mazos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
