<?php
/**
 * Customizer functionality for the theme
 *
 * @package fagri
 * @since 1.0.0
 */

/**
 * Customizer controls
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @since 1.0.0
 */
function fagri_customize_register( $wp_customize ) {

	/* Remove boxed layout control */
	$wp_customize->remove_control( 'hestia_general_layout' );

	/* Change default fonts, old priority 99 */
	$fagri_headings_font = $wp_customize->get_setting( 'hestia_headings_font' );
	if ( ! empty( $fagri_headings_font ) ) {
		$fagri_headings_font->default = fagri_font_default_frontend();
	}
	$fagri_body_font = $wp_customize->get_setting( 'hestia_body_font' );
	if ( ! empty( $fagri_body_font ) ) {
		$fagri_body_font->default = fagri_font_default_frontend();
	}

	/* Option for background image in testimonials section */
	$wp_customize->add_setting(
		'fagri_testimonials_background', array(
			'default'           => get_stylesheet_directory_uri() . '/assets/img/light_waves.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'fagri_testimonials_background', array(
				'label'    => esc_html__( 'Background Image', 'fagri' ),
				'section'  => 'hestia_testimonials',
				'priority' => 4,
			)
		)
	);

	/* Option for background image in team section */
	$wp_customize->add_setting(
		'fagri_team_background', array(
			'default'           => get_stylesheet_directory_uri() . '/assets/img/tower.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'fagri_team_background', array(
				'label'    => esc_html__( 'Background Image', 'fagri' ),
				'section'  => 'hestia_team',
				'priority' => 4,
			)
		)
	);

}
add_action( 'customize_register', 'fagri_customize_register', 99 );
