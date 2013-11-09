
CREATE TABLE IF NOT EXISTS `{$dbprefix}stickynotes` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`message` TEXT NOT NULL,
	`priority` INT(1) NOT NULL DEFAULT '1',
	`content_id` INT(10) NOT NULL,
	`content_lang` VARCHAR(2) NOT NULL,
	`user_id` INT(10) NOT NULL,
	`top_pos` INT(3) NOT NULL DEFAULT '0',
	`left_pos` INT(3) NOT NULL DEFAULT '0',		
	`updated` BIGINT(12) NULL DEFAULT NULL,

	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;





    

		