/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `answers`;
CREATE TABLE `answers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question_id` bigint unsigned NOT NULL,
  `jawaban` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `answers_question_id_foreign` (`question_id`),
  CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `category_letters`;
CREATE TABLE `category_letters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `city_question`;
CREATE TABLE `city_question` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `city_id` bigint unsigned NOT NULL,
  `question_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_question_city_id_foreign` (`city_id`),
  KEY `city_question_question_id_foreign` (`question_id`),
  CONSTRAINT `city_question_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `city_question_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `departements`;
CREATE TABLE `departements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_category_id_foreign` (`category_id`),
  CONSTRAINT `documents_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement_id` bigint unsigned NOT NULL,
  `position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employees_departement_id_foreign` (`departement_id`),
  CONSTRAINT `employees_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `letter_ins`;
CREATE TABLE `letter_ins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_letter_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `departement_id` bigint unsigned NOT NULL,
  `reference_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_letter` date NOT NULL,
  `date_in` date NOT NULL,
  `origin_letter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `properties_letter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `letter_ins_category_letter_id_foreign` (`category_letter_id`),
  KEY `letter_ins_employee_id_foreign` (`employee_id`),
  KEY `letter_ins_departement_id_foreign` (`departement_id`),
  CONSTRAINT `letter_ins_category_letter_id_foreign` FOREIGN KEY (`category_letter_id`) REFERENCES `category_letters` (`id`) ON DELETE CASCADE,
  CONSTRAINT `letter_ins_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE CASCADE,
  CONSTRAINT `letter_ins_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint unsigned NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `media_order_column_index` (`order_column`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `ministries`;
CREATE TABLE `ministries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `post_tag`;
CREATE TABLE `post_tag` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL,
  `tag_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_tag_post_id_foreign` (`post_id`),
  KEY `post_tag_tag_id_foreign` (`tag_id`),
  CONSTRAINT `post_tag_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_headline` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_category_id_foreign` (`category_id`),
  CONSTRAINT `posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `question_categories`;
CREATE TABLE `question_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `city_id` bigint unsigned NOT NULL,
  `ministry_id` bigint unsigned NOT NULL,
  `question_category_id` bigint unsigned NOT NULL,
  `nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '000000',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `wa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Belum Dijawab','Sudah Dijawab') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Dijawab',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_city_id_foreign` (`city_id`),
  KEY `questions_ministry_id_foreign` (`ministry_id`),
  KEY `questions_question_category_id_foreign` (`question_category_id`),
  CONSTRAINT `questions_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `questions_ministry_id_foreign` FOREIGN KEY (`ministry_id`) REFERENCES `ministries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `questions_question_category_id_foreign` FOREIGN KEY (`question_category_id`) REFERENCES `question_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `departement_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_departement_id_foreign` (`departement_id`),
  CONSTRAINT `users_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `announcements` (`id`, `title`, `content`, `file`, `link`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Surat Edaran Pencantuman Gelar Nomor 15 tahun 2024	', '<p>Surat Edaran Pencantuman Gelar Nomor 15 tahun 2024</p>', 'announcements/01JMB8ES1PM3AS0P2M7568F30S.png', NULL, 1, '2025-02-18 00:48:46', '2025-02-18 00:48:46');

INSERT INTO `banners` (`id`, `name`, `desc`, `file`, `is_active`, `created_at`, `updated_at`) VALUES
(6, 'Kantor Regional XIV BKN Manokwari', 'Kantor Regional XIV BKN Manokwari', 'banners/01JRW5514VWD86VECY8610TMR3.png', 1, '2025-04-15 07:20:54', '2025-04-15 07:20:54'),
(9, 'Jadwal Pelayanan Kepegawaian', 'Jadwal Pelayanan Kepegawaian', 'banners/01JZ2B98KRNEEVXWQX2T6AKYWH.png', 1, '2025-07-01 06:37:41', '2025-07-01 06:37:41');
INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Berita Kepegawaian', 'berita-kepegawaian', '2025-01-04 20:09:23', '2025-01-04 20:09:23'),
(2, 'Artikel Kepegawaian', 'artikel-kepegawaian', '2025-01-04 20:09:39', '2025-01-04 20:09:39'),
(3, 'Pengumuman', 'pengumuman', '2025-01-04 20:09:55', '2025-01-04 20:09:55'),
(4, 'Dokumen', 'dokumen', '2025-02-18 00:40:45', '2025-02-18 00:40:45');

INSERT INTO `cities` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Kabupaten Sorong', 'kabupaten-sorong', '2025-01-04 20:02:48', '2025-01-04 20:02:48'),
(2, 'Kabupaten Sorong', 'kabupaten-sorong', '2025-02-11 03:35:59', '2025-02-11 03:35:59');

INSERT INTO `departements` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Bidang Informasi Kepegawaian', 'bidang-informasi-kepegawaian', '2025-01-04 20:02:48', '2025-01-04 20:02:48'),
(3, 'Sub Bagian Kepegawaian', 'sub-bagian-kepegawaian', '2025-02-18 05:32:15', '2025-02-18 05:32:15');
INSERT INTO `documents` (`id`, `title`, `category_id`, `desc`, `file`, `is_public`, `year`, `created_at`, `updated_at`) VALUES
(2, 'PK Kantor Regional XIV BKN Manokwari Tahun 2025', 4, '<p>Perjanjian Kinerja Kantor Regional XIV BKN Manokwari Tahun 2025</p>', 'documents/01K3J2A9R4SRR8NPP5H075HXHG.pdf', 1, '2025', '2025-02-18 01:23:42', '2025-08-26 02:11:36'),
(3, 'LKJ Kantor Regional XIV BKN Manokwari Tahun 2024', 4, '<p>Laporan Kinerja Kantor Regional XIV BKN Tahun 2024</p>', 'documents/01K3J31G83JQBNZ0JK2C3AQJ9Y.pdf', 1, '2024', '2025-02-28 10:42:08', '2025-08-26 02:24:17'),
(4, 'RENJA Kantor Regional XIV BKN Manokwari 2025', 4, NULL, 'documents/01K3J2RR5FNP15S2GFY0WFRR8P.pdf', 1, '2025', '2025-03-05 06:30:24', '2025-08-26 02:19:30'),
(5, 'RENJA Kantor Regional XIV BKN Manokwari 2022', 4, NULL, 'documents/01JRS3K8MHQXT842XMV9TZCER1.pdf', 1, '2022', '2025-04-14 02:56:00', '2025-04-15 23:22:27'),
(6, 'PK Kantor Regional XIV BKN Manokwari 2021', 4, NULL, 'documents/01JRS45KGFAFB60A8P5CJSA76K.pdf', 1, '2021', '2025-04-14 03:04:24', '2025-04-15 23:15:38'),
(8, 'RENSTRA Kantor Regional XIV BKN Manokwari 2020 - 2024', 4, NULL, 'documents/01JRXVD7209QMSF9QQ0J62TQPW.pdf', 1, '2020', '2025-04-15 23:09:05', '2025-04-15 23:23:43'),
(9, 'PK Kantor Regional XIV BKN Manokwari 2020', 4, NULL, 'documents/01JRXVPXTCMZC7AS4253MQXWYE.pdf', 1, '2020', '2025-04-15 23:14:23', '2025-04-15 23:14:23'),
(10, 'PK Kantor Regional XIV BKN Manokwari 2022', 4, NULL, 'documents/01JRXVRHYRE6Q5VA3V3BNBX8H6.pdf', 1, '2022', '2025-04-15 23:15:17', '2025-04-15 23:15:17'),
(11, 'PK Kantor Regional XIV BKN Manokwari 2023', 4, NULL, 'documents/01JRXVZC8STFTER3Y834C4Q137.pdf', 1, '2023', '2025-04-15 23:19:00', '2025-04-15 23:19:00'),
(12, 'PK Kantor Regional XIV BKN Manokwari 2024', 4, NULL, 'documents/01JRXWB8G0K1H74F4QQ4JH0QSX.pdf', 1, '2024', '2025-04-15 23:25:29', '2025-04-15 23:26:18'),
(13, 'Rencana Aksi Kantor Regional XIV BKN Manokwari 2020', 4, NULL, 'documents/01JRXWKVPEFYV9VD4YD3R0N57N.pdf', 1, '2020', '2025-04-15 23:30:11', '2025-04-15 23:30:11'),
(14, 'Rencana Aksi Kantor Regional XIV BKN Manokwari 2021', 4, NULL, 'documents/01JRXWWS2TV3JNV1H4NNHD044W.pdf', 1, '2021', '2025-04-15 23:35:04', '2025-04-15 23:35:04'),
(15, 'Rencana Aksi Kantor Regional XIV BKN Manokwari 2022', 4, NULL, 'documents/01JRXX529F10SQ15TJ1DZA8SDK.pdf', 1, '2022', '2025-04-15 23:39:35', '2025-04-15 23:39:35'),
(16, 'Rencana Aksi Kantor Regional XIV BKN Manokwari 2023', 4, NULL, 'documents/01JRXX98PRNCV109NXKS526HJJ.pdf', 1, '2023', '2025-04-15 23:41:53', '2025-04-15 23:41:53'),
(17, 'Rencana Aksi Kantor Regional XIV BKN Manokwari 2024', 4, NULL, 'documents/01JRXXB7GZJKQABXF476T5E9PN.PDF', 1, '2024', '2025-04-15 23:42:57', '2025-04-15 23:42:57'),
(18, 'Rencana Aksi Kantor Regional XIV BKN Manokwari 2025', 4, NULL, 'documents/01JRXXQ499KQ100QF77G4NN3G2.pdf', 1, '2025', '2025-04-15 23:49:27', '2025-04-15 23:49:27'),
(19, 'LKJ Kantor Regional XIV BKN Manokwari Tahun 2021', 4, NULL, 'documents/01JRXY3FFMSRF7BDGM6CK9P1XC.pdf', 1, '2021', '2025-04-15 23:56:12', '2025-04-16 01:27:21'),
(20, 'LKJ Kantor Regional XIV BKN Manokwari Tahun 2020', 4, NULL, 'documents/01JRY2MXRXWKD71X4ZX8A5797N.pdf', 1, '2020', '2025-04-16 01:15:38', '2025-04-16 01:15:38'),
(21, 'LKJ Kantor Regional XIV BKN Manokwari Tahun 2022', 4, NULL, 'documents/01JRY2Y12W5G48BGAWQ3CZVG8Z.pdf', 1, '2022', '2025-04-16 01:17:11', '2025-04-16 01:20:36'),
(22, 'LKJ Kantor Regional XIV BKN Manokwari Tahun 2023', 4, NULL, 'documents/01JRY39V5W6JKTK1028DBN8ASE.pdf', 1, '2023', '2025-04-16 01:27:03', '2025-04-16 01:27:03'),
(23, 'RENJA Kantor Regional XIV BKN Manokwari Tahun 2020', 4, NULL, 'documents/01JRY3J7F6E4BXGXXKXQ8DBC0B.pdf', 1, '2020', '2025-04-16 01:31:38', '2025-04-16 01:31:38'),
(24, 'RENJA Kantor Regional XIV BKN Manokwari Tahun 2021', 4, NULL, 'documents/01JRY3MGREVKY82YWEC2E1JV6Q.pdf', 1, '2022', '2025-04-16 01:32:53', '2025-04-23 03:07:39'),
(25, 'RENJA Kantor Regional XIV BKN Manokwari Tahun 2023', 4, NULL, 'documents/01JRY3T4YC8KNH3M9WCT7S39FD.pdf', 1, '2023', '2025-04-16 01:35:57', '2025-04-16 01:35:57'),
(26, 'RENJA Kantor Regional XIV BKN Manokwari 2024', 4, NULL, 'documents/01K3J2HDPP83DD4W2W47WWP1SB.pdf', 1, '2024', '2025-04-23 03:07:14', '2025-08-26 02:15:30'),
(27, 'Jadwal Seleksi Penerimaan Mahasiswa Praja/ Taruna/ Sekolah Kedinasan Tahun Anggaran 2025', 4, NULL, 'documents/01JY0VT1QTPT59BBZT2934J9SP.pdf', 1, '2025', '2025-06-18 06:32:18', '2025-06-18 06:32:18'),
(28, 'Surat Edaran Kepala BKN Nomor 3 Tahun 2025 terkait Persyaratan Pencantuman Gelar Akademik bagi ASN', 4, '<p>Surat Edaran Kepala BKN Nomor 3 Tahun 2025 terkait Persyaratan Pencantuman Gelar Akademik bagi ASN</p>', 'documents/01JZ9JGHMRJD7ZM400QV0DY14Q.pdf', 1, '2025', '2025-07-04 01:58:41', '2025-07-04 01:58:41'),
(29, 'PERATURAN BADAN KEPEGAWAIAN NEGARA REPUBLIK INDONESIA NOMOR 4 TAHUN 2025 TENTANG PERIODISASI KENAIKAN PANGKAT PEGAWAI NEGERI SIPIL', 4, NULL, 'documents/01K44FDT3PJEXCAK7WMCTZDZCB.pdf', 1, '2025', '2025-09-02 05:47:03', '2025-09-02 05:47:03');




INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2024_02_19_024632_create_categories_table', 1),
(5, '2024_02_19_024655_create_posts_table', 1),
(6, '2024_02_19_024705_create_tags_table', 1),
(7, '2024_02_19_050542_create_post_tag_table', 1),
(8, '2024_02_19_051817_create_permission_tables', 1),
(9, '2024_02_19_111049_create_media_table', 1),
(10, '2024_02_26_052554_create_ministries_table', 1),
(11, '2024_02_27_023729_create_question_categories_table', 1),
(12, '2024_02_27_034740_create_cities_table', 1),
(13, '2024_02_27_035844_create_questions_table', 1),
(14, '2024_02_27_035944_create_answers_table', 1),
(15, '2024_02_27_084022_create_city_question_table', 1),
(16, '2024_02_28_073449_create_departements_table', 1),
(17, '2024_02_28_081441_create_users_table', 1),
(18, '2024_12_17_139731_create_employees_table', 1),
(19, '2024_12_17_140504_create_category_letters_table', 1),
(20, '2024_12_17_140538_create_letter_ins_table', 1),
(21, '2024_12_25_021508_create_banners_table', 1),
(22, '2024_12_26_233726_create_announcements_table', 1),
(23, '2025_01_04_120322_create_documents_table', 1);
INSERT INTO `ministries` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'KEMENKUMHAM', 'kemenkumham', '2025-01-04 20:02:48', '2025-01-04 20:02:48'),
(2, 'KEMENKUMHAM', 'kemenkumham', '2025-02-11 03:35:59', '2025-02-11 03:35:59');

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 5),
(1, 'App\\Models\\User', 6),
(1, 'App\\Models\\User', 7);

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'tambah-tulisan', 'web', '2025-01-04 20:02:46', '2025-01-04 20:02:46'),
(2, 'edit-tulisan', 'web', '2025-01-04 20:02:46', '2025-01-04 20:02:46'),
(3, 'lihat-tulisan', 'web', '2025-01-04 20:02:46', '2025-01-04 20:02:46'),
(4, 'hapus-tulisan', 'web', '2025-01-04 20:02:46', '2025-01-04 20:02:46'),
(5, 'tambah-user', 'web', '2025-01-04 20:02:46', '2025-01-04 20:02:46'),
(6, 'edit-user', 'web', '2025-01-04 20:02:46', '2025-01-04 20:02:46'),
(7, 'lihat-user', 'web', '2025-01-04 20:02:46', '2025-01-04 20:02:46'),
(8, 'hapus-user', 'web', '2025-01-04 20:02:46', '2025-01-04 20:02:46');


