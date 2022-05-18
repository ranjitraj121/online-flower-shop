(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Video
	blocks.registerBlockType(
		'trx-addons/video',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Widget: Video' ),
			description: i18n.__( "Insert widget with embedded video from popular video hosting: Vimeo, Youtube, etc." ),
			icon: 'video-alt3',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					title: {
						type: 'string',
						default: ''
					},
					cover: {
						type: 'number',
						default: 0
					},
					cover_url: {
						type: 'string',
						default: ''
					},
					popup: {
						type: 'boolean',
						default: false
					},
					autoplay: {
						type: 'boolean',
						default: false
					},
					link: {
						type: 'string',
						default: ''
					},
					embed: {
						type: 'string',
						default: ''
					}
				},
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/video' ),
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
									'type': 'text'
								},
								// Autoplay on load
								{
									'name': 'autoplay',
									'title': i18n.__( 'Autoplay on load' ),
									'descr': i18n.__( "Autoplay video on page load" ),
									'type': 'boolean'
								},
								// Cover image
								{
									'name': 'cover',
									'name_url': 'cover_url',
									'title': i18n.__( 'Cover image' ),
									'descr': i18n.__( "Select or upload cover image or write URL from other site" ),
									'type': 'image'
								},
								// Open in the popup
								{
									'name': 'popup',
									'title': i18n.__( 'Open in the popup' ),
									'descr': i18n.__( "Open video in the popup" ),
									'type': 'boolean'
								},
								// Link to video
								{
									'name': 'link',
									'title': i18n.__( 'Link to video' ),
									'descr': i18n.__( "Enter link to the video (Note: read more about available formats at WordPress Codex page)" ),
									'type': 'text'
								},
								// or paste Embed code
								{
									'name': 'embed',
									'title': i18n.__( 'or paste Embed code' ),
									'descr': i18n.__( "or paste the HTML code to embed video" ),
									'type': 'textarea'
								}
							], 'trx-addons/video', props ), props )
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
		'trx-addons/video'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
