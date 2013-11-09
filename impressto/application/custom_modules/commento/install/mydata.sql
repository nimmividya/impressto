
CREATE TABLE IF NOT EXISTS `{$dbprefix}commento_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `content_id` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `parent` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `show_it` tinyint(1) NOT NULL DEFAULT '1',
  `karma` int(11) NOT NULL DEFAULT '0',
  `dw_vote` int(11) NOT NULL DEFAULT '0',
  `up_vote` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=292 ;

CREATE TABLE IF NOT EXISTS `{$dbprefix}commento_karma_voted` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `com_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `{$dbprefix}commento_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cfg_name` varchar(255) NOT NULL,
  `cfg_value` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;


REPLACE INTO `{$dbprefix}commento_config` (`id`, `cfg_name`, `cfg_value`) VALUES
(1, 'maxnumchars', '7500'),
(2, 'Replymaxnumchars', '1000'),
(3, 'mod_comments', '1'),
(4, 'mid_range', '5'),
(5, 'default_ipp', '25'),
(6, 'conv_url_to_link', '1'),
(7, 'allowed_html', 'pre, strong, ol, ul, li'),
(8, 'blacklist', 'shit, crap'),
(9, 'display_order', 'ASC'),
(10, 'captcha_enabled', '1'),
(11, 'captcha_width', '130'),
(12, 'reg_users_only', '0'),
(13, 'ask_web_address', '1'),
(14, 'karma_on', '0'),
(15, 'karma_type', 'cookie'),
(16, 'captcha_color1', '#78b4f0'),
(17, 'captcha_color2', '#888888'),
(18, 'captcha_color3', '#78b4f0'),
(19, 'captcha_colorbg', ''),
(20, 'initial_hidden', '0'),
(21, 'notification_email', ''),
(22, 'template', '');




