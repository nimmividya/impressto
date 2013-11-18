<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Content Block Manager
@Type: PHP
@Filename: manager.php
@Description: manage content blocks that can be inserted into pages and content
@Author: Nimmitha Vidyathilaka
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-08-15
*/
?>

<script type="text/javascript">

ps_base.wysiwyg_editor = '<?=$this->config->item('wysiwyg_editor')?>';

<?php 

$lang_avail = $this->config->item('lang_avail');

$lang_avail_values = array();
	
foreach($lang_avail AS $langcode=>$language){ 

	$lang_avail_values[] = "{\"lang\":\"{$langcode}\"}";
	
}
				
?>

ps_base.lang_avail =  [<?php echo implode(",",$lang_avail_values); ?>];
				

</script>


<?php

$languages = $this->config->item('languages');

$request_uri = getenv("REQUEST_URI");

?>

<div class="admin-box">

<h3>Content Blocks</h3>
<?=$infobar?>


<div class="footNav clearfix">
	<ul>
		<li>
			<button class="btn btn-default" type="button" onclick="ps_cblockmanager.editblock('');">
				<i class="icon-star icon-white"></i> New Block
			</button>
		</li>
	</ul>
</div>

<div id="blockedit_div" style="display:none">
<form id="blockeditform" class="form-horizontal" accept-charset="utf-8">
		<input type="hidden" id="block_id" name="block_id" value="" />
		
		<?php 
				
		$lang_avail = $this->config->item('lang_avail');
		
		foreach($lang_avail AS $langcode=>$language){ ?>

			<input type="hidden" id="content_<?=$langcode?>" name="content_<?=$langcode?>" value="" />
				
		<?php } ?>
		
	

		<div id="crudTabs" style="display: none;">
			<ul>
				<li><a href="<?=$request_uri?>#block_setup">Setup</a></li>
				<?php 
				
				$lang_avail = $this->config->item('lang_avail');
		
				foreach($lang_avail AS $langcode=>$language){ ?>
				
				
					<li><a href="<?=$request_uri?>#block_<?=$language?>_content"><?php echo ucwords($language); ?></a></li>
				
					
				<?php } ?>
				<li><a href="<?=$request_uri?>#block_xtras">Xtras</a></li>
			</ul>
			<div class="footNav clearfix">
			
				<div style="float:left; margin-left:10px; margin-top:5px; font-weight:bold; color:#444444; font-size:14px;" id="current_edit_label"></div>
				<ul>
					<li><button class="btn btn-success" type="button" onclick="ps_cblockmanager.saveblock();"><i class="icon-white icon-ok"></i> Save</button></li>
					<li><button class="btn" type="button" onclick="ps_cblockmanager.canceledit();"><i class="icon-black icon-remove"></i> Cancel</button></li>
				</ul>
			</div>

			<div id="block_setup">
				<div style="float:left">
					<h5>Name</h5>
					<?php
					
						$fielddata = array(
						'name'        => "name",
						'type'          => 'text',
						'id'          => "cblock_name",
						'onkeyup'   => "ps_cblockmanager.update_current_edit_label();",
						'usewrapper'          => false,
						'width' =>  '200px'
					);
				
					echo $this->formelement->generate($fielddata);
					
					?>
				</div>
			
				<div style="float:left; margin-left:10px">
					<h5>Template</h5>
					<?php
					
						$fielddata = array(
						'name'        => "template",
						'type'          => 'select',
						'id'          => "cblock_template",
						'usewrapper'          => false,
						'width' =>  '200px',
						'options' => $template_options
					);
				
					echo $this->formelement->generate($fielddata);
					
					?>
				</div>
					
			
				<div style="float:left; margin-left:20px; margin-top:30px;">
					<?php
					
						$fielddata = array(
						'name'        => "blockmobile",
						'type'          => 'checkbox',
						'id'          => "cblock_blockmobile",
						'usewrapper'          => TRUE,
						'value' =>  'Y',
						'label' => 'block for mobile'
						
					);
					
					echo $this->formelement->generate($fielddata);
					
					?>
				</div>
				
				
				<div style="float:left; margin-left:20px; margin-top:30px;"><?php
			
			$fielddata = array(
				'name'        => "purify_content",
				'type'          => 'checkbox',
				'id'          => "purify_content",
				'usewrapper'          => true,
				'label' => 'Auto-clean HTML',
				'onclick' => 'ps_cblockmanager.purifier_prompt(this)',
				'options' =>  "1",
				'value'       =>  ""
			);
							
			echo $this->formelement->generate($fielddata);
		
		
			?></div>
			
			
				<div class="clearfix"></div>
			</div>
			

			
			<?php 
				
			$lang_avail = $this->config->item('lang_avail');
		
			foreach($lang_avail AS $langcode=>$language){ ?>
				
				
			<div id="block_<?=$language?>_content">
			<?php
			
											
					$content = "";
					if(isset($row->{"content_" . $langcode})) $content = $row->{"content_" . $langcode};
					
					$config = array(
				
						"content" => $content,
						"name" => "ck_content_" . $langcode, 
						"height" => 500, 
						"toolbar" => "Full" 		
						
					);
						
					echo $this->edittools->insert_wysiwyg($config);
				
					
				?>
			</div>
			
				
					
			<?php } ?>
				

			<div id="block_xtras" class="clearfix">
					
					<h5>Javascript</h5>
					<?php
					
						$fielddata = array(
						'name'        => "javascript",
						'type'          => 'textarea',
						'cssclass'          => 'markitupjavascript',
						'id'          => "cblock_javascript",
						'label'          => "",
						'usewrapper'          => false,
						'width' =>  '600',
						'height' =>  '200',				
						'value'       => ""
						);
				

						echo $this->formelement->generate($fielddata);
					?>
										
					<div class="clearfix"></div>
										
					<h5>CSS</h5>
					
					<?php
					
						
						$fielddata = array(
						'name'        => "css",
						'type'          => 'textarea',
						'id'          => "cblock_css",
						'label'          => "",
						'usewrapper'          => false,
						'width' =>  '650',
						'height' =>  '140',				
						'value'       => ""
						);
			

						echo $this->formelement->generate($fielddata);
						
					?>
					
			</div>
		</div><!-- [END] #cruTabs -->
</form>
</div>

<div id="blocklist_div">

<?php echo $blocklist; ?>

</div>

</div>



<div class="modal hide" id="purifier_prompt_modal">
	
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
	