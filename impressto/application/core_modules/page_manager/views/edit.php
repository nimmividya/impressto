<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Page Editor
@Type: PHP
@Filename: edit.php
@Description: edit a page and assign seo and admin rights
@Author: peterdrinnan
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-08-15
*/
?>

<?php

				
	if(isset($contentdata['draft_id'])){

		$CO_Active = 0;
		
	}else{

		// this will determine how the publish button appears
		if(isset($contentdata['CO_Active'])) $CO_Active = $contentdata['CO_Active'];
		else $CO_Active = 0;
		
	}

	if($page_id == ""){

		$publishbuttonvisible = " visible ";
		$savecurrentbuttonvisible = " none ";
		$unpublishbuttonvisible = " none ";
		
	}else if($CO_Active == 0){ 

		$publishbuttonvisible = " visible ";
		$savecurrentbuttonvisible = " none ";
		$unpublishbuttonvisible = " none ";
		
	}else{

		$publishbuttonvisible = " none ";
		$savecurrentbuttonvisible = " visible ";
		$unpublishbuttonvisible = " visible ";
		
	}	

	$request_uri = getenv("REQUEST_URI");
	

	if($contentdata['CO_externalLink'] == "0") $contentdata['CO_externalLink'] = "";
							
	$widgets_visible = ($contentdata['CO_externalLink'] == "" ? "visible" : "none");
				
	if($contentdata['CO_externalLink'] == "0") $contentdata['CO_externalLink'] = "";
	
	
	$aliasingchecked = ($contentdata['CO_externalLink'] != "" ? TRUE : FALSE);
			
	$aliasing_visible = $aliasingchecked ? "block": "none" ;

	$user_role = $this->session->userdata('role');

	
	if(isset($permissions['GURU']) && in_array($user_role,$permissions['GURU'])){
		$extended_js_css_visible = "block";
	}else{
		$extended_js_css_visible = "none";
	}

			
			
			
?>
<script type="text/javascript">

ps_base.wysiwyg_editor = '<?=$this->config->item('wysiwyg_editor')?>';

</script>

<div class="admin-box">


<h3><i class="icon-leaf"></i> Page Configuration</h3>

<?php echo $infobar; ?>


<?php if($page_id != ""){ ?>

<script>

$(function() {

	<?php
	
	if($contentdata['CO_externalLink'] == "0") $contentdata['CO_externalLink'] = "";
	$externallink = ($contentdata['CO_externalLink'] != "" ? TRUE : FALSE);
			
	if($externallink){
		echo "$('#crudTabs').tabs('select', 'page_advanced');";
	}else{
	
		if($onlymobile){
			echo "$('#crudTabs').tabs('select', 'page_mobilecontent');";
		}else{
			echo "$('#crudTabs').tabs('select', 'page_content');";
		}
	}
	?>
});
	
	
</script>

<?php } ?>
	
<?php



?>

