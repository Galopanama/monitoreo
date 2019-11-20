-- MySQL dump 10.13  Distrib 8.0.17, for macos10.14 (x86_64)
--
-- Host: 127.0.0.1    Database: monitoreo
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
-- Table structure for table `alcanzados`
--

DROP TABLE IF EXISTS `alcanzados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alcanzados` (
  `id_cedula_persona_receptora` varchar(12) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `nombre_subreceptor` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `region_de_salud` enum('Bocas_del_Toro','Chiriquí','Coclé','Colón','Herrera','Los_Santos','Panamá_Metro','Panamá_Oeste_1','Panamá_Oeste_2','San_Miguelito','Veraguas') NOT NULL,
  PRIMARY KEY (`id_cedula_persona_receptora`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alcanzados`
--

LOCK TABLES `alcanzados` WRITE;
/*!40000 ALTER TABLE `alcanzados` DISABLE KEYS */;
/*!40000 ALTER TABLE `alcanzados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona_en_proceso`
--

DROP TABLE IF EXISTS `persona_en_proceso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persona_en_proceso` (
  `id_cedula_persona_receptora` varchar(12) NOT NULL,
  `fecha_inicio` time NOT NULL,
  `id_promotor` int(11) NOT NULL,
  `condones` int(2) NOT NULL,
  `lubricantes` int(2) NOT NULL,
  `materiales_educativos` int(2) NOT NULL,
  PRIMARY KEY (`id_cedula_persona_receptora`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona_en_proceso`
--

LOCK TABLES `persona_en_proceso` WRITE;
/*!40000 ALTER TABLE `persona_en_proceso` DISABLE KEYS */;
/*!40000 ALTER TABLE `persona_en_proceso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona_receptora`
--

DROP TABLE IF EXISTS `persona_receptora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persona_receptora` (
  `id_cedula_persona_receptora` varchar(12) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'número de cedula',
  `poblacion_originaria` tinyint(1) NOT NULL COMMENT 'perteneciente a un grupo de población indígena',
  `poblacion` enum('HSH','TSF','TRANS','') NOT NULL COMMENT 'grupo en el que se identifica',
  `datos_actualizados` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cedula_persona_receptora`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona_receptora`
--

LOCK TABLES `persona_receptora` WRITE;
/*!40000 ALTER TABLE `persona_receptora` DISABLE KEYS */;
INSERT INTO `persona_receptora` VALUES ('111111111',1,'TSF','2019-10-10 13:16:56'),('1212121212',1,'HSH','2019-10-10 13:20:33'),('12345678',1,'HSH','2019-10-10 13:13:58'),('1313131',1,'TSF','2019-11-10 23:26:16'),('20202020',1,'TRANS','2019-10-18 18:26:04'),('2222222',1,'HSH','2019-10-11 18:39:57'),('31433333',0,'TSF','2019-10-10 13:15:02'),('3333333',1,'HSH','2019-10-11 18:40:57'),('44444444',1,'HSH','2019-10-12 18:30:43'),('55555555',1,'HSH','2019-10-12 18:31:29'),('88888888',1,'TRANS','2019-10-19 16:29:59'),('99999999',1,'TRANS','2019-10-19 16:28:34');
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
  `id_subreceptor` int(11) NOT NULL,
  `id_cedula` varchar(12) NOT NULL,
  `organizacion` varchar(20) NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_subreceptor`),
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
INSERT INTO `promotor` VALUES (17,15,'22222222','subreceptor Panama');
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
  `id_cedula_persona_receptora` varchar(12) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
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
  PRIMARY KEY (`id_promotor`,`id_cedula_persona_receptora`,`fecha`),
  KEY `persona_recept` (`id_cedula_persona_receptora`),
  CONSTRAINT `persona_recept` FOREIGN KEY (`id_cedula_persona_receptora`) REFERENCES `persona_receptora` (`id_cedula_persona_receptora`),
  CONSTRAINT `promotor_id` FOREIGN KEY (`id_promotor`) REFERENCES `promotor` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotor_realiza_actividad_grupal_con_personas_receptoras`
--

LOCK TABLES `promotor_realiza_actividad_grupal_con_personas_receptoras` WRITE;
/*!40000 ALTER TABLE `promotor_realiza_actividad_grupal_con_personas_receptoras` DISABLE KEYS */;
INSERT INTO `promotor_realiza_actividad_grupal_con_personas_receptoras` VALUES (17,'111111111','2019-10-10','Bocas_del_Toro','Panama',1,0,0,0,0,0,0,0,0,0,0,0,1,1,1),(17,'111111111','2019-10-16','Panamá_Metro','Panama',1,1,0,0,0,0,0,0,0,0,0,0,2,2,2),(17,'1212121212','2019-10-10','Bocas_del_Toro','Panama',1,0,0,0,0,0,0,0,0,0,0,0,1,1,1),(17,'12345678','2019-10-10','Bocas_del_Toro','Panama',1,0,0,0,0,0,0,0,0,0,0,0,1,1,1),(17,'1313131','2019-11-10','Colón','Colon',1,1,1,1,1,1,1,1,1,1,1,1,5,5,5),(17,'20202020','2019-10-18','Bocas_del_Toro','Bocas',1,1,0,0,0,0,0,0,0,0,0,0,20,20,20),(17,'2222222','2019-10-11','Panamá_Metro','Panama',1,1,0,0,0,0,0,0,0,0,0,0,8,8,8),(17,'2222222','2019-10-18','Bocas_del_Toro','Bocas',0,1,0,0,0,0,0,0,0,0,0,0,5,5,35),(17,'31433333','2019-10-18','Bocas_del_Toro','Bocas',1,0,0,0,0,0,0,0,0,0,0,0,6,7,8),(17,'3333333','2019-10-19','Panamá_Oeste_1','Panama',1,1,0,0,1,0,0,1,1,1,1,1,22,22,22),(17,'44444444','2019-10-12','Panamá_Metro','Panama',1,0,0,0,0,0,0,0,0,0,0,0,1,1,1),(17,'44444444','2019-10-18','Bocas_del_Toro','Bocas',1,1,1,0,0,1,0,0,0,0,0,0,9,9,9),(17,'55555555','2019-10-12','Panamá_Metro','Panama',1,0,0,0,0,0,0,0,0,0,0,0,30,30,30),(17,'88888888','2019-10-19','Herrera','Los santos',1,0,0,0,0,0,0,0,0,1,0,0,1,1,1),(17,'88888888','2019-11-10','Panamá_Oeste_1','Panama',1,1,0,0,0,0,0,0,0,0,0,0,2,2,2),(17,'99999999','2019-10-19','Coclé','Cocle',0,0,0,0,1,1,0,0,0,0,0,0,0,0,0);
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
  `id_cedula_persona_receptora` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `uso_del_condon` tinyint(1) DEFAULT NULL,
  `uso_de_alcohol_y_drogas_ilicitas` tinyint(1) DEFAULT NULL,
  `informacion_CLAM` tinyint(1) DEFAULT NULL,
  `referencia_a_prueba_de_VIH` tinyint(1) DEFAULT NULL,
  `referencia_a_clinica_TB` tinyint(1) DEFAULT NULL,
  `condones_entregados` int(11) DEFAULT NULL,
  `lubricantes_entregados` int(11) DEFAULT NULL,
  `materiales_educativos_entregados` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_promotor`,`id_cedula_persona_receptora`,`fecha`),
  KEY `persona_receptora` (`id_cedula_persona_receptora`),
  CONSTRAINT `persona_receptora` FOREIGN KEY (`id_cedula_persona_receptora`) REFERENCES `persona_receptora` (`id_cedula_persona_receptora`) ON UPDATE CASCADE,
  CONSTRAINT `promotor` FOREIGN KEY (`id_promotor`) REFERENCES `promotor` (`id_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='entrevista individual a individuos. Formulario 1';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotor_realiza_entrevista_individual`
--

LOCK TABLES `promotor_realiza_entrevista_individual` WRITE;
/*!40000 ALTER TABLE `promotor_realiza_entrevista_individual` DISABLE KEYS */;
INSERT INTO `promotor_realiza_entrevista_individual` VALUES (17,'111111111','2019-10-10',1,0,1,0,0,0,0,0),(17,'111111111','2019-10-16',0,0,0,1,1,39,39,39),(17,'1212121212','2019-10-15',1,0,0,0,0,40,40,40),(17,'1212121212','2019-10-18',1,1,1,1,1,4,4,4),(17,'12345678','2019-10-10',1,1,1,1,1,5,5,5),(17,'12345678','2019-10-16',0,0,1,1,0,35,35,35),(17,'1313131','2019-11-10',1,1,1,1,1,5,5,5),(17,'20202020','2019-10-18',1,1,1,1,1,20,20,20),(17,'2222222','2019-10-11',1,1,0,0,0,1,0,0),(17,'2222222','2019-10-17',0,0,0,0,0,20,20,20),(17,'31433333','2019-10-10',1,0,0,0,0,1,1,1),(17,'31433333','2019-10-19',0,0,1,1,1,3,2,1),(17,'3333333','2019-10-11',1,0,0,0,0,22,2,2),(17,'44444444','2019-10-12',1,0,0,0,0,50,50,50),(17,'55555555','2019-10-12',1,0,0,0,0,15,15,15),(17,'88888888','2019-10-19',1,1,1,1,1,4,4,4),(17,'88888888','2019-11-08',0,0,1,0,0,1,1,1),(17,'99999999','2019-10-19',1,0,1,1,1,75,75,75);
/*!40000 ALTER TABLE `promotor_realiza_entrevista_individual` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `sin_alcanzar_individual` AFTER INSERT ON `promotor_realiza_entrevista_individual` FOR EACH ROW BEGIN
    	IF id_cedula_persona_receptora not in (id_cedula_persona_receptora.persona_en_proceso) THEN BEGIN 
        	INSERT INTO persona_en_proceso (id_cedula_persona_receptora, fecha_incio, id_promotor, condones, lubricantes, materiales_educativos)
            VALUES ('NEW.id_cedula_persona_receptora', 'now()', 'new.id_promotor', 'new.condones_entregados', 'new.lubricantes_entregados', 'new.materiales_educativos_entregados');
		END;
        ELSEIF id_cedula_persona_receptora in (id_cedula_persona_receptora.persona_en_proceso) THEN BEGIN
			INSERT INTO persona_en_proceso (condones, lubricantes, materiales_educativos)
            VALUES ('condones' + 'new.condones_entregados', 'lubricantes' + 'new.lubricantes_entregados', 'materiales_educativos' + 'new.materiales_educativos_entregados');
		END; END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
INSERT INTO `subreceptor` VALUES (15,'Panama ciudad');
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
INSERT INTO `tecnologo` VALUES (16,23456789,'');
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
  `realizacion_prueba` enum('no_se_realizó','se_realizó','','') COLLATE utf8_spanish_ci DEFAULT NULL,
  `consejeria_pre-prueba` enum('si','no','','') COLLATE utf8_spanish_ci DEFAULT NULL,
  `consejeria_post-prueba` enum('si','no','','') COLLATE utf8_spanish_ci DEFAULT NULL,
  `resultado_prueba` enum('no_reactivo','reactivo') COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_tecnologo`,`id_cedula_persona_receptora`,`fecha`),
  KEY `tecnologo_realiza_prueba_vih_a_persona_receptora_ibfk_1` (`id_cedula_persona_receptora`),
  CONSTRAINT `tecnologo_realiza_prueba` FOREIGN KEY (`id_tecnologo`) REFERENCES `tecnologo` (`id_tecnologo`) ON UPDATE CASCADE,
  CONSTRAINT `tecnologo_realiza_prueba_vih_a_persona_receptora_ibfk_1` FOREIGN KEY (`id_cedula_persona_receptora`) REFERENCES `persona_receptora` (`id_cedula_persona_receptora`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='formulario_4';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tecnologo_realiza_prueba_vih_a_persona_receptora`
--

LOCK TABLES `tecnologo_realiza_prueba_vih_a_persona_receptora` WRITE;
/*!40000 ALTER TABLE `tecnologo_realiza_prueba_vih_a_persona_receptora` DISABLE KEYS */;
INSERT INTO `tecnologo_realiza_prueba_vih_a_persona_receptora` VALUES (16,'111111111','2019-10-10','se_realizó','si','si','reactivo'),(16,'2222222','2019-10-11','se_realizó','si','si','no_reactivo');
/*!40000 ALTER TABLE `tecnologo_realiza_prueba_vih_a_persona_receptora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `total`
--

DROP TABLE IF EXISTS `total`;
/*!50001 DROP VIEW IF EXISTS `total`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `total` AS SELECT 
 1 AS `id_cedula_persona_receptora`,
 1 AS `total_condones`,
 1 AS `total_lubricantes`,
 1 AS `total_materiales_educativos`,
 1 AS `Promotor_1`,
 1 AS `Promotor_2`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `total_grupales`
--

DROP TABLE IF EXISTS `total_grupales`;
/*!50001 DROP VIEW IF EXISTS `total_grupales`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `total_grupales` AS SELECT 
 1 AS `total_C`,
 1 AS `total_L`,
 1 AS `total_M`,
 1 AS `id_cedula_persona_receptora`,
 1 AS `id_promotor`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `total_individuales`
--

DROP TABLE IF EXISTS `total_individuales`;
/*!50001 DROP VIEW IF EXISTS `total_individuales`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `total_individuales` AS SELECT 
 1 AS `total_C`,
 1 AS `total_L`,
 1 AS `total_M`,
 1 AS `id_cedula_persona_receptora`,
 1 AS `id_promotor`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `total_por_subreceptor`
--

DROP TABLE IF EXISTS `total_por_subreceptor`;
/*!50001 DROP VIEW IF EXISTS `total_por_subreceptor`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `total_por_subreceptor` AS SELECT 
 1 AS `id_cedula_persona_receptora`,
 1 AS `total_condones`,
 1 AS `total_lubricantes`,
 1 AS `total_materiales_educativos`,
 1 AS `id_subreceptor`*/;
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
  `estado` enum('activo','no activo') COLLATE utf8_spanish_ci NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `password` varchar(256) COLLATE utf8_spanish_ci NOT NULL,
  `salt` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='registro de los usuarios independientemente del rol';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'gonzalo','Gonzalo','Cabezas','administrador','activo',234,'$2y$10$przh9Zi7GvyCrTbZcVQf0eBbEXLVj1mYYvI1i5KrsR0.glljxjb.W','as'),(15,'subreceptor','subreceptor','Panama','subreceptor','activo',1234567,'$2y$10$fXwYX5N/0m3z4N/RFWjE6.HwoE412gxG3zU4mW5RzB.wPc1j7Ruc.',''),(16,'tecnologo','tecnologo','medico','tecnologo','activo',2345678,'$2y$10$upAOeEwO91ix.1Wv5ohQKO6rOpFZFsTzxppNmRFtBw4ibWNoSa2wS',''),(17,'promotor','promotor','deSalud','promotor','activo',3456789,'$2y$10$5PedXwsgUEqfzJC3QZOqmO5du25ckUS0OQjLgaMC/U3c3mvFF/FsG','');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'monitoreo'
--

--
-- Dumping routines for database 'monitoreo'
--

--
-- Final view structure for view `total`
--

/*!50001 DROP VIEW IF EXISTS `total`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER */
/*!50001 VIEW `total` AS select `i`.`id_cedula_persona_receptora` AS `id_cedula_persona_receptora`,(`i`.`total_C` + `g`.`total_C`) AS `total_condones`,(`i`.`total_L` + `g`.`total_L`) AS `total_lubricantes`,(`i`.`total_M` + `g`.`total_M`) AS `total_materiales_educativos`,`i`.`id_promotor` AS `Promotor_1`,`g`.`id_promotor` AS `Promotor_2` from (`total_grupales` `i` left join `total_individuales` `g` on((`i`.`id_cedula_persona_receptora` = `g`.`id_cedula_persona_receptora`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `total_grupales`
--

/*!50001 DROP VIEW IF EXISTS `total_grupales`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER */
/*!50001 VIEW `total_grupales` AS select sum(`promotor_realiza_actividad_grupal_con_personas_receptoras`.`condones_entregados`) AS `total_C`,sum(`promotor_realiza_actividad_grupal_con_personas_receptoras`.`lubricantes_entregados`) AS `total_L`,sum(`promotor_realiza_actividad_grupal_con_personas_receptoras`.`materiales_educativos_entregados`) AS `total_M`,`promotor_realiza_actividad_grupal_con_personas_receptoras`.`id_cedula_persona_receptora` AS `id_cedula_persona_receptora`,`promotor_realiza_actividad_grupal_con_personas_receptoras`.`id_promotor` AS `id_promotor` from `promotor_realiza_actividad_grupal_con_personas_receptoras` group by `promotor_realiza_actividad_grupal_con_personas_receptoras`.`id_cedula_persona_receptora` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `total_individuales`
--

/*!50001 DROP VIEW IF EXISTS `total_individuales`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER */
/*!50001 VIEW `total_individuales` AS select sum(`promotor_realiza_entrevista_individual`.`condones_entregados`) AS `total_C`,sum(`promotor_realiza_entrevista_individual`.`lubricantes_entregados`) AS `total_L`,sum(`promotor_realiza_entrevista_individual`.`materiales_educativos_entregados`) AS `total_M`,`promotor_realiza_entrevista_individual`.`id_cedula_persona_receptora` AS `id_cedula_persona_receptora`,`promotor_realiza_entrevista_individual`.`id_promotor` AS `id_promotor` from `promotor_realiza_entrevista_individual` group by `promotor_realiza_entrevista_individual`.`id_cedula_persona_receptora` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `total_por_subreceptor`
--

/*!50001 DROP VIEW IF EXISTS `total_por_subreceptor`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER */
/*!50001 VIEW `total_por_subreceptor` AS select `total`.`id_cedula_persona_receptora` AS `id_cedula_persona_receptora`,`total`.`total_condones` AS `total_condones`,`total`.`total_lubricantes` AS `total_lubricantes`,`total`.`total_materiales_educativos` AS `total_materiales_educativos`,`promotor`.`id_subreceptor` AS `id_subreceptor` from (`total` join `promotor`) where (`total`.`Promotor_1` and (`total`.`Promotor_2` = `promotor`.`id_usuario`) and (`total`.`total_condones` >= 40) and (`total`.`total_lubricantes` >= 40) and (`total`.`total_materiales_educativos` >= 40)) */;
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

-- Dump completed on 2019-11-12 11:11:04
