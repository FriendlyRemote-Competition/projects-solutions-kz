-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Хост: mysql:3306
-- Время создания: Авг 18 2026 г., 16:47
-- Версия сервера: 8.4.11
-- Версия PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `KZ_Module_B`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departure_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line_id` bigint UNSIGNED NOT NULL,
  `departure_date` date NOT NULL,
  `departure_time` time NOT NULL,
  `first_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seats` smallint UNSIGNED NOT NULL,
  `fare_cny` decimal(5,2) NOT NULL,
  `status` enum('confirmed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'confirmed',
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bookings`
--

INSERT INTO `bookings` (`id`, `booking_code`, `departure_code`, `line_id`, `departure_date`, `departure_time`, `first_name`, `last_name`, `email`, `phone`, `seats`, `fare_cny`, `status`, `cancelled_at`, `created_at`, `updated_at`) VALUES
(1, 'HPFS0L6QV', 'DJ-20260916-0730-DCL', 1, '2026-09-16', '07:30:00', 'Lin', 'Wei', 'lin.wei@example.cn', '+8613800138011', 2, 2.00, 'cancelled', '2026-08-18 16:18:49', '2026-08-18 14:57:33', '2026-08-18 16:18:49'),
(2, 'HPFSVIH6B', 'DJ-20260916-0730-DCL', 1, '2026-09-16', '07:30:00', 'Lin', 'Wei', 'lin.wei@example.cn', '+8613800138011', 4, 2.00, 'cancelled', '2026-08-18 15:17:17', '2026-08-18 14:59:18', '2026-08-18 15:17:17'),
(3, 'HPFNSFRWO', 'DJ-20260916-0730-DCL', 1, '2026-09-16', '07:30:00', 'Lin', 'Wei', 'lin.wei@example.cn', '+8613800138011', 2, 2.00, 'cancelled', '2026-08-18 16:39:39', '2026-08-18 16:27:04', '2026-08-18 16:39:39'),
(4, 'HPFC2JNOT', 'DJ-20260916-0730-DCL', 1, '2026-09-16', '07:30:00', 'Lin', 'Wei', 'lin.wei@example.cn', '+8613800138011', 2, 2.00, 'confirmed', NULL, '2026-08-18 16:39:54', '2026-08-18 16:39:54');

-- --------------------------------------------------------

--
-- Структура таблицы `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cancelled_departures`
--

