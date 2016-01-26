-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2016 at 12:15 AM
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
-- Table structure for table `attendees`
--

CREATE TABLE IF NOT EXISTS `attendees` (
  `AttendeeID` int(11) NOT NULL,
  `AttendeeTimeIn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `AttendeeStatus` int(11) NOT NULL,
  `SchedID` int(11) NOT NULL,
  `EnrolledID` int(11) NOT NULL,
  `liug` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `EventID` int(11) NOT NULL,
  `EventName` varchar(50) NOT NULL,
  `EventDesc` varchar(60) NOT NULL,
  `EventDate` date NOT NULL,
  `EventLocation` varchar(60) NOT NULL,
  `EventStatus` int(11) NOT NULL,
  `EventPrice` decimal(10,0) NOT NULL,
  `SPID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gallary`
--

CREATE TABLE IF NOT EXISTS `gallary` (
  `gal_id` int(11) NOT NULL,
  `gal_title` varchar(100) NOT NULL,
  `gal_name` varchar(50) NOT NULL,
  `gal_image` longblob NOT NULL,
  `SPID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallary`
--

INSERT INTO `gallary` (`gal_id`, `gal_title`, `gal_name`, `gal_image`, `SPID`) VALUES
(120, '', 'ariana.jpg', '', 21),
(121, '', 'ariana.jpg', '', 21),
(122, '', 'ariana.jpg', '', 21),
(123, '', 'ariana.jpg', '', 21),
(124, '', 'ariana.jpg', '', 21),
(125, '', 'ariana.jpg', '', 21),
(126, '', 'ariana.jpg', '', 21),
(127, '', 'ariana.jpg', '', 21),
(128, '', 'ariana.jpg', '', 21),
(129, '', 'ariana.jpg', '', 21),
(130, '', 'ariana.jpg', '', 21),
(131, '', 'ariana.jpg', '', 21),
(132, '', '68yooseungho29.jpg', '', 25);

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE IF NOT EXISTS `instructors` (
  `InstructorID` int(11) NOT NULL,
  `InstructorStatus` int(11) NOT NULL,
  `MasterInsID` int(11) NOT NULL,
  `ServiceID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `MemberID` int(11) NOT NULL,
  `MemberName` varchar(100) NOT NULL,
  `MemberAddress` varchar(200) NOT NULL,
  `MemberAge` int(11) NOT NULL,
  `MemberEnrolled` date NOT NULL,
  `ClientID` int(11) NOT NULL,
  `SPID` int(11) NOT NULL,
  `MemberStatus` tinyint(2) NOT NULL COMMENT '0: Inactive; 1: Active;'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`MemberID`, `MemberName`, `MemberAddress`, `MemberAge`, `MemberEnrolled`, `ClientID`, `SPID`, `MemberStatus`) VALUES
(1, 'Norf', 'Cebu', 27, '2016-01-26', 11, 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `members_services_enrolled`
--

CREATE TABLE IF NOT EXISTS `members_services_enrolled` (
  `MSEID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `ServiceID` int(11) NOT NULL,
  `SPID` int(11) NOT NULL,
  `MESstatus` tinyint(4) NOT NULL COMMENT '0: Inactive; 1: Active;'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `my_clinics`
--

CREATE TABLE IF NOT EXISTS `my_clinics` (
  `myClinicID` int(11) NOT NULL,
  `SPID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `my_clinics`
--

INSERT INTO `my_clinics` (`myClinicID`, `SPID`, `ClientID`) VALUES
(1, 21, 9),
(2, 22, 9);

-- --------------------------------------------------------

--
-- Table structure for table `my_interests`
--

CREATE TABLE IF NOT EXISTS `my_interests` (
  `myInterestID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `ServiceID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `myinterestName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `PaymentID` int(11) NOT NULL,
  `PaymentAmt` int(10) NOT NULL,
  `PaymentDate` date NOT NULL,
  `PaymentDesc` varchar(60) NOT NULL,
  `PaymentBalance` int(10) NOT NULL,
  `SubscID` int(11) NOT NULL,
  `SPID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_logs`
--

CREATE TABLE IF NOT EXISTS `payment_logs` (
  `PLID` int(11) NOT NULL,
  `PLAmt` int(10) NOT NULL,
  `PLDate` date NOT NULL,
  `PLDesc` varchar(60) NOT NULL,
  `PLBalance` int(11) NOT NULL,
  `ServiceID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `EnrolledID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `promos`
--

CREATE TABLE IF NOT EXISTS `promos` (
  `PromoID` int(11) NOT NULL,
  `PromoName` varchar(50) NOT NULL,
  `PromoDesc` varchar(60) NOT NULL,
  `PromoTerm` varchar(20) NOT NULL,
  `PromoStatus` int(11) NOT NULL,
  `SPID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `EnrolledID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `SchedStartTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SchedStatus` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `RoomID` int(11) NOT NULL,
  `InstructorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `ServicePrice` decimal(10,0) NOT NULL,
  `ServiceType` int(2) NOT NULL COMMENT '0: Sports; 1: Arts;',
  `SPID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`ServiceID`, `ServiceName`, `ServiceDesc`, `ServiceSchedule`, `ServiceRegistrationFee`, `ServiceStatus`, `ServicePrice`, `ServiceType`, `SPID`) VALUES
(1, 'Taekwando', 'Binonogay na', 'Monday-Saturday 08:00am - 09:00pm', 500, 1, '200', 1, 21),
(2, 'Karate Kid', 'pinutlanay ug tiil', 'Monday-Saturday 08:00am - 09:00pm', 500, 1, '400', 1, 22),
(3, 'asdsdsds', 'dsd', 'Monday-Saturday 08:00am - 09:00pm', 500, 1, '300', 1, 23),
(4, 'Patire', 'rer', 'Monday-Saturday 08:00am - 09:00pm', 500, 1, '234', 1, 24),
(5, 'Taekwando', 'dsd', 'Monday-Saturday 08:00am - 09:00pm', 500, 1, '233', 1, 21),
(7, 'Test', 'desc', 'schedule', 144, 1, '54', 1, 21);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE IF NOT EXISTS `subscriptions` (
  `SubscID` int(11) NOT NULL,
  `SubscType` varchar(20) NOT NULL,
  `SubscPrice` decimal(10,0) NOT NULL,
  `SubscStartDate` date NOT NULL,
  `SubscEndDate` date NOT NULL,
  `SubscStatus` int(11) NOT NULL,
  `PlanID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`SubscID`, `SubscType`, `SubscPrice`, `SubscStartDate`, `SubscEndDate`, `SubscStatus`, `PlanID`, `UserID`, `status`) VALUES
(5, 'Trial', '0', '2016-01-14', '2016-02-14', 1, 1, 27, 0),
(6, 'Trial', '0', '2016-01-15', '2016-02-15', 1, 1, 28, 0),
(7, 'Trial', '0', '2016-01-15', '2016-02-15', 1, 1, 29, 0),
(8, 'Trial', '0', '2016-01-15', '2016-02-15', 1, 1, 30, 0),
(9, 'Trial', '0', '2016-01-19', '2016-02-19', 1, 1, 32, 0),
(10, 'Trial', '0', '2016-01-21', '2016-02-21', 1, 1, 33, 0);

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
(1, 'Trial', 'Free Trial', 'one month', '0'),
(2, 'Premium', 'Premium Subscription', 'one year', '5000');

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE IF NOT EXISTS `user_accounts` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Password` longtext NOT NULL,
  `UserType` int(20) NOT NULL COMMENT '0-admin, 1-service_provide, 2-client',
  `UserStatus` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`UserID`, `UserName`, `Password`, `UserType`, `UserStatus`) VALUES
(26, 'fire', '1ys30jU5v/S1WbbHTgNULiRrxbV5rJim6tCo2sDGy0mA0Hik3CYfxdgXlGIf4UnxlEgD0qdoP5WSrDxAtrdm4Q==', 0, 1),
(27, 'urgillo', '1ys30jU5v/S1WbbHTgNULiRrxbV5rJim6tCo2sDGy0mA0Hik3CYfxdgXlGIf4UnxlEgD0qdoP5WSrDxAtrdm4Q==', 1, 1),
(28, 'urgillo2', '1ys30jU5v/S1WbbHTgNULiRrxbV5rJim6tCo2sDGy0mA0Hik3CYfxdgXlGIf4UnxlEgD0qdoP5WSrDxAtrdm4Q==', 1, 1),
(29, 'r', '1ys30jU5v/S1WbbHTgNULiRrxbV5rJim6tCo2sDGy0mA0Hik3CYfxdgXlGIf4UnxlEgD0qdoP5WSrDxAtrdm4Q==', 1, 1),
(30, 'v', '1ys30jU5v/S1WbbHTgNULiRrxbV5rJim6tCo2sDGy0mA0Hik3CYfxdgXlGIf4UnxlEgD0qdoP5WSrDxAtrdm4Q==', 1, 1),
(31, 'g', '1ys30jU5v/S1WbbHTgNULiRrxbV5rJim6tCo2sDGy0mA0Hik3CYfxdgXlGIf4UnxlEgD0qdoP5WSrDxAtrdm4Q==', 2, 1),
(32, 'aljaymonggo', '1ys30jU5v/S1WbbHTgNULiRrxbV5rJim6tCo2sDGy0mA0Hik3CYfxdgXlGIf4UnxlEgD0qdoP5WSrDxAtrdm4Q==', 2, 1),
(33, 'norf', '1ys30jU5v/S1WbbHTgNULiRrxbV5rJim6tCo2sDGy0mA0Hik3CYfxdgXlGIf4UnxlEgD0qdoP5WSrDxAtrdm4Q==', 2, 1),
(34, 'norf123', '1ys30jU5v/S1WbbHTgNULiRrxbV5rJim6tCo2sDGy0mA0Hik3CYfxdgXlGIf4UnxlEgD0qdoP5WSrDxAtrdm4Q==', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
  `SPID` int(11) NOT NULL,
  `SPName` varchar(50) NOT NULL,
  `SPAddress` varchar(30) NOT NULL,
  `SPContactNo` varchar(12) NOT NULL,
  `SPEmail` varchar(30) DEFAULT NULL,
  `SPType` int(11) NOT NULL COMMENT '0-arts, 1-sports',
  `SPStatus` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `SPmobile` varchar(12) NOT NULL,
  `spphotoName` varchar(30) NOT NULL,
  `splogoName` varchar(30) NOT NULL,
  `spfirstname` varchar(50) NOT NULL,
  `splastname` varchar(50) NOT NULL,
  `usertype` int(11) NOT NULL COMMENT '0-admin, 1-service_provide, 2-client',
  `userstatus` int(11) NOT NULL COMMENT '0-inactive,1-active,2-banned',
  `SPAboutMe` longtext NOT NULL,
  `SPLocation` varchar(50) NOT NULL,
  `SPSubsPlan` int(11) NOT NULL,
  `SPRegisteredDate` datetime NOT NULL,
  `SPSubsDate` datetime NOT NULL COMMENT 'Subscription Date'
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`SPID`, `SPName`, `SPAddress`, `SPContactNo`, `SPEmail`, `SPType`, `SPStatus`, `UserID`, `SPmobile`, `spphotoName`, `splogoName`, `spfirstname`, `splastname`, `usertype`, `userstatus`, `SPAboutMe`, `SPLocation`, `SPSubsPlan`, `SPRegisteredDate`, `SPSubsDate`) VALUES
(21, 'Taekwando GYM', 'Urgello Cebu City', '677-7898', 'our@yahoo.com', 0, 1, 27, '09888888888', 'ariana.jpg', 'gym_07.jpg', '', '', 1, 1, '', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'Sumbagay GYM', 'Mabolo Cebu City', 'nine', 'none', 1, 1, 28, '3456666', '', 'IMG_0143-e1352505322542.jpg', '', '', 1, 1, '', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'HASOLA GYM', 'Cebu City', 'rrr', 'rere@yahoo.com', 1, 1, 29, 'rr', '', '30324943-fitness-sport-trainin', '', '', 1, 1, '', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'Dsdsdsd', 'Dsds', 'v', 'dsds', 0, 1, 30, 'v', '', 'inside-of-gym.jpg', '', '', 1, 1, '', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 'Aljay', 'Aljay mongo', '1234', 'aljaymonggo@gmail.com', 1, 1, 32, '4545', '68yooseungho29.jpg', '', '', '', 1, 1, '', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 'Norf', 'Secret', '123456', 'nalmonicar1988@gmail.com', 0, 1, 26, '12345678990', '', '', '', '', 0, 1, '', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD PRIMARY KEY (`AttendeeID`), ADD KEY `SCHEDID` (`SchedID`), ADD KEY `ENROLLEDID` (`EnrolledID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`EventID`), ADD KEY `SPID` (`SPID`);

--
-- Indexes for table `gallary`
--
ALTER TABLE `gallary`
  ADD PRIMARY KEY (`gal_id`), ADD KEY `SPID` (`SPID`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`InstructorID`), ADD KEY `MASTERINSID` (`MasterInsID`), ADD KEY `SERVICEID` (`ServiceID`), ADD KEY `EVENTID` (`EventID`);

--
-- Indexes for table `instructor_masterlist`
--
ALTER TABLE `instructor_masterlist`
  ADD PRIMARY KEY (`MasterInsID`), ADD KEY `SPID` (`SPID`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`MemberID`);

--
-- Indexes for table `members_services_enrolled`
--
ALTER TABLE `members_services_enrolled`
  ADD PRIMARY KEY (`MSEID`);

--
-- Indexes for table `my_clinics`
--
ALTER TABLE `my_clinics`
  ADD PRIMARY KEY (`myClinicID`), ADD KEY `SPID` (`SPID`), ADD KEY `CLIENTID` (`ClientID`);

--
-- Indexes for table `my_interests`
--
ALTER TABLE `my_interests`
  ADD PRIMARY KEY (`myInterestID`), ADD KEY `CLIENTID` (`ClientID`), ADD KEY `SERVICEID` (`ServiceID`), ADD KEY `EVENTID` (`EventID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`NotifID`), ADD KEY `CLIENTID` (`ClientID`), ADD KEY `SPID` (`SPID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`PaymentID`), ADD KEY `SUBSCID` (`SubscID`), ADD KEY `SPID` (`SPID`);

--
-- Indexes for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`PLID`), ADD KEY `SERVICEID` (`ServiceID`), ADD KEY `EVENTID` (`EventID`), ADD KEY `ENROLLEDID` (`EnrolledID`);

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`PromoID`), ADD KEY `SPID` (`SPID`);

