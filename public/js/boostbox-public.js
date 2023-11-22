jQuery(document).ready(function ($) {
	// Popup ID.
	var popupID = boostbox_settings.popup_id;
	// Trigger type.
	var triggerType = boostbox_settings.trigger;
	// Milliseconds.
	var milliseconds = boostbox_settings.milliseconds;
    // Window inner height.
    var innerHeight = window.innerHeight;
    console.log( innerHeight );
    console.log( triggerType );
    console.log( milliseconds );

	// Remove cookie?
	Cookies.remove('boostbox_popup_' + popupID + '', { path: '/' });

	var cookieCheck = Cookies.get( 'boostbox_popup_' + popupID + '' );

	// If there's a cookie saved, bail early.
    if ( cookieCheck != null ) { return; }

    // Trigger - auto open.
    if ( triggerType === "auto-open" ) {
        // Add class after X seconds.
        window.setTimeout(function(){
            $(".boostbox-popup-overlay").addClass('active');
        }, 0);
    }

    // Trigger - time.
    if ( triggerType === "time" ) {
        // Add class after X seconds.
        window.setTimeout(function(){
            $(".boostbox-popup-overlay").addClass('active');
        }, milliseconds);
    }

    // Trigger - on scroll.
    if ( triggerType === "on-scroll" ) {
        // Add class after scrolling X pixels.
        $(window).scroll(function () {
            var windowY = 32; //<-- Make this number dynamic
            var scrolledY = $(window).scrollTop();
            var percentResult = percentage(windowY, innerHeight);

            if (scrolledY > percentResult) {
                $(".boostbox-popup-overlay").addClass('active');
            }
        });
    }

	// Close popup when 'close' button is clicked.
	$(".boostbox-close").on("click", function() {
		$(".boostbox-popup-overlay").removeClass("active");
		Cookies.set( 'boostbox_popup_' + popupID + '', 'hidden', boostbox_settings.cookie_days );
    });

    // Get percentage of number.
    function percentage(percent, total) {
        return ((percent/ 100) * total)
    }
});
