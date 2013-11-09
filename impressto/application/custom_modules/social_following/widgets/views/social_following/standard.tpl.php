<?php
/*
@Name: Social Following Buttons
@Type: PHP
@Filename: standard.tpl.php
@Description: Add popular social bookmarks to your page
@Projectnum: 1001
@Author: peterdrinnan
@Status: development
@Date: 2012-06-05
*/
?>





<!-- AddThis Button BEGIN -->
<?php 



switch($settings['button_layout']){ 


	case "large-horizontal" : ?>
	
	

<div class="addthis_toolbox addthis_32x32_style addthis_default_style">
<?php if($uids['facebook']){ ?><a class="addthis_button_facebook_follow" addthis:userid="<?=$uids['facebook']?>"></a><?php } ?>
<?php if($uids['twitter']){ ?><a class="addthis_button_twitter_follow" addthis:userid="<?=$uids['twitter']?>"></a><?php } ?>
<?php if($uids['linkedin']){ ?><a class="addthis_button_linkedin_follow" addthis:userid="<?=$uids['linkedin']?>"></a><?php } ?>
<?php if($uids['google']){ ?><a class="addthis_button_google_follow" addthis:userid="<?=$uids['google']?>"></a><?php } ?>
<?php if($uids['youtube']){ ?><a class="addthis_button_youtube_follow" addthis:userid="<?=$uids['youtube']?>"></a><?php } ?>
<?php if($uids['flickr']){ ?><a class="addthis_button_flickr_follow" addthis:userid="<?=$uids['flickr']?>"></a><?php } ?>
<?php if($uids['vimeo']){ ?><a class="addthis_button_vimeo_follow" addthis:userid="<?=$uids['vimeo']?>"></a><?php } ?>
<?php if($uids['pinterest']){ ?><a class="addthis_button_pinterest_follow" addthis:userid="<?=$uids['pinterest']?>"></a><?php } ?>
<?php if($uids['instagram']){ ?><a class="addthis_button_instagram_follow" addthis:userid="<?=$uids['instagram']?>"></a><?php } ?>
<?php if($uids['rss']){ ?><a class="addthis_button_rss_follow" addthis:url="http://<?=$uids['rss']?>"></a><?php } ?>
</div>


<!-- AddThis Follow END -->


	
<?php


	break;

	case "small-horizontal" : ?>
	


<div class="addthis_toolbox addthis_default_style">
<?php if($uids['facebook']){ ?><a class="addthis_button_facebook_follow" addthis:userid="<?=$uids['facebook']?>"></a><?php } ?>
<?php if($uids['twitter']){ ?><a class="addthis_button_twitter_follow" addthis:userid="<?=$uids['twitter']?>"></a><?php } ?>
<?php if($uids['linkedin']){ ?><a class="addthis_button_linkedin_follow" addthis:userid="<?=$uids['linkedin']?>"></a><?php } ?>
<?php if($uids['google']){ ?><a class="addthis_button_google_follow" addthis:userid="<?=$uids['google']?>"></a><?php } ?>
<?php if($uids['youtube']){ ?><a class="addthis_button_youtube_follow" addthis:userid="<?=$uids['youtube']?>"></a><?php } ?>
<?php if($uids['flickr']){ ?><a class="addthis_button_flickr_follow" addthis:userid="<?=$uids['flickr']?>"></a><?php } ?>
<?php if($uids['vimeo']){ ?><a class="addthis_button_vimeo_follow" addthis:userid="<?=$uids['vimeo']?>"></a><?php } ?>
<?php if($uids['pinterest']){ ?><a class="addthis_button_pinterest_follow" addthis:userid="<?=$uids['pinterest']?>"></a><?php } ?>
<?php if($uids['instagram']){ ?><a class="addthis_button_instagram_follow" addthis:userid="<?=$uids['instagram']?>"></a><?php } ?>
<?php if($uids['rss']){ ?><a class="addthis_button_rss_follow" addthis:url="http://<?=$uids['rss']?>"></a><?php } ?>
</div>





	
	
<?php

	break;
	
	
	case "large-vertical" : ?>
	


<div class="addthis_toolbox addthis_32x32_style addthis_vertical_style">
<?php if($uids['facebook']){ ?><a class="addthis_button_facebook_follow" addthis:userid="<?=$uids['facebook']?>"></a><?php } ?>
<?php if($uids['twitter']){ ?><a class="addthis_button_twitter_follow" addthis:userid="<?=$uids['twitter']?>"></a><?php } ?>
<?php if($uids['linkedin']){ ?><a class="addthis_button_linkedin_follow" addthis:userid="<?=$uids['linkedin']?>"></a><?php } ?>
<?php if($uids['google']){ ?><a class="addthis_button_google_follow" addthis:userid="<?=$uids['google']?>"></a><?php } ?>
<?php if($uids['youtube']){ ?><a class="addthis_button_youtube_follow" addthis:userid="<?=$uids['youtube']?>"></a><?php } ?>
<?php if($uids['flickr']){ ?><a class="addthis_button_flickr_follow" addthis:userid="<?=$uids['flickr']?>"></a><?php } ?>
<?php if($uids['vimeo']){ ?><a class="addthis_button_vimeo_follow" addthis:userid="<?=$uids['vimeo']?>"></a><?php } ?>
<?php if($uids['pinterest']){ ?><a class="addthis_button_pinterest_follow" addthis:userid="<?=$uids['pinterest']?>"></a><?php } ?>
<?php if($uids['instagram']){ ?><a class="addthis_button_instagram_follow" addthis:userid="<?=$uids['instagram']?>"></a><?php } ?>
<?php if($uids['rss']){ ?><a class="addthis_button_rss_follow" addthis:url="http://<?=$uids['rss']?>"></a><?php } ?>
</div>

	
	
<?php

	break;
	
	
	case "small-vertical" : ?>
	

<div class="addthis_toolbox addthis_vertical_style">
<?php if($uids['facebook']){ ?><a class="addthis_button_facebook_follow" addthis:userid="<?=$uids['facebook']?>"></a><?php } ?>
<?php if($uids['twitter']){ ?><a class="addthis_button_twitter_follow" addthis:userid="<?=$uids['twitter']?>"></a><?php } ?>
<?php if($uids['linkedin']){ ?><a class="addthis_button_linkedin_follow" addthis:userid="<?=$uids['linkedin']?>"></a><?php } ?>
<?php if($uids['google']){ ?><a class="addthis_button_google_follow" addthis:userid="<?=$uids['google']?>"></a><?php } ?>
<?php if($uids['youtube']){ ?><a class="addthis_button_youtube_follow" addthis:userid="<?=$uids['youtube']?>"></a><?php } ?>
<?php if($uids['flickr']){ ?><a class="addthis_button_flickr_follow" addthis:userid="<?=$uids['flickr']?>"></a><?php } ?>
<?php if($uids['vimeo']){ ?><a class="addthis_button_vimeo_follow" addthis:userid="<?=$uids['vimeo']?>"></a><?php } ?>
<?php if($uids['pinterest']){ ?><a class="addthis_button_pinterest_follow" addthis:userid="<?=$uids['pinterest']?>"></a><?php } ?>
<?php if($uids['instagram']){ ?><a class="addthis_button_instagram_follow" addthis:userid="<?=$uids['instagram']?>"></a><?php } ?>
<?php if($uids['rss']){ ?><a class="addthis_button_rss_follow" addthis:url="http://<?=$uids['rss']?>"></a><?php } ?>
</div>

	
	
<?php

	break;
	

	
	case "vertical-sharing" : ?>
	



<div class="addthis_toolbox addthis_floating_style addthis_counter_style" style="left:50px;top:50px;">
<a class="addthis_button_facebook_like" fb:like:layout="box_count"></a>
<a class="addthis_button_tweet" tw:count="vertical"></a>
<a class="addthis_button_google_plusone" g:plusone:size="tall"></a>
<a class="addthis_counter"></a>
</div>

	
	
<?php

	break;
	
	
	
	case "horizontal-sharing" : ?>
	




<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>


	
	
<?php

	break;
	
	
	


}

?>

<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=<?=$settings['pubid']?>"></script>
<!-- AddThis Button END -->
