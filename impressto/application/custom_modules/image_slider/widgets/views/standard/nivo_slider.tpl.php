<!--
@Name: Nivo Slider
@Type: PHP
@Author: peterdrinnan peterdrinnan
@Projectnum: 1001
@Version: 1.0
@Status: complete
@Date: 2012-06-12
-->

<?php

$CI =& get_instance(); 
$CI->load->library('asset_loader');
$CI->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/image_slider/js/jquery.nivo.slider.js");	
$CI->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/custom_modules/image_slider/css/default.css");	


$lang = $CI->config->item('lang_selected');
	
	
?>




	<script type="text/javascript">
	
      $(window).load(function() {
       $('#slider').nivoSlider({
                effect:'<?=$slideshow_setting['effect']?>',
                slices:1,
                animSpeed:'<?=$slideshow_setting['speed']?>',
                pauseTime:'<?=$slideshow_setting['pausetime']?>',
                directionNav:true, //Next & Prev
                directionNavHide:true, //Only show on hover
                controlNav:true, //1,2,3...
                pauseOnHover:'<?=$slideshow_setting['pauseonhover']?>',
                manualAdvance:false, //Force manual transitions
                beforeChange: function(){},
                afterChange: function(){}
            });
        });
		
		/* effect options:
	
		sliceDownRight,	sliceDownLeft,	sliceUpRight, sliceUpLeft
		sliceUpDown , sliceUpDownLeft , fold , fade
		boxRandom , boxRain , boxRainReverse , boxRainGrow , boxRainGrowReverse
		slideInLeft, slideInRight
		*/
				
    </script>
	
	<style type="text/css">
	
		.nivo-caption p {padding:5px; margin:0; font-size:<?=$slideshow_setting['textsize']?>px;}
		
	</style>

	<div id="slider">
	
	<?php foreach($imagelist as $key => $imagedata){
	
		if($lang=='fr'){
		
			$showtitle = $imagedata['caption'];
					
			if($imagedata['url'] != ""){
					
				$showtitle .= "<a href='{$imagedata['url']}'>";
				$showtitle .= "Lire la suite";
				$showtitle .= "</a>";
			}
			
				
			echo "<a href=\"{$imagedata['url']}\"><img src=\"". ASSETURL . "/uploads/image_slider/images/{$widget_name}/{$imagedata['slide_img']}\" title=\"{$showtitle}\" /></a>";
			
			
		}else{

			$showtitle = $imagedata['caption'];
					
			if($imagedata['url'] != ""){
					
				$showtitle .= "<a href='{$imagedata['url']}'>";
				$showtitle .= "Read more";
				$showtitle .= "</a>";
			}
			
			echo "<a href=\"{$imagedata['url']}\"><img src=\"". ASSETURL . "/uploads/image_slider/images/{$widget_name}/{$imagedata['slide_img']}\" title=\"{$showtitle}\" /></a>";

						
			
		}
		
	}
	
	?>
			
	</div>
	
	
	

