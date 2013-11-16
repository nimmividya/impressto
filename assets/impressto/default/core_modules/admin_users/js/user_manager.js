

var psusermanager = appbase.extend({
	
	
construct: function() {
		
		//alert(this.sortorder);
		
	},
	
	edit_role : function(id){
	

		var url = "/admin_users/remote/edit_role/" + id;
		
		
		$.getJSON(url, function(data) {
		
			if(data.error == ""){
			
				$('#role_description').val(data.description);
				$('#role_id').val(data.id);
				$('#role_name').val(data.name);
				
				$('#role_theme').val(data.role_theme);
				$('#profile_template').val(data.profile_template);
				
				$('#dashboard_page').val(data.dashboard_page);
				$('#dashboard_template').val(data.dashboard_template);
	
						
				
				//$('#add_role_btn_div').hide();
				//$('#role_edit_div').slideDown();
				
				$('#roleEditModal').modal();
					
				
		
			}else{ 
			
				alert(data.error);	
			}
			
			
		});
		

		

				
	
	},
	
	
	role_fields : function(role_id){
	
		// should reemotely populate the user fields here since they may have
		// changed sie the last page load
		
		var url = "/admin_users/remote/edit_role_assignment/" + role_id;
		
		
		$.getJSON(url, function(data) {
		
			if(data.error == ""){
			
			var optionsAsString = "";
			
		
			$.each(data, function(key, value){
		
				//if(key != "error") optionsAsString += "<option value='" + value + "'>" + key + "</option>";
					
		
			});
			
			$.each(data, function(key, value){
			
				if(key != "error"){
				
					optionsAsString += "<option value='" + value.field_id + "'";

					if(value.selected == 1) optionsAsString += " selected "; 
					
					optionsAsString +=  ">" + key + "</option>";
					
				}
			});


			
			$('#roleuserfield-modal-options' ).append( $( optionsAsString ) );
			
			$('#roleuserfield-modal-options').multiSelect({
				selectableHeader: "<div class='custom-header'>User Fields</div>",
				selectionHeader: "<div class='custom-header'>Assigned to Role</div>"
			});
				
			
			$('#roleuserfieldEditModal').modal();
				
			
			}else{
			
				alert(data.error);
			}
				/*
			
			
				$(data).each(function(idx, obj){ 
					$(obj).each(function(key, value){
						console.log(key + ": " + value);
					});
				});
				
		
				$('#roleEditModal').modal();
				
			
				$('#roleuserfield-modal-options').multiSelect({
					selectableHeader: "<div class='custom-header'>User Fields</div>",
					selectionHeader: "<div class='custom-header'>Role</div>"
				});
		
				$('#roleuserfieldEditModal').modal();
				
			
			}
			*/
		});
	
	},
	
	
	
	change_dashboard : function(obj){
	
		//if(obj.value != ""){
		//	if(obj.id == 'dashboard_template') $('#dashboard_page').val('');
		//	else $('#dashboard_template').val('');
		//}
	},
	
	

	save_role : function(){
	
		var url = "/admin_users/remote/save_role";
					
		$.post(url, $("#role_edit_form").serialize(), function(){
				
			$('#role_record_div').load("/admin_users/remote/list_roles");
				
			$('#role_edit_div').slideUp();
			
			$('#add_role_btn_div').show();
			
		
		});


		
	},
	
	cancel_role_edit : function(){

		$('#role_edit_div').slideUp();
		
		$('#add_role_btn_div').show();
		
		
		
	

		
	},
	
	
	
	add_role : function(){
	
		$('#role_description').val('');
		$('#role_id').val('');
		$('#role_name').val('');
				
				
		//$('#add_role_btn_div').hide();
	
		//$('#role_edit_div').slideDown();	
		
		$('#roleEditModal').modal();
			



		
				
	
	},
	
	
	delete_role : function(id){
	
	
		var deleteme = confirm("Delete this record?")
		
		if (deleteme){
			$('#role_record_div').load("/admin_users/remote/delete_role/" + id);
		}	
			
	
	},
	
	
	save_advanced_settings : function(id){
	
		var url = "/admin_users/remote/save_advanced_settings";
		
	
		$.ajax({
			type: 'POST',
			url: url,
			data: $("#advanced_user_settings_form").serialize(),
			success: function (data) {
				if (data == "error") {
					// $('.success_box').hide();
					// $('.error_box').show();
				}
				else {
					alert('ok');
				}
            }
        });
		
	
	},
	
	edit_user :  function(id){
	
		$('#userEditModal').modal();
	
	},
	
	
	delete_user:function(id){
	
		
		$("#confirmDiv").confirmModal({
			heading:'Delete this user?',
			body:'This action cannot be undone',
			callback: function() {
				//alert('callback test');
			}	
		});
		
	}
	
	

	
});



