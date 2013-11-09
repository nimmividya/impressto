<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Events_xtra_content {

    protected $ci;

    protected $fallbacks = array();

    public function __construct()
    {
        $this->ci =& get_instance();
		

		
        //register the page_manager_save event
        Events::register('page_manager_edit_page', array($this, 'get_edit_code'));
		Events::register('public_page_view', array($this, 'merge_content'));
	
		Events::register('page_manager_save', array($this, 'save_content'));
		Events::register('page_manager_delete', array($this, 'delete_content'));
		
		
       
	
		
		Events::register('page_editor_assets', array($this, 'load_assets'));
		
		
    }

	

	/**
	* This will get the content and load it onto a view that will be send back to the editor panel
	* @package /custom_modules/xtra_content
	*/
	public function get_edit_code( $data ) // we will update the data array
    {
	
		$CI =& get_instance();
		
		$CI->load->library('formelement');
				
		
		$xtra_data = array();
				
		$xtra_data['xtra_content'] = $this->get_content( $data, "standard" );
		
		// this is our preferred location for this specific addon in the page edit panel
		if(!isset($data['editzone_1'])) $data['editzone_1'] = array();
				
		// load the view
		$data['editzone_1'][] = $CI->load->view(dirname(__FILE__) . '/views/edit_code', $xtra_data, TRUE);	
		
				
				
		$xtra_data['xtra_content'] = $this->get_content( $data, "mobile" );
		
		// this is our preferred location for this specific addon in the page edit panel
		if(!isset($data['editzone_3'])) $data['editzone_3'] = array();
		
		// load the view
		$data['editzone_3'][] = $CI->load->view(dirname(__FILE__) . '/views/edit_code', $xtra_data, TRUE);	
		
		//print_r($data);

			
		return $data;
		
			
		
    }
	
	
	/**
	* Grab the xtra content fileds associatd with said page id
	* and merges it into the main data array
	* 
	*/
	public function merge_content( $data ){
		
		$CI =& get_instance();
		
		$merge_data = array();
						
		$CI->load->model('xtra_content/xtra_content_model');
			
		$xtra_data = $CI->xtra_content_model->get_content( $data );
		
		foreach($xtra_data AS $field_name => $field_data){
		
			$merge_data[$field_name] =  $field_data['content'];
		
		}
				
		
		$data = array_merge($data, $merge_data);
		
		//print_r($xtra_data);

		return $data;
		
    }
	
	/**
	* Grab the xtra content fileds associatd with said page id
	* 
	*/
	public function get_content( $data , $media = "all" ){
		
		$CI =& get_instance();
				
		$CI->load->model('xtra_content/xtra_content_model');
			
		return $CI->xtra_content_model->get_content( $data, $media );
				
		
    }
	

	/**
	* 
	* @package /custom_modules/xtra_content
	*/
	public function save_content($data)
    {
	
		$CI =& get_instance();
		
		//print_r($data);
	
		if($data['CO_Node']){
		
			//add the path for the widgets module so we can locate the models	
			//$CI->load->_add_module_paths('swa_compliance_manager');
			$CI->load->model('xtra_content/xtra_content_model');
					
					
			$CI->xtra_content_model->save_content($data);
			
		}
	
			
	

    }
	
	
	/**
	* 
	* @package /custom_modules/xtra_content
	* @param $data - this is a passthru variable
	*/
	public function delete_content($item_id)
    {
	
		$CI =& get_instance();
		
		echo "okee";
		
		//print_r($data);
	
		//add the path for the widgets module so we can locate the models	
		//$CI->load->_add_module_paths('swa_compliance_manager');
		$CI->load->model('xtra_content/xtra_content_model');
							
		$CI->xtra_content_model->delete_content($item_id);
			
		
		//return $data;
	
		

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
	

	

	
}
/* End of file events.php */