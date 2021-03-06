(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Testimonials
	blocks.registerBlockType(
		'trx-addons/testimonials',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Testimonials' ),
			icon: 'format-status',
			category: 'trx-addons-cpt',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					rating: {
						type: 'boolean',
						default: false
					},
					use_initials: {
						type: 'boolean',
						default: false
					},
					cat: {
						type: 'string',
						default: '0'
					},
					slider_pagination_thumbs: {
						type: 'boolean',
						default: false
					}
				},
				trx_addons_gutenberg_get_param_query(),
				trx_addons_gutenberg_get_param_slider(),
				trx_addons_gutenberg_get_param_title(),
				trx_addons_gutenberg_get_param_button(),
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/testimonials' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Layout
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select shortcodes's layout" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['trx_sc_testimonials'] )
								},
								// Show rating
								{
									'name': 'rating',
									'title': i18n.__( "Show rating" ),
									'descr': i18n.__( "Display rating stars" ),
									'type': 'boolean',
								},
								// Use initials
								{
									'name': 'use_initials',
									'title': i18n.__( "Use initials" ),
									'descr': i18n.__( "If no avatar is present, the initials derived from the available username will be used." ),
									'type': 'boolean',
								},
								// Group
								{
									'name': 'cat',
									'title': i18n.__( "Group" ),
									'descr': i18n.__( "Courses group" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_testimonials_cat'] )
								},
								// Slider pagination
								{
									'name': 'slider_pagination_thumbs',
									'title': i18n.__( "Slider pagination" ),
									'descr': i18n.__( "Show thumbs as pagination bullets" ),
									'type': 'boolean',
									'dependency': {
										'slider_pagination': ['left', 'right', 'bottom']
									}
								}
							], 'trx-addons/testimonials', props ), props )
						),
						'additional_params': el(
							'div', {},
							// Query params
							trx_addons_gutenberg_add_param_query( props ),
							// Title params
							trx_addons_gutenberg_add_param_title( props, true ),
							// Slider params
							trx_addons_gutenberg_add_param_slider( props ),
							// ID, Class, CSS params
							trx_addons_gutenberg_add_param_id( props )
						)
					}, props
				);
			},
			save: function(props) {
				return el( '', null );
			}
		},
		'trx-addons/testimonials'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
