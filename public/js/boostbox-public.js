jQuery(document).ready(function ($) {
	// Popup ID.
	var popupID = boostbox_settings.popup_id;
	// Trigger type.
	var triggerType = boostbox_settings.trigger;
	// Milliseconds.
	var milliseconds = boostbox_settings.milliseconds;
    // Disable analytics?
    var disableAnalytics = boostbox_settings.disable_analytics;
    // Window inner height.
    var innerHeight = window.innerHeight;
    // Check to see if the cookie exists already.
	var cookieCheck = Cookies.get( 'boostbox_popup_' + popupID + '' );

	// If there's a cookie saved, bail early.
    if ( cookieCheck != null ) { return; }

    // Trigger - auto open.
    if ( triggerType === "auto-open" ) {
        if (!Cookies.get( 'boostbox_popup_' + popupID + '' )) {
            // Add class after X seconds.
            window.setTimeout(function(){
                $(".boostbox-popup-overlay").addClass('active');
                incrementPopupViewCount();
            }, 0);
        }
    }

    // Trigger - time.
    if ( triggerType === "time" ) {
        if (!Cookies.get( 'boostbox_popup_' + popupID + '' )) {
            // Add class after X seconds.
            window.setTimeout(function(){
                $(".boostbox-popup-overlay").addClass('active');
                incrementPopupViewCount();
            }, milliseconds);
        }
    }

    // Variable to track if the popup is closed
    var popupClosed = false;
    // Set a flag to track whether incrementPopupViewCount has been executed
    let popupViewCountIncremented = false;

    // Trigger - on scroll.
    if (triggerType === "on-scroll" && !Cookies.get('boostbox_popup_' + popupID)) {
        // Add class after scrolling X pixels.
        $(window).scroll(function () {
            if (!popupClosed && !popupViewCountIncremented) {
                if (!popupClosed) {
                    var triggerValue = boostbox_settings.scroll_distance;
                    var scrolledY = $(window).scrollTop();

                    var isPercentage = triggerValue.includes('%');
                    var windowY = isPercentage ? percentageToPixels(triggerValue, innerHeight) : parseInt(triggerValue, 10);

                    if (scrolledY > windowY) {
                        $(".boostbox-popup-overlay").addClass('active');
                        incrementPopupViewCount();
                        popupViewCountIncremented = true; // Set the flag to true.
                    }
                }

                // Function to convert percentage to pixels
                function percentageToPixels(percentage, containerHeight) {
                    var percent = parseInt(percentage, 10);
                    return (percent / 100) * containerHeight;
                }
            }
        });
    }

    // Set the click class used to close the popup.
    if (boostbox_settings.close_icon_placement == 'hidden') {
        var closeClickClass = '.boostbox-popup-overlay';
    } else {
        var closeClickClass = '.boostbox-close';
    }

    // Close popup when 'close' button is clicked.
    $(closeClickClass).on("click", function (event) {
        if (boostbox_settings.close_icon_placement == 'hidden') {
            // Check if the clicked element is not within the .boostbox-popup-content class
            if (!$(event.target).closest('.boostbox-popup-content').length) {
                $(".boostbox-popup-overlay").removeClass("active");
                popupClosed = true; // Set the variable to true when the popup is closed.
                var expirationDate = new Date();
                var expirationMilliseconds = expirationDate.getTime() + (boostbox_settings.cookie_days * 24 * 60 * 60 * 1000);
                expirationDate.setTime(expirationMilliseconds);
                Cookies.set('boostbox_popup_' + popupID, 'hidden', { expires: expirationDate });
            }
        } else {
            // Check if the clicked element is .boostbox-close
            $(".boostbox-popup-overlay").removeClass("active");
            popupClosed = true; // Set the variable to true when the popup is closed
            var expirationDate = new Date();
            var expirationMilliseconds = expirationDate.getTime() + (boostbox_settings.cookie_days * 24 * 60 * 60 * 1000);
            expirationDate.setTime(expirationMilliseconds);
            Cookies.set('boostbox_popup_' + popupID, 'hidden', { expires: expirationDate });
        }
    });

    // Track conversion when any button/link within the popup is clicked.
    // @TODO figure ways to make the tracking dynamic between buttons, links, form submissions, etc.
    $(".boostbox-popup-overlay").on("click", ":button:not('.boostbox-close'), button:not('.boostbox-close'), a, input[type='submit'], [role='button']", function () {
        trackConversion();
    });

    // Get percentage of number.
    function percentage(percent, total) {
        return ((percent/ 100) * total)
    }

    // Increment popup view count.
    function incrementPopupViewCount() {
        // Only do this if analytics is not disabled.
        if (!disableAnalytics) {
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
                    // Turned off console log message (for now) @TODO - set up a "debug" option that turns this back on.
                    //console.log('[SUCCESS] Impression tracking complete!');
                    //console.log(response);
                },
                error: function (error) {
                    // Turned off console log message (for now) @TODO - set up a "debug" option that turns this back on.
                    //console.log('[ERROR] Impression tracking failed!');
                    //console.log(error);
                }
            });
        }
    }

    // Increment popup conversion count.
    function trackConversion() {
        // Only do this if analytics is not disabled.
        if (!disableAnalytics) {
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
                    // Turned off console log message (for now) @TODO - set up a "debug" option that turns this back on.
                    //console.log('[SUCCESS] Conversion tracking complete!');
                    //console.log(response);
                },
                error: function (error) {
                    // Turned off console log message (for now) @TODO - set up a "debug" option that turns this back on.
                    //console.log('[ERROR] Conversion tracking failed!');
                    //console.log(error);
                }
            });
        }
    }
});
