CREATE TABLE IF NOT EXISTS `{$dbprefix}contentarchives_{$lang}` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `CO_ID` int(10) DEFAULT NULL,
  `CO_Node` varchar(200) NOT NULL,
  `CO_seoTitle` varchar(200) DEFAULT '',
  `CO_seoDesc` varchar(400) DEFAULT '',
  `CO_seoKeywords` varchar(400) DEFAULT '',  
  `CO_MenuTitle` varchar(200) DEFAULT '',
  `CO_Template` varchar(100) DEFAULT '',
  `CO_MobileTemplate` varchar(100) DEFAULT '',
  `CO_Body` longtext,
  `CO_MobileBody` longtext,
  `CO_WhenModified` datetime DEFAULT NULL,
  `CO_ModifiedBy` varchar(75) DEFAULT NULL,
  `CO_Javascript` text,
  `CO_MobileJavascript` text,
  `CO_CSS` text,
  `CO_MobileCSS` text,
  `CO_externalLink` text,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$dbprefix}contentdrafts_{$lang}` (
  `draft_id` int(3) NOT NULL AUTO_INCREMENT,
  `CO_ID` int(3) DEFAULT NULL,
  `CO_Node` int(10) NOT NULL,
  `CO_seoTitle` varchar(200) DEFAULT '',
  `CO_seoDesc` varchar(400) DEFAULT '',
  `CO_seoKeywords` varchar(400) DEFAULT '',  
  `CO_MenuTitle` varchar(200) DEFAULT '',
  `CO_Url` varchar(200) DEFAULT NULL,
  `CO_Body` longtext,
  `CO_MobileBody` longtext,
  `CO_Template` varchar(100) NOT NULL DEFAULT '',
  `CO_MobileTemplate` varchar(100) NOT NULL DEFAULT '',
  `CO_Active` int(1) DEFAULT NULL,
  `CO_Searchable` int(1) DEFAULT '0',
  `CO_WhenModified` datetime DEFAULT NULL,
  `CO_ModifiedBy` varchar(75) NOT NULL DEFAULT '',
  `CO_Public` int(1) DEFAULT NULL,  /* CO_Public = TRUE means it is available in all top nav menus */
  `CO_Javascript` text,
  `CO_MobileJavascript` text,
  `CO_CSS` text,
  `CO_MobileCSS` text,
  `CO_Color` varchar(7) DEFAULT '',   
  `CO_externalLink` text,
  PRIMARY KEY (`draft_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;






CREATE TABLE IF NOT EXISTS `{$dbprefix}content_{$lang}` (
  `CO_ID` int(3) NOT NULL AUTO_INCREMENT,
  `CO_Node` int(4) NOT NULL,
  `CO_seoTitle` varchar(200) DEFAULT '',
  `CO_seoDesc` varchar(400) DEFAULT '',
  `CO_seoKeywords` varchar(400) DEFAULT '',  
  `CO_MenuTitle` varchar(200) DEFAULT '',
  `CO_Url` varchar(200) DEFAULT NULL,
  `CO_Body` longtext,
  `CO_MobileBody` longtext,
  `CO_Template` varchar(100) DEFAULT '',
  `CO_MobileTemplate` varchar(100) NOT NULL DEFAULT '',
  `CO_Active` int(1) DEFAULT NULL,
  `CO_Searchable` int(1) DEFAULT '0',
  `CO_WhenModified` datetime DEFAULT NULL,
  `CO_ModifiedBy` varchar(75) NOT NULL DEFAULT '',
  `CO_Public` int(1) DEFAULT NULL,  /* CO_Public = TRUE means it is available in all top nav menus */
  `CO_Javascript` text,
  `CO_MobileJavascript` text,
  `CO_CSS` text,
  `CO_MobileCSS` text,
  `CO_Color` varchar(7) DEFAULT '',   
  `CO_externalLink` text,
  PRIMARY KEY (`CO_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;





/* SEARCH AND TAGGING 
* IMPORTANT: fultext indexes requires MyISAM
*
*/

CREATE TABLE IF NOT EXISTS `{$dbprefix}searchindex_{$lang}` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `content_module` varchar(100) NOT NULL,
  `content_id` int(10) NOT NULL,
  `priority` INT(2) NOT NULL DEFAULT '8', /* used for sitemap.xml */
  `change_frequency` INT(1) NOT NULL DEFAULT '4', /* used for sitemap.xml */
  `slug` varchar(100) NOT NULL DEFAULT '', /* used for sitemap.xml */   
  `expiration` bigint(12) DEFAULT NULL,
  `updated` bigint(12) DEFAULT NULL,
  `contentlength` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE `{$dbprefix}searchindex_{$lang}` ADD FULLTEXT `title` (`title`);
ALTER TABLE `{$dbprefix}searchindex_{$lang}` ADD FULLTEXT `content` (`content`);



CREATE TABLE IF NOT EXISTS `{$dbprefix}searchtags_{$lang}` (

  `id` int(3) NOT NULL AUTO_INCREMENT,
  `tag` varchar(100) NOT NULL,
  
  PRIMARY KEY (`id`)
  
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$dbprefix}searchtags_bridge_{$lang}` (
  `tag_id` int(10) DEFAULT NULL,
  `content_module` varchar(100) NOT NULL,
  `content_id` int(10) NOT NULL  
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Creates a link between tags and searchable content';