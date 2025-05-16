-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 16, 2025 at 04:45 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_vikor`
--

-- --------------------------------------------------------

--
-- Table structure for table `bobot_kriteria`
--

CREATE TABLE `bobot_kriteria` (
  `id` int NOT NULL,
  `kriteria_id` int NOT NULL,
  `bobot` decimal(10,5) NOT NULL,
  `jenis` enum('ahp','vikor') COLLATE utf8mb3_swedish_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_swedish_ci;

--
-- Dumping data for table `bobot_kriteria`
--

INSERT INTO `bobot_kriteria` (`id`, `kriteria_id`, `bobot`, `jenis`, `created_at`, `updated_at`) VALUES
(1, 2, '0.20000', 'ahp', '2025-05-15 09:13:23', '2025-05-15 09:13:23'),
(2, 4, '0.10000', 'ahp', '2025-05-15 09:13:42', '2025-05-15 09:13:42'),
(4, 5, '0.05000', 'ahp', '2025-05-15 09:14:44', '2025-05-15 09:16:26'),
(5, 6, '0.10000', 'ahp', '2025-05-15 09:15:42', '2025-05-15 09:15:42'),
(6, 7, '0.15000', 'ahp', '2025-05-15 09:16:44', '2025-05-15 09:16:44'),
(7, 8, '0.05000', 'ahp', '2025-05-15 09:16:56', '2025-05-15 09:16:56'),
(8, 9, '0.10000', 'ahp', '2025-05-15 09:17:09', '2025-05-15 09:17:09'),
(9, 10, '0.05000', 'ahp', '2025-05-15 09:17:25', '2025-05-15 09:17:25'),
(10, 11, '0.05000', 'ahp', '2025-05-15 09:18:05', '2025-05-15 09:18:05'),
(11, 12, '0.15000', 'ahp', '2025-05-15 09:18:27', '2025-05-15 09:18:27'),
(12, 2, '0.25000', 'vikor', '2025-05-15 09:18:55', '2025-05-15 09:18:55'),
(13, 4, '0.10000', 'vikor', '2025-05-15 09:19:08', '2025-05-15 09:19:08'),
(14, 5, '0.05000', 'vikor', '2025-05-15 09:19:26', '2025-05-15 09:19:26'),
(15, 6, '0.05000', 'vikor', '2025-05-15 09:20:12', '2025-05-15 09:20:12'),
(16, 7, '0.15000', 'vikor', '2025-05-15 09:20:57', '2025-05-15 09:20:57'),
(17, 8, '0.05000', 'vikor', '2025-05-15 09:21:58', '2025-05-15 09:21:58'),
(18, 9, '0.10000', 'vikor', '2025-05-15 09:22:28', '2025-05-15 09:22:28'),
(19, 10, '0.05000', 'vikor', '2025-05-15 09:22:42', '2025-05-15 09:22:42'),
(20, 11, '0.05000', 'vikor', '2025-05-15 09:22:55', '2025-05-15 09:22:55'),
(21, 12, '0.15000', 'vikor', '2025-05-15 09:23:11', '2025-05-15 09:23:11');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_ahp`
--

