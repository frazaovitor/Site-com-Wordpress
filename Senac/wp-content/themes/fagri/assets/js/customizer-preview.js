/**
 * Main customize js file
 *
 * @package fagri
 * @since 1.0.0
 */

(function ( $ ) {

    /* Team background-image */
    wp.customize(
        'fagri_team_background', function ( value ) {
            value.bind(
                function ( newval ) {
                    if ( newval.length > 0 ) {
                        $( '.fagri-team-wrapper' ).css( { 'background-image' : 'url(' + newval + ')' } );
                    } else {
                        $( '.fagri-team-wrapper' ).css( 'background-image', 'none' ).css( 'background-color', '#000000' );
                    }
                }
            );
        }
    );
    /* Pricing section */
    wp.customize(
        'accent_color', function ( value ) {
            value.bind(
                function ( newval ) {
                    /* card plain */
                    $( '.hestia-pricing .card-pricing .content .hestia-pricing-icon-wrapper' ).css( { 'box-shadow' : '0px 9px 30px -6px ' + newval } );
                    /* card raised */
                    $( '.hestia-pricing .card-pricing.card-raised' ).css( 'background-color', newval );
                    $( '.hestia-pricing .card-pricing.card-raised .content .btn' ).css( 'color', newval );
                }
            );
        }
    );
    /* Features section */
    wp.customize(
        'hestia_features_content', function ( value ) {
            value.bind(
                function ( newval ) {
                    wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function ( placement ) {
                        if ( typeof wp.customize._value.hestia_features_content === 'function' ) {

                            if ( placement.partial.id === 'hestia_features_content' ) {

                                var featureBoxes = JSON.parse( newval );

                                /* Hover Style */
                                var style = '<style class="fagri-hover-styles">';

                                for ( var i = 0; i < featureBoxes.length; i++ ) {

                                    var boxNumber = i + 1;

                                    var boxShadowSelector = '.hestia-features .hestia-features-content .feature-box:nth-of-type(' + boxNumber + ') .hestia-info > a .icon';
                                    var titleHoverSelector = '.hestia-features .hestia-features-content .feature-box:nth-of-type(' + boxNumber + ') .hestia-info > a:hover .info-title';

                                    if ( featureBoxes[ i ].color ) {
                                        $( boxShadowSelector ).css( { 'box-shadow' : '0 9px 30px -6px ' + featureBoxes[ i ].color } );
                                        style += titleHoverSelector + ' { color: ' + featureBoxes[ i ].color + '; }';
                                    }
                                }

                                style += '</style>';
                                var el     = $( '.fagri-hover-styles' ); // look for a matching style element that might already be there
                                if ( el.length ) {
                                    el.replaceWith( style ); // style element already exists, so replace it
                                } else {
                                    $( 'head' ).append( style ); // style element doesn't exist so add it
                                }

                            }
                        }
                    } );
                }
            );
        }
    );
    /* Testimonials background-image */
    wp.customize(
        'fagri_testimonials_background', function ( value ) {
            value.bind(
                function ( newval ) {
                    if ( newval.length > 0 ) {
                        $( '.fagri-testimonials-wrapper' ).css( { 'background-image' : 'url(' + newval + ')' } );
                    } else {
                        $( '.fagri-testimonials-wrapper' ).css( 'background-image', 'none' ).css( 'background-color', '#000000' );
                    }
                }
            );
        }
    );

})( jQuery );


























