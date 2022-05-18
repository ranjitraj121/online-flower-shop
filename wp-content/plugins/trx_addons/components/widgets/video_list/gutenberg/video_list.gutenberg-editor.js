(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Video List
	blocks.registerBlockType(
		'trx-addons/video-player',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Widget: Video List' ),
			description: i18n.__( "Show list of videos from posts or from the custom list" ),
			icon: 'video-alt3',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					title: {
						type: 'string',
						default: ''
					},
					autoplay: {
						type: 'boolean',
						default: false
					},
					post_type: {
						type: 'string',
						default: 'post'
					},
					taxonomy: {
						type: 'string',
						default: 'category'
					},
					category: {
						type: 'string',
						default: ''
					},
					controller_style: {
						type: 'string',
						default: 'default'
					},
					controller_pos: {
						type: 'string',
						default: 'right'
					},
					controller_height: {
						type: 'string',
						default: ''
					},
					controller_autoplay: {
						type: 'boolean',
						default: true
					},
					controller_link: {
						type: 'boolean',
						default: true
					}
				},
				trx_addons_gutenberg_get_param_query( { columns: false } ),
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/video-player' ),
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
								// Autoplay
								{
									'name': 'autoplay',
									'title': i18n.__( 'Autoplay first video' ),
									'type': 'boolean'
								},
								// Post type
								{
									'name': 'post_type',
									'title': i18n.__( 'Post type' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['posts_types'] )
								},
								// Taxonomy
								{
									'name': 'taxonomy',
									'title': i18n.__( 'Taxonomy' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['taxonomies'][props.attributes.post_type], true )
								},
								// Category
								{
									'name': 'category',
									'title': i18n.__( 'Category' ),
									'type': 'select',
									'multiple': true,
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['categories'][props.attributes.taxonomy], true )
								}
							], 'trx-addons/video-player', props ), props )
						),
						'additional_params': el(
							'div', {},
							// Query params
							trx_addons_gutenberg_add_param_query( props, { columns: false } ),
							// Controller params
							trx_addons_gutenberg_add_param_sc_video_list_controller( props ),
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
		'trx-addons/video-player'
	) );

	// Return details params
	//-------------------------------------------
	function trx_addons_gutenberg_add_param_sc_video_list_controller(props) {
		var el     = window.wp.element.createElement;
		var i18n   = window.wp.i18n;
		var params = [
						// Controller style
						{
							'name': 'controller_style',
							'title': i18n.__( 'Style of the TOC' ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_video_list_controller_styles'] )
						},
						// Controller position
						{
							'name': 'controller_pos',
							'title': i18n.__( 'Position of the TOC' ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_video_list_controller_positions'] )
						},
						// Controller height
						{
							'name': 'controller_height',
							'title': i18n.__( 'Max. height of the TOC' ),
							'type': 'text',
							'dependency': {
								'controller_pos': [ 'bottom' ]
							}
						},
						// Autoplay
						{
							'name': 'controller_autoplay',
							'title': i18n.__( 'Autoplay selected video' ),
							'type': 'boolean'
						},
						// Link to the video or to the post
						{
							'name': 'controller_link',
							'title': i18n.__( 'Show video or go to the post' ),
							'type': 'boolean'
						}
		];

		return el(
			wp.element.Fragment,
			null,
			el(
				wp.editor.InspectorControls,
				{ key: 'inspector' },
				el(
					wp.components.PanelBody,
					{ title: i18n.__( "Table of contents" ) },
					trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', params, 'trx-addons/video-player-details', props ), props )
				)
			)
		);
	}

})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
