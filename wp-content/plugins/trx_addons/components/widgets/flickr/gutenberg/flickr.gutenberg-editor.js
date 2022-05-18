(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Flickr photos
	blocks.registerBlockType(
		'trx-addons/flickr',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Widget: Flickr' ),
			description: i18n.__( "Display the latest photos from Flickr account" ),
			icon: 'format-gallery',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{				
					title: {
						type: 'string',
						default: i18n.__( 'Flickr photos' )
					},
					flickr_api_key: {
						type: 'string',
						default: ''
					},
					flickr_username: {
						type: 'string',
						default: ''
					},
					flickr_count: {
						type: 'number',
						default: 8
					},
					flickr_columns: {
						type: 'number',
						default: 4
					},
					flickr_columns_gap: {
						type: 'number',
						default: 0
					}
				},
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/flickr' ),
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
								// Flickr API key
								{
									'name': 'flickr_api_key',
									'title': i18n.__( 'Flickr API key' ),
									'descr': i18n.__( "Specify API key from your Flickr application" ),
									'type': 'text',
								},
								// Flickr username
								{
									'name': 'flickr_username',
									'title': i18n.__( 'Flickr username' ),
									'descr': i18n.__( "Your Flickr username" ),
									'type': 'text',
								},
								// Number of photos
								{
									'name': 'flickr_count',
									'title': i18n.__( 'Number of photos' ),
									'descr': i18n.__( "How many photos to be displayed?" ),
									'type': 'number',
									'min': 1
								},
								// Columns
								{
									'name': 'flickr_columns',
									'title': i18n.__( 'Columns' ),
									'descr': i18n.__( "Columns number" ),
									'type': 'number',
									'min': 1
								},
								// Columns gap
								{
									'name': 'flickr_columns_gap',
									'title': i18n.__( 'Columns gap' ),
									'descr': i18n.__( "Gap between images" ),
									'type': 'number',
									'min': 0
								}
							], 'trx-addons/flickr', props ), props )
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
		'trx-addons/flickr'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
