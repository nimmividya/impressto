<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: News Editor
@Type: PHP
@Filename: edit.php
@Description: edit news entries
@Author: peterdrinnan
@Projectnum: 1001 (default)
@Version: 1.5
@Status: complete
@Date: 2012-10-09
*/
?>
<?php

$lang_avail = $this->config->item('lang_avail');  

?>


<script type="text/javascript">

psnewsmanager.wysiwyg_editor = '<?=$this->config->item('wysiwyg_editor')?>';
ps_base.wysiwyg_editor = '<?=$this->config->item('wysiwyg_editor')?>';

<?php 

$lang_avail = $this->config->item('lang_avail');

$lang_avail_values = array();
	
foreach($lang_avail AS $langcode=>$language){ 

	$lang_avail_values[] = "{\"lang\":\"{$langcode}\"}";
	
}
				
?>

ps_base.lang_avail =  [<?php echo implode(",",$lang_avail_values); ?>];



$(function() {

	$.validator.setDefaults({
		ignore: '' // WYSIWYG hack. This tells the validator to not ignore hidden fields (set by WYSIWYG editors).
	});


	$('#newsForm').validate({
	
	    rules: {
			
	      newstitle_en : { // for now we will only make the english fields required
	        minlength: 5,
	        required: true
	      },
 		  
		  newsshortdescription_en : { // if there is no main article, insist there is at least a short description.
			
			required: function(element) {
			
				if($('#xFilePath').val() != "") return false;
				else return $("#newscontent_en").val() == '';
			}
		 }  
  
  
		  		  		  
	    },
	    highlight: function(label) {
	    	$(label).closest('.control-group').addClass('error');
	    },
	    success: function(label) {
	    	label
	    		.text('OK!').addClass('valid')
	    		.closest('.control-group').addClass('success');
	    }
	  });
	  
	  
});


				

</script>

<?php

$request_uri = getenv("REQUEST_URI");

?>

<div class="admin-box">

<h3>Edit News Item</h3>

<form id="newsForm" name="newsForm" method="post" action="/admin_news/save/<?=$newsdata['news_id']?>">

