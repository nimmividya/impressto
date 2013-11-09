<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
*
*/
class admin_remote extends PSRemote_Controller {

	public function __construct(){
		
		parent::__construct();
		
		
		$this->load->helper('auth');
		
		is_logged_in();
		
		
		$this->load->model('madmincontent');

		
		$this->load->plugin('widget');
		$this->load->plugin('admin_widget');
		
		$this->load->model('site_settings/site_settings_model');
		
		
	}
	
	/**
	* default management page
	*
	*/
	public function filter_orderlist(){
		
		$this->load->model('admin_users/mUsers');
		
		
		$lang = $this->input->get_post('lang');
		$keyword = $this->input->get_post('keyword');
		
		
		$content_table = $this->db->dbprefix . "content_" . $lang;

		$keyword_match_nodes = array();
		
		$sql = "SELECT CO_Node FROM {$content_table} ";
		$sql .= " WHERE CO_seoTitle LIKE '%{$keyword}%' ";
		$sql .= " OR CO_MenuTitle LIKE '%{$keyword}%'";
		$sql .= " OR CO_Body LIKE '%{$keyword}%'";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row){
				$keyword_match_nodes[] = $row->CO_Node;
			}
		}
		

		
		$orderlist = $this->madmincontent->get_orderlist( array("lang"=>$lang,"keyword"=>$keyword,"keyword_match_nodes"=>$keyword_match_nodes) );
		
		$parent_nodes = array();

		if(count($keyword_match_nodes) > 0){
			
			foreach($keyword_match_nodes as $node_id){
				
				$parent_ids = $this->adjacencytree->getParentIDs($node_id);
				
				$parent_nodes = array_merge($parent_nodes,$parent_ids);
				$parent_nodes[] = $node_id;
				
			}
			
			
			$parent_nodes = array_unique($parent_nodes);
			sort($parent_nodes);
			
			
		}
		
		
		
		
		echo "<ul id=\"u_1\"><li>" . $orderlist['pageitems'] . "</li></ul>";
		echo "<script>\n";
		echo " var reveal_nodes = '" . implode(",",$parent_nodes) . "';  ";
		echo " $(function() {\n";
		echo "   	psctntmgr.reveal_orderlist(reveal_nodes); \n";
		
		if(count($keyword_match_nodes) > 0){
			echo "  	$('html,body').animate({scrollTop: $(\"#page_anchor_\"+" . $keyword_match_nodes[0] . ").offset().top},'slow'); \n";
		}
		
		echo " }); ";
		echo "\n</script>";
		
		
	}

	/**
	* This respondes specifically to the Tiny_mce "external_link_list_url" call to provide a list of internal pages that 
	* can be easily linked to.
	*
	* See: /application/views/tiny_mce_init.php
	*
	*/
	public function tiny_mce_page_list($lang = ''){
		
		// this is not actually an AJAX call so we must turn the profiles off manually
		$this->config->set_item('debug_profiling',FALSE);
		$this->output->enable_profiler(FALSE);

		$this->load->library('edittools');
			
		// we are going to do some javascript acrobatics here
		
		$lang_avail = $this->config->item('lang_avail');

		$outbuf = "";
		
		if($lang != "") $outbuf .= " if(window.parent.ps_editorlang == '') window.parent.ps_editorlang = '{$lang}'; "; 
		
		// we basically load up all the lists for all languages of this site so we can
		// toggle between them when switching editors
		
		foreach($lang_avail AS $langcode=>$language){ 
		
			
			$outbuf .= " if(window.parent.ps_editorlang == \"{$langcode}\"){ ";
			
			$outbuf .= "  var tinyMCELinkList = new Array( ";
			$outbuf .= "  // Name, URL\n";
			
			$data['language'] = $langcode; // this will need to switch to fr is we are in french content somehow....
			$data['use_ids'] = FALSE; // this will need to switch to fr is we are in french content somehow....

			$content_page_list = $this->edittools->get_content_page_list($data);
			
			//$nodes = array("Select"=>"");
			//$colors = array("Select"=>"");
			//$textcolors = array("Select"=>"");
			
			$pages = array();
			
			foreach($content_page_list AS $node_data){
				
				$pages[] = "  [\"" . $node_data['code_indent'] . $node_data['label'] . "\", \"" . $node_data['link'] . "\"]";
			}
			
			$outbuf .= implode(",",$pages);
			
			$outbuf .= "  ); ";
						
			$outbuf .= "} ";
			
		}

		echo $outbuf;
		
	}
	
	/**
	*
	*
	*/
	public function remove_featured_image($page_id, $lang, $media){
	
		
	
		$content_table = $this->db->dbprefix . "content_" . $lang;
		
		if($media == "standard") $media = "";
		else  $media =  $media  . "_";
						
		$data = array( $media . "featured_image" => "");
				
		$this->db->where('CO_Node', $page_id);
		$this->db->update($content_table, $data); 
				
		echo "deleted";
	
	}
	
	
	
	/**
	* Regenerates the sitemap.xml file by reading the search index table
	*
	*/
	public function build_xml_sitemap(){
		
		
		$this->load->model('site_search/site_search_model');
		
		$this->load->spark('sitemaps'); // make sure there is an autoload file
		
		$this->load->library('sitemaps');
		
		$this->load->model('admin_users/mUsers');
		
		
		
		// need to loop through all languages to make sure all pages are indexed.
		$lang_avail = $this->config->item('lang_avail');
		
		
		foreach($lang_avail AS $langcode=>$language){
			
			$search_indexes = $this->site_search_model->get_indexed_content_list( array('lang' => $langcode, 'return_fields' => array('slug','updated','change_frequency','priority')) );
			
			foreach ($search_indexes AS $item){
				
				
				if($item['priority'] < 10){
					$item['priority'] = $item['priority'] . ""; // recast to string
					if(strlen($item['priority']) == 1) $item['priority'] = "0." . $item['priority'];
				}
				
				switch($item['change_frequency']){
					
				case 0 : $item['change_frequency'] = "hourly";
					break;
				case 1 : $item['change_frequency'] = "daily";
					break;
				case 2 : $item['change_frequency'] = "weekly";
					break;
				case 3 : $item['change_frequency'] = "monthly";
					break;
				case 4 : $item['change_frequency'] = "yearly";
					break;
				}	
				
				
				if($item['slug'] != ""){
					
					$item = array(
					"loc" => site_url("{$langcode}/" . $item['slug']),
					"lastmod" => date("Y-m-d", strtotime($item['updated'])),
					"changefreq" => $item['change_frequency'],
					"priority" => $item['priority'],
					);
					
					$this->sitemaps->add_item($item);
					
				}
			}
			
			
			
		}


		// file name may change due to compression
		$file_name = $this->sitemaps->build(getenv("DOCUMENT_ROOT") . "/sitemap.xml");
		$reponses = $this->sitemaps->ping(site_url($file_name));


		
		
		
	}
	
	
	
	

} //end class