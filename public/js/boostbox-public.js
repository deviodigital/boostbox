jQuery(document).ready(function ($) {
	// Popup ID.
	var popupID = boostbox_settings.popup_id;
	// Trigger type.
	var triggerType = boostbox_settings.trigger;
	// Milliseconds.
	var milliseconds = boostbox_settings.milliseconds;
    // Window inner height.
    var innerHeight = window.innerHeight;

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
            if (!popupClosed && !popupViewCountIncremented) { // Check if the popup is not closed and the count has not been incremented
                if (!popupClosed) { // Check if the popup is not closed
                    var windowY = 32; //<-- @TODO Make this number dynamic
                    var scrolledY = $(window).scrollTop();
                    var percentResult = percentage(windowY, innerHeight);

                    if (scrolledY > percentResult) {
                        $(".boostbox-popup-overlay").addClass('active');
                        incrementPopupViewCount();
                        popupViewCountIncremented = true; // Set the flag to true.
                    }
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
                popupClosed = true; // Set the variable to true when the popup is closed
                var expirationDate = new Date();
                expirationDate.setDate(expirationDate.getDate() + boostbox_settings.cookie_days);
                Cookies.set('boostbox_popup_' + popupID, 'hidden', { expires: expirationDate });
            }
        } else {
            // Check if the clicked element is .boostbox-close
            $(".boostbox-popup-overlay").removeClass("active");
            popupClosed = true; // Set the variable to true when the popup is closed
            var expirationDate = new Date();
            expirationDate.setDate(expirationDate.getDate() + boostbox_settings.cookie_days);
            Cookies.set('boostbox_popup_' + popupID, 'hidden', { expires: expirationDate });
        }
    });

    // Track conversion when any button/link within the popup is clicked.
    // @TODO figure ways to make the tracking dynamic between buttons, links, form submissions, etc.
    $(".boostbox-popup-overlay").on("click", ":button, button, a, input[type='submit'], [role='button']", function () {
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
                console.log('[ERROR] Impression tracking failed!');
                console.log(error);
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
