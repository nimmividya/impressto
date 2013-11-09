<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Events_Search {

    protected $ci;

    protected $fallbacks = array();

    public function __construct()
    {
        $this->ci =& get_instance();
		

		
        //register the page_manager_save event
        Events::register('delete_content', array($this, 'deleteindex_content'));
		Events::register('add_content', array($this, 'add_content'));
		Events::register('reindex_content', array($this, 'reindex_content'));
		
    }

	/**
	* 
	* @package /modules/search
	*/
	public function deleteindex_content( $content_module, $content_id)
    {
        $CI =& get_instance();	
		
    }
	
	/**
	* 
	* @package /modules/search
	*/
	public function add_content( $content_module, $content_id)
    {
        $CI =& get_instance();	
		
    }
	
	/**
	* 
	* @package /modules/search
	*/
	public function reindex_content( $content_module, $content_id)
    {
        $CI =& get_instance();	
		
    }
	
}
/* End of file events.php */