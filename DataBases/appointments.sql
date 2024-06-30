-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 28, 2024 at 06:00 PM
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
-- Database: `appointments`
--

-- --------------------------------------------------------

--
-- Table structure for table `available_appointments`
--

CREATE TABLE `available_appointments` (
  `AppointmentID` int NOT NULL,
  `app_date` date NOT NULL,
  `app_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `available_appointments`
--

INSERT INTO `available_appointments` (`AppointmentID`, `app_date`, `app_time`) VALUES
(1, '2024-05-25', '08:00:00'),
(2, '2024-05-25', '10:00:00'),
(4, '2024-05-25', '12:00:00'),
(5, '2024-05-30', '09:00:00'),
(6, '2024-05-30', '11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `booked_appointments`
--

CREATE TABLE `booked_appointments` (
  `booked_AppointmentID` int NOT NULL,
  `app_date` date NOT NULL,
  `app_time` time NOT NULL,
  `client` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `booked_appointments`
--

INSERT INTO `booked_appointments` (`booked_AppointmentID`, `app_date`, `app_time`, `client`) VALUES
(7, '2024-05-25', '11:00:00', 'omar J');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `available_appointments`
--
ALTER TABLE `available_appointments`
  ADD PRIMARY KEY (`AppointmentID`);

--
-- Indexes for table `booked_appointments`
--
ALTER TABLE `booked_appointments`
  ADD PRIMARY KEY (`booked_AppointmentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booked_appointments`
--
ALTER TABLE `booked_appointments`
  MODIFY `booked_AppointmentID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
