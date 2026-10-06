-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: zyacbtpublic
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cbt_user_grup`
--

DROP TABLE IF EXISTS `cbt_user_grup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_user_grup` (
  `grup_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `grup_nama` varchar(255) NOT NULL,
  PRIMARY KEY (`grup_id`),
  UNIQUE KEY `group_name` (`grup_nama`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_user_grup`
--

LOCK TABLES `cbt_user_grup` WRITE;
/*!40000 ALTER TABLE `cbt_user_grup` DISABLE KEYS */;
INSERT INTO `cbt_user_grup` VALUES (8,'X AKL 1'),(9,'X AKL 2'),(10,'X OTKP 1'),(11,'X OTKP 2'),(14,'X TBSM 1'),(15,'X TBSM 2'),(6,'X TKJ 1'),(7,'X TKJ 2'),(12,'X TKRO 1'),(13,'X TKRO 2'),(16,'XI AKL 1'),(17,'XI AKL 2'),(18,'XI OTKP 1'),(19,'XI OTKP 2'),(24,'XI TBSM 1'),(25,'XI TBSM 2'),(20,'XI TKJ 1'),(21,'XI TKJ 2'),(22,'XI TKRO 1'),(23,'XI TKRO 2'),(26,'XII AKL 1'),(27,'XII AKL 2'),(28,'XII OTKP 1'),(29,'XII OTKP 2'),(34,'XII TBSM 1'),(35,'XII TBSM 2'),(30,'XII TKJ 1'),(31,'XII TKJ 2'),(32,'XII TKRO 1'),(33,'XII TKRO 2');
/*!40000 ALTER TABLE `cbt_user_grup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbt_modul`
--

DROP TABLE IF EXISTS `cbt_modul`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_modul` (
  `modul_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `modul_nama` varchar(255) NOT NULL,
  `modul_aktif` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`modul_id`),
  UNIQUE KEY `ak_module_name` (`modul_nama`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_modul`
--

LOCK TABLES `cbt_modul` WRITE;
/*!40000 ALTER TABLE `cbt_modul` DISABLE KEYS */;
INSERT INTO `cbt_modul` VALUES (9,'Default',1),(10,'Pendidikan Agama',1),(11,'PPKn',1),(12,'Bahasa Indonesia',1),(13,'Sejarah Indonesia',1),(14,'Bahasa Inggris',1),(15,'Informatika',1),(16,'Mapel Pilihan',1),(17,'Seni Budaya',1),(18,'Matematika',1),(19,'IPAS',1),(20,'PKK',1),(21,'Dasar Kejuruan (Kelas X)',1),(22,'Konsentrasi Keahlian (Kelas XI)',1),(23,'Konsentrasi Keahlian (Kelas XII)',1),(24,'Penjasorkes',1);
/*!40000 ALTER TABLE `cbt_modul` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbt_topik`
--

DROP TABLE IF EXISTS `cbt_topik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_topik` (
  `topik_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `topik_modul_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `topik_nama` varchar(255) NOT NULL,
  `topik_detail` text DEFAULT NULL,
  `topik_aktif` tinyint(1) NOT NULL DEFAULT 0,
  `topik_tipe` varchar(20) NOT NULL DEFAULT 'panitia',
  `topik_user_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`topik_id`),
  UNIQUE KEY `ak_subject_name` (`topik_modul_id`,`topik_nama`),
  CONSTRAINT `cbt_topik_ibfk_1` FOREIGN KEY (`topik_modul_id`) REFERENCES `cbt_modul` (`modul_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_topik`
--

LOCK TABLES `cbt_topik` WRITE;
/*!40000 ALTER TABLE `cbt_topik` DISABLE KEYS */;
INSERT INTO `cbt_topik` VALUES (11,9,'Dasar Dasar Jaringan Komputer X TKJ','Dasar Dasar Jaringan Komputer X TKJ',1,'panitia',1),(12,10,'[SENIN-1] STS X - Pendidikan Agama','[SENIN-1] STS X - Pendidikan Agama',1,'panitia',1),(13,10,'[SENIN-1] STS XI - Pendidikan Agama','[SENIN-1] STS XI - Pendidikan Agama',1,'panitia',1),(14,10,'[SENIN-1] STS XII - Pendidikan Agama','[SENIN-1] STS XII - Pendidikan Agama',1,'panitia',1),(15,11,'[SENIN-2] STS X - PPKn','[SENIN-2] STS X - PPKn',1,'panitia',1),(16,11,'[SENIN-2] STS XI - PPKn','[SENIN-2] STS XI - PPKn',1,'panitia',1),(17,11,'[SENIN-2] STS XII - PPKn','[SENIN-2] STS XII - PPKn',1,'panitia',1),(18,12,'[SELASA-1] STS X - Bahasa Indonesia','[SELASA-1] STS X - Bahasa Indonesia',1,'panitia',1),(19,12,'[SELASA-1] STS XI - Bahasa Indonesia','[SELASA-1] STS XI - Bahasa Indonesia',1,'panitia',1),(20,12,'[SELASA-1] STS XII - Bahasa Indonesia','[SELASA-1] STS XII - Bahasa Indonesia',1,'panitia',1),(21,13,'[SELASA-2] STS X - Sejarah Indonesia','[SELASA-2] STS X - Sejarah Indonesia',1,'panitia',1),(22,13,'[SELASA-2] STS XI - Sejarah Indonesia','[SELASA-2] STS XI - Sejarah Indonesia',1,'panitia',1),(23,13,'[SELASA-2] STS XII - Sejarah Indonesia','[SELASA-2] STS XII - Sejarah Indonesia',1,'panitia',1),(24,14,'[RABU-1] STS X - Bahasa Inggris','[RABU-1] STS X - Bahasa Inggris',1,'panitia',1),(25,14,'[RABU-1] STS XI - Bahasa Inggris','[RABU-1] STS XI - Bahasa Inggris',1,'panitia',1),(26,14,'[RABU-1] STS XII - Bahasa Inggris','[RABU-1] STS XII - Bahasa Inggris',1,'panitia',1),(27,15,'[RABU-2] STS X - Informatika','[RABU-2] STS X - Informatika',1,'panitia',1),(28,16,'[RABU-2] STS XI - Mapel Pilihan (AKL)','[RABU-2] STS XI - Mapel Pilihan (AKL)',1,'panitia',1),(29,16,'[RABU-2] STS XI - Mapel Pilihan (OTKP)','[RABU-2] STS XI - Mapel Pilihan (OTKP)',1,'panitia',1),(30,16,'[RABU-2] STS XI - Mapel Pilihan (TKJ)','[RABU-2] STS XI - Mapel Pilihan (TKJ)',1,'panitia',1),(31,16,'[RABU-2] STS XI - Mapel Pilihan (TKRO)','[RABU-2] STS XI - Mapel Pilihan (TKRO)',1,'panitia',1),(32,16,'[RABU-2] STS XI - Mapel Pilihan (TBSM)','[RABU-2] STS XI - Mapel Pilihan (TBSM)',1,'panitia',1),(33,17,'[RABU-3] STS X - Seni Budaya','[RABU-3] STS X - Seni Budaya',1,'panitia',1),(34,17,'[RABU-3] STS XI - Seni Budaya','[RABU-3] STS XI - Seni Budaya',1,'panitia',1),(35,17,'[RABU-3] STS XII - Seni Budaya','[RABU-3] STS XII - Seni Budaya',1,'panitia',1),(36,18,'[KAMIS-1] STS X - Matematika','[KAMIS-1] STS X - Matematika',1,'panitia',1),(37,18,'[KAMIS-1] STS XI - Matematika','[KAMIS-1] STS XI - Matematika',1,'panitia',1),(38,18,'[KAMIS-1] STS XII - Matematika','[KAMIS-1] STS XII - Matematika',1,'panitia',1),(39,19,'[KAMIS-2] STS X - IPAS','[KAMIS-2] STS X - IPAS',1,'panitia',1),(40,20,'[KAMIS-2] STS XI - PKK','[KAMIS-2] STS XI - PKK',1,'panitia',1),(41,20,'[KAMIS-2] STS XII - PKK','[KAMIS-2] STS XII - PKK',1,'panitia',1),(42,21,'[JUMAT-1] STS X - Dasar-2 AKL','[JUMAT-1] STS X - Dasar-2 AKL',1,'panitia',1),(43,21,'[JUMAT-1] STS X - Dasar-2 MPLB','[JUMAT-1] STS X - Dasar-2 MPLB',1,'panitia',1),(44,21,'[JUMAT-1] STS X - Dasar-2 TJKT','[JUMAT-1] STS X - Dasar-2 TJKT',1,'panitia',1),(45,21,'[JUMAT-1] STS X - Dasar-2 Otomotif','[JUMAT-1] STS X - Dasar-2 Otomotif',1,'panitia',1),(46,22,'[JUMAT-1] STS XI - Keahlian AKL','[JUMAT-1] STS XI - Keahlian AKL',1,'panitia',1),(47,22,'[JUMAT-1] STS XI - Keahlian MP','[JUMAT-1] STS XI - Keahlian MP',1,'panitia',1),(48,22,'[JUMAT-1] STS XI - Keahlian TKJ','[JUMAT-1] STS XI - Keahlian TKJ',1,'panitia',1),(49,22,'[JUMAT-1] STS XI - Keahlian TKR','[JUMAT-1] STS XI - Keahlian TKR',1,'panitia',1),(50,22,'[JUMAT-1] STS XI - Keahlian TSM','[JUMAT-1] STS XI - Keahlian TSM',1,'panitia',1),(51,23,'[JUMAT-1] STS XII - Keahlian AKL','[JUMAT-1] STS XII - Keahlian AKL',1,'panitia',1),(52,23,'[JUMAT-1] STS XII - Keahlian MP','[JUMAT-1] STS XII - Keahlian MP',1,'panitia',1),(53,23,'[JUMAT-1] STS XII - Keahlian TKJ','[JUMAT-1] STS XII - Keahlian TKJ',1,'panitia',1),(54,23,'[JUMAT-1] STS XII - Keahlian TKR','[JUMAT-1] STS XII - Keahlian TKR',1,'panitia',1),(55,23,'[JUMAT-1] STS XII - Keahlian TSM','[JUMAT-1] STS XII - Keahlian TSM',1,'panitia',1),(56,24,'[JUMAT-2] STS X - Penjasorkes','[JUMAT-2] STS X - Penjasorkes',1,'panitia',1),(57,24,'[JUMAT-2] STS XI - Penjasorkes','[JUMAT-2] STS XI - Penjasorkes',1,'panitia',1),(58,24,'[JUMAT-2] STS XII - Penjasorkes','[JUMAT-2] STS XII - Penjasorkes',1,'panitia',1);
/*!40000 ALTER TABLE `cbt_topik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbt_tes`
--

DROP TABLE IF EXISTS `cbt_tes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_tes` (
  `tes_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tes_nama` varchar(255) NOT NULL,
  `tes_hari` varchar(30) DEFAULT NULL,
  `tes_shift` varchar(20) DEFAULT NULL,
  `tes_jam_ke` varchar(30) DEFAULT NULL,
  `tes_detail` text NOT NULL,
  `tes_begin_time` datetime DEFAULT NULL,
  `tes_end_time` datetime DEFAULT NULL,
  `tes_duration_time` smallint(10) unsigned NOT NULL DEFAULT 0,
  `tes_ip_range` varchar(255) NOT NULL DEFAULT '*.*.*.*',
  `tes_results_to_users` tinyint(1) NOT NULL DEFAULT 0,
  `tes_detail_to_users` tinyint(1) NOT NULL DEFAULT 0,
  `tes_score_right` decimal(10,2) DEFAULT 1.00,
  `tes_score_wrong` decimal(10,2) DEFAULT 0.00,
  `tes_score_unanswered` decimal(10,2) DEFAULT 0.00,
  `tes_max_score` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tes_token` tinyint(1) DEFAULT 0,
  `tes_user_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`tes_id`),
  UNIQUE KEY `ak_test_name` (`tes_nama`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_tes`
--

LOCK TABLES `cbt_tes` WRITE;
/*!40000 ALTER TABLE `cbt_tes` DISABLE KEYS */;
INSERT INTO `cbt_tes` VALUES (180,'[SENIN-1] STS X [PAGI - Rombel 1] - Pendidikan Agama','Senin','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Senin (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-12 07:15:00','2026-10-12 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(181,'[SENIN-1] STS X [SIANG - Rombel 2] - Pendidikan Agama','Senin','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Senin (Jam Ke-1 Shift Siang 13.00 - 14.30)','2026-10-12 12:45:00','2026-10-12 15:00:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(182,'[SENIN-1] STS XI [SIANG] - Pendidikan Agama','Senin','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Senin (Jam Ke-1 Shift Siang 13.00 - 14.30)','2026-10-12 12:45:00','2026-10-12 15:00:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(183,'[SENIN-1] STS XII [PAGI] - Pendidikan Agama','Senin','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Senin (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-12 07:15:00','2026-10-12 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(184,'[SENIN-2] STS X [PAGI - Rombel 1] - PPKn','Senin','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Senin (Jam Ke-2 Shift Pagi 09.30 - 11.00)','2026-10-12 09:15:00','2026-10-12 11:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(185,'[SENIN-2] STS X [SIANG - Rombel 2] - PPKn','Senin','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Senin (Jam Ke-2 Shift Siang 15.00 - 16.30)','2026-10-12 14:45:00','2026-10-12 17:00:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(186,'[SENIN-2] STS XI [SIANG] - PPKn','Senin','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Senin (Jam Ke-2 Shift Siang 15.00 - 16.30)','2026-10-12 14:45:00','2026-10-12 17:00:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(187,'[SENIN-2] STS XII [PAGI] - PPKn','Senin','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Senin (Jam Ke-2 Shift Pagi 09.30 - 11.00)','2026-10-12 09:15:00','2026-10-12 11:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(188,'[SELASA-1] STS X [PAGI - Rombel 1] - Bahasa Indonesia','Selasa','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Selasa (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-13 07:15:00','2026-10-13 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(189,'[SELASA-1] STS X [SIANG - Rombel 2] - Bahasa Indonesia','Selasa','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Selasa (Jam Ke-1 Shift Siang 13.00 - 14.30)','2026-10-13 12:45:00','2026-10-13 15:00:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(190,'[SELASA-1] STS XI [SIANG] - Bahasa Indonesia','Selasa','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Selasa (Jam Ke-1 Shift Siang 13.00 - 14.30)','2026-10-13 12:45:00','2026-10-13 15:00:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(191,'[SELASA-1] STS XII [PAGI] - Bahasa Indonesia','Selasa','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Selasa (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-13 07:15:00','2026-10-13 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(192,'[SELASA-2] STS X [PAGI - Rombel 1] - Sejarah Indonesia','Selasa','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Selasa (Jam Ke-2 Shift Pagi 09.30 - 11.00)','2026-10-13 09:15:00','2026-10-13 11:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(193,'[SELASA-2] STS X [SIANG - Rombel 2] - Sejarah Indonesia','Selasa','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Selasa (Jam Ke-2 Shift Siang 15.00 - 16.30)','2026-10-13 14:45:00','2026-10-13 17:00:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(194,'[SELASA-2] STS XI [SIANG] - Sejarah Indonesia','Selasa','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Selasa (Jam Ke-2 Shift Siang 15.00 - 16.30)','2026-10-13 14:45:00','2026-10-13 17:00:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(195,'[SELASA-2] STS XII [PAGI] - Sejarah Indonesia','Selasa','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Selasa (Jam Ke-2 Shift Pagi 09.30 - 11.00)','2026-10-13 09:15:00','2026-10-13 11:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(196,'[RABU-1] STS X [PAGI - Rombel 1] - Bahasa Inggris','Rabu','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-14 07:15:00','2026-10-14 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(197,'[RABU-1] STS X [SIANG - Rombel 2] - Bahasa Inggris','Rabu','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-1 Shift Siang 13.00 - 14.30)','2026-10-14 12:45:00','2026-10-14 15:00:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(198,'[RABU-1] STS XI [SIANG] - Bahasa Inggris','Rabu','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-1 Shift Siang 13.00 - 14.30)','2026-10-14 12:45:00','2026-10-14 15:00:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(199,'[RABU-1] STS XII [PAGI] - Bahasa Inggris','Rabu','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-14 07:15:00','2026-10-14 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(200,'[RABU-2] STS X [PAGI - Rombel 1] - Informatika','Rabu','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-2 Shift Pagi 09.00 - 10.00)','2026-10-14 08:45:00','2026-10-14 10:30:00',60,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(201,'[RABU-2] STS X [SIANG - Rombel 2] - Informatika','Rabu','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-2 Shift Siang 14.30 - 15.30)','2026-10-14 14:15:00','2026-10-14 16:00:00',60,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(202,'[RABU-2] STS XI [SIANG] - Mapel Pilihan (AKL)','Rabu','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-2 Shift Siang 14.30 - 15.30)','2026-10-14 14:15:00','2026-10-14 16:00:00',60,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(203,'[RABU-2] STS XI [SIANG] - Mapel Pilihan (OTKP)','Rabu','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-2 Shift Siang 14.30 - 15.30)','2026-10-14 14:15:00','2026-10-14 16:00:00',60,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(204,'[RABU-2] STS XI [SIANG] - Mapel Pilihan (TKJ)','Rabu','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-2 Shift Siang 14.30 - 15.30)','2026-10-14 14:15:00','2026-10-14 16:00:00',60,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(205,'[RABU-2] STS XI [SIANG] - Mapel Pilihan (TKRO)','Rabu','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-2 Shift Siang 14.30 - 15.30)','2026-10-14 14:15:00','2026-10-14 16:00:00',60,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(206,'[RABU-2] STS XI [SIANG] - Mapel Pilihan (TBSM)','Rabu','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-2 Shift Siang 14.30 - 15.30)','2026-10-14 14:15:00','2026-10-14 16:00:00',60,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(207,'[RABU-3] STS X [PAGI - Rombel 1] - Seni Budaya','Rabu','Pagi','Jam Ke-3','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-3 Shift Pagi 10.30 - 11.30)','2026-10-14 10:15:00','2026-10-14 12:00:00',60,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(208,'[RABU-3] STS X [SIANG - Rombel 2] - Seni Budaya','Rabu','Siang','Jam Ke-3','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-3 Shift Siang 16.00 - 17.00)','2026-10-14 15:45:00','2026-10-14 17:30:00',60,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(209,'[RABU-3] STS XI [SIANG] - Seni Budaya','Rabu','Siang','Jam Ke-3','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-3 Shift Siang 16.00 - 17.00)','2026-10-14 15:45:00','2026-10-14 17:30:00',60,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(210,'[RABU-3] STS XII [PAGI] - Seni Budaya','Rabu','Pagi','Jam Ke-3','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-3 Shift Pagi 10.30 - 11.30)','2026-10-14 10:15:00','2026-10-14 12:00:00',60,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(211,'[KAMIS-1] STS X [PAGI - Rombel 1] - Matematika','Kamis','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Kamis (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-15 07:15:00','2026-10-15 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(212,'[KAMIS-1] STS X [SIANG - Rombel 2] - Matematika','Kamis','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Kamis (Jam Ke-1 Shift Siang 13.00 - 14.30)','2026-10-15 12:45:00','2026-10-15 15:00:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(213,'[KAMIS-1] STS XI [SIANG] - Matematika','Kamis','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Kamis (Jam Ke-1 Shift Siang 13.00 - 14.30)','2026-10-15 12:45:00','2026-10-15 15:00:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(214,'[KAMIS-1] STS XII [PAGI] - Matematika','Kamis','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Kamis (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-15 07:15:00','2026-10-15 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(215,'[KAMIS-2] STS X [PAGI - Rombel 1] - IPAS','Kamis','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Kamis (Jam Ke-2 Shift Pagi 09.30 - 11.00)','2026-10-15 09:15:00','2026-10-15 11:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(216,'[KAMIS-2] STS X [SIANG - Rombel 2] - IPAS','Kamis','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Kamis (Jam Ke-2 Shift Siang 15.00 - 16.30)','2026-10-15 14:45:00','2026-10-15 17:00:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(217,'[KAMIS-2] STS XI [SIANG] - PKK','Kamis','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Kamis (Jam Ke-2 Shift Siang 15.00 - 16.30)','2026-10-15 14:45:00','2026-10-15 17:00:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(218,'[KAMIS-2] STS XII [PAGI] - PKK','Kamis','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Kamis (Jam Ke-2 Shift Pagi 09.30 - 11.00)','2026-10-15 09:15:00','2026-10-15 11:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(219,'[JUMAT-1] STS X [PAGI - Rombel 1] - Dasar-2 AKL','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(220,'[JUMAT-1] STS X [SIANG - Rombel 2] - Dasar-2 AKL','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(221,'[JUMAT-1] STS X [PAGI - Rombel 1] - Dasar-2 MPLB','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(222,'[JUMAT-1] STS X [SIANG - Rombel 2] - Dasar-2 MPLB','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(223,'[JUMAT-1] STS X [PAGI - Rombel 1] - Dasar-2 TJKT','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(224,'[JUMAT-1] STS X [SIANG - Rombel 2] - Dasar-2 TJKT','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(225,'[JUMAT-1] STS X [PAGI - Rombel 1] - Dasar-2 Otomotif','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(226,'[JUMAT-1] STS X [SIANG - Rombel 2] - Dasar-2 Otomotif','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(227,'[JUMAT-1] STS XI [SIANG] - Keahlian AKL','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(228,'[JUMAT-1] STS XI [SIANG] - Keahlian MP','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(229,'[JUMAT-1] STS XI [SIANG] - Keahlian TKJ','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(230,'[JUMAT-1] STS XI [SIANG] - Keahlian TKR','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(231,'[JUMAT-1] STS XI [SIANG] - Keahlian TSM','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(232,'[JUMAT-1] STS XII [PAGI] - Keahlian AKL','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(233,'[JUMAT-1] STS XII [PAGI] - Keahlian MP','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(234,'[JUMAT-1] STS XII [PAGI] - Keahlian TKJ','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(235,'[JUMAT-1] STS XII [PAGI] - Keahlian TKR','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(236,'[JUMAT-1] STS XII [PAGI] - Keahlian TSM','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(237,'[JUMAT-2] STS X [PAGI - Rombel 1] - Penjasorkes','Jumat','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-2 Shift Pagi 09.30 - 10.30)','2026-10-16 09:15:00','2026-10-16 11:00:00',60,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(238,'[JUMAT-2] STS X [SIANG - Rombel 2] - Penjasorkes','Jumat','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-2 Shift Siang 15.30 - 16.30)','2026-10-16 15:15:00','2026-10-16 17:00:00',60,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(239,'[JUMAT-2] STS XI [SIANG] - Penjasorkes','Jumat','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-2 Shift Siang 15.30 - 16.30)','2026-10-16 15:15:00','2026-10-16 17:00:00',60,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1),(240,'[JUMAT-2] STS XII [PAGI] - Penjasorkes','Jumat','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-2 Shift Pagi 09.30 - 10.30)','2026-10-16 09:15:00','2026-10-16 11:00:00',60,'*.*.*.*',0,0,1.00,0.00,0.00,40.00,1,1);
/*!40000 ALTER TABLE `cbt_tes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbt_tesgrup`
--

DROP TABLE IF EXISTS `cbt_tesgrup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_tesgrup` (
  `tstgrp_tes_id` bigint(20) unsigned NOT NULL,
  `tstgrp_grup_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`tstgrp_tes_id`,`tstgrp_grup_id`),
  KEY `p_tstgrp_test_id` (`tstgrp_tes_id`),
  KEY `p_tstgrp_group_id` (`tstgrp_grup_id`),
  CONSTRAINT `cbt_tesgrup_ibfk_1` FOREIGN KEY (`tstgrp_tes_id`) REFERENCES `cbt_tes` (`tes_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `cbt_tesgrup_ibfk_2` FOREIGN KEY (`tstgrp_grup_id`) REFERENCES `cbt_user_grup` (`grup_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_tesgrup`
--

LOCK TABLES `cbt_tesgrup` WRITE;
/*!40000 ALTER TABLE `cbt_tesgrup` DISABLE KEYS */;
INSERT INTO `cbt_tesgrup` VALUES (180,6),(180,8),(180,10),(180,12),(180,14),(181,7),(181,9),(181,11),(181,13),(181,15),(182,16),(182,17),(182,18),(182,19),(182,20),(182,21),(182,22),(182,23),(182,24),(182,25),(183,26),(183,27),(183,28),(183,29),(183,30),(183,31),(183,32),(183,33),(183,34),(183,35),(184,6),(184,8),(184,10),(184,12),(184,14),(185,7),(185,9),(185,11),(185,13),(185,15),(186,16),(186,17),(186,18),(186,19),(186,20),(186,21),(186,22),(186,23),(186,24),(186,25),(187,26),(187,27),(187,28),(187,29),(187,30),(187,31),(187,32),(187,33),(187,34),(187,35),(188,6),(188,8),(188,10),(188,12),(188,14),(189,7),(189,9),(189,11),(189,13),(189,15),(190,16),(190,17),(190,18),(190,19),(190,20),(190,21),(190,22),(190,23),(190,24),(190,25),(191,26),(191,27),(191,28),(191,29),(191,30),(191,31),(191,32),(191,33),(191,34),(191,35),(192,6),(192,8),(192,10),(192,12),(192,14),(193,7),(193,9),(193,11),(193,13),(193,15),(194,16),(194,17),(194,18),(194,19),(194,20),(194,21),(194,22),(194,23),(194,24),(194,25),(195,26),(195,27),(195,28),(195,29),(195,30),(195,31),(195,32),(195,33),(195,34),(195,35),(196,6),(196,8),(196,10),(196,12),(196,14),(197,7),(197,9),(197,11),(197,13),(197,15),(198,16),(198,17),(198,18),(198,19),(198,20),(198,21),(198,22),(198,23),(198,24),(198,25),(199,26),(199,27),(199,28),(199,29),(199,30),(199,31),(199,32),(199,33),(199,34),(199,35),(200,6),(200,8),(200,10),(200,12),(200,14),(201,7),(201,9),(201,11),(201,13),(201,15),(202,16),(202,17),(203,18),(203,19),(204,20),(204,21),(205,22),(205,23),(206,24),(206,25),(207,6),(207,8),(207,10),(207,12),(207,14),(208,7),(208,9),(208,11),(208,13),(208,15),(209,16),(209,17),(209,18),(209,19),(209,20),(209,21),(209,22),(209,23),(209,24),(209,25),(210,26),(210,27),(210,28),(210,29),(210,30),(210,31),(210,32),(210,33),(210,34),(210,35),(211,6),(211,8),(211,10),(211,12),(211,14),(212,7),(212,9),(212,11),(212,13),(212,15),(213,16),(213,17),(213,18),(213,19),(213,20),(213,21),(213,22),(213,23),(213,24),(213,25),(214,26),(214,27),(214,28),(214,29),(214,30),(214,31),(214,32),(214,33),(214,34),(214,35),(215,6),(215,8),(215,10),(215,12),(215,14),(216,7),(216,9),(216,11),(216,13),(216,15),(217,16),(217,17),(217,18),(217,19),(217,20),(217,21),(217,22),(217,23),(217,24),(217,25),(218,26),(218,27),(218,28),(218,29),(218,30),(218,31),(218,32),(218,33),(218,34),(218,35),(219,8),(220,9),(221,10),(222,11),(223,6),(224,7),(225,12),(225,14),(226,13),(226,15),(227,16),(227,17),(228,18),(228,19),(229,20),(229,21),(230,22),(230,23),(231,24),(231,25),(232,26),(232,27),(233,28),(233,29),(234,30),(234,31),(235,32),(235,33),(236,34),(236,35),(237,6),(237,8),(237,10),(237,12),(237,14),(238,7),(238,9),(238,11),(238,13),(238,15),(239,16),(239,17),(239,18),(239,19),(239,20),(239,21),(239,22),(239,23),(239,24),(239,25),(240,26),(240,27),(240,28),(240,29),(240,30),(240,31),(240,32),(240,33),(240,34),(240,35);
/*!40000 ALTER TABLE `cbt_tesgrup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbt_tes_topik_set`
--

DROP TABLE IF EXISTS `cbt_tes_topik_set`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_tes_topik_set` (
  `tset_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tset_tes_id` bigint(20) unsigned NOT NULL,
  `tset_topik_id` bigint(20) unsigned NOT NULL,
  `tset_tipe` smallint(6) NOT NULL DEFAULT 1,
  `tset_difficulty` smallint(6) NOT NULL DEFAULT 1,
  `tset_jumlah` smallint(6) NOT NULL DEFAULT 1,
  `tset_jawaban` smallint(6) NOT NULL DEFAULT 0,
  `tset_acak_jawaban` int(11) NOT NULL DEFAULT 1,
  `tset_acak_soal` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`tset_id`),
  KEY `p_tsubset_test_id` (`tset_tes_id`),
  KEY `tsubset_subject_id` (`tset_topik_id`),
  CONSTRAINT `cbt_tes_topik_set_ibfk_1` FOREIGN KEY (`tset_tes_id`) REFERENCES `cbt_tes` (`tes_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `cbt_tes_topik_set_ibfk_2` FOREIGN KEY (`tset_topik_id`) REFERENCES `cbt_topik` (`topik_id`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=313 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_tes_topik_set`
--

LOCK TABLES `cbt_tes_topik_set` WRITE;
/*!40000 ALTER TABLE `cbt_tes_topik_set` DISABLE KEYS */;
INSERT INTO `cbt_tes_topik_set` VALUES (252,180,12,1,1,40,5,1,1),(253,181,12,1,1,40,5,1,1),(254,182,13,1,1,40,5,1,1),(255,183,14,1,1,40,5,1,1),(256,184,15,1,1,40,5,1,1),(257,185,15,1,1,40,5,1,1),(258,186,16,1,1,40,5,1,1),(259,187,17,1,1,40,5,1,1),(260,188,18,1,1,40,5,1,1),(261,189,18,1,1,40,5,1,1),(262,190,19,1,1,40,5,1,1),(263,191,20,1,1,40,5,1,1),(264,192,21,1,1,40,5,1,1),(265,193,21,1,1,40,5,1,1),(266,194,22,1,1,40,5,1,1),(267,195,23,1,1,40,5,1,1),(268,196,24,1,1,40,5,1,1),(269,197,24,1,1,40,5,1,1),(270,198,25,1,1,40,5,1,1),(271,199,26,1,1,40,5,1,1),(272,200,27,1,1,40,5,1,1),(273,201,27,1,1,40,5,1,1),(274,202,28,1,1,40,5,1,1),(275,203,29,1,1,40,5,1,1),(276,204,30,1,1,40,5,1,1),(277,205,31,1,1,40,5,1,1),(278,206,32,1,1,40,5,1,1),(279,207,33,1,1,40,5,1,1),(280,208,33,1,1,40,5,1,1),(281,209,34,1,1,40,5,1,1),(282,210,35,1,1,40,5,1,1),(283,211,36,1,1,40,5,1,1),(284,212,36,1,1,40,5,1,1),(285,213,37,1,1,40,5,1,1),(286,214,38,1,1,40,5,1,1),(287,215,39,1,1,40,5,1,1),(288,216,39,1,1,40,5,1,1),(289,217,40,1,1,40,5,1,1),(290,218,41,1,1,40,5,1,1),(291,219,42,1,1,40,5,1,1),(292,220,42,1,1,40,5,1,1),(293,221,43,1,1,40,5,1,1),(294,222,43,1,1,40,5,1,1),(295,223,44,1,1,40,5,1,1),(296,224,44,1,1,40,5,1,1),(297,225,45,1,1,40,5,1,1),(298,226,45,1,1,40,5,1,1),(299,227,46,1,1,40,5,1,1),(300,228,47,1,1,40,5,1,1),(301,229,48,1,1,40,5,1,1),(302,230,49,1,1,40,5,1,1),(303,231,50,1,1,40,5,1,1),(304,232,51,1,1,40,5,1,1),(305,233,52,1,1,40,5,1,1),(306,234,53,1,1,40,5,1,1),(307,235,54,1,1,40,5,1,1),(308,236,55,1,1,40,5,1,1),(309,237,56,1,1,40,5,1,1),(310,238,56,1,1,40,5,1,1),(311,239,57,1,1,40,5,1,1),(312,240,58,1,1,40,5,1,1);
/*!40000 ALTER TABLE `cbt_tes_topik_set` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_menu`
--

DROP TABLE IF EXISTS `user_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipe` int(11) NOT NULL DEFAULT 1 COMMENT '0=parent, 1=child',
  `parent` varchar(50) DEFAULT NULL,
  `kode_menu` varchar(50) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `url` varchar(150) NOT NULL DEFAULT '#',
  `icon` varchar(75) NOT NULL DEFAULT 'fa fa-circle-o',
  `urutan` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_menu` (`kode_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_menu`
--

LOCK TABLES `user_menu` WRITE;
/*!40000 ALTER TABLE `user_menu` DISABLE KEYS */;
INSERT INTO `user_menu` VALUES (1,0,'','user','Pengaturan','#','fa fa-user',20),(3,1,'user','user_atur','Pengaturan User','manager/useratur','fa fa-circle-o',5),(4,1,'user','user_level','Pengaturan Level','manager/userlevel','fa fa-circle-o',6),(5,1,'user','user_menu','Pengaturan Menu','manager/usermenu','fa fa-circle-o',7),(6,0,'','modul','Data Modul','#','fa fa-book',2),(7,1,'modul','modul-daftar','Daftar Soal','manager/modul_daftar','fa fa-circle-o',5),(8,1,'modul','modul-topik','Topik','manager/modul_topik','fa fa-circle-o',2),(10,0,'','peserta','Data Peserta','#','fa fa-users',3),(11,1,'peserta','peserta-daftar','Daftar Peserta','manager/peserta_daftar','fa fa-circle-o',2),(12,1,'peserta','peserta-group','Daftar Group','manager/peserta_group','fa fa-circle-o',1),(13,1,'peserta','peserta-import','Import Data Peserta','manager/peserta_import','fa fa-circle-o',3),(14,0,'','tes','Data Tes','#','fa fa-tasks',4),(15,1,'tes','tes-tambah','Tambah Tes','manager/tes_tambah','fa fa-circle-o',1),(16,1,'tes','tes-daftar','Daftar Tes','manager/tes_daftar','fa fa-circle-o',2),(17,1,'tes','tes-hasil','Hasil Tes','manager/tes_hasil','fa fa-circle-o',6),(18,1,'modul','modul-soal','Soal','manager/modul_soal','fa fa-circle-o',3),(19,1,'tes','tes-token','Token','manager/tes_token','fa fa-circle-o',8),(22,1,'modul','modul-filemanager','File Manager','manager/modul_filemanager','fa fa-circle-o',6),(24,1,'modul','modul-import','Import Soal Spreadsheet','manager/modul_import','fa fa-circle-o',4),(25,1,'tes','tes-evaluasi','Evaluasi Tes','manager/tes_evaluasi','fa fa-circle-o',5),(28,1,'tes','tes-hasil-operator','Hasil Tes Operator','manager/tes_hasil_operator','fa fa-circle-o',10),(30,0,'','tool','Tool','#','fa fa-wrench',6),(31,1,'tool','tool-backup','Database','manager/tool_backup','fa fa-database',1),(32,1,'tes-laporan','laporan-rekap','Rekap Hasil Tes','manager/laporan_rekap_hasil','fa fa-circle-o',7),(33,1,'tool','tool-exportimport-soal','Export / Import Soal','manager/tool_exportimport_soal','fa fa-circle-o',2),(34,1,'user','user-zyacbt','Pengaturan ZYACBT','manager/pengaturan_zyacbt','fa fa-circle-o',1),(37,1,'peserta','peserta-kartu','Cetak Kartu','manager/peserta_kartu','fa fa-circle-o',5),(38,0,'','tes-laporan','Laporan','#','fa fa-print',5),(41,1,'tes-laporan','laporan-analisis-butir-soal','Analisis Butir Soal','manager/laporan_analisis_butir_soal','fa fa-circle-o',1),(42,1,'tes-laporan','laporan-analisis-soal','Analisis Soal','manager/laporan_analisis_soal','fa fa-circle-o',2),(43,1,'modul','modul-import-word','Import Soal Word','manager/modul_import_word','fa fa-circle-o',4),(44,1,'peserta','peserta-reset','Reset Login','manager/peserta_reset','fa fa-circle-o',7),(45,1,'tes','tes-jadwal','Jadwal & Matriks Tes','manager/tes_jadwal','fa fa-calendar',3),(47,1,'tes','guru-ulangan','Ulangan Harian','manager/guru_ulangan','fa fa-pencil-square-o',0),(48,1,'modul','modul-mapel','Mata Pelajaran (Modul)','manager/modul_mapel','fa fa-book',0);
/*!40000 ALTER TABLE `user_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_akses`
--

DROP TABLE IF EXISTS `user_akses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_akses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(75) NOT NULL,
  `kode_menu` varchar(50) NOT NULL,
  `add` int(2) NOT NULL DEFAULT 1 COMMENT '0=false, 1=true',
  `edit` int(2) NOT NULL DEFAULT 1 COMMENT '0=false, 1=true',
  PRIMARY KEY (`id`),
  KEY `akses_kode_menu` (`kode_menu`),
  KEY `akses_level` (`level`),
  CONSTRAINT `user_akses_ibfk_2` FOREIGN KEY (`kode_menu`) REFERENCES `user_menu` (`kode_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_akses_ibfk_3` FOREIGN KEY (`level`) REFERENCES `user_level` (`level`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=567 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_akses`
--

LOCK TABLES `user_akses` WRITE;
/*!40000 ALTER TABLE `user_akses` DISABLE KEYS */;
INSERT INTO `user_akses` VALUES (254,'operator-soal','modul-daftar',1,1),(255,'operator-soal','modul-filemanager',1,1),(256,'operator-soal','modul-import',1,1),(257,'operator-soal','modul-soal',1,1),(258,'operator-soal','modul-topik',1,1),(259,'operator-tes','tes-hasil-operator',1,1),(260,'operator-tes','tes-token',1,1),(505,'admin','laporan-analisis-butir-soal',1,1),(506,'admin','peserta-kartu',1,1),(507,'admin','peserta-group',1,1),(508,'admin','peserta-daftar',1,1),(509,'admin','modul-daftar',1,1),(510,'admin','tes-daftar',1,1),(511,'admin','tool-backup',1,1),(512,'admin','tes-evaluasi',1,1),(513,'admin','tool-exportimport-soal',1,1),(514,'admin','modul-filemanager',1,1),(515,'admin','tes-hasil',1,1),(516,'admin','peserta-import',1,1),(517,'admin','modul-import',1,1),(518,'admin','modul-import-word',1,1),(519,'admin','user_level',1,1),(520,'admin','user_menu',1,1),(521,'admin','user_atur',1,1),(522,'admin','user-zyacbt',1,1),(523,'admin','laporan-rekap',1,1),(524,'admin','peserta-reset',1,1),(525,'admin','modul-soal',1,1),(526,'admin','tes-tambah',1,1),(527,'admin','tes-token',1,1),(528,'admin','modul-topik',1,1),(529,'admin','tes-jadwal',1,1),(530,'operator-soal','tes-jadwal',1,1),(555,'guru','guru-ulangan',1,1),(556,'guru','modul-topik',1,1),(557,'guru','modul-daftar',1,1),(558,'guru','modul-soal',1,1),(559,'guru','modul-import-word',1,1),(560,'guru','tes-tambah',1,1),(561,'guru','tes-daftar',1,1),(562,'guru','tes-token',1,1),(563,'guru','tes-evaluasi',1,1),(564,'guru','tes-hasil',1,1),(565,'admin','modul-mapel',1,1),(566,'admin','modul-mapel',1,1);
/*!40000 ALTER TABLE `user_akses` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-06 16:40:34
