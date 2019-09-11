CREATE DATABASE  IF NOT EXISTS `monitoreo` /*!40100 DEFAULT CHARACTER SET utf8 */;
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
-- Table structure for table `persona_receptora`
--

DROP TABLE IF EXISTS `persona_receptora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persona_receptora` (
  `id_cedula` varchar(12) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'número de cedula',
  `poblacion_originaria` tinyint(1) NOT NULL COMMENT 'perteneciente a un grupo de población indígena',
  `poblacion` enum('HSH','TSF','TRANS','') NOT NULL COMMENT 'grupo en el que se identifica',
  `datos_actualizados` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona_receptora`
--

LOCK TABLES `persona_receptora` WRITE;
/*!40000 ALTER TABLE `persona_receptora` DISABLE KEYS */;
INSERT INTO `persona_receptora` VALUES ('12345678',1,'TSF','2019-09-09 17:18:15'),('13243546',1,'TSF','2019-09-09 17:18:15'),('142536478',1,'TSF','2019-09-09 17:18:15'),('23456789',0,'TSF','2019-09-09 17:18:15'),('3456789',1,'HSH','2019-09-06 21:05:12'),('345678912',1,'TSF','2019-09-09 17:18:15'),('34567898',1,'HSH','2019-09-06 21:18:10');
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
INSERT INTO `promotor` VALUES (5,4,'12345667','HSH');
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
INSERT INTO `promotor_realiza_actividad_grupal_con_personas_receptoras` VALUES (5,'12345678','2019-09-09','Panamá_Metro','Ingenio',1,0,1,0,1,0,0,0,0,0,0,0,3,5,2),(5,'13243546','2019-09-09','Panamá_Metro','Ingenio',1,0,1,0,1,0,0,0,0,0,0,0,4,4,3),(5,'142536478','2019-09-09','Panamá_Metro','Ingenio',1,0,1,0,1,0,0,0,0,0,0,0,2,3,1),(5,'23456789','2019-09-09','Panamá_Metro','Ingenio',1,0,1,0,1,0,0,0,0,0,0,0,5,2,1),(5,'345678912','2019-09-09','Panamá_Metro','Ingenio',1,0,1,0,1,0,0,0,0,0,0,0,4,2,3);
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
INSERT INTO `promotor_realiza_entrevista_individual` VALUES (5,'23456789','2019-09-10',0,0,0,0,0,20,20,20),(5,'3456789','2019-09-06',1,0,1,0,0,4,3,2),(5,'34567898','2019-09-06',1,0,1,0,0,4,3,2);
/*!40000 ALTER TABLE `promotor_realiza_entrevista_individual` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `subreceptor` VALUES (4,'Panama');
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
INSERT INTO `tecnologo` VALUES (2,1234,'');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='registro de los usuarios independientemente del rol';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'gonzalo','Gonzalo','Cabezas','administrador','activo',234,'$2y$10$przh9Zi7GvyCrTbZcVQf0eBbEXLVj1mYYvI1i5KrsR0.glljxjb.W','as'),(2,'tecnologoG','G','CT','tecnologo','activo',12345678,'$2y$10$Xmp/vJl1dBHVhBY3NCwcvuPGX3e2Sw4f1ERc/kMOqZ1tIV2saDKrS',''),(4,'Viviendo+','HSH','Viviendo Positivamen','subreceptor','activo',2134567,'$2y$10$9ug6SF236QDbvPB92Dnr6.CJf03w.bZ4O0BjW6x3tpzp.nuyNRcqi',''),(5,'PepitoFlorit','Pepito','Florito','promotor','activo',1234123,'$2y$10$HFUdGjwVdaApijdVk4nh1OJ45ffiPWN2jH0.B8AxtNQsVVapNVVBK','');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-09-10 12:24:48
