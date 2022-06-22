-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20220621.da7c7a84e1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2022 at 04:03 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evaluation_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `course_list`
--

CREATE TABLE `course_list` (
  `id` int(30) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_list`
--

INSERT INTO `course_list` (`id`, `code`, `description`) VALUES
(1, 'BSIT', 'Bachelor of Science in Information Technology');

-- --------------------------------------------------------

--
-- Table structure for table `criteria_list`
--

CREATE TABLE `criteria_list` (
  `id` int(30) NOT NULL,
  `criteria` text NOT NULL,
  `user_id` int(30) NOT NULL,
  `order_by` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `criteria_list`
--

INSERT INTO `criteria_list` (`id`, `criteria`, `user_id`, `order_by`) VALUES
(1, 'Performance', 0, 0),
(2, 'Speaker', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_answers`
--

CREATE TABLE `evaluation_answers` (
  `evaluation_id` int(30) NOT NULL,
  `question_id` int(30) NOT NULL,
  `rate` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `evaluation_answers`
--

INSERT INTO `evaluation_answers` (`evaluation_id`, `question_id`, `rate`) VALUES
(7, 18, 1),
(8, 20, 2),
(8, 19, 3),
(8, 21, 3),
(9, 23, 3),
(9, 22, 4);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_list`
--

CREATE TABLE `evaluation_list` (
  `evaluation_id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `event_id` int(30) NOT NULL,
  `date_taken` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `evaluation_list`
--

INSERT INTO `evaluation_list` (`evaluation_id`, `student_id`, `event_id`, `date_taken`) VALUES
(7, 2019100705, 10, '2022-06-22 20:01:46'),
(8, 2019100705, 12, '2022-06-22 21:04:50'),
(9, 2019100705, 13, '2022-06-22 21:32:45');

-- --------------------------------------------------------

--
-- Table structure for table `event_list`
--

CREATE TABLE `event_list` (
  `id` int(30) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event_list`
--

INSERT INTO `event_list` (`id`, `title`, `description`) VALUES
(10, 'General Meeting', 'General Meeting'),
(12, 'Kape at kwentuhan', 'To gather every scholars to talk about their academics while drinking coffee'),
(13, 'Singing Contest', 'Contest for all ISDA Scholars');

-- --------------------------------------------------------

--
-- Table structure for table `org_list`
--

CREATE TABLE `org_list` (
  `id` int(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `abbre` varchar(100) NOT NULL,
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `org_list`
--

INSERT INTO `org_list` (`id`, `name`, `abbre`, `avatar`, `date_created`) VALUES
(2, 'Scholar sa Dakbayan', 'ISDA', '1655895540_Christian De Asis.PNG', '2022-06-22 18:59:41'),
(3, 'Tertiary Education Subsidy', 'TES', '1655902860_Capture.PNG', '2022-06-22 21:01:48'),
(4, 'University City Scholarship', 'UCS', 'no-image-available.png', '2022-06-22 21:28:27');

-- --------------------------------------------------------

--
-- Table structure for table `question_list`
--

CREATE TABLE `question_list` (
  `id` int(30) NOT NULL,
  `question` text NOT NULL,
  `event_id` int(30) NOT NULL,
  `order_by` int(30) NOT NULL,
  `criteria_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_list`
--

INSERT INTO `question_list` (`id`, `question`, `event_id`, `order_by`, `criteria_id`) VALUES
(18, 'How is the speaker?', 10, 0, 2),
(19, 'How is the performance of the performers?', 12, 1, 1),
(20, 'How is the technical performance in the event?', 12, 0, 1),
(21, 'How is the speaker?', 12, 2, 2),
(22, 'How was each performers performance?', 13, 1, 1),
(23, 'How is the technical in the said event?', 13, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `restriction_list`
--

CREATE TABLE `restriction_list` (
  `id` int(30) NOT NULL,
  `year` int(30) NOT NULL,
  `course` int(30) NOT NULL,
  `org` int(30) NOT NULL,
  `event_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `restriction_list`
--

INSERT INTO `restriction_list` (`id`, `year`, `course`, `org`, `event_id`) VALUES
(26, 3, 1, 2, 10),
(27, 0, 1, 2, 12),
(28, 0, 0, 2, 13);

-- --------------------------------------------------------

--
-- Table structure for table `status_list`
--

CREATE TABLE `status_list` (
  `id` int(30) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT '0' COMMENT '0=Pending,1=Active,2=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status_list`
--

INSERT INTO `status_list` (`id`, `status`) VALUES
(0, 'Pending'),
(1, 'Active'),
(2, 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `student_list`
--

CREATE TABLE `student_list` (
  `id` int(30) NOT NULL,
  `school_id` varchar(100) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `status` int(30) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `org_id` int(30) NOT NULL,
  `course_id` int(30) NOT NULL,
  `year` int(30) NOT NULL,
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_list`
--

INSERT INTO `student_list` (`id`, `school_id`, `firstname`, `lastname`, `status`, `email`, `password`, `org_id`, `course_id`, `year`, `avatar`, `date_created`) VALUES
(9, '2019100705', 'Christian', 'De Asis', 1, 'cdeasis923@gmail.com', 'c54a9078828967579fad42a9d79c4c9a', 2, 1, 3, '1655899140_Christian De Asis.PNG', '2022-06-22 19:59:28'),
(10, '2019102030', 'RJ', 'Ocat', 1, 'rj_ocat@gmail.com', 'c54a9078828967579fad42a9d79c4c9a', 3, 1, 3, '1655902980_Capture.PNG', '2022-06-22 21:03:12'),
(11, '2019100706', 'Paul', 'Bucana', 1, 'paul_christian@gmail.com', 'c54a9078828967579fad42a9d79c4c9a', 2, 1, 3, 'no-image-available.png', '2022-06-22 21:30:09');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
(1, 'Scholarship Information Portal', 'scholarhub@gmail.com', '+639279572101', 'Zone 7 Poblacion Cagayan de Oro City', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `avatar`, `date_created`) VALUES
(1, 'Administrator', '', 'admin@admin.com', '0192023a7bbd73250516f069df18b500', '1607135820_avatar.jpg', '2020-11-26 10:57:04');

-- --------------------------------------------------------

--
-- Table structure for table `year_list`
--

CREATE TABLE `year_list` (
  `id` int(30) NOT NULL,
  `level` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `year_list`
--

INSERT INTO `year_list` (`id`, `level`) VALUES
(1, '1st'),
(2, '2nd'),
(3, '3rd'),
(4, '4th');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course_list`
--
ALTER TABLE `course_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_list`
--
ALTER TABLE `criteria_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluation_list`
--
ALTER TABLE `evaluation_list`
  ADD PRIMARY KEY (`evaluation_id`);

--
-- Indexes for table `event_list`
--
ALTER TABLE `event_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `org_list`
--
ALTER TABLE `org_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_list`
--
ALTER TABLE `question_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restriction_list`
--
ALTER TABLE `restriction_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_list`
--
ALTER TABLE `status_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_list`
--
ALTER TABLE `student_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `year_list`
--
ALTER TABLE `year_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course_list`
--
ALTER TABLE `course_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `criteria_list`
--
ALTER TABLE `criteria_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `evaluation_list`
--
ALTER TABLE `evaluation_list`
  MODIFY `evaluation_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `event_list`
--
ALTER TABLE `event_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `org_list`
--
ALTER TABLE `org_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `question_list`
--
ALTER TABLE `question_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `restriction_list`
--
ALTER TABLE `restriction_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `status_list`
--
ALTER TABLE `status_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_list`
--
ALTER TABLE `student_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `year_list`
--
ALTER TABLE `year_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



