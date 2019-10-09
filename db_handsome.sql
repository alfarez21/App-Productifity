-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 20 Sep 2019 pada 10.14
-- Versi Server: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_handsome`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_produksi`
--

CREATE TABLE `detail_produksi` (
  `IdDetailProduksi` char(16) NOT NULL,
  `RegProduksi` char(16) DEFAULT NULL,
  `RegPegawai` char(16) DEFAULT NULL,
  `IdLine` int(11) DEFAULT NULL,
  `Target` char(6) DEFAULT NULL,
  `HasilProduksi` char(6) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_produksi`
--

INSERT INTO `detail_produksi` (`IdDetailProduksi`, `RegProduksi`, `RegPegawai`, `IdLine`, `Target`, `HasilProduksi`) VALUES
('20190920030253', '20190920030246', '20190916084726', 1, '1', '0'),
('20190920030305', '20190920030246', '20190916084806', 2, '2', '0'),
('20190920030340', '20190920030327', '20190916084726', 1, '11', '0'),
('20190920030348', '20190920030327', '20190916084806', 2, '22', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `level`
--

CREATE TABLE `level` (
  `IdLevel` int(6) NOT NULL,
  `NamaLevel` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `level`
--

INSERT INTO `level` (`IdLevel`, `NamaLevel`) VALUES
(1, 'Administrator'),
(2, 'Manager'),
(3, 'Leader Line');

-- --------------------------------------------------------

--
-- Struktur dari tabel `line`
--

CREATE TABLE `line` (
  `IdLine` int(11) NOT NULL,
  `NamaLine` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `line`
--

INSERT INTO `line` (`IdLine`, `NamaLine`) VALUES
(1, 'Line 1'),
(2, 'Line 2'),
(3, 'Line 3'),
(4, 'Line 4'),
(5, 'Line 5'),
(6, 'Line 6'),
(7, 'Line 7'),
(8, 'Line 8'),
(9, 'Line 9'),
(10, 'Line 10'),
(11, 'Line 11'),
(12, 'Line 12'),
(13, 'Line 13'),
(14, 'Line 14'),
(15, 'Line 15'),
(16, 'Line 16'),
(17, 'Line 17'),
(18, 'Line 18'),
(19, 'Line 19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `RegPegawai` char(16) NOT NULL,
  `IdLevel` int(6) DEFAULT NULL,
  `IdLine` int(11) DEFAULT NULL,
  `Username` char(60) DEFAULT NULL,
  `Password` char(50) DEFAULT NULL,
  `Nama` varchar(100) DEFAULT NULL,
  `Gender` enum('L','P') DEFAULT 'L',
  `TempatLahir` varchar(200) DEFAULT NULL,
  `TanggalLahir` date DEFAULT '2000-01-01'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`RegPegawai`, `IdLevel`, `IdLine`, `Username`, `Password`, `Nama`, `Gender`, `TempatLahir`, `TanggalLahir`) VALUES
('20190916084640', 1, NULL, 'admin', '0cc175b9c0f1b6a831c399e269772661', 'Administator', 'L', 'subang', '2011-11-11'),
('20190916084726', 3, 1, 'leaderline1', '0cc175b9c0f1b6a831c399e269772661', 'LeaderLine1', 'L', 'subang', '2011-11-11'),
('20190916084806', 3, 2, 'leaderline2', '0cc175b9c0f1b6a831c399e269772661', 'LeaderLine2', 'L', 'subang', '2011-11-11'),
('20190916091247', 2, NULL, 'manager', '0cc175b9c0f1b6a831c399e269772661', 'Manager', 'P', 'subang', '2011-11-11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produksi`
--

CREATE TABLE `produksi` (
  `RegProduksi` char(16) NOT NULL,
  `RegPegawai` char(16) DEFAULT NULL,
  `Tanggal` date DEFAULT '2000-01-01'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `produksi`
--

INSERT INTO `produksi` (`RegProduksi`, `RegPegawai`, `Tanggal`) VALUES
('20190920030246', '20190916091247', '2001-01-01'),
('20190920030327', '20190916091247', '2001-01-02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_produksi`
--
ALTER TABLE `detail_produksi`
  ADD PRIMARY KEY (`IdDetailProduksi`),
  ADD KEY `RegProduksi` (`RegProduksi`),
  ADD KEY `RegPegawai` (`RegPegawai`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`IdLevel`);

--
-- Indexes for table `line`
--
ALTER TABLE `line`
  ADD PRIMARY KEY (`IdLine`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`RegPegawai`),
  ADD KEY `IdLevel` (`IdLevel`),
  ADD KEY `IdLine` (`IdLine`);

--
-- Indexes for table `produksi`
--
ALTER TABLE `produksi`
  ADD PRIMARY KEY (`RegProduksi`),
  ADD KEY `RegPegawai` (`RegPegawai`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_produksi`
--
ALTER TABLE `detail_produksi`
  ADD CONSTRAINT `detail_produksi_ibfk_1` FOREIGN KEY (`RegProduksi`) REFERENCES `produksi` (`RegProduksi`),
  ADD CONSTRAINT `detail_produksi_ibfk_2` FOREIGN KEY (`RegPegawai`) REFERENCES `pegawai` (`RegPegawai`);

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`IdLevel`) REFERENCES `level` (`IdLevel`),
  ADD CONSTRAINT `pegawai_ibfk_2` FOREIGN KEY (`IdLine`) REFERENCES `line` (`IdLine`);

--
-- Ketidakleluasaan untuk tabel `produksi`
--
ALTER TABLE `produksi`
  ADD CONSTRAINT `produksi_ibfk_1` FOREIGN KEY (`RegPegawai`) REFERENCES `pegawai` (`RegPegawai`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
