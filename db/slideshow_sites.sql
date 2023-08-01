-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 08 Jan 2016 pada 18.06
-- Versi Server: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bigtv_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `slideshow_sites`
--

CREATE TABLE IF NOT EXISTS `slideshow_sites` (
  `id_slideshow_sites` int(10) NOT NULL,
  `id_slideshow` int(11) DEFAULT NULL COMMENT 'id_slideshow is an index column',
  `id_site` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `slideshow_sites`
--
ALTER TABLE `slideshow_sites`
  ADD PRIMARY KEY (`id_slideshow_sites`), ADD KEY `id_slideshow` (`id_slideshow`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `slideshow_sites`
--
ALTER TABLE `slideshow_sites`
  MODIFY `id_slideshow_sites` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
