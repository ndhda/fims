-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table unissa_fims.academic_session
CREATE TABLE IF NOT EXISTS `academic_session` (
  `session_id` int unsigned NOT NULL,
  `session_name` varchar(50) DEFAULT NULL,
  `session_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`session_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.academic_session: ~3 rows (approximately)
INSERT INTO `academic_session` (`session_id`, `session_name`, `session_code`) VALUES
	(1, 'Semester 1', 'S1'),
	(2, 'Semester 2', 'S2'),
	(3, 'Semester 3', 'S3');

-- Dumping structure for table unissa_fims.amount_paid
CREATE TABLE IF NOT EXISTS `amount_paid` (
  `amount_paid_id` int unsigned NOT NULL AUTO_INCREMENT,
  `amount_paid` decimal(10,2) NOT NULL,
  `fee_id` bigint unsigned NOT NULL,
  `date_paid` date NOT NULL,
  `payment_method` enum('Online Payment (BIBD)','Counter') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `payment_proof` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reference_num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `receipt_num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`amount_paid_id`),
  UNIQUE KEY `receipt_num` (`receipt_num`),
  KEY `FK_amount_paid_fee` (`fee_id`),
  CONSTRAINT `FK_amount_paid_fee` FOREIGN KEY (`fee_id`) REFERENCES `fee` (`fee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.amount_paid: ~0 rows (approximately)

-- Dumping structure for table unissa_fims.bank_sponsor
CREATE TABLE IF NOT EXISTS `bank_sponsor` (
  `bank_sponsor_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `bank_acc_num` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `sponsor_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `student_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`bank_sponsor_id`),
  KEY `FK_bank_sponsor_students` (`student_id`),
  CONSTRAINT `FK_bank_sponsor_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.bank_sponsor: ~0 rows (approximately)

-- Dumping structure for table unissa_fims.bulk_fee_operations
CREATE TABLE IF NOT EXISTS `bulk_fee_operations` (
  `operation_id` int unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` bigint unsigned NOT NULL,
  `batch_id` varchar(50) NOT NULL,
  `total_students` int NOT NULL,
  `total_fees` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`operation_id`),
  UNIQUE KEY `batch_id` (`batch_id`),
  KEY `FK_bulk_fee_operations_staffs` (`admin_id`),
  CONSTRAINT `FK_bulk_fee_operations_staffs` FOREIGN KEY (`admin_id`) REFERENCES `staffs` (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.bulk_fee_operations: ~0 rows (approximately)

-- Dumping structure for table unissa_fims.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_general_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.cache: ~0 rows (approximately)

-- Dumping structure for table unissa_fims.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.cache_locks: ~0 rows (approximately)

-- Dumping structure for table unissa_fims.clearance_form
CREATE TABLE IF NOT EXISTS `clearance_form` (
  `clearance_form_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `clearance_form_doc` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `submission_date` date NOT NULL,
  `student_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`clearance_form_id`),
  KEY `FK_clearance_form_students` (`student_id`),
  CONSTRAINT `FK_clearance_form_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.clearance_form: ~0 rows (approximately)

-- Dumping structure for table unissa_fims.edu_level
CREATE TABLE IF NOT EXISTS `edu_level` (
  `level_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `level_code` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `level_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `level_duration` int NOT NULL COMMENT 'by semester',
  `study_mode` enum('Full Time','Part Time') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.edu_level: ~4 rows (approximately)
INSERT INTO `edu_level` (`level_id`, `level_code`, `level_name`, `level_duration`, `study_mode`, `created_at`, `updated_at`) VALUES
	(1, 'Degree-FT', 'Degree', 8, 'Full Time', NULL, NULL),
	(2, 'Master-FT', 'Master', 4, 'Full Time', NULL, NULL),
	(3, 'Diploma Tinggi-FT', 'Diploma Tinggi', 4, 'Full Time', NULL, NULL),
	(4, 'Master-PT', 'Master', 3, 'Part Time', NULL, NULL);

-- Dumping structure for table unissa_fims.faculties
CREATE TABLE IF NOT EXISTS `faculties` (
  `faculty_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `faculty_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `faculty_code` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`faculty_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.faculties: ~3 rows (approximately)
INSERT INTO `faculties` (`faculty_id`, `faculty_name`, `faculty_code`, `created_at`, `updated_at`) VALUES
	(1, 'Fakulti Komputeran Meta dan Teknologi', 'FKMT', NULL, NULL),
	(2, 'Fakulti Teknologi Vokasional', 'FTV', NULL, NULL),
	(3, 'Faculty of Islamic Technology', 'FIT', NULL, NULL);

-- Dumping structure for table unissa_fims.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `connection` text COLLATE utf8mb4_general_ci NOT NULL,
  `queue` text COLLATE utf8mb4_general_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table unissa_fims.fee
CREATE TABLE IF NOT EXISTS `fee` (
  `fee_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fee_category_id` int unsigned NOT NULL,
  `description` varchar(255) NOT NULL,
  `total_amount` float NOT NULL,
  `date_issued` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `amount_balance` decimal(10,2) DEFAULT NULL,
  `fee_status_id` int unsigned NOT NULL,
  `year_id` int unsigned NOT NULL,
  `student_id` bigint unsigned NOT NULL,
  `session_id` int unsigned NOT NULL,
  `batch_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`fee_id`),
  UNIQUE KEY `batch_id` (`batch_id`),
  KEY `FK_fee_fee_category` (`fee_category_id`),
  KEY `FK_fee_fee_status` (`fee_status_id`),
  KEY `FK_fee_year` (`year_id`),
  KEY `FK_fee_students` (`student_id`),
  KEY `FK_fee_academic_session` (`session_id`),
  CONSTRAINT `FK_fee_academic_session` FOREIGN KEY (`session_id`) REFERENCES `academic_session` (`session_id`),
  CONSTRAINT `FK_fee_bulk_fee_operations` FOREIGN KEY (`batch_id`) REFERENCES `bulk_fee_operations` (`batch_id`),
  CONSTRAINT `FK_fee_fee_category` FOREIGN KEY (`fee_category_id`) REFERENCES `fee_category` (`fee_category_id`),
  CONSTRAINT `FK_fee_fee_status` FOREIGN KEY (`fee_status_id`) REFERENCES `fee_status` (`fee_status_id`),
  CONSTRAINT `FK_fee_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  CONSTRAINT `FK_fee_year` FOREIGN KEY (`year_id`) REFERENCES `year` (`year_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.fee: ~0 rows (approximately)

-- Dumping structure for table unissa_fims.fee_category
CREATE TABLE IF NOT EXISTS `fee_category` (
  `fee_category_id` int unsigned NOT NULL AUTO_INCREMENT,
  `fee_category_name` varchar(255) NOT NULL,
  `fee_category_code` varchar(255) NOT NULL,
  PRIMARY KEY (`fee_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.fee_category: ~6 rows (approximately)
INSERT INTO `fee_category` (`fee_category_id`, `fee_category_name`, `fee_category_code`) VALUES
	(1, 'Hostel Fees', 'T003-1'),
	(2, 'Tuition Fees', 'T002-1'),
	(3, 'Admission Fees', 'T002-2'),
	(4, 'Registration Fees', 'T002-3'),
	(5, 'Student Pack', 'SP'),
	(6, 'Recurring Fees', 'T002-4');

-- Dumping structure for table unissa_fims.fee_history
CREATE TABLE IF NOT EXISTS `fee_history` (
  `history_id` int unsigned NOT NULL,
  `fee_id` bigint unsigned NOT NULL DEFAULT '0',
  `action` enum('created','updated','deleted') NOT NULL,
  `admin_id` bigint unsigned NOT NULL,
  `action_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`history_id`),
  KEY `FK_fee_history_fee` (`fee_id`),
  KEY `FK_fee_history_staffs` (`admin_id`),
  CONSTRAINT `FK_fee_history_fee` FOREIGN KEY (`fee_id`) REFERENCES `fee` (`fee_id`),
  CONSTRAINT `FK_fee_history_staffs` FOREIGN KEY (`admin_id`) REFERENCES `staffs` (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.fee_history: ~0 rows (approximately)

-- Dumping structure for table unissa_fims.fee_rules
CREATE TABLE IF NOT EXISTS `fee_rules` (
  `rule_id` int unsigned NOT NULL AUTO_INCREMENT,
  `fee_category_id` int unsigned NOT NULL,
  `programme_id` bigint unsigned NOT NULL,
  `semester_id` bigint unsigned DEFAULT NULL,
  `hostel` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `international` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`rule_id`),
  KEY `FK_fee_rules_fee_category` (`fee_category_id`),
  KEY `FK_fee_rules_semesters` (`semester_id`),
  KEY `FK_fee_rules_programmes` (`programme_id`),
  CONSTRAINT `FK_fee_rules_fee_category` FOREIGN KEY (`fee_category_id`) REFERENCES `fee_category` (`fee_category_id`),
  CONSTRAINT `FK_fee_rules_programmes` FOREIGN KEY (`programme_id`) REFERENCES `programmes` (`id`),
  CONSTRAINT `FK_fee_rules_semesters` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`semester_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.fee_rules: ~2 rows (approximately)
INSERT INTO `fee_rules` (`rule_id`, `fee_category_id`, `programme_id`, `semester_id`, `hostel`, `international`, `amount`, `created_at`, `updated_at`) VALUES
	(17, 2, 6, 2, 'yes', 'yes', 3000.00, NULL, NULL),
	(18, 2, 2, 5, NULL, NULL, 451223.00, NULL, NULL);

-- Dumping structure for table unissa_fims.fee_status
CREATE TABLE IF NOT EXISTS `fee_status` (
  `fee_status_id` int unsigned NOT NULL AUTO_INCREMENT,
  `fee_status_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`fee_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.fee_status: ~4 rows (approximately)
INSERT INTO `fee_status` (`fee_status_id`, `fee_status_name`) VALUES
	(1, 'Unpaid'),
	(2, 'Pending'),
	(3, 'Paid'),
	(4, 'Partially Paid');

-- Dumping structure for table unissa_fims.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.jobs: ~0 rows (approximately)

-- Dumping structure for table unissa_fims.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_general_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.job_batches: ~0 rows (approximately)

-- Dumping structure for table unissa_fims.level_of_access
CREATE TABLE IF NOT EXISTS `level_of_access` (
  `loa_code` bigint unsigned NOT NULL AUTO_INCREMENT,
  `loa_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`loa_code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.level_of_access: ~3 rows (approximately)
INSERT INTO `level_of_access` (`loa_code`, `loa_name`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin Access', NULL, NULL),
	(2, 'Staff Access', NULL, NULL),
	(3, 'Student Access', NULL, NULL);

-- Dumping structure for table unissa_fims.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table unissa_fims.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_general_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table unissa_fims.programmes
CREATE TABLE IF NOT EXISTS `programmes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `programme_code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `programme_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `programme_duration` int NOT NULL,
  `level_id` bigint unsigned NOT NULL,
  `faculty_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `programmes_level_id_foreign` (`level_id`),
  KEY `programmes_faculty_id_foreign` (`faculty_id`),
  CONSTRAINT `programmes_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`),
  CONSTRAINT `programmes_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `edu_level` (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.programmes: ~6 rows (approximately)
INSERT INTO `programmes` (`id`, `programme_code`, `programme_name`, `programme_duration`, `level_id`, `faculty_id`, `created_at`, `updated_at`) VALUES
	(1, 'AC10', 'Software Engineering', 8, 1, 1, '2024-12-28 03:05:05', NULL),
	(2, 'AT20', 'IT', 8, 1, 1, NULL, NULL),
	(3, 'AT55', 'Reka Bentuk dan Teknologi', 8, 1, 2, NULL, NULL),
	(4, 'F002', 'Bachelor in Islamic Data Science', 6, 1, 3, NULL, NULL),
	(5, 'F001', 'Bachelor in Islamic Media and Communication Technology', 6, 1, 3, NULL, NULL),
	(6, 'F202', 'Master of Islamic Media and Communication Technology (by Research)', 3, 2, 3, NULL, NULL);

-- Dumping structure for table unissa_fims.refund
CREATE TABLE IF NOT EXISTS `refund` (
  `refund_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `refund_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `student_id` bigint unsigned DEFAULT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `total_refund` decimal(10,2) NOT NULL,
  `receipt_depo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date_applied` date NOT NULL,
  `status` enum('pending','approved','denied') COLLATE utf8mb4_general_ci NOT NULL,
  `comment` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`refund_id`),
  KEY `FK_refund_students` (`student_id`),
  CONSTRAINT `FK_refund_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.refund: ~0 rows (approximately)

-- Dumping structure for table unissa_fims.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.roles: ~3 rows (approximately)
INSERT INTO `roles` (`role_id`, `role_name`, `created_at`, `updated_at`) VALUES
	(1, 'super_admin', NULL, NULL),
	(2, 'staff', NULL, NULL),
	(3, 'student', NULL, NULL);

-- Dumping structure for table unissa_fims.semesters
CREATE TABLE IF NOT EXISTS `semesters` (
  `semester_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `semester_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`semester_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.semesters: ~10 rows (approximately)
INSERT INTO `semesters` (`semester_id`, `semester_name`, `created_at`, `updated_at`) VALUES
	(1, 'Semester 1', NULL, NULL),
	(2, 'Semester 2', NULL, NULL),
	(3, 'Semester 3', NULL, NULL),
	(4, 'Semester 4', NULL, NULL),
	(5, 'Semester 5', NULL, NULL),
	(6, 'Semester 6', NULL, NULL),
	(7, 'Semester 7', NULL, NULL),
	(8, 'Semester 8', NULL, NULL),
	(9, 'Semester 9', NULL, NULL),
	(10, 'Semester 10', NULL, NULL);

-- Dumping structure for table unissa_fims.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_general_ci,
  `payload` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('xRcwv7UxEWEYIpPOh4lJd6lNBVEVH8Ef6KyYcSNF', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOENzY3R0aTkyaUtNcndDWUpGWEdVa0EwOHpsSkY2ZEJzWDN6TE9CMCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0ODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3JlY2VpcHRzLzUxL2dlbmVyYXRlIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9idWxrLWZlZS9jcmVhdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1736913358);

-- Dumping structure for table unissa_fims.staffs
CREATE TABLE IF NOT EXISTS `staffs` (
  `staff_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`staff_id`) USING BTREE,
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.staffs: ~2 rows (approximately)
INSERT INTO `staffs` (`staff_id`, `staff_name`, `email`, `position`, `created_at`, `updated_at`) VALUES
	(1, 'elisa', 'elisa@gmail.com', 'clerk', NULL, NULL),
	(2, 'asma', 'asma@gmail.com', 'clerk', NULL, NULL);

-- Dumping structure for table unissa_fims.students
CREATE TABLE IF NOT EXISTS `students` (
  `student_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `matric_num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `semester_id` bigint unsigned NOT NULL,
  `faculty_id` bigint unsigned NOT NULL,
  `programme_id` bigint unsigned DEFAULT NULL,
  `hostel` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'No',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `contact_num` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`student_id`) USING BTREE,
  UNIQUE KEY `email` (`email`),
  KEY `FK_students_semesters` (`semester_id`),
  KEY `FK_students_faculties` (`faculty_id`),
  KEY `programme_id` (`programme_id`),
  CONSTRAINT `FK_students_faculties` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`),
  CONSTRAINT `FK_students_programmes` FOREIGN KEY (`programme_id`) REFERENCES `programmes` (`id`),
  CONSTRAINT `FK_students_semesters` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`semester_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.students: ~4 rows (approximately)
INSERT INTO `students` (`student_id`, `full_name`, `matric_num`, `semester_id`, `faculty_id`, `programme_id`, `hostel`, `email`, `contact_num`, `created_at`, `updated_at`) VALUES
	(1, 'ainin', 'D097403', 1, 1, 1, 'Yes', 'ainin@gmail.com', '0134759685', '2024-12-28 06:42:05', NULL),
	(2, 'farah', 'D097589', 6, 2, 2, 'Yes', 'farah@gmail.com', '0173529874', '2024-12-28 06:42:03', NULL),
	(3, 'amzar', 'D096003', 7, 1, 1, 'Yes', 'amzar@gmail.com', '0164859874', NULL, NULL),
	(4, 'farishya', 'D097399', 5, 2, 3, 'No', 'farishya@gmail.com', '0175256324', NULL, NULL);

-- Dumping structure for table unissa_fims.super_admin
CREATE TABLE IF NOT EXISTS `super_admin` (
  `super_admin_id` int unsigned NOT NULL AUTO_INCREMENT,
  `super_admin_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`super_admin_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.super_admin: ~1 rows (approximately)
INSERT INTO `super_admin` (`super_admin_id`, `super_admin_name`, `email`) VALUES
	(1, 'nadira huda', 'nadira@gmail.com');

-- Dumping structure for table unissa_fims.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_general_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_general_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.users: ~0 rows (approximately)

-- Dumping structure for table unissa_fims.user_management
CREATE TABLE IF NOT EXISTS `user_management` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `loa_code` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  `student_id` bigint unsigned DEFAULT NULL,
  `staff_id` bigint unsigned DEFAULT NULL,
  `super_admin_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `FK__level_of_access` (`loa_code`),
  KEY `FK__roles` (`role_id`),
  KEY `FK_user_management_staffs` (`staff_id`),
  KEY `FK_user_management_super_admin` (`super_admin_id`),
  KEY `FK_user_management_students` (`student_id`),
  CONSTRAINT `FK__level_of_access` FOREIGN KEY (`loa_code`) REFERENCES `level_of_access` (`loa_code`),
  CONSTRAINT `FK__roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`),
  CONSTRAINT `FK_user_management_staffs` FOREIGN KEY (`staff_id`) REFERENCES `staffs` (`staff_id`),
  CONSTRAINT `FK_user_management_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  CONSTRAINT `FK_user_management_super_admin` FOREIGN KEY (`super_admin_id`) REFERENCES `super_admin` (`super_admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.user_management: ~7 rows (approximately)
INSERT INTO `user_management` (`id`, `email`, `password`, `loa_code`, `role_id`, `student_id`, `staff_id`, `super_admin_id`) VALUES
	(1, 'nadira@gmail.com', '$2y$12$dPPIMFsd/23fl0qodv94W.Xglmjj.9C1tFDhuTJBT9p973fWYiVES', 1, 1, NULL, NULL, 1),
	(2, 'elisa@gmail.com', '$2y$12$dPPIMFsd/23fl0qodv94W.Xglmjj.9C1tFDhuTJBT9p973fWYiVES', 2, 2, NULL, 1, NULL),
	(3, 'ainin@gmail.com', '$2y$12$dPPIMFsd/23fl0qodv94W.Xglmjj.9C1tFDhuTJBT9p973fWYiVES', 3, 3, 1, NULL, NULL),
	(4, 'asma@gmail.com', '$2y$12$kHsXyZvLlL46KMd4WDB74.PJAZZfgtNwxc8p14fqUUWM7nZVXpik2', 2, 2, NULL, 2, NULL),
	(5, 'farah@gmail.com', '$2y$12$kHsXyZvLlL46KMd4WDB74.PJAZZfgtNwxc8p14fqUUWM7nZVXpik2', 3, 3, 2, NULL, NULL),
	(6, 'amzar@gmail.com', '$2y$12$kHsXyZvLlL46KMd4WDB74.PJAZZfgtNwxc8p14fqUUWM7nZVXpik2', 3, 3, 3, NULL, NULL),
	(7, 'farishya@gmail.com', '$2y$12$kHsXyZvLlL46KMd4WDB74.PJAZZfgtNwxc8p14fqUUWM7nZVXpik2', 3, 3, 4, NULL, NULL);

-- Dumping structure for table unissa_fims.year
CREATE TABLE IF NOT EXISTS `year` (
  `year_id` int unsigned NOT NULL AUTO_INCREMENT,
  `year_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`year_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table unissa_fims.year: ~3 rows (approximately)
INSERT INTO `year` (`year_id`, `year_name`, `created_at`, `updated_at`) VALUES
	(1, '2024', NULL, NULL),
	(2, '2025', NULL, NULL),
	(3, '2026', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
