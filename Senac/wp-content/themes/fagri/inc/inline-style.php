<?php
/**
 * Inline style for the theme
 *
 * @package fagri
 * @since 1.0.0
 */

/**
 * Add color_accent on some elements
 *
 * @since 1.0.0
 */
function fagri_inline_style() {

	$color_accent              = get_theme_mod( 'accent_color', '#2ca8ff' );
	$hestia_features_repeaters = get_theme_mod( 'hestia_features_content' );

	$hestia_features_content = json_decode( $hestia_features_repeaters );

	$custom_css = '';

	/* Feature box repeaters, icon shadow and title color, hover state included */
	if ( ! empty( $hestia_features_content ) ) {
		foreach ( $hestia_features_content as $index => $value ) {

			$nth_of_type         = $index + 1;
			$color_rgba          = fagri_hex_rgba( $value->color, 0.3 );
			$color_rgba_on_hover = fagri_hex_rgba( $value->color, 0.35 );

			/* Hestia Pro */
			if ( isset( $value->choice ) ) {
				if ( $value->choice == 'customizer_repeater_icon' ) {

					$custom_css .= '.hestia-features-content .feature-box:nth-of-type(' . esc_html( $nth_of_type ) . ') .hestia-info > a .icon { box-shadow: 0 9px 30px -6px ' . esc_html( $color_rgba ) . '; }';
					$custom_css .= '.hestia-features-content .feature-box:nth-of-type(' . esc_html( $nth_of_type ) . ') .hestia-info > a:hover .icon { box-shadow: 0 15px 35px 0 ' . esc_html( $color_rgba_on_hover ) . '; }';
					$custom_css .= '.hestia-features-content .feature-box:nth-of-type(' . esc_html( $nth_of_type ) . ') .hestia-info > a:hover .info-title { color: ' . esc_html( $value->color ) . '; }';
				} else {
					$custom_css .= '.hestia-features-content .feature-box:nth-of-type(' . esc_html( $nth_of_type ) . ') .hestia-info > a:hover .info-title { color: ' . esc_html( $color_accent ) . '; }';
				}
			} else { /* Hestia Lite */
				$custom_css .= '.hestia-features-content .feature-box:nth-of-type(' . esc_html( $nth_of_type ) . ') .hestia-info > a .icon { box-shadow: 0 9px 30px -6px ' . esc_html( $color_rgba ) . '; }';
				$custom_css .= '.hestia-features-content .feature-box:nth-of-type(' . esc_html( $nth_of_type ) . ') .hestia-info > a:hover .icon { box-shadow: 0 15px 35px 0 ' . esc_html( $color_rgba_on_hover ) . '; }';
				$custom_css .= '.hestia-features-content .feature-box:nth-of-type(' . esc_html( $nth_of_type ) . ') .hestia-info > a:hover .info-title { color: ' . esc_html( $value->color ) . '; }';
			}
		}
	} else { /* Default values first time when the theme is installed */

		$custom_css .= '.hestia-features-content .feature-box:nth-of-type(1) .hestia-info > a .icon { box-shadow: 0 9px 30px -6px ' . esc_html( fagri_hex_rgba( '#e91e63', 0.3 ) ) . '; }';
		$custom_css .= '.hestia-features-content .feature-box:nth-of-type(1) .hestia-info > a:hover .icon { box-shadow: 0 15px 35px 0 ' . esc_html( fagri_hex_rgba( '#e91e63', 0.35 ) ) . '; }';
		$custom_css .= '.hestia-features-content .feature-box:nth-of-type(1) .hestia-info > a:hover .info-title { color: #e91e63; }';

		$custom_css .= '.hestia-features-content .feature-box:nth-of-type(2) .hestia-info > a .icon { box-shadow: 0 9px 30px -6px ' . esc_html( fagri_hex_rgba( '#00bcd4', 0.3 ) ) . '; }';
		$custom_css .= '.hestia-features-content .feature-box:nth-of-type(2) .hestia-info > a:hover .icon { box-shadow: 0 15px 35px 0 ' . esc_html( fagri_hex_rgba( '#00bcd4', 0.35 ) ) . '; }';
		$custom_css .= '.hestia-features-content .feature-box:nth-of-type(2) .hestia-info > a:hover .info-title { color: #00bcd4; }';

		$custom_css .= '.hestia-features-content .feature-box:nth-of-type(3) .hestia-info > a .icon { box-shadow: 0 9px 30px -6px ' . esc_html( fagri_hex_rgba( '#4caf50', 0.3 ) ) . '; }';
		$custom_css .= '.hestia-features-content .feature-box:nth-of-type(3) .hestia-info > a:hover .icon { box-shadow: 0 15px 35px 0 ' . esc_html( fagri_hex_rgba( '#4caf50', 0.35 ) ) . '; }';
		$custom_css .= '.hestia-features-content .feature-box:nth-of-type(3) .hestia-info > a:hover .info-title { color: #4caf50; }';
	}

	if ( ! empty( $color_accent ) ) {

		/* Buttons */
		$custom_css .= '.btn, .button, button, input[type="submit"] { background-color: ' . esc_html( $color_accent ) . '; }';
		$custom_css .= '.btn:hover, .button:hover, button:hover, input[type="submit"]:hover { background-color: ' . esc_html( $color_accent ) . '; }';

		/* Team section, team member function */
		$custom_css .= '.fagri-team-wrapper .hestia-team .card-profile .col-md-7 .content .category { color: ' . esc_html( $color_accent ) . ' }';

		/* Testimonials quotes */
		$custom_css .= '.fagri-testimonials-wrapper .hestia-testimonials .hestia-testimonials-content .card-testimonial .content .card-description::before { color: ' . esc_html( $color_accent ) . '; }';

		/* Pricing icon wrapper box-shadow */
		$custom_css .= '.hestia-pricing .card-pricing .content .hestia-pricing-icon-wrapper { 
		    box-shadow: 0px 9px 30px -6px ' . esc_html( $color_accent ) . ';
		 }';
		/* Pricing colored card */
		$custom_css .= '.hestia-pricing .card-pricing.card-raised { background-color: ' . esc_html( $color_accent ) . '; }';
		/* Pricing colored card white button text */
		$custom_css .= '.hestia-pricing .card-pricing.card-raised .content .btn { color: ' . esc_html( $color_accent ) . '; }';

		/* Contact Form, fields border color */
		$custom_css .= '.pirate_forms_wrap .form-group.is-focused .form-control:not(textarea):not(select):not([type="file"]):not([type="checkbox"]) { border-color: ' . esc_html( $color_accent ) . '; }';

		/* Blog authors section function color */
		$custom_css .= '.authors-on-blog .card-profile.card-plain .col-md-7 .content .category { color: ' . esc_html( $color_accent ) . '; }';

		/* Leave comment logged out */
		$custom_css .= '#respond.comment-respond .col-md-4 > .form-group.is-focused .form-control { border-color: ' . esc_html( $color_accent ) . '; }';

		/* Card-product, card-product add to cart icon */
		$custom_css .= '.shop-item .card-product .content .footer .stats a i { color: ' . esc_html( $color_accent ) . ' ; }';
		$custom_css .= '.product .card-product .content .footer .stats a i { color: ' . esc_html( $color_accent ) . ' ; }';

		/* Card-product, special price */
		$custom_css .= '.shop-item .card-product .content .footer .price h4 del + .woocommerce-Price-amount { color: ' . esc_html( $color_accent ) . '; }';
		$custom_css .= '.product .card-product .content .footer .price h4 del + .woocommerce-Price-amount { color: ' . esc_html( $color_accent ) . '; }';

		/* Rating starts color */
		$custom_css .= '.star-rating span { color: ' . esc_html( $color_accent ) . ' !important; }';

		/* Product page, reviews message */
		$custom_css .= '.woocommerce-page #reviews #review_form_wrapper .form-group.is-focused input#author,
						.woocommerce-page #reviews #review_form_wrapper .form-group.is-focused input#email {
						border-color: ' . esc_html( $color_accent ) . ';} ';

		/* Product Page rating stars */
		$custom_css .= '.woocommerce.single-product .main .blog-post .product .woocommerce-tabs #tab-reviews .stars a[class*="star-"]::before { color: ' . esc_html( $color_accent ) . '; }';

		/* Cart */
		$custom_css .= '.woocommerce-cart .shop_table .button {
			background-color: ' . esc_html( $color_accent ) . ' !important; 
			border-color: ' . esc_html( $color_accent ) . ' !important;
		 }';

		/* Account */
		$custom_css .= '.woocommerce-account form.woocommerce-form.woocommerce-form-login .form-group.is-focused input {
			border-color: ' . esc_html( $color_accent ) . ';
		}';

		$custom_css .= '.woocommerce-account .woocommerce-MyAccount-content .woocommerce-EditAccountForm .form-group.is-focused input {
			border-color: ' . esc_html( $color_accent ) . ';
		}';

		/* Navbar Hover */
		$custom_css .= '
			.navbar.navbar-default:not(.navbar-transparent) li:not(.btn):hover > a, 
			.navbar.navbar-default.navbar-transparent .dropdown-menu li:not(.btn):hover > a, 
			.navbar.navbar-default:not(.navbar-transparent) li:not(.btn):hover > a i, 
			.navbar.navbar-default:not(.navbar-transparent) .navbar-toggle:hover, 
			.navbar.navbar-default:not(.full-screen-menu) .nav-cart-icon .nav-cart-content a:hover, 
			.navbar.navbar-default:not(.navbar-transparent) .hestia-toggle-search:hover {
				color: ' . esc_html( $color_accent ) . ' !important;
			}';

		/* Forms bottom border color */
		$custom_css .= 'input:not([type="submit"]):focus-within { border: 1px solid ' . esc_html( $color_accent ) . ' !important; }';
		$custom_css .= '
			textarea.form-control:focus-within,
			input[type="checkbox"]:focus-within,
			input[type="file"]:focus-within,
			select:focus-within { 
				border: none !important;
				border-bottom: 1px solid ' . esc_html( $color_accent ) . ' !important; 
			}';
	}

	wp_add_inline_style( 'fagri_parent', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'fagri_inline_style', 10 );
