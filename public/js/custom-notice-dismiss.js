jQuery(document).on('click', '.notice.is-dismissible', function() {
    var $notice = jQuery(this);
    console.log($notice);

    jQuery.ajax({
        url: custom_notice.ajax_url,
        type: 'POST',
        data: {
            action: 'boostbox_custom_dismiss_update_notice',
            nonce: custom_notice.nonce
        },
        success: function(response) {
            $notice.fadeOut(); 
            console.log(response);
        }
    });
});
