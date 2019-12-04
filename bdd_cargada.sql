-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-12-2019 a las 22:23:38
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS Presty;
CREATE DATABASE Presty;
USE Presty;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `presty`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client`
--

CREATE TABLE `client` (
  `ID` int(9) UNSIGNED NOT NULL,
  `FK_USER` int(9) UNSIGNED NOT NULL,
  `NAME` varchar(45) NOT NULL,
  `LAST_NAME` varchar(45) NOT NULL,
  `DNI` int(8) NOT NULL,
  `BIRTH_DAY` date NOT NULL,
  `BORRADO` enum('Si','No') NOT NULL DEFAULT 'No',
  `PHONE` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `client`
--

INSERT INTO `client` (`ID`, `FK_USER`, `NAME`, `LAST_NAME`, `DNI`, `BIRTH_DAY`, `BORRADO`, `PHONE`) VALUES
(3, 3, 'Delfina', 'Alzate\r\n', 34958622, '1990-12-01', 'No', 11365069),
(4, 9, 'Mia', 'Bonilla', 23495837, '1975-12-28', 'No', 11829384),
(5, 10, 'Sol', 'Carvallo', 20584928, '1971-02-11', 'No', 1115384950),
(6, 14, 'Alejo', 'Cabrera', 28994485, '1984-05-22', 'No', 45472203),
(7, 16, 'Bruno', 'Donato', 35694820, '1990-11-04', 'No', 112349384),
(8, 17, 'Pablo', 'Escamilla', 19304958, '1964-10-13', 'No', 47897653),
(9, 18, 'Cielo', 'Herrera', 38449958, '1994-12-21', 'No', 11304643);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `financiera`
--

CREATE TABLE `financiera` (
  `ID` int(9) UNSIGNED NOT NULL,
  `FK_USER` int(9) UNSIGNED NOT NULL,
  `COMPANY` varchar(45) NOT NULL,
  `BORRADO` enum('Si','No') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `financiera`
--

INSERT INTO `financiera` (`ID`, `FK_USER`, `COMPANY`, `BORRADO`) VALUES
(2, 5, 'Hauswagen Pilar\r\n', 'No'),
(4, 8, 'MALKA', 'No'),
(5, 11, 'IQ Soluciones Financieras\r\n', 'No'),
(6, 12, 'FDI Gerenciadora de Patrimonios\r\n\r\n', 'No'),
(7, 13, 'AVAL FEDERAL SGR\r\n', 'No'),
(8, 15, 'Grupo Puerto\r\n', 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta`
--

