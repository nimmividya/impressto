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

<h3><i class="icon-user"></i> Users</h3>
<?=$infobar?>

<?php

$request_uri = getenv("REQUEST_URI");

?>


<!-- 
<div id="user_management_tabs" style="display: none;">
-->


<div id="user_management_tabs">



    <ul>
        <li><a href="<?=$request_uri?>#crudread">Users</a></li>
 		<li><a href="<?=$request_uri?>#roles_manager">Roles</a></li>
		<li><a href="<?=$request_uri?>#groups_manager">Groups</a></li>
		<li><a href="<?=$request_uri?>#extended_user_fields">Extended User Fields</a></li>
        <li><a href="<?=$request_uri?>#advanced_settings">Advanced User Settings</a></li>		
    </ul>
 
    <div id="crudread">
	
		<button class="btn" onclick="ps_usermanager.edit_user('')">Add User</button>
		
	
		
		<input type="text" />
		<select>
		<option value="">filter by</option>
		</select>
		<button class="btn">Search</button>
		
		
		<div class="clearfix"></div>
	

		
		<div class="clearfix"></div>
		
        <table id="users_table" class="crudRecords" class="table table-striped table-bordered table-condensed">
		<tr style="font-weight: bold;">
		<td></td>
		<td>id</td>
		<?php foreach($priority_fields AS $val){
			echo "<td>{$val}</td>\n";
		}
		?>
		

		
		<td>&nbsp;</td>
		</tr>
		
		</table>
    </div>


    <div id="roles_manager">
	

		<div style="float:right" id="add_role_btn_div"><a href="javascript:ps_usermanager.add_role()" class="btn btn-small"><i class="icon-cog"></i>  Add Role</a></div>

		<br />
		<br />

	



		
		<div id="role_record_div">
	

		
		</div>
		
	</div>
	
    <div id="groups_manager">
	
		<button class="btn">Add Group</button>
		
		<span>All () | Admin(2) | Developer (2)</span>
			
	
        <table id="groups_table" class="crudRecords" class="table table-striped table-bordered table-condensed">
		<tr style="font-weight: bold;">
		<td></td>
		<td>id</td>
		<td>User Group</td>
		<td>Description</td>
		<td>#Users</td>
		<td>&nbsp;</td>
		</tr>
		
		</table>
	
	</div>
	
	
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
   
			<form id="advanced_user_settings_form">
   
			remap the default user table to custom tables (such as fluxbb). although this should really be taking care of itself via a flubb bb plugin module.
   	
			<?=$advanced_settings_table?>
			
			
			<h5>Priority Fields</h5> (these appear in user management lists)
			
			<br />
			
			<!-- list all the default and extended fields here. -->
			<?php 
			foreach($all_fieldnames['basic'] AS $val){
			
				echo "<label><input type=\"checkbox\" name=\"priority_fields[]\" value=\"{$val}\" />{$val}</label>\n";
			
			}
			
			foreach($all_fieldnames['extended'] AS $val){
			
				echo "<label><input type=\"checkbox\" name=\"extended_priority_fields[]\" value=\"{$val}\" />{$val}</label>\n";
			
			}
					
			?>
			
			<button type="button" class="btn" onclick="ps_usermanager.save_advanced_settings()">Save</button>
			
			</form>
				
   
   
   </div>

	

	
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

 <!-- role field assignment dialog -->

               <div id="roleuserfieldEditModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				
					<form id="role_userfield_manage_form" class="form-horizontal">
									
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5 id="myModalLabel">Role User Field Assignments</h5>
                    </div>
                    <div class="modal-body">
					
					
					<select id='roleuserfield-modal-options' multiple='multiple'>
			
					 </select>
					 

						
                 
                        <div class="row-fluid">
				
					
							
                            </div>
                    
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Save changes</button>
                    </div>
					
					</form>
						
                </div>


 <!-- /role field assignment dialog -->
 
     
          <!-- Dialog content -->
                <div id="userEditModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				
					<form id="test_form" class="form-horizontal">
									
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5 id="myModalLabel">Edit User</h5>
                    </div>
                    <div class="modal-body">
                 
                        <div class="row-fluid">
				
							<!-- all this should be comind from the priority fields table -->
							
					
							
							<?php
							
							$avatarimg = ASSETURL . "/" . PROJECTNAME . "/default/core_modules/admin_users/img/avatar.png";
							
							
							
							?>
							<div style="float:left; background: url('<?=$avatarimg?>'); width:64px; height:64px">
							
							<input type="file" id="test" style="position:absolute; top:-1000px;">
											
							<div id="upload_button" style="float:left; margin-top:0px; margin-left:56px"><i style="font-size:26px;" class="icon-camera-retro"></i></div>
																			
							</div>
							
							 <span style="float:left; margin: 8px 0 0 24px" id="uploadavatar_label"></span>
							 
							 add ajax upload function here...
							
							<div class="clearfix"></div>
																				
							
					        <div class="control-group">
                                <label class="control-label">First Name:</label>
                                <div class="controls"><input type="text" name="regular" class="span12" /></div>
                            </div>
							
							<div class="control-group">
                                <label class="control-label">Last Name:</label>
                                <div class="controls"><input type="text" name="regular" class="span12" /></div>
                            </div>
							
							
                            <div class="control-group">
                                <label class="control-label">Username:</label>
                                <div class="controls"><input type="text" name="regular" class="span12" /></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">E-mail:</label>
                                <div class="controls"><input type="text" name="regular" class="span12" /></div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">Password:</label>
                                <div class="controls"><input type="text" name="regular" class="span12" /></div>
                            </div>
                             <div class="control-group">
                                <label class="control-label">Re-type:</label>
                                <div class="controls"><input type="text" name="regular" class="span12" /></div>
                            </div>
                            
                                                
                            <div class="control-group">
                                <label class="control-label">Dashboard Page:</label>
                                <div class="controls">
                                    <select name="select2" class="select" >
                                       <option value="opt1">Option 1</option>
                                        <option value="opt2">Option 2</option>
                                        <option value="opt3">Option 3</option>
                      
                      
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Role:</label>
                                <div class="controls">
                                    <select data-placeholder="Select..." class="select" tabindex="2">
                                        <option value="Stubbed">Stubbed</option>
                                        <option value="Facebook">Facebook</option>
                             
                                    </select>
                                </div>
                            </div>
							
							
                            <div class="control-group">
                                <label class="control-label">Group:</label>
                                <div class="controls"><textarea rows="1" cols="4" name="textarea" class="span12" placeholder="Add comma delimited list here..."></textarea></div>
                            </div>
                   
                            <div class="control-group">
                                <label class="control-label">Language:</label>
                                <div class="controls"><textarea rows="1" cols="4" name="textarea" class="span12" placeholder="Add comma delimited list here..."></textarea></div>
                            </div>
							
                            </div>
                    
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Save changes</button>
                    </div>
					
					</form>
						
                </div>
                <!-- /dialog content -->
				
				
