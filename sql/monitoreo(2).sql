-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 26-02-2020 a las 14:46:38
-- Versión del servidor: 5.6.43
-- Versión de PHP: 7.2.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `monitoreo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alcanzados`
--

CREATE TABLE `alcanzados` (
  `id_cedula_persona_receptora` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_alcanzado` date NOT NULL,
  `region_de_salud` enum('Bocas_del_Toro','Chiriquí','Coclé','Colón','Herrera','Los_Santos','Panamá_Metro','Panamá_Oeste_1','Panamá_Oeste_2','San_Miguelito','Veraguas') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `alcanzados`
--

INSERT INTO `alcanzados` (`id_cedula_persona_receptora`, `fecha_alcanzado`, `region_de_salud`) VALUES
('20202020', '2019-11-22', 'Bocas_del_Toro'),
('2222222', '2019-11-22', 'Colón'),
('31433333', '2019-11-22', 'Bocas_del_Toro'),
('3331333', '2019-11-22', 'Coclé'),
('3332333', '2019-11-22', 'Panamá_Oeste_2'),
('75757575', '2020-02-20', 'Herrera'),
('76767676', '2020-02-20', 'San_Miguelito'),
('78787878', '2020-02-20', 'Los_Santos'),
('79797979', '2020-02-20', 'Los_Santos'),
('80808080', '2020-02-20', 'Los_Santos'),
('81818181', '2020-02-20', 'Los_Santos'),
('82828282', '2020-02-20', 'Los_Santos'),
('83838383', '2020-02-20', 'San_Miguelito'),
('84848484', '2020-02-20', 'San_Miguelito'),
('85858585', '2020-02-20', 'Veraguas'),
('86868686', '2020-02-20', 'Veraguas'),
('87878787', '2020-02-20', 'Chiriquí'),
('89898989', '2020-02-20', 'Chiriquí'),
('91919191', '2020-02-20', 'Herrera'),
('92929292', '2020-02-20', 'Veraguas'),
('93939393', '2020-02-20', 'San_Miguelito'),
('94949494', '2020-02-20', 'Chiriquí'),
('95959595', '2020-02-20', 'Los_Santos'),
('96969696', '2020-02-20', 'San_Miguelito'),
('97979797', '2020-02-20', 'Chiriquí'),
('98989898', '2020-02-20', 'Chiriquí');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona_receptora`
--

CREATE TABLE `persona_receptora` (
  `id_cedula_persona_receptora` varchar(12) COLLATE utf8_spanish_ci NOT NULL COMMENT 'número de cedula',
  `poblacion_originaria` tinyint(1) NOT NULL COMMENT 'perteneciente a un grupo de población indígena',
  `poblacion` enum('HSH','TSF','TRANS','') CHARACTER SET utf8 NOT NULL COMMENT 'grupo en el que se identifica',
  `datos_actualizados` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `persona_receptora`
--

INSERT INTO `persona_receptora` (`id_cedula_persona_receptora`, `poblacion_originaria`, `poblacion`, `datos_actualizados`) VALUES
('111111111', 1, 'TSF', '2019-10-10 18:16:56'),
('1111199', 1, 'HSH', '2020-02-14 21:56:42'),
('1212121212', 1, 'HSH', '2019-10-10 18:20:33'),
('12131415', 1, 'TSF', '2020-02-09 15:42:50'),
('12345678', 1, 'HSH', '2019-10-10 18:13:58'),
('1313131', 1, 'TSF', '2019-11-11 04:26:16'),
('13131313', 1, 'HSH', '2019-11-18 09:20:51'),
('13141516', 1, 'TRANS', '2020-02-09 15:43:47'),
('1515151', 1, 'HSH', '2019-11-20 21:17:57'),
('15151515', 1, 'TRANS', '2020-02-09 16:16:52'),
('15151518', 1, 'HSH', '2020-02-09 15:41:59'),
('16161616', 0, 'TRANS', '2019-11-20 23:03:47'),
('18181818', 1, 'TSF', '2020-02-09 16:27:34'),
('20202020', 1, 'TRANS', '2019-10-18 23:26:04'),
('21212121', 1, 'TSF', '2020-02-09 16:31:04'),
('2222222', 1, 'HSH', '2019-10-11 23:39:57'),
('31433333', 0, 'TSF', '2019-10-10 18:15:02'),
('3331333', 1, 'HSH', '2019-11-22 00:22:35'),
('3332333', 1, 'TSF', '2019-11-22 00:24:18'),
('3333333', 1, 'HSH', '2019-10-11 23:40:57'),
('34343434', 1, 'TSF', '2020-02-14 13:43:38'),
('35353535', 1, 'TSF', '2020-02-14 13:43:38'),
('4141414', 1, 'HSH', '2019-11-18 09:23:49'),
('4441444', 1, 'HSH', '2019-11-22 00:04:15'),
('44444444', 1, 'HSH', '2019-10-12 23:30:43'),
('44444555', 1, 'HSH', '2020-02-09 16:53:34'),
('4fwf62y', 0, 'TSF', '2020-02-14 22:13:00'),
('55555555', 1, 'HSH', '2019-10-12 23:31:29'),
('6666666', 1, 'HSH', '2019-11-15 02:40:56'),
('75757575', 1, 'HSH', '2020-02-20 16:33:46'),
('76767676', 1, 'HSH', '2020-02-20 16:31:54'),
('7771777', 0, 'TSF', '2019-11-15 20:54:56'),
('7772777', 1, 'TSF', '2019-11-15 21:09:59'),
('7773777', 1, 'HSH', '2020-01-27 05:00:00'),
('7774777', 1, 'TRANS', '2020-01-27 05:00:00'),
('7777777', 1, 'HSH', '2019-11-15 03:01:35'),
('78787878', 1, 'TRANS', '2020-02-20 14:52:40'),
('79797979', 0, 'TRANS', '2020-02-20 14:52:06'),
('80808080', 0, 'HSH', '2020-02-20 14:50:10'),
('81818181', 0, 'HSH', '2020-02-20 14:48:44'),
('82828282', 1, 'HSH', '2020-02-20 14:48:08'),
('83838383', 1, 'HSH', '2020-02-20 14:47:17'),
('84848484', 1, 'HSH', '2020-02-20 14:46:21'),
('85858585', 1, 'TSF', '2020-02-20 14:45:28'),
('86868686', 0, 'TSF', '2020-02-20 14:44:48'),
('87878787', 1, 'TRANS', '2020-02-20 14:44:09'),
('8888888', 0, 'TSF', '2019-11-15 20:51:41'),
('88888888', 1, 'TRANS', '2019-10-19 21:29:59'),
('89898989', 1, 'TRANS', '2020-02-20 14:41:30'),
('91919191', 1, 'TRANS', '2020-02-20 13:58:48'),
('92929292', 0, 'TSF', '2020-02-20 13:59:39'),
('93939393', 1, 'HSH', '2020-02-20 14:00:29'),
('94949494', 1, 'TRANS', '2020-02-20 14:01:23'),
('95959595', 1, 'TSF', '2020-02-20 14:38:14'),
('96969696', 1, 'HSH', '2020-02-20 14:38:59'),
('97979797', 1, 'TRANS', '2020-02-20 14:39:59'),
('98989898', 1, 'TRANS', '2020-02-20 14:40:33'),
('99999999', 1, 'TRANS', '2019-10-19 21:28:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promotor`
--

CREATE TABLE `promotor` (
  `id_usuario` int(11) NOT NULL,
  `id_subreceptor` int(11) NOT NULL,
  `id_cedula` varchar(12) CHARACTER SET utf8 NOT NULL,
  `organizacion` varchar(20) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `promotor`
--

INSERT INTO `promotor` (`id_usuario`, `id_subreceptor`, `id_cedula`, `organizacion`) VALUES
(17, 15, '22222222', 'subreceptor Panama'),
(20, 19, '4257383', 'Viviendo Positivamen'),
(31, 15, '54654654', 'subreceptor Panama');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promotor_realiza_actividad_grupal_con_personas_receptoras`
--

CREATE TABLE `promotor_realiza_actividad_grupal_con_personas_receptoras` (
  `id_promotor` int(11) NOT NULL,
  `id_cedula_persona_receptora` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `region_de_salud` enum('Bocas_del_Toro','Chiriquí','Coclé','Colón','Herrera','Los_Santos','Panamá_Metro','Panamá_Oeste_1','Panamá_Oeste_2','San_Miguelito','Veraguas') COLLATE utf8_spanish_ci NOT NULL,
  `area` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `estilos_autocuidado` tinyint(1) NOT NULL,
  `ddhh_estigma_discriminacion` tinyint(1) NOT NULL,
  `uso_correcto_y_constantes_del_condon` tinyint(1) NOT NULL,
  `salud_sexual_e_ITS` tinyint(1) NOT NULL,
  `ofrecimiento_y_referencia_a_la_prueba_de_VIH` tinyint(1) NOT NULL,
  `CLAM_y_otros_servicios` tinyint(1) NOT NULL,
  `salud_anal` tinyint(1) NOT NULL,
  `hormonizacion` tinyint(1) NOT NULL,
  `apoyo_y_orientacion_psicologico` tinyint(1) NOT NULL,
  `diversidad_sexual_identidad_expresion_de_genero` tinyint(1) NOT NULL,
  `tuberculosis_y_coinfecciones` tinyint(1) NOT NULL,
  `infecciones_oportunistas` tinyint(1) NOT NULL,
  `condones_entregados` int(11) DEFAULT NULL,
  `lubricantes_entregados` int(11) DEFAULT NULL,
  `materiales_educativos_entregados` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `promotor_realiza_actividad_grupal_con_personas_receptoras`
--

INSERT INTO `promotor_realiza_actividad_grupal_con_personas_receptoras` (`id_promotor`, `id_cedula_persona_receptora`, `fecha`, `region_de_salud`, `area`, `estilos_autocuidado`, `ddhh_estigma_discriminacion`, `uso_correcto_y_constantes_del_condon`, `salud_sexual_e_ITS`, `ofrecimiento_y_referencia_a_la_prueba_de_VIH`, `CLAM_y_otros_servicios`, `salud_anal`, `hormonizacion`, `apoyo_y_orientacion_psicologico`, `diversidad_sexual_identidad_expresion_de_genero`, `tuberculosis_y_coinfecciones`, `infecciones_oportunistas`, `condones_entregados`, `lubricantes_entregados`, `materiales_educativos_entregados`) VALUES
(17, '111111111', '2019-10-10', 'Bocas_del_Toro', 'Panama', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1),
(17, '111111111', '2019-10-16', 'Panamá_Metro', 'Panama', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 2),
(17, '1212121212', '2019-10-10', 'Bocas_del_Toro', 'Panama', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1),
(17, '1212121212', '2019-11-14', 'Bocas_del_Toro', 'Bocas', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 50, 50, 50),
(17, '12345678', '2019-10-10', 'Bocas_del_Toro', 'Panama', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1),
(17, '12345678', '2019-11-22', 'Bocas_del_Toro', 'Colegio', 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 2, 2, 2),
(17, '1313131', '2019-11-10', 'Colón', 'Colon', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 5, 5, 5),
(17, '1313131', '2019-11-14', 'Colón', 'Colon', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 10, 10),
(17, '20202020', '2019-10-18', 'Bocas_del_Toro', 'Bocas', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20, 20, 20),
(17, '20202020', '2019-11-22', 'Bocas_del_Toro', 'Hospital', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1),
(17, '2222222', '2019-10-11', 'Panamá_Metro', 'Panama', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 8, 8, 8),
(17, '2222222', '2019-10-18', 'Bocas_del_Toro', 'Bocas', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 5, 35),
(17, '31433333', '2019-10-18', 'Bocas_del_Toro', 'Bocas', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6, 7, 8),
(17, '31433333', '2019-11-14', 'Bocas_del_Toro', 'Bocas', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1),
(17, '31433333', '2019-11-22', 'Bocas_del_Toro', 'Hospital', 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 39, 39, 39),
(17, '3331333', '2019-11-21', 'Coclé', 'Calle', 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 20, 20, 20),
(17, '3332333', '2019-11-21', 'Herrera', 'Escuela', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 39, 39, 39),
(17, '3333333', '2019-10-19', 'Panamá_Oeste_1', 'Panama', 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 1, 22, 22, 22),
(17, '34343434', '2020-02-14', 'Bocas_del_Toro', 'Mercado', 0, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 15, 15, 15),
(17, '35353535', '2020-02-14', 'Bocas_del_Toro', 'Mercado', 0, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 15, 15, 15),
(17, '4141414', '2019-11-17', 'Chiriquí', 'Chiriqui', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20, 20, 20),
(17, '44444444', '2019-10-12', 'Panamá_Metro', 'Panama', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1),
(17, '44444444', '2019-10-18', 'Bocas_del_Toro', 'Bocas', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 9, 9, 9),
(17, '55555555', '2019-10-12', 'Panamá_Metro', 'Panama', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 30, 30, 30),
(17, '76767676', '2020-02-20', 'San_Miguelito', 'Cantina', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 23, 23, 23),
(17, '7771777', '2019-11-15', 'Bocas_del_Toro', 'Gogol', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 10, 10),
(17, '7774777', '2020-01-27', 'Bocas_del_Toro', 'Bar', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 35, 35, 35),
(17, '78787878', '2020-02-20', 'Los_Santos', 'Farmacia', 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 25, 25, 25),
(17, '79797979', '2020-02-20', 'Los_Santos', 'Farmacia', 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 25, 25, 25),
(17, '80808080', '2020-02-20', 'Los_Santos', 'Bar', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15, 15, 15),
(17, '81818181', '2020-02-20', 'Los_Santos', 'Bar', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15, 15, 15),
(17, '82828282', '2020-02-20', 'Los_Santos', 'Bar', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15, 15, 15),
(17, '83838383', '2020-02-20', 'San_Miguelito', 'Cantina', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 34, 34, 34),
(17, '84848484', '2020-02-20', 'San_Miguelito', 'Cantina', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 34, 34, 34),
(17, '85858585', '2020-02-20', 'Veraguas', 'Plaza', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 34, 34, 34),
(17, '86868686', '2020-02-20', 'Veraguas', 'Plaza', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 34, 34, 34),
(17, '87878787', '2020-02-20', 'Chiriquí', 'Bar', 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 34, 34, 34),
(17, '88888888', '2019-10-19', 'Herrera', 'Los santos', 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1),
(17, '88888888', '2019-11-10', 'Panamá_Oeste_1', 'Panama', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 2),
(17, '89898989', '2020-02-20', 'Chiriquí', 'Bar', 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 34, 34, 34),
(17, '91919191', '2020-02-20', 'Herrera', 'Bar', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15, 15, 15),
(17, '92929292', '2020-02-20', 'Veraguas', 'Plaza', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 34, 34, 34),
(17, '93939393', '2020-02-20', 'San_Miguelito', 'Cantina', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 34, 34, 34),
(17, '94949494', '2020-02-20', 'Chiriquí', 'Bar', 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 34, 34, 34),
(17, '95959595', '2020-02-20', 'Los_Santos', 'Plaza', 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 24, 24, 24),
(17, '96969696', '2020-02-20', 'San_Miguelito', 'Cantina', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 34, 34, 34),
(17, '97979797', '2020-02-20', 'Chiriquí', 'Bar', 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 34, 34, 34),
(17, '98989898', '2020-02-20', 'Chiriquí', 'Bar', 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 34, 34, 34),
(17, '99999999', '2019-10-19', 'Coclé', 'Cocle', 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(17, '99999999', '2019-11-14', 'Bocas_del_Toro', 'Bocas', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1),
(20, '75757575', '2020-02-20', 'Herrera', 'Bar', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 15, 15, 15),
(20, '92929292', '2020-02-20', 'Coclé', 'Bar', 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0);

--
-- Disparadores `promotor_realiza_actividad_grupal_con_personas_receptoras`
--
DELIMITER $$
CREATE TRIGGER `alcanzado_grupal` AFTER INSERT ON `promotor_realiza_actividad_grupal_con_personas_receptoras` FOR EACH ROW BEGIN

	DECLARE total_condones INTEGER;
	DECLARE total_lubricantes INTEGER;
	DECLARE total_materiales INTEGER;
    DECLARE min_valor INTEGER default 40;
       
    
	IF NEW.`id_cedula_persona_receptora` in (
		SELECT id_cedula_persona_receptora
		FROM `promotor_realiza_actividad_grupal_con_personas_receptoras`
	)
	THEN  
		SET total_condones = (
			select sum(condones_entregados)
			from promotor_realiza_actividad_grupal_con_personas_receptoras
			where id_cedula_persona_receptora = NEW.id_cedula_persona_receptora
		)
        + 
        (
			select sum(condones_entregados)
			from promotor_realiza_entrevista_individual
			where id_cedula_persona_receptora = NEW.id_cedula_persona_receptora
        );
        
	
		SET total_lubricantes = (
			select sum(lubricantes_entregados)
			from promotor_realiza_actividad_grupal_con_personas_receptoras
			where id_cedula_persona_receptora = NEW.id_cedula_persona_receptora
		)
        + 
        (
			select sum(lubricantes_entregados)
			from promotor_realiza_entrevista_individual
			where id_cedula_persona_receptora = NEW.id_cedula_persona_receptora
        );
     
     
        SET total_materiales = (
			select sum(materiales_educativos_entregados)
			from promotor_realiza_actividad_grupal_con_personas_receptoras
			where id_cedula_persona_receptora = NEW.id_cedula_persona_receptora
		)
        + 
        (
			select sum(materiales_educativos_entregados)
			from promotor_realiza_entrevista_individual
			where id_cedula_persona_receptora = NEW.id_cedula_persona_receptora
        );
        
        IF (total_condones >= min_valor AND total_lubricantes >= min_valor AND total_materiales >= min_valor )
        THEN
			INSERT INTO alcanzados (id_cedula_persona_receptora, fecha_alcanzado, region_de_salud)
            VALUES (NEW.id_cedula_persona_receptora, now(), NEW.region_de_salud);
		END IF;
        
	END IF;
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promotor_realiza_entrevista_individual`
--

CREATE TABLE `promotor_realiza_entrevista_individual` (
  `id_promotor` int(11) NOT NULL,
  `id_cedula_persona_receptora` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `region_de_salud` enum('Bocas_del_Toro','Chiriquí','Coclé','Colón','Herrera','Los_Santos','Panamá_Metro','Panamá_Oeste_1','Panamá_Oeste_2','San_Miguelito','Veraguas') COLLATE utf8_spanish_ci NOT NULL,
  `area` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `uso_del_condon` tinyint(1) DEFAULT NULL,
  `uso_de_alcohol_y_drogas_ilicitas` tinyint(1) DEFAULT NULL,
  `informacion_CLAM` tinyint(1) DEFAULT NULL,
  `referencia_a_prueba_de_VIH` tinyint(1) DEFAULT NULL,
  `referencia_a_clinica_TB` tinyint(1) DEFAULT NULL,
  `condones_entregados` int(11) DEFAULT NULL,
  `lubricantes_entregados` int(11) DEFAULT NULL,
  `materiales_educativos_entregados` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='entrevista individual a individuos. Formulario 1';

--
-- Volcado de datos para la tabla `promotor_realiza_entrevista_individual`
--

INSERT INTO `promotor_realiza_entrevista_individual` (`id_promotor`, `id_cedula_persona_receptora`, `fecha`, `region_de_salud`, `area`, `uso_del_condon`, `uso_de_alcohol_y_drogas_ilicitas`, `informacion_CLAM`, `referencia_a_prueba_de_VIH`, `referencia_a_clinica_TB`, `condones_entregados`, `lubricantes_entregados`, `materiales_educativos_entregados`) VALUES
(17, '111111111', '2019-10-10', 'Bocas_del_Toro', '', 1, 0, 1, 0, 0, 0, 0, 0),
(17, '111111111', '2019-10-16', 'Bocas_del_Toro', '', 0, 0, 0, 1, 1, 39, 39, 39),
(17, '111111111', '2019-11-22', 'Bocas_del_Toro', '', 0, 0, 1, 0, 0, 1, 1, 1),
(17, '1111199', '2020-02-14', 'Bocas_del_Toro', 'Hospital', 0, 0, 0, 0, 0, 5, 5, 5),
(17, '1212121212', '2019-10-15', 'Bocas_del_Toro', '', 1, 0, 0, 0, 0, 40, 40, 40),
(17, '1212121212', '2019-10-18', 'Bocas_del_Toro', '', 1, 1, 1, 1, 1, 4, 4, 4),
(17, '12131415', '2020-02-09', 'Bocas_del_Toro', 'Bar', 1, 1, 0, 1, 0, 35, 35, 36),
(17, '12345678', '2019-10-10', 'Bocas_del_Toro', '', 1, 1, 1, 1, 1, 5, 5, 5),
(17, '12345678', '2019-10-16', 'Bocas_del_Toro', '', 0, 0, 1, 1, 0, 35, 35, 35),
(17, '1313131', '2019-11-10', 'Bocas_del_Toro', '', 1, 1, 1, 1, 1, 5, 5, 5),
(17, '1313131', '2019-11-14', 'Bocas_del_Toro', '', 0, 0, 1, 0, 0, 5, 5, 5),
(17, '1313131', '2019-11-22', 'Panamá_Oeste_1', '', 0, 0, 1, 0, 0, 15, 15, 15),
(17, '13141516', '2020-02-09', 'Bocas_del_Toro', 'Bar', 0, 1, 0, 0, 0, 34, 34, 34),
(17, '15151515', '2020-02-09', 'Bocas_del_Toro', 'Bar', 0, 0, 1, 0, 0, 12, 12, 12),
(17, '15151518', '2020-02-09', 'Bocas_del_Toro', 'Bar', 0, 0, 0, 0, 0, 30, 30, 30),
(17, '16161616', '2019-11-20', 'Chiriquí', '', 0, 1, 1, 0, 0, 2, 2, 2),
(17, '18181818', '2020-02-09', 'Bocas_del_Toro', 'Escuela', 0, 0, 0, 1, 0, 15, 15, 15),
(17, '20202020', '2019-10-18', 'Bocas_del_Toro', '', 1, 1, 1, 1, 1, 20, 20, 20),
(17, '21212121', '2020-02-09', 'Bocas_del_Toro', 'Plaza Mayor', 0, 0, 0, 1, 0, 13, 13, 13),
(17, '2222222', '2019-10-11', 'Bocas_del_Toro', '', 1, 1, 0, 0, 0, 1, 0, 0),
(17, '2222222', '2019-10-17', 'Bocas_del_Toro', '', 0, 0, 0, 0, 0, 20, 20, 20),
(17, '2222222', '2019-11-22', 'Colón', '', 1, 0, 0, 0, 0, 20, 20, 20),
(17, '31433333', '2019-10-10', 'Bocas_del_Toro', '', 1, 0, 0, 0, 0, 1, 1, 1),
(17, '31433333', '2019-10-19', 'Bocas_del_Toro', '', 0, 0, 1, 1, 1, 3, 2, 1),
(17, '3331333', '2019-11-21', 'Herrera', '', 1, 0, 0, 0, 0, 25, 25, 25),
(17, '3331333', '2019-11-22', 'Coclé', '', 1, 0, 0, 0, 0, 1, 1, 1),
(17, '3332333', '2019-11-21', 'Herrera', '', 1, 0, 0, 0, 0, 50, 50, 50),
(17, '3332333', '2019-11-22', 'Panamá_Oeste_2', '', 0, 0, 1, 0, 0, 2, 2, 2),
(17, '3333333', '2019-10-11', 'Bocas_del_Toro', '', 1, 0, 0, 0, 0, 22, 2, 2),
(17, '4141414', '2019-11-17', 'Chiriquí', '', 1, 0, 0, 0, 0, 21, 21, 21),
(17, '4441444', '2019-11-21', 'Bocas_del_Toro', '', 0, 1, 0, 0, 0, 5, 5, 5),
(17, '44444444', '2019-10-12', 'Bocas_del_Toro', '', 1, 0, 0, 0, 0, 50, 50, 50),
(17, '44444555', '2020-02-09', 'Bocas_del_Toro', 'Colegio', 0, 0, 1, 0, 0, 1, 1, 1),
(17, '55555555', '2019-10-12', 'Bocas_del_Toro', '', 1, 0, 0, 0, 0, 15, 15, 15),
(17, '7771777', '2019-11-15', 'Bocas_del_Toro', '', 1, 0, 0, 0, 0, 5, 5, 5),
(17, '7773777', '2020-01-27', 'Bocas_del_Toro', '', 0, 0, 0, 0, 0, 35, 35, 35),
(17, '7777777', '2019-11-15', 'Bocas_del_Toro', '', 0, 1, 0, 0, 0, 5, 5, 5),
(17, '88888888', '2019-10-19', 'Bocas_del_Toro', '', 1, 1, 1, 1, 1, 4, 4, 4),
(17, '88888888', '2019-11-08', 'Bocas_del_Toro', '', 0, 0, 1, 0, 0, 1, 1, 1),
(17, '91919191', '2020-02-20', 'Chiriquí', 'Plaza', 1, 0, 0, 1, 0, 25, 25, 25),
(17, '92929292', '2020-02-20', 'Coclé', 'Bar', 0, 1, 1, 0, 0, 25, 25, 25),
(17, '93939393', '2020-02-20', 'Colón', 'CLAM', 0, 0, 0, 1, 0, 25, 25, 25),
(17, '94949494', '2020-02-20', 'Herrera', 'Farmacia', 1, 0, 0, 0, 0, 25, 25, 25),
(17, '99999999', '2019-10-19', 'Bocas_del_Toro', '', 1, 0, 1, 1, 1, 75, 75, 75),
(17, '99999999', '2019-11-14', 'Bocas_del_Toro', '', 0, 1, 0, 0, 0, 4, 4, 4),
(20, '75757575', '2020-02-20', 'Panamá_Metro', 'Bar', 1, 0, 0, 0, 0, 34, 34, 34),
(20, '76767676', '2020-02-20', 'Panamá_Metro', 'Bar', 1, 0, 0, 0, 0, 34, 34, 34),
(20, '78787878', '2020-02-20', 'Los_Santos', 'Bar', 1, 1, 0, 0, 0, 25, 25, 25),
(20, '79797979', '2020-02-20', 'Los_Santos', 'Bar', 0, 1, 0, 0, 0, 25, 25, 25),
(20, '80808080', '2020-02-20', 'Los_Santos', 'Bar', 0, 0, 0, 1, 1, 25, 25, 25),
(20, '81818181', '2020-02-20', 'Los_Santos', 'Bar', 1, 1, 0, 0, 0, 25, 25, 25),
(20, '82828282', '2020-02-20', 'Los_Santos', 'Bar', 1, 0, 0, 0, 0, 25, 25, 25),
(20, '83838383', '2020-02-20', 'Panamá_Oeste_1', 'Bar', 0, 1, 0, 0, 0, 25, 25, 25),
(20, '84848484', '2020-02-20', 'Panamá_Oeste_1', 'Bar', 0, 0, 1, 0, 0, 26, 25, 25),
(20, '85858585', '2020-02-20', 'Veraguas', 'Super', 1, 0, 1, 0, 0, 25, 25, 25),
(20, '86868686', '2020-02-20', 'Veraguas', 'Bar', 0, 0, 0, 1, 0, 25, 25, 25),
(20, '87878787', '2020-02-20', 'Veraguas', 'Bar', 0, 0, 0, 1, 1, 25, 25, 25),
(20, '89898989', '2020-02-20', 'San_Miguelito', 'Farmacia', 1, 1, 0, 0, 0, 25, 25, 25),
(20, '95959595', '2020-02-20', 'Los_Santos', 'Bar', 1, 1, 1, 0, 0, 25, 25, 25),
(20, '96969696', '2020-02-20', 'Panamá_Metro', 'Bar', 0, 0, 0, 1, 1, 25, 25, 25),
(20, '97979797', '2020-02-20', 'Panamá_Oeste_1', 'Farmacia', 0, 0, 0, 1, 1, 26, 25, 25),
(20, '98989898', '2020-02-20', 'Panamá_Oeste_2', 'Farmacia', 0, 1, 0, 0, 0, 25, 25, 25);

--
-- Disparadores `promotor_realiza_entrevista_individual`
--
DELIMITER $$
CREATE TRIGGER `alcanzado_individual` AFTER INSERT ON `promotor_realiza_entrevista_individual` FOR EACH ROW BEGIN

	DECLARE total_condones INTEGER;
	DECLARE total_lubricantes INTEGER;
	DECLARE total_materiales INTEGER;
    DECLARE min_valor INTEGER default 40;
    
	IF NEW.`id_cedula_persona_receptora` in (
		SELECT id_cedula_persona_receptora
		FROM `promotor_realiza_actividad_grupal_con_personas_receptoras`
	)
	THEN  
		SET total_condones = (
			select sum(condones_entregados)
			from promotor_realiza_actividad_grupal_con_personas_receptoras
			where id_cedula_persona_receptora = NEW.id_cedula_persona_receptora
		)
        + 
        (
			select sum(condones_entregados)
			from promotor_realiza_entrevista_individual
			where id_cedula_persona_receptora = NEW.id_cedula_persona_receptora
        );
        
	
		SET total_lubricantes = (
			select sum(lubricantes_entregados)
			from promotor_realiza_actividad_grupal_con_personas_receptoras
			where id_cedula_persona_receptora = NEW.id_cedula_persona_receptora
		)
        + 
        (
			select sum(lubricantes_entregados)
			from promotor_realiza_entrevista_individual
			where id_cedula_persona_receptora = NEW.id_cedula_persona_receptora
        );
        
        
        SET total_materiales = (
			select sum(materiales_educativos_entregados)
			from promotor_realiza_actividad_grupal_con_personas_receptoras
			where id_cedula_persona_receptora = NEW.id_cedula_persona_receptora
		)
        + 
        (
			select sum(materiales_educativos_entregados)
			from promotor_realiza_entrevista_individual
			where id_cedula_persona_receptora = NEW.id_cedula_persona_receptora
        );
        
        IF (total_condones >= min_valor AND total_lubricantes >= min_valor AND total_materiales >= min_valor )
        THEN
        
			INSERT INTO alcanzados (id_cedula_persona_receptora, fecha_alcanzado, id_subreceptor, region_de_salud)
            VALUES (NEW.id_cedula_persona_receptora, now(), id_subreceptor, NEW.region_de_salud);
		END IF;
	END IF;
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subreceptor`
--

CREATE TABLE `subreceptor` (
  `id_subreceptor` int(11) NOT NULL,
  `ubicacion` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'lugar donde esta la oficina de la organización'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `subreceptor`
--

INSERT INTO `subreceptor` (`id_subreceptor`, `ubicacion`) VALUES
(15, 'Panama ciudad'),
(19, 'Panama ciudad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnologo`
--

CREATE TABLE `tecnologo` (
  `id_tecnologo` int(11) NOT NULL,
  `numero_de_registro` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tecnologo`
--

INSERT INTO `tecnologo` (`id_tecnologo`, `numero_de_registro`) VALUES
(16, 23456789);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnologo_colabora_con_subreceptor`
--

CREATE TABLE `tecnologo_colabora_con_subreceptor` (
  `id_subreceptor` int(11) NOT NULL,
  `id_tecnologo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `horas_trabajadas` int(11) NOT NULL,
  `lugar` varchar(15) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnologo_realiza_prueba_vih_a_persona_receptora`
--

CREATE TABLE `tecnologo_realiza_prueba_vih_a_persona_receptora` (
  `id_tecnologo` int(11) NOT NULL,
  `id_cedula_persona_receptora` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `realizacion_prueba` enum('no_se_realizó','se_realizó','','') COLLATE utf8_spanish_ci DEFAULT NULL,
  `consejeria_pre-prueba` enum('si','no','','') COLLATE utf8_spanish_ci DEFAULT NULL,
  `consejeria_post-prueba` enum('si','no','','') COLLATE utf8_spanish_ci DEFAULT NULL,
  `resultado_prueba` enum('no_reactivo','reactivo') COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='formulario_4';

--
-- Volcado de datos para la tabla `tecnologo_realiza_prueba_vih_a_persona_receptora`
--

INSERT INTO `tecnologo_realiza_prueba_vih_a_persona_receptora` (`id_tecnologo`, `id_cedula_persona_receptora`, `fecha`, `realizacion_prueba`, `consejeria_pre-prueba`, `consejeria_post-prueba`, `resultado_prueba`) VALUES
(16, '111111111', '2019-10-10', 'se_realizó', 'si', 'si', 'reactivo'),
(16, '1313131', '2019-11-13', 'se_realizó', 'si', 'si', 'reactivo'),
(16, '2222222', '2019-10-11', 'se_realizó', 'si', 'si', 'no_reactivo'),
(16, '91919191', '2020-02-20', 'se_realizó', 'si', 'si', 'no_reactivo'),
(16, '92929292', '2020-02-20', 'no_se_realizó', 'si', '', 'no_reactivo'),
(16, '93939393', '2020-02-20', 'no_se_realizó', 'si', '', 'no_reactivo'),
(16, '97979797', '2020-02-20', 'no_se_realizó', 'si', '', 'no_reactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `login` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_de_usuario` enum('administrador','subreceptor','promotor','tecnologo') COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` enum('activo','no activo') COLLATE utf8_spanish_ci NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `password` varchar(256) COLLATE utf8_spanish_ci NOT NULL,
  `salt` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='registro de los usuarios independientemente del rol';

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `login`, `nombre`, `apellidos`, `tipo_de_usuario`, `estado`, `telefono`, `password`, `salt`) VALUES
(1, 'gonzalo', 'Gonzalo', 'Cabezas', 'administrador', 'activo', 234, '$2y$10$przh9Zi7GvyCrTbZcVQf0eBbEXLVj1mYYvI1i5KrsR0.glljxjb.W', 'as'),
(15, 'subreceptor', 'subreceptor', 'Panama', 'subreceptor', 'activo', 1234567, '$2y$10$fXwYX5N/0m3z4N/RFWjE6.HwoE412gxG3zU4mW5RzB.wPc1j7Ruc.', ''),
(16, 'tecnologo', 'tecnologo', 'medico', 'tecnologo', 'activo', 2345678, '$2y$10$upAOeEwO91ix.1Wv5ohQKO6rOpFZFsTzxppNmRFtBw4ibWNoSa2wS', ''),
(17, 'promotor', 'promotor', 'deSalud', 'promotor', 'activo', 3456789, '$2y$10$5PedXwsgUEqfzJC3QZOqmO5du25ckUS0OQjLgaMC/U3c3mvFF/FsG', ''),
(19, 'subreceptor2', 'subreceptor2', 'Segundo', 'subreceptor', 'activo', 2345243, '$2y$10$UNVI3FsIsLj8hVPwg/idceyfZ0qjDQ4F9te5CE.GJha.cyyAa6CA2', ''),
(20, 'Promotor2', 'Promotor2', 'Segundo', 'promotor', 'activo', 6758923, '$2y$10$tSuMGhxnIQij5g6Wwv7Ta.bxRRaBKgBnXwnSEBXk4QNlWVwDdojX6', ''),
(31, 'promotor3', 'promotor3', 'Tercero', 'promotor', 'activo', 54354354, '$2y$10$B83kTDVv8oVcGX.5yQXFMuSJ1zS8mTwOMtAyecZZatDnilEgsgSG6', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alcanzados`
--
ALTER TABLE `alcanzados`
  ADD PRIMARY KEY (`id_cedula_persona_receptora`),
  ADD UNIQUE KEY `id_cedula_persona_receptora` (`id_cedula_persona_receptora`);

--
-- Indices de la tabla `persona_receptora`
--
ALTER TABLE `persona_receptora`
  ADD PRIMARY KEY (`id_cedula_persona_receptora`),
  ADD UNIQUE KEY `id_cedula_persona_receptora` (`id_cedula_persona_receptora`),
  ADD KEY `poblacion` (`poblacion`);

--
-- Indices de la tabla `promotor`
--
ALTER TABLE `promotor`
  ADD PRIMARY KEY (`id_usuario`,`id_subreceptor`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`),
  ADD UNIQUE KEY `id_cédula` (`id_cedula`);

--
-- Indices de la tabla `promotor_realiza_actividad_grupal_con_personas_receptoras`
--
ALTER TABLE `promotor_realiza_actividad_grupal_con_personas_receptoras`
  ADD PRIMARY KEY (`id_promotor`,`id_cedula_persona_receptora`,`fecha`),
  ADD KEY `persona_recept` (`id_cedula_persona_receptora`);

--
-- Indices de la tabla `promotor_realiza_entrevista_individual`
--
ALTER TABLE `promotor_realiza_entrevista_individual`
  ADD PRIMARY KEY (`id_promotor`,`id_cedula_persona_receptora`,`fecha`),
  ADD KEY `persona_receptora` (`id_cedula_persona_receptora`);

--
-- Indices de la tabla `subreceptor`
--
ALTER TABLE `subreceptor`
  ADD PRIMARY KEY (`id_subreceptor`);

--
-- Indices de la tabla `tecnologo`
--
ALTER TABLE `tecnologo`
  ADD PRIMARY KEY (`id_tecnologo`),
  ADD UNIQUE KEY `número_de_registro` (`numero_de_registro`);

--
-- Indices de la tabla `tecnologo_colabora_con_subreceptor`
--
ALTER TABLE `tecnologo_colabora_con_subreceptor`
  ADD PRIMARY KEY (`id_subreceptor`,`id_tecnologo`,`fecha`),
  ADD KEY `tecnologo` (`id_tecnologo`);

--
-- Indices de la tabla `tecnologo_realiza_prueba_vih_a_persona_receptora`
--
ALTER TABLE `tecnologo_realiza_prueba_vih_a_persona_receptora`
  ADD PRIMARY KEY (`id_tecnologo`,`id_cedula_persona_receptora`,`fecha`),
  ADD KEY `tecnologo_realiza_prueba_vih_a_persona_receptora_ibfk_1` (`id_cedula_persona_receptora`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alcanzados`
--
ALTER TABLE `alcanzados`
  ADD CONSTRAINT `id_cedula_persona_receptora` FOREIGN KEY (`id_cedula_persona_receptora`) REFERENCES `persona_receptora` (`id_cedula_persona_receptora`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `promotor`
--
ALTER TABLE `promotor`
  ADD CONSTRAINT `promotor_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `promotor_realiza_actividad_grupal_con_personas_receptoras`
--
ALTER TABLE `promotor_realiza_actividad_grupal_con_personas_receptoras`
  ADD CONSTRAINT `persona_recept` FOREIGN KEY (`id_cedula_persona_receptora`) REFERENCES `persona_receptora` (`id_cedula_persona_receptora`),
  ADD CONSTRAINT `promotor_id` FOREIGN KEY (`id_promotor`) REFERENCES `promotor` (`id_usuario`);

--
-- Filtros para la tabla `promotor_realiza_entrevista_individual`
--
ALTER TABLE `promotor_realiza_entrevista_individual`
  ADD CONSTRAINT `persona_receptora` FOREIGN KEY (`id_cedula_persona_receptora`) REFERENCES `persona_receptora` (`id_cedula_persona_receptora`) ON UPDATE CASCADE,
  ADD CONSTRAINT `promotor` FOREIGN KEY (`id_promotor`) REFERENCES `promotor` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `subreceptor`
--
ALTER TABLE `subreceptor`
  ADD CONSTRAINT `subreceptor_ibfk_1` FOREIGN KEY (`id_subreceptor`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `tecnologo`
--
ALTER TABLE `tecnologo`
  ADD CONSTRAINT `tecnologo_ibfk_1` FOREIGN KEY (`id_tecnologo`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `tecnologo_colabora_con_subreceptor`
--
ALTER TABLE `tecnologo_colabora_con_subreceptor`
  ADD CONSTRAINT `subreceptor` FOREIGN KEY (`id_subreceptor`) REFERENCES `subreceptor` (`id_subreceptor`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tecnologo` FOREIGN KEY (`id_tecnologo`) REFERENCES `tecnologo` (`id_tecnologo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tecnologo_realiza_prueba_vih_a_persona_receptora`
--
ALTER TABLE `tecnologo_realiza_prueba_vih_a_persona_receptora`
  ADD CONSTRAINT `tecnologo_realiza_prueba` FOREIGN KEY (`id_tecnologo`) REFERENCES `tecnologo` (`id_tecnologo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tecnologo_realiza_prueba_vih_a_persona_receptora_ibfk_1` FOREIGN KEY (`id_cedula_persona_receptora`) REFERENCES `persona_receptora` (`id_cedula_persona_receptora`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
