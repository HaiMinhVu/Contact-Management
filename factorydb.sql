-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 29, 2018 at 05:47 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `factorydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `Entity`
--

CREATE TABLE `Entity` (
  `EID` int(11) NOT NULL,
  `EPID` int(11) DEFAULT NULL,
  `EName` varchar(255) DEFAULT NULL,
  `ERegisteredName` varchar(255) DEFAULT NULL,
  `Owner` varchar(255) DEFAULT NULL,
  `Supplier` varchar(1000) DEFAULT NULL,
  `OEMCustomer` varchar(1000) DEFAULT NULL,
  `NumberofWorker` int(11) DEFAULT NULL,
  `AnnualSales` double DEFAULT NULL,
  `ProductManufactured` varchar(1023) DEFAULT NULL,
  `EStatus` enum('Active','InActive') DEFAULT NULL,
  `EEnterBy` int(11) DEFAULT NULL,
  `EModifyDate` datetime DEFAULT NULL,
  `EModifyBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Entity`
--

INSERT INTO `Entity` (`EID`, `EPID`, `EName`, `ERegisteredName`, `Owner`, `Supplier`, `OEMCustomer`, `NumberofWorker`, `AnnualSales`, `ProductManufactured`, `EStatus`, `EEnterBy`, `EModifyDate`, `EModifyBy`) VALUES
(1, NULL, 'Red Dragon', 'Red Dragon INC', 'Jo Wong', 'china factory', 'home depot', 100, 500000, 'wood, fiber', 'Active', 1, '2018-06-28 10:30:00', 1),
(2, NULL, 'Sun House', 'Sun House Group', 'Toan Nguyen', 'viet nam factory', 'keller william', 200, 1000000, 'solar, battery', 'Active', 1, '2018-06-08 00:00:00', 2),
(3, 1, 'blue dragon', 'blue dragon', 'red dragon', 'shanghai C.O', 'bestbuy', 150, 300000, 'keyboard, mouse', 'Active', 2, '2018-06-28 10:38:00', 1),
(4, 5, 'Moon House', 'Moon House', 'Sun House', 'saigon Inc', 'Frys', 80, 500000, 'electric devices', 'Active', 2, '2018-06-28 10:37:00', 1),
(5, NULL, 'Toyota', 'Toyota', 'Jackie', 'beijing Inc', 'discount tire', 250, 2000000, 'tires, wheel', 'Active', 1, '2018-06-28 10:43:00', 1),
(6, 5, 'goodyear', 'goodyear', 'toyota', 'SangThai INC', 'firestone', 40, 600000, 'tires, auto service', 'Active', 5, '2018-06-28 10:38:00', 1),
(7, 2, 'Panda', 'Panda', 'Junie', 'ha noi inc', 'Walmart', 200, 2500000, 'Wood, Metal', 'Active', 1, '2018-06-28 15:30:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Entity_Contact`
--

