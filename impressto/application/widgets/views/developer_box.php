
<div class="dropbox_box_wrap" style="display:none">
	<div class="dropbox_box_main">

		<div style="height:600px; overflow-y:scroll; overflow-x:hidden" id="dropbox_div">
	
		<?php  Widget::run('dropbox_connect/dropboxlist'); ?>
		
		 </div>
    
    </div>
    
    <div class="dropbox_box_button">
    <a style="display:block;" href="#" id="dropbox_box_link">
    <img id="dropbox_box_img" src="/assets/<?php echo PROJECTNAME; ?>/default/widgets/developer_box/images/dropbox.png" width="40" height="45" border="0" />
    </a>
    </div>
</div>



<div class="rssfeeds_box_wrap" style="display:none">

	<div class="rssfeeds_box_main" style="height:600px; overflow-y:scroll; overflow-x:hidden">

			<?php Widget::run('activecollab_connect/rss_reader'); ?>
    
    </div>
    
    <div class="rssfeeds_box_button">
    <a style="display:block;" href="#" id="rssfeeds_box_link">
    <img id="rssfeeds_box_img" src="/assets/<?php echo PROJECTNAME; ?>/default/widgets/developer_box/images/rss.png" width="40" height="45" border="0" />
    </a>
    </div>
</div>


<div class="svncommits_box_wrap" style="display:none">

	<div class="svncommits_box_main" style="min-height:200px">
	
		<div style="height:600px; overflow-y:scroll; overflow-x:hidden" id="svncommits_div"></div>
	
	</div>
    
    <div class="svncommits_box_button">
    <a style="display:block;" href="#" id="svncommits_box_link">
    <img id="svncommits_box_img" src="/assets/<?php echo PROJECTNAME; ?>/default/widgets/developer_box/images/svn.png" width="40" height="45" border="0" />
    </a>
    </div>
</div>


<div class="developer_box_wrap" style="display:none">
	<div class="developer_box_main">

			<div style="height:600px; overflow-y:scroll; overflow-x:hidden" id="ticketlist_div">
	
			<?php  Widget::run('activecollab_connect/ticketlist'); ?>
			
			</div>
			
    
    </div>
    
    <div class="developer_box_button">
    <a style="display:block;" href="#" id="developer_box_link">
    <img id="developer_box_img" src="/assets/<?php echo PROJECTNAME; ?>/default/widgets/developer_box/images/tickets.png" width="40" height="45" border="0" />
    </a>
    </div>
</div>







