<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class remote extends PSBase_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->helper('auth');
		is_logged_in();
		
		$this->load->library('session');
				
		$this->load->model('mUsers');
	}
	
	/**
	* returns an ajax called HTML layout
	*
	*/
	public function list_roles(){
	
	
		$this->load->helper('im_helper');
			
		
		$this->load->library('template_loader');
		$this->load->library('formelement');
		
		
		
		$roledata = array();
		
		$sql = "SELECT roles.*, users.id FROM {$this->db->dbprefix}user_roles AS roles ";
		$sql .= " LEFT JOIN {$this->db->dbprefix}users AS users on roles.id = users.role GROUP BY roles.id";
				
		$query = $this->db->query($sql);
				
		// need to check the users table to see if any users are associated with this role
		
		foreach ($query->result() as $row)
		{
		
			//print_r($row);
		
			$roledata[] = array("id"=>$row->id,"name"=>$row->name,"description"=>$row->description,"user_id"=>$row->user_id,"num_users"=>0);
			
		}
		
			

		
		$data['roledata'] = $roledata;
	
		$this->load->view('partials/list_roles', $data);
	

	}
	
	
	/**
	*
	*
	*/
	public function edit_role_assignment($role_id){
	
	
		// get the list of extended user fields/
		
		
		
		$extended_user_fields = $this->mUsers->get_extended_user_fields();
		
			
		$role_assignments = array();
		
		$query = $this->db->select('field_id')->from('user_role_fields')->where('role_id', $role_id)->get();
					
		foreach ($query->result_array() as $row){

			$role_assignments[] = $row['field_id'];
		}
					
		foreach ($extended_user_fields as $key => $val){
		
			if($key != "error"){

				if(in_array($val['field_id'],$role_assignments)){
					$extended_user_fields[$key]['selected'] = 1;
				}
			}
		}			

		echo json_encode($extended_user_fields);
		
			
	}
	
	
	
	
	/**
	* create a new user roles
	*
	*/
	public function save_role(){
	
		//role name, descrition
		
		$data['id'] = $this->input->post('id');
		$data['name'] = $this->input->post('name');
		$data['description'] = $this->input->post('description');
		$data['role_theme'] = $this->input->post('role_theme');
		$data['profile_template'] = $this->input->post('profile_template');
		$data['dashboard_template'] = $this->input->post('dashboard_template');
		$data['dashboard_page'] = $this->input->post('dashboard_page');

		
		
		$this->mUsers->save_role($data);
					

	}
	
	
	/**
	* create a new user roles
	*
	*/
	public function edit_role($id){
	
	
		$role_data = $this->mUsers->getroledata($id);
		
		if($role_data && is_array($role_data)) echo json_encode($role_data); 
				

	}
	
	
	public function delete_role($id){
	
		$this->mUsers->delete_role($id);
		
		$this->list_roles();
		
		
		
		
	}
	

	
	
	/**
	* returns an ajax called HTML layout
	*
	*/
	public function reorder_userfields(){
	
	
		$extended_fields = $this->input->post('extended_fields');
		
		
		$p = 0;
	
		foreach($extended_fields  as $id){
			
			if(is_numeric($id)){
			
				$sql = "UPDATE {$this->db->dbprefix}user_fields SET position = '{$p}' WHERE id = '{$id}'";
				$this->db->query($sql);
				$p++;
			}
		}   
		
	
	}
	
	
	/**
	* returns an ajax called HTML layout
	*
	*/
	public function list_userfields($role_id = ''){
		
	
		$this->load->helper('im_helper');
			
		
		$this->load->library('template_loader');
		$this->load->library('formelement');
		
		
		
		$userfielddata = array();
		
		$profile_data = $this->db->field_data($this->config->item('profile_table'));
		
		foreach($profile_data AS $field){
		
		
			$userfielddata[$field->name] = array(
				'field_name' => $field->name,
				'data_type' => $field->type,
				'max_length' => $field->max_length,
			);
				
		}

		if($role_id != ""){
			$this->db->join('user_role_fields', 'user_fields.id = user_role_fields.id', 'left')
					->where('user_role_fields.role_id', $role_id);
									
		}
				
		
		$query = $this->db->select('user_fields.id, user_fields.field_name, user_fields.input_type')
						->from('user_fields')

						->group_by("user_fields.id")
						->order_by("user_fields.position", "asc")
						->get();
												

		$sorted_userfielddata = array();
		
		foreach ($query->result() as $row){
		
			$userfielddata[$row->field_name]['field_id'] = $row->id;
			$userfielddata[$row->field_name]['input_type'] = $row->input_type;
		
			$sorted_userfielddata[] = $userfielddata[$row->field_name];
			
			
		}
		
	
		$data['userfielddata'] = $sorted_userfielddata;
	
		$this->load->view('partials/user_fields', $data);
	

	}
	
	
	
	/**
	* create a new user userfields
	*
	*/
	public function edit_userfield($field_id = ''){
	
	
		$result_array = array();
		
		$data = array("field_id" => $field_id);
				
		$data['field_options'] = "";
		
		$data['input_type'] = "";
		$data['field_name'] = "";
		$data['field_label'] = "";
		$data['default_value'] = "";
		$data['field_value'] = "";
		$data['disabled'] = "";
		$data['showlabel'] = "";
		$data['visible'] = "";
		$data['active'] = "";
		$data['width'] = "";
		$data['height'] = "";
		$data['orientation'] = "";	
		$data['onchange'] = "";			
		$data['required'] = "";		
		
		
		// get the field, then get the options of they apply
		$query = $this->db->get_where('user_fields', array('id' => $field_id));
		
		if ($query->num_rows() > 0)
		{

			$row = $query->row();
			
			
			$data['field_name'] = $row->field_name;
			$data['paragraph'] = $row->paragraph;	
				
			$data['active'] = $row->active;
			$data['visible'] = $row->visible;
			
			
			
			$data['width'] = $row->width;
			$data['height'] = $row->height;
			$data['orientation'] = $row->orientation;
			$data['onchange'] = $row->onchange;
			
			
			
			$data['input_type'] = $row->input_type;
			$data['required'] = $row->required;
			
			
			$data['field_value'] = $row->field_value;
			$data['default_value'] = $row->default_value;
		
			$options_array = array();
			
			$this->db->order_by("position", "desc"); 
			$sub_query = $this->db->get_where('form_builder_element_options', array('element_id' => $field_id));
			
		
			if($data['input_type'] == "dropdown" || $data['input_type'] == "radio"){
				
				$data['field_options'] = $this->load_user_field_options($data['input_type'], $field_id,  FALSE);
			}
			
		}else{
		
			// these are the defaults for new fields
			$data['active'] = 1;
			$data['visible'] = 1;
			$data['input_type'] = "text";
			$data['width'] = 100;
			$data['paragraph'] = "";	
					
			
			
		}
		
		
		$data['active_check'] =  $data['active'] == 1 ? " checked " : "";
		$data['disabled_check'] =  $data['disabled'] == 1 ? " checked " : "";
		$data['visible_check'] =  $data['visible'] == 1 ? " checked " : "";
		$data['required_check'] =  $data['required'] == 1 ? " checked " : "";
		$data['showlabel_check'] =  $data['showlabel'] == 1 ? " checked " : "";
		
		
		
		$this->load->library('formelement');
		
		$fielddata = array(
		'name'        => "input_type",
		'id'          => "input_type",
		'type'          => 'select',
		'showlabels'          =>  FALSE,	
		'onchange'          =>  "userfield_manager.set_field_type(this)",	
		'usewrapper'          => TRUE,
		'options' => array(
		"Text" => "text"
		,"Email" => "email"
		,"Textarea" => "textarea"
		,"Checkbox" => "checkbox"
		,"Checkboxes" => "multicheck"
		,"Radio" => "radio"
		,"Dropdown" => "dropdown"
		,"Multiselect-Dropdown" => "multiselect"
		,"static Content" => "static_content" // this is not a field but rather a place to put content
		,"Date" => "date"
		
		),
		'value' => $data['input_type'],
		);
		
		
		$data['ftype_selector'] = $this->formelement->generate($fielddata);
		
		
		
		$fielddata = array(
		'name'        => "field_orientation",
		'id'          => "field_orientation",
		'type'          => 'select',
		'showlabels'          =>  FALSE,	
		'onchange'          =>  "userfield_manager.set_orientation(this)",	
		'usewrapper'          => TRUE,
		'options' => array(
			"Horizontal" => "horizontal",
			"Vertical" => "vertical",
		),
		'value' => $data['orientation'],
		);
		
		
		$data['orientation_selector'] = $this->formelement->generate($fielddata);
		
		$display_none = "display:none";
		
		$data['fedit_height_display'] = "";
		$data['fedit_width_display'] = "";
		$data['fedit_onchange_display'] = "";
		$data['fedit_orientation_display'] = "";
		$data['fedit_field_value_display'] = "";
		$data['fedit_default_value_display'] = "";		
		

		
		
		switch($data['input_type']){
		
			case "text":
			case "email":
		
				$data['fedit_height_display'] = $display_none;
				$data['fedit_onchange_display'] = $display_none;
				$data['fedit_field_value_display'] = $display_none;
			
			break;
			
			case "textarea":
			
				$data['fedit_onchange_display'] = $display_none;
				$data['fedit_field_value_display'] = $display_none;
				
	
			break;
			
			case "checkbox":
			
				$data['fedit_height_display'] = $display_none;
				$data['fedit_width_display'] = $display_none;
				//$data['fedit_orientation_display'] = $display_none;
				
		
			break;
	
			case "radio":
			case "dropdown":
			
			
				$data['fedit_height_display'] = $display_none;
				$data['fedit_field_value_display'] = $display_none;
				
				
				
				break;
		
			
			case "date":
		
				
				$data['fedit_height_display'] = $display_none;
				$data['fedit_width_display'] = $display_none;
				//$data['fedit_orientation_display'] = $display_none;
				$data['fedit_field_value_display'] = $display_none;
				
				
				
			break;
			
		
		}
		
		
		echo $this->load->view('partials/field_editor', $data, TRUE); 
		
				

	}
	
	
	public function delete_user_field($id){
	
		//$this->mUsers->delete_userfield($id);
		
		//$this->list_userfields();
		
		
		
		
	}
	
	
	public function filter_user_fields($role){
	
			
		$this->list_userfields();
		

		
	}
	
	
	
	public function delete_option($option_id, $input_type, $field_id = ''){
		
		if($field_id == "" || $field_id < 1) $field_id = 10000000 + $this->session->userdata('id');
		
		$sql = "DELETE FROM {$this->db->dbprefix}user_field_options WHERE option_id = '{$option_id}'";
		
		$this->db->query($sql);
		
		echo $this->load_user_field_options($input_type, $field_id);
		
		
	}
	
	
	/**
	*
	*
	*/
	public function update_field_option_positions(){
	
		$options = $this->input->post('option');
		
		$p = 0;
	
		foreach($options  as $id){
				
			$sql = "UPDATE {$this->db->dbprefix}user_field_options SET position = '{$p}' WHERE option_id = '{$id}'";
						
			$this->db->query($sql);
			
				
			$p++;
			
		}   

	}

	

	public function add_field_option($name, $value, $input_type, $field_id = ''){
		
		$this->load->library('formelement');
		$this->load->library('impressto');
		
		$this->impressto->setDir(dirname(dirname(__FILE__)) . "/views/partials");
		
		
		
		if($field_id == "" || $field_id < 1) $field_id = 10000000 + $this->session->userdata('id');
		
		$position = 0; // for now...
		
		$sql = "INSERT INTO {$this->db->dbprefix}user_field_options (";
		$sql .= "field_id,";
		$sql .= "option_value,";
		$sql .= "option_label,";
		$sql .= "position";
		$sql .= ") VALUES (";
		$sql .= "'{$field_id}',";
		$sql .= "'{$value}',";
		$sql .= "'{$name}',";
		$sql .= "'{$position}'";
		$sql .= ");";
		
		$this->db->query($sql);
		
		$data['option_id'] = $this->db->insert_id();
					
		//if($default_value == $this_option_value){
		//	$data['defaultstaractiveflag'] = " active";
		//}else{
			$data['defaultstaractiveflag'] = "";
		///}
				
		$data['option_value'] = $value;			
		$data['option_label'] = $name;
				
				
		//echo $this->load_field_options($input_type, $field_id);
		
		echo $this->impressto->showpartial('optionspanel.tpl.php','FIELDOPTIONSITEM', $data); 
				
				
		
		
		
	}
	
	
	/**
	* 
	*
	*
	*/
	public function load_user_field_options($field_type, $field_id = '', $display = TRUE){
			
		if($field_type != "radio" && $field_type != "dropdown" && $field_type != "multiselect") return;
		
		
		$this->load->library('formelement');
		$this->load->library('impressto');
		
		$data = array();	
		
		$prevtamplatedir = $this->impressto->getDir();
		$this->impressto->setDir(dirname(dirname(__FILE__)) . "/views/partials");
		
		if($field_id == "" || $field_id < 1){
		
			$field_id = 10000000 + $this->session->userdata('id');
			$default_value = "";
			
		}else {
		
			$sql= "SELECT default_value FROM {$this->db->dbprefix}user_fields WHERE id = '{$field_id}'";
			$default_value = $this->db->query($sql)->row()->default_value;
		}
		
		
		
		$data['core_asset_url'] = ASSETURL . "/" . PROJECTNAME . "/default/core";
		$data['mod_asset_url'] = ASSETURL . "/" . PROJECTNAME . "/default/custom_modules/contact_form/";
		
		
		$data['fieldoptionitems'] = "";
		
	

		
				
		
		$sql= "SELECT * FROM {$this->db->dbprefix}user_field_options WHERE field_id = '{$field_id}' ORDER BY position";

		
		$query = $this->db->query($sql);
		
		$options_array = array();
		
		$data['i'] = 1;
		
		if($query && $query->num_rows() > 0){
			
			foreach ($query->result() as $row){
				
				//echo

				
				$data['option_id'] = $row->option_id;
				$this_option_value = $row->option_value;
				$this_option_label = $row->option_label;
				$this_option_position = $row->position;
				
				if($default_value == $this_option_value){
					$data['defaultstaractiveflag'] = " active";
				}else{
					$data['defaultstaractiveflag'] = "";
				}
				
				$data['option_value'] = $this_option_value;			
				$data['option_label'] = $this_option_label;
				
		
				

				$data['fieldoptionitems'] .= $this->impressto->showpartial('optionspanel.tpl.php','FIELDOPTIONSITEM', $data); 
				
				
				$data['i'] ++;
				
				
			}
			
			
			
		}else{
			
			$data['defaulticon'] = "stardim.gif";
			
		}
		
		
		
		if(isset($data['addoption']) &&  $data['addoption'] == 1){
			
			$data['defaulticon'] = "stardim.gif";
			$data['option_id'] = "";
			$data['option_value'] = "value ".$data['i'];			
			$data['option_label'] = "label ".$data['i'];
			$data['fieldoptionitems'] .= $this->impressto->showpartial('optionspanel.tpl.php','FIELDOPTIONSITEM', $data); 
			
		}
		

		$fielddata = array(
		'name'        => "felement_ischecked",
		'id'          => "felement_ischecked",
		'type'          => 'checkbox',
		'label'          => 'Forward',	
		'showlabels'          =>  FALSE,	
		'onclick'          =>  "ps_contact_form_manager.updatecheckboxdefault(this)",	
		'usewrapper'          => TRUE,
		'options' => ( isset($data['option_value']) ? $data['option_value'] : null),
		'value' => (isset($data['felement_value']) ? $data['felement_value'] : "")
		);
		
		
		$data['felement_ischecked_field'] = $this->formelement->generate($fielddata);
		
		
		
		$outbuf = $this->impressto->showpartial('optionspanel.tpl.php','FIELDOPTIONSPANELHEAD', $data);
		
		$outbuf .= $this->impressto->showpartial('optionspanel.tpl.php','FIELDOPTIONSPANEL', $data);

		$outbuf .= $this->impressto->showpartial('optionspanel.tpl.php','FIELDOPTIONSPANELFOOT', $data);
		
		
		$this->impressto->setDir($prevtamplatedir);
		
		if($display) echo $outbuf;
		else return $outbuf;
		
		
	}/////////////////////////////////////
	
	
	/**
	* Processes an ajax request to update advanced user settings
	*
	*
	*/
	public function save_advanced_settings(){

		
		if( is_array($this->input->post('priority_fields')) ){
		
			
		}
		
		
		if(is_array($this->input->post('extended_priority_fields')) ){
		
			
		}
		
		
		$this->db->query('user_priority_fields');
		
		
		
	}
	
	
	
	
