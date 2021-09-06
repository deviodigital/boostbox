jQuery(document).ready(function ($) {
	// Popup ID.
	var popupID = boostbox_settings.popup_id;

	// Remove cookie?
	Cookies.remove('boostbox_popup_' + popupID + '', { path: '/' });

	// @todo make the ID number dynamic via localize script.
	var cookieCheck = Cookies.get( 'boostbox_popup_' + popupID + '' );

	// If there's a cookie saved, bail early.
	if ( cookieCheck != null ) { return; }

	// Add class after X seconds.
	window.setTimeout(function(){
        $(".boostbox-popup-overlay").addClass('active');
	}, 2000); //<-- Delay in milliseconds

	// Add class after scrolling X pixels (not working yet).
	$(window).scroll(function () {
		var windowY = 100; // @todo make this number dynamic
		var scrolledY = $(window).scrollTop();
	 
		if (scrolledY > windowY) {
//			$(".boostbox-popup-overlay").addClass('active');
		}
	});

	// Close popup when 'close' button is clicked.
	$(".boostbox-close").on("click", function() {
		$(".boostbox-popup-overlay").removeClass("active");
		// @todo make the ID number dynamic via localize script.
		// @todo make the '30' dynamic via localize script (using user option via admin settings).
		Cookies.set( 'boostbox_popup_' + popupID + '', 'hidden', 30 );
	});
});
