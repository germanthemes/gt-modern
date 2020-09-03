<?php
/**
 * Layout Settings
 *
 * @package GT Modern
 */

/**
 * Add Layout settings to the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function gt_modern_customize_register_layout_settings( $wp_customize ) {

	// Add Section for Layout Settings.
	$wp_customize->add_section( 'gt_modern_section_layout', array(
		'title'    => esc_html__( 'Layout Settings', 'gt-modern' ),
		'priority' => 10,
		'panel'    => 'gt_modern_options_panel',
	) );

	// Get Default Settings.
	$default = gt_modern_default_options();

	// Add Phone Number setting.
	$wp_customize->add_setting( 'gt_modern_theme_options[header_phone]', array(
		'default'           => $default['header_phone'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'gt_modern_sanitize_header_text',
	) );

	$wp_customize->add_control( 'gt_modern_theme_options[header_phone]', array(
		'label'    => __( 'Phone Number', 'gt-modern' ),
		'section'  => 'gt_modern_section_layout',
		'settings' => 'gt_modern_theme_options[header_phone]',
		'type'     => 'text',
		'priority' => 10,
	) );

	// Add selective refresh for phone number.
	$wp_customize->selective_refresh->add_partial( 'gt_modern_theme_options[header_phone]', array(
		'selector'         => '.header-bar .header-bar-content .header-phone-text',
		'render_callback'  => 'gt_modern_customize_partial_header_phone',
		'fallback_refresh' => false,
	) );

	// Add Email setting.
	$wp_customize->add_setting( 'gt_modern_theme_options[header_email]', array(
		'default'           => $default['header_email'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'gt_modern_sanitize_header_text',
	) );

	$wp_customize->add_control( 'gt_modern_theme_options[header_email]', array(
		'label'    => __( 'Email Address', 'gt-modern' ),
		'section'  => 'gt_modern_section_layout',
		'settings' => 'gt_modern_theme_options[header_email]',
		'type'     => 'text',
		'priority' => 20,
	) );

	// Add selective refresh for email address.
	$wp_customize->selective_refresh->add_partial( 'gt_modern_theme_options[header_email]', array(
		'selector'         => '.header-bar .header-bar-content .header-email-text',
		'render_callback'  => 'gt_modern_customize_partial_header_email',
		'fallback_refresh' => false,
	) );

	// Add Address Line setting.
	$wp_customize->add_setting( 'gt_modern_theme_options[header_address]', array(
		'default'           => $default['header_address'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'gt_modern_sanitize_header_text',
	) );

	$wp_customize->add_control( 'gt_modern_theme_options[header_address]', array(
		'label'    => __( 'Location', 'gt-modern' ),
		'section'  => 'gt_modern_section_layout',
		'settings' => 'gt_modern_theme_options[header_address]',
		'type'     => 'text',
		'priority' => 40,
	) );

	// Add selective refresh for location address.
	$wp_customize->selective_refresh->add_partial( 'gt_modern_theme_options[header_address]', array(
		'selector'         => '.header-bar .header-bar-content .header-address-text',
		'render_callback'  => 'gt_modern_customize_partial_header_address',
		'fallback_refresh' => false,
	) );

	// Add Header Search Headline.
	$wp_customize->add_control( new GT_Modern_Customize_Header_Control(
		$wp_customize, 'gt_modern_theme_options[header_search_title]', array(
			'label'    => esc_html__( 'Header Search', 'gt-modern' ),
			'section'  => 'gt_modern_section_layout',
			'settings' => array(),
			'priority' => 40,
		)
	) );

	// Add Setting and Control for header search checkbox.
	$wp_customize->add_setting( 'gt_modern_theme_options[header_search]', array(
		'default'           => $default['header_search'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'gt_modern_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'gt_modern_theme_options[header_search]', array(
		'label'    => esc_html__( 'Enable search function in header', 'gt-modern' ),
		'section'  => 'gt_modern_section_layout',
		'settings' => 'gt_modern_theme_options[header_search]',
		'type'     => 'checkbox',
		'priority' => 50,
	) );

	// Add Scroll to Top Headline.
	$wp_customize->add_control( new GT_Modern_Customize_Header_Control(
		$wp_customize, 'gt_modern_theme_options[scroll_top_title]', array(
			'label'    => esc_html__( 'Scroll-to-Top Button', 'gt-modern' ),
			'section'  => 'gt_modern_section_layout',
			'settings' => array(),
			'priority' => 60,
		)
	) );

	// Add Setting and Control for scroll to top checkbox.
	$wp_customize->add_setting( 'gt_modern_theme_options[scroll_to_top]', array(
		'default'           => $default['scroll_to_top'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'gt_modern_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'gt_modern_theme_options[scroll_to_top]', array(
		'label'    => esc_html__( 'Enable Scroll-to-Top Button', 'gt-modern' ),
		'section'  => 'gt_modern_section_layout',
		'settings' => 'gt_modern_theme_options[scroll_to_top]',
		'type'     => 'checkbox',
		'priority' => 70,
	) );
}
add_action( 'customize_register', 'gt_modern_customize_register_layout_settings' );


/**
 * Render the phone number for the selective refresh partial.
 */
function gt_modern_customize_partial_header_phone() {
	echo wp_kses_post( gt_modern_get_option( 'header_phone' ) );
}


/**
 * Render the email address for the selective refresh partial.
 */
function gt_modern_customize_partial_header_email() {
	echo wp_kses_post( gt_modern_get_option( 'header_email' ) );
}


/**
 * Render the location for the selective refresh partial.
 */
function gt_modern_customize_partial_header_address() {
	echo wp_kses_post( gt_modern_get_option( 'header_address' ) );
}
