<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* This initializes Tiny_MCE 
*
*/

?>

function init_my_tinyMCE(lang){


	tinyMCE.init({
	
		// General options
		mode : "textareas",
        theme : "advanced",
        editor_selector : "mceAdvanced",
		
		language : lang,
		
		convert_urls: false,
		cleanup : false,
		cleanup_on_startup : false,

		skin : "o2k7",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,widgets, fbldfield, iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect,forecolor,backcolor,pasteword",
		theme_advanced_buttons2 : "search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,tablecontrols",
		theme_advanced_buttons3 : "hr,removeformat,visualaid,|,sub,sup,|,charmap,advhr,|,print,|,ltr,rtl,|,fullscreen,|,insertlayer,moveforward,movebackward,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,widgets,fbldfield",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		file_browser_callback : 'elFinderBrowser',
		
		<?php
		
		if(file_exists(ASSET_ROOT . "public/" . PROJECTNUM . "/css/wysiwyg_style.css")){
			
			echo "	content_css : \"" . ASSETURL . "public/" . PROJECTNUM . "/css/wysiwyg_style.css\", \n";
			
		}else{
		
			echo "	content_css : \"" . ASSETURL . "public/css/style.css\", \n";
				
		}
		
		?>

		external_link_list_url : "/page_manager/admin_remote/tiny_mce_page_list/" + lang,
		
		//external_image_list_url : "lists/image_list.js", // we do not need this because we are using elfinder
		//media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
	
	
	
	tinyMCE.init({
		// General options
		mode : "textareas",
        editor_selector : "mceSimple",
        theme : "simple",
		skin : "o2k7"
	});
	


}



$(function() {


	init_my_tinyMCE('<?=$lang?>'); //default to whatever the current language is
	



});



function elFinderBrowser (field_name, url, type, win) {
  var elfinder_url = '/file_browser/?tiny_mce=true';    // use an absolute path!
  tinyMCE.activeEditor.windowManager.open({
    file: elfinder_url,
    title: 'elFinder 2.0',
    width: 900,  
    height: 450,
    resizable: 'yes',
    inline: 'yes',    // This parameter only has an effect if you use the inlinepopups plugin!
    popup_css: false, // Disable TinyMCE's default popup CSS
    close_previous: 'no'
  }, {
    window: win,
    input: field_name
  });
  return false;
}

	