<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version8_update extends CI_Migration
{
	public function up()
	{
	
		
		$lang_avail = $this->config->item('lang_avail');
		
		foreach($lang_avail AS $langcode=>$language){ 
	
			if (!$this->db->field_exists('hits', 'content_' . $langcode))
			{
				$this->dbforge->add_column('content_' . $langcode, array(
					'hits' => array(
						'type'			=> 'int',
						'constraint'	=> 11,
						'null'			=> FALSE,
						'default'		=> 0,
					)
				));
				
			} 
	
		
		}
		
		if(!$this->db->table_exists("sessions")){
		
			$sql = "
			CREATE TABLE IF NOT EXISTS  `{$dbprefix}sessions` (
			session_id varchar(40) DEFAULT '0' NOT NULL,
			ip_address varchar(45) DEFAULT '0' NOT NULL,
			user_agent varchar(120) NOT NULL,
			last_activity int(10) unsigned DEFAULT 0 NOT NULL,
			user_data text NOT NULL,
			prevent_update int(10) DEFAULT NULL,
			PRIMARY KEY (session_id),
			KEY `last_activity_idx` (`last_activity`)
			);
			";
			
			$this->db->query($sql);
			
		}
		
				
		
		if($this->db->table_exists("sessions")){
		
			// required for upgrading Codeigniter from 2.0.2 to 2.0.3
			//$this->db->query("CREATE INDEX last_activity_idx ON {$this->db->dbprefix}sessions(last_activity);");
			$this->db->query("ALTER TABLE {$this->db->dbprefix}sessions MODIFY user_agent VARCHAR(120);");
			
			// required for upgrading Codeigniter from 2.1.0 to 2.1.1
			$this->db->query("ALTER TABLE {$this->db->dbprefix}sessions CHANGE ip_address ip_address varchar(45) default '0' NOT NULL");
			
		}
		

		
	}

	public function down()
	{

		// not in use right now.
	}
}