CREATE TABLE `Entity_Contact` (
  `ECID` int(11) NOT NULL,
  `ECName` varchar(255) DEFAULT NULL,
  `ECEmail` varchar(255) DEFAULT NULL,
  `ECPhone` varchar(20) DEFAULT NULL,
  `ECFax` varchar(20) DEFAULT NULL,
  `ECWebsite` varchar(255) DEFAULT NULL,
  `ECAddress1` varchar(255) DEFAULT NULL,
  `ECAddress2` varchar(255) DEFAULT NULL,
  `ECCity` varchar(255) DEFAULT NULL,
  `ECState` varchar(255) DEFAULT NULL,
  `ECZip` varchar(10) DEFAULT NULL,
  `ECCountry` varchar(255) DEFAULT NULL,
  `ECModifyDate` datetime DEFAULT NULL,
  `ECModifyBy` int(11) DEFAULT NULL,
  `ECStatus` enum('Active','InActive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Entity_Contact`
--

INSERT INTO `Entity_Contact` (`ECID`, `ECName`, `ECEmail`, `ECPhone`, `ECFax`, `ECWebsite`, `ECAddress1`, `ECAddress2`, `ECCity`, `ECState`, `ECZip`, `ECCountry`, `ECModifyDate`, `ECModifyBy`, `ECStatus`) VALUES
(1, 'John', 'john@red.com', '123456789', '123456789', 'red.com', '123 china town', NULL, 'new york', 'new york', '55445', 'USA', NULL, 2, 'Active'),
(2, 'Oanh', 'okt@gmail.com', '456789123', '456789123', 'okt.com', '456 hcm', NULL, 'sai gon', NULL, NULL, 'viet nam', NULL, 1, 'Active'),
(3, 'william', 'will@gmail.com', '987654321', '987654321', 'will.com', '678 su van hanh', NULL, 'ho chi minh', NULL, NULL, 'viet nam', NULL, 5, 'Active'),
(4, 'David', 'david@yahoo.com', '456897456', '455678123', 'abc.com', '123 khi nao em buon', NULL, 'Shanghai', NULL, '55487', 'China', NULL, 6, 'Active'),
(5, 'chris', 'chris@email.com', '123653827', '127385639', 'abcd.com', '542 o dau vay', NULL, 'austin', 'texas', '73726', 'USA', NULL, 1, 'Active'),
(6, 'sally', 'sally@email.com', '3243254552', '2312908353', 'jdh.com', '435 bellair', NULL, 'houston', 'texas', '77028', 'USA', NULL, 2, 'Active'),
(7, 'emily', 'emily@email.com', '2342352359', '2352532350', 'ksdf.com', '4350 san ho he', NULL, 'santa anna', 'CA', '45233', 'USA', NULL, 5, 'Active'),
(8, 'a', 'a@email.com', '1', '1', 'a', '1', '', '', '', '', '', NULL, 1, 'InActive');

-- --------------------------------------------------------

--
-- Table structure for table `Entity_RelateTo_Contact`
--

CREATE TABLE `Entity_RelateTo_Contact` (
  `EID` int(11) NOT NULL,
  `ECID` int(11) NOT NULL,
  `ERCTitle` varchar(255) DEFAULT NULL,
  `Priority` enum('Primary Contact','Alternative Contact') DEFAULT NULL,
  `DateCreated` datetime DEFAULT NULL,
  `ERCModifyDate` datetime DEFAULT NULL,
  `ERCModifyBy` int(11) DEFAULT NULL,
  `ERCStatus` enum('Active','InActive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Entity_RelateTo_Contact`
--

INSERT INTO `Entity_RelateTo_Contact` (`EID`, `ECID`, `ERCTitle`, `Priority`, `DateCreated`, `ERCModifyDate`, `ERCModifyBy`, `ERCStatus`) VALUES
(1, 1, 'CEO', 'Primary Contact', '2018-06-04 00:00:00', '2018-06-29 02:29:00', 5, 'InActive'),
(1, 6, 'Manager', 'Alternative Contact', '2018-06-29 01:21:00', '2018-06-29 03:39:00', 1, 'Active'),
(2, 2, 'VP', 'Primary Contact', '2018-03-01 00:00:00', '2018-06-29 02:30:00', 5, 'InActive'),
(2, 3, 'Representative', 'Alternative Contact', '2018-06-13 00:00:00', '2018-06-29 02:22:00', 1, 'InActive'),
(3, 1, 'Sale Manager', 'Primary Contact', '2017-12-04 00:00:00', '2018-06-29 04:42:00', 1, 'InActive'),
(4, 2, 'Sale Manager', 'Alternative Contact', '2018-06-05 00:00:00', '2018-06-29 03:39:00', 1, 'Active'),
(4, 4, 'Sale Director', 'Primary Contact', '2018-06-11 00:00:00', '2018-06-29 02:28:00', 1, 'Active'),
(5, 6, 'General Manager', 'Primary Contact', '2018-06-20 00:00:00', '2018-06-29 03:39:00', 1, 'Active'),
(5, 7, 'Accounting Manager', 'Primary Contact', '2018-03-13 00:00:00', '2018-06-29 03:39:00', 1, 'Active'),
(5, 8, 'Manager', 'Primary Contact', '2018-06-29 03:44:00', '2018-06-29 03:44:00', 1, 'Active'),
(6, 6, 'General Manager', 'Primary Contact', '2018-06-12 00:00:00', '2018-06-29 03:39:00', 1, 'Active'),
(7, 5, 'Director', 'Primary Contact', '2018-06-28 04:51:00', '2018-06-28 04:51:00', 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `Project`
--

CREATE TABLE `Project` (
  `ProjectID` int(11) NOT NULL,
  `ProjectName` varchar(255) DEFAULT NULL,
  `ProjectDescription` varchar(2047) DEFAULT NULL,
  `BrandBelongTo` int(11) DEFAULT NULL,
  `DeptBelongTo` int(11) DEFAULT NULL,
  `DateCreated` datetime DEFAULT NULL,
  `StartDate` datetime DEFAULT NULL,
  `EstEndDate` datetime DEFAULT NULL,
  `EndDate` datetime DEFAULT NULL,
  `EnterBy` int(11) DEFAULT NULL,
  `ProjectLead` int(11) DEFAULT NULL,
  `ModifyDate` datetime DEFAULT NULL,
  `ModifyBy` int(11) DEFAULT NULL,
  `Progress` enum('Complete','InComplete') DEFAULT NULL,
  `ProjectStatus` enum('Active','InActive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Project`
--

INSERT INTO `Project` (`ProjectID`, `ProjectName`, `ProjectDescription`, `BrandBelongTo`, `DeptBelongTo`, `DateCreated`, `StartDate`, `EstEndDate`, `EndDate`, `EnterBy`, `ProjectLead`, `ModifyDate`, `ModifyBy`, `Progress`, `ProjectStatus`) VALUES
(1, 'table', 'build desktop table for each room at the new office', 1, 2, '2018-06-12 00:00:00', '2018-06-20 00:00:00', '2018-06-22 00:00:00', NULL, 1, 1002, '2018-06-28 15:30:00', 1, 'InComplete', 'Active'),
(2, 'computer', 'build computer for marketing department', 1, 1, '2018-06-03 00:00:00', '2018-06-07 00:00:00', '2018-06-21 00:00:00', '2018-06-21 00:00:00', 1, 1004, '2018-06-26 00:00:00', 1, 'Complete', 'Active'),
(3, 'scope', 'multiple scope for fire fun', 2, 1, '2018-05-01 00:00:00', '2018-06-13 00:00:00', '2018-06-21 00:00:00', '2018-06-21 00:00:00', 1, 1003, '2018-06-25 00:00:00', 1, 'Complete', 'Active'),
(4, 'red dot', 'create red dot sight for hunting', 3, 5, '2018-06-04 00:00:00', '2018-06-07 00:00:00', '2018-06-25 00:00:00', NULL, 2, 1003, '2018-06-26 10:30:00', 1, 'InComplete', 'Active'),
(5, 'monocular', 'monocular that can see at night', 3, 3, '2018-06-06 00:00:00', '2018-06-18 00:00:00', '2018-06-30 00:00:00', NULL, 1, 1001, '2018-06-23 00:00:00', 2, 'InComplete', 'Active'),
(6, 'chair', 'build chair for office', 5, 1, '2018-06-05 00:00:00', '2018-06-19 00:00:00', '2018-06-27 00:00:00', NULL, 2, 1003, '2018-06-25 00:00:00', 1, 'InComplete', 'Active'),
(7, 'a', 'a', 3, 4, '2018-06-22 00:00:00', '2018-06-22 00:00:00', NULL, NULL, 1, 1003, '2018-06-19 00:00:00', 1, 'InComplete', 'InActive'),
(13, 'b', 'b', 2, 3, '2018-06-22 00:00:00', '2018-06-01 00:00:00', '2018-06-16 00:00:00', NULL, 2, 1002, NULL, 2, 'InComplete', 'InActive'),
(14, 'c', 'c', 5, 2, '2018-06-22 00:00:00', '2018-06-09 00:00:00', '2018-06-28 00:00:00', NULL, 2, 1003, NULL, 1, 'InComplete', 'Active'),
(15, 'dd', 'dd', 3, 6, '2018-06-01 00:00:00', '2018-06-02 00:00:00', '2018-06-15 00:00:00', '2018-06-16 00:00:00', 1, 1002, '2018-06-28 08:31:00', 1, 'Complete', 'InActive'),
(16, 'aaa', 'aa', 2, 4, '2018-06-02 00:00:00', '2018-06-01 00:00:00', '2018-06-20 00:00:00', '2018-06-01 00:00:00', 1, 1007, '2018-06-26 10:37:00', 1, 'InComplete', 'Active'),
(17, 'ab', 'ab', 3, 3, '2018-06-01 00:00:00', '2018-06-22 00:00:00', '2018-06-22 00:00:00', '2018-06-22 00:00:00', 2, 1005, '2018-06-26 10:37:00', 1, 'Complete', 'InActive'),
(18, 'abc', 'abc', 2, 2, '2018-06-01 00:00:00', '2018-06-01 00:00:00', '2018-01-11 00:00:00', '2018-06-01 00:00:00', 1, 1004, '2018-06-27 16:45:00', 1, 'InComplete', 'Active'),
(19, 'e', 'e', 3, 3, '2018-06-25 00:00:00', '2018-06-30 00:00:00', '2018-06-01 00:00:00', '2018-06-30 00:00:00', 1, 1003, '2018-06-26 14:33:00', 1, 'Complete', 'Active'),
(20, 'f', 'f', 5, 6, '2018-06-25 00:00:00', '2018-06-01 00:00:00', '2018-06-25 00:00:00', NULL, 2, 1003, '2018-06-27 09:58:00', 1, 'InComplete', 'Active'),
(21, '1', '1', 2, 3, '2018-06-26 00:00:00', '2018-06-26 00:00:00', '2018-06-15 00:00:00', '2018-06-26 00:00:00', 1, 1005, '2018-06-27 16:45:00', 1, 'InComplete', 'Active'),
(22, 'afaf', 'aff', 2, 3, '2018-06-27 00:00:00', '2018-06-27 00:00:00', '2018-06-27 00:00:00', NULL, 2, 1003, '2018-06-27 16:54:00', 1, 'InComplete', 'Active'),
(23, 'cui', 'cui', 4, 2, '2018-06-28 00:00:00', '2018-06-28 00:00:00', '2018-07-26 00:00:00', NULL, 1, 1003, '2018-06-28 08:29:00', 1, 'InComplete', 'Active'),
(24, 'f', 'f', 4, 2, '2018-06-28 00:00:00', '2018-06-28 00:00:00', '2018-06-28 00:00:00', '1969-12-31 00:00:00', 1, 1005, '2018-06-28 10:09:00', 1, 'InComplete', 'InActive'),
(25, 'g', 'g', 4, 3, '2018-06-28 00:00:00', '2018-06-28 00:00:00', '2018-06-28 00:00:00', '1969-12-31 00:00:00', 1, 1007, '2018-06-28 10:25:00', 1, 'InComplete', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `Project_Require_Sample`
--

CREATE TABLE `Project_Require_Sample` (
  `ProjectID` int(11) NOT NULL,
  `SID` int(11) NOT NULL,
  `Quantity` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Project_Require_Sample`
--

INSERT INTO `Project_Require_Sample` (`ProjectID`, `SID`, `Quantity`) VALUES
(1, 4, 5),
(2, 2, 10),
(2, 3, 15),
(3, 4, 40),
(3, 7, 15),
(4, 1, 15),
(4, 8, 5),
(5, 7, 7),
(6, 6, 15),
(13, 7, 5),
(14, 8, 10),
(16, 6, 7),
(17, 1, 7),
(17, 7, 15),
(18, 3, 5),
(19, 4, 20),
(20, 5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `Sample`
--

CREATE TABLE `Sample` (
  `SID` int(11) NOT NULL,
  `SName` varchar(255) DEFAULT NULL,
  `SDescription` varchar(1023) DEFAULT NULL,
  `SImages` blob,
  `SEnterBy` int(11) DEFAULT NULL,
  `SStatus` enum('Active','InActive') DEFAULT NULL,
  `SModifyDate` datetime DEFAULT NULL,
  `SModifyBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Sample`
--

INSERT INTO `Sample` (`SID`, `SName`, `SDescription`, `SImages`, `SEnterBy`, `SStatus`, `SModifyDate`, `SModifyBy`) VALUES
(1, 'keyboard', 'red keyboard with blue light', NULL, 1, 'Active', '2018-06-28 09:43:00', 1),
(2, 'mouse', 'usb mouse', NULL, 3, 'InActive', '2018-06-28 09:42:00', 1),
(3, 'fan', 'portable fan for desktop table', '', 2, 'Active', '2018-06-27 04:26:00', 1),
(4, 'pen', 'different color pens', '', 8, 'Active', '2018-06-27 04:26:00', 2),
(5, 'tatical pen', 'this is the tactical pen', '', 7, 'Active', '2018-06-27 04:26:00', 1),
(6, 'chair', 'this is a chair', '', 3, 'Active', '2018-06-27 04:26:00', 5),
(7, 'monocular', 'this is a monocular', '', 2, 'Active', '2018-06-27 04:26:00', 1),
(8, 'air gun', 'air gun to test red dot', '', 1, 'Active', '2018-06-27 04:26:00', 2),
(9, 'a', 'a', '', 2, 'Active', '2018-06-27 04:27:00', 1),
(10, 'b', 'b', '', 2, 'Active', '2018-06-27 04:26:00', 7),
(11, 'd', 'd', '', 2, 'Active', '2018-06-27 04:26:00', 1),
(12, 'c', 'c', '', 1, 'Active', '2018-06-27 04:28:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `SampleRecord`
--

CREATE TABLE `SampleRecord` (
  `SRID` int(11) NOT NULL,
  `SID` int(11) NOT NULL,
  `EID` int(11) NOT NULL,
  `Quantity` smallint(6) DEFAULT NULL,
  `PriceperUnit` double DEFAULT NULL,
  `DateRequested` datetime DEFAULT NULL,
  `Type` enum('Quote','P.O','Invoice','Payment') DEFAULT NULL,
  `EstDeliver` date DEFAULT NULL,
  `ArrivalDate` date DEFAULT NULL,
  `PaymentTerms` varchar(255) DEFAULT NULL,
  `WarrantyTerms` varchar(255) DEFAULT NULL,
  `ShippingTerms` varchar(255) DEFAULT NULL,
  `SRRequestBy` int(11) DEFAULT NULL,
  `SRModifyDate` datetime DEFAULT NULL,
  `SRModifyBy` int(11) DEFAULT NULL,
  `SRStatus` enum('Active','InActive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SampleRecord`
--

INSERT INTO `SampleRecord` (`SRID`, `SID`, `EID`, `Quantity`, `PriceperUnit`, `DateRequested`, `Type`, `EstDeliver`, `ArrivalDate`, `PaymentTerms`, `WarrantyTerms`, `ShippingTerms`, `SRRequestBy`, `SRModifyDate`, `SRModifyBy`, `SRStatus`) VALUES
(1, 1, 1, 10, 35, '2018-06-04 00:00:00', 'Quote', '2018-06-12', '2018-06-11', '', '', '', 1, '2018-06-28 15:29:00', 1, 'InActive'),
(2, 2, 1, 10, 120, '2018-06-11 00:00:00', 'Quote', '2018-06-18', '2018-06-20', NULL, NULL, NULL, 2, NULL, 2, 'Active'),
(3, 2, 3, 5, 65, '2018-06-18 00:00:00', 'Quote', '2018-06-20', '2018-06-20', '3 months', '3 months', '3 days', 3, NULL, 3, 'Active'),
(4, 4, 1, 20, 400, '2018-06-06 00:00:00', 'Invoice', '2018-06-11', '2018-06-13', NULL, NULL, NULL, 5, NULL, 5, 'Active'),
(5, 5, 3, 20, 500, '2018-06-01 00:00:00', 'Payment', '2018-06-07', '2018-06-07', NULL, NULL, NULL, 1, NULL, 2, 'Active'),
(6, 1, 1, 5, 18, '2018-06-21 00:00:00', 'P.O', NULL, NULL, NULL, NULL, NULL, 5, '2018-06-28 09:44:00', 1, 'Active'),
(7, 8, 5, 40, 500, '2018-06-04 00:00:00', 'Quote', NULL, NULL, NULL, NULL, NULL, 7, NULL, 2, 'Active'),
(8, 5, 4, 10, 120, '2018-06-11 00:00:00', 'Quote', NULL, NULL, NULL, NULL, NULL, 2, NULL, 5, 'Active'),
(9, 7, 2, 7, 130, '2018-06-01 00:00:00', 'Invoice', NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 'Active'),
(10, 6, 6, 12, 120, '2018-06-18 00:00:00', 'Payment', NULL, NULL, NULL, NULL, NULL, 3, NULL, 2, 'Active'),
(11, 2, 1, 5, 30, '2018-06-18 00:00:00', 'P.O', '2018-06-26', '2018-06-26', NULL, NULL, NULL, 3, NULL, 2, 'Active'),
(12, 8, 2, 5, 10, '2018-06-04 00:00:00', 'Invoice', '2018-06-12', '2018-06-13', NULL, NULL, NULL, 1, NULL, 1, 'Active'),
(13, 3, 7, 20, 15, '2018-06-04 00:00:00', 'P.O', '2018-06-12', '2018-06-13', NULL, NULL, NULL, 2, NULL, 2, 'Active'),
(14, 8, 7, 8, 25, '2018-06-01 00:00:00', 'P.O', '2018-06-20', '2018-06-20', NULL, NULL, NULL, 3, NULL, 2, 'Active'),
(15, 3, 2, 5, 12, '2018-06-04 00:00:00', 'Quote', '2018-06-20', '2018-06-20', NULL, NULL, NULL, 2, NULL, 1, 'Active'),
(16, 6, 2, 15, 13, '2018-06-11 00:00:00', 'Quote', '2018-06-18', '2018-06-19', NULL, NULL, NULL, 3, NULL, 3, 'Active'),
(17, 8, 4, 5, 120, '2018-06-28 00:00:00', 'Quote', '1000-01-01', '1000-01-01', '', '', '', 1, '2018-06-28 09:35:00', 1, 'Active'),
(18, 7, 7, 5, 100, '2018-06-28 00:00:00', 'Quote', '2018-07-03', '1000-01-01', '', '6 months', '', 1, '2018-06-28 09:37:00', 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `SampleRecord_LineItem`
--

CREATE TABLE `SampleRecord_LineItem` (
  `SRLID` int(11) NOT NULL,
  `SRID` int(11) NOT NULL,
  `Item` varchar(255) DEFAULT NULL,
  `Cost` double DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `WarrantyTerms` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `SampleTesting`
--

CREATE TABLE `SampleTesting` (
  `STID` int(11) NOT NULL,
  `SRID` int(11) DEFAULT NULL,
  `STRating` enum('1','2','3','4','5') DEFAULT NULL,
  `STDateTested` datetime DEFAULT NULL,
  `STStatus` enum('passed','failed') DEFAULT NULL,
  `STNotes` varchar(1023) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `SMBrands`
--

CREATE TABLE `SMBrands` (
  `BrandID` int(11) NOT NULL,
  `BrandPID` int(11) DEFAULT NULL,
  `BrandName` varchar(200) DEFAULT NULL,
  `BrandDescription` varchar(1000) DEFAULT NULL,
  `DateFounded` datetime DEFAULT NULL,
  `BrandStatus` enum('Active','Inactive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SMBrands`
--

INSERT INTO `SMBrands` (`BrandID`, `BrandPID`, `BrandName`, `BrandDescription`, `DateFounded`, `BrandStatus`) VALUES
(1, NULL, 'SellMark', NULL, '2000-06-08 00:00:00', 'Active'),
(2, 1, 'Fire Field', 'Firefield brings high-energy fun at competitive price points – perfect for the active lifestyle, Firefield’s products dominate in MilSim, training, accessory and plinking markets. A comprehensive brand providing optics, rails, lights, lasers and range bags, new shooters see Firefield as a one-stop shop for range day', '2003-06-08 00:00:00', 'Active'),
(3, 1, 'Pulsar', 'Subverting traditional practices, Pulsar is an industry leading brand featuring bleeding-edge thermal and night vision technology at revolutionary pricing. A custom, ground-up designed UI with all the features users want, and none they don’t, propels ease of use to new heights without sacrificing affordability. A favorite of hog and predator hunters as well as law enforcement officials, Pulsar delivers unmatched cost to value and premium performance simultaneously', '2005-06-08 00:00:00', 'Active'),
(4, 1, '12Survivors', 'From family-friendly field trips to serious survival situations, 12 Survivors products run the outdoor gamut to suit all needs. A variety quality products are available – priced for the market, not the name, and designed to limit environmental footprint, this versatile brand can fulfill needs in camping, backpacking, sports, travel, survival and other markets.', '2011-06-08 00:00:00', 'Active'),
(5, 1, 'Sight Mark', 'Sightmark hits the heart of the optics market with pinpoint accuracy. Best-in-class performance and consumer-level pricing compliment a lifetime warranty to form an industry staple. From rugged red dots and riflescopes to best-selling night vision, Sightmark makes its mark in the hearts and minds of consumers by consistently delivering quality at a price that performs as well as its products.', '2007-06-08 00:00:00', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `SMCategories`
--

CREATE TABLE `SMCategories` (
  `CatID` int(11) NOT NULL,
  `BrandID` int(11) NOT NULL,
  `CatName` varchar(200) DEFAULT NULL,
  `CatDescription` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SMCategories`
--

INSERT INTO `SMCategories` (`CatID`, `BrandID`, `CatName`, `CatDescription`) VALUES
(1, 5, 'MONOCULAR', NULL),
(2, 5, 'RED DOT SIGHTS', NULL),
(3, 5, 'BORESIGHTS', NULL),
(4, 5, 'LASER WEAPON SIGHTS', NULL),
(5, 5, 'MAGNIFIRES', NULL),
(6, 5, 'RIFLESCOPES', NULL),
(7, 5, 'FLASHLIGHTS', NULL),
(8, 5, 'DIGITAL NIGHT VISION', NULL),
(9, 5, 'NIGHT VISION', NULL),
(10, 5, 'SPOTTING SCOPES', NULL),
(11, 5, 'BINOCULARS', NULL),
(12, 5, 'PRISMATIC SIGHTS', NULL),
(13, 5, 'ACCESSORIES', NULL),
(30, 2, 'MONOCULARS', NULL),
(31, 2, 'RIFLE BAGS', NULL),
(32, 2, 'DIGITAL NIGHT VISION', NULL),
(33, 2, 'COMBAT SIGHT', NULL),
(34, 2, 'BIPODS', NULL),
(35, 2, 'KNIVES', NULL),
(36, 2, 'RAILS', NULL),
(37, 2, 'GREEN DOT SIGHTS', NULL),
(38, 2, 'MAGNIFIERS', NULL),
(39, 2, 'REFLEX SIGHTS', NULL),
(40, 2, 'RIFLESCOPES', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `SMDBAccounts`
--

CREATE TABLE `SMDBAccounts` (
  `AcctID` int(11) NOT NULL,
  `SMEmID` int(11) NOT NULL,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `AcctType` enum('Admin','Manager','User') DEFAULT NULL,
  `AcctStatus` enum('Active','InActive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SMDBAccounts`
--

INSERT INTO `SMDBAccounts` (`AcctID`, `SMEmID`, `username`, `password`, `AcctType`, `AcctStatus`) VALUES
(1, 1001, 'hvu', 'minhhai', 'Admin', 'Active'),
(2, 1002, 'manager', 'manager', 'Manager', 'Active'),
(3, 1004, 'user', 'user', 'User', 'Active'),
(5, 1002, 'manager1', 'manager1', 'Manager', 'Active'),
(6, 1005, 'manager2', 'manager2', 'Manager', 'Active'),
(7, 1006, 'user1', 'user1', 'User', 'Active'),
(8, 1008, 'user2', 'user2', 'User', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `SMDepartments`
--

CREATE TABLE `SMDepartments` (
  `SMDeptID` int(11) NOT NULL,
  `SMDeptName` varchar(200) DEFAULT NULL,
  `Location` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SMDepartments`
--

INSERT INTO `SMDepartments` (`SMDeptID`, `SMDeptName`, `Location`) VALUES
(1, 'ACCOUNTING/OPERATIONS', 'MANSFIELD'),
(2, 'LAW ENFORCEMENT SALES', 'MANSFIELD'),
(3, 'MARKETING', 'MANSFIELD'),
(4, 'SALES', 'MANSFIELD'),
(5, 'QUALITY ASSURANCE', 'MANSFIELD'),
(6, 'SHIPPING/RECEIVING', 'MANSFIELD'),
(101, 'BOARD', 'MANSFIELD');

-- --------------------------------------------------------

--
-- Table structure for table `SMEmployeePayRolls`
--

CREATE TABLE `SMEmployeePayRolls` (
  `PayID` int(11) NOT NULL,
  `SMEmID` int(11) NOT NULL,
  `PayType` enum('Check','Cash','Direct Deposit') DEFAULT NULL,
  `Amount` double DEFAULT NULL,
  `PayFrom` datetime DEFAULT NULL,
  `PayTo` datetime DEFAULT NULL,
  `PayIssueDate` datetime DEFAULT NULL,
  `PayStatus` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `SMEmployees`
--

CREATE TABLE `SMEmployees` (
  `SMEmID` int(11) NOT NULL,
  `SMDepartID` int(11) NOT NULL,
  `SMEmName` varchar(200) DEFAULT NULL,
  `SMEmTitle` varchar(200) DEFAULT NULL,
  `Manager` int(200) DEFAULT NULL,
  `WorkType` varchar(200) DEFAULT NULL,
  `StartDate` datetime DEFAULT NULL,
  `EndDate` datetime DEFAULT NULL,
  `WorkStatus` enum('Active','InActive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SMEmployees`
--

INSERT INTO `SMEmployees` (`SMEmID`, `SMDepartID`, `SMEmName`, `SMEmTitle`, `Manager`, `WorkType`, `StartDate`, `EndDate`, `WorkStatus`) VALUES
(1001, 101, 'Dianna', 'CEO', NULL, 'Full Time', '2000-01-01 00:00:00', NULL, 'Active'),
(1002, 1, 'John', 'Manager', 1001, 'Full Time', '2006-05-05 00:00:00', NULL, 'Active'),
(1003, 3, 'Carlos', 'Manager', 1001, 'Full Time', '2001-02-02 00:00:00', NULL, 'Active'),
(1004, 3, 'Camille', 'Employee', 1003, 'PartTime/Intern', '2018-06-04 00:00:00', '2018-08-10 00:00:00', 'Active'),
(1005, 4, 'manager1', 'Manager', 1002, 'Full Time', '2018-06-01 00:00:00', NULL, 'Active'),
(1006, 5, 'employee1', 'Employee', 1003, 'Part Time/Intern', '2018-06-01 00:00:00', NULL, 'Active'),
(1007, 3, 'manager2', 'Manager', 1003, 'Full Time', '2018-06-01 00:00:00', NULL, 'Active'),
(1008, 6, 'employee2', 'Employee', 1002, 'Full Time', '2018-05-04 00:00:00', NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `SMEmployeesContacts`
--

CREATE TABLE `SMEmployeesContacts` (
  `EmContactID` int(11) NOT NULL,
  `SMEmID` int(11) NOT NULL,
  `SMEmPhone` varchar(15) DEFAULT NULL,
  `SMEmFax` varchar(50) DEFAULT NULL,
  `SMEmEmail` varchar(50) DEFAULT NULL,
  `SMEmAddress1` varchar(200) DEFAULT NULL,
  `SMEmAddress2` varchar(200) DEFAULT NULL,
  `SMEmAddress3` varchar(200) DEFAULT NULL,
  `SMEmCity` varchar(200) DEFAULT NULL,
  `SMEmState` varchar(2) DEFAULT NULL,
  `SMEmZip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SMEmployeesContacts`
--

INSERT INTO `SMEmployeesContacts` (`EmContactID`, `SMEmID`, `SMEmPhone`, `SMEmFax`, `SMEmEmail`, `SMEmAddress1`, `SMEmAddress2`, `SMEmAddress3`, `SMEmCity`, `SMEmState`, `SMEmZip`) VALUES
(1, 1004, '6823859275', NULL, 'abc@gmail.com', '3465 Oakmont ln', NULL, NULL, 'Fort Worth', 'TX', '76010');

-- --------------------------------------------------------

--
-- Table structure for table `SMProductEvaluation`
--

CREATE TABLE `SMProductEvaluation` (
  `EvaluateID` int(11) NOT NULL,
  `SMProID` int(11) NOT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `ProFamily` varchar(200) DEFAULT NULL,
  `ReviewDate` datetime DEFAULT NULL,
  `Customer` varchar(200) DEFAULT NULL,
  `SalesRep` varchar(200) DEFAULT NULL,
  `Location` varchar(200) DEFAULT NULL,
  `ProPerformance` enum('1','2','3','4','5') DEFAULT NULL,
  `ProQuality` enum('1','2','3','4','5') DEFAULT NULL,
  `Dependability` enum('1','2','3','4','5') DEFAULT NULL,
  `ProFeatures` enum('1','2','3','4','5') DEFAULT NULL,
  `Comments` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SMProductEvaluation`
--

INSERT INTO `SMProductEvaluation` (`EvaluateID`, `SMProID`, `Description`, `ProFamily`, `ReviewDate`, `Customer`, `SalesRep`, `Location`, `ProPerformance`, `ProQuality`, `Dependability`, `ProFeatures`, `Comments`) VALUES
(1, 1, NULL, NULL, '2018-06-05 00:00:00', 'HAI', 'VU', 'MANSFIELD', '4', '5', '4', '5', NULL),
(2, 5, NULL, NULL, '2018-05-10 00:00:00', 'ALEX', 'SMITH', 'ARLINGTON', '3', '3', '4', '4', NULL),
(3, 17, NULL, NULL, '2018-05-16 14:00:00', 'JOHN', 'NGUYEN', 'DALLAS', '4', '4', '3', '5', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `SMProducts`
--

CREATE TABLE `SMProducts` (
  `SMProID` int(11) NOT NULL,
  `CatID` int(11) NOT NULL,
  `SKU` varchar(200) DEFAULT NULL,
  `SubCategories` varchar(200) DEFAULT NULL,
  `ProName` varchar(200) DEFAULT NULL,
  `ProFamily` varchar(1000) DEFAULT NULL,
  `MSRP` double DEFAULT NULL,
  `SMPrice` double DEFAULT NULL,
  `LandedPrice` double DEFAULT NULL,
  `ProImage` blob,
  `ProDescription` varchar(10000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SMProducts`
--

INSERT INTO `SMProducts` (`SMProID`, `CatID`, `SKU`, `SubCategories`, `ProName`, `ProFamily`, `MSRP`, `SMPrice`, `LandedPrice`, `ProImage`, `ProDescription`) VALUES
(1, 1, 'SM18024', NULL, 'Signal 320RT Digital Night Vision Monocular', NULL, NULL, NULL, 479.99, NULL, 'Offering a detection range of up to 380 yards in pure darkness, the Signal N320RT is a digital night vision monocular designed for scanning and scouting. Whether being used for hunting, wildlife observation or security and surveillance, the Signal’s high-resolution 640x480 CMOS sensor, 640x480 LCD display and built-in 850nm LED IR illuminator provide unrivaled night time performance. This advanced device features built-in video recording with sound and connects to smart phones via the Stream Vision app, allowing users to remote view/control the Signal and stream videos directly to YouTube with 8 Gb of internal memory. The Signal N320RT is able to stretch magnification to an incredible 9x due to a 2x digital zoom feature.  Other useful features include bright light exposure resistance technology, front focus objective lens, an attached Weaver rail for additional accessories and an intuitive easy-to-use interface. The Signal N320RT 4.5x30 includes a carrying case, user manual, USB cable, neck strap and lens cloth.'),
(2, 1, 'SM18025', NULL, 'Signal 340RT Digital Night Vision Monocular', NULL, NULL, NULL, 539.99, NULL, 'Detecting objects in total darkness has never been easier, thanks to the Signal 340RT Digital Night Vision Monocular. An ideal scanning tool for hunting, wildlife observation and security & surveillance, the Signal 340RT offers a 330 yard detection range and incredible night time performance due to its high sensitivity 640x480 CMOS sensor and 640x480 LCD display. The 340RT also features an invisible 940nm IR illuminator that produces no glow and built-in video recording with sound, allowing users to take images and videos undetected. The Signal connects to the Pulsar Stream Vision app, allowing remote view/control and streaming directly to YouTube. This innovative digital night vision unit can run for up 5 hours on 4 AA batteries and boasts a Weaver rail for additional accessories and a front focus objective lens for a clear, crisp image. The Signal 340RT includes carrying case, user manual, USB cable, neck strap and lens cloth.'),
(3, 2, 'SM26032', 'ULTRA SHOT', 'Ultra Shot A-Spec Reflex Sight', NULL, NULL, NULL, 179.99, NULL, NULL),
(4, 2, 'SM26015', 'ULTRA SHOT', 'Ultra Shot M-Spec FMS Carbon Fiber Reflex Sight', NULL, NULL, NULL, 299.99, NULL, NULL),
(5, 2, 'SM26035', 'ULTRA SHOT', 'Ultra Shot M-Spec FMS Reflex Sight', NULL, NULL, NULL, 239.99, NULL, NULL),
(7, 2, 'SM26010', 'ULTRA SHOT', 'Ultra Shot M-Spec FMS Reflex Sight', NULL, NULL, NULL, 275.99, NULL, NULL),
(8, 2, 'SM26021', 'WOLVERINE', 'Wolverine 1x23 CSR Red Dot Sight', NULL, NULL, NULL, 155.99, NULL, NULL),
(9, 2, 'SM26021DE', 'WOLVERINE', 'Wolverine 1x23 CSR Red Dot Sight - DARK EARTH', NULL, NULL, NULL, 167.99, NULL, NULL),
(10, 2, 'SM26020-LQD', 'WOLVERINE', 'Wolverine 1x28 FSR LQD', NULL, NULL, NULL, 215.99, NULL, NULL),
(11, 2, 'SM26040', 'ELEMENT 1X30', 'Element 1x30 Red Dot Sight', NULL, NULL, NULL, 155.99, NULL, NULL),
(12, 2, 'SM26043', 'MINI SHOT', 'Mini Shot M-Spec FMS', NULL, NULL, NULL, 239.99, NULL, NULL),
(13, 2, 'SM26043-LQD', 'MINI SHOT', 'Mini Shot M-Spec LQD', NULL, NULL, NULL, 299.99, NULL, NULL),
(16, 3, 'SM39046', 'PISTOL', '.380 ACP Pistol Boresight', NULL, NULL, NULL, 35.99, NULL, NULL),
(17, 3, 'SM39016', 'PISTOL', '.40 S&W Boresight', NULL, NULL, NULL, 35.99, NULL, NULL),
(18, 3, 'SM39007', 'SHOTGUN', '12Ga Boresight', NULL, NULL, NULL, 35.99, NULL, NULL),
(19, 4, 'SM25013', 'LOPRO', 'LoPro Combo Flashlight (Visible and IR) and Green Laser Sight', NULL, NULL, NULL, 239.99, NULL, NULL),
(20, 4, 'SM25004DE', 'LOPRO', 'LoPro Combo Green Laser/220 Lumen Flashlight - Dark Earth', NULL, NULL, NULL, 179.99, NULL, NULL),
(21, 30, 'FF12004', NULL, 'Siege 10x50 Monocular', NULL, NULL, NULL, 69.97, NULL, NULL),
(22, 30, 'FF12004T', NULL, 'Siege 10x50R Tactical Monocular', NULL, NULL, NULL, 79.97, NULL, NULL),
(23, 30, 'FF12003', NULL, 'Siege 8x32 Monocular', NULL, NULL, NULL, 39.97, NULL, NULL),
(24, 35, 'FF72000', NULL, 'AR Multi-Tool', NULL, NULL, NULL, 39.97, NULL, NULL),
(25, 35, 'FF77001', NULL, 'Rifle Knife Bayonet with Barrel Mount', NULL, NULL, NULL, 19.97, NULL, NULL),
(28, 6, 'asd', 'asd', 'asd', 'asd', 12, 12, 12, NULL, NULL),
(29, 30, 'dfg', 'wtt', 'ergr', 'ergreg', 324, 234, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `a` int(11) NOT NULL,
  `b` int(11) NOT NULL,
  `c` enum('1','2','3','5','4') DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `testdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`a`, `b`, `c`, `text`, `testdate`) VALUES
(1, 1, '1', NULL, NULL),
(1, 2, '2', NULL, NULL),
(1, 4, '3', '', NULL),
(2, 1, '2', NULL, NULL),
(2, 3, '3', '', NULL),
(3, 2, '3', 'NULL', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Entity`
--
ALTER TABLE `Entity`
  ADD PRIMARY KEY (`EID`),
  ADD KEY `FK_EEnterBy_Account` (`EEnterBy`),
  ADD KEY `FK_EModifyBy_Account` (`EModifyBy`);

--
-- Indexes for table `Entity_Contact`
--
ALTER TABLE `Entity_Contact`
  ADD PRIMARY KEY (`ECID`),
  ADD KEY `FK_ECModifyBy_Account` (`ECModifyBy`);

--
-- Indexes for table `Entity_RelateTo_Contact`
--
ALTER TABLE `Entity_RelateTo_Contact`
  ADD PRIMARY KEY (`EID`,`ECID`),
  ADD KEY `FK_EContact` (`ECID`),
  ADD KEY `FK_ERCModifyBy_Account` (`ERCModifyBy`);

--
-- Indexes for table `Project`
--
ALTER TABLE `Project`
  ADD PRIMARY KEY (`ProjectID`),
  ADD KEY `FK_Project_SMBrand` (`BrandBelongTo`),
  ADD KEY `FK_Project_SMDept` (`DeptBelongTo`),
  ADD KEY `FK_EnterBy_Account` (`EnterBy`),
  ADD KEY `FK_ProjectLead_Employee` (`ProjectLead`),
  ADD KEY `FK_ModifyBy_Account` (`ModifyBy`);

--
-- Indexes for table `Project_Require_Sample`
--
ALTER TABLE `Project_Require_Sample`
  ADD PRIMARY KEY (`ProjectID`,`SID`),
  ADD KEY `FK_PRS_SR` (`SID`);

--
-- Indexes for table `Sample`
--
ALTER TABLE `Sample`
  ADD PRIMARY KEY (`SID`),
  ADD KEY `FK_Sample_Account` (`SEnterBy`),
  ADD KEY `FK_SModifyBy_Account` (`SModifyBy`);

--
-- Indexes for table `SampleRecord`
--
ALTER TABLE `SampleRecord`
  ADD PRIMARY KEY (`SRID`,`SID`,`EID`),
  ADD KEY `FK_SR_E` (`EID`),
  ADD KEY `FK_SR_S` (`SID`),
  ADD KEY `FK_SRRequestBy_Account` (`SRRequestBy`),
  ADD KEY `FK_SRModifyBy_Account` (`SRModifyBy`);

--
-- Indexes for table `SampleRecord_LineItem`
--
ALTER TABLE `SampleRecord_LineItem`
  ADD PRIMARY KEY (`SRLID`),
  ADD KEY `FK_SRL_SR` (`SRID`);

--
-- Indexes for table `SampleTesting`
--
ALTER TABLE `SampleTesting`
  ADD PRIMARY KEY (`STID`),
  ADD KEY `FK_ST_SR` (`SRID`);

--
-- Indexes for table `SMBrands`
--
ALTER TABLE `SMBrands`
  ADD PRIMARY KEY (`BrandID`);

--
-- Indexes for table `SMCategories`
--
ALTER TABLE `SMCategories`
  ADD PRIMARY KEY (`CatID`),
  ADD KEY `FK_SMCategories` (`BrandID`);

--
-- Indexes for table `SMDBAccounts`
--
ALTER TABLE `SMDBAccounts`
  ADD PRIMARY KEY (`AcctID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `FK_SMEmAccounts` (`SMEmID`);

--
-- Indexes for table `SMDepartments`
--
ALTER TABLE `SMDepartments`
  ADD PRIMARY KEY (`SMDeptID`);

--
-- Indexes for table `SMEmployeePayRolls`
--
ALTER TABLE `SMEmployeePayRolls`
  ADD PRIMARY KEY (`PayID`);

--
-- Indexes for table `SMEmployees`
--
ALTER TABLE `SMEmployees`
  ADD PRIMARY KEY (`SMEmID`),
  ADD KEY `FK_SMEmployees` (`SMDepartID`);

--
-- Indexes for table `SMEmployeesContacts`
--
ALTER TABLE `SMEmployeesContacts`
  ADD PRIMARY KEY (`EmContactID`),
  ADD KEY `FK_SMEmployeesContacts` (`SMEmID`);

--
-- Indexes for table `SMProductEvaluation`
--
ALTER TABLE `SMProductEvaluation`
  ADD PRIMARY KEY (`EvaluateID`),
  ADD KEY `FK_SMProductEvaluation` (`SMProID`);

--
-- Indexes for table `SMProducts`
--
ALTER TABLE `SMProducts`
  ADD PRIMARY KEY (`SMProID`),
  ADD UNIQUE KEY `SKU` (`SKU`),
  ADD KEY `FK_SMProducts` (`CatID`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`a`,`b`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Entity`
--
ALTER TABLE `Entity`
  MODIFY `EID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Entity_Contact`
--
ALTER TABLE `Entity_Contact`
  MODIFY `ECID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `Project`
--
ALTER TABLE `Project`
  MODIFY `ProjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `Sample`
--
ALTER TABLE `Sample`
  MODIFY `SID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `SampleRecord`
--
ALTER TABLE `SampleRecord`
  MODIFY `SRID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `SampleRecord_LineItem`
--
ALTER TABLE `SampleRecord_LineItem`
  MODIFY `SRLID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `SampleTesting`
--
ALTER TABLE `SampleTesting`
  MODIFY `STID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `SMBrands`
--
ALTER TABLE `SMBrands`
  MODIFY `BrandID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `SMCategories`
--
ALTER TABLE `SMCategories`
  MODIFY `CatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `SMDBAccounts`
--
ALTER TABLE `SMDBAccounts`
  MODIFY `AcctID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `SMDepartments`
--
ALTER TABLE `SMDepartments`
  MODIFY `SMDeptID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `SMEmployeePayRolls`
--
ALTER TABLE `SMEmployeePayRolls`
  MODIFY `PayID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `SMEmployees`
--
ALTER TABLE `SMEmployees`
  MODIFY `SMEmID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1009;

--
-- AUTO_INCREMENT for table `SMEmployeesContacts`
--
ALTER TABLE `SMEmployeesContacts`
  MODIFY `EmContactID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `SMProductEvaluation`
--
ALTER TABLE `SMProductEvaluation`
  MODIFY `EvaluateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `SMProducts`
--
ALTER TABLE `SMProducts`
  MODIFY `SMProID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Entity`
--
ALTER TABLE `Entity`
  ADD CONSTRAINT `FK_EEnterBy_Account` FOREIGN KEY (`EEnterBy`) REFERENCES `SMDBAccounts` (`AcctID`),
  ADD CONSTRAINT `FK_EModifyBy_Account` FOREIGN KEY (`EModifyBy`) REFERENCES `SMDBAccounts` (`AcctID`);

--
-- Constraints for table `Entity_Contact`
--
ALTER TABLE `Entity_Contact`
  ADD CONSTRAINT `FK_ECModifyBy_Account` FOREIGN KEY (`ECModifyBy`) REFERENCES `SMDBAccounts` (`AcctID`);

--
-- Constraints for table `Entity_RelateTo_Contact`
--
ALTER TABLE `Entity_RelateTo_Contact`
  ADD CONSTRAINT `FK_EContact` FOREIGN KEY (`ECID`) REFERENCES `Entity_Contact` (`ECID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ERCModifyBy_Account` FOREIGN KEY (`ERCModifyBy`) REFERENCES `SMDBAccounts` (`AcctID`),
  ADD CONSTRAINT `FK_Entity` FOREIGN KEY (`EID`) REFERENCES `Entity` (`EID`) ON UPDATE CASCADE;

--
-- Constraints for table `Project`
--
ALTER TABLE `Project`
  ADD CONSTRAINT `FK_EnterBy_Account` FOREIGN KEY (`EnterBy`) REFERENCES `SMDBAccounts` (`AcctID`),
  ADD CONSTRAINT `FK_ModifyBy_Account` FOREIGN KEY (`ModifyBy`) REFERENCES `SMDBAccounts` (`AcctID`),
  ADD CONSTRAINT `FK_ProjectLead_Employee` FOREIGN KEY (`ProjectLead`) REFERENCES `SMEmployees` (`SMEmID`),
  ADD CONSTRAINT `FK_Project_SMBrand` FOREIGN KEY (`BrandBelongTo`) REFERENCES `SMBrands` (`BrandID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Project_SMDept` FOREIGN KEY (`DeptBelongTo`) REFERENCES `SMDepartments` (`SMDeptID`) ON UPDATE CASCADE;

--
-- Constraints for table `Project_Require_Sample`
--
ALTER TABLE `Project_Require_Sample`
  ADD CONSTRAINT `FK_PRS_P` FOREIGN KEY (`ProjectID`) REFERENCES `Project` (`ProjectID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PRS_SR` FOREIGN KEY (`SID`) REFERENCES `Sample` (`SID`) ON UPDATE CASCADE;

--
-- Constraints for table `Sample`
--
ALTER TABLE `Sample`
  ADD CONSTRAINT `FK_SModifyBy_Account` FOREIGN KEY (`SModifyBy`) REFERENCES `SMDBAccounts` (`AcctID`),
  ADD CONSTRAINT `FK_Sample_Account` FOREIGN KEY (`SEnterBy`) REFERENCES `SMDBAccounts` (`AcctID`);

--
-- Constraints for table `SampleRecord`
--
ALTER TABLE `SampleRecord`
  ADD CONSTRAINT `FK_SRModifyBy_Account` FOREIGN KEY (`SRModifyBy`) REFERENCES `SMDBAccounts` (`AcctID`),
  ADD CONSTRAINT `FK_SRRequestBy_Account` FOREIGN KEY (`SRRequestBy`) REFERENCES `SMDBAccounts` (`AcctID`),
  ADD CONSTRAINT `FK_SR_E` FOREIGN KEY (`EID`) REFERENCES `Entity` (`EID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SR_S` FOREIGN KEY (`SID`) REFERENCES `Sample` (`SID`) ON UPDATE CASCADE;

--
-- Constraints for table `SampleRecord_LineItem`
--
ALTER TABLE `SampleRecord_LineItem`
  ADD CONSTRAINT `FK_SRL_SR` FOREIGN KEY (`SRID`) REFERENCES `SampleRecord` (`SRID`) ON UPDATE CASCADE;

--
-- Constraints for table `SampleTesting`
--
ALTER TABLE `SampleTesting`
  ADD CONSTRAINT `FK_ST_SR` FOREIGN KEY (`SRID`) REFERENCES `SampleRecord` (`SRID`) ON UPDATE CASCADE;

--
-- Constraints for table `SMCategories`
--
ALTER TABLE `SMCategories`
  ADD CONSTRAINT `FK_SMCategories` FOREIGN KEY (`BrandID`) REFERENCES `SMBrands` (`BrandID`) ON UPDATE CASCADE;

--
-- Constraints for table `SMDBAccounts`
--
ALTER TABLE `SMDBAccounts`
  ADD CONSTRAINT `FK_SMEmAccounts` FOREIGN KEY (`SMEmID`) REFERENCES `SMEmployees` (`SMEmID`);

--
-- Constraints for table `SMEmployees`
--
ALTER TABLE `SMEmployees`
  ADD CONSTRAINT `FK_SMEmployees` FOREIGN KEY (`SMDepartID`) REFERENCES `SMDepartments` (`SMDeptID`);

--
-- Constraints for table `SMEmployeesContacts`
--
ALTER TABLE `SMEmployeesContacts`
  ADD CONSTRAINT `FK_SMEmployeesContacts` FOREIGN KEY (`SMEmID`) REFERENCES `SMEmployees` (`SMEmID`);

--
-- Constraints for table `SMProductEvaluation`
--
ALTER TABLE `SMProductEvaluation`
  ADD CONSTRAINT `FK_SMProductEvaluation` FOREIGN KEY (`SMProID`) REFERENCES `SMProducts` (`SMProID`) ON UPDATE CASCADE;

--
-- Constraints for table `SMProducts`
--
ALTER TABLE `SMProducts`
  ADD CONSTRAINT `FK_SMProducts` FOREIGN KEY (`CatID`) REFERENCES `SMCategories` (`CatID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
