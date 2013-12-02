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
	

		
		
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/css/common.css"      type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/css/dialog.css"      type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/css/toolbar.css"     type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/css/navbar.css"      type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/css/statusbar.css"   type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/css/contextmenu.css" type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/css/cwd.css"         type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/css/quicklook.css"   type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/css/commands.css"    type="text/css">

	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/css/fonts.css"       type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/css/theme.css"       type="text/css">

	<!-- elfinder core -->
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/elFinder.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/elFinder.version.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/jquery.elfinder.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/elFinder.resources.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/elFinder.options.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/elFinder.history.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/elFinder.command.js"></script>

	<!-- elfinder ui -->
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/overlay.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/workzone.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/navbar.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/dialog.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/tree.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/cwd.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/toolbar.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/button.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/uploadButton.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/viewbutton.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/searchbutton.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/sortbutton.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/panel.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/contextmenu.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/path.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/stat.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/ui/places.js"></script>

	<!-- elfinder commands -->
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/back.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/forward.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/reload.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/up.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/home.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/copy.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/cut.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/paste.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/open.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/rm.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/info.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/duplicate.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/rename.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/help.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/getfile.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/mkdir.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/mkfile.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/upload.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/download.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/edit.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/quicklook.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/quicklook.plugins.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/extract.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/archive.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/search.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/view.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/resize.js"></script>
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/sort.js"></script>	
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/commands/netmount.js"></script>	

	<!-- elfinder languages -->
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/i18n/elfinder.en.js"></script>


	<!-- elfinder dialog -->
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/jquery.dialogelfinder.js"></script>

	<!-- elfinder 1.x connector API support -->
	<script src="<?php echo ASSETURL . PROJECTNAME; ?>/default/vendor/xtras/elfinder/js/proxy/elFinderSupportVer1.js"></script>

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
    <body class="full_width">

		
		<div id="maincontainer" class="clearfix">

			<header>
				<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
					<div class="navbar-inner">
						<div class="container" style="width:100%">
						
										
							<a class="brand" href="/<?php echo PROJECTNAME; ?>-admin"><img style="max-height:50px; margin-top:-2px;" src="<?php
										
							$clientlogo = ASSET_ROOT . "public/" . $this->config->item('projectnum') . "/images/logo_mini.png";
							$defaultlogo = ASSET_ROOT . PROJECTNAME . "/default/themes/liquid/img/logo_mini.png";
								
							if(file_exists($clientlogo)) echo ASSETURL . "public/" . $this->config->item('projectnum') . "/images/logo_mini.png";
							else echo ASSETURL . PROJECTNAME . "/default/themes/liquid/img/logo_mini.png";
											
							?>" alt="<?php echo ucwords(str_replace("_"," ",PROJECTNAME)); ?> by <?php echo VENDOR; ?>" />
							
							</a>
			
							<ul class="nav navbar-nav user_menu pull-right">
				
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
						</div>
					</div>
				</nav>
				
				

				
			</header>
			
			

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
            
	  <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
<div class="sidebar">
	
	<div class="sidebar_inner_scroll">
		<div class="sidebar_inner">
		
				<?php
				
				$clientlogo = ASSET_ROOT . "public/" . $this->config->item('projectnum') . "/images/logo.png";
				if(file_exists($clientlogo)){ ?>
				
				<a href="/" target="_blank"><img border="0" src="<?php
				echo ASSETURL . "public/" . $this->config->item('projectnum') . "/images/logo.png";
				?>" alt="<?php echo ucwords(str_replace("_"," ",PROJECTNAME)); ?> by <?php echo VENDOR; ?>" /></a>

				<?php }
				
				$cache_id = 'adminleftnav_' . $this->session->userdata('role') . '_' . $this->config->item('current_menu_section') . '_'. $this->router->class;
				
											
				//if( ! $leftnav = $this->cache->get($cache_id)){
					$leftnav = $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/leftnav', $data, TRUE); 
					//$this->cache->write($leftnav,$cache_id);
				//}
				
				
				?>

			<div id="side_accordion" class="panel-group">
			
			
				<?=$leftnav?>
			
			
			



				
				
				
				

	
			</div>
			
			<div class="push"></div>
		</div>
					   
		<div class="sidebar_info">
		
			<div style="padding:2px;">
						Proudly powered by <?php echo ucwords(str_replace("_"," ",PROJECTNAME)); ?>
						<br />Generated in <?php $this->benchmark->mark('code_end'); echo $this->benchmark->elapsed_time('code_start', 'code_end'); ?> seconds
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
