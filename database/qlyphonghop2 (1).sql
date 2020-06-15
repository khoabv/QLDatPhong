-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2020 at 11:09 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlyphonghop2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cuochop`
--

CREATE TABLE `cuochop` (
  `id` int(11) NOT NULL,
  `tencuochop` int(11) NOT NULL,
  `noidungcuochop` varchar(10000) COLLATE utf8_unicode_ci NOT NULL,
  `trangthai` int(11) NOT NULL,
  `noidungtongket` varchar(10000) COLLATE utf8_unicode_ci NOT NULL,
  `idphong` int(11) NOT NULL,
  `idfiledinhkem` int(11) NOT NULL,
  `thoigianbatdau` datetime NOT NULL,
  `thoigianketthuc` datetime NOT NULL,
  `idlichtrinh` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `tenfile` int(11) NOT NULL,
  `linkfile` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lichtrinh.vue`
--

CREATE TABLE `lichtrinh` (
  `id` int(11) NOT NULL,
  `idphong` int(11) NOT NULL,
  `idnguoidat` int(11) NOT NULL,
  `thoigianbatdau` datetime NOT NULL,
  `thoigianketthuc` datetime NOT NULL,
  `loailichtrinh` int(11) NOT NULL,
  `trangthai` int(11) NOT NULL COMMENT 'trạng thái lịch trình'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phonghop`
--

CREATE TABLE `phonghop` (
  `id` int(11) NOT NULL,
  `ten_phong` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mo_ta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trang_thai` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `phonghop`
--

INSERT INTO `phonghop` (`id`, `ten_phong`, `mo_ta`, `trang_thai`, `created_at`, `updated_at`) VALUES
(3, 'phòng 2', 'đây là phòng 2', 'Rảnh', '2020-04-15 19:35:39', '2020-04-15 19:35:39'),
(4, 'Phòng 3', 'Đây là phòng 3', 'Rảnh', '2020-04-15 19:39:11', '2020-04-15 12:39:11');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `option` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `hoTen` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `moTa` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thanhvien`
--

CREATE TABLE `thanhvien` (
  `id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `id_cuochop` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thongbao`
--

CREATE TABLE `thongbao` (
  `id` int(11) NOT NULL,
  `tieude` int(11) NOT NULL,
  `noidung` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `loaithongbao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'Đoàn Cảnh Thống 1', 'admin@gmail.com', '$2y$10$Rp6DMu2JL1MYJUoWiVvH1.zKWsPH96lf8oRBSgeTDRztfelLrwP6a', 'user', NULL, '2020-03-25 09:59:43', '2020-03-29 11:57:27'),
