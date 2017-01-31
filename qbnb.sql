-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 27, 2016 at 09:11 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qbnb`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `Booking ID` int(11) NOT NULL,
  `Member ID` int(11) NOT NULL,
  `Date` int(11) NOT NULL,
  `Status` enum('1','2','3') NOT NULL,
  `Property ID` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`Booking ID`, `Member ID`, `Date`, `Status`, `Property ID`, `rating`) VALUES
(1, 1, 0, '3', 1, 4),
(2, 1, 0, '2', 3, NULL),
(3, 1, 0, '1', 4, 1),
(4, 1, 0, '1', 4, 10),
(21, 31, 1461567600, '1', 1, NULL),
(41, 31, 1458198000, '2', 81, NULL),
(51, 31, 1458198000, '2', 1, NULL),
(61, 91, 1458111600, '2', 1, NULL),
(71, 91, 1458716400, '2', 1, NULL),
(72, 51, 1459288800, '2', 1, NULL),
(73, 92, 1459288800, '2', 1, NULL),
(74, 92, 0, '2', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `Comment ID` int(11) NOT NULL,
  `Text` varchar(300) NOT NULL,
  `Rating` enum('1','2','3','4','5') DEFAULT NULL,
  `Date` int(11) NOT NULL,
  `Property` int(11) NOT NULL,
  `Member ID` int(11) NOT NULL,
  `Parent Comment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`Comment ID`, `Text`, `Rating`, `Date`, `Property`, `Member ID`, `Parent Comment`) VALUES
(1, 'These accommodations are outrageous for these prices! I demand a refund!', '1', 0, 1, 1, NULL),
(2, 'It was entirely clear what you signed up for, enjoy the tank ambience', NULL, 0, 1, 1, 1),
(3, 'Owner still has not responded to my request!', NULL, 0, 4, 1, NULL),
(4, 'Quality accommodations, great atmosphere. Everything was clean when I arrived.', '4', 0, 3, 1, NULL),
(41, 'Unrelated test comment', '3', 0, 1, 21, NULL),
(51, 'Test comment level 1', NULL, 0, 1, 21, 41),
(61, 'test comment level 2', NULL, 0, 1, 21, 51),
(71, 'test comment', NULL, 0, 71, 0, NULL),
(151, 'nice place', NULL, 0, 1, 31, NULL),
(161, 'test', NULL, 0, 1, 31, NULL),
(171, 'test comment date', NULL, 1459025468, 1, 31, NULL),
(201, 'Comment', NULL, 1459028485, 81, 31, NULL),
(211, 'Comment2', NULL, 1459028491, 81, 31, NULL),
(221, 'Reply', NULL, 1459028511, 81, 21, 201),
(231, 'Reply', NULL, 1459028516, 81, 21, 211);

-- --------------------------------------------------------

--
-- Table structure for table `degree`
--

CREATE TABLE `degree` (
  `Degree ID` int(11) NOT NULL,
  `Type` varchar(5) NOT NULL,
  `Faculty` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `degree`
--

INSERT INTO `degree` (`Degree ID`, `Type`, `Faculty`) VALUES
(1, 'HBSC', 'Arts and Science'),
(2, 'MSC', 'Arts and Science'),
(3, 'BEng', 'Applied Science'),
(4, 'BCom', 'School of Business');

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `District ID` int(11) NOT NULL,
  `District Name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`District ID`, `District Name`) VALUES
(1, 'Downtown'),
(2, 'Waterfront'),
(3, 'Yellow Light'),
(4, 'Army Base');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `Feature ID` int(11) NOT NULL,
  `Feature Name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`Feature ID`, `Feature Name`) VALUES
(1, 'Pool'),
(2, 'Garage'),
(3, 'Nice View'),
(4, 'On-suite Bathroom');

-- --------------------------------------------------------

--
-- Table structure for table `has_earned`
--

