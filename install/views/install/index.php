<?php echo lang('in_intro'); ?>

<?php if (isset($startup_errors) && !empty($startup_errors)) :?>

	<h2>Install Run Errors</h2>
	
	<?php echo $startup_errors; ?>
	
	<p style="text-align: right; margin-top: 3em;"><?php echo anchor('/', 'Reload Page'); ?></p>

<?php else : ?>

	<h2><?php echo lang('in_db_settings'); ?></h2>
	
	<?php echo lang('in_db_settings_note'); ?>
	
	
	<?php if (validation_errors()) : ?>
	<div class="notification information">
		<p><?php echo validation_errors(); ?></p>
	</div>
	<?php endif; ?>
	
	<?php if (isset($dbase_error)) : ?>
	<div class="notification error">
		<p><?php echo $dbase_error; ?></p>
	</div>
	<?php endif; ?>
	
	<!-- peterdrinnan - we need to use index.php because the routing won't work wothout it -->
	<form action="/install/index.php" method="post" accept-charset="utf-8" id="db-form">	
		<div>
			<label for="environment"><?php echo lang('in_environment'); ?></label>
			<select name="environment">
				<option value="development" <?php echo set_select('environment', 'development', TRUE); ?>>Development</option>
				<option value="testing" <?php echo set_select('environment', 'testing'); ?>>Testing</option>
				<option value="production" <?php echo set_select('environment', 'production'); ?>>Production</option>
			</select>
			
			<div> 
				NOTE: Remember to change your environment in init.php. 
				Also, if you are running a local server on windows, try to use 127.0.0.1 rather than localhost as it will speed up your page reloads.

			</div>
			
		</div>
		
		<div>
			<label for="hostname"><?php echo lang('in_host'); ?></label>
			<input type="text" name="hostname" value="<?php echo set_value('hostname', '127.0.0.1') ?>" />
		</div>
		
		<div>
			<label for="username"><?php echo lang('bf_username'); ?></label>
			<input type="text" name="username" value="<?php echo set_value('username', 'root') ?>" />
		</div>
		
		<div>
			<label for="password"><?php echo lang('bf_password'); ?></label>
			<input type="password" name="password" id="password" value="" />
		</div>
		
		<div>
			<label for="database"><?php echo lang('in_database'); ?></label>
			<input type="text" name="database" id="database" value="<?php echo set_value('database', 'local_sitename') ?>" />
		</div>
		
		<div>
			<label for="db_prefix"><?php echo lang('in_prefix'); ?></label>
			<input type="text" name="db_prefix" value="<?php echo set_value('db_prefix', 'ps_'); ?>" />
		</div>
		
		<div class="submits">
			<input type="submit" name="submit" id="submit" value="<?php echo lang('in_test_db'); ?>" />
		</div>
	
	<?php echo form_close(); ?>
<?php endif; ?>