(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;
	// Register Block - Logo
	blocks.registerBlockType(
		'trx-addons/layouts-logo',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Logo' ),
			description: i18n.__( 'Insert the site logo to the custom layout' ),
			icon: 'admin-appearance',
			category: 'trx-addons-layouts',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					logo_height: {
						type: 'string',
						default: ''
					},
					logo: {
						type: 'number',
						default: 0
					},
					logo_url: {
						type: 'string',
						default: ''
					},
					logo_retina: {
						type: 'number',
						default: 0
					},
					logo_retina_url: {
						type: 'string',
						default: ''
					},
					logo_text: {
						type: 'string',
						default: ''
					},
					logo_slogan: {
						type: 'string',
						default: ''
					}
				},
				trx_addons_gutenberg_get_param_hide(),
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/layouts-logo' ),
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
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_logo'] ),
								},
								// Max height
								{
									'name': 'logo_height',
									'title': i18n.__( 'Max height' ),
									'descr': i18n.__( "Max height of the logo image. If empty - theme default value is used" ),
									'type': 'text',
								},
								// Logo
								{
									'name': 'logo',
									'name_url': 'logo_url',
									'title': i18n.__( 'Logo' ),
									'descr': i18n.__( "Select or upload image for site's logo. If empty - theme-specific logo is used" ),
									'type': 'image',
								},
								// Logo Retina
								{
									'name': 'logo_retina',
									'name_url': 'logo_retina_url',
									'title': i18n.__( 'Logo Retin' ),
									'descr': i18n.__( "Select or upload image for site's logo on the Retina displays" ),
									'type': 'image',
								},
								// Logo text
								{
									'name': 'logo_text',
									'title': i18n.__( 'Logo text' ),
									'descr': i18n.__( "Site name (used as logo if image is empty or as alt text if image is selected). If not specified - use blog name" ),
									'type': 'text',
								},
								// Logo slogan
								{
									'name': 'logo_slogan',
									'title': i18n.__( 'Logo slogan' ),
									'descr': i18n.__( "Slogan or description below site name (used if logo is empty). If not specified - use blog description" ),
									'type': 'textarea',
								}
							], 'trx-addons/layouts-logo', props ), props )
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
		'trx-addons/layouts-logo'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );