-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2024 at 02:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbzambocitylib`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(11) NOT NULL,
  `adminEmail` varchar(255) NOT NULL,
  `adminPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `adminEmail`, `adminPassword`) VALUES
(2, 'zambocity@lib.com.ph', '$2y$10$RJc2NAQPPDyDOdyK3TNJIusjUd5zFYObM8C.O6PHZMHJYPsiWnZuC');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_checker`
--

CREATE TABLE `attendance_checker` (
  `attendanceCheckerID` int(11) NOT NULL,
  `acFirstName` varchar(255) NOT NULL,
  `acMiddleName` varchar(255) DEFAULT NULL,
  `acLastName` varchar(255) NOT NULL,
  `acContactNo` varchar(255) NOT NULL,
  `acEmail` varchar(255) NOT NULL,
  `acPassword` varchar(255) NOT NULL,
  `acImage` varchar(255) NOT NULL,
  `acEmployment` varchar(255) NOT NULL,
  `acCreatedAt` datetime DEFAULT current_timestamp(),
  `acUpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_checker`
--

INSERT INTO `attendance_checker` (`attendanceCheckerID`, `acFirstName`, `acMiddleName`, `acLastName`, `acContactNo`, `acEmail`, `acPassword`, `acImage`, `acEmployment`, `acCreatedAt`, `acUpdatedAt`) VALUES
(1, 'charlyn', 'labitad', 'elorde', '09574142224', 'elordecharlyn74@gmail.com', '92032', '', 'Active', '2024-05-06 03:39:52', '2024-05-06 03:39:52');

-- --------------------------------------------------------

--
-- Table structure for table `club`
--

CREATE TABLE `club` (
  `clubID` int(11) NOT NULL,
  `clubName` varchar(255) NOT NULL,
  `clubDescription` varchar(2555) NOT NULL,
  `clubMinAge` int(11) NOT NULL,
  `clubMaxAge` int(11) NOT NULL,
  `clubImage` varchar(255) DEFAULT NULL,
  `clubCreatedAt` date NOT NULL DEFAULT current_timestamp(),
  `clubUpdatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `club`
--

INSERT INTO `club` (`clubID`, `clubName`, `clubDescription`, `clubMinAge`, `clubMaxAge`, `clubImage`, `clubCreatedAt`, `clubUpdatedAt`) VALUES
(20, 'Friends of the Library Club', 'The Friends of the Library Club is a volunteer organization of individuals dedicated to support the activities of the library, providing funding for programs, services, and items outside the regular budget of the library as well as serve as a source of volunteers for library activities. The Friends Group meets every quarter of the year. Call the Zamboanga City Library for place and time.', 1, 6, NULL, '2024-04-29', '2024-06-06 09:56:23'),
(21, 'Young Storytellers Club', 'The Young Storytellers Club aims to foster the creativity, imagination, and storytelling skills of its members through various activities and opportunities. The club provides a supportive and inspiring environment for young storytellers to explore their ideas, enhance their communicative skills, and develop a passion for stroytelling in its various forms.', 7, 12, NULL, '2024-04-29', '2024-05-02 04:53:00');

-- --------------------------------------------------------

--
-- Table structure for table `club_announcement`
--

