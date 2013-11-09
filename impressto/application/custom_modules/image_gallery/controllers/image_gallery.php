<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class image_gallery extends PSAdmin_Controller {

	// these methods are "freed" from authentication.
	private $front_ajax_functions = array("ajax_changeslide","ajax_mainpage");
	
	
	
	public function __construct(){
		
		parent::__construct();
		
		
		$this->load->helper('auth');
					
		$this->load->library('impressto');
				
		if(!$this->is_frontresponder()) is_logged_in();
		
		if(!$this->db->table_exists($this->db->dbprefix .'image_galleries')){
		
			$this->install();
		}
				
		$this->load->model('image_gallery_model');
	
		
	}
	
	/**
	* this handles public side ajax requests
	*
	*/
	public function is_frontresponder(){
			
		if(in_array($this->router->method, $this->front_ajax_functions)) return true;
		
		return false;
	
	}
	
	
	private function init_impressto(){
	
		$this->load->library('impressto');
		
		$projectnum = $this->config->item('projectnum');
			
		
		if($projectnum){
		
			$templatedir = GETENV("DOCUMENT_ROOT") . "/" . PROJECTNAME . "/templates/smarty/" . $projectnum . "/";
			if(file_exists($templatedir)){
				$docketdir = $projectnum;
			}else{
				$docketdir = "default";
			}
		}else{
			$docketdir = "default";
		}
		
		$this->impressto->setDir(APPPATH . "/custom_modules/image_gallery/widgets/views/{$docketdir}/impressto/");
	
	}
	
	
	/**
	* AJAX responder to change top the next image
	* @args = cat id, current slide id
	*/
	public function ajax_changeslide(){
	
		$this->init_impressto();
			
				
		// /
		//  returns json ... shit, meybe we don't even need this here
	
	}
	
	
	/**
	* AJAX responder to change top the next image
	*
	*/
	public function ajax_mainpage(){
	
		$this->init_impressto();
			
		// return the main page as nasty old HTML. 
		
		return $this->load->view('mainpage', $data, true);
		
	
	}
	

	
	/**
	* default management page
	*
	*/
	public function index($param = ''){
		
				
		$this->load->library('asset_loader');

		$this->load->library('formelement');
		$this->load->library('template_loader');
		$this->load->model('image_gallery_admin_model');
				
		$this->load->helper('im_helper');
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/image_gallery/js/image_gallery_manager.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/ajaxfileuploader/ajaxfileupload.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/uniform/jquery.uniform.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/handlebars.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/core/js/bootbox.min.js");
		
		$this->asset_loader->add_header_js("vendor/jquery/jquery.Jcrop.js");

		
		$this->asset_loader->add_header_css("core/css/jquery/jcrop/jquery.Jcrop.css");		
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME  . "/default/vendor/uniform/Aristo/uniform.aristo.css");
		

		$data = array();
		
		$user_session_data = $this->session->all_userdata();	
		$data['user_role'] = $user_session_data['role']; 
		
		
		

		$data['infobar_help_section'] = getinfobarcontent('IMAGEGALLERYHELP','custom_modules');
		
		//$data['infobar_help_section'] = getinfobarcontent('CONTENTEDITHELP');
		
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
		
		$data['template_options'] = array_merge(array("Select"=>""),$this->template_loader->find_templates(array("module"=>"image_gallery","is_widget"=>TRUE)));
				
		
		$category = $this->input->get_post('category');
		

		
		//$data['galleryrecords'] = $this->image_gallery_admin_model->get_galleryitems($category);
			
		
		$fielddata = array(
		'name'        => "gallery_category_selector",
		'type'          => 'select',
		'id'          => "gallery_category_selector",
		'label'          => "Category",
		'onchange' => "ps_imagegallerymanager.setcategory(this)",
		'options' =>  $this->image_gallery_admin_model->get_category_selector(),
		'value'       => $category
		);
	
	
		$data['category_selector'] = $this->formelement->generate($fielddata);
			
		
		
		$fielddata = array(
		'name'        => "editor_category_selector",
		'type'          => 'select',
		'id'          => "editor_category_selector",
		'label'          => "Category",
		'options' =>  $this->image_gallery_admin_model->get_category_selector(),
		'value'       => $category
		);
				
		$data['editor_category_selector'] = $this->formelement->generate($fielddata);
		
		

		///////////////////////
		// settings tab
		
		//$widget_settings = $this->image_gallery_model->get_widget_settings();
		
		//print_r($widget_settings);
		
		$this->load->helper('im_helper');
		
		//$widget_settings['template'] = isset($widget_settings['template']) ? $widget_settings['template'] : "";
		

		$templateselectordata = array(
		
			'selector_name'=>'template_selector',
			'selector_label'=>'Template',
			'module'=>'image_gallery',
			'value'=> '',
			'widgettype' => '',
			'is_widget' => TRUE,	
			'lang' => 'en',	// force the template language to english for all backend selectors
			
		);
	
		
		$data['template_selector'] = $this->template_loader->template_selector($templateselectordata);
				
		$data['image_galleries'] = $this->image_gallery_admin_model->get_galleries();
				
		
		/*
		$widget_settings['thumb_maxwidth'] = isset($widget_settings['thumb_maxwidth']) ? $widget_settings['thumb_maxwidth'] : "200";
		
		$fielddata = array(
		'name'        => "thumb_maxwidth_input",
		'type'          => 'text',
		'id'          => "thumb_maxwidth_input",
		'label'          => "Thumbnail max width",
		'width'=>'60',
		'value'       => $widget_settings['thumb_maxwidth']
		);
				
		$data['thumb_maxwidth_input'] = $this->formelement->generate($fielddata);
		
		
		$widget_settings['thumb_maxheight'] = isset($widget_settings['thumb_maxheight']) ? $widget_settings['thumb_maxheight'] : "200";
		
		$fielddata = array(
		'name'        => "thumb_maxheight_input",
		'type'          => 'text',
		'id'          => "thumb_maxheight_input",
		'label'          => "Thumbnail max height",
		'width'=>'60',
		'value'       => $widget_settings['thumb_maxheight']
		);
				
		$data['thumb_maxheight_input'] = $this->formelement->generate($fielddata);

		$widget_settings['resized_maxwidth'] = isset($widget_settings['resized_maxwidth']) ? $widget_settings['resized_maxwidth'] : "800";

				
		$fielddata = array(
		'name'        => "resized_maxwidth_input",
		'type'          => 'text',
		'id'          => "resized_maxwidth_input",
		'label'          => "Resized max width",
		'width'=>'60',
		'value'       => $widget_settings['resized_maxwidth']
		);
				
		$data['resized_maxwidth_input'] = $this->formelement->generate($fielddata);
		
		$widget_settings['resized_maxheight'] = isset($widget_settings['resized_maxheight']) ? $widget_settings['resized_maxheight'] : "600";

		
		$fielddata = array(
		'name'        => "resized_maxheight_input",
		'type'          => 'text',
		'id'          => "resized_maxheight_input",
		'label'          => "Resized max height",
		'width'=>'60',
		'value'       => $widget_settings['resized_maxheight']
		);
				
				
		$data['resized_maxheight_input'] = $this->formelement->generate($fielddata);
			
		*/
			

		//$data['widget_settings'] = $widget_settings;
		
				

				
					
		$data['gallery_list'] = $this->load->view('image_gallery_list', $data, TRUE);
		
							
		//$data['gallery_categories'] = $this->image_gallery_admin_model->get_gallery_categories();
		
					
		$data['gallery_categories_list'] = $this->load->view('/partials/categories_list', $data, TRUE);
		
		
	
		
		$data['main_content'] = 'image_gallery_manager';
		
		
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

	
		$module_config = $this->config->item('module_config');
		


	
		
		
		
		$this->load->library('module_installer');
		$this->load->library('widget_utils');
		
		
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
	
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
		
		
		if(isset($module_config['version']) && is_numeric($module_config['version'])){
			
			$update_script = dirname(dirname(__FILE__)) . "/install/module_update_".$module_config['version'].".php";
				
			if(file_exists($update_script)) include($update_script); 
							
		}
		
	
		
		// now copy any required css or js fles to the assets folder
	
		
		// this is a singleton widget. There are no instances
		$this->widget_utils->register_widget("image_gallery","image_gallery");
				
		
	}
	
	/**
	* remove the module
	*	 
	*/
	public function uninstall(){
	
	
		$this->widget_utils->un_register_widget("image_gallery","image_gallery");
		
		
	}
	
	

