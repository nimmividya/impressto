<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version3_update extends CI_Migration
{
	public function up()
	{
	
		$lang_avail = $this->config->item('lang_avail');
											
		foreach($lang_avail AS $langcode=>$language){  
		
		
			if (!$this->db->field_exists('CO_Color', 'content_'.$langcode)){
		
				$this->dbforge->add_column('content_'.$langcode, array(
					'CO_Color' => array(
					'type'			=> 'varchar',
					'constraint'	=> 7,
					'null'			=> FALSE,
					'default'		=> ''
					)
			
				));
			
			}
			
			if (!$this->db->field_exists('CO_MobileJavascript', 'content_'.$langcode)){
		
				$this->dbforge->add_column('content_'.$langcode, array(
					'CO_MobileJavascript' => array(
					'type'			=> 'text',
					'null'			=> FALSE,
					'default'		=> ''
					)
			
				));
			
			}
			
			if (!$this->db->field_exists('CO_CSS', 'content_'.$langcode)){
		
				$this->dbforge->add_column('content_'.$langcode, array(
					'CO_CSS' => array(
					'type'			=> 'text',
					'null'			=> FALSE,
					'default'		=> ''
					)
			
				));
			
			}
			
			if (!$this->db->field_exists('CO_MobileCSS', 'content_'.$langcode)){
		
				$this->dbforge->add_column('content_'.$langcode, array(
					'CO_MobileCSS' => array(
					'type'			=> 'text',
					'null'			=> FALSE,
					'default'		=> ''
					)
			
				));
			
			}
			

			if (!$this->db->field_exists('CO_MobileTemplate', 'content_'.$langcode)){
		
				$this->dbforge->add_column('content_'.$langcode, array(
					'CO_MobileTemplate' => array(
					'type'			=> 'varchar',
					'constraint'	=> 100,
					'null'			=> FALSE,
					'default'		=> ''
					)
			
				));
			
			}
			
			
		}
		
				
		
	}

	public function down()
	{

	}
}