

CREATE TABLE IF NOT EXISTS `{$dbprefix}recover_password` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `token` char(40) collate utf8_bin NOT NULL,
  `email` varchar(255) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `{$dbprefix}role` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(20) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=0 ;

--
-- Dumping data for table `role`
--

REPLACE INTO `{$dbprefix}role` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'member');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `{$dbprefix}sessions` (
  `session_id` varchar(40) collate utf8_bin NOT NULL default '0',
  `ip_address` varchar(45) collate utf8_bin NOT NULL default '0',
  `user_agent` varchar(120) collate utf8_bin default NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text collate utf8_bin NOT NULL,
  PRIMARY KEY  (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `{$dbprefix}settings` (
  `id` tinyint(4) NOT NULL auto_increment,
  `login_enabled` tinyint(1) NOT NULL,
  `register_enabled` tinyint(1) NOT NULL,
  `install_enabled` tinyint(1) NOT NULL default '1',
  `members_per_page` tinyint(4) NOT NULL,
  `admin_email` varchar(255) collate utf8_bin NOT NULL,
  `home_page` varchar(50) collate utf8_bin NOT NULL,
  `default_theme` varchar(40) collate utf8_bin NOT NULL,
  `login_attempts` tinyint(4) NOT NULL,
  `recaptcha_theme` varchar(20) collate utf8_bin NOT NULL default 'white',
  `email_protocol` tinyint(4) NOT NULL default '1',
  `sendmail_path` varchar(100) collate utf8_bin NOT NULL default '/usr/sbin/sendmail',
  `smtp_host` varchar(255) collate utf8_bin NOT NULL default 'ssl://smtp.googlemail.com',
  `smtp_port` smallint(6) NOT NULL default '465',
  `smtp_user` mediumblob NOT NULL,
  `smtp_pass` mediumblob NOT NULL,
  `site_title` varchar(60) collate utf8_bin NOT NULL default 'CI_Membership',
  `cookie_expires` int(11) NOT NULL,
  `password_link_expires` int(11) NOT NULL,
  `activation_link_expires` int(11) NOT NULL,
  `disable_all` tinyint(1) NOT NULL,
  `site_disabled_text` tinytext collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `settings`
--

REPLACE INTO `{$dbprefix}settings` (`id`, `login_enabled`, `register_enabled`, `install_enabled`, `members_per_page`, `admin_email`, `home_page`, `default_theme`, `login_attempts`, `recaptcha_theme`, `email_protocol`, `sendmail_path`, `smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`, `site_title`, `cookie_expires`, `password_link_expires`, `activation_link_expires`, `disable_all`, `site_disabled_text`) VALUES
(1, 1, 1, 1, 20, 'admin@example.com', 'home', 'branded', 5, 'white', 2, '/usr/sbin/sendmail', 'ssl://smtp.googlemail.com', 465, '', '', 'CI_Membership', 259200, 43200, 43200, 0, 'This website is momentarily offline.');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `{$dbprefix}user` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(16) collate utf8_bin NOT NULL,
  `password` char(128) collate utf8_bin NOT NULL,
  `email` varchar(255) collate utf8_bin NOT NULL,
  `date_registered` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `nonce` varchar(32) collate utf8_bin NOT NULL,
  `first_name` varchar(40) collate utf8_bin NOT NULL,
  `last_name` varchar(60) collate utf8_bin NOT NULL,
  `role_id` tinyint(4) NOT NULL default '2',
  `active` tinyint(1) NOT NULL default '0',
  `banned` tinyint(1) NOT NULL default '0',
  `login_attempts` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=0 ;