CREATE TABLE `has_earned` (
  `Member ID` int(11) NOT NULL,
  `Degree ID` int(11) NOT NULL,
  `Year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `has_earned`
--

INSERT INTO `has_earned` (`Member ID`, `Degree ID`, `Year`) VALUES
(0, 1, 1936),
(0, 1, 2000),
(0, 2, 2002),
(0, 3, 2004),
(0, 4, 1997),
(81, 1, 2014),
(91, 1, 2000),
(91, 2, 1980),
(92, 1, 1930),
(92, 1, 1933),
(92, 1, 1934),
(92, 1, 1935),
(92, 1, 1941),
(92, 1, 2010),
(92, 2, 1932),
(92, 2, 1933),
(92, 2, 1936),
(92, 3, 1933),
(92, 3, 1935),
(92, 4, 1932),
(92, 4, 1936);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `Account Name` varchar(20) NOT NULL,
  `Email Address` varchar(50) NOT NULL,
  `Phone Number` varchar(15) DEFAULT NULL,
  `First Name` varchar(20) NOT NULL,
  `Last Name` varchar(20) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Member ID` int(11) NOT NULL,
  `Is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`Account Name`, `Email Address`, `Phone Number`, `First Name`, `Last Name`, `Password`, `Member ID`, `Is_admin`) VALUES
('neutral_on_gaels', 'totally_real@gmail.com', '5489992345', 'Georg', 'Awesom', '$1$Ryfajlrx$bvVsd9SOczulJedmyR1Wy.', 0, 0),
('Gaels_rok', '02JG98@queensu.ca', '1112223333', 'Justin', 'Gerolami', 'randomhashtobeimproved', 1, 1),
('Gaels_suk', '12bcw@queensu.ca', '2223334444', 'Ben', 'Wright', 'gonnabesupersecure', 2, 0),
('fraser', 'f', '123', 'Fraser', '', 'test1', 11, 0),
('fraser1', 'sdgfsdgfsdg', '123', 'Fraser', '', '$1$gd2.Ki1.$pdMy2dFcCZxC0EYQzY483/', 21, 0),
('testaccount', 'test', 'test', 'test', 'test', '$1$wc0.8S0.$Z/7/ivkL.Vi8WOq1NyT7J0', 31, 0),
('test', 'testtesttestest', 'test', 'test', 'test', '$1$O24.Jb1.$U84Z2/zDdFh1XoMVY1RZh/', 41, 0),
('a', 'a', 'a', 'a', 'a', '$1$gG.d.ebt$pfS8vEUn/uFI4OMfWVzK/0', 51, 0),
('b', 'b', 'b', 'b', 'b', '$1$IPGtkG9q$Ghlh18TcQXD0r7sgkCW2Q1', 61, 0),
('t', 't', 't', 'te', 't', '$1$.LK8Kt9V$eQrEAy/JTnG.Hw9c/IcyN0', 71, 0),
('justin', 'justin@email.com', '123456789', 'justin', 'gerolami', '$1$wyR1p/XW$m7syRKSxTZxSSNVB2nVUr/', 81, 0),
('bookingtest', 'testeewe', 'test', 'test', 'test', '$1$4d0.TR3.$8Dgqk/to.MJQQVyWZylsr.', 91, 0),
('justin1', 'justingerolami@hotmail.com', '8076296291', 'justinNew', 'gerolamiNew', '$1$Ryfajlrx$bvVsd9SOczulJedmyR1Wy.', 92, 0),
('q', 'q', '', 'q', 'q', '$1$uww85NCE$FQwvk.xF4PHItsSeyb0Qz0', 93, 0),
('x', 'x', '', 'x', 'x', '$1$6Nv49ULK$1yCpmHsm..J.KtkchcStg1', 94, 0),
('r', 'r', '', 'r', 'r', '$1$.hJZpn2D$EevtixVCfouUKKMpOARZC1', 95, 0);

-- --------------------------------------------------------

--
-- Table structure for table `point of interest`
--

CREATE TABLE `point of interest` (
  `POI ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `District ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `point of interest`
--

INSERT INTO `point of interest` (`POI ID`, `Name`, `District ID`) VALUES
(1, 'The Minefield', 4),
(2, 'Beach', 2),
(3, 'Mall', 1),
(4, 'Legitimate Establishment', 3);

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `Property ID` int(11) NOT NULL,
  `Supplier ID` int(11) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Type` varchar(30) NOT NULL,
  `Price` int(11) NOT NULL,
  `Other Features` varchar(200) DEFAULT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `District` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`Property ID`, `Supplier ID`, `Address`, `Type`, `Price`, `Other Features`, `Description`, `District`) VALUES
