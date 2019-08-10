	$(document).ready(function() {
	/*
	var nav_div = $("div.nav-fix");
	var nav_div_start = $(nav_div).offset().top;
	$.event.add(window, "scroll", function(){
		var nav_p = $(window).scrollTop();
		$(nav_div).css('position',((nav_p)>nav_div_start) ? 'fixed' : 'static');
		$(nav_div).css('top',((nav_p)>nav_div_start) ? '0px' : '');
		}
	);
	*/
	
	
	// Launch TipTip tooltip
	$('.tiptip a.button, .tiptip button, ul.tiptip li .tip').tipTip();
	
	var loading = $("#loading");
	loading.fadeOut();	
	
	var optionsClock = {
        format: '%A, %d %B %Y %H:%M:%S' // 24-hour
    }
    $('#jclock').jclock(optionsClock);
	
	
	});