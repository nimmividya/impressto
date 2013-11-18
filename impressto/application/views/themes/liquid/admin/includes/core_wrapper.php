<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Super Admin Section | <?php echo PROJECTNAME; ?></title>
		<!-- The base tag can cause issues with jQuery UI 1.9 Tabs. SEE http://bugs.jqueryui.com/ticket/8637 -->
		<base href="<?php echo base_url(); ?>" />
    
			
		<?php
	
		//$data['main_content'] = $main_content;
						
		// load up all the header assets after the content is loader
		echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/header_includes', $data, TRUE); 
			
		
	?>

    </head>
    <body class="full_width">

		
		<div id="maincontainer" class="clearfix">

			<header>
				<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
					<div class="navbar-inner">
						<div class="container" style="width:100%">
						
										
							<a class="brand" href="/<?php echo PROJECTNAME; ?>-admin"><img style="max-height:50px; margin-top:-2px;" src="<?php
										
							$clientlogo = ASSET_ROOT . "public/" . $this->config->item('projectnum') . "/images/logo_mini.png";
							$defaultlogo = ASSET_ROOT . PROJECTNAME . "/default/themes/liquid/img/logo_mini.png";
								
							if(file_exists($clientlogo)) echo ASSETURL . "public/" . $this->config->item('projectnum') . "/images/logo_mini.png";
							else echo ASSETURL . PROJECTNAME . "/default/themes/liquid/img/logo_mini.png";
											
							?>" alt="<?php echo ucwords(str_replace("_"," ",PROJECTNAME)); ?> by <?php echo VENDOR; ?>" />
							
							</a>
			
							<ul class="nav navbar-nav user_menu pull-right">
				
								<li class="dropdown">
                                    <a href="/admin_help/" target="_blank"><i class="icon-book icon-white"></i> Help</a>
			                     </li>
										
									
				                            
                                <li class="divider-vertical hidden-phone hidden-tablet"></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php
									
									echo $this->session->userdata('username');
									
									
									?> <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
										<li><a href="/edit_my_profile">My Profile</a></li>
										<li><a href="/site_settings/">Site Settings</a></li>
										<li class="divider"></li>
										<li><a href="/logout/">Log Out</a></li>
                                    </ul>
                                </li>
							</ul>
						</div>
					</div>
				</nav>
				
				<div class="modal fade" id="myMail">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3 class="modal-title">New Messages</h3>
							</div>
							<div class="modal-body">
								<div class="alert alert-info">In this table jquery plugin turns a table row into a clickable link.</div>
								<table class="table table-condensed table-striped" data-provides="rowlink">
									<thead>
										<tr>
											<th>Sender</th>
											<th>Subject</th>
											<th>Date</th>
											<th>Size</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Declan Pamphlett</td>
											<td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
											<td>23/05/2012</td>
											<td>25KB</td>
										</tr>
										<tr>
											<td>Erin Church</td>
											<td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
											<td>24/05/2012</td>
											<td>15KB</td>
										</tr>
										<tr>
											<td>Koby Auld</td>
											<td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
											<td>25/05/2012</td>
											<td>28KB</td>
										</tr>
										<tr>
											<td>Anthony Pound</td>
											<td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
											<td>25/05/2012</td>
											<td>33KB</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default">Go to mailbox</button>
							</div>
						</div>
					</div>
				</div>
				
				<div class="modal fade" id="myTasks">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3 class="modal-title">New Tasks</h3>
							</div>
							<div class="modal-body">
								<div class="alert alert-info">In this table jquery plugin turns a table row into a clickable link.</div>
								<table class="table table-condensed table-striped" data-provides="rowlink">
									<thead>
										<tr>
											<th>id</th>
											<th>Summary</th>
											<th>Updated</th>
											<th>Priority</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>P-23</td>
											<td><a href="javascript:void(0)">Admin should not break if URL…</a></td>
											<td>23/05/2012</td>
											<td><span class="label label-danger">High</span></td>
											<td>Open</td>
										</tr>
										<tr>
											<td>P-18</td>
											<td><a href="javascript:void(0)">Displaying submenus in custom…</a></td>
											<td>22/05/2012</td>
											<td><span class="label label-warning">Medium</span></td>
											<td>Reopen</td>
										</tr>
										<tr>
											<td>P-25</td>
											<td><a href="javascript:void(0)">Featured image on post types…</a></td>
											<td>22/05/2012</td>
											<td><span class="label label-success">Low</span></td>
											<td>Updated</td>
										</tr>
										<tr>
											<td>P-10</td>
											<td><a href="javascript:void(0)">Multiple feed fixes and…</a></td>
											<td>17/05/2012</td>
											<td><span class="label label-warning">Medium</span></td>
											<td>Open</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default">Go to task manager</button>
							</div>
						</div>
					</div>
				</div>
				
			</header>
			
			

            <div id="contentwrapper">
   
   
                   <div class="main_content">
				
				
                    

   				<?php echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/breadcrumbs', $data, TRUE); ?>

					
								
					<?php
				
								

