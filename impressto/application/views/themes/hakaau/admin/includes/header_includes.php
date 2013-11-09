<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// probably loaded already but loading this so we don't get an error .
$this->load->library('asset_loader');

?>

	<?php

		//if($this->config->item('thirdpartypopup') == FALSE || $this->config->item('thirdpartypopup') == "") {

		//}

	
		$this->asset_loader->add_header_css_top("core/css/reset.css","","all");
		$this->asset_loader->add_header_css_top("core/css/admin_base.css","","all");
	
	
		//$this->asset_loader->add_header_css_top("core/css/style.css","","all");
	
		$this->asset_loader->add_header_css_top("third_party/bootstrap/css/bootstrap.css","","all");
	

	
		$this->asset_loader->add_header_css_top("core/themes/hakaau/css/fonts/ptsans/stylesheet.css","","all");

		$this->asset_loader->add_header_css_top("core/themes/hakaau/css/mws-style.css","","all");


		

		$this->asset_loader->add_header_css_top("third_party/font-awesome/css/font-awesome.css","","all");
			


		$this->asset_loader->add_header_css_top("core/themes/hakaau/jui/css/jquery.ui.all.css","","all");
		$this->asset_loader->add_header_css_top("core/themes/hakaau/jui/jquery-ui.custom.css","","all");


		$this->asset_loader->add_header_css_top("core/themes/hakaau/css/mws-theme.css","","all");

		$this->asset_loader->add_header_css_top("core/themes/hakaau/css/bootstrap-overrides.css","","all");
		
		//$this->asset_loader->add_header_css_top("core/themes/hakaau/css/panels.css","","all");
		
		echo $this->asset_loader->output_header_css();
		
	?>


	
	
	
			
		<!-- <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans" type="text/css" /> -->
	
        <!-- Favicon -->
            <link rel="shortcut icon" href="favicon.ico" />
		
		
		<script>
			//* hide all elements & show preloader
			document.documentElement.className += 'js';
		</script>
		
		
		 
		<?php
		
		//$this->asset_loader->setDebug(TRUE);
		
		 
		$this->asset_loader->add_header_js_top("default/third_party/jquery/jquery-" . $this->config->item('jquery_version') . ".js");	
		$this->asset_loader->add_header_js_top("default/third_party/jquery/jquery-ui-" . $this->config->item('jquery_ui_version') . ".js");	
		
		
		if($this->config->item('thirdpartypopup') == FALSE || $this->config->item('thirdpartypopup') == "") {
		
			$this->asset_loader->add_header_js_top("default/third_party/jquery/jquery.cookie.min.js");
			$this->asset_loader->add_header_js_top(ASSETURL . PROJECTNAME . "/default/themes/haaki/js/jquery.debouncedresize.min.js");
			

			$this->asset_loader->add_header_js_top("core/js/appclass.js");	
			$this->asset_loader->add_header_js_top("core/js/appbase.js");		
			$this->asset_loader->add_header_js_top("core/js/ps_form.js");		
			
			$this->asset_loader->add_header_js_top("third_party/bootstrap/js/bootstrap.js");
			// bootstrap buttons are messing up the tabs in elfinder image tool
			$this->asset_loader->add_header_js_top("third_party/bootstrap/js/bootstrap_buttons.js");
			
			$this->asset_loader->add_header_js_top("default/third_party/qtip2/jquery.qtip.min.js");
			$this->asset_loader->add_header_js_top("default/third_party/jBreadcrumbs/js/jquery.jBreadCrumb.1.1.min.js");
	
	
			$this->asset_loader->add_header_js_top("default/third_party/angular/angular.min.js");
			
			// this framework sometimes uses handlebars along with angular. Don't judge!!! 
			$this->asset_loader->add_header_js_top("default/third_party/handlebars.js");
		
			// used for printing help docs
			$this->asset_loader->add_header_js_top("third_party/jquery/jquery.printelement.js");
						
			
			$this->asset_loader->add_header_js_top("default/third_party/antiscroll/antiscroll.js");
			$this->asset_loader->add_header_js_top("default/third_party/antiscroll/jquery-mousewheel.js");
			
				
		
		}
		

			//$this->asset_loader->add_header_js_top(ASSETURL . PROJECTNAME . "/default/themes/hakaau/js/libs/jquery.mousewheel.min.js");
			//$this->asset_loader->add_header_js_top(ASSETURL . PROJECTNAME . "/default/themes/hakaau/js/libs/jquery.placeholder.min.js");

    

			//$this->asset_loader->add_header_js_top(ASSETURL . PROJECTNAME . "/default/themes/hakaau/jui/jquery-ui.custom.min.js");
			//$this->asset_loader->add_header_js_top(ASSETURL . PROJECTNAME . "/default/themes/hakaau/jui/js/jquery.ui.touch-punch.js");


			//$this->asset_loader->add_header_js_top(ASSETURL . PROJECTNAME . "/default/themes/hakaau/plugins/datatables/jquery.dataTables.min.js");
		
		?><!--[if lt IE 9]><?php
			//$this->asset_loader->add_header_js_top(ASSETURL . PROJECTNAME . "/default/themes/hakaau/js/libs/excanvas.min.js");
		?><![endif]--><?php
		
		

		$this->asset_loader->add_header_js_top(ASSETURL . PROJECTNAME . "/default/themes/hakaau/js/mws.js");


		

		$this->asset_loader->add_header_js_string_top(" ps_base.appname = '" . PROJECTNAME . "'; ");
		$this->asset_loader->add_header_js_string_top(" ps_base.asseturl = '" . ASSETURL . "'; ");
		$this->asset_loader->add_header_js_string_top(" ps_base.projectnum = '" . PROJECTNUM . "'; ");
		$this->asset_loader->add_header_js_string_top(" ps_base.templateurl = '" . TEMPLATEURL . "'; ");
				
		
	
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
				$(document).ready(function() {
					//* show all elements & remove preloader
					//setTimeout('$("html").removeClass("js")',1000);
					
					
					//$('#mainnaviconsslider').tinycarousel({ display: 2 });
					
				});
			</script>


  
