-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-10-2024 a las 03:45:57
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
  `id_vendedor` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Telefono` varchar(70) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` char(150) NOT NULL,
  `rol` enum('admin','vendedor') NOT NULL DEFAULT 'vendedor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vendedores`
--

INSERT INTO `vendedores` (`id_vendedor`, `Nombre`, `Apellido`, `Telefono`, `Email`, `usuario`, `password`, `rol`) VALUES
(1, 'Agustín', 'Castro', '2494678635', 'agustinC@gmail.com', 'webadmin', '$2a$12$mvhk0vIlA2p3LU.cQw/OxOrWxQFOk71l0Eq8I94pvcQTF5Z32icBu', 'admin'),
(2, 'Pamela ', 'Sosa', '2494582311', 'pamsosa@gmail.com', '', '', 'vendedor'),
(3, 'Juan', 'Arce', '2494985634', 'ja@gmail.com', '', '', 'vendedor'),
(4, 'Carmen', 'Lopez', '2494123122', 'carmenlo@gmail.com', '', '', 'vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id_venta` int(11) NOT NULL,
  `inmueble` varchar(300) NOT NULL,
  `fecha_venta` date NOT NULL,
  `precio` int(11) NOT NULL,
  `Id_vendedor` int(11) NOT NULL,
  `foto_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id_venta`, `inmueble`, `fecha_venta`, `precio`, `id_vendedor`, `foto_url`) VALUES
(31, 'Lujosa casa en country golf', '2024-08-07', 525000, 1, 'https://cdn.pixabay.com/photo/2016/08/16/03/50/exterior-1597098_1280.jpg'),
(34, 'Departamento en pleno centro Tandil', '2024-08-13', 220000, 3, 'https://cdn.pixabay.com/photo/2014/09/04/05/54/construction-435302_1280.jpg'),
(35, 'Casa importante cerca del lago de Tandil', '2024-08-23', 480000, 2, 'https://cdn.pixabay.com/photo/2013/09/24/12/08/apartment-185779_1280.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`id_vendedor`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD UNIQUE KEY `id_venta` (`id_venta`),
  ADD KEY `id_vendedor` (`id_vendedor`);

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
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

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
