-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 20, 2019 at 01:17 PM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wke_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(500) NOT NULL,
  `date` varchar(500) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `ip_address` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1676 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `description`, `date`, `user_id`, `ip_address`) VALUES
(1664, 'View Roles', '1566297226', 20, '::1'),
(1665, 'View dashboard', '1566297229', 20, '::1'),
(1666, 'User Status Updated [ID:21]', '1566297516', 20, '::1'),
(1667, 'User Status Updated [ID:21]', '1566297517', 20, '::1'),
(1668, 'View Projects', '1566302703', 20, '::1'),
(1669, 'View Roles', '1566303421', 20, '::1'),
(1670, 'View Categories', '1566304771', 20, '::1'),
(1671, 'View Categories', '1566304862', 20, '::1'),
(1672, 'View dashboard', '1566304864', 20, '::1'),
(1673, 'View dashboard', '1566304872', 20, '::1'),
(1674, 'View dashboard', '1566305078', 20, '::1'),
(1675, 'View dashboard', '1566305399', 20, '::1');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created` varchar(500) NOT NULL,
  `updated` varchar(500) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `user_id`, `created`, `updated`, `is_active`, `is_deleted`) VALUES
(1, 'post-create', 20, '1565352886', '1566200011', 1, 0),
(2, 'post-update', 20, '1565353465', '1566205660', 1, 0),
(4, 'AdminSite', 2, '1565413296', '', 1, 1),
(5, 'post-dlete', 20, '1566025473', '1566205669', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id` varchar(500) NOT NULL,
  `name` varchar(500) NOT NULL,
  `details` varchar(500) DEFAULT NULL,
  `created` varchar(500) NOT NULL,
  `updated` varchar(500) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_id`, `name`, `details`, `created`, `updated`, `is_deleted`) VALUES
(1, 'PROJECT_57', 'post-create123456', 'This project is maintenance based', '1565269268', '1565766201', 1),
(2, 'PROJECT_81', 'API Devlopment', 'New Android API', '1565324506', '1566282998', 0),
(3, 'PROJECT_35', 'post-create', 'New Android API', '1565766189', '', 0),
(4, 'PROJECT_94', 'Jemin Nagoria', 'This project is maintenance based', '1565774397', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `permissions` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `permissions`) VALUES
(1, 'Admin', 'a:4:{s:5:\"users\";a:4:{i:0;s:4:\"View\";i:1;s:6:\"Create\";i:2;s:4:\"Edit\";i:3;s:6:\"Delete\";}s:8:\"projects\";a:4:{i:0;s:4:\"View\";i:1;s:6:\"Create\";i:2;s:4:\"Edit\";i:3;s:6:\"Delete\";}s:10:\"categories\";a:4:{i:0;s:4:\"View\";i:1;s:6:\"Create\";i:2;s:4:\"Edit\";i:3;s:6:\"Delete\";}s:5:\"roles\";a:4:{i:0;s:4:\"View\";i:1;s:6:\"Create\";i:2;s:4:\"Edit\";i:3;s:6:\"Delete\";}}'),
(4, 'Super Admin', 'a:2:{s:5:\"users\";a:4:{i:0;s:4:\"View\";i:1;s:6:\"Create\";i:2;s:4:\"Edit\";i:3;s:6:\"Delete\";}s:8:\"projects\";a:2:{i:0;s:4:\"View\";i:1;s:6:\"Create\";}}'),
(3, 'Moderator', 'a:4:{s:5:\"users\";a:1:{i:0;s:4:\"View\";}s:8:\"projects\";a:1:{i:0;s:4:\"View\";}s:10:\"categories\";a:1:{i:0;s:4:\"View\";}s:5:\"roles\";a:2:{i:0;s:4:\"View\";i:1;s:6:\"Create\";}}'),
(10, 'shivani', 'a:1:{s:5:\"users\";a:2:{i:0;s:4:\"View\";i:1;s:6:\"Create\";}}'),
(11, 'post-create', 'a:1:{s:5:\"users\";a:1:{i:0;s:4:\"View\";}}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(500) NOT NULL,
  `mobile_no` bigint(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `last_ip` varchar(40) NOT NULL,
  `last_login` varchar(500) DEFAULT 'Never',
  `last_password_change` varchar(500) NOT NULL,
  `auth_token` varchar(500) DEFAULT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `firstname`, `lastname`, `email`, `mobile_no`, `password`, `last_ip`, `last_login`, `last_password_change`, `auth_token`, `is_active`, `is_deleted`) VALUES
(24, 1, 'Shivani ', 'Tamakuwala', 'shivani.nagoria159@gmail.com', 9727844003, '14e1b600b1fd579f47433b88e8d85291', '::1', '1565700576', '', NULL, 1, 0),
(23, 1, 'Jemin', 'Tmakuwala', 'jemin@gmail.com1234', 9727844003, '2a810c88e3cb947e85bbab2728102f0d', '', 'Never', '', NULL, 1, 0),
(25, 3, 'sdnarola', 'sd', 'sd@narola.email', 123545666333, 'd41d8cd98f00b204e9800998ecf8427e', '::1', '1565933064', '1565938213', NULL, 1, 0),
(20, 1, 'Shivani ', 'Nagoria', 'sna@narola.email', 9727844003, 'e10adc3949ba59abbe56e057f20f883e', '::1', '1566284089', '1566283862', NULL, 1, 0),
(21, 4, 'Jemin', 'Nagoria', 'jemin@gmail.com', 9426114469, 'e10adc3949ba59abbe56e057f20f883e', '::1', '1565693799', '1566210874', NULL, 1, 0),
(22, 1, 'Sagar', 'Tamakuwala', 'sagartamakuwala@gmail.com', 9727844003, 'e10adc3949ba59abbe56e057f20f883e', '', 'Never', '1566022320', NULL, 1, 0),
(26, 3, 'Shivani 123', 'sna', 'sna123@narola.email', 9727844003, 'e10adc3949ba59abbe56e057f20f883e', '::1', '1566284172', '', NULL, 1, 0),
(27, 1, 'Mickey', 'Mouse', 'mickery@gmail.com', 9727844003, 'e10adc3949ba59abbe56e057f20f883e', '', 'Never', '', NULL, 1, 0),
(28, 1, 'mina', 'pwq', 'mana@gmail.com', 98513467, 'd41d8cd98f00b204e9800998ecf8427e', '', 'Never', '', NULL, 1, 0),
(29, 4, 'Mickey', 'auyb', 'mickey21w@gmail.com', 9727844003, 'e10adc3949ba59abbe56e057f20f883e', '', 'Never', '', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
CREATE TABLE IF NOT EXISTS `user_permissions` (
  `user_id` bigint(20) NOT NULL,
  `features` varchar(500) NOT NULL,
  `capabilities` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`user_id`, `features`, `capabilities`) VALUES
(20, 'roles', 'Delete'),
(23, 'projects', 'delete'),
(24, 'categories', 'Delete'),
(22, 'projects', 'View'),
(27, 'roles', 'Edit'),
(23, 'projects', 'edit'),
(24, 'categories', 'Edit'),
(21, 'users', 'View'),
(28, 'roles', 'Edit'),
(23, 'projects', 'create'),
(24, 'categories', 'Create'),
(27, 'roles', 'Create'),
(20, 'roles', 'Edit'),
(23, 'projects', 'view'),
(24, 'categories', 'View'),
(27, 'roles', 'View'),
(23, 'users', 'delete'),
(28, 'roles', 'Create'),
(24, 'projects', 'Delete'),
(27, 'categories', 'Delete'),
(27, 'categories', 'Edit'),
(23, 'users', 'edit'),
(24, 'projects', 'Edit'),
(20, 'roles', 'Create'),
(28, 'roles', 'View'),
(24, 'projects', 'Create'),
(23, 'users', 'create'),
(20, 'roles', 'View'),
(27, 'categories', 'Create'),
(24, 'projects', 'View'),
(23, 'users', 'view'),
(28, 'categories', 'Delete'),
(27, 'categories', 'View'),
(23, 'categories', 'delete'),
(24, 'users', 'Delete'),
(20, 'categories', 'Delete'),
(27, 'projects', 'Delete'),
(23, 'categories', 'edit'),
(24, 'users', 'Edit'),
(28, 'categories', 'Edit'),
(27, 'projects', 'Edit'),
(20, 'categories', 'Edit'),
(27, 'projects', 'Create'),
(23, 'categories', 'create'),
(24, 'users', 'Create'),
(28, 'categories', 'Create'),
(27, 'projects', 'View'),
(23, 'categories', 'view'),
(24, 'users', 'View'),
(20, 'categories', 'Create'),
(27, 'users', 'Delete'),
(28, 'categories', 'View'),
(27, 'users', 'Edit'),
(21, 'users', 'Create'),
(21, 'users', 'Edit'),
(22, 'users', 'Delete'),
(21, 'users', 'Delete'),
(22, 'users', 'Edit'),
(21, 'projects', 'View'),
(22, 'users', 'Create'),
(21, 'projects', 'Create'),
(22, 'users', 'View'),
(20, 'categories', 'View'),
(25, 'roles', 'View'),
(25, 'users', 'View'),
(27, 'users', 'Create'),
(28, 'projects', 'Edit'),
(27, 'users', 'View'),
(22, 'projects', 'Create'),
(22, 'projects', 'Edit'),
(22, 'projects', 'Delete'),
(22, 'categories', 'View'),
(22, 'categories', 'Create'),
(22, 'categories', 'Edit'),
(22, 'categories', 'Delete'),
(22, 'roles', 'View'),
(22, 'roles', 'Create'),
(22, 'roles', 'Edit'),
(22, 'roles', 'Delete'),
(24, 'roles', 'View'),
(24, 'roles', 'Create'),
(24, 'roles', 'Edit'),
(24, 'roles', 'Delete'),
(27, 'roles', 'Delete'),
(28, 'projects', 'Delete'),
(20, 'projects', 'Delete'),
(20, 'projects', 'Edit'),
(28, 'projects', 'Create'),
(20, 'projects', 'Create'),
(28, 'projects', 'View'),
(20, 'projects', 'View'),
(28, 'users', 'Delete'),
(20, 'users', 'Delete'),
(28, 'users', 'Edit'),
(20, 'users', 'Edit'),
(29, 'users', 'View'),
(29, 'users', 'Create'),
(29, 'users', 'Edit'),
(29, 'users', 'Delete'),
(29, 'projects', 'View'),
(29, 'projects', 'Create'),
(28, 'users', 'Create'),
(20, 'users', 'Create'),
(28, 'users', 'View'),
(20, 'users', 'View'),
(28, 'roles', 'Delete'),
(26, 'roles', 'Create'),
(26, 'categories', 'View'),
(26, 'roles', 'View'),
(26, 'projects', 'View'),
(26, 'users', 'View');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
