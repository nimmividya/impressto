<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Super Admin Section | <?php echo PROJECTNAME; ?></title>
	<base href="<?php echo base_url(); ?>" />
	

	<?php
	
	//$data['main_content'] = $main_content;
						
	// load up all the header assets after the content is loader
	echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/header_includes', $data, TRUE); 
			
		
	?>
	
	</head>
	<body style="padding:10px;">
	
<body class="bg_c sidebar fixed">

    <div id="slide_wrapper">
        <div id="slide_panel" class="wrapper">
            <div id="slide_content">
                <span id="slide_close"><img src="images/blank.gif" alt="" class="round_x16_b" /></span>

				<div class="cf">
					<div class="dp100 sortable"><p class="s_color tac sepH_a">You can drag widgets from dashboard and drop it here.</p></div>
				</div>

				<div class="row cf">
					<div class="dp75 taj">
                        <h4 class="sepH_b">Lorem ipsum dolor sit amet...</h4>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam enim diam, vulputate vitae pharetra vel, pretium dictum ligula. In mauris eros, aliquam sit amet ullamcorper id, dictum eget ipsum. Nulla non porta arcu. Pellentesque faucibus, erat id interdum accumsan, neque magna ultrices ante, at laoreet lorem sem sit amet risus. Proin quis turpis ac nulla faucibus luctus at ac nisl. Suspendisse adipiscing turpis non risus tempus sit amet rhoncus est luctus. Cras in accumsan nulla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam enim diam, vulputate vitae pharetra vel, pretium dictum ligula. In mauris eros, aliquam sit amet ullamcorper id, dictum eget ipsum. Nulla non porta arcu. Pellentesque faucibus, erat id interdum accumsan, neque magna ultrices ante, at laoreet lorem sem sit amet risus. Proin quis turpis ac nulla faucibus luctus at ac nisl. Suspendisse adipiscing turpis non risus tempus sit amet rhoncus est luctus. Cras in accumsan nulla.
                    </div>
					<div class="dp25">
                        <div id="chart_k"></div>
                    </div>
				</div>
            </div>
        </div>
    </div>

	<div id="top_bar">
		<div class="wrapper cf">
			<ul class="fl">
				<li class="sep">Welcome <a href="#">Admin</a></li>
				<li class="sep"><a href="login.html">Logout</a></li>
				<li><a href="#">Front End Preview</a></li>
			</ul>
			<ul class="new_items fr">
				<li class="sep"><span class="count_el">2</span> <a href="#">new messages</a></li>
				<li class="sep"><span class="count_el">10</span> <a href="#">new comments</a></li>
				<li class="sep"><span class="count_el">4</span> <a href="#">tasks</a></li>
				<li id="slide_open">sliding panel<img src="images/blank.gif" alt="" class="arrow_down_a" /></li>
			 </ul>
		</div>
	</div>

	<div id="header">
		<div class="wrapper cf">
			<div class="logo fl">
				<a href="/"><?php
								
					$clientlogo = ASSET_ROOT . "public/" . $this->config->item('projectnum') . "/images/logo.png";
					
					if(file_exists($clientlogo)){ ?>
					
						<a href="/" target="_blank"><img border="0" src="<?php echo ASSETURL . "public/" . $this->config->item('projectnum') . "/images/logo.png"; ?>" alt="<?php echo ucwords(str_replace("_"," ",PROJECTNAME)); ?> by <?php echo VENDOR; ?>" /></a>
							
					<?php } ?>
				
											
			</div>
			<ul class="fr cf" id="main_nav">
				<li class="nav_item active lgutipL" title="Aliquam erat volutpat. Nulla tempor tincidunt scelerisque."><a href="/admin/" class="main_link"><img class="img_holder" style="background-image: url(images/icons/computer_imac.png)" alt="" src="images/blank.gif"/><span>Dashboard</span></a><img class="tick tick_a" alt="" src="images/blank.gif" /></li>
				<li class="nav_item lgutipR" title="Aliquam erat volutpat. Nulla tempor tincidunt scelerisque."><a href="content.html" class="main_link"><img class="img_holder" style="background-image: url(images/icons/file_cabinet.png)" alt="" src="images/blank.gif"/><span>Content</span></a></li>
				<li class="nav_item lgutipT" title="Aliquam erat volutpat. Nulla tempor tincidunt scelerisque."><a href="file_explorer.html" class="main_link"><img class="img_holder" style="background-image: url(images/icons/image2_2.png)" alt="" src="images/blank.gif"/><span>Media library</span></a></li>
				<li class="nav_item lgutipB" title="Aliquam erat volutpat. Nulla tempor tincidunt scelerisque."><a href="users.html" class="main_link"><img class="img_holder" style="background-image: url(images/icons/users2.png)" alt="" src="images/blank.gif"/><span>Users</span></a></li>
				<li class="nav_item"><a href="tasks.html" class="main_link"><img class="img_holder" style="background-image: url(images/icons/create_write.png)" alt="" src="images/blank.gif"/><span>Tasks</span></a></li>
				<li class="nav_item"><a href="charts.html" class="main_link"><img class="img_holder" style="background-image: url(images/icons/chart8.png)" alt="" src="images/blank.gif"/><span>Reports</span></a></li>
				<li class="nav_item"><a href="../documentation/index.html" class="main_link"><img class="img_holder" style="background-image: url(images/icons/help.png)" alt="" src="images/blank.gif"/><span>Documentation</span></a></li>
			</ul>
		</div>
	</div>

	<div id="main">
		<div class="wrapper">
			<div id="main_section" class="cf brdrrad_a">

				<ul id="breadcrumbs" class="xbreadcrumbs cf">
					<li class="parent">
						<img src="images/blank.gif" alt="" class="sepV_a vam home_ico" />
						<a href="dashboard.html" class="vam">bitHeads Central</a>
						<ul class="first">
							<li><a href="#">Content</a></li>
							<li><a href="#">Media library</a></li>
							<li><a href="#">Users</a></li>
							<li><a href="#">Tasks</a></li>
							<li><a href="#">Reports</a></li>
							<li><a href="#">Settings</a></li>
						</ul>
					</li>
					<li class="parent">
						<a href="#">Content</a>
						<ul>
							<li><a href="#">Articles</a></li>
							<li><a href="#">Pages</a></li>
							<li><a href="#">Custom content</a></li>
						</ul>
					</li>
					<li class="parent">
						<a href="#">Articles</a>
						<ul>
							<li><a href="#">Show All</a></li>
							<li><a href="#">Create new</a></li>
						</ul>
					</li>
					<li class="current"><a href="#">Contact page</a></li>
				</ul>

				<div id="content_wrapper">
					<div id="main_content">
				
	<?php
	
	if(isset($parsedcontent)) echo $parsedcontent;
	else $this->load->view($main_content, $data); 
	
	?>
	
		</div>
				</div>

				<div id="sidebar">
				
				
						<?php
								
						$cache_id = 'adminleftnav_' . $this->session->userdata('role') . '_' . $this->config->item('current_menu_section') . '_'. $this->router->class;
								
						//if( ! $leftnav = $this->cache->get($cache_id)){
							$leftnav = $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/leftnav', $data, TRUE); 
							//$this->cache->write($leftnav,$cache_id);
					//	}
								
								
						echo $leftnav; 
												
								
						?>
			
				</div>

			</div>
		</div>
	</div>

	<div id="footer">
	   <div class="wrapper">
		  <div class="cf ftr_content">
	
			<a href="javascript:void(0)" class="toTop">Back to top</a>
		  </div>
	   </div>
	</div>
	
	
	<div id="ajaxLoadAni">
		<img src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/images/ajax-loader.gif" alt="Ajax Loading Animation" />
		<span>Processing...</span>
	</div><!-- [END] #ajaxLoadAni -->

</body>
</html>