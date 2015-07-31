-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 31, 2015 at 01:51 PM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `loan`
--

-- --------------------------------------------------------

--
-- Table structure for table `action`
--

DROP TABLE IF EXISTS `action`;
CREATE TABLE IF NOT EXISTS `action` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SessionID` varchar(255) NOT NULL,
  `ActionID` varchar(255) NOT NULL,
  `Action` varchar(255) NOT NULL,
  `Parameters` longtext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `actionmaster`
--

DROP TABLE IF EXISTS `actionmaster`;
CREATE TABLE IF NOT EXISTS `actionmaster` (
  `MasterID` int(11) NOT NULL AUTO_INCREMENT,
  `ActionID` int(11) NOT NULL,
  `Action_Name` int(255) NOT NULL,
  PRIMARY KEY (`MasterID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `username`, `password`, `active`, `created`) VALUES
(1, 'admin@gmail.com', 'Preeti Savant', 'admin123', '1', '2015-07-21 06:46:17');

-- --------------------------------------------------------

--
-- Table structure for table `mapproperties`
--

DROP TABLE IF EXISTS `mapproperties`;
CREATE TABLE IF NOT EXISTS `mapproperties` (
  `MpropID` int(11) NOT NULL AUTO_INCREMENT,
  `PropID` int(11) NOT NULL,
  `Source` varchar(255) NOT NULL,
  `Used` varchar(255) NOT NULL,
  `Creteria` varchar(255) NOT NULL,
  `Reason` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Street_No` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL,
  `State` varchar(255) NOT NULL,
  `Zip` varchar(255) NOT NULL,
  `Distance` int(11) NOT NULL,
  `Beds` int(11) NOT NULL,
  `Baths` int(11) NOT NULL,
  `Stories` int(11) NOT NULL,
  `Size` int(11) NOT NULL,
  `Built` int(11) NOT NULL,
  `Lot` int(11) NOT NULL,
  `Amount` int(11) NOT NULL,
  `Date_Sold` datetime NOT NULL,
  PRIMARY KEY (`MpropID`),
  UNIQUE KEY `PropID` (`PropID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `saveresultantprop`
--

DROP TABLE IF EXISTS `saveresultantprop`;
CREATE TABLE IF NOT EXISTS `saveresultantprop` (
  `SaveID` int(11) NOT NULL AUTO_INCREMENT,
  `PropID` int(11) NOT NULL,
  `SearchID` int(11) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `StreetNo` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL,
  `State` varchar(255) NOT NULL,
  `Zip` varchar(255) NOT NULL,
  `PrevVal` varchar(255) NOT NULL,
  `Edit` int(11) NOT NULL,
  `Distance` int(11) NOT NULL,
  `Beds` int(11) NOT NULL,
  `Baths` int(11) NOT NULL,
  `Stories` int(11) NOT NULL,
  `Size` int(11) NOT NULL,
  `Lot` int(11) NOT NULL,
  `Built` int(11) NOT NULL,
  `Date_Sold` int(11) NOT NULL,
  `Amount` int(11) NOT NULL,
  PRIMARY KEY (`SaveID`),
  UNIQUE KEY `SearchID` (`SearchID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `savesearch`
--

DROP TABLE IF EXISTS `savesearch`;
CREATE TABLE IF NOT EXISTS `savesearch` (
  `SearchID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `UserID` int(11) NOT NULL,
  `IsDone` tinyint(11) NOT NULL,
  `Param` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`SearchID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `searchAddresses`
--

DROP TABLE IF EXISTS `searchAddresses`;
CREATE TABLE IF NOT EXISTS `searchAddresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `searchId` int(11) NOT NULL,
  `paramAddress` text NOT NULL,
  `paramComments` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `securityquestion`
--

DROP TABLE IF EXISTS `securityquestion`;
CREATE TABLE IF NOT EXISTS `securityquestion` (
  `QuestionID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Question` varchar(255) NOT NULL,
  `Answer` varchar(255) NOT NULL,
  PRIMARY KEY (`QuestionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `securityquestion`
--

INSERT INTO `securityquestion` (`QuestionID`, `UserID`, `Question`, `Answer`) VALUES
(1, 1, ' hello', '1'),
(2, 1, 'a', 'a'),
(3, 1, 'Question1', '3'),
(4, 3, 'What is Your Favourite Colour?', 'Milky White'),
(5, 3, 'DSFDSFD', 'dsfdsfdsF'),
(6, 3, 'dgfdsfdsf', 'DSFDSFDSF'),
(28, 4, 'this is question 1 ?', 'this is answer 1'),
(29, 4, 'this is question 2 ?', 'this is answer 2'),
(30, 4, 'this is question 3 ?', 'this is answer 3'),
(31, 0, 'Test', 'Test'),
(32, 0, 'Test', 'Test'),
(33, 0, 'Test', 'Test'),
(34, 7, '12', '12'),
(35, 7, '12', '12'),
(36, 7, '12', '12'),
(37, 6, 'Question1', 'Answer1'),
(38, 6, 'Question2', 'Answer2'),
(39, 6, 'Question3', 'Answer3'),
(40, 5, '1', '1'),
(41, 5, '1', '1'),
(42, 5, '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `SessionID` varchar(255) NOT NULL,
  `UserID` int(11) NOT NULL,
  `LogInTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LogOutTime` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`SessionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sessionsavelink`
--

DROP TABLE IF EXISTS `sessionsavelink`;
CREATE TABLE IF NOT EXISTS `sessionsavelink` (
  `LinkID` int(11) NOT NULL AUTO_INCREMENT,
  `SessionID` varchar(255) NOT NULL,
  `SearchID` int(11) NOT NULL,
  PRIMARY KEY (`LinkID`),
  UNIQUE KEY `SessionID` (`SessionID`,`SearchID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `SponserMaster`
--

DROP TABLE IF EXISTS `SponserMaster`;
CREATE TABLE IF NOT EXISTS `SponserMaster` (
  `SponserID` int(11) NOT NULL AUTO_INCREMENT,
  `Sponser_Name` varchar(255) NOT NULL,
  `SponserCode` varchar(255) NOT NULL,
  `Sponser_Address` varchar(255) NOT NULL,
  PRIMARY KEY (`SponserID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userdetail`
--

DROP TABLE IF EXISTS `userdetail`;
CREATE TABLE IF NOT EXISTS `userdetail` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `SponserCode` varchar(255) NOT NULL,
  `Active` tinyint(11) NOT NULL,
  `CreateTime` int(11) NOT NULL,
  `ModifiedTime` varchar(255) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `TypeOfUser` int(11) NOT NULL,
  `lendingId` int(11) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `userdetail`
--

INSERT INTO `userdetail` (`UserID`, `UserName`, `Password`, `Name`, `Address`, `SponserCode`, `Active`, `CreateTime`, `ModifiedTime`, `CreatedBy`, `TypeOfUser`, `lendingId`) VALUES
(1, 'demo@cyquent.com', '12345678', 'Preeti Savant', '133 Miller Road Bangalore', '1', 1, 0, '', 0, 1, 6),
(5, 'loanofficer@gmail.com', 'loan123', 'Loan Officer', '1', '', 1, 0, '', 0, 2, 6),
(6, 'lending@gmail.com', '123456', 'ABHISHEK', 'bgm', '5', 1, 0, '', 0, 3, 0),
(7, 'admin@gmail.com', '123456', 'Admin', 'admin', '', 1, 0, '', 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
