-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 02, 2021 at 11:44 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_apt`
--
CREATE DATABASE IF NOT EXISTS `db_apt` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_apt`;

-- --------------------------------------------------------

--
-- Table structure for table `data_biaya_kerusakan`
--

DROP TABLE IF EXISTS `data_biaya_kerusakan`;
CREATE TABLE IF NOT EXISTS `data_biaya_kerusakan` (
  `id_biaya_kerusakan` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`id_biaya_kerusakan`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_biaya_kerusakan`
--

INSERT INTO `data_biaya_kerusakan` (`id_biaya_kerusakan`, `id_transaksi`, `keterangan`, `jumlah`) VALUES
(1, 1, 'C1', 1000),
(2, 1, 'C2', 2000),
(3, 13, 'sssd', 1000),
(4, 13, 'l;mol', 19000),
(5, 23, 'Coba 1', 20000);

-- --------------------------------------------------------

--
-- Table structure for table `data_biaya_tambahan`
--

DROP TABLE IF EXISTS `data_biaya_tambahan`;
CREATE TABLE IF NOT EXISTS `data_biaya_tambahan` (
  `id_biaya_tambahan` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`id_biaya_tambahan`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_biaya_tambahan`
--

INSERT INTO `data_biaya_tambahan` (`id_biaya_tambahan`, `id_transaksi`, `keterangan`, `jumlah`) VALUES
(1, 1, 'Biaya Administrasi.', 20000),
(2, 7, 'Biaya Administrasi.', 20000),
(3, 8, 'Biaya Administrasi.', 20000),
(4, 9, 'Biaya Administrasi.', 20000),
(5, 10, 'Biaya Administrasi.', 20000),
(6, 11, 'Biaya Administrasi.', 20000),
(7, 12, 'Biaya Administrasi.', 20000),
(8, 13, 'Biaya Administrasi.', 20000),
(9, 14, 'Biaya Administrasi.', 20000),
(10, 15, 'Biaya Administrasi.', 20000),
(11, 16, 'Biaya Administrasi.', 20000),
(12, 17, 'Biaya Administrasi.', 20000),
(13, 18, 'Biaya Administrasi.', 20000),
(14, 19, 'Biaya Administrasi.', 20000),
(15, 20, 'Biaya Administrasi.', 20000),
(16, 21, 'Biaya Administrasi.', 20000),
(17, 23, 'Biaya Administrasi.', 20000),
(18, 24, 'Biaya Administrasi.', 20000),
(19, 25, 'Biaya Administrasi.', 20000),
(20, 26, 'Biaya Administrasi.', 20000),
(21, 27, 'Biaya Administrasi.', 20000),
(22, 28, 'Biaya Administrasi.', 20000),
(23, 29, 'Biaya Administrasi.', 20000),
(24, 30, 'Biaya Administrasi.', 20000),
(25, 31, 'Biaya Administrasi.', 20000),
(26, 32, 'Biaya Administrasi.', 20000),
(27, 33, 'Biaya Administrasi.', 20000),
(28, 34, 'Biaya Administrasi.', 20000),
(29, 35, 'Biaya Administrasi.', 20000),
(30, 36, 'Biaya Administrasi.', 20000);

-- --------------------------------------------------------

--
-- Table structure for table `data_kategori`
--

DROP TABLE IF EXISTS `data_kategori`;
CREATE TABLE IF NOT EXISTS `data_kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(25) NOT NULL,
  `deskripsi` text NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_kategori`
--

INSERT INTO `data_kategori` (`id_kategori`, `nama_kategori`, `deskripsi`) VALUES
(1, 'Telur Burung', 'ini telur burung puyuh'),
(2, 'Telur Asin', 'kjmi'),
(3, 'telur ayam', ''),
(4, 'telur bebek', '');

-- --------------------------------------------------------

--
-- Table structure for table `data_konfigurasi_menu_pelanggan`
--

DROP TABLE IF EXISTS `data_konfigurasi_menu_pelanggan`;
CREATE TABLE IF NOT EXISTS `data_konfigurasi_menu_pelanggan` (
  `id_konfigurasi_menu_pelanggan` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `parent` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `konfigurasi_css` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_konfigurasi_menu_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_konfigurasi_menu_pelanggan`
--

INSERT INTO `data_konfigurasi_menu_pelanggan` (`id_konfigurasi_menu_pelanggan`, `nama`, `parent`, `url`, `konfigurasi_css`) VALUES
(1, 'Beranda', 0, '/apt', ''),
(2, 'Produk', 0, '/apt/?content=produk', ''),
(3, 'Transaksi', 0, '/apt/?content=transaksi', ''),
(12, 'Kontak', 0, '/apt/?content=kontak', ''),
(13, '&lt;i class=&quot;fa fa-cog&quot;&gt;&lt;/i&gt;', 0, '#', 'fz-18'),
(14, 'Profil', 13, '/apt/?content=profil', ''),
(15, 'Login', 13, 'login.php', ''),
(16, 'Register', 13, 'register.php', ''),
(17, 'Logout', 13, '/apt/?content=login_proses&amp;proses=logout', '');

-- --------------------------------------------------------

--
-- Table structure for table `data_konfigurasi_umum`
--

DROP TABLE IF EXISTS `data_konfigurasi_umum`;
CREATE TABLE IF NOT EXISTS `data_konfigurasi_umum` (
  `id_konfigurasi_umum` int(11) NOT NULL AUTO_INCREMENT,
  `nama_konfigurasi` varchar(255) NOT NULL,
  `nilai_konfigurasi` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id_konfigurasi_umum`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_konfigurasi_umum`
--

INSERT INTO `data_konfigurasi_umum` (`id_konfigurasi_umum`, `nama_konfigurasi`, `nilai_konfigurasi`, `keterangan`) VALUES
(1, 'biaya_administrasi', '20000', 'Biaya administrasi untuk setiap transaksi.'),
(2, 'no_rek_transaksi', '0901111111111111111', 'Bank BRI Atas Nama : Bla bla bla'),
(3, 'biaya_administrasi', '20000', 'Biaya panjar bagi pelanggan.'),
(4, 'office_address', 'Jl. Griya Pajjaiyang Indah Blok C No.1, Kel. Sudiang Raya, Kec. Biringkanaya, Kota Makassar, Sulawesi Selatan 90324', 'Alamat Kantor : Jl. Griya Pajjaiyang Indah Blok C No.1, Kel. Sudiang Raya, Kec. Biringkanaya, Kota Makassar, Sulawesi Selatan 90324'),
(5, 'phone_number', '+62 852 1029 1210', 'No. Telp : +62 852 1029 1210'),
(6, 'official_website', 'http://www.aryanspider.blogspot.com', 'Situs Resmi : http://www.aryanspider.blogspot.com'),
(7, 'official_email', 'aryan@stimednp.ac.id', 'Email Resmi : aryan@stimednp.ac.id'),
(8, 'open_hours', 'Senin-Jumat, pukul 08:00 AM â€“ 06:00 PM WITA', 'Jam Kerja : Senin-Jumat, pukul 08:00 AM â€“ 06:00 PM WITA');

-- --------------------------------------------------------

--
-- Table structure for table `data_kurir`
--

DROP TABLE IF EXISTS `data_kurir`;
CREATE TABLE IF NOT EXISTS `data_kurir` (
  `id_kurir` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kurir` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `status_akun` enum('aktif','non_aktif') NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `foto` varchar(255) NOT NULL,
  PRIMARY KEY (`id_kurir`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_kurir`
--

INSERT INTO `data_kurir` (`id_kurir`, `nama_kurir`, `username`, `password`, `alamat`, `status_akun`, `email`, `no_hp`, `foto`) VALUES
(1, 'kurir', 'kurir', 'bb31e9f1f03ad601eb8fb53e4f663039', 'jl hikkeh ', 'aktif', 'ariantampan@ymail.com', '085341725235', 'assets/img/kurir/cdec8f020bd6caa8ad7669ff80503a388d310c90.jpg'),
(2, 'kurir2', 'kurir2', '4a638ff5af016fec1cb4e368bef50235', 'btp blok h bau', 'aktif', 'kui@gmail.com', '08122343322', 'Array');

-- --------------------------------------------------------

--
-- Table structure for table `data_laporan_arus_kas`
--

DROP TABLE IF EXISTS `data_laporan_arus_kas`;
CREATE TABLE IF NOT EXISTS `data_laporan_arus_kas` (
  `id_laporan_arus_kas` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_transaksi` enum('masuk','keluar') NOT NULL,
  `id_no_transaksi` varchar(32) NOT NULL,
  `tgl_transaksi` datetime NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  PRIMARY KEY (`id_laporan_arus_kas`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_laporan_arus_kas`
--

INSERT INTO `data_laporan_arus_kas` (`id_laporan_arus_kas`, `jenis_transaksi`, `id_no_transaksi`, `tgl_transaksi`, `keterangan`, `kuantitas`, `harga`) VALUES
(4, 'masuk', 'TR-20200407233714', '2020-04-07 23:37:14', '0', 0, 140000),
(5, 'keluar', '9', '2020-04-08 00:00:00', 'Pembelian tanggal 2020-04-08 00:00:00', 0, 5400000),
(6, 'keluar', '10', '2020-04-08 00:00:00', 'Pembelian tanggal 2020-04-08 00:00:00', 0, 1450000),
(7, 'keluar', '11', '2020-04-08 00:00:00', 'Pembelian tanggal 2020-04-08 00:00:00', 0, 2675000),
(8, 'masuk', 'TR-20200901204643', '2020-09-01 20:46:43', 'Penjualan tanggal 2020-09-01 20:46:43', 0, 38000),
(9, 'masuk', 'TR-20200901210709', '2020-09-01 21:07:09', 'Penjualan tanggal 2020-09-01 21:07:09', 0, 26000),
(10, 'keluar', '12', '2020-09-11 00:00:00', 'Pembelian tanggal 2020-09-11 00:00:00', 0, 0),
(11, 'keluar', '13', '2020-09-11 00:00:00', 'Pembelian tanggal 2020-09-11 00:00:00', 0, 50000),
(12, 'masuk', 'TR-20200911161656', '2020-09-11 16:16:56', 'Penjualan tanggal 2020-09-11 16:16:56', 0, 29000),
(13, 'masuk', 'TR-20200912182600', '2020-09-12 18:26:00', 'Penjualan tanggal 2020-09-12 18:26:00', 0, 520000),
(14, 'keluar', '14', '2020-09-14 00:00:00', 'Pembelian tanggal 2020-09-14 00:00:00', 0, 20000),
(15, 'masuk', 'TR-20200914145734', '2020-09-14 14:57:34', 'Penjualan tanggal 2020-09-14 14:57:34', 0, 128000),
(16, 'masuk', 'TR-20200912183103', '2020-09-12 18:31:03', 'Penjualan tanggal 2020-09-12 18:31:03', 0, 56000),
(17, 'masuk', 'TR-20200917235643', '2020-09-17 23:56:43', 'Penjualan tanggal 2020-09-17 23:56:43', 0, 117500),
(18, 'masuk', 'TR-20200918002109', '2020-09-18 00:21:09', 'Penjualan tanggal 2020-09-18 00:21:09', 0, 24000),
(19, 'masuk', 'TR-20201107220727', '2020-11-07 22:07:27', 'Penjualan tanggal 2020-11-07 22:07:27', 16, 340000);

-- --------------------------------------------------------

--
-- Table structure for table `data_pelanggan`
--

DROP TABLE IF EXISTS `data_pelanggan`;
CREATE TABLE IF NOT EXISTS `data_pelanggan` (
  `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pelanggan` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `status_akun` enum('aktif','non_aktif','blokir') NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `user_token` varchar(32) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `foto_ktp` varchar(255) NOT NULL,
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_pelanggan`
--

INSERT INTO `data_pelanggan` (`id_pelanggan`, `nama_pelanggan`, `username`, `password`, `alamat`, `status_akun`, `email`, `no_hp`, `foto`, `user_token`, `nik`, `foto_ktp`) VALUES
(2, 'Pelanggan', 'pelanggan', '7f78f06d2d1262a0a222ca9834b15d9d', 'btp', 'aktif', 'ariantampan@ymail.com', '085341725235', 'assets/img/pelanggan/eb998a13168da0cb1fe51ba116ae6c4888069bbe.png', '', '', ''),
(22, 'tioooo', '123', '202cb962ac59075b964b07152d234b70', 'Jl. Daeng Tata 1. BTN. Tabaria Blok G8 No. 6', 'aktif', 'refatgafari300@gmail.com', '082193035842', 'assets/img/pelanggan/9121b9361ed43b6dca3ffcc635fb08d1fc6bb9e6.gif', 'ipe0v_17tmd5lubr2soygf96k', '7371110101960015', 'assets/img/ktp/deed77fcb74e08ed89dcd403a9da549ad3b4f6f6.jpg'),
(23, 'jj', 'jj', 'bf2bc2545a4a5f5683d9ef3ed0d977e0', 'jj', 'blokir', 'ibent95tuny@gmail.com', '00', 'assets/img/pelanggan/68f843ca7cb2962784d0a6969e5f4e7572ed66e1.jpg', '1de_n87tjiuk593frpvhm0syc', '99', 'assets/img/ktp/95f67ea266a93d80beec5982f583997ba1c7b20e.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `data_pengguna`
--

DROP TABLE IF EXISTS `data_pengguna`;
CREATE TABLE IF NOT EXISTS `data_pengguna` (
  `id_pengguna` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pengguna` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `jenis_akun` enum('admin','owner') NOT NULL,
  `status_akun` enum('aktif','non_aktif') NOT NULL,
  `email` varchar(30) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `foto` varchar(255) NOT NULL,
  PRIMARY KEY (`id_pengguna`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_pengguna`
--

INSERT INTO `data_pengguna` (`id_pengguna`, `nama_pengguna`, `username`, `password`, `jenis_akun`, `status_akun`, `email`, `no_hp`, `foto`) VALUES
(1, 'Admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'aktif', 'arians999@gmail.com', '085341725235', 'assets/img/pengguna/c62f3b30b46254ccd345438aa56b58aa4f194075.jpg'),
(2, 'Owner', 'owner', '72122ce96bfec66e2396d2e25225d70a', 'owner', 'aktif', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `data_riwayat_pembayaran`
--

DROP TABLE IF EXISTS `data_riwayat_pembayaran`;
CREATE TABLE IF NOT EXISTS `data_riwayat_pembayaran` (
  `id_riwayat_pembayaran` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) NOT NULL DEFAULT '0',
  `jumlah` int(11) NOT NULL DEFAULT '0',
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `info_pembayaran` enum('transfer','ditempat') NOT NULL DEFAULT 'ditempat',
  `tgl_pembayaran` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `konfirmasi_admin` enum('belum','ya','tidak') NOT NULL DEFAULT 'belum',
  PRIMARY KEY (`id_riwayat_pembayaran`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_riwayat_pembayaran`
--

INSERT INTO `data_riwayat_pembayaran` (`id_riwayat_pembayaran`, `id_transaksi`, `jumlah`, `bukti_pembayaran`, `info_pembayaran`, `tgl_pembayaran`, `konfirmasi_admin`) VALUES
(1, 1, 8000, '', 'ditempat', '0000-00-00 00:00:00', 'belum'),
(2, 3, 20000, '', 'ditempat', '0000-00-00 00:00:00', 'belum'),
(3, 4, 2000, 'assets/img/bukti_pembayaran/187361c5b2d0f1b0add6924a5e2de23a4834c4d3.png', 'transfer', '0000-00-00 00:00:00', 'belum'),
(4, 8, 30000, '', 'ditempat', '0000-00-00 00:00:00', 'belum'),
(5, 9, 32000, '', 'ditempat', '0000-00-00 00:00:00', 'belum'),
(7, 11, 140000, '', 'ditempat', '2020-04-07 22:37:19', 'belum'),
(8, 12, 38000, 'assets/img/bukti_pembayaran/f0f128389377d7e901fee9815f8e0d521d6724e7.png', 'transfer', '2020-09-01 20:47:52', 'belum'),
(9, 13, 26000, '', 'ditempat', '2020-09-01 21:07:15', 'belum'),
(10, 14, 44000, 'assets/img/bukti_pembayaran/853c8509a93b5575faee6b21751b203f04922e98.png', 'transfer', '2020-09-11 05:37:36', 'belum'),
(13, 15, 44000, 'assets/img/bukti_pembayaran/7dfc670d9836d9a9a574b55f3775cf7349d6b665.png', 'transfer', '2020-09-11 10:39:51', 'ya'),
(14, 10, 80000, '', 'ditempat', '2020-09-11 10:40:01', 'ya'),
(15, 21, 29000, 'assets/img/bukti_pembayaran/7dfc670d9836d9a9a574b55f3775cf7349d6b665.png', 'transfer', '2020-09-11 16:26:38', 'ya'),
(16, 23, 520000, 'assets/img/bukti_pembayaran/7dfc670d9836d9a9a574b55f3775cf7349d6b665.png', 'transfer', '2020-09-12 18:32:08', 'ya'),
(17, 24, 56000, 'assets/img/bukti_pembayaran/1d71dd2d9cc87d7010d27c89ed665657a8576158.jpg', 'transfer', '2020-09-14 14:58:02', 'ya'),
(18, 28, 128000, 'assets/img/bukti_pembayaran/e4ca94bd2e9d1058a892b6a4ccadf9ca2636c622.png', 'transfer', '2020-09-14 15:00:58', 'ya'),
(19, 29, 117500, '', 'ditempat', '2020-09-18 00:04:16', 'ya'),
(20, 30, 47000, 'assets/img/bukti_pembayaran/7dfc670d9836d9a9a574b55f3775cf7349d6b665.png', 'transfer', '2020-09-18 00:10:49', 'ya'),
(21, 31, 24000, 'assets/img/bukti_pembayaran/7dfc670d9836d9a9a574b55f3775cf7349d6b665.png', 'transfer', '2020-09-18 00:21:56', 'ya'),
(23, 34, 340000, NULL, 'ditempat', '2020-11-07 21:37:03', 'ya'),
(24, 35, 276000, 'assets/img/bukti_pembayaran/853c8509a93b5575faee6b21751b203f04922e98.png', 'transfer', '2020-11-08 10:28:12', 'ya');

-- --------------------------------------------------------

--
-- Table structure for table `data_telur`
--

DROP TABLE IF EXISTS `data_telur`;
CREATE TABLE IF NOT EXISTS `data_telur` (
  `id_telur` int(11) NOT NULL AUTO_INCREMENT,
  `nama_telur` varchar(50) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `persediaan` int(11) NOT NULL,
  `deskripsi` text,
  `diskon` int(11) DEFAULT NULL,
  `diskon_type` enum('umum','tambahan') NOT NULL DEFAULT 'umum',
  `diskon_count_increase` int(11) NOT NULL DEFAULT '0',
  `diskon_amount_increment` int(11) NOT NULL DEFAULT '0',
  `diskon_amount_increment_max` int(11) NOT NULL DEFAULT '0',
  `tgl_awal_diskon` date DEFAULT NULL,
  `tgl_akhir_diskon` date DEFAULT NULL,
  PRIMARY KEY (`id_telur`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_telur`
--

INSERT INTO `data_telur` (`id_telur`, `nama_telur`, `id_kategori`, `harga_jual`, `persediaan`, `deskripsi`, `diskon`, `diskon_type`, `diskon_count_increase`, `diskon_amount_increment`, `diskon_amount_increment_max`, `tgl_awal_diskon`, `tgl_akhir_diskon`) VALUES
(5, 'Telur Asin Cap 666', 2, 2000, 127, '<p>Blablablabla...</p>\r\n', 50, 'tambahan', 10, 5, 60, '2021-01-01', '2021-03-31'),
(6, 'KK', 2, 18000, 236, '<p>kljgkbmfgkbm</p>\r\n', 50, 'umum', 0, 0, 0, '2020-09-01', '2020-09-30'),
(7, 'telur ayam', 0, 0, 0, '', NULL, 'umum', 0, 0, 0, NULL, NULL),
(8, 'telur ayam ras', 3, 50000, 0, '<p>rw</p>\r\n', 35, 'umum', 0, 0, 0, '2020-09-01', '2020-10-31'),
(9, 'telur ayam k', 3, 40000, 1, '<p>dffd</p>\r\n', 10, 'tambahan', 1, 2, 3, '2020-09-01', '2020-09-30');

-- --------------------------------------------------------

--
-- Table structure for table `data_telur_foto`
--

DROP TABLE IF EXISTS `data_telur_foto`;
CREATE TABLE IF NOT EXISTS `data_telur_foto` (
  `id_foto` int(11) NOT NULL AUTO_INCREMENT,
  `id_telur` int(11) NOT NULL,
  `url_foto` varchar(255) NOT NULL,
  PRIMARY KEY (`id_foto`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_telur_foto`
--

INSERT INTO `data_telur_foto` (`id_foto`, `id_telur`, `url_foto`) VALUES
(1, 5, 'assets/img/telur/fd7a1dde8a665fc704ea02888b2c603cd4d71e53.png'),
(2, 5, 'assets/img/telur/fbd97662a8f45082c705173fdff7214efeb5f093.png'),
(3, 5, 'assets/img/telur/1f1a230edd6e1c80acd5bdc62e43b5939a71fc11.png'),
(4, 5, 'assets/img/telur/ef3e0bad1c7c6ab1436edff6dc585305d2729007.png'),
(5, 6, 'assets/img/telur/394ce2365634370e390f49a1f0fca4276ccaa55c.png'),
(6, 6, 'assets/img/telur/e18dc69abff9bb62ccddcd56197cc9ec7f13835c.jpg'),
(7, 6, 'assets/img/telur/bcfe27ccf76dfb6a79b4182683b551950f6664ac.png'),
(8, 6, 'assets/img/telur/3ce6b1564cd45b50ce036118a12179338701ed75.png'),
(9, 8, 'assets/img/telur/7dfc670d9836d9a9a574b55f3775cf7349d6b665.png');

-- --------------------------------------------------------

--
-- Table structure for table `data_telur_masuk`
--

DROP TABLE IF EXISTS `data_telur_masuk`;
CREATE TABLE IF NOT EXISTS `data_telur_masuk` (
  `id_telur_masuk` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_telur` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  PRIMARY KEY (`id_telur_masuk`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_telur_masuk`
--

INSERT INTO `data_telur_masuk` (`id_telur_masuk`, `tanggal`, `id_telur`, `jumlah`, `harga_beli`) VALUES
(8, '2019-07-09 00:00:00', 5, 55, 5500000),
(9, '2020-04-08 00:00:00', 6, 250, 5400000),
(10, '2020-04-08 00:00:00', 6, 50, 1450000),
(11, '2020-04-08 00:00:00', 5, 70, 2675000),
(12, '2020-09-11 00:00:00', 7, 0, 0),
(13, '2020-09-11 00:00:00', 8, 30, 50000),
(14, '2020-09-14 00:00:00', 9, 5, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `data_transaksi`
--

DROP TABLE IF EXISTS `data_transaksi`;
CREATE TABLE IF NOT EXISTS `data_transaksi` (
  `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `no_transaksi` varchar(32) DEFAULT NULL,
  `tgl_transaksi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_pelanggan` int(11) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `keterangan` text,
  `status_transaksi` enum('tunggu','proses','selesai','batal') NOT NULL DEFAULT 'tunggu',
  `diantarkan` enum('ya','tidak') NOT NULL DEFAULT 'tidak',
  `tgl_pengantaran` date DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `longlat` varchar(255) DEFAULT NULL,
  `id_kurir` int(11) DEFAULT NULL,
  `kurir_check` enum('belum','sudah','selesai') NOT NULL DEFAULT 'belum',
  `total_harga` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `ulasan` text,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_transaksi`
--

INSERT INTO `data_transaksi` (`id_transaksi`, `no_transaksi`, `tgl_transaksi`, `id_pelanggan`, `no_telp`, `keterangan`, `status_transaksi`, `diantarkan`, `tgl_pengantaran`, `alamat`, `longlat`, `id_kurir`, `kurir_check`, `total_harga`, `rating`, `ulasan`) VALUES
(1, 'TR-20190715212411', '2019-07-15 21:24:11', 2, '085341725235', '', 'selesai', 'ya', '2019-07-16', 'Jl. Daeng Tata 1. BTN. Tabaria Blok G8 No. 6', '119.43921690713383,-5.174376889312322', 1, 'sudah', NULL, NULL, NULL),
(2, 'TR-20190719165148', '2019-07-19 16:51:49', 2, '085341725235', 'Dgdg', 'batal', 'ya', '2019-07-20', 'Jjjj it', '119.52165035534688,-5.10636183661318', 0, 'belum', NULL, NULL, NULL),
(3, 'TR-20190719165843', '2019-07-19 16:58:43', 2, '085341725235', 'Sangat butuh', 'batal', 'ya', '2019-07-19', 'Bro blok g no 123', '', 0, 'belum', NULL, NULL, NULL),
(4, 'TR-20190719175231', '2019-07-19 17:52:31', 2, '085341725235', 'hjhk', 'batal', 'ya', '2019-07-20', 'Jl. Daeng Tata 1. BTN. Tabaria Blok G8 No. 6', '119.42826880419919,-5.1839093985134586', 0, 'belum', NULL, NULL, NULL),
(5, 'TR-20190719194943', '2019-07-19 19:49:43', 2, '085341725235', '', 'batal', 'ya', '2019-07-20', 'BTN. Tamarunnang 2. Gowa. Sulawesi Selatan', '119.44277419055173,-5.176299906483712', 0, 'belum', NULL, NULL, NULL),
(6, 'TR-20190719195532', '2019-07-19 19:55:32', 2, '085341725235', 'vdlsv', 'batal', 'ya', '0000-00-00', 'scasd', '119.45178641284177,-5.17120008702127', 0, 'belum', NULL, NULL, NULL),
(7, 'TR-20190719195631', '2019-07-19 19:56:31', 2, '085341725235', 'vdlsv', 'batal', 'ya', '0000-00-00', 'scasd', '119.45178641284177,-5.17120008702127', 0, 'belum', NULL, NULL, NULL),
(8, 'TR-20190719195757', '2019-07-19 19:57:57', 2, '085341725235', '', 'selesai', 'ya', '2019-07-20', 'dsv', '119.44603575671384,-5.166727760463113', 1, 'sudah', NULL, NULL, NULL),
(9, 'TR-20200211222713', '2020-02-11 22:27:13', 2, '085341725235', '', 'selesai', 'ya', '0000-00-00', 'BTN Tabaria blok B6 no 7, Jalan Mannuruki Raya, Mannuruki, Makassar City, South Sulawesi, Indonesia', '119.42902575,-5.176567051438649', 1, 'sudah', NULL, 5, 'loookok\r\n'),
(10, 'TR-20200407225927', '2020-04-07 22:59:27', 2, '085341725235', 'JJLK;lbm;fglb', 'selesai', 'ya', '2020-04-08', 'Jl. Pajjaiang, Sudiang Raya, Makassar City, South Sulawesi, Indonesia', '119.52164589942733,-5.106288443066042', 1, 'sudah', 80000, 4, 'babababa'),
(11, 'TR-20200407233714', '2020-04-07 23:37:14', 2, '085341725235', 'lgk', 'selesai', 'ya', '2020-04-09', 'Jl. Adhyaksa, Pandang, Makassar City, South Sulawesi, Indonesia', '119.44680220000001,-5.160307001434128', 1, 'sudah', 140000, 4, ''),
(12, 'TR-20200901204643', '2020-09-01 20:46:43', 2, '085341725235', '', 'selesai', 'ya', '2020-09-02', 'Griya Pajjaiyang Indah, Jalan Pajjaian, Sudiang Raya, Kota Makassar, Sulawesi Selatan, Indonesia', '119.5215377,-5.106411001419044', 1, 'sudah', 38000, 5, 'jkkunj;n'),
(13, 'TR-20200901210709', '2020-09-01 21:07:09', 2, '085341725235', 'lknlkn', 'selesai', 'ya', '0000-00-00', 'Sembahe, Kabupaten Deli Serdang, Sumatera Utara, Indonesia', '98.57761149999999,3.366193047216267', 1, 'sudah', 26000, 1, 'Tallo bakka'),
(14, 'TR-20200911053318', '2020-09-11 05:33:18', 2, '085341725235', '', 'selesai', 'ya', '2020-09-12', 'Jalan Toddopuli 11, Borong, Makassar City, South Sulawesi, Indonesia', '119.45519019999999,-5.164941001435428', 0, 'belum', NULL, 5, ''),
(15, 'TR-20200911062206', '2020-09-11 06:22:06', 2, '085341725235', ',dsvmflsdkvm ', 'selesai', 'ya', '2020-09-12', 'Jalan Toddopuli 11, Borong, Makassar City, South Sulawesi, Indonesia', '119.45519019999999,-5.164941001435428', 1, 'sudah', 44000, 5, 'c klsdz'),
(16, 'TR-20200911152829', '2020-09-11 15:28:29', 2, '085341725235', '', 'batal', 'ya', '0000-00-00', '', '', 0, 'belum', NULL, NULL, NULL),
(17, 'TR-20200911155726', '2020-09-11 15:57:26', 2, '085341725235', 'wddsc', 'batal', 'ya', '2020-09-02', 'BTP, Jalan Kejayaan Timur X, Tamalanrea, Makassar City, South Sulawesi, Indonesia', '119.50912399999997,-5.137889651427887', 0, 'belum', NULL, NULL, NULL),
(18, 'TR-20200911160345', '2020-09-11 16:03:45', 2, '085341725235', 'ddddddd', 'batal', 'ya', '2020-10-01', 'BTP Blok AD, Paccerakkang, Makassar City, South Sulawesi, Indonesia', '119.52000745,-5.129986201425668', 0, 'belum', NULL, NULL, NULL),
(19, 'TR-20200911160828', '2020-09-11 16:08:28', 2, '085341725235', 'ssssssss', 'batal', 'ya', '2020-10-01', 'Jalan Btp, Tamalanrea, Makassar City, South Sulawesi, Indonesia', '119.50138949999999,-5.132210801426256', 0, 'belum', NULL, NULL, NULL),
(20, 'TR-20200911161144', '2020-09-11 16:11:44', 2, '085341725235', 'asdf', 'batal', 'ya', '2020-10-03', 'Jalan Taman Sudiang Indah, Pai, Makassar City, South Sulawesi, Indonesia', '119.52341600000001,-5.087634501413807', 0, 'belum', NULL, NULL, NULL),
(21, 'TR-20200911161656', '2020-09-11 16:16:56', 2, '085341725235', 'jikjoiknm', 'selesai', 'ya', '2020-09-12', 'BTN PAO-PAO PERMAI BLOK B10/18, Paccinongang, Gowa Regency, South Sulawesi, Indonesia', '119.47033625000002,-5.186205151441363', 1, 'sudah', 29000, 4, ' xdsz'),
(22, NULL, '2020-09-11 16:23:08', 0, '', NULL, '', 'tidak', NULL, NULL, NULL, 0, 'belum', NULL, NULL, NULL),
(23, 'TR-20200912182600', '2020-09-12 18:26:00', 2, '085341725235', '10 rak telur yam ras', 'selesai', 'ya', '2020-09-29', 'BTP Blok M No. 202, Jalan Tamalanrea Selatan 6, Tamalanrea, Makassar City, South Sulawesi, Indonesia', '119.50081145,-5.135202751427095', 1, 'sudah', 520000, 2, 'ada kerusakan barang'),
(24, 'TR-20200912183103', '2020-09-12 18:31:03', 2, '085341725235', '4 rak telur ayam ras', 'selesai', 'ya', '2020-09-23', 'Jalan Btp, Tamalanrea, Makassar City, South Sulawesi, Indonesia', '119.50138949999999,-5.132210801426256', 1, 'sudah', 56000, NULL, NULL),
(27, 'TR-20200914144849', '2020-09-14 14:48:49', 2, '085341725235', '', 'batal', 'ya', '0000-00-00', 'Jalan Btp, Tamalanrea, Makassar City, South Sulawesi, Indonesia', '119.50138949999999,-5.132210801426256', 0, 'belum', NULL, 5, ''),
(28, 'TR-20200914145734', '2020-09-14 14:57:34', 2, '085341725235', 'gr', 'selesai', 'ya', '2020-09-16', 'daya', '', 1, 'selesai', 128000, 5, 'rgrt'),
(29, 'TR-20200917235643', '2020-09-17 23:56:43', 21, '00', 'edwfewfervgrebgtyneytejysrtnstrh trh rtsbnytswr etrwthgetrbws wergreqvqr gerqger gevwg g3rqevq', 'selesai', 'ya', '2020-09-18', 'Btn Lasoani Bawah, Lasoani, Palu City, Central Sulawesi, Indonesia', '119.91121555,-0.9025541002501468', 1, 'sudah', 117500, NULL, NULL),
(30, 'TR-20200918000955', '2020-09-18 00:09:55', 2, '085341725235', 'csdvcsfdvfd sdv sd  sdv sfd dvs ', 'selesai', 'ya', '2020-09-19', 'BTN PAO-PAO PERMAI BLOK B10/18, Paccinongang, Gowa Regency, South Sulawesi, Indonesia', '119.47033625000002,-5.186205151441363', 1, 'sudah', 47000, 5, 'vsdvsfvvfv f  ew w few'),
(31, 'TR-20200918002109', '2020-09-18 00:21:09', 2, '085341725235', 'cdscs', 'selesai', 'ya', '2020-09-19', 'BTN Pepabri, Jalan Goa Ria, Sudiang, Makassar City, South Sulawesi, Indonesia', '119.5291662,-5.091608201414921', 1, 'sudah', 24000, 4, 'dewvfersvs fwdvfers'),
(32, 'TR-20200918152447', '2020-09-18 15:24:47', 22, '082193035842', '', 'proses', 'ya', '2020-09-18', 'Daya, Makassar City, South Sulawesi, Indonesia', '119.50542449999999,-5.10554070559089', 0, 'belum', NULL, NULL, NULL),
(33, 'TR-20201107220536', '2020-11-07 22:05:36', 2, '085341725235', 'vsdvlfvklfmvkldf', 'batal', 'ya', '2020-11-07', 'Btn Tabaria blok G8/6, Btn tabaria, Blok G8, Parang Tambung, Makassar City, South Sulawesi, Indonesia', '119.42836249999999,-5.183501551440611', NULL, 'belum', NULL, NULL, NULL),
(34, 'TR-20201107220727', '2020-11-07 22:07:27', 2, '085341725235', 'dknclsdkncsd', 'selesai', 'ya', '2020-11-07', 'Btn Tabaria blok G8/6, Btn tabaria, Blok G8, Parang Tambung, Makassar City, South Sulawesi, Indonesia', '119.42836249999999,-5.183501551440611', 1, 'sudah', 340000, 1, 'dsvsdv s vmvsd m mvm  s  '),
(35, 'TR-20201108112718', '2020-11-08 11:27:18', 2, '085341725235', 'dcmgrfjrfhire dssdl', 'proses', 'ya', '2020-11-08', 'Griya Pajjaiyang Indah, Jalan Pajjaian, Sudiang Raya, Makassar City, South Sulawesi, Indonesia', '119.5215377,-5.106411001419044', NULL, 'belum', NULL, NULL, NULL),
(36, 'TR-20210302214001', '2021-03-02 21:40:01', 2, '085341725235', 'hoioiijo', 'tunggu', 'ya', '2021-03-02', 'Puskesmas BTN TABARIA, Jl. Dg. Tata Raya, Parang Tambung, Makassar City, South Sulawesi, Indonesia', '119.42868490000001,-5.1831583014404945', NULL, 'belum', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `data_transaksi_detail`
--

DROP TABLE IF EXISTS `data_transaksi_detail`;
CREATE TABLE IF NOT EXISTS `data_transaksi_detail` (
  `id_transaksi_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) NOT NULL,
  `id_telur` int(11) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `jumlah_harga` int(11) NOT NULL,
  PRIMARY KEY (`id_transaksi_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_transaksi_detail`
--

INSERT INTO `data_transaksi_detail` (`id_transaksi_detail`, `id_transaksi`, `id_telur`, `harga_satuan`, `kuantitas`, `jumlah_harga`) VALUES
(1, 1, 5, 2000, 4, 8000),
(2, 2, 5, 2000, 4, 8000),
(3, 3, 5, 2000, 10, 20000),
(4, 4, 5, 2000, 1, 2000),
(5, 5, 5, 2000, 4, 8000),
(6, 6, 5, 2000, 3, 6000),
(7, 8, 5, 2000, 5, 10000),
(8, 9, 5, 2000, 6, 12000),
(9, 10, 5, 2000, 30, 60000),
(10, 11, 5, 2000, 60, 120000),
(11, 12, 6, 18000, 2, 18000),
(12, 13, 5, 2000, 3, 6000),
(13, 14, 6, 18000, 2, 18000),
(14, 14, 5, 2000, 3, 6000),
(15, 15, 6, 18000, 2, 18000),
(16, 15, 5, 2000, 3, 6000),
(17, 16, 6, 18000, 8, 72000),
(18, 17, 6, 18000, 4, 36000),
(19, 18, 8, 50000, 4, 200000),
(20, 19, 6, 18000, 2, 18000),
(21, 20, 6, 18000, 4, 36000),
(22, 21, 6, 18000, 1, 9000),
(23, 23, 8, 50000, 10, 500000),
(24, 24, 6, 18000, 4, 36000),
(25, 25, 8, 50000, 2, 65000),
(26, 26, 8, 50000, 8, 260000),
(27, 27, 8, 50000, 2, 65000),
(28, 28, 9, 40000, 3, 108000),
(29, 29, 8, 50000, 3, 97500),
(30, 30, 6, 18000, 3, 27000),
(31, 31, 5, 2000, 4, 4000),
(32, 32, 6, 18000, 5, 45000),
(33, 33, 9, 40000, 1, 40000),
(34, 34, 8, 50000, 1, 50000),
(35, 34, 6, 18000, 15, 270000),
(36, 35, 5, 2000, 20, 40000),
(37, 35, 6, 18000, 12, 216000),
(38, 36, 5, 2000, 20, 20000);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
