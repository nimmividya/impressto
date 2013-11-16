
var pscontenteditor = appbase.extend({

	quickupdate : false,
	language : '',
	wysiwyg_editor : 'none',
				
				
	popwin_settings : { 
			
				"centerBrowser" : 1, // center window over browser window? {1 (YES) or 0 (NO)}. overrides top and left
				"centerScreen" : 1, // center window over entire screen? {1 (YES) or 0 (NO)}. overrides top and left
				"height" :800, // sets the height in pixels of the window.
				"left" :0, // left position when the window appears.
				"location" :0, // determines whether the address bar is displayed {1 (YES) or 0 (NO)}.
				"menubar" :0, // determines whether the menu bar is displayed {1 (YES) or 0 (NO)}.
				"resizable" :0, // whether the window can be resized {1 (YES) or 0 (NO)}. Can also be overloaded using resizable.
				"scrollbars" :0, // determines whether scrollbars appear on the window {1 (YES) or 0 (NO)}.
				"status" :0, // whether a status line appears at the bottom of the window {1 (YES) or 0 (NO)}.
				"width" :1000, // sets the width in pixels of the window.
				"windowName" : "PS Preview", // name of window set from the name attribute of the element that invokes the click
				"top" :0, // top position when the window appears.
				"toolbar" : 0 // determines whether a toolbar (includes the forward and back buttons) is displayed {1 (YES) or 0 (NO)}.
			
	},
				
		
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
					
				
	savecurrent: function(){
		
			this.process_save();
		
		},
			
		
		publish : function(){
				
			$('#CO_Active').val('1');
									
			this.process_save();
				
		},
			
		
		unpublish : function(){
		
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
			
			var state = 0;
			
			//if (obj.checked == 1) state = 1;
			
		
			var url = "/page_manager/setpublishedstate/" + this.language + "/" + $('#page_id').val() + "/" + state;
				
						
			$.get(url, function(data) {
			
				// now reveal the publish button, hide the save live button and hide the unpublish button
				$('#unpublish_button').hide();
				$('#savecurrent_button').hide();
				$('#publish_button').show();
				
				$( '#ajaxLoadAni' ).slideUp( 'slow' );
											
			});			
		
		},
				
		
			
		revertprompt : function(){
				
			var node_id = $('#page_id').val();
						
			var url = "/page_manager/getarchivelist/" + node_id + "/" + this.language;
						
			$.get(url, function(data) {
				
				$('#restore_dialog').html(data);
				
			
				$( "#restore_dialog" ).dialog( "open" );
							
			});
							
		},
		
		
		purifier_prompt : function(obj){
		
			
			if(obj.checked) $('#purifier_prompt_modal').modal();

		},
		

		/*
		popupwindow : function(settings){
				
			var windowFeatures = 'height=' + settings.height +
								',width=' + settings.width +
								',toolbar=' + settings.toolbar +
								',scrollbars=' + settings.scrollbars +
								',status=' + settings.status + 
								',resizable=' + settings.resizable +
								',location=' + settings.location +
								',menuBar=' + settings.menubar;
								
				
			var centeredY,centeredX;
			
			
			if(settings.centerBrowser){
						
				if ($.browser.msie) {//hacked together for IE browsers
					centeredY = (window.screenTop - 120) + ((((document.documentElement.clientHeight + 120)/2) - (settings.height/2)));
					centeredX = window.screenLeft + ((((document.body.offsetWidth + 20)/2) - (settings.width/2)));
				}else{
					centeredY = window.screenY + (((window.outerHeight/2) - (settings.height/2)));
					centeredX = window.screenX + (((window.outerWidth/2) - (settings.width/2)));
				}
				
				window.open(settings.windowURL, settings.windowName, windowFeatures+',left=' + centeredX +',top=' + centeredY).focus();
				
			}else if(settings.centerScreen){
				centeredY = (screen.height - settings.height)/2;
				centeredX = (screen.width - settings.width)/2;
				window.open(settings.windowURL, settings.windowName, windowFeatures+',left=' + centeredX +',top=' + centeredY).focus();
			}else{
				window.open(settings.windowURL, settings.windowName, windowFeatures+',left=' + settings.left +',top=' + settings.top).focus();	
			}
			
		
		
		},
		
		*/
		
		/**
		* simply highlight the row so we know what page it is when we come back
		*
		*/
		preview_archive : function(id){
		
			this.popwin_settings.windowURL = this.language + "/archive_preview::" + id;
			
			this.popupwindow(this.popwin_settings);
					
			var rows = $("#archive_list_table tr:gt(0)"); // skip the header row
		
			rows.each(function(index) {
			
				$(this).css("background", "#FFFFFF");
		
			});
								
			$('#archiverow_' + id).css("background", "#C9DFEA");
					
							
		},
		

		
		preview_draft : function(){
		
		
			var node_id = $('#page_id').val();
				
			this.popwin_settings.windowURL = this.language + "/draft_preview::" + node_id;

			this.popupwindow(this.popwin_settings);
			
	
		},
		
		revert_archive : function(){
	
			var node_id = $('#page_id').val();
			
			var url = "/page_manager/getarchivelist/" + node_id + "/" + this.language;
						
			$.get(url, function(data) {
				
				$('#restore_dialog').html(data);
				
				$( "#restore_dialog" ).dialog( "open" );
							
			});

							
		},
		
		
		reset_draft : function(){
		
			var url = "/page_manager/reset_draft/" + id + "/" + this.language;
						
			$.get(url, function(data) {
				
				
				if(data == 'OK'){
				
					$( "#restore_dialog" ).dialog( "close" );
				
					// now reload this page/
					location.reload(true);
					
				}else{
				
					alert('Error resetting draft');
					
				}
				
			});
							
		
		},
		
		
		
		restore_archive : function(id){
		
			// populate the dialog box with the archive list first
			
			var url = "/page_manager/restore_archive/" + id + "/" + this.language;
						
			$.get(url, function(data) {
				
				//$('#restore_dialog').html(data);
				
				//alert('Load was performed.');
				
				if(data == 'OK'){
					$( "#restore_dialog" ).dialog( "close" );
					
					// now reload this page with cache turned off (true)/
					location.reload(true);
					
					
				}else{
				
					alert('Error restoring page');
					
				
				}
				
					
							
			});

							
		},
		

		quicksave: function(){
		
			pscontentedit.quickupdate = true;
		
			this.process_save();
				
		},
		
		
		process_save: function(redirect){
		
		
			if( $('#aliasing').attr('checked') ){
			
			
				if( $('#externalLink').val() == ""){
				
					alert('You must select a link');
					$('#externalLink').focus();
					return;
					
									
					
				}
				

				
			
			}else{
			
				// do some other validation checks here.
						
			}
		

			// always required
			if($('#seoTitle').val() == ""){
					
					alert('You must set the title for this page');
					$('#seoTitle').focus();
					return;
					
			}
				
			// need a conditional here to determine which WYSIWYG editor is in use
			
			pscontentedit._autosave_wysiwyg();
						
				
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
				
				var url = "/page_manager/save";
	
				$.ajax({
					url: url,
					type: 'POST',
					data: $('#content_edit_form').serialize(),
					dataType: 'json',
					success: function( data ) {
					
						$('#page_id').val(data.node_id);										
				
						$( '#ajaxLoadAni' ).slideUp( 'slow', function(){
							
							// peter temporary hack
							
							if(pscontentedit.quickupdate == false){
								document.location = "/page_manager/index/" + $('#content_lang').val() + "/";
							}
							
							pscontentedit.quickupdate = false;
																		
						
						});
					
			
					}
				});
						
		},
		
		
		savedraft : function(){
		
		
			if( $('#aliasing').attr('checked') ){
			
				if( $('#externalLink').val() == ""){
				
					alert('You must select a link');
					$('#externalLink').focus();
					return;
									
					
				}
			
			} 
		
			pscontentedit._autosave_wysiwyg();
			
				
			
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
				
			var url = "/page_manager/savedraft";
	
			jQuery.ajax({
				url: url,
				type: 'POST',
				data: $('#content_edit_form').serialize(),
				dataType: 'json',
				success: function( data ) {
			
					//console.log(data.node_id);
					
					$('#page_id').val(data.node_id);
					
								
					$( '#ajaxLoadAni' ).slideUp( 'slow' );
					
					$('#preview_button_listitem').fadeIn();
					
					
					
			
				}
			});
	
	
		
		},
		
		
		savewarning : function(){
		
			if(confirm('When you click Save and Publish, this page will be live; this action cannot be undone.  If you are unsure, click Save to save the content until ready for publishing.  Continue?')){
			
						
				$('#content_edit_form').submit();

		
			}
		
		},
		
		
		
		init_priority_slider : function(value){
		

			$("#search_priority_slider").slider({ 

			max: 10,
			value: value,
			slide: function(event, ui) {
				
				$('#search_priority_val').val(ui.value);
				$('#search_priority_display').html(ui.value);
				
						
			}

		});
		
	},
	
	
		init_change_frequency_slider : function(value){
		
			var change_frequency_tag = "";
			
			
			$("#change_frequency_slider").slider({ 

			max: 4,
			value: value,
			slide: function(event, ui) {
				
				$('#change_frequency_val').val(ui.value);
				
				switch(ui.value){
				
					case 0 : change_frequency_tag = "hourly";
					break;
					case 1 : change_frequency_tag = "daily";
					break;
					case 2 : change_frequency_tag = "weekly";
					break;
					case 3 : change_frequency_tag = "monthly";
					break;
					case 4 : change_frequency_tag = "yearly";
					break;
				}
				
				$('#change_frequency_display').html(change_frequency_tag);
				
						
			}

		});
		
	},
	
	
	

		
		toggle_aliasing : function(obj){
		
			if(obj.checked){
		
				$("#crudTabs").tabs({disabled: [1,2]});

				$('#widget_selector_div').slideUp( function(){
				
					$('#aliasing_wrapper_div').slideDown();
					
					$('#extended_js_css_div').fadeOut();
					
								
				});
				
				
			}else{

				$('#crudTabs').tabs('enable', 1);
				$('#crudTabs').tabs('enable', 2);
				
				$('#aliasing_wrapper_div').slideUp( function(){
				
					$('#externalLink').val('');				
				
					$('#widget_selector_div').slideDown();
					
					$('#extended_js_css_div').fadeIn();
					
					
				});
				
				
				
			}
				
		
		},
		
		/**
		* Make sure the selected file is an image before trying to display it
 		*
		*/
		updatefeaturedimage : function(target){
		
			var filename = $('#' + target).val();
		
			var ext = filename.split('.').pop();
			
			ext = ext.toLowerCase();
						
			if(ext == "png" || ext == "gif" || ext == "jpg" || ext == "jpeg"){
						
				$('#' + target + '_preview').attr('src', filename).show();
				$('#remove_' + target + '_button').show();
								
					
			}else{
				
				$('#' + target).val('');
				$('#' + target + '_preview').hide();
				
			}
			
		
		}
		
	
		
		
	});
	
