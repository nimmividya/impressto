function psFolderToggle(number) {
	var el = document.getElementById('u_'+number);
	if ( el.style.display == 'none' ) {	
		document.getElementById('img_'+number).setAttribute("src", "/assets/" + ps_base.appname + "/default/core/images/pageList_Open.gif");
		el.style.display = 'block';
		setCookie(number,'1',30);
	} else if (el.style.display == '') {
		document.getElementById('img_'+number).setAttribute("src", "/assets/" + ps_base.appname + "/default/core/images/pageList_Closed.gif");
		el.style.display = 'none';
		setCookie(number,'0',30);
	} else {
		document.getElementById('img_'+number).setAttribute("src", "/assets/" + ps_base.appname + "/default/core/images/pageList_Closed.gif");
		el.style.display = 'none';
		setCookie(number,'0',30);
	}
}
function setCookie(c_name,value,expiredays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}
function getCookie(c_name) {
	if (document.cookie.length>0)
	  {
	  c_start=document.cookie.indexOf(c_name + "=");
	  if (c_start!=-1)
		{ 
		c_start=c_start + c_name.length+1; 
		c_end=document.cookie.indexOf(";",c_start);
		if (c_end==-1) c_end=document.cookie.length;
		return unescape(document.cookie.substring(c_start,c_end));
		} 
	  }
	return "";
}
function psDelete(id,url,name) {
  if (confirm("You are about to delete this "+name+".  This action cannot be undone.  Continue?")) {
    document.location.href=url+".php?id="+id+"";
  }
}
function psBrowseServer(idName) {
	window.SetUrl=function(value){
		document.getElementById(idName).value=value;
  	}
  	var filemanager='/includes/fckeditor/editor/filemanager/browser/default/browser.html';
  	var connector='../../connectors/php/connector.php';
  	window.open(filemanager+'?Connector='+connector,'fileupload','modal,width=980,height=550');
}
function psToggle( whichLayer )
{
  var elem, vis;
  if( document.getElementById ) // this is the way the standards work
    elem = document.getElementById( whichLayer );
  else if( document.all ) // this is the way old msie versions work
    elem = document.all[whichLayer];
  else if( document.layers ) // this is the way nn4 works
    elem = document.layers[whichLayer];
  vis = elem.style;
  // if the style.display value is blank we try to figure it out here
  if(vis.display==''&&elem.offsetWidth!=undefined&&elem.offsetHeight!=undefined)
    vis.display = (elem.offsetWidth!=0&&elem.offsetHeight!=0)?'block':'none';
  vis.display = (vis.display==''||vis.display=='block')?'none':'block';
}