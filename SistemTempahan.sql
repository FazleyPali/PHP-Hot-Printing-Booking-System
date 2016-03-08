-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 22, 2013 at 08:07 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sistem_e-tempahan_hot_printing`
--
CREATE DATABASE `sistem_e-tempahan_hot_printing` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sistem_e-tempahan_hot_printing`;

-- --------------------------------------------------------

--
-- Table structure for table `pekerja`
--

CREATE TABLE IF NOT EXISTS `pekerja` (
  `no_mykad_pekerja` varchar(12) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `jawatan` varchar(30) DEFAULT NULL,
  `kata_laluan` varchar(10) NOT NULL,
  PRIMARY KEY (`no_mykad_pekerja`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pekerja`
--

INSERT INTO `pekerja` (`no_mykad_pekerja`, `nama`, `alamat`, `email`, `jawatan`, `kata_laluan`) VALUES
('920517105553', 'mazlan', 'KualaSelangor', 'lan@psis.com', 'admin', '123456'),
('920517105554', 'Hafizi', 'kuala selangor', 'lan@psis.com', 'pekerja', '123456'),
('890910105352', 'Suhaila Binti Hashim', 'Sungai Besar', 'suhaila89@yahoo.com', 'admin', '123456'),
('921030085583', 'Ahmad ', '208H RUMAH AWAM, MELAKA', 'Ahmad@yahoo.com', 'pekerja', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE IF NOT EXISTS `pelanggan` (
  `no_mykad_pelanggan` varchar(12) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telefon_pejabat` varchar(12) DEFAULT NULL,
  `no_fax` varchar(10) DEFAULT NULL,
  `no_telefon_bimbit` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `kata_laluan` varchar(20) NOT NULL,
  `jawatan` varchar(20) NOT NULL DEFAULT 'pelanggan',
  PRIMARY KEY (`no_mykad_pelanggan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`no_mykad_pelanggan`, `nama`, `alamat`, `no_telefon_pejabat`, `no_fax`, `no_telefon_bimbit`, `email`, `kata_laluan`, `jawatan`) VALUES
('921030085583', 'Muhammad Hafizi Bin Subandi ', 'No. 208h RUMAH AWAM, BUKIT BERUANG, 54500 MELAKA', NULL, NULL, '0129163468', 'a@b.c', '123456', 'pelanggan'),
('920426106147', 'Ezad ', 'klang ', ' 0332891234 ', ' 033289123', '+601735677', 'lan@psis.com', '123456', 'pelanggan'),
('920517105557', 'Mohd Mazlan Bin Mohd Nor 2 ', 'kuala selangor', NULL, NULL, '0122231231', 'a@b.c', '123456', 'pelanggan'),
('920517105556', 'Saiful Baharin', 'Sabak Bernam Selangor', '-', '-', '+61234567890', 'saiful@psis.com', '123456', 'pelanggan'),
('921030085584', 'ALI BIN ABU SAMAD', 'SUANGAI LANG, selangor', NULL, NULL, '017917346888', 'A.B@C.JJ', 'QWERTY', 'pelanggan'),
('920517105554', 'Muhammad Hafizi Bin Subandi', 'Kampung Bukit Beruang, Melaka', '-', '-', '+62222222222', 'fizi@yahoo.com', '123456', 'pelanggan'),
('920517105559', 'Muhd Muazam Shah ', 'kuala selangor', '-', '-', '0123123012', 'azam@yahoo.com', '123456', 'pelanggan'),
('920517105553', 'Mohd Mazlan Bin Mohd Nor ', 'Jalan Batu 1, Kampung Bukit Rotan 45ooo Kuala Selangor', '-', '-', '+60173636365', 'lan.psis@gmail.com', '123456', 'pelanggan'),
('920906026349', 'Muhammad Izzul Akmal Bin Othman  ', 'Ipoh Perak', NULL, NULL, '0178861336', 'iezo23@yahoo.com', 'qwerty', 'pelanggan'),
('920517105551', 'Muhammad Jawahir Bin Abdul Samat ', 'nogori sombilan', '033343423423', '0343534535', '0122233434', 'jawa@psis.com', '123456', 'pelanggan'),
('921201146169', 'Zulkifli B Rasi ', 'Lot 47,\r\nKampung Masjid Segambut Dalam.\r\n51200 Kuala Lumpur', '036251674', '-', '0172573422', 'zulkifli_rasi@yahoo.com', 'zulkifli92', 'pelanggan'),
('921030105643', 'Logendran ', 'poet dickson', '0111111122', '2222111211', '9202922211', 'sws@g.com', '123456', 'pelanggan'),
('920517105555', 'Siti Diana ', 'sungai besar', '-', '-', '0199999999', 'akj@y.coo', '123456', 'pelanggan'),
('920430146758', 'Nur Elysa Bt Idris  ', '41 jalan tanjung1 bukit sentosa rawang selangor', '-', '-', '0126685738', 'alic3_inwnd3rland@yahoo.com.my', '123456', 'pelanggan'),
('820410105125', 'Ezwan Shah ', 'KL', '31313', '31313131', '0145515115', 'eaa@yahoo.com', '51256231', 'pelanggan'),
('921124145559', 'Muhd Nazrin Shah Bin Mohd Anuar ', 'no 9, jalan ru 9, melaka', '0178480144', '-', '0178480144', 'ryn_scoot@yahoo.com', '123456', 'pelanggan'),
('920000000000', 'Fikri ', 'banting', '0293232842', '0345678999', '0198667899', 'mmnhb@yahoo.com', '123456', 'pelanggan'),
('123456789098', 'Lan ', 'hhjh', '1234567''', NULL, '2345678904', 'g@g.v', '123456', 'pelanggan');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE IF NOT EXISTS `produk` (
  `kod_produk` varchar(100) NOT NULL DEFAULT '',
  `nama_produk` varchar(100) NOT NULL,
  `harga` decimal(5,2) NOT NULL,
  `warna` varchar(30) NOT NULL,
  `saiz` varchar(10) NOT NULL,
  `huraian` varchar(999) NOT NULL,
  `gambar` varchar(250) NOT NULL,
  PRIMARY KEY (`kod_produk`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`kod_produk`, `nama_produk`, `harga`, `warna`, `saiz`, `huraian`, `gambar`) VALUES
('DMF01-Yell', 'DMF01-Yellow Black', '40.00', 'Yellow', 'S,M,L,XL', 'Jenis Kain: \r\nCotton 60%, polyester 40%', 'DMF01-Yellow Black.jpg'),
('CT02-NAVY ', 'CT02-NAVY BLUE', '20.00', 'Navy Blue', 'S,M,L,XL', 'Jenis Kain: \r\nCotton 60%, polyester 40%', 'CT02-NAVY BLUE.jpg'),
('CT03-RED', 'CT03-RED', '21.00', 'Red', 'S,M,L', 'Jenis Kain: Cotton 60%, polyester 40%', 'CT03-RED.jpg'),
('CT04-ORANG', 'CT04-ORANGE', '23.00', 'Orange', 'S,M', 'Jenis Kain: \r\nCotton 60%, polyester 40%', 'CT04-ORANGE.jpg'),
('CT06-YELLO', 'CT06-YELLOW', '23.00', 'Yellow', 'S,M,L', 'Jenis Kain: \r\nCotton 60%, polyester 40%', 'CT06-YELLOW.jpg'),
('CT07-BLUE', 'CT07-BLUE', '23.00', 'Black', 'S,M,L,XL', 'Jenis Kain: \r\nCotton 60%, polyester 40%', 'CT07-BLUE.jpg'),
('CT01-BLACK', 'CT01-BLACK', '20.00', 'Black, White', 'S,M,L', 'Jenis Kain: \r\nCotton 60%, polyester 40%', 'CT01-BLACK.jpg'),
('DMF02-Roya', 'DMF02-Royal Blue White', '23.00', 'Black', 'S,M,L,XL', 'Jenis Kain: \r\nCotton 60%, polyester 40%', 'DMF02-Royal Blue White.jpg'),
('DMF04-Blac', 'DMF04-Black Orange', '23.00', 'Black', 'S,M,L', 'Jenis Kain: \r\nCotton 60%, polyester 40%', 'DMF04-Black Orange.jpg'),
('DMF05-Whit', 'DMF05-White Red', '23.00', 'Black', 'S,M,L,XL', 'Jenis Kain: \r\nmicrofiber 100%', 'DMF05-White Red.jpg'),
('F1-RED BLU', 'F1-RED BLUE', '23.00', 'Red', 'S,M,L', 'Jenis Kain: \r\npolyester 65% viscose 35%', 'F1-RED BLUE.jpg'),
('LA-BLACK', 'LA-BLACK', '23.00', 'Black', 'S,M,L,XL', 'Jenis Kain: Cotton 60%, polyester 40%', 'LA-BLACK.jpg'),
('LADIES DEN', 'LADIES DENIM', '21.00', 'Black', 'S,', 'Jenis Kain: \r\npolyester 65% viscose 35%', 'LADIES DENIM.jpg'),
('LADIES U1', 'LADIES U1', '23.00', 'Black', 'S,', 'Jenis Kain: \r\npolyester 65% viscose 35%', 'LADIES U1.jpg'),
('LA-ORANGE', 'LA-ORANGE', '23.00', 'Black', 'S,M,L', 'Jenis Kain: Cotton 60%, polyester 40%', 'LA-ORANGE.jpg'),
('F6-BEIGE O', 'F6-BEIGE ORANGE', '21.00', 'Black', 'S,', 'Jenis Kain: \r\npolyester 65% viscose 35%', 'F6-BEIGE ORANGE.jpg'),
('t-LA-YELLO', 't-LA-YELLOW', '34.00', 'Black', 'S', 'Jenis Kain: Cotton 60%, polyester 40%', 't-LA-YELLOW.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tempahan`
--

CREATE TABLE IF NOT EXISTS `tempahan` (
  `no_tempahan` int(10) NOT NULL AUTO_INCREMENT,
  `no_mykad_pelanggan` varchar(100) NOT NULL,
  `kod_produk` varchar(100) NOT NULL,
  `tarikh_tempah` date NOT NULL,
  `kuantiti` int(5) NOT NULL,
  `jumlah_harga` decimal(5,2) NOT NULL,
  `cara_bayaran` varchar(20) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Belum disahkan',
  `no_mykad_pekerja` int(12) NOT NULL,
  `catatan` varchar(300) DEFAULT NULL,
  `lakaran` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`no_tempahan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=161 ;

--
-- Dumping data for table `tempahan`
--

INSERT INTO `tempahan` (`no_tempahan`, `no_mykad_pelanggan`, `kod_produk`, `tarikh_tempah`, `kuantiti`, `jumlah_harga`, `cara_bayaran`, `status`, `no_mykad_pekerja`, `catatan`, `lakaran`) VALUES
(129, ' 921201146169', 'CT02-NAVY ', '2012-10-29', 1, '20.00', 'Bayaran Tunai', 'Lulus', 0, 'Do it right!', 'trollface.jpg'),
(127, ' 920517105554', 'CT07-BLUE', '2012-10-29', 6, '23.00', 'Bayaran Tunai', 'Lulus', 0, 'Sila buat dengan teliti, kalau sudah siap, inform ok', 'Capture8.jpg'),
(149, '921030085583', 'CT03-RED', '2012-10-31', 3, '21.00', 'Bayaran Tunai', 'Belum disahkan', 0, 'tiada', NULL),
(126, ' 920517105554', 'CT02-NAVY ', '2012-10-29', 5, '20.00', 'Bayaran Tunai', 'Lulus', 0, 'Guna teknik yang high quality ok', 'Capture5.PNG'),
(125, ' 920517105554', 'CT02-NAVY ', '2012-10-29', 5, '20.00', 'Bayaran Tunai', 'Lulus', 0, 'Saya nak warna merah glow in the dark', 'Capture2.PNG'),
(160, ' 920517105553', 'CT02-NAVY ', '2013-03-21', 5, '20.00', 'Bayaran Tunai', 'Belum disahkan', 0, 'hacked', 'Anonymous_logo_270x236.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