if(isset($parsedcontent)){
	echo $parsedcontent;
}else{
	$this->load->view($main_content, $data); 
}


	?>
	
	<div class="clearfix"></div>
	
	<div style="bottom: 0; left: 180; margin-bottom:20px;">
	


	</div>						
                        
                </div>
				
   
   
            </div>
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
<div class="sidebar">
	
	<div class="sidebar_inner_scroll">
		<div class="sidebar_inner">
		
				<?php
				
				$clientlogo = ASSET_ROOT . "public/" . $this->config->item('projectnum') . "/images/logo.png";
				if(file_exists($clientlogo)){ ?>
				
				<a href="/" target="_blank"><img border="0" src="<?php
				echo ASSETURL . "public/" . $this->config->item('projectnum') . "/images/logo.png";
				?>" alt="<?php echo ucwords(str_replace("_"," ",PROJECTNAME)); ?> by <?php echo VENDOR; ?>" /></a>

				<?php }
				
				$cache_id = 'adminleftnav_' . $this->session->userdata('role') . '_' . $this->config->item('current_menu_section') . '_'. $this->router->class;
				
											
				//if( ! $leftnav = $this->cache->get($cache_id)){
					$leftnav = $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/leftnav', $data, TRUE); 
					//$this->cache->write($leftnav,$cache_id);
				//}
				
				
				?>

			<div id="side_accordion" class="panel-group">
			
			
				<?=$leftnav?>
			
			
			



				
				
				
				

	
			</div>
			
			<div class="push"></div>
		</div>
					   
		<div class="sidebar_info">
		
			<div style="padding:2px;">
						<?php echo ucwords(str_replace("_"," ",PROJECTNAME)); ?>
						<br />&copy;<?php echo date("Y")?>, <a href="http://<?php echo VENDORURL; ?>" target="_blank"><?php echo VENDOR; ?></a>.
						<br />Generated in <?php $this->benchmark->mark('code_end'); echo $this->benchmark->elapsed_time('code_start', 'code_end'); ?> seconds
			</div>
									
			<ul class="list-unstyled">
				<li>
					<span class="act act-warning">65</span>
					<strong>New comments</strong>
				</li>
				<li>
					<span class="act act-success">10</span>
					<strong>New articles</strong>
				</li>
				<li>
					<span class="act act-danger">85</span>
					<strong>New registrations</strong>
				</li>
			</ul>
		</div> 
	</div>
	
</div>

	

	  
</div>


		
<div id="ajaxLoadAni">
	<img src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/images/ajax-loader.gif" alt="Ajax Loading Animation" />
	<span>Processing...</span>
</div><!-- [END] #ajaxLoadAni -->



<?php
	
	
	echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/footer_includes', $data, TRUE); 
		
?>


					</body>
				</html>
