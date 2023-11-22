jQuery(document).ready(function ($) {
	// Popup ID.
	var popupID = boostbox_settings.popup_id;
	// Trigger type.
	var triggerType = boostbox_settings.trigger;
	// Milliseconds.
	var milliseconds = boostbox_settings.milliseconds;
    // Window inner height.
    var innerHeight = window.innerHeight;

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
            incrementPopupViewCount();
        }, 0);
    }

    // Trigger - time.
    if ( triggerType === "time" ) {
        // Add class after X seconds.
        window.setTimeout(function(){
            $(".boostbox-popup-overlay").addClass('active');
            incrementPopupViewCount();
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
                incrementPopupViewCount();
            }
        });
    }

	// Close popup when 'close' button is clicked.
	$(".boostbox-close").on("click", function() {
		$(".boostbox-popup-overlay").removeClass("active");
		Cookies.set( 'boostbox_popup_' + popupID + '', 'hidden', boostbox_settings.cookie_days );
    });

    // Track conversion when any button/link within the popup is clicked.
    // @TODO figure ways to make the tracking dynamic between buttons, links, form submissions, etc.
    $(".boostbox-popup-overlay").on("click", ":button, a, input[type='submit'], [role='button']", function () {
        trackConversion();
    });

    // Get percentage of number.
    function percentage(percent, total) {
        return ((percent/ 100) * total)
    }

    // Increment popup view count.
    function incrementPopupViewCount() {
        // AJAX request to increment view count.
        $.ajax({
            url: boostbox_settings.ajax_url,
            type: 'POST',
            data: {
                action: 'increment_popup_view_count',
                popup_id: popupID,
                nonce: boostbox_settings.nonce,
            },
            success: function (response) {
                console.log('[SUCCESS] Impression tracking complete!');
                console.log(response);
            },
            error: function (error) {
                console.log('[SUCCESS] Impression tracking failed!');
                console.log(response);
            }
        });
    }

    // Increment popup conversion count.
    function trackConversion() {
        // AJAX request to track conversion.
        $.ajax({
            url: boostbox_settings.ajax_url,
            type: 'POST',
            data: {
                action: 'track_popup_conversion',
                popup_id: popupID,
                nonce: boostbox_settings.nonce,
            },
            success: function (response) {
                console.log('[SUCCESS] Conversion tracking complete!');
                console.log(response);
            },
            error: function (error) {
                console.log('[ERROR] Conversion tracking failed!');
                console.log(response);
            }
        });
    }

});