(10, '3AE Shop', 'admin333@gmail.com', '$2y$10$o12juS7CLmgh5X61Jel0CuwtBSjqJAzq/RYJNrq.1pcuI0n6rJ4j2', 'user', NULL, '2020-03-25 10:20:15', '2020-03-25 10:20:15'),
(11, 'NGUYỄN VĂN THIỆN222', 'admin1@gmail.com11111', '$2y$10$m4iO7xmrsISmN5IwueTJzeePHafXpFxbkHUK5kw8h23v.fcZfH/sy', 'user', NULL, '2020-03-25 10:21:27', '2020-03-25 10:21:27'),
(14, 'Đoàn Cảnh Thống222', 'admin1122@gmail.com', '$2y$10$5KjC730NDrTYZxjEOJLKuOSB7IIDR.c0A3.UNc4BcpOREOEbfg/7.', 'user', NULL, '2020-03-25 10:24:37', '2020-03-25 10:24:37'),
(15, 'Đoàn Cảnh Thống222', 'admin11222@gmail.com', '$2y$10$5KjC730NDrTYZxjEOJLKuOSB7IIDR.c0A3.UNc4BcpOREOEbfg/7.', 'user', '', '2020-03-25 10:24:37', '2020-03-25 10:24:37'),
(16, 'Chu Dai Admin', 'admin12@gmail.com', '$2y$10$Ty7oCPZCWeZSoLbEXeBEPelV19qwFBVXfZbYcqkn1kLjxcTkjSVc2', 'admin', '', '2020-03-17 08:57:43', '2020-03-17 08:57:43'),
(17, 'Đoàn Cảnh Thống', 'admin13@gmail.com', '$2y$10$754GVeBX1RvnJVQI.naDFeFBqNIO2xplML1EhMZ0k6pgc16IAveQi', 'user', '', '2020-03-25 09:59:43', '2020-03-25 09:59:43'),
(18, '3AE Shop', 'admin14@gmail.com', '$2y$10$DzISZZr9Ypezw.HS./x3K.az/2ELSHI2rsEErZfe8/ZTYRmN8Ypai', 'user', '', '2020-03-25 10:15:43', '2020-03-25 10:15:43'),
(19, '3AE Shop', 'admin15@gmail.com', '$2y$10$o12juS7CLmgh5X61Jel0CuwtBSjqJAzq/RYJNrq.1pcuI0n6rJ4j2', 'user', '', '2020-03-25 10:20:15', '2020-03-25 10:20:15'),
(20, 'NGUYỄN VĂN THIỆN222', 'admin16@gmail.com', '$2y$10$m4iO7xmrsISmN5IwueTJzeePHafXpFxbkHUK5kw8h23v.fcZfH/sy', 'user', '', '2020-03-25 10:21:27', '2020-03-25 10:21:27'),
(21, 'Đoàn Cảnh Thống222', 'admin17@gmail.com', '$2y$10$5KjC730NDrTYZxjEOJLKuOSB7IIDR.c0A3.UNc4BcpOREOEbfg/7.', 'user', '', '2020-03-25 10:24:37', '2020-03-25 10:24:37'),
(22, 'Đoàn Cảnh Thống222', 'admin18@gmail.com', '$2y$10$5KjC730NDrTYZxjEOJLKuOSB7IIDR.c0A3.UNc4BcpOREOEbfg/7.', 'user', '', '2020-03-25 10:24:37', '2020-03-25 10:24:37'),
(23, 'Người dùng 1', 'nguoidung1@gmail.com', '$2y$10$hd4P2ycs4QnDQ9wDox2Xxun4tzqEh7BLDPzWjuExaZck6ItRoICbm', 'user', NULL, '2020-03-28 05:25:33', '2020-03-28 05:25:33'),
(24, 'nguyễn văn a1', 'nuguyenvana@gmail.com', '$2y$10$QnG5Be6PpYll6IHvyetmi.NKHemQOo.KJ3/I/TtK4ZqJuQleWS3Xe', 'user', NULL, '2020-03-29 10:44:45', '2020-03-29 10:45:54'),
(25, 'aaaaaaaaa', 'adminaaaaaa@gmail.com', '$2y$10$WG3Rq7/Bsx5//92buYnPIeVUGEXYrnjQslON72/7UQcpb8jhAWqo6', 'user', NULL, '2020-04-15 11:27:28', '2020-04-15 11:27:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cuochop`
--
ALTER TABLE `cuochop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_CUOCHOP_PHONGHOP` (`idphong`),
  ADD KEY `FK_FILE` (`idfiledinhkem`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lichtrinh.vue`
--
ALTER TABLE `lichtrinh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_PHONGHOP_LT` (`idphong`),
  ADD KEY `FK_USER` (`idnguoidat`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phonghop`
--
ALTER TABLE `phonghop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thanhvien`
--
ALTER TABLE `thanhvien`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_CUOCHOP` (`id_cuochop`);

--
-- Indexes for table `thongbao`
--
ALTER TABLE `thongbao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_USER_TB` (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cuochop`
--
ALTER TABLE `cuochop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lichtrinh.vue`
--
ALTER TABLE `lichtrinh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phonghop`
--
ALTER TABLE `phonghop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `thanhvien`
--
ALTER TABLE `thanhvien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thongbao`
--
ALTER TABLE `thongbao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cuochop`
--
ALTER TABLE `cuochop`
  ADD CONSTRAINT `FK_CUOCHOP_PHONGHOP` FOREIGN KEY (`idphong`) REFERENCES `phonghop` (`id`),
  ADD CONSTRAINT `FK_FILE` FOREIGN KEY (`idfiledinhkem`) REFERENCES `file` (`id`);

--
-- Constraints for table `lichtrinh.vue`
--
ALTER TABLE `lichtrinh`
  ADD CONSTRAINT `FK_PHONGHOP_LT` FOREIGN KEY (`idphong`) REFERENCES `phonghop` (`id`),
  ADD CONSTRAINT `FK_USER` FOREIGN KEY (`idnguoidat`) REFERENCES `users` (`id`);

--
-- Constraints for table `thanhvien`
--
ALTER TABLE `thanhvien`
  ADD CONSTRAINT `FK_CUOCHOP` FOREIGN KEY (`id_cuochop`) REFERENCES `cuochop` (`id`);

--
-- Constraints for table `thongbao`
--
ALTER TABLE `thongbao`
  ADD CONSTRAINT `FK_USER_TB` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
