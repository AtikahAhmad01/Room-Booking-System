-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2024 at 09:58 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinebooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `resevID` int NOT NULL,
  `DeptName` varchar(350) COLLATE utf8mb4_general_ci NOT NULL,
  `VenueName` varchar(350) COLLATE utf8mb4_general_ci NOT NULL,
  `activity` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `Times` varchar(450) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`resevID`, `DeptName`, `VenueName`, `activity`, `Times`, `date`) VALUES
(26, 'HSE', 'Bilik Seminar', 'BRIEFING', '9:00 A.M', '2024-05-21'),
(27, 'HRA', 'Discussion Room 1', 'DISCUSSION', '2:00 A.M', '2024-06-05'),
(28, 'HRA', 'Meeting Room 1', 'meeting', '1-2', '2024-03-06'),
(29, 'HRA', 'Bilik Seminar', 'Taklimat', '2:30 pm', '2024-03-20');

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE `venue` (
  `VenueId` int NOT NULL,
  `VenueName` varchar(350) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue`
--

INSERT INTO `venue` (`VenueId`, `VenueName`) VALUES
(1, 'Meeting Room 1'),
(2, 'Meeting Room 2'),
(3, 'Bilik Seminar'),
(4, 'Discussion Room 1'),
(5, 'Discussion Room 2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`resevID`) USING BTREE,
  ADD KEY `DeptId` (`DeptName`) USING BTREE,
  ADD KEY `VenueId` (`VenueName`) USING BTREE;

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`VenueId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `resevID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
