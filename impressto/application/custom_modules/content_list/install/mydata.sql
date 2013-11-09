
CREATE TABLE IF NOT EXISTS `{$dbprefix}content_list_items` (

  	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  	`widget_id` INT(10) UNSIGNED NOT NULL,
	`title_en` TEXT NULL,
	`content_en` TEXT NULL,
	`title_fr` TEXT NULL,
	`content_fr` TEXT NULL,
	`position` int(10) DEFAULT '0',
    `active` INT(1) NULL DEFAULT '0',
	`modified` DATETIME NULL DEFAULT NULL,
	
	PRIMARY KEY (`id`)	
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



