-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 16, 2025 lúc 06:53 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webbanhang`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_don_hang`
--

CREATE TABLE `chi_tiet_don_hang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_dh` int(11) NOT NULL COMMENT 'Mã đơn hàng',
  `id_sp` int(11) NOT NULL COMMENT 'Mã sản phẩm',
  `so_luong` int(11) NOT NULL DEFAULT 1 COMMENT 'Số lượng mua',
  `id_size` varchar(255) DEFAULT NULL,
  `gia` int(11) NOT NULL COMMENT 'Giá mua sản phẩm',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_don_hang`
--

INSERT INTO `chi_tiet_don_hang` (`id`, `id_dh`, `id_sp`, `so_luong`, `id_size`, `gia`, `created_at`, `updated_at`) VALUES
(1, 2, 8, 1, '1', 3900000, '2025-06-30 10:20:02', '2025-06-30 10:20:02'),
(2, 3, 8, 1, '1', 3900000, '2025-07-08 09:43:24', '2025-07-08 09:43:24'),
(3, 4, 8, 1, '1', 3900000, '2025-07-08 09:49:24', '2025-07-08 09:49:24'),
(5, 6, 8, 1, '2', 3900000, '2025-07-10 01:50:57', '2025-07-10 01:50:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_gia`
--

CREATE TABLE `danh_gia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_sp` int(11) NOT NULL COMMENT 'Mã sản phẩm',
  `id_user` int(11) NOT NULL COMMENT 'Người bình luận',
  `id_ctdh` int(11) NOT NULL,
  `noi_dung` text NOT NULL COMMENT 'Nội dung bình luận',
  `quality_product` varchar(255) DEFAULT NULL,
  `thoi_diem` datetime NOT NULL COMMENT 'Thời điểm bình luận',
  `hinh_dg` varchar(255) DEFAULT NULL,
  `feedback` varchar(255) DEFAULT NULL,
  `an_hien` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 là ẩn 1 là hiện',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_muc`
--

CREATE TABLE `danh_muc` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ten_dm` varchar(100) NOT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `trang_thai` int(11) NOT NULL,
  `thu_tu` int(11) NOT NULL DEFAULT 0,
  `id_loai` int(11) DEFAULT NULL,
  `an_hien` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danh_muc`
--

