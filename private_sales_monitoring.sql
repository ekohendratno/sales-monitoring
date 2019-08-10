-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2013 at 06:57 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `private_sales_monitoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
  `no_barang` int(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(30) NOT NULL,
  `harga_satuan` int(30) NOT NULL,
  `jumlah_barang` int(12) NOT NULL,
  PRIMARY KEY (`no_barang`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`no_barang`, `nama_barang`, `harga_satuan`, `jumlah_barang`) VALUES
(1, 'Kartu Perdana 30K', 3000, 986),
(2, 'Kartu Perdana 50K', 5000, 993),
(3, 'Always ON (AON) 1 Bulan', 10000, 415),
(4, 'Always ON (AON) 6 Bulan', 35000, 495),
(5, 'Always ON (AON) 12 Bulan', 50000, 495),
(6, 'Regular 500MB', 35000, 1000),
(7, 'Regular 1GB', 50000, 995),
(8, 'Regular 3GB', 75000, 992),
(9, 'Regular 5GB', 125000, 500),
(10, 'Kenyang Download 1,5GB', 10000, 500),
(11, 'Kenyang Download 10GB', 50000, 500);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE IF NOT EXISTS `penjualan` (
  `id_penjualan` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_retailer` int(11) NOT NULL,
  `jumlah_terjual` int(12) NOT NULL,
  `date` datetime NOT NULL,
  `approv_sales` int(1) NOT NULL DEFAULT '0',
  `approv_be` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_penjualan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_barang`, `id_users`, `id_retailer`, `jumlah_terjual`, `date`, `approv_sales`, `approv_be`) VALUES
(1, 7, 4, 1, 5, '2013-01-07 17:24:42', 1, 0),
(2, 8, 4, 1, 2, '2013-01-07 17:25:12', 1, 0),
(3, 1, 4, 2, 5, '2013-01-07 17:28:59', 1, 0),
(4, 2, 4, 1, 5, '2013-01-07 17:29:18', 1, 0),
(5, 2, 4, 3, 2, '2013-01-07 17:35:46', 1, 0),
(6, 8, 4, 1, 6, '2013-01-09 11:06:24', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `retailer`
--

CREATE TABLE IF NOT EXISTS `retailer` (
  `id_retailer` int(11) NOT NULL AUTO_INCREMENT,
  `id_be` int(11) NOT NULL,
  `nama_retailer` varchar(80) NOT NULL,
  `alamat_retailer` text NOT NULL,
  `gambar_retailer` longtext NOT NULL,
  `status_retailer` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_retailer`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `retailer`
--

INSERT INTO `retailer` (`id_retailer`, `id_be`, `nama_retailer`, `alamat_retailer`, `gambar_retailer`, `status_retailer`) VALUES
(1, 3, 'Alam Cell', 'Jl Pertama Gang Sempit Bandar Lampung', '20130109120919@administrator@mp3-edit-1.jpg', 1),
(2, 3, 'Barca Cell', 'Jl Kedua Gang Sempit Bandar Lampung', '', 1),
(3, 3, 'Candra Cell', 'Jl Ketiga Gang Sempit Bandar Lampung', '', 1),
(4, 3, 'Dodoy Cell', 'Jl Keempat Gang Sempit Bandar Lampung', '', 1),
(5, 3, 'Edy Cell', 'Jl Kelima Gang Sempit Bandar Lampung', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_be_id` int(11) NOT NULL,
  `nama_pengguna` varchar(30) NOT NULL,
  `kata_sandi` text NOT NULL,
  `email` text NOT NULL,
  `jabatan` enum('sales','be','as','administrator') NOT NULL,
  `nama_user` varchar(80) NOT NULL,
  `jenis_kelamin` enum('p','l') NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `area` text NOT NULL,
  `gambar` longtext NOT NULL,
  `status_account` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_be_id`, `nama_pengguna`, `kata_sandi`, `email`, `jabatan`, `nama_user`, `jenis_kelamin`, `alamat`, `no_telp`, `area`, `gambar`, `status_account`) VALUES
(1, 0, 'administrator', '200ceb26807d6bf99fd6f4f0d1ca54d4', 'administrator@sales-monitoring.com', 'administrator', 'Mr Administrator', 'l', '', '', '', '20130107045618@administrator@67367_10151465450538296_1643718994_n.jpg', 1),
(2, 0, 'adminsupport', '8d66f6146f54a831118a463bbc633289', 'adminsupport@sm.net63.net', 'as', 'Mrs Admin Support', 'p', '', '', '', '', 1),
(3, 0, 'be', '910955a907e739b81ec8855763108a29', 'be@sm.net63.net', 'be', 'Mr BE', 'l', 'Bandar Lampung', '089712345678', 'Bandar Lampung', '20130109010323@be@michael.jpg', 1),
(4, 3, 'sales', '9ed083b1436e5f40ef984b28255eef18', 'sales@sm.net63.net', 'sales', 'Sales', 'l', 'Jl Sempit, gg lebar, Bandar Lampung', '08976118097', '', '20130107052751@sales@57ab61ce05cf11e2bf7c22000a1e9ddc_7.jpg', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
