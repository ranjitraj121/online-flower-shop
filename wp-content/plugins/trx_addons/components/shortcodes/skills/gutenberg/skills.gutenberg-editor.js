(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Skills
	blocks.registerBlockType(
		'trx-addons/skills',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Skills' ),
			description: i18n.__( "Skill counters and pie charts" ),
			icon: 'awards',
			category: 'trx-addons-blocks',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'counter'
					},
					style: {
						type: 'string',
						default: 'counter'
					},
					cutout: {
						type: 'number',
						default: 92
					},
					compact: {
						type: 'boolean',
						default: false
					},
					color: {
						type: 'string',
						default: ''
					},
					icon_color: {
						type: 'string',
						default: ''
					},
					item_title_color: {
						type: 'string',
						default: ''
					},
					back_color: {
						type: 'string',
						default: ''
					},
					border_color: {
						type: 'string',
						default: ''
					},
					max: {
						type: 'number',
						default: 100
					},
					columns: {
						type: 'number',
						default: 1
					},
					values: {
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
			), 'trx-addons/skills' ),
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
									'descr': i18n.__( "Select shortcode's layout" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_skills'] )
								},
								// Style
								{
									'name': 'style',
									'title': i18n.__( 'Style' ),
									'descr': i18n.__( "Select counter's style" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_skills_counter_styles'] )
								},
								// Icon position
								{
									'name': 'icon_position',
									'title': i18n.__( 'Icon position' ),
									'descr': i18n.__( "Select an icon's position" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_skills_counter_icon_positions'] )
								},
								// Cutout
								{
									'name': 'cutout',
									'title': i18n.__( 'Cutout' ),
									'descr': i18n.__( "Specify the pie cutout radius. Border width = 100% - cutout value." ),
									'type': 'number',
									'min': 0,
									'max': 100,
									'dependency': {
										'type': ['pie']
									}
								},
								// Compact pie
								{
									'name': 'compact',
									'title': i18n.__( 'Compact pie' ),
									'descr': i18n.__( "Show all values in one pie or each value in the single pie" ),
									'type': 'boolean',
									'dependency': {
										'type': ['pie']
									}
								},
								// Icon color
								{
									'name': 'icon_color',
									'title': i18n.__( 'Icon color' ),
									'descr': i18n.__( "Select custom color for item icons" ),
									'type': 'color',
								},
								// Value color
								{
									'name': 'color',
									'title': i18n.__( 'Value color' ),
									'descr': i18n.__( "Select custom color for item values" ),
									'type': 'color',
								},
								// Title color
								{
									'name': 'item_title_color',
									'title': i18n.__( 'Title color' ),
									'descr': i18n.__( "Select custom color for item titles" ),
									'type': 'color',
								},
								// Background color
								{
									'name': 'back_color',
									'title': i18n.__( 'Background color' ),
									'descr': i18n.__( "Select custom color for item's background" ),
									'type': 'color',
									'dependency': {
										'type': ['pie']
									}
								},
								// Border color
								{
									'name': 'border_color',
									'title': i18n.__( 'Border color' ),
									'descr': i18n.__( "Select custom color for item's border" ),
									'type': 'color',
									'dependency': {
										'type': ['pie']
									}
								},
								// Max. value
								{
									'name': 'max',
									'title': i18n.__( 'Max. value' ),
									'descr': i18n.__( "Enter max value for all items" ),
									'type': 'number'
								},
								// Columns
								{
									'name': 'columns',
									'title': i18n.__( 'Columns' ),
									'descr': i18n.__( "Specify the number of columns. If left empty or assigned the value '0' - auto detect by the number of items." ),
									'type': 'number'
								}
							], 'trx-addons/skills', props ), props )
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
				props.attributes.values = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
			},
		},
		'trx-addons/skills'
	) );

	// Register block Skills Item
	blocks.registerBlockType(
		'trx-addons/skills-item',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Skills Item' ),
			description: i18n.__( "Specify values for each counter" ),
			icon: 'awards',
			category: 'trx-addons-blocks',
			parent: ['trx-addons/skills'],
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', {
				icon: {
					type: 'string',
					default: ''
				},
				icon_color: {
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
				value: {
					type: 'number',
					default: 0
				},
				color: {
					type: 'string',
					default: ''
				},
				title: {
					type: 'string',
					default: i18n.__( 'One' )
				},
				item_title_color: {
					type: 'string',
					default: ''
				},
				className: {
					type: 'string',
					default: ''
				}
			}, 'trx-addons/skills-item' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'title': i18n.__( 'Skills item' ) + (props.attributes.title ? ': ' + props.attributes.title : ''),
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Icon
								{
									'name': 'icon',
									'title': i18n.__( 'Icon' ),
									'descr': '',
									'type': 'select',
									'options': trx_addons_gutenberg_get_option_icons_classes()
								},
								// Char
								{
									'name': 'char',
									'title': i18n.__( 'or character' ),
									'descr': '',
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
									'descr': '',
									'type': 'image',
									'dependency': {
										'icon': ['', 'none'],
										'char': ''
									}
								},
								// Icon color
								{
									'name': 'icon_color',
									'title': i18n.__( 'Icon color' ),
									'descr': '',
									'type': 'color'
								},
								// Value
								{
									'name': 'value',
									'title': i18n.__( 'Value' ),
									'descr': '',
									'type': 'number',
									'min': 0
								},
								// Color
								{
									'name': 'color',
									'title': i18n.__( 'Value color' ),
									'descr': '',
									'type': 'color'
								},
								// Title
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'descr': '',
									'type': 'text'
								},
								// Title color
								{
									'name': 'item_title_color',
									'title': i18n.__( 'Title color' ),
									'descr': '',
									'type': 'color'
								},
							], 'trx-addons/skills-item', props ), props )
						)
					}, props
				);
			},
			save: function(props) {
				return el( '', null );
			}
		},
		'trx-addons/skills-item'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
