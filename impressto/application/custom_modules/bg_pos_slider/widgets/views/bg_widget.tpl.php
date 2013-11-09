<!--
@Name: BG POS SLIDER
@Type: PageShaper
@Author: acart
@Projectnum: 4858
@Version: 1.2
@Status: complete
@Date: 2012-10-17
-->


<!-- BEGIN BGPOSMAINBODY -->

<?php  

// IMPORTANT NOTE: This component will only work with jquery 1.5 or lower. It used the fx class which was removed after jquery 1.5

$CI = &get_instance();  


$CI->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/custom_modules/bg_pos_slider/js/jquery.bgpos.js");
$CI->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/custom_modules/bg_pos_slider/js/jquery.lightbox-0.5.min.js");
$CI->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/custom_modules/bg_pos_slider/js/bgslider.js");
$CI->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/custom_modules/bg_pos_slider/css/bgs_style.css");
		

$jsstring = "";
		
for($i=0; $i < count($background_images); $i++){
			
	$jsstring .= " .bg" . ($i+1) . "{ background-image: url('" . ASSETURL . "/uploads/" . PROJECTNAME . "/bg_pos_slider/images/backgrounds/{$background_images[$i]}');  }\n";
				
}
			
$CI->asset_loader->add_header_css_string($jsstring);

// we simply assume smarty is loaded here

		
if(isset($widget_options['prev_page']) && $widget_options['prev_page'] != ""){
	$CI->mysmarty->assign('widget_prev_page', $widget_options['prev_page']);	
}

if(isset($widget_options['next_page']) && $widget_options['next_page'] != ""){
	$CI->mysmarty->assign('widget_next_page', $widget_options['next_page']);	
}


		
		
		

?>

	
           <div id="bgs_content">
		
            <div id="menuWrapper" class="menuWrapper bg1">
                <ul class="menu" id="menu">
					<?php 
										
					for($i=0; $i < count($blocktitle); $i++){ 
						
							if($i == 0){
								$bgposition = "0 0";  // first item is visible to set bg position to 0
							}else{
								$bgposition = "-325px 0";
							}
					?>
					<li class="bg1" style="background-position:<?php echo $blockbgpos[$i]; ?>px 0;">
                        <a id="bg<?php echo ($i + 1); ?>" href="<?php if($blocklink[$i] != ""){ echo $blocklink[$i]; }else{ echo "#"; } ?>"><?php echo $blocktitle[$i]; ?></a>
                        <ul id="sub<?php echo ($i + 1); ?>" class="sub<?php echo ($i + 1); ?>" style="background-position:<?php echo $bgposition; ?>;">
                            <li class="bgs_content_<?php echo ($i + 1); ?>">
							
							
							<?php echo $blockcontent[$i]; ?>
							
							</li>
                        </ul>
                    </li>
					
					<?php } ?>
					
                 
					
       
                </ul><!-- [END] #menu .menu -->
            </div><!-- [END] #menuWrapper -->
		</div><!-- [END] #bgs_content -->
		


<!-- END BGPOSMAINBODY -->
