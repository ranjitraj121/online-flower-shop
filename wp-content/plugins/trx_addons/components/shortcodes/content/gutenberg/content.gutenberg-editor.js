(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Content area
	blocks.registerBlockType(
		'trx-addons/content',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Content area' ),
			description: i18n.__( "Limit content width inside the fullwide rows" ),
			icon: 'schedule',
			category: 'trx-addons-blocks',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					size: {
						type: 'string',
						default: 'none'
					},
					paddings: {
						type: 'string',
						default: 'none'
					},
					margins: {
						type: 'string',
						default: 'none'
					},
					float: {
						type: 'string',
						default: 'none'
					},
					align: {
						type: 'string',
						default: 'none'
					},
					push: {
						type: 'string',
						default: 'none'
					},
					push_hide_on_tablet: {
						type: 'boolean',
						default: false
					},
					push_hide_on_mobile: {
						type: 'boolean',
						default: false
					},
					pull: {
						type: 'string',
						default: 'none'
					},
					pull_hide_on_tablet: {
						type: 'boolean',
						default: false
					},
					pull_hide_on_mobile: {
						type: 'boolean',
						default: false
					},
					shift_x: {
						type: 'string',
						default: 'none'
					},
					shift_y: {
						type: 'string',
						default: 'none'
					},
					number: {
						type: 'string',
						default: ''
					},
					number_position: {
						type: 'string',
						default: 'br'
					},
					number_color: {
						type: 'string',
						default: ''
					},
					extra_bg: {
						type: 'string',
						default: 'none'
					},
					extra_bg_mask: {
						type: 'string',
						default: 'none'
					},
					content: {
						type: 'string',
						default: ''
					}
				},
				trx_addons_gutenberg_get_param_title(),
				trx_addons_gutenberg_get_param_button(),
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/content' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'parent': true,
						'allowedblocks': TRX_ADDONS_STORAGE['gutenberg_allowed_blocks'],
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Layout
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select shortcodes's layout" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_content'] )
								},
								// Size
								{
									'name': 'size',
									'title': i18n.__( 'Size' ),
									'descr': i18n.__( "Select size of the block" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_content_widths'] )
								},
								// Inner paddings
								{
									'name': 'paddings',
									'title': i18n.__( 'Inner paddings' ),
									'descr': i18n.__( "Select paddings around of the inner text in the block" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_content_paddings_and_margins'] )
								},
								// Outer margin
								{
									'name': 'margins',
									'title': i18n.__( 'Outer margin' ),
									'descr': i18n.__( "Select margin around of the block" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_content_paddings_and_margins'] )
								},
								// Block alignment
								{
									'name': 'float',
									'title': i18n.__( 'Block alignment' ),
									'descr': i18n.__( "Select alignment (floating position) of the block" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] )
								},
								// Text alignment
								{
									'name': 'align',
									'title': i18n.__( 'Text alignment' ),
									'descr': i18n.__( "Select alignment of the inner text in the block" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] )
								},
								// Push block up
								{
									'name': 'push',
									'title': i18n.__( 'Push block up' ),
									'descr': i18n.__( "Push this block up, so that it partially covers the previous block" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_content_push_and_pull'] )
								},
								// On tablet
								{
									'name': 'push_hide_on_tablet',
									'title': i18n.__( 'On tablet' ),
									'descr': i18n.__( "Disable push on the tablets" ),
									'type': 'boolean',
									'dependency': {
										'push': ['tiny', 'tiny_negative', 'small', 'small_negative', 'medium', 'medium_negative', 'large', 'large_negative']
									}
								},
								// On mobile
								{
									'name': 'push_hide_on_mobile',
									'title': i18n.__( 'On mobile' ),
									'descr': i18n.__( "Disable push on the mobile" ),
									'type': 'boolean',
									'dependency': {
										'push': ['tiny', 'tiny_negative', 'small', 'small_negative', 'medium', 'medium_negative', 'large', 'large_negative']
									}
								},
								// Pull next block up
								{
									'name': 'pull',
									'title': i18n.__( 'Pull next block up' ),
									'descr': i18n.__( "Pull next block up, so that it partially covers this block" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_content_push_and_pull'] )
								},
								// On tablet
								{
									'name': 'pull_hide_on_tablet',
									'title': i18n.__( 'On tablet' ),
									'descr': i18n.__( "Disable pull on the tablets" ),
									'type': 'boolean',
									'dependency': {
										'push': ['tiny', 'tiny_negative', 'small', 'small_negative', 'medium', 'medium_negative', 'large', 'large_negative']
									}
								},
								// On mobile
								{
									'name': 'pull_hide_on_mobile',
									'title': i18n.__( 'On mobile' ),
									'descr': i18n.__( "Disable pull on the mobile" ),
									'type': 'boolean',
									'dependency': {
										'push': ['tiny', 'tiny_negative', 'small', 'small_negative', 'medium', 'medium_negative', 'large', 'large_negative']
									}
								},
								// The X-axis shift
								{
									'name': 'shift_x',
									'title': i18n.__( 'The X-axis shift' ),
									'descr': i18n.__( "Shift this block along the X-axis" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_content_shift'] )
								},
								// The Y-axis shift
								{
									'name': 'shift_y',
									'title': i18n.__( 'The Y-axis shift' ),
									'descr': i18n.__( "Shift this block along the Y-axis" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_content_shift'] )
								},
								// Number
								{
									'name': 'number',
									'title': i18n.__( 'Number' ),
									'descr': i18n.__( "Number to display in the corner of this area" ),
									'type': 'text',
								},
								// Number position
								{
									'name': 'number_position',
									'title': i18n.__( 'Number position' ),
									'descr': i18n.__( "Select position to display number" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_positions'] )
								},
								// Color of the number
								{
									'name': 'number_color',
									'title': i18n.__( 'Color of the number' ),
									'descr': i18n.__( "Select custom color of the number" ),
									'type': 'color'
								},
								// Entended background
								{
									'name': 'extra_bg',
									'title': i18n.__( 'Entended background' ),
									'descr': i18n.__( "Extend background of this block" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_content_extra_bg'] )
								},
								// Background mask
								{
									'name': 'extra_bg_mask',
									'title': i18n.__( 'Background mask' ),
									'descr': i18n.__( "Specify opacity of the background color to use it as mask for the background image" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_content_extra_bg_mask'] )
								}
							], 'trx-addons/content', props ), props )
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
				return el( wp.editor.InnerBlocks.Content, {} );
			}
		},
		'trx-addons/content'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
