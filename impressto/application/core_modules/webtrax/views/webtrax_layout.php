<?php
/*
@Name: User Management
@Type: PHP
@Filename: users.php
@Description: manage site users
@Author: Nimmitha Vidyathilaka
@Projectnum: 1001
@Version: 1.2
@Status: in development
@Date: 2012-10-15
*/
?>

<div class="admin-box">
<h3>Users</h3>
<?=$infobar?>

<?php

$request_uri = getenv("REQUEST_URI");

?>



<div id="crudTabs" style="display: none;">
    <ul>
        <li><a href="<?=$request_uri?>#crudread">Users</a></li>
        <li><a href="<?=$request_uri?>#crudcreate">Add New User</a></li>
		<li><a href="<?=$request_uri?>#roles_manager">Roles</a></li>
		<li><a href="<?=$request_uri?>#extended_user_fields">Extended User Fields</a></li>
        <li><a href="<?=$request_uri?>#advanced_settings"">Advanced User Settings</a></li>		
        <li><a href="/webtrax/admin_remote/load">WebTraX</a></li>
    </ul>
 
    <div id="crudread">
        <table id="crudRecords" class="table table-striped table-bordered table-condensed"></table>
    </div>

    <div id="crudcreate">
		<form action="" method="post">
           <p>
               <label for="cfirst_name">First Name:</label>
               <input type="text" id="cfirst_name" name="cfirst_name" />
           </p>
           <p>
               <label for="clast_name">Last Name:</label>
               <input type="text" id="clast_name" name="clast_name" />
           </p>
		   <p>
               <label for="cusername">Username:</label>
               <input type="text" id="cusername" name="cusername" />
           </p>
		   <p>
               <label for="cpassword">Password:</label>
               <input type="password" id="cpassword" name="cpassword" />
           </p>
		   <p>
               <label for="cemail_address">Email Address:</label>
               <input type="text" id="cemail_address" name="cemail_address" />
           </p>
		   
		   <p>
                <label for="cuser_role">Role:</label>
				<ul style="height: 20px;">
					<?php
					$roles = load_defined_roles();
					
					foreach($roles AS $role_name => $role_id){ ?>
						
						<li style="float: left;margin-right:10px;" ><?= form_radio('cuser_role', $role_id, FALSE)?>&nbsp;<?=$role_name?></li>
							
					<?php } ?>
				</ul>
		   </p>
		   <div class="clearfix"></div>
           <p>
			  <button class="btn btn-default" type="submit" name="createSubmit">Submit</button>
           </p>
        </form>
	</div>

    <div id="roles_manager"></div>
	
    <div id="extended_user_fields">
	
		
		<div id="user_fields_main_buttons">
	
		<button class="btn btn-default" type="button" onclick="userfield_manager.edit_user_field('');" id="new-userfield_btn" name="new-userfield_btn">New User Field</button>
		
		

		<?php
		
		$userfieldroles = array_merge( array("Show All"=>""),$roles);
		
	
		$fielddata = array(
		'name'        => "user_field_role_filter",
		'type'          => 'select',
		'id'          => "user_field_role_filter",
		'label'          => "Roles",
		'width'          => 200,
		'usewrapper'          => FALSE,
		'onchange' => "userfield_manager.reload_user_fields()",
		'options' =>  $userfieldroles,
		);
					
		echo $this->formelement->generate($fielddata);
	
		?>
	
		</div>
		
		
		
		<div id="userfield_edit_div" style="display:none">
		
		
		
		</div>
	
		<br />

	
		
		<div id="userfield_list_div"></div>
		

		
	
	</div>
	
	
   <div id="advanced_settings">
   
   remap the default user table to custom tables (such as fluxbb). although this should really be taking care of itself via a flubb bb plugin module.
   	
			<?=$advanced_settings_table?>
			

				
   
   
   </div>

	
    <div id="webtrax"></div>
	
</div> <!-- [END] #crudTabs -->

</div>


<div id="crudupdateDialog" title="Update">
    <div>
        <form action="" method="post">
			<p>
               <label for="first_name">First Name:</label>
               <input type="text" id="first_name" name="first_name" />
            </p>
			<p>
               <label for="last_name">Last Name:</label>
               <input type="text" id="last_name" name="last_name" />
            </p>
            <p>
               <label for="username">Username:</label>
               <input type="text" id="username" name="username" />
            </p>
			
			<p>
               <label for="password">Password:</label>
               <input type="password" id="password" name="password" />
           </p>
		   
            
            <p>
               <label for="email_address">Email Address:</label>
               <input type="text" id="email_address" name="email_address" />
            </p>
			
		   <p>
               <label for="cemail_address">Role:</label>
    			   
			   <?php 
			   
		   
			   $roles = load_defined_roles();
		   	
		   
			   foreach($roles AS $role_name => $role_id){ 
				
							
					$data = array(
						'name'        => 'urole',
						'id'          => 'urole_' . $role_id,
						'value'       => $role_id,
						'checked'     => FALSE
					);
	
					
			   
			   ?>
			   
				<div style="float:left; margin-left:10px;"><?=form_radio($data)?>&nbsp;<?=$role_name?></div>
				
					
				<?php } ?>
				
				
           </p>
		   

            
            <input type="hidden" id="userId" name="id" />
        </form>
    </div>
</div>
<div id="cruddelConfDialog" title="Confirm">
	<p>Are you sure?</p>
</div>
<div id="crudmsgDialog"><p></p></div>

<div id="webtraxPopup"></div>

<script type="text/template" id="readTemplate">
	<tr id="${id}">
		<td>${id}</td>
		<td>${first_name}</td>
		<td>${last_name}</td>
		<td>${username}</td>
		<td>${email_address}</td>
		<td>${role}</td>
		<td><a class="updateBtn btn btn-default-small" href="${updateLink}">Update</a>&nbsp;<a class="deleteBtn btn btn-default-small" href="${deleteLink}">Delete</a></td>
	</tr>
</script>





