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
-- Table structure for table `cbt_jawaban`
--

DROP TABLE IF EXISTS `cbt_jawaban`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_jawaban` (
  `jawaban_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `jawaban_soal_id` bigint(20) unsigned NOT NULL,
  `jawaban_detail` text NOT NULL,
  `jawaban_benar` tinyint(1) NOT NULL DEFAULT 0,
  `jawaban_aktif` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`jawaban_id`),
  KEY `p_answer_question_id` (`jawaban_soal_id`),
  CONSTRAINT `cbt_jawaban_ibfk_1` FOREIGN KEY (`jawaban_soal_id`) REFERENCES `cbt_soal` (`soal_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=926 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_jawaban`
--

LOCK TABLES `cbt_jawaban` WRITE;
/*!40000 ALTER TABLE `cbt_jawaban` DISABLE KEYS */;
INSERT INTO `cbt_jawaban` VALUES (901,271,'<p>Computer Based Test</p>',1,1),(902,271,'<p>Computer Basic Training</p>',0,1),(903,271,'<p>Central Board Testing</p>',0,1),(904,271,'<p>Connection Broad Terminal</p>',0,1),(905,271,'<p>Class Based Tutorial</p>',0,1),(906,272,'<p>Kecepatan menjawab tanpa membaca soal dengan teliti</p>',0,1),(907,272,'<p>Kejujuran, kedisiplinan, dan integritas mandiri</p>',1,1),(908,272,'<p>Bekerja sama dan saling mencontek dengan teman</p>',0,1),(909,272,'<p>Membuka browser lain untuk mencari kunci jawaban</p>',0,1),(910,272,'<p>Menunggu teman selesai untuk meniru jawaban</p>',0,1),(911,273,'<p>Monitor</p>',0,1),(912,273,'<p>Keyboard</p>',1,1),(913,273,'<p>Mouse</p>',0,1),(914,273,'<p>Printer</p>',0,1),(915,273,'<p>Scanner</p>',0,1),(916,274,'<p>HTTP</p>',0,1),(917,274,'<p>HTTPS</p>',1,1),(918,274,'<p>FTP</p>',0,1),(919,274,'<p>SMTP</p>',0,1),(920,274,'<p>Telnet</p>',0,1),(921,275,'<p>Tombol Hentikan Tes</p>',0,1),(922,275,'<p>Tombol Selesai Ujian</p>',0,1),(923,275,'<p>Tombol Ragu-ragu (Warna Kuning)</p>',1,1),(924,275,'<p>Tombol Batal Ujian</p>',0,1),(925,275,'<p>Tombol Refresh Browser</p>',0,1);
/*!40000 ALTER TABLE `cbt_jawaban` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbt_konfigurasi`
--

DROP TABLE IF EXISTS `cbt_konfigurasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_konfigurasi` (
  `konfigurasi_id` int(11) NOT NULL AUTO_INCREMENT,
  `konfigurasi_kode` varchar(50) NOT NULL,
  `konfigurasi_isi` varchar(500) NOT NULL,
  `konfigurasi_keterangan` varchar(100) NOT NULL,
  PRIMARY KEY (`konfigurasi_id`),
  UNIQUE KEY `konfigurasi_kode` (`konfigurasi_kode`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_konfigurasi`
--

LOCK TABLES `cbt_konfigurasi` WRITE;
/*!40000 ALTER TABLE `cbt_konfigurasi` DISABLE KEYS */;
INSERT INTO `cbt_konfigurasi` VALUES (1,'link_login_operator','ya','Menampilkan Link Login Operator'),(2,'cbt_nama','Computer Based-Test','Nama Penyelenggara ZYACBT'),(3,'cbt_keterangan','Ujian Online Berbasis Komputer','Keterangan Penyelenggara ZYACBT'),(4,'cbt_mobile_lock_xambro','tidak','Melakukan Lock pada browser mobile agar menggunakan Xambro Saja'),(5,'cbt_informasi','<p>Silahkan pilih Tes yang diikuti dari daftar tes yang tersedia dibawah ini. Apabila tes tidak muncul, silahkan menghubungi Operator yang bertugas.</p>','Informasi yang diberika di Dashboard peserta tes\''),(6,'proteksi_multilogin','tidak','Proteksi MultiLogin Peserta Tes'),(7,'cbt_anti_cheating','ya','Fitur Anti-Cheating Browser'),(8,'cbt_tipe_soal_global','pilihan_ganda',''),(9,'cbt_use_token','tidak',''),(10,'cbt_radius_lock','ya',''),(11,'cbt_sekolah_latitude','-6.175392',''),(12,'cbt_sekolah_longitude','106.827153',''),(13,'cbt_sekolah_radius','200',''),(14,'cbt_sekolah_ip_bypass','192.168., 10., 172.16., 158.11., 127.0.0.1','');
/*!40000 ALTER TABLE `cbt_konfigurasi` ENABLE KEYS */;
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
  `modul_durasi` int(11) NOT NULL DEFAULT 90,
  PRIMARY KEY (`modul_id`),
  UNIQUE KEY `ak_module_name` (`modul_nama`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_modul`
--

LOCK TABLES `cbt_modul` WRITE;
/*!40000 ALTER TABLE `cbt_modul` DISABLE KEYS */;
INSERT INTO `cbt_modul` VALUES (9,'Default',1,90),(10,'Pendidikan Agama',1,90),(11,'PPKn',1,90),(12,'Bahasa Indonesia',1,90),(13,'Sejarah Indonesia',1,90),(14,'Bahasa Inggris',1,90),(15,'Informatika',1,90),(16,'Mapel Pilihan',1,90),(17,'Seni Budaya',1,90),(18,'Matematika',1,90),(19,'IPAS',1,90),(20,'PKK',1,90),(21,'Dasar Kejuruan (Kelas X)',1,90),(22,'Konsentrasi Keahlian (Kelas XI)',1,90),(23,'Konsentrasi Keahlian (Kelas XII)',1,90),(24,'Penjasorkes',1,90),(25,'Simulasi Ujian',1,90);
/*!40000 ALTER TABLE `cbt_modul` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbt_sessions`
--

DROP TABLE IF EXISTS `cbt_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  `ts` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_sessions`
--

LOCK TABLES `cbt_sessions` WRITE;
/*!40000 ALTER TABLE `cbt_sessions` DISABLE KEYS */;
INSERT INTO `cbt_sessions` VALUES ('5anmmbgdussbhqgu24k3b1kpgt9sl60b','192.168.137.22',1794378417,'__ci_last_regenerate|i:1794378417;','2026-11-11 06:26:57'),('5js0vprpv8nmg74l7pauill4g74jdh1f','::1',1791695619,'__ci_last_regenerate|i:1791695619;cbt_tes_tanda|s:21:\"@ZYACBT@lutfi@ZYACBT@\";cbt_tes_user_id|s:5:\"lutfi\";cbt_tes_nama|s:22:\"Muhammad Lutfial Hakim\";cbt_tes_group|s:5:\"XI MM\";cbt_tes_group_id|s:1:\"5\";cbt_user_id|s:5:\"admin\";cbt_nama|s:12:\"Achmad Lutfi\";cbt_level|s:5:\"admin\";cbt_opsi1|s:0:\"\";cbt_opsi2|s:0:\"\";','2026-10-09 05:08:04'),('62m296713g5hrpiuvhfhred8rg3abq6l','::1',1791854520,'__ci_last_regenerate|i:1791695619;cbt_tes_tanda|s:21:\"@ZYACBT@lutfi@ZYACBT@\";cbt_tes_user_id|s:5:\"lutfi\";cbt_tes_nama|s:22:\"Muhammad Lutfial Hakim\";cbt_tes_group|s:5:\"XI MM\";cbt_tes_group_id|s:1:\"5\";cbt_user_id|s:5:\"admin\";cbt_nama|s:12:\"Achmad Lutfi\";cbt_level|s:5:\"admin\";cbt_opsi1|s:0:\"\";cbt_opsi2|s:0:\"\";','2026-10-11 05:13:39'),('ht5gv32gv9qi62coiet6rhqtorlo5uii','::1',1791694627,'__ci_last_regenerate|i:1791693639;cbt_user_id|s:5:\"admin\";cbt_nama|s:12:\"Achmad Lutfi\";cbt_level|s:5:\"admin\";cbt_opsi1|s:0:\"\";cbt_opsi2|s:0:\"\";','2026-10-11 04:40:39'),('l1h15a0rnrcj33hiac32n48vjqme2lql','::1',1795156079,'__ci_last_regenerate|i:1795139383;cbt_user_id|s:5:\"admin\";cbt_nama|s:12:\"Achmad Lutfi\";cbt_level|s:5:\"admin\";cbt_opsi1|s:0:\"\";cbt_opsi2|s:0:\"\";','2026-11-20 01:49:43'),('nbnbrem4lvhkvk2e2l6uaip6ogf04v2f','192.168.2.61',1791694033,'__ci_last_regenerate|i:1791694033;','2026-10-11 04:47:13'),('rov4tbf5apajov4pdjsu8b24m2dov7hh','192.168.2.1',1791695836,'__ci_last_regenerate|i:1791694115;cbt_tes_lat|s:0:\"\";cbt_tes_lng|s:0:\"\";cbt_tes_ip|s:11:\"192.168.2.1\";cbt_tes_is_wifi|i:1;cbt_tes_tanda|s:26:\"@ZYACBT@simulasi01@ZYACBT@\";cbt_tes_user_id|s:10:\"simulasi01\";cbt_tes_nama|s:19:\"Peserta Simulasi 01\";cbt_tes_group|s:12:\"SIMULASI CBT\";cbt_tes_group_id|s:2:\"36\";','2026-10-11 04:48:35'),('tg5908er821s661bqun3jm8hub2b1nft','192.168.2.61',1791694026,'__ci_last_regenerate|i:1791694026;','2026-10-11 04:47:06');
/*!40000 ALTER TABLE `cbt_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbt_soal`
--

DROP TABLE IF EXISTS `cbt_soal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_soal` (
  `soal_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `soal_topik_id` bigint(20) unsigned NOT NULL,
  `soal_detail` text NOT NULL,
  `soal_tipe` smallint(3) unsigned NOT NULL DEFAULT 1 COMMENT '1=Pilihan ganda, 2=essay, 3=jawaban singkat',
  `soal_kunci` text DEFAULT NULL COMMENT 'Kunci untuk soal jawaban singkat',
  `soal_difficulty` smallint(6) NOT NULL DEFAULT 1,
  `soal_aktif` tinyint(1) NOT NULL DEFAULT 0,
  `soal_audio` varchar(200) DEFAULT NULL,
  `soal_audio_play` int(11) NOT NULL DEFAULT 0,
  `soal_timer` smallint(10) DEFAULT NULL,
  `soal_inline_answers` tinyint(1) NOT NULL DEFAULT 0,
  `soal_auto_next` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`soal_id`),
  KEY `p_question_subject_id` (`soal_topik_id`),
  CONSTRAINT `cbt_soal_ibfk_1` FOREIGN KEY (`soal_topik_id`) REFERENCES `cbt_topik` (`topik_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=276 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_soal`
--

LOCK TABLES `cbt_soal` WRITE;
/*!40000 ALTER TABLE `cbt_soal` DISABLE KEYS */;
INSERT INTO `cbt_soal` VALUES (271,85,'<p>Apa kepanjangan dari singkatan <b>CBT</b> dalam konteks pelaksanaan ujian sekolah modern?</p>',1,NULL,1,1,NULL,0,NULL,0,0),(272,85,'<p>SMK 11 MARET berkomitmen mencetak lulusan berakhlak mulia dan kompeten. Sikap utama yang harus dijunjung tinggi peserta saat mengikuti ujian CBT adalah...</p>',1,NULL,1,1,NULL,0,NULL,0,0),(273,85,'<p>Perangkat keras (hardware) komputer yang berfungsi sebagai papan tombol untuk memasukkan data karakter atau teks adalah...</p>',1,NULL,1,1,NULL,0,NULL,0,0),(274,85,'<p>Protokol jaringan yang digunakan untuk mengamankan transmisi data melalui enkripsi pada situs web dengan simbol gembok hijau/aman adalah...</p>',1,NULL,1,1,NULL,0,NULL,0,0),(275,85,'<p>Dalam sistem ujian <b>SMART-CBT</b>, jika peserta merasa belum yakin dengan pilihan jawaban yang dipilih pada suatu nomor soal, tombol apa yang dapat digunakan untuk menandai nomor tersebut?</p>',1,NULL,1,1,NULL,0,NULL,0,0);
/*!40000 ALTER TABLE `cbt_soal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbt_soal_koreksi`
--

DROP TABLE IF EXISTS `cbt_soal_koreksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_soal_koreksi` (
  `koreksi_id` int(11) NOT NULL AUTO_INCREMENT,
  `koreksi_topik_id` int(11) NOT NULL,
  `koreksi_soal_id` int(11) NOT NULL,
  `koreksi_guru_nama` varchar(150) NOT NULL,
  `koreksi_catatan` text NOT NULL,
  `koreksi_status` varchar(20) NOT NULL DEFAULT 'pending',
  `koreksi_created_at` datetime NOT NULL,
  `koreksi_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`koreksi_id`),
  KEY `idx_topik` (`koreksi_topik_id`),
  KEY `idx_soal` (`koreksi_soal_id`),
  KEY `idx_status` (`koreksi_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_soal_koreksi`
--

LOCK TABLES `cbt_soal_koreksi` WRITE;
/*!40000 ALTER TABLE `cbt_soal_koreksi` DISABLE KEYS */;
/*!40000 ALTER TABLE `cbt_soal_koreksi` ENABLE KEYS */;
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
  `tes_score_right` decimal(10,4) DEFAULT 1.0000,
  `tes_score_wrong` decimal(10,2) DEFAULT 0.00,
  `tes_score_unanswered` decimal(10,2) DEFAULT 0.00,
  `tes_max_score` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tes_token` tinyint(1) DEFAULT 0,
  `tes_user_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`tes_id`),
  UNIQUE KEY `ak_test_name` (`tes_nama`)
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_tes`
--

LOCK TABLES `cbt_tes` WRITE;
/*!40000 ALTER TABLE `cbt_tes` DISABLE KEYS */;
INSERT INTO `cbt_tes` VALUES (180,'[SENIN-1] STS X [PAGI - Rombel 1] - Pendidikan Agama','Senin','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Senin (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-12 07:15:00','2026-10-12 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(181,'[SENIN-1] STS X [SIANG - Rombel 2] - Pendidikan Agama','Senin','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Senin (Jam Ke-1 Shift Siang 13.00 - 14.30)','2026-10-12 12:45:00','2026-10-12 15:00:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(182,'[SENIN-1] STS XI [SIANG] - Pendidikan Agama','Senin','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Senin (Jam Ke-1 Shift Siang 13.00 - 14.30)','2026-10-12 12:45:00','2026-10-12 15:00:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(183,'[SENIN-1] STS XII [PAGI] - Pendidikan Agama','Senin','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Senin (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-12 07:15:00','2026-10-12 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(184,'[SENIN-2] STS X [PAGI - Rombel 1] - PPKn','Senin','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Senin (Jam Ke-2 Shift Pagi 09.30 - 11.00)','2026-10-12 09:15:00','2026-10-12 11:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(185,'[SENIN-2] STS X [SIANG - Rombel 2] - PPKn','Senin','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Senin (Jam Ke-2 Shift Siang 15.00 - 16.30)','2026-10-12 14:45:00','2026-10-12 17:00:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(186,'[SENIN-2] STS XI [SIANG] - PPKn','Senin','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Senin (Jam Ke-2 Shift Siang 15.00 - 16.30)','2026-10-12 14:45:00','2026-10-12 17:00:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(187,'[SENIN-2] STS XII [PAGI] - PPKn','Senin','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Senin (Jam Ke-2 Shift Pagi 09.30 - 11.00)','2026-10-12 09:15:00','2026-10-12 11:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(188,'[SELASA-1] STS X [PAGI - Rombel 1] - Bahasa Indonesia','Selasa','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Selasa (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-13 07:15:00','2026-10-13 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(189,'[SELASA-1] STS X [SIANG - Rombel 2] - Bahasa Indonesia','Selasa','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Selasa (Jam Ke-1 Shift Siang 13.00 - 14.30)','2026-10-13 12:45:00','2026-10-13 15:00:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(190,'[SELASA-1] STS XI [SIANG] - Bahasa Indonesia','Selasa','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Selasa (Jam Ke-1 Shift Siang 13.00 - 14.30)','2026-10-13 12:45:00','2026-10-13 15:00:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(191,'[SELASA-1] STS XII [PAGI] - Bahasa Indonesia','Selasa','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Selasa (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-13 07:15:00','2026-10-13 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(192,'[SELASA-2] STS X [PAGI - Rombel 1] - Sejarah Indonesia','Selasa','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Selasa (Jam Ke-2 Shift Pagi 09.30 - 11.00)','2026-10-13 09:15:00','2026-10-13 11:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(193,'[SELASA-2] STS X [SIANG - Rombel 2] - Sejarah Indonesia','Selasa','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Selasa (Jam Ke-2 Shift Siang 15.00 - 16.30)','2026-10-13 14:45:00','2026-10-13 17:00:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(194,'[SELASA-2] STS XI [SIANG] - Sejarah Indonesia','Selasa','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Selasa (Jam Ke-2 Shift Siang 15.00 - 16.30)','2026-10-13 14:45:00','2026-10-13 17:00:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(195,'[SELASA-2] STS XII [PAGI] - Sejarah Indonesia','Selasa','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Selasa (Jam Ke-2 Shift Pagi 09.30 - 11.00)','2026-10-13 09:15:00','2026-10-13 11:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(196,'[RABU-1] STS X [PAGI - Rombel 1] - Bahasa Inggris','Rabu','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-14 07:15:00','2026-10-14 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(197,'[RABU-1] STS X [SIANG - Rombel 2] - Bahasa Inggris','Rabu','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-1 Shift Siang 13.00 - 14.30)','2026-10-14 12:45:00','2026-10-14 15:00:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(198,'[RABU-1] STS XI [SIANG] - Bahasa Inggris','Rabu','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-1 Shift Siang 13.00 - 14.30)','2026-10-14 12:45:00','2026-10-14 15:00:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(199,'[RABU-1] STS XII [PAGI] - Bahasa Inggris','Rabu','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-14 07:15:00','2026-10-14 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(200,'[RABU-2] STS X [PAGI - Rombel 1] - Informatika','Rabu','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-2 Shift Pagi 09.00 - 10.00)','2026-10-14 08:45:00','2026-10-14 10:30:00',60,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(201,'[RABU-2] STS X [SIANG - Rombel 2] - Informatika','Rabu','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-2 Shift Siang 14.30 - 15.30)','2026-10-14 14:15:00','2026-10-14 16:00:00',60,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(202,'[RABU-2] STS XI [SIANG] - Mapel Pilihan (AKL)','Rabu','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-2 Shift Siang 14.30 - 15.30)','2026-10-14 14:15:00','2026-10-14 16:00:00',60,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(203,'[RABU-2] STS XI [SIANG] - Mapel Pilihan (OTKP)','Rabu','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-2 Shift Siang 14.30 - 15.30)','2026-10-14 14:15:00','2026-10-14 16:00:00',60,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(204,'[RABU-2] STS XI [SIANG] - Mapel Pilihan (TKJ)','Rabu','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-2 Shift Siang 14.30 - 15.30)','2026-10-14 14:15:00','2026-10-14 16:00:00',60,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(205,'[RABU-2] STS XI [SIANG] - Mapel Pilihan (TKRO)','Rabu','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-2 Shift Siang 14.30 - 15.30)','2026-10-14 14:15:00','2026-10-14 16:00:00',60,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(206,'[RABU-2] STS XI [SIANG] - Mapel Pilihan (TBSM)','Rabu','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-2 Shift Siang 14.30 - 15.30)','2026-10-14 14:15:00','2026-10-14 16:00:00',60,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(207,'[RABU-3] STS X [PAGI - Rombel 1] - Seni Budaya','Rabu','Pagi','Jam Ke-3','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-3 Shift Pagi 10.30 - 11.30)','2026-10-14 10:15:00','2026-10-14 12:00:00',60,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(208,'[RABU-3] STS X [SIANG - Rombel 2] - Seni Budaya','Rabu','Siang','Jam Ke-3','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-3 Shift Siang 16.00 - 17.00)','2026-10-14 15:45:00','2026-10-14 17:30:00',60,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(209,'[RABU-3] STS XI [SIANG] - Seni Budaya','Rabu','Siang','Jam Ke-3','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-3 Shift Siang 16.00 - 17.00)','2026-10-14 15:45:00','2026-10-14 17:30:00',60,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(210,'[RABU-3] STS XII [PAGI] - Seni Budaya','Rabu','Pagi','Jam Ke-3','STS Ganjil 2026/2027 SMK 11 Maret - Rabu (Jam Ke-3 Shift Pagi 10.30 - 11.30)','2026-10-14 10:15:00','2026-10-14 12:00:00',60,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(211,'[KAMIS-1] STS X [PAGI - Rombel 1] - Matematika','Kamis','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Kamis (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-15 07:15:00','2026-10-15 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(212,'[KAMIS-1] STS X [SIANG - Rombel 2] - Matematika','Kamis','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Kamis (Jam Ke-1 Shift Siang 13.00 - 14.30)','2026-10-15 12:45:00','2026-10-15 15:00:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(213,'[KAMIS-1] STS XI [SIANG] - Matematika','Kamis','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Kamis (Jam Ke-1 Shift Siang 13.00 - 14.30)','2026-10-15 12:45:00','2026-10-15 15:00:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(214,'[KAMIS-1] STS XII [PAGI] - Matematika','Kamis','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Kamis (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-15 07:15:00','2026-10-15 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(215,'[KAMIS-2] STS X [PAGI - Rombel 1] - IPAS','Kamis','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Kamis (Jam Ke-2 Shift Pagi 09.30 - 11.00)','2026-10-15 09:15:00','2026-10-15 11:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(216,'[KAMIS-2] STS X [SIANG - Rombel 2] - IPAS','Kamis','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Kamis (Jam Ke-2 Shift Siang 15.00 - 16.30)','2026-10-15 14:45:00','2026-10-15 17:00:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(217,'[KAMIS-2] STS XI [SIANG] - PKK','Kamis','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Kamis (Jam Ke-2 Shift Siang 15.00 - 16.30)','2026-10-15 14:45:00','2026-10-15 17:00:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(218,'[KAMIS-2] STS XII [PAGI] - PKK','Kamis','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Kamis (Jam Ke-2 Shift Pagi 09.30 - 11.00)','2026-10-15 09:15:00','2026-10-15 11:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(219,'[JUMAT-1] STS X [PAGI - Rombel 1] - Dasar-2 AKL','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(220,'[JUMAT-1] STS X [SIANG - Rombel 2] - Dasar-2 AKL','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(221,'[JUMAT-1] STS X [PAGI - Rombel 1] - Dasar-2 MPLB','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(222,'[JUMAT-1] STS X [SIANG - Rombel 2] - Dasar-2 MPLB','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(223,'[JUMAT-1] STS X [PAGI - Rombel 1] - Dasar-2 TJKT','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(224,'[JUMAT-1] STS X [SIANG - Rombel 2] - Dasar-2 TJKT','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(225,'[JUMAT-1] STS X [PAGI - Rombel 1] - Dasar-2 Otomotif','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(226,'[JUMAT-1] STS X [SIANG - Rombel 2] - Dasar-2 Otomotif','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(227,'[JUMAT-1] STS XI [SIANG] - Keahlian AKL','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(228,'[JUMAT-1] STS XI [SIANG] - Keahlian MP','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(229,'[JUMAT-1] STS XI [SIANG] - Keahlian TKJ','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(230,'[JUMAT-1] STS XI [SIANG] - Keahlian TKR','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(231,'[JUMAT-1] STS XI [SIANG] - Keahlian TSM','Jumat','Siang','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Siang 13.30 - 15.00)','2026-10-16 13:15:00','2026-10-16 15:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(232,'[JUMAT-1] STS XII [PAGI] - Keahlian AKL','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(233,'[JUMAT-1] STS XII [PAGI] - Keahlian MP','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(234,'[JUMAT-1] STS XII [PAGI] - Keahlian TKJ','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(235,'[JUMAT-1] STS XII [PAGI] - Keahlian TKR','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(236,'[JUMAT-1] STS XII [PAGI] - Keahlian TSM','Jumat','Pagi','Jam Ke-1','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-1 Shift Pagi 07.30 - 09.00)','2026-10-16 07:15:00','2026-10-16 09:30:00',90,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(237,'[JUMAT-2] STS X [PAGI - Rombel 1] - Penjasorkes','Jumat','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-2 Shift Pagi 09.30 - 10.30)','2026-10-16 09:15:00','2026-10-16 11:00:00',60,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(238,'[JUMAT-2] STS X [SIANG - Rombel 2] - Penjasorkes','Jumat','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-2 Shift Siang 15.30 - 16.30)','2026-10-16 15:15:00','2026-10-16 17:00:00',60,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(239,'[JUMAT-2] STS XI [SIANG] - Penjasorkes','Jumat','Siang','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-2 Shift Siang 15.30 - 16.30)','2026-10-16 15:15:00','2026-10-16 17:00:00',60,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(240,'[JUMAT-2] STS XII [PAGI] - Penjasorkes','Jumat','Pagi','Jam Ke-2','STS Ganjil 2026/2027 SMK 11 Maret - Jumat (Jam Ke-2 Shift Pagi 09.30 - 10.30)','2026-10-16 09:15:00','2026-10-16 11:00:00',60,'*.*.*.*',0,0,2.5000,0.00,0.00,100.00,0,1),(241,'[SIMULASI] Simulasi Ujian SMART-CBT SMK 11 MARET',NULL,NULL,NULL,'Simulasi Ujian Berbasis Komputer SMK 11 MARET. Silakan jawab 5 soal berikut dengan teliti.','2026-11-20 00:00:00','2027-11-20 23:59:59',60,'*.*.*.*',1,1,20.0000,0.00,0.00,100.00,0,1);
/*!40000 ALTER TABLE `cbt_tes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbt_tes_soal`
--

DROP TABLE IF EXISTS `cbt_tes_soal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_tes_soal` (
  `tessoal_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tessoal_tesuser_id` bigint(20) unsigned NOT NULL,
  `tessoal_user_ip` varchar(39) DEFAULT NULL,
  `tessoal_soal_id` bigint(20) unsigned NOT NULL,
  `tessoal_jawaban_text` text DEFAULT NULL,
  `tessoal_nilai` decimal(10,4) DEFAULT NULL,
  `tessoal_creation_time` datetime DEFAULT NULL,
  `tessoal_display_time` datetime DEFAULT NULL,
  `tessoal_change_time` datetime DEFAULT NULL,
  `tessoal_reaction_time` bigint(20) unsigned NOT NULL DEFAULT 0,
  `tessoal_ragu` int(1) NOT NULL DEFAULT 0 COMMENT '1=ragu, 0=tidak ragu',
  `tessoal_order` smallint(6) NOT NULL DEFAULT 1,
  `tessoal_num_answers` smallint(5) unsigned NOT NULL DEFAULT 0,
  `tessoal_comment` text DEFAULT NULL,
  `tessoal_audio_play` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`tessoal_id`),
  UNIQUE KEY `ak_testuser_question` (`tessoal_tesuser_id`,`tessoal_soal_id`),
  KEY `p_testlog_question_id` (`tessoal_soal_id`),
  KEY `p_testlog_testuser_id` (`tessoal_tesuser_id`),
  CONSTRAINT `cbt_tes_soal_ibfk_1` FOREIGN KEY (`tessoal_tesuser_id`) REFERENCES `cbt_tes_user` (`tesuser_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `cbt_tes_soal_ibfk_2` FOREIGN KEY (`tessoal_soal_id`) REFERENCES `cbt_soal` (`soal_id`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_tes_soal`
--

LOCK TABLES `cbt_tes_soal` WRITE;
/*!40000 ALTER TABLE `cbt_tes_soal` DISABLE KEYS */;
/*!40000 ALTER TABLE `cbt_tes_soal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbt_tes_soal_jawaban`
--

DROP TABLE IF EXISTS `cbt_tes_soal_jawaban`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_tes_soal_jawaban` (
  `soaljawaban_tessoal_id` bigint(20) unsigned NOT NULL,
  `soaljawaban_jawaban_id` bigint(20) unsigned NOT NULL,
  `soaljawaban_selected` smallint(6) NOT NULL DEFAULT -1,
  `soaljawaban_order` smallint(6) NOT NULL DEFAULT 1,
  `soaljawaban_position` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`soaljawaban_tessoal_id`,`soaljawaban_jawaban_id`),
  KEY `p_logansw_answer_id` (`soaljawaban_jawaban_id`),
  KEY `p_logansw_testlog_id` (`soaljawaban_tessoal_id`),
  CONSTRAINT `cbt_tes_soal_jawaban_ibfk_1` FOREIGN KEY (`soaljawaban_tessoal_id`) REFERENCES `cbt_tes_soal` (`tessoal_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `cbt_tes_soal_jawaban_ibfk_2` FOREIGN KEY (`soaljawaban_jawaban_id`) REFERENCES `cbt_jawaban` (`jawaban_id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_tes_soal_jawaban`
--

LOCK TABLES `cbt_tes_soal_jawaban` WRITE;
/*!40000 ALTER TABLE `cbt_tes_soal_jawaban` DISABLE KEYS */;
/*!40000 ALTER TABLE `cbt_tes_soal_jawaban` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbt_tes_token`
--

DROP TABLE IF EXISTS `cbt_tes_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_tes_token` (
  `token_id` int(11) NOT NULL AUTO_INCREMENT,
  `token_isi` varchar(20) NOT NULL,
  `token_user_id` int(11) NOT NULL,
  `token_ts` timestamp NOT NULL DEFAULT current_timestamp(),
  `token_aktif` int(11) NOT NULL DEFAULT 1 COMMENT 'Umur Token dalam menit, 1 = 1 hari penuh',
  `token_tes_id` bigint(20) NOT NULL DEFAULT 0,
  PRIMARY KEY (`token_id`),
  KEY `token_user_id` (`token_user_id`),
  CONSTRAINT `cbt_tes_token_ibfk_1` FOREIGN KEY (`token_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_tes_token`
--

LOCK TABLES `cbt_tes_token` WRITE;
/*!40000 ALTER TABLE `cbt_tes_token` DISABLE KEYS */;
INSERT INTO `cbt_tes_token` VALUES (12,'299403',5,'2019-12-12 02:53:22',1,0);
/*!40000 ALTER TABLE `cbt_tes_token` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=315 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_tes_topik_set`
--

LOCK TABLES `cbt_tes_topik_set` WRITE;
/*!40000 ALTER TABLE `cbt_tes_topik_set` DISABLE KEYS */;
INSERT INTO `cbt_tes_topik_set` VALUES (252,180,12,1,1,40,5,1,1),(253,181,12,1,1,40,5,1,1),(254,182,13,1,1,40,5,1,1),(255,183,14,1,1,40,5,1,1),(256,184,15,1,1,40,5,1,1),(257,185,15,1,1,40,5,1,1),(258,186,16,1,1,40,5,1,1),(259,187,17,1,1,40,5,1,1),(260,188,18,1,1,40,5,1,1),(261,189,18,1,1,40,5,1,1),(262,190,19,1,1,40,5,1,1),(263,191,20,1,1,40,5,1,1),(264,192,21,1,1,40,5,1,1),(265,193,21,1,1,40,5,1,1),(266,194,22,1,1,40,5,1,1),(267,195,23,1,1,40,5,1,1),(268,196,24,1,1,40,5,1,1),(269,197,24,1,1,40,5,1,1),(270,198,25,1,1,40,5,1,1),(271,199,26,1,1,40,5,1,1),(272,200,27,1,1,40,5,1,1),(273,201,27,1,1,40,5,1,1),(274,202,28,1,1,40,5,1,1),(275,203,29,1,1,40,5,1,1),(276,204,30,1,1,40,5,1,1),(277,205,31,1,1,40,5,1,1),(278,206,32,1,1,40,5,1,1),(279,207,33,1,1,40,5,1,1),(280,208,33,1,1,40,5,1,1),(281,209,34,1,1,40,5,1,1),(282,210,35,1,1,40,5,1,1),(283,211,36,1,1,40,5,1,1),(284,212,36,1,1,40,5,1,1),(285,213,37,1,1,40,5,1,1),(286,214,38,1,1,40,5,1,1),(287,215,39,1,1,40,5,1,1),(288,216,39,1,1,40,5,1,1),(289,217,40,1,1,40,5,1,1),(290,218,41,1,1,40,5,1,1),(291,219,42,1,1,40,5,1,1),(292,220,42,1,1,40,5,1,1),(293,221,43,1,1,40,5,1,1),(294,222,43,1,1,40,5,1,1),(295,223,44,1,1,40,5,1,1),(296,224,44,1,1,40,5,1,1),(297,225,45,1,1,40,5,1,1),(298,226,45,1,1,40,5,1,1),(299,227,46,1,1,40,5,1,1),(300,228,47,1,1,40,5,1,1),(301,229,48,1,1,40,5,1,1),(302,230,49,1,1,40,5,1,1),(303,231,50,1,1,40,5,1,1),(304,232,51,1,1,40,5,1,1),(305,233,52,1,1,40,5,1,1),(306,234,53,1,1,40,5,1,1),(307,235,54,1,1,40,5,1,1),(308,236,55,1,1,40,5,1,1),(309,237,56,1,1,40,5,1,1),(310,238,56,1,1,40,5,1,1),(311,239,57,1,1,40,5,1,1),(312,240,58,1,1,40,5,1,1),(314,241,85,1,1,5,5,1,1);
/*!40000 ALTER TABLE `cbt_tes_topik_set` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbt_tes_user`
--

DROP TABLE IF EXISTS `cbt_tes_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_tes_user` (
  `tesuser_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tesuser_tes_id` bigint(20) unsigned NOT NULL,
  `tesuser_user_id` bigint(20) unsigned NOT NULL,
  `tesuser_status` smallint(5) unsigned NOT NULL DEFAULT 0,
  `tesuser_pelanggaran` int(11) NOT NULL DEFAULT 0,
  `tesuser_creation_time` datetime NOT NULL,
  `tesuser_comment` text DEFAULT NULL,
  `tesuser_token` varchar(10) DEFAULT NULL,
  `tesuser_ip` varchar(50) DEFAULT NULL,
  `tesuser_lat` varchar(50) DEFAULT NULL,
  `tesuser_lng` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`tesuser_id`),
  UNIQUE KEY `ak_testuser` (`tesuser_tes_id`,`tesuser_user_id`,`tesuser_status`),
  KEY `p_testuser_user_id` (`tesuser_user_id`),
  KEY `p_testuser_test_id` (`tesuser_tes_id`),
  CONSTRAINT `cbt_tes_user_ibfk_1` FOREIGN KEY (`tesuser_tes_id`) REFERENCES `cbt_tes` (`tes_id`) ON DELETE CASCADE,
  CONSTRAINT `cbt_tes_user_ibfk_2` FOREIGN KEY (`tesuser_user_id`) REFERENCES `cbt_user` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_tes_user`
--

LOCK TABLES `cbt_tes_user` WRITE;
/*!40000 ALTER TABLE `cbt_tes_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `cbt_tes_user` ENABLE KEYS */;
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
INSERT INTO `cbt_tesgrup` VALUES (180,6),(180,8),(180,10),(180,12),(180,14),(181,7),(181,9),(181,11),(181,13),(181,15),(182,16),(182,17),(182,18),(182,19),(182,20),(182,21),(182,22),(182,23),(182,24),(182,25),(183,26),(183,27),(183,28),(183,29),(183,30),(183,31),(183,32),(183,33),(183,34),(183,35),(184,6),(184,8),(184,10),(184,12),(184,14),(185,7),(185,9),(185,11),(185,13),(185,15),(186,16),(186,17),(186,18),(186,19),(186,20),(186,21),(186,22),(186,23),(186,24),(186,25),(187,26),(187,27),(187,28),(187,29),(187,30),(187,31),(187,32),(187,33),(187,34),(187,35),(188,6),(188,8),(188,10),(188,12),(188,14),(189,7),(189,9),(189,11),(189,13),(189,15),(190,16),(190,17),(190,18),(190,19),(190,20),(190,21),(190,22),(190,23),(190,24),(190,25),(191,26),(191,27),(191,28),(191,29),(191,30),(191,31),(191,32),(191,33),(191,34),(191,35),(192,6),(192,8),(192,10),(192,12),(192,14),(193,7),(193,9),(193,11),(193,13),(193,15),(194,16),(194,17),(194,18),(194,19),(194,20),(194,21),(194,22),(194,23),(194,24),(194,25),(195,26),(195,27),(195,28),(195,29),(195,30),(195,31),(195,32),(195,33),(195,34),(195,35),(196,6),(196,8),(196,10),(196,12),(196,14),(197,7),(197,9),(197,11),(197,13),(197,15),(198,16),(198,17),(198,18),(198,19),(198,20),(198,21),(198,22),(198,23),(198,24),(198,25),(199,26),(199,27),(199,28),(199,29),(199,30),(199,31),(199,32),(199,33),(199,34),(199,35),(200,6),(200,8),(200,10),(200,12),(200,14),(201,7),(201,9),(201,11),(201,13),(201,15),(202,16),(202,17),(203,18),(203,19),(204,20),(204,21),(205,22),(205,23),(206,24),(206,25),(207,6),(207,8),(207,10),(207,12),(207,14),(208,7),(208,9),(208,11),(208,13),(208,15),(209,16),(209,17),(209,18),(209,19),(209,20),(209,21),(209,22),(209,23),(209,24),(209,25),(210,26),(210,27),(210,28),(210,29),(210,30),(210,31),(210,32),(210,33),(210,34),(210,35),(211,6),(211,8),(211,10),(211,12),(211,14),(212,7),(212,9),(212,11),(212,13),(212,15),(213,16),(213,17),(213,18),(213,19),(213,20),(213,21),(213,22),(213,23),(213,24),(213,25),(214,26),(214,27),(214,28),(214,29),(214,30),(214,31),(214,32),(214,33),(214,34),(214,35),(215,6),(215,8),(215,10),(215,12),(215,14),(216,7),(216,9),(216,11),(216,13),(216,15),(217,16),(217,17),(217,18),(217,19),(217,20),(217,21),(217,22),(217,23),(217,24),(217,25),(218,26),(218,27),(218,28),(218,29),(218,30),(218,31),(218,32),(218,33),(218,34),(218,35),(219,8),(220,9),(221,10),(222,11),(223,6),(224,7),(225,12),(225,14),(226,13),(226,15),(227,16),(227,17),(228,18),(228,19),(229,20),(229,21),(230,22),(230,23),(231,24),(231,25),(232,26),(232,27),(233,28),(233,29),(234,30),(234,31),(235,32),(235,33),(236,34),(236,35),(237,6),(237,8),(237,10),(237,12),(237,14),(238,7),(238,9),(238,11),(238,13),(238,15),(239,16),(239,17),(239,18),(239,19),(239,20),(239,21),(239,22),(239,23),(239,24),(239,25),(240,26),(240,27),(240,28),(240,29),(240,30),(240,31),(240,32),(240,33),(240,34),(240,35),(241,6),(241,7),(241,8),(241,9),(241,10),(241,11),(241,12),(241,13),(241,14),(241,15),(241,16),(241,17),(241,18),(241,19),(241,20),(241,21),(241,22),(241,23),(241,24),(241,25),(241,26),(241,27),(241,28),(241,29),(241,30),(241,31),(241,32),(241,33),(241,34),(241,35),(241,36);
/*!40000 ALTER TABLE `cbt_tesgrup` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_topik`
--

LOCK TABLES `cbt_topik` WRITE;
/*!40000 ALTER TABLE `cbt_topik` DISABLE KEYS */;
INSERT INTO `cbt_topik` VALUES (11,9,'Dasar Dasar Jaringan Komputer X TKJ','Dasar Dasar Jaringan Komputer X TKJ',1,'panitia',1),(12,10,'[SENIN-1] STS X - Pendidikan Agama','[SENIN-1] STS X - Pendidikan Agama',1,'panitia',1),(13,10,'[SENIN-1] STS XI - Pendidikan Agama','[SENIN-1] STS XI - Pendidikan Agama',1,'panitia',1),(14,10,'[SENIN-1] STS XII - Pendidikan Agama','[SENIN-1] STS XII - Pendidikan Agama',1,'panitia',1),(15,11,'[SENIN-2] STS X - PPKn','[SENIN-2] STS X - PPKn',1,'panitia',1),(16,11,'[SENIN-2] STS XI - PPKn','[SENIN-2] STS XI - PPKn',1,'panitia',1),(17,11,'[SENIN-2] STS XII - PPKn','[SENIN-2] STS XII - PPKn',1,'panitia',1),(18,12,'[SELASA-1] STS X - Bahasa Indonesia','[SELASA-1] STS X - Bahasa Indonesia',1,'panitia',1),(19,12,'[SELASA-1] STS XI - Bahasa Indonesia','[SELASA-1] STS XI - Bahasa Indonesia',1,'panitia',1),(20,12,'[SELASA-1] STS XII - Bahasa Indonesia','[SELASA-1] STS XII - Bahasa Indonesia',1,'panitia',1),(21,13,'[SELASA-2] STS X - Sejarah Indonesia','[SELASA-2] STS X - Sejarah Indonesia',1,'panitia',1),(22,13,'[SELASA-2] STS XI - Sejarah Indonesia','[SELASA-2] STS XI - Sejarah Indonesia',1,'panitia',1),(23,13,'[SELASA-2] STS XII - Sejarah Indonesia','[SELASA-2] STS XII - Sejarah Indonesia',1,'panitia',1),(24,14,'[RABU-1] STS X - Bahasa Inggris','[RABU-1] STS X - Bahasa Inggris',1,'panitia',1),(25,14,'[RABU-1] STS XI - Bahasa Inggris','[RABU-1] STS XI - Bahasa Inggris',1,'panitia',1),(26,14,'[RABU-1] STS XII - Bahasa Inggris','[RABU-1] STS XII - Bahasa Inggris',1,'panitia',1),(27,15,'[RABU-2] STS X - Informatika','[RABU-2] STS X - Informatika',1,'panitia',1),(28,16,'[RABU-2] STS XI - Mapel Pilihan (AKL)','[RABU-2] STS XI - Mapel Pilihan (AKL)',1,'panitia',1),(29,16,'[RABU-2] STS XI - Mapel Pilihan (OTKP)','[RABU-2] STS XI - Mapel Pilihan (OTKP)',1,'panitia',1),(30,16,'[RABU-2] STS XI - Mapel Pilihan (TKJ)','[RABU-2] STS XI - Mapel Pilihan (TKJ)',1,'panitia',1),(31,16,'[RABU-2] STS XI - Mapel Pilihan (TKRO)','[RABU-2] STS XI - Mapel Pilihan (TKRO)',1,'panitia',1),(32,16,'[RABU-2] STS XI - Mapel Pilihan (TBSM)','[RABU-2] STS XI - Mapel Pilihan (TBSM)',1,'panitia',1),(33,17,'[RABU-3] STS X - Seni Budaya','[RABU-3] STS X - Seni Budaya',1,'panitia',1),(34,17,'[RABU-3] STS XI - Seni Budaya','[RABU-3] STS XI - Seni Budaya',1,'panitia',1),(35,17,'[RABU-3] STS XII - Seni Budaya','[RABU-3] STS XII - Seni Budaya',1,'panitia',1),(36,18,'[KAMIS-1] STS X - Matematika','[KAMIS-1] STS X - Matematika',1,'panitia',1),(37,18,'[KAMIS-1] STS XI - Matematika','[KAMIS-1] STS XI - Matematika',1,'panitia',1),(38,18,'[KAMIS-1] STS XII - Matematika','[KAMIS-1] STS XII - Matematika',1,'panitia',1),(39,19,'[KAMIS-2] STS X - IPAS','[KAMIS-2] STS X - IPAS',1,'panitia',1),(40,20,'[KAMIS-2] STS XI - PKK','[KAMIS-2] STS XI - PKK',1,'panitia',1),(41,20,'[KAMIS-2] STS XII - PKK','[KAMIS-2] STS XII - PKK',1,'panitia',1),(42,21,'[JUMAT-1] STS X - Dasar-2 AKL','[JUMAT-1] STS X - Dasar-2 AKL',1,'panitia',1),(43,21,'[JUMAT-1] STS X - Dasar-2 MPLB','[JUMAT-1] STS X - Dasar-2 MPLB',1,'panitia',1),(44,21,'[JUMAT-1] STS X - Dasar-2 TJKT','[JUMAT-1] STS X - Dasar-2 TJKT',1,'panitia',1),(45,21,'[JUMAT-1] STS X - Dasar-2 Otomotif','[JUMAT-1] STS X - Dasar-2 Otomotif',1,'panitia',1),(46,22,'[JUMAT-1] STS XI - Keahlian AKL','[JUMAT-1] STS XI - Keahlian AKL',1,'panitia',1),(47,22,'[JUMAT-1] STS XI - Keahlian MP','[JUMAT-1] STS XI - Keahlian MP',1,'panitia',1),(48,22,'[JUMAT-1] STS XI - Keahlian TKJ','[JUMAT-1] STS XI - Keahlian TKJ',1,'panitia',1),(49,22,'[JUMAT-1] STS XI - Keahlian TKR','[JUMAT-1] STS XI - Keahlian TKR',1,'panitia',1),(50,22,'[JUMAT-1] STS XI - Keahlian TSM','[JUMAT-1] STS XI - Keahlian TSM',1,'panitia',1),(51,23,'[JUMAT-1] STS XII - Keahlian AKL','[JUMAT-1] STS XII - Keahlian AKL',1,'panitia',1),(52,23,'[JUMAT-1] STS XII - Keahlian MP','[JUMAT-1] STS XII - Keahlian MP',1,'panitia',1),(53,23,'[JUMAT-1] STS XII - Keahlian TKJ','[JUMAT-1] STS XII - Keahlian TKJ',1,'panitia',1),(54,23,'[JUMAT-1] STS XII - Keahlian TKR','[JUMAT-1] STS XII - Keahlian TKR',1,'panitia',1),(55,23,'[JUMAT-1] STS XII - Keahlian TSM','[JUMAT-1] STS XII - Keahlian TSM',1,'panitia',1),(56,24,'[JUMAT-2] STS X - Penjasorkes','[JUMAT-2] STS X - Penjasorkes',1,'panitia',1),(57,24,'[JUMAT-2] STS XI - Penjasorkes','[JUMAT-2] STS XI - Penjasorkes',1,'panitia',1),(58,24,'[JUMAT-2] STS XII - Penjasorkes','[JUMAT-2] STS XII - Penjasorkes',1,'panitia',1),(85,25,'Latihan & Simulasi SMART-CBT','Bank Soal Simulasi Ujian Berbasis Komputer SMK 11 MARET',1,'panitia',0);
/*!40000 ALTER TABLE `cbt_topik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbt_topik_verifikasi`
--

DROP TABLE IF EXISTS `cbt_topik_verifikasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_topik_verifikasi` (
  `verifikasi_id` int(11) NOT NULL AUTO_INCREMENT,
  `verifikasi_topik_id` int(11) NOT NULL,
  `verifikasi_guru_nama` varchar(150) NOT NULL,
  `verifikasi_guru_nip` varchar(50) DEFAULT NULL,
  `verifikasi_status` varchar(20) NOT NULL DEFAULT 'sesuai',
  `verifikasi_catatan` text DEFAULT NULL,
  `verifikasi_ttd` text DEFAULT NULL,
  `verifikasi_created_at` datetime NOT NULL,
  `verifikasi_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`verifikasi_id`),
  UNIQUE KEY `uk_topik` (`verifikasi_topik_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_topik_verifikasi`
--

LOCK TABLES `cbt_topik_verifikasi` WRITE;
/*!40000 ALTER TABLE `cbt_topik_verifikasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `cbt_topik_verifikasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbt_user`
--

DROP TABLE IF EXISTS `cbt_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbt_user` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` int(11) NOT NULL DEFAULT 0 COMMENT ' 	0=Tidak Login, 1=Login ',
  `user_login_date` date DEFAULT NULL,
  `user_grup_id` bigint(20) unsigned NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_regdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_ip` varchar(39) DEFAULT NULL,
  `user_firstname` varchar(255) DEFAULT NULL,
  `user_birthdate` date DEFAULT NULL,
  `user_birthplace` varchar(255) DEFAULT NULL,
  `user_level` smallint(3) unsigned NOT NULL DEFAULT 1,
  `user_detail` varchar(25) DEFAULT NULL,
  `user_lat` varchar(50) DEFAULT NULL,
  `user_lng` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `ak_user_name` (`user_name`),
  KEY `user_groups_id` (`user_grup_id`),
  KEY `user_detail` (`user_detail`),
  CONSTRAINT `cbt_user_ibfk_1` FOREIGN KEY (`user_grup_id`) REFERENCES `cbt_user_grup` (`grup_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_user`
--

LOCK TABLES `cbt_user` WRITE;
/*!40000 ALTER TABLE `cbt_user` DISABLE KEYS */;
INSERT INTO `cbt_user` VALUES (3,0,NULL,6,'sutrisno','sutrisno','waktu','2026-09-25 16:13:03',NULL,'sutrisno',NULL,NULL,1,'gsg',NULL,NULL),(4,0,'2026-10-11',36,'simulasi01','simulasi01',NULL,'2026-10-11 04:43:57','192.168.2.1','Peserta Simulasi 01',NULL,NULL,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `cbt_user` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbt_user_grup`
--

LOCK TABLES `cbt_user_grup` WRITE;
/*!40000 ALTER TABLE `cbt_user_grup` DISABLE KEYS */;
INSERT INTO `cbt_user_grup` VALUES (36,'SIMULASI CBT'),(8,'X AKL 1'),(9,'X AKL 2'),(10,'X OTKP 1'),(11,'X OTKP 2'),(14,'X TBSM 1'),(15,'X TBSM 2'),(6,'X TKJ 1'),(7,'X TKJ 2'),(12,'X TKRO 1'),(13,'X TKRO 2'),(16,'XI AKL 1'),(17,'XI AKL 2'),(18,'XI OTKP 1'),(19,'XI OTKP 2'),(24,'XI TBSM 1'),(25,'XI TBSM 2'),(20,'XI TKJ 1'),(21,'XI TKJ 2'),(22,'XI TKRO 1'),(23,'XI TKRO 2'),(26,'XII AKL 1'),(27,'XII AKL 2'),(28,'XII OTKP 1'),(29,'XII OTKP 2'),(34,'XII TBSM 1'),(35,'XII TBSM 2'),(30,'XII TKJ 1'),(31,'XII TKJ 2'),(32,'XII TKRO 1'),(33,'XII TKRO 2');
/*!40000 ALTER TABLE `cbt_user_grup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `opsi1` varchar(75) NOT NULL,
  `opsi2` varchar(75) NOT NULL,
  `keterangan` varchar(150) NOT NULL,
  `level` varchar(50) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `level` (`level`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`level`) REFERENCES `user_level` (`level`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','d033e22ae348aeb5660fc2140aec35850c4da997','Achmad Lutfi','','','','admin','2015-07-29 18:12:03'),(4,'operator','fe96dd39756ac41b74283a9292652d366d73931f','Operator','','','Operator','operator-soal','2018-03-30 12:58:55'),(5,'joko','97c358728f7f947c9a279ba9be88308395c7cc3a','Joko','','','Haloo','admin','2019-12-12 02:53:12'),(6,'085725424166','58f95bc8c2184d761e4a26661359f70ce0778be1','Sutrisno','','085725424166','Guru Mata Pelajaran','guru','2026-09-25 13:54:17');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=581 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_akses`
--

LOCK TABLES `user_akses` WRITE;
/*!40000 ALTER TABLE `user_akses` DISABLE KEYS */;
INSERT INTO `user_akses` VALUES (254,'operator-soal','modul-daftar',1,1),(255,'operator-soal','modul-filemanager',1,1),(256,'operator-soal','modul-import',1,1),(257,'operator-soal','modul-soal',1,1),(258,'operator-soal','modul-topik',1,1),(259,'operator-tes','tes-hasil-operator',1,1),(260,'operator-tes','tes-token',1,1),(505,'admin','laporan-analisis-butir-soal',1,1),(506,'admin','peserta-kartu',1,1),(507,'admin','peserta-group',1,1),(508,'admin','peserta-daftar',1,1),(509,'admin','modul-daftar',1,1),(510,'admin','tes-daftar',1,1),(511,'admin','tool-backup',1,1),(512,'admin','tes-evaluasi',1,1),(513,'admin','tool-exportimport-soal',1,1),(514,'admin','modul-filemanager',1,1),(515,'admin','tes-hasil',1,1),(516,'admin','peserta-import',1,1),(517,'admin','modul-import',1,1),(518,'admin','modul-import-word',1,1),(519,'admin','user_level',1,1),(520,'admin','user_menu',1,1),(521,'admin','user_atur',1,1),(522,'admin','user-zyacbt',1,1),(523,'admin','laporan-rekap',1,1),(524,'admin','peserta-reset',1,1),(525,'admin','modul-soal',1,1),(526,'admin','tes-tambah',1,1),(527,'admin','tes-token',1,1),(528,'admin','modul-topik',1,1),(529,'admin','tes-jadwal',1,1),(530,'operator-soal','tes-jadwal',1,1),(555,'guru','guru-ulangan',1,1),(556,'guru','modul-topik',1,1),(557,'guru','modul-daftar',1,1),(558,'guru','modul-soal',1,1),(559,'guru','modul-import-word',1,1),(560,'guru','tes-tambah',1,1),(561,'guru','tes-daftar',1,1),(562,'guru','tes-token',1,1),(563,'guru','tes-evaluasi',1,1),(564,'guru','tes-hasil',1,1),(565,'admin','modul-mapel',1,1),(567,'guru','modul-import',1,1),(568,'guru','modul-mapel',1,1),(569,'operator-soal','modul-import-word',1,1),(570,'operator-soal','modul-mapel',1,1),(571,'admin','modul-import-json',1,1),(572,'operator-soal','modul-import-json',1,1),(573,'guru','modul-import-json',1,1),(574,'admin','tes-qr-akses',1,1),(578,'operator-soal','tes-qr-akses',1,1),(579,'operator-tes','tes-qr-akses',1,1),(580,'guru','tes-qr-akses',1,1);
/*!40000 ALTER TABLE `user_akses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_level`
--

DROP TABLE IF EXISTS `user_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(50) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `level` (`level`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_level`
--

LOCK TABLES `user_level` WRITE;
/*!40000 ALTER TABLE `user_level` DISABLE KEYS */;
INSERT INTO `user_level` VALUES (1,'admin','Administrator'),(7,'operator-soal','Operator Soal'),(8,'operator-tes','Operator Tes'),(9,'guru','Guru Mata Pelajaran');
/*!40000 ALTER TABLE `user_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_log`
--

DROP TABLE IF EXISTS `user_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `log` varchar(250) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_log`
--

LOCK TABLES `user_log` WRITE;
/*!40000 ALTER TABLE `user_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_log` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_menu`
--

LOCK TABLES `user_menu` WRITE;
/*!40000 ALTER TABLE `user_menu` DISABLE KEYS */;
INSERT INTO `user_menu` VALUES (1,0,'','user','Pengaturan','#','fa fa-user',20),(3,1,'user','user_atur','Pengaturan User','manager/useratur','fa fa-circle-o',5),(4,1,'user','user_level','Pengaturan Level','manager/userlevel','fa fa-circle-o',6),(5,1,'user','user_menu','Pengaturan Menu','manager/usermenu','fa fa-circle-o',7),(6,0,'','modul','Data Modul','#','fa fa-book',2),(7,1,'modul','modul-daftar','Daftar Soal','manager/modul_daftar','fa fa-circle-o',5),(8,1,'modul','modul-topik','Topik','manager/modul_topik','fa fa-circle-o',2),(10,0,'','peserta','Data Peserta','#','fa fa-users',3),(11,1,'peserta','peserta-daftar','Daftar Peserta','manager/peserta_daftar','fa fa-circle-o',2),(12,1,'peserta','peserta-group','Daftar Group','manager/peserta_group','fa fa-circle-o',1),(13,1,'peserta','peserta-import','Import Data Peserta','manager/peserta_import','fa fa-circle-o',3),(14,0,'','tes','Data Tes','#','fa fa-tasks',4),(15,1,'tes','tes-tambah','Tambah Tes','manager/tes_tambah','fa fa-circle-o',1),(16,1,'tes','tes-daftar','Daftar Tes','manager/tes_daftar','fa fa-circle-o',2),(17,1,'tes','tes-hasil','Hasil Tes','manager/tes_hasil','fa fa-circle-o',6),(18,1,'modul','modul-soal','Soal','manager/modul_soal','fa fa-circle-o',3),(19,1,'tes','tes-token','Token','manager/tes_token','fa fa-circle-o',8),(22,1,'modul','modul-filemanager','File Manager','manager/modul_filemanager','fa fa-circle-o',6),(24,1,'modul','modul-import','Import Soal Spreadsheet','manager/modul_import','fa fa-circle-o',4),(25,1,'tes','tes-evaluasi','Evaluasi Tes','manager/tes_evaluasi','fa fa-circle-o',5),(28,1,'tes','tes-hasil-operator','Hasil Tes Operator','manager/tes_hasil_operator','fa fa-circle-o',10),(30,0,'','tool','Tool','#','fa fa-wrench',6),(31,1,'tool','tool-backup','Database','manager/tool_backup','fa fa-database',1),(32,1,'tes-laporan','laporan-rekap','Rekap Hasil Tes','manager/laporan_rekap_hasil','fa fa-circle-o',7),(33,1,'tool','tool-exportimport-soal','Export / Import Soal','manager/tool_exportimport_soal','fa fa-circle-o',2),(34,1,'user','user-zyacbt','Pengaturan ZYACBT','manager/pengaturan_zyacbt','fa fa-circle-o',1),(37,1,'peserta','peserta-kartu','Cetak Kartu','manager/peserta_kartu','fa fa-circle-o',5),(38,0,'','tes-laporan','Laporan','#','fa fa-print',5),(41,1,'tes-laporan','laporan-analisis-butir-soal','Analisis Butir Soal','manager/laporan_analisis_butir_soal','fa fa-circle-o',1),(42,1,'tes-laporan','laporan-analisis-soal','Analisis Soal','manager/laporan_analisis_soal','fa fa-circle-o',2),(43,1,'modul','modul-import-word','Import Soal Word','manager/modul_import_word','fa fa-circle-o',4),(44,1,'peserta','peserta-reset','Reset Login','manager/peserta_reset','fa fa-circle-o',7),(45,1,'tes','tes-jadwal','Jadwal & Matriks Tes','manager/tes_jadwal','fa fa-calendar',3),(47,1,'tes','guru-ulangan','Ulangan Harian','manager/guru_ulangan','fa fa-pencil-square-o',0),(48,1,'modul','modul-mapel','Mata Pelajaran (Modul)','manager/modul_mapel','fa fa-book',0),(50,1,'modul','modul-import-json','Import Soal JSON / AI','manager/modul_import_json','fa fa-code',5),(51,1,'tes','tes-qr-akses','QR Akses Siswa (Data Mandiri)','manager/tes_qr_akses','fa fa-qrcode',6);
/*!40000 ALTER TABLE `user_menu` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-21 13:05:29
