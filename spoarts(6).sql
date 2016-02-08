-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2016 at 02:28 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `spoarts`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE IF NOT EXISTS `bookmark` (
  `bm_id` int(11) NOT NULL,
  `clinic_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `service_id` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_clinics`
--

CREATE TABLE IF NOT EXISTS `client_clinics` (
  `cc_id` int(11) NOT NULL,
  `clinic_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `service_id` mediumtext NOT NULL COMMENT 'values: 1,2,3,4',
  `interest` mediumtext NOT NULL COMMENT 'list of service_id'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

CREATE TABLE IF NOT EXISTS `clinics` (
  `clinic_id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `clinic_name` varchar(30) NOT NULL,
  `clinic_logo` varchar(30) NOT NULL,
  `SPAboutMe` longtext NOT NULL,
  `SPLocation` varchar(50) NOT NULL,
  `SPSubsPlan` int(11) NOT NULL COMMENT '1-trial;2-premium',
  `SPSubsDate` datetime NOT NULL COMMENT 'Subscription Date',
  `clinic_status` int(11) NOT NULL COMMENT '0-deactivated;1-activated'
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`clinic_id`, `UserID`, `clinic_name`, `clinic_logo`, `SPAboutMe`, `SPLocation`, `SPSubsPlan`, `SPSubsDate`, `clinic_status`) VALUES
(21, 27, 'Test Club', 'Desert.jpg', 'Test Club Descriptioqnsdfsd', 'Cebu City', 1, '0000-00-00 00:00:00', 0),
(22, 28, '', 'IMG_0143-e1352505322542.jpg', '', '', 0, '0000-00-00 00:00:00', 0),
(23, 29, '', '30324943-fitness-sport-trainin', '', '', 0, '0000-00-00 00:00:00', 0),
(24, 30, '', 'inside-of-gym.jpg', '', '', 0, '0000-00-00 00:00:00', 0),
(25, 32, '', '', '', '', 0, '0000-00-00 00:00:00', 0),
(26, 26, '', '', '', '', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `EventID` int(11) NOT NULL,
  `EventName` varchar(50) NOT NULL,
  `EventDesc` text NOT NULL,
  `EventFor` varchar(200) NOT NULL,
  `EventStartDate` date NOT NULL,
  `EventEndDate` date NOT NULL,
  `EventLocation` varchar(60) NOT NULL,
  `EventStatus` int(11) NOT NULL,
  `SPID` int(11) NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`EventID`, `EventName`, `EventDesc`, `EventFor`, `EventStartDate`, `EventEndDate`, `EventLocation`, `EventStatus`, `SPID`, `TIMESTAMP`) VALUES
(0, 'dog', 'the quick brown fox jumps over the lazy dog.', '9,10,11', '2016-02-01', '2016-02-07', 'cebu', 1, 27, '2016-02-07 20:44:33'),
(2, 'keyzia', 'doggie keyzia', '11,12,13', '2016-02-06', '2016-02-09', 'cebu', 1, 27, '2016-02-07 20:44:34'),
(0, 'dog', 'the quick brown fox jumps over the lazy dog.', '9,10,11', '2016-02-01', '2016-02-07', 'cebu', 1, 27, '2016-02-07 20:44:33'),
(2, 'keyzia', 'doggie keyzia', '11,12,13', '2016-02-06', '2016-02-09', 'cebu', 1, 27, '2016-02-07 20:44:34');

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE IF NOT EXISTS `instructors` (
  `ins_id` int(11) NOT NULL,
  `ins_name` varchar(35) NOT NULL,
  `ins_schedule` mediumtext NOT NULL,
  `ins_room` varchar(20) NOT NULL,
  `ins_slot` int(11) NOT NULL,
  `ins_status` int(11) NOT NULL COMMENT '0-inactive;1active',
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`ins_id`, `ins_name`, `ins_schedule`, `ins_room`, `ins_slot`, `ins_status`, `service_id`) VALUES
(1, 'Park Hae Jin', 'Monday, Wednesday & Saturday 10:00am-02:00pm', 'room 81', 10, 1, 8),
(2, 'Siwon', 'Monday-Wednesday 02:00pm-05pm', 'room 10', 12, 1, 8),
(3, 'Iu', 'Monday, Friday 10:00am-01:00pm', 'room5', 12, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `instructor_masterlist`
--

CREATE TABLE IF NOT EXISTS `instructor_masterlist` (
  `MasterInsID` int(11) NOT NULL,
  `MasterInsName` varchar(50) NOT NULL,
  `MasterInsAddress` varchar(60) NOT NULL,
  `MasterInsContactNo` int(11) NOT NULL,
  `MasterInsEmail` varchar(30) DEFAULT NULL,
  `MasterInsExpertise` varchar(30) NOT NULL,
  `MasterInsStatus` int(11) NOT NULL,
  `SPID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `interest`
--

CREATE TABLE IF NOT EXISTS `interest` (
  `interest_id` int(11) NOT NULL,
  `interest_name` varchar(50) NOT NULL,
  `interest_type` int(11) NOT NULL COMMENT '0-sports;1-arts'
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `interest`
--

INSERT INTO `interest` (`interest_id`, `interest_name`, `interest_type`) VALUES
(1, 'Animation', 1),
(2, 'Architecture', 1),
(3, 'Body Art', 1),
(6, 'Brief Art', 1),
(7, 'Cinema', 1),
(8, 'Comic writing', 1),
(9, 'Dance', 1),
(10, 'Digital art', 1),
(11, 'Drawing', 1),
(12, 'Engraving', 1),
(13, 'Fractal art', 1),
(14, 'Gastronomy', 1),
(15, 'Gold-smithery, silver-smithery, and jewellery', 1),
(16, 'Graffiti', 1),
(17, 'Music', 1),
(18, 'Opera', 1),
(19, 'Painting', 1),
(20, 'Photography', 1),
(21, 'Poetry', 1),
(22, 'Pottery', 1),
(23, 'Sculpture', 1),
(24, 'Singing', 1),
(25, 'Theatre', 1),
(26, 'Woodwork', 1),
(27, 'Writing', 1),
(28, 'Air sports', 0),
(29, ' Archery', 0),
(30, ' Ball-over-net games', 0),
(31, ' Basketball family', 0),
(32, 'Bat-and-ball (safe haven)', 0),
(33, 'Board sports', 0),
(34, ' Climbing', 0),
(35, ' Cycling', 0),
(36, 'Combat sports: Wrestling and martial arts', 0),
(37, ' Dance', 0),
(38, 'Football', 0),
(39, 'Ice sports', 0),
(40, ' Running', 0),
(41, 'Snow sports', 0),
(42, 'Table sports', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `NotifID` int(11) NOT NULL,
  `Subject` varchar(50) NOT NULL,
  `Message` varchar(200) NOT NULL,
  `DateCreated` date NOT NULL,
  `ClientID` int(11) NOT NULL,
  `SPID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_logs`
--

CREATE TABLE IF NOT EXISTS `payment_logs` (
  `payment_id` int(11) NOT NULL,
  `payment_amt` varchar(11) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_type` int(11) NOT NULL COMMENT '0:session;1:monthly;2:membership',
  `payment_balance` varchar(11) NOT NULL,
  `stud_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `payment_desc` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `promos`
--

CREATE TABLE IF NOT EXISTS `promos` (
  `PromoID` int(11) NOT NULL,
  `PromoName` varchar(50) NOT NULL,
  `PromoDesc` text NOT NULL,
  `PromoStartDate` date NOT NULL,
  `PromoEndDate` date NOT NULL,
  `PromoStatus` int(11) NOT NULL,
  `SPID` int(11) NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promos`
--

INSERT INTO `promos` (`PromoID`, `PromoName`, `PromoDesc`, `PromoStartDate`, `PromoEndDate`, `PromoStatus`, `SPID`, `TIMESTAMP`) VALUES
(1, 'set', 'sets', '2016-02-01', '2016-02-22', 0, 27, '2016-02-06 23:34:41'),
(2, 'test2', 'test2', '2016-02-14', '0000-00-00', 0, 27, '2016-02-06 23:35:17'),
(3, 'adsfasdf', 'asdfasdf', '2016-02-01', '2016-02-08', 1, 27, '2016-02-07 04:36:08'),
(4, 'asdfads', 'fadsfadsf', '2014-09-13', '0000-00-00', 1, 27, '2016-02-06 23:08:57'),
(5, 'asdfads', 'fadsfadsf', '2014-09-13', '0000-00-00', 1, 27, '2016-02-06 23:08:57'),
(6, 'asdfadsf', 'asdfadsf', '2016-02-10', '2016-02-17', 1, 27, '2016-02-08 01:56:43'),
(7, 'aaa', 'aaa', '2016-06-06', '0000-00-00', 1, 27, '2016-02-05 01:37:39'),
(8, 'keyzia', 'keyzia', '0000-00-00', '0000-00-00', 1, 27, '2016-02-06 23:13:11'),
(9, 'adsfadf', 'asdfadsf', '0000-00-00', '0000-00-00', 1, 27, '2016-02-06 23:14:46'),
(10, 'matet', 'matet', '0000-00-00', '0000-00-00', 1, 27, '2016-02-06 23:16:38'),
(11, 'aaaa', 'aaaa', '0000-00-00', '0000-00-00', 1, 27, '2016-02-06 23:28:48'),
(1, 'set', 'sets', '2016-02-01', '2016-02-22', 0, 27, '2016-02-06 23:34:41'),
(2, 'test2', 'test2', '2016-02-14', '0000-00-00', 0, 27, '2016-02-06 23:35:17'),
(3, 'adsfasdf', 'asdfasdf', '2016-02-01', '2016-02-08', 1, 27, '2016-02-07 04:36:08'),
(4, 'asdfads', 'fadsfadsf', '2014-09-13', '0000-00-00', 1, 27, '2016-02-06 23:08:57'),
(5, 'asdfads', 'fadsfadsf', '2014-09-13', '0000-00-00', 1, 27, '2016-02-06 23:08:57'),
(6, 'asdfadsf', 'asdfadsf', '2016-02-10', '2016-02-17', 1, 27, '2016-02-08 01:56:43'),
(7, 'aaa', 'aaa', '2016-06-06', '0000-00-00', 1, 27, '2016-02-05 01:37:39'),
(8, 'keyzia', 'keyzia', '0000-00-00', '0000-00-00', 1, 27, '2016-02-06 23:13:11'),
(9, 'adsfadf', 'asdfadsf', '0000-00-00', '0000-00-00', 1, 27, '2016-02-06 23:14:46'),
(10, 'matet', 'matet', '0000-00-00', '0000-00-00', 1, 27, '2016-02-06 23:16:38'),
(11, 'aaaa', 'aaaa', '0000-00-00', '0000-00-00', 1, 27, '2016-02-06 23:28:48');

-- --------------------------------------------------------

--
-- Table structure for table `reviews_and_ratings`
--

CREATE TABLE IF NOT EXISTS `reviews_and_ratings` (
  `ReviewsID` int(11) NOT NULL,
  `DatePosted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Message` varchar(200) NOT NULL,
  `Rating` int(11) NOT NULL,
  `SPID` int(11) NOT NULL,
  `EnrolledID` int(11) NOT NULL,
  `ReviewerID` int(11) NOT NULL,
  `ReviewStatus` tinyint(2) NOT NULL COMMENT '0:Peding; 1: Disapproved; 2: Approved;'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews_and_ratings`
--

INSERT INTO `reviews_and_ratings` (`ReviewsID`, `DatePosted`, `Message`, `Rating`, `SPID`, `EnrolledID`, `ReviewerID`, `ReviewStatus`) VALUES
(1, '2016-02-08 02:11:20', 'the quick brown fox jumps over the lazy dog', 4, 27, 0, 27, 2),
(2, '2016-02-08 02:11:20', 'The quick brown', 5, 27, 0, 27, 1),
(3, '2016-02-08 02:11:21', 'The quick brown', 5, 27, 0, 0, 0),
(1, '2016-02-08 02:11:20', 'the quick brown fox jumps over the lazy dog', 4, 27, 0, 27, 2),
(2, '2016-02-08 02:11:20', 'The quick brown', 5, 27, 0, 27, 1),
(3, '2016-02-08 02:11:21', 'The quick brown', 5, 27, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `RoomID` int(11) NOT NULL,
  `RoomNo` int(11) NOT NULL,
  `RoomName` varchar(30) NOT NULL,
  `RoomStatus` int(11) NOT NULL,
  `ServiceID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE IF NOT EXISTS `schedules` (
  `SchedID` int(11) NOT NULL,
  `SchedDate` date NOT NULL,
  `SchedStatus` int(11) NOT NULL,
  `RoomID` int(11) NOT NULL,
  `InstructorID` int(11) NOT NULL,
  `ServiceID` int(11) NOT NULL,
  `SchedSlots` int(11) NOT NULL,
  `SchedTime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `security_questions`
--

CREATE TABLE IF NOT EXISTS `security_questions` (
  `sec_id` int(11) NOT NULL,
  `sec_questions` mediumtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `security_questions`
--

INSERT INTO `security_questions` (`sec_id`, `sec_questions`) VALUES
(1, 'What''s your first pet''s name'),
(2, 'What''s your mother''s maiden name'),
(3, 'What is the name of your elementary school'),
(4, 'hfjjjksdfksd');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `ServiceID` int(11) NOT NULL,
  `ServiceName` varchar(50) NOT NULL,
  `ServiceDesc` varchar(60) NOT NULL,
  `ServiceSchedule` varchar(100) NOT NULL,
  `ServiceRegistrationFee` double NOT NULL,
  `ServiceStatus` int(11) NOT NULL,
  `ServicePrice` decimal(10,0) NOT NULL COMMENT 'monthly fee',
  `ServiceType` int(2) NOT NULL COMMENT '0: Sports; 1: Arts;',
  `SPID` int(11) NOT NULL COMMENT 'userid',
  `serviceWalkin` int(11) NOT NULL,
  `serviceHour` int(11) NOT NULL,
  `clubpic` varchar(50) NOT NULL,
  `interest_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`ServiceID`, `ServiceName`, `ServiceDesc`, `ServiceSchedule`, `ServiceRegistrationFee`, `ServiceStatus`, `ServicePrice`, `ServiceType`, `SPID`, `serviceWalkin`, `serviceHour`, `clubpic`, `interest_id`) VALUES
(1, 'Taekwando', 'Binonogay na', 'Monday-Saturday 08:00am - 09:00pm', 500, 1, '0', 1, 21, 0, 0, '', 0),
(2, 'Karate Kid', 'pinutlanay ug tiil', 'Monday-Saturday 08:00am - 09:00pm', 500, 1, '400', 1, 22, 0, 0, '', 0),
(3, 'asdsdsds', 'dsd', 'Monday-Saturday 08:00am - 09:00pm', 500, 1, '300', 1, 23, 0, 0, '', 0),
(4, 'Patire', 'rer', 'Monday-Saturday 08:00am - 09:00pm', 500, 1, '234', 1, 24, 0, 0, '', 0),
(5, 'Taekwando', 'dsd', 'Monday-Saturday 08:00am - 09:00pm', 500, 1, '233', 1, 21, 0, 0, '', 0),
(7, 'Test', 'desc', 'schedule', 144, 1, '54', 1, 21, 0, 0, '', 0),
(8, 'Taekwando', 'Taekwando1lwerwe', 'Monday-Friday 09:00am-07:00pm', 250, 1, '1000', 0, 27, 200, 0, '', 36),
(9, 'Muay Thai', 'Muay Thai', 'Monday-Friday 09:00am-07:00pm', 500, 1, '1500', 0, 27, 200, 0, '', 36),
(10, 'Piano Lesson', 'Piano Lesson', 'Monday-Saturday 09:00am-07:00pm', 200, 1, '1000', 1, 27, 150, 0, '', 17),
(11, 'Aikido', 'Aikido', 'Monday-Friday 09:00am-10:00pm', 500000, 1, '1000', 0, 27, 90, 60, '', 36),
(12, 'Kick-boxing', 'Kick-boxing', 'Monday-Saturday 09:00am-10:00pm', 500, 1, '2000', 0, 27, 200, 0, '', 36),
(13, 'Badminton', 'Badminton', 'Monday-Sunday 07:00am-08:00pm', 500, 1, '1000', 0, 27, 100, 0, '', 36),
(19, 'test', 'kjfjskdl', '235fbdfg', 5645, 1, '232', 0, 27, 345, 67, '', 0),
(21, 'dfskdfj', 'dskhkds', 'rhkgher', 21424, 1, '345', 0, 27, 234823, 23432, '', 34);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `stud_id` int(11) NOT NULL,
  `stud_name` varchar(35) NOT NULL,
  `stud_age` int(11) NOT NULL,
  `stud_address` mediumtext NOT NULL,
  `stud_membership` int(11) NOT NULL COMMENT '0:non-member;1:member',
  `client_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `clinic_id` int(11) NOT NULL,
  `stud_member_since` date NOT NULL,
  `ins_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE IF NOT EXISTS `subscriptions` (
  `SubscID` int(11) NOT NULL,
  `SubscType` int(11) NOT NULL,
  `SubscStartDate` date NOT NULL,
  `SubscEndDate` date NOT NULL,
  `UserID` int(11) NOT NULL,
  `SubsStatus` int(11) NOT NULL COMMENT '0-unpaid;1-paid'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`SubscID`, `SubscType`, `SubscStartDate`, `SubscEndDate`, `UserID`, `SubsStatus`) VALUES
(5, 0, '2016-01-14', '2016-02-14', 27, 0),
(6, 0, '2016-01-15', '2016-02-15', 28, 0),
(7, 0, '2016-01-15', '2016-02-15', 29, 0),
(8, 0, '2016-01-15', '2016-02-15', 30, 0),
(9, 0, '2016-01-19', '2016-02-19', 32, 0),
(10, 0, '2016-01-21', '2016-02-21', 33, 0),
(12, 1, '2016-02-08', '0000-00-00', 38, 0),
(13, 2, '2016-02-08', '2017-02-09', 60, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE IF NOT EXISTS `subscription_plans` (
  `PlanID` int(11) NOT NULL,
  `PlanName` varchar(50) NOT NULL,
  `PlanDesc` varchar(60) NOT NULL,
  `PlanTerm` varchar(20) NOT NULL,
  `PlanPrice` decimal(10,0) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`PlanID`, `PlanName`, `PlanDesc`, `PlanTerm`, `PlanPrice`) VALUES
(1, 'Trial', 'Free Trial', '1M', '0'),
(2, 'Premium', 'Premium Subscription', '1Y', '5000');

-- --------------------------------------------------------

--
-- Table structure for table `time_logs`
--

CREATE TABLE IF NOT EXISTS `time_logs` (
  `tl_id` int(11) NOT NULL,
  `tl_in` datetime NOT NULL,
  `tl_out` datetime NOT NULL,
  `stud_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE IF NOT EXISTS `user_accounts` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Password` longtext NOT NULL,
  `UserType` int(20) NOT NULL COMMENT '0-admin, 1-service_provide, 2-client',
  `UserStatus` int(11) NOT NULL COMMENT '0-unverified;1-active;2-inactive',
  `security_question_id` int(11) NOT NULL COMMENT 'refer to security_questions table',
  `security_password` varchar(50) NOT NULL,
  `first_login` int(11) NOT NULL COMMENT '0-firstlogin;1-alreadyloginMultipleTimes',
  `verification_code` varchar(10) NOT NULL,
  `verify_expiry` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`UserID`, `UserName`, `Password`, `UserType`, `UserStatus`, `security_question_id`, `security_password`, `first_login`, `verification_code`, `verify_expiry`) VALUES
(26, 'fire', '81dc9bdb52d04dc20036dbd8313ed055', 0, 1, 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, '', ''),
(27, 'test', '81dc9bdb52d04dc20036dbd8313ed055', 1, 1, 1, '03d25b3dc4f4a37fc9ceb5baa455d594', 1, '', ''),
(28, 'urgillo2', '81dc9bdb52d04dc20036dbd8313ed055', 1, 1, 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, '', ''),
(29, 'r', '81dc9bdb52d04dc20036dbd8313ed055', 1, 1, 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, '', ''),
(30, 'v', '81dc9bdb52d04dc20036dbd8313ed055', 1, 1, 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, '', ''),
(31, 'g', '81dc9bdb52d04dc20036dbd8313ed055', 2, 1, 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, '', ''),
(32, 'aljaymonggo', '81dc9bdb52d04dc20036dbd8313ed055', 2, 1, 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, '', ''),
(33, 'norf', '81dc9bdb52d04dc20036dbd8313ed055', 2, 1, 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, '', ''),
(34, 'norf123', '81dc9bdb52d04dc20036dbd8313ed055', 2, 1, 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, '', ''),
(38, 'mickey', 'c28b959962a1a3058c9f56f0691df470', 1, 0, 0, '', 0, '', ''),
(60, 'sponge', 'aa19ba73252e50e36a6a009c8808aaa3', 1, 1, 1, 'e1964798cfe86e914af895f8d0291812', 1, '1203391043', '2016-02-09 09:39:32'),
(61, 'patrick', '7cc2ae164fbe5a3b4fb70c2ecf667fe2', 2, 1, 0, '', 0, '576900437', '2016-02-09 11:32:17');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
  `SPID` int(11) NOT NULL,
  `SPAddress` varchar(30) NOT NULL,
  `SPContactNo` varchar(12) NOT NULL,
  `SPEmail` varchar(30) DEFAULT NULL,
  `UserID` int(11) NOT NULL,
  `splogoName` varchar(30) NOT NULL,
  `spfirstname` varchar(50) NOT NULL,
  `splastname` varchar(50) NOT NULL,
  `SPRegisteredDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `spbirthday` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`SPID`, `SPAddress`, `SPContactNo`, `SPEmail`, `UserID`, `splogoName`, `spfirstname`, `splastname`, `SPRegisteredDate`, `spbirthday`) VALUES
(21, 'Urgello Cebu City', '677-7898', 'our@yahoo.com', 27, 'Koala.jpg', 'test', 'test', '0000-00-00 00:00:00', '0000-00-00'),
(22, 'Mabolo Cebu City', 'nine', 'none', 28, 'IMG_0143-e1352505322542.jpg', '', '', '0000-00-00 00:00:00', '0000-00-00'),
(23, 'Cebu City', 'rrr', 'rere@yahoo.com', 33, '', '', '', '0000-00-00 00:00:00', '0000-00-00'),
(24, 'Dsds', 'v', 'dsds', 30, 'inside-of-gym.jpg', '', '', '0000-00-00 00:00:00', '0000-00-00'),
(25, 'Aljay mongo', '1234', 'aljaymonggo@gmail.com', 32, '', '', '', '0000-00-00 00:00:00', '0000-00-00'),
(26, 'Secret', '123456', 'nalmonicar1988@gmail.com', 26, 'Chrysanthemum.jpg', 'Admin', 'Admin', '0000-00-00 00:00:00', '0000-00-00'),
(28, '', '123456789', NULL, 38, '', 'mickey', 'mouse', '0000-00-00 00:00:00', '1991-02-08'),
(50, '', '89534808035', 'saga_aquatic@yahoo.com.ph', 60, '', 'sponge', 'bob', '2016-02-08 16:39:32', '1991-02-03'),
(51, '', '23859035034', 'mymiracle91@gmail.com', 61, '', 'Patrick', 'Spongebob', '2016-02-08 18:32:18', '1991-02-03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`bm_id`);

--
-- Indexes for table `client_clinics`
--
ALTER TABLE `client_clinics`
  ADD PRIMARY KEY (`cc_id`);

--
-- Indexes for table `clinics`
--
ALTER TABLE `clinics`
  ADD PRIMARY KEY (`clinic_id`), ADD KEY `USERID` (`UserID`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`ins_id`);

--
-- Indexes for table `instructor_masterlist`
--
ALTER TABLE `instructor_masterlist`
  ADD PRIMARY KEY (`MasterInsID`), ADD KEY `SPID` (`SPID`);

--
-- Indexes for table `interest`
--
ALTER TABLE `interest`
  ADD PRIMARY KEY (`interest_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`NotifID`), ADD KEY `CLIENTID` (`ClientID`), ADD KEY `SPID` (`SPID`);

--
-- Indexes for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`RoomID`), ADD KEY `SERVICEID` (`ServiceID`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`SchedID`), ADD KEY `ROOMID` (`RoomID`), ADD KEY `INSTRUCTORID` (`InstructorID`);

--
-- Indexes for table `security_questions`
--
ALTER TABLE `security_questions`
  ADD PRIMARY KEY (`sec_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`ServiceID`), ADD KEY `SPID` (`SPID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`stud_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`SubscID`), ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`PlanID`), ADD KEY `PlanID` (`PlanID`);

--
-- Indexes for table `time_logs`
--
ALTER TABLE `time_logs`
  ADD PRIMARY KEY (`tl_id`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`UserID`), ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`SPID`), ADD KEY `USERID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `bm_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `client_clinics`
--
ALTER TABLE `client_clinics`
  MODIFY `cc_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `clinic_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `ins_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `instructor_masterlist`
--
ALTER TABLE `instructor_masterlist`
  MODIFY `MasterInsID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `interest`
--
ALTER TABLE `interest`
  MODIFY `interest_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `NotifID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `RoomID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `SchedID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `security_questions`
--
ALTER TABLE `security_questions`
  MODIFY `sec_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `ServiceID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `stud_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `SubscID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `PlanID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `time_logs`
--
ALTER TABLE `time_logs`
  MODIFY `tl_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `SPID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
