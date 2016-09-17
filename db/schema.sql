-- ==========================================================
--
-- Rate My Instructor -- database schema
--
-- Includes the app's own tables (rmi_*) plus the minimal
-- `members` table shape it expects for authentication
-- (originally an SMF forum's `smf_members` table -- swap in
-- whatever your own auth/members table looks like, as long
-- as the column names referenced in connect.php/scripts line up).
--
-- ==========================================================

--
-- Table structure for table `rmi_addinstructor`
--

CREATE TABLE IF NOT EXISTS `rmi_addinstructor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `whosubmit` int(11) NOT NULL,
  `insname` varchar(75) NOT NULL,
  `insinfo` varchar(250) NOT NULL,
  `ip` varchar(16) NOT NULL DEFAULT '127.0.0.1',
  `waittime` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `new` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `rmi_instructors`
--

CREATE TABLE IF NOT EXISTS `rmi_instructors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ins_name` varchar(50) NOT NULL,
  `title` varchar(20) NOT NULL DEFAULT 'Instructor',
  `ismale` int(1) NOT NULL,
  `email` varchar(20) NOT NULL,
  `office` varchar(10) NOT NULL,
  `collegeof` int(1) NOT NULL DEFAULT '0',
  `department` varchar(50) NOT NULL,
  `course_1` varchar(10) NOT NULL,
  `course_2` varchar(10) NOT NULL,
  `course_3` varchar(10) NOT NULL,
  `course_4` varchar(10) NOT NULL,
  `course_5` varchar(10) NOT NULL,
  `addedby` int(11) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `rmi_instructors`
--

--
-- Table structure for table `rmi_rate`
--

CREATE TABLE IF NOT EXISTS `rmi_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rater_id` int(11) NOT NULL,
  `ins_id` int(11) NOT NULL,
  `rate` int(1) NOT NULL,
  `lod` int(1) NOT NULL,
  `course_name` varchar(10) NOT NULL,
  `take_again` int(1) NOT NULL,
  `textbook` int(1) NOT NULL,
  `attendance` int(1) NOT NULL,
  `hotness` int(1) NOT NULL,
  `test_pattern` int(1) NOT NULL,
  `tag1` int(11) NOT NULL,
  `tag2` int(11) NOT NULL,
  `tag3` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `recgrade` int(11) NOT NULL DEFAULT '11',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `rmi_rate`
--

--
-- Table structure for table `rmi_script`
--

CREATE TABLE IF NOT EXISTS `rmi_script` (
  `title` varchar(55) NOT NULL DEFAULT 'Rate My Instructor!',
  `description` varchar(500) NOT NULL DEFAULT 'Share your opinion about your instructors!',
  `version` varchar(20) NOT NULL DEFAULT 'v1.0.3 (beta)',
  `keywords` varchar(100) NOT NULL DEFAULT 'rate my instructor college university professor reviews',
  `webmaster` varchar(80) CHARACTER SET latin1 NOT NULL DEFAULT 'admin@example.com',
  `footer` varchar(200) CHARACTER SET latin1 NOT NULL DEFAULT '&copy; 2016 | All rights reserved.',
  `maxrating` int(11) NOT NULL DEFAULT '5',
  `maxlod` int(11) NOT NULL DEFAULT '5',
  `maxrecentratings` int(11) NOT NULL DEFAULT '15',
  `giverespect` int(11) NOT NULL DEFAULT '5',
  `respectsuggest` int(11) NOT NULL DEFAULT '35',
  `rate_name_1` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT 'Bad',
  `rate_name_2` varchar(50) NOT NULL DEFAULT 'Satisfactory',
  `rate_name_3` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT 'Good',
  `rate_name_4` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT 'Very Good',
  `rate_name_5` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT 'Excellent!',
  `lod_name_1` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT 'Easy A',
  `lod_name_2` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT 'Show up & pass',
  `lod_name_3` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT 'Make you work for it',
  `lod_name_4` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT 'Hardest thing I''ve ever done',
  `lod_name_5` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT 'Never take this instructor, ever',
  `myratingpage` int(11) NOT NULL DEFAULT '3',
  `numberofinstructors` int(11) NOT NULL DEFAULT '15',
  `disablecomments` int(1) NOT NULL DEFAULT '0',
  `numberofcomments` int(11) NOT NULL DEFAULT '3',
  `disclaimer` varchar(500) NOT NULL DEFAULT 'Thank you for visiting this section of the website. We want all of you to acknowledge that we respect each and every single faculty member of our university and we do not (in any case) would want to devalue their hard-work at campus. These are just thoughts and opinions of students for other students. '
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rmi_script`
--

--
-- Table structure for table `rmi_tags`
--

