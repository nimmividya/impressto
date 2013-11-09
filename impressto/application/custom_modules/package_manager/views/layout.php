<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Module Manager
@Type: PHP
@Filename: layout.php
@Description: manage modules and create new ones
@Author: peterdrinnan
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-08-15
*/
?>

<div class="admin-box">
<h3>Installer Package Manager</h3>


<?php


if(!$curl_enabled) echo "CURL not enabled";

?>
<div style="float:right; margin:14px 2px 10px;">

	<button type="button" onclick="ps_module_manager.new_module_form()" class="btn btn-inverse"><i class="splashy-box_new"></i> Add Package</button>
</div>


<div class="clearfix" style="margin-bottom"></div>



<div id="module_table_div">

<?php echo $modulestable; ?>
</div>

</div>



<div id="new_package_dialog" title="New Package" style="display:none">

<p>
Add a new package to the database. You can add new versions later.
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

<div style="float:right; margin-top:12px;">
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
<label for="new_module_type">Module Type</label>
selector with core/custom/
</div>

<br />
<div style="float:left">
<label for="new_module_author">Author</label>
<input type="text" name="new_module_author" id="new_module_author" style="width:180px" />
</div>
<br />


<br />

<div style="float:left">
<label for="new_module_name">Short Description</label>
<input type="text" name="new_module_description" id="new_module_description" style="width:300px" />
</div>


<br />

<div style="float:left">
<label for="new_module_version">Version</label>
<input type="text" name="new_module_version" id="new_module_version" style="width:50px" />
</div>


<br />

<div style="float:left">
<label for="min_core_version">Min Core Version</label>
<input type="text" name="min_core_version" id="min_core_version" style="width:50px" />
</div>


<br />

<div style="float:left">
<label for="max_core_version">Max Core Version</label>
<input type="text" name="max_core_version" id="max_core_version" style="width:50px" />
</div>

<br />
<div style="float:left; margin-left:30px;">
<label for="new_module_updated">Updated</label>
<input type="text" name="new_module_updated" id="new_module_updated" style="width:80px" />
</div>
<br />


<div class="clearfix"></div>
<br />

</form>


</div>







