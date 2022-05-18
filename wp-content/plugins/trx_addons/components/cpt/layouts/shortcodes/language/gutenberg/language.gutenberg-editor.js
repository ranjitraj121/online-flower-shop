(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;
	// Register Block - Language
	blocks.registerBlockType(
		'trx-addons/layouts-language',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Language' ),
			description: i18n.__( 'Insert WPML Language Selector' ),
			icon: 'editor-bold',
			category: 'trx-addons-layouts',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					flag: {
						type: 'string',
						default: 'both'
					},
					title_link: {
						type: 'string',
						default: 'name'
					},
					title_menu: {
						type: 'string',
						default: 'name'
					}
				},
				trx_addons_gutenberg_get_param_hide(),
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/layouts-language' ),
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
									'descr': i18n.__( "Select layout's type" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_language'] ),
								},
								// Show flag
								{
									'name': 'flag',
									'title': i18n.__( 'Show flag' ),
									'descr': i18n.__( "Where do you want to show flag?" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts_language_positions'] ),
								},
								// Show link's title
								{
									'name': 'title_link',
									'title': i18n.__( "Show link's title" ),
									'descr': i18n.__( "Select link's title type" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts_language_parts'] ),
								},
								// Show menu item's title
								{
									'name': 'title_menu',
									'title': i18n.__( "Show menu item's title" ),
									'descr': i18n.__( "Select menu item's title type" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts_language_parts'] ),
								}
							], 'trx-addons/layouts-language', props ), props )
						),
						'additional_params': el(
							'div', {},
							// Hide on devices params
							trx_addons_gutenberg_add_param_hide( props ),
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
		'trx-addons/layouts-language'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
