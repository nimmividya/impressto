

CREATE TABLE IF NOT EXISTS `ps_top_banners` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `page_node` int(10) default 0,
  `title` varchar(10) DEFAULT "",
   `img` varchar(255) DEFAULT "",
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

