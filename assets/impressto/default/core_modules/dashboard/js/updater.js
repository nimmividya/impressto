var psupdater = appbase.extend({

	core_files_array : '',
	core_files_array_position: 0,
	cancel_core_update : false,
	
	
	
	construct: function() {
		
	
		
	},
	
	show_full_change_log : function(){
	
	
		$('#full_change_log').slideToggle();
	
	},
	
	
	process_core_update : function(version){
	
		$('#process_core_update_div').slideUp();
		$('#core_update_progress_div').slideDown();
		$('#cancel_core_update_button').show();
		
		var url = "/dashboard/process_core_update/" + version; 

	
		$.getJSON(url, function(json) {
			
			if(json.status == "OK"){
			
				ps_updater.core_files_array = json.files_array;
				
				ps_updater.draw_file_list(json.files_array);
				
				ps_updater.copy_next_core_file(version);
			
				
			}
			
		});

		
	},
	
	
	copy_next_core_file : function(version){
	
		//alert(ps_updater.core_files_array.length);
		
		if(this.cancel_core_update == true) return;
				
			
		var url = "/dashboard/copy_next_core_file/";
		
		$.ajax({

			url: url,
			dataType: 'json',
			type: 'POST',
			data: "version=" + version + "&file_path=" + ps_updater.core_files_array[ps_updater.core_files_array_position],
			success: (function(json) { 
			
			
				$('#cflist_' + ps_updater.core_files_array_position).html(json.msg).css("color",json.color);
						
				ps_updater.core_files_array_position ++;
					
				progress_percent = Math.round((ps_updater.core_files_array_position / ps_updater.core_files_array.length) * 100);
								
					
				$('#core_update_progress_bar').html(progress_percent + "%").css("width", progress_percent + "%");
					
	
				if(ps_updater.core_files_array_position >= ps_updater.core_files_array.length){
					
					var url = "/dashboard/run_migration_script/";
					
					$.get(url,function(){
					
						var url = "/dashboard/run_cleanup_script/" + version;
					
						$.get(url,function(){
						
							$('#cancel_core_update_button').hide();
							
							//$('#process_core_update_div').slideDown();
							
							alert("Update is complete.");
						
						
						});
					
															
			
					});
					
											
		
					return;
						
				}else{
					ps_updater.copy_next_core_file(version);
				}
				
							
			
			})
		});
		
					
	
	},
	
	cancel_core_update : function(){
	
		this.cancel_core_update = true;	
			
		$('#core_update_progress_div').slideUp();
		$('#process_core_update_div').slideDown();
		
	
	},
	
	
	
	draw_file_list : function(){
	
		var file_list_html = "<ul>";
		
		$.each(ps_updater.core_files_array, function(i, item) {
			
			file_list_html += "<li id=\"cflist_" + i + "\">" + item + "</li>";
			
			
   		});
		
		file_list_html += "</ul>";
		
		$('#core_update_progress_file_list').html(file_list_html);
		
		$('#core_update_progress_div').show();
			
	
	}
	
});



var ps_updater = new psupdater();



$(document).ready(function(){



});




