-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2025 at 09:19 AM
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
-- Database: `school`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `campus_id` int(11) DEFAULT NULL,
  `is_super` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `password`, `campus_id`, `is_super`) VALUES
(2, 'Super admin', 'superadmin', '$2y$10$pOayPB56W69UDRhW/ZbHDOvrYmhVfB3cdkuK1HDjx4lSu2QEUmqAW', NULL, 1),
(3, 'junaid', 'junaid', '$2y$10$Usovy4Id4/LfXvwTvw03pO8vVWk4Xha4bPO/16UY/3XgaAckv.uW2', 3, 0),
(4, 'junaid2', 'junaid2', '$2y$10$GcV1HPL86ekTTFgQ0dGw3enj09MHkOaqLXlIuAa.8XpgzkpcX9ko.', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` enum('present','absent','late','leave') DEFAULT NULL,
  `campus_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `date`, `status`, `campus_id`) VALUES
(31, 14, '2025-05-12', 'present', NULL),
(32, 15, '2025-05-12', 'present', NULL),
(33, 14, '2025-05-23', 'present', NULL),
(34, 15, '2025-05-23', 'absent', NULL),
(35, 16, '2025-05-23', 'present', NULL),
(36, 17, '2025-05-23', 'absent', NULL),
(37, 18, '2025-05-23', 'leave', NULL),
(38, 20, '2025-05-23', 'late', NULL),
(39, 19, '2025-05-23', 'present', NULL),
(40, 17, '2025-05-26', 'absent', NULL),
(41, 16, '2025-05-26', 'present', NULL),
(42, 15, '2025-05-26', 'late', NULL),
(43, 14, '2025-05-26', 'leave', NULL),
(44, 18, '2025-05-26', 'present', NULL),
(45, 20, '2025-05-26', 'present', NULL),
(46, 14, '2025-05-30', 'present', NULL),
(47, 15, '2025-05-30', 'absent', NULL),
(48, 16, '2025-05-30', 'late', NULL),
(49, 17, '2025-05-30', 'leave', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `campuses`
--

CREATE TABLE `campuses` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campuses`
--

INSERT INTO `campuses` (`id`, `name`) VALUES
(3, 'FICER'),
(4, 'FICER 2');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `campus_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `campus_id`) VALUES
(1, 'Web Development', NULL),
(2, 'Graphic Design', NULL),
(3, 'Wordpress', NULL),
(4, 'MS Office', NULL),
(5, 'Digital Marketing', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','cancelled') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cancel_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `teacher_id`, `from_date`, `to_date`, `reason`, `status`, `created_at`, `cancel_reason`) VALUES
(5, 4, '2025-05-12', '2025-05-12', 'Sick', 'approved', '2025-05-12 05:14:30', NULL),
(6, 4, '2025-05-14', '2025-05-14', 'Sick', 'approved', '2025-05-12 05:16:54', NULL),
(7, 4, '2025-05-16', '2025-05-16', 'Sick', 'cancelled', '2025-05-12 05:17:33', 'nothing'),
(8, 4, '2025-05-26', '2025-05-26', 'nothing', 'pending', '2025-05-26 09:30:44', NULL),
(9, 4, '2025-05-30', '2025-05-30', 'kjahdkajs', 'pending', '2025-05-30 10:32:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` int(11) NOT NULL,
  `shift_name` varchar(100) NOT NULL,
  `campus_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`id`, `shift_name`, `campus_id`) VALUES
(1, 'Morning', NULL),
(2, 'Evening', NULL),
(3, 'Weekend', NULL),
(4, 'Afternoon', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `session_start` date DEFAULT NULL,
  `session_end` date DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `shift_id` int(11) DEFAULT NULL,
  `campus_id` int(11) DEFAULT NULL,
  `cnic` varchar(30) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `marital_status` varchar(15) DEFAULT NULL,
  `guardian_name` varchar(100) DEFAULT NULL,
  `guardian_phone` varchar(20) DEFAULT NULL,
  `student_phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `education` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `status` enum('active','passout','blocked') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `image`, `admission_date`, `session_start`, `session_end`, `course_id`, `shift_id`, `campus_id`, `cnic`, `gender`, `marital_status`, `guardian_name`, `guardian_phone`, `student_phone`, `address`, `education`, `dob`, `status`) VALUES
(14, 'Hunzla ikram', '1747025311_3.webp', '2025-05-12', '2025-05-12', '2025-07-12', 1, 1, 3, '3530219558003', 'Male', 'Single', 'Ikram', '03434058227', '0343405827', 'Okara', 'BSCS', '2025-05-12', 'active'),
(15, 'Shahzad', '1747025381_2.webp', '2025-05-12', '2025-05-12', '2025-07-12', 1, 1, 4, '3530219558003', 'Male', 'Single', 'Muhammad', '03434058227', '03434058227', 'Okara', 'BSCS', '2025-05-12', 'active'),
(16, 'Zeeshan', '1747038300_298348556_2096852580476473_3725707314048836329_n.jpg', '2025-05-12', '2025-05-12', '2025-07-12', 1, 1, 3, '3530219558003', 'Male', 'Single', 'Muhammad', '03434058227', '03434058227', 'Okara', 'BSCS', '2025-05-12', 'active'),
(17, 'Haseeb waleed', '1747038370_298348556_2096852580476473_3725707314048836329_n.jpg', '2025-05-12', '2025-05-12', '2025-07-12', 1, 1, 3, '3530219558003', 'Male', 'Single', 'Waleed', '03434058227', '03434058227', 'Okara', 'BSCS', '2025-05-12', 'active'),
(18, 'Haseeb Munawar', '1747038414_298348556_2096852580476473_3725707314048836329_n.jpg', '2025-05-12', '2025-05-12', '2025-07-12', 1, 1, 3, '3530219558003', 'Male', 'Single', 'Munawar', '03434058227', '03434058227', 'Okara', 'BSCS', '2025-05-12', 'active'),
(19, 'Arslan Ali', '1747038482_298348556_2096852580476473_3725707314048836329_n.jpg', '2025-05-12', '2025-05-12', '2025-07-12', 1, 1, 3, '3530219558003', 'Male', 'Single', 'Ali', '03434058227', '03434058227', 'Okara', 'BSCS', '2025-05-12', 'blocked'),
(20, 'Naeem', '1747038510_298348556_2096852580476473_3725707314048836329_n.jpg', '2025-05-12', '2025-05-12', '2025-07-12', 1, 1, 4, '3530219558003', 'Male', 'Single', 'Ali', '03434058227', '03434058227', 'Okara', 'BSCS', '2025-05-12', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `class_assigned` varchar(50) DEFAULT NULL,
  `campus_id` int(11) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cnic` varchar(30) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `username`, `password`, `class_assigned`, `campus_id`, `hire_date`, `phone`, `cnic`, `gender`, `address`, `image`) VALUES
(4, 'Moeen Dastgeer', 'moeen', '$2y$10$KX4eM.n94ulxJzoktVueZ.y1zXb5L4B7s7xWX1xgV6CEexN/DvxZm', '1-4,1-2,1-1', 3, '2025-05-12', '03434058227', '3530219558003', 'male', 'Okara', '1747025445_298348556_2096852580476473_3725707314048836329_n.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `campuses`
--
ALTER TABLE `campuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_name` (`course_name`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shift_name` (`shift_name`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `shift_id` (`shift_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `campuses`
--
ALTER TABLE `campuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
