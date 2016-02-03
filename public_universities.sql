-- phpMyAdmin SQL Dump
-- version 4.0.10.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 02, 2016 at 03:56 PM
-- Server version: 5.5.31-cll
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mcca8757`
--

-- --------------------------------------------------------

--
-- Table structure for table `public_universities`
--

CREATE TABLE IF NOT EXISTS `public_universities` (
  `public_university_id` smallint(4) NOT NULL AUTO_INCREMENT,
  `federal_school_code` int(10) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `county` varchar(50) DEFAULT NULL,
  `college_system` varchar(50) DEFAULT NULL,
  `founded` smallint(4) DEFAULT NULL,
  `students` int(6) DEFAULT NULL,
  `fall_2015_acceptance_percentage` int(3) DEFAULT NULL,
  `img` varchar(30) NOT NULL DEFAULT 'default.jpg',
  PRIMARY KEY (`public_university_id`),
  UNIQUE KEY `public_university_id` (`public_university_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `public_universities`
--

INSERT INTO `public_universities` (`public_university_id`, `federal_school_code`, `name`, `city`, `county`, `college_system`, `founded`, `students`, `fall_2015_acceptance_percentage`, `img`) VALUES
(1, 1312, 'University of California, Berkeley', 'Berkeley', 'Alameda', 'University of California', 1868, 37581, 19, 'uc_Berkeley.jpg'),
(2, 1313, 'University of California, Davis', 'Davis', 'Yolo', 'University of California', 1908, 36104, 33, 'uc_Davis.jpg'),
(3, 1314, 'University of California, Irvine', 'Irvine', 'Orange', 'University of California', 1965, 30757, 33, 'uc_Irvine.jpg'),
(4, 1315, 'University of California, Los Angeles', 'Los Angeles', 'Los Angeles', 'University of California', 1919, 43301, 16, 'uc_Los_Angeles.jpg'),
(5, 41271, 'University of California, Merced', 'Merced', 'Merced', 'University of California', 2005, 6268, 66, 'uc_Merced.jpg'),
(6, 1316, 'University of California, Riverside', 'Riverside', 'Riverside', 'University of California', 1954, 21539, 57, 'uc_Riverside.jpg'),
(7, 1317, 'University of California, San Diego', 'La Jolla, San Diego', 'San Diego', 'University of California', 1960, 31502, 30, 'uc_San_Diego.jpg'),
(8, 1320, 'University of California, Santa Barbara', 'Santa Barbara-Goleta', 'Santa Barbara', 'University of California', 1891, 22225, 34, 'uc_Santa_Barbara.jpg'),
(9, 1321, 'University of California, Santa Cruz', 'Santa Cruz', 'Santa Cruz', 'University of California', 1965, 17866, 46, 'uc_Santa_Cruz.jpg'),
(10, 1134, 'California Maritime Academy', 'Vallejo', 'Solano', 'California State University', 1929, 1046, 61, 'csu_Cal_Maritime.jpg'),
(11, 1143, 'California Polytechnic State University', 'San Luis Obispo', 'San Luis Obispo', 'California State University', 1901, 20944, 31, 'csu_Cal_Poly.jpg'),
(12, 1144, 'California Polytechnic State University, Pomona', 'Pomona', 'Los Angeles', 'California State University', 1938, 23717, 52, 'csu_Cal_Poly_Pomona.jpg'),
(13, 7993, 'California State University, Bakersfield', 'Bakersfield', 'Kern', 'California State University', 1965, 8720, 71, 'csu_Bakersfield.jpg'),
(14, 39803, 'California State University, Channel Islands', 'Camarillo', 'Ventura County', 'California State University', 2002, 5140, 72, 'csu_Channel_Islands.jpg'),
(15, 1146, 'California State University, Chico', 'Chico', 'Butte', 'California State University', 1887, 17287, 71, 'csu_Chico.jpg'),
(16, 1141, 'California State University, Dominguez Hills', 'Carson', 'Los Angeles', 'California State University', 1960, 14670, 42, 'csu_Dominguez_Hills.jpg'),
(17, 1138, 'California State University, East Bay', 'Hayward', 'Alameda', 'California State University', 1959, 14823, 70, 'csu_East_Bay.jpg'),
(18, 1147, 'California State University, Fresno', 'Fresno', 'Fresno', 'California State University', 1911, 23179, 59, 'csu_Fresno.jpg'),
(19, 1137, 'California State University, Fullerton', 'Fullerton', 'Orange', 'California State University', 1957, 38128, 44, 'csu_Fullerton.jpg'),
(20, 1139, 'California State University, Long Beach', 'Long Beach', 'Los Angeles', 'California State University', 1949, 36822, 35, 'csu_Long_Beach.jpg'),
(21, 1140, 'California State University, Los Angeles', 'Los Angeles', 'Los Angeles', 'California State University', 1947, 24488, 61, 'csu_Los_Angeles.jpg'),
(22, 32603, 'California State University, Monterey Bay', 'Seaside', 'Monterey', 'California State University', 1994, 7102, 69, 'csu_Monterey_Bay.jpg'),
(23, 1153, 'California State University, Northridge', 'Northridge', 'Los Angeles', 'California State University', 1958, 40131, 53, 'csu_Northridge.jpg'),
(24, 1150, 'California State University, Sacramento', 'Sacramento', 'Sacramento', 'California State University', 1947, 28811, 73, 'csu_Sacramento.jpg'),
(25, 1142, 'California State University, San Bernadino', 'San Bernardino', 'San Bernardino', 'California State University', 1965, 18398, 84, 'csu_San_Bernardino.jpg'),
(26, 30113, 'California State University, San Marcos', 'San Marcos', 'San Diego', 'California State University', 1988, 12152, 62, 'csu_San_Marcos.jpg'),
(27, 1157, 'California State University, Stanislaus', 'Turlock', 'Stanislaus', 'California State University', 1957, 8917, 73, 'csu_Stanislaus.jpg'),
(28, 1149, 'Humbolt State University', 'Arcata', 'Humboldt', 'California State University', 1913, 8485, 77, 'csu_Humboldt.jpg'),
(29, 1151, 'San Diego State University', 'San Diego', 'San Diego', 'California State University', 1897, 33130, 34, 'csu_San_Diego.jpg'),
(30, 1154, 'San Francisco State University', 'San Francisco', 'San Francisco', 'California State University', 1899, 29905, 66, 'csu_San_Francisco.jpg'),
(31, 1155, 'San José State University', 'San José', 'Santa Clara', 'California State University', 1857, 32713, 60, 'csu_San_Jose.jpg'),
(32, 1156, 'Sonoma State University', 'Rohnert Park', 'Sonoma', 'California State University', 1960, 9120, 80, 'csu_Sonoma.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
