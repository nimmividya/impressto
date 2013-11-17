<?php echo lang('in_intro'); ?>

<?php if (isset($startup_errors) && !empty($startup_errors)) :?>

	<h2><?php echo lang('in_not_writeable_heading'); ?></h2>
	
	<?php echo $startup_errors; ?>
	
	<p style="text-align: right; margin-top: 3em;"><?php echo anchor('install', 'Reload Page'); ?></p>

<?php else : ?>

	<?php if (isset($curl_error) && !empty($curl_error)) :?>
	
	<?php echo lang('in_curl_disabled'); ?>
	
	<?php endif; ?>
    

	<?php echo lang('in_account_heading'); ?>
	  
	
	<?php if (validation_errors()) : ?>
	<div class="notification information">
		<p><?php echo validation_errors(); ?></p>
	</div>
	<?php endif; ?>
	
	<!-- peterdrinnan - we need to use index.php because the routing won't work wothout it -->
	<form action="/install/index.php/install/account/" method="post" accept-charset="utf-8" id="db-form">	
		
		<div>
			<label for="site_title"><?php echo lang('in_site_title'); ?></label>
			<input type="text" name="site_title" id="site_title" placeholder="A Great New App" value="<?php echo set_value('site_title', config_item('site.title')) ?>" />
		</div>

		
		<div>
			<label for="site_url"><?php echo lang('in_site_url'); ?></label>
			<input type="text" name="site_url" id="site_url" value="<?php echo (set_value('site_url') != "") ? set_value('site_url') : "http://" .  getenv('SERVER_NAME'); ?>" />
		</div>
		
		<div>
			<label for="site_projectnum"><?php echo lang('in_projectnumber'); ?></label>
			<input type="text" name="site_projectnum" id="site_projectnum" value="<?php echo set_value('site_projectnum') ?>" />
		</div>
		
		
		<div>
			<label for="site_verndorname"><?php echo lang('in_verndorname'); ?></label>
			<input type="text" name="site_verndorname" id="site_verndorname" value="<?php echo set_value('site_verndorname') ?>" />
		</div>
		
		
		<div>
			<label for="site_verndorname"><?php echo lang('in_vendorurl'); ?></label>
			<input type="text" name="site_vendorurl" id="site_vendorurl" value="<?php echo set_value('site_vendorurl') ?>" />
		</div>
		
		
		<div>
			<label for="site_languages"><?php echo lang('in_languages'); ?></label>
			
			
			<?php 
			
			if(isset($_POST['site_languages'])) $site_languages = $_POST['site_languages'];
			else $site_languages = array();
			?>
			
			<select id="site_languages" name="site_languages[]" multiple size="4"> 
			<option value="en" <?php if(in_array("en",$site_languages)) echo "selected"; ?>>English</option>
			<option value="fr" <?php if(in_array("fr",$site_languages)) echo "selected"; ?>>French</option>
			<option value="zh" <?php if(in_array("zh",$site_languages)) echo "selected"; ?>>Mandarin</option>
			<option value="es" <?php if(in_array("es",$site_languages)) echo "selected"; ?>>Spanish</option>
			</select>

			
		</div>
		
		
		<br />
	
		
		<div>
			<label for="username"><?php echo lang('bf_username'); ?></label>
			<input type="text" name="username" id="username" value="<?php echo set_value('username') ?>" />
		</div>
		
		<br />
		
		<div>
			<label for="password"><?php echo lang('bf_password'); ?></label>
			<input type="password" name="password" id="password" value="" />
			<p class="small"><?php echo lang('in_password_note'); ?></p>
		</div>
		
		<div>
			<label for="pass_confirm"><?php echo lang('in_password_again'); ?></label>
			<input type="password" name="pass_confirm" id="pass_confirm" value="" />
		</div>
		
		<br/>
		
		<div>
			<label for="email"><?php echo lang('in_email'); ?></label>
			<input type="email" name="email" id="email" placeholder="webmaster@yoursite.com" value="<?php echo set_value('email') ?>" />
			<p class="small"><?php echo lang('in_email_note'); ?></p>
		</div>
		
		<div class="submits">
			<input type="submit" name="submit" id="submit" value="<?php echo lang('in_install_button'); ?>" />
		</div>
	
	<?php echo form_close(); ?>
<?php endif; ?>