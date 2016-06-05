-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2015 at 07:31 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rental_7262442`
--
CREATE DATABASE IF NOT EXISTS `rental_7262442` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `rental_7262442`;

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE IF NOT EXISTS `matches` (
  `owner` varchar(30) NOT NULL DEFAULT '',
  `tenant` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`owner`),
  KEY `matches_ibfk_2` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`owner`, `tenant`) VALUES
('esthere', 'charlesc'),
('carolc', 'davidd'),
('bettyb', 'elieel'),
('denised', 'harrya'),
('alicea', 'steveb');

-- --------------------------------------------------------

--
-- Table structure for table `owner_selection`
--

CREATE TABLE IF NOT EXISTS `owner_selection` (
  `username` varchar(30) NOT NULL DEFAULT '',
  `gender` enum('m','f','non') DEFAULT NULL,
  `ilevel` enum('high','mid','low','non') DEFAULT NULL,
  `pets` enum('yes','no','non') DEFAULT NULL,
  `smoke` enum('yes','no','non') DEFAULT NULL,
  `nat` enum('canada','international') DEFAULT NULL,
  `specNat` varchar(30) DEFAULT NULL,
  `pro` enum('white','blue','unemployed','student','non') DEFAULT NULL,
  `specPro` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `owner_selection`
--

INSERT INTO `owner_selection` (`username`, `gender`, `ilevel`, `pets`, `smoke`, `nat`, `specNat`, `pro`, `specPro`) VALUES
('alicea', 'f', 'mid', 'no', 'yes', 'international', 'USA', '', 'N/A'),
('bettyb', 'f', 'low', 'yes', 'no', 'canada', 'N/A', '', 'N/A'),
('carolc', 'non', 'non', 'non', 'non', '', 'N/A', 'student', 'N/A'),
('denised', 'm', 'high', 'yes', 'yes', 'international', 'Mexico', 'unemployed', 'N/A'),
('esthere', 'f', 'low', 'non', 'yes', 'canada', 'N/A', '', 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE IF NOT EXISTS `properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `address` varchar(30) DEFAULT NULL,
  `city` varchar(30) DEFAULT 'Montreal',
  `postal` char(6) DEFAULT NULL,
  `sector` enum('center','east','west','north','laval') DEFAULT 'center',
  `type` varchar(5) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `available` date DEFAULT NULL,
  `area` double DEFAULT NULL,
  `total_rooms` int(11) DEFAULT NULL,
  `bed_rooms` int(11) DEFAULT NULL,
  `bath_rooms` int(11) DEFAULT NULL,
  `airc` tinyint(1) DEFAULT '0',
  `park` tinyint(1) DEFAULT '0',
  `yard` tinyint(1) DEFAULT '0',
  `balc` tinyint(1) DEFAULT '0',
  `tran` tinyint(1) DEFAULT '0',
  `pool` tinyint(1) DEFAULT '0',
  `htub` tinyint(1) DEFAULT '0',
  `wifi` tinyint(1) DEFAULT '0',
  `wash` tinyint(1) DEFAULT '0',
  `elev` tinyint(1) DEFAULT '0',
  `other` blob,
  PRIMARY KEY (`id`),
  KEY `properties_ibfk_1` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `username`, `address`, `city`, `postal`, `sector`, `type`, `price`, `available`, `area`, `total_rooms`, `bed_rooms`, `bath_rooms`, `airc`, `park`, `yard`, `balc`, `tran`, `pool`, `htub`, `wifi`, `wash`, `elev`, `other`) VALUES
(1, 'alicea', '111 demaisoneuve', 'Montreal', 'q1q1q1', 'center', '2', 1200, '2015-04-16', 10000, 4, 2, 2, 1, 0, 0, 1, 1, 0, 0, 1, 0, 1, NULL),
(2, 'bettyb', '222 sherbrooke', 'Montreal', 'q1q1q1', 'center', 'loft', 1800, '2015-06-01', 18000, 4, 2, 2, 1, 1, 0, 1, 1, 0, 0, 1, 1, 1, NULL),
(3, 'carolc', '333 outinnowhere', 'Montreal', 'z1z1z1', 'north', '4', 1000, '2015-08-01', 50000, 10, 6, 3, 1, 1, 1, 1, 0, 1, 1, 0, 1, 0, NULL),
(4, 'denised', '444 partyville', 'Montreal', 'a1a1a1', 'west', '4', 2500, '2015-04-16', 100000, 15, 10, 7, 1, 1, 1, 1, 0, 1, 1, 0, 1, 1, NULL),
(5, 'esthere', '555 nowhere', 'Montreal', 'l1l1l1', 'laval', 'studi', 500, '2015-04-16', 1000, 2, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0, 0x636865617020706c616365);

-- --------------------------------------------------------

--
-- Table structure for table `property_rank`
--

