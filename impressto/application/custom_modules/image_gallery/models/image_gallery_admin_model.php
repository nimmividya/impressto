<?php

class image_gallery_admin_model extends image_gallery_model{



	/**
	*
	*
	*/
	public function get_galleries(){
				
		$records_array = array();
		
		$sql = "SELECT * FROM {$this->db->dbprefix('image_galleries')} ORDER BY name ASC ";
		
		$query = $this->db->query($sql);
		
		//$return_array = array("Select"=>"");
		
		foreach ($query->result() as $row)
		{
		
			// at some point we will want to add the number of images to this return.
			$records_array[] = array("id"=>$row->id,"name"=>$row->name,"description"=>$row->description,"template"=>$row->template);	
		
			
		}


		return $records_array;
		
	
	}
	

	/**
	*
	*
	*/
	public function get_galleryitems($gallery, $category = ''){
		
		
		$records_array = array();
		
		$sql = "SELECT * FROM {$this->db->dbprefix('image_gallery_items')} WHERE gallery = '{$gallery}'";
		
		if($category != "") $sql .= "AND category = '{$category}' ";
				
		$sql .= "ORDER BY position ASC ";
		
		
		$query = $this->db->query($sql);
		
		$return_array = array("Select"=>"");
		
		foreach ($query->result() as $row)
		{
		
			$records_array['item_' . $row->id] = array("imagename"=>$row->imagename,"caption"=>$row->caption,"label"=>$row->label,"alttag"=>$row->alttag, "category"=>$row->category);	
			
			
		}

		return $records_array;
		
	
	}
	
	/**
	* Get list of categories
	*
	*/
	
	public function get_gallery_categories($gallery){
	
		$return_array = array();
			
		$this->db->order_by("position", "asc"); 
		$this->db->where("gallery", $gallery); 
		$query = $this->db->get('image_gallery_categories');
		
		
		if ($query->num_rows() > 0){
			
			foreach ($query->result() as $row){
			
				$rowarray = array(
				
					'id' => $row->id,
					'category_image' => $row->category_image,
					'name_en' => $row->name,
					'name_fr' => $row->name_fr,
			
				);
				
				$this->db->where("category", $row->id); 
				$num_images = $this->db->get('image_gallery_items')->num_rows();
						
				$rowarray['num_images'] = $num_images;

				$return_array["cat_" . $row->id] = $rowarray;
				
	
			}
		}
		
		return $return_array;
		
		
	}
	
	
	
	
	
	/**
	*  this overrides the parent version
	*
	*/
	function get_category_selector(){

		$sql = "SELECT * FROM {$this->db->dbprefix('image_gallery_categories')} ORDER BY position ASC";
		
		$query = $this->db->query($sql);
		
		$return_array = array("Select"=>"");
		
		foreach ($query->result() as $row)
		{
			
			$return_array[$row->name] = $row->id;
			
		}
		
		return $return_array;
		

	}///////////
	





} //end class