<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en"<?php if(isset($ng_app_name)) echo " ng-app=\"{$ng_app_name}\";" ?>>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Super Admin Section | <?php echo PROJECTNAME; ?></title>
		<!-- The base tag can cause issues with jQuery UI 1.9 Tabs. SEE http://bugs.jqueryui.com/ticket/8637 -->
		<base href="<?php echo base_url(); ?>" />
	

			
		<?php
		
		if(!isset($current_module)) $current_module = "";
		
	
		//$data['main_content'] = $main_content;
						
		// load up all the header assets after the content is loader
		echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/header_includes', $data, TRUE); 
			
		
	?>

		
    </head>
  
<body class="bg_c sidebar fixed">

	<?php
	
	echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/header', $data, TRUE); 
				
	?>
	




	<div id="main">
		<div class="wrapper">
			<div id="main_section" class="cf brdrrad_a">
			
				<?php echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/breadcrumbs', $data, TRUE); ?>

					
					


				<div id="content_wrapper">
					<div id="main_content" <?php
					
						// if we are in dashboard view, even an admin sees what everyone else sees.	
						if($this->session->userdata('role') == 1 && $current_module != "dashboard") echo "style=\"margin-left:216px;\"";
						else echo "style=\"margin-left:0px;\"";
					
					?>>
					
					<?php
				
								

if(isset($parsedcontent)){
	echo $parsedcontent;
}else{
	$this->load->view($main_content, $data); 
}


	?>


					</div>
				</div>
				
				<?php 
				
				//print_r($this->session->userdata);
				if($this->session->userdata('role') == 1 && $current_module != "dashboard") :				
							
				?>

				<div id="sidebar">
				
				
						<?php
								
						$cache_id = 'adminleftnav_' . $this->session->userdata('role') . '_' . $this->config->item('current_menu_section') . '_'. $this->router->class;
								
						//if( ! $leftnav = $this->cache->get($cache_id)){
							$leftnav = $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/leftnav', $data, TRUE); 
							//$this->cache->write($leftnav,$cache_id);
					//	}
								
								
						echo $leftnav; 
												
								
						?>
			
				</div>
				
				<?php endif; ?>
				
				




			</div>
			


		</div>
		


	</div>





			
<?php

	echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/footer', $data, TRUE); 
			
?>
	
