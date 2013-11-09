<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_remote extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		
		$this->load->helper('auth');
		
		is_logged_in();
		
		$this->load->model('form_builder_model');
		

	}
	
	
	/**
	* 
	*
	*/
	public function check_form_name_duplicate(){
	
		$form_name = $this->input->post('form_name');
		
		if($this->form_builder_model->check_form_name_duplicate($form_name)){
		
			echo "FAIL";
		}else{
		
			echo "OK";
			
		}
		
		
		die();
		
			
	
	}
	
	
	/**
	* 
	*
	*/
	public function load_form_list(){
	
		
		$data['form_list_data'] = $this->form_builder_model->get_form_list_data();
			
		echo $this->load->view('partials/formlist', $data, TRUE); 
		
	
	}
	
	/**
	* 
	*
	*/
	public function delete_form(){
	
		$form_id = $this->input->get('form_id');
	
			
		$this->form_builder_model->delete_form($form_id);
			

		
	
	}
	
	
	/**
	*
	*
	*/
	public function save_new_form(){
	
		$form_name = $this->input->post('form_name');
		
		$this->form_builder_model->save_new_form($form_name);
			
	
	}
	

	
	public function delete_option($option_id, $ftype, $field_id = ''){
		
		if($field_id == "" || $field_id < 1) $field_id = 10000000 + $this->session->userdata('id');
		
		$sql = "DELETE FROM {$this->db->dbprefix}form_builder_element_options WHERE option_id = '{$option_id}'";
		
		$this->db->query($sql);
		
		echo $this->load_field_options($ftype, $field_id);
		
		
	}
	
	public function update_option_positions(){
	
		$options = $this->input->post('option');
		
		$p = 0;
	
		foreach($options  as $id){
				
			$sql = "UPDATE {$this->db->dbprefix}form_builder_element_options SET position = '{$p}' WHERE option_id = '{$id}'";
						
			$this->db->query($sql);
			
				
			$p++;
			
		}   

	}

	
	
	public function add_field_option($name, $value, $ftype, $form_id, $field_id = ''){
		
		$this->load->library('formelement');
		$this->load->library('impressto');
		
		$this->impressto->setDir(dirname(dirname(__FILE__)) . "/views/partials");
		
		
		
		if($field_id == "" || $field_id < 1) $field_id = 10000000 + $this->session->userdata('id');
		
		$position = 0; // for now...
		
		$sql = "INSERT INTO {$this->db->dbprefix}form_builder_element_options (";
		$sql .= "element_id,";
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
				
				
		//echo $this->load_field_options($ftype, $field_id);
		
		echo $this->impressto->showpartial('optionspanel.tpl.php','FIELDOPTIONSITEM', $data); 
				
				
		
		
		
	}
	
	
	/**
	*
	*
	*/
	public function edit_field($form_id, $field_id = ''){
		
		$result_array = array();
		
		$data = array("form_id"=>$form_id,"field_id" => $field_id);
				
		$data['field_options'] = "";
		
		$data['ftype'] = "";
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
		$query = $this->db->get_where('form_builder_fields', array('field_id' => $field_id));
		
		if ($query->num_rows() > 0)
		{

			$row = $query->row();
			
			
			$data['field_name'] = $row->field_name;
			$data['field_label'] = $row->field_label;
			$data['paragraph'] = $row->paragraph;	
				
			$data['active'] = $row->active;
			$data['disabled'] = $row->disabled;
			$data['visible'] = $row->visible;
			$data['showlabel'] = $row->showlabel;
			
			
			
			$data['width'] = $row->width;
			$data['height'] = $row->height;
			$data['orientation'] = $row->orientation;
			$data['onchange'] = $row->onchange;
			
			
			
			$data['ftype'] = $row->ftype;
			$data['required'] = $row->required;
			
			
			$data['field_value'] = $row->field_value;
			$data['default_value'] = $row->default_value;
		
			$options_array = array();
			
			$this->db->order_by("position", "desc"); 
			$sub_query = $this->db->get_where('form_builder_element_options', array('element_id' => $field_id));
			
		
			if($data['ftype'] == "dropdown" || $data['ftype'] == "radio"){
				
				$data['field_options'] = $this->load_field_options($data['ftype'], $field_id,  FALSE);
			}
			
		}else{
		
			// these are the defaults for new fields
			$data['active'] = 1;
			$data['visible'] = 1;
			$data['ftype'] = "text";
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
		'name'        => "ftype",
		'id'          => "ftype",
		'type'          => 'select',
		'showlabels'          =>  FALSE,	
		'onchange'          =>  "ps_formbuilder_manager.set_field_type(this)",	
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
		'value' => $data['ftype'],
		);
		
		
		$data['ftype_selector'] = $this->formelement->generate($fielddata);
		
		
		
		$fielddata = array(
		'name'        => "field_orientation",
		'id'          => "field_orientation",
		'type'          => 'select',
		'showlabels'          =>  FALSE,	
		'onchange'          =>  "ps_formbuilder_manager.set_orientation(this)",	
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
		

		
		
		switch($data['ftype']){
		
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
	

	/**
	*
	*
	*/
	public function load_fieldlist($form_id){
		
		$data = array("form_id"=>$form_id);
		
		
		echo $this->load->view('partials/fieldlist', $data, TRUE); 
		
		
	}
	
	
	/**
	* 
	*
	*
	*/
	public function load_field_options($field_type, $field_id = '', $display = TRUE){
		
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
		
			$sql= "SELECT default_value FROM {$this->db->dbprefix}form_builder_fields WHERE field_id = '{$field_id}'";
			$default_value = $this->db->query($sql)->row()->default_value;
		}
		
		
		
		$data['core_asset_url'] = ASSETURL . "/" . PROJECTNAME . "/default/core";
		$data['mod_asset_url'] = ASSETURL . "/" . PROJECTNAME . "/default/custom_modules/form_builder/";
		
		
		$data['fieldoptionitems'] = "";
		
	

		
				
		
		$sql= "SELECT * FROM {$this->db->dbprefix}form_builder_element_options WHERE element_id = '{$field_id}' ORDER BY position";

		
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
		'onclick'          =>  "ps_formbuilder_manager.updatecheckboxdefault(this)",	
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
	*
	*
	*/
	public function update_required(){
		
		$required = $this->input->get('required');
		$field_id = $this->input->get('field_id');
		
		$sql = "UPDATE " . $this->db->dbprefix . "form_builder_fields SET "
		. " required = '" . $required . "' "
		. " WHERE field_id = '" . $field_id . "'";
		$this->db->query($sql);
		
		
	}
	
	
	/**
	*
	*
	*/
	public function update_active(){
		
		$active = $this->input->get('active');
		$field_id = $this->input->get('field_id');
		
		$sql = "UPDATE " . $this->db->dbprefix . "form_builder_fields SET "
		. " active = '" . $active . "' "
		. " WHERE field_id = '" . $field_id . "'";
		$this->db->query($sql);
		
		echo $sql;
		
	}
	
	
	
	/**
	*
	*
	*/

	public function update(){
		
		
		$enabled = $this->input->post('enabled') == "" ? $this->input->post('enabled') : 0 ;
		
		$field_type = $this->input->post('field_type');
		$field_id = $this->input->post('field_id');
		$required = $this->input->post('required');
		$field_name = $this->input->post('field_name');
		$flexible_choices = $this->input->post('flexible_choices');
		if ($field_id != ""){
			$file = 0;
			foreach ($field_id as $alia) {
				$enable = '0';
				$require = '0';
				if ($enabled[$alia] == 'on'){
					$enable = '1';
				}
				if ($required[$alia] == 'on'){
					$require = '1';
				}

				if ($field_type[$alia] != 'subject'){
					$continue = true;
					mysql_query("UPDATE {$this->db->dbprefix}form_builder_fields SET ftype ='".$field_type[$alia]."' WHERE field_id ='".$alia."'") or die(mysql_error());

					mysql_query("UPDATE {$this->db->dbprefix}form_builder_fields SET enabled ='".$enable."' WHERE field_id ='".$alia."'") or die(mysql_error());
					mysql_query("UPDATE {$this->db->dbprefix}form_builder_fields SET req ='".$require."' WHERE field_id ='".$alia."'") or die(mysql_error());
				}
				mysql_query("UPDATE {$this->db->dbprefix}form_builder_fields SET field_name ='".$field_name[$alia]."' WHERE field_id ='".$alia."'") or die(mysql_error());
			}
		}
		$result = $_REQUEST["form_fields"];
		if (is_array($result)){
			$i = 0;
			foreach($result as $value) {
				$i++;
				mysql_query("UPDATE {$this->db->dbprefix}form_builder_fields SET position='".$i."' WHERE field_id='".$value."'") or die(mysql_error());
			}
		}	
	}
	

	
	/**
	*
	*/
	public function special_options(){
		
		$mode = $_POST["mode"];

		if ($mode == 'get'){
			$options = mysql_fetch_array(mysql_query("SELECT choices FROM {$this->db->dbprefix}form_builder_fields WHERE field_id='".$_POST['fid']."'"));
			echo $options['choices'];
		}elseif($mode == 'update'){
			mysql_query("UPDATE {$this->db->dbprefix}form_builder_fields SET choices ='".trim($_POST['opts'])."' WHERE field_id ='".$_POST['fid']."'") or die(mysql_error());
		}elseif($mode == 'type'){
			$options = mysql_fetch_array(mysql_query("SELECT ftype FROM {$this->db->dbprefix}form_builder_fields WHERE field_id='".$_POST['fid']."'"));
			echo $options['ftype'];
		}
	}
	
	/**
	*
	*/
	public function special_options_file(){
		
		$field = $_POST["fid"];
		$mode = $_POST["mode"];

		if ($mode == 'show'){
			$settings = mysql_fetch_array(mysql_query("SELECT * FROM {$this->db->dbprefix}form_builder_file_settings WHERE flexible_id='".$field."' "));
			$extensions = $settings['flexible_file_ext'];
			$limit = $settings['flexible_file_size'];
			$page = "<label for='extensions'>Exensions allowed: </label><input id='extensions' name='extensions' value='".$extensions."' style='width:500px;' /><br/>\n
		<label for='size_limit'>Maximum File Size Limit in Bytes</label><input id='size_limit' name='size_limit' value='".$limit."' style='width:200px;' /><br>
		<p style='font-size:10px;'>Leave any field empty to set it to unlimited.";
			echo $page;
		}elseif($mode == 'update'){
			mysql_query("UPDATE {$this->db->dbprefix}form_builder_file_settings SET flexible_file_ext='".$_POST['extensions']."' WHERE flexible_id='".$field."' ");
			mysql_query("UPDATE {$this->db->dbprefix}form_builder_file_settings SET flexible_file_size='".$_POST['maxsize']."' WHERE flexible_id='".$field."' ");
		}
	}
	
	/**
	*
	*/
	public function special_options_slider(){
		
		$field = $_POST["fid"];
		$mode = $_POST["mode"];

		if ($mode == 'show'){
			$settings = mysql_fetch_array(mysql_query("SELECT * FROM {$this->db->dbprefix}form_builder_slider_settings WHERE flexible_id='".$field."' "));
			$min = $settings['slider_min'];
			$max = $settings['slider_max'];
			$value = $settings['slider_value'];
			$step = $settings['slider_step'];
			$prefix = $settings['slider_prefix'];
			$range_min = $settings['slider_value_min'];
			$range_max = $settings['slider_value_max'];
			if ($settings['slider_display'] == 1){
				$display= 'checked=\'checked\'';
			}
			if ($settings['slider_range'] == 1){
				$range= 'checked=\'checked\'';
			}
			$page = "<label for='value'>Default Value: </label><input id='value' name='value' value='".$value."' style='width:500px;' /><br/>\n
		<label for='min'>Minimum Value: </label><input id='min' name='min' value='".$min."' style='width:500px;' /><br/>\n
		<label for='max'>Maximum Value: </label><input id='max' name='max' value='".$max."' style='width:500px;' /><br/>\n
		<label for='step'>Step: </label><input id='step' name='step' value='".$step."' style='width:500px;' /><br/>\n
		<label for='prefix'>Slider Prefix: </label><input id='prefix' name='prefix' value='".$prefix."' style='width:500px;' /><br/>\n
		<input type='checkbox' name='display' id='display' value='1' ".$display." /><label for='display'>Display Value</label><br><br>\n
		<input type='checkbox' name='range' id='range' value='1' ".$range." /><label for='range'>Enable Range Slider</label><br>\n
		<label for='range_min'>Range Low Value: </label><input id='range_min' name='range_min' value='".$range_min."' style='width:500px;' /><br/>\n
		<label for='range_max'>Range Max Value: </label><input id='range_max' name='range_max' value='".$range_max."' style='width:500px;' /><br/>\n
		<p style='font-size:10px;'>Please complete all necessary fields.";
			echo $page;
		}elseif($mode == 'update'){
			mysql_query("UPDATE {$this->db->dbprefix}form_builder_slider_settings SET slider_value='".$_POST['value']."' WHERE flexible_id='".$field."' ");
			mysql_query("UPDATE {$this->db->dbprefix}form_builder_slider_settings SET slider_min='".$_POST['min']."' WHERE flexible_id='".$field."' ");
			mysql_query("UPDATE {$this->db->dbprefix}form_builder_slider_settings SET slider_max='".$_POST['max']."' WHERE flexible_id='".$field."' ");
			mysql_query("UPDATE {$this->db->dbprefix}form_builder_slider_settings SET slider_step='".$_POST['step']."' WHERE flexible_id='".$field."' ");
			mysql_query("UPDATE {$this->db->dbprefix}form_builder_slider_settings SET slider_prefix='".$_POST['prefix']."' WHERE flexible_id='".$field."' ");
			mysql_query("UPDATE {$this->db->dbprefix}form_builder_slider_settings SET slider_range='".$_POST['range']."' WHERE flexible_id='".$field."' ");
			mysql_query("UPDATE {$this->db->dbprefix}form_builder_slider_settings SET slider_value_min='".$_POST['range_min']."' WHERE flexible_id='".$field."' ");
			mysql_query("UPDATE {$this->db->dbprefix}form_builder_slider_settings SET slider_value_max='".$_POST['range_max']."' WHERE flexible_id='".$field."' ");
			if ( $_POST['display'] == 1){ $display = 1; }else{ $display = 0;}
			mysql_query("UPDATE {$this->db->dbprefix}form_builder_slider_settings SET slider_display='".$display."' WHERE flexible_id='".$field."' ");

			if ( $_POST['range'] == 1){ $range = 1; }else{ $range = 0;}
			mysql_query("UPDATE {$this->db->dbprefix}form_builder_slider_settings SET slider_range='".$range."' WHERE flexible_id='".$field."' ");

		}



	}
	
	/**
	*
	*
	*/
	public function save_settings(){

		$form_id = $this->input->post('form_id');
		
		$email_account = $this->input->post('email_account');
		$button_value = $this->input->post('button_value');
		$captcha = $this->input->post('captcha');
		$captcha_theme = $this->input->post('captcha_theme');
		
		$form_content = $this->input->post('form_content');
		
		
		

		$javascript = $this->input->post('form_javascript');
		
						
		$button_value = $this->input->post('button_value');
		
		$success_message = $this->input->post('success_message');
		$from_a = $this->input->post('from_a');
		$mapcode = $this->input->post('mapcode');
		
		

		$saveoptions['form_id'] = $form_id;
		
		$saveoptions['template'] = $this->input->post('form_builder_template');
		$saveoptions['email_account'] = $email_account;
		$saveoptions['button_value'] = $button_value;
		$saveoptions['captcha'] = $captcha;
		$saveoptions['captcha_theme'] = $captcha_theme;
		$saveoptions['button_value'] = $button_value;
		
		$saveoptions['content'] = $form_content;
		
		$saveoptions['success_message'] = $success_message;
		$saveoptions['from_a'] = $from_a;
		$saveoptions['mapcode'] = $mapcode;
		$saveoptions['javascript'] = $javascript;
		
			
		$this->form_builder_model->save_form_settings($saveoptions);
		
		
		
	}
	
	
	/**
	*
	*/
	public function save_field(){

		$form_id = $this->input->post('field_form_id');
			
		$field_id = $this->input->post('field_id');
		
		$field_name = $this->input->post('field_name');
		$field_label = $this->input->post('field_label');
		
		if($field_label == "") $field_label = ucwords($field_name);
		
		$paragraph = $this->input->post('paragraph');
				
		
		
		$field_value = $this->input->post('field_value');
		$default_value = $this->input->post('default_value');

		$width = $this->input->post('field_width');
		$height = $this->input->post('field_height');
		$orientation = $this->input->post('field_orientation');
		$onchange = $this->input->post('field_onchange');

		
		$field_name = preg_replace('/[^a-zA-Z0-9\-_%\[().\]\\/-]/s', '', $field_name);
		
		$active = $this->input->post('active') != "" ? $this->input->post('active') : 0;
		$disabled = $this->input->post('disabled') != "" ? $this->input->post('disabled') : 0;
		$visible = $this->input->post('visible') != "" ? $this->input->post('visible') : 0;
		$required = $this->input->post('required') != "" ? $this->input->post('required') : 0;
		$showlabel = $this->input->post('showlabel') != "" ? $this->input->post('showlabel') : 0;
		

		$ftype = $this->input->post('ftype');
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

		
		
		


		
		$allow = TRUE;
		
		$data = array(
		
			"field_name" => $field_name,
			"field_label" => $field_label,
			"showlabel" => $showlabel,
			"paragraph" => $paragraph,
			"active" => $active,
			"disabled" => $disabled,
			"visible" => $visible,
			"ftype" => $ftype,
			"field_value" => $field_value,			
			"default_value" => $default_value,			
			"required" => $required,
			"width" => $width,
			"height" => $height,
			"orientation" => $orientation,
			"onchange" => $onchange,
			"updated" => date('Y-m-d H:i:s')
						
			
		);
		

		
		if($field_id == "" || $field_id < 1){

			$find_last_order = mysql_query("SELECT position FROM {$this->db->dbprefix}form_builder_fields ORDER BY position DESC");
			$row = mysql_fetch_array($find_last_order);
			$last = $row["position"] + 1;
		
			$data['position'] = $last;
		
			$data['field_name'] = $this->_get_unique_fieldname($data['field_name']);
			
			$this->db->insert('form_builder_fields', $data);
			
			$field_id = $this->db->insert_id();
			
			$temp_field_id = 10000000 + $this->session->userdata('id');
			
			$sql = "UPDATE {$this->db->dbprefix}form_builder_element_options SET element_id = '{$field_id}' WHERE element_id = '{$temp_field_id}'";
			$this->db->query($sql);
						
			
			// now modify the storage table
			
			$this->load->dbforge();
			
			if (!$this->db->field_exists($data['field_name'], 'form_builder_records')){
				
				$this->dbforge->add_column('form_builder_records', array($data['field_name'] => $column_attribs[strtolower($ftype)]) );
				
			}
			
		}else{
			
			$sql = "SELECT field_name FROM {$this->db->dbprefix}form_builder_fields WHERE field_id = '{$field_id}'";
			
			$old_field_name = $this->db->query($sql)->row()->field_name;

			
			$this->db->where('field_id', $field_id);
			$this->db->update('form_builder_fields', $data); 


			// if the field name was changed we need to update the records table...
						
			if(	$old_field_name != 	$data['field_name']){
									
				$this->load->dbforge();
				
				if ($this->db->field_exists($old_field_name, 'form_builder_records')){
			
					$this->dbforge->drop_column('form_builder_records',$old_field_name);
				}
				
		
				
				if (!$this->db->field_exists($data['field_name'], 'form_builder_records')){
					
									
					$this->dbforge->add_column('form_builder_records', array($data['field_name'] => $column_attribs[$ftype]) );
					

					
				}
				
			}
		}
		

		
		$option_ids = $this->input->post('option_ids');
		$option_values = $this->input->post('option_values');
		$option_labels = $this->input->post('option_labels');
		
		for($i = 0; $i < count($option_ids); $i++){
			
			$sql = "UPDATE {$this->db->dbprefix}form_builder_element_options SET option_value='{$option_values[$i]}', option_label='{$option_labels[$i]}' WHERE option_id = '{$option_ids[$i]}'";
			$this->db->query($sql);
		}	


		
		$sql = "REPLACE INTO {$this->db->dbprefix}form_builder_form_fields (form_id, field_id) VALUES ('{$form_id}','{$field_id}');";
		$this->db->query($sql);		
			
			
		
		
		
	}
	
	

	
	/**
	*
	*/
	public function delete_field($field_id){
		
		
		$this->load->dbforge();
		
		
		$q = mysql_fetch_array(mysql_query("SELECT ftype, field_name FROM {$this->db->dbprefix}form_builder_fields WHERE field_id='".$field_id."'"));
		$type = $q["ftype"];
		$field_name = $q["field_name"];

		
		mysql_query("DELETE FROM {$this->db->dbprefix}form_builder_fields WHERE field_id='".$field_id."'") or die(mysql_error());
		
		if ($this->db->field_exists($field_name, 'form_builder_records')){
			
			$this->dbforge->drop_column('form_builder_records', $field_name );
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
			
			$sql = "SELECT COUNT(*) AS numrecs FROM {$this->db->dbprefix}form_builder_fields WHERE field_name = '{$field_name}' ";
			
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
	
	
	
	/**
	* AJAX responder
	* returns a simple list of all the site widgets to CK Editor Widgets plugin
	*
	*/
	public function tinymce_field_list($form_id){

		$outbuf = "";
			
		$data = array();
		
		//$data['ckeditor_name'] = $this->input->get('editor_name');
			
		$data['active_fields'] = $this->form_builder_model->get_active_fields($form_id);
		
		$this->load->view('partials/tinymce_field_list', $data);
				
	
	}	
	
	
	
	
	
}

