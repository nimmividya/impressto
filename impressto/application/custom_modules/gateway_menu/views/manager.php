<?php
/*
@Name: Manager
@Type: PHP
@Filename: manager.php
@Description: 
@Author: bitHeads
@Projectnum: 
@Version: 1.0
@Status: development
@Date: 2013/04/26
*/
?>


<?php echo $infobar; ?>

<h2>Gateway Menu</h2>


<div style="clear:both"></div>


<form id="gateway_menu_management_form">


<div style="float:left;"><?=$template_selector?></div>

<div style="float:left; margin-left:10px; margin-top:20px;">
	<button id="gateway_menu_save_button" class="btn btn-success" type="button" onClick="ps_gateway_menu_manager.save_settings()"><i class="icon-white icon-ok"></i> Save Settings</button>
</div>

<button class="btn">Add Menu Item</button>

<div>

<label>Name
<input type="text" name="gmenu_item_name" id="gmenu_item_name" value="" />
</label>

<label>Icon
<input type="text" name="gmenu_item_name" id="gmenu_item_name" value="" />
</label>


<label>URL</label>
<input class="span4" type="text" placeholder="link url…">




<!-- this list has to come from the user groups table -->

<label>Group Assignments</label>

<select class="span4" multiple="multiple">
       <option>1</option>
       <option>2</option>
       <option>3</option>
       <option>4</option>
       <option>5</option>
</select>
											


<button class="btn">Save</button>






</div>



List bilder


<div style="clear:both"></div>


</form>