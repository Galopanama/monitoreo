CREATE DATABASE  IF NOT EXISTS `monitoreo_y_evaluacion` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `monitoreo_y_evaluacion`;
-- MySQL dump 10.13  Distrib 8.0.17, for macos10.14 (x86_64)
--
-- Host: 127.0.0.1    Database: monitoreo_y_evaluacion
-- ------------------------------------------------------
-- Server version	5.6.43

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Temporary view structure for view `entregas_segun_las_areas_de_salud`
--

DROP TABLE IF EXISTS `entregas_segun_las_areas_de_salud`;
/*!50001 DROP VIEW IF EXISTS `entregas_segun_las_areas_de_salud`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `entregas_segun_las_areas_de_salud` AS SELECT 
 1 AS `region_de_salud`,
 1 AS `count(condones_entregados)`,
 1 AS `count(lubricantes_entregados)`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `llego_al_grupal`
--

DROP TABLE IF EXISTS `llego_al_grupal`;
/*!50001 DROP VIEW IF EXISTS `llego_al_grupal`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `llego_al_grupal` AS SELECT 
 1 AS `continuaron_asistiendo`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `persona_receptora`
--

DROP TABLE IF EXISTS `persona_receptora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persona_receptora` (
  `id_cedula` varchar(12) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'número de cedula',
  `poblacion_originaria` tinyint(1) NOT NULL COMMENT 'perteneciente a un grupo de población indígena',
  `poblacion` enum('HSH','TSF','TRANS','') NOT NULL COMMENT 'grupo en el que se identifica',
  PRIMARY KEY (`id_cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona_receptora`
--

LOCK TABLES `persona_receptora` WRITE;
/*!40000 ALTER TABLE `persona_receptora` DISABLE KEYS */;
/*!40000 ALTER TABLE `persona_receptora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotor`
--

DROP TABLE IF EXISTS `promotor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promotor` (
  `id_usuario` int(11) NOT NULL,
  `id_cedula` varchar(12) NOT NULL,
  `organizacion` varchar(20) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `id_usuario` (`id_usuario`),
  UNIQUE KEY `id_cédula` (`id_cedula`),
  CONSTRAINT `promotor_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotor`
--

LOCK TABLES `promotor` WRITE;
/*!40000 ALTER TABLE `promotor` DISABLE KEYS */;
/*!40000 ALTER TABLE `promotor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotor_realiza_actividad_grupal_con_personas_receptoras`
--

DROP TABLE IF EXISTS `promotor_realiza_actividad_grupal_con_personas_receptoras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promotor_realiza_actividad_grupal_con_personas_receptoras` (
  `id_promotor` int(11) NOT NULL,
  `id_persona_receptora` varchar(12) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `region_de_salud` enum('Bocas_del_Toro','Chiriquí','Coclé','Colón','Herrera','Los_Santos','Panamá_Metro','Panamá_Oeste_1','Panamá_Oeste_2','San_Miguelito','Veraguas') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `area` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
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
  `materiales_educativos_entregados` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_promotor`,`id_persona_receptora`,`fecha`),
  KEY `persona_recept` (`id_persona_receptora`),
  CONSTRAINT `persona_recept` FOREIGN KEY (`id_persona_receptora`) REFERENCES `persona_receptora` (`id_cedula`),
  CONSTRAINT `promotor_id` FOREIGN KEY (`id_promotor`) REFERENCES `promotor` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotor_realiza_actividad_grupal_con_personas_receptoras`
--

LOCK TABLES `promotor_realiza_actividad_grupal_con_personas_receptoras` WRITE;
/*!40000 ALTER TABLE `promotor_realiza_actividad_grupal_con_personas_receptoras` DISABLE KEYS */;
/*!40000 ALTER TABLE `promotor_realiza_actividad_grupal_con_personas_receptoras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotor_realiza_entrevista_individual`
--

DROP TABLE IF EXISTS `promotor_realiza_entrevista_individual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promotor_realiza_entrevista_individual` (
  `id_promotor` int(11) NOT NULL,
  `id_persona_receptora` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `uso_del_condon` tinyint(1) DEFAULT NULL,
  `uso_de_alcohol_y_drogas_ilicitas` tinyint(1) DEFAULT NULL,
  `informacion_CLAM` tinyint(1) DEFAULT NULL,
  `referencia_a_prueba_de_VIH` tinyint(1) DEFAULT NULL,
  `referencia_a_clinica_TB` tinyint(1) DEFAULT NULL,
  `condones_entregados` int(11) DEFAULT NULL,
  `lubricantes_entregados` int(11) DEFAULT NULL,
  `materiales_educativos_entregados` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_promotor`,`id_persona_receptora`,`fecha`),
  KEY `persona_receptora` (`id_persona_receptora`),
  CONSTRAINT `persona_receptora` FOREIGN KEY (`id_persona_receptora`) REFERENCES `persona_receptora` (`id_cedula`) ON UPDATE CASCADE,
  CONSTRAINT `promotor` FOREIGN KEY (`id_promotor`) REFERENCES `promotor` (`id_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='entrevista individual a individuos. Formulario 1';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotor_realiza_entrevista_individual`
--

LOCK TABLES `promotor_realiza_entrevista_individual` WRITE;
/*!40000 ALTER TABLE `promotor_realiza_entrevista_individual` DISABLE KEYS */;
/*!40000 ALTER TABLE `promotor_realiza_entrevista_individual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotor_trabaja_con_un_subreceptor`
--

DROP TABLE IF EXISTS `promotor_trabaja_con_un_subreceptor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promotor_trabaja_con_un_subreceptor` (
  `id_promotor` int(11) NOT NULL,
  `subreceptor` int(11) NOT NULL,
  PRIMARY KEY (`id_promotor`,`subreceptor`),
  KEY `subrcptor` (`subreceptor`),
  CONSTRAINT `promotr` FOREIGN KEY (`id_promotor`) REFERENCES `promotor` (`id_usuario`) ON UPDATE CASCADE,
  CONSTRAINT `subrcptor` FOREIGN KEY (`subreceptor`) REFERENCES `subreceptor` (`id_subreceptor`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotor_trabaja_con_un_subreceptor`
--

LOCK TABLES `promotor_trabaja_con_un_subreceptor` WRITE;
/*!40000 ALTER TABLE `promotor_trabaja_con_un_subreceptor` DISABLE KEYS */;
/*!40000 ALTER TABLE `promotor_trabaja_con_un_subreceptor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `pruebas_realizadas`
--

DROP TABLE IF EXISTS `pruebas_realizadas`;
/*!50001 DROP VIEW IF EXISTS `pruebas_realizadas`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `pruebas_realizadas` AS SELECT 
 1 AS `id_subreceptor`,
 1 AS `total_realizados`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `reactivo_positivo`
--

DROP TABLE IF EXISTS `reactivo_positivo`;
/*!50001 DROP VIEW IF EXISTS `reactivo_positivo`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `reactivo_positivo` AS SELECT 
 1 AS `id_subreceptor`,
 1 AS `count(id_cedula_persona_receptora)`,
 1 AS `resultado_prueba`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `resultados_del_tecnologo`
--

DROP TABLE IF EXISTS `resultados_del_tecnologo`;
/*!50001 DROP VIEW IF EXISTS `resultados_del_tecnologo`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `resultados_del_tecnologo` AS SELECT 
 1 AS `id_tecnologo`,
 1 AS `id_cedula_persona_receptora`,
 1 AS `fecha`,
 1 AS `realizacion_prueba`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `subreceptor`
--

DROP TABLE IF EXISTS `subreceptor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subreceptor` (
  `id_subreceptor` int(11) NOT NULL,
  `ubicacion` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'lugar donde esta la oficina de la organización',
  PRIMARY KEY (`id_subreceptor`),
  CONSTRAINT `subreceptor_ibfk_1` FOREIGN KEY (`id_subreceptor`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subreceptor`
--

LOCK TABLES `subreceptor` WRITE;
/*!40000 ALTER TABLE `subreceptor` DISABLE KEYS */;
/*!40000 ALTER TABLE `subreceptor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tecnologo`
--

DROP TABLE IF EXISTS `tecnologo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tecnologo` (
  `id_tecnologo` int(11) NOT NULL,
  `numero_de_registro` int(8) NOT NULL,
  `id_cedula` varchar(12) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_tecnologo`),
  UNIQUE KEY `número_de_registro` (`numero_de_registro`),
  UNIQUE KEY `id_cédula` (`id_cedula`),
  CONSTRAINT `tecnologo_ibfk_1` FOREIGN KEY (`id_tecnologo`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tecnologo`
--

LOCK TABLES `tecnologo` WRITE;
/*!40000 ALTER TABLE `tecnologo` DISABLE KEYS */;
/*!40000 ALTER TABLE `tecnologo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tecnologo_colabora_con_subreceptor`
--

DROP TABLE IF EXISTS `tecnologo_colabora_con_subreceptor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tecnologo_colabora_con_subreceptor` (
  `id_subreceptor` int(11) NOT NULL,
  `id_tecnologo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `horas_trabajadas` int(11) NOT NULL,
  `lugar` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_subreceptor`,`id_tecnologo`,`fecha`),
  KEY `tecnologo` (`id_tecnologo`),
  CONSTRAINT `subreceptor` FOREIGN KEY (`id_subreceptor`) REFERENCES `subreceptor` (`id_subreceptor`) ON UPDATE CASCADE,
  CONSTRAINT `tecnologo` FOREIGN KEY (`id_tecnologo`) REFERENCES `tecnologo` (`id_tecnologo`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tecnologo_colabora_con_subreceptor`
--

LOCK TABLES `tecnologo_colabora_con_subreceptor` WRITE;
/*!40000 ALTER TABLE `tecnologo_colabora_con_subreceptor` DISABLE KEYS */;
/*!40000 ALTER TABLE `tecnologo_colabora_con_subreceptor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tecnologo_realiza_prueba_vih_a_persona_receptora`
--

DROP TABLE IF EXISTS `tecnologo_realiza_prueba_vih_a_persona_receptora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tecnologo_realiza_prueba_vih_a_persona_receptora` (
  `id_tecnologo` int(11) NOT NULL,
  `id_cedula_persona_receptora` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `consejeria_pre-prueba` enum('si','no','','') COLLATE utf8_spanish_ci DEFAULT NULL,
  `consejeria_post-prueba` enum('si','no','','') COLLATE utf8_spanish_ci DEFAULT NULL,
  `resultado_prueba` enum('no_reactivo','reactivo') COLLATE utf8_spanish_ci DEFAULT NULL,
  `realizacion_prueba` enum('no_se_realizó','se_realizó','','') COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_tecnologo`,`id_cedula_persona_receptora`,`fecha`),
  KEY `tecnologo_realiza_prueba_vih_a_persona_receptora_ibfk_1` (`id_cedula_persona_receptora`),
  CONSTRAINT `tecnologo_realiza_prueba` FOREIGN KEY (`id_tecnologo`) REFERENCES `tecnologo` (`id_tecnologo`) ON UPDATE CASCADE,
  CONSTRAINT `tecnologo_realiza_prueba_vih_a_persona_receptora_ibfk_1` FOREIGN KEY (`id_cedula_persona_receptora`) REFERENCES `persona_receptora` (`id_cedula`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='formulario_4';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tecnologo_realiza_prueba_vih_a_persona_receptora`
--

LOCK TABLES `tecnologo_realiza_prueba_vih_a_persona_receptora` WRITE;
/*!40000 ALTER TABLE `tecnologo_realiza_prueba_vih_a_persona_receptora` DISABLE KEYS */;
/*!40000 ALTER TABLE `tecnologo_realiza_prueba_vih_a_persona_receptora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `total_promotor`
--

DROP TABLE IF EXISTS `total_promotor`;
/*!50001 DROP VIEW IF EXISTS `total_promotor`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `total_promotor` AS SELECT 
 1 AS `individuos`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_de_usuario` enum('administrador','subreceptor','promotor','tecnologo') COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `password` varchar(256) COLLATE utf8_spanish_ci NOT NULL,
  `salt` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='registro de los usuarios independientemente del rol';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'jose','Jose Manuel','asf','administrador',234,'$2y$10$iJJll0jreD/sxU2XW1/Ipu5Op2Hfs0m9Pc.wZC4zkAwXTPBXh5TxG','as');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `vistaprueba`
--

DROP TABLE IF EXISTS `vistaprueba`;
/*!50001 DROP VIEW IF EXISTS `vistaprueba`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vistaprueba` AS SELECT 
 1 AS `id_subreceptor`,
 1 AS `total_realizados`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `entregas_segun_las_areas_de_salud`
--

/*!50001 DROP VIEW IF EXISTS `entregas_segun_las_areas_de_salud`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER */
/*!50001 VIEW `entregas_segun_las_areas_de_salud` AS select `promotor_realiza_actividad_grupal_con_personas_receptoras`.`region_de_salud` AS `region_de_salud`,count(`promotor_realiza_actividad_grupal_con_personas_receptoras`.`condones_entregados`) AS `count(condones_entregados)`,count(`promotor_realiza_actividad_grupal_con_personas_receptoras`.`lubricantes_entregados`) AS `count(lubricantes_entregados)` from `promotor_realiza_actividad_grupal_con_personas_receptoras` group by `promotor_realiza_actividad_grupal_con_personas_receptoras`.`region_de_salud` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `llego_al_grupal`
--

/*!50001 DROP VIEW IF EXISTS `llego_al_grupal`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER */
/*!50001 VIEW `llego_al_grupal` AS select count(`promotor_realiza_actividad_grupal_con_personas_receptoras`.`id_persona_receptora`) AS `continuaron_asistiendo` from (`promotor_realiza_actividad_grupal_con_personas_receptoras` join `promotor_realiza_entrevista_individual`) where (`promotor_realiza_entrevista_individual`.`id_persona_receptora` = `promotor_realiza_actividad_grupal_con_personas_receptoras`.`id_persona_receptora`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `pruebas_realizadas`
--

/*!50001 DROP VIEW IF EXISTS `pruebas_realizadas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER */
/*!50001 VIEW `pruebas_realizadas` AS select `colabora`.`id_subreceptor` AS `id_subreceptor`,count(`realiza`.`id_cedula_persona_receptora`) AS `total_realizados` from (`tecnologo_colabora_con_subreceptor` `colabora` join `tecnologo_realiza_prueba_vih_a_persona_receptora` `realiza`) where ((`colabora`.`id_tecnologo` = `realiza`.`id_tecnologo`) and (`realiza`.`resultado_prueba` = 'se_realizó')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `reactivo_positivo`
--

/*!50001 DROP VIEW IF EXISTS `reactivo_positivo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER */
/*!50001 VIEW `reactivo_positivo` AS select `tecnologo_colabora_con_subreceptor`.`id_subreceptor` AS `id_subreceptor`,count(`tecnologo_realiza_prueba_vih_a_persona_receptora`.`id_cedula_persona_receptora`) AS `count(id_cedula_persona_receptora)`,`tecnologo_realiza_prueba_vih_a_persona_receptora`.`resultado_prueba` AS `resultado_prueba` from (`tecnologo_colabora_con_subreceptor` join `tecnologo_realiza_prueba_vih_a_persona_receptora`) where (`tecnologo_colabora_con_subreceptor`.`id_tecnologo` = `tecnologo_realiza_prueba_vih_a_persona_receptora`.`id_tecnologo`) group by (`tecnologo_realiza_prueba_vih_a_persona_receptora`.`resultado_prueba` = 'reactivo') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `resultados_del_tecnologo`
--

/*!50001 DROP VIEW IF EXISTS `resultados_del_tecnologo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER */
/*!50001 VIEW `resultados_del_tecnologo` AS select `tecnologo_realiza_prueba_vih_a_persona_receptora`.`id_tecnologo` AS `id_tecnologo`,`tecnologo_realiza_prueba_vih_a_persona_receptora`.`id_cedula_persona_receptora` AS `id_cedula_persona_receptora`,`tecnologo_realiza_prueba_vih_a_persona_receptora`.`fecha` AS `fecha`,`tecnologo_realiza_prueba_vih_a_persona_receptora`.`realizacion_prueba` AS `realizacion_prueba` from `tecnologo_realiza_prueba_vih_a_persona_receptora` order by `tecnologo_realiza_prueba_vih_a_persona_receptora`.`fecha` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `total_promotor`
--

/*!50001 DROP VIEW IF EXISTS `total_promotor`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER */
/*!50001 VIEW `total_promotor` AS select count(`promotor_realiza_entrevista_individual`.`id_persona_receptora`) AS `individuos` from `promotor_realiza_entrevista_individual` group by `promotor_realiza_entrevista_individual`.`id_promotor` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vistaprueba`
--

/*!50001 DROP VIEW IF EXISTS `vistaprueba`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER */
/*!50001 VIEW `vistaprueba` AS select `colabora`.`id_subreceptor` AS `id_subreceptor`,count(`realiza`.`id_cedula_persona_receptora`) AS `total_realizados` from (`tecnologo_colabora_con_subreceptor` `colabora` join `tecnologo_realiza_prueba_vih_a_persona_receptora` `realiza`) where ((`colabora`.`id_tecnologo` = `realiza`.`id_tecnologo`) and (`realiza`.`resultado_prueba` = 'se_realizó')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-08-03 17:53:56
