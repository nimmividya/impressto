<!-- 
@Name: Basic
@Type: impressto
@Filename: content.tpl.html
@Description: Layout and partials for Image Gallery
@Author: galbraithdesmind@gmail.com
@Docket: 4484
@Version: 1.0
@Status: development
@Date: 2012-05-29
-->


<!-- BEGIN IMAGEGALLERYWRAPPER -->

<div id="image_gallery_body_div">


	{$gallerybody}

	
</div>
	
	
<!-- END IMAGEGALLERYWRAPPER -->

	

<!-- BEGIN IMAGEGALLERYMAINBODY -->

   <div class="gallery_landing clearfix">
      <ul>
	  
	  <?php

	  foreach($category_image_list AS $key => $catvals){ 
	  
	  	$id = str_replace("id_","",$key);
				
	  ?>
	    
        <li>
          <a href="javascript:ps_image_gallery.loadcategory_by_id('<?=$id?>');"> <span>&nbsp;</span> <img alt="<?=$catvals['name_en']?>" height="152" src="/assets/uploads/<?php echo PROJECTNAME; ?>/image_gallery/<?=$id?>/thumbs/<?=$catvals['imagename']?>" width="152" /> <?=$catvals['name_en']?> </a>
		</li>
 
	<?php   }   ?>
 
  
      </ul>
    </div><!-- [END] .gallery_landing -->
	
<!-- END IMAGEGALLERYMAINBODY -->


<!-- BEGIN IMAGEGALLERYCATPAGE -->
<?php	  
		$slidecount = 0;
		
		$javascriptstring = "";
		$imagelist = "";
		
		
		foreach($category_images as $key => $val){
		
			$id = str_replace("id_","",$key);
	
			$display = "visible";
			if($slidecount > 0) $display = "none";
			
			$imgpath = "/assets/uploads/" . PROJECTNAME  . "/image_gallery/{$ig_category}/";
								
			$javascriptstring  .= "images[{$slidecount}] = '{$imgpath}{$val['imagename']}';\n";
			
			$imgsrc = "";
			
			if($slidecount == "") $imgsrc = "{$imgpath}{$val['imagename']}";

			
			$imagelist .= "<img style=\"display:{$display}\" id=\"imgslide_{$slidecount}\" src=\"{$imgsrc}\" alt=\"{$val['caption']}\">\n";
			
			$slidecount++;
		
		} 

		?>
        

<!-- HERE -->	


	<div class="gallery_inner_container clearfix">
		<div class="ig_controls">
			<div class="ig_controls_info">
				<span>{$category_name} <small id="ig_slide_number">(1/<?php echo $slidecount; ?>)</small><span>
			</div><!-- [END] .ig_controls_info -->
			<div class="ig_controls_btn">
				<div style="position: absolute; left: -215px; top: -2px;">{$gallery_category_seletor}</div>
				<a href="photo-gallery" class="ig_home">Home</a>
				<a href="javascript:ps_image_gallery.playslideshow()" class="ig_start">Start</a>
				<a href="javascript:ps_image_gallery.pauseslideshow()" class="ig_stop">Stop</a>
			</div><!-- [END] .ig_controls_btn -->
		</div><!-- [END] .ig_controls -->
		<div id="ig_image_resizer" class="ig_image_container" style="background: url('/assets/<?php echo PROJECTNAME; ?>/image_gallery/images/spinner.gif'); background-repeat:no-repeat; background-position:center; ">
			<div class="ig_image_container_prev">
				<a href="javascript:ps_image_gallery.manual_go_prev_slide()" title="Previous Image">Previous Image</a>
			</div><!-- [END] .ig_image_container_prev -->
			<?php echo $imagelist; ?>
			<div class="ig_image_container_next">
				<a href="javascript:ps_image_gallery.manual_go_next_slide()" title="Next Image">Next Image</a>
			</div><!-- [END] .ig_image_container_next -->
		</div><!-- [END] .ig_image_container -->
	</div><!-- [END] .gallery_inner_container -->
	
	
	
<!-- TO HERE -->

	<script type="text/javascript">
	
			ps_image_gallery.current_category = '<?php echo $ig_category; ?>';
			ps_image_gallery.slidecount = '<?php echo $slidecount; ?>';
			ps_image_gallery.current_slide = '0';
			
			var images = new Array();

			<?php echo $javascriptstring; ?>
			
	</script>
    

<!-- END IMAGEGALLERYCATPAGE -->










