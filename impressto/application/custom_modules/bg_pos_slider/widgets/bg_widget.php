<?php

// sample tags
//  [widget type='bg_pos_slider/bg_widget' bgcolor='#AA22FF' title=wawaewa]

class bg_widget extends Widget
{
    function run() {
	

		$args = func_get_args();
		
	
        // if paramaeters have been passed to this widget, assign them	
		if(isset($args[0]) && is_array($args[0])){
		
			$widget_args = $args[0];
			if(isset($args[0]['name'])) $data['widget_name'] = $args[0]['name'];
				
		}


		$this->load->library('impressto');
		$this->load->library('asset_loader');
		$this->load->library('widget_utils');
		
		
		
		
		//echo dirname(__FILE__) . "/views";
		
		$this->impressto->setDir(dirname(__FILE__) . "/views");
	

		$blocktitle = array();
		$blocklink = array();
		$blockcontent= array();
		$blockbgpos = array();
	
		$sql = "SELECT * FROM ps_bgslider WHERE widget_name = '{$data['widget_name']}' ORDER BY position";
	
		$result = mysql_query($sql);
	
		$bgpos = 0;
	
		while($row = mysql_fetch_assoc($result)){
	
			$blocktitle[] = $row['title'];
			$blocklink[] = $row['link'];						
			$blockcontent[] = $row['content'];
			$blockbgpos[] = $bgpos;	
			$background_images[] = $row['widget_name'] . "/" . $row['background_image'];
			
			//	peterd - change this value if you are changing the size of the sliders
			$bgpos -= 244;
	
		}
		

		$widget_id = $this->widget_utils->getwidgetid('bg_widget', 'bg_pos_slider', $data['widget_name']);
		
		$widget_options = $this->widget_utils->get_widget_options($widget_id);
		
		
		
	
		$data = array(
		
			'blocktitle' => $blocktitle,
			'widget_options' => $widget_options,
			'blocklink' => $blocklink,
			'blockcontent'=>$blockcontent,
			'blockbgpos'=>$blockbgpos,
			'background_images'=>$background_images
		);

		echo $this->impressto->showpartial("bg_widget.tpl.php",'BGPOSMAINBODY',$data);
		
		return;
		
		 
    }
}  
