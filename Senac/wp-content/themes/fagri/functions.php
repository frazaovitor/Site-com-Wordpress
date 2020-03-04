<?php
/**
 * Fagri functions and definitions.
 *
 * @package fagri
 * @since 1.0.0
 */

define( 'FAGRI_VERSION', '1.0.6' );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'fagri_parent_css' ) ) :
	/**
	 * Enqueue parent style
	 *
	 * @since 1.0.0
	 */
	function fagri_parent_css() {
		wp_enqueue_style( 'fagri_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'bootstrap' ), FAGRI_VERSION );
		wp_style_add_data( 'fagri_parent', 'rtl', 'replace' );
		wp_style_add_data( 'hestia_style', 'rtl', 'replace' );
	}

endif;
add_action( 'wp_enqueue_scripts', 'fagri_parent_css', 10 );

/**
 * Remove functionality from forms
 *
 * @since 1.0.6
 */
function fagri_remove_materialjs() {
	wp_dequeue_script( 'jquery-hestia-material' );
	wp_deregister_script( 'jquery-hestia-material' );
}
add_filter( 'wp_enqueue_scripts', 'fagri_remove_materialjs' );

/**
 * Enqueue customizer js
 */
function fagri_customizer_preview_js() {

	wp_enqueue_script( 'fagri-customizer-preview-js', get_stylesheet_directory_uri() . '/assets/js/customizer-preview.js', array( 'jquery', 'customize-preview' ), FAGRI_VERSION, true );
}
add_action( 'customize_preview_init', 'fagri_customizer_preview_js', 10 );

/* Require files */
$fagri_customizer_controls = get_stylesheet_directory() . '/inc/customizer/customizer.php';
if ( file_exists( $fagri_customizer_controls ) ) {
	require_once $fagri_customizer_controls;
}

$fagri_inline_style = get_stylesheet_directory() . '/inc/inline-style.php';
if ( file_exists( $fagri_inline_style ) ) {
	require_once $fagri_inline_style;
}

$fagri_front_page_sections = get_stylesheet_directory() . '/inc/fp-sections.php';
if ( file_exists( $fagri_front_page_sections ) ) {
	require_once $fagri_front_page_sections;
}

/**
 * Change default font family for front end display.
 *
 * @return string
 *
 * @since 1.0.0
 */
function fagri_font_default_frontend() {
	return 'Montserrat';
}
add_filter( 'hestia_headings_default', 'fagri_font_default_frontend' );
add_filter( 'hestia_body_font_default', 'fagri_font_default_frontend' );

/**
 * Change default value of accent color
 *
 * @return string - default accent color
 * @since 1.0.0
 */
function fagri_accent_color() {
	return '#2ca8ff';
}
add_filter( 'hestia_accent_color_default', 'fagri_accent_color' );

/**
 * Change default value of gradient color
 *
 * @return string - default gradient color
 * @since 1.0.0
 */
function fagri_gradient_color() {
	return '#43b1ff';
}
add_filter( 'hestia_header_gradient_default', 'fagri_gradient_color' );

/**
 * Enable featured posts section by default, on Blog Page
 *
 * This function checks if there is a category with the id 1
 * And if it has posts in it
 * and it shows posts from this category by default, instead of disabling section
 */
function fagri_enable_featured_posts_section() {

	/* Check if a category with id 1 exists */
	if ( ! term_exists( 1 ) ) {
		return array( 0 );
	}

	/* Check if the category with id 1 has posts */
	$nb_of_posts_in_category = get_category( 1 )->count;
	if ( is_numeric( $nb_of_posts_in_category ) && ( $nb_of_posts_in_category <= 0 ) ) {
		return array( 0 );
	}

	/* Return the category with id 1 as choice */
	return array( 1 );
}
add_filter( 'hestia_featured_posts_category_default', 'fagri_enable_featured_posts_section' );


/**
 * Change default header image in Big Title Section
 *
 * @since 1.0.0
 * @return string - path to image
 */
function fagri_header_background_default() {
	return get_stylesheet_directory_uri() . '/assets/img/glass_building.jpg';
}
add_filter( 'hestia_big_title_background_default', 'fagri_header_background_default' );

/**
 * Change default boxed layout option to unboxed
 *
 * @since 1.0.0
 */
function fagri_remove_boxed_layout_option() {
	set_theme_mod( 'hestia_general_layout', 0 );
}
add_action( 'after_switch_theme', 'fagri_remove_boxed_layout_option' );

/**
 * HEX colors conversion to RGBA.
 *
 * @param array|string $input RGB color.
 * @param int          $opacity Opacity value.
 */
function fagri_hex_rgba( $input, $opacity = false ) {

	// Convert hexadeciomal color to rgb(a)
	$rgb = hestia_hex_rgb( $input );
	return hestia_rgb_to_rgba( $rgb, $opacity );
}

/**
 * Remove parent theme actions
 *
 * @since 1.0.0
 */
function fagri_remove_hestia_actions() {

	/* Remove three points from blog read more button */
	remove_filter( 'excerpt_more', 'hestia_excerpt_more', 10 );

}
add_action( 'after_setup_theme', 'fagri_remove_hestia_actions' );

/**
 * Replace excerpt more button and points with nothing
 *
 * On Blog page and Archive pages, the excerpt more is the Read More link
 * On front page, and other pages than above, there is no excerpt more
 * This function returns an empty string on the second case because by default there will be three points with a link ...
 *
 * @return string - string to show instead of excerpt more
 * @since 1.0.0
 */
function fagri_remove_excerpt_more_points() {
	global $post;
	if ( is_archive() || is_home() ) {
		return '<a class="moretag" href="' . esc_url( get_permalink( $post->ID ) ) . '"> ' . esc_html__( 'Read more', 'fagri' ) . '</a>';
	} else {
		return '';
	}
}
add_filter( 'excerpt_more', 'fagri_remove_excerpt_more_points' );

/**
 * Customize excerpt length on Blog page
 *
 * If current page is blog
 * 15 words if sidebar is active
 * 35 words if sidebar is hidden
 *
 * other pages than blog inherits the value from Hestia
 *
 * @param int $length - initial length.
 *
 * @return int - the new length
 *
 * @since 1.0.0
 */
function fagri_excerpt_length( $length ) {

	if ( is_archive() || is_home() ) {
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			return 35;
		}
		return 15;
	}
	return $length;
}
add_filter( 'excerpt_length', 'fagri_excerpt_length', 1000 );