INSERT INTO `danh_muc` (`id`, `ten_dm`, `slug`, `trang_thai`, `thu_tu`, `id_loai`, `an_hien`, `created_at`, `updated_at`) VALUES
(7, 'Air Force 1', 'air-force-1', 0, 0, 2, 1, NULL, NULL),
(8, 'Air Max', 'air-max', 0, 0, 2, 1, NULL, NULL),
(9, 'Air Jordan', 'air-jordan', 0, 0, 2, 1, NULL, NULL),
(10, 'Dunk', 'dunk', 0, 0, 2, 1, NULL, NULL),
(11, 'Blazer', 'blazer', 0, 0, 2, 1, NULL, NULL),
(12, 'Clothing', 'clothing', 0, 0, 2, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dia_chi`
--

CREATE TABLE `dia_chi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL COMMENT 'Người bình luận',
  `phone` varchar(15) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `dc_chi_tiet` varchar(150) DEFAULT NULL,
  `qh` varchar(50) DEFAULT NULL,
  `thanh_pho` varchar(50) DEFAULT NULL,
  `an_hien` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 là ẩn 1 là hiện',
  `is_default_address` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 là bình thường, 1 là địa chỉ mặc định',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dia_chi`
--

INSERT INTO `dia_chi` (`id`, `id_user`, `phone`, `ho_ten`, `dc_chi_tiet`, `qh`, `thanh_pho`, `an_hien`, `is_default_address`, `created_at`, `updated_at`) VALUES
(6, 2, '0708662504', 'Nguyễn Ngọc Hưng', '65 Ấp Chánh Nhứt, xã Long Phụng, Cần Giuộc, Long An', NULL, NULL, 0, 0, '2025-07-09 10:06:44', '2025-07-09 10:06:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `don_hang`
--

CREATE TABLE `don_hang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` int(11) NOT NULL,
  `thoi_diem_mua_hang` datetime NOT NULL COMMENT 'Thời điểm mua hàng',
  `id_dc` int(11) NOT NULL,
  `tong_dh` int(11) NOT NULL COMMENT 'Tổng tiền sản phẩm',
  `pttt` varchar(255) NOT NULL,
  `trang_thai` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Trạng thái đơn hàng',
  `uu_dai` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `don_hang`
--

INSERT INTO `don_hang` (`id`, `id_user`, `thoi_diem_mua_hang`, `id_dc`, `tong_dh`, `pttt`, `trang_thai`, `uu_dai`, `created_at`, `updated_at`) VALUES
(2, 2, '2025-06-30 17:20:02', 2, 3900000, 'COD', 0, NULL, '2025-06-30 10:20:02', '2025-06-30 10:20:02'),
(3, 2, '2025-07-08 16:43:24', 2, 3900000, 'COD', 0, NULL, '2025-07-08 09:43:24', '2025-07-08 09:43:24'),
(4, 2, '2025-07-08 16:49:24', 2, 3900000, 'COD', 0, NULL, '2025-07-08 09:49:24', '2025-07-08 09:49:24'),
(6, 2, '2025-07-10 08:50:57', 6, 3900000, 'COD', 0, NULL, '2025-07-10 01:50:57', '2025-07-10 01:50:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gio_hang`
--

CREATE TABLE `gio_hang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `id_sp` bigint(20) UNSIGNED NOT NULL,
  `id_size` bigint(20) UNSIGNED NOT NULL,
  `so_luong` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `gio_hang`
--

INSERT INTO `gio_hang` (`id`, `user_id`, `id_sp`, `id_size`, `so_luong`, `status`, `created_at`, `updated_at`) VALUES
(11, 2, 8, 2, 1, 0, '2025-07-16 05:22:28', '2025-07-16 05:22:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loai`
--

CREATE TABLE `loai` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ten_loai` varchar(100) NOT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `thu_tu` int(11) NOT NULL DEFAULT 0,
  `an_hien` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loai`
--

INSERT INTO `loai` (`id`, `ten_loai`, `slug`, `thu_tu`, `an_hien`, `created_at`, `updated_at`) VALUES
(1, 'Áo', 'ao', 0, 1, NULL, NULL),
(2, 'Giày', 'giay', 0, 1, NULL, NULL),
(3, 'Quần', 'quan', 0, 1, NULL, NULL),
(7, 'Phụ kiện', 'phu-kien', 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_06_24_084001_edit_dia_chi_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reply_email`
--

CREATE TABLE `reply_email` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `noi_dung` text NOT NULL,
  `an_hien` tinyint(1) NOT NULL DEFAULT 1,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `san_pham`
--

CREATE TABLE `san_pham` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ten_sp` varchar(200) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `gia` int(11) NOT NULL,
  `gia_km` int(11) DEFAULT NULL,
  `id_dm` bigint(20) UNSIGNED NOT NULL,
  `hinh` varchar(255) DEFAULT NULL,
  `mo_ta_ct` text DEFAULT NULL,
  `mo_ta_ngan` text DEFAULT NULL,
  `an_hien` tinyint(1) NOT NULL DEFAULT 0,
  `trang_thai` tinyint(1) NOT NULL DEFAULT 0,
  `luot_mua` int(11) NOT NULL DEFAULT 0,
  `tinh_chat` tinyint(1) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `ngay` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `san_pham`
--

INSERT INTO `san_pham` (`id`, `ten_sp`, `slug`, `gia`, `gia_km`, `id_dm`, `hinh`, `mo_ta_ct`, `mo_ta_ngan`, `an_hien`, `trang_thai`, `luot_mua`, `tinh_chat`, `color`, `ngay`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Nike Dunk Low Retro', 'nike-dunk-low-retro', 4000000, 3900000, 8, 'nikedunklowretrose.png', NULL, NULL, 0, 3, 0, NULL, 'Đen', '2025-05-19', NULL, NULL, NULL),
(2, 'Air Jordan 1 Low', 'air-jordan-1-low', 4000000, 3900000, 8, 'airjordan1low.png', NULL, NULL, 0, 3, 100, NULL, 'Đen', '2025-05-19', NULL, NULL, NULL),
(3, 'Nike Air Max Moto 2k', 'nike-air-max-moto-2k', 4000000, 3900000, 8, 'nikeairmaxmoto2k.png', NULL, NULL, 0, 3, 0, NULL, 'Trắng', '2025-05-19', NULL, NULL, NULL),
(4, 'Nike Air Max Plus', 'nike-air-max-plus', 4000000, 3900000, 8, 'nikeairmaxplus.png', NULL, NULL, 0, 4, 0, NULL, 'Đen', '2025-05-19', NULL, NULL, NULL),
(5, 'Nike Air Force 1 \'07 LX', 'nike-air-force-1-0-7-LX', 4000000, 3900000, 8, 'nikeairforce107lx.png', NULL, NULL, 0, 1, 0, NULL, 'Đen', '2025-05-19', NULL, NULL, NULL),
(6, 'Nike Air Force 1 \'07 LV8', 'nike-air-force-1-0-7-lv8', 4000000, 3900000, 8, 'nikeairforce107lv8.png', NULL, NULL, 0, 1, 0, NULL, 'Đen', '2025-05-19', NULL, NULL, NULL),
(7, 'Nike Dunk Low', 'nike-dunk-low', 4000000, 3900000, 8, 'nikedunklow.png', NULL, NULL, 0, 1, 0, NULL, 'Đen', '2025-05-19', NULL, NULL, NULL),
(8, 'Air Jordan 1 Low SE', 'air-jordan-1-low-se', 4000000, 3900000, 8, 'airjordan1lowse.png', NULL, NULL, 0, 1, 4, NULL, 'Đen', '2025-05-19', NULL, '2025-07-10 01:50:57', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('fM3k5IcD5Lw1j2VVkkBQZ1bz5F7MDWByYwpjAvzo', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '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ImdpYSI7aTo0MDAwMDAwO3M6NjoiZ2lhX2ttIjtpOjM5MDAwMDA7czo1OiJpZF9kbSI7aTo4O3M6NDoiaGluaCI7czoxOToiYWlyam9yZGFuMWxvd3NlLnBuZyI7czo4OiJtb190YV9jdCI7TjtzOjEwOiJtb190YV9uZ2FuIjtOO3M6NzoiYW5faGllbiI7aTowO3M6MTA6InRyYW5nX3RoYWkiO2k6MTtzOjg6Imx1b3RfbXVhIjtpOjQ7czo5OiJ0aW5oX2NoYXQiO047czo1OiJjb2xvciI7czo0OiLEkGVuIjtzOjQ6Im5nYXkiO3M6MTA6IjIwMjUtMDUtMTkiO3M6MTA6ImNyZWF0ZWRfYXQiO047czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyNS0wNy0xMCAwODo1MDo1NyI7czoxMDoiZGVsZXRlZF9hdCI7Tjt9czoxMToiACoAb3JpZ2luYWwiO2E6MTg6e3M6MjoiaWQiO2k6ODtzOjY6InRlbl9zcCI7czoxOToiQWlyIEpvcmRhbiAxIExvdyBTRSI7czo0OiJzbHVnIjtzOjE5OiJhaXItam9yZGFuLTEtbG93LXNlIjtzOjM6ImdpYSI7aTo0MDAwMDAwO3M6NjoiZ2lhX2ttIjtpOjM5MDAwMDA7czo1OiJpZF9kbSI7aTo4O3M6NDoiaGluaCI7czoxOToiYWlyam9yZGFuMWxvd3NlLnBuZyI7czo4OiJtb190YV9jdCI7TjtzOjEwOiJtb190YV9uZ2FuIjtOO3M6NzoiYW5faGllbiI7aTowO3M6MTA6InRyYW5nX3RoYWkiO2k6MTtzOjg6Imx1b3RfbXVhIjtpOjQ7czo5OiJ0aW5oX2NoYXQiO047czo1OiJjb2xvciI7czo0OiLEkGVuIjtzOjQ6Im5nYXkiO3M6MTA6IjIwMjUtMDUtMTkiO3M6MTA6ImNyZWF0ZWRfYXQiO047czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyNS0wNy0xMCAwODo1MDo1NyI7czoxMDoiZGVsZXRlZF9hdCI7Tjt9czoxMDoiACoAY2hhbmdlcyI7YTowOnt9czo4OiIAKgBjYXN0cyI7YToxOntzOjEwOiJkZWxldGVkX2F0IjtzOjg6ImRhdGV0aW1lIjt9czoxNzoiACoAY2xh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', 1752671410);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `size_product` varchar(50) NOT NULL,
  `so_luong` int(11) NOT NULL DEFAULT 0,
  `id_product` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sizes`
--

INSERT INTO `sizes` (`id`, `size_product`, `so_luong`, `id_product`, `created_at`, `updated_at`) VALUES
(1, '37', 99, 8, NULL, '2025-07-08 09:49:24'),
(2, '38', 99, 8, NULL, '2025-07-10 01:50:57'),
(5, '37', 100, 7, NULL, NULL),
(6, '38', 100, 7, NULL, NULL),
(7, '40', 100, 6, NULL, NULL),
(8, '41', 100, 6, NULL, NULL),
(9, '40', 100, 5, NULL, NULL),
(10, '41', 100, 5, NULL, NULL),
(11, '40', 100, 1, NULL, NULL),
(12, '40', 100, 4, NULL, NULL),
(13, '41', 100, 4, NULL, NULL),
(14, '40', 100, 3, NULL, NULL),
(15, '41', 100, 3, NULL, NULL),
(16, '40', 100, 2, NULL, NULL),
(17, '41', 100, 2, NULL, NULL),
(18, '41', 100, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 là bình thường, 1 là admin',
  `idGG` int(11) NOT NULL DEFAULT 0 COMMENT '0 là bình thường, 1 là admin',
  `google_id` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_hidden` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 là hiển thị, 1 là ẩn',
  `otp` varchar(255) DEFAULT NULL,
  `otp_verified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `email_verified_at`, `role`, `idGG`, `google_id`, `remember_token`, `created_at`, `updated_at`, `is_hidden`, `otp`, `otp_verified_at`) VALUES
(2, 'Hung Ngoc', 'hungnguyen270604@gmail.com', '$2y$12$rNpy6gY95ldNAI9QnaCJKOyOofiOYupUtBC8dh3AF.SsDUHhStTT2', '2025-05-25 10:06:45', 1, 0, NULL, 'rA6s1H4NvSdpQnmDsL0YJAkLaGUYeYJwLVLbMRa8dp7K3xbCqg47qRJyxPw7', '2025-05-25 10:06:45', '2025-07-13 01:30:43', 0, NULL, NULL),
(3, 'Đức Duy', 'ducduytdd30@gmail.com', '$2y$12$EHPWl1D8kIEm3uBA6EkWreWgG4tZDaHvvsQ2V/tR20DpqgiWVVK5G', '2025-05-25 10:06:45', 0, 0, NULL, 'DA3cAd5hMMB3u7PDOXBt2GSDowudTRqToQAl8ldGKGocJBcvk4R7T1mKBevJ', '2025-05-25 10:06:45', '2025-05-25 10:06:45', 0, NULL, NULL),
(4, 'Admin', 'admin@gmail.com', '$2y$12$vzW98TQmmwrXRkIcxwWlBOI2gUTB4psPlB5Ni6XYXhbIELECd07OK', '2025-05-25 10:06:45', 1, 0, NULL, '5ufSkyiSYk', '2025-05-25 10:06:45', '2025-05-25 10:06:45', 0, NULL, NULL),
(6, 'Nguyễn Ngọc Hưng', 'hungnnps30324@fpt.edu.vn', '$2y$12$2j8qYYybDKHBEKUAMFwTFehHiDSNfp1sq95qMR2FwtLN347qP.eOi', NULL, 0, 0, NULL, NULL, '2025-07-16 06:10:09', '2025-07-16 06:10:09', 0, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `danh_muc`
--
ALTER TABLE `danh_muc`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `dia_chi`
--
ALTER TABLE `dia_chi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dia_chi_id_user_foreign` (`id_user`);

--
-- Chỉ mục cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gio_hang_user_id_foreign` (`user_id`),
  ADD KEY `gio_hang_id_sp_foreign` (`id_sp`),
  ADD KEY `gio_hang_id_size_foreign` (`id_size`);

--
-- Chỉ mục cho bảng `loai`
--
ALTER TABLE `loai`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `danh_muc`
--
ALTER TABLE `danh_muc`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `dia_chi`
--
ALTER TABLE `dia_chi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `loai`
--
ALTER TABLE `loai`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
