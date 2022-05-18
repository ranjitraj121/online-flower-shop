<?php
update_option( sprintf( 'trx_addons_theme_%s_activated', get_option( 'template' ) ), '1' );
update_option( sprintf( 'purchase_code_%s', get_option( 'template' ) ), 'purchase_code' );
/**
 * Theme functions: init, enqueue scripts and styles, include required files and widgets
 *
 * @package QWERY
 * @since QWERY 1.0
 */

if ( ! defined( 'QWERY_THEME_DIR' ) ) {
	define( 'QWERY_THEME_DIR', trailingslashit( get_template_directory() ) );
}
if ( ! defined( 'QWERY_THEME_URL' ) ) {
	define( 'QWERY_THEME_URL', trailingslashit( get_template_directory_uri() ) );
}
if ( ! defined( 'QWERY_CHILD_DIR' ) ) {
	define( 'QWERY_CHILD_DIR', trailingslashit( get_stylesheet_directory() ) );
}
if ( ! defined( 'QWERY_CHILD_URL' ) ) {
	define( 'QWERY_CHILD_URL', trailingslashit( get_stylesheet_directory_uri() ) );
}

//-------------------------------------------------------
//-- Theme init
//-------------------------------------------------------

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( ! function_exists( 'qwery_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'qwery_theme_setup1', 1 );
	function qwery_theme_setup1() {
		// Make theme available for translation
		// Translations can be filed in the /languages directory
		// Attention! Translations must be loaded before first call any translation functions!
		load_theme_textdomain( 'qwery', qwery_get_folder_dir( 'languages' ) );
	}
}

if ( ! function_exists( 'qwery_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'qwery_theme_setup9', 9 );
	function qwery_theme_setup9() {

		// Set theme content width
		$GLOBALS['content_width'] = apply_filters( 'qwery_filter_content_width', qwery_get_theme_option( 'page_width' ) );

		// Theme support '-full' versions of styles and scripts (used in the editors)
		add_theme_support( 'styles-and-scripts-full-merged' );

		// Allow external updtates
		if ( QWERY_THEME_ALLOW_UPDATE ) {
			add_theme_support( 'theme-updates-allowed' );
		}

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Custom header setup
		add_theme_support( 'custom-header',
			array(
				'header-text' => false,
				'video'       => true,
			)
		);

		// Custom logo
		add_theme_support( 'custom-logo',
			array(
				'width'       => 250,
				'height'      => 60,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
		// Custom backgrounds setup
		add_theme_support( 'custom-background', array() );

		// Partial refresh support in the Customize
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Supported posts formats
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat' ) );

		// Autogenerate title tag
		add_theme_support( 'title-tag' );

		// Add theme menus
		add_theme_support( 'nav-menus' );

		// Switch default markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

		// Register navigation menu
		register_nav_menus(
			array(
				'menu_main'   => esc_html__( 'Main Menu', 'qwery' ),
				'menu_mobile' => esc_html__( 'Mobile Menu', 'qwery' ),
				'menu_footer' => esc_html__( 'Footer Menu', 'qwery' ),
			)
		);

		// Register theme-specific thumb sizes
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 370, 0, false );
		$thumb_sizes = qwery_storage_get( 'theme_thumbs' );
		$mult        = qwery_get_theme_option( 'retina_ready', 1 );
		if ( $mult > 1 ) {
			$GLOBALS['content_width'] = apply_filters( 'qwery_filter_content_width', 1170 * $mult );
		}
		foreach ( $thumb_sizes as $k => $v ) {
			add_image_size( $k, $v['size'][0], $v['size'][1], $v['size'][2] );
			if ( $mult > 1 ) {
				add_image_size( $k . '-@retina', $v['size'][0] * $mult, $v['size'][1] * $mult, $v['size'][2] );
			}
		}
		// Add new thumb names
		add_filter( 'image_size_names_choose', 'qwery_theme_thumbs_sizes' );

		// Excerpt filters
		add_filter( 'excerpt_length', 'qwery_excerpt_length' );
		add_filter( 'excerpt_more', 'qwery_excerpt_more' );

		// Comment form
		add_filter( 'comment_form_fields', 'qwery_comment_form_fields' );
		add_filter( 'comment_form_fields', 'qwery_comment_form_agree', 11 );

		// Add required meta tags in the head
		add_action( 'wp_head', 'qwery_wp_head', 0 );

		// Load current page/post customization (if present)
		add_action( 'wp_footer', 'qwery_wp_footer' );
		add_action( 'admin_footer', 'qwery_wp_footer' );

		// Enqueue scripts and styles for the frontend
		add_action( 'wp_enqueue_scripts', 'qwery_load_theme_fonts', 0 );
		add_action( 'wp_enqueue_scripts', 'qwery_load_theme_icons', 0 );
		add_action( 'wp_enqueue_scripts', 'qwery_wp_styles', 1000 );                  // priority 1000 - load main theme styles
		add_action( 'wp_enqueue_scripts', 'qwery_wp_styles_single', 1020);            // priority 1020 - load styles of single posts
		add_action( 'wp_enqueue_scripts', 'qwery_wp_styles_plugins', 1100 );          // priority 1100 - load styles of the supported plugins
		add_action( 'wp_enqueue_scripts', 'qwery_wp_styles_custom', 1200 );           // priority 1200 - load styles with custom fonts and colors
		add_action( 'wp_enqueue_scripts', 'qwery_wp_styles_child', 1500 );            // priority 1500 - load styles of the child theme
		add_action( 'wp_enqueue_scripts', 'qwery_wp_styles_responsive', 2000 );       // priority 2000 - load responsive styles after all other styles
		add_action( 'wp_enqueue_scripts', 'qwery_wp_styles_single_responsive', 2020); // priority 2020 - load responsive styles of single posts after all other styles
		add_action( 'wp_enqueue_scripts', 'qwery_wp_styles_responsive_child', 2500);  // priority 2500 - load responsive styles of the child theme after all other responsive styles

		// Enqueue scripts for the frontend
		add_action( 'wp_enqueue_scripts', 'qwery_wp_scripts', 1000 );                 // priority 1000 - load main theme scripts
		add_action( 'wp_footer', 'qwery_localize_scripts' );

		// Add body classes
		add_filter( 'body_class', 'qwery_add_body_classes' );

		// Register sidebars
		add_action( 'widgets_init', 'qwery_register_sidebars' );
	}
}


//-------------------------------------------------------
//-- Theme styles
//-------------------------------------------------------

// Theme-specific fonts icons styles must be loaded before main stylesheet
if ( ! function_exists( 'qwery_theme_fonts' ) ) {
	//Handler of the add_action('wp_enqueue_scripts', 'qwery_load_theme_fonts', 0);
	function qwery_load_theme_fonts() {
		$links = qwery_theme_fonts_links();
		if ( count( $links ) > 0 ) {
			foreach ( $links as $slug => $link ) {
				wp_enqueue_style( sprintf( 'qwery-font-%s', $slug ), $link, array(), null );
			}
		}
	}
}

// Font icons styles must be loaded before main stylesheet
if ( ! function_exists( 'qwery_load_theme_icons' ) ) {
	//Handler of the add_action('wp_enqueue_scripts', 'qwery_load_theme_icons', 0);
	function qwery_load_theme_icons() {
		// This style NEED the theme prefix, because style 'fontello' in some plugin contain different set of characters
		// and can't be used instead this style!
		wp_enqueue_style( 'qwery-fontello', qwery_get_file_url( 'css/font-icons/css/fontello.css' ), array(), null );
	}
}


// Load frontend styles
if ( ! function_exists( 'qwery_wp_styles' ) ) {
	//Handler of the add_action('wp_enqueue_scripts', 'qwery_wp_styles', 1000);
	function qwery_wp_styles() {

		// Load main stylesheet
		$main_stylesheet = QWERY_THEME_URL . 'style.css';
		wp_enqueue_style( 'qwery-style', $main_stylesheet, array(), null );

		// Add custom bg image
		$bg_image = qwery_remove_protocol_from_url( qwery_get_theme_option( 'front_page_bg_image' ), false );
		if ( is_front_page() && ! empty( $bg_image ) && qwery_is_on( qwery_get_theme_option( 'front_page_enabled', false ) ) ) {
			// Add custom bg image for the Front page
			qwery_add_inline_css( 'body.frontpage, body.home-page, body.home { background-image:url(' . esc_url( $bg_image ) . ') !important }' );
		} else {
			// Add custom bg image for the body_style == 'boxed'
			$bg_image = qwery_get_theme_option( 'boxed_bg_image' );
			if ( ! empty( $bg_image ) && ( qwery_get_theme_option( 'body_style' ) == 'boxed' || is_customize_preview() ) ) {
				qwery_add_inline_css( '.body_style_boxed { background-image:url(' . esc_url( $bg_image ) . ') !important }' );
			}
		}

		// Add post nav background
		qwery_add_bg_in_post_nav();
	}
}

// Load styles of single posts
if ( ! function_exists( 'qwery_wp_styles_single' ) ) {
	//Handler of the add_action('wp_enqueue_scripts', 'qwery_wp_styles_single', 1020);
	function qwery_wp_styles_single() {
		if ( apply_filters( 'qwery_filters_separate_single_styles', false )
			&& apply_filters( 'qwery_filters_load_single_styles', qwery_is_single() || qwery_is_singular( 'attachment' ) || (int) qwery_get_theme_option( 'open_full_post_in_blog' ) > 0 )
		) {
			if ( qwery_is_off( qwery_get_theme_option( 'debug_mode' ) ) ) {
				$file = qwery_get_file_url( 'css/__single.css' );
				if ( ! empty( $file ) ) {
					wp_enqueue_style( 'qwery-single', $file, array(), null );
				}
			} else {
				$file = qwery_get_file_url( 'css/single.css' );
				if ( ! empty( $file ) ) {
					wp_enqueue_style( 'qwery-single', $file, array(), null );
				}
			}
		}
	}
}

// Load styles of supported plugins
if ( ! function_exists( 'qwery_wp_styles_plugins' ) ) {
	//Handler of the add_action('wp_enqueue_scripts', 'qwery_wp_styles_plugins', 1100);
	function qwery_wp_styles_plugins() {
		if ( qwery_is_off( qwery_get_theme_option( 'debug_mode' ) ) ) {
			wp_enqueue_style( 'qwery-plugins', qwery_get_file_url( 'css/__plugins' . ( qwery_is_preview() || ! qwery_optimize_css_and_js_loading() ? '-full' : '' ) . '.css' ), array(), null );
		}
	}
}

// Load styles with custom fonts and colors
if ( ! function_exists( 'qwery_wp_styles_custom' ) ) {
	//Handler of the add_action('wp_enqueue_scripts', 'qwery_wp_styles_custom', 1200);
	function qwery_wp_styles_custom() {
		if ( ! is_customize_preview() && qwery_is_off( qwery_get_theme_option( 'debug_mode' ) ) && ! qwery_is_blog_mode_custom() ) {
			wp_enqueue_style( 'qwery-custom', qwery_get_file_url( 'css/__custom.css' ), array(), null );
		} else {
			wp_enqueue_style( 'qwery-custom', qwery_get_file_url( 'css/__custom-inline.css' ), array(), null );
			wp_add_inline_style( 'qwery-custom', qwery_customizer_get_css() );
		}
	}
}

// Load child-theme stylesheet (if different) after all theme styles
if ( ! function_exists( 'qwery_wp_styles_child' ) ) {
	//Handler of the add_action('wp_enqueue_scripts', 'qwery_wp_styles_child', 1500);
	function qwery_wp_styles_child() {
		if ( QWERY_THEME_URL != QWERY_CHILD_URL ) {
			wp_enqueue_style( 'qwery-child', QWERY_CHILD_URL . 'style.css', array( 'qwery-style' ), null );
		}
	}
}

// Load responsive styles (priority 2500 - load it after other responsive styles)
if ( ! function_exists( 'qwery_wp_styles_responsive_child' ) ) {
	//Handler of the add_action('wp_enqueue_scripts', 'qwery_wp_styles_responsive_child', 2500);
	function qwery_wp_styles_responsive_child() {
		if ( QWERY_THEME_URL != QWERY_CHILD_URL && file_exists( QWERY_CHILD_DIR . 'responsive.css' ) ) {
			wp_enqueue_style( 'qwery-responsive-child', QWERY_CHILD_URL . 'responsive.css', array( 'qwery-responsive' ), null, qwery_media_for_load_css_responsive( 'main' ) );
		}
	}
}

// Load responsive styles (priority 2000 - load it after main styles and plugins custom styles)
if ( ! function_exists( 'qwery_wp_styles_responsive' ) ) {
	//Handler of the add_action('wp_enqueue_scripts', 'qwery_wp_styles_responsive', 2000);
	function qwery_wp_styles_responsive() {
		if ( qwery_is_off( qwery_get_theme_option( 'debug_mode' ) ) ) {
			wp_enqueue_style( 'qwery-responsive', qwery_get_file_url( 'css/__responsive' . ( qwery_is_preview() || ! qwery_optimize_css_and_js_loading() ? '-full' : '' ) . '.css' ), array(), null, qwery_media_for_load_css_responsive( 'main' ) );
		} else {
			wp_enqueue_style( 'qwery-responsive', qwery_get_file_url( 'css/responsive.css' ), array(), null, qwery_media_for_load_css_responsive( 'main' ) );
		}
	}
}

// Load responsive styles for single posts (priority 2020 - load it after plugins responsive styles)
if ( ! function_exists( 'qwery_wp_styles_single_responsive' ) ) {
	//Handler of the add_action('wp_enqueue_scripts', 'qwery_wp_styles_single_responsive', 2020);
	function qwery_wp_styles_single_responsive() {
		if ( apply_filters( 'qwery_filters_separate_single_styles', false )
			&& apply_filters( 'qwery_filters_load_single_styles', qwery_is_single() || qwery_is_singular( 'attachment' ) || (int) qwery_get_theme_option( 'open_full_post_in_blog' ) > 0 )
		) {
			if ( qwery_is_off( qwery_get_theme_option( 'debug_mode' ) ) ) {
				$file = qwery_get_file_url( 'css/__single-responsive.css' );
				if ( ! empty( $file ) ) {
					wp_enqueue_style( 'qwery-single-responsive', $file, array(), null, qwery_media_for_load_css_responsive( 'single' ) );
				}
			} else {
				$file = qwery_get_file_url( 'css/single-responsive.css' );
				if ( ! empty( $file ) ) {
					wp_enqueue_style( 'qwery-single-responsive', $file, array(), null, qwery_media_for_load_css_responsive( 'single' ) );
				}
			}
		}
	}
}

// Media for load responsive CSS
if ( ! function_exists( 'qwery_media_for_load_css_responsive' ) ) {
	function qwery_media_for_load_css_responsive( $slug = 'main', $media = 'all' ) {
		global $QWERY_STORAGE;
		$condition = 'all';
		$media = apply_filters( 'qwery_filter_media_for_load_css_responsive', $media, $slug );
		if ( ! empty( $QWERY_STORAGE['responsive'][ $media ]['max'] ) ) {
			$condition = sprintf( '(max-width:%dpx)', $QWERY_STORAGE['responsive'][ $media ]['max'] );
		}
		return apply_filters( 'qwery_filter_condition_for_load_css_responsive', $condition, $slug );
	}
}

// Return maximum media slug for all responsive css-files
if ( ! function_exists( 'qwery_media_for_load_css_responsive_callback' ) ) {
	add_filter( 'qwery_filter_media_for_load_css_responsive', 'qwery_media_for_load_css_responsive_callback', 10, 2 );
	function qwery_media_for_load_css_responsive_callback( $media, $slug ) {
		return 'all' == $media ? 'xxl' : $media;
	}
}


//-------------------------------------------------------
//-- Theme scripts
//-------------------------------------------------------

// Load frontend scripts
if ( ! function_exists( 'qwery_wp_scripts' ) ) {
	//Handler of the add_action('wp_enqueue_scripts', 'qwery_wp_scripts', 1000);
	function qwery_wp_scripts() {
		$blog_archive = qwery_storage_get( 'blog_archive' ) === true || is_home();
		$blog_style   = qwery_get_theme_option( 'blog_style' );
		$use_masonry  = false;
		if ( strpos( $blog_style, 'blog-custom-' ) === 0 ) {
			$blog_id   = qwery_get_custom_blog_id( $blog_style );
			$blog_meta = qwery_get_custom_layout_meta( $blog_id );
			if ( ! empty( $blog_meta['scripts_required'] ) && ! qwery_is_off( $blog_meta['scripts_required'] ) ) {
				$blog_style  = $blog_meta['scripts_required'];
				$use_masonry = strpos( $blog_meta['scripts_required'], 'masonry' ) !== false;
			}
		} else {
			$blog_parts  = explode( '_', $blog_style );
			$blog_style  = $blog_parts[0];
			$use_masonry = qwery_is_blog_style_use_masonry( $blog_style );
		}

		// Superfish Menu
		// Attention! To prevent duplicate this script in the plugin and in the menu, don't merge it!
		wp_enqueue_script( 'superfish', qwery_get_file_url( 'js/superfish/superfish.min.js' ), array( 'jquery' ), null, true );

		// Background video
		$header_video = qwery_get_header_video();
		if ( ! empty( $header_video ) && ! qwery_is_inherit( $header_video ) ) {
			if ( qwery_is_youtube_url( $header_video ) ) {
				wp_enqueue_script( 'jquery-tubular', qwery_get_file_url( 'js/tubular/jquery.tubular.js' ), array( 'jquery' ), null, true );
			} else {
				wp_enqueue_script( 'bideo', qwery_get_file_url( 'js/bideo/bideo.js' ), array(), null, true );
			}
		}

		// Merged scripts
		if ( qwery_is_off( qwery_get_theme_option( 'debug_mode' ) ) ) {
			wp_enqueue_script( 'qwery-init', qwery_get_file_url( 'js/__scripts' . ( qwery_is_preview() || ! qwery_optimize_css_and_js_loading() ? '-full' : '' ) . '.js' ), apply_filters( 'qwery_filter_script_deps', array( 'jquery' ) ), null, true );
		} else {
			// Skip link focus
			wp_enqueue_script( 'skip-link-focus-fix', qwery_get_file_url( 'js/skip-link-focus-fix/skip-link-focus-fix.js' ), null, true );
			// Theme scripts
			wp_enqueue_script( 'qwery-utils', qwery_get_file_url( 'js/utils.js' ), array( 'jquery' ), null, true );
			wp_enqueue_script( 'qwery-init', qwery_get_file_url( 'js/init.js' ), array( 'jquery' ), null, true );
		}

		// Load scripts for smooth parallax animation
		if ( qwery_is_singular( 'post' ) && qwery_get_theme_option( 'single_parallax' ) != 0 ) {
			qwery_load_parallax_scripts();
		}

		// Load masonry scripts
		if ( ( $blog_archive && $use_masonry ) || ( qwery_is_singular( 'post' ) && str_replace( 'post-format-', '', get_post_format() ) == 'gallery' ) ) {
			qwery_load_masonry_scripts();
		}

		// Load tabs to show filters
		if ( $blog_archive && ! is_customize_preview() && ! qwery_is_off( qwery_get_theme_option( 'show_filters' ) ) ) {
			wp_enqueue_script( 'jquery-ui-tabs', false, array( 'jquery', 'jquery-ui-core' ), null, true );
		}

		// Comments
		if ( qwery_is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Media elements library
		if ( qwery_get_theme_setting( 'use_mediaelements' ) ) {
			wp_enqueue_style( 'wp-mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );
		}
	}
}


// Add variables to the scripts in the frontend
if ( ! function_exists( 'qwery_localize_scripts' ) ) {
	//Handler of the add_action('wp_footer', 'qwery_localize_scripts');
	function qwery_localize_scripts() {

		$video = qwery_get_header_video();

		wp_localize_script( 'qwery-init', 'QWERY_STORAGE', apply_filters( 'qwery_filter_localize_script', array(
			// AJAX parameters
			'ajax_url'            => esc_url( admin_url( 'admin-ajax.php' ) ),
			'ajax_nonce'          => esc_attr( wp_create_nonce( admin_url( 'admin-ajax.php' ) ) ),

			// Site base url
			'site_url'            => esc_url( get_home_url() ),
			'theme_url'           => QWERY_THEME_URL,

			// Site color scheme
			'site_scheme'         => sprintf( 'scheme_%s', qwery_get_theme_option( 'color_scheme' ) ),

			// User logged in
			'user_logged_in'      => is_user_logged_in() ? true : false,

			// Window width to switch the site header to the mobile layout
			'mobile_layout_width' => 768,
			'mobile_device'       => wp_is_mobile(),

			// Mobile breakpoints for JS (if window width less then)
			'mobile_breakpoint_underpanels_off' => 768,
			'mobile_breakpoint_fullheight_off' => 1025,

			// Sidemenu options
			'menu_side_stretch'   => (int) qwery_get_theme_option( 'menu_side_stretch' ) > 0,
			'menu_side_icons'     => (int) qwery_get_theme_option( 'menu_side_icons' ) > 0,

			// Video background
			'background_video'    => qwery_is_from_uploads( $video ) ? $video : '',

			// Video and Audio tag wrapper
			'use_mediaelements'   => qwery_get_theme_setting( 'use_mediaelements' ) ? true : false,

			// Resize video and iframe
			'resize_tag_video'    => false,
			'resize_tag_iframe'   => true,

			// Allow open full post in the blog
			'open_full_post'      => (int) qwery_get_theme_option( 'open_full_post_in_blog' ) > 0,

			// Which block to load in the single posts
			'which_block_load'    => qwery_get_theme_option( 'posts_navigation_scroll_which_block' ),

			// Current mode
			'admin_mode'          => false,

			// Strings for translation
			'msg_ajax_error'      => esc_html__( 'Invalid server answer!', 'qwery' ),
			'msg_i_agree_error'   => esc_html__( 'Please accept the terms of our Privacy Policy.', 'qwery' ),
		) ) );
	}
}

// Enqueue masonry scripts
if ( ! function_exists( 'qwery_load_masonry_scripts' ) ) {
	function qwery_load_masonry_scripts() {
		static $once = true;
		if ( $once ) {
			$once = false;
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'masonry' );
		}
	}
}


// Enqueue parallax scripts
if ( ! function_exists( 'qwery_load_parallax_scripts' ) ) {
	function qwery_load_parallax_scripts() {
		if ( function_exists( 'trx_addons_enqueue_parallax' ) ) {
			trx_addons_enqueue_parallax();
		}
	}
}

// Enqueue specific styles and scripts for blog style
if ( ! function_exists( 'qwery_load_specific_scripts' ) ) {
	add_filter( 'qwery_filter_enqueue_blog_scripts', 'qwery_load_specific_scripts', 10, 5 );
	function qwery_load_specific_scripts( $load, $blog_style, $script_slug, $list, $responsive ) {
		if ( 'masonry' == $script_slug && false === $list ) { // if list === false - called from enqueue_scripts, true - called from merge_script
			qwery_load_masonry_scripts();
			$load = false;
		}
		return $load;
	}
}


//-------------------------------------------------------
//-- Head, body and footer
//-------------------------------------------------------

//  Add meta tags in the header for frontend
if ( ! function_exists( 'qwery_wp_head' ) ) {
	//Handler of the add_action('wp_head',	'qwery_wp_head', 1);
	function qwery_wp_head() {
		// Add ', maximum-scale=1' to the content of the viewport to disallow page scaling
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="format-detection" content="telephone=no">
		<link rel="profile" href="//gmpg.org/xfn/11">
		<?php
		if ( qwery_is_singular() && pings_open() ) {
			?>
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
			<?php
		}
	}
}

// Add theme specified classes to the body
if ( ! function_exists( 'qwery_add_body_classes' ) ) {
	//Handler of the add_filter( 'body_class', 'qwery_add_body_classes' );
	function qwery_add_body_classes( $classes ) {

		$classes[] = 'scheme_' . esc_attr( qwery_get_theme_option( 'color_scheme' ) );

		if ( is_customize_preview() ) {
			$classes[] = 'customize_preview';
		}

		$blog_mode = qwery_storage_get( 'blog_mode' );
		$classes[] = 'blog_mode_' . esc_attr( $blog_mode );
		$classes[] = 'body_style_' . esc_attr( qwery_get_theme_option( 'body_style' ) );

		if ( in_array( $blog_mode, array( 'post', 'page' ) ) || apply_filters( 'qwery_filter_single_post_header', qwery_is_singular( 'post' ) ) ) {
			$classes[] = 'is_single';
		} else {
			$classes[] = ' is_stream';
			$classes[] = 'blog_style_' . esc_attr( qwery_get_theme_option( 'blog_style' ) );
			if ( qwery_storage_get( 'blog_template' ) > 0 ) {
				$classes[] = 'blog_template';
			}
		}

		if ( apply_filters( 'qwery_filter_single_post_header', qwery_is_singular( 'post' ) || qwery_is_singular( 'attachment' ) ) ) {
			$classes[] = 'single_style_' . esc_attr( qwery_get_theme_option( 'single_style' ) );
		}

		if ( qwery_sidebar_present() ) {
			$classes[] = 'sidebar_show sidebar_' . esc_attr( qwery_get_theme_option( 'sidebar_position' ) );
			$classes[] = 'sidebar_small_screen_' . esc_attr( qwery_get_theme_option( 'sidebar_position_ss' ) );
		} else {
			$expand = qwery_get_theme_option( 'expand_content' );
			// Compatibility with old versions
			if ( "={$expand}" == '=0' ) {
				$expand = 'normal';
			} else if ( "={$expand}" == '=1' ) {
				$expand = 'expand';
			}
			if ( 'narrow' == $expand && ! qwery_is_singular( apply_filters('qwery_filter_is_singular_type', array('post') ) ) ) {
				$expand = 'normal';
			}
			$classes[] = 'sidebar_hide';
			$classes[] = "{$expand}_content";
		}

		if ( qwery_is_on( qwery_get_theme_option( 'remove_margins' ) ) ) {
			$classes[] = 'remove_margins';
		}

		$bg_image = qwery_get_theme_option( 'front_page_bg_image' );
		if ( is_front_page() && ! empty( $bg_image ) && qwery_is_on( qwery_get_theme_option( 'front_page_enabled', false ) ) ) {
			$classes[] = 'with_bg_image';
		}

		$classes[] = 'trx_addons_' . esc_attr( qwery_exists_trx_addons() ? 'present' : 'absent' );

		$classes[] = 'header_type_' . esc_attr( qwery_get_theme_option( 'header_type' ) );
		$classes[] = 'header_style_' . esc_attr( 'default' == qwery_get_theme_option( 'header_type' ) ? 'header-default' : qwery_get_theme_option( 'header_style' ) );
		$header_position = qwery_get_theme_option( 'header_position' );
		if ( 'over' == $header_position && qwery_is_single() && ! has_post_thumbnail() ) {
			$header_position = 'default';
		}
		$classes[] = 'header_position_' . esc_attr( $header_position );

		$menu_side = qwery_get_theme_option( 'menu_side' );
		$classes[] = 'menu_side_' . esc_attr( $menu_side ) . ( in_array( $menu_side, array( 'left', 'right' ) ) ? ' menu_side_present' : '' );
		$classes[] = 'no_layout';

		if ( qwery_get_theme_setting( 'fixed_blocks_sticky' ) ) {
			$classes[] = 'fixed_blocks_sticky';
		}

		if ( qwery_get_theme_option( 'blog_content' ) == 'fullpost' ) {
			$classes[] = 'fullpost_exist';
		}

		return $classes;
	}
}

// Load current page/post customization (if present)
if ( ! function_exists( 'qwery_wp_footer' ) ) {
	//Handler of the add_action('wp_footer', 'qwery_wp_footer');
	//and add_action('admin_footer', 'qwery_wp_footer');
	function qwery_wp_footer() {
		// Add header zoom
		$header_zoom = max( 0.2, min( 2, (float) qwery_get_theme_option( 'header_zoom' ) ) );
		if ( 1 != $header_zoom ) {
			qwery_add_inline_css( ".sc_layouts_title_title{font-size:{$header_zoom}em}" );
		}
		// Add logo zoom
		$logo_zoom = max( 0.2, min( 2, (float) qwery_get_theme_option( 'logo_zoom' ) ) );
		if ( 1 != $logo_zoom ) {
			qwery_add_inline_css( ".custom-logo-link,.sc_layouts_logo{font-size:{$logo_zoom}em}" );
		}
		// Put inline styles to the output
		$css = qwery_get_inline_css();
		if ( ! empty( $css ) ) {
			wp_enqueue_style( 'qwery-inline-styles', qwery_get_file_url( 'css/__inline.css' ), array(), null );
			wp_add_inline_style( 'qwery-inline-styles', $css );
		}
	}
}


//-------------------------------------------------------
//-- Sidebars and widgets
//-------------------------------------------------------

// Register widgetized areas
if ( ! function_exists( 'qwery_register_sidebars' ) ) {
	// Handler of the add_action('widgets_init', 'qwery_register_sidebars');
	function qwery_register_sidebars() {
		$sidebars = qwery_get_sidebars();
		if ( is_array( $sidebars ) && count( $sidebars ) > 0 ) {
			$cnt = 0;
			foreach ( $sidebars as $id => $sb ) {
				$cnt++;
				register_sidebar(
					apply_filters( 'qwery_filter_register_sidebar',
						array(
							'name'          => $sb['name'],
							'description'   => $sb['description'],
							// Translators: Add the sidebar number to the id
							'id'            => ! empty( $id ) ? $id : sprintf( 'theme_sidebar_%d', $cnt),
							'before_widget' => '<aside class="widget %2$s">',	// %1$s - id, %2$s - class
							'after_widget'  => '</aside>',
							'before_title'  => '<h5 class="widget_title">',
							'after_title'   => '</h5>',
						)
					)
				);
			}
		}
	}
}

// Return theme specific widgetized areas
if ( ! function_exists( 'qwery_get_sidebars' ) ) {
	function qwery_get_sidebars() {
		$list = apply_filters(
			'qwery_filter_list_sidebars', array(
				'sidebar_widgets'       => array(
					'name'        => esc_html__( 'Sidebar Widgets', 'qwery' ),
					'description' => esc_html__( 'Widgets to be shown on the main sidebar', 'qwery' ),
				),
				'header_widgets'        => array(
					'name'        => esc_html__( 'Header Widgets', 'qwery' ),
					'description' => esc_html__( 'Widgets to be shown at the top of the page (in the page header area)', 'qwery' ),
				),
				'above_page_widgets'    => array(
					'name'        => esc_html__( 'Top Page Widgets', 'qwery' ),
					'description' => esc_html__( 'Widgets to be shown below the header, but above the content and sidebar', 'qwery' ),
				),
				'above_content_widgets' => array(
					'name'        => esc_html__( 'Above Content Widgets', 'qwery' ),
					'description' => esc_html__( 'Widgets to be shown above the content, near the sidebar', 'qwery' ),
				),
				'below_content_widgets' => array(
					'name'        => esc_html__( 'Below Content Widgets', 'qwery' ),
					'description' => esc_html__( 'Widgets to be shown below the content, near the sidebar', 'qwery' ),
				),
				'below_page_widgets'    => array(
					'name'        => esc_html__( 'Bottom Page Widgets', 'qwery' ),
					'description' => esc_html__( 'Widgets to be shown below the content and sidebar, but above the footer', 'qwery' ),
				),
				'footer_widgets'        => array(
					'name'        => esc_html__( 'Footer Widgets', 'qwery' ),
					'description' => esc_html__( 'Widgets to be shown at the bottom of the page (in the page footer area)', 'qwery' ),
				),
			)
		);
		return $list;
	}
}


//-------------------------------------------------------
//-- Theme fonts
//-------------------------------------------------------

// Return links for all theme fonts
if ( ! function_exists( 'qwery_theme_fonts_links' ) ) {
	function qwery_theme_fonts_links() {
		$links = array();

		/*
		Translators: If there are characters in your language that are not supported
		by chosen font(s), translate this to 'off'. Do not translate into your own language.
		*/
		$google_fonts_enabled = ( 'off'  !== _x( 'on', 'Google fonts: on or off', 'qwery' ) );
		$google_fonts_api     = ( 'css2' !== _x( 'css2', 'Google fonts API: css or css2', 'qwery' ) ? 'css' : 'css2' );
		$adobe_fonts_enabled  = ( 'off'  !== _x( 'on', 'Adobe fonts: on or off', 'qwery' ) );
		$custom_fonts_enabled = ( 'off'  !== _x( 'on', 'Custom fonts (included in the theme): on or off', 'qwery' ) );

		if ( ( $google_fonts_enabled || $adobe_fonts_enabled || $custom_fonts_enabled ) && ! qwery_storage_empty( 'load_fonts' ) ) {
			$load_fonts = qwery_storage_get( 'load_fonts' );
			if ( count( $load_fonts ) > 0 ) {
				$google_fonts = '';
				$adobe_fonts  = '';
				foreach ( $load_fonts as $font ) {
					$used = false;
					// Custom (in the theme folder included) font
					if ( $custom_fonts_enabled && empty( $font['styles'] ) && empty( $font['link'] ) ) {
						$slug = qwery_get_load_fonts_slug( $font['name'] );
						$url  = qwery_get_file_url( "css/font-face/{$slug}/stylesheet.css" );
						if ( ! empty( $url ) ) {
							$links[ $slug ] = $url;
							$used = true;
						}
					}
					// Adobe font
					if ( $adobe_fonts_enabled && ! empty( $font['link'] ) ) {
						if ( ! in_array( $font['link'], $links ) ) {
							$slug = qwery_get_load_fonts_slug( $font['name'] );
							$links[ $slug ] = $font['link'];
						}
						$used = true;
					}
					// Google font
					if ( $google_fonts_enabled && ! $used ) {
						$google_fonts .= ( $google_fonts
											? ( 'css2' == $google_fonts_api
												? '&family='
												: '|'			// Attention! Using '%7C' instead '|' damage loading second+ fonts
												)
											: ''
											)
										. str_replace( ' ', '+', $font['name'] )
										. ':'
										. ( empty( $font['styles'] )
											? ( 'css2' == $google_fonts_api
												? 'ital,wght@0,400;0,700;1,400;1,700'
												: '400,700,400italic,700italic'
												)
											: $font['styles']
											);
					}
				}
				if ( $google_fonts_enabled && ! empty( $google_fonts ) ) {
					$google_fonts_subset = qwery_get_theme_option( 'load_fonts_subset' );
					$links['google_fonts'] = esc_url( "https://fonts.googleapis.com/{$google_fonts_api}?family={$google_fonts}&subset={$google_fonts_subset}&display=swap" );
				}
			}
		}
		return apply_filters( 'qwery_filter_theme_fonts_links', $links );
	}
}

// Return links for WP Editor
if ( ! function_exists( 'qwery_theme_fonts_for_editor' ) ) {
	function qwery_theme_fonts_for_editor() {
		$links = array_values( qwery_theme_fonts_links() );
		if ( is_array( $links ) && count( $links ) > 0 ) {
			for ( $i = 0; $i < count( $links ); $i++ ) {
				$links[ $i ] = str_replace( ',', '%2C', $links[ $i ] );
			}
		}
		return $links;
	}
}


//-------------------------------------------------------
//-- The Excerpt
//-------------------------------------------------------
if ( ! function_exists( 'qwery_excerpt_length' ) ) {
	// Handler of the add_filter( 'excerpt_length', 'qwery_excerpt_length' );
	function qwery_excerpt_length( $length ) {
		$blog_style = explode( '_', qwery_get_theme_option( 'blog_style' ) );
		return max( 0, round( qwery_get_theme_option( 'excerpt_length' ) / ( in_array( $blog_style[0], array( 'classic', 'masonry', 'portfolio' ) ) ? 2 : 1 ) ) );
	}
}

if ( ! function_exists( 'qwery_excerpt_more' ) ) {
	// Handler of the add_filter( 'excerpt_more', 'qwery_excerpt_more' );
	function qwery_excerpt_more( $more ) {
		return '&hellip;';
	}
}


//-------------------------------------------------------
//-- Comments
//-------------------------------------------------------

// Comment form fields order
if ( ! function_exists( 'qwery_comment_form_fields' ) ) {
	// Handler of the add_filter('comment_form_fields', 'qwery_comment_form_fields');
	function qwery_comment_form_fields( $comment_fields ) {
		if ( qwery_get_theme_setting( 'comment_after_name' ) ) {
			$keys = array_keys( $comment_fields );
			if ( 'comment' == $keys[0] ) {
				$comment_fields['comment'] = array_shift( $comment_fields );
			}
		}
		return $comment_fields;
	}
}

// Add checkbox with "I agree ..."
if ( ! function_exists( 'qwery_comment_form_agree' ) ) {
	// Handler of the add_filter('comment_form_fields', 'qwery_comment_form_agree', 11);
	function qwery_comment_form_agree( $comment_fields ) {
		$privacy_text = qwery_get_privacy_text();
		if ( ! empty( $privacy_text )
			&& ( ! function_exists( 'qwery_exists_gdpr_framework' ) || ! qwery_exists_gdpr_framework() )
			&& ( ! function_exists( 'qwery_exists_wp_gdpr_compliance' ) || ! qwery_exists_wp_gdpr_compliance() )
		) {
			$comment_fields['i_agree_privacy_policy'] = qwery_single_comments_field(
				array(
					'form_style'        => 'default',
					'field_type'        => 'checkbox',
					'field_req'         => '',
					'field_icon'        => '',
					'field_value'       => '1',
					'field_name'        => 'i_agree_privacy_policy',
					'field_title'       => $privacy_text,
				)
			);
		}
		return $comment_fields;
	}
}



//-------------------------------------------------------
//-- Thumb sizes
//-------------------------------------------------------
if ( ! function_exists( 'qwery_theme_thumbs_sizes' ) ) {
	//Handler of the add_filter( 'image_size_names_choose', 'qwery_theme_thumbs_sizes' );
	function qwery_theme_thumbs_sizes( $sizes ) {
		$thumb_sizes = qwery_storage_get( 'theme_thumbs' );
		$mult        = qwery_get_theme_option( 'retina_ready', 1 );
		foreach ( $thumb_sizes as $k => $v ) {
			$sizes[ $k ] = $v['title'];
			if ( $mult > 1 ) {
				$sizes[ $k . '-@retina' ] = $v['title'] . ' ' . esc_html__( '@2x', 'qwery' );
			}
		}
		return $sizes;
	}
}



//-------------------------------------------------------
//-- Include theme (or child) PHP-files
//-------------------------------------------------------

require_once QWERY_THEME_DIR . 'includes/utils.php';
require_once QWERY_THEME_DIR . 'includes/storage.php';

require_once QWERY_THEME_DIR . 'includes/lists.php';
require_once QWERY_THEME_DIR . 'includes/wp.php';

if ( is_admin() ) {
	require_once QWERY_THEME_DIR . 'includes/tgmpa/class-tgm-plugin-activation.php';
	require_once QWERY_THEME_DIR . 'includes/admin.php';
}

require_once QWERY_THEME_DIR . 'theme-options/theme-customizer.php';

require_once QWERY_THEME_DIR . 'front-page/front-page-options.php';

// Theme skins support
if ( defined( 'QWERY_ALLOW_SKINS' ) && QWERY_ALLOW_SKINS && file_exists( QWERY_THEME_DIR . 'skins/skins.php' ) ) {
	require_once QWERY_THEME_DIR . 'skins/skins.php';
}

// Load the following files after the skins to allow substitution of files from the skins folder
require_once qwery_get_file_dir( 'theme-specific/theme-tags.php' );                     // Substitution from skin is disallowed
require_once qwery_get_file_dir( 'theme-specific/theme-about/theme-about.php' );        // Substitution from skin is disallowed

// Free themes support
if ( QWERY_THEME_FREE ) {
	require_once qwery_get_file_dir( 'theme-specific/theme-about/theme-upgrade.php' );
}

require_once qwery_get_file_dir( 'theme-specific/theme-hovers/theme-hovers.php' );      // Substitution from skin is allowed

// Plugins support
$qwery_required_plugins = qwery_storage_get( 'required_plugins' );
if ( is_array( $qwery_required_plugins ) ) {
	foreach ( $qwery_required_plugins as $qwery_plugin_slug => $qwery_plugin_data ) {
		$qwery_plugin_slug = qwery_esc( $qwery_plugin_slug );
		$qwery_plugin_path = qwery_get_file_dir( sprintf( 'plugins/%1$s/%1$s.php', $qwery_plugin_slug ) );
		if ( ! empty( $qwery_plugin_path ) ) {
			require_once $qwery_plugin_path;
		}
	}
}
