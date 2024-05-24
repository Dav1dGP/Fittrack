-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-05-2024 a las 13:32:44
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
-- Base de datos: `fittrack`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombre_usuario` varchar(255) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id`, `usuario_id`, `nombre_usuario`, `correo_electronico`, `asunto`, `mensaje`, `fecha`) VALUES
(1, 1, 'David', 'david_alfaz@hotmail.com', 'Plantillas', 'Quiero mas plantillas', '2024-05-23 10:26:10'),
(2, 2, 'prueba', 'agnieszka@gmail.com', 'Saludos', 'David Te quiero', '2024-05-23 10:40:00'),
(3, 1, 'David', 'david_alfaz@hotmail.com', 'prueba', 'prueba color validación', '2024-05-23 10:45:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicios`
--

CREATE TABLE `ejercicios` (
  `id` int(11) NOT NULL,
  `nombre_ejercicio` varchar(255) NOT NULL,
  `tipo_ejercicio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejercicios`
--

INSERT INTO `ejercicios` (`id`, `nombre_ejercicio`, `tipo_ejercicio`) VALUES
(1, 'sentadilla', 'bodybuilding'),
(2, 'press de banca con barra', 'bodybuilding'),
(3, 'press militar', 'bodybuilding'),
(4, 'press de banca inclinado con barra', 'bodybuilding'),
(5, 'aperturas', 'bodybuilding'),
(6, 'fondos tríceps', 'bodybuilding'),
(7, 'polea tríceps', 'bodybuilding'),
(8, 'dominadas', 'bodybuilding'),
(9, 'peso muerto', 'bodybuilding'),
(10, 'remo', 'bodybuilding'),
(11, 'elevación lateral con mancuernas', 'bodybuilding'),
(12, 'thrusters', 'crossfit'),
(13, 'pull ups', 'crossfit'),
(14, 'burpees', 'crossfit'),
(15, 'double unders', 'crossfit'),
(16, 'toes to bars', 'crossfit'),
(17, 'wall balls', 'crossfit'),
(18, 'snatches', 'crossfit'),
(19, 'clean and jerks', 'crossfit'),
(20, 'swing', 'kettlebells'),
(21, 'turkish get up', 'kettlebells'),
(22, 'clean', 'kettlebells'),
(23, 'snatch', 'kettlebells'),
(24, 'deadlift', 'kettlebells'),
(25, 'row', 'kettlebells'),
(26, 'carry', 'kettlebells'),
(27, 'goblet squat', 'kettlebells');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicio_musculos`
--

CREATE TABLE `ejercicio_musculos` (
  `id` int(11) NOT NULL,
  `ejercicio_id` int(11) NOT NULL,
  `musculo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejercicio_musculos`
--

INSERT INTO `ejercicio_musculos` (`id`, `ejercicio_id`, `musculo_id`) VALUES
(1, 1, 6),
(2, 2, 1),
(3, 3, 3),
(4, 4, 1),
(5, 5, 1),
(6, 6, 5),
(7, 7, 5),
(8, 8, 2),
(9, 9, 7),
(10, 10, 2),
(11, 11, 3),
(12, 12, 3),
(13, 13, 2),
(14, 14, 9),
(15, 15, 8),
(16, 16, 9),
(17, 17, 3),
(18, 18, 7),
(19, 19, 3),
(20, 20, 8),
(21, 21, 9),
(22, 22, 4),
(23, 23, 4),
(24, 24, 7),
(25, 25, 2),
(26, 26, 8),
(27, 27, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrenamiento`
--

CREATE TABLE `entrenamiento` (
  `id` int(11) NOT NULL,
  `ejercicio_id` int(11) NOT NULL,
  `repeticiones` int(11) NOT NULL,
  `series` int(11) NOT NULL,
  `peso` float NOT NULL,
  `fecha` date NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entrenamiento`
--

INSERT INTO `entrenamiento` (`id`, `ejercicio_id`, `repeticiones`, `series`, `peso`, `fecha`, `usuario_id`) VALUES
(9, 12, 20, 1, 1, '2024-05-16', 1),
(11, 1, 5, 5, 1, '2024-05-30', 1),
(12, 2, 5, 5, 1, '2024-05-30', 1),
(13, 3, 5, 5, 1, '2024-05-30', 1),
(15, 2, 5, 5, 1, '2024-05-16', 1),
(16, 3, 5, 5, 1, '2024-05-16', 1),
(19, 20, 3, 3, 12, '2024-05-17', 1),
(34, 7, 12, 3, 25, '2023-08-04', 2),
(36, 7, 1, 1, 1, '2024-05-18', 2),
(37, 12, 1, 1, 80, '2024-05-01', 1),
(39, 14, 1, 1, 1, '2024-05-13', 1),
(41, 11, 2, 2, 2, '2024-05-13', 1),
(42, 1, 2, 3, 24, '2024-05-09', 1),
(43, 1, 1, 12, 23, '2024-05-19', 1),
(44, 14, 1, 1, 1, '2024-05-22', 1),
(45, 8, 10, 4, 80, '2024-05-20', 1),
(46, 9, 10, 4, 120, '2024-05-20', 1),
(47, 10, 10, 4, 120, '2024-05-20', 1),
(48, 3, 10, 4, 12, '2024-05-20', 1),
(49, 11, 8, 3, 12, '2024-05-20', 1),
(50, 14, 10, 3, 80, '2024-05-23', 2),
(51, 3, 3, 3, 12, '2024-01-31', 2),
(52, 12, 1, 1, 1, '2024-05-24', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `musculos`
--

CREATE TABLE `musculos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `musculos`
--

INSERT INTO `musculos` (`id`, `nombre`) VALUES
(1, 'pecho'),
(2, 'espalda'),
(3, 'hombros'),
(4, 'bíceps'),
(5, 'tríceps'),
(6, 'cuádriceps'),
(7, 'femorales'),
(8, 'glúteos'),
(9, 'abdominales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tipo_usuario` enum('NORMAL','PREMIUM') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `password`, `tipo_usuario`) VALUES
(1, 'David', 'Gaspar', 'PREMIUM'),
(2, 'Prueba', '1234', 'NORMAL');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ejercicio_musculos`
--
ALTER TABLE `ejercicio_musculos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ejercicio_id` (`ejercicio_id`),
  ADD KEY `musculo_id` (`musculo_id`);

--
-- Indices de la tabla `entrenamiento`
--
ALTER TABLE `entrenamiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ejercicio_id` (`ejercicio_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `musculos`
--
ALTER TABLE `musculos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `entrenamiento`
--
ALTER TABLE `entrenamiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `ejercicio_musculos`
--
ALTER TABLE `ejercicio_musculos`
  ADD CONSTRAINT `ejercicio_musculos_ibfk_1` FOREIGN KEY (`ejercicio_id`) REFERENCES `ejercicios` (`id`),
  ADD CONSTRAINT `ejercicio_musculos_ibfk_2` FOREIGN KEY (`musculo_id`) REFERENCES `musculos` (`id`);

--
-- Filtros para la tabla `entrenamiento`
--
ALTER TABLE `entrenamiento`
  ADD CONSTRAINT `entrenamiento_ibfk_1` FOREIGN KEY (`ejercicio_id`) REFERENCES `ejercicios` (`id`),
  ADD CONSTRAINT `entrenamiento_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
