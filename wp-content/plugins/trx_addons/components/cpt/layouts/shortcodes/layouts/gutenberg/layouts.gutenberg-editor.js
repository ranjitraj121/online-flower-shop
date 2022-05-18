(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;
	// Register Block - Layouts
	blocks.registerBlockType(
		'trx-addons/layouts',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Layouts' ),
			description: i18n.__( 'Display previously created custom layouts' ),
			icon: 'admin-plugins',
			category: 'trx-addons-layouts',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					popup_id: {
						type: 'string',
						default: ''
					},
					layout: {
						type: 'string',
						default: ''
					},
					position: {
						type: 'string',
						default: 'right'
					},
					effect: {
						type: 'string',
						default: 'slide'
					},
					size: {
						type: 'number',
						default: 300
					},
					modal: {
						type: 'boolean',
						default: false
					},
					shift_page: {
						type: 'boolean',
						default: false
					},
					show_on: {
						type: 'string',
						default: 'none'
					},
					show_delay: {
						type: 'number',
						default: 0
					},
					content: {
						type: 'string',
						default: ''
					}
				},
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/layouts' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Type
								{
									'name': 'type',
									'title': i18n.__( 'Type' ),
									'descr': i18n.__( "Select shortcodes's type" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_layouts'] ),
								},
								// Popup (panel) ID
								{
									'name': 'popup_id',
									'title': i18n.__( 'Popup (panel) ID' ),
									'descr': i18n.__( "Popup (panel) ID is required!" ),
									'type': 'text',
									'dependency': {
										'type': ['popup', 'panel']
									}									
								},
								// Layout
								{
									'name': 'layout',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select any previously created layout to insert to this page" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts_layouts'] ),
								},
								// Panel position
								{
									'name': 'position',
									'title': i18n.__( 'Panel position' ),
									'descr': i18n.__( "Dock the panel to the specified side of the window" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts_panel_positions'] ),
									'dependency': {
										'type': ['panel']
									}
								},
								// Display effect
								{
									'name': 'effect',
									'title': i18n.__( 'Display effect' ),
									'descr': i18n.__( "Effect to display this panel" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts_panel_effects'] ),
									'dependency': {
										'type': ['panel']
									}
								},
								// Size of the panel
								{
									'name': 'size',
									'title': i18n.__( 'Size of the panel' ),
									'descr': i18n.__( 'Size (width or height) of the panel' ),
									'type': 'number',
									'min': 0,
									'max': 600,
									'dependency': {
										'type': ['panel']
									}
								},
								// Modal
								{
									'name': 'modal',
									'title': i18n.__( 'Modal' ),
									'descr': i18n.__( 'Disable clicks on the rest window area' ),
									'type': 'boolean',
									'dependency': {
										'type': ['panel']
									}
								},
								// Shift page
								{
									'name': 'shift_page',
									'title': i18n.__( 'Shift page' ),
									'descr': i18n.__( 'Shift page content when panel is opened' ),
									'type': 'boolean',
									'dependency': {
										'type': ['panel']
									}
								},
								// Show on page load
								{
									'name': 'show_on',
									'title': i18n.__( 'Show on' ),
									'descr': i18n.__( "The event on which to display the popup" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts_show_on'] ),
								},
								// Show delay
								{
									'name': 'show_delay',
									'title': i18n.__( 'Show delay' ),
									'descr': i18n.__( 'How many seconds to wait before the popup appears' ),
									'type': 'number',
									'min': 0,
									'max': 120,
									'dependency': {
										'type': ['popup', 'panel'],
										'show_on': ['on_page_load', 'on_page_load_once']
									}
								},
								// Content
								{
									'name': 'content',
									'title': i18n.__( 'Content' ),
									'descr': i18n.__( "Alternative content to be used instead of the selected layout" ),
									'type': 'textarea',
								}
							], 'trx-addons/layouts', props ), props )
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
		'trx-addons/layouts'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
