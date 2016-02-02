-- phpMyAdmin SQL Dump
-- version 4.0.10.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 02, 2016 at 10:41 AM
-- Server version: 5.5.31-cll
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hans6447`
--

-- --------------------------------------------------------

--
-- Table structure for table `admissions_offices`
--

CREATE TABLE IF NOT EXISTS `admissions_offices` (
  `admissions_offices_id` smallint(4) NOT NULL AUTO_INCREMENT,
  `public_university_id` smallint(4) NOT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`admissions_offices_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `admissions_offices`
--

INSERT INTO `admissions_offices` (`admissions_offices_id`, `public_university_id`, `phone`, `website`) VALUES
(1, 1, '510-642-3175', 'http://admissions.berkeley.edu/admissions'),
(2, 2, '530-752-1011', 'https://www.ucdavis.edu/admissions/'),
(3, 3, '949-824-6703', 'https://www.admissions.uci.edu/'),
(4, 4, '310-825-3101', 'http://www.admission.ucla.edu/'),
(5, 5, '209-228-7178', 'http://admissions.ucmerced.edu/'),
(6, 6, '951-827-3411', 'http://www.admission.ucr.edu/Admissions'),
(7, 7, '858-534-4831', 'http://admissions.ucsd.edu/'),
(8, 8, '858-534-4831', 'https://admissions.sa.ucsb.edu/'),
(9, 9, '831-459-2131', 'http://admissions.ucsc.edu/'),
(10, 10, '707-654-1330', 'https://www.csum.edu/web/admissions'),
(11, 11, '707-654-1330', 'http://admissions.calpoly.edu/'),
(12, 12, '909-869-5299', 'https://www.cpp.edu/~admissions/'),
(13, 13, '661-654-3036', 'http://www.csub.edu/admissions/'),
(14, 14, '805-437-8520', 'http://www.csuci.edu/admissions/'),
(15, 15, '530-898-6322', 'http://www.csuchico.edu/admissions/'),
(16, 16, '310-243-3645', 'http://www4.csudh.edu/admissions-records/'),
(17, 17, '510-885-2784', 'http://www20.csueastbay.edu/prospective/'),
(18, 18, '559-278-4240', 'http://www.fresnostate.edu/home/admissions/'),
(19, 19, '657-278-2011', 'http://www.fullerton.edu/admissions.aspx'),
(20, 20, '562-985-4111', 'http://web.csulb.edu/depts/enrollment/admissions/'),
(21, 21, '323-343-3000', 'http://www.calstatela.edu/admissions'),
(22, 22, '831-582-3000', 'https://csumb.edu/admissions'),
(23, 23, '818-677-3700', 'http://www.csun.edu/admissions-records'),
(24, 24, '916-278-7766', 'http://www.csus.edu/admissions/'),
(25, 25, '909-537-5188', 'http://admissions.csusb.edu/'),
(26, 26, '760-750-4848', 'http://www.csusm.edu/admissions/'),
(27, 27, '209-667-3070', 'https://www.csustan.edu/admissions'),
(28, 28, '866-850-9556', 'http://www2.humboldt.edu/admissions/'),
(29, 29, '619-594-6336', 'http://arweb.sdsu.edu/es/admissions/'),
(30, 30, '415-338-1111', 'http://www.sfsu.edu/future/'),
(31, 31, '408-924-1000', 'http://info.sjsu.edu/home/admission.html'),
(32, 32, '707-664-2880', 'http://www.sonoma.edu/admissions/');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
