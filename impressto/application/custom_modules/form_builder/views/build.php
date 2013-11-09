<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Contact Form Manager
@Type: PHP
@Filename: manager.php
@Description: Form field management interface
@Author: peterdrinnan
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-05-15
*/
?>

<?php

$modasseturl = ASSETURL . PROJECTNAME . "/default/custom_modules/form_builder/";


?>

<script type="text/javascript">

ps_base.wysiwyg_editor = '<?=$this->config->item('wysiwyg_editor')?>';

</script>



<div class="admin-box">

<h3>Contact Form</h3>

<?php echo $infobar; ?>
			
<?php

$request_uri = getenv("REQUEST_URI");

?>





<div id="crudTabs" style="display: none;">

		<ul>
			<li><a href="<?=$request_uri?>#form_page"><img src="<?=$modasseturl?>images/page.png" /> Form Page</a></li>
			<li><a href="<?=$request_uri?>#field_manager"><img src="<?=$modasseturl?>images/pencil-ruler.png" /> Fields</a></li>
			<li><a href="<?=$request_uri?>#form_settings"><img src="<?=$modasseturl?>images/gear.png" /> Settings</a></li>

			
			
		</ul>
		

		
		

		
			<form id="settings_box" method="post" >
				<input type="hidden" name="settings_hidden" value="1">
				<input type="hidden" id="form_id" name="form_id" value="<?=$form_id?>">
				<input type="hidden" id="fbld_form_id" value="<?=$form_id?>">
				
		
		<div id="form_page">
		
			<div style="float:right"><button type="button" class="btn btn-success" onclick="ps_formbuilder_manager.save_settings()"><i class="icon-white icon-ok"></i>  Save</button></div>
			
			<div style="clear:both; height:20px;"></div>
					
				
			<?php

			$content = "";

			$content = isset($settings['content']) ? $settings['content'] : "";
					
			$config = array(
			
				"content" => $content,
				"name" => "form_content", 
				"height" => 200, 
				"toolbar" => "Full" 		
						
			);
						
			echo $this->edittools->insert_wysiwyg($config);

		?>
			
		</div>
		
		<div id="form_settings">
			
		
			<div style="float:right"><button type="button" class="btn btn-success" onclick="ps_formbuilder_manager.save_settings()"><i class="icon-white icon-ok"></i>  Save</button></div>

			
			<div style="clear:both"></div>
				
				<table>
				
					<tr>

					<td>Template:</td><td><?=$template_selector?></td>
							
					</tr>
						
				<tr>

						<td>Recipient Email:</td><td><input type="text" name="email_account" value="<?php echo $settings['email_account'];?>"></td>
							
						</tr>
						<tr><td>Button Text:</td><td><input type="text" name="button_value" value="<?php echo $settings['button_value'];?>"></td></tr>
						
						<tr>
						<td>Enable CAPTCHA:</td>
	
						
						<td>
						
							<select name="captcha" onchange="ps_formbuilder_manager.select_captcha(this)">
							<option value="" <?php if ($settings['captcha'] == ""){ echo ' selected';}?>>None</option>
							<option value="captcha" <?php if ($settings['captcha'] == "captcha"){ echo ' selected';}?>>Standard Captcha</option>
							<option value="visualcaptcha" <?php if ($settings['captcha'] == "visualcaptcha"){ echo ' selected';}?>>Visual Captcha</option>
							</select>
							

							
		
						</td>
						
						</tr>
						
						<tr id="visualcaptcha_settings" <?php 
						
							if ($settings['captcha'] != "visualcaptcha") echo " style=\"display:none\" "; 
							
						?> class="captcha_settings">
												
						<td>CAPTCHA THEME:</td>
													
						<td>
								
							<select name="captcha_theme">
								<option value="" <?php if ($settings['captcha_theme'] == ""){ echo ' selected';}?>>None</option>
											
							<?php
							
								foreach($visualcaptcha_themes AS $theme){
								
									echo "<option value=\"" . strtolower($theme) . "\"";
									if ($settings['captcha_theme'] == strtolower($theme)) echo " selected "; 
									echo ">" . ucwords($theme)  . "</option>\n";
																	
																
								}
							
							
							?>
							
							</select>
											
						</td>
						
						</tr>
						
						<tr><td>Default Sender:</td><td><input type="text" name="from_a" value="<?php echo $settings['from_a'];?>"></td></tr>			
						
						

			
						</table>
		
		<div class="clearfix"></div>
		

		
	Success Message:<textarea name="success_message" id="success_message"><?php echo $settings['success_message'];?></textarea>
	
<div class="clearfix"></div>
							
	Javascript:<textarea name="form_javascript" id="form_javascript" class="text cornered"><?php echo $settings['javascript'];?></textarea>
	

<div class="clearfix"></div>
				

						

						
				
		
		</div>

		
		</form>
							
		
				
		<div id="field_manager">

				<div id="field_buttons_div" style="float:right">
				
					<div style="float:right">
						<button type="button" onclick="ps_formbuilder_manager.edit_field('')" id="btn_new" class="btn btn-success"><i class="icon-white icon-plus"></i> New Field</button>
					</div>
				
	
				</div>
				
				
				<div style="height:20px;" class="clearfix"></div>
				
				
				
			<div id="form_fields_div">


				
				<?=$fieldlist?>

			</div>		
		

				
			<div id="field_edit_div" style="display:none"></div>
				
		</div>
		

		

</div>
	
<br />
					
</div>
