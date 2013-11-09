<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Events_sticky_notes {

	protected $ci;

	protected $fallbacks = array();

	public function __construct()
	{
		$this->ci =& get_instance();

		Events::register('public_page_view', array($this, 'get_public_html'));

	}

	
	/**
	* 
	* @package /custom_modules/sticky_notes
	*/
	public function get_public_html( $data ) // we will update the data array
	{

		if(!isset($data['CO_Node'])) return $data;
		
		$CI =& get_instance();
		

		$CI->load->plugin('admin_widget');
		
		$user_session_data = $CI->session->all_userdata();	
	
		if(isset($user_session_data['role']) && $user_session_data['role'] == 1){
			
			$CI->load->library('asset_loader');
			$CI->load->config('sticky_notes/config');
			$module_config = $CI->config->item('module_config');
			
			if(isset($module_config['version'])) $module_version = $module_config['version'];
			else $module_version = null;
			
			$CI->asset_loader->set_module_asset_version('sticky_notes',$module_version);
			
			$CI->asset_loader->add_header_css("default/custom_modules/sticky_notes/css/sticky_notes.css");
			$CI->asset_loader->add_header_js("default/custom_modules/sticky_notes/js/sticky_notes.js");
			$CI->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/ajaxfileuploader/ajaxfileupload.js");
					
			
			$widget_args = array("content_id"=>$data['CO_Node'],"lang"=>$data['content_lang'],"user_id"=>$CI->session->userdata('id'));
			
			
					
			if(isset($data['admin_widgets'])){
				$data['admin_widgets'] .= Widget::run('sticky_notes/sticky_notes',$widget_args);
			}else{
				$data['admin_widgets'] = Widget::run('sticky_notes/sticky_notes',$widget_args);
			}
			
			
		}
		
		return $data;
		
		
	}
	

}
/* End of file events.php */