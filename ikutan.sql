-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2014 at 11:29 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ikutan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `adminId` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(200) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `fakultas` varchar(200) NOT NULL,
  `nohp` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`adminId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminId`, `nama`, `userName`, `email`, `password`, `fakultas`, `nohp`) VALUES
(2, 'Anas', 'anasajadah', 'anas.bladz@gmail.com', 'balonku', 'FMIPA', NULL),
(11, 'baru', 'baruaja', 'baru1@baru.com', 'baruaja', 'FAPERTA', NULL),
(12, 'Tujuh Orang', 'tujuh', 'tujuh@tujuh.com', 'tujuh', 'FAPERTA', NULL),
(13, 'YAYIYALAH', 'yaiyalah', 'yaiyalah@yaiyadong.com', 'yaiyadong', 'FMIPA', NULL),
(14, 'baru', 'aa', 'baru@baru.com', 'makan', 'FAPERTA', NULL),
(15, 'poiu', 'poiuy', 'po@oi.c', 'poiuy', 'FAPERTA', NULL),
(16, 'ucup', 'ucup', 'uc@up.com', 'ucup', 'FATETA', '085697025202'),
(17, '...', '...', 'kalah', 'beda', 'FEM', NULL),
(18, 'resmimanda', 'resmimanda', 'resmimanda@yahoo.com', '9juli1993', 'FKH', NULL),
(19, 'Muhammad Badar', 'badar', 'badar@uhuy.com', '12345', 'FAPET', '0999999999'),
(20, 'ucup2', 'ucup2', 'ucup1', 'ucup2', 'FAPERTA', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `pembuat` varchar(200) DEFAULT NULL,
  `tanggal` varchar(200) NOT NULL,
  `tempat` varchar(200) NOT NULL,
  `idevent` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(200) NOT NULL,
  `img` varchar(200) NOT NULL,
  `deskripsi` varchar(500) NOT NULL,
  `kategori` varchar(200) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  PRIMARY KEY (`idevent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`pembuat`, `tanggal`, `tempat`, `idevent`, `nama`, `img`, `deskripsi`, `kategori`, `point`) VALUES
('baruaja', '05/11/2014', 'Lapangan Gladiator IPB', 1, 'Lari Pagi Sekampung Yok', 'event/satu.jpg', 'Ini kata-kata boongan, buat dummy text aja. Ini kata-kata boongan, buat dummy text aja Ini kata-kata boongan, buat dummy text aja.', NULL, 1),
(NULL, '10/11/2013', 'bogor aja', 2, 'Makanan baru', 'event/satu.jpg', 'Huaa.. ini deskripsi!!', NULL, 0),
(NULL, '05/11/2013', 'Auditorium Common Class Room IPB, Dramaga-Bogor ', 3, 'Seminar Kewirausahaan Nasional', 'event/1.jpg', 'Seminar Kewirausahaan Nasional\r\n\r\nâ€œLOOKING FOR OPPORTUNITIES IN THE ASEAN ECONOMIC COMMUNITY 2015â€\r\n\r\nkeynote speaker:\r\nIr. M. Hatta Rajasa \r\n(Menteri Koordinator Bidang Perekonomian Indonesia)\r\n\r\nseminar:\r\n- Prof. Ir. Hermanto Siregar, Mec, PhD\r\n(Anggota Komite Ekonomi Nasional, Guru Besar Ilmu Ekonomi IPB)\r\n- Nancy Martasuta \r\n(KADIN INDONESIA Komite Thailand dan Myanmar, Pemimpin CCR BNI)\r\n- Ir. H. Nursyamsyu Mahyuddin \r\n(Pengusaha Exportir, Ketua KPMI Pusat)\r\nmoderator:\r\nRyan Adam \r\n(pen', NULL, 0),
(NULL, '05/03/2014', 'Auditorium Toyib Hadiwidjaya', 4, 'GEBYAR KOPERASI NASIONAL', 'event/2.jpg', 'Koperasi Mahasiswa Institut Pertanian Bogor Proudly Present\r\nGEBYAR KOPERASI NASIONAL\r\n\r\nSEMINAR NASIONAL\r\nTema : Peran Koperasi Mahasiswa dalam Menghadapi Masyarakat Ekonomi ASEAN (MEA) 2015\r\n\r\nMenghadirkan Menteri Koperasi dan UKM serta pembicara-pembicara handal.\r\n\r\nMinggu, 08 Desember 2013\r\nPukul 08.00-12.35 WIB\r\ndi Auditorium Toyib Hadiwidjaya\r\n\r\nHTM: Rp. 10.000\r\nFasilitas: sertifikat, snack, dorprice, lunch\r\n\r\nBuruan segera daftar !!!\r\n\r\nCP:\r\nWiwin : 0877-3668-7181\r\nKholis: 0856-4266-8914', NULL, 0),
(NULL, '05/02/2014', 'Thamrin City lt.2, Jakarta', 5, 'Young on Top Networking Day', 'event/3.jpg', 'Young on Top Networking Day! Perluas network kamu dengan teman-teman organisasi kampus dan komunitas, serta dengan pembicara yang luar biasa! Daftarkan diri kamu dii http://tinyurl.com/klftcbo', NULL, 0),
(NULL, '05/10/2013', 'Gedung Graha Widya Wisuda, IPB, Dramaga', 6, 'ART COLLABORATION AND REVOLUTIONARY ACTION', 'event/5.jpg', 'UKM MAX!! IPB dengan bangga mempersembahkan\r\n\r\n"Malam Puncak: ART COLLABORATION AND REVOLUTIONARY ACTION". Sabtu, 7 Desember 2013, pukul 18.30 - till drop, Gedung Graha Widya Wisuda, IPB, Dramaga, Bogor. Guest Star : D''MASIV\r\n\r\nTurut menampilkan:\r\n1. Pemenang Kompetisi Band #ACRA2013\r\n2. Pemenang Kompetisi Solo Vocal #ACRA2013\r\n3. Hasil kompetisi Fotografi #ACRA2013\r\n4. FlavaliciuosMAX!! (Pemenang Kompetisi Perkusi IAC 2013)\r\n5. Reverie (Band Pemenang Kompetisi Cilapop IAC 2013)\r\n6. Dita Project', NULL, 0),
('baruaja', '05/11/2013', 'Auditorium Common Class Room IPB, Dramaga-Bogor ', 7, 'Young on Top Networking Day', 'event/3.jpg', 'Young on Top Networking Day! Perluas network kamu dengan teman-teman organisasi kampus dan komunitas, serta dengan pembicara yang luar biasa! Daftarkan diri kamu dii ', NULL, 0),
('ucup', '24/06/2013', 'Kolam GFM', 8, 'Ceburin Tri', 'event/6.jpg', 'Ceburin TRI woi!! Ceburin TRI woi!! Ceburin TRI woi!! Ceburin TRI woi!!', 'Apa aja', 0),
('ucup', '30/12/2013', 'tempat/audit_sumardi_fpil.jpg', 9, 'Coba nambah Event', 'event/satu.jpg', 'Coba doang Coba doang Coba doang Coba doang', NULL, 2),
('ucup', '01/01/2014', 'tempat/SC_MIPA.jpg', 10, 'Makan Barang', 'event/2.jpg', 'Makan oi Makan oi Makan oi Makan oi Makan oi Makan oi', 'Kuliah Umum', 1),
('...', '30/02/2013', 'tempat/alhur.jpg', 11, 'Dota', 'event/1.jpg', 'Ayo kita MABIT di Alhur, MAlam BIna doTa', 'Agenda Kuliah', 2),
('badar', '12/02/2012', 'tempat/gww.jpg', 13, 'Minum Teh', '12.jpg', 'Minum teh bareng badar Minum teh bareng badar Minum teh bareng badar Minum teh bareng badar Minum teh bareng badar Minum teh bareng badar Minum teh bareng badar Minum teh bareng badar Minum teh bareng badar Minum teh bareng badar Minum teh bareng badar ', 'Kuliah Umum', 0),
('badar', '08/01/2014', 'tempat/SC_MIPA.jpg', 14, 'Minum Teh season 2', '17.jpg', 'Minum teh bareng badar season 2 Minum teh bareng badar season 2 Minum teh bareng badar season 2 Minum teh bareng badar season 2 Minum teh bareng badar season 2 Minum teh bareng badar season 2 Minum teh bareng badar season 2 Minum teh bareng badar season 2 Minum teh bareng badar season 2 ', 'Kuliah Umum', 1),
('ucup2', '12/02/2012', 'tempat/SC_MIPA.jpg', 16, 'aaa', '3.jpg', 'aaaaaaaaa', 'Kuliah Umum', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE IF NOT EXISTS `fakultas` (
  `id_fakultas` int(11) NOT NULL AUTO_INCREMENT,
  `fakultas` varchar(200) NOT NULL,
  PRIMARY KEY (`id_fakultas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`id_fakultas`, `fakultas`) VALUES
(1, 'FAPERTA'),
(2, 'FKH'),
(4, 'FPIK'),
(5, 'FAPET'),
(6, 'FAHUTAN'),
(7, 'FATETA'),
(8, 'FMIPA'),
(9, 'FEM'),
(10, 'FEMA');

-- --------------------------------------------------------

--
-- Table structure for table `ikutevent`
--

CREATE TABLE IF NOT EXISTS `ikutevent` (
  `username` varchar(200) NOT NULL,
  `id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `img` varchar(200) NOT NULL,
  `tanggal` varchar(200) NOT NULL,
  `tempat` varchar(200) NOT NULL,
  `noikut` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`noikut`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `ikutevent`
--

INSERT INTO `ikutevent` (`username`, `id`, `nama`, `img`, `tanggal`, `tempat`, `noikut`) VALUES
('...', 11, 'Dota', 'event/1.jpg', '30 Februari 2014', 'tempat/alhur.jpg', 6),
('resmimanda', 6, 'ART COLLABORATION AND REVOLUTIONARY ACTION', 'event/5.jpg', 'baruaja', 'Gedung Graha Widya Wisuda, IPB, Dramaga', 7),
('resmimanda', 8, 'Ceburin Tri', 'event/6.jpg', '24 Januari 2013', 'Kolam GFM', 8),
('ucup', 11, 'Dota', 'event/1.jpg', '30 Februari 2014', 'tempat/alhur.jpg', 11),
('ucup', 13, 'Makan Barang', 'gladiator.jpg', '20 Januari 2014', 'tempat/SC_MIPA.jpg', 12),
('ucup', 10, 'Makan Barang', 'event/2.jpg', '20 Januari 2014', 'tempat/SC_MIPA.jpg', 13),
('ucup', 14, 'Minum Teh season 2', '17.jpg', '08/01/2014', 'tempat/SC_MIPA.jpg', 14),
('ucup', 10, 'Makan Barang', 'event/2.jpg', '01/01/2014', 'tempat/SC_MIPA.jpg', 15);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
  `idkategori` int(11) NOT NULL AUTO_INCREMENT,
  `Kategori` varchar(200) NOT NULL,
  PRIMARY KEY (`idkategori`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`idkategori`, `Kategori`) VALUES
(1, 'Agenda Kuliah'),
(2, 'Acara Olahraga'),
(3, 'Acara BEM'),
(4, 'Seminar'),
(5, 'Kuliah Umum');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(200) NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id_status`, `status`) VALUES
(1, 'Keren!'),
(2, 'Not Bad..'),
(4, 'Garing!'),
(5, 'Meh..');

-- --------------------------------------------------------

--
-- Table structure for table `superadmin`
--

CREATE TABLE IF NOT EXISTS `superadmin` (
  `superid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY (`superid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tempat`
--

CREATE TABLE IF NOT EXISTS `tempat` (
  `idtempat` int(11) NOT NULL AUTO_INCREMENT,
  `tempat` varchar(200) NOT NULL,
  `nama_tempat` varchar(200) NOT NULL,
  PRIMARY KEY (`idtempat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `tempat`
--

INSERT INTO `tempat` (`idtempat`, `tempat`, `nama_tempat`) VALUES
(1, 'tempat/alhur.jpg', 'Masjid Al-Hurriyah'),
(4, 'tempat/audit _toyib_faperta.jpg', 'Audit Toyib Faperta'),
(5, 'tempat/audit_abdul_muis_fateta.jpg', 'Audit Abdul Muis Fateta'),
(6, 'tempat/audit_AHN.jpg', 'Audit AHN'),
(7, 'tempat/audit_JHH_fapet.jpg', 'Audit JHH Fapet'),
(8, 'tempat/audit_sumardi_fpil.jpg', 'Audit Sumardi FPIK'),
(9, 'tempat/gladiator.jpg', 'Gladiator'),
(10, 'tempat/gmsk.jpg', 'GMSK'),
(11, 'tempat/gww.jpg', 'GWW'),
(12, 'tempat/gym.jpg', 'Gym'),
(13, 'tempat/korfat.jpg', 'Koridor Fateta'),
(14, 'tempat/Koridor_gka.jpg', 'Koridor GKA'),
(15, 'tempat/Korpin.jpg', 'Koridor Pinus'),
(16, 'tempat/Kortan.jpg', 'Koridor Tanah'),
(17, 'tempat/media_center.jpg', 'Media Center'),
(19, 'tempat/POMI.jpg', 'Pojok Mipa'),
(20, 'tempat/SC_MIPA.jpg', 'SC MIPA');

-- --------------------------------------------------------

--
-- Table structure for table `testimoni`
--

CREATE TABLE IF NOT EXISTS `testimoni` (
  `id_komen` int(11) NOT NULL AUTO_INCREMENT,
  `ownerevent` varchar(50) DEFAULT NULL,
  `nama_event` varchar(50) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  `komentator` varchar(50) DEFAULT NULL,
  `komentar` varchar(200) NOT NULL,
  `id_event` int(10) NOT NULL,
  PRIMARY KEY (`id_komen`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `testimoni`
--

INSERT INTO `testimoni` (`id_komen`, `ownerevent`, `nama_event`, `status`, `komentator`, `komentar`, `id_event`) VALUES
(1, 'baruaja', 'Lari Pagi Sekampung Yok', 'Puas', 'ucup', 'Boleh juga nih', 1),
(2, 'baruaja', 'Lari Pagi Sekampung Yok', 'Ga Peduli', NULL, 'makan', 1),
(3, NULL, 'Seminar Kewirausahaan Nasional', 'Ga Peduli', NULL, 'makan', 3),
(4, 'ucup', 'Ceburin Tri', 'Ga Peduli', 'ucup', 'makan aja..', 8),
(5, '...', 'Dota', 'Penting Ban', '...', 'Ngebosenin', 11),
(6, '...', 'Dota', 'Garing Para', '...', 'Seru banget', 11),
(7, NULL, 'Minum Teh season 2', 'Meh..', 'badar', 'Ayo kita minum teh!!', 14),
(8, NULL, 'Minum Teh season 2', 'Garing!', 'ucup', 'oi.. jangan pada ikutan!!', 14),
(9, 'ucup', 'Coba nambah Event', 'Meh..', 'ucup', 'Tes komentar', 9),
(10, 'ucup', 'Coba nambah Event', 'Meh..', 'ucup', 'Ucup komentar Lagi', 9);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
