-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2016 at 04:28 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `code_spring`
--
CREATE DATABASE IF NOT EXISTS `code_spring` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `code_spring`;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `company` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `name`, `company`, `location`, `email`, `mobile`, `username`, `password`) VALUES
(1, 'Lakshay Verma', 'Advait SparX', 'Jalandhar', 'lake.verma25@gmail.com', '+919779333346', 'lk7253', '9713'),
(2, 'Mandeep Kaur', 'Mandy Softwares', 'Jalandhar', 'mandeepshabina@gmail.com', '7589417253', 'mandy', '123'),
(3, 'Desmond', 'Templars', 'Italy', 'creed@ubisoft.com', '12345', 'desmond', 'miles'),
(4, '7253', '25', '', '', 'abc', '7253', 'lk'),
(5, '8946', '553', '', '', '', '8946', '553'),
(6, 'LK', 'Wall', 'Nut', 'dev@wall.net', 'av', 'lkv', '123');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posted_by` int(11) NOT NULL,
  `user_type` set('client','user') NOT NULL DEFAULT 'client',
  `project` int(11) NOT NULL,
  `comment` text NOT NULL,
  `posted_on` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `CommentFor_idx` (`project`),
  KEY `CommentByClient_idx` (`posted_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `posted_by`, `user_type`, `project`, `comment`, `posted_on`) VALUES
(1, 1, 'user', 2, 'Hi there how are you?', '2016-03-14 14:04:02'),
(2, 1, 'user', 2, 'HI everyone are you ready for the bang?', '2016-03-14 14:09:54'),
(3, 2, 'user', 2, 'Wooohooo!!!', '2016-03-14 14:17:48'),
(4, 1, 'client', 1, 'Why is this project not progressing? I there any issue with the team? Please let us know.', '2016-03-14 14:30:23'),
(5, 1, 'user', 1, 'Sorry for the delay but we are facing some technical difficulties.', '2016-03-14 14:31:20'),
(6, 3, 'client', 2, 'please let us know the project details by midnight. Thankyou <strong>Mid-Night</strong>', '2016-03-14 14:36:18'),
(7, 3, 'user', 1, 'When can I work on other projects as well?', '2016-03-14 14:39:24'),
(8, 3, 'user', 2, '', '2016-03-14 14:39:57'),
(9, 4, 'user', 1, 'As soon as the project gets manager.', '2016-03-14 14:52:40'),
(10, 1, 'user', 3, 'My first comment for this project to verify the working.', '2016-03-31 20:31:08'),
(11, 3, 'client', 2, 'Why is the project not complete yet?', '2016-04-02 12:53:51');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `description` text,
  `head` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `description`, `head`) VALUES
(1, 'Management', 'The department is top level and controls all the work in the company.', 1),
(2, 'Graphics', NULL, 1),
(3, 'Coding', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `deadline` date NOT NULL,
  `project_manager` int(11) NOT NULL,
  `current_stage` enum('Initial','Design','Code','Test','Final','Executed','Failed') NOT NULL DEFAULT 'Initial',
  PRIMARY KEY (`id`),
  KEY `ProjectClient_idx` (`client_id`),
  KEY `ProjectManager_idx` (`project_manager`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `name`, `description`, `client_id`, `start_date`, `deadline`, `project_manager`, `current_stage`) VALUES
(1, 'Project 1', 'My first dummy project', 1, '2017-01-01', '2018-10-31', 4, 'Initial'),
(2, 'Project 2', 'My second dummy project', 3, '2016-03-04', '2016-03-30', 2, 'Initial'),
(3, 'Project 3', 'Yet another project', 3, '2016-03-05', '2016-03-31', 1, 'Final'),
(4, 'Assasins Creed', 'A great game it is.', 3, '2011-03-25', '2013-07-09', 4, 'Initial'),
(5, 'One Piece', 'This is an anime series aired in Japan, following the story of a yound pirate, Monkey D Luffy who aims to become the pirate king by finding the great treasure hidden by Gol D Roger somewhere in Grand Line.', 1, '1998-07-27', '2036-12-29', 2, 'Failed'),
(6, 'Naruto', 'Another Anime about a Ninja who has power of a Nine Tailed Demon fox inside', 1, '1999-01-01', '2008-02-28', 4, 'Initial'),
(7, 'Bleach', 'ICHIGO becomes a Shinigami, and saves world.', 3, '2006-10-31', '2012-12-29', 4, 'Initial'),
(8, 'New', 'ONE', 1, '2016-05-20', '2016-05-19', 4, 'Initial');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `description` text NOT NULL,
  `project` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `stage` set('Initial','Mid','Testing','Final','Done','Failed') NOT NULL DEFAULT 'Initial',
  `deadline` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `AssignedTo_idx` (`assigned_to`),
  KEY `TaskFor_idx` (`project`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `name`, `description`, `project`, `assigned_to`, `stage`, `deadline`) VALUES
(1, 'Task 1', 'Task for my first project', 1, 1, 'Mid', '0000-00-00'),
(2, 'Task 2', 'Another task for my project 1', 1, 2, 'Done', '0000-00-00'),
(3, 'Major 1', 'A task that is important for me', 1, 1, 'Initial', '0000-00-00'),
(4, 'Play Me', 'Try again in a little while.', 2, 3, 'Initial', '0000-00-00'),
(5, 'Desmond''s Journey', 'AC 1', 4, 2, 'Done', '0000-00-00'),
(6, 'Ezio saga begins', 'AC 2', 4, 1, 'Done', '0000-00-00'),
(7, 'Start the coding', 'Yes do the code in a freaky way. You can do it I know for sure.', 3, 2, 'Mid', '0000-00-00'),
(8, 'Modify Tasks', 'Create the tasks for this very project in order to assign them to other users. We are required to complete the project by deadline.', 3, 1, 'Final', '0000-00-00'),
(9, 'System Analysis', '', 5, 4, 'Initial', '0000-00-00'),
(10, 'System Design', '', 5, 4, 'Initial', '0000-00-00'),
(11, 'Coding', '', 5, 4, 'Initial', '0000-00-00'),
(12, 'Testing', '', 5, 4, 'Initial', '0000-00-00'),
(13, 'Implementation', '', 5, 4, 'Initial', '0000-00-00'),
(14, 'Maintainance', '', 5, 4, 'Initial', '0000-00-00'),
(15, 'System Analysis', '', 6, 4, 'Initial', '0000-00-00'),
(16, 'System Design', '', 6, 4, 'Initial', '0000-00-00'),
(17, 'Coding', '', 6, 4, 'Initial', '0000-00-00'),
(18, 'Testing', '', 6, 4, 'Initial', '0000-00-00'),
(19, 'Implementation', '', 6, 4, 'Initial', '0000-00-00'),
(20, 'Maintainance', '', 6, 4, 'Initial', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL,
  `designation` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`username`),
  KEY `BelongsTO_idx` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `username`, `password`, `department_id`, `designation`) VALUES
(1, 'Lakshay', 'Verma', 'lakshay', 'lk', 1, 'Head'),
(2, 'Raziel', 'Kain', 'raziel', '1', 3, 'Lead'),
(3, 'Ezio', 'Auditore', 'ezio', '1', 2, 'Junior'),
(4, 'Super', 'User', 'su', 'L*v8946553', 1, 'Head');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `CommentFor` FOREIGN KEY (`project`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `ProjectClient` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ProjectManager` FOREIGN KEY (`project_manager`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `AssignedTo` FOREIGN KEY (`assigned_to`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `TaskFor` FOREIGN KEY (`project`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `BelongsTO` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
