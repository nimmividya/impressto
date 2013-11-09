<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

		
	$lang_avail = $this->config->item('lang_avail');
	
	
	foreach($lang_avail AS $langcode=>$language){ 
	
	
		if ( ! $this->db->table_exists("searchindex_" .$langcode)){
		
			$this->db->query("
			CREATE TABLE `".$this->db->dbprefix("searchindex_" .$langcode)."` (
				`id` int(3) NOT NULL AUTO_INCREMENT,
				`title` text NOT NULL,
				`content` text NOT NULL,
				`content_module` varchar(100) NOT NULL,
				`content_id` int(10) NOT NULL,
				`expiration` bigint(12) DEFAULT NULL,
				`updated` bigint(12) DEFAULT NULL,
				`contentlength` int(8) NOT NULL DEFAULT '0',
				PRIMARY KEY (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
			
			$this->db->query("ALTER TABLE `".$this->db->dbprefix("searchindex_" .$langcode)."` ADD FULLTEXT `title` (`title`)");
			$this->db->query("ALTER TABLE `".$this->db->dbprefix("searchindex_" .$langcode)."` ADD FULLTEXT `content` (`content`)");	
		
		
		
		}
		
		if ( ! $this->db->table_exists("searchtags_" .$langcode)){
		
			$this->db->query("
				CREATE TABLE `".$this->db->dbprefix("searchtags_" .$langcode)."` (
				`id` int(3) NOT NULL AUTO_INCREMENT,
				`tag` varchar(100) NOT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
	
		}
		
		if ( ! $this->db->table_exists("searchtags_bridge_" .$langcode)){
		
			$this->db->query("
				CREATE TABLE `".$this->db->dbprefix("searchtags_bridge_" .$langcode)."` (
				`tag_id` int(10) DEFAULT NULL,
				`content_module` varchar(100) NOT NULL,
				`content_id` int(10) NOT NULL  
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
	
		}


	}
	