CREATE TABLE `hasil_ahp` (
  `id` int NOT NULL,
  `kriteria_id` int NOT NULL,
  `bobot` decimal(10,5) NOT NULL,
  `lambda_max` decimal(10,5) DEFAULT NULL,
  `ci` decimal(10,5) DEFAULT NULL,
  `cr` decimal(10,5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `hasil_rekomendasi`
--

CREATE TABLE `hasil_rekomendasi` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `sekolah_id` int NOT NULL,
  `nilai_s` decimal(10,5) DEFAULT NULL,
  `nilai_r` decimal(10,5) DEFAULT NULL,
  `nilai_q` decimal(10,5) DEFAULT NULL,
  `peringkat` int DEFAULT NULL,
  `tanggal_rekomendasi` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_swedish_ci;

--
-- Dumping data for table `hasil_rekomendasi`
--

INSERT INTO `hasil_rekomendasi` (`id`, `user_id`, `sekolah_id`, `nilai_s`, `nilai_r`, `nilai_q`, `peringkat`, `tanggal_rekomendasi`) VALUES
(73, 3, 5, '0.05000', '0.05000', '0.00000', 1, '2025-05-16 04:40:51'),
(74, 3, 6, '0.76667', '0.25000', '0.84234', 2, '2025-05-16 04:40:51'),
(75, 3, 4, '0.97500', '0.25000', '1.00000', 3, '2025-05-16 04:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id` int NOT NULL,
  `kode` varchar(10) COLLATE utf8mb3_swedish_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb3_swedish_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb3_swedish_ci,
  `jenis` enum('benefit','cost') COLLATE utf8mb3_swedish_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_swedish_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id`, `kode`, `nama`, `deskripsi`, `jenis`, `created_at`, `updated_at`) VALUES
(2, 'C01', 'Akreditas Sekolah', 'Akreditas Sekolah', 'benefit', '2025-05-15 07:27:33', '2025-05-15 08:12:50'),
(4, 'C02', 'Jarak Lokasi', 'Jarak Lokasi', 'benefit', '2025-05-15 07:37:37', '2025-05-15 07:43:44'),
(5, 'C03', 'Biaya Pendaftaran', 'Biaya Pendaftaran', 'benefit', '2025-05-15 07:46:01', '2025-05-15 07:46:01'),
(6, 'C04', 'Biaya Spp', 'Biaya Spp', 'benefit', '2025-05-15 07:46:41', '2025-05-15 07:46:41'),
(7, 'C05', 'Fasilitas', 'Fasilitas', 'benefit', '2025-05-15 07:47:14', '2025-05-15 07:47:14'),
(8, 'C06', 'Atribut', 'Atribut', 'benefit', '2025-05-15 07:47:43', '2025-05-15 07:47:43'),
(9, 'C07', 'Waktu Pembelajaran', 'Waktu Pembelajaran', 'benefit', '2025-05-15 07:48:22', '2025-05-15 07:48:22'),
(10, 'C08', 'Jumlah Wali Kelas', 'Jumlah Wali Kelas', 'benefit', '2025-05-15 07:49:12', '2025-05-15 07:49:12'),
(11, 'C09', 'Jumlah Perkelas', 'Jumlah Perkelas', 'benefit', '2025-05-15 07:49:49', '2025-05-15 07:49:49'),
(12, 'C10', 'Jumlah Guru', 'Jumlah Guru', 'benefit', '2025-05-15 07:50:14', '2025-05-15 07:50:14');

-- --------------------------------------------------------

--
-- Table structure for table `matriks_perbandingan_ahp`
--

CREATE TABLE `matriks_perbandingan_ahp` (
  `id` int NOT NULL,
  `kriteria_baris` int NOT NULL,
  `kriteria_kolom` int NOT NULL,
  `nilai` decimal(10,5) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nilai_tk`
--

CREATE TABLE `nilai_tk` (
  `id` int NOT NULL,
  `sekolah_id` int NOT NULL,
  `kriteria_id` int NOT NULL,
  `nilai` decimal(10,2) NOT NULL,
  `subkriteria_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_swedish_ci;

--
-- Dumping data for table `nilai_tk`
--

INSERT INTO `nilai_tk` (`id`, `sekolah_id`, `kriteria_id`, `nilai`, `subkriteria_id`, `created_at`, `updated_at`) VALUES
(11, 5, 2, '4.00', 17, '2025-05-16 02:49:23', '2025-05-16 02:49:23'),
(12, 5, 4, '4.00', 21, '2025-05-16 02:49:23', '2025-05-16 02:49:23'),
(13, 5, 5, '4.00', 25, '2025-05-16 02:49:23', '2025-05-16 02:49:23'),
(14, 5, 6, '4.00', 29, '2025-05-16 02:49:23', '2025-05-16 02:49:23'),
(15, 5, 7, '4.00', 33, '2025-05-16 02:49:23', '2025-05-16 02:49:23'),
(16, 5, 8, '4.00', 37, '2025-05-16 02:49:23', '2025-05-16 02:49:23'),
(17, 5, 9, '4.00', 46, '2025-05-16 02:49:23', '2025-05-16 02:49:23'),
(18, 5, 10, '4.00', 41, '2025-05-16 02:49:23', '2025-05-16 02:49:23'),
(19, 5, 11, '1.00', 52, '2025-05-16 02:49:23', '2025-05-16 02:49:23'),
(20, 5, 12, '4.00', 53, '2025-05-16 02:49:23', '2025-05-16 02:49:23'),
(21, 6, 2, '2.00', 19, '2025-05-16 02:58:37', '2025-05-16 02:58:37'),
(22, 6, 4, '3.00', 22, '2025-05-16 02:58:37', '2025-05-16 02:58:37'),
(23, 6, 5, '3.00', 26, '2025-05-16 02:58:37', '2025-05-16 02:58:37'),
(24, 6, 6, '3.00', 30, '2025-05-16 02:58:37', '2025-05-16 02:58:37'),
(25, 6, 7, '2.00', 35, '2025-05-16 02:58:37', '2025-05-16 02:58:37'),
(26, 6, 8, '2.00', 39, '2025-05-16 02:58:37', '2025-05-16 02:58:37'),
(27, 6, 9, '3.00', 47, '2025-05-16 02:58:37', '2025-05-16 02:58:37'),
(28, 6, 10, '3.00', 42, '2025-05-16 02:58:37', '2025-05-16 02:58:37'),
(29, 6, 11, '3.00', 50, '2025-05-16 02:58:37', '2025-05-16 02:58:37'),
(30, 6, 12, '2.00', 55, '2025-05-16 02:58:37', '2025-05-16 02:58:37'),
(31, 4, 2, '2.00', 19, '2025-05-16 02:59:37', '2025-05-16 02:59:37'),
(32, 4, 4, '2.00', 23, '2025-05-16 02:59:37', '2025-05-16 02:59:37'),
(33, 4, 5, '1.00', 28, '2025-05-16 02:59:37', '2025-05-16 02:59:37'),
(34, 4, 6, '2.00', 31, '2025-05-16 02:59:37', '2025-05-16 02:59:37'),
(35, 4, 7, '2.00', 35, '2025-05-16 02:59:37', '2025-05-16 02:59:37'),
(36, 4, 8, '2.00', 39, '2025-05-16 02:59:37', '2025-05-16 02:59:37'),
(37, 4, 9, '2.00', 48, '2025-05-16 02:59:37', '2025-05-16 02:59:37'),
(38, 4, 10, '2.00', 43, '2025-05-16 02:59:37', '2025-05-16 02:59:37'),
(39, 4, 11, '2.00', 51, '2025-05-16 02:59:37', '2025-05-16 02:59:37'),
(40, 4, 12, '2.00', 55, '2025-05-16 02:59:37', '2025-05-16 02:59:37');

-- --------------------------------------------------------

--
-- Table structure for table `parameter_vikor`
--

CREATE TABLE `parameter_vikor` (
  `id` int NOT NULL,
  `nilai_v` decimal(5,2) DEFAULT '0.50',
  `keterangan` text COLLATE utf8mb3_swedish_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_swedish_ci;

--
-- Dumping data for table `parameter_vikor`
--

INSERT INTO `parameter_vikor` (`id`, `nilai_v`, `keterangan`, `created_at`, `updated_at`) VALUES
(7, '0.70', 'Nilai v berdasarkan rata-rata preferensi user 3', '2025-05-16 04:40:51', '2025-05-16 04:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `preferensi_orangtua`
--

CREATE TABLE `preferensi_orangtua` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `kriteria_id` int NOT NULL,
  `nilai_preferensi` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_swedish_ci;

--
-- Dumping data for table `preferensi_orangtua`
--

INSERT INTO `preferensi_orangtua` (`id`, `user_id`, `kriteria_id`, `nilai_preferensi`, `created_at`, `updated_at`) VALUES
(2, 3, 2, '5.00', '2025-05-15 14:57:46', '2025-05-15 14:57:46'),
(3, 3, 4, '5.00', '2025-05-15 14:57:46', '2025-05-15 14:57:46'),
(4, 3, 5, '5.00', '2025-05-15 14:57:46', '2025-05-15 14:57:46'),
(5, 3, 6, '5.00', '2025-05-15 14:57:46', '2025-05-15 14:57:46'),
(6, 3, 7, '5.00', '2025-05-15 14:57:46', '2025-05-15 14:57:46'),
(7, 3, 8, '5.00', '2025-05-15 14:57:46', '2025-05-15 14:57:46'),
(8, 3, 9, '5.00', '2025-05-15 14:57:46', '2025-05-15 14:57:46'),
(9, 3, 10, '5.00', '2025-05-15 14:57:46', '2025-05-15 14:57:46'),
(10, 3, 11, '5.00', '2025-05-15 14:57:46', '2025-05-15 14:57:46'),
(11, 3, 12, '5.00', '2025-05-15 14:57:46', '2025-05-15 14:57:46');

-- --------------------------------------------------------

--
-- Table structure for table `sekolah_tk`
--

CREATE TABLE `sekolah_tk` (
  `id` int NOT NULL,
  `nama_tk` varchar(100) COLLATE utf8mb3_swedish_ci NOT NULL,
  `alamat` text COLLATE utf8mb3_swedish_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb3_swedish_ci,
  `kontak` varchar(15) COLLATE utf8mb3_swedish_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb3_swedish_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb3_swedish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_swedish_ci;

--
-- Dumping data for table `sekolah_tk`
--

INSERT INTO `sekolah_tk` (`id`, `nama_tk`, `alamat`, `deskripsi`, `kontak`, `email`, `latitude`, `longitude`, `foto`, `created_at`, `updated_at`) VALUES
(4, 'Tk Tunas Harapan (pim)', 'l. Singgalang Komp, Tambon Tunong, Kec. Dewantara, Kabupaten Aceh Utara, Aceh', 'Tk Tunas Harapan (pim)', '0852-7700-3404', 'email@gmail.com', '5.22557055', '97.03173202', '1747325328', '2025-05-15 16:08:48', '2025-05-15 16:09:56'),
(5, 'TK Bhayangkari', 'Jalan Tgk. Chik Ditiro, Lancang Garam, Kec. Banda Sakti, Kota Lhokseumawe, Aceh\r\n', 'TK Bhayangkari', '082165443677', 'email@gmail.com', '5.19859121', '97.14565249', '1747325433', '2025-05-15 16:10:33', '2025-05-15 16:13:55'),
(6, 'Tk Islam Fajar Meulia', 'Bluka Teubai, Kec. Dewantara, Kabupaten Aceh Utara, Aceh\r\n', 'Tk Islam Fajar Meulia', '082165443677', 'email@gmail.com', '5.25258687', '97.00966545', '1747325612', '2025-05-15 16:13:32', '2025-05-15 16:13:50');

-- --------------------------------------------------------

--
-- Table structure for table `subkriteria`
--

CREATE TABLE `subkriteria` (
  `id` int NOT NULL,
  `kriteria_id` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb3_swedish_ci NOT NULL,
  `nilai` int NOT NULL,
  `keterangan` text COLLATE utf8mb3_swedish_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_swedish_ci;

--
-- Dumping data for table `subkriteria`
--

INSERT INTO `subkriteria` (`id`, `kriteria_id`, `nama`, `nilai`, `keterangan`, `created_at`, `updated_at`) VALUES
(17, 2, 'Sangat Baik', 4, 'A', '2025-05-15 08:13:22', '2025-05-15 08:13:22'),
(18, 2, 'Baik', 3, 'B', '2025-05-15 08:13:34', '2025-05-15 08:13:34'),
(19, 2, 'Cukup', 2, 'C', '2025-05-15 08:13:55', '2025-05-15 08:13:55'),
(20, 2, 'Kurang', 1, 'Tidak Terakreditas', '2025-05-15 08:14:52', '2025-05-15 08:14:52'),
(21, 4, 'Sangat  Dekat', 4, '< 1 km', '2025-05-15 08:15:24', '2025-05-15 08:15:24'),
(22, 4, 'Dekat', 3, '1 - 2 km', '2025-05-15 08:16:00', '2025-05-15 08:16:00'),
(23, 4, 'Jauh', 2, ' 2 - 3.5 km', '2025-05-15 08:16:27', '2025-05-15 10:12:37'),
(24, 4, 'Sangat Jauh', 1, '> 3.5 km', '2025-05-15 08:16:53', '2025-05-15 09:34:09'),
(25, 5, 'Sangat Murah', 4, '< 250 Ribu', '2025-05-15 08:17:35', '2025-05-15 08:17:35'),
(26, 5, 'Murah', 3, '250 - 400 Ribu', '2025-05-15 08:18:36', '2025-05-15 08:19:47'),
(28, 5, 'Mahal', 1, '> 550 Ribu', '2025-05-15 08:20:31', '2025-05-15 09:34:16'),
(29, 6, 'Sangat Murah', 4, '< 100 Ribu', '2025-05-15 08:21:05', '2025-05-15 08:21:05'),
(30, 6, 'Murah', 3, '100 - 150 Ribu', '2025-05-15 08:21:28', '2025-05-15 08:21:28'),
(31, 6, 'Cukup Mahal ', 2, '150 - 200 Ribu', '2025-05-15 08:21:53', '2025-05-15 08:21:53'),
(32, 6, 'Mahal', 1, '> 200 Ribu', '2025-05-15 08:22:13', '2025-05-15 09:34:25'),
(33, 7, 'Lengkap', 4, 'Fasilitas Lengkap', '2025-05-15 08:22:49', '2025-05-15 08:22:49'),
(34, 7, 'Baik', 3, 'Fasilitas Baik', '2025-05-15 08:23:10', '2025-05-15 08:23:10'),
(35, 7, 'Cukup', 2, 'Fasilitas Cukup', '2025-05-15 08:24:01', '2025-05-15 08:24:01'),
(36, 7, 'Kurang ', 1, 'Fasilitas Kurang', '2025-05-15 08:24:45', '2025-05-15 08:24:45'),
(37, 8, 'Sangat Lengkap', 4, 'Atribut Sangat Lengkap', '2025-05-15 08:25:30', '2025-05-15 08:25:30'),
(38, 8, 'Baik', 3, 'Atribut Biak', '2025-05-15 08:25:59', '2025-05-15 08:26:31'),
(39, 8, 'Cukup', 2, 'Atribut Cukup', '2025-05-15 08:26:51', '2025-05-15 08:26:51'),
(40, 8, 'Kurang', 1, 'Kurang', '2025-05-15 08:27:40', '2025-05-15 08:27:40'),
(41, 10, 'Banyak', 4, '> 3', '2025-05-15 08:29:21', '2025-05-15 08:32:09'),
(42, 10, 'Cukup', 3, '2', '2025-05-15 08:29:36', '2025-05-15 08:32:17'),
(43, 10, 'Kurang', 2, '1', '2025-05-15 08:29:57', '2025-05-15 08:32:37'),
(44, 10, 'Tidak Ada', 1, '0', '2025-05-15 08:30:30', '2025-05-15 08:32:28'),
(45, 11, 'Ideal ', 4, '< 10', '2025-05-15 08:31:30', '2025-05-15 08:31:30'),
(46, 9, 'Full Time ', 4, '> 6 Jam', '2025-05-15 08:33:07', '2025-05-15 08:33:07'),
(47, 9, 'Normal', 3, '5 - 5.9 Jam', '2025-05-15 08:33:42', '2025-05-15 08:33:42'),
(48, 9, 'Pendek', 2, '4 - 4.9 Jam', '2025-05-15 08:34:10', '2025-05-15 08:34:10'),
(49, 9, 'Sangat Pendek', 1, '< 4 Jam', '2025-05-15 08:34:45', '2025-05-15 08:34:45'),
(50, 11, 'Cukup Ideal ', 3, '11 -15', '2025-05-15 08:35:07', '2025-05-15 08:35:30'),
(51, 11, 'Ramai', 2, '16 - 20 ', '2025-05-15 08:35:54', '2025-05-15 08:35:54'),
(52, 11, 'Sangat Ramai', 1, '20', '2025-05-15 08:36:15', '2025-05-15 08:36:15'),
(53, 12, 'Sangat Baik', 4, '> 8 ', '2025-05-15 08:36:41', '2025-05-15 08:36:41'),
(54, 12, 'Baik', 3, '6 - 7', '2025-05-15 08:37:24', '2025-05-15 08:37:37'),
(55, 12, 'Cukup', 2, '4 -5 ', '2025-05-15 08:38:11', '2025-05-15 08:38:34'),
(56, 12, 'Kurang', 1, '< 4', '2025-05-15 08:38:52', '2025-05-15 08:38:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb3_swedish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb3_swedish_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb3_swedish_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb3_swedish_ci DEFAULT NULL,
  `no_telp` varchar(15) COLLATE utf8mb3_swedish_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb3_swedish_ci,
  `role` enum('admin','orangtua') COLLATE utf8mb3_swedish_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `email`, `no_telp`, `alamat`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'Administrator', 'admin@gmail.com', NULL, NULL, 'admin', '2025-05-14 07:12:38', '2025-05-14 07:12:38'),
(3, 'Khairul122', '12345', 'Khairul Huda', 'khairulhuda242@gmail.com', '082165443677', 'Aceh', 'orangtua', '2025-05-14 07:34:30', '2025-05-14 07:34:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bobot_kriteria`
--
ALTER TABLE `bobot_kriteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kriteria_id` (`kriteria_id`);

--
-- Indexes for table `hasil_ahp`
--
ALTER TABLE `hasil_ahp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kriteria_id` (`kriteria_id`);

--
-- Indexes for table `hasil_rekomendasi`
--
ALTER TABLE `hasil_rekomendasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sekolah_id` (`sekolah_id`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `matriks_perbandingan_ahp`
--
ALTER TABLE `matriks_perbandingan_ahp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kriteria_baris` (`kriteria_baris`),
  ADD KEY `kriteria_kolom` (`kriteria_kolom`);

--
-- Indexes for table `nilai_tk`
--
ALTER TABLE `nilai_tk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sekolah_id` (`sekolah_id`),
  ADD KEY `kriteria_id` (`kriteria_id`),
  ADD KEY `subkriteria_id` (`subkriteria_id`);

--
-- Indexes for table `parameter_vikor`
--
ALTER TABLE `parameter_vikor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `preferensi_orangtua`
--
ALTER TABLE `preferensi_orangtua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `kriteria_id` (`kriteria_id`);

--
-- Indexes for table `sekolah_tk`
--
ALTER TABLE `sekolah_tk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subkriteria`
--
ALTER TABLE `subkriteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kriteria_id` (`kriteria_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bobot_kriteria`
--
ALTER TABLE `bobot_kriteria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `hasil_ahp`
--
ALTER TABLE `hasil_ahp`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `hasil_rekomendasi`
--
ALTER TABLE `hasil_rekomendasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `matriks_perbandingan_ahp`
--
ALTER TABLE `matriks_perbandingan_ahp`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1301;

--
-- AUTO_INCREMENT for table `nilai_tk`
--
ALTER TABLE `nilai_tk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `parameter_vikor`
--
ALTER TABLE `parameter_vikor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `preferensi_orangtua`
--
ALTER TABLE `preferensi_orangtua`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sekolah_tk`
--
ALTER TABLE `sekolah_tk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subkriteria`
--
ALTER TABLE `subkriteria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bobot_kriteria`
--
ALTER TABLE `bobot_kriteria`
  ADD CONSTRAINT `bobot_kriteria_ibfk_1` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hasil_ahp`
--
ALTER TABLE `hasil_ahp`
  ADD CONSTRAINT `hasil_ahp_ibfk_1` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hasil_rekomendasi`
--
ALTER TABLE `hasil_rekomendasi`
  ADD CONSTRAINT `hasil_rekomendasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hasil_rekomendasi_ibfk_2` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolah_tk` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `matriks_perbandingan_ahp`
--
ALTER TABLE `matriks_perbandingan_ahp`
  ADD CONSTRAINT `matriks_perbandingan_ahp_ibfk_1` FOREIGN KEY (`kriteria_baris`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matriks_perbandingan_ahp_ibfk_2` FOREIGN KEY (`kriteria_kolom`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nilai_tk`
--
ALTER TABLE `nilai_tk`
  ADD CONSTRAINT `nilai_tk_ibfk_1` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolah_tk` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_tk_ibfk_2` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_tk_ibfk_3` FOREIGN KEY (`subkriteria_id`) REFERENCES `subkriteria` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `preferensi_orangtua`
--
ALTER TABLE `preferensi_orangtua`
  ADD CONSTRAINT `preferensi_orangtua_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `preferensi_orangtua_ibfk_2` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subkriteria`
--
ALTER TABLE `subkriteria`
  ADD CONSTRAINT `subkriteria_ibfk_1` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
