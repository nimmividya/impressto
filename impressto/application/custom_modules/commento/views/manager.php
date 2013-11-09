<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Manager
@Type: PHP
@Filename: manager.php
@Description: 
@Author: 
@Projectnum: 
@Version: 1.0
@Status: development
@Date: 2012/09/04
*/
?>

<?php

$CI = &get_instance();

?>

<?php echo $infobar; ?>

<div class="admin-box">


<h3>Comment Moderation</h3>

		<div id="commento_admin_container">

			<div class="commento_admin_menu">
				<a class="<?php if($area == "comments") { echo "current"; } ?>" href="/commento/index/comments">Comments</a> | <a class="<?php if($area == "configuration") { echo "current"; } ?>" href="/commento/index/configuration">Configurations</a>
			</div>
			<?php
				
				if ($area == "configuration") {
					$configurations = $CI->commento_model->getConfigurations();
					?>
					
					<script type="text/javascript">
						$(function() {
							// Tabs
							
							// something odd is happening with pageshaper. If we are not in debug mode, these tabs will not load.
							$('#crudTabs').tabs();
					
							<?php
								// fix to keep background color empty value
								if($configurations["captcha_colorbg"] == "") {
									?>
									$('#captcha_colorbg').val("");
									<?php
								}
							?>
						});
					</script>
					
					<div class="work_space config_area">

						<br/>
	
						
						<div id="crudTabs">
							
							<ul>
								<li><a href="#tabs_1">Comment System</a></li>
								<li><a href="#tabs_2">Notifications</a></li>
								<li><a href="#tabs_3">Design</a></li>
								<li><a href="#tabs_4">Security</a></li>
								<li><a href="#tabs_5">Pagination</a></li>
								<li><a href="#tabs_6">Captcha</a></li>
								<li><a href="#tabs_7">Voting System</a></li>
							</ul>
							
				
							
							<div id="tabs_1">
								<form class="form_save_config" method="post" action="">
									<input type="hidden" name="post_action" value="save_cfg" />
									<table style="width: 100%;" >
									
									
									
								
										<tr>
											<td style="width: 70%;">
												<label for="maxnumchars">template</label>
												<small>Select a template for the comments</small>
												<br/>
											</td>
											<td><?=$template_selector?>
							
												<small>&nbsp;</small>
											</td>
										</tr>

										<tr>
											<td style="width: 70%;">
												<label for="mod_comments">initial_hidden</label>
												<small>Hide comments on initial page load?</small>
												<br/>
											</td>
											<td>
												<select name="initial_hidden" id="initial_hidden">
													<option <?php if ($configurations["initial_hidden"] == "0") echo 'selected="selected"'; ?> value="0">False</option>
													<option <?php if ($configurations["initial_hidden"] == "1") echo 'selected="selected"'; ?> value="1">True</option>
												</select><br/>
												<small>&nbsp;</small>
											</td>
										</tr>
										
										
											
										<tr>
											<td style="width: 70%;">
												<label for="maxnumchars">maxnumchars</label>
												<small>Maximun number of characters per comment</small>
											</td>
											<td>
												<select name="maxnumchars" id="maxnumchars">
													<option <?php if ($configurations["maxnumchars"] == "100") echo 'selected="selected"'; ?> value="100">100</option>
													<option <?php if ($configurations["maxnumchars"] == "250") echo 'selected="selected"'; ?> value="250">250</option>
													<option <?php if ($configurations["maxnumchars"] == "500") echo 'selected="selected"'; ?> value="500">500</option>
													<option <?php if ($configurations["maxnumchars"] == "1000") echo 'selected="selected"'; ?> value="1000">1000</option>
													<option <?php if ($configurations["maxnumchars"] == "1500") echo 'selected="selected"'; ?> value="1500">1500</option>
													<option <?php if ($configurations["maxnumchars"] == "2000") echo 'selected="selected"'; ?> value="2000">2000</option>
													<option <?php if ($configurations["maxnumchars"] == "2500") echo 'selected="selected"'; ?> value="2500">2500</option>
													<option <?php if ($configurations["maxnumchars"] == "5000") echo 'selected="selected"'; ?> value="5000">5000</option>
													<option <?php if ($configurations["maxnumchars"] == "7500") echo 'selected="selected"'; ?> value="7500">7500</option>
													<option <?php if ($configurations["maxnumchars"] == "9999") echo 'selected="selected"'; ?> value="9999">9999</option>
												</select>
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												&nbsp;
											</td>
										</tr>
										<tr>
											<td style="width: 70%;">
												<label for="Replymaxnumchars">Replymaxnumchars</label>
												<small>Maximun number of characters per reply</small>
											</td>
											<td>
												<select name="Replymaxnumchars" id="Replymaxnumchars">
													<option <?php if ($configurations["Replymaxnumchars"] == "100") echo 'selected="selected"'; ?> value="100">100</option>
													<option <?php if ($configurations["Replymaxnumchars"] == "250") echo 'selected="selected"'; ?> value="250">250</option>
													<option <?php if ($configurations["Replymaxnumchars"] == "500") echo 'selected="selected"'; ?> value="500">500</option>
													<option <?php if ($configurations["Replymaxnumchars"] == "1000") echo 'selected="selected"'; ?> value="1000">1000</option>
													<option <?php if ($configurations["Replymaxnumchars"] == "1500") echo 'selected="selected"'; ?> value="1500">1500</option>
													<option <?php if ($configurations["Replymaxnumchars"] == "2000") echo 'selected="selected"'; ?> value="2000">2000</option>
													<option <?php if ($configurations["Replymaxnumchars"] == "2500") echo 'selected="selected"'; ?> value="2500">2500</option>
													<option <?php if ($configurations["Replymaxnumchars"] == "5000") echo 'selected="selected"'; ?> value="5000">5000</option>
												</select>
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												&nbsp;
											</td>
										</tr>
										<tr>
											<td style="width: 70%;">
												<label for="mod_comments">mod_comments</label>
												<small>All comments should be moderated?</small>
											</td>
											<td>
												<select name="mod_comments" id="mod_comments">
													<option <?php if ($configurations["mod_comments"] == "0") echo 'selected="selected"'; ?> value="0">False</option>
													<option <?php if ($configurations["mod_comments"] == "1") echo 'selected="selected"'; ?> value="1">True</option>
												</select><br/>
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												&nbsp;
											</td>
										</tr>
										<tr>
											<td style="width: 70%;">
												<label for="conv_url_to_link">conv_url_to_link</label>
												<small>convert URL's in text to links? (nofollow and target blank will be added)</small>
											</td>
											<td>
												<select name="conv_url_to_link" id="conv_url_to_link">
													<option <?php if ($configurations["conv_url_to_link"] == "0") echo 'selected="selected"'; ?> value="0">False</option>
													<option <?php if ($configurations["conv_url_to_link"] == "1") echo 'selected="selected"'; ?> value="1">True</option>
												</select><br/>
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												&nbsp;
											</td>
										</tr>
										<tr>
											<td style="width: 70%;">
												<label for="display_order">display_order</label>
												<small>Order of comments (Most recent bottom = Ascending) or (Most recent top = Descending)</small>
											</td>
											<td>
												<select name="display_order" id="display_order">
													<option <?php if ($configurations["display_order"] == "ASC") echo 'selected="selected"'; ?> value="ASC">Ascending</option>
													<option <?php if ($configurations["display_order"] == "DESC") echo 'selected="selected"'; ?> value="DESC">Descending</option>
												</select><br/>
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<br/>
												<input class="btn btn-success" type="submit" method="post" value="save configurations" />											
											
											</td>
										</tr>	
									</table>
								</form>
							</div>
							
							<div id="tabs_2">
							
								<form class="form_save_config" method="post" action="">
									<input type="hidden" name="post_action" value="save_cfg" />
									<table style="width: 100%;" >
										<tr>
											<td style="width: 70%;">
												<label for="notification_email">Notification Email</label>
												<small>Recipient for comments (leave blank to disable)</small>
											</td>
											<td>
												<input type="text" name="notification_email" id="notification_email" value="<?php echo $configurations["notification_email"]; ?>" /><br/>
												<small>&nbsp;</small>
											</td>
										</tr>
										
					
										<tr>
											<td colspan="2">
												<br/>
												<input class="btn btn-success" type="submit" method="post" value="save configurations" />											

											</td>
										</tr>	
									</table>
								</form>
								
							
							</div>
							
							<div id="tabs_3">
							
									<form class="form_save_config" method="post" action="">
									<input type="hidden" name="post_action" value="save_cfg" />
									<table style="width: 100%;" >
										<tr>
											<td style="width: 70%;">
												<label for="ask_web_address">ask_web_address</label>
												<small>Request the users web url as part of the form?</small>
											</td>
											<td>
												<select name="reg_users_only" id="reg_users_only">
													<option <?php if ($configurations["ask_web_address"] == "0") echo 'selected="selected"'; ?> value="0">False</option>
													<option <?php if ($configurations["ask_web_address"] == "1") echo 'selected="selected"'; ?> value="1">True</option>
												</select><br/>
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												&nbsp;
											</td>
										</tr>
				
			
										<tr>
											<td colspan="2">
												<br/>
												<input class="btn btn-success" type="submit" method="post" value="save configurations" />											

											</td>
										</tr>	
									</table>
								</form>
								
								
								
							</div>
							
							<div id="tabs_4">
								<form class="form_save_config" method="post" action="">
									<input type="hidden" name="post_action" value="save_cfg" />
									<table style="width: 100%;" >
										<tr>
											<td style="width: 70%;">
												<label for="reg_users_only">reg_users_only</label>
												<small>Should COMMAX only allow registered users to comment?</small>
											</td>
											<td>
												<select name="reg_users_only" id="reg_users_only">
													<option <?php if ($configurations["reg_users_only"] == "0") echo 'selected="selected"'; ?> value="0">False</option>
													<option <?php if ($configurations["reg_users_only"] == "1") echo 'selected="selected"'; ?> value="1">True</option>
												</select><br/>
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												&nbsp;
											</td>
										</tr>
										<tr>
											<td style="width: 70%;">
												<label for="allowed_html">allowed_html</label>
												<small>What HTML tags should be allowed? (separate by comma. Leave blank for none)</small><br/>
												<small>Carefull here. Htmlpurifier <strong>HTML.Allowed</strong> directive. <a target="blank" href="http://htmlpurifier.org/live/configdoc/plain.html#HTML.Allowed">More info here</a></small>
											</td>
											<td>
												<input type="text" name="allowed_html" id="allowed_html" value="<?php echo $configurations["allowed_html"]; ?>" /><br/>
												<small>&nbsp;</small><br/>
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												&nbsp;
											</td>
										</tr>
										<tr>
											<td style="width: 70%;">
												<label for="blacklist">blacklist</label>
												<small>A list of words that will stop comment to be submitted (separate by comma)</small><br/>
											</td>
											<td>
												<input type="text" name="blacklist" id="blacklist" value="<?php echo $configurations["blacklist"]; ?>" /><br/>
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												&nbsp;
											</td>
										</tr>
										<tr>
											<td style="width: 70%;">
												<label for="captcha_enabled">captcha_enabled</label>
												<small>Should the captcha system be enabled?</small>
											</td>
											<td>
												<select name="captcha_enabled" id="captcha_enabled">
													<option <?php if ($configurations["captcha_enabled"] == "0") echo 'selected="selected"'; ?> value="0">NO</option>
													<option <?php if ($configurations["captcha_enabled"] == "1") echo 'selected="selected"'; ?> value="1">YES</option>
												</select><br/>
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<br/>
												<input class="btn btn-success" type="submit" method="post" value="save configurations" />											

											</td>
										</tr>	
									</table>
								</form>
							</div>
							
							<div id="tabs_5">
								<form class="form_save_config" method="post" action="">
									<input type="hidden" name="post_action" value="save_cfg" />
									<table style="width: 100%;" >
										<tr>
											<td style="width: 70%;">
												<label for="mid_range">mid_range</label>
												<small>How many page link to either side of current selected one?</small>
											</td>
											<td>
												<select name="mid_range" id="mid_range">
													<option <?php if ($configurations["mid_range"] == "2") echo 'selected="selected"'; ?> value="2">2</option>
													<option <?php if ($configurations["mid_range"] == "3") echo 'selected="selected"'; ?> value="3">3</option>
													<option <?php if ($configurations["mid_range"] == "4") echo 'selected="selected"'; ?> value="4">4</option>
													<option <?php if ($configurations["mid_range"] == "5") echo 'selected="selected"'; ?> value="5">5</option>
													<option <?php if ($configurations["mid_range"] == "6") echo 'selected="selected"'; ?> value="6">6</option>
													<option <?php if ($configurations["mid_range"] == "7") echo 'selected="selected"'; ?> value="7">7</option>
													<option <?php if ($configurations["mid_range"] == "8") echo 'selected="selected"'; ?> value="8">8</option>
													<option <?php if ($configurations["mid_range"] == "9") echo 'selected="selected"'; ?> value="9">9</option>
													<option <?php if ($configurations["mid_range"] == "10") echo 'selected="selected"'; ?> value="10">10</option>
													<option <?php if ($configurations["mid_range"] == "15") echo 'selected="selected"'; ?> value="15">15</option>
												</select><br/>
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												&nbsp;
											</td>
										</tr>
										<tr>
											<td style="width: 70%;">
												<label for="default_ipp">default_ipp</label>
												<small>Number of comments per page (set <strong>ALL</strong> to show all and disable pagination)</small>
											</td>
											<td>
												<select name="default_ipp" id="default_ipp">
													<option <?php if ($configurations["default_ipp"] == "2") echo 'selected="selected"'; ?> value="2">2</option>
													<option <?php if ($configurations["default_ipp"] == "4") echo 'selected="selected"'; ?> value="4">4</option>
													<option <?php if ($configurations["default_ipp"] == "5") echo 'selected="selected"'; ?> value="5">5</option>
													<option <?php if ($configurations["default_ipp"] == "10") echo 'selected="selected"'; ?> value="10">10</option>
													<option <?php if ($configurations["default_ipp"] == "15") echo 'selected="selected"'; ?> value="15">15</option>
													<option <?php if ($configurations["default_ipp"] == "25") echo 'selected="selected"'; ?> value="25">25</option>
													<option <?php if ($configurations["default_ipp"] == "50") echo 'selected="selected"'; ?> value="50">50</option>
													<option <?php if ($configurations["default_ipp"] == "ALL") echo 'selected="selected"'; ?> value="ALL">ALL</option>
												</select><br/>
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<br/>
												<input class="btn btn-success" type="submit" method="post" value="save configurations" />
											</td>
										</tr>	
									</table>
								</form>
							</div>
							
							<div id="tabs_6">
								<form class="form_save_config" method="post" action="">
									<input type="hidden" name="post_action" value="save_cfg" />
									<table style="width: 100%;" >
										<tr>
											<td style="width: 70%;">
												<label for="captcha_width">captcha_width</label>
												<small>The width of the captcha image. Height is calculated automatically</small><br/>
											</td>
											<td>
												<input type="text" name="captcha_width" id="captcha_width" value="<?php echo $configurations["captcha_width"]; ?>" /><br/>
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												&nbsp;
											</td>
										</tr>
										<tr>
											<td style="width: 70%;">
												<label for="captcha_color1">captcha_color1</label>
												<small>Set HEXADECIMAL color for Color 2.</small><br/>
											</td>
											<td>
												<input type="text" id="captcha_color1" name="captcha_color1" class="color-picker" style="width:70px" value="<?php echo ( isset($configurations['captcha_color1']) ?  $configurations['captcha_color1'] : ''); ?>" /><br/>
												
			
												<!-- <input type="text" name="captcha_color1" id="captcha_color1" value="<?php //echo $configurations["captcha_color1"]; ?>" /><br/> -->
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												&nbsp;
											</td>
										</tr>
										<tr>
											<td style="width: 70%;">
												<label for="captcha_color2">captcha_color2</label>
												<small>Set HEXADECIMAL color for Color 2.</small><br/>
											</td>
											<td>
												<input type="text" id="captcha_color2" name="captcha_color2" class="color-picker" style="width:70px" value="<?php echo ( isset($configurations['captcha_color2']) ?  $configurations['captcha_color2'] : ''); ?>" /><br/>
												
												
												<!-- <input type="text" name="captcha_color2" id="captcha_color2" value="<?php //echo $configurations["captcha_color2"]; ?>" /><br/> -->
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												&nbsp;
											</td>
										</tr>
										<tr>
											<td style="width: 70%;">
												<label for="captcha_color3">captcha_color3</label>
												<small>Set HEXADECIMAL color for Color 3.</small><br/>
											</td>
											<td>
												<input type="text" id="captcha_color3" name="captcha_color3" class="color-picker" style="width:70px" value="<?php echo ( isset($configurations['captcha_color3']) ?  $configurations['captcha_color3'] : ''); ?>" /><br/>

																							
												<!-- <input type="text" name="captcha_color3" id="captcha_color3" value="<?php //echo $configurations["captcha_color3"]; ?>" /><br/> -->
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												&nbsp;
											</td>
										</tr>
										<tr>
											<td style="width: 70%;">
												<label for="captcha_colorbg">captcha_colorbg</label>
												<small>Set HEXADECIMAL color for background. Leave blank for transparent.</small><br/>
											</td>
											<td>
												<input type="text" id="captcha_colorbg" name="captcha_colorbg" class="color-picker" style="width:70px" value="<?php echo ( isset($configurations['captcha_colorbg']) ?  $configurations['captcha_colorbg'] : ''); ?>" /><br/>

																	
												<!-- <input type="text" name="captcha_colorbg" id="captcha_colorbg" value="<?php //echo $configurations["captcha_colorbg"]; ?>" /><br/> -->
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<br/>
												<input class="btn btn-success" type="submit" method="post" value="save configurations" />
											</td>
										</tr>	
									</table>
								</form>
							</div>
							
							<div id="tabs_7">
								<form class="form_save_config" method="post" action="">
									<input type="hidden" name="post_action" value="save_cfg" />
									<table style="width: 100%;" >
										<tr>
											<td style="width: 70%;">
												<label for="karma_on">karma_on</label><br/>
												<small>Turn karma system on?</small>
											</td>
											<td>
												<select name="karma_on" id="karma_on">
													<option <?php if ($configurations["karma_on"] == "0") echo 'selected="selected"'; ?> value="0">Karma OFF</option>
													<option <?php if ($configurations["karma_on"] == "1") echo 'selected="selected"'; ?> value="1">Karma ON</option>
												</select><br/>
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												&nbsp;
											</td>
										</tr>
										<tr>
											<td style="width: 70%;">
												<label for="karma_type">karma_type</label><br/>
												<small>Should the votes be counted based on a cookie, meaning everybody can vote?</small><br/>
												<small>Or allow only to registered users? (database email verify)</small><br/>
												<small><strong>WARNING:</strong> cookies are very very easy to cheat. I warned you!</small><br/>
												<small><strong>WARNING:</strong> "Logged User Based" with "reg_users_only = false", KARMA WON'T SHOW.</small>
											</td>
											<td>
												<select name="karma_type" id="karma_type">
													<option <?php if ($configurations["karma_type"] == "cookie") echo 'selected="selected"'; ?> value="cookie">Cookie Based</option>
													<option <?php if ($configurations["karma_type"] == "user") echo 'selected="selected"'; ?> value="user">Logged User Based</option>
												</select><br/>
												<small>&nbsp;</small><br/>
												<small>&nbsp;</small><br/>
												<small>&nbsp;</small><br/>
												<small>&nbsp;</small>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<br/>
												<input class="btn btn-success" type="submit" method="post" value="save configurations" />
											</td>
										</tr>	
									</table>
								</form>
							</div>
						</div>
					</div>
					<?php
				} else {
					?>
					<div class="work_space comments_area">
						<div id="dialog-remove" title="Confirm Comment Removal">
							<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span> You are about to remove a comment:</p>
							<p>Are you sure you want to remove this comment?</p>
						</div>
						<div id="dialog-approve" title="Confirm Comment Approval">
							<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span> You are about to approve a comment:</p>
							<p>Are you sure you want to approve this comment?</p>
						</div>
						<?php
							if ($subarea == "showall") {
								$comments = $CI->commento_model->admin_build_comment_system(null, null);
								?>
								<h4>Comments - Show all</h4>
								<br/>
								<br/>
								<?php
								echo $comments;
								
								
							} else if ($subarea == "showunreviewed") {
								$comments = $CI->commento_model->admin_build_unreviewed_comment_system(null, null);
								?>
								<h3>Comments - Show unreviewed</h3>
								<br/>
								<br/>
								<?php
								echo $comments;
								
								
							} else {
								?>
								<h2>Comments</h2>
								<ul class="commento_list">
									<?php
									$mainComments = $CI->commento_model->adminGetMainComments();
									while($row = mysql_fetch_assoc($mainComments)) {
										$uncomments = $CI->commento_model->adminGetUnreviewdTotalComments($row["content_type"], $row["content_id"]);
										?>
										<li>
											<span>There are <?php echo $row["total"]; ?> comments in page (<?php echo $row["content_id"]; ?>)</span>
											<div>
												<a href="/commento/index/comments/showall/?id=<?php echo $row["content_id"] ?>">Show all comments</a> | 
												<?php
												if ($uncomments > 0) {
													?>
													<a href="/commento/index/comments/showunreviewed/?id=<?php echo $row["content_id"] ?>"><?php echo $uncomments; ?> need review</a>
													<?php
												} else {
													?>
													<?php echo $uncomments; ?> need review
													<?php
												}
												?>
											</div>
											<br clear="all" />
										</li>
										<?php
									}
									?>
								</ul>
								<?php
							}
						?>
					</div>
					<?php
				}
			?>
			
		</div>
		
</div>