(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Twitter
	blocks.registerBlockType(
		'trx-addons/twitter',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Widget: Twitter' ),
			icon: 'twitter',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'list'
					},
					title: {
						type: 'string',
						default: ''
					},
					count: {
						type: 'number',
						default: 2
					},
					columns: {
						type: 'number',
						default: 1
					},
					follow: {
						type: 'boolean',
						default: true
					},
					back_image: {
						type: 'number',
						default: 0
					},
					back_image_url: {
						type: 'string',
						default: ''
					},
					twitter_api: {
						type: 'string',
						default: 'token'
					},
					username: {
						type: 'string',
						default: ''
					},
					consumer_key: {
						type: 'string',
						default: ''
					},
					consumer_secret: {
						type: 'string',
						default: ''
					},
					token_key: {
						type: 'string',
						default: ''
					},
					token_secret: {
						type: 'string',
						default: ''
					},
					bearer: {
						type: 'string',
						default: ''
					},
					embed_header: {
						type: 'boolean',
						default: true
					},
					embed_footer: {
						type: 'boolean',
						default: true
					},
					embed_borders: {
						type: 'boolean',
						default: true
					},
					embed_scrollbar: {
						type: 'boolean',
						default: true
					},
					embed_transparent: {
						type: 'boolean',
						default: true
					}
				},
				trx_addons_gutenberg_get_param_slider(),
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/twitter' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Layout
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select shortcodes's layout" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_twitter'] )
								},
								// Widget title
								{
									'name': 'title',
									'title': i18n.__( 'Widget title' ),
									'descr': i18n.__( "Title of the widget" ),
									'type': 'text'
								},
								// Twitter API
								{
									'name': 'twitter_api',
									'title': i18n.__( 'Twitter API' ),
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_twitter_api'] ),
									'type': 'select'
								},
								// Tweets number
								{
									'name': 'count',
									'title': i18n.__( 'Tweets number' ),
									'descr': i18n.__( "Tweets number to show in the feed" ),
									'type': 'number',
									'min': 1,
									'max': 20
								},
								// Columns
								{
									'name': 'columns',
									'title': i18n.__( 'Columns' ),
									'descr': i18n.__( "Specify the number of columns. If left empty or assigned the value '0' - auto detect by the number of items." ),
									'type': 'number',
									'min': 1,
									'max': 4,
									'dependency': {
										'type': [ 'default' ],
										'twitter_api': [ '^embed' ]
									}
								},
								// Show Follow Us
								{
									'name': 'follow',
									'title': i18n.__( 'Show Follow Us' ),
									'descr': i18n.__( "Do you want display Follow Us link below the feed?" ),
									'type': 'boolean'
								},
								// Widget background
								{
									'name': 'back_image',
									'name_url': 'back_image_url',
									'title': i18n.__( 'Widget background' ),
									'descr': i18n.__( "Select or upload image or write URL from other site for use it as widget background" ),
									'type': 'image'
								},
								// Twitter Username
								{
									'name': 'username',
									'title': i18n.__( 'Twitter Username' ),
									'type': 'text'
								},
								// Show embed header
								{
									'name': 'embed_header',
									'title': i18n.__( 'Show embed header' ),
									'descr': '',
									'dependency': {
										'twitter_api': [ 'embed' ]
									},
									'type': 'boolean'
								},
								// Show embed footer
								{
									'name': 'embed_footer',
									'title': i18n.__( 'Show embed footer' ),
									'descr': '',
									'dependency': {
										'twitter_api': [ 'embed' ]
									},
									'type': 'boolean'
								},
								// Show embed borders
								{
									'name': 'embed_borders',
									'title': i18n.__( 'Show embed borders' ),
									'descr': '',
									'dependency': {
										'twitter_api': [ 'embed' ]
									},
									'type': 'boolean'
								},
								// Show embed scrollbar
								{
									'name': 'embed_scrollbar',
									'title': i18n.__( 'Show embed scrollbar' ),
									'descr': '',
									'dependency': {
										'twitter_api': [ 'embed' ]
									},
									'type': 'boolean'
								},
								// Make embed bg transparent
								{
									'name': 'embed_transparent',
									'title': i18n.__( 'Make embed bg transparent' ),
									'descr': '',
									'dependency': {
										'twitter_api': [ 'embed' ]
									},
									'type': 'boolean'
								},
								// Consumer Key
								{
									'name': 'consumer_key',
									'title': i18n.__( 'Consumer Key' ),
									'descr': i18n.__( "Specify a Consumer Key from Twitter application" ),
									'dependency': {
										'twitter_api': [ 'token' ]
									},
									'type': 'text'
								},
								// Consumer Secret
								{
									'name': 'consumer_secret',
									'title': i18n.__( 'Consumer Secret' ),
									'descr': i18n.__( "Specify a Consumer Secret from Twitter application" ),
									'dependency': {
										'twitter_api': [ 'token' ]
									},
									'type': 'text'
								},
								// Token Key
								{
									'name': 'token_key',
									'title': i18n.__( 'Token Key' ),
									'descr': i18n.__( "Specify a Token Key from Twitter applicationd" ),
									'dependency': {
										'twitter_api': [ 'token' ]
									},
									'type': 'text'
								},
								// Token Secret
								{
									'name': 'token_secret',
									'title': i18n.__( 'Token Secret' ),
									'descr': i18n.__( "Specify a Token Secret from Twitter application" ),
									'dependency': {
										'twitter_api': [ 'token' ]
									},
									'type': 'text'
								},
								// Bearer
								{
									'name': 'bearer',
									'title': i18n.__( 'Bearer' ),
									'descr': i18n.__( "Specify a Bearer authorization token from a Twitter application" ),
									'dependency': {
										'twitter_api': [ 'token' ]
									},
									'type': 'text'
								}
							], 'trx-addons/twitter', props ), props )
						),
						'additional_params': el(
							'div', {},
							// Slider params
							trx_addons_gutenberg_add_param_slider( props ),
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
		'trx-addons/twitter'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
