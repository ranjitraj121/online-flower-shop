(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - About me
	blocks.registerBlockType(
		'trx-addons/aboutme',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Widget: About me' ),
			description: i18n.__( "About me - photo and short description about the blog author" ),
			icon: 'admin-users',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					title: {
						type: 'string',
						default: i18n.__( 'About me' )
					},
					avatar: {
						type: 'number',
						default: 0
					},
					avatar_url: {
						type: 'string',
						default: ''
					},
					username: {
						type: 'string',
						default: ''
					},
					description: {
						type: 'string',
						default: ''
					}
				},
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/aboutme' ),
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
									'type': 'text'
								},
								// Avatar
								{
									'name': 'avatar',
									'name_url': 'avatar_url',
									'title': i18n.__( 'Avatar' ),
									'descr': i18n.__( 'Avatar (if empty - get gravatar by admin email)' ),
									'type': 'image'
								},
								// User name
								{
									'name': 'username',
									'title': i18n.__( 'User name' ),
									'descr': i18n.__( 'User name (if equal to # - not show)' ),
									'type': 'text'
								},
								// Description
								{
									'name': 'description',
									'title': i18n.__( 'Description' ),
									'descr': i18n.__( 'Short description about user (if equal to # - not show)' ),
									'type': 'textarea'
								}
							], 'trx-addons/aboutme', props ), props )
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
		'trx-addons/aboutme'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
