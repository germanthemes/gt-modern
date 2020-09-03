<?php
/**
 * GT Modern functions and definitions
 *
 * @package GT Modern
 */

/**
 * GT Modern only works in WordPress 5.3 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '5.3', '<' ) ) {
	require get_template_directory() . '/inc/admin/back-compat.php';
	return;
}


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function gt_modern_setup() {

	// Make theme available for translation.
	load_theme_textdomain( 'gt-modern', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Set default Post Thumbnail size.
	set_post_thumbnail_size( 1600, 900, true );

	// Add image size for header image on single posts and pages.
	add_image_size( 'gt-modern-header-image', 9999, 640, true );

	// Register Navigation Menus.
	register_nav_menus( array(
		'primary'       => esc_html__( 'Main Navigation', 'gt-modern' ),
		'footer'        => esc_html__( 'Footer Navigation', 'gt-modern' ),
		'social-header' => esc_html__( 'Social Icons (Header)', 'gt-modern' ),
		'social-footer' => esc_html__( 'Social Icons (Footer)', 'gt-modern' ),
	) );

	// Switch default core markup for galleries and captions to output valid HTML5.
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom logo feature.
	add_theme_support( 'custom-logo', apply_filters( 'gt_modern_custom_logo_args', array(
		'height'      => 60,
		'width'       => 300,
		'flex-height' => true,
		'flex-width'  => true,
	) ) );

	// Set up the WordPress core custom header feature.
	add_theme_support( 'custom-header', apply_filters( 'gt_modern_custom_header_args', array(
		'header-text' => false,
		'width'       => 9999,
		'height'      => 640,
	) ) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'gt_modern_custom_background_args', array(
		'default-color' => 'ffffff',
	) ) );

	// Add Theme Support for Selective Refresh in Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'gt_modern_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function gt_modern_content_width() {
	// Set global variable for content width.
	$GLOBALS['content_width'] = apply_filters( 'gt_modern_content_width', 800 );
}
add_action( 'after_setup_theme', 'gt_modern_content_width', 0 );


/**
 * Enqueue scripts and styles.
 */
