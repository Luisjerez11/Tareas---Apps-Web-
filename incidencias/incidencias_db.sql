-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2026 a las 18:11:12
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
-- Base de datos: `incidencias_db`
--
CREATE DATABASE IF NOT EXISTS `incidencias_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `incidencias_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia`
--

CREATE TABLE `incidencia` (
  `id_incidencia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `prioridad` enum('alta','media','baja') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `clave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD PRIMARY KEY (`id_incidencia`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  MODIFY `id_incidencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD CONSTRAINT `incidencia_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Volcado de datos para la tabla `usuario`
-- (id_usuario se genera automáticamente)
--

INSERT INTO `usuario` (`nombre`, `clave`) VALUES
('oscar', '123'),
('maria', '456');

--
-- Volcado de datos para la tabla `incidencia`
-- (id_incidencia se genera automáticamente; id_usuario se obtiene por el nombre del usuario)
--

INSERT INTO `incidencia` (`id_usuario`, `nombre`, `descripcion`, `prioridad`) VALUES
((SELECT `id_usuario` FROM `usuario` WHERE `nombre` = 'oscar'), 'Impresora no imprime', 'La impresora del área de contabilidad no responde al enviar documentos.', 'media'),
((SELECT `id_usuario` FROM `usuario` WHERE `nombre` = 'oscar'), 'Sin acceso a internet', 'Los equipos del segundo piso no tienen conexión a internet desde la mañana.', 'alta'),
((SELECT `id_usuario` FROM `usuario` WHERE `nombre` = 'oscar'), 'Mouse dañado', 'El mouse del equipo de recepción no funciona correctamente.', 'baja'),
((SELECT `id_usuario` FROM `usuario` WHERE `nombre` = 'oscar'), 'Correo no sincroniza', 'El cliente de correo no descarga los mensajes nuevos.', 'media'),
((SELECT `id_usuario` FROM `usuario` WHERE `nombre` = 'oscar'), 'Servidor de archivos caído', 'No se puede acceder a la carpeta compartida del servidor.', 'alta'),
((SELECT `id_usuario` FROM `usuario` WHERE `nombre` = 'maria'), 'Pantalla parpadea', 'El monitor del equipo de ventas parpadea constantemente.', 'baja'),
((SELECT `id_usuario` FROM `usuario` WHERE `nombre` = 'maria'), 'Olvido de contraseña', 'Un usuario no puede ingresar al sistema contable por olvido de contraseña.', 'media'),
((SELECT `id_usuario` FROM `usuario` WHERE `nombre` = 'maria'), 'Virus detectado', 'El antivirus reporta una amenaza en el equipo de gerencia.', 'alta'),
((SELECT `id_usuario` FROM `usuario` WHERE `nombre` = 'maria'), 'Teclado sin respuesta', 'Algunas teclas del teclado de bodega no funcionan.', 'baja'),
((SELECT `id_usuario` FROM `usuario` WHERE `nombre` = 'maria'), 'Sistema de facturación lento', 'El sistema de facturación tarda varios minutos en generar facturas.', 'alta');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