INSERT INTO `posts` (`id`, `category_id`, `title`, `slug`, `content`, `thumbnail`, `status`, `is_headline`, `created_at`, `updated_at`) VALUES
(1, 1, 'Asesmen ASN ke IKN Klaster Pertama Dimulai Tahun 2022', 'asesmen-asn-ke-ikn-klaster-pertama-dimulai-tahun-2022', '<p>Bandung – Humas BKN, Terbitnya dasar hukum pemindahan ibu kota negara (IKN) melalui Undang - Undang Nomor 3 Tahun 2022 tentang Ibu Kota Negara, Badan Kepegawaian Negara (BKN) mendapat mandat untuk melaksanakan asesmen Aparatur Sipil Negara (ASN) yang akan dipindahkan ke IKN.</p><p>Untuk merealisasikan tugas tersebut, BKN melalui Pusat Penilaian Kompetensi ASN sedang menyiapkan dua tahapan utama dalam proses asesmen ASN menuju IKN. Pertama, menyusun dan mengembangkan instrumen atau metode asesmen yang akan digunakan untuk memetakan potensi dan kompetensi ASN sesuai dengan tuntutan kebutuhan kompetensi pada IKN yang mengusung konsep <em>smart city</em> dan pengelolaan pemerintahan berbasis elektronik (SPBE), antara lain kompetensi manajerial dan sosiokultural, kompetensi literasi digital dan <em>emerging skills</em>. Instrumen atau metode asesmen ini dirancang berbasis IT yang dapat digunakan secara massal sehingga lebih efisien, lebih cepat, serta telah terintegrasi dengan SI-ASN. Kedua, BKN juga menyiapkan mekanisme pelaksanaan asesmen ASN yang direncanakan akan dilakukan bertahap yang terbagi dalam lima klaster.</p><p>BKN menargetkan pengembangan instrumen atau alat ukur penilaian kompetensi ini akan selesai pada September 2022 sehingga pelaksanaan pemetaan/penilaian kompetensi bagi ASN Instansi Pusat dapat dimulai pada tahun 2022 ini. Target terdekat BKN adalah akan melaksanakan penilaian kompetensi bagi ASN Instansi Pusat yang masuk pada klaster pertama dan seterusnya sesuai dengan skenario tahapan pemindahan yang ditetapkan oleh pemerintah. ASN yang akan dinilai adalah pejabat administrator dan pejabat fungsional madya ke bawah.</p><p>Pelaksanaan penilaian kompetensi tahap awal di tahun 2022 sampai dengan 2023 ditargetkan sejumlah 60.000 ASN, meliputi 20.000 ASN di tahun 2022 dan 40.000 ASN pada tahun 2023. Keseluruhan proses pelaksanaan asesmen ASN ke IKN, BKN akan bekerja sama dengan beberapa instansi pemerintah pusat terkait, seperti KemenPPN/Bappenas dan Kementerian Pendayagunaan Aparatur Negara dan Reformasi Birokrasi.</p><p>Sosialisasi rencana pelaksanaan asesmen bagi ASN ini disampaikan melalui Forum Tematik Bakohumas yang diselenggarakan BKN pada Kamis, 30 Juni 2022 di Kantor Regional III BKN Bandung, dengan melibatkan unit kerja kehumasan di sejumlah Kementerian/Lembaga, khususnya instansi yang masuk pada kategori klaster awal berdasarkan skenario pemindahan ASN ke IKN. <strong><em>han</em></strong></p>', 'post-thumbnail/01JGTE4GFYPQ783Y8224S7QS64.png', 1, 1, '2025-01-04 20:13:50', '2025-01-04 20:13:50'),
(2, 2, 'Mengenal Merit Sistem dan Refleksi Implementasinya', 'mengenal-merit-sistem-dan-refleksi-implementasinya', '<p>Merit sistem merupakan salah satu sistem dalam manajemen sumber daya manusia yang menjadikan kualifikasi, kompetensi dan kinerja sebagai pertimbangan utama dalam proses perencanaan, perekrutan, penggajian, pengembangan, promosi, retensi, disiplin dan pensiun pegawai. Mulanya, merit sistem banyak diterapkan di organisasi sektor swasta, yang kemudian belakangan mulai berkembang dan diadaptasi juga oleh sektor publik.&nbsp;</p><p>Di Indonesia, merit sistem secara legal formal diberlakukan pada tahun 2014 melalui Undang-Undang No 5 tahun 2014 tentang Aparatur Sipil Negara (ASN). Dalam UU tersebut dinyatakan bahwa kebijakan manajemen ASN berdasarkan pada kualifikasi, kompetensi dan kinerja yang diberlakukan secara adil dan wajar tanpa membedakan latar belakang politik, ras, warna kulit, agama, asal usul, jenis kelamin, status pernikahan, umur, atau kondisi kecacatan (tanpa diskriminasi). Sistem ini seolah menjadi kritik atas suburnya praktek nepotisme, dan primordialisme di dunia kerja. Oleh karenanya sistem merit menjadi salah satu hasil dari agenda reformasi birokrasi yang dicanangkan Presiden untuk menciptakan birokrasi netral dan mampu melayani kebutuhan publik serta bebas dari KKN.&nbsp;</p><p>Pemberlakukan merit sistem dalam birokrasi Indonesia bertujuan untuk menghasilkan ASN yang profesional dan berintegritas dengan menempatkan mereka pada jabatan-jabatan birokrasi pemerintah sesuai kompetensinya; pemberian kompensasi yang adil dan layak; mengembangkan kemampuan ASN melalui bimbingan dan diklat; dan melindungi karier ASN dari politisasi dan kebijakan yang bertentangan dengan prinsip merit.&nbsp;</p><p><strong>Implementasi&nbsp;</strong></p><p>Implementasi merit sistem dapat diwujudkan pada manajemen sejak perencanaan kebutuhan SDM hingga pensiun nantinya. Dalam kondisi ideal, penerapan merit sistem dalam manajemen ASN dapat digambarkan sebagai berikut:<br>1.&nbsp; &nbsp; Penyusunan dan penetapan Kebutuhan<br>Pada aspek penyusunan dan penetapan kebutuhan, merit sistem dapat diterjemahkan instansi dengan membuat perencanaan kebutuhan ASN 5 tahunan berdasarkan Anjab (Analisis Jabatan) dan ABK (Analisis Beban Kerja) yang dalam penyusunannya mempertimbangkan jumlah, pangkat, dan kualifikasi pegawai yang ada, dengan mempertimbangkan pegawai yang akan pensiun.<br>2.	Pengadaan<br>Pada aspek pengadaan, merit sistem salah satunya ditunjukkan dengan mekanisme rekrutmen pegawai yang terbuka, transparan dan kompetitif. Dengan metode tersebut diharapkan SDM yang dihasilkan berasal dari talenta-talenta terbaik dan unggul.<br>3.	Pengembangan karier<br>Merit sistem dalam aspek ini dapat berupa kebijakan/program pengembangan karier berdasarkan hasil pemetaan talenta melalui assessment, analisis kesenjangan kompetensi dan kesenjangan kinerja, <em>talent pool</em>, dan rencana suksesi berdasarkan pola karier instansi.<br>4.	Promosi dan Mutasi<br>Merit sistem pada aspek promosi dan mutasi diwujudkan dalam bentuk kebijakan yang objektif dan transparan didasarkan pada kesesuaian kualifikasi, kompetensi dan kinerja dengan memanfaatkan <em>Talent Pool</em>. Salah satu bentuk kebijakan tersebut adalah pengisian JPT melalui seleksi terbuka. Melalui seleksi terbuka diharapkan dapat menghasilkan orang yang tepat untuk menduduki suatu jabatan sesuai kebutuhan organisasi, mengatasi <em>spoil system </em>dan jual beli jabatan, serta memberikan kesempatan bagi semua pegawai untuk berkompetisi.<br>5.	Penilaian kinerja<br>Penetapan target kinerja, evaluasi kinerja secara berkala (berkelanjutan) dengan menggunakan metode yang obyektif, menganalisis kesenjangan kinerja dan mempunyai strategi untuk mengatasinya dan menggunakan hasil penilaian kinerja dalam membuat keputusan terkait promosi, mutasi dapat menjadi bentuk implementasi merit sistem.<br>6.	Penggajian, Penghargaan dan Disiplin<br>Instansi mengaitkan hasil penilaian kinerja dan disiplin dengan membayar tunjangan kinerja dan memberi penghargaan kepada pegawai serta melakukan penegakan nilai dasar, kode etik dan kode perilaku.<br>7.	Jaminan dan perlindungan<br>Instansi mempunyai program perlindungan untuk pegawai diluar dari jaminan kesehatan, jaminan kecelakaan kerja, dan program pensiun yang diselenggarakan pemerintah nasional, serta menjamin kemudahan pelayanan administrasi bagi pegawai.&nbsp;</p><p><strong>Evaluasi<br></strong><br></p><p><strong><br></strong>Pada perjalanannya selama hampir 8 tahun, implementasi sistem merit di birokrasi Indonesia tidak terlepas dari tantangan. Berdasarkan peta sebaran penerapan sistem merit per Provinsi sampai dengan Tahun 2021 yang disusun Komisi Aparatur Sipil Negara (KASN) sebagai instansi yang dimandatkan untuk mengawasi penyelenggaraan merit sistem menunjukkan bahwa rata-rata pemerintah provinsi wilayah Indonesia bagian barat telah menerapkan sistem merit manajemen ASN, sedangkan wilayah Indonesia bagian timur rata-rata belum menerapkan sistem merit dengan optimal. Sebaran ini menunjukkan bahwa faktor geografis mempengaruhi implementasi sistem merit. Bukan fakta yang mengejutkan mengingat wilayah Indonesia sangat luas dan berbentuk kepulauan yang seringkali menjadi tantangan dalam hal pemerataan, hingga berujung pada ketimpangan kondisi antara wilayah barat dengan timur.</p><p><br></p><p>Sementara itu, berdasarkan hasil penilaian sistem merit oleh KASN pada tahun 2021, nilai tertinggi terdapat pada aspek pengadaan sebesar 73, 9%, lalu aspek perencanaan kebutuhan 73,2%. Sedangkan aspek pengembangan karier 31% dan aspek promosi dan mutasi 41,5% merupakan aspek yang paling rendah dalam penerapannya. Hal ini menunjukkan bahwa proses pengadaan ASN kini sudah semakin terbuka dan objektif salah satunya dengan diterapkannya <em>computer assisted test </em>(CAT) sebagai media rekrutmen. World Bank Global Report: Public Sector Performance 2018 bahkan menobatkan CAT BKN sebagai produk unggul dari Indonesia pada kategori <em>Civil Service Management </em>yang berhasil mereformasi sistem rekrutmen ASN Indonesia.</p><p><br></p><p>Sejalan dengan praktek baik dalam perekrutan pegawai, guna menjaga dan meningkatkan kualitas SDM hasil rekrutmen tersebut semestinya ditindaklanjuti dengan pembinaan dan pengembangan yang baik juga. Hanya saja dari penilaian implementasi merit sistem yang dilakukan KASN justru menunjukkan aspek pengembangan karier cenderung rendah dan perlu ditingkatkan.</p><p>Penerapan merit sistem pada aspek promosi serta mutasi juga masih rendah sehingga perlu diakselerasi dan ditingkatkan. Hasil ini perlu menjadi perhatian karena menunjukkan masih adanya peluang terjadinya praktek nepotisme berbasis primordial maupun afiliasi sosial politik. Padahal, pengisian jabatan seharusnya dilakukan sesuai dengan kualifikasi yang dibutuhkan dan kompetensi serta kinerja dari pegawai dengan melihat pola karier.&nbsp;</p><p><strong>Kesimpulan&nbsp;</strong></p><p>Tidak dapat dipungkiri berlakunya merit sistem dalam birokrasi Indonesia yang bertujuan untuk menghasilkan ASN yang profesional dan berintegritas dengan menempatkan mereka pada jabatan-jabatan birokrasi pemerintah sesuai kompetensinya; pemberian kompensasi yang adil dan layak; mengembangkan kemampuan ASN melalui bimbingan dan diklat; dan melindungi karier ASN dari politisasi dan kebijakan yang bertentangan dengan prinsip merit&nbsp; belum&nbsp; sepenuhnya&nbsp; optimal&nbsp; sesuai&nbsp; dengan ketentuan maupun ekspektasi. Dalam prakteknya penerapan&nbsp; sistem&nbsp; merit&nbsp; di Indonesia cukup kompleks karena adanya pengaruh kondisi lingkungan dimana&nbsp; sistem&nbsp; itu diterapkan. Oleh karenanya tidak heran jika progres implementasi sistem merit antara instansi satu dengan yang lain berbeda mengingat ada konteks lingkungan sosial bahkan geografis yang berbeda juga.&nbsp;</p><p>Pada akhirnya penerapan sistem merit lebih dari sekedar angka dalam penilaian dan tidak semestinya kita terfokus pada pengumpulan poin saja, melainkan juga pada proses internalisasi dalam pemikiran dan keseharian para pelakunya. Perlu menjadi catatan bahwa evaluasi penerapan sistem merit dilakukan melalui skoring/penilaian atas terpenuhinya aspek-aspek ideal yang dibuktikan salah satunya dengan dokumen administrasi. Oleh karenanya, kemampuan pengelola kepegawaian instansi pemerintah untuk menyiapkan berbagai prasyarat penilaian turut berpengaruh pada penilaian sistem merit di Indonesia. &nbsp;</p><p><br></p>', 'post-thumbnail/01JGTE9ZRX31P8BC2MC4FD50YJ.jpg', 1, 0, '2025-01-04 20:16:50', '2025-01-04 20:16:50'),
(3, 1, 'Hadirnya PP Disiplin PNS Terbaru Menghapus Adanya PTDH?', 'hadirnya-pp-disiplin-pns-terbaru-menghapus-adanya-ptdh', '<p>Yogyakarta – Humas BKN,&nbsp; Pada pertengahan 2021 yang lalu pemerintah telah menerbitkan peraturan terbaru yang mengatur mengenai disiplin Pegawai Negeri Sipil (PNS). Melalui Peraturan Pemerintah (PP) Nomor 94 Tahun 2021, aturan disiplin terbaru ini mengubah peraturan sebelumnya yakni PP Nomor 53 Tahun 2010.</p><p>Salah satu hal penting dari perubahan aturan disiplin PNS ini adalah terkait dengan jenis hukuman disiplin khususnya pada jenis hukuman disiplin tingkat sedang. Jika pada aturan sebelumnya jenis hukuman disiplin tingkat sedang berupa penundaan atau penurunan pada kenaikan gaji berkala dan kenaikan pangkat, maka pada aturan terbaru diubah menjadi pemotongan tunjangan kinerja sebesar 25% secara berjenjang mulai dari enam (6), sembilan (9), hingga dua belas (12) bulan. Meskipun, aturan pemotongan tunjangan kinerja ini baru akan diterapkan saat peraturan mengenai gaji dan tunjangan PNS yang baru sudah terbit.</p><p>Selain terkait pemotongan tunjangan kinerja, dalam PP disiplin yang baru ini juga menegaskan akan status hukuman terberat bagi PNS. Jika pada aturan sebelumnya dalam lingkup disiplin PNS hukuman tertinggi masih mengakomodir pemberhentian dengan tidak dengan hormat (PTDH), maka dalam aturan disiplin yang baru telah berubah. Hukuman tertinggi dalam ranah disiplin PNS adalah pemberhentian dengan hormat (PDH). Sepanjang pelanggaran yang dilakukan masih dalam lingkup aturan disiplin PNS maka hukuman disiplin tertinggi yang dapat dikenakan adalah pemberhentian dengan hormat (PDH).&nbsp;</p><p>Apa konsekuensi dari PDH dan PTDH ini? Bagi PNS yang memperoleh PDH, maka dalam aspek kepegawaiannya saat pemberhentian dimungkinkan untuk memperoleh hak pensiun. Artinya, bagi PNS yang memperoleh PDH akan memperoleh hak pensiun sepanjang persyaratan lain terpenuhi. Sementara PNS yang dikenai PTDH maka tidak memperoleh pensiun, peluang untuk hak atas pensiun otomatis tertutup. lantas, apakah dengan hadirnya PP 94 ini hukuman pemberhentian bagi PNS hanya akan maksimal pada hukuman PDH dan menghapus adanya PTDH? Ternyata tidak.</p><p>Di luar mekanisme yang diatur dalam PP Nomor 94 ini, klausul pemberhentian PNS juga telah diatur dalam Undang-Undang Aparatur Sipil Negara (ASN). Berdasarkan Pasal 87 ayat (4) UU ASN menyatakan bahwa PNS dapat diberhentikan tidak dengan hormat (PTDH). Jenis PTDH ini dapat diberikan jika seorang PNS melakukan pelanggaran salah satu dari kondisi berikut:</p><ol><li>Melakukan penyelewengan terhadap Pancasila dan Undang-Undang Dasar Negara Republik Indonesia Tahun 1945;</li><li>Dihukum penjara atau kurungan berdasarkan putusan pengadilan yang telah memiliki kekuatan hukum tetap karena melakukan tindak pidana kejahatan jabatan atau tindak pidana kejahatan yang ada hubungannya dengan jabatan dan/atau pidana umum;</li><li>Menjadi anggota dan/atau pengurus partai politik;</li><li>Dihukum berdasarkan putusan pengadilan yang telah memiliki kekuatan hukum tetap karena melakukan tindak pidana penjara paling singkat 2 (dua) tahun dan pidana yang dilakukan dengan berencana.&nbsp;</li></ol><p>Jadi, meskipun dalam PP Nomor 94 sudah tidak diatur adanya PTDH bagi PNS yang memperoleh hukuman disiplin berat, namun kedudukan PTDH ini masih ada karena diatur tersendiri dalam salah satu pasal di UU ASN. Empat kondisi yang disebutkan di atas menjadi pintu masuk untuk diberikannya PTDH.&nbsp;</p><p>Justifikasi atas jenis hukuman disiplin yang berakibat pada PTDH ini tentu bergantung pada hasil pemeriksaan berdasarkan situasi, motif, serta dampak yang ditimbulkan dari pelanggaran tersebut. Bagi PNS yang memperoleh PDTH, seperti yang sudah disebutkan di atas maka tidak akan memperoleh hak atas pensiun dan hanya mendapatkan jaminan hari tua yang dikeluarkan oleh Taspen dengan uang Taperum. <strong><em>rdl</em></strong></p><p><br></p>', 'post-thumbnail/01JGTEH97JPDA5PYPF15Z7MFYF.png', 1, 0, '2025-01-04 20:20:49', '2025-01-04 20:20:49'),
(4, 1, 'Pejabat Fungsional Tak Perlu Lagi Urus DUPAK', 'pejabat-fungsional-tak-perlu-lagi-urus-dupak', '<p>Yogyakarta – Humas BKN, Pemerintah telah meresmikan regulasi terbaru terkait Jabatan Fungsional melalui Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi (Menpan RB) Nomor 1 Tahun 2023 yang diundangkan pada 12 Januari 2023.</p><p>Dengan adanya Permenpan RB tersebut nantinya penilaian kinerja bagi para pejabat fungsional tidak lagi diukur lagi dari butir kegiatan, tapi dari hasil kualitas kinerja, ekspektasi atasan, dan perilaku individu. “Jadi nanti para pejabat fungsional tidak sibuk untuk mengurus DUPAK (Daftar Usul Penetapan Angka Kredit). Karena evaluasi didasarkan pada hasil penilaian pemenuhan ekspektasi kinerja,” ujar Menpan RB Abdullah Azwar Anas pada sosialisasi Permenpan RB Nomor 1 Tahun 2023 di Jakarta, Jumat (27/1/2023). Hadirnya Permenpan RB Nomor 1 Tahun 2023 ini tidak hanya mengakomodasi “kerisauan” para pejabat fungsional, tetapi juga mendukung transformasi pemerintah menjadi lebih <em>agile</em> (lincah).&nbsp;</p><p>Sebagaimana tercantum pada pasal 37 ayat 1, nantinya predikat kinerja akan dikonversikan ke dalam perolehan angka kredit (AK) tahunan. Pejabat fungsional yang mendapat predikat kinerja sangat baik akan mendapatkan nilai 150% dari koefisien angka kredit tahunan sesuai dengan jenjang JF; predikat baik ditetapkan 100% dari koefisien angka kredit; predikat cukup/butuh perbaikan ditetapkan nilai 75% dari koefisien angka kredit; predikat kurang ditetapkan nilai 50% dari koefisien angka kredit; predikat sangat kurang ditetapkan nilai 25% dari koefisien angka kredit.</p><p>Sementara itu BKN juga tengah menyusun rancangan Peraturan BKN sebagai juknis dari Permenpan RB Nomor 1 Tahun 2023. Hal-hal yang akan diatur oleh BKN antara lain yaitu tentang tata cara penghitungan AK untuk perpindahan dalam JF; pemberian AK penyesuaian; penghitungan konversi predikat kinerja dalam AK; mekanisme kenaikan jenjang &amp; tata cara penghitungan AK kumulatif; mekanisme kenaikan pangkat &amp; penghitungan AK kumulatif; tata cara penyelarasan kegiatan dan hasil kerja JF ke dalam butir kegiatan JF; dan tata cara penyesuaian AK kumulatif. <strong><em>han</em></strong></p><p><br></p>', 'post-thumbnail/01JGTEMHK71X2Z1VPFCY81HK44.png', 1, 0, '2025-01-04 20:22:36', '2025-01-04 20:22:36'),
(5, 1, 'BKN Uji Alat Ukur Penilaian Potensi dan Kompetensi PNS', 'bkn-uji-alat-ukur-penilaian-potensi-dan-kompetensi-pns', '<p>Yogyakarta – Humas BKN, Kantor Regional I Badan Kepegawaian Negara (Kanreg I BKN) Yogyakarta menjadi salah satu lokasi penyelenggaraan uji validitas dan uji reliabilitas dalam pelaksanaan pemetaan kompetensi oleh Pusat Penilaian Kompetensi ASN BKN (Puspenkom BKN) pada Rabu hingga Kamis (14-15/09/2022). Sebanyak 70 pegawai dari beberapa instansi daerah di DIY menjadi peserta. Kegiatan ini bertujuan untuk memastikan bahwa metode dan alat ukur yang dikembangkan oleh Puspenkom BKN memenuhi kaidah akademik. Sehingga ke depan mampu menjadi prediksi yang baik atas potensi dan kompetensi pegawai.</p><p>Puspenkom ASN BKN pada tahun 2022 tengah mengembangkan beberapa alat ukur penilaian potensi, yaitu Psikotes dan alat ukur Kompetensi Manajerial dan Sosial Kultural yang berupa Situational Judgement Test. Pengembangan alat ukur ini bekerja sama dengan Lembaga Psikologi Terapan Universitas Indonesia untuk untuk menilai potensi talenta sesuai Permenpan RB Nomor 3 Tahun 2020.</p><p>Potensi talenta tersebut terdiri dari kemampuan intelektual, kemampuan interpersonal, kesadaran diri, kemampuan berpikir kritis dan strategis, kemampuan menyelesaikan permasalahan, kecerdasan emosional, kemampuan belajar cepat dan mengembangkan diri, serta motivasi dan komitmen. Sasaran dari alat ukur potensi ini adalah seluruh jenjang jabatan, mulai dari pelaksana sampai dengan pejabat pimpinan tinggi utama, dan jabatan fungsional setara. Sedangkan alat ukur Situational Judgement Test disusun untuk menilai 9 kompetensi manajerial dan sosiokultural sesuai Permenpan RB Nomor 38 Tahun 2017. Kompetensi manajerial terdiri dari integritas, kerja sama, komunikasi, orientasi pada hasil, pelayanan publik, pengembangan diri dan orang lain, mengelola perubahan dan pengambilan keputusan. Selain itu terdapat kompetensi sosial kultural yang dinilai yaitu perekat bangsa. Alat ukur kompetensi ini diperuntukan bagi pejabat administrator, pengawas dan pelaksana serta jabatan fungsional madya ke bawah.</p><p>Purwanto, Asesor Utama BKN mengungkapkan bahwa pengembangan metode dan instrumen/alat ukur yang dikembangkan oleh BKN saat ini berbasis daring sehingga dapat massal. “Pengolahan data hasil berbasis aplikasi tanpa harus melalui assessor meeting dan dapat dipetakan dalam <em>nine box</em> (<em>talent mapping</em>),” jelas Purwanto pada pembukaan kegiatan. Pengembangan metode dan instrumen yang dilakukan merupakan respon BKN untuk memberikan layanan kepegawaian yang lebih baik, terutama dalam layanan penilaian kompetensi bagi PNS, sekaligus sebagai respon atas tuntutan pengelolaan pemerintahan yang berbasis elektronik/digital.</p><p>Selain Kanreg I BKN Yogyakarta, uji validitas dan uji reliabilitas dalam pelaksanaan pemetaan kompetensi dilakukan secara serempak di empat titik lokasi lainnya, yaitu di Kanreg II BKN Surabaya, Kanreg VI BKN Medan, Kanreg VIII BKN Banjarmasin dan UPT BKN Gorontalo, dengan total jumlah peserta keseluruhan sebanyak 300 peserta. <strong><em>han</em></strong></p><p><br></p>', 'post-thumbnail/01JGTEQ37JGA9DRKT3Q6BVC7FV.png', 1, 0, '2025-01-04 20:23:59', '2025-01-04 20:23:59'),
(6, 2, 'Mengenal Sistem Kepegawaian di Indonesia: Regulasi, Hak, dan Kewajiban', 'mengenal-sistem-kepegawaian-di-indonesia-regulasi-hak-dan-kewajiban', '<h3><strong>Pendahuluan</strong></h3><p>Kepegawaian merupakan aspek penting dalam pengelolaan sumber daya manusia di berbagai sektor, baik pemerintahan maupun swasta. Di Indonesia, sistem kepegawaian terutama diatur dalam peraturan perundang-undangan yang memastikan kesejahteraan, hak, serta kewajiban pegawai dalam menjalankan tugasnya.</p><h3><strong>Regulasi Kepegawaian di Indonesia</strong></h3><p>Dalam lingkup pemerintahan, regulasi utama yang mengatur kepegawaian adalah <strong>Undang-Undang Nomor 20 Tahun 2023 tentang Aparatur Sipil Negara (ASN)</strong>. Undang-undang ini mengatur sistem pengelolaan pegawai negeri, yang terbagi menjadi dua kategori utama:</p><ol><li><strong>Pegawai Negeri Sipil (PNS)</strong> – Pegawai tetap yang memperoleh gaji dan tunjangan dari APBN atau APBD.</li><li><strong>Pegawai Pemerintah dengan Perjanjian Kerja (PPPK)</strong> – Pegawai yang diangkat berdasarkan kontrak untuk jangka waktu tertentu.</li></ol><p>Selain itu, regulasi terkait juga mencakup Peraturan Pemerintah (PP), Peraturan Menteri, serta berbagai kebijakan teknis yang diterapkan di masing-masing instansi.</p><h3><strong>Hak dan Kewajiban Pegawai</strong></h3><p>Pegawai di Indonesia memiliki sejumlah hak yang dijamin oleh peraturan, antara lain:</p><ul><li>Gaji dan tunjangan</li><li>Cuti tahunan dan cuti khusus</li><li>Jaminan pensiun dan asuransi kesehatan</li><li>Pengembangan kompetensi dan pelatihan</li><li>Perlindungan hukum dalam pelaksanaan tugas</li></ul><p>Namun, setiap pegawai juga memiliki kewajiban yang harus dipenuhi, seperti:</p><ul><li>Mematuhi peraturan disiplin pegawai</li><li>Menjaga integritas dan profesionalisme dalam bekerja</li><li>Melaksanakan tugas dengan penuh tanggung jawab</li><li>Menghindari konflik kepentingan</li></ul><h3><strong>Sistem Pengelolaan Kepegawaian</strong></h3><p>Pemerintah telah mengembangkan berbagai sistem informasi kepegawaian untuk mempermudah pengelolaan data pegawai. Salah satu sistem utama adalah <strong>Sistem Informasi Kepegawaian Nasional (SIASN)</strong> yang terintegrasi dengan Badan Kepegawaian Negara (BKN). Melalui sistem ini, proses administrasi seperti pengangkatan, mutasi, kenaikan pangkat, dan pensiun dapat dilakukan dengan lebih efisien.</p><h3><strong>Tantangan dalam Kepegawaian</strong></h3><p>Beberapa tantangan yang dihadapi dalam sistem kepegawaian di Indonesia antara lain:</p><ol><li><strong>Digitalisasi dan Adaptasi Teknologi</strong> – Proses transisi ke sistem digital masih mengalami kendala di beberapa daerah.</li><li><strong>Reformasi Birokrasi</strong> – Perlu adanya penyederhanaan regulasi dan prosedur untuk meningkatkan efisiensi kerja.</li><li><strong>Peningkatan Kompetensi</strong> – Pegawai perlu terus mengikuti pelatihan dan sertifikasi agar dapat menyesuaikan diri dengan perkembangan zaman.</li></ol><h3><strong>Kesimpulan</strong></h3><p>Kepegawaian di Indonesia terus mengalami perkembangan seiring dengan perubahan regulasi dan kebutuhan zaman. Dengan adanya sistem yang lebih transparan dan efisien, diharapkan pegawai, khususnya ASN, dapat bekerja lebih profesional dan memberikan pelayanan terbaik kepada masyarakat. Untuk itu, penting bagi setiap pegawai memahami hak dan kewajibannya serta terus beradaptasi dengan perkembangan teknologi dalam dunia kerja.</p><p><br></p>', 'post-thumbnail/01JKSN2Y837JBZT8PG26FQGYV2.png', 1, 0, '2025-02-11 04:43:10', '2025-02-11 04:43:10'),
(7, 2, 'Peran dan Tantangan Kepegawaian dalam Administrasi Publik', 'peran-dan-tantangan-kepegawaian-dalam-administrasi-publik', '<p>Kepegawaian merupakan elemen kunci dalam administrasi publik yang berperan dalam memastikan kelancaran fungsi pemerintahan dan pelayanan masyarakat. Sistem kepegawaian yang efektif dapat meningkatkan efisiensi, transparansi, dan akuntabilitas birokrasi.</p><h3><strong>Peran Kepegawaian dalam Administrasi Publik</strong></h3><ol><li><strong>Pelayanan Publik yang Efisien</strong><ul><li>Pegawai negeri berperan dalam menyelenggarakan layanan publik yang berkualitas.</li><li>Digitalisasi administrasi kepegawaian mempercepat proses birokrasi.</li></ul></li><li><strong>Menjaga Stabilitas Pemerintahan</strong><ul><li>Pegawai pemerintah bekerja untuk menjaga kesinambungan kebijakan dan program nasional.</li><li>Profesionalisme pegawai mendukung implementasi kebijakan yang efektif.</li></ul></li><li><strong>Peningkatan Kualitas Sumber Daya Manusia (SDM)</strong><ul><li>Pelatihan dan pengembangan kompetensi membantu pegawai menyesuaikan diri dengan perubahan zaman.</li><li>Reformasi birokrasi menekankan pentingnya peningkatan kapasitas pegawai.</li></ul></li></ol><h3><strong>Tantangan dalam Manajemen Kepegawaian</strong></h3><ol><li><strong>Beban Administratif yang Tinggi</strong><ul><li>Proses administratif yang kompleks sering menghambat efektivitas kerja.</li><li>Perlu adanya penyederhanaan birokrasi melalui inovasi digital.</li></ul></li><li><strong>Kurangnya SDM yang Berkualitas</strong><ul><li>Tantangan dalam merekrut dan mempertahankan pegawai yang kompeten.</li><li>Diperlukan peningkatan sistem seleksi dan pengembangan karier.</li></ul></li><li><strong>Transparansi dan Akuntabilitas</strong><ul><li>Korupsi dan nepotisme masih menjadi kendala dalam sistem kepegawaian.</li><li>Penguatan sistem meritokrasi untuk meningkatkan kepercayaan publik.</li></ul></li></ol><h3><strong>Reformasi Kepegawaian</strong></h3><ol><li><strong>Digitalisasi Administrasi</strong><ul><li>Penggunaan sistem informasi kepegawaian untuk meningkatkan efisiensi.</li><li>Implementasi e-government dalam proses kepegawaian.</li></ul></li><li><strong>Peningkatan Kesejahteraan Pegawai</strong><ul><li>Penyediaan tunjangan dan insentif yang adil bagi pegawai.</li><li>Pengembangan lingkungan kerja yang kondusif dan produktif.</li></ul></li><li><strong>Penerapan Sistem Merit</strong><ul><li>Rekrutmen dan promosi berbasis kompetensi dan kinerja.</li><li>Evaluasi kinerja pegawai yang objektif dan berbasis data.</li></ul></li></ol><h3><strong>Kesimpulan</strong></h3><p>Manajemen kepegawaian yang baik sangat penting untuk efektivitas administrasi publik. Dengan mengatasi tantangan yang ada melalui reformasi birokrasi, digitalisasi, dan peningkatan kesejahteraan pegawai, sistem kepegawaian dapat lebih adaptif dan responsif terhadap perubahan zaman. Transparansi dan profesionalisme harus terus dijaga guna meningkatkan kepercayaan masyarakat terhadap pemerintahan. hmm</p>', 'post-thumbnail/01JKSQK6YV96N9P19JXYB069ME.jpg', 1, 0, '2025-02-11 05:27:00', '2025-02-11 05:28:40'),
(8, 1, 'Peresmian Assessment Center Kabupaten Raja Ampat oleh Kepala Badan Kepegawaian Negara', 'peresmian-assessment-center-kabupaten-raja-ampat-oleh-kepala-badan-kepegawaian-negara', '<p>Waisai, Raja Ampat, Jumat (14/02/2025) - Kepala Badan Kepegawaian Negara Prof. Zudan Arif Fakrullah, S.H.,M.H, memberikan apresiasi kepada Pemerintah Kabupaten Raja Ampat, Pemerintah Provinsi Papua Barat Daya, dan Kantor Regional XIV BKN Manokwari atas peresmian Gedung <em>Assessment Center</em> Kabupaten Raja Ampat. Peresmian Gedung <em>Assessment Center </em>Kabupaten Raja Ampat oleh Kepala BKN dan Bupati Raja Ampat, dihadiri oleh Pj. Gubernur Papua Barat Daya, Deputi Bidang Pembinaan Penyelenggaraan Manajemen ASN BKN, Kepala Kantor Regional XIV BKN Manokwari, FORKOPIMDA Kabupaten Raja Ampat, seluruh pimpinan OPD Kabupaten Raja Ampat, dan Kepala BKD/BKPSDM/BKPP/BKDD se-wilayah kerja Kantor Regional XIV BKN.</p><p>Dalam arahannya Prof. Zudan menyampaikan berdirinya <em>Assessment Center</em> ini tidak hanya menjadi momentum bersejarah sebagai <em>Assessment Center </em>pertama yang dimiliki instansi daerah di wilayah Timur Indonesia, tetapi juga menjadi bukti komitmen pemerintah daerah khususnya Pemerintah Kabupaten Raja Ampat dalam membangun SDM yang unggul dan berdaya saing.</p><p>Senada dengan Kepala BKN, Kepala Kantor Regional XIV BKN Manokwari, Nur Hasan, S.Sos.,M.Adm.SDA menyampaikan bahwa berdirinya gedung <em>Assessment Center</em> merupakan langkah strategis dalam percepatan pembangunan manajemen talenta ASN di wilayah kerja Kantor Regional XIV BKN, sekaligus menjadi <em>role model</em> kolaborasi bagi daerah lain di Indonesia khususnya di wilayah Papua.<br><br>berita: Nusa<br>editor: Afry<br>foto: Arfian</p>', 'post-thumbnail/01JMBBEHBHFWY3205VA3BZKD59.jpg', 1, 1, '2025-02-18 01:41:04', '2025-02-18 01:41:04'),
(9, 1, 'Rapat Kerja Bagian/Bidang Selama WFA', 'rapat-kerja-bagianbidang-selama-wfa', '<p>Selasa, 08/04/2025 - Kepala Kantor Regional XIV BKN Manokwari, Nur Hasan, S.Sos.,M.Adm.SDA memimpin rapat kerja pegawai rutin dilaksanakan untuk membahas kinerja setiap bidang dan bagian di lingkungan Kantor Regional XIV BKN Manokwari dan UPSCPKP ASN BKN Sorong yang dilaksanakan secara daring melalui <em>virtual zoom meeting</em>.&nbsp;</p><p>Pada rapat kerja ini, Kepala Kantor Regional XIV BKN Manokwari memberikan arahan kepada setiap bidang teknis untuk terus berkoordinasi secara intensif dengan instansi daerah terkait percepatan penyelesaian penetapan NIP CPNS dan NI PPPK Tahap I Tahun Anggaran 2024, penyelesaian disparitas data, penyelesaian kenaikan pangkat, pencantuman gelar, akselerasi pembangunan manajemen talenta ASN diwilayah kerja Kantor Regional XIV BKN Manokwari. Serta agar dijadwalkan secara rutin pertemuan dengan instansi wilayah kerja Kantor Regional XIV BKN Manokwari terkait penyelesaian permasalahan kepegawaian di instansi.</p><p>Selanjutnya, Kepala Kantor Regional XIV BKN Manokwari memberi apresiasi kepada seluruh pegawai yang tetap produktif dan berkinerja selama masa cuti bersama Hari Suci Nyepi dan Hari Raya Idul Fitri 1446 H, serta tetap optimal berkinerja selama <em>Work From Anywhere </em>(WFA) berlangsung.&nbsp;</p>', 'post-thumbnail/01JRW5MR0J39QV323CZVZ8EZNT.png', 1, 0, '2025-04-15 07:29:29', '2025-04-15 07:29:29'),
(10, 1, 'Aksi Donor Darah Kantor Regional XIV BKN Manokwari Dalam Rangka HUT BKN ke - 77', 'aksi-donor-darah-kantor-regional-xiv-bkn-manokwari-dalam-rangka-hut-bkn-ke-77', '<p>&nbsp;</p><p>Kamis, 22/05/2025 - Dalam rangka memperingati momen ulang tahun Badan Kepegawaian Negara ke - 77 Tahun, Kantor Regional XIV BKN Manokwari mengadakan kegiatan donor darah. Kegiatan donor darah ini bekerja sama dengan Unit Donor Darah Palang Merah Indonesia (PMI) Provinsi Papua Barat, bertempat di lantai 2 kantor Regional XIV BKN Manokwari.</p><p>Dalam sambutan Kepala Kantor Regional XIV BKN Manokwari, Nur Hasan, S.Sos.,M.Adm.SDA, menyampaikan bahwa pada hari ini kita bersyukur dan berbahagia karena diberikan kesehatan dan memiliki kesempatan mendonorkan darah kepada yang membutuhkan.</p><p>“Bagi Bapak Ibu yang baru pertama kali mendonorkan darah, pasti merasa deg-degan, tetapi coba Bapak Ibu membayangkan ada orang sakit yang membutuhakn setetes darah kita, saya sakin akan sirna rasa sakit itu”, ujar Nur Hasan.</p><p>Mewakili PMI Provinsi Papua Barat, dr. Christin, mengungkapkan terima kasih dan mengapresiasi kantor Regional XIV BKN Manokwari yang telah menyelenggarakan kegiatan donor darah pada hari ini. “Donor darah bukan hanya membantu orang sakit yang membutuhkan, tetapi dengan donor darah akan membuat tubuh kita lebih sehat, dan mencegah penyakit jantung dan kolesterol”, ungkap dokter Christin.</p><p>Dalam kesempatan ini turut berpartisipasi Kepala PT. Taspen Manokwari dan Kepala Bank Mandiri Taspen Cabang Manokwari beserta pegawai, serta pengurus Dharma Wanita Persatuan (DWP) Kantor Regional XIV BKN Manokwari.&nbsp;<br><br>Foto : Nusa<br>Berita : Nusa<br>Editor : Afry</p>', 'post-thumbnail/01JWABS4NSYTZ0DMF6GRT20G5G.jpeg', 1, 0, '2025-05-28 02:33:12', '2025-05-28 02:33:12'),
(11, 1, 'Pengukuhan Dewan Pengurus KORPRI Komisariat Kantor Regional XIV BKN Manokwari', 'pengukuhan-dewan-pengurus-korpri-komisariat-kantor-regional-xiv-bkn-manokwari', '<p>&nbsp;</p><p>Selasa, 27/05/2025 - Ketua Dewan Pengurus KORPRI BKN, Neny Rochyani, S.Si.Apt.,M.Si, mengukuhkan Ketua dan Personalia Dewan Pengurus KORPRI Badan Kepegawaian Negara Komisariat Kantor Regional XIV BKN masa bakti 2025 - 2030 yang dilaksanakan secara <em>hybird</em>.</p><p>Kepala Kantor Regional XIV BKN Manokwari, Nur Hasan, S.Sos.M.Adm.SDA, sebagai Ketua Dewan Pengurus KORPRI Badan Kepegawaian Negara Komisariat Kantor Regional XIV BKN menerima penyerahan bendera Pataka KORPRI sebagai simbolisasi pengukuhan Dewan pengurus KORPRI yang baru secara langsung di Ruang Mawar Badan Kepegawaian Negara dan disaksikan oleh seluruh personalia pengurus melalui virtual zoom meeting di Kantor Regional XIV BKN Manokwari.&nbsp;<br>Ketua Dewan Pengurus KORPRI BKN, Neny Rochyani, memberikan ucapan selamat kepada pengurus KORPRI yang baru dikukuhkan dan berpesan agar aktif guna meningkatkan peran KORPRI melalui program - program positif dan bermanfaat dari setiap bidang.&nbsp;<br><br>Berita : Nusa, Foto : Nusa, Editor : Afry</p>', 'post-thumbnail/01JXA4ZDNQG2AXCPZP61T94C5Z.png', 1, 1, '2025-06-09 10:49:59', '2025-06-09 10:49:59'),
(12, 1, 'Peningkatan Layanan Kesehatan  Pegawai Kantor Regional XIV BKN Manokwari', 'peningkatan-layanan-kesehatan-pegawai-kantor-regional-xiv-bkn-manokwari', '<p>&nbsp;</p><p>Selasa, 3/06/2025 - Dalam rangka meningkatkan kesejahteraan pegawai dalam hal kesehatan pegawai, Kepala Kantor Regional XIV BKN Manokwari, Nur Hasan, S.Sos.,M.Adm.SDA menyediakan layanan kesehatan berupa tenaga kesehatan dokter dan perawat secara rutin di klinik kesehatan Kantor Regional XIV BKN Manokwari.&nbsp;</p><p>Melalui koordinasi bersama Kodam XVIII Kasuari, Kantor Regional XIV BKN mendapat dukungan satu dokter dan satu perawat yang akan membuka layanan kesehatan 2 kali dalam seminggu.&nbsp;</p><p>Dalam arahannya, Kepala Kantor Regional XIV BKN menyampaikan bahwa hal ini merupakan upaya untuk menjaga kesehatan pegawai serta memberikan kemudahan bagi pegawai apabila ada yang sakit ataupun ingin berkonsultasi permasalah kesehatan.</p><p>Adapun layanan kesehatan ini diperuntukkan bagi seluruh pegawai, PPNPN, serta bagi suami/istri/anak seluruh pegawai.&nbsp;<br><br>Berita: Nusa, Foto : Nusa, Editor : Afry</p>', 'post-thumbnail/01JXA52GP843JRJ7D3APRT934C.png', 1, 0, '2025-06-09 10:51:41', '2025-06-09 10:51:41'),
(13, 1, 'Pelaksanaan CAT Ujian Dinas dan Ujian Penyesuaian Kenaikan Pangkat PNS di Lingkungan POLRI TA 2025', 'pelaksanaan-cat-ujian-dinas-dan-ujian-penyesuaian-kenaikan-pangkat-pns-di-lingkungan-polri-ta-2025', '<p>&nbsp;Manokwari, Rabu (11/06/2025) – Kantor Regional XIV Badan Kepegawaian Negara Manokwari memfasilitasi pelaksanaan Ujian Dinas dan Ujian Penyesuaian Kenaikan Pangkat (UPKP) PNS di lingkungan POLRI TA 2025 yang dilaksanakan selama 2 (dua) hari mulai tanggal 11 s.d 12 Juni 2025 dengan metode CAT BKN diikuti oleh 4 (empat) orang peserta dari Polda Papua Barat.&nbsp;</p>', 'post-thumbnail/01JXGZEXXRPP9C89Q4SWFVXDFB.png', 1, 0, '2025-06-12 02:28:17', '2025-06-12 02:28:17'),
(14, 1, 'Bimbingan Teknis Penyusunan SKP dan Penggunaan Aplikasi E-Kinerja bagi Pegawai Pemerintah Kabupaten Pegunungan Arfak', 'bimbingan-teknis-penyusunan-skp-dan-penggunaan-aplikasi-e-kinerja-bagi-pegawai-pemerintah-kabupaten-pegunungan-arfak', '<p>&nbsp;</p><p>Manokwari, Rabu (11/06/2025) – Dalam upaya meningkatkan efektivitas sistem penilaian kinerja Aparatur Sipil Negara (ASN), Kantor Regional XIV Badan Kepegawaian Negara (BKN) Manokwari melaksanakan bimbingan teknis penyusunan SKP dan penggunaan aplikasi E-Kinerja bagi seluruh Organisasi Perangkat Daerah (OPD) Kabupaten Pegunungan Arfak sejumlah 135 peserta.</p><p>Kegiatan ini akan dilaksanakan dalam tiga (3) angkatan diawali dengan pra bimibingan teknis secara daring pada tanggal 11 s.d 13 Juni 2025 dengan memastikan seluruh peserta dapat mengakses aplikasi E-Kinerja BKN, dengan harapan seluruh peserta mendapatkan informasi awal tentang penyusunan SKP sebelum pelaksanaan bimbingan teknis yang akan dilaksanakan pada tanggal 19 s.d 28 Juni 2025 secara tatap muka langsung (luring).&nbsp;</p>', 'post-thumbnail/01JXGZGKWR2Z6DQ1CVE5RD8QCW.png', 1, 1, '2025-06-12 02:29:12', '2025-06-12 02:29:24'),
(15, 1, 'Kepala Kantor Regional XIV BKN Terima Audiensi Pemerintah Kabupaten Manokwari Selatan terkait Formasi ASN TA 2021', 'kepala-kantor-regional-xiv-bkn-terima-audiensi-pemerintah-kabupaten-manokwari-selatan-terkait-formasi-asn-ta-2021', '<p>&nbsp;</p><p>Manokwari, Selasa (17/06/2025) – Kepala Kantor Regional XIV BKN, Nur Hasan, S.Sos.,M.Adm.SDA menerima audiensi dari Pemerintah Kabupaten Manokwari Selatan dalam hal ini Wakil Bupati Manokwari Selatan, Mesak Inyomusi, S.E., M.Si, didampingi Plt. Sekretaris Daerah Kabupaten Manokwari Selatan, Adolop Kawey, S.H, Ketua Dewan Perwakilan Rakyat Kabupaten (DPRK) Manokwari Selatan, Ferdinand Waran, S.H, dan Kepala BKPSDM Kabupaten Manokwari Selatan, Leo Leonard Sayori, S.STP., bertempat di Kantor Regional XIV BKN Manokwari.</p><p>Audiensi tersebut membahas terkait tindak lanjut proses pelaksanaan seleksi CASN Formasi Tahun Anggaran 2021 Kabupaten Manokwari Selatan. Dalam audiensi tersebut Ketua DPRK Mansel menyampaikan beberapa aspirasi dari masyarakat khususnya tenaga honorer, diantaranya hasil verifikasi data honorer dan kepastian jadwal penerimaan SK CPNS TA 2021.&nbsp;</p><p>Kepala Kantor Regional XIV BKN menjelaskan bahwa proses pelaksanaan formasi honorer Tahun Anggaran 2021 Kabupaten Manokwari Selatan sedang berjalan sesuai dengan mekanisme yang berlaku, sebagaimana surat Menteri PANRB Nomor: B/1707/M.SM.01.00/2021 tanggal 26 November 2021 perihal Formasi ASN Tahun 2021, dan surat Menteri PANRB Nomor: B/2766/M.SM.01.00/2023 tanggal 26 Oktober 2023 perihal Permohonan Dilakukan Verifikasi dan Validasi Tenaga Honorer di Provinsi, Kabupaten dan Kota di Wilayah Papua Barat dan Papua Barat Daya.</p><p>Kakanreg XIV BKN juga menyampaikan apresiasi kepada Pemerintah Kabupaten Manokwari Selatan yang menanggapi proses pelaksanaan formasi honorer TA 2021 dengan cepat sehingga saat ini proses dapat berjalan dengan lancar dan berharap agar masyarakat tetap tenang serta terus melaksanakan tugas pada unit masing-masing.&nbsp;</p>', 'post-thumbnail/01JY04B4QWHAEPB5P98BVCBN22.png', 1, 1, '2025-06-17 23:42:12', '2025-06-17 23:42:12'),
(16, 1, 'Pembekalan Peserta Ujian Dinas dan Ujian Penyesuaian Kenaikan Pangkat di Lingkungan Pemerintah Kabupaten Fakfak', 'pembekalan-peserta-ujian-dinas-dan-ujian-penyesuaian-kenaikan-pangkat-di-lingkungan-pemerintah-kabupaten-fakfak', '<p>&nbsp;</p><p>Fakfak, Jumat (13/06/2025) – Kepala Kantor Regional XIV BKN, Nur Hasan, S.Sos.,M.Adm.SDA memberikan pembekalan bagi pegawai yang mengikuti kegiatan Ujian Dinas (UD) dan Ujian Penyesuaian Kenaikan Pangkat (UPKP)di Lingkungan Pemerintah Kabupaten Fakfak.&nbsp;</p><p>Kegiatan tersebut dibuka langsung oleh Wakil Bupati Fakfak, Drs. Donatus Nimbitkendik, M.T. dengan turut dihadiri oleh Sekretaris Daerah Kabupaten Fakfak, Drs. Ec. Sulaeman Uswanas, M.Si.&nbsp;</p><p>Kegiatan ini diikuti peserta dengan rincian peserta UD dan UPKP sebanyak 109 orang, yang terdiri dari 23 peserta UD tingkat I, 27 peserta UD tingkat II, 11 peserta UPKP SMA, dan 48 peserta UPKP S-1, dan ujian akan dilaksanakan hari Sabtu, 14 Juni 2025 menggunakan metode CAT BKN dan wawancara.&nbsp;</p><p>Pembekalan peserta oleh Kepala Kantor Regional XIV BKN bertujuan memberikan gambaran umum terkait jenis-jenis tes dan materi ujian yang perlu dipelajari oleh peserta untuk mengikuti ujian, dan diharapkan peserta UD dan UPKP dapat mengikuti ujian dengan lebih siap dan optimal.&nbsp;</p>', 'post-thumbnail/01JZ9FEAJFNNHA5CDKBYS9C72T.png', 1, 0, '2025-07-04 01:05:03', '2025-07-04 01:05:03'),
(17, 2, 'Membangun Sistem Kepegawaian yang Profesional dan Adaptif di Era Digital', 'membangun-sistem-kepegawaian-yang-profesional-dan-adaptif-di-era-digital', '<p><strong>Pendahuluan</strong></p><p>&nbsp;<br>Kepegawaian merupakan aspek fundamental dalam manajemen organisasi, khususnya dalam sektor pemerintahan. Kualitas sumber daya manusia (SDM) yang dikelola dengan baik akan berpengaruh besar terhadap kinerja organisasi secara keseluruhan. Di era digital saat ini, sistem kepegawaian tidak lagi hanya berfokus pada administrasi semata, tetapi juga pada pengembangan kompetensi, integritas, dan kemampuan adaptasi terhadap perubahan teknologi.<br>&nbsp;</p><h3><strong>Transformasi Digital dalam Pelayanan Kepegawaian</strong></h3><p>&nbsp;<br>Dengan perkembangan teknologi informasi, pelayanan kepegawaian kini mulai bergeser ke arah digitalisasi. Proses-proses seperti rekrutmen, penilaian kinerja, kenaikan pangkat, hingga pensiun mulai dilakukan secara elektronik. Sistem informasi kepegawaian yang terintegrasi (seperti <em>e-office</em>, <em>e-performance</em>, dan <em>e-personnel</em>) memungkinkan pegawai untuk mengakses informasi kepegawaian dengan lebih cepat, transparan, dan akuntabel.<br>&nbsp;<br>Contoh implementasi nyata dari digitalisasi kepegawaian dapat dilihat dalam layanan kepegawaian berbasis aplikasi yang disediakan oleh instansi pemerintah, seperti Badan Kepegawaian Negara (BKN) melalui aplikasi MySAPK dan sistem CAT dalam seleksi ASN.<br>&nbsp;</p><h3><strong>Pengembangan Kompetensi dan Karier Pegawai</strong></h3><p>&nbsp;<br>Pegawai tidak hanya dituntut untuk memiliki kemampuan dasar administratif, tetapi juga dituntut untuk terus mengembangkan kompetensi sesuai dengan perkembangan zaman. Oleh karena itu, pelatihan dan pengembangan SDM menjadi prioritas utama dalam sistem kepegawaian modern.<br>&nbsp;<br>Program pengembangan karier seperti pelatihan teknis, diklat kepemimpinan, dan pembelajaran berbasis digital (<em>e-learning</em>) sangat diperlukan untuk meningkatkan kapasitas aparatur sipil negara (ASN). Dengan demikian, pegawai dapat berkontribusi secara optimal dalam pelayanan publik yang profesional dan berintegritas.<br>&nbsp;</p><h3><strong>Etika dan Nilai Dasar ASN</strong></h3><p>&nbsp;<br>Selain kompetensi teknis, ASN juga harus menjunjung tinggi etika profesi dan nilai-nilai dasar seperti yang tercantum dalam core values ASN yaitu <strong>BerAKHLAK</strong> (Berorientasi Pelayanan, Akuntabel, Kompeten, Harmonis, Loyal, Adaptif, dan Kolaboratif). Nilai-nilai ini menjadi pedoman moral dan perilaku dalam bekerja, baik secara individu maupun sebagai bagian dari tim.<br>&nbsp;</p><h3><strong>Kesimpulan</strong></h3><p>&nbsp;<br>Kepegawaian bukan hanya urusan administratif, tetapi juga strategi penting dalam pembangunan kualitas birokrasi yang tangguh, adaptif, dan responsif terhadap kebutuhan masyarakat. Dengan memanfaatkan teknologi, meningkatkan kompetensi, dan menjunjung tinggi nilai-nilai ASN, kita dapat mewujudkan aparatur negara yang profesional dan melayani dengan sepenuh hati.<br>&nbsp;</p>', 'post-thumbnail/01JZ9MGB8Q8EMPYF4V3HHAYGNC.png', 1, 0, '2025-07-04 02:33:32', '2025-07-04 02:33:32'),
(18, 1, 'Penyerahan Piagam Penghargaan atas Penyelesaian SK Pensiun dan Kenaikan Pangkat PNS serta Penyelesaian SK CPNS dan PPPK Tahap I Tepat Waktu bagi Pemerintah Kabupaten Fakfak', 'penyerahan-piagam-penghargaan-atas-penyelesaian-sk-pensiun-dan-kenaikan-pangkat-pns-serta-penyelesaian-sk-cpns-dan-pppk-tahap-i-tepat-waktu-bagi-pemerintah-kabupaten-fakfak', '<p>&nbsp;</p><p>Fakfak, Sabtu (14/06/2025) – Kepala Kantor Regional XIV BKN Manokwari, Nur Hasan S.Sos.,M.Adm.SDA menyerahkan 2 (dua) piagam penghargaan kepada Pemerintah Kabupaten Fakfak yang terdiri atas penyelesaian SK Pensiun PNS sebelum Terhitung Mulai Tanggal (TMT) Batas Usia Pensiun (BUP) dan Penyelesaian SK Kenaikan Pangkat (KP) PNS Tepat Waktu serta penghargaan kedua diberikan atas penyelesaian SK pengangkatan Calon Pegawai Negeri Sipil (CPNS) dan Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Tahap I Tahun Anggaran 2024 secara tepat waktu.&nbsp;</p><p>Pemberian piagam penghargaan tersebut diberikan langsung oleh Kepala Kantor Regional XIV BKN kepada Bupati Fakfak, Samaun Dahlan, S.Sos., M.AP didampingi oleh Wakil Bupati Fakfak, Drs. Donatus Nimbitkendik, M.T.&nbsp;</p><p>Pada kegiatan tersebut, juga dilaksanakan penandatanganan komitmen bersama oleh Kepala Kantor Regional XIV BKN dan Bupati Fakfak atas akselerasi penerapan Manajemen Talenta Instansi berbasis sistem meritokrasi guna mewujudkan tata kelola pemerintahan yang baik khususnya di lingkungan pemerintah Kabupaten Fakfak.&nbsp;</p>', 'post-thumbnail/01JZHNG4D1N7BF3ZW25JPN3EZ9.png', 1, 0, '2025-07-07 05:24:49', '2025-07-07 05:24:49'),
(19, 1, 'Rapat Penyelesaian Permasalahan Kepegawaian Wilayah Kerja Kantor Regional XIV BKN', 'rapat-penyelesaian-permasalahan-kepegawaian-wilayah-kerja-kantor-regional-xiv-bkn', '<p>&nbsp;</p><p>Manokwari, Rabu (17/06/2025) – Dalam rangka penguatan koordinasi dan peningkatan kualitas pelayanan kepegawaian, Kantor Regional XIV BKN menyelenggarakan Rapat Penyelesaian Permasalahan Kepegawaian di wilayah kerja Kantor Regional XIV BKN, yang dilaksanakan melalui <em>virtual zoom meeting</em>. Kegiatan tersebut dihadiri oleh Kepala dan Kepala Bidang beserta staf di BKD/BKDD/BKPP/BKPSDM se wilayah Kerja Kantor Regional XIV BKN Manokwari.</p><p>Kepala Kantor Regional XIV BKN, Nur Hasan, S.Sos.,M.Adm.SDA, menyampaikan bahwa pertemuan ini penting untuk membangun komunikasi yang baik sehingga tidak terjadi <em>miss </em>informasi, membuka ruang diskusi, serta memastikan penerapan kebijakan - kebijakan terbaru dari BKN pada instansi daerah.&nbsp;</p><p>Dalam rapat tersebut Kepala Kantor Regional (Kakanreg) XIV BKN membahas terkait kebijakan terbaru BKN perihal Pencantuman Gelar Akademik (PGA) sesuai SE Kepala BKN Nomor 3 Tahun 2025, evaluasi penerapan pengawasan Manajemen Talenta melalui Indeks NSPK, serta sosialisasi Peraturan Kepala BKN Nomor 2 Tahun 2025 tentang Kenaikan Pangkat Reguler Pegawai Negeri Sipil.</p><p>Lebih lanjut, Kepala Kantor Regional XIV BKN memberikan apresiasi kepada 8 (delapan) instansi daerah yang telah menyerahkan SK CPNS dan PPPK Tahap I dan menghimbau agar memastikan seluruh CPNS maupun PPPK yang baru saja menerima SK segera melaksanakan tugas pada unit kerja masing-masing.&nbsp;</p><p>Selanjutnya Kakanreg menyampaikan kembali sebagaimana arahan Presiden RI dalam mewujudkan Asta Cita agar instansi menerapkan implementasi Manajemen Talenta ASN.&nbsp;</p>', 'post-thumbnail/01JZHNKVVX18SCC63DPF1D0TGX.png', 1, 0, '2025-07-07 05:26:51', '2025-07-07 05:26:51'),
(20, 1, 'Kepala Kantor Regional XIV BKN Berikan Pengarahan pada Bimtek Penyusunan SKP dan Penggunaan Aplikasi E-Kinerja di  Lingkungan Pemerintah Kabupaten Pegunungan Arfak', 'kepala-kantor-regional-xiv-bkn-berikan-pengarahan-pada-bimtek-penyusunan-skp-dan-penggunaan-aplikasi-e-kinerja-di-lingkungan-pemerintah-kabupaten-pegunungan-arfak', '<p>&nbsp;</p><p>Manokwari, 19/06/2025 – Kepala Kantor Regional XIV Badan Kepegawaian Negara (BKN) Manokwari, Nur Hasan, S.Sos., M.Adm.SDA, memberikan pengarahan dalam pembukaan kegiatan Bimbingan Teknis Penyusunan Sasaran Kinerja Pegawai (SKP) dan Penggunaan Aplikasi E-Kinerja di lingkungan Pemerintah Kabupaten Pegunungan Arfak pada hari Kamis, 19 Juni 2025, bertempat di Hotel Fujita, Manokwari.</p><p>Kegiatan ini dibuka secara resmi oleh Sekretaris Daerah Kabupaten Pegunungan Arfak, Ever Dowansiba, S.IP., M.Si, dengan simbolisasi pembukaan melalui pemukulan Tifa. Hadir pula dalam kegiatan ini, Kepala BKPSDM Kabupaten Pegunungan Arfak, Edward Dowansiba, S.Kom., M.Ag, serta jajaran pejabat struktural dan fungsional terkait. Kegiatan ini rencananya akan dilaksanakan sebanyak 3 angkatan mulai tanggal 19 s.d 28 Juni 2025.</p><p>Dalam arahannya, Kepala Kantor Regional XIV BKN menyampaikan beberapa poin strategis terkait arah kebijakan manajemen kinerja ASN yang sejalan dengan visi reformasi birokrasi nasional. Beliau menekankan bahwa:</p><ul><li>Asta Cita Presiden RI mengamanatkan transformasi birokrasi, termasuk penerapan manajemen talenta ASN melalui sistem merit. Sistem ini menempatkan kompetensi dan kinerja sebagai pilar utama dalam pengelolaan ASN. Oleh karena itu, pencapaian dan pelaporan kinerja harus menjadi perhatian utama di setiap instansi pemerintah.</li><li>Pengelolaan kinerja ASN saat ini telah beralih dari metode konvensional menjadi sistem berbasis digital melalui aplikasi E-Kinerja, yang tidak hanya meningkatkan efisiensi tetapi juga transparansi dan akuntabilitas dalam pelaporan kinerja.</li></ul><p>&nbsp;&nbsp;</p><p>Sementara itu, dalam sambutannya, Sekretaris Daerah Kabupaten Pegunungan Arfak menyampaikan apresiasi atas pelaksanaan kegiatan ini. Ia berharap kegiatan bimbingan teknis ini dapat menjadi momentum penting bagi seluruh perangkat daerah untuk meningkatkan kualitas pelayanan publik melalui sistem pelaporan kinerja yang terukur dan terintegrasi.</p><p>Kegiatan ini merupakan bagian dari upaya bersama antara Pemerintah Kabupaten Pegunungan Arfak dan Kantor Regional XIV BKN dalam mendukung reformasi birokrasi dan pembangunan sumber daya manusia aparatur yang profesional dan berintegritas.&nbsp;</p>', 'post-thumbnail/01JZHNPYQDJEFY4YP98ZBY3GMM.png', 1, 0, '2025-07-07 05:28:32', '2025-07-07 05:28:32'),
(21, 1, 'Penyerahan SK CPNS dan PPPK Tahap I Formasi Tahun  2024  Pemerintah Kabupaten Manokwari Selatan', 'penyerahan-sk-cpns-dan-pppk-tahap-i-formasi-tahun-2024-pemerintah-kabupaten-manokwari-selatan', '<p>&nbsp;Ransiki, Selasa (24/06/2025) – Kepala Kantor Regional XIV Badan Kepegawaian Negara Manokwari, Nur Hasan, S.Sos.,M.Adm.SDA, menghadiri Penyerahan Surat Keputusan Calon Pegawai Negeri Sipil (CPNS) dan Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Tahap I Formasi Tahun 2024 di lingkungan Pemerintah Kabupaten Manokwari Selatan.&nbsp;</p><p>Penyerahan SK CPNS dan PPPK Tahap I Tahun 2024 ini diserahkan langsung oleh Bupati Manokwari Selatan, Bernard Mandacan, S.IP, kepada 193 orang CPNS dan 495 orang PPPK.</p><p>Penyerahan SK tersebut turut dihadiri oleh Wakil Bupati Manokwari Selatan Mesak Inyomusi, SE., M.Si, Sekretaris Daerah Kabupaten Manokwari Selatan, Adolof Kawei, S.H, serta Kepala BKPSDM Kabupaten Manokwari Selatan, Leo Leonard Sayori, S.STP.&nbsp;</p><p>&nbsp;Kepala Kantor Regional XIV BKN berharap agar para CPNS dan PPPK yang baru saja menerima SK dapat menjalankan tugas sebagai ASN sebaik-baiknya dengan menjaga integritas, profesionalitas dan semangat melayani bagi masyarakat.&nbsp;</p>', 'post-thumbnail/01JZHNSTSQTQK00D48QHWSVGPY.png', 1, 0, '2025-07-07 05:30:07', '2025-07-07 05:30:07'),
(22, 1, 'Pengambilan Sumpah Janji PPPK Tahap I dan Penyerahan SK CPNS Formasi Tahun  2024 Pemerintah Kabupaten Pegunungan Arfak', 'pengambilan-sumpah-janji-pppk-tahap-i-dan-penyerahan-sk-cpns-formasi-tahun-2024-pemerintah-kabupaten-pegunungan-arfak', '<p>&nbsp;</p><p>Ullong, Pegunungan Arfak, Senin (30/06/2025) – Kepala Kantor Regional XIV BKN Manokwari yang diwakili Kepala Bidang Pengembangan dan Supervisi Kepegawaian dan Kepala Bagian Tata Usaha Kantor Regional XIV BKN Manokwari menghadiri acara Pengambilan Sumpah Janji Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Tahap I dan Penyerahan Surat Keputusan Pengangkatan Calon Pegawai Negeri Sipil (CPNS) Formasi Tahun 2024 di lingkungan Pemerintah Kabupaten Pegunungan Arfak.</p><p>Pengambilan Sumpah Janji Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Tahap I Jabatan Fungsional Formasi Tahun 2024 secara langsung oleh Bupati Pegunungan Arfak, Dominggus Saiba, S.Pd.K.,M.Si.</p><p>Selanjutnya Surat Keputusan Pengangkatan CPNS Formasi Tahun 2024 sebanyak 496 dan Surat Keputusan Pengangkatan PPPK Tahap I Formasi Tahun 2024 sebanyak 162 diserahkan secara simbolis oleh Bupati Pegunungan Arfak, Wakil Bupati Pegunungan Arfak, Sekretaris Daerah Pegunungan Arfak, Kepala BKPSDM Pegunungan Arfak, Kepala Bidang Pengembangan dan Supervisi Kepegawaian Kantor Regional XIV BKN Manokwari dan Kepala Bagian Tata Usaha Kantor Regional XIV BKN Manokwari.&nbsp;</p>', 'post-thumbnail/01JZHNWKM3F1GH0TE9GEHPYB07.png', 1, 0, '2025-07-07 05:31:37', '2025-07-07 05:31:37'),
(23, 1, 'Webinar Pendampingan Disparitas Data: Upaya Konkret Tingkatkan Kualitas Data ASN', 'webinar-pendampingan-disparitas-data-upaya-konkret-tingkatkan-kualitas-data-asn', '<p>Manokwari, Jumat, 18 Juli 2025 - &nbsp;</p><p>Kantor Regional XIV Badan Kepegawaian Negara (BKN) menyelenggarakan webinar series dengan tema \"Pendampingan Penyelesaian Disparitas Data Dalam Rangka Peningkatan Kualitas Data ASN\". Kegiatan ini bertujuan untuk memberikan pemahaman teknis serta pendampingan kepada instansi pemerintah maupun ASN secara umum dalam menyelesaikan perbedaan atau ketidaksesuaian data Aparatur Sipil Negara (ASN).&nbsp;</p><p>Melalui kegiatan ini, Kepala Kantor Regional XIV BKN, Nur Hasan, S.Sos.,M.Adm.SDA berharap seluruh instansi dapat lebih proaktif dalam memperbaiki dan menyelaraskan data kepegawaian, demi mendukung terwujudnya birokrasi yang profesional dan berbasis digital.&nbsp;</p>', 'post-thumbnail/01K0R8PFNMJ2G308R40V0V3JM6.png', 1, 1, '2025-07-22 05:11:28', '2025-07-22 05:11:28'),
(24, 1, 'Pemerintah Kabupaten Pegunungan Arfak dan Kantor Regional XIV BKN Jalin Sinergi Digitalisasi Kepegawaian', 'pemerintah-kabupaten-pegunungan-arfak-dan-kantor-regional-xiv-bkn-jalin-sinergi-digitalisasi-kepegawaian', '<p>Pegaf, Senin, 21 Juli 2025 - &nbsp;</p><p>Kantor Regional XIV Badan Kepegawaian Negara (BKN) menyelenggarakan webinar series dengan tema \"Pendampingan Penyelesaian Disparitas Data Dalam Rangka Peningkatan Kualitas Data ASN\". Kegiatan ini bertujuan untuk memberikan pemahaman teknis serta pendampingan kepada instansi pemerintah maupun ASN secara umum dalam menyelesaikan perbedaan atau ketidaksesuaian data Aparatur Sipil Negara (ASN).&nbsp;</p><p>Melalui kegiatan ini, Kepala Kantor Regional XIV BKN, Nur Hasan, S.Sos.,M.Adm.SDA berharap seluruh instansi dapat lebih proaktif dalam memperbaiki dan menyelaraskan data kepegawaian, demi mendukung terwujudnya birokrasi yang profesional dan berbasis digital.&nbsp;</p>', 'post-thumbnail/01K0R8RKJJVRJR5Y1G5GRS3JPV.png', 1, 1, '2025-07-22 05:12:38', '2025-07-22 05:12:38'),
(25, 1, 'Kantor Regional XIV BKN Mengadakan Sosialisasi SE Kepala BKN Nomor 7 Tahun 2024 di Wilayah Kerja Kantor Regional XIV BKN', 'kantor-regional-xiv-bkn-mengadakan-sosialisasi-se-kepala-bkn-nomor-7-tahun-2024-di-wilayah-kerja-kantor-regional-xiv-bkn', '<p>&nbsp;</p><p>Kantor Regional XIV BKN menyelenggarakan Sosialisasi SE Kepala BKN Nomor 7 Tahun 2024 tentang Pemanfaatan Aplikasi Integrated Mutasi dalam Rangka Pengangkatan, Pemindahan, dan Pemberhentian ASN, dengan dihadiri oleh Kepala BKD/BKPSDM/BKDD/BKPP, pejabat/pegawai pengelola kepegawaian dan PIC Aplikasi I-Mut di wilayah kerja Kantor Regional XIV BKN.</p><p>Kepala Kantor Regional XIV BKN, Nur Hasan, S.Sos., M.Adm.SDA, menyampaikan kegiatan ini bertujuan agar seluruh instansi pemerintah di wilayah kerja Kantor Regional XIV BKN dalam hal mengimplementasikan manajemen ASN sesuai dengan NSPK Manajamen ASN.&nbsp;</p><p>Dalam sosialisasi tersebut menghadirkan narasumber dari Kedeputian Pengawasan dan Pengendalian Manajemen Aparatur Sipil Negara BKN dan Kedeputian Bidang Sistem Informasi dan Digitalisasi Manajemen Arapatur Sipil Negara BKN, yaitu Arfiani Haryanti, ST, M.T.I., Direktur Pengawasan dan Pengendalian IV BKN, Santri Panca Nurul Alami, SH, Auditor Manajemen ASN Ahli Madya, dan Yullia Widya Cahyadi, ST, Pranata Komputer Ahli Pertama.&nbsp; (na)</p>', 'post-thumbnail/01K15RA54KSSA7SEC2FH1Z4NYY.png', 1, 1, '2025-07-27 10:54:29', '2025-07-27 10:54:29'),
(26, 1, 'Kantor Regional XIV BKN Fasilitasi Pelaksanaan Ujian Dinas Tingkat I, Tingkat II dan Ujian Penyesuian Kenaikan Pangkat di Lingkungan BPK RI, BPS dan Kejaksaan RI', 'kantor-regional-xiv-bkn-fasilitasi-pelaksanaan-ujian-dinas-tingkat-i-tingkat-ii-dan-ujian-penyesuian-kenaikan-pangkat-di-lingkungan-bpk-ri-bps-dan-kejaksaan-ri', '<p>&nbsp;</p><p>Senin, 29 Juli 2025 - Kantor Regional XIV Badan Kepegawaian Negara (BKN) menyelenggarakan fasilitasi pelaksanaan Ujian Dinas (UD) Tingkat I dan II serta Ujian Penyesuaian Kenaikan Pangkat (UPKP) bagi aparatur di lingkungan Badan Pemeriksa Keuangan Republik Indonesia (BPK RI), Badan Pusat Statistik (BPS), dan Kejaksaan Republik Indonesia. Ujian tersebut dilaksanakan menggunakan metode Computer Assisted Test (CAT) BKN.</p><p>Kegiatan ini diikuti oleh sebanyak 7 (tujuh) peserta, yang terdiri atas 2 (dua) peserta dari BPK RI, 4 (empat) peserta dari BPS, dan 1 (satu) peserta dari Kejaksaan RI.&nbsp;</p>', 'post-thumbnail/01K1QHF3WY70CP73RAJAEZ3FS4.png', 1, 0, '2025-08-03 08:41:11', '2025-08-03 08:41:11'),
(27, 1, 'Kantor Regional XIV BKN Fasilitasi Pelaksanaan Ujian Kompetensi Teknis di Lingkungan Kementerian Hak Asasi Manusia', 'kantor-regional-xiv-bkn-fasilitasi-pelaksanaan-ujian-kompetensi-teknis-di-lingkungan-kementerian-hak-asasi-manusia', '<p>Jumat, 01 Agustus 2025 -&nbsp; Kantor Regional XIV Badan Kepegawaian Negara (BKN) menyelenggarakan fasilitasi pelaksanaan Ujian Kompetensi Teknis pada Bidang Hak Asasi Manusia (HAM) di lingkungan Kementerian HAM yang dilaksanakan secara serentak pada 1 Agustus 2025 di 32 titik lokasi ujian BKN.</p><p>Ujian tersebut dilaksanakan menggunakan metode Computer Assisted Test (CAT) BKN dengan diikuti oleh 18 (delapan belas) peserta dari Kantor Wilayah Kementerian HAM Papua Barat.&nbsp;</p>', 'post-thumbnail/01K1QJ1MEZ11GETF3S12MJ4YGJ.png', 1, 0, '2025-08-03 08:51:18', '2025-08-03 08:51:18');
INSERT INTO `question_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'CAT', 'cat', '2025-01-04 20:02:48', '2025-01-04 20:02:48'),
(2, 'CAT', 'cat', '2025-02-11 03:35:59', '2025-02-11 03:35:59');

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2);
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-01-04 20:02:46', '2025-01-04 20:02:46'),
(2, 'penulis', 'web', '2025-01-04 20:02:46', '2025-01-04 20:02:46');

INSERT INTO `users` (`id`, `departement_id`, `name`, `email`, `nip`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 1, 'Sulistyo Cahyo Gumilang', 'sulistyo.gumilang@bkn.go.id', '199806162022031001', NULL, '$2y$12$wpYHoCllRZRVmECtOM.K0.x7cGCkVwRiVeEpJjo25OWcc/7NpZv2G', NULL, '2025-02-18 00:38:55', '2025-02-18 00:38:55'),
(6, 3, 'Nusaybah Amatullah', 'nusaybahamatullah94@gmail.com', '199410312024212014', NULL, '$2y$12$ilg.Eh3o.hz6hAwAqeUE1ON2Z5eZvDStRgtSgAZT9URtxgMs3wvqS', 'eVmVft9XTLYCNkKkpKAsQHMypPDKcUDCTyGz3naBr9bmcCu4eg6qAaQZxvGC', '2025-02-18 05:33:34', '2025-02-18 05:33:34'),
(7, 1, 'Cahyo', 'cgumilang48@gmail.com', '199806162022031006', NULL, '$2y$12$ZDZLdjQLxj9v43nPIwp6oun3c6CN.tkCmpI/y.Gw8/HQPMJy0cKLe', NULL, '2025-08-26 00:22:03', '2025-08-26 00:22:03');


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;