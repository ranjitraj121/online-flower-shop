(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Icons
	blocks.registerBlockType(
		'trx-addons/icons',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Icons' ),
			description: i18n.__( "Insert icons or images with title and description" ),
			icon: 'carrot',
			category: 'trx-addons-blocks',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					align: {
						type: 'string',
						default: 'center'
					},
					size: {
						type: 'string',
						default: 'medium'
					},
					color: {
						type: 'string',
						default: ''
					},
					item_title_color: {
						type: 'string',
						default: ''
					},
					item_text_color: {
						type: 'string',
						default: ''
					},
					columns: {
						type: 'number',
						default: 1
					},
					icons_animation: {
						type: 'boolean',
						default: false
					},
					icons: {
						type: 'string',
						default: ''
					},
					// Reload block - hidden option
					reload: {
						type: 'string'
					}
				},
				trx_addons_gutenberg_get_param_slider(),
				trx_addons_gutenberg_get_param_title(),
				trx_addons_gutenberg_get_param_button(),
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/icons' ),
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
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_icons'] )
								},
								// Align
								{
									'name': 'align',
									'title': i18n.__( 'Align' ),
									'descr': i18n.__( "Select alignment of this item" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] )
								},
								// Icon size
								{
									'name': 'size',
									'title': i18n.__( 'Icon size' ),
									'descr': i18n.__( "Select icon's size" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_icon_sizes'] )
								},
								// Icon color
								{
									'name': 'color',
									'title': i18n.__( 'Icon color' ),
									'descr': i18n.__( "Select custom color for item icons" ),
									'type': 'color',
								},
								// Title color
								{
									'name': 'item_title_color',
									'title': i18n.__( 'Title color' ),
									'descr': i18n.__( "Select custom color for item titles" ),
									'type': 'color',
								},
								// Text (description) color
								{
									'name': 'item_text_color',
									'title': i18n.__( 'Text color' ),
									'descr': i18n.__( "Select custom color for item descriptions" ),
									'type': 'color',
								},
								// Columns
								{
									'name': 'columns',
									'title': i18n.__( 'Columns' ),
									'descr': i18n.__( "Specify the number of columns. If left empty or assigned the value '0' - auto detect by the number of items." ),
									'type': 'number',
									'min': 1,
									'max': 4
								},
								// Animation
								{
									'name': 'icons_animation',
									'title': i18n.__( 'Animation' ),
									'descr': i18n.__( "Toggle on if you want to animate icons. Attention! Animation is enabled only if there is an .SVG  icon in your theme with the same name as the selected icon." ),
									'type': 'boolean'
								}
							], 'trx-addons/icons', props ), props )
						),
						'additional_params': el(
							'div', {},
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
				// Get child block values of attributes
				props.attributes.icons = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
			},
		},
		'trx-addons/icons'
	) );

	// Register block Icons Item
	blocks.registerBlockType(
		'trx-addons/icons-item',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Icons Item' ),
			description: i18n.__( "elect icons, specify title and/or description for each item" ),
			icon: 'carrot',
			category: 'trx-addons-blocks',
			parent: ['trx-addons/icons'],
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', {
				title: {
					type: 'string',
					default: i18n.__( 'One' )
				},
				link: {
					type: 'string',
					default: ''
				},
				description: {
					type: 'string',
					default: ''
				},
				color: {
					type: 'string',
					default: ''
				},
				item_title_color: {
					type: 'string',
					default: ''
				},
				item_text_color: {
					type: 'string',
					default: ''
				},
				char: {
					type: 'string',
					default: ''
				},
				image: {
					type: 'number',
					default: 0
				},
				image_url: {
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
			}, 'trx-addons/icons-item' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'title': i18n.__( 'Icons item' ) + (props.attributes.title ? ': ' + props.attributes.title : ''),
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Icon
								{
									'name': 'icon',
									'title': i18n.__( 'Icon' ),
									'descr': i18n.__( "Select icon from library" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_option_icons_classes()
								},
								// Char
								{
									'name': 'char',
									'title': i18n.__( 'or character' ),
									'descr': i18n.__( "Single character instaed image or icon" ),
									'type': 'text',
									'dependency': {
										'icon': ['', 'none']
									}
								},
								// Image
								{
									'name': 'image',
									'name_url': 'image_url',
									'title': i18n.__( 'or image' ),
									'descr': i18n.__( "Select or upload image or specify URL from other site to use it as icon" ),
									'type': 'image',
									'dependency': {
										'icon': ['', 'none'],
										'char': ''
									}
								},
								// Icon color
								{
									'name': 'color',
									'title': i18n.__( 'Icon color' ),
									'descr': i18n.__( "Select a custom color of the icon" ),
									'type': 'color'
								},
								// Title
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'descr': i18n.__( "Enter title of the item" ),
									'type': 'text'
								},
								// Title color
								{
									'name': 'item_title_color',
									'title': i18n.__( 'Title color' ),
									'descr': i18n.__( "Select a custom color of the title" ),
									'type': 'color'
								},
								// Link
								{
									'name': 'link',
									'title': i18n.__( 'Link' ),
									'descr': i18n.__( "URL to link this block" ),
									'type': 'text'
								},
								// Description
								{
									'name': 'description',
									'title': i18n.__( 'Description' ),
									'descr': i18n.__( "Enter short description for this item" ),
									'type': 'textarea'
								},
								// Text (description) color
								{
									'name': 'item_text_color',
									'title': i18n.__( 'Description color' ),
									'descr': i18n.__( "Select a custom color of the description" ),
									'type': 'color'
								},
							], 'trx-addons/icons-item', props ), props )
						)
					}, props
				);
			},
			save: function(props) {
				return el( '', null );
			}
		},
		'trx-addons/icons-item'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
