<?php
/*
@Name: Standard
@Type: PHP
@Author: peterdrinnan peterdrinnan
@Projectnum: 1001
@Version: 1.0
@Status: complete
@Date: 2012-06-12
*/
?>

<?php

$CI =& get_instance(); 
$CI->load->library('asset_loader');
$CI->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/image_slider/js/jquery.nivo.slider.js");	
$CI->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/custom_modules/image_slider/css/standard_theme.css");	

		
?>

	<script type="text/javascript">
		jQuery(window).load(function() {
			jQuery('#slider').nivoSlider({
				effect: 'fade',
				slices: 15,
				boxCols: 8,
				boxRows: 4,
				animSpeed: 500,
				pauseTime: 3000,
				startSlide: 0,
				directionNav: false,
				directionNavHide: false,
				manualAdvance: false
			});
		});
		
		/* effect options:
	
		sliceDownRight,	sliceDownLeft,	sliceUpRight, sliceUpLeft
		sliceUpDown , sliceUpDownLeft , fold , fade
		boxRandom , boxRain , boxRainReverse , boxRainGrow , boxRainGrowReverse
		slideInLeft, slideInRight
		*/
				
    </script>

<div class="widget" id="image_slider_widget_<?php echo $widget_name; ?>">

<div class="slider-wrapper theme-default">
		
		<?php 
		
			$i = 0;
			
			foreach($imagelist as $key => $imagedata){ 
		
				if($i == 0){ ?>

				<div id="slider" style="position: relative; height: 353px; background: url('<?php echo ASSETURL; ?>upload/image_slider/images/<?=$imagedata['widget_name']?>/<?=$imagedata['slide_img']?>') no-repeat scroll 0% 0% transparent;" class="nivoSlider">
			
			
				<?php 
				}
					
				echo "<img alt=\"{$imagedata['title']}\"";
				echo " src=\"" . ASSETURL . "upload/image_slider/images/{$imagedata['widget_name']}/{$imagedata['slide_img']}";
				echo "\" style=\"display: none;\">\n";

				$i++;
				
				
				
			}
		?>
			
</div>



	
	</div>

</div>				
	

