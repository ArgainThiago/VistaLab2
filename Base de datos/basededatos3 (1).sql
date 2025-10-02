-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-10-2025 a las 03:22:44
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
-- Base de datos: `basededatos3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `ID_Administrador` int(11) NOT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `Tel` varchar(15) DEFAULT NULL,
  `Usuario_A` varchar(50) DEFAULT NULL,
  `Contraseña_A` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`ID_Administrador`, `Correo`, `Tel`, `Usuario_A`, `Contraseña_A`) VALUES
(1, 'admin1@gmail.com', '099876554', 'admin1', '4321'),
(2, 'admin2@gmail.com', '098765456', 'admin2', '321'),
(3, 'admin3@gmail.com', '096875234', 'admin3', '21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `ID_Consulta` int(11) NOT NULL,
  `Cedula_D` int(11) NOT NULL,
  `ID_Especialidad` int(11) NOT NULL,
  `Fecha_Consulta` date NOT NULL,
  `Horario` time NOT NULL,
  `Cedula_P` int(11) DEFAULT NULL,
  `Estado` enum('Disponible','Ocupado','Cancelado') NOT NULL DEFAULT 'Disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`ID_Consulta`, `Cedula_D`, `ID_Especialidad`, `Fecha_Consulta`, `Horario`, `Cedula_P`, `Estado`) VALUES
(1, 54367989, 1, '2025-09-06', '09:00:00', NULL, 'Disponible'),
(2, 54367989, 1, '2025-09-06', '09:30:00', 23456789, 'Ocupado'),
(3, 54367989, 1, '2025-09-06', '10:00:00', NULL, 'Disponible'),
(4, 56784876, 2, '2025-10-03', '18:25:00', 34567894, 'Ocupado'),
(5, 56789875, 3, '2025-09-06', '14:30:00', NULL, 'Disponible'),
(6, 54367989, 1, '2025-09-09', '11:00:00', 23456789, 'Ocupado'),
(7, 54367989, 1, '2025-09-09', '08:00:00', 23456789, 'Ocupado'),
(8, 56784876, 2, '2025-10-01', '16:00:00', 23456789, 'Ocupado'),
(9, 54367989, 1, '2025-09-20', '15:00:00', 23456789, 'Ocupado'),
(10, 54367989, 1, '2025-09-11', '09:00:00', 23456789, 'Ocupado'),
(12, 54367989, 1, '2025-09-28', '11:00:00', 34567894, 'Ocupado'),
(13, 56789875, 3, '2025-09-27', '15:00:00', 34567894, 'Ocupado'),
(14, 56789875, 3, '2025-09-30', '09:00:00', 34567894, 'Cancelado'),
(15, 56784876, 2, '2025-09-28', '17:00:00', 34567894, 'Disponible'),
(16, 56784876, 2, '2025-09-29', '17:00:00', 34567894, 'Disponible'),
(17, 56784876, 2, '2025-10-31', '11:00:00', 57383315, 'Ocupado'),
(18, 56784876, 2, '2025-10-12', '15:00:00', 34567894, 'Disponible'),
(19, 56784876, 2, '2025-09-30', '17:00:00', 34567894, 'Ocupado'),
(20, 56784876, 2, '2025-10-31', '10:00:00', 34567894, 'Ocupado'),
(21, 56784876, 2, '2026-01-01', '15:00:00', 34567894, 'Disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctor`
--

