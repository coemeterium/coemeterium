-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2017 at 07:35 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coemeterium`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(12) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'unpublished',
  `createdBy` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `d_person`
--

CREATE TABLE `d_person` (
  `id` int(12) NOT NULL,
  `code` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `middleName` varchar(254) NOT NULL,
  `gender` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `placeOfBirth` text NOT NULL,
  `graveCode` varchar(100) NOT NULL,
  `level` int(20) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `dateOfDeath` date NOT NULL,
  `causedOfDeath` varchar(254) NOT NULL,
  `type_mnth_or_yr` varchar(50) NOT NULL,
  `type_rent_or_tit` varchar(50) NOT NULL,
  `remarks` text NOT NULL,
  `graveExpirationDate` date NOT NULL,
  `status` varchar(254) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grave`
--

CREATE TABLE `grave` (
  `id` int(12) NOT NULL,
  `code` varchar(100) NOT NULL,
  `level` int(11) NOT NULL,
  `type` varchar(245) NOT NULL,
  `dPersonId` int(12) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'vacant',
  `expirationDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grave_images`
--

CREATE TABLE `grave_images` (
  `id` int(12) NOT NULL,
  `graveCode` varchar(254) NOT NULL,
  `graveLevel` int(12) NOT NULL,
  `recordId` int(12) NOT NULL,
  `fileName` longtext NOT NULL,
  `fileLocation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `userGivenId` int(12) DEFAULT NULL,
  `firstName` varchar(50) NOT NULL,
  `middleName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `gender` varchar(12) NOT NULL,
  `birthdate` date NOT NULL,
  `address` varchar(50) NOT NULL,
  `mobileNo` varchar(13) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profilePicture` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `clearPassword` varchar(50) NOT NULL,
  `userType` varchar(15) NOT NULL,
  `status` varchar(12) NOT NULL DEFAULT 'pending',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `yearLevel` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userGivenId`, `firstName`, `middleName`, `lastName`, `gender`, `birthdate`, `address`, `mobileNo`, `email`, `profilePicture`, `username`, `password`, `clearPassword`, `userType`, `status`, `created`, `yearLevel`) VALUES
(50, NULL, 'Admin', '', 'Org', 'male', '1991-07-08', 'cebu city', '09229292377', 'admin_org@gmail.com', '', 'admin_org', '34f37879261a865738da8e9ccd6fd803', '', 'admin', 'active', '2016-12-03 04:08:07', 7),
(88, NULL, 'John', '', 'Doe', 'male', '1991-07-08', 'cebu', '09229292388', 'admin_john_doe@gmail.com', '', 'admin', '21232f297a57a5a743894a0e4a801fc3', '', 'admin', 'active', '2016-12-03 04:48:40', 6),
(89, NULL, 'Tue', '', 'Dwang', 'female', '1957-02-18', 'asdfds', '3434', 'darz.delgado@gmail.com', '', 'tttt', '32bf0e6fcff51e53bd74e70ba1d622b2', '', 'admin', 'active', '2017-03-04 15:56:25', 0),
(90, NULL, 'Tan', '', 'Elizardo', 'male', '1957-01-19', 'sadf', '90909', 'darz.delgado@gmail.com', '', 'u', '7b774effe4a349c6dd82ad4f4f21d34c', '', 'admin', 'active', '2017-03-04 15:56:16', 0),
(91, NULL, 'Ghu', '', 'Kui', 'male', '1957-01-18', 'sfdf', '90909', 'darz.delgado@gmail.com', '', 'i', '865c0c0b4ab0e063e5caa3387c1a8741', '', 'user', 'active', '2017-03-04 15:56:37', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `d_person`
--
ALTER TABLE `d_person`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grave`
--
ALTER TABLE `grave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grave_images`
--
ALTER TABLE `grave_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `d_person`
--
ALTER TABLE `d_person`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;
--
-- AUTO_INCREMENT for table `grave`
--
ALTER TABLE `grave`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=341;
--
-- AUTO_INCREMENT for table `grave_images`
--
ALTER TABLE `grave_images`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