<form name="content_edit_form" id="content_edit_form" method="post" class="form-horizontal" accept-charset="utf-8">


	<div id="crudTabs" style="display: none;">
		<ul>
			<li><a href="<?=$request_uri?>#page_settings">Page</a></li>
			<?php if(!$onlymobile){ ?><li><a href="<?=$request_uri?>#page_content">Content</a></li><?php } ?>
			<?php if($mobilized){ ?><li><a href="<?=$request_uri?>#page_mobilecontent">Mobile Content</a></li><?php } ?>
			<li><a href="<?=$request_uri?>#page_seo">SEO</a></li>
			<li><a href="<?=$request_uri?>#page_permissions">Permissions</a></li>
			<li><a href="<?=$request_uri?>#page_advanced">Advanced</a></li>
			
		</ul>
		
		<!-- these are just containers to hold ajax post data -->
		<input type="hidden" name="bodycontent" id="bodycontent" value="" />   
		<input type="hidden" name="mobilebodycontent" id="mobilebodycontent" value="" />
		
		<input type="hidden" name="content_lang" id="content_lang" value="<?php echo $content_lang; ?>" /> 
		<input type="hidden" name="page_id" id="page_id" value="<?php echo $page_id; ?>" />
		<input type="hidden" name="Active" id="CO_Active" value="<?php echo $CO_Active; ?>" />

		<div class="footNav clearfix">
		
		
	
		
			<ul>
				
				<?php
				
				$custom_buttons = Events::trigger('page_editor_buttons', array("node_id"=>$page_id,"lang"=>$content_lang), 'array');
				
				//print_r($custom_buttons);
				
				if(isset($custom_buttons[0]) && is_array($custom_buttons[0])){

					foreach($custom_buttons[0] AS $button){ ?>
					
					<li>
					
					<?php
					
						if(strpos($button['action'],"#") !== false){
						
							// make it an href
							echo "<a class=\"btn "; 
							echo isset($button['btn_class']) ? $button['btn_class'] : "btn-default"; 
							echo "\" href=\"" . trim($button['action']) . "\">";
							if( isset($button['btn_icon_class']) ){ 
								echo "<i class=\"" . $button['btn_icon_class'] . "\"></i> ";  
							}
							echo $button['label'] . "</a>";
							
						
						}else{
						
							// make it a button
							echo "<button class=\"btn  ";							
							echo isset($button['btn_class']) ? $button['btn_class'] : "btn-default"; 
							echo "\" type=\"button\" onclick=\"" . $button['action'] . "\">";
							if( isset($button['btn_icon_class']) ){ 
								echo "<i class=\"" . $button['btn_icon_class'] . "\"></i> ";  
							}
							echo $button['label'] . "</button>";
													
						}
						
					?>
					
			
					</li>
					
				<?php
				
					}
				}				

						
				?>
	

					<li>
						<button class="btn" type="button" id="revert_button" onclick="pscontentedit.revertprompt()"><i class="icon-step-backward"></i> Revert</button>
					</li>
					
					<li>
					<div class="btn-group">
						<button type="button" class="btn btn-success"><i class="icon-white icon-ok"></i> Save</button>
						<button class="btn btn-success dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li><a onclick="pscontentedit.savedraft();">Save as Draft</a></li>
							<li><a onclick="pscontentedit.quicksave();">Quick Save</a></li>
							<li style="display: <?php echo $savecurrentbuttonvisible; ?>"><a onclick="pscontentedit.savecurrent();">Save Current</a></li>
							<li style="display: <?php echo $publishbuttonvisible; ?>"><a onclick="pscontentedit.publish();">Publish Now</a></li>
						</ul>
					</div>
				
					</li>
		
					<li id="preview_button_listitem" <?php if(!$page_id){ ?> style="display:none" <?php } ?> >
						<button class="btn btn-default" type="button" id="preview_button" onclick="pscontentedit.preview_draft()"><i class="icon-white icon-eye-open"></i> Preview</button>
					</li>

					<li>
						<button class="btn btn-danger" type="button" id="unpublish_button" style="display: <?php echo $unpublishbuttonvisible; ?>" onclick="pscontentedit.unpublish();"><i class="icon-white icon-off"></i> Unpublish</button>
					</li>					

				</ul>
		</div>
		
		<?php //TODO: This is Temporary
		if(isset($contentdata['draft_id'])) { ?>
			<div class="alert alert-error">
				<?php
					//formDisplayError();
				?>
				<?php if(isset($contentdata['draft_id'])){ ?>
						This is a <strong>Draft Copy.</strong>
				<?php } ?>
			</div>
		<?php } ?>
		

		
		<div id="page_settings">
		
		<fieldset>
		
		
		
		
 
		<div style="background:#FAFAFA; padding:10px; border: 1px solid #EFEFEF;">
			Page Title ( HTML will be auto-purged for META tags) <br />

			
			
			<textarea id="seoTitle" name= "seoTitle" placeholder="Enter text ..." style="width: 588px; height: 50px"><?php
			
			echo isset($contentdata['CO_seoTitle']) ? $contentdata['CO_seoTitle'] : "";
			
					
			?></textarea>
			
		</div>
		

	<div class="control-group ">
		<label for="MenuTitle" class="control-label">Menu Title</label>
			<div class="controls">
			
			
			<?php
				
				
			$fielddata = array(
				'name'        => "MenuTitle",
				'type'          => 'text',
				'id'          => "MenuTitle",
				'label'          => "",
				'width'          => 300,
				'usewrapper'          => false,
				'value'       =>  (isset($contentdata['CO_MenuTitle']) ? $contentdata['CO_MenuTitle'] : "")
			);
							
			echo $this->formelement->generate($fielddata);
			
				
			?>

		</div>
	</div>
		

		
	<div class="control-group ">
		<label for="Url" class="control-label">Friendly Url</label>
			<div class="controls">
			
		<?php
		$CO_Url = "";
		
		if(isset($contentdata['CO_Url'])) $CO_Url = $contentdata['CO_Url'];

			
			$fielddata = array(
				'name'        => "Url",
				'type'          => 'text',
				'id'          => "Url",
				'label'          => "",
				'width'          => 300,
				'usewrapper'          => false,
				'value'       =>  $CO_Url
			);
							
			echo $this->formelement->generate($fielddata);
			

			?>

		</div>
	</div>

	
		
			<div class="control-group ">
			
				<label for="Public" class="control-label"></label>
				<div class="controls">
										
			
			<?php
		
			
			$fielddata = array(
				'name'        => "aliasing",
				'type'          => 'checkbox',
				'id'          => "aliasing",
				'onclick'       => "pscontentedit.toggle_aliasing(this);",
				'options' =>  "1",
				'usewrapper'          => TRUE,
				'label' => 'External link or alias',
				'value'       =>  $aliasingchecked 
			);
							
			echo $this->formelement->generate($fielddata);
		
		
			?>
			
			
			<div id="aliasing_wrapper_div" style="display: <?=$aliasing_visible?>">
		
			<?php

			
				$data = array(
				  'name'        => 'externalLink',
				  'id'          => 'externalLink',
				  'value'       => '0',
				  'size' 		=> '30',
				  'value' 		=> (isset($contentdata['CO_externalLink']) ? $contentdata['CO_externalLink'] : ""),
				  'checked'     => ($CO_Active == '0' ? true : false),
				  'style'		=> 'width: 350px; margin: 0 9px 0 0;'
				);

				echo form_input($data);
				

			?>
			
			<button class="btn btn-default" type="button" id="CO_externalLink_button">Browse Server</button>

			</div>
			
			
		</div>
		</div>
		
		

	<div class="control-group ">
		<label for="Parent" class="control-label">Parent</label>
			<div class="controls">

			<?php
			

			$nodes = array("ROOT"=>"1");
			$colors = array("ROOT"=>"");
			$textcolors = array("ROOT"=>"");
	
			foreach($page_parent_options AS $node_data){

				$key = $node_data['code_indent'] . $node_data['label'];
							
				$nodes[$key . " [" . $node_data['id'] . "]"] = $node_data['id'];
				$colors[$key . " [" . $node_data['id'] . "]"] = $node_data['color'];
				$textcolors[$key . " [" . $node_data['id'] . "]"] = $node_data['text_color'];
									
			}
			
			$fielddata = array(
				'name'        => "Parent",
				'type'          => 'select',
				'id'          => "Parent",
				'colors'  => $colors,
				'textcolors'  => $textcolors,
				'label'          => "",
				'width'          => 300,
				'usewrapper'          => false,
				'options' =>  $nodes,
				'value'       =>  (isset($contentdata['node_parent']) ? $contentdata['node_parent'] : "")
			);
							
			echo $this->formelement->generate($fielddata);

				
			?>
		</div>
	</div>
		
	
			
			
			
			<div class="control-group ">
			
				<label for="Public" class="control-label"></label>
				<div class="controls">
		
			
			<?php
			

				if(isset($contentdata['CO_Public'])) $CO_Public = $contentdata['CO_Public'];
				else $CO_Public = 0;
	
					
			
				$fielddata = array(
				'name'        => "Public",
				'type'          => 'checkbox',
				'id'          => "Public",
				'usewrapper'          => TRUE,
				'label' => 'Appears in menus',
				'options' =>  "1",
				'value'       =>  ($CO_Public == 0 ? 0 : 1)
			);
							
			echo $this->formelement->generate($fielddata);
			
			
			?>
			</div>
		
			</div>
			
					
			


		</fieldset>

		
		</div>
				
				
		<?php if(!$onlymobile){ ?>
				
				
		<div id="page_content">
		
				<?php
				
				$current_template = (isset($contentdata['CO_Template']) ? $contentdata['CO_Template'] : "");
			
				?>
				
				<div class="template_box">
				
				<div class="template_thumb" style="float:left; margin-left:10px;">
				
				<?php
				
				
					$template_thumb = "";
					$template_thumb_visible = "none";
								
					if($current_template != ""){

						$template_thumb = "/thumbs/" . PROJECTNUM . "/pages/desktop/" . str_replace(".php","",$current_template) . ".png";
												
						if(file_exists(TEMPLATEPATH . $template_thumb)){
																	
							$template_thumb = TEMPLATEURL . $template_thumb;
							$template_thumb_visible = "visible";
													
						}
				 
					}
					
				?>
				
				<img id="template_preview_thumb" src="<?=$template_thumb?>" style="display:<?=$template_thumb_visible?>" />
				
				</div>
				
		
				<div style="float:left; margin-left:10px;">
			
				Page Design Template:

				<br />
				<?php
		
				
				$fielddata = array(
				'name'        => "Template",
				'type'          => 'select',
				'id'          => "Template",
				'usewrapper'          => FALSE,
				'onchange' => 'pscontentedit.showtemplatethumb(this)',
				'options' =>  $template_select_options,
				'value'       =>  $current_template
				);
							
				echo $this->formelement->generate($fielddata);
			

				?>
				</div>
				
				<div class="clearfix"></div>
				
				</div>
				
	
				
	
				

		
		
			<div class="clearfix"></div>
	
			<div><?php
			
			$fielddata = array(
				'name'        => "purify_co_body",
				'type'          => 'checkbox',
				'id'          => "purify_co_body",
				'usewrapper'          => true,
				'label' => 'Auto-clean HTML',
				'onclick' => 'pscontentedit.purifier_prompt(this)',
				'options' =>  "1",
				'value'       =>  ""
			);
							
			echo $this->formelement->generate($fielddata);
		
		
			?></div>
				
				<?php 
					
				$content = "";
				if(isset($contentdata['CO_Body'])) $content = $contentdata['CO_Body'];
					
				$config = array(
				
					"content" => $content,
					"name" => "Body", 
					"lang" => $content_lang, 					
					"height" => 500, 
					"toolbar" => "Full" 		
						
				);
						
				echo $this->edittools->insert_wysiwyg($config);
				
			
				?>	
				
				
				<?php 
				
				if(isset($editzone_1) && is_array($editzone_1)){
			
					foreach($editzone_1 as $editsection){
				
						echo $editsection;
						
					}
					
				}
				
				?>
				
			
				
				<div class="control-group ">
			
					
		
				<label for="prevpage" class="control-label">Previous Page</label>
				<div class="controls">
			
					<?php 

		
				$optionval = isset($contentdata['prevpage']) ? $contentdata['prevpage'] : "";
				
				$data = array(	
				'name'        => "prevpage",
				'id'          => "prevpage",
				'type'          => 'select',
				'showlabels'          => false,
				'width'          => 300,
				'label'          => "",
				'onchange' => "",
				'value'       => $optionval,
				'use_ids' => TRUE,
				
	
				);

				echo get_ps_page_slector($data); 
				
		
				?>
				</div>
			
		
				</div>
	
		
			

			
			<div class="control-group ">
				<label for="nextpage" class="control-label">Next Page</label>
				<div class="controls">
			
					<?php 

						
				$optionval = isset($contentdata['nextpage']) ? $contentdata['nextpage'] : "";
				
				$data = array(	
				'name'        => "nextpage",
				'id'          => "nextpage",
				'type'          => 'select',
				'showlabels'          => false,
				'width'          => 300,
				'label'          => "",
				'onchange' => "",
				'value'       => $optionval,
				'use_ids' => TRUE,
				
	
				);

				echo get_ps_page_slector($data); 
		
				?>
				</div>
			</div>
			
					
				
			<div class="clearfix"></div>
			

			
			
			<div id="featured_image_div" style="display: <?=$widgets_visible?>">
		
			<h4>Featured Image</h4>
			
			<?php
			
				$featured_image = isset($contentdata['featured_image']) ? $contentdata['featured_image'] : "";
			
			?>
			
			
			<input type="hidden" name="featured_image" id="featured_image" value="<?=$featured_image?>" />
			
			<img id="featured_image_preview" class="featured_thumb" src="<?=$featured_image?>" style="<?php echo ($featured_image == "") ? "display:none;" : ""; ?>" />
			
			<button class="btn btn-default" type="button" id="featured_image_button">Browse Server</button>
			
						
			<button class="btn btn-default" type="button" id="remove_featured_image_button" style="<?php echo ($featured_image == "") ? "display:none;" : ""; ?>">Remove Image</button>
			
			
			</div>
			
			
			<div class="clearfix"></div>
			
			
			
			
			
			
			
			<div id="extended_js_css_div" style="display: <?=$extended_js_css_visible?>">

		
			<?php formLabel("Javascript", "Javascript", "");?>
			<?php
			
				$data = array(
				  'name'        => 'Javascript',
				  'id'          => 'Javascript',
				  'class'          => 'markitupjavascript',
				  'value'       => (isset($contentdata['CO_Javascript']) ? $contentdata['CO_Javascript'] : ""),
				  'rows'   => '4',
				  'cols'        => '50',
				  'style'       => 'width: 602px;',
				);

				echo form_textarea($data);
			
			?>
								
			<div class="clearfix"></div>
								
			<?php formLabel("CSS", "CSS", "");?>
			<?php
			
				$data = array(
				  'name'        => 'CSS',
				  'id'          => 'CSS_editor',
				  'value'       => (isset($contentdata['CO_CSS']) ? $contentdata['CO_CSS'] : ""),
				  'rows'   => '6',
				  'class'   => 'lined',
				  'cols'        => '50',
				  'style'       => 'width:98.3%',
				);

				echo form_textarea($data);
				
			?>
			
			
	
						
			</div>

			
								
			<div class="clearfix"></div>
			

		</div>  
		
		<?php } // end of onlymobile check ?>

	
		<?php if($mobilized){ ?>
		
		
		<div id="page_mobilecontent">
		
				<?php
				
				$current_mobile_template = (isset($contentdata['CO_MobileTemplate']) ? $contentdata['CO_MobileTemplate'] : "");
				
				?>
				
				<div class="template_box">
				
											
				<div class="template_thumb" style="float:left; margin-left:10px;">
				
				<?php 
				
					$template_thumb = "";
					$template_thumb_visible = "none";
								
					if($current_mobile_template != ""){

						$template_thumb = "/templates/thumbs/pages/mobile/" . str_replace(".php","",$current_mobile_template) . ".png";
						
						if(file_exists(INSTALL_ROOT .  $template_thumb)){
												
							$template_thumb = "/" . PROJECTNAME . $template_thumb;
							$template_thumb_visible = "visible";
									
					
								
						}
				 
					}
				
				
				?>
				<img id="mobile_template_preview_thumb" src="<?=$template_thumb?>" style="display:<?=$template_thumb_visible?>" />
				
				</div>
				
		
				<div style="float:left; margin-left:10px; <?php if(!$mobilized) echo "display:none;"; ?>">
				Mobile Design Template:
				<br />
				
				<?php
	
				
				//echo form_dropdown('MobileTemplate', $mobile_template_select_options, $current_mobile_template);
				
				$fielddata = array(
				'name'        => "MobileTemplate",
				'type'          => 'select',
				'id'          => "MobileTemplate",
				'usewrapper'          => FALSE,
				'onchange' => 'pscontentedit.showtemplatethumb(this)',
				'options' =>  $mobile_template_select_options,
				'value'       =>  $current_mobile_template
				);
							
				echo $this->formelement->generate($fielddata);
				
				
				
				?></div>
				
				<div class="clearfix"></div>
				
				
				</div>
				

				
				<div class="clearfix"></div>
				
				
				<div><?php
			
				$fielddata = array(
				'name'        => "purify_co_mobilebody",
				'type'          => 'checkbox',
				'id'          => "purify_co_mobilebody",
				'usewrapper'          => true,
				'label' => 'Auto-clean HTML',
				'options' =>  "1",
				'onclick' => 'pscontentedit.purifier_prompt(this)',
				'value'       =>  ""
				);
							
				echo $this->formelement->generate($fielddata);
		
		
				?></div>
			
			
				<?php 
					
				$content = "";
				if(isset($contentdata['CO_MobileBody'])) $content = $contentdata['CO_MobileBody'];
					
				$config = array(
				
					"content" => $content,
					"name" => "MobileBody", 
					"lang" => $content_lang, 
					"height" => 500, 
					"toolbar" => "Full" 		
						
				);
						
				echo $this->edittools->insert_wysiwyg($config);
				
			
				?>	
				
				<div class="clearfix"></div>
				
				
				<?php 
				
				if(isset($editzone_3) && is_array($editzone_3)){
			
					foreach($editzone_3 as $editsection){
				
						echo $editsection;
						
					}
					
				}
				
				?>
				
					
				
					<div class="control-group ">
			
					
		
				<label for="mobile_prevpage" class="control-label">Previous Page</label>
				<div class="controls">
			
					<?php 

		
				$optionval = isset($contentdata['mobile_prevpage']) ? $contentdata['mobile_prevpage'] : "";
				
				$data = array(	
				'name'        => "mobile_prevpage",
				'id'          => "mobile_prevpage",
				'type'          => 'select',
				'showlabels'          => false,
				'width'          => 300,
				'label'          => "",
				'onchange' => "",
				'value'       => $optionval,
				'use_ids' => TRUE,
				
	
				);

				echo get_ps_page_slector($data); 
				
		
				?>
				</div>
			
		
				</div>
	
		
			

			
			<div class="control-group ">
				<label for="mobile_nextpage" class="control-label">Next Page</label>
				<div class="controls">
			
					<?php 

						
				$optionval = isset($contentdata['mobile_nextpage']) ? $contentdata['mobile_nextpage'] : "";
				
				$data = array(	
				'name'        => "mobile_nextpage",
				'id'          => "mobile_nextpage",
				'type'          => 'select',
				'showlabels'          => false,
				'width'          => 300,
				'label'          => "",
				'onchange' => "",
				'value'       => $optionval,
				'use_ids' => TRUE,
				
	
				);

				echo get_ps_page_slector($data); 
		
				?>
				</div>
			</div>
			
			<div class="clearfix"></div>
		
			<div id="mobile_featured_image_div" style="display: <?=$widgets_visible?>">
		
			<h4>Featured Image</h4>
			
			<?php
			
				$featured_image = isset($contentdata['mobile_featured_image']) ? $contentdata['mobile_featured_image'] : "";
			
			?>
			
			<input type="hidden" name="mobile_featured_image" id="mobile_featured_image" value="<?=$featured_image?>" />
			
			<img id="mobile_featured_image_preview" class="featured_thumb" src="<?=$featured_image?>" style="<?php echo ($featured_image == "") ? "display:none;" : ""; ?>" />
			
			<button class="btn btn-default" type="button" id="mobile_featured_image_button">Browse Server</button>
				
			<button class="btn btn-default" type="button" id="remove_mobile_featured_image_button" style="<?php echo ($featured_image == "") ? "display:none;" : ""; ?>">Remove Image</button>
				
			
			</div>
			

			
			<div class="clearfix"></div>
			
			<div id="extended_mobile_js_css_div" style="display: <?=$extended_js_css_visible?>">
						

			<?php
			
				$data = array(
				  'name'        => 'MobileJavascript',
				  'id'          => 'MobileJavascript',
				   'class'          => 'markitupjavascript',
					
				  'value'       => (isset($contentdata['CO_MobileJavascript']) ? $contentdata['CO_MobileJavascript'] : ""),
				  'rows'   => '4',
				  'cols'        => '50',
				  'style'       => 'width: 602px;',
				);

				echo form_textarea($data);
			?>
			
				<div class="clearfix"></div>
				
		
			<?php formLabel("Mobile CSS", "Mobile CSS", "");?>
			<?php
			
				$data = array(
				  'name'        => 'MobileCSS',
				  'id'          => 'MobileCSS_editor',
				  'value'       => (isset($contentdata['CO_MobileCSS']) ? $contentdata['CO_MobileCSS'] : ""),
				  'rows'   => '6',
				  'class'   => 'lined',
				  'cols'        => '50',
				  'style'       => 'width:98.3%',
				);

				echo form_textarea($data);
				
			?>
			
			</div>
			
		
		</div>
		
		<?php }  // end of is mobilized ?>
		
		
	<div id="page_seo">
	
					
		<fieldset>
		
		<div class="control-group ">
			<label for="seoKeywords" class="control-label fullwidth">Keywords</label>
			<div class="clearfix"></div>
			<div class="controls fullwidth">

	
				<?php
			
				$data = array(
				  'name'        => 'seoKeywords',
				  'id'          => 'seoKeywords',
				  'value'       => (isset($contentdata['CO_seoKeywords']) ? $contentdata['CO_seoKeywords'] : ""),
				  'rows'   => '2',
				  'class'   => 'lined',
				  'cols'        => '50',
				  'style'       => 'width:98.3%',
				);

				echo form_textarea($data);
				
			?>
			
				<span class="help-inline">Max. 255 characters.</span>
			</div>
		</div>
		
			
			
		<div class="control-group ">
			<label for="seoDesc" class="control-label fullwidth">Description</label>
			<div class="controls fullwidth">
			
			<?php
			
				$data = array(
				  'name'        => 'seoDesc',
				  'id'          => 'seoDesc',
				  'value'       => (isset($contentdata['CO_seoDesc']) ? $contentdata['CO_seoDesc'] : ""),
				  'rows'   => '4',
				  'class'   => 'lined',
				  'cols'        => '50',
				  'style'       => 'width:98.3%',
				);

				echo form_textarea($data);
				
			?>
			
			
			<span class="help-inline">Max. 255 characters.</span>
			</div>
		</div>
		
		
	<div class="control-group ">
	
		<div style="float:left; margin-top:0px;">
		
			<div class="controls fullwidth">
			
			
		<?php
		
			if(isset($contentdata['CO_Searchable'])) $CO_Searchable = $contentdata['CO_Searchable'];
			else $CO_Searchable = 1;
				
			//echo form_checkbox($data);

				$fielddata = array(
				'name'        => "Searchable",
				'type'          => 'checkbox',
				'id'          => "Searchable",
				'label'      => "Appears in search results",
				'usewrapper'          => TRUE,
				'onclick'       => "pscontentedit.whiteout_tags();",
				'options' =>  "1",
				'value'       =>  ($CO_Searchable == 0 ? 0 : 1),
			);
							
			echo $this->formelement->generate($fielddata);
		
		
		?>
			</div>
			
			</div>
			
			<div id="search_fields_div" style="float:left; margin-left:20px; margin-top:5px; <?php if($CO_Searchable != 1) echo "display:none;"; ?>">
			
		
			
				<div id="search_priority_div" style="float:left;">
					<img src="<?php echo ASSETURL . PROJECTNAME; ?>/default/core_modules/page_manager/img/spider.png" />
				</div>
			
				<div id="search_priority_div" style="float:left; margin-left:20px; margin-top:5px;">
					<label for="search_priority_val"><span id="field_height_label">Search Priority</span>: <span id="search_priority_display"><?=$search_priority?></span></label>
					<input style="width:40px;" type="hidden" id="search_priority_val" name="search_priority" value="<?=$search_priority?>" />
					<div class="clearfix"></div>
					<div style="float:left; width:120px" id="search_priority_slider"></div>
					<script>  pscontentedit.init_priority_slider('<?=$search_priority?>'); </script>
				</div>
			

				<div id="change_frequency_div" style="float:left; margin-left:20px; margin-top:5px;">
					<label for="change_frequency_val" style="width:200px"><span id="field_height_label">Reindex</span>: <span id="change_frequency_display"><?=$change_frequency_label?></span></label>
					<input style="width:40px;" type="hidden" id="change_frequency_val" name="change_frequency" value="<?=$change_frequency?>" />
					<div class="clearfix"></div>
					<div style="float:left; width:120px" id="change_frequency_slider"></div>
					<script>  pscontentedit.init_change_frequency_slider('<?=$change_frequency?>'); </script>
				</div>
			
			</div>
			
					
		</div>
		

		
		
		
		<div id="page_tags_div" <?php if($CO_Searchable != 1) echo " style=\"display:none\""; ?>>
		
		<!-- this is where the tag widget goes -->

				
		<?php 
		// No need to register events because each module event class will auto register its own events
		// you just need to  make sure the events library has been loaded and trigger the event
		
		$tags = Events::trigger('edit_content', array("lang"=>$content_lang,"content_module"=>"page_manager","content_id"=>$page_id), 'array');
		
		
		$adminwidget_config = array(
		
			"lang"=>$content_lang,
			"content_module" => "page_manager",
			"content_id" => $page_id,
			"field_name" => "page_tags",
			"tags" => $tags[0],
			
		);
	
		Admin_Widget::run('tags/tagger', $adminwidget_config ); 
			
		?>
		
				
		</div>		
			
			
		</fieldset>
				
		
		

	</div>					

	<div id="page_permissions">

	
			<p>
			Roles that are allowed to view this page. Select "Anonymous" to allow viewing to all users.
			</p>
			
					
			<?php

			foreach($content_rights AS $data){ 
			
				$checked = "";
				if($data['accessible'] == 'Y') $checked = " checked=\"checked\"";
				
			?>
			
				<label class="uni-checkbox">
					<div class="uni-checker"><span class="uni-checked"><input type="checkbox" class="uni_style" name="content_rights[]" value="<?=$data['role_id']?>" style="opacity: 0;" <?=$checked?>"></span></div>
						<?=$data['role_name']?>
				</label>
		

			<?php }  ?>
			
				
		
	
	</div>
	

	
	<div id="page_advanced">
	
	
	
			<div>
			<?php formLabel("Color", "Color", "");?>
			<input type="text" id="Color" name="Color" class="color-picker" style="width:70px" value="<?php echo ( isset($contentdata['CO_Color']) ?  $contentdata['CO_Color'] : ''); ?>" />
			</div>	
		
		
			<div class="clearfix" style="height:20px"></div>
					
			<div style="float:left; margin-left:10px;">
									
				<div id="widget_selector_div" style="display:<?=$widgets_visible?>" >
				Widget Collection: 
				<?php echo $wm_collection_selector;	?>
				</div>		
			</div>	
			
			<div class="clearfix"></div>
		

		

			

	</div>		
		

	</div>
	
</form>

</div>


	<script type="text/javascript">
	
	$(function() {
	
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		
		$( "#restore_dialog" ).dialog({
			autoOpen: false,
			height: 360,
			width: 300,
			modal: true,
			buttons: {
				'Cancel': function() {
					$(this).dialog("close");
				}
			}
		});
		
		pscontentedit.language = '<?php echo $content_lang; ?>';
		
		
		<?php if($contentdata['CO_externalLink'] != ""){ ?>
		
			$("#crudTabs").tabs({disabled: [1,2]});
				
		
		<?php } ?>
		
		

	});
	</script>
<div id="restore_dialog" title="Revert Page"></div>
<div id="dialog" style="display:none"></div>


<div class="modal hide" id="purifier_prompt_modal" style="display:none">


<?php

$popupwidgets = Events::trigger('page_editor_popupwidgets', array("node_id"=>$page_id,"lang"=>$content_lang), 'array');

?>


				
	
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3>HTML PURIFIER NOTICE</h3>
    </div>
    <div class="modal-body">
    <p>
	
	This option will auto-repair broken HTML documents. 
	Please be aware that complex documents may be transformed in unpredictable ways. It is best to only use this option when necessary.
		
	</p>
    </div>
    <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Close</a>
	</div>
    </div>
	