CREATE TABLE IF NOT EXISTS `property_rank` (
  `username` varchar(30) NOT NULL DEFAULT '',
  `property1` int(11) DEFAULT NULL,
  `property2` int(11) DEFAULT NULL,
  `property3` int(11) DEFAULT NULL,
  `property4` int(11) DEFAULT NULL,
  `property5` int(11) DEFAULT NULL,
  PRIMARY KEY (`username`),
  KEY `property_rank_ibfk_2` (`property1`),
  KEY `property_rank_ibfk_3` (`property2`),
  KEY `property_rank_ibfk_4` (`property3`),
  KEY `property_rank_ibfk_5` (`property4`),
  KEY `property_rank_ibfk_6` (`property5`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property_rank`
--

INSERT INTO `property_rank` (`username`, `property1`, `property2`, `property3`, `property4`, `property5`) VALUES
('charlesc', 5, 1, 2, 3, 4),
('davidd', 5, 1, 2, 3, 4),
('elieel', 1, 2, 5, 3, 4),
('harrya', 2, 1, 3, 5, 4),
('steveb', 5, 1, 2, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `rental_preferences`
--

CREATE TABLE IF NOT EXISTS `rental_preferences` (
  `username` varchar(30) NOT NULL,
  `city` varchar(30) DEFAULT 'Montreal',
  `sector` enum('center','east','west','north','laval') DEFAULT 'center',
  `type` varchar(5) DEFAULT NULL,
  `minPrice` double DEFAULT NULL,
  `maxPrice` double DEFAULT NULL,
  `available` date DEFAULT NULL,
  `area` double DEFAULT '0',
  `total_rooms` int(11) DEFAULT '0',
  `bed_rooms` int(11) DEFAULT '0',
  `bath_rooms` int(11) DEFAULT '0',
  `airc` tinyint(1) DEFAULT '0',
  `park` tinyint(1) DEFAULT '0',
  `yard` tinyint(1) DEFAULT '0',
  `balc` tinyint(1) DEFAULT '0',
  `tran` tinyint(1) DEFAULT '0',
  `pool` tinyint(1) DEFAULT '0',
  `htub` tinyint(1) DEFAULT '0',
  `wifi` tinyint(1) DEFAULT '0',
  `wash` tinyint(1) DEFAULT '0',
  `elev` tinyint(1) DEFAULT '0',
  `addInfo` blob,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rental_preferences`
--

INSERT INTO `rental_preferences` (`username`, `city`, `sector`, `type`, `minPrice`, `maxPrice`, `available`, `area`, `total_rooms`, `bed_rooms`, `bath_rooms`, `airc`, `park`, `yard`, `balc`, `tran`, `pool`, `htub`, `wifi`, `wash`, `elev`, `addInfo`) VALUES
('charlesc', 'Montreal', 'center', 'studi', NULL, 700, '2015-05-01', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0x496d20706f6f72),
('davidd', 'Montreal', 'center', 'loft', NULL, 1500, '2015-09-01', 15000, 2, 1, 1, 1, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0x496d20612073747564656e742066726f6d206162726f6164),
('elieel', 'Montreal', 'center', '3', 1000, 2500, '2015-06-01', 10000, 5, 3, 2, 1, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0x496d2061207269636820646f63746f72),
('harrya', 'Montreal', 'center', '4', 5000, NULL, '2015-06-19', 20000, 10, 4, 3, 1, 1, 0, 1, 0, 1, 1, 1, 0, 1, 0x426574746572206220676f6f64),
('steveb', 'Montreal', 'east', '2', NULL, 2000, '2015-05-02', 1000, 3, 2, 1, 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0x5768617465766572);

-- --------------------------------------------------------

--
-- Table structure for table `tenant_profile`
--

CREATE TABLE IF NOT EXISTS `tenant_profile` (
  `username` varchar(15) NOT NULL DEFAULT '',
  `gender` enum('m','f') DEFAULT NULL,
  `ilevel` enum('high','mid','low') DEFAULT NULL,
  `pets` enum('Yes','No') DEFAULT 'No',
  `smoke` enum('Yes','no') DEFAULT 'no',
  `nat` enum('canada','international') DEFAULT NULL,
  `specNat` varchar(30) DEFAULT NULL,
  `pro` enum('white','blue','unemployed','student') DEFAULT NULL,
  `specPro` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tenant_profile`
--

INSERT INTO `tenant_profile` (`username`, `gender`, `ilevel`, `pets`, `smoke`, `nat`, `specNat`, `pro`, `specPro`) VALUES
('charlesc', 'm', 'mid', 'Yes', 'no', 'canada', 'N/A', 'unemployed', 'N/A'),
('davidd', 'm', 'mid', '', 'Yes', 'international', 'Italy', 'student', 'N/A'),
('elieel', 'm', 'high', 'Yes', '', 'canada', 'N/A', 'white', 'Doctor'),
('harrya', 'm', 'high', 'Yes', 'Yes', 'canada', 'N/A', 'white', 'Lawyer'),
('steveb', 'm', 'mid', '', 'Yes', 'international', 'USA', 'blue', 'Grocer');

-- --------------------------------------------------------

--
-- Table structure for table `tenant_rank`
--

CREATE TABLE IF NOT EXISTS `tenant_rank` (
  `username` varchar(30) NOT NULL DEFAULT '',
  `tenant1` varchar(30) DEFAULT NULL,
  `tenant2` varchar(30) DEFAULT NULL,
  `tenant3` varchar(30) DEFAULT NULL,
  `tenant4` varchar(30) DEFAULT NULL,
  `tenant5` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`username`),
  KEY `tenant_rank_ibfk_2` (`tenant1`),
  KEY `tenant_rank_ibfk_3` (`tenant2`),
  KEY `tenant_rank_ibfk_4` (`tenant3`),
  KEY `tenant_rank_ibfk_5` (`tenant4`),
  KEY `tenant_rank_ibfk_6` (`tenant5`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tenant_rank`
--

INSERT INTO `tenant_rank` (`username`, `tenant1`, `tenant2`, `tenant3`, `tenant4`, `tenant5`) VALUES
('alicea', 'steveb', 'davidd', 'charlesc', 'elieel', 'harrya'),
('bettyb', 'charlesc', 'elieel', 'harrya', 'davidd', 'steveb'),
('carolc', 'davidd', 'charlesc', 'elieel', 'harrya', 'steveb'),
('denised', 'charlesc', 'davidd', 'elieel', 'harrya', 'steveb'),
('esthere', 'charlesc', 'elieel', 'harrya', 'davidd', 'steveb');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(40) DEFAULT NULL,
  `userType` enum('owner','tenant') DEFAULT NULL,
  `fname` varchar(15) DEFAULT NULL,
  `lname` varchar(15) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `phone` char(13) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `userType`, `fname`, `lname`, `email`, `phone`) VALUES
('alicea', '5f6ef157f55d89dfdc757cfebeb11c0e', 'owner', 'Alice', 'A', 'alice@a.com', '(123)456-7890'),
('bettyb', '5f6ef157f55d89dfdc757cfebeb11c0e', 'owner', 'Betty', 'B', 'betty@b.com', '(123)456-7890'),
('carolc', '5f6ef157f55d89dfdc757cfebeb11c0e', 'owner', 'Carol', 'C', 'carol@c.com', '(123)456-7890'),
('charlesc', '5f6ef157f55d89dfdc757cfebeb11c0e', 'tenant', 'Charles', 'C', 'charles@c.ca', '(123)456-7890'),
('davidd', '5f6ef157f55d89dfdc757cfebeb11c0e', 'tenant', 'David', 'D', 'david@d.com', '(123)456-7890'),
('denised', '14080c4741d3c61a94b0516a070f5915', 'owner', 'Denise', 'D', 'denise@d.com', '(123)456-7890'),
('elieel', '5f6ef157f55d89dfdc757cfebeb11c0e', 'tenant', 'Elie', 'E', 'elie@e.com', '(123)456-7890'),
('esthere', '4803a183d95d782fd5a868dddc095b1b', 'owner', 'Esther', 'E', 'esther@e.com', '(123)456-7890'),
('harrya', '5f6ef157f55d89dfdc757cfebeb11c0e', 'tenant', 'Harry', 'A', 'harry@a.com', '(123)456-7890'),
('steveb', '5f6ef157f55d89dfdc757cfebeb11c0e', 'tenant', 'Steve', 'B', 'steve@b.com', '(123)456-7890');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`tenant`) REFERENCES `users` (`username`);

--
-- Constraints for table `owner_selection`
--
ALTER TABLE `owner_selection`
  ADD CONSTRAINT `owner_selection_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `property_rank`
--
ALTER TABLE `property_rank`
  ADD CONSTRAINT `property_rank_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `property_rank_ibfk_2` FOREIGN KEY (`property1`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `property_rank_ibfk_3` FOREIGN KEY (`property2`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `property_rank_ibfk_4` FOREIGN KEY (`property3`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `property_rank_ibfk_5` FOREIGN KEY (`property4`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `property_rank_ibfk_6` FOREIGN KEY (`property5`) REFERENCES `properties` (`id`);

--
-- Constraints for table `rental_preferences`
--
ALTER TABLE `rental_preferences`
  ADD CONSTRAINT `rental_preferences_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `tenant_profile`
--
ALTER TABLE `tenant_profile`
  ADD CONSTRAINT `tenant_profile_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `tenant_rank`
--
ALTER TABLE `tenant_rank`
  ADD CONSTRAINT `tenant_rank_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `tenant_rank_ibfk_2` FOREIGN KEY (`tenant1`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `tenant_rank_ibfk_3` FOREIGN KEY (`tenant2`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `tenant_rank_ibfk_4` FOREIGN KEY (`tenant3`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `tenant_rank_ibfk_5` FOREIGN KEY (`tenant4`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `tenant_rank_ibfk_6` FOREIGN KEY (`tenant5`) REFERENCES `users` (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
