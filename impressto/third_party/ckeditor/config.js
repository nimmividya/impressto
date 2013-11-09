/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/


CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	config.uiColor = '#54b9d7';

    config.removePlugins = 'resize';

    config.resize_enabled = false;

    config.toolbarCanCollapse = false;

    config.removePlugins = 'elementspath';
	
	config.protectedSource.push( /<\?[\s\S]*?\?>/g ); // peterdrinnan - this allows PHP tags to stasy alive
	

	config.templates_files =['/third_party/ckeditor/plugins/templates/templates/default.js'];

	config.toolbar = 'Full';
	
	config.extraPlugins = 'widgets'; // peterdrinnan - added for widgets
	
    
    CKEDITOR.config.toolbar_Full =
[
    ['Source','-',/*'Save','NewPage',*/'Preview'/*,'-','Templates'*/],
    ['Cut','Copy','Paste','PasteText','PasteFromWord','-',/*'Print',*/ 'SpellChecker', 'Scayt'],
    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	/*['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],*/
    '/',
    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['BidiLtr', 'BidiRtl' ],
    ['Link','Unlink'/*,'Anchor'*/],
    ['Image','Widgets','Flash','Table','HorizontalRule','SpecialChar',/*'PageBreak',*/'Iframe'],
    '/',
    ['Styles','Format','Font','FontSize'],
    ['TextColor','BGColor'],
    ['Maximize', 'ShowBlocks','-','About']
	

	
];


config.toolbar_Basic =
[
	['Bold', 'Italic', '-', 'NumberedList', 'BulletedList']
];


};
