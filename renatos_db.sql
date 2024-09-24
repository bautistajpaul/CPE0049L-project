-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2024 at 07:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `renatosplace_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `renatos_db`
--

CREATE TABLE `renatos_db` (
  `id` int(11) NOT NULL,
  `FullName` varchar(150) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `ContactNumber` int(11) NOT NULL,
  `FullAddress` varchar(250) NOT NULL,
  `NumberofGuests` int(11) NOT NULL,
  `roomNum` int(11) NOT NULL,
  `PreferredDateofStay` varchar(150) NOT NULL,
  `PoolOptions` varchar(250) NOT NULL,
  `RoomOptions` varchar(250) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `renatos_db`
--

INSERT INTO `renatos_db` (`id`, `FullName`, `Email`, `ContactNumber`, `FullAddress`, `NumberofGuests`, `roomNum`, `PreferredDateofStay`, `PoolOptions`, `RoomOptions`, `Date`) VALUES
(1, 'Doms Cristo', 'DC7@gmail.com', 2024, '1', 1, 0, '2', '', '', '2024-08-23'),
(4, 'Rohan Victor', 'rohan@gmail.com', 2147483647, 'ortigas-cainta', 5, 0, '2024-08-28', '5', '', '0000-00-00'),
(5, 'rohan victor', 'rohan@gmail.com', 544554854, 'cainta', 7, 0, '2024-08-30', '4', '', '2024-08-27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `renatos_db`
--
ALTER TABLE `renatos_db`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `renatos_db`
--
ALTER TABLE `renatos_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
