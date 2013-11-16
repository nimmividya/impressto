

var impdashboardmanager = appbase.extend({
	
	
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
		

		

				
	
	}
	

	
});



var dashboardmanager = new impdashboardmanager();



$(document).ready(function(){

$('#searchable').multiSelect({
  selectableHeader: "<input type='text' id='search' autocomplete='off' placeholder='try \"elem 2\"'>"
});

$('#search').quicksearch($('.ms-elem-selectable', '#ms-searchable' )).on('keydown', function(e){
  if (e.keyCode == 40){
    $(this).trigger('focusout');
    $('#searchable').focus();
    return false;
  }
});

});