<input type="hidden" id="news_id" name="news_id" value="<?=$newsdata['news_id']?>">

		<?php 
				
		$lang_avail = $this->config->item('lang_avail');
		
		foreach($lang_avail AS $langcode=>$language){ ?>

			<input type="hidden" id="content_<?=$langcode?>" name="content_<?=$langcode?>" value="" />
				
		<?php } ?>
		


	<div id="crudTabs" style="display: none;">
		<ul>
		<?php
		
		$lang_avail = $this->config->item('lang_avail');
		
		foreach($lang_avail AS $langcode=>$language){ ?>
				
				
			<li><a href="<?=$request_uri?>#<?=$language?>_news"><?php echo ucwords($language); ?></a></li>
				
				
		<?php } ?>
				
			<li><a href="<?=$request_uri?>#newsitem_settings">Settings</a></li>
		</ul>
		<div class="footNav clearfix">
			<ul>
			<?php if($newsdata['news_id'] != "") { ?>
			
				<li><button class="btn btn-default" type="button" id="quicksave" onclick="ps_newsmanager.quicksave()"><i class="icon-white icon-ok-sign"></i> Quick Save</button></li>
				
			<?php } ?>
				<li><button class="btn btn-success" type="button" onclick="ps_newsmanager.publish()" name="submit"><i class="icon-white icon-ok"></i> Publish</button></li>
				<li><a class="btn btn-danger" href="/admin_news/">Cancel</a></li>
			</ul>
		</div>
		
		<?php
		
		foreach($lang_avail AS $langcode=>$language){ ?>
				
				
		<div id="<?=$language?>_news">
		
		
		
			<div class="control-group">
			    <label class="control-label" for="newstitle_<?=$langcode?>">Title</label>
				<div class="controls">
				<input type="text" id="newstitle_<?=$langcode?>" name="newstitle_<?=$langcode?>" maxlength="100" size="50" value="<?=$newsdata['newstitle_' . $langcode]?>" />
				</div>
			</div>
			
	
		
				<div>
				
				<label for="blog_tags_<?=$langcode?>">Tags</label>
				
			
			
				
				<?php 
				// No need to register events because each module event class will auto register its own events
				// you just need to  make sure the events library has been loaded and trigger the event
				// also make sure the admin widget plugin is loaded
		
				$tags = Events::trigger('edit_content', array("lang"=>$langcode,"content_module"=>"admin_news","content_id"=>$newsdata['news_id']), 'array');
		
				$adminwidget_config = array(
		
				"lang"=>$langcode,
				"content_module" => "admin_news",
				"content_id" => $newsdata['news_id'],
				"field_name" => "news_tags_".$langcode,
				"tags" => $tags[0],
			
				);
	
				Admin_Widget::run('tags/tagger', $adminwidget_config ); 
			
				?>
	
				
		
		
			
			</div>
			
			<div style="clear:both"></div>
			
			
				<label for="xFilePath">External link or pdf?</label>
				<input type="text" id="xFilePath_<?=$langcode?>" name="newslink_<?=$langcode?>" id="newslink_<?=$langcode?>" value="<?=$newsdata['newslink_'.$langcode]?>" size="30" style="width: 353px; margin: 0 9px 0 0;" />
				<button class="btn btn-default" type="button" id="CO_externalLink_button_<?=$langcode?>">Browse Server</button>
				
				<script type="text/javascript"> 
					$(document).ready(function() {
						$('#CO_externalLink_button_<?=$langcode?>').popupWindow({ 
						
							windowURL: '/file_browser/?ajpx_targetfield=xFilePath_<?=$langcode?>', 
							windowName: 'elfinder', 
							height: 500, 
							width: 800, 
							centerBrowser: 1
						
						});
					});
				</script>

			
			
			<div>
				<h2>Short Description</h2>
				<?php
		
				$config = array(
				
					"content" => $newsdata['newsshortdescription_' . $langcode],
					"name" => "newsshortdescription_" . $langcode, 
					"height" => 100, 
					"toolbar" => "Basic" 		
				);
						
				echo $this->edittools->insert_wysiwyg($config);
		
				?>
			</div>
			
			
			
			<div>
				<h2>Full Article</h2>
				<?php
		
				$config = array(
				
					"content" => $newsdata['newscontent_' . $langcode],
					"name" => "newscontent_" . $langcode, 
					"height" => 500, 
					"toolbar" => "Full" 		
				);
						
				echo $this->edittools->insert_wysiwyg($config);
		
				?>
			</div>

		</div><!-- [END] #<?=$language?>_news -->
		
				
				
		<?php } ?>
		

		
		<div id="newsitem_settings">
			<div>
				<label for="newsactive">
					Article Active?
					<input type="checkbox" id="newsactive" name="newsactive" onchange="ps_newsmanager.toggle_searchfields(this);" value="1" <?php echo $newsdata['active'] == 1 ? "checked" : ""; ?> />
				</label>
			</div>
			
			
			
			
			<div id="search_fields_div" style="float:left; margin-left:20px; margin-top:5px; <?php if($newsdata['active'] != 1) echo "display:none;"; ?>">
								
			
				<div id="search_priority_div" style="float:left;">
					<img src="<?php echo ASSETURL . PROJECTNAME; ?>/default/core_modules/page_manager/img/spider.png" />
				</div>
			
				<div id="search_priority_div" style="float:left; margin-left:20px; margin-top:5px;">
					<label for="search_priority_val"><span id="field_height_label">Search Priority</span>: <span id="search_priority_display"><?=$search_priority?></span></label>
					<input style="width:40px;" type="hidden" id="search_priority_val" name="search_priority" value="<?=$search_priority?>" />
					<div class="clearfix"></div>
					<div style="float:left; width:120px" id="search_priority_slider"></div>
					<script>  ps_newsmanager.init_priority_slider('<?=$search_priority?>'); </script>
				</div>
			

				<div id="change_frequency_div" style="float:left; margin-left:20px; margin-top:5px;">
					<label for="change_frequency_val" style="width:200px"><span id="field_height_label">Reindex</span>: <span id="change_frequency_display"><?=$change_frequency_label?></span></label>
					<input style="width:40px;" type="hidden" id="change_frequency_val" name="change_frequency" value="<?=$change_frequency?>" />
					<div class="clearfix"></div>
					<div style="float:left; width:120px" id="change_frequency_slider"></div>
					<script>  ps_newsmanager.init_change_frequency_slider('<?=$change_frequency?>'); </script>
				</div>
			
			</div>
			
		
					

			<div class="clearfix"></div>
			
		
			
			<div>
				<label for="newsarchived">
					Archived Active?
					<input type="checkbox" id="newsarchived" name="newsarchived" value="1" <?php echo $newsdata['archived'] == 1 ? "checked" : ""; ?> />
				</label>
			</div>
			
			<div>
				<label for="opennewwindow">
					Opens new page?
					<input type="checkbox" id="opennewwindow" name="opennewwindow" value="1" <?php echo $newsdata['opennewwindow'] == 1 ? "checked" : ""; ?> />
				</label>
			</div>
			
			<div>
				<label>Publish Date</label>
				<input type="text" name="publishdate" id="publishdate" value="<?=$newsdata['published']?>" style="width:100px" maxlength="10" />
			</div>
			
			
			
		</div><!-- [END] .news_settings -->
	</div><!-- [END] #crudTabs -->
</form>

</div>
<script type="text/javascript" src="<?php echo base_url(); ?><?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/vendor/jquery.popupwindow.js"></script>