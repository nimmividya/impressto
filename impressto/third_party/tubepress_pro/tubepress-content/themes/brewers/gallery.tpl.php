<?php
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
<div class="tubepress_container" id="tubepress_gallery_<?php echo ${org_tubepress_api_const_template_Variable::GALLERY_ID}; ?>">

  <?php echo ${org_tubepress_api_const_template_Variable::PLAYER_HTML}; ?>

  <div id="tubepress_gallery_<?php echo ${org_tubepress_api_const_template_Variable::GALLERY_ID}; ?>_thumbnail_area" class="tubepress_thumbnail_area">
  
<!-- arrows-->
<div class="vid_control_l">
<a href="#" class="prev"><img src="/assets/public/4858/images/icons/arrow_left.jpg" border="0" /></a></div>

<div class="vid_control_r"><a href="#" class="next"><img src="/assets/public/4858/images/icons/arrow_right.jpg" border="0" /> </a></div>

    <?php if (isset(${org_tubepress_api_const_template_Variable::PAGINATION_TOP})) : echo ${org_tubepress_api_const_template_Variable::PAGINATION_TOP}; endif; ?>
<div class="tubepress_thumbs">
<ul style="margin: 0px; padding: 0px; position: relative; list-style-type: none; z-index: 1; width: 2890px; left: -850px;">
        <?php foreach (${org_tubepress_api_const_template_Variable::VIDEO_ARRAY} as $video): ?>
<li style="overflow: hidden; float: left; width: 174px; height: 105px;">
      <div class="tubepress_thumb">
        <a id="tubepress_image_<?php echo $video->getId(); ?>_<?php echo ${org_tubepress_api_const_template_Variable::GALLERY_ID}; ?>" rel="tubepress_<?php echo ${org_tubepress_api_const_template_Variable::EMBEDDED_IMPL_NAME}; ?>_<?php echo ${org_tubepress_api_const_template_Variable::PLAYER_NAME}; ?>_<?php echo ${org_tubepress_api_const_template_Variable::GALLERY_ID}; ?>">
          <img alt="<?php echo htmlspecialchars($video->getTitle(), ENT_QUOTES, "UTF-8"); ?>" src="<?php echo $video->getThumbnailUrl(); ?>" width="<?php echo ${org_tubepress_api_const_template_Variable::THUMBNAIL_WIDTH}; ?>" height="<?php echo ${org_tubepress_api_const_template_Variable::THUMBNAIL_HEIGHT}; ?>" />
        </a>
        
      </div>
</li>
      <?php endforeach; ?>
</ul>
    </div>
    <?php if (isset(${org_tubepress_api_const_template_Variable::PAGINATION_BOTTOM})) : echo ${org_tubepress_api_const_template_Variable::PAGINATION_BOTTOM}; endif; ?>
  </div>
</div>
<script type="text/javascript">
    $(".tubepress_thumbs").jCarouselLite({

        btnNext: ".next",
        btnPrev: ".prev",
		visible: 4

    });   
</script> 
