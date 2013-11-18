


CREATE TABLE IF NOT EXISTS `{$dbprefix}contentblocks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100),
  `javascript` text,
   `css` text,
  `template` varchar(50) DEFAULT '',
  `blockmobile` enum('Y','N') DEFAULT 'N',
  `updated` datetime DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$dbprefix}contentblocks_{$lang}` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `block_id` int(10),
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



