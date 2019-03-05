-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 05, 2019 at 09:57 PM
-- Server version: 5.7.25-0ubuntu0.18.04.2
-- PHP Version: 7.2.15-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `connectIt`
--

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `sessionsid` varchar(100) NOT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `menu` varchar(50) DEFAULT NULL,
  `pg` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `others` varchar(50) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `msisdn` varchar(18) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `update_ts` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Handle the sessions';

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`sessionsid`, `tel`, `menu`, `pg`, `created_at`, `others`, `name`, `msisdn`, `age`, `sex`, `update_ts`) VALUES
('123', 'tel:8801866742387', 'friend-list-1', '0', '2019-03-05 14:38:31', 'age-init', NULL, NULL, 1, 1, '2019-03-05 20:08:58'),
('1231', 'tel:8801866742387', 'friend-list-2', '0', '2019-03-05 16:06:48', 'age-init', NULL, NULL, 1, 1, '2019-03-05 21:39:46'),
('12311', 'tel:8801866742387', 'friend-list-3', '0', '2019-03-05 16:09:55', 'age-init', NULL, NULL, 1, 1, '2019-03-05 21:56:03');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_connect`
--

CREATE TABLE `tbl_connect` (
  `id` int(10) NOT NULL,
  `uid_inviter` int(10) NOT NULL,
  `uid_inviee` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - pending, 1 - accept, 2 - reject , 3 - reject',
  `create_ts` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_ts` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_friends`
--

CREATE TABLE `tbl_friends` (
  `id` int(11) NOT NULL,
  `urq` int(11) NOT NULL,
  `urs` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `create_ts` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_ts` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscriber`
--

CREATE TABLE `tbl_subscriber` (
  `id` int(11) NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `sex` tinyint(4) DEFAULT NULL COMMENT '1 - male 2 female',
  `age` int(3) DEFAULT NULL,
  `msisdn` varchar(17) DEFAULT NULL,
  `create_ts` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_ts` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_subscriber`
--

INSERT INTO `tbl_subscriber` (`id`, `name`, `sex`, `age`, `msisdn`, `create_ts`, `update_ts`) VALUES
(1, 'Kavinda Rochana', 1, 25, '8801866742387', '2019-02-18 18:35:37', '2019-02-18 18:35:37'),
(2, 'Sakuni Nisansala', 2, 20, '8801866742387', '2019-02-18 21:06:39', '2019-02-21 21:50:47'),
(3, 'KasH', 1, 35, '8801866742387', '2019-02-18 21:07:43', '2019-02-21 21:51:04'),
(4, 'SakU', 2, 35, '8801866742387', '2019-02-18 21:11:44', '2019-02-21 21:51:19'),
(5, 'KS', 1, 55, NULL, '2019-02-18 22:52:36', '2019-02-21 21:51:28'),
(6, 'KSRN', 1, 40, '8801866742389', '2019-02-18 23:02:41', '2019-02-21 21:51:36'),
(7, 'KSKSKS', 2, 18, NULL, '2019-02-18 23:11:28', '2019-02-21 21:51:49'),
(8, 'KSKS', 1, 221, NULL, '2019-02-18 23:12:01', '2019-02-21 21:51:59'),
(9, 'AR', 2, 29, '8801866742400', '2019-02-19 12:43:03', '2019-02-21 21:52:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`sessionsid`);

--
-- Indexes for table `tbl_connect`
--
ALTER TABLE `tbl_connect`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_friends`
--
ALTER TABLE `tbl_friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_subscriber`
--
ALTER TABLE `tbl_subscriber`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_connect`
--
ALTER TABLE `tbl_connect`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_friends`
--
ALTER TABLE `tbl_friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_subscriber`
--
ALTER TABLE `tbl_subscriber`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
