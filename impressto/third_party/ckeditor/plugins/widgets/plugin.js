/**
* @author Galbraith Desmond <galbraithdesmond@gmail.com>
*
*/
CKEDITOR.plugins.add( 'widgets',
{

	init: function( editor )
	{
	
		var pluginName  = 'widgets';
				
		var editor_id = editor.id;
		
		
		var widgetlist = '';
		
		var url = '/widget_manager/admin_remote/ck_widget_list/?editor_name=' + editor.name;
		
		
		$.get(url, function(data){
			widgetlist = data;
		});

		
		editor.addCommand( editor_id + '_widgetDialog', new CKEDITOR.dialogCommand( editor_id + '_widgetDialog' ) );
 
		editor.ui.addButton( 'Widgets',
		{
			label: 'Insert a Widget',
			command: editor_id + '_widgetDialog',
			icon: this.path + 'images/widgets.png'
		} );
 

		CKEDITOR.dialog.add( editor_id + '_widgetDialog', function( editor )
		{
			return {
				title : 'Widget Selector',
				minWidth : 400,
				minHeight : 500,
				contents :
				[
					{
						id : 'widget',
						label : 'Widgets',
						elements :
						[
							{
								type : 'html',
								html : widgetlist
							},
										
						]
					}
				],
				onOk : function()
				{
					var slug = $('#' + editor.name + '_selected_widget').val();
					editor.insertHtml(slug);
				}

			};
		} );
	}
} );


function assign_widget(ckeditor_name, widget_id, slug){

	$('#' + ckeditor_name + '_selected_widget').val(slug);
	
	$('#' + ckeditor_name + '_widget_list_div td').each(function() {
		  
		$(this).removeClass("widget_item_selector_active");
		
		  		  
      });
	  
	  
	  $('#' + ckeditor_name + '_widget_selector_item_' + widget_id).addClass("widget_item_selector_active");
	 	 
	 
}