-- phpMyAdmin SQL Dump
-- version 3.4.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 20, 2012 at 03:06 PM
-- Server version: 5.1.36
-- PHP Version: 5.2.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `j2.4_whmcs_5`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblaccounts`
--

CREATE TABLE IF NOT EXISTS `tblaccounts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `currency` int(10) NOT NULL,
  `gateway` text NOT NULL,
  `date` datetime DEFAULT NULL,
  `description` text NOT NULL,
  `amountin` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fees` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amountout` decimal(10,2) NOT NULL DEFAULT '0.00',
  `rate` decimal(10,5) NOT NULL DEFAULT '1.00000',
  `transid` text NOT NULL,
  `invoiceid` int(10) NOT NULL DEFAULT '0',
  `refundid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `invoiceid` (`invoiceid`),
  KEY `userid` (`userid`),
  KEY `date` (`date`),
  KEY `transid` (`transid`(32))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblactivitylog`
--

CREATE TABLE IF NOT EXISTS `tblactivitylog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` text NOT NULL,
  `user` text NOT NULL,
  `userid` int(10) NOT NULL,
  `ipaddr` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbladdonmodules`
--

CREATE TABLE IF NOT EXISTS `tbladdonmodules` (
  `module` text NOT NULL,
  `setting` text NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbladdons`
--

CREATE TABLE IF NOT EXISTS `tbladdons` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `packages` text NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `billingcycle` text NOT NULL,
  `tax` text NOT NULL,
  `showorder` text NOT NULL,
  `downloads` text NOT NULL,
  `autoactivate` text NOT NULL,
  `suspendproduct` text NOT NULL,
  `welcomeemail` int(10) NOT NULL,
  `weight` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`(32))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbladminlog`
--

