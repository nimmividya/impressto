<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_remote extends PSBase_Controller {

	public $thumbmaxwidth = 200;
	public $thumbmaxheight = 200;
	
	public $resizedmaxwidth = 500;
	public $resizedmaxheight = 500;	
	
	
	public function __construct(){
		
		parent::__construct();
		
		
		$this->load->helper('auth');
		
		is_logged_in();
				
		$this->load->library('impressto');
		
		// probably good to load the config values here from widget_options table
		$this->thumbmaxwidth = 200;
		$this->thumbmaxheight = 200;
		$this->resizedmaxwidth = 500;
		$this->resizedmaxheight = 500;	
					
		
		//if(!$this->db->table_exists('image_galleries')) $this->install();
				
		$this->load->model('image_gallery_model');
	
		
	}
	
	/**
	* AJAX responder to allow management of categories
	*
	*/
	public function list_gallery_categories($gallery){
			
		$this->load->model('image_gallery_admin_model');
	
		$data['gallery_categories'] = $this->image_gallery_admin_model->get_gallery_categories($gallery);
							
		echo $this->load->view('/partials/categories_list', $data, TRUE);
		

	}
	
	
	
	/**
	* AJAX responder to change top the next image
	*
	*/
	public function list_gallery_items($gallery, $category = ''){
			
		$this->load->model('image_gallery_admin_model');
		
		$this->load->library('formelement');
		
		$data['galleryrecords'] = $this->image_gallery_admin_model->get_galleryitems($gallery, $category);
		
		$data['category_name'] = $this->image_gallery_admin_model->get_category_name($category);
		
		$data['category'] = $category;
		$data['gallery'] = $gallery;
		
		
			
		$fielddata = array(
		'name'        => "gallery_category_selector",
		'type'          => 'select',
		'id'          => "gallery_category_selector",
		'label'          => "Category",
		'onchange'          => "ps_imagegallerymanager.loadgalleryitemlist(this.value)",
		'options' =>  $this->image_gallery_admin_model->get_category_selector(),
		'value'       => $category
		);
				
		$data['category_selector'] = $this->formelement->generate($fielddata);
		
				
		$sql = "SELECT category_image FROM {$this->db->dbprefix}image_gallery_categories WHERE id='{$category}'";
		
		$query = $this->db->query($sql);
		
		if($query) $data['default_category_image'] = "need to fix"; //$query->row()->category_image; 
				
			
							
		echo $this->load->view('image_gallery_list', $data, TRUE);
		

	}
	
	/**
	*
	*
	*/
	public function upload_image(){
	
		global $_FILES;
		
		// this is not actually an AJAX call so we must turn the profiles off manually
		$this->config->set_item('debug_profiling',FALSE);
		$this->output->enable_profiler(FALSE);
		
		$gallery = $this->input->post('gallery');
		$category = $this->input->post('category');
		$resizeme =  $this->input->post('resizeme');

		
		$settings = $this->image_gallery_model->getGallerySettings($gallery);


		
		if(!isset($settings['resized_maxwidth'])) $settings['resized_maxwidth'] = 500;
		if(!isset($settings['resized_maxheight'])) $settings['resized_maxheight'] = 500;
		if(!isset($settings['thumb_maxwidth'])) $settings['thumb_maxwidth'] = 100;
		if(!isset($settings['thumb_maxheight'])) $settings['thumb_maxheight'] = 100;
				
		

		$settings['resized_maxwidth'] = intval($settings['resized_maxwidth']);
		$settings['resized_maxheight'] = intval($settings['resized_maxheight']);
		$settings['thumb_maxwidth'] = intval($settings['thumb_maxwidth']);
		$settings['thumb_maxheight'] = intval($settings['thumb_maxheight']);

		
		if( $settings['resized_maxwidth'] > 100  ) $this->resizedmaxwidth = $settings['resized_maxwidth'];
		if( $settings['resized_maxheight'] > 100  ) $this->resizedmaxheight = $settings['resized_maxheight'];
		if( $settings['thumb_maxwidth'] > 50  ) $this->thumbmaxwidth = $settings['thumb_maxwidth'];
		if( $settings['thumb_maxheight'] > 50  ) $this->thumbmaxheight = $settings['thumb_maxheight'];
				
		
		$error = "";
		
		$msg = "";
		

			
	$fileElementName = 'fileToUpload';
	
	if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error'])
		{

			case '1':
				$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case '2':
				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case '3':
				$error = 'The uploaded file was only partially uploaded';
				break;
			case '4':
				$error = 'No file was uploaded sucka!.';
				break;

			case '6':
				$error = 'Missing a temporary folder';
				break;
			case '7':
				$error = 'Failed to write file to disk';
				break;
			case '8':
				$error = 'File upload stopped by extension';
				break;
			case '999':
			default:
				$error = 'No error code avaiable';
		}
	}elseif(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none')
	{
		$error = 'No file was uploaded....';
	}else 
	{

	
			$this->load->library('file_tools');
				
			
			$image_path = ASSET_ROOT . "uploads/" . PROJECTNAME . "/image_gallery/{$gallery}/{$category}";
			$thumbnail_path = $image_path . "/thumbs";
			$original_path = $image_path . "/originals";
			
		
			$this->file_tools->create_dirpath($thumbnail_path);
			$this->file_tools->create_dirpath($original_path);
			
			
			$original_image_path = $original_path . "/" . $_FILES[$fileElementName]["name"];
						
			move_uploaded_file($_FILES[$fileElementName]["tmp_name"],$original_image_path);
			

			$this->load->library('img_resize',$original_image_path);
			
			

			if($resizeme == "true"){
			
			
				echo $this->resizedmaxwidth . ", " . $this->resizedmaxheight;
				
							
			
				// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
				$this->img_resize->resizeImage($this->resizedmaxwidth, $this->resizedmaxheight, 'auto');
				
				// *** 3) Save image
				$this->img_resize->saveImage($image_path . "/" . $_FILES[$fileElementName]["name"], 100);
				
			}else{
			
				
				// simply copy the file.
				copy($original_image_path, $image_path . "/" . $_FILES[$fileElementName]["name"]);
				
			}
			
			
			
			
			$this->img_resize->setimage($original_image_path);


			//$widget_settings['thumb_maxwidth']
			// $widget_settings['thumb_maxheight']
				 
			// now make the thumnbnail
			$this->img_resize->resizeImage($this->thumbmaxwidth, $this->thumbmaxheight, 'auto');
			
			// *** 3) Save image
			$this->img_resize->saveImage($thumbnail_path . "/" . $_FILES[$fileElementName]["name"] , 100);
					
			
			
 
	}

	//$error .= addslashes($sql);
	
	echo "{";
	echo				"error: '" . $error . "',\n";
	echo				"saved_image: '" . $_FILES[$fileElementName]["name"] . "'\n";
	echo "}";
	
	
	} //
	
	
	/**
	*
	*
	*/
	public function savecrop_dimensions(){
	
		$widget_settings = $this->image_gallery_model->get_widget_settings();
			

		$widget_settings['resized_maxwidth'] = intval($widget_settings['resized_maxwidth']);
		$widget_settings['resized_maxheight'] = intval($widget_settings['resized_maxheight']);
		$widget_settings['thumb_maxwidth'] = intval($widget_settings['thumb_maxwidth']);
		$widget_settings['thumb_maxheight'] = intval($widget_settings['thumb_maxheight']);

		
		if( $widget_settings['resized_maxwidth'] > 100  ) $this->resizedmaxwidth = $widget_settings['resized_maxwidth'];
		if( $widget_settings['resized_maxheight'] > 100  ) $this->resizedmaxheight = $widget_settings['resized_maxheight'];
		if( $widget_settings['thumb_maxwidth'] > 50  ) $this->thumbmaxwidth = $widget_settings['thumb_maxwidth'];
		if( $widget_settings['thumb_maxheight'] > 50  ) $this->thumbmaxheight = $widget_settings['thumb_maxheight'];
		

		
		$targ_w = $this->thumbmaxwidth;
		$targ_h = $this->thumbmaxheight;
		
		
		$jpeg_quality = 90;
		
		$crop_x = $this->input->post('x');
		$crop_y =  $this->input->post('y');
		
		
		$fn_extension = pathinfo($this->input->post('thumb_image_name'), PATHINFO_EXTENSION);
		
		
		$image_path = ASSET_ROOT . "uploads/" . PROJECTNAME . "/image_gallery/{$this->input->get('gallery')}/{$this->input->post('thumb_image_category')}";
				
				
		$src = $image_path . "/{$this->input->post('thumb_image_name')}";
		$target = $image_path . "/thumbs/{$this->input->post('thumb_image_name')}";
		

		if(strtolower($fn_extension) == "png"){
		
			$png_quality = 9;
			$img_r = imagecreatefrompng($src);
			$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
		
			imagecopyresampled($dst_r,$img_r,0,0,$crop_x,$crop_y,
			$targ_w,$targ_h,$this->input->post('w'),$this->input->post('h'));
		
			imagepng ($dst_r,$target,$png_quality);
	
		}else{
	
			$jpeg_quality = 90;
		
			$img_r = imagecreatefromjpeg($src);
			$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
		
			imagecopyresampled($dst_r,$img_r,0,0,$crop_x,$crop_y,
			$targ_w,$targ_h,$this->input->post('w'),$this->input->post('h'));

			imagejpeg($dst_r,$target,$jpeg_quality);
		
		}
	
		echo "done";
	}

	
	
	
	/**
	*
	*
	*/	
	public function edit_category($id){
	
	
		$sql = "SELECT * FROM {$this->db->dbprefix}image_gallery_categories WHERE id = '{$id}'";
	
		$query = $this->db->query($sql);
		
		$return_array = array();
		
		
		if ($query->num_rows() > 0){
			
			$row = $query->row();
			
			$return_array['id'] = $row->id;
			$return_array['name_en'] = $row->name;
			$return_array['name_fr'] = $row->name_fr;
	
			$return_array['category_image'] = "";
				
			$sql = "SELECT imagename FROM {$this->db->dbprefix}image_gallery_items WHERE id = '{$row->category_image}'";
	
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0){
			
				$return_array['category_image'] = $query->row()->imagename;
								
			} 
			
		
		}
		
	
		echo json_encode($return_array);
		
	
	}
	
	
	
	
	
	/**
	*
	*
	*/	
	public function edit_item($id){
	
	
		$sql = "SELECT * FROM {$this->db->dbprefix}image_gallery_items WHERE id = '{$id}'";
	
		$query = $this->db->query($sql);
		
		$return_array = array();
		
		
		if ($query->num_rows() > 0){
			
			$row = $query->row();
			
			$return_array['id'] = $row->id;
			$return_array['category'] = $row->category;
			$return_array['imagename'] = $row->imagename;
			$return_array['label'] = $row->label;
			$return_array['alttag'] = $row->alttag;
			$return_array['caption'] = $row->caption;	

			$sql = "SELECT category_image FROM {$this->db->dbprefix}image_gallery_categories WHERE id = '{$row->category}'";
	
			$return_array['is_category_image'] = ($this->db->query($sql)->row()->category_image == $row->id ? 1 : 0);

		
		}
		
	
		echo json_encode($return_array);
		
			
	
	}

	/**
	*
	*
	*/
	public function deletecategory($id){
			
		$this->db->delete('image_gallery_categories', array('id' => $id)); 
			
	
	}

	
	
	public function deleteitem($id){
	
		
		$sql = "SELECT category, imagename FROM {$this->db->dbprefix}image_gallery_items WHERE id = '{$id}'";
		
		$query = $this->db->query($sql);
			
		if ($query->num_rows() > 0){
			
			$row = $query->row();
	
			$gallery = $row->category;
			$category_id = $row->category;
			$imagename = $row->imagename;
			
		
			$image_path = ASSET_ROOT . "uploads/" . PROJECTNAME . "/image_gallery/{$gallery}/{$category_id}";
			$thumbnail_path = $image_path . "/thumbs";
			$original_path = $image_path . "/originals";
			
			
			$resized_image = $image_path . "/" . $row->imagename;
			$thumbnail_image = $thumbnail_path . "/" . $row->imagename;
			$original_image = $original_path . "/" . $row->imagename;
					
			
			if(file_exists($resized_image)) unlink($resized_image);
			if(file_exists($thumbnail_image)) unlink($thumbnail_image);
			if(file_exists($original_image)) unlink($original_image);	
			
			$sql = "DELETE FROM {$this->db->dbprefix}image_gallery_items WHERE id = '{$id}'";
			
			$query = $this->db->query($sql);

			
		}
		
	
	}
	
	
	/**
	*
	*
	*/
	public function saveimagedetails(){
	
		$id = $this->input->post('image_id');
	
		$gallery = $this->input->get_post('gallery');
	
		$category = $this->input->post('editor_category_selector');
		$image_name = $this->input->post('uploaded_image_name');
		$label = $this->input->post('image_label');
		$alttag = $this->input->post('image_alt');
		$caption = $this->input->post('image_caption');
		$is_default_category_image = $this->input->post('default_category_image') == 1 ? TRUE : FALSE;
				
		
		
		$data = array(
			'gallery' => $gallery,
			'category' => $category,
			'imagename' => $image_name ,
			'label' => $label ,
			'alttag' => $alttag ,
			'caption' => $caption 
			
		);

		if($id == ""){
		
		
			$this->db->insert('image_gallery_items', $data); 
								
			$id = $this->db->insert_id();
								
			$return_array = array( "action"=>"inserted","id"=>$id );
			

		
		}else{
		
			// get the old category id and if it is different, move the images
			$query = $this->db->get_where('image_gallery_items', array('id' => $id));
			
			if ($query->num_rows() > 0)
			{
				$old_category = $query->row()->category;
				$imagename = $query->row()->imagename;
				
				//$old_category  = $row->category;
				if($old_category != $category){
				
					$this->load->library("file_tools");
						
				
					$gallerypath = ASSET_ROOT . "uploads/" . PROJECTNAME . "/image_gallery/{$gallery}";
									
					// move the images to the new location
				
					$old_resized_file = "{$gallerypath}/{$old_category}/{$imagename}";				
					$old_original_file = "{$gallerypath}/{$old_category}/originals/{$imagename}";
					$old_thumb_file = "{$gallerypath}/{$old_category}/thumbs/{$imagename}";

					$new_resized_path = "{$gallerypath}/{$category}";		
					$new_original_path = "{$gallerypath}/{$category}/originals";
					$new_thumb_path = "{$gallerypath}/{$category}/thumbs";
					
					$this->file_tools->create_dirpath($new_resized_path);
					$this->file_tools->create_dirpath($new_original_path);
					$this->file_tools->create_dirpath($new_thumb_path);
	
					$new_resized_file = $new_resized_path . "/" . $imagename;
					$new_original_file = $new_original_path . "/" . $imagename;
					$new_thumb_file = $new_thumb_path . "/" . $imagename;
						

					if (copy($old_resized_file, $new_resized_file)) unlink($old_resized_file);
					if (copy($old_original_file, $new_original_file)) unlink($old_original_file);
					if (copy($old_thumb_file, $new_thumb_file)) unlink($old_thumb_file);
							
												

				}
			}
   	
			
		
			$this->db->where('id', $id);
			$this->db->update('image_gallery_items', $data); 

			$return_array = array("action"=>"updated","id"=>$id);
				
		
		}
	
		if($is_default_category_image){
		
			$data = array(
				'category_image' => $id,
			);
			
			$this->db->where('id', $category);
			$this->db->update('image_gallery_categories', $data); 

		
		}
		
		
		echo json_encode( $return_array  );
		
		
	

	}
	
	/**
	* Create a new gallery instance
	*
	*/
	public function savenewgallery(){
	
		
		$this->widget_utils->register_widget("image_gallery","image_gallery",$olddata['name'], $data['name']);
		
	
	}


	/**
	* destroy the galley instance, delete inages, generally wite the thing out
	*
	*/
	public function deleteGallery($id){
	
		$this->load->library('widget_utils');

		//$sql = "SELECT * FROM {$this->db->dbprefix('image_galleries')} WHERE id = '{$id}'"; 
		
		$query = $this->db->get_where('image_galleries', array('id' => $id));
		
		if ($query->num_rows() > 0)
		{
			$name = $row->name;

			// need a function here to wipe out all the images on the asset folder too. later...
		
			$this->db->delete('image_galleries', array('id' => $id)); 
			$this->db->delete('image_gallery_items', array('gallery' => $id)); 
			$this->db->delete('image_gallery_categories', array('gallery' => $id)); 
			
			$this->widget_utils->un_register_widget("image_gallery","image_gallery",$row->name);
			
			echo "ok";
		
		
		} 


		
	
		

	}	
	
	
	/**
	* creates a new gallery widget instance
	*
	*/
	public function saveGallery(){
	
		$this->load->library('widget_utils');
		$this->load->model('image_gallery_admin_model');
			
		$data = array();
		
		$data['name'] = $this->input->post('name');
		$data['description'] = $this->input->post('description');
		$data['template'] = $this->input->post('template');
		$return_array = array("error"=>"");
		
		
		// check to see if this widget name already exists. If so return an error,
		if($this->widget_utils->getwidgetid("image_gallery","image_gallery",$data['name'])){
			
			$return_array['error'] = "already exists";

		}else{
		
			$this->db->insert('image_galleries', $data);

			// add a defualt category for this gallery
			
			$catdata = array(
				"gallery" => $this->db->insert_id(),
				"name" => "default",
			);
			
			$this->db->insert('image_gallery_categories', $catdata);
	

			// register it to the system
			$this->widget_utils->register_widget("image_gallery","image_gallery",$data['name']);
			
			//$return_array['gallerylist'] = $this->image_gallery_admin_model->get_galleries();
				
		}
			
		
		echo json_encode($return_array);
		
	
	}
	
	
	public function galleryList(){

		$this->load->model('image_gallery_admin_model');
		
		echo json_encode($this->image_gallery_admin_model->get_galleries());
		
	}
	
	/**
	*
	*
	*/

	public function savecategory(){
	

		$id = $this->input->get_post('edit_category_id');
				
		$category_name_en = $this->input->get_post('edit_category_name_en');
		$category_name_fr = $this->input->get_post('edit_category_name_fr');
		
		$data = array(
		
			'name' => $category_name_en,
			'name_fr' => $category_name_fr,
						
		);
		
		$this->db->where('id', $id);
		$this->db->update('image_gallery_categories', $data);
		
				
	}

	
	
	public function savenewcategory(){
	
	
		$gallery = $this->input->get_post('gallery');
	
		$new_category = $this->input->get_post('new_category');
		
		$new_category =  trim($new_category);

		
		// check to see if it exists. if so, return the id and name
		
		$maxpos = 0;
		
		$sql = "SELECT MAX(position) AS maxpos FROM {$this->db->dbprefix}image_gallery_categories WHERE gallery = '{$gallery}'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
	 		$row = $query->row();
			$maxpos = ($row->maxpos + 1);
		}
			
		$sql = "SELECT * FROM {$this->db->dbprefix}image_gallery_categories WHERE name = '{$new_category}' AND gallery = '{$gallery}'";
		$query = $this->db->query($sql);
	
		if ($query->num_rows() == 0) {

			$sql = "INSERT INTO {$this->db->dbprefix}image_gallery_categories (name,gallery,position) VALUES (";
			$sql .= "'{$new_category}',";
			$sql .= "'{$gallery}',";
			$sql .= "'{$maxpos}'";
			$sql .= ")";
			
			$this->db->query($sql);
			
			$returnarray = array("id"=>$this->db->insert_ID(),"category"=>$new_category);
						
			
		
		}else{
			
			$row = $query->row();
						
			$returnarray = array("id"=>intval($row->id),"category"=>$row->name);
			
		}
		
		
		echo json_encode($returnarray);
		
	
		
	}
	
	
	/**
	* AJAX responder for sortable calls 
	*
	*/	
	public function reposition_categories(){
	
	
		$ids = $this->input->post('ids');
		
		//print_r($ids);
		
		$i = 0;
		
		foreach($ids AS $id){
		
			$sql = "UPDATE {$this->db->dbprefix}image_gallery_categories SET position = '{$i}' WHERE id='{$id}'";
			$this->db->query($sql);
						
			$i ++;
			
		
		}
	
	
	
	}
	
	
	
	
	/**
	* 
	*
	*/	
	public function move_category_position(){
	
		$direction  = $this->input->get_post("direction");
		
		$id  = $this->input->get_post("id");
		
		
		// fill in all the gaps first.
		$sql = "SELECT id FROM {$this->db->dbprefix}image_gallery_categories ORDER BY position";
		
		$query = $this->db->query($sql);
		
		$position = 0;
		$positions_array = array();
		$target_position = 0;
		
		foreach ($query->result() as $row)
		{
			
			$sql = "UPDATE {$this->db->dbprefix}image_gallery_categories SET position = '{$position}' WHERE  id = '{$row->id}'";
			$this->db->query($sql);
			
			$positions_array['item_' . $position] = $row->id;
			
			if($row->id == $id) $target_position = $position;		
			
			$position ++;
			
		}

		
		if($direction == "up"){
			
			$sql = "UPDATE {$this->db->dbprefix}image_gallery_categories SET position = (position -1) WHERE  id = '" . $positions_array['item_' . $target_position] . "'";
			$this->db->query($sql);
			$sql = "UPDATE {$this->db->dbprefix}image_gallery_categories SET position = (position +1) WHERE  id = '" . $positions_array['item_' . ($target_position - 1)] . "'";
			$this->db->query($sql);	
		}
		
		
		if($direction == "down"){
			
			$sql = "UPDATE {$this->db->dbprefix}image_gallery_categories SET position = (position +1) WHERE  id = '" . $positions_array['item_' . $target_position] . "'";
			$this->db->query($sql);
			$sql = "UPDATE {$this->db->dbprefix}image_gallery_categories SET position = (position -1) WHERE  id = '" . $positions_array['item_' . ($target_position + 1)] . "'";
			$this->db->query($sql);	
			
		}
		
		
	
	}

	/**
	* AJAX responder for sortable calls 
	*
	*/	
	public function reposition_images(){
	
	
		$ids = $this->input->post('ids');
		
		
		$i = 0;
		
		foreach($ids AS $id){
		
			$sql = "UPDATE {$this->db->dbprefix('image_gallery_items')} SET position = '{$i}' WHERE id='{$id}'";
			$this->db->query($sql);
						
			$i ++;
			
		
		}
	
	
	
	}
	
	
	
	/**
	* 
	*
	*/	
	public function move_position(){
		
		$direction  = $this->input->get_post("direction");
		
		$gallery  = $this->input->get_post("gallery");
		$category  = $this->input->get_post("category");
		$id  = $this->input->get_post("id");
		
		
		// fill in all the gaps first.
		$sql = "SELECT id FROM {$this->db->dbprefix}image_gallery_items WHERE gallery = '{$gallery}' AND category = '{$category}' ORDER BY position";
		$query = $this->db->query($sql);
		

		
		
		$position = 0;
		$positions_array = array();
		$target_position = 0;
		
		foreach ($query->result() as $row)
		{
			
			$sql = "UPDATE {$this->db->dbprefix}image_gallery_items SET position = '{$position}' WHERE  id = '{$row->id}'";
			$this->db->query($sql);
			
			//echo $sql . "<br />";
					
			
			$positions_array['item_' . $position] = $row->id;
			
			if($row->id == $id) $target_position = $position;		
			
			$position ++;
			
		}
		
		
		
		if($direction == "up"){
			
			$sql = "UPDATE {$this->db->dbprefix}image_gallery_items SET position = (position -1) WHERE  id = '" . $positions_array['item_' . $target_position] . "'";
			$this->db->query($sql);
			$sql = "UPDATE {$this->db->dbprefix}image_gallery_items SET position = (position +1) WHERE  id = '" . $positions_array['item_' . ($target_position - 1)] . "'";
			$this->db->query($sql);	
		}
		
		if($direction == "down"){
			
			$sql = "UPDATE {$this->db->dbprefix}image_gallery_items SET position = (position +1) WHERE  id = '" . $positions_array['item_' . $target_position] . "'";
			$this->db->query($sql);
			$sql = "UPDATE {$this->db->dbprefix}image_gallery_items SET position = (position -1) WHERE  id = '" . $positions_array['item_' . ($target_position + 1)] . "'";
			$this->db->query($sql);	
			
		}
		
		
		
		
		
	}
	

	
	
	
	/**
	* Ajax responder 
	*
	*/
	public function getgallerysettings($gallery){
	
		// set defaults
		echo json_encode($this->image_gallery_model->getGallerySettings($gallery));
	
	}
	
	
	/**
	* Ajax resonder
	*/
	public function savegallerysettings($gallery){
	
	
		$thumb_maxwidth = $this->input->post('thumb_maxwidth_input');
		$thumb_maxheight = $this->input->post('thumb_maxheight_input');
		$resized_maxwidth = $this->input->post('resized_maxwidth_input');
		$resized_maxheight = $this->input->post('resized_maxheight_input');

		$template = $this->input->post('template_selector');
	
	
		$this->db->delete('image_gallery_settings', array('gallery' => $gallery)); 
		
		

		$insertdata = array("gallery" => $gallery);
		
		
		$insertdata["name"] = "thumb_maxwidth";
		$insertdata["val"] = $thumb_maxwidth;
		$this->db->insert('image_gallery_settings', $insertdata); 

		$insertdata["name"] = "thumb_maxheight";
		$insertdata["val"] = $thumb_maxheight;
		$this->db->insert('image_gallery_settings', $insertdata); 

		
		$insertdata["name"] = "resized_maxwidth";
		$insertdata["val"] = $resized_maxwidth;
		$this->db->insert('image_gallery_settings', $insertdata); 

		
		$insertdata["name"] = "resized_maxheight";
		$insertdata["val"] = $resized_maxheight;
		$this->db->insert('image_gallery_settings', $insertdata); 

		$insertdata["name"] = "template";
		$insertdata["val"] = $template;
		$this->db->insert('image_gallery_settings', $insertdata); 	
		
		echo "ok";
		
	}
	
	
	
	private function init_impressto(){
	
		//$this->load->library('impressto');
		//$this->impressto->setDir(APPPATH . "/custom_modules/image_gallery/views/ps_templates/");
		
		$this->load->library('impressto');
		
		$projectnum = $this->config->item('projectnum');
			   	
		$template_path = dirname(dirname(__FILE__)) . "/widgets/views/ps_templates/";

		$this->impressto->setDir($template_path);
		
	
	}
	
	
	



} //end class