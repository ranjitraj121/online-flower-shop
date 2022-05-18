(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Banner
	blocks.registerBlockType(
		'trx-addons/banner',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Widget: Banner' ),
			description: i18n.__( "Banner with image and/or any html and js code" ),
			icon: 'format-image',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					title: {
						type: 'string',
						default: ''
					},
					fullwidth: {
						type: 'boolean',
						default: false
					},
					show: {
						type: 'string',
						default: 'permanent'
					},
					image: {
						type: 'number',
						default: 0
					},
					image_url: {
						type: 'string',
						default: ''
					},
					link: {
						type: 'string',
						default: ''
					},
					code: {
						type: 'string',
						default: ''
					}
				},
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/banner' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Title
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'type': 'text',
								},
								// Widget size
								{
									'name': 'fullwidth',
									'title': i18n.__( 'Widget size:' ),
									'descr': i18n.__( "Stretch the width of the element to the full screen's width" ),
									'type': 'boolean'
								},
								// Show on
								{
									'name': 'show',
									'title': i18n.__( 'Show on:' ),
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_banner_show_on'] ),
									'type': 'select',
								},
								// Image source URL
								{
									'name': 'image',
									'name_url': 'image_url',
									'title': i18n.__( 'Image source URL:' ),
									'type': 'image'
								},
								// Image link URL
								{
									'name': 'link',
									'title': i18n.__( 'Image link URL:' ),
									'type': 'text',
								},
								// Paste HTML Code
								{
									'name': 'code',
									'title': i18n.__( 'Paste HTML Code:' ),
									'type': 'textarea',
								}
							], 'trx-addons/banner', props ), props )
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
		'trx-addons/banner'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
