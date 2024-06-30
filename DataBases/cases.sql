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
-- Database: `cases`
--

-- --------------------------------------------------------

--
-- Table structure for table `my_cases`
--

CREATE TABLE `my_cases` (
  `CaseID` int NOT NULL,
  `AnimalID` int NOT NULL,
  `BirthDate` date NOT NULL,
  `Species` varchar(30) NOT NULL,
  `animalName` varchar(30) NOT NULL,
  `OwnerName` varchar(30) NOT NULL,
  `BloodTestResult` varchar(255) NOT NULL,
  `Treatment` varchar(255) NOT NULL,
  `caseDescription` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `my_cases`
--

INSERT INTO `my_cases` (`CaseID`, `AnimalID`, `BirthDate`, `Species`, `animalName`, `OwnerName`, `BloodTestResult`, `Treatment`, `caseDescription`) VALUES
(1, 22, '2005-05-05', 'Dog', 'Max', 'omar J', ' Blood Test Result ', ' Treatment ', ' Description '),
(5, 3141, '2222-02-02', 'sadfdsf', 'sadfdf', 'omar J', '   sadfadsfa ', '   safddasf ', '   sadfsdaf ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `my_cases`
--
ALTER TABLE `my_cases`
  ADD PRIMARY KEY (`CaseID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `my_cases`
--
ALTER TABLE `my_cases`
  MODIFY `CaseID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