CREATE TABLE IF NOT EXISTS `tbladminlog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `adminusername` text NOT NULL,
  `logintime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logouttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ipaddress` text NOT NULL,
  `sessionid` text NOT NULL,
  `lastvisit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `logouttime` (`logouttime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbladminlog`
--

INSERT INTO `tbladminlog` (`id`, `adminusername`, `logintime`, `logouttime`, `ipaddress`, `sessionid`, `lastvisit`) VALUES
(1, 'admin', '2012-04-20 10:25:49', '2012-04-20 15:05:11', '127.0.0.1', '4ji435ib8ju8bu0jcem09k3bl3', '0000-00-00 00:00:00'),
(2, 'admin', '2012-04-20 10:25:49', '2012-04-20 15:05:11', '127.0.0.1', '4ji435ib8ju8bu0jcem09k3bl3', '2012-04-20 10:28:24'),
(3, 'admin', '2012-04-20 15:05:11', '0000-00-00 00:00:00', '127.0.0.1', 'f709nssp0i50kvgbf3vqma4072', '0000-00-00 00:00:00'),
(4, 'admin', '2012-04-20 15:05:11', '0000-00-00 00:00:00', '127.0.0.1', 'f709nssp0i50kvgbf3vqma4072', '2012-04-20 15:06:35');

-- --------------------------------------------------------

--
-- Table structure for table `tbladminperms`
--

CREATE TABLE IF NOT EXISTS `tbladminperms` (
  `roleid` int(1) NOT NULL,
  `permid` int(1) NOT NULL,
  KEY `roleid_permid` (`roleid`,`permid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbladminperms`
--

INSERT INTO `tbladminperms` (`roleid`, `permid`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(1, 54),
(1, 55),
(1, 56),
(1, 57),
(1, 58),
(1, 59),
(1, 60),
(1, 61),
(1, 62),
(1, 63),
(1, 64),
(1, 65),
(1, 66),
(1, 67),
(1, 68),
(1, 69),
(1, 70),
(1, 71),
(1, 72),
(1, 73),
(1, 74),
(1, 75),
(1, 76),
(1, 77),
(1, 78),
(1, 79),
(1, 80),
(1, 81),
(1, 82),
(1, 83),
(1, 84),
(1, 85),
(1, 86),
(1, 87),
(1, 88),
(1, 89),
(1, 90),
(1, 91),
(1, 92),
(1, 93),
(1, 94),
(1, 95),
(1, 96),
(1, 97),
(1, 98),
(1, 99),
(1, 100),
(1, 101),
(1, 102),
(1, 103),
(1, 104),
(1, 105),
(1, 106),
(1, 107),
(1, 108),
(1, 109),
(1, 110),
(1, 111),
(1, 112),
(1, 113),
(1, 114),
(1, 115),
(1, 116),
(1, 117),
(1, 118),
(1, 119),
(1, 120),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(2, 25),
(2, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(2, 32),
(2, 33),
(2, 34),
(2, 35),
(2, 36),
(2, 37),
(2, 38),
(2, 39),
(2, 40),
(2, 41),
(2, 42),
(2, 43),
(2, 44),
(2, 45),
(2, 46),
(2, 47),
(2, 48),
(2, 49),
(2, 50),
(2, 51),
(2, 52),
(2, 71),
(2, 73),
(2, 85),
(2, 98),
(2, 99),
(2, 101),
(2, 104),
(2, 105),
(2, 110),
(2, 120),
(3, 38),
(3, 39),
(3, 40),
(3, 41),
(3, 42),
(3, 43),
(3, 44),
(3, 50),
(3, 105),
(4, 81);

-- --------------------------------------------------------

--
-- Table structure for table `tbladminroles`
--

CREATE TABLE IF NOT EXISTS `tbladminroles` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `widgets` text NOT NULL,
  `systememails` int(1) NOT NULL,
  `accountemails` int(1) NOT NULL,
  `supportemails` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbladminroles`
--

INSERT INTO `tbladminroles` (`id`, `name`, `widgets`, `systememails`, `accountemails`, `supportemails`) VALUES
(1, 'Full Administrator', 'activity_log,getting_started,income_forecast,income_overview,my_notes,network_status,open_invoices,orders_overview,paypal_addon,admin_activity,client_activity,system_overview,todo_list,whmcs_news,supporttickets_overview', 1, 1, 1),
(2, 'Sales Operator', 'activity_log,getting_started,income_forecast,income_overview,my_notes,network_status,open_invoices,orders_overview,paypal_addon,client_activity,todo_list,whmcs_news,supporttickets_overview', 0, 1, 1),
(3, 'Support Operator', 'activity_log,getting_started,my_notes,todo_list,whmcs_news,supporttickets_overview', 0, 0, 1),
(4, 'API Administrators', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbladmins`
--

CREATE TABLE IF NOT EXISTS `tbladmins` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `roleid` int(1) NOT NULL,
  `username` text NOT NULL,
  `password` varchar(32) NOT NULL DEFAULT '',
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `email` text NOT NULL,
  `signature` text NOT NULL,
  `notes` text NOT NULL,
  `template` text NOT NULL,
  `language` text NOT NULL,
  `loginattempts` int(1) NOT NULL,
  `supportdepts` text NOT NULL,
  `ticketnotifications` varchar(2) NOT NULL,
  `homewidgets` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`(32))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbladmins`
--

INSERT INTO `tbladmins` (`id`, `roleid`, `username`, `password`, `firstname`, `lastname`, `email`, `signature`, `notes`, `template`, `language`, `loginattempts`, `supportdepts`, `ticketnotifications`, `homewidgets`) VALUES
(1, 1, 'admin', 'b5ffa2f60613a2da93b654db69f3dfd1', 'Admin', 'User', 'admin@localhost.com', '', 'Welcome to WHMCS!  Please ensure you have setup the cron job in cPanel to automate tasks', 'blend', '', 0, ',', '', ''),
(2, 4, 'apiadmin', '5f4dcc3b5aa765d61d8327deb882cf99', 'API', 'Admin', 'apiadmin@localhost.com', '', '', 'blend', 'english', 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbladminsecurityquestions`
--

CREATE TABLE IF NOT EXISTS `tbladminsecurityquestions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblaffiliates`
--

CREATE TABLE IF NOT EXISTS `tblaffiliates` (
  `id` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `clientid` int(10) NOT NULL,
  `visitors` int(1) NOT NULL,
  `paytype` text NOT NULL,
  `payamount` decimal(10,2) NOT NULL,
  `onetime` int(1) NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `withdrawn` decimal(10,2) NOT NULL DEFAULT '0.00',
  KEY `affiliateid` (`id`),
  KEY `clientid` (`clientid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblaffiliatesaccounts`
--

CREATE TABLE IF NOT EXISTS `tblaffiliatesaccounts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `affiliateid` int(10) NOT NULL,
  `relid` int(10) NOT NULL,
  `lastpaid` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  KEY `affiliateid` (`affiliateid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblaffiliateshistory`
--

CREATE TABLE IF NOT EXISTS `tblaffiliateshistory` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `affiliateid` int(10) NOT NULL,
  `date` date NOT NULL,
  `affaccid` int(10) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `affiliateid` (`affiliateid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblaffiliatespending`
--

CREATE TABLE IF NOT EXISTS `tblaffiliatespending` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `affaccid` int(10) NOT NULL DEFAULT '0',
  `amount` decimal(10,2) NOT NULL,
  `clearingdate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `clearingdate` (`clearingdate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblaffiliateswithdrawals`
--

CREATE TABLE IF NOT EXISTS `tblaffiliateswithdrawals` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `affiliateid` int(10) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `affiliateid` (`affiliateid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblannouncements`
--

CREATE TABLE IF NOT EXISTS `tblannouncements` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `title` text NOT NULL,
  `announcement` text NOT NULL,
  `published` text NOT NULL,
  `parentid` int(10) NOT NULL,
  `language` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblbannedemails`
--

CREATE TABLE IF NOT EXISTS `tblbannedemails` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `domain` text NOT NULL,
  `count` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `domain` (`domain`(64))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblbannedips`
--

CREATE TABLE IF NOT EXISTS `tblbannedips` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` text NOT NULL,
  `reason` text NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`(32))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblbillableitems`
--

CREATE TABLE IF NOT EXISTS `tblbillableitems` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `description` text NOT NULL,
  `hours` decimal(5,1) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `recur` int(5) NOT NULL DEFAULT '0',
  `recurcycle` text NOT NULL,
  `recurfor` int(5) NOT NULL DEFAULT '0',
  `invoiceaction` int(1) NOT NULL,
  `duedate` date NOT NULL,
  `invoicecount` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblbrowserlinks`
--

CREATE TABLE IF NOT EXISTS `tblbrowserlinks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(32))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblbundles`
--

CREATE TABLE IF NOT EXISTS `tblbundles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `validfrom` date NOT NULL,
  `validuntil` date NOT NULL,
  `uses` int(4) NOT NULL,
  `maxuses` int(4) NOT NULL,
  `itemdata` text NOT NULL,
  `allowpromo` int(1) NOT NULL,
  `showgroup` int(1) NOT NULL,
  `gid` int(10) NOT NULL,
  `description` text NOT NULL,
  `displayprice` decimal(10,2) NOT NULL,
  `sortorder` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblcalendar`
--

CREATE TABLE IF NOT EXISTS `tblcalendar` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `desc` text NOT NULL,
  `day` text NOT NULL,
  `month` text NOT NULL,
  `year` text NOT NULL,
  `startt1` text NOT NULL,
  `startt2` text NOT NULL,
  `endt1` text NOT NULL,
  `endt2` text NOT NULL,
  `adminid` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `day_month_year` (`day`(2),`month`(2),`year`(4))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblcancelrequests`
--

CREATE TABLE IF NOT EXISTS `tblcancelrequests` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `relid` int(10) NOT NULL,
  `reason` text NOT NULL,
  `type` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `serviceid` (`relid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblclientgroups`
--

CREATE TABLE IF NOT EXISTS `tblclientgroups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(45) NOT NULL,
  `groupcolour` varchar(45) DEFAULT NULL,
  `discountpercent` decimal(10,2) unsigned DEFAULT '0.00',
  `susptermexempt` text,
  `separateinvoices` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblclients`
--

CREATE TABLE IF NOT EXISTS `tblclients` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `companyname` text NOT NULL,
  `email` text NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `postcode` text NOT NULL,
  `country` text NOT NULL,
  `phonenumber` text NOT NULL,
  `password` text NOT NULL,
  `currency` int(10) NOT NULL,
  `defaultgateway` text NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `taxexempt` text NOT NULL,
  `latefeeoveride` text NOT NULL,
  `overideduenotices` text NOT NULL,
  `separateinvoices` text NOT NULL,
  `disableautocc` text NOT NULL,
  `datecreated` date NOT NULL,
  `notes` text NOT NULL,
  `billingcid` int(10) NOT NULL,
  `securityqid` int(10) NOT NULL,
  `securityqans` text NOT NULL,
  `groupid` int(10) NOT NULL,
  `cardtype` varchar(255) NOT NULL DEFAULT '',
  `cardlastfour` text NOT NULL,
  `cardnum` blob NOT NULL,
  `startdate` blob NOT NULL,
  `expdate` blob NOT NULL,
  `issuenumber` blob NOT NULL,
  `bankname` text NOT NULL,
  `banktype` text NOT NULL,
  `bankcode` blob NOT NULL,
  `bankacct` blob NOT NULL,
  `gatewayid` text NOT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `ip` text NOT NULL,
  `host` text NOT NULL,
  `status` enum('Active','Inactive','Closed') NOT NULL DEFAULT 'Active',
  `language` text NOT NULL,
  `pwresetkey` text NOT NULL,
  `pwresetexpiry` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `firstname_lastname` (`firstname`(32),`lastname`(32)),
  KEY `email` (`email`(64))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

--
-- Dumping data for table `tblclients`
--

INSERT INTO `tblclients` (`id`, `firstname`, `lastname`, `companyname`, `email`, `address1`, `address2`, `city`, `state`, `postcode`, `country`, `phonenumber`, `password`, `currency`, `defaultgateway`, `credit`, `taxexempt`, `latefeeoveride`, `overideduenotices`, `separateinvoices`, `disableautocc`, `datecreated`, `notes`, `billingcid`, `securityqid`, `securityqans`, `groupid`, `cardtype`, `cardlastfour`, `cardnum`, `startdate`, `expdate`, `issuenumber`, `bankname`, `banktype`, `bankcode`, `bankacct`, `gatewayid`, `lastlogin`, `ip`, `host`, `status`, `language`, `pwresetkey`, `pwresetexpiry`) VALUES
(1, 'Riley', 'George', '', 'montes@Donecat.org', '670-7590 Erat Av.', '', 'Eden Prairie', 'Ontario', '23673', 'Svalbard and Jan Mayen', '(112) 964-7962', 'OIX41ICX5ZO', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(2, 'Basil', 'Vinson', '', 'lacus.Nulla.tincidunt@utdolordapibus.org', 'P.O. Box 566, 5485 Egestas Av.', '', 'Bozeman', 'MS', 'Q1F 5P1', 'Bhutan', '(208) 419-3031', 'YWE70SHC8CU', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(3, 'Bo', 'Knapp', '', 'egestas.Duis@idante.com', '390-3761 Facilisis St.', '', 'Houma', 'Mississippi', 'M4J 6F4', 'Heard Island and Mcdonald Islands', '(522) 504-0466', 'AZA03JKT9XC', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(4, 'Kevin', 'Lloyd', '', 'purus@quisarcuvel.edu', '658-2177 Eget St.', '', 'Perth Amboy', 'IL', '62142', 'Armenia', '(566) 765-2172', 'BML26SXX3FT', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet,', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(5, 'Roanna', 'Wilson', '', 'aliquam.adipiscing@tincidunt.org', '326-9176 Neque Ave', '', 'Indio', 'MT', '22616', 'Taiwan, Province of China', '(873) 554-2502', 'PAY27FMQ6NU', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(6, 'Linda', 'Lane', '', 'mollis.vitae@doloregestas.ca', 'Ap #281-9518 Donec Ave', '', 'Butte', 'Manitoba', '93469', 'United Kingdom', '(409) 792-3465', 'VVP55DTM2ZS', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(7, 'Connor', 'Glass', '', 'sit.amet.lorem@turpis.com', 'P.O. Box 532, 3056 Quis Avenue', '', 'North Platte', 'SK', 'M6U 9X7', 'Norfolk Island', '(895) 817-1994', 'DFR03EKB2HN', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(8, 'Gillian', 'Mcbride', '', 'ante@quis.edu', '532-922 Congue, Avenue', '', 'Covina', 'NS', 'A3W 1O1', 'Mauritania', '(791) 434-9551', 'TSY69KUE8HN', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet,', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(9, 'Rylee', 'Jones', '', 'mauris.ut@Aliquam.ca', 'P.O. Box 646, 4289 Aliquet, Rd.', '', 'Rye', 'VT', 'V9Z 9T2', 'Luxembourg', '(274) 643-1821', 'YEH43XWC0LQ', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(10, 'Roanna', 'Sharp', '', 'diam.Pellentesque.habitant@atlibero.ca', '218-6425 Mauris Rd.', '', 'Brockton', 'Quebec', 'X9I 1C7', 'Nigeria', '(174) 972-7430', 'HCX83BMM4GO', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(11, 'Guy', 'Ward', '', 'quis.turpis@mattissemper.ca', 'Ap #410-1602 Habitant Road', '', 'Bartlesville', 'NB', 'E2R 6R9', 'Cook Islands', '(722) 666-5071', 'NSF93OCK2IU', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet,', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(12, 'Martha', 'Sweet', '', 'Nunc.mauris@malesuada.ca', '962-2515 Lacinia Ave', '', 'Lock Haven', 'Michigan', '71013', 'Grenada', '(948) 965-5591', 'RZA06NZX0SH', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(13, 'Anne', 'Alston', '', 'Sed@habitantmorbi.ca', 'Ap #770-5914 In St.', '', 'Carrollton', 'NC', '32723', 'Korea', '(535) 534-5359', 'SRW86LQG5IA', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(14, 'Avye', 'Watts', '', 'velit.Quisque@orciPhasellus.org', 'P.O. Box 551, 204 Sed Rd.', '', 'Hastings', 'Pennsylvania', '42668', 'Tuvalu', '(728) 531-5369', 'TTQ72RGG0JF', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(15, 'Finn', 'Patton', '', 'gravida@facilisisSuspendisse.com', '6704 Donec Road', '', 'Tamuning', 'Newfoundland and Labrador', 'Q3D 9O2', 'Equatorial Guinea', '(833) 849-1113', 'UAS23MYF5HA', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(16, 'Mariko', 'Wolfe', '', 'fringilla@sed.edu', 'Ap #601-597 Id Avenue', '', 'San Luis Obispo', 'Newfoundland and Labrador', '05821', 'British Indian Ocean Territory', '(355) 762-4642', 'WNM54CBL9TV', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet,', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(17, 'Iliana', 'Cohen', '', 'eu.nibh.vulputate@non.edu', 'Ap #123-2222 Pharetra, Av.', '', 'Green River', 'Alabama', '40789', 'Maldives', '(749) 684-9015', 'IFQ19JEF7RS', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(18, 'Ora', 'Holman', '', 'semper.pretium.neque@tellusjustosit.edu', '4068 Non, St.', '', 'Clearwater', 'Kansas', 'M8R 6A3', 'France', '(729) 490-0398', 'JOZ37ZSX9HQ', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(19, 'Maggy', 'Hebert', '', 'adipiscing.elit.Curabitur@enimcommodohendrerit.com', '724-346 Placerat, Avenue', '', 'Norman', 'GA', 'Y7A 8T2', 'Latvia', '(134) 820-2109', 'RJP66HQG9LG', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(20, 'Kessie', 'Vinson', '', 'eu.metus.In@telluslorem.edu', '906-8614 Pede Rd.', '', 'McKeesport', 'QC', '96415', 'Turks and Caicos Islands', '(471) 972-5703', 'DVO94AWI5VD', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(21, 'Buffy', 'Bauer', '', 'vel@acnullaIn.com', 'P.O. Box 432, 2398 Sem, Ave', '', 'Vail', 'Nunavut', '61807', 'Pakistan', '(248) 608-7114', 'CXX25DPV0ZK', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(22, 'Oscar', 'Vazquez', '', 'Donec.felis.orci@auguescelerisque.ca', '2996 Semper Ave', '', 'La Mirada', 'Northwest Territories', '49907', 'American Samoa', '(910) 271-0409', 'XRA80SVJ1XV', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(23, 'Bernard', 'Wheeler', '', 'Aliquam.fringilla@natoquepenatibuset.edu', '2204 Quam Ave', '', 'Riverton', 'DC', '00483', 'Monaco', '(726) 836-3468', 'JPK36CDW8JE', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(24, 'Carter', 'Osborn', '', 'dignissim.tempor@Proin.ca', 'P.O. Box 682, 3014 Duis Avenue', '', 'Palmdale', 'Vermont', 'O6N 5M9', 'Netherlands Antilles', '(147) 399-9342', 'MHG44WSD1WE', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet,', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(25, 'Avram', 'Bowen', '', 'dolor.Fusce@temporarcuVestibulum.com', '458-8559 Ipsum Av.', '', 'Salem', 'BC', '62374', 'Ethiopia', '(947) 517-5135', 'XXZ37KUP1RS', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(26, 'Fiona', 'Lang', '', 'faucibus@utmolestiein.edu', '359-2984 Nibh Ave', '', 'Little Rock', 'MO', '22584', 'Czech Republic', '(690) 705-9587', 'IAX87FDA7TW', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(27, 'Abdul', 'Joseph', '', 'Duis.elementum@leoVivamusnibh.com', '408-6079 Libero Rd.', '', 'Ventura', 'Newfoundland and Labrador', 'X5G 9F9', 'South Georgia and The South Sandwich Islands', '(325) 375-7004', 'AJG67OGR7OY', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(28, 'Emmanuel', 'Robertson', '', 'auctor.ullamcorper@elitfermentum.org', '756-7885 Enim St.', '', 'Gu', 'Manitoba', 'X1H 6U8', 'Madagascar', '(765) 598-3419', 'GSC39VCI5IS', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(29, 'April', 'Chen', '', 'fringilla.porttitor@tellusNunclectus.org', 'Ap #240-1584 Pellentesque Av.', '', 'Beacon', 'Alberta', '09735', 'Bosnia and Herzegovina', '(129) 887-8938', 'RRL95BCR1LS', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet,', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(30, 'Shad', 'Stanton', '', 'Mauris.nulla.Integer@fringillacursuspurus.org', '681-5374 Et, Rd.', '', 'Hope', 'North Dakota', 'F8D 8X5', 'Mongolia', '(404) 553-3363', 'FHF86VKC8SE', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet,', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(31, 'Florence', 'Mcdonald', '', 'nisi@et.ca', '954-3612 Praesent St.', '', 'Sherrill', 'Virginia', '66265', 'American Samoa', '(805) 188-3402', 'PQF26SEA5UR', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(32, 'Clare', 'Ramos', '', 'Suspendisse.ac.metus@nequenonquam.ca', 'Ap #186-2534 Vehicula. Av.', '', 'Artesia', 'PA', '44949', 'Sierra Leone', '(155) 608-8785', 'OQJ85AXU0BH', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(33, 'Jermaine', 'Jennings', '', 'lorem.ipsum@mauris.edu', 'P.O. Box 625, 1800 Luctus Road', '', 'Stafford', 'Prince Edward Island', 'O1D 4D1', 'Nigeria', '(896) 321-7860', 'QRU07JEP7XA', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(34, 'Gillian', 'Perry', '', 'enim@eratEtiam.org', '1938 Erat Street', '', 'Ames', 'QC', '32158', 'Turks and Caicos Islands', '(487) 400-5477', 'YEU41BGJ0XE', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(35, 'TaShya', 'Bernard', '', 'est@convallisantelectus.org', 'Ap #798-3904 Nunc Av.', '', 'Winston-Salem', 'Oregon', 'Y9Q 3A5', 'Lithuania', '(271) 130-1470', 'WHU78ODW1GU', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(36, 'Sade', 'Burgess', '', 'est@arcuiaculis.edu', 'Ap #870-4400 Mi Street', '', 'Warren', 'Nova Scotia', '78660', 'Turkmenistan', '(480) 662-4838', 'LRZ29NCK4SY', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(37, 'Bruce', 'Jenkins', '', 'cursus@eutellus.edu', 'Ap #700-4572 Nisi St.', '', 'Lower Burrell', 'NB', 'R8G 1G9', 'Argentina', '(552) 494-8052', 'LPR43IYV3FU', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet,', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(38, 'Chase', 'Schwartz', '', 'nibh.Donec@risusNullaeget.org', 'Ap #638-2110 Enim Road', '', 'Owensboro', 'NT', '04598', 'San Marino', '(782) 654-8499', 'HAR43IBP9FZ', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(39, 'Katell', 'Fowler', '', 'natoque@Aliquam.edu', '7619 Arcu Street', '', 'Cairo', 'Missouri', '91006', 'Aruba', '(361) 379-3323', 'QHA85IPI4VB', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(40, 'Tatiana', 'Gallagher', '', 'magna@sagittislobortis.com', 'P.O. Box 506, 410 Eleifend Ave', '', 'Hattiesburg', 'Newfoundland and Labrador', '56481', 'Denmark', '(965) 797-6202', 'QNM12OQG9HQ', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(41, 'Montana', 'Coffey', '', 'metus.In@Praesentluctus.org', '763-8652 Diam Street', '', 'Rancho Santa Margarita', 'Indiana', '51170', 'Libyan Arab Jamahiriya', '(497) 475-0918', 'IRK29WAU6VW', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(42, 'Kenneth', 'Reyes', '', 'et.magna@mattis.org', '565-2569 Sed St.', '', 'Downey', 'Kentucky', '24900', 'Reunion', '(908) 464-9385', 'QQC68KEC6VG', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(43, 'Darrel', 'Alvarado', '', 'ultrices.a@Suspendissealiquetmolestie.com', '218 Magna. Av.', '', 'San Antonio', 'AK', 'R4T 8L3', 'Norfolk Island', '(768) 572-7770', 'MGK01KBX7XF', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet,', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(44, 'Geoffrey', 'Fletcher', '', 'lacinia@Integervulputaterisus.com', 'P.O. Box 124, 755 Lorem Road', '', 'San Mateo', 'British Columbia', 'F8I 2Q2', 'Greece', '(469) 842-1601', 'NJX84YYG7AN', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet,', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(45, 'Brenna', 'Chen', '', 'dignissim@Curabiturut.ca', '739-5100 Vel Street', '', 'Athens', 'Colorado', 'O5I 8F3', 'Gabon', '(181) 122-2257', 'ROE99WMA6DO', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(46, 'Eric', 'Boyer', '', 'eu@ridiculusmus.com', 'Ap #767-6147 Dapibus Road', '', 'Urbana', 'Vermont', '84090', 'China', '(578) 509-7124', 'NPX09OUP4CY', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(47, 'Suki', 'Oliver', '', 'accumsan.laoreet.ipsum@velsapienimperdiet.org', 'Ap #701-5008 Semper Ave', '', 'San Bernardino', 'Nevada', 'O4D 2W2', 'Bermuda', '(925) 504-2830', 'DZU86MJL4GT', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(48, 'Coby', 'Nash', '', 'sed@felisNullatempor.org', 'Ap #802-9702 Ridiculus Ave', '', 'Modesto', 'Colorado', '73927', 'Congo', '(972) 126-2896', 'RDI98AUW6XX', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(49, 'Brittany', 'Sexton', '', 'lacus@auctor.org', '9713 Sit St.', '', 'Forrest City', 'SK', 'K9J 2U9', 'Bangladesh', '(720) 518-6984', 'AWD38ZHF7FE', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(50, 'Sheila', 'Powers', '', 'Quisque.imperdiet.erat@magnanecquam.edu', 'P.O. Box 802, 7624 Amet St.', '', 'Cumberland', 'New Brunswick', '43860', 'Australia', '(823) 385-1549', 'JEA23GBC4SI', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(51, 'Ashton', 'Brennan', '', 'at@a.com', 'P.O. Box 987, 4972 Nec Road', '', 'Rolling Hills Estates', 'NT', 'Z7K 1E1', 'Heard Island and Mcdonald Islands', '(830) 291-2233', 'HTW69VDS3OW', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(52, 'Marsden', 'Wolfe', '', 'Sed.nec.metus@maurisipsum.edu', 'P.O. Box 674, 2072 Dui. Avenue', '', 'Grand Island', 'Nunavut', 'R3J 4P9', 'Egypt', '(694) 571-4688', 'NAI41ZRL9GC', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(53, 'Noah', 'Randolph', '', 'Praesent.eu@gravida.org', '651-1827 In Ave', '', 'Albany', 'AB', '63602', 'Togo', '(295) 525-2018', 'BHM59VDD8RF', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(54, 'Todd', 'Watson', '', 'turpis.Aliquam.adipiscing@dapibusquamquis.edu', '975-8064 Integer Rd.', '', 'Lawton', 'Ontario', 'K9F 5U8', 'Russian Federation', '(203) 482-3742', 'UOQ30QEN7VB', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(55, 'Geoffrey', 'Bonner', '', 'faucibus.orci.luctus@accumsanlaoreetipsum.com', 'P.O. Box 401, 7383 Dolor. Road', '', 'Springfield', 'KS', 'I3E 8Z0', 'Timor-leste', '(200) 693-7755', 'RWR09ATV7SM', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(56, 'Murphy', 'Downs', '', 'quam.dignissim@malesuada.org', 'Ap #544-234 Rhoncus Street', '', 'Littleton', 'Nunavut', 'Y3X 7A6', 'Egypt', '(197) 544-7918', 'PXA86NXD5MI', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(57, 'Hadley', 'Deleon', '', 'vitae.aliquet.nec@turpisegestas.ca', '726-3363 Dictum Rd.', '', 'Grass Valley', 'MB', '47753', 'Cyprus', '(899) 439-7686', 'CYO35YBW2XB', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(58, 'Beau', 'Smith', '', 'nisi.magna@dui.com', '9217 Non, Av.', '', 'Marlborough', 'Minnesota', '82781', 'Angola', '(722) 553-5621', 'CHQ43MFG0PB', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(59, 'Aurelia', 'Quinn', '', 'mauris.eu.elit@gravidasitamet.com', '4146 Fusce Avenue', '', 'Lancaster', 'North Dakota', 'D3T 4N7', 'United States Minor Outlying Islands', '(599) 408-4766', 'NCB50AYO5PE', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(60, 'Cole', 'Rivas', '', 'imperdiet@tristiquesenectuset.ca', '5876 Tincidunt St.', '', 'Newark', 'MB', 'U4I 7X9', 'Georgia', '(128) 566-7397', 'CUS89RKQ3PW', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(61, 'Kevin', 'Bray', '', 'sit@adlitora.org', '936-5870 Duis Av.', '', 'Paducah', 'Newfoundland and Labrador', '66020', 'Namibia', '(264) 407-9193', 'OEB89JTP0QX', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(62, 'Malachi', 'Hogan', '', 'lobortis@libero.com', '354-6979 Vulputate Av.', '', 'Madison', 'British Columbia', '35695', 'Fiji', '(835) 875-4181', 'FGN70XBS4GU', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(63, 'Jane', 'Beasley', '', 'ipsum.dolor.sit@eteros.com', 'P.O. Box 561, 1346 Leo. Ave', '', 'Fort Wayne', 'NH', 'P7I 3D5', 'Bouvet Island', '(620) 125-0254', 'CXJ70WXI2EV', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(64, 'Joelle', 'Pate', '', 'Integer.mollis.Integer@nislMaecenasmalesuada.com', 'Ap #498-4820 Semper Road', '', 'San Dimas', 'Saskatchewan', '81513', 'San Marino', '(117) 253-6217', 'BOB99PKL3JI', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(65, 'Noelani', 'Little', '', 'Nunc@Proin.edu', 'Ap #485-1758 Fusce Rd.', '', 'Trenton', 'Delaware', '15259', 'Norway', '(829) 510-1632', 'ARK01CMI9BG', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(66, 'Patricia', 'Brock', '', 'Cum.sociis.natoque@eratvelpede.ca', 'P.O. Box 729, 3795 Nec St.', '', 'Reno', 'Ohio', '80220', 'Gabon', '(595) 678-3860', 'RLY36ZAA7BP', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(67, 'Melanie', 'Lee', '', 'ac.orci.Ut@diamluctuslobortis.org', '281-2943 Auctor Avenue', '', 'Greensburg', 'NL', 'Z3J 9A4', 'Mexico', '(511) 878-3651', 'WFN76TBA6KA', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(68, 'Patrick', 'Tate', '', 'est@maurisblandit.com', 'P.O. Box 504, 6779 Elit Road', '', 'Reading', 'QC', 'W2K 8T8', 'Tuvalu', '(752) 650-5529', 'COQ46BDL0YA', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(69, 'Rooney', 'Winters', '', 'pede@ipsumnuncid.edu', 'Ap #321-830 Adipiscing Rd.', '', 'Colorado Springs', 'Alaska', '77817', 'Sierra Leone', '(201) 615-4170', 'ARE22VLI0XJ', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(70, 'Rosalyn', 'Shields', '', 'bibendum.ullamcorper.Duis@sollicitudina.org', '3642 Donec Rd.', '', 'Ann Arbor', 'Vermont', 'C1B 6J0', 'Liberia', '(734) 831-6292', 'VYX65RZP5CQ', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(71, 'Veronica', 'Carter', '', 'Lorem.ipsum@aliquameros.com', 'Ap #268-6095 Odio. Avenue', '', 'Tyler', 'AK', 'Q4I 2Z4', 'Switzerland', '(537) 146-1768', 'YAX97CNQ2JK', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(72, 'Barrett', 'Burch', '', 'eu.nibh@adipiscingelitCurabitur.ca', '448-2305 Arcu St.', '', 'Butler', 'CA', '80542', 'Turkmenistan', '(850) 646-7512', 'OEE21MRK6SM', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(73, 'Kadeem', 'Curry', '', 'pellentesque@arcu.com', '7842 Id Rd.', '', 'Florence', 'Yukon', '22187', 'Slovenia', '(614) 461-0131', 'XNC27SCM9MK', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet,', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(74, 'Roanna', 'Holmes', '', 'et.magnis@Duis.org', '922-6222 Vitae Rd.', '', 'Klamath Falls', 'TN', '55705', 'Croatia', '(406) 933-7782', 'ABZ76IRG7ZA', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(75, 'Isaiah', 'Larson', '', 'Curabitur.sed@Inatpede.edu', '766-5474 Lectus, Ave', '', 'Danville', 'North Dakota', '31659', 'New Zealand', '(504) 487-8318', 'CZZ57LGH6WD', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(76, 'Baker', 'Leon', '', 'posuere.enim@Duis.edu', '4075 Nulla. Road', '', 'Eureka', 'Louisiana', 'W3O 2P2', 'American Samoa', '(705) 794-7487', 'RVU22SRN9GR', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(77, 'Hayley', 'Gallegos', '', 'tellus.justo.sit@egetmassa.org', 'Ap #430-8500 Ac St.', '', 'Citrus Heights', 'NU', 'I1U 8B0', 'Luxembourg', '(473) 687-8532', 'ZAD07NXW7NS', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(78, 'Larissa', 'White', '', 'mauris@eutellus.com', 'P.O. Box 574, 8971 Nonummy St.', '', 'Santa Fe Springs', 'BC', '57745', 'Dominican Republic', '(231) 941-5421', 'XSN67TFQ5BT', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(79, 'Rachel', 'Valenzuela', '', 'egestas@interdum.org', 'P.O. Box 578, 7182 Pharetra. St.', '', 'La Ca', 'Saskatchewan', 'H2G 9R3', 'Pakistan', '(126) 284-1872', 'BIQ23DXV9UE', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(80, 'Jasmine', 'Osborn', '', 'pellentesque.tellus.sem@Nuncsollicitudin.edu', '5085 Pede. St.', '', 'Easthampton', 'South Dakota', 'A9H 9U2', 'Pitcairn', '(978) 250-6294', 'PYN60LDI2JW', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(81, 'Finn', 'Wiley', '', 'ante.Nunc.mauris@ridiculusmusDonec.com', '5890 Enim, Av.', '', 'McAllen', 'OH', '35949', 'Chile', '(872) 872-7124', 'SWC03ZXZ5AO', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(82, 'Mechelle', 'Adkins', '', 'Donec.porttitor@nascetur.com', 'P.O. Box 662, 8326 Neque. St.', '', 'El Cerrito', 'NB', '13908', 'Tuvalu', '(636) 736-3319', 'OMH95LOL7KR', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(83, 'Emerald', 'Mccormick', '', 'cursus@sedhendrerit.com', '7821 Nam Ave', '', 'Bayamon', 'Saskatchewan', 'Q9U 2K4', 'Micronesia', '(116) 189-3424', 'YEX08RVY8TY', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(84, 'Amber', 'Gaines', '', 'enim.Etiam@estacfacilisis.org', 'Ap #537-385 Id, Rd.', '', 'Washington', 'NS', '70769', 'Madagascar', '(646) 957-9834', 'UXE35SVP6OC', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet,', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(85, 'Leilani', 'Conway', '', 'mattis.semper.dui@euismodenimEtiam.ca', '253-3997 Quisque Road', '', 'Greensburg', 'SK', 'Z7I 6J8', 'Peru', '(832) 357-5322', 'YFP36UTA2QE', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(86, 'Xenos', 'Delgado', '', 'habitant.morbi.tristique@sociisnatoquepenatibus.edu', 'Ap #933-4982 Integer Avenue', '', 'Bellflower', 'Prince Edward Island', 'C2D 1K7', 'Eritrea', '(149) 788-9678', 'JXA35YVQ1OQ', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(87, 'Cailin', 'Quinn', '', 'Vestibulum.accumsan@eu.com', 'P.O. Box 832, 1024 Mattis St.', '', 'Valdosta', 'Michigan', '09460', 'Afghanistan', '(368) 329-4923', 'ZTS99ZTZ8HY', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(88, 'Sebastian', 'Dalton', '', 'risus.Quisque@quam.com', 'Ap #115-4329 Magna. Avenue', '', 'Port Jervis', 'AK', '94393', 'Pakistan', '(953) 821-6555', 'SEB81UWP5EJ', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(89, 'Grant', 'Dunlap', '', 'In@ultricesiaculisodio.edu', 'Ap #507-6333 Pede. Avenue', '', 'Ardmore', 'MB', '30486', 'Nigeria', '(388) 270-5922', 'XIM22ARX0QC', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(90, 'Jordan', 'Stein', '', 'nunc.est.mollis@imperdietornare.ca', 'Ap #541-9609 Vitae Road', '', 'Norwalk', 'AK', '37427', 'Bhutan', '(458) 799-2893', 'IGI76ZFR6ZW', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(91, 'Derek', 'Holden', '', 'dolor.sit@ullamcorperDuis.org', '483-523 Risus Av.', '', 'Fitchburg', 'ND', 'J7P 1J5', 'Trinidad and Tobago', '(554) 597-9674', 'QGX47IMB7WR', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(92, 'Lisandra', 'Silva', '', 'sem.vitae.aliquam@euligulaAenean.org', 'Ap #937-6602 Tempus Ave', '', 'Hackensack', 'British Columbia', 'R4X 7D7', 'Guyana', '(633) 470-2319', 'PXE36CZZ7CZ', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(93, 'Gannon', 'Bartlett', '', 'amet.ante@urnasuscipit.org', 'P.O. Box 835, 8101 Cras Rd.', '', 'Niagara Falls', 'UT', '40547', 'New Zealand', '(547) 983-2893', 'HEX07DXP7WJ', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(94, 'Geoffrey', 'Black', '', 'Suspendisse.aliquet.sem@infelisNulla.org', '818-3452 In St.', '', 'Fajardo', 'WV', '77535', 'Jamaica', '(751) 104-3114', 'VID34ODT8WM', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(95, 'Rowan', 'Mckee', '', 'pede.Cum.sociis@tellus.ca', '6483 Fusce Rd.', '', 'Wisconsin Dells', 'QC', '15123', 'Virgin Islands, British', '(273) 184-5605', 'ABD82USX7TS', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0),
(96, 'Ginger', 'Wilkins', '', 'viverra@elitdictumeu.com', '745-7869 Nec, St.', '', 'Winston-Salem', 'NB', '02599', 'Estonia', '(628) 505-8064', 'ZUX29FZU2SB', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet,', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(97, 'Philip', 'Love', '', 'Donec.vitae@DonecfringillaDonec.ca', '2733 Magna Rd.', '', 'Hornell', 'WY', '26024', 'Cyprus', '(954) 504-9794', 'NUP44EMS5MP', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet,', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Inactive', '', '', 0),
(98, 'Vivien', 'Espinoza', '', 'Integer.urna.Vivamus@vitaealiquet.ca', '3451 At Road', '', 'Johnstown', 'NB', 'S5R 2H2', 'Palau', '(861) 298-0284', 'SWJ63HZT9HQ', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(99, 'Riley', 'Brennan', '', 'arcu@diamPellentesquehabitant.org', 'Ap #845-3230 Nec St.', '', 'Thousand Oaks', 'QC', 'X4F 6K4', 'Finland', '(684) 572-6923', 'AAI27DNP8IF', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit amet,', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Closed', '', '', 0),
(100, 'Marah', 'Ballard', '', 'dictum@ultricies.ca', 'Ap #998-314 Nulla Road', '', 'Oak Ridge', 'IA', '08467', 'Rwanda', '(822) 360-8639', 'ZGY76QTR2AC', 1, '', '0.00', '', '', '', '', '', '0000-00-00', 'Lorem ipsum dolor sit', 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', 'Active', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblclientsfiles`
--

CREATE TABLE IF NOT EXISTS `tblclientsfiles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `title` text NOT NULL,
  `filename` text NOT NULL,
  `adminonly` int(1) NOT NULL,
  `dateadded` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblconfiguration`
--

CREATE TABLE IF NOT EXISTS `tblconfiguration` (
  `setting` text NOT NULL,
  `value` text NOT NULL,
  KEY `setting` (`setting`(32))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblconfiguration`
--

INSERT INTO `tblconfiguration` (`setting`, `value`) VALUES
('Language', 'english'),
('CompanyName', 'J!WHMCS Localhost'),
('Email', 'admin@localhost.com'),
('Domain', 'http://localhost/'),
('LogoURL', ''),
('SystemURL', 'http://localhost/2.4/whmcs/'),
('SystemSSLURL', ''),
('DisableSessionIPCheck', ''),
('AutoSuspension', 'on'),
('AutoSuspensionDays', '5'),
('CreateInvoiceDaysBefore', '14'),
('AffiliateEnabled', ''),
('AffiliateEarningPercent', '0'),
('AffiliateBonusDeposit', '0.00'),
('AffiliatePayout', '0.00'),
('AffiliateLinks', ''),
('ActivityLimit', '10000'),
('DateFormat', 'DD/MM/YYYY'),
('PreSalesQuestions', ''),
('Template', 'default'),
('AllowRegister', 'on'),
('AllowTransfer', 'on'),
('AllowOwnDomain', 'on'),
('EnableTOSAccept', ''),
('TermsOfService', ''),
('AllowLanguageChange', 'on'),
('Version', '5.0.3'),
('AllowCustomerChangeInvoiceGateway', 'on'),
('DefaultNameserver1', 'ns1.yourdomain.com'),
('DefaultNameserver2', 'ns2.yourdomain.com'),
('SendInvoiceReminderDays', '7'),
('SendReminder', 'on'),
('NumRecordstoDisplay', '50'),
('BCCMessages', ''),
('MailType', 'mail'),
('SMTPHost', ''),
('SMTPUsername', ''),
('SMTPPassword', ''),
('SMTPPort', '25'),
('ShowCancellationButton', 'on'),
('UpdateStatsAuto', 'on'),
('InvoicePayTo', 'Address goes here...'),
('SendAffiliateReportMonthly', 'on'),
('InvalidLoginBanLength', '15'),
('Signature', 'Signature goes here...'),
('DomainOnlyOrderEnabled', 'on'),
('TicketBannedAddresses', ''),
('SendEmailNotificationonUserDetailsChange', 'on'),
('TicketAllowedFileTypes', '.jpg,.gif,.jpeg,.png'),
('CloseInactiveTickets', '0'),
('InvoiceLateFeeAmount', '10.00'),
('AutoTermination', ''),
('AutoTerminationDays', '30'),
('RegistrarAdminFirstName', ''),
('RegistrarAdminLastName', ''),
('RegistrarAdminCompanyName', ''),
('RegistrarAdminAddress1', ''),
('RegistrarAdminAddress2', ''),
('RegistrarAdminCity', ''),
('RegistrarAdminStateProvince', ''),
('RegistrarAdminCountry', 'US'),
('RegistrarAdminPostalCode', ''),
('RegistrarAdminPhone', ''),
('RegistrarAdminFax', ''),
('RegistrarAdminEmailAddress', ''),
('RegistrarAdminUseClientDetails', 'on'),
('Charset', 'utf-8'),
('AutoUnsuspend', 'on'),
('RunScriptonCheckOut', ''),
('License', 'N2Q2ZjJjMDg0NzdlMTYwYTAwMDg4Njc3YTg3ZmM5NGE2NjY0OGViM3RBRE13QWpJNkFUTTZNM09pVUdk\naFJXWjFSR2Q0Vm1iaW9UTXhvemM3SUNOdzBpTXgwU014QWpNaW9ETXhvemM3SVNaMEZHWm5WbWNpb3pO\nNk0zT2lraWRsUkVLZ1UyY3VWMllweEVJa1ZtYjM5a0k2a1RNNk0zT2lVV2JoNUdkalZIWnZKSGNpb1RN\neG96YzdJaU0wRWpJNk1qT3p0aklrbEdkalZIWnZKSGNpb1RPNk0zT2lNRVRNQkNMelYyWXBabmNsTkZJ\ndTlXYTBGV2J5OW1adWxFSXlWR2FubEdTZzgyUmlvVE56b3pjN0lTWnRGbWJrVm1jbFIzY3BkV1p5SmlP\nMEVqT3p0aklsWlhhME5XUWlvak42TTNPaU1YZDBGR2R6SmlPMm96Yzdwak14b1RZZDg5MDg5MzZkNjA3\nOGNmOGE3M2U3Mzg0MGQ0NTE5NDliNGMxOTNlOT0wM09pQWpNMEFqTXhBak1pb0RPNk0zT2lVR2RoUjJh\nalZHYWpKaU81b3pjN0l5TXVBakwxSWlPMW96YzdJaWJ2bDJjeVZtZDBOWFowRkdiaW96TXhvemM3SXlj\najFHYTN4MVFYQkNNdVFqTHlBaWN2UlhZeWRXWjA1V1NmOUZYek4yYmtSSGFjQkhjdEZHZWNwelFpb3pN\nMG96YzdJU2V5OUdkalZtY3BSR1pweFdZMkppTzBFak96dGpJeDRDTXVBakwzSVRNaW9UTzZNM09pQVhh\na2xHYmhabkk2Y2pPenRqSTBOM2JveFdZajlHYnVjM2QzeENkejlHYXNGMll2eG1JNk1qTTZNM09pNFdh\naDEyYmtSV2FzRm1kaW9UTXhvemM3SVNadGxHVmdVbWJQSmlPNG96YzdJU1pzTldlamRtYnB4R2JwSm1J\nNklUTTZNM09pQURNdEFETTIzNjdjOGM3YjczM2MxNzQ2MjExNGE0N2EzZThhYmI2MjBiZjE5Njg='),
('OrderFormTemplate', 'modern'),
('AllowDomainsTwice', 'on'),
('AddLateFeeDays', '5'),
('TaxEnabled', ''),
('DefaultCountry', 'US'),
('OrderDaysGrace', '0'),
('AutoRedirectoInvoice', 'gateway'),
('EnablePDFInvoices', 'on'),
('CaptchaSetting', 'offloggedin'),
('SupportTicketOrder', 'ASC'),
('SendFirstOverdueInvoiceReminder', '1'),
('TaxType', 'Exclusive'),
('DefaultNameserver3', ''),
('DomainDNSManagement', '5.00'),
('DomainEmailForwarding', '5.00'),
('InvoiceIncrement', '1'),
('ContinuousInvoiceGeneration', ''),
('AutoCancellationRequests', 'on'),
('SystemEmailsFromName', 'WHMCompleteSolution'),
('SystemEmailsFromEmail', 'noreply@yourdomain.com'),
('AllowClientRegister', 'on'),
('BulkCheckTLDs', ''),
('OrderDaysGrace', '0'),
('CreditOnDowngrade', 'on'),
('AcceptedCardTypes', 'Visa,MasterCard,Discover,American Express,JCB,EnRoute,Diners Club'),
('TaxDomains', 'on'),
('TaxLateFee', 'on'),
('AdminForceSSL', 'on'),
('ProductMonthlyPricingBreakdown', ''),
('LateFeeType', 'Percentage'),
('SendSecondOverdueInvoiceReminder', '0'),
('SendThirdOverdueInvoiceReminder', '0'),
('DomainIDProtection', '5.00'),
('DomainRenewalNotices', '60,30,15,7,1'),
('SequentialInvoiceNumbering', ''),
('SequentialInvoiceNumberFormat', '{NUMBER}'),
('SequentialInvoiceNumberValue', '1'),
('DefaultNameserver4', ''),
('AffiliatesDelayCommission', '0'),
('SupportModule', ''),
('AddFundsEnabled', ''),
('AddFundsMinimum', '10.00'),
('AddFundsMaximum', '100.00'),
('AddFundsMaximumBalance', '300.00'),
('DisableClientDropdown', ''),
('CCProcessDaysBefore', '0'),
('CCAttemptOnlyOnce', ''),
('CCDaySendExpiryNotices', '25'),
('BulkDomainSearchEnabled', 'on'),
('AutoRenewDomainsonPayment', 'on'),
('DomainAutoRenewDefault', 'on'),
('CCRetryEveryWeekFor', '0'),
('SupportTicketKBSuggestions', 'on'),
('DailyEmailBackup', ''),
('FTPBackupHostname', ''),
('FTPBackupUsername', ''),
('FTPBackupPassword', ''),
('FTPBackupDestination', '/'),
('TaxL2Compound', ''),
('EmailCSS', 'body,td { font-family: verdana; font-size: 11px; font-weight: normal; }\r\na { color: #0000ff; }'),
('SEOFriendlyUrls', ''),
('ShowCCIssueStart', ''),
('ClientDropdownFormat', '1'),
('TicketRatingEnabled', 'on'),
('NetworkIssuesRequireLogin', 'on'),
('ShowNotesFieldonCheckout', 'on'),
('RequireLoginforClientTickets', 'on'),
('NOMD5', ''),
('CurrencyAutoUpdateExchangeRates', 'on'),
('CurrencyAutoUpdateProductPrices', ''),
('RequiredPWStrength', '50'),
('MaintenanceMode', ''),
('MaintenanceModeMessage', 'We are currently performing maintenance and will be back shortly.'),
('SkipFraudForExisting', ''),
('SMTPSSL', ''),
('ContactFormDept', ''),
('ContactFormTo', ''),
('TicketEscalationLastRun', '2009-01-01 00:00:00'),
('APIAllowedIPs', '127.0.0.1'),
('DisableSupportTicketReplyEmailsLogging', ''),
('OverageBillingMethod', '1'),
('CCNeverStore', ''),
('CCAllowCustomerDelete', ''),
('CreateDomainInvoiceDaysBefore', ''),
('NoInvoiceEmailOnOrder', ''),
('TaxInclusiveDeduct', ''),
('LateFeeMinimum', '0.00'),
('AutoProvisionExistingOnly', ''),
('EnableDomainRenewalOrders', 'on'),
('EnableMassPay', 'on'),
('NoAutoApplyCredit', ''),
('CreateInvoiceDaysBeforeMonthly', ''),
('CreateInvoiceDaysBeforeQuarterly', ''),
('CreateInvoiceDaysBeforeSemiAnnually', ''),
('CreateInvoiceDaysBeforeAnnually', ''),
('CreateInvoiceDaysBeforeBiennially', ''),
('CreateInvoiceDaysBeforeTriennially', ''),
('ClientsProfileUneditableFields', ''),
('ClientDisplayFormat', '1'),
('CCDoNotRemoveOnExpiry', ''),
('GenerateRandomUsername', ''),
('AddFundsRequireOrder', 'on'),
('GroupSimilarLineItems', 'on'),
('ProrataClientsAnniversaryDate', ''),
('TCPDFFont', 'helvetica'),
('CancelInvoiceOnCancellation', 'on'),
('AttachmentThumbnails', 'on'),
('EmailGlobalHeader', '&lt;p&gt;&lt;a href=&quot;{$company_domain}&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;{$company_logo_url}&quot; alt=&quot;{$company_name}&quot; border=&quot;0&quot; /&gt;&lt;/a&gt;&lt;/p&gt;'),
('EmailGlobalFooter', ''),
('ClientDateFormat', ''),
('AllowIDNDomains', ''),
('DownloadsIncludeProductLinked', ''),
('CaptchaType', ''),
('ReCAPTCHAPrivateKey', ''),
('ReCAPTCHAPublicKey', ''),
('DisableAdminPWReset', ''),
('TwitterUsername', ''),
('AnnouncementsTweet', ''),
('AnnouncementsFBRecommend', ''),
('AnnouncementsFBComments', ''),
('GooglePlus1', ''),
('DefaultToClientArea', ''),
('DisplayErrors', ''),
('SQLErrorReporting', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblcontacts`
--

CREATE TABLE IF NOT EXISTS `tblcontacts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `companyname` text NOT NULL,
  `email` text NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `postcode` text NOT NULL,
  `country` text NOT NULL,
  `phonenumber` text NOT NULL,
  `subaccount` int(1) NOT NULL DEFAULT '0',
  `password` text NOT NULL,
  `permissions` text NOT NULL,
  `domainemails` int(1) NOT NULL,
  `generalemails` int(1) NOT NULL,
  `invoiceemails` int(1) NOT NULL,
  `productemails` int(1) NOT NULL,
  `supportemails` int(1) NOT NULL,
  `pwresetkey` text NOT NULL,
  `pwresetexpiry` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid_firstname_lastname` (`userid`,`firstname`(32),`lastname`(32)),
  KEY `email` (`email`(64))
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblcredit`
--

CREATE TABLE IF NOT EXISTS `tblcredit` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `clientid` int(10) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `relid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblcurrencies`
--

CREATE TABLE IF NOT EXISTS `tblcurrencies` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` text NOT NULL,
  `prefix` text NOT NULL,
  `suffix` text NOT NULL,
  `format` int(1) NOT NULL,
  `rate` decimal(10,5) NOT NULL DEFAULT '1.00000',
  `default` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tblcurrencies`
--

INSERT INTO `tblcurrencies` (`id`, `code`, `prefix`, `suffix`, `format`, `rate`, `default`) VALUES
(1, 'USD', '$', ' USD', 1, '1.00000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomfields`
--

CREATE TABLE IF NOT EXISTS `tblcustomfields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  `relid` int(10) NOT NULL DEFAULT '0',
  `fieldname` text NOT NULL,
  `fieldtype` text NOT NULL,
  `description` text NOT NULL,
  `fieldoptions` text NOT NULL,
  `regexpr` text NOT NULL,
  `adminonly` text NOT NULL,
  `required` text NOT NULL,
  `showorder` text NOT NULL,
  `showinvoice` text NOT NULL,
  `sortorder` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `serviceid` (`relid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomfieldsvalues`
--

CREATE TABLE IF NOT EXISTS `tblcustomfieldsvalues` (
  `fieldid` int(10) NOT NULL,
  `relid` int(10) NOT NULL,
  `value` text NOT NULL,
  KEY `fieldid_relid` (`fieldid`,`relid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbldomainpricing`
--

CREATE TABLE IF NOT EXISTS `tbldomainpricing` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `extension` text NOT NULL,
  `dnsmanagement` text NOT NULL,
  `emailforwarding` text NOT NULL,
  `idprotection` text NOT NULL,
  `eppcode` text NOT NULL,
  `autoreg` text NOT NULL,
  `order` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `extension_registrationperiod` (`extension`(32)),
  KEY `order` (`order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbldomains`
--

CREATE TABLE IF NOT EXISTS `tbldomains` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `orderid` int(1) NOT NULL,
  `type` enum('Register','Transfer') NOT NULL,
  `registrationdate` date NOT NULL,
  `domain` text NOT NULL,
  `firstpaymentamount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `recurringamount` decimal(10,2) NOT NULL,
  `registrar` text NOT NULL,
  `registrationperiod` int(1) NOT NULL DEFAULT '1',
  `expirydate` date DEFAULT NULL,
  `subscriptionid` text NOT NULL,
  `promoid` int(10) NOT NULL,
  `status` enum('Pending','Pending Transfer','Active','Expired','Cancelled','Fraud') NOT NULL DEFAULT 'Pending',
  `nextduedate` date NOT NULL DEFAULT '0000-00-00',
  `nextinvoicedate` date NOT NULL,
  `additionalnotes` text NOT NULL,
  `paymentmethod` text NOT NULL,
  `dnsmanagement` text NOT NULL,
  `emailforwarding` text NOT NULL,
  `idprotection` text NOT NULL,
  `donotrenew` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `orderid` (`orderid`),
  KEY `domain` (`domain`(64)),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbldomainsadditionalfields`
--

CREATE TABLE IF NOT EXISTS `tbldomainsadditionalfields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `domainid` int(10) NOT NULL,
  `name` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `domainid` (`domainid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbldownloadcats`
--

CREATE TABLE IF NOT EXISTS `tbldownloadcats` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parentid` int(10) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `description` text NOT NULL,
  `hidden` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parentid` (`parentid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbldownloads`
--

CREATE TABLE IF NOT EXISTS `tbldownloads` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` int(10) NOT NULL,
  `type` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `downloads` int(10) NOT NULL DEFAULT '0',
  `location` text NOT NULL,
  `clientsonly` text NOT NULL,
  `hidden` text NOT NULL,
  `productdownload` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`(32)),
  KEY `downloads` (`downloads`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblemailmarketer`
--

CREATE TABLE IF NOT EXISTS `tblemailmarketer` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `type` text NOT NULL,
  `settings` text NOT NULL,
  `disable` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblemails`
--

CREATE TABLE IF NOT EXISTS `tblemails` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `date` datetime DEFAULT NULL,
  `to` text,
  `cc` text,
  `bcc` text,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblemailtemplates`
--

CREATE TABLE IF NOT EXISTS `tblemailtemplates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  `name` text NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `attachments` text NOT NULL,
  `fromname` text NOT NULL,
  `fromemail` text NOT NULL,
  `disabled` text NOT NULL,
  `custom` text NOT NULL,
  `language` text NOT NULL,
  `copyto` text NOT NULL,
  `plaintext` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`(32)),
  KEY `name` (`name`(64))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `tblemailtemplates`
--

INSERT INTO `tblemailtemplates` (`id`, `type`, `name`, `subject`, `message`, `attachments`, `fromname`, `fromemail`, `disabled`, `custom`, `language`, `copyto`, `plaintext`) VALUES
(1, 'product', 'Hosting Account Welcome Email', 'New Account Information', '<p>Dear {$client_name},</p><p align="center"><strong>PLEASE READ THIS EMAIL IN FULL AND PRINT IT FOR YOUR RECORDS</strong></p><p>Thank you for your order from us! Your hosting account has now been setup and this email contains all the information you will need in order to begin using your account.</p><p>If you have requested a domain name during sign up, please keep in mind that your domain name will not be visible on the internet instantly. This process is called propagation and can take up to 48 hours. Until your domain has propagated, your website and email will not function, we have provided a temporary url which you may use to view your website and upload files in the meantime.</p><p><strong>New Account Information</strong></p><p>Hosting Package: {$service_product_name}<br />Domain: {$service_domain}<br />First Payment Amount: {$service_first_payment_amount}<br />Recurring Amount: {$service_recurring_amount}<br />Billing Cycle: {$service_billing_cycle}<br />Next Due Date: {$service_next_due_date}</p><p><strong>Login Details</strong></p><p>Username: {$service_username}<br />Password: {$service_password}</p><p>Control Panel URL: <a href="http://{$service_server_ip}:2082/">http://{$service_server_ip}:2082/</a><br />Once your domain has propogated, you may also use <a href="http://www.{$service_domain}:2082/">http://www.{$service_domain}:2082/</a></p><p><strong>Server Information</strong></p><p>Server Name: {$service_server_name}<br />Server IP: {$service_server_ip}</p><p>If you are using an existing domain with your new hosting account, you will need to update the nameservers to point to the nameservers listed below.</p><p>Nameserver 1: {$service_ns1} ({$service_ns1_ip})<br />Nameserver 2: {$service_ns2} ({$service_ns2_ip}){if $service_ns3}<br />Nameserver 3: {$service_ns3} ({$service_ns3_ip}){/if}{if $service_ns4}<br />Nameserver 4: {$service_ns4} ({$service_ns4_ip}){/if}</p><p><strong>Uploading Your Website</strong></p><p>Temporarily you may use one of the addresses given below to manage your web site:</p><p>Temporary FTP Hostname: {$service_server_ip}<br />Temporary Webpage URL: <a href="http://{$service_server_ip}/~{$service_username}/">http://{$service_server_ip}/~{$service_username}/</a></p><p>And once your domain has propagated you may use the details below:</p><p>FTP Hostname: {$service_domain}<br />Webpage URL: <a href="http://www.{$service_domain}">http://www.{$service_domain}</a></p><p><strong>Email Settings</strong></p><p>For email accounts that you setup, you should use the following connection details in your email program:</p><p>POP3 Host Address: mail.{$service_domain}<br />SMTP Host Address: mail.{$service_domain}<br />Username: The email address you are checking email for<br />Password: As specified in your control panel</p><p>Thank you for choosing us.</p><p>{$signature}</p>', '', '', '', '', '', '', '', 0),
(29, 'domain', 'Domain Renewal Confirmation', 'Domain Renewal Confirmation', '<p>Dear {$client_name}, </p><p>Thank you for your domain renewal order. Your domain renewal request for the domain listed below has now been completed.</p><p>Domain: {$domain_name}<br />Renewal Length: {$domain_reg_period}<br />Renewal Price: {$domain_recurring_amount}<br />Next Due Date: {$domain_next_due_date} </p><p>You may login to your client area at {$whmcs_url} to manage your domain. </p><p>{$signature} </p>', '', '', '', '', '', '', '', 0),
(3, 'domain', 'Domain Registration Confirmation', 'Domain Registration Confirmation', '<p>\r\nDear {$client_name}, \r\n</p>\r\n<p>\r\nThis message is to confirm that your domain purchase has been successful. The details of the domain purchase are below: \r\n</p>\r\n<p>\r\nRegistration Date: {$domain_reg_date}<br />\r\nDomain: {$domain_name}<br />\r\nRegistration Period: {$domain_reg_period}<br />\r\nAmount: {$domain_first_payment_amount}<br />\r\nNext Due Date: {$domain_next_due_date} \r\n</p>\r\n<p>\r\nYou may login to your client area at {$whmcs_url} to manage your new domain. \r\n</p>\r\n<p>\r\n{$signature} \r\n</p>\r\n', '', '', '', '', '', '', '', 0),
(4, 'product', 'Reseller Account Welcome Email', 'Reseller Account Information', '<p align="center">\r\n<strong>PLEASE PRINT THIS MESSAGE FOR YOUR RECORDS - PLEASE READ THIS EMAIL IN FULL.</strong>\r\n</p>\r\n<p>\r\nIf you have requested a domain name during sign up then this will not be visible on the internet for between 24 and 72 hours. This process is called Propagation. Until your domain has Propagated your website and email will not function, we have provided a temporary url which you may use to view your website and upload files in the meantime.\r\n</p>\r\n<p>\r\nDear {$client_name},\r\n</p>\r\n<p>\r\nThe reseller hosting account for {$service_domain} has been set up. The username and password below are for both cPanel to manage the website at {$service_domain} and WebHostManager to manage your Reseller Account.\r\n</p>\r\n<p>\r\n<strong>New Account Info</strong>\r\n</p>\r\n<p>\r\nDomain: {$service_domain}<br />\r\nUsername: {$service_username}<br />\r\nPassword: {$service_password}<br />\r\nHosting Package: {$service_product_name}\r\n</p>\r\n<p>\r\nControl Panel: <a href="http://{$service_server_ip}:2082/">http://{$service_server_ip}:2082/</a><br />\r\nWeb Host Manager: <a href="http://{$service_server_ip}:2086/">http://{$service_server_ip}:2086/</a>\r\n</p>\r\n<p>\r\n-------------------------------------------------------------------------------------------- <br />\r\n<strong>Web Host Manager Quick Start</strong> <br />\r\n-------------------------------------------------------------------------------------------- <br />\r\n<br />\r\nTo access your Web Host Manager, use the following address:<br />\r\n<br />\r\n<a href="http://{$service_server_ip}:2086/">http://{$service_server_ip}:2086/</a><br />\r\n<br />\r\nThe <strong>http://</strong> must be in the address line to connect to port :2086 <br />\r\nPlease use the username/password given above. <br />\r\n<br />\r\n<strong><em>To Create a New Account <br />\r\n</em></strong><br />\r\nThe first thing you need to do is scroll down on the left and click on &#39Add Package&#39 so that you can create your own hosting packages. You cannot install a domain onto your account without first creating packages.<br />\r\n<br />\r\n1. Click on &#39Create a New Account&#39 from the left hand side menu <br />\r\n2. Put the domain in the &#39Domain&#39 box (no www or http or spaces ? just domainname.com). After putting in the domain, hit TAB and it will automatically create a username. Also, enter a password for the account.<br />\r\n3. Your package selection should be one that you created earlier <br />\r\n4. Then press the create button <br />\r\n<br />\r\nThis will give you a confirmation page (you should print this for your records)\r\n</p>\r\n<p>\r\nPlease do not click on anything that you are not sure what it does. Please do not try to alter the WHM Theme from the selection box - fatal errors may occur. \r\n</p>\r\n<p>\r\n-------------------------------------------------------------------------------------------- \r\n</p>\r\n<p>\r\nTemporarily you may use one of the addresses given below manage your web site\r\n</p>\r\n<p>\r\nTemporary FTP Hostname: {$service_server_ip}<br />\r\nTemporary Webpage URL: <a href="http://{$service_server_ip}/~{$service_username}/">http://{$service_server_ip}/~{$service_username}/</a><br />\r\nTemporary Control Panel: <a href="http://{$service_server_ip}/cpanel">http://{$service_server_ip}/cpanel</a>\r\n</p>\r\n<p>\r\nOnce your domain has Propagated\r\n</p>\r\n<p>\r\nFTP Hostname: www.{$service_domain}<br />\r\nWebpage URL: <a href="http://www.{$service_domain}">http://www.{$service_domain}</a><br />\r\nControl Panel: <a href="http://www.{$service_domain}/cpanel">http://www.{$service_domain}/cpanel</a><br />\r\nWeb Host Manager: <a href="http://www.{$service_domain}/whm">http://www.{$service_domain}/whm</a>\r\n</p>\r\n<p>\r\n<strong>Mail settings</strong>\r\n</p>\r\n<p>\r\nCatch all email with your default email account\r\n</p>\r\n<p>\r\nPOP3 Host Address : mail.{$service_domain}<br />\r\nSMTP Host Address: mail.{$service_domain}<br />\r\nUsername: {$service_username}<br />\r\nPassword: {$service_password}\r\n</p>\r\n<p>\r\nAdditional mail accounts that you add\r\n</p>\r\n<p>\r\nPOP3 Host Address : mail.{$service_domain}<br />\r\nSMTP Host Address: mail.{$service_domain}<br />\r\nUsername : The FULL email address that you are picking up from (e.g. info@yourdomain.com). <br />\r\nIf your email client cannot accept a @ symbol, then you may replace this with a backslash .<br />\r\nPassword : As specified in your control panel \r\n</p>\r\n<p>\r\nThank you for choosing us.\r\n</p>\r\n<p>\r\n{$signature}\r\n</p>\r\n', '', '', '', '', '', '', '', 0),
(30, 'domain', 'Upcoming Domain Renewal Notice', 'Upcoming Domain Renewal Notice', '<p>Dear {$client_name}, </p><p>The domain name listed below will expire in {$domain_days_until_expiry} days.</p><p>{$domain_name} - {$domain_next_due_date}</p><p>To ensure the domain does not expire, you should renew it now. You can do this from the domains management section of our client area here: {$whmcs_url}</p><p>Should you allow the domain to expire, you will be able to renew it for up to 30 days after the renewal date. During this time, the domain will not be accessible so any web site or email services associated with it will stop working.</p><p>{$signature}</p>', '', '', '', '', '', '', '', 0),
(28, 'domain', 'Domain Transfer Initiated', 'Domain Transfer Initiated', '<p>Dear {$client_name}, </p><p>Thank you for your domain transfer order. Your order has been received and we have now initiated the transfer process. The details of the domain purchase are below: </p><p>Domain: {$domain_name}<br />Registration Length: {$domain_reg_period}<br />Transfer Price: {$domain_first_payment_amount}<br />Renewal Price: {$domain_recurring_amount}<br />Next Due Date: {$domain_next_due_date} </p><p>You may login to your client area at {$whmcs_url} to manage your domain. </p><p>{$signature} </p>', '', '', '', '', '', '', '', 0),
(7, 'support', 'Support Ticket Opened', 'New Support Ticket Opened', '<p>\r\n{$client_name},\r\n</p>\r\n<p>\r\nThank you for contacting our support team. A support ticket has now been opened for your request. You will be notified when a response is made by email. The details of your ticket are shown below.\r\n</p>\r\n<p>\r\nSubject: {$ticket_subject}<br />\r\nPriority: {$ticket_priority}<br />\r\nStatus: {$ticket_status}\r\n</p>\r\n<p>\r\nYou can view the ticket at any time at {$ticket_link}\r\n</p>\r\n<p>\r\n{$signature}\r\n</p>\r\n', '', '', '', '', '', '', '', 0),
(8, 'support', 'Support Ticket Reply', 'Support Ticket Response', '<p>\r\n{$ticket_message}\r\n</p>\r\n<p>\r\n----------------------------------------------<br />\r\nTicket ID: #{$ticket_id}<br />\r\nSubject: {$ticket_subject}<br />\r\nStatus: {$ticket_status}<br />\r\nTicket URL: {$ticket_link}<br />\r\n----------------------------------------------\r\n</p>\r\n', '', '', '', '', '', '', '', 0),
(9, 'general', 'Client Signup Email', 'Welcome', '<p>\r\nDear {$client_name}, \r\n</p>\r\n<p>\r\nThank you for signing up with us. Your new account has been setup and you can now login to our client area using the details below. \r\n</p>\r\n<p>\r\nEmail Address: {$client_email}<br />\r\nPassword: {$client_password} \r\n</p>\r\n<p>\r\nTo login, visit {$whmcs_url} \r\n</p>\r\n<p>\r\n{$signature} \r\n</p>\r\n', '', '', '', '', '', '', '', 0),
(10, 'product', 'Service Suspension Notification', 'Service Suspension Notification', '<p>Dear {$client_name},</p><p>This is a notification that your service has now been suspended.  The details of this suspension are below:</p><p>Product/Service: {$service_product_name}<br />{if $service_domain}Domain: {$service_domain}<br />{/if}Amount: {$service_recurring_amount}<br />Due Date: {$service_next_due_date}<br />Suspension Reason: <strong>{$service_suspension_reason}</strong></p><p>Please contact us as soon as possible to get your service reactivated.</p><p>{$signature}</p>', '', '', '', '', '', '', '', 0),
(32, 'general', 'Credit Card Expiring Soon', 'Credit Card Expiring Soon', '<p>Dear {$client_name}, </p><p>This is a notice to inform you that your {$client_cc_type} credit card ending with {$client_cc_number} will be expiring next month on {$client_cc_expiry}. Please login to update your credit card information as soon as possible and prevent any interuptions in service at {$whmcs_url}<br /><br />If you have any questions regarding your account, please open a support ticket from the client area.</p><p>{$signature}</p>', '', '', '', '', '', '', '', 0),
(31, 'support', 'Bounce Message', 'Support Ticket Not Opened', '<p>{$client_name},</p><p>Your email to our support system could not be accepted because it was not recognized as coming from an email address belonging to one of our customers.  If you need assistance, please email from the address you registered with us that you use to login to our client area.</p><p>{$signature}</p>', '', '', '', '', '', '', '', 0),
(13, 'invoice', 'Invoice Payment Confirmation', 'Invoice Payment Confirmation', '<p>Dear {$client_name},</p>\r\n<p>This is a payment receipt for Invoice {$invoice_num} sent on {$invoice_date_created}</p>\r\n<p>{$invoice_html_contents}</p>\r\n<p>Amount: {$invoice_last_payment_amount}<br />Transaction #: {$invoice_last_payment_transid}<br />Total Paid: {$invoice_amount_paid}<br />Remaining Balance: {$invoice_balance}<br />Status: {$invoice_status}</p>\r\n<p>You may review your invoice history at any time by logging in to your client area.</p>\r\n<p>Note: This email will serve as an official receipt for this payment.</p>\r\n<p>{$signature}</p>', '', '', '', '', '', '', '', 0),
(14, 'invoice', 'Invoice Created', 'Customer Invoice', '<p>\r\nDear {$client_name}, \r\n</p>\r\n<p>\r\nThis is a notice that an invoice has been generated on {$invoice_date_created}. \r\n</p>\r\n<p>\r\nYour payment method is: {$invoice_payment_method} \r\n</p>\r\n<p>\r\nInvoice #{$invoice_num}<br />\r\nAmount Due: {$invoice_total}<br />\r\nDue Date: {$invoice_date_due} \r\n</p>\r\n<p>\r\n<strong>Invoice Items</strong> \r\n</p>\r\n<p>\r\n{$invoice_html_contents} <br />\r\n------------------------------------------------------ \r\n</p>\r\n<p>\r\nYou can login to your client area to view and pay the invoice at {$invoice_link} \r\n</p>\r\n<p>\r\n{$signature} \r\n</p>\r\n', '', '', '', '', '', '', '', 0),
(15, 'invoice', 'Invoice Payment Reminder', 'Invoice Payment Reminder', '<p>\r\nDear {$client_name},\r\n</p>\r\n<p>\r\nThis is a billing reminder that your invoice no. {$invoice_num} which was generated on {$invoice_date_created} is due on {$invoice_date_due}.\r\n</p>\r\n<p>\r\nYour payment method is: {$invoice_payment_method}\r\n</p>\r\n<p>\r\nInvoice: {$invoice_num}<br />\r\nBalance Due: {$invoice_balance}<br />\r\nDue Date: {$invoice_date_due}\r\n</p>\r\n<p>\r\nYou can login to your client area to view and pay the invoice at {$invoice_link}\r\n</p>\r\n<p>\r\n{$signature}\r\n</p>\r\n', '', '', '', '', '', '', '', 0),
(16, 'general', 'Order Confirmation', 'Order Confirmation', '<p>\r\nDear {$client_name}, \r\n</p>\r\n<p>\r\nWe have received your order and will be processing it shortly. The details of the order are below: \r\n</p>\r\n<p>\r\nOrder Number: <b>{$order_number}</b></p>\r\n<p>\r\n{$order_details} \r\n</p>\r\n<p>\r\nYou will receive an email from us shortly once your account has been setup. Please quote your order reference number if you wish to contact us about this order. \r\n</p>\r\n<p>\r\n{$signature}\r\n</p>\r\n', '', '', '', '', '', '', '', 0),
(17, 'product', 'Dedicated/VPS Server Welcome Email', 'New Dedicated Server Information', '<p>\r\nDear {$client_name},<br />\r\n<br />\r\n<strong>PLEASE PRINT THIS MESSAGE FOR YOUR RECORDS - PLEASE READ THIS EMAIL IN FULL.</strong>\r\n</p>\r\n<p>\r\nWe are pleased to tell you that the server you ordered has now been set up and is operational.\r\n</p>\r\n<p>\r\n<strong>Server Details<br />\r\n</strong>=============================\r\n</p>\r\n<p>\r\n{$service_product_name}\r\n</p>\r\n<p>\r\nMain IP: {$service_dedicated_ip}<br />\r\nRoot pass: {$service_password}\r\n</p>\r\n<p>\r\nIP address allocation: <br />\r\n{$service_assigned_ips}\r\n</p>\r\n<p>\r\nServerName: {$service_domain}\r\n</p>\r\n<p>\r\n<strong>WHM Access<br />\r\n</strong>=============================<br />\r\n<a href="http://xxxxx:2086/">http://xxxxx:2086</a><br />\r\nUsername: root<br />\r\nPassword: {$service_password}\r\n</p>\r\n<p>\r\n<strong>Custom DNS Server Addresses</strong><br />\r\n=============================<br />\r\nThe custom DNS addresses you should set for your domain to use are: <br />\r\nPrimary DNS: {$service_ns1}<br />\r\nSecondary DNS: {$service_ns2}\r\n</p>\r\n<p>\r\nYou will have to login to your registrar and find the area where you can specify both of your custom name server addresses.\r\n</p>\r\n<p>\r\nAfter adding these custom nameservers to your domain registrar control panel, it will take 24 to 48 hours for your domain to delegate authority to your DNS server. Once this has taken effect, your DNS server has control over the DNS records for the domains which use your custom name server addresses. \r\n</p>\r\n<p>\r\n<strong>SSH Access Information<br />\r\n</strong>=============================<br />\r\nMain IP Address: xxxxxxxx<br />\r\nServer Name: {$service_domain}<br />\r\nRoot Password: xxxxxxxx\r\n</p>\r\n<p>\r\nYou can access your server using a free simple SSH client program called Putty located at:<br />\r\n<a href="http://www.securitytools.net/mirrors/putty/">http://www.securitytools.net/mirrors/putty/</a>\r\n</p>\r\n<p>\r\n<strong>Support</strong><br />\r\n=============================<br />\r\nFor any support needs, please open a ticket at {$whmcs_url}\r\n</p>\r\n<p>\r\nPlease include any necessary information to provide you with faster service, such as root password, domain names, and a description of the problem / or assistance needed. This will speed up the support time by allowing our administrators to immediately begin diagnosing the problem.\r\n</p>\r\n<p>\r\nThe manual for cPanel can be found here: <a href="http://www.cpanel.net/docs/cp/">http://www.cpanel.net/docs/cp/</a> <br />\r\nFor documentation on using WHM please see the following link: <a href="http://www.cpanel.net/docs/whm/index.html">http://www.cpanel.net/docs/whm/index.html</a>\r\n</p>\r\n<p>\r\n=============================\r\n</p>\r\n<p>\r\nIf you need to move accounts to the server use: Transfers Copy an account from another server with account password\r\n</p>\r\n<p>\r\n<a href="http://xxxxxxx:2086/scripts2/norootcopy">http://xxxxxxx:2086/scripts2/norootcopy</a>\r\n</p>\r\n<p>\r\nNote the other server must use cpanel to move it.\r\n</p>\r\n<p>\r\n=============================\r\n</p>\r\n<p>\r\n{$signature}\r\n</p>\r\n', '', '', '', '', '', '', '', 0),
(18, 'product', 'Other Product/Service Welcome Email', 'New Product Information', '<p>\r\nDear {$client_name},\r\n</p>\r\n<p>\r\nYour order for {$service_product_name} has now been activated. Please keep this message for your records.\r\n</p>\r\n<p>\r\nProduct/Service: {$service_product_name}<br />\r\nPayment Method: {$service_payment_method}<br />\r\nAmount: {$service_recurring_amount}<br />\r\nBilling Cycle: {$service_billing_cycle}<br />\r\nNext Due Date: {$service_next_due_date}\r\n</p>\r\n<p>\r\nThank you for choosing us.\r\n</p>\r\n<p>\r\n{$signature}\r\n</p>\r\n', '', '', '', '', '', '', '', 0),
(19, 'invoice', 'Credit Card Payment Confirmation', 'Credit Card Payment Confirmation', '<p>Dear {$client_name},</p>\r\n<p>This is a payment receipt for Invoice {$invoice_num} sent on {$invoice_date_created}</p>\r\n<p>{$invoice_html_contents}</p>\r\n<p>Amount: {$invoice_last_payment_amount}<br />Transaction #: {$invoice_last_payment_transid}<br />Total Paid: {$invoice_amount_paid}<br />Remaining Balance: {$invoice_balance}<br />Status: {$invoice_status}</p>\r\n<p>You may review your invoice history at any time by logging in to your client area.</p>\r\n<p>Note: This email will serve as an official receipt for this payment.</p>\r\n<p>{$signature}</p>', '', '', '', '', '', '', '', 0),
(20, 'invoice', 'Credit Card Payment Failed', 'Credit Card Payment Failed', '<p>\r\nDear {$client_name}, \r\n</p>\r\n<p>\r\nThis is a notice that a recent credit card payment we attempted on the card we have registered for you failed. \r\n</p>\r\n<p>\r\nInvoice Date: {$invoice_date_created}<br />\r\nInvoice No: {$invoice_num}<br />\r\nAmount: {$invoice_total}<br />\r\nStatus: {$invoice_status} \r\n</p>\r\n<p>\r\nYou now need to login to your client area to pay the invoice manually. During the payment process you will be given the opportunity to change the card on record with us.<br />\r\n{$invoice_link} \r\n</p>\r\n<p>\r\nNote: This email will serve as an official receipt for this payment. \r\n</p>\r\n<p>\r\n{$signature}\r\n</p>\r\n', '', '', '', '', '', '', '', 0),
(21, 'invoice', 'Credit Card Invoice Created', 'Customer Invoice', '<p> Dear {$client_name}, </p> <p> This is a notice that an invoice has been generated on {$invoice_date_created}. </p> <p> Your payment method is: {$invoice_payment_method} </p> <p> Invoice #{$invoice_num}<br /> Amount Due: {$invoice_total}<br /> Due Date: {$invoice_date_due} </p> <p> <strong>Invoice Items</strong> </p> <p> {$invoice_html_contents} <br /> ------------------------------------------------------ </p> <p> Payment will be taken automatically on {$invoice_date_due} from your credit card on record with us. To update or change the credit card details we hold for your account please login at {$invoice_link} and click Pay Now then following the instructions on screen. </p> <p> {$signature} </p>', '', '', '', '', '', '', '', 0),
(22, 'affiliate', 'Affiliate Monthly Referrals Report', 'Affiliate Monthly Referrals Report', '<p>\r\nDear {$client_name}, \r\n</p>\r\n<p>\r\nThis is your monthly affiliate referrals report. You can view your referral statistics at any time by logging in to the client area. \r\n</p>\r\n<p>\r\nTotal Visitors Referred: {$affiliate_total_visits}<br />\r\nCurrent Earnings: {$affiliate_balance}<br />\r\nAmount Withdrawn: {$affiliate_withdrawn} \r\n</p>\r\n<p>\r\n<strong>Your New Signups this Month</strong> \r\n</p>\r\n<p>\r\n{$affiliate_referrals_table} \r\n</p>\r\n<p>\r\nRemember, you can refer new customers using your unique affiliate link: {$affiliate_referral_url} \r\n</p>\r\n<p>\r\n{$signature}\r\n</p>\r\n', '', '', '', '', '', '', '', 0),
(23, 'support', 'Support Ticket Opened by Admin', '{$ticket_subject}', '{$ticket_message}', '', '', '', '', '', '', '', 0),
(24, 'invoice', 'First Invoice Overdue Notice', 'First Invoice Overdue Notice', '<p> Dear {$client_name}, </p> <p> This is a billing notice that your invoice no. {$invoice_num} which was generated on {$invoice_date_created} is now overdue. </p> <p> Your payment method is: {$invoice_payment_method} </p> <p> Invoice: {$invoice_num}<br /> Balance Due: {$invoice_balance}<br /> Due Date: {$invoice_date_due} </p> <p> You can login to your client area to view and pay the invoice at {$invoice_link} </p> <p> Your login details are as follows: </p> <p> Email Address: {$client_email}<br /> Password: {$client_password} </p> <p> {$signature} </p>', '', '', '', '', '', '', '', 0),
(25, 'product', 'SHOUTcast Welcome Email', 'SHOUTcast New Account Information', '<p align="center">\r\n<strong>PLEASE READ THIS EMAIL IN FULL AND PRINT IT FOR YOUR RECORDS</strong> \r\n</p>\r\n<p>\r\nDear {$client_name}, \r\n</p>\r\n<p>\r\nThank you for your order from us! Your shoutcast account has now been setup and this email contains all the information you will need in order to begin using your account. \r\n</p>\r\n<p>\r\n<strong>New Account Information</strong> \r\n</p>\r\n<p>\r\nDomain: {$service_domain}<br />\r\nUsername: {$service_username}<br />\r\nPassword: {$service_password} \r\n</p>\r\n<p>\r\n<strong>Server Information</strong> \r\n</p>\r\n<p>\r\nServer Name: {$service_server_name}<br />\r\nServer IP: {$service_server_ip}<br />\r\nNameserver 1: {$service_ns1}<br />\r\nNameserver 1 IP: {$service_ns1_ip}<br />\r\nNameserver 2: {$service_ns2} <br />\r\nNameserver 2 IP: {$service_ns2_ip} \r\n</p>\r\n<p>\r\nThank you for choosing us. \r\n</p>\r\n<p>\r\n{$signature}\r\n</p>\r\n', '', '', '', '', '', '', '', 0),
(26, 'invoice', 'Second Invoice Overdue Notice', 'Second Invoice Overdue Notice', '<p> Dear {$client_name}, </p> <p> This is the second billing notice that your invoice no. {$invoice_num} which was generated on {$invoice_date_created} is now overdue. </p> <p> Your payment method is: {$invoice_payment_method} </p> <p> Invoice: {$invoice_num}<br /> Balance Due: {$invoice_balance}<br /> Due Date: {$invoice_date_due} </p> <p> You can login to your client area to view and pay the invoice at {$invoice_link} </p> <p> Your login details are as follows: </p> <p> Email Address: {$client_email}<br /> Password: {$client_password} </p> <p> {$signature} </p>', '', '', '', '', '', '', '', 0),
(27, 'invoice', 'Third Invoice Overdue Notice', 'Third Invoice Overdue Notice', '<p> Dear {$client_name}, </p> <p> This is the third and final billing notice that your invoice no. {$invoice_num} which was generated on {$invoice_date_created} is now overdue. Failure to make payment will result in account suspension.</p> <p> Your payment method is: {$invoice_payment_method} </p> <p> Invoice: {$invoice_num}<br /> Balance Due: {$invoice_balance}<br /> Due Date: {$invoice_date_due} </p> <p> You can login to your client area to view and pay the invoice at {$invoice_link} </p> <p> Your login details are as follows: </p> <p> Email Address: {$client_email}<br /> Password: {$client_password} </p> <p> {$signature} </p>', '', '', '', '', '', '', '', 0),
(33, 'support', 'Support Ticket Auto Close Notification', 'Support Ticket Resolved', '<p>{$client_name},</p><p>This is a notification to let you know that we are changing the status of your ticket #{$ticket_id} to Closed as we have not received a response from you in over {$ticket_auto_close_time} hours.</p><p>Subject: {$ticket_subject}<br>Department: {$ticket_department}<br>Priority: {$ticket_priority}<br>Status: {$ticket_status}</p><p>If you have any further questions then please just reply to re-open the ticket.</p><p>{$signature}</p>', '', '', '', '', '', '', '', 0),
(34, 'invoice', 'Credit Card Payment Due', 'Invoice Payment Reminder', '<p>Dear {$client_name},</p><p>This is a notice to remind you that you have an invoice due on {$invoice_date_due}. We tried to bill you automatically but were unable to because we don''t have your credit card details on file.</p><p>Invoice Date: {$invoice_date_created}<br>Invoice #{$invoice_num}<br>Amount Due: {$invoice_total}<br>Due Date: {$invoice_date_due}</p><p>Please login to our client area at the link below to submit your card details or make payment using a different method.</p><p>{$invoice_link}</p><p>{$signature}</p>', '', '', '', '', '', '', '', 0),
(35, 'product', 'Cancellation Request Confirmation', 'Cancellation Request Confirmation', '<p>Dear {$client_name},</p><p>This email is to confirm that we have received your cancellation request for the service listed below.</p><p>Product/Service: {$service_product_name}<br />Domain: {$service_domain}</p><p>If you requested immediate cancellation then the service will be terminated within the next 24 hours. If however you chose end of billing cycle, it will not be cancelled until {$service_next_due_date}.</p><p>Thank you for using {$company_name} and we hope to see you again in the future.</p><p>{$signature}</p>', '', '', '', '', '', '', '', 0),
(36, 'general', 'Quote Delivery with PDF', 'Quote #{$quote_number} - {$quote_subject}', '<p>Dear {$client_name},</p>\r\n<p>Here is the quote you requested for {$quote_subject}. The quote is valid until {$quote_valid_until}. You may simply reply to this email with any furthur questions or requirement.</p>\r\n<p>{$signature}</p>', '', '', '', '', '', '', '', 0),
(37, 'general', 'Password Reset Validation', 'Your login details for {$company_name}', '<p>Dear {$client_name},</p><p>Recently a request was submitted to reset your password for our client area. If you did not request this, please ignore this email. It will expire and become useless in 2 hours time.</p><p>To reset your password, please visit the url below:<br /><a href="{$pw_reset_url}">{$pw_reset_url}</a></p><p>When you visit the link above, your password will be reset, and the new password will be emailed to you.</p><p>{$signature}</p>', '', '', '', '', '', '', '', 0),
(38, 'general', 'Password Reset Confirmation', 'Your new password for {$company_name}', '<p>Dear {$client_name},</p><p>As you requested, your password for our client area has now been reset.  Your new login details are as follows:</p><p>{$whmcs_link}<br />Email: {$client_email}<br />Password: {$client_password}</p><p>To change your password to something more memorable, after logging in go to My Details > Change Password.</p><p>{$signature}</p>', '', '', '', '', '', '', '', 0),
(39, 'admin', 'Automatic Setup Failed', 'WHMCS Automatic Setup Failed', '<p>An order has received its first payment but the automatic provisioning has failed and requires you to manually check & resolve.</p>\r\n<p>Client ID: {$client_id}<br />{if $service_id}Service ID: {$service_id}<br />Product/Service: {$service_product}<br />Domain: {$service_domain}{else}Domain ID: {$domain_id}<br />Registration Type: {$domain_type}<br />Domain: {$domain_name}{/if}<br />Error: {$error_msg}</p>\r\n<p>{$whmcs_admin_link}</p>', '', '', '', '', '', '', '', 0),
(40, 'admin', 'Automatic Setup Successful', 'WHMCS Automatic Setup Successful', '<p>An order has received its first payment and the product/service has been automatically provisioned successfully.</p>\r\n<p>Client ID: {$client_id}<br />{if $service_id}Service ID: {$service_id}<br />Product/Service: {$service_product}<br />Domain: {$service_domain}{else}Domain ID: {$domain_id}<br />Registration Type: {$domain_type}<br />Domain: {$domain_name}{/if}</p>\r\n<p>{$whmcs_admin_link}</p>', '', '', '', '', '', '', '', 0),
(41, 'admin', 'Domain Renewal Failed', 'WHMCS Automatic Domain Renewal Failed', '<p>An invoice for the renewal of a domain has been paid but the renewal request submitted to the registrar failed.</p>\r\n<p>Client ID: {$client_id}<br />Domain ID: {$domain_id}<br />Domain Name: {$domain_name}<br />Error: {$error_msg}</p>\r\n<p>{$whmcs_admin_link}</p>', '', '', '', '', '', '', '', 0),
(42, 'admin', 'Domain Renewal Successful', 'WHMCS Automatic Domain Renewal Successful', '<p>An invoice for the renewal of a domain has been paid and the renewal request was submitted to the registrar successfully.</p>\r\n<p>Client ID: {$client_id}<br />Domain ID: {$domain_id}<br />Domain Name: {$domain_name}</p>\r\n<p>{$whmcs_admin_link}</p>', '', '', '', '', '', '', '', 0),
(43, 'admin', 'New Order Notification', 'WHMCS New Order Notification', '<p><strong>Order Information</strong></p>\r\n<p>Order ID: {$order_id}<br />\r\nOrder Number: {$order_number}<br />\r\nDate/Time: {$order_date}<br />\r\nInvoice Number: {$invoice_id}<br />\r\nPayment Method: {$order_payment_method}</p>\r\n<p><strong>Customer Information</strong></p>\r\n<p>Customer ID: {$client_id}<br />\r\nName: {$client_first_name} {$client_last_name}<br />\r\nEmail: {$client_email}<br />\r\nCompany: {$client_company_name}<br />\r\nAddress 1: {$client_address1}<br />\r\nAddress 2: {$client_address2}<br />\r\nCity: {$client_city}<br />\r\nState: {$client_state}<br />\r\nPostcode: {$client_postcode}<br />\r\nCountry: {$client_country}<br />\r\nPhone Number: {$client_phonenumber}</p>\r\n<p><strong>Order Items</strong></p>\r\n<p>{$order_items}</p>\r\n{if $order_notes}<p><strong>Order Notes</strong></p>\r\n<p>{$order_notes}</p>{/if}\r\n<p><strong>ISP Information</strong></p>\r\n<p>IP: {$client_ip}<br />\r\nHost: {$client_hostname}</p><p><a href="{$whmcs_admin_url}orders.php?action=view&id={$order_id}">{$whmcs_admin_url}orders.php?action=view&id={$order_id}</a></p>', '', '', '', '', '', '', '', 0),
(44, 'admin', 'Service Unsuspension Failed', 'WHMCS Service Unsuspension Failed', '<p>This product/service has received its next payment but the automatic reactivation has failed.</p>\r\n<p>Client ID: {$client_id}<br />Service ID: {$service_id}<br />Product/Service: {$service_product}<br />Domain: {$service_domain}<br />Error: {$error_msg}</p>\r\n<p>{$whmcs_admin_link}</p>', '', '', '', '', '', '', '', 0),
(45, 'admin', 'Service Unsuspension Successful', 'WHMCS Service Unsuspension Successful', '<p>This product/service has received its next payment and has been reactivated successfully.</p>\r\n<p>Client ID: {$client_id}<br />Service ID: {$service_id}<br />Product/Service: {$service_product}<br />Domain: {$service_domain}</p>\r\n<p>{$whmcs_admin_link}</p>', '', '', '', '', '', '', '', 0),
(46, 'admin', 'Support Ticket Created', '[Ticket ID: {$ticket_tid}] New Support Ticket Opened', '<p>A new support ticket has been opened.</p>\r\n<p>Client: {$client_name}{if $client_id} #{$client_id}{/if}<br />Department: {$ticket_department}<br />Subject: {$ticket_subject}<br />Priority: {$ticket_priority}</p>\r\n<p>---<br />{$ticket_message}<br />---</p>\r\n<p>You can respond to this ticket by simply replying to this email or through the admin area at the url below.</p>\r\n<p><a href="{$whmcs_admin_url}supporttickets.php?action=viewticket&id={$ticket_id}">{$whmcs_admin_url}supporttickets.php?action=viewticket&id={$ticket_id}</a></p>', '', '', '', '', '', '', '', 0),
(47, 'admin', 'Support Ticket Response', '[Ticket ID: {$ticket_tid}] New Support Ticket Response', '<p>A new support ticket response has been made.</p>\r\n<p>Client: {$client_name}{if $client_id} #{$client_id}{/if} <br />Department: {$ticket_department} <br />Subject: {$ticket_subject} <br />Priority: {$ticket_priority}</p>\r\n<p>--- <br />{$ticket_message} <br />---</p>\r\n<p>You can respond to this ticket by simply replying to this email or through the admin area at the url below.</p>\r\n<p><a href="{$whmcs_admin_url}supporttickets.php?action=viewticket&id={$ticket_id}">{$whmcs_admin_url}supporttickets.php?action=viewticket&id={$ticket_id}</a></p>', '', '', '', '', '', '', '', 0),
(48, 'admin', 'Escalation Rule Notification', '[Ticket ID: {$tickettid}] Escalation Rule Notification', '<p>The escalation rule {$name} has just been applied to this ticket.</p>\r\n<p>Client: {$clientname}<br />Department: {$deptname}<br />Subject: {$ticketsubject}<br />Priority: {$ticketpriority}<br />Status: {$ticketstatus}</p>\r\n<p>You can respond to this ticket by simply replying to this email or by logging into the administration area.</p>', '', '', '', '', '', '', '', 0),
(49, 'admin', 'Support Ticket Department Reassigned', '[Ticket ID: {$ticket_tid}] Support Ticket Department Reassigned', '<p>The department this ticket is assigned to has been changed to a department you are a member of.</p><p>Client: {$client_name}{if $client_id} #{$client_id}{/if}<br />Department: {$ticket_department}<br />Subject: {$ticket_subject}<br />Priority: {$ticket_priority}</p><p>---<br />{$ticket_message}<br />---</p><p>You can respond to this ticket by simply replying to this email or through the admin area at the url below.</p><p><a href="{$whmcs_admin_url}supporttickets.php?action=viewticket&id={$ticket_id}">{$whmcs_admin_url}supporttickets.php?action=viewticket&id={$ticket_id}</a></p>', '', '', '', '', '', '', '', 0),
(50, 'invoice', 'Invoice Refund Confirmation', 'Invoice Refund Confirmation', '<p>Dear {$client_name},</p>\r\n<p>This is confirmation that a {if $invoice_status eq "Refunded"}full{else}partial{/if} refund has been processed for Invoice #{$invoice_num}</p>\r\n<p>The refund has been {if $invoice_refund_type eq "credit"}credited to your account balance with us{else}returned via the payment method you originally paid with{/if}.</p>\r\n<p>{$invoice_html_contents}</p>\r\n<p>Amount Refunded: {$invoice_last_payment_amount}{if $invoice_last_payment_transid}<br />Transaction #: {$invoice_last_payment_transid}{/if}<br />Balance Remaining: {$invoice_balance}</p>\r\n<p>You may review your invoice history at any time by logging in to your client area.</p>\r\n<p>{$signature}</p>', '', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblfraud`
--

CREATE TABLE IF NOT EXISTS `tblfraud` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fraud` text NOT NULL,
  `setting` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fraud` (`fraud`(32))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblgatewaylog`
--

CREATE TABLE IF NOT EXISTS `tblgatewaylog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gateway` text NOT NULL,
  `data` text NOT NULL,
  `result` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblhosting`
--

CREATE TABLE IF NOT EXISTS `tblhosting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `orderid` int(10) NOT NULL,
  `packageid` int(10) NOT NULL,
  `server` int(10) NOT NULL,
  `regdate` date NOT NULL,
  `domain` text NOT NULL,
  `paymentmethod` text NOT NULL,
  `firstpaymentamount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `billingcycle` text NOT NULL,
  `nextduedate` date DEFAULT NULL,
  `nextinvoicedate` date NOT NULL,
  `domainstatus` enum('Pending','Active','Suspended','Terminated','Cancelled','Fraud') NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `notes` text NOT NULL,
  `subscriptionid` text NOT NULL,
  `promoid` int(10) NOT NULL,
  `suspendreason` text NOT NULL,
  `overideautosuspend` text NOT NULL,
  `overidesuspenduntil` date NOT NULL,
  `dedicatedip` text NOT NULL,
  `assignedips` text NOT NULL,
  `ns1` text NOT NULL,
  `ns2` text NOT NULL,
  `diskusage` int(10) NOT NULL DEFAULT '0',
  `disklimit` int(10) NOT NULL DEFAULT '0',
  `bwusage` int(10) NOT NULL DEFAULT '0',
  `bwlimit` int(10) NOT NULL DEFAULT '0',
  `lastupdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `serviceid` (`id`),
  KEY `userid` (`userid`),
  KEY `orderid` (`orderid`),
  KEY `productid` (`packageid`),
  KEY `serverid` (`server`),
  KEY `domain` (`domain`(64)),
  KEY `domainstatus` (`domainstatus`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblhostingaddons`
--

CREATE TABLE IF NOT EXISTS `tblhostingaddons` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `orderid` int(10) NOT NULL,
  `hostingid` int(10) NOT NULL,
  `addonid` int(10) NOT NULL,
  `name` text NOT NULL,
  `setupfee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `recurring` decimal(10,2) NOT NULL DEFAULT '0.00',
  `billingcycle` text NOT NULL,
  `tax` text NOT NULL,
  `status` enum('Pending','Active','Suspended','Terminated','Cancelled','Fraud') NOT NULL DEFAULT 'Pending',
  `regdate` date NOT NULL DEFAULT '0000-00-00',
  `nextduedate` date DEFAULT NULL,
  `nextinvoicedate` date NOT NULL,
  `paymentmethod` text NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orderid` (`orderid`),
  KEY `serviceid` (`hostingid`),
  KEY `name` (`name`(32)),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblhostingconfigoptions`
--

CREATE TABLE IF NOT EXISTS `tblhostingconfigoptions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `relid` int(10) NOT NULL,
  `configid` int(10) NOT NULL,
  `optionid` int(10) NOT NULL,
  `qty` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `relid_configid` (`relid`,`configid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblinvoiceitems`
--

CREATE TABLE IF NOT EXISTS `tblinvoiceitems` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `invoiceid` int(10) NOT NULL DEFAULT '0',
  `userid` int(10) NOT NULL,
  `type` text NOT NULL,
  `relid` int(10) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `taxed` int(1) NOT NULL,
  `duedate` date DEFAULT NULL,
  `paymentmethod` text NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `invoiceid` (`invoiceid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblinvoices`
--

CREATE TABLE IF NOT EXISTS `tblinvoices` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `invoicenum` text NOT NULL,
  `date` date DEFAULT NULL,
  `duedate` date DEFAULT NULL,
  `datepaid` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `subtotal` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `tax2` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `taxrate` decimal(10,2) NOT NULL,
  `taxrate2` decimal(10,2) NOT NULL,
  `status` text NOT NULL,
  `paymentmethod` text NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `status` (`status`(3))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblknowledgebase`
--

CREATE TABLE IF NOT EXISTS `tblknowledgebase` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `article` text NOT NULL,
  `views` int(10) NOT NULL DEFAULT '0',
  `useful` int(10) NOT NULL DEFAULT '0',
  `votes` int(10) NOT NULL DEFAULT '0',
  `private` text NOT NULL,
  `order` int(3) NOT NULL,
  `parentid` int(10) NOT NULL,
  `language` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblknowledgebasecats`
--

CREATE TABLE IF NOT EXISTS `tblknowledgebasecats` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parentid` int(10) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `description` text NOT NULL,
  `hidden` text NOT NULL,
  `catid` int(10) NOT NULL,
  `language` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parentid` (`parentid`),
  KEY `name` (`name`(64))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblknowledgebaselinks`
--

CREATE TABLE IF NOT EXISTS `tblknowledgebaselinks` (
  `categoryid` int(10) NOT NULL,
  `articleid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbllinks`
--

CREATE TABLE IF NOT EXISTS `tbllinks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `clicks` int(10) NOT NULL,
  `conversions` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(64))
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblmodulelog`
--

CREATE TABLE IF NOT EXISTS `tblmodulelog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `module` text NOT NULL,
  `action` text NOT NULL,
  `request` text NOT NULL,
  `response` text NOT NULL,
  `arrdata` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblnetworkissues`
--

CREATE TABLE IF NOT EXISTS `tblnetworkissues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `type` enum('Server','System','Other') NOT NULL,
  `affecting` varchar(100) DEFAULT NULL,
  `server` int(10) unsigned DEFAULT NULL,
  `priority` enum('Critical','Low','Medium','High') NOT NULL,
  `startdate` datetime NOT NULL,
  `enddate` datetime DEFAULT NULL,
  `status` enum('Reported','Investigating','In Progress','Outage','Scheduled','Resolved') NOT NULL,
  `lastupdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblnotes`
--

CREATE TABLE IF NOT EXISTS `tblnotes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `adminid` int(10) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblorders`
--

CREATE TABLE IF NOT EXISTS `tblorders` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ordernum` bigint(10) NOT NULL,
  `userid` int(10) NOT NULL,
  `contactid` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `nameservers` text NOT NULL,
  `transfersecret` text NOT NULL,
  `renewals` text NOT NULL,
  `promocode` text NOT NULL,
  `promotype` text NOT NULL,
  `promovalue` text NOT NULL,
  `orderdata` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paymentmethod` text NOT NULL,
  `invoiceid` int(10) NOT NULL DEFAULT '0',
  `status` text NOT NULL,
  `ipaddress` text NOT NULL,
  `fraudmodule` text NOT NULL,
  `fraudoutput` text NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ordernum` (`ordernum`),
  KEY `userid` (`userid`),
  KEY `contactid` (`contactid`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblpaymentgateways`
--

CREATE TABLE IF NOT EXISTS `tblpaymentgateways` (
  `gateway` text NOT NULL,
  `setting` text NOT NULL,
  `value` text NOT NULL,
  `order` int(1) NOT NULL,
  KEY `gateway_setting` (`gateway`(32),`setting`(32)),
  KEY `setting_value` (`setting`(32),`value`(32))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblpaymentgateways`
--

INSERT INTO `tblpaymentgateways` (`gateway`, `setting`, `value`, `order`) VALUES
('paypal', 'forcesubscriptions', '', 0),
('paypal', 'forceonetime', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblpricing`
--

CREATE TABLE IF NOT EXISTS `tblpricing` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` enum('product','addon','configoptions','domainregister','domaintransfer','domainrenew','domainaddons') NOT NULL,
  `currency` int(10) NOT NULL,
  `relid` int(10) NOT NULL,
  `msetupfee` decimal(10,2) NOT NULL,
  `qsetupfee` decimal(10,2) NOT NULL,
  `ssetupfee` decimal(10,2) NOT NULL,
  `asetupfee` decimal(10,2) NOT NULL,
  `bsetupfee` decimal(10,2) NOT NULL,
  `tsetupfee` decimal(10,2) NOT NULL,
  `monthly` decimal(10,2) NOT NULL,
  `quarterly` decimal(10,2) NOT NULL,
  `semiannually` decimal(10,2) NOT NULL,
  `annually` decimal(10,2) NOT NULL,
  `biennially` decimal(10,2) NOT NULL,
  `triennially` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblproductconfiggroups`
--

CREATE TABLE IF NOT EXISTS `tblproductconfiggroups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblproductconfiglinks`
--

CREATE TABLE IF NOT EXISTS `tblproductconfiglinks` (
  `gid` int(10) NOT NULL,
  `pid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblproductconfigoptions`
--

CREATE TABLE IF NOT EXISTS `tblproductconfigoptions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gid` int(10) NOT NULL DEFAULT '0',
  `optionname` text NOT NULL,
  `optiontype` text NOT NULL,
  `qtyminimum` int(10) NOT NULL,
  `qtymaximum` int(10) NOT NULL,
  `order` int(1) NOT NULL DEFAULT '0',
  `hidden` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `productid` (`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblproductconfigoptionssub`
--

CREATE TABLE IF NOT EXISTS `tblproductconfigoptionssub` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `configid` int(10) NOT NULL,
  `optionname` text NOT NULL,
  `sortorder` int(10) NOT NULL DEFAULT '0',
  `hidden` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `configid` (`configid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblproductgroups`
--

CREATE TABLE IF NOT EXISTS `tblproductgroups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `disabledgateways` text NOT NULL,
  `hidden` text NOT NULL,
  `order` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order` (`order`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tblproductgroups`
--

INSERT INTO `tblproductgroups` (`id`, `name`, `disabledgateways`, `hidden`, `order`) VALUES
(1, 'sed consequat auctor,', '', '', 0),
(2, 'tincidunt. Donec vitae', '', '', 0),
(3, 'elit, dictum eu,', '', '', 0),
(4, 'Lorem ipsum dolor', '', '', 0),
(5, 'Maecenas iaculis aliquet', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblproducts`
--

CREATE TABLE IF NOT EXISTS `tblproducts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  `gid` int(10) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `hidden` text NOT NULL,
  `showdomainoptions` text NOT NULL,
  `welcomeemail` int(1) NOT NULL DEFAULT '0',
  `stockcontrol` text NOT NULL,
  `qty` int(1) NOT NULL DEFAULT '0',
  `proratabilling` text NOT NULL,
  `proratadate` int(2) NOT NULL,
  `proratachargenextmonth` int(2) NOT NULL,
  `paytype` text NOT NULL,
  `allowqty` int(1) NOT NULL,
  `subdomain` text NOT NULL,
  `autosetup` text NOT NULL,
  `servertype` text NOT NULL,
  `servergroup` int(10) NOT NULL,
  `configoption1` text NOT NULL,
  `configoption2` text NOT NULL,
  `configoption3` text NOT NULL,
  `configoption4` text NOT NULL,
  `configoption5` text NOT NULL,
  `configoption6` text NOT NULL,
  `configoption7` text NOT NULL,
  `configoption8` text NOT NULL,
  `configoption9` text NOT NULL,
  `configoption10` text NOT NULL,
  `configoption11` text NOT NULL,
  `configoption12` text NOT NULL,
  `configoption13` text NOT NULL,
  `configoption14` text NOT NULL,
  `configoption15` text NOT NULL,
  `configoption16` text NOT NULL,
  `configoption17` text NOT NULL,
  `configoption18` text NOT NULL,
  `configoption19` text NOT NULL,
  `configoption20` text NOT NULL,
  `configoption21` text NOT NULL,
  `configoption22` text NOT NULL,
  `configoption23` text NOT NULL,
  `configoption24` text NOT NULL,
  `freedomain` text NOT NULL,
  `freedomainpaymentterms` text NOT NULL,
  `freedomaintlds` text NOT NULL,
  `recurringcycles` int(2) NOT NULL,
  `autoterminatedays` int(4) NOT NULL,
  `autoterminateemail` text NOT NULL,
  `upgradepackages` text NOT NULL,
  `configoptionsupgrade` text NOT NULL,
  `billingcycleupgrade` text NOT NULL,
  `upgradeemail` text NOT NULL,
  `overagesenabled` int(1) NOT NULL,
  `overagesdisklimit` int(10) NOT NULL,
  `overagesbwlimit` int(10) NOT NULL,
  `overagesdiskprice` decimal(6,4) NOT NULL,
  `overagesbwprice` decimal(6,4) NOT NULL,
  `tax` int(1) NOT NULL,
  `affiliateonetime` text NOT NULL,
  `affiliatepaytype` text NOT NULL,
  `affiliatepayamount` decimal(10,2) NOT NULL,
  `downloads` text NOT NULL,
  `order` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gid` (`gid`),
  KEY `name` (`name`(64))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `tblproducts`
--

INSERT INTO `tblproducts` (`id`, `type`, `gid`, `name`, `description`, `hidden`, `showdomainoptions`, `welcomeemail`, `stockcontrol`, `qty`, `proratabilling`, `proratadate`, `proratachargenextmonth`, `paytype`, `allowqty`, `subdomain`, `autosetup`, `servertype`, `servergroup`, `configoption1`, `configoption2`, `configoption3`, `configoption4`, `configoption5`, `configoption6`, `configoption7`, `configoption8`, `configoption9`, `configoption10`, `configoption11`, `configoption12`, `configoption13`, `configoption14`, `configoption15`, `configoption16`, `configoption17`, `configoption18`, `configoption19`, `configoption20`, `configoption21`, `configoption22`, `configoption23`, `configoption24`, `freedomain`, `freedomainpaymentterms`, `freedomaintlds`, `recurringcycles`, `autoterminatedays`, `autoterminateemail`, `upgradepackages`, `configoptionsupgrade`, `billingcycleupgrade`, `upgradeemail`, `overagesenabled`, `overagesdisklimit`, `overagesbwlimit`, `overagesdiskprice`, `overagesbwprice`, `tax`, `affiliateonetime`, `affiliatepaytype`, `affiliatepayamount`, `downloads`, `order`) VALUES
(1, 'other', 2, 'Maecenas iaculis', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(2, 'other', 1, 'dictum', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(3, 'other', 4, 'lacus, varius', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(4, 'other', 1, 'Suspendisse aliquet,', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(5, 'other', 1, 'at pretium', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(6, 'other', 3, 'velit. Sed', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(7, 'other', 5, 'condimentum', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(8, 'other', 4, 'eget', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(9, 'other', 2, 'ligula. Aenean', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(10, 'other', 3, 'Suspendisse', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(11, 'other', 4, 'sed, facilisis', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(12, 'other', 1, 'Mauris blandit', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(13, 'other', 2, 'nec tempus', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(14, 'other', 1, 'hendrerit id,', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(15, 'other', 2, 'sagittis. Duis', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(16, 'other', 5, 'tincidunt', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(17, 'other', 2, 'ut', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(18, 'other', 3, 'amet, risus.', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(19, 'other', 4, 'luctus', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0),
(20, 'other', 5, 'nunc, ullamcorper', '', '', '', 0, '', 0, '', 0, 0, '', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', 0, 0, 0, '0.0000', '0.0000', 0, '', '', '0.00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblpromotions`
--

CREATE TABLE IF NOT EXISTS `tblpromotions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` text NOT NULL,
  `type` text NOT NULL,
  `recurring` int(1) DEFAULT NULL,
  `value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cycles` text NOT NULL,
  `appliesto` text NOT NULL,
  `requires` text NOT NULL,
  `requiresexisting` int(1) NOT NULL,
  `startdate` date NOT NULL,
  `expirationdate` date DEFAULT NULL,
  `maxuses` int(10) NOT NULL DEFAULT '0',
  `uses` int(10) NOT NULL DEFAULT '0',
  `applyonce` int(1) NOT NULL,
  `newsignups` int(1) NOT NULL,
  `existingclient` int(11) NOT NULL,
  `onceperclient` int(11) NOT NULL,
  `recurfor` int(3) NOT NULL,
  `upgrades` int(1) NOT NULL,
  `upgradeconfig` text NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`(32))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblquoteitems`
--

CREATE TABLE IF NOT EXISTS `tblquoteitems` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `quoteid` int(10) NOT NULL,
  `description` text NOT NULL,
  `quantity` text NOT NULL,
  `unitprice` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `taxable` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblquotes`
--

CREATE TABLE IF NOT EXISTS `tblquotes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `subject` text NOT NULL,
  `stage` enum('Draft','Delivered','On Hold','Accepted','Lost','Dead') NOT NULL,
  `validuntil` date NOT NULL,
  `userid` int(10) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `companyname` text NOT NULL,
  `email` text NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `postcode` text NOT NULL,
  `country` text NOT NULL,
  `phonenumber` text NOT NULL,
  `currency` int(10) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax1` decimal(10,2) NOT NULL,
  `tax2` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `proposal` text NOT NULL,
  `customernotes` text NOT NULL,
  `adminnotes` text NOT NULL,
  `datecreated` date NOT NULL,
  `lastmodified` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblregistrars`
--

CREATE TABLE IF NOT EXISTS `tblregistrars` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `registrar` text NOT NULL,
  `setting` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `registrar_setting` (`registrar`(32),`setting`(32))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblservergroups`
--

CREATE TABLE IF NOT EXISTS `tblservergroups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `filltype` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblservergroupsrel`
--

CREATE TABLE IF NOT EXISTS `tblservergroupsrel` (
  `groupid` int(10) NOT NULL,
  `serverid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblservers`
--

CREATE TABLE IF NOT EXISTS `tblservers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `ipaddress` text NOT NULL,
  `assignedips` text NOT NULL,
  `hostname` text NOT NULL,
  `monthlycost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `noc` text NOT NULL,
  `statusaddress` text NOT NULL,
  `nameserver1` text NOT NULL,
  `nameserver1ip` text NOT NULL,
  `nameserver2` text NOT NULL,
  `nameserver2ip` text NOT NULL,
  `nameserver3` text NOT NULL,
  `nameserver3ip` text NOT NULL,
  `nameserver4` text NOT NULL,
  `nameserver4ip` text NOT NULL,
  `nameserver5` text NOT NULL,
  `nameserver5ip` text NOT NULL,
  `maxaccounts` int(10) NOT NULL DEFAULT '0',
  `type` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `accesshash` text NOT NULL,
  `secure` text NOT NULL,
  `active` int(1) NOT NULL,
  `disabled` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblsslorders`
--

CREATE TABLE IF NOT EXISTS `tblsslorders` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `serviceid` int(10) NOT NULL,
  `remoteid` text NOT NULL,
  `module` text NOT NULL,
  `certtype` text NOT NULL,
  `configdata` text NOT NULL,
  `completiondate` datetime NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbltax`
--

CREATE TABLE IF NOT EXISTS `tbltax` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `level` int(1) NOT NULL,
  `name` text NOT NULL,
  `state` text NOT NULL,
  `country` text NOT NULL,
  `taxrate` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `state_country` (`state`(32),`country`(2))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblticketbreaklines`
--

CREATE TABLE IF NOT EXISTS `tblticketbreaklines` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `breakline` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tblticketbreaklines`
--

INSERT INTO `tblticketbreaklines` (`id`, `breakline`) VALUES
(1, '> -----Original Message-----'),
(2, '----- Original Message -----'),
(3, '-----Original Message-----'),
(4, '<!-- Break Line -->'),
(5, '====== Please reply above this line ======'),
(6, '_____');

-- --------------------------------------------------------

--
-- Table structure for table `tblticketdepartments`
--

CREATE TABLE IF NOT EXISTS `tblticketdepartments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `email` text NOT NULL,
  `clientsonly` text NOT NULL,
  `piperepliesonly` text NOT NULL,
  `noautoresponder` text NOT NULL,
  `hidden` text NOT NULL,
  `order` int(1) NOT NULL,
  `host` text NOT NULL,
  `port` text NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(64))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblticketescalations`
--

CREATE TABLE IF NOT EXISTS `tblticketescalations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `departments` text NOT NULL,
  `statuses` text NOT NULL,
  `priorities` text NOT NULL,
  `timeelapsed` int(5) NOT NULL,
  `newdepartment` text NOT NULL,
  `newpriority` text NOT NULL,
  `newstatus` text NOT NULL,
  `flagto` text NOT NULL,
  `notify` text NOT NULL,
  `addreply` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblticketlog`
--

CREATE TABLE IF NOT EXISTS `tblticketlog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `tid` int(10) NOT NULL,
  `action` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblticketmaillog`
--

CREATE TABLE IF NOT EXISTS `tblticketmaillog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `to` text NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblticketnotes`
--

CREATE TABLE IF NOT EXISTS `tblticketnotes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ticketid` int(10) NOT NULL,
  `admin` text NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `message` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ticketid_date` (`ticketid`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblticketpredefinedcats`
--

CREATE TABLE IF NOT EXISTS `tblticketpredefinedcats` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parentid` int(10) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parentid_name` (`parentid`,`name`(64))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblticketpredefinedreplies`
--

CREATE TABLE IF NOT EXISTS `tblticketpredefinedreplies` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `catid` int(10) NOT NULL,
  `name` text NOT NULL,
  `reply` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblticketreplies`
--

CREATE TABLE IF NOT EXISTS `tblticketreplies` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tid` int(10) NOT NULL,
  `userid` int(10) NOT NULL,
  `contactid` int(10) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `date` datetime NOT NULL,
  `message` text NOT NULL,
  `admin` text NOT NULL,
  `attachment` text NOT NULL,
  `rating` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tid_date` (`tid`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbltickets`
--

CREATE TABLE IF NOT EXISTS `tbltickets` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tid` int(6) NOT NULL DEFAULT '0',
  `did` int(10) NOT NULL,
  `userid` int(10) NOT NULL,
  `contactid` int(10) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `cc` text NOT NULL,
  `c` text NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `title` text NOT NULL,
  `message` text NOT NULL,
  `status` text NOT NULL,
  `urgency` text NOT NULL,
  `admin` text NOT NULL,
  `attachment` text NOT NULL,
  `lastreply` datetime NOT NULL,
  `flag` int(1) NOT NULL,
  `clientunread` int(1) NOT NULL,
  `adminunread` text NOT NULL,
  `replyingadmin` int(1) NOT NULL,
  `replyingtime` datetime NOT NULL,
  `service` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tid_c` (`tid`,`c`(64)),
  KEY `userid` (`userid`),
  KEY `status` (`status`(10)),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblticketspamfilters`
--

CREATE TABLE IF NOT EXISTS `tblticketspamfilters` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` enum('sender','subject','phrase') NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblticketstatuses`
--

CREATE TABLE IF NOT EXISTS `tblticketstatuses` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `color` text NOT NULL,
  `sortorder` int(2) NOT NULL,
  `showactive` int(1) NOT NULL,
  `showawaiting` int(1) NOT NULL,
  `autoclose` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tblticketstatuses`
--

INSERT INTO `tblticketstatuses` (`id`, `title`, `color`, `sortorder`, `showactive`, `showawaiting`, `autoclose`) VALUES
(1, 'Open', '#779500', 1, 1, 1, 0),
(2, 'Answered', '#000000', 2, 1, 0, 1),
(3, 'Customer-Reply', '#ff6600', 3, 1, 1, 1),
(4, 'Closed', '#888888', 10, 0, 0, 0),
(5, 'On Hold', '#224488', 5, 1, 0, 0),
(6, 'In Progress', '#cc0000', 6, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbltodolist`
--

CREATE TABLE IF NOT EXISTS `tbltodolist` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `admin` int(10) NOT NULL DEFAULT '0',
  `status` text NOT NULL,
  `duedate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `duedate` (`duedate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblupgrades`
--

CREATE TABLE IF NOT EXISTS `tblupgrades` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `orderid` int(10) NOT NULL,
  `type` text NOT NULL,
  `date` date NOT NULL,
  `relid` int(10) NOT NULL,
  `originalvalue` text NOT NULL,
  `newvalue` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `recurringchange` decimal(10,2) NOT NULL,
  `status` enum('Pending','Completed') NOT NULL DEFAULT 'Pending',
  `paid` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `orderid` (`orderid`),
  KEY `serviceid` (`relid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblwhoislog`
--

CREATE TABLE IF NOT EXISTS `tblwhoislog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `domain` text NOT NULL,
  `ip` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