<!--  role edit dialog content -->	

        <div id="roleEditModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h5 id="roleEditModalLabel">Edit Role</h5>
                 </div>
         <div class="modal-body">
		 
	

		<form id="role_edit_form" class="form-horizontal" accept-charset="utf-8">
		<input type="hidden" id="role_id" name="id" value="" />

		<fieldset>

		<legend>Edit Role Details</legend>

		<div style="float:right; margin:10px 10px;">
		<div style="float:right"><a href="javascript:ps_usermanager.cancel_role_edit()" class="btn">Cancel</a></div>

		<div style="float:right; margin-right:10px;"><a href="javascript:ps_usermanager.save_role()" class="btn btn-success"><i class="icon-ok icon-white"></i>  Save Role</a></div>

		</div>

		
		<div class="control-group ">

		<label class="control-label" for="role_name">Name</label>

		<div class="controls">
		<input type="text" id="role_name" name="name" value="" /><span class="help-inline"></span>
		</div>
	
		</div>
		<br />


		<div style="vertical-align: top" class="control-group ">
			<label for="role_description" class="control-label">Description</label>
			<div class="controls">
				<textarea class="input-xlarge" rows="3" id="role_description" name="role_description"></textarea>
				<span class="help-inline">Max. 255 characters.</span>
			</div>
		</div>
		
		<br />

		<div style="vertical-align: top" class="control-group ">
			<label for="admin_theme" class="control-label">Role Theme</label>
			<div class="controls">
			

		<?php 

		$themes = $this->template_loader->find_admin_themes();
	
		$fielddata = array(
		'name'        => "role_theme",
		'type'          => 'select',
		'id'          => "role_theme",
		'label'          => "",
		'width'          => 200,
		'usewrapper'          => FALSE,
		'options' =>  array_merge(array("Select"=>""),$themes),
		'value'       =>  (isset($option_data['admin_theme']) ? $option_data['admin_theme'] : "classic")
	);
					
	echo $this->formelement->generate($fielddata);
				
	?>
			</div>
		</div>
		
		
<br />

<div style="vertical-align: top" class="control-group ">
			<label for="profile_template" class="control-label">"My Profile" Template</label>
			<div class="controls">
			
<?=$profile_template_selector?>

			</div>
		</div>
		

<br />

<div style="vertical-align: top" class="control-group ">
			<label for="dashboard_template" class="control-label">Dashboard Template</label>
			<div class="controls">
			
			<?=$dashboard_template_selector?>
		</div>
</div>


<div style="vertical-align: top" class="control-group ">
			<label for="dashboard_page" class="control-label">Dashboard Page</label>
			<div class="controls">
<?=$dashboard_page_selector?>
		</div>
</div>



<div style="clear:both"></div>

<br />








<div style="clear:both; height:20px;"></div>

</fieldset>
</form>


 </div>
  </div>
		  

<!--  /role edit dialog content -->	
				
				
<!-- this should be in the common admin footer -->
<div id="confirmDiv"></div> 



<script id="userlist-template" type="text/x-handlebars-template">

  {{#each .}}
	<tr id="{{id}}">
		<td><input type="checkbox" name="bulk_action_{{id}}" value="1"></td>
	
		<td>{{id}}</td>
		<td>{{first_name}}</td>
		<td>{{last_name}}</td>
		<td>{{username}}</td>
		<td>{{email_address}}</td>
		<td>{{role}}</td>
		<td>{{group}}</td>
			
		<td><a href="javascript:ps_usermanager.edit_user('{{id}}');"> <i class="icon-edit"></i> </a>&nbsp;<a href="javascript:ps_usermanager.delete_user('{{id}}')"><i class="icon-remove"></i></a></td>
	</tr>
  {{/each}}
  

</script>





