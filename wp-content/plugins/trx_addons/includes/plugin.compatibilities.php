<?php
/**
 * Compatibility fixes for WordPress updates, 3rd-party plugins, etc.
 *
 * @package ThemeREX Addons
 * @since v2.1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }



/* WordPress 5.8+: Widgets block editor in Customize don't allow moving sections with widgets
 *                 from the panel 'Widgets' to another panel
--------------------------------------------------------------------------------------------------- */
if ( ! function_exists( 'trx_addons_disable_moving_widgets_sections_in_customizer' ) ) {
	add_filter( 'after_setup_theme', 'trx_addons_disable_moving_widgets_sections_in_customizer', 1 );
	function trx_addons_disable_moving_widgets_sections_in_customizer() {
		if ( version_compare( get_bloginfo( 'version' ), '5.8', '>=' ) ) {
			$slug = str_replace( '-', '_', get_template() );
			add_filter( "{$slug}_filter_front_page_options", 'trx_addons_disable_moving_widgets_sections_in_customizer_callback', 10000, 1 );
		}
	}
}

// Rename sections with widgets to prevent its moving
if ( ! function_exists( 'trx_addons_disable_moving_widgets_sections_in_customizer_callback' ) ) {
	function trx_addons_disable_moving_widgets_sections_in_customizer_callback( $options ) {
		if ( isset( $options['front_page_sections']['options'] ) && is_array( $options['front_page_sections']['options'] ) ) {
			foreach ( $options['front_page_sections']['options'] as $k => $v ) {
				if ( isset( $options["sidebar-widgets-front_page_{$k}_widgets"] ) && ! isset( $options["front_page_{$k}_widgets"] ) ) {
					trx_addons_array_insert_after( $options, "sidebar-widgets-front_page_{$k}_widgets", array(
						"front_page_{$k}_widgets" => $options["sidebar-widgets-front_page_{$k}_widgets"]
					) );
					unset( $options["sidebar-widgets-front_page_{$k}_widgets"] );
				}
				if ( ! empty( $options["front_page_{$k}_widgets_info"]['desc'] ) && is_string( $options["front_page_{$k}_widgets_info"]['desc'] ) ) {
					$options["front_page_{$k}_widgets_info"]['desc'] .= '<br>&nbsp;<br><i>' . wp_kses_data( sprintf( __( 'Attention! Since WordPress 5.8+ you are not able to select widgets for this section here, in order to do that please go to Customize - Widgets - Front page section "%s"', 'trx_addons' ), $v ) . '</i>' );
				}
			}
		}
		return $options;
	}
}
