(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Hotspot
	blocks.registerBlockType(
		'trx-addons/hotspot',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Hotspot' ),
			description: i18n.__( "Insert image with hotspots" ),
			icon: 'location-alt',
			category: 'trx-addons-blocks',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					image: {
						type: 'number',
						default: 0
					},
					image_url: {
						type: 'string',
						default: ''
					},
					image_link: {
						type: 'string',
						default: ''
					},
					spots: {
						type: 'string',
						default: ''
					},
					// Reload block - hidden option
					reload: {
						type: 'string'
					}
				},
				trx_addons_gutenberg_get_param_title(),
				trx_addons_gutenberg_get_param_button(),
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/hotspot' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'render_button': true,
						'parent': true,
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Layout
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_hotspot'] )
								},
								// Image
								{
									'name': 'image',
									'name_url': 'image_url',
									'title': i18n.__( 'Image' ),
									'type': 'image'
								},
								// Link
								{
									'name': 'image_link',
									'title': i18n.__( 'Image link' ),
									'type': 'text'
								},
							], 'trx-addons/hotspot', props ), props )
						),
						'additional_params': el(
							'div', {},
							// Title params
							trx_addons_gutenberg_add_param_title( props, true ),
							// ID, Class, CSS params
							trx_addons_gutenberg_add_param_id( props )
						)
					}, props
				);
			},
			save: function(props) {
				// Get child block values of attributes
				props.attributes.spots = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
			},
		},
		'trx-addons/hotspot'
	) );

	// Register block Hotspot Item
	blocks.registerBlockType(
		'trx-addons/hotspot-item',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Hotspot Item' ),
			description: i18n.__( "Insert a single hotspot" ),
			icon: 'sticky',
			category: 'trx-addons-blocks',
			parent: ['trx-addons/hotspot'],
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', {
				// Action Item attributes
				spot_visible: {
					type: 'boolean',
					default: true
				},
				spot_x: {
					type: 'number',
					default: 0
				},
				spot_y: {
					type: 'number',
					default: 0
				},
				spot_symbol: {
					type: 'string',
					default: 'none'
				},
				icon: {
					type: 'string',
					default: 'none'
				},
				spot_image: {
					type: 'number',
					default: 0
				},
				spot_char: {
					type: 'string',
					default: ''
				},
				spot_color: {
					type: 'string',
					default: ''
				},
				spot_bg_color: {
					type: 'string',
					default: ''
				},
				spot_sonar_color: {
					type: 'string',
					default: ''
				},
				position: {
					type: 'string',
					default: 'bc'
				},
				open: {
					type: 'boolean',
					default: true
				},
				opened: {
					type: 'boolean',
					default: false
				},
				source: {
					type: 'string',
					default: 'custom'
				},
				post: {
					type: 'number',
					default: 0
				},
				image: {
					type: 'number',
					default: 0
				},
				image_url: {
					type: 'string',
					default: ''
				},
				title: {
					type: 'string',
					default: i18n.__( 'One' )
				},
				subtitle: {
					type: 'string',
					default: ''
				},
				price: {
					type: 'string',
					default: ''
				},
				description: {
					type: 'string',
					default: ''
				},
				link: {
					type: 'string',
					default: ''
				},
				link_text: {
					type: 'string',
					default: ''
				},
				className: {
					type: 'string',
					default: ''
				}
			}, 'trx-addons/hotspot-item' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'title': i18n.__( 'Hotspot item' ) + (props.attributes.title ? ': ' + props.attributes.title : ''),
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Spot visible
								{
									'name': 'spot_visible',
									'title': i18n.__( 'Always visible' ),
									'type': 'boolean'
								},
								// X position
								{
									'name': 'spot_x',
									'title': i18n.__( 'X position (in %)' ),
									'type': 'number',
									'min': 0,
									'max': 100,
									'step': 0.1
								},
								// Y position
								{
									'name': 'spot_y',
									'title': i18n.__( 'Y position (in %)' ),
									'type': 'number',
									'min': 0,
									'max': 100,
									'step': 0.1
								},
								// Spot symbol
								{
									'name': 'spot_symbol',
									'title': i18n.__( 'Spot symbol' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_hotspot_symbols'] )
								},
								// Spot image
								{
									'name': 'spot_image',
									'name_url': 'spot_image_url',
									'title': i18n.__( 'Image' ),
									'type': 'image',
									'dependency': {
										'spot_symbol': ['image']
									}
								},
								// Spot icon
								{
									'name': 'icon',
									'title': i18n.__( 'Icon' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_option_icons_classes(),
									'dependency': {
										'spot_symbol': [ 'icon' ]
									}
								},
								// Spot caption
								{
									'name': 'spot_char',
									'title': i18n.__( 'Caption' ),
									'type': 'text',
									'dependency': {
										'spot_symbol': [ 'custom' ]
									}
								},
								// Spot color
								{
									'name': 'spot_color',
									'title': i18n.__( 'Spot color' ),
									'type': 'color',
									'dependency': {
										'spot_symbol': [ '^none' ]
									}
								},
								// Background color
								{
									'name': 'spot_bg_color',
									'title': i18n.__( 'Spot bg color' ),
									'type': 'color'
								},
								// Sonar color
								{
									'name': 'spot_sonar_color',
									'title': i18n.__( 'Spot sonar color' ),
									'type': 'color'
								},
								// Popup position
								{
									'name': 'position',
									'title': i18n.__( 'Popup position' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_positions'] )
								},
								// Popup open on click/hover
								{
									'name': 'open',
									'title': i18n.__( 'Open on click' ),
									'type': 'boolean'
								},
								// Popup opened on page load
								{
									'name': 'opened',
									'title': i18n.__( 'Open on load' ),
									'type': 'boolean'
								},
								// Source
								{
									'name': 'source',
									'title': i18n.__( 'Data source' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_hotspot_sources'] )
								},
								// Post
								{
									'name': 'post',
									'title': i18n.__( 'Data from post' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_hotspot_posts'] ),
									'dependency': {
										'source': ['post']
									}
								},
								// Image
								{
									'name': 'image',
									'name_url': 'image_url',
									'title': i18n.__( 'Image' ),
									'type': 'image',
									'dependency': {
										'source': ['custom']
									}
								},
								// Title
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'type': 'text',
									'dependency': {
										'source': ['custom']
									}
								},
								// Subtitle
								{
									'name': 'subtitle',
									'title': i18n.__( 'Subtitle' ),
									'type': 'text',
									'dependency': {
										'source': ['custom']
									}
								},
								// Price
								{
									'name': 'price',
									'title': i18n.__( 'Price' ),
									'type': 'text',
									'dependency': {
										'source': ['custom']
									}
								},
								// Description
								{
									'name': 'description',
									'title': i18n.__( 'Description' ),
									'type': 'textarea',
									'dependency': {
										'source': ['custom']
									}
								},
								// Link
								{
									'name': 'link',
									'title': i18n.__( 'Link' ),
									'type': 'text',
									'dependency': {
										'source': ['custom']
									}
								},
								// Link Text
								{
									'name': 'link_text',
									'title': i18n.__( 'Link Text' ),
									'type': 'text'
								}
							], 'trx-addons/hotspot-item', props ), props )
						)
					}, props
				);
			},
			save: function(props) {
				return el( '', null );
			}
		},
		'trx-addons/hotspot-item'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
