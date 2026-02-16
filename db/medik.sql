/*
SQLyog Professional v13.1.1 (64 bit)
MySQL - 8.0.30 : Database - medik
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`medik` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `medik`;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `migrations` */

/*Table structure for table `t_antrian` */

DROP TABLE IF EXISTS `t_antrian`;

CREATE TABLE `t_antrian` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_pasien` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `umur` int NOT NULL,
  `alamat` text,
  `waktu_masuk` datetime NOT NULL,
  `status_kunjungan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `t_antrian` */

/*Table structure for table `t_detail` */

DROP TABLE IF EXISTS `t_detail`;

CREATE TABLE `t_detail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_riwayat` int DEFAULT NULL,
  `id_obat` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `t_detail` */

insert  into `t_detail`(`id`,`id_riwayat`,`id_obat`,`jumlah`,`created_at`,`updated_at`) values 
(8,38,2,1,'2026-02-09 07:44:53',NULL),
(9,39,3,1,'2026-02-09 07:48:02',NULL),
(10,40,2,1,'2026-02-09 07:52:05',NULL),
(11,41,2,1,'2026-02-09 07:54:30',NULL),
(12,42,2,1,'2026-02-09 08:29:55',NULL),
(13,42,3,1,'2026-02-09 08:29:55',NULL);

/*Table structure for table `t_farmasi` */

DROP TABLE IF EXISTS `t_farmasi`;

CREATE TABLE `t_farmasi` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `id_obat` int DEFAULT NULL,
  `kode_pasien` varchar(255) DEFAULT NULL,
  `catatan_obat` varchar(255) DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `t_farmasi` */

/*Table structure for table `t_obat` */

DROP TABLE IF EXISTS `t_obat`;

CREATE TABLE `t_obat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_obat` varchar(255) DEFAULT NULL,
  `stok` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `t_obat` */

insert  into `t_obat`(`id`,`nama_obat`,`stok`,`created_at`,`updated_at`) values 
(2,'Bodrex',56,'2026-02-07 23:49:56','2026-02-08 00:23:11'),
(3,'OBH',6,'2026-02-08 00:09:49','2026-02-08 00:09:49');

/*Table structure for table `t_pasien` */

DROP TABLE IF EXISTS `t_pasien`;

CREATE TABLE `t_pasien` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_pasien` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `umur` int DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `kelurahan` varchar(255) DEFAULT NULL,
  `kecamatan` varchar(255) DEFAULT NULL,
  `provinsi` varchar(255) DEFAULT NULL,
  `kode_pos` varchar(255) DEFAULT NULL,
  `status_kunjungan` enum('draft','antrian','pemeriksaan','ambil obat','selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `t_pasien` */

insert  into `t_pasien`(`id`,`kode_pasien`,`nama`,`umur`,`alamat`,`kelurahan`,`kecamatan`,`provinsi`,`kode_pos`,`status_kunjungan`,`created_at`,`updated_at`) values 
(42,'PS0001','aa',12,'aa','aa','aa','aa','aa','antrian','2026-02-09 06:08:23','2026-02-09 06:08:36'),
(44,'PS0003','zaky',18,'gg.sukaresmi','antapani','kiaracondong','jawa barat','3050','antrian','2026-02-09 07:49:12','2026-02-09 07:49:15'),
(45,'PS0004','adi nugroho',12,'gg.sukaresmi','antapani','aa','jawa barat','3050','antrian','2026-02-09 07:53:42','2026-02-09 07:53:44'),
(46,'PS0005','Lucky Wahyudiana, S.ST.',18,'gg.sukaresmi','caheum','Antapani','Jawa Barat','78291','antrian','2026-02-09 08:28:44','2026-02-09 08:28:46'),
(47,'PS0006','jek',18,'asdjasdiwa','jasdhasjd','asdbdwhba','aijdwjskd','2392','draft','2026-02-10 14:09:23','2026-02-10 14:09:23');

/*Table structure for table `t_pemeriksaan` */

DROP TABLE IF EXISTS `t_pemeriksaan`;

CREATE TABLE `t_pemeriksaan` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_pasien` varchar(255) DEFAULT NULL,
  `tinggi_badan` int NOT NULL,
  `berat_badan` int NOT NULL,
  `suhu_badan` decimal(4,1) DEFAULT NULL,
  `tensi` varchar(10) DEFAULT NULL,
  `status_kunjungan` varchar(255) DEFAULT NULL,
  `keluhan` text,
  `catatan_obat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `t_pemeriksaan` */

insert  into `t_pemeriksaan`(`id`,`kode_pasien`,`tinggi_badan`,`berat_badan`,`suhu_badan`,`tensi`,`status_kunjungan`,`keluhan`,`catatan_obat`,`created_at`) values 
(54,'PS0001',12,12,12.0,'12','selesai','aa','aa','2026-02-09 06:08:59'),
(55,'PS0002',170,68,37.0,'120/80','selesai','patah hati','pacar baru','2026-02-09 07:47:28'),
(56,'PS0003',170,45,36.0,'110/80','selesai','Nt mulu','Pacar baru','2026-02-09 07:51:38'),
(57,'PS0004',123,23,23.0,'23','selesai','aaa','aaa','2026-02-09 07:53:57'),
(58,'PS0005',180,68,37.0,'120/80','selesai','ga punya pacar','cari pacar lah goblok','2026-02-09 08:29:39');

/*Table structure for table `t_poli` */

DROP TABLE IF EXISTS `t_poli`;

CREATE TABLE `t_poli` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_poli` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `t_poli` */

