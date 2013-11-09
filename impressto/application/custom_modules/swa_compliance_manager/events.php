<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Events_swa_compliance_manager {

    protected $ci;

    protected $fallbacks = array();

    public function __construct()
    {
        $this->ci =& get_instance();
		

		
        //register the page_manager_save event
        Events::register('page_manager_edit_page', array($this, 'get_static_html'));
		Events::register('page_manager_save', array($this, 'save_static_html'));
        
		Events::register('public_page_view', array($this, 'get_public_html'));

		Events::register('page_manager', array($this, 'pagemanager_menu_link'));
		Events::register('page_manager', array($this, 'pagemanager_list_icons'));
		
		Events::register('page_manager_assets', array($this, 'load_assets'));
		Events::register('page_editor_assets', array($this, 'load_assets'));
		Events::register('page_editor_popupwidgets', array($this, 'load_popupwidgets'));
		
		
		Events::register('page_editor_buttons', array($this, 'page_editor_buttons'));
		
    }

	
	/**
	* 
	* @package /modules/banners
	*/
	public function get_public_html( $data ) // we will update the data array
    {
	
		if(!isset($data['CO_Node'])) return $data;
			
		$CI =& get_instance();
		
		$public_data = $this->get_static_html( $data );
		
		
		$public_data['CO_Body'] = str_replace("=\"./images", "=\"" . ASSETURL . "upload/clf_compliance_manager/{$data['content_lang']}/images", $public_data['CO_Body']);
		$public_data['CO_Body'] = str_replace("=\"images",  "=\"" . ASSETURL . "upload/clf_compliance_manager/{$data['content_lang']}/images", $public_data['CO_Body']);

		$public_data['CO_Body'] = str_replace("=\"../images",  "=\"" . ASSETURL . "upload/clf_compliance_manager/images", $public_data['CO_Body']);

		// this is just a temporary fix until we fix a bug with the pageshaper widget shortcode parser
		//.. there is a wierd bug fix here. 
		//$public_data['CO_Body'] = str_replace("[","&#91;", $public_data['CO_Body']);
		//$public_data['CO_Body'] = str_replace("]","&#93;", $public_data['CO_Body']);
				

		return 	$public_data;
			
		
    }
	
	
	/**
	* 
	* @package /modules/banners
	*/
	public function get_static_html( $data ) // we will update the data array
    {
	
		$CI =& get_instance();
				
		//add the path for the widgets module so we can locate the models	
		$CI->load->_add_module_paths('swa_compliance_manager');
		$CI->load->model('swa_compliance_manager_model');
			
		return $CI->swa_compliance_manager_model->get_static_html( $data) ;
			
		
    }
	

	/**
	* 
	* @package /modules/banners
	*/
	public function save_static_html($data)
    {
	
		$CI =& get_instance();
		
		//print_r($data);
	
		if($data['CO_Node']){
		
			//add the path for the widgets module so we can locate the models	
			$CI->load->_add_module_paths('swa_compliance_manager');
			$CI->load->model('swa_compliance_manager_model');
					
					
			$dir_path = $CI->swa_compliance_manager_model->getfilepath($data['CO_Node'],$data['lang']);
						
			$CI->file_tools->create_dirpath($dir_path);
			
			if(isset($data['old_data']) && ($data['old_data']['CO_seoTitle'] != $data['CO_seoTitle'])){
				
				//echo "renaming";
				
				$old_target_file = $dir_path . "/" . $data['old_data']['CO_seoTitle'] . ".html";
				
				$new_target_file = $dir_path . "/" . $data['CO_seoTitle'] . ".html";
				
				rename ( $old_target_file ,$new_target_file );
								
				
			}
			
							
			$target_file = $dir_path . "/" . $data['CO_seoTitle'] . ".html";
						
			write_file($target_file,$data['CO_Body']);
			
			//echo "TEST";
			
			
		}


    }

	
	
	public function pagemanager_menu_link($data){
	
		$CI =& get_instance();
			
		$data['pagemanager_menulink'] = array("css_class"=>"clf_checklist","label"=>"CLF 2.0", "link"=>"ps_swa_compliance_manager.show_status");
	
		
		return $data;
			
	
	
	}
	
	public function pagemanager_list_icons($data){
	
		$CI =& get_instance();
		
	
		// here we will process all the pages that have been checked for clf compliance and return an array
		
		//add the path for the widgets module so we can locate the models	
		$CI->load->_add_module_paths('swa_compliance_manager');
		$CI->load->model('swa_compliance_manager_model');

		$compliance_records = $CI->swa_compliance_manager_model->get_compliance_ratings($data['lang']);
		
	
		$data['pagemanager_listicons'] = array();
				
		if($compliance_records){
			
			foreach($compliance_records AS $node_id => $compliance_data){
		
				$pass = TRUE;

				foreach($compliance_data AS $fieldval){
			
					if($fieldval == 'N') $pass = FALSE;
			
				}
		
				if($pass) {
					$data['pagemanager_listicons'][$node_id] = "<img src=\"" . ASSETURL . PROJECTNAME . "/default/custom_modules/swa_compliance_manager/images/pass_test.png\">&nbsp;";
				}else{
					$data['pagemanager_listicons'][$node_id] = "<img src=\"" . ASSETURL . PROJECTNAME . "/default/custom_modules/swa_compliance_manager/images/fail_test.png\">&nbsp;";
				}
			}
		}
		
		
		return $data;
			
	
	
	}
	
	
	public function load_assets(){
	
		$CI =& get_instance();
	
		$CI->asset_loader->add_header_css("/default/custom_modules/swa_compliance_manager/css/style.css");
		$CI->asset_loader->add_header_css("/default/core/css/jquery/jquery.treeview.css");		
		
		$CI->asset_loader->add_header_js("/default/custom_modules/swa_compliance_manager/js/swa_compliance_manager.js");	
		$CI->asset_loader->add_header_js("/default/vendor/jquery/jquery.treeview.js");

		// This is required for the new text tools
		$CI->asset_loader->add_header_css("default/core_modules/dev_shed/css/text_tools.css");
		$CI->asset_loader->add_header_js("default/core_modules/dev_shed/js/text_tools.js");
		
	
	}
	
	
	/**
	* this loads addon widgets and sparks packages that may be used by this module
	*
	*/
	public function load_popupwidgets(){
	
		$CI =& get_instance();
		
		Widget::run('wcag_contrast_checker', array('rendermode'=>'popup'));
		
		

	
	}
	
	
	
	public function page_editor_buttons($data){
	
		$CI =& get_instance();
		
		$buttons = array();
					
		if($data['node_id'] != ""){
		
			$buttons[] = array(
				"label" => "SWA Kit",
				"action" => "ps_swa_compliance_manager.show_status('{$data['node_id']}','{$data['lang']}')",
				"btn_class" => "btn-inverse",
				"btn_icon_class" => "splashy-okay"
				
			);
						
		}

		$buttons[] = array(
			"label" => "Contrast Checker",
			"action" => "#contrast_checker_wrap",
			"btn_class" => "btn-inverse nyroModalbutton",
			"btn_icon_class" => "splashy-thumb_up"
				
		);
			
		
		return $buttons;
		
	
	}
	
}
/* End of file events.php */