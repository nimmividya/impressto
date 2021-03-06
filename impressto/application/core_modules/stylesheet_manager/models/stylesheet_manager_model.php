<?php

class stylesheet_manager_model extends CI_Model{


		

/**
* return infpo for the edit fields
* 
*/
function getmodules(){


	$default_array = array();
	
	// these will need to come from the registry late on
	// and also we need to filte ronly those /assets/... folders that
	// have a css subdir
	// this code can be shared with the module manager
	
	$this->load->helper('im_helper');
	
	$modules = get_modules();
		
	$default_array['Select'] = "";
	$default_array['Public'] = "public";
	
	$foundmodules = array();
	
	foreach($modules as $mod_dirname => $moddata){
	
		
		$foundmodules[strtolower($moddata['name'])] = $mod_dirname;
					
		
	}
	
	ksort($foundmodules);
	
	//array_
	return array_merge($default_array, $foundmodules);
	

}


/**
* 
*
*/
function get_category_selector(){

	$sql = "SELECT * FROM {$this->db->dbprefix}image_gallery_categories ORDER BY position ASC";
				
	$query = $this->db->query($sql);
	
	$return_array = array();
	
	foreach ($query->result() as $row)
	{
		
		$return_array['id_' . $row->id] = $row->name;
	
	}
		
	return $return_array;
	

}///////////



/**
* 
*
*/
public function get_widget_id(){

	$sql = "SELECT widget_id FROM {$this->db->dbprefix}widgets WHERE module = 'image_gallery' AND widget = 'image_gallery' AND instance = '' ";
			
	$query = $this->db->query($sql);
	
	$widget_id = false;
		
	if ($query->num_rows() > 0){
			
		$row = $query->row();
		$widget_id = $row->widget_id;
		
	}
	
	return $widget_id;
			
	

}///////////


/**
*
*
*/
public function get_widget_settings(){

		
	$return_array = array();
	
	$widget_id = $this->get_widget_id();
	
	
	$sql = "SELECT * FROM {$this->db->dbprefix}widget_options WHERE widget_id = '{$widget_id}'";
			
	$query = $this->db->query($sql);

	
	foreach ($query->result() as $row)
	{
		
		$return_array[$row->name] = $row->value;
	
	}
		
	return $return_array;
	
}







/**
*
*
*/
public function get_category_images($category){

	$sql = "SELECT * FROM {$this->db->dbprefix}image_gallery WHERE category = '{$category}' ORDER BY position ASC";
		
	$query = $this->db->query($sql);
	
	$return_array = array();
	
	foreach ($query->result() as $row)
	{
		
		$return_array['id_' . $row->id] = array("imagename"=>$row->imagename,"caption"=>$row->caption);
	
	}

	return $return_array;

}



/**
*
*
*/
public function get_category_name($category_id){

	$sql = "SELECT name FROM {$this->db->dbprefix}image_gallery_categories WHERE id = '{$category_id}'";
		
	$query = $this->db->query($sql);
	
	$return_array = array();
	
	foreach ($query->result() as $row)
	{
		
		return $row->name;
	
	}
	
	return "";
	
}



function doajaxfileupload(){
			
	global $_FILES, $thumbwidthheight;
	
	// this is not actually an AJAX call so we must turn the profiles off manually
	$this->config->set_item('debug_profiling',FALSE);
	$this->output->enable_profiler(FALSE);
		
				
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
				$error = 'No file was uploaded.';
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
	}elseif(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
	{
		$error = 'No file was uploaded..';
	}else 
	{
			$msg .= " File Name: " . $_FILES['fileToUpload']['name'] . ", ";
			$msg .= " File Size: " . @filesize($_FILES['fileToUpload']['tmp_name']);
			//for security reason, we force to remove all uploaded file
			//@unlink($_FILES['fileToUpload']);	
			move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],"./images/" . $_FILES["fileToUpload"]["name"]);
			
	
			// now resize this thing
			// *** Include the class
			include($_SERVER['DOCUMENT_ROOT'] . "/application/libraries/img_resize.php");
			
			// *** 1) Initialise / load image
			$resizeObj = new img_resize("./images/" . $_FILES["fileToUpload"]["name"]);
			
			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj -> resizeImage($thumbwidthheight, $thumbwidthheight, 'crop');
			
