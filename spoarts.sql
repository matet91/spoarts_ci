-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2016 at 08:32 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`bm_id`, `clinic_id`, `client_id`, `service_id`) VALUES
(1, '1,3', 3, ''),
(2, '2', 6, ''),
(3, '1,2', 10, '');

-- --------------------------------------------------------

--
-- Table structure for table `client_interest`
--

CREATE TABLE IF NOT EXISTS `client_interest` (
  `ci_id` int(11) NOT NULL,
  `interest_ids` longtext NOT NULL COMMENT 'e.g. 1,2,3,4',
  `client_id` int(11) NOT NULL COMMENT 'userid foreign key see usr_account'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_interest`
--

INSERT INTO `client_interest` (`ci_id`, `interest_ids`, `client_id`) VALUES
(1, '1,2,3,6,7,18,19,20,21,22,33,34,35,36', 3),
(2, '31', 6),
(3, '1,2', 10),
(4, '35', 11),
(5, '37', 11);

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
(2, 9, 'JanClub', 'gym_07.jpg', 'Just a club', 'Cebu IT Park, Cebu City, Central Visayas, Philippines', 0, '0000-00-00 00:00:00', 1, '123.90739229999997', '10.3304499'),
(3, 12, 'Leane', 'Penguins.jpg', 'My club', 'Talamban, Cebu City, Central Visayas, Philippines', 0, '0000-00-00 00:00:00', 1, '123.91739230000007', '10.3670682');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`EventID`, `EventName`, `EventDesc`, `EventFor`, `EventStartDate`, `EventEndDate`, `EventLocation`, `EventStatus`, `SPID`, `TIMESTAMP`) VALUES
(1, 'My pink Life', 'story telling on how I started to like pink', '1', '2016-02-16', '2016-02-23', 'cebu', 1, 2, '2016-02-16 16:21:12'),
(2, 'reer', 'rereff', '1', '2016-02-11', '2016-02-11', 'cebu', 0, 2, '2016-02-18 07:56:46'),
(3, 'ds', 'sas', '', '2016-02-03', '2016-02-04', 'sa', 0, 9, '2016-02-18 18:32:57'),
(4, 'Karate kid', 'Karatel ug dagan me', '4', '2016-02-19', '2016-02-27', 'cebu', 1, 9, '2016-02-18 18:34:29'),
(5, 'Boxing', 'Just Boxing', '2', '2016-02-19', '2016-02-21', 'cebu', 1, 9, '2016-02-18 18:35:15'),
(6, 'wewew', 'wewew', '5', '2016-02-19', '2016-02-27', 'cebu', 1, 2, '2016-02-20 09:58:50');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events_enrolled`
--

INSERT INTO `events_enrolled` (`EventEnrolledID`, `EventID`, `stud_id`, `client_id`, `clinic_id`, `EventEnrolledStatus`, `dateEnrolled`) VALUES
(1, 4, 1, 3, 2, 0, '2016-02-21 14:00:59'),
(2, 4, 2, 3, 2, 0, '2016-02-21 14:01:38'),
(3, 4, 2, 3, 2, 0, '2016-02-21 14:05:31'),
(4, 4, 2, 3, 2, 0, '2016-02-21 14:06:15');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `instructor_masterlist`
--

INSERT INTO `instructor_masterlist` (`MasterInsID`, `MasterInsName`, `MasterInsAddress`, `MasterInsContactNo`, `MasterInsEmail`, `MasterInsExpertise`, `MasterInsStatus`, `UserID`, `date_added`) VALUES
(1, 'Pink Manther', 'secret', 1234589, 'pinkmanther@gmail.com', 'i collect pink things', 1, 2, '2016-02-16 11:17:02'),
(2, 'Jorge ongsasasa', 'subangdaku mandaue', 234567, 'noemailsas', 'dancingsas', 1, 9, '2016-02-19 02:24:16'),
(4, 'jason juntong', 'cebu city cebu city cebu citycebu citycebu city cebu city ce', 23456, 'email', 'none', 1, 9, '2016-02-19 02:31:07'),
(5, 'nikita', 'ambot', 189083, 'ambot@gmail.com', 'hfwekfekw', 1, 12, '2016-02-21 13:12:42'),
(6, 'ckuan', 'kuan', 189348, 'kuan@gmail.com', 'wala', 1, 12, '2016-02-21 13:16:39');

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
  `Message` mediumtext NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ClientID` int(11) NOT NULL,
  `SPID` int(11) NOT NULL,
  `NotifStatus` int(11) NOT NULL COMMENT '0:not read; 1:read;'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`NotifID`, `Subject`, `Message`, `DateCreated`, `ClientID`, `SPID`, `NotifStatus`) VALUES
(1, 'New Event', 'Event test has been added by Jiujitsu pink service', '2016-02-21 00:00:00', 1, 2, 0),
(2, 'New Event', 'Event test has been added by Jiujitsu pink service', '2016-02-21 00:00:00', 3, 2, 1),
(4, 'Time In/Out', 'hihi just logged in today 2016-02-22 01:59:35 [Leane-Wqwr]', '0000-00-00 00:00:00', 3, 12, 1),
(5, 'Time In/Out', 'hihi just logged out today 2016-02-22 02:00:25 [Leane-Wqwr]', '0000-00-00 00:00:00', 3, 12, 1),
(6, 'Session Payment 2016-02-22 02:03:02', 'Paid Today with amount of 220 and outstanding balance of 20 [ Rene''s Pink Club-Jiujitsu pink service ] ', '2016-02-22 14:03:02', 3, 12, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_logs`
--

INSERT INTO `payment_logs` (`payment_id`, `payment_amt`, `payment_date`, `payment_type`, `payment_balance`, `stud_id`, `client_id`, `payment_desc`, `payment_end_date`, `SchedID`, `UserID`, `service_id`, `date_added`, `last_updated`) VALUES
(1, '34', '2016-02-18 04:09:08', 1, '45', 1, 3, 'fdf', '2016-03-18 04:09:08', 1, 2, 1, '2016-02-18 16:09:08', '0000-00-00 00:00:00'),
(2, '200', '2016-02-19 09:59:36', 2, '00', 18, 11, 'membership', '0000-00-00 00:00:00', 4, 9, 2, '2016-02-19 02:59:36', '2016-02-20 03:32:54'),
(3, '30', '2016-02-19 03:00:44', 0, '00', 19, 11, 'session', '2016-02-19 03:00:44', 4, 9, 2, '2016-02-19 03:00:44', '2016-02-20 03:22:35'),
(4, '100', '2016-02-19 03:01:36', 1, '00', 19, 11, 'monthly', '2016-03-19 03:01:36', 4, 9, 2, '2016-02-19 03:01:36', '2016-02-20 03:37:57'),
(5, '200', '2016-02-22 11:34:05', 0, '0', 18, 11, 'paid', '2016-02-22 11:34:05', 1, 2, 1, '2016-02-22 11:34:06', '0000-00-00 00:00:00'),
(6, '2000', '2016-02-22 11:35:07', 1, '0', 19, 11, 'paid monthly', '2016-03-22 11:35:07', 1, 2, 1, '2016-02-22 11:35:07', '0000-00-00 00:00:00'),
(7, '220', '2016-02-22 02:03:02', 0, '20', 21, 3, 'paid', '2016-02-22 02:03:02', 10, 12, 7, '2016-02-22 14:03:02', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paypal_logs`
--

INSERT INTO `paypal_logs` (`paypal_id`, `transaction_id`, `UserID`, `paypal_amount`, `paypal_invoice`, `buyer_name`, `paypal_createTime`) VALUES
(1, '3WF45874VA242582C', 2, 1500, '56c34a95b673e', 'rene macalisang', '2016-02-16 16:13:15'),
(2, '39P01599VE932810J', 9, 1500, '56c60a2034b83', 'rene macalisang', '2016-02-18 18:14:39');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promos`
--

INSERT INTO `promos` (`PromoID`, `PromoName`, `PromoDesc`, `PromoStartDate`, `PromoEndDate`, `PromoStatus`, `SPID`, `TIMESTAMP`) VALUES
(1, 'Pink Promo', 'Pink Manther ', '2016-02-24', '2016-02-29', 1, 2, '2016-02-16 16:21:36'),
(2, 'new promo', 'new promo new promo new promo new promo new promo new promo new promo', '2016-02-19', '2016-02-22', 1, 9, '2016-02-18 18:35:54'),
(3, 'old promo', 'oldest promo', '2016-02-20', '2016-02-27', 1, 9, '2016-02-18 18:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `relationship_status`
--

CREATE TABLE IF NOT EXISTS `relationship_status` (
  `relationship_id` int(11) NOT NULL,
  `relationship_name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `relationship_status`
--

INSERT INTO `relationship_status` (`relationship_id`, `relationship_name`) VALUES
(1, 'Mother'),
(2, 'Father'),
(3, 'Bother'),
(4, 'Sister'),
(5, 'Relative');

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews_and_ratings`
--

INSERT INTO `reviews_and_ratings` (`ReviewsID`, `DatePosted`, `Message`, `Rating`, `SPID`, `EnrolledID`, `ReviewStatus`, `clinic_id`) VALUES
(1, '2016-02-16 16:56:20', 'pink is pink and not blue', 3, 3, 3, 2, 1),
(3, '2016-02-19 08:54:52', 'YUIYUiYUI', 1, 2, 3, 2, 1),
(4, '2016-02-18 08:07:46', 'Hallooo me', 3, 2, 3, 2, 1),
(5, '2016-02-18 09:15:27', 'halllllllllllssdsdsdsd', 4, 2, 3, 2, 0),
(6, '2016-02-19 07:54:13', 'Bati ug service', 2, 2, 3, 2, 1),
(8, '2016-02-19 07:09:30', 'mobile comment rene here.', 3, 2, 3, 2, 0),
(10, '2016-02-19 07:16:05', 'my comment', 5, 9, 3, 2, 0),
(11, '2016-02-19 08:20:16', 'bati inyo gym', 1, 9, 3, 2, 0),
(12, '2016-02-19 09:03:39', 'caraa oi bisay bate caraa oi bisay bate caraa oi bisay bate caraa oi bisay batecaraa oi bisay bate caraa oi bisay bate\r\ncaraa oi bisay bate caraa oi bisay bate caraa oi bisay bate caraa oi bisay batec', 4, 2, 3, 2, 0),
(13, '2016-02-18 19:02:05', 'Yes', 3, 9, 3, 0, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`RoomID`, `RoomNo`, `RoomName`, `RoomStatus`, `UserID`) VALUES
(1, 12, 'Pink Room', 1, 2),
(2, 126, 'Pink Again', 1, 2),
(3, 45, 'Ilove Pink', 1, 2),
(4, 1, 'Room11', 1, 9),
(6, 511, 'room22', 1, 9),
(8, 12, 'dsio', 1, 12),
(9, 1, 'dsio', 1, 12),
(10, 14, 'hello', 1, 12);

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
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`SchedID`, `SchedDays`, `RoomID`, `InstructorID`, `ServiceID`, `SchedSlots`, `SchedTime`, `date_added`, `SchedRemaining`) VALUES
(1, 'Tuesday,Thursday', 1, 1, 1, 10, '11:00 am - 01:00 pm', '2016-02-16 11:16:14', 4),
(3, 'Monday,Wednesday', 4, 2, 2, 20, '03:00 am - 04:00 am', '2016-02-19 02:24:58', 0),
(4, 'Wednesday,Thursday', 4, 2, 2, 30, '02:00 am - 03:00 am', '2016-02-19 02:28:35', 1),
(5, 'Monday,Tuesday', 6, 4, 4, 20, '03:00 am - 04:00 am', '2016-02-19 02:31:36', 2),
(6, 'Monday,Wednesday', 1, 1, 5, 12, '11:00 am - 01:00 pm', '2016-02-21 11:16:07', 1),
(7, 'Monday,Wednesday', 10, 6, 6, 11, '01:00 pm - 04:00 pm', '2016-02-21 12:49:23', 1),
(8, 'Monday,Wednesday,Thursday', 8, 5, 6, 12, '02:00 pm - 05:00 pm', '2016-02-21 12:53:08', 1),
(10, 'Monday,Tuesday', 10, 6, 7, 12, '05:00 pm - 07:00 pm', '2016-02-21 15:03:15', 1),
(11, 'Tuesday,Friday', 8, 6, 6, 12, '01:00 pm - 03:00 pm', '2016-02-21 15:05:34', 0),
(12, 'Friday', 9, 5, 6, 12, '04:00 pm - 05:00 pm', '2016-02-21 15:08:26', 1),
(27, 'Monday,Tuesday', 1, 1, 1, 12, '11:00 am - 06:00 pm', '2016-02-21 21:34:40', 0),
(76, 'Monday,Wednesday', 1, 1, 1, 12, '06:00 pm - 07:00 pm', '2016-02-22 07:55:45', 0),
(87, 'Monday', 1, 1, 5, 12, '10:00 am - 11:00 am', '2016-02-22 08:48:35', 1),
(88, 'Monday', 1, 1, 5, 12, '08:00 pm - 09:00 pm', '2016-02-22 08:49:30', 0);

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
  `interest_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`ServiceID`, `ServiceName`, `ServiceDesc`, `ServiceSchedule`, `ServiceRegistrationFee`, `ServiceStatus`, `ServicePrice`, `ServiceType`, `SPID`, `serviceWalkin`, `serviceHour`, `interest_id`) VALUES
(1, 'Jiujitsu pink service', 'I have pink mouse and this is pink manther', 'Monday-Friday 09:00am-10:00pm', 1000, 1, '1500', 0, 2, 300, 3, 36),
(2, 'Dancing queen', 'Dancing me', 'Monday-sunday', 50, 1, '100', 1, 9, 50, 3, 9),
(4, 'Paint', 'Just paint', 'Monday-sunday', 50, 1, '300', 1, 9, 2, 3, 1),
(5, 'Server', 'Server', 'M-s', 50, 1, '100', 0, 2, 3, 3, 29),
(6, 'Animated', 'Hello', 'We', 35, 1, '2455', 1, 12, 55, 1, 1),
(7, 'Wqwr', 'Asdwe', 'Ew', 232, 1, '4667', 0, 12, 244, 4, 29),
(8, 'Climbing', 'Hffdkgfd2', '233dfsfe', 323, 1, '201020', 0, 2, 3334, 552, 34),
(11, 'Climbing', 'Sdfdsffdsf1', '3sdff', 22444, 1, '33444', 1, 2, 44442, 23, 1);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `stud_id` int(11) NOT NULL,
  `stud_name` varchar(35) NOT NULL,
  `stud_age` int(11) NOT NULL,
  `stud_address` mediumtext NOT NULL,
  `stud_relationship` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `stud_type` int(11) NOT NULL COMMENT '0:client; 1:non-client;',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`stud_id`, `stud_name`, `stud_age`, `stud_address`, `stud_relationship`, `client_id`, `stud_type`, `date_added`) VALUES
(18, 'jarson bus', 2, 'Cebu IT Park, Cebu City, Central Visayas, Philippines', 0, 11, 1, '2016-02-19 05:02:00'),
(19, 'Rene', 23, 'Cebu Business Park, Cebu City, Central Visayas, Philippines', 0, 11, 1, '2016-02-19 05:02:17'),
(20, 'chauncey', 12, 'edew', 0, 3, 1, '2016-02-21 11:05:17'),
(21, 'hihi', 12, 'hihi', 0, 3, 1, '2016-02-21 15:14:43'),
(22, 'Cris Cubcuban', 50, 'Mandaue City, Central Visayas, Philippines', 0, 3, 0, '2016-02-22 09:53:34');

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
  `StudEnrolledStatus` int(11) NOT NULL COMMENT '0 pending;i active;2disapprove',
  `date_enrolled` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students_enrolled`
--

INSERT INTO `students_enrolled` (`StudEnrolledID`, `stud_id`, `client_id`, `service_id`, `clinic_id`, `ins_id`, `SchedID`, `StudEnrolledStatus`, `date_enrolled`) VALUES
(19, 18, 11, 1, 1, 1, 1, 1, '2016-02-19 05:02:00'),
(20, 19, 11, 1, 1, 1, 1, 1, '2016-02-19 05:02:17'),
(21, 20, 3, 1, 1, 1, 1, 1, '2016-02-21 11:05:17'),
(22, 21, 3, 6, 3, 6, 7, 0, '2016-02-21 15:14:43'),
(26, 21, 3, 6, 3, 5, 8, 1, '2016-02-21 15:36:30'),
(27, 21, 3, 7, 3, 6, 10, 1, '2016-02-21 15:48:09'),
(28, 21, 3, 1, 1, 1, 1, 1, '2016-02-22 08:57:16'),
(29, 21, 3, 5, 1, 1, 6, 1, '2016-02-22 09:49:47'),
(30, 21, 3, 5, 1, 1, 87, 1, '2016-02-22 09:50:56'),
(31, 22, 3, 6, 3, 5, 8, 0, '2016-02-22 09:53:34'),
(34, 22, 3, 6, 3, 6, 7, 1, '2016-02-22 10:02:36'),
(35, 21, 3, 6, 3, 5, 12, 1, '2016-02-22 10:10:08'),
(36, 21, 3, 6, 3, 6, 11, 0, '2016-02-22 11:45:05');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE IF NOT EXISTS `subscriptions` (
  `SubscID` int(11) NOT NULL,
  `SubscType` int(11) NOT NULL COMMENT '1 trial;2 premium',
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
(3, 2, '2016-02-18', '2016-02-19', 9, 1),
(4, 1, '2016-02-21', '2016-03-21', 12, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `time_logs`
--

INSERT INTO `time_logs` (`tl_id`, `tl_in`, `tl_out`, `stud_id`, `SchedID`, `StudEnrolledID`, `tl_paid`, `service_id`, `clinic_id`) VALUES
(1, '2016-02-18 04:09:29', '2016-02-18 07:24:39', 1, 1, 1, 2, 1, 1),
(2, '2016-02-19 02:58:56', '2016-02-19 02:58:59', 6, 4, 6, 1, 2, 2),
(3, '2016-02-22 11:33:33', '2016-02-22 11:33:36', 18, 1, 19, 1, 1, 1),
(4, '2016-02-22 11:34:38', '2016-02-22 11:34:40', 19, 1, 20, 1, 1, 1),
(6, '2016-02-22 01:59:35', '2016-02-22 02:00:24', 21, 10, 27, 2, 7, 3);

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
  `first_login` int(11) NOT NULL COMMENT '0-firstlogin;1-alreadyloginMultipleTimes',
  `verification_code` varchar(10) NOT NULL,
  `verify_expiry` varchar(25) NOT NULL,
  `confirmation_status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`UserID`, `UserName`, `Password`, `UserType`, `UserStatus`, `first_login`, `verification_code`, `verify_expiry`, `confirmation_status`) VALUES
(1, 'admin', 'a5507290a2d7b5e23d2d408410ffc626', 0, 1, 0, '998100816', '2016-02-17 04:59:14', 0),
(2, 'rene', '99186c7ea5e48c857e1248fbc10decb9', 1, 1, 0, '239963565', '2016-02-17 05:02:28', 0),
(3, 'cris', 'dbe3578deeb495215b304d7917bce826', 2, 1, 1, '24564950', '2016-02-17 05:03:44', 0),
(4, 're', '25d55ad283aa400af464c76d713c07ad', 2, 0, 0, '688841267', '2016-02-19 09:47:50', 0),
(5, 'u', '25d55ad283aa400af464c76d713c07ad', 2, 1, 0, '199255958', '2016-02-19 11:10:34', 1),
(6, 'kimmayorga', 'c2cad1acd5a253cb0471ad9e6bb93c71', 2, 1, 1, '1002100142', '2016-02-19 11:20:07', 1),
(7, 'y', '25d55ad283aa400af464c76d713c07ad', 2, 0, 0, '498739877', '2016-02-19 11:21:07', 0),
(8, 'me', '25d55ad283aa400af464c76d713c07ad', 2, 0, 0, '7063844', '2016-02-19 06:35:45', 0),
(9, 'jan', '25d55ad283aa400af464c76d713c07ad', 1, 1, 0, '1391534521', '2016-02-19 07:06:34', 0),
(10, 'james', '25d55ad283aa400af464c76d713c07ad', 2, 1, 1, '12750494', '2016-02-19 07:40:03', 0),
(11, 'we', '25d55ad283aa400af464c76d713c07ad', 2, 1, 1, '159544863', '2016-02-20 04:27:06', 1),
(12, 'leane', '6ccb78fe8a9c973f210b78ca7b72c9f8', 1, 1, 0, '1174359474', '2016-02-22 05:43:06', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`SPID`, `SPAddress`, `SPContactNo`, `SPEmail`, `UserID`, `splogoName`, `spfirstname`, `splastname`, `SPRegisteredDate`, `spbirthday`, `longitude`, `latitude`) VALUES
(1, 'Mandaue City, Central Visayas, Philippines', '12346598', 'spoarts.cebu@gmail.com', 1, '', 'admin', 'admin', '2016-02-16 10:59:14', '1966-02-02', '123.94155180000007', '10.3402623'),
(2, 'Mandaue City, Central Visayas, Philippines', '1234567', 'rene@gmail.com', 2, 'Devil.jpg', 'rene', 'macalisang', '2016-02-16 11:02:28', '1966-07-04', '123.94155180000007', '10.3402623'),
(3, 'Mandaue City, Central Visayas, Philippines', '1234556', 'cris@gmail.com', 3, 'Koala.jpg', 'Cris', 'Cubcuban', '2016-02-16 11:03:44', '1966-02-03', '123.94155180000007', '10.3402623'),
(4, 'cebu city', '232323', 'renzjan2014@yahoo.com', 4, '', 'love', 'loving', '2016-02-18 16:47:50', '2016-10-14', '', ''),
(5, 'cebu', 's', 'hf', 5, '', 'hfs', 'f', '2016-02-18 18:10:34', '2017-02-18', '', ''),
(6, 'Talisay City, Central Visayas, Philippines', '09332514781', 'kim_mayorga@yahoo.com', 6, '', 'kim', 'mayorga', '2016-02-18 18:20:07', '1994-11-14', '123.82996389999994', '10.2569872'),
(7, 'Subangdaku, Mandaue City, Central Visayas, Philippines', 's', 'dd', 7, '', 'f', 'x', '2016-02-18 18:21:07', '2016-02-18', '123.92761070000006', '10.320215'),
(8, 'Cebu Veterans Drive, Cebu City, Central Visayas, Philippines', '234567', 'renz@yahoo.com', 8, '', 'James', 'red', '2016-02-19 01:35:46', '2016-10-10', '123.89404939999997', '10.3437121'),
(9, 'Cebu Veterans Drive, Cebu City, Central Visayas, Philippines', '234-5566', 'renzmac2014@yahoo.com', 9, 'large.jpg', 'Jannette', 'Cnasa', '2016-02-19 02:06:35', '1966-02-10', '123.89404939999997', '10.3437121'),
(10, 'Cebu Metropolitan Cathedral, Cebu City, Central Visayas, Philippines', '234554545', 'renzmac2014@yahoo.com', 10, 'ariana.jpg', 'James', 'margot', '2016-02-19 02:40:03', '1981-07-25', '123.90177199999994', '10.295534'),
(11, 'Cebu IT Park, Cebu City, Central Visayas, Philippines', '234-4567', 'vbbb', 11, 'main_11.jpg', 'jarson', 'bus', '2016-02-19 23:27:06', '2014-10-20', '123.90739229999997', '10.3304499'),
(12, 'Talamban, Cebu City, Central Visayas, Philippines', '123456', 'leane@gmail.com', 12, 'Tulips.jpg', 'leane', 'Ardoza', '2016-02-21 12:43:06', '1966-02-01', '123.91739230000007', '10.3670682');

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
-- Indexes for table `interest`
--
ALTER TABLE `interest`
  ADD PRIMARY KEY (`interest_id`);

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
-- Indexes for table `relationship_status`
--
ALTER TABLE `relationship_status`
  ADD PRIMARY KEY (`relationship_id`);

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
  MODIFY `bm_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `client_interest`
--
ALTER TABLE `client_interest`
  MODIFY `ci_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `clinic_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `events_enrolled`
--
ALTER TABLE `events_enrolled`
  MODIFY `EventEnrolledID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `galleryID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `instructor_masterlist`
--
ALTER TABLE `instructor_masterlist`
  MODIFY `MasterInsID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `interest`
--
ALTER TABLE `interest`
  MODIFY `interest_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `NotifID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `paypal_logs`
--
ALTER TABLE `paypal_logs`
  MODIFY `paypal_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `PromoID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `relationship_status`
--
ALTER TABLE `relationship_status`
  MODIFY `relationship_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `reviews_and_ratings`
--
ALTER TABLE `reviews_and_ratings`
  MODIFY `ReviewsID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `RoomID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `SchedID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `ServiceID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `stud_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `students_enrolled`
--
ALTER TABLE `students_enrolled`
  MODIFY `StudEnrolledID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
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
  MODIFY `tl_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `SPID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
