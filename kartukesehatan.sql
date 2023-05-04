-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2023 at 01:27 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `utsapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `kartukesehatan`
--

CREATE TABLE `kartukesehatan` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `usia` int(11) NOT NULL,
  `jenis_kelamin` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_telp` varchar(255) NOT NULL,
  `tgl_buat` date NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kartukesehatan`
--

INSERT INTO `kartukesehatan` (`id`, `nama`, `usia`, `jenis_kelamin`, `alamat`, `no_telp`, `tgl_buat`, `is_active`) VALUES
(1, 'Luthfi Nur Ramadhan', 20, 'Laki-Laki', 'Jl.Madesa Rt.05 Rw.11 Blok.K No.21', '085722584498', '2023-04-05', 1),
(2, 'Izuchii', 17, 'Perempuan', 'Jl.Kochi Rt.02 Rw.07 No.221', '089976529182', '2022-09-07', 0),
(3, 'Yae ', 24, 'Perempuan', 'Jl.Inazuma Rt.01 Rw.06 Blok.M No.43', '081322458920', '2016-04-21', 0),
(4, 'Hutao', 19, 'Perempuan', 'Jl.Liyue Harbour No.88', '081399891232', '2017-04-13', 1),
(5, 'tessa', 19, 'perempuan', 'Jl.Buah batu No.22', '085721262181', '2021-01-04', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kartukesehatan`
--
ALTER TABLE `kartukesehatan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kartukesehatan`
--
ALTER TABLE `kartukesehatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
