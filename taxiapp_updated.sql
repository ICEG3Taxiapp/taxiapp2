-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2016 at 07:34 AM
-- Server version: 5.7.10-log
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `taxiapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE IF NOT EXISTS `driver` (
  `driver_id` varchar(10) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL,
  `name` varchar(30) NOT NULL,
  `contact_no` varchar(12) NOT NULL,
  `nic_no` varchar(10) DEFAULT NULL,
  `availability` tinyint(1) NOT NULL DEFAULT '1',
  `longitude` float DEFAULT NULL,
  `lattitude` float DEFAULT NULL,
  PRIMARY KEY (`driver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`driver_id`, `password`, `name`, `contact_no`, `nic_no`, `availability`, `longitude`, `lattitude`) VALUES
('0008', '81dc9bdb52d04dc20036dbd8313ed055', 'Hansika', '0773767865', '940263760V', 0, 79.899, 6.9033),
('dineth', 'c8d78fff63457ce5acab2630517b3af4', 'dineth', '0713636666', '932390035v', 1, 79.9167, 6.94),
('heshan', '0186bf338fc6a79be2c29fc1707aa225', 'Heshan', '0712282328', '922111804v', 1, 79.9167, 6.9123),
('surani', '9e1a86bf2c4cb7952e4611123558d1be', 'surani', '0123456789', '932390035v', 1, 79.8467, 6.9011);

-- --------------------------------------------------------

--
-- Table structure for table `driverbid`
--

