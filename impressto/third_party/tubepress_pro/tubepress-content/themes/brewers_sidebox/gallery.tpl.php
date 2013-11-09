﻿<?php
/**
 * Copyright 2006 - 2012 Eric D. Hough (http://ehough.com)
 *
 * This file is part of TubePress (http://tubepress.org)
 *
 * TubePress is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * TubePress is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with TubePress.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * Uber simple/fast template for TubePress. Idea from here: http://seanhess.net/posts/simple_templating_system_in_php
 * Sure, maybe your templating system of choice looks prettier but I'll bet it's not faster :)
 */
?>

<?php 


	$CI = & get_instance();
	// detect language
	$lang = $CI->config->item('lang_selected');
?>


<?php 

if($lang == 'en'){ ?>
<h3>Video</h3>
  
<div class="sidebarContent">
	<?php foreach (${org_tubepress_api_const_template_Variable::VIDEO_ARRAY} as $video){ ?>

	  <div class="tubepress_thumb">
	  
	
		<a href="/en/videos/">
		  <img alt="<?php echo htmlspecialchars($video->getTitle(), ENT_QUOTES, "UTF-8"); ?>" src="<?php echo $video->getThumbnailUrl(); ?>" width="<?php echo ${org_tubepress_api_const_template_Variable::THUMBNAIL_WIDTH}; ?>" height="<?php echo ${org_tubepress_api_const_template_Variable::THUMBNAIL_HEIGHT}; ?>" /><br/>
		  <?php echo htmlspecialchars($video->getTitle(), ENT_QUOTES, "UTF-8"); ?>
		</a>
	
	  </div>
	  <?php

	  break;
	  
	} ?>
  

</div>
<?php } else{ ?>
<h3>Vid&#233;o</h3>
  
<div class="sidebarContent">
	<?php foreach (${org_tubepress_api_const_template_Variable::VIDEO_ARRAY} as $video){ ?>

	  <div class="tubepress_thumb">
		<a href="/en/videos/">
		  <img alt="<?php echo htmlspecialchars($video->getTitle(), ENT_QUOTES, "UTF-8"); ?>" src="<?php echo $video->getThumbnailUrl(); ?>" width="<?php echo ${org_tubepress_api_const_template_Variable::THUMBNAIL_WIDTH}; ?>" height="<?php echo ${org_tubepress_api_const_template_Variable::THUMBNAIL_HEIGHT}; ?>" /><br/>
		  <?php echo htmlspecialchars($video->getTitle(), ENT_QUOTES, "UTF-8"); ?>
		</a>
	  </div>
	  <?php

	  break;
	  
	} ?>
  

</div>
<?php } ?>
