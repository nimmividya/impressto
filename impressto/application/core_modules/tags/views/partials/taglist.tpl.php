	<br>
	<BR>


	
	<table border=0 cellpadding=2><tr>
	
	<td><b>Keywords</b></td>
	<td><b>URL</b></td>
	<td><b>User</b></td>
	<td><b>ID</b></td>
	<td><b>Date</b></td>
	
	<td></td>
	</tr>
	
	<?php
	

	$records = array();

	while($frs->next()) { 

		if($bgcolor == "#CFCFCF"){ $bgcolor="#DDDDDD";  }
		else { $bgcolor="#CFCFCF"; }
	
		$this_record_Keywords = $frs->getCurrentValueByName("Keywords");
		$this_record_URL = $frs->getCurrentValueByName("URL");
		$this_record_IPA = $frs->getCurrentValueByName("IPA");
		$this_record_ID = $frs->getCurrentValueByName("ID");
		$this_record_Date = $frs->getCurrentValueByName("Date");


		$this_record_year = substr($this_record_Date,0,4);
		$this_record_month = substr($this_record_Date,4,2);
		$this_record_day = substr($this_record_Date,6,2);
		$this_record_hour = substr($this_record_Date,8,2);
		$this_record_minute = substr($this_record_Date,10,2);

		$daysback = date_diff($this_record_year,$this_record_month,$this_record_day);

		$this->load->view('header');
		


	}
	
	?>
	
	</table>
		
	
