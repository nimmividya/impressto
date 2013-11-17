
/* 

PageShaper is a full API server so we will add a basic api key registey table
- Additional API functionality can be added as joins to this table
- See the 
*/


CREATE TABLE IF NOT EXISTS  `{$dbprefix}sessions` (
    session_id varchar(40) DEFAULT '0' NOT NULL,
    ip_address varchar(45) DEFAULT '0' NOT NULL,
    user_agent varchar(120) NOT NULL,
    last_activity int(10) unsigned DEFAULT 0 NOT NULL,
    user_data text NOT NULL,
    prevent_update int(10) DEFAULT NULL,
    PRIMARY KEY (session_id),
    KEY `last_activity_idx` (`last_activity`)
);



CREATE TABLE IF NOT EXISTS `{$dbprefix}api_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$dbprefix}modules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `active` enum('Y','N') DEFAULT 'N',
  `searchable` enum('Y','N') DEFAULT 'N',
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `{$dbprefix}modules` (`name`, `active`) VALUES ('site_settings', 'Y');
INSERT INTO `{$dbprefix}modules` (`name`, `active`) VALUES ('module_manager', 'Y');
INSERT INTO `{$dbprefix}modules` (`name`, `active`) VALUES ('admin_users', 'Y');
INSERT INTO `{$dbprefix}modules` (`name`, `active`) VALUES ('page_manager', 'Y');
INSERT INTO `{$dbprefix}modules` (`name`, `active`) VALUES ('site_search', 'Y');
INSERT INTO `{$dbprefix}modules` (`name`, `active`) VALUES ('stylesheet_manager', 'Y');
INSERT INTO `{$dbprefix}modules` (`name`, `active`) VALUES ('tags', 'Y');
INSERT INTO `{$dbprefix}modules` (`name`, `active`) VALUES ('templates', 'Y');
INSERT INTO `{$dbprefix}modules` (`name`, `active`) VALUES ('widget_manager', 'Y');
INSERT INTO `{$dbprefix}modules` (`name`, `active`) VALUES ('admin_help', 'Y');



CREATE TABLE IF NOT EXISTS `{$dbprefix}module_permissions` (
  `module_id` int(10) DEFAULT NULL,
  `role` int(10) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$dbprefix}content_nodes` (
  `node_id` int(10) NOT NULL AUTO_INCREMENT,
  `node_parent` int(10) DEFAULT NULL,
  `node_position` int(10) DEFAULT NULL,
  PRIMARY KEY (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `{$dbprefix}content_nodes` (`node_id`, `node_parent`, `node_position`) VALUES (1, 0, 0);



CREATE TABLE IF NOT EXISTS `{$dbprefix}options` (
  `name` varchar(50) DEFAULT '',
  `module` varchar(50) DEFAULT '',
  `value` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `{$dbprefix}options` (`name`, `module`, `value`) VALUES ('admin_theme', 'core', 'liquid');
INSERT INTO `{$dbprefix}options` (`name`, `module`, `value`) VALUES ('wysiwyg_editor', 'core', 'tiny_mce');
INSERT INTO `{$dbprefix}options` (`name`, `module`, `value`) VALUES ('debug_profiling', 'core', '1');
INSERT INTO `{$dbprefix}options` (`name`, `module`, `value`) VALUES ('debugmode', 'core', '1');
INSERT INTO `{$dbprefix}options` (`name`, `module`, `value`) VALUES ('site_title_en', 'core', '{$site_title_en}');





/*
BEGIN User Management Section 
*/





CREATE TABLE IF NOT EXISTS `{$dbprefix}user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `role_theme` varchar(50) DEFAULT '',
  `dashboard_template` varchar(255) DEFAULT '',
  `dashboard_page` int(10) DEFAULT NULL,
  `profile_template` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `{$dbprefix}user_roles` (`name`, `description`) VALUES ('administrator','super administrator');
INSERT INTO `{$dbprefix}user_roles` (`name`, `description`) VALUES ('editor','standard permissions');



/* user groups are just used to categories users. Nothing to do with access rights */

CREATE TABLE IF NOT EXISTS `{$dbprefix}user_groups` (
  `u_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group` varchar(255) NOT NULL,
  `activate` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`u_group_id`)
);


/* This is the root authentication table. It can be joined to any other user profile table */
CREATE TABLE IF NOT EXISTS `{$dbprefix}users` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(75) NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	`email` VARCHAR(75) NOT NULL,
	`activated` TINYINT(1) NOT NULL DEFAULT '1',
	`role` INT(10) NOT NULL DEFAULT '0',
	`user_group` INT(10) NOT NULL DEFAULT '0', /* now redundant */
	`created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`last_login` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=InnoDB;

/* This is default profile table used with the im_auth authentication prodived library. It can be swapped out 
with whatever tabele is required by the selectd authentication library */ 
CREATE TABLE IF NOT EXISTS `{$dbprefix}user_profile` (
	`user_id` INT(11),
	`first_name` VARCHAR(255) NOT NULL,
	`last_name` VARCHAR(255) NOT NULL,
	`oauth_provider` VARCHAR(50) NOT NULL, /* standard or the social media channel */
	`oauth_provider_name` VARCHAR(75) NOT NULL, 
	`oauth_uid` VARCHAR(75) NOT NULL
) COLLATE='utf8_general_ci' ENGINE=InnoDB;


/* This table is used to assign field management properties to any user field in the user profile table */
CREATE TABLE `{$dbprefix}user_fields` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`field_name` VARCHAR(100) NOT NULL, /* name of field in the user_profile table */
	`input_type` VARCHAR(25) NOT NULL, /* comment: this is the form input type, not the data type */
	`field_value` TEXT NOT NULL,
	`default_value` TEXT NULL,
	`paragraph` TEXT,
	`visible` INT( 1 ) NOT NULL DEFAULT '1', /* in some cases we do not want users to see private admin data */
	`active` INT( 1 ) NOT NULL DEFAULT '1',
	`width` VARCHAR( 6 ) NOT NULL DEFAULT '',
	`height` VARCHAR( 6 ) NOT NULL DEFAULT '',
	`required` INT(1) NOT NULL DEFAULT '0',
	`orientation` ENUM('horizontal','vertical') NOT NULL DEFAULT 'horizontal',
	`onchange` TEXT,
	`position` INT(4) NOT NULL DEFAULT '0',
	`updated` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=3;



CREATE TABLE IF NOT EXISTS `{$dbprefix}user_field_options` (
	`option_id` int(11) NOT NULL auto_increment,
	`field_id` int(11) NOT NULL default '0',
	`option_value` varchar(255) default NULL,
	`option_label` varchar(255) default NULL,
	`position` int(11) NOT NULL default '0',
	PRIMARY KEY  (`option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



/* simply maps the roles to existing user fields */
CREATE TABLE IF NOT EXISTS `{$dbprefix}user_role_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



/*
END User Management Section 
*/


CREATE TABLE IF NOT EXISTS `{$dbprefix}widgets` (
  `widget_id` int(10) NOT NULL AUTO_INCREMENT,
  `module` varchar(50) DEFAULT '',
  `widget` varchar(50) DEFAULT NULL,
  `instance` varchar(50) DEFAULT '',
  `slug` varchar(50) DEFAULT '',
  PRIMARY KEY (`widget_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$dbprefix}widget_collections` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$dbprefix}widget_collection_assignments` (
  `page_node` int(10) DEFAULT NULL,
  `widget_collection` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$dbprefix}widget_options` (
  `widget_id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='this holds the default values for widgets';



CREATE TABLE IF NOT EXISTS `{$dbprefix}widget_placements` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `collection_id` int(10) DEFAULT NULL,
  `widget_id` int(10) DEFAULT NULL,
  `zone_id` int(50) DEFAULT NULL,
  `position` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$dbprefix}widget_placement_options` (
  `placement_id` int(10) NOT NULL,
  `name` varchar(55) DEFAULT '',
  `value` varchar(255) DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$dbprefix}widget_zones` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `colorcode` varchar(7) NOT NULL,
  `position` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$dbprefix}files` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `directory` varchar(255) DEFAULT '',
  `file` varchar(255) DEFAULT '',
  `description` text,
  `mime` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS {$dbprefix}migrations (
  `version` int(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- command split --

INSERT INTO {$dbprefix}migrations VALUES (0);



/*  used to contol access to pages and control of what user can do on pages - e.g. comments */

CREATE TABLE IF NOT EXISTS `{$dbprefix}content_rights` (
  `node_id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

	
	
