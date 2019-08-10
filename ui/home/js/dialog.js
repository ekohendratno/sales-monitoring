/*holds currently opened dialog*/
var XDLG="";
$(document).ready(function(){

	// CENTERS given element
	jQuery.fn.center = function () {
    	this.css("position","absolute");
    	this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
    	this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
    	return this;
	}
	
	// SHOW a dialog
	jQuery.fn.showX = function () {
    	// get the screen height and width        
		var maskHeight = $(document).height()+$(document).scrollTop();  
		var maskWidth = $(window).width();
			
		// calculate the values for center alignment
		var dialogTop =  ($(document).scrollTop()+50);    
		var dialogLeft = "100px"; 
	
		// assign values to the overlay and dialogbox
		//$('#redactor_modal_overlay').css({height:maskHeight, width:maskWidth});
		$(this).css({top:dialogTop, left:dialogLeft}).center();

		// display the boxes
		XDLG="#"+$(this).attr("id");
		$("#redactor_modal_overlay").show();
		$(XDLG).show();	
	}
	
	// CLOSE a dialog
	jQuery.fn.closeX = function () {
		$(this).clearX();
		$(this).hide();
		$("#redactor_modal_overlay").hide();
		XDLG="";
	}
	
	
	// CLEAR inputs in a dialog
	jQuery.fn.clearX = function (){	
		$(this).find("input:text").val('');	
	}
	
	// CLEAR on pressing `esc` button
	$(document).keyup(function(e){
		if(e.keyCode === 27)
			$(XDLG).clearX();
	});

	// CLOSE on clicking on request
	$("#redactor_modal_overlay,#redactor_modal_close").click(function(){
		$(XDLG).closeX();
	});

});	