--
-- Indexes for table `reviews_and_ratings`
--
ALTER TABLE `reviews_and_ratings`
  ADD PRIMARY KEY (`ReviewsID`), ADD KEY `SPID` (`SPID`), ADD KEY `ENROLLEDID` (`EnrolledID`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`RoomID`), ADD KEY `SERVICEID` (`ServiceID`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`SchedID`), ADD KEY `EVENTID` (`EventID`), ADD KEY `ROOMID` (`RoomID`), ADD KEY `INSTRUCTORID` (`InstructorID`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`ServiceID`), ADD KEY `SPID` (`SPID`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`SubscID`), ADD KEY `PLANID` (`PlanID`), ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`PlanID`), ADD KEY `PlanID` (`PlanID`);

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
-- AUTO_INCREMENT for table `attendees`
--
ALTER TABLE `attendees`
  MODIFY `AttendeeID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gallary`
--
ALTER TABLE `gallary`
  MODIFY `gal_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=133;
--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `InstructorID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `instructor_masterlist`
--
ALTER TABLE `instructor_masterlist`
  MODIFY `MasterInsID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `members_services_enrolled`
--
ALTER TABLE `members_services_enrolled`
  MODIFY `MSEID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `my_clinics`
--
ALTER TABLE `my_clinics`
  MODIFY `myClinicID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `my_interests`
--
ALTER TABLE `my_interests`
  MODIFY `myInterestID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `NotifID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `PLID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `PromoID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reviews_and_ratings`
