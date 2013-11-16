
var pswebtrax = appbase.extend({

current_day : 0,


construct: function() {
		//alert(this.sortorder);
	},
	

	init : function(){
	
		$( '#webtraxPopup' ).dialog({
		
			autoOpen: false,
			
			height: 320,
			width: 450,
			title: 'Trax',
			
			buttons: {
				'Close': function() {
					$( this ).dialog( 'close' );
				}
			} //end buttons
		}); //end dialog
		
		
		$('.webtrax_user_link').tooltip();
				
	},
	
		


	
trackuser: function(user_id){


		
	var url = "/webtrax/admin_remote/track_user/" + this.current_day + "/" + user_id;
	
	$('#webtraxPopup').load(url, function() {

		  $( '#webtraxPopup' ).dialog( 'open' );
		  
		  
	});

},
	

closetraxfollow : function(){




},
	
	
	
userballoon: function(data){
		
	//this.movezoneposition(zone_id, "down");
		
		
},



disableprevbtn: function(data){

	//alert('hoo');
	
	//disableprevbtn
	
	$('#webtrax_prevday_btn').attr( 'disabled', 'disabled' ).removeClass('btn-default').addClass('disabled');
	
		
		
},

prevday : function(){

	$('#webtrax_nextday_btn').removeAttr('disabled').removeClass('disabled').addClass('btn-default');

	this.current_day ++;
	this.showday(this.current_day);

},

nextday : function(){

	this.current_day --;
	
	$('#webtrax_prevday_btn').removeAttr('disabled').removeClass('disabled').addClass('btn-default');

	if(this.current_day < 1) $('#webtrax_nextday_btn').attr( 'disabled', 'disabled' ).removeClass('btn-default').addClass('disabled');
	
	this.showday(this.current_day);
	
},


showday : function(current_day){

	var url = "/webtrax/admin_remote/showday/" + current_day;
	
	$('#webtraxdayview').load(url, function() {
	
		
		$('.webtrax_user_link').tooltip();

	});
	
}

	


	
});




var ps_webtrax = new pswebtrax();



$( function() {

	ps_webtrax.init();


}); //end document ready
