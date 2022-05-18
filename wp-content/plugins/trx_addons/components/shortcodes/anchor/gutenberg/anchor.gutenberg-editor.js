(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Anchor
	blocks.registerBlockType(
		'trx-addons/anchor',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Anchor' ),
			description: i18n.__( "Insert anchor for the inner page navigation" ),
			icon: 'sticky',
			category: 'trx-addons-blocks',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', {
				id: {
					type: 'string',
					default: ''
				},
				title: {
					type: 'string',
					default: i18n.__( 'Anchor' )
				},
				url: {
					type: 'string',
					default: ''
				},
				icon: {
					type: 'string',
					default: ''
				},
				className: {
					type: 'string',
					default: ''
				}
			}, 'trx-addons/anchor' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Anchor ID
								{
									'name': 'id',
									'title': i18n.__( 'Anchor ID' ),
									'descr': i18n.__( "ID of this anchor" ),
									'type': 'text',
								},
								// Title
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'descr': i18n.__( "Anchor title" ),
									'type': 'text',
								},
								// URL to navigate
								{
									'name': 'url',
									'title': i18n.__( 'URL to navigate' ),
									'descr': i18n.__( "URL to navigate. If empty - use id to create anchor" ),
									'type': 'text',
								},
								// Icon
								{
									'name': 'icon',
									'title': i18n.__( 'Icon' ),
									'descr': i18n.__( "Select icon from library" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_option_icons_classes()
								}
							], 'trx-addons/anchor', props ), props )
						)
					}, props
				);
			},
			save: function(props) {
				return el( '', null );
			},
		},
		'trx-addons/anchor'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
