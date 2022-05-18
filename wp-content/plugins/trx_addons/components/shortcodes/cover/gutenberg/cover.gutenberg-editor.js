(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Cover
	blocks.registerBlockType(
		'trx-addons/cover',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Cover link' ),
			description: i18n.__( "Add a cover link" ),
			icon: 'external',
			category: 'trx-addons-blocks',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					place: {
						type: 'string',
						default: 'row'
					},
					url: {
						type: 'string',
						default: ''
					},
					// Reload block - hidden option
					reload: {
						type: 'string'
					}
				},
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/cover' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'render_button': true,
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Layout
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select shortcodes's layout" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_cover'] )
								},
								// Place
								{
									'name': 'place',
									'title': i18n.__( 'Place' ),
									'descr': i18n.__( "Which object should the link overlap?" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_cover_places'] )
								},
								// URL to navigate
								{
									'name': 'url',
									'title': i18n.__( 'URL' ),
									'descr': i18n.__( "URL to navigate" ),
									'type': 'text',
								}
							], 'trx-addons/cover', props ), props )
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
			},
		},
		'trx-addons/cover'
	) );

})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
