<?php
/**
 * Template to display a shortcode's placeholder in the Elementor preview area
 *
 * Written as a Backbone JavaScript template and used to generate the live preview.
 *
 * @package ThemeREX Addons
 * @since v2.9.0
 */
$args = get_query_var( 'trx_addons_args_sc_placeholder' );
?><#
var use_image_field = '<?php echo esc_html( $args['use_image'] ); ?>';
var use_image = use_image_field ? settings[use_image_field] != '' : true;
var image_field = '<?php echo esc_html( $args['image'] ); ?>';
var image = image_field && use_image ? settings[image_field].url  : '';
var title_field = '<?php echo esc_html( $args['title'] ); ?>';
var title = title_field ? settings[title_field] : '';
if ( ! title ) title = '<?php echo esc_html( $args['sc'] ); ?>';
#>
<div class="sc_placeholder"><#
	if ( image ) {
		#><img src="{{ image }}" /><#
	}
	#><p>{{ title }}</p>
</div>