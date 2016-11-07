-- phpMyAdmin SQL Dump
-- version 4.4.15.8
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 03, 2016 at 01:44 AM
-- Server version: 5.6.31
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `redDoor`
--

-- --------------------------------------------------------

--
-- Table structure for table `beerWeek`
--

CREATE TABLE IF NOT EXISTS `beerWeek` (
  `beer_ID` int(11) NOT NULL,
  `beerName` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beerWeek`
--

INSERT INTO `beerWeek` (`beer_ID`, `beerName`) VALUES
(1, 'Surly, Fulton, Coors'),
(2, 'Surly, Indeed, Hamms');

-- --------------------------------------------------------

--
-- Table structure for table `burgerOfMonth`
--

CREATE TABLE IF NOT EXISTS `burgerOfMonth` (
  `burger_ID` int(11) NOT NULL,
  `burgerName` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `burgerOfMonth`
--

INSERT INTO `burgerOfMonth` (`burger_ID`, `burgerName`) VALUES
(1, 'Pastrami Burger'),
(2, 'Black and Bleu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beerWeek`
--
ALTER TABLE `beerWeek`
  ADD PRIMARY KEY (`beer_ID`);

--
-- Indexes for table `burgerOfMonth`
--
ALTER TABLE `burgerOfMonth`
  ADD PRIMARY KEY (`burger_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beerWeek`
--
ALTER TABLE `beerWeek`
  MODIFY `beer_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `burgerOfMonth`
--
ALTER TABLE `burgerOfMonth`
  MODIFY `burger_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
