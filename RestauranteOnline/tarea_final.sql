-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-06-2024 a las 12:19:51
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
-- Base de datos: `tarea_final`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `nombres` varchar(80) NOT NULL,
  `apellidos` varchar(80) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `estatus` tinyint(4) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_modifica` int(11) DEFAULT NULL,
  `fecha_baja` int(11) DEFAULT NULL,
  `ubicacion` varchar(100) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`nombres`, `apellidos`, `email`, `telefono`, `dni`, `estatus`, `fecha_alta`, `fecha_modifica`, `fecha_baja`, `ubicacion`, `id`) VALUES
('moises', 'gonzalez', 'mg3924238@gmail.com', '8092293596', '12345678', 0, '2024-02-07 08:15:19', NULL, NULL, '', 1),
('moises', 'gonzalez', 'mg3924238@gmail.com', '8092293596', '12345678', 0, '2024-02-07 08:15:47', NULL, NULL, '', 2),
('moises', 'gonzalez', 'mg3924238@gmail.com', '123456789', '1234567890', 0, '2024-02-07 08:16:27', NULL, NULL, '', 3),
('moises', 'gonzalez', 'mg3924238@gmail.com', '123456789', '1234567890', 0, '2024-02-07 09:33:21', NULL, NULL, '', 4),
('moises', 'gonzalez', 'mg3924238@gmail.com', '8092293596', '12345678', 0, '2024-02-12 08:19:10', NULL, NULL, '', 5),
('moises', 'gonzalez', 'mg3924238@gmail.com', '8092293596', '12345678', 0, '2024-02-12 08:19:42', NULL, NULL, '', 6),
('moises', 'gonzalez', 'mg3924238@gmail.com', '8092293596', '12345678', 0, '2024-02-12 08:20:33', NULL, NULL, '', 7),
('moises', 'gonzalez', 'mg3924238@gmail.com', '8092293596', '12345678', 0, '2024-02-13 10:21:27', NULL, NULL, '', 8),
('moises', 'gonzalez', 'mg3924238@gmail.com', '8092293596', '12345678', 0, '2024-02-14 09:36:33', NULL, NULL, '', 9),
('moises', 'gonzalez', 'mg3924238@gmail.com', '8092293596', '12345678', 0, '2024-02-14 09:37:44', NULL, NULL, '', 10),
('moises', 'gonzalez', 'mg3924238@gmail.com', '8092293596', '12345678', 0, '2024-02-14 09:38:04', NULL, NULL, '', 11),
('moises', 'gonzalez', 'mg3924238@gmail.com', '809294586', '12345678', 0, '2024-02-14 09:48:03', NULL, NULL, '', 12),
('moises', 'gonzalez', 'mg3924238@gmail.com', '809294586', '12345678', 0, '2024-02-14 12:53:02', NULL, NULL, '', 13),
('moises', 'gonzalez', 'mg3924238@gmail.com', '8092293596', '12345689', 0, '2024-02-14 12:53:41', NULL, NULL, '', 14),
('moises', 'gonzalez', 'mg3924238@gmail.com', '8092293596', '12345689', 0, '2024-02-14 12:55:36', NULL, NULL, '', 15),
('moises', 'gonzalez', 'mg3924238@gmail.com', '3455535353', '12355555', 0, '2024-02-14 12:56:01', NULL, NULL, '', 16),
('moises', 'gonzalez', 'mg3924238@gmail.com', '8383749', '89898989', 0, '2024-02-14 12:57:38', NULL, NULL, '', 17),
('moises', 'gonzalez', 'mg3924238@gmail.com', '8383749', '89898989', 0, '2024-02-14 12:59:38', NULL, NULL, '', 18),
('moises', 'gonzalez', 'mg3924238@gmail.com', '83942929', '7387927', 0, '2024-02-14 12:59:59', NULL, NULL, '', 19),
('Roderlis', 'Mendez', 'mendokirodeliw@gmail.com', '8093345678', '1345678', 0, '2024-02-20 18:00:43', NULL, NULL, '', 20),
('Roderlis', 'Mendez', 'roderlismendez@gmail.com', '8093345678', '134567', 0, '2024-02-20 18:02:38', NULL, NULL, '', 21),
('Rafael', 'Mendez', 'cobramendez@gmail.com', '8093345678', '134567', 0, '2024-02-21 18:45:45', NULL, NULL, '', 22),
('josue', 'Mendez', 'josue@gmail.com', '8093345678', '134567', 0, '2024-02-21 19:12:03', NULL, NULL, '', 23),
('Rose', 'Mendez', 'rosemendez@gmail.com', '8093345678', '134567', 0, '2024-02-22 18:47:50', NULL, NULL, '', 24),
('blanco', 'Mendez', 'mendokiblanco@gmail.com', '8093345678', '134567', 0, '2024-02-24 06:59:21', NULL, NULL, '', 25),
('Rosanna', 'Mendez', 'rosanna@gmail.com', '8093345678', '13456789', 0, '2024-02-26 08:31:13', NULL, NULL, '', 26),
('manolo', 'perez', 'rosana@gmail.com', '8093345678', '13456789', 0, '2024-02-26 08:50:40', NULL, NULL, '', 27),
('manolo', 'perez', 'rosna@gmail.com', '8093345678', '13456789', 0, '2024-02-26 11:50:04', NULL, NULL, '', 28),
('mando', 'pedro', 'vitorjosue12343@gmail.com', '809-372-2323', '213719562', 0, '2024-04-17 08:19:33', NULL, NULL, '', 29),
('wilian', 'richal', 'dsaweghe5feFWEQ@GMAIL.com', '324341234', '4123123213', 0, '0000-00-00 00:00:00', NULL, NULL, '2024-05-20 18:55:19', 30),
('w', 'w', 'w@gmail.com', '321312', '321312312', 0, '0000-00-00 00:00:00', NULL, NULL, '2024-05-20 18:57:07', 31),
('V', 'V', 'V@gmail.com', '321312', '321312312', 0, '2024-05-21 03:59:05', NULL, NULL, 'calle 22', 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `id_transaccion` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `id_cliente` varchar(20) NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `id_transaccion`, `fecha`, `status`, `email`, `id_cliente`, `total`) VALUES
(1, '23R34792W4827222A', '2024-02-28 18:06:55', 'COMPLETED', 'mendokiblanco@gmail.com', '25', 235),
(2, '3456WFVV346UO', '2024-02-28 18:19:26', 'COMPLETED', 'rosemendez@gmail.com', '24', 409),
(3, '23R34792W4827222E', '2024-02-28 18:24:37', 'COMPLETED', 'mendokiblanco@gmail.com', '25', 500),
(4, '23R34792W4827222U', '2024-02-28 18:27:05', 'COMPLETED', 'mendokiblanco@gmail.com', '25', 1000),
(5, '23R34792W4827222F', '2024-02-28 18:27:56', 'COMPLETED', 'mendokiblanco@gmail.com', '25', 3500),
(6, '3456WFVV346UO', '2024-02-28 18:30:29', 'COMPLETED', 'rosemendez@gmail.com', '24', 235),
(7, '3456WFVV346UO', '2024-02-28 18:32:10', 'COMPLETED', 'rosemendez@gmail.com', '29', 5500),
(8, '03346715XD853421G', '2024-05-21 11:27:28', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 130),
(9, '6CX83192CL623922Y', '2024-05-21 11:35:38', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 130),
(10, '6V8113301Y462772R', '2024-05-22 15:25:33', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 170),
(11, '4YS29489RW9726319', '2024-05-22 16:20:33', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 300),
(12, '9HK343103X226312S', '2024-05-22 16:37:54', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 170),
(13, '8K372323BP063833Y', '2024-05-22 17:06:59', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 270),
(14, '24182510LV093213F', '2024-05-22 17:18:01', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 170),
(15, '2GD80291D6483142R', '2024-05-22 17:26:12', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 170),
(16, '1AG052855E2874409', '2024-05-22 18:04:23', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 170),
(17, '3B575074E8431424F', '2024-05-22 18:10:03', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 170),
(18, '6W794764BY6197714', '2024-05-22 18:54:31', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 170),
(19, '88L66668NJ642710K', '2024-05-22 19:11:01', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 85),
(20, '2L091856NW934653V', '2024-05-22 19:15:39', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 170),
(21, '9GS55827UD281942T', '2024-05-27 19:50:18', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 1800),
(22, '18E145723F133310T', '2024-05-27 19:50:46', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 1800),
(23, '2G603988RY252732S', '2024-05-27 19:53:15', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 1800),
(24, '1RV877074E1178728', '2024-05-27 20:25:04', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 800),
(25, '13K73178WE638360T', '2024-05-28 14:02:28', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 170),
(26, '9EY91526MU501501J', '2024-05-28 14:17:11', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 2380),
(27, '0CL223111B207832W', '2024-05-28 14:18:27', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 2380),
(28, '36829922VC271943W', '2024-05-28 14:19:01', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 2380),
(29, '7HN10924PR2945615', '2024-05-28 14:22:52', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 2380),
(30, '3NL79728JN249271P', '2024-05-28 14:23:55', 'COMPLETED', 'sb-ztkce29059488@personal.example.com', '32', 2380);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`id`, `id_compra`, `id_producto`, `nombre`, `precio`, `cantidad`) VALUES
(1, 7, 3, 'Tiramisu', 560, 1),
(2, 8, 1, 'Hamburguesa', 130, 1),
(3, 9, 1, 'Hamburguesa', 130, 1),
(4, 10, 28, 'Pancakes de avena y plátano', 170, 1),
(5, 11, 33, 'Ensalada César con pollo', 300, 1),
(6, 12, 28, 'Pancakes de avena y plátano', 170, 1),
(7, 13, 40, 'Gelatina de cabellos', 100, 1),
(8, 13, 28, 'Pancakes de avena y plátano', 170, 1),
(9, 14, 28, 'Pancakes de avena y plátano', 170, 1),
(10, 15, 28, 'Pancakes de avena y plátano', 170, 1),
(11, 16, 28, 'Pancakes de avena y plátano', 170, 1),
(12, 17, 28, 'Pancakes de avena y plátano', 170, 1),
(13, 18, 28, 'Pancakes de avena y plátano', 170, 1),
(14, 19, 38, 'Pulceras', 50, 1),
(15, 19, 37, 'Jugo de Tamarindo', 35, 1),
(16, 20, 28, 'Pancakes de avena y plátano', 170, 1),
(17, 21, 33, 'Ensalada César con pollo', 300, 1),
(18, 21, 34, 'Sopa de lentejas', 170, 3),
(19, 21, 27, 'Avena con frutas', 110, 9),
(20, 22, 33, 'Ensalada César con pollo', 300, 1),
(21, 22, 34, 'Sopa de lentejas', 170, 3),
(22, 22, 27, 'Avena con frutas', 110, 9),
(23, 23, 33, 'Ensalada César con pollo', 300, 1),
(24, 23, 34, 'Sopa de lentejas', 170, 3),
(25, 23, 27, 'Avena con frutas', 110, 9),
(26, 24, 31, 'Tacos de pescado', 200, 4),
(27, 25, 28, 'Pancakes de avena y plátano', 170, 1),
(28, 29, 27, 'Avena con frutas', 110, 8),
(29, 29, 30, 'Pollo a la parrilla con ensalada de quinoa', 500, 3),
(30, 30, 27, 'Avena con frutas', 110, 8),
(31, 30, 30, 'Pollo a la parrilla con ensalada de quinoa', 500, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_cliente` varchar(100) NOT NULL,
  `productos` text NOT NULL,
  `precio` int(11) NOT NULL,
  `ubicacion` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_cliente`, `productos`, `precio`, `ubicacion`, `fecha`, `estado`) VALUES
(1, '32', 'Ensalada César con pollo(RD300)\nSopa de lentejas(RD510)\nAvena con frutas(RD990)\n', 1800, '', '2024-05-27 19:53:15', 1),
(2, '32', 'Tacos de pescado(RD$800)\n', 800, '', '2024-05-27 20:25:04', 1),
(3, '32', 'Pancakes de avena y plátano(RD$170)\n', 170, '', '2024-05-28 14:02:28', 1),
(4, '32', 'Avena con frutasx8(RD$880)\nPollo a la parrilla con ensalada de quinoax3(RD$1500)\n', 2380, 'calle 22', '2024-05-28 14:22:52', 1),
(5, '32', 'Avena con frutasx8(RD$880)\nPollo a la parrilla con ensalada de quinoax3(RD$1500)\n', 2380, 'calle 22', '2024-05-28 14:23:55', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descricion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `categoria` varchar(30) NOT NULL,
  `active` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `descuento` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descricion`, `precio`, `categoria`, `active`, `Cantidad`, `descuento`) VALUES