var pscontentedit = new pscontenteditor();




$(function() {


	$( '#crudTabs' ).tabs({
		fx: { height: 'toggle', opacity: 'fadeIn' }
	}).fadeIn();
	
	$(".markitupjavascript").markItUp(mySettings);
	

	$(".color-picker").miniColors({
		letterCase: 'uppercase',
		change: function(hex, rgb) {
			//logData(hex, rgb);
		}
	});
	
	$('#CO_externalLink_button').popupWindow({ 
					
		windowURL:'/file_browser/?ajpx_targetfield=externalLink', 
		windowName:'elfinder', 
		height:500, 
		width:800, 
		centerBrowser:1
	});
	
	
	$('#featured_image_button').popupWindow({ 	
					
		windowURL:'/file_browser/?ajpx_targetfield=featured_image&callback=pscontentedit.updatefeaturedimage(\'featured_image\')', 
		windowName:'elfinder', 
		height:500, 
		width:800, 
		centerBrowser:1
	});
	
	$('#remove_featured_image_button').click(function() { 
	
		pscontentedit.remove_featured_image('standard');
		
	
							
	});
	
	
	$('#mobile_featured_image_button').popupWindow({ 
					
		windowURL:'/file_browser/?ajpx_targetfield=mobile_featured_image&callback=pscontentedit.updatefeaturedimage(\'mobile_featured_image\')', 
		windowName:'elfinder', 
		height:500, 
		width:800, 
		centerBrowser:1
	});
	
	$('#remove_mobile_featured_image_button').click(function() {
			
		pscontentedit.remove_featured_image('mobile');
		
	});
	

			
	$(".uni_style").uniform();
	
	$('#seoTitle').wysihtml5();
		
	

	
		
});

