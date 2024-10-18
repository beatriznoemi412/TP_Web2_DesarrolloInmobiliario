-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-10-2024 a las 23:54:56
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
CREATE DATABASE IF NOT EXISTS `desarrolloinmobiliario` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `desarrolloinmobiliario`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedores`
--

CREATE TABLE IF NOT EXISTS `vendedores` (
  `id_vendedor` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Telefono` varchar(70) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` char(150) NOT NULL,
  `rol` enum('admin','vendedor') NOT NULL DEFAULT 'vendedor',
  PRIMARY KEY (`id_vendedor`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vendedores`
--

INSERT INTO `vendedores` (`id_vendedor`, `Nombre`, `Apellido`, `Telefono`, `Email`, `usuario`, `password`, `rol`) VALUES
(1, 'Agustín Leonel', 'Castro', '2494678637', 'agustinC@gmail.com', 'webadmin', '$2a$12$mvhk0vIlA2p3LU.cQw/OxOrWxQFOk71l0Eq8I94pvcQTF5Z32icBu', 'admin'),
(2, 'Pamela Andrea', 'Sosa', '2494582311', 'pamsosa@gmail.com', '', '', 'vendedor'),
(3, 'Atilio', 'Arce', '2494985635', 'ja@gmail.com', '', '', 'vendedor'),
(48, 'Nora Alicia', 'Pascal', '2494302987', 'pascal@gmail.com', '', '', 'vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE IF NOT EXISTS `venta` (
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  `inmueble` varchar(300) NOT NULL,
  `fecha_venta` date NOT NULL,
  `precio` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `foto_url` varchar(255) DEFAULT NULL,
  UNIQUE KEY `id_venta` (`id_venta`),
  KEY `Id_vendedor` (`id_vendedor`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id_venta`, `inmueble`, `fecha_venta`, `precio`, `id_vendedor`, `foto_url`) VALUES
(34, 'Departamento en pleno centro Tandil', '2024-09-04', 228990, 3, 'https://cdn.pixabay.com/photo/2014/09/04/05/54/construction-435302_1280.jpg'),
(35, 'Casa importante cerca del lago de Tandil.', '2024-07-07', 485000, 48, 'https://cdn.pixabay.com/photo/2013/09/24/12/08/apartment-185779_1280.jpg'),
(36, ' Excepcional cabaña en frente lago de Tandil, en plena sierra', '2024-10-08', 287000, 3, 'https://cdn.pixabay.com/photo/2016/09/23/10/20/cottage-1689224_1280.jpg'),
(71, 'Espectacular casa en las sierras de Tandil con vista inmejorable', '2024-09-04', 455000, 1, 'https://cdn.pixabay.com/photo/2017/04/10/22/28/residence-2219972_1280.jpg'),
(72, 'Espectacular casa en las sierras de Tandil con vista inmejorable', '2024-09-04', 470000, 1, 'https://www.elmueble.com/medio/2018/02/15/dsc9100_54145a8f.jpg'),
(76, 'Casona de campo muy importante ', '2024-08-07', 467900, 2, 'https://cdn.pixabay.com/photo/2023/08/19/08/26/house-8200038_960_720.jpg');

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
