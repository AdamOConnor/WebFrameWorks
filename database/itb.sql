-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Apr 29, 2016 at 12:46 PM
-- Server version: 10.1.9-MariaDB-log
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itb`
--
CREATE DATABASE IF NOT EXISTS `itb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `itb`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `username`, `password`, `role`) VALUES
(1, 'admin@itb.ie', 'admin', '$2y$10$gbhk2y00DTq2XLZ6GgvsJOoVuSFciVorPYVL3SL1zCpP8PqDHbMh6', 'Lecturer'),
(2, 'mattsmith@itb.ie', 'matt', '$2y$10$Sr5NYiTkk/SRgpU8LSkNK.U7W3tlWuGu0RAg5ZYrkgnYKHE9vefDG', 'Lecturer');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `job` int(10) NOT NULL,
  `name` text NOT NULL,
  `surname` text NOT NULL,
  `email` text NOT NULL,
  `number` int(11) NOT NULL,
  `image` text NOT NULL,
  `status` text NOT NULL,
  `address` text NOT NULL,
  `town` text NOT NULL,
  `city` text NOT NULL,
  `eircode` text NOT NULL,
  `country` text NOT NULL,
  `employment` text NOT NULL,
  `qualifications` text NOT NULL,
  `skills` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `job`, `name`, `surname`, `email`, `number`, `image`, `status`, `address`, `town`, `city`, `eircode`, `country`, `employment`, `qualifications`, `skills`) VALUES
(2, 3, 'Joe', 'Bloggs', 'adam-o-connor@hotmail.com', 851234567, 'upload/noImage.png', 'employed', '123 Fake Street', 'Springfield', 'Dublin', 'F4KÂ£STR33T', 'Ireland', 'STEPPING STONE ADVERTISING, New York, NY\r\n        A full-service ad agency devoted to the well-planned execution of customized direct and digital marketing campaigns. \r\n        Graphic Design Specialist, Aug 2009-May 2011.\r\n        - Developed numerous marketing programs (logos, brochures, newsletters, infographics, presentations, and advertisements) and guaranteed that they exceeded the expectations of our clients.\r\n        - Managed up to 5 projects or tasks at a given time while under pressure to meet weekly deadlines.\r\n        - Recommended and consulted with clients on the most appropriate graphic design options based on their overall marketing goals.\r\n        - Created 4+ design presentations and proposals a month for clients and account managers.', 'ROCHESTER INSTITUTE OF TECHNOLOGY, Rochester NY\r\n        Bachelor of Fine Arts in Graphic Design May 2009\r\n        - GPA: 3.4/4.0\r\n        - Designed the school''s online newspaper', '        - Proficiency in Adobe Creative Suite (InDesign, Illustrator, Photoshop)\r\n        - Member of the Society for Experiential Graphic Design (SEGD)\r\n        - Skilled in Microsoft Office Suite\r\n        - Working knowledge of HTML and CSS\r\n        - Bilingual in English and Spanish');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `status` text NOT NULL,
  `username` text NOT NULL,
  `company` text NOT NULL,
  `description` text NOT NULL,
  `position` text NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `status`, `username`, `company`, `description`, `position`, `timestamp`) VALUES
(3, 'Active', 'glaxo', 'Glaxo Technologies', 'new Graphic design position available.', 'Graphic Designer', 1461919500);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `user` text NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `email`, `text`, `user`, `timestamp`) VALUES
(1, 'adam-o-connor@hotmail.com', 'hello ?\r\n', 'adam', 1461895828);

-- --------------------------------------------------------

--
-- Table structure for table `private`
--

CREATE TABLE `private` (
  `id` int(11) NOT NULL,
  `sender` text NOT NULL,
  `receiver` text NOT NULL,
  `text` text NOT NULL,
  `about` text NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `private`
--

INSERT INTO `private` (`id`, `sender`, `receiver`, `text`, `about`, `timestamp`) VALUES
(1, 'glaxo', 'admin', 'hey thanks for sending my job out ', 'About Job', 1461895791),
(2, 'adam', 'admin', 'hey what kind of image would be best to submit \r\nthanks.', 'Image', 1461932644);

-- --------------------------------------------------------

--
-- Table structure for table `resume`
--

CREATE TABLE `resume` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` text NOT NULL,
  `number` int(15) NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `town` text NOT NULL,
  `city` text NOT NULL,
  `eircode` varchar(15) NOT NULL,
  `country` text NOT NULL,
  `employment` text NOT NULL,
  `qualifications` text NOT NULL,
  `skills` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resume`
--

INSERT INTO `resume` (`id`, `email`, `name`, `surname`, `number`, `image`, `status`, `address`, `town`, `city`, `eircode`, `country`, `employment`, `qualifications`, `skills`) VALUES
(2, 'adam-o-connor@hotmail.com', 'Joe', 'Bloggs', 851234567, 'upload/noImage.png', 'employed', '123 Fake Street', 'Springfield', 'Dublin', 'F4KÂ£STR33T', 'Ireland', 'STEPPING STONE ADVERTISING, New York, NY\r\n        A full-service ad agency devoted to the well-planned execution of customized direct and digital marketing campaigns. \r\n        Graphic Design Specialist, Aug 2009-May 2011.\r\n        - Developed numerous marketing programs (logos, brochures, newsletters, infographics, presentations, and advertisements) and guaranteed that they exceeded the expectations of our clients.\r\n        - Managed up to 5 projects or tasks at a given time while under pressure to meet weekly deadlines.\r\n        - Recommended and consulted with clients on the most appropriate graphic design options based on their overall marketing goals.\r\n        - Created 4+ design presentations and proposals a month for clients and account managers.', 'ROCHESTER INSTITUTE OF TECHNOLOGY, Rochester NY\r\n        Bachelor of Fine Arts in Graphic Design May 2009\r\n        - GPA: 3.4/4.0\r\n        - Designed the school''s online newspaper', '        - Proficiency in Adobe Creative Suite (InDesign, Illustrator, Photoshop)\r\n        - Member of the Society for Experiential Graphic Design (SEGD)\r\n        - Skilled in Microsoft Office Suite\r\n        - Working knowledge of HTML and CSS\r\n        - Bilingual in English and Spanish');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(500) NOT NULL,
  `role` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `role`, `status`) VALUES
(1, 'glaxo@glaxo.ie', 'glaxo', '$2y$10$jaQUeKNm9YuGMKjYU0iPCuzXlj8W8AivMhI4gM6pZqdgNIQE4gxT.', 'Employer', 'employed'),
(2, 'adam-o-connor@hotmail.com', 'adam', '$2y$10$KE8azATyhpI4/zIU8GJOzeuuYJW4D9f05Wef7AOSyj2qZEdkBg4UO', 'Student', 'employed');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `private`
--
ALTER TABLE `private`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resume`
--
ALTER TABLE `resume`
  ADD PRIMARY KEY (`id`),
  ADD KEY `firstname` (`name`),
  ADD KEY `firstname_2` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `private`
--
ALTER TABLE `private`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
