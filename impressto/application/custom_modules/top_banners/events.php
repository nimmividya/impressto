<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Events_Top_banners {

    protected $ci;

    protected $fallbacks = array();

    public function __construct()
    {
        $this->ci =& get_instance();
		
        //register the page_manager_save event
        Events::register('page_manager_save', array($this, 'save_published_data'));
        Events::register('page_manager_save_draft', array($this, 'save_draft_data'));
		
    }

    public function save_published_data($data = array())
    {
        $this->ci =& get_instance();

		return " saying something here ";
		
		//	return TRUE;

    }
	
    public function save_draft_data($data = array())
    {
        $this->ci =& get_instance();

		return " saying something else here ";
		
		//	return TRUE;

    }
	
	
}
/* End of file events.php */