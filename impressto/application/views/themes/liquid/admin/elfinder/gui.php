<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en"<?php if(isset($ng_app_name)) echo " ng-app=\"{$ng_app_name}\";" ?>>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Super Admin Section | <?php echo PROJECTNAME; ?></title>
		<base href="<?php echo base_url(); ?>" />
	

			
		<?php
	
						
		// load up all the header assets after the content is loader
		echo $this->load->view("themes/" .$this->config->item('admin_theme') . '/admin/elfinder/header_includes', $data, TRUE); 
			
		
		?>
	

		
		
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/css/common.css"      type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/css/dialog.css"      type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/css/toolbar.css"     type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/css/navbar.css"      type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/css/statusbar.css"   type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/css/contextmenu.css" type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/css/cwd.css"         type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/css/quicklook.css"   type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/css/commands.css"    type="text/css">

	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/css/fonts.css"       type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/css/theme.css"       type="text/css">

	<!-- elfinder core -->
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/elFinder.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/elFinder.version.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/jquery.elfinder.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/elFinder.resources.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/elFinder.options.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/elFinder.history.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/elFinder.command.js"></script>

	<!-- elfinder ui -->
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/overlay.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/workzone.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/navbar.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/dialog.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/tree.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/cwd.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/toolbar.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/button.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/uploadButton.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/viewbutton.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/searchbutton.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/sortbutton.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/panel.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/contextmenu.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/path.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/stat.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/ui/places.js"></script>

	<!-- elfinder commands -->
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/back.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/forward.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/reload.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/up.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/home.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/copy.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/cut.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/paste.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/open.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/rm.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/info.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/duplicate.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/rename.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/help.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/getfile.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/mkdir.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/mkfile.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/upload.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/download.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/edit.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/quicklook.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/quicklook.plugins.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/extract.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/archive.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/search.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/view.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/resize.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/sort.js"></script>	
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/commands/netmount.js"></script>	

	<!-- elfinder languages -->
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/i18n/elfinder.en.js"></script>


	<!-- elfinder dialog -->
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/jquery.dialogelfinder.js"></script>

	<!-- elfinder 1.x connector API support -->
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/elfinder/js/proxy/elFinderSupportVer1.js"></script>

	<!-- elfinder custom extenstions -->
	
	


		<!-- elFinder initialization (REQUIRED) -->
		<script type="text/javascript" charset="utf-8">
			$().ready(function() {
				var elf = $('#elfinder').elfinder({
					url : '/file_browser/elfinder_init/',  // connector URL (REQUIRED)
					lang: 'en',             // language (OPTIONAL)
					handlers : {
						select : function(event, elfinderInstance) {
							var selected = event.data.selected;
						
							if (selected.length) {
							 console.log(elfinderInstance.file(selected[0]))
							}
						
						}
					}
				
				}).elfinder('instance');
			});
		</script>
		
	
    </head>
    <body>
		<div id="loading_layer" style="display:none"><img src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/themes/liquid/img/ajax_loader.gif" alt="loader" /></div>
		
		
				
		<div id="maincontainer" class="clearfix">
			<!-- header -->
            <header>
                <div class="navbar navbar-fixed-top">
                    <div class="navbar-inner">
                        <div class="container-fluid">
						
						
							<a class="brand" href="/admin/"><i class="icon-home icon-white"></i>
							
								
							<img style="max-height:50px; margin-top:-8px;" src="<?php
										
							$clientlogo = ASSET_ROOT . "public/" . $this->config->item('projectnum') . "/images/logo_mini.png";
							$defaultlogo = ASSET_ROOT . PROJECTNAME . "/default/themes/liquid/img/logo_mini.png";
								
							if(file_exists($clientlogo)) echo ASSETURL . "public/" . $this->config->item('projectnum') . "/images/logo_mini.png";
							else echo ASSETURL . PROJECTNAME . "/default/themes/liquid/img/logo_mini.png";
											
							?>" alt="<?php echo ucwords(str_replace("_"," ",PROJECTNAME)); ?> by <?php echo VENDOR; ?>" />
							
							</a>
																	
											
                            <ul class="nav user_menu pull-right">
							
							
								<li class="dropdown">
                                    <a href="http://kb.central.bitheads.ca/" target="_blank"><i class="icon-book icon-white"></i> Help</a>
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
							
						?>
		

							</nav>
				
    
                        </div>
                    </div>
                </div>
				
				
				
				
				
		
	
				
				
				
            </header>
            
            <!-- main content -->
            <div id="contentwrapper">
                <div class="main_content">
				
				
				
				<div class="admin-box" style="min-height:600px">

<h3>File Manager</h3>
<?=$infobar?>


					
		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>
				
					
		
					
					
					
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
															
								
								echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/leftnav', $data, TRUE); 
								
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
		
		

		


	</body>
</html>