-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-03-2021 a las 03:02:28
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ipos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `identificacion` varchar(200) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellido` varchar(200) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `tipodecuenta` varchar(15) NOT NULL,
  `numerodecuenta` varchar(200) NOT NULL,
  `fecha` date NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(15) NOT NULL,
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `identificacion`, `nombre`, `apellido`, `direccion`, `correo`, `tipodecuenta`, `numerodecuenta`, `fecha`, `username`, `password`, `role`, `is_active`) VALUES
(10043, '1', 'BANCO', 'BANCO', 'JUAN X MARCOS', 'BANCO', 'Ahorro', 'CA00100', '0000-00-00', 'kevin', 'kevin', 'Admin', 1),
(10044, '1250709209', 'KEVIN', 'MOSQUERA', 'JUAN X MARCOS', 'kevin.mosquera.coronel@gmail.com', 'Corriente', 'CC00002', '2021-03-14', 'KMOSQUERA', 'WMwJUJ1g', 'Operator', 1),
(10045, '125070920911', 'SDFSDF', 'SDFSDFSDF', '564', 'kevin.mosquera.coronel@gmail.com', 'Corriente', 'CC00003', '2021-03-15', 'SSDFSDFSDF', 'oxgbF51x', 'Operator', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10046;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
