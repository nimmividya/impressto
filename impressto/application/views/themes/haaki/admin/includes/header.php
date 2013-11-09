<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


    <div id="slide_wrapper">
        <div id="slide_panel" class="wrapper">
            <div id="slide_content" style="padding:25px;">
                <span id="slide_close"><img src="/assets/public/101/images/blank.gif" alt="" class="round_x16_b" /></span>

	
				<div class="row cf">
					<div class="dp75 taj">
                        <h4 class="sepH_b">Messages</h4>
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
	
			<ul class="new_items fr">
				<li class="sep">Welcome <a href="#">Admin</a></li>
				<li class="sep"><a href="/auth/logout">Logout</a></li>
				<li id="slide_open"><span class="count_el">2</span> Messages<img src="/assets/public/101/images/blank.gif" alt="" class="arrow_down_a" /></li>
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

			
			    <div id="mainnaviconsslider">
                        <a class="buttons prev" href="#">left</a>
                        <div class="viewport">
           			<ul class="fr cf overview" id="main_nav">
				<li class="nav_item active lgutipL" title="Dashboard"><a href="/admin/" class="main_link"><img class="img_holder" style="background-image: url(/assets/public/101/images/icons/dashboard.png)" alt="" src="/assets/public/101/images/blank.gif"/><span>Dashboard</span></a><img class="tick tick_a" alt="" src="/assets/public/101/images/blank.gif" /></li>
				<li class="nav_item lgutipR" title="Review Snap"><a href="https://www.reviewsnap.com/login.cfm" class="main_link"><img class="img_holder" style="background-image: url(/assets/public/101/images/icons/reviewsnap.png)" alt="" src="/assets/public/101/images/blank.gif"/><span>Review Snap</span></a></li>
				<li class="nav_item lgutipT" title="HR Portal"><a href="http://bitmobile.bitheads.com/kb/" class="main_link"><img class="img_holder" style="background-image: url(/assets/public/101/images/icons/mobilekb.png)" alt="" src="/assets/public/101/images/blank.gif"/><span>Mobile KB</span></a></li>

				<li class="nav_item lgutipT" title="HR Portal"><a href="https://64.26.142.205/HrPortal/TimeEntry/" class="main_link"><img class="img_holder" style="background-image: url(/assets/public/101/images/icons/hrportal.png)" alt="" src="/assets/public/101/images/blank.gif"/><span>HR Portal</span></a></li>
				<li class="nav_item lgutipB" title="Aliquam erat volutpat. Nulla tempor tincidunt scelerisque."><a href="users.html" class="main_link"><img class="img_holder" style="background-image: url(/assets/public/101/images/icons/users.png)" alt="" src="/assets/public/101/images/blank.gif"/><span>Admin/Users</span></a></li>
				<li class="nav_item"><a href="https://www.yammer.com/bitheads.com" class="main_link"><img class="img_holder" style="background-image: url(/assets/public/101/images/icons/yammer.png)" alt="" src="/assets/public/101/images/blank.gif"/><span>Yammer</span></a></li>
				<li class="nav_item"><a href="https://trello.com/" class="main_link"><img class="img_holder" style="background-image: url(/assets/public/101/images/icons/trello.png)" alt="" src="/assets/public/101/images/blank.gif"/><span>Trello</span></a></li>
				<li class="nav_item"><a href="http://support.bitheadsinc.local/portal" class="main_link"><img class="img_holder" style="background-image: url(/assets/public/101/images/icons/itsupport.png)" alt="" src="/assets/public/101/images/blank.gif"/><span>IT Support</span></a></li>
			</ul>
                        </div>
                        <a class="buttons next" href="#">right</a>
                    </div>
								

		</div>
	</div>