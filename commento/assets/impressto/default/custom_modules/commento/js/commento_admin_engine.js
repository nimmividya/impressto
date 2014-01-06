$(document).ready(function() {
	
	var currentForm_rem;
	var current_rem_id;
	
	var currentForm_app;
	var current_app_id;
	
	
	$( "#dialog-remove" ).dialog({
		resizable: false,
		height:140,
		width: 400,
		autoOpen: false,
		modal: true,
		buttons: {
			"Confirm Remove": function() {
				$.post('/commento/admin_remote/processor/?post_action=rem_comm&comm_rem_id='+current_rem_id, function(msg){
					if(msg.status){
						$(".id_"+current_rem_id).slideUp();
					} else {
						alert(msg.error);
					}
				},'json');
				$( this ).dialog( "close" );
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	
	$('form.form_remove_comm').submit(function(e){
		e.preventDefault();
		currentForm_rem = this;
		current_rem_id 	= $(this).find("input[name=comm_rem_id]").val();
		$('#dialog-remove').dialog('open');
	});
	
	
	
	
	
	
	
	$( "#dialog-approve" ).dialog({
		resizable: false,
		height:140,
		width: 400,
		autoOpen: false,
		modal: true,
		buttons: {
			"Confirm approve": function() {
				$.post('/commento/admin_remote/processor/?post_action=app_comm&comm_app_id='+current_app_id, function(msg){
					if(msg.status){
						$(".id_"+current_app_id).removeClass("not_accepted_comment");
					} else {
						alert(msg.error);
					}
				},'json');
				$( this ).dialog( "close" );
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	
	$('form.form_approve_comm').submit(function(e){
		e.preventDefault();
		currentForm_app = this;
		current_app_id 	= $(this).find("input[name=comm_app_id]").val();
		$('#dialog-approve').dialog('open');
	});
	
	
	
	
	
	
	
	$('form.form_save_config').submit(function(e){
		e.preventDefault();
		$this = $(this);
		$.post('/commento/admin_remote/processor/?post_action=save_cfg', $(this).serialize(), function(msg){
			if(msg.status){
				$('<span style="color: green; font-weight: bold;"> Saved successfully</span>').insertAfter($this.find("input[type=submit]")).delay(1000).fadeOut("normal");
			} else {
				alert(msg.error);
			}
		},'json');
	});
	
	
	
	$(".color-picker").miniColors({
		letterCase: 'uppercase',
		change: function(hex, rgb) {
			//logData(hex, rgb);
		}
	});
	
	
	 
	
});