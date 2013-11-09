<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version7_update extends CI_Migration
{
	public function up()
	{
	
	
		$dbprefix = $this->db->dbprefix;
		
		////////////////////////////////
		//  August 14 , 2012
		$sql = "
			CREATE TABLE IF NOT EXISTS `{$dbprefix}content_rights` (
			`node_id` int(10) NOT NULL,
			`role_id` int(10) NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		";
			
		$this->db->query($sql);
		
		
		$co_seokeywords_set = array(
			'CO_seoKeywords' => array(
				'type'			=> 'varchar',
				'constraint'	=> 500,
				'null'			=> FALSE,
				'default'		=> ''
				)
		);
				
				
		$lang_avail = $this->config->item('lang_avail');
											
		foreach($lang_avail AS $langcode=>$language){  
		
			if (!$this->db->field_exists('CO_seoKeywords', 'content_'.$langcode)){
				$this->dbforge->add_column('content_'.$langcode, $co_seokeywords_set);
			} 
		

		
			if (!$this->db->field_exists('CO_seoKeywords', 'contentdrafts_'.$langcode)){
				$this->dbforge->add_column('contentdrafts_'.$langcode, $co_seokeywords_set);
			} 
		
		
			if (!$this->db->field_exists('CO_seoKeywords', 'contentarchives_'.$langcode)){
				$this->dbforge->add_column('contentarchives_'.$langcode, $co_seokeywords_set);
			} 
		

		}
		
		
					
		

		
		
		if (!$this->db->field_exists('role_theme', 'user_roles')){
		
			$this->dbforge->add_column('user_roles', array(
				'role_theme' => array(
				'type'			=> 'varchar',
				'constraint'	=> 255,
				'null'			=> FALSE,
				'default'		=> ''
				)
			
			));
		
			
		} 
		
		if (!$this->db->field_exists('dashboard_template', 'user_roles')){
		
			$this->dbforge->add_column('user_roles', array(
				'dashboard_template' => array(
				'type'			=> 'varchar',
				'constraint'	=> 255,
				'null'			=> FALSE,
				'default'		=> ''
				)
			
			));
		
			
		} 
		
		
		if (!$this->db->field_exists('dashboard_page', 'user_roles')){
		
			$this->dbforge->add_column('user_roles', array(
				'dashboard_page' => array(
				'type'			=> 'int',
				'constraint'	=> 10,
				'null'			=> TRUE
				)
			
			));
		
			
		} 
		
		
		if (!$this->db->field_exists('profile_template', 'user_roles')){
		
			$this->dbforge->add_column('user_roles', array(
				'profile_template' => array(
				'type'			=> 'varchar',
				'constraint'	=> 255,
				'null'			=> FALSE,
				'default'		=> ''
				)
			
			));
		
			
		} 
		
		//
		//////////////////////////////
		


		
	}

	public function down()
	{

		// not in use right now.
	}
}