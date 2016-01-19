-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2016 at 08:19 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gita_pertiwi`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activity`
--

CREATE TABLE IF NOT EXISTS `tbl_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `start` date NOT NULL,
  `end` date DEFAULT NULL,
  `lama` int(5) NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `allDay` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `untuk` varchar(30) NOT NULL,
  `dibuat_oleh` varchar(30) NOT NULL,
  `tanggal` datetime NOT NULL,
  `status` int(1) NOT NULL COMMENT 'Status Hari(Libur/KBM)',
  `className` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_activity`
--

INSERT INTO `tbl_activity` (`id`, `title`, `start`, `end`, `lama`, `url`, `allDay`, `untuk`, `dibuat_oleh`, `tanggal`, `status`, `className`) VALUES
(1, 'Pendaftaran Member Baru : M-0001', '2016-01-06', '2016-01-06', 0, '', 'false', '', '1', '0000-00-00 00:00:00', 0, 'bg-blue'),
(2, 'Pendaftaran Member Baru : M-0001', '2016-01-06', '2016-01-06', 0, '', 'false', '', '1', '0000-00-00 00:00:00', 0, 'bg-blue');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_agama`
--

CREATE TABLE IF NOT EXISTS `tbl_agama` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agama` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `KODE_AGAMA` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_agama`
--

INSERT INTO `tbl_agama` (`id`, `agama`) VALUES
(1, 'ISLAM'),
(2, 'KATOLIK'),
(3, 'PROTESTAN'),
(4, 'HINDU'),
(6, 'KONGHUCU');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank`
--

