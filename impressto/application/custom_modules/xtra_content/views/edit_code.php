<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

					
	if(isset($xtra_content) && is_array($xtra_content)){ //[xtra_mobile_field_1] => here we are
	
		foreach($xtra_content AS $field_name => $field_data){
		
			?>
			<div class="clearfix"></div>
			<h4><?=$field_name?></h4>
			
			<?php
			
				if($field_data['type'] == "int"){
				
					$fielddata = array(
						'name'        => $field_name,
						'type'          => 'text',
						'id'          => $field_name,
						'label'          => "",
						'width'          => 80,
						'usewrapper'          => false,
						'value'       =>  $field_data['content']
					);
					
					echo $this->formelement->generate($fielddata);
					
				
				}else if($field_data['type'] == "varchar"){
				
					$fielddata = array(
						'name'        => $field_name,
						'type'          => 'text',
						'id'          => $field_name,
						'label'          => "",
						'width'          => 500,
						'usewrapper'          => false,
						'value'       =>  $field_data['content']
					);
					
					echo $this->formelement->generate($fielddata);
							
				
				
				}else{
				
					$config = array(
						"content" => $field_data['content'],
						"name" => $field_name, 
						"lang" => "en", 					
						"height" => 200, 
						"toolbar" => "Full" 		
						
					);
						
					echo $this->edittools->insert_wysiwyg($config);
					
				}
				
				
				?>
				
				<div class="clearfix"></div>
				
				<?php
				
			}
			
		}
		
	?>		