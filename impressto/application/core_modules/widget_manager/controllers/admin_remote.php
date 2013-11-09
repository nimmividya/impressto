<?php

class admin_remote extends PSBase_Controller {

	public function __construct(){
		
		parent::__construct();
		
		
		$this->load->helper('auth');
		$this->load->library('impressto');
		$this->load->library('widget_utils');
		
		
		$this->impressto->setDir(APPPATH . "/core_modules/widget_manager/views/ps_templates");
		
		
		is_logged_in();
		
		//if(!$this->db->table_exists('ps_image_slider')) $this->install();
		
		$this->load->model('widget_manager_model');
		
		
	}
	
	/**
	*
	*
	*/
	public function save_slug(){
	
		
		$widget_id = $this->input->post('widget_id');
		$slug = $this->input->post('slug');
				
		if($slug == "") return;
		
		$slug = str_replace("[","",$slug);
		$slug = str_replace("]","",$slug);

		$data = array('slug' => $slug);
		
		$sql = "SELECT widget_id FROM {$this->db->dbprefix}widgets WHERE slug = '{$slug}'; ";
		
		$query = $this->db->query($sql);
	
		if ($query->num_rows() == 0){ 
		
			$this->db->where('widget_id', $widget_id);
			$this->db->update('widgets', $data);
			echo "[" . $slug . "]";
			
		
		}else{
	
			// OK, so a slug already exsits. Lets check if it is used by the current widget. If not return a warning
			$row = $query->row();
			
			if($row->widget_id == $widget_id){
			
				$this->db->where('widget_id', $widget_id);
				$this->db->update('widgets', $data);
				echo "[" . $slug . "]";
				
			}else{
			
				// this slug is being used by another widget
				echo "used";
			
			}

					
		}
		

	
	}
	

	
	
