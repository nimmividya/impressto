<?php

// sample tags
//  [widget type='form_builder' name='formname']
//  direct from PHP code Widget::run('form_builder/form_builder', array('name'=>'widget_1'));

// within smarty {widget type='form_builder/form_builder' name='widget1'}



class form_builder extends Widget
{

	private $settings;

	
    function run() {
	
	
		$this->load->library('asset_loader');
		//$this->load->library('widget_utils');
		

		$args = func_get_args();
		

		
		$data = array();
		
						
        // if paramaeters have been passed to this widget, assign them	and override the defaults for this widget instance
		if(isset($args[0]) && is_array($args[0])){
		
			$widget_args = $args[0];
					
			if(isset($args[0]['name'])) $data['name'] = $args[0]['name'];
			if(isset($args[0]['form_id'])) $data['form_id'] = $args[0]['form_id'];


			
		}
		
		$this->load->model('form_builder/form_builder_model');
				
		if(!isset($data['form_id'])){
		
			$data['form_id'] = $this->form_builder_model->get_form_id_by_name($data['name']);
				
		}
		
		
	
		////////////////////////////////
		// peterdrinnan - May 21, 2012
		//add the path for the widgets module so we can locate the models	
		//$this->load->_add_module_paths('form_builder');


		// If the widget is being called form a shortcode and there is no ID, get the id 
		if(!isset($widget_args['widget_id']) && isset($data['name'])) 
			$widget_args['widget_id'] = $this->widget_utils->getwidgetid('form_builder_fields', 'form_builder', $data['name']);


		
			
		// load the news widget language file now...
		$this->lang->load('form_builder', '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');	
	
	
		//$widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);

				
		//$moduleoptions = ps_getmoduleoptions('form_builder');
		
		// detect language
		$data['lang_selected'] = $this->config->item('lang_selected');
	
		$node_id = $this->config->item( 'page_node_id' );
	

		$lang_avail = $this->config->item('lang_avail');


		$num1 = rand(1,10); $num2 = rand(1,10); $total = $num1 + $num2;
		
		$submitted = false;

		
		
		
		$this->settings = $this->form_builder_model->get_form_settings($data['form_id']);
		
				
		$data['fields'] = array();
			

		// parse the contect for field short codes ...
		
		$data['content'] = $this->process_field_codes($this->settings['content'], $data['form_id']);
					
		
		$data['template'] = $this->settings['template']; // can also be $widget_options['template'] if we are using instances
		$data['module'] = 'form_builder';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'form_builder';	

		$data['settings'] = $this->settings;

		$module_version = $this->_get_module_version('form_builder');
		
		$data['file_version_tag'] = "";
		if($module_version) $data['file_version_tag'] = "." . $module_version;

		$data['partial_section'] = "MAINFORM";
		
		// use this to load witht the correct filters (language, device, docket)
		echo $this->template_loader->render_template($data);
		
		
		return;
			

		 
    }
	
	
	
		/**
	* This function can be called by template files or module code to execute template like function calls
	* Sample string: 
	* $text = "He is a simple demo of  [widget type='bg_pos_slider/bg_widget' othername='seomething else' relative=wawaewa] OR [widget='bg_pos_slider/bg_widget' ] 
	* return processed html
	*/	
	protected function process_field_codes($string, $form_id){
	
		$CI = & get_instance();
			
		
		//return $string;
		
		if($string == "") return "";
		

		
		// replace BBCode style widget call for actual widget plugin call
		$string = preg_replace_callback(
		'/\[fbld_submit]/i',
		create_function(
		'$matches',
		'
				return \'{=$this->_fbld_submit_button("' . $form_id . '")=}\';
				
				'
		),
		$string);
		

		$string = preg_replace_callback(
		'/\[fbld_full_field_list]/i',
		create_function(
		'$matches',
		'
				return \'{=$this->_fbld_full_field_list("' . $form_id . '")=}\';
				
				'
		),
		$string);
		
		
		
		
		$string = preg_replace_callback(
		'/\[fbldfield=([^\]]+)?\]/i',
		create_function(
		'$matches',
		'
				return \'{=$this->_fbld_field(\'.$matches[1].\',' . $form_id . ')=}\';
				
				'
		),
		$string);

		
		//echo $string;
		
		$pattern = '/\{=(.*?)\=}/is';
		
		//echo $pattern;
		
		$outbuf = preg_replace_callback($pattern, array(&$this, '_func_eval'), $string) . "\n";
		
				
		return $outbuf;
		
	}////////////////////
	
	
	///////////////////////////////////////
	//
	// watch out for function calls with ' characters converted to &#39;
	// took me hours to figure that $#%@ out.
	//
	protected function _func_eval($matches){
		

		//print_r($matches);
			
		ob_start();
		
		$outbuf = "";
			
		
		if(trim($matches[1]) != ""){
		
			
			if(preg_match("/\(/",$matches[1])){
		
				$str = trim($matches[1]); 
					
				// quick little fix for corrupted tags
				$str = str_replace("&#39;","'", $str);
						
				eval("\$outbuf = " . $str . ";");
					
				echo $outbuf;
					
					
			}
		}
		
				
		$outbuf = ob_get_contents();

		ob_end_clean();
		
		//echo $outbuf;
		
		return $outbuf;
		
	}///////////////////////////
	
	
	private function _fbld_full_field_list($form_id){
	
	
		$sql = "SELECT FIELDS.* FROM {$this->db->dbprefix}form_builder_form_fields AS FINDEX LEFT JOIN {$this->db->dbprefix}form_builder_fields AS FIELDS ";
		$sql .= "ON FINDEX.field_id = FIELDS.field_id ";
		$sql .= " WHERE FINDEX.form_id='{$form_id}' AND FIELDS.active = 1 ORDER BY FIELDS.position ASC";
		
		$query = $this->db->query($sql);
		
		///echo $sql;

		
		foreach ($query->result_array() as $row)
		{

			$data['fields'][$row['field_name']] = $row;
		
			$sql = "SELECT * FROM {$this->db->dbprefix}form_builder_element_options WHERE element_id = '{$row['field_id']}' ORDER BY position ASC";
		
			$data['fields'][$row['field_name']]['options'] = array(); 
		
			$query2 = $this->db->query($sql);
		
			foreach ($query2->result_array() as $row2){
			
				$data['fields'][$row['field_name']]['options'][$row2['option_label']] = $row2['option_value'];
				
				
			}
			
		}
		

		
		//$data['template'] = "partials/form_fields.tpl.php"; // can also be $widget_options['template'] if we are using instances
		$data['module'] = 'form_builder';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'form_builder';	


		$data['settings'] = $this->settings;

		$module_version = $this->_get_module_version('form_builder');
		
		$data['file_version_tag'] = "";
		if($module_version) $data['file_version_tag'] = "." . $module_version;
		
		$data['template'] = $this->settings['template']; // can also be $widget_options['template'] if we are using instances


		$data['partial_section'] = "FORM_FIELDS";
		

		
		return $this->template_loader->render_template($data);
				
	
	}
	
