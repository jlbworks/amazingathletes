jQuery(document).ready(function( $ ) {

(function($) { 
		var scroll_start = 0;
		var startchange = $('#fo-float-row');
		var offset = startchange.offset();
		var request_div = $("#fo-float-row");
		if (startchange.length){
			$(document).scroll(function() { 
				scroll_start = $(this).scrollTop();
				if(scroll_start > offset.top + (-75)) {
						request_div.addClass("fo-floated-row")
				}
				else {
					request_div.removeClass("fo-floated-row")
				}
			});
		}
 })(jQuery);


	
	
$("#displayText").click(function(){
     $( "#toggleText" ).toggle("slow").css("display","block");;
});
	

	
});//close all jquery

