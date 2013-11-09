

CREATE TABLE IF NOT EXISTS `{$dbprefix}image_galleries` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '',
  `description` text,
  `template` varchar(255) DEFAULT 'default.tpl.php',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$dbprefix}image_gallery_settings` (
  `gallery` int(10) NOT NULL,
  `name` varchar(50) DEFAULT '',
  `val` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$dbprefix}image_gallery_items` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gallery` int(10) NOT NULL, /* items are specific to each gallery instance */	
  `category` int(10) NOT NULL,
  `imagename` varchar(255) DEFAULT '',
  `caption` text,
  `html_content` text,
  `alttag` varchar(100) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_type` varchar(50) DEFAULT NULL,
  `views` int(10) DEFAULT '0',
  `position` int(10) DEFAULT '0',
  `created` int(12) DEFAULT '0',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `{$dbprefix}image_gallery_categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gallery` int(10) NOT NULL, /* categories are specific to each gallery instance */	
  `category_image` int(10) NULL DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `position` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