CREATE TABLE `cancelled_departures` (
  `id` bigint UNSIGNED NOT NULL,
  `departure_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line_id` bigint UNSIGNED NOT NULL,
  `departure_date` date NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `cancelled_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cancelled_departures`
--

INSERT INTO `cancelled_departures` (`id`, `departure_code`, `line_id`, `departure_date`, `reason`, `cancelled_at`) VALUES
(1, 'QF-20260819-0830-QCZ', 2, '2026-08-19', 'Vessel maintenance', '2026-08-17 22:10:00'),
(2, 'TD-20260819-0900-DJD', 5, '2026-08-19', 'Vessel swap at Tangqiao', '2026-08-17 23:40:00'),
(3, 'TD-20260820-1400-DJD', 5, '2026-08-20', 'Vessel maintenance', '2026-08-15 06:00:00'),
(4, 'DJ-20260916-0730-DCL', 1, '2026-09-16', 'Dense fog on the river', '2026-08-18 16:18:49');

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `lines`
--

CREATE TABLE `lines` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `station_a_id` bigint UNSIGNED NOT NULL,
  `station_b_id` bigint UNSIGNED NOT NULL,
  `seat_capacity` smallint UNSIGNED NOT NULL,
  `crossing_minutes` smallint UNSIGNED NOT NULL,
  `fare_cny` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lines`
--

INSERT INTO `lines` (`id`, `code`, `name`, `status`, `station_a_id`, `station_b_id`, `seat_capacity`, `crossing_minutes`, `fare_cny`) VALUES
(1, 'DJ', 'Dongjin Line', 'active', 1, 5, 48, 8, 2.00),
(2, 'QF', 'Qifu Line', 'active', 9, 3, 36, 10, 2.00),
(3, 'TG', 'Taigong Line', 'active', 11, 4, 24, 7, 2.00),
(4, 'ND', 'Nandong Line', 'active', 8, 2, 40, 9, 2.00),
(5, 'TD', 'Tangdong Line', 'active', 10, 2, 20, 12, 2.00),
(6, 'LT', 'Lantern Line', 'active', 6, 5, 60, 25, 25.00),
(7, 'PY', 'Puyang Line', 'suspended', 7, 12, 30, 11, 2.00),
(8, 'WS', 'Wusong Line', 'active', 10, 4, 30, 14, 3.00),
(10, 'WSA', 'Wusong Line', 'active', 10, 4, 30, 14, 3.00);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_08_10_180159_create_personal_access_tokens_table', 1),
(5, '2026_08_18_134206_create_stations_table', 1),
(6, '2026_08_18_134218_create_lines_table', 1),
(7, '2026_08_18_134239_create_service_windows_table', 1),
(8, '2026_08_18_134309_create_cancelled_departures_table', 1),
(9, '2026_08_18_134321_create_bookings_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `service_windows`
--

CREATE TABLE `service_windows` (
  `id` bigint UNSIGNED NOT NULL,
  `line_id` bigint UNSIGNED NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `interval_minutes` smallint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `service_windows`
--

INSERT INTO `service_windows` (`id`, `line_id`, `start_time`, `end_time`, `interval_minutes`) VALUES
(1, 1, '06:00:00', '08:59:00', 10),
(2, 1, '09:00:00', '15:59:00', 20),
(3, 1, '16:00:00', '18:59:00', 10),
(4, 1, '19:00:00', '23:59:00', 20),
(5, 2, '06:30:00', '09:29:00', 12),
(6, 2, '09:30:00', '16:59:00', 20),
(7, 2, '17:00:00', '19:29:00', 12),
(8, 2, '19:30:00', '23:59:00', 30),
(9, 3, '06:00:00', '08:59:00', 15),
(10, 3, '09:00:00', '17:59:00', 30),
(11, 3, '18:00:00', '20:59:00', 15),
(12, 4, '06:15:00', '20:15:00', 15),
(13, 5, '07:00:00', '19:00:00', 30),
(14, 6, '18:30:00', '22:30:00', 45),
(15, 7, '06:30:00', '19:30:00', 20),
(17, 8, '06:00:00', '07:59:00', 20);

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('g12Fm9jQpipycGUp44uO7pejpTSG3teDpXahskp7', NULL, '172.25.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:153.0) Gecko/20100101 Firefox/153.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOVNtVHJJOGtPUHY1UFJtRUl3ZDk5eVhSNjZBVWpKS0EyUWpCb1NENSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9sb2NhbGhvc3QvS1pfTW9kdWxlX0IvYm9hcmQvRENMIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1787070513);

-- --------------------------------------------------------

--
-- Структура таблицы `stations`
--

CREATE TABLE `stations` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `stations`
--

INSERT INTO `stations` (`id`, `code`, `name`, `bank`, `district`, `address`) VALUES
(1, 'DCL', 'Dongchang Road', 'Pudong', 'Pudong New Area', '1 Dongchang Road'),
(2, 'DJD', 'Dongjiadu', 'Puxi', 'Huangpu', '5 Waima Road'),
(3, 'FXR', 'Fuxing Road', 'Puxi', 'Huangpu', '465 Zhongshan East No.2 Road'),
(4, 'GPR', 'Gongping Road', 'Puxi', 'Hongkou', '1 Gongping Road'),
(5, 'JLE', 'Jinling East Road', 'Puxi', 'Huangpu', '127 Zhongshan East No.2 Road'),
(6, 'LJZ', 'Lujiazui', 'Pudong', 'Pudong New Area', '1 Fenghe Road'),
(7, 'MLR', 'Meilin Road', 'Pudong', 'Pudong New Area', '218 Meilin Road'),
(8, 'NMT', 'Nanmatou', 'Pudong', 'Pudong New Area', '3588 Pudong South Road'),
(9, 'QCZ', 'Qichangzhan', 'Pudong', 'Pudong New Area', '2477 Binjiang Avenue'),
(10, 'TQO', 'Tangqiao', 'Pudong', 'Pudong New Area', '2588 Binjiang Avenue'),
(11, 'TTZ', 'Taitongzhan', 'Pudong', 'Pudong New Area', '1500 Binjiang Avenue'),
(12, 'YSP', 'Yangshupu Road', 'Puxi', 'Yangpu', '1088 Yangshupu Road');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','dispatcher') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `api_token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `is_active`, `api_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Zhu Hai', 'admin1@hpferry.cn', NULL, '$2y$12$sPbU6GIylr6gRdG9ljdXs.kYXyC2OrZ8C97kAHRwjE.mzZ9v/1U9C', 'admin', 1, 'rJpfRYsme7E2pnvCbGF7CVwYULRjSHnrI8749ukNNhCmI6SIWvsYRMZ1kg5u', NULL, '2026-08-18 14:57:26', '2026-08-18 16:36:06'),
(2, 'Ivana Kral', 'admin2@hpferry.cn', NULL, '$2y$12$qUmnf1ZR4grlvztKXQwsw.jZGPd2mRHVQ9HzahkoLVbuCj91Egxxm', 'admin', 1, NULL, NULL, '2026-08-18 14:57:26', '2026-08-18 14:57:26'),
(3, 'Mo Chen', 'dispatch1@hpferry.cn', NULL, '$2y$12$a8WLWg45ameHg517EfkbjexfeLlM.5qRy6g8wFszXl6vlJMykwiHi', 'dispatcher', 1, NULL, NULL, '2026-08-18 14:57:26', '2026-08-18 14:57:26'),
(4, 'Lars Holm', 'dispatch2@hpferry.cn', NULL, '$2y$12$fq659gvYVhtJvNFjry89cuklCPTpdlkOxWCUe3iapUrmepinf7HRK', 'dispatcher', 0, NULL, NULL, '2026-08-18 14:57:26', '2026-08-18 14:57:26');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_booking_code_unique` (`booking_code`),
  ADD KEY `bookings_line_id_foreign` (`line_id`);

--
-- Индексы таблицы `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Индексы таблицы `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Индексы таблицы `cancelled_departures`
--
ALTER TABLE `cancelled_departures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cancelled_departures_departure_code_unique` (`departure_code`),
  ADD KEY `cancelled_departures_line_id_foreign` (`line_id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Индексы таблицы `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `lines`
--
ALTER TABLE `lines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lines_code_unique` (`code`),
  ADD KEY `lines_station_a_id_foreign` (`station_a_id`),
  ADD KEY `lines_station_b_id_foreign` (`station_b_id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Индексы таблицы `service_windows`
--
ALTER TABLE `service_windows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_windows_line_id_foreign` (`line_id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Индексы таблицы `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stations_code_unique` (`code`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `cancelled_departures`
--
ALTER TABLE `cancelled_departures`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `lines`
--
ALTER TABLE `lines`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `service_windows`
--
ALTER TABLE `service_windows`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `stations`
--
ALTER TABLE `stations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_line_id_foreign` FOREIGN KEY (`line_id`) REFERENCES `lines` (`id`);

--
-- Ограничения внешнего ключа таблицы `cancelled_departures`
--
ALTER TABLE `cancelled_departures`
  ADD CONSTRAINT `cancelled_departures_line_id_foreign` FOREIGN KEY (`line_id`) REFERENCES `lines` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `lines`
--
ALTER TABLE `lines`
  ADD CONSTRAINT `lines_station_a_id_foreign` FOREIGN KEY (`station_a_id`) REFERENCES `stations` (`id`),
  ADD CONSTRAINT `lines_station_b_id_foreign` FOREIGN KEY (`station_b_id`) REFERENCES `stations` (`id`);

--
-- Ограничения внешнего ключа таблицы `service_windows`
--
ALTER TABLE `service_windows`
  ADD CONSTRAINT `service_windows_line_id_foreign` FOREIGN KEY (`line_id`) REFERENCES `lines` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
