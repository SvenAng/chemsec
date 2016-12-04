// Speciallösningar ///



// Visar resetknapp i kategorifilter
(function($) {

    $('.tag').click(function(){
        $('#site-main .site-sidebar .back-link.reset-link').css('display', 'inline-block');
    });


	function ieFix() {
	        if(isIE()) {
	            // add src to srcset img
	            $('img[srcset]').each(function() {
	                var image = $(this).attr('srcset').match(/(.+),/)[1];
	                $(this).attr('src', image);
	            });
	
	            $('#header-banner-content-wrapper > #header-banner-content').css({
	                'marginLeft': 0,
	                'marginRight': 0
	            });
	
	            $('#page').css('display', 'block');
	        }
	    }
	
	    function isIE() {
	        var ua = navigator.userAgent;
	        return ua.match(/(MSIE|Trident)/);
	    }



})( jQuery ); 