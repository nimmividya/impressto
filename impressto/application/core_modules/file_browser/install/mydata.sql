
CREATE TABLE IF NOT EXISTS `{$dbprefix}files` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `directory` varchar(255) DEFAULT '',
  `file` varchar(255) DEFAULT '',
  `description` text,
  `mime` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

