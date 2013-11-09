
CREATE TABLE `{$dbprefix}installer_packages` (
	`id` INT(10) NULL AUTO_INCREMENT,
	`mod_name` VARCHAR(100) NOT NULL DEFAULT '',
	`mod_type` ENUM('core','custom') NOT NULL DEFAULT 'custom',
	`author` VARCHAR(255) NOT NULL,
	`short_description` TEXT NOT NULL,
	`version` INT(3) NOT NULL DEFAULT '0',
	`min_core_version` INT(3) NOT NULL DEFAULT '0',
	`max_core_version` INT(3) NOT NULL DEFAULT '0',
	`updated` INT(12) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;





