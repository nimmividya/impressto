<?php
/*
@Name: Site Settings
@Type: PHP
@Filename: site_settings_view.php
@Description: general settings page for the site
@Author: Nimmitha Vidyathilaka
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-05-15
*/
?>

<?php


// loaded from the site_settings in options table
//$languages = $this->config->item('languages');

$languages = $this->config->item('languages');

	
?>
<div class="admin-box">
<h3><i class="icon-wrench"></i> Site Settings</h3>
<?=$infobar?>

<?php
// this is for the jquery UI 1.9 tabs bug
$request_uri = getenv("REQUEST_URI");
?>


<div class="settings_page">
	<form id="ps_settings_form" class="form-horizontal" accept-charset="utf-8">
		<div id="crudTabs" style="display: none;">
			<ul>
				<li><a href="<?=$request_uri?>#general_settings">General</a></li>
				<li><a href="<?=$request_uri?>#notifications">Notifications</a></li>
				<li><a href="<?=$request_uri?>#api_keys">API Keys</a></li>	
				<li><a href="<?=$request_uri?>#content_management">Content Management</a></li>
		
								
				<?php 
				
				$lang_avail = $this->config->item('lang_avail');
											
				foreach($lang_avail AS $key=>$val){ ?>
											
						<li><a href="<?=$request_uri?>#<?=$key?>_settings"><?php echo ucwords($val); ?></a></li>
						
				<?php } ?>
			</ul>
			<div class="footNav clearfix">
				<ul>
					<li><button class="btn btn-default" type="button" onClick="site_settings.save();">Save</button></li>
					<li><button class="btn btn-default" type="button" onClick="site_settings.clearsmartycache();">Clear Page Cache</button></li>
				</ul>
			</div>
			
			<div id="general_settings">
				
			
			
				<div class="control-group ">
				<label for="admin_theme" class="control-label">Admin Theme</label>
					<div class="controls">
			
					<?php 

					$fielddata = array(
						'name'        => "admin_theme",
						'type'          => 'select',
						'id'          => "admin_theme",
						'width'          => 200,
						'usewrapper'          => FALSE,
						'options' =>  $available_themes,
						'value'       =>  (isset($option_data['admin_theme']) ? $option_data['admin_theme'] : "classic")
					);
					
					echo $this->formelement->generate($fielddata);
					
				?>
				</div>
				</div>
						
					
				
				
				<div class="control-group ">
				<label for="splash_page_id" class="control-label">Language Select Page</label>
					<div class="controls">
			
					<?php 

				$optionval = isset($option_data['splash_page_id']) ? $option_data['splash_page_id'] : "";
				
				$data = array(	
				'name'        => "splash_page_id",
				'id'          => "splash_page_id",
				'type'          => 'select',
				'showlabels'          => false,
				'width'          => 300,
				'label'          => "",
				'onchange' => "",
				'value'       => $optionval,
				'use_ids' => TRUE,
				
	
				);

				echo get_ps_page_slector($data); 
				?>
				</div>
				</div>
				
				

				<div class="control-group ">
				<label for="potential_admin_list" class="control-label">Site Admin e-Mail</label>
					<div class="controls">
					
					
					<?php
					
					$fielddata = array(
						'name'        => "potential_admin_list",
						'type'          => 'select',
						'id'          => "potential_admin_list",
						'label'          => "",
						'width'          => 300,
						'usewrapper'          => FALSE,
						'options' =>  $potential_admin_list,
						'onchange' => 'site_settings.select_site_admin(this)',
						'value'       =>  (isset($option_data['site_admin']) ? $option_data['site_admin'] : "")
					);
					
					echo $this->formelement->generate($fielddata);
					
					
					?>
					<br />
					<br />
					
					<input type="text" style="width:300px" id="site_admin" name="site_admin" value="<?php echo isset($option_data['site_admin']) ? $option_data['site_admin'] : ""; ?>" />
				</div>
				</div>

			
				<div class="control-group" style="background: url(<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/images/yuno.png) 0 45px no-repeat;">
				
			
				
					<label for="admin_theme" class="control-label">Developer Settings</label>
						<div class="controls">
						
	
				<div style="float:left"><?php
					$optionval = isset($option_data['debugmode']) ? $option_data['debugmode'] : 0;

					$fielddata = array(
						'name'        => "debugmode",
						'type'          => 'checkbox',
						'id'          => "debugmode",
						'usewrapper'          => TRUE,
						'label'     => 'Enable Debug Mode',
						'options' =>  '1',
						'value'       =>  $optionval,
					);
					
					echo $this->formelement->generate($fielddata);
					
				?></div>
							
				<div style="clear:both"></div>
									
					
				<div style="float:left;"><?php
				
					$optionval = isset($option_data['debug_profiling']) ? $option_data['debug_profiling'] : 0;

					$fielddata = array(
						'name'        => "debug_profiling",
						'type'          => 'checkbox',
						'id'          => "debug_profiling",
						'usewrapper'          => TRUE,
						'label'     => 'Enable Debug Profiling',
						'options' =>  '1',
						'value'       =>  $optionval,
					);
					
					echo $this->formelement->generate($fielddata);
					
					?></div>
					
					<div style="clear:both"></div>
				
					<div style="float:left;"><?php
			

					$optionval = isset($option_data['unit_testing']) ? $option_data['unit_testing'] : 0;

					$fielddata = array(
						'name'        => "unit_testing",
						'type'          => 'checkbox',
						'id'          => "unit_testing",
						'usewrapper'          => TRUE,
						'label'     => 'Enable Unit Testing',
						'options' =>  '1',
						'value'       =>  $optionval,
					);
					
					echo $this->formelement->generate($fielddata);
					
					?></div>
						
					</div>
							
				
					<div style="clear:both; height:20px;"></div>
					

					<label for="admin_theme" class="control-label">API Key</label>
						<div class="controls">
					
					<?php
			
					$optionval = isset($option_data['api_key']) ? $option_data['api_key'] : '';

					$fielddata = array(
						'name'        => "api_key",
						'type'          => 'text',
						'id'          => "api_key",
						'width' 	=> 250,
						'usewrapper'          => FALSE,
						'value'       =>   $optionval,
					);
					
					echo $this->formelement->generate($fielddata);
					
					?>
					
					</div>
					
					
					<div style="clear:both; height:20px;"></div>
									
					
					<label for="jquery_version" class="control-label">jQuery Version</label>
						<div class="controls">
					
					<?php
			
					$optionval = isset($option_data['jquery_version']) ? $option_data['jquery_version'] : '1.8.2';

					$fielddata = array(
						'name'        => "jquery_version",
						'type'          => 'text',
						'id'          => "jquery_version",
						'width' 	=> 40,
						'usewrapper'          => FALSE,
						'value'       =>   $optionval,
					);
					
					echo $this->formelement->generate($fielddata);
					
					?>
					
					</div>
					
					

					<div style="clear:both; height:20px;"></div>
				
					<label for="jquery_ui_version" class="control-label">jQuery UI Version</label>
						<div class="controls">
					
					<?php
			
					$optionval = isset($option_data['jquery_ui_version']) ? $option_data['jquery_ui_version'] : '1.9.1';

					$fielddata = array(
						'name'        => "jquery_ui_version",
						'type'          => 'text',
						'id'          => "jquery_ui_version",
						'width' 	=> 40,
						'usewrapper'          => FALSE,
						'value'       =>   $optionval,
					);
					
					echo $this->formelement->generate($fielddata);
					
					?>
					
					</div>
					

					
				
					<div style="clear:both; height:20px;"></div>
					
				
					<label for="jquery_ui_theme" class="control-label">jQuery UI Theme</label>
						<div class="controls">
					
					<?php
			
					$optionval = isset($option_data['jquery_ui_theme']) ? $option_data['jquery_ui_theme'] : 'smoothness';

					$fielddata = array(
						'name'        => "jquery_ui_theme",
						'type'          => 'text',
						'id'          => "jquery_ui_theme",
						'width' 	=> 100,
						'usewrapper'          => FALSE,
						'value'       =>   $optionval,
					);
					
					echo $this->formelement->generate($fielddata);
					
					?>
					
					</div>

					
					
				</div>
				
				
				
				
				
				
				
				
			</div><!-- [END] #general_settings -->
			
			
			
			<div id="content_management">
			
				<div>
				<strong>WYSIWYG Editor</strong>
				<br />
				<?php 
				
					$options = array();
				
					if(file_exists(INSTALL_ROOT . "default/vendor/ckeditor/ckeditor.php")){
					
						$options["CK Editor"] = "ckeditor";
											
					}
					
					$options["Tiny MCE"] = "tiny_mce";
					$options["Nerd Mode(raw HTML)"] = "none";
									

					$fielddata = array(
						'name'        => "wysiwyg_editor",
						'type'          => 'select',
						'id'          => "wysiwyg_editor",
						'width'          => 200,
						'usewrapper'          => FALSE,
						'options' =>  $options,
						'value'       =>  (isset($option_data['wysiwyg_editor']) ? $option_data['wysiwyg_editor'] : "ckeditor")
					);
					
					echo $this->formelement->generate($fielddata);
					
				?>
				</div>
				
				<div>
					
				<strong>Page Cache Timeout</strong>
				<br />
				<?php 

					$fielddata = array(
						'name'        => "page_cache_timeout",
						'type'          => 'select',
						'id'          => "page_cache_timeout",
						'width'          => 200,
						'usewrapper'          => FALSE,
						'options' =>  array("No Cache"=>0,"30 Minutes"=>1800,"1 hour"=>3600,"2 hours"=>7200,"4 hours"=>14400, "1 day"=>86400),
						'value'       =>  (isset($option_data['page_cache_timeout']) ? $option_data['page_cache_timeout'] : 0)
					);
					
					echo $this->formelement->generate($fielddata);
					
				?>
				</div>
			</div>
			
			
			
			

			
			
			<div id="notifications">
			
	
			
    <div class="grey_box">