CREATE TABLE `club_announcement` (
  `clubAnnouncementID` int(11) NOT NULL,
  `clubID` int(11) NOT NULL,
  `caTitle` varchar(255) NOT NULL,
  `caDescription` varchar(255) NOT NULL,
  `caCondition` varchar(255) NOT NULL,
  `caStartDate` date NOT NULL,
  `caEndDate` date NOT NULL,
  `caStartTime` time NOT NULL,
  `caEndTime` time NOT NULL,
  `caCreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `caUpdatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `club_announcement`
--

INSERT INTO `club_announcement` (`clubAnnouncementID`, `clubID`, `caTitle`, `caDescription`, `caCondition`, `caStartDate`, `caEndDate`, `caStartTime`, `caEndTime`, `caCreatedAt`, `caUpdatedAt`) VALUES
(6, 20, 'sample', 'SAMPLE', 'Urgent', '2024-08-23', '2024-08-31', '23:27:00', '06:27:00', '2024-08-09 21:27:50', '2024-08-09 21:28:21');

-- --------------------------------------------------------

--
-- Table structure for table `club_event`
--

CREATE TABLE `club_event` (
  `club_eventID` int(11) NOT NULL,
  `clubID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `club_event`
--

INSERT INTO `club_event` (`club_eventID`, `clubID`, `eventID`, `status`) VALUES
(2, 20, 79, 'Pending'),
(3, 20, 80, 'Pending'),
(4, 20, 81, 'Pending'),
(5, 20, 82, 'Pending'),
(6, 20, 83, 'Pending'),
(7, 20, 84, 'Pending'),
(8, 20, 85, 'Pending'),
(9, 20, 86, 'Pending'),
(10, 20, 103, 'Pending'),
(11, 20, 118, 'Pending'),
(12, 20, 119, 'Pending'),
(13, 20, 120, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `club_formanswer`
--

CREATE TABLE `club_formanswer` (
  `clubFormAnswerID` int(11) NOT NULL,
  `clubFormQuestionID` int(11) NOT NULL,
  `clubMembershipID` int(11) NOT NULL,
  `cfAnswer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `club_formanswer`
--

INSERT INTO `club_formanswer` (`clubFormAnswerID`, `clubFormQuestionID`, `clubMembershipID`, `cfAnswer`) VALUES
(5, 1, 22, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `club_formquestion`
--

CREATE TABLE `club_formquestion` (
  `clubFormQuestionID` int(11) NOT NULL,
  `clubID` int(11) NOT NULL,
  `cfQuestion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `club_formquestion`
--

INSERT INTO `club_formquestion` (`clubFormQuestionID`, `clubID`, `cfQuestion`) VALUES
(5, 20, 'again');

-- --------------------------------------------------------

--
-- Table structure for table `club_management`
--

CREATE TABLE `club_management` (
  `clubID` int(11) NOT NULL,
  `librarianID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `club_management`
--

INSERT INTO `club_management` (`clubID`, `librarianID`) VALUES
(12, 2),
(12, 2),
(12, 2),
(12, 2),
(12, 2),
(12, 2),
(12, 2),
(12, 2),
(12, 2),
(12, 2),
(12, 2),
(12, 2),
(12, 2),
(12, 2),
(12, 2),
(12, 2),
(7, 3),
(7, 4),
(7, 5),
(7, 6),
(7, 8),
(14, 9),
(14, 10),
(14, 11),
(15, 9),
(15, 10),
(15, 11),
(16, 10),
(16, 11),
(17, 9),
(18, 11),
(22, 14),
(23, 14),
(23, 15),
(23, 16),
(21, 15),
(21, 16),
(20, 14);

-- --------------------------------------------------------

--
-- Table structure for table `club_membership`
--

CREATE TABLE `club_membership` (
  `clubMembershipID` int(11) NOT NULL,
  `clubID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `cmStatus` varchar(255) NOT NULL DEFAULT 'Pending',
  `cmCreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `cmUpdatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `club_membership`
--

INSERT INTO `club_membership` (`clubMembershipID`, `clubID`, `userID`, `cmStatus`, `cmCreatedAt`, `cmUpdatedAt`) VALUES
(16, 20, 85, 'Rejected', '2024-05-02 04:15:38', '2024-05-05 20:11:36'),
(17, 20, 80, 'Approved', '2024-05-05 19:25:51', '2024-05-05 19:38:03'),
(18, 20, 85, 'Rejected', '2024-05-05 19:25:51', '2024-05-05 19:32:19'),
(19, 20, 85, 'Approved', '2024-05-05 19:38:25', '2024-05-05 19:41:29'),
(20, 20, 80, 'Rejected', '2024-05-05 19:38:25', '2024-05-05 19:40:09'),
(21, 20, 85, 'Rejected', '2024-05-05 19:45:55', '2024-05-05 19:46:05'),
(22, 20, 80, 'Approved', '2024-05-05 19:51:36', '2024-05-05 19:51:46');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `eventID` int(11) NOT NULL,
  `eventTitle` varchar(255) NOT NULL,
  `eventDescription` varchar(2555) NOT NULL,
  `eventStartDate` date NOT NULL,
  `eventEndDate` date NOT NULL,
  `eventStartTime` time NOT NULL,
  `eventEndTime` time NOT NULL,
  `eventGuestLimit` int(11) NOT NULL,
  `eventRegion` varchar(255) NOT NULL,
  `eventProvince` varchar(255) NOT NULL,
  `eventCity` varchar(255) NOT NULL,
  `eventBarangay` varchar(255) NOT NULL,
  `eventStreetName` varchar(255) NOT NULL,
  `eventBuildingName` varchar(255) DEFAULT NULL,
  `eventZipCode` int(11) NOT NULL,
  `organizationClubID` int(11) DEFAULT NULL,
  `eventStatus` varchar(255) NOT NULL,
  `eventCreatedAt` date NOT NULL DEFAULT current_timestamp(),
  `eventUpdatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`eventID`, `eventTitle`, `eventDescription`, `eventStartDate`, `eventEndDate`, `eventStartTime`, `eventEndTime`, `eventGuestLimit`, `eventRegion`, `eventProvince`, `eventCity`, `eventBarangay`, `eventStreetName`, `eventBuildingName`, `eventZipCode`, `organizationClubID`, `eventStatus`, `eventCreatedAt`, `eventUpdatedAt`) VALUES
(117, 'harry potter reading session', 'sample', '2024-08-22', '2024-08-29', '23:42:00', '01:42:00', 12, 'Region XIII', 'Agusan del Sur', 'zamboanga city', 'san roque', '2nd', 'none', 7000, NULL, 'Ongoing', '2024-08-18', '2024-08-18 23:04:06'),
(118, 'harry potter reading session', 'sample', '2024-08-23', '2024-08-24', '05:02:00', '06:02:00', 12, 'CAR', 'Abra', 'zamboanga city', 'sanroque', '123', 'Zamboanga City Library', 7000, NULL, '', '2024-08-18', '2024-08-18 23:02:53'),
(119, 'sample', 'sample', '2024-08-29', '2024-08-30', '01:17:00', '02:17:00', 12, 'Region IX', 'Zamboanga del Sur', 'zamboanga city', 'san roque', 'chico', 'Zamboanga City Library', 7000, NULL, '', '2024-08-18', '2024-08-18 23:18:06'),
(120, 'sample', 'sample', '2024-08-31', '2024-09-07', '02:51:00', '05:51:00', 12, 'Region IX', 'Zamboanga del Sur', 'zamboanga city', 'random', 'random', 'city hall', 7000, NULL, '', '2024-08-20', '2024-08-20 00:52:04');

-- --------------------------------------------------------

--
-- Table structure for table `event_announcement`
--

CREATE TABLE `event_announcement` (
  `eventAnnouncementID` int(11) NOT NULL,
  `eaTitle` varchar(255) NOT NULL,
  `eaDescription` varchar(255) DEFAULT NULL,
  `eaStartDate` date NOT NULL,
  `eaEndDate` date NOT NULL,
  `eaStartTime` time DEFAULT NULL,
  `eaEndTime` time DEFAULT NULL,
  `eaCreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `eaUpdatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_announcement`
--

INSERT INTO `event_announcement` (`eventAnnouncementID`, `eaTitle`, `eaDescription`, `eaStartDate`, `eaEndDate`, `eaStartTime`, `eaEndTime`, `eaCreatedAt`, `eaUpdatedAt`) VALUES
(6, 'CLOSED', '', '2024-05-04', '2024-05-04', '00:20:24', '00:00:00', '2024-05-03 04:09:11', '2024-05-03 04:17:25');

-- --------------------------------------------------------

--
-- Table structure for table `event_attendance`
--

CREATE TABLE `event_attendance` (
  `eventAttendanceID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  `eaDate` date NOT NULL DEFAULT current_timestamp(),
  `eaTime` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_attendance`
--

INSERT INTO `event_attendance` (`eventAttendanceID`, `eventID`, `eaDate`, `eaTime`) VALUES
(1, 118, '2024-04-17', '07:00:00'),
(4, 43, '2024-04-30', '10:00:00'),
(5, 44, '2024-04-29', '10:00:00'),
(6, 44, '2024-04-30', '10:00:00'),
(7, 44, '2024-05-01', '10:00:00'),
(8, 44, '2024-05-02', '10:00:00'),
(9, 45, '2024-04-01', '08:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `event_attendance-checker`
--

CREATE TABLE `event_attendance-checker` (
  `eventAttendanceID` int(11) NOT NULL,
  `librarianID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_attendanceuser`
--

CREATE TABLE `event_attendanceuser` (
  `idattendance` int(11) NOT NULL,
  `eventAttendanceID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `dateEntered` date NOT NULL DEFAULT current_timestamp(),
  `timeEntered` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_attendanceuser`
--

INSERT INTO `event_attendanceuser` (`idattendance`, `eventAttendanceID`, `userID`, `dateEntered`, `timeEntered`) VALUES
(42, 1, 80, '2024-05-06', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `event_certificate`
--

CREATE TABLE `event_certificate` (
  `eventCertificateID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `ecName` varchar(255) NOT NULL,
  `ecImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_certificate`
--

INSERT INTO `event_certificate` (`eventCertificateID`, `eventID`, `userID`, `ecName`, `ecImage`) VALUES
(1, 41, 80, 'Certificate of Recognition', ''),
(3, 43, 79, 'Certificate of Recognition', ''),
(4, 118, 80, 'Certificate of Recognition', 'certificate_66c34a504f4ca.png'),
(5, 118, 80, 'Certificate of Recognition', 'certificate_66c34a610f1f0.png'),
(6, 118, 80, 'Certificate of Recognition', 'certificate_66c34a66ba44e.png'),
(7, 118, 80, 'Certificate of Recognition', 'certificate_66c34b721c914.png'),
(8, 118, 80, 'Certificate of Recognition', 'certificate_66c34b7f9b888.png'),
(9, 118, 80, 'Certificate of Recognition', 'certificate_66c34bbe85a1b.png'),
(10, 0, 0, 'Certificate of Recognition', 'certificate_66c34d6f8d7dd.png'),
(11, 118, 0, 'Certificate of Recognition', 'certificate_66c34dbbb72a8.png'),
(12, 118, 0, 'Certificate of Recognition', 'certificate_66c34dec3d38f.png'),
(13, 118, 0, 'Certificate of Recognition', 'certificate_66c34f15b3a7b.png'),
(14, 118, 80, 'Certificate of Recognition', 'certificate_66c34fbf01816.png'),
(15, 118, 80, 'Certificate of Recognition', 'certificate_66c350eceb194.png'),
(16, 118, 80, 'Certificate of Recognition', 'certificate_66c3515014f6b.png'),
(17, 118, 80, 'Certificate of Recognition', 'certificate_66c3515bd5ce2.png'),
(18, 118, 80, 'Certificate of Recognition', 'certificate_66c3526d3d935.png'),
(19, 118, 80, 'Certificate of Recognition', 'certificate_66c35299aef96.png'),
(20, 118, 80, 'Certificate of Recognition', 'certificate_66c352f46df28.png'),
(21, 118, 80, 'Certificate of Recognition', 'certificate_66c35303e1c7d.png'),
(22, 118, 80, 'Certificate of Recognition', 'certificate_66c35326ccb83.png'),
(23, 118, 80, 'Certificate of Recognition', 'certificate_66c353dc869a0.png'),
(24, 118, 80, 'Certificate of Recognition', 'certificate_66c353fe923e8.png'),
(25, 118, 80, 'Certificate for Volunteers', 'certificate_66c356310fd70.png'),
(26, 118, 80, 'Certificate for Participant', 'certificate_66c3564f2143e.png');

-- --------------------------------------------------------

--
-- Table structure for table `event_facilitator`
--

CREATE TABLE `event_facilitator` (
  `eventID` int(11) NOT NULL,
  `librarianID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_facilitator`
--

INSERT INTO `event_facilitator` (`eventID`, `librarianID`) VALUES
(8, 2),
(8, 3),
(9, 2),
(9, 3),
(10, 3),
(10, 5),
(11, 2),
(12, 2),
(12, 3),
(12, 4),
(12, 5),
(13, 2),
(13, 3),
(13, 4),
(13, 5),
(0, 3),
(0, 4),
(0, 5),
(0, 6),
(0, 8),
(14, 3),
(14, 4),
(14, 5),
(14, 6),
(14, 8),
(18, 3),
(18, 4),
(18, 5),
(18, 6),
(18, 8),
(12, 3),
(12, 4),
(12, 5),
(12, 6),
(12, 8),
(19, 3),
(19, 4),
(19, 5),
(19, 6),
(19, 8),
(20, 9),
(20, 10),
(20, 11),
(21, 9),
(21, 10),
(21, 11),
(22, 9),
(22, 10),
(22, 11),
(23, 13),
(40, 13),
(41, 13),
(43, 13),
(44, 13),
(46, 14),
(47, 14),
(47, 15),
(47, 16),
(48, 16),
(49, 14),
(50, 14),
(50, 15),
(50, 16),
(51, 14),
(51, 15),
(51, 16),
(52, 14),
(52, 15),
(52, 16),
(53, 14),
(53, 15),
(53, 16),
(45, 14),
(54, 14),
(54, 15),
(54, 16),
(55, 14),
(55, 15),
(56, 14),
(57, 14),
(58, 16),
(59, 15),
(60, 14),
(61, 14),
(62, 14),
(62, 15),
(62, 16),
(63, 14),
(64, 15),
(65, 14),
(65, 15),
(66, 15),
(67, 15),
(68, 15),
(69, 15),
(70, 16),
(71, 14),
(72, 16),
(73, 14),
(74, 14),
(75, 14),
(76, 14),
(77, 14),
(78, 14),
(79, 14),
(80, 14),
(81, 14),
(81, 15),
(81, 16),
(82, 14),
(82, 15),
(82, 16),
(83, 14),
(83, 15),
(83, 16),
(84, 14),
(85, 14),
(86, 16),
(87, 16),
(88, 16),
(89, 14),
(89, 16),
(90, 14),
(90, 16),
(91, 14),
(91, 16),
(92, 16),
(93, 16),
(94, 16),
(95, 16),
(96, 16),
(97, 16),
(98, 15),
(98, 16),
(99, 16),
(100, 16),
(101, 16),
(102, 14),
(103, 14),
(104, 14),
(104, 15),
(104, 16),
(105, 16),
(106, 14),
(106, 15),
(106, 16),
(107, 14),
(108, 14),
(109, 14),
(110, 14),
(110, 15),
(111, 14),
(112, 15),
(112, 16),
(113, 14),
(114, 14),
(115, 14),
(116, 14),
(118, 14),
(119, 14),
(120, 14);

-- --------------------------------------------------------

--
-- Table structure for table `event_feedback`
--

CREATE TABLE `event_feedback` (
  `event_feedbackID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `ratings` int(11) NOT NULL,
  `feedback` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_feedback`
--

INSERT INTO `event_feedback` (`event_feedbackID`, `eventID`, `userID`, `ratings`, `feedback`, `createdAt`) VALUES
(1, 118, 80, 0, 'aamaaaziiing', '2024-05-06 01:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `event_images`
--

CREATE TABLE `event_images` (
  `event_ImageID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  `eventImage` varchar(255) NOT NULL,
  `eventDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_orgclub`
--

CREATE TABLE `event_orgclub` (
  `eventID` int(11) NOT NULL,
  `organizationClubID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_orgclub`
--

INSERT INTO `event_orgclub` (`eventID`, `organizationClubID`) VALUES
(52, 21),
(53, 21),
(53, 22),
(53, 23),
(45, 21),
(45, 22),
(45, 23),
(54, 21),
(54, 22),
(54, 23),
(54, 24),
(62, 21),
(62, 22),
(62, 23),
(62, 24),
(65, 24),
(70, 22),
(72, 21),
(73, 23),
(74, 21),
(75, 21),
(76, 21),
(77, 22),
(78, 21),
(79, 21),
(80, 23),
(81, 21),
(82, 23),
(83, 22),
(84, 21),
(85, 22),
(86, 21),
(87, 21),
(88, 21),
(89, 21),
(90, 21),
(91, 21),
(92, 21),
(93, 21),
(94, 21),
(95, 21),
(96, 21),
(97, 21),
(98, 21),
(99, 21),
(100, 21),
(101, 21),
(102, 21),
(103, 21),
(104, 21),
(105, 21),
(106, 23),
(107, 21),
(108, 24),
(109, 21),
(110, 21),
(111, 24),
(112, 21),
(114, 21),
(115, 21),
(116, 21),
(117, 21),
(118, 21),
(119, 21),
(120, 21);

-- --------------------------------------------------------

--
-- Table structure for table `event_reganswer`
--

CREATE TABLE `event_reganswer` (
  `eventRegAnswerID` int(11) NOT NULL,
  `eventRegQuestionID` int(11) NOT NULL,
  `eventRegistrationID` int(11) NOT NULL,
  `erAnswer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_regform`
--

CREATE TABLE `event_regform` (
  `eventRegistrationFormID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  `erfCreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `erfUpdatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_regform`
--

INSERT INTO `event_regform` (`eventRegistrationFormID`, `eventID`, `erfCreatedAt`, `erfUpdatedAt`) VALUES
(1, 47, '2024-05-03 05:53:35', '2024-05-03 05:53:35'),
(10, 45, '2024-05-03 10:29:59', '2024-05-03 10:29:59'),
(11, 45, '2024-05-03 10:32:01', '2024-05-03 10:32:01'),
(12, 45, '2024-05-03 10:39:06', '2024-05-03 10:39:06'),
(13, 45, '2024-05-03 10:39:33', '2024-05-03 10:39:33'),
(14, 45, '2024-05-03 10:39:46', '2024-05-03 10:39:46'),
(15, 45, '2024-05-03 10:41:04', '2024-05-03 10:41:04'),
(16, 45, '2024-05-03 10:41:10', '2024-05-03 10:41:10'),
(17, 118, '2024-08-19 23:58:41', '2024-08-19 23:58:41');

-- --------------------------------------------------------

--
-- Table structure for table `event_registration`
--

CREATE TABLE `event_registration` (
  `eventRegistrationID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `erStatus` varchar(255) NOT NULL DEFAULT 'Pending',
  `erCreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `erUpdatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_registration`
--

INSERT INTO `event_registration` (`eventRegistrationID`, `eventID`, `userID`, `erStatus`, `erCreatedAt`, `erUpdatedAt`) VALUES
(1, 118, 80, 'Approved', '2024-04-28 23:49:47', '2024-08-19 23:06:06'),
(3, 118, 85, 'Rejected', '2024-05-06 01:23:48', '2024-08-19 23:53:10'),
(4, 45, 80, 'Approved', '2024-05-06 01:23:48', '2024-05-06 01:50:23');

-- --------------------------------------------------------

--
-- Table structure for table `event_regquestion`
--

CREATE TABLE `event_regquestion` (
  `eventRegQuestionID` int(11) NOT NULL,
  `eventRegistrationFormID` int(11) NOT NULL,
  `erQuestion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_regquestion`
--

INSERT INTO `event_regquestion` (`eventRegQuestionID`, `eventRegistrationFormID`, `erQuestion`) VALUES
(2, 1, 'Do you like bands?'),
(3, 1, 'sample'),
(4, 1, 'effective'),
(5, 1, 'again'),
(6, 1, 'sample'),
(7, 1, 'samples'),
(8, 1, 'slay'),
(9, 1, 'sample'),
(10, 1, 'sa 8th');

-- --------------------------------------------------------

--
-- Table structure for table `event_volunteer`
--

CREATE TABLE `event_volunteer` (
  `event_volunteerID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `dateRegistered` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_volunteer`
--

INSERT INTO `event_volunteer` (`event_volunteerID`, `eventID`, `userID`, `dateRegistered`) VALUES
(1, 118, 80, '2024-05-06 01:53:28');

-- --------------------------------------------------------

--
-- Table structure for table `guardian`
--

CREATE TABLE `guardian` (
  `guardianID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `guardianFirstName` varchar(255) NOT NULL,
  `guardianMiddleName` varchar(255) DEFAULT NULL,
  `guardianLastName` varchar(255) NOT NULL,
  `guardianRole` varchar(255) NOT NULL,
  `guardianContactNo` varchar(255) NOT NULL,
  `guardianEmail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `librarian`
--

CREATE TABLE `librarian` (
  `librarianID` int(11) NOT NULL,
  `librarianFirstName` varchar(255) NOT NULL,
  `librarianMiddleName` varchar(255) DEFAULT NULL,
  `librarianLastName` varchar(255) NOT NULL,
  `librarianDesignation` varchar(255) NOT NULL,
  `librarianContactNo` varchar(255) DEFAULT NULL,
  `librarianEmail` varchar(255) NOT NULL,
  `librarianPassword` varchar(255) NOT NULL,
  `librarianImage` varchar(255) DEFAULT NULL,
  `librarianEmployment` varchar(255) NOT NULL,
  `librarianCreatedAt` date NOT NULL DEFAULT current_timestamp(),
  `librarianUpdatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `librarian`
--

INSERT INTO `librarian` (`librarianID`, `librarianFirstName`, `librarianMiddleName`, `librarianLastName`, `librarianDesignation`, `librarianContactNo`, `librarianEmail`, `librarianPassword`, `librarianImage`, `librarianEmployment`, `librarianCreatedAt`, `librarianUpdatedAt`) VALUES
(14, 'Madelyn', '', 'Candido', 'Librarian 4', '9914494', 'candido.madelyn@gmail.com', '$2y$10$VB.CRGlwkJlKmKrcQhQQd.GPPkFB39B1liRSOaqx.MB6kngGS6TGO', NULL, 'Active', '2024-04-29', '2024-04-29 02:56:34'),
(15, 'Reshelda', '', 'Patrimonio', 'Librarian 1', '9914494', 'patrimoio.reshelda@gmail.com', '$2y$10$hDRHUTVuh/HZPJak5qlT1e3fGsQ41kR8OaTy6xrO8EJ7q/DB5mm2O', NULL, 'Active', '2024-04-29', '2024-04-29 02:57:14'),
(16, 'Carmelita', '', 'Agustin', 'Librarian 3', '9914494', 'agustin.carmelita@gmail.com', '$2y$10$GwNuhj8Z7FhGHo8gVK7HHusPJSdn.MHGB.vDMeYIYdJdyT1gXd8ki', NULL, 'Active', '2024-04-29', '2024-04-29 02:57:39');

-- --------------------------------------------------------

--
-- Table structure for table `library_attendance`
--

CREATE TABLE `library_attendance` (
  `libraryAttendanceID` int(11) NOT NULL,
  `attendanceCheckerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `library_attendance`
--

INSERT INTO `library_attendance` (`libraryAttendanceID`, `attendanceCheckerID`) VALUES
(0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lib_attendanceuser`
--

CREATE TABLE `lib_attendanceuser` (
  `libraryAttendanceID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `dateEntered` date NOT NULL,
  `timeEntered` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lib_attendanceuser`
--

INSERT INTO `lib_attendanceuser` (`libraryAttendanceID`, `userID`, `purpose`, `dateEntered`, `timeEntered`) VALUES
(0, 80, 'study', '0000-00-00', '00:00:00'),
(0, 80, 'study', '0000-00-00', '00:00:00'),
(0, 80, 'study', '2024-05-06', '03:36:17'),
(0, 80, 'study', '2024-05-06', '19:55:39'),
(0, 80, 'study', '2024-05-06', '26:55:39'),
(0, 80, 'study', '2024-05-05', '16:57:17'),
(0, 80, 'study', '2024-05-05', '12:59:04'),
(0, 85, 'none', '2024-05-06', '16:14:08');

-- --------------------------------------------------------

--
-- Table structure for table `organization_club`
--

CREATE TABLE `organization_club` (
  `organizationClubID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `ocName` varchar(255) NOT NULL,
  `orgClubImage` varchar(255) NOT NULL,
  `ocEmail` varchar(255) NOT NULL,
  `ocContactNumber` varchar(255) NOT NULL,
  `ocStatus` varchar(255) NOT NULL DEFAULT 'Pending',
  `ocCreatedAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization_club`
--

INSERT INTO `organization_club` (`organizationClubID`, `userID`, `ocName`, `orgClubImage`, `ocEmail`, `ocContactNumber`, `ocStatus`, `ocCreatedAt`) VALUES
(20, 85, 'WMSU', '../images/orgClub_pic/wmsu@gmail.com.png', 'wmsu@gmail.com', '09876567876', 'Rejected', '2024-05-01 18:49:38'),
(21, 85, 'ComSci CLub', '../images/orgClub_pic/comsci@club.ph.png', 'comsci@club.ph', '09878765432', 'Approved', '2024-05-02 04:29:57'),
(22, 85, 'Ariana', '../images/orgClub_pic/ari@gmail.com.png', 'ari@gmail.com', '09287678965', 'Approved', '2024-05-02 06:45:22'),
(23, 85, 'student', '../images/orgClub_pic/student@gmail.com.png', 'student@gmail.com', '09284222123', 'Approved', '2024-05-02 06:46:15'),
(24, 85, 'The Organization', '../images/orgClub_pic/orgg@gmail.com.png', 'orgg@gmail.com', '09126374859', 'Approved', '2024-05-02 18:15:14');

-- --------------------------------------------------------

--
-- Table structure for table `org_proposal`
--

CREATE TABLE `org_proposal` (
  `org_proposalID` int(11) NOT NULL,
  `organizationClubID` int(11) NOT NULL,
  `proposalID` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `org_proposal`
--

INSERT INTO `org_proposal` (`org_proposalID`, `organizationClubID`, `proposalID`, `status`) VALUES
(1, 22, 54, 'Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `proposal`
--

CREATE TABLE `proposal` (
  `proposalID` int(11) NOT NULL,
  `proposalSubject` varchar(255) NOT NULL,
  `proposalDescription` varchar(2555) NOT NULL,
  `proposalStartDate` date NOT NULL,
  `proposalEndDate` date NOT NULL,
  `proposalStartTime` time NOT NULL,
  `proposalEndTime` time NOT NULL,
  `proposalCreatedAt` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_files`
--

CREATE TABLE `proposal_files` (
  `proposalID` int(11) NOT NULL,
  `proposalFile` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `userFirstName` varchar(255) NOT NULL,
  `userMiddleName` varchar(255) DEFAULT NULL,
  `userLastName` varchar(255) NOT NULL,
  `userUserName` varchar(255) NOT NULL,
  `userBirthdate` date NOT NULL,
  `userAge` int(11) NOT NULL,
  `userGender` varchar(255) NOT NULL,
  `userCivilStatus` varchar(255) NOT NULL,
  `userContactNo` varchar(255) NOT NULL,
  `userEmail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userSchoolOffice` varchar(255) NOT NULL,
  `userIDCard` varchar(255) NOT NULL,
  `userRegion` varchar(255) NOT NULL,
  `userProvince` varchar(255) NOT NULL,
  `userCity` varchar(255) NOT NULL,
  `userBarangay` varchar(255) NOT NULL,
  `userStreetName` varchar(255) NOT NULL,
  `userZipCode` int(11) DEFAULT NULL,
  `userImage` varchar(255) NOT NULL,
  `userType` varchar(255) NOT NULL,
  `account_activation_hash` varchar(64) DEFAULT NULL,
  `userCreatedAt` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `userFirstName`, `userMiddleName`, `userLastName`, `userUserName`, `userBirthdate`, `userAge`, `userGender`, `userCivilStatus`, `userContactNo`, `userEmail`, `userPassword`, `userSchoolOffice`, `userIDCard`, `userRegion`, `userProvince`, `userCity`, `userBarangay`, `userStreetName`, `userZipCode`, `userImage`, `userType`, `account_activation_hash`, `userCreatedAt`) VALUES
(80, 'Fred Anthony', 'Duran', 'Yu', 'fred123', '2003-03-07', 21, 'Male', 'Single', '09353742658', 'yufredanthony@gmail.com', '$2y$10$hXMcz2tsAjt/iDsZgadrbOoTfWtTy.stX64ZItaBVTqk03O3pb/gW', 'WMSU', '../qr-code-generator/user-qrcodes/user_80_qr.png', '9', 'Zamboanga Del Sur', 'Zamboanga City', 'Maasin', 'Kalambuan', 7000, '../images/profile_pic/fred123.jpg', 'Individual', NULL, '2024-04-26'),
(85, 'Christiana', 'Ovalo', 'Bagotao', '', '0000-00-00', 3, 'Female', '', '', 'bagotaochristiana@gmail.com', '$2y$10$r3hjMHq04O9U/Qo0cEtdU.pNoC6YbEjiePPXZy9BaYe3MJb4878je', 'Trade', '', '', '', '', '', '', NULL, '', '', NULL, '2024-04-29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `attendance_checker`
--
ALTER TABLE `attendance_checker`
  ADD PRIMARY KEY (`attendanceCheckerID`);

--
-- Indexes for table `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`clubID`);

--
-- Indexes for table `club_announcement`
--
ALTER TABLE `club_announcement`
  ADD PRIMARY KEY (`clubAnnouncementID`),
  ADD KEY `FK_CA1` (`clubID`);

--
-- Indexes for table `club_event`
--
ALTER TABLE `club_event`
  ADD PRIMARY KEY (`club_eventID`);

--
-- Indexes for table `club_formanswer`
--
ALTER TABLE `club_formanswer`
  ADD PRIMARY KEY (`clubFormAnswerID`),
  ADD KEY `clubMembershipID_fk` (`clubMembershipID`);

--
-- Indexes for table `club_formquestion`
--
ALTER TABLE `club_formquestion`
  ADD PRIMARY KEY (`clubFormQuestionID`);

--
-- Indexes for table `club_membership`
--
ALTER TABLE `club_membership`
  ADD PRIMARY KEY (`clubMembershipID`),
  ADD KEY `userID_cm_fk` (`userID`),
  ADD KEY `clubID_cm_fk` (`clubID`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`eventID`);

--
-- Indexes for table `event_announcement`
--
ALTER TABLE `event_announcement`
  ADD PRIMARY KEY (`eventAnnouncementID`);

--
-- Indexes for table `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD PRIMARY KEY (`eventAttendanceID`);

--
-- Indexes for table `event_attendanceuser`
--
ALTER TABLE `event_attendanceuser`
  ADD PRIMARY KEY (`idattendance`);

--
-- Indexes for table `event_certificate`
--
ALTER TABLE `event_certificate`
  ADD PRIMARY KEY (`eventCertificateID`);

--
-- Indexes for table `event_feedback`
--
ALTER TABLE `event_feedback`
  ADD PRIMARY KEY (`event_feedbackID`);

--
-- Indexes for table `event_images`
--
ALTER TABLE `event_images`
  ADD PRIMARY KEY (`event_ImageID`),
  ADD KEY `FK_EIMG1` (`eventID`);

--
-- Indexes for table `event_reganswer`
--
ALTER TABLE `event_reganswer`
  ADD PRIMARY KEY (`eventRegAnswerID`),
  ADD KEY `FK_REGANSWER` (`eventRegistrationID`);

--
-- Indexes for table `event_regform`
--
ALTER TABLE `event_regform`
  ADD PRIMARY KEY (`eventRegistrationFormID`);

--
-- Indexes for table `event_registration`
--
ALTER TABLE `event_registration`
  ADD PRIMARY KEY (`eventRegistrationID`);

--
-- Indexes for table `event_regquestion`
--
ALTER TABLE `event_regquestion`
  ADD PRIMARY KEY (`eventRegQuestionID`);

--
-- Indexes for table `event_volunteer`
--
ALTER TABLE `event_volunteer`
  ADD PRIMARY KEY (`event_volunteerID`);

--
-- Indexes for table `guardian`
--
ALTER TABLE `guardian`
  ADD PRIMARY KEY (`guardianID`);

--
-- Indexes for table `librarian`
--
ALTER TABLE `librarian`
  ADD PRIMARY KEY (`librarianID`);

--
-- Indexes for table `library_attendance`
--
ALTER TABLE `library_attendance`
  ADD PRIMARY KEY (`libraryAttendanceID`);

--
-- Indexes for table `organization_club`
--
ALTER TABLE `organization_club`
  ADD PRIMARY KEY (`organizationClubID`),
  ADD KEY `userOcHead_fk` (`userID`);

--
-- Indexes for table `org_proposal`
--
ALTER TABLE `org_proposal`
  ADD PRIMARY KEY (`org_proposalID`);

--
-- Indexes for table `proposal`
--
ALTER TABLE `proposal`
  ADD PRIMARY KEY (`proposalID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userEmail` (`userEmail`),
  ADD UNIQUE KEY `account_activation_hash` (`account_activation_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance_checker`
--
ALTER TABLE `attendance_checker`
  MODIFY `attendanceCheckerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `club`
--
ALTER TABLE `club`
  MODIFY `clubID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `club_announcement`
--
ALTER TABLE `club_announcement`
  MODIFY `clubAnnouncementID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `club_event`
--
ALTER TABLE `club_event`
  MODIFY `club_eventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `club_formanswer`
--
ALTER TABLE `club_formanswer`
  MODIFY `clubFormAnswerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `club_formquestion`
--
ALTER TABLE `club_formquestion`
  MODIFY `clubFormQuestionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `club_membership`
--
ALTER TABLE `club_membership`
  MODIFY `clubMembershipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `eventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `event_announcement`
--
ALTER TABLE `event_announcement`
  MODIFY `eventAnnouncementID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `event_attendance`
--
ALTER TABLE `event_attendance`
  MODIFY `eventAttendanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `event_attendanceuser`
--
ALTER TABLE `event_attendanceuser`
  MODIFY `idattendance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `event_certificate`
--
ALTER TABLE `event_certificate`
  MODIFY `eventCertificateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `event_feedback`
--
ALTER TABLE `event_feedback`
  MODIFY `event_feedbackID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_images`
--
ALTER TABLE `event_images`
  MODIFY `event_ImageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `event_reganswer`
--
ALTER TABLE `event_reganswer`
  MODIFY `eventRegAnswerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event_regform`
--
ALTER TABLE `event_regform`
  MODIFY `eventRegistrationFormID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `event_registration`
--
ALTER TABLE `event_registration`
  MODIFY `eventRegistrationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `event_regquestion`
--
ALTER TABLE `event_regquestion`
  MODIFY `eventRegQuestionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `event_volunteer`
--
ALTER TABLE `event_volunteer`
  MODIFY `event_volunteerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guardian`
--
ALTER TABLE `guardian`
  MODIFY `guardianID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `librarian`
--
ALTER TABLE `librarian`
  MODIFY `librarianID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `library_attendance`
--
ALTER TABLE `library_attendance`
  MODIFY `libraryAttendanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `organization_club`
--
ALTER TABLE `organization_club`
  MODIFY `organizationClubID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `org_proposal`
--
ALTER TABLE `org_proposal`
  MODIFY `org_proposalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `proposal`
--
ALTER TABLE `proposal`
  MODIFY `proposalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `club_announcement`
--
ALTER TABLE `club_announcement`
  ADD CONSTRAINT `FK_CA1` FOREIGN KEY (`clubID`) REFERENCES `club` (`clubID`);

--
-- Constraints for table `club_formanswer`
--
ALTER TABLE `club_formanswer`
  ADD CONSTRAINT `clubMembershipID_fk` FOREIGN KEY (`clubMembershipID`) REFERENCES `club_membership` (`clubMembershipID`);

--
-- Constraints for table `club_membership`
--
ALTER TABLE `club_membership`
  ADD CONSTRAINT `clubID_cm_fk` FOREIGN KEY (`clubID`) REFERENCES `club` (`clubID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userID_cm_fk` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_reganswer`
--
ALTER TABLE `event_reganswer`
  ADD CONSTRAINT `FK_REGANSWER` FOREIGN KEY (`eventRegistrationID`) REFERENCES `event_registration` (`eventRegistrationID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
