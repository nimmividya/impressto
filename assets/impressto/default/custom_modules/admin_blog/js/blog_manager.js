

var psblogmanager = appbase.extend({

	
construct: function() {
		
		//alert(this.sortorder);
		
	},
	
	
	blogCtrl : function($scope){
	
    $scope.todos = [
        {text:'learn angular', done:true},
        {text:'build an angular app', done:false}];
	
	
		// start moving all the functions into here...
	
		
		$scope.newwidget = function(){
	
			$('#widget_template').val(''); 
			$('#widget_name').val(''); 
			$('#widget_id').val(''); 
		
			$('#widgetlist_mainbody_div').slideUp( function(){
				
				$('#widgetnameinput_div').slideDown();		
		
			});
			
		
		};
		
	    $scope.addTodo = function() {
			$scope.todos.push({text:$scope.todoText, done:false});
			$scope.todoText = '';
		};
		
			
	
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
	
	


	
	deletewidget: function(id){
	
		if(confirm("Delete this widget?")){
		
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
			
			// post this widget to the server 
			var url = "/admin_blog/admin_remote/deletewidget/" + id;
			
			$.post(url, function(data) {
			
				var url = "/admin_blog/admin_remote/loadwidgetlist";
				
				$('#widgets_list').load(url, function(){
				
					$( '#ajaxLoadAni' ).slideUp( 'slow' );
					
					
				});
					
			
			});
	
		}
		
	},
	

	delete_blog : function(id){
	
		
		if (confirm("Delete this item?")) {
		
			this.slowspinner();
		
		
			var category = $('#gallery_category_selector').val();
		
			var url = "/admin_blog/admin_remote/deleteblog/" + id;
		
			$.get(url, function(data) {
		
				// go back to the main list
				document.location = "/admin_blog";
								 
			});
		
		}
	
	},


	editwidget: function(id){
	
		if( id != ""){
		
			var url = "/admin_blog/admin_remote/getwidgetdata/" + id;
			
			$.getJSON(url, function(data) {
				
		
				$('#widget_template').val(data.template); 
				$('#widget_name').val(data.widget_name); 
				$('#widget_id').val(data.widget_id); 
				$('#widget_type').val(data.widget_type); 
				
				if(data.widget_type != "" && data.template != ''){
				
					$('#' + data.widget_type + '_template').val(data.template);
					$('#' + data.widget_type + '_template_selector_div').show();
					
					// hode the other one
					
		
				}
				
			
				$('#widgetnameinput_div').slideDown();
					
					
			});
			
		
			
		}
	
	
			 
		$('#widgetlist_mainbody_div').slideUp( function(){
				
			$('#widgetnameinput_div').slideDown();
		
		});
		

		
	},
	
	
	publish : function(){

		// set published state to true
		$('#blog_active').attr('checked', true);

		
		this.save_blog();
						
	
	},
	
	
	
	save_blog : function(){
		
	
		ps_blogmanager._autosave_wysiwyg();
		
		//jquery validation
		if(!$("#blogForm").valid()) return;
		
		$( '#ajaxLoadAni' ).slideDown( 'slow' );	
		
	
		var blog_id = $('#blog_id').val();
		$.ajax({
		
			type: "POST",
			url: "/admin_blog/admin_remote/save_blog",
			data: $('#blogForm').serialize(),
			success: function( data ) {
				
				$( '#ajaxLoadAni' ).slideUp( 'slow', function(){
				
					// go back to the main list
					document.location = "/admin_blog";
				
				});
													
			}
			
		});
	},
	
	
	quicksave: function (){
	
		//jquery validation
		if(!$("#blogForm").valid()) return;
			
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
					
			ps_blogmanager._autosave_wysiwyg();
					
			var blog_id = $('#blog_id').val();
			$.ajax({
				type: "POST",
				url: "/admin_blog/admin_remote/save_blog",
				data: $('#blogForm').serialize(),
				dataType: 'json',				
				success: function( data ) {
				
					if( data.blog_id != ""){

						$('#blog_id').val(data.blog_id);
						$( '#ajaxLoadAni' ).slideUp( 'slow' );
						
					}
					
				}
			
			});

		},
		
	
	cancelnewidgetedit: function(obj){
		
		$('#widgetnameinput_div').slideUp( function(){
				
			//ps_blogmanager.loadwidgetlist();
			
			$('#blogarticle_template_selector_div').hide();
			$('#blogticker_template_selector_div').hide();
			
				
			$('#widgetlist_mainbody_div').slideDown();
		
		});
		

		


	},


	
	
	loadwidgetlist : function(){
	
		var url = "/admin_blog/admin_remote/loadwidgetlist";
		
		$('#widgets_list').load(url);
		
	
	
	},
	


	
	
	switch_new_widget_type : function(obj){
	
		if( obj.value != ""){
		
		
			if(obj.value == "blogarticle"){
			
				$('#blogarticle_template_selector_div').show();
				$('#blogticker_template_selector_div, #blogarchive_template_selector_div').hide();
				$('#blogticker_template').val('');
				
			}else if(obj.value == "blogarchive"){

				$('#blogarchive_template_selector_div').show();
				$('#blogarticle_template_selector_div, #blogarticle_template_selector_div').hide();
				$('#blogarchive_template').val('');

			}else{

				$('#blogticker_template_selector_div').show();
				$('#blogarticle_template_selector_div, #blogarchive_template_selector_div').hide();
				$('#blogarticle_template').val('');
				

			}
		
	
			
		
			
		}
	
	
	
	},
	





	savewidget : function(){
		
		var widget_type = $('#widget_type').val();
		
		
		if(widget_type == "") return;
				
		if(widget_type == "blogarticle" && $('#blogarticle_template').val() == "") return; 
		if(widget_type == "blogticker" && $('#blogticker_template').val() == "") return; 
		if($('#widget_name').val() == "") return; 
		
		
		
				
		var data = $('#blog_widget_form').serialize();
		
		// post this widget to the server 
		var url = "/admin_blog/admin_remote/savewidget";
		
			
		$.ajax({
			type: 'POST',
			url: url,
			dataType: 'json',
			data: data,
			success: function(data){
		  
				$('#widget_id').val(data.widget_id);
								
				ps_blogmanager.loadwidgetlist();
				
				$('#widgetnameinput_div').slideUp( function(){
				
				
					$('#blogarticle_template_selector_div').hide();
					$('#blogticker_template_selector_div').hide();
	
				
					var url = "/admin_blog/admin_remote/loadwidgetlist";
					
					$('#widgets_list').load(url, function(){
					
						$('#widgetlist_mainbody_div').slideDown();
					
					});
		
										
				});
		
			}

		});
	
	
	},
	
	
	
		toggle_searchfields : function(obj){
		
			if( $('#' + obj.id).is(':checked') ){
			
				$('#search_fields_div').show();
				
			}else{

				$('#search_fields_div').hide();
		
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
	
	
	
	savesettings : function(){
	
		// post this widget to the server 
		var url = "/admin_blog/admin_remote/savesettings";
		
		var data = $('#blog_settings_form').serialize();
		
		this.slowspinner();
				
	
		
		$.ajax({
			type: 'POST',
			url: url,
			data: data,
			success: function(data){
		  
				
			}

		});
	
	
	},
	
	toggle_active: function (id){
	
		var img_path = ps_base.asseturl + ps_base.appname + "/default/core/images/actionicons/";
	
		var is_active = $('#active_toggle_' + id).attr('is_active');

				 
		if(is_active == 1){
		
			$('#active_toggle_img_' + id).attr("src", img_path + 'checkbox_cross.gif');
			$('#active_toggle_' + id).attr('is_active', '0');
					

		}else{
		
			$('#active_toggle_img_' + id).attr("src", img_path + 'checkbox_check.gif');
			$('#active_toggle_' + id).attr('is_active', '1');

		}	

		var url = "/admin_blog/admin_remote/toggle_active/" + id + "/" + is_active;	
		
		$.get(url, function(data) {
			 // alert('Load was performed.');
		});

	
	},
	
	toggle_archived: function (id){
	
		var img_path = ps_base.asseturl + ps_base.appname + "/default/core/images/actionicons/";
	
		var is_archived = $('#archived_toggle_' + id).attr('is_archived');

				 
		if(is_archived == 1){
		
			$('#archived_toggle_img_' + id).attr("src", img_path + 'checkbox_cross.gif');
			$('#archived_toggle_' + id).attr('is_archived', '0');
					

		}else{
		
			$('#archived_toggle_img_' + id).attr("src", img_path + 'checkbox_check.gif');
			$('#archived_toggle_' + id).attr('is_archived', '1');

		}	

		var url = "/admin_blog/admin_remote/toggle_archived/" + id + "/" + is_archived;	
		
		$.get(url, function(data) {
			 // alert('Load was performed.');
		});

	
	},
	
	/**
		* Make sure the selected file is an image before trying to display it
 		*
		*/
		updatefeaturedimage : function(target, lang){
		
						
			var filename = $('#' + target + '_' + lang).val();
		
			var ext = filename.split('.').pop();
			
			ext = ext.toLowerCase();
						
			if(ext == "png" || ext == "gif" || ext == "jpg" || ext == "jpeg"){
						
				$('#' + target + '_preview_' + lang).attr('src', filename).show();
				$('#remove_' + target + '_button_' + lang).show();
								
					
			}else{
				
				$('#' + target + '_' + lang).val('');
				$('#' + target + '_preview_' + lang).hide();
				
			}
			
		
		},
		
		remove_featured_image : function(lang){
		
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
			
			var blog_id = $('#blog_id').val();
			
			if(blog_id == "") return;
					
			var url = "/admin_blog/admin_remote/remove_featured_image/" + blog_id + "/" + lang;
			
						
			$.get(url, function(data) {
			
				$('#featured_image_preview_' + lang).hide();
				$('#featured_image_' + lang).val('');
							
				$('#remove_featured_image_button_' + lang).hide();				
							
				$( '#ajaxLoadAni' ).slideUp( 'slow'); 
				
			});
			
		}
		
		
	
	
	
	
	
});






var ps_blogmanager = new psblogmanager();


$(function() {
	$( '#crudTabs' ).tabs({
		fx: { height: 'toggle', opacity: 'fadeIn' }
	}).fadeIn();
	
	
	$( "#publish_date_en, #publish_date_fr" ).datepicker({ dateFormat: "yy-mm-dd" });
	
	$('.featured_image_button').popupWindow({ 
					
		windowName:'elfinder', 
		height:500, 
		width:800, 
		centerBrowser:1
	});

	$('.remove_featured_image_button').click(function() { 

		var lang = $(this).data("lang");
						
		ps_blogmanager.remove_featured_image(lang);
		
							
	});
	
});
	
	
//angular bootstrapping starts here 
var app = angular.module('admin_blog', ['ngResource']);


	

	
