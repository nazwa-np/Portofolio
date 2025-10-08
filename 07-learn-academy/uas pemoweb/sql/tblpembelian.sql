-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2022 at 12:52 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tblpembelian`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblpembelian`
--

CREATE TABLE `tblpembelian` (
  `id` int(11) NOT NULL,
  `nama_pembeli` varchar(50) NOT NULL,
  `email_pembeli` varchar(50) NOT NULL,
  `phone` int(50) NOT NULL,
  `alamat_pembeli` varchar(50) NOT NULL,
  `jenis_paket` varchar(50) NOT NULL,
  `tanggal_pemesanan` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblpembelian`
--

INSERT INTO `tblpembelian` (`id`, `nama_pembeli`, `email_pembeli`, `phone`, `alamat_pembeli`, `jenis_paket`, `tanggal_pemesanan`) VALUES
(2, 'ikii', 'iki12@gmail.com', 2147483647, 'jl.no 1', 'paket_b', '2022-06-16 17:03:00.000000'),
(3, 'farra', 'faraa12@gmail.com', 2147483647, 'jlm.no 3', 'paket_a', '2022-06-16 17:04:00.000000'),
(4, 'Tika', 'iki12@gmail.com', 2147483647, 'jl.no 1', 'paket_c', '2022-06-16 17:29:00.000000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblpembelian`
--
ALTER TABLE `tblpembelian`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblpembelian`
--
ALTER TABLE `tblpembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
