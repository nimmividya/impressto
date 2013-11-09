<script>

function setversionconfirm(){

	var url = "/dashboard/setversionconfirm";
	
	$.get(url, function(data) {
		
		if(data == "complete"){
			$('#ps_version_confirm_notice').fadeOut();
		}
		
	});
	
	
	

}

</script>
<h1>PROFILE PAGE</h2>

<br />

<form id="my_profile_form">

<?php





foreach($profile_field_data AS $key => $val){


	if(!isset($val['field_type'])) $val['field_type'] = "text";
			
		
	$fielddata = array(
		'name'        => $key,
		'id'          => $key,
		'type'          => $val['field_type'],
		'usewrapper'          => FALSE,
		'value'  => $val['value'],
		'label'          => $key,
		'type'          => $val['field_type'],
		'width' =>  '200px'
	);
	
	if(
		$val['field_type'] == "radio"
		||
		$val['field_type'] == "select"
		||
		$val['field_type'] == "multiselect"
		||
		$val['field_type'] == "multicheck"
	){
	
		Console::log($val);
		$fielddata['options'] =  $val['options'];	
		
	}
	
	echo $this->formelement->generate($fielddata);
	
	
	echo "<br />";
	
	
			
	
		
		
		
	
}


?>

<button class="btn" type="button" onclick="ps_my_profile_manager.save_profile();" ><i class="icon-ok"></i> Save</button>
</form>
