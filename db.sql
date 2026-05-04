-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 8.0.30 - MySQL Community Server - GPL
-- OS Server:                    Win64
-- HeidiSQL Versi:               12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Membuang data untuk tabel backend_travel.blog_posts: ~0 rows (lebih kurang)

-- Membuang data untuk tabel backend_travel.bookings: ~0 rows (lebih kurang)

-- Membuang data untuk tabel backend_travel.contacts: ~0 rows (lebih kurang)

-- Membuang data untuk tabel backend_travel.destinations: ~0 rows (lebih kurang)

-- Membuang data untuk tabel backend_travel.failed_jobs: ~0 rows (lebih kurang)

-- Membuang data untuk tabel backend_travel.faqs: ~0 rows (lebih kurang)

-- Membuang data untuk tabel backend_travel.jobs: ~0 rows (lebih kurang)

-- Membuang data untuk tabel backend_travel.migrations: ~13 rows (lebih kurang)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2026_04_29_000001_create_destinations_table', 1),
	(6, '2026_04_29_000002_create_trips_table', 1),
	(7, '2026_04_29_000003_create_reviews_table', 1),
	(8, '2026_04_29_000004_create_bookings_table', 1),
	(9, '2026_04_29_000005_create_blog_posts_table', 1),
	(10, '2026_04_29_000006_create_faqs_table', 1),
	(11, '2026_04_29_000007_create_contacts_table', 1),
	(12, '2026_04_30_000008_add_role_to_users_table', 1),
	(13, '2026_05_01_170829_change_cover_image_type_in_blog_posts_table', 1),
	(14, '2026_05_01_173751_create_jobs_table', 1),
	(15, '2026_05_02_000005_alter_cover_image_to_longtext_in_blog_posts_table', 1);

-- Membuang data untuk tabel backend_travel.password_reset_tokens: ~0 rows (lebih kurang)

-- Membuang data untuk tabel backend_travel.personal_access_tokens: ~2 rows (lebih kurang)
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
	(1, 'App\\Models\\User', 1, 'api', '7257d6cb6779f8752202930b7b5d11bef1d6b653aa5858caa433289c0edbad6b', '["*"]', '2026-05-02 01:26:09', NULL, '2026-05-01 23:19:14', '2026-05-02 01:26:09'),
	(2, 'App\\Models\\User', 2, 'api', '513df81113a246012bd3d0625fa1da8375662d3c3fb4d812ecf97dbe8d96e9f2', '["*"]', '2026-05-01 23:20:11', NULL, '2026-05-01 23:20:09', '2026-05-01 23:20:11');

-- Membuang data untuk tabel backend_travel.reviews: ~0 rows (lebih kurang)

-- Membuang data untuk tabel backend_travel.trips: ~0 rows (lebih kurang)

-- Membuang data untuk tabel backend_travel.users: ~2 rows (lebih kurang)
INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'admin@gmail.com', 'admin', NULL, '$2y$12$0m/Y3.tNl5VMXjE22W2eWuWkaTFbZrLF2vac4zqsHpHeR3gSefzjy', NULL, '2026-05-01 23:19:13', '2026-05-01 23:19:13'),
	(2, 'user', 'user@gmail.com', 'user', NULL, '$2y$12$LDhZ5aEzrLklnO3v1r7OoOe6xyNIVtZc.rZliGDVSJKBpQS66lEOu', NULL, '2026-05-01 23:20:09', '2026-05-01 23:20:09');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
