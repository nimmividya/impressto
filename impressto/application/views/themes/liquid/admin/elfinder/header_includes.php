<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// probably loaded already but loading this so we don't get an error .
$this->load->library('asset_loader');

//$this->asset_loader->add_header_css("core/css/reset.css","","all");
	
	
$this->asset_loader->add_header_css("third_party/bootstrap/css/bootstrap.css","","all");
$this->asset_loader->add_header_css("third_party/bootstrap/css/bootstrap-responsive.css","","all");
$this->asset_loader->add_header_css("third_party/font-awesome/css/font-awesome.css","","all");

		
$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/themes/liquid/css/blue.css","","all");
		
$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/third_party/jBreadcrumbs/css/BreadCrumb.css","","all");
$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/third_party/qtip2/jquery.qtip.css","","all");
		
$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/themes/liquid/css/base_style.css","","all");
$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/themes/liquid/css/liquid_style.css","","all");
				
$this->asset_loader->add_header_css("core/css/jquery/jquery_ui/" . $this->config->item('jquery_ui_theme') . "/jquery-ui-" . $this->config->item('jquery_ui_version') . ".custom.css");	
		
$this->asset_loader->add_header_css("third_party/bootstrap/css/toolkits_style.css");	

	
$this->asset_loader->add_header_css("default/third_party/google-code-prettify/prettify.css");	
$this->asset_loader->add_header_css("default/third_party/sticky/sticky.css");	

// these are base admin styles that are loaded last to ensure they apply to all components
$this->asset_loader->add_header_css("core/css/admin_base.css","","all");


echo $this->asset_loader->output_header_css();
		
?>

	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans" />
	<!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico" />
			
<?php
		 
$this->asset_loader->add_header_js_top("third_party/jquery/jquery-" . $this->config->item('jquery_version') . ".js");	
$this->asset_loader->add_header_js_top("third_party/jquery/jquery-ui-" . $this->config->item('jquery_ui_version') . ".js");	

	
$this->asset_loader->add_header_js_top("third_party/bootstrap/js/bootstrap.js");

// bootstrap buttons are messing up the tabs in elfinder image tool
//$this->asset_loader->add_header_js_top("third_party/bootstrap/js/bootstrap_buttons.js");

	
$this->asset_loader->add_header_js_top("default/third_party/qtip2/jquery.qtip.min.js");
$this->asset_loader->add_header_js_top("default/third_party/jBreadcrumbs/js/jquery.jBreadCrumb.1.1.min.js");
$this->asset_loader->add_header_js_top("default/third_party/antiscroll/antiscroll.js");
$this->asset_loader->add_header_js_top("default/third_party/antiscroll/jquery-mousewheel.js");
$this->asset_loader->add_header_js_top("core/js/libs/jquery-templ.js");	
		
$this->asset_loader->add_header_js_top("third_party/jquery/jquery.actual.min.js");
$this->asset_loader->add_header_js_top("third_party/jquery/ios-orientationchange-fix.js");
$this->asset_loader->add_header_js_top("third_party/jquery/jquery.actual.min.js");


$this->asset_loader->add_header_js_top("third_party/jquery/jquery.cookie.min.js");
$this->asset_loader->add_header_js_top("third_party/jquery/jquery.debouncedresize.min.js");
	
$this->asset_loader->add_header_js_top(ASSETURL . PROJECTNAME . "/default/themes/liquid/js/liquid_common.js");




$this->asset_loader->add_header_js_top("core/js/appclass.js");	
$this->asset_loader->add_header_js_top("core/js/appbase.js");		
$this->asset_loader->add_header_js_top("core/js/ps_form.js");	
		
$this->asset_loader->add_header_js_string_top(" ps_base.appname = '" . PROJECTNAME . "'; ");
$this->asset_loader->add_header_js_string_top(" ps_base.asseturl = '" . ASSETURL . "'; ");

	
$this->load->helper('mobile');
		
		
$ismobile = (ps_ismobile() == true) ? 'true' : 'false';
$domobile = (ps_domobile() == true) ? 'true' : 'false';
		
$this->asset_loader->add_header_js_string_top(" ps_base.ismobile = '{$ismobile}'; ps_base.domobile = '{$domobile}'; ");
	
	
// some modules will need to output specific css libraries here
if(isset($customheadertags)){
	echo $customheadertags; 
}
	
echo $this->asset_loader->output_header_js();
	
?>
            

<script>

//* hide all elements & show preloader
document.documentElement.className += 'js';

$(document).ready(function() {
	//* show all elements & remove preloader
	setTimeout('$("html").removeClass("js")',1000);
});

</script>