<div class="form_title">Protocol</div>
<div class="text_black">PHP mail() » <input type="radio" value="1" name="email_protocol"></div>
<div class="text_black">Sendmail » <input type="radio" checked="checked" value="2" name="email_protocol"></div>
<div class="text_black">Gmail SMTP » <input type="radio" value="3" name="email_protocol"></div>
</div>

<div class="grey_box">
<div class="form_label"><label for="sendmail_path">Path to sendmail</label></div>
<div class="text_black">For most servers this is /usr/sbin/sendmail</div>
<div class="input_box_thin"><input type="text" class="input_text" id="sendmail_path" value="/usr/sbin/sendmail" name="sendmail_path"></div>
<div class="form_label"><label for="smtp_host">SMTP host</label> ."</div>
<div class="input_box_thin"><input type="text" class="input_text" id="smtp_host" value="ssl://smtp.googlemail.com" name="smtp_host"></div>
<div class="form_label"><label for="smtp_port">SMTP port</label> ."</div>
<div class="input_box_thin"><input type="text" class="input_text" id="smtp_port" value="465" name="smtp_port"></div>
<div class="form_label"><label for="smtp_user">SMTP user</label></div>
<div class="input_box_thin"><input type="text" class="input_text" id="smtp_user" value="" name="smtp_user"></div>
<div class="form_label"><label for="smtp_pass">SMTP password</label></div>
<div class="text_black">Will be encrypted before saving to database.</div>
<div class="input_box_thin"><input type="text" class="input_text" id="smtp_pass" value="" name="smtp_pass"></div>
</div>

			</div>
			
			
			<div id="api_keys">
						
			
				<h2>Third Party APIs</a>
				
				<form method="post"> 


	<h4>HybridAuth Endpoint</h4> 
 
	
	<ul style="list-style:circle inside;">
		<li style="color: #000000;font-size: 14px;">HybridAuth endpoint url is where the index.php is located.</li>
		<li style="color: #000000;font-size: 14px;">HybridAuth enpoint should be set to <b>+rx mode</b> (read and execute permissions)</li>
	</ul>
	
	<div> 
		<div class="cfg">
		   <div class="cgfparams"> 
			  <ul>
				<li><label>HybridAuth Endpoint URL</label><input type="text" style="min-width:380px;" name="GLOBAL_HYBRID_AUTH_URL_BASE" value="http://impressto.com/hybridauth/" class="inputgnrc"></li>
			  </ul>
		   </div> 
		   <div style="margin-left: 430px;padding: 20px;min-height: 60px;width: 190px;" class="cgftip">
				Set the complete url to hybridauth core library on your website.  
				This URL will be used for many providers as the <a target="_blank" href="http://hybridauth.sourceforge.net/userguide/HybridAuth_endpoint_URL.html">Endpoint</a> for your website. 
		   </div>
		</div>   
	</div> 
	<br style="clear:both;"> 
	<br>

	<h4>Providers setup</h4> 

	<ul style="list-style:circle inside;">
		<li style="color: #000000;font-size: 14px;">To correctly setup these Identity Providers please carefully follow the help section of each one.</li>
		<li style="color: #000000;font-size: 14px;">If <b>Provider Adapter Satus</b> is set to <b style="color:red">Disabled</b> then users will not be able to login with this provider on you website.</li>
	</ul>

	<h4>Facebook</h4> 
	<div> 
		<div class="cfg">
		   <div class="cgfparams">
			  <ul>
				 <li><label>Facebook Adapter Satus</label>
					<select name="FACEBOOK_ADAPTER_STATUS">
						<option value="true" selected="selected">Enabled</option>
						<option value="false">Disabled</option>
					</select>
				</li>
															<li><label>Application ID</label><input type="text" name="FACEBOOK_APPLICATION_APP_ID" value="" class="inputgnrc"></li>
						 
					<li><label>Application Secret</label><input type="text" name="FACEBOOK_APPLICATION_SECRET" value="" class="inputgnrc"></li>
							  </ul> 
		   </div>
		   <div class="cgftip">
				 
					<p><b>1</b>. Go to <a target="_blanck" href="https://www.facebook.com/developers/">https://www.facebook.com/developers/</a> and <b>create a new application</b>.</p>

					<p><b>2</b>. Fill out any required fields such as the application name and description.</p>

						

					 

					 

					 

											<p><b>3</b>. Put your website domain in the <b>Site Url</b> field. It should match with the current hostname <em style="color:#CB4B16;">impressto.com</em>.</p> 
						

						

						

						
					
					<p><b>4</b>. Once you have registered, copy and past the created application credentials into this setup page.</p>  
				 
		   </div>
		</div>   
	</div> 
	<br style="clear:both;"> 
	<br>
	<h4>Google</h4> 
	<div> 
		<div class="cfg">
		   <div class="cgfparams">
			  <ul>
				 <li><label>Google Adapter Satus</label>
					<select name="GOOGLE_ADAPTER_STATUS">
						<option value="true" selected="selected">Enabled</option>
						<option value="false">Disabled</option>
					</select>
				</li>
															<li><label>Application ID</label><input type="text" name="GOOGLE_APPLICATION_APP_ID" value="" class="inputgnrc"></li>
						 
					<li><label>Application Secret</label><input type="text" name="GOOGLE_APPLICATION_SECRET" value="" class="inputgnrc"></li>
							  </ul> 
		   </div>
		   <div class="cgftip">
				 
					<p><b>1</b>. Go to <a target="_blanck" href="https://code.google.com/apis/console/">https://code.google.com/apis/console/</a> and <b>create a new application</b>.</p>

					<p><b>2</b>. Fill out any required fields such as the application name and description.</p>

											<p><b>3</b>. On the <b>"Create Client ID"</b> popup switch to advanced settings by clicking on <b>(more options)</b>.</p>
						

											<p>
							<b>4</b>. Provide this URL as the Callback URL for your application:
							<br>
							<span style="color:green">http://impressto.com/hybridauth/?hauth.done=Google</span>						</p>
					 

					 

					 

						

						

						

						
					
					<p><b>5</b>. Once you have registered, copy and past the created application credentials into this setup page.</p>  
				 
		   </div>
		</div>   
	</div> 
	<br style="clear:both;"> 
	<br>
	<h4>Twitter</h4> 
	<div> 
		<div class="cfg">
		   <div class="cgfparams">
			  <ul>
				 <li><label>Twitter Adapter Satus</label>
					<select name="TWITTER_ADAPTER_STATUS">
						<option value="true" selected="selected">Enabled</option>
						<option value="false">Disabled</option>
					</select>
				</li>
										
						<li><label>Application Key</label><input type="text" name="TWITTER_APPLICATION_KEY" value="" class="inputgnrc"></li>
						 
					<li><label>Application Secret</label><input type="text" name="TWITTER_APPLICATION_SECRET" value="" class="inputgnrc"></li>
							  </ul> 
		   </div>
		   <div class="cgftip">
				 
					<p><b>1</b>. Go to <a target="_blanck" href="https://dev.twitter.com/apps">https://dev.twitter.com/apps</a> and <b>create a new application</b>.</p>

					<p><b>2</b>. Fill out any required fields such as the application name and description.</p>

						

					 

					 

					 

						

						

						

											<p><b>3</b>. Put your website domain in the <b>Application Website</b> and <b>Application Callback URL</b> fields. It should match with the current hostname <em style="color:#CB4B16;">impressto.com</em>.</p> 
						<p><b>4</b>. Set the <b>Default Access Type</b> to <em style="color:#CB4B16;">Read, Write, &amp; Direct Messages</em>.</p> 
						
					
					<p><b>5</b>. Once you have registered, copy and past the created application credentials into this setup page.</p>  
				 
		   </div>
		</div>   
	</div> 
	<br style="clear:both;"> 
	<br>
	<h4>Yahoo!</h4> 
	<div> 
		<div class="cfg">
		   <div class="cgfparams">
			  <ul>
				 <li><label>Yahoo! Adapter Satus</label>
					<select name="YAHOO_ADAPTER_STATUS">
						<option value="true" selected="selected">Enabled</option>
						<option value="false">Disabled</option>
					</select>
				</li>
															<li><label>Application ID</label><input type="text" name="YAHOO_APPLICATION_APP_ID" value="" class="inputgnrc"></li>
						 
					<li><label>Application Secret</label><input type="text" name="YAHOO_APPLICATION_SECRET" value="" class="inputgnrc"></li>
							  </ul> 
		   </div>
		   <div class="cgftip">
				 
					<p><b>1</b>. Go to <a target="_blanck" href="https://developer.apps.yahoo.com/dashboard/createKey.html">https://developer.apps.yahoo.com/dashboard/createKey.html</a> and <b>create a new application</b>.</p>

					<p><b>2</b>. Fill out any required fields such as the application name and description.</p>

						

					 

					 

					 

						

						

											<p><b>3</b>. Put your website domain in the <b>Application URL</b> and <b>Application Domain</b> fields. It should match with the current hostname <em style="color:#CB4B16;">impressto.com</em>.</p> 
						<p><b>4</b>. Set the <b>Kind of Application</b> to <em style="color:#CB4B16;">Web-based</em>.</p> 
						

						
					
					<p><b>5</b>. Once you have registered, copy and past the created application credentials into this setup page.</p>  
				 
		   </div>
		</div>   
	</div> 
	<br style="clear:both;"> 
	<br>
	<h4>Windows Live</h4> 
	<div> 
		<div class="cfg">
		   <div class="cgfparams">
			  <ul>
				 <li><label>Windows Live Adapter Satus</label>
					<select name="LIVE_ADAPTER_STATUS">
						<option value="true" selected="selected">Enabled</option>
						<option value="false">Disabled</option>
					</select>
				</li>
															<li><label>Application ID</label><input type="text" name="LIVE_APPLICATION_APP_ID" value="" class="inputgnrc"></li>
						 
					<li><label>Application Secret</label><input type="text" name="LIVE_APPLICATION_SECRET" value="" class="inputgnrc"></li>
							  </ul> 
		   </div>
		   <div class="cgftip">
				 
					<p><b>1</b>. Go to <a target="_blanck" href="https://manage.dev.live.com/ApplicationOverview.aspx">https://manage.dev.live.com/ApplicationOverview.aspx</a> and <b>create a new application</b>.</p>

					<p><b>2</b>. Fill out any required fields such as the application name and description.</p>

						

					 

					 

											<p><b>3</b>. Put your website domain in the <b>Redirect Domain</b> field. It should match with the current hostname <em style="color:#CB4B16;">impressto.com</em>.</p>
					 

						

						

						

						
					
					<p><b>4</b>. Once you have registered, copy and past the created application credentials into this setup page.</p>  
				 
		   </div>
		</div>   
	</div> 


	<br style="clear:both;"> 
	<br>
	<h4>LinkedIn</h4> 
	<div> 
		<div class="cfg">
		   <div class="cgfparams">
			  <ul>
				 <li><label>LinkedIn Adapter Satus</label>
					<select name="LINKEDIN_ADAPTER_STATUS">
						<option value="true" selected="selected">Enabled</option>
						<option value="false">Disabled</option>
					</select>
				</li>
										
						<li><label>Application Key</label><input type="text" name="LINKEDIN_APPLICATION_KEY" value="" class="inputgnrc"></li>
						 
					<li><label>Application Secret</label><input type="text" name="LINKEDIN_APPLICATION_SECRET" value="" class="inputgnrc"></li>
							  </ul> 
		   </div>
		   <div class="cgftip">
				 
					<p><b>1</b>. Go to <a target="_blanck" href="https://www.linkedin.com/secure/developer">https://www.linkedin.com/secure/developer</a> and <b>create a new application</b>.</p>

					<p><b>2</b>. Fill out any required fields such as the application name and description.</p>

						

					 

					 

					 

						

											<p><b>3</b>. Put your website domain in the <b>Integration URL</b> field. It should match with the current hostname <em style="color:#CB4B16;">impressto.com</em>.</p> 
						<p><b>4</b>. Set the <b>Application Type</b> to <em style="color:#CB4B16;">Web Application</em>.</p> 
						

						

						
					
					<p><b>5</b>. Once you have registered, copy and past the created application credentials into this setup page.</p>  
				 
		   </div>
		</div>   
	</div> 
	<br style="clear:both;"> 
	<br>
	<h4>OpenID</h4> 
	<div> 
		<div class="cfg">
		   <div class="cgfparams">
			  <ul>
				 <li><label>OpenID Adapter Satus</label>
					<select name="OPENID_ADAPTER_STATUS">
						<option value="true" selected="selected">Enabled</option>
						<option value="false">Disabled</option>
					</select>
				</li>
							  </ul> 
		   </div>
		   <div class="cgftip">
					
					<p>No registration required for OpenID based providers</p> 
				 
		   </div>
		</div>   
	</div> 
	<br style="clear:both;"> 
	<br>
	<br> 
	<div style="text-align:center">
	
		<input type="submit" value="Setup HybridAuth" class="inputsave"> 
	</div> 
