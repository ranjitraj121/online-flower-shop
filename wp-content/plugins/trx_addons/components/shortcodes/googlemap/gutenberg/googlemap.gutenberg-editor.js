(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Google Map
	blocks.registerBlockType(
		'trx-addons/googlemap',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Google Map' ),
			description: i18n.__( "Google map with custom styles and several markers" ),
			icon: 'admin-site',
			category: 'trx-addons-blocks',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					style: {
						type: 'string',
						default: 'default'
					},
					zoom: {
						type: 'string',
						default: '16'
					},
					center: {
						type: 'string',
						default: ''
					},
					width: {
						type: 'string',
						default: '100%'
					},
					height: {
						type: 'string',
						default: '350'
					},
					cluster: {
						type: 'number',
						default: ''
					},
					cluster_url: {
						type: 'string',
						default: ''
					},
					prevent_scroll: {
						type: 'boolean',
						default: false
					},
					address: {
						type: 'string',
						default: ''
					},
					markers: {
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
			), 'trx-addons/googlemap' ),
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
									'descr': i18n.__( "Select shortcodes's layout" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_googlemap'] )
								},
								// Style
								{
									'name': 'style',
									'title': i18n.__( 'Style' ),
									'descr': i18n.__( "Map's custom style" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_googlemap_styles'] )
								},
								// Zoom
								{
									'name': 'zoom',
									'title': i18n.__( 'Zoom' ),
									'descr': i18n.__( "Map zoom factor on a scale from 1 to 20. If assigned the value '0' or left empty, fit the bounds to markers." ),
									'type': 'text',
								},
								// Center
								{
									'name': 'center',
									'title': i18n.__( 'Center' ),
									'descr': i18n.__( "Comma separated coordinates of the map's center. If left empty, the coordinates of the first marker will be used." ),
									'type': 'text',
								},
								// Width
								{
									'name': 'width',
									'title': i18n.__( 'Width' ),
									'descr': i18n.__( "Width of the element" ),
									'type': 'text',
								},
								// Height
								{
									'name': 'height',
									'title': i18n.__( 'Height' ),
									'descr': i18n.__( "Height of the element" ),
									'type': 'text',
								},
								// Cluster icon
								{
									'name': 'cluster',
									'name_url': 'cluster_url',
									'title': i18n.__( 'Cluster icon' ),
									'descr': i18n.__( "Select or upload image for markers clusterer" ),
									'type': 'image'
								},
								// Prevent_scroll
								{
									'name': 'prevent_scroll',
									'title': i18n.__( 'Prevent_scroll' ),
									'descr': i18n.__( "Disallow scrolling of the map" ),
									'type': 'boolean'
								},
								// Address
								{
									'name': 'address',
									'title': i18n.__( 'Address or Lat,Lng' ),
									'descr': i18n.__( "Specify the address (or comma separated coordinates) if you don't need a unique marker, title or LatLng coordinates. Otherwise, leave this field empty and specify the markers below." ),
									'type': 'text',
								}
							], 'trx-addons/googlemap', props ), props )
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
				props.attributes.markers = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
			},
		},
		'trx-addons/googlemap'
	) );

	// Register block Markers
	blocks.registerBlockType(
		'trx-addons/googlemap-markers',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Markers' ),
			description: i18n.__( "Add markers to the map" ),
			icon: 'admin-site',
			category: 'trx-addons-blocks',
			parent: ['trx-addons/googlemap'],
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', {
				title: {
					type: 'string',
					default: i18n.__( 'One' )
				},
				address: {
					type: 'string',
					default: ''
				},
				html: {
					type: 'string',
					default: ''
				},
				icon: {
					type: 'number',
					default: ''
				},
				icon_url: {
					type: 'string',
					default: ''
				},
				icon_retina: {
					type: 'number',
					default: ''
				},
				icon_retina_url: {
					type: 'string',
					default: ''
				},
				icon_width: {
					type: 'string',
					default: ''
				},
				icon_height: {
					type: 'string',
					default: ''
				},
				animation: {
					type: 'string',
					default: ''
				},
				description: {
					type: 'string',
					default: ''
				},
				className: {
					type: 'string',
					default: ''
				}
			}, 'trx-addons/googlemap-markers' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'title': i18n.__( 'Marker' ) + (props.attributes.title ? ': ' + props.attributes.title : ''),
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Title
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'descr': i18n.__( "Title of the marker" ),
									'type': 'text'
								},
								// Address
								{
									'name': 'address',
									'title': i18n.__( 'Address or Lat,Lng' ),
									'descr': i18n.__( "Address or comma separated coorditanes of this marker" ),
									'type': 'text'
								},
								// Custom HTML code
								{
									'name': 'html',
									'title': i18n.__( 'Custom HTML' ),
									'descr': i18n.__( "Custom HTML-code of the marker" ),
									'type': 'textarea'
								},
								// Marker image
								{
									'name': 'icon',
									'name_url': 'icon_url',
									'title': i18n.__( 'Marker image' ),
									'descr': i18n.__( "Select or upload image of this marker" ),
									'type': 'image',
									'dependency': {
										'html': ['']
									}
								},
								// Marker for Retina
								{
									'name': 'icon_retina',
									'name_url': 'icon_retina_url',
									'title': i18n.__( 'Marker for Retina' ),
									'descr': i18n.__( "Select or upload image of this marker for Retina device" ),
									'type': 'image',
									'dependency': {
										'html': ['']
									}
								},
								// Width
								{
									'name': 'icon_width',
									'title': i18n.__( 'Width' ),
									'descr': i18n.__( "Width of this marker. If empty - use original size" ),
									'type': 'text',
									'dependency': {
										'html': ['']
									}
								},
								// Height
								{
									'name': 'icon_height',
									'title': i18n.__( 'Height' ),
									'descr': i18n.__( "Height of this marker. If empty - use original size" ),
									'type': 'text',
									'dependency': {
										'html': ['']
									}
								},
								// Animation
								{
									'name': 'animation',
									'title': i18n.__( 'Animation' ),
									'descr': i18n.__( "Marker's animation" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_googlemap_animations'] ),
									'dependency': {
										'html': ['']
									}
								},
								// Description
								{
									'name': 'description',
									'title': i18n.__( 'Description' ),
									'descr': i18n.__( "Description of the marker" ),
									'type': 'textarea',
									'dependency': {
										'html': ['']
									}
								}
							], 'trx-addons/googlemap-markers', props ), props )
						)
					}, props
				);
			},
			save: function(props) {
				return el( '', null );
			}
		},
		'trx-addons/googlemap-markers'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
