<?php
/*
@Name: Simple
@Type: PHP
@Filename: simple.tpl.php
@Description: Blog ticker for Brewers
@Projectnum: 4858
@Author: peterdrinnan
@Status: development
@Date: 2012-05-16
*/
?>

<?php 	

$CI =& get_instance();
$CI->asset_loader->add_header_js("/assets/".PROJECTNAME"."/default/third_party/jquery/jquery.vticker.js"); 

?>
		

<script type="text/javascript"> 

$(function(){

	$('#news-container').vTicker({ 
		speed: 900,
		pause: 4000,
		animation: 'fade',
		mousePause: true,
		showItems: 6
	});
});

</script>




<div id="news-container">

<ul class="newsUl">

<?php


	foreach($newsitems as $newsitem){
	
		
		if($newsitem['newslink'] != "") $linkto = $newsitem['newslink'];
		else $linkto = $news_page . "?news_id={$newsitem['news_id']}";

						
		if($newsitem['opennewwindow']==1)
			$target='target="_blank"';
		else
			$target=' ';
						
		if($newsitem['newstitle'] != NULL){ ?>
		
			<li class="menucontent"><br /><a class="newstitlelink" <?=$target?> href="<?=$linkto?>" title="<?=$newsitem['newstitle']?>"><?=$newsitem['newstitle']?></a>
		
			<?php
			
			if($newsitem['newsshortdescription'] != "") $news_snippet = $newsitem['newsshortdescription'];
			else $news_snippet = $newsitem['newscontent'];
	
		
			//$news_snippet = str_pad($news_snippet,50," ... ") . "<br /><a href=\"" . $linkto . "\">read more</a>"; 
			
			?>

			<?=$news_snippet?>
			
			
			<div class="rule"></div></li>
		
		<?php }  
		
	}
					
	


?>

</ul>
</div>



<div class="clearfix"></div>
		
		
