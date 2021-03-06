CREATE DATABASE  IF NOT EXISTS `monitoreo` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;
USE `monitoreo`;
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
  `fecha_alcanzado` date NOT NULL,
  `region_de_salud` enum('Bocas_del_Toro','Chiriquí','Coclé','Colón','Herrera','Los_Santos','Panamá_Metro','Panamá_Oeste_1','Panamá_Oeste_2','San_Miguelito','Veraguas') NOT NULL,
  PRIMARY KEY (`id_cedula_persona_receptora`),
  UNIQUE KEY `id_cedula_persona_receptora` (`id_cedula_persona_receptora`),
  CONSTRAINT `id_cedula_persona_receptora` FOREIGN KEY (`id_cedula_persona_receptora`) REFERENCES `persona_receptora` (`id_cedula_persona_receptora`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alcanzados`
--

LOCK TABLES `alcanzados` WRITE;
/*!40000 ALTER TABLE `alcanzados` DISABLE KEYS */;
INSERT INTO `alcanzados` VALUES ('20202020','2019-11-22','Bocas_del_Toro'),('2222222','2019-11-22','Colón'),('31433333','2019-11-22','Bocas_del_Toro'),('3331333','2019-11-22','Coclé'),('3332333','2019-11-22','Panamá_Oeste_2');
/*!40000 ALTER TABLE `alcanzados` ENABLE KEYS */;
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
  PRIMARY KEY (`id_cedula_persona_receptora`),
  UNIQUE KEY `id_cedula_persona_receptora` (`id_cedula_persona_receptora`),
  KEY `poblacion` (`poblacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona_receptora`
--

LOCK TABLES `persona_receptora` WRITE;
/*!40000 ALTER TABLE `persona_receptora` DISABLE KEYS */;
INSERT INTO `persona_receptora` VALUES ('111111111',1,'TSF','2019-10-10 18:16:56'),('1212121212',1,'HSH','2019-10-10 18:20:33'),('12345678',1,'HSH','2019-10-10 18:13:58'),('1313131',1,'TSF','2019-11-11 04:26:16'),('13131313',1,'HSH','2019-11-18 09:20:51'),('1515151',1,'HSH','2019-11-20 21:17:57'),('16161616',0,'TRANS','2019-11-20 23:03:47'),('20202020',1,'TRANS','2019-10-18 23:26:04'),('2222222',1,'HSH','2019-10-11 23:39:57'),('31433333',0,'TSF','2019-10-10 18:15:02'),('3331333',1,'HSH','2019-11-22 00:22:35'),('3332333',1,'TSF','2019-11-22 00:24:18'),('3333333',1,'HSH','2019-10-11 23:40:57'),('4141414',1,'HSH','2019-11-18 09:23:49'),('4441444',1,'HSH','2019-11-22 00:04:15'),('44444444',1,'HSH','2019-10-12 23:30:43'),('55555555',1,'HSH','2019-10-12 23:31:29'),('6666666',1,'HSH','2019-11-15 02:40:56'),('7771777',0,'TSF','2019-11-15 20:54:56'),('7772777',1,'TSF','2019-11-15 21:09:59'),('7777777',1,'HSH','2019-11-15 03:01:35'),('8888888',0,'TSF','2019-11-15 20:51:41'),('88888888',1,'TRANS','2019-10-19 21:29:59'),('99999999',1,'TRANS','2019-10-19 21:28:34');
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
INSERT INTO `promotor_realiza_actividad_grupal_con_personas_receptoras` VALUES (17,'111111111','2019-10-10','Bocas_del_Toro','Panama',1,0,0,0,0,0,0,0,0,0,0,0,1,1,1),(17,'111111111','2019-10-16','Panamá_Metro','Panama',1,1,0,0,0,0,0,0,0,0,0,0,2,2,2),(17,'1212121212','2019-10-10','Bocas_del_Toro','Panama',1,0,0,0,0,0,0,0,0,0,0,0,1,1,1),(17,'1212121212','2019-11-14','Bocas_del_Toro','Bocas',1,0,0,0,0,0,0,0,0,0,0,0,50,50,50),(17,'12345678','2019-10-10','Bocas_del_Toro','Panama',1,0,0,0,0,0,0,0,0,0,0,0,1,1,1),(17,'12345678','2019-11-22','Bocas_del_Toro','Colegio',1,0,0,0,1,0,0,0,0,1,0,0,2,2,2),(17,'1313131','2019-11-10','Colón','Colon',1,1,1,1,1,1,1,1,1,1,1,1,5,5,5),(17,'1313131','2019-11-14','Colón','Colon',1,0,0,0,0,0,0,0,0,0,0,0,10,10,10),(17,'20202020','2019-10-18','Bocas_del_Toro','Bocas',1,1,0,0,0,0,0,0,0,0,0,0,20,20,20),(17,'20202020','2019-11-22','Bocas_del_Toro','Hospital',1,0,0,0,0,0,0,0,0,0,0,0,1,1,1),(17,'2222222','2019-10-11','Panamá_Metro','Panama',1,1,0,0,0,0,0,0,0,0,0,0,8,8,8),(17,'2222222','2019-10-18','Bocas_del_Toro','Bocas',0,1,0,0,0,0,0,0,0,0,0,0,5,5,35),(17,'31433333','2019-10-18','Bocas_del_Toro','Bocas',1,0,0,0,0,0,0,0,0,0,0,0,6,7,8),(17,'31433333','2019-11-14','Bocas_del_Toro','Bocas',1,0,0,0,0,0,0,0,0,0,0,0,1,1,1),(17,'31433333','2019-11-22','Bocas_del_Toro','Hospital',0,0,0,0,0,0,0,0,1,1,0,0,39,39,39),(17,'3331333','2019-11-21','Coclé','Calle',0,0,0,1,0,0,0,0,0,0,0,0,20,20,20),(17,'3332333','2019-11-21','Herrera','Escuela',1,0,0,0,0,0,0,0,0,0,0,0,39,39,39),(17,'3333333','2019-10-19','Panamá_Oeste_1','Panama',1,1,0,0,1,0,0,1,1,1,1,1,22,22,22),(17,'4141414','2019-11-17','Chiriquí','Chiriqui',1,0,0,0,0,0,0,0,0,0,0,0,20,20,20),(17,'44444444','2019-10-12','Panamá_Metro','Panama',1,0,0,0,0,0,0,0,0,0,0,0,1,1,1),(17,'44444444','2019-10-18','Bocas_del_Toro','Bocas',1,1,1,0,0,1,0,0,0,0,0,0,9,9,9),(17,'55555555','2019-10-12','Panamá_Metro','Panama',1,0,0,0,0,0,0,0,0,0,0,0,30,30,30),(17,'7771777','2019-11-15','Bocas_del_Toro','Gogol',1,0,0,0,0,0,0,0,0,0,0,0,10,10,10),(17,'88888888','2019-10-19','Herrera','Los santos',1,0,0,0,0,0,0,0,0,1,0,0,1,1,1),(17,'88888888','2019-11-10','Panamá_Oeste_1','Panama',1,1,0,0,0,0,0,0,0,0,0,0,2,2,2),(17,'99999999','2019-10-19','Coclé','Cocle',0,0,0,0,1,1,0,0,0,0,0,0,0,0,0),(17,'99999999','2019-11-14','Bocas_del_Toro','Bocas',1,0,0,0,0,0,0,0,0,0,0,0,1,1,1);
/*!40000 ALTER TABLE `promotor_realiza_actividad_grupal_con_personas_receptoras` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `alcanzado_grupal`  
AFTER INSERT ON `promotor_realiza_actividad_grupal_con_personas_receptoras` FOR EACH ROW 
BEGIN

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
			INSERT INTO alcanzados (id_cedula_persona_receptora, fecha, region_de_salud)
            VALUES (NEW.id_cedula_persona_receptora, now(), NEW.region_de_salud);
		END IF;
        
	END IF;
    
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
  `region_de_salud` enum('Bocas_del_Toro','Chiriquí','Coclé','Colón','Herrera','Los_Santos','Panamá_Metro','Panamá_Oeste_1','Panamá_Oeste_2','San_Miguelito','Veraguas') COLLATE utf8_spanish_ci NOT NULL,
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
INSERT INTO `promotor_realiza_entrevista_individual` VALUES (17,'111111111','2019-10-10','Bocas_del_Toro',1,0,1,0,0,0,0,0),(17,'111111111','2019-10-16','Bocas_del_Toro',0,0,0,1,1,39,39,39),(17,'111111111','2019-11-22','Bocas_del_Toro',0,0,1,0,0,1,1,1),(17,'1212121212','2019-10-15','Bocas_del_Toro',1,0,0,0,0,40,40,40),(17,'1212121212','2019-10-18','Bocas_del_Toro',1,1,1,1,1,4,4,4),(17,'12345678','2019-10-10','Bocas_del_Toro',1,1,1,1,1,5,5,5),(17,'12345678','2019-10-16','Bocas_del_Toro',0,0,1,1,0,35,35,35),(17,'1313131','2019-11-10','Bocas_del_Toro',1,1,1,1,1,5,5,5),(17,'1313131','2019-11-14','Bocas_del_Toro',0,0,1,0,0,5,5,5),(17,'1313131','2019-11-22','Panamá_Oeste_1',0,0,1,0,0,15,15,15),(17,'16161616','2019-11-20','Chiriquí',0,1,1,0,0,2,2,2),(17,'20202020','2019-10-18','Bocas_del_Toro',1,1,1,1,1,20,20,20),(17,'2222222','2019-10-11','Bocas_del_Toro',1,1,0,0,0,1,0,0),(17,'2222222','2019-10-17','Bocas_del_Toro',0,0,0,0,0,20,20,20),(17,'2222222','2019-11-22','Colón',1,0,0,0,0,20,20,20),(17,'31433333','2019-10-10','Bocas_del_Toro',1,0,0,0,0,1,1,1),(17,'31433333','2019-10-19','Bocas_del_Toro',0,0,1,1,1,3,2,1),(17,'3331333','2019-11-21','Herrera',1,0,0,0,0,25,25,25),(17,'3331333','2019-11-22','Coclé',1,0,0,0,0,1,1,1),(17,'3332333','2019-11-21','Herrera',1,0,0,0,0,50,50,50),(17,'3332333','2019-11-22','Panamá_Oeste_2',0,0,1,0,0,2,2,2),(17,'3333333','2019-10-11','Bocas_del_Toro',1,0,0,0,0,22,2,2),(17,'4141414','2019-11-17','Chiriquí',1,0,0,0,0,21,21,21),(17,'4441444','2019-11-21','Bocas_del_Toro',0,1,0,0,0,5,5,5),(17,'44444444','2019-10-12','Bocas_del_Toro',1,0,0,0,0,50,50,50),(17,'55555555','2019-10-12','Bocas_del_Toro',1,0,0,0,0,15,15,15),(17,'7771777','2019-11-15','Bocas_del_Toro',1,0,0,0,0,5,5,5),(17,'7777777','2019-11-15','Bocas_del_Toro',0,1,0,0,0,5,5,5),(17,'88888888','2019-10-19','Bocas_del_Toro',1,1,1,1,1,4,4,4),(17,'88888888','2019-11-08','Bocas_del_Toro',0,0,1,0,0,1,1,1),(17,'99999999','2019-10-19','Bocas_del_Toro',1,0,1,1,1,75,75,75),(17,'99999999','2019-11-14','Bocas_del_Toro',0,1,0,0,0,4,4,4);
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `alcanzado_individual` 
AFTER INSERT ON `promotor_realiza_entrevista_individual` 
FOR EACH ROW 
BEGIN

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
        
			INSERT INTO alcanzados (id_cedula_persona_receptora, fecha, id_subreceptor, region_de_salud)
            VALUES (NEW.id_cedula_persona_receptora, now(), id_subreceptor, NEW.region_de_salud);
		END IF;
	END IF;
    
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
INSERT INTO `tecnologo_realiza_prueba_vih_a_persona_receptora` VALUES (16,'111111111','2019-10-10','se_realizó','si','si','reactivo'),(16,'1313131','2019-11-13','se_realizó','si','si','reactivo'),(16,'2222222','2019-10-11','se_realizó','si','si','no_reactivo');
/*!40000 ALTER TABLE `tecnologo_realiza_prueba_vih_a_persona_receptora` ENABLE KEYS */;
UNLOCK TABLES;

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
  UNIQUE KEY `login` (`login`),
  KEY `id_usuario` (`id_usuario`)
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-27 13:51:43
