/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : qlyphonghop

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-06-02 22:37:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cuochop
-- ----------------------------
DROP TABLE IF EXISTS `cuochop`;
CREATE TABLE `cuochop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tencuochop` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `noidungcuochop` varchar(10000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trangthai` int(11) NOT NULL,
  `noidungtongket` varchar(10000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idphong` int(11) NOT NULL,
  `idfiledinhkem` int(11) DEFAULT NULL,
  `idlichtrinh` int(11) NOT NULL,
  `deleted` int(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_CUOCHOP_PHONGHOP` (`idphong`),
  KEY `FK_FILE` (`idfiledinhkem`),
  CONSTRAINT `FK_CUOCHOP_PHONGHOP` FOREIGN KEY (`idphong`) REFERENCES `phonghop` (`id`),
  CONSTRAINT `FK_FILE` FOREIGN KEY (`idfiledinhkem`) REFERENCES `file` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of cuochop
-- ----------------------------
INSERT INTO `cuochop` VALUES ('18', 'Họp bàn kế hoạch du lịch hè 2020', 'Họp lúc 14h30', '0', null, '4', null, '25', '0');
INSERT INTO `cuochop` VALUES ('19', 'sdfasdf', 'ádfa', '0', 'ádfasd', '4', null, '25', '0');
INSERT INTO `cuochop` VALUES ('20', 'dgh', 'ghdfgh', '0', 'dgfh', '4', null, '4', '1');
INSERT INTO `cuochop` VALUES ('21', 'ten cuoc hop', 'asdfad', '0', 'asdfasd', '4', null, '4', '1');

-- ----------------------------
-- Table structure for file
-- ----------------------------
DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenfile` int(11) NOT NULL,
  `linkfile` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of file
-- ----------------------------

-- ----------------------------
-- Table structure for lichtrinh
-- ----------------------------
DROP TABLE IF EXISTS `lichtrinh`;
CREATE TABLE `lichtrinh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idphong` int(11) NOT NULL,
  `idnguoidat` int(11) NOT NULL,
  `thoigianbatdau` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `thoigianketthuc` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `loailichtrinh` int(11) NOT NULL,
  `trangthai` int(11) NOT NULL COMMENT 'trạng thái lịch trình',
  `ngaybatdau` date NOT NULL,
  `ngayketthuc` date DEFAULT NULL,
  `thu` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `malichtrinh` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` int(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_PHONGHOP_LT` (`idphong`),
  KEY `FK_USER` (`idnguoidat`),
  CONSTRAINT `FK_PHONGHOP_LT` FOREIGN KEY (`idphong`) REFERENCES `phonghop` (`id`),
  CONSTRAINT `FK_USER` FOREIGN KEY (`idnguoidat`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lichtrinh
-- ----------------------------
INSERT INTO `lichtrinh` VALUES ('1', '3', '5', '07:00', '09:30', '0', '0', '2020-05-25', '2020-05-20', '4', '2020-05-20 23:51:07', '2020-05-20 23:51:07', '20200520869', '1');
INSERT INTO `lichtrinh` VALUES ('2', '3', '5', '07:00', '09:30', '0', '0', '2020-05-25', '2020-05-20', '4', '2020-05-20 23:52:28', '2020-05-23 13:12:48', '20200520198', '1');
INSERT INTO `lichtrinh` VALUES ('3', '4', '17', '07:00', '09:30', '0', '0', '2020-05-26', '2020-05-26', '3', '2020-05-20 23:58:50', '2020-05-28 21:07:33', '20200520867', '0');
INSERT INTO `lichtrinh` VALUES ('4', '4', '5', '07:00', '09:30', '0', '0', '2020-05-25', '2020-05-20', '4', '2020-05-21 00:02:53', '2020-05-21 00:02:53', '20200521488', '0');
INSERT INTO `lichtrinh` VALUES ('5', '4', '16', '07:00', '09:30', '0', '0', '2020-05-26', '2020-05-26', '3', '2020-05-21 00:05:03', '2020-05-28 20:54:25', '20200521169', '0');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------

-- ----------------------------
-- Table structure for phonghop
-- ----------------------------
DROP TABLE IF EXISTS `phonghop`;
CREATE TABLE `phonghop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ten_phong` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mo_ta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trang_thai` int(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `loai_phong` int(2) NOT NULL,
  `soluong` int(11) NOT NULL,
  `deleted` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of phonghop
-- ----------------------------
INSERT INTO `phonghop` VALUES ('2', 'Phong hop 2', 'day la phong hop 2', '0', '2020-06-01 23:55:27', '2020-06-01 23:55:35', '1', '4', '0');
INSERT INTO `phonghop` VALUES ('3', 'phòng Họp', 'đây là phòng họp', '0', '2020-04-19 22:40:18', '2020-04-19 22:40:18', '1', '1', '0');
INSERT INTO `phonghop` VALUES ('4', 'Phòng Phỏng vấn', 'Đây là phòng phỏng vấn', '0', '2020-04-19 22:40:27', '2020-05-19 11:15:22', '2', '5', '0');

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `option` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of settings
-- ----------------------------

-- ----------------------------
-- Table structure for thanhvien
-- ----------------------------
DROP TABLE IF EXISTS `thanhvien`;
CREATE TABLE `thanhvien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `id_cuochop` int(11) NOT NULL,
  `deleted` int(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_CUOCHOP` (`id_cuochop`),
  CONSTRAINT `FK_CUOCHOP` FOREIGN KEY (`id_cuochop`) REFERENCES `cuochop` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of thanhvien
-- ----------------------------
INSERT INTO `thanhvien` VALUES ('25', 'daicq.dev@gmail.com', '20', '0');
INSERT INTO `thanhvien` VALUES ('26', ' quangdai2904@gmail.com', '20', '0');
INSERT INTO `thanhvien` VALUES ('27', 'quangdai2904@gmail.com', '21', '0');
INSERT INTO `thanhvien` VALUES ('28', 'daicq.dev@gmail.com', '21', '0');
INSERT INTO `thanhvien` VALUES ('29', 'alone01011991@gmail.com', '21', '0');

-- ----------------------------
-- Table structure for thongbao
-- ----------------------------
DROP TABLE IF EXISTS `thongbao`;
CREATE TABLE `thongbao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tieude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `noidung` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `userid` int(11) NOT NULL,
  `loaithongbao` int(11) NOT NULL,
  `deleted` int(1) DEFAULT 0,
  `isRead` int(1) DEFAULT NULL,
  `link` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `FK_USER_TB` (`userid`),
  CONSTRAINT `FK_USER_TB` FOREIGN KEY (`userid`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of thongbao
-- ----------------------------
INSERT INTO `thongbao` VALUES ('40', 'Yêu cầu nhượng phòng', 'Bạn có một yêu cầu nhượng phòng từ email nguoidung@gmail.com cho đặt phòng có mã \'20200520198\';\n            Tên phòng: \'.phòng Họp.\'; Vào thời gian \' - \'; 4; Ngày: \'2020-05-25\'', '5', '0', '0', '1', 'http://localhost:8000/lichtrinh/yeucaunhuongphong/detail/5', null, null);
INSERT INTO `thongbao` VALUES ('41', 'Yêu cầu nhượng phòng', 'Bạn có một yêu cầu nhượng phòng từ email nguoidung@gmail.com cho đặt phòng có mã \'20200520867\';\n            Tên phòng: \'.Phòng Phỏng vấn.\'; Vào thời gian \' - \'; 4; Ngày: \'2020-05-25\'', '5', '0', '0', '1', 'http://localhost:8000/lichtrinh/yeucaunhuongphong/detail/6', null, null);
INSERT INTO `thongbao` VALUES ('46', 'Duyệt yêu cầu nhượng phòng', 'Yêu cầu nhương phòng của bạn đã đã được chấp nhận; Thông tin đặt phòng: \n Mã đăt phòng: 20200520198;\n            Tên phòng phòng Họp; Vào thời gian 00:00:00-01:30:00; 4; Ngày: 2020-05-25\n\n             Truy cập: <a href=\'http://localhost:8000/lichtrinh/yeucaunhuongphong/detail/5\'>chi tiết yêu cầu nhượng phòng</a>', '10', '0', '0', '1', null, null, null);
INSERT INTO `thongbao` VALUES ('47', 'Yêu cầu nhượng phòng', 'Bạn có một yêu cầu nhượng phòng từ email nguoidung@gmail.com cho đặt phòng có mã \'20200520869\';\n            Tên phòng: \'.phòng Họp.\'; Vào thời gian \' - \'; 4; Ngày: \'2020-05-25\'', '5', '0', '0', '1', 'http://localhost:8000/lichtrinh/yeucaunhuongphong/detail/7', null, null);
INSERT INTO `thongbao` VALUES ('48', 'Xử lý yêu cầu nhượng phòng', 'Yêu cầu nhương phòng của bạn đã đã bị từ chối; Thông tin đặt phòng: \n Mã đăt phòng: 20200520198;\n            Tên phòng phòng Họp; Vào thời gian 00:00:00-01:30:00; 4; Ngày: 2020-05-25\n\n             Truy cập: <a href=\'http://localhost:8000/lichtrinh/yeucaunhuongphong/detail/5\'>chi tiết yêu cầu nhượng phòng</a>', '10', '0', '0', '0', null, null, null);
INSERT INTO `thongbao` VALUES ('49', 'Yêu cầu nhượng phòng', 'Bạn có một yêu cầu nhượng phòng từ email nguoidung@gmail.com cho đặt phòng có mã 20200521488;\n            Tên phòng: Phòng Phỏng vấn; Vào thời gian  - ; 4; Ngày: .2020-05-25', '5', '0', '0', '0', 'http://localhost:8000/lichtrinh/yeucaunhuongphong/detail/8', null, null);
INSERT INTO `thongbao` VALUES ('50', 'Yêu cầu nhượng phòng', 'Bạn có một yêu cầu nhượng phòng từ email nguoidung@gmail.com cho đặt phòng có mã 20200521488;\n            Tên phòng: Phòng Phỏng vấn; Vào thời gian  - ; 4; Ngày: .2020-05-25', '5', '0', '0', '0', 'http://localhost:8000/lichtrinh/yeucaunhuongphong/detail/9', null, null);
INSERT INTO `thongbao` VALUES ('51', 'Yêu cầu nhượng phòng', 'Bạn có một yêu cầu nhượng phòng từ email nguoidung@gmail.com cho đặt phòng có mã 20200521488;\n            Tên phòng: Phòng Phỏng vấn; Vào thời gian  - ; 4; Ngày: .2020-05-25', '5', '0', '0', '1', 'http://localhost:8000/lichtrinh/yeucaunhuongphong/detail/10', '2020-05-21 21:17:15', '2020-05-21 21:17:15');
INSERT INTO `thongbao` VALUES ('52', 'Chuyển nhượng phòng', 'Admin đã chuyển nhương thành công lịch đặt phòng cho tài khoản admin@gmail.com; thông tin đặt phòng: Tên phòng phòng Họp; Vào thời gian 00:00:00-01:30:00; 4; Ngày: 2020-05-25', '5', '0', '0', '1', null, '2020-05-23 13:13:41', '2020-05-23 13:13:41');
INSERT INTO `thongbao` VALUES ('53', 'Đặt lịch', 'Admin đã đặt lịch cho bạn phòng Phòng Phỏng vấn vào thời gian 07:00-09:30 thứ 3, 2020-05-26 00:00:00', '26', '0', '0', null, null, '2020-05-28 20:52:22', '2020-05-28 20:52:22');
INSERT INTO `thongbao` VALUES ('54', 'Đặt lịch', 'Admin đã đặt lịch cho bạn phòng Phòng Phỏng vấn vào thời gian 07:00-09:30 thứ 3, 2020-05-26 00:00:00', '16', '0', '0', null, null, '2020-05-28 20:55:16', '2020-05-28 20:55:16');
INSERT INTO `thongbao` VALUES ('55', 'Đặt lịch', 'Admin đã đặt lịch cho bạn phòng Phòng Phỏng vấn vào thời gian 07:00-09:30 thứ 3, 2020-05-26 00:00:00', '17', '0', '0', null, null, '2020-05-28 21:07:38', '2020-05-28 21:07:38');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `isActive` int(1) DEFAULT NULL,
  `deleted` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('5', 'Admin', 'admin@gmail.com', '$2y$10$kEM1SKwTS93nLMgZX2RCIeko0trkD2QKmg/nhxPJAgu3FTivn4fSm', 'admin', null, '2020-03-25 16:59:43', '2020-03-29 18:57:27', '1', '0');
INSERT INTO `users` VALUES ('10', 'Người dùng', 'nguoidung@gmail.com', '$2y$10$kEM1SKwTS93nLMgZX2RCIeko0trkD2QKmg/nhxPJAgu3FTivn4fSm', 'user', null, '2020-03-25 17:20:15', '2020-03-25 17:20:15', '1', '0');
INSERT INTO `users` VALUES ('11', 'NGUYỄN VĂN THIỆN222', 'admin1@gmail.com11111', '$2y$10$m4iO7xmrsISmN5IwueTJzeePHafXpFxbkHUK5kw8h23v.fcZfH/sy', 'user', null, '2020-03-25 17:21:27', '2020-03-25 17:21:27', '1', '0');
INSERT INTO `users` VALUES ('14', 'Đoàn Cảnh Thống222', 'admin1122@gmail.com', '$2y$10$5KjC730NDrTYZxjEOJLKuOSB7IIDR.c0A3.UNc4BcpOREOEbfg/7.', 'user', null, '2020-03-25 17:24:37', '2020-03-25 17:24:37', '1', '0');
INSERT INTO `users` VALUES ('15', 'Đoàn Cảnh Thống222', 'admin11222@gmail.com', '$2y$10$5KjC730NDrTYZxjEOJLKuOSB7IIDR.c0A3.UNc4BcpOREOEbfg/7.', 'user', '', '2020-03-25 17:24:37', '2020-03-25 17:24:37', '1', '0');
INSERT INTO `users` VALUES ('16', 'Chu Dai Admin', 'admin12@gmail.com', '$2y$10$Ty7oCPZCWeZSoLbEXeBEPelV19qwFBVXfZbYcqkn1kLjxcTkjSVc2', 'admin', '', '2020-03-17 15:57:43', '2020-03-17 15:57:43', '1', '0');
INSERT INTO `users` VALUES ('17', 'Đoàn Cảnh Thống', 'admin13@gmail.com', '$2y$10$754GVeBX1RvnJVQI.naDFeFBqNIO2xplML1EhMZ0k6pgc16IAveQi', 'user', '', '2020-03-25 16:59:43', '2020-03-25 16:59:43', '1', '0');
INSERT INTO `users` VALUES ('18', '3AE Shop', 'admin14@gmail.com', '$2y$10$DzISZZr9Ypezw.HS./x3K.az/2ELSHI2rsEErZfe8/ZTYRmN8Ypai', 'user', '', '2020-03-25 17:15:43', '2020-03-25 17:15:43', '1', '0');
INSERT INTO `users` VALUES ('19', '3AE Shop', 'admin15@gmail.com', '$2y$10$o12juS7CLmgh5X61Jel0CuwtBSjqJAzq/RYJNrq.1pcuI0n6rJ4j2', 'user', '', '2020-03-25 17:20:15', '2020-03-25 17:20:15', '1', '0');
INSERT INTO `users` VALUES ('20', 'NGUYỄN VĂN THIỆN222', 'admin16@gmail.com', '$2y$10$m4iO7xmrsISmN5IwueTJzeePHafXpFxbkHUK5kw8h23v.fcZfH/sy', 'user', '', '2020-03-25 17:21:27', '2020-03-25 17:21:27', '1', '0');
INSERT INTO `users` VALUES ('21', 'Đoàn Cảnh Thống222', 'admin17@gmail.com', '$2y$10$5KjC730NDrTYZxjEOJLKuOSB7IIDR.c0A3.UNc4BcpOREOEbfg/7.', 'user', '', '2020-03-25 17:24:37', '2020-03-25 17:24:37', '1', '0');
INSERT INTO `users` VALUES ('22', 'Đoàn Cảnh Thống222', 'admin18@gmail.com', '$2y$10$5KjC730NDrTYZxjEOJLKuOSB7IIDR.c0A3.UNc4BcpOREOEbfg/7.', 'user', '', '2020-03-25 17:24:37', '2020-03-25 17:24:37', '1', '0');
INSERT INTO `users` VALUES ('23', 'Người dùng 1', 'nguoidung1@gmail.com', '$2y$10$hd4P2ycs4QnDQ9wDox2Xxun4tzqEh7BLDPzWjuExaZck6ItRoICbm', 'user', null, '2020-03-28 12:25:33', '2020-03-28 12:25:33', '1', '0');
INSERT INTO `users` VALUES ('24', 'nguyễn văn a1', 'nuguyenvana@gmail.com', '$2y$10$QnG5Be6PpYll6IHvyetmi.NKHemQOo.KJ3/I/TtK4ZqJuQleWS3Xe', 'user', null, '2020-03-29 17:44:45', '2020-03-29 17:45:54', '1', '0');
INSERT INTO `users` VALUES ('25', 'aaaaaaaaa', 'adminaaaaaa@gmail.com', '$2y$10$axTYM4zEpOwsa8Wv3ZK2W.LW0Ck2Kwz9bESe7S0EaP3vKNZ3I9uKS', 'admin', null, '2020-04-15 18:27:28', '2020-05-14 14:29:39', '1', '0');
INSERT INTO `users` VALUES ('26', 'nguoidungmoi', 'nguoidungmoi@gmail.com', '$2y$10$UJnLUtqyKzi33N74Ml/IAeJNdYPdTQL1FSiM/OWaiN/QdqcGxnERy', 'user', null, '2020-05-14 14:33:05', '2020-05-14 14:33:05', '1', '0');
INSERT INTO `users` VALUES ('27', 'nguoidungmoi', 'nguoidungmoi@gmail.com', '$2y$10$izi/m77bhUUWBebCArP1D./ZfSrjPINOsW0c8BKwSr2l.BonhPHGK', 'user', null, '2020-05-14 14:33:05', '2020-05-14 14:33:05', '1', '0');
INSERT INTO `users` VALUES ('28', 'nguoidungmoi', 'nguoidungmoi@gmail.com', '$2y$10$Bjs5fpKSPPlQIwxRpd6M5ObmKKVTJdRyRTsm2D4jE9u0vMrNYZyAK', 'user', null, '2020-05-14 14:33:06', '2020-05-14 14:33:06', '1', '0');
INSERT INTO `users` VALUES ('29', 'nguoidungmoi', 'nguoidungmoi@gmail.com', '$2y$10$QG9NLbCPSi61.vBEHcvu1efqUnAMsyw1bg4ANNBYdq6oGDb8SesmG', 'user', null, '2020-05-14 14:33:07', '2020-05-14 14:33:07', '1', '0');
INSERT INTO `users` VALUES ('30', 'nguoidungmoi', 'nguoidungmoi@gmail.com', '$2y$10$3gXhkLD9IdTeZqiKf9Jex.0MVIMzVUiK6SDBHkfiLcYmp87l8ilL2', 'user', null, '2020-05-14 14:33:08', '2020-05-14 14:33:08', '1', '0');
INSERT INTO `users` VALUES ('31', 'nguoidungmoi', 'nguoidungmoi@gmail.com', '$2y$10$jgAGgwLhSnjycIYjD0Qmyu6w58z1ajna/72BjsUVIM6iGIwr.BrEm', 'user', null, '2020-05-14 14:33:09', '2020-05-14 14:33:09', '1', '1');
INSERT INTO `users` VALUES ('32', 'nguoidungmoi', 'nguoidungmoi@gmail.com', '$2y$10$9seTaWDGtFrUP.ANds1bJuDACQnKgF1odZ1j91hdRa3ChBTX1p/ae', 'user', null, '2020-05-14 14:33:11', '2020-05-14 14:33:11', '1', '1');
INSERT INTO `users` VALUES ('33', 'nguoidungmoi', 'nguoidungmoi@gmail.com', '$2y$10$pGAk1JruKbvUdLpB8uPiEOK2PKAft20XDWLa8PyF4fp/lCzPzgyYy', 'user', null, '2020-05-14 14:33:12', '2020-05-17 17:34:56', '0', '1');
INSERT INTO `users` VALUES ('36', 'CHU QUANG DAI', 'themmoi@gmail.com', '$2y$10$Y80C750BRrXUUvY5O2iIMuAGmtKM7bKAkY3FhgzYqYQldrjlYNa3W', 'user', null, '2020-05-23 05:51:20', '2020-05-23 05:51:20', null, '1');
INSERT INTO `users` VALUES ('38', 'chu quang dai', 'chudai@gmail.com', '$2y$10$K.5riA.PacNANmK6t4o7AejQQ18cFiWnskzz5qbFD.w700USc4U3S', 'user', null, '2020-05-25 22:31:14', '2020-05-25 22:31:14', null, '0');

-- ----------------------------
-- Table structure for yeucaunhuongphong
-- ----------------------------
DROP TABLE IF EXISTS `yeucaunhuongphong`;
CREATE TABLE `yeucaunhuongphong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idlichtrinh` int(11) NOT NULL,
  `idnguoidat` int(11) NOT NULL,
  `idnguoiyeucau` int(11) NOT NULL,
  `lydo` varchar(255) NOT NULL,
  `trangthai` int(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yeucaunhuongphong
-- ----------------------------
INSERT INTO `yeucaunhuongphong` VALUES ('1', '2', '5', '10', 'ly do 2', '0', '2020-05-21 20:31:08', '2020-05-21 20:31:08');
INSERT INTO `yeucaunhuongphong` VALUES ('2', '1', '5', '10', 'sxdsdad', '0', '2020-05-21 20:31:08', '2020-05-21 20:31:08');
INSERT INTO `yeucaunhuongphong` VALUES ('3', '1', '5', '10', 'sxdsdad', '0', '2020-05-21 20:31:08', '2020-05-21 20:31:08');
INSERT INTO `yeucaunhuongphong` VALUES ('4', '1', '5', '10', 'ly do', '0', '2020-05-21 20:31:08', '2020-05-21 20:31:08');
INSERT INTO `yeucaunhuongphong` VALUES ('5', '2', '5', '10', 'ly do', '2', '2020-05-21 20:51:04', '2020-05-21 20:51:04');
INSERT INTO `yeucaunhuongphong` VALUES ('6', '3', '5', '10', 'Tao muon may nhuong phong lai cho tao', '0', null, null);
INSERT INTO `yeucaunhuongphong` VALUES ('7', '1', '5', '10', 'nhuong phong cho tao nhe', '0', null, null);
INSERT INTO `yeucaunhuongphong` VALUES ('8', '4', '5', '10', 'ewr gsd gsd gsda gsda gsdag dsa asdg asd g', '0', null, null);
INSERT INTO `yeucaunhuongphong` VALUES ('9', '4', '5', '10', 'sdf asdf dasf adsf ds as', '0', null, null);
INSERT INTO `yeucaunhuongphong` VALUES ('10', '4', '5', '10', 'svbgs gsadf sdafads', '0', null, null);
