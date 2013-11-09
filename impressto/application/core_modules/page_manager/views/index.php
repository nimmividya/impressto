
<script type="text/javascript">
	$(function() {
		psctntmgr.setupsortable('<?php echo $baserootid; ?>');
	});
</script>


<div class="admin-box">

<h3><i class="icon-leaf"></i> Content (<?=$lang?>)</h3>
<?=$infobar?>



<div class="subNav clearfix">

			<?php
							
							$user_session_data = $this->session->all_userdata();	
							$user_role = $user_session_data['role']; 
							
					
		
							if($user_role == 1){ // this is for the administrator to toggle the WYSIWYG editor on the fly ?>
							
							
					
							<div style="float:left; margin:8px 0 0 4px;">
								
								<input onchange="psctntmgr.toggle_wysiwyg(this)" type="checkbox" id="toggle_wysiwyg_button" value="true" <?php
								
									$block_wysiwyg_editing = $this->input->cookie('block_wysiwyg_editing', FALSE);
									
									if(!$block_wysiwyg_editing ||  $block_wysiwyg_editing == "false" || $block_wysiwyg_editing == "" ) echo " checked=\"checked\"";
																		
									 
								?> />
							</div>
							
			
							
							<?php } ?>
							
	<ul style="padding:5px;">
	
		<li>
		<input style="width:120px; margin-right:4px;" type="text" name="orderlist_filter_keyword" id="orderlist_filter_keyword" />
		</li>
		
		<li>
			<a style="margin-right:10px; display:inline-block" class="btn btn-default" onclick="psctntmgr.filter_orderlist()"><i class="icon-white icon-search"></i> Search</a>
		</li>
		<li>
			<a style="margin-right:10px; display:inline-block" class="btn btn-default" onclick="psctntmgr.build_xml_sitemap()" title="Build XML Sitemap"><i class="icon-white icon-refresh"></i> Rebuild Sitemap</a>
		</li>
		
		<li>
			<a style="display:inline-block" class="btn btn-default" href="/page_manager/edit/<?=$lang?>" title="Add a page to the website"><i class="icon-white icon-plus"></i> Add Page</a>
		</li>
	

	
	
	
	</ul>	
</div>


<div id="pageList">

	<?php echo $aj_pagelist; ?>
	
</div>


<div id="dialog" style="display:none"></div>

		
		
</div>


<script type="text/javascript" class="showcase">

$(function(){

    $.contextMenu({
        selector: '.page_listitem', 
        trigger: 'left',
        callback: function(key, options) {
		
			var obj_id = options.$trigger.attr('id');
						
			psctntmgr.contextmenu_action(obj_id, key);
			
            //var m = "clicked: " + key;
            //window.console && console.log(m) || alert(m); 
			
        },
        items: {
            "edit": {name: "Edit", icon: "edit"},
            "copy": {name: "Copy", icon: "copy"},
            "add_child": {name: "Add Sub-page", icon: "add_child"},
            "preview": {name: "Preview", icon: "preview"},
			<?php foreach($pagemanager_menulinks as $menulink){ ?>
			"<?=$menulink['css_class']?>": {name: "<?=$menulink['label']?>", icon: "<?=$menulink['css_class']?>"},
			<?php } ?>
            "sep1": "---------"
		}
    });
	
    $.contextMenu({
        selector: '.childless_page_listitem', 
        trigger: 'left',
        callback: function(key, options) {
		
			var obj_id = options.$trigger.attr('id');
			
			psctntmgr.contextmenu_action(obj_id, key);
			
					
            //var m = "clicked: " + key;
            //window.console && console.log(m) || alert(m); 
			
        },
        items: {
            "edit": {name: "Edit", icon: "edit"},
            "copy": {name: "Copy", icon: "copy"},
            "add_child": {name: "Add Sub-page", icon: "add_child"},
            "preview": {name: "Preview", icon: "preview"},
            "delete": {name: "Delete", icon: "delete"},
     		 "sep1": "---------",
			<?php foreach($pagemanager_menulinks as $menulink){ ?>
			"<?=$menulink['css_class']?>": {name: "<?=$menulink['label']?>", icon: "<?=$menulink['css_class']?>"},
			<?php } ?>
            "sep1": "---------"
		}
    })
});
    </script>

   
   

<script>
	
$(function() {
	
			
	psctntmgr.language = '<?php echo $lang; ?>';

		
});
</script>

	