/**
 * Change metadata on Blog Post
 *
 * @return string - information to show on the bottom of the post
 */
function fagri_blog_post_metadata() {

	$author_email  = get_the_author_meta( 'user_email' );
	$author_avatar = get_avatar( $author_email, 30 );

	return sprintf(
		/* translators: %1$s is Author name wrapped, %2$s is Time */
		esc_html__( '%1$s %2$s', 'fagri' ),
		/* translators: %1$s is author gravatar */
		sprintf(
			'<span class="author-avatar">%1$s</span>',
			$author_avatar
		),
		/* translators: %1$s is Author name, %2$s is author link */
		sprintf(
			'<a href="%2$s" title="%1$s" class="vcard author"><strong class="fn">%1$s</strong></a>',
			esc_html( get_the_author() ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
		)
	);
}
add_filter( 'hestia_blog_post_meta', 'fagri_blog_post_metadata' );

/**
 * Import options from Hestia
 *
 * @since 1.0.0
 */
function fagri_import_hestia_options() {
	$hestia_mods = get_option( 'theme_mods_hestia' );
	if ( ! empty( $hestia_mods ) ) {
		foreach ( $hestia_mods as $hestia_mod_k => $hestia_mod_v ) {
			set_theme_mod( $hestia_mod_k, $hestia_mod_v );
		}
	}
}
add_action( 'after_switch_theme', 'fagri_import_hestia_options' );

/**
 * Change default welcome notice that appears after theme first installed
 */
function fagri_welcome_notice_filter() {

	$theme = wp_get_theme();

	$theme_name = $theme->get( 'Name' );
	$theme      = $theme->parent();

	$theme_slug = $theme->get_template();

	$var = '<p>' . sprintf( 'Welcome! Thank you for choosing %1$s! To fully take advantage of the best our theme can offer please make sure you visit our %2$swelcome page%3$s.', $theme_name, '<a href="' . esc_url( admin_url( 'themes.php?page=' . $theme_slug . '-welcome' ) ) . '">', '</a>' ) . '</p><p><a href="' . esc_url( admin_url( 'themes.php?page=' . $theme_slug . '-welcome' ) ) . '" class="button" style="text-decoration: none;">' . sprintf( 'Get started with %s', $theme_name ) . '</a></p>';

	return wp_kses_post( $var );
}
add_filter( 'hestia_welcome_notice_filter', 'fagri_welcome_notice_filter' );

/**
 * Change About page defaults
 *
 * @param string $old_value Old value beeing filtered.
 * @param string $parameter Specific parameter for filtering.
 */
function fagri_about_page_filter( $old_value, $parameter ) {

	switch ( $parameter ) {
		case 'menu_name':
		case 'pro_menu_name':
			$return = esc_html__( 'About Fagri', 'fagri' );
			break;
		case 'page_name':
		case 'pro_page_name':
			$return = esc_html__( 'About Fagri', 'fagri' );
			break;
		case 'welcome_title':
		case 'pro_welcome_title':
			/* translators: s - theme name */
			$return = sprintf( esc_html__( 'Welcome to %s! - Version ', 'fagri' ), 'Fagri' );
			break;
		case 'welcome_content':
		case 'pro_welcome_content':
			$return = esc_html__( 'Fagri is a responsive WordPress theme, built to fit all kinds of businesses. Its multipurpose design is great for small businesses, startups, corporate businesses, freelancers, portfolios, WooCommerce, creative agencies, or niche websites (medical, restaurants, sports, fashion). Fagri was created on top of Now UI Kit and displays an elegant one-page layout, complemented by the smooth parallax effect. The theme comes with a clean look, but it also provides subtle hover animations. Moreover, Fagri offers Sendinblue newsletter integration, a flexible interface via Live Customizer, a widgetized footer, full compatibility with Elementor and Beaver Builder, a full-width featured slider, and even more functionality based on the latest WordPress trends. Last but not least, the theme is lightweight and SEO-friendly.', 'fagri' );
			break;
		default:
			$return = '';
	}
	return $return;
}
add_filter( 'hestia_about_page_filter', 'fagri_about_page_filter', 0, 3 );

/**
 * Declare text domain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function fagri_theme_setup() {
	load_child_theme_textdomain( 'fagri', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'fagri_theme_setup' );

