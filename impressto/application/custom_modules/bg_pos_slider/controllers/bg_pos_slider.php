<?php

class bg_pos_slider extends PSAdmin_Controller {

	private $bgslider_table;
	

	public function __construct(){
		
		parent::__construct();
		
		
		$this->load->helper('auth');
		$this->load->library('impressto');
				
		is_logged_in();
		
		if(!$this->db->table_exists('ps_bgslider')) $this->install();
				
		$this->load->model('bgposslider');
		
		$this->bgslider_table = $this->db->dbprefix . "bgslider";
			
	
		
	}
	
	/**
	* default management page
	*
	*/
	public function index($param = ''){
		
		
		$this->load->helper('im_helper');
		$this->load->library('asset_loader');
		$this->load->library('widget_utils');
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/bg_pos_slider/js/bgp_manager.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/bg_pos_slider/js/popup.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/vendor/jquery/jHtmlArea/jHtmlArea-0.7.0.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/vendor/jquery/jHtmlArea/jHtmlArea.ColorPickerMenu-0.7.0.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/ajaxfileuploader/ajaxfileupload.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/jcrop/jquery.Jcrop.js");
		
		$this->asset_loader->add_header_css("core/css/jquery/jcrop/jquery.Jcrop.css");
		$this->asset_loader->add_header_css("core/css/jquery/jHtmlArea/jHtmlArea.css");
		$this->asset_loader->add_header_css("core/css/jquery/jHtmlArea/jHtmlArea.ColorPickerMenu.css");
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/custom_modules/bg_pos_slider/css/bgs_manager.css");
									
		
		$widget_name = "";
					
		
		if(isset($param) && strpos($param, "::") !== false){
		
			list($param_name,$param_val) = explode("::",$param);
			
			if($param_name == "widget"){
				$widget_name = $param_val;
			}
					
		}

		$widget_id = $this->widget_utils->getwidgetid('bg_widget', 'bg_pos_slider', $widget_name);
			
		// little fix up for legacy shit
		if($widget_name != ""){
		
					
			if($widget_id == ""){
			
				// fist thing is to create the widget instance
				$widget_id = $this->widget_utils->register_widget('bg_widget', 'bg_pos_slider', $widget_name);
			}
			
			// update the name in case it was changed
			$sql = "UPDATE {$this->db->dbprefix}widgets SET instance = '{$widget_name}' WHERE widget_id = '{$widget_id}'";
			$this->db->query($sql);
			
		}
	
		
		
		$data['widget_selector'] = $this->widget_selector($widget_name);
		
		$data['widget_name'] = $widget_name;
		
		if($widget_id != ""){
		
			$data['widget_options'] = $this->widget_utils->get_widget_options($widget_id);
			
		}
		
		$data['prev_page'] = isset($data['widget_options']['prev_page']) ? $data['widget_options']['prev_page'] : "";
		$data['next_page'] = isset($data['widget_options']['next_page']) ? $data['widget_options']['next_page'] : "";
		
		$data['widget_id'] = $widget_id;
		
		
		$data['datarows'] = $this->reloadlist($widget_name);
		

		
		$data['main_content'] = 'index';
		
		$site_settings = $this->site_settings_model->get_settings();
		
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
	}
	
		
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){

		$this->load->library('module_installer');
		
		$data['slide1'] = array(
			'title'=>'first slide'
			,'content'=>'this is sample data'
			,'leftpos'=>'-255'
		);
		$data['slide2'] = array(
			'title'=>'second slide'
			,'content'=>'this is sample data'
			,'leftpos'=>'-255'
		);
		$data['slide3'] = array(
			'title'=>'third slide'
			,'content'=>'this is sample data'
			,'leftpos'=>'-255'
		);
		$data['slide4'] = array(
			'title'=>'fourth slide'
			,'content'=>'this is sample data'
			,'leftpos'=>'-255'
		);

		
		$data['dbprefix'] = $this->db->dbprefix;
		
		//$this->module_installer->process_file(APPPATH . "/modules/bg_pos_slider/install/mydata.sql",$data);
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);


		
		
	}

/**
* return infpo for the edit fields
* 
*/
function edit($id = null){

	$sql = "SELECT * FROM {$this->bgslider_table} WHERE id = '{$id}'";
			
	$result = mysql_query($sql);
	
	while($row = mysql_fetch_assoc($result)){
	
	
		$data = array(
		
			'id'=>$row['id'],
			'title'=>$row['title'],
			'link'=>$row['link'],						
			'content'=>$row['content'],
			'background_image'=>$row['background_image'],
			'leftpos'=>$row['leftpos']
			
		);
		
		echo json_encode($data);
			
	
	}

}


