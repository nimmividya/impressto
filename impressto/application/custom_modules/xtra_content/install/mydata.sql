
/* extra fields can be added thought the xtra_content_settings panel */

CREATE TABLE IF NOT EXISTS `{$dbprefix}xtra_content_{$langcode}` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `page_node` int(10) default 0,
  `field_1` text,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$dbprefix}xtra_mobile_content_{$langcode}` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `page_node` int(10) default 0,
  `field_1` text,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
