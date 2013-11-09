




CREATE TABLE IF NOT EXISTS `{$dbprefix}clf_compliance` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `page_node` int(10) DEFAULT NULL,
  `lang` varchar(2) DEFAULT '',
  `alt_tags` enum('Y','N') DEFAULT 'N',
  `acronyms` enum('Y','N') DEFAULT 'N',
  `top_links` enum('Y','N') DEFAULT 'N',
  `plain_html` enum('Y','N') DEFAULT 'N',
  `file_naming` enum('Y','N') DEFAULT 'N',
  `navigation` enum('Y','N') DEFAULT 'N',
  `element_width` enum('Y','N') DEFAULT 'N',
  
  
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;






    

		