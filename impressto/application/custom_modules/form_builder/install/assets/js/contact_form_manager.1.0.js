 
var psform_buildermanager = appbase.extend({

	
construct: function() {
		
		//alert(this.sortorder);
		
	},
	
	
	showrecords : function(){
	
	
		// use ajax to load the latest record list.
	
	},
	
	

	
	
	save_settings: function(){
		
			var datas = $('.settings_box').serialize();
	
		$('#btn_save_settings').val('Saving. . .');
		
		$.ajax({
		   type: "POST",
		   url: "/form_builder/admin_remote/save_settings",
		   data: datas,
		   success: function(msg){
			 
			// location.reload();
			 
			$('#form_settings_div').slideUp(function(){
		
				$('#form_fields_div').slideDown();
		
			});
		
		   }
		 });
		 
		 
	},
	
	
	edit_field : function(field_id){

		// get json call to retreive all the settings....
		
		var url = "/form_builder/admin_remote/edit_field/" + field_id;
		
		$('#field_edit_div').load(url, function(){

			$('#form_fields_div').slideUp(function(){
			
	
				$('#field_edit_div').slideDown();
		
			});
				
		});
				
		
	},
	
	
	set_field_type: function(obj){
	
		// dynamically load the correct field list. If this elemetn has an id, load the linked elements
		
		var ftype = obj.value;
		var field_id = $('#field_id').val();
		
		if(field_id == "") field_id = 0;
		
		
		
		var url = "/form_builder/admin_remote/load_field_options/" + ftype + "/" + field_id;
		
		$('#field_options_div').load(url, function(){
		
		
			$('#field_options_div').fadeIn();
		
		});
				
	
	},
	
	
	/**
	* Delete an option from the field options list
	*
	*/
	delete_option : function(option_id){
	
		var field_id = $('#field_id').val();
		var ftype = $('#ftype').val();
		
			
		if(field_id == "") field_id = 0;
		
		
		var url = "/form_builder/admin_remote/delete_option/" + option_id + "/" + ftype + "/" + field_id;
		
		$('#field_options_div').load(url);
	
	},
	
	/**
	* adds a blank option to the list of options
	*
	*/  
	add_option : function(field_id){
	
		var ftype = $('#ftype').val();
					
		var count = $("#sortable_options_list li").size();
			
		var name = "option_" + (count + 1);
		var value = "value_" + (count + 1);
				
		var field_id = $('#field_id').val();
		
		if(field_id == "") field_id = 0;
		
		
		var url = "/form_builder/admin_remote/add_field_option/" + name + "/" + value + "/" + ftype + "/" + field_id;
		
		$('#field_options_div').load(url);
	
	},
	
	
	save_field : function(){
	
		var data = $('.add_new_field').serialize();
		$('#btn_add_new').val('Working. . .');
			
		$.ajax({
		   type: "POST",
		     url: "/form_builder/admin_remote/save_field",
			data: data,
			success: function(msg){
   
				if ($.trim(msg) != ''){
				
	
					$('.error_box').html(d).css("display", "inline-table").fadeIn();
					$('#btn_add_new').val('Add');
	
				}else{
				
		
					var url = "/form_builder/admin_remote/load_fieldlist";
					$('#form_fields_div').load(url, function(){
					
						alert('huh');
					
						$('#form_fields_div').fadeIn();
						ps_formbuilder_manager.initdnd();
						
						$('#field_edit_div').fadeOut();
						
							
						$('.add_new_field').fadeOut(function(){
						
												
			
							
							
						});

					});
				}     
			}
		});
 
 
	
	},
	
	cancel_field_edit : function(){
	
		var url = "/form_builder/admin_remote/load_fieldlist";
					
		$('.add_new_field').fadeOut(function(){
					
			$('#form_fields_div').fadeIn(function(){
			

				ps_formbuilder_manager.initdnd();
				
			});

		});
	
	},
	
	
	save : function(){
	
	
			var datas = $('.add_new_field').serialize();
		$('#btn_add_new').val('Working. . .');
$.ajax({
   type: "POST",
   url: "/form_builder/admin_remote/save",
   data: datas,
   success: function(d){
   
		if ($.trim(d) != ''){
		
			$('.error_box').html(d).css("display", "inline-table").fadeIn();
			$('#btn_add_new').val('Add');
	
		}else{
		
			var url = "/form_builder/admin_remote/load_fieldlist";
			$('#form_fields_div').load(url, function(){
			

			
				$('.add_new_field').fadeOut(function(){
				
					ps_formbuilder_manager.initdnd();
				
				});

			
			});
				
	
	
		}     
   }
 });
 
 
	
	
	},
	
	
	
	update_enabled : function(obj, field_id){
	
		var enabled = 0;
		if(obj.checked) enabled = 1;
		
		$.ajax({
			type: "GET",
			url: "/form_builder/admin_remote/update_enabled",
			data: {enabled: enabled, field_id: field_id},
			success: function(msg){
			
				//alert('hi');
				//location.reload(true);
			}
	 });
	 
		
		
	
	},
	
	update : function(){
	
		$('.success').hide();
		var data_saved = $(".settings").serialize();
		$('.loading').fadeIn();
		$('.error').hide();
		$.ajax({
		   type: "POST",
		   url: "/form_builder/admin_remote/update",
		   data: data_saved,
		   success: function(d){
				$('.loading').fadeOut('slow', function() {
					$('.success').fadeIn();
				  });
				setTimeout(function(){
					$('.success').fadeOut();
				}
			  , 2000);

		   }
		});
		return false;
		
		
	
	},
	
	delete_field : function(field_id){
	
		if (confirm("Delete this field?")) { 
		
			$( '#ajaxLoadAni' ).slideDown();
					
		
			$.ajax({
				type: "POST",
				url: "/form_builder/admin_remote/delete_field/" + field_id,
				success: function(msg){
					
					var url = "/form_builder/admin_remote/load_fieldlist";
					
					$('#form_fields_div').load(url, function(){
			
						ps_formbuilder_manager.initdnd();
						
						$( '#ajaxLoadAni' ).slideUp();
				
					});

				}
			});
			
		}
	
	
	},
	
	initdnd : function(){
	
	
    $('#form_fields').tableDnD({
	
        onDrop: function(table, row) {
		
			$( '#ajaxLoadAni' ).slideDown( 'fast' );
			
		
	$.ajax({
	   type: "POST",
	   url: "/form_builder/admin_remote/update",
	   data: $.tableDnD.serialize(),
	   
	   success: function(msg){
			$( '#ajaxLoadAni' ).slideUp( 'fast' );
	   }
	   
	 });
		
        },
	dragHandle: "dragHandle"
    });
	
	
	$("#form_fields tr").hover(function() {
          $(this.cells[0]).addClass('showDragHandle');
    }, function() {
          $(this.cells[0]).removeClass('showDragHandle');
    });
	
	
	}
	
	
	
	
	
	
});



