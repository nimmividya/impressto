<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
@Name: Royal Slider Gallery
@Type: PHP
@Filename: royal_slider.tpl.php
@Description: Uses the basic royal slider layout
@Author: galbraithdesmind@gmail.com
@Docket: 101
@Version: 1.0
@Status: development
@Date: 2013-05-22
*/
?>

<?php

	$CI = &get_instance();

	$CI->load->library('asset_loader');

	// this will go into the gallery widget at a later date
	$CI->asset_loader->add_header_css("default/third_party/royalslider/royalslider.css","","all");
	$CI->asset_loader->add_header_css("default/third_party/royalslider/skins/standard/rs-default.css","","all");
	$CI->asset_loader->add_header_js("default/third_party/royalslider/jquery.royalslider.min.js");
	
?>


<div class="col span_4 fwImage">
  <div id="gallery-1" class="royalSlider rsDefault">
  
	<?php

	foreach($images AS $imgdata){ ?>
	
		<a class="rsImg" data-rsBigImg="<?=$galleryimgbase?>/<?=$imgdata['gallery']?>/<?=$imgdata['category']?>/originals/<?=$imgdata['imagename']?>" href="<?=$galleryimgbase?>/<?=$imgdata['gallery']?>/<?=$imgdata['category']?>/<?=$imgdata['imagename']?>"><?=$imgdata['caption']?>
		<img width="96" height="72" class="rsTmb" src="<?=$galleryimgbase?>/<?=$imgdata['gallery']?>/<?=$imgdata['category']?>/thumbs/<?=$imgdata['imagename']?>" />
		</a>
  
<?php }  ?>

 
  
  </div>
</div>

<script id="addJS">
	
jQuery(document).ready(function($) {

  $('#gallery-1').royalSlider({
    fullscreen: {
      enabled: true,
      nativeFS: true
    },
    controlNavigation: 'thumbnails',
    autoScaleSlider: true, 
    autoScaleSliderWidth: 960,     
    autoScaleSliderHeight: 850,
    loop: false,
    imageScaleMode: 'fit-if-smaller',
    navigateByClick: true,
    numImagesToPreload:3,
    arrowsNavAutoHide: true,
    arrowsNavHideOnTouch: true,
    keyboardNavEnabled: true,
    fadeinLoadedSlide: true,
    globalCaption: true,
    globalCaptionInside: true,
    thumbs: {
      appendSpan: true,
      firstMargin: true,
      paddingBottom: 4

    }
  });
});

</script>

