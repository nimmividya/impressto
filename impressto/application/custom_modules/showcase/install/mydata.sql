

CREATE TABLE IF NOT EXISTS `{$dbprefix}showcases` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) DEFAULT '0', /* some of these showcases will belong to specific system users */	
  `name` varchar(255) DEFAULT '',
  `description` text,
  `template` varchar(255) DEFAULT 'default.tpl.php',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$dbprefix}showcase_settings` (
  `gallery` int(10) NOT NULL,
  `name` varchar(50) DEFAULT '',
  `val` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* allow people to vote on items */
CREATE TABLE IF NOT EXISTS `{$dbprefix}showcase_votes` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`user_id` INT(10) UNSIGNED NOT NULL,
	`item_id` INT(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* used for those 5 or 10 star rating widgets */
CREATE TABLE IF NOT EXISTS `{$dbprefix}showcase_ratings` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`user_id` INT(10) UNSIGNED NOT NULL,
	`item_id` INT(10) UNSIGNED NOT NULL,
	`rating` INT(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$dbprefix}showcase_items` (
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




CREATE TABLE IF NOT EXISTS `{$dbprefix}showcase_categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gallery` int(10) NOT NULL, /* categories are specific to each gallery instance */	
  `category_image` int(10) NULL DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `position` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


