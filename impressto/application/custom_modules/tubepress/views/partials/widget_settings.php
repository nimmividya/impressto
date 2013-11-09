
	<div id="tubepress_widget_tabs" style="clear: both">
	<ul>
		<li>
			<a href="#tubepress_whichvideo">
				Videos
			</a>
		</li>
		<li>
			<a href="#tubepress_thumbnails">
				Thumbnails
			</a>
		</li>
		<li>
			<a href="#tubepress_player">
				Player
			</a>
		</li>
		<li>
			<a href="#tubepress_meta_tab">
				Meta
			</a>
		</li>
		<li>
			<a href="#tubepress_feeb_tab">
				Feed
			</a>
		</li>
		
		<li>
			<a href="#tubepress_advanced_tab">
				Advanced
			</a>
		</li>
	</ul>
	
	<div id="tubepress_whichvideo">
		<table cellpadding="0" cellspacing="0" border="0">
			<tbody>
				<tr style="height:42px;">
					<td style="width: 210px;">
						This YouTube User's "Favorites"
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'mode',
								'id'          => 'favorites',
								'value'       => 'favorites',
								'checked'     => (isset($tubepress['mode']) && $tubepress['mode'] == "favorites") ? true : false,
							);
							echo form_radio($options);
						?>
					</td>
					<td>
						<?php
							$options = array(
								'name'        => 'favoritesValue',
								'id'          => 'favoritesValue',
								'value'       => isset($tubepress['favoritesvalue']) ? $tubepress['favoritesvalue'] : "",
								'size'        => '20',
							);
							echo form_input($options);
						?>
					</td>

				</tr>

				<tr style="height:42px;">
					<td style="width: 210px;">
						Videos from this YouTube user
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'mode',
								'id'          => 'user',
								'value'       => 'user',
								'checked'     => (isset($tubepress['mode']) && $tubepress['mode'] == "user") ? true : false,
							);
							echo form_radio($options);
						?>
					</td>
					<td>
						<?php
							$options = array(
								'name'        => 'userValue',
								'id'          => 'userValue',
								'value'       => (isset($tubepress['uservalue']) ? $tubepress['uservalue'] : ""),
								'size'        => '20',
							);
							echo form_input($options);						
						?>
					</td>

				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Limited to 200 videos per playlist. Will usually look something like this: D2B04665B213AE35. Copy the playlist id from the end of the URL in your browser's address bar (while looking at a YouTube playlist). It comes right after the 'p='. For instance: http://youtube.com/my_playlists?p=D2B04665B213AE35.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						This YouTube playlist
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'mode',
								'id'          => 'playlist',
								'value'       => 'playlist',
								'checked'     => (isset($tubepress['mode']) && $tubepress['mode'] == "playlist") ? true : false,
							);
							echo form_radio($options);
						?>
					</td>
					<td>
						<?php
							$options = array(
								'name'        => 'playlistValue',
								'id'          => 'playlistValue',
								'value'       => (isset($tubepress['playlistvalue']) ? $tubepress['playlistvalue'] : ""),
								'size'        => '20',
							);
							echo form_input($options);						
						?>
					</td>

				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="YouTube limits this to 1,000 results.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						YouTube search for
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'mode',
								'id'          => 'tag',
								'value'       => 'tag',
								'checked'     => (isset($tubepress['mode']) && $tubepress['mode'] == "tag") ? true : false,
							);
							echo form_radio($options);
						?>
					</td>
					<td>
						<?php
							$options = array(
								'name'        => 'tagValue',
								'id'          => 'tagValue',
								'value'       => (isset($tubepress['tagvalue']) ? $tubepress['tagvalue'] : ""),
								'size'        => '20',
							);
							echo form_input($options);						
						?>
					</td>

				</tr>


				
			</tbody>
		</table>
	</div>
	
	
	<div id="tubepress_thumbnails">
		<table cellpadding="0" cellspacing="0" border="0">
			<tbody>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Default is 90.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Height (px) of thumbs
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'thumbHeight',
								'id'          => 'thumbHeight',
								'value'       => (isset($tubepress['thumbheight']) ? $tubepress['thumbheight'] : ""),
								'size'        => '20',
							);
							echo form_input($options);						
						?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Default is 120.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Width (px) of thumbs
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'thumbWidth',
								'id'          => 'thumbWidth',
								'value'       => (isset($tubepress['thumbwidth']) ? $tubepress['thumbwidth'] : ""),
								'size'        => '20',
							);
							echo form_input($options);						
						?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Asynchronous JavaScript">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Ajax-enabled pagination
					</td>
					<td style="padding: 0 10px;">
						<?php 
							$options = array(
								'name'        => 'ajaxPagination',
								'id'          => 'ajaxPagination',
								'value'       => "true",
								'checked'     => (isset($tubepress['ajaxpagination']) && $tubepress['ajaxpagination'] == "true") ?  TRUE : FALSE,
							);
							echo form_checkbox($options);
						?>
					</td>
	
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Dynamically set thumbnail spacing based on the width of their container.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Use "fluid" thumbnails
					</td>
					<td style="padding: 0 10px;">
						<?php 
							$options = array(
								'name'        => 'fluidThumbs',
								'id'          => 'fluidThumbs',
								'value'       => "true",
								'checked'     => (isset($tubepress['fluidthumbs']) && $tubepress['fluidthumbs'] == "true") ?  TRUE : FALSE,
							);
							echo form_checkbox($options);
						?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Only applies to galleries that span multiple pages.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Show pagination above thumbnails
					</td>
					<td style="padding: 0 10px;">
						<?php 
							$options = array(
								'name'        => 'paginationAbove',
								'id'          => 'paginationAbove',
								'value'       => "true",
								'checked'     => (isset($tubepress['paginationabove']) && $tubepress['paginationabove'] == "true") ?  TRUE : FALSE,
							);
							echo form_checkbox($options);
						?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Only applies to galleries that span multiple pages.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Show pagination below thumbnails
					</td>
					<td style="padding: 0 10px;">
						<?php 
							$options = array(
								'name'        => 'paginationBelow',
								'id'          => 'paginationBelow',
								'value'       => "true",
								'checked'     => (isset($tubepress['paginationbelow']) &&  $tubepress['paginationbelow'] == "true") ?  TRUE : FALSE,
							);
							echo form_checkbox($options);
						?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="this option cannot be used with the 'randomize thumbnails' feature.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Use high-quality thumbnails
					</td>
					<td style="padding: 0 10px;">
						<?php 
							$options = array(
								'name'        => 'hqThumbs',
								'id'          => 'hqThumbs',
								'value'       => "true",
								'checked'     => (isset($tubepress['hqthumbs']) && $tubepress['hqthumbs'] == "true") ?  TRUE : FALSE,
							);
							echo form_checkbox($options);
						?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Most videos come with several thumbnails. By selecting this option, each time someone views your gallery they will see the same videos with each video's thumbnail randomized. Note: this option cannot be used with the 'high quality thumbnails' feature.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Randomize thumbnail images
					</td>
					<td style="padding: 0 10px;">
						<?php 
							$options = array(
								'name'        => 'randomize_thumbnails',
								'id'          => 'randomize_thumbnails',
								'value'       => "true",
								'checked'     => (isset($tubepress['randomize_thumbnails']) && $tubepress['randomize_thumbnails'] == "true") ?  TRUE : FALSE,
							);
							echo form_checkbox($options);
						?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Default is 20. Maximum is 50.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Thumbnails per page
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'resultsPerPage',
								'id'          => 'resultsPerPage',
								'value'       => (isset($tubepress['resultsperpage']) ? $tubepress['resultsperpage'] : ""),
								'size'        => '20',
							);
							echo form_input($options);						
						?>
					</td>
				</tr>
				
			</tbody>
		</table>		
	</div>
	
	<div id="tubepress_player">
		<table cellpadding="0" cellspacing="0" border="0">
			<tbody>
				<tr style="height:42px;">
					<td style="width: 210px;">
						Play each video
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
									  'normal'    => 'normally (at the top of your gallery)',
									  'popup'    => 'in a popup window',
									  'youtube'    => 'from the video\'s original YouTube page',
									  'vimeo'    => 'from the video\'s original Vimeo page',
									  'shadowbox'    => 'with Shadowbox',
									  'jqmodal'    => 'with jqModal',
									  'tinybox'    => 'with TinyBox',
									  'fancybox'    => 'with FancyBox',
									  'static'    => 'statically (page refreshes on each thumbnail click)',
									  'solo'    => 'in a new window on its own',
									  'detached'    => 'in a "detached" location (see the documentation)',
							);
							echo form_dropdown('playerLocation', $options, (isset($tubepress['playerlocation']) ? $tubepress['playerlocation'] : ""));
						?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="The brand of the embedded player. Default is the provider's player (YouTube, Vimeo, etc).">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Implementation
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
									  'embedplus'    => 'EmbedPlus',
									  'longtail'    => 'JW FLV Media Player (by Longtail Video)',
									  'provider_based'    => 'Provider default',
							);
							echo form_dropdown('playerImplementation', $options, (isset($tubepress['playerimplementation']) ? $tubepress['playerimplementation'] : ""));
						?>
					</td>

				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Default is 350.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Max height (px)
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'embeddedHeight',
								'id'          => 'embeddedHeight',
								'value'       => (isset($tubepress['embeddedheight']) ? $tubepress['embeddedheight'] : ""),
								'size'        => '20',
							);
							echo form_input($options);						
						?>
					</td>
			
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Default is 425.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Max width (px)
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'embeddedWidth',
								'id'          => 'embeddedWidth',
								'value'       => (isset($tubepress['embeddedwidth']) ? $tubepress['embeddedwidth'] : ""),
								'size'        => '20',
							);
							echo form_input($options);						
						?>
					</td>

				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Auto-play each video after thumbnail click.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						"Lazy" play videos
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'lazyPlay',
								'id'          => 'lazyPlay',
								'value'       => "true",
								'checked'     => (isset($tubepress['lazyplay']) && $tubepress['lazyplay'] == "true") ? TRUE : FALSE,
							);
							echo form_checkbox($options);
						?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Default is #999999.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Main color
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'playerColor',
								'id'          => 'playerColor',
								'value'       => (isset($tubepress['playercolor']) ? $tubepress['playercolor'] : ""),
								'size'        => '6',
							);
							echo form_input($options);						
						?>
					</td>
		
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Default is #FFFFFF.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Highlight color
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'playerHighlight',
								'id'          => 'playerHighlight',
								'value'       => (isset($tubepress['playerhighlight']) ? $tubepress['playerhighlight'] : ""),
								'size'        => '6',
							);
							echo form_input($options);						
						?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						Show title and rating before video starts
					</td>
					<td style="padding: 0 10px;">
						<?php echo form_checkbox('showInfo', "true", (isset($tubepress['showinfo']) && $tubepress['showinfo'] == "true") ? TRUE : FALSE ); ?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						Allow fullscreen playback.
					</td>
					<td style="padding: 0 10px;">
						<?php echo form_checkbox('fullscreen', "true", (isset($tubepress['fullscreen']) && $tubepress['fullscreen'] == "true") ? TRUE : FALSE ); ?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						Play videos in high definition by default
					</td>
					<td style="padding: 0 10px;">
						<?php echo form_checkbox('hd', "true", (isset($tubepress['hd']) && $tubepress['hd'] == "true") ? TRUE : FALSE ); ?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="When a video finishes, this will start playing the next video in the gallery.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Play videos sequentially without user intervention
					</td>
					<td style="padding: 0 10px;">
						<?php echo form_checkbox('autoNext', "true", (isset($tubepress['autonext']) && $tubepress['autonext'] == "true") ? TRUE : FALSE ); ?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						Auto-play all videos
					</td>
					<td style="padding: 0 10px;">
						<?php echo form_checkbox('autoplay', "true", (isset($tubepress['autoplay']) && $tubepress['autoplay'] == "true") ? TRUE : FALSE ); ?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Continue playing the video until the user stops it.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Loop
					</td>
					<td style="padding: 0 10px;">
						<?php echo form_checkbox('loop', "true", (isset($tubepress['loop']) && $tubepress['loop'] == "true" ) ? TRUE : FALSE ); ?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Toggles the display of related videos after a video finishes.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Show related videos
					</td>
					<td style="padding: 0 10px;">
						<?php echo form_checkbox('showRelated', "true", (isset($tubepress['showrelated']) && $tubepress['showrelated'] == "true" ) ? TRUE : FALSE ); ?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="A few seconds after playback begins, fade out the video controls.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Auto-hide video controls
					</td>
					<td style="padding: 0 10px;">
						<?php echo form_checkbox('autoHide', "true", (isset($tubepress['autohide']) && $tubepress['autohide'] == "true") ? TRUE : FALSE ); ?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Hide the YouTube logo from the control area.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						"Modest" branding
					</td>
					<td style="padding: 0 10px;">
						<?php echo form_checkbox('modestBranding', "true", (isset($tubepress['modestbranding']) && $tubepress['modestbranding'] == "true") ? TRUE : FALSE ); ?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Allow TubePress to communicate with the embedded video player via JavaScript. This incurs a very small performance overhead, but is required for some features.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Enable JavaScript API
					</td>
					<td style="padding: 0 10px;">
						<?php echo form_checkbox('enableJsApi', "true", (isset($tubepress['enablejsapi']) && $tubepress['enablejsapi'] == "true") ? TRUE : FALSE ); ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div id="tubepress_meta_tab">
		<table cellpadding="0" cellspacing="0" border="0">
			<tbody>
				<tr style="height:42px;">
					<td style="width: 210px;">
						Show each video's...
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
													  
									  'author'    => 'Author',
									  'rating'    => 'Average rating',
									  'category'    => 'Category',
									  'uploaded'    => 'Date posted',
									  'description'    => 'Description',
									  'id'    => 'ID',
									  'tags'    => 'Keywords',
									  'likes'    => 'Number of "likes',
									  'ratings'    => 'Number of ratings',
									  'length'    => 'Runtime',
									  'title'    => 'Title',
									  'url'    => 'URL',
									  'views'    => 'View count',
							);
									
							$selected_options = array();
							
							$addonvars = 'id="multiselect-metadropdown" ';
									
							echo form_dropdown('metadropdown', $options, $selected_options, $addonvars);
						?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Set the textual formatting of date information for videos. See <a href='http://us.php.net/date'>date</a> for examples.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Date format
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'dateFormat',
								'id'          => 'dateFormat',
								'value'       => (isset($tubepress['dateformat']) ? $tubepress['dateformat'] : ""),
								'size'        => '20',
							);
							echo form_input($options);						
						?>
					</td>
					<!-- <input type="text" name="dateFormat" size="20" value="<?//=$tubepress['dateformat']?>" /> -->
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="e.g. 'yesterday' instead of 'November 3, 1980'.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Use relative dates
					</td>
					<td style="padding: 0 10px;">
						<?php echo form_checkbox('relativeDates', "true", (isset($tubepress['relativedates']) && $tubepress['relativedates'] == "true") ? TRUE : FALSE); ?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Maximum number of characters to display in video descriptions. Set to 0 for no limit.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Maximum description length
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'descriptionLimit',
								'id'          => 'descriptionLimit',
								'value'       => (isset($tubepress['descriptionlimit']) ? $tubepress['descriptionlimit'] : ""),
								'size'        => '20',
							);
							echo form_input($options);						
						?>
					</td>
			
				</tr>
			</tbody>
		</table>
	</div>
	<div id="tubepress_feeb_tab">
		<table cellpadding="0" cellspacing="0" border="0">
			<tbody>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Not all sort orders can be applied to all gallery types.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Order videos by
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'commentCount'    => 'Comment Count',
								'newest'    => 'Date published (newest first)',
								'oldest'    => 'Date published (oldest first)',
								'duration'    => 'length',
								'position'    => 'position in a playlist',
								'random'    => 'randomly',
								'rating'    => 'rating',
								'relevance'    => 'relevance',
								'title'    => 'title',
								'viewCount'    => 'view count'
							);
							
							echo form_dropdown('orderBy', $options, (isset($tubepress['orderby']) ? $tubepress['orderby'] : ""));
						?>
					</td>

					
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Additional sort order applied to each individual page of a gallery">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Per-page sort order
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'commentCount'    => 'Comment Count',
								'newest'    => 'Date published (newest first)',
								'oldest'    => 'Date published (oldest first)',
								'duration'    => 'length',
								'none'    => 'none',
								'random'    => 'randomly',
								'rating'    => 'rating',
								'relevance'    => 'relevance',
								'title'    => 'title',
								'viewCount'    => 'view count'
							);
							
							echo form_dropdown('perPageSort', $options, (isset($tubepress['perpagesort']) ? $tubepress['perpagesort'] : ""));
						?>
					</td>

				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="This can help to reduce the number of pages in your gallery. Set to "0" to remove any limit.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Maximum total videos to retrieve
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'resultCountCap',
								'id'          => 'resultCountCap',
								'value'       => (isset($tubepress['resultcountcap']) ? $tubepress['resultcountcap'] : ""),
								'size'        => '20',
							);
							echo form_input($options);						
						?>
					</td>
					<!-- <input type="text" name="resultCountCap" size="20" value="<?//=$tubepress['resultcountcap']?>" /> -->
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="YouTube will use this developer key for logging and debugging purposes if you experience a service problem on their end. You can register a new client ID and developer key. Don't change this unless you know what you're doing.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						YouTube API Developer Key
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'developerKey',
								'id'          => 'developerKey',
								'value'       => (isset($tubepress['developerkey']) ? $tubepress['developerkey'] : ""),
								'size'        => '20',
							);
							echo form_input($options);						
						?>
					</td>
					<!-- <input type="text" name="developerKey" size="20" value="<?//=$tubepress['developerkey']?>" /> -->
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="A list of video IDs that should never be displayed.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Video blacklist
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'videoBlacklist',
								'id'          => 'videoBlacklist',
								'value'       => (isset($tubepress['videoblacklist']) ? $tubepress['videoblacklist'] : ""),
								'size'        => '20',
							);
							echo form_input($options);						
						?>
					</td>
					<!-- <input type="text" name="videoBlacklist" size="20" value="<?//=$tubepress['videoblacklist']?>" /> -->
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="A YouTube or Vimeo user name. Only applies to search-based galleries.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Restrict search results to videos from author
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'searchResultsRestrictedToUser',
								'id'          => 'searchResultsRestrictedToUser',
								'value'       => (isset($tubepress['searchresultsrestrictedtouser']) ? $tubepress['searchresultsrestrictedtouser'] : ""),
								'size'        => '20',
							);
							echo form_input($options);						
						?>
					</td>
					<!-- <input type="text" name="searchResultsRestrictedToUser" size="20" value="<?//=$tubepress['searchresultsrestrictedtouser']?>" /> -->
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Some videos have embedding disabled. Checking this option will exclude these videos from your galleries.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Only retrieve embeddable videos
					</td>
					<td style="padding: 0 10px;">
						<?php echo form_checkbox('embeddableOnly', "true", (isset($tubepress['embeddableonly']) && $tubepress['embeddableonly'] == "true") ? TRUE : FALSE ); ?>
					</td>
				</tr>
			</tbody>
		</table>		
	</div>
	
	
		<div id="tubepress_advanced_tab">
	
	
	
			
	<table cellpadding="0" cellspacing="0" border="0">
			<tbody>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="If checked, anyone will be able to view your debugging information.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Enable debugging
					</td>
					<td style="padding: 0 10px;">
						<?php echo form_checkbox('debugging_enabled', "true", (isset($tubepress['debugging_enabled']) && $tubepress['debugging_enabled'] == "true" ) ? TRUE : FALSE ); ?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Store API responses in a cache file to significantly reduce load times for your galleries at the slight expense of freshness.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Enable API cache
					</td>
					<td style="padding: 0 10px;">
						<?php echo form_checkbox('cacheEnabled', "true", (isset($tubepress['cacheenabled']) && $tubepress['cacheenabled'] == "true") ? TRUE : FALSE ); ?>
					</td>
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Leave blank to attempt to use your system's temp directory. Otherwise enter the absolute path of a writeable directory.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Cache directory
					</td>
					<td style="padding: 0 10px;">
						<?php
						
							$cachedirectory = (isset($tubepress['cachedirectory']) && $tubepress['cachedirectory'] != "") ? $tubepress['cachedirectory'] : APPPATH . PROJECTNUM . DS . "cache" . DS . "tubepress" . DS;
						
							$options = array(
								'name'        => 'cacheDirectory',
								'id'          => 'cacheDirectory',
								'value'       => $cachedirectory,
								'size'        => '60',
							);
							echo form_input($options);						
						?>
					</td>
					<!-- <input type="text" name="cacheDirectory" size="20" value="<?//=$tubepress['cachedirectory']?>" /> -->
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="Cache entries will be considered stale after the specified number of seconds. Default is 3600 (one hour).">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Cache expiration time (seconds)
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'cacheLifetimeSeconds',
								'id'          => 'cacheLifetimeSeconds',
								'value'       => (isset($tubepress['cachelifetimeseconds']) ? $tubepress['cachelifetimeseconds'] : ""),
								'size'        => '20',
							);
							echo form_input($options);						
						?>
					</td>
					<!-- <input type="text" name="cacheLifetimeSeconds" size="20" value="<?//=$tubepress['cachelifetimeseconds']?>" />	 -->
				</tr>
				<tr style="height:42px;">
					<td style="width: 210px;">
						<a style="float: right;" class="tooltip_description" rel="tooltip" data-original-title="If you enter X, the entire cache will be cleaned every 1/X cache writes. Enter 0 to disable cache cleaning.">
							 <i class="icon-exclamation-sign"></i>
						</a>
						Cache cleaning factor
					</td>
					<td style="padding: 0 10px;">
						<?php
							$options = array(
								'name'        => 'cacheCleaningFactor',
								'id'          => 'cacheCleaningFactor',
								'value'       => (isset($tubepress['cachecleaningfactor']) ? $tubepress['cachecleaningfactor'] : ""),
								'size'        => '20',
							);
							echo form_input($options);						
						?>
					</td>
					<!-- <input type="text" name="cacheCleaningFactor" size="20" value="<?//=$tubepress['cachecleaningfactor']?>" /> -->
				</tr>
			</tbody>
		</table>
		
			
	</div>
	
	
	</div>