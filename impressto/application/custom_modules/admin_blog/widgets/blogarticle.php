<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// sample tags
//  [widget type='admin_blog/blogarticle']
//  direct from PHP cde Widget::run('admin_blog/blogarticle, array()'name'=>'widget_1')
//  within smarty {widgets type='admin_blog/blogarticle' name='widget1'}
//  when viewing a full blog item, this widget can be set to displayfull mode

class blogarticle extends Widget
{

	/**
	* Default state for this widget is to list blog articles
	* by the page limit specified in blog settings
	*
	*/
    function run() {
	
		$error = "";
	
		$this->load->library('asset_loader');
		$this->load->library('widget_utils');
		$this->load->library('template_loader');
		$this->load->helper('im_helper');
				
	
		$args = func_get_args();

		
		$lang_selected = $this->config->item('lang_selected');
	
        // if paramaeters have been passed to this widget, assign them	and override the defaults for this widget instance
		if(isset($args[0]) && is_array($args[0])){
		
			$widget_args = $args[0];
					
			if(isset($args[0]['name'])) $data['name'] = $args[0]['name'];
			
		}

	
		////////////////////////////////
		// Nimmitha Vidyathilaka - May 21, 2012
		//add the path for the widgets module so we can locate the models	
		//$this->load->_add_module_paths('admin_blog');
		
		$this->load->model('admin_blog/blog_model');
		
				
		//$this->load->_add_module_paths('breadcrumbs');
		//$this->load->model('breadcrumbs_model');
		
		// load the blog widget language file now...
		$this->lang->load('blog_widgets', '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');
		
		
		// If the widget is being called form a shortcode and there is no ID, get the id 
		if(!isset($widget_args['widget_id']) && isset($data['name'])) 
			$widget_args['widget_id'] = $this->widget_utils->getwidgetid('blogarticle', 'admin_blog', $data['name']);
		
		
				
		$widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);
		
		
		$page_data = $this->config->item('page_data');

		
		
		$moduleoptions = ps_getmoduleoptions('admin_blog');
		
		if(!isset($moduleoptions['admin_blog_page_' . $lang_selected])){
		
			$data['blogpageurl'] = $this->current_url();
					
			$error .= " MISSING blog page link. See blog settings ";
			
		}else{
			$data['blogpageurl'] = $moduleoptions['admin_blog_page_' . $lang_selected];
		}
		
		
		
		if(!isset($moduleoptions['blog_listlimit'])){
		
			$moduleoptions['blog_listlimit'] = 10; // just a default
			
		}
		

		
		$data['search_keywords'] = "";
					

		if(!isset($moduleoptions['blog_title_' . $lang_selected])){
		
			$data['blogpagetitle'] = ""; 
			
		}else{
			
			$data['blogpagetitle'] = $moduleoptions['blog_title_' . $lang_selected];
	
			$page_data['CO_seoTitle'] = $data['blogpagetitle'];
		
		}

	
		
		
		$data['blog_pager'] = 1;
				
		if($this->input->get_post('blog_pager') != ""){
			$data['blog_pager'] = $this->input->get_post('blog_pager') ;
		}
		
	
		
		if($this->input->get_post('blog_id') != ""){
		
			$data['blog_id'] = $this->input->get_post('blog_id');
		
			// simply load the specificed article into the view and don't bother with listing anything else
			$data['blogitem'] = $this->blog_model->get_blog_item($data['blog_id']);
			
			$page_data['page_title'] = $data['blogitem']['blogtitle'];
					
					
		}else if ($this->input->get_post('blog_tag') != ""){
		
			$data['blog_tag'] = $this->input->get_post('blog_tag');
		
			$newsrecords = $this->blog_model->get_active_items('', $data['blog_tag'],$data['blog_pager'], $moduleoptions['blog_listlimit']);
			
			$data['blogitems'] = $newsrecords['limitedrecords'];
			$data['totalblogcount'] = $newsrecords['totalrowcount'];

			
		}else if ($this->input->get_post('blog_search_keywords') != ""){
		
			$data['search_keywords'] = $this->input->get_post('blog_search_keywords');
		
			// proces the list view with keyword search
			
			
			$blogrecords = $this->blog_model->get_active_items($this->input->get_post('blog_search_keywords'),'',$data['blog_pager'], $moduleoptions['blog_listlimit']);
			

			
			$data['blogitems'] = $blogrecords['limitedrecords'];
			$data['totalblogcount'] = $blogrecords['totalrowcount'];
			
			
		}else{
		
					
			// regular full list
			$blogrecords = $this->blog_model->get_active_items('','',$data['blog_pager'], $moduleoptions['blog_listlimit']);

			
			$data['blogitems'] = $blogrecords['limitedrecords'];
			$data['totalblogcount'] = $blogrecords['totalrowcount'];
			
		
		}
		
		$data['lang'] = $lang_selected;
		
		$data['content_type'] = "blog";
		if( isset($data['blog_id']) ) $data['content_id'] = $data['blog_id'];
		
		// events are a broadcast method
		$triggerdata = Events::trigger('show_content', $data, 'array');
		if($triggerdata) $data = $triggerdata[0];
		


		// set page data overrides here
		$this->config->set_item('page_data', $page_data);
	
	
		// DO NOT USE $this->render unless you want to simply show PHP files
		//$this->render("blogticker/" . $widget_options['template'],$data);
		
		$data['moduleoptions'] = $moduleoptions;

		$data['template'] = $widget_options['template'];
		
		$data['module'] = 'admin_blog';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'blogarticle';			
		
		

		// use this to load witht the correct filters (language, device, docket)
		echo $this->template_loader->render_template($data);
				
	
		
		return;
			

		 
    }
	
	
	
	private function current_url() {
		
		//global $_SERVER;

		$pageURL = 'http';
		//if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}

		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
}  
