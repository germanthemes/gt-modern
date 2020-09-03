<?php
/**
 * License Settings
 *
 * Register License Settings
 *
 * @package GT Modern
 */

/**
 * Adds all License settings to the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function gt_modern_customize_register_license_settings( $wp_customize ) {

	// Add Section for License.
	$wp_customize->add_section( 'gt_modern_section_license', array(
		'title'       => esc_html__( 'License', 'gt-modern' ),
		'description' => esc_html__( 'Please enter your license key. An active license key is necessary for automatic theme updates and support.', 'gt-modern' ),
		'priority'    => 60,
		'panel'       => 'gt_modern_options_panel',
	) );

	// Add Theme Links control.
	$wp_customize->add_control( new GT_Modern_Customize_Links_Control(
		$wp_customize, 'gt_modern_theme_links', array(
			'section'  => 'gt_modern_section_license',
			'settings' => array(),
			'priority' => 10,
		)
	) );

	// Add License Key setting.
	$wp_customize->add_setting( 'gt_modern_theme_options[license_key]', array(
		'default'           => '',
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( new GT_Modern_Customize_License_Control(
		$wp_customize, 'license_key', array(
			'label'    => esc_html__( 'License Key', 'gt-modern' ),
			'section'  => 'gt_modern_section_license',
			'settings' => 'gt_modern_theme_options[license_key]',
			'priority' => 20,
		)
	) );
}
add_action( 'customize_register', 'gt_modern_customize_register_license_settings' );
