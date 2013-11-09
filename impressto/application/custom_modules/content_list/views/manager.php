<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Content List Manager
@Type: PHP
@Filename: manager.php
@Description: manage a content lists
@Author: peterdrinnan
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-05-15
*/
?>

<script type="text/javascript">

ps_base.wysiwyg_editor = '<?=$this->config->item('wysiwyg_editor')?>';

</script>


<?php echo $infobar; ?>


<h2>Content Lists</h2>

<div style="float:right; margin-bottom:10px;">
<button id="new_list_button" class="btn btn-success" type="button" onClick="pscontentlistmanager.create_new_list()"><i class="icon-white icon-star"></i> New Content List</button>
</div>

<div style="clear:both"></div>

<div id="contentlist_edit_div" style="display:none">

<form id="contentlist_edit_form">

<input type="hidden" id="contentlist_id" name="contentlist_id" />
<input type="hidden" id="clone_id" name="clone_id" />


<div style="float:left">

<label style="display:block;text-align:left;" for="content_list_name" class="qfield_select_label_vertical">List Name</label>
<input type="text" id="content_list_name" name="content_list_name" style="width:200px" onChange="pscontentlistmanager.check_existing_widget_name(this)" />
</div>
<div style="float:left; margin-left:10px; width:200px">&nbsp;
<div id="edit_list_noticebox" class="alert" style="display:none;"></div>
</div>

<div style="float:left; margin-left:10px;"><?=$template_selector?></div>




<div id="content_list_cancel_save_buttons_div" style="float:right; margin-top:20px; margin-bottom:10px;">
	<button id="content_list_cancel_button" class="btn" type="button" onClick="pscontentlistmanager.cancel_save_contentlist()"> Cancel</button>
	<button id="content_list_save_button" class="btn btn-success" type="button" onClick="pscontentlistmanager.save_contentlist()"><i class="icon-white icon-ok"></i> Save List</button>
</div>

<div style="clear:both"></div>


</form>


<div style="clear:both"></div>

				
<div id="content_list_items_wrapper">

<div style="float:left"><h4>List Items</h4></div>


<div style="float:right"><button id="edit_list_item_button" class="btn" type="button" onClick="pscontentlistmanager.edit_list_item('')"><i class="icon-plus"></i> New List Item</button></div>

<div style="clear:both"></div>


<div id="list_item_edit_div" style="display:none">


	<form name="content_list_item_edit_form" id="content_list_item_edit_form">
	
	<input type="hidden" id="content_list_item_id" name="content_list_item_id" />
	
	<input type="hidden" id="content_list_item_widget_id" name="content_list_item_widget_id" />
	


	<div class="tabbable tabbable-bordered">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#item_english">English</a></li>
				<li class=""><a data-toggle="tab" href="#item_french">French</a></li>
			</ul>
			

		
			<div class="tab-content">
			
			
			
			<div class="clearfix"></div>
			
			
			<div id="item_english" class="tab-pane active">
		
				<div style="float:right; margin-top:20px">
					<button class="btn" type="button" onClick="pscontentlistmanager.cancel_save_list_item()"> Cancel</button>
					<button class="btn btn-success" type="button" onClick="pscontentlistmanager.save_list_item()"><i class="icon-white icon-ok"></i> Save List Item</button>
				</div>
			
					<label for="content_item_title_en">Label (EN)</label>
					<input type="text" name="content_item_title_en" id="content_item_title_en" />
					
					<br />
					<label for="list_item_content_en">Content (EN)</label>
					<?php 
					
					$content = "";
					if(isset($row->content_en)) $content = $row->content_en;
					
					$config = array(
				
						"content" => $content,
						"name" => "ck_list_item_content_en", 
						"height" => 500, 
						"toolbar" => "Full" 		
						
					);
						
					echo $this->edittools->insert_wysiwyg($config);
				
			
					?>	
					<input type="hidden" id="list_item_content_en" name="list_item_content_en" />
					
		
			</div>
			<div id="item_french" class="tab-pane">
		
				<div style="float:right; margin-top:20px">
				<button class="btn" type="button" onClick="pscontentlistmanager.cancel_save_list_item()"> Cancel</button>
				<button class="btn btn-success" type="button" onClick="pscontentlistmanager.save_list_item()"><i class="icon-white icon-ok"></i> Save List Item</button>
				</div>
				
				
					<label for="content_item_title_fr">Label (FR)</label>
					<input type="text" name="content_item_title_fr" id="content_item_title_fr" />
					<br />
					<label for="list_item_content_fr">Content (FR)</label>
					<?php 
					
					$content = "";
					if(isset($row->content_fr)) $content = $row->content_fr;
					
					
					$config = array(
				
						"content" => $content,
						"name" => "ck_list_item_content_fr", 
						"height" => 500, 
						"toolbar" => "Full" 		
						
					);
						
					echo $this->edittools->insert_wysiwyg($config);
					
				
					?>					
					
					<input type="hidden" id="list_item_content_fr" name="list_item_content_fr" />
					
			</div>
		</div>
	</div>
	
	</form>
	
	
</div>

	
	
<div id="content_list_items_div">



</div>
		
		

			


</div>



<div style="clear:both"></div>
		
		


</div>



<div id="content_list_list_div">

<?php echo $widgetlist?>

</div>



