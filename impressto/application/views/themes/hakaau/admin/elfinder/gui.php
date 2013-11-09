<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en"<?php if(isset($ng_app_name)) echo " ng-app=\"{$ng_app_name}\";" ?>>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Super Admin Section | <?php echo PROJECTNAME; ?></title>
		<!-- The base tag can cause issues with jQuery UI 1.9 Tabs. SEE http://bugs.jqueryui.com/ticket/8637 -->
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
							 if(window.console) console.log(elfinderInstance.file(selected[0]))
							}
						
						}
					}
				
				}).elfinder('instance');
			});
		</script>
		
    </head>
  
<body>


	<!-- Header -->
	<div id="mws-header" class="clearfix">
    
    	<!-- Logo Container -->
    	<div id="mws-logo-container">
        
        	<!-- Logo Wrapper, images put within this wrapper will always be vertically centered -->
        	<div id="mws-logo-wrap">
            	<img src="/assets/public/2013/skin/main/images/logog.png" alt="mws admin">
			</div>
        </div>
        
        <!-- User Tools (notifications, logout, profile, change password) -->
        <div id="mws-user-tools" class="clearfix">
        
        	<!-- Notifications -->
        	<div id="mws-user-notif" class="mws-dropdown-menu">
            	<a href="#" data-toggle="dropdown" class="mws-dropdown-trigger"><i class="icon-exclamation-sign"></i></a>
                
                <!-- Unread notification count -->
                <span class="mws-dropdown-notif">35</span>
                
                <!-- Notifications dropdown -->
                <div class="mws-dropdown-box">
                	<div class="mws-dropdown-content">
                        <ul class="mws-notifications">
                        	<li class="read">
                            	<a href="#">
                                    <span class="message">
                                        Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="read">
                            	<a href="#">
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="unread">
                            	<a href="#">
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="unread">
                            	<a href="#">
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="mws-dropdown-viewall">
	                        <a href="#">View All Notifications</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Messages -->
            <div id="mws-user-message" class="mws-dropdown-menu">
            	<a href="#" data-toggle="dropdown" class="mws-dropdown-trigger"><i class="icon-envelope"></i></a>
                
                <!-- Unred messages count -->
                <span class="mws-dropdown-notif">35</span>
                
                <!-- Messages dropdown -->
                <div class="mws-dropdown-box">
                	<div class="mws-dropdown-content">
                        <ul class="mws-messages">
                        	<li class="read">
                            	<a href="#">
                                    <span class="sender">John Doe</span>
                                    <span class="message">
                                        Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="read">
                            	<a href="#">
                                    <span class="sender">John Doe</span>
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="unread">
                            	<a href="#">
                                    <span class="sender">John Doe</span>
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="unread">
                            	<a href="#">
                                    <span class="sender">John Doe</span>
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="mws-dropdown-viewall">
	                        <a href="#">View All Messages</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- User Information and functions section -->
            <div id="mws-user-info" class="mws-inset">
            
            	<!-- User Photo -->
            	<div id="mws-user-photo">
                	<img src="example/profile.jpg" alt="User Photo">
                </div>
                
                <!-- Username and Functions -->
                <div id="mws-user-functions">
                    <div id="mws-username">
                        Hello, John Doe
                    </div>
                    <ul>
                    	<li><a href="#">Profile</a></li>
                        <li><a href="#">Change Password</a></li>
                        <li><a href="index.html">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Start Main Wrapper -->
    <div id="mws-wrapper">
    
    	<!-- Necessary markup, do not remove -->
		<div id="mws-sidebar-stitch"></div>
		<div id="mws-sidebar-bg"></div>
        
        <!-- Sidebar Wrapper -->
        <div id="mws-sidebar">
        
            <!-- Hidden Nav Collapse Button -->
            <div id="mws-nav-collapse">
                <span></span>
                <span></span>
                <span></span>
            </div>
            
 
            
            <!-- Main Navigation -->
            <div id="mws-navigation">
			
			<ul>
			
				<li><a href="/admin/"><i class="icon-home"></i> Dashboard</a></li>
			
			
				<?php
								
					$cache_id = 'adminleftnav_' . $this->session->userdata('role') . '_' . $this->config->item('current_menu_section') . '_'. $this->router->class;
								
					//if( ! $leftnav = $this->cache->get($cache_id)){
							$leftnav = $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/leftnav', $data, TRUE); 
							//$this->cache->write($leftnav,$cache_id);
					//}
								
								
					
							
								echo $leftnav; 
								
						
									
								
								?>
								
								
			</ul>
			
               </div>         
        </div>
        
        <!-- Main Container Start -->
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
			
			
				<div class="panel">
	
					<div class="panel-header">
		
			
			
						<h2><i class="icon-folder-open-alt"></i> File Manager</h2>

					</div>
	
		 <div class="body">
		 

	<?=$infobar?>
					
		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>
				
					 
		
					
					
		 </div>  <!-- body End -->
	
               </div> 
                <!-- Panels End -->
            </div>
            <!-- Inner Container End -->
                       
            <!-- Footer -->
            <div id="mws-footer">
            	Copyright Your Website 2012. All Rights Reserved.
            </div>
            
        </div>
        <!-- Main Container End -->
        
    </div>

	
<?php

	echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/footer', $data, TRUE); 
			
?>
	
</body>
</html>