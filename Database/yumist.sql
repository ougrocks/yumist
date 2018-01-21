-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2015 at 07:33 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yumist`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `id` varchar(100) NOT NULL,
  `address_line_1` varchar(255) NOT NULL,
  `address_line_2` varchar(255) NOT NULL,
  `locality` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `address_line_1`, `address_line_2`, `locality`, `city`, `state`, `pincode`) VALUES
('79d737ca-2c76-11e5-9799-002637bd3942', 'L II/3 Sec D', 'Kanpur Road', 'LDA Colony', 'Lucknow', 'Uttar Pradesh', '226012'),
('8406b6dd-2c81-11e5-9799-002637bd3942', 'C/23 Sector M', 'Near Komal Ice Cream', 'LDA Colony', 'Lucknow', 'Uttar Pradesh', '226012');

-- --------------------------------------------------------

--
-- Table structure for table `meal`
--

CREATE TABLE IF NOT EXISTS `meal` (
  `id` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(100) NOT NULL,
  `stock_status` int(12) NOT NULL,
  `created_timestamp` varchar(100) NOT NULL,
  `last_updated_timestamp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meal`
--

INSERT INTO `meal` (`id`, `name`, `description`, `price`, `stock_status`, `created_timestamp`, `last_updated_timestamp`) VALUES
('b381b30f-2c79-11e5-9799-002637bd3942', 'Afternoon Meal', '3 Roti, Dal Makhni, Paneer and Rice', '98', 10, '2015-07-17 17:18:11', '2015-07-17 17:18:11'),
('b381caee-2c79-11e5-9799-002637bd3942', 'Dinner Meal', '5 Roti, Chiken Tikka, Murg Masala and Biryani', '120', 20, '2015-07-17 17:18:11', '2015-07-17 17:18:11');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `meal_id` varchar(255) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `order_status` varchar(100) NOT NULL,
  `created_timestamp` varchar(100) NOT NULL,
  `last_updated_timestamp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address_id` varchar(255) NOT NULL,
  `phone_no` varchar(100) NOT NULL,
  `created_timestamp` varchar(255) NOT NULL,
  `last_updated_timestamp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `address_id`, `phone_no`, `created_timestamp`, `last_updated_timestamp`) VALUES
('0f313a76-2c6e-11e5-9799-002637bd3942', 'Adityaa Gupta', '79d737ca-2c76-11e5-9799-002637bd3942', '8604827051', '2015-07-17 15:54:51', '2015-07-17 15:54:51'),
('83fef065-2c81-11e5-9799-002637bd3942', 'Saroj Gupta', '83fef090-2c81-11e5-9799-002637bd3942', '9415014712', '2015-07-17 18:14:08', '2015-07-17 18:14:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meal`
--
ALTER TABLE `meal`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
