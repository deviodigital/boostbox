jQuery(document).ready(function ($) {

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

	// Back to top links
	$( "#help-panel h3" ).append( $( "<a class='back-to-top' href='#panel'><i class='fa fa-angle-up'></i> Back to top</a>" ) );
});

// Add a filter to modify the group variations
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