CREATE TABLE IF NOT EXISTS `tbl_bank` (
  `kode` varchar(20) NOT NULL,
  `nama_bank` varchar(20) NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_bank`
--

INSERT INTO `tbl_bank` (`kode`, `nama_bank`) VALUES
('BCA', 'BCA'),
('BII', 'BII'),
('BNI', 'BNI 46'),
('BRI', 'BRI'),
('Mandiri', 'Mandiri'),
('MEGA', 'Bank Mega');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_batas`
--

CREATE TABLE IF NOT EXISTS `tbl_batas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_member` varchar(20) NOT NULL,
  `tgl_expired` date NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bglogin`
--

CREATE TABLE IF NOT EXISTS `tbl_bglogin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_bglogin`
--

INSERT INTO `tbl_bglogin` (`id`, `logo`) VALUES
(1, 'bg-5.jpg'),
(2, 'bg-6.jpg'),
(3, 'bg-7.jpg'),
(4, 'bg-8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cetak`
--

CREATE TABLE IF NOT EXISTS `tbl_cetak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_member` varchar(20) NOT NULL,
  `no_ijazah` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `tgl_cetak` datetime NOT NULL,
  `status_ambil` int(1) NOT NULL COMMENT '0=SudahDiambil 1=BelumDiAmbil',
  `tgl_ambil` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jenis_ketidakhadiran`
--

CREATE TABLE IF NOT EXISTS `tbl_jenis_ketidakhadiran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ket` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_jenis_ketidakhadiran`
--

INSERT INTO `tbl_jenis_ketidakhadiran` (`id`, `ket`) VALUES
(1, 'Cuti'),
(2, 'Sakit'),
(3, 'Izin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kartukredit`
--

CREATE TABLE IF NOT EXISTS `tbl_kartukredit` (
  `kode_kartu` varchar(20) NOT NULL,
  `jenis_kartu` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_kartukredit`
--

INSERT INTO `tbl_kartukredit` (`kode_kartu`, `jenis_kartu`) VALUES
('visa', 'Visa'),
('mastercard', 'Mastercard');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ketidakhadiran`
--

CREATE TABLE IF NOT EXISTS `tbl_ketidakhadiran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) NOT NULL,
  `jns` int(11) NOT NULL,
  `ket` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `lama` int(5) NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `allDay` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `dibuat_oleh` varchar(30) NOT NULL,
  `tanggal` date NOT NULL,
  `className` varchar(30) NOT NULL,
  `bulan` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member`
--

CREATE TABLE IF NOT EXISTS `tbl_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jns_kel` varchar(1) NOT NULL,
  `nama_ortu` varchar(50) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(12) NOT NULL,
  `foto` text NOT NULL,
  `id_agama` int(1) NOT NULL,
  `id_pendidikan` int(2) NOT NULL,
  `id_pekerjaan` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member_detil`
--

CREATE TABLE IF NOT EXISTS `tbl_member_detil` (
  `kode_member` varchar(20) NOT NULL,
  `id_kursus` int(2) NOT NULL,
  `mulai` datetime NOT NULL,
  `status` int(2) NOT NULL,
  `quota` int(5) NOT NULL,
  `ket` text NOT NULL,
  PRIMARY KEY (`kode_member`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

CREATE TABLE IF NOT EXISTS `tbl_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `kelas` varchar(50) NOT NULL,
  `nama_menu` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `urutan` int(1) NOT NULL,
  PRIMARY KEY (`menu_id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_menu`
--

INSERT INTO `tbl_menu` (`menu_id`, `kelas`, `nama_menu`, `link`, `icon`, `status`, `urutan`) VALUES
(1, 'dashboard', 'Dashboard', 'dashboard', 'fa fa-laptop', 0, 1),
(2, 'info', 'Informasi Pribadi', '#', 'fa fa-info', 1, 2),
(3, 'ref_data', 'Referensi Data', '#', 'fa fa-database', 1, 3),
(4, 'master', 'Master Data', '#', 'fa fa-users', 1, 4),
(5, 'trans', 'Transaksi - Transaksi', '#', 'fa fa-credit-card', 1, 5),
(6, 'laporan', 'Laporan - Laporan', '#', 'fa fa-bar-chart-o', 1, 5),
(7, 'tools', 'Tools', '#', 'fa fa-cogs', 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mobil`
--

CREATE TABLE IF NOT EXISTS `tbl_mobil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) NOT NULL,
  `plat` varchar(10) NOT NULL,
  `foto` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_mobil`
--

INSERT INTO `tbl_mobil` (`id`, `nama`, `plat`, `foto`) VALUES
(1, 'Mesin', '-', 'no.jpg'),
(2, 'Mobil Splash', 'Z 3821 DD', 'no.jpg'),
(3, 'Avanza Abu', 'Z 3821 DD', 'no.jpg'),
(4, 'Avanza Hitam', 'Z 3222 DD', 'no.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mulai`
--

CREATE TABLE IF NOT EXISTS `tbl_mulai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_member` varchar(11) NOT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `instruktur` varchar(20) NOT NULL,
  `fasilitas` int(5) NOT NULL,
  `kursus` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  `id_tipe` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pekerjaan`
--

CREATE TABLE IF NOT EXISTS `tbl_pekerjaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `KODE_AGAMA` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_pekerjaan`
--

INSERT INTO `tbl_pekerjaan` (`id`, `nama`) VALUES
(1, 'Pelajar'),
(2, 'Pengangguran'),
(3, 'Mahasiswa');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pendidikan`
--

CREATE TABLE IF NOT EXISTS `tbl_pendidikan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `KODE_AGAMA` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_pendidikan`
--

INSERT INTO `tbl_pendidikan` (`id`, `nama`) VALUES
(1, 'SD'),
(2, 'SMA'),
(3, 'S1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_registermember`
--

CREATE TABLE IF NOT EXISTS `tbl_registermember` (
  `kode_reg` varchar(20) NOT NULL,
  `tgl_reg` date NOT NULL,
  `kode_member` varchar(20) NOT NULL,
  `total` double NOT NULL,
  `discount` double NOT NULL,
  `totalbersih` double NOT NULL,
  `carabayar` varchar(20) NOT NULL,
  `nama_bank` varchar(20) NOT NULL,
  `jenis_kartu` varchar(20) NOT NULL,
  `nomor_kartu` varchar(20) NOT NULL,
  `bank_asal` varchar(20) NOT NULL,
  `rek_asal` varchar(20) NOT NULL,
  `bank_tujuan` varchar(20) NOT NULL,
  `rek_tujuan` varchar(20) NOT NULL,
  `post` int(1) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`kode_reg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_regmemdetil`
--

CREATE TABLE IF NOT EXISTS `tbl_regmemdetil` (
  `kode_reg` varchar(20) NOT NULL,
  `kode_paket` int(2) NOT NULL,
  `bayar` double NOT NULL,
  `sisa` double NOT NULL,
  PRIMARY KEY (`kode_reg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status_izajah`
--

CREATE TABLE IF NOT EXISTS `tbl_status_izajah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_status_izajah`
--

INSERT INTO `tbl_status_izajah` (`id`, `status`) VALUES
(1, 'CUKUP'),
(2, 'BAIK'),
(3, 'SANGAT BAIK'),
(4, 'MEMUASKAN');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_submenu`
--

CREATE TABLE IF NOT EXISTS `tbl_submenu` (
  `smenu_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(5) NOT NULL,
  `nama_smenu` varchar(100) NOT NULL,
  `slink` varchar(50) NOT NULL,
  `sicon` varchar(50) NOT NULL,
  `anak` int(1) NOT NULL,
  `sstatus` tinyint(1) NOT NULL,
  `level` int(11) NOT NULL,
  `urut` int(2) NOT NULL,
  PRIMARY KEY (`smenu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `tbl_submenu`
--

INSERT INTO `tbl_submenu` (`smenu_id`, `parent`, `nama_smenu`, `slink`, `sicon`, `anak`, `sstatus`, `level`, `urut`) VALUES
(1, 2, 'Profile', 'profile', '#', 0, 1, 1, 0),
(2, 3, 'Data Agama', 'agama', '#', 0, 1, 1, 1),
(3, 3, 'Data Pendidikan', 'pendidikan', '#', 0, 1, 1, 2),
(4, 3, 'Data Pekerjaan', 'pekerjaan', '#', 0, 1, 1, 3),
(5, 3, 'Jenis Kursus', 'jenis', '#', 0, 1, 1, 4),
(6, 3, 'Tipe Kursus', 'tipe', '#', 0, 1, 1, 5),
(7, 4, 'Data Siswa', 'member', '#', 0, 1, 1, 1),
(8, 4, 'Data Karyawan', 'users', '#', 0, 1, 1, 2),
(9, 3, 'Data Fasilitas', 'kendaraan', '#', 0, 1, 1, 6),
(10, 5, 'Migrasi Kursus', 'migrasi', '#', 0, 1, 1, 1),
(11, 5, 'Pembayaran', 'bayar', '#', 0, 1, 1, 2),
(12, 5, 'Cetak Izajah', 'cetak', '#', 0, 1, 1, 3),
(13, 6, 'Laporan Keuangan', 'lap_uang', '#', 0, 1, 1, 1),
(14, 6, 'Laporan Data Siswa', 'lap_siswa', '#', 0, 1, 1, 2),
(15, 5, 'Pengambilan Ijazah', 'ambil', '#', 0, 1, 1, 4),
(16, 5, 'Ketidakhadiran', 't_hadir', '#', 0, 1, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_submenux`
--

CREATE TABLE IF NOT EXISTS `tbl_submenux` (
  `smenu_id` int(11) NOT NULL AUTO_INCREMENT,
  `parentx` int(5) NOT NULL,
  `nama_smenux` varchar(100) NOT NULL,
  `slinkx` varchar(50) NOT NULL,
  `siconx` varchar(50) NOT NULL,
  `sstatusx` tinyint(1) NOT NULL,
  `levelx` int(11) NOT NULL,
  `urut` int(11) NOT NULL,
  PRIMARY KEY (`smenu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subtipe`
--

CREATE TABLE IF NOT EXISTS `tbl_subtipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipe` int(5) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `ket` text NOT NULL,
  `durasi` int(5) NOT NULL,
  `pertemuan` int(5) NOT NULL,
  `h_pokok` double NOT NULL,
  `h_daftar` double NOT NULL,
  `expired` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `KODE_AGAMA` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_subtipe`
--

INSERT INTO `tbl_subtipe` (`id`, `id_tipe`, `nama`, `ket`, `durasi`, `pertemuan`, `h_pokok`, `h_daftar`, `expired`) VALUES
(7, 2, '18 X Berikut SIM', '', 18, 18, 1350000, 50000, 30);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tipe`
--

CREATE TABLE IF NOT EXISTS `tbl_tipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `KODE_AGAMA` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_tipe`
--

INSERT INTO `tbl_tipe` (`id`, `nama`) VALUES
(1, 'Menjahit'),
(2, 'Mengemudi');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi`
--

CREATE TABLE IF NOT EXISTS `tbl_transaksi` (
  `kode_trans` varchar(20) NOT NULL COMMENT 'MREG = RegMember TRAN = TranPembayaran MRAN = MigrasiTransaksi',
  `kode_member` varchar(20) NOT NULL,
  `tgl_bayar` datetime NOT NULL,
  `total` double NOT NULL,
  `bayar` double NOT NULL,
  `sisa` double NOT NULL,
  PRIMARY KEY (`kode_trans`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_username`
--

CREATE TABLE IF NOT EXISTS `tbl_username` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `foto` text NOT NULL,
  `level` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_username`
--

INSERT INTO `tbl_username` (`id`, `nama`, `username`, `password`, `foto`, `level`) VALUES
(1, 'Hendy Andrianto', 'dodon', '492e2d67d5ef704dd2d18cf3e4a64ed7', 'image.jpg', 0),
(2, 'Hendrian', 'hendrian', '827ccb0eea8a706c4c34a16891f84e7b', 'no.jpg', 0),
(3, 'Angga', 'angga', '827ccb0eea8a706c4c34a16891f84e7b', 'no.jpg', 0),
(4, 'Sigit', 'sigit', '827ccb0eea8a706c4c34a16891f84e7b', 'no.jpg', 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_ijazah`
--
CREATE TABLE IF NOT EXISTS `view_ijazah` (
`kode` varchar(10)
,`nama` varchar(50)
,`foto` text
,`no_ijazah` varchar(30)
,`status` varchar(30)
,`tgl_cetak` datetime
,`status_ambil` int(1)
,`tgl_ambil` datetime
,`nama_tipe` varchar(50)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_kursus`
--
CREATE TABLE IF NOT EXISTS `view_kursus` (
`id` int(11)
,`nama` varchar(50)
,`idna` int(11)
,`nama_subtipe` varchar(50)
,`ket` text
,`h_daftar` double
,`h_pokok` double
,`pertemuan` int(5)
,`durasi` int(5)
,`expired` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_laporan`
--
CREATE TABLE IF NOT EXISTS `view_laporan` (
`kode_trans` varchar(20)
,`tgl_bayar` datetime
,`total` double
,`bayar` double
,`sisa` double
,`nama` varchar(50)
,`id_tipe` int(5)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_member`
--
CREATE TABLE IF NOT EXISTS `view_member` (
`id` int(11)
,`kode` varchar(10)
,`nama` varchar(50)
,`jns_kel` varchar(1)
,`nama_ortu` varchar(50)
,`tempat_lahir` varchar(50)
,`tgl_lahir` date
,`alamat` text
,`no_hp` varchar(12)
,`foto` text
,`id_agama` int(1)
,`id_pendidikan` int(2)
,`id_pekerjaan` int(2)
,`id_kursus` int(2)
,`mulai` datetime
,`status` int(2)
,`quota` int(5)
,`id_tipe` int(5)
,`nama_tipe` varchar(50)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_member_kursus`
--
CREATE TABLE IF NOT EXISTS `view_member_kursus` (
`kode` varchar(10)
,`nama` varchar(50)
,`foto` text
,`nama_tipe` varchar(50)
,`id_kursus` int(2)
,`status` int(2)
,`quota` int(5)
);
-- --------------------------------------------------------

--
-- Structure for view `view_ijazah`
--
DROP TABLE IF EXISTS `view_ijazah`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_ijazah` AS select `view_member`.`kode` AS `kode`,`view_member`.`nama` AS `nama`,`view_member`.`foto` AS `foto`,`tbl_cetak`.`no_ijazah` AS `no_ijazah`,`tbl_cetak`.`status` AS `status`,`tbl_cetak`.`tgl_cetak` AS `tgl_cetak`,`tbl_cetak`.`status_ambil` AS `status_ambil`,`tbl_cetak`.`tgl_ambil` AS `tgl_ambil`,`view_member`.`nama_tipe` AS `nama_tipe` from (`view_member` join `tbl_cetak` on((`view_member`.`kode` = `tbl_cetak`.`kode_member`)));

-- --------------------------------------------------------

--
-- Structure for view `view_kursus`
--
DROP TABLE IF EXISTS `view_kursus`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_kursus` AS select `tbl_tipe`.`id` AS `id`,`tbl_tipe`.`nama` AS `nama`,`tbl_subtipe`.`id` AS `idna`,`tbl_subtipe`.`nama` AS `nama_subtipe`,`tbl_subtipe`.`ket` AS `ket`,`tbl_subtipe`.`h_daftar` AS `h_daftar`,`tbl_subtipe`.`h_pokok` AS `h_pokok`,`tbl_subtipe`.`pertemuan` AS `pertemuan`,`tbl_subtipe`.`durasi` AS `durasi`,`tbl_subtipe`.`expired` AS `expired` from (`tbl_tipe` join `tbl_subtipe` on((`tbl_tipe`.`id` = `tbl_subtipe`.`id_tipe`)));

-- --------------------------------------------------------

--
-- Structure for view `view_laporan`
--
DROP TABLE IF EXISTS `view_laporan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_laporan` AS select `tbl_transaksi`.`kode_trans` AS `kode_trans`,`tbl_transaksi`.`tgl_bayar` AS `tgl_bayar`,`tbl_transaksi`.`total` AS `total`,`tbl_transaksi`.`bayar` AS `bayar`,`tbl_transaksi`.`sisa` AS `sisa`,`tbl_member`.`nama` AS `nama`,`view_member`.`id_tipe` AS `id_tipe` from ((`tbl_transaksi` join `tbl_member` on((`tbl_transaksi`.`kode_member` = `tbl_member`.`kode`))) join `view_member` on((`tbl_member`.`kode` = `view_member`.`kode`)));

-- --------------------------------------------------------

--
-- Structure for view `view_member`
--
DROP TABLE IF EXISTS `view_member`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_member` AS select `tbl_member`.`id` AS `id`,`tbl_member`.`kode` AS `kode`,`tbl_member`.`nama` AS `nama`,`tbl_member`.`jns_kel` AS `jns_kel`,`tbl_member`.`nama_ortu` AS `nama_ortu`,`tbl_member`.`tempat_lahir` AS `tempat_lahir`,`tbl_member`.`tgl_lahir` AS `tgl_lahir`,`tbl_member`.`alamat` AS `alamat`,`tbl_member`.`no_hp` AS `no_hp`,`tbl_member`.`foto` AS `foto`,`tbl_member`.`id_agama` AS `id_agama`,`tbl_member`.`id_pendidikan` AS `id_pendidikan`,`tbl_member`.`id_pekerjaan` AS `id_pekerjaan`,`tbl_member_detil`.`id_kursus` AS `id_kursus`,`tbl_member_detil`.`mulai` AS `mulai`,`tbl_member_detil`.`status` AS `status`,`tbl_member_detil`.`quota` AS `quota`,`tbl_subtipe`.`id_tipe` AS `id_tipe`,`tbl_tipe`.`nama` AS `nama_tipe` from (((`tbl_member` join `tbl_member_detil` on((`tbl_member`.`kode` = `tbl_member_detil`.`kode_member`))) join `tbl_subtipe` on((`tbl_member_detil`.`id_kursus` = `tbl_subtipe`.`id`))) join `tbl_tipe` on((`tbl_subtipe`.`id_tipe` = `tbl_tipe`.`id`)));

-- --------------------------------------------------------

--
-- Structure for view `view_member_kursus`
--
DROP TABLE IF EXISTS `view_member_kursus`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_member_kursus` AS select `tbl_member`.`kode` AS `kode`,`tbl_member`.`nama` AS `nama`,`tbl_member`.`foto` AS `foto`,`tbl_subtipe`.`nama` AS `nama_tipe`,`tbl_member_detil`.`id_kursus` AS `id_kursus`,`tbl_member_detil`.`status` AS `status`,`tbl_member_detil`.`quota` AS `quota` from ((`tbl_member` join `tbl_member_detil` on((`tbl_member`.`kode` = `tbl_member_detil`.`kode_member`))) join `tbl_subtipe` on((`tbl_member_detil`.`id_kursus` = `tbl_subtipe`.`id`)));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