var ps_usermanager = new psusermanager();




var readUrl   = 'admin_users/read',
	updateUrl = 'admin_users/update',
	delUrl    = 'admin_users/delete',
	delHref,
	updateHref,
	updateId;
	
	

							
	

function readUsers(){
	//display ajax loader animation
    $( '#ajaxLoadAni' ).slideDown( 'slow' );
	
	$.ajax({
		url: readUrl,
		dataType: 'json',
		success: function(response){
		
			for( var i in response ) {
			
                response[ i ].updateLink = updateUrl + '/' + response[ i ].id;
                response[ i ].deleteLink = delUrl + '/' + response[ i ].id;
				
            }
            

			var source   = $("#userlist-template").html();
			var template = Handlebars.compile(source);
						
			$('#users_table').append(template(response));
						
		  
			
			
			//hide ajax loader animation here...
            $( '#ajaxLoadAni' ).slideUp( 'slow' );
		}
	});
} //end readUsers




		
$( function() {
    
	
	
    $( '#user_management_tabs' ).tabs({
        fx: { height: 'toggle', opacity: 'toggle' },
		select: function(event, ui) {
		
		
			if(ui.index == 1){
			
				$('#role_record_div').load("/admin_users/remote/list_roles");
			
			}
			
			if(ui.index == 3){
			
				$('#userfield_list_div').load("/admin_users/remote/list_userfields",function(){
					userfield_manager.initdnd();
							
				});
			
			}
			
					
		}
	
    }).fadeIn(); 
	
	
	
	readUsers();    
    
    $( '#crudmsgDialog' ).dialog({
        autoOpen: false,
        
        buttons: {
            'Ok': function() {
                $( this ).dialog( 'close' );
            }
        }
    });
    
    $( '#crudupdateDialog' ).dialog({
        autoOpen: false,
        buttons: {
            'Update': function() {
                $( '#ajaxLoadAni' ).slideDown( 'slow' );
                $( this ).dialog( 'close' );
                
                $.ajax({
                    url: updateHref,
                    type: 'POST',
                    data: $( '#crudupdateDialog form' ).serialize(),
                    
                    success: function( response ) {
                   
                        $( '#crudmsgDialog > p' ).html( response );
                        $( '#crudmsgDialog' ).dialog( 'option', 'title', 'Success' ).dialog( 'open' );
                        
                        $( '#ajaxLoadAni' ).slideUp( 'slow' );
                   		
	 
                        //--- update row in table with new values ---
                        var first_name = $( 'tr#' + updateId + ' td' )[ 1 ];
                        var last_name = $( 'tr#' + updateId + ' td' )[ 2 ];
						var username = $( 'tr#' + updateId + ' td' )[ 3 ];
						//var password = $( 'tr#' + updateId + ' td' )[ 4 ];
						var email_address = $( 'tr#' + updateId + ' td' )[ 4 ];
                        
						$( first_name ).html( $( '#first_name' ).val() );
                        $( last_name ).html( $( '#last_name' ).val() );
                        $( username ).html( $( '#username' ).val() );
                        //$( password ).html( $( '#password' ).val() );
						$( email_address ).html( $( '#email_address' ).val() );
						
						/*  
                        //--- clear form ---
                        $( '#crudupdateDialog form input' ).val( '' );
						*/
                        
                    } //end success
                    
                }); //end ajax()
            },
            
            'Cancel': function() {
                $( this ).dialog( 'close' );
            }
        },
        width: '350px'
    }); //end update dialog
	
	$( '#cruddelConfDialog' ).dialog({
        autoOpen: false,
        
        buttons: {
            'No': function() {
                $( this ).dialog( 'close' );
            },
            
            'Yes': function() {
                //display ajax loader animation here...
                $( '#ajaxLoadAni' ).slideDown( 'slow' );
                
                $( this ).dialog( 'close' );
                
                $.ajax({
                    url: delHref,
                    
                    success: function( response ) {
                        //hide ajax loader animation here...
                        $( '#ajaxLoadAni' ).slideUp( 'slow' );
                        
                        $( '#crudmsgDialog > p' ).html( response );
                        $( '#crudmsgDialog' ).dialog( 'option', 'title', 'Success' ).dialog( 'open' );
                        
                        $( 'a[href=' + delHref + ']' ).parents( 'tr' )
                        .fadeOut( 'slow', function() {
                            $( this ).remove();
                        });
                    } //end success
                });
            } //end Yes
        } //end buttons
    }); //end dialog
    
    $( '#crudRecords' ).delegate( 'a.updateBtn', 'click', function() {
        updateHref = $( this ).attr( 'href' );
        updateId = $( this ).parents( 'tr' ).attr( "id" );
        
        $( '#ajaxLoadAni' ).slideDown( 'slow' );
        
        $.ajax({
            url: 'admin_users/getById/' + updateId,
            dataType: 'json',
            
            success: function( response ) {
				$( '#first_name' ).val( response.usr_first_name );
                $( '#last_name' ).val( response.usr_last_name );
                $( '#username' ).val( response.usr_username );
                $( '#email_address' ).val( response.usr_email_address );
				
				$( '#password' ).val(''); // reset this from previous edits
				
				// here we have to select the correct radio box
				
				$('#urole_' + response.role).attr('checked', true);

						
                $( '#ajaxLoadAni' ).slideUp( 'slow' );
                
                //--- assign id to hidden field ---
                $( '#userId' ).val( updateId );
                
                $( '#crudupdateDialog' ).dialog( 'open' );
            }
        });
        
        return false;
    }); //end update delegate
	
	$( '#crudRecords' ).delegate( 'a.deleteBtn', 'click', function() {
        delHref = $( this ).attr( 'href' );
        
        $( '#cruddelConfDialog' ).dialog( 'open' );
		
        return false;
    
    }); //end delete delegate
	
	// --- Create Record with Validation ---
    $( '#crudcreate form' ).validate({
        rules: {
			cfirst_name: { required: true },
			clast_name: { required: true },
			cusername: { required: true },
			cpassword: { required: true },
			cemail_address: { required: true, email: true }
        },
		
        submitHandler: function( form ) {
            $( '#ajaxLoadAni' ).slideDown( 'slow' );
            
            $.ajax({
                url: 'admin_users/create',
                type: 'POST',
                data: $( form ).serialize(),
                
                success: function( response ) {
                    $( '#crudmsgDialog > p' ).html( response );
                    $( '#crudmsgDialog' ).dialog( 'option', 'title', 'Success' ).dialog( 'open' );
                    
                    //clear all input fields in create form
                    $( 'input', this ).val( '' );
                    
                    //refresh list of users by reading it
                    readUsers();
                    
                    //open Read tab
                    $( '#crudTabs' ).tabs( 'select', 0 ).fadeIn();
                }
            });
            
            return false;
        }
    });
	
	
	$('.dropdown-toggle').dropdown()
	

	
	/* user edit form */
	
	$('#upload_button').click(function() {
			$("#test").click();
	})
							
	$('#test').change(function() {
							
		var filename = jQuery(this).val();
						
		$('#uploadavatar_label').html("Selected: " + filename);
					
	});
							
							
	
	
}); //end document ready
