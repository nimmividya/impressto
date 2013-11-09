<?php

class top_banners extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		
		
		$this->load->helper('auth');
		$this->load->library('impressto');
				
		is_logged_in();
		
		if(!$this->db->table_exists('ps_top_banners')) $this->install();
				
		$this->load->model('top_banners_model');
	
		
	}
	
	/**
	* default management page
	*
	*/
	public function index($param = ''){
		
		
		
		$this->load->library('asset_loader');
		
		$data['headerjs'] = $this->asset_loader->insert_js(ASSETURL.PROJECTNAME."/custom_modules/top_banners/js/top_banners_manager.js");
		$data['headerjs'] .= $this->asset_loader->insert_js(ASSETURL . PROJECTNAME  . "/default/vendor/ajaxfileuploader/ajaxfileupload.js");

		
		$widget_name = "";
					
		
		if(isset($param) && strpos($param, "::") !== false){
		
			list($param_name,$param_val) = explode("::",$param);
			
			if($param_name == "widget"){
				$widget_name = $param_val;
			}
					
		}
		
		
		$data['widget_selector'] = $this->widget_selector($widget_name);
		
		$data['widget_name'] = $widget_name;
		
		$data['infobar_help_section'] = getinfobarcontent('TOPBANNERSHELP','custom_modules');
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
		
				
		$data['datarows'] = $this->reloadlist($widget_name);
		
		$data['main_content'] = 'top_banners_manager';
		
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

		
		//$this->module_installer->process_file(APPPATH . "/custom_modules/top_banners/install/mydata.sql",$data);

		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);

		// now copy any required css or js fles to the assets folder
		$this->module_installer->copy_assets("/custom_modules/" . $this->router->class);		

		
		
	}

/**
* return infpo for the edit fields
* 
*/
function edit($id = null, $current_widget = null){

	echo json_encode($this->top_banners_model->geteditdata($id,$current_widget));
			


}




/**
*
*
*/
function uploadimage(){
			
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
			//$msg .= " File Name: " . $_FILES[$fileElementName]['name'] . ", ";
			//$msg .= " File Size: " . @filesize($_FILES[$fileElementName]['tmp_name']);
			
			$temp_image_path = ASSET_ROOT . "upload/".PROJECTNAME."/widgets/top_banners/temp/" . $_FILES[$fileElementName]["name"];
			
			move_uploaded_file($_FILES[$fileElementName]["tmp_name"],$temp_image_path);
			
					
			if(!file_exists(ASSET_ROOT . "upload/".PROJECTNAME."/widgets/top_banners/" . $_POST['widget_name'])){
			
				mkdir(ASSET_ROOT . "upload/".PROJECTNAME."/widgets/top_banners/" . $_POST['widget_name']);
			
			}
			
			$this->load->library('img_resize',$temp_image_path);
			
			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$this->img_resize->resizeImage(1000, 353, 'auto');
			
			// *** 3) Save image
			$this->img_resize->saveImage($temp_image_path, 100);
			
			
			$this->img_resize->setimage($temp_image_path);
			
			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$this->img_resize->resizeImage(1000, 353, 'crop');
			
			// *** 3) Save image
			$this->img_resize->saveImage($temp_image_path, 100);
 
	}

	//$error .= addslashes($sql);
	
	echo "{";
	echo				"error: '" . $error . "',\n";
	echo				"msg: '" . $msg . "',\n";
	echo				"temp_image: '" . $_FILES[$fileElementName]["name"] . "'\n";
	
	echo "}";


}






function edit_widget_settings($widget_name){

	// get these from the options table and return as a json array
	//effect: 'sliceUp',
	//	animSpeed: 500,
	//	pauseTime: 3000,
		

}



function save_widget_settings(){

	//	effect: 'sliceUp',
	// 	animSpeed: 500,
	//	pauseTime: 3000,	

}



/**
* save this record to the database
*
*/
function save(){

	$savedata = array(
	
		"title"=>$this->input->post('s_title')
		,"slide_img"=>$this->input->post('temp_image')
		,"id"=>$this->input->post('s_edit_id')
		,"widget_name"=>$this->input->post('form_widget_name')
		


	);
	
	$this->top_banners_model->save($savedata);
	
	$temp_image_path = ASSET_ROOT . "upload/".PROJECTNAME."/widgets/top_banners/temp/" . $this->input->post('temp_image');
				
	$final_image_path = ASSET_ROOT . "upload/".PROJECTNAME."/widgets/top_banners/" . $this->input->post('form_widget_name') . "/" . $this->input->post('temp_image');

	$thumbnail_folder = ASSET_ROOT . "upload/".PROJECTNAME."/widgets/top_banners/" . $this->input->post('form_widget_name') . "/thumbnails/";
	
	$thumbnail = $thumbnail_folder  . $this->input->post('temp_image');
		
	if(file_exists($temp_image_path) && !file_exists($final_image_path)) rename($temp_image_path, $final_image_path);

	if(!file_exists($thumbnail_folder)) mkdir($thumbnail_folder);

	if(!file_exists($thumbnail)){

		// now create a thumbnail for the list
		$this->load->library('img_resize',$final_image_path);
		
		// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
		$this->img_resize->resizeImage(200, 100, 'auto');
		
		// *** 3) Save image
		$this->img_resize->saveImage($thumbnail_folder . $this->input->post('temp_image'), 100);
		
	}		
	
}

