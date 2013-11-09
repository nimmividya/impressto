<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Cloud Carousel helper
 * 
 * A helper for the Cloud Carousel by Professor Cloud http://www.professorcloud.com/mainsite/carousel.htm/
 *
 * see http://www.professorcloud.com/mainsite/carousel-integration.htm for detailed integration instructions.
 */

/*
 *
 */
if ( ! function_exists('cloud_carousel'))
{
	function cloud_carousel($items=array(), $config=array(), $css_id)
	{
		$CI =& get_instance();
		
        $CI->load->config('cloud_carousel',true,false,'cloud_carousel'); // true to avoid naming collisions, false to not suppress errors

		// get defaults from config
		$image_path = $CI->config->item('image_path','cloud_carousel');
		$css_path = $CI->config->item('css_path','cloud_carousel');
		$js_path = $CI->config->item('js_path','cloud_carousel');

		$html = <<<CAROUSEL
<div id='carousel-script-includes'>

	<!-- You can load the jQuery library from the Google Content Network, probably better than from your own server. -->
	<!-- Carousel styles -->
	<link rel="stylesheet" type="text/css" href="$css_path/cloud-carousel.css">

CAROUSEL;

	if (isset($config['mouseWheel']) && $config['mouseWheel'])
	{
		$html .= <<<CAROUSEL
	<!-- Load the JQuery Mousewheel Plugin -->
	<script type="text/JavaScript" src="$js_path/jquery.mousewheel.min.js"></script>

CAROUSEL;
	}

		$html .= <<<CAROUSEL
	<!-- Load the CloudCarousel JavaScript file -->
	<script type="text/JavaScript" src="$js_path/cloud-carousel.1.0.5.min.js"></script>

	<script>
	$(document).ready(function(){
							   
		// This initialises carousels on the container elements specified, in this case, $css_id.
		$("#$css_id").CloudCarousel(		
			{
CAROUSEL;

		foreach ($config as $setting => $val) 
		{
			$html .= "\n";
			if (is_string($val) && (substr($val,0,3)!='$("'))
			{
				echo($val . " is a string        --- --- ");
				$html .= "\t\t\t\t" . $setting . ' : "' . $val . '",';
			}
			else if (is_bool($val))
			{
				
				$html .= "\t\t\t\t" . $setting . ' : ' .(($val) ? 'true' : 'false').  ',';	
			} 
			else
			{
				$html .= "\t\t\t\t" . $setting . ' : ' . $val . ',';
			}
				
		}
		if (count($config)>0)
		{
			$html = substr($html, 0, -1)."\n";
			
		}

		$html .= <<<CAROUSEL
			}
		);
	});
	 
	</script>

	<!-- This is the container for the carousel. -->
        <div id = "$css_id">            
            <!-- All images with class of "cloudcarousel" will be turned into carousel items -->
            <!-- You can place links around these images -->
CAROUSEL;

		foreach ($items as $item) {
			$html .= "\n";
			if (isset($item['href']) && strlen($item['href'])>0)
			{
				$html .= "<a href='$item[href]'";
				if (isset($item['href_target']) && strlen($item['href_target'])>0) $html .= " target='$item[href_target]'";
				$html .= '>';
			}
			$html .= "<img class='cloudcarousel' src='$image_path/$item[img]' alt='$item[img_alt]' title='$item[img_title]' />";
			if (isset($item['href']) && strlen($item['href'])>0)
			{
				$html .= "</a>";
			}
		}

		$html .= <<<CAROUSEL

        </div>
        
        <!-- Define left and right buttons. -->
        <div id="carousel-left-but"></div>
        <div id="carousel-right-but"></div>
        
        <!-- Define elements to accept the alt and title text from the images. -->
        <p id="carousel-title-text"></p>
        <p id="carousel-alt-text"></p>

</div>
CAROUSEL;


	return $html;
	}
}

?>
