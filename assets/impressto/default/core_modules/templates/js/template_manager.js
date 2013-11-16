var pstemplatemanager = appbase.extend({

	current_module : '',
	

	construct: function() {
	

		
		
	},
		
	
	
	populate_widgetlist: function(module){
	
		var lang = $('#lang_filter').val();
		var module = module;
		var widget = $('#widget_filter').val();
		var device = $('#device_filter').val();
		
		
		var url = "/templates/admin_remote/widget_selectorlist/?lang=" + lang + "&module=" + module + "&widget=" + widget + "&device=" + device;
		
	
		ps_templatemanager.current_module = module;
		
	
		
		$.getJSON(url, function(data) {
	
			var options = '<option value="">Select</option>';
			for (var i = 0; i < data.length; i++) {
				options += '<option value="' + data[i].name + '">' + data[i].desc_name + '</option>';
			}
			$("#widget_filter").html(options);
    
		});
		
		
		
	},
	
	change_module : function(){
	
		var widget = $('#widget_filter').val('');
		var device = $('#device_filter').val('');
					
		ps_templatemanager.apply_filter();
	
	
	},
	
	
	
	apply_filter : function(){
	
		var lang = $('#lang_filter').val();
		
		if(lang == "") return;
		
		
		var module = $('#module_filter').val();
		var widget = $('#widget_filter').val();
		var device = $('#device_filter').val();
		
		
		var url = "/templates/admin_remote/listtemplates/?lang=" + lang + "&module=" + module + "&widget=" + widget + "&device=" + device;
				
		$.get(url, function(data){
							
			$('#template_list_div').html(data);	
						
			if(ps_templatemanager.current_module != module) ps_templatemanager.populate_widgetlist(module);
			
			
			$('#template_list_div').slideDown();
				
		});
		
		
	
	},
	
	
	edittemplate : function(filepath){
	
		$( '#ajaxLoadAni' ).slideDown( 'slow' );
		
		$('#template_filters_div').fadeOut();
		$('#versioncontrol_alert').fadeOut();	

		var lang = $('#lang_filter').val();
			
		
		$('#template_list_div').slideUp(function(){
				
			
			//ajax call loads up the content into the editor
			var url = "/templates/admin_remote/edit_template";

			$.ajax({
				type: "POST",
				url: url,
				data: "template=" + filepath + "&lang=" + lang,
				dataType: "json"
			}).done(function( data ) {
	
						
				$('#template_standard_content').val(data.templatecontent);
				$('#template_filename').val(data.template_data.Filename);
				$('#template_filepath').val(data.template_data.filepath);
				$('#template_lang').val(data.template_data.Lang);	
				$('#template_name').val(data.template_data.Name);
				$('#template_docket').val(data.template_data.Docket);
				$('#template_author').val(data.template_data.Author);
				$('#template_status').val(data.template_data.Status);
				$('#template_date').val(data.template_data.Date);
				$('#template_type').val(data.template_data.Type);
				$('#template_description').val(data.template_data.Description);
				
				$('#smartybox').slideDown();
				
				$( '#ajaxLoadAni' ).slideUp( 'slow' );
				
					
					
			});
		
		});
		
		
	},
	
	
	deletetemplate : function(filepath){
	
		if (confirm("Delete this template?")) {
		
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
			
			var url = "/templates/admin_remote/delete_smarty_template";

			$.ajax({
				type: "POST",
				url: url,
				data: "template=" + filepath
			}).done(function( data ) {
	
		
				ps_templatemanager.apply_filter();
				
				$( '#ajaxLoadAni' ).slideUp( 'slow' );
				
			
					
			});
			
			
		}
		
		
	},
	
	
	
	
	select_widget_type: function (obj) {
	

		
	
	},
	
	
	quicksavetemplate : function(){

	
		$( '#ajaxLoadAni' ).slideDown( 'slow' );
					
		
		//ajax call loads up the content into the editor
		var url = "/templates/admin_remote/savetemplate";

		$.ajax({
			type: "POST",
			url: url,
			data: $('#template_form').serialize()	
		}).done(function( msg ) {
		
			$( '#ajaxLoadAni' ).slideUp( 'slow' );
				
		
		});
		
	
	
	
	},
	
	
	savetemplate : function(){
	
	
		$( '#ajaxLoadAni' ).slideDown( 'slow' );
					
		
		//ajax call loads up the content into the editor
		var url = "/templates/admin_remote/savetemplate";

		$.ajax({
			type: "POST",
			url: url,
			data: $('#template_form').serialize()	
		}).done(function( msg ) {
	

			$('#template_standard_content').val('');
			$('#template_filename').val('');
			$('#template_filepath').val('');
			$('#template_name').val('');
			$('#template_docket').val('');
			$('#template_author').val('');
			$('#template_status').val('');
			$('#template_date').val('');
						
			
			$('#smartybox').slideUp();
			
			
			ps_templatemanager.apply_filter();
			
			$('#template_filters_div').fadeIn();
			
			$( '#ajaxLoadAni' ).slideUp( 'slow' );
			
			

					
		});
		
		
	
	
	},
	
	
	shownewsmartybox : function(){
	
		$('#template_list_div').slideUp(function(){
		
			$('#smartycontent').val('');
			$('#smarty_filename').val('');
			$('#smarty_filepath').val('');
			$('#smarty_name').val('');
			$('#smarty_docket').val('');
			$('#smarty_author').val('');
			$('#smarty_status').val('');
			$('#smarty_date').val('');
		
			
			$('#smartybox').slideDown();
			
		
		});

	
	
	},
	

	
	canceledit: function(){
	
		$('#smartybox').slideUp(function(){

			$('#template_list_div').slideDown();
			
			$('#template_filters_div').fadeIn();
				
				
		
		});
		

					
	
	},
	
	


});
	
var ps_templatemanager = new pstemplatemanager();
	
$(document).ready(function() {

		$( '#crudTabs' ).tabs({
			fx: { height: 'toggle', opacity: 'toggle' }
		}).fadeIn();
		
		
		$("#template_standard_content").markItUp(mySettings);
		
		
		$('#template_list_div').slideDown();
		
				

});