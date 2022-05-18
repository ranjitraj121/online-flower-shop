(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Instagram feed
	blocks.registerBlockType(
		'trx-addons/instagram',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Widget: Instagram' ),
			description: i18n.__( "Display the latest photos from instagram account by hashtag" ),
			icon: 'images-alt2',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{				
					title: {
						type: 'string',
						default: i18n.__( 'Instagram feed' )
					},
					type: {
						type: 'string',
						default: 'default'
					},
					demo: {
						type: 'boolean',
						default: false
					},
					demo_thumb_size: {
						type: 'string',
						default: TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_instagram_demo_thumb_size']	//'trx_addons-thumb-avatar'
					},
					demo_files: {
						type: 'string',
						default: ''
					},
					count: {
						type: 'number',
						default: 8
					},
					columns: {
						type: 'number',
						default: 4
					},
					columns_gap: {
						type: 'number',
						default: 0
					},
					hashtag: {
						type: 'string',
						default: ''
					},
					links: {
						type: 'string',
						default: 'instagram'
					},
					follow: {
						type: 'boolean',
						default: false
					},
					follow_link: {
						type: 'string',
						default: ''
					},
					// Reload block - hidden option
					reload: {
						type: 'string'
					}
				},
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/instagram' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'render_button': true,
						'parent': true,
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Widget title
								{
									'name': 'title',
									'title': i18n.__( 'Widget title' ),
									'descr': i18n.__( "Title of the widget" ),
									'type': 'text',
								},
								// Layout
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select shortcodes's layout" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_instagram'] )
								},
								// Demo mode
								{
									'name': 'demo',
									'title': i18n.__( 'Demo mode' ),
									'descr': i18n.__( 'Show demo images' ),
									'type': 'boolean',
								},
								// Demo thumb size
								{
									'name': 'demo_thumb_size',
									'title': i18n.__( 'Thumb size' ),
									'descr': i18n.__( "Select a thumb size to show images" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_instagram_thumb_sizes'] ),
									'dependency': {
										'demo': [true]
									}
								},
								// Hashtag
								{
									'name': 'hashtag',
									'title': i18n.__( 'Hashtag or Username' ),
									'descr': i18n.__( "Hashtag (start with #) or Username to filter your photos" ),
									'dependency': {
										'demo': [false]
									},
									'type': 'text',
								},
								// Number of photos
								{
									'name': 'count',
									'title': i18n.__( 'Number of photos' ),
									'descr': i18n.__( "How many photos to be displayed?" ),
									'dependency': {
										'demo': [false]
									},
									'type': 'number',
									'min': 1
								},
								// Columns
								{
									'name': 'columns',
									'title': i18n.__( 'Columns' ),
									'descr': i18n.__( "Columns number" ),
									'type': 'number',
									'min': 1
								},
								// Columns gap
								{
									'name': 'columns_gap',
									'title': i18n.__( 'Columns gap' ),
									'descr': i18n.__( "Gap between images" ),
									'type': 'number',
									'min': 0
								},
								// Link images to
								{
									'name': 'links',
									'title': i18n.__( 'Link images to' ),
									'descr': i18n.__( "Where to send a visitor after clicking on the picture" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_instagram_redirects'] )
								},
								// Show button "Follow me"
								{
									'name': 'follow',
									'title': i18n.__( 'Show button "Follow me"' ),
									'descr': i18n.__( 'Add button "Follow me" after images' ),
									'type': 'boolean',
								},
								// Foolow link
								{
									'name': 'follow_link',
									'title': i18n.__( 'Follow link' ),
									'descr': i18n.__( "URL for the Follow link" ),
									'type': 'text',
									'dependency': {
										'follow': [true]
									}
								}
							], 'trx-addons/instagram', props ), props )
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
				props.attributes.demo_files = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
//				return el( '', null );
			}
		},
		'trx-addons/instagram'
	) );

	// Register block Instagram Item
	blocks.registerBlockType(
		'trx-addons/instagram-item',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Instagram demo image' ),
			description: i18n.__( "Insert an image or a video for demo mode" ),
			icon: 'images-alt',
			category: 'trx-addons-widgets',
			parent: ['trx-addons/instagram'],
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', {
				// Media attributes
				image: {
					type: 'number',
					default: 0
				},
				image_url: {
					type: 'string',
					default: ''
				},
				video: {
					type: 'string',
					default: ''
				}
			}, 'trx-addons/instagram-item' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'title': i18n.__( 'Demo media item' ) + (props.attributes.title ? ': ' + props.attributes.title : ''),
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Image
								{
									'name': 'image',
									'name_url': 'image_url',
									'title': i18n.__( 'Image' ),
									'descr': i18n.__( "Select or upload image or specify URL from other site to use it as icon" ),
									'type': 'image'
								},
								// Video URL
								{
									'name': 'video',
									'title': i18n.__( 'Video URL' ),
									'descr': i18n.__( "Enter link to the video (Note: read more about available formats at WordPress Codex page)" ),
									'type': 'text'
								}
							], 'trx-addons/instagram-item', props ), props )
						)
					}, props
				);
			},
			save: function(props) {
				return el( '', null );
			}
		},
		'trx-addons/instagram-item'
	) );

})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