CREATE TABLE `doctor` (
  `Cedula_D` int(11) NOT NULL,
  `Nombre_D` varchar(50) DEFAULT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `His_med` varchar(1000) DEFAULT NULL,
  `Tel` varchar(15) DEFAULT NULL,
  `Contraseña_D` varchar(10) DEFAULT NULL,
  `ID_Administrador` int(11) DEFAULT NULL,
  `Usuario_D` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `doctor`
--

INSERT INTO `doctor` (`Cedula_D`, `Nombre_D`, `Correo`, `His_med`, `Tel`, `Contraseña_D`, `ID_Administrador`, `Usuario_D`) VALUES
(57746, 'Juncho', 'si@gmail.com', 'nada', '09881234', '1234', 3, 'jucho'),
(54367989, 'Jason Dematté', 'jasond45@gmail.com', 'Atendimientos: 13/4/2002 - 16/6/2004 - 25/11/2004', '093453269', '1234', 2, 'jason'),
(56784876, 'Lucas Gómez', 'medlucasgom@gmail.com', 'Atendimientos: 15/8/2024 - 16/9/2024 - 25/1/2025', '097825637', '1234', 1, 'lucas'),
(56789875, 'Marcos Fernández', 'medmarcosfer@gmail.com', 'Atendimientos: 13/4/2004 - 16/6/2004 - 25/11/2004', '097835567', '12345', 1, 'marcos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `ID_Especialidad` int(11) NOT NULL,
  `Nom_Especialidad` varchar(100) DEFAULT NULL,
  `Cedula_D` int(11) DEFAULT NULL,
  `Descripcion` varchar(1000) DEFAULT NULL,
  `Fecha_Esp` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`ID_Especialidad`, `Nom_Especialidad`, `Cedula_D`, `Descripcion`, `Fecha_Esp`) VALUES
(1, 'Cardiología', 54367989, 'Se enfoca en el estudio, diagnóstico y tratamiento de enfermedades del corazón y los vasos sanguíneos', '2001-03-04'),
(2, 'Quiropraccia', 56784876, 'Se dedica al estudio, diagnóstico y tratamiento de enfermedades de la piel, cabello y uñas', '2000-03-07'),
(3, 'Otorrinolaringología', 56789875, 'Se enfoca en el estudio y tratamiento de las enfermedades del oído, nariz, garganta y estructuras relacionadas de la cabeza y cuello', '2004-02-08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `Cedula_P` int(11) NOT NULL,
  `Nombre_P` varchar(100) DEFAULT NULL,
  `Fecha_Nac` date DEFAULT NULL,
  `Sexo` varchar(10) DEFAULT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `His_med` varchar(1000) DEFAULT NULL,
  `Tel` varchar(15) DEFAULT NULL,
  `Contraseña_P` varchar(10) DEFAULT NULL,
  `Usuario_P` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`Cedula_P`, `Nombre_P`, `Fecha_Nac`, `Sexo`, `Correo`, `His_med`, `Tel`, `Contraseña_P`, `Usuario_P`) VALUES
(23456789, 'Pedro García', '1980-05-16', 'Hombre', 'padrito@gmail.com', 'blablablablablablabla', '097876543', '23415', 'pedro'),
(34567894, 'Martín López', '1989-06-06', 'Hombre', 'martincho12@gmail.com', 'Enfermedad: Sarampión 12/3/2014', '096784671', '1231', 'martin'),
(57284529, 'Ramirito 123', '2007-11-11', 'Masculino', 'ramiroo@gmail.com', 'Sano (por ahora)', '098657234', '33234', 'Ramiro'),
(57383315, 'belecita', '2007-09-06', 'Femenino', 'bebel@gmail.com', 'nada', '0998787', '34321', 'Belen');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`ID_Administrador`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`ID_Consulta`),
  ADD KEY `Cedula_D` (`Cedula_D`),
  ADD KEY `Cedula_P` (`Cedula_P`),
  ADD KEY `ID_Especialidad` (`ID_Especialidad`);

--
-- Indices de la tabla `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`Cedula_D`),
  ADD KEY `ID_Administrador` (`ID_Administrador`);

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`ID_Especialidad`),
  ADD KEY `Cedula_D` (`Cedula_D`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`Cedula_P`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `ID_Administrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `ID_Consulta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `ID_Especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `consulta_ibfk_1` FOREIGN KEY (`Cedula_D`) REFERENCES `doctor` (`Cedula_D`),
  ADD CONSTRAINT `consulta_ibfk_2` FOREIGN KEY (`Cedula_P`) REFERENCES `paciente` (`Cedula_P`),
  ADD CONSTRAINT `consulta_ibfk_3` FOREIGN KEY (`ID_Especialidad`) REFERENCES `especialidad` (`ID_Especialidad`);

--
-- Filtros para la tabla `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`ID_Administrador`) REFERENCES `administrador` (`ID_Administrador`);

--
-- Filtros para la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD CONSTRAINT `especialidad_ibfk_1` FOREIGN KEY (`Cedula_D`) REFERENCES `doctor` (`Cedula_D`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
