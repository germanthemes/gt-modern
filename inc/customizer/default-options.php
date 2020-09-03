<?php
/**
 * Returns theme options
 *
 * Uses sane defaults in case the user has not configured any theme options yet.
 *
 * @package GT Modern
 */

/**
* Get a single theme option
*
* @return mixed
*/
function gt_modern_get_option( $option_name = '' ) {

	// Get all Theme Options from Database.
	$theme_options = gt_modern_theme_options();

	// Return single option.
	if ( isset( $theme_options[ $option_name ] ) ) {
		return $theme_options[ $option_name ];
	}

	return false;
}


/**
 * Get saved user settings from database or theme defaults
 *
 * @return array
 */
function gt_modern_theme_options() {

	// Merge theme options array from database with default options array.
	$theme_options = wp_parse_args( get_option( 'gt_modern_theme_options', array() ), gt_modern_default_options() );

	// Return theme options.
	return apply_filters( 'gt_modern_theme_options', $theme_options );
}


/**
 * Returns the default settings of the theme
 *
 * @return array
 */
function gt_modern_default_options() {

	$default_options = array(
		'retina_logo'           => false,
		'site_title'            => true,
		'site_description'      => true,
		'header_phone'          => '0123-456789',
		'header_email'          => 'email@domain.com',
		'header_address'        => '',
		'header_search'         => false,
		'scroll_to_top'         => false,
		'meta_date'             => true,
		'meta_author'           => true,
		'meta_categories'       => true,
		'meta_tags'             => false,
		'primary_color'         => '#202020',
		'secondary_color'       => '#0068a0',
		'accent_color'          => '#084868',
		'highlight_color'       => '#00b0f8',
		'light_gray_color'      => '#f0f0f0',
		'gray_color'            => '#707070',
		'dark_gray_color'       => '#303030',
		'header_bar_color'      => '#ffffff',
		'header_bar_icon_color' => '#e34333',
		'header_color'          => '#c92919',
		'title_color'           => '#303030',
		'title_hover_color'     => '#e34333',
		'title_border_color'    => '#e34333',
		'link_color'            => '#e34333',
		'link_hover_color'      => '#c92919',
		'button_color'          => '#e34333',
		'button_hover_color'    => '#c92919',
		'footer_color'          => '#202020',
		'text_font'             => 'Roboto',
		'title_font'            => 'Roboto',
		'title_is_bold'         => true,
		'title_is_uppercase'    => false,
		'navi_font'             => 'Roboto',
		'navi_is_bold'          => true,
		'navi_is_uppercase'     => false,
		'license_key'           => '',
		'license_status'        => 'inactive',
	);

	return apply_filters( 'gt_modern_default_options', $default_options );
}
