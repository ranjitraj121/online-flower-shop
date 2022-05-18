(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Socials
	blocks.registerBlockType(
		'trx-addons/socials',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Socials' ),
			description: i18n.__( "Insert social icons with links on your profiles" ),
			icon: 'facebook-alt',
			category: 'trx-addons-blocks',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					icons_type: {
						type: 'string',
						default: 'socials'
					},
					align: {
						type: 'string',
						default: 'none'
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
				trx_addons_gutenberg_get_param_title(),
				trx_addons_gutenberg_get_param_button(),
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/socials' ),
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
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_socials'] )
								},
								// Icons type
								{
									'name': 'align',
									'title': i18n.__( 'Icons type' ),
									'descr': i18n.__( "Select type of icons: links to the social profiles or share links" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_socials_types'] )
								},
								// Icons alignment
								{
									'name': 'align',
									'title': i18n.__( 'Icons align' ),
									'descr': i18n.__( "Select alignment of the icons" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] )
								}
							], 'trx-addons/socials', props ), props )
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
				props.attributes.icons = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
			},
		},
		'trx-addons/socials'
	) );

	// Register block Socials Item
	blocks.registerBlockType(
		'trx-addons/socials-item',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Socials Item' ),
			description: i18n.__( "Select social icons and specify link for each item" ),
			icon: 'facebook-alt',
			category: 'trx-addons-blocks',
			parent: ['trx-addons/socials'],
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', {
				title: {
					type: 'string',
					default: i18n.__( 'One' )
				},
				link: {
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
			}, 'trx-addons/socials-item' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'title': i18n.__( 'Socials item' ) + (props.attributes.title ? ': ' + props.attributes.title : ''),
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Title
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'descr': i18n.__( "Enter title of the item" ),
									'type': 'text'
								},
								// Link
								{
									'name': 'link',
									'title': i18n.__( 'Link' ),
									'descr': i18n.__( "URL to link this item" ),
									'type': 'text'
								},
								// Icon
								{
									'name': 'icon',
									'title': i18n.__( 'Icon' ),
									'descr': i18n.__( "Select icon from library" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_option_icons_classes()
								}
							], 'trx-addons/socials-item', props ), props )
						)
					}, props
				);
			},
			save: function(props) {
				return el( '', null );
			}
		},
		'trx-addons/socials-item'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
