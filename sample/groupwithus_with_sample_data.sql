-- phpMyAdmin SQL Dump
-- version 2.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 06, 2012 at 12:07 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `groupwithus`
--

-- --------------------------------------------------------

--
-- Table structure for table `affiliates`
--

DROP TABLE IF EXISTS `affiliates`;
CREATE TABLE IF NOT EXISTS `affiliates` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `class` varchar(255) collate utf8_unicode_ci NOT NULL,
  `foreign_id` bigint(20) unsigned NOT NULL,
  `affiliate_type_id` bigint(20) unsigned NOT NULL,
  `affliate_user_id` bigint(20) NOT NULL,
  `affiliate_status_id` bigint(20) NOT NULL,
  `commission_amount` double(10,2) NOT NULL,
  `commission_holding_start_date` date default NULL,
  PRIMARY KEY  (`id`),
  KEY `affiliate_type_id` (`affiliate_type_id`),
  KEY `affliate_user_id` (`affliate_user_id`),
  KEY `affiliate_status_id` (`affiliate_status_id`),
  KEY `foreign_id` (`foreign_id`),
  KEY `class` (`class`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='affiliate detailes';

--
-- Dumping data for table `affiliates`
--


-- --------------------------------------------------------

--
-- Table structure for table `affiliate_cash_withdrawals`
--

DROP TABLE IF EXISTS `affiliate_cash_withdrawals`;
CREATE TABLE IF NOT EXISTS `affiliate_cash_withdrawals` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `affiliate_cash_withdrawal_status_id` bigint(20) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `commission_amount` double(10,2) default '0.00',
  `payment_gateway_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `affiliate_cash_withdrawal_status_id` (`affiliate_cash_withdrawal_status_id`),
  KEY `payment_gateway_id` (`payment_gateway_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `affiliate_cash_withdrawals`
--


-- --------------------------------------------------------

--
-- Table structure for table `affiliate_cash_withdrawal_statuses`
--

DROP TABLE IF EXISTS `affiliate_cash_withdrawal_statuses`;
CREATE TABLE IF NOT EXISTS `affiliate_cash_withdrawal_statuses` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `affiliate_cash_withdrawal_statuses`
--

INSERT INTO `affiliate_cash_withdrawal_statuses` (`id`, `created`, `modified`, `name`) VALUES
(1, '0000-00-00 00:00:00', '2011-02-15 05:23:16', 'Pending'),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Under Process'),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Rejected'),
(4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Paid'),
(5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Payment Failure');

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_commission_types`
--

DROP TABLE IF EXISTS `affiliate_commission_types`;
CREATE TABLE IF NOT EXISTS `affiliate_commission_types` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `description` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `affiliate_commission_types`
--

INSERT INTO `affiliate_commission_types` (`id`, `name`, `description`) VALUES
(1, '%', 'Percentage'),
(2, '$', 'Amount');

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_requests`
--

DROP TABLE IF EXISTS `affiliate_requests`;
CREATE TABLE IF NOT EXISTS `affiliate_requests` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `site_name` varchar(255) collate utf8_unicode_ci default NULL,
  `site_description` text collate utf8_unicode_ci,
  `site_url` varchar(255) collate utf8_unicode_ci default NULL,
  `site_category_id` bigint(20) default NULL,
  `why_do_you_want_affiliate` text collate utf8_unicode_ci,
  `is_web_site_marketing` tinyint(1) default '0',
  `is_search_engine_marketing` tinyint(1) default '0',
  `is_email_marketing` tinyint(1) default '0',
  `special_promotional_method` varchar(255) collate utf8_unicode_ci default NULL,
  `special_promotional_description` text collate utf8_unicode_ci,
  `is_approved` tinyint(2) default '0',
  PRIMARY KEY  (`id`),
  KEY `site_category_id` (`site_category_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `affiliate_requests`
--


-- --------------------------------------------------------

--
-- Table structure for table `affiliate_statuses`
--

DROP TABLE IF EXISTS `affiliate_statuses`;
CREATE TABLE IF NOT EXISTS `affiliate_statuses` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='affliate status details';

--
-- Dumping data for table `affiliate_statuses`
--

INSERT INTO `affiliate_statuses` (`id`, `created`, `modified`, `name`) VALUES
(1, '2011-02-08 00:00:00', '2011-02-08 00:00:00', 'Pending'),
(2, '2011-02-08 00:00:00', '2011-02-08 00:00:00', 'Canceled '),
(3, '2011-02-08 00:00:00', '2011-02-08 00:00:00', 'Pipeline'),
(4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_types`
--

DROP TABLE IF EXISTS `affiliate_types`;
CREATE TABLE IF NOT EXISTS `affiliate_types` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `model_name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `commission` double(10,2) default '0.00',
  `affiliate_commission_type_id` bigint(20) NOT NULL,
  `is_active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `affiliate_commission_type_id` (`affiliate_commission_type_id`),
  KEY `model_name` (`model_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='affiliate types';

--
-- Dumping data for table `affiliate_types`
--

INSERT INTO `affiliate_types` (`id`, `created`, `modified`, `name`, `model_name`, `commission`, `affiliate_commission_type_id`, `is_active`) VALUES
(1, '2011-02-08 00:00:00', '2011-08-12 13:08:07', 'Sign Up', 'User', 0.00, 2, 1),
(2, '2011-02-08 00:00:00', '2011-08-12 13:08:07', 'Purchase', 'Item,ItemUser', 2.00, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_widget_sizes`
--

DROP TABLE IF EXISTS `affiliate_widget_sizes`;
CREATE TABLE IF NOT EXISTS `affiliate_widget_sizes` (
  `id` int(11) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `content` text collate utf8_unicode_ci NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `affiliate_widget_sizes`
--

INSERT INTO `affiliate_widget_sizes` (`id`, `created`, `modified`, `name`, `content`, `width`, `height`) VALUES
(1, '2011-03-28 11:30:33', '2011-03-30 10:03:48', '88x31', '<div class="widget widget1" style="border-color: ##COLOR##">\r\n	<a href="##ITEM_LINK##"  title="##ITEM_TITLE##"><img src="##AD_IMAGE##"></a>\r\n</div>', 88, 31),
(2, '2011-03-28 11:37:40', '2011-03-31 07:58:26', '120x60', '<div class="widget widget2">\r\n	<div id="groupwithusGet" style="color:##COLOR##">##ITEM_HEADING##</div>\r\n	<div id="groupwithusTitle" style="overflow: visible; white-space: nowrap;" title="##ITEM_TITLE##">\r\n		<a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">##ITEM_MAIN_TITLE##</a>\r\n		<div id="groupwithusPoweredBy"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img src="##AD_IMAGE##"></a></div>\r\n	</div>\r\n</div>', 120, 60),
(5, '2011-03-28 12:50:11', '2011-03-31 07:48:03', '234x60', '<div class="widget widget5">\r\n	<div id="groupwithusCity">##ITEM_HEADING##</div>\r\n	<div id="groupwithusTitle" style="overflow: visible;" title="##ITEM_TITLE##"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">##ITEM_MAIN_TITLE##</a></div>\r\n	<div class="clearfix">\r\n		<div id="groupwithusGet" style="##COLOR##"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">Get It!</a></div>\r\n		<div id="groupwithusPoweredBy"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img src=##AD_IMAGE##></a></div>\r\n	</div>\r\n</div>', 234, 60),
(3, '2011-03-28 12:26:37', '2011-03-30 10:49:17', '125x125', '<div class="widget widget3">\r\n	<div id="groupwithusCity" style="background-color:##COLOR##; overflow: visible; white-space: nowrap;" title="">##ITEM_HEADING##</div>\r\n	<div id="groupwithusTitle" style="overflow: visible; white-space: nowrap;" title=""><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">##ITEM_MAIN_TITLE##</a></div>\r\n	<div class="clearfix">\r\n		<div class="groupwithusTag-block">\r\n			<div id="groupwithusTag"><a href="##ITEM_LINK##">##ITEM_PRICE##</a></div>\r\n		</div>\r\n		<div id="groupwithusImage"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img height="42" width="71" src="##ITEM_IMAGE##"/> </a></div>\r\n	</div>\r\n	<div id="groupwithusPoweredBy"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img src=##AD_IMAGE##></a></div>\r\n</div>', 125, 125),
(4, '2011-03-28 12:35:41', '2011-03-31 08:12:05', '180x150', '<div class="widget widget4">\r\n	<div id="groupwithusCity" style="background-color: ##COLOR##;"><p>##ITEM_HEADING##</p></div>\r\n	<div id="groupwithusTitle" style="overflow: visible; white-space: nowrap;" title="##ITEM_TITLE##"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">##ITEM_MAIN_TITLE##</a></div>\r\n	<div class="clearfix">\r\n		<div class="groupwithusTag-block">\r\n			<div id="groupwithusTag"><p>##ITEM_PRICE##</p></div>\r\n			<div id="groupwithusImage"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img height="56" width="93" src="##ITEM_IMAGE##"> </a></div>\r\n		</div>\r\n		<div id="groupwithusGet" style="color: ##COLOR##;"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">Get It!</a></div>\r\n		<div id="groupwithusPoweredBy"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img src=##AD_IMAGE##></a></div>\r\n	</div>\r\n</div>', 180, 150),
(6, '2011-03-28 13:47:05', '2011-03-31 08:31:50', '300x250', '<div class="widget widget6">\r\n	<div class="groupwithusCity" style="color: ##COLOR##">##ITEM_HEADING##</div>\r\n	<div class="groupwithusTitle" style="overflow: visible;" title=##ITEM_TITLE##><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">##ITEM_MAIN_TITLE##</a></div>\r\n	<div class="clearfix">\r\n		<div class="groupwithusTag-block">\r\n			<div class="groupwithusBought"><strong>##ITEM_BOUGHT_COUNT##</strong> Bought</div>\r\n			<div class="groupwithusGet" style="color:  ##COLOR##"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">Get It!</a></div>\r\n		</div>\r\n		<div class="groupwithusImage"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img height="108" width="190" src="##ITEM_IMAGE##"> </a></div>\r\n	</div>\r\n	<div class="clearfix">\r\n		<div class="groupwithusCountdown">\r\n			<div class="groupwithusCountContainer"><span class="countdownText">Time left<br>to buy</span>##TIME_LEFT##</div>\r\n		</div>\r\n		<div class="groupwithusPoweredBy"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img src=##AD_IMAGE##></a></div>\r\n	</div>\r\n</div>', 300, 250),
(7, '2011-03-28 13:56:45', '2011-03-31 08:46:30', '336x280', '<div class="widget widget7">\r\n	<div class="groupwithusCity" style="color: ##COLOR##">##ITEM_HEADING##</div>\r\n	<div class="groupwithusTitle" style="overflow: visible;" title=##ITEM_TITLE##><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">##ITEM_MAIN_TITLE##</a></div>\r\n	<div class="clearfix">\r\n		<div class="groupwithusTag-block">\r\n			<div class="groupwithusBought"><strong>##ITEM_BOUGHT_COUNT##</strong> Bought</div>\r\n			<div class="groupwithusGet" style="color:  ##COLOR##"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">Get It!</a></div>\r\n		</div>\r\n		<div class="groupwithusImage"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img height="129" width="223" src="##ITEM_IMAGE##"> </a></div>\r\n	</div>\r\n	<div class="clearfix">\r\n		<div class="groupwithusCountdown">\r\n			<div class="groupwithusCountContainer"><span class="countdownText">Time left<br>to buy</span>##TIME_LEFT##</div>\r\n		</div>\r\n		<div class="groupwithusPoweredBy"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img src=##AD_IMAGE##></a></div>\r\n	</div>\r\n</div>', 336, 280),
(8, '2011-03-28 14:01:52', '2011-03-31 05:06:58', '468x60', '<div class="widget widget8 clearfix">\r\n	<div class="groupwithusTable-block1">\r\n		<div id="groupwithusGet" style="color: ##COLOR##;"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">Get It!</a></div>\r\n	</div>\r\n	<div class="groupwithusImage"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img height="55" width="93" src="##ITEM_IMAGE##"> </a></div>\r\n	<div class="groupwithusTable-block2">\r\n		<div id="groupwithusCity" style="color: ##COLOR##;">##ITEM_HEADING##</div>\r\n		<div id="groupwithusTitle" style="overflow: visible;" title="##ITEM_TITLE##"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">##ITEM_MAIN_TITLE##</a></div>\r\n		<div id="groupwithusPoweredBy"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img src=##AD_IMAGE##></a></div>\r\n	</div>\r\n</div>', 468, 60),
(9, '2011-03-28 14:10:03', '2011-03-31 05:16:03', '728x90', '<div class="widget widget9 clearfix">\r\n	<div class="groupwithusTable-block1">\r\n		<div class="groupwithusGet" style="color: ##COLOR##"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">Get It!</a></div>\r\n	</div>\r\n	<div class="groupwithusImage"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img height="80" width="137" src="##ITEM_IMAGE##"></a></div>\r\n	<div class="groupwithusTable-block2">\r\n		<div class="groupwithusCity" style="color: ##COLOR##">##ITEM_HEADING##</div>\r\n		<div class="groupwithusTitle" style="overflow: visible;" title=##ITEM_TITLE##><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">##ITEM_MAIN_TITLE##</a></div>\r\n		<div class="groupwithusBought"><strong>##ITEM_BOUGHT_COUNT##</strong> Bought</div>\r\n		<div class="groupwithusCountdown">\r\n			<div class="groupwithusCountContainer"><span class="countdownText">Time left to buy</span>##TIME_LEFT##</div>\r\n		</div>\r\n		<div class="groupwithusPoweredBy"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img src=##AD_IMAGE##></a></div>\r\n	</div>\r\n</div>', 728, 90),
(10, '2011-03-28 14:17:18', '2011-03-30 10:09:49', '120x600', '<div class="widget widget10">\r\n	<div class="groupwithusCity" style="color: ##COLOR##">##ITEM_HEADING##</div>\r\n	<div class="groupwithusTitle" style="overflow: visible;" title=##ITEM_TITLE##><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">##ITEM_MAIN_TITLE##</a></div>\r\n	<div class="groupwithusImage"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img  height="64" width="112" src="##ITEM_IMAGE##"> </a></div>\r\n	<div class="groupwithusBought"><strong>##ITEM_BOUGHT_COUNT##</strong> Bought</div>\r\n	<div class="groupwithusGet" style="color: ##COLOR##"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">Get It!</a></div>\r\n	<div class="groupwithusCountdown">\r\n		<div class="groupwithusCountContainer"><span class="countdownText">Time left<br>to buy</span>##TIME_LEFT##</div>\r\n	</div>\r\n	<div class="groupwithusPoweredBy"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img src=##AD_IMAGE##></a></div>\r\n</div>', 120, 600),
(11, '2011-03-28 14:24:50', '2011-03-30 10:10:04', '160x600', '<div class="widget widget11">\r\n	<div class="groupwithusCity" style="color: ##COLOR##">##ITEM_HEADING##</div>\r\n	<div class="groupwithusTitle" style="overflow: visible;" title=##ITEM_TITLE##><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">##ITEM_MAIN_TITLE##</a></div>\r\n	<div class="groupImage"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img  height="87" width="151" src="##ITEM_IMAGE##"> </a></div>\r\n	<div class="groupwithusBought"><strong></strong> Bought</div>\r\n	<div class="groupwithusGet" style="color: ##COLOR##"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##">Get It!</a></div>\r\n	<div class="groupwithusCountdown">\r\n		<div class="groupwithusCountContainer"><span class="countdownText">Time left<br>to buy</span>##TIME_LEFT##</div>\r\n	</div>\r\n	<div class="groupwithusPoweredBy"><a href="##ITEM_LINK##" target="_blank" title="##ITEM_TITLE##"><img src=##AD_IMAGE##></a></div>\r\n</div>', 160, 600);

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
CREATE TABLE IF NOT EXISTS `attachments` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `class` varchar(100) collate utf8_unicode_ci NOT NULL,
  `foreign_id` bigint(20) unsigned NOT NULL,
  `filename` varchar(255) collate utf8_unicode_ci NOT NULL,
  `dir` varchar(100) collate utf8_unicode_ci NOT NULL,
  `mimetype` varchar(100) collate utf8_unicode_ci default NULL,
  `filesize` bigint(20) default NULL,
  `height` bigint(20) default NULL,
  `width` bigint(20) default NULL,
  `thumb` tinyint(1) default NULL,
  `description` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  KEY `foreign_id` (`foreign_id`),
  KEY `class` (`class`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Attachement Details';

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `created`, `modified`, `class`, `foreign_id`, `filename`, `dir`, `mimetype`, `filesize`, `height`, `width`, `thumb`, `description`) VALUES
(1, '2009-05-11 20:15:24', '2009-05-11 20:15:24', 'UserAvatar', 0, 'default_avatar.jpg', 'UserAvatar/0', 'image/jpeg', 1087, 50, 50, NULL, ''),
(2, '2011-07-30 15:03:38', '2011-07-30 15:03:41', 'Merchant', 0, 'default_img.jpeg', 'Merchant/0', 'image/jpeg', 7118, 225, 225, NULL, NULL),
(3, '2011-08-06 06:50:19', '2011-08-06 06:50:25', 'AffiliateWidgetSize', 0, 'poweredgrouponpro.png', 'AffiliateWidgetSize/0', 'image/png', 570, NULL, NULL, NULL, 'Widget Logo'),
(4, '2011-08-23 11:40:27', '2011-08-23 11:40:27', 'City', 0, 'listing-banner.png', 'City/0', 'image/png', 152658, NULL, NULL, NULL, 'City Image'),
(5, '2011-11-22 10:13:33', '2011-11-22 10:13:33', 'Item', 1, '807_16_128---Pizza_web.jpg', 'Item/1', 'image/jpeg', 93314, 402, 600, NULL, NULL),
(6, '2011-11-22 10:13:34', '2011-11-22 10:13:34', 'Item', 1, 'johns_pizza.jpg', 'Item/1', 'image/jpeg', 175056, 337, 448, NULL, NULL),
(7, '2011-11-22 10:17:03', '2011-11-22 10:17:03', 'Item', 2, '950d7bd17ee8ca842f2c2631a697631f9.jpg', 'Item/2', 'image/jpeg', 47256, 340, 448, NULL, NULL),
(8, '2011-11-22 10:28:33', '2011-11-22 10:28:33', 'Item', 3, '4552183613_73933b2683.jpg', 'Item/3', 'image/jpeg', 125613, 333, 500, NULL, NULL),
(9, '2011-11-22 10:28:34', '2011-11-22 10:28:34', 'Item', 3, '5255348385_c9c7bb400a.jpg', 'Item/3', 'image/jpeg', 151451, 332, 500, NULL, NULL),
(10, '2011-11-22 10:40:32', '2011-11-22 10:40:32', 'Item', 4, 'y lunch in masterdam.JPG', 'Item/4', 'image/jpeg', 29732, 300, 400, NULL, NULL),
(11, '2011-11-22 10:40:32', '2011-11-22 10:40:32', 'Item', 4, '09_22_17---Sunday-Lunch_web.jpg', 'Item/4', 'image/jpeg', 276111, 400, 600, NULL, NULL),
(12, '2011-11-22 10:47:10', '2011-11-22 10:47:10', 'Item', 5, '09_39_3---Chinese-Food_web.jpg', 'Item/5', 'image/jpeg', 178519, 400, 600, NULL, NULL),
(13, '2011-11-22 10:47:11', '2011-11-22 10:47:11', 'Item', 5, '09_22_17---Sunday-Lunch_web 2.jpg', 'Item/5', 'image/jpeg', 276111, 400, 600, NULL, NULL),
(14, '2011-11-22 11:03:17', '2011-11-22 11:03:17', 'Item', 6, '4732855477_d999fd5b5a.jpg', 'Item/6', 'image/jpeg', 153466, 305, 500, NULL, NULL),
(15, '2011-11-22 11:03:19', '2011-11-22 11:03:19', 'Item', 6, '4732208019_a733801da7.jpg', 'Item/6', 'image/jpeg', 136834, 500, 375, NULL, NULL),
(16, '2011-11-22 11:10:57', '2011-11-22 11:10:57', 'UserAvatar', 2, '864c1e9e9c0a37174e7ec479398ae6e2d07.jpg', 'UserAvatar/2', 'image/jpeg', 6747, 164, 160, NULL, NULL),
(17, '2011-11-22 11:18:47', '2011-11-22 11:18:47', 'UserAvatar', 3, 'article-page-main_ehow_images_a06_d7_91_make-cartoon-avatar-photo-800x800.jpg', 'UserAvatar/3', 'image/jpeg', 9260, 220, 225, NULL, NULL),
(18, '2011-11-22 12:41:03', '2011-11-22 12:41:03', 'UserAvatar', 6, '107.jpg', 'UserAvatar/6', 'image/jpeg', 37275, 340, 350, NULL, NULL),
(19, '2011-11-22 12:48:09', '2011-11-22 12:48:09', 'UserAvatar', 7, '7992295f0e53be9e2c23b4ec77323a67dcb 1.jpg', 'UserAvatar/7', 'image/jpeg', 72796, 304, 494, NULL, NULL),
(20, '2012-02-21 07:17:06', '2012-02-21 07:17:06', 'Item', 7, 'images5.jpg', 'Item/7', 'image/jpeg', 7563, 183, 275, NULL, NULL),
(21, '2012-02-21 07:17:06', '2012-02-21 07:17:06', 'Item', 7, 'images4.jpg', 'Item/7', 'image/jpeg', 9690, 185, 272, NULL, NULL),
(24, '2012-02-21 07:21:01', '2012-02-21 07:21:01', 'Item', 8, 'images4.jpg', 'Item/8', 'image/jpeg', 9690, 185, 272, NULL, NULL),
(25, '2012-02-21 07:21:59', '2012-02-21 07:21:59', 'Item', 9, 'images6.jpg', 'Item/9', 'image/jpeg', 8585, 176, 286, NULL, NULL),
(26, '2012-02-21 07:21:59', '2012-02-21 07:21:59', 'Item', 9, 'index2.jpg', 'Item/9', 'image/jpeg', 12199, 172, 292, NULL, NULL),
(27, '2012-02-21 07:21:59', '2012-02-21 07:21:59', 'Item', 9, 'index5.jpg', 'Item/9', 'image/jpeg', 11482, 194, 259, NULL, NULL),
(28, '2012-02-21 07:28:26', '2012-02-21 07:28:26', 'Item', 10, 'd2.jpg', 'Item/10', 'image/jpeg', 6345, 194, 259, NULL, NULL),
(29, '2012-02-21 07:28:26', '2012-02-21 07:28:26', 'Item', 10, 'd1.jpg', 'Item/10', 'image/jpeg', 6532, 194, 259, NULL, NULL),
(30, '2012-02-21 07:28:26', '2012-02-21 07:28:26', 'Item', 10, 'd4.jpg', 'Item/10', 'image/jpeg', 8109, 194, 259, NULL, NULL),
(33, '2012-02-21 07:32:08', '2012-02-21 07:32:08', 'Item', 11, 'd5.jpg', 'Item/11', 'image/jpeg', 5673, 194, 259, NULL, NULL),
(32, '2012-02-21 07:31:12', '2012-02-21 07:31:12', 'Item', 11, 'd4.jpg', 'Item/11', 'image/jpeg', NULL, NULL, NULL, NULL, NULL),
(34, '2012-02-21 08:23:39', '2012-02-21 08:23:39', 'Item', 11, 'id1.jpg', 'Item/11', 'image/jpeg', 10275, 187, 269, NULL, NULL),
(35, '2012-02-21 08:23:39', '2012-02-21 08:23:39', 'Item', 11, 'pa1.jpg', 'Item/11', 'image/jpeg', 11803, 183, 275, NULL, NULL),
(36, '2012-02-21 08:23:39', '2012-02-21 08:23:39', 'Item', 11, 'pu1.jpg', 'Item/11', 'image/jpeg', 7074, 183, 276, NULL, NULL),
(37, '2012-02-21 09:52:57', '2012-02-21 09:52:57', 'Item', 12, 'piz6.jpg', 'Item/12', 'image/jpeg', 9980, 177, 284, NULL, NULL),
(38, '2012-02-21 09:52:58', '2012-02-21 09:52:58', 'Item', 12, 'piz2.jpg', 'Item/12', 'image/jpeg', 12350, 177, 284, NULL, NULL),
(39, '2012-02-21 10:19:00', '2012-02-21 10:19:00', 'Item', 13, 'i5.jpg', 'Item/13', 'image/jpeg', 6606, 183, 275, NULL, NULL),
(40, '2012-02-21 10:19:00', '2012-02-21 10:19:00', 'Item', 13, 'i1.jpg', 'Item/13', 'image/jpeg', 3673, 157, 124, NULL, NULL),
(41, '2012-02-21 12:58:16', '2012-02-21 12:58:16', 'Item', 14, 'i2.jpg', 'Item/14', 'image/jpeg', 12959, 186, 270, NULL, NULL),
(42, '2012-02-23 06:01:46', '2012-02-23 06:01:46', 'Item', 15, 'piz1.jpg', 'Item/15', 'image/jpeg', 10010, 177, 284, NULL, NULL),
(43, '2012-02-23 06:01:47', '2012-02-23 06:01:47', 'Item', 15, 'piz2.jpg', 'Item/15', 'image/jpeg', 12350, 177, 284, NULL, NULL),
(44, '2012-02-23 06:01:47', '2012-02-23 06:01:47', 'Item', 15, 'piz4.jpg', 'Item/15', 'image/jpeg', 13715, 194, 259, NULL, NULL),
(45, '2012-02-23 06:01:48', '2012-02-23 06:01:48', 'Item', 15, 'piz6.jpg', 'Item/15', 'image/jpeg', 9980, 177, 284, NULL, NULL),
(46, '2012-02-23 06:01:48', '2012-02-23 06:01:48', 'Item', 15, 'piz3.jpg', 'Item/15', 'image/jpeg', 13413, 177, 284, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `authorizenet_docapture_logs`
--

DROP TABLE IF EXISTS `authorizenet_docapture_logs`;
CREATE TABLE IF NOT EXISTS `authorizenet_docapture_logs` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `item_user_id` bigint(20) default NULL,
  `transactionid` varchar(255) collate utf8_unicode_ci default NULL,
  `authorize_amt` double(10,2) default NULL,
  `authorize_gateway_feeamt` double(10,2) default NULL,
  `authorize_taxamt` double(10,2) default NULL,
  `authorize_cvv2match` varchar(20) collate utf8_unicode_ci NOT NULL,
  `authorize_avscode` varchar(10) collate utf8_unicode_ci NOT NULL,
  `authorize_authorization_code` varchar(20) collate utf8_unicode_ci NOT NULL,
  `authorize_response_text` varchar(255) collate utf8_unicode_ci NOT NULL,
  `authorize_response` text collate utf8_unicode_ci NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `converted_currency_id` bigint(20) NOT NULL,
  `original_amount` double(10,2) NOT NULL,
  `rate` varchar(100) collate utf8_unicode_ci NOT NULL,
  `payment_status` varchar(20) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `item_user_id` (`item_user_id`),
  KEY `currency_id` (`currency_id`),
  KEY `converted_currency_id` (`converted_currency_id`),
  KEY `transactionid` (`transactionid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `authorizenet_docapture_logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `banned_ips`
--

DROP TABLE IF EXISTS `banned_ips`;
CREATE TABLE IF NOT EXISTS `banned_ips` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `address` varchar(255) collate utf8_unicode_ci NOT NULL,
  `range` varchar(255) collate utf8_unicode_ci NOT NULL,
  `referer_url` varchar(255) collate utf8_unicode_ci NOT NULL,
  `reason` varchar(255) collate utf8_unicode_ci NOT NULL,
  `redirect` varchar(255) collate utf8_unicode_ci NOT NULL,
  `thetime` int(15) NOT NULL,
  `timespan` int(15) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `address` (`address`),
  KEY `range` (`range`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Banned IPs Details';

--
-- Dumping data for table `banned_ips`
--


-- --------------------------------------------------------

--
-- Table structure for table `blocked_users`
--

DROP TABLE IF EXISTS `blocked_users`;
CREATE TABLE IF NOT EXISTS `blocked_users` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `blocked_user_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `blocked_user_id` (`blocked_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Blocked users lists';

--
-- Dumping data for table `blocked_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `cake_sessions`
--

DROP TABLE IF EXISTS `cake_sessions`;
CREATE TABLE IF NOT EXISTS `cake_sessions` (
  `id` varchar(255) collate utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL default '0',
  `data` text collate utf8_unicode_ci,
  `expires` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Cake Session Details';

--
-- Dumping data for table `cake_sessions`
--


-- --------------------------------------------------------

--
-- Table structure for table `charities`
--

DROP TABLE IF EXISTS `charities`;
CREATE TABLE IF NOT EXISTS `charities` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `charity_category_id` bigint(20) NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `slug` varchar(255) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  `url` varchar(255) collate utf8_unicode_ci NOT NULL,
  `paypal_email` varchar(255) collate utf8_unicode_ci NOT NULL,
  `total_amount` double(10,2) default '0.00',
  `total_site_amount` double(10,2) default '0.00',
  `total_seller_amount` double(10,2) default '0.00',
  `available_amount` double(10,2) default '0.00',
  `withdraw_request_amount` double(10,2) default '0.00',
  `paid_amount` double(10,2) default '0.00',
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `charity_category_id` (`charity_category_id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `charities`
--

INSERT INTO `charities` (`id`, `created`, `modified`, `charity_category_id`, `name`, `slug`, `description`, `url`, `paypal_email`, `total_amount`, `total_site_amount`, `total_seller_amount`, `available_amount`, `withdraw_request_amount`, `paid_amount`, `is_active`) VALUES
(1, '2011-11-23 06:36:20', '2011-11-23 06:36:20', 2, 'Agaramm', 'agaramm', 'Agaramm is student welfare organization. Mr.Surya who is actor in tamil industry, he is managing director for this organization.', 'http://www.agaram.com', '', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `charities_item_users`
--

DROP TABLE IF EXISTS `charities_item_users`;
CREATE TABLE IF NOT EXISTS `charities_item_users` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `item_user_id` bigint(20) NOT NULL,
  `charity_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL default '0.00',
  `site_commission_amount` double(10,2) NOT NULL default '0.00',
  `seller_commission_amount` double(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`id`),
  KEY `item_user_id` (`item_user_id`),
  KEY `charity_id` (`charity_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `charities_item_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `charity_cash_withdrawals`
--

DROP TABLE IF EXISTS `charity_cash_withdrawals`;
CREATE TABLE IF NOT EXISTS `charity_cash_withdrawals` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `charity_id` bigint(20) NOT NULL,
  `charity_cash_withdrawal_status_id` bigint(20) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `commission_amount` double(10,2) default '0.00',
  PRIMARY KEY  (`id`),
  KEY `charity_id` (`charity_id`),
  KEY `charity_cash_withdrawal_status_id` (`charity_cash_withdrawal_status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `charity_cash_withdrawals`
--


-- --------------------------------------------------------

--
-- Table structure for table `charity_cash_withdrawal_statuses`
--

DROP TABLE IF EXISTS `charity_cash_withdrawal_statuses`;
CREATE TABLE IF NOT EXISTS `charity_cash_withdrawal_statuses` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `charity_cash_withdrawal_statuses`
--

INSERT INTO `charity_cash_withdrawal_statuses` (`id`, `created`, `modified`, `name`) VALUES
(1, '0000-00-00 00:00:00', '2011-02-15 05:23:16', 'Pending'),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Paid'),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Payment Failure'),
(4, '2011-04-08 20:05:43', '2011-04-08 20:05:43', 'Under Process'),
(5, '2011-04-08 20:05:43', '2011-04-08 20:05:43', 'Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `charity_categories`
--

DROP TABLE IF EXISTS `charity_categories`;
CREATE TABLE IF NOT EXISTS `charity_categories` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `charity_count` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `charity_categories`
--

INSERT INTO `charity_categories` (`id`, `created`, `modified`, `name`, `charity_count`) VALUES
(1, '2011-11-23 06:29:10', '2011-11-23 06:29:10', 'Child Welfare', 0),
(2, '2011-11-23 06:30:18', '2011-11-23 06:30:56', 'Students welfare', 0),
(3, '2011-11-23 06:31:37', '2011-11-23 06:31:37', 'Socail welfare', 0);

-- --------------------------------------------------------

--
-- Table structure for table `charity_money_transfer_accounts`
--

DROP TABLE IF EXISTS `charity_money_transfer_accounts`;
CREATE TABLE IF NOT EXISTS `charity_money_transfer_accounts` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `charity_id` bigint(20) NOT NULL,
  `payment_gateway_id` int(11) NOT NULL,
  `account` varchar(100) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`charity_id`,`payment_gateway_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `charity_money_transfer_accounts`
--


-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `country_id` bigint(20) unsigned NOT NULL,
  `state_id` bigint(20) unsigned NOT NULL,
  `language_id` bigint(20) default NULL,
  `name` varchar(45) collate utf8_unicode_ci NOT NULL,
  `slug` varchar(45) collate utf8_unicode_ci NOT NULL,
  `latitude` float default NULL,
  `longitude` float default NULL,
  `dma_id` int(11) default NULL,
  `county` varchar(25) collate utf8_unicode_ci default NULL,
  `code` varchar(4) collate utf8_unicode_ci default NULL,
  `item_count` bigint(20) unsigned NOT NULL,
  `active_item_count` bigint(20) NOT NULL default '0',
  `is_approved` tinyint(1) NOT NULL default '0',
  `is_enable` tinyint(1) NOT NULL default '0',
  `fb_user_id` bigint(20) default NULL,
  `fb_access_token` varchar(225) collate utf8_unicode_ci default NULL,
  `twitter_username` varchar(225) collate utf8_unicode_ci default NULL,
  `twitter_password` varchar(225) collate utf8_unicode_ci default NULL,
  `twitter_access_token` varchar(255) collate utf8_unicode_ci default NULL,
  `twitter_access_key` varchar(255) collate utf8_unicode_ci default NULL,
  `twitter_url` varchar(225) collate utf8_unicode_ci default NULL,
  `facebook_url` varchar(225) collate utf8_unicode_ci default NULL,
  `facebook_page_id` varchar(225) collate utf8_unicode_ci default NULL,
  `foursquare_venue` bigint(20) default '0',
  PRIMARY KEY  (`id`),
  KEY `country_id` (`country_id`),
  KEY `state_id` (`state_id`),
  KEY `slug` (`slug`),
  KEY `dma_id` (`dma_id`),
  KEY `fb_user_id` (`fb_user_id`),
  KEY `foursquare_venue` (`foursquare_venue`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `created`, `modified`, `country_id`, `state_id`, `language_id`, `name`, `slug`, `latitude`, `longitude`, `dma_id`, `county`, `code`, `item_count`, `active_item_count`, `is_approved`, `is_enable`, `fb_user_id`, `fb_access_token`, `twitter_username`, `twitter_password`, `twitter_access_token`, `twitter_access_key`, `twitter_url`, `facebook_url`, `facebook_page_id`, `foursquare_venue`) VALUES
(42464, '2010-04-16 07:46:56', '2010-07-21 07:34:36', 253, 17, NULL, 'San Diego', 'san-diego', NULL, NULL, NULL, '', '', 0, 14, 1, 1, 0, '', '', '', '', '', '0', '', NULL, 0),
(42549, '2010-07-21 07:33:53', '2010-07-21 07:33:53', 253, 51, NULL, 'Red Oak', 'red-oak', NULL, NULL, NULL, NULL, '', 0, 13, 1, 1, NULL, NULL, '', '', '', '', '', '', NULL, 0),
(42548, '2010-07-21 07:33:20', '2011-08-23 12:44:11', 253, 43, NULL, 'Austin', 'austin', NULL, NULL, NULL, NULL, '', 0, 13, 1, 1, NULL, NULL, '', '', '', '', '', '', NULL, 0),
(42547, '2010-07-21 07:32:20', '2010-07-21 07:32:20', 253, 24, NULL, 'Edge Hill', 'edge-hill', NULL, NULL, NULL, NULL, '', 0, 10, 1, 1, NULL, NULL, '', '', '', '', '', '', NULL, 0),
(42546, '2010-07-21 07:31:45', '2011-08-23 11:03:00', 253, 24, NULL, 'Adel', 'adel', NULL, NULL, NULL, NULL, '', 0, 13, 1, 1, NULL, NULL, '', '', '', '', '', '', NULL, 0),
(42545, '2010-07-21 07:31:22', '2010-07-21 07:31:22', 253, 16, NULL, 'Heber Springs', 'heber-springs', NULL, NULL, NULL, NULL, '', 0, 9, 1, 1, NULL, NULL, '', '', '', '', '', '', NULL, 0),
(42544, '2010-07-21 07:30:55', '2010-07-21 07:30:55', 253, 16, NULL, 'Berryville', 'berryville', NULL, NULL, NULL, NULL, '', 0, 13, 1, 1, NULL, NULL, '', '', '', '', '', '', NULL, 0),
(42543, '2010-07-21 07:30:23', '2010-07-21 07:30:23', 253, 15, NULL, 'Bisbee', 'bisbee', NULL, NULL, NULL, NULL, '', 0, 12, 1, 1, NULL, NULL, '', '', '', '', '', '', NULL, 0),
(42542, '2010-07-21 07:29:48', '2010-07-21 07:29:48', 253, 15, NULL, 'Bullhead City', 'bullhead-city', NULL, NULL, NULL, NULL, '', 0, 12, 1, 1, NULL, NULL, '', '', '', '', '', '', NULL, 0),
(42541, '2010-07-21 07:29:06', '2010-07-21 07:29:06', 253, 15, NULL, 'Coolidge', 'coolidge', NULL, NULL, NULL, NULL, '', 0, 12, 1, 1, NULL, NULL, '', '', '', '', '', '', NULL, 0),
(42550, '2010-07-30 15:04:29', '2010-07-30 15:04:29', 0, 0, NULL, 'Madras', 'madras', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(42551, '2010-07-30 15:20:31', '2010-07-30 15:20:31', 0, 0, NULL, 'chennai', 'chennai', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(42552, '2011-08-19 14:10:07', '2011-08-19 14:10:07', 0, 0, NULL, 'Frankfurt Am Main', 'frankfurt-am-main', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(42553, '2011-08-23 12:22:55', '2011-08-23 12:22:55', 109, 71, 0, 'Trichy', 'trichy', NULL, NULL, NULL, NULL, '', 0, 7, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cities_items`
--

DROP TABLE IF EXISTS `cities_items`;
CREATE TABLE IF NOT EXISTS `cities_items` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `city_id` bigint(20) unsigned NOT NULL,
  `item_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `city_id` (`city_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Map Table for cities and items for Muiltiple City Implementi';

--
-- Dumping data for table `cities_items`
--

INSERT INTO `cities_items` (`id`, `city_id`, `item_id`) VALUES
(1, 42546, 1),
(2, 42548, 1),
(3, 42544, 1),
(4, 42543, 1),
(5, 42542, 1),
(6, 42541, 1),
(7, 42547, 1),
(8, 42549, 1),
(9, 42464, 1),
(10, 42546, 2),
(11, 42548, 2),
(12, 42544, 2),
(13, 42543, 2),
(14, 42542, 2),
(15, 42547, 2),
(16, 42549, 2),
(17, 42464, 2),
(18, 42546, 3),
(19, 42548, 3),
(20, 42544, 3),
(21, 42543, 3),
(22, 42545, 3),
(23, 42549, 3),
(24, 42464, 3),
(25, 42546, 4),
(26, 42548, 4),
(27, 42544, 4),
(28, 42543, 4),
(29, 42541, 4),
(30, 42545, 4),
(31, 42549, 4),
(32, 42464, 4),
(33, 42546, 5),
(34, 42548, 5),
(35, 42544, 5),
(36, 42543, 5),
(37, 42542, 5),
(38, 42541, 5),
(39, 42549, 5),
(40, 42464, 5),
(41, 42546, 6),
(42, 42548, 6),
(43, 42544, 6),
(44, 42542, 6),
(45, 42541, 6),
(46, 42547, 6),
(47, 42464, 6),
(48, 42546, 7),
(49, 42548, 7),
(50, 42544, 7),
(51, 42543, 7),
(52, 42542, 7),
(53, 42541, 7),
(54, 42547, 7),
(55, 42545, 7),
(56, 42549, 7),
(57, 42464, 7),
(58, 42553, 7),
(183, 42553, 8),
(182, 42464, 8),
(181, 42549, 8),
(180, 42545, 8),
(179, 42547, 8),
(178, 42541, 8),
(177, 42542, 8),
(176, 42543, 8),
(175, 42544, 8),
(174, 42548, 8),
(173, 42546, 8),
(102, 42553, 9),
(101, 42464, 9),
(100, 42549, 9),
(99, 42545, 9),
(98, 42547, 9),
(97, 42541, 9),
(96, 42542, 9),
(95, 42543, 9),
(94, 42544, 9),
(93, 42548, 9),
(92, 42546, 9),
(103, 42546, 10),
(104, 42548, 10),
(105, 42544, 10),
(106, 42543, 10),
(107, 42542, 10),
(108, 42541, 10),
(109, 42547, 10),
(110, 42545, 10),
(111, 42549, 10),
(112, 42464, 10),
(194, 42553, 11),
(193, 42464, 11),
(192, 42549, 11),
(191, 42545, 11),
(190, 42547, 11),
(189, 42541, 11),
(188, 42542, 11),
(187, 42543, 11),
(186, 42544, 11),
(185, 42548, 11),
(184, 42546, 11),
(146, 42546, 12),
(147, 42548, 12),
(148, 42544, 12),
(149, 42543, 12),
(150, 42542, 12),
(151, 42541, 12),
(152, 42547, 12),
(153, 42545, 12),
(154, 42549, 12),
(155, 42464, 12),
(156, 42553, 12),
(157, 42542, 13),
(158, 42541, 13),
(159, 42547, 13),
(160, 42545, 13),
(161, 42549, 13),
(162, 42464, 13),
(163, 42553, 13),
(214, 42553, 14),
(213, 42464, 14),
(212, 42549, 14),
(211, 42541, 14),
(210, 42542, 14),
(209, 42543, 14),
(208, 42544, 14),
(207, 42548, 14),
(206, 42546, 14),
(195, 42546, 15),
(196, 42548, 15),
(197, 42544, 15),
(198, 42543, 15),
(199, 42542, 15),
(200, 42541, 15),
(201, 42547, 15),
(202, 42545, 15),
(203, 42549, 15),
(204, 42464, 15),
(205, 42553, 15);

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

DROP TABLE IF EXISTS `colleges`;
CREATE TABLE IF NOT EXISTS `colleges` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(100) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='College details';

--
-- Dumping data for table `colleges`
--


-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(100) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `companies`
--


-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(50) collate utf8_unicode_ci default NULL,
  `fips104` varchar(2) collate utf8_unicode_ci default NULL,
  `iso2` varchar(2) collate utf8_unicode_ci default NULL,
  `iso3` varchar(3) collate utf8_unicode_ci default NULL,
  `ison` varchar(4) collate utf8_unicode_ci default NULL,
  `internet` varchar(2) collate utf8_unicode_ci default NULL,
  `capital` varchar(25) collate utf8_unicode_ci default NULL,
  `map_reference` varchar(50) collate utf8_unicode_ci default NULL,
  `nationality_singular` varchar(35) collate utf8_unicode_ci default NULL,
  `nationality_plural` varchar(35) collate utf8_unicode_ci default NULL,
  `currency` varchar(30) collate utf8_unicode_ci default NULL,
  `currency_code` varchar(3) collate utf8_unicode_ci default NULL,
  `population` bigint(20) default NULL,
  `title` varchar(50) collate utf8_unicode_ci default NULL,
  `comment` text collate utf8_unicode_ci,
  `slug` varchar(50) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `fips104`, `iso2`, `iso3`, `ison`, `internet`, `capital`, `map_reference`, `nationality_singular`, `nationality_plural`, `currency`, `currency_code`, `population`, `title`, `comment`, `slug`) VALUES
(1, 'Afghanistan (افغانستان)', 'AF', 'AF', 'AFG', '4', 'AF', 'Kabul ', 'Asia ', 'Afghan', 'Afghans', 'Afghani ', 'AFA', 26813057, 'Afghanistan', '', 'afghanistan'),
(2, 'Albania (Shqipëria)', 'AL', 'AL', 'ALB', '8', 'AL', 'Tirana ', 'Europe ', 'Albanian', 'Albanians', 'Lek ', 'ALL', 3510484, 'Albania', '', 'albania-shqip-ria'),
(3, 'Algeria (الجزائر)', 'AG', 'DZ', 'DZA', '12', 'DZ', 'Algiers ', 'Africa ', 'Algerian', 'Algerians', 'Algerian Dinar ', 'DZD', 31736053, 'Algeria', '', 'algeria'),
(4, 'American Samoa', 'AQ', 'AS', 'ASM', '16', 'AS', 'Pago Pago ', 'Oceania ', 'American Samoan', 'American Samoans', 'US Dollar', 'USD', 67084, 'American Samoa', '', 'american-samoa'),
(5, 'Andorra', 'AN', 'AD', 'AND', '20', 'AD', 'Andorra la Vella ', 'Europe ', 'Andorran', 'Andorrans', 'Euro', 'EUR', 67627, 'Andorra', '', 'andorra'),
(6, 'Angola', 'AO', 'AO', 'AGO', '24', 'AO', 'Luanda ', 'Africa ', 'Angolan', 'Angolans', 'Kwanza ', 'AOA', 10366031, 'Angola', '', 'angola'),
(7, 'Anguilla', 'AV', 'AI', 'AIA', '660', 'AI', 'The Valley ', 'Central America and the Caribbean ', 'Anguillan', 'Anguillans', 'East Caribbean Dollar ', 'XCD', 12132, 'Anguilla', '', 'anguilla'),
(8, 'Antarctica', 'AY', 'AQ', 'ATA', '10', 'AQ', '', 'Antarctic Region ', '', '', '', '', 0, 'Antarctica', 'ISO defines as the territory south of 60 degrees south latitude', 'antarctica'),
(9, 'Antigua and Barbuda', 'AC', 'AG', 'ATG', '28', 'AG', 'Saint John''s ', 'Central America and the Caribbean ', 'Antiguan and Barbudan', 'Antiguans and Barbudans', 'East Caribbean Dollar ', 'XCD', 66970, 'Antigua and Barbuda', '', 'antigua-and-barbuda'),
(10, 'Argentina', 'AR', 'AR', 'ARG', '32', 'AR', 'Buenos Aires ', 'South America ', 'Argentine', 'Argentines', 'Argentine Peso ', 'ARS', 37384816, 'Argentina', '', 'argentina'),
(11, 'Armenia (Հայաստան)', 'AM', 'AM', 'ARM', '51', 'AM', 'Yerevan ', 'Commonwealth of Independent States ', 'Armenian', 'Armenians', 'Armenian Dram ', 'AMD', 3336100, 'Armenia', '', 'armenia'),
(12, 'Aruba', 'AA', 'AW', 'ABW', '533', 'AW', 'Oranjestad ', 'Central America and the Caribbean ', 'Aruban', 'Arubans', 'Aruban Guilder', 'AWG', 70007, 'Aruba', '', 'aruba'),
(13, 'Ashmore and Cartier', 'AT', '--', '-- ', '--', '--', '', 'Southeast Asia ', '', '', '', '', 0, 'Ashmore and Cartier', 'ISO includes with Australia', 'ashmore-and-cartier'),
(14, 'Australia', 'AS', 'AU', 'AUS', '36', 'AU', 'Canberra ', 'Oceania ', 'Australian', 'Australians', 'Australian dollar ', 'AUD', 19357594, 'Australia', 'ISO includes Ashmore and Cartier Islands,Coral Sea Islands', 'australia'),
(15, 'Austria (Österreich)', 'AU', 'AT', 'AUT', '40', 'AT', 'Vienna ', 'Europe ', 'Austrian', 'Austrians', 'Euro', 'EUR', 8150835, 'Austria', '', 'austria-sterreich'),
(16, 'Azerbaijan (Azərbaycan)', 'AJ', 'AZ', 'AZE', '31', 'AZ', 'Baku (Baki) ', 'Commonwealth of Independent States ', 'Azerbaijani', 'Azerbaijanis', 'Azerbaijani Manat ', 'AZM', 7771092, 'Azerbaijan', '', 'azerbaijan-az-rbaycan'),
(17, 'Bahamas', 'BF', 'BS', 'BHS', '44', 'BS', 'Nassau ', 'Central America and the Caribbean ', 'Bahamian', 'Bahamians', 'Bahamian Dollar ', 'BSD', 297852, 'The Bahamas', '', 'bahamas'),
(18, 'Bahrain (البحرين)', 'BA', 'BH', 'BHR', '48', 'BH', 'Manama ', 'Middle East ', 'Bahraini', 'Bahrainis', 'Bahraini Dinar ', 'BHD', 645361, 'Bahrain', '', 'bahrain'),
(19, 'Baker Island', 'FQ', '--', '-- ', '--', '--', '', 'Oceania ', '', '', '', '', 0, 'Baker Island', 'ISO includes with the US Minor Outlying Islands', 'baker-island'),
(20, 'Bangladesh (বাংলাদেশ)', 'BG', 'BD', 'BGD', '50', 'BD', 'Dhaka ', 'Asia ', 'Bangladeshi', 'Bangladeshis', 'Taka ', 'BDT', 131269860, 'Bangladesh', '', 'bangladesh'),
(21, 'Barbados', 'BB', 'BB', 'BRB', '52', 'BB', 'Bridgetown ', 'Central America and the Caribbean ', 'Barbadian', 'Barbadians', 'Barbados Dollar', 'BBD', 275330, 'Barbados', '', 'barbados'),
(22, 'Bassas da India', 'BS', '--', '-- ', '--', '--', '', 'Africa ', '', '', '', '', 0, 'Bassas da India', 'ISO includes with the Miscellaneous (French) Indian Ocean Islands', 'bassas-da-india'),
(23, 'Belarus (Белару́сь)', 'BO', 'BY', 'BLR', '112', 'BY', 'Minsk ', 'Commonwealth of Independent States ', 'Belarusian', 'Belarusians', 'Belarussian Ruble', 'BYR', 10350194, 'Belarus', '', 'belarus'),
(24, 'Belgium (België)', 'BE', 'BE', 'BEL', '56', 'BE', 'Brussels ', 'Europe ', 'Belgian', 'Belgians', 'Euro', 'EUR', 10258762, 'Belgium', '', 'belgium-belgi'),
(25, 'Belize', 'BH', 'BZ', 'BLZ', '84', 'BZ', 'Belmopan ', 'Central America and the Caribbean ', 'Belizean', 'Belizeans', 'Belize Dollar', 'BZD', 256062, 'Belize', '', 'belize'),
(26, 'Benin (Bénin)', 'BN', 'BJ', 'BEN', '204', 'BJ', 'Porto-Novo  ', 'Africa ', 'Beninese', 'Beninese', 'CFA Franc BCEAO', 'XOF', 6590782, 'Benin', '', 'benin-b-nin'),
(27, 'Bermuda', 'BD', 'BM', 'BMU', '60', 'BM', 'Hamilton ', 'North America ', 'Bermudian', 'Bermudians', 'Bermudian Dollar ', 'BMD', 63503, 'Bermuda', '', 'bermuda'),
(28, 'Bhutan (འབྲུག་ཡུལ)', 'BT', 'BT', 'BTN', '64', 'BT', 'Thimphu ', 'Asia ', 'Bhutanese', 'Bhutanese', 'Ngultrum', 'BTN', 2049412, 'Bhutan', '', 'bhutan'),
(29, 'Bolivia', 'BL', 'BO', 'BOL', '68', 'BO', 'La Paz /Sucre ', 'South America ', 'Bolivian', 'Bolivians', 'Boliviano ', 'BOB', 8300463, 'Bolivia', '', 'bolivia'),
(30, 'Bosnia and Herzegovina (Bosna i Hercegovina)', 'BK', 'BA', 'BIH', '70', 'BA', 'Sarajevo ', 'Bosnia and Herzegovina, Europe ', 'Bosnian and Herzegovinian', 'Bosnians and Herzegovinians', 'Convertible Marka', 'BAM', 3922205, 'Bosnia and Herzegovina', '', 'bosnia-and-herzegovina-bosna-i-hercegovina'),
(31, 'Botswana', 'BC', 'BW', 'BWA', '72', 'BW', 'Gaborone ', 'Africa ', 'Motswana', 'Batswana', 'Pula ', 'BWP', 1586119, 'Botswana', '', 'botswana'),
(32, 'Bouvet Island', 'BV', 'BV', 'BVT', '74', 'BV', '', 'Antarctic Region ', '', '', 'Norwegian Krone ', 'NOK', 0, 'Bouvet Island', '', 'bouvet-island'),
(33, 'Brazil (Brasil)', 'BR', 'BR', 'BRA', '76', 'BR', 'Brasilia ', 'South America ', 'Brazilian', 'Brazilians', 'Brazilian Real ', 'BRL', 174468575, 'Brazil', '', 'brazil-brasil'),
(34, 'British Indian Ocean Territory', 'IO', 'IO', 'IOT', '86', 'IO', '', 'World ', '', '', 'US Dollar', 'USD', 0, 'The British Indian Ocean Territory', '', 'british-indian-ocean-territory'),
(35, 'Brunei (Brunei Darussalam)', 'BX', 'BN', 'BRN', '96', 'BN', '', '', '', '', 'Brunei Dollar', 'BND', 372361, 'Brunei', '', 'brunei-brunei-darussalam'),
(36, 'Bulgaria (България)', 'BU', 'BG', 'BGR', '100', 'BG', 'Sofia ', 'Europe ', 'Bulgarian', 'Bulgarians', 'Lev ', 'BGN', 7707495, 'Bulgaria', '', 'bulgaria'),
(37, 'Burkina Faso', 'UV', 'BF', 'BFA', '854', 'BF', 'Ouagadougou ', 'Africa ', 'Burkinabe', 'Burkinabe', 'CFA Franc BCEAO', 'XOF', 12272289, 'Burkina Faso', '', 'burkina-faso'),
(38, 'Burundi (Uburundi)', 'BY', 'BI', 'BDI', '108', 'BI', 'Bujumbura ', 'Africa ', 'Burundi', 'Burundians', 'Burundi Franc ', 'BIF', 6223897, 'Burundi', '', 'burundi-uburundi'),
(39, 'Cambodia (Kampuchea)', 'CB', 'KH', 'KHM', '116', 'KH', 'Phnom Penh ', 'Southeast Asia ', 'Cambodian', 'Cambodians', 'Riel ', 'KHR', 12491501, 'Cambodia', '', 'cambodia-kampuchea'),
(40, 'Cameroon (Cameroun)', 'CM', 'CM', 'CMR', '120', 'CM', 'Yaounde ', 'Africa ', 'Cameroonian', 'Cameroonians', 'CFA Franc BEAC', 'XAF', 15803220, 'Cameroon', '', 'cameroon-cameroun'),
(41, 'Canada', 'CA', 'CA', 'CAN', '124', 'CA', 'Ottawa ', 'North America ', 'Canadian', 'Canadians', 'Canadian Dollar ', 'CAD', 31592805, 'Canada', '', 'canada'),
(42, 'Cape Verde (Cabo Verde)', 'CV', 'CV', 'CPV', '132', 'CV', 'Praia ', 'World ', 'Cape Verdean', 'Cape Verdeans', 'Cape Verdean Escudo ', 'CVE', 405163, 'Cape Verde', '', 'cape-verde-cabo-verde'),
(43, 'Cayman Islands', 'CJ', 'KY', 'CYM', '136', 'KY', 'George Town ', 'Central America and the Caribbean ', 'Caymanian', 'Caymanians', 'Cayman Islands Dollar', 'KYD', 35527, 'The Cayman Islands', '', 'cayman-islands'),
(44, 'Central African Republic (République Centrafricain', 'CT', 'CF', 'CAF', '140', 'CF', 'Bangui ', 'Africa ', 'Central African', 'Central Africans', 'CFA Franc BEAC', 'XAF', 3576884, 'The Central African Republic', '', 'central-african-republic-r-publique-centrafricain'),
(45, 'Chad (Tchad)', 'CD', 'TD', 'TCD', '148', 'TD', 'N''Djamena ', 'Africa ', 'Chadian', 'Chadians', 'CFA Franc BEAC', 'XAF', 8707078, 'Chad', '', 'chad-tchad'),
(46, 'Chile', 'CI', 'CL', 'CHL', '152', 'CL', 'Santiago ', 'South America ', 'Chilean', 'Chileans', 'Chilean Peso ', 'CLP', 15328467, 'Chile', '', 'chile'),
(47, 'China (中国)', 'CH', 'CN', 'CHN', '156', 'CN', 'Beijing ', 'Asia ', 'Chinese', 'Chinese', 'Yuan Renminbi', 'CNY', 1273111290, 'China', 'see also Taiwan', 'china'),
(48, 'Christmas Island', 'KT', 'CX', 'CXR', '162', 'CX', 'The Settlement ', 'Southeast Asia ', 'Christmas Island', 'Christmas Islanders', 'Australian Dollar ', 'AUD', 2771, 'Christmas Island', '', 'christmas-island'),
(49, 'Clipperton Island', 'IP', '--', '-- ', '--', '--', '', 'World ', '', '', '', '', 0, 'Clipperton Island', 'ISO includes with French Polynesia', 'clipperton-island'),
(50, 'Cocos Islands', 'CK', 'CC', 'CCK', '166', 'CC', 'West Island ', 'Southeast Asia ', 'Cocos Islander', 'Cocos Islanders', 'Australian Dollar ', 'AUD', 633, 'The Cocos Islands', '', 'cocos-islands'),
(51, 'Colombia', 'CO', 'CO', 'COL', '170', 'CO', 'Bogota ', 'South America, Central America and the Caribbean ', 'Colombian', 'Colombians', 'Colombian Peso ', 'COP', 40349388, 'Colombia', '', 'colombia'),
(52, 'Comoros (Comores)', 'CN', 'KM', 'COM', '174', 'KM', 'Moroni ', 'Africa ', 'Comoran', 'Comorans', 'Comoro Franc', 'KMF', 596202, 'Comoros', '', 'comoros-comores'),
(53, 'Congo', 'CF', 'CG', 'COG', '178', 'CG', 'Brazzaville ', 'Africa ', 'Congolese', 'Congolese', 'CFA Franc BEAC', 'XAF', 2894336, 'Republic of the Congo', '', 'congo-1'),
(54, 'Congo, Democratic Republic of the', 'CG', 'CD', 'COD', '180', 'CD', 'Kinshasa ', 'Africa ', 'Congolese', 'Congolese', 'Franc Congolais', 'CDF', 53624718, 'Democratic Republic of the Congo', 'formerly Zaire', 'congo-democratic-republic-of-the'),
(55, 'Cook Islands', 'CW', 'CK', 'COK', '184', 'CK', 'Avarua ', 'Oceania ', 'Cook Islander', 'Cook Islanders', 'New Zealand Dollar ', 'NZD', 20611, 'The Cook Islands', '', 'cook-islands'),
(56, 'Coral Sea Islands', 'CR', '--', '-- ', '--', '--', '', 'Oceania ', '', '', '', '', 0, 'The Coral Sea Islands', 'ISO includes with Australia', 'coral-sea-islands'),
(57, 'Costa Rica', 'CS', 'CR', 'CRI', '188', 'CR', 'San Jose ', 'Central America and the Caribbean ', 'Costa Rican', 'Costa Ricans', 'Costa Rican Colon', 'CRC', 3773057, 'Costa Rica', '', 'costa-rica'),
(58, 'Côte d&#39;Ivoire', 'IV', 'CI', 'CIV', '384', 'CI', 'Yamoussoukro', 'Africa ', 'Ivorian', 'Ivorians', 'CFA Franc BCEAO', 'XOF', 16393221, 'Cote d''Ivoire', '', 'c-te-d-39-ivoire'),
(59, 'Croatia (Hrvatska)', 'HR', 'HR', 'HRV', '191', 'HR', 'Zagreb ', 'Europe ', 'Croatian', 'Croats', 'Kuna', 'HRK', 4334142, 'Croatia', '', 'croatia-hrvatska'),
(60, 'Cuba', 'CU', 'CU', 'CUB', '192', 'CU', 'Havana ', 'Central America and the Caribbean ', 'Cuban', 'Cubans', 'Cuban Peso', 'CUP', 11184023, 'Cuba', '', 'cuba'),
(61, 'Cyprus (Κυπρος)', 'CY', 'CY', 'CYP', '196', 'CY', 'Nicosia ', 'Middle East ', 'Cypriot', 'Cypriots', 'Cyprus Pound', 'CYP', 762887, 'Cyprus', '', 'cyprus'),
(62, 'Czech Republic (Česko)', 'EZ', 'CZ', 'CZE', '203', 'CZ', 'Prague ', 'Europe ', 'Czech', 'Czechs', 'Czech Koruna', 'CZK', 10264212, 'The Czech Republic', '', 'czech-republic-esko'),
(63, 'Denmark (Danmark)', 'DA', 'DK', 'DNK', '208', 'DK', 'Copenhagen ', 'Europe ', 'Danish', 'Danes', 'Danish Krone', 'DKK', 5352815, 'Denmark', '', 'denmark-danmark'),
(64, 'Djibouti', 'DJ', 'DJ', 'DJI', '262', 'DJ', 'Djibouti ', 'Africa ', 'Djiboutian', 'Djiboutians', 'Djibouti Franc', 'DJF', 460700, 'Djibouti', '', 'djibouti'),
(65, 'Dominica', 'DO', 'DM', 'DMA', '212', 'DM', 'Roseau ', 'Central America and the Caribbean ', 'Dominican', 'Dominicans', 'East Caribbean Dollar', 'XCD', 70786, 'Dominica', '', 'dominica'),
(66, 'Dominican Republic', 'DR', 'DO', 'DOM', '214', 'DO', 'Santo Domingo ', 'Central America and the Caribbean ', 'Dominican', 'Dominicans', 'Dominican Peso', 'DOP', 8581477, 'The Dominican Republic', '', 'dominican-republic'),
(67, 'Ecuador', 'EC', 'EC', 'ECU', '218', 'EC', 'Quito ', 'South America ', 'Ecuadorian', 'Ecuadorians', 'US Dollar', 'USD', 13183978, 'Ecuador', '', 'ecuador'),
(68, 'Egypt (مصر)', 'EG', 'EG', 'EGY', '818', 'EG', 'Cairo ', 'Africa ', 'Egyptian', 'Egyptians', 'Egyptian Pound ', 'EGP', 69536644, 'Egypt', '', 'egypt'),
(69, 'El Salvador', 'ES', 'SV', 'SLV', '222', 'SV', 'San Salvador ', 'Central America and the Caribbean ', 'Salvadoran', 'Salvadorans', 'El Salvador Colon', 'SVC', 6237662, 'El Salvador', '', 'el-salvador'),
(70, 'Equatorial Guinea (Guinea Ecuatorial)', 'EK', 'GQ', 'GNQ', '226', 'GQ', 'Malabo ', 'Africa ', 'Equatorial Guinean', 'Equatorial Guineans', 'CFA Franc BEAC', 'XAF', 486060, 'Equatorial Guinea', '', 'equatorial-guinea-guinea-ecuatorial'),
(71, 'Eritrea (Ertra)', 'ER', 'ER', 'ERI', '232', 'ER', 'Asmara ', 'Africa ', 'Eritrean', 'Eritreans', 'Nakfa', 'ERN', 4298269, 'Eritrea', '', 'eritrea-ertra'),
(72, 'Estonia (Eesti)', 'EN', 'EE', 'EST', '233', 'EE', 'Tallinn ', 'Europe ', 'Estonian', 'Estonians', 'Kroon', 'EEK', 1423316, 'Estonia', '', 'estonia-eesti'),
(73, 'Ethiopia (Ityop&#39;iya)', 'ET', 'ET', 'ETH', '231', 'ET', 'Addis Ababa ', 'Africa ', 'Ethiopian', 'Ethiopians', 'Ethiopian Birr', 'ETB', 65891874, 'Ethiopia', '', 'ethiopia-ityop-39-iya'),
(74, 'Europa Island', 'EU', '--', '-- ', '--', '--', '', 'Africa ', '', '', '', '', 0, 'Europa Island', 'ISO includes with the Miscellaneous (French) Indian Ocean Islands', 'europa-island'),
(75, 'Falkland Islands', 'FK', 'FK', 'FLK', '238', 'FK', 'Stanley', 'South America', 'Falkland Island', 'Falkland Islanders', 'Falkland Islands Pound', 'FKP', 2895, 'The Falkland Islands ', '', 'falkland-islands'),
(76, 'Faroe Islands', 'FO', 'FO', 'FRO', '234', 'FO', 'Torshavn ', 'Europe ', 'Faroese', 'Faroese', 'Danish Krone ', 'DKK', 45661, 'The Faroe Islands', '', 'faroe-islands'),
(77, 'Fiji', 'FJ', 'FJ', 'FJI', '242', 'FJ', 'Suva ', 'Oceania ', 'Fijian', 'Fijians', 'Fijian Dollar ', 'FJD', 844330, 'Fiji', '', 'fiji'),
(78, 'Finland (Suomi)', 'FI', 'FI', 'FIN', '246', 'FI', 'Helsinki ', 'Europe ', 'Finnish', 'Finns', 'Euro', 'EUR', 5175783, 'Finland', '', 'finland-suomi'),
(79, 'France', 'FR', 'FR', 'FRA', '250', 'FR', 'Paris ', 'Europe ', 'Frenchman', 'Frenchmen', 'Euro', 'EUR', 59551227, 'France', '', 'france'),
(80, 'France, Metropolitan', '--', '--', '-- ', '--', 'FX', '', '', '', '', 'Euro', 'EUR', 0, 'Metropolitan France', 'ISO limits to the European part of France, excluding French Guiana, French Polynesia, French Southern and Antarctic Lands, Guadeloupe, Martinique, Mayotte, New Caledonia, Reunion, Saint Pierre and Miquelon, Wallis and Futuna', 'france-metropolitan'),
(81, 'French Guiana', 'FG', 'GF', 'GUF', '254', 'GF', 'Cayenne ', 'South America ', 'French Guianese', 'French Guianese', 'Euro', 'EUR', 177562, 'French Guiana', '', 'french-guiana'),
(82, 'French Polynesia', 'FP', 'PF', 'PYF', '258', 'PF', 'Papeete ', 'Oceania ', 'French Polynesian', 'French Polynesians', 'CFP Franc', 'XPF', 253506, 'French Polynesia', 'ISO includes Clipperton Island', 'french-polynesia'),
(83, 'French Southern Territories', 'FS', 'TF', 'ATF', '260', 'TF', '', 'Antarctic Region ', '', '', 'Euro', 'EUR', 0, 'The French Southern and Antarctic Lands', 'FIPS 10-4 does not include the French-claimed portion of Antarctica (Terre Adelie)', 'french-southern-territories'),
(84, 'Gabon', 'GB', 'GA', 'GAB', '266', 'GA', 'Libreville ', 'Africa ', 'Gabonese', 'Gabonese', 'CFA Franc BEAC', 'XAF', 1221175, 'Gabon', '', 'gabon'),
(85, 'Gambia', 'GA', 'GM', 'GMB', '270', 'GM', 'Banjul ', 'Africa ', 'Gambian', 'Gambians', 'Dalasi', 'GMD', 1411205, 'The Gambia', '', 'gambia'),
(86, 'Gaza Strip', 'GZ', '--', '-- ', '--', '--', '', 'Middle East ', '', '', 'New Israeli Shekel ', 'ILS', 1178119, 'The Gaza Strip', '', 'gaza-strip'),
(87, 'Georgia (საქართველო)', 'GG', 'GE', 'GEO', '268', 'GE', 'T''bilisi ', 'Commonwealth of Independent States ', 'Georgian', 'Georgians', 'Lari', 'GEL', 4989285, 'Georgia', '', 'georgia'),
(88, 'Germany (Deutschland)', 'GM', 'DE', 'DEU', '276', 'DE', 'Berlin ', 'Europe ', 'German', 'Germans', 'Euro', 'EUR', 83029536, 'Deutschland', '', 'germany-deutschland'),
(89, 'Ghana', 'GH', 'GH', 'GHA', '288', 'GH', 'Accra ', 'Africa ', 'Ghanaian', 'Ghanaians', 'Cedi', 'GHC', 19894014, 'Ghana', '', 'ghana'),
(90, 'Gibraltar', 'GI', 'GI', 'GIB', '292', 'GI', 'Gibraltar ', 'Europe ', 'Gibraltar', 'Gibraltarians', 'Gibraltar Pound', 'GIP', 27649, 'Gibraltar', '', 'gibraltar'),
(91, 'Glorioso Islands', 'GO', '--', '-- ', '--', '--', '', 'Africa ', '', '', '', '', 0, 'The Glorioso Islands', 'ISO includes with the Miscellaneous (French) Indian Ocean Islands', 'glorioso-islands'),
(92, 'Greece (Ελλάς)', 'GR', 'GR', 'GRC', '300', 'GR', 'Athens ', 'Europe ', 'Greek', 'Greeks', 'Euro', 'EUR', 10623835, 'Greece', '', 'greece'),
(93, 'Greenland', 'GL', 'GL', 'GRL', '304', 'GL', 'Nuuk ', 'Arctic Region ', 'Greenlandic', 'Greenlanders', 'Danish Krone', 'DKK', 56352, 'Greenland', '', 'greenland'),
(94, 'Grenada', 'GJ', 'GD', 'GRD', '308', 'GD', 'Saint George''s ', 'Central America and the Caribbean ', 'Grenadian', 'Grenadians', 'East Caribbean Dollar', 'XCD', 89227, 'Grenada', '', 'grenada'),
(95, 'Guadeloupe', 'GP', 'GP', 'GLP', '312', 'GP', 'Basse-Terre ', 'Central America and the Caribbean ', 'Guadeloupe', 'Guadeloupians', 'Euro', 'EUR', 431170, 'Guadeloupe', '', 'guadeloupe'),
(96, 'Guam', 'GQ', 'GU', 'GUM', '316', 'GU', 'Hagatna', 'Oceania ', 'Guamanian', 'Guamanians', 'US Dollar', 'USD', 157557, 'Guam', '', 'guam'),
(97, 'Guatemala', 'GT', 'GT', 'GTM', '320', 'GT', 'Guatemala ', 'Central America and the Caribbean ', 'Guatemalan', 'Guatemalans', 'Quetzal', 'GTQ', 12974361, 'Guatemala', '', 'guatemala'),
(98, 'Guernsey', 'GK', '--', '-- ', '--', 'GG', 'Saint Peter Port ', 'Europe ', 'Channel Islander', 'Channel Islanders', 'Pound Sterling', 'GBP', 64342, 'Guernsey', 'ISO includes with the United Kingdom', 'guernsey'),
(99, 'Guinea (Guinée)', 'GV', 'GN', 'GIN', '324', 'GN', 'Conakry ', 'Africa ', 'Guinean', 'Guineans', 'Guinean Franc ', 'GNF', 7613870, 'Guinea', '', 'guinea-guin-e'),
(100, 'Guinea-Bissau (Guiné-Bissau)', 'PU', 'GW', 'GNB', '624', 'GW', 'Bissau ', 'Africa ', 'Guinean', 'Guineans', 'CFA Franc BCEAO', 'XOF', 1315822, 'Guinea-Bissau', '', 'guinea-bissau-guin-bissau'),
(101, 'Guyana', 'GY', 'GY', 'GUY', '328', 'GY', 'Georgetown ', 'South America ', 'Guyanese', 'Guyanese', 'Guyana Dollar', 'GYD', 697181, 'Guyana', '', 'guyana'),
(102, 'Haiti (Haïti)', 'HA', 'HT', 'HTI', '332', 'HT', 'Port-au-Prince ', 'Central America and the Caribbean ', 'Haitian', 'Haitians', 'Gourde', 'HTG', 6964549, 'Haiti', '', 'haiti-ha-ti'),
(103, 'Heard Island and McDonald Islands', 'HM', 'HM', 'HMD', '334', 'HM', '', 'Antarctic Region ', '', '', 'Australian Dollar', 'AUD', 0, 'The Heard Island and McDonald Islands', '', 'heard-island-and-mcdonald-islands'),
(104, 'Honduras', 'HO', 'HN', 'HND', '340', 'HN', 'Tegucigalpa ', 'Central America and the Caribbean ', 'Honduran', 'Hondurans', 'Lempira', 'HNL', 6406052, 'Honduras', '', 'honduras'),
(105, 'Hong Kong', 'HK', 'HK', 'HKG', '344', 'HK', '', 'Southeast Asia ', '', '', 'Hong Kong Dollar ', 'HKD', 0, 'Xianggang ', '', 'hong-kong'),
(106, 'Howland Island', 'HQ', '--', '-- ', '--', '--', '', 'Oceania ', '', '', '', '', 7210505, 'Howland Island', 'ISO includes with the US Minor Outlying Islands', 'howland-island'),
(107, 'Hungary (Magyarország)', 'HU', 'HU', 'HUN', '348', 'HU', 'Budapest ', 'Europe ', 'Hungarian', 'Hungarians', 'Forint', 'HUF', 10106017, 'Hungary', '', 'hungary-magyarorsz-g'),
(108, 'Iceland (Ísland)', 'IC', 'IS', 'ISL', '352', 'IS', 'Reykjavik ', 'Arctic Region ', 'Icelandic', 'Icelanders', 'Iceland Krona', 'ISK', 277906, 'Iceland', '', 'iceland-sland'),
(109, 'India', 'IN', 'IN', 'IND', '356', 'IN', 'New Delhi ', 'Asia ', 'Indian', 'Indians', 'Indian Rupee ', 'INR', 1029991145, 'India', '', 'india'),
(110, 'Indonesia', 'ID', 'ID', 'IDN', '360', 'ID', 'Jakarta ', 'Southeast Asia ', 'Indonesian', 'Indonesians', 'Rupiah', 'IDR', 228437870, 'Indonesia', '', 'indonesia'),
(111, 'Iran (ایران)', 'IR', 'IR', 'IRN', '364', 'IR', 'Tehran ', 'Middle East ', 'Iranian', 'Iranians', 'Iranian Rial', 'IRR', 66128965, 'Iran', '', 'iran'),
(112, 'Iraq (العراق)', 'IZ', 'IQ', 'IRQ', '368', 'IQ', 'Baghdad ', 'Middle East ', 'Iraqi', 'Iraqis', 'Iraqi Dinar', 'IQD', 23331985, 'Iraq', '', 'iraq'),
(113, 'Ireland', 'EI', 'IE', 'IRL', '372', 'IE', 'Dublin ', 'Europe ', 'Irish', 'Irishmen', 'Euro', 'EUR', 3840838, 'Ireland', '', 'ireland'),
(114, 'Israel (ישראל)', 'IS', 'IL', 'ISR', '376', 'IL', 'Jerusalem', 'Middle East ', 'Israeli', 'Israelis', 'New Israeli Sheqel', 'ILS', 5938093, 'Israel', '', 'israel'),
(115, 'Italy (Italia)', 'IT', 'IT', 'ITA', '380', 'IT', 'Rome ', 'Europe ', 'Italian', 'Italians', 'Euro', 'EUR', 57679825, 'Italia ', '', 'italy-italia'),
(116, 'Jamaica', 'JM', 'JM', 'JAM', '388', 'JM', 'Kingston ', 'Central America and the Caribbean ', 'Jamaican', 'Jamaicans', 'Jamaican dollar ', 'JMD', 2665636, 'Jamaica', '', 'jamaica'),
(117, 'Jan Mayen', 'JN', '--', '-- ', '--', '--', '', 'Arctic Region ', '', '', 'Norway Kroner', 'NOK', 0, 'Jan Mayen', 'ISO includes with Svalbard', 'jan-mayen'),
(118, 'Japan (日本)', 'JA', 'JP', 'JPN', '392', 'JP', 'Tokyo ', 'Asia ', 'Japanese', 'Japanese', 'Yen ', 'JPY', 126771662, 'Japan', '', 'japan'),
(119, 'Jarvis Island', 'DQ', '--', '-- ', '--', '--', '', 'Oceania ', '', '', '', '', 0, 'Jarvis Island', 'ISO includes with the US Minor Outlying Islands', 'jarvis-island'),
(120, 'Jersey', 'JE', '--', '-- ', '--', 'JE', 'Saint Helier ', 'Europe ', 'Channel Islander', 'Channel Islanders', 'Pound Sterling', 'GBP', 89361, 'Jersey', 'ISO includes with the United Kingdom', 'jersey'),
(121, 'Johnston Atoll', 'JQ', '--', '-- ', '--', '--', '', 'Oceania ', '', '', '', '', 0, 'Johnston Atoll', 'ISO includes with the US Minor Outlying Islands', 'johnston-atoll'),
(122, 'Jordan (الاردن)', 'JO', 'JO', 'JOR', '400', 'JO', 'Amman ', 'Middle East ', 'Jordanian', 'Jordanians', 'Jordanian Dinar', 'JOD', 5153378, 'Jordan', '', 'jordan'),
(123, 'Juan de Nova Island', 'JU', '--', '-- ', '--', '--', '', 'Africa ', '', '', '', '', 0, 'Juan de Nova Island', 'ISO includes with the Miscellaneous (French) Indian Ocean Islands', 'juan-de-nova-island'),
(124, 'Kazakhstan (Қазақстан)', 'KZ', 'KZ', 'KAZ', '398', 'KZ', 'Astana ', 'Commonwealth of Independent States ', 'Kazakhstani', 'Kazakhstanis', 'Tenge', 'KZT', 16731303, 'Kazakhstan', '', 'kazakhstan'),
(125, 'Kenya', 'KE', 'KE', 'KEN', '404', 'KE', 'Nairobi ', 'Africa ', 'Kenyan', 'Kenyans', 'Kenyan shilling ', 'KES', 30765916, 'Kenya', '', 'kenya'),
(126, 'Kingman Reef', 'KQ', '--', '-- ', '--', '--', '', 'Oceania ', '', '', '', '', 0, 'Kingman Reef', 'ISO includes with the US Minor Outlying Islands', 'kingman-reef'),
(127, 'Kiribati', 'KR', 'KI', 'KIR', '296', 'KI', 'Tarawa ', 'Oceania ', 'I-Kiribati', 'I-Kiribati', 'Australian dollar ', 'AUD', 94149, 'Kiribati', '', 'kiribati'),
(128, 'Kuwait (الكويت)', 'KU', 'KW', 'KWT', '414', 'KW', 'Kuwait ', 'Middle East ', 'Kuwaiti', 'Kuwaitis', 'Kuwaiti Dinar', 'KWD', 2041961, 'Al Kuwayt', '', 'kuwait'),
(129, 'Kyrgyzstan (Кыргызстан)', 'KG', 'KG', 'KGZ', '417', 'KG', 'Bishkek ', 'Commonwealth of Independent States ', 'Kyrgyzstani', 'Kyrgyzstanis', 'Som', 'KGS', 4753003, 'Kyrgyzstan', '', 'kyrgyzstan'),
(130, 'Laos (ນລາວ)', 'LA', 'LA', 'LAO', '418', 'LA', 'Vientiane ', 'Southeast Asia ', 'Lao', 'Laos', 'Kip', 'LAK', 5635967, 'Laos', '', 'laos'),
(131, 'Latvia (Latvija)', 'LG', 'LV', 'LVA', '428', 'LV', 'Riga ', 'Europe ', 'Latvian', 'Latvians', 'Latvian Lats', 'LVL', 2385231, 'Latvia', '', 'latvia-latvija'),
(132, 'Lebanon (لبنان)', 'LE', 'LB', 'LBN', '422', 'LB', 'Beirut ', 'Middle East ', 'Lebanese', 'Lebanese', 'Lebanese Pound', 'LBP', 3627774, 'Lebanon', '', 'lebanon'),
(133, 'Lesotho', 'LT', 'LS', 'LSO', '426', 'LS', 'Maseru ', 'Africa ', 'Basotho', 'Mosotho', 'Loti', 'LSL', 2177062, 'Lesotho', '', 'lesotho'),
(134, 'Liberia', 'LI', 'LR', 'LBR', '430', 'LR', 'Monrovia ', 'Africa ', 'Liberian', 'Liberians', 'Liberian Dollar', 'LRD', 3225837, 'Liberia', '', 'liberia'),
(135, 'Libya (ليبيا)', 'LY', 'LY', 'LBY', '434', 'LY', 'Tripoli ', 'Africa ', 'Libyan', 'Libyans', 'Libyan Dinar', 'LYD', 5240599, 'Libya', '', 'libya'),
(136, 'Liechtenstein', 'LS', 'LI', 'LIE', '438', 'LI', 'Vaduz ', 'Europe ', 'Liechtenstein', 'Liechtensteiners', 'Swiss Franc', 'CHF', 32528, 'Liechtenstein', '', 'liechtenstein'),
(137, 'Lithuania (Lietuva)', 'LH', 'LT', 'LTU', '440', 'LT', 'Vilnius ', 'Europe ', 'Lithuanian', 'Lithuanians', 'Lithuanian Litas', 'LTL', 3610535, 'Lithuania', '', 'lithuania-lietuva'),
(138, 'Luxembourg (Lëtzebuerg)', 'LU', 'LU', 'LUX', '442', 'LU', 'Luxembourg ', 'Europe ', 'Luxembourg', 'Luxembourgers', 'Euro', 'EUR', 442972, 'Luxembourg', '', 'luxembourg-l-tzebuerg'),
(139, 'Macao', 'MC', 'MO', 'MAC', '446', 'MO', '', 'Southeast Asia ', 'Chinese', 'Chinese', 'Pataca', 'MOP', 453733, 'Macao', '', 'macao'),
(140, 'Macedonia (Македонија)', 'MK', 'MK', 'MKD', '807', 'MK', 'Skopje ', 'Europe ', 'Macedonian', 'Macedonians', 'Denar', 'MKD', 2046209, 'Makedonija', '', 'macedonia'),
(141, 'Madagascar (Madagasikara)', 'MA', 'MG', 'MDG', '450', 'MG', 'Antananarivo ', 'Africa ', 'Malagasy', 'Malagasy', 'Malagasy Franc', 'MGF', 15982563, 'Madagascar', '', 'madagascar-madagasikara'),
(142, 'Malawi', 'MI', 'MW', 'MWI', '454', 'MW', 'Lilongwe ', 'Africa ', 'Malawian', 'Malawians', 'Kwacha', 'MWK', 10548250, 'Malawi', '', 'malawi'),
(143, 'Malaysia', 'MY', 'MY', 'MYS', '458', 'MY', 'Kuala Lumpur ', 'Southeast Asia ', 'Malaysian', 'Malaysians', 'Malaysian Ringgit', 'MYR', 22229040, 'Malaysia', '', 'malaysia'),
(144, 'Maldives (ގުޖޭއްރާ ޔާއްރިހޫމްޖ)', 'MV', 'MV', 'MDV', '462', 'MV', 'Male ', 'Asia ', 'Maldivian', 'Maldivians', 'Rufiyaa', 'MVR', 310764, 'Maldives', '', 'maldives'),
(145, 'Mali', 'ML', 'ML', 'MLI', '466', 'ML', 'Bamako ', 'Africa ', 'Malian', 'Malians', 'CFA Franc BCEAO', 'XOF', 11008518, 'Mali', '', 'mali'),
(146, 'Malta', 'MT', 'MT', 'MLT', '470', 'MT', 'Valletta ', 'Europe ', 'Maltese', 'Maltese', 'Maltese Lira', 'MTL', 394583, 'Malta', '', 'malta'),
(147, 'Man, Isle of', 'IM', '--', '-- ', '--', 'IM', 'Douglas ', 'Europe ', 'Manxman', 'Manxmen', 'Pound Sterling', 'GBP', 73489, 'The Isle of Man', 'ISO includes with the United Kingdom', 'man-isle-of'),
(148, 'Marshall Islands', 'RM', 'MH', 'MHL', '584', 'MH', 'Majuro ', 'Oceania ', 'Marshallese', 'Marshallese', 'US Dollar', 'USD', 70822, 'The Marshall Islands', '', 'marshall-islands'),
(149, 'Martinique', 'MB', 'MQ', 'MTQ', '474', 'MQ', 'Fort-de-France ', 'Central America and the Caribbean ', 'Martiniquais', 'Martiniquais', 'Euro', 'EUR', 418454, 'Martinique', '', 'martinique'),
(150, 'Mauritania (موريتانيا)', 'MR', 'MR', 'MRT', '478', 'MR', 'Nouakchott ', 'Africa ', 'Mauritanian', 'Mauritanians', 'Ouguiya', 'MRO', 2747312, 'Mauritania', '', 'mauritania'),
(151, 'Mauritius', 'MP', 'MU', 'MUS', '480', 'MU', 'Port Louis ', 'World ', 'Mauritian', 'Mauritians', 'Mauritius Rupee', 'MUR', 1189825, 'Mauritius', '', 'mauritius'),
(152, 'Mayotte', 'MF', 'YT', 'MYT', '175', 'YT', 'Mamoutzou ', 'Africa ', 'Mahorais', 'Mahorais', 'Euro', 'EUR', 163366, 'Mayotte', '', 'mayotte'),
(153, 'Mexico (México)', 'MX', 'MX', 'MEX', '484', 'MX', 'Mexico ', 'North America ', 'Mexican', 'Mexicans', 'Mexican Peso', 'MXN', 101879171, 'Mexico', '', 'mexico-m-xico'),
(154, 'Micronesia', 'FM', 'FM', 'FSM', '583', 'FM', 'Palikir ', 'Oceania ', 'Micronesian', 'Micronesians', 'US Dollar', 'USD', 134597, 'The Federated States of Micronesia', '', 'micronesia'),
(155, 'Midway Islands', 'MQ', '--', '-- ', '--', '--', '', 'Oceania ', '', '', 'United States Dollars', 'USD', 0, 'The Midway Islands', 'ISO includes with the US Minor Outlying Islands', 'midway-islands'),
(156, 'Miscellaneous (French)', '--', '--', '-- ', '--', '--', '', '', '', '', '', '', 0, 'Miscellaneous (French)', 'ISO includes Bassas da India, Europa Island, Glorioso Islands, Juan de Nova Island, Tromelin Island', 'miscellaneous-french'),
(157, 'Moldova', 'MD', 'MD', 'MDA', '498', 'MD', 'Chisinau ', 'Commonwealth of Independent States ', 'Moldovan', 'Moldovans', 'Moldovan Leu', 'MDL', 4431570, 'Moldova', '', 'moldova'),
(158, 'Monaco', 'MN', 'MC', 'MCO', '492', 'MC', 'Monaco ', 'Europe ', 'Monegasque', 'Monegasques', 'Euro', 'EUR', 31842, 'Monaco', '', 'monaco'),
(159, 'Mongolia (Монгол Улс)', 'MG', 'MN', 'MNG', '496', 'MN', 'Ulaanbaatar ', 'Asia ', 'Mongolian', 'Mongolians', 'Tugrik', 'MNT', 2654999, 'Mongolia', '', 'mongolia'),
(160, 'Montenegro', '--', '--', '-- ', '--', '--', '', '', '', '', '', '', 0, 'Montenegro', 'now included as region within Yugoslavia', 'montenegro'),
(161, 'Montserrat', 'MH', 'MS', 'MSR', '500', 'MS', 'Plymouth', 'Central America and the Caribbean ', 'Montserratian', 'Montserratians', 'East Caribbean Dollar', 'XCD', 7574, 'Montserrat', '', 'montserrat'),
(162, 'Morocco (المغرب)', 'MO', 'MA', 'MAR', '504', 'MA', 'Rabat ', 'Africa ', 'Moroccan', 'Moroccans', 'Moroccan Dirham', 'MAD', 30645305, 'Morocco', '', 'morocco'),
(163, 'Mozambique (Moçambique)', 'MZ', 'MZ', 'MOZ', '508', 'MZ', 'Maputo ', 'Africa ', 'Mozambican', 'Mozambicans', 'Metical', 'MZM', 19371057, 'Mozambique', '', 'mozambique-mo-ambique'),
(164, 'Myanmar', '--', '--', '-- ', '--', '--', '', '', '', '', 'Kyat', 'MMK', 0, 'Myanmar', 'see Burma', 'myanmar-1'),
(165, 'Myanmar (Burma)', 'BM', 'MM', 'MMR', '104', 'MM', 'Rangoon ', 'Southeast Asia ', 'Burmese', 'Burmese', 'kyat ', 'MMK', 41994678, 'Burma', 'ISO uses the name Myanmar', 'myanmar-burma'),
(166, 'Namibia', 'WA', 'NA', 'NAM', '516', 'NA', 'Windhoek ', 'Africa ', 'Namibian', 'Namibians', 'Namibian Dollar ', 'NAD', 1797677, 'Namibia', '', 'namibia'),
(167, 'Nauru (Naoero)', 'NR', 'NR', 'NRU', '520', 'NR', '', 'Oceania ', 'Nauruan', 'Nauruans', 'Australian Dollar', 'AUD', 12088, 'Nauru', '', 'nauru-naoero'),
(168, 'Navassa Island', 'BQ', '--', '-- ', '--', '--', '', 'Central America and the Caribbean ', '', '', '', '', 0, 'Navassa Island', '', 'navassa-island'),
(169, 'Nepal (नेपाल)', 'NP', 'NP', 'NPL', '524', 'NP', 'Kathmandu ', 'Asia ', 'Nepalese', 'Nepalese', 'Nepalese Rupee', 'NPR', 25284463, 'Nepal', '', 'nepal'),
(170, 'Netherlands (Nederland)', 'NL', 'NL', 'NLD', '528', 'NL', 'Amsterdam ', 'Europe ', 'Dutchman', 'Dutchmen', 'Euro', 'EUR', 15981472, 'The Netherlands', '', 'netherlands-nederland'),
(171, 'Netherlands Antilles', 'NT', 'AN', 'ANT', '530', 'AN', 'Willemstad ', 'Central America and the Caribbean ', 'Dutch Antillean', 'Dutch Antilleans', 'Netherlands Antillean guilder ', 'ANG', 212226, 'The Netherlands Antilles', '', 'netherlands-antilles'),
(172, 'New Caledonia', 'NC', 'NC', 'NCL', '540', 'NC', 'Noumea ', 'Oceania ', 'New Caledonian', 'New Caledonians', 'CFP Franc', 'XPF', 204863, 'New Caledonia', '', 'new-caledonia'),
(173, 'New Zealand', 'NZ', 'NZ', 'NZL', '554', 'NZ', 'Wellington ', 'Oceania ', 'New Zealand', 'New Zealanders', 'New Zealand Dollar', 'NZD', 3864129, 'New Zealand', '', 'new-zealand'),
(174, 'Nicaragua', 'NU', 'NI', 'NIC', '558', 'NI', 'Managua ', 'Central America and the Caribbean ', 'Nicaraguan', 'Nicaraguans', 'Cordoba Oro', 'NIO', 4918393, 'Nicaragua', '', 'nicaragua'),
(175, 'Niger', 'NG', 'NE', 'NER', '562', 'NE', 'Niamey ', 'Africa ', 'Nigerien', 'Nigeriens', 'CFA Franc BCEAO', 'XOF', 10355156, 'Niger', '', 'niger'),
(176, 'Nigeria', 'NI', 'NG', 'NGA', '566', 'NG', 'Abuja', 'Africa ', 'Nigerian', 'Nigerians', 'Naira', 'NGN', 126635626, 'Nigeria', '', 'nigeria'),
(177, 'Niue', 'NE', 'NU', 'NIU', '570', 'NU', 'Alofi ', 'Oceania ', 'Niuean', 'Niueans', 'New Zealand Dollar', 'NZD', 2124, 'Niue', '', 'niue'),
(178, 'Norfolk Island', 'NF', 'NF', 'NFK', '574', 'NF', 'Kingston ', 'Oceania ', 'Norfolk Islander', 'Norfolk Islanders', 'Australian Dollar', 'AUD', 1879, 'Norfolk Island', '', 'norfolk-island'),
(179, 'North Korea (조선)', 'KN', 'KP', 'PRK', '408', 'KP', 'P''yongyang ', 'Asia ', 'Korean', 'Koreans', 'North Korean Won', 'KPW', 21968228, 'North Korea', '', 'north-korea'),
(180, 'Northern Mariana Islands', 'CQ', 'MP', 'MNP', '580', 'MP', 'Saipan ', 'Oceania ', '', '', 'US Dollar', 'USD', 74612, 'The Northern Mariana Islands', '', 'northern-mariana-islands'),
(181, 'Norway (Norge)', 'NO', 'NO', 'NOR', '578', 'NO', 'Oslo ', 'Europe ', 'Norwegian', 'Norwegians', 'Norwegian Krone', 'NOK', 4503440, 'Norway', '', 'norway-norge'),
(182, 'Oman (عمان)', 'MU', 'OM', 'OMN', '512', 'OM', 'Muscat ', 'Middle East ', 'Omani', 'Omanis', 'Rial Omani', 'OMR', 2622198, 'Oman', '', 'oman'),
(183, 'Pakistan (پاکستان)', 'PK', 'PK', 'PAK', '586', 'PK', 'Islamabad ', 'Asia ', 'Pakistani', 'Pakistanis', 'Pakistan Rupee', 'PKR', 144616639, 'Pakistan', '', 'pakistan'),
(184, 'Palau (Belau)', 'PS', 'PW', 'PLW', '585', 'PW', 'Koror ', 'Oceania ', 'Palauan', 'Palauans', 'US Dollar', 'USD', 19092, 'Palau', '', 'palau-belau'),
(185, 'Palestinian Territories', '--', 'PS', 'PSE', '275', 'PS', '', '', '', '', '', '', 0, 'Palestine', 'NULL', 'palestinian-territories'),
(186, 'Palmyra Atoll', 'LQ', '--', '-- ', '--', '--', '', 'Oceania ', '', '', '', '', 0, 'Palmyra Atoll', 'ISO includes with the US Minor Outlying Islands', 'palmyra-atoll'),
(187, 'Panama (Panamá)', 'PM', 'PA', 'PAN', '591', 'PA', 'Panama ', 'Central America and the Caribbean ', 'Panamanian', 'Panamanians', 'balboa ', 'PAB', 2845647, 'Panama', '', 'panama-panam'),
(188, 'Papua New Guinea', 'PP', 'PG', 'PNG', '598', 'PG', 'Port Moresby ', 'Oceania ', 'Papua New Guinean', 'Papua New Guineans', 'Kina', 'PGK', 5049055, 'Papua New Guinea', '', 'papua-new-guinea'),
(189, 'Paracel Islands', 'PF', '--', '-- ', '--', '--', '', 'Southeast Asia ', '', '', '', '', 0, 'The Paracel Islands', '', 'paracel-islands'),
(190, 'Paraguay', 'PA', 'PY', 'PRY', '600', 'PY', 'Asuncion ', 'South America ', 'Paraguayan', 'Paraguayans', 'Guarani', 'PYG', 5734139, 'Paraguay', '', 'paraguay'),
(191, 'Peru (Perú)', 'PE', 'PE', 'PER', '604', 'PE', 'Lima ', 'South America ', 'Peruvian', 'Peruvians', 'Nuevo Sol', 'PEN', 27483864, 'Peru', '', 'peru-per'),
(192, 'Philippines (Pilipinas)', 'RP', 'PH', 'PHL', '608', 'PH', 'Manila ', 'Southeast Asia ', 'Philippine', 'Filipinos', 'Philippine Peso', 'PHP', 82841518, 'The Philippines', '', 'philippines-pilipinas'),
(193, 'Pitcairn', 'PC', 'PN', 'PCN', '612', 'PN', 'Adamstown ', 'Oceania ', 'Pitcairn Islander', 'Pitcairn Islanders', 'New Zealand Dollar', 'NZD', 47, 'The Pitcairn Islands', '', 'pitcairn'),
(194, 'Poland (Polska)', 'PL', 'PL', 'POL', '616', 'PL', 'Warsaw ', 'Europe ', 'Polish', 'Poles', 'Zloty', 'PLN', 38633912, 'Poland', '', 'poland-polska'),
(195, 'Portugal', 'PO', 'PT', 'PRT', '620', 'PT', 'Lisbon ', 'Europe ', 'Portuguese', 'Portuguese', 'Euro', 'EUR', 10066253, 'Portugal', '', 'portugal'),
(196, 'Puerto Rico', 'RQ', 'PR', 'PRI', '630', 'PR', 'San Juan ', 'Central America and the Caribbean ', 'Puerto Rican', 'Puerto Ricans', 'US Dollar', 'USD', 3937316, 'Puerto Rico', '', 'puerto-rico'),
(197, 'Qatar (قطر)', 'QA', 'QA', 'QAT', '634', 'QA', 'Doha ', 'Middle East ', 'Qatari', 'Qataris', 'Qatari Rial', 'QAR', 769152, 'Qatar', '', 'qatar'),
(198, 'Reunion', 'RE', 'RE', 'REU', '638', 'RE', 'Saint-Denis', 'World', 'Reunionese', 'Reunionese', 'Euro', 'EUR', 732570, 'Réunion', '', 'reunion'),
(199, 'Romania (România)', 'RO', 'RO', 'ROU', '642', 'RO', 'Bucharest ', 'Europe ', 'Romanian', 'Romanians', 'Leu', 'ROL', 22364022, 'Romania', '', 'romania-rom-nia'),
(200, 'Russia (Россия)', 'RS', 'RU', 'RUS', '643', 'RU', 'Moscow ', 'Asia ', 'Russian', 'Russians', 'Russian Ruble', 'RUB', 145470197, 'Russia', '', 'russia'),
(201, 'Rwanda', 'RW', 'RW', 'RWA', '646', 'RW', 'Kigali ', 'Africa ', 'Rwandan', 'Rwandans', 'Rwanda Franc', 'RWF', 7312756, 'Rwanda', '', 'rwanda'),
(202, 'Saint Helena', 'SH', 'SH', 'SHN', '654', 'SH', 'Jamestown ', 'Africa ', 'Saint Helenian', 'Saint Helenians', 'Saint Helenian Pound ', 'SHP', 7266, 'Saint Helena', '', 'saint-helena'),
(203, 'Saint Kitts and Nevis', 'SC', 'KN', 'KNA', '659', 'KN', 'Basseterre ', 'Central America and the Caribbean ', 'Kittitian and Nevisian', 'Kittitians and Nevisians', 'East Caribbean Dollar ', 'XCD', 38756, 'Saint Kitts and Nevis', '', 'saint-kitts-and-nevis'),
(204, 'Saint Lucia', 'ST', 'LC', 'LCA', '662', 'LC', 'Castries ', 'Central America and the Caribbean ', 'Saint Lucian', 'Saint Lucians', 'East Caribbean Dollar ', 'XCD', 158178, 'Saint Lucia', '', 'saint-lucia'),
(205, 'Saint Pierre and Miquelon', 'SB', 'PM', 'SPM', '666', 'PM', 'Saint-Pierre ', 'North America ', 'Frenchman', 'Frenchmen', 'Euro', 'EUR', 6928, 'Saint Pierre and Miquelon', '', 'saint-pierre-and-miquelon'),
(206, 'Saint Vincent and the Grenadines', 'VC', 'VC', 'VCT', '670', 'VC', 'Kingstown ', 'Central America and the Caribbean ', 'Saint Vincentian', 'Saint Vincentians', 'East Caribbean Dollar ', 'XCD', 115942, 'Saint Vincent and the Grenadines', '', 'saint-vincent-and-the-grenadines'),
(207, 'Samoa', 'WS', 'WS', 'WSM', '882', 'WS', 'Apia ', 'Oceania ', 'Samoan', 'Samoans', 'Tala', 'WST', 179058, 'Samoa', 'NULL', 'samoa'),
(208, 'San Marino', 'SM', 'SM', 'SMR', '674', 'SM', 'San Marino ', 'Europe ', 'Sammarinese', 'Sammarinese', 'Euro', 'EUR', 27336, 'San Marino', '', 'san-marino'),
(209, 'São Tomé and Príncipe', 'TP', 'ST', 'STP', '678', 'ST', 'Sao Tome', 'Africa', 'Sao Tomean', 'Sao Tomeans', 'Dobra', 'STD', 165034, 'São Tomé and Príncipe', '', 's-o-tom-and-pr-ncipe'),
(210, 'Saudi Arabia (المملكة العربية السعودية)', 'SA', 'SA', 'SAU', '682', 'SA', 'Riyadh ', 'Middle East ', 'Saudi Arabian ', 'Saudis', 'Saudi Riyal', 'SAR', 22757092, 'Saudi Arabia', '', 'saudi-arabia'),
(211, 'Senegal (Sénégal)', 'SG', 'SN', 'SEN', '686', 'SN', 'Dakar ', 'Africa ', 'Senegalese', 'Senegalese', 'CFA Franc BCEAO', 'XOF', 10284929, 'Senegal', '', 'senegal-s-n-gal'),
(212, 'Serbia', '--', '--', '-- ', '--', '--', '', '', '', '', '', '', 0, 'Serbia', 'now included as region within Yugoslavia', 'serbia'),
(213, 'Serbia and Montenegro', '--', '--', '-- ', '--', '--', '', '', '', '', '', '', 0, 'Serbia and Montenegro', 'See Yugoslavia', 'serbia-and-montenegro'),
(214, 'Seychelles', 'SE', 'SC', 'SYC', '690', 'SC', 'Victoria ', 'Africa ', 'Seychellois', 'Seychellois', 'Seychelles Rupee', 'SCR', 79715, 'Seychelles', '', 'seychelles'),
(215, 'Sierra Leone', 'SL', 'SL', 'SLE', '694', 'SL', 'Freetown ', 'Africa ', 'Sierra Leonean', 'Sierra Leoneans', 'Leone', 'SLL', 5426618, 'Sierra Leone', '', 'sierra-leone'),
(216, 'Singapore (Singapura)', 'SN', 'SG', 'SGP', '702', 'SG', 'Singapore ', 'Southeast Asia ', 'Singaporeian', 'Singaporeans', 'Singapore Dollar', 'SGD', 4300419, 'Singapore', '', 'singapore-singapura'),
(217, 'Slovakia (Slovensko)', 'LO', 'SK', 'SVK', '703', 'SK', 'Bratislava ', 'Europe ', 'Slovakian', 'Slovaks', 'Slovak Koruna', 'SKK', 5414937, 'Slovakia', '', 'slovakia-slovensko'),
(218, 'Slovenia (Slovenija)', 'SI', 'SI', 'SVN', '705', 'SI', 'Ljubljana ', 'Europe ', 'Slovenian', 'Slovenes', 'Euro', 'EUR', 1930132, 'Slovenia', '', 'slovenia-slovenija'),
(219, 'Solomon Islands', 'BP', 'SB', 'SLB', '90', 'SB', 'Honiara ', 'Oceania ', 'Solomon Islander', 'Solomon Islanders', 'Solomon Islands Dollar', 'SBD', 480442, 'The Solomon Islands', '', 'solomon-islands'),
(220, 'Somalia (Soomaaliya)', 'SO', 'SO', 'SOM', '706', 'SO', 'Mogadishu ', 'Africa ', 'Somali', 'Somalis', 'Somali Shilling', 'SOS', 7488773, 'Somalia', '', 'somalia-soomaaliya'),
(221, 'South Africa', 'SF', 'ZA', 'ZAF', '710', 'ZA', 'Pretoria', 'Africa ', 'South African', 'South Africans', 'Rand', 'ZAR', 43586097, 'South Africa', '', 'south-africa'),
(222, 'South Georgia and the South Sandwich Islands', 'SX', 'GS', 'SGS', '239', 'GS', '', 'Antarctic Region ', '', '', 'Pound Sterling', 'GBP', 0, 'The South Georgia and the South Sandwich Islands', '', 'south-georgia-and-the-south-sandwich-islands'),
(223, 'South Korea (한국)', 'KS', 'KR', 'KOR', '410', 'KR', 'Seoul ', 'Asia ', 'Korean', 'Koreans', 'Won', 'KRW', 47904370, 'South Korea', '', 'south-korea'),
(224, 'Spain (España)', 'SP', 'ES', 'ESP', '724', 'ES', 'Madrid ', 'Europe ', 'Spanish', 'Spaniards', 'Euro', 'EUR', 40037995, 'Spain', '', 'spain-espa-a'),
(225, 'Spratly Islands', 'PG', '--', '-- ', '--', '--', '', 'Southeast Asia ', '', '', '', '', 0, 'The Spratly Islands', '', 'spratly-islands'),
(226, 'Sri Lanka', 'CE', 'LK', 'LKA', '144', 'LK', 'Colombo', 'Asia ', 'Sri Lankan', 'Sri Lankans', 'Sri Lanka Rupee', 'LKR', 19408635, 'Sri Lanka', '', 'sri-lanka'),
(227, 'Sudan (السودان)', 'SU', 'SD', 'SDN', '736', 'SD', 'Khartoum ', 'Africa ', 'Sudanese', 'Sudanese', 'Sudanese Dinar', 'SDD', 36080373, 'Sudan', '', 'sudan'),
(228, 'Suriname', 'NS', 'SR', 'SUR', '740', 'SR', 'Paramaribo ', 'South America ', 'Surinamese', 'Surinamers', 'Suriname Guilder', 'SRG', 433998, 'Suriname', '', 'suriname'),
(229, 'Svalbard and Jan Mayen', 'SV', 'SJ', 'SJM', '744', 'SJ', 'Longyearbyen ', 'Arctic Region ', '', '', 'Norwegian Krone', 'NOK', 2332, 'Svalbard', 'ISO includes Jan Mayen', 'svalbard-and-jan-mayen'),
(230, 'Swaziland', 'WZ', 'SZ', 'SWZ', '748', 'SZ', 'Mbabane ', 'Africa ', 'Swazi', 'Swazis', 'Lilangeni', 'SZL', 1104343, 'Swaziland', '', 'swaziland'),
(231, 'Sweden (Sverige)', 'SW', 'SE', 'SWE', '752', 'SE', 'Stockholm ', 'Europe ', 'Swedish', 'Swedes', 'Swedish Krona', 'SEK', 8875053, 'Sweden', '', 'sweden-sverige'),
(232, 'Switzerland (Schweiz)', 'SZ', 'CH', 'CHE', '756', 'CH', 'Bern ', 'Europe ', 'Swiss', 'Swiss', 'Swiss Franc', 'CHF', 7283274, 'Switzerland', '', 'switzerland-schweiz'),
(233, 'Syria (سوريا)', 'SY', 'SY', 'SYR', '760', 'SY', 'Damascus ', 'Middle East ', 'Syrian', 'Syrians', 'Syrian Pound', 'SYP', 16728808, 'Syria', '', 'syria'),
(234, 'Taiwan (台灣)', 'TW', 'TW', 'TWN', '158', 'TW', 'Taipei ', 'Southeast Asia ', 'Taiwanese', 'Taiwanese', 'New Taiwan Dollar', 'TWD', 22370461, 'Taiwan', '', 'taiwan'),
(235, 'Tajikistan (Тоҷикистон)', 'TI', 'TJ', 'TJK', '762', 'TJ', 'Dushanbe ', 'Commonwealth of Independent States ', 'Tajikistani', 'Tajikistanis', 'Somoni', 'TJS', 6578681, 'Tajikistan', '', 'tajikistan'),
(236, 'Tanzania', 'TZ', 'TZ', 'TZA', '834', 'TZ', 'Dar es Salaam', 'Africa ', 'Tanzanian', 'Tanzanians', 'Tanzanian Shilling', 'TZS', 36232074, 'Tanzania', '', 'tanzania'),
(237, 'Thailand (ราชอาณาจักรไทย)', 'TH', 'TH', 'THA', '764', 'TH', 'Bangkok ', 'Southeast Asia ', 'Thai', 'Thai', 'Baht', 'THB', 61797751, 'Thailand', '', 'thailand'),
(238, 'Timor-Leste', 'TT', 'TL', 'TLS', '626', 'TP', '', '', '', '', 'Timor Escudo', 'TPE', 1040880, 'East Timor', 'NULL', 'timor-leste'),
(239, 'Togo', 'TO', 'TG', 'TGO', '768', 'TG', 'Lome ', 'Africa ', 'Togolese', 'Togolese', 'CFA Franc BCEAO', 'XOF', 5153088, 'Togo', '', 'togo'),
(240, 'Tokelau', 'TL', 'TK', 'TKL', '772', 'TK', '', 'Oceania ', 'Tokelauan', 'Tokelauans', 'New Zealand Dollar', 'NZD', 1445, 'Tokelau', '', 'tokelau'),
(241, 'Tonga', 'TN', 'TO', 'TON', '776', 'TO', 'Nuku''alofa ', 'Oceania ', 'Tongan', 'Tongans', 'Pa''anga', 'TOP', 104227, 'Tonga', '', 'tonga'),
(242, 'Trinidad and Tobago', 'TD', 'TT', 'TTO', '780', 'TT', 'Port-of-Spain ', 'Central America and the Caribbean ', 'Trinidadian and Tobagonian', 'Trinidadians and Tobagonians', 'Trinidad and Tobago Dollar', 'TTD', 1169682, 'Trinidad and Tobago', '', 'trinidad-and-tobago'),
(243, 'Tromelin Island', 'TE', '--', '-- ', '--', '--', '', 'Africa ', '', '', '', '', 0, 'Tromelin Island', 'ISO includes with the Miscellaneous (French) Indian Ocean Islands', 'tromelin-island'),
(244, 'Tunisia (تونس)', 'TS', 'TN', 'TUN', '788', 'TN', 'Tunis ', 'Africa ', 'Tunisian', 'Tunisians', 'Tunisian Dinar', 'TND', 9705102, 'Tunisia', '', 'tunisia'),
(245, 'Turkey (Türkiye)', 'TU', 'TR', 'TUR', '792', 'TR', 'Ankara ', 'Middle East ', 'Turkish', 'Turks', 'Turkish Lira', 'TRL', 66493970, 'Turkey', '', 'turkey-t-rkiye'),
(246, 'Turkmenistan (Türkmenistan)', 'TX', 'TM', 'TKM', '795', 'TM', 'Ashgabat ', 'Commonwealth of Independent States ', 'Turkmen', 'Turkmens', 'Manat', 'TMM', 4603244, 'Turkmenistan', '', 'turkmenistan-t-rkmenistan'),
(247, 'Turks and Caicos Islands', 'TK', 'TC', 'TCA', '796', 'TC', 'Cockburn Town ', 'Central America and the Caribbean ', '', '', 'US Dollar', 'USD', 18122, 'The Turks and Caicos Islands', '', 'turks-and-caicos-islands'),
(248, 'Tuvalu', 'TV', 'TV', 'TUV', '798', 'TV', 'Funafuti ', 'Oceania ', 'Tuvaluan', 'Tuvaluans', 'Australian Dollar', 'AUD', 10991, 'Tuvalu', '', 'tuvalu'),
(249, 'Uganda', 'UG', 'UG', 'UGA', '800', 'UG', 'Kampala ', 'Africa ', 'Ugandan', 'Ugandans', 'Uganda Shilling', 'UGX', 23985712, 'Uganda', '', 'uganda'),
(250, 'Ukraine (Україна)', 'UP', 'UA', 'UKR', '804', 'UA', 'Kiev ', 'Commonwealth of Independent States ', 'Ukrainian', 'Ukrainians', 'Hryvnia', 'UAH', 48760474, 'The Ukraine', '', 'ukraine'),
(251, 'United Arab Emirates (الإمارات العربيّة المتّحدة)', 'AE', 'AE', 'ARE', '784', 'AE', 'Abu Dhabi ', 'Middle East ', 'Emirati', 'Emiratis', 'UAE Dirham', 'AED', 2407460, 'The United Arab Emirates', '', 'united-arab-emirates'),
(252, 'United Kingdom', 'UK', 'GB', 'GBR', '826', 'UK', 'London ', 'Europe ', 'British', 'Britons', 'Pound Sterling', 'GBP', 59647790, 'The United Kingdom', 'ISO includes Guernsey, Isle of Man, Jersey', 'united-kingdom'),
(253, 'United States', 'US', 'US', 'USA', '840', 'US', 'Washington, DC ', 'North America ', 'American', 'Americans', 'US Dollar', 'USD', 278058881, 'The United States', '', 'united-states'),
(254, 'United States minor outlying islands', '--', 'UM', 'UMI', '581', 'UM', '', '', '', '', 'US Dollar', 'USD', 0, 'The United States Minor Outlying Islands', 'ISO includes Baker Island, Howland Island, Jarvis Island, Johnston Atoll, Kingman Reef, Midway Islands, Palmyra Atoll, Wake Island', 'united-states-minor-outlying-islands'),
(255, 'Uruguay', 'UY', 'UY', 'URY', '858', 'UY', 'Montevideo ', 'South America ', 'Uruguayan', 'Uruguayans', 'Peso Uruguayo', 'UYU', 3360105, 'Uruguay', '', 'uruguay'),
(256, 'Uzbekistan (O&#39;zbekiston)', 'UZ', 'UZ', 'UZB', '860', 'UZ', 'Tashkent', 'Commonwealth of Independent States ', 'Uzbekistani', 'Uzbekistanis', 'Uzbekistan Sum', 'UZS', 25155064, 'Uzbekistan', '', 'uzbekistan-o-39-zbekiston'),
(257, 'Vanuatu', 'NH', 'VU', 'VUT', '548', 'VU', 'Port-Vila ', 'Oceania ', 'Ni-Vanuatu', 'Ni-Vanuatu', 'Vatu', 'VUV', 192910, 'Vanuatu', '', 'vanuatu'),
(258, 'Vatican City (Città del Vaticano)', 'VT', 'VA', 'VAT', '336', 'VA', 'Vatican City ', 'Europe ', '', '', 'Euro', 'EUR', 890, 'The Vatican City', '', 'vatican-city-citt-del-vaticano'),
(259, 'Venezuela', 'VE', 'VE', 'VEN', '862', 'VE', 'Caracas ', 'South America, Central America and the Caribbean ', 'Venezuelan', 'Venezuelans', 'Bolivar', 'VEB', 23916810, 'Venezuela', '', 'venezuela'),
(260, 'Vietnam (Việt Nam)', 'VM', 'VN', 'VNM', '704', 'VN', 'Hanoi ', 'Southeast Asia ', 'Vietnamese', 'Vietnamese', 'Dong', 'VND', 79939014, 'Vietnam', '', 'vietnam-vi-t-nam'),
(261, 'Virgin Islands (UK)', '--', '--', '-- ', '--', '--', '', '', '', '', 'US Dollar', 'USD', 0, 'Virgin Islands (UK)', 'see British Virgin Islands', 'virgin-islands-uk'),
(262, 'Virgin Islands (US)', '--', '--', '-- ', '--', '--', '', '', '', '', 'US Dollar', 'USD', 0, 'Virgin Islands (US)', 'see Virgin Islands', 'virgin-islands-us'),
(263, 'Virgin Islands, British', 'VI', 'VG', 'VGB', '92', 'VG', 'Road Town ', 'Central America and the Caribbean ', 'British Virgin Islander', 'British Virgin Islanders', 'US Dollar', 'USD', 20812, 'The British Virgin Islands', '', 'virgin-islands-british'),
(264, 'Virgin Islands, U.S.', 'VQ', 'VI', 'VIR', '850', 'VI', 'Charlotte Amalie ', 'Central America and the Caribbean ', 'Virgin Islander', 'Virgin Islanders', 'US Dollar', 'USD', 122211, 'The Virgin Islands', '', 'virgin-islands-u-s'),
(265, 'Wake Island', 'WQ', '--', '-- ', '--', '--', '', 'Oceania ', '', '', 'US Dollar', 'USD', 0, 'Wake Island', 'ISO includes with the US Minor Outlying Islands', 'wake-island'),
(266, 'Wallis and Futuna', 'WF', 'WF', 'WLF', '876', 'WF', 'Mata-Utu', 'Oceania ', 'Wallis and Futuna Islander', 'Wallis and Futuna Islanders', 'CFP Franc', 'XPF', 15435, 'Wallis and Futuna', '', 'wallis-and-futuna'),
(267, 'West Bank', 'WE', '--', '-- ', '--', '--', '', 'Middle East ', '', '', 'New Israeli Shekel ', 'ILS', 2090713, 'The West Bank', '', 'west-bank'),
(268, 'Western Sahara (الصحراء الغربية)', 'WI', 'EH', 'ESH', '732', 'EH', '', 'Africa ', 'Sahrawian', 'Sahrawis', 'Moroccan Dirham', 'MAD', 250559, 'Western Sahara', '', 'western-sahara'),
(269, 'Western Samoa', '--', '--', '-- ', '--', '--', '', '', '', '', 'Tala', 'WST', 0, 'Western Samoa', 'see Samoa', 'western-samoa'),
(270, 'World', '--', '--', '-- ', '--', '--', '', 'World, Time Zones ', '', '', '', '', 1862433264, 'The World', 'NULL', 'world'),
(271, 'Yemen (اليمن)', 'YM', 'YE', 'YEM', '887', 'YE', 'Sanaa ', 'Middle East ', 'Yemeni', 'Yemenis', 'Yemeni Rial', 'YER', 18078035, 'Yemen', '', 'yemen'),
(272, 'Yugoslavia', 'YI', 'YU', 'YUG', '891', 'YU', 'Belgrade ', 'Europe ', 'Serbian', 'Serbs', 'Yugoslavian Dinar ', 'YUM', 10677290, 'Yugoslavia', 'NULL', 'yugoslavia'),
(273, 'Zaire', '--', '--', '-- ', '--', '--', '', '', '', '', '', '', 0, 'Zaire', 'see Democratic Republic of the Congo', 'zaire'),
(274, 'Zambia', 'ZA', 'ZM', 'ZWB', '894', 'ZM', 'Lusaka ', 'Africa ', 'Zambian', 'Zambians', 'Kwacha', 'ZMK', 9770199, 'Zambia', '', 'zambia'),
(275, 'Zimbabwe', 'ZI', 'ZW', 'ZWE', '716', 'ZW', 'Harare ', 'Africa ', 'Zimbabwean', 'Zimbabweans', 'Zimbabwe Dollar', 'ZWD', 11365366, 'Zimbabwe', '', 'zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `code` varchar(10) collate utf8_unicode_ci NOT NULL,
  `symbol` varchar(255) collate utf8_unicode_ci NOT NULL,
  `is_enabled` tinyint(1) NOT NULL,
  `prefix` varchar(10) collate utf8_unicode_ci default NULL,
  `suffix` varchar(10) collate utf8_unicode_ci default NULL,
  `decimals` int(10) default '2',
  `dec_point` varchar(2) collate utf8_unicode_ci default '.',
  `thousands_sep` varchar(2) collate utf8_unicode_ci default ',',
  `locale` varchar(10) collate utf8_unicode_ci default NULL,
  `format_string` varchar(10) collate utf8_unicode_ci default NULL,
  `grouping_algorithm_callback` varchar(255) collate utf8_unicode_ci default NULL,
  `is_use_graphic_symbol` tinyint(1) default NULL,
  `is_paypal_supported` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `created`, `modified`, `name`, `code`, `symbol`, `is_enabled`, `prefix`, `suffix`, `decimals`, `dec_point`, `thousands_sep`, `locale`, `format_string`, `grouping_algorithm_callback`, `is_use_graphic_symbol`, `is_paypal_supported`) VALUES
(2, '2010-08-07 00:00:00', '2010-09-14 02:29:05', 'Euros', 'EUR', '€', 1, '€', 'EUR', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(1, '2010-08-07 00:00:00', '2011-05-04 07:49:32', 'U.S. Dollars', 'USD', '$', 1, '1', 'USD', 2, '.', ',', '', '', '', 0, 1),
(4, '2010-08-07 00:50:27', '2010-09-14 02:28:39', 'Australian Dollars', 'AUD', '$', 1, '1', 'AUD', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(5, '2010-08-07 00:50:51', '2010-09-14 02:28:12', 'British Pounds', 'GBP', '£', 1, '1', 'GBP', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(6, '2010-08-07 00:51:11', '2010-09-14 02:27:53', 'Canadian Dollars', 'CAD', '$', 1, '1', 'CAD', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(7, '2010-08-07 00:51:29', '2010-09-14 02:27:28', 'Czech Koruny', 'CZK', 'Kč', 1, '1', 'CZK', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(8, '2010-08-07 00:51:47', '2010-09-14 02:27:10', 'Danish Kroner', 'DKK', 'kr', 1, '1', 'DKK', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(9, '2010-08-07 00:52:05', '2010-09-14 02:26:46', 'Hong Kong Dollars', 'HKD', 'HK$', 1, '1', 'HKD', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(10, '2010-08-07 00:52:24', '2010-09-14 02:26:28', 'Hungarian Forints', 'HUF', 'Ft', 1, '1', 'HUF', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(11, '2010-08-07 00:52:41', '2010-09-14 02:26:08', 'Israeli New Shekels', 'ILS', '₪', 1, '1', 'ILS', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(12, '2010-08-07 00:53:01', '2010-09-14 02:25:45', 'Japanese Yen', 'JPY', '¥', 1, '1', 'JPY', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(13, '2010-08-07 00:53:16', '2010-09-14 02:25:11', 'Mexican Pesos', 'MXN', '$', 1, '1', 'MXN', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(14, '2010-08-07 00:53:37', '2010-09-14 02:24:52', 'New Zealand Dollars', 'NZD', '$', 1, '1', 'NZD', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(15, '2010-08-07 00:53:53', '2010-09-14 02:24:34', 'Norwegian Kroner', 'NOK', 'kr', 1, '1', 'NOK', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(16, '2010-08-07 00:54:12', '2010-09-14 02:24:16', 'Philippine Pesos', 'PHP', 'Php', 1, '1', 'PHP', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(17, '2010-08-07 00:54:30', '2010-09-14 02:23:56', 'Polish Zlotych', 'PLN', 'zł', 1, '1', 'PLN', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(18, '2010-08-07 00:54:49', '2010-09-14 02:23:36', 'Singapore Dollars', 'SGD', '$', 1, '1', 'SGD', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(19, '2010-08-07 00:55:04', '2010-09-14 02:22:37', 'Swedish Kronor', 'SEK', 'kr', 1, '1', 'SEK', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(20, '2010-08-07 00:55:25', '2010-09-14 02:22:16', 'Swiss Francs', 'CHF', 'CHF', 1, '1', 'CHF', 2, '.', ',', NULL, NULL, NULL, NULL, 1),
(22, '2010-08-07 00:55:54', '2011-05-04 06:16:11', 'Thai Baht', 'THB', '฿', 1, '1', 'THB', 2, '.', ',', '', '', '', 0, 1),
(23, '2010-08-07 00:55:54', '2011-05-11 08:08:09', 'Indian Rupee', 'INR', 'र', 1, '1', 'INR', 2, '.', ',', '', '', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `currency_conversions`
--

DROP TABLE IF EXISTS `currency_conversions`;
CREATE TABLE IF NOT EXISTS `currency_conversions` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `converted_currency_id` bigint(20) NOT NULL,
  `rate` float(10,6) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `currency_id` (`currency_id`),
  KEY `converted_currency_id` (`converted_currency_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currency_conversions`
--

INSERT INTO `currency_conversions` (`id`, `created`, `modified`, `currency_id`, `converted_currency_id`, `rate`) VALUES
(1, '2011-10-10 08:19:52', '2011-10-10 08:19:52', 2, 2, 1.000000),
(2, '2011-10-10 08:19:52', '2011-10-10 08:19:52', 2, 1, 1.340000),
(3, '2011-10-10 08:19:52', '2011-10-10 08:19:52', 2, 4, 1.370000),
(4, '2011-10-10 08:19:52', '2011-10-10 08:19:52', 2, 5, 0.860000),
(5, '2011-10-10 08:19:52', '2011-10-10 08:19:52', 2, 6, 1.390000),
(6, '2011-10-10 08:19:52', '2011-10-10 08:19:52', 2, 7, 24.780001),
(7, '2011-10-10 08:19:52', '2011-10-10 08:19:52', 2, 8, 7.440000),
(8, '2011-10-10 08:19:52', '2011-10-10 08:19:52', 2, 9, 10.460000),
(9, '2011-10-10 08:19:52', '2011-10-10 08:19:52', 2, 10, 296.630005),
(10, '2011-10-10 08:19:52', '2011-10-10 08:19:52', 2, 11, 4.980000),
(11, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 2, 12, 103.019997),
(12, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 2, 13, 18.049999),
(13, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 2, 14, 1.740000),
(14, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 2, 15, 7.800000),
(15, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 2, 16, 58.459999),
(16, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 2, 17, 4.380000),
(17, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 2, 18, 1.740000),
(18, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 2, 19, 9.130000),
(19, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 2, 20, 1.240000),
(20, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 2, 22, 41.540001),
(21, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 2, 23, 66.040001),
(22, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 2, 0.740000),
(23, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 1, 1.000000),
(24, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 4, 1.020000),
(25, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 5, 0.640000),
(26, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 6, 1.040000),
(27, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 7, 18.450001),
(28, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 8, 5.540000),
(29, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 9, 7.780000),
(30, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 10, 220.809998),
(31, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 11, 3.710000),
(32, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 12, 76.690002),
(33, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 13, 13.440000),
(34, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 14, 1.290000),
(35, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 15, 5.810000),
(36, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 16, 43.509998),
(37, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 17, 3.260000),
(38, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 18, 1.290000),
(39, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 19, 6.800000),
(40, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 20, 0.920000),
(41, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 22, 30.920000),
(42, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 1, 23, 49.160000),
(43, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 2, 0.730000),
(44, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 1, 0.980000),
(45, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 4, 1.000000),
(46, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 5, 0.630000),
(47, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 6, 1.010000),
(48, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 7, 18.059999),
(49, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 8, 5.420000),
(50, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 9, 7.620000),
(51, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 10, 216.110001),
(52, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 11, 3.630000),
(53, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 12, 75.050003),
(54, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 13, 13.150000),
(55, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 14, 1.270000),
(56, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 15, 5.680000),
(57, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 16, 42.590000),
(58, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 17, 3.190000),
(59, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 18, 1.270000),
(60, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 19, 6.650000),
(61, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 20, 0.900000),
(62, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 22, 30.260000),
(63, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 4, 23, 48.110001),
(64, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 2, 1.160000),
(65, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 1, 1.550000),
(66, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 4, 1.590000),
(67, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 5, 1.000000),
(68, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 6, 1.610000),
(69, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 7, 28.660000),
(70, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 8, 8.610000),
(71, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 9, 12.090000),
(72, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 10, 343.000000),
(73, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 11, 5.760000),
(74, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 12, 119.129997),
(75, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 13, 20.879999),
(76, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 14, 2.010000),
(77, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 15, 9.020000),
(78, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 16, 67.599998),
(79, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 17, 5.060000),
(80, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 18, 2.010000),
(81, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 19, 10.560000),
(82, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 20, 1.430000),
(83, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 22, 48.029999),
(84, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 5, 23, 76.370003),
(85, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 2, 0.720000),
(86, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 1, 0.970000),
(87, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 4, 0.990000),
(88, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 5, 0.620000),
(89, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 6, 1.000000),
(90, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 7, 17.820000),
(91, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 8, 5.350000),
(92, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 9, 7.520000),
(93, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 10, 213.229996),
(94, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 11, 3.580000),
(95, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 12, 74.059998),
(96, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 13, 12.980000),
(97, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 14, 1.250000),
(98, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 15, 5.610000),
(99, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 16, 42.020000),
(100, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 17, 3.150000),
(101, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 18, 1.250000),
(102, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 19, 6.570000),
(103, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 20, 0.890000),
(104, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 22, 29.860001),
(105, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 6, 23, 47.470001),
(106, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 2, 0.040000),
(107, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 1, 0.050000),
(108, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 4, 0.060000),
(109, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 5, 0.030000),
(110, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 6, 0.060000),
(111, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 7, 1.000000),
(112, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 8, 0.300000),
(113, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 9, 0.420000),
(114, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 10, 11.970000),
(115, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 11, 0.200000),
(116, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 12, 4.160000),
(117, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 13, 0.730000),
(118, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 14, 0.070000),
(119, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 15, 0.310000),
(120, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 16, 2.360000),
(121, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 17, 0.180000),
(122, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 18, 0.070000),
(123, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 19, 0.370000),
(124, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 20, 0.050000),
(125, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 22, 1.680000),
(126, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 7, 23, 2.660000),
(127, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 2, 0.130000),
(128, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 1, 0.180000),
(129, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 4, 0.180000),
(130, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 5, 0.120000),
(131, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 6, 0.190000),
(132, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 7, 3.330000),
(133, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 8, 1.000000),
(134, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 9, 1.400000),
(135, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 10, 39.849998),
(136, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 11, 0.670000),
(137, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 12, 13.840000),
(138, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 13, 2.430000),
(139, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 14, 0.230000),
(140, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 15, 1.050000),
(141, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 16, 7.850000),
(142, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 17, 0.590000),
(143, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 18, 0.230000),
(144, '2011-10-10 08:19:53', '2011-10-10 08:19:53', 8, 19, 1.230000),
(145, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 8, 20, 0.170000),
(146, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 8, 22, 5.580000),
(147, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 8, 23, 8.870000),
(148, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 2, 0.100000),
(149, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 1, 0.130000),
(150, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 4, 0.130000),
(151, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 5, 0.080000),
(152, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 6, 0.130000),
(153, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 7, 2.370000),
(154, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 8, 0.710000),
(155, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 9, 1.000000),
(156, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 10, 28.370001),
(157, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 11, 0.480000),
(158, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 12, 9.850000),
(159, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 13, 1.730000),
(160, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 14, 0.170000),
(161, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 15, 0.750000),
(162, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 16, 5.590000),
(163, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 17, 0.420000),
(164, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 18, 0.170000),
(165, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 19, 0.870000),
(166, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 20, 0.120000),
(167, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 22, 3.970000),
(168, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 9, 23, 6.320000),
(169, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 2, 0.000000),
(170, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 1, 0.000000),
(171, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 4, 0.000000),
(172, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 5, 0.000000),
(173, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 6, 0.000000),
(174, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 7, 0.080000),
(175, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 8, 0.030000),
(176, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 9, 0.040000),
(177, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 10, 1.000000),
(178, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 11, 0.020000),
(179, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 12, 0.350000),
(180, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 13, 0.060000),
(181, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 14, 0.010000),
(182, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 15, 0.030000),
(183, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 16, 0.200000),
(184, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 17, 0.010000),
(185, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 18, 0.010000),
(186, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 19, 0.030000),
(187, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 20, 0.000000),
(188, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 22, 0.140000),
(189, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 10, 23, 0.220000),
(190, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 2, 0.200000),
(191, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 1, 0.270000),
(192, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 4, 0.280000),
(193, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 5, 0.170000),
(194, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 6, 0.280000),
(195, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 7, 4.970000),
(196, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 8, 1.490000),
(197, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 9, 2.100000),
(198, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 10, 59.520000),
(199, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 11, 1.000000),
(200, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 12, 20.670000),
(201, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 13, 3.620000),
(202, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 14, 0.350000),
(203, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 15, 1.570000),
(204, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 16, 11.730000),
(205, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 17, 0.880000),
(206, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 18, 0.350000),
(207, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 19, 1.830000),
(208, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 20, 0.250000),
(209, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 22, 8.340000),
(210, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 11, 23, 13.250000),
(211, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 2, 0.010000),
(212, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 1, 0.010000),
(213, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 4, 0.010000),
(214, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 5, 0.010000),
(215, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 6, 0.010000),
(216, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 7, 0.240000),
(217, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 8, 0.070000),
(218, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 9, 0.100000),
(219, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 10, 2.880000),
(220, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 11, 0.050000),
(221, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 12, 1.000000),
(222, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 13, 0.180000),
(223, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 14, 0.020000),
(224, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 15, 0.080000),
(225, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 16, 0.570000),
(226, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 17, 0.040000),
(227, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 18, 0.020000),
(228, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 19, 0.090000),
(229, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 20, 0.010000),
(230, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 22, 0.400000),
(231, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 12, 23, 0.640000),
(232, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 2, 0.060000),
(233, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 1, 0.070000),
(234, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 4, 0.080000),
(235, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 5, 0.050000),
(236, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 6, 0.080000),
(237, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 7, 1.370000),
(238, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 8, 0.410000),
(239, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 9, 0.580000),
(240, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 10, 16.430000),
(241, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 11, 0.280000),
(242, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 12, 5.710000),
(243, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 13, 1.000000),
(244, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 14, 0.100000),
(245, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 15, 0.430000),
(246, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 16, 3.240000),
(247, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 17, 0.240000),
(248, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 18, 0.100000),
(249, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 19, 0.510000),
(250, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 20, 0.070000),
(251, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 22, 2.300000),
(252, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 13, 23, 3.660000),
(253, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 2, 0.580000),
(254, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 1, 0.770000),
(255, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 4, 0.790000),
(256, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 5, 0.500000),
(257, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 6, 0.800000),
(258, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 7, 14.260000),
(259, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 8, 4.280000),
(260, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 9, 6.020000),
(261, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 10, 170.630005),
(262, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 11, 2.870000),
(263, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 12, 59.259998),
(264, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 13, 10.390000),
(265, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 14, 1.000000),
(266, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 15, 4.490000),
(267, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 16, 33.630001),
(268, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 17, 2.520000),
(269, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 18, 1.000000),
(270, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 19, 5.250000),
(271, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 20, 0.710000),
(272, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 22, 23.889999),
(273, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 14, 23, 37.990002),
(274, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 15, 2, 0.130000),
(275, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 15, 1, 0.170000),
(276, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 15, 4, 0.180000),
(277, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 15, 5, 0.110000),
(278, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 15, 6, 0.180000),
(279, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 15, 7, 3.180000),
(280, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 15, 8, 0.950000),
(281, '2011-10-10 08:19:54', '2011-10-10 08:19:54', 15, 9, 1.340000),
(282, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 15, 10, 38.029999),
(283, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 15, 11, 0.640000),
(284, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 15, 12, 13.210000),
(285, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 15, 13, 2.310000),
(286, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 15, 14, 0.220000),
(287, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 15, 15, 1.000000),
(288, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 15, 16, 7.490000),
(289, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 15, 17, 0.560000),
(290, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 15, 18, 0.220000),
(291, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 15, 19, 1.170000),
(292, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 15, 20, 0.160000),
(293, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 15, 22, 5.330000),
(294, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 15, 23, 8.470000),
(295, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 2, 0.020000),
(296, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 1, 0.020000),
(297, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 4, 0.020000),
(298, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 5, 0.010000),
(299, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 6, 0.020000),
(300, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 7, 0.420000),
(301, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 8, 0.130000),
(302, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 9, 0.180000),
(303, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 10, 5.070000),
(304, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 11, 0.090000),
(305, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 12, 1.760000),
(306, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 13, 0.310000),
(307, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 14, 0.030000),
(308, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 15, 0.130000),
(309, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 16, 1.000000),
(310, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 17, 0.070000),
(311, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 18, 0.030000),
(312, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 19, 0.160000),
(313, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 20, 0.020000),
(314, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 22, 0.710000),
(315, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 16, 23, 1.130000),
(316, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 2, 0.230000),
(317, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 1, 0.310000),
(318, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 4, 0.310000),
(319, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 5, 0.200000),
(320, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 6, 0.320000),
(321, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 7, 5.660000),
(322, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 8, 1.700000),
(323, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 9, 2.390000),
(324, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 10, 67.779999),
(325, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 11, 1.140000),
(326, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 12, 23.540001),
(327, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 13, 4.130000),
(328, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 14, 0.400000),
(329, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 15, 1.780000),
(330, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 16, 13.360000),
(331, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 17, 1.000000),
(332, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 18, 0.400000),
(333, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 19, 2.090000),
(334, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 20, 0.280000),
(335, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 22, 9.490000),
(336, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 17, 23, 15.090000),
(337, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 2, 0.580000),
(338, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 1, 0.770000),
(339, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 4, 0.790000),
(340, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 5, 0.500000),
(341, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 6, 0.800000),
(342, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 7, 14.250000),
(343, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 8, 4.280000),
(344, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 9, 6.010000),
(345, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 10, 170.580002),
(346, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 11, 2.870000),
(347, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 12, 59.240002),
(348, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 13, 10.380000),
(349, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 14, 1.000000),
(350, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 15, 4.490000),
(351, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 16, 33.619999),
(352, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 17, 2.520000),
(353, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 18, 1.000000),
(354, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 19, 5.250000),
(355, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 20, 0.710000),
(356, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 22, 23.889999),
(357, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 18, 23, 37.980000),
(358, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 2, 0.110000),
(359, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 1, 0.150000),
(360, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 4, 0.150000),
(361, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 5, 0.090000),
(362, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 6, 0.150000),
(363, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 7, 2.710000),
(364, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 8, 0.820000),
(365, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 9, 1.150000),
(366, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 10, 32.480000),
(367, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 11, 0.550000),
(368, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 12, 11.280000),
(369, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 13, 1.980000),
(370, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 14, 0.190000),
(371, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 15, 0.850000),
(372, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 16, 6.400000),
(373, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 17, 0.480000),
(374, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 18, 0.190000),
(375, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 19, 1.000000),
(376, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 20, 0.140000),
(377, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 22, 4.550000),
(378, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 19, 23, 7.230000),
(379, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 2, 0.810000),
(380, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 1, 1.090000),
(381, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 4, 1.110000),
(382, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 5, 0.700000),
(383, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 6, 1.130000),
(384, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 7, 20.040001),
(385, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 8, 6.020000),
(386, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 9, 8.460000),
(387, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 10, 239.889999),
(388, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 11, 4.030000),
(389, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 12, 83.320000),
(390, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 13, 14.600000),
(391, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 14, 1.410000),
(392, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 15, 6.310000),
(393, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 16, 47.279999),
(394, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 17, 3.540000),
(395, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 18, 1.410000),
(396, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 19, 7.390000),
(397, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 20, 1.000000),
(398, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 22, 33.590000),
(399, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 20, 23, 53.410000),
(400, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 2, 0.020000),
(401, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 1, 0.030000),
(402, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 4, 0.030000),
(403, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 5, 0.020000),
(404, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 6, 0.030000),
(405, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 7, 0.600000),
(406, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 8, 0.180000),
(407, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 9, 0.250000),
(408, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 10, 7.140000),
(409, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 11, 0.120000),
(410, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 12, 2.480000),
(411, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 13, 0.430000),
(412, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 14, 0.040000),
(413, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 15, 0.190000),
(414, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 16, 1.410000),
(415, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 17, 0.110000),
(416, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 18, 0.040000),
(417, '2011-10-10 08:19:55', '2011-10-10 08:19:55', 22, 19, 0.220000),
(418, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 22, 20, 0.030000),
(419, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 22, 22, 1.000000),
(420, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 22, 23, 1.590000),
(421, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 2, 0.020000),
(422, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 1, 0.020000),
(423, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 4, 0.020000),
(424, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 5, 0.010000),
(425, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 6, 0.020000),
(426, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 7, 0.380000),
(427, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 8, 0.110000),
(428, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 9, 0.160000),
(429, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 10, 4.490000),
(430, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 11, 0.080000),
(431, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 12, 1.560000),
(432, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 13, 0.270000),
(433, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 14, 0.030000),
(434, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 15, 0.120000),
(435, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 16, 0.890000),
(436, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 17, 0.070000),
(437, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 18, 0.030000),
(438, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 19, 0.140000),
(439, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 20, 0.020000),
(440, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 22, 0.630000),
(441, '2011-10-10 08:19:56', '2011-10-10 08:19:56', 23, 23, 1.000000);

-- --------------------------------------------------------

--
-- Table structure for table `currency_conversion_histories`
--

DROP TABLE IF EXISTS `currency_conversion_histories`;
CREATE TABLE IF NOT EXISTS `currency_conversion_histories` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `currency_conversion_id` bigint(20) NOT NULL,
  `rate_before_change` float(10,6) default '0.000000',
  `rate` float(10,6) default '0.000000',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currency_conversion_histories`
--


-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `from` varchar(500) collate utf8_unicode_ci NOT NULL,
  `reply_to` varchar(500) collate utf8_unicode_ci NOT NULL,
  `name` varchar(150) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  `subject` varchar(255) collate utf8_unicode_ci NOT NULL,
  `email_content` text collate utf8_unicode_ci NOT NULL,
  `email_variables` varchar(1000) collate utf8_unicode_ci NOT NULL,
  `is_html` tinyint(1) default '0',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Site Email Template Details';

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `created`, `modified`, `from`, `reply_to`, `name`, `description`, `subject`, `email_content`, `email_variables`, `is_html`) VALUES
(1, '2009-02-20 10:24:49', '2011-11-09 06:26:42', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Forgot Password', 'We will send this mail, when user submit the forgot password form.', 'Reset your ##SITE_NAME## password', '<div style="padding: 10px; width: 720px; margin: auto;">\n  <table width="720" cellspacing="0" cellpadding="0" summary="Forgot Password">\n    <tbody>\n      <tr>\n        <td align="center"><p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;"> Be sure to add <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox. </p></td>\n      </tr>\n    </tbody>\n  </table>\n  <div style="width: 670px; margin: 5px 0pt; padding:20px 18px; border: 5px solid #24BAA3; background-color: #dcdddb;">\n    <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;" summary="Forgot Password">\n      <tbody>\n        <tr>\n          <td align="center"><div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid #d7d7d7;"> <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a> </div></td>\n        </tr>\n        <tr>\n          <td style="padding: 20px 30px 5px;"><h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;"> Hi\n              ##USERNAME##, </h2>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">A password reset request has been made for your user account at ##SITE_NAME##.</p>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">If you made this request, please <a href="##RESET_URL##" style="color: #F7437A;" title="Click here" target="_blank">click here.</a></p>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;"> If you did not request this action and feel this is an error, please contact us at ##SUPPORT_EMAIL##.</p>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;"></p></td>\n        </tr>\n        <tr>\n          <td><div style="border-top: 1px solid #d7d7d7; padding: 15px 30px 25px; margin: 0pt 30px;">\n              <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #4c4c4c;"> Thanks, </h4>\n              <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;"> ##SITE_NAME## - <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a> </h5>\n            </div></td>\n        </tr>\n      </tbody>\n    </table>\n    <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;" summary="Forgot Password">\n      <tbody>\n        <tr>\n          <td><p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;"> Need help? Have feedback? Feel free to <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a> </p></td>\n        </tr>\n      </tbody>\n    </table>\n  </div>\n  <table width="720" cellspacing="0" cellpadding="0" summary="Forgot Password">\n    <tbody>\n      <tr>\n        <td align="center"><p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;"> Delivered by <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p></td>\n      </tr>\n    </tbody>\n  </table>\n</div>', 'FROM_EMAIL, REPLY_TO_EMAIL, USERNAME, RESET_URL, SITE_NAME, SITE_URL,CONTACT_URL', 1),
(2, '2009-02-20 10:15:57', '2011-11-09 06:29:47', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Activation Request', 'We will send this mail, when user registering an account he/she will get an activation request.', 'Please activate your ##SITE_NAME## account', '<div style="padding: 10px; width: 720px; margin: auto;">\n  <table width="720" cellspacing="0" cellpadding="0" summary="Action Request">\n    <tbody>\n      <tr>\n        <td align="center"><p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;"> Be sure to add <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox. </p></td>\n      </tr>\n    </tbody>\n  </table>\n  <div style="width: 670px; margin: 5px 0pt; padding:20px 18px; border: 5px solid #24baa3; background-color: #dcdddb;">\n    <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;" summary="Action Request">\n      <tbody>\n        <tr>\n          <td align="center"><div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid #d7d7d7;"> <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a> </div></td>\n        </tr>\n        <tr>\n          <td style="padding: 20px 30px 5px;"><h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;"> Hi\n              ##USERNAME##, </h2>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;"> Your account has been created. \n              Please visit the following URL to activate your account. <a href="##ACTIVATION_URL##" target="_blank" style="color:#F7437A;">verify your email address</a></p></td>\n        </tr>\n        <tr>\n          <td><div style="border-top: 1px solid #d7d7d7; padding: 15px 30px 25px; margin: 0pt 30px;">\n              <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;"> Thanks, </h4>\n              <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;"> ##SITE_NAME## - <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a> </h5>\n            </div></td>\n        </tr>\n      </tbody>\n    </table>\n    <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;" summary="Action Request">\n      <tbody>\n        <tr>\n          <td><p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;"> Need help? Have feedback? Feel free to <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a> </p></td>\n        </tr>\n      </tbody>\n    </table>\n  </div>\n  <table width="720" cellspacing="0" cellpadding="0" summary="Action Request">\n    <tbody>\n      <tr>\n        <td align="center"><p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;"> Delivered by <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p></td>\n      </tr>\n    </tbody>\n  </table>\n</div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_NAME, USERNAME, ACTIVATION_URL, SITE_URL,CONTACT_URL', 1),
(3, '2009-02-20 10:15:19', '2011-11-09 06:30:46', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'New User Join', 'We will send this mail to admin, when a new user registered in the site. For this you have to enable "admin mail after register" in the settings page.', '[##SITE_NAME##] New user joined', '<div style="padding: 10px; width: 720px; margin: auto;">\n  <table width="720" cellspacing="0" cellpadding="0"  summary="New User Join">\n    <tbody>\n      <tr>\n        <td align="center"><p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;"> Be sure to add <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox. </p></td>\n      </tr>\n    </tbody>\n  </table>\n  <div style="width: 670px; margin: 5px 0pt; padding:20px 18px; border: 5px solid #24baa3; background-color: #dcdddb;">\n    <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;"  summary="New User Join">\n      <tbody>\n        <tr>\n          <td align="center"><div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);"> <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a> </div></td>\n        </tr>\n        <tr>\n          <td style="padding: 20px 30px 5px;"><h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;"> Hi, </h2>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">A new user named "##USERNAME##" has joined in ##SITE_NAME## account.</p>\n            <table width="100%" border="0"  summary="New User Join">\n              <tr>\n                <td width="32%"><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Username</p></td>\n                <td width="8%"><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p></td>\n                <td width="60%"><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;"> ##USERNAME##</p></td>\n               </tr> \n              <tr>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Email</p></td>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p></td>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">##EMAIL##</p></td>\n                </tr>\n              <tr>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Signup IP</p></td>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p></td>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">##SIGNUP_IP##</p></td>\n              </tr>\n            </table>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;"></p></td>\n        </tr>\n        <tr>\n          <td><div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\n              <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;"> Thanks, </h4>\n              <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;"> ##SITE_NAME## - <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a> </h5>\n            </div></td>\n        </tr>\n      </tbody>\n    </table>\n    <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;" summary="New User Join">\n      <tbody>\n        <tr>\n          <td><p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;"> Need help? Have feedback? Feel free to <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a> </p></td>\n        </tr>\n      </tbody>\n    </table>\n  </div>\n  <table width="720" cellspacing="0" cellpadding="0" summary="New User Join">\n    <tbody>\n      <tr>\n        <td align="center"><p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;"> Delivered by <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p></td>\n      </tr>\n    </tbody>\n  </table>\n</div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME,CONTACT_URL', 1),
(4, '2009-03-02 00:00:00', '2011-11-09 07:12:11', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Admin User Add', 'We will send this mail to user, when admin add a new user.', 'Welcome to ##SITE_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\n<table width="720" cellspacing="0" cellpadding="0" summary="Admin User Add">\n  <tbody><tr>\n    <td align="center">\n      <p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;">\n        Be sure to add\n        <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\n        to your address book or safe sender list so our emails get to your inbox.      </p>\n    </td>\n  </tr>\n</tbody></table>\n <div style="width: 670px; margin: 5px 0pt; padding:20px 18px; border: 5px solid #24baa3; background-color: #dcdddb;">\n  <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;"   summary="Admin User Add">\n    <tbody><tr>\n      <td align="center">\n        <div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);">\n          <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a>\n        </div>\n      </td>\n    </tr>\n    <tr>\n      <td style="padding: 20px 30px 5px;">\n        <h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;">\n          Hi\n          ##USERNAME##,\n        </h2>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">##SITE_NAME## team has been added you as a user in ##SITE_NAME##.</p>\n        <table width="100%" border="0" summary="Admin User Add">\n          <tr>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Your account details.</p>\n              </td>\n              </tr>\n          <tr>\n            <td width="27%"><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">##LOGINLABEL##: ##USEDTOLOGIN## </p></td>\n            </tr>\n          <tr>\n            <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Password: ##PASSWORD##</p>\n              </td>\n            </tr>\n        </table>        \n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;"></p></td>\n    </tr>\n    <tr>\n      <td>\n        <div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\n          <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#545454;">\n            Thanks,          </h4>\n          <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\n            ##SITE_NAME## -\n            <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a>          </h5>\n        </div>\n      </td>\n    </tr>\n  </tbody></table>\n  <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;"  summary="Admin User Add">\n    <tbody><tr>\n      <td>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\n          Need help? Have feedback? Feel free to\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a>        </p>\n      </td>\n    </tr>\n  </tbody></table>\n</div>\n<table width="720" cellspacing="0" cellpadding="0"  summary="Admin User Add">\n  <tbody><tr>\n    <td align="center"><p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;"> Delivered by <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p></td>\n  </tr>\n</tbody>\n</table>\n  </div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME, LOGINLABEL, USEDTOLOGIN, PASSWORD,CONTACT_URL', 1),
(5, '2009-05-22 16:51:14', '2011-11-09 07:10:23', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Welcome Email', 'We will send this mail, when user register in this site and get activate.', 'Welcome to ##SITE_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\n<table width="720" cellspacing="0" cellpadding="0" summary="Welcome Email">\n  <tbody><tr>\n    <td align="center">\n      <p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;">\n        Be sure to add\n        <a href="mailto:##FROM_EMAIL##" style="color:#F7437A" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\n        to your address book or safe sender list so our emails get to your inbox.      </p>\n    </td>\n  </tr>\n</tbody></table>\n  <div style="width: 670px; margin: 5px 0pt; padding:20px 18px; border: 5px solid #24baa3; background-color: #dcdddb;">\n   <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;"  summary="Welcome Email">\n    <tbody><tr>\n      <td align="center">\n        <div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);">\n          <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a>\n        </div>\n      </td>\n    </tr>\n    <tr>\n      <td style="padding: 20px 30px 5px;">\n        <h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;">\n          Hi ##USERNAME##,\n        </h2>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">We wish to say a quick hello and thanks for registering at ##SITE_NAME##.</p>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">If you did not request this account and feel this is an error, please\ncontact us at ##SUPPORT_EMAIL##.</p>           \n       </td>\n    </tr>\n    <tr>\n      <td>\n        <div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\n          <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#545454;">\n            Thanks,          </h4>\n          <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\n            ##SITE_NAME## -\n            <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a>          </h5>\n        </div>\n      </td>\n    </tr>\n  </tbody></table>\n   <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;" summary="Welcome Email">\n    <tbody><tr>\n      <td>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\n          Need help? Have feedback? Feel free to\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a>        </p>\n      </td>\n    </tr>\n  </tbody></table>\n</div>\n<table width="720" cellspacing="0" cellpadding="0"  summary="Welcome Email">\n  <tbody><tr>\n    <td align="center">\n      <p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;">\n        Delivered by\n        <a href="##SITE_URL##" style="color:#F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\n    </td>\n  </tr>\n</tbody>\n</table>\n  </div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME, SUPPORT_EMAIL,CONTACT_URL', 1),
(7, '2009-05-22 16:45:38', '2011-01-12 06:54:22', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Admin User Active', 'We will send this mail to user, when user active   \r\nby administator.', 'Your ##SITE_NAME## account has been activated', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color: #00b5c8;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 20px; background-repeat: no-repeat; border: 5px solid #bfe27d; background-color: ebfdff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody><tr>\r\n      <td align="center">\r\n        <div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);">\r\n          <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##"></a>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td style="padding: 20px 30px 5px;">\r\n        <h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;">\r\n          Hi\r\n          ##USERNAME##,\r\n        </h2>\r\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">Your ##SITE_NAME## account has been activated.</p>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\r\n          <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #00b5c8;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_URL##" style="color: #00b5c8;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #e6e6e6;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: Helvetica,Arial,sans-serif; color: #000; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#00b5c8;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_URL##" style="color: #00b5c8;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME,CONTACT_URL', 1),
(8, '2009-05-22 16:48:38', '2011-11-09 07:20:10', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Admin User Deactivate', 'We will send this mail to user, when user deactive by administator.', 'Your ##SITE_NAME## account has been deactivated', '<div style="padding: 10px; width: 720px; margin: auto;">\n<table width="720" cellspacing="0" cellpadding="0" summary="Admin User Deactivate">\n  <tbody><tr>\n    <td align="center">\n      <p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;">\n        Be sure to add\n        <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\n        to your address book or safe sender list so our emails get to your inbox.      </p>\n    </td>\n  </tr>\n</tbody></table>\n  <div style="width: 670px; margin: 5px 0pt; padding:20px 18px; border: 5px solid #24baa3; background-color: #dcdddb;">\n     <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;" summary="Admin User Deactivate">\n    <tbody><tr>\n      <td align="center">\n        <div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);">\n          <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a>\n        </div>\n      </td>\n    </tr>\n    <tr>\n      <td style="padding: 20px 30px 5px;">\n        <h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;">\n          Hi\n          ##USERNAME##,\n        </h2>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">Your ##SITE_NAME## account has been deactivated.</p>\n      </td>\n    </tr>\n    <tr>\n      <td>\n        <div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\n          <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;">\n            Thanks,          </h4>\n          <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\n            ##SITE_NAME## -\n            <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a>          </h5>\n        </div>\n      </td>\n    </tr>\n  </tbody></table>\n <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;" summary="Admin User Deactivate">\n    <tbody><tr>\n      <td>\n	  	<p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\n          Need help? Have feedback? Feel free to\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a>        </p>\n      </td>\n    </tr>\n  </tbody></table>\n</div>\n<table width="720" cellspacing="0" cellpadding="0" summary="Admin User Deactivate">\n  <tbody><tr>\n    <td align="center">\n      <p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;">\n        Delivered by\n        <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\n    </td>\n  </tr>\n</tbody>\n</table>\n  </div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME,CONTACT_URL', 1),
(9, '2009-05-22 16:50:25', '2011-11-09 07:29:27', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Admin User Delete', 'We will send this mail to user, when user delete by administrator.', 'Your ##SITE_NAME## account has been removed', '<div style="padding: 10px; width: 720px; margin: auto;">\n<table width="720" cellspacing="0" cellpadding="0"  summary="Admin User Delete">\n  <tbody><tr>\n    <td align="center">\n      <p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;">\n        Be sure to add\n        <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\n        to your address book or safe sender list so our emails get to your inbox.      </p>\n    </td>\n  </tr>\n</tbody></table>\n  <div style="width: 670px; margin: 5px 0pt; padding:20px 18px; border: 5px solid #24baa3; background-color: #dcdddb;">\n  <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;" summary="Admin User Delete">\n    <tbody><tr>\n      <td align="center">\n        <div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);">\n          <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a>\n        </div>\n      </td>\n    </tr>\n    <tr>\n      <td style="padding: 20px 30px 5px;">\n        <h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;">\n          Hi\n          ##USERNAME##,\n        </h2>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">Your ##SITE_NAME## account has been removed.</p>\n      </td>\n    </tr>\n    <tr>\n      <td>\n        <div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\n          <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;">\n            Thanks,          </h4>\n          <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\n            ##SITE_NAME## -\n            <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a>          </h5>\n        </div>\n      </td>\n    </tr>\n  </tbody></table>\n   <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;"  summary="Admin User Delete">\n    <tbody><tr>\n      <td>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\n          Need help? Have feedback? Feel free to\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a>        </p>\n      </td>\n    </tr>\n  </tbody></table>\n</div>\n<table width="720" cellspacing="0" cellpadding="0"  summary="Admin User Delete">\n  <tbody><tr>\n    <td align="center">\n      <p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;">\n        Delivered by\n        <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\n    </td>\n  </tr>\n</tbody>\n</table>\n  </div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME,CONTACT_URL', 1),
(10, '2009-07-07 15:47:09', '2011-11-09 07:36:43', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Admin Change Password', 'we will send this mail to user, when admin change user password.', 'Password changed for your ##SITE_NAME## account', '<div style="padding: 10px; width: 720px; margin: auto;">\n<table width="720" cellspacing="0" cellpadding="0" summary="Admin Change Password">\n  <tbody><tr>\n    <td align="center">\n      <p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;">\n        Be sure to add\n        <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\n        to your address book or safe sender list so our emails get to your inbox.      </p>\n    </td>\n  </tr>\n</tbody></table>\n  <div style="width: 670px; margin: 5px 0pt; padding:20px 18px; border: 5px solid #24baa3; background-color: #dcdddb;">\n   <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;" summary="Admin Change Password">\n    <tbody><tr>\n      <td align="center">\n        <div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);">\n          <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a>\n        </div>\n      </td>\n    </tr>\n    <tr>\n      <td style="padding: 20px 30px 5px;">\n        <h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;">\n          Hi\n          ##USERNAME##,\n        </h2>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">\n          Admin reset your password for your ##SITE_NAME## account. </p>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">\n           Your new password: ##PASSWORD##</p>\n      </td>\n    </tr>\n    <tr>\n      <td>\n        <div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\n          <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;">\n            Thanks,          </h4>\n          <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\n            ##SITE_NAME## -\n            <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a>          </h5>\n        </div>\n      </td>\n    </tr>\n  </tbody></table>\n   <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;" summary="Admin Change Password">\n    <tbody><tr>\n      <td>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\n          Need help? Have feedback? Feel free to\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a>        </p>\n      </td>\n    </tr>\n  </tbody></table>\n</div>\n<table width="720" cellspacing="0" cellpadding="0" summary="Admin Change Password">\n  <tbody><tr>\n    <td align="center">\n      <p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;">\n        Delivered by\n        <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\n    </td>\n  </tr>\n</tbody>\n</table>\n  </div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME, PASSWORD ,CONTACT_URL', 1),
(11, '2009-09-11 19:52:06', '2011-01-12 07:11:22', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Item of the day', 'This email will be sent to all the subscribers of a particular city, when there is a item available for that particular day.', '##ITEM_NAME##', '<div style="border: 5px solid #bfe27d; margin: 5px 0pt; padding: 20px; width: 700px; background-color:ebfdff; background-repeat: no-repeat;">\n  <table cellspacing="0" cellpadding="0" width="100%" style="background-color: #FFF;">\n    <tbody>\n      <tr>\n        <td colspan="2"><div style="border-bottom: 4px solid #bfe27d; margin: 0pt; min-height: 104px;">\n            <table height="104" cellspacing="0" cellpadding="0"  width="700">\n              <tbody>\n                <tr>\n                  <td valign="top" style="padding: 18px 0pt 0pt 15px; width: 110px; min-height: 37px;"><div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);"> <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a> </div></td>\n                  <td valign="top" style="padding-left: 15px; width: 250px; padding-top: 16px;"><table>\n                      <tbody>\n                        <tr>\n                          <td style="margin: 0pt; color: #00b5c8; font-size: 12px; font-weight: 700; font-family: Helvetica,Arial,sans-serif;"> The Daily Item for </td>\n                        </tr>\n                        <tr>\n                          <td style="margin: 0pt; padding: 5px 0pt 0pt; color: #00b5c8; font-size: 20px; font-weight: 700; font-family: Helvetica,Arial,sans-serif;"> ##CITY_NAME## </td>\n                        </tr>\n                      </tbody>\n                    </table></td>\n                  <td align="right" valign="top" style="padding-right: 20px; padding-top: 21px;"><table cellspacing="0" cellpadding="0" width="225">\n                      <tbody>\n                        <tr>\n                          <td align="right" style="margin: 0pt; color: #00b5c8; font-size: 12px; font-family: Helvetica,Arial,sans-serif;"> ##DATE## </td>\n                        </tr>\n                        <tr>\n                          <td align="right" style="padding-top: 15px;"><p style="margin: 0pt; color: #00b5c8; font-size: 11px; font-family: Helvetica,Arial,sans-serif; font-weight: 700;">follow\n                          us: <a target="_blank" title="Become friends with ##SITE_URL## on Facebook" style="margin-left: 10px;" href="##FACEBOOK_URL##"><img style="border: medium none ; vertical-align: middle;" alt="[Image: Facebook]" src="##FACEBOOK_IMAGE##"/></a> <a target="_blank" title="Follow ##SITE_NAME## on Twitter" style="margin-left: 10px;" href="##TWITTER_URL##"><img style="border: medium none ; vertical-align: middle;"  src="##TWITTER_IMAGE##" alt="[Image: Follow ##SITE_NAME## on Twitter]"/></a> </p></td>\n                        </tr>\n                      </tbody>\n                    </table></td>\n                </tr>\n              </tbody>\n            </table>\n          </div></td>\n      </tr>\n      <tr>\n        <td valign="top" style="border-top: 10px solid #e3e4e6; padding: 20px 0pt 25px;"><table cellspacing="0" cellpadding="0" width="100%">\n            <tbody>\n              <tr>\n                <td colspan="2"><h1 style="margin: 0pt; padding: 0pt 20px 20px 40px;"><a target="_blank" title="##SITE_NAME## - ##ITEM_LINK##" style="margin: 0pt; text-decoration: none; color: #00b5c8; font-size: 26px; font-weight: 700; font-family: Helvetica,Arial,sans-serif;" href="##ITEM_LINK##">##ITEM_NAME##</a></h1></td>\n              </tr>\n              <tr>\n                <td valign="top" style="padding: 0pt 15px 0pt 4px; width: 260px;"><table height="84" cellspacing="0" cellpadding="0" width="260" background="##BACKGROUND##" style="background-repeat:no-repeat; background-position:left;">\n                    <tbody>\n                      <tr>\n                        <td style="padding-left: 45px; font-size: 20px; color: #00b5c8; font-family: Helvetica,Arial,sans-serif; height:84px;"><div>##BUY_PRICE##</div></td>\n                        <td style="padding-top: 5px;"><a target="_blank" title="##SITE_NAME## - ##ITEM_LINK##" href="##ITEM_URL##" style="background:url(''##BTN_IMAGE##'') no-repeat left top; float:left; width:91px; height:41px; font-weight:bold; color:#000; text-decoration:none; font-size:15px; padding:5px 20px; text-align:center;">See Today''s Items</a></td>\n                      </tr>\n                    </tbody>\n                  </table>\n                  <div style="padding: 8px 0pt 0pt 32px;">\n                    <table cellspacing="0" cellpadding="0" width="228">\n                      <tbody>\n                        <tr>\n                          <td style="border: 1px solid rgb(232, 232, 232); padding: 0pt 5px 10px 18px; width: 217px; min-height: 116px;"><table cellspacing="0" cellpadding="0">\n                              <tbody>\n                                <tr>\n                                  <td style="margin: 0pt; padding: 10px 0pt 7px; font-weight: 700; font-size: 11px; color: rgb(0, 0, 0); font-family: Helvetica,Arial,sans-serif;">##END_DATE##</td>\n                                </tr>\n                              </tbody>\n                            </table></td>\n                        </tr>\n                      </tbody>\n                    </table>\n                    <table cellspacing="0" cellpadding="0" width="228">\n                      <tbody>\n                        <tr>\n                          <td style="border: 1px solid rgb(232, 232, 232); padding: 0pt 5px 10px 18px; width: 217px; min-height: 116px;"><table cellspacing="0" cellpadding="0">\n                              <tbody>\n                                <tr>\n                                  <td style="margin: 0pt; padding: 10px 0pt 7px; font-weight: 700; font-size: 11px; color: rgb(0, 0, 0); font-family: Helvetica,Arial,sans-serif;"> Merchant Information: </td>\n                                </tr>\n                                <tr>\n                                  <td style="margin: 0pt; padding: 0pt; font-weight: 700; font-size: 12px; color: rgb(0, 0, 0); font-family: Helvetica,Arial,sans-serif;"> ##MERCHANT_NAME## </td>\n                                </tr>\n                                <tr>\n                                  <td style="margin: 0pt; padding: 0pt; font-size: 12px; color: rgb(0, 0, 0); font-family: Helvetica,Arial,sans-serif;"><a target="_blank" title="##MERCHANT_NAME## website" style="color: #00b5c8;" href="#">##MERCHANT_WEBSITE##</a> </td>\n                                </tr>\n                                <tr>\n                                  <td style="margin: 0pt; padding: 5px 0pt 0pt; font-weight: 700; font-size: 12px; color: rgb(0, 0, 0); font-family: Helvetica,Arial,sans-serif;"> Locations: </td>\n                                </tr>\n                                <tr>\n                                  <td style="margin: 0pt; padding: 0pt; font-size: 12px; color: rgb(0, 0, 0); font-family: Helvetica,Arial,sans-serif;">##MERCHANT_ADDRESS## </td>\n                                </tr>\n                              </tbody>\n                            </table></td>\n                        </tr>\n                      </tbody>\n                    </table>\n                  </div></td>\n                <td valign="top"><a target="_blank" title="##SITE_NAME## - ##ITEM_NAME##" href="##ITEM_LINK##"><img src="##ITEM_IMAGE##" alt="[Image: ##ITEM_NAME##]"/></a></td>\n              </tr>\n              <tr>\n                <td style="padding: 10px 20px 0pt 35px;" colspan="2"><table width="100%" style="border: 1px solid rgb(218, 216, 160); background-color: rgb(255, 253, 193); margin-top: 2px;">\n                    <tbody>\n                      <tr>\n                        <td style="padding: 0pt 10px; font-family: Helvetica,Arial,sans-serif; color: rgb(0, 0, 0); font-size: 14px; line-height: 16px;"><ul style="padding: 0pt;">\n                            <li style="list-style-type: none; list-style-position: outside;">\n                              <p>The wait is over: Who will Live Off ##SITE_NAME##\n                                for the next year? Go to <a target="_blank" href="##SITE_URL##">##SITE_URL##</a> to find out!</p>\n                            </li>\n                          </ul></td>\n                      </tr>\n                    </tbody>\n                  </table></td>\n              </tr>\n            </tbody>\n          </table></td>\n      </tr>\n    </tbody>\n  </table>\n  <table width="100%" style="background-color: #e6e6e6; margin-top: 2px;">\n    <tbody>\n      <tr>\n        <td style="padding: 10px; font-family: Helvetica,Arial,sans-serif; color: #000; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px;"> Need help? Have feedback? Feel free to <a target="_blank" title="Contact ##SITE_NAME##" style="color: #00b5c8;" href="##CONTACT_US##">Contact Us</a> </td>\n      </tr>\n    </tbody>\n  </table>\n<p style="margin:10px 0px;padding:0px;text-align:center;">\n		<span style="font-size:10px; ">You have received this email, just because you have subscribed with ##SITE_NAME##.<br/> ##UNSUB_LBL## ##UNSUB_LNK##</span>\n    </p>\n</div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME, ITEM_LINK, ITEM_NAME, BUY_PRICE, MERCHANT_NAME, MERCHANT_SITE, MERCHANT_ADDRESS, CITY_NAME, ITEM_NAME, DESCRIPTION, UNSUBSCRIBE_LINK ,CONTACT_URL', 1);
INSERT INTO `email_templates` (`id`, `created`, `modified`, `from`, `reply_to`, `name`, `description`, `subject`, `email_content`, `email_variables`, `is_html`) VALUES
(12, '2009-09-24 13:06:48', '2011-11-09 12:56:49', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Item Pass', 'Pass generated for all the buyers of a item', 'Pass for ##ITEM_NAME## from ##SITE_NAME##', '<div style="width: 750px; margin:0 auto; padding:20px 18px; border: 5px solid #24baa3; background-color: #dcdddb;">\n<div style="width:750px; margin:0px auto;margin:0px;padding:0px; font-family:Arial, Helvetica, sans-serif; font-size:12px;">\n<div style="color:#999;  border:2px solid #000; padding:20px; background:#fff;">\n  <table width="100%" style="background-color:#fff;border-bottom:2px solid #ddd;padding:0px 0px 10px 0px;margin:0px 0px 10px 0px;" summary="Item Pass">\n<tr>\n      <td width="70%" style="margin:0px;padding:0px;">\n           <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##"></a>\n       </td>\n      <td width="30%"  style="margin:0px;padding:0px;">\n      	  <strong style="width:120px; margin:0px; padding:0px 0px 0px 10px; font-size:20px; color:#F7437A;">##PASS_CODE##</strong>      </td>\n    </tr>\n\n</table>\n		<p style="margin:0px;padding:0px;">\n			<strong style="color:#F7437A; font-size:20px; display:block; margin:15px 0px 0px 0px; padding:0px;">##ITEM_NAME##</strong>		</p>\n      <div  style="margin:0px;padding:0px 10px;">\n		<table style="background-color:#fff;padding:0px;margin:0px;width: 100%;margin:0px;padding:0px; font-size:12px;"  summary="Item Pass">\n		<tbody>\n		<tr>\n			<td style="width: 49%;line-height:22px;vertical-align:top; margin:0px;padding:0px;">\n				<strong style="color:#000; font-size:16px;display:block;margin:5px 0px 0px 0px;padding:0px;display:block;">Recipient:</strong>\n				<p style="margin:0px;padding:0px;font-size:13px;color:#000;">	##USER_NAME##</p>\n			</td>\n        <td style="width: 49%;line-height:22px;vertical-align:top;margin:0px;padding:0px;" valign="top">\n				<dl style="margin:0px;padding:0px;">\n					<dt style="width:120px; float:left; margin:0px; padding:0px;font-size:16px; text-align:right; font-weight:bold; color:#000;">Purchased: </dt>\n	  			    <dd style="width:130px;float:left;margin:0px;padding:0px 0px 0px 10px;font-size:13px;color:#000;">##PASS_PURCHASED_DATE##</dd>\n				</dl>\n				<dl style="margin:0px;padding:0px;">\n					##MERCHANT_ADDRESS##\n				</dl>\n			</td>\n		</tr>\n		</tbody>\n		</table>\n		<table style="padding:0px; margin:10px 0px 0px 0px;"  summary="Item Pass">\n		<tr>\n 	      <td  width="60%"  style="margin:0px;padding:0px;">\n 	        <strong style="color:#000; font-size:16px; padding:0px 0px 0px 0px;color:#000;display:block;">Universal Fine Print:</strong>\n            <p style="margin:0px;padding:0px;font-size:12px;color:#000;">    Not valid for cash back (unless required by law). Must use in one visit. Doesn''t cover tax or gratuity. Can''t be combined with other offers.<br/>\n                </p>\n	       	</td>\n		<td  width="30%" style="margin:0px;padding:0px; text-aling:left;text-align:left;">\n		  <p style="color:#000;margin:0px;padding:0px;"> ##BARCODE##</p>\n		</td>\n		</tr>\n		</table>\n        </div>\n</div>\n\n    <table style="margin:10px 0px 0px 0px;padding:10px;"  summary="Item Pass">\n        <tr>\n        <td width="60%" style="vertical-align:top;margin:0px;padding:0px;">\n          	<strong style="color:#000; font-size:16px;padding:10px 0px 0px 0px; color:#000;margin:0px 0px 5px 0px;display:block;">How to use this:</strong>\n				<ol  style="font-family:arial;font-size:13px;color:#000;margin:10px 0px;padding:0px;list-style-type:decimal;list-style-position:inside;">\n					<li>Print your ##SITE_NAME##</li>\n\n					<li>Present ##SITE_NAME## upon arrival.</li>\n					<li>Enjoy!</li>\n				</ol>\n				<p style="font-family:arial;font-size:13px;color:#000;margin:0px;padding:0px;">\n				*Remember: ##SITE_NAME## customers tip on the full\n				amount of the pre-discounted service (and tip\n				generously). That''s why we are the coolest\n				customers out there.</p>\n\n				</td>\n				<td width="40%" style="vertical-align:top;margin:0px;padding:0px;">\n					<strong style="color:#000; font-size:20px;padding:10px 0px 5px 0px;color:#000;font-size:16px; display:block;">Map</strong>\n						<div>\n				<img src=''##GOOGLE_MAP###'' />\n				</div>\n				</td>\n			</tr>\n\n		</table>\n			<div style="background-color: #b9dc75; border:2px solid #a0ca4e; padding:10px 0px; margin:0px; text-align:center; font-size:14px; color:#000;">\n					Email ##SITE_NAME##: ##CONTACT_LINK##		</div>\n<div style="margin:0px 0px;padding:20px 10px;font-size:10px;text-align:left">\n	<h6 style="margin:0px;padding:0px;color:#000;font-size:13px;">Legal Stuff We Have To Say:</h6>\n     	<p style="amrgin:0px;padding:0px;font-size:11px;line-heihgt:13px;" >\nGeneral terms applicable to all Vouchers (unless otherwise set forth below, in  ##SITE_NAME##''s Terms of Sale, or in the Fine Print): Unless prohibited by applicable law the following restrictions also apply. See below for\nfurther details. However, even if the promotional offer stated on your ##SITE_NAME## has expired, applicable law may require the merchant to allow you to redeem your Voucher\nbeyond its expiration date for goods/services equal to the amount you paid for it. If you have gone to the merchant and the merchant has refused to redeem the cash value of your expired Voucher, and if applicable\nlaw entitles you to such redemption,  ##SITE_NAME## will refund the purchase price of the Voucher per its Terms of Sale. Partial Redemptions: If you redeem the Voucher for less than its face value, you only will be entitled to\na credit or cash equal to the difference between the face value and the amount you redeemed from the merchant if applicable law requires it.If you redeem this  ##SITE_NAME## Voucher for less than the total face value, you\nwill not be entitled to receive any credit or cash for the difference between the face value and the amount you redeemed, (unless otherwise required by applicable law). You will only be entitled to a redemption value\nequal to the amount you paid for the  ##SITE_NAME## less the amount actually redeemed. The redemption value will be reduced by the amount of purchases made. This  ##SITE_NAME## expiration date above,\nthe merchant will, in its discretion: (1) allow you to redeem this Voucher for the product or service specified on the Voucher or (2) allow you to redeem the Voucher to purchase other goods or services from the\nmerchant for up to the amount you paid for the Voucher. This Voucher can only can be used for making purchases of goods/services at the named merchant. Merchant is solely responsible for Voucher\nredemption. Vouchers cannot be redeemed for cash or applied as payment to any account unless required by applicable law. Neither  ##SITE_NAME##, Inc. nor the named merchant shall be responsible for ##SITE_NAME##s\nVouchers that are lost or damaged. Use of Vouchers are subject to ##SITE_NAME##''s Terms of Sale\n</p>\n	</div>\n	</div>\n</div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME, ITEM_NAME, MERCHANT_NAME, MERCHANT_ADDRESS_1, MERCHANT_ADDRESS_2, MERCHANT_CITY, PASS_CONDITION, QUANTITY, SITE_LOGO, BARCODE, PASS_CODE, USER_NAME ,CONTACT_URL, MERCHANT_COUNTRY, MERCHANT_STATE', 1),
(13, '2009-09-24 13:06:48', '2011-11-09 09:42:39', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Item Pass Buyers List', 'Buyers list for a item', 'List of buyers for "##ITEM_NAME##" item', '<div style="padding: 10px; width: 720px; margin: auto;">\n<table width="720" cellspacing="0" cellpadding="0" summary="Item Pass Buyers List">\n  <tbody><tr>\n    <td align="center">\n      <p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;">\n        Be sure to add\n        <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\n        to your address book or safe sender list so our emails get to your inbox.      </p>\n    </td>\n  </tr>\n</tbody></table>\n\n<div style="color:#999; font-family:Arial, Helvetica, sans-serif; font-size:12px; width:600px; margin:0px auto; border: 5px solid #24baa3;  padding:20px 18px; background-color: #dcdddb;">\n<div style="background-color:#f3f4f2; border:2px solid #fff; padding:10px;">\n  <table width="100%" summary="Item Pass Buyers List">\n<tr>\n      <td align="center">\n        <div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);">\n          <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a>\n        </div>\n      </td>\n    </tr>\n</table>\n<p>Hello <strong style="color:#F7437A;">##USERNAME##</strong>,</p>\n\n<p>Buyers list for <a href=''##ITEM_URL##'' title=''##ITEM_NAME##'' style="color:#F7437A">##ITEM_NAME##</a></p>\n\n<p><strong style="color:#F7437A;">Redeem at: </strong>##REDEMPTION_PLACE## </p>\n\n<p><strong style="color:#F7437A;">Event Date:</strong> ##EVENT_DATE##</p>\n\n<p><strong style="color:#F7437A;">Special Instructions:</strong>##PASS_CONDITION##</p>\n\n<div>\n         ##TABLE##\n<div>\n	<div style="margin:0px 0px;padding:20px 10px; text-align:center;">\n			<h6 style="color:#F7437A; font-family:Helvetica,Arial,sans-serif; font-size:22px; font-weight:700; line-height:26px; margin:0 0 5px; text-align:center;">Thanks</h6>\n		<p style="color:#545454;font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:20px;margin:0;text-align:center;font-weight:bold;">##SITE_NAME## - ##SITE_URL##</p>\n\n	</div>\n</div>\n\n</div>\n</div><div style="background-color: #b9dc75; border:2px solid #a0ca4e; margin:0; text-align:center; border-top:2px solid #d9d9d9; padding:13px 0;">\n      <p style="margin:0; font-weight:bold; color:#535353;">Need help? Have feedback? Feel free to <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427">Contact Us</a> </p>            \n    </div>\n  </div>\n  <p style="text-align:center; font:11px Arial, Helvetica, sans-serif; color:#929292; margin:20px 0;">Delivered by <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\n</div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME, ITEM_NAME, ITEM_URL, REDEMPTION_PLACE, EVENT_DATE, PASS_CONDITION, TABLE,CONTACT_URL', 1),
(14, '2009-09-11 19:52:06', '2011-11-09 12:53:15', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Item Bought', 'We will send this mail, after purchased a item', 'Item Purchased in ##SITE_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\n<table width="720" cellspacing="0" cellpadding="0" summary="Item Bought">\n  <tbody><tr>\n    <td align="center">\n      <p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;">\n        Be sure to add\n        <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\n        to your address book or safe sender list so our emails get to your inbox.      </p>\n    </td>\n  </tr>\n</tbody></table>\n  <div style="width: 670px; margin: 5px 0pt; padding:20px 18px; border: 5px solid #24baa3; background-color: #dcdddb;">\n    <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;" summary="Item Bought">\n    <tbody><tr>\n      <td align="center">\n        <div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);">\n          <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a>\n        </div>\n      </td>\n    </tr>\n    <tr>\n      <td style="padding: 20px 30px 5px;">\n        <h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;">\n          Hi\n          ##USERNAME##,\n        </h2>\n      <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">You have successfully purchased "##ITEM_TITLE##" from ##SITE_NAME##.\n</p>\n        <table width="100%" border="0" summary="Item Bought">\n            <tr>\n            <td width="32%" colspan="3"> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Purchased Details:</p>\n              </td>\n             <tr>\n\n          <tr>\n            <td width="32%"> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Item Name</p>\n              </td>\n            <td width="8%"> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p>\n              </td>\n            <td width="60%"> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">##ITEM_TITLE##</p>\n              </td>\n             <tr>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Quantity</p>\n              </td>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p>\n              </td>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">##QUANTITY##</p>\n              </td>\n          <tr>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Amount</p>\n              </td>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p>\n              </td>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">##ITEM_AMOUNT##</p>\n              </td>\n          <tr>\n          <tr>\n            <td height="32"> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Purchased on</p>\n              </td>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p>\n              </td>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">##PURCHASE_ON##</p>\n              </td>\n          <tr>\n         <tr>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Item Status</p>\n              </td>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p>\n              </td>\n            <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">              ##ITEM_STATUS##\n            </p>\n              </td>\n          <tr>\n <tr>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Merchant Name</p>\n              </td>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p>\n              </td>\n            <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">              ##MERCHANT_NAME##</p>\n              </td>\n          <tr>\n <tr>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Merchant Address</p>\n              </td>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p>\n              </td>\n            <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">              ##MERCHANT_ADDRESS##</p>\n              </td>\n          <tr>          </table>\n\n                <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">Note: You will receive the pass once the item get tipped.</p>\n\n\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;"></p></td>\n    <tr>\n      <td>\n        <div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\n          <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;">\n            Thanks,          </h4>\n          <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\n            ##SITE_NAME## -\n            <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a>          </h5>\n        </div>\n      </td>\n    </tr>\n  </tbody></table>\n    <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;" summary="New User Join">\n    <tbody><tr>\n      <td>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: #000; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\n          Need help? Have feedback? Feel free to\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a>        </p>\n      </td>\n    </tr>\n  </tbody></table>\n</div>\n\n<table width="720" cellspacing="0" cellpadding="0" summary="Item Bought">\n  <tbody><tr>\n    <td align="center">\n      <p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;">\n        Delivered by\n        <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\n    </td>\n  </tr>\n</tbody>\n</table>\n  </div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME, ITEM_TITLE, QUANTITY, ITEM_AMOUNT ,CONTACT_URL', 1),
(15, '0000-00-00 00:00:00', '2011-11-09 10:31:11', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Item Amount Refunded', 'We will send this mail, when item amount is refunded to user.', 'Item amount refunded for ##ITEM_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\n<table width="720" cellspacing="0" cellpadding="0" summary="Item Amount Refunded">\n  <tbody><tr>\n    <td align="center">\n      <p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;">\n        Be sure to add\n        <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\n        to your address book or safe sender list so our emails get to your inbox.      </p>\n    </td>\n  </tr>\n</tbody></table>\n<div style="width: 670px; margin: 5px 0pt; padding: 20px; border: 5px solid #24baa3; background-color: #dcdddb;">\n  <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;"  summary="Item Amount Refunded">\n    <tbody><tr>\n      <td align="center">\n        <div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);">\n          <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a>\n        </div>\n      </td>\n    </tr>\n    <tr>\n      <td style="padding: 20px 30px 5px;">\n        <h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;">\n          Hi\n          ##USER_NAME##,\n        </h2>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">The "##ITEM_NAME##" item which you bought in ##SITE_NAME## was not reached the minimum target, so the item was not tipped. ##SITE_NAME## refunded your amount to your wallet.</p>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">Please login and check for your wallet amount.</p>       \n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;"></p></td>\n    </tr>\n    <tr>\n      <td>\n        <div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\n          <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;">\n            Thanks,          </h4>\n          <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\n            ##SITE_NAME## -\n            <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a>          </h5>\n        </div>\n      </td>\n    </tr>\n  </tbody></table>\n  <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;"  summary="Item Amount Refunded">\n    <tbody><tr>\n      <td>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\n          Need help? Have feedback? Feel free to\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a>        </p>\n      </td>\n    </tr>\n  </tbody></table>\n</div>\n<table width="720" cellspacing="0" cellpadding="0"  summary="Item Amount Refunded">\n  <tbody><tr>\n    <td align="center">\n      <p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;">\n        Delivered by\n        <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\n    </td>\n  </tr>\n</tbody>\n</table>\n  </div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USER_NAME, ITEM_NAME, CONTACT_URL', 1),
(16, '2009-03-02 00:00:00', '2011-11-09 10:43:49', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Two Way New Friend', 'We will send this mail, when a user get new friend request', '##USERNAME## added you as a friend on ##SITE_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\n<table width="720" cellspacing="0" cellpadding="0" summary="Two Way New Friend">\n  <tbody><tr>\n    <td align="center">\n      <p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;">\n        Be sure to add\n        <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\n        to your address book or safe sender list so our emails get to your inbox.      </p>\n    </td>\n  </tr>\n</tbody></table>\n <div style="width: 670px; margin: 5px 0pt; padding:20px 18px; border: 5px solid #24baa3; background-color: #dcdddb;">\n  <table width="100%"  style="background-color:#f3f4f2; border:2px solid #fff;"   summary="Two Way New Friend">\n    <tbody><tr>\n      <td align="center">\n        <div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);">\n          <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a>\n        </div>\n      </td>\n    </tr>\n    <tr>\n      <td style="padding: 20px 30px 5px;">\n        <h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;">\n          Hi ##TO_USER##,\n        </h2>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">##USERNAME## requested you as a friend on ##SITE_NAME##.</p>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">Click here to view \n<a href="##PROFILE_LINK##" style="color: #F7437A;" title="Click here" target="_blank">##USERNAME##''s profile.</a></p>     \n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;"> If you accept the ##USERNAME##''s request, Please\n<a href="##FRIEND_LINK##" style="color: #F7437A;" title="Click here" target="_blank">Click here</a>.</p>       \n       \n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;"></p></td>\n    </tr>\n    <tr>\n      <td>\n        <div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\n          <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;">\n            Thanks,          </h4>\n          <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\n            ##SITE_NAME## -\n            <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a>          </h5>\n        </div>\n      </td>\n    </tr>\n  </tbody></table>\n  <table width="100%"  style="background-color: #b9dc75; border:2px solid #a0ca4e;" summary="Two Way New Friend">\n    <tbody><tr>\n      <td>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\n          Need help? Have feedback? Feel free to\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a>        </p>\n      </td>\n    </tr>\n  </tbody></table>\n</div>\n<table width="720" cellspacing="0" cellpadding="0"  summary="Two Way New Friend">\n  <tbody><tr>\n    <td align="center">\n      <p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;">\n        Delivered by\n        <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\n    </td>\n\n  </tr>\n</tbody>\n</table>\n  </div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME, PROFILE_LINK, TO_USER,CONTACT_URL', 1),
(17, '2009-03-02 00:00:00', '2011-01-12 06:25:59', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'One Way New Friend', 'We will send this mail, when a user get new friend request', '##USERNAME## added you as a friend on ##SITE_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color: #00b5c8;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 20px; background-repeat: no-repeat; border: 5px solid #bfe27d; background-color: ebfdff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody><tr>\r\n      <td align="center">\r\n        <div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);">\r\n          <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##"></a>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td style="padding: 20px 30px 5px;">\r\n        <h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;">\r\n          Hi ##TO_USER##\r\n        </h2>\r\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">##USERNAME## added you as a friend on ##SITE_NAME##.</p>   <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">Click here to view <a href="##PROFILE_LINK##" style="color: #00b5c8;" title="Click here to your whitelist" target="_blank">##USERNAME##''s profile</a></p>       \r\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;"></p></td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\r\n          <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #00b5c8;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_URL##" style="color: #00b5c8;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #e6e6e6;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: Helvetica,Arial,sans-serif; color: #000; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#00b5c8;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_URL##" style="color: #00b5c8;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME, PROFILE_LINK, FRIEND_LINK, TO_USER,CONTACT_URL', 1),
(18, '2009-03-02 00:00:00', '2011-11-09 10:57:44', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'New Comment Profile', 'We will send this mail, when a user get new comment on his profile', '##USERNAME## wrote on your Wall...', '<div style="padding: 10px; width: 720px; margin: auto;">\n<table width="720" cellspacing="0" cellpadding="0"  summary="New Comment Profile">\n  <tbody><tr>\n    <td align="center">\n      <p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;">\n        Be sure to add\n        <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\n        to your address book or safe sender list so our emails get to your inbox.      </p>\n    </td>\n  </tr>\n</tbody></table>\n<div style="width: 670px; margin: 5px 0pt; padding: 20px; background-repeat: no-repeat;  border: 5px solid #24baa3; background-color: #dcdddb;">\n  <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;" summary="New Comment Profile">\n    <tbody><tr>\n      <td align="center">\n        <div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);">\n          <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a>\n        </div>\n      </td>\n    </tr>\n    <tr>\n      <td style="padding: 20px 30px 5px;">\n        <h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;">\n          Hi ##PROFILEUSERNAME##,\n        </h2>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">##USERNAME## wrote on your Wall: ##COMMENT##</p>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;"> To see your Wall, Please <a href="##PROFILE_LINK##" style="color: #F7437A;" title="Click here" target="_blank">Click here</a></p>             \n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;"></p></td>\n    </tr>\n    <tr>\n      <td>\n        <div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\n          <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;">\n            Thanks,          </h4>\n          <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\n            ##SITE_NAME## -\n            <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a>          </h5>\n        </div>\n      </td>\n    </tr>\n  </tbody></table>\n  <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;" summary="New Comment Profile">\n    <tbody><tr>\n      <td>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\n          Need help? Have feedback? Feel free to\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a>        </p>\n      </td>\n    </tr>\n  </tbody></table>\n</div>\n<table width="720" cellspacing="0" cellpadding="0" summary="New Comment Profile">\n  <tbody><tr>\n    <td align="center">\n      <p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;">\n        Delivered by\n        <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\n    </td>\n  </tr>\n</tbody>\n</table>\n  </div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME, PROFILE_LINK, COMMENT,CONTACT_URL', 1),
(19, '2009-03-02 00:00:00', '2011-11-09 11:06:10', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Invite User', 'We will send this mail, when a user invited his/her friends', '##USERNAME## would like to add you as a contact at ##SITE_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\n<table width="720" cellspacing="0" cellpadding="0" summary="Invite User">\n  <tbody><tr>\n    <td align="center">\n      <p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;">\n        Be sure to add\n        <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\n        to your address book or safe sender list so our emails get to your inbox.      </p>\n    </td>\n  </tr>\n</tbody></table>\n<div style="width: 670px; margin: 5px 0pt; padding: 20px; background-repeat: no-repeat; border: 5px solid #24baa3; background-color: #dcdddb;">\n  <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;" summary="Invite User">\n    <tbody><tr>\n      <td align="center">\n        <div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);">\n          <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a>\n        </div>\n      </td>\n    </tr>\n    <tr>\n      <td style="padding: 20px 30px 5px;">\n        <h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;">\n          Hi,\n        </h2>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">##USERNAME##, requested you to join his/her ##SITE_NAME## network.</p>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">I have joined the ##SITE_NAME## network. I wish to invite you to ##SITE_NAME## as well.</p>             \n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;"><a href="##SITE_URL##" style="color: #F7437A;" title="Click here" target="_blank">Click here</a> to our site.</p>      \n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">Join fast!</p>      \n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">##USERNAME##</p>      \n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">  If you did not request this action and feel this is an error, please contact us at ##SUPPORT_EMAIL##.</p>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;"></p></td>\n    </tr>\n    <tr>\n      <td>\n        <div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\n          <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;">\n            Thanks,          </h4>\n          <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\n            ##SITE_NAME## -\n            <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a>          </h5>\n        </div>\n      </td>\n    </tr>\n  </tbody></table>\n  <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;" summary="Invite User">\n    <tbody><tr>\n      <td>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\n          Need help? Have feedback? Feel free to\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a>        </p>\n      </td>\n    </tr>\n  </tbody></table>\n</div>\n<table width="720" cellspacing="0" cellpadding="0" summary="Invite User">\n  <tbody><tr>\n    <td align="center">\n      <p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;">\n        Delivered by\n        <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\n    </td>\n  </tr>\n</tbody>\n</table>\n  </div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME,CONTACT_URL', 1),
(20, '2009-10-14 18:31:14', '2011-11-09 11:21:06', '##FROM_EMAIL##', '##FROM_EMAIL##', 'Contact Us ', 'We will send this mail to admin, when user submit any contact form.', '[##SITE_NAME##] ##SUBJECT##', '<div style="padding: 10px; width: 720px; margin: auto;">\n<table width="720" cellspacing="0" cellpadding="0" summary="Contact Us">\n  <tbody><tr>\n    <td align="center">&nbsp;\n	\n    </td>\n  </tr>\n</tbody></table>\n<div style="width: 670px; margin: 5px 0pt; padding: 20px; border: 5px solid #24baa3; background-color: #dcdddb;">\n  <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;"  summary="Contact Us">\n    <tbody><tr>\n      <td align="center">\n        <div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);">\n          <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a>\n        </div>\n      </td>\n    </tr>\n    <tr>\n      <td style="padding: 20px 30px 5px;"><h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;">          ##MESSAGE##</h2>\n        <table width="100%" border="0"  summary="Contact Us">\n          <tr>\n            <td width="32%"> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Telephone</p>\n              </td>\n            <td width="8%"> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p>\n              </td>\n            <td width="60%"> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;"> ##TELEPHONE##</p>\n              </td>\n             <tr>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">IP</p>\n              </td>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p>\n              </td>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">##IP##, ##SITE_ADDR##</p>\n              </td>\n          <tr>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Whois</p>\n              </td>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p>\n              </td>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">http://whois.sc/##IP##</p>\n              </td>\n          <tr>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">URL</p>\n              </td>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p>\n              </td>\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">##FROM_URL##</p>\n              </td>\n          </tr>  \n        </table>        \n        <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;"></p></td>\n    </tr>\n    <tr>\n      <td>\n        <div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\n          <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;">\n            Thanks,          </h4>\n          <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\n            ##SITE_NAME## -\n            <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a>          </h5>\n        </div>\n      </td>\n    </tr>\n  </tbody></table>\n  <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;"  summary="Contact Us">\n    <tbody><tr>\n      <td>\n        <p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\n          Need help? Have feedback? Feel free to\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a>        </p>\n      </td>\n    </tr>\n  </tbody></table>\n</div>\n<table width="720" cellspacing="0" cellpadding="0"  summary="Contact Us">\n  <tbody><tr>\n    <td align="center">\n      <p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;">\n        Delivered by\n        <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\n    </td>\n  </tr>\n</tbody>\n</table>\n  </div>', 'FROM_URL, IP, TELEPHONE, MESSAGE, SITE_NAME, SUBJECT, FROM_EMAIL, LAST_NAME, FIRST_NAME,CONTACT_URL', 1);
INSERT INTO `email_templates` (`id`, `created`, `modified`, `from`, `reply_to`, `name`, `description`, `subject`, `email_content`, `email_variables`, `is_html`) VALUES
(21, '2009-10-14 19:20:59', '2011-08-02 14:55:03', '"##SITE_NAME## (auto response) "   ##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Contact Us Auto Reply', 'We will send this mail to user, when user submit the contact us form.', '[##SITE_NAME##] RE: ##SUBJECT##', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n  <table width="720" cellspacing="0" cellpadding="0" summary="Contact Us Auto Reply">\r\n    <tbody>\r\n      <tr>\r\n        <td align="center"><p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;"> Be sure to add <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox. </p></td>\r\n      </tr>\r\n    </tbody>\r\n  </table>\r\n  <div style="width: 670px; margin: 5px 0pt; padding: 20px; padding:20px 18px; border: 5px solid #24baa3; background-color: #dcdddb;">\r\n    <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;"  summary="Contact Us Auto Reply">\r\n      <tbody>\r\n        <tr>\r\n          <td align="center"><div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);"> <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a> </div></td>\r\n        </tr>\r\n        <tr>\r\n          <td style="padding: 20px 30px 5px;"><h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;"> Hi\r\n              ##FIRST_NAME####LAST_NAME##, </h2>\r\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">Thanks for contacting us. We''ll get back to you shortly.</p>\r\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">Please do not reply to this automated response. If you have not contacted us and if you feel this is an error, please <a href="##CONTACT_URL##" style="color: #F7437A;" title="##CONTACT_URL##" target="_blank">contact us</a> through our site. </p>\r\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">------ On ##POST_DATE## you wrote from ##IP## --------</p>\r\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">##MESSAGE## </p>\r\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;"></p></td>\r\n        </tr>\r\n        <tr>\r\n          <td><div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\r\n              <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;"> Thanks, </h4>\r\n              <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;"> ##SITE_NAME## - <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a> </h5>\r\n            </div></td>\r\n        </tr>\r\n      </tbody>\r\n    </table>\r\n    <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;"  summary="Contact Us Auto Reply">\r\n      <tbody>\r\n        <tr>\r\n          <td><p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;"> Need help? Have feedback? Feel free to <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a> </p></td>\r\n        </tr>\r\n      </tbody>\r\n    </table>\r\n  </div>\r\n  <table width="720" cellspacing="0" cellpadding="0"  summary="Contact Us Auto Reply">\r\n    <tbody>\r\n      <tr>\r\n        <td align="center"><p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;"> Delivered by <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p></td>\r\n      </tr>\r\n    </tbody>\r\n  </table>\r\n</div>', 'SITE_NAME, SUBJECT, FIRST_NAME, LAST_NAME, CONTACT_URL, POST_DATE, IP , MESSAGE,CONTACT_URL', 1),
(22, '2010-05-24 00:00:00', '2011-11-09 12:47:25', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Subscription Welcome Mail', 'We will send this mail, when user subscribed for a city ', 'Welcome to ##SITE_NAME##!', '<div style="border: 5px solid #bfe27d; margin: 5px 0pt; padding: 20px; width: 705px;  padding:20px 18px; border: 5px solid #24baa3; background-color: #dcdddb;">\n  <table cellspacing="0" cellpadding="0" width="100%" style="background-color:#f3f4f2; border:2px solid #fff;"  summary="Subscribtion Welcome Mail">\n    <tbody>\n      <tr>\n        <td colspan="2"><div style="border-bottom: 4px solid #24baa3; margin: 0pt; min-height: 104px;">\n            <table height="104" cellspacing="0" cellpadding="0" bgcolor="#ffffff" width="700"  summary="Subscribtion Welcome Mail">\n              <tbody>\n                <tr>\n                  <td valign="top" style="padding: 18px 0pt 0pt 15px; width: 110px; min-height: 37px;"><a target="_blank" title="##SITE_NAME##" style="color: rgb(9, 129, 190);" href="#"> <img style="border-style: none solid none none; border-color: -moz-use-text-color rgb(84, 84, 84) -moz-use-text-color -moz-use-text-color; border-width: 0px 1px 0px 0px; padding-right: 15px;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]"/></a></td>\n                  <td valign="top" style="padding-left: 15px; width: 250px; padding-top: 16px;"><table  summary="Subscribtion Welcome Mail">\n                      <tbody>\n                        <tr>\n                          <td style="margin: 0pt; padding: 5px 0pt 0pt; color: #000; font-size: 20px; font-weight: 700; font-family: Helvetica,Arial,sans-serif;"> ##SITE_NAME## </td>\n                        </tr>\n                      </tbody>\n                    </table></td>\n                  <td align="right" valign="top" style="padding-right: 20px; padding-top: 21px;">&nbsp;</td>\n                </tr>\n              </tbody>\n            </table>\n          </div></td>\n      </tr>\n      <tr>\n        <td valign="top" style="border-top: 10px solid #24baa3; padding: 20px 0pt 25px;"><div style="margin: auto; padding: 10px; width: 650px;">\n            <table align="center" cellpadding="0" cellspacing="0" width="650"  summary="Subscribtion Welcome Mail">\n              <tbody>\n                <tr>\n                  <td><p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;"> Be sure to add <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox. </p>\n                    <a href="##LEARN_HOW_LINK##" style="color: #F7437A;" title="White List ##SITE_NAME##" target="_blank">Learn How</a> </td>\n                </tr>\n              </tbody>\n            </table>\n            <div style="border: 5px solid #24baa3; margin: 10px auto 5px; padding: 20px; width: 590px; background-repeat: no-repeat;">\n              <table style="background-color: rgb(255, 255, 255);" cellpadding="0" cellspacing="0" width="100%"  summary="Subscribtion Welcome Mail">\n                <tbody>\n                  <tr>\n                    <td style="padding-top: 10px;"><table align="center" bgcolor="#ffffff" width="540" height="134" style="border:1px solid #ffffff; -moz-border-radius:5px; -webkit-border-radius:5px;"  summary="Subscribtion Welcome Mail">\n                        <tbody>\n                          <tr>\n                            <td style="padding: 0pt 20px; text-align: center;" valign="top"><h1 style="margin: 0pt; padding: 13px 10px 10px; font-family: Helvetica,Arial,sans-serif; color: #000; font-weight: 700; font-size: 21px;">Welcome to ##SITE_NAME##!</h1>\n                              <p style="margin: 0pt; padding: 0pt 10px; font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); font-size: 14px; line-height: 21px;">Every morning, you''ll find one exclusive item waiting in your inbox. We can''t wait to help you explore all the cool things to do in your city at a price you can afford.</p></td>\n                          </tr>\n                        </tbody>\n                      </table></td>\n                  </tr>\n                  <tr style="width: 100%;">\n                    <td style="padding-top: 10px;"><table style="padding: 22px 0pt 0pt;" align="center" cellpadding="0" cellspacing="0" width="540"  summary="Subscribtion Welcome Mail">\n                        <tbody>\n                          <tr>\n                            <td width="180" height="160"><table align="center" background="bg-bucket.gif" cellpadding="0" cellspacing="0" width="180" height="160" style="font-family:Arial, Helvetica, sans-serif;"  summary="Subscribtion Welcome Mail">\n                                <tbody>\n                                  <tr>\n                                    <td style="width: 164px; min-height: 44px;" align="center" valign="top"><h2 style="margin: 0pt 0pt 3px; font-size: 16px;"><a style="color:#F7437A; text-decoration: none;" href="##REFER_FRIEND_LINK##" title="##REFERAL_PERSON##" target="_blank">##REFERAL_PERSON##</a></h2>\n                                      <p style="margin: 0pt; color: rgb(84, 84, 84); font-weight: 700; font-family: Helvetica,Arial,sans-serif; font-size: 11px;">Get ##REFERRAL_AMOUNT## ##SITE_NAME## bucks</p></td>\n                                  </tr>\n                                  <tr>\n                                    <td style="width: 164px; min-height: 90px;" align="center" valign="top"><a href="##REFER_FRIEND_LINK##" title="##REFERAL_PERSON##, Get ##REFERRAL_AMOUNT##" target="_blank"> <img style="border: medium none ;" src="##SITE_URL##img/blue-theme/subscription_welcome_mail/refer-friend.png" /> </a> </td>\n                                  </tr>\n                                  <tr>\n                                    <td style="width: 164px;" align="center" background="btn-bule.png"><a style="line-height: 21px; color: rgb(255, 255, 255); font-size: 11px; font-weight: 700; text-decoration: none;" href="##REFER_FRIEND_LINK##" title="##REFERAL_PERSON##, Get ##REFERRAL_AMOUNT##" target="_blank">##REFERAL_PERSON##</a> </td>\n                                  </tr>\n                                  <tr>\n                                    <td height="10">&nbsp;</td>\n                                  </tr>\n                                </tbody>\n                              </table></td>\n                            <td width="180" height="160">&nbsp;</td>\n                            <td width="180" height="160"><p style="margin: 0pt 0pt 5px; text-align: center; color: #21759b; font-family: Helvetica,Arial,sans-serif; font-style: italic;">...and don''t forget to keep in touch:</p>\n                              <p style="margin: 0pt; text-align: center;"> <a href="##FACEBOOK_LINK##" title="##SITE_NAME## Facebook" target="_blank"><img src="##SITE_URL##img/blue-theme/subscription_welcome_mail/icon-facebook.png" alt="[Image: Facebook]" width="48" height="48" style="border: 0pt none ;" /></a> <a href="##TWITTER_LINK##" title="##SITE_NAME## Twitter" target="_blank"><img style="border: 0pt none ; margin-left: 3px;" src="##SITE_URL##img/blue-theme/subscription_welcome_mail/icon-twitter.png" alt="[Image: Follow ##SITE_NAME## on Twitter]" /></a></p></td>\n                          </tr>\n                        </tbody>\n                      </table>\n                      <table cellpadding="0" cellspacing="0" width="100%"  summary="Subscribtion Welcome Mail">\n                        <tbody>\n                          <tr>\n                            <td colspan="1" style="border-top: 4px solid #ccc; border-right: 4px solid #ccc; border-bottom: 4px solid #ccc; padding: 20px 30px; background: #ffffff; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" valign="top" width="33%"><p style="margin: 0pt; line-height: 18px; font-family: Georgia,Helvetica,Arial,sans-serif; font-size: 14px; font-style: italic; color: rgb(84, 84, 84);">Get ready </br>\n                                <span style="color: rgb(84, 84, 84); font-style: normal; line-height: 22px; font-family: Helvetica,Arial,sans-serif; font-weight: 700; font-size: 18px;">50% - 90% off</span> the best in your city:</p>\n                              <table style="padding-top: 5px; width: 100%;" cellpadding="0" cellspacing="1"  summary="Subscribtion Welcome Mail">\n                                <tbody>\n                                  <tr>\n                                    <td width="19"><img src="##SITE_URL##img/blue-theme/subscription_welcome_mail/icon-hand.png" alt="[Image: Hand]" /></td>\n                                    <td style="padding: 3px 0pt 0pt 4px; font-family: Helvetica,Arial,sans-serif; font-size: 14px; color: rgb(84, 84, 84);">Merchants</td>\n                                  </tr>\n                                  <tr>\n                                    <td width="19"><img src="##SITE_URL##img/blue-theme/subscription_welcome_mail/icon-hand.png" alt="[Image: Hand]" /></td>\n                                    <td style="padding: 3px 0pt 0pt 4px; font-family: Helvetica,Arial,sans-serif; font-size: 14px; color: rgb(84, 84, 84);">Spas</td>\n                                  </tr>\n                                  <tr>\n                                    <td width="19"><img src="##SITE_URL##img/blue-theme/subscription_welcome_mail/icon-hand.png" alt="[Image: Hand]" /></td>\n                                    <td style="padding: 3px 0pt 0pt 4px; font-family: Helvetica,Arial,sans-serif; font-size: 14px; color: rgb(84, 84, 84);">Activities</td>\n                                  </tr>\n                                  <tr>\n                                    <td width="19"><img src="##SITE_URL##img/blue-theme/subscription_welcome_mail/icon-hand.png" alt="[Image: Hand]" /></td>\n                                    <td style="padding: 3px 0pt 0pt 4px; font-family: Helvetica,Arial,sans-serif; font-size: 14px; color: rgb(84, 84, 84);">Events</td>\n                                  </tr>\n                                  <tr>\n                                    <td width="19"><img src="##SITE_URL##img/blue-theme/subscription_welcome_mail/icon-hand.png" alt="[Image: Hand]" /></td>\n                                    <td style="padding: 3px 0pt 0pt 4px; font-family: Helvetica,Arial,sans-serif; font-size: 14px; color: rgb(84, 84, 84);">Classes</td>\n                                  </tr>\n                                </tbody>\n                              </table>\n                              <p style="margin: 5px 0pt 0pt;"><a style="color: #F7437A; font-weight: 700; text-decoration: none; font-size: 12px;" href="##RECENT_ITEMS##" target="_blank">See more recent items</a></p></td>\n                            <td colspan="2" style="border-top: 4px solid #ccc; border-bottom: 4px solid #ccc; padding: 20px 30px; background: #ffffff; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" valign="top" width="66%"><table  summary="Subscribtion Welcome Mail">\n                                <tbody>\n                                  <tr>\n                                    <td style="margin: 0pt; line-height: 18px; font-family: Georgia,Helvetica,Arial,sans-serif; font-size: 14px; font-style: italic; color: rgb(84, 84, 84);">What our <span style="color: rgb(84, 84, 84); font-style: normal; line-height: 22px; font-family: Helvetica,Arial,sans-serif; font-weight: 700; font-size: 18px;">over 5 million customers</span> are saying about ##SITE_NAME##:</td>\n                                  </tr>\n                                  <tr>\n                                    <td style="margin: 0pt; line-height: 18px; font-family: Georgia,Helvetica,Arial,sans-serif; font-size: 14px; font-style: italic;"><table style="padding-top: 5px;" cellpadding="0" cellspacing="0"  summary="Subscribtion Welcome Mail">\n                                        <tbody>\n                                          <tr>\n                                            <td valign="top"><img src="##SITE_URL##img/blue-theme/subscription_welcome_mail/icon-quote.png" alt="[Image: Quote]" /> </td>\n                                            <td valign="top"><p style="margin: 2px 0pt 0pt 4px; font-size: 12px; font-family: Helvetica,Arial,sans-serif; font-style: italic; color: rgb(84, 84, 84);">##SITE_NAME## you are beyond awesome. You are the first e-mail I check everyday outside of work e-mail, I do have to pace myself however and fight the urge to NOT buy everything that comes up.</p>\n                                              <p style="margin: 2px 0pt 0pt 4px; font-size: 12px; font-family: Helvetica,Arial,sans-serif; font-weight: 700; font-style: normal; color: rgb(84, 84, 84);">Missy Y, Yelp.com</p></td>\n                                          </tr>\n                                          <tr>\n                                            <td style="padding-top: 10px;" valign="top"><img src="##SITE_URL##img/blue-theme/subscription_welcome_mail/icon-quote.png" alt="[Image: Quote]" /> </td>\n                                            <td style="padding-top: 10px;"><p style="margin: 2px 0pt 0pt 4px; font-size: 12px; font-family: Helvetica,Arial,sans-serif; font-style: italic; color: rgb(84, 84, 84);">Hi. My name is Nektaria and I''m addicted to ##SITE_NAME##.</p>\n                                              <p style="margin: 2px 0pt 0pt 4px; font-size: 12px; font-family: Helvetica,Arial,sans-serif; font-weight: 700; font-style: normal; color: rgb(84, 84, 84);">Nektaria R, Yelp.com</p></td>\n                                          </tr>\n                                        </tbody>\n                                      </table></td>\n                                  </tr>\n                                  <tr>\n                                    <td><p style="margin: 5px 0pt 0pt;"><a style="color: #F7437A; font-weight: 700; text-decoration: none; font-size: 12px;" href="##SITE_URL##" target="_blank">See more ##SITE_NAME## buzz</a></p></td>\n                                  </tr>\n                                </tbody>\n                              </table></td>\n                          </tr>\n                        </tbody>\n                      </table></td>\n                  </tr>\n                  <tr>\n                    <td><table align="center" width="530">\n                        <tbody>\n                          <tr>\n                            <td><div style="margin: 0pt; padding: 15px 0pt 25px;">\n                                <h4 style="margin: 0pt 0pt 5px; font-family: Helvetica,Arial,sans-serif; font-size: 35px; font-weight: 700; text-align: center; color: #545454; line-height: 26px;"><img style="margin: 0pt 8px 0pt 0pt; vertical-align: middle;" src="##SITE_URL##img/blue-theme/subscription_welcome_mail/thanks.png" alt="[Image: ##SITE_NAME##]" />Thanks!</h4>\n                                <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); font-size: 16px; line-height: 20px;">We hope you have as much fun using ##SITE_NAME## as we have working on it. And we crave your feedback: email us</p>\n                                <p style="margin: 10px 0pt 0pt; font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; font-size: 16px;">Sincerely,</p>\n                                <p style="margin: 0pt; font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; font-size: 16px; font-weight: 700;">The ##SITE_NAME## Team</p>\n                                <p style="margin: 0pt; font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; font-size: 12px; font-weight: 700;"><a style="color: #535353;" href="##SITE_URL##" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\n                              </div></td>\n                          </tr>\n                        </tbody>\n                      </table></td>\n                  </tr>\n                </tbody>\n              </table>\n            </div>\n            <table align="center" cellpadding="0" cellspacing="0" width="650"  summary="Subscribtion Welcome Mail">\n              <tbody>\n                <tr>\n                  <td style="text-align: center;"><p style="margin: 3px; font-size: 11px; font-family: Helvetica,Arial,sans-serif; color: rgb(146, 146, 146); padding-bottom: 5px;"> You are receiving this email because you signed up for the Daily ##SITE_NAME## alerts. If you prefer not to receive promotional email from ##SITE_NAME##, you can always <a style="color: #F7437A;" href="##UNSUBSCRIBE_LINK##" target="_blank">unsubscribe at anytime.</a> </p>\n                    <p style="border-top: 1px solid rgb(206, 206, 206); margin: 3px; font-size: 11px; font-family: Helvetica,Arial,sans-serif; color:#000; padding-top: 10px;"> Delivered by <a href="##SITE_URL##" title="##SITE_NAME##" target="_blank" style="color:#F7437A">##SITE_NAME##</a> </p></td>\n                </tr>\n              </tbody>\n            </table>\n          </div></td>\n      </tr>\n    </tbody>\n  </table>\n  <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;"  summary="Subscribtion Welcome Mail">\n    <tbody>\n      <tr>\n        <td style="padding: 10px; font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px;"> Need help? Have feedback? Feel free to <a target="_blank" title="Contact ##SITE_NAME##" style="color: #4D8427;" href="##CONTACT_US_LINK##">Contact Us</a> </td>\n      </tr>\n    </tbody>\n  </table>\n</div>', 'SITE_NAME, SITE_LOGO, FROM_EMAIL, LEARN_HOW_LINK, SITE_URL, REFERRAL_AMOUNT, REFER_FRIEND_LINK, FACEBOOK_LINK, TWITTER_LINK, RECENT_ITEMS, CONTACT_US_LINK,CONTACT_URL', 1),
(23, '2010-06-18 19:39:35', '2011-11-09 12:46:29', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Item invite', 'User send this mail if he invite user to view his item after his creation.', '##USERNAME## invited you to view the item on ##SITE_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\n  <table width="720" cellspacing="0" cellpadding="0" summary="Item Invite">\n    <tbody>\n      <tr>\n        <td align="center"><p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;"> Be sure to add <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox. </p></td>\n      </tr>\n    </tbody>\n  </table>\n  <div style="width: 670px; margin: 5px 0pt; padding: 20px; padding:20px 18px; border: 5px solid #24baa3; background-color: #dcdddb;">\n    <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;"  summary="Item Invite">\n      <tbody>\n        <tr>\n          <td align="center"><div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);"> <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a> </div></td>\n        </tr>\n        <tr>\n          <td style="padding: 20px 30px 5px;"><h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;"> Hi\n              ##TO_USER##, </h2>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">##USERNAME## invited you to view the item ##ITEM_NAME##</p>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;"><a href="##ITEM_LINK##" style="color: #F7437A;" title="##ITEM_LINK##" target="_blank">Click  to view the item</a></p>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;"></p></td>\n        </tr>\n        <tr>\n          <td><div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\n              <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;"> Thanks, </h4>\n              <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;"> ##SITE_NAME## - <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a> </h5>\n            </div></td>\n        </tr>\n      </tbody>\n    </table>\n    <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;"  summary="Item Invite">\n      <tbody>\n        <tr>\n          <td><p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;"> Need help? Have feedback? Feel free to <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a></p></td>\n        </tr>\n      </tbody>\n    </table>\n  </div>\n  <table width="720" cellspacing="0" cellpadding="0"  summary="Item Invite">\n    <tbody>\n      <tr>\n        <td align="center"><p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;"> Delivered by <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p></td>\n      </tr>\n    </tbody>\n  </table>\n</div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME, TO_USER, ITEM_NAME, ITEM_LINK,CONTACT_URL', 1),
(24, '2010-06-23 10:49:46', '2011-11-09 12:45:27', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Item gift mail', 'We will send this mail, after purchased a item for someone else.', 'Your friend gifted you a Item in ##SITE_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\n  <table width="720" cellspacing="0" cellpadding="0" summary="Item Gift Mail">\n    <tbody>\n      <tr>\n        <td align="center"><p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;"> Be sure to add <a href="mailto:mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox. </p></td>\n      </tr>\n    </tbody>\n  </table>\n  <div style="width: 670px; margin: 5px 0pt; padding: 20px; padding:20px 18px; border: 5px solid #24baa3; background-color: #dcdddb;">\n    <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;"  summary="Item Gift Mail">\n      <tbody>\n        <tr>\n          <td align="center"><div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);"> <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a> </div></td>\n        </tr>\n        <tr>\n          <td style="padding: 20px 30px 5px;"><h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;"> Hi\n              ##USERNAME##, </h2>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;"> Your friend ##FRIEND_NAME## gifted you a Item "##ITEM_TITLE##" from ##SITE_NAME##. </p>\n            <table width="100%" border="0"  summary="Item Gift Mail">\n              <tr>\n                <td width="32%" colspan="3"><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Purchased Details :</p></td>\n              </tr>\n              <tr>\n                <td width="32%"><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Item Name</p></td>\n                <td width="8%"><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p></td>\n                <td width="60%"><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">##ITEM_TITLE##</p></td>\n              </tr>\n              <tr>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Quantity</p></td>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p></td>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">##QUANTITY##</p></td>\n              <tr>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Amount</p></td>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p></td>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">##ITEM_AMOUNT##</p></td>\n              </tr>\n              <tr>\n                <td height="32"><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Purchased on</p></td>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p></td>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">##PURCHASE_ON##</p></td>\n              </tr>\n              <tr>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Item Status</p></td>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p></td>\n                <td><p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;"> ##ITEM_STATUS## </p></td>\n              </tr>\n            </table>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">Note:You will receive the pass once the item get tipped.</p>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;"></p></td>\n        </tr>\n        <tr>\n          <td><div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\n              <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;"> Thanks, </h4>\n              <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;"> ##SITE_NAME## - <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a> </h5>\n            </div></td>\n        </tr>\n      </tbody>\n    </table>\n    <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;"  summary="Item Gift Mail">\n      <tbody>\n        <tr>\n          <td><p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;"> Need help? Have feedback? Feel free to <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a></p></td>\n        </tr>\n      </tbody>\n    </table>\n  </div>\n  <table width="720" cellspacing="0" cellpadding="0"  summary="Item Gift Mail">\n    <tbody>\n      <tr>\n        <td align="center"><p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;"> Delivered by <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p></td>\n      </tr>\n    </tbody>\n  </table>\n</div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME, ITEM_TITLE, QUANTITY, ITEM_AMOUNT, GIFT_RECEIVER', 1),
(25, '2011-06-25 17:36:39', '2011-08-03 13:07:11', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'New Message', 'we will send this mail, when a user get new message', '##USERNAME## sent you a message on ##SITE_NAME##...', 'Hi,\n\n##USERNAME## sent you a message.\n\n--------------------\n##MESSAGE##\n--------------------\n\nTo view this message, follow the link below:\n##MESSAGE_LINK##\n\n\nThanks,\n##SITE_NAME##\n##SITE_URL##', 'USERNAME,MESSAGE,MESSAGE_LINK,SITE_NAME', 0),
(26, '2011-06-27 19:05:27', '2011-11-09 12:41:19', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Grab User Alert', 'We will send this mail, when a user grab item in your city', 'Your friend grabbed new item...', '<div style="padding: 10px; width: 720px; margin: auto;">\n  <table width="720" cellspacing="0" cellpadding="0" summary="Grab User Alert">\n    <tbody>\n      <tr>\n        <td align="center"><p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;"> Be sure to add <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox. </p></td>\n      </tr>\n    </tbody>\n  </table>\n  <div style="width: 670px; margin: 5px 0pt; padding: 20px; background-repeat: no-repeat; border: 5px solid #24baa3; background-color: #dcdddb;">\n    <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;"  summary="Grab User Alert">\n      <tbody>\n        <tr>\n          <td align="center"><div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);"> <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a> </div></td>\n        </tr>\n        <tr>\n          <td style="padding: 20px 30px 5px;"><h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;"> Dear ##PROFILEUSERNAME##, </h2>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">Your friend "##GRABUSER##" grabbed new item in "##MERCHANT##". Please click the link to see the details: <a href="##LINK##" title="##ITEM_NAME##" target="_blank" style="color:#F7437A;">##ITEM_NAME##</a></p>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;"></p></td>\n        </tr>\n        <tr>\n          <td><div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\n              <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;"> Thanks, </h4>\n              <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;"> ##SITE_NAME## - <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a> </h5>\n            </div></td>\n        </tr>\n      </tbody>\n    </table>\n    <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;"  summary="Grab User Alert">\n      <tbody>\n        <tr>\n          <td><p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;"> Need help? Have feedback? Feel free to <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a> </p></td>\n        </tr>\n      </tbody>\n    </table>\n  </div>\n  <table width="720" cellspacing="0" cellpadding="0"  summary="Grab User Alert">\n    <tbody>\n      <tr>\n        <td align="center"><p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;"> Delivered by <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p></td>\n      </tr>\n    </tbody>\n  </table>\n</div>', '', 1),
(27, '2009-09-11 19:52:06', '2011-01-12 07:11:22', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Interest of the day', 'This email will be sent to all the subscribers of a particular city, when there is a item available for that particular day.', '##ITEM_NAME##', '<div style="border: 5px solid #bfe27d; margin: 5px 0pt; padding: 20px; width: 700px; background-color: ebfdff; background-repeat: no-repeat;"><br /><table style="background-color: #fff;" cellspacing="0" cellpadding="0" width="100%"><br /><tbody><br /><tr><br /><td colspan="2"><br /><div style="border-bottom: 4px solid #bfe27d; margin: 0pt; min-height: 104px;"><br /><table cellspacing="0" cellpadding="0" width="700" height="104"><br /><tbody><br /><tr><br /><td style="padding: 18px 0pt 0pt 15px; width: 110px; min-height: 37px;" valign="top"><br /><div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid #d6d6d6;"><a style="color: #ffffff;" title="##SITE_NAME##" href="##SITE_URL##" target="_blank"><img src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" /></a></div><br /></td><br /><td style="padding-left: 15px; width: 250px; padding-top: 16px;" valign="top"><br /><table><br /><tbody><br /><tr><br /><td style="margin: 0pt; color: #00b5c8; font-size: 12px; font-weight: bold; font-family: Helvetica,Arial,sans-serif;">The Daily Item for your interest</td><br /></tr><br /><tr><br /><td style="margin: 0pt; padding: 5px 0pt 0pt; color: #00b5c8; font-size: 20px; font-weight: bold; font-family: Helvetica,Arial,sans-serif;">##INTEREST_NAME##</td><br /></tr><br /></tbody><br /></table><br /></td><br /><td style="padding-right: 20px; padding-top: 21px;" align="right" valign="top"><br /><table cellspacing="0" cellpadding="0" width="225"><br /><tbody><br /><tr><br /><td style="margin: 0pt; color: #00b5c8; font-size: 12px; font-family: Helvetica,Arial,sans-serif;" align="right">##DATE##</td><br /></tr><br /><tr><br /><td style="padding-top: 15px;" align="right"><br /><p style="margin: 0pt; color: #00b5c8; font-size: 11px; font-family: Helvetica,Arial,sans-serif; font-weight: bold;">follow&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; us: <a style="margin-left: 10px;" title="Become friends with ##SITE_URL## on Facebook" href="##FACEBOOK_URL##" target="_blank"><img style="border: medium none; vertical-align: middle;" src="##FACEBOOK_IMAGE##" alt="[Image: Facebook]" /></a> <a style="margin-left: 10px;" title="Follow ##SITE_NAME## on Twitter" href="##TWITTER_URL##" target="_blank"><img style="border: medium none; vertical-align: middle;" src="##TWITTER_IMAGE##" alt="[Image: Follow ##SITE_NAME## on Twitter]" /></a></p><br /></td><br /></tr><br /></tbody><br /></table><br /></td><br /></tr><br /></tbody><br /></table><br /></div><br /></td><br /></tr><br /><tr><br /><td style="border-top: 10px solid #e3e4e6; padding: 20px 0pt 25px;" valign="top"><br /><table cellspacing="0" cellpadding="0" width="100%"><br /><tbody><br /><tr><br /><td colspan="2"><br /><h1 style="margin: 0pt; padding: 0pt 20px 20px 40px;"><a style="margin: 0pt; text-decoration: none; color: #00b5c8; font-size: 26px; font-weight: bold; font-family: Helvetica,Arial,sans-serif;" title="##SITE_NAME## - ##ITEM_LINK##" href="##ITEM_LINK##" target="_blank">##ITEM_NAME##</a></h1><br /></td><br /></tr><br /><tr><br /><td style="padding: 0pt 15px 0pt 4px; width: 260px;" valign="top"><br /><table style="background-repeat: no-repeat; background-position: left;" cellspacing="0" cellpadding="0" width="260" height="84" background="##BACKGROUND##"><br /><tbody><br /><tr><br /><td style="padding-left: 45px; font-size: 20px; color: #00b5c8; font-family: Helvetica,Arial,sans-serif; height: 84px;"><br /><div>##BUY_PRICE##</div><br /></td><br /><td style="padding-top: 5px;"><a style="background: url(##BTN_IMAGE##) no-repeat left top; float: left; width: 91px; height: 41px; font-weight: bold; color: #000; text-decoration: none; font-size: 15px; padding: 5px 20px; text-align: center;" title="##SITE_NAME## - ##ITEM_LINK##" href="##ITEM_URL##" target="_blank">See Today''s Items</a></td><br /></tr><br /></tbody><br /></table><br /><div style="padding: 8px 0pt 0pt 32px;"><br /><table cellspacing="0" cellpadding="0" width="228"><br /><tbody><br /><tr><br /><td style="border: 1px solid #e8e8e8; padding: 0pt 5px 10px 18px; width: 217px; min-height: 116px;"><br /><table cellspacing="0" cellpadding="0"><br /><tbody><br /><tr><br /><td style="margin: 0pt; padding: 10px 0pt 7px; font-weight: bold; font-size: 11px; color: #000000; font-family: Helvetica,Arial,sans-serif;">##END_DATE##</td><br /></tr><br /></tbody><br /></table><br /></td><br /></tr><br /></tbody><br /></table><br /><table cellspacing="0" cellpadding="0" width="228"><br /><tbody><br /><tr><br /><td style="border: 1px solid #e8e8e8; padding: 0pt 5px 10px 18px; width: 217px; min-height: 116px;"><br /><table cellspacing="0" cellpadding="0"><br /><tbody><br /><tr><br /><td style="margin: 0pt; padding: 10px 0pt 7px; font-weight: bold; font-size: 11px; color: #000000; font-family: Helvetica,Arial,sans-serif;">Merchant Information:</td><br /></tr><br /><tr><br /><td style="margin: 0pt; padding: 0pt; font-weight: bold; font-size: 12px; color: #000000; font-family: Helvetica,Arial,sans-serif;">##MERCHANT_NAME##</td><br /></tr><br /><tr><br /><td style="margin: 0pt; padding: 0pt; font-size: 12px; color: #000000; font-family: Helvetica,Arial,sans-serif;"><a style="color: #00b5c8;" title="##MERCHANT_NAME## website" href="#" target="_blank">##MERCHANT_WEBSITE##</a></td><br /></tr><br /><tr><br /><td style="margin: 0pt; padding: 5px 0pt 0pt; font-weight: bold; font-size: 12px; color: #000000; font-family: Helvetica,Arial,sans-serif;">Locations:</td><br /></tr><br /><tr><br /><td style="margin: 0pt; padding: 0pt; font-size: 12px; color: #000000; font-family: Helvetica,Arial,sans-serif;">##MERCHANT_ADDRESS##</td><br /></tr><br /></tbody><br /></table><br /></td><br /></tr><br /></tbody><br /></table><br /></div><br /></td><br /><td valign="top"><a title="##SITE_NAME## - ##ITEM_NAME##" href="##ITEM_LINK##" target="_blank"><img src="##ITEM_IMAGE##" alt="[Image: ##ITEM_NAME##]" /></a></td><br /></tr><br /><tr><br /><td style="padding: 10px 20px 0pt 35px;" colspan="2"><br /><table style="border: 1px solid #dad8a0; background-color: #fffdc1; margin-top: 2px;" width="100%"><br /><tbody><br /><tr><br /><td style="padding: 0pt 10px; font-family: Helvetica,Arial,sans-serif; color: #000000; font-size: 14px; line-height: 16px;"><br /><ul style="padding: 0pt;"><br /><li style="list-style-type: none; list-style-position: outside;"><br /><p>The wait is over: Who will Live Off ##SITE_NAME##&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; for the next year? Go to <a href="##SITE_URL##" target="_blank">##SITE_URL##</a> to find out!</p><br /></li><br /></ul><br /></td><br /></tr><br /></tbody><br /></table><br /></td><br /></tr><br /></tbody><br /></table><br /></td><br /></tr><br /></tbody><br /></table><br /><table style="background-color: #e6e6e6; margin-top: 2px;" width="100%"><br /><tbody><br /><tr><br /><td style="padding: 10px; font-family: Helvetica,Arial,sans-serif; color: #000; font-weight: bold; font-size: 12px; text-align: center; line-height: 16px;">Need help? Have feedback? Feel free to <a style="color: #00b5c8;" title="Contact ##SITE_NAME##" href="##CONTACT_US##" target="_blank">Contact Us</a></td><br /></tr><br /></tbody><br /></table><br /></div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME, ITEM_LINK, ITEM_NAME, BUY_PRICE, MERCHANT_NAME, MERCHANT_SITE, MERCHANT_ADDRESS, UNSUBSCRIBE_LINK, CONTACT_URL', 1);
INSERT INTO `email_templates` (`id`, `created`, `modified`, `from`, `reply_to`, `name`, `description`, `subject`, `email_content`, `email_variables`, `is_html`) VALUES
(28, '2010-06-23 10:49:46', '2011-11-09 12:45:27', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Referrer Booked Mail', 'We will send this mail, after purchased a item booked user was referred by an user.', 'User referred by you was booked an item in ##SITE_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\n  <table width="720" cellspacing="0" cellpadding="0" summary="Referrer Booked Mail">\n    <tbody>\n      <tr>\n        <td align="center"><p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;"> Be sure to add <a href="mailto:mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox. </p></td>\n      </tr>\n    </tbody>\n  </table>\n  <div style="width: 670px; margin: 5px 0pt; padding: 20px; padding:20px 18px; border: 5px solid #24baa3; background-color: #dcdddb;">\n    <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;"  summary="Referrer Booked Mail">\n      <tbody>\n        <tr>\n          <td align="center"><div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);"> <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a> </div></td>\n        </tr>\n        <tr>\n          <td style="padding: 20px 30px 5px;">\n            <h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;"> Hi ##USERNAME##, </h2>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">##FRIEND_USERNAME## referred by you was booked an item "##ITEM_TITLE##" in ##SITE_NAME##.</p>\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;line-height: 2px;">To view this item, please visit the below link,</p>\n	    <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;line-height: 2px;"><a href="##ITEM_LINK##">##ITEM_LINK##</a></p>\n        </td></tr>\n        <tr>\n          <td><div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\n              <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;"> Thanks, </h4>\n              <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;"> ##SITE_NAME## - <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a> </h5>\n            </div></td>\n        </tr>\n      </tbody>\n    </table>\n    <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;"  summary="Referrer Booked Mail">\n      <tbody>\n        <tr>\n          <td><p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;"> Need help? Have feedback? Feel free to <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a></p></td>\n        </tr>\n      </tbody>\n    </table>\n  </div>\n  <table width="720" cellspacing="0" cellpadding="0"  summary="Referrer Booked Mail">\n    <tbody>\n      <tr>\n        <td align="center"><p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;"> Delivered by <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p></td>\n      </tr>\n    </tbody>\n  </table>\n</div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME, FRIEND_USERNAME, ITEM_TITLE, ITEM_LINK', 1),
(29, '2010-06-23 10:49:46', '2011-11-09 12:45:27', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Referrer Registered Mail', 'We will send this mail, after purchased a item booked user was referred by an user.', 'User registered using your invitation in ##SITE_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n  <table width="720" cellspacing="0" cellpadding="0" summary="Referrer Registered Mail">\r\n    <tbody>\r\n      <tr>\r\n        <td align="center"><p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;"> Be sure to add <a href="mailto:mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox. </p></td>\r\n      </tr>\r\n    </tbody>\r\n  </table>\r\n  <div style="width: 670px; margin: 5px 0pt; padding: 20px; padding:20px 18px; border: 5px solid #24baa3; background-color: #dcdddb;">\r\n    <table width="100%" style="background-color:#f3f4f2; border:2px solid #fff;"  summary="Referrer Registered Mail">\r\n      <tbody>\r\n        <tr>\r\n          <td align="center"><div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);"> <a href="##SITE_URL##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##" /></a> </div></td>\r\n        </tr>\r\n        <tr>\r\n          <td style="padding: 20px 30px 5px;">\r\n            <h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;"> Hi ##USERNAME##, </h2>\r\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">User ##FRIEND_USERNAME## registered using your invitation in ##SITE_NAME##.</p>\r\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">To follow this user, please visit the below link,<br /><a href="##USER_LINK##">##USER_LINK##</a></p\r\n	  </td>\r\n        </tr>\r\n        <tr>\r\n          <td><div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\r\n              <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #545454;"> Thanks, </h4>\r\n              <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;"> ##SITE_NAME## - <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_URL##</a> </h5>\r\n            </div></td>\r\n        </tr>\r\n      </tbody>\r\n    </table>\r\n    <table width="100%" style="background-color: #b9dc75; border:2px solid #a0ca4e;"  summary="Referrer Registered Mail">\r\n      <tbody>\r\n        <tr>\r\n          <td><p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;"> Need help? Have feedback? Feel free to <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a></p></td>\r\n        </tr>\r\n      </tbody>\r\n    </table>\r\n  </div>\r\n  <table width="720" cellspacing="0" cellpadding="0"  summary="Referrer Registered Mail">\r\n    <tbody>\r\n      <tr>\r\n        <td align="center"><p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;"> Delivered by <a href="##SITE_URL##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p></td>\r\n      </tr>\r\n    </tbody>\r\n  </table>\r\n</div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_URL, SITE_NAME, USERNAME, FRIEND_USERNAME, USER_LINK', 1),
(30, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Admin Approve Affiliate', 'We will send this mail to user, when affiliate request is approved by administrator.', 'Your ##SITE_NAME## affiliate account has been activated', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n  <table width="720px" cellspacing="0" cellpadding="0">\r\n    <tbody>\r\n      <tr>\r\n        <td align="center"><p style="text-align: center; font-size: 11px; color: rgb(146, 146, 146); margin: 3px;"> Be sure to add <a href="mailto:##FROM_EMAIL##" style="color: #F7437A;" title="Add ##FROM_EMAIL## to your wishlist" target="_blank">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox. </p></td>\r\n      </tr>\r\n    </tbody>\r\n  </table>\r\n  <div style="width: 670px; margin: 5px 0pt; padding: 20px; background-repeat: no-repeat; border: 5px solid #24baa3; background-color: #dcdddb;">\r\n    <table width="100%" style="background-color: #f3f4f2;">\r\n      <tbody>\r\n        <tr>\r\n          <td align="center"><div style="padding: 12px; margin: 0pt 30px; border-bottom: 1px solid rgb(214, 214, 214);"> <a href="##SITE_LINK##" style="color: rgb(255, 255, 255);" title="##SITE_NAME##" target="_blank"><img alt="[Image: ##SITE_NAME##]" src="##SITE_LOGO##"></a> </div></td>\r\n        </tr>\r\n        <tr>\r\n          <td style="padding: 20px 30px 5px;"><h2 style="color: rgb(84, 84, 84); margin: 0pt 20px 5px; font-family: Helvetica,Arial,sans-serif; font-size: 18px;"> Hi          ##USERNAME##, </h2>\r\n            <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">Your ##SITE_NAME## affiliate account has been activated.</p></td>\r\n        </tr>\r\n        <tr>\r\n          <td><div style="border-top: 1px solid rgb(214, 214, 214); padding: 15px 30px 25px; margin: 0pt 30px;">\r\n              <h4 style="font-family: Helvetica,Arial,sans-serif; font-size: 22px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #F7437A;"> Thanks, </h4>\r\n              <h5 style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;"> ##SITE_NAME## - <a href="##SITE_LINK##" style="color: #F7437A;" title="##SITE_NAME## - Collective Buying Power" target="_blank">##SITE_LINK##</a> </h5>\r\n            </div></td>\r\n        </tr>\r\n      </tbody>\r\n    </table>\r\n    <table width="100%" style="margin-top: 2px; background-color: #b9dc75; border:2px solid #a0ca4e;">\r\n      <tbody>\r\n        <tr>\r\n          <td><p style="font-family: Helvetica,Arial,sans-serif; color: #535353; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;"> Need help? Have feedback? Feel free to <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#4D8427;">Contact Us</a> </p></td>\r\n        </tr>\r\n      </tbody>\r\n    </table>\r\n  </div>\r\n  <table width="720px" cellspacing="0" cellpadding="0">\r\n    <tbody>\r\n      <tr>\r\n        <td align="center"><p style="font-size: 11px; color: rgb(146, 146, 146); margin: 3px; padding-top: 10px;"> Delivered by <a href="##SITE_LINK##" style="color: #F7437A;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p></td>\r\n      </tr>\r\n    </tbody>\r\n  </table>\r\n</div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_LINK, SITE_NAME, USERNAME,CONTACT_URL', 1);

-- --------------------------------------------------------

--
-- Table structure for table `friend_statuses`
--

DROP TABLE IF EXISTS `friend_statuses`;
CREATE TABLE IF NOT EXISTS `friend_statuses` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='friends status details';

--
-- Dumping data for table `friend_statuses`
--

INSERT INTO `friend_statuses` (`id`, `created`, `modified`, `name`) VALUES
(1, '2010-05-13 09:58:07', '2010-05-13 09:58:09', 'Pending'),
(2, '2010-05-13 09:58:07', '2010-05-13 09:58:07', 'Approved'),
(3, '2010-05-13 09:59:22', '2010-05-13 09:59:24', 'Reject');

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

DROP TABLE IF EXISTS `genders`;
CREATE TABLE IF NOT EXISTS `genders` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(100) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Gender details';

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `created`, `modified`, `name`) VALUES
(1, '2009-02-12 09:41:37', '2009-02-12 09:41:37', 'Male'),
(2, '2009-02-12 09:41:37', '2009-02-12 09:41:37', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `ips`
--

DROP TABLE IF EXISTS `ips`;
CREATE TABLE IF NOT EXISTS `ips` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `ip` varchar(255) collate utf8_unicode_ci default NULL,
  `host` varchar(100) collate utf8_unicode_ci NOT NULL,
  `city_id` bigint(20) NOT NULL,
  `state_id` bigint(20) NOT NULL,
  `country_id` bigint(20) NOT NULL,
  `timezone_id` bigint(20) NOT NULL,
  `latitude` float(10,6) NOT NULL,
  `longitude` float(10,6) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `city_id` (`city_id`),
  KEY `state_id` (`state_id`),
  KEY `country_id` (`country_id`),
  KEY `timezone_id` (`timezone_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ips`
--

INSERT INTO `ips` (`id`, `created`, `modified`, `ip`, `host`, `city_id`, `state_id`, `country_id`, `timezone_id`, `latitude`, `longitude`) VALUES
(1, '2011-11-22 07:49:40', '2011-11-22 07:49:40', '127.0.0.1', 'http://localhost/groupwithus/san-diego/users/register', 42550, 71, 109, 0, 13.083300, 80.283302);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(250) collate utf8_unicode_ci NOT NULL,
  `slug` varchar(255) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  `min_limit` int(11) unsigned NOT NULL,
  `max_limit` int(11) unsigned default NULL,
  `city_id` bigint(20) unsigned NOT NULL,
  `merchant_id` bigint(20) unsigned NOT NULL,
  `item_user_count` bigint(20) unsigned NOT NULL,
  `payment_failed_count` bigint(20) default '0',
  `buy_min_quantity_per_user` int(11) default '1',
  `buy_max_quantity_per_user` int(11) default '0',
  `item_tipped_time` datetime NOT NULL,
  `is_pass_mail_sent` tinyint(1) unsigned NOT NULL,
  `is_subscription_mail_sent` tinyint(1) NOT NULL default '0',
  `is_interest_mail_sent` tinyint(1) NOT NULL default '0',
  `item_status_id` int(2) unsigned NOT NULL,
  `bonus_amount` double(10,2) default '0.00',
  `commission_percentage` double(10,2) default '0.00',
  `total_commission_amount` double(10,2) default '0.00',
  `total_purchased_amount` double(10,2) default '0.00',
  `net_profit` double(10,2) default '0.00',
  `referred_purchase_count` bigint(20) default '0',
  `charity_id` int(11) default NULL,
  `total_charity_amount` double(10,2) NOT NULL default '0.00',
  `site_charity_amount` double(10,2) NOT NULL default '0.00',
  `seller_charity_amount` double(10,2) NOT NULL default '0.00',
  `charity_percentage` double(10,2) default '0.00',
  `item_category_id` bigint(20) NOT NULL,
  `menu` text collate utf8_unicode_ci NOT NULL,
  `price` double(10,2) NOT NULL,
  `is_tipped_item` tinyint(1) NOT NULL,
  `event_date` datetime NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `is_be_next` tinyint(1) NOT NULL,
  `be_next_increase_price` double(10,2) default NULL,
  `item_user_expired_count` bigint(20) default '0',
  `total_sales_lost_amount` double(10,2) default '0.00',
  `total_merchant_earned_amount` double(10,2) default '0.00',
  `total_affiliate_amount` double(10,2) default '0.00',
  `total_referral_amount` double(10,2) default '0.00',
  `item_user_pending_count` bigint(20) default '0',
  `item_user_available_count` bigint(20) default '0',
  `item_user_used_count` bigint(20) default '0',
  `item_user_canceled_count` bigint(20) default '0',
  PRIMARY KEY  (`id`),
  KEY `city_id` (`city_id`),
  KEY `slug` (`slug`),
  KEY `item_status_id` (`item_status_id`),
  KEY `user_id` (`user_id`),
  KEY `charity_id` (`charity_id`),
  KEY `item_category_id` (`item_category_id`),
  KEY `merchant_id` (`merchant_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `created`, `modified`, `user_id`, `name`, `slug`, `description`, `min_limit`, `max_limit`, `city_id`, `merchant_id`, `item_user_count`, `payment_failed_count`, `buy_min_quantity_per_user`, `buy_max_quantity_per_user`, `item_tipped_time`, `is_pass_mail_sent`, `is_subscription_mail_sent`, `is_interest_mail_sent`, `item_status_id`, `bonus_amount`, `commission_percentage`, `total_commission_amount`, `total_purchased_amount`, `net_profit`, `referred_purchase_count`, `charity_id`, `total_charity_amount`, `site_charity_amount`, `seller_charity_amount`, `charity_percentage`, `item_category_id`, `menu`, `price`, `is_tipped_item`, `event_date`, `start_date`, `end_date`, `is_be_next`, `be_next_increase_price`, `item_user_expired_count`, `total_sales_lost_amount`, `total_merchant_earned_amount`, `total_affiliate_amount`, `total_referral_amount`, `item_user_pending_count`, `item_user_available_count`, `item_user_used_count`, `item_user_canceled_count`) VALUES
(1, '2011-11-22 10:13:31', '2011-11-22 10:13:31', 4, 'Burger and pizza', 'burger-and-pizza', '<p>Burger and pizza</p>', 1, NULL, 0, 1, 0, 0, NULL, NULL, '0000-00-00 00:00:00', 0, 1, 0, 2, 0.00, 30.00, 0.00, 0.00, 0.00, 0, NULL, 0.00, 0.00, 0.00, NULL, 0, '<p>Burger and pizza</p>', 100.00, 0, '2012-01-06 03:00:00', '2011-11-22 10:19:08', '2011-12-30 03:00:00', 0, NULL, 0, 0.00, 0.00, 0.00, 0.00, 0, 0, 0, 0),
(2, '2011-11-22 10:17:01', '2011-11-22 10:17:01', 4, 'Pizza offer', 'pizza-offer', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.<br />Epsum factorial non deposit quid pro quo hic escorol. Olypian quarrels et gorilla congolium sic ad nauseum. Souvlaki ignitus carborundum e pluribus unum. Defacto lingo est igpay atinlay. Marquee selectus non provisio incongruous feline nolo contendre. Gratuitous octopus niacin, sodium glutimate. Quote meon an estimate et non interruptus stadium. Sic tempus fugit esperanto hiccup estrogen. Glorious baklava ex librus hup hey ad infinitum. Non sequitur condominium facile et geranium incognito. Epsum factorial non deposit quid pro quo hic escorol. Marquee selectus non provisio incongruous feline nolo contendre Olypian quarrels et gorilla congolium sic ad nauseum. Souvlaki ignitus carborundum e pluribus unum.</p>\n<p><br />Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc., li tot Europa usa li sam vocabularium. Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilit&aacute; de un nov lingua franca: on refusa continuar payar custosi traductores. It solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.<br />Ma quande lingues coalesce, li grammatica del resultant lingue es plu simplic e regulari quam ti del coalescent lingues. Li nov lingua franca va esser plu simplic e regulari quam li existent Europan lingues. It va esser tam simplic quam Occidental: in fact, it va esser Occidental. A un Angleso it va semblar un simplificat Angles, quam un skeptic Cambridge amico dit me que Occidental es.</p>', 1, NULL, 0, 1, 2, 0, NULL, NULL, '2011-11-22 13:30:57', 1, 1, 0, 5, 0.00, 30.00, 36.30, 121.00, 0.00, 0, NULL, 0.00, 0.00, 0.00, NULL, 0, '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.<br />Epsum factorial non deposit quid pro quo hic escorol. Olypian quarrels et gorilla congolium sic ad nauseum. Souvlaki ignitus carborundum e pluribus unum. Defacto lingo est igpay atinlay. Marquee selectus non provisio incongruous feline nolo contendre. Gratuitous octopus niacin, sodium glutimate. Quote meon an estimate et non interruptus stadium. Sic tempus fugit esperanto hiccup estrogen. Glorious baklava ex librus hup hey ad infinitum. Non sequitur condominium facile et geranium incognito. Epsum factorial non deposit quid pro quo hic escorol. Marquee selectus non provisio incongruous feline nolo contendre Olypian quarrels et gorilla congolium sic ad nauseum. Souvlaki ignitus carborundum e pluribus unum.</p>\n<p><br />Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc., li tot Europa usa li sam vocabularium. Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilit&aacute; de un nov lingua franca: on refusa continuar payar custosi traductores. It solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.<br />Ma quande lingues coalesce, li grammatica del resultant lingue es plu simplic e regulari quam ti del coalescent lingues. Li nov lingua franca va esser plu simplic e regulari quam li existent Europan lingues. It va esser tam simplic quam Occidental: in fact, it va esser Occidental. A un Angleso it va semblar un simplificat Angles, quam un skeptic Cambridge amico dit me que Occidental es.</p>', 60.00, 0, '2012-01-01 03:00:00', '2011-11-22 10:18:52', '2011-12-28 03:00:00', 1, 1.00, 0, 0.00, 84.70, 0.00, 0.00, 0, 1, 0, 0),
(3, '2011-11-22 10:28:32', '2011-11-22 10:28:32', 4, 'Ice Cream Festival', 'ice-cream-festival', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.Epsum factorial non deposit quid pro quo hic escorol. Olypian quarrels et gorilla congolium sic ad nauseum. Souvlaki ignitus carborundum e pluribus unum. Defacto lingo est igpay atinlay. Marquee selectus non provisio incongruous feline nolo contendre. Gratuitous octopus niacin, sodium glutimate. Quote meon an estimate et non interruptus stadium. Sic tempus fugit esperanto hiccup estrogen. Glorious baklava ex librus hup hey ad infinitum. Non sequitur condominium facile et geranium incognito. Epsum factorial non deposit quid pro quo hic escorol.</p>\n<p>&nbsp;</p>\n<p>Marquee selectus non provisio incongruous feline nolo contendre Olypian quarrels et gorilla congolium sic ad nauseum. Souvlaki ignitus carborundum e pluribus unum.Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc., li tot Europa usa li sam vocabularium. Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilit&aacute; de un nov lingua franca: on refusa continuar payar custosi traductores. It solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.Ma quande lingues coalesce, li grammatica del resultant lingue es plu simplic e regulari quam ti del coalescent lingues. Li nov lingua franca va esser plu simplic e regulari quam li existent Europan lingues. It va esser tam simplic quam Occidental: in fact, it va esser Occidental. A un Angleso it va semblar un simplificat Angles, quam un skeptic Cambridge amico dit me que Occidental es.</p>', 1, NULL, 0, 1, 2, 0, NULL, NULL, '2011-11-22 13:32:47', 1, 1, 0, 5, 0.00, 30.00, 72.00, 240.00, 0.00, 0, NULL, 0.00, 0.00, 0.00, NULL, 0, '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.Epsum factorial non deposit quid pro quo hic escorol. Olypian quarrels et gorilla congolium sic ad nauseum. Souvlaki ignitus carborundum e pluribus unum. Defacto lingo est igpay atinlay. Marquee selectus non provisio incongruous feline nolo contendre. Gratuitous octopus niacin, sodium glutimate. Quote meon an estimate et non interruptus stadium. Sic tempus fugit esperanto hiccup estrogen. Glorious baklava ex librus hup hey ad infinitum. Non sequitur condominium facile et geranium incognito. Epsum factorial non deposit quid pro quo hic escorol.</p>\n<p>&nbsp;</p>\n<p>Marquee selectus non provisio incongruous feline nolo contendre Olypian quarrels et gorilla congolium sic ad nauseum. Souvlaki ignitus carborundum e pluribus unum.Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc., li tot Europa usa li sam vocabularium. Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilit&aacute; de un nov lingua franca: on refusa continuar payar custosi traductores. It solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.Ma quande lingues coalesce, li grammatica del resultant lingue es plu simplic e regulari quam ti del coalescent lingues. Li nov lingua franca va esser plu simplic e regulari quam li existent Europan lingues. It va esser tam simplic quam Occidental: in fact, it va esser Occidental. A un Angleso it va semblar un simplificat Angles, quam un skeptic Cambridge amico dit me que Occidental es.</p>', 120.00, 0, '2011-12-27 03:00:00', '2011-11-22 10:41:32', '2011-12-26 03:00:00', 0, NULL, 0, 0.00, 168.00, 0.00, 0.00, 0, 1, 0, 0),
(4, '2011-11-22 10:40:29', '2011-11-22 10:40:29', 4, 'Sunday Lunch', 'sunday-lunch', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, NULL, 0, 1, 3, 0, NULL, NULL, '2011-11-22 12:53:26', 1, 1, 0, 5, 0.00, 30.00, 81.90, 273.00, 0.00, 0, NULL, 0.00, 0.00, 0.00, NULL, 0, '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 90.00, 0, '2011-12-25 03:00:00', '2011-11-22 10:41:28', '2011-12-24 03:00:00', 1, 1.00, 0, 0.00, 191.10, 0.00, 0.00, 0, 1, 0, 0),
(5, '2011-11-22 10:47:09', '2011-11-22 10:47:09', 4, 'Chinese Food', 'chinese-food', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, NULL, 0, 1, 0, 0, NULL, NULL, '0000-00-00 00:00:00', 0, 1, 0, 2, 0.00, 30.00, 0.00, 0.00, 0.00, 0, NULL, 0.00, 0.00, 0.00, NULL, 0, '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 75.00, 0, '2011-12-26 03:00:00', '2011-11-22 10:53:37', '2011-12-25 03:00:00', 0, NULL, 0, 0.00, 0.00, 0.00, 0.00, 0, 0, 0, 0),
(6, '2011-11-22 11:03:15', '2011-11-22 11:03:15', 5, 'Dinner Together', 'dinner-together', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 1, NULL, 0, 2, 0, 0, NULL, NULL, '0000-00-00 00:00:00', 0, 1, 0, 2, 0.00, 30.00, 0.00, 0.00, 0.00, 0, NULL, 0.00, 0.00, 0.00, 2.00, 0, '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 130.00, 0, '2012-01-10 03:00:00', '2011-11-22 11:04:55', '2012-01-04 03:00:00', 1, 5.00, 0, 0.00, 0.00, 0.00, 0.00, 0, 0, 0, 0),
(7, '2012-02-21 07:17:05', '2012-02-21 07:17:05', 1, 'Veg thali', 'veg-thali', '', 1, NULL, 0, 1, 0, 0, NULL, NULL, '0000-00-00 00:00:00', 0, 0, 0, 2, 0.00, 10.00, 0.00, 0.00, 0.00, 0, NULL, 0.00, 0.00, 0.00, 2.00, 0, '<div id="lipsum">\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>\r\n<li>Pellentesque hendrerit eleifend eros, a consequat justo iaculis non.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Integer eu felis in odio ullamcorper malesuada mollis ut elit.</li>\r\n<li>Pellentesque molestie lobortis risus, id suscipit justo tristique quis.</li>\r\n<li>Praesent quis sapien mauris, in faucibus leo.</li>\r\n<li>Fusce pulvinar porttitor mi, non porttitor risus fringilla sed.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Aliquam hendrerit semper lorem, nec hendrerit urna egestas sit amet.</li>\r\n<li>Aliquam condimentum mauris nec arcu tempus et commodo sapien auctor.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Integer vitae odio ante, ut interdum magna.</li>\r\n<li>Proin aliquet augue sit amet nisl euismod commodo.</li>\r\n<li>Cras pulvinar malesuada elit, auctor malesuada elit porttitor ac.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Quisque ut arcu id orci hendrerit tincidunt.</li>\r\n<li>Vestibulum pellentesque mi sit amet odio dictum vel aliquam justo convallis.</li>\r\n<li>Maecenas non massa ut dui suscipit auctor a sed erat.</li>\r\n<li>Cras eu velit vitae quam varius faucibus ut quis urna.</li>\r\n<li>Curabitur imperdiet ante venenatis nibh commodo iaculis.</li>\r\n<li>Nullam ut neque tellus, et facilisis dui.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n</div>', 100.00, 0, '2012-07-06 03:00:00', '2012-02-21 07:17:05', '2012-06-20 03:00:00', 0, NULL, 0, 0.00, 0.00, 0.00, 0.00, 0, 0, 0, 0),
(8, '2012-02-21 07:19:01', '2012-02-22 11:26:56', 1, 'South Indian veg.  thali', 'south-indian-veg-thali', '', 1, NULL, 0, 1, 0, 0, NULL, NULL, '0000-00-00 00:00:00', 0, 0, 0, 2, 0.00, 10.00, 0.00, 0.00, 0.00, 0, NULL, 0.00, 0.00, 0.00, 2.00, 0, '<div id="lipsum">\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>\r\n<li>Pellentesque hendrerit eleifend eros, a consequat justo iaculis non.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Integer eu felis in odio ullamcorper malesuada mollis ut elit.</li>\r\n<li>Pellentesque molestie lobortis risus, id suscipit justo tristique quis.</li>\r\n<li>Praesent quis sapien mauris, in faucibus leo.</li>\r\n<li>Fusce pulvinar porttitor mi, non porttitor risus fringilla sed.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Aliquam hendrerit semper lorem, nec hendrerit urna egestas sit amet.</li>\r\n<li>Aliquam condimentum mauris nec arcu tempus et commodo sapien auctor.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Integer vitae odio ante, ut interdum magna.</li>\r\n<li>Proin aliquet augue sit amet nisl euismod commodo.</li>\r\n<li>Cras pulvinar malesuada elit, auctor malesuada elit porttitor ac.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Quisque ut arcu id orci hendrerit tincidunt.</li>\r\n<li>Vestibulum pellentesque mi sit amet odio dictum vel aliquam justo convallis.</li>\r\n<li>Maecenas non massa ut dui suscipit auctor a sed erat.</li>\r\n<li>Cras eu velit vitae quam varius faucibus ut quis urna.</li>\r\n<li>Curabitur imperdiet ante venenatis nibh commodo iaculis.</li>\r\n<li>Nullam ut neque tellus, et facilisis dui.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n</div>', 100.00, 0, '2012-07-06 03:00:00', '2012-02-21 07:19:01', '2012-06-20 03:00:00', 0, NULL, 0, 0.00, 0.00, 0.00, 0.00, 0, 0, 0, 0),
(9, '2012-02-21 07:20:12', '2012-02-21 07:21:58', 1, 'Special Veg thali', 'special-veg-thali', '', 1, NULL, 0, 1, 0, 0, NULL, NULL, '0000-00-00 00:00:00', 0, 0, 0, 2, 0.00, 10.00, 0.00, 0.00, 0.00, 0, NULL, 0.00, 0.00, 0.00, 2.00, 0, '<div id="lipsum">\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>\r\n<li>Pellentesque hendrerit eleifend eros, a consequat justo iaculis non.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Integer eu felis in odio ullamcorper malesuada mollis ut elit.</li>\r\n<li>Pellentesque molestie lobortis risus, id suscipit justo tristique quis.</li>\r\n<li>Praesent quis sapien mauris, in faucibus leo.</li>\r\n<li>Fusce pulvinar porttitor mi, non porttitor risus fringilla sed.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Aliquam hendrerit semper lorem, nec hendrerit urna egestas sit amet.</li>\r\n<li>Aliquam condimentum mauris nec arcu tempus et commodo sapien auctor.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Integer vitae odio ante, ut interdum magna.</li>\r\n<li>Proin aliquet augue sit amet nisl euismod commodo.</li>\r\n<li>Cras pulvinar malesuada elit, auctor malesuada elit porttitor ac.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Quisque ut arcu id orci hendrerit tincidunt.</li>\r\n<li>Vestibulum pellentesque mi sit amet odio dictum vel aliquam justo convallis.</li>\r\n<li>Maecenas non massa ut dui suscipit auctor a sed erat.</li>\r\n<li>Cras eu velit vitae quam varius faucibus ut quis urna.</li>\r\n<li>Curabitur imperdiet ante venenatis nibh commodo iaculis.</li>\r\n<li>Nullam ut neque tellus, et facilisis dui.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n</div>', 100.00, 0, '2012-07-06 03:00:00', '2012-02-21 07:20:12', '2012-06-20 03:00:00', 0, NULL, 0, 0.00, 0.00, 0.00, 0.00, 0, 0, 0, 0),
(10, '2012-02-21 07:28:26', '2012-02-21 07:28:26', 1, 'Special dosa', 'special-dosa', '', 25, 250, 0, 1, 0, 0, NULL, NULL, '0000-00-00 00:00:00', 0, 0, 0, 2, 0.00, 15.00, 0.00, 0.00, 0.00, 0, NULL, 0.00, 0.00, 0.00, NULL, 0, '<ul>\r\n<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>\r\n<li>Pellentesque hendrerit eleifend eros, a consequat justo iaculis non.</li>\r\n</ul>\r\n<ul>\r\n<li>Quisque ut arcu id orci hendrerit tincidunt.</li>\r\n<li>Vestibulum pellentesque mi sit amet odio dictum vel aliquam justo convallis.</li>\r\n<li>Maecenas non massa ut dui suscipit auctor a sed erat.</li>\r\n<li>Cras eu velit vitae quam varius faucibus ut quis urna.</li>\r\n<li>Curabitur imperdiet ante venenatis nibh commodo iaculis.</li>\r\n<li>Nullam ut neque tellus, et facilisis dui.</li>\r\n</ul>', 75.00, 1, '2012-07-11 03:00:00', '2012-02-21 07:28:26', '2012-06-05 03:00:00', 1, 2.00, 0, 0.00, 0.00, 0.00, 0.00, 0, 0, 0, 0),
(11, '2012-02-21 07:31:11', '2012-02-22 11:27:21', 1, 'South Indian dinner', 'south-indian-dinner', '', 25, 250, 0, 1, 3, 0, NULL, NULL, '0000-00-00 00:00:00', 0, 0, 0, 2, 0.00, 15.00, 115.50, 770.00, 0.00, 0, NULL, 0.00, 0.00, 0.00, NULL, 0, '<ul>\r\n<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>\r\n<li>Pellentesque hendrerit eleifend eros, a consequat justo iaculis non.</li>\r\n</ul>\r\n<ul>\r\n<li>Quisque ut arcu id orci hendrerit tincidunt.</li>\r\n<li>Vestibulum pellentesque mi sit amet odio dictum vel aliquam justo convallis.</li>\r\n<li>Maecenas non massa ut dui suscipit auctor a sed erat.</li>\r\n<li>Cras eu velit vitae quam varius faucibus ut quis urna.</li>\r\n<li>Curabitur imperdiet ante venenatis nibh commodo iaculis.</li>\r\n<li>Nullam ut neque tellus, et facilisis dui.</li>\r\n</ul>', 250.00, 1, '2012-07-11 03:00:00', '2012-02-21 07:31:11', '2012-06-05 03:00:00', 1, 10.00, 0, 0.00, 654.50, 0.00, 0.00, 3, 0, 0, 0),
(12, '2012-02-21 09:52:56', '2012-02-21 09:53:53', 2, 'cheese piza', 'cheese-piza', '', 1, 2, 0, 2, 2, 0, NULL, NULL, '2012-02-21 09:53:51', 1, 0, 0, 6, 0.00, 10.00, 5.00, 50.00, 0.00, 0, NULL, 0.00, 0.00, 0.00, NULL, 0, '<ul>\r\n<li>Quisque ut arcu id orci hendrerit tincidunt.</li>\r\n<li>Vestibulum pellentesque mi sit amet odio dictum vel aliquam justo convallis.</li>\r\n<li>Maecenas non massa ut dui suscipit auctor a sed erat.</li>\r\n<li>Cras eu velit vitae quam varius faucibus ut quis urna.</li>\r\n<li>Curabitur imperdiet ante venenatis nibh commodo iaculis.</li>\r\n<li>Nullam ut neque tellus, et facilisis dui.</li>\r\n</ul>', 25.00, 0, '2012-02-23 03:00:00', '2012-02-21 09:52:56', '2012-02-21 09:53:53', 0, NULL, 0, 0.00, 45.00, 0.00, 0.00, 0, 2, 0, 0),
(13, '2012-02-21 10:18:59', '2012-02-21 10:18:59', 1, 'Ice creem', 'ice-creem', '', 1, NULL, 0, 2, 7, 0, NULL, NULL, '2012-02-21 11:17:25', 1, 0, 0, 5, 5.00, 2.00, 26.00, 1050.00, 0.00, 0, NULL, 0.00, 0.00, 0.00, NULL, 0, '<ul>\r\n<li>Quisque ut arcu id orci hendrerit tincidunt.</li>\r\n<li>Vestibulum pellentesque mi sit amet odio dictum vel aliquam justo convallis.</li>\r\n<li>Maecenas non massa ut dui suscipit auctor a sed erat.</li>\r\n<li>Cras eu velit vitae quam varius faucibus ut quis urna.</li>\r\n<li>Curabitur imperdiet ante venenatis nibh commodo iaculis.</li>\r\n<li>Nullam ut neque tellus, et facilisis dui.</li>\r\n</ul>', 150.00, 0, '2012-03-03 03:00:00', '2012-02-21 10:18:59', '2012-02-29 03:00:00', 0, NULL, 0, 0.00, 1024.00, 0.00, 0.00, 0, 1, 0, 0),
(14, '2012-02-21 12:58:16', '2012-02-23 06:25:10', 1, 'Ice creem treat', 'ice-creem-treat', '', 1, NULL, 0, 1, 0, 0, NULL, NULL, '0000-00-00 00:00:00', 0, 0, 0, 2, 0.00, 10.00, 0.00, 0.00, 0.00, 0, NULL, 0.00, 0.00, 0.00, NULL, 0, '<p>sample</p>', 25.00, 0, '2012-02-29 03:00:00', '2012-02-21 12:58:16', '2012-02-29 03:00:00', 0, NULL, 0, 0.00, 0.00, 0.00, 0.00, 0, 0, 0, 0),
(15, '2012-02-23 06:01:45', '2012-02-23 06:01:45', 1, 'Pizza Fest', 'pizza-fest', '', 25, 100, 0, 2, 0, 0, 1, 10, '0000-00-00 00:00:00', 0, 0, 0, 2, 0.00, 10.00, 0.00, 0.00, 0.00, 0, NULL, 0.00, 0.00, 0.00, NULL, 0, '<ul>\n<li>Quisque ut arcu id orci hendrerit tincidunt.</li>\n<li>Vestibulum pellentesque mi sit amet odio dictum vel aliquam justo  convallis.</li>\n<li>Maecenas non massa ut dui suscipit auctor a sed erat.</li>\n<li>Cras eu velit vitae quam varius faucibus ut quis urna.</li>\n<li>Curabitur imperdiet ante venenatis nibh commodo iaculis.</li>\n<li>Nullam ut neque tellus, et facilisis dui.</li>\n</ul>', 50.00, 1, '2012-04-10 03:00:00', '2012-02-23 06:01:45', '2012-04-05 03:00:00', 1, 5.00, 0, 0.00, 0.00, 0.00, 0.00, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

DROP TABLE IF EXISTS `item_categories`;
CREATE TABLE IF NOT EXISTS `item_categories` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `slug` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`id`, `created`, `modified`, `name`, `slug`) VALUES
(1, '2012-02-22 11:22:02', '2012-02-22 11:22:02', 'Indian', 'indian'),
(2, '2012-02-22 11:22:18', '2012-02-22 11:22:18', 'South Indian', 'south-indian'),
(3, '2012-02-23 05:52:02', '2012-02-23 05:52:02', 'Pizza', 'pizza');

-- --------------------------------------------------------

--
-- Table structure for table `item_categories_items`
--

DROP TABLE IF EXISTS `item_categories_items`;
CREATE TABLE IF NOT EXISTS `item_categories_items` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `item_category_id` bigint(20) NOT NULL,
  `item_id` varchar(20) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `item_category_id` (`item_category_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_categories_items`
--

INSERT INTO `item_categories_items` (`id`, `created`, `modified`, `item_category_id`, `item_id`) VALUES
(1, '0000-00-00', '0000-00-00', 2, '8'),
(2, '0000-00-00', '0000-00-00', 2, '11'),
(3, '0000-00-00', '0000-00-00', 3, '15');

-- --------------------------------------------------------

--
-- Table structure for table `item_comments`
--

DROP TABLE IF EXISTS `item_comments`;
CREATE TABLE IF NOT EXISTS `item_comments` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `posted_user_id` bigint(20) NOT NULL,
  `comment` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `item_id` (`item_id`),
  KEY `posted_user_id` (`posted_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `item_coupons`
--

DROP TABLE IF EXISTS `item_coupons`;
CREATE TABLE IF NOT EXISTS `item_coupons` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `item_id` bigint(20) default NULL,
  `pass_code` varchar(255) collate utf8_unicode_ci default NULL,
  `is_used` tinyint(1) default '0',
  `is_system_generated` tinyint(1) default '0',
  PRIMARY KEY  (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_coupons`
--


-- --------------------------------------------------------

--
-- Table structure for table `item_passes`
--

DROP TABLE IF EXISTS `item_passes`;
CREATE TABLE IF NOT EXISTS `item_passes` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `item_id` bigint(20) default NULL,
  `pass_code` varchar(255) collate utf8_unicode_ci default NULL,
  `is_used` tinyint(1) default '0',
  `is_system_generated` tinyint(1) default '0',
  PRIMARY KEY  (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_passes`
--

INSERT INTO `item_passes` (`id`, `created`, `modified`, `item_id`, `pass_code`, `is_used`, `is_system_generated`) VALUES
(1, '2011-11-22 12:53:26', '2011-11-22 12:53:26', 4, '00071ded-1', 1, 1),
(2, '2011-11-22 12:56:28', '2011-11-22 12:56:28', 4, '0008e3d9-1', 1, 1),
(3, '2011-11-22 13:01:42', '2011-11-22 13:01:42', 4, '0008a48e-1', 1, 1),
(4, '2011-11-22 13:30:57', '2011-11-22 13:30:57', 2, '000ebae7-1', 1, 1),
(5, '2011-11-22 13:32:08', '2011-11-22 13:32:08', 2, '0007b499-1', 1, 1),
(6, '2011-11-22 13:32:47', '2011-11-22 13:32:47', 3, '00008922-1', 1, 1),
(7, '2011-11-22 13:35:18', '2011-11-22 13:35:18', 3, '000ed6ac-1', 1, 1),
(8, '2012-02-21 09:06:55', '2012-02-21 09:06:55', 11, '0003c7f5-1', 1, 1),
(9, '2012-02-21 09:19:48', '2012-02-21 09:19:48', 11, '000d5064-1', 1, 1),
(10, '2012-02-21 09:19:48', '2012-02-21 09:19:48', 11, '000d825f-2', 1, 1),
(11, '2012-02-21 09:53:50', '2012-02-21 09:53:50', 12, '0000e46f-1', 1, 1),
(12, '2012-02-21 09:53:50', '2012-02-21 09:53:50', 12, '0009fe19-2', 1, 1),
(13, '2012-02-21 11:17:25', '2012-02-21 11:17:25', 13, '00060455-1', 1, 1),
(14, '2012-02-21 11:27:12', '2012-02-21 11:27:12', 13, '00036978-1', 1, 1),
(15, '2012-02-21 11:36:47', '2012-02-21 11:36:47', 13, '0000b292-1', 1, 1),
(16, '2012-02-21 11:44:28', '2012-02-21 11:44:28', 13, '00009059-1', 1, 1),
(17, '2012-02-21 11:47:31', '2012-02-21 11:47:31', 13, '000d6c0e-1', 1, 1),
(18, '2012-02-21 11:48:25', '2012-02-21 11:48:25', 13, '0007f86c-1', 1, 1),
(19, '2012-02-21 11:49:07', '2012-02-21 11:49:07', 13, '00014e05-1', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_referrers`
--

DROP TABLE IF EXISTS `item_referrers`;
CREATE TABLE IF NOT EXISTS `item_referrers` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `earned_amount` double(10,2) NOT NULL,
  `refferral_count` bigint(20) NOT NULL,
  `total_purchased_referral_count` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `item_id` (`item_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_referrers`
--

INSERT INTO `item_referrers` (`id`, `created`, `modified`, `item_id`, `user_id`, `earned_amount`, `refferral_count`, `total_purchased_referral_count`) VALUES
(1, '2012-02-21 11:49:08', '2012-02-21 11:49:08', 13, 2, 150.00, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_statuses`
--

DROP TABLE IF EXISTS `item_statuses`;
CREATE TABLE IF NOT EXISTS `item_statuses` (
  `id` int(4) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `item_count` bigint(20) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_statuses`
--

INSERT INTO `item_statuses` (`id`, `created`, `modified`, `name`, `item_count`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Pending', 1),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Open', 10),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Canceled', 4),
(4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Expired', 0),
(5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Tipped', 3),
(6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Closed', 1),
(7, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Refunded', 11),
(10, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Rejected', 0),
(11, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Draft', 1),
(8, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Paid To Merchant', 0),
(9, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Pending Approval', 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_users`
--

DROP TABLE IF EXISTS `item_users`;
CREATE TABLE IF NOT EXISTS `item_users` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `referred_by_user_id` bigint(20) default '0',
  `item_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) unsigned NOT NULL,
  `discount_amount` double(10,2) NOT NULL default '0.00',
  `payment_gateway_id` bigint(20) default '1',
  `payment_profile_id` bigint(20) default NULL,
  `cim_approval_code` varchar(255) collate utf8_unicode_ci default NULL,
  `cim_transaction_id` varchar(255) collate utf8_unicode_ci default NULL,
  `is_paid` tinyint(1) default '1',
  `is_repaid` tinyint(1) unsigned NOT NULL,
  `is_canceled` tinyint(1) NOT NULL default '0',
  `is_gift` tinyint(1) NOT NULL default '0',
  `gift_to` varchar(255) collate utf8_unicode_ci default NULL,
  `gift_from` varchar(255) collate utf8_unicode_ci default NULL,
  `gift_email` varchar(100) collate utf8_unicode_ci default NULL,
  `message` text collate utf8_unicode_ci,
  `item_user_pass_count` bigint(20) default NULL COMMENT 'update for used count only',
  `admin_commission_amount` double(10,2) default '0.00',
  `affiliate_commission_amount` double(10,2) default '0.00',
  `charity_paid_amount` double(10,2) default '0.00',
  `city_id` bigint(20) NOT NULL default '0',
  `latitude` double(10,6) NOT NULL default '0.000000',
  `longitude` double(10,6) NOT NULL default '0.000000',
  `referral_commission_amount` double(10,2) default '0.00',
  `is_referral_commission_sent` tinyint(1) default '0',
  `referral_commission_type` tinyint(2) default '0',
  `charity_site_amount` double(10,2) default '0.00',
  `charity_seller_amount` double(10,2) default '0.00',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `item_id` (`item_id`),
  KEY `payment_gateway_id` (`payment_gateway_id`),
  KEY `payment_profile_id` (`payment_profile_id`),
  KEY `city_id` (`city_id`),
  KEY `cim_transaction_id` (`cim_transaction_id`),
  KEY `referred_by_user_id` (`referred_by_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_users`
--

INSERT INTO `item_users` (`id`, `created`, `modified`, `user_id`, `referred_by_user_id`, `item_id`, `quantity`, `discount_amount`, `payment_gateway_id`, `payment_profile_id`, `cim_approval_code`, `cim_transaction_id`, `is_paid`, `is_repaid`, `is_canceled`, `is_gift`, `gift_to`, `gift_from`, `gift_email`, `message`, `item_user_pass_count`, `admin_commission_amount`, `affiliate_commission_amount`, `charity_paid_amount`, `city_id`, `latitude`, `longitude`, `referral_commission_amount`, `is_referral_commission_sent`, `referral_commission_type`, `charity_site_amount`, `charity_seller_amount`) VALUES
(1, '2011-11-22 12:53:26', '2011-11-22 12:53:26', 7, 0, 4, 1, 90.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42464, 13.083300, 80.283300, 0.00, 0, 0, 0.00, 0.00),
(2, '2011-11-22 12:56:28', '2011-11-22 12:56:28', 3, 0, 4, 1, 91.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42464, 13.083300, 80.283300, 5.00, 1, 1, 0.00, 0.00),
(3, '2011-11-22 13:01:42', '2011-11-22 13:01:42', 2, 0, 4, 1, 92.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42464, 13.083300, 80.283300, 0.00, 0, 0, 0.00, 0.00),
(4, '2011-11-22 13:30:56', '2011-11-22 13:30:56', 2, 0, 2, 1, 60.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42464, 13.083300, 80.283300, 0.00, 0, 0, 0.00, 0.00),
(5, '2011-11-22 13:32:08', '2011-11-22 13:32:08', 6, 0, 2, 1, 61.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42464, 13.083300, 80.283300, 0.00, 0, 0, 0.00, 0.00),
(6, '2011-11-22 13:32:47', '2011-11-22 13:32:47', 6, 0, 3, 1, 120.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42464, 13.083300, 80.283300, 0.00, 0, 0, 0.00, 0.00),
(7, '2011-11-22 13:35:18', '2011-11-22 13:35:18', 3, 0, 3, 1, 120.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42464, 13.083300, 80.283300, 0.00, 0, 0, 0.00, 0.00),
(8, '2012-02-21 09:06:55', '2012-02-21 09:06:55', 2, 0, 11, 1, 250.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42464, 13.083300, 80.283300, 150.00, 1, 2, 0.00, 0.00),
(9, '2012-02-21 09:19:48', '2012-02-21 09:19:48', 2, 0, 11, 2, 520.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42464, 13.083300, 80.283300, 0.00, 0, 0, 0.00, 0.00),
(10, '2012-02-21 09:53:50', '2012-02-21 09:53:50', 2, 0, 12, 2, 50.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42464, 13.083300, 80.283300, 0.00, 0, 0, 0.00, 0.00),
(11, '2012-02-21 11:17:25', '2012-02-21 11:17:25', 8, 2, 13, 1, 150.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42553, 13.083300, 80.283300, 0.00, 0, 0, 0.00, 0.00),
(12, '2012-02-21 11:27:12', '2012-02-21 11:27:12', 9, 2, 13, 1, 150.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42553, 13.083300, 80.283300, 0.00, 0, 0, 0.00, 0.00),
(13, '2012-02-21 11:36:47', '2012-02-21 11:36:47', 2, 0, 13, 1, 150.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42553, 13.083300, 80.283300, 0.00, 0, 0, 0.00, 0.00),
(14, '2012-02-21 11:44:28', '2012-02-21 11:44:28', 10, 2, 13, 1, 150.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42553, 13.083300, 80.283300, 0.00, 0, 0, 0.00, 0.00),
(15, '2012-02-21 11:47:31', '2012-02-21 11:47:31', 10, 0, 13, 1, 150.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42553, 13.083300, 80.283300, 0.00, 0, 0, 0.00, 0.00),
(16, '2012-02-21 11:48:25', '2012-02-21 11:48:25', 10, 0, 13, 1, 150.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42553, 13.083300, 80.283300, 0.00, 0, 0, 0.00, 0.00),
(17, '2012-02-21 11:49:07', '2012-02-21 11:49:07', 10, 0, 13, 1, 150.00, 1, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0.00, 0.00, 0.00, 42553, 13.083300, 80.283300, 0.00, 0, 0, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `item_user_passes`
--

DROP TABLE IF EXISTS `item_user_passes`;
CREATE TABLE IF NOT EXISTS `item_user_passes` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_user_id` bigint(20) default NULL,
  `pass_code` varchar(255) collate utf8_unicode_ci default NULL,
  `unique_pass_code` varchar(255) collate utf8_unicode_ci NOT NULL,
  `is_used` tinyint(1) default '0',
  `guest_name` varchar(100) collate utf8_unicode_ci default NULL,
  `guest_email` varchar(100) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `item_user_id` (`item_user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_user_passes`
--

INSERT INTO `item_user_passes` (`id`, `created`, `modified`, `user_id`, `item_user_id`, `pass_code`, `unique_pass_code`, `is_used`, `guest_name`, `guest_email`) VALUES
(1, '2011-11-22 12:53:26', '2011-11-22 12:53:26', 0, 1, '00071ded-1', '88374201', 0, 'user3', 'productdemo.user+user3@gmail.com'),
(2, '2011-11-22 12:56:29', '2011-11-22 12:56:29', 0, 2, '0008e3d9-1', '85876854', 0, 'user1', 'productdemo.user+user1@gmail.com'),
(3, '2011-11-22 13:01:42', '2011-11-22 13:01:42', 0, 3, '0008a48e-1', '99492902', 0, 'user', 'productdemo.user@gmail.com'),
(4, '2011-11-22 13:30:57', '2011-11-22 13:30:57', 0, 4, '000ebae7-1', '76991295', 0, 'user', 'productdemo.user@gmail.com'),
(5, '2011-11-22 13:32:08', '2011-11-22 13:32:08', 0, 5, '0007b499-1', '25595910', 0, 'user2', 'productdemo.user+user2@gmail.com'),
(6, '2011-11-22 13:32:47', '2011-11-22 13:32:47', 0, 6, '00008922-1', '58174742', 0, 'user2', 'productdemo.user+user2@gmail.com'),
(7, '2011-11-22 13:35:18', '2011-11-22 13:35:18', 0, 7, '000ed6ac-1', '59674650', 0, 'user1', 'productdemo.user+user1@gmail.com'),
(8, '2012-02-21 09:06:55', '2012-02-21 09:06:55', 0, 8, '0003c7f5-1', '85899299', 0, 'user', 'productdemo.user@gmail.com'),
(9, '2012-02-21 09:19:49', '2012-02-21 09:19:49', 0, 9, '000d5064-1', '87696359', 0, 'user', 'productdemo.user@gmail.com'),
(10, '2012-02-21 09:19:49', '2012-02-21 09:19:49', 0, 9, '000d825f-2', '94728287', 0, 'Jaya', 'jayashree.n@agriya.in'),
(11, '2012-02-21 09:53:50', '2012-02-21 09:53:50', 0, 10, '0000e46f-1', '67645364', 0, 'user', 'productdemo.user@gmail.com'),
(12, '2012-02-21 09:53:51', '2012-02-21 09:53:51', 0, 10, '0009fe19-2', '44714139', 0, 'Jaya', 'jayashree.n@agriya.in'),
(13, '2012-02-21 11:17:25', '2012-02-21 11:17:25', 0, 11, '00060455-1', '90464423', 0, 'juser', 'jayashree.n+juser@agriya.in'),
(14, '2012-02-21 11:27:12', '2012-02-21 11:27:12', 0, 12, '00036978-1', '27581097', 0, 'juser1', 'jayashree.n+juser1@agriya.in'),
(15, '2012-02-21 11:36:47', '2012-02-21 11:36:47', 0, 13, '0000b292-1', '18892287', 0, 'user', 'productdemo.user@gmail.com'),
(16, '2012-02-21 11:44:28', '2012-02-21 11:44:28', 0, 14, '00009059-1', '57534962', 0, 'juser2', 'jayashree.n+juser2@agriya.in'),
(17, '2012-02-21 11:47:31', '2012-02-21 11:47:31', 0, 15, '000d6c0e-1', '35135372', 0, 'juser2', 'jayashree.n+juser2@agriya.in'),
(18, '2012-02-21 11:48:25', '2012-02-21 11:48:25', 0, 16, '0007f86c-1', '41993390', 0, 'juser2', 'jayashree.n+juser2@agriya.in'),
(19, '2012-02-21 11:49:07', '2012-02-21 11:49:07', 0, 17, '00014e05-1', '65317291', 0, 'juser2', 'jayashree.n+juser2@agriya.in');

-- --------------------------------------------------------

--
-- Table structure for table `item_views`
--

DROP TABLE IF EXISTS `item_views`;
CREATE TABLE IF NOT EXISTS `item_views` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `item_id` bigint(20) default NULL,
  `ip_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Item View Details';

--
-- Dumping data for table `item_views`
--

INSERT INTO `item_views` (`id`, `created`, `modified`, `user_id`, `item_id`, `ip_id`) VALUES
(1, '2011-11-22 10:22:01', '2011-11-22 10:22:01', 4, 1, 1),
(2, '2011-11-22 10:22:25', '2011-11-22 10:22:25', 4, 2, 1),
(3, '2011-11-22 10:22:40', '2011-11-22 10:22:40', 4, 1, 1),
(4, '2011-11-22 10:22:50', '2011-11-22 10:22:50', 4, 2, 1),
(5, '2011-11-22 12:51:36', '2011-11-22 12:51:36', 7, 4, 1),
(6, '2011-11-22 12:56:14', '2011-11-22 12:56:14', 3, 4, 1),
(7, '2011-11-22 13:01:13', '2011-11-22 13:01:13', 2, 4, 1),
(8, '2011-11-22 13:30:38', '2011-11-22 13:30:38', 2, 2, 1),
(9, '2011-11-22 13:31:52', '2011-11-22 13:31:52', 6, 2, 1),
(10, '2011-11-22 13:32:32', '2011-11-22 13:32:32', 6, 3, 1),
(11, '2011-11-22 13:35:03', '2011-11-22 13:35:03', 3, 3, 1),
(12, '2012-02-21 07:59:29', '2012-02-21 07:59:29', 2, 10, 1),
(13, '2012-02-21 08:22:29', '2012-02-21 08:22:29', 2, 11, 1),
(14, '2012-02-21 08:23:47', '2012-02-21 08:23:47', 2, 11, 1),
(15, '2012-02-21 09:12:19', '2012-02-21 09:12:19', 2, 11, 1),
(16, '2012-02-21 09:21:17', '2012-02-21 09:21:17', 2, 11, 1),
(17, '2012-02-21 09:33:44', '2012-02-21 09:33:44', 2, 11, 1),
(18, '2012-02-21 09:37:22', '2012-02-21 09:37:22', 1, 10, 1),
(19, '2012-02-21 09:53:34', '2012-02-21 09:53:34', 2, 12, 1),
(20, '2012-02-21 09:54:34', '2012-02-21 09:54:34', 1, 12, 1),
(21, '2012-02-21 09:54:37', '2012-02-21 09:54:37', 2, 12, 1),
(22, '2012-02-21 09:55:21', '2012-02-21 09:55:21', 1, 12, 1),
(23, '2012-02-21 09:55:23', '2012-02-21 09:55:23', 1, 12, 1),
(24, '2012-02-21 10:26:24', '2012-02-21 10:26:24', 4, 12, 1),
(25, '2012-02-21 10:35:59', '2012-02-21 10:35:59', 4, 12, 1),
(26, '2012-02-21 10:36:24', '2012-02-21 10:36:24', 2, 12, 1),
(27, '2012-02-21 10:37:11', '2012-02-21 10:37:11', 2, 11, 1),
(28, '2012-02-21 10:49:18', '2012-02-21 10:49:18', 2, 11, 1),
(29, '2012-02-21 10:49:24', '2012-02-21 10:49:24', 2, 11, 1),
(30, '2012-02-21 10:49:38', '2012-02-21 10:49:38', 2, 11, 1),
(31, '2012-02-21 10:50:20', '2012-02-21 10:50:20', 2, 11, 1),
(32, '2012-02-21 10:59:42', '2012-02-21 10:59:42', 4, 12, 1),
(33, '2012-02-21 11:01:28', '2012-02-21 11:01:28', 4, 4, 1),
(34, '2012-02-21 11:02:37', '2012-02-21 11:02:37', 4, 4, 1),
(35, '2012-02-21 11:04:38', '2012-02-21 11:04:38', 4, 11, 1),
(36, '2012-02-21 11:05:18', '2012-02-21 11:05:18', 4, 11, 1),
(37, '2012-02-21 11:06:15', '2012-02-21 11:06:15', 4, 11, 1),
(38, '2012-02-21 11:14:57', '2012-02-21 11:14:57', 4, 11, 1),
(39, '2012-02-21 11:15:02', '2012-02-21 11:15:02', 4, 12, 1),
(40, '2012-02-21 11:15:04', '2012-02-21 11:15:04', 4, 12, 1),
(41, '2012-02-21 11:17:13', '2012-02-21 11:17:13', 8, 13, 1),
(42, '2012-02-21 11:17:38', '2012-02-21 11:17:38', 8, 13, 1),
(43, '2012-02-21 11:26:47', '2012-02-21 11:26:47', 9, 13, 1),
(44, '2012-02-21 11:36:36', '2012-02-21 11:36:36', 2, 13, 1),
(45, '2012-02-21 11:38:46', '2012-02-21 11:38:46', 0, 13, 1),
(46, '2012-02-21 11:39:59', '2012-02-21 11:39:59', 0, 13, 1),
(47, '2012-02-21 11:40:40', '2012-02-21 11:40:40', 0, 13, 1),
(48, '2012-02-21 11:41:50', '2012-02-21 11:41:50', 9, 13, 1),
(49, '2012-02-21 11:43:52', '2012-02-21 11:43:52', 10, 13, 1),
(50, '2012-02-21 11:58:19', '2012-02-21 11:58:19', 2, 11, 1),
(51, '2012-02-21 12:36:56', '2012-02-21 12:36:56', 1, 13, 1),
(52, '2012-02-21 13:38:10', '2012-02-21 13:38:10', 0, 14, 1),
(53, '2012-02-21 13:55:41', '2012-02-21 13:55:41', 0, 14, 1),
(54, '2012-02-23 06:22:18', '2012-02-23 06:22:18', 1, 15, 1),
(55, '2012-02-23 06:22:43', '2012-02-23 06:22:43', 1, 15, 1),
(56, '2012-02-23 10:14:51', '2012-02-23 10:14:51', 0, 11, 1),
(57, '2012-02-27 05:26:50', '2012-02-27 05:26:50', 0, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `labels`
--

DROP TABLE IF EXISTS `labels`;
CREATE TABLE IF NOT EXISTS `labels` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `slug` varchar(265) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Messages labels name';

--
-- Dumping data for table `labels`
--


-- --------------------------------------------------------

--
-- Table structure for table `labels_messages`
--

DROP TABLE IF EXISTS `labels_messages`;
CREATE TABLE IF NOT EXISTS `labels_messages` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `label_id` bigint(20) default NULL,
  `message_id` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `label_id` (`label_id`),
  KEY `message_id` (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Map table for labels and messages';

--
-- Dumping data for table `labels_messages`
--


-- --------------------------------------------------------

--
-- Table structure for table `labels_users`
--

DROP TABLE IF EXISTS `labels_users`;
CREATE TABLE IF NOT EXISTS `labels_users` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `label_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `label_id` (`label_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Map table for labels and users';

--
-- Dumping data for table `labels_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(80) collate utf8_unicode_ci NOT NULL,
  `iso2` varchar(5) collate utf8_unicode_ci NOT NULL,
  `iso3` varchar(5) collate utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Language Details ';

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `created`, `modified`, `name`, `iso2`, `iso3`, `is_active`) VALUES
(1, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Abkhazian', 'ab', 'abk', 1),
(2, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Afar', 'aa', 'aar', 1),
(3, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Afrikaans', 'af', 'afr', 1),
(4, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Akan', 'ak', 'aka', 1),
(5, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Albanian', 'sq', 'sqi', 1),
(6, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Amharic', 'am', 'amh', 1),
(7, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Arabic', 'ar', 'ara', 1),
(8, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Aragonese', 'an', 'arg', 1),
(9, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Armenian', 'hy', 'hye', 1),
(10, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Assamese', 'as', 'asm', 1),
(11, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Avaric', 'av', 'ava', 1),
(12, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Avestan', 'ae', 'ave', 1),
(13, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Aymara', 'ay', 'aym', 1),
(14, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Azerbaijani', 'az', 'aze', 1),
(15, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Bambara', 'bm', 'bam', 1),
(16, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Bashkir', 'ba', 'bak', 1),
(17, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Basque', 'eu', 'eus', 1),
(18, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Belarusian', 'be', 'bel', 1),
(19, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Bengali', 'bn', 'ben', 1),
(20, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Bihari', 'bh', 'bih', 1),
(21, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Bislama', 'bi', 'bis', 1),
(22, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Bosnian', 'bs', 'bos', 1),
(23, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Breton', 'br', 'bre', 1),
(24, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Bulgarian', 'bg', 'bul', 1),
(25, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Burmese', 'my', 'mya', 1),
(26, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Catalan', 'ca', 'cat', 1),
(27, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Chamorro', 'ch', 'cha', 1),
(28, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Chechen', 'ce', 'che', 1),
(29, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Chichewa', 'ny', 'nya', 1),
(30, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Chinese', 'zh', 'zho', 1),
(31, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Church Slavic', 'cu', 'chu', 1),
(32, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Chuvash', 'cv', 'chv', 1),
(33, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Cornish', 'kw', 'cor', 1),
(34, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Corsican', 'co', 'cos', 1),
(35, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Cree', 'cr', 'cre', 1),
(36, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Croatian', 'hr', 'hrv', 1),
(37, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Czech', 'cs', 'ces', 1),
(38, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Danish', 'da', 'dan', 1),
(39, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Divehi', 'dv', 'div', 1),
(40, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Dutch', 'nl', 'nld', 1),
(41, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Dzongkha', 'dz', 'dzo', 1),
(42, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'English', 'en', 'eng', 1),
(43, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Esperanto', 'eo', 'epo', 1),
(44, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Estonian', 'et', 'est', 1),
(45, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Ewe', 'ee', 'ewe', 1),
(46, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Faroese', 'fo', 'fao', 1),
(47, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Fijian', 'fj', 'fij', 1),
(48, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Finnish', 'fi', 'fin', 1),
(49, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'French', 'fr', 'fra', 1),
(50, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Fulah', 'ff', 'ful', 1),
(51, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Galician', 'gl', 'glg', 1),
(52, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Ganda', 'lg', 'lug', 1),
(53, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Georgian', 'ka', 'kat', 1),
(54, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'German', 'de', 'deu', 1),
(55, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Greek', 'el', 'ell', 1),
(56, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Guaraní', 'gn', 'grn', 1),
(57, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Gujarati', 'gu', 'guj', 1),
(58, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Haitian', 'ht', 'hat', 1),
(59, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Hausa', 'ha', 'hau', 1),
(60, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Hebrew', 'he', 'heb', 1),
(61, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Herero', 'hz', 'her', 1),
(62, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Hindi', 'hi', 'hin', 1),
(63, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Hiri Motu', 'ho', 'hmo', 1),
(64, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Hungarian', 'hu', 'hun', 1),
(65, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Icelandic', 'is', 'isl', 1),
(66, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Ido', 'io', 'ido', 1),
(67, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Igbo', 'ig', 'ibo', 1),
(68, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Indonesian', 'id', 'ind', 1),
(69, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Interlingua (International Auxiliary Language Association)', 'ia', 'ina', 1),
(70, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Interlingue', 'ie', 'ile', 1),
(71, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Inuktitut', 'iu', 'iku', 1),
(72, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Inupiaq', 'ik', 'ipk', 1),
(73, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Irish', 'ga', 'gle', 1),
(74, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Italian', 'it', 'ita', 1),
(75, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Japanese', 'ja', 'jpn', 1),
(76, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Javanese', 'jv', 'jav', 1),
(77, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kalaallisut', 'kl', 'kal', 1),
(78, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kannada', 'kn', 'kan', 1),
(79, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kanuri', 'kr', 'kau', 1),
(80, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kashmiri', 'ks', 'kas', 1),
(81, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kazakh', 'kk', 'kaz', 1),
(82, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Khmer', 'km', 'khm', 1),
(83, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kikuyu', 'ki', 'kik', 1),
(84, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kinyarwanda', 'rw', 'kin', 1),
(85, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kirghiz', 'ky', 'kir', 1),
(86, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kirundi', 'rn', 'run', 1),
(87, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Komi', 'kv', 'kom', 1),
(88, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kongo', 'kg', 'kon', 1),
(89, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Korean', 'ko', 'kor', 1),
(90, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kurdish', 'ku', 'kur', 1),
(91, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kwanyama', 'kj', 'kua', 1),
(92, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Lao', 'lo', 'lao', 1),
(93, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Latin', 'la', 'lat', 1),
(94, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Latvian', 'lv', 'lav', 1),
(95, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Limburgish', 'li', 'lim', 1),
(96, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Lingala', 'ln', 'lin', 1),
(97, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Lithuanian', 'lt', 'lit', 1),
(98, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Luba-Katanga', 'lu', 'lub', 1),
(99, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Luxembourgish', 'lb', 'ltz', 1),
(100, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Macedonian', 'mk', 'mkd', 1),
(101, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Malagasy', 'mg', 'mlg', 1),
(102, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Malay', 'ms', 'msa', 1),
(103, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Malayalam', 'ml', 'mal', 1),
(104, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Maltese', 'mt', 'mlt', 1),
(105, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Manx', 'gv', 'glv', 1),
(106, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Māori', 'mi', 'mri', 1),
(107, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Marathi', 'mr', 'mar', 1),
(108, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Marshallese', 'mh', 'mah', 1),
(109, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Mongolian', 'mn', 'mon', 1),
(110, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Nauru', 'na', 'nau', 1),
(111, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Navajo', 'nv', 'nav', 1),
(112, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Ndonga', 'ng', 'ndo', 1),
(113, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Nepali', 'ne', 'nep', 1),
(114, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'North Ndebele', 'nd', 'nde', 1),
(115, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Northern Sami', 'se', 'sme', 1),
(116, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Norwegian', 'no', 'nor', 1),
(117, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Norwegian Bokmål', 'nb', 'nob', 1),
(118, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Norwegian Nynorsk', 'nn', 'nno', 1),
(119, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Occitan', 'oc', 'oci', 1),
(120, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Ojibwa', 'oj', 'oji', 1),
(121, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Oriya', 'or', 'ori', 1),
(122, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Oromo', 'om', 'orm', 1),
(123, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Ossetian', 'os', 'oss', 1),
(124, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Pāli', 'pi', 'pli', 1),
(125, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Panjabi', 'pa', 'pan', 1),
(126, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Pashto', 'ps', 'pus', 1),
(127, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Persian', 'fa', 'fas', 1),
(128, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Polish', 'pl', 'pol', 1),
(129, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Portuguese', 'pt', 'por', 1),
(130, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Quechua', 'qu', 'que', 1),
(131, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Raeto-Romance', 'rm', 'roh', 1),
(132, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Romanian', 'ro', 'ron', 1),
(133, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Russian', 'ru', 'rus', 1),
(134, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Samoan', 'sm', 'smo', 1),
(135, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Sango', 'sg', 'sag', 1),
(136, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Sanskrit', 'sa', 'san', 1),
(137, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Sardinian', 'sc', 'srd', 1),
(138, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Scottish Gaelic', 'gd', 'gla', 1),
(139, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Serbian', 'sr', 'srp', 1),
(140, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Shona', 'sn', 'sna', 1),
(141, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Sichuan Yi', 'ii', 'iii', 1),
(142, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Sindhi', 'sd', 'snd', 1),
(143, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Sinhala', 'si', 'sin', 1),
(144, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Slovak', 'sk', 'slk', 1),
(145, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Slovenian', 'sl', 'slv', 1),
(146, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Somali', 'so', 'som', 1),
(147, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'South Ndebele', 'nr', 'nbl', 1),
(148, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Southern Sotho', 'st', 'sot', 1),
(149, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Spanish', 'es', 'spa', 1),
(150, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Sundanese', 'su', 'sun', 1),
(151, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Swahili', 'sw', 'swa', 1),
(152, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Swati', 'ss', 'ssw', 1),
(153, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Swedish', 'sv', 'swe', 1),
(154, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tagalog', 'tl', 'tgl', 1),
(155, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tahitian', 'ty', 'tah', 1),
(156, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tajik', 'tg', 'tgk', 1),
(157, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tamil', 'ta', 'tam', 1),
(158, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tatar', 'tt', 'tat', 1),
(159, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Telugu', 'te', 'tel', 1),
(160, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Thai', 'th', 'tha', 1),
(161, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Tibetan', 'bo', 'bod', 1),
(162, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tigrinya', 'ti', 'tir', 1),
(163, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tonga', 'to', 'ton', 1),
(164, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Traditional Chinese', 'zh-TW', 'zh-TW', 1),
(165, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tsonga', 'ts', 'tso', 1),
(166, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tswana', 'tn', 'tsn', 1),
(167, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Turkish', 'tr', 'tur', 1),
(168, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Turkmen', 'tk', 'tuk', 1),
(169, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Twi', 'tw', 'twi', 1),
(170, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Uighur', 'ug', 'uig', 1),
(171, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Ukrainian', 'uk', 'ukr', 1),
(172, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Urdu', 'ur', 'urd', 1),
(173, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Uzbek', 'uz', 'uzb', 1),
(174, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Venda', 've', 'ven', 1),
(175, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Vietnamese', 'vi', 'vie', 1),
(176, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Volapük', 'vo', 'vol', 1),
(177, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Walloon', 'wa', 'wln', 1),
(178, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Welsh', 'cy', 'cym', 1),
(179, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Western Frisian', 'fy', 'fry', 1),
(180, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Wolof', 'wo', 'wol', 1),
(181, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Xhosa', 'xh', 'xho', 1),
(182, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Yiddish', 'yi', 'yid', 1),
(183, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Yoruba', 'yo', 'yor', 1),
(184, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Zhuang', 'za', 'zha', 1),
(185, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Zulu', 'zu', 'zul', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mail_chimp_lists`
--

DROP TABLE IF EXISTS `mail_chimp_lists`;
CREATE TABLE IF NOT EXISTS `mail_chimp_lists` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `city_id` bigint(20) unsigned NOT NULL,
  `user_interest_id` bigint(20) NOT NULL default '0',
  `list_id` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `city_id` (`city_id`),
  KEY `list_id` (`list_id`),
  KEY `user_interest_id` (`user_interest_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `mail_chimp_lists`
--


-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

DROP TABLE IF EXISTS `merchants`;
CREATE TABLE IF NOT EXISTS `merchants` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `slug` varchar(265) collate utf8_unicode_ci NOT NULL,
  `email` varchar(255) collate utf8_unicode_ci default NULL,
  `address1` varchar(50) collate utf8_unicode_ci NOT NULL,
  `address2` varchar(50) collate utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `city_id` bigint(20) unsigned NOT NULL,
  `state_id` bigint(20) unsigned NOT NULL,
  `country_id` bigint(20) unsigned NOT NULL,
  `phone` varchar(20) collate utf8_unicode_ci default NULL,
  `zip` varchar(255) collate utf8_unicode_ci NOT NULL,
  `url` varchar(100) collate utf8_unicode_ci NOT NULL,
  `bonus_amount` double(10,2) default '0.00',
  `commission_percentage` double(10,2) default '0.00',
  `item_count` bigint(20) default '0',
  `is_online_account` tinyint(1) default '0',
  `is_merchant_profile_enabled` tinyint(1) NOT NULL default '0',
  `merchant_profile` text collate utf8_unicode_ci,
  `latitude` float(10,6) default NULL,
  `longitude` float(10,6) default NULL,
  `map_zoom_level` bigint(20) default NULL,
  `merchant_view_count` bigint(20) default '0',
  `total_open_count` int(11) default '0',
  `total_canceled_count` int(11) default '0',
  `total_expired_count` int(11) default '0',
  `total_tipped_count` int(11) default '0',
  `total_closed_count` int(11) default '0',
  `total_refunded_count` int(11) default '0',
  `total_paid_to_merchant_count` int(11) default '0',
  `total_pending_approval_count` int(11) default '0',
  `total_rejected_count` int(11) default '0',
  `total_draft_count` int(11) default '0',
  `total_sales_cleared_amount` double(10,2) default '0.00',
  `total_sales_pipeline_amount` double(10,2) default '0.00',
  `total_sales_lost_amount` double(10,2) default '0.00',
  `total_site_revenue_amount` double(10,2) default '0.00',
  `total_paid_for_charity_amount` double(10,2) default '0.00',
  PRIMARY KEY  (`id`),
  KEY `country_id` (`country_id`),
  KEY `state_id` (`state_id`),
  KEY `city_id` (`city_id`),
  KEY `user_id` (`user_id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `merchants`
--

INSERT INTO `merchants` (`id`, `created`, `modified`, `name`, `slug`, `email`, `address1`, `address2`, `user_id`, `city_id`, `state_id`, `country_id`, `phone`, `zip`, `url`, `bonus_amount`, `commission_percentage`, `item_count`, `is_online_account`, `is_merchant_profile_enabled`, `merchant_profile`, `latitude`, `longitude`, `map_zoom_level`, `merchant_view_count`, `total_open_count`, `total_canceled_count`, `total_expired_count`, `total_tipped_count`, `total_closed_count`, `total_refunded_count`, `total_paid_to_merchant_count`, `total_pending_approval_count`, `total_rejected_count`, `total_draft_count`, `total_sales_cleared_amount`, `total_sales_pipeline_amount`, `total_sales_lost_amount`, `total_site_revenue_amount`, `total_paid_for_charity_amount`) VALUES
(1, '2011-11-22 09:41:16', '2012-02-23 06:25:10', 'Crusent', 'crusent', NULL, '16/3, krishna street, nungambakkam', '', 4, 42551, 71, 109, '', '600094', '', 0.00, 0.00, 11, 1, 1, NULL, 13.060422, 80.249580, 8, 14, 8, 0, 0, 3, 0, 0, 0, 0, 0, 0, 0.00, 1404.00, 0.00, 0.00, 0.00),
(2, '2011-11-22 09:46:05', '2012-02-23 06:01:45', 'Ahsan', 'ahsan', NULL, '16/3, krishna street, nungambakkam', '', 5, 42551, 71, 109, '', '600094', 'http://agriya.com', 0.00, 0.00, 4, 1, 1, NULL, 13.060422, 80.249580, 8, 1, 2, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0.00, 1100.00, 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `merchant_views`
--

DROP TABLE IF EXISTS `merchant_views`;
CREATE TABLE IF NOT EXISTS `merchant_views` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) default NULL,
  `merchant_id` bigint(20) NOT NULL,
  `ip_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `merchant_id` (`merchant_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `merchant_views`
--

INSERT INTO `merchant_views` (`id`, `created`, `modified`, `user_id`, `merchant_id`, `ip_id`) VALUES
(1, '2012-02-21 11:02:53', '2012-02-21 11:02:53', 4, 1, 1),
(2, '2012-02-21 11:58:41', '2012-02-21 11:58:41', 2, 1, 1),
(3, '2012-02-21 12:01:50', '2012-02-21 12:01:50', 2, 1, 1),
(4, '2012-02-21 12:03:39', '2012-02-21 12:03:39', 2, 1, 1),
(5, '2012-02-21 12:04:05', '2012-02-21 12:04:05', 2, 2, 1),
(6, '2012-02-21 12:07:47', '2012-02-21 12:07:47', 4, 1, 1),
(7, '2012-02-21 12:07:54', '2012-02-21 12:07:54', 4, 1, 1),
(8, '2012-02-21 12:08:18', '2012-02-21 12:08:18', 2, 1, 1),
(9, '2012-02-21 12:09:28', '2012-02-21 12:09:28', 2, 1, 1),
(10, '2012-02-21 12:10:39', '2012-02-21 12:10:39', 2, 1, 1),
(11, '2012-02-21 12:18:30', '2012-02-21 12:18:30', 8, 1, 1),
(12, '2012-02-21 12:18:55', '2012-02-21 12:18:55', 8, 1, 1),
(13, '2012-02-21 12:23:11', '2012-02-21 12:23:11', 8, 1, 1),
(14, '2012-02-21 12:23:56', '2012-02-21 12:23:56', 8, 1, 1),
(15, '2012-02-21 12:53:48', '2012-02-21 12:53:48', 8, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `user_id` bigint(20) default NULL,
  `other_user_id` bigint(20) default NULL,
  `parent_message_id` bigint(20) default NULL,
  `message_content_id` bigint(20) NOT NULL,
  `message_folder_id` bigint(20) NOT NULL,
  `is_sender` tinyint(1) NOT NULL,
  `is_starred` tinyint(1) default NULL,
  `is_read` tinyint(1) default '0',
  `is_deleted` tinyint(1) default '0',
  `is_archived` tinyint(1) NOT NULL default '0',
  `is_communication` tinyint(1) NOT NULL,
  `hash` text collate utf8_unicode_ci,
  `size` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `other_user_id` (`other_user_id`),
  KEY `parent_message_id` (`parent_message_id`),
  KEY `message_content_id` (`message_content_id`),
  KEY `message_folder_id` (`message_folder_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User messages';

--
-- Dumping data for table `messages`
--


-- --------------------------------------------------------

--
-- Table structure for table `message_contents`
--

DROP TABLE IF EXISTS `message_contents`;
CREATE TABLE IF NOT EXISTS `message_contents` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `subject` text collate utf8_unicode_ci,
  `message` text collate utf8_unicode_ci,
  `admin_suspend` tinyint(1) NOT NULL default '0',
  `is_system_flagged` tinyint(1) NOT NULL default '0',
  `detected_suspicious_words` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User messages content';

--
-- Dumping data for table `message_contents`
--


-- --------------------------------------------------------

--
-- Table structure for table `message_filters`
--

DROP TABLE IF EXISTS `message_filters`;
CREATE TABLE IF NOT EXISTS `message_filters` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `user_id` bigint(20) default NULL,
  `from_user_id` bigint(20) default '0',
  `to_user_id` bigint(20) default NULL,
  `subject` varchar(255) collate utf8_unicode_ci default NULL,
  `has_words` varchar(255) collate utf8_unicode_ci default NULL,
  `does_not_has_words` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `to_user_id` (`to_user_id`),
  KEY `from_user_id` (`from_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Message Filter Details';

--
-- Dumping data for table `message_filters`
--


-- --------------------------------------------------------

--
-- Table structure for table `message_folders`
--

DROP TABLE IF EXISTS `message_folders`;
CREATE TABLE IF NOT EXISTS `message_folders` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Messages folder';

--
-- Dumping data for table `message_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `money_transfer_accounts`
--

DROP TABLE IF EXISTS `money_transfer_accounts`;
CREATE TABLE IF NOT EXISTS `money_transfer_accounts` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `payment_gateway_id` int(11) NOT NULL,
  `account` varchar(100) collate utf8_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`,`payment_gateway_id`),
  KEY `is_default` (`is_default`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `money_transfer_accounts`
--

INSERT INTO `money_transfer_accounts` (`id`, `created`, `modified`, `user_id`, `payment_gateway_id`, `account`, `is_default`) VALUES
(1, '2012-02-23 06:52:28', '2012-02-23 06:52:28', 2, 3, 'jayindreams@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `parent_id` bigint(20) unsigned default NULL,
  `title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `content` text collate utf8_unicode_ci,
  `template` varchar(255) collate utf8_unicode_ci default NULL,
  `draft` tinyint(1) NOT NULL default '0',
  `lft` bigint(20) default NULL,
  `rght` bigint(20) default NULL,
  `level` int(3) NOT NULL default '0',
  `description_meta_tag` text collate utf8_unicode_ci,
  `url` text collate utf8_unicode_ci,
  `slug` varchar(255) collate utf8_unicode_ci NOT NULL,
  `is_default` tinyint(1) default '0',
  PRIMARY KEY  (`id`),
  KEY `title` (`title`),
  KEY `parent_id` (`parent_id`),
  KEY `lft` (`lft`),
  KEY `rght` (`rght`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Page Details';

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `created`, `modified`, `parent_id`, `title`, `content`, `template`, `draft`, `lft`, `rght`, `level`, `description_meta_tag`, `url`, `slug`, `is_default`) VALUES
(9, '2010-04-07 08:04:15', '2011-01-08 08:33:27', NULL, 'Privacy Policy', '<div class="static-pages-block">\r\n<h3>Terms</h3>\r\n<p>##SITE_NAME## is an intermediary service offering discounts through primary vendors. We do our very best to insure that you have an optimum experience with your ##SITE_NAME## certificate from purchase to redemption.</dt><dd>Should there be a problem with, or question about your purchase, please contact us as soon as possible.</dd><dt>In certain circumstances, ##SITE_NAME## certificates may be returned for the full purchase price.</dt><dd>Examples of these situations include, but are not limited to:</dd><dt>The business closes prior to expiration of ##SITE_NAME## certificate, or a legitimate discrepancy in our printed terms (i.e. expiration dates, location of vendor)</dt><dd>If you wish to inquire about returning a ##SITE_NAME## certificate for a refund, please email us at <a href="mailto:help@##SITE_NAME##.com">help@##SITE_NAME##.com</a> Your happiness is our success.</p>\r\n<h3>Your Privacy</h3>\r\n<p>All credit card information is encrypted for your security. Information provided to ##SITE_NAME## will be used solely for the purpose of conducting business with ##SITE_NAME##.</p>\r\n</div>', NULL, 0, NULL, NULL, 0, '', NULL, 'privacy_policy', 0),
(2, '2009-07-11 11:16:54', '2011-01-18 15:07:54', NULL, 'About', '<p>Vivamus aliquet justo sit amet elit dapibus lobortis. Donec non est at  lectus vestibulum convallis. Nulla facilisi. Vestibulum felis libero,  sodales quis euismod eget, viverra a metus. Nulla eleifend iaculis lorem  nec ullamcorper. Suspendisse eu cursus ligula. Fusce dolor sapien,  tincidunt quis rutrum vitae, egestas eu leo. Nullam commodo risus eu  magna iaculis dignissim. Sed dignissim erat a lacus tincidunt dictum.  Donec arcu augue, hendrerit eu tempor vel, fringilla eget neque.  Phasellus dignissim euismod est quis sagittis. Mauris euismod bibendum  tortor, in elementum diam ultricies vel. Ut tincidunt sollicitudin nibh,  ac semper augue tincidunt ac. Aliquam semper arcu at risus faucibus  placerat. Nullam a enim turpis, nec convallis sapien.</p>\r\n<p>Aenean lacus odio, rhoncus iaculis sodales et, hendrerit hendrerit ante.  Morbi pulvinar blandit pretium. Nunc at rutrum ligula. Cras non massa  at elit placerat tempor. Mauris sollicitudin tristique tellus, nec  placerat leo bibendum ornare. Nunc et mi neque, eu volutpat dui. Sed  ultricies nisi quis nisl congue vulputate. Proin sed augue quis nibh  aliquam tempor. Nam auctor malesuada quam vel porta. Vestibulum quam  enim, ultricies ac semper sed, blandit in augue. Pellentesque vel diam  enim, quis blandit neque. Ut molestie bibendum pellentesque. Duis in  suscipit lacus. Phasellus condimentum purus non sem posuere hendrerit.  Donec aliquet placerat massa, pretium fringilla enim sodales at. In  tempus turpis tincidunt augue luctus dictum. Vestibulum convallis, elit  vitae elementum luctus, velit tortor condimentum massa, vel dapibus  sapien elit non diam. Quisque ante elit, scelerisque sed lobortis in,  mattis sit amet magna.</p>', 'about.ctp', 0, NULL, NULL, 0, NULL, NULL, 'about', 0),
(8, '2010-04-07 08:01:58', '2010-04-07 08:01:58', NULL, 'Contacts Policy', '<p>coming soon</p>', NULL, 0, NULL, NULL, 0, '', NULL, 'contacts_policy', 0),
(6, '2009-07-17 07:55:38', '2011-01-08 08:36:37', NULL, 'FAQ', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque vulputate rhoncus erat, quis cursus erat porta sed. Maecenas augue mi, mattis vel mattis sed, dictum quis lorem. Mauris orci massa, interdum commodo convallis a, gravida id tortor. Nam et nisl vel nisi ullamcorper scelerisque. Sed mollis rutrum ultrices. Maecenas sed mattis mauris. Phasellus dolor velit, ultricies in suscipit sit amet, rhoncus vel nunc. Nunc vel mattis dui. Proin luctus semper tellus, et placerat est molestie a. Sed posuere enim sagittis nulla malesuada malesuada. In ut risus at augue venenatis volutpat ac et lacus. Fusce adipiscing, justo hendrerit tristique rutrum, nibh lorem vulputate mauris, sit amet vulputate leo turpis eu odio. Vivamus placerat bibendum est id fringilla. Donec euismod varius enim id auctor.</p>\r\n\r\n<p>Vestibulum eu leo ac felis tincidunt rutrum. Praesent venenatis turpis ac mi venenatis bibendum. Phasellus dictum tincidunt elementum. Duis sit amet est odio, et volutpat augue. Phasellus eget libero turpis. Sed porttitor pellentesque eleifend. Cras eget leo eget leo facilisis varius sit amet sit amet lorem. Integer gravida, ante sed ullamcorper volutpat, diam quam porttitor velit, nec vestibulum massa magna sit amet odio. Nullam eget lectus arcu, at varius est. Phasellus arcu purus, convallis vitae ultrices sit amet, volutpat quis erat. Proin in mauris in dui venenatis semper. Duis pellentesque, sem nec malesuada sodales, velit orci vestibulum orci, porta tincidunt dolor augue et erat. Integer ultrices scelerisque dolor. Donec odio quam, laoreet id ornare et, ornare vehicula lacus. Mauris non augue eu nisl mollis fermentum ac et lacus. Aenean interdum augue a massa tincidunt ac ultricies justo sollicitudin. Morbi nibh eros, aliquam ac suscipit at, congue eget mauris. Integer felis metus, ullamcorper dignissim commodo ac, euismod in nisi. Curabitur tempor feugiat leo in tincidunt.</p>\r\n\r\n<p>Etiam eu blandit nunc. Nunc laoreet vulputate iaculis. Sed ac augue risus. Maecenas mi mi, suscipit quis sollicitudin eget, condimentum ut nibh. Aenean eget libero dolor. Vivamus libero enim, rhoncus id malesuada a, faucibus quis magna. Cras molestie venenatis velit, a blandit orci accumsan quis. Ut elit enim, volutpat eget ultricies sodales, lobortis vel tortor. Quisque tincidunt eros at felis rutrum scelerisque. Morbi nec commodo mi. Quisque consectetur tempus nibh id aliquam. Maecenas bibendum tristique lectus id lacinia.</p>\r\n\r\n<p>Etiam vel libero sem. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque bibendum augue nec erat vulputate commodo. Morbi quis fermentum sem. Proin sodales, turpis sed convallis tincidunt, dolor ipsum placerat turpis, et interdum tortor velit pellentesque nulla. Nulla scelerisque sapien vel neque rutrum at feugiat enim convallis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin consequat mi sit amet enim aliquam laoreet. In gravida consequat pulvinar. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi elit ligula, dictum id condimentum eu, feugiat id metus. Integer in eros risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Proin mollis adipiscing sem et mollis. Quisque mattis tempus felis, sit amet sodales lectus rutrum in. In ultrices lorem vitae risus pulvinar ullamcorper. Praesent pellentesque, nibh eget lacinia accumsan, ligula neque dictum risus, at posuere augue diam eu neque. In hac habitasse platea dictumst. Aliquam hendrerit neque a massa ullamcorper vel mollis tortor bibendum.</p>\r\n\r\n<p>Donec faucibus lectus interdum justo volutpat at iaculis libero congue. Nulla eget lorem augue. Aliquam vestibulum felis eu diam viverra in blandit arcu vulputate. Aliquam ut diam lacus, sed venenatis arcu. Sed nec quam quam, a viverra risus. Curabitur vitae massa in velit varius tempor ut vitae tortor. Nunc eget enim quis tortor ornare adipiscing vitae in erat. Praesent lacinia, ipsum et luctus tempor, nunc erat congue metus, ac pretium urna ligula id nibh. Maecenas a diam nisl. Aenean tristique orci dolor. Cras est risus, aliquam id rhoncus a, lacinia id quam. Nullam velit neque, vestibulum feugiat consequat vel, congue vitae diam. Fusce risus nisi, vulputate eu rutrum vitae, porta eget elit. Integer sit amet enim nunc. Etiam consectetur nisl eget dui tristique gravida. Nullam fermentum velit tellus. Nullam aliquet iaculis turpis, non vehicula orci ultricies non. </p>', '', 0, NULL, NULL, 0, NULL, NULL, 'faq', 0),
(7, '2009-07-21 15:56:45', '2011-01-18 15:07:59', NULL, 'Terms and conditions', '<p>Ut fringilla bibendum nulla, nec viverra risus venenatis ut. Lorem ipsum  dolor sit amet, consectetur adipiscing elit. Phasellus velit dui,  rhoncus vel fringilla ac, dictum nec nisi. Nulla ultrices hendrerit  purus, in porta lectus venenatis vitae. Vestibulum ante ipsum primis in  faucibus orci luctus et ultrices posuere cubilia Curae; Duis mauris  ipsum, porttitor in luctus id, porttitor sit amet purus. Vestibulum nisi  purus, rhoncus et hendrerit ut, adipiscing et ipsum. Proin posuere  augue egestas est interdum vestibulum. Sed et erat arcu. Curabitur sed  leo id neque commodo hendrerit. Aliquam erat volutpat. In ante ligula,  ultrices eu euismod facilisis, gravida eget nisl. Phasellus convallis  ullamcorper eros, eu posuere metus tristique condimentum. Praesent ut  tortor tellus, a rhoncus lacus. Class aptent taciti sociosqu ad litora  torquent per conubia nostra, per inceptos himenaeos. Aliquam vel velit  vulputate eros lacinia placerat vel at ligula.</p>\r\n<p>Sed non dui massa, quis euismod nulla. Lorem ipsum dolor sit amet,  consectetur adipiscing elit. Nullam volutpat leo nec nisi tristique at  tristique erat varius. Ut id purus viverra ipsum ultrices consectetur  pellentesque id lectus. Suspendisse ac augue non enim convallis rhoncus.  Nunc mi mauris, sodales at rhoncus id, elementum eget neque. Nullam  fringilla, lectus sit amet venenatis tincidunt, sapien dolor mollis  magna, et pellentesque sem lectus et est. Nam lacinia purus sed nunc  lobortis id blandit magna eleifend. Nullam arcu sem, fringilla vitae  porta sed, scelerisque sed urna. Pellentesque condimentum metus sed  justo scelerisque et tempor velit pellentesque.</p>', '', 0, NULL, NULL, 0, NULL, NULL, 'term-and-conditions', 0),
(10, '2010-05-05 12:12:23', '2011-01-18 15:08:01', NULL, 'Learn How ##SITE_NAME## Works', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ullamcorper  feugiat augue, sed luctus quam fermentum fringilla. Vestibulum et  dictum dolor. Fusce at ligula malesuada velit sodales auctor a ac est.  In accumsan imperdiet lorem. Morbi imperdiet, elit eu scelerisque  congue, est neque hendrerit nisl, vel dictum neque lorem et mi. Aenean  commodo, mauris eleifend hendrerit fringilla, tortor diam feugiat eros,  id dictum erat nulla sed odio. Fusce at eros eros. Praesent lobortis  vehicula arcu non elementum. Duis urna odio, tempor sed mollis vel,  mollis nec felis. Suspendisse mauris libero, sodales ac sollicitudin  eget, pellentesque vitae nisi.</p>\r\n<p>Morbi et purus nec quam rhoncus ullamcorper ut vitae lectus. Vestibulum  rutrum egestas lacinia. Nullam dapibus sagittis magna ut vestibulum.  Curabitur urna justo, ornare eu pulvinar ac, luctus eget nisi. Nulla  ornare ultricies hendrerit. Donec vitae sem quam, a blandit lacus. Ut  faucibus urna sed quam dictum sed rutrum elit vehicula. Mauris tincidunt  sagittis tempus. Cras varius suscipit convallis. Phasellus a enim nec  metus hendrerit imperdiet eu a arcu.</p>\r\n<p>Nulla risus sem, dignissim laoreet imperdiet in, bibendum vitae lacus.  Curabitur consequat lobortis quam at pharetra. Cras molestie cursus ante  porta facilisis. Morbi ullamcorper enim ac urna pretium vel sodales  nisi facilisis. Proin sagittis enim eget lacus dictum congue. Lorem  ipsum dolor sit amet, consectetur adipiscing elit. In hac habitasse  platea dictumst. Ut vestibulum rhoncus arcu vel consectetur. Phasellus a  porta risus. Cras quis mi metus. Aenean elit nunc, pharetra vel  vulputate sed, faucibus sit amet nulla.</p>', NULL, 0, NULL, NULL, 0, '', NULL, 'learn', 0),
(11, '2010-05-05 14:37:51', '2011-01-31 13:14:47', NULL, '##SITE_NAME## for Your Business', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus turpis  sem, placerat ac imperdiet fringilla, semper vel odio. Donec pharetra  feugiat mi id vulputate. Integer semper placerat nisi, vitae bibendum  diam eleifend id. Etiam imperdiet, mi non molestie sagittis, velit purus  tempus neque, ut sagittis nisi mauris non enim. Pellentesque vel sem  eget elit ornare pellentesque. Suspendisse lobortis tempor fringilla.  Nulla eget volutpat mi. Ut ut arcu nisl, quis euismod arcu. Ut iaculis  nisl quis arcu iaculis consequat. Proin commodo, tellus eget varius  rutrum, turpis eros pulvinar erat, id ultrices enim lacus ac mauris.  Maecenas hendrerit porttitor sodales.</p>\r\n<p>Phasellus commodo, dui ut molestie accumsan, diam felis pretium dolor,  id pharetra odio justo egestas nulla. Pellentesque et lectus ut justo  facilisis dignissim eu eget mi. In hac habitasse platea dictumst. Etiam  consectetur arcu felis. Curabitur consectetur ullamcorper elementum.  Phasellus porttitor sapien sit amet nibh ultricies luctus. Sed et quam  vel neque gravida accumsan in vel velit. Nam convallis ante eu tortor  bibendum a aliquet odio auctor. Nulla semper lorem tellus. Sed aliquam  malesuada lorem, eu viverra purus tempor vehicula. Phasellus non orci  sed tortor tempor rhoncus. Aenean sed metus nunc, a tempor justo. Nam  non malesuada lacus. Suspendisse arcu metus, bibendum sed eleifend vel,  sagittis ut tortor. Etiam id lectus est, in sodales arcu. Pellentesque  sit amet orci lacus, ac fermentum magna. Lorem ipsum dolor sit amet,  consectetur adipiscing elit. Curabitur molestie vehicula laoreet. Nullam  gravida mattis sagittis. Sed vestibulum consequat dolor sit amet  sollicitudin.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ipsum  magna, lobortis luctus aliquam vitae, ultricies in dui. Quisque mauris  nulla, rutrum vel ultrices vitae, suscipit ac ante. Integer venenatis  bibendum tortor, eu varius sapien tempus quis. Sed vestibulum arcu quis  elit imperdiet vel rhoncus nulla mattis. Nullam ut lacus eu purus  interdum dictum sed vel libero. Donec dictum, quam vitae ornare  suscipit, neque odio ullamcorper nibh, consectetur congue neque elit ac  ipsum. Curabitur sodales malesuada pulvinar. Nulla facilisi. Duis in  ornare purus. Vivamus cursus imperdiet dignissim. Maecenas ultricies  volutpat auctor. Cum sociis natoque penatibus et magnis dis parturient  montes, nascetur ridiculus mus. Suspendisse facilisis lobortis dui quis  molestie. Integer non vehicula ligula. Aliquam facilisis auctor nulla eu  congue. Donec dolor mauris, dictum vel aliquet eget, dignissim nec  lacus.</p>', NULL, 0, NULL, NULL, 0, '', NULL, 'merchant', 0),
(14, '2010-06-15 14:25:45', '2010-06-24 23:03:23', NULL, '##SITE_NAME## API', '<div class="page_content table">\r\n<div class="api-img-blcok">\r\n<h3><span class="big_button">\r\n<img class="space_cat" src="##SITE_URL##img/space_cat.png" alt="" /></span></h3>\r\n</div>\r\n<div class="api-information-blcok">\r\n<h3>Access ##SITE_NAME##''s Space-Age Technology</h3>\r\n<p>Register for a ##SITE_NAME## API key to develop your own ##SITE_NAME## applications. Now, you can put all those great ideas for ##SITE_NAME## improvements, extensions, and multiple-platform interfaces to work.</p>\r\n<p>First, read <a href="##SITE_URL##page/api-terms-of-use">API Terms of  Service</a> and <a href="##SITE_URL##page/api-branding-requirements">Branding  Requirements</a>. Then, once you register, you''ll find guidance and  support in our <a href="##SITE_URL##page/api-instructions">API  instructions</a>.</p>\r\n<p>We''re excited to see what you come up with!</p>\r\n<div class="footer">If you have any questions or comments  about the Developer API, please contact us at ##SITE_CONTACT_EMAIL##.</div>\r\n</div>\r\n</div>\r\n', NULL, 0, NULL, NULL, 0, '', NULL, 'api', 0);
INSERT INTO `pages` (`id`, `created`, `modified`, `parent_id`, `title`, `content`, `template`, `draft`, `lft`, `rght`, `level`, `description_meta_tag`, `url`, `slug`, `is_default`) VALUES
(17, '2010-06-15 14:58:05', '2010-08-07 05:19:26', NULL, 'API Instructions', '<h3 id="sites-page-title-header">&nbsp;</h3>\r\n<div id="api-instructionblock">\r\n<div style="margin: 6px; padding: 0px; font-family: Verdana; font-size: 10pt; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); line-height: normal;" _mce_style="margin: 6px; padding: 0px; font-family: Verdana; font-size: 10pt; background-color: #ffffff; color: #000000; line-height: normal;">\r\n<h1 style="font-size: 18pt;" _mce_style="font-size: 18pt;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;"><a class="mceItemAnchor" name="TOC-##SITE_NAME##-API"></a>##SITE_NAME## API</span></h1>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;"><strong>Version</strong>: 1.0</span></div>\r\n<h3 style="font-size: 12pt;" _mce_style="font-size: 12pt;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;"><a class="mceItemAnchor" name="TOC-About-the-##SITE_NAME##-API"></a>About  the ##SITE_NAME## API</span></h3>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;">The  goal of this API is to allow applications to directly interact with  ##SITE_NAME## via a REST API. &nbsp;This document describes supported aspects of  the API, focusing primarily on exposure of item content based on  geography.</span></div>\r\n<h3 style="font-weight: normal; color: rgb(68, 68, 68); font-size: 12pt;" _mce_style="font-weight: normal; color: #444444; font-size: 12pt;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;"><a class="mceItemAnchor" name="TOC-API-Token"></a>API Token</span></h3>\r\n<div><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;">An API token will be  required on all inbound requests. &nbsp;This token is a 36 character string  is generated by the system as part of signing up to use the API. and  should used while rquesting for the data.</span></div>\r\n<div>\r\n<h3 style="font-size: 12pt;" _mce_style="font-size: 12pt;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;"><a class="mceItemAnchor" name="TOC-Supported-Formats"></a>Supported  Formats</span></h3>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;">JSON and  XML formats will be supported. &nbsp;Naming conventions for elements  throughout the API will use underscores (i.e. "this_is_valid") rather  than camel-case. &nbsp;Specifying a supported format type on any request will  return a response in that format. &nbsp;The format may be specified by  appending an extension at the end of a URL (.xml, or .json).</span></div>\r\n<span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;"><br>\r\n</span><h3 style="font-size: 12pt;" _mce_style="font-size: 12pt;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;"><a class="mceItemAnchor" name="TOC-Error-Handling"></a>Error Handling</span></h3>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;">HTTP error codes will be  returned in response headers, unless the caller chooses bypasses this  functionality and assumes responsibility for parsing the content of the  response while receiving an HTTP status code of 200 (OK) (this is only  suggested for developers using frameworks that do not support parsing of  HTTP response headers).</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;">Each response will contain a result code, and an  optional message associated with it, such as follows:</span></div>\r\n</div>\r\n\r\n<table style="font-size: 1em; line-height: inherit; border-collapse: collapse; width: 550px;" _mce_style="font-size: 1em; line-height: inherit; border-collapse: collapse; width: 550px;" border="1" bordercolor="#000000" cellpadding="3" cellspacing="0">\r\n<tbody>\r\n<tr style="text-align: left;" _mce_style="text-align: left;">\r\n<td style="text-align: center;" _mce_style="text-align: center;" width="46"><strong>Type</strong></td>\r\n<td style="text-align: center;" _mce_style="text-align: center;" width="199"><strong>Description</strong></td>\r\n<td style="text-align: center;" _mce_style="text-align: center;" width="454"><strong>Example</strong><br></td>\r\n</tr>\r\n<tr style="text-align: left;" _mce_style="text-align: left;">\r\n<td width="46">JSON</td>\r\n<td width="199">Status element will appear at the top level  of response</td>\r\n<td width="454">\r\n<blockquote style="padding: 10px; border-style: none; margin: 0px 0px 0px 40px;" _mce_style="padding: 10px; border-style: none; margin: 0px 0px 0px 40px;"><span style="color: rgb(58, 67, 78);" _mce_style="color: #3a434e;">''status'': {</span><br><span style="color: rgb(58, 67, 78);" _mce_style="color: #3a434e;">&nbsp;&nbsp;''code'' &nbsp; : 0</span><br>\r\n<span style="color: rgb(58, 67, 78);" _mce_style="color: #3a434e;">&nbsp;&nbsp;''message'': "Item Found"</span><br>\r\n<span style="color: rgb(58, 67, 78);" _mce_style="color: #3a434e;">}</span></blockquote>\r\n</td>\r\n</tr>\r\n<tr style="text-align: left;" _mce_style="text-align: left;">\r\n<td width="46">XML</td>\r\n<td width="199">A top-level response element contains  attributes detailing the code &amp; message</td>\r\n<td width="454">\r\n<blockquote style="padding: 10px; border-style: none; margin: 0px 0px 0px 40px;" _mce_style="padding: 10px; border-style: none; margin: 0px 0px 0px 40px;"><span style="color: rgb(58, 67, 78);" _mce_style="color: #3a434e;">&lt;response code="0" message="Item Found"&gt;</span><br>\r\n    <span style="color: rgb(58, 67, 78);" _mce_style="color: #3a434e;">&nbsp;&nbsp;...</span><br><span style="color: rgb(58, 67, 78);" _mce_style="color: #3a434e;">&lt;/response&gt;</span></blockquote>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>\r\n<div style="margin: 6px; padding: 0px; font-family: Verdana; font-size: 10pt; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);  line-height: normal;" _mce_style="margin: 6px; padding: 0px; font-family: Verdana; font-size: 10pt; background-color: #ffffff; color: #000000;  line-height: normal;">\r\n<h3 style="font-size: 12pt;" _mce_style="font-size: 12pt;">&nbsp;</h3>\r\n<h3 style="font-size: 12pt;" _mce_style="font-size: 12pt;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;"><a class="mceItemAnchor" name="TOC-Dates-Times"></a>Dates &amp; Times</span></h3>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;">Throughout the API, date  and time fields will be specified in ISO 8601 format. &nbsp;All times should  be assumed to be returned in UTC. &nbsp;In order to avoid ambiguities,  however, timezone will always be present in any date &amp; time field as  an offset. &nbsp;See http://en.wikipedia.org/wiki/ISO_8601 for more  information.</span></div>\r\n<span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;">Because  time will always be expressed as UTC, it is the responsibility of the  API developer to parse and adjust these values accordingly. &nbsp;The API  will document places in which these values refer to a specific  geographic timezone.\r\n</span><div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;"><br>\r\n</span><div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;">Examples:</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px; text-align: left;" _mce_style="margin-top: 0px; margin-bottom: 0px; text-align: left;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;"><strong>&quot;Jun 16, 2010 10:38 AM&quot;</strong>&nbsp;(date  &amp; time)</span></div>\r\n<span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;"><br>\r\n</span><h3 style="font-size: 12pt;" _mce_style="font-size: 12pt;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;"><a class="mceItemAnchor" name="TOC-Currency"></a>Currency</span></h3>\r\n<span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;">Currency  is represented as string values composed of a decimal value followed by  a three letter currency code. &nbsp;See  http://en.wikipedia.org/wiki/ISO_4217 for more information. &nbsp;The decimal  value will not have any locale-specific formatting applied to it. &nbsp;A  period (''.'') will signify the decimal in any and all supported currency  types.</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;">Examples:</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;">$400.50</span></div>\r\n<span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;"><br>\r\n</span><h3 style="font-size: 12pt;" _mce_style="font-size: 12pt;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;"><a class="mceItemAnchor" name="TOC-Images"></a>Images</span></h3>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;">Displaying image content is crucial for  communicating both details and attractiveness of a item. &nbsp;Since API  developers may be working in a variety of media and devices, images for  item content will be supplied in three sizes.</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;">&nbsp;&nbsp;  &nbsp;35x35 pixels&nbsp;- small</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;">&nbsp;&nbsp; &nbsp;185x125 pixels&nbsp;-  medium</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;">&nbsp;&nbsp; &nbsp;437x264 pixels&nbsp;- large</span></div>\r\n<span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;"><br>\r\n</span><div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="color: rgb(0, 0, 0); font-family: Times; font-size: medium; line-height: normal;" _mce_style="color: #000000; font-family: Times; font-size: medium; line-height: normal;">Although it will not happen  frequently, ##SITE_NAME## reserves the right to update image content, so API  developers need to take this into consideration when applying any kind  of caching of image content.</span></div>\r\n<h3 style="font-size: 12pt;" _mce_style="font-size: 12pt;">&nbsp;</h3>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"></div>\r\n</div>\r\n</div>\r\n</p>\r\n<h3 id="sites-page-title-header"><span id="sites-page-title" dir="ltr">Items API</span></h3>\r\n<p><span style="color: rgb(0, 0, 0); font-family: Verdana,sans-serif; line-height: normal;" _mce_style="color: #000000; font-family: Verdana,sans-serif; line-height: normal;">\r\n<h2 style="font-weight: normal; color: rgb(68, 68, 68);" _mce_style="font-weight: normal; color: #444444;"><a class="mceItemAnchor" name="TOC-Retrieving-Featured-Item"></a><span style="color: rgb(0, 0, 0); font-weight: bold;" _mce_style="color: #000000; font-weight: bold;"><span style="font-size: small;" _mce_style="font-size: small;">Retrieving  Featured Item</span></span></h2>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><strong><span style="font-size: small;" _mce_style="font-size: small;"><br></span></strong></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><strong>URL:</strong></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">&nbsp;&nbsp;  &nbsp;##SITE_URL##newyork/items.json</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="font-family: ''Courier New'',sans-serif;" _mce_style="font-family: ''Courier New'',sans-serif;"><br></span></div>\r\n<strong>Supported Formats:</strong><br>&nbsp;&nbsp; &nbsp;JSON / XML<br>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="font-family: ''Courier New'',sans-serif;" _mce_style="font-family: ''Courier New'',sans-serif;"><br></span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="font-family: ''Courier New'',sans-serif;" _mce_style="font-family: ''Courier New'',sans-serif;"><br></span></div>\r\n<strong>Description:</strong><br>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;">&nbsp;&nbsp; &nbsp;Returns a list of  items. &nbsp;The API returns an ordered list of items currently running for a  given Division. &nbsp;Priority is based on position within the response (top  items are higher in priority).</div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"></div>\r\n<h4 style="font-size: 10pt;" _mce_style="font-size: 10pt;"><a class="mceItemAnchor" name="TOC-Item-Response"></a><strong><span style="color: rgb(0, 0, 0);" _mce_style="color: #000000;">Item Response</span></strong></h4>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">id</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;">&nbsp;&nbsp; &nbsp;Description: A unique  identifier for a specific item. &nbsp;Allowable characters include  [a-z][0-9][-], and will contain no whitespace.</div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;">&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">my-great-restaurant-item</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">item_url</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;">&nbsp;&nbsp; &nbsp;Description: A URL for  the item as it can be accessed on the main ##SITE_NAME## site. &nbsp;This would be  the same URL a user would enter to access the item in a web browser.</div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;">&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">##SITE_URL##item/green-door-tavern</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">title</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;">&nbsp;&nbsp; &nbsp;Description: A  one-line summary of the item.</div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;">&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">$10 for $25  Worth of Food and Drink at Green Door Tavern</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">small_image_url</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">medium_image_url</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">large_image_url</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;">&nbsp;&nbsp; &nbsp;Description: Fixed size URLs for the main  image associated with the item</div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;">&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-size: x-small;" _mce_style="font-size: x-small;"><span style="font-family: ''Courier  New'';" _mce_style="font-family: ''Courier  New'';">##SITE_URL##img/medium_big_thumb/Item/0.a5522c7c3f8b1a86fbd764dcad1cf216.jpg</span></span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">division_id</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: A unique identifier for the  division that the item is located in. &nbsp;Allowable characters include  [a-z][0-9][-], and will contain no whitespace. &nbsp;The identifier for a  division may or may not be geographic in nature.</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">minneapolis-stpaul</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">division_name</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: The human-readable form of  the division id.</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">Minneapolis / St Paul</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">division_lat</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">division_lng</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: Geographic coordinates.  &nbsp;These coordinates will only appear in cases where the division is  geographic in nature. &nbsp;##SITE_NAME## reserves the right to define divisions  which span multiple geographic regions, and in this case, geographic  coordinate smay not present.</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-size: x-small;" _mce_style="font-size: x-small;"><span style="font-family: ''Courier  New'';" _mce_style="font-family: ''Courier  New'';">41.88941 , -87.624039</span></span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">vendor_id</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: A unique identifier for the  vendor providing this item. &nbsp;Allowable characters include [a-z][0-9][-],  and will contain no whitespace.</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">green-door-tavern</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">vendor_name</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: A human-readable form of the  vendor id.</div>\r\n<div>&nbsp;&nbsp;  &nbsp;Example:&nbsp;<span style="font-family: Courier New,sans-serif;" _mce_style="font-family: Courier New,sans-serif;">Green Door  Tavern</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">vendor_website_url</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: The external URL for the  vendor, if available. &nbsp;This URL will not point back to any content on  ##SITE_NAME##.com.</div>\r\n<div>&nbsp;&nbsp;  &nbsp;Example:&nbsp;<span style="font-family: Courier New,sans-serif;" _mce_style="font-family: Courier New,sans-serif;">http://www.greendoorchicago.com</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">status</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: The status of the item. &nbsp;A  item will either be ''<span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">open</span>'', or ''<span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">closed</span>'' depending on whether it is currently  active and allowing purchases, or no longer available for purchase.</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">open</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">start_date</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: The date and time at which  the item became available (status: open), represented in UTC.</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-size: x-small;" _mce_style="font-size: x-small;"><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">Jun 16, 2010 10:38 AM</span></span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">end_date</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: For closed items, the date  and time at which the item no longer became available. &nbsp;For items that  are currently open, this represents the closing date and time of the  item.</div>\r\n<div>&nbsp;&nbsp;  &nbsp;Example:&nbsp;<span style="font-size: x-small;" _mce_style="font-size: x-small;"><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">Jun 19, 2010 10:38 AM</span></span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">tipped</span></div>\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;">&nbsp;&nbsp; &nbsp;Description: A boolean value (true, false)  that indicates whether this item has tipped. &nbsp;A item is considered  ''tipped'' when it reaches a tipping point, whereby a minimum number of  members join.</div>\r\n<div>&nbsp;&nbsp;  &nbsp;Example:&nbsp;<span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">true / false</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">tipping_point</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: The minimum number (zero or  more) of purchases that must be met by all participants in the item in  order for the item to tip.</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">100</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">tipped_date</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: For any items that have  tipped, the date and time at which the item tipped. &nbsp;For items that did  not tip, this field will not be present.</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';"><span style="font-size: x-small;" _mce_style="font-size: x-small;">Aug 16, 2010 10:38 AM</span></span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">sold_out</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: A boolean value indicating  whether the item had specified a limited quantity available, and that  quantity sold out. &nbsp;This provides an easy way for clients to visually  indicate that the item ended early due to a limited quantity being  depleted. &nbsp;If the item does not have limits applied, or has not yet sold  out, this value will be false.</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: Courier New,sans-serif;" _mce_style="font-family: Courier New,sans-serif;">true / false</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">quantity_sold</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: The number of units sold so  far. &nbsp;For items that have closed, this number represents the total  number of units sold.</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: Courier New,sans-serif;" _mce_style="font-family: Courier New,sans-serif;">174</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">price</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: The discounted cost of each  unit to the customer.</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">40.00USD</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">value</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: The actual value of the  ##SITE_NAME##. &nbsp;This is effectively the full value of the ##SITE_NAME## when it is  redeemed.</div>\r\n<div>&nbsp;&nbsp;  &nbsp;Example:&nbsp;<span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">80.00USD</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">discount_amount</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description:&nbsp;</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;</div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">discount_percent</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: The discounted percent  (0-100). &nbsp;This is effectively the same as (price / value * 100).</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: Courier New,sans-serif;" _mce_style="font-family: Courier New,sans-serif;">60</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">shipping_address_required</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: ##SITE_NAME## which would require a  user to enter a shipping address. &nbsp;This denotes a item whose purchase  will require the user to supply such an address in order to redeem.</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: Courier New,sans-serif;" _mce_style="font-family: Courier New,sans-serif;">true / false</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">limited_quantity</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: This flag dictates whether or  not there are only a limited quantity of inventory available for this  item. &nbsp;Once this limit is reached, the item is ''sold out'' (see above).</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: Courier New,sans-serif;" _mce_style="font-family: Courier New,sans-serif;">true / false</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">initial_quantity</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: The initial quantity  available. &nbsp;If quantity is limited, this value will normally not change,  unless the merchant / vendor decides to open up more inventory once the  item is launched.</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: Courier New,sans-serif;" _mce_style="font-family: Courier New,sans-serif;">250</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">quantity_remaining</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: The quantity still available  for purchase. &nbsp;Upon launching, this value will equal the ''initial  quantity''. &nbsp;For items that sell out, this will equal zero.</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="font-family: Courier New,sans-serif;" _mce_style="font-family: Courier New,sans-serif;">249</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">minimum_purchase</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: The minimum amount that a  customer must order in order to purchase this item.</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example: <span style="font-family: ''Courier New'',sans-serif;" _mce_style="font-family: ''Courier New'',sans-serif;">2</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">maximum_purchase</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: The maximum number which any  single customer is allowed to purchase. &nbsp;In rare cases this number may  be ''1'', but normally&nbsp;</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example: <span style="font-family: ''Courier New'',sans-serif;" _mce_style="font-family: ''Courier New'',sans-serif;">7</span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">expiration_date</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: The date at which a voucher  will expire.</div>\r\n<div>&nbsp;&nbsp;  &nbsp;Example:&nbsp;<span style="white-space: pre;" _mce_style="white-space: pre;"><span style="font-family: ''courier new'',monospace;" _mce_style="font-family: ''courier new'',monospace;">Aug 16, 2010 10:38 AM</span></span></div>\r\n<div><span style="font-family: ''Courier New'';" _mce_style="font-family: ''Courier New'';">details</span></div>\r\n<div>&nbsp;&nbsp; &nbsp;Description: An array of details and  restrictions for this item. &nbsp;This is effectively the ''Fine Print'' which  appears on the site itself.</div>\r\n<div>&nbsp;&nbsp; &nbsp;Example:&nbsp;<span style="white-space: pre;" _mce_style="white-space: pre;"><span style="font-family: ''courier new'',monospace;" _mce_style="font-family: ''courier new'',monospace;">Limit 1 per person. May purchase 1 <br>additional as gift.</span></span></div>\r\n<div><span style="font-family: Arial,Verdana,sans-serif;" _mce_style="font-family: Arial,Verdana,sans-serif;">\r\n<div><strong>Sample Response (JSON)</strong></div>\r\n\r\n<PRE>\r\n\r\n{\r\n  "status"\r\n  "message":"Items found",\r\n  "items":[\r\n    {\r\n      "id":"242",\r\n      "item_url":"##SITE_URL##item/item02-2",\r\n      "title":"item02",\r\n      "small_image_url":"##SITE_URL##img/small_thumb/Item/.797b12d0ec6fbdca1b761768ab59e233.jpg",\r\n      "medium_image_url":"##SITE_URL##img/small_big_thumb/Item/.101835f24ac2fc3c5cfdad6426a8ef3c.jpg",\r\n      "large_image_url":"##SITE_URL##img/medium_big_thumb/Item/.db548c3ddb67f895f0495c53f3fc2a23.jpg",\r\n      "division_id":"6618",\r\n      "division_name":"Kigali",\r\n      "division_lat":"-1.95",\r\n      "division_lng":"30.0667",\r\n      "vendor_id":"30",\r\n      "vendor_name":"dcom01",\r\n      "vendor_website_url":"http:\\/\\/www.google.com",\r\n      "status":"Paid To Restaurant",\r\n      "start_date":"Jun 16, 2010 10:38 AM",\r\n      "end_date": "Jun 19, 2010 10:38 AM",\r\n      "tipped":"false",\r\n      "tipping_point":"1",\r\n      "tipped_date":"Not Yet Tipped",\r\n      "quantity_sold":"2",\r\n      "price":"$9.00",\r\n      "value":"$10.00",\r\n      "discount_amount":"$1.00",\r\n      "discount_percent":"10%",\r\n      "conditions":{\r\n        "limited_quantity":"true",\r\n        "initial_quantity":"1",\r\n        "quantity_remaining":0,\r\n        "minimum_purchase":"1",\r\n        "maximum_purchase":"2",\r\n        "expiration_date":"Aug 19, 2010 10:38 AM",\r\n        "details":{\r\n          "detail":"<p>Test Item<\\/p>"\r\n        }\r\n      }\r\n    }\r\n\r\n  ]\r\n}\r\n<div style="margin-top: 0px; margin-bottom: 0px;" _mce_style="margin-top: 0px; margin-bottom: 0px;"><span style="font-family: Arial,Verdana,sans-serif;" _mce_style="font-family: Arial,Verdana,sans-serif;">\r\n</div>\r\n</PRE>\r\n</div>\r\n</div>\r\n', NULL, 0, NULL, NULL, 0, '', NULL, 'api-instructions', 0),
(13, '2010-05-25 11:20:54', '2010-05-25 11:44:22', NULL, 'Whitelist ##SITE_NAME## in your Email', '<div class="page_content table">\r\n<h3>Add ##SITE_NAME## to your address book to ensure email delivery.</h3>\r\n<p>Find your web-based email subscriber below, and follow the step-by-step instructions on how to add <a title="Add ##SITE_CONTACT_EMAIL##" href="mailto:##SITE_CONTACT_EMAIL##">##SITE_CONTACT_EMAIL##</a> to your address book.</p>\r\n<p>If your email provider is not listed below, please contact them directly.</p>\r\n<div class="address_wrap" style="border-top: 1px solid #cccccc; margin: 10px 0pt; padding: 20px 0pt;"><img style="margin: 10px 0pt;" title="AOL" src="##SITE_URL##img/blue-theme/subscription_welcome_mail/logo_AOL.gif" alt="" width="153" height="31" />\r\n<h5>AOL&reg; Webmail Users:</h5>\r\n<ol>\r\n<li>Open your email message.</li>\r\n<li>Click on ''More Details'' at the top of your email message.</li>\r\n<li>Hover mouse over the From address.</li>\r\n<li>Our email address is automatically placed in the email field in the "Add Contact" pop-up box.</li>\r\n<li>Add additional contact information.</li>\r\n<li>Click on ''Add Contact''.</li>\r\n<li>Our email address will be automatically entered into your AOL Address Book.</li>\r\n</ol>\r\n<p>If you encounter any problems, <a href="http://help.aol.com/help/microsites/microsite.do">contact AOL Support</a>.</p>\r\n</div>\r\n<div class="address_wrap" style="border-top: 1px solid #cccccc; margin: 10px 0pt; padding: 20px 0pt;"><img style="margin: 10px 0pt;" title="Yahoo" src="##SITE_URL##img/blue-theme/subscription_welcome_mail/logo_Yahoo.jpg" alt="" />\r\n<h5>Yahoo&reg; Users:</h5>\r\n<ol>\r\n<li>Open your email message.</li>\r\n<li>Click on ''Add'' icon next to From address.</li>\r\n<li>Our email address is automatically placed in the email field in the "Add Contact" pop-up box.</li>\r\n<li>Add additional contact information.</li>\r\n<li>Click on ''Save''.</li>\r\n<li>Our email address will be automatically entered into your Yahoo! Address Book.</li>\r\n</ol>\r\n<p>If you encounter any problems, <a href="http://help.yahoo.com/l/us/yahoo/helpcentral/">contact Yahoo Support</a>.</p>\r\n</div>\r\n<div class="address_wrap" style="border-top: 1px solid #cccccc; margin: 10px 0pt; padding: 20px 0pt;"><img style="margin: 10px 0pt;" title="Hotmail" src="##SITE_URL##img/blue-theme/subscription_welcome_mail/logo_Hotmail.jpg" alt="" width="106" height="29" />\r\n<h5>Window Live Hotmail&reg; Users:</h5>\r\n<ol>\r\n<li>Open your email message.</li>\r\n<li>Click on ''Mark as safe'' at the top of the message.</li>\r\n<li>Our email address will be automatically entered into your Safe senders list.</li>\r\n</ol>\r\n<p>If you encounter any problems, <a href="http://help.live.com/help.aspx?project=a&amp;market=en-us">Window Live Hotmail Support</a>.</p>\r\n</div>\r\n<div class="address_wrap" style="border-top: 1px solid #cccccc; margin: 10px 0pt; padding: 20px 0pt;"><img style="margin: 10px 0pt;" title="Google" src="##SITE_URL##img/blue-theme/subscription_welcome_mail/logo_Google.jpg" alt="" />\r\n<h5>Google Mail&reg; Users:</h5>\r\n<ol>\r\n<li>Open your email message.</li>\r\n<li>Click on down arrow next to ''Reply'' on top right of the message.</li>\r\n<li>From drop down menu click on ''Add to Contact List''.</li>\r\n<li>Our email address will be automatically entered into your contacts list.</li>\r\n</ol>\r\n<p>If you encounter any problems, <a href="http://mail.google.com/support/">Google Support</a>.</p>\r\n</div>\r\n<div class="address_wrap" style="border-top: 1px solid #cccccc; margin: 10px 0pt; padding: 20px 0pt;"><img style="margin: 10px 0pt;" title="Earthlink" src="##SITE_URL##img/blue-theme/subscription_welcome_mail/logo_Earthlink.jpg" alt="" width="119" height="22" />\r\n<h5>EarthLink&reg; Users:</h5>\r\n<ol>\r\n<li>Open your email message.</li>\r\n<li>Click your mailbox''s "Message" menu and choose "Add Senders" to your Address Book.</li>\r\n<li>Your email message will be automatically entered into your EarthLink Address Book.</li>\r\n</ol>\r\n<p>If you encounter any problems, <a href="http://support.earthlink.net/">contact EarthLink Support</a>.</p>\r\n</div>\r\n<div class="address_wrap" style="border-top: 1px solid #cccccc; margin: 10px 0pt; padding: 20px 0pt;"><img style="margin: 10px 0pt;" title="Office Outlook" src="##SITE_URL##img/blue-theme/subscription_welcome_mail/logo_Office_Outlook.jpg" alt="" />\r\n<h5>Microsoft Outlook 2003/2007&reg; Users:</h5>\r\n<ol>\r\n<li>Open your email message.</li>\r\n<li>Click on ''Actions'' from the menu bar.</li>\r\n<li>Click on ''Junk E-mail'' from drop down menu.</li>\r\n<li>Click on ''Add Sender to Safe Senders List''.</li>\r\n<li>Our email address will be automatically entered into your Safe senders list.</li>\r\n<li>Click on ''Junk E-mail'' from drop down menu.</li>\r\n</ol>\r\n<p>If you encounter any problems, <a href="http://office.microsoft.com/en-us/outlook/default.aspx">contact Outlook Support</a>.</p>\r\n</div>\r\n<div class="address_wrap" style="border-top: 1px solid #cccccc; margin: 10px 0pt; padding: 20px 0pt;"><img style="margin: 10px 0pt;" title="AOL mail" src="##SITE_URL##img/blue-theme/subscription_welcome_mail/logo_AOL_mail.jpg" alt="" />\r\n<h5>AOL&reg; Users:</h5>\r\n<ol>\r\n<li>Open your email message.</li>\r\n<li>Click on the "Add Address" icon.</li>\r\n<li>Our email address is automatically placed in the name and email field in the "Add Contact" pop-up box. Verify the information is correct and then...</li>\r\n<li>Click the Save button.</li>\r\n<li>Your email message will be automatically entered into your AOL Address Book.</li>\r\n</ol>\r\n<p>If you encounter any problems, <a href="http://help.aol.com/help/microsites/microsite.do">contact AOL Support</a>.</p>\r\n</div>\r\n<p>Please contact your email provider directly if not on the list above.</p>\r\n</div>', NULL, 0, NULL, NULL, 0, '', NULL, 'whitelist', 0);
INSERT INTO `pages` (`id`, `created`, `modified`, `parent_id`, `title`, `content`, `template`, `draft`, `lft`, `rght`, `level`, `description_meta_tag`, `url`, `slug`, `is_default`) VALUES
(15, '2010-06-15 14:49:05', '2010-08-05 14:39:18', NULL, '##SITE_NAME##  API TERMS OF USE', '<div class="page_content table">\r\n<div class="api_body">\r\n<h2>En Fran&ccedil;ais</h2>\r\n<h2>##SITE_NAME## <span class="caps">API</span> <span class="caps">TERMS</span> OF <span class="caps">USE</span></h2>\r\n<p>&nbsp;</p>\r\n<p>This document governs the terms under which you may  access and use the application programming interface that is made  available on this website (the &ldquo;<strong><span class="caps">API</span></strong>&rdquo;),  and the data transmitted through the <span class="caps">API</span> (the &ldquo;##SITE_NAME##<strong> Content</strong>&rdquo;).  This document incorporates the terms of the following  additional documents, including all future amendments or modifications  thereto (collectively, and together with this document, the &ldquo;<strong><span class="caps">API</span> Agreement</strong>&rdquo;):</p>\r\n<ul class="apiinstruction-list">\r\n<li><a href="##SITE_URL##page/api-branding-requirements">##SITE_NAME## Branding Requirements</a></li>\r\n<li><a href="##SITE_URL##page/term-and-conditions">##SITE_NAME## Terms of Service</a></li>\r\n<li><a href="##SITE_URL##page/privacy_policy">##SITE_NAME## Privacy Policy</a></li>\r\n</ul>\r\n<div class="apiinstruction-block">\r\n<p>By accessing or using the <span class="caps">API</span> or ##SITE_NAME## Content, you agree to be bound by the <span class="caps">API</span> Agreement.  If you access or use the <span class="caps">API</span> or ##SITE_NAME## Content on behalf of a company, principal or other entity, you  represent that you have authority to bind such entity and its affiliates  to the <span class="caps">API</span> Agreement and that it is fully  binding upon them.  In such case, the term &ldquo;you&rdquo; will refer to such  entity and its affiliates.  If you do not have authority, or if you do  not agree with the terms of the <span class="caps">API</span> Agreement,  you may not access or use the <span class="caps">API</span> or ##SITE_NAME##  Content.  You should read and keep a copy of each component of the <span class="caps">API</span> Agreement for your records.  In the event of a  conflict among them, the terms of this document will control.</p>\r\n<p><strong>1. <span style="text-decoration: underline;">Purpose</span></strong></p>\r\n<p>The <span class="caps">API</span> is made available by ##SITE_NAME##, Inc. ##SITE_NAME##") to enable others to access valuable local  information and present it to their end users in new and imaginative  ways that are more complementary than competitive in nature to ##SITE_NAME##&rsquo;s  own services.  With this in mind, ##SITE_NAME## reserves the right to  continually review and evaluate all uses of the <span class="caps">API</span>.</p>\r\n<p><strong>2. <span style="text-decoration: underline;">Changes</span></strong></p>\r\n<p>##SITE_NAME## reserves the right to modify or revise the <span class="caps">API</span> Agreement at any time.  You should visit this  website periodically to review the documents comprising the <span class="caps">API</span> Agreement and check for updates.  Your continued  use of the <span class="caps">API</span> after the effective date of  any such changes will constitute your acceptance of and agreement to  such changes.  <strong>If <span class="caps">YOU</span> DO <span class="caps">NOT</span> <span class="caps">WISH</span> TO BE <span class="caps">BOUND</span> TO  <span class="caps">ANY</span> <span class="caps">NEW</span> <span class="caps">TERMS</span>, <span class="caps">YOU</span> <span class="caps">MUST</span> <span class="caps">TERMINATE</span> <span class="caps">THE</span> <span class="caps">API</span> <span class="caps">AGREEMENT</span> BY <span class="caps">IMMEDIATELY</span> <span class="caps">CEASING</span> <span class="caps">USE</span> OF <span class="caps">THE</span> <span class="caps">API</span>.</strong></p>\r\n<p><strong>3. <span style="text-decoration: underline;">Registration</span></strong></p>\r\n<p>In order to access or use the <span class="caps">API</span>,  you must first register for and receive a valid ##SITE_NAME##  Application Key and Token.  You are only allowed  to register for and use one <span class="caps">pair of Application Key and Token</span>, unless  otherwise permitted by ##SITE_NAME## in writing.  All queries sent to the <span class="caps">API</span> requesting data must reference your valid Application Key and Token pair ..  You agree to keep your Application Key and Token confidential and not to share it with any third party.</p>\r\n<p><strong>4. <span style="text-decoration: underline;">License</span></strong></p>\r\n<p>Subject to the terms set forth in the&nbsp;<a href="##SITE_URL##page/api-branding-requirements">##SITE_NAME##  Branding Requirements</a> and elsewhere in the <span class="caps">API</span> Agreement, ##SITE_NAME## grants you a non-exclusive, revocable,  non-sublicensable, non-transferable license to (i) access and use the <span class="caps">API</span> to receive the ##SITE_NAME## Content; (ii) display  the ##SITE_NAME## Content on your website or internet-connected application  for mobile devices (&ldquo;<strong>Your Site</strong>&rdquo;); and (iii) reproduce and display  the ##SITE_NAME## name and logo (the &ldquo;##SITE_NAME##<strong> Brand Features</strong>&rdquo;) solely  in order to comply with the&nbsp;<a href="##SITE_URL##/page/api-branding-requirements">##SITE_NAME##  Branding Requirments</a>.</p>\r\n<p>You may not use the <span class="caps">API</span>, ##SITE_NAME## Content, or ##SITE_NAME## Brand Features for any other purpose without ##SITE_NAME##&rsquo;s prior written consent.  These license rights are further  limited by the restrictions set forth elsewhere in the <span class="caps">API</span> Agreement, and all rights not expressly granted  to you hereunder are reserved by ##SITE_NAME##.  You acknowledge and agree  that ##SITE_NAME## may monitor Your Site in order to confirm compliance with  the <span class="caps">API</span> Agreement.</p>\r\n<p><strong>5. <span style="text-decoration: underline;">Restrictions</span></strong></p>\r\n<p>You agree that you will not, and will not assist or  enable others to:</p>\r\n</div>\r\n<ol class="apiinstruction-list" style="list-style-type: upper-alpha; list-style-position: inside;">\r\n<li>cache, record, pre-fetch, or otherwise store any  portion of the ##SITE_NAME## Content, or attempt or provide a means to execute  any &ldquo;bulk download&rdquo; operations;</li>\r\n<li>modify the ##SITE_NAME## Content, or use it to update or  create your own database of business listing information;</li>\r\n<li>create or disclose metrics about, or perform any  statistical analysis of, the <span class="caps">API</span> or ##SITE_NAME##  Content;</li>\r\n<li>use the <span class="caps">API</span> on behalf of  any third party;</li>\r\n<li>display ##SITE_NAME## Brand Features or ##SITE_NAME## Content in  a manner that could reasonably imply an endorsement, relationship or  affiliation with or sponsorship between you or a third party and ##SITE_NAME##, other than your permitted use of the <span class="caps">API</span> under the terms of the <span class="caps">API</span> Agreement;</li>\r\n<li>copy, rent, lease, sell, transfer, assign,  sublicense, dissemble, reverse engineer or decompile (except to the  limited extent expressly authorized under applicable statutory law),  modify or alter any part of the <span class="caps">API</span>;</li>\r\n<li>modify, rate, rank, review, vote or comment on, or  otherwise respond to the ##SITE_NAME## Content;</li>\r\n<li>use the <span class="caps">API</span> in a manner  that impacts the stability of ##SITE_NAME##&rsquo;s servers or impacts the behavior  of other applications using the <span class="caps">API</span>;</li>\r\n<li>display the ##SITE_NAME## Content on any site that  disparages ##SITE_NAME## or its products or services, or infringes any ##SITE_NAME##  intellectual property or other rights;</li>\r\n<li>use the <span class="caps">API</span> or ##SITE_NAME##  Content in any manner or for any purpose that may violate any law or  regulation, or any right of any person including, but not limited to,  intellectual property rights, rights of privacy and/or rights of  personality, or which otherwise may be harmful (in ##SITE_NAME##&rsquo;s sole  discretion) to ##SITE_NAME##, its providers, its suppliers, end users of this  website, or your end users;</li>\r\n<li>use the <span class="caps">API</span>, ##SITE_NAME##  Content or ##SITE_NAME## Brand Features in a manner that could reasonably be  interpreted to suggest that ##SITE_NAME## is the author or entity that is  responsible, in whole or in part, for the creation or development of any ##SITE_NAME## Content or that such ##SITE_NAME## Content represents the views of ##SITE_NAME##;</li>\r\n<li>use the <span class="caps">API</span> or ##SITE_NAME##  Content in connection with or to promote any products, services or  materials that constitute, promote or are used primarily for the purpose  of iteming in: spyware, adware and/or other malicious programs or code;  counterfeit goods and/or items subject to U.S.  embargo; unsolicited  mass distributions of e-mail (&ldquo;spam&rdquo;), actions intended to mislead  search engines into ranking some pages higher than they would otherwise  deserve (&ldquo;web spam&rdquo;) multilevel marketing proposals, direct marketing  and/or telemarketing activities; hate materials; libelous, defamatory,  obscene, pornographic, abusive or otherwise offensive content;  prostitution, body parts and/or bodily fluids; stolen products and/or  items used for theft; hacking/surveillance/interception/descrambling  equipment; fireworks, explosives and/or other hazardous materials;  gambling; professional services regulated by state licensing regimes;  and/or non-transferable items such as airline tickets, event tickets,  weapons and/or weapons accessories;</li>\r\n</ol>\r\n<div class="apiinstruction-block">\r\n<p><strong>6. <span style="text-decoration: underline;">Proprietary Rights</span></strong></p>\r\n<p>As between you and ##SITE_NAME##, the <span class="caps">API</span>, ##SITE_NAME## Content, ##SITE_NAME## Brand Features, and all intellectual property  rights contained in the foregoing, are and will at all times remain the  sole and exclusive property of ##SITE_NAME## and are protected by applicable  intellectual property laws and treaties (whether those rights happen to  be registered or not, and wherever in the world those rights may  exist.).  You agree that at no time during or after the termination of  the <span class="caps">API</span> Agreement will you attempt to register  any trademarks (including domain names) that are confusingly similar in  any way to those of ##SITE_NAME## Brand Features or ##SITE_NAME## Content.</p>\r\n<p><strong>7. <span style="text-decoration: underline;">Termination</span></strong></p>\r\n<p>##SITE_NAME## reserves the right, in its sole discretion (for  any reason or for no reason) and at any time without notice to you, to  change, suspend or discontinue the <span class="caps">API</span> and/or  suspend or terminate your rights under the <span class="caps">API</span> Agreement to access, use and/or display (as applicable) the <span class="caps">API</span>, ##SITE_NAME## Brand Features and/or any ##SITE_NAME##  Content.  Any termination of the <span class="caps">API</span> Agreement  will also immediately terminate the licenses granted to you hereunder.   Such change, suspension or termination of the <span class="caps">API</span> may cause your existing services using the <span class="caps">API</span> to stop functioning properly.  Upon any termination of the <span class="caps">API</span> Agreement, you will promptly delete and remove  all calls to the <span class="caps">API</span> from all web pages,  scripts, widgets, applications, and other software in your possession or  under your control; promptly destroy and remove from all computers,  hard drives, networks and other storage media all copies of the <span class="caps">API</span>, ##SITE_NAME## Brand Features and/or any ##SITE_NAME##  Content; and you will promptly certify in writing to ##SITE_NAME## that such  actions have been taken.</p>\r\n<p><strong>8. <span style="text-decoration: underline;">Indemnity</span></strong></p>\r\n<p>You agree that your use of the <span class="caps">API</span> is at your own risk and you agree to hold harmless, defend (subject to ##SITE_NAME##&rsquo;s right to participate with counsel it selects) and indemnify ##SITE_NAME## and its subsidiaries, affiliates, officers, agents, employees  and suppliers from and against any and all claims, damages, liabilities,  costs and fees (including reasonable attorneys&rsquo; fee) arising from, or  in any way related to your or your end users&rsquo; use or implementation of  the <span class="caps">API</span> or any ##SITE_NAME## Content obtained from  the <span class="caps">API</span>.  You will not agree to any settlement  that imposes any obligation on ##SITE_NAME## without ##SITE_NAME##&rsquo;s prior consent.</p>\r\n<p><strong>9. <span style="text-decoration: underline;">No Warranties; No Support</span></strong></p>\r\n<p><span class="caps">THE</span> <span class="caps">API</span>, ##SITE_NAME## <span class="caps">BRAND</span> <span class="caps">FEATURES</span> <span class="caps">AND</span> ##SITE_NAME## <span class="caps">CONTENT</span> <span class="caps">ARE</span> <span class="caps">PROVIDED</span> &ldquo;AS IS&rdquo;, &ldquo;<span class="caps">WITH</span> <span class="caps">ALL</span> <span class="caps">FAULTS</span>&rdquo; <span class="caps">AND</span> &ldquo;AS <span class="caps">AVAILABLE</span>&rdquo; <span class="caps">WITHOUT</span> <span class="caps">WARRANTY</span>, OF <span class="caps">ANY</span> <span class="caps">KIND</span> <span class="caps">AND</span> AT <span class="caps">YOUR</span> <span class="caps">SOLE</span> <span class="caps">RISK</span>.  <span class="caps">EXCEPT</span> TO <span class="caps">THE</span> <span class="caps">MAXIMUM</span> <span class="caps">EXTENT</span> <span class="caps">REQUIRED</span> BY <span class="caps">APPLICABLE</span> <span class="caps">LAW</span>, ##SITE_NAME## <span class="caps">DISCLAIMS</span> <span class="caps">ALL</span> <span class="caps">WARRANTIES</span>, <span class="caps">REPRESENTATIONS</span>, <span class="caps">CONDITIONS</span>,  <span class="caps">AND</span> <span class="caps">DUTIES</span>, <span class="caps">WHETHER</span> <span class="caps">EXPRESS</span>, <span class="caps">IMPLIED</span> OR <span class="caps">STATUTORY</span>, <span class="caps">REGARDING</span> <span class="caps">THE</span> <span class="caps">API</span>, ##SITE_NAME## <span class="caps">BRAND</span> <span class="caps">FEATURES</span> <span class="caps">AND</span> <span class="caps">ANY</span> ##SITE_NAME## <span class="caps">CONTENT</span>, <span class="caps">INCLUDING</span>,  <span class="caps">WITHOUT</span> <span class="caps">LIMITATION</span>,  <span class="caps">ANY</span> <span class="caps">AND</span> <span class="caps">ALL</span> <span class="caps">IMPLIED</span> <span class="caps">WARRANTIES</span> OF <span class="caps">MERCHANTABILITY</span>,  <span class="caps">ACCURACY</span>, <span class="caps">RESULTS</span> OF <span class="caps">USE</span>, <span class="caps">RELIABILITY</span>,  <span class="caps">FITNESS</span> <span class="caps">FOR</span> A <span class="caps">PARTICULAR</span> <span class="caps">PURPOSE</span>, <span class="caps">TITLE</span>, <span class="caps">INTERFERENCE</span> <span class="caps">WITH</span> <span class="caps">QUIET</span> <span class="caps">ENJOYMENT</span> <span class="caps">AND</span> <span class="caps">NON</span>-<span class="caps">INFRINGEMENT</span> OF <span class="caps">THIRD</span>-<span class="caps">PARTY</span> <span class="caps">RIGHTS</span>.  <span class="caps">FURTHER</span>, ##SITE_NAME## <span class="caps">DISCLAIMS</span> <span class="caps">ANY</span> <span class="caps">WARRANTY</span> <span class="caps">THAT</span> <span class="caps">YOUR</span> <span class="caps">USE</span> OF <span class="caps">THE</span> <span class="caps">API</span> <span class="caps">WILL</span> BE <span class="caps">UNINTERRUPTED</span>, <span class="caps">SECURE</span>, <span class="caps">TIMELY</span> OR <span class="caps">ERROR</span> <span class="caps">FREE</span>.  <span class="caps">FOR</span> <span class="caps">THE</span> <span class="caps">AVOIDANCE</span> OF <span class="caps">DOUBT</span>, <span class="caps">YOU</span> <span class="caps">ACKNOWLEDGE</span> <span class="caps">AND</span> <span class="caps">AGREE</span> <span class="caps">THAT</span> <span class="caps">THE</span> <span class="caps">API</span> <span class="caps">AGREEMENT</span> <span class="caps">DOES</span> <span class="caps">NOT</span> <span class="caps">ENTITLE</span> <span class="caps">YOU</span> TO <span class="caps">ANY</span> <span class="caps">SUPPORT</span> <span class="caps">FOR</span> <span class="caps">THE</span> <span class="caps">API</span>.   NO <span class="caps">ADVICE</span> OR <span class="caps">INFORMATION</span>,  <span class="caps">WHETHER</span> <span class="caps">ORAL</span> OR IN <span class="caps">WRITING</span>, <span class="caps">OBTAINED</span> BY <span class="caps">YOU</span> <span class="caps">FROM</span> ##SITE_NAME## <span class="caps">WILL</span> <span class="caps">CREATE</span> <span class="caps">ANY</span> <span class="caps">WARRANTY</span> <span class="caps">NOT</span> <span class="caps">EXPRESSLY</span> <span class="caps">STATED</span> IN <span class="caps">THE</span> <span class="caps">API</span> <span class="caps">AGREEMENT</span>.</p>\r\n<p><strong>10. <span style="text-decoration: underline;">Limitation of Liability</span></strong></p>\r\n<p><span class="caps">THE</span> <span class="caps">API</span> IS <span class="caps">BEING</span> <span class="caps">PROVIDED</span> <span class="caps">FREE</span> OF <span class="caps">CHARGE</span>.  <span class="caps">ACCORDINGLY</span>, <span class="caps">YOU</span> <span class="caps">AGREE</span> <span class="caps">THAT</span> ##SITE_NAME## <span class="caps">SHALL</span> <span class="caps">HAVE</span> NO <span class="caps">LIABILITY</span> <span class="caps">ARISING</span> <span class="caps">FROM</span> OR <span class="caps">BASED</span> ON <span class="caps">YOUR</span> <span class="caps">USE</span> OF <span class="caps">THE</span> <span class="caps">API</span>.  <span class="caps">REGARDLESS</span> OF <span class="caps">WHETHER</span> <span class="caps">ANY</span> <span class="caps">REMEDY</span> <span class="caps">SET</span> <span class="caps">FORTH</span> <span class="caps">HEREIN</span> <span class="caps">FAILS</span> OF <span class="caps">ITS</span> <span class="caps">ESSENTIAL</span> <span class="caps">PURPOSE</span> OR <span class="caps">OTHERWISE</span>, <span class="caps">AND</span> <span class="caps">EXCEPT</span> <span class="caps">FOR</span> <span class="caps">BODILY</span> <span class="caps">INJURY</span>, IN NO <span class="caps">EVENT</span> <span class="caps">SHALL</span> ##SITE_NAME## OR <span class="caps">ITS</span> <span class="caps">SUBSIDIARIES</span>, <span class="caps">AFFILIATES</span>, <span class="caps">OFFICERS</span>, <span class="caps">AGENTS</span>, <span class="caps">EMPLOYEES</span> <span class="caps">AND</span> <span class="caps">SUPPLIERS</span> BE <span class="caps">LIABLE</span> TO <span class="caps">YOU</span> OR TO <span class="caps">ANY</span> <span class="caps">THIRD</span> <span class="caps">PARTY</span> <span class="caps">UNDER</span> <span class="caps">ANY</span> <span class="caps">TORT</span>, <span class="caps">CONTRACT</span>, <span class="caps">NEGLIGENCE</span>, <span class="caps">STRICT</span> <span class="caps">LIABILITY</span> OR <span class="caps">OTHER</span> <span class="caps">LEGAL</span> OR <span class="caps">EQUITABLE</span> <span class="caps">THEORY</span> <span class="caps">FOR</span> <span class="caps">ANY</span> <span class="caps">LOST</span> <span class="caps">PROFITS</span>, <span class="caps">LOST</span> OR <span class="caps">CORRUPTED</span> <span class="caps">DATA</span>, <span class="caps">COMPUTER</span> <span class="caps">FAILURE</span> OR <span class="caps">MALFUNCTION</span>, <span class="caps">INTERRUPTION</span> OF <span class="caps">BUSINESS</span>, OR <span class="caps">OTHER</span> <span class="caps">SPECIAL</span>, <span class="caps">INDIRECT</span>, <span class="caps">INCIDENTAL</span> OR <span class="caps">CONSEQUENTIAL</span> <span class="caps">DAMAGES</span> OF <span class="caps">ANY</span> <span class="caps">KIND</span> <span class="caps">ARISING</span> <span class="caps">OUT</span> OF <span class="caps">THE</span> <span class="caps">USE</span> OR <span class="caps">INABILITY</span> TO <span class="caps">USE</span> <span class="caps">THE</span> <span class="caps">API</span>,  <span class="caps">EVEN</span> IF ##SITE_NAME## <span class="caps">HAS</span> <span class="caps">BEEN</span> <span class="caps">ADVISED</span> OF <span class="caps">THE</span> <span class="caps">POSSIBILITY</span> OF <span class="caps">SUCH</span> <span class="caps">LOSS</span> OR <span class="caps">DAMAGES</span> <span class="caps">AND</span> <span class="caps">WHETHER</span> OR <span class="caps">NOT</span> <span class="caps">SUCH</span> <span class="caps">LOSS</span> OR <span class="caps">DAMAGES</span> <span class="caps">ARE</span> <span class="caps">FORESEEABLE</span>.  <span class="caps">ANY</span> <span class="caps">CLAIM</span> <span class="caps">ARISING</span> <span class="caps">OUT</span> OF OR <span class="caps">RELATING</span> TO <span class="caps">THE</span> <span class="caps">API</span> <span class="caps">AGREEMENT</span> <span class="caps">MUST</span> BE <span class="caps">BROUGHT</span> <span class="caps">WITHIN</span> (1) <span class="caps">YEAR</span> <span class="caps">AFTER</span> <span class="caps">THE</span> <span class="caps">OCCURRENCE</span> OF <span class="caps">THE</span> <span class="caps">EVENT</span> <span class="caps">GIVING</span> <span class="caps">RISE</span> TO <span class="caps">SUCH</span> <span class="caps">CLAIM</span>.  IF <span class="caps">SUCH</span> <span class="caps">CLAIM</span> IS <span class="caps">NOT</span> <span class="caps">FILED</span>, <span class="caps">THEN</span> <span class="caps">THAT</span> <span class="caps">CLAIM</span> IS <span class="caps">PERMANENTLY</span> <span class="caps">BARRED</span>.  <span class="caps">THIS</span> <span class="caps">APPLIES</span> TO <span class="caps">YOU</span> <span class="caps">AND</span> <span class="caps">YOUR</span> <span class="caps">SUCCESSORS</span>, <span class="caps">AND</span> TO ##SITE_NAME## <span class="caps">AND</span> <span class="caps">ITS</span> <span class="caps">SUCCESSORS</span>.  <span class="caps">NOTWITHSTANDING</span> <span class="caps">THE</span> <span class="caps">FOREGOING</span>, ##SITE_NAME##&rsquo;S <span class="caps">MAXIMUM</span> <span class="caps">LIABILITY</span> <span class="caps">UNDER</span> <span class="caps">THIS</span> <span class="caps">API</span> <span class="caps">AGREEMENT</span> <span class="caps">SHALL</span> <span class="caps">NOT</span>, IN <span class="caps">ANY</span> <span class="caps">EVENT</span>, <span class="caps">EXCEED</span> US$50.00.</p>\r\n<p><strong>11. <span style="text-decoration: underline;">Limited Relationship</span></strong></p>\r\n<p>##SITE_NAME## and you are, and will remain, independent  contractors, and nothing in the <span class="caps">API</span> Agreement  will be construed as creating an employer-employee relationship,  partnership or joint venture.  Although you are permitted to publicize  your use of the <span class="caps">API</span>, you agree not to make any  other statements, without the prior written consent of ##SITE_NAME##,  implying a different kind of relationship between you and ##SITE_NAME##,  including any implied endorsement of your content, products, or services  by ##SITE_NAME##.  You do not have any authority of any kind to bind ##SITE_NAME##  in any respect whatsoever.</p>\r\n<p><strong>12. <span style="text-decoration: underline;">Miscellaneous</span></strong></p>\r\n<p>The <span class="caps">API</span> Agreement encompasses  the entire agreement between you and ##SITE_NAME## regarding the subject  matter discussed therein.  The <span class="caps">API</span> Agreement,  and any disputes arising from or relating to the interpretation thereof,  will be governed by and construed under the laws of the State of  Illinois without regard to its conflict of law provisions.  You agree to  personal jurisdiction by and venue in the state and federal courts of  the State of Illinois, City of Chicago.  The failure of ##SITE_NAME## to  exercise or enforce any right or provision of the <span class="caps">API</span> Agreement will not constitute a waiver of such right or provision.  The  failure of either party to exercise in any respect any right provided  for herein will not be deemed a waiver of any further rights hereunder.   If any provision of the <span class="caps">API</span> Agreement is  found to be unenforceable or invalid, that provision will be replaced  with terms that most closely match the intent of the provision that is  not enforceable to the minimum extent necessary so that the remaining <span class="caps">API</span> Agreement will otherwise remain in full force  and effect and enforceable.  The <span class="caps">API</span> Agreement  is not assignable, transferable or sublicensable, in whole or in part,  by you except with ##SITE_NAME##&rsquo;s prior written consent. ##SITE_NAME## may assign  the <span class="caps">API</span> Agreement, in whole or in part, at any  time with or without notice to you.  Any attempt to do so is void.  The  section titles in the <span class="caps">API</span> Agreement are for  convenience only and have no legal or contractual effect.</p>\r\n<p><strong>13. <span style="text-decoration: underline;">Survival</span></strong></p>\r\n<p>Sections 6, 8, 9, 10, and 13 will survive any expiration  or termination of this <span class="caps">API</span> Agreement for any  reason.</p>\r\n<p><strong>14. <span style="text-decoration: underline;">Contact and Violations</span></strong></p>\r\n<p>Please contact ##SITE_NAME## with any questions regarding the <span class="caps">API</span> Agreement.  Please report any violations of the  <span class="caps">API</span> Agreement to api@##SITE_NAME##.com</p>\r\n</div>\r\n</div>\r\n</div>', NULL, 0, NULL, NULL, 0, '', NULL, 'api-terms-of-use', 0),
(16, '2010-06-15 14:51:31', '2010-06-15 14:48:21', NULL, 'API Branding Requirements', '<div class="section">\r\n<p>We want you to use our content in useful and  interesting ways, not boring or underhanded ways. To that end, we have  some rules in addition to those explained in the <a href="##SITE_URL##/page/api-terms-of-use">API Terms of Use</a>:</p>\r\n<div class="columns">\r\n<div class="column">\r\n<h3>Give Us Credit</h3>\r\n<p>Wherever you display our content, you must  prominently display our logo (see below). It should be obvious that the  information originates from ##SITE_NAME##. Also, don&rsquo;t claim responsibility or  sponsorship for ##SITE_NAME## content (e.g., ##SITE_NAME##&rsquo;s item of the day is  brought to you by Larry&rsquo;s Crab Shack).</p>\r\n<h3>Live in the Moment</h3>\r\n<p>The API is for real time user-driven requests.  Don&rsquo;t capture information from the API for later use.</p>\r\n<h3>Keep it Consumer Facing</h3>\r\n<p>Don&rsquo;t use ##SITE_NAME## information for non-consumer  purposes.</p>\r\n</div>\r\n<div class="column">\r\n<h3>Add Value</h3>\r\n<p>If you&rsquo;re only going to recreate the  functionality of ##SITE_NAME##&rsquo;s own website or mobile apps, save yourself the  trouble and just put up a link.</p>\r\n<h3>Enable Links</h3>\r\n<p>Don&rsquo;t &lsquo;nofollow&rsquo; your links to ##SITE_NAME##.</p>\r\n<h3>Give Us the Spotlight</h3>\r\n<p>Don&rsquo;t aggregate our items with other providers.</p>\r\n<h3>Leave Our Content Alone</h3>\r\n<p>Don&rsquo;t alter our logo, graphics, or copy provided  by ##SITE_NAME##.</p>\r\n</div>\r\n</div>\r\n<h3>For Mobile</h3>\r\n<p>Have clear ##SITE_NAME## branding at the top of app/mobile  pages where you&rsquo;re using and/or incorporating ##SITE_NAME## content. On  platforms where ##SITE_NAME## also has a mobile application, we may require  you to link directly to our application instead of our mobile site.</p>\r\n</div>', NULL, 0, NULL, NULL, 0, '', NULL, 'api-branding-requirements', 0),
(20, '2010-08-05 14:33:46', '2011-02-11 11:27:15', NULL, 'Payment FAQ', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque vulputate rhoncus erat, quis cursus erat porta sed. Maecenas augue mi, mattis vel mattis sed, dictum quis lorem. Mauris orci massa, interdum commodo convallis a, gravida id tortor. Nam et nisl vel nisi ullamcorper scelerisque. Sed mollis rutrum ultrices. Maecenas sed mattis mauris. Phasellus dolor velit, ultricies in suscipit sit amet, rhoncus vel nunc. Nunc vel mattis dui.</p>\r\n<p>Proin luctus semper tellus, et placerat est molestie a. Sed posuere enim sagittis nulla malesuada malesuada. In ut risus at augue venenatis volutpat ac et lacus. Fusce adipiscing, justo hendrerit tristique rutrum, nibh lorem vulputate mauris, sit amet vulputate leo turpis eu odio. Vivamus placerat bibendum est id fringilla. Donec euismod varius enim id auctor.</p>', NULL, 0, NULL, NULL, 0, '', NULL, 'payment-faq', 0),
(21, '0000-00-00 00:00:00', '2011-02-16 14:38:37', NULL, 'Lorem Ipsum', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and  typesetting industry. Lorem Ipsum has been the industry''s standard dummy  text ever since the 1500s, when an unknown printer took a galley of  type and scrambled it to make a type specimen book.</p>', NULL, 0, NULL, NULL, 0, NULL, NULL, 'subscription-footer', 0),
(22, '2011-02-24 13:14:17', '2011-02-24 13:17:07', NULL, 'Affiliate', '<p>In posuere molestie augue, eget tincidunt libero pellentesque nec.   Aliquam erat volutpat. Aliquam a ligula nulla, at suscipit odio. Nullam   in nibh nibh, eu bibendum ligula. Morbi eu nibh dui. Vivamus  scelerisque  fermentum lacus et tristique. Sed vulputate euismod metus  porta  feugiat. Nulla varius venenatis mauris, nec ornare nisl bibendum  id. Aenean id orci nisl, in scelerisque nibh. Sed quam sapien,  tempus quis  vestibulum eu, sagittis varius sapien. Aliquam erat  volutpat. Nulla  facilisi. In egestas faucibus nunc, et venenatis purus  aliquet quis.  Nulla eget arcu turpis. Nunc pellentesque eros quis neque  sodales  hendrerit. Donec eget nibh sit amet ipsum elementum vehicula.   Pellentesque molestie diam vitae erat suscipit consequat. Pellentesque   vel arcu sit amet metus mattis congue vitae eu quam.</p>\r\n<p>&nbsp;</p>\r\n<p>Nam dapibus vestibulum est, id blandit erat scelerisque id. Morbi   vestibulum dignissim sapien, vitae laoreet est vehicula et. Ut pulvinar   quam vel est cursus mollis. Nullam imperdiet faucibus odio, sed   imperdiet quam elementum id. Fusce varius, odio in porta rutrum,  urna  dolor porttitor sem, tempus lacinia mi tortor et libero.  Suspendisse et  ultricies urna. Nam luctus felis non turpis pretium  aliquam. Mauris non  felis sit amet nibh malesuada luctus ut sit amet  risus. Praesent ante  tellus, aliquet eget feugiat nec, viverra in elit.  Nulla dictum eros et  risus consequat mollis.</p>\r\n<p>&nbsp;</p>\r\n<p>Duis id lectus  eros. Class aptent taciti sociosqu ad litora torquent per  conubia  nostra, per inceptos himenaeos. Fusce eleifend eros quis ligula  porta  rutrum mattis non risus. Donec eget neque a turpis elementum  egestas  nec a enim. Ut ut quam lorem, eget dapibus dolor. Vestibulum nec  turpis  erat, eget luctus magna. Phasellus ac tincidunt arcu. Etiam et   augue massa. Donec eget justo enim. Quisque eget orci eu orci malesuada   vestibulum non at magna. Fusce malesuada malesuada faucibus. Nulla   ultrices nibh in tellus pellentesque mollis commodo velit placerat.   Fusce eget velit velit, vitae adipiscing justo.</p>', NULL, 0, NULL, NULL, 0, '', NULL, 'affiliates', 0),
(23, '2011-07-13 06:49:07', '2011-07-13 06:49:07', NULL, 'Legal', '<p>Comming Soon</p>', NULL, 0, NULL, NULL, 0, '', NULL, 'legal', 0),
(24, '2011-07-13 06:49:07', '2011-07-13 06:49:07', NULL, 'Etiquette', '<p>Comming Soon</p>', NULL, 0, NULL, NULL, 0, '', NULL, 'etiquette', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pagseguro_transaction_logs`
--

DROP TABLE IF EXISTS `pagseguro_transaction_logs`;
CREATE TABLE IF NOT EXISTS `pagseguro_transaction_logs` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `email` varchar(255) collate utf8_unicode_ci default NULL,
  `address` varchar(255) collate utf8_unicode_ci default NULL,
  `number` bigint(20) default '0',
  `quarter` varchar(255) collate utf8_unicode_ci default NULL,
  `city` varchar(255) collate utf8_unicode_ci default NULL,
  `state` varchar(50) collate utf8_unicode_ci default NULL,
  `zip` varchar(255) collate utf8_unicode_ci default NULL,
  `phone` varchar(20) collate utf8_unicode_ci default NULL,
  `item_id` bigint(20) default NULL,
  `item_user_id` bigint(20) default NULL,
  `transaction_id` varbinary(100) default NULL,
  `transaction_date` datetime default NULL,
  `amount` double default NULL,
  `transaction_fee` double(10,3) default '0.000',
  `currency` varchar(25) collate utf8_unicode_ci default NULL,
  `remark` varchar(255) collate utf8_unicode_ci default NULL,
  `is_gift` tinyint(2) default '0',
  `quantity` bigint(20) default NULL,
  `payment_gateway_id` bigint(20) default NULL,
  `payment_type` varchar(255) collate utf8_unicode_ci default NULL,
  `payment_status` varchar(255) collate utf8_unicode_ci default NULL,
  `gift_to` varchar(255) collate utf8_unicode_ci default NULL,
  `gift_from` varchar(255) collate utf8_unicode_ci default NULL,
  `gift_email` varchar(255) collate utf8_unicode_ci default NULL,
  `buyer_email` varchar(255) collate utf8_unicode_ci default NULL,
  `ip` varchar(255) collate utf8_unicode_ci default NULL,
  `message` varchar(255) collate utf8_unicode_ci default NULL,
  `serialized_post_array` longtext collate utf8_unicode_ci,
  `currency_id` bigint(20) default NULL,
  `converted_currency_id` bigint(20) default NULL,
  `orginal_amount` double(10,2) default NULL,
  `rate` double(10,2) default NULL,
  PRIMARY KEY  (`id`),
  KEY `item_user_id` (`item_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pagseguro_transaction_logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

DROP TABLE IF EXISTS `payment_gateways`;
CREATE TABLE IF NOT EXISTS `payment_gateways` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) collate utf8_unicode_ci default NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  `gateway_fees` double(10,2) default NULL,
  `transaction_count` bigint(20) unsigned default '0',
  `payment_gateway_setting_count` bigint(20) unsigned default '0',
  `is_mass_pay_enabled` tinyint(1) NOT NULL,
  `is_test_mode` tinyint(1) NOT NULL default '0',
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `created`, `modified`, `name`, `display_name`, `description`, `gateway_fees`, `transaction_count`, `payment_gateway_setting_count`, `is_mass_pay_enabled`, `is_test_mode`, `is_active`) VALUES
(3, '2010-05-10 10:43:02', '2012-02-23 07:28:39', 'PayPal', 'Paypal', 'PayPal is an electronic money service which allows you to make payment to anyone online. ', 0.00, 0, 1, 0, 1, 1),
(2, '2010-05-10 10:43:02', '2010-09-20 12:48:02', 'CreditCard', 'Credit Card Using PayPal', 'Payment by Credit card.', 0.00, 0, 1, 0, 1, 1),
(1, '2010-05-10 10:43:02', '2011-07-18 10:44:47', 'Wallet', 'Wallet', 'Purchase via Wallet', 0.00, 0, 1, 0, 1, 1),
(4, '2010-09-24 09:26:59', '2011-08-03 09:31:46', 'AuthorizeNet', 'Credit Card', 'Purchase via credit card using Authorize.net CIM', NULL, 0, 0, 0, 1, 1),
(5, '2010-10-25 15:09:48', '2010-11-10 19:02:38', 'PagSeguro', 'PagSeguro', 'We use PagSeguro because it is secure, secure and secure (and easy). ', NULL, 0, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateway_settings`
--

DROP TABLE IF EXISTS `payment_gateway_settings`;
CREATE TABLE IF NOT EXISTS `payment_gateway_settings` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `payment_gateway_id` bigint(20) unsigned NOT NULL,
  `key` varchar(256) collate utf8_unicode_ci NOT NULL,
  `type` enum('text','textarea','select','checkbox','radio','password') collate utf8_unicode_ci NOT NULL,
  `options` text collate utf8_unicode_ci NOT NULL COMMENT 'Its only use, when we select type = select. Here we can give otpions value',
  `test_mode_value` text collate utf8_unicode_ci,
  `live_mode_value` text collate utf8_unicode_ci,
  `description` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_gateway_settings`
--

INSERT INTO `payment_gateway_settings` (`id`, `created`, `modified`, `payment_gateway_id`, `key`, `type`, `options`, `test_mode_value`, `live_mode_value`, `description`) VALUES
(1, '2010-05-10 11:01:23', '2010-05-14 13:05:28', 3, 'payee_account', 'text', '', 'group._1275387295_biz@agriya.in', '', 'PayPal merchant account email'),
(2, '2010-07-16 16:29:35', '2010-07-16 16:29:38', 3, 'receiver_emails', 'text', '', 'group._1275387295_biz@agriya.in', '', 'Comma separated for setting multiple receiver emails.'),
(3, '2010-07-15 12:15:27', '2010-07-15 12:15:27', 3, 'masspay_API_UserName', 'text', '', 'group._1275387295_biz_api1.agriya.in', '', ''),
(4, '2010-07-15 12:15:27', '2010-07-15 12:15:27', 3, 'masspay_API_Password', 'text', '', '1275387304', '', ''),
(5, '2010-07-15 12:20:23', '2010-07-15 12:20:23', 3, 'masspay_API_Signature', 'text', '', 'A2D-o.ABr1BhSY94P3USn3LNzZHIA.j34dhfDHi77OE5YiM93TixlOZK', '', ''),
(8, '2010-07-15 12:20:23', '2010-07-15 12:20:23', 2, 'directpay_API_Signature', 'text', '', 'A2D-o.ABr1BhSY94P3USn3LNzZHIA.j34dhfDHi77OE5YiM93TixlOZK', '', ''),
(7, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 2, 'directpay_API_Password', 'text', '', '1275387304', '', ''),
(6, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 2, 'directpay_API_UserName', 'text', '', 'group._1275387295_biz_api1.agriya.in', '', ''),
(9, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 1, 'is_enable_for_buy_a_item', 'checkbox', '', '1', '1', 'Enable/Disable the current payment option for Purchasing item.'),
(11, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 1, 'is_enable_for_add_to_wallet', 'checkbox', '', '1', '1', 'Enable/Disable the current payment option for ''Add to wallet'''),
(12, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 2, 'is_enable_for_buy_a_item', 'checkbox', '', '1', '', 'Enable/Disable the current payment option for Purchasing item.'),
(14, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 2, 'is_enable_for_add_to_wallet', 'checkbox', '', '1', '', 'Enable/Disable the current payment option for ''Add to wallet'''),
(15, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 3, 'is_enable_for_buy_a_item', 'checkbox', '', '1', '', 'Enable/Disable the current payment option for Purchasing item.'),
(17, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 1, 'is_enable_wallet', 'checkbox', '', '1', '', 'Disabling this option will, disable all ''Wallet'' option for Item purchase and Gift card. And user will not be able to use Cash withdrawal option or add to wallet option'),
(18, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 3, 'is_enable_for_add_to_wallet', 'checkbox', '', '1', '', 'Enable/Disable the current payment option for ''Add to wallet'''),
(19, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 2, 'is_enable_wallet', 'checkbox', '', '1', '', 'Disabling this option will, disable all ''Wallet'' option for Item purchase and Gift card. And user will not be able to use Cash withdrawal option or add to wallet option'),
(20, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 3, 'is_enable_wallet', 'checkbox', '', '1', '1', 'Disabling this option will, disable all ''Wallet'' option for Item purchase and Gift card. And user will not be able to use Cash withdrawal option or add to wallet option'),
(21, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 4, 'is_enable_for_add_to_wallet', 'checkbox', '', '1', '', 'Enable/Disable the current payment option for ''Add to wallet'''),
(22, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 4, 'is_enable_for_buy_a_item', 'checkbox', '', '1', '', 'Enable/Disable the current payment option for Purchasing item.'),
(24, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 4, 'is_enable_wallet', 'checkbox', '', '1', '', 'Disabling this option will, disable all ''Wallet'' option for Item purchase and Gift card. And user will not be able to use Cash withdrawal option or add to wallet option'),
(25, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 4, 'authorize_net_api_key', 'text', '', '6zpqE4M9Au3a', '', ''),
(26, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 4, 'authorize_net_trans_key', 'text', '', '48we9UQp44Y5Ns5Y', '', ''),
(27, '2010-10-25 15:14:13', '2010-10-25 15:14:15', 5, 'payee_account', 'text', '', '', '', 'PagSeguro merchant account email'),
(28, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 5, 'is_enable_for_add_to_wallet', 'checkbox', '', '1', '', 'Enable/Disable the current payment option for ''Add to wallet'''),
(29, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 5, 'is_enable_for_buy_a_item', 'checkbox', '', '1', '', 'Enable/Disable the current payment option for Purchasing item.'),
(31, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 5, 'is_enable_wallet', 'checkbox', '', '1', '1', 'Disabling this option will, disable all ''Wallet'' option for Item purchase and Gift card. And user will not be able to use Cash withdrawal option or add to wallet option'),
(32, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 'token', 'text', '', '', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `paypal_docapture_logs`
--

DROP TABLE IF EXISTS `paypal_docapture_logs`;
CREATE TABLE IF NOT EXISTS `paypal_docapture_logs` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `item_user_id` bigint(20) default NULL,
  `wallet_user_id` bigint(20) NOT NULL,
  `authorizationid` varchar(255) collate utf8_unicode_ci default NULL,
  `currencycode` varchar(10) collate utf8_unicode_ci default NULL,
  `dodirectpayment_correlationid` varchar(255) collate utf8_unicode_ci default NULL,
  `dodirectpayment_ack` varchar(255) collate utf8_unicode_ci default NULL,
  `dodirectpayment_build` varchar(255) character set utf8 collate utf8_danish_ci default NULL,
  `dodirectpayment_amt` double(10,2) default NULL,
  `dodirectpayment_avscode` varchar(255) collate utf8_unicode_ci default NULL,
  `dodirectpayment_cvv2match` varchar(255) collate utf8_unicode_ci default NULL,
  `dodirectpayment_response` text collate utf8_unicode_ci,
  `version` double(10,2) default NULL,
  `dodirectpayment_timestamp` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_timestamp` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_correlationid` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_ack` varchar(50) collate utf8_unicode_ci default NULL,
  `docapture_build` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_transactionid` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_parenttransactionid` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_receiptid` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_transactiontype` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_paymenttype` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_ordertime` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_amt` double(10,2) default NULL,
  `docapture_feeamt` double(10,2) default NULL,
  `docapture_taxamt` double(10,2) default NULL,
  `docapture_paymentstatus` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_pendingreason` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_reasoncode` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_protectioneligibility` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_response` text collate utf8_unicode_ci,
  `dovoid_timestamp` varchar(255) collate utf8_unicode_ci default NULL,
  `dovoid_correlationid` varchar(255) collate utf8_unicode_ci default NULL,
  `dovoid_ack` varchar(50) collate utf8_unicode_ci default NULL,
  `dovoid_build` varchar(50) collate utf8_unicode_ci default NULL,
  `dovoid_response` text collate utf8_unicode_ci,
  `currency_id` bigint(20) NOT NULL,
  `converted_currency_id` bigint(20) NOT NULL,
  `original_amount` double(10,2) NOT NULL,
  `rate` varchar(100) collate utf8_unicode_ci NOT NULL,
  `payment_status` varchar(20) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `item_user_id` (`item_user_id`),
  KEY `wallet_user_id` (`wallet_user_id`),
  KEY `currency_id` (`currency_id`),
  KEY `converted_currency_id` (`converted_currency_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `paypal_docapture_logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `paypal_transaction_logs`
--

DROP TABLE IF EXISTS `paypal_transaction_logs`;
CREATE TABLE IF NOT EXISTS `paypal_transaction_logs` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `date_added` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_id` bigint(20) default '0',
  `transaction_id` bigint(20) default '0',
  `item_user_id` bigint(20) default NULL,
  `ip_id` bigint(20) NOT NULL,
  `currency_type` varchar(50) collate utf8_unicode_ci NOT NULL,
  `txn_id` varchar(50) collate utf8_unicode_ci default NULL,
  `payer_email` varchar(150) collate utf8_unicode_ci default NULL,
  `payment_date` varchar(30) collate utf8_unicode_ci default NULL,
  `email` varchar(150) collate utf8_unicode_ci NOT NULL,
  `to_digicurrency` varchar(50) collate utf8_unicode_ci NOT NULL,
  `to_account_no` varchar(100) collate utf8_unicode_ci NOT NULL,
  `to_account_name` varchar(150) collate utf8_unicode_ci NOT NULL,
  `fees_paid_by` varchar(50) collate utf8_unicode_ci NOT NULL,
  `mc_gross` double(50,5) default NULL,
  `mc_fee` double(50,5) default NULL,
  `mc_currency` varchar(12) collate utf8_unicode_ci NOT NULL,
  `payment_status` varchar(20) collate utf8_unicode_ci default NULL,
  `pending_reason` varchar(20) collate utf8_unicode_ci default NULL,
  `receiver_email` varchar(100) collate utf8_unicode_ci default NULL,
  `paypal_response` varchar(20) collate utf8_unicode_ci default NULL,
  `error_no` tinyint(4) default '0',
  `error_message` text collate utf8_unicode_ci NOT NULL,
  `memo` text collate utf8_unicode_ci,
  `paypal_post_vars` text collate utf8_unicode_ci,
  `is_mass_pay` tinyint(1) default '0',
  `mass_pay_status` varchar(20) collate utf8_unicode_ci default NULL,
  `masspay_response` text collate utf8_unicode_ci,
  `is_authorization` tinyint(1) default '0',
  `authorization_auth_exp` varchar(255) collate utf8_unicode_ci default NULL,
  `authorization_transaction_entity` varchar(255) collate utf8_unicode_ci default NULL,
  `authorization_parent_txn_id` varchar(255) collate utf8_unicode_ci default NULL,
  `authorization_remaining_settle` int(10) default NULL,
  `authorization_auth_id` varchar(255) collate utf8_unicode_ci default NULL,
  `authorization_auth_amount` double(50,2) default NULL,
  `authorization_pending_reason` varchar(20) collate utf8_unicode_ci default NULL,
  `authorization_payment_gross` double(50,5) default NULL,
  `authorization_auth_status` varchar(20) collate utf8_unicode_ci default NULL,
  `authorization_data` varchar(500) collate utf8_unicode_ci default NULL,
  `capture_authorizationid` varchar(255) collate utf8_unicode_ci default NULL,
  `capture_timestamp` varchar(255) collate utf8_unicode_ci default NULL,
  `capture_correlationid` varchar(255) collate utf8_unicode_ci default NULL,
  `capture_ack` varchar(50) collate utf8_unicode_ci default NULL,
  `capture_version` varchar(50) collate utf8_unicode_ci default NULL,
  `capture_build` varchar(50) collate utf8_unicode_ci default NULL,
  `capture_transactionid` varchar(255) collate utf8_unicode_ci default NULL,
  `capture_parenttransactionid` varchar(255) collate utf8_unicode_ci default NULL,
  `capture_transactiontype` varchar(255) collate utf8_unicode_ci default NULL,
  `capture_paymenttype` varchar(255) collate utf8_unicode_ci default NULL,
  `capture_expectedecheckcleardate` varchar(255) collate utf8_unicode_ci default NULL,
  `capture_ordertime` varchar(255) collate utf8_unicode_ci default NULL,
  `capture_amt` varchar(255) collate utf8_unicode_ci default NULL,
  `capture_feeamt` varchar(255) collate utf8_unicode_ci default NULL,
  `capture_taxamt` varchar(255) collate utf8_unicode_ci default NULL,
  `capture_pendingreason` varchar(255) collate utf8_unicode_ci default NULL,
  `capture_reasoncode` varchar(255) collate utf8_unicode_ci default NULL,
  `capture_protectioneligibility` varchar(255) collate utf8_unicode_ci default NULL,
  `capture_data` varchar(255) collate utf8_unicode_ci default NULL,
  `void_timestamp` varchar(255) collate utf8_unicode_ci default NULL,
  `void_correlationid` varchar(255) collate utf8_unicode_ci default NULL,
  `void_ack` varchar(50) collate utf8_unicode_ci default NULL,
  `void_data` varchar(500) collate utf8_unicode_ci default NULL,
  `user_cash_withdrawal_id` bigint(20) NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `converted_currency_id` bigint(20) NOT NULL,
  `orginal_amount` double(10,2) NOT NULL,
  `rate` varchar(100) collate utf8_unicode_ci NOT NULL,
  `affiliate_cash_withdrawal_id` bigint(20) default NULL,
  `charity_cash_withdrawal_id` bigint(20) default '0',
  PRIMARY KEY  (`id`),
  KEY `txn_id` (`txn_id`),
  KEY `user_id` (`user_id`),
  KEY `transaction_id` (`transaction_id`),
  KEY `currency_id` (`currency_id`),
  KEY `affiliate_cash_withdrawal_id` (`affiliate_cash_withdrawal_id`),
  KEY `converted_currency_id` (`converted_currency_id`),
  KEY `user_cash_withdrawal_id` (`user_cash_withdrawal_id`),
  KEY `item_user_id` (`item_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `paypal_transaction_logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `revisions`
--

DROP TABLE IF EXISTS `revisions`;
CREATE TABLE IF NOT EXISTS `revisions` (
  `id` bigint(20) NOT NULL auto_increment,
  `type` varchar(15) collate utf8_unicode_ci NOT NULL,
  `node_id` bigint(20) NOT NULL,
  `content` text collate utf8_unicode_ci NOT NULL,
  `revision_number` bigint(20) NOT NULL,
  `user_id` bigint(20) default NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `node_id` (`node_id`),
  KEY `revision_number` (`revision_number`),
  KEY `type` (`type`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Revision Details';

--
-- Dumping data for table `revisions`
--


-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL auto_increment,
  `setting_category_id` int(11) NOT NULL,
  `setting_category_parent_id` bigint(20) default '0',
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `value` text collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci,
  `type` enum('text','textarea','select','checkbox','radio','password','file') collate utf8_unicode_ci NOT NULL,
  `options` text collate utf8_unicode_ci COMMENT 'Its only use, when\r\nwe select type = select. Here we can give otpions value',
  `label` varchar(255) collate utf8_unicode_ci default NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `setting_category_id` (`setting_category_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Site Setting Details';

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_category_id`, `setting_category_parent_id`, `name`, `value`, `description`, `type`, `options`, `label`, `order`) VALUES
(1, 17, 1, 'site.name', 'GroupWithUs', 'This name will used in all pages, emails.', 'text', NULL, 'Name', 1),
(2, 0, 65, 'site.version', 'v1.0b5', 'This is the current version of the site, which will be displayed in the footer.', 'text', NULL, 'Version', 2),
(3, 22, 3, 'meta.keywords', 'agriya, Groupwithus, grubwithus clone', 'These are the keywords used for improving search engine results of our site. (Comma separated for multiple keywords.)', 'text', NULL, 'Keywords', 3),
(4, 22, 3, 'meta.description', 'Groupwithus, grubwithus clone', 'This is the short description of your site, used by search engines on search result pages to display preview snippets for a given page.', 'textarea', NULL, 'Description', 4),
(5, 18, 1, 'site.contact_email', 'info@agriya.com', 'This is the email address to which you will receive the mail from contact form.', 'text', NULL, 'Contact Email Address', 10),
(9, 26, 5, 'user.using_to_login', 'username', 'Users will be able to login with chosen login handle (username or email address) along with their password.', 'select', 'username,email', 'Login Handle', 1),
(10, 23, 3, 'site.tracking_script', '<script type="text/javascript">var gaJsHost=(("https:"==document.location.protocol)?"https://ssl.":"http://www.");document.write(unescape("%3Cscript src=\\''"+gaJsHost+"google-analytics.com/ga.js\\'' type=\\''text/javascript\\''%3E%3C/script%3E"));</script><script type="text/javascript">var pageTracker=_gat._getTracker("UA-4819298-1");pageTracker._initData();pageTracker._trackPageview();</script>', 'This is the site tracker script, used for track and analyze data about how people are getting to your website. e.g., Google Analytics. http://www.google.com/analytics/', 'textarea', NULL, 'Site Tracker Code', 16),
(25, 0, 65, 'thumb_size.micro_thumb.width', '30', '', 'text', NULL, 'Micro thumb', 1),
(26, 0, 65, 'thumb_size.micro_thumb.height', '30', '', 'text', NULL, '', 2),
(27, 0, 65, 'thumb_size.small_thumb.width', '35', '', 'text', NULL, 'Small thumb', 3),
(28, 0, 65, 'thumb_size.small_thumb.height', '35', '', 'text', NULL, '', 4),
(29, 0, 65, 'thumb_size.medium_thumb.width', '50', '', 'text', NULL, 'Medium thumb', 5),
(30, 0, 65, 'thumb_size.medium_thumb.height', '50', '', 'text', NULL, '', 6),
(31, 0, 65, 'thumb_size.normal_thumb.width', '161', '', 'text', NULL, 'Normal thumb', 7),
(32, 0, 65, 'thumb_size.normal_thumb.height', '119', '', 'text', NULL, '', 8),
(33, 0, 65, 'thumb_size.big_thumb.width', '436', '', 'text', NULL, 'Big thumb', 9),
(34, 0, 65, 'thumb_size.big_thumb.height', '340', '', 'text', NULL, '', 10),
(35, 0, 65, 'thumb_size.small_big_thumb.width', '205', '', 'text', NULL, 'Small big thumb', 11),
(36, 0, 65, 'thumb_size.small_big_thumb.height', '114', '', 'text', NULL, '', 12),
(41, 27, 5, 'user.is_admin_activate_after_register', '0', 'On enabling this feature, admin need to approve each user after registration (User cannot login until admin approves)', 'checkbox', NULL, 'Enable Administrator Approval After Registration', 2),
(42, 27, 5, 'user.is_email_verification_for_register', '0', 'On enabling this feature, user need to verify their email address provided during registration. (User cannot login until email address is verified)', 'checkbox', NULL, 'Enable Email Verification After Registration', 3),
(43, 27, 5, 'user.is_auto_login_after_register', '1', 'On enabling this feature, users will be automatically logged-in after registration. (Only when "Email Verification" & "Admin Approval" is disabled)', 'checkbox', NULL, 'Enable Auto Login After Registration', 4),
(44, 27, 5, 'user.is_admin_mail_after_register', '1', 'On enabling this feature, notification mail will be sent to administrator on each registration.', 'checkbox', NULL, 'Enable Notify Administrator on Each Registration', 5),
(45, 27, 5, 'user.is_welcome_mail_after_register', '1', 'On enabling this feature, users will receive a welcome mail after registration.', 'checkbox', NULL, 'Enable Sending Welcome Mail After Registration', 6),
(47, 27, 5, 'user.is_logout_after_change_password', '1', 'On enabling this feature, users will be asked to log-in again.', 'checkbox', NULL, 'Enable Auto-Logout After Password Change', 7),
(53, 26, 5, 'user.is_enable_openid', '1', 'On enabling this feature, users can authenticate their ##SITE_NAME## account using OpenID.', 'checkbox', NULL, 'Enable OpenID', 8),
(231, 25, 4, 'site.timezone_offset', 'America/Bahia', 'The selected timezone will be used as default timezone for our site. All the record''s date and time will be updated based on this timezone.', 'select', NULL, 'Timezone', 8),
(56, 25, 4, 'site.date.format', '%b %d, %Y', 'This is the date format which is displayed in our site.', 'text', NULL, 'Date Format', 25),
(58, 25, 4, 'site.time.format', '%I:%M %p', 'This is the time format which is displayed in our site.', 'text', NULL, 'Time Format', 27),
(57, 25, 4, 'site.datetime.format', '%b %d, %Y %I:%M %p', 'This is the date-time format which is displayed in our site.', 'text', NULL, 'Date-Time Format', 26),
(59, 25, 4, 'site.date.tooltip', '%b %d, %Y %I:%M %p', 'This is the date tooltip format which is displayed in our site.', 'text', NULL, 'Date Tooltip Format', 28),
(61, 25, 4, 'site.datetime.tooltip', '%B %d, %Y %I:%M:%S %p (%A) %Z', 'This is the date-time tooltip format which is displayed in our site.', 'text', NULL, 'Date-Time Tooltip Format', 28),
(72, 19, 4, 'site.language', 'en', 'The selected language will be used as default language all over the site (also for emails)', 'select', NULL, 'Site Language ', 5),
(73, 23, 3, 'site.robots', '', 'Content for robots.txt; (search engine) robots specific instructions. Refer,<a href="http://www.robotstxt.org/">http://www.robotstxt.org/</a> for syntax and usage.', 'textarea', NULL, 'robots.txt', 17),
(92, 28, 5, 'user.is_allow_user_to_switch_language', '1', 'On enabling this feature, users can change site language to their choice.', 'checkbox', '', 'Enable User to Switch Language', 9),
(97, 19, 4, 'site.city', 'san-diego', 'The selected city will be used as default ''city'' when users/visitors access our site.', 'select', NULL, 'Default City', 3),
(99, 26, 5, 'facebook.is_enabled_facebook_connect', '1', 'On enabling this feature, users can authenticate their ##SITE_NAME## account using Facebook.', 'checkbox', NULL, 'Enabled Facebook', 1),
(127, 35, 6, 'barcode.is_barcode_enabled', '1', '', 'checkbox', NULL, 'Enable Barcode', 1),
(128, 35, 6, 'barcode.width', '120', 'This is the width of the barcode which is generated for pass.', 'text', NULL, 'Barcode Width', 3),
(129, 35, 6, 'barcode.height', '120', 'This is the height of the barcode which is generated for pass.', 'text', NULL, 'Barcode Height', 4),
(126, 40, 7, 'user.is_user_can_with_draw_amount', '1', 'On enabling this feature, users can make a request to withdraw their wallet amount to their provided. PayPal account. (Requires administrator approval for each request).', 'checkbox', NULL, 'Enable Cash Withdrawal', 5),
(110, 48, 10, 'user.referral_amount', '5', 'This is the amount earned by referral user.', 'text', NULL, 'Referral Amount', 2),
(111, 38, 7, 'wallet.min_wallet_amount', '5', 'This is the minimum amount a user can add to his wallet.', 'text', NULL, 'Minimum Wallet Funding Limit', 1),
(112, 38, 7, 'wallet.max_wallet_amount', '', 'This is the maximum amount a user can add to his wallet. (If left empty, then, no maximum amount restrictions)', 'text', NULL, 'Maximum Wallet Funding Limit', 2),
(115, 29, 5, 'user.is_merchant_actas_normal_user', '1', 'On enabling this feature, makes the merchant users to have normal user features.', 'checkbox', NULL, 'Enable Normal User Features', 1),
(121, 48, 10, 'user.referral_cookie_expire_time', '24', 'This is the maximum time after which the referral register cookie will be expired or unusable.', 'text', NULL, 'Referral Register Cookie Expire Time', 3),
(122, 48, 10, 'user.referral_item_buy_time', '24', 'This is the maximum time after which the referral purchase cookie will be expired or unusable.', 'text', NULL, 'Referral Purchase Cookie Expire Time', 4),
(206, 62, 14, 'friend.msn_app_id', '000000004805BD82', 'This is the configured MSN Application ID.', 'text', NULL, 'Application ID', 15),
(134, 28, 5, 'user.is_send_email_on_profile_comments', '1', 'On enabling this feature, users will receive notification mail when other users post comment on their profile page.', 'checkbox', NULL, 'Enable Notify User on New Comment', 19),
(136, 36, 7, 'item.is_auto_refund_enabled', '1', 'On enabling this feature, users will be automatically refunded when the item purchased fails to reach its tipping point. (Disable this, if you want to manually refund to users when changing status to "Expired" Or "Refund" Or "Canceled" in item listings page.)', 'checkbox', NULL, 'Enable Auto Refund for User', 1),
(299, 0, 65, 'thumb_size.item_user_thumb.width', '160', NULL, 'text', NULL, 'Item User thumb', 0),
(300, 0, 65, 'thumb_size.item_user_thumb.height', '164', NULL, 'text', NULL, 'Item User thumb', 0),
(140, 40, 7, 'user.is_withdraw_request_amount_paid_automatic', '1', 'On enabling this feature, users request for cash withdrawal will be automatically carried out everyday when cron is triggered and requests will be sent to PayPal for processing without the needed for administrator approval. (Disable this, if you want to manually approve each request for processing)', 'checkbox', NULL, 'Enable Auto Pay for Users Withdrawal', 8),
(205, 62, 14, 'friend.msn_secret', 'DnZIsYiimx1UT1KJTA448x8utHBBwFZ5', 'This is the configured MSN Application Secret Key.', 'text', NULL, 'Application Secret', 16),
(204, 53, 13, 'friend.is_send_email_on_friend_request', '1', 'On enabling this feature, users will be notified by an email for every friend request.', 'checkbox', NULL, 'Enable Notify via Mail for Friend Request', 3),
(149, 54, 14, 'facebook.fb_api_key', '231084413598942', 'This is the Facebook app key used for authentication and other Facebook related plugins support', 'text', NULL, 'Application Key', 4),
(150, 54, 14, 'facebook.fb_secrect_key', '9c9babe6c6d1ce5f7d18cec75090f893', 'This is the Facebook secret key used for authentication and other Facebook related plugins support', 'text', NULL, 'Secret Key', 5),
(154, 40, 7, 'user.minimum_withdraw_amount', '2', 'This is the minimum amount a user can withdraw from their wallet.', 'text', NULL, 'Minimum Wallet Withdrawal Amount', 6),
(155, 40, 7, 'user.maximum_withdraw_amount', '100', 'This is the maximum amount a user can withdraw from their wallet.', 'text', NULL, 'Maximum Wallet Withdrawal Amount', 7),
(159, 19, 4, 'site.city_url', 'prefix', 'The selected routing URL format will be used as default routing around the site. (e.g., prefix - http://www.sitename.com/city, subdomain - http://city.sitename.com)', 'select', 'prefix,subdomain', 'Routing URL', 4),
(162, 28, 5, 'user.is_show_user_statistics', '1', 'On enabling this feature, various statistics information about an user will be displayed in his user view page such as Item Purchased, Friends, Referred Users.', 'checkbox', NULL, 'Enable User Statistics', 14),
(163, 53, 13, 'user.is_show_friend', '1', 'On enabling this feature, the list of friends added will be displayed in user view page.', 'checkbox', NULL, 'Enable Friends Listing', 8),
(164, 48, 10, 'user.is_show_referred_friends', '1', 'On enabling this feature, the referred users will be listed in user view page.', 'checkbox', NULL, 'Enable Referred User Display', 5),
(165, 33, 6, 'user.is_show_item_purchased', '1', 'On enabling this feature, items will be listed in the purchased user''s profile page.', 'checkbox', NULL, 'Enable Item Purchased Listing', 3),
(166, 53, 13, 'merchant.is_show_friend', '1', 'On enabling this feature, the list of friends added will be displayed in merchant view page.', 'checkbox', NULL, 'Enable Friends Merchant Listing', 9),
(167, 29, 5, 'merchant.is_show_merchant_statistics', '1', 'On enabling this features, displays the item statistics in merchant user profile page.', 'checkbox', NULL, 'Enable Showing Item Statistics', 7),
(168, 33, 6, 'merchant.is_show_item_purchased', '1', 'On enabling this feature, items purchased by a users will be listed in item-merchant owners page.', 'checkbox', NULL, 'Enable Item Purchased Users Listing', 4),
(169, 48, 10, 'merchant.is_show_referred_friends', '1', 'On enabling this feature, the referred users will be listed in merchant page.', 'checkbox', NULL, 'Enable Referred User Display for Merchant', 6),
(170, 18, 1, 'EmailTemplate.from_email', 'GroupWithUs <info@agriya.com>', 'This is the email address that will appear in the "From" field of all emails sent from the site.', 'text', NULL, 'From Email Address', 32),
(171, 18, 1, 'EmailTemplate.reply_to_email', '', '"Reply-To" email header for all emails. Leave it empty to receive replies as usual (to "From" email address).', 'text', NULL, 'Reply to Email Address', 33),
(173, 21, 2, 'site.look_up_url', 'http://whois.sc/', 'URL prefix for whois lookup service. Will be used in whois links found in ##USER_LOGIN## pages to resolve users'' IP to where they are from&mdash;often down to the city or neighborhood or country. This is a security feature.', 'text', '', 'Whois Lookup URL', 12),
(174, 0, 65, 'thumb_size.medium_big_thumb.width', '680', '', 'text', NULL, 'Medium big thumb', 13),
(175, 0, 65, 'thumb_size.medium_big_thumb.height', '320', '', 'text', NULL, '', 14),
(176, 33, 6, 'merchant.is_show_item_owned', '1', 'On enabling this feature, item belong to a merchant will be listed in their profile.', 'checkbox', NULL, 'Enable Item Listing for Merchant', 5),
(310, 26, 5, 'foursquare.is_enabled_foursquare_connect', '1', 'On enabling this feature, users can authenticate their ##SITE_NAME## account using Foursquare.', 'checkbox', NULL, 'Enable Foursquare', 9),
(179, 0, 65, 'thumb_size.site_logo_thumb.width', '335', '', 'text', NULL, 'Site Logo Thumb', 15),
(180, 0, 65, 'thumb_size.site_logo_thumb.height', '69', '', 'text', NULL, '', 16),
(243, 0, 65, 'thumb_size.large_thumb.width', '1500', NULL, 'text', NULL, 'Large thumb', 0),
(244, 0, 65, 'thumb_size.large_thumb.height', '1000', NULL, 'text', NULL, '', 0),
(183, 55, 14, 'twitter.site_twitter_url', 'http://twitter.com/groupwithus', 'This is the site Twitter URL used displayed in the footer. (Replaced with city specific Twitter URL, if updated in cities)', 'text', NULL, 'Twitter Account URL', 2),
(184, 54, 14, 'facebook.site_facebook_url', 'http://www.facebook.com/apps/application.php?id=227748570597275&sk=wall', 'This is the site Facebook URL used displayed in the footer. (Replaced with city specific Facebook URL, if updated in cities)', 'text', NULL, 'Facebook Account URL', 7),
(188, 21, 2, 'site.is_ssl_for_item_buy_enabled', '0', 'On enabling this feature, users login, registration and purchase will be carried through more secure way. (Requires purchase of an SSL certificate if this option is in disabled state)', 'checkbox', NULL, 'Enable SSL (Secure Socket Layer)', 14),
(191, 57, 14, 'GoogleMap.static_map_zoom_level', '9', 'This is the default zoom level for static Map. ( 1 to 15 ) (Merchant user can adjust the zoom level in his/her profile.)', 'text', NULL, 'Default Zoom Level', 0),
(192, 55, 14, 'twitter.consumer_key', 'xwyHG9nm1kwO670VaBUMw', 'This is the consumer key used for authentication and posting on Twitter.', 'text', NULL, 'Consumer Key', 5),
(193, 55, 14, 'twitter.consumer_secret', '3UAcHGiBP1BPnEaY5zrq03vKC1wEKfRmoIRFKjZKjKs', 'This is the consumer secret key used for authentication and posting on Twitter.', 'text', NULL, 'Consumer Secret Key', 6),
(194, 55, 14, 'twitter.site_user_access_key', 'PagSOk5TvYOLZpRixkn4js3iEjRUqALm9P1A5iMRhM', 'This will be automatically updated when on clicking "Update Twitter Credentials" link. (Required for posting in Twitter)', 'text', NULL, 'Access Key', 7),
(195, 55, 14, 'twitter.site_user_access_token', '202602486-N2epy4MsqL1vF5cdAaqjiKhqk1xu28jVbLiWVsUU', 'This will be automatically updated when on clicking "Update Twitter Credentials" link. (Required for posting in Twitter)', 'text', NULL, 'Access Token', 7),
(277, 26, 5, 'twitter.is_enabled_twitter_connect', '1', 'On enabling this feature, users can authenticate their ##SITE_NAME## account using Twitter.', 'checkbox', NULL, 'Enable Twitter', 1),
(198, 55, 14, 'twitter.new_item_message', '###SLUGED_SITE_NAME## ##URL## ##ITEM_NAME##', 'This is the format used when posting on Twitter when items get opened. ##ITEM_NAME##, ##SLUGED_SITE_NAME##., will be automatically replaced when posting on Twitter.', 'textarea', NULL, 'Twitter Post Format', 4),
(199, 54, 14, 'facebook.new_item_message', '##ITEM_NAME## ##ITEM_LINK##', 'This is the format used when posting on Facebook when items get opened. ##ITEM_NAME##, ##ITEM_LINK##., will be automatically replaced when posting on Facebook.', 'textarea', NULL, 'Facebook Post Format', 11),
(208, 53, 13, 'friend.is_two_way', '1', 'On enabling this feature, on each friend request, the requested friend needs to accept the request to become friends. (Disable this, if other users don''t need to approve to become a friend.)', 'checkbox', NULL, 'Enable "Two Way" Friendship', 2),
(211, 53, 13, 'friend.is_enabled', '1', 'On enabling this feature, all friends related settings like adding friends, managing friends will be enabled.', 'checkbox', NULL, 'Enable Friends', 1),
(213, 60, 14, 'invite.yahoo_app_id', '9aAK156k', 'This is the configured Yahoo API ID.', 'text', NULL, 'Application ID', 10),
(214, 60, 14, 'invite.yahoo_app_data', 'Groupwithus', 'This is the data provided during Yahoo Invite. (our site name)', 'text', NULL, 'Application Data', 11),
(216, 60, 14, 'invite.yahoo_consumer_key', 'dj0yJmk9Rnh3YXVjaHpNTk9PJmQ9WVdrOU9XRkJTekUxTm1zbWNHbzlNVFV3TXpBeE5qYzJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD1mYg--', 'This is configured Yahoo consumer key.', 'text', NULL, 'Consumer Key', 12),
(217, 60, 14, 'invite.yahoo_secret_key', 'a340a7638b09a8a7edbdc8897e76e83c3d25837c', 'This is configured Yahoo consumer secret key.', 'text', NULL, 'Consumer Secret', 13),
(224, 55, 14, 'twitter.enable_twitter_post_open_item', '1', 'On enabling this feature, Post All the Open Item in Site''s Twitter Account', 'checkbox', NULL, 'Post New Item on Twitter', 3),
(225, 54, 14, 'facebook.enable_facebook_post_open_item', '1', 'On enabling this feature, Post Newly Open Item in Site''s Facebook Wall', 'checkbox', NULL, 'Post New Item on Facebook Wall', 10),
(229, 30, 6, 'Item.invite_after_item_add', '1', 'On enabling this feature, lets user to invite friends after item purchase which helps the item to reach its tipped status faster, their by increases the commission amount.', 'checkbox', NULL, 'Enable Redirect to Invite After Purchase', 0),
(71, 21, 2, 'site.maintenance_mode', '0', 'On enabling this feature, only administrator can access the site (e.g., http://yourdomain.com/admin). Users will see a temporary page until you return to turn this off. (Turn this on, whenever you need to perform maintenance in the site.)', 'checkbox', NULL, 'Enable Maintenance Mode', 15),
(60, 25, 4, 'site.time.tooltip', '%B %d, %Y (%A) %Z', 'This is the time tooltip format which is displayed in our site.', 'text', NULL, 'Time Tooltip Format', 29),
(232, 0, 65, 'thumb_size.subscription_thumb.width', '395', NULL, 'text', NULL, 'Subscription thumb', 0),
(233, 0, 65, 'thumb_size.subscription_thumb.height', '305', NULL, 'text', NULL, '', 0),
(228, 21, 2, 'site.is_mobile_app', '1', 'On enabling this feature, the site can be accessed through mobile. (e.g., http:/m.yourdomain.com/?mobile=true)', 'checkbox', NULL, 'Enable Mobile Version', 31),
(234, 54, 14, 'facebook.fb_access_token', '231084413598942|d48ad0fea7eed29b45d7c35a.1-100000268833646|Z0WD9MFW_yWhdH5QSrFe4B3d7Gs', 'This will be automatically updated when on clicking "Update Facebook Credentials" link. (Required for posting in Facebook)', 'text', NULL, 'Accees Token', 3),
(235, 54, 14, 'facebook.fb_user_id', '100000268833646', 'This will be automatically updated when on clicking "Update Facebook Credentials" link. (Required for posting in Facebook)', 'text', '', 'User ID', 4),
(238, 61, 14, 'friend.gmail_contact_max_result_limit', '1000', 'This is the maximum number of contacts retrieved from Gmail during importing contact.', 'text', NULL, 'Maximum Contact Import Limit', 15),
(239, 54, 14, 'facebook.app_id', '231084413598942', 'This is the application ID used in Facebook plugins such as like box, login and post.', 'text', NULL, 'Application ID', 0),
(240, 57, 14, 'GoogleMap.embed_map', 'Static', 'The selected option is used as the default map type displayed in item listing and merchant page. Static - Image of the map will be generated. Fast, but, unable to zoom or drag/move the map. Embedded - Users can zoom and drag the map. But, takes a little more time to render the map than static.', 'select', 'embed, Static', 'Type', 5),
(245, 38, 7, 'wallet.is_handle_wallet', '1', 'On enabling this feature, Users will be unable to choose payment gateway if they have sufficient wallet balance. If insufficient wallet balance (not zero balance), the remaining amount will be taken from payment gateway of their choice along with their partial wallet amount. (Disable this, if you want users to choose other payment gateways whether they have sufficient wallet amount or not)', 'checkbox', NULL, 'Handle wallet amount', 3),
(247, 59, 14, 'mailchimp.is_enabled', '1', 'On enabling this feature, "Item of the day" & "Interest of the day" mail will be sent through mailchimp server.', 'checkbox', '', 'Enable MailChimp', 1),
(248, 59, 14, 'mailchimp.from_mail', 'groupwithusdev@gmail.com', 'This is the email address that will appear in the "From" fields when sending subscription mail using MailChimp.', 'text', '', 'From Email', 3),
(249, 59, 14, 'mailchimp.api_key', 'ab4a778996e79a7c4b5b5fb3bc361426-us2', 'This is the configured API key', 'text', '', 'API Key', 2),
(250, 0, 65, 'thumb_size.iphone_big_thumb.width', '160', NULL, 'text', NULL, 'iPhone Big Thumb', 13),
(251, 0, 65, 'thumb_size.iphone_big_thumb.height', '102', NULL, 'text', NULL, '', 14),
(252, 0, 65, 'thumb_size.iphone_small_thumb.width', '100', NULL, 'text', NULL, 'iPhone Small Thumb', 15),
(253, 0, 65, 'thumb_size.iphone_small_thumb.height', '60', NULL, 'text', NULL, '', 16),
(254, 54, 14, 'facebook.page_id', '231084413598942', 'This is the Facebook page ID, if specified, any item when gets opened will be posted in this page wall, instead of the configured account.', 'text', NULL, 'Page ID', 6),
(255, 24, 4, 'site.currency_symbol_place', 'left', 'The selected position will be used as default currency symbol position all over the site (also for emails)', 'select', 'left,right', 'Currency Symbol Position', 18),
(256, 44, 9, 'affiliate.is_enabled', '1', 'On enabling this feature, users can make request to become a "Affiliate User" and related affiliate users setting will be enabled.', 'checkbox', NULL, 'Enable Affiliate', 1),
(257, 46, 9, 'affiliate.payment_threshold_for_threshold_limit_reach', '1', 'This is the minimum amount to get reached for a affiliate user can make a withdraw request.', 'text', NULL, 'Minimum Withdrawal Threshold Limit', 6),
(258, 45, 9, 'affiliate.commission_holding_period', '0', 'This is the maximum number of days in which the commission amount is in holding state. During this state, amount cannot be requested for withdrawal.', 'text', NULL, 'Maximum Commission Holding Period', 4),
(259, 45, 9, 'affiliate.commission_on_every_item_purchase', '1', 'On enabling this feature, affiliate user will earn commission amount on every referral purchase. (Turn this off, if you want affiliate user to be payed only for his first referral)', 'checkbox', NULL, 'Enable Pay Commission On Every Item Purchase', 3),
(260, 44, 9, 'affiliate.referral_cookie_expire_time', '1', 'This is the maximum time after which the referral cookie will be expired or unusable.', 'text', NULL, 'Referral Cookie Expire Time', 2),
(261, 46, 9, 'affiliate.site_commission_amount', '1', 'This is the amount which will be taken during affiliate cash withdrawal. (If left empty, then, no fee will be taken)', 'text', NULL, 'Transaction fee', 7),
(262, 46, 9, 'affiliate.site_commission_type', 'amount', 'The selected option will be used as the default fee type during affiliate cash withdrawal.', 'select', 'percentage,amount', '', 8),
(265, 47, 10, 'referral.referral_enabled_option', 'Refer and Get Refund/Get Amount', 'The selected option will be used as the default referral earning option in our site. Referral user will get amount or refund, based on the type chosen. Single Purchase Referral Amount - Earn "Referral Amount" for first purchase made by referred user. Multiple Purchase Referral Amount (or Refund) - Earn "Referral Amount" or get the item amount refunded, on number of purchases ("Referral Target Count") made by referred user.', 'select', 'Refer and Get Amount,Refer and Get Refund/Get Amount,Disable Referral', 'Referral Earning Type Options', 1),
(266, 49, 10, 'referral.no_of_refer_to_get_a_refund', '3', 'This is the target referral count to get reached for a referral user to get referral amount or refund', 'text', NULL, 'Referral Target Count', 7),
(267, 49, 10, 'referral.refund_type', 'Refund Item Amount', 'The selected option will be used as the default reward type for a referred user.<br> Refund Item Amount - The referred user purchased item amount (discounted amount) will be refunded as the reward.<br> Refund Amount - The amount set in "Referred Amount" will rewarded.', 'select', 'Refund Item Amount, Refund Particular Amount', 'Referral Reward Type', 8),
(268, 49, 10, 'referral.refund_amount', '', 'This is the amount earned by referral user. (Requires "Referral Reward Type" set to "Referral Amount")', 'text', NULL, 'Referral Amount', 9),
(273, 43, 8, 'charity.site_commission_type', 'amount', 'The selected option will be used as the default fee type during charity cash withdrawal.', 'select', 'percentage,amount', '', 8),
(272, 43, 8, 'charity.site_commission_amount', '1', 'This is the amount which will be taken during charity cash withdrawal. (If left empty, then, no fee will be taken)', 'text', NULL, 'Transaction Fee', 7),
(270, 42, 8, 'charity.who_will_pay', 'Admin', 'The selected option will be used as the default for paying amount to the charity. Admin - Administrator will pay from his earned commission portion. Merchant - Merchant will pay from this earned portion (excluding the admin commission amount). Administrator and Merchant - Both will pay from their earned amount.', 'select', 'Admin,Merchant User,Admin and Merchant User', 'Who Will Pay to Charity', 2),
(271, 41, 8, 'charity.is_enabled', '1', 'On enabling this feature, merchant or administrator will donate certain percent of amount for charities on each purchase. The merchant decides the percent share for the charity. (Charities are registered to the site by administrator only)', 'checkbox', '', 'Enable Charity', 1),
(269, 42, 8, 'charity.who_will_choose', 'Buyer', 'The selected option will be used as the default for selecting the charity. Merchant - merchant decides which charity the buyer should pay. Buyer - buyer decides which charity they would like to pay.', 'select', 'Merchant User,Buyer', 'Who Will Choose the Charity', 3),
(276, 34, 6, 'item.is_user_can_change_pass_type', '1', 'On enabling this feature, users can permission to change the pass status to "used". Merchant has always have permission to change between "used" & "not-used". (Turn this on, to make users to mark this status as "used" for their reference.)', 'checkbox', '', 'Enable User to Change Pass Status', 13),
(275, 34, 6, 'item.item_pass_code_show_type', 'top', 'The selected option be used as the default option in displaying pass. Top code - Actually pass code Bottom code - Unique code (Requires "Pass Usable Option''s" to be submit)', 'select', 'top,bottom', 'Alternate pass Displays Modes', 12),
(274, 34, 6, 'item.item_pass_used_type', 'submit', 'The selected option will be used as the default "pass usable" option for the users. Click - Pass will marked as used on clicking the "used" link. Submit - Pass needs to be entered in a input field and then submit for marking it as "used". (Note: Users can only mark as used, whereas the merchant can change between "used/not-used")', 'select', 'click,submit', 'Alternate Pass Usable Modes', 11),
(278, 70, 11, 'messages.content_length', '50', 'Here you can control and truncate the message content length in listing with subject and body.', 'text', NULL, 'Message Content Length in List', 6),
(279, 70, 11, 'messages.page_size', '50', 'Here you can control messages per page in listing.', 'text', NULL, 'Messages per page', 7),
(281, 70, 11, 'messages.is_send_email_on_new_message', '1', 'Here you can control whether notification will be sent to user while new message or not.', 'checkbox', NULL, 'Enable Notify User on New Message', 5),
(282, 70, 11, 'messages.allowed_message_size', '2', 'Here you can control the allowed memory usage.', 'text', NULL, 'Allowed Memory Usage', 1),
(283, 70, 11, 'messages.allowed_message_size_unit', 'MB', 'Here you can update the allowed memory size as unit (KB/MB/GB/B)', 'select', 'MB, KB, GB, B', '', 2),
(286, 0, 65, 'thumb_size.home_thumb.width', '494', '', 'text', NULL, 'Small big thumb', 11),
(287, 0, 65, 'thumb_size.home_thumb.height', '304', '', 'text', NULL, '', 12),
(288, 0, 65, 'thumb_size.small_medium_thumb.width', '78', '', 'text', NULL, 'Small thumb', 3),
(289, 0, 65, 'thumb_size.small_medium_thumb.height', '71', '', 'text', NULL, '', 4),
(290, 24, 4, 'site.currency_id', '0', 'The selected currency will be used as site default currency. (All payments, transaction will use this currency).', 'select', NULL, 'Currency', 7),
(291, 24, 4, 'site.paypal_currency_converted_id', '0', 'PayPal doesn''t support all currencies; refer, <a href="https://www.paypal.com/cgi-bin/webscr?cmd=p/sell/mc/mc_wa-outside">https://www.paypal.com/cgi-bin/webscr?cmd=p/sell/mc/mc_wa-outside</a> for list of supported currencies in PayPal. Users will be forced to pay with the selected currency in PayPal (with currency conversion done) when site''s currency isn''t supported by PayPal. Note that this software gets PayPal supported currencies from ##MASTER_CURRENCY##; keep that updated with <a href="https://www.paypal.com/cgi-bin/webscr?cmd=p/sell/mc/mc_wa-outside">https://www.paypal.com/cgi-bin/webscr?cmd=p/sell/mc/mc_wa-outside</a> when you''re utilizing this feature.', 'select', NULL, 'PayPal Converted Currency', 8),
(294, 0, 65, 'thumb_size.comment_thumb.width', '78', NULL, 'text', NULL, 'Comment thumb', 0),
(295, 0, 65, 'thumb_size.comment_thumb.height', '71', NULL, 'text', NULL, 'Comment thumb', 0),
(297, 17, 1, 'site.tag_text', 'Join with Awesome People !', 'This text will used as to display below logo.', 'text', NULL, 'Slogan', 0),
(301, 0, 65, 'thumb_size.reataurent_user_medium_thumb.width', '48', '', 'text', NULL, 'Restaurant user Medium', 0),
(302, 0, 65, 'thumb_size.reataurent_user_medium_thumb.height', '48', '', 'text', NULL, '', 0),
(303, 0, 65, 'thumb_size.reataurent_user_small_thumb.width', '56', '', 'text', NULL, 'Restaurant user small', 0),
(304, 0, 65, 'thumb_size.reataurent_user_small_thumb.height', '56', '', 'text', NULL, '', 0),
(137, 66, 7, 'merchant.is_user_can_withdraw_amount', '1', 'On enabling this feature, merchant can make a request to withdraw their wallet amount to their provided. PayPal account. (Requires administrator approval for each request).', 'checkbox', NULL, 'Enable Cash Withdrawal', 9),
(305, 0, 65, 'thumb_size.city_banner_thumb.width', '756', '', 'text', NULL, 'City thumb', 1),
(306, 0, 65, 'thumb_size.city_banner_thumb.height', '105', '', 'text', NULL, '', 2),
(307, 36, 7, 'merchant.is_paid_to_merchant_automatic', '1', 'On enabling this feature, payment will be automatically made for the "online" merchant once item status get changed to "closed". (Disable this, if you want to make the payment manually when changing the status from "closed" to "Pay To Merchant" in item listings page.)', 'checkbox', NULL, 'Enable Auto Pay for Merchant', 2),
(308, 0, 65, 'thumb_size.user_interest_thumb.width', '46', '', 'text', NULL, 'User Interest thumb', 1),
(309, 0, 65, 'thumb_size.user_interest_thumb.height', '46', '', 'text', NULL, '', 2),
(311, 56, 14, 'foursquare.consumer_key', 'P1GCD0QZMYDURRXM4UFVSIS3AXNTB4NVYHNPEU2P4DJFGEJ2', 'This is the consumer key used for authentication and posting on Foursquare.', 'text', NULL, 'Consumer Key', 0),
(312, 56, 14, 'foursquare.consumer_secret', 'HF4MOBD4CGGFVO1HMS2ODU4LJNCWGW2FIB4MWJBO0VIZKE4Z', 'This is the consumer secret key used for authentication and posting on Foursquare.', 'text', NULL, 'Consumer Secret Key', 0),
(313, 56, 14, 'foursquare.site_user_fs_id', '10462689', 'This will be automatically updated when on clicking "Update Foursquare Credentials" link. (Required for posting in Foursquare)', 'text', NULL, 'User ID', 0),
(314, 56, 14, 'foursquare.site_user_access_token', '1DAJHQ2Z0OR5IRGQIVS2QBGCHNSQEHTSEBBWAGPZJMRCPM50', 'This will be automatically updated when on clicking "Update Foursquare Credentials" link. (Required for posting in Foursquare)', 'text', NULL, 'Access Token', 0),
(315, 56, 14, 'foursquare.new_item_message', '##SLUGGED_SITE_NAME## ##ITEM_NAME##', 'This is the format used when posting on Facebook when items get opened. ##ITEM_NAME##, ##SLUGGED_SITE_NAME##., will be automatically replaced when posting on Foursquare', 'textarea', NULL, 'Foursquare Post Format', 0),
(316, 56, 14, 'foursquare.site_foursquare_venue_id', '23828924', 'This is the default venue ID for the site. (To create venue, <a href="http://dev1products.dev.agriya.com/doku.php?id=foursquare-setup#creating_venue"> http://dev1products.dev.agriya.com/doku.php?id=foursquare-setup#creating_venue </a>)', 'text', NULL, 'Venue ID', 0),
(317, 56, 14, 'foursquare.enable_foursquare_post_open_item', '1', 'On enabling this feature, when item gets opened, the information about the opened items will be automatically posted in Foursquare Account configured.', 'checkbox', NULL, 'Post New Item on Foursquare', 0),
(319, 30, 6, 'item.is_enable_item_category', '1', 'On enabling this feature, merchant or admin can select item category like vegetarian etc., in items add & edit page. Also in front end user can filter by category in items list page.', 'checkbox', NULL, 'Enable Item Category', 0),
(320, 24, 4, 'site.is_auto_currency_updation', '1', 'On enabling this feature, latest currency conversion values are automatically updated <a href="http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml"> http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml</a> via cron everyday. (Disable this, if you have manually updated certain currency values in ##MASTER_CURRENCY##)', 'checkbox', NULL, 'Enable Automatic Currency Conversion Updation', 0),
(321, 24, 4, 'site.is_currency_conversion_history_updation', '1', 'On enabling this feature, latest currency conversion rate, old rate are stored in currency conversion History.', 'checkbox', NULL, 'Enable Currency Conversion History Updation', 0),
(322, 26, 5, 'user.is_enable_gmail_openid', '1', 'On enabling this feature, users can authenticate their ##SITE_NAME## account using Gmail.', 'checkbox', NULL, 'Enable Gmail', 0),
(323, 26, 5, 'user.is_enable_yahoo_openid', '1', 'On enabling this feature, users can authenticate their ##SITE_NAME## account using Yahoo.', 'checkbox', NULL, 'Enable Yahoo', 0),
(324, 47, 10, 'referral.referral_enable', '1', 'On enabling this feature, user can access referral functionality', 'checkbox', NULL, 'Enable Referral', 0),
(325, 66, 7, 'merchant.minimum_withdraw_amount', '2', 'This is the minimum amount a merchant can withdraw from their wallet.', 'text', '', 'Minimum Wallet Withdrawal Amount', 0),
(326, 66, 7, 'merchant.maximum_withdraw_amount', '120', 'This is the maximum amount a merchant can withdraw from their wallet.', 'text', NULL, 'Maximum Wallet Withdrawal Amount', 0),
(327, 66, 7, 'merchant.is_withdraw_request_amount_paid_automatic', '1', 'On enabling this feature, merchants request for cash withdrawal will be automatically carried out everyday when cron is triggered and requests will be sent to PayPal for processing without the needed for administrator approval. (Disable this, if you want to manually approve each request for processing)', 'checkbox', NULL, 'Enable Auto Pay for Merchants Withdrawal', 0),
(328, 69, 14, 'google.translation_api_key', '', 'This is the configured Google Translate API key.', 'text', NULL, 'API Key', 0),
(329, 31, 6, 'item.is_admin_enable_commission', '1', 'On enabling this feature, administrator can override the commission percentage over merchant users.', 'checkbox', NULL, 'Enable Administrator to Control Commission Percentage', 0),
(330, 31, 6, 'item.commission_amount_type', 'minimum', '<p>The selected option will be used as the default commission percentage type. Based on this, "commission percentage" field will be used.</p><p>Fixed - Merchant should pay the amount set in "commission percentage". merchant cannot set or modify the commission amount. </p><p>Minimum - Merchant should pay greater than or equal to the one set in "commission percentage".</p><p>(Requries: "Enable Administrator to Control Commission Percentage" should be checked to take this setting in effect.)</p>', 'select', 'minimum,fixed', 'Commission Type', 0),
(331, 31, 6, 'item.commission_amount', '30', 'This is the commission percentage which will be taken from merchant when on closing the item (after tipped status). (Requires "Enable Administrator to Control Commission Percentage" to be enabled)', 'text', NULL, 'Commission Percentage (%)', 0),
(332, 71, 12, 'cdn.images', '', 'This is base URL (without trailing slash) for CDN images. (e.g., http://images.yourdomain.com)', 'text', NULL, 'CDN Image URL', 1),
(333, 71, 12, 'cdn.css', '', 'This is base URL (including trailing slash) for CDN CSS. (e.g., http://css.yourdomain.com/)', 'text', NULL, 'CDN CSS URL', 2),
(334, 71, 12, 'cdn.js', '', 'This is base URL (including trailing slash) for CDN JavaScript. (e.g., http://js.yourdomain.com/)', 'text', NULL, 'CDN JS URL', 3),
(335, 70, 11, 'messages.is_allow_send_messsage', '1', 'Here you can control whether notification will be sent to user while new message or not.', 'checkbox', '', 'Enable Send Message Option', 5),
(336, 0, 5, 'twitter.prompt_for_email_after_register', '1', 'On enabling this feature, users login through Twitter will be prompted to enter email by redirecting to our site registration page again. (Disable this, if dont require email for users registering through Twitter.)', 'checkbox', NULL, 'Prompt for Email After Registration', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setting_categories`
--

DROP TABLE IF EXISTS `setting_categories`;
CREATE TABLE IF NOT EXISTS `setting_categories` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `parent_id` bigint(20) default '0',
  `name` varchar(200) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Site Setting Category Details';

--
-- Dumping data for table `setting_categories`
--

INSERT INTO `setting_categories` (`id`, `created`, `modified`, `parent_id`, `name`, `description`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'System', 'Manage site name, contact email, from email, reply to email and subscription.'),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Developments', 'Manage Maintenance mode and Mobile layout.'),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'SEO', 'Manage content, meta data and other information relevant to browsers or search engines'),
(4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Regional, Currency & Language', 'Manage site default language, default city, city routing URL, currency, date-time format and timezone'),
(5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Account', 'Manage different type of login option such as Facebook, Twitter, Yahoo and Gmail'),
(6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Item', 'Manage & configure settings related to items, pass, commission and items list options.'),
(7, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Payment', 'Manage payment related settings such as wallet, cash withdrawal and item purchase.<br>Manage different types payment gateway settings of the site. [Wallet, Credit Card Using PayPal, PayPal, Credit Card using Authorize.net CIM, PagSeguro]. <a title="Update Payment Gateway Settings" class="paymentgateway-link" href="##PAYMENT_SETTINGS_URL##">Update Payment Gateway Settings</a>'),
(8, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Charity', 'Manage charity information, commission and withdraw amount details.'),
(9, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Affiliate', 'Manage affiliate information,  commission and withdraw amount details.'),
(10, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Referrals', 'Manage referral and various settings such as referral earning type, register cookie expire time, purchase cookie expire time, referral amount, referral target count, reward type, refund amount.'),
(13, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Friends', 'Manage friends request, approve and send mail related settings.'),
(14, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Third Party API', 'Manage third party settings such as Facebook, Twitter, Foursquare, Google Map, MailChimp, Gmail, Yahoo, MSN for authentication, sending subscription mail, importing contacts and posting.'),
(16, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Module Manager', 'Manage Referral, Affiliate, Charity and Friends module enable and disable options.'),
(17, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'Site Information', 'Here you can modify site related settings such as site name.'),
(18, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'E-mails', 'Here you can modify email related settings such as contact email, from email, reply-to email.'),
(24, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 'Currency Settings', 'Here you can modify site currency settings such as currency position, default currency and conversion currency.'),
(21, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 'Server', 'Here you can change server settings such as maintenance mode, SSL settings.'),
(22, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 'Metadata', 'Here you can set metadata settings such as meta keyword and description.'),
(23, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 'SEO', 'Here you can set SEO settings such as inserting tracker code and robots.'),
(19, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 'Regional', 'Here you can change regional setting such as site language, default city, routing URL.'),
(25, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 'Date and Time', 'Here you can modify date time settings such as timezone, date time format.'),
(26, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 'Logins', 'Here you can modify user login settings such as enabling 3rd party logins and other login options.'),
(27, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 'Account Settings', 'Here you can modify account settings such as admin approval, email verification, and other site account settings.'),
(28, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 'Privacy', 'Here you can modify privacy settings such as allowing user language change, comments and other user personal settings.'),
(29, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 'Merchant', 'Here you modify merchant settings such as allowing merchant to have normal features, merchant statistics.'),
(30, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 'Configuration', 'Here you modify item settings such as configuring item category and other item related settings.'),
(31, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 'Commission', 'Here you can modify item commission related settings such as controlling merchant paying commission percentage, commission type and other commission related settings for a item. You can set whether a merchant can modify the commission percentage or should pay the commission percentage set in "Commission Percentage" based on the selection of "Commission Type".'),
(33, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 'Displays', 'Here you can modify item display related settings such as enabling item listing for merchants and other display settings.'),
(34, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 'Pass', 'Here you can modify pass related settings such as pass type, status and other pass settings.'),
(35, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 'Barcode', 'Here you can modify barcode settings such as symbology, width, height settings. You can enable/disable barcode and its types here. Based on the symbology, the barcode will be displayed in the pass code. If you use barcode reader with computer, it will help in input pass code in the text box. If you have POS machine, you can export the pass code and try matching with that.'),
(36, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 7, 'Items', 'Here you can modify payment related setting such as auto pay, auto-refund for a item. Once enabled, no need for administrator to manually close a item & make payment for the merchant or close the item when it fails. It will be automatically processed.'),
(38, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 7, 'Wallet', 'Here you can modify wallet related setting such as enabling groupon-like wallet, maximum and minimum funding limit settings.'),
(39, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 7, 'Cash Withdraw', ''),
(40, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 7, 'Cash Withdraw for User', 'Here you can modify cash withdraw settings for a user such as enabling withdrawal and setting withdraw limit'),
(41, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 8, 'Configuration', 'Here you can modify charity related settings'),
(42, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 8, 'Commission', 'Here you can modify charity related settings such as charity choosing feature.'),
(43, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 8, 'Withdrawal', 'Here you can modify charity withdraw settings such as transaction fee and fee type settings.'),
(44, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 'Configuration', 'Here you can modify affiliate related settings such as enabling affiliate and referral expire time.'),
(45, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 'Commission', 'Here you can modify affiliate related commission settings such as commission holding period, commission pay type settings.'),
(46, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 'Withdrawal', 'Here you can modify affiliate withdrawal settings such as threshold limit, transaction fee settings.'),
(47, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 10, 'Configuration', 'Here you can modify referral related settings such as enabling referrals, referral expiry time and other referral basic settings. '),
(48, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 10, 'Refer and Get Amount ', 'Here you can modify "Single Purchase Referral" settings which is used for single referral purchase or register. Settings such as cookie expire time, referral amount settings can be set.'),
(49, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 10, 'Multiple Purchase Referral Amount', 'Here you can modify "Multiple Purchase Referral Amount" settings which is used for multiple referral purchases. Settings such as no of referrals, referral reward type can be set.'),
(53, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 13, 'Configuration', 'Here you can modify friend settings such as enabling friend, auto accept and other friendship related settings.'),
(54, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 'Facebook', 'Facebook is used for login and posting message using its account details. For doing above, our site must be configured with existing Facebook account. <a href="http://dev1products.dev.agriya.com/doku.php?id=facebook-setup"> http://dev1products.dev.agriya.com/doku.php?id=facebook-setup </a>'),
(55, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 'Twitter', 'Twitter is used for login and posting message using its account details. For doing above, our site must be configured with existing Twitter account. <a href="http://dev1products.dev.agriya.com/doku.php?id=twitter-setup"> http://dev1products.dev.agriya.com/doku.php?id=twitter-setup </a>'),
(56, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 'Foursquare', 'Foursquare is used for login and posting message using its account details. For doing above, our site must be configured with existing Foursquare account. <a href="http://dev1products.dev.agriya.com/doku.php?id=foursquare-setup"> http://dev1products.dev.agriya.com/doku.php?id=foursquare-setup </a>'),
(57, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 'Google Map', ''),
(58, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 'Bitly', 'Bitly (bit.ly) is a URL shortening service. We use this service to shorten the URL formed for posting in Twitter, Facebook & other share pages. (Since certain sites restrict the total length of the text to be posted). For doing above, our site must be configured with existing Bitly account. <a href="http://dev1products.dev.agriya.com/doku.php?id=bitly-setup"> http://dev1products.dev.agriya.com/doku.php?id=bitly-setup</a>'),
(59, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 'MailChimp', 'MailChimp is a powerful, easy-to-use email marketing service. We use this service when sending subscription mail for the users. (Since sending large of mail at a time can affect our server performance). For doing above, our site must be configured with existing MailChimp account. <a href="http://dev1products.dev.agriya.com/doku.php?id=mailchimp-integration"> http://dev1products.dev.agriya.com/doku.php?id=mailchimp-integration</a>. ##MAIL_CHIMP_LINK## to manage the MailChimp Mailing Lists. '),
(60, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 'Yahoo', 'We use this service for importing contacts from Yahoo for friends invite. For doing above, our site must be configured with existing Yahoo account. <a href="http://dev1products.dev.agriya.com/doku.php?id=yahoo-setup"> http://dev1products.dev.agriya.com/doku.php?id=yahoo-setup </a>'),
(61, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 'Gmail', 'We use this service for importing contacts from Gmail for friends invite. For doing above, our site must be configured with existing Gmail account. <a href="http://dev1products.dev.agriya.com/doku.php?id=google_setup"> http://dev1products.dev.agriya.com/doku.php?id=google_setup </a>'),
(62, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 'MSN', 'We use this service for importing contacts from MSN for friends invite. For doing above, our site must be configured with existing MSN account. <a href="http://dev1products.dev.agriya.com/doku.php?id=msn-setup"> http://dev1products.dev.agriya.com/doku.php?id=google_setup </a>'),
(64, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 16, 'Module', 'Here you can modify module settings such as enabling/disabling master modules settings.'),
(66, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 7, 'Cash Withdraw for Merchant', 'Here you can modify cash withdraw settings for a merchant such as enabling withdrawal and setting withdraw limit'),
(68, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 16, 'Configuration', ''),
(69, '2011-10-11 18:55:26', '2011-10-11 18:55:26', 14, 'Google Translations', '<p>We use this service for quick translation to support new languages in ##TRANSLATIONADD##.</p> <p>Note that Google Translate API is now a <a href="http://code.google.com/apis/language/translate/v2/pricing.html" target="_blank">paid service</a>. Getting Api key, refer <a href="http://dev1products.dev.agriya.com/doku.php?id=google-translation-setup" target="_blank">http://dev1products.dev.agriya.com/doku.php?id=google-translation-setup</a>.</p>'),
(11, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Messages', 'Manage allowed memory usage to user and send mail related settings'),
(70, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 11, 'Configuration', 'Here you modify message settings such as configuring allowed memory usage and other message related settings.'),
(12, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'CDN', 'Manage CDN server settings which is used to store the Images, CSS and JavaScript. So all the above will be loaded from CDN server to your site.'),
(71, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 12, 'Configuration', '');

-- --------------------------------------------------------

--
-- Table structure for table `site_categories`
--

DROP TABLE IF EXISTS `site_categories`;
CREATE TABLE IF NOT EXISTS `site_categories` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `slug` varchar(265) collate utf8_unicode_ci default NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `site_categories`
--

INSERT INTO `site_categories` (`id`, `created`, `modified`, `name`, `slug`, `is_active`) VALUES
(1, '2010-05-14 07:31:32', '2010-05-14 07:31:32', 'Technology', 'technology', 1),
(2, '2010-05-14 07:31:47', '2010-05-14 07:31:47', 'Programming', 'programming', 1),
(3, '2010-05-14 07:32:00', '2010-05-14 07:32:00', 'Music & Audio', 'music-audio', 1),
(4, '2010-05-14 07:32:13', '2010-05-14 07:32:13', 'Business', 'business', 1),
(5, '2010-05-14 07:32:28', '2010-05-14 07:32:28', 'Silly Stuff', 'silly-stuff', 1),
(6, '2010-05-14 07:32:42', '2010-05-14 07:32:42', 'Other', 'other', 1),
(7, '2010-05-14 07:32:55', '2010-05-14 07:32:55', 'Graphics', 'graphics', 1),
(8, '2010-05-14 07:33:17', '2010-05-14 07:33:17', 'Writing', 'writing', 1),
(9, '2010-05-14 07:33:30', '2010-06-04 09:03:58', 'Fun &  Bizarre', 'fun-bizarre', 0);

-- --------------------------------------------------------

--
-- Table structure for table `spam_filters`
--

DROP TABLE IF EXISTS `spam_filters`;
CREATE TABLE IF NOT EXISTS `spam_filters` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `other_user_id` bigint(20) NOT NULL,
  `content` text collate utf8_unicode_ci,
  `subject` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `other_user_id` (`other_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `spam_filters`
--


-- --------------------------------------------------------

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `id` bigint(20) NOT NULL auto_increment,
  `country_id` bigint(20) NOT NULL,
  `name` varchar(45) collate utf8_unicode_ci NOT NULL,
  `code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `adm1code` char(4) collate utf8_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `country_id` (`country_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `name`, `code`, `adm1code`, `is_approved`) VALUES
(1, 253, 'British Columbia', 'BC', '', 1),
(2, 253, 'Manitoba', 'MB', '', 1),
(3, 253, 'New Brunswick', 'NB', '', 1),
(4, 43, 'Newfoundland and Labrador', 'NL', '', 1),
(5, 253, 'Northwest Territories', 'NT', '', 1),
(6, 253, 'Nunavut', 'NU', '', 1),
(7, 253, 'Ontario', 'ON', '', 1),
(8, 253, 'Prince Edward Island', 'PE', '', 1),
(9, 253, 'Quebec', 'QC', '', 1),
(10, 253, 'Saskatchewan', 'SK', '', 1),
(11, 253, 'Yukon', 'YT', '', 1),
(12, 253, 'Alabama', 'AL', '', 0),
(13, 253, 'Alaska', 'AK', '', 1),
(14, 253, 'American Samoa', 'AS', '', 1),
(15, 253, 'Arizona', 'AZ', '', 1),
(16, 253, 'Arkansas', 'AR', '', 1),
(17, 253, 'California', 'CA', '', 1),
(18, 253, 'Colorado', 'CO', '', 1),
(19, 253, 'Connecticut', 'CT', '', 1),
(20, 253, 'Delaware', 'DE', '', 1),
(21, 253, 'District of Columbia', 'DC', '', 1),
(22, 253, 'Federated States of Micronesia', 'FM', '', 1),
(23, 253, 'Florida', 'FL', '', 1),
(24, 253, 'Georgia', 'GA', '', 1),
(25, 253, 'Guam', 'GU', '', 1),
(26, 253, 'Hawaii', 'HI', '', 1),
(27, 253, 'Illinois', 'IL', '', 1),
(28, 253, 'Indiana', 'IN', '', 1),
(29, 253, 'Iowa', 'IA', '', 1),
(30, 253, 'Kansas', 'KS', '', 1),
(31, 253, 'Kentucky', 'KY', '', 1),
(32, 253, 'Louisiana', 'LA', '', 1),
(33, 253, 'Maine', 'ME', '', 1),
(34, 253, 'Marshall Islands', 'MH', '', 1),
(35, 253, 'Maryland', 'MD', '', 1),
(36, 253, 'Massachusetts', 'MA', '', 1),
(37, 253, 'Michigan', 'MI', '', 1),
(38, 253, 'Minnesota', 'MN', '', 1),
(39, 253, 'Mississippi', 'MS', '', 1),
(40, 253, 'Missouri', 'MO', '', 1),
(41, 253, 'Montana', 'MT', '', 1),
(42, 253, 'Nebraska', 'NE', '', 1),
(43, 253, 'Nevada', 'NV', '', 1),
(44, 253, 'New Hampshire', 'NH', '', 1),
(45, 253, 'New Jersey', 'NJ', '', 1),
(46, 253, 'New Mexico', 'NM', '', 1),
(47, 253, 'New York', 'NY', '', 1),
(48, 253, 'North Carolina', 'NC', '', 1),
(49, 253, 'North Dakota', 'ND', '', 1),
(50, 253, 'Northern Mariana Islands', 'MP', '', 1),
(51, 253, 'Oklahoma', 'OK', '', 1),
(52, 253, 'Oregon', 'OR', '', 1),
(53, 253, 'Palau', 'PW', '', 1),
(54, 253, 'Pennsylvania', 'PA', '', 1),
(55, 253, 'Puerto Rico', 'PR', '', 1),
(56, 253, 'Rhode Island', 'RI', '', 1),
(57, 253, 'South Carolina', 'SC', '', 1),
(58, 253, 'South Dakota', 'SD', '', 1),
(59, 253, 'Texas', 'TX', '', 1),
(60, 253, 'Utah', 'UT', '', 1),
(61, 253, 'Vermont', 'VT', '', 1),
(62, 253, 'Virgin Islands', 'VI', '', 1),
(63, 253, 'Virginia', 'VA', '', 1),
(64, 253, 'Washington', 'WA', '', 1),
(65, 253, 'West Virginia', 'WV', '', 1),
(66, 253, 'Wisconsin', 'WI', '', 1),
(67, 253, 'Wyoming', 'WY', '', 1),
(68, 253, 'Armed Forces Americas', 'AA', '', 1),
(69, 253, 'Armed Forces', 'AE', '', 1),
(70, 253, 'Armed Forces Pacific', 'AP', '', 1),
(71, 0, 'Tamil Nadu', '', '', 1),
(72, 0, 'sdfdsfs', '', '', 0),
(73, 0, 'fdgdfgd', '', '', 0),
(74, 0, 'ihjhjh', '', '', 0),
(75, 0, 'dki', '', '', 0),
(76, 0, 'Chisinau', '', '', 0),
(77, 0, 'orissa', '', '', 1),
(78, 0, 'jharkhand', '', '', 0),
(79, 0, 'Moscow City', '', '', 0),
(80, 0, 'Sao Paulo', '', '', 0),
(81, 0, 'Distrito Federal', '', '', 0),
(82, 0, 'Dubai', '', '', 0),
(83, 0, 'Tamilnadu', '', '', 0),
(84, 0, 'rtr', '', '', 0),
(85, 0, 'Gujarat', '', '', 0),
(86, 0, 'Bogota', '', '', 0),
(87, 113, 'Gujarat', '079', 'aa', 1),
(88, 0, 'qwc', '', '', 0),
(89, 0, 'GraubÃƒÆ’Ã‚Â¼nden', '', '', 0),
(90, 215, 'Pcinjski Okrug', 'keinCode', '', 1),
(91, 234, 'Schweiz', 'keinCode', '', 1),
(92, 0, 'Beyrouth', '', '', 0),
(93, 0, 'MO', '', '', 0),
(94, 0, 'Maharastra', '', '', 0),
(95, 0, 'Karnataka', '', '', 0),
(96, 0, 'Cundinamarca', '', '', 0),
(97, 0, 'san jose', '', '', 0),
(98, 0, 'Reading', '', '', 0),
(99, 6, 'test', 'test', '', 0),
(100, 0, 'Rogaland', '', '', 0),
(101, 0, 'Rizal', '', '', 0),
(102, 0, 'Canada', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) unsigned default '0',
  `city_id` bigint(20) unsigned NOT NULL,
  `email` varchar(255) collate utf8_unicode_ci NOT NULL,
  `is_subscribed` tinyint(1) default '1',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `city_id` (`city_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `subscriptions`
--


-- --------------------------------------------------------

--
-- Table structure for table `temp_contacts`
--

DROP TABLE IF EXISTS `temp_contacts`;
CREATE TABLE IF NOT EXISTS `temp_contacts` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `contact_id` bigint(20) NOT NULL,
  `contact_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `contact_email` varchar(255) collate utf8_unicode_ci NOT NULL,
  `is_member` int(2) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Temporary Contact Details';

--
-- Dumping data for table `temp_contacts`
--


-- --------------------------------------------------------

--
-- Table structure for table `temp_payment_logs`
--

DROP TABLE IF EXISTS `temp_payment_logs`;
CREATE TABLE IF NOT EXISTS `temp_payment_logs` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `trans_id` bigint(20) NOT NULL,
  `payment_type` varchar(50) collate utf8_unicode_ci NOT NULL,
  `payment_method` varchar(255) collate utf8_unicode_ci default NULL,
  `user_id` bigint(20) NOT NULL,
  `item_id` bigint(20) default NULL,
  `sub_item_id` bigint(20) default '0',
  `is_gift` tinyint(1) default NULL,
  `quantity` int(5) default NULL,
  `payment_gateway_id` int(5) default NULL,
  `gift_to` varchar(255) collate utf8_unicode_ci default NULL,
  `guest_name` text collate utf8_unicode_ci,
  `guest_email` text collate utf8_unicode_ci,
  `ip_id` bigint(20) NOT NULL,
  `amount_needed` double(10,2) NOT NULL,
  `original_amount_needed` double(10,2) default '0.00',
  `currency_code` varchar(10) collate utf8_unicode_ci NOT NULL,
  `message` text collate utf8_unicode_ci,
  `purchased_via` varchar(100) collate utf8_unicode_ci default NULL,
  `friend_name` varchar(200) collate utf8_unicode_ci default NULL,
  `friend_mail` varchar(200) collate utf8_unicode_ci default NULL,
  `referred_user_id` int(20) default NULL,
  `is_purchase_with_wallet_amount` tinyint(1) default '0',
  `charity_id` bigint(20) default NULL,
  `city` bigint(20) default NULL,
  `latitude` float(10,6) default NULL,
  `longitude` float(10,6) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `temp_payment_logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

DROP TABLE IF EXISTS `timezones`;
CREATE TABLE IF NOT EXISTS `timezones` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `code` varchar(255) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `gmt_offset` varchar(10) collate utf8_unicode_ci NOT NULL,
  `dst_offset` varchar(10) collate utf8_unicode_ci NOT NULL,
  `raw_offset` varchar(10) collate utf8_unicode_ci NOT NULL,
  `hasdst` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `created`, `modified`, `code`, `name`, `gmt_offset`, `dst_offset`, `raw_offset`, `hasdst`) VALUES
(1, '2010-05-10 20:13:09', '2010-05-10 20:13:09', 'Pacific/Apia', '(GMT-11:00) Apia', '-10.0', '-11.0', '-11.0', 1),
(2, '2010-05-10 20:13:09', '2010-05-10 20:13:09', 'Pacific/Midway', '(GMT-11:00) Midway', '-11.0', '-11.0', '-11.0', 0),
(3, '2010-05-10 20:13:09', '2010-05-10 20:13:09', 'Pacific/Niue', '(GMT-11:00) Niue', '-11.0', '-11.0', '-11.0', 0),
(4, '2010-05-10 20:13:09', '2010-05-10 20:13:09', 'Pacific/Pago_Pago', '(GMT-11:00) Pago Pago', '-11.0', '-11.0', '-11.0', 0),
(5, '2010-05-10 20:13:09', '2010-05-10 20:13:09', 'Pacific/Fakaofo', '(GMT-10:00) Fakaofo', '-10.0', '-10.0', '-10.0', 0),
(6, '2010-05-10 20:13:09', '2010-05-10 20:13:09', 'Pacific/Honolulu', '(GMT-10:00) Hawaii Time', '-10.0', '-10.0', '-10.0', 0),
(7, '2010-05-10 20:13:09', '2010-05-10 20:13:09', 'Pacific/Johnston', '(GMT-10:00) Johnston', '-10.0', '-10.0', '-10.0', 0),
(8, '2010-05-10 20:13:09', '2010-05-10 20:13:09', 'Pacific/Rarotonga', '(GMT-10:00) Rarotonga', '-10.0', '-10.0', '-10.0', 0),
(9, '2010-05-10 20:13:09', '2010-05-10 20:13:09', 'Pacific/Tahiti', '(GMT-10:00) Tahiti', '-10.0', '-10.0', '-10.0', 0),
(10, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'Pacific/Marquesas', '(GMT-09:30) Marquesas', '-9.5', '-9.5', '-9.5', 0),
(11, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Anchorage', '(GMT-09:00) Alaska Time', '-9.0', '-8.0', '-9.0', 1),
(12, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'Pacific/Gambier', '(GMT-09:00) Gambier', '-9.0', '-9.0', '-9.0', 0),
(13, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Los_Angeles', '(GMT-08:00) Pacific Time', '-8.0', '-7.0', '-8.0', 1),
(14, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Tijuana', '(GMT-08:00) Pacific Time - Tijuana', '-8.0', '-7.0', '-8.0', 1),
(15, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Vancouver', '(GMT-08:00) Pacific Time - Vancouver', '-8.0', '-7.0', '-8.0', 1),
(16, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Whitehorse', '(GMT-08:00) Pacific Time - Whitehorse', '-8.0', '-7.0', '-8.0', 1),
(17, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'Pacific/Pitcairn', '(GMT-08:00) Pitcairn', '-8.0', '-8.0', '-8.0', 0),
(18, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Dawson_Creek', '(GMT-07:00) Mountain Time - Dawson Creek', '-7.0', '-7.0', '-7.0', 0),
(19, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Denver', '(GMT-07:00) Mountain Time (America/Denver)', '-7.0', '-6.0', '-7.0', 1),
(20, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Edmonton', '(GMT-07:00) Mountain Time - Edmonton', '-7.0', '-6.0', '-7.0', 1),
(21, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Hermosillo', '(GMT-07:00) Mountain Time - Hermosillo', '-7.0', '-7.0', '-7.0', 0),
(22, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Mazatlan', '(GMT-07:00) Mountain Time - Chihuahua, Mazatlan', '-7.0', '-6.0', '-7.0', 1),
(23, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Phoenix', '(GMT-07:00) Mountain Time - Arizona', '-7.0', '-7.0', '-7.0', 0),
(24, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Yellowknife', '(GMT-07:00) Mountain Time - Yellowknife', '-7.0', '-6.0', '-7.0', 1),
(25, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Belize', '(GMT-06:00) Belize', '-6.0', '-6.0', '-6.0', 0),
(26, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Chicago', '(GMT-06:00) Central Time', '-6.0', '-5.0', '-6.0', 1),
(27, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Costa_Rica', '(GMT-06:00) Costa Rica', '-6.0', '-6.0', '-6.0', 0),
(28, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/El_Salvador', '(GMT-06:00) El Salvador', '-6.0', '-6.0', '-6.0', 0),
(29, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Guatemala', '(GMT-06:00) Guatemala', '-6.0', '-6.0', '-6.0', 0),
(30, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Managua', '(GMT-06:00) Managua', '-6.0', '-6.0', '-6.0', 0),
(31, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Mexico_City', '(GMT-06:00) Central Time - Mexico City', '-6.0', '-5.0', '-6.0', 1),
(32, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Regina', '(GMT-06:00) Central Time - Regina', '-6.0', '-6.0', '-6.0', 0),
(33, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Tegucigalpa', '(GMT-06:00) Central Time (America/Tegucigalpa)', '-6.0', '-6.0', '-6.0', 0),
(34, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Winnipeg', '(GMT-06:00) Central Time - Winnipeg', '-6.0', '-5.0', '-6.0', 1),
(35, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'Pacific/Easter', '(GMT-06:00) Easter Island', '-6.0', '-5.0', '-6.0', 1),
(36, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'Pacific/Galapagos', '(GMT-06:00) Galapagos', '-6.0', '-6.0', '-6.0', 0),
(37, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Bogota', '(GMT-05:00) Bogota', '-5.0', '-5.0', '-5.0', 0),
(38, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Cayman', '(GMT-05:00) Cayman', '-5.0', '-4.0', '-5.0', 1),
(39, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Grand_Turk', '(GMT-05:00) Grand Turk', '-5.0', '-4.0', '-5.0', 1),
(40, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Guayaquil', '(GMT-05:00) Guayaquil', '-5.0', '-5.0', '-5.0', 0),
(41, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Havana', '(GMT-05:00) Havana', '-5.0', '-4.0', '-5.0', 1),
(42, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Iqaluit', '(GMT-05:00) Eastern Time - Iqaluit', '-5.0', '-4.0', '-5.0', 1),
(43, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Jamaica', '(GMT-05:00) Jamaica', '-5.0', '-5.0', '-5.0', 0),
(44, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Lima', '(GMT-05:00) Lima', '-5.0', '-5.0', '-5.0', 0),
(45, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Montreal', '(GMT-05:00) Eastern Time - Montreal', '-5.0', '-4.0', '-5.0', 1),
(46, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Nassau', '(GMT-05:00) Nassau', '-5.0', '-4.0', '-5.0', 1),
(47, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/New_York', '(GMT-05:00) Eastern Time', '-5.0', '-4.0', '-5.0', 1),
(48, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Panama', '(GMT-05:00) Panama', '-5.0', '-5.0', '-5.0', 0),
(49, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Port-au-Prince', '(GMT-05:00) Port-au-Prince', '-5.0', '-5.0', '-5.0', 0),
(50, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Toronto', '(GMT-05:00) Eastern Time - Toronto', '-5.0', '-4.0', '-5.0', 1),
(51, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Caracas', '(GMT-04:30) Caracas', '-4.5', '-4.5', '-4.5', 0),
(52, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Anguilla', '(GMT-04:00) Anguilla', '-4.0', '-4.0', '-4.0', 0),
(53, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Antigua', '(GMT-04:00) Antigua', '-4.0', '-4.0', '-4.0', 0),
(54, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Aruba', '(GMT-04:00) Aruba', '-4.0', '-4.0', '-4.0', 0),
(55, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Asuncion', '(GMT-04:00) Asuncion', '-3.0', '-4.0', '-4.0', 1),
(56, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Barbados', '(GMT-04:00) Barbados', '-4.0', '-4.0', '-4.0', 0),
(57, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Boa_Vista', '(GMT-04:00) Boa Vista', '-4.0', '-4.0', '-4.0', 0),
(58, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Campo_Grande', '(GMT-04:00) Campo Grande', '-3.0', '-4.0', '-4.0', 0),
(59, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Cuiaba', '(GMT-04:00) Cuiaba', '-3.0', '-4.0', '-4.0', 1),
(60, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Curacao', '(GMT-04:00) Curacao', '-4.0', '-4.0', '-4.0', 0),
(61, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Dominica', '(GMT-04:00) Dominica', '-4.0', '-4.0', '-4.0', 0),
(62, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Grenada', '(GMT-04:00) Grenada', '-4.0', '-4.0', '-4.0', 0),
(63, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Guadeloupe', '(GMT-04:00) Guadeloupe', '-4.0', '0.0', '-4.0', 1),
(64, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Guyana', '(GMT-04:00) Guyana', '-4.0', '-4.0', '-4.0', 0),
(65, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Halifax', '(GMT-04:00) Atlantic Time - Halifax', '0.0', '1.0', '0.0', 1),
(66, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/La_Paz', '(GMT-04:00) La Paz', '-4.0', '-4.0', '-4.0', 0),
(67, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Manaus', '(GMT-04:00) Manaus', '-4.0', '-4.0', '-4.0', 0),
(68, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Martinique', '(GMT-04:00) Martinique', '-4.0', '-4.0', '-4.0', 0),
(69, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Montserrat', '(GMT-04:00) Montserrat', '-4.0', '-4.0', '-4.0', 0),
(70, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Port_of_Spain', '(GMT-04:00) Port of Spain', '-4.0', '-4.0', '-4.0', 0),
(71, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Porto_Velho', '(GMT-04:00) Porto Velho', '-4.0', '-4.0', '-4.0', 0),
(72, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Puerto_Rico', '(GMT-04:00) Puerto Rico', '-4.0', '-4.0', '-4.0', 0),
(73, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Rio_Branco', '(GMT-04:00) Rio Branco', '', '', '', 0),
(74, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Santiago', '(GMT-04:00) Santiago', '-3.0', '-4.0', '-4.0', 1),
(75, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/Santo_Domingo', '(GMT-04:00) Santo Domingo', '-4.0', '-4.0', '-4.0', 0),
(76, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/St_Kitts', '(GMT-04:00) St. Kitts', '-4.0', '-4.0', '-4.0', 0),
(77, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/St_Lucia', '(GMT-04:00) St. Lucia', '-4.0', '-4.0', '-4.0', 0),
(78, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/St_Thomas', '(GMT-04:00) St. Thomas', '-4.0', '-4.0', '-4.0', 0),
(79, '2010-05-10 20:13:10', '2010-05-10 20:13:10', 'America/St_Vincent', '(GMT-04:00) St. Vincent', '-4.0', '-4.0', '-4.0', 0),
(80, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Thule', '(GMT-04:00) Thule', '11.0', '10.0', '10.0', 1),
(81, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Tortola', '(GMT-04:00) Tortola', '-4.0', '-4.0', '-4.0', 0),
(82, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Antarctica/Palmer', '(GMT-04:00) Palmer', '1.0', '2.0', '1.0', 1),
(83, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Atlantic/Bermuda', '(GMT-04:00) Bermuda', '-4.0', '-3.0', '-4.0', 1),
(84, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Atlantic/Stanley', '(GMT-04:00) Stanley', '11.0', '10.0', '10.0', 1),
(85, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/St_Johns', '(GMT-03:30) Newfoundland Time - St. Johns', '-3.5', '-2.5', '-3.5', 1),
(86, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Araguaina', '(GMT-03:00) Araguaina', '-3.0', '-3.0', '-3.0', 0),
(87, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Argentina/Buenos_Aires', '(GMT-03:00) Buenos Aires', '-3.0', '-3.0', '-3.0', 0),
(88, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Bahia', '(GMT-03:00) Salvador', '-3.0', '-3.0', '-3.0', 0),
(89, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Belem', '(GMT-03:00) Belem', '-3.0', '-3.0', '-3.0', 0),
(90, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Cayenne', '(GMT-03:00) Cayenne', '-3.0', '-3.0', '-3.0', 0),
(91, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Fortaleza', '(GMT-03:00) Fortaleza', '-3.0', '-3.0', '-3.0', 0),
(92, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Godthab', '(GMT-03:00) Godthab', '-3.0', '-2.0', '-3.0', 1),
(93, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Maceio', '(GMT-03:00) Maceio', '-3.0', '-3.0', '-3.0', 0),
(94, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Miquelon', '(GMT-03:00) Miquelon', '-3.0', '-2.0', '-3.0', 1),
(95, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Montevideo', '(GMT-03:00) Montevideo', '-2.0', '-3.0', '-3.0', 1),
(96, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Paramaribo', '(GMT-03:00) Paramaribo', '-3.0', '-3.0', '-3.0', 0),
(97, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Recife', '(GMT-03:00) Recife', '-3.0', '-3.0', '-3.0', 0),
(98, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Sao_Paulo', '(GMT-03:00) Sao Paulo', '-2.0', '-3.0', '-3.0', 0),
(99, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Antarctica/Rothera', '(GMT-03:00) Rothera', '-3.0', '-3.0', '-3.0', 0),
(100, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Noronha', '(GMT-02:00) Noronha', '-2.0', '-3.0', '-3.0', 1),
(101, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Atlantic/South_Georgia', '(GMT-02:00) South Georgia', '-2.0', '-2.0', '-2.0', 0),
(102, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Scoresbysund', '(GMT-01:00) Scoresbysund', '-1.0', '0.0', '-1.0', 1),
(103, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Atlantic/Azores', '(GMT-01:00) Azores', '-1.0', '0.0', '-1.0', 1),
(104, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Atlantic/Cape_Verde', '(GMT-01:00) Cape Verde', '-1.0', '-0.0', '-1.0', 0),
(105, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Abidjan', '(GMT+00:00) Abidjan', '0.0', '0.0', '0.0', 0),
(106, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Accra', '(GMT+00:00) Accra', '0.0', '0.0', '0.0', 0),
(107, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Bamako', '(GMT+00:00) Bamako', '0.0', '0.0', '0.0', 0),
(108, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Banjul', '(GMT+00:00) Banjul', '0.0', '0.0', '0.0', 0),
(109, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Bissau', '(GMT+00:00) Bissau', '0.0', '0.0', '0.0', 0),
(110, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Casablanca', '(GMT+00:00) Casablanca', '0.0', '0.0', '0.0', 0),
(111, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Conakry', '(GMT+00:00) Conakry', '0.0', '0.0', '0.0', 0),
(112, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Dakar', '(GMT+00:00) Dakar', '0.0', '0.0', '0.0', 0),
(113, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/El_Aaiun', '(GMT+00:00) El Aaiun', '0.0', '0.0', '0.0', 0),
(114, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Freetown', '(GMT+00:00) Freetown', '0.0', '0.0', '0.0', 0),
(115, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Lome', '(GMT+00:00) Lome', '0.0', '0.0', '0.0', 0),
(116, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Monrovia', '(GMT+00:00) Monrovia', '0.0', '0.0', '0.0', 0),
(117, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Nouakchott', '(GMT+00:00) Nouakchott', '0.0', '0.0', '0.0', 0),
(118, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Ouagadougou', '(GMT+00:00) Ouagadougou', '0.0', '0.0', '0.0', 0),
(119, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Sao_Tome', '(GMT+00:00) Sao Tome', '0.0', '0.0', '0.0', 0),
(120, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'America/Danmarkshavn', '(GMT+00:00) Danmarkshavn', '0.0', '0.0', '0.0', 0),
(121, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Atlantic/Canary', '(GMT+00:00) Canary Islands', '', '', '', 0),
(122, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Atlantic/Faroe', '(GMT+00:00) Faeroe', '1.0', '2.0', '1.0', 1),
(123, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Atlantic/Reykjavik', '(GMT+00:00) Reykjavik', '0.0', '0.0', '0.0', 0),
(124, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Atlantic/St_Helena', '(GMT+00:00) St Helena', '-1.0', '0.0', '-1.0', 0),
(125, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Etc/GMT', '(GMT+00:00) GMT (no daylight saving)', '0.0', '0.0', '0.0', 0),
(126, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Dublin', '(GMT+00:00) Dublin', '0.0', '1.0', '0.0', 1),
(127, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Lisbon', '(GMT+00:00) Lisbon', '0.0', '1.0', '0.0', 1),
(128, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/London', '(GMT+00:00) London', '0.0', '1.0', '0.0', 1),
(129, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Algiers', '(GMT+01:00) Algiers', '1.0', '1.0', '1.0', 0),
(130, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Bangui', '(GMT+01:00) Bangui', '1.0', '1.0', '1.0', 0),
(131, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Brazzaville', '(GMT+01:00) Brazzaville', '1.0', '1.0', '1.0', 0),
(132, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Ceuta', '(GMT+01:00) Ceuta', '1.0', '2.0', '1.0', 1),
(133, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Douala', '(GMT+01:00) Douala', '1.0', '1.0', '1.0', 0),
(134, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Kinshasa', '(GMT+01:00) Kinshasa', '1.0', '1.0', '1.0', 0),
(135, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Lagos', '(GMT+01:00) Lagos', '1.0', '1.0', '1.0', 0),
(136, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Libreville', '(GMT+01:00) Libreville', '1.0', '1.0', '1.0', 0),
(137, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Luanda', '(GMT+01:00) Luanda', '1.0', '1.0', '1.0', 0),
(138, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Malabo', '(GMT+01:00) Malabo', '1.0', '1.0', '1.0', 0),
(139, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Ndjamena', '(GMT+01:00) Ndjamena', '1.0', '1.0', '1.0', 0),
(140, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Niamey', '(GMT+01:00) Niamey', '1.0', '1.0', '1.0', 0),
(141, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Porto-Novo', '(GMT+01:00) Porto-Novo', '1.0', '1.0', '1.0', 0),
(142, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Tunis', '(GMT+01:00) Tunis', '1.0', '2.0', '1.0', 1),
(143, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Windhoek', '(GMT+01:00) Windhoek', '2.0', '1.0', '1.0', 1),
(144, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Amsterdam', '(GMT+01:00) Amsterdam', '1.0', '2.0', '1.0', 1),
(145, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Andorra', '(GMT+01:00) Andorra', '1.0', '2.0', '1.0', 1),
(146, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Belgrade', '(GMT+01:00) Central European Time (Europe/Belgrade)', '1.0', '2.0', '1.0', 1),
(147, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Berlin', '(GMT+01:00) Berlin', '1.0', '2.0', '1.0', 1),
(148, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Brussels', '(GMT+01:00) Brussels', '1.0', '2.0', '1.0', 1),
(149, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Budapest', '(GMT+01:00) Budapest', '1.0', '2.0', '1.0', 1),
(150, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Copenhagen', '(GMT+01:00) Copenhagen', '1.0', '2.0', '1.0', 1),
(151, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Gibraltar', '(GMT+01:00) Gibraltar', '1.0', '2.0', '1.0', 1),
(152, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Luxembourg', '(GMT+01:00) Luxembourg', '1.0', '2.0', '1.0', 1),
(153, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Madrid', '(GMT+01:00) Madrid', '1.0', '2.0', '1.0', 1),
(154, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Malta', '(GMT+01:00) Malta', '1.0', '2.0', '1.0', 1),
(155, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Monaco', '(GMT+01:00) Monaco', '1.0', '2.0', '1.0', 1),
(156, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Oslo', '(GMT+01:00) Oslo', '1.0', '2.0', '1.0', 1),
(157, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Paris', '(GMT+01:00) Paris', '1.0', '2.0', '1.0', 1),
(158, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Prague', '(GMT+01:00) Central European Time (Europe/Prague)', '1.0', '2.0', '1.0', 1),
(159, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Rome', '(GMT+01:00) Rome', '1.0', '2.0', '1.0', 1),
(160, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Stockholm', '(GMT+01:00) Stockholm', '1.0', '2.0', '1.0', 1),
(161, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Tirane', '(GMT+01:00) Tirane', '1.0', '2.0', '1.0', 1),
(162, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Vaduz', '(GMT+01:00) Vaduz', '1.0', '2.0', '1.0', 1),
(163, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Vienna', '(GMT+01:00) Vienna', '1.0', '2.0', '1.0', 1),
(164, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Warsaw', '(GMT+01:00) Warsaw', '1.0', '2.0', '1.0', 1),
(165, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Zurich', '(GMT+01:00) Zurich', '1.0', '2.0', '1.0', 1),
(166, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Blantyre', '(GMT+02:00) Blantyre', '2.0', '2.0', '2.0', 0),
(167, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Bujumbura', '(GMT+02:00) Bujumbura', '2.0', '2.0', '2.0', 0),
(168, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Cairo', '(GMT+02:00) Cairo', '2.0', '3.0', '2.0', 1),
(169, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Gaborone', '(GMT+02:00) Gaborone', '2.0', '2.0', '2.0', 0),
(170, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Harare', '(GMT+02:00) Harare', '2.0', '2.0', '2.0', 0),
(171, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Johannesburg', '(GMT+02:00) Johannesburg', '2.0', '2.0', '2.0', 0),
(172, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Kigali', '(GMT+02:00) Kigali', '2.0', '2.0', '2.0', 0),
(173, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Lubumbashi', '(GMT+02:00) Lubumbashi', '2.0', '2.0', '2.0', 0),
(174, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Lusaka', '(GMT+02:00) Lusaka', '2.0', '2.0', '2.0', 0),
(175, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Maputo', '(GMT+02:00) Maputo', '2.0', '2.0', '2.0', 0),
(176, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Maseru', '(GMT+02:00) Maseru', '2.0', '2.0', '2.0', 0),
(177, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Mbabane', '(GMT+02:00) Mbabane', '2.0', '2.0', '2.0', 0),
(178, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Tripoli', '(GMT+02:00) Tripoli', '2.0', '2.0', '2.0', 0),
(179, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Asia/Amman', '(GMT+02:00) Amman', '2.0', '3.0', '2.0', 1),
(180, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Asia/Beirut', '(GMT+02:00) Beirut', '2.0', '3.0', '2.0', 1),
(181, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Asia/Damascus', '(GMT+02:00) Damascus', '2.0', '3.0', '2.0', 1),
(182, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Asia/Gaza', '(GMT+02:00) Gaza', '2.0', '3.0', '2.0', 1),
(183, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Asia/Jerusalem', '(GMT+02:00) Jerusalem', '2.0', '3.0', '2.0', 1),
(184, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Asia/Nicosia', '(GMT+02:00) Nicosia', '2.0', '3.0', '2.0', 1),
(185, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Athens', '(GMT+02:00) Athens', '2.0', '3.0', '2.0', 1),
(186, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Bucharest', '(GMT+02:00) Bucharest', '2.0', '3.0', '2.0', 1),
(187, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Chisinau', '(GMT+02:00) Chisinau', '2.0', '3.0', '2.0', 1),
(188, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Helsinki', '(GMT+02:00) Helsinki', '2.0', '3.0', '2.0', 1),
(189, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Istanbul', '(GMT+02:00) Istanbul', '2.0', '3.0', '2.0', 1),
(190, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Kaliningrad', '(GMT+02:00) Moscow-01 - Kaliningrad', '2.0', '3.0', '2.0', 1),
(191, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Kiev', '(GMT+02:00) Kiev', '2.0', '3.0', '2.0', 1),
(192, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Minsk', '(GMT+02:00) Minsk', '2.0', '3.0', '2.0', 1),
(193, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Riga', '(GMT+02:00) Riga', '2.0', '3.0', '2.0', 1),
(194, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Sofia', '(GMT+02:00) Sofia', '2.0', '3.0', '2.0', 1),
(195, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Tallinn', '(GMT+02:00) Tallinn', '2.0', '3.0', '2.0', 1),
(196, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Vilnius', '(GMT+02:00) Vilnius', '2.0', '3.0', '2.0', 1),
(197, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Addis_Ababa', '(GMT+03:00) Addis Ababa', '3.0', '3.0', '3.0', 0),
(198, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Asmara', '(GMT+03:00) Asmera', '3.0', '3.0', '3.0', 0),
(199, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Dar_es_Salaam', '(GMT+03:00) Dar es Salaam', '3.0', '3.0', '3.0', 0),
(200, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Djibouti', '(GMT+03:00) Djibouti', '3.0', '3.0', '3.0', 0),
(201, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Kampala', '(GMT+03:00) Kampala', '3.0', '3.0', '3.0', 0),
(202, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Khartoum', '(GMT+03:00) Khartoum', '3.0', '3.0', '3.0', 0),
(203, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Mogadishu', '(GMT+03:00) Mogadishu', '3.0', '3.0', '3.0', 0),
(204, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Africa/Nairobi', '(GMT+03:00) Nairobi', '3.0', '3.0', '3.0', 0),
(205, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Antarctica/Syowa', '(GMT+03:00) Syowa', '9.0', '9.0', '9.0', 0),
(206, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Asia/Aden', '(GMT+03:00) Aden', '2.0', '3.0', '2.0', 1),
(207, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Asia/Baghdad', '(GMT+03:00) Baghdad', '3.0', '3.0', '3.0', 0),
(208, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Asia/Bahrain', '(GMT+03:00) Bahrain', '3.0', '3.0', '3.0', 0),
(209, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Asia/Kuwait', '(GMT+03:00) Kuwait', '3.0', '3.0', '3.0', 0),
(210, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Asia/Qatar', '(GMT+03:00) Qatar', '3.0', '3.0', '3.0', 0),
(211, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Asia/Riyadh', '(GMT+03:00) Riyadh', '3.0', '3.0', '3.0', 0),
(212, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Europe/Moscow', '(GMT+03:00) Moscow+00', '3.0', '4.0', '3.0', 1),
(213, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Indian/Antananarivo', '(GMT+03:00) Antananarivo', '3.0', '3.0', '3.0', 0),
(214, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Indian/Comoro', '(GMT+03:00) Comoro', '3.0', '3.0', '3.0', 0),
(215, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Indian/Mayotte', '(GMT+03:00) Mayotte', '3.0', '3.0', '3.0', 0),
(216, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Asia/Tehran', '(GMT+03:30) Tehran', '3.5', '4.5', '3.5', 1),
(217, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Asia/Baku', '(GMT+04:00) Baku', '4.0', '5.0', '4.0', 1),
(218, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Asia/Dubai', '(GMT+04:00) Dubai', '4.0', '4.0', '4.0', 0),
(219, '2010-05-10 20:13:11', '2010-05-10 20:13:11', 'Asia/Muscat', '(GMT+04:00) Muscat', '4.0', '4.0', '4.0', 0),
(220, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Tbilisi', '(GMT+04:00) Tbilisi', '4.0', '4.0', '4.0', 0),
(221, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Yerevan', '(GMT+04:00) Yerevan', '4.0', '5.0', '4.0', 1),
(222, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Europe/Samara', '(GMT+04:00) Moscow+01 - Samara', '4.0', '5.0', '4.0', 1),
(223, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Indian/Mahe', '(GMT+04:00) Mahe', '4.0', '4.0', '4.0', 0),
(224, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Indian/Mauritius', '(GMT+04:00) Mauritius', '4.0', '4.0', '4.0', 0),
(225, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Indian/Reunion', '(GMT+04:00) Reunion', '4.0', '4.0', '4.0', 0),
(226, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Kabul', '(GMT+04:30) Kabul', '4.5', '4.5', '4.5', 0),
(227, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Aqtau', '(GMT+05:00) Aqtau', '5.0', '5.0', '5.0', 0),
(228, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Aqtobe', '(GMT+05:00) Aqtobe', '5.0', '5.0', '5.0', 0),
(229, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Ashgabat', '(GMT+05:00) Ashgabat', '5.0', '5.0', '5.0', 0),
(230, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Dushanbe', '(GMT+05:00) Dushanbe', '5.0', '5.0', '5.0', 0),
(231, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Karachi', '(GMT+05:00) Karachi', '5.0', '6.0', '5.0', 1),
(232, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Tashkent', '(GMT+05:00) Tashkent', '5.0', '5.0', '5.0', 0),
(233, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Yekaterinburg', '(GMT+05:00) Moscow+02 - Yekaterinburg', '5.0', '6.0', '5.0', 1),
(234, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Indian/Kerguelen', '(GMT+05:00) Kerguelen', '5.0', '5.0', '5.0', 0),
(235, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Indian/Maldives', '(GMT+05:00) Maldives', '5.0', '5.0', '5.0', 0),
(236, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Calcutta', '(GMT+05:30) India Standard Time', '5.5', '5.5', '5.5', 0),
(237, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Colombo', '(GMT+05:30) Colombo', '5.5', '5.5', '5.5', 0),
(238, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Katmandu', '(GMT+05:45) Katmandu', '5.75', '5.75', '5.75', 0),
(239, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Antarctica/Mawson', '(GMT+06:00) Mawson', '6.0', '6.0', '6.0', 0),
(240, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Antarctica/Vostok', '(GMT+06:00) Vostok', '6.0', '6.0', '6.0', 0),
(241, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Almaty', '(GMT+06:00) Almaty', '6.0', '6.0', '6.0', 0),
(242, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Bishkek', '(GMT+06:00) Bishkek', '6.0', '6.0', '6.0', 0),
(243, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Dhaka', '(GMT+06:00) Dhaka', '6.0', '7.0', '6.0', 1),
(244, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Omsk', '(GMT+06:00) Moscow+03 - Omsk, Novosibirsk', '6.0', '7.0', '6.0', 1),
(245, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Thimphu', '(GMT+06:00) Thimphu', '6.0', '6.0', '6.0', 0),
(246, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Indian/Chagos', '(GMT+06:00) Chagos', '6.0', '6.0', '6.0', 0),
(247, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Rangoon', '(GMT+06:30) Rangoon', '6.5', '6.5', '6.5', 0),
(248, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Indian/Cocos', '(GMT+06:30) Cocos', '6.5', '6.5', '6.5', 0),
(249, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Antarctica/Davis', '(GMT+07:00) Davis', '-8.0', '-7.0', '-8.0', 1),
(250, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Bangkok', '(GMT+07:00) Bangkok', '7.0', '7.0', '7.0', 0),
(251, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Hovd', '(GMT+07:00) Hovd', '7.0', '7.0', '7.0', 0),
(252, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Jakarta', '(GMT+07:00) Jakarta', '7.0', '7.0', '7.0', 0),
(253, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Krasnoyarsk', '(GMT+07:00) Moscow+04 - Krasnoyarsk', '7.0', '8.0', '7.0', 1),
(254, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Phnom_Penh', '(GMT+07:00) Phnom Penh', '7.0', '7.0', '7.0', 0),
(255, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Saigon', '(GMT+07:00) Hanoi', '7.0', '7.0', '7.0', 0),
(256, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Vientiane', '(GMT+07:00) Vientiane', '7.0', '7.0', '7.0', 0),
(257, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Indian/Christmas', '(GMT+07:00) Christmas', '-7.0', '-7.0', '-7.0', 0),
(258, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Antarctica/Casey', '(GMT+08:00) Casey', '8.0', '8.0', '8.0', 0),
(259, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Brunei', '(GMT+08:00) Brunei', '8.0', '8.0', '8.0', 0),
(260, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Choibalsan', '(GMT+08:00) Choibalsan', '8.0', '8.0', '8.0', 0),
(261, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Hong_Kong', '(GMT+08:00) Hong Kong', '8.0', '8.0', '8.0', 0),
(262, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Irkutsk', '(GMT+08:00) Moscow+05 - Irkutsk', '8.0', '9.0', '8.0', 1),
(263, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Kuala_Lumpur', '(GMT+08:00) Kuala Lumpur', '8.0', '8.0', '8.0', 0),
(264, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Macau', '(GMT+08:00) Macau', '8.0', '8.0', '8.0', 0),
(265, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Makassar', '(GMT+08:00) Makassar', '8.0', '8.0', '8.0', 0),
(266, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Manila', '(GMT+08:00) Manila', '8.0', '8.0', '8.0', 0),
(267, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Shanghai', '(GMT+08:00) China Time - Beijing', '8.0', '8.0', '8.0', 0),
(268, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Singapore', '(GMT+08:00) Singapore', '8.0', '8.0', '8.0', 0),
(269, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Taipei', '(GMT+08:00) Taipei', '8.0', '8.0', '8.0', 0),
(270, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Ulaanbaatar', '(GMT+08:00) Ulaanbaatar', '8.0', '8.0', '8.0', 0),
(271, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Australia/Perth', '(GMT+08:00) Western Time - Perth', '8.0', '8.0', '8.0', 0),
(272, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Dili', '(GMT+09:00) Dili', '8.0', '8.0', '8.0', 0),
(273, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Jayapura', '(GMT+09:00) Jayapura', '9.0', '9.0', '9.0', 0),
(274, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Pyongyang', '(GMT+09:00) Pyongyang', '9.0', '9.0', '9.0', 0),
(275, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Seoul', '(GMT+09:00) Seoul', '9.0', '9.0', '9.0', 0),
(276, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Tokyo', '(GMT+09:00) Tokyo', '9.0', '9.0', '9.0', 0),
(277, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Yakutsk', '(GMT+09:00) Moscow+06 - Yakutsk', '9.0', '10.0', '9.0', 1),
(278, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Palau', '(GMT+09:00) Palau', '9.0', '9.0', '9.0', 0),
(279, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Australia/Adelaide', '(GMT+09:30) Central Time - Adelaide', '10.5', '9.5', '9.5', 1),
(280, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Australia/Darwin', '(GMT+09:30) Central Time - Darwin', '9.5', '9.5', '9.5', 0),
(281, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Antarctica/DumontDUrville', '(GMT+10:00) Dumont D''Urville', '10.0', '10.0', '10.0', 0),
(282, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Vladivostok', '(GMT+10:00) Moscow+07 - Yuzhno-Sakhalinsk', '10.0', '11.0', '10.0', 1),
(283, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Australia/Brisbane', '(GMT+10:00) Eastern Time - Brisbane', '10.0', '10.0', '10.0', 0),
(284, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Australia/Hobart', '(GMT+10:00) Eastern Time - Hobart', '-6.0', '-5.0', '-6.0', 1),
(285, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Australia/Sydney', '(GMT+10:00) Eastern Time - Melbourne, Sydney', '11.0', '10.0', '10.0', 1),
(286, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Guam', '(GMT+10:00) Guam', '10.0', '10.0', '10.0', 0),
(287, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Port_Moresby', '(GMT+10:00) Port Moresby', '10.0', '10.0', '10.0', 0),
(288, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Saipan', '(GMT+10:00) Saipan', '10.0', '10.0', '10.0', 0),
(289, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Truk', '(GMT+10:00) Truk', '10.0', '10.0', '10.0', 0),
(290, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Magadan', '(GMT+11:00) Moscow+08 - Magadan', '11.0', '12.0', '11.0', 1),
(291, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Efate', '(GMT+11:00) Efate', '11.0', '11.0', '11.0', 0),
(292, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Guadalcanal', '(GMT+11:00) Guadalcanal', '11.0', '11.0', '11.0', 0),
(293, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Kosrae', '(GMT+11:00) Kosrae', '11.0', '11.0', '11.0', 0),
(294, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Noumea', '(GMT+11:00) Noumea', '11.0', '11.0', '11.0', 0),
(295, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Ponape', '(GMT+11:00) Ponape', '11.0', '11.0', '11.0', 0),
(296, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Norfolk', '(GMT+11:30) Norfolk', '11.5', '11.5', '11.5', 0),
(297, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Asia/Kamchatka', '(GMT+12:00) Moscow+09 - Petropavlovsk-Kamchatskiy', '12.0', '13.0', '12.0', 1),
(298, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Auckland', '(GMT+12:00) Auckland', '13.0', '12.0', '12.0', 1),
(299, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Fiji', '(GMT+12:00) Fiji', '12.0', '12.0', '12.0', 0),
(300, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Funafuti', '(GMT+12:00) Funafuti', '12.0', '12.0', '12.0', 0),
(301, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Kwajalein', '(GMT+12:00) Kwajalein', '12.0', '12.0', '12.0', 0),
(302, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Majuro', '(GMT+12:00) Majuro', '12.0', '12.0', '12.0', 0),
(303, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Nauru', '(GMT+12:00) Nauru', '12.0', '12.0', '12.0', 0),
(304, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Tarawa', '(GMT+12:00) Tarawa', '12.0', '12.0', '12.0', 0),
(305, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Wake', '(GMT+12:00) Wake', '12.0', '12.0', '12.0', 0),
(306, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Wallis', '(GMT+12:00) Wallis', '12.0', '12.0', '12.0', 0),
(307, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Enderbury', '(GMT+13:00) Enderbury', '13.0', '13.0', '13.0', 0),
(308, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Tongatapu', '(GMT+13:00) Tongatapu', '13.0', '13.0', '13.0', 0),
(309, '2010-05-10 20:13:12', '2010-05-10 20:13:12', 'Pacific/Kiritimati', '(GMT+14:00) Kiritimati', '14.0', '14.0', '14.0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `foreign_id` bigint(20) NOT NULL,
  `class` varchar(25) collate utf8_unicode_ci NOT NULL,
  `transaction_type_id` bigint(20) default NULL,
  `amount` double(10,2) NOT NULL,
  `description` text collate utf8_unicode_ci,
  `payment_gateway_id` bigint(20) default NULL,
  `gateway_fees` double(10,2) NOT NULL,
  `currency_id` bigint(20) default NULL,
  `converted_currency_id` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `transaction_type_id` (`transaction_type_id`),
  KEY `payment_gateway_id` (`payment_gateway_id`),
  KEY `foreign_id` (`foreign_id`),
  KEY `class` (`class`),
  KEY `currency_id` (`currency_id`),
  KEY `converted_currency_id` (`converted_currency_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `created`, `modified`, `user_id`, `foreign_id`, `class`, `transaction_type_id`, `amount`, `description`, `payment_gateway_id`, `gateway_fees`, `currency_id`, `converted_currency_id`) VALUES
(1, '2011-11-22 12:53:26', '2011-11-22 12:53:26', 7, 1, 'ItemUser', 2, 90.00, NULL, NULL, 0.00, NULL, NULL),
(2, '2011-11-22 12:56:29', '2011-11-22 12:56:29', 3, 2, 'ItemUser', 2, 91.00, NULL, NULL, 0.00, NULL, NULL),
(3, '2011-11-22 12:56:30', '2011-11-22 12:56:30', 3, 1, 'SecondUser', 6, 5.00, NULL, NULL, 0.00, NULL, NULL),
(4, '2011-11-22 12:56:30', '2011-11-22 12:56:30', 3, 1, 'SecondUser', 6, 5.00, NULL, NULL, 0.00, NULL, NULL),
(5, '2011-11-22 12:56:30', '2011-11-22 12:56:30', 1, 3, 'SecondUser', 11, 5.00, NULL, NULL, 0.00, NULL, NULL),
(6, '2011-11-22 13:01:42', '2011-11-22 13:01:42', 2, 3, 'ItemUser', 2, 92.00, NULL, NULL, 0.00, NULL, NULL),
(7, '2011-11-22 13:01:45', '2011-11-22 13:01:45', 3, 1, 'SecondUser', 6, 5.00, NULL, NULL, 0.00, NULL, NULL),
(8, '2011-11-22 13:01:45', '2011-11-22 13:01:45', 2, 1, 'SecondUser', 6, 5.00, NULL, NULL, 0.00, NULL, NULL),
(9, '2011-11-22 13:01:45', '2011-11-22 13:01:45', 1, 2, 'SecondUser', 11, 5.00, NULL, NULL, 0.00, NULL, NULL),
(10, '2011-11-22 13:30:57', '2011-11-22 13:30:57', 2, 4, 'ItemUser', 2, 60.00, NULL, NULL, 0.00, NULL, NULL),
(11, '2011-11-22 13:32:08', '2011-11-22 13:32:08', 6, 5, 'ItemUser', 2, 61.00, NULL, NULL, 0.00, NULL, NULL),
(12, '2011-11-22 13:32:47', '2011-11-22 13:32:47', 6, 6, 'ItemUser', 2, 120.00, NULL, NULL, 0.00, NULL, NULL),
(13, '2011-11-22 13:35:18', '2011-11-22 13:35:18', 3, 7, 'ItemUser', 2, 120.00, NULL, NULL, 0.00, NULL, NULL),
(14, '2012-02-21 09:06:56', '2012-02-21 09:06:56', 2, 8, 'ItemUser', 2, 250.00, NULL, NULL, 0.00, NULL, NULL),
(15, '2012-02-21 09:19:49', '2012-02-21 09:19:49', 2, 9, 'ItemUser', 2, 520.00, NULL, NULL, 0.00, NULL, NULL),
(16, '2012-02-21 09:26:00', '2012-02-21 09:26:00', 2, 1, 'SecondUser', 25, 10000.00, '', NULL, 0.00, NULL, NULL),
(17, '2012-02-21 09:53:51', '2012-02-21 09:53:51', 2, 10, 'ItemUser', 2, 50.00, NULL, NULL, 0.00, NULL, NULL),
(18, '2012-02-21 11:16:39', '2012-02-21 11:16:39', 8, 1, 'SecondUser', 25, 5000.00, '', NULL, 0.00, NULL, NULL),
(19, '2012-02-21 11:17:25', '2012-02-21 11:17:25', 8, 11, 'ItemUser', 2, 150.00, NULL, NULL, 0.00, NULL, NULL),
(20, '2012-02-21 11:17:28', '2012-02-21 11:17:28', 2, 1, 'SecondUser', 6, 5.00, NULL, NULL, 0.00, NULL, NULL),
(21, '2012-02-21 11:17:28', '2012-02-21 11:17:28', 8, 1, 'SecondUser', 6, 5.00, NULL, NULL, 0.00, NULL, NULL),
(22, '2012-02-21 11:17:28', '2012-02-21 11:17:28', 1, 8, 'SecondUser', 11, 5.00, NULL, NULL, 0.00, NULL, NULL),
(23, '2012-02-21 11:26:03', '2012-02-21 11:26:03', 9, 1, 'SecondUser', 25, 2000.00, '', NULL, 0.00, NULL, NULL),
(24, '2012-02-21 11:27:12', '2012-02-21 11:27:12', 9, 12, 'ItemUser', 2, 150.00, NULL, NULL, 0.00, NULL, NULL),
(25, '2012-02-21 11:36:47', '2012-02-21 11:36:47', 2, 13, 'ItemUser', 2, 150.00, NULL, NULL, 0.00, NULL, NULL),
(26, '2012-02-21 11:44:17', '2012-02-21 11:44:17', 10, 1, 'SecondUser', 25, 1000.00, '', NULL, 0.00, NULL, NULL),
(27, '2012-02-21 11:44:28', '2012-02-21 11:44:28', 10, 14, 'ItemUser', 2, 150.00, NULL, NULL, 0.00, NULL, NULL),
(28, '2012-02-21 11:47:31', '2012-02-21 11:47:31', 10, 15, 'ItemUser', 2, 150.00, NULL, NULL, 0.00, NULL, NULL),
(29, '2012-02-21 11:48:25', '2012-02-21 11:48:25', 10, 16, 'ItemUser', 2, 150.00, NULL, NULL, 0.00, NULL, NULL),
(30, '2012-02-21 11:49:08', '2012-02-21 11:49:08', 2, 1, 'SecondUser', 48, 150.00, NULL, NULL, 0.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_types`
--

DROP TABLE IF EXISTS `transaction_types`;
CREATE TABLE IF NOT EXISTS `transaction_types` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `message` varchar(255) collate utf8_unicode_ci NOT NULL,
  `message_for_admin` varchar(255) collate utf8_unicode_ci NOT NULL,
  `is_credit` tinyint(1) default '0',
  `transaction_variables` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transaction_types`
--

INSERT INTO `transaction_types` (`id`, `created`, `modified`, `name`, `message`, `message_for_admin`, `is_credit`, `transaction_variables`) VALUES
(1, '2010-03-04 10:17:05', '2010-08-15 08:10:06', 'Amount added to wallet ', 'Amount added to wallet ', '##USER_LINK## added amount to his wallet.', 1, ''),
(2, '2010-03-04 10:17:14', '2010-08-15 19:47:46', 'Bought new item', 'Bought new item ##ITEM_LINK##', '##USER_LINK## bought a new item ##ITEM_LINK## ##GATEWAY##', 0, 'ITEM_LINK'),
(3, '2010-03-04 10:17:05', '2010-03-04 10:17:08', 'Item has been gifted to friend', 'Item has been gifted to friend ##FRIEND_LINK##', '##USER_LINK## bought a new item ##ITEM_LINK## and gifted to ##FRIEND_LINK##', 0, 'FRIEND_LINK'),
(6, '2010-03-04 10:19:34', '2010-03-04 10:19:37', 'Referral amount received', 'Referral amount received', 'Referral amount received by ##USER_LINK##', 1, ''),
(7, '2010-03-04 10:20:11', '2010-03-04 10:20:14', 'Paid amount for item to merchant', 'Paid amount for ##ITEM_NAME## to ##MERCHANT_NAME## ', 'Paid amount to merchant ##MERCHANT_NAME## for item ##ITEM_NAME##', 0, '##ITEM_LINK##, ##MERCHANT_NAME##, ##ITEM_NAME##'),
(8, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Withdrawn amount from wallet', 'Withdraw request has been made by user, ##USER##', '', 0, 'USER'),
(9, '2010-03-11 14:34:12', '2010-07-08 10:34:57', 'Refund for failed item', 'Refund for failed item ##ITEM_LINK##', 'Item ##ITEM_LINK## has been failed. Refunded to ##USER_LINK##', 1, 'ITEM_LINK'),
(10, '2010-03-11 14:34:14', '2010-03-11 14:34:14', 'Gift refund for failed item', 'Refunded for failed gifted item ##ITEM_LINK##', 'Gifted item ##ITEM_LINK## has been failed. Refunded to ##USER_LINK##', 1, 'ITEM_LINK'),
(11, '2010-03-11 14:34:14', '2010-03-11 14:34:14', 'Referral amount paid to user', 'Referral amount paid to user ##USER_LINK##', 'Referral amount paid to user ##USER_LINK##', 0, 'USER_LINK'),
(12, '2010-03-11 14:34:14', '2010-06-07 02:07:46', 'Received amount for item', 'Received amount for item##ITEM_LINK##', 'Merchant ##MERCHANT_NAME## has received amount for the item ##ITEM_NAME##', 1, 'ITEM_LINK'),
(13, '2010-03-11 14:34:14', '2010-03-11 14:34:14', 'Paid cash withdraw request amount to user', 'Withdraw request has been succesfully made and paid to your money transfer account', 'Withdraw request for ##USER_LINK## was succesfully and paid to his money transfer account', 0, 'USER_LINK'),
(14, '2010-06-24 13:00:27', '2010-07-07 13:23:57', 'Deduct amount for offline merchant', 'Amount deducted for ##USER_LINK##', '', 0, ''),
(15, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Canceled the item', 'Canceled the item ##ITEM_LINK##', '##USER_LINK## has canceled the item ##ITEM_LINK##', 1, '##ITEM_LINK##'),
(16, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Canceled the gifted item', 'Canceled the gifted item ##ITEM_LINK##', '##USER_LINK## has canceled the gift item ##ITEM_LINK##', 1, '##ITEM_LINK##'),
(17, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'User cash withdrawal request', 'Cash withdrawal request made', 'Cash withdrawal request made by ##USER_LINK##', 0, '##USER_LINK##'),
(18, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Admin approved withdrawal request', 'You (administrator) have approved the withdrawal request for ##USER_LINK##', 'You (administrator) have approved the withdrawal request for ##USER_LINK##', 0, '##USER_LINK##'),
(19, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Admin rejected withdrawal request', 'Withdrawal request rejected for ##USER_LINK##', 'Withdrawal request rejected for ##USER_LINK##', 0, '##USER_LINK##'),
(20, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Failed withdrawal request', 'Withdrawal request for ##USER_LINK## has been failed', '', 0, '##USER_LINK##'),
(22, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Withdrawal request approved for user by admin', 'Withdrawal request approved', 'Withdrawal request approved for ##USER_LINK## ', 0, '##USER_LINK##'),
(21, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Amount refunded for rejected withdrawal request', 'Adminstrator have rejected the withdrawal request. Your requested amount has been refunded to your wallet', 'Amount refunded to ##USER_LINK## for rejected withdrawal request', 1, '##USER_LINK##'),
(24, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Failed withdrawal request and refunded to user', 'Withdrawal request failed. Your requested amount has been refunded to your wallet.', 'Withdrawal request has been failed. Amount refunded to ##USER_LINK##', 1, '##USER_LINK##'),
(25, '2010-09-17 11:12:37', '2010-09-17 11:12:42', 'Add fund to wallet', 'Administrator added fund to your wallet', 'Added fund to ##USER_LINK## wallet', 1, ''),
(26, '2010-09-17 11:13:20', '2010-09-17 11:13:23', 'Deduct fund from wallet', 'Administrator deducted fund from your wallet', 'Deducted fund from ##USER_LINK## wallet', 0, ''),
(28, '2010-09-17 11:13:20', '2010-09-17 11:13:20', 'Partial wallet amount taken for item purchase', 'Partial wallet amount taken for item ##ITEM_LINK##', '##USER_LINK## bought a new item ##ITEM_LINK## with partial wallet amount', 0, '##ITEM_LINK##'),
(30, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'User affiliate commission withdrawal request', 'Affiliate commission amount withdrawal request made by ##AFFILIATE_USER##', '', 0, 'AFFILIATE_USER'),
(31, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Admin approved affiliate withdrawal request', 'Affiliate withdrawal request has been approved', 'Affiliate withdrawal request approved for ##AFFILIATE_USER##', 0, 'AFFILIATE_USER'),
(32, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Admin rejected affiliate withdrawal request', 'Administrator have rejected the affiliate withdrawal request. Your requested amount has been refunded to your affiliate commission amount', 'You (administrator) have rejected the affiliate withdrawal request for ##AFFILIATE_USER##', 0, 'AFFILIATE_USER'),
(33, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Failed affiliate withdrawal request', 'Affiliate withdrawal request failed. Your requested amount has been refunded to your affiliate commission amount.', 'Affiliate withdrawal request has been failed. Amount refunded to ##AFFILIATE_USER##', 0, 'AFFILIATE_USER'),
(34, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Withdrawal request rejected by admin', 'Administrator have rejected the affiliate withdrawal request. Your requested amount has been refunded to your affiliate commission amount', 'Amount refunded to ##AFFILIATE_USER## for rejected withdrawal request', 0, 'AFFILIATE_USER'),
(35, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Affiliate withdrawal request approved for user by admin', 'Affiliate withdrawal request has been approved', 'Affiliate Withdrawal request approved for ##USER_LINK##', 1, 'AFFILIATE_USER'),
(36, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Failed withdrawal request and refunded to user', 'Withdrawal request failed for user ##AFFILIATE_USER##', '', 1, 'AFFILIATE_USER'),
(37, '2010-03-04 10:17:14', '2010-03-04 10:17:16', 'Withdrawn amount from Affiliate', 'Cash affiliate withdrawal request made', 'Affiliate Withdraw request has been made by user ##AFFILIATE_USER##', 0, 'AFFILIATE_USER'),
(38, '2010-03-04 10:20:11', '2010-03-04 10:20:14', 'Paid cash withdraw request amount to user', 'Cash withdraw request made by user ##AFFILIATE_USER## has been accepted.', '', 0, 'AFFILIATE_USER'),
(40, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Failed charity withdrawal request', 'Charity withdrawal request for ##CHARITY_USER## has been failed', '', 0, 'CHARITY_USER'),
(41, '2010-08-17 14:31:48', '2011-04-08 11:24:25', 'Failed charity withdrawal request and refunded to user', 'Charity Withdrawal request failed for user ##CHARITY_USER##', '', 1, 'CHARITY_USER'),
(42, '2010-03-04 10:20:11', '2010-03-04 10:20:14', 'Paid cash charity withdraw request amount to user', 'Cash withdraw request made by charity user ##CHARITY_USER## has been accepted.', '', 0, 'CHARITY_USER'),
(43, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Admin approved charity withdrawal request', 'Admin approved the ##CHARITY_USER## charity withdrawal request', '', 0, 'CHARITY_USER'),
(44, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Admin rejected withdrawal request', '', 'You (administrator) have rejected the charity withdrawal request for ##CHARITY_USER##', 0, 'CHARITY_USER'),
(48, '2010-03-04 10:17:05', '2010-08-15 08:10:06', 'Referral Amount added to wallet ', 'Referral Amount added to wallet ', '', 1, ''),
(45, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Amount take for charity', 'Amount taken for charity for the item ##ITEM_LINK##', 'Amount taken for charity for the item ##ITEM_LINK##', 0, ''),
(49, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Your affiliate commission amount added to your account', 'Your affiliate commission amount added to your account', 'Affiliate commission amount sent to user ##AFFILIATE_USER##', 1, ''),
(50, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Affiliate commission amount sent to user', 'Affiliate commission amount sent to user ##AFFILIATE_USER##', 'User ##AFFILIATE_USER## has received amount for affiliate', 0, '##AFFILIATE_USER##'),
(51, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Amount take for charity from admin', 'Amount taken for charity from admin for the item ##ITEM_LINK##', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
CREATE TABLE IF NOT EXISTS `translations` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `language_id` bigint(20) NOT NULL,
  `key` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `lang_text` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `is_translated` tinyint(1) NOT NULL,
  `is_google_translate` tinyint(1) NOT NULL,
  `is_verified` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `created`, `modified`, `language_id`, `key`, `lang_text`, `is_translated`, `is_google_translate`, `is_verified`) VALUES
(1, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Unknown Error', 'Unknown Error', 0, 0, 0),
(2, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Sorry. You cannot update or delete in demo mode', 'Sorry. You cannot update or delete in demo mode', 0, 0, 0),
(3, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Maintenance Mode', 'Maintenance Mode', 0, 0, 0),
(4, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'City you have requested is not available in %s.', 'City you have requested is not available in %s.', 0, 0, 0),
(5, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Invalid request', 'Invalid request', 0, 0, 0),
(6, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'You need to Log-In or Sign-Up to do that!', 'You need to Log-In or Sign-Up to do that!', 0, 0, 0),
(7, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Sorry, login failed.  Either your %s or password are incorrect or admin deactivated your account.', 'Sorry, login failed.  Either your %s or password are incorrect or admin deactivated your account.', 0, 0, 0),
(8, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Your API authorization request failed. Please try again', 'Your API authorization request failed. Please try again', 0, 0, 0),
(9, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Unknown Application', 'Unknown Application', 0, 0, 0),
(10, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Invalid App key', 'Invalid App key', 0, 0, 0),
(11, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Sorry, login failed.  Your %s or password are incorrect', 'Sorry, login failed.  Your %s or password are incorrect', 0, 0, 0),
(12, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Checked records has been deleted', 'Checked records has been deleted', 0, 0, 0),
(13, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Show in home page deactivated successfully', 'Show in home page deactivated successfully', 0, 0, 0),
(14, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Show in home page activated successfully', 'Show in home page activated successfully', 0, 0, 0),
(15, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Only ', 'Only ', 0, 0, 0),
(16, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, ' properties allowed to show in home page slider', ' properties allowed to show in home page slider', 0, 0, 0),
(17, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Featured deactivated successfully', 'Featured deactivated successfully', 0, 0, 0),
(18, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Featured activated successfully', 'Featured activated successfully', 0, 0, 0),
(19, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'User blocked successfully', 'User blocked successfully', 0, 0, 0),
(20, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'User activated successfully', 'User activated successfully', 0, 0, 0),
(21, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'suspended successfully', 'suspended successfully', 0, 0, 0),
(22, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'unsuspended successfully', 'unsuspended successfully', 0, 0, 0),
(23, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'flagged successfully', 'flagged successfully', 0, 0, 0),
(24, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'flag cleared successfully', 'flag cleared successfully', 0, 0, 0),
(25, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'verified successfully', 'verified successfully', 0, 0, 0),
(26, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'unverified successfully', 'unverified successfully', 0, 0, 0),
(27, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'disapproved successfully', 'disapproved successfully', 0, 0, 0),
(28, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Your property has been activated', 'Your property has been activated', 0, 0, 0),
(29, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'approved successfully', 'approved successfully', 0, 0, 0),
(30, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Message flagged successfully', 'Message flagged successfully', 0, 0, 0),
(31, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Message flag cleared successfully', 'Message flag cleared successfully', 0, 0, 0),
(32, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Checked records has been disabled', 'Checked records has been disabled', 0, 0, 0),
(33, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Checked records has been enabled', 'Checked records has been enabled', 0, 0, 0),
(34, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Checked records has been disapproved', 'Checked records has been disapproved', 0, 0, 0),
(35, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Checked records has been approved', 'Checked records has been approved', 0, 0, 0),
(36, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Checked records has been Suspended', 'Checked records has been Suspended', 0, 0, 0),
(37, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Checked records has been changed to Unsuspended', 'Checked records has been changed to Unsuspended', 0, 0, 0),
(38, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Checked records has been changed to Unflagged', 'Checked records has been changed to Unflagged', 0, 0, 0),
(39, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Checked records has been changed to flagged', 'Checked records has been changed to flagged', 0, 0, 0),
(40, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, '[Image: %s]', '[Image: %s]', 0, 0, 0),
(41, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'View this item', 'View this item', 0, 0, 0),
(42, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'View this merchant', 'View this merchant', 0, 0, 0),
(43, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'using', 'using', 0, 0, 0),
(44, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Mark as paid/manual', 'Mark as paid/manual', 0, 0, 0),
(45, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Affiliate Fund Withdrawal Request', 'Affiliate Fund Withdrawal Request', 0, 0, 0),
(46, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, ' - Pending', ' - Pending', 0, 0, 0),
(47, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, ' - Accepted', ' - Accepted', 0, 0, 0),
(48, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, ' - Rejected', ' - Rejected', 0, 0, 0),
(49, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, ' - Payment Failure', ' - Payment Failure', 0, 0, 0),
(50, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, ' - Paid', ' - Paid', 0, 0, 0),
(51, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, ' -  today', ' -  today', 0, 0, 0),
(52, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, ' -  in this week', ' -  in this week', 0, 0, 0),
(53, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, ' -  in this month', ' -  in this month', 0, 0, 0),
(54, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Add Affiliate Cash Withdrawal', 'Add Affiliate Cash Withdrawal', 0, 0, 0),
(55, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Withdraw Fund Requests - from Affiliates', 'Withdraw Fund Requests - from Affiliates', 0, 0, 0),
(56, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, ' - Requested today', ' - Requested today', 0, 0, 0),
(57, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, ' - Requested in this week', ' - Requested in this week', 0, 0, 0),
(58, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, ' - Requested in this month', ' - Requested in this month', 0, 0, 0),
(59, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, ' - Under Process', ' - Under Process', 0, 0, 0),
(60, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, ' - Failed', ' - Failed', 0, 0, 0),
(61, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, ' - Success', ' - Success', 0, 0, 0),
(62, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Affiliate Cash Withdrawal deleted', 'Affiliate Cash Withdrawal deleted', 0, 0, 0),
(63, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Checked requests have been moved to pending status', 'Checked requests have been moved to pending status', 0, 0, 0),
(64, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Checked requests have been moved to rejected status, Amount sent back tot the users.', 'Checked requests have been moved to rejected status, Amount sent back tot the users.', 0, 0, 0),
(65, '2012-03-06 17:36:56', '2012-03-06 17:36:56', 42, 'Pay via ', 'Pay via ', 0, 0, 0),
(66, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'API', 'API', 0, 0, 0),
(67, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Withdraw Fund Requests - Approved', 'Withdraw Fund Requests - Approved', 0, 0, 0),
(68, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Manual payment process has been completed.', 'Manual payment process has been completed.', 0, 0, 0),
(69, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Mass payment request is submitted in', 'Mass payment request is submitted in', 0, 0, 0),
(70, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'User will be paid once process completed.', 'User will be paid once process completed.', 0, 0, 0),
(71, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Withdrawal has beed successfully moved to ', 'Withdrawal has beed successfully moved to ', 0, 0, 0),
(72, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Request Affiliate', 'Request Affiliate', 0, 0, 0),
(73, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Your request added successfully', 'Your request added successfully', 0, 0, 0),
(74, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate request could not be added. Please, try again.', 'Affiliate request could not be added. Please, try again.', 0, 0, 0),
(75, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate Requests', 'Affiliate Requests', 0, 0, 0),
(76, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, ' - Search - %s', ' - Search - %s', 0, 0, 0),
(77, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Add Affiliate Request', 'Add Affiliate Request', 0, 0, 0),
(78, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate request has been added', 'Affiliate request has been added', 0, 0, 0),
(79, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Edit Affiliate Request', 'Edit Affiliate Request', 0, 0, 0),
(80, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate Request has been updated', 'Affiliate Request has been updated', 0, 0, 0),
(81, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate Request could not be updated. Please, try again.', 'Affiliate Request could not be updated. Please, try again.', 0, 0, 0),
(82, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate Request deleted', 'Affiliate Request deleted', 0, 0, 0),
(83, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Disapproved the checked requests', 'Disapproved the checked requests', 0, 0, 0),
(84, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Approved checked requests', 'Approved checked requests', 0, 0, 0),
(85, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Deleted the checked requests', 'Deleted the checked requests', 0, 0, 0),
(86, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate Types', 'Affiliate Types', 0, 0, 0),
(87, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Commission Settings', 'Commission Settings', 0, 0, 0),
(88, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate Type has been updated', 'Affiliate Type has been updated', 0, 0, 0),
(89, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, ' Affiliate Type could not be updated. Please, try again.', ' Affiliate Type could not be updated. Please, try again.', 0, 0, 0),
(90, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate Widget Sizes', 'Affiliate Widget Sizes', 0, 0, 0),
(91, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Add Affiliate Widget Size', 'Add Affiliate Widget Size', 0, 0, 0),
(92, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate Widget Size has been added.', 'Affiliate Widget Size has been added.', 0, 0, 0),
(93, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate Widget Size could not be added. Please, try again.', 'Affiliate Widget Size could not be added. Please, try again.', 0, 0, 0),
(94, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Edit Affiliate Widget Size', 'Edit Affiliate Widget Size', 0, 0, 0),
(95, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate Widget Size has been updated', 'Affiliate Widget Size has been updated', 0, 0, 0),
(96, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate Widget Size could not be updated. Please, try again.', 'Affiliate Widget Size could not be updated. Please, try again.', 0, 0, 0),
(97, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate Widget Size deleted', 'Affiliate Widget Size deleted', 0, 0, 0),
(98, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate', 'Affiliate', 0, 0, 0),
(99, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, ' - Pipeline', ' - Pipeline', 0, 0, 0),
(100, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, ' - Completed', ' - Completed', 0, 0, 0),
(101, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Stats', 'Stats', 0, 0, 0),
(102, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Today', 'Today', 0, 0, 0),
(103, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'This week', 'This week', 0, 0, 0),
(104, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'This month', 'This month', 0, 0, 0),
(105, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Total', 'Total', 0, 0, 0),
(106, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Pipeline', 'Pipeline', 0, 0, 0),
(107, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Completed', 'Completed', 0, 0, 0),
(108, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate Withdaw Request', 'Affiliate Withdaw Request', 0, 0, 0),
(109, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Pending', 'Pending', 0, 0, 0),
(110, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Approved', 'Approved', 0, 0, 0),
(111, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Rejected', 'Rejected', 0, 0, 0),
(112, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Paid', 'Paid', 0, 0, 0),
(113, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Payment Failure', 'Payment Failure', 0, 0, 0),
(114, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliates', 'Affiliates', 0, 0, 0),
(115, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, ' - Referred today', ' - Referred today', 0, 0, 0),
(116, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, ' - Referred in this week', ' - Referred in this week', 0, 0, 0),
(117, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, ' - Referred in this month', ' - Referred in this month', 0, 0, 0),
(118, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, '- Pending', '- Pending', 0, 0, 0),
(119, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, '- Canceled', '- Canceled', 0, 0, 0),
(120, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, '- PipeLine', '- PipeLine', 0, 0, 0),
(121, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, '- Completed', '- Completed', 0, 0, 0),
(122, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, '- All', '- All', 0, 0, 0),
(123, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate deleted', 'Affiliate deleted', 0, 0, 0),
(124, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Canceled', 'Canceled', 0, 0, 0),
(125, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Waiting for Approved', 'Waiting for Approved', 0, 0, 0),
(126, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Affiliate Withdaw Requests', 'Affiliate Withdaw Requests', 0, 0, 0),
(127, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Daily Items Widget', 'Daily Items Widget', 0, 0, 0),
(128, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Authorizenet Docapture Logs', 'Authorizenet Docapture Logs', 0, 0, 0),
(129, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Authorizenet Docapture Log', 'Authorizenet Docapture Log', 0, 0, 0),
(130, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Authorizenet Docapture Log deleted', 'Authorizenet Docapture Log deleted', 0, 0, 0),
(131, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Banned IPs', 'Banned IPs', 0, 0, 0),
(132, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Add Banned IP', 'Add Banned IP', 0, 0, 0),
(133, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Must be a valid URL', 'Must be a valid URL', 0, 0, 0),
(134, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Banned IP has been added', 'Banned IP has been added', 0, 0, 0),
(135, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Banned IP could not be added. Please, try again', 'Banned IP could not be added. Please, try again', 0, 0, 0),
(136, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'You cannot add your IP address. Please, try again', 'You cannot add your IP address. Please, try again', 0, 0, 0),
(137, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'You cannot add your own domain. Please, try again', 'You cannot add your own domain. Please, try again', 0, 0, 0),
(138, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Banned IP deleted', 'Banned IP deleted', 0, 0, 0),
(139, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Blocked Users', 'Blocked Users', 0, 0, 0),
(140, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Add Blocked User', 'Add Blocked User', 0, 0, 0),
(141, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'User blocked successfully.', 'User blocked successfully.', 0, 0, 0),
(142, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Already added', 'Already added', 0, 0, 0),
(143, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Edit Blocked User', 'Edit Blocked User', 0, 0, 0),
(144, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, '\\"%s\\" Blocked User has been updated', '\\"%s\\" Blocked User has been updated', 0, 0, 0),
(145, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, '\\"%s\\" Blocked User could not be updated. Please, try again.', '\\"%s\\" Blocked User could not be updated. Please, try again.', 0, 0, 0),
(146, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Blocked User deleted', 'Blocked User deleted', 0, 0, 0),
(147, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, '\\"%s\\" Blocked User has been added', '\\"%s\\" Blocked User has been added', 0, 0, 0),
(148, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, '\\"%s\\" Blocked User could not be added. Please, try again.', '\\"%s\\" Blocked User could not be added. Please, try again.', 0, 0, 0),
(149, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Checked blocked users has been deleted', 'Checked blocked users has been deleted', 0, 0, 0),
(150, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Charity', 'Charity', 0, 0, 0),
(151, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Charities', 'Charities', 0, 0, 0),
(152, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Add Charity', 'Add Charity', 0, 0, 0),
(153, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Charity has been added', 'Charity has been added', 0, 0, 0),
(154, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Charity could not be added. Please, try again.', 'Charity could not be added. Please, try again.', 0, 0, 0),
(155, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Edit Charity', 'Edit Charity', 0, 0, 0),
(156, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Charity has been updated', 'Charity has been updated', 0, 0, 0),
(157, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Charity could not be updated. Please, try again.', 'Charity could not be updated. Please, try again.', 0, 0, 0),
(158, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Charity deleted', 'Charity deleted', 0, 0, 0),
(159, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Checked charities has been marked as active', 'Checked charities has been marked as active', 0, 0, 0),
(160, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Checked charities has been marked as inactive', 'Checked charities has been marked as inactive', 0, 0, 0),
(161, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Checked charities has been deleted', 'Checked charities has been deleted', 0, 0, 0),
(162, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Pay to Charity - Approved', 'Pay to Charity - Approved', 0, 0, 0),
(163, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Mass payment request is submitted in Paypal. Charity will be paid once process completed.', 'Mass payment request is submitted in Paypal. Charity will be paid once process completed.', 0, 0, 0),
(164, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Add Charity Cash Withdrawal', 'Add Charity Cash Withdrawal', 0, 0, 0),
(165, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Payment History', 'Payment History', 0, 0, 0),
(166, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, ' - Under Progress', ' - Under Progress', 0, 0, 0),
(167, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Charity Cash Withdrawal deleted', 'Charity Cash Withdrawal deleted', 0, 0, 0),
(168, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Charity Categories', 'Charity Categories', 0, 0, 0),
(169, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Add Charity Category', 'Add Charity Category', 0, 0, 0),
(170, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Charity Category has been added', 'Charity Category has been added', 0, 0, 0),
(171, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Charity Category could not be added. Please, try again.', 'Charity Category could not be added. Please, try again.', 0, 0, 0),
(172, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Edit Charity Category', 'Edit Charity Category', 0, 0, 0),
(173, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Charity Category has been updated', 'Charity Category has been updated', 0, 0, 0),
(174, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Charity Category could not be updated. Please, try again.', 'Charity Category could not be updated. Please, try again.', 0, 0, 0),
(175, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Charity Category deleted', 'Charity Category deleted', 0, 0, 0),
(176, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Charity Money Transfer Accounts', 'Charity Money Transfer Accounts', 0, 0, 0),
(177, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'charity money transfer account has been added', 'charity money transfer account has been added', 0, 0, 0),
(178, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'charity money transfer account could not be updated. Please, try again.', 'charity money transfer account could not be updated. Please, try again.', 0, 0, 0),
(179, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Charity money transfer account has been deleted', 'Charity money transfer account has been deleted', 0, 0, 0),
(180, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Last 7 days', 'Last 7 days', 0, 0, 0),
(181, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Last 4 weeks', 'Last 4 weeks', 0, 0, 0),
(182, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Last 3 months', 'Last 3 months', 0, 0, 0),
(183, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Last 3 years', 'Last 3 years', 0, 0, 0),
(184, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Normal', 'Normal', 0, 0, 0),
(185, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Twitter', 'Twitter', 0, 0, 0),
(186, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Foursquare', 'Foursquare', 0, 0, 0),
(187, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Facebook', 'Facebook', 0, 0, 0),
(188, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'OpenID', 'OpenID', 0, 0, 0),
(189, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Gmail', 'Gmail', 0, 0, 0),
(190, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Yahoo', 'Yahoo', 0, 0, 0),
(191, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'All', 'All', 0, 0, 0),
(192, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Draft', 'Draft', 0, 0, 0),
(193, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Open', 'Open', 0, 0, 0),
(194, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Tipped', 'Tipped', 0, 0, 0),
(195, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Closed', 'Closed', 0, 0, 0),
(196, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Paid To Merchant', 'Paid To Merchant', 0, 0, 0),
(197, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Refunded', 'Refunded', 0, 0, 0),
(198, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Expired', 'Expired', 0, 0, 0),
(199, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Available', 'Available', 0, 0, 0),
(200, '2012-03-06 17:36:57', '2012-03-06 17:36:57', 42, 'Used', 'Used', 0, 0, 0),
(201, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Redeemed', 'Redeemed', 0, 0, 0),
(202, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Not Redeemed', 'Not Redeemed', 0, 0, 0),
(203, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Site Earned Amount', 'Site Earned Amount', 0, 0, 0),
(204, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Deposited', 'Deposited', 0, 0, 0),
(205, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Paid Commission for Merchant', 'Paid Commission for Merchant', 0, 0, 0),
(206, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Paid Referral for User', 'Paid Referral for User', 0, 0, 0),
(207, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Withdrawn Amount', 'Withdrawn Amount', 0, 0, 0),
(208, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Pending Withdraw Request', 'Pending Withdraw Request', 0, 0, 0),
(209, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Orders', 'Orders', 0, 0, 0),
(210, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, '500+', '500+', 0, 0, 0),
(211, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Item Stats', 'Item Stats', 0, 0, 0),
(212, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Not Mentioned', 'Not Mentioned', 0, 0, 0),
(213, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, '18 - 34 Yrs', '18 - 34 Yrs', 0, 0, 0),
(214, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, '35 - 44 Yrs', '35 - 44 Yrs', 0, 0, 0),
(215, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, '45 - 54 Yrs', '45 - 54 Yrs', 0, 0, 0),
(216, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, '55+ Yrs', '55+ Yrs', 0, 0, 0),
(217, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Amount Received from Admin', 'Amount Received from Admin', 0, 0, 0),
(218, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Paid To Charity', 'Paid To Charity', 0, 0, 0),
(219, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Deposited Amount', 'Deposited Amount', 0, 0, 0),
(220, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Pending withdrwaw request', 'Pending withdrwaw request', 0, 0, 0),
(221, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Cities', 'Cities', 0, 0, 0),
(222, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, ' - Served', ' - Served', 0, 0, 0),
(223, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, ' - Unserved', ' - Unserved', 0, 0, 0),
(224, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Update Twitter', 'Update Twitter', 0, 0, 0),
(225, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Update Facebook', 'Update Facebook', 0, 0, 0),
(226, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Edit City', 'Edit City', 0, 0, 0),
(227, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'City has been updated', 'City has been updated', 0, 0, 0),
(228, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'City could not be updated. Please, try again.', 'City could not be updated. Please, try again.', 0, 0, 0),
(229, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Add City', 'Add City', 0, 0, 0),
(230, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, ' City has been added', ' City has been added', 0, 0, 0),
(231, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, ' City could not be added. Please, try again.', ' City could not be added. Please, try again.', 0, 0, 0),
(232, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Selected cities has been disapproved', 'Selected cities has been disapproved', 0, 0, 0),
(233, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Selected cities has been approved', 'Selected cities has been approved', 0, 0, 0),
(234, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Selected cities has been activated', 'Selected cities has been activated', 0, 0, 0),
(235, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Selected cities has been inactivated', 'Selected cities has been inactivated', 0, 0, 0),
(236, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'You cannot inactivate the default city. Please update default city from settings and try again.', 'You cannot inactivate the default city. Please update default city from settings and try again.', 0, 0, 0),
(237, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'except the default city. Please update default city from settings and try again.', 'except the default city. Please update default city from settings and try again.', 0, 0, 0),
(238, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Selected cities has been deleted', 'Selected cities has been deleted', 0, 0, 0),
(239, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'You can not delete the default city. Please update default city from settings and try again.', 'You can not delete the default city. Please update default city from settings and try again.', 0, 0, 0),
(240, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'City deleted', 'City deleted', 0, 0, 0),
(241, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Facebook credentials updated for selected city', 'Facebook credentials updated for selected city', 0, 0, 0),
(242, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Facebook credentials could not be updated for selected city. Please, try again.', 'Facebook credentials could not be updated for selected city. Please, try again.', 0, 0, 0),
(243, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Twitter credentials updated for selected city', 'Twitter credentials updated for selected city', 0, 0, 0),
(244, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Twitter credentials could not be updated for selected city. Please, try again.', 'Twitter credentials could not be updated for selected city. Please, try again.', 0, 0, 0),
(245, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Collages', 'Collages', 0, 0, 0),
(246, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Add College', 'Add College', 0, 0, 0),
(247, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'college has been added', 'college has been added', 0, 0, 0),
(248, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'college could not be added. Please, try again.', 'college could not be added. Please, try again.', 0, 0, 0),
(249, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Edit College', 'Edit College', 0, 0, 0),
(250, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Invalid college', 'Invalid college', 0, 0, 0),
(251, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'college has been updated', 'college has been updated', 0, 0, 0),
(252, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'college could not be updated. Please, try again.', 'college could not be updated. Please, try again.', 0, 0, 0),
(253, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'College  deleted', 'College  deleted', 0, 0, 0),
(254, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Companies', 'Companies', 0, 0, 0),
(255, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Add Company', 'Add Company', 0, 0, 0),
(256, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'company has been added', 'company has been added', 0, 0, 0),
(257, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'company could not be added. Please, try again.', 'company could not be added. Please, try again.', 0, 0, 0),
(258, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Edit Company', 'Edit Company', 0, 0, 0),
(259, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Invalid company', 'Invalid company', 0, 0, 0),
(260, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'company has been updated', 'company has been updated', 0, 0, 0),
(261, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'company could not be updated. Please, try again.', 'company could not be updated. Please, try again.', 0, 0, 0),
(262, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Company  deleted', 'Company  deleted', 0, 0, 0),
(263, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Contact could not be added. Please, try again.', 'Contact could not be added. Please, try again.', 0, 0, 0),
(264, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Contact Us', 'Contact Us', 0, 0, 0),
(265, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Countries', 'Countries', 0, 0, 0),
(266, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Add Country', 'Add Country', 0, 0, 0),
(267, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Country has been added', 'Country has been added', 0, 0, 0),
(268, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Country could not be updated. Please, try again', 'Country could not be updated. Please, try again', 0, 0, 0),
(269, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Edit Country', 'Edit Country', 0, 0, 0),
(270, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Country has been updated', 'Country has been updated', 0, 0, 0),
(271, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Country could not be updated. Please, try again.', 'Country could not be updated. Please, try again.', 0, 0, 0),
(272, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Country deleted', 'Country deleted', 0, 0, 0),
(273, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Country could not be deleted. Please, check seleted country belongs to default city', 'Country could not be deleted. Please, check seleted country belongs to default city', 0, 0, 0),
(274, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Checked countries has been deleted', 'Checked countries has been deleted', 0, 0, 0),
(275, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Currencies', 'Currencies', 0, 0, 0),
(276, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Add Currency', 'Add Currency', 0, 0, 0),
(277, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Currency has been added', 'Currency has been added', 0, 0, 0),
(278, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Currency could not be added. Please, try again.', 'Currency could not be added. Please, try again.', 0, 0, 0),
(279, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Edit Currency', 'Edit Currency', 0, 0, 0),
(280, '2012-03-06 17:36:58', '2012-03-06 17:36:58', 42, 'Currency has been updated', 'Currency has been updated', 0, 0, 0),
(281, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Currency could not be updated. Please, try again.', 'Currency could not be updated. Please, try again.', 0, 0, 0),
(282, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Currency deleted', 'Currency deleted', 0, 0, 0),
(283, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Currency Conversion / Exchange Rates', 'Currency Conversion / Exchange Rates', 0, 0, 0),
(284, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Required', 'Required', 0, 0, 0),
(285, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'History', 'History', 0, 0, 0),
(286, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Invalid currency conversion history', 'Invalid currency conversion history', 0, 0, 0),
(287, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Currency conversion history deleted', 'Currency conversion history deleted', 0, 0, 0),
(288, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Currency conversion history was not deleted', 'Currency conversion history was not deleted', 0, 0, 0),
(289, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Email Templates', 'Email Templates', 0, 0, 0),
(290, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Edit Email Template', 'Edit Email Template', 0, 0, 0),
(291, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Email Template has been updated', 'Email Template has been updated', 0, 0, 0),
(292, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Email Template could not be updated. Please, try again.', 'Email Template could not be updated. Please, try again.', 0, 0, 0),
(293, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Sorry. You Cannot Update the Settings in Demo Mode', 'Sorry. You Cannot Update the Settings in Demo Mode', 0, 0, 0),
(294, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Genders', 'Genders', 0, 0, 0),
(295, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Edit Gender', 'Edit Gender', 0, 0, 0),
(296, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Gender has been updated', 'Gender has been updated', 0, 0, 0),
(297, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Gender could not be updated. Please, try again.', 'Gender could not be updated. Please, try again.', 0, 0, 0),
(298, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'IPs', 'IPs', 0, 0, 0),
(299, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'IP deleted', 'IP deleted', 0, 0, 0),
(300, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item Categories', 'Item Categories', 0, 0, 0),
(301, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Add Item   Category', 'Add Item   Category', 0, 0, 0),
(302, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item category has been added', 'Item category has been added', 0, 0, 0),
(303, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item category could not be added. Please, try again.', 'Item category could not be added. Please, try again.', 0, 0, 0),
(304, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Edit Item Category', 'Edit Item Category', 0, 0, 0),
(305, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item category has been updated', 'Item category has been updated', 0, 0, 0),
(306, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item category could not be updated. Please, try again.', 'Item category could not be updated. Please, try again.', 0, 0, 0),
(307, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item category deleted', 'Item category deleted', 0, 0, 0),
(308, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item Comments', 'Item Comments', 0, 0, 0),
(309, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item Comment', 'Item Comment', 0, 0, 0),
(310, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Invalid item comment', 'Invalid item comment', 0, 0, 0),
(311, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Add Item Comment', 'Add Item Comment', 0, 0, 0),
(312, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item comment has been added', 'Item comment has been added', 0, 0, 0),
(313, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'item comment could not be added. Please, try again.', 'item comment could not be added. Please, try again.', 0, 0, 0),
(314, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Edit Item Comment', 'Edit Item Comment', 0, 0, 0),
(315, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'item comment has been updated', 'item comment has been updated', 0, 0, 0),
(316, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'item comment could not be updated. Please, try again.', 'item comment could not be updated. Please, try again.', 0, 0, 0),
(317, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item comment deleted', 'Item comment deleted', 0, 0, 0),
(318, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item comment was not deleted', 'Item comment was not deleted', 0, 0, 0),
(319, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'item comment has been added', 'item comment has been added', 0, 0, 0),
(320, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'item comment  deleted', 'item comment  deleted', 0, 0, 0),
(321, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item Orders/Passes', 'Item Orders/Passes', 0, 0, 0),
(322, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Unused Pass deleted', 'Unused Pass deleted', 0, 0, 0),
(323, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Success', 'Success', 0, 0, 0),
(324, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item user Pass', 'Item user Pass', 0, 0, 0),
(325, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Invalid Pass code', 'Invalid Pass code', 0, 0, 0),
(326, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'You have no authorized to view this page', 'You have no authorized to view this page', 0, 0, 0),
(327, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'This Pass used already', 'This Pass used already', 0, 0, 0),
(328, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Pass used successfully', 'Pass used successfully', 0, 0, 0),
(329, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Not Used', 'Not Used', 0, 0, 0),
(330, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Refund', 'Refund', 0, 0, 0),
(331, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'My %s Passes', 'My %s Passes', 0, 0, 0),
(332, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'My %s Items', 'My %s Items', 0, 0, 0),
(333, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item Pass deleted', 'Item Pass deleted', 0, 0, 0),
(334, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, ' - Used', ' - Used', 0, 0, 0),
(335, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, ' - Expired', ' - Expired', 0, 0, 0),
(336, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, ' - Canceled', ' - Canceled', 0, 0, 0),
(337, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, ' - Refund', ' - Refund', 0, 0, 0),
(338, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Checked item pass status has been changed', 'Checked item pass status has been changed', 0, 0, 0),
(339, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item canceled successfully.', 'Item canceled successfully.', 0, 0, 0),
(340, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.', 'Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.', 0, 0, 0),
(341, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Referral Commission', 'Referral Commission', 0, 0, 0),
(342, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item has been added.', 'Item has been added.', 0, 0, 0),
(343, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Nearby Items', 'Nearby Items', 0, 0, 0),
(344, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Past Items', 'Past Items', 0, 0, 0),
(345, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Main Items', 'Main Items', 0, 0, 0),
(346, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Recent Items', 'Recent Items', 0, 0, 0),
(347, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Items of the Day', 'Items of the Day', 0, 0, 0),
(348, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'My Items', 'My Items', 0, 0, 0),
(349, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'No Items available', 'No Items available', 0, 0, 0),
(350, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Items found', 'Items found', 0, 0, 0),
(351, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'true', 'true', 0, 0, 0),
(352, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'false', 'false', 0, 0, 0),
(353, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Not Yet Tipped', 'Not Yet Tipped', 0, 0, 0),
(354, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'No Limit', 'No Limit', 0, 0, 0),
(355, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Its seems that the current select city does''t have any open items. Please select another city', 'Its seems that the current select city does''t have any open items. Please select another city', 0, 0, 0),
(356, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'User name', 'User name', 0, 0, 0),
(357, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Quantity', 'Quantity', 0, 0, 0),
(358, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Amount', 'Amount', 0, 0, 0),
(359, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Top Code', 'Top Code', 0, 0, 0),
(360, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Bottom Code', 'Bottom Code', 0, 0, 0),
(361, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item', 'Item', 0, 0, 0),
(362, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Edit Item', 'Edit Item', 0, 0, 0),
(363, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item could not be added. Please, try again.', 'Item could not be added. Please, try again.', 0, 0, 0),
(364, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item has been updated', 'Item has been updated', 0, 0, 0),
(365, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item could not be updated. Please, try again.', 'Item could not be updated. Please, try again.', 0, 0, 0),
(366, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Add Item', 'Add Item', 0, 0, 0),
(367, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item has been added', 'Item has been added', 0, 0, 0),
(368, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item deleted', 'Item deleted', 0, 0, 0),
(369, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, ' %s Items', ' %s Items', 0, 0, 0),
(370, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, ' - Created today', ' - Created today', 0, 0, 0),
(371, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, ' - Created in this week', ' - Created in this week', 0, 0, 0),
(372, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, ' - Created in this month', ' - Created in this month', 0, 0, 0),
(373, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Cancel and refund', 'Cancel and refund', 0, 0, 0),
(374, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Delete', 'Delete', 0, 0, 0),
(375, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Pay To Merchant', 'Pay To Merchant', 0, 0, 0),
(376, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Checked items have been moved to open status. ', 'Checked items have been moved to open status. ', 0, 0, 0),
(377, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Some of the items are not opened due to the end date and pass expiry date in past.', 'Some of the items are not opened due to the end date and pass expiry date in past.', 0, 0, 0),
(378, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Checked items have been canceled', 'Checked items have been canceled', 0, 0, 0),
(379, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Checked items have been rejected', 'Checked items have been rejected', 0, 0, 0),
(380, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Items have been changed as expired. ', 'Items have been changed as expired. ', 0, 0, 0),
(381, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Some of the items are not expired becasue \\"AnyTime\\" Item cannot be expired. It can be either cancelled or closed.', 'Some of the items are not expired becasue \\"AnyTime\\" Item cannot be expired. It can be either cancelled or closed.', 0, 0, 0),
(382, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Expired items have been refunded', 'Expired items have been refunded', 0, 0, 0),
(383, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Checked items have been closed', 'Checked items have been closed', 0, 0, 0),
(384, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Checked item amount have been transferred', 'Checked item amount have been transferred', 0, 0, 0),
(385, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Checked items have been deleted', 'Checked items have been deleted', 0, 0, 0),
(386, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Item status updated successfully', 'Item status updated successfully', 0, 0, 0),
(387, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Buy Item', 'Buy Item', 0, 0, 0),
(388, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Your Purchase could not be completed.', 'Your Purchase could not be completed.', 0, 0, 0),
(389, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Invalid data entered. Your purchase has been cancelled.', 'Invalid data entered. Your purchase has been cancelled.', 0, 0, 0),
(390, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'You can''t buy this item. Your maximum allowed limit %s is over', 'You can''t buy this item. Your maximum allowed limit %s is over', 0, 0, 0),
(391, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Visa', 'Visa', 0, 0, 0),
(392, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'MasterCard', 'MasterCard', 0, 0, 0),
(393, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Discover', 'Discover', 0, 0, 0),
(394, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Amex', 'Amex', 0, 0, 0),
(395, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Purchase via wallet not possible as the total purchase amount exceeded your wallet balance.', 'Purchase via wallet not possible as the total purchase amount exceeded your wallet balance.', 0, 0, 0),
(396, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Buy %s Item', 'Buy %s Item', 0, 0, 0),
(397, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Payment failed. Please try again.', 'Payment failed. Please try again.', 0, 0, 0),
(398, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Credit card could not be updated. Please, try again.', 'Credit card could not be updated. Please, try again.', 0, 0, 0),
(399, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'You have bought a item sucessfully.', 'You have bought a item sucessfully.', 0, 0, 0),
(400, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Payment failed.Please try again.', 'Payment failed.Please try again.', 0, 0, 0),
(401, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Your transaction has been completed.', 'Your transaction has been completed.', 0, 0, 0),
(402, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Error in payment.', 'Error in payment.', 0, 0, 0),
(403, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, '%s', '%s', 0, 0, 0),
(404, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'You have bought an item successfully.', 'You have bought an item successfully.', 0, 0, 0),
(405, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'You can''t buy this item.', 'You can''t buy this item.', 0, 0, 0);
INSERT INTO `translations` (`id`, `created`, `modified`, `language_id`, `key`, `lang_text`, `is_translated`, `is_google_translate`, `is_verified`) VALUES
(406, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Payment Success', 'Payment Success', 0, 0, 0),
(407, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Your payment has been successfully finished. We will update this transactions after item has been tipped.', 'Your payment has been successfully finished. We will update this transactions after item has been tipped.', 0, 0, 0),
(408, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Your payment has been successfully finished. We will update this transactions page after receiving the confirmation from PayPal', 'Your payment has been successfully finished. We will update this transactions page after receiving the confirmation from PayPal', 0, 0, 0),
(409, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Payment Cancel', 'Payment Cancel', 0, 0, 0),
(410, '2012-03-06 17:36:59', '2012-03-06 17:36:59', 42, 'Transaction failure. Please try once again.', 'Transaction failure. Please try once again.', 0, 0, 0),
(411, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Today''s Item', 'Today''s Item', 0, 0, 0),
(412, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Unlimited', 'Unlimited', 0, 0, 0),
(413, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Item Snapshot', 'Item Snapshot', 0, 0, 0),
(414, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Languages', 'Languages', 0, 0, 0),
(415, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Active ', ' - Active ', 0, 0, 0),
(416, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Inactive ', ' - Inactive ', 0, 0, 0),
(417, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Add Language', 'Add Language', 0, 0, 0),
(418, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Language has been added', 'Language has been added', 0, 0, 0),
(419, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Language could not be added. Please, try again.', 'Language could not be added. Please, try again.', 0, 0, 0),
(420, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Edit Language', 'Edit Language', 0, 0, 0),
(421, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Language  has been updated', 'Language  has been updated', 0, 0, 0),
(422, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Language  could not be updated. Please, try again.', 'Language  could not be updated. Please, try again.', 0, 0, 0),
(423, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'MailChimp Lists', 'MailChimp Lists', 0, 0, 0),
(424, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'MailChimp List has been updated', 'MailChimp List has been updated', 0, 0, 0),
(425, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Merchant', 'Merchant', 0, 0, 0),
(426, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Edit Merchant', 'Edit Merchant', 0, 0, 0),
(427, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Merchant has been updated', 'Merchant has been updated', 0, 0, 0),
(428, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Merchant could not be updated. Please, try again.', 'Merchant could not be updated. Please, try again.', 0, 0, 0),
(429, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Merchant deleted', 'Merchant deleted', 0, 0, 0),
(430, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Merchants', 'Merchants', 0, 0, 0),
(431, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Search - ', ' - Search - ', 0, 0, 0),
(432, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Affiliate', ' - Affiliate', 0, 0, 0),
(433, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Registered through OpenID ', ' - Registered through OpenID ', 0, 0, 0),
(434, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Registered through Facebook ', ' - Registered through Facebook ', 0, 0, 0),
(435, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Registered through Twitter ', ' - Registered through Twitter ', 0, 0, 0),
(436, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Registered through Gmail ', ' - Registered through Gmail ', 0, 0, 0),
(437, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Registered through Yahoo ', ' - Registered through Yahoo ', 0, 0, 0),
(438, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Online Account', ' - Online Account', 0, 0, 0),
(439, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Offline Account', ' - Offline Account', 0, 0, 0),
(440, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Registered today', ' - Registered today', 0, 0, 0),
(441, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Registered in this week', ' - Registered in this week', 0, 0, 0),
(442, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Registered in this month', ' - Registered in this month', 0, 0, 0),
(443, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Set As Paid', 'Set As Paid', 0, 0, 0),
(444, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Add Merchant', 'Add Merchant', 0, 0, 0),
(445, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Merchant has been added', 'Merchant has been added', 0, 0, 0),
(446, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Merchant could not be added. Please, try again.', 'Merchant could not be added. Please, try again.', 0, 0, 0),
(447, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Should be less than available balance amount', 'Should be less than available balance amount', 0, 0, 0),
(448, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Amount deducted for the selected merchants', 'Amount deducted for the selected merchants', 0, 0, 0),
(449, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Amount could not be deducted for the selected merchants. Please, try again.', 'Amount could not be deducted for the selected merchants. Please, try again.', 0, 0, 0),
(450, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Dashboard', 'Dashboard', 0, 0, 0),
(451, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Items', 'Items', 0, 0, 0),
(452, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Pending Approval', 'Pending Approval', 0, 0, 0),
(453, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Cancelled', 'Cancelled', 0, 0, 0),
(454, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Item Passes', 'Item Passes', 0, 0, 0),
(455, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Transactions', 'Transactions', 0, 0, 0),
(456, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'No. of Pending Withdraw Request', 'No. of Pending Withdraw Request', 0, 0, 0),
(457, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Withdrawn Amount by Merchant', 'Withdrawn Amount by Merchant', 0, 0, 0),
(458, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Total Item Amount Received from Admin', 'Total Item Amount Received from Admin', 0, 0, 0),
(459, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Deposits to Wallet', 'Deposits to Wallet', 0, 0, 0),
(460, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Merchant Snapshot', 'Merchant Snapshot', 0, 0, 0),
(461, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Checked merchants has been enabled', 'Checked merchants has been enabled', 0, 0, 0),
(462, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Checked merchants has been disabled', 'Checked merchants has been disabled', 0, 0, 0),
(463, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Checked merchants user has been activated', 'Checked merchants user has been activated', 0, 0, 0),
(464, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Checked merchants user has been deactivated', 'Checked merchants user has been deactivated', 0, 0, 0),
(465, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Messages - Inbox', 'Messages - Inbox', 0, 0, 0),
(466, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Messages - Sent Mail', 'Messages - Sent Mail', 0, 0, 0),
(467, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Messages - Drafts', 'Messages - Drafts', 0, 0, 0),
(468, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Messages - Spam', 'Messages - Spam', 0, 0, 0),
(469, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Messages - Trash', 'Messages - Trash', 0, 0, 0),
(470, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Messages - All', 'Messages - All', 0, 0, 0),
(471, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Messages - %s', 'Messages - %s', 0, 0, 0),
(472, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Messages - Starred', 'Messages - Starred', 0, 0, 0),
(473, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Message', 'Message', 0, 0, 0),
(474, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'All mails', 'All mails', 0, 0, 0),
(475, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Message has been flagged', 'Message has been flagged', 0, 0, 0),
(476, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Message has been Unflagged', 'Message has been Unflagged', 0, 0, 0),
(477, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Message has been suspend', 'Message has been suspend', 0, 0, 0),
(478, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Message has been unsuspend', 'Message has been unsuspend', 0, 0, 0),
(479, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Message has been deleted', 'Message has been deleted', 0, 0, 0),
(480, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Message deleted', 'Message deleted', 0, 0, 0),
(481, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Messages - Compose', 'Messages - Compose', 0, 0, 0),
(482, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Message send is temporarily stopped. Please try again later.', 'Message send is temporarily stopped. Please try again later.', 0, 0, 0),
(483, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Message has been saved successfully', 'Message has been saved successfully', 0, 0, 0),
(484, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Problem in saving message', 'Problem in saving message', 0, 0, 0),
(485, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Message has been sent successfully', 'Message has been sent successfully', 0, 0, 0),
(486, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Message saved successfully', 'Message saved successfully', 0, 0, 0),
(487, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Problem in sending message. You can send message only to your friends network', 'Problem in sending message. You can send message only to your friends network', 0, 0, 0),
(488, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Please specify atleast one recipient', 'Please specify atleast one recipient', 0, 0, 0),
(489, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Re:', 'Re:', 0, 0, 0),
(490, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Fwd:', 'Fwd:', 0, 0, 0),
(491, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Messages', 'Messages', 0, 0, 0),
(492, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Compose message', 'Compose message', 0, 0, 0),
(493, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Problem in sending mail to the appropriate user', 'Problem in sending mail to the appropriate user', 0, 0, 0),
(494, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Search Results', 'Search Results', 0, 0, 0),
(495, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, '---- More actions ----', '---- More actions ----', 0, 0, 0),
(496, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Mark as read', 'Mark as read', 0, 0, 0),
(497, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Mark as unread', 'Mark as unread', 0, 0, 0),
(498, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Add star', 'Add star', 0, 0, 0),
(499, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Remove star', 'Remove star', 0, 0, 0),
(500, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, '----Apply label----', '----Apply label----', 0, 0, 0),
(501, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, '----Remove label----', '----Remove label----', 0, 0, 0),
(502, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Settings', 'Settings', 0, 0, 0),
(503, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Message Settings has been updated', 'Message Settings has been updated', 0, 0, 0),
(504, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Message Settings could not be updated', 'Message Settings could not be updated', 0, 0, 0),
(505, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Suspend ', ' - Suspend ', 0, 0, 0),
(506, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Flagged ', ' - Flagged ', 0, 0, 0),
(507, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Messages sent today', ' - Messages sent today', 0, 0, 0),
(508, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Messages sent this week', ' - Messages sent this week', 0, 0, 0),
(509, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, ' - Messages sent this month', ' - Messages sent this month', 0, 0, 0),
(510, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Money Transfer Accounts', 'Money Transfer Accounts', 0, 0, 0),
(511, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'money transfer account has been added', 'money transfer account has been added', 0, 0, 0),
(512, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'money transfer account could not be updated. Please, try again.', 'money transfer account could not be updated. Please, try again.', 0, 0, 0),
(513, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Transfer account deleted', 'Transfer account deleted', 0, 0, 0),
(514, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Primary money transfer account has been updated', 'Primary money transfer account has been updated', 0, 0, 0),
(515, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Add Page', 'Add Page', 0, 0, 0),
(516, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Page has been created', 'Page has been created', 0, 0, 0),
(517, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Page could not be added. Please, try again.', 'Page could not be added. Please, try again.', 0, 0, 0),
(518, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Edit Page', 'Edit Page', 0, 0, 0),
(519, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Page has been Updated', 'Page has been Updated', 0, 0, 0),
(520, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Page could not be Updated. Please, try again.', 'Page could not be Updated. Please, try again.', 0, 0, 0),
(521, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Pages', 'Pages', 0, 0, 0),
(522, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Page Deleted Successfully', 'Page Deleted Successfully', 0, 0, 0),
(523, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'The submitted file extension is not permitted, only jpg,jpeg,gif,png permitted.', 'The submitted file extension is not permitted, only jpg,jpeg,gif,png permitted.', 0, 0, 0),
(524, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Image not uploaded. Please try again ', 'Image not uploaded. Please try again ', 0, 0, 0),
(525, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Add Payment Gateway Setting', 'Add Payment Gateway Setting', 0, 0, 0),
(526, '2012-03-06 17:37:00', '2012-03-06 17:37:00', 42, 'Payment Gateway Setting has been added', 'Payment Gateway Setting has been added', 0, 0, 0),
(527, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Payment Gateway Setting could not be added. Please, try again.', 'Payment Gateway Setting could not be added. Please, try again.', 0, 0, 0),
(528, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Edit Payment Gateway Setting', 'Edit Payment Gateway Setting', 0, 0, 0),
(529, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Payment gateway settings updated.', 'Payment gateway settings updated.', 0, 0, 0),
(530, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Payment Gateway Setting deleted', 'Payment Gateway Setting deleted', 0, 0, 0),
(531, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Payment Gateways', 'Payment Gateways', 0, 0, 0),
(532, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Edit Payment Gateway', 'Edit Payment Gateway', 0, 0, 0),
(533, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Payment Gateway has been updated', 'Payment Gateway has been updated', 0, 0, 0),
(534, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Payment Gateway could not be updated. Please, try again.', 'Payment Gateway could not be updated. Please, try again.', 0, 0, 0),
(535, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Paypal Docapture Logs', 'Paypal Docapture Logs', 0, 0, 0),
(536, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Paypal Docapture Log', 'Paypal Docapture Log', 0, 0, 0),
(537, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Paypal Transaction Logs', 'Paypal Transaction Logs', 0, 0, 0),
(538, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Mass Paypal Transaction Logs', 'Mass Paypal Transaction Logs', 0, 0, 0),
(539, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Normal Paypal Transaction Logs', 'Normal Paypal Transaction Logs', 0, 0, 0),
(540, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Paypal Transaction Log', 'Paypal Transaction Log', 0, 0, 0),
(541, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'This is image base URL should not trailing slash', 'This is image base URL should not trailing slash', 0, 0, 0),
(542, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'This is css base URL should have trailing slash', 'This is css base URL should have trailing slash', 0, 0, 0),
(543, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'This is JS base URL should have trailing slash', 'This is JS base URL should have trailing slash', 0, 0, 0),
(544, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Settings updated successfully.', 'Settings updated successfully.', 0, 0, 0),
(545, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, ' Settings', ' Settings', 0, 0, 0),
(546, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Facebook credentials updated', 'Facebook credentials updated', 0, 0, 0),
(547, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Facebook credentials could not be updated. Please, try again.', 'Facebook credentials could not be updated. Please, try again.', 0, 0, 0),
(548, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'PNG images crushed successfully', 'PNG images crushed successfully', 0, 0, 0),
(549, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Site Categories', 'Site Categories', 0, 0, 0),
(550, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Site Category', 'Site Category', 0, 0, 0),
(551, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Add Site Category', 'Add Site Category', 0, 0, 0),
(552, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Site Category has been added', 'Site Category has been added', 0, 0, 0),
(553, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Site Category could not be added. Please, try again.', 'Site Category could not be added. Please, try again.', 0, 0, 0),
(554, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Edit Site Category', 'Edit Site Category', 0, 0, 0),
(555, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Site Category has been updated', 'Site Category has been updated', 0, 0, 0),
(556, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Site Category could not be updated. Please, try again.', 'Site Category could not be updated. Please, try again.', 0, 0, 0),
(557, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Site Category deleted', 'Site Category deleted', 0, 0, 0),
(558, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'States', 'States', 0, 0, 0),
(559, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, ' - Approved', ' - Approved', 0, 0, 0),
(560, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, ' - Disapproved', ' - Disapproved', 0, 0, 0),
(561, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Add State', 'Add State', 0, 0, 0),
(562, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'State has been added', 'State has been added', 0, 0, 0),
(563, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'State could not be added. Please, try again.', 'State could not be added. Please, try again.', 0, 0, 0),
(564, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Edit State', 'Edit State', 0, 0, 0),
(565, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'State has been updated', 'State has been updated', 0, 0, 0),
(566, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'State could not be updated. Please, try again.', 'State could not be updated. Please, try again.', 0, 0, 0),
(567, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Checked states has been inactivated', 'Checked states has been inactivated', 0, 0, 0),
(568, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Checked states has been activated', 'Checked states has been activated', 0, 0, 0),
(569, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'States could not be deleted. Please, check seleted state belongs to default city', 'States could not be deleted. Please, check seleted state belongs to default city', 0, 0, 0),
(570, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Checked states has been deleted', 'Checked states has been deleted', 0, 0, 0),
(571, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'State deleted', 'State deleted', 0, 0, 0),
(572, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'My Subscriptions', 'My Subscriptions', 0, 0, 0),
(573, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Add Subscription', 'Add Subscription', 0, 0, 0),
(574, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'a free', 'a free', 0, 0, 0),
(575, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'You are now subscribed to %s in %s city', 'You are now subscribed to %s in %s city', 0, 0, 0),
(576, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'You''ll start receiving your emails soon.', 'You''ll start receiving your emails soon.', 0, 0, 0),
(577, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Could not be subscribed. Please, try again.', 'Could not be subscribed. Please, try again.', 0, 0, 0),
(578, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'You are now subscribed to', 'You are now subscribed to', 0, 0, 0),
(579, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Thanks for subscribing again.', 'Thanks for subscribing again.', 0, 0, 0),
(580, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Item of the Day', 'Item of the Day', 0, 0, 0),
(581, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Subscription confirmation', 'Subscription confirmation', 0, 0, 0),
(582, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Subscribers list has been updated.', 'Subscribers list has been updated.', 0, 0, 0),
(583, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Unsubscribe', 'Unsubscribe', 0, 0, 0),
(584, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Please provide a subscribed email', 'Please provide a subscribed email', 0, 0, 0),
(585, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'You have unsubscribed from the subscribers list', 'You have unsubscribed from the subscribers list', 0, 0, 0),
(586, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'You have unsubscribed from the subscribers list.', 'You have unsubscribed from the subscribers list.', 0, 0, 0),
(587, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Subscriptions', 'Subscriptions', 0, 0, 0),
(588, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Subscribed Users', 'Subscribed Users', 0, 0, 0),
(589, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Unsubscribed Users', 'Unsubscribed Users', 0, 0, 0),
(590, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Checked subscriptions has been deleted', 'Checked subscriptions has been deleted', 0, 0, 0),
(591, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Checked subscriptions has been un subscribed', 'Checked subscriptions has been un subscribed', 0, 0, 0),
(592, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Subscription deleted', 'Subscription deleted', 0, 0, 0),
(593, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Checked cities has been subscribed', 'Checked cities has been subscribed', 0, 0, 0),
(594, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Subscriptions Could not be added. please select cities', 'Subscriptions Could not be added. please select cities', 0, 0, 0),
(595, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Checked city has been Unsubscribed', 'Checked city has been Unsubscribed', 0, 0, 0),
(596, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Could not be Unsubscribed. please select cities', 'Could not be Unsubscribed. please select cities', 0, 0, 0),
(597, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Manage Subscriptions', 'Manage Subscriptions', 0, 0, 0),
(598, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'User Friends', 'User Friends', 0, 0, 0),
(599, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Transaction Types', 'Transaction Types', 0, 0, 0),
(600, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Edit Transaction Type', 'Edit Transaction Type', 0, 0, 0),
(601, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, '\\"%s\\" Transaction Type has been updated', '\\"%s\\" Transaction Type has been updated', 0, 0, 0),
(602, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, '\\"%s\\" Transaction Type could not be updated. Please, try again.', '\\"%s\\" Transaction Type could not be updated. Please, try again.', 0, 0, 0),
(603, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, '''To date'' should be greater than ''From date''.', '''To date'' should be greater than ''From date''.', 0, 0, 0),
(604, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'To date should greater than From date. Please, try again.', 'To date should greater than From date. Please, try again.', 0, 0, 0),
(605, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, ' - Amount Earned today', ' - Amount Earned today', 0, 0, 0),
(606, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, ' - Amount Earned in this week', ' - Amount Earned in this week', 0, 0, 0),
(607, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, ' - Amount Earned in this month', ' - Amount Earned in this month', 0, 0, 0),
(608, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, ' - Today', ' - Today', 0, 0, 0),
(609, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, '- Today', '- Today', 0, 0, 0),
(610, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, ' - This Week', ' - This Week', 0, 0, 0),
(611, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, '- This Week', '- This Week', 0, 0, 0),
(612, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, ' - This Month', ' - This Month', 0, 0, 0),
(613, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, '- This Month', '- This Month', 0, 0, 0),
(614, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, ' - Total', ' - Total', 0, 0, 0),
(615, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, '- Total', '- Total', 0, 0, 0),
(616, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'From date should greater than To date. Please, try again.', 'From date should greater than To date. Please, try again.', 0, 0, 0),
(617, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Transaction deleted', 'Transaction deleted', 0, 0, 0),
(618, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Translations', 'Translations', 0, 0, 0),
(619, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Translation deleted successfully', 'Translation deleted successfully', 0, 0, 0),
(620, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Translation', 'Translation', 0, 0, 0),
(621, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Add New Language Variable', 'Add New Language Variable', 0, 0, 0),
(622, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Language variables has been added', 'Language variables has been added', 0, 0, 0),
(623, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Language variables could not be added', 'Language variables could not be added', 0, 0, 0),
(624, '2012-03-06 17:37:01', '2012-03-06 17:37:01', 42, 'Add Translation', 'Add Translation', 0, 0, 0),
(625, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Default English variable is missing', 'Default English variable is missing', 0, 0, 0),
(626, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Translation could not be updated. Please, try again.', 'Translation could not be updated. Please, try again.', 0, 0, 0),
(627, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Translation could not be updated. Please check iso2 of this language and try again', 'Translation could not be updated. Please check iso2 of this language and try again', 0, 0, 0),
(628, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Translation has been added', 'Translation has been added', 0, 0, 0),
(629, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Edit Translation', 'Edit Translation', 0, 0, 0),
(630, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, '\\"%s\\" Translation has been updated', '\\"%s\\" Translation has been updated', 0, 0, 0),
(631, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, '\\"%s\\" Translation could not be updated. Please, try again.', '\\"%s\\" Translation could not be updated. Please, try again.', 0, 0, 0),
(632, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Translation deleted', 'Translation deleted', 0, 0, 0),
(633, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Edit Translations', 'Edit Translations', 0, 0, 0),
(634, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Translation updated successfully', 'Translation updated successfully', 0, 0, 0),
(635, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, ' - Verified ', ' - Verified ', 0, 0, 0),
(636, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, ' - Unverified ', ' - Unverified ', 0, 0, 0),
(637, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Withdraw Fund Request', 'Withdraw Fund Request', 0, 0, 0),
(638, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Add Fund Withdraw', 'Add Fund Withdraw', 0, 0, 0),
(639, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Withdraw Fund Requests - from Users & Merchants', 'Withdraw Fund Requests - from Users & Merchants', 0, 0, 0),
(640, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Withdraw fund request deleted', 'Withdraw fund request deleted', 0, 0, 0),
(641, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Checked requests have been moved to rejected status, Refunded  Money to Wallet', 'Checked requests have been moved to rejected status, Refunded  Money to Wallet', 0, 0, 0),
(642, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Comments', 'User Comments', 0, 0, 0),
(643, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Comment', 'User Comment', 0, 0, 0),
(644, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Add User Comment', 'Add User Comment', 0, 0, 0),
(645, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Comment has been added', 'User Comment has been added', 0, 0, 0),
(646, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Comment could not be added. Please, try again.', 'User Comment could not be added. Please, try again.', 0, 0, 0),
(647, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Edit User Comment', 'Edit User Comment', 0, 0, 0),
(648, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Comment has been updated', 'User Comment has been updated', 0, 0, 0),
(649, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Comment could not be updated. Please, try again.', 'User Comment could not be updated. Please, try again.', 0, 0, 0),
(650, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Comment deleted', 'User Comment deleted', 0, 0, 0),
(651, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Accepted', 'Accepted', 0, 0, 0),
(652, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Friends', 'Friends', 0, 0, 0),
(653, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Add User Friend', 'Add User Friend', 0, 0, 0),
(654, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, '%s is blocked you. You can not become friend of %s', '%s is blocked you. You can not become friend of %s', 0, 0, 0),
(655, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'You cannot add this user as a friend', 'You cannot add this user as a friend', 0, 0, 0),
(656, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Friend has been added.', 'Friend has been added.', 0, 0, 0),
(657, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Already added in your friend''s list.', 'Already added in your friend''s list.', 0, 0, 0),
(658, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'You can''t yourself to friend''s list.', 'You can''t yourself to friend''s list.', 0, 0, 0),
(659, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Friend deleted', 'User Friend deleted', 0, 0, 0),
(660, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Friend', 'User Friend', 0, 0, 0),
(661, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, '\\"%s\\" User Friend has been added', '\\"%s\\" User Friend has been added', 0, 0, 0),
(662, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, '\\"%s\\" User Friend could not be added. Please, try again.', '\\"%s\\" User Friend could not be added. Please, try again.', 0, 0, 0),
(663, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Edit User Friend', 'Edit User Friend', 0, 0, 0),
(664, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, '\\"%s\\" User Friend has been updated', '\\"%s\\" User Friend has been updated', 0, 0, 0),
(665, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, '\\"%s\\" User Friend could not be updated. Please, try again.', '\\"%s\\" User Friend could not be updated. Please, try again.', 0, 0, 0),
(666, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Checked users has been %s', 'Checked users has been %s', 0, 0, 0),
(667, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Friends Import', 'Friends Import', 0, 0, 0),
(668, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Plesae select a valid CSV file', 'Plesae select a valid CSV file', 0, 0, 0),
(669, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Friends Import Failed. Plesase Try Again', 'Friends Import Failed. Plesase Try Again', 0, 0, 0),
(670, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'MSN Contact Import Not working. Please Contact Admin.', 'MSN Contact Import Not working. Please Contact Admin.', 0, 0, 0),
(671, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Your friend has been invited.', 'Your friend has been invited.', 0, 0, 0),
(672, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Invite Friend', 'Invite Friend', 0, 0, 0),
(673, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Problem in inviting.', 'Problem in inviting.', 0, 0, 0),
(674, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Invite your friends for the item', 'Invite your friends for the item', 0, 0, 0),
(675, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Please select atleast one friend before inviting', 'Please select atleast one friend before inviting', 0, 0, 0),
(676, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest Comments', 'Interest Comments', 0, 0, 0),
(677, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest Comment', 'Interest Comment', 0, 0, 0),
(678, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Add Interest Comment', 'Add Interest Comment', 0, 0, 0),
(679, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest Comment has been added', 'Interest Comment has been added', 0, 0, 0),
(680, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest Comment could not be added. Please, try again.', 'Interest Comment could not be added. Please, try again.', 0, 0, 0),
(681, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Edit Interest Comment', 'Edit Interest Comment', 0, 0, 0),
(682, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest Comment has been updated', 'Interest Comment has been updated', 0, 0, 0),
(683, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest Comment could not be updated. Please, try again.', 'Interest Comment could not be updated. Please, try again.', 0, 0, 0),
(684, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest Comment deleted', 'Interest Comment deleted', 0, 0, 0),
(685, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest has added ', 'Interest has added ', 0, 0, 0),
(686, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest deleted', 'Interest deleted', 0, 0, 0),
(687, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest Followers', 'Interest Followers', 0, 0, 0),
(688, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest', 'Interest', 0, 0, 0),
(689, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest - ', 'Interest - ', 0, 0, 0),
(690, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Add Interest', 'Add Interest', 0, 0, 0),
(691, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest has been added', 'Interest has been added', 0, 0, 0),
(692, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest could not be added. Please, try again.', 'Interest could not be added. Please, try again.', 0, 0, 0),
(693, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interests', 'Interests', 0, 0, 0),
(694, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Edit Interest', 'Edit Interest', 0, 0, 0),
(695, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Invalid interest', 'Invalid interest', 0, 0, 0),
(696, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest has been updated', 'Interest has been updated', 0, 0, 0),
(697, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest could not be updated. Please, try again.', 'Interest could not be updated. Please, try again.', 0, 0, 0),
(698, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Interest  deleted', 'Interest  deleted', 0, 0, 0),
(699, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Jobs', 'User Jobs', 0, 0, 0),
(700, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Add User Job', 'Add User Job', 0, 0, 0),
(701, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'user job has been added', 'user job has been added', 0, 0, 0),
(702, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'user job could not be added. Please, try again.', 'user job could not be added. Please, try again.', 0, 0, 0),
(703, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Edit User Job', 'Edit User Job', 0, 0, 0),
(704, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Invalid user job', 'Invalid user job', 0, 0, 0),
(705, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'user job has been updated', 'user job has been updated', 0, 0, 0),
(706, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'user job could not be updated. Please, try again.', 'user job could not be updated. Please, try again.', 0, 0, 0),
(707, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User job deleted', 'User job deleted', 0, 0, 0),
(708, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Logins', 'User Logins', 0, 0, 0),
(709, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Login deleted', 'User Login deleted', 0, 0, 0),
(710, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Checked user logins has been deleted', 'Checked user logins has been deleted', 0, 0, 0),
(711, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'My Notifications', 'My Notifications', 0, 0, 0),
(712, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User notification has been updated', 'User notification has been updated', 0, 0, 0),
(713, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User notification could not be updated. Please, try again.', 'User notification could not be updated. Please, try again.', 0, 0, 0),
(714, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Openids', 'User Openids', 0, 0, 0),
(715, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Add New Openid', 'Add New Openid', 0, 0, 0),
(716, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Authenticated failed or you may not have profile in your OpenID account', 'Authenticated failed or you may not have profile in your OpenID account', 0, 0, 0),
(717, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Openid has been added', 'User Openid has been added', 0, 0, 0),
(718, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Openid could not be added. Please, try again.', 'User Openid could not be added. Please, try again.', 0, 0, 0),
(719, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Invalid OpenID', 'Invalid OpenID', 0, 0, 0),
(720, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Openid deleted', 'User Openid deleted', 0, 0, 0),
(721, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Sorry, you registered through OpenID account. So you should have atleast one OpenID account for login', 'Sorry, you registered through OpenID account. So you should have atleast one OpenID account for login', 0, 0, 0),
(722, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Credit Cards', 'Credit Cards', 0, 0, 0),
(723, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Add New Credit Card', 'Add New Credit Card', 0, 0, 0),
(724, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Invalid expire date', 'Invalid expire date', 0, 0, 0),
(725, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Edit Credit Card', 'Edit Credit Card', 0, 0, 0),
(726, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Credit card has been updated.', 'Credit card has been updated.', 0, 0, 0),
(727, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Credit card deleted', 'Credit card deleted', 0, 0, 0),
(728, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Credit card could not be deleted. Please, try again.', 'Credit card could not be deleted. Please, try again.', 0, 0, 0),
(729, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Credit card set as default successfully', 'Credit card set as default successfully', 0, 0, 0),
(730, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Edit Profile', 'Edit Profile', 0, 0, 0),
(731, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Profile has been updated', 'User Profile has been updated', 0, 0, 0),
(732, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'The file uploaded is too big, only files less than %s permitted', 'The file uploaded is too big, only files less than %s permitted', 0, 0, 0),
(733, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Profile could not be updated. Please, try again.', 'User Profile could not be updated. Please, try again.', 0, 0, 0),
(734, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'My Account', 'My Account', 0, 0, 0),
(735, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'My Profile', 'My Profile', 0, 0, 0),
(736, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'School Degrees', 'School Degrees', 0, 0, 0),
(737, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Add School Degree', 'Add School Degree', 0, 0, 0),
(738, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User school degree has been added', 'User school degree has been added', 0, 0, 0),
(739, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User school degree could not be added. Please, try again.', 'User school degree could not be added. Please, try again.', 0, 0, 0),
(740, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Edit School Degree', 'Edit School Degree', 0, 0, 0),
(741, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Invalid user school degree', 'Invalid user school degree', 0, 0, 0),
(742, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User school degree has been updated', 'User school degree has been updated', 0, 0, 0),
(743, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User school degree could not be updated. Please, try again.', 'User school degree could not be updated. Please, try again.', 0, 0, 0),
(744, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User school degree  deleted', 'User school degree  deleted', 0, 0, 0),
(745, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Schools', 'User Schools', 0, 0, 0),
(746, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Add User School', 'Add User School', 0, 0, 0),
(747, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'user school has been added', 'user school has been added', 0, 0, 0),
(748, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'user school could not be added. Please, try again.', 'user school could not be added. Please, try again.', 0, 0, 0),
(749, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Edit User School', 'Edit User School', 0, 0, 0),
(750, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'Invalid user school', 'Invalid user school', 0, 0, 0),
(751, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'user school has been updated', 'user school has been updated', 0, 0, 0),
(752, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'user school could not be updated. Please, try again.', 'user school could not be updated. Please, try again.', 0, 0, 0),
(753, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User School deleted', 'User School deleted', 0, 0, 0),
(754, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User school  deleted', 'User school  deleted', 0, 0, 0),
(755, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Views', 'User Views', 0, 0, 0),
(756, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User View deleted', 'User View deleted', 0, 0, 0),
(757, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'You have successfully activated your account. Now you can login with your %s.', 'You have successfully activated your account. Now you can login with your %s.', 0, 0, 0),
(758, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User', 'User', 0, 0, 0),
(759, '2012-03-06 17:37:02', '2012-03-06 17:37:02', 42, 'User Registration', 'User Registration', 0, 0, 0),
(760, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Your registration process is not completed. Please, try again.', 'Your registration process is not completed. Please, try again.', 0, 0, 0),
(761, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'You have successfully registered with our site.', 'You have successfully registered with our site.', 0, 0, 0),
(762, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'You have successfully registered with our site and your activation mail has been sent to your mail inbox.', 'You have successfully registered with our site and your activation mail has been sent to your mail inbox.', 0, 0, 0),
(763, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'verification is completed successfully. But you have to fill the following required fields to complete our registration process.', 'verification is completed successfully. But you have to fill the following required fields to complete our registration process.', 0, 0, 0),
(764, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Profile Image', 'Profile Image', 0, 0, 0),
(765, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'User Profile Image has been updated', 'User Profile Image has been updated', 0, 0, 0),
(766, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Connect', 'Connect', 0, 0, 0),
(767, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'You have successfully disconnected with facebook.', 'You have successfully disconnected with facebook.', 0, 0, 0),
(768, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'You have successfully disconnected with twitter.', 'You have successfully disconnected with twitter.', 0, 0, 0),
(769, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, ' - Registered through FaceBook ', ' - Registered through FaceBook ', 0, 0, 0),
(770, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, ' - Admin ', ' - Admin ', 0, 0, 0),
(771, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, ' - All ', ' - All ', 0, 0, 0),
(772, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Username', 'Username', 0, 0, 0),
(773, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Email', 'Email', 0, 0, 0),
(774, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Login count', 'Login count', 0, 0, 0),
(775, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Referred User', 'Referred User', 0, 0, 0),
(776, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Email Confirmed', 'Email Confirmed', 0, 0, 0),
(777, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Yes', 'Yes', 0, 0, 0),
(778, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'No', 'No', 0, 0, 0),
(779, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Signup IP', 'Signup IP', 0, 0, 0),
(780, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Created on', 'Created on', 0, 0, 0),
(781, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Available balance amount', 'Available balance amount', 0, 0, 0),
(782, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Referrer username does not exist.', 'Referrer username does not exist.', 0, 0, 0),
(783, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Activate your account', 'Activate your account', 0, 0, 0),
(784, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Invalid activation request, please register again', 'Invalid activation request, please register again', 0, 0, 0),
(785, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Invalid activation request', 'Invalid activation request', 0, 0, 0),
(786, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'You have successfully activated your account. But you can login after admin activate your account.', 'You have successfully activated your account. But you can login after admin activate your account.', 0, 0, 0),
(787, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'You have successfully activated and logged in to your account.', 'You have successfully activated and logged in to your account.', 0, 0, 0),
(788, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Activation mail has been resent.', 'Activation mail has been resent.', 0, 0, 0),
(789, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'A Mail for activating your account has been sent.', 'A Mail for activating your account has been sent.', 0, 0, 0),
(790, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Try some time later as mail could not be dispatched due to some error in the server', 'Try some time later as mail could not be dispatched due to some error in the server', 0, 0, 0),
(791, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Problem in Facebook connect. Please try again', 'Problem in Facebook connect. Please try again', 0, 0, 0),
(792, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'An account already exists with this Facebook Login.', 'An account already exists with this Facebook Login.', 0, 0, 0);
INSERT INTO `translations` (`id`, `created`, `modified`, `language_id`, `key`, `lang_text`, `is_translated`, `is_google_translate`, `is_verified`) VALUES
(793, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Your profile has been updated', 'Your profile has been updated', 0, 0, 0),
(794, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Sorry, login failed.  Your account has been blocked', 'Sorry, login failed.  Your account has been blocked', 0, 0, 0),
(795, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Login', 'Login', 0, 0, 0),
(796, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Enter valid OpenID', 'Enter valid OpenID', 0, 0, 0),
(797, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Your Foursquare credentials are updated', 'Your Foursquare credentials are updated', 0, 0, 0),
(798, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'An account already exists with this Foursquare Login.', 'An account already exists with this Foursquare Login.', 0, 0, 0),
(799, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Problem in Twitter connect. Please try again', 'Problem in Twitter connect. Please try again', 0, 0, 0),
(800, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Your Twitter credentials are updated', 'Your Twitter credentials are updated', 0, 0, 0),
(801, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'An account already exists with this Twitter Login.', 'An account already exists with this Twitter Login.', 0, 0, 0),
(802, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'You are now logged out of the site.', 'You are now logged out of the site.', 0, 0, 0),
(803, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Forgot Password', 'Forgot Password', 0, 0, 0),
(804, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'An email has been sent with a link where you can change your password', 'An email has been sent with a link where you can change your password', 0, 0, 0),
(805, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'There is no user registered with the email %s or admin deactivated your account. If you spelled the address incorrectly or entered the wrong address, please try again.', 'There is no user registered with the email %s or admin deactivated your account. If you spelled the address incorrectly or entered the wrong address, please try again.', 0, 0, 0),
(806, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Please Enter valid Email id', 'Please Enter valid Email id', 0, 0, 0),
(807, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Reset Password', 'Reset Password', 0, 0, 0),
(808, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Your password changed successfully, Please login now', 'Your password changed successfully, Please login now', 0, 0, 0),
(809, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Could not update your password, please enter password.', 'Could not update your password, please enter password.', 0, 0, 0),
(810, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Invalid change password request', 'Invalid change password request', 0, 0, 0),
(811, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'User cannot be found in server or admin deactivated your account, please register again', 'User cannot be found in server or admin deactivated your account, please register again', 0, 0, 0),
(812, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Change Password', 'Change Password', 0, 0, 0),
(813, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Your password changed successfully. Please login now', 'Your password changed successfully. Please login now', 0, 0, 0),
(814, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, '%s ''s password changed successfully.', '%s ''s password changed successfully.', 0, 0, 0),
(815, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Your password changed successfully', 'Your password changed successfully', 0, 0, 0),
(816, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Password could not be changed', 'Password could not be changed', 0, 0, 0),
(817, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Sorry. You Cannot Update the password in Demo Mode', 'Sorry. You Cannot Update the password in Demo Mode', 0, 0, 0),
(818, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Users', 'Users', 0, 0, 0),
(819, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, ' - Registered Yesterday', ' - Registered Yesterday', 0, 0, 0),
(820, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, ' - Affiliate users', ' - Affiliate users', 0, 0, 0),
(821, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, ' - Registered through Foursquare ', ' - Registered through Foursquare ', 0, 0, 0),
(822, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, ' - Registered through Site ', ' - Registered through Site ', 0, 0, 0),
(823, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Add New User/Admin', 'Add New User/Admin', 0, 0, 0),
(824, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'User has been added', 'User has been added', 0, 0, 0),
(825, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'User could not be added. Please, try again.', 'User could not be added. Please, try again.', 0, 0, 0),
(826, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'User deleted', 'User deleted', 0, 0, 0),
(827, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Checked users has been inactivated', 'Checked users has been inactivated', 0, 0, 0),
(828, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Checked users has been activated', 'Checked users has been activated', 0, 0, 0),
(829, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Checked users has been deleted', 'Checked users has been deleted', 0, 0, 0),
(830, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Checked users has been set to display in home', 'Checked users has been set to display in home', 0, 0, 0),
(831, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Checked users has been unset to display in home', 'Checked users has been unset to display in home', 0, 0, 0),
(832, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Checked merchants profile has been enabled', 'Checked merchants profile has been enabled', 0, 0, 0),
(833, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Snapshot', 'Snapshot', 0, 0, 0),
(834, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Add Amount to Wallet', 'Add Amount to Wallet', 0, 0, 0),
(835, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Add amount to wallet', 'Add amount to wallet', 0, 0, 0),
(836, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'wallet', 'wallet', 0, 0, 0),
(837, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Your amount can not be added. Please, try again.', 'Your amount can not be added. Please, try again.', 0, 0, 0),
(838, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Amount added in wallet successfully.', 'Amount added in wallet successfully.', 0, 0, 0),
(839, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Transaction failure. Please try once again. ', 'Transaction failure. Please try once again. ', 0, 0, 0),
(840, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Error in payment', 'Error in payment', 0, 0, 0),
(841, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Your payment has been successfully transferred.', 'Your payment has been successfully transferred.', 0, 0, 0),
(842, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'My Stuff', 'My Stuff', 0, 0, 0),
(843, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'My API', 'My API', 0, 0, 0),
(844, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Add Fund', 'Add Fund', 0, 0, 0),
(845, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Fund has been added successfully', 'Fund has been added successfully', 0, 0, 0),
(846, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Fund could not be added. Please, try again.', 'Fund could not be added. Please, try again.', 0, 0, 0),
(847, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Deduct Fund', 'Deduct Fund', 0, 0, 0),
(848, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Deduct amount should be less than the available balance amount', 'Deduct amount should be less than the available balance amount', 0, 0, 0),
(849, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Fund has been deducted successfully', 'Fund has been deducted successfully', 0, 0, 0),
(850, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Fund could not be deducted. Please, try again.', 'Fund could not be deducted. Please, try again.', 0, 0, 0),
(851, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Invalid Facebook Connection.', 'Invalid Facebook Connection.', 0, 0, 0),
(852, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Diagnostics', 'Diagnostics', 0, 0, 0),
(853, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Referrals', 'Referrals', 0, 0, 0),
(854, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Email recovery is not properly informed', 'Email recovery is not properly informed', 0, 0, 0),
(855, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Should be numeric', 'Should be numeric', 0, 0, 0),
(856, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Approved...', 'Approved...', 0, 0, 0),
(857, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Given amount is greater than your commission amount', 'Given amount is greater than your commission amount', 0, 0, 0),
(858, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'Given amount is less than withdraw limit', 'Given amount is less than withdraw limit', 0, 0, 0),
(859, '2012-03-06 17:37:03', '2012-03-06 17:37:03', 42, 'one the selected withdrawal has not configured the money transfer account. Please try again', 'one the selected withdrawal has not configured the money transfer account. Please try again', 0, 0, 0),
(860, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Enter valid URL', 'Enter valid URL', 0, 0, 0),
(861, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Approve', 'Approve', 0, 0, 0),
(862, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Disapprove', 'Disapprove', 0, 0, 0),
(863, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Inactive', 'Inactive', 0, 0, 0),
(864, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Active', 'Active', 0, 0, 0),
(865, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Enter number higher than 0', 'Enter number higher than 0', 0, 0, 0),
(866, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'You cannot add your own domain in redirect URL', 'You cannot add your own domain in redirect URL', 0, 0, 0),
(867, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Must be a valid URL, starting with http://', 'Must be a valid URL, starting with http://', 0, 0, 0),
(868, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Single IP or hostname', 'Single IP or hostname', 0, 0, 0),
(869, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'IP Range', 'IP Range', 0, 0, 0),
(870, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Referer block', 'Referer block', 0, 0, 0),
(871, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Permanent', 'Permanent', 0, 0, 0),
(872, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Day(s)', 'Day(s)', 0, 0, 0),
(873, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Week(s)', 'Week(s)', 0, 0, 0),
(874, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Pay to Charity...', 'Pay to Charity...', 0, 0, 0),
(875, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'should be less than or equal to available amount', 'should be less than or equal to available amount', 0, 0, 0),
(876, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Pay Via', 'Pay Via', 0, 0, 0),
(877, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Mass Pay API', 'Mass Pay API', 0, 0, 0),
(878, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Must be a valid email', 'Must be a valid email', 0, 0, 0),
(879, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Unapproved', 'Unapproved', 0, 0, 0),
(880, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Please enter valid captcha', 'Please enter valid captcha', 0, 0, 0),
(881, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Give numeric format', 'Give numeric format', 0, 0, 0),
(882, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Should be greater than 0', 'Should be greater than 0', 0, 0, 0),
(883, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Should be a number', 'Should be a number', 0, 0, 0),
(884, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Maximum limit should be greater than or equal to minimum limit', 'Maximum limit should be greater than or equal to minimum limit', 0, 0, 0),
(885, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Should be greater than or equal to', 'Should be greater than or equal to', 0, 0, 0),
(886, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Should be equal to', 'Should be equal to', 0, 0, 0),
(887, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Must be between of 1 to 100', 'Must be between of 1 to 100', 0, 0, 0),
(888, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Quantity is more than the maximum quantity.', 'Quantity is more than the maximum quantity.', 0, 0, 0),
(889, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'You can''t buy this quantity.', 'You can''t buy this quantity.', 0, 0, 0),
(890, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Quantity is less than the minimum quantity.', 'Quantity is less than the minimum quantity.', 0, 0, 0),
(891, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'End date should be greater than today', 'End date should be greater than today', 0, 0, 0),
(892, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Event date should be greater than end date', 'Event date should be greater than end date', 0, 0, 0),
(893, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Event date should be greater than today', 'Event date should be greater than today', 0, 0, 0),
(894, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Charity Amount cannot be zero', 'Charity Amount cannot be zero', 0, 0, 0),
(895, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Item Payment', 'Item Payment', 0, 0, 0),
(896, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Pass code', 'Pass code', 0, 0, 0),
(897, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Payment pending', 'Payment pending', 0, 0, 0),
(898, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Top code', 'Top code', 0, 0, 0),
(899, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Bottom code', 'Bottom code', 0, 0, 0),
(900, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Item Payment refund', 'Item Payment refund', 0, 0, 0),
(901, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'End Date:', 'End Date:', 0, 0, 0),
(902, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'If you do not wish to receive these messages in the future, please', 'If you do not wish to receive these messages in the future, please', 0, 0, 0),
(903, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Labels already exist.', 'Labels already exist.', 0, 0, 0),
(904, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, ' Masspay not completed. Please try again', ' Masspay not completed. Please try again', 0, 0, 0),
(905, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Enable Profile', 'Enable Profile', 0, 0, 0),
(906, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Disable Profile', 'Disable Profile', 0, 0, 0),
(907, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Activate', 'Activate', 0, 0, 0),
(908, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Deactivate', 'Deactivate', 0, 0, 0),
(909, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Test Mode', 'Test Mode', 0, 0, 0),
(910, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Live Mode', 'Live Mode', 0, 0, 0),
(911, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Auto Approved', 'Auto Approved', 0, 0, 0),
(912, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Non Auto Approved', 'Non Auto Approved', 0, 0, 0),
(913, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Please enter valid email address', 'Please enter valid email address', 0, 0, 0),
(914, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'No Action', 'No Action', 0, 0, 0),
(915, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Add as friend', 'Add as friend', 0, 0, 0),
(916, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Remove', 'Remove', 0, 0, 0),
(917, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Invite', 'Invite', 0, 0, 0),
(918, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Should be greater than or equal to 0', 'Should be greater than or equal to 0', 0, 0, 0),
(919, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Require numeric value', 'Require numeric value', 0, 0, 0),
(920, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Must be between of 3 to 20 characters', 'Must be between of 3 to 20 characters', 0, 0, 0),
(921, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Must be a valid character', 'Must be a valid character', 0, 0, 0),
(922, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Username is already exist', 'Username is already exist', 0, 0, 0),
(923, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Must be start with an alphabets', 'Must be start with an alphabets', 0, 0, 0),
(924, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Email address is already exist', 'Email address is already exist', 0, 0, 0),
(925, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Must be at least 6 characters', 'Must be at least 6 characters', 0, 0, 0),
(926, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Your old password is incorrect, please try again', 'Your old password is incorrect, please try again', 0, 0, 0),
(927, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'New and confirm password field must match, please try again', 'New and confirm password field must match, please try again', 0, 0, 0),
(928, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'You must agree to the terms and policies', 'You must agree to the terms and policies', 0, 0, 0),
(929, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Export', 'Export', 0, 0, 0),
(930, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'All Users', 'All Users', 0, 0, 0),
(931, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Inactive Users', 'Inactive Users', 0, 0, 0),
(932, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Active Users', 'Active Users', 0, 0, 0),
(933, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Amount should be Numeric', 'Amount should be Numeric', 0, 0, 0),
(934, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Amount should be greater than minimum amount', 'Amount should be greater than minimum amount', 0, 0, 0),
(935, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Given amount should lies from  %s%s to %s%s', 'Given amount should lies from  %s%s to %s%s', 0, 0, 0),
(936, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Given amount is greater than wallet amount', 'Given amount is greater than wallet amount', 0, 0, 0),
(937, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Must be in numeric', 'Must be in numeric', 0, 0, 0),
(938, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Reject', 'Reject', 0, 0, 0),
(939, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Interest name is already exist', 'Interest name is already exist', 0, 0, 0),
(940, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'OpenID already exist', 'OpenID already exist', 0, 0, 0),
(941, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Must be a valid date', 'Must be a valid date', 0, 0, 0),
(942, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'DOB should be lesser than current date', 'DOB should be lesser than current date', 0, 0, 0),
(943, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Affiliate Cash Withdrawals', 'Affiliate Cash Withdrawals', 0, 0, 0),
(944, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Generate Affiliate Widget', 'Generate Affiliate Widget', 0, 0, 0),
(945, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'The requested amount will be deducted from your affiliate commission amount and the amount will be blocked until it get approved or rejected by the administrator. Once it''s approved, the requested amount will be sent to your paypal account. In case of failure, the amount will be refunded to your affiliate commission amount.', 'The requested amount will be deducted from your affiliate commission amount and the amount will be blocked until it get approved or rejected by the administrator. Once it''s approved, the requested amount will be sent to your paypal account. In case of failure, the amount will be refunded to your affiliate commission amount.', 0, 0, 0),
(946, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Transaction Fee', 'Transaction Fee', 0, 0, 0),
(947, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Minimum withdraw amount: %s <br/>  Commission amount: %s  %s', 'Minimum withdraw amount: %s <br/>  Commission amount: %s  %s', 0, 0, 0),
(948, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Request Withdraw', 'Request Withdraw', 0, 0, 0),
(949, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Affiliate module is currently enabled. You can disable or configure it from', 'Affiliate module is currently enabled. You can disable or configure it from', 0, 0, 0),
(950, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, ' page', ' page', 0, 0, 0),
(951, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Failed', 'Failed', 0, 0, 0),
(952, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Under Process', 'Under Process', 0, 0, 0),
(953, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Following withdrawal request has been submitted to payment geteway API, These are waiting for IPN from the payment geteway API. Eiether it will move to Success or Failed', 'Following withdrawal request has been submitted to payment geteway API, These are waiting for IPN from the payment geteway API. Eiether it will move to Success or Failed', 0, 0, 0),
(954, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Withdrawal fund frequest which were unable to process will be returned as failed. The amount requested will be automatically refunded to the user.', 'Withdrawal fund frequest which were unable to process will be returned as failed. The amount requested will be automatically refunded to the user.', 0, 0, 0),
(955, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Transfer Account: ', 'Transfer Account: ', 0, 0, 0),
(956, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Action', 'Action', 0, 0, 0),
(957, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Requested on', 'Requested on', 0, 0, 0),
(958, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Paid on', 'Paid on', 0, 0, 0),
(959, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Status', 'Status', 0, 0, 0),
(960, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Move to success', 'Move to success', 0, 0, 0),
(961, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Move to failed', 'Move to failed', 0, 0, 0),
(962, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'No records available', 'No records available', 0, 0, 0),
(963, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Select:', 'Select:', 0, 0, 0),
(964, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'None', 'None', 0, 0, 0),
(965, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, '-- More actions --', '-- More actions --', 0, 0, 0),
(966, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Gateway', 'Gateway', 0, 0, 0),
(967, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Paid Amount', 'Paid Amount', 0, 0, 0),
(968, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Proceed', 'Proceed', 0, 0, 0),
(969, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Your money transfer account is empty, so click here to update your money transfer account.', 'Your money transfer account is empty, so click here to update your money transfer account.', 0, 0, 0),
(970, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Edit money transfer accounts', 'Edit money transfer accounts', 0, 0, 0),
(971, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Requested On', 'Requested On', 0, 0, 0),
(972, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'No withdraw requests available', 'No withdraw requests available', 0, 0, 0),
(973, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Your request will be confirmed after admin approval.', 'Your request will be confirmed after admin approval.', 0, 0, 0),
(974, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Sorry, admin declined your request. If you want submit once again please', 'Sorry, admin declined your request. If you want submit once again please', 0, 0, 0),
(975, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Click Here', 'Click Here', 0, 0, 0),
(976, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'This request will be confirmed after admin approval.', 'This request will be confirmed after admin approval.', 0, 0, 0),
(977, '2012-03-06 17:37:04', '2012-03-06 17:37:04', 42, 'Site Name', 'Site Name', 0, 0, 0),
(978, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Site Description', 'Site Description', 0, 0, 0),
(979, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Site URL', 'Site URL', 0, 0, 0),
(980, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Why Do You Want an Affiliate?', 'Why Do You Want an Affiliate?', 0, 0, 0),
(981, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Web Site Marketing?', 'Web Site Marketing?', 0, 0, 0),
(982, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Search Engine Marketing?', 'Search Engine Marketing?', 0, 0, 0),
(983, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Email Marketing?', 'Email Marketing?', 0, 0, 0),
(984, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Special Promotional Method', 'Special Promotional Method', 0, 0, 0),
(985, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Special Promotional Description', 'Special Promotional Description', 0, 0, 0),
(986, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Request', 'Request', 0, 0, 0),
(987, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Approved?', 'Approved?', 0, 0, 0),
(988, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Add', 'Add', 0, 0, 0),
(989, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Update', 'Update', 0, 0, 0),
(990, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Waiting for Approval', 'Waiting for Approval', 0, 0, 0),
(991, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Keyword', 'Keyword', 0, 0, 0),
(992, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Search', 'Search', 0, 0, 0),
(993, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Actions', 'Actions', 0, 0, 0),
(994, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Site', 'Site', 0, 0, 0),
(995, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Why Do You Want Affiliate', 'Why Do You Want Affiliate', 0, 0, 0),
(996, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Website Marketing?', 'Website Marketing?', 0, 0, 0),
(997, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Email Marketing', 'Email Marketing', 0, 0, 0),
(998, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Promotional Method', 'Promotional Method', 0, 0, 0),
(999, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Edit', 'Edit', 0, 0, 0),
(1000, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'No Affiliate Requests available', 'No Affiliate Requests available', 0, 0, 0),
(1001, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Name', 'Name', 0, 0, 0),
(1002, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Commission', 'Commission', 0, 0, 0),
(1003, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Commission Type', 'Commission Type', 0, 0, 0),
(1004, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Active?', 'Active?', 0, 0, 0),
(1005, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'No Affiliate Types available', 'No Affiliate Types available', 0, 0, 0),
(1006, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'content', 'content', 0, 0, 0),
(1007, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Widget Logo', 'Widget Logo', 0, 0, 0),
(1008, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Created On', 'Created On', 0, 0, 0),
(1009, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Logo', 'Logo', 0, 0, 0),
(1010, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'No Affiliate Widget Sizes available', 'No Affiliate Widget Sizes available', 0, 0, 0),
(1011, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Affiliate  Requests', 'Affiliate  Requests', 0, 0, 0),
(1012, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Affiliate Fund Withdrawal Requests', 'Affiliate Fund Withdrawal Requests', 0, 0, 0),
(1013, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Widgets', 'Widgets', 0, 0, 0),
(1014, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Commission History', 'Commission History', 0, 0, 0),
(1015, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Created', 'Created', 0, 0, 0),
(1016, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Affiliate User', 'Affiliate User', 0, 0, 0),
(1017, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Type', 'Type', 0, 0, 0),
(1018, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Since', 'Since', 0, 0, 0),
(1019, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'No commission history available', 'No commission history available', 0, 0, 0),
(1020, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Click to View Details', 'Click to View Details', 0, 0, 0),
(1021, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Affiliate Cash Withdrawal Requests', 'Affiliate Cash Withdrawal Requests', 0, 0, 0),
(1022, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, '1. Customize your widget', '1. Customize your widget', 0, 0, 0),
(1023, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Make your widget fit right in on your site with custom sizes, colors and relevant items.', 'Make your widget fit right in on your site with custom sizes, colors and relevant items.', 0, 0, 0),
(1024, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Choose an ad size', 'Choose an ad size', 0, 0, 0),
(1025, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Customize your ad accent color', 'Customize your ad accent color', 0, 0, 0),
(1026, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Choose a city', 'Choose a city', 0, 0, 0),
(1027, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, '2. Generate your widget', '2. Generate your widget', 0, 0, 0),
(1028, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Just click the \\"Generate widget\\" button below to preview and generate your widget code. Simply paste the generated code into your webpage and start making money.', 'Just click the \\"Generate widget\\" button below to preview and generate your widget code. Simply paste the generated code into your webpage and start making money.', 0, 0, 0),
(1029, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Generate Widget', 'Generate Widget', 0, 0, 0),
(1030, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Share your below unique link for referral purposes', 'Share your below unique link for referral purposes', 0, 0, 0),
(1031, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Share your below unique link by appending to end of site URL for referral', 'Share your below unique link by appending to end of site URL for referral', 0, 0, 0),
(1032, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Preview', 'Preview', 0, 0, 0),
(1033, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Transaction Id', 'Transaction Id', 0, 0, 0),
(1034, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Authorize amt', 'Authorize amt', 0, 0, 0),
(1035, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Authorize avscode', 'Authorize avscode', 0, 0, 0),
(1036, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Authorize Authorization Code', 'Authorize Authorization Code', 0, 0, 0),
(1037, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Authorize Response Text', 'Authorize Response Text', 0, 0, 0),
(1038, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Authorize Response', 'Authorize Response', 0, 0, 0),
(1039, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'View', 'View', 0, 0, 0),
(1040, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'No Authorizenet Docapture Logs available', 'No Authorizenet Docapture Logs available', 0, 0, 0),
(1041, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Payment Status', 'Payment Status', 0, 0, 0),
(1042, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Authorize Amt', 'Authorize Amt', 0, 0, 0),
(1043, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Authorize Avscode', 'Authorize Avscode', 0, 0, 0),
(1044, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Current User Information', 'Current User Information', 0, 0, 0),
(1045, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Your IP: ', 'Your IP: ', 0, 0, 0),
(1046, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Your Hostname: ', 'Your Hostname: ', 0, 0, 0),
(1047, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Ban Type', 'Ban Type', 0, 0, 0),
(1048, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Select method', 'Select method', 0, 0, 0),
(1049, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Address/Range', 'Address/Range', 0, 0, 0),
(1050, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, '(IP address, domain or hostname)', '(IP address, domain or hostname)', 0, 0, 0),
(1051, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Possibilities:', 'Possibilities:', 0, 0, 0),
(1052, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, '- Single IP/Hostname: Fill in either a hostname or IP address in the first field.', '- Single IP/Hostname: Fill in either a hostname or IP address in the first field.', 0, 0, 0),
(1053, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, '- IP Range: Put the starting IP address in the left and the ending IP address in the right field.', '- IP Range: Put the starting IP address in the left and the ending IP address in the right field.', 0, 0, 0),
(1054, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, '- Referer block: To block google.com put google.com in the first field. To block google altogether.', '- Referer block: To block google.com put google.com in the first field. To block google altogether.', 0, 0, 0),
(1055, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Ban Details', 'Ban Details', 0, 0, 0),
(1056, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Reason', 'Reason', 0, 0, 0),
(1057, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, '(optional, shown to victim)', '(optional, shown to victim)', 0, 0, 0),
(1058, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Redirect', 'Redirect', 0, 0, 0),
(1059, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, '(optional)', '(optional)', 0, 0, 0),
(1060, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'How long', 'How long', 0, 0, 0),
(1061, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Leave field empty when using permanent. Fill in a number higher than 0 when using another option!', 'Leave field empty when using permanent. Fill in a number higher than 0 when using another option!', 0, 0, 0),
(1062, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Hints and tips:', 'Hints and tips:', 0, 0, 0),
(1063, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, '- Banning hosts in the 10.x.x.x / 169.254.x.x / 172.16.x.x or 192.168.x.x range probably won''t work.', '- Banning hosts in the 10.x.x.x / 169.254.x.x / 172.16.x.x or 192.168.x.x range probably won''t work.', 0, 0, 0),
(1064, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, '- Banning by internet hostname might work unexpectedly and resulting in banning multiple people from the same ISP!', '- Banning by internet hostname might work unexpectedly and resulting in banning multiple people from the same ISP!', 0, 0, 0),
(1065, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, '- Wildcards on IP addresses are allowed. Block 84.234.*.* to block the whole 84.234.x.x range!', '- Wildcards on IP addresses are allowed. Block 84.234.*.* to block the whole 84.234.x.x range!', 0, 0, 0),
(1066, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, '- Setting a ban on a range of IP addresses might work unexpected and can result in false positives!', '- Setting a ban on a range of IP addresses might work unexpected and can result in false positives!', 0, 0, 0),
(1067, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, '- An IP address always contains 4 parts with numbers no higher than 254 separated by a dot!', '- An IP address always contains 4 parts with numbers no higher than 254 separated by a dot!', 0, 0, 0),
(1068, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, '- If a ban does not seem to work try to find out if the person you''re trying to ban doesn''t use <a href=\\"http://en.wikipedia.org/wiki/DHCP\\" target=\\"_blank\\" title=\\"DHCP\\">DHCP.</a>', '- If a ban does not seem to work try to find out if the person you''re trying to ban doesn''t use <a href=\\"http://en.wikipedia.org/wiki/DHCP\\" target=\\"_blank\\" title=\\"DHCP\\">DHCP.</a>', 0, 0, 0),
(1069, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Cancel', 'Cancel', 0, 0, 0),
(1070, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Select', 'Select', 0, 0, 0),
(1071, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Victims', 'Victims', 0, 0, 0),
(1072, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Redirect to', 'Redirect to', 0, 0, 0),
(1073, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Date Set', 'Date Set', 0, 0, 0),
(1074, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Expiry Date', 'Expiry Date', 0, 0, 0),
(1075, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Never', 'Never', 0, 0, 0),
(1076, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'No Banned IPs available', 'No Banned IPs available', 0, 0, 0),
(1077, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Blocked User', 'Blocked User', 0, 0, 0),
(1078, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'user', 'user', 0, 0, 0),
(1079, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Blocked user', 'Blocked user', 0, 0, 0),
(1080, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Please Select', 'Please Select', 0, 0, 0),
(1081, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'No Blocked Users available', 'No Blocked Users available', 0, 0, 0),
(1082, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Id', 'Id', 0, 0, 0),
(1083, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Modified', 'Modified', 0, 0, 0),
(1084, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Blocked', 'Blocked', 0, 0, 0),
(1085, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'No blocked users available', 'No blocked users available', 0, 0, 0),
(1086, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Charity Category', 'Charity Category', 0, 0, 0),
(1087, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Select Category', 'Select Category', 0, 0, 0),
(1088, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Description', 'Description', 0, 0, 0),
(1089, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'e.g., http://example.com/', 'e.g., http://example.com/', 0, 0, 0),
(1090, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'URL', 'URL', 0, 0, 0),
(1091, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Paypal Email', 'Paypal Email', 0, 0, 0),
(1092, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Charity module is currently enabled. You can disable or configure it from', 'Charity module is currently enabled. You can disable or configure it from', 0, 0, 0),
(1093, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Using charity feature, site can support charities on every purchase. Charities are to be added and managed by site admin. All contributions for charities will be accumulated in their wallet. Once lumpsum amount is accumulated in wallet, site admin may directly pay/clear to charity if \\"Transfer Account\\" is configured. When site admin processes the payment manually through offline mode, he may also mark it as paid/cleared.', 'Using charity feature, site can support charities on every purchase. Charities are to be added and managed by site admin. All contributions for charities will be accumulated in their wallet. Once lumpsum amount is accumulated in wallet, site admin may directly pay/clear to charity if \\"Transfer Account\\" is configured. When site admin processes the payment manually through offline mode, he may also mark it as paid/cleared.', 0, 0, 0),
(1094, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Transfer Account', 'Transfer Account', 0, 0, 0),
(1095, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Share', 'Share', 0, 0, 0),
(1096, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Cleared', 'Cleared', 0, 0, 0),
(1097, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Wallet', 'Wallet', 0, 0, 0),
(1098, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Edit Transfer Account', 'Edit Transfer Account', 0, 0, 0),
(1099, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'No Charities available', 'No Charities available', 0, 0, 0),
(1100, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Submit', 'Submit', 0, 0, 0),
(1101, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Available Amount', 'Available Amount', 0, 0, 0),
(1102, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Pay Amount?', 'Pay Amount?', 0, 0, 0),
(1103, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Gateways: ', 'Gateways: ', 0, 0, 0),
(1104, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Process on', 'Process on', 0, 0, 0),
(1105, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Manual Payment', 'Manual Payment', 0, 0, 0),
(1106, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Pay', 'Pay', 0, 0, 0),
(1107, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Category', 'Category', 0, 0, 0),
(1108, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'No Charity Categories available', 'No Charity Categories available', 0, 0, 0),
(1109, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'Account', 'Account', 0, 0, 0),
(1110, '2012-03-06 17:37:05', '2012-03-06 17:37:05', 42, 'In order to withdrawal cash/amount for the charity from the account balance in the site, You first need to create a ''Money tranfer account''. You can also add multiple transfer accounts with different gateways and mark any one of them as ''Primary''. The approved withdrawal amount from your account balance will be credited to the ''Primary'' marked transfer account.', 'In order to withdrawal cash/amount for the charity from the account balance in the site, You first need to create a ''Money tranfer account''. You can also add multiple transfer accounts with different gateways and mark any one of them as ''Primary''. The approved withdrawal amount from your account balance will be credited to the ''Primary'' marked transfer account.', 0, 0, 0),
(1111, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Payment Gateway', 'Payment Gateway', 0, 0, 0),
(1112, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'No charity money transfer account available', 'No charity money transfer account available', 0, 0, 0),
(1113, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Min', 'Min', 0, 0, 0),
(1114, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Max', 'Max', 0, 0, 0),
(1115, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Sum', 'Sum', 0, 0, 0),
(1116, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Offered Price', 'Offered Price', 0, 0, 0),
(1117, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Quantities Sold', 'Quantities Sold', 0, 0, 0),
(1118, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Total Revenue', 'Total Revenue', 0, 0, 0),
(1119, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Average Sold Price', 'Average Sold Price', 0, 0, 0),
(1120, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Top 10 Merchants', 'Top 10 Merchants', 0, 0, 0),
(1121, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Average', 'Average', 0, 0, 0),
(1122, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Revenue', 'Revenue', 0, 0, 0),
(1123, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, '# Items', '# Items', 0, 0, 0),
(1124, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, '# Pass', '# Pass', 0, 0, 0),
(1125, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Pass', 'Pass', 0, 0, 0),
(1126, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'No stats available', 'No stats available', 0, 0, 0),
(1127, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Merchant by Total Revenue', 'Merchant by Total Revenue', 0, 0, 0),
(1128, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Merchant by # Pass Sold', 'Merchant by # Pass Sold', 0, 0, 0),
(1129, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Price Point', 'Price Point', 0, 0, 0),
(1130, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, '# Passes', '# Passes', 0, 0, 0),
(1131, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Passes', 'Passes', 0, 0, 0),
(1132, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Price', 'Price', 0, 0, 0),
(1133, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Total Revenue by Price Point', 'Total Revenue by Price Point', 0, 0, 0),
(1134, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Total Sold Passes by Price Point', 'Total Sold Passes by Price Point', 0, 0, 0),
(1135, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Total Sold Passes', 'Total Sold Passes', 0, 0, 0),
(1136, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Avg Revenue per Item by Price Point', 'Avg Revenue per Item by Price Point', 0, 0, 0),
(1137, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Avg Revenue per Item', 'Avg Revenue per Item', 0, 0, 0),
(1138, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Avg Sold Passes per Item by Price Point', 'Avg Sold Passes per Item by Price Point', 0, 0, 0),
(1139, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Avg Sold Passes per Item', 'Avg Sold Passes per Item', 0, 0, 0),
(1140, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Overview', 'Overview', 0, 0, 0),
(1141, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Select Range', 'Select Range', 0, 0, 0),
(1142, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Value', 'Value', 0, 0, 0),
(1143, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Total Orders', 'Total Orders', 0, 0, 0),
(1144, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'User Login', 'User Login', 0, 0, 0),
(1145, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Merchant Login', 'Merchant Login', 0, 0, 0),
(1146, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Merchant Registration', 'Merchant Registration', 0, 0, 0),
(1147, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Registration', 'Registration', 0, 0, 0),
(1148, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Purchases', 'Purchases', 0, 0, 0),
(1149, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Total Sold', 'Total Sold', 0, 0, 0),
(1150, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Total Redeemed', 'Total Redeemed', 0, 0, 0),
(1151, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Purchase Demographics', 'Purchase Demographics', 0, 0, 0),
(1152, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Purchased Users', 'Purchased Users', 0, 0, 0),
(1153, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Purchase Locations', 'Purchase Locations', 0, 0, 0),
(1154, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Items/Passes', 'Items/Passes', 0, 0, 0),
(1155, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Orders/Passes', 'Orders/Passes', 0, 0, 0),
(1156, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Pass Usages', 'Pass Usages', 0, 0, 0),
(1157, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Purchased User', 'Purchased User', 0, 0, 0),
(1158, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Demographics', 'Demographics', 0, 0, 0),
(1159, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'City Name', 'City Name', 0, 0, 0),
(1160, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'State', 'State', 0, 0, 0),
(1161, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Country', 'Country', 0, 0, 0),
(1162, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Default Language', 'Default Language', 0, 0, 0),
(1163, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'select the default language for this city. If not selected, Site default language will be set.', 'select the default language for this city. If not selected, Site default language will be set.', 0, 0, 0),
(1164, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Locate The City on Google Maps', 'Locate The City on Google Maps', 0, 0, 0),
(1165, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Latitude', 'Latitude', 0, 0, 0),
(1166, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Longitude', 'Longitude', 0, 0, 0),
(1167, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Zoom', 'Zoom', 0, 0, 0),
(1168, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Point the exact location in map by dragging marker', 'Point the exact location in map by dragging marker', 0, 0, 0),
(1169, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Facebook Details', 'Facebook Details', 0, 0, 0),
(1170, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Facebook URL', 'Facebook URL', 0, 0, 0),
(1171, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Facebook Page ID', 'Facebook Page ID', 0, 0, 0),
(1172, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Twitter Details', 'Twitter Details', 0, 0, 0),
(1173, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Twitter URL', 'Twitter URL', 0, 0, 0),
(1174, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Foursquare Details', 'Foursquare Details', 0, 0, 0),
(1175, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Venue ID', 'Venue ID', 0, 0, 0),
(1176, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Background Image', 'Background Image', 0, 0, 0),
(1177, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Upload', 'Upload', 0, 0, 0),
(1178, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Other', 'Other', 0, 0, 0),
(1179, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Served?', 'Served?', 0, 0, 0),
(1180, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'You can not change default city name.', 'You can not change default city name.', 0, 0, 0),
(1181, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Credentials', 'Credentials', 0, 0, 0),
(1182, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Facebook credentials for this city was not updated.', 'Facebook credentials for this city was not updated.', 0, 0, 0);
INSERT INTO `translations` (`id`, `created`, `modified`, `language_id`, `key`, `lang_text`, `is_translated`, `is_google_translate`, `is_verified`) VALUES
(1183, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'before giving Facebook Page ID', 'before giving Facebook Page ID', 0, 0, 0),
(1184, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Facebook credentials has been updated for this city.', 'Facebook credentials has been updated for this city.', 0, 0, 0),
(1185, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'if you want to change the credentials again', 'if you want to change the credentials again', 0, 0, 0),
(1186, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Update Twitter Credentials', 'Update Twitter Credentials', 0, 0, 0),
(1187, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Twitter credentials for this city was not updated.', 'Twitter credentials for this city was not updated.', 0, 0, 0),
(1188, '2012-03-06 17:37:06', '2012-03-06 17:37:06', 42, 'Twitter credentials has been updated for this city.', 'Twitter credentials has been updated for this city.', 0, 0, 0),
(1189, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Delete?', 'Delete?', 0, 0, 0),
(1190, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Served', 'Served', 0, 0, 0),
(1191, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Unserved', 'Unserved', 0, 0, 0),
(1192, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Total Records', 'Total Records', 0, 0, 0),
(1193, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Add New City', 'Add New City', 0, 0, 0),
(1194, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Change Default City', 'Change Default City', 0, 0, 0),
(1195, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Manage the served cities/cities that the website is targetting. Served cities will appear in the top of page for users to filter.', 'Manage the served cities/cities that the website is targetting. Served cities will appear in the top of page for users to filter.', 0, 0, 0),
(1196, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Here you can', 'Here you can', 0, 0, 0),
(1197, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, '* Change a city''s page background', '* Change a city''s page background', 0, 0, 0),
(1198, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, '* Configure different default language for a city', '* Configure different default language for a city', 0, 0, 0),
(1199, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, '* Configure different Facebook, Twitter, Foursquare accounts for the items to get posted for the city', '* Configure different Facebook, Twitter, Foursquare accounts for the items to get posted for the city', 0, 0, 0),
(1200, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Language', 'Language', 0, 0, 0),
(1201, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Active Items', 'Active Items', 0, 0, 0),
(1202, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Twitter Credentials', 'Twitter Credentials', 0, 0, 0),
(1203, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Click here to change as Unserved', 'Click here to change as Unserved', 0, 0, 0),
(1204, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Click here to change as Served', 'Click here to change as Served', 0, 0, 0),
(1205, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'N/A', 'N/A', 0, 0, 0),
(1206, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'No cities available', 'No cities available', 0, 0, 0),
(1207, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Others', 'Others', 0, 0, 0),
(1208, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Collage', 'Collage', 0, 0, 0),
(1209, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'No Collages available', 'No Collages available', 0, 0, 0),
(1210, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Add ', 'Add ', 0, 0, 0),
(1211, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Company', 'Company', 0, 0, 0),
(1212, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'No Companies available', 'No Companies available', 0, 0, 0),
(1213, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Thank you, we received your message and will get back to you as soon as possible.', 'Thank you, we received your message and will get back to you as soon as possible.', 0, 0, 0),
(1214, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'First Name', 'First Name', 0, 0, 0),
(1215, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Last Name', 'Last Name', 0, 0, 0),
(1216, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Telephone', 'Telephone', 0, 0, 0),
(1217, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Subject', 'Subject', 0, 0, 0),
(1218, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, '[Image: CAPTCHA image. You will need to recognize the text in it; audible CAPTCHA available too.]', '[Image: CAPTCHA image. You will need to recognize the text in it; audible CAPTCHA available too.]', 0, 0, 0),
(1219, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'CAPTCHA image', 'CAPTCHA image', 0, 0, 0),
(1220, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Reload CAPTCHA', 'Reload CAPTCHA', 0, 0, 0),
(1221, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Click to play', 'Click to play', 0, 0, 0),
(1222, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Security Code', 'Security Code', 0, 0, 0),
(1223, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Send', 'Send', 0, 0, 0),
(1224, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Fips104', 'Fips104', 0, 0, 0),
(1225, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Iso2', 'Iso2', 0, 0, 0),
(1226, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Iso3', 'Iso3', 0, 0, 0),
(1227, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Ison', 'Ison', 0, 0, 0),
(1228, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Internet', 'Internet', 0, 0, 0),
(1229, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Capital', 'Capital', 0, 0, 0),
(1230, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Map Reference', 'Map Reference', 0, 0, 0),
(1231, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Nationality Singular', 'Nationality Singular', 0, 0, 0),
(1232, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Nationality Plural', 'Nationality Plural', 0, 0, 0),
(1233, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Currency', 'Currency', 0, 0, 0),
(1234, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Currency Code', 'Currency Code', 0, 0, 0),
(1235, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Population', 'Population', 0, 0, 0),
(1236, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Title', 'Title', 0, 0, 0),
(1237, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Comment', 'Comment', 0, 0, 0),
(1238, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Warning! If you delete any country from below list, users from that country can''t register into our site.', 'Warning! If you delete any country from below list, users from that country can''t register into our site.', 0, 0, 0),
(1239, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Filter', 'Filter', 0, 0, 0),
(1240, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Add New Country', 'Add New Country', 0, 0, 0),
(1241, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Nationality', 'Nationality', 0, 0, 0),
(1242, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Singular', 'Singular', 0, 0, 0),
(1243, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Plural', 'Plural', 0, 0, 0),
(1244, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Code', 'Code', 0, 0, 0),
(1245, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'No countries available', 'No countries available', 0, 0, 0),
(1246, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Symbol', 'Symbol', 0, 0, 0),
(1247, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Decimals', 'Decimals', 0, 0, 0),
(1248, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Decimal Point', 'Decimal Point', 0, 0, 0),
(1249, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Thousand Separate', 'Thousand Separate', 0, 0, 0),
(1250, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Enabled?', 'Enabled?', 0, 0, 0),
(1251, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Automatic Currency Conversion Updation is currently enabled. You can disable it from', 'Automatic Currency Conversion Updation is currently enabled. You can disable it from', 0, 0, 0),
(1252, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'page if you prefer to manually update the values here.', 'page if you prefer to manually update the values here.', 0, 0, 0),
(1253, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Automatic Currency Conversion Updation is currently disabled. You can enable it from', 'Automatic Currency Conversion Updation is currently disabled. You can enable it from', 0, 0, 0),
(1254, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'page. When you enabled automatic update, you don''t have to manually update the values here.', 'page. When you enabled automatic update, you don''t have to manually update the values here.', 0, 0, 0),
(1255, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Base Currency', 'Base Currency', 0, 0, 0),
(1256, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Conversion', 'Conversion', 0, 0, 0),
(1257, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Rate', 'Rate', 0, 0, 0),
(1258, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Add New Currency', 'Add New Currency', 0, 0, 0),
(1259, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Added On', 'Added On', 0, 0, 0),
(1260, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Dec Point', 'Dec Point', 0, 0, 0),
(1261, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Thousands Sep', 'Thousands Sep', 0, 0, 0),
(1262, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'PayPal Support?', 'PayPal Support?', 0, 0, 0),
(1263, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'No Currencies available', 'No Currencies available', 0, 0, 0),
(1264, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Currency Conversion History Updation is currently enabled. You can disable it from', 'Currency Conversion History Updation is currently enabled. You can disable it from', 0, 0, 0),
(1265, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'No Currency Conversion Histories available', 'No Currency Conversion Histories available', 0, 0, 0),
(1266, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'City', 'City', 0, 0, 0),
(1267, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Selecting the city will filter the following items: Admin stat - items and total commission amount earned, Items, Item Passes, Subscriptions.', 'Selecting the city will filter the following items: Admin stat - items and total commission amount earned, Items, Item Passes, Subscriptions.', 0, 0, 0),
(1268, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Add User', 'Add User', 0, 0, 0),
(1269, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Top 10, by revenue, by pass', 'Top 10, by revenue, by pass', 0, 0, 0),
(1270, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'MailChimp Mailing Lists', 'MailChimp Mailing Lists', 0, 0, 0),
(1271, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Payments', 'Payments', 0, 0, 0),
(1272, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Withdraw Fund Requests', 'Withdraw Fund Requests', 0, 0, 0),
(1273, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Users & Merchants', 'Users & Merchants', 0, 0, 0),
(1274, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Release payment', 'Release payment', 0, 0, 0),
(1275, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Partners', 'Partners', 0, 0, 0),
(1276, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Requests', 'Requests', 0, 0, 0),
(1277, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Common Settings', 'Common Settings', 0, 0, 0),
(1278, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Referral Commissions', 'Referral Commissions', 0, 0, 0),
(1279, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Setting Overview', 'Setting Overview', 0, 0, 0),
(1280, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'System', 'System', 0, 0, 0),
(1281, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Developments', 'Developments', 0, 0, 0),
(1282, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'SEO', 'SEO', 0, 0, 0),
(1283, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Regional, Currency & Language', 'Regional, Currency & Language', 0, 0, 0),
(1284, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Account ', 'Account ', 0, 0, 0),
(1285, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Payment', 'Payment', 0, 0, 0),
(1286, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Third Party API', 'Third Party API', 0, 0, 0),
(1287, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Module Manager', 'Module Manager', 0, 0, 0),
(1288, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'CDN', 'CDN', 0, 0, 0),
(1289, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Masters', 'Masters', 0, 0, 0),
(1290, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Warning! Please edit with caution.', 'Warning! Please edit with caution.', 0, 0, 0),
(1291, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Regional', 'Regional', 0, 0, 0),
(1292, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Static pages', 'Static pages', 0, 0, 0),
(1293, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Manage Static Pages', 'Manage Static Pages', 0, 0, 0),
(1294, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Colleges', 'Colleges', 0, 0, 0),
(1295, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Education', 'Education', 0, 0, 0),
(1296, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Relationship', 'Relationship', 0, 0, 0),
(1297, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Employment', 'Employment', 0, 0, 0),
(1298, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Income', 'Income', 0, 0, 0),
(1299, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Gender', 'Gender', 0, 0, 0),
(1300, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Age', 'Age', 0, 0, 0),
(1301, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Page', 'Page', 0, 0, 0),
(1302, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'of', 'of', 0, 0, 0),
(1303, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'showing ', 'showing ', 0, 0, 0),
(1304, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'records out of', 'records out of', 0, 0, 0),
(1305, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'total, starting on record', 'total, starting on record', 0, 0, 0),
(1306, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'ending on', 'ending on', 0, 0, 0),
(1307, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Prev', 'Prev', 0, 0, 0),
(1308, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Next', 'Next', 0, 0, 0),
(1309, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Total Bought: ', 'Total Bought: ', 0, 0, 0),
(1310, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'This account is associated with your %s profile', 'This account is associated with your %s profile', 0, 0, 0),
(1311, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, ' your public profile page is here', ' your public profile page is here', 0, 0, 0),
(1312, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Share your unique referral link', 'Share your unique referral link', 0, 0, 0),
(1313, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'In site url to add your share unique referral', 'In site url to add your share unique referral', 0, 0, 0),
(1314, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Change password', 'Change password', 0, 0, 0),
(1315, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Manage Email settings', 'Manage Email settings', 0, 0, 0),
(1316, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Manage email notifications', 'Manage email notifications', 0, 0, 0),
(1317, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Click here', 'Click here', 0, 0, 0),
(1318, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'From Email', 'From Email', 0, 0, 0),
(1319, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'From', 'From', 0, 0, 0),
(1320, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, '%s to set common from email for all email templates', '%s to set common from email for all email templates', 0, 0, 0),
(1321, '2012-03-06 17:37:07', '2012-03-06 17:37:07', 42, 'Reply To', 'Reply To', 0, 0, 0),
(1322, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, '%s to set common reply to email for all email templates', '%s to set common reply to email for all email templates', 0, 0, 0),
(1323, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Subject (Japanese)', 'Subject (Japanese)', 0, 0, 0),
(1324, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Email Type', 'Email Type', 0, 0, 0),
(1325, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Is Html', 'Is Html', 0, 0, 0),
(1326, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Email Content', 'Email Content', 0, 0, 0),
(1327, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Email Content (Japanese)', 'Email Content (Japanese)', 0, 0, 0),
(1328, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Update Email Templates', 'Update Email Templates', 0, 0, 0),
(1329, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'No e-mail templates added yet.', 'No e-mail templates added yet.', 0, 0, 0),
(1330, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'No genders available', 'No genders available', 0, 0, 0),
(1331, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'click here', 'click here', 0, 0, 0),
(1332, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'child count less than 0 in %s', 'child count less than 0 in %s', 0, 0, 0),
(1333, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'IP', 'IP', 0, 0, 0),
(1334, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Auto detected', 'Auto detected', 0, 0, 0),
(1335, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'No Ips available', 'No Ips available', 0, 0, 0),
(1336, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Add Category', 'Add Category', 0, 0, 0),
(1337, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'No item Categories available', 'No item Categories available', 0, 0, 0),
(1338, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Add item Comment', 'Add item Comment', 0, 0, 0),
(1339, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Posted User', 'Posted User', 0, 0, 0),
(1340, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Edit item Comment', 'Edit item Comment', 0, 0, 0),
(1341, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'item', 'item', 0, 0, 0),
(1342, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Posted user', 'Posted user', 0, 0, 0),
(1343, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Commented User', 'Commented User', 0, 0, 0),
(1344, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Comments', 'Comments', 0, 0, 0),
(1345, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Date', 'Date', 0, 0, 0),
(1346, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'No item Comments available', 'No item Comments available', 0, 0, 0),
(1347, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'item Comment', 'item Comment', 0, 0, 0),
(1348, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Posted User Id', 'Posted User Id', 0, 0, 0),
(1349, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'No comments available', 'No comments available', 0, 0, 0),
(1350, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Used?', 'Used?', 0, 0, 0),
(1351, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'System generated?', 'System generated?', 0, 0, 0),
(1352, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'No item Passes available', 'No item Passes available', 0, 0, 0),
(1353, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Item:', 'Item:', 0, 0, 0),
(1354, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Pass code:', 'Pass code:', 0, 0, 0),
(1355, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Recipient:', 'Recipient:', 0, 0, 0),
(1356, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Purchased:', 'Purchased:', 0, 0, 0),
(1357, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Event Date:', 'Event Date:', 0, 0, 0),
(1358, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Used on:', 'Used on:', 0, 0, 0),
(1359, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Mark as Used', 'Mark as Used', 0, 0, 0),
(1360, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Pending (%s)', 'Pending (%s)', 0, 0, 0),
(1361, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Canceled (%s)', 'Canceled (%s)', 0, 0, 0),
(1362, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Available (%s)', 'Available (%s)', 0, 0, 0),
(1363, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Expired (%s)', 'Expired (%s)', 0, 0, 0),
(1364, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Used (%s)', 'Used (%s)', 0, 0, 0),
(1365, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Refunded (%s)', 'Refunded (%s)', 0, 0, 0),
(1366, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'All (%s)', 'All (%s)', 0, 0, 0),
(1367, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Purchased Date', 'Purchased Date', 0, 0, 0),
(1368, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Canceled Date', 'Canceled Date', 0, 0, 0),
(1369, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Pass Code', 'Pass Code', 0, 0, 0),
(1370, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Top/Bottom', 'Top/Bottom', 0, 0, 0),
(1371, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Quantities', 'Quantities', 0, 0, 0),
(1372, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Be Next Increase Price', 'Be Next Increase Price', 0, 0, 0),
(1373, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Charity Contributions', 'Charity Contributions', 0, 0, 0),
(1374, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Print', 'Print', 0, 0, 0),
(1375, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'View Pass', 'View Pass', 0, 0, 0),
(1376, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'No pass available', 'No pass available', 0, 0, 0),
(1377, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Use Now', 'Use Now', 0, 0, 0),
(1378, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Referral module is currently enabled. You can disable or configure it from', 'Referral module is currently enabled. You can disable or configure it from', 0, 0, 0),
(1379, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Commission Earned', 'Commission Earned', 0, 0, 0),
(1380, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Commission Earned type', 'Commission Earned type', 0, 0, 0),
(1381, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'No Referred Users Earning Available', 'No Referred Users Earning Available', 0, 0, 0),
(1382, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Refund (%s)', 'Refund (%s)', 0, 0, 0),
(1383, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Gifted (%s)', 'Gifted (%s)', 0, 0, 0),
(1384, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Own', 'Own', 0, 0, 0),
(1385, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Gift', 'Gift', 0, 0, 0),
(1386, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Undo', 'Undo', 0, 0, 0),
(1387, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Awesome groupers who''ve reserved', 'Awesome groupers who''ve reserved', 0, 0, 0),
(1388, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Price up by ', 'Price up by ', 0, 0, 0),
(1389, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, ' Seat', ' Seat', 0, 0, 0),
(1390, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, '+', '+', 0, 0, 0),
(1391, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'More', 'More', 0, 0, 0),
(1392, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, ' at ', ' at ', 0, 0, 0),
(1393, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'View Item', 'View Item', 0, 0, 0),
(1394, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, ' Quantity', ' Quantity', 0, 0, 0),
(1395, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'No passes available', 'No passes available', 0, 0, 0),
(1396, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, '[Image: Logo]', '[Image: Logo]', 0, 0, 0),
(1397, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Name:', 'Name:', 0, 0, 0),
(1398, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Recipient Email:', 'Recipient Email:', 0, 0, 0),
(1399, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Purchased:  ', 'Purchased:  ', 0, 0, 0),
(1400, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Universal Fine Print:', 'Universal Fine Print:', 0, 0, 0),
(1401, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Not valid for cash back (unless required by law). Must use in one visit. Doesn''t cover tax or gratuity. Can''t be combined with other offers.', 'Not valid for cash back (unless required by law). Must use in one visit. Doesn''t cover tax or gratuity. Can''t be combined with other offers.', 0, 0, 0),
(1402, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'A gift from', 'A gift from', 0, 0, 0),
(1403, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'How to use this:', 'How to use this:', 0, 0, 0),
(1404, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Print your', 'Print your', 0, 0, 0),
(1405, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Present', 'Present', 0, 0, 0),
(1406, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'upon arrival.', 'upon arrival.', 0, 0, 0),
(1407, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Enjoy!', 'Enjoy!', 0, 0, 0),
(1408, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, '*Remember:', '*Remember:', 0, 0, 0),
(1409, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'customers tip on the full amount of the pre-discounted service (and tip generously). That''s why we are the coolest customers out there.', 'customers tip on the full amount of the pre-discounted service (and tip generously). That''s why we are the coolest customers out there.', 0, 0, 0),
(1410, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Map:', 'Map:', 0, 0, 0),
(1411, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'View Larger Map', 'View Larger Map', 0, 0, 0),
(1412, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Legal Stuff We Have To Say:', 'Legal Stuff We Have To Say:', 0, 0, 0),
(1413, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'General terms applicable to all Vouchers (unless otherwise set forth below, in %s Terms of Sale, or in the Fine Print): Unless prohibited by applicable law the following restrictions also apply. See below for further details. However, even if the promotional offer stated on your %s has expired, applicable law may require the merchant to allow you to redeem your Voucher beyond its expiration date for goods/services equal to the amount you paid for it. If you have gone to the merchant and the merchant has refused to redeem the cash value of your expired Voucher, and if applicable law entitles you to such redemption %s will refund the purchase price of the Voucher per its Terms of Sale. Partial Redemptions: If you redeem the Voucher for less than its face value, you only will be entitled to a credit or cash equal to the difference between the face value and the amount you redeemed from the merchant if applicable law requires it.If you redeem this %s Voucher for less than the total face value, you will not be entitled to receive any credit or cash for the difference between the face value and the amount you redeemed, (unless otherwise required by applicable law). You will only be entitled to a redemption value equal to the amount you paid for the %s less the amount actually redeemed. The redemption value will be reduced by the amount of purchases made. This %s expiration date above, the merchant will, in its discretion: (1) allow you to redeem this Voucher for the product or service specified on the Voucher or (2) allow you to redeem the Voucher to purchase other goods or services from the merchant for up to the amount you paid for the Voucher. This Voucher can only can be used for making purchases of goods/services at the named merchant. Merchant is solely responsible for Voucher redemption. Vouchers cannot be redeemed for cash or applied as payment to any account unless required by applicable law. Neither %s, Inc. nor the named merchant shall be responsible for %s Vouchers that are lost or damaged. Use of Vouchers are subject to %s Terms of Sale', 'General terms applicable to all Vouchers (unless otherwise set forth below, in %s Terms of Sale, or in the Fine Print): Unless prohibited by applicable law the following restrictions also apply. See below for further details. However, even if the promotional offer stated on your %s has expired, applicable law may require the merchant to allow you to redeem your Voucher beyond its expiration date for goods/services equal to the amount you paid for it. If you have gone to the merchant and the merchant has refused to redeem the cash value of your expired Voucher, and if applicable law entitles you to such redemption %s will refund the purchase price of the Voucher per its Terms of Sale. Partial Redemptions: If you redeem the Voucher for less than its face value, you only will be entitled to a credit or cash equal to the difference between the face value and the amount you redeemed from the merchant if applicable law requires it.If you redeem this %s Voucher for less than the total face value, you will not be entitled to receive any credit or cash for the difference between the face value and the amount you redeemed, (unless otherwise required by applicable law). You will only be entitled to a redemption value equal to the amount you paid for the %s less the amount actually redeemed. The redemption value will be reduced by the amount of purchases made. This %s expiration date above, the merchant will, in its discretion: (1) allow you to redeem this Voucher for the product or service specified on the Voucher or (2) allow you to redeem the Voucher to purchase other goods or services from the merchant for up to the amount you paid for the Voucher. This Voucher can only can be used for making purchases of goods/services at the named merchant. Merchant is solely responsible for Voucher redemption. Vouchers cannot be redeemed for cash or applied as payment to any account unless required by applicable law. Neither %s, Inc. nor the named merchant shall be responsible for %s Vouchers that are lost or damaged. Use of Vouchers are subject to %s Terms of Sale', 0, 0, 0),
(1414, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, '[Image: Merchant Item Flow]', '[Image: Merchant Item Flow]', 0, 0, 0),
(1415, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Merchant Item Flow', 'Merchant Item Flow', 0, 0, 0),
(1416, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, '[Image: Administrator Item Flow]', '[Image: Administrator Item Flow]', 0, 0, 0),
(1417, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Administrator Item Flow', 'Administrator Item Flow', 0, 0, 0),
(1418, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'General', 'General', 0, 0, 0),
(1419, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Menu', 'Menu', 0, 0, 0),
(1420, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'End Date', 'End Date', 0, 0, 0),
(1421, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Event Date', 'Event Date', 0, 0, 0),
(1422, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Is there be next?', 'Is there be next?', 0, 0, 0),
(1423, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Be next increase price', 'Be next increase price', 0, 0, 0),
(1424, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Is there tipping point?', 'Is there tipping point?', 0, 0, 0),
(1425, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Passes & Quantities', 'Passes & Quantities', 0, 0, 0),
(1426, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'No of Min Passes', 'No of Min Passes', 0, 0, 0),
(1427, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Minimum limit of passes to be bought by users, in order for the item to get tipped.', 'Minimum limit of passes to be bought by users, in order for the item to get tipped.', 0, 0, 0),
(1428, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'No of Max Passes', 'No of Max Passes', 0, 0, 0),
(1429, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Maximum limit of passes can be bought for this item. Leave blank for no limit.', 'Maximum limit of passes can be bought for this item. Leave blank for no limit.', 0, 0, 0),
(1430, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Minimum Buy Quantity', 'Minimum Buy Quantity', 0, 0, 0),
(1431, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Minimum purchase per user including gifts.', 'Minimum purchase per user including gifts.', 0, 0, 0),
(1432, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Maximum Buy Quantity', 'Maximum Buy Quantity', 0, 0, 0),
(1433, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Maximum purchase per user including gifts. Leave blank for no limit.', 'Maximum purchase per user including gifts. Leave blank for no limit.', 0, 0, 0),
(1434, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Total Commission Amount = Bonus Amount + ((Total Purchased Amount) * Commission Percentage/100))', 'Total Commission Amount = Bonus Amount + ((Total Purchased Amount) * Commission Percentage/100))', 0, 0, 0),
(1435, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Bonus Amount', 'Bonus Amount', 0, 0, 0),
(1436, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'This is the flat fee that the merchant will pay for the whole item.', 'This is the flat fee that the merchant will pay for the whole item.', 0, 0, 0),
(1437, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'This is the commission that merchant will pay for the whole item in percentage.', 'This is the commission that merchant will pay for the whole item in percentage.', 0, 0, 0),
(1438, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Commission (%)', 'Commission (%)', 0, 0, 0),
(1439, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'This is the commission that merchant will pay for the whole item in percentage. The Commission set must be greater than %s', 'This is the commission that merchant will pay for the whole item in percentage. The Commission set must be greater than %s', 0, 0, 0),
(1440, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Item Interests', 'Item Interests', 0, 0, 0),
(1441, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Item Cities', 'Item Cities', 0, 0, 0),
(1442, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'You can decide whether you want to give amount to charity', 'You can decide whether you want to give amount to charity', 0, 0, 0),
(1443, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Amount to the charity will be given from the commission amount you have earned.', 'Amount to the charity will be given from the commission amount you have earned.', 0, 0, 0),
(1444, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Amount to the charity will be given from admin commission amount. Your profit wont be affected.', 'Amount to the charity will be given from admin commission amount. Your profit wont be affected.', 0, 0, 0),
(1445, '2012-03-06 17:37:08', '2012-03-06 17:37:08', 42, 'Charity Percentage (%)', 'Charity Percentage (%)', 0, 0, 0),
(1446, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Percentage of amount you would like to give for charity.', 'Percentage of amount you would like to give for charity.', 0, 0, 0),
(1447, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Admin also pay same percentage of amount from his commission', 'Admin also pay same percentage of amount from his commission', 0, 0, 0),
(1448, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Item Image', 'Item Image', 0, 0, 0),
(1449, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Item Images', 'Item Images', 0, 0, 0),
(1450, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Delete Photo', 'Delete Photo', 0, 0, 0),
(1451, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Users can use this pass code at the time of purchase irrespective of types of users. If you leave this field be free or else entered the less passes than the users can possible to purchase then system will automatically generate the passes to compensate the total no of passes users has purchased.', 'Users can use this pass code at the time of purchase irrespective of types of users. If you leave this field be free or else entered the less passes than the users can possible to purchase then system will automatically generate the passes to compensate the total no of passes users has purchased.', 0, 0, 0),
(1452, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Comma seperated for multiple passes. <br />e.g., 000781b0-1, 0004e1b0-6, 00a481b0-8', 'Comma seperated for multiple passes. <br />e.g., 000781b0-1, 0004e1b0-6, 00a481b0-8', 0, 0, 0),
(1453, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Save as Draft', 'Save as Draft', 0, 0, 0),
(1454, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Continue', 'Continue', 0, 0, 0),
(1455, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Save this item as draft and make changes until you send it to open status. Use the update button in edit page to send it to open status.', 'Save this item as draft and make changes until you send it to open status. Use the update button in edit page to send it to open status.', 0, 0, 0),
(1456, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Save this item as draft and make changes until you send it to pending status. Use the update button in edit page to send it to pending status.', 'Save this item as draft and make changes until you send it to pending status. Use the update button in edit page to send it to pending status.', 0, 0, 0),
(1457, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'List Existing Passes', 'List Existing Passes', 0, 0, 0),
(1458, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Users can use this pass code at the time of purchase irrespective of types of users. If you leave this field be free or else entered the less passes than the users can possible to purchase then system will automatically generate the passes to compensate the total no of passes users has purchased.<br/>(Passes entered will be updated with existing.)', 'Users can use this pass code at the time of purchase irrespective of types of users. If you leave this field be free or else entered the less passes than the users can possible to purchase then system will automatically generate the passes to compensate the total no of passes users has purchased.<br/>(Passes entered will be updated with existing.)', 0, 0, 0),
(1459, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Update Draft', 'Update Draft', 0, 0, 0),
(1460, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'New Item', 'New Item', 0, 0, 0),
(1461, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Paid to Merchant', 'Paid to Merchant', 0, 0, 0),
(1462, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Merchant share for their items will be funded to their respective wallet account.\\r\\nIf the ''Paid to Merchant'' items has Charity & Affiliate, their share will be also funded to their respective charity and affiliate user wallet account.', 'Merchant share for their items will be funded to their respective wallet account.\\r\\nIf the ''Paid to Merchant'' items has Charity & Affiliate, their share will be also funded to their respective charity and affiliate user wallet account.', 0, 0, 0),
(1463, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'All Items', 'All Items', 0, 0, 0),
(1464, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Start', 'Start', 0, 0, 0),
(1465, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'End', 'End', 0, 0, 0),
(1466, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Sales', 'Sales', 0, 0, 0),
(1467, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Site / Revenue', 'Site / Revenue', 0, 0, 0),
(1468, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'CSV', 'CSV', 0, 0, 0),
(1469, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Quantities Sold  (%s)', 'Quantities Sold  (%s)', 0, 0, 0),
(1470, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Quantity Sold', 'Quantity Sold', 0, 0, 0),
(1471, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Clone Item', 'Clone Item', 0, 0, 0),
(1472, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'List Allocated Pass', 'List Allocated Pass', 0, 0, 0),
(1473, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Private Note', 'Private Note', 0, 0, 0),
(1474, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Original Price', 'Original Price', 0, 0, 0),
(1475, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Total Commission Amount', 'Total Commission Amount', 0, 0, 0),
(1476, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Item Limit', 'Item Limit', 0, 0, 0),
(1477, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Minimum', 'Minimum', 0, 0, 0),
(1478, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Maximum', 'Maximum', 0, 0, 0),
(1479, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Categories', 'Categories', 0, 0, 0),
(1480, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Added 0n', 'Added 0n', 0, 0, 0),
(1481, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Status: ', 'Status: ', 0, 0, 0),
(1482, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Summary Statistics', 'Summary Statistics', 0, 0, 0),
(1483, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Price Point Statistics', 'Price Point Statistics', 0, 0, 0),
(1484, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Minimum Quantity: %s <br /> Maximum Quantity: %s', 'Minimum Quantity: %s <br /> Maximum Quantity: %s', 0, 0, 0),
(1485, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'bucks', 'bucks', 0, 0, 0),
(1486, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'You will have used all your Bucks.', 'You will have used all your Bucks.', 0, 0, 0),
(1487, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'You will have', 'You will have', 0, 0, 0),
(1488, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Bucks remaining.', 'Bucks remaining.', 0, 0, 0),
(1489, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'My Price:', 'My Price:', 0, 0, 0),
(1490, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'For every item purchased, %s will donate %s of amount to charity that you selected from the pull-down', 'For every item purchased, %s will donate %s of amount to charity that you selected from the pull-down', 0, 0, 0),
(1491, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'For every item purchased, %s will donate %s of amount to ', 'For every item purchased, %s will donate %s of amount to ', 0, 0, 0),
(1492, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'charity', 'charity', 0, 0, 0),
(1493, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Friend Name', 'Friend Name', 0, 0, 0),
(1494, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Friend Email', 'Friend Email', 0, 0, 0),
(1495, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, '<p>Note: Currently, Payment Gateways doesn''t allow', '<p>Note: Currently, Payment Gateways doesn''t allow', 0, 0, 0),
(1496, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'currency to be processed. It''ll converted to', 'currency to be processed. It''ll converted to', 0, 0, 0),
(1497, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'before processing. <strong>You wont be charged extra.</strong></p><p>You can also check the converted amount in <strong>My Transactions</strong>.</p>', 'before processing. <strong>You wont be charged extra.</strong></p><p>You can also check the converted amount in <strong>My Transactions</strong>.</p>', 0, 0, 0),
(1498, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Must start with an alphabet. <br/> Must be minimum of 3 characters and <br/> Maximum of 20 characters <br/> No special characters and spaces allowed', 'Must start with an alphabet. <br/> Must be minimum of 3 characters and <br/> Maximum of 20 characters <br/> No special characters and spaces allowed', 0, 0, 0),
(1499, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Password', 'Password', 0, 0, 0),
(1500, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Password Confirmation', 'Password Confirmation', 0, 0, 0),
(1501, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Payment Type', 'Payment Type', 0, 0, 0),
(1502, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Pay with this card(s)', 'Pay with this card(s)', 0, 0, 0),
(1503, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Add new card', 'Add new card', 0, 0, 0),
(1504, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Billing Information', 'Billing Information', 0, 0, 0),
(1505, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Card Type', 'Card Type', 0, 0, 0),
(1506, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Card Number', 'Card Number', 0, 0, 0),
(1507, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Expiration Date', 'Expiration Date', 0, 0, 0),
(1508, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Card Verification Number:', 'Card Verification Number:', 0, 0, 0),
(1509, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Billing Address', 'Billing Address', 0, 0, 0),
(1510, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Address', 'Address', 0, 0, 0),
(1511, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Zip code', 'Zip code', 0, 0, 0),
(1512, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Complete My Order', 'Complete My Order', 0, 0, 0),
(1513, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Already Have An Account?', 'Already Have An Account?', 0, 0, 0),
(1514, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'If you have purchased a %s before, you can sign in using your %s.', 'If you have purchased a %s before, you can sign in using your %s.', 0, 0, 0),
(1515, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Sign In', 'Sign In', 0, 0, 0),
(1516, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Already have an account on Facebook?', 'Already have an account on Facebook?', 0, 0, 0),
(1517, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Use it to sign in to %s!', 'Use it to sign in to %s!', 0, 0, 0),
(1518, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, '[Image: Facebook Connect]', '[Image: Facebook Connect]', 0, 0, 0),
(1519, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Facebook connect', 'Facebook connect', 0, 0, 0),
(1520, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Redirecting you to Pagseguro', 'Redirecting you to Pagseguro', 0, 0, 0),
(1521, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'If your browser doesn''t redirect you please ', 'If your browser doesn''t redirect you please ', 0, 0, 0),
(1522, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'to continue ', 'to continue ', 0, 0, 0),
(1523, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Redirecting you to PayPal', 'Redirecting you to PayPal', 0, 0, 0),
(1524, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'Filter By:', 'Filter By:', 0, 0, 0),
(1525, '2012-03-06 17:37:09', '2012-03-06 17:37:09', 42, 'more needed!', 'more needed!', 0, 0, 0),
(1526, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Sold Out', 'Sold Out', 0, 0, 0),
(1527, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Item On!', 'Item On!', 0, 0, 0),
(1528, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Grab this', 'Grab this', 0, 0, 0),
(1529, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'There are currently no ', 'There are currently no ', 0, 0, 0),
(1530, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, ' items.', ' items.', 0, 0, 0),
(1531, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'No peoples available', 'No peoples available', 0, 0, 0),
(1532, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'See Menu', 'See Menu', 0, 0, 0),
(1533, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'All item', 'All item', 0, 0, 0),
(1534, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Date Start/End', 'Date Start/End', 0, 0, 0),
(1535, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Save and send to admin approval', 'Save and send to admin approval', 0, 0, 0),
(1536, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Pass CSV', 'Pass CSV', 0, 0, 0),
(1537, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Print of Pass', 'Print of Pass', 0, 0, 0),
(1538, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'List Pass', 'List Pass', 0, 0, 0),
(1539, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Bonus', 'Bonus', 0, 0, 0),
(1540, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Total Commission', 'Total Commission', 0, 0, 0),
(1541, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'User Limit', 'User Limit', 0, 0, 0),
(1542, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'No items available', 'No items available', 0, 0, 0),
(1543, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Total Quantities Sold', 'Total Quantities Sold', 0, 0, 0),
(1544, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Item Status', 'Item Status', 0, 0, 0),
(1545, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Not used', 'Not used', 0, 0, 0),
(1546, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Check out these other items', 'Check out these other items', 0, 0, 0),
(1547, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Check out these past items', 'Check out these past items', 0, 0, 0),
(1548, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, ' MORE', ' MORE', 0, 0, 0),
(1549, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'bought', 'bought', 0, 0, 0),
(1550, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Be the first to buy!', 'Be the first to buy!', 0, 0, 0),
(1551, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'more needed to get the item', 'more needed to get the item', 0, 0, 0),
(1552, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'The item is on!', 'The item is on!', 0, 0, 0),
(1553, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Tipped at ', 'Tipped at ', 0, 0, 0),
(1554, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, ' with ', ' with ', 0, 0, 0),
(1555, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, '  bought', '  bought', 0, 0, 0),
(1556, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Item Information', 'Item Information', 0, 0, 0),
(1557, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Current Item Status', 'Current Item Status', 0, 0, 0),
(1558, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Locations', 'Locations', 0, 0, 0);
INSERT INTO `translations` (`id`, `created`, `modified`, `language_id`, `key`, `lang_text`, `is_translated`, `is_google_translate`, `is_verified`) VALUES
(1559, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Item Lifetime', 'Item Lifetime', 0, 0, 0),
(1560, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Item Sales/Purchase Information', 'Item Sales/Purchase Information', 0, 0, 0),
(1561, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Pass Expires On', 'Pass Expires On', 0, 0, 0),
(1562, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Total Purchases', 'Total Purchases', 0, 0, 0),
(1563, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Oh no... You''re too late for this ', 'Oh no... You''re too late for this ', 0, 0, 0),
(1564, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Sign up for our daily email so you never miss another', 'Sign up for our daily email so you never miss another', 0, 0, 0),
(1565, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'in', 'in', 0, 0, 0),
(1566, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Map It!', 'Map It!', 0, 0, 0),
(1567, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'View Menu', 'View Menu', 0, 0, 0),
(1568, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Sold out', 'Sold out', 0, 0, 0),
(1569, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Grab Now!', 'Grab Now!', 0, 0, 0),
(1570, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'current price', 'current price', 0, 0, 0),
(1571, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'End On', 'End On', 0, 0, 0),
(1572, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Ended On', 'Ended On', 0, 0, 0),
(1573, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Be Next', 'Be Next', 0, 0, 0),
(1574, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'The price goes up ', 'The price goes up ', 0, 0, 0),
(1575, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, ' with each reservation.', ' with each reservation.', 0, 0, 0),
(1576, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Reserve Now', 'Reserve Now', 0, 0, 0),
(1577, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Share This Item: ', 'Share This Item: ', 0, 0, 0),
(1578, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Quick! Email a friend!', 'Quick! Email a friend!', 0, 0, 0),
(1579, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Check out the great item on ', 'Check out the great item on ', 0, 0, 0),
(1580, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'I think you should get ', 'I think you should get ', 0, 0, 0),
(1581, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, ': ', ': ', 0, 0, 0),
(1582, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, '% off at ', '% off at ', 0, 0, 0),
(1583, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Send a mail to friend about this item', 'Send a mail to friend about this item', 0, 0, 0),
(1584, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Tweet!', 'Tweet!', 0, 0, 0),
(1585, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Buy Now', 'Buy Now', 0, 0, 0),
(1586, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'No Longer Available', 'No Longer Available', 0, 0, 0),
(1587, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Return to The Item', 'Return to The Item', 0, 0, 0),
(1588, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Active Records', 'Active Records', 0, 0, 0),
(1589, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Inactive Records', 'Inactive Records', 0, 0, 0),
(1590, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'ISO2', 'ISO2', 0, 0, 0),
(1591, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'ISO3', 'ISO3', 0, 0, 0),
(1592, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'No Languages available', 'No Languages available', 0, 0, 0),
(1593, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Admin - %s', 'Admin - %s', 0, 0, 0),
(1594, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'View Site', 'View Site', 0, 0, 0),
(1595, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Tools', 'Tools', 0, 0, 0),
(1596, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Logout', 'Logout', 0, 0, 0),
(1597, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Welcome, ', 'Welcome, ', 0, 0, 0),
(1598, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Back to Settings', 'Back to Settings', 0, 0, 0),
(1599, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'To reflect setting changes, you need to', 'To reflect setting changes, you need to', 0, 0, 0),
(1600, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'clear cache', 'clear cache', 0, 0, 0),
(1601, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Affiliate module is currently disabled. You can enable it from ', 'Affiliate module is currently disabled. You can enable it from ', 0, 0, 0),
(1602, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Referral module is currently disabled. You can enable it from ', 'Referral module is currently disabled. You can enable it from ', 0, 0, 0),
(1603, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Charity module is currently disabled. You can enable it from ', 'Charity module is currently disabled. You can enable it from ', 0, 0, 0),
(1604, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'MailChimp module is currently disabled. You can enable it from ', 'MailChimp module is currently disabled. You can enable it from ', 0, 0, 0),
(1605, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Currency Conversion History Updation is currently disabled. You can enable it from ', 'Currency Conversion History Updation is currently disabled. You can enable it from ', 0, 0, 0),
(1606, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'All rights reserved', 'All rights reserved', 0, 0, 0),
(1607, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'You are logged in as Admin', 'You are logged in as Admin', 0, 0, 0),
(1608, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Follow', 'Follow', 0, 0, 0),
(1609, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'How It Works', 'How It Works', 0, 0, 0),
(1610, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Refer a Friend', 'Refer a Friend', 0, 0, 0),
(1611, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Join Us', 'Join Us', 0, 0, 0),
(1612, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Join us', 'Join us', 0, 0, 0),
(1613, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Inbox', 'Inbox', 0, 0, 0),
(1614, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Hi, ', 'Hi, ', 0, 0, 0),
(1615, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Balance: ', 'Balance: ', 0, 0, 0),
(1616, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'My Merchant', 'My Merchant', 0, 0, 0),
(1617, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'My %s', 'My %s', 0, 0, 0),
(1618, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'My Transactions', 'My Transactions', 0, 0, 0),
(1619, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'My Friends', 'My Friends', 0, 0, 0),
(1620, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Import Friends', 'Import Friends', 0, 0, 0),
(1621, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Transfer Accounts', 'Transfer Accounts', 0, 0, 0),
(1622, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Home', 'Home', 0, 0, 0),
(1623, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'About', 'About', 0, 0, 0),
(1624, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'FAQ', 'FAQ', 0, 0, 0),
(1625, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Get a Free Item!!!', 'Get a Free Item!!!', 0, 0, 0),
(1626, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Get', 'Get', 0, 0, 0),
(1627, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Refer', 'Refer', 0, 0, 0),
(1628, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Item Etiquette', 'Item Etiquette', 0, 0, 0),
(1629, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Follow Us in Twitter', 'Follow Us in Twitter', 0, 0, 0),
(1630, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'RSS', 'RSS', 0, 0, 0),
(1631, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'RSS Feed', 'RSS Feed', 0, 0, 0),
(1632, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, '%s items builds friendship among any radicals. Reserve any theme of your choice to meet a group of new people and discover new neighborhoods and group activities.', '%s items builds friendship among any radicals. Reserve any theme of your choice to meet a group of new people and discover new neighborhoods and group activities.', 0, 0, 0),
(1633, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Top', 'Top', 0, 0, 0),
(1634, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Current time: ', 'Current time: ', 0, 0, 0),
(1635, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Last login: ', 'Last login: ', 0, 0, 0),
(1636, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Powered by GroupWithUs', 'Powered by GroupWithUs', 0, 0, 0),
(1637, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Items Best in', 'Items Best in', 0, 0, 0),
(1638, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Visit More Cities', 'Visit More Cities', 0, 0, 0),
(1639, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Today''s Items', 'Today''s Items', 0, 0, 0),
(1640, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'How', 'How', 0, 0, 0),
(1641, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Works', 'Works', 0, 0, 0),
(1642, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, ' Works', ' Works', 0, 0, 0),
(1643, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Hi, Guest', 'Hi, Guest', 0, 0, 0),
(1644, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Register', 'Register', 0, 0, 0),
(1645, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Regular Version', 'Regular Version', 0, 0, 0),
(1646, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Welcome, Guest', 'Welcome, Guest', 0, 0, 0),
(1647, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Discussion', 'Discussion', 0, 0, 0),
(1648, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'How %s Works', 'How %s Works', 0, 0, 0),
(1649, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Contact us', 'Contact us', 0, 0, 0),
(1650, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Terms & Policies', 'Terms & Policies', 0, 0, 0),
(1651, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Terms, Privacy, Returns, Etc.', 'Terms, Privacy, Returns, Etc.', 0, 0, 0),
(1652, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Learn More', 'Learn More', 0, 0, 0),
(1653, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Follow Us', 'Follow Us', 0, 0, 0),
(1654, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'See Our Profile in Facebook', 'See Our Profile in Facebook', 0, 0, 0),
(1655, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Subscribe to Daily Email', 'Subscribe to Daily Email', 0, 0, 0),
(1656, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Topics', 'Topics', 0, 0, 0),
(1657, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Collective Buying Power', 'Collective Buying Power', 0, 0, 0),
(1658, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'MailChimp module is currently enabled. You can disable or configure it from', 'MailChimp module is currently enabled. You can disable or configure it from', 0, 0, 0),
(1659, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Note that, if the unique list ID is empty, mail will be sent through our server only. For configuring MailChimp', 'Note that, if the unique list ID is empty, mail will be sent through our server only. For configuring MailChimp', 0, 0, 0),
(1660, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'http://dev1products.dev.agriya.com/doku.php?id=mailchimp-integration', 'http://dev1products.dev.agriya.com/doku.php?id=mailchimp-integration', 0, 0, 0),
(1661, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Mail chimp integration', 'Mail chimp integration', 0, 0, 0),
(1662, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'List ID', 'List ID', 0, 0, 0),
(1663, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'It is the unique ID of the mailchimp list', 'It is the unique ID of the mailchimp list', 0, 0, 0),
(1664, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Merchant Name', 'Merchant Name', 0, 0, 0),
(1665, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Phone', 'Phone', 0, 0, 0),
(1666, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'eg. http://www.example.com', 'eg. http://www.example.com', 0, 0, 0),
(1667, '2012-03-06 17:37:10', '2012-03-06 17:37:10', 42, 'Online Account', 'Online Account', 0, 0, 0),
(1668, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Only online merchant can login and make payment via site. Offline merchant can process manually. ', 'Only online merchant can login and make payment via site. Offline merchant can process manually. ', 0, 0, 0),
(1669, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Address1', 'Address1', 0, 0, 0),
(1670, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Address2', 'Address2', 0, 0, 0),
(1671, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Zip', 'Zip', 0, 0, 0),
(1672, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Merchant Profile', 'Merchant Profile', 0, 0, 0),
(1673, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Enable merchant profile', 'Enable merchant profile', 0, 0, 0),
(1674, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Whether other users can view the merchant profile or not', 'Whether other users can view the merchant profile or not', 0, 0, 0),
(1675, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Paypal Account', 'Paypal Account', 0, 0, 0),
(1676, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Locate yourself on google maps', 'Locate yourself on google maps', 0, 0, 0),
(1677, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'You can change the google map zooming level here, else default zooming level will be taken.', 'You can change the google map zooming level here, else default zooming level will be taken.', 0, 0, 0),
(1678, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Available Balance: ', 'Available Balance: ', 0, 0, 0),
(1679, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Change Image', 'Change Image', 0, 0, 0),
(1680, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Profile', 'Profile', 0, 0, 0),
(1681, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Upload Logo', 'Upload Logo', 0, 0, 0),
(1682, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Active Merchants', 'Active Merchants', 0, 0, 0),
(1683, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Inactive Merchants', 'Inactive Merchants', 0, 0, 0),
(1684, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Online Merchants', 'Online Merchants', 0, 0, 0),
(1685, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Offline Merchants', 'Offline Merchants', 0, 0, 0),
(1686, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Affiliate Merchants', 'Affiliate Merchants', 0, 0, 0),
(1687, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Total Merchants', 'Total Merchants', 0, 0, 0),
(1688, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, '\\"online\\" merchants accounts are managed by merchants themselves and they''ll have login details.', '\\"online\\" merchants accounts are managed by merchants themselves and they''ll have login details.', 0, 0, 0),
(1689, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'for info.', 'for info.', 0, 0, 0),
(1690, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, '\\"offline\\" merchants accounts cannot login into the site. To set amount the money paid for a offline merchants, use ''Set as Paid''.', '\\"offline\\" merchants accounts cannot login into the site. To set amount the money paid for a offline merchants, use ''Set as Paid''.', 0, 0, 0),
(1691, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Site Revenue', 'Site Revenue', 0, 0, 0),
(1692, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Views', 'Views', 0, 0, 0),
(1693, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Logins', 'Logins', 0, 0, 0),
(1694, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Registered on', 'Registered on', 0, 0, 0),
(1695, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Count', 'Count', 0, 0, 0),
(1696, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Time', 'Time', 0, 0, 0),
(1697, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Resend Activation', 'Resend Activation', 0, 0, 0),
(1698, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Successful', 'Successful', 0, 0, 0),
(1699, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Unsuccessful', 'Unsuccessful', 0, 0, 0),
(1700, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Withdrawn', 'Withdrawn', 0, 0, 0),
(1701, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'No Merchants available', 'No Merchants available', 0, 0, 0),
(1702, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Disabled', 'Disabled', 0, 0, 0),
(1703, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Enabled', 'Enabled', 0, 0, 0),
(1704, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Job Info', 'Job Info', 0, 0, 0),
(1705, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'School Info', 'School Info', 0, 0, 0),
(1706, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Profile Language', 'Profile Language', 0, 0, 0),
(1707, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'This will be the default site languge after logged in', 'This will be the default site languge after logged in', 0, 0, 0),
(1708, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Locate Yourself on Google Maps', 'Locate Yourself on Google Maps', 0, 0, 0),
(1709, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Please update address info to generate location Map', 'Please update address info to generate location Map', 0, 0, 0),
(1710, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Branch Address', 'Branch Address', 0, 0, 0),
(1711, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Item Owned', 'Item Owned', 0, 0, 0),
(1712, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Referred Users', 'Referred Users', 0, 0, 0),
(1713, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Item Purchased', 'Item Purchased', 0, 0, 0),
(1714, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Items Owned', 'Items Owned', 0, 0, 0),
(1715, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Items Purchased', 'Items Purchased', 0, 0, 0),
(1716, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Add Your comments', 'Add Your comments', 0, 0, 0),
(1717, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Profile Enabled', 'Profile Enabled', 0, 0, 0),
(1718, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Available Balance Amount', 'Available Balance Amount', 0, 0, 0),
(1719, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Compose Message', 'Compose Message', 0, 0, 0),
(1720, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'to me', 'to me', 0, 0, 0),
(1721, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'OR', 'OR', 0, 0, 0),
(1722, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'To', 'To', 0, 0, 0),
(1723, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Admin Suspended', 'Admin Suspended', 0, 0, 0),
(1724, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'System Flagged', 'System Flagged', 0, 0, 0),
(1725, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'No messages available', 'No messages available', 0, 0, 0),
(1726, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Compose', 'Compose', 0, 0, 0),
(1727, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Save', 'Save', 0, 0, 0),
(1728, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Discard', 'Discard', 0, 0, 0),
(1729, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Add more attachment', 'Add more attachment', 0, 0, 0),
(1730, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Remove attachment', 'Remove attachment', 0, 0, 0),
(1731, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Edit Message', 'Edit Message', 0, 0, 0),
(1732, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'See All', 'See All', 0, 0, 0),
(1733, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'You have', 'You have', 0, 0, 0),
(1734, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'messages', 'messages', 0, 0, 0),
(1735, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'My ', 'My ', 0, 0, 0),
(1736, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, ' Messages', ' Messages', 0, 0, 0),
(1737, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'You''ve used', 'You''ve used', 0, 0, 0),
(1738, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, '% of your', '% of your', 0, 0, 0),
(1739, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'message limit', 'message limit', 0, 0, 0),
(1740, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'You are exceeding the allowed messages quoto. Please delete some messages from your inbox/sent/trash folders', 'You are exceeding the allowed messages quoto. Please delete some messages from your inbox/sent/trash folders', 0, 0, 0),
(1741, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Archive', 'Archive', 0, 0, 0),
(1742, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Notspam', 'Notspam', 0, 0, 0),
(1743, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Spam', 'Spam', 0, 0, 0),
(1744, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'All,', 'All,', 0, 0, 0),
(1745, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'None,', 'None,', 0, 0, 0),
(1746, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Read,', 'Read,', 0, 0, 0),
(1747, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Read', 'Read', 0, 0, 0),
(1748, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Unread', 'Unread', 0, 0, 0),
(1749, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Star', 'Star', 0, 0, 0),
(1750, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'To: ', 'To: ', 0, 0, 0),
(1751, '2012-03-06 17:37:11', '2012-03-06 17:37:11', 42, 'Me   : ', 'Me   : ', 0, 0, 0),
(1752, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'messages available', 'messages available', 0, 0, 0),
(1753, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Refresh', 'Refresh', 0, 0, 0),
(1754, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Sent Mail', 'Sent Mail', 0, 0, 0),
(1755, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Starred', 'Starred', 0, 0, 0),
(1756, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Drafts', 'Drafts', 0, 0, 0),
(1757, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'All Mail', 'All Mail', 0, 0, 0),
(1758, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Trash', 'Trash', 0, 0, 0),
(1759, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Search results', 'Search results', 0, 0, 0),
(1760, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Unread,', 'Unread,', 0, 0, 0),
(1761, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Starred,', 'Starred,', 0, 0, 0),
(1762, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Unstarred', 'Unstarred', 0, 0, 0),
(1763, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'me', 'me', 0, 0, 0),
(1764, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'No messages matched your search.', 'No messages matched your search.', 0, 0, 0),
(1765, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Edit profile', 'Edit profile', 0, 0, 0),
(1766, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Invite Friends', 'Invite Friends', 0, 0, 0),
(1767, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'General Settings', 'General Settings', 0, 0, 0),
(1768, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Message Page Size', 'Message Page Size', 0, 0, 0),
(1769, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Show conversations per page', 'Show conversations per page', 0, 0, 0),
(1770, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Message Signature', 'Message Signature', 0, 0, 0),
(1771, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Back to Label', 'Back to Label', 0, 0, 0),
(1772, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Back to Starred', 'Back to Starred', 0, 0, 0),
(1773, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Back to %s', 'Back to %s', 0, 0, 0),
(1774, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Project', 'Project', 0, 0, 0),
(1775, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'star-select', 'star-select', 0, 0, 0),
(1776, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'show details', 'show details', 0, 0, 0),
(1777, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'from', 'from', 0, 0, 0),
(1778, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'to', 'to', 0, 0, 0),
(1779, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'date', 'date', 0, 0, 0),
(1780, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'at', 'at', 0, 0, 0),
(1781, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'subject', 'subject', 0, 0, 0),
(1782, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Pledge', 'Pledge', 0, 0, 0),
(1783, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Reward', 'Reward', 0, 0, 0),
(1784, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'No reward', 'No reward', 0, 0, 0),
(1785, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Reply', 'Reply', 0, 0, 0),
(1786, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Forward', 'Forward', 0, 0, 0),
(1787, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'attachments', 'attachments', 0, 0, 0),
(1788, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Download', 'Download', 0, 0, 0),
(1789, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'In order to withdrawal cash/amount from your account balance in the site, You first need to create a ''Money tranfer account''. You can also add multiple transfer accounts with different gateways and mark any one of them as ''Primary''. The approved withdrawal amount from your account balance will be credited to the ''Primary'' marked transfer account.', 'In order to withdrawal cash/amount from your account balance in the site, You first need to create a ''Money tranfer account''. You can also add multiple transfer accounts with different gateways and mark any one of them as ''Primary''. The approved withdrawal amount from your account balance will be credited to the ''Primary'' marked transfer account.', 0, 0, 0),
(1790, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Primary', 'Primary', 0, 0, 0),
(1791, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Make as primary', 'Make as primary', 0, 0, 0),
(1792, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'No money transfer account available', 'No money transfer account available', 0, 0, 0),
(1793, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Change', 'Change', 0, 0, 0),
(1794, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Page title', 'Page title', 0, 0, 0),
(1795, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Body', 'Body', 0, 0, 0),
(1796, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Available Variables: ##SITE_NAME##, ##SITE_URL##, ##ABOUT_US_URL##, ##CONTACT_US_URL##, ##FAQ_URL##', 'Available Variables: ##SITE_NAME##, ##SITE_URL##, ##ABOUT_US_URL##, ##CONTACT_US_URL##, ##FAQ_URL##', 0, 0, 0),
(1797, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Description Meta Tag', 'Description Meta Tag', 0, 0, 0),
(1798, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Slug', 'Slug', 0, 0, 0),
(1799, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'When you create link for this page, url should be page/value of this field.', 'When you create link for this page, url should be page/value of this field.', 0, 0, 0),
(1800, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Available Variables: ##SITE_NAME##, ##SITE_URL##, ##ABOUT_US_URL##, ##CONTACT_US_URL##, ##FAQ_URL##, ##SITE_CONTACT_PHONE##, ##SITE_CONTACT_EMAIL##', 'Available Variables: ##SITE_NAME##, ##SITE_URL##, ##ABOUT_US_URL##, ##CONTACT_US_URL##, ##FAQ_URL##, ##SITE_CONTACT_PHONE##, ##SITE_CONTACT_EMAIL##', 0, 0, 0),
(1801, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'If you change value of this field then don''t forget to update links created for this page. It should be page/value of this field.', 'If you change value of this field then don''t forget to update links created for this page. It should be page/value of this field.', 0, 0, 0),
(1802, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Upload Site Logo', 'Upload Site Logo', 0, 0, 0),
(1803, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Upload Background Image', 'Upload Background Image', 0, 0, 0),
(1804, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Content', 'Content', 0, 0, 0),
(1805, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'No Pages available', 'No Pages available', 0, 0, 0),
(1806, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Refer Friends and Get %s %s Bucks! ', 'Refer Friends and Get %s %s Bucks! ', 0, 0, 0),
(1807, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Get %s in %s Bucks when someone you invite gets their first %s. There is no limit on how much you can earn!', 'Get %s in %s Bucks when someone you invite gets their first %s. There is no limit on how much you can earn!', 0, 0, 0),
(1808, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Mail it', 'Mail it', 0, 0, 0),
(1809, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Check out %s daily item for coolest stuff in your city. ', 'Check out %s daily item for coolest stuff in your city. ', 0, 0, 0),
(1810, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Share it on Facebook', 'Share it on Facebook', 0, 0, 0),
(1811, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Tweet it', 'Tweet it', 0, 0, 0),
(1812, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, ' or ', ' or ', 0, 0, 0),
(1813, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Setup Your Account', 'Setup Your Account', 0, 0, 0),
(1814, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Signup', 'Signup', 0, 0, 0),
(1815, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, ' to get your personal referral link.', ' to get your personal referral link.', 0, 0, 0),
(1816, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Referral FAQ', 'Referral FAQ', 0, 0, 0),
(1817, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'What is this?', 'What is this?', 0, 0, 0),
(1818, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'We are giving %s in %s Bucks for every friend you refer when they make their first purchase. It is our way of saying \\"thanks\\" for spreading the word and increasing our collective buying power! %s Bucks can be used toward any %s purchase, and they never expire.', 'We are giving %s in %s Bucks for every friend you refer when they make their first purchase. It is our way of saying \\"thanks\\" for spreading the word and increasing our collective buying power! %s Bucks can be used toward any %s purchase, and they never expire.', 0, 0, 0),
(1819, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'How do I participate?', 'How do I participate?', 0, 0, 0),
(1820, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Share your personalized referral link using the tools to your left. When someone clicks that link, we will know you sent them.', 'Share your personalized referral link using the tools to your left. When someone clicks that link, we will know you sent them.', 0, 0, 0),
(1821, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'What are the rules?', 'What are the rules?', 0, 0, 0),
(1822, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'If someone joins %s within %s hours after clicking your link, we will notify you within %s hours of their first purchase and automatically add %s %s Bucks to your account. You can refer as many people as you like. Check your balance by clicking My Stuff > My Transactions.', 'If someone joins %s within %s hours after clicking your link, we will notify you within %s hours of their first purchase and automatically add %s %s Bucks to your account. You can refer as many people as you like. Check your balance by clicking My Stuff > My Transactions.', 0, 0, 0),
(1823, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, '', '', 0, 0, 0),
(1824, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Share your unique referral link that you''ll get after your purchase a item.', 'Share your unique referral link that you''ll get after your purchase a item.', 0, 0, 0),
(1825, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'When cron is not working, you may trigger it by clicking below link. For the processes that happen during a cron run, refer the ', 'When cron is not working, you may trigger it by clicking below link. For the processes that happen during a cron run, refer the ', 0, 0, 0),
(1826, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Trigger Cron Manually to update item status', 'Trigger Cron Manually to update item status', 0, 0, 0),
(1827, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Trigger cron functions manually to update item status (If for some reasons, cron is not getting triggered, clicking this link will trigger the functionality)', 'Trigger cron functions manually to update item status (If for some reasons, cron is not getting triggered, clicking this link will trigger the functionality)', 0, 0, 0),
(1828, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Manually trigger cron to update currency conversion rate', 'Manually trigger cron to update currency conversion rate', 0, 0, 0),
(1829, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'You can use this to update currency conversion rate. This will be used in the scenario where cron is not working', 'You can use this to update currency conversion rate. This will be used in the scenario where cron is not working', 0, 0, 0),
(1830, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Business', 'Business', 0, 0, 0),
(1831, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Sign Up / Sign In', 'Sign Up / Sign In', 0, 0, 0),
(1832, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Sign in with Facebook', 'Sign in with Facebook', 0, 0, 0),
(1833, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Sign in with Foursquare', 'Sign in with Foursquare', 0, 0, 0),
(1834, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Sign in with Twitter', 'Sign in with Twitter', 0, 0, 0),
(1835, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Sign in with Yahoo', 'Sign in with Yahoo', 0, 0, 0),
(1836, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, '[Image: Yahoo]', '[Image: Yahoo]', 0, 0, 0),
(1837, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Sign in with Gmail', 'Sign in with Gmail', 0, 0, 0),
(1838, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, '[Image: Gmail]', '[Image: Gmail]', 0, 0, 0),
(1839, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Sign in with OpenID', 'Sign in with OpenID', 0, 0, 0),
(1840, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Terms of Use', 'Terms of Use', 0, 0, 0),
(1841, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Branding Requirements', 'Branding Requirements', 0, 0, 0),
(1842, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'API Instructions', 'API Instructions', 0, 0, 0),
(1843, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Continue Editing', 'Continue Editing', 0, 0, 0),
(1844, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Add Payment Gateway Settings', 'Add Payment Gateway Settings', 0, 0, 0),
(1845, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Edit %s Settings', 'Edit %s Settings', 0, 0, 0),
(1846, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Payment Gateway Setting Update', 'Payment Gateway Setting Update', 0, 0, 0),
(1847, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Sorry no settings added.', 'Sorry no settings added.', 0, 0, 0),
(1848, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Test Mode?', 'Test Mode?', 0, 0, 0),
(1849, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Enable for Mass Pay', 'Enable for Mass Pay', 0, 0, 0),
(1850, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'On enabling this, admin can use this gateway to transfer amount to multiple users.', 'On enabling this, admin can use this gateway to transfer amount to multiple users.', 0, 0, 0),
(1851, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Enable for Item Purchase', 'Enable for Item Purchase', 0, 0, 0),
(1852, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Enable add to wallet', 'Enable add to wallet', 0, 0, 0),
(1853, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Payee Details', 'Payee Details', 0, 0, 0),
(1854, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Mass Payment Details', 'Mass Payment Details', 0, 0, 0),
(1855, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Masspay used to send money to user.', 'Masspay used to send money to user.', 0, 0, 0),
(1856, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Create masspay API from paypal profile. Refer', 'Create masspay API from paypal profile. Refer', 0, 0, 0),
(1857, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Direct Payment Details', 'Direct Payment Details', 0, 0, 0),
(1858, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Direct pay allowed user to pay directly from credit card using capture authorization and void concept.', 'Direct pay allowed user to pay directly from credit card using capture authorization and void concept.', 0, 0, 0),
(1859, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'It will let the user to pay only at the item tipped state.', 'It will let the user to pay only at the item tipped state.', 0, 0, 0),
(1860, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'display_name', 'display_name', 0, 0, 0),
(1861, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Where to use?', 'Where to use?', 0, 0, 0),
(1862, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Mass Pay', 'Mass Pay', 0, 0, 0),
(1863, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Add to Wallet', 'Add to Wallet', 0, 0, 0),
(1864, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Item Purchase', 'Item Purchase', 0, 0, 0),
(1865, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'No Payment Gateways available', 'No Payment Gateways available', 0, 0, 0),
(1866, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Direct Payment', 'Direct Payment', 0, 0, 0),
(1867, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Direct Capture', 'Direct Capture', 0, 0, 0),
(1868, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Direct Void', 'Direct Void', 0, 0, 0),
(1869, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'No Paypal Docapture Logs available', 'No Paypal Docapture Logs available', 0, 0, 0),
(1870, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Date Added', 'Date Added', 0, 0, 0),
(1871, '2012-03-06 17:37:12', '2012-03-06 17:37:12', 42, 'Authorizationid', 'Authorizationid', 0, 0, 0),
(1872, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Currencycode', 'Currencycode', 0, 0, 0),
(1873, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Dodirectpayment Correlationid', 'Dodirectpayment Correlationid', 0, 0, 0),
(1874, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Dodirectpayment Ack', 'Dodirectpayment Ack', 0, 0, 0),
(1875, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Dodirectpayment Build', 'Dodirectpayment Build', 0, 0, 0),
(1876, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Dodirectpayment Amt', 'Dodirectpayment Amt', 0, 0, 0),
(1877, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Dodirectpayment Avscode', 'Dodirectpayment Avscode', 0, 0, 0),
(1878, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Dodirectpayment Cvv2match', 'Dodirectpayment Cvv2match', 0, 0, 0),
(1879, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Dodirectpayment Response', 'Dodirectpayment Response', 0, 0, 0),
(1880, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Version', 'Version', 0, 0, 0),
(1881, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Dodirectpayment Timestamp', 'Dodirectpayment Timestamp', 0, 0, 0),
(1882, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Timestamp', 'Docapture Timestamp', 0, 0, 0),
(1883, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Correlationid', 'Docapture Correlationid', 0, 0, 0),
(1884, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Ack', 'Docapture Ack', 0, 0, 0),
(1885, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Build', 'Docapture Build', 0, 0, 0),
(1886, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Transactionid', 'Docapture Transactionid', 0, 0, 0),
(1887, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Parenttransactionid', 'Docapture Parenttransactionid', 0, 0, 0),
(1888, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Receiptid', 'Docapture Receiptid', 0, 0, 0),
(1889, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Transactiontype', 'Docapture Transactiontype', 0, 0, 0),
(1890, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Paymenttype', 'Docapture Paymenttype', 0, 0, 0),
(1891, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Ordertime', 'Docapture Ordertime', 0, 0, 0),
(1892, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Amt', 'Docapture Amt', 0, 0, 0),
(1893, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Feeamt', 'Docapture Feeamt', 0, 0, 0),
(1894, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Taxamt', 'Docapture Taxamt', 0, 0, 0),
(1895, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Paymentstatus', 'Docapture Paymentstatus', 0, 0, 0),
(1896, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Pendingreason', 'Docapture Pendingreason', 0, 0, 0),
(1897, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Reasoncode', 'Docapture Reasoncode', 0, 0, 0),
(1898, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Protectioneligibility', 'Docapture Protectioneligibility', 0, 0, 0),
(1899, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Docapture Response', 'Docapture Response', 0, 0, 0),
(1900, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Dovoid Timestamp', 'Dovoid Timestamp', 0, 0, 0),
(1901, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Dovoid Correlationid', 'Dovoid Correlationid', 0, 0, 0),
(1902, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Dovoid Ack', 'Dovoid Ack', 0, 0, 0),
(1903, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Dovoid Build', 'Dovoid Build', 0, 0, 0),
(1904, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Dovoid Response', 'Dovoid Response', 0, 0, 0),
(1905, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Transaction ID', 'Transaction ID', 0, 0, 0),
(1906, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'User email', 'User email', 0, 0, 0),
(1907, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Fees', 'Fees', 0, 0, 0),
(1908, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Authorization', 'Authorization', 0, 0, 0),
(1909, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture', 'Capture', 0, 0, 0),
(1910, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Void', 'Void', 0, 0, 0),
(1911, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'New User', 'New User', 0, 0, 0),
(1912, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'No Paypal Transaction Logs available', 'No Paypal Transaction Logs available', 0, 0, 0),
(1913, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Transaction', 'Transaction', 0, 0, 0),
(1914, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Ip', 'Ip', 0, 0, 0),
(1915, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Currency Type', 'Currency Type', 0, 0, 0),
(1916, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Txn Id', 'Txn Id', 0, 0, 0),
(1917, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Payer Email', 'Payer Email', 0, 0, 0),
(1918, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Payment Date', 'Payment Date', 0, 0, 0),
(1919, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'To Digicurrency', 'To Digicurrency', 0, 0, 0),
(1920, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'To Account No', 'To Account No', 0, 0, 0),
(1921, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'To Account Name', 'To Account Name', 0, 0, 0),
(1922, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Fees Paid By', 'Fees Paid By', 0, 0, 0),
(1923, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Mc Gross', 'Mc Gross', 0, 0, 0),
(1924, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Mc Fee', 'Mc Fee', 0, 0, 0),
(1925, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Mc Currency', 'Mc Currency', 0, 0, 0),
(1926, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Pending Reason', 'Pending Reason', 0, 0, 0),
(1927, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Receiver Email', 'Receiver Email', 0, 0, 0),
(1928, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Paypal Response', 'Paypal Response', 0, 0, 0),
(1929, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Error No', 'Error No', 0, 0, 0),
(1930, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Error Message', 'Error Message', 0, 0, 0),
(1931, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Memo', 'Memo', 0, 0, 0),
(1932, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Paypal Post Vars', 'Paypal Post Vars', 0, 0, 0),
(1933, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Is Mass Pay', 'Is Mass Pay', 0, 0, 0),
(1934, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Mass Pay Status', 'Mass Pay Status', 0, 0, 0),
(1935, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Masspay Response', 'Masspay Response', 0, 0, 0),
(1936, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'User Cash Withdrawal Id', 'User Cash Withdrawal Id', 0, 0, 0),
(1937, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Charity Cash Withdrawal Id', 'Charity Cash Withdrawal Id', 0, 0, 0),
(1938, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Affiliate Cash Withdrawal Id', 'Affiliate Cash Withdrawal Id', 0, 0, 0),
(1939, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Is Authorization', 'Is Authorization', 0, 0, 0),
(1940, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Authorization Auth Exp', 'Authorization Auth Exp', 0, 0, 0),
(1941, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Authorization Transaction Entity', 'Authorization Transaction Entity', 0, 0, 0),
(1942, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Authorization Parent Txn Id', 'Authorization Parent Txn Id', 0, 0, 0),
(1943, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Authorization Remaining Settle', 'Authorization Remaining Settle', 0, 0, 0),
(1944, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Authorization Auth Id', 'Authorization Auth Id', 0, 0, 0),
(1945, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Authorization Auth Amount', 'Authorization Auth Amount', 0, 0, 0),
(1946, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Authorization Pending Reason', 'Authorization Pending Reason', 0, 0, 0),
(1947, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Authorization Payment Gross', 'Authorization Payment Gross', 0, 0, 0),
(1948, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Authorization Auth Status', 'Authorization Auth Status', 0, 0, 0),
(1949, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Authorization Data', 'Authorization Data', 0, 0, 0),
(1950, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Authorizationid', 'Capture Authorizationid', 0, 0, 0),
(1951, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Timestamp', 'Capture Timestamp', 0, 0, 0),
(1952, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Correlationid', 'Capture Correlationid', 0, 0, 0),
(1953, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Ack', 'Capture Ack', 0, 0, 0),
(1954, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Version', 'Capture Version', 0, 0, 0),
(1955, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Build', 'Capture Build', 0, 0, 0),
(1956, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Transactionid', 'Capture Transactionid', 0, 0, 0),
(1957, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Parenttransactionid', 'Capture Parenttransactionid', 0, 0, 0),
(1958, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Transactiontype', 'Capture Transactiontype', 0, 0, 0),
(1959, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Paymenttype', 'Capture Paymenttype', 0, 0, 0),
(1960, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Expectedecheckcleardate', 'Capture Expectedecheckcleardate', 0, 0, 0),
(1961, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Ordertime', 'Capture Ordertime', 0, 0, 0),
(1962, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Amt', 'Capture Amt', 0, 0, 0),
(1963, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Feeamt', 'Capture Feeamt', 0, 0, 0),
(1964, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Taxamt', 'Capture Taxamt', 0, 0, 0),
(1965, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Currencycode', 'Capture Currencycode', 0, 0, 0),
(1966, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Paymentstatus', 'Capture Paymentstatus', 0, 0, 0),
(1967, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Shippingmethod', 'Capture Shippingmethod', 0, 0, 0),
(1968, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Pendingreason', 'Capture Pendingreason', 0, 0, 0),
(1969, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Reasoncode', 'Capture Reasoncode', 0, 0, 0),
(1970, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Protectioneligibility', 'Capture Protectioneligibility', 0, 0, 0),
(1971, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Capture Data', 'Capture Data', 0, 0, 0),
(1972, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Void Timestamp', 'Void Timestamp', 0, 0, 0),
(1973, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Void Correlationid', 'Void Correlationid', 0, 0, 0),
(1974, '2012-03-06 17:37:13', '2012-03-06 17:37:13', 42, 'Void Ack', 'Void Ack', 0, 0, 0),
(1975, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Void Data', 'Void Data', 0, 0, 0),
(1976, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Converted Currency', 'Converted Currency', 0, 0, 0),
(1977, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Orginal Amount', 'Orginal Amount', 0, 0, 0),
(1978, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Label', 'Label', 0, 0, 0),
(1979, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Setting Category', 'Setting Category', 0, 0, 0),
(1980, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Translations add', 'Translations add', 0, 0, 0),
(1981, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Application Info', 'Application Info', 0, 0, 0);
INSERT INTO `translations` (`id`, `created`, `modified`, `language_id`, `key`, `lang_text`, `is_translated`, `is_google_translate`, `is_verified`) VALUES
(1982, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Other Info', 'Other Info', 0, 0, 0),
(1983, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Here you can update Facebook credentials . Click ''Update Facebook Credentials'' link below and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.', 'Here you can update Facebook credentials . Click ''Update Facebook Credentials'' link below and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.', 0, 0, 0),
(1984, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Here you can update Twitter credentials like Access key and Accss Token. Click ''Update Twitter Credentials'' link below and Follow the steps. Please make sure that you have updated the Consumer Key and  Consumer secret before you click this link.', 'Here you can update Twitter credentials like Access key and Accss Token. Click ''Update Twitter Credentials'' link below and Follow the steps. Please make sure that you have updated the Consumer Key and  Consumer secret before you click this link.', 0, 0, 0),
(1985, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Here you can update Foursquare credentials . Click  ''Update Foursquare Credentials'' link below and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.', 'Here you can update Foursquare credentials . Click  ''Update Foursquare Credentials'' link below and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.', 0, 0, 0),
(1986, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, '<span>Update Facebook Credentials</span>', '<span>Update Facebook Credentials</span>', 0, 0, 0),
(1987, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Here you can update Facebook credentials . Click this link and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.', 'Here you can update Facebook credentials . Click this link and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.', 0, 0, 0),
(1988, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, '<span>Update Twitter Credentials</span>', '<span>Update Twitter Credentials</span>', 0, 0, 0),
(1989, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Here you can update Twitter credentials like Access key and Accss Token. Click this link and Follow the steps. Please make sure that you have updated the Consumer Key and  Consumer secret before you click this link.', 'Here you can update Twitter credentials like Access key and Accss Token. Click this link and Follow the steps. Please make sure that you have updated the Consumer Key and  Consumer secret before you click this link.', 0, 0, 0),
(1990, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, '<span>Update Foursquare Credentials</span>', '<span>Update Foursquare Credentials</span>', 0, 0, 0),
(1991, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Here you can update Foursquare credentials . Click this link and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.', 'Here you can update Foursquare credentials . Click this link and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.', 0, 0, 0),
(1992, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Here you can update and modify affiliate types', 'Here you can update and modify affiliate types', 0, 0, 0),
(1993, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'hrs', 'hrs', 0, 0, 0),
(1994, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Merchant add', 'Merchant add', 0, 0, 0),
(1995, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Merchant edit', 'Merchant edit', 0, 0, 0),
(1996, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'registration', 'registration', 0, 0, 0),
(1997, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Not Allow Beyond Original', 'Not Allow Beyond Original', 0, 0, 0),
(1998, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Allow Handle Aspect', 'Allow Handle Aspect', 0, 0, 0),
(1999, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'No settings available', 'No settings available', 0, 0, 0),
(2000, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'No Site Categories available', 'No Site Categories available', 0, 0, 0),
(2001, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Is Active', 'Is Active', 0, 0, 0),
(2002, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Approved Records', 'Approved Records', 0, 0, 0),
(2003, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Disapproved Records', 'Disapproved Records', 0, 0, 0),
(2004, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Add New State', 'Add New State', 0, 0, 0),
(2005, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Click here to Disapprove', 'Click here to Disapprove', 0, 0, 0),
(2006, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Disapproved', 'Disapproved', 0, 0, 0),
(2007, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Click here to Approve', 'Click here to Approve', 0, 0, 0),
(2008, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'No states available', 'No states available', 0, 0, 0),
(2009, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Enter your Email address:', 'Enter your Email address:', 0, 0, 0),
(2010, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'We''ll never share your e-mail address)', 'We''ll never share your e-mail address)', 0, 0, 0),
(2011, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Choose your city:', 'Choose your city:', 0, 0, 0),
(2012, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Subscribe', 'Subscribe', 0, 0, 0),
(2013, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Sign in', 'Sign in', 0, 0, 0),
(2014, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Admin', 'Admin', 0, 0, 0),
(2015, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Already Registered', 'Already Registered', 0, 0, 0),
(2016, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Enter your email address:', 'Enter your email address:', 0, 0, 0),
(2017, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Don''t worry, your email is safe and secure with us.', 'Don''t worry, your email is safe and secure with us.', 0, 0, 0),
(2018, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Welcome to', 'Welcome to', 0, 0, 0),
(2019, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Every day, %s e-mails you one exclusive offer to do, see, taste, or experience something amazing in', 'Every day, %s e-mails you one exclusive offer to do, see, taste, or experience something amazing in', 0, 0, 0),
(2020, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'at an unbeatable price.', 'at an unbeatable price.', 0, 0, 0),
(2021, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Sign up now for free, and prepare to discover', 'Sign up now for free, and prepare to discover', 0, 0, 0),
(2022, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'at 40% to 90% off! ', 'at 40% to 90% off! ', 0, 0, 0),
(2023, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, '(We''ll never share your e-mail address) ', '(We''ll never share your e-mail address) ', 0, 0, 0),
(2024, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Get item updates in ', 'Get item updates in ', 0, 0, 0),
(2025, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Count Me In', 'Count Me In', 0, 0, 0),
(2026, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Subscribed', 'Subscribed', 0, 0, 0),
(2027, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Unsubscribed', 'Unsubscribed', 0, 0, 0),
(2028, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Subscribed On', 'Subscribed On', 0, 0, 0),
(2029, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'No Subscriptions available', 'No Subscriptions available', 0, 0, 0),
(2030, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'You can change the background image for the \\"Two Step Subscription\\" page.', 'You can change the background image for the \\"Two Step Subscription\\" page.', 0, 0, 0),
(2031, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'If background image is uploaded, background color will not appear.', 'If background image is uploaded, background color will not appear.', 0, 0, 0),
(2032, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'If height and width is not specified, original image will be set as background image.', 'If height and width is not specified, original image will be set as background image.', 0, 0, 0),
(2033, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Background Color', 'Background Color', 0, 0, 0),
(2034, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Background Image Width', 'Background Image Width', 0, 0, 0),
(2035, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Background Image Height', 'Background Image Height', 0, 0, 0),
(2036, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Background image center?', 'Background image center?', 0, 0, 0),
(2037, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Confirmation', 'Confirmation', 0, 0, 0),
(2038, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Thanks for your subscriptions!', 'Thanks for your subscriptions!', 0, 0, 0),
(2039, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'We will notify you when new items on your city....', 'We will notify you when new items on your city....', 0, 0, 0),
(2040, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Manage Your Subscriptions', 'Manage Your Subscriptions', 0, 0, 0),
(2041, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Oops, i changed my mind', 'Oops, i changed my mind', 0, 0, 0),
(2042, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Manage Your Subscription', 'Manage Your Subscription', 0, 0, 0),
(2043, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Are sure you want to unsubscribe?', 'Are sure you want to unsubscribe?', 0, 0, 0),
(2044, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Manage Your Unsubscriptions', 'Manage Your Unsubscriptions', 0, 0, 0),
(2045, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Contacts found in your friends list', 'Contacts found in your friends list', 0, 0, 0),
(2046, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Contacts found in %s', 'Contacts found in %s', 0, 0, 0),
(2047, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Invite your contacts to %s', 'Invite your contacts to %s', 0, 0, 0),
(2048, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Contact Name', 'Contact Name', 0, 0, 0),
(2049, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Contact E-mail', 'Contact E-mail', 0, 0, 0),
(2050, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Add as Friend', 'Add as Friend', 0, 0, 0),
(2051, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'No %s friends available in your mail', 'No %s friends available in your mail', 0, 0, 0),
(2052, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'No %s contacts available in your mail', 'No %s contacts available in your mail', 0, 0, 0),
(2053, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'No contacts available in your mail', 'No contacts available in your mail', 0, 0, 0),
(2054, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Available Variables: ', 'Available Variables: ', 0, 0, 0),
(2055, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Credit', 'Credit', 0, 0, 0),
(2056, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'No Transaction Types available', 'No Transaction Types available', 0, 0, 0),
(2057, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'To ', 'To ', 0, 0, 0),
(2058, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Debit', 'Debit', 0, 0, 0),
(2059, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Gateway Fees', 'Gateway Fees', 0, 0, 0),
(2060, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'No Transactions available', 'No Transactions available', 0, 0, 0),
(2061, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Filter Summary', 'Filter Summary', 0, 0, 0),
(2062, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Transaction Summary (Credit - Debit)', 'Transaction Summary (Credit - Debit)', 0, 0, 0),
(2063, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'User Summary', 'User Summary', 0, 0, 0),
(2064, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Withdraw Request', 'Withdraw Request', 0, 0, 0),
(2065, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Transaction Summary (Cr - Db - Withdraw Request)', 'Transaction Summary (Cr - Db - Withdraw Request)', 0, 0, 0),
(2066, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Account Balance', 'Account Balance', 0, 0, 0),
(2067, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'All the amount in the transactions are listed in', 'All the amount in the transactions are listed in', 0, 0, 0),
(2068, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Where the processed gateway amount is in', 'Where the processed gateway amount is in', 0, 0, 0),
(2069, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, '(Showed in bracket).', '(Showed in bracket).', 0, 0, 0),
(2070, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'This Week', 'This Week', 0, 0, 0),
(2071, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'This Month', 'This Month', 0, 0, 0),
(2072, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Transaction Summary (Cr - Db)', 'Transaction Summary (Cr - Db)', 0, 0, 0),
(2073, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'The amount in [] is the original converted amount processed by Payment Gateways. And the other amount in the actual amount taken from the site.', 'The amount in [] is the original converted amount processed by Payment Gateways. And the other amount in the actual amount taken from the site.', 0, 0, 0),
(2074, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'English', 'English', 0, 0, 0),
(2075, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'To Language', 'To Language', 0, 0, 0),
(2076, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'It will only populate site labels for selected new language. You need to manually enter all the equivalent translated labels.', 'It will only populate site labels for selected new language. You need to manually enter all the equivalent translated labels.', 0, 0, 0),
(2077, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'It will automatically translate site labels into selected language with Google. You may then edit necessary labels.', 'It will automatically translate site labels into selected language with Google. You may then edit necessary labels.', 0, 0, 0),
(2078, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Google Translate service is currently a paid service and you''d need API key to use it.', 'Google Translate service is currently a paid service and you''d need API key to use it.', 0, 0, 0),
(2079, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Please enter Google Translate API key in ', 'Please enter Google Translate API key in ', 0, 0, 0),
(2080, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Original', 'Original', 0, 0, 0),
(2081, '2012-03-06 17:37:14', '2012-03-06 17:37:14', 42, 'Make New Translation', 'Make New Translation', 0, 0, 0),
(2082, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Add New Text', 'Add New Text', 0, 0, 0),
(2083, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Sorry, in order to translate, default English strings should be extracted and available. Please contact support.', 'Sorry, in order to translate, default English strings should be extracted and available. Please contact support.', 0, 0, 0),
(2084, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Verified', 'Verified', 0, 0, 0),
(2085, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Not Verified', 'Not Verified', 0, 0, 0),
(2086, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Manage', 'Manage', 0, 0, 0),
(2087, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Verified: ', 'Verified: ', 0, 0, 0),
(2088, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Delete Translation', 'Delete Translation', 0, 0, 0),
(2089, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No Translations available', 'No Translations available', 0, 0, 0),
(2090, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Unverified', 'Unverified', 0, 0, 0),
(2091, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'If you translated with Google Translate, it may not be perfect translation and it may have mistakes. So you need to manually check all translated texts. The translation stats will give summary of verified/unverified translated text.', 'If you translated with Google Translate, it may not be perfect translation and it may have mistakes. So you need to manually check all translated texts. The translation stats will give summary of verified/unverified translated text.', 0, 0, 0),
(2092, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Translated', 'Translated', 0, 0, 0),
(2093, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No translations available', 'No translations available', 0, 0, 0),
(2094, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Key', 'Key', 0, 0, 0),
(2095, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Lang Text', 'Lang Text', 0, 0, 0),
(2096, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'The requested amount will be deducted from your wallet and the amount will be blocked until it get approved or rejected by the administrator. Once its approved, the requested amount will be sent to your paypal account. In case of failure, the amount will be refunded to your wallet.', 'The requested amount will be deducted from your wallet and the amount will be blocked until it get approved or rejected by the administrator. Once its approved, the requested amount will be sent to your paypal account. In case of failure, the amount will be refunded to your wallet.', 0, 0, 0),
(2097, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Minimum withdraw amount: %s <br/> Maximum withdraw amount: %s', 'Minimum withdraw amount: %s <br/> Maximum withdraw amount: %s', 0, 0, 0),
(2098, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Edit Withdraw Fund Request', 'Edit Withdraw Fund Request', 0, 0, 0),
(2099, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Withdrawal Status ', 'Withdrawal Status ', 0, 0, 0),
(2100, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Remark', 'Remark', 0, 0, 0),
(2101, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Your money transfer account is empty, so click here to update money transfer account.', 'Your money transfer account is empty, so click here to update money transfer account.', 0, 0, 0),
(2102, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'money transfer accounts', 'money transfer accounts', 0, 0, 0),
(2103, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No withdraw fund requests available', 'No withdraw fund requests available', 0, 0, 0),
(2104, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Ban User IP', 'Ban User IP', 0, 0, 0),
(2105, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No User Comments available', 'No User Comments available', 0, 0, 0),
(2106, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Comments on ', 'Comments on ', 0, 0, 0),
(2107, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'What group members are saying about one another!', 'What group members are saying about one another!', 0, 0, 0),
(2108, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Remove Friend', 'Remove Friend', 0, 0, 0),
(2109, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Friend User', 'Friend User', 0, 0, 0),
(2110, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Friend Status', 'Friend Status', 0, 0, 0),
(2111, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'actions', 'actions', 0, 0, 0),
(2112, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Friends Status', 'Friends Status', 0, 0, 0),
(2113, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No User Friends available', 'No User Friends available', 0, 0, 0),
(2114, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Friend User Id', 'Friend User Id', 0, 0, 0),
(2115, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Contacts', 'Contacts', 0, 0, 0),
(2116, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No user contacts available.', 'No user contacts available.', 0, 0, 0),
(2117, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Your privacy is our top concern', 'Your privacy is our top concern', 0, 0, 0),
(2118, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Your contacts are your private information. Only you have access to your contacts, and %s will not send them any email. For more information please see the %', 'Your contacts are your private information. Only you have access to your contacts, and %s will not send them any email. For more information please see the %', 0, 0, 0),
(2119, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Privacy Policy', 'Privacy Policy', 0, 0, 0),
(2120, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'CSV Import', 'CSV Import', 0, 0, 0),
(2121, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'YAHOO!', 'YAHOO!', 0, 0, 0),
(2122, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'MSN', 'MSN', 0, 0, 0),
(2123, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'You need to give %s permission to access your Yahoo! Mail address book.', 'You need to give %s permission to access your Yahoo! Mail address book.', 0, 0, 0),
(2124, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'We will take you to Yahoo! where you will be asked to let', 'We will take you to Yahoo! where you will be asked to let', 0, 0, 0),
(2125, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'take a peek at your address book. Once you get there, click \\"Grant access\\" and you will be returned here to find your friends.', 'take a peek at your address book. Once you get there, click \\"Grant access\\" and you will be returned here to find your friends.', 0, 0, 0),
(2126, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Go', 'Go', 0, 0, 0),
(2127, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'You need to give %s permission to access your Gmail address book.', 'You need to give %s permission to access your Gmail address book.', 0, 0, 0),
(2128, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'We''ll take you to Google where you''ll be asked to let %s take a peek at your address book. Once you get there, click \\"Grant access\\" and you''ll be returned here to find your friends.', 'We''ll take you to Google where you''ll be asked to let %s take a peek at your address book. Once you get there, click \\"Grant access\\" and you''ll be returned here to find your friends.', 0, 0, 0),
(2129, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'You need to give', 'You need to give', 0, 0, 0),
(2130, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'permission to access your Windows Live Hotmail address book.', 'permission to access your Windows Live Hotmail address book.', 0, 0, 0),
(2131, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'We will take you to Windows Live where you will be asked to let', 'We will take you to Windows Live where you will be asked to let', 0, 0, 0),
(2132, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'You can export contacts to a file (csv - comma separated values) from any address book software and upload that file.', 'You can export contacts to a file (csv - comma separated values) from any address book software and upload that file.', 0, 0, 0),
(2133, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'View Sample CSV File', 'View Sample CSV File', 0, 0, 0),
(2134, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Upload Friends', 'Upload Friends', 0, 0, 0),
(2135, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Reject ', 'Reject ', 0, 0, 0),
(2136, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Accept ', 'Accept ', 0, 0, 0),
(2137, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Accept', 'Accept', 0, 0, 0),
(2138, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Remove ', 'Remove ', 0, 0, 0),
(2139, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No approved friends available', 'No approved friends available', 0, 0, 0),
(2140, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No rejected friends available', 'No rejected friends available', 0, 0, 0),
(2141, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No pending friends available', 'No pending friends available', 0, 0, 0),
(2142, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Friend''s Email', 'Friend''s Email', 0, 0, 0),
(2143, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Comma separated e-mails', 'Comma separated e-mails', 0, 0, 0),
(2144, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Share Via Social Media', 'Share Via Social Media', 0, 0, 0),
(2145, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Invite to Your Friends', 'Invite to Your Friends', 0, 0, 0),
(2146, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'I think you should get it at', 'I think you should get it at', 0, 0, 0),
(2147, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, ' & Affiliate Refferal Link', ' & Affiliate Refferal Link', 0, 0, 0),
(2148, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Refer Friends, Get', 'Refer Friends, Get', 0, 0, 0),
(2149, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Affiliate Refferal Link', 'Affiliate Refferal Link', 0, 0, 0),
(2150, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Skip', 'Skip', 0, 0, 0),
(2151, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Find people you know on %s', 'Find people you know on %s', 0, 0, 0),
(2152, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Received Friends Requests', 'Received Friends Requests', 0, 0, 0),
(2153, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Sent Friends Requests', 'Sent Friends Requests', 0, 0, 0),
(2154, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No Friends Available', 'No Friends Available', 0, 0, 0),
(2155, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No friends available', 'No friends available', 0, 0, 0),
(2156, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Invite to item', 'Invite to item', 0, 0, 0),
(2157, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'User Interest', 'User Interest', 0, 0, 0),
(2158, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No User Interest Comments available', 'No User Interest Comments available', 0, 0, 0),
(2159, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Search for an interest and follow it to get notified when items are available for that interest. ', 'Search for an interest and follow it to get notified when items are available for that interest. ', 0, 0, 0),
(2160, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Add User Interest', 'Add User Interest', 0, 0, 0),
(2161, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Followers count', 'Followers count', 0, 0, 0),
(2162, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Comments count', 'Comments count', 0, 0, 0),
(2163, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No User Interests available', 'No User Interests available', 0, 0, 0),
(2164, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Find your favorite interests!', 'Find your favorite interests!', 0, 0, 0),
(2165, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Interests followed:', 'Interests followed:', 0, 0, 0),
(2166, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'My Interests', 'My Interests', 0, 0, 0),
(2167, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Popular Interests', 'Popular Interests', 0, 0, 0),
(2168, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Signin', 'Signin', 0, 0, 0),
(2169, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, ' to follow interests so that you can get notified when items are created with your interests!', ' to follow interests so that you can get notified when items are created with your interests!', 0, 0, 0),
(2170, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Unfollow', 'Unfollow', 0, 0, 0),
(2171, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No Interests Followed', 'No Interests Followed', 0, 0, 0),
(2172, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No Popular Interests Available', 'No Popular Interests Available', 0, 0, 0),
(2173, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'User Interests', 'User Interests', 0, 0, 0),
(2174, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No User Interest available', 'No User Interest available', 0, 0, 0),
(2175, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Back to all Interests', 'Back to all Interests', 0, 0, 0),
(2176, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Join the Conversation!', 'Join the Conversation!', 0, 0, 0),
(2177, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, ' Followers (', ' Followers (', 0, 0, 0),
(2178, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, ')', ')', 0, 0, 0),
(2179, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Add UserJob', 'Add UserJob', 0, 0, 0),
(2180, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Company Name', 'Company Name', 0, 0, 0),
(2181, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Position', 'Position', 0, 0, 0),
(2182, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No User Jobs available', 'No User Jobs available', 0, 0, 0),
(2183, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Company Name: ', 'Company Name: ', 0, 0, 0),
(2184, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No Jobs available', 'No Jobs available', 0, 0, 0),
(2185, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Login Time', 'Login Time', 0, 0, 0),
(2186, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Login IP', 'Login IP', 0, 0, 0),
(2187, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'User Agent', 'User Agent', 0, 0, 0),
(2188, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Ban Login IP', 'Ban Login IP', 0, 0, 0),
(2189, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No User Logins available', 'No User Logins available', 0, 0, 0),
(2190, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'When user message me', 'When user message me', 0, 0, 0),
(2191, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'When user comment me', 'When user comment me', 0, 0, 0),
(2192, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'When user follow or request to follow me', 'When user follow or request to follow me', 0, 0, 0),
(2193, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'When user booked an item followed my me', 'When user booked an item followed my me', 0, 0, 0),
(2194, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'When new item was added from my interests groups', 'When new item was added from my interests groups', 0, 0, 0),
(2195, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'When user registered from my invitation', 'When user registered from my invitation', 0, 0, 0),
(2196, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'When user book an item after your invitation', 'When user book an item after your invitation', 0, 0, 0),
(2197, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Add New OpenID', 'Add New OpenID', 0, 0, 0),
(2198, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Verify', 'Verify', 0, 0, 0),
(2199, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No User Openids available', 'No User Openids available', 0, 0, 0),
(2200, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Manage your OpenIDs', 'Manage your OpenIDs', 0, 0, 0),
(2201, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'The following OpenIDs are currently attached to your %s account. You can use any of them to sign in.', 'The following OpenIDs are currently attached to your %s account. You can use any of them to sign in.', 0, 0, 0),
(2202, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No OpenIDs available', 'No OpenIDs available', 0, 0, 0),
(2203, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Attach a new OpenID', 'Attach a new OpenID', 0, 0, 0),
(2204, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'First name', 'First name', 0, 0, 0),
(2205, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Last name', 'Last name', 0, 0, 0),
(2206, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Card Verification Number', 'Card Verification Number', 0, 0, 0),
(2207, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, '-- Please Select --', '-- Please Select --', 0, 0, 0),
(2208, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'ZIP', 'ZIP', 0, 0, 0),
(2209, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'For security reason, we are not saved the credit card details. You have to specify again.', 'For security reason, we are not saved the credit card details. You have to specify again.', 0, 0, 0),
(2210, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Billing address', 'Billing address', 0, 0, 0),
(2211, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Select Country', 'Select Country', 0, 0, 0),
(2212, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Credit Card', 'Credit Card', 0, 0, 0),
(2213, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Default', 'Default', 0, 0, 0),
(2214, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Set as default', 'Set as default', 0, 0, 0),
(2215, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'No credit cards available', 'No credit cards available', 0, 0, 0),
(2216, '2012-03-06 17:37:15', '2012-03-06 17:37:15', 42, 'Edit Profile - %s', 'Edit Profile - %s', 0, 0, 0),
(2217, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Personal', 'Personal', 0, 0, 0),
(2218, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'DOB', 'DOB', 0, 0, 0),
(2219, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'About Me', 'About Me', 0, 0, 0),
(2220, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Hometown', 'Hometown', 0, 0, 0),
(2221, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Primarily will grab in', 'Primarily will grab in', 0, 0, 0),
(2222, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Auto approve friend request?', 'Auto approve friend request?', 0, 0, 0),
(2223, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Email confirmed', 'Email confirmed', 0, 0, 0),
(2224, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Interesting Fact', 'Interesting Fact', 0, 0, 0),
(2225, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Personal Website', 'Personal Website', 0, 0, 0),
(2226, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'User School Degree', 'User School Degree', 0, 0, 0),
(2227, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'No User School Degrees available', 'No User School Degrees available', 0, 0, 0),
(2228, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'College', 'College', 0, 0, 0),
(2229, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Year', 'Year', 0, 0, 0),
(2230, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'User Name', 'User Name', 0, 0, 0),
(2231, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Major1', 'Major1', 0, 0, 0),
(2232, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Major2', 'Major2', 0, 0, 0),
(2233, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Major3', 'Major3', 0, 0, 0),
(2234, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'No User Schools available', 'No User Schools available', 0, 0, 0),
(2235, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'College: ', 'College: ', 0, 0, 0),
(2236, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Year: ', 'Year: ', 0, 0, 0),
(2237, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Major1: ', 'Major1: ', 0, 0, 0),
(2238, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Major2: ', 'Major2: ', 0, 0, 0),
(2239, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Major3: ', 'Major3: ', 0, 0, 0),
(2240, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'No Schools available', 'No Schools available', 0, 0, 0),
(2241, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'User School', 'User School', 0, 0, 0),
(2242, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Viewed Time', 'Viewed Time', 0, 0, 0),
(2243, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Viewed User', 'Viewed User', 0, 0, 0),
(2244, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Guest', 'Guest', 0, 0, 0),
(2245, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'whois', 'whois', 0, 0, 0),
(2246, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'No User Views available', 'No User Views available', 0, 0, 0),
(2247, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'You have not yet activated your account. Please activate it. If you have not received the activation mail, %s to resend the activation mail.', 'You have not yet activated your account. Please activate it. If you have not received the activation mail, %s to resend the activation mail.', 0, 0, 0),
(2248, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Minimum Amount: %s <br/> Maximum Amount: %s', 'Minimum Amount: %s <br/> Maximum Amount: %s', 0, 0, 0),
(2249, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'User Type', 'User Type', 0, 0, 0),
(2250, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Available balance amount: %s', 'Available balance amount: %s', 0, 0, 0),
(2251, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Diagnostics are for developer purpose only.', 'Diagnostics are for developer purpose only.', 0, 0, 0),
(2252, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Payment Transaction Log', 'Payment Transaction Log', 0, 0, 0),
(2253, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'View the transaction details done via Normal PayPal', 'View the transaction details done via Normal PayPal', 0, 0, 0),
(2254, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Mass Payment Transaction Log', 'Mass Payment Transaction Log', 0, 0, 0),
(2255, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'View the transaction details done via Mass PayPal', 'View the transaction details done via Mass PayPal', 0, 0, 0),
(2256, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'View the transaction logs  done via PayPal', 'View the transaction logs  done via PayPal', 0, 0, 0),
(2257, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'View the transaction logs done via Authorizenet', 'View the transaction logs done via Authorizenet', 0, 0, 0),
(2258, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Debug & Error Log', 'Debug & Error Log', 0, 0, 0),
(2259, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'View debug, error log, used cache memory and used log memory', 'View debug, error log, used cache memory and used log memory', 0, 0, 0),
(2260, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Inactive users', 'Inactive users', 0, 0, 0),
(2261, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'OpenID users', 'OpenID users', 0, 0, 0),
(2262, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'OpenID Users: ', 'OpenID Users: ', 0, 0, 0),
(2263, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Facebook users', 'Facebook users', 0, 0, 0),
(2264, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Facebook Users: ', 'Facebook Users: ', 0, 0, 0),
(2265, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Twitter Users', 'Twitter Users', 0, 0, 0),
(2266, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Foursquare Users', 'Foursquare Users', 0, 0, 0),
(2267, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Gmail Users', 'Gmail Users', 0, 0, 0),
(2268, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Gmail Users: ', 'Gmail Users: ', 0, 0, 0),
(2269, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Yahoo users', 'Yahoo users', 0, 0, 0),
(2270, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Yahoo Users: ', 'Yahoo Users: ', 0, 0, 0),
(2271, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Affiliate Users', 'Affiliate Users', 0, 0, 0),
(2272, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'TAdmin', 'TAdmin', 0, 0, 0),
(2273, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Total users', 'Total users', 0, 0, 0),
(2274, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Total Users', 'Total Users', 0, 0, 0),
(2275, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Available Balance', 'Available Balance', 0, 0, 0),
(2276, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Registered On', 'Registered On', 0, 0, 0),
(2277, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Ban Signup IP', 'Ban Signup IP', 0, 0, 0),
(2278, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Ban Sign up IP', 'Ban Sign up IP', 0, 0, 0),
(2279, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'No users available', 'No users available', 0, 0, 0),
(2280, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Memory Status', 'Memory Status', 0, 0, 0),
(2281, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Used Cache Memory', 'Used Cache Memory', 0, 0, 0),
(2282, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Used Log Memory', 'Used Log Memory', 0, 0, 0),
(2283, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Recent Errors & Logs', 'Recent Errors & Logs', 0, 0, 0),
(2284, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Error Log', 'Error Log', 0, 0, 0),
(2285, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Clear Error Log', 'Clear Error Log', 0, 0, 0),
(2286, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Debug Log', 'Debug Log', 0, 0, 0),
(2287, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Clear Debug Log', 'Clear Debug Log', 0, 0, 0),
(2288, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Online Users', 'Online Users', 0, 0, 0),
(2289, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'No users online', 'No users online', 0, 0, 0),
(2290, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Recently Registered Users', 'Recently Registered Users', 0, 0, 0),
(2291, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Recently no users registered', 'Recently no users registered', 0, 0, 0),
(2292, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Referred By', 'Referred By', 0, 0, 0),
(2293, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'No Referrals Available', 'No Referrals Available', 0, 0, 0),
(2294, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Timings', 'Timings', 0, 0, 0),
(2295, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'GroupWithUs', 'GroupWithUs', 0, 0, 0),
(2296, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Product Support', 'Product Support', 0, 0, 0),
(2297, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Product Manual', 'Product Manual', 0, 0, 0),
(2298, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'CSSilize', 'CSSilize', 0, 0, 0),
(2299, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Agriya Blog', 'Agriya Blog', 0, 0, 0),
(2300, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Redirecting you to authorize %s', 'Redirecting you to authorize %s', 0, 0, 0),
(2301, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'If your browser doesn''t redirect you please %s to continue.', 'If your browser doesn''t redirect you please %s to continue.', 0, 0, 0),
(2302, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Old Password', 'Old Password', 0, 0, 0),
(2303, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Enter a new Password', 'Enter a new Password', 0, 0, 0),
(2304, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Confirm Password', 'Confirm Password', 0, 0, 0),
(2305, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Allow', 'Allow', 0, 0, 0),
(2306, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, ' to share your products', ' to share your products', 0, 0, 0),
(2307, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Connect to Facebook', 'Connect to Facebook', 0, 0, 0),
(2308, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Connect your Facebook account to automatically push status updates about your product in your news stream.', 'Connect your Facebook account to automatically push status updates about your product in your news stream.', 0, 0, 0),
(2309, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Update my Facebook status when', 'Update my Facebook status when', 0, 0, 0),
(2310, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'I have placed a new product.', 'I have placed a new product.', 0, 0, 0),
(2311, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'A product has been sold.', 'A product has been sold.', 0, 0, 0),
(2312, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'A product has not been sold after', 'A product has not been sold after', 0, 0, 0),
(2313, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'days.', 'days.', 0, 0, 0),
(2314, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Disconnect', 'Disconnect', 0, 0, 0),
(2315, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Connect to Twitter', 'Connect to Twitter', 0, 0, 0),
(2316, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Connect your Twitter account to automatically push status updates about your product to your followers.', 'Connect your Twitter account to automatically push status updates about your product to your followers.', 0, 0, 0),
(2317, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Tweet when', 'Tweet when', 0, 0, 0),
(2318, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Forgot your password?', 'Forgot your password?', 0, 0, 0),
(2319, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Enter your Email, and we will send you instructions for resetting your password.', 'Enter your Email, and we will send you instructions for resetting your password.', 0, 0, 0),
(2320, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Linked Accounts', 'Linked Accounts', 0, 0, 0),
(2321, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'You can connect with', 'You can connect with', 0, 0, 0),
(2322, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'using multiple connect.', 'using multiple connect.', 0, 0, 0),
(2323, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Twitter Profile Image', 'Twitter Profile Image', 0, 0, 0),
(2324, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Connected with Twitter', 'Connected with Twitter', 0, 0, 0),
(2325, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'with', 'with', 0, 0, 0),
(2326, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Facebook Profile Image', 'Facebook Profile Image', 0, 0, 0),
(2327, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Connected with Facebook', 'Connected with Facebook', 0, 0, 0),
(2328, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Sign In using: ', 'Sign In using: ', 0, 0, 0),
(2329, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Sign in with Open ID', 'Sign in with Open ID', 0, 0, 0),
(2330, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Remember me on this computer.', 'Remember me on this computer.', 0, 0, 0),
(2331, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Never Mind', 'Never Mind', 0, 0, 0),
(2332, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Choose Your Id', 'Choose Your Id', 0, 0, 0),
(2333, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'The goal of this API is to allow applications to directly interact with ', 'The goal of this API is to allow applications to directly interact with ', 0, 0, 0),
(2334, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, ' via a REST API', ' via a REST API', 0, 0, 0),
(2335, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Follow this link for detail information about API.', 'Follow this link for detail information about API.', 0, 0, 0),
(2336, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'API Key', 'API Key', 0, 0, 0),
(2337, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'API Token', 'API Token', 0, 0, 0),
(2338, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'My_Account', 'My_Account', 0, 0, 0),
(2339, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Choose your profile image', 'Choose your profile image', 0, 0, 0),
(2340, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Member Since:', 'Member Since:', 0, 0, 0),
(2341, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Total Item Purchase:', 'Total Item Purchase:', 0, 0, 0),
(2342, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'No Referred Users Available', 'No Referred Users Available', 0, 0, 0),
(2343, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Sign Up', 'Sign Up', 0, 0, 0),
(2344, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Reference Code', 'Reference Code', 0, 0, 0),
(2345, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'I have read, understood &amp; agree to the ', 'I have read, understood &amp; agree to the ', 0, 0, 0),
(2346, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Reset your password', 'Reset your password', 0, 0, 0),
(2347, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Enter a new password', 'Enter a new password', 0, 0, 0),
(2348, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Our groupers are awesome', 'Our groupers are awesome', 0, 0, 0),
(2349, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, ' ', ' ', 0, 0, 0),
(2350, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Grab With Me', 'Grab With Me', 0, 0, 0),
(2351, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'To get notified when grab item', 'To get notified when grab item', 0, 0, 0),
(2352, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Other info', 'Other info', 0, 0, 0),
(2353, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Member Since', 'Member Since', 0, 0, 0),
(2354, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Home Town', 'Home Town', 0, 0, 0),
(2355, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Degree', 'Degree', 0, 0, 0),
(2356, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Website', 'Website', 0, 0, 0),
(2357, '2012-03-06 17:37:16', '2012-03-06 17:37:16', 42, 'Debug setting does not allow access to this url.', 'Debug setting does not allow access to this url.', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_type_id` int(5) unsigned NOT NULL,
  `username` varchar(255) collate utf8_unicode_ci default NULL,
  `email` varchar(255) collate utf8_unicode_ci default NULL,
  `password` varchar(100) collate utf8_unicode_ci NOT NULL,
  `referred_by_user_id` bigint(20) default NULL,
  `referred_by_user_count` bigint(20) NOT NULL,
  `fb_user_id` bigint(20) unsigned default NULL,
  `user_login_count` bigint(20) unsigned NOT NULL,
  `user_view_count` bigint(20) unsigned NOT NULL,
  `cookie_hash` varchar(50) collate utf8_unicode_ci NOT NULL,
  `cookie_time_modified` datetime NOT NULL,
  `is_agree_terms_conditions` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_email_confirmed` tinyint(1) NOT NULL,
  `ip_id` bigint(20) NOT NULL,
  `last_login_ip_id` bigint(20) NOT NULL,
  `last_logged_in_time` datetime NOT NULL,
  `available_balance_amount` double(10,2) NOT NULL default '0.00',
  `blocked_amount` bigint(20) default '0',
  `user_openid_count` bigint(20) unsigned default NULL,
  `is_openid_register` tinyint(1) default '0',
  `is_gmail_register` tinyint(1) NOT NULL,
  `is_yahoo_register` tinyint(1) NOT NULL,
  `is_facebook_register` tinyint(1) NOT NULL,
  `is_twitter_register` tinyint(1) NOT NULL,
  `is_foursquare_register` tinyint(1) default '0',
  `twitter_access_token` varchar(255) collate utf8_unicode_ci default NULL,
  `twitter_user_id` varchar(255) collate utf8_unicode_ci NOT NULL,
  `twitter_access_key` bigint(20) default NULL,
  `api_key` varchar(50) collate utf8_unicode_ci default NULL,
  `api_token` varchar(50) collate utf8_unicode_ci default '',
  `fb_access_token` varchar(255) collate utf8_unicode_ci default NULL,
  `foursquare_access_token` varchar(255) collate utf8_unicode_ci NOT NULL,
  `foursquare_user_id` varchar(50) collate utf8_unicode_ci NOT NULL,
  `cim_profile_id` bigint(20) default NULL,
  `is_affiliate_user` tinyint(1) default '0',
  `total_commission_pending_amount` double(10,2) default '0.00',
  `total_commission_canceled_amount` double(10,2) default '0.00',
  `total_commission_completed_amount` double(10,2) default '0.00',
  `commission_line_amount` double(10,2) default '0.00',
  `commission_withdraw_request_amount` double(10,2) default '0.00',
  `commission_paid_amount` double(10,2) default '0.00',
  `referred_purchase_count` bigint(20) default '0',
  `affiliate_refer_purchase_count` bigint(20) default '0',
  `twitter_username` varchar(100) collate utf8_unicode_ci NOT NULL,
  `twitter_avatar_url` varchar(255) collate utf8_unicode_ci NOT NULL,
  `user_comment_count` bigint(20) NOT NULL,
  `user_friend_count` bigint(20) NOT NULL,
  `item_count` bigint(20) NOT NULL,
  `user_interest_follower_count` bigint(20) NOT NULL,
  `user_interest_count` bigint(20) NOT NULL,
  `user_interest_comment_count` bigint(20) NOT NULL,
  `total_withdraw_request_count` bigint(20) default '0',
  `profile_image_id` bigint(20) default '3',
  `is_home` tinyint(1) NOT NULL,
  `total_amount_added_to_wallet` double(10,2) default '0.00',
  `total_amount_withdrawn` double(10,2) default '0.00',
  `total_referral_earned_amount` double(10,2) default '0.00',
  `total_purchased_amount` double(10,2) default '0.00',
  `total_purchased_amount_via_wallet` double(10,2) default '0.00',
  `total_purchased_amount_via_paypal` double(10,2) default '0.00',
  `total_purchased_amount_via_credit_card` double(10,2) default '0.00',
  `total_purchased_amount_via_cim` double(10,2) default '0.00',
  `total_purchased_amount_via_pagseguro` double(10,2) default '0.00',
  `total_item_purchase_count` bigint(20) default '0',
  `total_item_purchase_cancel_count` bigint(20) default '0',
  PRIMARY KEY  (`id`),
  KEY `user_type_id` (`user_type_id`),
  KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `fb_user_id` (`fb_user_id`),
  KEY `cim_profile_id` (`cim_profile_id`),
  KEY `profile_image_id` (`profile_image_id`),
  KEY `referred_by_user_id` (`referred_by_user_id`),
  KEY `twitter_user_id` (`twitter_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Details';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created`, `modified`, `user_type_id`, `username`, `email`, `password`, `referred_by_user_id`, `referred_by_user_count`, `fb_user_id`, `user_login_count`, `user_view_count`, `cookie_hash`, `cookie_time_modified`, `is_agree_terms_conditions`, `is_active`, `is_email_confirmed`, `ip_id`, `last_login_ip_id`, `last_logged_in_time`, `available_balance_amount`, `blocked_amount`, `user_openid_count`, `is_openid_register`, `is_gmail_register`, `is_yahoo_register`, `is_facebook_register`, `is_twitter_register`, `is_foursquare_register`, `twitter_access_token`, `twitter_user_id`, `twitter_access_key`, `api_key`, `api_token`, `fb_access_token`, `foursquare_access_token`, `foursquare_user_id`, `cim_profile_id`, `is_affiliate_user`, `total_commission_pending_amount`, `total_commission_canceled_amount`, `total_commission_completed_amount`, `commission_line_amount`, `commission_withdraw_request_amount`, `commission_paid_amount`, `referred_purchase_count`, `affiliate_refer_purchase_count`, `twitter_username`, `twitter_avatar_url`, `user_comment_count`, `user_friend_count`, `item_count`, `user_interest_follower_count`, `user_interest_count`, `user_interest_comment_count`, `total_withdraw_request_count`, `profile_image_id`, `is_home`, `total_amount_added_to_wallet`, `total_amount_withdrawn`, `total_referral_earned_amount`, `total_purchased_amount`, `total_purchased_amount_via_wallet`, `total_purchased_amount_via_paypal`, `total_purchased_amount_via_credit_card`, `total_purchased_amount_via_cim`, `total_purchased_amount_via_pagseguro`, `total_item_purchase_count`, `total_item_purchase_cancel_count`) VALUES
(1, '2010-06-24 15:06:07', '2011-08-05 10:29:04', 1, 'admin', 'productdemo.admin@gmail.com', 'df250333cfb72ae1fc70c47880fc514af892bfea', NULL, 0, 100000754103010, 18, 0, '0682b4ee5683deadfc5c3d56d73e947f', '2011-06-11 09:12:38', 1, 1, 1, 122183, 1, '2012-02-23 10:20:19', 0.00, 0, 0, 0, 0, 0, 1, 0, 0, NULL, '', NULL, 'fd8d00f5-346a-4e57-bdee-6776944fc0c3', 'bb1d3a95af41201', '231084413598942|2.AQB5vn9V2NZlitfD.3600.1312545600.1-100000754103010|hW3ONd9lmdh-Q-ORMJd6NrzSK1s', '', '', 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', 0, 0, 8, 0, 0, 0, 0, 1, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0),
(2, '2011-11-22 07:49:40', '2011-11-22 11:10:59', 2, 'user', 'productdemo.user@gmail.com', 'df250333cfb72ae1fc70c47880fc514af892bfea', 3, 3, NULL, 12, 5, '', '0000-00-00 00:00:00', 1, 1, 1, 1, 1, '2012-02-23 08:21:09', 10488.00, 0, NULL, 0, 0, 0, 0, 0, 0, NULL, '', NULL, NULL, '', NULL, '', '', 5668405, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', 0, 0, 1, 0, 0, 0, 0, 3, 1, 0.00, 0.00, 610.00, 1122.00, 1122.00, 0.00, 0.00, 0.00, 0.00, 6, 0),
(3, '2011-11-22 07:51:32', '2011-11-22 11:18:47', 2, 'user1', 'productdemo.user+user1@gmail.com', 'df250333cfb72ae1fc70c47880fc514af892bfea', NULL, 0, NULL, 5, 1, '', '0000-00-00 00:00:00', 1, 1, 1, 1, 1, '2011-11-22 13:33:32', 304.00, 0, NULL, 0, 0, 0, 0, 0, 0, NULL, '', NULL, NULL, '', NULL, '', '', 5668413, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 3, 1, 0.00, 0.00, 15.00, 211.00, 211.00, 0.00, 0.00, 0.00, 0.00, 2, 0),
(4, '2011-11-22 09:41:13', '2012-02-21 13:34:52', 3, 'merchant', 'jayashree.n+merchant2@agriya.in', 'df250333cfb72ae1fc70c47880fc514af892bfea', NULL, 0, NULL, 8, 0, '', '0000-00-00 00:00:00', 1, 1, 1, 1, 1, '2012-02-23 07:32:24', 0.00, 0, NULL, 0, 0, 0, 0, 0, 0, NULL, '', NULL, NULL, '', NULL, '', '', 5669731, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', 2, 0, 5, 0, 4, 0, 0, 3, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0),
(5, '2011-11-22 09:46:00', '2011-11-22 09:46:00', 3, 'merchant1', 'product.demo+cuser@gmail.com', 'df250333cfb72ae1fc70c47880fc514af892bfea', NULL, 0, NULL, 2, 0, '', '0000-00-00 00:00:00', 1, 1, 1, 1, 1, '2011-11-22 10:59:16', 0.00, 0, NULL, 0, 0, 0, 0, 0, 0, NULL, '', NULL, NULL, '', NULL, '', '', 5669739, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', 0, 0, 1, 0, 0, 0, 0, 3, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0),
(6, '2011-11-22 12:38:01', '2011-11-22 12:41:03', 2, 'user2', 'productdemo.user+user2@gmail.com', 'df250333cfb72ae1fc70c47880fc514af892bfea', NULL, 0, NULL, 3, 0, '', '0000-00-00 00:00:00', 1, 1, 1, 1, 1, '2011-11-22 13:41:11', 269.00, 0, NULL, 0, 0, 0, 0, 0, 0, NULL, '', NULL, NULL, '', NULL, '', '', 5671011, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 3, 1, 0.00, 0.00, 0.00, 181.00, 181.00, 0.00, 0.00, 0.00, 0.00, 2, 0),
(7, '2011-11-22 12:42:56', '2011-11-22 12:48:39', 2, 'user3', 'productdemo.user+user3@gmail.com', 'df250333cfb72ae1fc70c47880fc514af892bfea', NULL, 0, NULL, 2, 0, '', '0000-00-00 00:00:00', 1, 1, 1, 1, 1, '2011-11-22 13:40:16', 110.00, 0, NULL, 0, 0, 0, 0, 0, 0, NULL, '', NULL, NULL, '', NULL, '', '', 5671026, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 3, 1, 0.00, 0.00, 0.00, 90.00, 90.00, 0.00, 0.00, 0.00, 0.00, 1, 0),
(8, '2012-02-21 10:54:11', '2012-02-21 10:54:11', 2, 'juser', 'jayashree.n+juser@agriya.in', 'df250333cfb72ae1fc70c47880fc514af892bfea', 2, 0, NULL, 3, 2, '', '0000-00-00 00:00:00', 1, 1, 1, 1, 1, '2012-02-21 12:16:33', 5155.00, 0, NULL, 0, 0, 0, 0, 0, 0, NULL, '', NULL, NULL, '', NULL, '', '', 6615453, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 3, 0, 0.00, 0.00, 305.00, 150.00, 150.00, 0.00, 0.00, 0.00, 0.00, 1, 0),
(9, '2012-02-21 11:23:44', '2012-02-21 11:23:44', 2, 'juser1', 'jayashree.n+juser1@agriya.in', 'df250333cfb72ae1fc70c47880fc514af892bfea', 2, 0, NULL, 2, 0, '', '0000-00-00 00:00:00', 1, 0, 1, 1, 1, '2012-02-21 11:40:58', 1850.00, 0, NULL, 0, 0, 0, 0, 0, 0, NULL, '', NULL, NULL, '', NULL, '', '', 6615590, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 3, 0, 0.00, 0.00, 0.00, 150.00, 150.00, 0.00, 0.00, 0.00, 0.00, 1, 0),
(10, '2012-02-21 11:43:31', '2012-02-21 11:43:31', 2, 'juser2', 'jayashree.n+juser2@agriya.in', 'df250333cfb72ae1fc70c47880fc514af892bfea', 2, 0, NULL, 1, 0, '', '0000-00-00 00:00:00', 1, 1, 1, 1, 1, '2012-02-21 11:43:36', 400.00, 0, NULL, 0, 0, 0, 0, 0, 0, NULL, '', NULL, NULL, '', NULL, '', '', 6615601, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 3, 0, 0.00, 0.00, 0.00, 600.00, 600.00, 0.00, 0.00, 0.00, 0.00, 4, 0),
(11, '2012-02-21 12:55:52', '2012-02-21 12:55:52', 3, 'jmerchant', 'jayashree.n+merchant1@agriya.in', 'df250333cfb72ae1fc70c47880fc514af892bfea', NULL, 0, NULL, 3, 0, '', '0000-00-00 00:00:00', 0, 1, 1, 0, 1, '2012-02-21 13:20:13', 0.00, 0, NULL, 0, 0, 0, 0, 0, 0, NULL, '', NULL, NULL, '', NULL, '', '', 6615918, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 3, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_cash_withdrawals`
--

DROP TABLE IF EXISTS `user_cash_withdrawals`;
CREATE TABLE IF NOT EXISTS `user_cash_withdrawals` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `withdrawal_status_id` bigint(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `remark` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `withdrawal_status_id` (`withdrawal_status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED;

--
-- Dumping data for table `user_cash_withdrawals`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_comments`
--

DROP TABLE IF EXISTS `user_comments`;
CREATE TABLE IF NOT EXISTS `user_comments` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `posted_user_id` bigint(20) NOT NULL,
  `comment` text collate utf8_unicode_ci NOT NULL,
  `ip_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `posted_user_id` (`posted_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User comments details';

--
-- Dumping data for table `user_comments`
--

INSERT INTO `user_comments` (`id`, `created`, `modified`, `user_id`, `posted_user_id`, `comment`, `ip_id`) VALUES
(1, '2012-02-21 12:22:11', '2012-02-21 12:22:11', 4, 8, 'afdfsdf', 1),
(2, '2012-02-21 12:23:54', '2012-02-21 12:23:54', 4, 8, 'test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_friends`
--

DROP TABLE IF EXISTS `user_friends`;
CREATE TABLE IF NOT EXISTS `user_friends` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `friend_user_id` bigint(20) NOT NULL,
  `friend_status_id` bigint(20) NOT NULL,
  `is_requested` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `friend_user_id` (`friend_user_id`),
  KEY `friend_status_id` (`friend_status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Friend Details';

--
-- Dumping data for table `user_friends`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_interests`
--

DROP TABLE IF EXISTS `user_interests`;
CREATE TABLE IF NOT EXISTS `user_interests` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `slug` varchar(255) collate utf8_unicode_ci NOT NULL,
  `user_interest_follower_count` bigint(20) NOT NULL,
  `user_interest_comment_count` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_interests`
--

INSERT INTO `user_interests` (`id`, `created`, `modified`, `name`, `slug`, `user_interest_follower_count`, `user_interest_comment_count`) VALUES
(1, '2011-11-22 10:12:35', '2011-11-22 10:12:35', 'Pizza', 'pizza', 4, 0),
(2, '2011-11-22 10:28:11', '2011-11-22 10:28:11', 'Ice Cream', 'ice-cream', 4, 0),
(3, '2011-11-22 10:39:41', '2011-11-22 10:39:41', 'Lunch Special', 'lunch-special', 4, 0),
(4, '2011-11-22 10:42:35', '2011-11-22 10:42:35', 'Chinese Food', 'chinese-food', 3, 0),
(5, '2011-11-22 10:59:54', '2011-11-22 10:59:54', 'Dinner', 'dinner', 4, 0),
(6, '2011-11-22 11:00:03', '2011-11-22 11:00:03', 'GetTogether', 'gettogether', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_interest_comments`
--

DROP TABLE IF EXISTS `user_interest_comments`;
CREATE TABLE IF NOT EXISTS `user_interest_comments` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_interest_id` bigint(20) NOT NULL,
  `comment` text collate utf8_unicode_ci NOT NULL,
  `ip_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_interest_id` (`user_interest_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_interest_comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_interest_followers`
--

DROP TABLE IF EXISTS `user_interest_followers`;
CREATE TABLE IF NOT EXISTS `user_interest_followers` (
  `id` bigint(20) NOT NULL auto_increment,
  `user_id` bigint(20) NOT NULL,
  `user_interest_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_interest_id` (`user_interest_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_interest_followers`
--

INSERT INTO `user_interest_followers` (`id`, `user_id`, `user_interest_id`) VALUES
(1, 4, 1),
(2, 4, 2),
(3, 4, 3),
(4, 4, 4),
(5, 5, 5),
(6, 5, 6),
(7, 3, 1),
(8, 3, 2),
(9, 3, 3),
(10, 3, 4),
(11, 3, 5),
(12, 3, 6),
(13, 2, 2),
(14, 2, 3),
(15, 2, 6),
(16, 7, 6),
(17, 7, 5),
(18, 7, 1),
(19, 6, 1),
(20, 6, 4),
(21, 6, 2),
(22, 6, 5),
(23, 6, 3),
(24, 6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user_interest_items`
--

DROP TABLE IF EXISTS `user_interest_items`;
CREATE TABLE IF NOT EXISTS `user_interest_items` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_interest_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_interest_id` (`user_interest_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_interest_items`
--

INSERT INTO `user_interest_items` (`id`, `created`, `modified`, `user_interest_id`, `item_id`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 1),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 2),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 3),
(4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 4),
(5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 5),
(6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 5),
(7, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 6),
(8, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 6),
(9, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 7),
(10, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 7),
(11, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 7),
(41, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 8),
(40, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 8),
(39, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 8),
(23, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 9),
(22, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 9),
(21, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 9),
(24, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 10),
(25, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 10),
(43, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 11),
(42, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 11),
(32, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 12),
(33, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 12),
(34, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 12),
(35, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 13),
(36, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 13),
(50, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 14),
(49, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 14),
(44, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 15),
(45, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 15),
(46, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 15),
(47, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 15),
(48, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `user_jobs`
--

DROP TABLE IF EXISTS `user_jobs`;
CREATE TABLE IF NOT EXISTS `user_jobs` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `position` varchar(100) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `company_id` (`company_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_jobs`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

DROP TABLE IF EXISTS `user_logins`;
CREATE TABLE IF NOT EXISTS `user_logins` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `ip_id` bigint(20) NOT NULL,
  `user_agent` varchar(500) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Login Details';

--
-- Dumping data for table `user_logins`
--

INSERT INTO `user_logins` (`id`, `created`, `modified`, `user_id`, `ip_id`, `user_agent`) VALUES
(1, '2011-11-22 07:49:46', '2011-11-22 07:49:46', 2, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(2, '2011-11-22 07:51:38', '2011-11-22 07:51:38', 3, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(3, '2011-11-22 09:41:19', '2011-11-22 09:41:19', 4, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(4, '2011-11-22 09:46:08', '2011-11-22 09:46:08', 5, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(5, '2011-11-22 09:50:28', '2011-11-22 09:50:28', 4, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(6, '2011-11-22 10:17:38', '2011-11-22 10:17:38', 1, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(7, '2011-11-22 10:59:16', '2011-11-22 10:59:16', 5, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(8, '2011-11-22 11:07:22', '2011-11-22 11:07:22', 2, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(9, '2011-11-22 11:14:07', '2011-11-22 11:14:07', 3, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(10, '2011-11-22 11:16:40', '2011-11-22 11:16:40', 3, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(11, '2011-11-22 12:38:07', '2011-11-22 12:38:07', 6, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(12, '2011-11-22 12:43:00', '2011-11-22 12:43:00', 7, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(13, '2011-11-22 12:55:59', '2011-11-22 12:55:59', 3, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(14, '2011-11-22 13:00:57', '2011-11-22 13:00:57', 2, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(15, '2011-11-22 13:31:38', '2011-11-22 13:31:38', 6, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(16, '2011-11-22 13:33:32', '2011-11-22 13:33:32', 3, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(17, '2011-11-22 13:38:14', '2011-11-22 13:38:14', 2, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(18, '2011-11-22 13:40:16', '2011-11-22 13:40:16', 7, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(19, '2011-11-22 13:41:10', '2011-11-22 13:41:10', 6, 1, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2'),
(20, '2012-02-16 06:56:53', '2012-02-16 06:56:53', 1, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(21, '2012-02-16 06:57:33', '2012-02-16 06:57:33', 1, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(22, '2012-02-16 06:59:17', '2012-02-16 06:59:17', 1, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(23, '2012-02-21 05:25:28', '2012-02-21 05:25:28', 1, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(24, '2012-02-21 06:10:32', '2012-02-21 06:10:32', 1, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(25, '2012-02-21 06:37:23', '2012-02-21 06:37:23', 2, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(26, '2012-02-21 06:55:33', '2012-02-21 06:55:33', 1, 1, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; EmbeddedWB 14.52 from: http://www.bsalsa.com/ EmbeddedWB 14.52)'),
(27, '2012-02-21 10:15:51', '2012-02-21 10:15:51', 4, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(28, '2012-02-21 10:36:15', '2012-02-21 10:36:15', 2, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(29, '2012-02-21 10:54:18', '2012-02-21 10:54:18', 8, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(30, '2012-02-21 10:59:02', '2012-02-21 10:59:02', 4, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(31, '2012-02-21 11:15:59', '2012-02-21 11:15:59', 8, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(32, '2012-02-21 11:17:53', '2012-02-21 11:17:53', 2, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(33, '2012-02-21 11:25:50', '2012-02-21 11:25:50', 9, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(34, '2012-02-21 11:27:32', '2012-02-21 11:27:32', 2, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(35, '2012-02-21 11:40:58', '2012-02-21 11:40:58', 9, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(36, '2012-02-21 11:43:36', '2012-02-21 11:43:36', 10, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(37, '2012-02-21 11:49:26', '2012-02-21 11:49:26', 2, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(38, '2012-02-21 12:05:03', '2012-02-21 12:05:03', 4, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(39, '2012-02-21 12:08:05', '2012-02-21 12:08:05', 2, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(40, '2012-02-21 12:16:33', '2012-02-21 12:16:33', 8, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(41, '2012-02-21 13:15:26', '2012-02-21 13:15:26', 11, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(42, '2012-02-21 13:15:44', '2012-02-21 13:15:44', 11, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(43, '2012-02-21 13:20:13', '2012-02-21 13:20:13', 11, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(45, '2012-02-21 14:02:18', '2012-02-21 14:02:18', 4, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(46, '2012-02-22 05:41:24', '2012-02-22 05:41:24', 4, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(47, '2012-02-22 05:45:49', '2012-02-22 05:45:49', 1, 1, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0)'),
(48, '2012-02-22 08:51:34', '2012-02-22 08:51:34', 1, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(49, '2012-02-22 09:42:52', '2012-02-22 09:42:52', 1, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(50, '2012-02-22 09:43:05', '2012-02-22 09:43:05', 1, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(51, '2012-02-22 09:45:04', '2012-02-22 09:45:04', 1, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(52, '2012-02-22 09:46:45', '2012-02-22 09:46:45', 1, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(53, '2012-02-22 09:48:37', '2012-02-22 09:48:37', 1, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(54, '2012-02-22 09:48:51', '2012-02-22 09:48:51', 1, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(55, '2012-02-23 05:51:49', '2012-02-23 05:51:49', 1, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(56, '2012-02-23 06:28:16', '2012-02-23 06:28:16', 2, 1, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; EmbeddedWB 14.52 from: http://www.bsalsa.com/ EmbeddedWB 14.52)'),
(57, '2012-02-23 07:32:24', '2012-02-23 07:32:24', 4, 1, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; EmbeddedWB 14.52 from: http://www.bsalsa.com/ EmbeddedWB 14.52)'),
(58, '2012-02-23 08:21:09', '2012-02-23 08:21:09', 2, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(59, '2012-02-23 10:19:12', '2012-02-23 10:19:12', 1, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6'),
(60, '2012-02-23 10:20:19', '2012-02-23 10:20:19', 1, 1, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6');

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

DROP TABLE IF EXISTS `user_notifications`;
CREATE TABLE IF NOT EXISTS `user_notifications` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `when_user_message_me` tinyint(1) NOT NULL default '1',
  `when_user_comment_me` tinyint(1) NOT NULL default '1',
  `when_user_follow_or_request_to_follow_me` tinyint(1) NOT NULL default '1',
  `when_user_booked_an_item_followed_by_me` tinyint(1) NOT NULL default '1',
  `when_new_item_was_added_from_my_interests` tinyint(1) NOT NULL default '1',
  `when_user_registered_from_my_invitation` tinyint(1) NOT NULL default '1',
  `when_user_book_an_item_after_your_invitation` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`id`, `created`, `modified`, `user_id`, `when_user_message_me`, `when_user_comment_me`, `when_user_follow_or_request_to_follow_me`, `when_user_booked_an_item_followed_by_me`, `when_new_item_was_added_from_my_interests`, `when_user_registered_from_my_invitation`, `when_user_book_an_item_after_your_invitation`) VALUES
(1, '2011-11-22 07:49:43', '2011-11-22 07:49:43', 2, 1, 1, 1, 1, 1, 1, 1),
(2, '2011-11-22 07:51:35', '2011-11-22 07:51:35', 3, 1, 1, 1, 1, 1, 1, 1),
(3, '2011-11-22 09:41:16', '2011-11-22 09:41:16', 4, 1, 1, 1, 1, 1, 1, 1),
(4, '2011-11-22 09:46:05', '2011-11-22 09:46:05', 5, 1, 1, 1, 1, 1, 1, 1),
(5, '2011-11-22 12:38:04', '2011-11-22 12:38:04', 6, 1, 1, 1, 1, 1, 1, 1),
(6, '2011-11-22 12:42:58', '2011-11-22 12:42:58', 7, 1, 1, 1, 1, 1, 1, 1),
(7, '2012-02-21 10:54:15', '2012-02-21 10:54:15', 8, 1, 1, 1, 1, 1, 1, 1),
(8, '2012-02-21 11:43:33', '2012-02-21 11:43:33', 10, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_openids`
--

DROP TABLE IF EXISTS `user_openids`;
CREATE TABLE IF NOT EXISTS `user_openids` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `openid` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User OpenID Details';

--
-- Dumping data for table `user_openids`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_payment_profiles`
--

DROP TABLE IF EXISTS `user_payment_profiles`;
CREATE TABLE IF NOT EXISTS `user_payment_profiles` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `cim_payment_profile_id` varchar(255) collate utf8_unicode_ci NOT NULL,
  `masked_cc` varchar(255) collate utf8_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `cim_payment_profile_id` (`cim_payment_profile_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_payment_profiles`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `language_id` bigint(20) default NULL,
  `first_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `middle_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `gender_id` int(2) default NULL,
  `dob` date default NULL,
  `about_me` text collate utf8_unicode_ci NOT NULL,
  `city_id` bigint(20) default NULL,
  `state_id` bigint(20) NOT NULL default '0',
  `country_id` bigint(20) NOT NULL default '0',
  `paypal_account` varchar(225) collate utf8_unicode_ci default NULL,
  `home_town` varchar(100) collate utf8_unicode_ci NOT NULL,
  `url` varchar(255) collate utf8_unicode_ci NOT NULL,
  `interesting_fact` text collate utf8_unicode_ci NOT NULL,
  `is_auto_approve_friend_request` tinyint(1) NOT NULL,
  `latitude` double(10,6) NOT NULL,
  `longitude` double(10,6) NOT NULL,
  `last_access` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `city_id` (`city_id`),
  KEY `gender_id` (`gender_id`),
  KEY `user_id` (`user_id`),
  KEY `language_id` (`language_id`),
  KEY `state_id` (`state_id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Profile Details';

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `created`, `modified`, `user_id`, `language_id`, `first_name`, `last_name`, `middle_name`, `gender_id`, `dob`, `about_me`, `city_id`, `state_id`, `country_id`, `paypal_account`, `home_town`, `url`, `interesting_fact`, `is_auto_approve_friend_request`, `latitude`, `longitude`, `last_access`) VALUES
(4, '2011-07-25 12:21:39', '2011-07-25 12:21:39', 1, NULL, '', '', '', NULL, '1992-07-21', 'Elementum nunc dis, pellentesque sed, porttitor rhoncus urna tempor nisi! Et a! Lectus adipiscing eros, scelerisque scelerisque a, pellentesque ut. Urna eu augue aenean non tincidunt auctor placerat. Nunc vel? Urna lundium amet, phasellus nunc pid. Ac tincidunt duis dapibus. Augue turpis, turpis vel odio penatibus? Mid lorem, mid elementum tristique mattis, vel montes, platea amet? Nunc! Turpis aliquet odio rhoncus nisi ut porttitor, integer sit augue turpis aliquam scelerisque? Tortor facilisis, porttitor rhoncus porttitor, vut. Arcu, ut, dis pulvinar ac. Est tortor massa mus non hac nascetur enim enim. Aliquam et lundium diam rhoncus est, scelerisque pulvinar dignissim mattis. Porta urna ac platea integer, augue sed natoque tempor lacus et ridiculus, enim scelerisque sit sed. Tincidunt adipiscing pulvinar eros.', NULL, 0, 0, '', '', '', '', 0, 13.083300, 80.283300, '2012-02-23 07:20:19'),
(37, '2011-11-22 07:49:43', '2011-11-22 11:10:31', 2, 42, 'Andrew', 'Simon', '', 1, '1981-06-11', 'Hey,\n\nI am very open type and enjoying life''s golden moments.....', NULL, 0, 0, NULL, '', '', '', 1, 13.083300, 80.283300, '2012-02-23 05:21:09'),
(38, '2011-11-22 07:51:35', '2011-11-22 11:18:08', 3, 42, 'Ellete', 'Lisa', '', 2, '1987-05-14', 'Hello,\n\nI am very friendly and social type of girl, i love music and get together with friends.', 42464, 0, 0, NULL, '', '', '', 1, 13.083300, 80.283300, '2011-11-22 10:33:32'),
(39, '2011-11-22 09:41:16', '2011-11-22 09:41:16', 4, NULL, '', '', '', NULL, NULL, '', 42551, 71, 109, '', '', '', '', 0, 13.083300, 80.283300, '2012-02-23 04:32:24'),
(40, '2011-11-22 09:46:05', '2011-11-22 09:46:05', 5, NULL, '', '', '', NULL, NULL, '', 42551, 71, 0, NULL, '', '', '', 0, 13.083300, 80.283300, '2011-11-22 07:59:15'),
(41, '2011-11-22 12:38:04', '2011-11-22 12:40:42', 6, 42, 'Franklyn', 'Russuel', '', 1, '1985-11-30', 'Very cool guy ;)', NULL, 0, 0, NULL, '', '', '', 1, 13.083300, 80.283300, '2011-11-22 10:41:10'),
(42, '2011-11-22 12:42:58', '2011-11-22 12:48:39', 7, 42, 'Dab', 'ressler', '', 1, '1982-02-09', 'I am very much interested to participate the social networking sites, also i love friends and like get together with them.....', NULL, 0, 0, NULL, '', '', '', 0, 13.083300, 80.283300, '2011-11-22 10:40:16'),
(43, '2012-02-21 10:54:15', '2012-02-21 10:54:15', 8, NULL, '', '', '', NULL, NULL, '', NULL, 0, 0, NULL, '', '', '', 0, 13.083300, 80.283300, '2012-02-21 09:16:33'),
(44, '2012-02-21 11:43:33', '2012-02-21 11:43:33', 10, NULL, '', '', '', NULL, NULL, '', NULL, 0, 0, NULL, '', '', '', 0, 13.083300, 80.283300, '2012-02-21 08:43:36'),
(45, '2012-02-21 12:55:52', '2012-02-21 12:55:52', 11, NULL, '', '', '', NULL, NULL, '', 42551, 83, 109, '', '', '', '', 0, 13.083300, 80.283300, '2012-02-21 10:20:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_schools`
--

DROP TABLE IF EXISTS `user_schools`;
CREATE TABLE IF NOT EXISTS `user_schools` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_school_degree_id` smallint(6) NOT NULL,
  `college_id` bigint(20) NOT NULL,
  `year` year(4) NOT NULL,
  `major1` varchar(100) collate utf8_unicode_ci NOT NULL,
  `major2` varchar(100) collate utf8_unicode_ci NOT NULL,
  `major3` varchar(100) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_school_degree_id` (`user_school_degree_id`),
  KEY `college_id` (`college_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_schools`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_school_degrees`
--

DROP TABLE IF EXISTS `user_school_degrees`;
CREATE TABLE IF NOT EXISTS `user_school_degrees` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(100) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_school_degrees`
--

INSERT INTO `user_school_degrees` (`id`, `created`, `modified`, `name`) VALUES
(1, '2011-07-20 12:08:22', '2011-07-20 12:08:22', 'MBA'),
(2, '2011-07-20 12:10:13', '2011-07-20 12:10:33', 'BSC'),
(3, '2011-07-20 12:16:04', '2011-07-20 12:16:04', 'MSC'),
(4, '2011-07-20 12:16:19', '2011-07-20 12:16:19', 'MCA'),
(5, '2011-07-20 12:16:37', '2011-07-20 12:16:37', 'BCOM'),
(6, '2011-07-20 12:16:57', '2011-07-20 12:17:13', 'BE');

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

DROP TABLE IF EXISTS `user_types`;
CREATE TABLE IF NOT EXISTS `user_types` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(250) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Type Details';

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `created`, `modified`, `name`) VALUES
(1, NULL, NULL, 'admin'),
(2, NULL, NULL, 'user'),
(3, NULL, NULL, 'merchant');

-- --------------------------------------------------------

--
-- Table structure for table `user_views`
--

DROP TABLE IF EXISTS `user_views`;
CREATE TABLE IF NOT EXISTS `user_views` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `viewing_user_id` bigint(20) default NULL,
  `ip_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `viewing_user_id` (`viewing_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User View Details';

--
-- Dumping data for table `user_views`
--

INSERT INTO `user_views` (`id`, `created`, `modified`, `user_id`, `viewing_user_id`, `ip_id`) VALUES
(1, '2011-11-22 11:08:40', '2011-11-22 11:08:40', 2, 2, 1),
(2, '2011-11-22 11:08:45', '2011-11-22 11:08:45', 2, 2, 1),
(3, '2011-11-22 11:35:02', '2011-11-22 11:35:02', 3, 3, 1),
(4, '2012-02-21 11:02:14', '2012-02-21 11:02:14', 2, 4, 1),
(5, '2012-02-21 11:15:47', '2012-02-21 11:15:47', 2, 4, 1),
(6, '2012-02-21 12:14:57', '2012-02-21 12:14:57', 2, 2, 1),
(7, '2012-02-21 12:15:03', '2012-02-21 12:15:03', 8, 2, 1),
(8, '2012-02-21 12:54:14', '2012-02-21 12:54:14', 8, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_statuses`
--

DROP TABLE IF EXISTS `withdrawal_statuses`;
CREATE TABLE IF NOT EXISTS `withdrawal_statuses` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `user_cash_withdrawal_count` bigint(20) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `withdrawal_statuses`
--

INSERT INTO `withdrawal_statuses` (`id`, `created`, `modified`, `name`, `user_cash_withdrawal_count`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Pending', 1),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Under Process', 0),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Rejected', 9),
(4, '2010-04-15 14:20:17', '2010-04-15 14:20:17', 'Failed', 12),
(5, '2010-04-15 14:20:17', '2010-04-15 14:20:17', 'Success', 0);
