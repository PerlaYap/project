-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2014 at 05:17 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `microfinance2`
--
CREATE DATABASE IF NOT EXISTS `microfinance2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `microfinance2`;

-- --------------------------------------------------------

--
-- Table structure for table `addresstyperef`
--

CREATE TABLE IF NOT EXISTS `addresstyperef` (
  `AddressType` varchar(45) NOT NULL,
  PRIMARY KEY (`AddressType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `addresstyperef`
--

INSERT INTO `addresstyperef` (`AddressType`) VALUES
('Home Address'),
('Provincial Address');

-- --------------------------------------------------------

--
-- Table structure for table `branchaddress`
--

CREATE TABLE IF NOT EXISTS `branchaddress` (
  `ControlNo` int(11) NOT NULL,
  `BranchAddress` varchar(50) NOT NULL,
  PRIMARY KEY (`ControlNo`,`BranchAddress`),
  KEY `fk_BranchAddress_CaritasBranch1_idx` (`ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branchaddress`
--

INSERT INTO `branchaddress` (`ControlNo`, `BranchAddress`) VALUES
(2, '321 Tayuman St.'),
(3, '321 Paco St.'),
(4, '321 Pasay St.');

-- --------------------------------------------------------

--
-- Table structure for table `branchcontact`
--

CREATE TABLE IF NOT EXISTS `branchcontact` (
  `ControlNo` int(11) NOT NULL AUTO_INCREMENT,
  `ContactNo` varchar(11) NOT NULL,
  PRIMARY KEY (`ControlNo`,`ContactNo`),
  KEY `fk_BranchContact_CaritasBranch1_idx` (`ControlNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `branchcontact`
--

INSERT INTO `branchcontact` (`ControlNo`, `ContactNo`) VALUES
(2, '2526161'),
(3, '2526162'),
(4, '2526163');

-- --------------------------------------------------------

--
-- Table structure for table `businessaddress`
--

CREATE TABLE IF NOT EXISTS `businessaddress` (
  `ControlNo` int(11) NOT NULL,
  `Address` varchar(50) NOT NULL,
  PRIMARY KEY (`ControlNo`,`Address`),
  KEY `fk_BusinessAddress_LoanBusiness1_idx` (`ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `businessaddress`
--

INSERT INTO `businessaddress` (`ControlNo`, `Address`) VALUES
(1, '111 Taft Avenue'),
(2, '111 Taft Avenue'),
(3, '111 Taft Avenue');

-- --------------------------------------------------------

--
-- Table structure for table `businesscontact`
--

CREATE TABLE IF NOT EXISTS `businesscontact` (
  `ControlNo` int(11) NOT NULL,
  `ContactNo` varchar(11) NOT NULL,
  PRIMARY KEY (`ControlNo`,`ContactNo`),
  KEY `fk_BusinessContact_LoanBusiness1_idx` (`ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `businesscontact`
--

INSERT INTO `businesscontact` (`ControlNo`, `ContactNo`) VALUES
(1, '09223455433'),
(2, '2518282'),
(3, '2518282');

-- --------------------------------------------------------

--
-- Table structure for table `businessexpensetype`
--

CREATE TABLE IF NOT EXISTS `businessexpensetype` (
  `ExpenseType` varchar(30) NOT NULL,
  PRIMARY KEY (`ExpenseType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `caritasbranch`
--

CREATE TABLE IF NOT EXISTS `caritasbranch` (
  `ControlNo` int(11) NOT NULL AUTO_INCREMENT,
  `BranchID` int(11) NOT NULL,
  `BranchName` varchar(45) NOT NULL,
  PRIMARY KEY (`ControlNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `caritasbranch`
--

INSERT INTO `caritasbranch` (`ControlNo`, `BranchID`, `BranchName`) VALUES
(1, 1, 'Main'),
(2, 2, 'Tayuman'),
(3, 3, 'Paco'),
(4, 4, 'Makati');

-- --------------------------------------------------------

--
-- Table structure for table `caritasbranch_has_caritascenters`
--

CREATE TABLE IF NOT EXISTS `caritasbranch_has_caritascenters` (
  `CaritasBranch_ControlNo` int(11) NOT NULL,
  `CaritasCenters_ControlNo` int(11) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`CaritasBranch_ControlNo`,`CaritasCenters_ControlNo`,`Date`),
  KEY `fk_CaritasBranch_has_CaritasCenters_CaritasCenters1_idx` (`CaritasCenters_ControlNo`),
  KEY `fk_CaritasBranch_has_CaritasCenters_CaritasBranch1_idx` (`CaritasBranch_ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `caritasbranch_has_caritascenters`
--

INSERT INTO `caritasbranch_has_caritascenters` (`CaritasBranch_ControlNo`, `CaritasCenters_ControlNo`, `Date`) VALUES
(2, 1, '2013-01-01 05:00:32'),
(2, 2, '2013-01-01 05:02:06'),
(2, 3, '2013-01-01 05:02:41'),
(2, 4, '2013-01-01 05:03:25'),
(2, 5, '2013-01-01 05:04:42');

-- --------------------------------------------------------

--
-- Table structure for table `caritasbranch_has_caritaspersonnel`
--

CREATE TABLE IF NOT EXISTS `caritasbranch_has_caritaspersonnel` (
  `CaritasBranch_ControlNo` int(11) NOT NULL,
  `CaritasPersonnel_ControlNo` int(11) NOT NULL,
  PRIMARY KEY (`CaritasBranch_ControlNo`,`CaritasPersonnel_ControlNo`),
  KEY `fk_CaritasBranch_has_CaritasPersonnel_CaritasPersonnel1_idx` (`CaritasPersonnel_ControlNo`),
  KEY `fk_CaritasBranch_has_CaritasPersonnel_CaritasBranch1_idx` (`CaritasBranch_ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `caritasbranch_has_caritaspersonnel`
--

INSERT INTO `caritasbranch_has_caritaspersonnel` (`CaritasBranch_ControlNo`, `CaritasPersonnel_ControlNo`) VALUES
(1, 1),
(2, 2),
(2, 3),
(2, 4),
(3, 5),
(2, 6),
(3, 7),
(3, 8),
(4, 9),
(4, 10),
(4, 11),
(4, 12);

-- --------------------------------------------------------

--
-- Table structure for table `caritasbranch_has_establishmentstatus`
--

CREATE TABLE IF NOT EXISTS `caritasbranch_has_establishmentstatus` (
  `ControlNo` int(11) NOT NULL,
  `EstablishmentStatus` varchar(45) NOT NULL,
  `DateUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ControlNo`,`EstablishmentStatus`,`DateUpdated`),
  KEY `fk_CaritasBranch_has_EstablishmentStatus_CaritasBranch1_idx` (`ControlNo`),
  KEY `fk_CaritasBranch_has_EstablishmentStatus_EstablishmentStatu_idx` (`EstablishmentStatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `caritascenters`
--

CREATE TABLE IF NOT EXISTS `caritascenters` (
  `ControlNo` int(11) NOT NULL AUTO_INCREMENT,
  `CenterNo` int(11) NOT NULL,
  `DayoftheWeek` varchar(9) NOT NULL,
  `so_controlno` int(11) NOT NULL,
  PRIMARY KEY (`ControlNo`,`CenterNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `caritascenters`
--

INSERT INTO `caritascenters` (`ControlNo`, `CenterNo`, `DayoftheWeek`, `so_controlno`) VALUES
(1, 1, 'Monday', 0),
(2, 2, 'Tuesday', 3),
(3, 3, 'Wednesday', 0),
(4, 4, 'Thursday', 0),
(5, 5, 'Friday', 0);

-- --------------------------------------------------------

--
-- Table structure for table `caritascenters_has_coordinator`
--

CREATE TABLE IF NOT EXISTS `caritascenters_has_coordinator` (
  `CaritasCenters_ControlNo` int(11) NOT NULL,
  `Members_ControlNo` int(11) NOT NULL,
  `DateAssigned` date NOT NULL,
  `DateEnded` date DEFAULT NULL,
  PRIMARY KEY (`CaritasCenters_ControlNo`,`Members_ControlNo`,`DateAssigned`),
  KEY `fk_CaritasCenters_has_Members1_Members1_idx` (`Members_ControlNo`),
  KEY `fk_CaritasCenters_has_Members1_CaritasCenters1_idx` (`CaritasCenters_ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `caritascenters_has_members`
--

CREATE TABLE IF NOT EXISTS `caritascenters_has_members` (
  `CaritasCenters_ControlNo` int(11) NOT NULL,
  `Members_ControlNo` int(11) NOT NULL,
  `DateEntered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateLeft` date DEFAULT NULL,
  PRIMARY KEY (`CaritasCenters_ControlNo`,`Members_ControlNo`,`DateEntered`),
  KEY `fk_CaritasCenters_has_Members_Members1_idx` (`Members_ControlNo`),
  KEY `fk_CaritasCenters_has_Members_CaritasCenters1_idx` (`CaritasCenters_ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `caritascenters_has_members`
--

INSERT INTO `caritascenters_has_members` (`CaritasCenters_ControlNo`, `Members_ControlNo`, `DateEntered`, `DateLeft`) VALUES
(1, 5, '2013-01-01 05:43:59', NULL),
(1, 7, '2014-08-05 06:42:09', NULL),
(2, 1, '2013-01-01 05:28:25', NULL),
(2, 2, '2013-01-01 05:31:07', NULL),
(2, 3, '2013-01-01 05:34:26', NULL),
(2, 4, '2013-01-01 05:39:46', NULL),
(2, 6, '2013-01-01 06:07:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `caritaspersonnel`
--

CREATE TABLE IF NOT EXISTS `caritaspersonnel` (
  `ControlNo` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(45) NOT NULL,
  `MiddleName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `Rank` varchar(45) NOT NULL,
  `PersonnelID` varchar(45) NOT NULL,
  PRIMARY KEY (`ControlNo`),
  KEY `fk_CaritasPersonnel_PersonnelRank1_idx` (`Rank`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `caritaspersonnel`
--

INSERT INTO `caritaspersonnel` (`ControlNo`, `FirstName`, `MiddleName`, `LastName`, `Rank`, `PersonnelID`) VALUES
(1, 'Mark', 'Agustin', 'Lao', 'mispersonnel', 'admin'),
(2, 'Perla', 'Cajilo', 'Yap', 'branchmanager', 'perla'),
(3, 'Lyka', 'Chua', 'Dado', 'salveofficer', 'lyka'),
(4, 'Sheila', 'Chua', 'Uy', 'salveofficer', 'sheila'),
(5, 'Katherine', 'Galang', 'Ong', 'branchmanager', 'katherine'),
(6, 'Marion', 'Kate', 'Menese', 'salveofficer', 'marion'),
(7, 'Rebecca', 'Esmenda', 'Esmenda', 'salveofficer', 'rebecca'),
(8, 'Donna', 'San', 'Tiago', 'salveofficer', 'donna'),
(9, 'Mona', 'Tan', 'Tan', 'salveofficer', 'mona'),
(10, 'AJ', 'John', 'Lim', 'salveofficer', 'aj'),
(11, 'Candes', 'Bernardo', 'Fernado', 'salveofficer', 'candes'),
(12, 'Earl', 'Centen', 'Centino', 'branchmanager', 'earl');

-- --------------------------------------------------------

--
-- Table structure for table `centeraddress`
--

CREATE TABLE IF NOT EXISTS `centeraddress` (
  `ControlNo` int(11) NOT NULL,
  `CenterAddress` varchar(50) NOT NULL,
  PRIMARY KEY (`ControlNo`),
  KEY `fk_CenterAddress_CaritasCenters1_idx` (`ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `centeraddress`
--

INSERT INTO `centeraddress` (`ControlNo`, `CenterAddress`) VALUES
(1, '321 Tayuman St.'),
(2, '321 Tayuman St.'),
(3, '321 Tayuman St.'),
(4, '321 Tayuman St.'),
(5, '321 Tayuman St.');

-- --------------------------------------------------------

--
-- Table structure for table `centercontact`
--

CREATE TABLE IF NOT EXISTS `centercontact` (
  `ControlNo` int(11) NOT NULL,
  `ContactNo` varchar(11) NOT NULL,
  PRIMARY KEY (`ControlNo`,`ContactNo`),
  KEY `fk_CenterContact_CaritasCenters1_idx` (`ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `centercontact`
--

INSERT INTO `centercontact` (`ControlNo`, `ContactNo`) VALUES
(1, '2526161'),
(2, '2526161'),
(3, '2526161'),
(4, '2526161'),
(5, '2526161');

-- --------------------------------------------------------

--
-- Table structure for table `civilstatusref`
--

CREATE TABLE IF NOT EXISTS `civilstatusref` (
  `CivilStatus` varchar(45) NOT NULL,
  PRIMARY KEY (`CivilStatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `civilstatusref`
--

INSERT INTO `civilstatusref` (`CivilStatus`) VALUES
('Married'),
('Single');

-- --------------------------------------------------------

--
-- Table structure for table `dailyreports`
--

CREATE TABLE IF NOT EXISTS `dailyreports` (
  `ReportNo` int(11) NOT NULL,
  `NoofBorrowers` int(11) NOT NULL,
  `TotalDeposits` int(11) NOT NULL,
  `TotalWithdrawals` int(11) NOT NULL,
  `TotalLoanCollection` varchar(45) NOT NULL,
  `CaritasBranch_ControlNo` int(11) NOT NULL,
  PRIMARY KEY (`ReportNo`),
  KEY `fk_DailyReports_CaritasBranch1_idx` (`CaritasBranch_ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dayoftheweek`
--

CREATE TABLE IF NOT EXISTS `dayoftheweek` (
  `Day` varchar(45) NOT NULL,
  PRIMARY KEY (`Day`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dayoftheweek`
--

INSERT INTO `dayoftheweek` (`Day`) VALUES
('Friday'),
('Monday'),
('Thursday'),
('Tuesday'),
('Wednesday');

-- --------------------------------------------------------

--
-- Table structure for table `degree`
--

CREATE TABLE IF NOT EXISTS `degree` (
  `Degree` varchar(20) NOT NULL,
  PRIMARY KEY (`Degree`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `educationalattainmentref`
--

CREATE TABLE IF NOT EXISTS `educationalattainmentref` (
  `EducationalAttainment` varchar(45) NOT NULL,
  PRIMARY KEY (`EducationalAttainment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `educationalattainmentref`
--

INSERT INTO `educationalattainmentref` (`EducationalAttainment`) VALUES
('College'),
('Elementary'),
('High School');

-- --------------------------------------------------------

--
-- Table structure for table `establishmentstatus`
--

CREATE TABLE IF NOT EXISTS `establishmentstatus` (
  `Status` varchar(45) NOT NULL,
  PRIMARY KEY (`Status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `familyexpensetype`
--

CREATE TABLE IF NOT EXISTS `familyexpensetype` (
  `ExpenseType` varchar(30) NOT NULL,
  PRIMARY KEY (`ExpenseType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `familyexpensetype`
--

INSERT INTO `familyexpensetype` (`ExpenseType`) VALUES
('Communications'),
('Electricity'),
('Food'),
('Fuel'),
('Groceries'),
('Medical Expenses'),
('Rent'),
('School Allowance'),
('Transportation'),
('Tuition/School Supplies'),
('Water');

-- --------------------------------------------------------

--
-- Table structure for table `genderref`
--

CREATE TABLE IF NOT EXISTS `genderref` (
  `GenderID` varchar(6) NOT NULL,
  PRIMARY KEY (`GenderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `genderref`
--

INSERT INTO `genderref` (`GenderID`) VALUES
('Female'),
('Male');

-- --------------------------------------------------------

--
-- Table structure for table `householdname`
--

CREATE TABLE IF NOT EXISTS `householdname` (
  `HouseholdNo` int(11) NOT NULL,
  `FirstName` varchar(45) NOT NULL,
  `MiddleName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  PRIMARY KEY (`HouseholdNo`),
  KEY `fk_HouseholdName_MembersHousehold1_idx` (`HouseholdNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `householdname`
--

INSERT INTO `householdname` (`HouseholdNo`, `FirstName`, `MiddleName`, `LastName`) VALUES
(1, 'Angelu', 'Tiu', 'Yap'),
(2, 'Juana', 'Cajilo', 'Chua'),
(3, 'Nikki', 'Pit', 'Pitargue'),
(4, 'Ingrid', 'Pit', 'Pitargue'),
(5, 'Angeli', 'Yu', 'You'),
(6, 'Joshua', 'Cajilo', 'Ngo'),
(7, 'George ', 'Hanna', 'Bin');

-- --------------------------------------------------------

--
-- Table structure for table `householdoccupation`
--

CREATE TABLE IF NOT EXISTS `householdoccupation` (
  `HouseholdNo` int(11) NOT NULL,
  `Occupation` varchar(30) NOT NULL,
  PRIMARY KEY (`HouseholdNo`),
  KEY `fk_HouseholdOccupation_MembersHousehold1_idx` (`HouseholdNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `householdoccupation`
--

INSERT INTO `householdoccupation` (`HouseholdNo`, `Occupation`) VALUES
(1, 'Student'),
(2, 'Vendor'),
(3, 'Employee'),
(4, 'Manager'),
(5, 'Manager'),
(6, 'Businessman'),
(7, 'Vendor');

-- --------------------------------------------------------

--
-- Table structure for table `householdsignature`
--

CREATE TABLE IF NOT EXISTS `householdsignature` (
  `HouseholdNo` int(11) NOT NULL,
  `Signature` longblob NOT NULL,
  PRIMARY KEY (`HouseholdNo`),
  KEY `fk_HouseholdSigniture_MembersHousehold1_idx` (`HouseholdNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `incometype`
--

CREATE TABLE IF NOT EXISTS `incometype` (
  `IncomeType` varchar(20) NOT NULL,
  PRIMARY KEY (`IncomeType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `incometype`
--

INSERT INTO `incometype` (`IncomeType`) VALUES
('Children'),
('Other Business'),
('Others'),
('Spouse');

-- --------------------------------------------------------

--
-- Table structure for table `loanapplication`
--

CREATE TABLE IF NOT EXISTS `loanapplication` (
  `ControlNo` int(11) NOT NULL AUTO_INCREMENT,
  `ApplicationNumber` int(11) NOT NULL,
  `AmountRequested` int(11) NOT NULL,
  `Interest` int(11) NOT NULL,
  `CapitalShare` int(3) NOT NULL,
  `DateApplied` date NOT NULL,
  `DayoftheWeek` varchar(45) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `LoanType` varchar(45) NOT NULL,
  `Comments` varchar(100) DEFAULT NULL,
  `DateReleased` date DEFAULT NULL,
  PRIMARY KEY (`ControlNo`),
  KEY `fk_LoanApplication_DayoftheWeek1_idx` (`DayoftheWeek`),
  KEY `fk_LoanApplication_LoanStatus1_idx` (`Status`),
  KEY `fk_LoanApplication_LoanType1_idx` (`LoanType`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `loanapplication`
--

INSERT INTO `loanapplication` (`ControlNo`, `ApplicationNumber`, `AmountRequested`, `Interest`, `CapitalShare`, `DateApplied`, `DayoftheWeek`, `Status`, `LoanType`, `Comments`, `DateReleased`) VALUES
(1, 1, 4000, 600, 100, '2014-08-01', 'Tuesday', 'Current', '23-Weeks', NULL, '2014-08-05'),
(2, 2, 4000, 600, 100, '2014-08-05', 'Tuesday', 'Current', '23-Weeks', NULL, '2014-08-05'),
(3, 3, 3500, 700, 100, '2014-08-05', 'Tuesday', 'Active', '40-Weeks', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loanapplication_has_businessexpensetype`
--

CREATE TABLE IF NOT EXISTS `loanapplication_has_businessexpensetype` (
  `loanapplication_ControlNo` int(11) NOT NULL,
  `BusinessExpenseType_ExpenseType` varchar(30) NOT NULL,
  `Amount` float DEFAULT NULL,
  PRIMARY KEY (`loanapplication_ControlNo`,`BusinessExpenseType_ExpenseType`),
  KEY `fk_loanapplication_has_BusinessExpenseType_BusinessExpenseT_idx` (`BusinessExpenseType_ExpenseType`),
  KEY `fk_loanapplication_has_BusinessExpenseType_loanapplication1_idx` (`loanapplication_ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `loanapplication_has_familyexpensetype`
--

CREATE TABLE IF NOT EXISTS `loanapplication_has_familyexpensetype` (
  `LoanApplication_ControlNo` int(11) NOT NULL,
  `FamilyExpenseType_ExpenseType` varchar(30) NOT NULL,
  `Amount` float DEFAULT NULL,
  PRIMARY KEY (`LoanApplication_ControlNo`,`FamilyExpenseType_ExpenseType`),
  KEY `fk_LoanApplication_has_ExpenseType_ExpenseType1_idx` (`FamilyExpenseType_ExpenseType`),
  KEY `fk_LoanApplication_has_ExpenseType_LoanApplication1_idx` (`LoanApplication_ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loanapplication_has_familyexpensetype`
--

INSERT INTO `loanapplication_has_familyexpensetype` (`LoanApplication_ControlNo`, `FamilyExpenseType_ExpenseType`, `Amount`) VALUES
(1, 'Communications', 500),
(1, 'Electricity', 500),
(1, 'Food', 3000),
(1, 'Groceries', 500),
(1, 'Rent', 1500),
(2, 'Communications', 1000),
(2, 'Electricity', 1000),
(2, 'Food', 1000),
(3, 'Communications', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `loanapplication_has_incometype`
--

CREATE TABLE IF NOT EXISTS `loanapplication_has_incometype` (
  `LoanApplication_ControlNo` int(11) NOT NULL,
  `IncomeType_IncomeType` varchar(30) NOT NULL,
  `Amount` float DEFAULT NULL,
  PRIMARY KEY (`LoanApplication_ControlNo`,`IncomeType_IncomeType`),
  KEY `fk_LoanApplication_has_IncomeType_IncomeType1_idx` (`IncomeType_IncomeType`),
  KEY `fk_LoanApplication_has_IncomeType_LoanApplication1_idx` (`LoanApplication_ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loanapplication_has_incometype`
--

INSERT INTO `loanapplication_has_incometype` (`LoanApplication_ControlNo`, `IncomeType_IncomeType`, `Amount`) VALUES
(1, 'Other Business', 10000),
(1, 'Others', 10),
(1, 'Spouse', 10000),
(2, 'Spouse', 20000),
(3, 'Other Business', 10000),
(3, 'Spouse', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `loanapplication_has_members`
--

CREATE TABLE IF NOT EXISTS `loanapplication_has_members` (
  `LoanApplication_ControlNo` int(11) NOT NULL,
  `Members_ControlNo` int(11) NOT NULL,
  `CaritasBranch_ControlNo` int(11) NOT NULL,
  PRIMARY KEY (`LoanApplication_ControlNo`,`Members_ControlNo`,`CaritasBranch_ControlNo`),
  KEY `fk_LoanApplication_has_Members_Members2_idx` (`Members_ControlNo`),
  KEY `fk_LoanApplication_has_Members_LoanApplication2_idx` (`LoanApplication_ControlNo`),
  KEY `fk_LoanApplication_has_Members_CaritasBranch1_idx` (`CaritasBranch_ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loanapplication_has_members`
--

INSERT INTO `loanapplication_has_members` (`LoanApplication_ControlNo`, `Members_ControlNo`, `CaritasBranch_ControlNo`) VALUES
(1, 1, 2),
(2, 2, 2),
(3, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `loanbusiness`
--

CREATE TABLE IF NOT EXISTS `loanbusiness` (
  `ControlNo` int(11) NOT NULL AUTO_INCREMENT,
  `BusinessName` varchar(45) DEFAULT NULL,
  `BusinessType` varchar(45) NOT NULL,
  `DateEstablished` date NOT NULL,
  PRIMARY KEY (`ControlNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `loanbusiness`
--

INSERT INTO `loanbusiness` (`ControlNo`, `BusinessName`, `BusinessType`, `DateEstablished`) VALUES
(1, 'Sari-sari Store', 'Sari Store', '2008-03-17'),
(2, 'Glocery', 'Store', '2006-03-03'),
(3, 'Yami', 'Restaurant', '2007-05-19');

-- --------------------------------------------------------

--
-- Table structure for table `loanbusiness_has_loanapplication`
--

CREATE TABLE IF NOT EXISTS `loanbusiness_has_loanapplication` (
  `LoanBusiness_ControlNo` int(11) NOT NULL,
  `LoanApplication_ControlNo` int(11) NOT NULL,
  `Material` varchar(50) NOT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `UnitPrice` int(11) DEFAULT NULL,
  PRIMARY KEY (`LoanBusiness_ControlNo`,`LoanApplication_ControlNo`,`Material`),
  KEY `fk_LoanBusiness_has_LoanApplication_LoanApplication1_idx` (`LoanApplication_ControlNo`),
  KEY `fk_LoanBusiness_has_LoanApplication_LoanBusiness1_idx` (`LoanBusiness_ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loanbusiness_has_loanapplication`
--

INSERT INTO `loanbusiness_has_loanapplication` (`LoanBusiness_ControlNo`, `LoanApplication_ControlNo`, `Material`, `Quantity`, `UnitPrice`) VALUES
(1, 1, 'Laptop', 1, 4000),
(2, 2, 'Laptop', 1, 4000),
(3, 3, 'Equiptment', 1, 3500);

-- --------------------------------------------------------

--
-- Table structure for table `loanstatus`
--

CREATE TABLE IF NOT EXISTS `loanstatus` (
  `Status` varchar(20) NOT NULL,
  PRIMARY KEY (`Status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loanstatus`
--

INSERT INTO `loanstatus` (`Status`) VALUES
('Active'),
('Current'),
('Full Payment'),
('Past Due'),
('Pending'),
('Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `loantype`
--

CREATE TABLE IF NOT EXISTS `loantype` (
  `LoanType` varchar(45) NOT NULL,
  PRIMARY KEY (`LoanType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loantype`
--

INSERT INTO `loantype` (`LoanType`) VALUES
('23-Weeks'),
('40-Weeks');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `ControlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Approved` enum('YES','NO','P') DEFAULT 'P',
  `MemberID` varchar(50) DEFAULT NULL,
  `Birthday` date NOT NULL,
  `BirthPlace` varchar(20) NOT NULL,
  `GenderID` varchar(6) NOT NULL,
  `Religion` varchar(45) NOT NULL,
  `EducationalAttainment` varchar(45) NOT NULL,
  `CivilStatus` varchar(45) NOT NULL,
  `LoanExpense` double NOT NULL DEFAULT '0',
  `Savings` double NOT NULL DEFAULT '0',
  `CapitalShare` double NOT NULL DEFAULT '0',
  `pastdue` double NOT NULL DEFAULT '0',
  `Comment` text,
  PRIMARY KEY (`ControlNo`),
  KEY `fk_Members_GenderRef1_idx` (`GenderID`),
  KEY `fk_Members_Religion1_idx` (`Religion`),
  KEY `fk_Members_EducationalAttainmentRef1_idx` (`EducationalAttainment`),
  KEY `fk_Members_CivilStatusRef1_idx` (`CivilStatus`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`ControlNo`, `Approved`, `MemberID`, `Birthday`, `BirthPlace`, `GenderID`, `Religion`, `EducationalAttainment`, `CivilStatus`, `LoanExpense`, `Savings`, `CapitalShare`, `pastdue`, `Comment`) VALUES
(1, 'YES', 'CS-01-2013-1R', '1963-01-18', 'Palawan', 'Female', 'Roman Catholic', 'College', 'Married', 4200, 100, 0, 400, NULL),
(2, 'YES', 'CS-01-2013-2R', '1994-02-02', 'Palawan', 'Female', 'Roman Catholic', 'College', 'Single', 4200, 100, 0, 400, NULL),
(3, 'YES', 'CS-01-2013-3R', '1968-03-09', 'Manila', 'Female', 'Roman Catholic', 'High School', 'Single', 0, 300, 0, 0, NULL),
(4, 'YES', 'CS-01-2013-4R', '1947-03-04', 'Palawan', 'Female', 'Roman Catholic', 'College', 'Married', 0, 650, 0, 0, NULL),
(5, 'YES', 'CS-01-2013-5R', '1964-02-19', 'Palawan', 'Female', 'Roman Catholic', 'High School', 'Single', 0, 0, 0, 0, NULL),
(6, 'YES', 'CS-01-2013-6R', '1948-02-03', 'China', 'Female', 'Roman Catholic', 'College', 'Married', 0, 300, 0, 0, NULL),
(7, 'YES', 'CS-08-2014-7R', '1950-02-03', 'Yami', 'Female', 'Roman Catholic', 'College', 'Married', 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `membersaddress`
--

CREATE TABLE IF NOT EXISTS `membersaddress` (
  `ControlNo` int(11) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `AddressDate` int(4) DEFAULT NULL,
  `AddressType` varchar(45) NOT NULL,
  PRIMARY KEY (`ControlNo`,`Address`),
  KEY `fk_MembersAddress_Members1_idx` (`ControlNo`),
  KEY `fk_MembersAddress_AddressTypeRef1_idx` (`AddressType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `membersaddress`
--

INSERT INTO `membersaddress` (`ControlNo`, `Address`, `AddressDate`, `AddressType`) VALUES
(1, '111 Taft Avenue ', 5, 'Home Address'),
(2, '111 Taft Avenue ', 5, 'Home Address'),
(3, '111 Taft Avenue ', 5, 'Home Address'),
(4, '111 Taft Avenue ', 5, 'Home Address'),
(5, '111 Taft Avenue ', 5, 'Home Address'),
(6, '1234 Balintawak St. Tondo Manila', 12, 'Home Address'),
(7, 'Manila City', 4, 'Home Address');

-- --------------------------------------------------------

--
-- Table structure for table `memberscontact`
--

CREATE TABLE IF NOT EXISTS `memberscontact` (
  `ControlNo` int(11) NOT NULL,
  `ContactNo` varchar(11) NOT NULL,
  PRIMARY KEY (`ControlNo`,`ContactNo`),
  KEY `fk_MembersContact_Members1_idx` (`ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `memberscontact`
--

INSERT INTO `memberscontact` (`ControlNo`, `ContactNo`) VALUES
(1, '09228756558'),
(2, '09228756558'),
(3, '09228756558'),
(4, '09228756558'),
(5, '09228756558'),
(6, '2526161'),
(7, '2518282');

-- --------------------------------------------------------

--
-- Table structure for table `membershousehold`
--

CREATE TABLE IF NOT EXISTS `membershousehold` (
  `HouseholdNo` int(11) NOT NULL AUTO_INCREMENT,
  `Age` int(11) NOT NULL,
  `GenderID` varchar(6) NOT NULL,
  `CivilStatus` varchar(45) NOT NULL,
  PRIMARY KEY (`HouseholdNo`),
  KEY `fk_MembersHousehold_GenderRef1_idx` (`GenderID`),
  KEY `fk_MembersHousehold_CivilStatusRef1_idx` (`CivilStatus`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `membershousehold`
--

INSERT INTO `membershousehold` (`HouseholdNo`, `Age`, `GenderID`, `CivilStatus`) VALUES
(1, 21, 'female', 'Single'),
(2, 44, 'female', 'Married'),
(3, 33, 'female', 'Married'),
(4, 37, 'female', 'Single'),
(5, 32, 'female', 'Married'),
(6, 44, 'female', 'Married'),
(7, 43, 'male', 'Married');

-- --------------------------------------------------------

--
-- Table structure for table `membersmembershipstatus`
--

CREATE TABLE IF NOT EXISTS `membersmembershipstatus` (
  `Status` varchar(45) NOT NULL,
  PRIMARY KEY (`Status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `membersmembershipstatus`
--

INSERT INTO `membersmembershipstatus` (`Status`) VALUES
('Active'),
('Active Saver'),
('Borrower'),
('dormant saver'),
('Past Due'),
('Terminated'),
('Terminated Voluntarily');

-- --------------------------------------------------------

--
-- Table structure for table `membersmfi`
--

CREATE TABLE IF NOT EXISTS `membersmfi` (
  `ControlNo` int(11) NOT NULL,
  `MFI` longtext NOT NULL,
  PRIMARY KEY (`ControlNo`),
  KEY `fk_MembersMFI_Members1_idx` (`ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `membersmfi`
--

INSERT INTO `membersmfi` (`ControlNo`, `MFI`) VALUES
(1, 'CASA'),
(2, 'CASA'),
(3, 'CASA'),
(4, 'CASA'),
(5, 'CASA'),
(6, 'Chevron'),
(7, 'casa');

-- --------------------------------------------------------

--
-- Table structure for table `membersname`
--

CREATE TABLE IF NOT EXISTS `membersname` (
  `ControlNo` int(11) NOT NULL,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `MiddleName` varchar(45) NOT NULL,
  PRIMARY KEY (`ControlNo`),
  KEY `fk_MembersName_Members1_idx` (`ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `membersname`
--

INSERT INTO `membersname` (`ControlNo`, `FirstName`, `LastName`, `MiddleName`) VALUES
(1, 'Angela', 'Yap', 'Tiu'),
(2, 'Vergilia', 'Uy', 'Ngo'),
(3, 'Alaiza', 'Tiu', 'Cajilo'),
(4, 'Shane', 'Harvard', 'Harold'),
(5, 'Ingrid', 'Insigne', 'Signe'),
(6, 'Lyla', 'Lee', 'K'),
(7, 'Gaby', 'Riano', 'Riano');

-- --------------------------------------------------------

--
-- Table structure for table `membersorganization`
--

CREATE TABLE IF NOT EXISTS `membersorganization` (
  `ControlNo` int(11) NOT NULL,
  `Organization` varchar(40) NOT NULL,
  `Position` varchar(45) NOT NULL,
  PRIMARY KEY (`ControlNo`,`Organization`),
  KEY `fk_MembersOrganization_Members1_idx` (`ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `membersorganization`
--

INSERT INTO `membersorganization` (`ControlNo`, `Organization`, `Position`) VALUES
(1, 'Green and White', 'Member'),
(2, 'Green and White', 'Member'),
(3, 'Blue and White', 'Member'),
(4, 'Hapzan', 'Member'),
(5, 'Green and White', 'Member'),
(6, 'Microsoft', 'Member'),
(7, 'org1', 'manager');

-- --------------------------------------------------------

--
-- Table structure for table `memberspicture`
--

CREATE TABLE IF NOT EXISTS `memberspicture` (
  `ControlNo` int(11) NOT NULL,
  `Picture` varchar(1000) NOT NULL,
  PRIMARY KEY (`ControlNo`),
  KEY `fk_MembersPicture_Members1_idx` (`ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `memberspicture`
--

INSERT INTO `memberspicture` (`ControlNo`, `Picture`) VALUES
(1, 'ids/images.jpg'),
(2, 'ids/images.jpg'),
(3, 'ids/npa_vorne.jpg'),
(4, 'ids/download.jpg'),
(5, 'ids/npa_vorne.jpg'),
(6, 'ids/npa_vorne.jpg'),
(7, 'ids/BgqM3t9IYAAzsaX.png');

-- --------------------------------------------------------

--
-- Table structure for table `memberssignature`
--

CREATE TABLE IF NOT EXISTS `memberssignature` (
  `ControlNo` int(11) NOT NULL,
  `Signature` varchar(1000) NOT NULL,
  PRIMARY KEY (`ControlNo`),
  KEY `fk_MembersSigniture_Members1_idx` (`ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `memberssignature`
--

INSERT INTO `memberssignature` (`ControlNo`, `Signature`) VALUES
(1, 'signatures/download (1).jpg'),
(2, 'signatures/download.jpg'),
(3, 'signatures/download.jpg'),
(4, 'signatures/npa_vorne.jpg'),
(5, 'signatures/download (1).jpg'),
(6, 'signatures/download (1).jpg'),
(7, 'signatures/Capture.PNG');

-- --------------------------------------------------------

--
-- Table structure for table `members_has_members`
--

CREATE TABLE IF NOT EXISTS `members_has_members` (
  `ControlNo` int(11) NOT NULL,
  `FamilyControlNo` int(11) NOT NULL,
  PRIMARY KEY (`ControlNo`,`FamilyControlNo`),
  KEY `fk_Members_has_Members_Members2_idx` (`FamilyControlNo`),
  KEY `fk_Members_has_Members_Members1_idx` (`ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `members_has_membershousehold`
--

CREATE TABLE IF NOT EXISTS `members_has_membershousehold` (
  `ControlNo` int(11) NOT NULL,
  `HouseholdNo` int(11) NOT NULL,
  `Relationship` varchar(45) NOT NULL,
  PRIMARY KEY (`ControlNo`,`HouseholdNo`),
  KEY `fk_Members_has_MembersHousehold_MembersHousehold1_idx` (`HouseholdNo`),
  KEY `fk_Members_has_MembersHousehold_Members1_idx` (`ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members_has_membershousehold`
--

INSERT INTO `members_has_membershousehold` (`ControlNo`, `HouseholdNo`, `Relationship`) VALUES
(1, 1, 'Child'),
(2, 2, 'Mother'),
(3, 3, 'In-Law'),
(4, 4, 'In-Law'),
(5, 5, 'Mother'),
(6, 6, 'In-Law'),
(7, 7, 'Father');

-- --------------------------------------------------------

--
-- Table structure for table `members_has_membersmembershipstatus`
--

CREATE TABLE IF NOT EXISTS `members_has_membersmembershipstatus` (
  `ControlNo` int(11) NOT NULL,
  `DateUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` varchar(45) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`ControlNo`,`DateUpdated`,`Status`),
  KEY `fk_Members_has_MembersMembershipStatus_Members1_idx` (`ControlNo`),
  KEY `fk_Members_has_MembersMembershipStatus_MembersMembershipSta_idx` (`Status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members_has_membersmembershipstatus`
--

INSERT INTO `members_has_membersmembershipstatus` (`ControlNo`, `DateUpdated`, `Status`) VALUES
(1, '2014-08-26 15:14:40', 'Borrower'),
(2, '2014-08-26 15:14:40', 'Borrower'),
(3, '2014-08-26 15:14:40', 'Active Saver'),
(4, '2014-08-26 15:14:40', 'Active Saver'),
(5, '2013-01-01 05:43:59', 'Active'),
(6, '2014-08-26 15:14:40', 'Active Saver'),
(7, '2014-08-05 06:42:09', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `members_has_membertype`
--

CREATE TABLE IF NOT EXISTS `members_has_membertype` (
  `ControlNo` int(11) NOT NULL,
  `Type` varchar(45) NOT NULL,
  `DateUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ControlNo`,`Type`,`DateUpdated`),
  KEY `fk_Members_has_MemberType_Members1_idx` (`ControlNo`),
  KEY `fk_Members_has_MemberType_MemberType1_idx` (`Type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members_has_membertype`
--

INSERT INTO `members_has_membertype` (`ControlNo`, `Type`, `DateUpdated`) VALUES
(1, 'Associate Member', '2013-01-01 05:28:24'),
(2, 'Associate Member', '2013-01-01 05:31:06'),
(3, 'Associate Member', '2013-01-01 05:34:26'),
(4, 'Associate Member', '2013-01-01 05:39:45'),
(5, 'Associate Member', '2013-01-01 05:43:59'),
(6, 'Associate Member', '2013-01-01 06:07:22'),
(7, 'Associate Member', '2014-08-05 06:42:09');

-- --------------------------------------------------------

--
-- Table structure for table `members_has_violations`
--

CREATE TABLE IF NOT EXISTS `members_has_violations` (
  `ControlNo` varchar(45) NOT NULL,
  `Date` date NOT NULL,
  `Comment` varchar(100) NOT NULL,
  `Members_ControlNo` int(11) NOT NULL,
  `Violations_ViolationID` int(11) NOT NULL,
  `CaritasPersonnel_ControlNo` int(11) NOT NULL,
  PRIMARY KEY (`ControlNo`),
  KEY `fk_Members_has_Violations_Violations1_idx` (`Violations_ViolationID`),
  KEY `fk_Members_has_Violations_Members1_idx` (`Members_ControlNo`),
  KEY `fk_Members_has_Violations_CaritasPersonnel1_idx` (`CaritasPersonnel_ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `membertype`
--

CREATE TABLE IF NOT EXISTS `membertype` (
  `Type` varchar(45) NOT NULL,
  PRIMARY KEY (`Type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `membertype`
--

INSERT INTO `membertype` (`Type`) VALUES
('Associate Member'),
('Regular Member');

-- --------------------------------------------------------

--
-- Table structure for table `member_comaker`
--

CREATE TABLE IF NOT EXISTS `member_comaker` (
  `LoanApplication_ControlNo` int(11) NOT NULL,
  `Members_ControlNo` int(11) NOT NULL,
  `Relationship` varchar(45) NOT NULL,
  PRIMARY KEY (`LoanApplication_ControlNo`,`Members_ControlNo`),
  KEY `fk_LoanApplication_has_Members_Members1_idx` (`Members_ControlNo`),
  KEY `fk_LoanApplication_has_Members_LoanApplication1_idx` (`LoanApplication_ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member_comaker`
--

INSERT INTO `member_comaker` (`LoanApplication_ControlNo`, `Members_ControlNo`, `Relationship`) VALUES
(1, 1, 'Relative'),
(2, 2, 'Friend'),
(3, 3, 'Friend');

-- --------------------------------------------------------

--
-- Table structure for table `nonmember_comaker`
--

CREATE TABLE IF NOT EXISTS `nonmember_comaker` (
  `LoanApplication_ControlNo` int(11) NOT NULL,
  `MembersHousehold_HouseholdNo` int(11) NOT NULL,
  PRIMARY KEY (`LoanApplication_ControlNo`,`MembersHousehold_HouseholdNo`),
  KEY `fk_LoanApplication_has_MembersHousehold_MembersHousehold1_idx` (`MembersHousehold_HouseholdNo`),
  KEY `fk_LoanApplication_has_MembersHousehold_LoanApplication1_idx` (`LoanApplication_ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nonmember_comaker`
--

INSERT INTO `nonmember_comaker` (`LoanApplication_ControlNo`, `MembersHousehold_HouseholdNo`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `passbook`
--

CREATE TABLE IF NOT EXISTS `passbook` (
  `ControlNo` int(11) NOT NULL AUTO_INCREMENT,
  `PassbookNo` int(11) NOT NULL,
  `DateIssued` date NOT NULL,
  `CaritasCenters_ControlNo` int(11) NOT NULL,
  PRIMARY KEY (`ControlNo`),
  KEY `fk_Passbook_CaritasCenters1_idx` (`CaritasCenters_ControlNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `passbook`
--

INSERT INTO `passbook` (`ControlNo`, `PassbookNo`, `DateIssued`, `CaritasCenters_ControlNo`) VALUES
(2, 2, '2014-08-06', 2);

-- --------------------------------------------------------

--
-- Table structure for table `personnelrank`
--

CREATE TABLE IF NOT EXISTS `personnelrank` (
  `Rank` varchar(45) NOT NULL,
  PRIMARY KEY (`Rank`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `personnelrank`
--

INSERT INTO `personnelrank` (`Rank`) VALUES
('branchmanager'),
('mispersonnel'),
('salveofficer');

-- --------------------------------------------------------

--
-- Table structure for table `religion`
--

CREATE TABLE IF NOT EXISTS `religion` (
  `Religion` varchar(45) NOT NULL,
  PRIMARY KEY (`Religion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `religion`
--

INSERT INTO `religion` (`Religion`) VALUES
('Christian'),
('Roman Catholic');

-- --------------------------------------------------------

--
-- Table structure for table `sourceofincome`
--

CREATE TABLE IF NOT EXISTS `sourceofincome` (
  `ControlNo` int(11) NOT NULL,
  `BusinessType` varchar(45) NOT NULL,
  `CompanyName` varchar(45) NOT NULL,
  `CompanyContact` varchar(45) NOT NULL,
  `YearEntered` year(4) NOT NULL,
  PRIMARY KEY (`ControlNo`),
  KEY `fk_1_Members1_idx` (`ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sourceofincome`
--

INSERT INTO `sourceofincome` (`ControlNo`, `BusinessType`, `CompanyName`, `CompanyContact`, `YearEntered`) VALUES
(1, 'Buy and Sell', 'Ukay Ukay Store', '09228756558', 2013),
(2, 'Buy and Sell', 'Ukay Ukay Store', '09228756558', 2013),
(3, 'Buy and Sell', 'Ukay Ukay Store', '09228756558', 2013),
(4, 'Buy and Sell', 'Ukay Ukay Store', '09228756558', 2013),
(5, 'Service', 'Salon', '09228756558', 2013),
(6, 'Grocery', 'National Book Store', '09332321232', 2013),
(7, 'Market', 'Market Market', '09224234221', 2002);

-- --------------------------------------------------------

--
-- Table structure for table `termination`
--

CREATE TABLE IF NOT EXISTS `termination` (
  `ControlNo` int(11) NOT NULL,
  `Comment` varchar(100) NOT NULL,
  `AmountGiven` int(11) NOT NULL,
  `SharesReturned` int(11) NOT NULL,
  `CaritasBranch_ControlNo` int(11) NOT NULL,
  `Members_ControlNo` int(11) NOT NULL,
  `CaritasPersonnel_ControlNo` int(11) NOT NULL,
  PRIMARY KEY (`ControlNo`),
  KEY `fk_Termination_CaritasBranch1_idx` (`CaritasBranch_ControlNo`),
  KEY `fk_Termination_Members1_idx` (`Members_ControlNo`),
  KEY `fk_Termination_CaritasPersonnel1_idx` (`CaritasPersonnel_ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `ControlNo` int(11) NOT NULL AUTO_INCREMENT,
  `LoanAppControlNo` int(11) DEFAULT NULL,
  `Amount` int(11) NOT NULL,
  `DateTime` date NOT NULL,
  `Members_ControlNo` int(11) NOT NULL,
  `Passbook_ControlNo` int(11) DEFAULT NULL,
  `CaritasPersonnel_ControlNo` int(11) NOT NULL,
  `TransactionType` varchar(45) NOT NULL,
  PRIMARY KEY (`ControlNo`),
  KEY `fk_Passbook_Members1_idx` (`Members_ControlNo`),
  KEY `fk_Transaction_Passbook1_idx` (`Passbook_ControlNo`),
  KEY `fk_Transaction_TransactionType1_idx` (`TransactionType`),
  KEY `fk_SavingsTransaction_CaritasPersonnel1_idx` (`CaritasPersonnel_ControlNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`ControlNo`, `LoanAppControlNo`, `Amount`, `DateTime`, `Members_ControlNo`, `Passbook_ControlNo`, `CaritasPersonnel_ControlNo`, `TransactionType`) VALUES
(2, 1, 200, '2014-08-05', 1, 2, 3, 'Loan '),
(3, 1, 50, '2014-08-05', 1, 2, 3, 'Savings'),
(4, 2, 200, '2014-08-05', 2, 2, 3, 'Loan '),
(5, 2, 50, '2014-08-05', 2, 2, 3, 'Savings'),
(6, 0, 50, '2014-08-05', 4, 2, 3, 'Savings'),
(7, 0, 50, '2014-08-05', 3, 2, 3, 'Savings'),
(8, 0, 50, '2014-08-05', 6, 2, 3, 'Savings'),
(9, 1, 200, '2014-08-12', 1, 2, 3, 'Loan '),
(10, 1, 50, '2014-08-12', 1, 2, 3, 'Savings'),
(11, 2, 200, '2014-08-12', 2, 2, 3, 'Past Due'),
(12, 2, 0, '2014-08-12', 2, 2, 3, 'Savings'),
(13, 0, 50, '2014-08-12', 4, 2, 3, 'Savings'),
(14, 0, 50, '2014-08-12', 3, 2, 3, 'Savings'),
(15, 0, 50, '2014-08-12', 6, 2, 3, 'Savings'),
(16, 1, 200, '2014-08-19', 1, 2, 3, 'Past Due'),
(17, 1, 0, '2014-08-19', 1, 2, 3, 'Savings'),
(18, 2, 200, '2014-08-19', 2, 2, 3, 'Loan '),
(19, 2, 50, '2014-08-19', 2, 2, 3, 'Savings'),
(20, 0, 50, '2014-08-19', 4, 2, 3, 'Savings'),
(21, 0, 50, '2014-08-19', 3, 2, 3, 'Savings'),
(22, 0, 50, '2014-08-19', 6, 2, 3, 'Savings'),
(23, 1, 200, '2014-08-26', 1, 2, 3, 'Past Due'),
(24, 1, 0, '2014-08-26', 1, 2, 3, 'Savings'),
(25, 2, 200, '2014-08-26', 2, 2, 3, 'Past Due'),
(26, 2, 0, '2014-08-26', 2, 2, 3, 'Savings'),
(27, 0, 500, '2014-08-26', 4, 2, 3, 'Savings'),
(28, 0, 150, '2014-08-26', 3, 2, 3, 'Savings'),
(29, 0, 150, '2014-08-26', 6, 2, 3, 'Savings');

-- --------------------------------------------------------

--
-- Table structure for table `transactiontype`
--

CREATE TABLE IF NOT EXISTS `transactiontype` (
  `TransactionType` varchar(45) NOT NULL,
  PRIMARY KEY (`TransactionType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transactiontype`
--

INSERT INTO `transactiontype` (`TransactionType`) VALUES
('Capital Share'),
('Loan '),
('Past Due'),
('Savings'),
('Withdrawal');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ControlNo` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `IsActive` int(11) NOT NULL,
  PRIMARY KEY (`ControlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ControlNo`, `Username`, `Password`, `IsActive`) VALUES
(1, 'admin', 'admin', 1),
(2, 'perla', 'perla', 1),
(3, 'lyka', 'lyka', 1),
(4, 'sheila', 'sheila', 1),
(5, 'katherine', 'katherine', 1),
(6, 'marion', 'marion', 1),
(7, 'rebecca', 'rebecca', 1),
(8, 'donna', 'donna', 1),
(9, 'mona', 'mona', 1),
(10, 'aj', 'aj', 1),
(11, 'candes', 'candes', 1),
(12, 'earl', 'earl', 1);

-- --------------------------------------------------------

--
-- Table structure for table `violations`
--

CREATE TABLE IF NOT EXISTS `violations` (
  `ViolationID` int(11) NOT NULL,
  `Violation` varchar(45) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Degree` varchar(20) NOT NULL,
  PRIMARY KEY (`ViolationID`),
  KEY `fk_Violations_Degree1_idx` (`Degree`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branchaddress`
--
ALTER TABLE `branchaddress`
  ADD CONSTRAINT `fk_BranchAddress_CaritasBranch1` FOREIGN KEY (`ControlNo`) REFERENCES `caritasbranch` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `branchcontact`
--
ALTER TABLE `branchcontact`
  ADD CONSTRAINT `fk_BranchContact_CaritasBranch1` FOREIGN KEY (`ControlNo`) REFERENCES `caritasbranch` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `businessaddress`
--
ALTER TABLE `businessaddress`
  ADD CONSTRAINT `fk_BusinessAddress_LoanBusiness1` FOREIGN KEY (`ControlNo`) REFERENCES `loanbusiness` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `businesscontact`
--
ALTER TABLE `businesscontact`
  ADD CONSTRAINT `fk_BusinessContact_LoanBusiness1` FOREIGN KEY (`ControlNo`) REFERENCES `loanbusiness` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `caritasbranch_has_caritascenters`
--
ALTER TABLE `caritasbranch_has_caritascenters`
  ADD CONSTRAINT `fk_CaritasBranch_has_CaritasCenters_CaritasBranch1` FOREIGN KEY (`CaritasBranch_ControlNo`) REFERENCES `caritasbranch` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_CaritasBranch_has_CaritasCenters_CaritasCenters1` FOREIGN KEY (`CaritasCenters_ControlNo`) REFERENCES `caritascenters` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `caritasbranch_has_caritaspersonnel`
--
ALTER TABLE `caritasbranch_has_caritaspersonnel`
  ADD CONSTRAINT `fk_CaritasBranch_has_CaritasPersonnel_CaritasBranch1` FOREIGN KEY (`CaritasBranch_ControlNo`) REFERENCES `caritasbranch` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_CaritasBranch_has_CaritasPersonnel_CaritasPersonnel1` FOREIGN KEY (`CaritasPersonnel_ControlNo`) REFERENCES `caritaspersonnel` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `caritasbranch_has_establishmentstatus`
--
ALTER TABLE `caritasbranch_has_establishmentstatus`
  ADD CONSTRAINT `fk_CaritasBranch_has_EstablishmentStatus_CaritasBranch1` FOREIGN KEY (`ControlNo`) REFERENCES `caritasbranch` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_CaritasBranch_has_EstablishmentStatus_EstablishmentStatus1` FOREIGN KEY (`EstablishmentStatus`) REFERENCES `establishmentstatus` (`Status`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `caritascenters_has_coordinator`
--
ALTER TABLE `caritascenters_has_coordinator`
  ADD CONSTRAINT `fk_CaritasCenters_has_Members1_CaritasCenters1` FOREIGN KEY (`CaritasCenters_ControlNo`) REFERENCES `caritascenters` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_CaritasCenters_has_Members1_Members1` FOREIGN KEY (`Members_ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `caritascenters_has_members`
--
ALTER TABLE `caritascenters_has_members`
  ADD CONSTRAINT `fk_CaritasCenters_has_Members_CaritasCenters1` FOREIGN KEY (`CaritasCenters_ControlNo`) REFERENCES `caritascenters` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_CaritasCenters_has_Members_Members1` FOREIGN KEY (`Members_ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `caritaspersonnel`
--
ALTER TABLE `caritaspersonnel`
  ADD CONSTRAINT `fk_CaritasPersonnel_PersonnelRank1` FOREIGN KEY (`Rank`) REFERENCES `personnelrank` (`Rank`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `centeraddress`
--
ALTER TABLE `centeraddress`
  ADD CONSTRAINT `fk_CenterAddress_CaritasCenters1` FOREIGN KEY (`ControlNo`) REFERENCES `caritascenters` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `centercontact`
--
ALTER TABLE `centercontact`
  ADD CONSTRAINT `fk_CenterContact_CaritasCenters1` FOREIGN KEY (`ControlNo`) REFERENCES `caritascenters` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `dailyreports`
--
ALTER TABLE `dailyreports`
  ADD CONSTRAINT `fk_DailyReports_CaritasBranch1` FOREIGN KEY (`CaritasBranch_ControlNo`) REFERENCES `caritasbranch` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `householdname`
--
ALTER TABLE `householdname`
  ADD CONSTRAINT `fk_HouseholdName_MembersHousehold1` FOREIGN KEY (`HouseholdNo`) REFERENCES `membershousehold` (`HouseholdNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `householdoccupation`
--
ALTER TABLE `householdoccupation`
  ADD CONSTRAINT `fk_HouseholdOccupation_MembersHousehold1` FOREIGN KEY (`HouseholdNo`) REFERENCES `membershousehold` (`HouseholdNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `householdsignature`
--
ALTER TABLE `householdsignature`
  ADD CONSTRAINT `fk_HouseholdSigniture_MembersHousehold1` FOREIGN KEY (`HouseholdNo`) REFERENCES `membershousehold` (`HouseholdNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `loanapplication`
--
ALTER TABLE `loanapplication`
  ADD CONSTRAINT `fk_LoanApplication_DayoftheWeek1` FOREIGN KEY (`DayoftheWeek`) REFERENCES `dayoftheweek` (`Day`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LoanApplication_LoanStatus1` FOREIGN KEY (`Status`) REFERENCES `loanstatus` (`Status`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LoanApplication_LoanType1` FOREIGN KEY (`LoanType`) REFERENCES `loantype` (`LoanType`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `loanapplication_has_businessexpensetype`
--
ALTER TABLE `loanapplication_has_businessexpensetype`
  ADD CONSTRAINT `fk_loanapplication_has_BusinessExpenseType_BusinessExpenseType1` FOREIGN KEY (`BusinessExpenseType_ExpenseType`) REFERENCES `businessexpensetype` (`ExpenseType`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_loanapplication_has_BusinessExpenseType_loanapplication1` FOREIGN KEY (`loanapplication_ControlNo`) REFERENCES `loanapplication` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `loanapplication_has_familyexpensetype`
--
ALTER TABLE `loanapplication_has_familyexpensetype`
  ADD CONSTRAINT `fk_LoanApplication_has_ExpenseType_ExpenseType1` FOREIGN KEY (`FamilyExpenseType_ExpenseType`) REFERENCES `familyexpensetype` (`ExpenseType`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LoanApplication_has_ExpenseType_LoanApplication1` FOREIGN KEY (`LoanApplication_ControlNo`) REFERENCES `loanapplication` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `loanapplication_has_incometype`
--
ALTER TABLE `loanapplication_has_incometype`
  ADD CONSTRAINT `fk_LoanApplication_has_IncomeType_IncomeType1` FOREIGN KEY (`IncomeType_IncomeType`) REFERENCES `incometype` (`IncomeType`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LoanApplication_has_IncomeType_LoanApplication1` FOREIGN KEY (`LoanApplication_ControlNo`) REFERENCES `loanapplication` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `loanapplication_has_members`
--
ALTER TABLE `loanapplication_has_members`
  ADD CONSTRAINT `fk_LoanApplication_has_Members_CaritasBranch1` FOREIGN KEY (`CaritasBranch_ControlNo`) REFERENCES `caritasbranch` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LoanApplication_has_Members_LoanApplication2` FOREIGN KEY (`LoanApplication_ControlNo`) REFERENCES `loanapplication` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LoanApplication_has_Members_Members2` FOREIGN KEY (`Members_ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `loanbusiness_has_loanapplication`
--
ALTER TABLE `loanbusiness_has_loanapplication`
  ADD CONSTRAINT `fk_LoanBusiness_has_LoanApplication_LoanApplication1` FOREIGN KEY (`LoanApplication_ControlNo`) REFERENCES `loanapplication` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LoanBusiness_has_LoanApplication_LoanBusiness1` FOREIGN KEY (`LoanBusiness_ControlNo`) REFERENCES `loanbusiness` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `fk_Members_CivilStatusRef1` FOREIGN KEY (`CivilStatus`) REFERENCES `civilstatusref` (`CivilStatus`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Members_EducationalAttainmentRef1` FOREIGN KEY (`EducationalAttainment`) REFERENCES `educationalattainmentref` (`EducationalAttainment`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Members_GenderRef1` FOREIGN KEY (`GenderID`) REFERENCES `genderref` (`GenderID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Members_Religion1` FOREIGN KEY (`Religion`) REFERENCES `religion` (`Religion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `membersaddress`
--
ALTER TABLE `membersaddress`
  ADD CONSTRAINT `fk_MembersAddress_AddressTypeRef1` FOREIGN KEY (`AddressType`) REFERENCES `addresstyperef` (`AddressType`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_MembersAddress_Members1` FOREIGN KEY (`ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `memberscontact`
--
ALTER TABLE `memberscontact`
  ADD CONSTRAINT `fk_MembersContact_Members1` FOREIGN KEY (`ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `membershousehold`
--
ALTER TABLE `membershousehold`
  ADD CONSTRAINT `fk_MembersHousehold_CivilStatusRef1` FOREIGN KEY (`CivilStatus`) REFERENCES `civilstatusref` (`CivilStatus`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_MembersHousehold_GenderRef1` FOREIGN KEY (`GenderID`) REFERENCES `genderref` (`GenderID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `membersmfi`
--
ALTER TABLE `membersmfi`
  ADD CONSTRAINT `fk_MembersMFI_Members1` FOREIGN KEY (`ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `membersname`
--
ALTER TABLE `membersname`
  ADD CONSTRAINT `fk_MembersName_Members1` FOREIGN KEY (`ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `membersorganization`
--
ALTER TABLE `membersorganization`
  ADD CONSTRAINT `fk_MembersOrganization_Members1` FOREIGN KEY (`ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `memberspicture`
--
ALTER TABLE `memberspicture`
  ADD CONSTRAINT `fk_MembersPicture_Members1` FOREIGN KEY (`ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `memberssignature`
--
ALTER TABLE `memberssignature`
  ADD CONSTRAINT `fk_MembersSigniture_Members1` FOREIGN KEY (`ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `members_has_members`
--
ALTER TABLE `members_has_members`
  ADD CONSTRAINT `fk_Members_has_Members_Members1` FOREIGN KEY (`ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Members_has_Members_Members2` FOREIGN KEY (`FamilyControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `members_has_membershousehold`
--
ALTER TABLE `members_has_membershousehold`
  ADD CONSTRAINT `fk_Members_has_MembersHousehold_Members1` FOREIGN KEY (`ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Members_has_MembersHousehold_MembersHousehold1` FOREIGN KEY (`HouseholdNo`) REFERENCES `membershousehold` (`HouseholdNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `members_has_membersmembershipstatus`
--
ALTER TABLE `members_has_membersmembershipstatus`
  ADD CONSTRAINT `fk_Members_has_MembersMembershipStatus_Members1` FOREIGN KEY (`ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Members_has_MembersMembershipStatus_MembersMembershipStatus1` FOREIGN KEY (`Status`) REFERENCES `membersmembershipstatus` (`Status`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `members_has_membertype`
--
ALTER TABLE `members_has_membertype`
  ADD CONSTRAINT `fk_Members_has_MemberType_Members1` FOREIGN KEY (`ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Members_has_MemberType_MemberType1` FOREIGN KEY (`Type`) REFERENCES `membertype` (`Type`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `members_has_violations`
--
ALTER TABLE `members_has_violations`
  ADD CONSTRAINT `fk_Members_has_Violations_CaritasPersonnel1` FOREIGN KEY (`CaritasPersonnel_ControlNo`) REFERENCES `caritaspersonnel` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Members_has_Violations_Members1` FOREIGN KEY (`Members_ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Members_has_Violations_Violations1` FOREIGN KEY (`Violations_ViolationID`) REFERENCES `violations` (`ViolationID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `member_comaker`
--
ALTER TABLE `member_comaker`
  ADD CONSTRAINT `fk_LoanApplication_has_Members_LoanApplication1` FOREIGN KEY (`LoanApplication_ControlNo`) REFERENCES `loanapplication` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LoanApplication_has_Members_Members1` FOREIGN KEY (`Members_ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `nonmember_comaker`
--
ALTER TABLE `nonmember_comaker`
  ADD CONSTRAINT `fk_LoanApplication_has_MembersHousehold_LoanApplication1` FOREIGN KEY (`LoanApplication_ControlNo`) REFERENCES `loanapplication` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LoanApplication_has_MembersHousehold_MembersHousehold1` FOREIGN KEY (`MembersHousehold_HouseholdNo`) REFERENCES `membershousehold` (`HouseholdNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `passbook`
--
ALTER TABLE `passbook`
  ADD CONSTRAINT `fk_Passbook_CaritasCenters1` FOREIGN KEY (`CaritasCenters_ControlNo`) REFERENCES `caritascenters` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sourceofincome`
--
ALTER TABLE `sourceofincome`
  ADD CONSTRAINT `fk_1_Members1` FOREIGN KEY (`ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `termination`
--
ALTER TABLE `termination`
  ADD CONSTRAINT `fk_Termination_CaritasBranch1` FOREIGN KEY (`CaritasBranch_ControlNo`) REFERENCES `caritasbranch` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Termination_CaritasPersonnel1` FOREIGN KEY (`CaritasPersonnel_ControlNo`) REFERENCES `caritaspersonnel` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Termination_Members1` FOREIGN KEY (`Members_ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `fk_Passbook_Members1` FOREIGN KEY (`Members_ControlNo`) REFERENCES `members` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_SavingsTransaction_CaritasPersonnel1` FOREIGN KEY (`CaritasPersonnel_ControlNo`) REFERENCES `caritaspersonnel` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Transaction_Passbook1` FOREIGN KEY (`Passbook_ControlNo`) REFERENCES `passbook` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Transaction_TransactionType1` FOREIGN KEY (`TransactionType`) REFERENCES `transactiontype` (`TransactionType`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_Users_CaritasPersonnel1` FOREIGN KEY (`ControlNo`) REFERENCES `caritaspersonnel` (`ControlNo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `violations`
--
ALTER TABLE `violations`
  ADD CONSTRAINT `fk_Violations_Degree1` FOREIGN KEY (`Degree`) REFERENCES `degree` (`Degree`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
