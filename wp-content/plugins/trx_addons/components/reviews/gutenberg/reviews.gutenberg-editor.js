(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Dishes
	blocks.registerBlockType(
		'trx-addons/reviews',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Reviews' ),
			icon: 'carrot',
			category: 'trx-addons-blocks',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'short'
					},
					align: {
						type: 'string',
						default: 'right'
					}
				},
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/reviews' ),
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
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['trx_sc_reviews'] )
								},
								// Alignment
								{
									'name': 'align',
									'title': i18n.__( 'Alignment' ),
									'descr': i18n.__( "Alignment of the block in the content" ),
									'dependency': {
										'type': ['short']
									},
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_floats'] )
								}
							], 'trx-addons/reviews', props ), props )
						),
						'additional_params': el(
							'div', {},
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
		'trx-addons/reviews'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
