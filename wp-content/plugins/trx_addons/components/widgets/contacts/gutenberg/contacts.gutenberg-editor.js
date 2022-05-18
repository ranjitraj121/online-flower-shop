(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Contacts
	blocks.registerBlockType(
		'trx-addons/contacts',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Widget: Contacts' ),
			description: i18n.__( "Insert widget with logo, short description and contacts" ),
			icon: 'admin-home',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					title: {
						type: 'string',
						default: i18n.__( 'Contacts' )
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
					description: {
						type: 'string',
						default: ''
					},
					map: {
						type: 'boolean',
						default: false
					},
					map_height: {
						type: 'number',
						default: 140
					},
					map_position: {
						type: 'string',
						default: 'top'
					},
					address: {
						type: 'string',
						default: ''
					},
					phone: {
						type: 'string',
						default: ''
					},
					email: {
						type: 'string',
						default: ''
					},
					columns: {
						type: 'boolean',
						default: false
					},
					socials: {
						type: 'boolean',
						default: false
					}
				},
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/contacts' ),
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
								// Logo
								{
									'name': 'logo',
									'name_url': 'logo_url',
									'title': i18n.__( 'Logo' ),
									'descr': i18n.__( "Select or upload image or write URL from other site for site's logo." ),
									'type': 'image',
								},
								// Logo Retina
								{
									'name': 'logo_retina',
									'name_url': 'logo_retina_url',
									'title': i18n.__( 'Logo Retina' ),
									'descr': i18n.__( "Select or upload image or write URL from other site: site's logo for the Retina display." ),
									'type': 'image',
								},
								// Description
								{
									'name': 'description',
									'title': i18n.__( 'Description' ),
									'descr': i18n.__( "Short description about user. If empty - get description of the first registered blog user" ),
									'type': 'textarea',
								},
								// Address
								{
									'name': 'address',
									'title': i18n.__( 'Address' ),
									'descr': i18n.__( "Address string. Use '|' to split this string on two parts" ),
									'type': 'text',
								},
								// Phone
								{
									'name': 'phone',
									'title': i18n.__( 'Phone' ),
									'descr': i18n.__( "Your phone" ),
									'type': 'text',
								},
								// E-mail
								{
									'name': 'email',
									'title': i18n.__( 'E-mail' ),
									'descr': i18n.__( "Your e-mail address" ),
									'type': 'text',
								},
								// Break into columns
								{
									'name': 'columns',
									'title': i18n.__( 'Break into columns' ),
									'descr': i18n.__( "Break contact information into two columns with the address being displayed on the left hand side and phone/email - on the right." ),
									'type': 'boolean',
								},
								// Show map
								{
									'name': 'map',
									'title': i18n.__( 'Show map' ),
									'descr': i18n.__( "Do you want to display map with address above" ),
									'type': 'boolean',
								},
								// Map height
								{
									'name': 'map_height',
									'title': i18n.__( 'Map height' ),
									'descr': i18n.__( "Height of the map" ),
									'type': 'number',
									'min': 100,
									'dependency': {
										'map': [true]
									}
								},
								// Map position
								{
									'name': 'map_position',
									'title': i18n.__( 'Map position' ),
									'descr': i18n.__( "Select position of the map" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists({
										'top': i18n.__( 'Top' ),
										'left': i18n.__( 'Left' ),
										'right': i18n.__( 'Right' ),
									}),
									'dependency': {
										'map': [true]
									}
								},
								// Show Social Icons
								{
									'name': 'socials',
									'title': i18n.__( 'Show Social Icons' ),
									'descr': i18n.__( "Do you want to display icons with links on your profiles in the Social networks?" ),
									'type': 'boolean'
								}
							], 'trx-addons/contacts', props ), props )
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
		'trx-addons/contacts'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
