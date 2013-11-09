

CREATE TABLE IF NOT EXISTS `{$dbprefix}image_slider` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `widget_name` varchar(25) DEFAULT NULL,
  `title_en` varchar(100) DEFAULT '',
  `title_fr` varchar(100) DEFAULT '',
  `caption_en` text,
  `caption_fr` text,
  `url_en` varchar(255) DEFAULT '',
  `url_fr` varchar(255) DEFAULT '',
  `active_en` int(1) DEFAULT 1,
  `active_fr` int(1) DEFAULT 1,
  `slide_img` text,
  `position` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;





CREATE TABLE IF NOT EXISTS `{$dbprefix}image_slider_settings` (
  `widget_name` varchar(25) DEFAULT NULL,
  `effect` text,
  `speed` text,
  `pausetime` text,
  `pauseonhover` text,
  `textsize` int(11) DEFAULT '12'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


	


    

		