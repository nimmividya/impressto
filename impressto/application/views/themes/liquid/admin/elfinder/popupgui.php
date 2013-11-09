<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI = & get_instance();

// Get the default wysiwyg editor. This is required since we need to know what WYSIWYG editor called this view
if(!$CI->config->item('wysiwyg_editor')){
	
	$CI->load->model("site_settings/site_settings_model");
	$site_options = $CI->site_settings_model->get_settings();
				
	if(!isset($site_options['wysiwyg_editor']) || $site_options['wysiwyg_editor'] == "") $wysiwyg_editor = "none";
	else $wysiwyg_editor = $site_options['wysiwyg_editor'];
	// store it so we don't have to call this routine again
	$CI->config->set_item('wysiwyg_editor',$site_options['wysiwyg_editor']);
										
}else{
	$wysiwyg_editor = $CI->config->item('wysiwyg_editor');	
}

		
?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>elFinder 2.0</title>

		<?php
		
			$data = array();
			
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

				

<!-- elFinder initialization (REQUIRED) -->

<?php if($wysiwyg_editor == "tiny_mce") { ?>

<script type="text/javascript" src="<?php echo  ASSETURL; ?>third_party/tiny_mce/tiny_mce_popup.js"></script>

<?php } ?>


<script type="text/javascript" charset="utf-8">

// DOES NOT SEEM TO BE IN USE !!!		
// Helper function to get parameters from the query string.

function getUrlParam(paramName) {
	var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
	var match = window.location.search.match(reParam) ;
	return (match && match.length > 1) ? match[1] : '' ;
			
}



	
$().ready(function() {

<?php if($wysiwyg_editor == "tiny_mce") { ?>
	
  var FileBrowserDialogue = {
    init: function() {
      // Here goes your code for setting your custom things onLoad.
    },
    mySubmit: function (URL) {
      var win = tinyMCEPopup.getWindowArg('window');

      // pass selected file path to TinyMCE
      win.document.getElementById(tinyMCEPopup.getWindowArg('input')).value = URL;

      // are we an image browser?
      if (typeof(win.ImageDialog) != 'undefined') {
        // update image dimensions
        if (win.ImageDialog.getImageData) {
          win.ImageDialog.getImageData();
        }
        // update preview if necessary
        if (win.ImageDialog.showPreviewImage) {
          win.ImageDialog.showPreviewImage(URL);
        }
      }

      // close popup window
      tinyMCEPopup.close();
    }
  }

  tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);
  
  
<?php } ?>

<?php

	// this is used for popup calls that will sent the selected file path back to a non-WYSIWYG field
				
	$ajpx_targetfield = "";
	$ckeditor_targetfield = "";
	
			
	if(strpos(getenv("REQUEST_URI"), "CKEditor=") !== false || strpos(getenv("REQUEST_URI"), "ajpx_targetfield=") !== false	){
		if(isset($_GET['ajpx_targetfield']) && $_GET['ajpx_targetfield'] != "") $ajpx_targetfield = $_GET['ajpx_targetfield'];
		else if($_GET['CKEditorFuncNum'] != "") $ckeditor_targetfield = $_GET['CKEditorFuncNum'];
	}
				
	$elfinder_callback = "";
				
	if(strpos(getenv("REQUEST_URI"), "CKEditor=") !== false || strpos(getenv("REQUEST_URI"), "callback=") !== false	){
		if(isset($_GET['callback']) && $_GET['callback'] != "") $elfinder_callback = $_GET['callback'];
	}
				
?>

	
				
	var ajxplorer_ispopup = 'true';
			
			
	var elf = $('#elfinder').elfinder({
		url : '/file_browser/elfinder_init/', // connector URL (REQUIRED)
		lang: 'en',             // language (OPTIONAL)
		handlers : {
			select : function(event, elfinderInstance) {
				var selected = event.data.selected;
						
				if (selected.length) {
					console.log(elfinderInstance.file(selected[0]))
				}
						
			}
		},
		getFileCallback : function(file) {
			
		/* file attribs are: mime, ts, read, write, size, hash, name, phash, date, tmb, baseUrl, url, path, width, height, dim  */
		
<?php if( isset($_GET['ajpx_targetfield']) && $_GET['ajpx_targetfield'] != "") { ?>
	
		window.opener.ps_base.updatetarget('<?=$_GET['ajpx_targetfield']?>', file.url);

<?php }else if($wysiwyg_editor == "ckeditor") { ?>
	
			window.opener.CKEDITOR.tools.callFunction('<?=$ckeditor_targetfield?>', file.url);


<?php }else if($wysiwyg_editor == "tiny_mce"){ ?>
						
		FileBrowserDialogue.mySubmit(file.url); // pass selected file path to TinyMCE 
							
<?php } 

		// callback is used for widgets and other components that need a post update function call
		if($elfinder_callback != ""){ ?>
		
			eval("window.opener.<?=$elfinder_callback?>"); 
			
		<?php } ?>
		
			window.close(); // we're done
		},
		resizable: false,
	}).elfinder('instance');
});
</script>
				
</head>
<body>
	
		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>
			
	</body>
</html>
		

		

		