var ps_formbuilder_manager = new psform_buildermanager();




$(function() {


	
	
});
	






	
	
	
 
 $(function() {
    $('.error').hide();
	$('.success').hide();
	$('.loading').hide();
	$('.add_new_field').hide();
    $("#btn_save").click(function() {
		
		
		ps_formbuilder_manager.update();
		
		
	
			 


    });
	



	$('#btn_settings').click(function(){
	
		$('#form_fields_div').slideUp(function(){
		
			$('#form_settings_div').slideDown();
		
		});
		
	});
	
	$('#btn_add_new').click(function(){
	
	
		ps_formbuilder_manager.save();
		
	
	

	});	
	
	
	
	
	
	$('#btn_records').click(function(){
	
		ps_formbuilder_manager.showrecords();
		
	});
	
		
	
	$('#btn_save_settings').click(function(){
	
	
		ps_formbuilder_manager.save_settings();
		
		
	});	
	
	

	
  });
 	
	
$(document).ready(function() {
	
	
	ps_formbuilder_manager.initdnd();
	

	$( '#crudTabs' ).tabs({
		fx: { height: 'toggle', opacity: 'fadeIn' }
	}).fadeIn();

	/*
    $(".new_field_type").change(function () {
		var field_type = $(".new_field_type option:selected").val()
			switch(field_type){
			case "checkbox":
			case "radio":
			case "dropdown":
				$('#d_field').html('Write the options for your '+field_type+' [ <i>one per line</i> ]<br>');
				$('#d_field').fadeIn();
				$('#field_options').fadeIn();
			break;
			default:
				$('#d_field').fadeOut();
				$('#field_options').fadeOut();
			}
        })
	
	*/
	
}); 