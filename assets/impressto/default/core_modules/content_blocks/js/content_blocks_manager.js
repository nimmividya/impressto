var pscontentblocksmanager = appbase.extend({
	construct: function() {
	
	},
	
	
	
	_autosave_wysiwyg : function(){
	
		
		if(ps_base.wysiwyg_editor == 'ckeditor'){
		
		   for ( instance in CKEDITOR.instances ){
				CKEDITOR.instances[instance].updateElement();
			}
			
		}else if(ps_base.wysiwyg_editor == 'tiny_mce'){
			
			if(window.tinyMCE) {
				tinyMCE.triggerSave();
			}
		}
		
		
	},
	
	_autoload_wysiwyg : function( data ){
	
				
		if(ps_base.wysiwyg_editor == 'ckeditor'){
		
			if(	data == ''){
			
				$.each(ps_base.lang_avail, function(i, item) {
					eval("CKEDITOR.instances.ck_content_" + item.lang  + ".setData( '' )");
				});

			}else{
				$.each(ps_base.lang_avail, function(i, item) {
					eval("CKEDITOR.instances.ck_content_" + item.lang  + ".setData( data.content_" + item.lang + ")");
				});
			}				
			
		}else if(ps_base.wysiwyg_editor == 'tiny_mce'){
			
			if(	data == ''){
			
				$.each(ps_base.lang_avail, function(i, item) {
					tinyMCE.get('ck_content_' + item.lang).setContent('');
				});

			}else{
			
				$.each(ps_base.lang_avail, function(i, item) {
				
					var data_content = '';
				
					eval("data_content = data.content_" + item.lang);
				
					tinyMCE.get('ck_content_' + item.lang).setContent(data_content);

				
				});
				
			}
		}else{ // nerd mode
		
			$.each(ps_base.lang_avail, function(i, item) {
			
				var data_content = '';
				
				eval("data_content = data.content_" + item.lang);
								
				$('#ck_content_' + item.lang).val(data_content);
		
			});
		}
		
		
	},
	
	
	
	deleteblock : function(id){
	
		if (confirm("Delete this?")) {
			
			var url = "/content_blocks/admin_remote/deleteblock/" + id;
			
			$.get(url, function(data) {
				
				ps_cblockmanager._loadblocklist();
				
			});
			
		}
	
	},
	
	canceledit : function(id){

		$('#blocklist_div').slideDown(function(){
		
			$('#blockedit_div').slideUp();
					
		});
				
	
	},
	
	editblock : function(id){
	
		if(id == ""){
		

			ps_cblockmanager._autoload_wysiwyg( '' );
			
			
			$('#block_id').val("");
			$('#content_en').val("");
			$('#content_fr').val("");
			$('#cblock_javascript').val("");
			$('#cblock_css').val("");
			$('#cblock_name').val("");
			$('#cblock_template').val("");
			$('#current_edit_label').html('');
			
					
				
			$('#blockedit_div').slideDown(function(){
					
				$('#blocklist_div').slideUp();
				
			});
			
		}else{
		
			this._loadblockcontent(id);
		}
		
	
			
	
	},
	
	
	purifier_prompt : function(obj){
		
			
			if(obj.checked) $('#purifier_prompt_modal').modal();

	},
		
		
	_loadblockcontent : function(id){
	
	
		var url = "/content_blocks/admin_remote/editblock/" + id;
		
		$.getJSON(url, function(data) {
		
			if(data.error != ""){
				alert(data.error);
			}else{
			
			
				ps_cblockmanager._autoload_wysiwyg(data);
									
				$('#cblock_javascript').val( data.javascript );
				$('#cblock_css').val( data.css );
				$('#cblock_name').val( data.name );
				$('#cblock_template').val( data.template );
				
				$('#block_id').val( data.id );
				
								
				if(data.blockmobile == "Y") $("#cblock_blockmobile").attr('checked','checked')
				else $("#cblock_blockmobile").removeAttr('checked')

				ps_cblockmanager.update_current_edit_label();
				
				

				$('#blockedit_div').slideDown(function(){
					
					$('#blocklist_div').slideUp();
						
							
				});
				
									
				
			}
			
			
		});
		
	},
	
	
	
	saveblock : function(){
	
	
		var cblock_name = $('#cblock_name').val();
		var cblock_template = $('#cblock_template').val();

		if(cblock_name == ""){
		
			alert('add a name'); return;
		
		}
		
		if(cblock_template == ""){
		
			alert('select a template'); return;
		
		}
		
		$( '#ajaxLoadAni' ).slideDown( 'slow' );
				
		
		ps_cblockmanager._autosave_wysiwyg();
				
			
		var url = "/content_blocks/admin_remote/saveblock";
				
		$.post(url, $("#blockeditform").serialize(), function(data){
		
			ps_cblockmanager._loadblocklist();
			
			$( '#ajaxLoadAni' ).slideUp( 'slow' );
				
				
		
		});
				
	
	},
	
		
	
	_loadblocklist : function(){
	
	
		var url = "/content_blocks/admin_remote/loadblocklist";
		
		$('#blocklist_div').load(url, function(){
		
			$('#blocklist_div').slideDown(function(){
			
					
				$('#blockedit_div').slideUp();
					
			});
			
		
		});
		
			
	
	
	},
	
	
	update_current_edit_label : function(){
	
	
		$('#current_edit_label').html($('#cblock_name').val());
		
	
	}
	
	
	
	
	
	
	
});

var ps_cblockmanager = new pscontentblocksmanager();


$(function() {

	$( '#crudTabs' ).tabs({
		fx: { height: 'toggle', opacity: 'fadeIn' },
		
		select: function(event, ui) {
		
			if(ps_base.wysiwyg_editor == 'tiny_mce'){
								
				if(window.tinyMCE) {

					if(ui.index == 1){ // english
						
						ps_editorlang = "en";
		
					}
					
					if(ui.index == 2){ // french
					
						ps_editorlang = "fr";
				
			
					}
		
				}
								
			}
		
		}
		
	}).fadeIn();
	
	$(".markitupjavascript").markItUp(mySettings);
	
	

});
	





