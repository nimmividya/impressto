<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="wrapper">


	<div id="header">
		<div class="logo">
			<a href="<?php echo base_url(); ?>" title="PageShaper">
				<img src="<?php echo ASSETURL; ?>/<?php echo PROJECTNAME; ?>/default/core/images/logo.gif" alt="Pageshaper Logo" />
			</a>
		</div><!-- [END] .logo -->
		<?php
			if(isset($utilitynav)){
				echo $utilitynav; 
			}
		?>
	</div>
   	<div id="wrapper1"></div>
  	<div id="wrapper2">
		<?php
			if(isset($leftnav)){
				echo $leftnav; 
			}
		?>
        <div id="main_content">