<?php
/**
 * The Front Page template file.
 *
 * @package QWERY
 * @since QWERY 1.0.31
 */

get_header();

// If front-page is a static page
if ( get_option( 'show_on_front' ) == 'page' ) {

	// If Front Page Builder is enabled - display sections
	if ( qwery_is_on( qwery_get_theme_option( 'front_page_enabled', false ) ) ) {

		if ( have_posts() ) {
			the_post();
		}

		$qwery_sections = qwery_array_get_keys_by_value( qwery_get_theme_option( 'front_page_sections' ) );
		if ( is_array( $qwery_sections ) ) {
			foreach ( $qwery_sections as $qwery_section ) {
				get_template_part( apply_filters( 'qwery_filter_get_template_part', 'front-page/section', $qwery_section ), $qwery_section );
			}
		}

		// Else if this page is blog archive
	} elseif ( is_page_template( 'blog.php' ) ) {
		get_template_part( apply_filters( 'qwery_filter_get_template_part', 'blog' ) );

		// Else - display native page content
	} else {
		get_template_part( apply_filters( 'qwery_filter_get_template_part', 'page' ) );
	}

	// Else get index template to show posts
} else {
	get_template_part( apply_filters( 'qwery_filter_get_template_part', 'index' ) );
}

get_footer();
