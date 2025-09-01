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
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `answers`;
CREATE TABLE `answers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question_id` bigint unsigned NOT NULL,
  `jawaban` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `answers_question_id_foreign` (`question_id`),
  CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `category_letters`;
CREATE TABLE `category_letters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_category_id_foreign` (`category_id`),
  CONSTRAINT `documents_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement_id` bigint unsigned NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employees_departement_id_foreign` (`departement_id`),
  CONSTRAINT `employees_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
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

DROP TABLE IF EXISTS `letter_ins`;
CREATE TABLE `letter_ins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_letter_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `departement_id` bigint unsigned NOT NULL,
  `reference_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_letter` date NOT NULL,
  `date_in` date NOT NULL,
  `origin_letter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `properties_letter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `ministries`;
CREATE TABLE `ministries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `personal_access_tokens`;
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
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_headline` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_category_id_foreign` (`category_id`),
  CONSTRAINT `posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `question_categories`;
CREATE TABLE `question_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `city_id` bigint unsigned NOT NULL,
  `ministry_id` bigint unsigned NOT NULL,
  `question_category_id` bigint unsigned NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '000000',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Belum Dijawab','Sudah Dijawab') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Dijawab',
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `departement_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_departement_id_foreign` (`departement_id`),
  CONSTRAINT `users_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



INSERT INTO `banners` (`id`, `name`, `desc`, `file`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Kantor', 'kantor', 'banners/01K2EDZK9XKV4PW87AV3VSEDXK.png', 1, '2025-08-12 06:02:49', '2025-08-12 06:02:49'),
(2, 'Layanan', 'layanan', 'banners/01K2EE8ESXHM28NFY5CF7907TY.png', 1, '2025-08-12 06:07:39', '2025-08-12 06:07:39');
INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Berita Kepegawaian', 'berita-kepegawaian', '2025-08-12 05:57:54', '2025-08-12 05:57:54'),
(2, 'Artikel Kepegawaian', 'artikel-kepegawaian', '2025-08-24 03:09:07', '2025-08-24 03:09:07');

INSERT INTO `cities` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Kabupaten Sorong', 'kabupaten-sorong', '2025-08-12 03:11:07', '2025-08-12 03:11:07');

INSERT INTO `departements` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Bidang Informasi Kepegawaian', 'bidang-informasi-kepegawaian', '2025-08-12 03:11:07', '2025-08-12 03:11:07');





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
(1, 'KEMENKUMHAM', 'kemenkumham', '2025-08-12 03:11:07', '2025-08-12 03:11:07');

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'tambah-tulisan', 'web', '2025-08-12 03:10:38', '2025-08-12 03:10:38'),
(2, 'edit-tulisan', 'web', '2025-08-12 03:10:38', '2025-08-12 03:10:38'),
(3, 'lihat-tulisan', 'web', '2025-08-12 03:10:38', '2025-08-12 03:10:38'),
(4, 'hapus-tulisan', 'web', '2025-08-12 03:10:38', '2025-08-12 03:10:38'),
(5, 'tambah-user', 'web', '2025-08-12 03:10:38', '2025-08-12 03:10:38'),
(6, 'edit-user', 'web', '2025-08-12 03:10:38', '2025-08-12 03:10:38'),
(7, 'lihat-user', 'web', '2025-08-12 03:10:38', '2025-08-12 03:10:38'),
(8, 'hapus-user', 'web', '2025-08-12 03:10:38', '2025-08-12 03:10:38');


INSERT INTO `posts` (`id`, `category_id`, `title`, `slug`, `content`, `thumbnail`, `status`, `is_headline`, `created_at`, `updated_at`) VALUES
(2, 1, 'Pemerintah Kabupaten Pegunungan Arfak dan Kantor Regional XIV BKN Jalin Sinergi Digitalisasi Kepegawaian', 'pemerintah-kabupaten-pegunungan-arfak-dan-kantor-regional-xiv-bkn-jalin-sinergi-digitalisasi-kepegawaian', '<p>Pegaf, Senin, 21 Juli 2025 - &nbsp;</p><p>Kantor Regional XIV Badan Kepegawaian Negara (BKN) menyelenggarakan webinar series dengan tema \"Pendampingan Penyelesaian Disparitas Data Dalam Rangka Peningkatan Kualitas Data ASN\". Kegiatan ini bertujuan untuk memberikan pemahaman teknis serta pendampingan kepada instansi pemerintah maupun ASN secara umum dalam menyelesaikan perbedaan atau ketidaksesuaian data Aparatur Sipil Negara (ASN).&nbsp;</p><p>Melalui kegiatan ini, Kepala Kantor Regional XIV BKN, Nur Hasan, S.Sos.,M.Adm.SDA berharap seluruh instansi dapat lebih proaktif dalam memperbaiki dan menyelaraskan data kepegawaian, demi mendukung terwujudnya birokrasi yang profesional dan berbasis digital.&nbsp;</p>', 'post-thumbnail/01K3BN8GDWBXX442AYG94A4A4A.png', 1, 0, '2025-08-23 14:28:00', '2025-08-24 04:37:34'),
(3, 1, 'Kantor Regional XIV BKN Fasilitasi Pelaksanaan Ujian Kompetensi Teknis di Lingkungan Kementerian Hak Asasi Manusia', 'kantor-regional-xiv-bkn-fasilitasi-pelaksanaan-ujian-kompetensi-teknis-di-lingkungan-kementerian-hak-asasi-manusia', '<p>Jumat, 01 Agustus 2025 -&nbsp; Kantor Regional XIV Badan Kepegawaian Negara (BKN) menyelenggarakan fasilitasi pelaksanaan Ujian Kompetensi Teknis pada Bidang Hak Asasi Manusia (HAM) di lingkungan Kementerian HAM yang dilaksanakan secara serentak pada 1 Agustus 2025 di 32 titik lokasi ujian BKN.</p><p>Ujian tersebut dilaksanakan menggunakan metode Computer Assisted Test (CAT) BKN dengan diikuti oleh 18 (delapan belas) peserta dari Kantor Wilayah Kementerian HAM Papua Barat.&nbsp;</p>', 'post-thumbnail/01K3D01ACS2PJ2MB6XD33F6YFJ.png', 1, 0, '2025-08-24 02:55:33', '2025-08-24 02:55:33'),
(4, 1, 'Kantor Regional XIV BKN Fasilitasi Pelaksanaan Ujian Dinas Tingkat I, Tingkat II dan Ujian Penyesuian Kenaikan Pangkat di Lingkungan BPK RI, BPS dan Kejaksaan RI', 'kantor-regional-xiv-bkn-fasilitasi-pelaksanaan-ujian-dinas-tingkat-i-tingkat-ii-dan-ujian-penyesuian-kenaikan-pangkat-di-lingkungan-bpk-ri-bps-dan-kejaksaan-ri', '<p>Senin, 29 Juli 2025 - Kantor Regional XIV Badan Kepegawaian Negara (BKN) menyelenggarakan fasilitasi pelaksanaan Ujian Dinas (UD) Tingkat I dan II serta Ujian Penyesuaian Kenaikan Pangkat (UPKP) bagi aparatur di lingkungan Badan Pemeriksa Keuangan Republik Indonesia (BPK RI), Badan Pusat Statistik (BPS), dan Kejaksaan Republik Indonesia. Ujian tersebut dilaksanakan menggunakan metode Computer Assisted Test (CAT) BKN.</p><p>Kegiatan ini diikuti oleh sebanyak 7 (tujuh) peserta, yang terdiri atas 2 (dua) peserta dari BPK RI, 4 (empat) peserta dari BPS, dan 1 (satu) peserta dari Kejaksaan RI.&nbsp;</p>', 'post-thumbnail/01K3D03XZFB5D5ZBQY01T0ZA3V.png', 1, 0, '2025-08-24 02:56:58', '2025-08-24 02:56:58'),
(5, 1, 'Kantor Regional XIV BKN Mengadakan Sosialisasi SE Kepala BKN Nomor 7 Tahun 2024 di Wilayah Kerja Kantor Regional XIV BKN', 'kantor-regional-xiv-bkn-mengadakan-sosialisasi-se-kepala-bkn-nomor-7-tahun-2024-di-wilayah-kerja-kantor-regional-xiv-bkn', '<p>Kantor Regional XIV BKN menyelenggarakan Sosialisasi SE Kepala BKN Nomor 7 Tahun 2024 tentang Pemanfaatan Aplikasi Integrated Mutasi dalam Rangka Pengangkatan, Pemindahan, dan Pemberhentian ASN, dengan dihadiri oleh Kepala BKD/BKPSDM/BKDD/BKPP, pejabat/pegawai pengelola kepegawaian dan PIC Aplikasi I-Mut di wilayah kerja Kantor Regional XIV BKN.</p><p>Kepala Kantor Regional XIV BKN, Nur Hasan, S.Sos., M.Adm.SDA, menyampaikan kegiatan ini bertujuan agar seluruh instansi pemerintah di wilayah kerja Kantor Regional XIV BKN dalam hal mengimplementasikan manajemen ASN sesuai dengan NSPK Manajamen ASN.&nbsp;</p><p>Dalam sosialisasi tersebut menghadirkan narasumber dari Kedeputian Pengawasan dan Pengendalian Manajemen Aparatur Sipil Negara BKN dan Kedeputian Bidang Sistem Informasi dan Digitalisasi Manajemen Arapatur Sipil Negara BKN, yaitu Arfiani Haryanti, ST, M.T.I., Direktur Pengawasan dan Pengendalian IV BKN, Santri Panca Nurul Alami, SH, Auditor Manajemen ASN Ahli Madya, dan Yullia Widya Cahyadi, ST, Pranata Komputer Ahli Pertama.&nbsp; (na)</p>', 'post-thumbnail/01K3D06S5ZC85XMA6J6D1JTY3B.png', 1, 1, '2025-08-24 02:58:32', '2025-08-24 04:38:05'),
(6, 2, 'Membangun Sistem Kepegawaian yang Profesional dan Adaptif di Era Digital', 'membangun-sistem-kepegawaian-yang-profesional-dan-adaptif-di-era-digital', '<p><strong>Pendahuluan</strong></p><p>&nbsp;<br>Kepegawaian merupakan aspek fundamental dalam manajemen organisasi, khususnya dalam sektor pemerintahan. Kualitas sumber daya manusia (SDM) yang dikelola dengan baik akan berpengaruh besar terhadap kinerja organisasi secara keseluruhan. Di era digital saat ini, sistem kepegawaian tidak lagi hanya berfokus pada administrasi semata, tetapi juga pada pengembangan kompetensi, integritas, dan kemampuan adaptasi terhadap perubahan teknologi.<br>&nbsp;</p><h3><strong>Transformasi Digital dalam Pelayanan Kepegawaian</strong></h3><p>&nbsp;<br>Dengan perkembangan teknologi informasi, pelayanan kepegawaian kini mulai bergeser ke arah digitalisasi. Proses-proses seperti rekrutmen, penilaian kinerja, kenaikan pangkat, hingga pensiun mulai dilakukan secara elektronik. Sistem informasi kepegawaian yang terintegrasi (seperti <em>e-office</em>, <em>e-performance</em>, dan <em>e-personnel</em>) memungkinkan pegawai untuk mengakses informasi kepegawaian dengan lebih cepat, transparan, dan akuntabel.<br>&nbsp;<br>Contoh implementasi nyata dari digitalisasi kepegawaian dapat dilihat dalam layanan kepegawaian berbasis aplikasi yang disediakan oleh instansi pemerintah, seperti Badan Kepegawaian Negara (BKN) melalui aplikasi MySAPK dan sistem CAT dalam seleksi ASN.<br>&nbsp;</p><h3><strong>Pengembangan Kompetensi dan Karier Pegawai</strong></h3><p>&nbsp;<br>Pegawai tidak hanya dituntut untuk memiliki kemampuan dasar administratif, tetapi juga dituntut untuk terus mengembangkan kompetensi sesuai dengan perkembangan zaman. Oleh karena itu, pelatihan dan pengembangan SDM menjadi prioritas utama dalam sistem kepegawaian modern.<br>&nbsp;<br>Program pengembangan karier seperti pelatihan teknis, diklat kepemimpinan, dan pembelajaran berbasis digital (<em>e-learning</em>) sangat diperlukan untuk meningkatkan kapasitas aparatur sipil negara (ASN). Dengan demikian, pegawai dapat berkontribusi secara optimal dalam pelayanan publik yang profesional dan berintegritas.<br>&nbsp;</p><h3><strong>Etika dan Nilai Dasar ASN</strong></h3><p>&nbsp;<br>Selain kompetensi teknis, ASN juga harus menjunjung tinggi etika profesi dan nilai-nilai dasar seperti yang tercantum dalam core values ASN yaitu <strong>BerAKHLAK</strong> (Berorientasi Pelayanan, Akuntabel, Kompeten, Harmonis, Loyal, Adaptif, dan Kolaboratif). Nilai-nilai ini menjadi pedoman moral dan perilaku dalam bekerja, baik secara individu maupun sebagai bagian dari tim.<br>&nbsp;</p><h3><strong>Kesimpulan</strong></h3><p>&nbsp;<br>Kepegawaian bukan hanya urusan administratif, tetapi juga strategi penting dalam pembangunan kualitas birokrasi yang tangguh, adaptif, dan responsif terhadap kebutuhan masyarakat. Dengan memanfaatkan teknologi, meningkatkan kompetensi, dan menjunjung tinggi nilai-nilai ASN, kita dapat mewujudkan aparatur negara yang profesional dan melayani dengan sepenuh hati.</p>', 'post-thumbnail/01K3D0WDFA5G34XMTVN3R6JGKY.png', 1, 0, '2025-08-24 03:10:21', '2025-08-24 03:10:21'),
(7, 2, 'Peran dan Tantangan Kepegawaian dalam Administrasi Publik', 'peran-dan-tantangan-kepegawaian-dalam-administrasi-publik', '<p>Kepegawaian merupakan elemen kunci dalam administrasi publik yang berperan dalam memastikan kelancaran fungsi pemerintahan dan pelayanan masyarakat. Sistem kepegawaian yang efektif dapat meningkatkan efisiensi, transparansi, dan akuntabilitas birokrasi.</p><h3><strong>Peran Kepegawaian dalam Administrasi Publik</strong></h3><ol><li><strong>Pelayanan Publik yang Efisien</strong><ul><li>Pegawai negeri berperan dalam menyelenggarakan layanan publik yang berkualitas.</li><li>Digitalisasi administrasi kepegawaian mempercepat proses birokrasi.</li></ul></li><li><strong>Menjaga Stabilitas Pemerintahan</strong><ul><li>Pegawai pemerintah bekerja untuk menjaga kesinambungan kebijakan dan program nasional.</li><li>Profesionalisme pegawai mendukung implementasi kebijakan yang efektif.</li></ul></li><li><strong>Peningkatan Kualitas Sumber Daya Manusia (SDM)</strong><ul><li>Pelatihan dan pengembangan kompetensi membantu pegawai menyesuaikan diri dengan perubahan zaman.</li><li>Reformasi birokrasi menekankan pentingnya peningkatan kapasitas pegawai.</li></ul></li></ol><h3><strong>Tantangan dalam Manajemen Kepegawaian</strong></h3><ol><li><strong>Beban Administratif yang Tinggi</strong><ul><li>Proses administratif yang kompleks sering menghambat efektivitas kerja.</li><li>Perlu adanya penyederhanaan birokrasi melalui inovasi digital.</li></ul></li><li><strong>Kurangnya SDM yang Berkualitas</strong><ul><li>Tantangan dalam merekrut dan mempertahankan pegawai yang kompeten.</li><li>Diperlukan peningkatan sistem seleksi dan pengembangan karier.</li></ul></li><li><strong>Transparansi dan Akuntabilitas</strong><ul><li>Korupsi dan nepotisme masih menjadi kendala dalam sistem kepegawaian.</li><li>Penguatan sistem meritokrasi untuk meningkatkan kepercayaan publik.</li></ul></li></ol><h3><strong>Reformasi Kepegawaian</strong></h3><ol><li><strong>Digitalisasi Administrasi</strong><ul><li>Penggunaan sistem informasi kepegawaian untuk meningkatkan efisiensi.</li><li>Implementasi e-government dalam proses kepegawaian.</li></ul></li><li><strong>Peningkatan Kesejahteraan Pegawai</strong><ul><li>Penyediaan tunjangan dan insentif yang adil bagi pegawai.</li><li>Pengembangan lingkungan kerja yang kondusif dan produktif.</li></ul></li><li><strong>Penerapan Sistem Merit</strong><ul><li>Rekrutmen dan promosi berbasis kompetensi dan kinerja.</li><li>Evaluasi kinerja pegawai yang objektif dan berbasis data.</li></ul></li></ol><h3><strong>Kesimpulan</strong></h3><p>Manajemen kepegawaian yang baik sangat penting untuk efektivitas administrasi publik. Dengan mengatasi tantangan yang ada melalui reformasi birokrasi, digitalisasi, dan peningkatan kesejahteraan pegawai, sistem kepegawaian dapat lebih adaptif dan responsif terhadap perubahan zaman. Transparansi dan profesionalisme harus terus dijaga guna meningkatkan kepercayaan masyarakat terhadap pemerintahan.</p>', 'post-thumbnail/01K3D0ZYV95E7ZGD6YQPF62D01.jpg', 1, 0, '2025-08-24 03:12:17', '2025-08-24 03:12:17'),
(8, 2, 'Mengenal Sistem Kepegawaian di Indonesia: Regulasi, Hak, dan Kewajiban', 'mengenal-sistem-kepegawaian-di-indonesia-regulasi-hak-dan-kewajiban', '<h3><strong>Pendahuluan</strong></h3><p>Kepegawaian merupakan aspek penting dalam pengelolaan sumber daya manusia di berbagai sektor, baik pemerintahan maupun swasta. Di Indonesia, sistem kepegawaian terutama diatur dalam peraturan perundang-undangan yang memastikan kesejahteraan, hak, serta kewajiban pegawai dalam menjalankan tugasnya.</p><h3><strong>Regulasi Kepegawaian di Indonesia</strong></h3><p>Dalam lingkup pemerintahan, regulasi utama yang mengatur kepegawaian adalah <strong>Undang-Undang Nomor 20 Tahun 2023 tentang Aparatur Sipil Negara (ASN)</strong>. Undang-undang ini mengatur sistem pengelolaan pegawai negeri, yang terbagi menjadi dua kategori utama:</p><ol><li><strong>Pegawai Negeri Sipil (PNS)</strong> – Pegawai tetap yang memperoleh gaji dan tunjangan dari APBN atau APBD.</li><li><strong>Pegawai Pemerintah dengan Perjanjian Kerja (PPPK)</strong> – Pegawai yang diangkat berdasarkan kontrak untuk jangka waktu tertentu.</li></ol><p>Selain itu, regulasi terkait juga mencakup Peraturan Pemerintah (PP), Peraturan Menteri, serta berbagai kebijakan teknis yang diterapkan di masing-masing instansi.</p><h3><strong>Hak dan Kewajiban Pegawai</strong></h3><p>Pegawai di Indonesia memiliki sejumlah hak yang dijamin oleh peraturan, antara lain:</p><ul><li>Gaji dan tunjangan</li><li>Cuti tahunan dan cuti khusus</li><li>Jaminan pensiun dan asuransi kesehatan</li><li>Pengembangan kompetensi dan pelatihan</li><li>Perlindungan hukum dalam pelaksanaan tugas</li></ul><p>Namun, setiap pegawai juga memiliki kewajiban yang harus dipenuhi, seperti:</p><ul><li>Mematuhi peraturan disiplin pegawai</li><li>Menjaga integritas dan profesionalisme dalam bekerja</li><li>Melaksanakan tugas dengan penuh tanggung jawab</li><li>Menghindari konflik kepentingan</li></ul><h3><strong>Sistem Pengelolaan Kepegawaian</strong></h3><p>Pemerintah telah mengembangkan berbagai sistem informasi kepegawaian untuk mempermudah pengelolaan data pegawai. Salah satu sistem utama adalah <strong>Sistem Informasi Kepegawaian Nasional (SIASN)</strong> yang terintegrasi dengan Badan Kepegawaian Negara (BKN). Melalui sistem ini, proses administrasi seperti pengangkatan, mutasi, kenaikan pangkat, dan pensiun dapat dilakukan dengan lebih efisien.</p><h3><strong>Tantangan dalam Kepegawaian</strong></h3><p>Beberapa tantangan yang dihadapi dalam sistem kepegawaian di Indonesia antara lain:</p><ol><li><strong>Digitalisasi dan Adaptasi Teknologi</strong> – Proses transisi ke sistem digital masih mengalami kendala di beberapa daerah.</li><li><strong>Reformasi Birokrasi</strong> – Perlu adanya penyederhanaan regulasi dan prosedur untuk meningkatkan efisiensi kerja.</li><li><strong>Peningkatan Kompetensi</strong> – Pegawai perlu terus mengikuti pelatihan dan sertifikasi agar dapat menyesuaikan diri dengan perkembangan zaman.</li></ol><h3><strong>Kesimpulan</strong></h3><p>Kepegawaian di Indonesia terus mengalami perkembangan seiring dengan perubahan regulasi dan kebutuhan zaman. Dengan adanya sistem yang lebih transparan dan efisien, diharapkan pegawai, khususnya ASN, dapat bekerja lebih profesional dan memberikan pelayanan terbaik kepada masyarakat. Untuk itu, penting bagi setiap pegawai memahami hak dan kewajibannya serta terus beradaptasi dengan perkembangan teknologi dalam dunia kerja.</p><p><br></p>', 'post-thumbnail/01K3D1C5TGC9S0QZGFS7J7Q9Y9.png', 1, 0, '2025-08-24 03:18:57', '2025-08-24 03:18:57'),
(9, 2, 'Mengenal Merit Sistem dan Refleksi Implementasinya', 'mengenal-merit-sistem-dan-refleksi-implementasinya', '<p>Merit sistem merupakan salah satu sistem dalam manajemen sumber daya manusia yang menjadikan kualifikasi, kompetensi dan kinerja sebagai pertimbangan utama dalam proses perencanaan, perekrutan, penggajian, pengembangan, promosi, retensi, disiplin dan pensiun pegawai. Mulanya, merit sistem banyak diterapkan di organisasi sektor swasta, yang kemudian belakangan mulai berkembang dan diadaptasi juga oleh sektor publik.&nbsp;</p><p>Di Indonesia, merit sistem secara legal formal diberlakukan pada tahun 2014 melalui Undang-Undang No 5 tahun 2014 tentang Aparatur Sipil Negara (ASN). Dalam UU tersebut dinyatakan bahwa kebijakan manajemen ASN berdasarkan pada kualifikasi, kompetensi dan kinerja yang diberlakukan secara adil dan wajar tanpa membedakan latar belakang politik, ras, warna kulit, agama, asal usul, jenis kelamin, status pernikahan, umur, atau kondisi kecacatan (tanpa diskriminasi). Sistem ini seolah menjadi kritik atas suburnya praktek nepotisme, dan primordialisme di dunia kerja. Oleh karenanya sistem merit menjadi salah satu hasil dari agenda reformasi birokrasi yang dicanangkan Presiden untuk menciptakan birokrasi netral dan mampu melayani kebutuhan publik serta bebas dari KKN.&nbsp;</p><p>Pemberlakukan merit sistem dalam birokrasi Indonesia bertujuan untuk menghasilkan ASN yang profesional dan berintegritas dengan menempatkan mereka pada jabatan-jabatan birokrasi pemerintah sesuai kompetensinya; pemberian kompensasi yang adil dan layak; mengembangkan kemampuan ASN melalui bimbingan dan diklat; dan melindungi karier ASN dari politisasi dan kebijakan yang bertentangan dengan prinsip merit.&nbsp;</p><p><strong>Implementasi&nbsp;</strong></p><p>Implementasi merit sistem dapat diwujudkan pada manajemen sejak perencanaan kebutuhan SDM hingga pensiun nantinya. Dalam kondisi ideal, penerapan merit sistem dalam manajemen ASN dapat digambarkan sebagai berikut:<br>1.&nbsp; &nbsp; Penyusunan dan penetapan Kebutuhan<br>Pada aspek penyusunan dan penetapan kebutuhan, merit sistem dapat diterjemahkan instansi dengan membuat perencanaan kebutuhan ASN 5 tahunan berdasarkan Anjab (Analisis Jabatan) dan ABK (Analisis Beban Kerja) yang dalam penyusunannya mempertimbangkan jumlah, pangkat, dan kualifikasi pegawai yang ada, dengan mempertimbangkan pegawai yang akan pensiun.<br>2. Pengadaan<br>Pada aspek pengadaan, merit sistem salah satunya ditunjukkan dengan mekanisme rekrutmen pegawai yang terbuka, transparan dan kompetitif. Dengan metode tersebut diharapkan SDM yang dihasilkan berasal dari talenta-talenta terbaik dan unggul.<br>3. Pengembangan karier<br>Merit sistem dalam aspek ini dapat berupa kebijakan/program pengembangan karier berdasarkan hasil pemetaan talenta melalui assessment, analisis kesenjangan kompetensi dan kesenjangan kinerja, <em>talent pool</em>, dan rencana suksesi berdasarkan pola karier instansi.<br>4. Promosi dan Mutasi<br>Merit sistem pada aspek promosi dan mutasi diwujudkan dalam bentuk kebijakan yang objektif dan transparan didasarkan pada kesesuaian kualifikasi, kompetensi dan kinerja dengan memanfaatkan <em>Talent Pool</em>. Salah satu bentuk kebijakan tersebut adalah pengisian JPT melalui seleksi terbuka. Melalui seleksi terbuka diharapkan dapat menghasilkan orang yang tepat untuk menduduki suatu jabatan sesuai kebutuhan organisasi, mengatasi <em>spoil system </em>dan jual beli jabatan, serta memberikan kesempatan bagi semua pegawai untuk berkompetisi.<br>5. Penilaian kinerja<br>Penetapan target kinerja, evaluasi kinerja secara berkala (berkelanjutan) dengan menggunakan metode yang obyektif, menganalisis kesenjangan kinerja dan mempunyai strategi untuk mengatasinya dan menggunakan hasil penilaian kinerja dalam membuat keputusan terkait promosi, mutasi dapat menjadi bentuk implementasi merit sistem.<br>6. Penggajian, Penghargaan dan Disiplin<br>Instansi mengaitkan hasil penilaian kinerja dan disiplin dengan membayar tunjangan kinerja dan memberi penghargaan kepada pegawai serta melakukan penegakan nilai dasar, kode etik dan kode perilaku.<br>7. Jaminan dan perlindungan<br>Instansi mempunyai program perlindungan untuk pegawai diluar dari jaminan kesehatan, jaminan kecelakaan kerja, dan program pensiun yang diselenggarakan pemerintah nasional, serta menjamin kemudahan pelayanan administrasi bagi pegawai.&nbsp;</p><p><strong>Evaluasi<br></strong><br></p><p><strong><br></strong>Pada perjalanannya selama hampir 8 tahun, implementasi sistem merit di birokrasi Indonesia tidak terlepas dari tantangan. Berdasarkan peta sebaran penerapan sistem merit per Provinsi sampai dengan Tahun 2021 yang disusun Komisi Aparatur Sipil Negara (KASN) sebagai instansi yang dimandatkan untuk mengawasi penyelenggaraan merit sistem menunjukkan bahwa rata-rata pemerintah provinsi wilayah Indonesia bagian barat telah menerapkan sistem merit manajemen ASN, sedangkan wilayah Indonesia bagian timur rata-rata belum menerapkan sistem merit dengan optimal. Sebaran ini menunjukkan bahwa faktor geografis mempengaruhi implementasi sistem merit. Bukan fakta yang mengejutkan mengingat wilayah Indonesia sangat luas dan berbentuk kepulauan yang seringkali menjadi tantangan dalam hal pemerataan, hingga berujung pada ketimpangan kondisi antara wilayah barat dengan timur.</p><p><br></p><p>Sementara itu, berdasarkan hasil penilaian sistem merit oleh KASN pada tahun 2021, nilai tertinggi terdapat pada aspek pengadaan sebesar 73, 9%, lalu aspek perencanaan kebutuhan 73,2%. Sedangkan aspek pengembangan karier 31% dan aspek promosi dan mutasi 41,5% merupakan aspek yang paling rendah dalam penerapannya. Hal ini menunjukkan bahwa proses pengadaan ASN kini sudah semakin terbuka dan objektif salah satunya dengan diterapkannya <em>computer assisted test </em>(CAT) sebagai media rekrutmen. World Bank Global Report: Public Sector Performance 2018 bahkan menobatkan CAT BKN sebagai produk unggul dari Indonesia pada kategori <em>Civil Service Management </em>yang berhasil mereformasi sistem rekrutmen ASN Indonesia.</p><p><br></p><p>Sejalan dengan praktek baik dalam perekrutan pegawai, guna menjaga dan meningkatkan kualitas SDM hasil rekrutmen tersebut semestinya ditindaklanjuti dengan pembinaan dan pengembangan yang baik juga. Hanya saja dari penilaian implementasi merit sistem yang dilakukan KASN justru menunjukkan aspek pengembangan karier cenderung rendah dan perlu ditingkatkan.</p><p>Penerapan merit sistem pada aspek promosi serta mutasi juga masih rendah sehingga perlu diakselerasi dan ditingkatkan. Hasil ini perlu menjadi perhatian karena menunjukkan masih adanya peluang terjadinya praktek nepotisme berbasis primordial maupun afiliasi sosial politik. Padahal, pengisian jabatan seharusnya dilakukan sesuai dengan kualifikasi yang dibutuhkan dan kompetensi serta kinerja dari pegawai dengan melihat pola karier.&nbsp;</p><p><strong>Kesimpulan&nbsp;</strong></p><p>Tidak dapat dipungkiri berlakunya merit sistem dalam birokrasi Indonesia yang bertujuan untuk menghasilkan ASN yang profesional dan berintegritas dengan menempatkan mereka pada jabatan-jabatan birokrasi pemerintah sesuai kompetensinya; pemberian kompensasi yang adil dan layak; mengembangkan kemampuan ASN melalui bimbingan dan diklat; dan melindungi karier ASN dari politisasi dan kebijakan yang bertentangan dengan prinsip merit&nbsp; belum&nbsp; sepenuhnya&nbsp; optimal&nbsp; sesuai&nbsp; dengan ketentuan maupun ekspektasi. Dalam prakteknya penerapan&nbsp; sistem&nbsp; merit&nbsp; di Indonesia cukup kompleks karena adanya pengaruh kondisi lingkungan dimana&nbsp; sistem&nbsp; itu diterapkan. Oleh karenanya tidak heran jika progres implementasi sistem merit antara instansi satu dengan yang lain berbeda mengingat ada konteks lingkungan sosial bahkan geografis yang berbeda juga.&nbsp;</p><p>Pada akhirnya penerapan sistem merit lebih dari sekedar angka dalam penilaian dan tidak semestinya kita terfokus pada pengumpulan poin saja, melainkan juga pada proses internalisasi dalam pemikiran dan keseharian para pelakunya. Perlu menjadi catatan bahwa evaluasi penerapan sistem merit dilakukan melalui skoring/penilaian atas terpenuhinya aspek-aspek ideal yang dibuktikan salah satunya dengan dokumen administrasi. Oleh karenanya, kemampuan pengelola kepegawaian instansi pemerintah untuk menyiapkan berbagai prasyarat penilaian turut berpengaruh pada penilaian sistem merit di Indonesia.&nbsp;</p>', 'post-thumbnail/01K3D30GM7PNF9F7N976REKZ4R.jpg', 1, 0, '2025-08-24 03:47:32', '2025-08-24 03:47:32');
INSERT INTO `question_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'CAT', 'cat', '2025-08-12 03:11:07', '2025-08-12 03:11:07');

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
(1, 'admin', 'web', '2025-08-12 03:10:37', '2025-08-12 03:10:37'),
(2, 'penulis', 'web', '2025-08-12 03:10:37', '2025-08-12 03:10:37');

INSERT INTO `users` (`id`, `departement_id`, `name`, `email`, `nip`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'admin@admin.test', '199806162022031006', '2025-08-12 03:11:07', '$2y$12$B1By2NwpWaIgSKVa3i9sHu34P9CwSgGrUJ9pr0meWzP.GWU/H/Bxu', NULL, '2025-08-12 03:11:08', '2025-08-12 03:11:08'),
(2, 1, 'Admin Arsip', 'penulis@penulis.test', '000000', '2025-08-12 03:11:08', '$2y$12$MA2.HxEL0s0D7ha8a0t3aeAE3oPVDD1rKnBkY8Tk4kuLxjioLtmmu', NULL, '2025-08-12 03:11:08', '2025-08-12 03:11:08');


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;