(1, 21, '459 tanks-drive-on-it parkway', 'Tent', 100000, 'Loud, historical area', 'Live the lifestyle of a true WWII soldier! Army gear supplied by request.', 4),
(2, 0, '38 Lakeshore Avenue', 'Bungalow', 1500, 'Maid Service', 'Right by the water, this property is great for anybody looking to get to the beach!', 2),
(3, 0, '1700 Main Street, Apt 258', 'Apartment', 3000, NULL, 'Right next to the mall, great for the nightlife', 1),
(4, 0, '69 Napoli Drive', 'House', 900, NULL, 'Great for anybody looking to have an exciting and 100% legal time. Totally not a money laundering front.', 3),
(61, 21, 'sdafasaasa', 'asdfa', 100, '', 'dsasdad', 2),
(71, 21, 'sdafasaasasdwd', 'asdfa', 100, '', 'dsasdad', 2),
(81, 21, 'Test Comments', 'Test', 1, '', 'TEST', 2);

-- --------------------------------------------------------

--
-- Table structure for table `property_has`
--

CREATE TABLE `property_has` (
  `Property ID` int(11) NOT NULL,
  `Feature ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property_has`
--

INSERT INTO `property_has` (`Property ID`, `Feature ID`) VALUES
(2, 1),
(2, 2),
(3, 4),
(4, 1),
(61, 2),
(71, 1),
(71, 2),
(71, 3),
(71, 4),
(81, 1),
(81, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`Booking ID`),
  ADD UNIQUE KEY `Booking ID` (`Booking ID`),
  ADD KEY `Member ID` (`Member ID`),
  ADD KEY `Property ID` (`Property ID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`Comment ID`),
  ADD UNIQUE KEY `Comment ID` (`Comment ID`),
  ADD KEY `Member ID` (`Member ID`),
  ADD KEY `Property` (`Property`);

--
-- Indexes for table `degree`
--
ALTER TABLE `degree`
  ADD PRIMARY KEY (`Degree ID`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`District ID`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`Feature ID`);

--
-- Indexes for table `has_earned`
--
ALTER TABLE `has_earned`
  ADD PRIMARY KEY (`Member ID`,`Degree ID`,`Year`),
  ADD KEY `Degree ID` (`Degree ID`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`Member ID`),
  ADD UNIQUE KEY `Account Name` (`Account Name`),
  ADD UNIQUE KEY `Email Address` (`Email Address`);

--
-- Indexes for table `point of interest`
--
ALTER TABLE `point of interest`
  ADD PRIMARY KEY (`POI ID`),
  ADD KEY `District ID` (`District ID`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`Property ID`),
  ADD KEY `Supplier ID` (`Supplier ID`);

--
-- Indexes for table `property_has`
--
ALTER TABLE `property_has`
  ADD PRIMARY KEY (`Property ID`,`Feature ID`),
  ADD KEY `Feature ID` (`Feature ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `Booking ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `Comment ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;
--
-- AUTO_INCREMENT for table `degree`
--
ALTER TABLE `degree`
  MODIFY `Degree ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `District ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `Feature ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `Member ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT for table `point of interest`
--
ALTER TABLE `point of interest`
  MODIFY `POI ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `Property ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`Member ID`) REFERENCES `member` (`Member ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`Property ID`) REFERENCES `property` (`Property ID`) ON DELETE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`Member ID`) REFERENCES `member` (`Member ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_4` FOREIGN KEY (`Property`) REFERENCES `property` (`Property ID`) ON DELETE CASCADE;

--
-- Constraints for table `has_earned`
--
ALTER TABLE `has_earned`
  ADD CONSTRAINT `has_earned_ibfk_1` FOREIGN KEY (`Member ID`) REFERENCES `member` (`Member ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `has_earned_ibfk_2` FOREIGN KEY (`Degree ID`) REFERENCES `degree` (`Degree ID`) ON DELETE CASCADE;

--
-- Constraints for table `point of interest`
--
ALTER TABLE `point of interest`
  ADD CONSTRAINT `point of interest_ibfk_1` FOREIGN KEY (`District ID`) REFERENCES `district` (`District ID`) ON DELETE CASCADE;

--
-- Constraints for table `property`
--
ALTER TABLE `property`
  ADD CONSTRAINT `property_ibfk_1` FOREIGN KEY (`Supplier ID`) REFERENCES `member` (`Member ID`) ON DELETE CASCADE;

--
-- Constraints for table `property_has`
--
ALTER TABLE `property_has`
  ADD CONSTRAINT `property_has_ibfk_1` FOREIGN KEY (`Property ID`) REFERENCES `property` (`Property ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `property_has_ibfk_2` FOREIGN KEY (`Feature ID`) REFERENCES `features` (`Feature ID`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