/**
	*
	*/
	public function save_user_field(){

		$field_id = $this->input->post('field_id');
		
		$field_name = $this->input->post('field_name');
			
		
		
		$field_value = $this->input->post('field_value');
		$default_value = $this->input->post('default_value');

		$width = $this->input->post('field_width');
		$height = $this->input->post('field_height');
		
		$field_name = preg_replace('/[^a-zA-Z0-9\-_%\[().\]\\/-]/s', '', $field_name);
		
		$required = $this->input->post('required') != "" ? $this->input->post('required') : 0;
		

		$input_type = $this->input->post('input_type');
		$field_options = $this->input->post('field_options');
		$settings_hidden = $this->input->post('settings_hidden');
		
		$column_attribs = array(
		
		"text" => array( 'type' => 'varchar', 'constraint' => 255, 'null' => FALSE, 'default'	=> ''),
		"email" => array( 'type' => 'varchar', 'constraint' => 8, 'null' => FALSE, 'default'	=> 0),
		"password" => array( 'type' => 'varchar', 'constraint' => 8, 'null' => FALSE, 'default'	=> 0),
		"textarea" => array( 'type' => 'TEXT','null' => TRUE),
		"checkbox" => array( 'type' => 'varchar', 'constraint' => 255, 'null' => FALSE, 'default'	=> ''),
		"multicheck" => array( 'type' => 'TEXT','null' => TRUE),
		"radio" => array( 'type' => 'TEXT','null' => TRUE),
		"dropdown" => array( 'type' => 'TEXT','null' => TRUE),
		"multiselect" => array( 'type' => 'TEXT','null' => TRUE),
		"static_content" => array( 'type' => 'TEXT','null' => TRUE),
		"date" => array( 'type' => 'int', 'constraint' => 12, 'null' => FALSE, 'default'	=> 0),
		);

		
		
		$find_last_order = mysql_query("SELECT position FROM {$this->db->dbprefix}user_fields ORDER BY position DESC");
		$row = mysql_fetch_array($find_last_order);
		$last = $row["position"] + 1;

		
		$allow = TRUE;
		
		$data = array(
		
			"field_name" => $field_name,
			"input_type" => $input_type,
			"field_value" => $field_value,			
			"default_value" => $default_value,			
			"required" => $required,
			"position" => $last,
			"width" => $width,
			"height" => $height,
						
		);
		
	
		
		if($field_id == "" || $field_id < 1){
			
			$data['field_name'] = $this->_get_unique_fieldname($data['field_name']);
			
			$this->db->insert('user_fields', $data);
			
			$field_id = $this->db->insert_id();
			
			$temp_field_id = 10000000 + $this->session->userdata('id');
			
			$sql = "UPDATE {$this->db->dbprefix}user_field_options SET field_id = '{$field_id}' WHERE field_id = '{$temp_field_id}'";
			$this->db->query($sql);
			
			
			// now modify the storage table
			
			$this->load->dbforge();
			
			if (!$this->db->field_exists($data['field_name'], $this->config->item('profile_table'))){
				
				$this->dbforge->add_column($this->config->item('profile_table'), array($data['field_name'] => $column_attribs[strtolower($input_type)]) );
				
			}
			
		}else{
			
			$sql = "SELECT field_name FROM {$this->db->dbprefix}user_fields WHERE id = '{$field_id}'";
			
			$old_field_name = $this->db->query($sql)->row()->field_name;

			
			$this->db->where('id', $field_id);
			$this->db->update('user_fields', $data); 


			// if the field name was changed we need to update the records table...
						
			if(	$old_field_name != 	$data['field_name']){
									
				$this->load->dbforge();
				
				if ($this->db->field_exists($old_field_name, $this->config->item('profile_table'))){
			
					$this->dbforge->drop_column($this->config->item('profile_table'),$old_field_name);
				}
				
			
				if (!$this->db->field_exists($data['field_name'], $this->config->item('profile_table'))){
							
					$this->dbforge->add_column($this->config->item('profile_table'), array($data['field_name'] => $column_attribs[$input_type]) );
				
				}
				
			}
		}
		
		$option_ids = $this->input->post('option_ids');
		$option_values = $this->input->post('option_values');
		$option_labels = $this->input->post('option_labels');
		
		for($i = 0; $i < count($option_ids); $i++){
			
			$sql = "UPDATE {$this->db->dbprefix}user_field_options SET option_value='{$option_values[$i]}', option_label='{$option_labels[$i]}' WHERE option_id = '{$option_ids[$i]}'";
			$this->db->query($sql);
		}				
		
		
		
	}
	
	
	
	/**
	* prevents user from creating duplicate friendly urls. 
	* Adds a unique number to the end of duplicates
	* @param string url (original)
	* @param varchar(2) language
	* @param int node_id
	* @return string url
	*/
	private function _get_unique_fieldname($field_name, $field_id = ''){
		
		
		$unique = FALSE;
		
		$i = 0;
		
		while(!$unique){
			
			$sql = "SELECT COUNT(*) AS numrecs FROM {$this->db->dbprefix}user_fields WHERE field_name = '{$field_name}' ";
			
			if($field_id != "") $sql .= " AND field_id != '{$field_id}'";
			
			if( $this->db->query($sql)->row()->numrecs > 0 ){
				
				
				preg_match('/^([^\d]+)([\d]*?)$/', $field_name, $match);
				$field_name = $match[1];
				$number = $match[2] + 1;
				$field_name .= $number;
				
			}else{
				
				$unique = TRUE;
				break;
				
			}
			
			if($i > 100) break; // this is insurance
			$i++;
			
		}
		
		
		return $field_name;
		
		
		
	}
	

	

} //end class