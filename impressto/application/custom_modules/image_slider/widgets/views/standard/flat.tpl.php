<?php
/*
@Name: Flat
@Type: PHP
@File: flat.tpl.php
@Author: peterdrinnan
@Projectnum: 1001
@Version: 1.0
@Status: complete
@Date: 2012-06-12
*/
?>

		<div class="sliderWrap clearfix">
			<div id="slider">
			<?php
			
			$i = 0;
			
			foreach($imagelist as $key => $data){ 
		
				if($i == 0){ 
				
				$link = "";
				
				if($data['url'] != "") $link = "<a href='{$data['url']}' class='learnmore' title='Learn More'>Learn more<i></i></a>";
								
				?>
				
				<img src="<?php echo ASSETURL; ?>upload/image_slider/images/<?=$data['widget_name']?>/<?=$data['slide_img']?>" alt="" title="<h1><?=$data['title']?></h1><p><?=$data['caption']?></p><?=$link?>" width="617" />  
								
						
			<?php }
			
			
			}
			
			?>
			
			</div><!-- [END] #slider -->
		</div><!-- [END] .sliderWrap -->