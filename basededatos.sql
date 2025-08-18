-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-08-2025 a las 16:17:14
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
-- Base de datos: `basededatos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `ID_Administrador` int(11) NOT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `Tel` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`ID_Administrador`, `Correo`, `Tel`) VALUES
(1, 'admin1@gmail.com', '099876554'),
(2, 'admin2@gmail.com', '098765456'),
(3, 'admin3@gmail.com', '096875234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `ID_Consulta` int(11) NOT NULL,
  `Fecha_Consulta` date DEFAULT NULL,
  `Cedula_P` int(11) DEFAULT NULL,
  `ID_Especialidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`ID_Consulta`, `Fecha_Consulta`, `Cedula_P`, `ID_Especialidad`) VALUES
(34, '2025-06-04', 23456789, 1),
(67, '2025-06-05', 34567894, 2),
(70, '2025-06-05', 58791235, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctor`
--

CREATE TABLE `doctor` (
  `Cedula_D` int(11) NOT NULL,
  `ID_Administrador` int(11) DEFAULT NULL,
  `Nombre_D` varchar(50) DEFAULT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `His_med` varchar(1000) DEFAULT NULL,
  `Tel` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `doctor`
--

INSERT INTO `doctor` (`Cedula_D`, `ID_Administrador`, `Nombre_D`, `Correo`, `His_med`, `Tel`) VALUES
(54367989, 2, 'Jason Dematté', 'jasond45@gmail.com', 'Atendimientos: 13/4/2002 - 16/6/2004 - 25/11/2004', '093453269'),
(56784876, 1, 'Lucas Gómez', 'medlucasgom@gmail.com', 'Atendimientos: 15/8/2024 - 16/9/2024 - 25/1/2025', '097825637'),
(56789875, 1, 'Marcos Fernández', 'medmarcosfer@gmail.com', 'Atendimientos: 13/4/2004 - 16/6/2004 - 25/11/2004', '097835567');

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
  `Tel` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`Cedula_P`, `Nombre_P`, `Fecha_Nac`, `Sexo`, `Correo`, `His_med`, `Tel`) VALUES
(23456789, 'Pedro García', '1980-05-16', 'Hombre', 'padrito@gmail.com', 'blablablablablablabla', '097876543'),
(34567894, 'Martín López', '1989-06-06', 'Hombre', 'martincho12@gmail.com', 'Enfermedad: Sarampión 12/3/2014', '096784671'),
(57284529, 'Ramirito III de Ceibal el más viral', '2007-11-11', 'Masculino', 'ramiroo@gmail.com', 'Sida', '098657234'),
(57383315, 'belen', '2007-09-06', 'Femenino', 'bebel@gmail.com', 'cancer de mama', '0998787'),
(58791235, 'Juanita Martinez', '1970-12-09', 'Mujer', 'juanitamar4@gmail.com', 'Citas: 12/4/2017 - 12/4/2018 - 12/4/2019 - 12/4/2020 - 12/4/2021 - 12/4/2022', '092346578');

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
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `consulta_ibfk_1` FOREIGN KEY (`Cedula_P`) REFERENCES `paciente` (`Cedula_P`),
  ADD CONSTRAINT `consulta_ibfk_2` FOREIGN KEY (`ID_Especialidad`) REFERENCES `especialidad` (`ID_Especialidad`);

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
