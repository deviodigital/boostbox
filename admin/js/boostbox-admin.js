jQuery(function ($) {
    // Construct the path to the theme.json file.
    const themeJsonPath = script_vars.stylesheet_url + '/theme.json';
    // Declare colorPalette outside the fetch scope.
    let colorPalette;

    // Fetch the theme.json file.
    fetch(themeJsonPath)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Access the color palette data.
        colorPalette = data.settings.color.palette;

        // Convert colorPalette to an array of hex values
        var presetColors = colorPalette.map(function (color) {
            return color.color;
        });

        // Add a color picker to the close icon color picker.
        $('.boostbox-close-icon-color-picker').wpColorPicker({
            defaultColor: presetColors[1],
            palettes: presetColors
        });
    })
    .catch(error => {
        console.error('Error fetching theme.json:', error);
        // Add a color picker to the close icon color picker.
        $('.boostbox-close-icon-color-picker').wpColorPicker({
            defaultColor: '#010101'
        });
    });

	// Tabs
	$( ".inline-list" ).each( function() {
		$( this ).find( "li" ).each( function(i) {
			$( this).click( function(){
				$( this ).addClass( "current" ).siblings().removeClass( "current" )
				.parents( "#wpbody" ).find( "div.panel-left" ).removeClass( "visible" ).end().find( 'div.panel-left:eq('+i+')' ).addClass( "visible" );
				return false;
			} );
		} );
	} );

	// Scroll to anchor
	$( ".anchor-nav a, .toc a" ).click( function(e) {
		e.preventDefault();

		var href = $( this ).attr( "href" );
		$( "html, body" ).animate( {
			scrollTop: $( href ).offset().top
		}, 'slow', 'swing' );
	} );

	// Back to top links.
	$( "#help-panel h3" ).append( $( "<a class='back-to-top' href='#panel'><i class='fa fa-angle-up'></i> Back to top</a>" ) );

    // Add select2 to metabox fields.
    $( '#boostbox_display_location' ).select2();
    $( '#boostbox_animation_type' ).select2();
    $( '#boostbox_trigger_type' ).select2();
    $( '#boostbox_close_icon_placement' ).select2();
    $( '#boostbox_popup_selected' ).select2();

    // Initialize Select2 for Custom Post Types.
    $('#custom_post_types').select2({
        placeholder: "Select Post Type(s)"
    });

    // Initialize Select2 for General Settings with multiple selection enabled
    $('#general_field').select2({
        placeholder: "Select General Settings",
        multiple: true // Explicitly enabling multiple
    });

    // Initialize Select2 for Posts with AJAX search.
    $('#posts').select2({
        placeholder: "Search and Select Post(s)",
        ajax: {
            url: script_vars.ajax_url,
            method: 'POST',
            dataType: 'json',
            delay: 250, // Delay for better performance
            data: function (params) {
                return {
                    action: 'fetch_posts_by_search', // AJAX action
                    search_term: params.term // Search term entered by user
                };
            },
            processResults: function (response) {
                if (response.success) {
                    return {
                        results: response.data
                    };
                } else {
                    return {
                        results: []
                    };
                }
            },
            cache: true
        },
        minimumInputLength: 3 // Minimum characters before search
    });

    // Reset the metrics when button is clicked in metabox.
    $('#reset-metrics').on('click', function () {
        var postId = script_vars.popup_id;
        var nonce = script_vars.metrics_reset_nonce;
    
        // AJAX request to reset metrics
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'reset_boostbox_metrics',
                post_id: postId,
                security: nonce,
            },
            success: function (response) {
                // Turned off console log message (for now) @TODO - set up a "debug" option that turns this back on.
                //console.log(response);
            
                // Update the specific elements within the metabox
                var container = $('#boostbox-metrics-container');
                container.replaceWith($(response).find('#boostbox-metrics-container'));
            
                // Update the nonce
                script_vars.metrics_reset_nonce = $(response).find('#boostbox_metrics_reset_nonce').val();
            },
            error: function (error) {
                // Turned off console log message (for now) @TODO - set up a "debug" option that turns this back on.
                //console.log('[ERROR] Metrics resets failed!');
                //console.log(error);
            }
        });
    });

    // Set variables for trigger targeting.
    var boostboxTriggerType = $('#boostbox_trigger_type');
    var timeTriggerDiv = $('.display-speed');
    var onScrollTriggerDiv = $('.on-scroll');

    // Initial check on page load.
    if (boostboxTriggerType.val() === 'time') {
        onScrollTriggerDiv.addClass('hidden');
        timeTriggerDiv.addClass('active');
    } else if (boostboxTriggerType.val() === 'on-scroll') {
        onScrollTriggerDiv.addClass('active');
        timeTriggerDiv.addClass('hidden');
    } else {
        timeTriggerDiv.addClass('hidden');
        onScrollTriggerDiv.addClass('hidden');
    }

    // Add an event listener for changes in the boostbox_trigger_type field.
    boostboxTriggerType.change(function() {
        if ($(this).val() === 'time') {
            timeTriggerDiv.addClass('active');
            onScrollTriggerDiv.removeClass('active');
            onScrollTriggerDiv.addClass('hidden');
        } else if ($(this).val() === 'on-scroll') {
            onScrollTriggerDiv.addClass('active');
            timeTriggerDiv.removeClass('active');
            timeTriggerDiv.hiddenClass('hidden');
        } else {
            timeTriggerDiv.removeClass('active');
            timeTriggerDiv.addClass('hidden');
            onScrollTriggerDiv.removeClass('active');
            onScrollTriggerDiv.addClass('hidden');
        }
    });
});

// Add a filter to modify the group variations.
function customizeGroupVariations(groupVariations) {
    return groupVariations.map((variation) => {
        // Add the 'padding' attribute to each variation
        variation.attributes = {
            ...variation.attributes,
            padding: {
                type: 'number',
                default: 0,
            },
        };
        return variation;
    });
}
if (typeof wp.hooks === 'undefined') {
    console.error('wp.hooks is not defined. Make sure it is loaded.');
} else {
    // Hook into the filter
    wp.hooks.addFilter(
        'blocks.getGroupVariations',
        'boostbox-admin-js',
        customizeGroupVariations
    );
}