--
ALTER TABLE `reviews_and_ratings`
  MODIFY `ReviewsID` int(11) NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `ServiceID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `SubscID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `PlanID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `SPID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendees`
--
ALTER TABLE `attendees`
ADD CONSTRAINT `attendees_ibfk_1` FOREIGN KEY (`SchedID`) REFERENCES `schedules` (`SchedID`),
ADD CONSTRAINT `attendees_ibfk_2` FOREIGN KEY (`EnrolledID`) REFERENCES `enrolled_clients` (`EnrolledID`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`SPID`) REFERENCES `user_details` (`SPID`);

--
-- Constraints for table `gallary`
--
ALTER TABLE `gallary`
ADD CONSTRAINT `gallary_ibfk_1` FOREIGN KEY (`SPID`) REFERENCES `user_details` (`SPID`);

--
-- Constraints for table `instructors`
--
ALTER TABLE `instructors`
ADD CONSTRAINT `instructors_ibfk_1` FOREIGN KEY (`MasterInsID`) REFERENCES `instructor_masterlist` (`MasterInsID`),
ADD CONSTRAINT `instructors_ibfk_2` FOREIGN KEY (`ServiceID`) REFERENCES `services` (`ServiceID`),
ADD CONSTRAINT `instructors_ibfk_3` FOREIGN KEY (`EventID`) REFERENCES `events` (`EventID`);

--
-- Constraints for table `instructor_masterlist`
--
ALTER TABLE `instructor_masterlist`
ADD CONSTRAINT `instructor_masterlist_ibfk_1` FOREIGN KEY (`SPID`) REFERENCES `user_details` (`SPID`);

--
-- Constraints for table `my_clinics`
--
ALTER TABLE `my_clinics`
ADD CONSTRAINT `my_clinics_ibfk_1` FOREIGN KEY (`SPID`) REFERENCES `user_details` (`SPID`),
ADD CONSTRAINT `my_clinics_ibfk_2` FOREIGN KEY (`ClientID`) REFERENCES `clients` (`ClientID`);

--
-- Constraints for table `my_interests`
--
ALTER TABLE `my_interests`
ADD CONSTRAINT `my_interests_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `clients` (`ClientID`),
ADD CONSTRAINT `my_interests_ibfk_2` FOREIGN KEY (`ServiceID`) REFERENCES `services` (`ServiceID`),
ADD CONSTRAINT `my_interests_ibfk_3` FOREIGN KEY (`EventID`) REFERENCES `events` (`EventID`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `clients` (`ClientID`),
ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`SPID`) REFERENCES `user_details` (`SPID`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`SubscID`) REFERENCES `subscriptions` (`SubscID`),
ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`SPID`) REFERENCES `user_details` (`SPID`);

