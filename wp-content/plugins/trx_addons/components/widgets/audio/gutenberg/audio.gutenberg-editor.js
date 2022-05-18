(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Audio
	blocks.registerBlockType(
		'trx-addons/audio',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Widget: Audio' ),
			description: i18n.__( "Play audio from Soundcloud and other audio hostings or Local hosted audio" ),
			icon: 'format-audio',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					title: {
						type: 'string',
						default: ''
					},
					subtitle: {
						type: 'string',
						default: ''
					},
					next_btn: {
						type: 'boolean',
						default: true
					},
					prev_btn: {
						type: 'boolean',
						default: true
					},
					next_text: {
						type: 'string',
						default: ''
					},
					prev_text: {
						type: 'string',
						default: ''
					},
					now_text: {
						type: 'string',
						default: ''
					},
					track_time: {
						type: 'boolean',
						default: true
					},
					track_scroll: {
						type: 'boolean',
						default: true
					},
					track_volume: {
						type: 'boolean',
						default: true
					},
					media: {
						type: 'string',
						default: ''
					},
					// Reload block - hidden option
					reload: {
						type: 'string'
					}
				},
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/audio' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'render_button': true,
						'parent': true,
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Title
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'type': 'text',
								},
								// Subtitle
								{
									'name': 'subtitle',
									'title': i18n.__( 'Subtitle' ),
									'type': 'text',
								},
								// Show next button
								{
									'name': 'next_btn',
									'title': i18n.__( 'Show next button' ),
									'type': 'boolean'
								},
								// Show prev button
								{
									'name': 'prev_btn',
									'title': i18n.__( 'Show prev button' ),
									'type': 'boolean'
								},
								// Next button text
								{
									'name': 'next_text',
									'title': i18n.__( 'Next button text' ),
									'type': 'text',
								},
								// Prev button text
								{
									'name': 'prev_text',
									'title': i18n.__( 'Prev button text' ),
									'type': 'text',
								},
								// "Now playing" text
								{
									'name': 'now_text',
									'title': i18n.__( '"Now playing" text' ),
									'type': 'text',
								},
								// Show tack time
								{
									'name': 'track_time',
									'title': i18n.__( 'Show tack time' ),
									'type': 'boolean'
								},
								// Show track scroll bar
								{
									'name': 'track_scroll',
									'title': i18n.__( 'Show track scroll bar' ),
									'type': 'boolean'
								},
								// Show track volume bar
								{
									'name': 'track_volume',
									'title': i18n.__( 'Show track volume bar' ),
									'type': 'boolean'
								}
							], 'trx-addons/audio', props ), props )
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
				props.attributes.media = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
			},
		},
		'trx-addons/audio'
	) );

	// Register block Audio Item
	blocks.registerBlockType(
		'trx-addons/audio-item',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Audio Item' ),
			description: i18n.__( "Insert audio item" ),
			icon: 'format-audio',
			category: 'trx-addons-widgets',
			parent: ['trx-addons/audio'],
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', {
				url: {
					type: 'string',
					default: ''
				},
				embed: {
					type: 'string',
					default: ''
				},
				caption: {
					type: 'string',
					default: ''
				},
				author: {
					type: 'string',
					default: ''
				},
				description: {
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
				}
			}, 'trx-addons/audio-item' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'title': i18n.__( 'Audio item' ) + (props.attributes.caption ? ': ' + props.attributes.caption : ''),
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Media URL
								{
									'name': 'url',
									'title': i18n.__( 'Media URL' ),
									'type': 'text'
								},
								// Embed code
								{
									'name': 'embed',
									'title': i18n.__( 'Embed code' ),
									'type': 'textarea'
								},
								// Audio caption
								{
									'name': 'caption',
									'title': i18n.__( 'Audio caption' ),
									'type': 'text'
								},
								// Author name
								{
									'name': 'author',
									'title': i18n.__( 'Author name' ),
									'type': 'text'
								},
								// Description
								{
									'name': 'description',
									'title': i18n.__( 'Description' ),
									'type': 'textarea'
								},
								// Cover image
								{
									'name': 'cover',
									'name_url': 'cover_url',
									'title': i18n.__( 'Cover image' ),
									'type': 'image'
								}
							], 'trx-addons/audio-item', props ), props )
						)
					}, props
				);
			},
			save: function(props) {
				return el( '', null );
			}
		},
		'trx-addons/audio-item'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
