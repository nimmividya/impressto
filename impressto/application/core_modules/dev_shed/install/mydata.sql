

CREATE TABLE IF NOT EXISTS `{$dbprefix}timesheet_samples` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` int(10) DEFAULT NULL,
  `entry` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$dbprefix}timesheet_sample_categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

REPLACE INTO `{$dbprefix}timesheet_sample_categories` (`name`) VALUES 
('client development'), 
('general administration');





    

		