(27, 'Avena con frutas', 'La avena con frutas es un desayuno saludable y nutritivo que combina avena cocida con una variedad de frutas frescas o secas\r\n', 110.00, 'Desayuno', 1, 100, 0),
(28, 'Pancakes de avena y plátano', '    <p>Los pancakes de avena y plátano son una opción deliciosa y saludable para el desayuno\r\n     <h2>Ingredientes:</h2>\r\n    <ul>\r\n        <li>taza de avena</li>\r\n        <li>plátanos maduros</li>\r\n        <li>huevos</li>\r\n        <li>taza de leche (puede ser vegetal)</li>\r\n        <li>cucharadita de polvo de hornear</li>\r\n        <li>cucharadita de esencia de vainilla (opcional)</li>\r\n        <li>Una pizca de sal</li>\r\n        <li>Aceite o mantequilla para cocinar</li>\r\n    </ul>\r\n', 170.00, 'Desayuno', 1, 50, 0),
(29, 'Yogur con granola y miel', '', 140.00, 'Desayuno', 1, 50, 0),
(30, 'Pollo a la parrilla con ensalada de quinoa', '', 500.00, 'Platos Principales', 1, 100, 0),
(31, 'Tacos de pescado', '', 200.00, 'Platos Principales', 1, 200, 0),
(32, 'Botella De Agua', '', 30.00, 'Productos de emprendimiento', 1, 250, 0),
(33, 'Ensalada César con pollo', '', 300.00, 'Platos Principales', 1, 200, 0),
(34, 'Sopa de lentejas', '', 170.00, 'Platos Principales', 1, 50, 0),
(35, 'Pasta al pesto', '', 250.00, 'Platos Principales', 1, 100, 0),
(36, 'Jugo de Limon', '', 30.00, 'Productos de emprendimiento', 1, 4, 0),
(37, 'Jugo de Tamarindo', '', 35.00, 'Productos de emprendimiento', 1, 4, 0),
(38, 'Pulceras', '', 50.00, 'Productos de emprendimiento', 1, 7, 0),
(39, 'Pulceras', '', 60.00, 'Productos de emprendimiento', 1, 250, 0),
(40, 'Gelatina de cabellos', '', 100.00, 'Productos de emprendimiento', 0, 6, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `password` varchar(13) NOT NULL,
  `rol` varchar(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `nombre`, `password`, `rol`) VALUES
(1, 'Adam', '1', '1'),
(8, 'Roderlis', '1', '2'),
(0, 'G', '1', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(120) NOT NULL,
  `activacion` int(11) NOT NULL DEFAULT 0,
  `token` varchar(40) NOT NULL,
  `token_password` varchar(40) DEFAULT NULL,
  `password_request` int(11) NOT NULL DEFAULT 0,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `password`, `activacion`, `token`, `token_password`, `password_request`, `id_cliente`) VALUES
(0, 'blanco', '$2y$10$6pzyMaejfeGWnwh/hcfDtuxUIiI.abcI9KoU7wz3fb1xsUOukPLwG', 0, '28c6163d1dcd6886eb215cffdb0b6a08', NULL, 0, 25),
(0, 'josue', '$2y$10$z84W2RlInsfp0xEJtvBAoOexNc4vlKe0Pel68TSoFTZJkuO2LmaXi', 1, '388b69ad15e23563bf9cf191ae8baeda', NULL, 0, 23),
(0, 'manlo', '$2y$10$leNJygjYv2Usns9OBcc4jOZjHgSD.64W8ucElQ8lJhtb/.oJjFKle', 0, 'f3fa1fe398c198d39ecd6366b2a1ed27', NULL, 0, 28),
(0, 'manolo', '$2y$10$H6iT8GgMkpNgwpnnnK.2UulV3wN/pVY4vtz0KHNEVXYFeqnfs11ES', 0, '74949ed0a94e083bf2c4a509bb3df4ff', NULL, 0, 27),
(0, 'Pedro', '$2y$10$6Ki/inR7VbrYlNxmYFeajOvulcaZ5H54GmepJNKEJ9SnZOmngtXxm', 0, 'f63515491e412cb780efc6cc71b0ab04', NULL, 0, 29),
(1, 'Roderlis', '$2y$10$9baWxsAi.tidkYT3usoWS.3jKatKW6oOPEWP.JFeetguj1S9v9Fwq', 1, '2ccf7388eca44d17c9116aea18d939e9', NULL, 0, 20),
(0, 'Rosa', '$2y$10$JsXdpEjnHb/axBhFHcL7RuJbai4iFhZBqRd06CL4OP0r61xjW4sDK', 0, 'a22f04beea4ac9155138defac3baf125', NULL, 0, 26),
(0, 'Rose', '$2y$10$f25zsl7o4K6aB6ZBRHiAtu.xjaTC/vU1a2Xpiv9U5RMU087lGXfuW', 1, '8f62da96a7608cff5ad5d4b9be4113fc', NULL, 0, 24),
(0, 'V', '$2y$10$aH.z39KLKW8U0DKrTbawxuK3lFGZ4EbJ.FfsNmMvoFNUmQlRHSYzO', 0, 'b5ed9c6769b6f2276c1739544b161ee5', NULL, 0, 32),
(0, 'w', '$2y$10$Caba7IkgjcVa7BLWEEnCWeDKRIwOeuWHIsxQkh6.EFv0w.m.9up9G', 0, '6edb30af7976835b69f3fb7826b2de3b', NULL, 0, 31);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD UNIQUE KEY `uq_usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