--
-- Constraints for table `payment_logs`
--
ALTER TABLE `payment_logs`
ADD CONSTRAINT `payment_logs_ibfk_1` FOREIGN KEY (`ServiceID`) REFERENCES `services` (`ServiceID`),
ADD CONSTRAINT `payment_logs_ibfk_2` FOREIGN KEY (`EventID`) REFERENCES `events` (`EventID`),
ADD CONSTRAINT `payment_logs_ibfk_3` FOREIGN KEY (`EnrolledID`) REFERENCES `enrolled_clients` (`EnrolledID`);

--
-- Constraints for table `promos`
--
ALTER TABLE `promos`
ADD CONSTRAINT `promos_ibfk_1` FOREIGN KEY (`SPID`) REFERENCES `user_details` (`SPID`);

--
-- Constraints for table `reviews_and_ratings`
--
ALTER TABLE `reviews_and_ratings`
ADD CONSTRAINT `reviews_and_ratings_ibfk_1` FOREIGN KEY (`SPID`) REFERENCES `user_details` (`SPID`),
ADD CONSTRAINT `reviews_and_ratings_ibfk_2` FOREIGN KEY (`EnrolledID`) REFERENCES `enrolled_clients` (`EnrolledID`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`ServiceID`) REFERENCES `services` (`ServiceID`);

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`EventID`) REFERENCES `events` (`EventID`),
ADD CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`RoomID`) REFERENCES `rooms` (`RoomID`),
ADD CONSTRAINT `schedules_ibfk_3` FOREIGN KEY (`InstructorID`) REFERENCES `instructors` (`InstructorID`);

--
-- Constraints for table `services`
--
ALTER TABLE `services`
ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`SPID`) REFERENCES `user_details` (`SPID`);

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`PlanID`) REFERENCES `subscription_plans` (`PlanID`),
ADD CONSTRAINT `subscriptions_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user_accounts` (`UserID`);

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user_accounts` (`UserID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
