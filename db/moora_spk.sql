-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2022 at 04:16 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moora_spk`
--

-- --------------------------------------------------------

--
-- Table structure for table `tab_alternatif`
--

CREATE TABLE `tab_alternatif` (
  `id_alternatif` varchar(10) NOT NULL,
  `nama_alternatif` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab_alternatif`
--

INSERT INTO `tab_alternatif` (`id_alternatif`, `nama_alternatif`) VALUES
('1', 'Bobby Brown'),
('10', 'Madame Gie'),
('2', 'Etude House'),
('3', 'Y.O.U'),
('4', 'Innisfree'),
('5', 'Focallure'),
('6', 'Maybelline'),
('7', 'Purbasari'),
('8', 'Tony Moly'),
('9', 'Emina');

-- --------------------------------------------------------

--
-- Table structure for table `tab_kriteria`
--

CREATE TABLE `tab_kriteria` (
  `id_kriteria` varchar(10) NOT NULL,
  `nama_kriteria` varchar(50) NOT NULL,
  `type` varchar(10) NOT NULL,
  `bobot` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab_kriteria`
--

INSERT INTO `tab_kriteria` (`id_kriteria`, `nama_kriteria`, `type`, `bobot`) VALUES
('1', 'Harga', 'cost', 18),
('2', 'Pigmentasi', 'benefit', 20),
('3', 'Variasi Shade', 'benefit', 21),
('4', 'Ketahanan', 'benefit', 21),
('5', 'Transferproof', 'benefit', 20);

-- --------------------------------------------------------

--
-- Table structure for table `tab_nilai`
--

CREATE TABLE `tab_nilai` (
  `id_nilai` int(10) NOT NULL,
  `altern` varchar(50) NOT NULL,
  `krit` varchar(50) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tab_poin`
--

CREATE TABLE `tab_poin` (
  `id_poin` varchar(10) NOT NULL,
  `id_alternatif` varchar(10) NOT NULL,
  `id_kriteria` varchar(10) NOT NULL,
  `poin` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tab_topsis`
--

CREATE TABLE `tab_topsis` (
  `id_alternatif` varchar(10) NOT NULL,
  `id_kriteria` varchar(10) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab_topsis`
--

INSERT INTO `tab_topsis` (`id_alternatif`, `id_kriteria`, `nilai`) VALUES
('1', '1', 345000),
('1', '2', 3),
('1', '3', 7),
('1', '4', 2),
('1', '5', 0),
('10', '1', 23000),
('10', '2', 3),
('10', '3', 8),
('10', '4', 2),
('10', '5', 0),
('2', '1', 35000),
('2', '2', 3),
('2', '3', 10),
('2', '4', 2),
('2', '5', 1),
('3', '1', 45000),
('3', '2', 4),
('3', '3', 6),
('3', '4', 4),
('3', '5', 1),
('4', '1', 150000),
('4', '2', 4),
('4', '3', 10),
('4', '4', 4),
('4', '5', 1),
('5', '1', 129045),
('5', '2', 3),
('5', '3', 7),
('5', '4', 3),
('5', '5', 0),
('6', '1', 119000),
('6', '2', 2),
('6', '3', 5),
('6', '4', 2),
('6', '5', 0),
('7', '1', 38500),
('7', '2', 3),
('7', '3', 3),
('7', '4', 4),
('7', '5', 1),
('8', '1', 28000),
('8', '2', 3),
('8', '3', 3),
('8', '4', 2),
('8', '5', 1),
('9', '1', 46000),
('9', '2', 4),
('9', '3', 6),
('9', '4', 3),
('9', '5', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tab_alternatif`
--
ALTER TABLE `tab_alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indexes for table `tab_kriteria`
--
ALTER TABLE `tab_kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `tab_nilai`
--
ALTER TABLE `tab_nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indexes for table `tab_poin`
--
ALTER TABLE `tab_poin`
  ADD PRIMARY KEY (`id_poin`),
  ADD KEY `id_alternatif` (`id_alternatif`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indexes for table `tab_topsis`
--
ALTER TABLE `tab_topsis`
  ADD PRIMARY KEY (`id_alternatif`,`id_kriteria`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tab_poin`
--
ALTER TABLE `tab_poin`
  ADD CONSTRAINT `tab_poin_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `tab_alternatif` (`id_alternatif`),
  ADD CONSTRAINT `tab_poin_ibfk_2` FOREIGN KEY (`id_kriteria`) REFERENCES `tab_kriteria` (`id_kriteria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
