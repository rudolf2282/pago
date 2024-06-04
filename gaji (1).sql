-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2024 at 09:08 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gaji`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gaji`
--

CREATE TABLE `tbl_gaji` (
  `id` int(11) NOT NULL,
  `ID_Gaji` int(11) NOT NULL,
  `NIK` int(11) NOT NULL,
  `Tanggal` date NOT NULL,
  `Id_Karyawan` int(11) NOT NULL,
  `Jabatan` varchar(50) NOT NULL,
  `Gaji_Pokok` int(11) NOT NULL,
  `Tunjangan_Jabatan` int(11) NOT NULL,
  `Status` enum('Kawin','Belum Kawin') NOT NULL,
  `Jumlah_Anak` smallint(2) NOT NULL,
  `Tunjangan_Anak` int(11) NOT NULL,
  `BPJS` int(11) NOT NULL,
  `PPh21` int(11) NOT NULL,
  `Total_Pendapatan` int(11) NOT NULL,
  `Total_Potongan` int(11) NOT NULL,
  `Gaji_Bersih` int(11) NOT NULL,
  `Id_User` smallint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_gaji`
--

INSERT INTO `tbl_gaji` (`id`, `ID_Gaji`, `NIK`, `Tanggal`, `Id_Karyawan`, `Jabatan`, `Gaji_Pokok`, `Tunjangan_Jabatan`, `Status`, `Jumlah_Anak`, `Tunjangan_Anak`, `BPJS`, `PPh21`, `Total_Pendapatan`, `Total_Potongan`, `Gaji_Bersih`, `Id_User`) VALUES
(5, 0, 0, '2024-05-27', 2, 'Manejer Keuangan', 9000000, 900000, 'Kawin', 3, 1350000, 360000, 180000, 11250000, 540000, 10710000, 1),
(6, 0, 0, '2024-05-27', 3, 'Manejer IT', 8500000, 850000, 'Kawin', 3, 1275000, 340000, 170000, 10625000, 510000, 10115000, 1),
(7, 0, 0, '2024-06-02', 2, 'Manejer Keuangan', 9000000, 900000, 'Kawin', 3, 1350000, 360000, 180000, 11250000, 540000, 10710000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jabatan`
--

CREATE TABLE `tbl_jabatan` (
  `id` int(11) NOT NULL,
  `Nama_Jabatan` varchar(50) NOT NULL,
  `Gaji_Pokok` int(11) NOT NULL,
  `Tunjangan_Jabatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_jabatan`
--

INSERT INTO `tbl_jabatan` (`id`, `Nama_Jabatan`, `Gaji_Pokok`, `Tunjangan_Jabatan`) VALUES
(1, 'Manejer IT', 8500000, 850000),
(2, 'Manejer Keuangan', 9000000, 900000),
(3, 'Maneger Pemasaran', 8000000, 800000),
(4, 'Staff IT', 4500000, 450000),
(5, 'Staff Keuangan', 5000000, 500000),
(6, 'Staff Pemasaran', 4750000, 475000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_karyawan`
--

CREATE TABLE `tbl_karyawan` (
  `id` int(11) NOT NULL,
  `Id_Karyawan` int(11) NOT NULL,
  `NIK` varchar(10) NOT NULL,
  `Nama` varchar(35) NOT NULL,
  `Id_Jabatan` int(11) NOT NULL,
  `Status` enum('Kawin','Belum Kawin') NOT NULL,
  `Jumlah_Anak` smallint(2) NOT NULL,
  `Tunjangan_Anak` int(11) NOT NULL,
  `Gaji_Pokok` int(11) NOT NULL,
  `Tunjangan_Jabatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_karyawan`
--

INSERT INTO `tbl_karyawan` (`id`, `Id_Karyawan`, `NIK`, `Nama`, `Id_Jabatan`, `Status`, `Jumlah_Anak`, `Tunjangan_Anak`, `Gaji_Pokok`, `Tunjangan_Jabatan`) VALUES
(2, 0, 'KAR-01', 'Merlien', 2, 'Kawin', 3, 1350000, 9000000, 900000),
(3, 0, 'KAR-02', 'Rudolf', 1, 'Kawin', 3, 1275000, 8500000, 850000),
(6, 0, 'KAR-04', 'Joice', 6, 'Belum Kawin', 0, 0, 4750000, 475000),
(8, 0, 'KAR-04', 'Joy', 3, 'Kawin', 1, 400000, 8000000, 800000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` smallint(2) NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `user_name`, `email`, `password`) VALUES
(1, 'Ambarwati', 'ambar@yahoo.com', 'ambar123'),
(2, 'Rini', 'rini@yahoo.com', 'rini123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_gaji`
--
ALTER TABLE `tbl_gaji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Id_Karyawan` (`Id_Karyawan`),
  ADD KEY `Id_User` (`Id_User`);

--
-- Indexes for table `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_karyawan`
--
ALTER TABLE `tbl_karyawan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Id_Jabatan` (`Id_Jabatan`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_gaji`
--
ALTER TABLE `tbl_gaji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_karyawan`
--
ALTER TABLE `tbl_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` smallint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_gaji`
--
ALTER TABLE `tbl_gaji`
  ADD CONSTRAINT `tbl_gaji_ibfk_1` FOREIGN KEY (`Id_Karyawan`) REFERENCES `tbl_karyawan` (`id`),
  ADD CONSTRAINT `tbl_gaji_ibfk_2` FOREIGN KEY (`Id_User`) REFERENCES `tbl_user` (`id`);

--
-- Constraints for table `tbl_karyawan`
--
ALTER TABLE `tbl_karyawan`
  ADD CONSTRAINT `tbl_karyawan_ibfk_1` FOREIGN KEY (`Id_Jabatan`) REFERENCES `tbl_jabatan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
