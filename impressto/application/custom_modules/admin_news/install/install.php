<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	$sql  = "SHOW COLUMNS FROM {$this->db->dbprefix}news";
	
	$query = $this->db->query($sql);
	
	$table_fields = array();
	

	foreach ($query->result_array() as $row){
	
		$table_fields[] = $row['Field'];
					
	}
	
	$lang_avail = $this->config->item('lang_avail');
	
	
	foreach($lang_avail AS $langcode=>$language){ 
	

		if(!in_array("newstitle_" . $langcode, $table_fields)){
				
			$this->dbforge->add_column('news', array(

				'newstitle_' . $langcode => array('type'=>'text') 
				
			));
			
			$this->dbforge->add_column('news', array(

				'newsshortdescription_' . $langcode => array('type'=>'text') 
				
			));
			
			$this->dbforge->add_column('news', array(

				'newscontent_' . $langcode => array('type'=>'text') 
				
			));
			
			$this->dbforge->add_column('news', array(

				'newslink_' . $langcode => array('type'=>'VARCHAR', 'constraint' => '255', 'default' => '') 
				
			));
			
			
		}
	
	}
	
	