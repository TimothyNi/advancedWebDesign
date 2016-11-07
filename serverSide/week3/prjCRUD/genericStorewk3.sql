-- phpMyAdmin SQL Dump
-- version 4.4.15.8
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 26, 2016 at 12:54 AM
-- Server version: 5.6.31
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `genericStore`
--

-- --------------------------------------------------------

--
-- Table structure for table `deptTable`
--

CREATE TABLE IF NOT EXISTS `deptTable` (
  `dept_ID` int(11) unsigned NOT NULL,
  `department` varchar(25) NOT NULL,
  `departmentManager` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deptTable`
--

INSERT INTO `deptTable` (`dept_ID`, `department`, `departmentManager`) VALUES
(1, 'Kitchenware', 'Roger Garrison'),
(2, 'Outdoors', 'Shayna Niccum'),
(3, 'Bedding', 'Timothy Niccum'),
(4, 'Pets', 'Rollie St. Claire'),
(5, 'Living Room', 'John Smith');

-- --------------------------------------------------------

--
-- Table structure for table `genStore`
--

CREATE TABLE IF NOT EXISTS `genStore` (
  `gen_ID` int(11) unsigned NOT NULL,
  `productName` varchar(25) NOT NULL,
  `price` varchar(25) NOT NULL,
  `prod_ID` int(25) DEFAULT NULL,
  `department` varchar(25) NOT NULL,
  `departmentManager` varchar(50) NOT NULL,
  `dept_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `manuTable`
--

CREATE TABLE IF NOT EXISTS `manuTable` (
  `manu_ID` int(11) unsigned NOT NULL,
  `manufacturer` varchar(25) NOT NULL,
  `manufacturerPage` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manuTable`
--

INSERT INTO `manuTable` (`manu_ID`, `manufacturer`, `manufacturerPage`) VALUES
(1, 'KitchenwareINC', 'www.kitchenwareINC.com'),
(2, 'Bedding INC', 'http://www.beddingINC.com'),
(3, 'Naturemade', 'http://naturemade.com');

-- --------------------------------------------------------

--
-- Table structure for table `prodTable`
--

CREATE TABLE IF NOT EXISTS `prodTable` (
  `prod_ID` int(11) unsigned NOT NULL,
  `productName` varchar(25) NOT NULL,
  `price` varchar(25) NOT NULL,
  `productPage` varchar(50) NOT NULL,
  `dept_ID` int(11) DEFAULT NULL,
  `manu_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prodTable`
--

INSERT INTO `prodTable` (`prod_ID`, `productName`, `price`, `productPage`, `dept_ID`, `manu_ID`) VALUES
(1, 'Plates', '10.99', 'http://MyStore.com/plates.php', 1, 1),
(2, 'Big Plant', '75.99', 'http://MyStore.com/bigplants.php', 2, 2),
(3, 'Fluffy Pillow', '25.99', 'http://MyStore.com/fluffypillow.php', 3, 3),
(4, 'Pet Pillow', '14.99', 'http://MyStore.com/petpillow.php', 3, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deptTable`
--
ALTER TABLE `deptTable`
  ADD PRIMARY KEY (`dept_ID`);

--
-- Indexes for table `genStore`
--
ALTER TABLE `genStore`
  ADD PRIMARY KEY (`gen_ID`);

--
-- Indexes for table `manuTable`
--
ALTER TABLE `manuTable`
  ADD PRIMARY KEY (`manu_ID`);

--
-- Indexes for table `prodTable`
--
ALTER TABLE `prodTable`
  ADD PRIMARY KEY (`prod_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deptTable`
--
ALTER TABLE `deptTable`
  MODIFY `dept_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `genStore`
--
ALTER TABLE `genStore`
  MODIFY `gen_ID` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `manuTable`
--
ALTER TABLE `manuTable`
  MODIFY `manu_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `prodTable`
--
ALTER TABLE `prodTable`
  MODIFY `prod_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
