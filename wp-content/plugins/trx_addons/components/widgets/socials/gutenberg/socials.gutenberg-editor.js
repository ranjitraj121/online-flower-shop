(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Socials
	blocks.registerBlockType(
		'trx-addons/widget-socials',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Widget: Socials' ),
			description: i18n.__( "Socials - show links to the profiles in your favorites social networks" ),
			icon: 'facebook-alt',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					title: {
						type: 'string',
						default: ''
					},
					description: {
						type: 'string',
						default: ''
					},
					align: {
						type: 'string',
						default: 'left'
					},
					type: {
						type: 'string',
						default: 'socials'
					}
				},
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/widget-socials' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Widget title
								{
									'name': 'title',
									'title': i18n.__( 'Widget title' ),
									'descr': i18n.__( "Title of the widget" ),
									'type': 'text',
								},
								// Type
								{
									'name': 'type',
									'title': i18n.__( 'Icons type' ),
									'descr': i18n.__( "Select type of icons: links to the social profiles or share links" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_socials_types'] )
								},
								// Align
								{
									'name': 'align',
									'title': i18n.__( 'Align' ),
									'descr': i18n.__( "Select alignment of this item" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] )
								},
								// Description
								{
									'name': 'description',
									'title': i18n.__( 'Description' ),
									'descr': i18n.__( "Short description about user" ),
									'type': 'textarea',
								}
							], 'trx-addons/widget-socials', props ), props )
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
		'trx-addons/widget-socials'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
