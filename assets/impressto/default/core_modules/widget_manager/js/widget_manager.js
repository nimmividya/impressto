var pswidgetmanager = appbase.extend({
construct: function() {
		//alert(this.sortorder);
	},
	
selectpage: function (obj){
		

		var selected = $('#' + obj.id).val();
		
		if(selected != "" && $('#wm_zone_selector').val() != ""){
			
			this.loadwidgetlist();
			

		}			
		
		
	},

	
	show_widgetshortcode : function(obj, id){
	
				
		$('#shortcode_' + id + '_btn').hide("slide", { direction: "left" }, function(){
		
			$('#shortcode_' + id).show("slide", { direction: "right" } );
			
		});
		
		
			
	
	},
	
	/**
	* gets the slub for the widget
	*
	*/
	show_widget_slug : function(obj, id){
	
		
		$('#slug_' + id + '_btn').fadeOut("fast", function(){
		
			$('#shortcode_' + id + '_btn').fadeOut("fast", function(){
			
				$('#widget_slug_code_' + id).show("slide", { direction: "right" } );
		
			});
		
		});
				
	
	},
	
	
	
	cancel_slug : function (id){
	
		$('#widget_slug_code_' + id).hide("slide", { direction: "left" } , function(){
		
			$('#slug_' + id + '_btn, #shortcode_' + id + '_btn').fadeIn("fast");
		
		});
				
		
		
	},
	
	/**
	* pingsthe server to see it the slug is already in use for another widget
	*
	*/
	save_slug : function (id){
		

		var shortcode = $('#shortcode_' + id).val();
		var slug = $('#slug_' + id).val();
		
		var url = "/widget_manager/admin_remote/save_slug";
		
		var data = "shortcode=" + shortcode + "&slug=" + slug + "&widget_id=" + id;
		
		$.ajax({
			type: 'POST',
			url: url,
			data: data,
			success: function(data){
			
				if(data == "used"){
				
					alert("slug used by another widget");
					
					$('#slug_' + id).css("color","red"); 
					
					
				
				}else{
				
					$('#widget_slug_code_' + id).hide("slide", { direction: "left" } , function(){
		
						$('#slug_' + id + '_btn, #shortcode_' + id + '_btn').fadeIn("fast");
						$('#slug_' + id).css("color","black"); 
		
					});
				
				}				
				
			}
		});

				
			

				
		
		
	},
	
selectcollection: function (obj){
		
		var selected = $('#' + obj.id).val();
		
		var label = $('#' + obj.id + ' option:selected').text();
		
		$('#collection_title').html(label + " Collection");
		
	
		if(selected != ""){
		
			ps_widget_manager.loadwidgetlist();
			
			$('#deletecurrentcollection_btn').fadeIn();
					
			//$('#shownewzonefield_btn').fadeIn();
					
			
			$('#widgetcollections_div').slideDown(function(){
			
			
				$('.widget_description').tooltip();
									
				
			});
			
		
			
			

		}else{

			$('#widgetcollections_div').slideUp(function(){
			
				//$('#shownewzonefield_btn').fadeOut();
							
				
			});
		}		
		
		
	},
	
	

	
selectzone: function(obj){
		
		
		var selected = $('#' + obj.id).val();
		
		if(selected != "" && $('#wm_page_selector').val() != ""){
			
			this.loadwidgetlist();
			
			
			
		}			
		


	},

	
movedown: function(placement_id, zone){
		
		this.moveposition(placement_id, zone, "down");
		
		
	},
	
	
moveup: function(placement_id, zone){
		
		this.moveposition(placement_id, zone, "up");
	},	
	
	
	
moveposition: function(placement_id, zone, direction){
		
	
		var collection = $('#wm_collection_selector').val();

		var url = "/widget_manager/admin_remote/move_position/";
		var data = "direction=" + direction + "&collection=" + collection + "&zone=" + zone + "&placement_id=" + placement_id;
		
		$.ajax({
type: "GET",
url: url,
data: data
		}).done(function( msg ) {
			
			ps_widget_manager.loadwidgetlist();
			
		});
	},
	

	
	
	
movezonedown: function(zone_id){
		
		this.movezoneposition(zone_id, "down");
		
		
	},
	
	
movezoneup: function(zone_id){
		
		this.movezoneposition(zone_id, "up");
	},	
	
	
	
movezoneposition: function(zone_id, direction){
		
	
		//var collection = $('#wm_collection_selector').val();

		var url = "/widget_manager/admin_remote/move_zone_position/";
		var data = "direction=" + direction + "&zone_id=" + zone_id;
		
		$.ajax({
type: "GET",
url: url,
data: data
		}).done(function( msg ) {
			
			ps_widget_manager.loadwidgetlist();
			
		});
	},
	
	
	

	
	togglewidgetadd_btn : function(obj){
		
		if($('#' + obj.id).val() != "") $('#widget_add_button').show();
		else $('#widget_add_button').hide();
		
	},
	
	
	assign_new_widget: function(widget_id, zone_id){

		var collection = $('#wm_collection_selector').val();
		//var widget_id = obj.value;
		
		
		var url = "/widget_manager/admin_remote/assign_new_widget/";
		var data = "collection=" + collection + "&zone_id=" + zone_id + "&widget_id=" + widget_id;
		
		$.ajax({
type: "GET",
url: url,
data: data
		}).done(function( msg ) {
			
			ps_widget_manager.loadwidgetlist();
			
		});

		
		
	},
	
	


	unlink_widget: function (placement_id){


		
		var url = "/widget_manager/admin_remote/unlink_widget/";
		var data = "placement_id=" + placement_id;
		
		$.ajax({
type: "GET",
url: url,
data: data
		}).done(function( msg ) {
			
			ps_widget_manager.loadwidgetlist();
			
		});
		
	},

	


deletezone : function(zone_id){


  if (confirm("You are about to delete this zone.  Are you absolutely certain you want to do this?")) {
    
		var url = "/widget_manager/admin_remote/deletezone/" + zone_id;

		$.get(url, function(data){
			
			
			ps_widget_manager.loadwidgetlist();
			
			
		});
  }


},


deletecurrentcollection : function(){

	var collection_id = $('#wm_collection_selector').val();

	if(collection_id != ""){
	
		if (confirm("You are about to delete this collection.  Are you absolutely certain you want to do this?")) {
		
			$('#widgetcollections_div').slideUp(function(){
			
				//$('#shownewzonefield_btn').fadeOut();
							
				var url = "/widget_manager/admin_remote/deletecollection/" + collection_id;
			
				$.get(url, function(data){
			
					// now remove the item from the selector
					$("#wm_collection_selector option[value='" + collection_id + "']").remove();
					$('#widget_list_div').html('');
				
					//$('#deletecurrentcollection_btn').fadeOut();
					
			
				});
			
			});
						
		}
	
	}


},

	
loadwidgetlist: function (){

		//var zone = $('#wm_zone_selector').val();
		
		var collection = $('#wm_collection_selector').val();		
		
		if(collection == "") return; 
		
		var url = "/widget_manager/admin_remote/loadwidgetlist/" + collection;

		$.get(url, function(data){
			
			
			$('#widget_list_div').html(data);
			
			$('#new_widget_selector_div').show();
			
			 $('.widget_dropzone').droppable({ 
			 
			 	hoverClass	: 'droppablewidgets-hover',
				accept		: '.droppablewidgets',
				greedy		: true,
				tolerance	: 'pointer',
				
				over : function(){
					//pyro.widgets.$areas.accordion('resize');
		
				},
				out : function(){
					//pyro.widgets.$areas.accordion('resize');
				},
				drop: function handleDropEvent( event, ui ) {
					
					var draggable = ui.draggable;
					
					//alert( 'The square with ID "' + draggable.attr('id') + '" was dropped onto me!' );
										
					var widget_id = draggable.attr('id')
					widget_id = widget_id.replace('droppablewidget_', '');
					
					var zone_id = $(this).attr('id');
					zone_id = zone_id.replace('widget_dropzone_', '');
			
							
					ps_widget_manager.assign_new_widget(widget_id, zone_id);
					
										
					$(draggable).animate($(draggable).data('startPosition'), 500);
					
				
				} 
			 
			 });
			  
  
			
		});
	},

	
shownewidgetnameinput: function (){
		
		$('#widget_selector').slideUp(function(){
			
			$('#newidgetnameinput_div').slideDown();
			
		});
		
		
	},
	
	
	
	
	
	shownewzonefield : function(){
		
		
		$('#shownewzonefield_btn').hide("slide", { direction: "right" }, function(){
		
			$('#new_widget_zone_div').show("slide", { direction: "left" });
			
		
		});

		
	},
	
	
	
	savezone : function(){
	
					
			$('#new_widget_zone_div').hide("slide", function(){

				// now add the value to the selector
				var name  = $('#new_widget_zone_field').val();
				var colorcode  = $('#colorpicker').val();
				
								
			
				if(name != ""){
				
					// do a quick post to the server and get the list id
					var ur = "/widget_manager/admin_remote/add_widget_zone";
										
					$.post(ur, {name : name, colorcode: colorcode},  function(data) {

											
						var dataobj = jQuery.parseJSON(data);
						
						if(dataobj.error != ""){
						
							alert(dataobj.error);
						
						}
						
						
						$('#new_widget_zone_div').fadeOut(function(){
						
							$('#shownewzonefield_btn').show("slide", { direction: "right" });
							
						});
						
						
						
					});
					
				}
				
				
				$('#new_widget_zone_field').val(""); // reset this to nothing

				
					$('#shownewzonefield_btn').val("Create Template Zone");
					
					ps_widget_manager.loadwidgetlist();

				
				
			});
			
			
		
	
	},
	
	
	cancelzone : function(){
	
		$('#new_widget_zone_div').fadeOut(function(){
		
			$('#shownewzonefield_btn').show("slide", { direction: "right" });
			
		
		});
	
	},
	
	
	
show_newcollectiondiv: function (){
		

	$('#shownewwidgetcollectionfield_btn').hide("slide", { direction: "right" },  function(){
				
		$('#newcollectiondiv').show("slide", { direction: "right" },  function(){
					
		});
				
	});	
			

		
		
	},
	
	
	savecollection : function(){
	
					
		$('#newcollectiondiv').hide("slide", { direction: "right" }, function(){

			// now add the value to the selector
			var collectionname  = $('#new_widget_collection_field').val();
				
			if(collectionname != ""){
				
				// do a quick post to the server and get the list id
				var ur = "/widget_manager/admin_remote/add_widget_collection";
					
				$.post(ur, { collectionname: collectionname }, function(data) {
					
					
					$('#newcollectiondiv').hide("slide", function(){
						$('#shownewwidgetcollectionfield_btn').show("slide", { direction: "right" });
						
										
						var dataobj = jQuery.parseJSON(data);
						
						if(dataobj.error == ""){
						
			
							if(dataobj.msg == "inserted"){
							
												
								$('#wm_collection_selector').append($("<option></option>").attr("value",dataobj.id).text(collectionname)); 
								$('#wm_collection_selector').val(dataobj.id); 
								
								ps_widget_manager.loadwidgetlist();
										
								var label = $('#wm_collection_selector option:selected').text();
																
								$('#collection_title').html(label + " Collection");
										
																
								$('#widgetcollections_div').slideDown(function(){
			
							
								});
			
								
							}
							
						}else{
						
							alert(dataobj.error);
						
						}
					
					});
							
					
				});
					
					
			}
				
			$('#new_widget_collection_field').val(""); // reset this to nothing

			//$('#shownewwidgetcollectionfield_btn').val("Create Widget Collection");
					
		});
			
		
	
	},
	
	
	cancelcollection : function(){
	
		$('#newcollectiondiv').hide("slide", { direction: "right" }, function(){
		
			$('#shownewwidgetcollectionfield_btn').show("slide", { direction: "right" });
			
		
		});
	
	},
	
	
	
	load_placement_options : function(placement_id){
	

		var url = "/widget_manager/admin_remote/load_placement_options/" + placement_id;

		$.get(url, function(data){
						
			$('#placement_options_dialog').html(data);
			
			$( "#placement_options_dialog" ).dialog( "open" );
				
		
		});
	
	
	},
	
	
	add_new_option : function(){
	
		
		var row = $('#placement_options_table tbody>tr:last').clone(true);
		row.find("input:text").val("");
		row.insertAfter('#placement_options_table tbody>tr:last');

		
	
	},
	
	save_placement_options : function(){
	
	
		var collection = $('#wm_collection_selector').val();
		var zone = $('#wm_zone_selector').val();
		//var widget = $('#new_widget_selector').val();
		
		var url = "/widget_manager/admin_remote/save_placement_options/";
		var data = $('#placement_options_form').serialize();
		
			$.ajax({
type: "GET",
url: url,
data: data
		}).done(function( msg ) {
			
			//alert('done');
			//$('#widget_options_div').hide("slide");
			
			$( "#placement_options_dialog" ).dialog( "close" );
			
			
			
		});
		
		
		
		
	}
		
	


	
});




var ps_widget_manager = new pswidgetmanager();


$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		
		$( "#placement_options_dialog" ).dialog({
			autoOpen: false,
			height: 240,
			width: 240,
			modal: true,
			buttons: {
				"Update": function() {
				
					ps_widget_manager.save_placement_options();
						
					//$( this ).dialog( "close" );

				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				
			}
		});
		
		
		
	$("#colorpicker").miniColors();
	
  
    $(".droppablewidgets").draggable({
	    cursor: 'move',
		helper: 'clone',
		cursorAt	: {left: 100},
		revert		: 'invalid',
		refreshPositions: true,
			
        start: function(event, ui) {
			$(this).data('startPosition', ui.position);
			$(this).addClass('droppablewidgets-drag')
			
        },									
		stop: function() {
			$(this).removeClass('droppablewidgets-drag');
		}
    });
		
		
});




