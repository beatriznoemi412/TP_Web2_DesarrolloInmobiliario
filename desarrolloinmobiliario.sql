-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-10-2024 a las 16:07:08
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
-- Base de datos: `desarrolloinmobiliario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedores`
--

CREATE TABLE `vendedores` (
  `Id_vendedor` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Telefono` varchar(70) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Calificacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vendedores`
--

INSERT INTO `vendedores` (`Id_vendedor`, `Nombre`, `Apellido`, `Telefono`, `Email`, `Calificacion`) VALUES
(1, 'Agustín', 'Castro', '2494678635', 'agustinC@gmail.com', 0),
(2, 'Pamela ', 'Sosa', '2494582311', 'pamsosa@gmail.com', 0),
(3, 'Juan', 'Arce', '2494985634', 'ja@gmail.com', 0),
(4, 'Carmen', 'Lopez', '2494123122', 'carmenlo@gmail.com', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id_venta` int(11) NOT NULL,
  `inmueble` varchar(100) NOT NULL,
  `fecha_venta` date NOT NULL,
  `precio` int(11) NOT NULL,
  `Id_vendedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id_venta`, `inmueble`, `fecha_venta`, `precio`, `Id_vendedor`) VALUES
(1, 'Casa de lujo en el  Lago del Fuerte.', '2024-09-11', 550000, 2),
(2, 'nueva casa en la sierra', '2024-10-01', 300000, 4),
(3, 'cabaña cercana al lago, entre sierras', '2024-10-01', 200000, 2),
(4, 'casa céntrica, inmejorables terminaciones', '2024-10-01', 350000, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`Id_vendedor`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD UNIQUE KEY `id_venta` (`id_venta`),
  ADD KEY `Id_vendedor` (`Id_vendedor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  MODIFY `Id_vendedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`Id_vendedor`) REFERENCES `vendedores` (`Id_vendedor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
