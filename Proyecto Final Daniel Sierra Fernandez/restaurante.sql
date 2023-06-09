-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 08-06-2023 a las 17:35:42
-- Versión del servidor: 8.0.18
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `tipo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`id`, `nombre`, `cantidad`, `precio`, `tipo_id`) VALUES
(29, 'Agua mineral', 7, '1.50', 1),
(30, 'Refresco de cola', 5, '2.00', 1),
(31, 'Zumo de naranja', 8, '2.50', 1),
(32, 'Cerveza Lager', 10, '1.80', 1),
(33, 'Ensalada César', 9, '4.50', 2),
(34, 'Sopa de tomate', 7, '3.20', 2),
(35, 'Crema de calabaza', 8, '3.80', 2),
(36, 'Espaguetis Bolognesa', 7, '5.00', 2),
(37, 'Filete de pollo', 8, '6.50', 3),
(38, 'Lomo de cerdo', 6, '7.00', 3),
(39, 'Salmón a la parrilla', 8, '9.50', 3),
(40, 'Hamburguesa con queso', 7, '5.80', 3),
(41, 'Tarta de manzana', 6, '3.00', 4),
(42, 'Helado', 9, '3.25', 4),
(43, 'Brownie de chocolate', 8, '4.00', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_producto`
--

CREATE TABLE `tipos_producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tipos_producto`
--

INSERT INTO `tipos_producto` (`id`, `nombre`) VALUES
(1, 'bebida'),
(2, 'primero'),
(3, 'segundo'),
(4, 'postre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(5) NOT NULL,
  `nombre` varchar(40) DEFAULT NULL,
  `clave` varchar(200) DEFAULT NULL,
  `tipo_usuario` enum('gerente','camarero') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `clave`, `tipo_usuario`) VALUES
(1, 'Daniel', 'Contra123', 'gerente'),
(2, 'camarero1', 'Cama123', 'camarero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `comanda` varchar(30) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `comanda`, `total`, `fecha`) VALUES
(1, 'pedido_2023-06-07_14-47-32.txt', 7.5, '2023-06-06'),
(2, 'pedido_2023-06-07_14-48-36.txt', 30.2, '2023-06-06'),
(3, 'pedido_2023-06-07_15-26-32.txt', 1.5, '2023-06-07'),
(4, 'pedido_2023-06-07_16-09-48.txt', 2, '2023-06-07'),
(5, 'pedido_2023-06-07_16-15-18.txt', 0, '2023-06-07'),
(6, 'pedido_2023-06-07_16-15-23.txt', 3.8, '2023-06-07'),
(7, 'pedido_2023-06-07_16-21-08.txt', 15, '2023-06-07'),
(8, 'pedido_2023-06-07_16-23-39.txt', 34.8, '2023-06-07'),
(9, 'pedido_2023-06-07_16-31-37.txt', -9.5, '2023-06-07'),
(10, 'pedido_2023-06-07_16-35-58.txt', 12.5, '2023-06-07'),
(11, 'pedido_2023-06-08_10-08-17.txt', 35, '2023-06-08'),
(12, 'pedido_2023-06-08_10-10-27.txt', 17, '2023-06-12'),
(13, 'pedido_2023-06-08_10-17-24.txt', 47.95, '2023-06-12'),
(14, 'pedido_2023-06-08_10-18-25.txt', 30.4, '2023-06-12');

--
-- Disparadores `ventas`
--
DELIMITER $$
CREATE TRIGGER `insertar_dia` AFTER INSERT ON `ventas` FOR EACH ROW BEGIN
    DECLARE fecha_actual DATE;
    DECLARE fecha_ayer date;
    DECLARE cant INT;
    DECLARE suma FLOAT;
    
    SET fecha_actual = CURDATE();
    SET fecha_ayer = (SELECT DATE_SUB(curdate(), INTERVAL 1 DAY));
    
    IF (SELECT fecha from ventas where id_venta=(new.id_venta - 1)) != fecha_actual THEN
        SELECT COUNT(*) INTO cant FROM ventas WHERE fecha = fecha_ayer;
        SELECT SUM(total) INTO suma FROM ventas WHERE fecha = fecha_ayer;
        INSERT INTO ventas_dia VALUES (NULL, cant, suma, fecha_ayer);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_dia`
--

CREATE TABLE `ventas_dia` (
  `id_dia` int(11) NOT NULL,
  `cant_comandas` int(11) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ventas_dia`
--

INSERT INTO `ventas_dia` (`id_dia`, `cant_comandas`, `total`, `fecha`) VALUES
(1, 2, 37.7, '2023-06-06'),
(2, 8, 60.1, '2023-06-07');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tipo` (`tipo_id`);

--
-- Indices de la tabla `tipos_producto`
--
ALTER TABLE `tipos_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`);

--
-- Indices de la tabla `ventas_dia`
--
ALTER TABLE `ventas_dia`
  ADD PRIMARY KEY (`id_dia`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `ventas_dia`
--
ALTER TABLE `ventas_dia`
  MODIFY `id_dia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD CONSTRAINT `fk_tipo` FOREIGN KEY (`tipo_id`) REFERENCES `tipos_producto` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
