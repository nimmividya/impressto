<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Developer Box
@Filename: developer_box.php
@Author: Nimmitha Vidyathilaka
@Projectnum: 1001
@Version: 1
@Status: complete
@Date: 2012-05
*/

/*

To make this work you need a tile cutter. Use MapTiler Beta from maptiler.org

VERY IMPORTANT: Make image based tiles (not Google Map tiles). If you use the other options
the images will get skewed and so will your brain (it happened to me).


*/

// example of usage
//  [widget type='developer_box']
// OR
// [widget='developer_box']
// OR IN SMARTY {widget type='developer_box'}


class developer_box extends Widget
{
    function run() {

		$args = func_get_args();
		
		$data = array();
		
		$this->load->library('asset_loader');
		$this->load->library('template_loader');
		
		
		
		$data['widget_js'] = ""; //$this->asset_loader->insert_js("/assets/".PROJECTNAME."/default/widgets/developer_box/js/developer_box.js");
		$data['widget_css'] = ""; //$this->asset_loader->insert_css("/assets/".PROJECTNAME."/default/widgets/developer_box/css/style.css");
		
	
		$this->asset_loader->add_header_js("/assets/" . PROJECTNAME . "/default/widgets/developer_box/js/developer_box.js");
		$this->asset_loader->add_header_css("/assets/" . PROJECTNAME . "//widgets/developer_box/css/style.css");
					
		
		//$this->render('developer_box',$data);
		
		$data['template'] = 'developer_box.php';
		
		$data['module'] = '';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'developer_box';			
		
		

		// use this to load witht the correct filters (language, device, docket)
		
		echo $this->template_loader->render_template($data);
		
		
		 
    }
}  

?>
