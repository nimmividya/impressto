<?php

class image_slider extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		
		
		$this->load->helper('auth');
		$this->load->library('impressto');
		
		is_logged_in();
		
		if(!$this->db->table_exists('ps_image_slider')) $this->install();
		
		$this->load->model('image_slider_model');
		
		
	}
	
	/**
	* default management page
	*
	*/
	public function index($param = ''){
		
		$this->load->helper('im_helper');
		
		$this->load->library('template_loader');
		
		$this->load->library('asset_loader');
		
	
		$module_config =  $this->config->item('module_config');
		$this->asset_loader->set_module_asset_version("image_slider",$module_config['version']);
			
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/custom_modules/image_slider/js/image_slider_manager.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/ajaxfileuploader/ajaxfileupload.js");
		$this->asset_loader->add_header_js("vendor/bootstrap/js/bootstrap-fileupload.js");
		
		
		
		$widget_name = "";
		
		$data['template_selector'] = "";
		
		$data['widget_content_list_div_visible'] = "none";
		
		
		if(isset($param) && strpos($param, "::") !== false){
			
			list($param_name,$param_val) = explode("::",$param);
			
			if($param_name == "widget"){
				$widget_name = trim($param_val);
				
				if($widget_name != ""){
				
				
					// little fix up for legacy shit
					$this->load->library('widget_utils');
					
					$widget_id = $this->widget_utils->getwidgetid('image_slider', 'image_slider', $widget_name);
					
					if($widget_id == ""){
						// fist thing is to create the widget instance
						$widget_id = $this->widget_utils->register_widget('image_slider', 'image_slider', $widget_name);
					}
					
					$widget_options = $this->widget_utils->get_widget_options($widget_id);
					
					//print_r($widget_options);
					
							
					$data['widget_content_list_div_visible'] = "visible";
					
					
					$templateselectordata = array(
					'selector_name'=>'template',
					'selector_label'=>'Template',
					'module'=> strtolower($this->router->class),
					'value'=> $widget_options['template'],
					'is_widget' => TRUE,	
					'onchange' => 'imageslider_manager.update_template(this)',
					
					);
					
					$data['template_selector'] = $this->template_loader->template_selector($templateselectordata);
					
				}
				
				
			}
			
		}
		
		
		
		$data['widget_selector'] = $this->widget_selector($widget_name);
		
		$data['widget_name'] = $widget_name;
		
		

		$data['infobar_help_section'] = getinfobarcontent('IMAGESLIDERHELP','custom_modules');
		
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
		
		
		
		$data['datarows'] = $this->reloadlist($widget_name);
		
		
		$data['main_content'] = 'image_slider_manager';
		

		
		
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
		
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
		
		// now copy any required css or js fles to the assets folder
		//$this->module_installer->copy_assets("/modules/image_slider");	

		$update_script = dirname(dirname(__FILE__)) . "/install/module_update.php";
		
		if(file_exists($update_script)){ 
		
			echo "running update script ";
			include($update_script); 
		}else{
		
			echo "failed to run $update_script ";
		
		}
		
			
		
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
*/
	function uploadimage(){
		
		global $_FILES, $thumbwidthheight;
	
	// this is not actually an AJAX call so we must turn the profiles off manually
	$this->config->set_item('debug_profiling',FALSE);
	$this->output->enable_profiler(FALSE);
			
		$this->load->library('file_tools');
		
		$upload_dir = getenv("DOCUMENT_ROOT"). ASSETURL . "upload/image_slider/images/" . $_POST['widget_name'];
		$thumbs_dir = getenv("DOCUMENT_ROOT"). ASSETURL . "upload/image_slider/images/" . $_POST['widget_name'] . "/thumbs";
		
		$this->file_tools->create_dirpath($upload_dir);
		$this->file_tools->create_dirpath($thumbs_dir);
		
		$thumbheight = 100;
		$thumbwidth = 300;
		
		
		
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
			
									
			move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$upload_dir . "/" . $_FILES["fileToUpload"]["name"]);
										
			
			$this->load->library('img_resize',$upload_dir . "/" . $_FILES["fileToUpload"]["name"]);
						
			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$this->img_resize->resizeImage(1000, 353, 'auto');
			
			// *** 3) Save image
			$this->img_resize->saveImage($upload_dir . "/" . $_FILES["fileToUpload"]["name"], 100);
			
			
			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$this->img_resize->resizeImage($thumbwidth, $thumbheight, 'crop');
			
	
			
			// *** 3) Save image
			$this->img_resize->saveImage($thumbs_dir . "/" . $_FILES["fileToUpload"]["name"], 100);
			
			
			
		}

		//$error .= addslashes($sql);
		
		echo "{";
		echo				"error: '" . $error . "',\n";
		echo				"msg: '" . $msg . "',\n";
		echo				"thumbname: '" . $_FILES[$fileElementName]["name"] . "'\n";
		
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

		$this->load->library('file_tools');
		
	
		$savedata = array(
		
		"title_en"=>$this->input->post('slide_title_en'),
		"title_fr"=>$this->input->post('slide_title_fr'),
		"caption_en"=>$this->input->post('slide_caption_en'),
		"caption_fr"=>$this->input->post('slide_caption_fr'),
		"url_en"=>$this->input->post('slide_url_en'),
		"url_fr"=>$this->input->post('slide_url_fr'),
		"slide_img"=>$this->input->post('temp_image'),
		"id"=>$this->input->post('s_edit_id'),
		"widget_name"=>$this->input->post('form_widget_name'),
		);
		
		$this->image_slider_model->save($savedata);
		
		/*
		$temp_image_path = ASSET_ROOT . "upload/".PROJECTNAME."/image_slider/temp/" . $this->input->post('temp_image');
		
		$final_image_path = ASSET_ROOT . "upload/".PROJECTNAME."/image_slider/" . $this->input->post('form_widget_name') . "/" . $this->input->post('temp_image');

		$thumbnail_folder = ASSET_ROOT . "upload/".PROJECTNAME."/image_slider/" . $this->input->post('form_widget_name') . "/thumbs/";
		
		$this->file_tools->create_dirpath($temp_image_path);
		$this->file_tools->create_dirpath($final_image_path);
		$this->file_tools->create_dirpath($thumbnail_folder);
		
		
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
		*/
				
		
	}

	/**
* delete record
*
*/
	function delete_item($id){
		
		
		$data = $this->image_slider_model->geteditdata($id);
		
		$image = ASSET_ROOT . "upload/".PROJECTNAME."/image_slider/{$data['widget_name']}/{$data['slide_img']}";

		$thumbnail = ASSET_ROOT . "upload/".PROJECTNAME."/image_slider/{$data['widget_name']}/thumbnails/{$data['slide_img']}";
		
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

	
	/**
	* Ajax responder
	*
	*/
	public function toggle_active($id, $lang, $state){
	
		if($state == 1) $data['active_' . $lang] = 0;
		else $data['active_' . $lang] = 1;
			
		$this->db->where('id', $id);
		$this->db->update('image_slider', $data);
		
		echo $this->db->last_query();
			
	}
	

	function reloadlist($widget_name = ''){


		if($widget_name == "") return "";

		//$projectnum = $this->config->item('projectnum');
		
		
		$this->impressto->setDir(dirname(dirname(__FILE__)) . "/views/ps_templates");
		
		$result = $this->image_slider_model->reloadlist($widget_name);
		
		
		$i=0;
		
		$returnarray = array();
		
		
		$datarows = "";
		
		
		$datarows .=  $this->impressto->showpartial("manager.tpl.html",'LISTTABLEHEAD');
		

		
		$numrows = 0;
		
		while($row = mysql_fetch_assoc($result)){
			
			$numrows ++;
			
		}
		
		mysql_data_seek($result, 0);

		
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
			
			$thumbnail = ASSETURL . "upload/image_slider/images/{$widget_name}/thumbs/{$row['slide_img']}";
						
			if($row['active_en'] == "1") $en_active_stateimg = "check";
			else $en_active_stateimg = "cross";
			
			//			echo $row['active_fr'] . "<br />";
			
			if($row['active_fr'] == "1") $fr_active_stateimg = "check";
			else $fr_active_stateimg = "cross";
			
			
			$en_active_check = "<img id=\"en_active_toggle_img_{$row['id']}\" src=\"" . ASSETURL . PROJECTNAME . "/default/core/images/actionicons/checkbox_{$en_active_stateimg}.gif\" lang=\"en\" is_active=\"{$row['active_en']}\" />";
			$fr_active_check = "<img id=\"fr_active_toggle_img_{$row['id']}\" src=\"" . ASSETURL . PROJECTNAME . "/default/core/images/actionicons/checkbox_{$fr_active_stateimg}.gif\" lang=\"en\" is_active=\"{$row['active_fr']}\" />";
						
			
			$data = array(
			'id'=>$row['id'],
			'title_en'=>$row['title_en'],
			//'slide_img'=>"/uploads/PROJECTNAME/widgets/image_slider/{$widget_name}/{$row['slide_img']}",
			'rowaltclass'=>$rowaltclass,
			'divBdr'=>$divBdr,
			'uparrow'=>$uparrow,
			'downarrow'=>$downarrow,
			'thumbnail'=>$thumbnail,
			'en_active_check'=>$en_active_check,
			'fr_active_check'=>$fr_active_check,
			'active_en'=>$row['active_en'],
			'active_fr'=>$row['active_fr'],
			
			);
			
			
			$datarows .= $this->impressto->showpartial("manager.tpl.html",'MANAGERLSTITEM',$data);
			
		}
		
		$datarows .=  $this->impressto->showpartial("manager.tpl.html",'LISTTABLEFOOT');
		
		
		return $datarows;
		

	}

	private function widget_selector($widget_name){

		$widget_names = $this->image_slider_model->getDistinctWidgetNames();
		
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

		$this->load->library('widget_utils');
			
		$widget_name = $this->input->post('new_widget_name');
		
		$widget_name = str_replace(" ","_",$widget_name);
		
		$this->image_slider_model->createnewwidget($widget_name);
		
		
		$widget_id = $this->widget_utils->getwidgetid('image_slider', 'image_slider', $widget_name);
				
		if($widget_id == ""){
		
			// fist thing is to create the widget instance
			$widget_id = $this->widget_utils->register_widget('image_slider', 'image_slider', $widget_name);
			
		}
		
		// update the name in case it was changed
		$sql = "UPDATE {$this->db->dbprefix}widgets SET instance = '{$widget_name}' WHERE widget_id = '{$widget_id}'";
		$this->db->query($sql);
		
		
		
		redirect("/admin/image_slider/index/widget::{$widget_name}");
		


	}

	/**
	* Ajax responder that sets the template for the currently selected template
	*
	*/
	public function update_template(){

		$this->load->library('widget_utils');
		
		
		$widget_name = $this->input->post('widget_name');
		$widget_template = $this->input->post('template');
				
		$widget_id = $this->widget_utils->getwidgetid('image_slider', 'image_slider', $widget_name);
							
		$this->widget_utils->set_widget_option($widget_id, 'template',$widget_template);
							
							
		echo $widget_template;


	}




	public function moveitem_up($id){
		
		$this->image_slider_model->moveitem("up",$id);
	}


	public function moveitem_down($id){
		
		$this->image_slider_model->moveitem("down",$id);

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