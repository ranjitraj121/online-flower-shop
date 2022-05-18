<?php
/**
 * Shortcode: Super title
 *
 * @package ThemeREX Addons
 * @since v1.6.49
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	exit;
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_supertitle_load_scripts_front' ) ) {
	add_action( "wp_enqueue_scripts", 'trx_addons_sc_supertitle_load_scripts_front', TRX_ADDONS_ENQUEUE_SCRIPTS_PRIORITY );
	add_action( 'trx_addons_action_pagebuilder_preview_scripts', 'trx_addons_sc_supertitle_load_scripts_front', 10, 1 );
	function trx_addons_sc_supertitle_load_scripts_front( $force = false ) {
		static $loaded = false;
		$debug    = trx_addons_is_on( trx_addons_get_option( 'debug_mode' ) );
		$optimize = ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) );
		$preview_elm = trx_addons_is_preview( 'elementor' );
		$preview_gb  = trx_addons_is_preview( 'gutenberg' );
		$theme_full  = current_theme_supports( 'styles-and-scripts-full-merged' );
		$need        = ! $loaded && ( ! $preview_elm || $debug ) && ! $preview_gb && $optimize && (
						$force === true
							|| ( $preview_elm && $debug )
							|| trx_addons_sc_check_in_content( array(
											'sc' => 'sc_supertitle',
											'entries' => array(
												array( 'type' => 'sc',  'sc' => 'trx_sc_supertitle' ),
												array( 'type' => 'gb',  'sc' => 'wp:trx-addons/supertitle' ),
												array( 'type' => 'elm', 'sc' => '"widgetType":"trx_sc_supertitle"' ),
												array( 'type' => 'elm', 'sc' => '"shortcode":"[trx_sc_supertitle' ),
											)
								) )
							);
		if ( ! $loaded && ! $preview_gb && ( ( ! $optimize && $debug ) || ( $optimize && $need ) ) ) {
			$loaded = true;
			wp_enqueue_style( 'trx_addons-sc_supertitle', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/supertitle.css'), array(), null );
			do_action( 'trx_addons_action_load_scripts_front', $force, 'sc_supertitle' );
		}
		if ( ! $loaded && $preview_elm && $optimize && ! $debug && ! $theme_full ) {
			do_action( 'trx_addons_action_load_scripts_front', false, 'sc_supertitle', 2 );
		}
	}
}

// Enqueue responsive styles for frontend
if ( ! function_exists( 'trx_addons_sc_supertitle_load_scripts_front_responsive' ) ) {
	add_action( 'wp_enqueue_scripts', 'trx_addons_sc_supertitle_load_scripts_front_responsive', TRX_ADDONS_ENQUEUE_RESPONSIVE_PRIORITY );
	add_action( 'trx_addons_action_load_scripts_front_sc_supertitle', 'trx_addons_sc_supertitle_load_scripts_front_responsive', 10, 1 );
	function trx_addons_sc_supertitle_load_scripts_front_responsive( $force = false ) {
		static $loaded = false;
		if ( ! $loaded && (
			current_action() == 'wp_enqueue_scripts' && trx_addons_need_frontend_scripts( 'sc_supertitle' )
			||
			current_action() != 'wp_enqueue_scripts' && $force === true
			)
		) {
			$loaded = true;
			wp_enqueue_style( 'trx_addons-sc_supertitle-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/supertitle.responsive.css'), array(), null, trx_addons_media_for_load_css_responsive( 'sc-supertitle', 'sm' ) );
		}
	}
}

// Merge shortcode's specific styles to the single stylesheet
if ( !function_exists( 'trx_addons_sc_supertitle_merge_styles' ) ) {
	add_filter('trx_addons_filter_merge_styles', 'trx_addons_sc_supertitle_merge_styles');
	function trx_addons_sc_supertitle_merge_styles($list) {
		$list[ TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/supertitle.css' ] = false;
		return $list;
	}
}

// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_supertitle_merge_styles_responsive' ) ) {
	add_filter('trx_addons_filter_merge_styles_responsive', 'trx_addons_sc_supertitle_merge_styles_responsive');
	function trx_addons_sc_supertitle_merge_styles_responsive($list) {
		$list[ TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/supertitle.responsive.css' ] = false;
		return $list;
	}
}

// Load styles and scripts if present in the cache of the menu
if ( !function_exists( 'trx_addons_sc_supertitle_check_in_html_output' ) ) {
//	add_filter( 'trx_addons_filter_get_menu_cache_html', 'trx_addons_sc_supertitle_check_in_html_output', 10, 1 );
	add_action( 'trx_addons_action_show_layout_from_cache', 'trx_addons_sc_supertitle_check_in_html_output', 10, 1 );
	add_action( 'trx_addons_action_check_page_content', 'trx_addons_sc_supertitle_check_in_html_output', 10, 1 );
	function trx_addons_sc_supertitle_check_in_html_output( $content = '' ) {
		if ( ! trx_addons_need_frontend_scripts( 'sc_supertitle' )
			&& ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading' ) )
		) {
			$checklist = apply_filters( 'trx_addons_filter_check_in_html', array(
							'class=[\'"][^\'"]*sc_supertitle'
							),
							'sc_supertitle'
						);
			foreach ( $checklist as $item ) {
				if ( preg_match( "#{$item}#", $content, $matches ) ) {
					trx_addons_sc_supertitle_load_scripts_front( true );
					break;
				}
			}
		}
		return $content;
	}
}

// Check if there are side title
if ( !function_exists( 'trx_addons_sc_supertitle_has_side_title' ) ) {
	function trx_addons_sc_supertitle_has_side_title($sc_args) {
		$side = is_rtl() ? 'left' : 'right';
		if (!empty($sc_args['items']) && in_array( $side, array_column($sc_args['items'], 'align'))) {
			return true;
		}
		return false;
	}
}


// [trx_sc_supertitle]
//-------------------------------------------------------------
/*
[trx_sc_supertitle id="unique_id" "type" => "default"]
*/
if ( !function_exists( 'trx_addons_sc_supertitle' ) ) {
	function trx_addons_sc_supertitle($atts, $content=null) {
		$atts = trx_addons_sc_prepare_atts('trx_sc_supertitle', $atts, trx_addons_sc_common_atts('id', array(
				// Individual params
				'type' => 'default',
				'icon_column' => 8,
				'header_column' => 8,
				'items' => '',
				'icon' => '',
				'icon_color' => '',
				'icon_size' => '',
				'icon_bg_color' => '',
				'image' => '',
			))
		);
		$atts['header_column'] = max(0, min($atts['header_column'], 11));
		if (function_exists('vc_param_group_parse_atts') && !is_array($atts['items'])) {
			$atts['items'] = (array) vc_param_group_parse_atts( $atts['items'] );
		}
		// Load shortcode-specific scripts and styles
		trx_addons_sc_supertitle_load_scripts_front( true );
		// Load template
		$output = '';
		if (is_array($atts['items']) && count($atts['items']) > 0) {
			$output = trx_addons_get_template_part_as_string(array(
				TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/tpl.'.trx_addons_esc($atts['type']).'.php',
				TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/tpl.default.php'
				),
				'trx_addons_args_sc_supertitle',
				$atts
			);
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_supertitle', $atts, $content);
	}
}


// Add shortcode [trx_sc_supertitle]
if (!function_exists('trx_addons_sc_supertitle_add_shortcode')) {
	function trx_addons_sc_supertitle_add_shortcode() {
		add_shortcode('trx_sc_supertitle', 'trx_addons_sc_supertitle');
	}
	add_action('init', 'trx_addons_sc_supertitle_add_shortcode', 20);
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/supertitle-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/supertitle-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/supertitle-sc-vc.php';
}
