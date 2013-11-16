<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en"<?php if(isset($ng_app_name)) echo " ng-app=\"{$ng_app_name}\";" ?>>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Super Admin Section | <?php echo PROJECTNAME; ?></title>
		<!-- The base tag can cause issues with jQuery UI 1.9 Tabs. SEE http://bugs.jqueryui.com/ticket/8637 -->
		<base href="<?php echo base_url(); ?>" />
	

			
		<?php
	
		//$data['main_content'] = $main_content;
						
		// load up all the header assets after the content is loader
		echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/header_includes', $data, TRUE); 
			
		
	?>
	
    </head>
    <body class="full_width">
		<div id="loading_layer" style="display:none"><img src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/themes/liquid/img/ajax_loader.gif" alt="loader" /></div>
		
		
				
		<div id="maincontainer" class="clearfix">
			<!-- header -->
            <header>
                <div class="navbar navbar-fixed-top">
                    <div class="navbar-inner">
                        <div class="container-fluid">
						
						
							<a class="brand" href="/<?php echo PROJECTNAME; ?>-admin"><i class="icon-home icon-white"></i>
							
							<img style="max-height:50px; margin-top:-8px;" src="<?php
										
							$clientlogo = ASSET_ROOT . "public/" . $this->config->item('projectnum') . "/images/logo_mini.png";
							$defaultlogo = ASSET_ROOT . PROJECTNAME . "/default/themes/liquid/img/logo_mini.png";
								
							if(file_exists($clientlogo)) echo ASSETURL . "public/" . $this->config->item('projectnum') . "/images/logo_mini.png";
							else echo ASSETURL . PROJECTNAME . "/default/themes/liquid/img/logo_mini.png";
											
							?>" alt="<?php echo ucwords(str_replace("_"," ",PROJECTNAME)); ?> by <?php echo VENDOR; ?>" />
							
							</a>
																	
											
                            <ul class="nav user_menu pull-right">
							
							
								<li class="dropdown">
                                    <a href="/admin_help/" target="_blank"><i class="icon-book icon-white"></i> Help</a>
			                     </li>
										
									
				                            
                                <li class="divider-vertical hidden-phone hidden-tablet"></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php
									
									echo $this->session->userdata('username');
									
									
									?> <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
										<li><a href="/edit_my_profile">My Profile</a></li>
										<li><a href="/site_settings/">Site Settings</a></li>
										<li class="divider"></li>
										<li><a href="/logout/">Log Out</a></li>
                                    </ul>
                                </li>
                            </ul>
							<a data-target=".nav-collapse" data-toggle="collapse" class="btn_menu">
								<span class="icon-align-justify icon-white"></span>
							</a>
							
							
							
							
							<nav>
							
							<?php
							
							$user_session_data = $this->session->all_userdata();	
							$user_role = $user_session_data['role']; 
							
					
		
							if($user_role == 1){ // this is for the administrator to toggle the WYSIWYG editor on the fly ?>
							
							<div style="margin-top:5px;">
							<span style="color:#FFFFFF; float:left; margin-top:5px; font-size:10px; font-weight:bold">WYSIWYG</span>
							<div id="wysiwyg_block_toggle" class='toggle yellow_toggle' data-enabled="ON" data-disabled="OFF" data-toggle="toggle">
								<input type="checkbox" value="1" name="myCheckbox" class="checkbox" <?php
								
									$block_wysiwyg_editing = $this->input->cookie('block_wysiwyg_editing', FALSE);
									
									if(!$block_wysiwyg_editing ||  $block_wysiwyg_editing == "false" || $block_wysiwyg_editing == "" ) echo " checked=\"checked\"";
																		
									 
								?> />
								<label class="check" for="myCheckbox"></label>
							</div>
							</div>
							
							<script>
							 // Don't use .toggle, it will be global.
							 $('#wysiwyg_block_toggle').toggle({
								onClick: function (event, status) {
								
									$.cookie("block_wysiwyg_editing", status, {path : '/'} );
																	
								}, // Do something on status change if you want
								text: {
									enabled: false, // Change the enabled disabled text on the fly ie: 'ENABLED'
									disabled: false // and for 'DISABLED'
								},
								style: {
									enabled: 'btn-warning', // default button styles like btn-primary, btn-info, btn-warning just remove the btn- part.
									disabled: false // same goes for this, primary, info, warning, danger, success. 
								}
							});
							</script>
							
							<?php } ?>
							</nav>
				
    
                        </div>
                    </div>
                </div>
				
				
				
            </header>
            

			

            <!-- main content -->
            <div id="contentwrapper">
                <div class="main_content">
				
				
                    

   				<?php echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/breadcrumbs', $data, TRUE); ?>

					
								
					<?php
				
								

if(isset($parsedcontent)){
	echo $parsedcontent;
}else{
	$this->load->view($main_content, $data); 
}


	?>
	
	<div class="clearfix"></div>
	
	<div style="bottom: 0; left: 180; margin-bottom:20px;">
	


	</div>						
                        
                </div>
				
	
            </div>
            
			<!-- sidebar -->
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				
				<div class="antiScroll">
					<div class="antiscroll-inner">
						<div class="antiscroll-content">
					
							<div class="sidebar_inner">
							
								<?php
								
								$clientlogo = ASSET_ROOT . "public/" . $this->config->item('projectnum') . "/images/logo.png";
								if(file_exists($clientlogo)){ ?>
								
								<a href="/" target="_blank"><img border="0" src="<?php
								echo ASSETURL . "public/" . $this->config->item('projectnum') . "/images/logo.png";
								?>" alt="<?php echo ucwords(str_replace("_"," ",PROJECTNAME)); ?> by <?php echo VENDOR; ?>" /></a>

								<?php }
								
								$cache_id = 'adminleftnav_' . $this->session->userdata('role') . '_' . $this->config->item('current_menu_section') . '_'. $this->router->class;
								
															
								if( ! $leftnav = $this->cache->get($cache_id)){
									$leftnav = $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/leftnav', $data, TRUE); 
									$this->cache->write($leftnav,$cache_id);
								}
								
								
								echo "<div id=\"leftnav\">";
										
													
								echo $leftnav; 
								
								echo "</div>";
									
								
								?>
										
								
								<div class="push"></div>
								
								<div style="font-size:10px; background: none repeat scroll 0 0; bottom: 0; position: absolute; left:0px; width: 100%;">
									<div style="padding:2px; background:#CCCCCC">
									<?php echo ucwords(str_replace("_"," ",PROJECTNAME)); ?>
									<br />&copy;<?php echo date("Y")?>, <a href="http://<?php echo VENDORURL; ?>" target="_blank"><?php echo VENDOR; ?></a>.
									<br />Generated in <?php $this->benchmark->mark('code_end'); echo $this->benchmark->elapsed_time('code_start', 'code_end'); ?> seconds
									</div>
								<div>

							</div>
							   

						
						</div>
					</div>
				</div>
				

			
			</div>
			
			

	</div>
	
		
	</div>
	
	</div>		
		

		
<div id="ajaxLoadAni">
	<img src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/images/ajax-loader.gif" alt="Ajax Loading Animation" />
	<span>Processing...</span>
</div><!-- [END] #ajaxLoadAni -->

<?php
	
	
	echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/footer_includes', $data, TRUE); 
		
?>

	</body>
</html>