/**
*
*
*/
function do_background_ajaxfileupload(){
			
	global $_FILES;
	
	// this is not actually an AJAX call so we must turn the profiles off manually
	$this->config->set_item('debug_profiling',FALSE);
	$this->output->enable_profiler(FALSE);
		
		
	$this->load->library('file_tools');
	
	$widget_name = $this->input->post('widget_name');
	

	$upload_dir = getenv("DOCUMENT_ROOT"). ASSETURL . "upload/" . PROJECTNAME . "/bg_pos_slider/images/backgrounds/" . $widget_name;
	$this->file_tools->create_dirpath($upload_dir);
	
	$error = "";
	
	$msg = "";
		
	
	
	$fileElementName = 'background_fileToUpload';
	
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
			$msg .= " File Name: " . $_FILES[$fileElementName]['name'] . ", ";
			$msg .= " File Size: " . @filesize($_FILES[$fileElementName]['tmp_name']);
			
			//if(!file_exists($upload_dir)) mkdir($upload_dir);
						
			//for security reason, we force to remove all uploaded file
			//@unlink($_FILES['fileToUpload']);	
			move_uploaded_file($_FILES[$fileElementName]["tmp_name"], $upload_dir . "/" . $_FILES[$fileElementName]["name"]);
				
			$this->load->library('img_resize', $upload_dir . "/" . $_FILES[$fileElementName]["name"]);
						
			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$this->img_resize->resizeImage(976, 534, 'crop');
			
			// *** 3) Save image
			$this->img_resize->saveImage($upload_dir . "/" . $_FILES[$fileElementName]["name"], 100);
		
 
	}


	echo "{";
	echo				"error: '" . $error . "',\n";
	echo				"msg: '" . $msg . "',\n";
	echo				"background: '" . $widget_name . "/" . $_FILES[$fileElementName]["name"] . "'\n";
	
	echo "}";


}




function doajaxfileupload(){
			
	global $_FILES;
	
	// this is not actually an AJAX call so we must turn the profiles off manually
	$this->config->set_item('debug_profiling',FALSE);
	$this->output->enable_profiler(FALSE);
		
	
	$this->load->library('file_tools');
	
	$upload_dir = getenv("DOCUMENT_ROOT"). ASSETURL . "upload/".  PROJECTNAME . "/bg_pos_slider/images";
	$thumbs_dir = getenv("DOCUMENT_ROOT"). ASSETURL . "upload/".  PROJECTNAME . "/bg_pos_slider/images/thumbs";
			
	$this->file_tools->create_dirpath($upload_dir);
	$this->file_tools->create_dirpath($thumbs_dir);
	

	$thumbwidthheight = 100;

	

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
			move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$upload_dir . "/" . $_FILES["fileToUpload"]["name"]);
	
		
			// now resize this thing
			// *** Include the class
			
			$this->load->library('img_resize', $upload_dir . "/" . $_FILES["fileToUpload"]["name"]);
			
			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$this->img_resize->resizeImage($thumbwidthheight, $thumbwidthheight, 'crop');
						
			// *** 3) Save image
			$this->img_resize->saveImage($thumbs_dir . "/" . $_FILES["fileToUpload"]["name"], 100);
			
		
						
 
	}		
	
	$outbuf = "";
	
	$outbuf .= "{";
	$outbuf .=				"error: '" . $error . "',\n";
	$outbuf .=				"msg: '" . $msg . "',\n";
	$outbuf .=				"thumbname: '" . $_FILES["fileToUpload"]["name"] . "'\n";
	
	$outbuf .= "}";
	

	echo $outbuf;
	


}





function savecrop(){

	global $thumbwidthheight;
	
	// this needs to come from a config file eh!
	$thumbwidthheight = 100;
		
	$targ_w = $targ_h = $thumbwidthheight;
	$jpeg_quality = 90;
	
	//$targ_w = $_GET['w'];
	//$targ_h = $_GET['h'];
	
	$crop_x = $_GET['x'];
	$crop_y = $_GET['y'];
	
	$fn_extension = pathinfo($_GET['image'], PATHINFO_EXTENSION);

	$src = ASSET_ROOT . "upload/" . PROJECTNAME . "/bg_pos_slider/images/". $_GET['image'];
	
	$thumb_dst = ASSET_ROOT . "upload/" . PROJECTNAME . "/bg_pos_slider/images/thumbs/". $_GET['image'];
	
	
	if(strtolower($fn_extension) == "png"){
	
		$png_quality = 9;
		
		$img_r = imagecreatefrompng($src);
		$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
		
		imagecopyresampled($dst_r,$img_r,0,0,$crop_x,$crop_y,
		$targ_w,$targ_h,$_GET['w'],$_GET['h']);
		
		imagepng ($dst_r,$thumb_dst,$png_quality);
		
	}else{
	
		$jpeg_quality = 90;
		
		$img_r = imagecreatefromjpeg($src);
		$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
		
		imagecopyresampled($dst_r,$img_r,0,0,$crop_x,$crop_y,
		$targ_w,$targ_h,$_GET['w'],$_GET['h']);

		imagejpeg($dst_r,$thumb_dst,$jpeg_quality);
		
	}
	
	echo "done";
}


