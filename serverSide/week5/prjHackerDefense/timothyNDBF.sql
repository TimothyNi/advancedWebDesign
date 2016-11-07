-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `sunRun`;

DELIMITER ;;

DROP PROCEDURE IF EXISTS `runnerUpdate`;;
CREATE PROCEDURE `runnerUpdate`(IN `gender` varchar(50), IN `phone` varchar(50), IN `lName` varchar(50), IN `fName` varchar(50), IN `thisRunner` int)
BEGIN
UPDATE runner SET id_runner=id_runner,fName=fName,lName=lName,phone=phone,gender=gender WHERE id_runner=thisRunner;
END;;

DELIMITER ;

DROP TABLE IF EXISTS `race`;
CREATE TABLE `race` (
  `id_race` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `raceName` varchar(25) NOT NULL,
  `entranceFee` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id_race`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `race` (`id_race`, `raceName`, `entranceFee`) VALUES
(1,	'10K',	46),
(2,	'5K',	46),
(3,	'Marathon',	85),
(4,	'Half Marathon',	75);

DROP TABLE IF EXISTS `runner`;
CREATE TABLE `runner` (
  `id_runner` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `fName` varchar(25) NOT NULL,
  `lName` varchar(25) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_runner`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `runner` (`id_runner`, `fName`, `lName`, `gender`, `phone`) VALUES
(1,	'Johnny',	'Hayes',	'male',	'1234567890'),
(2,	'Robert',	'Fowler',	'male',	'2234567890'),
(3,	'James',	'Clark',	'male',	'3234567890'),
(4,	'Marie-Louise',	'Ledru',	'female',	'4234567890'),
(5,	'John',	'Watson',	'male',	'5071237899'),
(6,	'Sally',	'Johnson',	'female',	'8121237800'),
(7,	'Paula',	'Radcliff',	'female',	'8029881123');

DROP TABLE IF EXISTS `runner_race`;
CREATE TABLE `runner_race` (
  `id_runner` int(6) DEFAULT NULL,
  `id_race` int(6) DEFAULT NULL,
  `bibNumber` int(6) DEFAULT NULL,
  `paid` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `runner_race` (`id_runner`, `id_race`, `bibNumber`, `paid`) VALUES
(2,	4,	1234,	1),
(1,	3,	1234,	1),
(1,	4,	1234,	1),
(2,	3,	1234,	1),
(3,	3,	1234,	1),
(3,	4,	1234,	1),
(4,	3,	1234,	1),
(4,	4,	1234,	1);

DROP TABLE IF EXISTS `sponsor`;
CREATE TABLE `sponsor` (
  `id_sponsor` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `sponsorName` varchar(50) NOT NULL,
  `id_runner` int(6) DEFAULT NULL,
  PRIMARY KEY (`id_sponsor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `sponsor` (`id_sponsor`, `sponsorName`, `id_runner`) VALUES
(1,	'Nike',	2),
(2,	'Western Hospital',	3),
(3,	'House of Heroes',	4),
(4,	'Wells Fargo Bank',	NULL);

-- 2016-10-15 20:28:19