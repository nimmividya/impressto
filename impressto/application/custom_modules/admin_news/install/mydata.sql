
CREATE TABLE IF NOT EXISTS `{$dbprefix}news` (
  `news_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `archived` int(1) DEFAULT '0',
  `active` varchar(2) DEFAULT '0',
  `opennewwindow` varchar(2) DEFAULT '0',
  `added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL,
  `published` date DEFAULT '0000-00-00',
  PRIMARY KEY (`news_id`),
  UNIQUE KEY `news_id` (`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