insert  into `t_poli`(`id`,`nama_poli`,`created_at`,`updated_at`) values 
(1,'Poli Gigi edit','2026-02-07 03:36:09','2026-02-07 03:36:38'),
(2,'Poli Umum','2026-02-07 03:36:48','2026-02-07 03:36:48'),
(4,'Poli Anak','2026-02-07 03:37:04','2026-02-07 03:37:04');

/*Table structure for table `t_riwayat` */

DROP TABLE IF EXISTS `t_riwayat`;

CREATE TABLE `t_riwayat` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_pasien` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `tinggi_badan` decimal(10,0) DEFAULT NULL,
  `berat_badan` decimal(10,0) DEFAULT NULL,
  `tensi` varchar(100) DEFAULT NULL,
  `suhu_badan` decimal(4,1) DEFAULT NULL,
  `keluhan` text,
  `catatan_obat` text,
  `status_kunjungan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_pasien` (`kode_pasien`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `t_riwayat` */

insert  into `t_riwayat`(`id`,`kode_pasien`,`tanggal`,`tinggi_badan`,`berat_badan`,`tensi`,`suhu_badan`,`keluhan`,`catatan_obat`,`status_kunjungan`,`created_at`,`updated_at`) values 
(38,'PS0001','2026-02-09 07:44:53',12,12,'12',12.0,'aa','aa','selesai','2026-02-09 07:44:53',NULL),
(39,'PS0002','2026-02-09 07:48:02',170,68,'120/80',37.0,'patah hati','pacar baru','selesai','2026-02-09 07:48:02',NULL),
(40,'PS0003','2026-02-09 07:52:05',170,45,'110/80',36.0,'Nt mulu','Pacar baru','selesai','2026-02-09 07:52:05',NULL),
(41,'PS0004','2026-02-09 07:54:30',123,23,'23',23.0,'aaa','aaa','selesai','2026-02-09 07:54:30',NULL),
(42,'PS0005','2026-02-09 08:29:55',180,68,'120/80',37.0,'ga punya pacar','cari pacar lah goblok','selesai','2026-02-09 08:29:55',NULL);

/*Table structure for table `t_rujukan` */

DROP TABLE IF EXISTS `t_rujukan`;

CREATE TABLE `t_rujukan` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_pasien` varchar(20) DEFAULT NULL,
  `kode_rumah` int DEFAULT NULL,
  `catatan_rujukan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `t_rujukan` */

/*Table structure for table `t_rumah` */

DROP TABLE IF EXISTS `t_rumah`;

CREATE TABLE `t_rumah` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_rumah` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `t_rumah` */

insert  into `t_rumah`(`id`,`nama_rumah`,`created_at`,`updated_at`) values 
(1,'Santoyusuf','2026-02-07 07:48:24','2026-02-07 07:48:24');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_Poli` int DEFAULT NULL,
  `role` enum('Admin','Dokter','Farmasi') DEFAULT NULL,
  `status` enum('Aktif','Nonaktif') DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email_verified` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`id_Poli`,`role`,`status`,`avatar`,`email_verified`,`remember_token`,`created_at`,`updated_at`) values 
(5,'Claudia','Claudia@gmail.com','$2y$12$W9Xs8CokAtD05iFdNxh4be0BnIoc0YZx4/a/tB6DK73FdAwv9Tuyq',NULL,'Farmasi','Aktif','Farmasi/uqjTqoKtOwaMwqlRO1uiFIAxpK9iKVJYt2aSNNAo.jpg',NULL,NULL,'2026-02-07 04:18:43','2026-02-07 04:20:50'),
(6,'dokter','dokter@gmail.com','$2y$12$hXOmQChfaAHCl2/RKRSEoup24yMJMRwQX8YDZRX3iq.Ud9N80Zh36',4,'Dokter','Aktif','Dokter/PBBbW2hEIjYkPYHmjYFd7xFg5wrQpr9Df86O1a6S.jpg',NULL,NULL,'2026-02-07 07:33:46','2026-02-07 07:33:46'),
(8,'dzaky','admin@gmail.com','$2y$12$XgsqZxFhnWx8UuxET4LROOvMAIc23Pk1axsM6f3qzzQJ81/FD8YYm',NULL,'Admin',NULL,NULL,NULL,NULL,'2026-02-07 21:54:11','2026-02-07 21:54:11'),
(9,'yty','ty@gmail.com','$2y$12$j9PBZWgkofQNxPepcq9hfOmLe1Xvdx.2O4OXnyphiO6b0AFpzlffG',NULL,'Admin',NULL,NULL,NULL,NULL,'2026-02-08 05:30:15','2026-02-08 05:30:15'),
(10,'jek','jek@gmail.com','$2y$12$hL9RlB//GDIPr2M/LaB6n.ieExugkCh5Ctvh3rgWwoY/5E6LUwM3y',NULL,'Admin',NULL,NULL,NULL,NULL,'2026-02-10 13:59:58','2026-02-10 13:59:58');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