</form>
			
			</div>
						
			
				
			<?php foreach($lang_avail AS $langcode=>$langname){ ?>
											

			<div id="<?=$langcode?>_settings">
	
				
				<div class="control-group ">
					<label for="site_title_<?=$langcode?>" class="control-label">Site Title (<?php echo ucwords($langname); ?>)</label>
					<div class="controls">
					<input style="width:400px" type="text" id="site_title_<?=$langcode?>" name="site_title_<?=$langcode?>" value="<?php echo isset($option_data['site_title_' . $langcode]) ? $option_data['site_title_' . $langcode] : ""; ?>" />
					</div>
				</div>
				
				<div class="control-group ">
					<label for="homepage_<?=$langcode?>_id" class="control-label">Homepage (<?php echo ucwords($langname); ?>)</label>
					<div class="controls">
					<?php 

					$data = array(
					"language" =>$langcode,
					'name'        => "homepage_" . $langcode . "_id",
					'id'          => "homepage_" . $langcode . "_id",
					'type'          => 'select',
					'showlabels'          => false,
					'width'          => 300,
					'label'          => "",
					'onchange' => "",
					'use_ids' => TRUE,
					'value'       => ( isset($option_data['homepage_' . $langcode . '_id']) ? $option_data['homepage_' . $langcode . '_id'] : "" )
					);

					echo get_ps_page_slector($data); 

					?>
					</div>
				</div>
				
		
				<div class="meta_settings">
				
					<div class="control-group ">
						<label for="site_keywords_<?=$langcode?>" class="control-label fullwidth">Meta Keywords (<?php echo ucwords($langname); ?>)</label>
						<div class="clearfix"></div>
						<div class="controls fullwidth">
						<textarea id="site_keywords_<?=$langcode?>" name="site_keywords_<?=$langcode?>"><?php echo isset($option_data['site_keywords_'.$langcode]) ? $option_data['site_keywords_' . $langcode] : ""; ?></textarea>
						</div>
					</div>
					
					<div class="control-group ">
						<label for="site_description_<?=$langcode?>" class="control-label fullwidth">Meta Description (<?php echo ucwords($langname); ?>)</label>
						<div class="clearfix"></div>
						<div class="controls fullwidth">
						<textarea id="site_description_<?=$langcode?>" name="site_description_<?=$langcode?>"><?php echo isset($option_data['site_description_' . $langcode]) ? $option_data['site_description_' . $langcode] : ""; ?></textarea>
						</div>
					</div>
				</div><!-- [END] .meta_settings -->
				
			</div><!-- [END] #<?=$langname?>_settings -->

			


			<?php } ?>
				
				
		
			
			

		</div><!-- [END] #cruTabs -->
	</form>
</div><!-- [END] .settings_page -->
</div><!-- [END] .admin-box -->