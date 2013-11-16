// JavaScript Document
		var text = " "; 
		var tp_id,tp_file,tp_label;
		var data_table = '<table class="table table-striped table-bordered table-condensed">';
		
		data_table +="<thead style='font-weight:bold;'><tr><td>ID</td><td>Filename</td><td>Label</td></tr></thead>";
		
		for (var obj=0; obj<data_array.length; obj++) {
			tp_id = data_array[obj][0].toString();
			tp_file = data_array[obj][1].toString();
			tp_label = data_array[obj][2].toString();
			
			if (obj%2 == 0) {
				alternator = "style='background-color:#EAEAEA;'";
				returncolor = 0;
			} else {
				alternator = "style='background-color:#FFF;'";
				returncolor = 1;
			}
			
			mouseovercode = 'onMouseover="f_toggle_hover(0,this,'+returncolor+')" onMouseout="f_toggle_hover(1,this,'+returncolor+')"';
			 
			data_table += '<tr '+mouseovercode+' '+alternator+' >';
			data_table += '<td>'+tp_id+"</td><td>"+tp_file+"</td><td><a href='/admin/templates/edit/"+tp_id+"' class='btnSma'>"+tp_label+"</a></td>";
			data_table += "</tr>";
		}
		
		data_table += "</table>";
		document.getElementById('data_table').innerHTML = data_table;

		
		function f_toggle_hover(inorout,myhandle,returncolor) {

			if (inorout == 1) {
				if (returncolor == 1){
					myhandle.style.backgroundColor = "#FFF";
				} else {
					myhandle.style.backgroundColor = "#EAEAEA";
				}
				myhandle.style.color = "black";
			} else {
				myhandle.style.backgroundColor = "#888";
				myhandle.style.color = "white";
			}
		}
		
		
		
		
		
		