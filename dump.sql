-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 25, 2012 at 05:21 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `statice`
--

CREATE TABLE IF NOT EXISTS `statice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `order` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `meta_description` text,
  `meta_keywords` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `statice`
--

INSERT INTO `statice` (`id`, `name`, `description`, `order`, `visible`, `meta_description`, `meta_keywords`) VALUES
(1, 'Intrare 1', '<p>Duis eu odio sit amet leo cursus euismod. Pellentesque tincidunt bibendum vehicula. Pellentesque bibendum ultrices massa, et lobortis nunc auctor tincidunt.</p>\r\n<p>Praesent eu mi velit, a varius nisi. Donec luctus rutrum risus ut bibendum. Vestibulum risus mauris, laoreet ut vulputate eget, vestibulum ac arcu.</p>\r\n<p>Morbi non sem arcu. Cras at libero a quam euismod malesuada. In sit amet felis non nulla congue gravida. Etiam elementum lobortis neque, at varius velit rhoncus gravida. Maecenas id nisi sem, quis convallis nunc. Suspendisse id mauris at dolor adipiscing vestibulum. Aliquam sit amet massa tellus, vel tincidunt erat. Vestibulum consectetur feugiat magna, ut volutpat dolor mattis eget.</p>', 1, 1, '', ''),
(2, 'Intrare 2', '<p>Duis eu odio sit amet leo cursus euismod. Pellentesque tincidunt bibendum vehicula. Pellentesque bibendum ultrices massa, et lobortis nunc auctor tincidunt. Praesent eu mi velit, a varius nisi. Donec luctus rutrum risus ut bibendum. Vestibulum risus mauris, laoreet ut vulputate eget, vestibulum ac arcu. Morbi non sem arcu. Cras at libero a quam euismod malesuada. In sit amet felis non nulla congue gravida. Etiam elementum lobortis neque, at varius velit rhoncus gravida. Maecenas id nisi sem, quis convallis nunc. Suspendisse id mauris at dolor adipiscing vestibulum. Aliquam sit amet massa tellus, vel tincidunt erat. Vestibulum consectetur feugiat magna, ut volutpat dolor mattis eget.</p>', 2, 0, NULL, NULL),
(5, 'Intrare 3', '<p><img src="http://localhost/cms/userfiles/box_pic2.jpg" class="alignright" height="93" width="162" /></p>\r\n<p>test</p>', 3, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sys_admins`
--

CREATE TABLE IF NOT EXISTS `sys_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sys_admins`
--

INSERT INTO `sys_admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '8287458823facb8ff918dbfabcd22ccb'),
(2, 'axello', '8287458823facb8ff918dbfabcd22ccb');

-- --------------------------------------------------------

--
-- Table structure for table `sys_admins_log`
--

CREATE TABLE IF NOT EXISTS `sys_admins_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sys_admins_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `sys_core_setup`
--

CREATE TABLE IF NOT EXISTS `sys_core_setup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `settings` text NOT NULL,
  `order` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sys_core_setup`
--

INSERT INTO `sys_core_setup` (`id`, `name`, `table_name`, `settings`, `order`, `visible`) VALUES
(1, 'Pagini statice', 'statice', 'a:3:{s:6:"config";a:11:{s:9:"tableName";s:7:"statice";s:8:"pageName";s:14:"Pagini statice";s:13:"displaiedName";s:4:"nume";s:21:"displaiedFriendlyName";s:4:"Nume";s:12:"limitPerPage";s:2:"20";s:11:"functionAdd";i:1;s:12:"functionEdit";i:1;s:14:"functionDelete";i:1;s:16:"functionSetOrder";i:1;s:15:"functionVisible";i:1;s:19:"functionCreateTable";i:1;}s:7:"message";a:6:{s:3:"add";s:15:"Adauca o pagina";s:4:"edit";s:15:"Editeaza pagina";s:9:"no_images";s:36:"Nu exista poze pentru aceasta pagina";s:8:"no_files";s:39:"Nu exista fisiere pentru aceasta pagina";s:5:"added";s:32:"Pagina a fost adaugata cu succes";s:7:"deleted";s:31:"Pagina a fost stearsa cu succes";}s:8:"elements";a:4:{s:4:"nume";a:4:{s:12:"friendlyName";s:4:"Nume";s:4:"type";s:4:"text";s:8:"required";s:1:"1";s:7:"colType";s:11:"varchar|100";}s:9:"descriere";a:4:{s:12:"friendlyName";s:9:"Descriere";s:4:"type";s:6:"editor";s:8:"required";s:1:"1";s:7:"colType";s:4:"text";}s:14:"meta_descriere";a:4:{s:12:"friendlyName";s:14:"Meta descirere";s:4:"type";s:8:"textarea";s:8:"required";s:1:"0";s:7:"colType";s:4:"text";}s:13:"meta_keywords";a:4:{s:12:"friendlyName";s:13:"Meta keywords";s:4:"type";s:8:"textarea";s:8:"required";s:1:"0";s:7:"colType";s:4:"text";}}}', 1, 1);
