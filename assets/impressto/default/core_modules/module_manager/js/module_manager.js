

var psmodulemanager = appbase.extend({
	
	
construct: function() {
		
},



	/**
	* reload the left nav bar
	*
	*/
	refresh_leftnav : function(){
	
		var url = "/module_manager/remote/refresh_leftnav";
		
		$('#leftnav').load(url);
		
	
	},
	

	

	deactivatemodule : function(module){
	
		var url = "/module_manager/remote/deactivatemodule";
			
								
		this.slowspinner();
		
		$.get(url, { module: module }, function(data) {
			
			$('#module_table_div').load("/module_manager/remote/loadlist");
			
			ps_module_manager.refresh_leftnav();
			
			
		});
			
	
	},
	
	
	activatemodule : function(module){
	
		var url = "/module_manager/remote/activatemodule";
			
								
		this.slowspinner();
		
		$.get(url, { module: module }, function(data) {
			
			if(data == 'activated'){
			
				$('#module_table_div').load("/module_manager/remote/loadlist");
				
				ps_module_manager.refresh_leftnav();
				
				
			}
			
		});
		
	},
	
	
	check_for_module_update : function(module_dirname, module_type, module_id, version){
	
		$("#ajaxLoadAni").ajaxStart(function(){
			$(this).slideDown();
		}).ajaxComplete(function(){
			$(this).slideUp();
		});
	
		if(version == "N/A") version = 0;
		
		var url = "/module_manager/remote/check_for_module_update/" + module_dirname + "/" + module_type + "/" + version;
			
		$.getJSON(url, function(data) {
		
			
			if(data.version > version){
			
				$('#update_check_' + module_id).html('version ' + data.version + ' available. <a href="javascript:ps_module_manager.install_module_update(\'' + module_dirname + '\',\''+ module_type + '\',\''+ module_id +'\',\'' + data.version + '\')">Click here</a> to download and install.');
			
			}else{
			
				$('#update_check_' + module_id).html('No updates currently available');
			
			
			}
			
	
		});
	
	
	},
	
	install_module_update : function(module_dirname, module_type, module_id, version){
	
		
		var url = "/module_manager/remote/install_module_update/" + module_dirname + "/" + module_type + "/" + version;
	
		$.getJSON(url, function(data) {
		
			
			if(data.msg === 'success'){
			
				$('#update_check_' + module_id).html('');
			
			}else{
			
				$('#update_check_' + module_id).html('Failed to install');
			
			
			}
			
	
		});
	},
	
	
	
	reinstall : function(module){
	
		var url = "/module_manager/remote/reinstall";
			
								
		this.slowspinner();
		
		$.get(url, { module: module }, function(data) {
			
			if(data == 'activated'){
			
				$('#module_table_div').load("/module_manager/remote/loadlist");
				
			}
			
		});
		
		
		
		
	
	},
	
	
	
	getstyle : function(){
	
		// load the list based on the selected category
		var module = $('#module_selector').val();
		var css = $('#css_selector').val();
		
		if( module == "" || css == "") return;
				
					
		this.slowspinner();
		
		var url = "/stylesheet_manager/admin_remote/getstyle/";

		var data = "css=" +  css;
						
		
		$.ajax({
		
			url: url,
			dataType: 'json',
			data: data,
			success: function(data) {
			
				$('#css_edit_area').val(data.css);
				
				$('#savecss_button').show();			  
			  
			}
		});

			
		
	
	},
	
	
	setpermissions : function(module_id){
	

		// load the module premisions dialoge and float it...
		var url = "/module_manager/remote/loadpermissions";
		


		$("#permissions_dialog").load(url, {module_id: module_id}, function(){

			$("#permissions_dialog" ).dialog({
				height: 'auto',
				width: 600,
				modal: true
			});
			
			
			$('.role_action_label').tooltip();
			
			
			
			
			
		
		});
		
	
		
	
	},
	
	
	saverolepermissions : function(){
	

		// load the module premisions dialoge and float it...
		var url = "/module_manager/remote/saverolepermissions";
				

		$.post(url, $("#module_role_permissions_form").serialize(), function(){

			$( "#permissions_dialog" ).dialog("close");
			
			ps_module_manager.refresh_leftnav();
			
					
		});
				
	
	},
	
	
	new_module_form : function(){
	
	
		
		$("#new_module_dialog" ).dialog({
			height: 'auto',
			width: 340,
			modal: true
		});
			

	
	},
	
	install_module_form : function(){
	
	
		// initialize
		$('#install_module_dialog_message').hide();
		$('#install_module_info_div').hide();
		$('#module_file').val('');
		
		$('#install_module_form').show();
				
		
		$("#install_module_dialog" ).dialog({
			height: 'auto',
			width: 340,
			modal: true
		});
		
		//});
	

			

	
	},
	
	

	cancel_new_module : function(){

		$( "#new_module_dialog" ).dialog("close");

	},
	
	

	
	create_new_module : function(){
	
		var new_module_name = $('#new_module_name').val();
		
		if(!new_module_name){
		
			$('#new_module_dialog_message').html('Please set module name.').fadeIn();
		
			return;
			
		}
		
		var url = "/module_manager/remote/create_new_module";
		
			

		$.post(url, $("#new_module_form").serialize(), function(){

			$( "#new_module_dialog" ).dialog("close");

			$('#module_table_div').load("/module_manager/remote/loadlist");
			
		});
	
	},
	
	
	install_module : function(){
	

		// load the module premisions dialoge and float it...
		var url = "/module_manager/remote/install_module";
	
		$.post(url, { type: $('#installmod_type').val(), unpackfolder: $('#installmod_unpackfolder').val(), module_name: $('#installmod_name').val()}, function(){

					
			$('#module_table_div').load("/module_manager/remote/loadlist", function(){
			
				$( "#install_module_dialog" ).dialog("close");
				
			});
				

				
					
		});
				
	
	},
	
	
	
	
ajaxFileUpload: function (){


	$("#ajaxLoadAni")
	.ajaxStart(function(){
		$(this).slideDown();
	})
	.ajaxComplete(function(){
		$(this).slideUp();
	});


	$.ajaxFileUpload
	(
	{
url:'/module_manager/remote/upload_module',
secureuri:false,
fileElementId:'fileToUpload',
debug: true,
dataType: 'json',
data:{name:'logan', id:'id' },
success: function (data, status)
		{
		
			if(data.status != 'error')
            {
			
				$('#install_module_form').fadeOut( function(){
				
					$('#install_module_info_name').html(data.install_info.Name);
					$('#install_module_info_type').html(data.install_info.Type);
					$('#install_module_info_description').html(data.install_info.Description);
					$('#install_module_info_author').html(data.install_info.Author);
					$('#install_module_info_version').html(data.install_info.Version);
					$('#install_module_info_date').html(data.install_info.Date);
					
					$('#installmod_unpackfolder').val(data.install_info.unpackfolder);
					$('#installmod_type').val(data.install_info.Type);
					$('#installmod_name').val(data.install_info.Name);
					
				
				
					$('#install_module_info_div').slideDown();
					
					
					if(data.status == 'warning')
					{
			
		
						$('#install_module_dialog_message').html(data.msg).fadeIn();
						
						$('#complete_install_btn').attr("disabled", true);

						
				
				
					}else{
					
						$('#install_module_dialog_message').html('').fadeOut();
					
						$('#complete_install_btn').attr("disabled", false);	
					
					
					}
				});
			

			
              //$('#install_module_info_div').html(data.msg);
             //  refresh_files();
              // $('#title').val('');
			  
			  
            }
           // alert(data.msg);
			
		},
error: function (data, status, e)
		{
			alert(e);
		}
	}
	)
	
	return false;

	},

	
	
	
		
});


var ps_module_manager = new psmodulemanager();




$(function() {

   $('#fileToUpload').change( function()
    {
      $('#module_file').val( $(this).val() );
    });




		
});


	
	






	