/**
* Save widget specific settings
*
*/
public function save_settings(){


	$this->load->library('widget_utils');

	$widget_id = $this->input->post('widget_id');	
	$prev_page = $this->input->post('widget_prev_page_selector');
	$next_page = $this->input->post('widget_next_page_selector');
			
	$this->widget_utils->set_widget_option($widget_id, 'prev_page',$prev_page);
	$this->widget_utils->set_widget_option($widget_id, 'next_page',$next_page);
	
	echo "OK";
		
	
}



/**
* save this record to the database
*
*/
function save(){

	

	$title = $this->input->post('s_title');
	$link = $this->input->post('s_link');


	
	$content = $this->input->post('s_content');
	$leftpos = $this->input->post('s_leftpos');
	$background_image = $this->input->post('background_image_url');
	$widget_id = $this->input->post('edit_id');
	$widget_name = $this->input->post('widget_name');
	
	$background_image  = str_replace($widget_name,"",$background_image);
	$background_image  = str_replace("/","",$background_image);
	$background_image  = str_replace("\\","",$background_image);
			

	$data = array(
	
		'title' => $title,
		'link' => $link,		
		'content' => $content,
		'leftpos' => $leftpos,
		'background_image' => $background_image,
		
	);	

	$this->db->where('id', $widget_id);
	$this->db->update('bgslider', $data); 

	//echo $this->db->last_query();

	
	echo "saved";
	
	

}

/**
* delete record
*
*/
function return_delete($id){

	$sql = "DELETE FROM {$this->bgslider_table} WHERE id = '{$id}'";
			
	mysql_query($sql);
	
	echo "deleted";
	
}


function ajax_reloadlist($param = ''){


	if(isset($param) && strpos($param, "::") !== false){
		
		list($param_name,$param_val) = explode("::",$param);
			
		if($param_name == "widget"){
			$widget_name = $param_val;
		}
	}

	echo $this->reloadlist($widget_name);
	

}


function reloadlist($widget_name = ''){

	$this->impressto->setDir(dirname(dirname(__FILE__)) . "/views/ps_templates");
		
	$sql = "SELECT * FROM {$this->bgslider_table} WHERE widget_name = '{$widget_name}' ORDER BY position";
		
	$result = mysql_query($sql);
	
	$i=0;
	
	$returnarray = array();
	
	
	$datarows = "";
	
	
	$datarows .=  $this->impressto->showpartial("manager.tpl.html",'LISTTABLEHEAD');
	
	
	while($row = mysql_fetch_assoc($result)){
	
	
		$i++;
		
		if ($i%2==0){
			$rowaltclass ="even";
			$divBdr ="CCCCCC";
		}else{
			$rowaltclass ="odd";//"afdae7";
			$divBdr ="FFFFFF";
		}
		
		$data = array(
		'id'=>$row['id'],
		'widget_name'=>$row['widget_name'],
		'title'=>$row['title'],
		'content'=>$row['content'],
		'leftpos'=>$row['leftpos'],
		'background_image'=>$row['background_image'],
		'rowaltclass'=>$rowaltclass,
		'divBdr'=>$divBdr
		);
	
	
		$datarows .= $this->impressto->showpartial("manager.tpl.html",'MANAGERLSTITEM',$data);
		
	}
	
	$datarows .=  $this->impressto->showpartial("manager.tpl.html",'LISTTABLEFOOT');
		
	
	return $datarows;
		

}

private function widget_selector($widget_name){

	$widget_names = $this->bgposslider->getDistinctWidgetNames();
	
	$options = array(""=>"Select Widget");
	
	foreach($widget_names as $val){
	
		$options[$val] = $val;
	
	}
	
	
	$js = 'id="widget_selector" onChange="ps_bgposmanager.switch_widget(this);"';
	
	return form_dropdown('widget_selector', $options, $widget_name, $js );
	
}


/**
* Creates a new instance of a widget by simply inserting 4 default records
* into the db table with the widget name. Redirects to edit panel with widthet name
* as the key
*
*/
public function createnewwidget(){

	$widget_name = $this->input->post('new_widget_name');
	
	$widget_name = str_replace(" ","_",$widget_name);
		
	$this->bgposslider->createnewwidget($widget_name);
	
	redirect("/bg_pos_slider/index/widget::{$widget_name}");
	


}



} //end class