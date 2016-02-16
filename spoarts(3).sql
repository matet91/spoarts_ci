-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2016 at 06:16 PM
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
  `clinic_id` mediumtext NOT NULL,
  `client_id` int(11) NOT NULL,
  `service_id` mediumtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`bm_id`, `clinic_id`, `client_id`, `service_id`) VALUES
(1, '1', 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `client_interest`
--

CREATE TABLE IF NOT EXISTS `client_interest` (
  `ci_id` int(11) NOT NULL,
  `interest_ids` longtext NOT NULL COMMENT 'e.g. 1,2,3,4',
  `client_id` int(11) NOT NULL COMMENT 'userid foreign key see usr_account'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_interest`
--

INSERT INTO `client_interest` (`ci_id`, `interest_ids`, `client_id`) VALUES
(1, '1,2,3,6,7,18,19,20,21,22,33,34,35,36', 3);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`clinic_id`, `UserID`, `clinic_name`, `clinic_logo`, `SPAboutMe`, `SPLocation`, `SPSubsPlan`, `SPSubsDate`, `clinic_status`, `longitude`, `latitude`) VALUES
(1, 2, 'Rene''s Pink Club', 'original.jpg', 'I have a pink mouse and i really really love it', 'Mandaue City, Central Visayas, Philippines', 0, '0000-00-00 00:00:00', 1, '123.94155180000007', '10.3402623');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`EventID`, `EventName`, `EventDesc`, `EventFor`, `EventStartDate`, `EventEndDate`, `EventLocation`, `EventStatus`, `SPID`, `TIMESTAMP`) VALUES
(1, 'My pink Life', 'story telling on how I started to like pink', '1', '2016-02-16', '2016-02-23', 'cebu', 1, 2, '2016-02-16 16:21:12');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `instructor_masterlist`
--

INSERT INTO `instructor_masterlist` (`MasterInsID`, `MasterInsName`, `MasterInsAddress`, `MasterInsContactNo`, `MasterInsEmail`, `MasterInsExpertise`, `MasterInsStatus`, `UserID`, `date_added`) VALUES
(1, 'Pink Manther', 'secret', 1234589, 'pinkmanther@gmail.com', 'i collect pink things', 1, 2, '2016-02-16 11:17:02');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promos`
--

INSERT INTO `promos` (`PromoID`, `PromoName`, `PromoDesc`, `PromoStartDate`, `PromoEndDate`, `PromoStatus`, `SPID`, `TIMESTAMP`) VALUES
(1, 'Pink Promo', 'Pink Manther ', '2016-02-24', '2016-02-29', 1, 2, '2016-02-16 16:21:36');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews_and_ratings`
--

INSERT INTO `reviews_and_ratings` (`ReviewsID`, `DatePosted`, `Message`, `Rating`, `SPID`, `EnrolledID`, `ReviewStatus`, `clinic_id`) VALUES
(1, '2016-02-16 16:56:20', 'pink is pink and not blue', 3, 3, 3, 2, 1),
(3, '2016-02-16 16:56:20', 'YUIYUiYUI', 4, 2, 3, 2, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`RoomID`, `RoomNo`, `RoomName`, `RoomStatus`, `UserID`) VALUES
(1, 12, 'Pink Room', 1, 2),
(2, 126, 'Pink Again', 1, 2),
(3, 45, 'Ilove Pink', 1, 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`SchedID`, `SchedDays`, `RoomID`, `InstructorID`, `ServiceID`, `SchedSlots`, `SchedTime`, `date_added`, `SchedRemaining`) VALUES
(1, 'Tuesday,Thursday', 1, 1, 1, 10, '11:00 am - 01:00 pm', '2016-02-16 11:16:14', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`ServiceID`, `ServiceName`, `ServiceDesc`, `ServiceSchedule`, `ServiceRegistrationFee`, `ServiceStatus`, `ServicePrice`, `ServiceType`, `SPID`, `serviceWalkin`, `serviceHour`, `clubpic`, `interest_id`) VALUES
(1, 'Jiujitsu pink service', 'I have pink mouse and this is pink manther', 'Monday-Friday 09:00am-10:00pm', 1000, 1, '1500', 0, 2, 300, 3, '', 36);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `stud_id` int(11) NOT NULL,
  `stud_name` varchar(35) NOT NULL,
  `stud_age` int(11) NOT NULL,
  `stud_address` mediumtext NOT NULL,
  `client_id` int(11) NOT NULL,
  `stud_type` int(11) NOT NULL COMMENT '0:client; 1:non-client;',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`stud_id`, `stud_name`, `stud_age`, `stud_address`, `client_id`, `stud_type`, `date_added`) VALUES
(1, 'Cris love pink too', 39, 'pink subdivision', 3, 1, '2016-02-16 11:28:13');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students_enrolled`
--

INSERT INTO `students_enrolled` (`StudEnrolledID`, `stud_id`, `client_id`, `service_id`, `clinic_id`, `ins_id`, `SchedID`, `StudEnrolledStatus`, `date_enrolled`) VALUES
(1, 1, 3, 1, 1, 1, 1, 1, '2016-02-16 11:28:13');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`SubscID`, `SubscType`, `SubscStartDate`, `SubscEndDate`, `UserID`, `SubsStatus`) VALUES
(2, 2, '2016-02-16', '2017-02-16', 2, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`UserID`, `UserName`, `Password`, `UserType`, `UserStatus`, `security_question_id`, `security_password`, `first_login`, `verification_code`, `verify_expiry`, `confirmation_status`) VALUES
(1, 'admin', 'a5507290a2d7b5e23d2d408410ffc626', 0, 1, 0, '', 0, '998100816', '2016-02-17 04:59:14', 0),
(2, 'rene', '99186c7ea5e48c857e1248fbc10decb9', 1, 1, 0, '', 0, '239963565', '2016-02-17 05:02:28', 0),
(3, 'cris', 'dbe3578deeb495215b304d7917bce826', 2, 1, 0, '', 1, '24564950', '2016-02-17 05:03:44', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`SPID`, `SPAddress`, `SPContactNo`, `SPEmail`, `UserID`, `splogoName`, `spfirstname`, `splastname`, `SPRegisteredDate`, `spbirthday`, `longitude`, `latitude`) VALUES
(1, 'Mandaue City, Central Visayas, Philippines', '12346598', 'spoarts.cebu@gmail.com', 1, '', 'admin', 'admin', '2016-02-16 10:59:14', '1966-02-02', '123.94155180000007', '10.3402623'),
(2, 'Mandaue City, Central Visayas, Philippines', '1234567', 'rene@gmail.com', 2, 'Devil.jpg', 'rene', 'macalisang', '2016-02-16 11:02:28', '1966-07-04', '123.94155180000007', '10.3402623'),
(3, 'Mandaue City, Central Visayas, Philippines', '1234556', 'cris@gmail.com', 3, '', 'cris', 'cubcub', '2016-02-16 11:03:44', '1966-02-03', '123.94155180000007', '10.3402623');

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`NotifID`), ADD KEY `CLIENTID` (`ClientID`), ADD KEY `SPID` (`SPID`);

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
-- AUTO_INCREMENT for table `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `bm_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `client_interest`
--
ALTER TABLE `client_interest`
  MODIFY `ci_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `clinic_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `instructor_masterlist`
--
ALTER TABLE `instructor_masterlist`
  MODIFY `MasterInsID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
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
-- AUTO_INCREMENT for table `paypal_logs`
--
ALTER TABLE `paypal_logs`
  MODIFY `paypal_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `PromoID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `reviews_and_ratings`
--
ALTER TABLE `reviews_and_ratings`
  MODIFY `ReviewsID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `RoomID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `SchedID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `security_questions`
--
ALTER TABLE `security_questions`
  MODIFY `sec_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `ServiceID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `stud_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `students_enrolled`
--
ALTER TABLE `students_enrolled`
  MODIFY `StudEnrolledID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `SubscID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
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
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `SPID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