CREATE TABLE `oferta` (
  `ID` int(9) UNSIGNED NOT NULL,
  `FK_FINANCIERA` int(9) UNSIGNED NOT NULL,
  `FK_PRESTAMO` int(9) UNSIGNED NOT NULL,
  `STATE` enum('Ofertar','Denegar') NOT NULL,
  `STATE_CLIENT` enum('Tomada','Rechazada') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `oferta`
--

INSERT INTO `oferta` (`ID`, `FK_FINANCIERA`, `FK_PRESTAMO`, `STATE`, `STATE_CLIENT`) VALUES
(27, 2, 11, 'Ofertar', 'Rechazada'),
(28, 2, 12, 'Denegar', NULL),
(29, 4, 45, 'Ofertar', 'Rechazada'),
(30, 5, 10, 'Denegar', NULL),
(31, 5, 12, 'Denegar', NULL),
(32, 5, 13, 'Denegar', NULL),
(33, 5, 15, 'Denegar', NULL),
(34, 5, 45, 'Ofertar', NULL),
(35, 8, 10, 'Ofertar', NULL),
(36, 8, 45, 'Denegar', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `ID` int(9) UNSIGNED NOT NULL,
  `FK_CLIENT` int(9) UNSIGNED NOT NULL,
  `FK_FINANCIERA` int(9) UNSIGNED DEFAULT NULL,
  `FK_AUTORIZADOR` int(9) UNSIGNED NOT NULL,
  `AMOUNT` int(11) NOT NULL,
  `STATE` enum('Pedido','Pre-Otorgado','Otorgado','Denegado') NOT NULL DEFAULT 'Pedido',
  `CREATED_DATE` datetime NOT NULL,
  `BORRADO` enum('Si','No') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `prestamo`
--

INSERT INTO `prestamo` (`ID`, `FK_CLIENT`, `FK_FINANCIERA`, `FK_AUTORIZADOR`, `AMOUNT`, `STATE`, `CREATED_DATE`, `BORRADO`) VALUES
(10, 3, NULL, 4, 12345, 'Pre-Otorgado', '2019-10-12 15:59:39', 'No'),
(11, 4, 4, 7, 123456, 'Otorgado', '2019-10-12 16:11:31', 'No'),
(12, 3, NULL, 7, 1111111, 'Pre-Otorgado', '2019-10-12 16:28:36', 'No'),
(13, 3, NULL, 7, 12345, 'Pre-Otorgado', '2019-10-12 16:29:12', 'No'),
(14, 3, NULL, 7, 12345678, 'Denegado', '2019-10-12 16:30:50', 'No'),
(15, 3, NULL, 4, 12345678, 'Pre-Otorgado', '2019-10-12 16:31:39', 'No'),
(16, 3, NULL, 4, 12345678, 'Denegado', '2019-10-12 16:34:09', 'No'),
(17, 3, NULL, 7, 12345678, 'Denegado', '2019-10-12 16:34:27', 'No'),
(18, 3, NULL, 7, 11111, 'Pedido', '2019-10-12 16:42:10', 'No'),
(45, 5, 5, 4, 20000, 'Otorgado', '2019-10-14 18:11:20', 'No'),
(51, 9, NULL, 7, 111111, 'Pedido', '2019-12-03 16:42:12', 'No'),
(52, 4, NULL, 2, 12222, 'Denegado', '2019-12-04 17:09:25', 'No'),
(53, 5, NULL, 2, 321312, 'Pedido', '2019-12-04 18:03:41', 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicidad`
--

CREATE TABLE `publicidad` (
  `ID` int(9) UNSIGNED NOT NULL,
  `NAME` varchar(45) NOT NULL,
  `LINK` varchar(255) NOT NULL,
  `IMG` varchar(255) NOT NULL,
  `BORRADO` enum('Si','No') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `publicidad`
--

INSERT INTO `publicidad` (`ID`, `NAME`, `LINK`, `IMG`, `BORRADO`) VALUES
(1, 'presty', 'https://www.google.com.ar', 'C:/xampp/htdocs/Presty/images/Publicidad/buenos aires.jpg', 'No'),
(2, 'dddd', 'https://www.google.com', 'C:/xampp/htdocs/Presty/images/Publicidad/buenos aires.jpg', 'No'),
(3, 'despegar', 'https://www.despegar.com.ar/', 'C:/xampp/htdocs/Presty/images/Publicidad/Despegar.png', 'No'),
(4, 'Peugeot', 'https://www.peugeot.com.ar/', 'C:/xampp/htdocs/Presty/images/Publicidad/peugeot.png', 'No'),
(5, 'tuvieja', 'entanga.com', 'C:/xampp/htdocs/Presty/images/Publicidad/peugeot.png', 'No'),
(6, 'jose', 'cito', 'C:/xampp/htdocs/Presty/images/Publicidad/WhatsApp Image 2019-10-25 at 11.30.10 AM (1).jpeg', 'No'),
(7, 'tuvie', 'jita', 'C:/xampp/htdocs/Presty/images/Publicidad/WhatsApp Image 2019-10-30 at 10.27.44 AM (2).jpeg', 'Si'),
(8, 'dwqdwq', 'dwqqdqw', 'C:/xampp/htdocs/Presty/images/Publicidad/WhatsApp Image 2019-10-18 at 12.00.01 PM.jpeg', 'Si'),
(9, 'zazaz', 'zazaza', 'C:/xampp/htdocs/Presty/images/Publicidad/Despegar.jpg', 'Si'),
(10, 's', 's', 'C:/xampp/htdocs/Presty/images/Publicidad/font.png', 'Si'),
(11, 'efdw', 'https://efdw.dw', 'C:/xampp/htdocs/Presty/images/Publicidad/font.png', 'Si'),
(12, 'heyyy', 'http://holu.co', 'C:/xampp/htdocs/Presty/images/Publicidad/DER.png', 'Si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `ID` int(9) UNSIGNED NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `USER_TYPE` enum('Cliente','Financiera','Autorizador','Administrador') DEFAULT 'Cliente',
  `BORRADO` enum('Si','No') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`ID`, `EMAIL`, `PASSWORD`, `USER_TYPE`, `BORRADO`) VALUES
(1, 'administrador1@gmail.com', '1234', 'Administrador', 'No'),
(2, 'autorizador1@gmail.com', '1234', 'Autorizador', 'No'),
(3, 'delfi@gmail.com', '1234', 'Cliente', 'No'),
(4, 'autorizador2@gmail.com', '1234', 'Autorizador', 'No'),
(5, 'hauswagen@gmail.com', '1234', 'Financiera', 'No'),
(7, 'autorizador@gmail.com', '1234', 'Autorizador', 'No'),
(8, 'malka@gmail.com', '1234', 'Financiera', 'No'),
(9, 'mia@gmail.com', '1234', 'Cliente', 'No'),
(10, 'sol@gmail.com', '1234', 'Cliente', 'No'),
(11, 'solucionesfinancieras@gmail.com', '1234', 'Financiera', 'No'),
(12, 'fdi@gmail.com', '1234', 'Financiera', 'No'),
(13, 'abalfederal@gmail.com', '1234', 'Financiera', 'No'),
(14, 'alejo@gmail.com', '1234', 'Cliente', 'No'),
(15, 'grupopuerto@gmail.com', '1234', 'Financiera', 'No'),
(16, 'bruno@gmail.com', '1234', 'Cliente', 'No'),
(17, 'pablo@gmail.com', '1234', 'Cliente', 'No'),
(18, 'cielo@gmail.com', '1234', 'Cliente', 'Si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `veraz`
--

CREATE TABLE `veraz` (
  `ID` int(9) UNSIGNED NOT NULL,
  `FK_PRESTAMO` int(9) UNSIGNED NOT NULL,
  `ANSWER` enum('Aprobado','Reprobado') DEFAULT 'Reprobado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `veraz`
--

INSERT INTO `veraz` (`ID`, `FK_PRESTAMO`, `ANSWER`) VALUES
(1, 11, 'Aprobado'),
(2, 12, 'Aprobado'),
(3, 13, 'Aprobado'),
(4, 14, 'Aprobado'),
(5, 45, 'Aprobado'),
(6, 16, 'Aprobado'),
(7, 15, 'Aprobado'),
(8, 10, 'Reprobado'),
(9, 17, 'Reprobado'),
(10, 18, 'Aprobado'),
(11, 45, 'Reprobado'),
(12, 18, 'Aprobado'),
(16, 52, 'Aprobado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_USER` (`FK_USER`);

--
-- Indices de la tabla `financiera`
--
ALTER TABLE `financiera`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_USER` (`FK_USER`);

--
-- Indices de la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_FINANCIERA` (`FK_FINANCIERA`),
  ADD KEY `FK_PRESTAMO` (`FK_PRESTAMO`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_CLIENT` (`FK_CLIENT`),
  ADD KEY `FK_FINANCIERA` (`FK_FINANCIERA`),
  ADD KEY `FK_AUTORIZADOR` (`FK_AUTORIZADOR`);

--
-- Indices de la tabla `publicidad`
--
ALTER TABLE `publicidad`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- Indices de la tabla `veraz`
--
ALTER TABLE `veraz`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_PRESTAMO` (`FK_PRESTAMO`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `client`
--
ALTER TABLE `client`
  MODIFY `ID` int(9) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `financiera`
--
ALTER TABLE `financiera`
  MODIFY `ID` int(9) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `oferta`
--
ALTER TABLE `oferta`
  MODIFY `ID` int(9) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `ID` int(9) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `publicidad`
--
ALTER TABLE `publicidad`
  MODIFY `ID` int(9) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(9) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `veraz`
--
ALTER TABLE `veraz`
  MODIFY `ID` int(9) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`FK_USER`) REFERENCES `user` (`ID`);

--
-- Filtros para la tabla `financiera`
--
ALTER TABLE `financiera`
  ADD CONSTRAINT `financiera_ibfk_1` FOREIGN KEY (`FK_USER`) REFERENCES `user` (`ID`);

--
-- Filtros para la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD CONSTRAINT `oferta_ibfk_1` FOREIGN KEY (`FK_FINANCIERA`) REFERENCES `financiera` (`ID`),
  ADD CONSTRAINT `oferta_ibfk_2` FOREIGN KEY (`FK_PRESTAMO`) REFERENCES `prestamo` (`ID`);

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `prestamo_ibfk_1` FOREIGN KEY (`FK_CLIENT`) REFERENCES `client` (`ID`),
  ADD CONSTRAINT `prestamo_ibfk_2` FOREIGN KEY (`FK_FINANCIERA`) REFERENCES `financiera` (`ID`),
  ADD CONSTRAINT `prestamo_ibfk_3` FOREIGN KEY (`FK_AUTORIZADOR`) REFERENCES `user` (`ID`);

--
-- Filtros para la tabla `veraz`
--
ALTER TABLE `veraz`
  ADD CONSTRAINT `veraz_ibfk_1` FOREIGN KEY (`FK_PRESTAMO`) REFERENCES `prestamo` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