CREATE TABLE IF NOT EXISTS `rmi_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Expected members table (originally SMF's `smf_members`)
-- Only used for login/auth -- id_member, member_name, real_name,
-- passwd, email_address, karma_good, posts are the columns this
-- script actually reads.
--

DROP TABLE IF EXISTS `smf_members`;

CREATE TABLE `smf_members` (
 `id_member` mediumint(8) unsigned NOT NULL auto_increment,
 `member_name` varchar(80) NOT NULL default '',
 `date_registered` int(10) unsigned NOT NULL default 0,
 `posts` mediumint(8) unsigned NOT NULL default 0,
 `id_group` smallint(5) unsigned NOT NULL default 0,
 `lngfile` varchar(255) NOT NULL default '',
 `last_login` int(10) unsigned NOT NULL default 0,
 `real_name` varchar(255) NOT NULL default '',
 `instant_messages` smallint(5) NOT NULL default 0,
 `unread_messages` smallint(5) NOT NULL default 0,
 `new_pm` tinyint(3) unsigned NOT NULL default 0,
 `buddy_list` text NOT NULL,
 `pm_ignore_list` varchar(255) NOT NULL default '',
 `pm_prefs` mediumint(8) NOT NULL default 0,
 `mod_prefs` varchar(20) NOT NULL default '',
 `message_labels` text NOT NULL,
 `passwd` varchar(64) NOT NULL default '',
 `openid_uri` text NOT NULL,
 `email_address` varchar(255) NOT NULL default '',
 `personal_text` varchar(255) NOT NULL default '',
 `gender` tinyint(4) unsigned NOT NULL default 0,
 `birthdate` date NOT NULL default '0001-01-01',
 `website_title` varchar(255) NOT NULL default '',
 `website_url` varchar(255) NOT NULL default '',
 `location` varchar(255) NOT NULL default '',
 `icq` varchar(255) NOT NULL default '',
 `aim` varchar(255) NOT NULL default '',
 `yim` varchar(32) NOT NULL default '',
 `msn` varchar(255) NOT NULL default '',
 `hide_email` tinyint(4) NOT NULL default 0,
 `show_online` tinyint(4) NOT NULL default 1,
 `time_format` varchar(80) NOT NULL default '',
 `signature` text NOT NULL,
 `time_offset` float NOT NULL default 0,
 `avatar` varchar(255) NOT NULL default '',
 `pm_email_notify` tinyint(4) NOT NULL default 0,
 `karma_bad` smallint(5) unsigned NOT NULL default 0,
 `karma_good` smallint(5) unsigned NOT NULL default 0,
 `usertitle` varchar(255) NOT NULL default '',
 `notify_announcements` tinyint(4) NOT NULL default 1,
 `notify_regularity` tinyint(4) NOT NULL default 1,
 `notify_send_body` tinyint(4) NOT NULL default 0,
 `notify_types` tinyint(4) NOT NULL default 2,
 `member_ip` varchar(255) NOT NULL default '',
 `member_ip2` varchar(255) NOT NULL default '',
 `secret_question` varchar(255) NOT NULL default '',
 `secret_answer` varchar(64) NOT NULL default '',
 `id_theme` tinyint(4) unsigned NOT NULL default 0,
 `is_activated` tinyint(3) unsigned NOT NULL default 1,
 `validation_code` varchar(10) NOT NULL default '',
 `id_msg_last_visit` int(10) unsigned NOT NULL default 0,
 `additional_groups` varchar(255) NOT NULL default '',
 `smiley_set` varchar(48) NOT NULL default '',
 `id_post_group` smallint(5) unsigned NOT NULL default 0,
 `total_time_logged_in` int(10) unsigned NOT NULL default 0,
 `password_salt` varchar(255) NOT NULL default '',
 `ignore_boards` text NOT NULL,
 `warning` tinyint(4) NOT NULL default 0,
 `passwd_flood` varchar(12) NOT NULL default '',
 `pm_receive_from` tinyint(4) unsigned NOT NULL default 1,
 `anon_posts` int(8) NOT NULL default 0,
 PRIMARY KEY (`id_member`),
 KEY `member_name` (`member_name`),
 KEY `real_name` (`real_name`),
 KEY `date_registered` (`date_registered`),
 KEY `id_group` (`id_group`),
 KEY `birthdate` (`birthdate`),
 KEY `posts` (`posts`),
 KEY `last_login` (`last_login`),
 KEY `lngfile` (`lngfile`(30)),
 KEY `id_post_group` (`id_post_group`),
 KEY `warning` (`warning`),
 KEY `total_time_logged_in` (`total_time_logged_in`),
 KEY `id_theme` (`id_theme`)
) ENGINE=MyISAM;
