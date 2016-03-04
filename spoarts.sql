-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2016 at 08:06 PM
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
-- Table structure for table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `albumID` int(11) NOT NULL,
  `albumName` text NOT NULL,
  `UserID` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `albumDesc` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`albumID`, `albumName`, `UserID`, `dateCreated`, `albumDesc`) VALUES
(1, 'Pink Album', 2, '2016-02-17 12:59:02', 'My mouse is pink                  '),
(2, 'hello', 2, '2016-02-17 16:47:15', 'is it me you''re looking for?                  '),
(3, 'picture', 9, '2016-02-19 02:36:57', '                  Just picture');

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE IF NOT EXISTS `bookmark` (
  `bm_id` int(11) NOT NULL,
  `clinic_id` mediumtext NOT NULL,
  `client_id` int(11) NOT NULL,
  `service_id` mediumtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`bm_id`, `clinic_id`, `client_id`, `service_id`) VALUES
(1, '1,2', 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `client_interest`
--

CREATE TABLE IF NOT EXISTS `client_interest` (
  `ci_id` int(11) NOT NULL,
  `interest_ids` longtext NOT NULL COMMENT 'e.g. 1,2,3,4',
  `client_id` int(11) NOT NULL COMMENT 'userid foreign key see usr_account'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_interest`
--

INSERT INTO `client_interest` (`ci_id`, `interest_ids`, `client_id`) VALUES
(1, '1,2,6,7,18,19,20,21,22,33,34,35,36,3,8', 3),
(2, '1', 3),
(3, '34,35', 6);

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
  `SPLocation` mediumtext NOT NULL,
  `SPSubsPlan` int(11) NOT NULL COMMENT '1-trial;2-premium',
  `SPSubsDate` datetime NOT NULL COMMENT 'Subscription Date',
  `clinic_status` int(11) NOT NULL COMMENT '0-deactivated;1-activated',
  `longitude` text NOT NULL,
  `latitude` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`clinic_id`, `UserID`, `clinic_name`, `clinic_logo`, `SPAboutMe`, `SPLocation`, `SPSubsPlan`, `SPSubsDate`, `clinic_status`, `longitude`, `latitude`) VALUES
(1, 2, 'Rene''s Pink Club', 'original.jpg', 'I have a pink mouse and i really really love it', 'Mandaue City, Central Visayas, Philippines', 0, '0000-00-00 00:00:00', 1, '123.94155180000007', '10.3402623'),
(2, 4, 'Bugoy''s club', 'IMG_20150608_211313.jpg', 'Mga bugoy ug bugay lang pwede', 'Guadalupe, Cebu City, Central Visayas, Philippines', 0, '0000-00-00 00:00:00', 1, '123.88543770000001', '10.3156173'),
(3, 5, 'Erfe', 'Devil.jpg', 'Efer', 'Cebu City, Central Visayas, Philippines', 0, '0000-00-00 00:00:00', 1, '123.88543660000005', '10.3156992');

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`EventID`, `EventName`, `EventDesc`, `EventFor`, `EventStartDate`, `EventEndDate`, `EventLocation`, `EventStatus`, `SPID`, `TIMESTAMP`) VALUES
(1, 'My pink Life', 'story telling on how I started to like pink', '1', '2016-02-16', '2016-02-23', 'cebu', 1, 2, '2016-02-16 16:21:12'),
(2, 'test2', 'test', '1', '2016-02-18', '2016-02-20', 'ceb', 0, 2, '2016-02-17 07:49:06'),
(3, 'test', 'test', '1', '2016-02-17', '2016-02-18', 'test', 0, 2, '2016-02-17 07:53:49'),
(4, 'test', 'tes', '1', '2016-02-15', '2016-02-21', 'cebu', 0, 2, '2016-02-21 10:20:15'),
(5, 'New Event', 'New Event', '2', '2016-02-03', '2016-02-05', 'Cebu', 1, 4, '2016-02-21 08:53:34'),
(6, 'test', 'test', '1', '2016-02-01', '2016-02-09', 'ceb', 0, 2, '2016-02-21 09:59:56'),
(7, 'test', 'test', '1', '2016-02-01', '2016-02-09', 'ceb', 0, 2, '2016-02-21 10:00:01'),
(8, 'test', 'tes', '1', '2016-02-09', '2016-02-09', 'ceb', 0, 2, '2016-02-21 10:01:22'),
(9, 'test', 'tes', '1', '2016-02-09', '2016-02-09', 'ceb', 0, 2, '2016-02-21 10:01:27'),
(10, 'test', 'test', '1', '2016-02-02', '2016-02-09', 'ceb', 0, 2, '2016-02-21 10:20:08'),
(11, 'a', 'a', '1', '2016-02-22', '2016-02-23', 'a', 0, 2, '2016-02-21 10:20:17'),
(12, 'test', 'tes', '1', '2016-02-01', '2016-02-02', 'a', 0, 2, '2016-02-21 10:24:44'),
(13, 'z', 'z', '1', '2016-02-01', '2016-02-22', 'z', 0, 2, '2016-02-21 10:24:43'),
(14, 'a', 'a', '1', '2016-02-09', '2016-02-09', 'a', 0, 2, '2016-02-21 10:24:49'),
(15, 'tests', 'tests', '1', '2016-02-08', '2016-02-15', 'test', 1, 2, '2016-02-23 03:10:04'),
(16, 'sdf', 'sdfsd', '3', '2016-03-01', '2016-03-10', 'fdgdfg', 1, 5, '2016-03-04 18:12:26'),
(17, 'sdf', 'sdfsd', '3', '2016-03-01', '2016-03-10', 'fdgdfg', 1, 5, '2016-03-04 18:14:43'),
(18, 'sdf', 'sdfsd', '3', '2016-03-01', '2016-03-10', 'fdgdfg', 1, 5, '2016-03-04 18:15:38'),
(19, 'rge', 'dfgfd', '3', '2016-03-01', '2016-03-08', 'fdgfdg', 1, 5, '2016-03-04 18:22:08');

-- --------------------------------------------------------

--
-- Table structure for table `events_enrolled`
--

CREATE TABLE IF NOT EXISTS `events_enrolled` (
  `EventEnrolledID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `stud_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `clinic_id` int(11) NOT NULL COMMENT 'SPID in events;',
  `EventEnrolledStatus` int(11) NOT NULL,
  `dateEnrolled` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events_enrolled`
--

INSERT INTO `events_enrolled` (`EventEnrolledID`, `EventID`, `stud_id`, `client_id`, `clinic_id`, `EventEnrolledStatus`, `dateEnrolled`) VALUES
(1, 4, 1, 3, 2, 1, '2016-02-21 14:00:59'),
(2, 4, 2, 3, 2, 1, '2016-02-21 14:01:38'),
(3, 4, 2, 3, 2, 1, '2016-02-21 14:05:31'),
(4, 4, 2, 3, 2, 1, '2016-02-21 14:06:15'),
(5, 5, 1, 3, 4, 0, '2016-02-23 10:13:01'),
(6, 5, 2, 3, 4, 0, '2016-02-23 10:18:06');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `galleryID` int(11) NOT NULL,
  `albumID` int(11) NOT NULL,
  `fileName` text NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`galleryID`, `albumID`, `fileName`, `dateCreated`) VALUES
(1, 1, 'Chrysanthemum.jpg', '2016-02-17 16:12:46'),
(2, 1, 'Desert.jpg', '2016-02-17 16:12:47'),
(3, 1, 'Hydrangeas.jpg', '2016-02-17 16:12:48'),
(4, 1, 'Jellyfish.jpg', '2016-02-17 16:12:49'),
(5, 1, 'Koala.jpg', '2016-02-17 16:12:50'),
(6, 1, 'Lighthouse.jpg', '2016-02-17 16:12:51'),
(7, 1, 'Penguins.jpg', '2016-02-17 16:12:52'),
(8, 1, 'Tulips.jpg', '2016-02-17 16:12:53'),
(9, 2, 'arts.jpg', '2016-02-17 17:05:06'),
(10, 2, 'artscover.jpg', '2016-02-17 17:05:07'),
(11, 2, 'background1.jpg', '2016-02-17 17:05:08'),
(12, 2, 'bg2.jpg', '2016-02-17 17:05:08'),
(13, 1, 'ariana.jpg', '2016-02-18 16:10:51'),
(14, 3, 'alden.jpg', '2016-02-19 02:37:12'),
(15, 3, 'large.jpg', '2016-02-19 02:37:15'),
(16, 3, 'ariana.jpg', '2016-02-19 02:37:34');

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
  `UserID` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `instructor_masterlist`
--

INSERT INTO `instructor_masterlist` (`MasterInsID`, `MasterInsName`, `MasterInsAddress`, `MasterInsContactNo`, `MasterInsEmail`, `MasterInsExpertise`, `MasterInsStatus`, `UserID`, `date_added`) VALUES
(1, 'Pink Manther', 'secret', 1234589, 'pinkmanther@gmail.com', 'i collect pink things', 1, 2, '2016-02-16 11:17:02'),
(2, 'Lan', 'Cebu', 2611149, 'secret@yahoo.com', 'Painting', 1, 4, '2016-02-21 14:59:47');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `NotifID` int(11) NOT NULL,
  `Subject` varchar(50) NOT NULL,
  `Message` mediumtext NOT NULL,
  `DateCreated` date NOT NULL,
  `ClientID` int(11) NOT NULL,
  `SPID` int(11) NOT NULL,
  `NotifStatus` int(11) NOT NULL COMMENT '0:not read; 1:read;'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`NotifID`, `Subject`, `Message`, `DateCreated`, `ClientID`, `SPID`, `NotifStatus`) VALUES