/**
* return infpo for the edit fields
* 
*/
function edit($id = null, $current_widget = null){

	echo json_encode($this->image_slider_model->geteditdata($id,$current_widget));
			


}




/**
*
*

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
			
			$temp_image_path = ASSET_ROOT . "uploads/".PROJECTNAME."/image_gallery/temp/" . $_FILES[$fileElementName]["name"];
			
			move_uploaded_file($_FILES[$fileElementName]["tmp_name"],$temp_image_path);
			
					
			if(!file_exists(ASSET_ROOT . "uploads/".PROJECTNAME."/image_gallery/" . $_POST['widget_name'])){
			
				mkdir(ASSET_ROOT . "uploads/".PROJECTNAME."/image_gallery/" . $_POST['widget_name']);
			
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

*/





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
	
	$this->image_slider_model->save($savedata);
	
	$temp_image_path = ASSET_ROOT . "uploads/".PROJECTNAME."/image_gallery/temp/" . $this->input->post('temp_image');
				
	$final_image_path = ASSET_ROOT . "uploads/".PROJECTNAME."/image_gallery/" . $this->input->post('form_widget_name') . "/" . $this->input->post('temp_image');

	$thumbnail_folder = ASSET_ROOT . "uploads/".PROJECTNAME."/image_gallery/" . $this->input->post('form_widget_name') . "/thumbnails/";
	
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
		
	
	$data = $this->image_slider_model->geteditdata($id);
	
	$image = ASSET_ROOT . "uploads/".PROJECTNAME."/widgets/image_slider/{$data['widget_name']}/{$data['slide_img']}";

	$thumbnail = ASSET_ROOT . "uploads/".PROJECTNAME."/widgets/image_slider/{$data['widget_name']}/thumbnails/{$data['slide_img']}";
	
	//echo "IT IS $image";
	
	unlink($image);
	unlink($thumbnail);
	
	$this->image_slider_model->delete_item($id);
	
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





public function moveitem_up($id){
	
	$this->image_gallery_model->moveitem("up",$id);
}


public function moveitem_down($id){
	
	$this->image_gallery_model->moveitem("down",$id);

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