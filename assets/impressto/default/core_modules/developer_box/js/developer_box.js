

$(document).ready(function() {

	// load the SVN commit logs for this project
	$('#svncommits_div').load('/springloops/');
	
	// setup to refresh every 5 minutes
	$.ajaxSetup({ cache: false }); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
	

	setInterval(function() {
		$('#svncommits_div').load('/springloops/');
		
	}, 300000); 
	
		
	  
	$(".developer_box_wrap").fadeIn();
	$(".developer_box_main").hide();
		  
	$('#developer_box_link').toggle(

		function() {
		
			$(".svncommits_box_wrap").hide();
			$(".rssfeeds_box_wrap").hide();
			$(".dropbox_box_wrap").hide();
			$(".androidcheckmark_box_wrap").hide();
			
		
			$('.developer_box_main').show( function() {
				$('.developer_box_main').animate({
					width: '300'
				}, 500, function(){
				
					$('.developer_box_main').show();
				
				
				});
			});
			$('#developer_box_img').attr("src", ps_base.asseturl + ps_base.appname + "/default/widgets/developer_box/images/close.png");

		},

		function() {
			$('.developer_box_main').animate({
				width: "0"
			}, 500, function() {
				$('.developer_box_main').hide();
				$('#developer_box_img').attr("src", ps_base.asseturl + ps_base.appname + "/default/widgets/developer_box/images/tickets.png");
				
				$(".svncommits_box_wrap").show();
				$(".rssfeeds_box_wrap").show();
				$(".dropbox_box_wrap").show();
				$(".androidcheckmark_box_wrap").show();
				
				
			});
	});
	
	
	
	$(".svncommits_box_wrap").fadeIn();
	$(".svncommits_box_main").hide();
		  
	$('#svncommits_box_link').toggle(

		function() {

			$(".developer_box_wrap").hide();
			$(".rssfeeds_box_wrap").hide();
			$(".dropbox_box_wrap").hide();
			$(".androidcheckmark_box_wrap").hide();
		
			$('.svncommits_box_main').show( function() {
			
			
				$('.svncommits_box_main').animate({
					width: '300'
				}, 500, function(){
				
					$('.svncommits_box_main').show();
				
				
				});
			});
			$('#svncommits_box_img').attr("src", ps_base.asseturl + ps_base.appname + "/default/widgets/developer_box/images/close.png");

		},

		function() {
			$('.svncommits_box_main').animate({
				width: "0"
			}, 500, function() {
				$('.svncommits_box_main').hide();
				$('#svncommits_box_img').attr("src", ps_base.asseturl + ps_base.appname + "/default/widgets/developer_box/images/svn.png");
				
				$(".developer_box_wrap").show();
				$(".rssfeeds_box_wrap").show();
				$(".dropbox_box_wrap").show();
				$(".androidcheckmark_box_wrap").show();

			});
	});
	
	
	
	
	
	
	
	$(".rssfeeds_box_wrap").fadeIn();
	$(".rssfeeds_box_main").hide();
		  
	$('#rssfeeds_box_link').toggle(

		function() {

			$(".developer_box_wrap").hide();
			$(".svncommits_box_wrap").hide();
			$(".dropbox_box_wrap").hide();
			$(".androidcheckmark_box_wrap").hide();
			
			$('.rssfeeds_box_main').show( function() {
			
			
				$('.rssfeeds_box_main').animate({
					width: '294'
				}, 500, function(){
				
					$('.rssfeeds_box_main').show();
				
				
				});
			});
			$('#rssfeeds_box_img').attr("src", ps_base.asseturl + ps_base.appname + "/default/widgets/developer_box/images/close.png");

		},

		function() {
			$('.rssfeeds_box_main').animate({
				width: "0"
			}, 500, function() {
				$('.rssfeeds_box_main').hide();
				$('#rssfeeds_box_img').attr("src", ps_base.asseturl + ps_base.appname + "/default/widgets/developer_box/images/rss.png");
				
				$(".developer_box_wrap").show();
				$(".svncommits_box_wrap").show();
				$(".dropbox_box_wrap").show();
				$(".androidcheckmark_box_wrap").show();
				

			});
	});
	
	
	
	$(".dropbox_box_wrap").fadeIn();
	$(".dropbox_box_main").hide();
		  
	$('#dropbox_box_link').toggle(

		function() {

			$(".developer_box_wrap").hide();
			$(".svncommits_box_wrap").hide();
			$(".rssfeeds_box_wrap").hide();
			$(".androidcheckmark_box_wrap").hide();
			
			$('.dropbox_box_main').show( function() {
			
			
				$('.dropbox_box_main').animate({
					width: '294'
				}, 500, function(){
				
					$('.dropbox_box_main').show();
				
				
				});
			});
			$('#dropbox_box_img').attr("src", ps_base.asseturl + ps_base.appname + "/default/widgets/developer_box/images/close.png");

		},

		function() {
		
			$('.dropbox_box_main').animate({
				width: "0"
			}, 500, function() {
				//$('.dropbox_box_main').hide();
				$('#dropbox_box_img').attr("src", ps_base.asseturl + ps_base.appname + "/default/widgets/developer_box/images/dropbox.png");
				
				$(".developer_box_wrap").show();
				$(".svncommits_box_wrap").show();
				$(".rssfeeds_box_wrap").show();
				$(".androidcheckmark_box_wrap").show();
				

			});
	});
	
	
	
	$(".androidcheckmark_box_wrap").fadeIn();
	$(".androidcheckmark_box_main").hide();
		
	$('#androidcheckmark_box_link').toggle(

		function() {
		
			$(".svncommits_box_wrap").hide();
			$(".rssfeeds_box_wrap").hide();
			$(".dropbox_box_wrap").hide();
			$(".developer_box_wrap").hide();
		
			$('.androidcheckmark_box_main').show( function() {
				$('.developer_box_main').animate({
					width: '300'
				}, 500, function(){
				
					$('.androidcheckmark_box_main').show();
				
				
				});
			});
			$('#androidcheckmark_box_img').attr("src", ps_base.asseturl + ps_base.appname + "/default/widgets/developer_box/images/close.png");

		},

		function() {
			$('.androidcheckmark_box_main').animate({
				width: "0"
			}, 500, function() {
				$('.androidcheckmark_box_main').hide();
				$('#androidcheckmark_box_img').attr("src", ps_base.asseturl + ps_base.appname + "/default/widgets/developer_box/images/androidcheckmark.png");
				
				$(".svncommits_box_wrap").show();
				$(".rssfeeds_box_wrap").show();
				$(".dropbox_box_wrap").show();
				$(".developer_box_wrap").show();
				
			});
	});
	
	
	
	
	
});
	