	/**
	* default management page
	*
	*/
	public function add_widget_collection(){
		
		$name = $this->input->post('collectionname');
		
		$return_array['error'] = "SQL Error";
		$return_array['id'] = "";
		$return_array['msg'] = "";
		
		$sql = "SELECT id FROM {$this->db->dbprefix}widget_collections WHERE name = '{$name}'";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() == 0){
			
			
			
			$sql = "INSERT INTO {$this->db->dbprefix}widget_collections SET name = '{$name}'";
			$query = $this->db->query($sql);
			
			
			$return_array['error'] = "";
			$return_array['msg'] = "inserted";
			$return_array['id'] = $this->db->insert_id();
			
			
			
		}else{
			
			$row = $query->row();

			$return_array['error'] = "";
			$return_array['msg'] = "exists";
			$return_array['id'] = $row->id;
			
			
		}
		
		
		echo json_encode($return_array);
		

		
		
	}
	
	
	/**
	* AJAX responder
	* returns a simple list of all the site widgets to CK Editor Widgets plugin
	*
	*/
	public function tinymce_widget_list(){

		$outbuf = "";
			
		$data = array();
		
		//$data['ckeditor_name'] = $this->input->get('editor_name');
			
		$data['active_widgets'] = $this->widget_manager_model->get_active_widgets();
		
		$this->load->view('partials/tinymce_widget_list', $data);
				
	
	}	
	
	/**
	* AJAX responder
	* returns a simple list of all the site widgets to CK Editor Widgets plugin
	*
	*/
	public function ck_widget_list(){

		$outbuf = "";
			
		$data = array();
		
		$data['ckeditor_name'] = $this->input->get('editor_name');
			
		$data['active_widgets'] = $this->widget_manager_model->get_active_widgets();
		
		$this->load->view('partials/ck_widget_list', $data);
				
	
	}	
	
	
	/**
	* returns HTML table with list of widgets for selected page and zone
	*
	*/
	public function loadwidgetlist($collection_id){
		
		
		$outbuf = "";
		
		
		$this->load->library("image_color");
		
		$this->load->library('formelement');
		
		$data['collection_name'] = $this->widget_manager_model->getcollectionname($collection_id);
				
		$data['collection_id'] = $collection_id;
				
		$sql = "SELECT * FROM {$this->db->dbprefix}widget_zones ORDER BY position ASC";
		
		$query1 = $this->db->query($sql);
		
		$zoneposition = 1;
				
			$data['zoneuparrowdisplay'] =  "none";
			$data['zonedownarrowdisplay'] =  "none";
		
		foreach ($query1->result() as $zonerow){
			
			
			$data['zone_colorcode'] = $zonerow->colorcode;
			$data['zone_name'] = $zonerow->name;
			$data['zone_id'] = 	$zonerow->id;	


			if($zoneposition == 1 && $zoneposition != $query1->num_rows()){ // more than one record
						
				$data['zonedownarrowdisplay'] =  "visible";
						
			}else if($zoneposition == $query1->num_rows() && $zoneposition > 1 ){ 
						
				$data['zoneuparrowdisplay'] =  "visible";
				$data['zonedownarrowdisplay'] =  "none";

			}else if($zoneposition > 1){
						
				$data['zoneuparrowdisplay'] =  "visible";
			
			}
					
			
			$data['zone_darkertone'] = $this->image_color->mixColors ("#666666",$zonerow->colorcode);
			
			$data['zone_name_textcolor'] = $this->image_color->getTextColor($data['zone_darkertone']);
					
			

			
			
			$sql = "SELECT {$this->db->dbprefix}widget_placements.*, {$this->db->dbprefix}widgets.module,  {$this->db->dbprefix}widgets.widget, {$this->db->dbprefix}widgets.instance FROM {$this->db->dbprefix}widget_placements LEFT JOIN {$this->db->dbprefix}widgets ON {$this->db->dbprefix}widget_placements.widget_id = {$this->db->dbprefix}widgets.widget_id ";
			$sql .= " WHERE  {$this->db->dbprefix}widget_placements.collection_id='{$collection_id}' AND {$this->db->dbprefix}widget_placements.zone_id = '{$zonerow->id}' ";
			$sql .= " ORDER BY position ";
			
			$query = $this->db->query($sql);
			
			
			
			$position = 1;

			
			$data['uparrowdisplay'] =  "none";
			$data['downarrowdisplay'] =  "none";
			
			$data['rowalt'] = "odd";
			
			$data['zonelist'] = "";
			
			if ($query->num_rows() > 0){
				

						
				//$data['zonelist'] =  $this->impressto->showpartial("manager.tpl.html",'ZONELISTHEADER',$data);
				
				foreach ($query->result() as $row)
				{
					
					if($data['rowalt'] == "odd") $data['rowalt'] = "even"; else $data['rowalt'] = "odd"; 
										
					$data['placement_id'] =  $row->id;
					$data['widget_id'] =  $row->widget_id;
					
					if($position == 1 && $position != $query->num_rows()){ // more than one record
						
						$data['downarrowdisplay'] =  "visible";
						
					}else if($position == $query->num_rows() && $position > 1 ){ 
						
						$data['uparrowdisplay'] =  "visible";
						$data['downarrowdisplay'] =  "none";

					}else if($position > 1){
						
						$data['uparrowdisplay'] =  "visible";
					}
					
					
					
					$data['module'] =  $row->module;
					$data['widget'] =  $row->widget;
					$data['instance'] =  $row->instance;
					
					$data['widgetlabel'] = "";
					if($row->module == $row->widget){
						$data['widgetlabel'] = $row->module;
					}else{
						$data['widgetlabel'] = $row->module . " >> " . $row->widget;
					}
					
					if($row->instance != "") $data['widgetlabel'] .= " >> " . $row->instance;
					
			
					$configdata = $this->widget_utils->load_widget_config($data['widget'],$data['module']);
			
		
					$data['mod_icon'] = "";
					
					$mod_icon = "";
					
					
				
	
	if($configdata['module_type'] == "widget"){
		
		$mod_icon_path = ASSET_ROOT . PROJECTNAME . "/default/widgets/{$data['widget']}/img/widget_icon.png";
		
		if(file_exists($mod_icon_path)){
			
			$mod_icon = ASSETURL . PROJECTNAME . "/default/widgets/{$data['widget']}/img/widget_icon.png";
		}
		
	}else{
		
		$mod_icon_path = ASSET_ROOT . PROJECTNAME . "/default/{$configdata['module_type']}_modules/{$data['module']}/img/mod_icon.png";
		
		if(file_exists($mod_icon_path)){
			
			$mod_icon = ASSETURL . PROJECTNAME . "/default/{$configdata['module_type']}_modules/{$data['module']}/img/mod_icon.png";
			
		}else{
			
			// legacy path
			$mod_icon_path = ASSET_ROOT . PROJECTNAME . "/default/{$configdata['module_type']}_modules/{$data['module']}/images/mod_icon.png";
			
			if(file_exists($mod_icon_path)){
				
				$mod_icon = ASSETURL . PROJECTNAME . "/default/{$configdata['module_type']}_modules/{$data['module']}/images/mod_icon.png";
				
			}
		}	
	}

	
	if($mod_icon != "") $data['mod_icon'] = "<img class=\"mod_icon\" src=\"{$mod_icon}\" />";
	
					
					
					$data['zonelist'] .= $this->impressto->showpartial("manager.tpl.html",'ZONELISTROW',$data);
					
					$position ++;
					
					
					
				}
				
			}
			
			
			$outbuf .=  $this->impressto->showpartial("manager.tpl.html",'WIDGETLISTMAINROW',$data);
			
			$zoneposition ++;
				
			
			
		}
		

		echo $outbuf;
		
		
		
	}
	
	
	
	
	/**
	*
	*
	*/
	
	public function add_widget_zone(){
		
		
		$name = $this->input->post('name');
		$colorcode = $this->input->post('colorcode');

		$colorcode = str_replace("#","",$colorcode);
		
		
		$return_array['error'] = "SQL Error";
		$return_array['id'] = "";
		$return_array['msg'] = "";
		
		
		// phew, now we have the widget id so lets insert it into the placements table
		$sql = "SELECT MAX(position) AS maxpos FROM {$this->db->dbprefix}widget_zones";
		
		$query = $this->db->query($sql);
		$row = $query->row();
		$maxpos = intval($row->maxpos + 1);
		
				
		$sql = "SELECT id FROM {$this->db->dbprefix}widget_zones WHERE name = '{$name}'";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() == 0){
			
			
			
			$sql = "INSERT INTO {$this->db->dbprefix}widget_zones SET name = '{$name}', colorcode = '{$colorcode}', position = '{$maxpos}' ";
			$query = $this->db->query($sql);
			
			
			$return_array['error'] = "";
			$return_array['msg'] = "inserted";
			$return_array['id'] = $this->db->insert_id();
			
			
			
		}else{
			
			$row = $query->row();

			$return_array['error'] = "";
			$return_array['msg'] = "exists";
			$return_array['id'] = $row->id;
			
			
		}
		
		
		echo json_encode($return_array);
		
		
	}
	
	
	
	
	/**
	*
	*
	*/
	
	public function assign_new_widget(){
		
		
		$collection  = $this->input->get_post("collection");
		$zone_id  = $this->input->get_post("zone_id");
		$widget_id  = $this->input->get_post("widget_id");

		
		if($collection == "" || $zone_id == "" || $widget_id == ""){
			echo "error";
			return;
		}
		
		//$collection = str_replace("pageid_","",$collection);
		
		
		// phew, now we have the widget id so lets insert it into the placements table
		$sql = "SELECT MAX(position) AS maxpos FROM {$this->db->dbprefix}widget_placements WHERE collection_id = '{$collection}' AND zone_id = '{$zone_id}'";
		
		$query = $this->db->query($sql);
		$row = $query->row();
		$maxpos = intval($row->maxpos + 1);
		
		$sql = "SELECT widget_id FROM {$this->db->dbprefix}widget_placements WHERE collection_id = '{$collection}' AND widget_id = '{$widget_id}' AND zone_id = '{$zone_id}'";
		
		$query = $this->db->query($sql);

		if ($query->num_rows() == 0) {
			
			$sql = "INSERT INTO {$this->db->dbprefix}widget_placements (collection_id, widget_id, zone_id, position) VALUES ('{$collection}','{$widget_id }','{$zone_id}','{$maxpos}')";
			//echo $sql;
			$this->db->query($sql);
			
		}

		echo "done";
		
		
	}
	
	
	/**
	*
	*
	*/
	public function move_position(){
		
		$direction  = $this->input->get_post("direction");
		$collection  = $this->input->get_post("collection");
		$zone  = $this->input->get_post("zone");
		$id  = $this->input->get_post("placement_id");
		
		
		// fill in all the gaps first.
		$sql = "SELECT id FROM {$this->db->dbprefix}widget_placements WHERE collection_id = '{$collection}' AND zone_id = '{$zone}' ORDER BY position";
		$query = $this->db->query($sql);
		
		//echo $sql;
		
		
		$position = 0;
		$positions_array = array();
		$target_position = 0;
		
		foreach ($query->result() as $row)
		{
			
			$sql = "UPDATE {$this->db->dbprefix}widget_placements SET position = '{$position}' WHERE  id = '{$row->id}'";
			$this->db->query($sql);
			
			$positions_array['item_' . $position] = $row->id;
			
			if($row->id == $id) $target_position = $position;		
			
			$position ++;
			
		}
		
		
		
		if($direction == "up"){
			
			$sql = "UPDATE {$this->db->dbprefix}widget_placements SET position = (position -1) WHERE  id = '" . $positions_array['item_' . $target_position] . "'";
			$this->db->query($sql);
			$sql = "UPDATE {$this->db->dbprefix}widget_placements SET position = (position +1) WHERE  id = '" . $positions_array['item_' . ($target_position - 1)] . "'";
			$this->db->query($sql);	
		}
		
		if($direction == "down"){
			
			$sql = "UPDATE {$this->db->dbprefix}widget_placements SET position = (position +1) WHERE  id = '" . $positions_array['item_' . $target_position] . "'";
			$this->db->query($sql);
			$sql = "UPDATE {$this->db->dbprefix}widget_placements SET position = (position -1) WHERE  id = '" . $positions_array['item_' . ($target_position + 1)] . "'";
			$this->db->query($sql);	
			
		}
		
		
		
		
		
	}
	
	
	
	
	
	/**
	*
	*
	*/
	public function move_zone_position(){
		
		$direction  = $this->input->get_post("direction");
		$zone_id  = $this->input->get_post("zone_id");
		
		
		// fill in all the gaps first.
		$sql = "SELECT id FROM {$this->db->dbprefix}widget_zones ORDER BY position";
		$query = $this->db->query($sql);
		

		$position = 0;
		$positions_array = array();
		$target_position = 0;
		
		foreach ($query->result() as $row)
		{
			
			$sql = "UPDATE {$this->db->dbprefix}widget_zones SET position = '{$position}' WHERE  id = '{$row->id}'";
			$this->db->query($sql);
			
			$positions_array['item_' . $position] = $row->id;
			
			if($row->id == $zone_id) $target_position = $position;		
			
			$position ++;
			
		}
		
		
		
		if($direction == "up"){
			
			$sql = "UPDATE {$this->db->dbprefix}widget_zones SET position = (position -1) WHERE  id = '" . $positions_array['item_' . $target_position] . "'";
			$this->db->query($sql);
			$sql = "UPDATE {$this->db->dbprefix}widget_zones SET position = (position +1) WHERE  id = '" . $positions_array['item_' . ($target_position - 1)] . "'";
			$this->db->query($sql);	
		}
		
		if($direction == "down"){
			
			$sql = "UPDATE {$this->db->dbprefix}widget_zones SET position = (position +1) WHERE  id = '" . $positions_array['item_' . $target_position] . "'";
			$this->db->query($sql);
			$sql = "UPDATE {$this->db->dbprefix}widget_zones SET position = (position -1) WHERE  id = '" . $positions_array['item_' . ($target_position + 1)] . "'";
			$this->db->query($sql);	
			
		}
			
		
	}
	
	
	
	/**
	*
	*
	*/	
	public function unlink_widget(){
		
		$placement_id  = $this->input->get_post("placement_id");
		
		if($placement_id == ""){
			echo "error";
			return;
		}

		$sql = "DELETE FROM {$this->db->dbprefix}widget_placements WHERE id = '{$placement_id}'";
		
		
		$query = $this->db->query($sql);
		
		echo "done";
		
	}
	
	

	
	/**
	*
	*
	*/	
	public function load_placement_options($id){
		
		
		
		$data['placement_options_id'] = $id;
		
		$outbuf =  $this->impressto->showpartial("manager.tpl.html",'PLACEMENTOPTIONSHEAD',$data);
		
		
		$sql = "SELECT * FROM {$this->db->dbprefix}widget_placement_options ";
		$sql .= " WHERE placement_id='{$id}' ";
		
		$query = $this->db->query($sql);
		
		
		if ($query->num_rows() > 0){
			
			foreach ($query->result() as $row){

				
				$data['name'] =  $row->name;
				$data['value'] =  $row->value;
				
				$outbuf .= $this->impressto->showpartial("manager.tpl.html",'PLACEMENTOPTIONSITEM',$data);
				
			} 
			
		}else{
			
			$data['name'] = "";
			$data['value'] = "";
			
			$outbuf .= $this->impressto->showpartial("manager.tpl.html",'PLACEMENTOPTIONSITEM',$data);
			
		}		
		
		$outbuf .=  $this->impressto->showpartial("manager.tpl.html",'PLACEMENTOPTIONSFOOT');
		
		echo $outbuf;
		
		
	}
	
	
	public function save_placement_options(){
		
		$names  = $this->input->get_post("placement_options_name");
		$values  = $this->input->get_post("placement_options_value");
		$placement_id = $this->input->get_post("placement_options_id");		
		
		
		if(is_array($names) && is_array($names)){
			
			$sql = "DELETE FROM {$this->db->dbprefix}widget_placement_options WHERE placement_id = '{$placement_id}'";
			
			$this->db->query($sql);
			
			$sql = "INSERT INTO ps_widget_placement_options (placement_id, name, value) VALUES ";
			
			$valuearray = array();
			
			for($i = 0; $i < count($names); $i++){
				
				$valuearray[] = "('{$placement_id}','{$names[$i]}','{$values[$i]}')";
				
			}
			
			$sql .= implode(",",$valuearray) . "; ";
			
			//echo $sql;
			
			$this->db->query($sql);
			
			
			
		}
		
		
		
		
	}
	
	
	/**
	*
	*
	*/
	public function deletezone($zone_id){
	
	
		$sql = "SELECT id FROM {$this->db->dbprefix}widget_placements WHERE zone_id = '{$zone_id}'";
		
		$query = $this->db->query($sql);
		
		
		if ($query->num_rows() > 0){
			
			foreach ($query->result() as $row){
			
				$sql = "DELETE FROM {$this->db->dbprefix}widget_placement_options WHERE placement_id = '{$row->id}'";
				$this->db->query($sql);
			}
				
			$sql = "DELETE FROM {$this->db->dbprefix}widget_placements WHERE zone_id = '{$zone_id}'";
			$this->db->query($sql);
		
		}	

		$sql = "DELETE FROM {$this->db->dbprefix}widget_zones WHERE id = '{$zone_id}'";
		$this->db->query($sql);
			
	
		
	
	}
	
	
	
	/**
	*
	*
	*/
	public function deletecollection($collection_id){
	
	
		// first thing is clean up the placements assiiciated with this collection
		
		$sql = "SELECT id FROM {$this->db->dbprefix}widget_placements WHERE collection_id = '{$collection_id}'";
		
		$query = $this->db->query($sql);
		
		
		if ($query->num_rows() > 0){
			
			foreach ($query->result() as $row){
			
				$sql = "DELETE FROM {$this->db->dbprefix}widget_placement_options WHERE placement_id = '{$row->id}'";
				$this->db->query($sql);
			}
				
			$sql = "DELETE FROM {$this->db->dbprefix}widget_placements WHERE collection_id = '{$collection_id}'";
			$this->db->query($sql);
		
		}	

		// now get rid of the collection altogether
			
		$sql = "DELETE FROM {$this->db->dbprefix}widget_collections WHERE id = '{$collection_id}'";
		$query = $this->db->query($sql);
		

		$sql = "DELETE FROM {$this->db->dbprefix}widget_collection_assignments WHERE widget_collection = '{$collection_id}'";
		$this->db->query($sql);
			
	
		
	
	}
	
	


} //end class