CREATE TABLE IF NOT EXISTS `driverbid` (
  `bid` decimal(9,2) NOT NULL,
  `driver_id` varchar(10) DEFAULT NULL,
  `request_id` varchar(10) DEFAULT NULL,
  KEY `driver_id` (`driver_id`),
  KEY `request_id` (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `driverbid`
--

INSERT INTO `driverbid` (`bid`, `driver_id`, `request_id`) VALUES
('500.00', '0008', '1'),
('100.00', '0008', '3'),
('123.00', '0008', '2'),
('400.00', 'dineth', '1'),
('100.00', 'heshan', '9');

-- --------------------------------------------------------

--
-- Table structure for table `driver_inbox`
--

CREATE TABLE IF NOT EXISTS `driver_inbox` (
  `driver_inbox_id` int(10) unsigned NOT NULL DEFAULT '0',
  `driver_id` varchar(10) NOT NULL DEFAULT '',
  `message` varchar(100) NOT NULL DEFAULT '',
  `is_viewed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`driver_inbox_id`),
  KEY `driver_id` (`driver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hire_request`
--

CREATE TABLE IF NOT EXISTS `hire_request` (
  `request_id` varchar(10) NOT NULL DEFAULT '',
  `start_loc_long` float(7,4) NOT NULL,
  `start_loc_lat` float(7,4) NOT NULL,
  `destination_long` float(7,4) NOT NULL,
  `destination_lat` float(7,4) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL DEFAULT '00:00:00',
  `num_of_passengers` int(2) NOT NULL DEFAULT '0',
  `max_bid` decimal(9,2) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `distanceM` int(11) NOT NULL,
  `durationMins` int(11) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `vehicle_type` varchar(30) NOT NULL,
  PRIMARY KEY (`request_id`),
  KEY `contact_no` (`contact_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hire_request`
--

INSERT INTO `hire_request` (`request_id`, `start_loc_long`, `start_loc_lat`, `destination_long`, `destination_lat`, `date`, `time`, `num_of_passengers`, `max_bid`, `contact_no`, `distanceM`, `durationMins`, `completed`, `vehicle_type`) VALUES
('1', 79.9334, 6.9497, 79.9071, 6.9028, '2016-01-20', '12:00:00', 2, '1200.00', '0713636666', 11455, 60, 1, 'Van'),
('10', 79.8999, 6.9133, 79.8707, 6.9507, '2016-01-27', '00:04:00', 4, '500.00', '0713636666', 8991, 25, 0, 'Car'),
('2', 79.9457, 6.9491, 79.8746, 6.9503, '2016-01-18', '12:00:00', 2, '1200.00', '0717673721', 10830, 55, 1, 'Car'),
('3', 81.3638, 6.7142, 79.8842, 6.9520, '2016-01-22', '12:00:00', 2, '1200.00', '0717673721', 12545, 75, 1, '3 Wheeler'),
('4', 79.0000, 6.9999, 79.9300, 6.0340, '2016-01-19', '03:16:32', 2, '244.00', '0713636666', 2214, 64, 0, 'Car'),
('7', 79.9186, 6.9412, 79.8499, 6.9333, '2016-01-30', '01:59:00', 10, '1500.00', '0713636666', 1040, 29, 0, 'Van'),
('9', 79.8999, 6.9133, 79.8707, 6.9507, '2016-01-23', '00:00:00', 3, '123.00', '0713636666', 8991, 25, 1, '3 Wheeler');

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE IF NOT EXISTS `passenger` (
  `contact_no` varchar(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`contact_no`),
  UNIQUE KEY `contact_no` (`contact_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `passenger`
--

INSERT INTO `passenger` (`contact_no`, `name`, `password`) VALUES
('0713636666', 'nimantha', 'cefc10f1447898c039b1f8e00f41c61c'),
('0717673721', 'Madushan', '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(9,2) DEFAULT NULL,
  `driver_id` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `driver_id` (`driver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `taxi`
--

CREATE TABLE IF NOT EXISTS `taxi` (
  `reg_no` varchar(10) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `max_passengers` int(2) DEFAULT NULL,
  `driver_id` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`reg_no`),
  KEY `driver_id` (`driver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taxi`
--

INSERT INTO `taxi` (`reg_no`, `type`, `max_passengers`, `driver_id`) VALUES
('84-3452', '3 Wheeler', 3, 'heshan'),
('we 3456', 'Car', 2, '0008'),
('wp-1234', '3 Wheeler', 3, 'surani'),
('wp-1235', 'Car', 4, 'dineth');

-- --------------------------------------------------------

--
-- Table structure for table `tour`
--

CREATE TABLE IF NOT EXISTS `tour` (
  `tour_id` int(10) NOT NULL AUTO_INCREMENT,
  `charge` decimal(9,2) NOT NULL,
  `feedback` text,
  `rating` tinyint(4) DEFAULT NULL,
  `driver_id` varchar(10) DEFAULT NULL,
  `request_id` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`tour_id`),
  KEY `driver_id` (`driver_id`),
  KEY `request_id` (`request_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `tour`
--

INSERT INTO `tour` (`tour_id`, `charge`, `feedback`, `rating`, `driver_id`, `request_id`) VALUES
(1, '500.00', NULL, NULL, '0008', '2'),
(2, '123.00', NULL, NULL, '0008', '3'),
(3, '400.00', NULL, NULL, 'dineth', '1'),
(4, '100.00', NULL, NULL, 'heshan', '9');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `driverbid`
--
ALTER TABLE `driverbid`
  ADD CONSTRAINT `driverbid_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`driver_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `driverbid_ibfk_2` FOREIGN KEY (`request_id`) REFERENCES `hire_request` (`request_id`) ON DELETE SET NULL;

--
-- Constraints for table `hire_request`
--
ALTER TABLE `hire_request`
  ADD CONSTRAINT `hire_request_ibfk_1` FOREIGN KEY (`contact_no`) REFERENCES `passenger` (`contact_no`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`driver_id`) ON DELETE SET NULL;

--
-- Constraints for table `taxi`
--
ALTER TABLE `taxi`
  ADD CONSTRAINT `taxi_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`driver_id`) ON DELETE CASCADE;

--
-- Constraints for table `tour`
--
ALTER TABLE `tour`
  ADD CONSTRAINT `tour_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`driver_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tour_ibfk_2` FOREIGN KEY (`request_id`) REFERENCES `hire_request` (`request_id`) ON DELETE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
