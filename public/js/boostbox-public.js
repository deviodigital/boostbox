jQuery(document).ready(function ($) {
    if (typeof boostbox_settings !== 'undefined' && Array.isArray(boostbox_settings.popups)) {
        // Loop through each popup's settings.
        boostbox_settings.popups.forEach(function (popup) {
            // Popup ID.
            var popupID = popup.popup_id;
            console.log('Processing popup ID:', popupID);

            // Trigger type.
            var triggerType = popup.trigger;
            console.log('Trigger type for popup', popupID, ':', triggerType);

            // Milliseconds.
            var milliseconds = popup.milliseconds;
            // Disable analytics?
            var disableAnalytics = popup.disable_analytics;
            // Window inner height.
            var innerHeight = window.innerHeight;
            // Scroll distance.
            var scrollDistance = popup.scroll_distance;
            // Check to see if the cookie exists already.
            var cookieCheck = Cookies.get('boostbox_popup_' + popupID);
            console.log('Cookie check for popup', popupID, ':', cookieCheck);

            // If there's a cookie saved, bail early.
            if (cookieCheck != null) {
                console.log('Popup', popupID, 'skipped due to cookie');
                return; // Skip if cookie exists
            }

            // Trigger - auto open.
            if (triggerType === "auto-open") {
                console.log('Auto-open trigger detected for popup', popupID);
                window.setTimeout(function () {
                    console.log('Activating auto-open popup:', popupID);
                    $(".boostbox-popup-overlay[data-popup-id='" + popupID + "']").addClass('active');
                    incrementPopupViewCount(popupID, popup.nonce);
                }, 0);
            }

            // Trigger - time.
            if (triggerType === "time") {
                console.log('Time trigger detected for popup', popupID, 'Milliseconds:', milliseconds);
                window.setTimeout(function () {
                    console.log('Activating time-based popup:', popupID);
                    $(".boostbox-popup-overlay[data-popup-id='" + popupID + "']").addClass('active');
                    incrementPopupViewCount(popupID, popup.nonce);
                }, milliseconds);
            }

            // Trigger - on scroll.
            if (triggerType === "on-scroll") {
                console.log('Scroll trigger detected for popup', popupID, 'Scroll Distance:', scrollDistance);
                $(window).scroll(function () {
                    var scrolledY = $(window).scrollTop();
                    var isPercentage = scrollDistance.includes('%');
                    var triggerValue = isPercentage ? percentageToPixels(scrollDistance, innerHeight) : parseInt(scrollDistance, 10);

                    if (scrolledY > triggerValue) {
                        console.log('Activating scroll-based popup:', popupID);
                        $(".boostbox-popup-overlay[data-popup-id='" + popupID + "']").addClass('active');
                        incrementPopupViewCount(popupID, popup.nonce);
                    }
                });
            }

            // Trigger - exit intent.
            if (triggerType === "exit-intent") {
                console.log('Exit-intent trigger detected for popup', popupID);
                $(document).on('mouseleave', function (e) {
                    if (e.clientY < 0) {
                        console.log('Activating exit-intent popup:', popupID);
                        $(".boostbox-popup-overlay[data-popup-id='" + popupID + "']").addClass('active');
                        incrementPopupViewCount(popupID, popup.nonce);
                    }
                });
            }

            // Set the click class used to close the popup.
            var closeClickClass = (popup.close_icon_placement === 'hidden') ? '.boostbox-popup-overlay[data-popup-id="' + popupID + '"]' : '.boostbox-close[data-popup-id="' + popupID + '"]';

            // Close popup when 'close' button is clicked.
            $(document).on("click", closeClickClass, function (event) {
                console.log('Closing popup:', popupID);
                $(".boostbox-popup-overlay[data-popup-id='" + popupID + "']").removeClass("active");
                var expirationDate = new Date();
                expirationDate.setTime(expirationDate.getTime() + (popup.cookie_days * 24 * 60 * 60 * 1000));
                Cookies.set('boostbox_popup_' + popupID, 'hidden', { expires: expirationDate });
            });

            // Track conversion when any button/link within the popup is clicked.
            $(".boostbox-popup-overlay[data-popup-id='" + popupID + "']").on("click", ":button:not('.boostbox-close'), button:not('.boostbox-close'), a, input[type='submit'], [role='button']", function () {
                trackConversion(popupID, popup.nonce);
            });
        });
    }

    // Function to convert percentage to pixels.
    function percentageToPixels(percentage, containerHeight) {
        var percent = parseInt(percentage, 10);
        return (percent / 100) * containerHeight;
    }

    // Increment popup view count.
    function incrementPopupViewCount(popupID, nonce) {
        $.ajax({
            url: boostbox_settings.ajax_url,
            type: 'POST',
            data: {
                action: 'increment_popup_view_count',
                popup_id: popupID,
                nonce: nonce,
            },
            success: function (response) {
                console.log('[SUCCESS] Impression tracking complete for popup ' + popupID);
            },
            error: function (error) {
                console.log('[ERROR] Impression tracking failed for popup ' + popupID);
            }
        });
    }

    // Increment popup conversion count.
    function trackConversion(popupID, nonce) {
        $.ajax({
            url: boostbox_settings.ajax_url,
            type: 'POST',
            data: {
                action: 'track_popup_conversion',
                popup_id: popupID,
                nonce: nonce,
            },
            success: function (response) {
                console.log('[SUCCESS] Conversion tracking complete for popup ' + popupID);
            },
            error: function (error) {
                console.log('[ERROR] Conversion tracking failed for popup ' + popupID);
            }
        });
    }
});
