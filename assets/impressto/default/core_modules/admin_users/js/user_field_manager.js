

var userfieldmanager = appbase.extend({
	
	
construct: function() {
		
		//alert(this.sortorder);
		
	},
	
	
	
	set_field_type: function(obj){
		
		// dynamically load the correct field list. If this elemetn has an id, load the linked elements
		
		var input_type = obj.value;
		var field_id = $('#field_id').val();
		
		if(field_id == "") field_id = 0;
		
		
		// swtich for the element type and hide reveal fields accordingly
		switch (input_type){
		

			case "text":
			case "email":
		
				$('#fedit_height, #fedit_onchange, #fedit_orientation, #fedit_field_value').val('').hide();
				
				$('#field_width_label').html("Width (pixels)");
				
				$('#fedit_width').show();
				
				
			break;
			
			case "textarea":
			
				$('#fedit_orientation, #fedit_onchange, #fedit_field_value').val('').hide();

				$('#field_height_label').html("Height (pixels)");
				$('#field_width_label').html("Width (pixels)");
				
				$('#fedit_width, #fedit_height').show();

			break;
			
			case "checkbox":
			
				$('#fedit_height, #fedit_width, #fedit_orientation').val('').hide();
				
				$('#field_width_label').html("Width (pixels)");
				
				$('#fedit_onchange, #fedit_field_value').show();			
		
			break;
			
			
			case "radio":
			
				$('#fedit_height, #fedit_field_value').val('').hide();

				$('#field_width_label').html("Width (columns)");
				
				$('#fedit_width, #fedit_orientation, #fedit_onchange').show();
						
				
				
				break;
				
	
			case "dropdown":
			
				$('#fedit_height, #fedit_field_value').val('').hide();

				$('#field_width_label').html("Width (pixels)");
								
				$('#fedit_width, #fedit_orientation, #fedit_onchange').show();
				
				
				
				
				break;
		
			
			case "date":
		
				$('#fedit_height, #fedit_width, #fedit_orientation, #fedit_field_value').val('').hide();
				$('#fedit_onchange').show();	
				
			break;
			
		 
		
		} 
		
		var url = "/admin_users/remote/load_field_options/" + input_type + "/" + field_id;
		
		$('#field_options_div').load(url, function(){
			
			
			$('#field_options_div').fadeIn(function(){
				
				$("#sortable_options_list").sortable();
				
				userfield_manager.initoptionsortable();
				
				
				
			});
			
		});
		
		
	},
	
	
	initoptionsortable : function(){
		
		$("#sortable_options_list").sortable({
			
update: function(event, ui) {
				
				//var optionorder = $(this).sortable('toArray').toString();
				
				var data = $(this).sortable( "serialize", { key: "option[]" } );
				
				var url = "/admin_users/remote/update_option_positions";
				
				$( '#ajaxLoadAni' ).slideDown();
				
				
				$.ajax({
type: "POST",
url: url,
data: data
				}).done(function( msg ) {
					//alert( "Data Saved: " + msg );
					
					$( '#ajaxLoadAni' ).slideUp();
					
				});
				
			}
		});
		
		
	},
	
	
	
	/**
	* Delete an option from the field options list
	*
	*/
	delete_option : function(option_id){
		
		var field_id = $('#field_id').val();
		var input_type = $('#input_type').val();
		
		
		if(field_id == "") field_id = 0;
		
		
		var url = "/admin_users/remote/delete_option/" + option_id + "/" + input_type + "/" + field_id;
		
		$('#field_options_div').load(url);
		
	},
	
	/**
	* adds a blank option to the list of options
	*
	*/  
	add_option : function(field_id){
		
		var input_type = $('#input_type').val();
		
		var count = $("#sortable_options_list li").size();
		
		var name = "option_" + (count + 1);
		var value = "value_" + (count + 1);
		
		var field_id = $('#field_id').val();
		
		if(field_id == "") field_id = 0;
		
		
		var url = "/admin_users/remote/add_field_option/" + name + "/" + value + "/" + input_type + "/" + field_id;
		
		$.ajax({
url: url,
success: function(data) {
				$('.result').html(data);
				
				$('#sortable_options_list').append(data);
				
				userfield_manager.initoptionsortable();
				
				
			}
		});


	},
	
	
	set_default_option : function(option_id){
		
		// use ajax to load the latest record list.
		
		$('#default_value').val($('#option_value_' + option_id).val());
		
		
		
		$('#sortable_options_list .defaultstar').each(function () { 
			
			/* ... */
			
			console.log($(this).attr('id'));
			
			option_default_icon_1

			if( $(this).attr('id') == "option_default_icon_" + option_id ){
				
				
				$(this).addClass('active').removeClass('inactive');
				
			}else{
				
				$(this).addClass('inactive').removeClass('active');
				
				
			}
			
		});
		
		
	},
	
	
	
	
	
	edit_user_field : function(field_id){
	
		
		var url = "/admin_users/remote/edit_userfield/" + field_id;
				
		$('#userfield_edit_div').load(url, function(){

			$('#userfield_list_div, #user_fields_main_buttons').slideUp(function(){

				$('#userfield_edit_div').slideDown();
		
		
			});
					
		});
			

	
	},
	

	delete_user_field : function(field_id){
		
		if (confirm("Delete this field?")) { 
			
			$( '#ajaxLoadAni' ).slideDown();
			
			
			$.ajax({
				type: "POST",
				url: "/admin_users/remote/delete_user_field/" + field_id,
				success: function(msg){
									
					userfield_manager.reload_user_fields();
									
						
					$( '#ajaxLoadAni' ).slideUp();
						
				
				}
			});
			
		}
		
		
	},
	

	save_field : function(){

		
		$( '#ajaxLoadAni' ).slideDown();
		
		var data = $('#field_editor_form').serialize();
		
		$.ajax({
		
			type: "POST",
			url: "/admin_users/remote/save_user_field",
			data: data,
			success: function(msg){

				if ($.trim(msg) != ''){
							
					$('.error_box').html(msg).css("display", "inline-table").fadeIn();
					$('#btn_add_new').val('Add');
					
				}else{
					
		
					$('#userfield_edit_div').fadeOut(function(){
					
						userfield_manager.reload_user_fields();
						
																	
						$('#userfield_list_div, #user_fields_main_buttons').slideDown(function(){
						
						});
			
											
						
						
					});
										
				} 
				
				$( '#ajaxLoadAni' ).slideUp();
					
			}
		
		});
		
		
	},

	
	cancel_field_edit : function(){

		
		//var url = "/contact_form/admin_remote/load_fieldlist";
		
		$('#userfield_edit_div').slideUp(function(){
			
			$('#userfield_list_div, #user_fields_main_buttons').fadeIn(function(){
			
				//ps_contact_form_manager.initdnd();
				
			});

		});
		
	},
	
	
	
	
	
	reload_user_fields : function(){
		
		var role_filter = $('#user_field_role_filter').val();
		
			
				
		var url = "/admin_users/remote/list_userfields/" + role_filter;
		
		$('#userfield_list_div').load(url, function(){
		
			$('#form_fields_div').fadeIn(); // just in case
				
			userfield_manager.initdnd();
			
		});
		
	},
	
	
	initdnd : function(){
		
		
		$('#extended_fields').tableDnD({
	
			onDrop: function(table, row) {
				
				$( '#ajaxLoadAni' ).slideDown( 'fast' );
				
				
				$.ajax({
					type: "POST",
					url: "/admin_users/remote/reorder_userfields",
					data: $.tableDnD.serialize(),
					success: function(msg){
						$( '#ajaxLoadAni' ).slideUp( 'fast' );
					}
					
				});
				
			},
			dragHandle: "dragHandle"
		});
		
		
		$("#extended_fields tr").hover(function() {
			$(this.cells[0]).addClass('showDragHandle');
		}, function() {
			$(this.cells[0]).removeClass('showDragHandle');
		});
		
		
	},
	

	init_height_slider : function(value){
		
		$("#height_slider").slider({ 

			max: 800,
			value: value,
			slide: function(event, ui) {
				
				$('#field_height').val(ui.value);
				$('#field_height_display').html(ui.value);
				
						
			}

		});
		
	},
	
		
	init_width_slider : function(value){
		
		$("#width_slider").slider({ 

			max: 400,
			value: value,
			slide: function(event, ui) {
				
				$('#field_width').val(ui.value);
				$('#field_width_display').html(ui.value);
				
						
			}

		});
		
	},
	
	set_orientation : function(obj){
	
		if(obj.value == "horizontal"){
		
			$('#fedit_width').show();
				
		}else{
		
			$('#fedit_width').hide();
		
		}
		
	
	},
	
	

	
	set_field_type: function(obj){
		
		// dynamically load the correct field list. If this elemetn has an id, load the linked elements
		
		var ftype = obj.value;
		var field_id = $('#field_id').val();
		
		if(field_id == "") field_id = 0;
		
		
		// swtich for the element type and hide reveal fields accordingly
		switch (ftype){
		

			case "text":
			case "email":
		
				$('#fedit_height, #fedit_onchange, #fedit_orientation, #fedit_field_value').val('').hide();
				
				$('#field_width_label').html("Width (pixels)");
				
				$('#fedit_width').show();
				
				
			break;
			
			case "textarea":
			
				$('#fedit_orientation, #fedit_onchange, #fedit_field_value').val('').hide();

				$('#field_height_label').html("Height (pixels)");
				$('#field_width_label').html("Width (pixels)");
				
				$('#fedit_width, #fedit_height').show();

			break;
			
			case "checkbox":
			
				$('#fedit_height, #fedit_width, #fedit_orientation').val('').hide();
				
				$('#field_width_label').html("Width (pixels)");
				
				$('#fedit_onchange, #fedit_field_value').show();			
		
			break;
			
			
			case "radio":
			
				$('#fedit_height, #fedit_field_value').val('').hide();

				$('#field_width_label').html("Width (columns)");
				
				$('#fedit_width, #fedit_orientation, #fedit_onchange').show();
						
				
				
				break;
				
	
			case "dropdown":
			case "multiselect":
			
				$('#fedit_height, #fedit_field_value').val('').hide();

				$('#field_width_label').html("Width (pixels)");
								
				$('#fedit_width, #fedit_orientation, #fedit_onchange').show();
				
				
				break;
		
			
			case "date":
		
				$('#fedit_height, #fedit_width, #fedit_orientation, #fedit_field_value').val('').hide();
				$('#fedit_onchange').show();	
				
			break;
			
		 
		
		} 
		
		var url = "/admin_users/remote/load_user_field_options/" + ftype + "/" + field_id;
		
		$('#field_options_div').load(url, function(){
			
			
			$('#field_options_div').fadeIn(function(){
				
				$("#sortable_options_list").sortable();
				
				userfield_manager.initoptionsortable();
				
				
				
			});
			
		});
		
		
	},
	
	initoptionsortable : function(){
		
		$("#sortable_options_list").sortable({
			
update: function(event, ui) {
				
				//var optionorder = $(this).sortable('toArray').toString();
				
				var data = $(this).sortable( "serialize", { key: "option[]" } );
				
				var url = "/admin_users/remote/update_field_option_positions";
				
				$( '#ajaxLoadAni' ).slideDown();
				
				
				$.ajax({
type: "POST",
url: url,
data: data
				}).done(function( msg ) {
					//alert( "Data Saved: " + msg );
					
					$( '#ajaxLoadAni' ).slideUp();
					
				});
				
			}
		});
		
		
	},
	
	
	
	
	
	

	
});




var userfield_manager = new userfieldmanager();




$(function() {

	


		
});



