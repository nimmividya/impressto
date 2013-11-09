<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Blog Editor
@Type: PHP
@Filename: edit.php
@Description: edit blog entries
@Author: peterdrinnan
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-05-15
*/
?>
<?php

$lang_avail = $this->config->item('lang_avail');  

?>
<script type="text/javascript">

ps_base.wysiwyg_editor = '<?=$this->config->item('wysiwyg_editor')?>';


$(function() {

	$.validator.setDefaults({
		ignore: '' // WYSIWYG hack. This tells the validator to not ignore hidden fields (set by WYSIWYG editors).
	});


	$('#blogForm').validate({
	
	    rules: {
			
	      blogtitle_en : { // for now we will only make the english fields required
	        minlength: 5,
	        required: true
	      },
		  
	      author_en : {
	        minlength: 5,
	        required: true
	      },
		  
		  
		  blogshortdescription_en : { // if there is no main article, insist there is at least a short description.
			
			required: function(element) {
				return $("#blogcontent_en").val() == '';
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

<div class="admin-box">
<h3>Edit Blog Item</h3>

<br />
<form id="blogForm" name="blogForm" method="post" action="/admin_blog/save/<?=$blogdata['blog_id']?>">

<input type="hidden" id="blog_id" name="blog_id" value="<?=$blogdata['blog_id']?>">

<?php

$request_uri = getenv("REQUEST_URI");

?>

	<div id="crudTabs" style="display: none;">
		<ul>
		
		<?php
		

		
		foreach($lang_avail AS $langcode=>$language){ ?>
				
				
			<li><a href="<?=$request_uri?>#<?=$language?>_blog"><?php echo ucwords($language); ?></a></li>
				
				
		<?php } ?>
		<li><a href="<?=$request_uri?>#blog_settings">Settings</a></li>
					
		</ul>
		<div class="footNav clearfix">
			<ul>
			<?php if($blogdata['blog_id'] != "") { ?>
			
				<li><button class="btn btn-default" type="button" id="quicksave" onclick="ps_blogmanager.quicksave()"><i class="icon-white icon-ok-sign"></i> Quick Save</button></li>
				
				<li><button class="btn btn-success" type="button" onclick="ps_blogmanager.publish()" name="submit"><i class="icon-white icon-ok"></i> Publish</button></li>
				
			<?php }else{ ?>


				<li><button class="btn btn-default" type="button" onclick="ps_blogmanager.save_blog()" name="submit"><i class="icon-white icon-ok"></i> Save</button></li>
				<li><button class="btn btn-success" type="button" onclick="ps_blogmanager.publish()" name="submit"><i class="icon-white icon-ok"></i> Publish</button></li>

			<?php 	} ?>
			
				<li><a class="btn btn-danger" href="/admin_blog/">Cancel</a></li>
			</ul>
		</div>
		
		<?php
		
		foreach($lang_avail AS $langcode=>$language){ ?>
				
		<div id="<?=$language?>_blog">
		
			<div class="control-group">
			    <label class="control-label" for="blogtitle_<?=$langcode?>">Title</label>
				<div class="controls">
					<input type="text" id="blogtitle_<?=$langcode?>" name="blogtitle_<?=$langcode?>" size="300" maxlength="100" value="<?=$blogdata['blogtitle_'.$langcode]?>" />
				</div>
			</div>

			
			<div>
				<label for="blog_tags_<?=$langcode?>">Tags</label>
			
				
				<?php 
				// No need to register events because each module event class will auto register its own events
				// you just need to  make sure the events library has been loaded and trigger the event
				// also make sure the admin widget plugin is loaded
		
				$tags = Events::trigger('edit_content', array("lang"=>$langcode,"content_module"=>"admin_blog","content_id"=>$blogdata['blog_id']), 'array');
		
				$adminwidget_config = array(
		
				"lang"=>$langcode,
				"content_module" => "admin_blog",
				"content_id" => $blogdata['blog_id'],
				"field_name" => "blog_tags_".$langcode,
				"tags" => $tags[0],
			
				);
	
				Admin_Widget::run('tags/tagger', $adminwidget_config ); 
			
				?>
		
			
			</div>
			
	
			
			<div class="control-group">
			    <label class="control-label" for="author_<?=$langcode?>">Author</label>
				<div class="controls">
					<input type="text" id="author_<?=$langcode?>" name="author_<?=$langcode?>" style="width:200px" value="<?=$blogdata['author_' . $langcode]?>" />
				</div>
			</div>
			
			
			
			<div style="float:left">
				<label for="publish_date_<?=$langcode?>">Publish Date</label>
				<input type="text" id="publish_date_<?=$langcode?>" name="publish_date_<?=$langcode?>" style="width:80px" value="<?=$blogdata['publish_date_'.$langcode]?>" />
			</div>
			
	
			
			<div class="clearfix"></div>
			
			
			
			
			
			<div>
				<h2>Short Description</h2>
				<?php
									
					$content = "";
					if(isset($blogdata['blogshortdescription_'.$langcode])) $content = $blogdata['blogshortdescription_'.$langcode];
					
					$config = array(
				
						"content" => $content,
						"name" => "blogshortdescription_".$langcode, 
						"height" => 200, 
						"toolbar" => "Basic" 		
						
					);
						
					echo $this->edittools->insert_wysiwyg($config);
				

				?>
			</div>
			
			
			
			<div>
				<h2>Full Article</h2>
				<?php
				
					$content = "";
					if(isset($blogdata['blogcontent_'.$langcode])) $content = $blogdata['blogcontent_'.$langcode];
					
					$config = array(
				
						"content" => $content,
						"name" => "blogcontent_".$langcode, 
						"height" => 500, 
						"toolbar" => "Full" 		
						
					);
						
					echo $this->edittools->insert_wysiwyg($config);
				
				
				?>
			</div>
			
			
			<div class="clearfix"></div>
			

			
			
			<div id="featured_image_div">
		
			<h4>Featured Image</h4>
			
			<?php
			
				$featured_image = isset($blogdata['featured_image_'.$langcode]) ? $blogdata['featured_image_'.$langcode] : "";
			
			?>
			
			
			<input type="hidden" name="featured_image_<?=$langcode?>" id="featured_image_<?=$langcode?>" value="<?=$featured_image?>" />
			
			<img id="featured_image_preview_<?=$langcode?>" class="featured_thumb" src="<?=$featured_image?>" style="<?php echo ($featured_image == "") ? "display:none;" : ""; ?>" />
			
			<button class="featured_image_button btn btn-default" type="button" data-href="/file_browser/?ajpx_targetfield=featured_image_<?=$langcode?>&callback=ps_blogmanager.updatefeaturedimage('featured_image','<?=$langcode?>')" id="featured_image_button_<?=$langcode?>">Browse Server</button>
									
			<button class="remove_featured_image_button btn btn-default" type="button" data-lang="<?=$langcode?>" id="remove_featured_image_button_<?=$langcode?>" style="<?php echo ($featured_image == "") ? "display:none;" : ""; ?>">Remove Image</button>
			
			
			</div>
			
			
			<div class="clearfix"></div>
			
			

		</div><!-- [END] #<?=$language?>_blog -->
		
		<?php } ?>

		
		<div id="blog_settings">
		
			<div style="float:left; margin-left:20px; margin-top:5px;">
				<label for="blog_active">
					<input type="checkbox" id="blog_active" name="blog_active" onchange="ps_blogmanager.toggle_searchfields(this);" value="1" <?php echo $blogdata['active'] == 1 ? "checked" : ""; ?> /> Active
				</label>
			</div>
			
			
			
			
			<div id="search_fields_div" style="float:left; margin-left:20px; margin-top:5px; <?php if($blogdata['active'] != 1) echo "display:none;"; ?>">
								
			
				<div id="search_priority_div" style="float:left;">
					<img src="<?php echo ASSETURL . PROJECTNAME; ?>/default/core_modules/page_manager/img/spider.png" />
				</div>
			
				<div id="search_priority_div" style="float:left; margin-left:20px; margin-top:5px;">
					<label for="search_priority_val"><span id="field_height_label">Search Priority</span>: <span id="search_priority_display"><?=$search_priority?></span></label>
					<input style="width:40px;" type="hidden" id="search_priority_val" name="search_priority" value="<?=$search_priority?>" />
					<div class="clearfix"></div>
					<div style="float:left; width:120px" id="search_priority_slider"></div>
					<script>  ps_blogmanager.init_priority_slider('<?=$search_priority?>'); </script>
				</div>
			

				<div id="change_frequency_div" style="float:left; margin-left:20px; margin-top:5px;">
					<label for="change_frequency_val" style="width:200px"><span id="field_height_label">Reindex</span>: <span id="change_frequency_display"><?=$change_frequency_label?></span></label>
					<input style="width:40px;" type="hidden" id="change_frequency_val" name="change_frequency" value="<?=$change_frequency?>" />
					<div class="clearfix"></div>
					<div style="float:left; width:120px" id="change_frequency_slider"></div>
					<script>  ps_blogmanager.init_change_frequency_slider('<?=$change_frequency?>'); </script>
				</div>
			
			</div>
			
		
					

			<div class="clearfix"></div>
			
			
			
				<div style="float:left; margin-left:20px; margin-top:5px;">
				<label for="archived">
					<input type="checkbox" id="archived" name="archived" value="1" <?php echo $blogdata['archived'] == 1 ? "checked" : ""; ?> /> Archived
				</label>
			</div>
			
			<br />
			<br />
			
		</div>
			
		

	</div><!-- [END] #crudTabs -->
</form>
</div>


