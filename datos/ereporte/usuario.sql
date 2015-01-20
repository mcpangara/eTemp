-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-10-2014 a las 01:08:38
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `eproyect`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` blob NOT NULL,
  `email` varchar(50) NOT NULL,
  `identificacion` varchar(11) NOT NULL,
  `idusuariocrea` int(11) NOT NULL,
  `fechacrea` date NOT NULL,
  `idusuarioedita` int(11) NOT NULL,
  `fechaedita` date NOT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `idempresa`, `username`, `password`, `email`, `identificacion`, `idusuariocrea`, `fechacrea`, `idusuarioedita`, `fechaedita`) VALUES
(3, 1, 'mcpangara', 0x8d0019970a9a5d07f2f5d4df5e9d24fb, 'mcpangara@gmail.com', '13495908', 1, '2014-10-20', 1, '2014-10-20');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