function gt_modern_scripts() {

	// Get Theme Version.
	$theme_version = wp_get_theme()->get( 'Version' );

	// Register and Enqueue Stylesheet.
	wp_enqueue_style( 'gt-modern-stylesheet', get_stylesheet_uri(), array(), $theme_version );

	// Register and enqueue navigation.js.
	if ( has_nav_menu( 'primary' ) or has_nav_menu( 'social-header' ) ) {
		wp_enqueue_script( 'gt-modern-navigation', get_theme_file_uri( '/assets/js/navigation.min.js' ), array( 'jquery' ), '20200327', true );
		$gt_modern_l10n = array(
			'expand'   => esc_html__( 'Expand child menu', 'gt-modern' ),
			'collapse' => esc_html__( 'Collapse child menu', 'gt-modern' ),
			'icon'     => gt_modern_get_svg( 'expand' ),
		);
		wp_localize_script( 'gt-modern-navigation', 'gtModernScreenReaderText', $gt_modern_l10n );
	}

	// Register and enqueue header-search.js if enabled
	if ( true === gt_modern_get_option( 'header_search' ) || is_customize_preview() ) :

		wp_enqueue_script( 'gt-modern-header-search', get_theme_file_uri( '/assets/js/header-search.min.js' ), array( 'jquery' ), '20200327', true );

	endif;

	// Register and enqueue scroll-to-top.js if enabled
	if ( true === gt_modern_get_option( 'scroll_to_top' ) || is_customize_preview() ) :

		wp_enqueue_script( 'gt-modern-scroll-to-top', get_theme_file_uri( '/assets/js/scroll-to-top.min.js' ), array( 'jquery' ), '20200327', true );
		wp_localize_script( 'gt-modern-scroll-to-top', 'gtModernScrollButton', gt_modern_get_svg( 'collapse' ) );

	endif;

	// Enqueue svgxuse to support external SVG Sprites in Internet Explorer.
	wp_enqueue_script( 'svgxuse', get_theme_file_uri( '/assets/js/svgxuse.min.js' ), array(), '1.2.4' );

	// Register Comment Reply Script for Threaded Comments.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'gt_modern_scripts' );


/**
* Enqueue theme fonts.
*/
function gt_modern_theme_fonts() {
	wp_enqueue_style( 'gt-modern-theme-fonts', get_template_directory_uri() . '/assets/css/theme-fonts.css', array(), '20200320' );
}
add_action( 'wp_enqueue_scripts', 'gt_modern_theme_fonts', 1 );
add_action( 'enqueue_block_editor_assets', 'gt_modern_theme_fonts', 1 );


/**
 * Register widget areas and custom widgets.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function gt_modern_widgets_init() {

	// Register Blog Sidebar widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'gt-modern' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html_x( 'Appears on blog pages and single posts.', 'widget area description', 'gt-modern' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Register Before Header widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Before Header', 'gt-modern' ),
		'id'            => 'before-header',
		'description'   => esc_html_x( 'Appears above the header area.', 'widget area description', 'gt-modern' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Register After Header widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'After Header', 'gt-modern' ),
		'id'            => 'after-header',
		'description'   => esc_html_x( 'Appears below the header area.', 'widget area description', 'gt-modern' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Register Before Blog widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Before Content', 'gt-modern' ),
		'id'            => 'before-content',
		'description'   => esc_html_x( 'Appears above the content area.', 'widget area description', 'gt-modern' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Register After Posts widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'After Single Posts', 'gt-modern' ),
		'id'            => 'after-posts',
		'description'   => esc_html_x( 'Appears below single posts.', 'widget area description', 'gt-modern' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Register After Pages widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'After Pages', 'gt-modern' ),
		'id'            => 'after-pages',
		'description'   => esc_html_x( 'Appears below static pages.', 'widget area description', 'gt-modern' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Register Before Footer widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Before Footer', 'gt-modern' ),
		'id'            => 'before-footer',
		'description'   => esc_html_x( 'Appears above the footer area.', 'widget area description', 'gt-modern' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Register Footer Column 1 widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'gt-modern' ),
		'id'            => 'footer-column-1',
		'description'   => esc_html_x( 'Appears in the first column in footer.', 'widget area description', 'gt-modern' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	// Register Footer Column 2 widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'gt-modern' ),
		'id'            => 'footer-column-2',
		'description'   => esc_html_x( 'Appears in the second column in footer.', 'widget area description', 'gt-modern' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	// Register Footer Column 3 widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'gt-modern' ),
		'id'            => 'footer-column-3',
		'description'   => esc_html_x( 'Appears in the third column in footer.', 'widget area description', 'gt-modern' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	// Register Footer Column 4 widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 4', 'gt-modern' ),
		'id'            => 'footer-column-4',
		'description'   => esc_html_x( 'Appears in the fourth column in footer.', 'widget area description', 'gt-modern' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	// Register Footer Copyright widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Copyright', 'gt-modern' ),
		'id'            => 'footer-copyright',
		'description'   => esc_html_x( 'Appears in the bottom footer line.', 'widget area description', 'gt-modern' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'gt_modern_widgets_init' );


/**
 * Set up automatic theme updates.
 *
 * @return void
 */
function gt_modern_theme_updater() {
	if ( '' !== gt_modern_get_option( 'license_key' ) ) :

		// Setup the updater.
		$theme_updater = new GT_Modern_Theme_Updater(
			array(
				'remote_api_url' => GT_MODERN_STORE_API_URL,
				'version'        => '1.2',
				'license'        => trim( gt_modern_get_option( 'license_key' ) ),
				'item_id'        => GT_MODERN_PRODUCT_ID,
				'item_name'      => 'GT Modern',
				'theme_slug'     => 'gt-modern',
				'author'         => 'GermanThemes',
			),
			array(
				'update-notice'    => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'gt-modern' ),
				'update-available' => __( '<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4$s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'gt-modern' ),
			)
		);

	endif;
}
add_action( 'admin_init', 'gt_modern_theme_updater', 0 );


/**
 * Include Files
 */

// Include Admin Classes.
require get_template_directory() . '/inc/admin/license-key.php';
require get_template_directory() . '/inc/admin/theme-updater.php';

// Include Customizer Options.
require get_template_directory() . '/inc/customizer/customizer.php';
require get_template_directory() . '/inc/customizer/default-options.php';

// Include Template Functions.
require get_template_directory() . '/inc/template-functions.php';

// Include Template Tags.
require get_template_directory() . '/inc/template-tags.php';

// Include Gutenberg Features.
require get_template_directory() . '/inc/gutenberg.php';

// Include Customization Features.
require get_template_directory() . '/inc/custom-colors.php';
require get_template_directory() . '/inc/custom-fonts.php';
