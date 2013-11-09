var pscontentmanager = appbase.extend({

		sortorder : '',
		treenodestates : new Array(),
		language : '',
				
		construct: function() {
		
		},
		
		
		showalert : function(msg){
		
		
			alert(msg);
		
		},
		
		setupsortable : function(cat_id){
		
			$('#u_' + cat_id).sortable({
			    update: function() {
					psctntmgr.reorder(cat_id,$('#u_' + cat_id).sortable('serialize'));
				}
  			});
		
		},
		reorder: function (parent_id,orderlist){
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
			$.ajax({
		
				type: "POST",
				url: "/page_manager/reorder/" + parent_id,
				data: orderlist,
				success: function( data ) {
				
					$( '#ajaxLoadAni' ).slideUp( 'slow' );
					
				}
			});
		},
		
		deletecontent : function(item_id){
		
		    var answer = confirm("Delete selected item?")
			if (answer){

				$.ajax({
					type: "POST",
					url: "/page_manager/delete/" + item_id,
					success: function( data ) {
						$('#item__' + item_id).remove();
					}
				});
			}
			return false;
		},
		
		deletewarning : function(item_id){
			alert('This item has children. Please delete them individually before deleting this item.');
		},
		
	
	editcontent : function(id){
	
		var url = "/page_manager/edit/" + psctntmgr.language + "/" + id;
		
		//alert(url);
		
		
		document.location = url; 
	
	
	},
	
	copycontent : function(id){
	
		var url = "/page_manager/copy/" + psctntmgr.language + "/" + id;
			
		document.location = url; 
	
	
	},
	
	
	
	
	addsubcontent : function(id){
	
		var url = "/page_manager/edit/" + psctntmgr.language + "/0/" + id;
		
		document.location = url; 
	
	
	},
	
	
	previewcontent : function(id){
	
		var url = "/page_manager/get_friendly_url/" + id + "/" + this.language;
		
		$.getJSON(url, function(data) {
		
			var url = "";
		
		
			if(data.url != ""){
			
				url = "/" + psctntmgr.language + "/" + data.url;
			
			}else{
			
				url = "/" + psctntmgr.language + "/" + data.id;
			
			}
			
			window.open(url,'_newtab');
				
		});
							
	
	},


		
		
	/**
	* on page reload this function executes to restore the tree state
	*
	*/
	restore_node_visiblestates : function(){
	

		
	
		var nodestates = $.cookie('cntntmgr_nodestates');
						
		this.treenodestates = nodestates ? nodestates.split(/,/) : new Array();
			
		for(i=0; i < this.treenodestates.length; i++){
			
			var el = document.getElementById('u_'+this.treenodestates[i]);
			
			document.getElementById('img_'+this.treenodestates[i]).setAttribute("src", ps_base.asseturl + ps_base.appname + "/default/core/images/pageList_Open.gif");
			el.style.display = 'block';
			
		}
	
	},
	
	psfoldertoggle: function (number) {
	
	
		
		var el = document.getElementById('u_'+number);
		
		if ( el.style.display == 'none' ) {	
		
			
			document.getElementById('img_'+number).setAttribute("src", ps_base.asseturl + ps_base.appname + "/default/core/images/pageList_Open.gif");
			el.style.display = 'block';
			//setCookie(number,'1',30);
			
			// add it to the list of open nodes
			
			this.treenodestates.push(number);
			
			$.cookie('cntntmgr_nodestates',this.treenodestates.join(','));
			
			//alert(this.treenodestates.join(','));
			
			
		} else {
		
			document.getElementById('img_'+number).setAttribute("src", ps_base.asseturl + ps_base.appname + "/default/core/images/pageList_Closed.gif");
			el.style.display = 'none';
			//setCookie(number,'0',30);
			
			
			this.treenodestates.removeItem(number);
			
			// now loop through the dom and get all the ids of the child items
			
			$.cookie('cntntmgr_nodestates',this.treenodestates.join(','));
				
						
			//alert(this.treenodestates.join(','));
			
			
		}
	},
	
		filter_orderlist: function(){
		
			var keyword = $('#orderlist_filter_keyword').val();
					
			var url = "/page_manager/admin_remote/filter_orderlist/?lang=" + this.language + "&keyword=" + escape(keyword);
						
			$('#pageList').load(url, function(){
			
				psctntmgr.initmaincontextmenus();
			
			});
			

		},
		
		
		reveal_orderlist: function(nodes){
		

			var node_array = this._explodeArray(nodes,",");
			
			for (var i = 0; i < node_array.length; i++) {
			
				$('#u_' + node_array[i]).show(); //css("display", "block");
				
				//Do something
		}

				//			alert(nodes);
		
		},
		
		
		_explodeArray : function (item,delimiter) {
		
			tempArray=new Array(1);
			var Count=0;
			var tempString=new String(item);
			
			while (tempString.indexOf(delimiter)>0) {
				tempArray[Count]=tempString.substr(0,tempString.indexOf(delimiter));
				tempString=tempString.substr(tempString.indexOf(delimiter)+1,tempString.length-tempString.indexOf(delimiter)+1);
				Count=Count+1
			}
			
			tempArray[Count]=tempString;
			return tempArray;
		},
		

		
		initmaincontextmenus : function(){
		
			// Show menu when a list item is clicked
			$(".page_listitem").contextMenu({
				menu: 'pageMenu'
			}, function(action, el, pos) {
	
				var id = $(el).attr('id');
				
				id = id.replace("page_anchor_","");
		 	
				if(action == "editcontent") psctntmgr.editcontent(id);
				else if(action == "copycontent") psctntmgr.copycontent(id);				
				else if(action == "addsubcontent") psctntmgr.addsubcontent(id);
				else if(action == "deletecontent") psctntmgr.deletecontent(id);
				else if(action == "previewcontent") psctntmgr.previewcontent(id);
				else {
		
					// this is a plugin action
			
					try{
						eval(action + "(" + id + ",'" + psctntmgr.language + "')");
					}
					catch(e){
						console.log('An error has occurred: '+e.message);
					}

			
				}
						
	
			});
	
	
			$(".childless_page_listitem").contextMenu({
				menu: 'childlesspageMenu'
			}, function(action, el, pos) {
	
				var id = $(el).attr('id');
	
	
				id = id.replace("page_anchor_","");
		 	
				if(action == "editcontent") psctntmgr.editcontent(id);
				else if(action == "copycontent") psctntmgr.copycontent(id);		
				else if(action == "addsubcontent") psctntmgr.addsubcontent(id);
				else if(action == "deletecontent") psctntmgr.deletecontent(id);
				else if(action == "previewcontent") psctntmgr.previewcontent(id);
				else {
		
					// this is a plugin action
			
					try{
						eval(action + "(" + id + ",'" + psctntmgr.language + "')");
					}
					catch(e){
						console.log('An error has occurred: '+e.message);
					}

			
				}

		
	
			});
		
		}


});
	
var psctntmgr = new pscontentmanager();
	

	


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




// peterd - extent the functionality of array function so we 
//can remove items easily
Array.prototype.removeItem=function(str) {

	for(i=0; i<this.length ; i++){
		if(escape(this[i]).match(escape(str.trim()))){
			this.splice(i, 1);  break;
		}
	}
  return this;
}


$(document).ready(function() {

	psctntmgr.restore_node_visiblestates();
	

	psctntmgr.initmaincontextmenus();
	
	
	

});

