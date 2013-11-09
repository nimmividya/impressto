

CREATE TABLE IF NOT EXISTS `{$dbprefix}form_builder_forms`  (
	`id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
	`form_name` VARCHAR( 255 ) NOT NULL,
	`template` VARCHAR( 100 ) NOT NULL default '',
	`email_account` VARCHAR( 100 ) NOT NULL default '',
	`button_value` VARCHAR( 100 ) NOT NULL default '',
	`captcha` VARCHAR(25) NOT NULL DEFAULT '',
	`captcha_theme` VARCHAR( 100 ) NOT NULL default '',
	`from_a` VARCHAR( 100 ) NOT NULL default '',
	`content` TEXT,
	`success_message` TEXT,
	`javascript` TEXT,
	`updated` DATETIME NULL DEFAULT NULL,	
	PRIMARY KEY ( `id` )
);


CREATE TABLE IF NOT EXISTS `{$dbprefix}form_builder_form_fields`  (
	`form_id` int(10) NOT NULL,
	`field_id` INT( 10 ) NOT NULL,
	PRIMARY KEY ( `field_id` )
);



CREATE TABLE IF NOT EXISTS `{$dbprefix}form_builder_fields`  (
	`field_id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
	`field_name` VARCHAR( 100 ) NOT NULL ,
	`field_label` VARCHAR(100) NOT NULL DEFAULT '',
	`showlabel` INT( 1 )  NOT NULL DEFAULT '1',
	`paragraph` TEXT,
	`active` INT( 1 ) NOT NULL DEFAULT '1',
	`disabled` INT( 1 ) NOT NULL DEFAULT '0',
	`visible` INT( 1 ) NOT NULL DEFAULT '1',
	`ftype` VARCHAR( 50 ) NOT NULL ,
	`required` INT( 1 )  NOT NULL DEFAULT '0',
	`field_value` TEXT,
	`default_value` TEXT,
	`width` VARCHAR( 6 ) NOT NULL DEFAULT '',
	`height` VARCHAR( 6 ) NOT NULL DEFAULT '',
	`orientation` ENUM('horizontal','vertical') NOT NULL DEFAULT 'horizontal',
	`onchange` TEXT,
	`position` INT( 4 ) ,
	`updated` DATETIME NULL DEFAULT NULL,

	PRIMARY KEY ( `field_id` )
) ENGINE = MYISAM 
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;



CREATE TABLE IF NOT EXISTS `{$dbprefix}form_builder_element_options` (
`option_id` int(11) NOT NULL auto_increment,
`element_id` int(11) NOT NULL default '0',
`option_value` varchar(255) default NULL,
`option_label` varchar(255) default NULL,
`position` int(11) NOT NULL default '0',
PRIMARY KEY  (`option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$dbprefix}form_builder_records`  (
`id` int(10) NOT NULL AUTO_INCREMENT,
`form_id` int(10) NOT NULL,
`created` int(12) DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;








