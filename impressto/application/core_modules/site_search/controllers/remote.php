<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class remote extends PSBase_Controller {


	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');
		is_logged_in();
		
		
		
		$this->load->model('site_search_model');
		
		
				
		
	}
	
	
	public function process_search(){
	
	
		$keywords = $this->input->get_post('keywords');
		$searchpage = $this->input->get_post('searchpage');
		$lang = $this->input->get_post('lang');
		

		$data = array();

		$this->load->library('highlighter');
		$this->load->library('template_loader');
		$this->load->library('impressto');
				
		$this->load->library('im_pagination');
		
		$this->load->helper('im_helper');
		
		$this->load->model('site_search_model');
			
		
		$case_sensitive = FALSE;
		$matchall = TRUE;
		

		$this->highlighter->casesensitive = $case_sensitive;
		$this->highlighter->extracts = true;
		$this->highlighter->matchall = $matchall;

	
		
		$this->lang->load('site_search'); //, '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');	
				
		
		$moduleoptions = ps_getmoduleoptions('site_search');
		
		
		$data['template'] = $moduleoptions['search_template'];
		$data['search_page'] = $moduleoptions['search_page'];
		$data['sortmethod'] = $moduleoptions['sortmethod'];
		
		$data['module'] = 'site_search';
		$data['is_widget'] = TRUE;
		
		$template = $this->template_loader->find_template($data); 
		
		$prevtpldir = $this->impressto->getDir();
					
		$this->impressto->setDir(dirname($template));
		
		$template_file = basename($template);
		
					
		$page = $this->input->get_post('searchpage');
				
		if($page == "") $page = 1;
		
		$keywords = trim($this->input->get_post('keywords'));
				
		$keyterms = array();
		
		
		
				
		if($keywords != "") $keyterms = explode(" ",$keywords . " ");
		
		
		$data['content_filters'] = ( $this->input->get_post('search_content_filters')
		&& 
		is_array($this->input->get_post('search_content_filters')))
		? $this->input->get_post('search_content_filters')
		: $moduleoptions['content_filters'];
		
		$data['booleanseach'] = ($this->input->get_post('booleanseach')) ? 1 : 0;
		
					
		
		$data['searchfilterbox'] = $this->impressto->showpartial($template_file,'SEARCHFILTERBOX',$data);
		$data['resultrows'] = "";
		$data['searchresults_wrapper'] = "";
		
						
		if(count($keyterms) > 0){
		
			$searchdata = array(
				'keyterms' => $keyterms,
				'page' => $page,
				'listings_per_page' => $moduleoptions['listings_per_page'],
				'traillength' => $moduleoptions['traillength'],					
				'content_filters' => $data['content_filters'],
				'booleanseach' => $data['booleanseach'],
				'lang' => $lang,
			);
			
				
			$srecords = $this->site_search_model->get_search_results($searchdata);
			
			
			if ($srecords['numrecords'] > 0){
			
			
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
		
							
				foreach ($srecords['records'] as $rowdata){

					$data['resultrows'] .= $this->impressto->showpartial($template_file,'SEARCHRESULTITEM',$rowdata);
				
				}
							
				$data['resultsdisplay'] = $this->impressto->showpartial($template_file,'SEARCHRESULTS_WRAPPER',$data);
							
				
			}else{ 
				$data['resultsdisplay'] = $this->impressto->showpartial($template_file,'NORESULTS',$data);
			}
						
		}
		
		
		echo $data['resultsdisplay'];
		
		
	
	}
	
	
	

	
	
	
	
	
	
}