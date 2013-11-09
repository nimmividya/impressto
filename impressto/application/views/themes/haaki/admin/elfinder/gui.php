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
					
						if($this->session->userdata('role') == 1) echo "style=\"margin-left:216px;\"";
						else echo "style=\"margin-left:0px;\"";
					
					?>>

						<div class="admin-box" style="min-height:600px">

<h3><i class="icon-folder-open-alt"></i> File Manager</h3>
<?=$infobar?>


					
		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>
				
					 
		
					
					
					
                   </div>   

					</div>
				</div>

				<?php 
				
				//print_r($this->session->userdata);
				if($this->session->userdata('role') == 1):				
							
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
	