	/**
	*
	*
	*/
	private function _fbld_submit_button($form_id){
	
			
		$data['module'] = 'form_builder';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'form_builder';	


		$data['settings'] = $this->settings;

		$module_version = $this->_get_module_version('form_builder');
		
		$data['file_version_tag'] = "";
		if($module_version) $data['file_version_tag'] = "." . $module_version;
		
		$data['template'] = $this->settings['template']; // can also be $widget_options['template'] if we are using instances
	
		
		$data['partial_section'] = "SUBMIT_BUTTON";
				
		return $this->template_loader->render_template($data);
	
	

	}

	private function _fbld_field($field_name, $form_id){
	
			
		$this->load->library('formelement');
		
		$sql = "SELECT FIELDS.* FROM {$this->db->dbprefix}form_builder_form_fields AS FINDEX LEFT JOIN {$this->db->dbprefix}form_builder_fields AS FIELDS ";
		$sql .= "ON FINDEX.field_id = FIELDS.field_id ";
		$sql .= " WHERE FINDEX.form_id='{$form_id}' AND FIELDS.field_name = '{$field_name}'";
		
		$query = $this->db->query($sql);
		
		//echo $sql;

		if ($query->num_rows() > 0)
		{

			$row = $query->row_array(); 
   
			$data['fields'][$row['field_name']] = $row;
		
			$sql = "SELECT * FROM {$this->db->dbprefix}form_builder_element_options WHERE element_id = '{$row['field_id']}' ORDER BY position ASC";
		
			$data['fields'][$row['field_name']]['options'] = array(); 
		
			$query2 = $this->db->query($sql);
		
			foreach ($query2->result_array() as $row2){
			
				$data['fields'][$row['field_name']]['options'][$row2['option_label']] = $row2['option_value'];
				
				
			}
			
		}
	
	
		//return "this is {$field_name} field";
		
		$errorlabel = '<label id="label_'.$row['field_id'].'" class="errorbox cornered" style="display:none;">You have not completed \''.$row['field_name'].'\'</label>';

		

	
		$settings = $this->settings;
			
		$this->formelement->init();

		$fielddata = array(
		'name'        => $row['field_name'],
		'type'        => $row['ftype'],
		'id'          => $row['field_name'],
		'required'    => $row['required'],
		'label'       => $row['field_label'],
		'value'       => $row['default_value'],
		'orientation' => $row['orientation'],
		'width'       => $row['width'],
		'height'      => $row['height'],
		'onchange'    => $row['onchange'],
		
		
		);
		
		if($row['showlabel'] == 1) $fielddata['showlabels'] = TRUE;
		else $fielddata['showlabels'] = FALSE;
	
		
		if(isset($row['options'])) $fielddata['options'] = $row['options'];

		$outbuf = "<div style=\"padding:5px\">huh";

		if($row['paragraph'] != "") $outbuf .= "<p>" . $row['paragraph'] . "</p>";
	
		$outbuf .= $this->formelement->generate($fielddata);
	
		$outbuf .= "</div><div>{$errorlabel}</div>";
		
		$outbuf .= "<div class=\"clearfix\"></div>";
		
		return $outbuf;
			
	
	}
	
	
}  

