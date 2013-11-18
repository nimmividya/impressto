<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Module Manager
@Type: PHP
@Filename: layout.php
@Description: manage modules and create new ones
@Author: Nimmitha Vidyathilaka
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-08-15
*/
?>

<div class="admin-box">
<h3><i class="icon-th"></i> Module Manager</h3>
<?php echo $infobar; ?>


<?php


if(!$curl_enabled){ ?>

	<div class="alert alert-error">
	<i class="icon-warning-sign"></i> <strong>Warning!</strong> cURL is not enabled on your server. cURL is required for automatic package updates. Please contact your server administrator.		
	</div>
	
<?php } ?>



<div style="float:right; margin:14px 2px 10px;">

	<button type="button" onclick="ps_module_manager.new_module_form()" class="btn btn-inverse"><i class="splashy-box_new"></i> Create Module</button>
	<button type="button" onclick="ps_module_manager.install_module_form()" class="btn btn-inverse"><i class="splashy-box_add"></i> Install Module</button>
</div>


<div class="clearfix" style="margin-bottom"></div>



<div id="module_table_div">
<?php echo $modulestable; ?>
</div>

</div>



<div id="permissions_dialog" title="Permissions"></div>





<div id="install_module_dialog" title="Install Module" style="display:none">

<br />

<div class="alert alert-info">Upload and install a module using a <a href="http://central.bitheads.ca/en/modules/">BitHeads Central Installer Package</a>.</div>

<div class="alert alert-error" id="install_module_dialog_message" style="display:none"></div>
	
<div id="install_module_info_div" style="display:none">

<strong>Name: </strong> <span id="install_module_info_name"></span><br />
<strong>Type: </strong> <span id="install_module_info_type"></span><br />
<strong>Description: </strong> <span id="install_module_info_description"></span><br />
<strong>Author: </strong> <span id="install_module_info_author"></span><br />
<strong>Version: </strong> <span id="install_module_info_version"></span><br />
<strong>Date: </strong> <span id="install_module_info_date"></span><br />

<input type="hidden" id="installmod_unpackfolder" value="" />
<input type="hidden" id="installmod_type" value="" />
<input type="hidden" id="installmod_name" value="" />

<br />
<div style="float:right">
<a class="btn" id="complete_install_btn" onclick="ps_module_manager.install_module();">Complete the Installation</a>
</div>

</div>

	
<form id="install_module_form" name="form" action="" method="POST" enctype="multipart/form-data">	

<br />


				<div style="float:left; margin-top:10px;">
									
							
							<label for="fileToUpload" style="margin: 0 0 5px 0;display: block;font-size: 14px;">Please select a file and click Upload button</label>

							<input name="fileToUpload" id="fileToUpload" type="file" style="display:none" />
							<div class="input-append">
								<input id="module_file" class="input-large" type="text" style="width:150px">
								<a class="btn" onclick="$('input[id=fileToUpload]').click();">Browse</a>
								<a class="btn" onclick="ps_module_manager.ajaxFileUpload();">Upload</a>
								
							</div>

							<img id="loading" style="width:24px; height:24px;" src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/images/ajax-loader.gif" style="display:none;">

			
									
							</div>
							
							


<div class="clearfix"></div>
<br />

</form>


</div>



<div id="new_module_dialog" title="New Module Builder" style="display:none">

<p>
This tool creates the framework for a fully functional module.
</p>
<br />
<div class="alert alert-info">
<p>NOTE: If using a docket number, ensure it is the docket number for this website or the new module will not be accessible. 
</p>
<p>
If you leave the docket blank, the module
will be created in the /applications/custom_modules/ folder.
</p>
</div>

<div class="alert alert-error" id="new_module_dialog_message" style="display:none"></div>
	
	
<form id="new_module_form">




<div style="float:right; margin-top:36px;">
<button type="button" onclick="ps_module_manager.create_new_module()" class="btn btn-success"><i class="icon-ok icon-white"></i> Create</button>
<button type="button" onclick="ps_module_manager.cancel_new_module()" class="btn">Cancel</button>

</div>


<br />

<div style="float:left">
<label for="new_module_name">Module Name</label>
<input type="text" name="new_module_name" id="new_module_name" style="width:140px" />
</div>

<br />

<div style="float:left">
<label for="new_module_name">Short Description</label>
<input type="text" name="new_module_description" id="new_module_description" style="width:300px" />
</div>

<br />
<div style="float:left">
<label for="new_module_author">Author</label>
<input type="text" name="new_module_author" id="new_module_author" style="width:180px" />
</div>
<br />

<br />
<div style="float:left; margin-left:10px;">
<label for="new_module_docket">Docket</label>
<input type="text" name="new_module_docket" id="new_module_docket" style="width:80px" />
</div>
<br />


<div class="clearfix"></div>
<br />

</form>


</div>







