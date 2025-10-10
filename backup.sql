-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: localhost    Database: ngoforum
-- ------------------------------------------------------
-- Server version	8.0.43

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `event_files`
--

DROP TABLE IF EXISTS `event_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_files_event_id_foreign` (`event_id`),
  CONSTRAINT `event_files_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_files`
--

LOCK TABLES `event_files` WRITE;
/*!40000 ALTER TABLE `event_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_images`
--

DROP TABLE IF EXISTS `event_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_images_event_id_foreign` (`event_id`),
  CONSTRAINT `event_images_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_images`
--

LOCK TABLES `event_images` WRITE;
/*!40000 ALTER TABLE `event_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organizer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organizer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `registration_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_code_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `focal_points`
--

DROP TABLE IF EXISTS `focal_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `focal_points` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `membership_upload_id` bigint unsigned NOT NULL,
  `network_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `focal_points_membership_upload_id_foreign` (`membership_upload_id`),
  CONSTRAINT `focal_points_membership_upload_id_foreign` FOREIGN KEY (`membership_upload_id`) REFERENCES `membership_uploads` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `focal_points`
--

LOCK TABLES `focal_points` WRITE;
/*!40000 ALTER TABLE `focal_points` DISABLE KEYS */;
/*!40000 ALTER TABLE `focal_points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membership_applications`
--

DROP TABLE IF EXISTS `membership_applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membership_applications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mailing_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `physical_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comm_channels` json DEFAULT NULL,
  `comm_phones` json DEFAULT NULL,
  `letter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `constitution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activities` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `funding` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `strategic_plan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fundraising_strategy` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audit_report` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vision` text COLLATE utf8mb4_unicode_ci,
  `mission` text COLLATE utf8mb4_unicode_ci,
  `goal` text COLLATE utf8mb4_unicode_ci,
  `objectives` text COLLATE utf8mb4_unicode_ci,
  `director_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `membership_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `membership_applications_membership_id_foreign` (`membership_id`),
  CONSTRAINT `membership_applications_membership_id_foreign` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership_applications`
--

LOCK TABLES `membership_applications` WRITE;
/*!40000 ALTER TABLE `membership_applications` DISABLE KEYS */;
/*!40000 ALTER TABLE `membership_applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membership_focal_points`
--

DROP TABLE IF EXISTS `membership_focal_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membership_focal_points` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `membership_id` bigint unsigned NOT NULL,
  `network_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `membership_focal_points_membership_id_foreign` (`membership_id`),
  CONSTRAINT `membership_focal_points_membership_id_foreign` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership_focal_points`
--

LOCK TABLES `membership_focal_points` WRITE;
/*!40000 ALTER TABLE `membership_focal_points` DISABLE KEYS */;
/*!40000 ALTER TABLE `membership_focal_points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membership_networks`
--

DROP TABLE IF EXISTS `membership_networks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membership_networks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `membership_id` bigint unsigned NOT NULL,
  `network_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `membership_networks_membership_id_foreign` (`membership_id`),
  CONSTRAINT `membership_networks_membership_id_foreign` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership_networks`
--

LOCK TABLES `membership_networks` WRITE;
/*!40000 ALTER TABLE `membership_networks` DISABLE KEYS */;
/*!40000 ALTER TABLE `membership_networks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membership_uploads`
--

DROP TABLE IF EXISTS `membership_uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membership_uploads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `letter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mission_vision` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `constitution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activities` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `funding` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `strategic_plan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fundraising_strategy` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audit_report` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature` longtext COLLATE utf8mb4_unicode_ci,
  `new_membership_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `json_content` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `membership_uploads_new_membership_id_foreign` (`new_membership_id`),
  CONSTRAINT `membership_uploads_new_membership_id_foreign` FOREIGN KEY (`new_membership_id`) REFERENCES `new_memberships` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership_uploads`
--

LOCK TABLES `membership_uploads` WRITE;
/*!40000 ALTER TABLE `membership_uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `membership_uploads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `memberships`
--

DROP TABLE IF EXISTS `memberships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `memberships` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ngo_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `director_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `director_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `director_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `membership_status` tinyint(1) NOT NULL,
  `more_info` tinyint(1) DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `deadline` date DEFAULT NULL,
  `status` enum('pending','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `memberships_user_id_foreign` (`user_id`),
  CONSTRAINT `memberships_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `memberships`
--

LOCK TABLES `memberships` WRITE;
/*!40000 ALTER TABLE `memberships` DISABLE KEYS */;
/*!40000 ALTER TABLE `memberships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2025_08_07_081247_add_role_to_users_table',1),(6,'2025_08_07_083135_create_memberships_table',1),(7,'2025_08_08_095306_create_permission_tables',1),(8,'2025_08_15_020538_add_deadline_to_memberships_table',1),(9,'2025_08_27_023231_create_new_membership_table',1),(10,'2025_08_27_041934_create_ngos_table',1),(11,'2025_08_27_091724_create_new_upload_table',1),(12,'2025_09_01_032259_add_status_to_new_memberships_table',1),(13,'2025_09_03_010049_add_logo_to_membership_uploads_table',1),(14,'2025_09_08_014247_create_events_table',1),(15,'2025_09_10_064521_create_registrations_table',1),(16,'2025_09_10_064558_add_registration_link_to_events_table',1),(17,'2025_09_12_040101_add_file_name_to_event_files_table',1),(18,'2025_09_29_044126_add_image_to_users_table',1),(19,'2025_10_03_072425_add_json_content_to_membership_uploads',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `networks`
--

DROP TABLE IF EXISTS `networks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `networks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `membership_upload_id` bigint unsigned NOT NULL,
  `network_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `networks_membership_upload_id_foreign` (`membership_upload_id`),
  CONSTRAINT `networks_membership_upload_id_foreign` FOREIGN KEY (`membership_upload_id`) REFERENCES `membership_uploads` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `networks`
--

LOCK TABLES `networks` WRITE;
/*!40000 ALTER TABLE `networks` DISABLE KEYS */;
/*!40000 ALTER TABLE `networks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `new_memberships`
--

DROP TABLE IF EXISTS `new_memberships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `new_memberships` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `org_name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `org_name_kh` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `membership_type` enum('Full member','Associate member') COLLATE utf8mb4_unicode_ci NOT NULL,
  `director_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `director_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `director_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_media` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `representative_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `representative_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `representative_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `representative_position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `new_memberships_user_id_foreign` (`user_id`),
  CONSTRAINT `new_memberships_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `new_memberships`
--

LOCK TABLES `new_memberships` WRITE;
/*!40000 ALTER TABLE `new_memberships` DISABLE KEYS */;
/*!40000 ALTER TABLE `new_memberships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ngos`
--

DROP TABLE IF EXISTS `ngos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ngos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ngo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ngos`
--

LOCK TABLES `ngos` WRITE;
/*!40000 ALTER TABLE `ngos` DISABLE KEYS */;
INSERT INTO `ngos` VALUES (1,'ACR/Caritas Australia','ACR Caritas','2025-10-07 02:15:50','2025-10-07 02:15:50'),(2,'Action For Development','AFD','2025-10-07 02:15:50','2025-10-07 02:15:50'),(3,'American Friends Service Committee','AFSC','2025-10-07 02:15:50','2025-10-07 02:15:50'),(4,'Banteay Srei','BS','2025-10-07 02:15:50','2025-10-07 02:15:50'),(5,'Building Community Voice','BCV','2025-10-07 02:15:50','2025-10-07 02:15:50'),(6,'Cambodian Development Mission for Disability','CDMD','2025-10-07 02:15:50','2025-10-07 02:15:50'),(7,'Cambodian Disabled People\'s Organization','CDPO','2025-10-07 02:15:50','2025-10-07 02:15:50'),(8,'Cambodian Health and Education For Community','CHEC','2025-10-07 02:15:50','2025-10-07 02:15:50'),(9,'Cambodian Women\'s Crisis Center','CWCC','2025-10-07 02:15:50','2025-10-07 02:15:50'),(10,'Cambodian Women\'s Development Association','CWDA','2025-10-07 02:15:50','2025-10-07 02:15:50'),(11,'Catholic Relief Services','CRS','2025-10-07 02:15:50','2025-10-07 02:15:50'),(12,'Centre d\'Etude et de Developpement Agricole Cambodgien','CDAC','2025-10-07 02:15:50','2025-10-07 02:15:50'),(13,'Community Council for Development','CCDO','2025-10-07 02:15:50','2025-10-07 02:15:50'),(14,'Community Legal Education Center','CLEC','2025-10-07 02:15:50','2025-10-07 02:15:50'),(15,'Community Sanitation and Recycling Organisation','CSRO','2025-10-07 02:15:50','2025-10-07 02:15:50'),(16,'Cooperation for Alleviation of Poverty','COFAP','2025-10-07 02:15:50','2025-10-07 02:15:50'),(17,'Cooperation for Development of Cambodia','CODECKT','2025-10-07 02:15:50','2025-10-07 02:15:50'),(18,'Cooperation for Social Services and Development','CSSD','2025-10-07 02:15:50','2025-10-07 02:15:50'),(19,'Culture and Environment Preservation Association','CEPA','2025-10-07 02:15:50','2025-10-07 02:15:50'),(20,'DANMISSION','DANMISSION','2025-10-07 02:15:50','2025-10-07 02:15:50'),(21,'Development and Partnership in Action','DPA','2025-10-07 02:15:50','2025-10-07 02:15:50'),(22,'Diaconia ECCB – Center of Relief and Development','DE–CoRaD','2025-10-07 02:15:50','2025-10-07 02:15:50'),(23,'Farmer Livelihood Development Organization','FLD','2025-10-07 02:15:50','2025-10-07 02:15:50'),(24,'Fisheries Action Coalition Team','FACT','2025-10-07 02:15:50','2025-10-07 02:15:50'),(25,'ForumCiv','ForumCiv','2025-10-07 02:15:50','2025-10-07 02:15:50'),(26,'Gender And Development for Cambodia','GADC','2025-10-07 02:15:50','2025-10-07 02:15:50'),(27,'Groupe de Recherche et d\'Echanges Technologiques','GRET','2025-10-07 02:15:50','2025-10-07 02:15:50'),(28,'HEKS/EPER-Swiss Church Aid','HEKS','2025-10-07 02:15:50','2025-10-07 02:15:50'),(29,'Help Age Cambodia','HAC','2025-10-07 02:15:50','2025-10-07 02:15:50'),(30,'HALO Trust Cambodia','HALO','2025-10-07 02:15:50','2025-10-07 02:15:50'),(31,'Hurredo','Hurredo','2025-10-07 02:15:50','2025-10-07 02:15:50'),(32,'Indigenous Community Support Organization','ICSO','2025-10-07 02:15:50','2025-10-07 02:15:50'),(33,'Jesuit Service Cambodia','JRC','2025-10-07 02:15:50','2025-10-07 02:15:50'),(34,'Khmer Angka for Development of Rural Areas','KADRA','2025-10-07 02:15:50','2025-10-07 02:15:50'),(35,'Khmer Community for Agricultural Development','KCAD','2025-10-07 02:15:50','2025-10-07 02:15:50'),(36,'Legal Aid of Cambodia','LAC','2025-10-07 02:15:50','2025-10-07 02:15:50'),(37,'Mennonite Central Committee','MCC','2025-10-07 02:15:50','2025-10-07 02:15:50'),(38,'Minority Rights Organization','MIRO','2025-10-07 02:15:50','2025-10-07 02:15:50'),(39,'Mission Alliance','MA','2025-10-07 02:15:50','2025-10-07 02:15:50'),(40,'Mlup Baitong','MB','2025-10-07 02:15:50','2025-10-07 02:15:50'),(41,'Mlup Promviheathor Center Organization','MPC','2025-10-07 02:15:50','2025-10-07 02:15:50'),(42,'My Village','Mvi','2025-10-07 02:15:50','2025-10-07 02:15:50'),(43,'Norwegian People\'s Aid','NPA','2025-10-07 02:15:50','2025-10-07 02:15:50'),(44,'Occupation of Rural Economic Development and Agriculture','OREDA','2025-10-07 02:15:50','2025-10-07 02:15:50'),(45,'OXFAM','Oxf','2025-10-07 02:15:50','2025-10-07 02:15:50'),(46,'Partnership for Development in Kampuchea','PADEK','2025-10-07 02:15:50','2025-10-07 02:15:50'),(47,'People\'s Action for Inclusive Development','PAFID','2025-10-07 02:15:50','2025-10-07 02:15:50'),(48,'Phnom Srey Association for Development','PSOD','2025-10-07 02:15:50','2025-10-07 02:15:50'),(49,'Plan International Cambodia','Plan','2025-10-07 02:15:50','2025-10-07 02:15:50'),(50,'Por Thom Elderly Association','PTEA','2025-10-07 02:15:50','2025-10-07 02:15:50'),(51,'Prom Vihear Thor Organization','Promvihearthor','2025-10-07 02:15:50','2025-10-07 02:15:50'),(52,'Rural Aid Organization','RAO','2025-10-07 02:15:50','2025-10-07 02:15:50'),(53,'Rural Community and Environment Development Organization','RCEDO','2025-10-07 02:15:50','2025-10-07 02:15:50'),(54,'Save the Children','SC','2025-10-07 02:15:50','2025-10-07 02:15:50'),(55,'Urban Poor Women Development','UPWD','2025-10-07 02:15:50','2025-10-07 02:15:50'),(56,'Women\'s Media Centre of Cambodia','WMC','2025-10-07 02:15:50','2025-10-07 02:15:50'),(57,'World Renew','WR','2025-10-07 02:15:50','2025-10-07 02:15:50'),(58,'World Vision International - Cambodia','WVI-C','2025-10-07 02:15:50','2025-10-07 02:15:50'),(59,'Youth for Peace Organisation','YPO','2025-10-07 02:15:50','2025-10-07 02:15:50'),(60,'Environment and Health Education','EHE','2025-10-07 02:15:50','2025-10-07 02:15:50'),(61,'Buddhism for Social Development Action','BSDA','2025-10-07 02:15:50','2025-10-07 02:15:50'),(62,'Passerelles Numériques Cambodia','PNC','2025-10-07 02:15:50','2025-10-07 02:15:50');
/*!40000 ALTER TABLE `ngos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngo_id` bigint unsigned DEFAULT NULL,
  `new_membership_id` bigint unsigned DEFAULT NULL,
  `membership_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `registrations_event_id_foreign` (`event_id`),
  KEY `registrations_ngo_id_foreign` (`ngo_id`),
  KEY `registrations_new_membership_id_foreign` (`new_membership_id`),
  KEY `registrations_membership_id_foreign` (`membership_id`),
  CONSTRAINT `registrations_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `registrations_membership_id_foreign` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`id`) ON DELETE SET NULL,
  CONSTRAINT `registrations_new_membership_id_foreign` FOREIGN KEY (`new_membership_id`) REFERENCES `new_memberships` (`id`) ON DELETE SET NULL,
  CONSTRAINT `registrations_ngo_id_foreign` FOREIGN KEY (`ngo_id`) REFERENCES `ngos` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registrations`
--

LOCK TABLES `registrations` WRITE;
/*!40000 ALTER TABLE `registrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `registrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Mengseu','NGO Forum Cambodia','mengseu@ngoforum.org.kh',NULL,'$2y$10$IxYEmAFPM4eeKj6HBhgjgOahV.W7E4nl596f3dNj4tHF6fF/JnXi6',NULL,'2025-10-07 02:15:50','2025-10-07 02:15:50','admin',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-07  2:20:35