(1, 'New Event', 'Event test has been added by Jiujitsu pink service', '2016-02-21', 1, 2, 0),
(2, 'New Event', 'Event test has been added by Jiujitsu pink service', '2016-02-21', 3, 2, 1),
(3, 'For Approval [Jiujitsu pink service] : New Student', 'You have a new student request from client cris cubcub. Enrollee Name: a.', '0000-00-00', 2, 3, 0),
(4, 'For Approval [Jiujitsu pink service] : New Student', 'You have a new student request from client cris cubcub. Enrollee Name: b.', '0000-00-00', 2, 3, 0),
(5, 'For Approval [Jiujitsu pink service] : New Student', 'You have a new student request from client cris cubcub. Enrollee Name: dian.', '0000-00-00', 2, 3, 0),
(6, 'For Approval [Jiujitsu pink service] : New Student', 'You have a new student request from client sdfsdf sdfsdf. Enrollee Name: das.', '0000-00-00', 2, 6, 0),
(7, 'Enrollment Request Approval', 'das enrollment to Jiujitsu pink service of Rene''s Pink Club has been approved last 2016-03-05 03:02:04 [Rene''s Pink Club-Jiujitsu pink service]', '0000-00-00', 6, 2, 0),
(8, 'For Approval [Jiujitsu pink service] : New Student', 'You have a new student request from client sdfsdf sdfsdf. Enrollee Name: dfg.', '0000-00-00', 2, 6, 0),
(9, 'Enrollment Request Approval', 'dfg enrollment to Jiujitsu pink service of Rene''s Pink Club has been approved last 2016-03-05 03:05:12 [Rene''s Pink Club-Jiujitsu pink service]', '0000-00-00', 6, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `payment_logs`
--

CREATE TABLE IF NOT EXISTS `payment_logs` (
  `payment_id` int(11) NOT NULL,
  `payment_amt` varchar(11) NOT NULL,
  `payment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_type` int(11) NOT NULL COMMENT '0:session;1:monthly;2:membership',
  `payment_balance` varchar(11) NOT NULL,
  `stud_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `payment_desc` mediumtext NOT NULL,
  `payment_end_date` datetime NOT NULL,
  `SchedID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL COMMENT 'service provider ID',
  `service_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_logs`
--

INSERT INTO `payment_logs` (`payment_id`, `payment_amt`, `payment_date`, `payment_type`, `payment_balance`, `stud_id`, `client_id`, `payment_desc`, `payment_end_date`, `SchedID`, `UserID`, `service_id`, `date_added`, `last_updated`) VALUES
(1, '100', '2016-01-18 04:01:00', 2, '50', 4, 3, 'okay', '0000-00-00 00:00:00', 2, 2, 1, '2016-02-18 04:01:00', '2016-02-29 20:09:58'),
(2, '100', '2016-02-18 11:52:21', 2, '100', 4, 3, 'paid', '0000-00-00 00:00:00', 2, 2, 2, '2016-02-18 11:52:21', '0000-00-00 00:00:00'),
(3, '200', '2016-02-18 11:53:17', 0, '100', 3, 3, 'balanced', '2016-02-18 11:53:17', 2, 2, 2, '2016-02-18 11:53:17', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `paypal_logs`
--

CREATE TABLE IF NOT EXISTS `paypal_logs` (
  `paypal_id` int(11) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `UserID` int(11) NOT NULL,
  `paypal_amount` int(11) NOT NULL,
  `paypal_invoice` varchar(50) NOT NULL,
  `buyer_name` varchar(50) NOT NULL,
  `paypal_createTime` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paypal_logs`
--

INSERT INTO `paypal_logs` (`paypal_id`, `transaction_id`, `UserID`, `paypal_amount`, `paypal_invoice`, `buyer_name`, `paypal_createTime`) VALUES
(1, '3WF45874VA242582C', 2, 1500, '56c34a95b673e', 'rene macalisang', '2016-02-16 16:13:15');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promos`
--

INSERT INTO `promos` (`PromoID`, `PromoName`, `PromoDesc`, `PromoStartDate`, `PromoEndDate`, `PromoStatus`, `SPID`, `TIMESTAMP`) VALUES
(1, 'Pink Promo', 'Pink Manther ', '2016-02-24', '2016-02-29', 1, 2, '2016-02-16 16:21:36'),
(2, 'tests', 'tests', '2016-02-17', '2016-02-18', 0, 2, '2016-02-17 07:54:25'),
(3, 'sdfsd', 'sdfsd', '2016-03-06', '2016-03-16', 1, 5, '2016-03-04 18:16:20'),
(4, 'sdfsd', 'sdfsd', '2016-03-06', '2016-03-16', 1, 5, '2016-03-04 18:16:59'),
(5, 'sdfsd', 'sdfsd', '2016-03-06', '2016-03-16', 1, 5, '2016-03-04 18:18:23'),
(6, 'sdfsd', 'sdfsd', '2016-03-06', '2016-03-16', 1, 5, '2016-03-04 18:20:03');

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
  `ReviewStatus` tinyint(2) NOT NULL COMMENT '0:Peding; 1: Disapproved; 2: Approved;',
  `clinic_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews_and_ratings`
--

INSERT INTO `reviews_and_ratings` (`ReviewsID`, `DatePosted`, `Message`, `Rating`, `SPID`, `EnrolledID`, `ReviewStatus`, `clinic_id`) VALUES
(1, '2016-02-16 16:56:20', 'pink is pink and not blue', 3, 3, 3, 2, 1),
(3, '2016-02-16 16:56:20', 'YUIYUiYUI', 4, 2, 3, 2, 1),
(4, '2016-02-18 03:16:35', 'test', 4, 2, 3, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `RoomID` int(11) NOT NULL,
  `RoomNo` int(11) NOT NULL,
  `RoomName` varchar(30) NOT NULL,
  `RoomStatus` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`RoomID`, `RoomNo`, `RoomName`, `RoomStatus`, `UserID`) VALUES
(1, 12, 'Pink Room', 1, 2),
(2, 126, 'Pink Again', 1, 2),
(3, 45, 'Ilove Pink', 1, 2),
(4, 1, 'Rose', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE IF NOT EXISTS `schedules` (
  `SchedID` int(11) NOT NULL,
  `SchedDays` varchar(50) NOT NULL,
  `RoomID` int(11) NOT NULL,
  `InstructorID` int(11) NOT NULL,
  `ServiceID` int(11) NOT NULL,
  `SchedSlots` int(11) NOT NULL,
  `SchedTime` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SchedRemaining` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`SchedID`, `SchedDays`, `RoomID`, `InstructorID`, `ServiceID`, `SchedSlots`, `SchedTime`, `date_added`, `SchedRemaining`) VALUES
(1, 'Tuesday,Thursday', 1, 1, 1, 10, '11:00 am - 01:00 pm', '2016-02-16 11:16:14', 4),
(2, 'Monday,Tuesday,Wednesday', 4, 2, 2, 20, '03:00 pm - 05:00 pm', '2016-02-21 14:58:27', 0),
(3, 'Wednesday,Saturday', 1, 1, 1, 20, '06:00 pm - 07:00 pm', '2016-02-27 16:46:06', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`ServiceID`, `ServiceName`, `ServiceDesc`, `ServiceSchedule`, `ServiceRegistrationFee`, `ServiceStatus`, `ServicePrice`, `ServiceType`, `SPID`, `serviceWalkin`, `serviceHour`, `clubpic`, `interest_id`) VALUES
(1, 'Jiujitsu pink service', 'I have pink mouse and this is pink manther', 'Monday-Friday 09:00am-10:00pm', 1000, 1, '1500', 0, 2, 300, 3, '', 36),
(2, 'Body Art', 'Body Art', 'Tuesday', 200, 1, '100', 1, 4, 100, 50, '', 3),
(3, 'Fdg', 'Dfgfg', '', 5654, 1, '45', 0, 5, 4, 45, '', 4);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `stud_id` int(11) NOT NULL,
  `stud_name` varchar(35) NOT NULL,
  `stud_age` int(11) NOT NULL,
  `stud_address` mediumtext NOT NULL,
  `relationship` varchar(50) NOT NULL,
  `client_id` int(11) NOT NULL,
  `stud_type` int(11) NOT NULL COMMENT '0:client; 1:non-client;',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`stud_id`, `stud_name`, `stud_age`, `stud_address`, `relationship`, `client_id`, `stud_type`, `date_added`) VALUES
(1, 'Cris love pink too', 39, 'pink subdivision', '0', 3, 1, '2016-02-16 11:28:13'),
(2, 'cris cubcub', 50, 'Mandaue City, Central Visayas, Philippines', '0', 3, 0, '2016-02-21 11:38:41'),
(3, 'dian', 4, 'cebu', '0', 3, 1, '2016-02-21 12:08:21'),
(4, 'a', 12, 'a', 'Sister', 3, 1, '2016-02-29 19:20:10'),
(5, 'b', 23, 'b', 'Sister', 3, 1, '2016-02-29 19:25:12'),
(6, 'das', 33, 'sda', 'Sister', 6, 1, '2016-03-04 14:01:01'),
(7, 'dfg', 34, 'sdfsdf', 'Mother', 6, 1, '2016-03-04 14:04:00');

-- --------------------------------------------------------

--
-- Table structure for table `students_enrolled`
--

CREATE TABLE IF NOT EXISTS `students_enrolled` (
  `StudEnrolledID` int(11) NOT NULL,
  `stud_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `clinic_id` int(11) NOT NULL,
  `ins_id` int(11) NOT NULL,
  `SchedID` int(11) NOT NULL,
  `StudEnrolledStatus` int(11) NOT NULL,
  `date_enrolled` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students_enrolled`
--

INSERT INTO `students_enrolled` (`StudEnrolledID`, `stud_id`, `client_id`, `service_id`, `clinic_id`, `ins_id`, `SchedID`, `StudEnrolledStatus`, `date_enrolled`) VALUES
(1, 1, 3, 1, 1, 1, 1, 1, '2016-02-16 11:28:13'),
(2, 2, 3, 1, 1, 1, 1, 1, '2016-02-21 11:38:41'),
(3, 3, 3, 1, 1, 1, 1, 0, '2016-02-21 12:08:21'),
(4, 2, 3, 2, 2, 2, 2, 1, '2016-02-21 16:11:36'),
(5, 4, 3, 1, 1, 1, 3, 0, '2016-02-29 19:20:10'),
(6, 5, 3, 1, 1, 1, 3, 0, '2016-02-29 19:25:12'),
(7, 2, 3, 1, 2, 1, 1, 0, '2016-03-03 00:22:32'),
(8, 3, 3, 1, 2, 1, 1, 0, '2016-03-03 15:37:12'),
(9, 6, 6, 1, 1, 1, 1, 1, '2016-03-04 14:01:01'),
(10, 7, 6, 1, 1, 1, 1, 1, '2016-03-04 14:04:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`SubscID`, `SubscType`, `SubscStartDate`, `SubscEndDate`, `UserID`, `SubsStatus`) VALUES
(2, 2, '2016-02-16', '2017-02-16', 2, 1),
(3, 1, '2016-02-21', '2016-03-21', 4, 0),
(4, 1, '2016-03-04', '2016-04-04', 5, 0);

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
  `tl_in` varchar(20) NOT NULL,
  `tl_out` varchar(20) DEFAULT NULL,
  `stud_id` int(11) NOT NULL,
  `SchedID` int(11) NOT NULL,
  `StudEnrolledID` int(11) NOT NULL,
  `tl_paid` int(11) NOT NULL COMMENT '0-unpaid;1-paid;2-partial',
  `service_id` int(11) NOT NULL,
  `clinic_id` int(11) NOT NULL
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
  `verify_expiry` varchar(25) NOT NULL,
  `confirmation_status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`UserID`, `UserName`, `Password`, `UserType`, `UserStatus`, `security_question_id`, `security_password`, `first_login`, `verification_code`, `verify_expiry`, `confirmation_status`) VALUES
(1, 'admin', 'a5507290a2d7b5e23d2d408410ffc626', 0, 1, 0, '', 0, '998100816', '2016-02-17 04:59:14', 0),
(2, 'rene', '99186c7ea5e48c857e1248fbc10decb9', 1, 1, 0, '', 1, '239963565', '2016-02-17 05:02:28', 0),
(3, 'cris', 'dbe3578deeb495215b304d7917bce826', 2, 1, 0, '', 1, '24564950', '2016-02-17 05:03:44', 0),
(4, 'norfelyn', 'd8624b2a737b418417e45ae460947657', 1, 1, 0, '', 0, '786850178', '2016-02-22 07:46:33', 0),
(5, 'gma7', '25f9e794323b453885f5181f1b624d0b', 1, 1, 0, '', 1, '223042818', '2016-03-05 06:53:05', 0),
(6, 'qwer', '25f9e794323b453885f5181f1b624d0b', 2, 1, 0, '', 1, '867583264', '2016-03-05 07:44:36', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
  `SPID` int(11) NOT NULL,
  `SPAddress` mediumtext NOT NULL,
  `SPContactNo` varchar(12) NOT NULL,
  `SPEmail` varchar(30) DEFAULT NULL,
  `UserID` int(11) NOT NULL,
  `splogoName` mediumtext NOT NULL,
  `spfirstname` varchar(50) NOT NULL,
  `splastname` varchar(50) NOT NULL,
  `SPRegisteredDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `spbirthday` date NOT NULL,
  `longitude` text NOT NULL,
  `latitude` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`SPID`, `SPAddress`, `SPContactNo`, `SPEmail`, `UserID`, `splogoName`, `spfirstname`, `splastname`, `SPRegisteredDate`, `spbirthday`, `longitude`, `latitude`) VALUES
(1, 'Mandaue City, Central Visayas, Philippines', '12346598', 'spoarts.cebu@gmail.com', 1, '', 'admin', 'admin', '2016-02-16 10:59:14', '1966-02-02', '123.94155180000007', '10.3402623'),
(2, 'Mandaue City, Central Visayas, Philippines', '1234567', 'rene@gmail.com', 2, 'Devil.jpg', 'rene', 'macalisang', '2016-02-16 11:02:28', '1966-07-04', '123.94155180000007', '10.3402623'),
(3, 'Mandaue City, Central Visayas, Philippines', '1234556', 'cris@gmail.com', 3, '', 'cris', 'cubcub', '2016-02-16 11:03:44', '1966-02-03', '123.94155180000007', '10.3402623'),
(4, 'Kalunasan, Cebu City, Central Visayas, Philippines', '09055475725', 'nalmonicar1988@gmail.com', 4, '', 'Norfelyn', 'Almonicar', '2016-02-21 14:46:33', '1988-12-20', '123.8774052', '10.3502923'),
(5, 'Cebu City, Central Visayas, Philippines', '1454823', 'sadas@gmail.com', 5, '', 'haas', 'jsldfjsdkl', '2016-03-04 12:53:05', '1966-03-04', '123.88543660000005', '10.3156992'),
(6, 'Verbena Capitol Suites, Don Gil Garcia Street, Cebu City, Central Visayas, Philippines', '56786876987', 'sdfdsf@yahooc.om', 6, '', 'sdfsdf', 'sdfsdf', '2016-03-04 13:44:36', '1966-03-01', '123.89019770000004', '10.3155579');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`albumID`);

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`bm_id`);

--
-- Indexes for table `client_interest`
--
ALTER TABLE `client_interest`
  ADD PRIMARY KEY (`ci_id`);

--
-- Indexes for table `clinics`
--
ALTER TABLE `clinics`
  ADD PRIMARY KEY (`clinic_id`), ADD KEY `USERID` (`UserID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`EventID`);

--
-- Indexes for table `events_enrolled`
--
ALTER TABLE `events_enrolled`
  ADD PRIMARY KEY (`EventEnrolledID`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`galleryID`);

--
-- Indexes for table `instructor_masterlist`
--
ALTER TABLE `instructor_masterlist`
  ADD PRIMARY KEY (`MasterInsID`), ADD KEY `SPID` (`UserID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`NotifID`), ADD KEY `SPID` (`SPID`);

--
-- Indexes for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `paypal_logs`
--
ALTER TABLE `paypal_logs`
  ADD PRIMARY KEY (`paypal_id`);

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`PromoID`);

--
-- Indexes for table `reviews_and_ratings`
--
ALTER TABLE `reviews_and_ratings`
  ADD PRIMARY KEY (`ReviewsID`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`RoomID`), ADD KEY `SERVICEID` (`UserID`);

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
-- Indexes for table `students_enrolled`
--
ALTER TABLE `students_enrolled`
  ADD PRIMARY KEY (`StudEnrolledID`);

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
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `albumID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `bm_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `client_interest`
--
ALTER TABLE `client_interest`
  MODIFY `ci_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `clinic_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `events_enrolled`
--
ALTER TABLE `events_enrolled`
  MODIFY `EventEnrolledID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `galleryID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `instructor_masterlist`
--
ALTER TABLE `instructor_masterlist`
  MODIFY `MasterInsID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `NotifID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `paypal_logs`
--
ALTER TABLE `paypal_logs`
  MODIFY `paypal_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `PromoID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `reviews_and_ratings`
--
ALTER TABLE `reviews_and_ratings`
  MODIFY `ReviewsID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `RoomID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `SchedID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `security_questions`
--
ALTER TABLE `security_questions`
  MODIFY `sec_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `ServiceID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `stud_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `students_enrolled`
--
ALTER TABLE `students_enrolled`
  MODIFY `StudEnrolledID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `SubscID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
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
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `SPID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
