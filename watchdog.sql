-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 03, 2018 at 11:24 PM
-- Server version: 5.5.57-0ubuntu0.14.04.1
-- PHP Version: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `watchdog`
--
CREATE DATABASE IF NOT EXISTS `watchdog` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `watchdog`;

-- --------------------------------------------------------

--
-- Table structure for table `networks`
--

CREATE TABLE IF NOT EXISTS `networks` (
`id` int(11) NOT NULL,
  `base` varchar(60) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nodes`
--

CREATE TABLE IF NOT EXISTS `nodes` (
`id` int(11) NOT NULL,
  `scan_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `mac` varchar(60) NOT NULL DEFAULT '00:00:00:00:00:00',
  `ip` varchar(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ports`
--

CREATE TABLE IF NOT EXISTS `ports` (
`id` int(11) NOT NULL,
  `node_id` int(11) NOT NULL,
  `port` int(11) NOT NULL,
  `state` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scans`
--

CREATE TABLE IF NOT EXISTS `scans` (
`id` int(11) NOT NULL,
  `network_id` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `watching`
--

CREATE TABLE IF NOT EXISTS `watching` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `networks`
--
ALTER TABLE `networks`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nodes`
--
ALTER TABLE `nodes`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ports`
--
ALTER TABLE `ports`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scans`
--
ALTER TABLE `scans`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `watching`
--
ALTER TABLE `watching`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `networks`
--
ALTER TABLE `networks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `nodes`
--
ALTER TABLE `nodes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `ports`
--
ALTER TABLE `ports`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=166;
--
-- AUTO_INCREMENT for table `scans`
--
ALTER TABLE `scans`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `watching`
--
ALTER TABLE `watching`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
