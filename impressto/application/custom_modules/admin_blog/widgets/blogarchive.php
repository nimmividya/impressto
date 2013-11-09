<?php

// sample tags
//  [widget type='admin_blog/blogarticle']
//  direct from PHP cde Widget::run('admin_blog/blogarticle, array()'name'=>'widget_1')
//  within smarty {widgets type='admin_blog/blogarticle' name='widget1'}
//  when viewing a full blog item, this widget can be set to displayfull mode

class blogarchive extends Widget
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
				
		
		$this->load->library('widget_utils');
				
		$this->load->helper('im_helper');
		
		$args = func_get_args();
		

		
		$lang_selected = $this->config->item('lang_selected');
	
        // if paramaeters have been passed to this widget, assign them	and override the defaults for this widget instance
		if(isset($args[0]) && is_array($args[0])){
		
			$widget_args = $args[0];
					
			if(isset($args[0]['name'])) $data['name'] = $args[0]['name'];
			
		}

	
		////////////////////////////////
		// peterdrinnan - May 21, 2012
		//add the path for the widgets module so we can locate the models	
		$this->load->_add_module_paths('admin_blog');
		$this->load->model('blog_model');
		
		// If the widget is being called form a shortcode and there is no ID, get the id 
		if(!isset($widget_args['widget_id']) && isset($data['name'])) 
			$widget_args['widget_id'] = $this->widget_utils->getwidgetid('blogarchive', 'admin_blog', $data['name']);
		
		// load the blog widget language file now...
		$this->lang->load('blog_widgets', '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');	
				
		$widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);
		
		
		
		
		$moduleoptions = ps_getmoduleoptions('admin_blog');
		
		
		$data['archived_blog_page_url'] = $this->remove_querystring_var($this->current_url(), 'blog_pager');
		
					
		
		
		if(!isset($moduleoptions['blog_listlimit'])){
		
			$moduleoptions['blog_listlimit'] = 10; // just a default
			
		}
		
		//$moduleoptions['blog_listlimit'] = 0;
		
		
		$data['search_keywords'] = "";
					

		if(!isset($moduleoptions['blog_title_' . $lang_selected])){
		
			$data['blogpagetitle'] = ""; 
			
		}else{
			$data['blogpagetitle'] = $moduleoptions['blog_title_' . $lang_selected];
		}
		
		
		$data['target_page'] = $moduleoptions['admin_blog_archive_page_' . $lang_selected];
		
		
	
		$data['blog_pager'] = 1;
				
		if($this->input->get_post('blog_pager') != ""){
			$data['blog_pager'] = $this->input->get_post('blog_pager') ;
		}
		
		
		if($this->input->get_post('blog_id') != ""){
		
			$data['blog_id'] = $this->input->get_post('blog_id');
		
			// simply load the specificed article into the view and don't bother with listing anything else
			$data['blogitem'] = $this->blog_model->get_blog_item($data['blog_id']);
					
			
			
		}else if ($this->input->get_post('blog_tag') != ""){
		
			$data['blog_tag'] = $this->input->get_post('blog_tag');
		
			$newsrecords = $this->blog_model->get_archived_items('', $data['blog_tag'],$data['blog_pager'], $moduleoptions['blog_listlimit']);
			
			$data['blogitems'] = $newsrecords['limitedrecords'];
			$data['totalblogcount'] = $newsrecords['totalrowcount'];

			
			
		}else if ($this->input->get_post('blog_search_keywords') != ""){
		
			$data['search_keywords'] = $this->input->get_post('blog_search_keywords');
		
			// proces the list view with keyword search
			
			
			$blogrecords = $this->blog_model->get_archived_items($this->input->get_post('blog_search_keywords'),'',$data['blog_pager'], $moduleoptions['blog_listlimit']);
			
			$data['blogitems'] = $blogrecords['limitedrecords'];
			$data['totalblogcount'] = $blogrecords['totalrowcount'];
			
			
		}else{
		
					
			// regular full list
			$blogrecords = $this->blog_model->get_archived_items('','',$data['blog_pager'], $moduleoptions['blog_listlimit']);
			
			$data['blogitems'] = $blogrecords['limitedrecords'];
			$data['totalblogcount'] = $blogrecords['totalrowcount'];
			
		
		}
		
		
	
		// DO NOT USE $this->render unless you want to simply show PHP files
		//$this->render("blogticker/" . $widget_options['template'],$data);
		
		$data['moduleoptions'] = $moduleoptions;

		$data['template'] = $widget_options['template'];
		
		$data['module'] = 'admin_blog';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'blogarchive';			
		
		

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
	
	
	private function remove_querystring_var($url, $key) { 
	
		$url = preg_replace('/(.*)(\?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&'); 
	
		$url = rtrim($url, '?');
		$url = rtrim($url, '&');
				
	
		return $url; 
	}
	
	
	
}  