/**
* delete record
*
*/
function delete_item($id){
		
	
	$data = $this->top_banners_model->geteditdata($id);
	
	$image = ASSET_ROOT . "upload/".PROJECTNAME."/widgets/top_banners/{$data['widget_name']}/{$data['slide_img']}";

	$thumbnail = ASSET_ROOT . "upload/".PROJECTNAME."/widgets/top_banners/{$data['widget_name']}/thumbnails/{$data['slide_img']}";
	
	//echo "IT IS $image";
	
	unlink($image);
	unlink($thumbnail);
	
	$this->top_banners_model->delete_item($id);
	
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

	$this->impressto->setDir(APPPATH . "/custom_modules/top_banners/templates");
	
	$result = $this->top_banners_model->reloadlist($widget_name);
	
		
	$i=0;
	
	$returnarray = array();
	
	
	$datarows = "";
	
	
	$datarows .=  $this->impressto->showpartial("manager.tpl.html",'LISTTABLEHEAD');
	

	
	$numrows = 0;
	
	while($row = mysql_fetch_assoc($result)){
	
		$numrows ++;
		
	}
	
	mysql_data_seek($result,0);
	//echo "IT IS " . $numrows;
	
	while($row = mysql_fetch_assoc($result)){
	
	
		$i++;
		
		if ($i%2==0){
			$rowaltclass ="even";
			$divBdr ="CCCCCC";
		}else{
			$rowaltclass ="odd";//"afdae7";
			$divBdr ="FFFFFF";
		}
		
		$uparrow = "empty.gif";
		$downarrow = "downarrow.gif";
		
		if($i > 1) $uparrow = "uparrow.gif";
		if($i == $numrows) $downarrow = "empty.gif";
		
		$thumbnail =  ASSETURL . "upload/" . PROJECTNAME . "/widgets/top_banners/{$widget_name}/thumbnails/{$row['slide_img']}";
	
		
		$data = array(
		'id'=>$row['id'],
		'title'=>$row['title'],
		'slide_img'=>"/uploads/" . PROJECTNAME . "/widgets/top_banners/{$widget_name}/{$row['slide_img']}",
		'rowaltclass'=>$rowaltclass,
		'divBdr'=>$divBdr,
		'uparrow'=>$uparrow,
		'downarrow'=>$downarrow,
		'thumbnail'=>$thumbnail
		);
	
	
		$datarows .= $this->impressto->showpartial("manager.tpl.html",'MANAGERLSTITEM',$data);
		
	}
	
	$datarows .=  $this->impressto->showpartial("manager.tpl.html",'LISTTABLEFOOT');
		
	
	return $datarows;
		

}

private function widget_selector($widget_name){

	$widget_names = $this->top_banners_model->getDistinctWidgetNames();
	
	$options = array(""=>"Select Widget");
	
	foreach($widget_names as $val){
	
		$options[$val] = $val;
	
	}
	
	
	$js = 'id="widget_selector" onChange="imageslider_manager.switch_widget(this);"';
	
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
		
	$this->top_banners_model->createnewwidget($widget_name);
	
	redirect("/admin/top_banners/index/widget::{$widget_name}");
	


}


public function moveitem_up($id){
	
	$this->top_banners_model->moveitem("up",$id);
}


public function moveitem_down($id){
	
	$this->top_banners_model->moveitem("down",$id);

}


function settings(){

	$settingSql="SELECT * FROM ps_slideshow_settings WHERE set_id=1";
	$settingRes=mysql_query($settingSql);
	$setting=mysql_fetch_assoc($settingRes);


	$selected='selected="selected"';

	if ($setting['set_pauseOnHover']==true)
	$checked='checked="checked"';
	else
	$checked='';
	
	
	$data = array(
	
	'selected'=>$selected,
	'setting'=>$setting,
	'checked'=>$checked
	
	);
	
	echo $this->impressto->showpartial("manager.tpl.html",'SETTINGS',$data);
	
	


}



} //end class