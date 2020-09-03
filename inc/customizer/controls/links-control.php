<?php
/**
 * Theme Links Control for the Customizer
 *
 * @package GT Modern
 */

/**
 * Make sure that custom controls are only defined in the Customizer
 */
if ( class_exists( 'WP_Customize_Control' ) ) :

	/**
	 * Displays the theme links in the Customizer.
	 */
	class GT_Modern_Customize_Links_Control extends WP_Customize_Control {
		/**
		 * Render Control
		 */
		public function render_content() {
			?>

			<div class="theme-links">

				<span class="customize-control-title"><?php esc_html_e( 'Theme Links', 'gt-modern' ); ?></span>

				<p>
					<a href="<?php echo esc_url( __( 'https://germanthemes.de/en/themes/gt-modern/', 'gt-modern' ) ); ?>?utm_source=customizer&utm_medium=textlink&utm_campaign=gt-modern&utm_content=theme-page" target="_blank">
						<?php esc_html_e( 'Theme Page', 'gt-modern' ); ?>
					</a>
				</p>

				<p>
					<a href="https://demo.germanthemes.de/?demo=gt-modern&utm_source=customizer&utm_campaign=gt-modern" target="_blank">
						<?php esc_html_e( 'Theme Demo', 'gt-modern' ); ?>
					</a>
				</p>

				<p>
					<a href="<?php echo esc_url( __( 'https://germanthemes.de/en/docs/gt-modern-documentation/', 'gt-modern' ) ); ?>?utm_source=customizer&utm_medium=textlink&utm_campaign=gt-modern&utm_content=documentation" target="_blank">
						<?php esc_html_e( 'Theme Documentation', 'gt-modern' ); ?>
					</a>
				</p>

			</div>

			<?php
		}
	}

endif;
