<?php

class image_slider_model extends My_Model{


	private $tablename;
	private $settings_table;
	

	public function __construct(){
		
		$this->tablename = $this->db->dbprefix . "image_slider";
		$this->settings_table = $this->db->dbprefix . "image_slider_settings";
		
		
	}
	
	
	/**
* 
*
*/
	function getDistinctWidgetNames(){

		$sql = "SELECT DISTINCT widget_name FROM {$this->tablename}";
		
		$result = mysql_query($sql);
		
		$widget_names = array();
		
		
		while($row = mysql_fetch_assoc($result)){
			
			$widget_names[] = $row['widget_name'];
			
		}
		
		return $widget_names;
		

	}///////////





	/**
* insert a new set of widget rows into the table
*
*/
	function createnewwidget($widget_name){

		$sql = "SELECT * FROM {$this->tablename} WHERE widget_name = '{$widget_name}'";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() == 0){
			
			$position = 0;
			
			$sql = "INSERT INTO {$this->tablename} (title_en, caption_en, caption_fr, widget_name, slide_img, position) values ('slide_1','','','{$widget_name}','','0');";
			$this->db->query($sql);
			
			$sql = "INSERT INTO {$this->settings_table} ";
			$sql .= "(widget_name, effect, speed, pausetime, pauseonhover, textsize) ";
			$sql .= " VALUES ";
			$sql .= "('{$widget_name}', 'fade', '500', '5000', 'true', 14);";
					
			$this->db->query($sql);
	

		}
		
	}



	/**
* 
*
*/
	function getslideshow_settings($widget_name){

		$return_array = array();
		
		$return_array['effect'] = "fade";
		$return_array['speed'] = "500";
		$return_array['pausetime'] = "5000";
		$return_array['pauseonhover'] = "true";
		$return_array['textsize'] = "14";

			
		$sql = "SELECT * FROM {$this->settings_table} WHERE widget_name = '{$widget_name}'";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			$row = $query->row();
			
			$return_array['effect'] = $row->effect;
			$return_array['speed'] = $row->speed;
			$return_array['pausetime'] = $row->pausetime;
			$return_array['pauseonhover'] = $row->pauseonhover;
			$return_array['textsize'] = $row->textsize;
			
				
		}
		
		return $return_array;
				
	} 

			

	

	/**
* delete record
*
*/
	function delete_item($id){

		$sql = "DELETE FROM {$this->tablename} WHERE id = '{$id}'";
		
		$this->db->query($sql);
		
		echo "deleted";
		
	}

	/**
*
*
*/
	public function geteditdata($id = '', $widget_name = ''){

		$sql = "SELECT * FROM {$this->tablename} WHERE id = '{$id}'";
		
		$result = mysql_query($sql);
		
		while($row = mysql_fetch_assoc($result)){
			
			if($row['widget_name'] != "") $widget_name = $row['widget_name'];
			
			$data = array(
			
			'id'=>$row['id'],
			'widget_name'=>$widget_name,
			'title_en'=>$row['title_en'],
			'title_fr'=>$row['title_fr'],
			'caption_en'=>$row['caption_en'],
			'caption_fr'=>$row['caption_fr'],
			'url_en'=>$row['url_en'],
			'url_fr'=>$row['url_fr'],
			'slide_img'=>$row['slide_img']
			
			);
			
		}
		
		return $data;
		
	}


	/**
*
*
*/
	public function save($data){


		$dbdata = array(
		
			"widget_name" => $data['widget_name'],
			"title_en" => $data['title_en'],
			"title_fr" => $data['title_fr'],
			"caption_en" => $data['caption_en'],
			"caption_fr" => $data['caption_fr'],
			"url_en" => $data['url_en'],
			"url_fr" => $data['url_fr'],	
		
		);
					
		if($data['slide_img'] != "") $dbdata["slide_img"] = $data['slide_img'];
		
		
			
		
		if($data['id'] == ''){
			
			$maxpos = 0;
			
			$sql = "SELECT MAX(position) AS maxpos FROM {$this->tablename} WHERE widget_name = '{$data['widget_name']}'";
			$query = $this->db->query($sql);
			
			if ($query->num_rows() == 1) {
				$row = $query->row();
				$maxpos = ($row->maxpos + 1);
			}
			
			$dbdata["position"] = $maxpos;
			
			$this->db->insert($this->tablename,$dbdata);
			
			
		}else{
			
		
			$this->db->where("id",$data['id']);
			$this->db->update($this->tablename,$dbdata);
				
			
		}
		
		
		
	}

	public function moveitem($direction, $id){

		// fill in all the gaps first.
		$sql = "SELECT id FROM {$this->tablename} WHERE widget_name = (SELECT widget_name FROM {$this->tablename} WHERE id='{$id}') ORDER BY position";
		$query = $this->db->query($sql);
		
		$position = 0;
		$positions_array = array();
		$target_position = 0;
		
		foreach ($query->result() as $row)
		{
			
			$sql = "UPDATE {$this->tablename} SET position = '{$position}' WHERE  id = '{$row->id}'";
			$this->db->query($sql);
			
			$positions_array['item_' . $position] = $row->id;
			
			if($row->id == $id) $target_position = $position;		
			
			$position ++;
			
		}
		
		
		
		if($direction == "up"){
			
			$sql = "UPDATE {$this->tablename} SET position = (position -1) WHERE  id = '" . $positions_array['item_' . $target_position] . "'";
			$this->db->query($sql);
			$sql = "UPDATE {$this->tablename} SET position = (position +1) WHERE  id = '" . $positions_array['item_' . ($target_position - 1)] . "'";
			$this->db->query($sql);	
		}
		
		if($direction == "down"){
			
			$sql = "UPDATE {$this->tablename} SET position = (position +1) WHERE  id = '" . $positions_array['item_' . $target_position] . "'";
			$this->db->query($sql);
			$sql = "UPDATE {$this->tablename} SET position = (position -1) WHERE  id = '" . $positions_array['item_' . ($target_position + 1)] . "'";
			$this->db->query($sql);	
			
		}


	}


	public function reloadlist($widget_name){

		$sql = "SELECT * FROM {$this->tablename} WHERE widget_name = '{$widget_name}' ORDER BY position";
		
		return mysql_query($sql);
		

	}



	public function get_public_slidelist($widget_name, $lang = 'en'){
					
		$returnarray = array();
		
		$sql = "SELECT * FROM {$this->tablename} WHERE widget_name = '{$widget_name}' AND active_{$lang} = '1' ORDER BY position";
		
		//echo $sql;
		
		$query = $this->db->query($sql);

		foreach ($query->result_array() as $row)
		{
			
			$data = array();
			
			$data['id'] = $row['id'];
			$data['title'] = $row['title_' . $lang];
			$data['caption'] = $row['caption_' . $lang];
			$data['url'] = $row['url_' . $lang];
			$data['slide_img'] = $row['slide_img'];
			$data['widget_name'] = $row['widget_name'];
			
			$returnarray[] = $data;
			
			
		}
		

	
		return $returnarray;
		

	}
	
	

	public function getslidelist($widget_name){
				
		$returnarray = array();
		
		$sql = "SELECT * FROM {$this->tablename} WHERE widget_name = '{$widget_name}' ORDER BY position";
		
		$query = $this->db->query($sql);
		
		
		foreach ($query->result() as $row)
		{
			
			$data = array();
			
			$data['id'] = $row->id;
			$data['title_en'] = $row->title_en;
			$data['title_fr'] = $row->title_fr;
			$data['caption_en'] = $row->caption_en;
			$data['caption_fr'] = $row->caption_fr;
			$data['url_en'] = $row->url_en;
			$data['url_fr'] = $row->url_fr;			
			$data['slide_img'] = $row->slide_img;
			$data['widget_name'] = $widget_name;
			
			$returnarray[] = $data;
			
			
		}
		
	
		return $returnarray;
		

	}




} //end class