tinyMCEPopup.requireLangPack();

var WidgetsDialog = {
	init : function() {
	
		var f = document.forms[0];

		// Get the selected contents as text and place it in the input
		//f.someval.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.selected_widget.value = ''; //tinyMCEPopup.getWindowArg('some_custom_arg');
		
		//alert('huh');
		
	},

	insert : function() {
		// Insert the contents from the input into the document
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, document.forms[0].selected_widget.value);
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(WidgetsDialog.init, WidgetsDialog);


function assign_widget(ckeditor_name, widget_id, slug){

	$('#selected_widget').val(slug);
	
	$('#widget_list_div td').each(function() {
		  
		$(this).removeClass("widget_item_selector_active");
		
		  		  
      });
	  
	  
	  $('#widget_selector_item_' + widget_id).addClass("widget_item_selector_active");
	 	 
	 
}
