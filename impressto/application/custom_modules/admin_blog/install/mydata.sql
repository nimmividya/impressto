
CREATE TABLE IF NOT EXISTS `{$dbprefix}blog` (
  	`blog_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`active` INT(1) NULL DEFAULT '0',
	`opennewwindow` VARCHAR(2) NULL DEFAULT '0',
	`archived` INT(1) NOT NULL DEFAULT '0',
	`added` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`blog_id`),
	UNIQUE KEY `blog_id` (`blog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

