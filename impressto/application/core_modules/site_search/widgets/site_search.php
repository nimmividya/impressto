<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// sample tags
//  [widget type='bg_pos_slider/bg_widget' bgcolor='#AA22FF' title=wawaewa]
//  direct from PHP cde Widget::run('image_slider, array()'name'=>'widget_1')
// within smarty {widgets type='image_slider' name='widget1'}

// when viewing a full news item, this widget can be set to displayfull mode

class site_search extends Widget
{


	function run() {
		
		$args = func_get_args();


		$data = array();
		
		
		// if paramaeters have been passed to this widget, assign them	
		if(isset($args[0]) && is_array($args[0])){
			
			$widget_args = $args[0];
			
		}else{
			
			$widget_args = array();
			
		}
		

		$this->load->library('asset_loader');
		$this->load->library('highlighter');
		$this->load->library('impressto');
		$this->load->library('im_pagination');
		
		
		//add the path for the widgets module so we can locate the models	
		$this->load->_add_module_paths('site_search');
		$this->load->model('site_search_model');
		
		
		
		$case_sensitive = FALSE;
		$matchall = TRUE;
		

		$this->highlighter->casesensitive = $case_sensitive;
		$this->highlighter->extracts = true;
		$this->highlighter->matchall = $matchall;
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/core_modules/site_search/js/site_search.js");

		
		$this->lang->load('site_search', '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');	

		
		
		$moduleoptions = ps_getmoduleoptions('site_search');

		$lang_avail = $this->config->item('lang_avail');
					
		foreach($lang_avail AS $langcode=>$language){
			$data['search_page_' . $langcode] = $moduleoptions['search_page_' . $langcode];
		}	

		$data['search_page'] = $data['search_page_' . $this->language];
		
		if($this->input->get_post('listings_per_page') != "") $moduleoptions['listings_per_page'] = $this->input->get_post('listings_per_page');
	
		$data['listings_per_page'] = $moduleoptions['listings_per_page'];
		
		$data['template'] = $moduleoptions['search_template'];
		

				
		//$data['search_page'] = $moduleoptions['search_page'];
				
		$data['sortmethod'] = $moduleoptions['sortmethod'];
		
		if(isset($moduleoptions['content_filters']) && $moduleoptions['content_filters'] != ""){
			$moduleoptions['content_filters'] = unserialize( $moduleoptions['content_filters'] );
		}else{
			
			$moduleoptions['content_filters'] = array();
			
		}
		
		
		
		$data['module'] = 'site_search';
		$data['is_widget'] = TRUE;
		
		$template = $this->template_loader->find_template($data); 
		
		$prevtpldir = $this->impressto->getDir();
		
		$this->impressto->setDir(dirname($template));
		
		$template_file = basename($template);
		
		

		
		$page = $this->input->get_post('searchpage');
		
		if($page == "") $page = 1;
		
		$keywords = trim($this->input->get_post('keywords'));
		
		$tag = trim($this->input->get_post('tag'));
		
		$data['keywords'] = $keywords;
		$data['tag'] = $tag;
		
		$data['lang'] = $this->language;
		
		
		$keyterms = array();
		
		if($keywords != "") $keyterms = explode(" ",$keywords . " ");
		
		
		$data['active_content_types'] = $this->site_search_model->get_active_content_types();

		$data['pagination_method'] = $moduleoptions['pagination_method'];
		
		
		$data['content_filters'] = ( $this->input->get_post('search_content_filters')
		&& 
		is_array($this->input->get_post('search_content_filters')))
		? $this->input->get_post('search_content_filters')
		: $moduleoptions['content_filters'];
		
		$data['booleanseach'] = ($this->input->get_post('booleanseach')) ? 1 : 0;
		

		$data['resultrows'] = "";
		$data['searchresults_wrapper'] = "";
		
		$searchdata = array(
			'page' => $page,
			'listings_per_page' => $moduleoptions['listings_per_page'],
			'traillength' => $moduleoptions['traillength'],
			'content_filters' => $data['content_filters'],
			'booleanseach' => $data['booleanseach'],
			'lang' => $this->language,
		);
			
			
		if(count($keyterms) > 0){
			
			$searchdata['keyterms'] = $keyterms;
			
			$data['searchterm'] = implode(" ",$keyterms);
			
			
			$srecords = $this->site_search_model->get_search_results($searchdata);
			
		}else if( $tag != ""){
	
			$searchdata['tag'] = $tag;
			
			$data['searchterm'] = "TAG > $tag";
			
			$srecords = $this->site_search_model->get_tag_results($searchdata);
					
		}
		
		$data['count_from'] = isset($srecords['count_from']) ? $srecords['count_from'] : 0;
		$data['count_to'] =  isset($srecords['count_to']) ? $srecords['count_to'] : 0;
		
		
		
		if (isset($srecords['numrecords']) && $srecords['numrecords'] > 0){
			
			
			$data['numrecords'] = $srecords['numrecords'];
			
			
			
			$config['max'] = $srecords['numrecords'];
			$config['maxperpage'] = $moduleoptions['listings_per_page'];
			$config['page'] = $page;
			$config['seperator'] = "|";
			$config['maxpagesperpage'] = 10;
			$config['pager_id'] = 'random';
			$config['anchor'] = "";
			$config['script'] = FALSE; //"ps_blog.changepage";		
			$config['doajax'] = "";	
			$config['page_varname'] = "searchpage";	
			
			$config['css_ul_class'] = "";
			$config['css_ul_active_class'] = "active";			
			$config['css_li_disabled_class'] = "disabled";	
			
			
			//if($data['numrecords'] < $config['maxperpage']) $data['count_to'] = $data['numrecords'];
			//else $data['count_to'] = $data['numrecords'] * $page;
			

			/* STYLING */
			$config['previmg'] = "pageprev.gif";
			$config['nextimg'] = "pagenext.gif";
			$config['asset_url'] = ASSETURL . "public/default/images/";
			
			if($moduleoptions['pagination_method'] == "ajax"){
				$config['script'] = "ps_sitesearch.turnpage";
				//$config['params'] = array('keywords', implode(" ",$keyterms));
				
			}
			
			
			
			
			$this->im_pagination->initialize($config); 	
			
			$data['paginator'] =  $this->im_pagination->create_links();
			
			$rowindex = 1;
			
			
			foreach ($srecords['records'] as $rowdata){

				$rowdata['rowindex'] = $rowindex;
		
				$rowdata['search_page'] = $data['search_page_' . $this->language];
				
				$data['resultrows'] .= $this->impressto->showpartial($template_file,'SEARCHRESULTITEM',$rowdata);
				
				$rowindex ++;
				
			}
			
			$data['resultsdisplay'] = $this->impressto->showpartial($template_file,'SEARCHRESULTS_WRAPPER',$data);
			
			
		}else{ 
			$data['resultsdisplay'] = $this->impressto->showpartial($template_file,'NORESULTS',$data);
		}
		
		

		$data['searchfilterbox'] = $this->impressto->showpartial($template_file,'SEARCHFILTERBOX',$data);
		
		
		echo $this->impressto->showpartial($template_file,'MAINLAYOUT',$data);
		
		$this->impressto->setDir(dirname($prevtpldir ));
		

		
		
	}
	
	



}  





