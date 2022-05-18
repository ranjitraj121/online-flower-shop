(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;
	var trx_addons_gutenberg_add_param_key = 0;

	// Register Block - Action
	blocks.registerBlockType(
		'trx-addons/accordionposts',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Accordion posts' ),
			description: i18n.__( "Accordion of posts" ),
			icon: 'excerpt-view',
			category: 'trx-addons-blocks',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					accordions: {
						type: 'string',
						default: ''
					},
					// Reload block - hidden option
					reload: {
						type: 'string'
					}
				},
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/accordionposts' ),
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
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_accordionposts'] )
								}
							], 'trx-addons/accordionposts', props ), props )
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
				// Get child block values of attributes
				props.attributes.accordions = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
			}
		},
		'trx-addons/accordionposts'
	) );

	// Register block Accordionposts Item
	var first_page = trx_addons_array_first_key(TRX_ADDONS_STORAGE['gutenberg_sc_params']['list_pages']),
		first_layout = trx_addons_array_first_key(TRX_ADDONS_STORAGE['gutenberg_sc_params']['list_layouts']);

	blocks.registerBlockType(
		'trx-addons/accordionposts-item',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Accordion posts item' ),
			description: i18n.__( "Insert 'Accordion posts' item" ),
			icon: 'excerpt-view',
			category: 'trx-addons-blocks',
			parent: ['trx-addons/accordionposts'],
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', {
				// Accordion posts item attributes
				title: {
					type: 'string',
					default: i18n.__( "Item's title" )
				},
				subtitle: {
					type: 'string',
					default: i18n.__( 'Description' )
				},
				icon: {
					type: 'string',
					default: ''
				},
				color: {
					type: 'string',
					default: ''
				},
				bg_color: {
					type: 'string',
					default: ''
				},
				content_source: {
					type: 'string',
					default: 'text'
				},
				post_id: {
					type: 'string',
					default: first_page
				},
				layout_id: {
					type: 'string',
					default: first_layout
				},
				inner_content: {
					type: 'string',
					default: ''
				},
				advanced_rolled_content: {
					type: 'boolean',
					default: false
				},
				rolled_content: {
					type: 'string',
					default: ''
				},
				className: {
					type: 'string',
					default: ''
				}
			}, 'trx-addons/accordionposts-item' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'title': i18n.__( 'Accordion item' ) + (props.attributes.title ? ': ' + props.attributes.title : ''),
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Title
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'type': 'text'
								},
								// Subtitle
								{
									'name': 'subtitle',
									'title': i18n.__( 'Subtitle' ),
									'type': 'text'
								},
								// Icon
								{
									'name': 'icon',
									'title': i18n.__( 'Icon' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_option_icons_classes()
								},
								// Icon Color
								{
									'name': 'color',
									'title': i18n.__( 'Icon Color' ),
									'descr': i18n.__( "Selected color will also be applied to the subtitle" ),
									'type': 'color'
								},
								// Icon Background Color
								{
									'name': 'bg_color',
									'title': i18n.__( 'Icon Background Color' ),
									'descr': i18n.__( "Selected color will also be applied to the subtitle" ),
									'type': 'color'
								},
								// Select content source
								{
									'name': 'content_source',
									'title': i18n.__( 'Select content source' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists({
										'text': i18n.__( 'Use content' ),
										'page': i18n.__( 'Pages' ),
										'layout': i18n.__( 'Layouts' ),
									} )
								},
								// Page ID
								{
									'name': 'post_id',
									'title': i18n.__( 'Page ID' ),
									'descr': i18n.__( "'Use Content' option allows you to create custom content for the selected content area, otherwise you will be prompted to choose an existing page to import content from it. " ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['list_pages'] ),
									'dependency': {
										'content_source': ['page']
									}
								},
								// Layout ID
								{
									'name': 'layout_id',
									'title': i18n.__( 'Layout ID' ),
									'descr': i18n.__( "'Use Content' option allows you to create custom content for the selected content area, otherwise you will be prompted to choose an existing page to import content from it. " ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['list_layouts'] ),
									'dependency': {
										'content_source': ['layout']
									}
								},
								// Inner content
								{
									'name': 'inner_content',
									'title': i18n.__( 'Inner content' ),
									'type': 'textarea',
									'dependency': {
										'content_source': ['text']
									}
								},
								// Advanced Header Options
								{
									'name': 'advanced_rolled_content',
									'title': i18n.__( 'Advanced Header Options' ),
									'type': 'boolean'
								},
								// Advanced Header Options
								{
									'name': 'rolled_content',
									'title': i18n.__( 'Advanced Header Options' ),
									'type': 'textarea',
									'dependency': {
										'advanced_rolled_content': [ true ]
									}
								}
							], 'trx-addons/accordionposts-item', props ), props )
						)
					}, props
				);
			},
			save: function(props) {
				return el( '', null );
			}
		},
		'trx-addons/accordionposts-item'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
