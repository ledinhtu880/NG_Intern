-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               11.1.2-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for laravel01
CREATE DATABASE IF NOT EXISTS `laravel01` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `laravel01`;

-- Dumping structure for table laravel01.chi_tiet_don_nhap
CREATE TABLE IF NOT EXISTS `chi_tiet_don_nhap` (
  `FK_Id_DonNhapHang` bigint(20) unsigned NOT NULL,
  `FK_Id_MatHang` bigint(20) unsigned NOT NULL,
  `count` int(11) NOT NULL,
  KEY `chi_tiet_don_nhap_fk_id_donnhaphang_foreign` (`FK_Id_DonNhapHang`),
  KEY `chi_tiet_don_nhap_fk_id_mathang_foreign` (`FK_Id_MatHang`),
  CONSTRAINT `chi_tiet_don_nhap_fk_id_donnhaphang_foreign` FOREIGN KEY (`FK_Id_DonNhapHang`) REFERENCES `don_nhap_hang` (`id`),
  CONSTRAINT `chi_tiet_don_nhap_fk_id_mathang_foreign` FOREIGN KEY (`FK_Id_MatHang`) REFERENCES `mat_hang` (`Id_MatHang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel01.chi_tiet_don_nhap: ~40 rows (approximately)
INSERT INTO `chi_tiet_don_nhap` (`FK_Id_DonNhapHang`, `FK_Id_MatHang`, `count`) VALUES
	(47, 2, 3),
	(47, 2, 3),
	(48, 4, 5),
	(48, 3, 3),
	(48, 3, 5),
	(48, 4, 15),
	(48, 9, 3),
	(49, 6, 15),
	(50, 4, 8),
	(50, 8, 17),
	(51, 9, 8),
	(51, 9, 7),
	(51, 5, 5),
	(51, 5, 5),
	(51, 6, 8),
	(51, 3, 4),
	(51, 5, 5),
	(51, 3, 4),
	(51, 3, 4),
	(51, 4, 4),
	(51, 3, 5),
	(51, 5, 5),
	(51, 3, 4),
	(51, 1, 4),
	(51, 1, 4),
	(51, 1, 4),
	(51, 1, 3),
	(51, 10, 3),
	(52, 4, 4),
	(52, 2, 4),
	(52, 3, 123),
	(52, 11, 34),
	(52, 9, 3),
	(52, 10, 4),
	(52, 13, 2),
	(52, 11, 3),
	(52, 13, 3),
	(52, 12, 3),
	(52, 1, 4),
	(52, 8, 3);

-- Dumping structure for table laravel01.don_nhap_hang
CREATE TABLE IF NOT EXISTS `don_nhap_hang` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `FK_Id_NCC` bigint(20) unsigned NOT NULL,
  `TrangThai` enum('Đang chờ xử lý','Đã được xử lý','Đang vận chuyển','Hoàn thành') NOT NULL DEFAULT 'Đang chờ xử lý',
  `Ngay_DatHang` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `don_nhap_hang_fk_id_ncc_foreign` (`FK_Id_NCC`) USING BTREE,
  CONSTRAINT `don_nhap_hang_fk_id_ncc_foreign` FOREIGN KEY (`FK_Id_NCC`) REFERENCES `nha_cung_cap` (`Id_NCC`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel01.don_nhap_hang: ~51 rows (approximately)
INSERT INTO `don_nhap_hang` (`id`, `FK_Id_NCC`, `TrangThai`, `Ngay_DatHang`) VALUES
	(1, 1, 'Đã được xử lý', '2023-09-07'),
	(2, 2, 'Đang chờ xử lý', '2023-08-28'),
	(3, 2, 'Đã được xử lý', '2023-10-31'),
	(4, 1, 'Đã được xử lý', '2008-08-08'),
	(6, 2, 'Đang chờ xử lý', '2008-08-08'),
	(7, 1, 'Đang chờ xử lý', '2019-08-08'),
	(8, 3, 'Đang vận chuyển', '2020-09-09'),
	(9, 1, 'Đang chờ xử lý', '2019-09-09'),
	(10, 1, 'Đang chờ xử lý', '2019-09-09'),
	(11, 1, 'Đang chờ xử lý', '2019-09-09'),
	(12, 1, 'Đang chờ xử lý', '2019-09-09'),
	(13, 1, 'Đang chờ xử lý', '2019-09-09'),
	(14, 1, 'Đang chờ xử lý', '2019-09-09'),
	(15, 1, 'Đang chờ xử lý', '2019-09-09'),
	(16, 1, 'Đang chờ xử lý', '2019-09-09'),
	(17, 1, 'Đang chờ xử lý', '2019-09-09'),
	(18, 1, 'Đang chờ xử lý', '2016-12-31'),
	(19, 2, 'Đang chờ xử lý', '2018-02-27'),
	(20, 3, 'Đang vận chuyển', '2016-05-31'),
	(21, 3, 'Hoàn thành', '2018-05-23'),
	(22, 3, 'Đã được xử lý', '1026-02-08'),
	(23, 1, 'Đã được xử lý', '2008-08-08'),
	(24, 3, 'Đang chờ xử lý', '2017-08-08'),
	(25, 3, 'Đang chờ xử lý', '2018-02-08'),
	(26, 2, '', '2015-09-09'),
	(27, 2, 'Đang chờ xử lý', '2016-12-25'),
	(28, 2, 'Đang vận chuyển', '2018-02-05'),
	(29, 3, 'Đang chờ xử lý', '1254-09-09'),
	(30, 3, 'Đang chờ xử lý', '1254-09-09'),
	(31, 3, 'Đã được xử lý', '0215-08-09'),
	(32, 1, 'Đang chờ xử lý', '2018-02-04'),
	(33, 2, 'Đang chờ xử lý', '2018-02-09'),
	(34, 3, 'Đã được xử lý', '2015-08-09'),
	(35, 3, 'Đã được xử lý', '2015-08-09'),
	(36, 3, 'Đang chờ xử lý', '2016-12-31'),
	(37, 3, 'Đang chờ xử lý', '2016-12-31'),
	(38, 2, 'Đang vận chuyển', '2015-08-08'),
	(39, 2, 'Đang chờ xử lý', '2018-08-09'),
	(40, 2, 'Đang chờ xử lý', '2018-08-08'),
	(41, 2, 'Đang chờ xử lý', '2016-08-08'),
	(42, 2, 'Đang chờ xử lý', '2008-12-07'),
	(43, 2, 'Đang chờ xử lý', '1206-12-04'),
	(44, 2, 'Đang chờ xử lý', '0201-03-05'),
	(45, 1, 'Đã được xử lý', '2018-02-05'),
	(46, 2, 'Đã được xử lý', '2005-03-04'),
	(47, 2, 'Hoàn thành', '2017-08-08'),
	(48, 1, 'Đã được xử lý', '2018-07-05'),
	(49, 1, 'Đang vận chuyển', '2019-06-05'),
	(50, 3, 'Đang chờ xử lý', '2019-05-08'),
	(51, 1, 'Đang chờ xử lý', '2019-05-08'),
	(52, 1, 'Đã được xử lý', '2003-02-05');

-- Dumping structure for table laravel01.loai_hang
CREATE TABLE IF NOT EXISTS `loai_hang` (
  `Id_LoaiHang` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Ten_LoaiHang` varchar(255) NOT NULL,
  PRIMARY KEY (`Id_LoaiHang`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel01.loai_hang: ~3 rows (approximately)
INSERT INTO `loai_hang` (`Id_LoaiHang`, `Ten_LoaiHang`) VALUES
	(1, 'Điện thoại'),
	(2, 'Máy tính bảng'),
	(3, 'Laptop');

-- Dumping structure for table laravel01.mat_hang
CREATE TABLE IF NOT EXISTS `mat_hang` (
  `Id_MatHang` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Ten_MatHang` varchar(255) NOT NULL,
  `DonViTinh` varchar(255) NOT NULL,
  `DonGia` double NOT NULL,
  `FK_Id_LoaiHang` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`Id_MatHang`),
  KEY `mat_hang_fk_id_loaihang_foreign` (`FK_Id_LoaiHang`),
  CONSTRAINT `mat_hang_fk_id_loaihang_foreign` FOREIGN KEY (`FK_Id_LoaiHang`) REFERENCES `loai_hang` (`Id_LoaiHang`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel01.mat_hang: ~13 rows (approximately)
INSERT INTO `mat_hang` (`Id_MatHang`, `Ten_MatHang`, `DonViTinh`, `DonGia`, `FK_Id_LoaiHang`) VALUES
	(1, 'Iphone XS Max 64GB', 'Cái', 8000, 1),
	(2, 'Iphone 11 128GB', 'Cái', 10000, 1),
	(3, 'Iphone 11 Pro 512GB', 'Cái', 12690, 1),
	(4, 'Iphone 12 256GB', 'Cái', 13990, 1),
	(5, 'Iphone 12 Pro Max 128gb', 'Cái', 17990, 1),
	(6, 'Iphone 13 256GB', 'Cái', 20990, 1),
	(7, 'Iphone 13 256GB', 'Cái', 20990, 1),
	(8, 'Iphone 13 Pro 1TB', 'Cái', 25990, 1),
	(9, 'LAPTOP LENOVO GAMING 3 15ACH6 (82K2027QVN) (R5 5500H/8GB RAM/512GB', 'Cái', 25490, 3),
	(10, 'LAPTOP ASUS GAMING TUF FX507ZC4-HN074W (I5 12500H/8GB RAM/512GB', 'Cái', 30490, 3),
	(11, 'Samsung Galaxy S23 Ultra', 'Cái', 21500, 1),
	(12, 'iPad Air 5(2022) 256GB', 'Cái', 18890, 2),
	(13, 'iPad Pro 12.9 2021 M1 Wifi 256GB', 'Cái', 26990, 2);

-- Dumping structure for table laravel01.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel01.migrations: ~6 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(2, '2023_10_31_075032_create_nha_cung_caps_table', 1),
	(3, '2023_10_31_075324_create_loai_hang', 1),
	(4, '2023_10_31_075442_create_mat_hangs_table', 1),
	(5, '2023_10_31_075859_create_don_nhap_hangs_table', 1),
	(6, '2023_10_31_080129_create_chi_tiet_don_nhaps_table', 1);

-- Dumping structure for table laravel01.nha_cung_cap
CREATE TABLE IF NOT EXISTS `nha_cung_cap` (
  `Id_NCC` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Ten_NCC` varchar(50) NOT NULL,
  `Dia_Chi` varchar(255) NOT NULL,
  `Email` varchar(40) NOT NULL,
  PRIMARY KEY (`Id_NCC`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel01.nha_cung_cap: ~3 rows (approximately)
INSERT INTO `nha_cung_cap` (`Id_NCC`, `Ten_NCC`, `Dia_Chi`, `Email`) VALUES
	(1, 'CellphoneS', '133 Thái Hà, Đống Đa, Hà Nội', 'cellphones@gmail.com'),
	(2, 'Hoàng Hà Mobile', '122 Thái Hà, Đống Đa, Hà Nội', 'hoangha@gmail.com'),
	(3, 'Thế Giới Di Động', '11A Thái Hà, Đống Đa, Hà Nội', 'tgđ@gmail.com');

-- Dumping structure for table laravel01.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel01.personal_access_tokens: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
