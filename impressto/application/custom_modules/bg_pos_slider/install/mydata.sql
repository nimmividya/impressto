

CREATE TABLE IF NOT EXISTS `ps_bgslider` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `widget_name` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `content` text,
  `leftpos` varchar(10) DEFAULT NULL,
  `background_image` varchar(100) DEFAULT NULL,
  `position` int(10) DEFAULT 0,
  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

