
<h1>Edit Blog Item</h1>
<form id="blogForm" name="blogForm" method="post" action="/admin_blog/save/<?=$blogdata['blog_id']?>">

<input type="hidden" id="blog_id" name="blog_id" value="<?=$blogdata['blog_id']?>">


<?php

$request_uri = getenv("REQUEST_URI");

?>


	<div id="crudTabs" style="display: none;">
		<ul>
			<li><a href="<?=$request_uri?>#english_blog">English</a></li>
			<li><a href="<?=$request_uri?>#french_blog">French</a></li>
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
		
		<div id="english_blog">
			<div>
				<label for="blogtitle_e">Title</label>
				<input type="text" id="blogtitle_en" name="blogtitle_en" size="300" maxlength="100" value="<?=$blogdata['blogtitle_en']?>" />
			</div>

			
			<div>
				<label for="blog_tags_en">Tags (comma delimited)</label>
				<input type="text" id="blog_tags_en" name="blog_tags_en" size="300" maxlength="500" value="<?=$blogdata['blog_tags_en']?>" />
			</div>
			
			<div>
				<label for="author_en">Author</label>
				<input type="text" id="author_en" name="author_en" style="width:200px" value="<?=$blogdata['author_en']?>" />
			</div>
			
			
			<div style="float:left">
				<label for="publish_date_en">Publish Date</label>
				<input type="text" id="publish_date_en" name="publish_date_en" style="width:80px" value="<?=$blogdata['publish_date_en']?>" />
			</div>
			
	
			
			<div class="clearfix"></div>
			
			
			
			
			
			<div>
				<h2>Short Description</h2>
				<?php
					$blogshortdescription_en = $blogdata['blogshortdescription_en'];
					$ckeditor->basePath = '/' . PROJECTNAME . '/vendor/ckeditor/';
					$ckeditor->config['filebrowserBrowseUrl'] = '/' . PROJECTNAME . '/vendor/elfinder/index.php';
					$ckeditor->config['filebrowserImageBrowseUrl'] = '/' . PROJECTNAME . '/vendor/elfinder/index.php';
					$ckeditor->config['filebrowserFlashBrowseUrl'] = '/' . PROJECTNAME . '/vendor/elfinder/index.php';
					$ckeditor->config['filebrowserWindowWidth'] = '800';
					$ckeditor->config['filebrowserWindowHeight'] = '550';;
					$ckeditor->config['height'] = '100';
					$ckeditor->config['toolbar'] = 'Basic';
					
					$ckeditor->editor('blogshortdescription_en', $blogshortdescription_en);
				?>
			</div>
			
			
			
			<div>
				<h2>Full Article</h2>
				<?php
					$english_content = $blogdata['blogcontent_en'];
					$ckeditor->basePath = '/' . PROJECTNAME . '/vendor/ckeditor/';
					$ckeditor->config['filebrowserBrowseUrl'] = '/' . PROJECTNAME . '/vendor/elfinder/index.php';
					$ckeditor->config['filebrowserImageBrowseUrl'] = '/' . PROJECTNAME . '/vendor/elfinder/index.php';
					$ckeditor->config['filebrowserFlashBrowseUrl'] = '/' . PROJECTNAME . '/vendor/elfinder/index.php';
					$ckeditor->config['filebrowserWindowWidth'] = '800';
					$ckeditor->config['filebrowserWindowHeight'] = '550';;
					$ckeditor->config['height'] = '500';
					$ckeditor->config['toolbar'] = 'Full';
					
					$ckeditor->editor('editor_en', $english_content);
				?>
			</div>

		</div><!-- [END] #english_blog -->
		
		<div id="french_blog">
		
			
			<div>
				<label for="blogtitle_f">Title</label>
				<input type="text" name="blogtitle_fr" id="blogtitle_fr" size="300" maxlength="100" value="<?=$blogdata['blogtitle_fr']?>" />
			</div>
			
			<div>
				<label for="blog_tags_en">Tags (comma delimited)</label>
				<input type="text" id="blog_tags_fr" name="blog_tags_fr" maxlength="500" size="300" value="<?=$blogdata['blog_tags_fr']?>" />
			</div>
			
			
			<div>
				<label for="author_fr">Author</label>
				<input type="text" id="author_fr" name="author_fr" style="width:200px" value="<?=$blogdata['author_fr']?>" />
			</div>
			
			
			<div style="float:left">
				<label for="publish_date_fr">Publish Date</label>
				<input type="text" id="publish_date_fr" name="publish_date_fr" style="width:80px" value="<?=$blogdata['publish_date_fr']?>" />
			</div>
			

			
			<div class="clearfix"></div>
			
				<div>
				<h2>Short Description</h2>
				<?php
					$blogshortdescription_fr = $blogdata['blogshortdescription_fr'];
					$ckeditor->basePath = '/' . PROJECTNAME . '/vendor/ckeditor/';
					$ckeditor->config['filebrowserBrowseUrl'] = '/' . PROJECTNAME . '/vendor/elfinder/index.php';
					$ckeditor->config['filebrowserImageBrowseUrl'] = '/' . PROJECTNAME . '/vendor/elfinder/index.php';
					$ckeditor->config['filebrowserFlashBrowseUrl'] = '/' . PROJECTNAME . '/vendor/elfinder/index.php';
					$ckeditor->config['filebrowserWindowWidth'] = '800';
					$ckeditor->config['filebrowserWindowHeight'] = '550';;
					$ckeditor->config['height'] = '100';
					$ckeditor->config['toolbar'] = 'Basic';
					
					
					$ckeditor->editor('blogshortdescription_fr', $blogshortdescription_fr);
				?>
			</div>
			
			
			<div>
				<h2>Full Article</h2>
				<?php
					$french_content = $blogdata['blogcontent_fr'];
					$ckeditor->basePath = '/' . PROJECTNAME . '/vendor/ckeditor/';
					$ckeditor->config['filebrowserBrowseUrl'] = '/' . PROJECTNAME . '/vendor/elfinder/index.php';
					$ckeditor->config['filebrowserImageBrowseUrl'] = '/' . PROJECTNAME . '/vendor/elfinder/index.php';
					$ckeditor->config['filebrowserFlashBrowseUrl'] = '/' . PROJECTNAME . '/vendor/elfinder/index.php';
					$ckeditor->config['filebrowserWindowWidth'] = '800';
					$ckeditor->config['filebrowserWindowHeight'] = '550';;
					$ckeditor->config['height'] = '500';
					$ckeditor->config['toolbar'] = 'Full';
										
						
					$ckeditor->editor('editor_fr', $french_content);
				?>
			</div>
			
			
			

		</div><!-- [END] #french_blog -->
		
		
		<div id="blog_settings">
		
			<div style="float:left; margin-left:20px; margin-top:5px;">
				<label for="blog_active">
					<input type="checkbox" id="blog_active" name="blog_active" value="1" <?php echo $blogdata['active'] == 1 ? "checked" : ""; ?> /> Active
				</label>
			</div>
			
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
<script type="text/javascript" src="<?php echo base_url(); ?><?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/vendor/jquery.popupwindow.js"></script>