jQuery(document).ready(function ($) {
    if (typeof boostbox_settings !== 'undefined' && Array.isArray(boostbox_settings.popups)) {
        // Loop through each popup's settings.
        boostbox_settings.popups.forEach(function (popup) {
            var popupID = popup.popup_id;

            // Check for existing cookies to see if popup should be skipped.
            var cookieCheck = Cookies.get('boostbox_popup_' + popupID);
            if (cookieCheck != null) {
                console.log('Popup', popupID, 'skipped due to cookie');
                return;
            }

            // Trigger handling (auto-open, on-scroll, exit-intent)
            handlePopupTrigger(popup);

            // Close behavior handling (inside/outside/hide)
            setupCloseBehavior(popupID, popup.close_icon_placement, popup.cookie_days);

            // Track conversion when any button/link within the popup is clicked.
            $(".boostbox-popup-overlay[data-popup-id='" + popupID + "']").on("click", ":button:not('.boostbox-close'), button:not('.boostbox-close'), a, input[type='submit'], [role='button']", function () {
                trackConversion(popupID, popup.nonce);
            });
        });
    }

    // Function to handle popup triggers.
    function handlePopupTrigger(popup) {
        var popupID = popup.popup_id;
        var triggerType = popup.trigger;

        if (triggerType === "auto-open") {
            window.setTimeout(function () {
                $(".boostbox-popup-overlay[data-popup-id='" + popupID + "']").addClass('active');
                incrementPopupViewCount(popupID, popup.nonce);
            }, 0);
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
                        var triggerValue = popup.scroll_distance; // Use the popup's specific scroll distance
                        var scrolledY = $(window).scrollTop();

                        if (!triggerValue) {
                            console.error('Popup scroll_distance is not defined for popup ' + popupID);
                            return;
                        }

                        var isPercentage = triggerValue.includes('%');
                        var windowY = isPercentage ? percentageToPixels(triggerValue, innerHeight) : parseInt(triggerValue, 10);

                        if (scrolledY > windowY) {
                            $(".boostbox-popup-overlay").addClass('active');
                            incrementPopupViewCount(popupID, popup.nonce); // Pass popupID and nonce
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

        if (triggerType === "exit-intent") {
            $(document).on('mouseleave', function (e) {
                if (e.clientY < 0) {
                    $(".boostbox-popup-overlay[data-popup-id='" + popupID + "']").addClass('active');
                    incrementPopupViewCount(popupID, popup.nonce);
                }
            });
        }
    }

    // Function to set up the close behavior.
    function setupCloseBehavior(popupID, closeIconPlacement, cookieDays) {
        if (closeIconPlacement === 'hidden') {
            $(document).on("click", ".boostbox-popup-overlay[data-popup-id='" + popupID + "']", function (event) {
                if ($(event.target).hasClass('boostbox-popup-overlay')) {
                    closePopup(popupID, cookieDays);
                }
            });
        } else {
            // Close button click handling - specifically target the correct close button.
            $(".boostbox-popup-overlay[data-popup-id='" + popupID + "'] .boostbox-close").on("click", function () {
                closePopup(popupID, cookieDays);
            });
        }
    }

    // Function to close the popup and set a cookie.
    function closePopup(popupID, cookieDays) {
        $(".boostbox-popup-overlay[data-popup-id='" + popupID + "']").removeClass("active");
        var expirationDate = new Date();
        expirationDate.setTime(expirationDate.getTime() + (cookieDays * 24 * 60 * 60 * 1000));
        Cookies.set('boostbox_popup_' + popupID, 'hidden', { expires: expirationDate });
    }

    // Function to convert percentage to pixels.
    function percentageToPixels(percentage, containerHeight) {
        var percent = parseInt(percentage, 10);
        return (percent / 100) * containerHeight;
    }

    // Function to increment popup view count.
    function incrementPopupViewCount(popupID, nonce) {
        console.log('Nonce:', boostbox_settings.nonce);

        $.ajax({
            url: boostbox_settings.ajax_url,
            type: 'POST',
            data: {
                action: 'increment_popup_view_count',
                popup_id: popupID,
                nonce: boostbox_settings.nonce, // Ensure you're using the nonce from boostbox_settings
            },
            success: function (response) {
                console.log('[SUCCESS] Impression tracking complete for popup ' + popupID + ' ' + response);
            },
            error: function (xhr, status, error) {
                console.log('[ERROR] Impression tracking failed for popup ' + popupID);
                console.log('XHR:', xhr);
                console.log('Status:', status);
                console.log('Error:', error);
            }
        });
    }

    // Function to track conversions.
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
