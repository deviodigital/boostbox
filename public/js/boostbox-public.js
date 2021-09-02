jQuery(document).ready(function ($) {
	// Cookies.remove('boostbox_popup_236', { path: '/' });
	// @todo make the ID number dynamic via localize script.
	var cookieCheck = Cookies.get( 'boostbox_popup_236' );

	// If there's a cookie saved, bail early.
	if ( cookieCheck != null ) { return; }

	// Add class after X seconds.
	window.setTimeout(function(){
        $(".boostbox-popup-overlay").addClass('active');
	}, 2000); //<-- Delay in milliseconds

	// Close popup when 'close' button is clicked.
	$(".boostbox-close").on("click", function() {
		$(".boostbox-popup-overlay").removeClass("active");
		// @todo make the ID number dynamic via localize script.
		// @todo make the '30' dynamic via localize script (using user option via admin settings).
		Cookies.set( 'boostbox_popup_236', 'hidden', 30 );
	});
});
