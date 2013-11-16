// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2011 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
// Html tags
// http://en.wikipedia.org/wiki/html
// ----------------------------------------------------------------------------
// Basic set. Feel free to add more tags
// ----------------------------------------------------------------------------
var mySettings = {
	onShiftEnter:  	{keepDefault:false, replaceWith:'<br />\n'},
	onCtrlEnter:  	{keepDefault:false, openWith:'\n<p>', closeWith:'</p>'},
	onTab:    		{keepDefault:false, replaceWith:'    '},
	markupSet:  [ 	

		{separator:'---------------' },
		{name:'jQuery Ready Function', openWith:'$(document).ready(function() {\n\n', closeWith:'});' },
		{name:'Ajax', openWith:'$.ajax({\n   type: "POST",\n   url: "",\n   success: function( data ) {\n\n', closeWith:'   }\n});\n' },
		{separator:'---------------' },

	]
}

