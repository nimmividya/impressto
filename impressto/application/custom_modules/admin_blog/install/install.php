<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	$sql  = "SHOW COLUMNS FROM {$this->db->dbprefix}blog";
	
	$query = $this->db->query($sql);
	
	$table_fields = array();
	

	foreach ($query->result_array() as $row){
	
		$table_fields[] = $row['Field'];
					
	}
	
	$lang_avail = $this->config->item('lang_avail');
	
	
	foreach($lang_avail AS $langcode=>$language){ 
	

		if(!in_array("blogtitle_" . $langcode, $table_fields)){
				
			$this->dbforge->add_column('blog', array(

				'blogtitle_' . $langcode => array('type'=>'text') 
				
			));
			
			$this->dbforge->add_column('blog', array(

				'author_' . $langcode => array('type'=>'VARCHAR', 'constraint' => '255', 'default' => '') 
				
			));
			
			$this->dbforge->add_column('blog', array(

				'publish_date_' . $langcode => array('type'=>'VARCHAR', 'constraint' => '10', 'default' => '') 
				
			));
			
			
			$this->dbforge->add_column('blog', array(

				'blogshortdescription_' . $langcode => array('type'=>'text') 
				
			));
			
			$this->dbforge->add_column('blog', array(

				'blogcontent_' . $langcode => array('type'=>'text') 
				
			));

			
			$this->dbforge->add_column('blog', array(

				'bloglink_' . $langcode => array('type'=>'VARCHAR', 'constraint' => '255', 'default' => '') 
				
			));
			
			
			$this->dbforge->add_column('blog', array(

				'featured_image_' . $langcode => array('type'=>'VARCHAR', 'constraint' => '255', 'default' => '') 
				
			));
			
			
		}
	
	}
	