			// *** 3) Save image
			$resizeObj -> saveImage("images/thumbs/" . $_FILES["fileToUpload"]["name"], 100);

			
						
 
	}		
	echo "{";
	echo				"error: '" . $error . "',\n";
	echo				"msg: '" . $msg . "',\n";
	echo				"thumbname: '" . $_FILES["fileToUpload"]["name"] . "'\n";
	
	echo "}";


}




/**
* insert a new set of widget rows into the table
*
*/
function createnewwidget($widget_name){

		$sql = "SELECT * FROM {$this->tablename} WHERE widget_name = '{$widget_name}'";
					
		$query = $this->db->query($sql);
	
		if ($query->num_rows() == 0){
		
			$position = 0;
				
			//for($i=0; $i < 1; $i++){
				$sql = "INSERT INTO {$this->tablename} (title, widget_name, slide_img, position) values ('slide_1','{$widget_name}','','0');";
				//echo $sql;
				$this->db->query($sql);
				
			//	$position ++;
			//}
		}
						
	


}





/**
* save this record to the database
*
*/
function return_save(){

	$sql = "UPDATE {$this->tablename} SET ";
	
	$sql .= "title = '{$_POST['s_title']}',";
	$sql .= "content = '" . addslashes($_POST['s_content']) . "',";
	$sql .= "leftpos = '{$_POST['s_leftpos']}'";
	
	$sql .= " WHERE id = '{$_GET['id']}'";
			
	mysql_query($sql);
	
	echo "saved";
	
	

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

function geteditdata($id = '', $widget_name = ''){

	$sql = "SELECT * FROM {$this->tablename} WHERE id = '{$id}'";
			
	$result = mysql_query($sql);
	
	while($row = mysql_fetch_assoc($result)){
	
		if($row['widget_name'] != "") $widget_name = $row['widget_name'];
			
		$data = array(
				
			'id'=>$row['id'],
			'title'=>$row['title'],
			'widget_name'=>$widget_name,
			'slide_img'=>$row['slide_img']
				
		);
		
	}
	
	return $data;
	
}


public function save($data){


	
	
	if($data['id'] == ''){
	
		$maxpos = 0;
	
		$sql = "SELECT MAX(position) AS maxpos FROM {$this->tablename} WHERE widget_name = '{$data['widget_name']}'";
		$query = $this->db->query($sql);
	
		if ($query->num_rows() == 1) {
	 		$row = $query->row();
			$maxpos = ($row->maxpos + 1);
		}
		
		$sql = "INSERT INTO {$this->tablename} (widget_name,title,slide_img,position) VALUES (";
		$sql .= "'{$data['widget_name']}',";
		$sql .= "'{$data['title']}',";
		$sql .= "'{$data['slide_img']}',";
		$sql .= "'{$maxpos}'";
		$sql .= ")";
		
	
	}else{
	
		$sql = "UPDATE {$this->tablename} SET ";
		$sql .= "widget_name = '{$data['widget_name']}'";
		$sql .= ",title = '{$data['title']}'";
		
		if($data['slide_img'] != "") $sql .= ",slide_img = '" . $data['slide_img'] . "'";
		
		$sql .= " WHERE id = '{$data['id']}'";
			
	}
	
	$this->db->query($sql);
	
	
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



public function getslidelist($widget_name){

	//$this->impressto->setDir(APPPATH . "/core_modules/image_slider/templates");

	//$outbuf = "";
		
	//$outbuf .=  $this->impressto->showpartial("nivo_slider.tpl.html",'HEAD');
	
	$returnarray = array();
	
	$sql = "SELECT * FROM {$this->tablename} WHERE widget_name = '{$widget_name}' ORDER BY position";
	
	$query = $this->db->query($sql);
	
	
	foreach ($query->result() as $row)
	{
		
		$data = array();
			
		$data['id'] = $row->id;
		$data['title'] = $row->title;
		$data['slide_img'] = $row->slide_img;
		$data['widget_name'] = $widget_name;
		
		$returnarray[] = $data;
		

		//$outbuf .= $this->impressto->showpartial("nivo_slider.tpl.html",'ITEM',$data)
		
		
	}
	

	
	//$outbuf .=  $this->impressto->showpartial("nivo_slider.tpl.html",'FOOT');
	
	return $returnarray;
		

}



////////////////////////////////////////////////
// ADMIN SECTIONS

public function admin_get_galleryitems(){




}






} //end class