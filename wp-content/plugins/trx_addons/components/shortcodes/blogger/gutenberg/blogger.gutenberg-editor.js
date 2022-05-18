(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement,
		atts = trx_addons_object_merge(
			{
				type: {
					type: 'string',
					default: 'default'
				},
				post_type: {
					type: 'string',
					default: 'post'
				},
				taxonomy: {
					type: 'string',
					default: 'category'
				},
				cat: {
					type: 'string',
					default: ''
				},
				pagination: {
					type: 'string',
					default: 'none'
				},
				// Details
				meta_parts: {
					type: 'string',
					default: ''
				},
				hide_excerpt: {
					type: 'boolean',
					default: false
				},
				excerpt_length: {
					type: 'string',
					default: ''
				},
				full_post: {
					type: 'boolean',
					default: false
				},
				more_button: {
					type: 'boolean',
					default: true
				},
				more_text: {
					type: 'string',
					default: i18n.__( 'Read more' )
				},
				image_position: {
					type: 'string',
					default: 'top'
				},
				image_width: {
					type: 'number',
					default: 40
				},
				image_ratio: {
					type: 'string',
					default: 'none'
				},
				thumb_size: {
					type: 'string',
					default: ''
				},
				hover: {
					type: 'string',
					default: 'inherit'
				},
				text_align: {
					type: 'string',
					default: 'left'
				},
				on_plate: {
					type: 'boolean',
					default: false
				},
				numbers: {
					type: 'boolean',
					default: false
				},
				date_format: {
					type: 'string',
					default: ''
				},
				no_margin: {
					type: 'boolean',
					default: false
				},
				no_links: {
					type: 'boolean',
					default: false
				},
				video_in_popup: {
					type: 'boolean',
					default: false
				},
				align: {
					type: 'string',
					//enum: [ 'left', 'center', 'right', 'wide', 'full' ],
					default: ''
				},
				// Reload block - hidden option
				reload: {
					type: 'string'
				}
			},
			trx_addons_gutenberg_get_param_filters(),
			trx_addons_gutenberg_get_param_query(),
			trx_addons_gutenberg_get_param_slider(),
			trx_addons_gutenberg_get_param_title(),
			trx_addons_gutenberg_get_param_button(),
			trx_addons_gutenberg_get_param_id()
		);

	// Add templates
	for (var l in TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_blogger']) {
		if (l == 'length' || ! TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_blogger_template_'+l]) continue;
		var opts = TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_blogger_template_'+l],
			defa = '';
		if (opts) {
			for (var i in opts) {
				defa = i;
				break;
			}
		}
		atts['template_' + l] = {
			type: 'string',
			default: defa
		}
	}
	
	// Register Block - Blogger
	blocks.registerBlockType(
		'trx-addons/blogger', 
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Blogger' ),
			description: i18n.__( "Display posts from specified category in many styles" ),
			icon: 'welcome-widgets-menus',
			category: 'trx-addons-blocks',
			supports: {
				align: [ 'left', 'center', 'right', 'wide', 'full' ],
				html: false,
			},
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', atts, 'trx-addons/blogger' ),
			edit: function(props) {
				if (!TRX_ADDONS_STORAGE['gutenberg_sc_params']['taxonomies'][props.attributes.post_type].hasOwnProperty(props.attributes.taxonomy)) {
					props.attributes.taxonomy = 0;
				}
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'render_button': true,
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Layout
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_blogger'] )
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
									'name': 'cat',
									'title': i18n.__( 'Category' ),
									'type': 'select',
									'multiple': true,
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['categories'][props.attributes.taxonomy], true )
								},
								// Pagination
								{
									'name': 'pagination',
									'title': i18n.__( 'Pagination' ),
									'descr': i18n.__( "Add pagination links after posts. Attention! If slider is active, pagination is not allowed!" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_paginations'] ),
									'dependency': {
										'type': [ '^cards' ]
									}
								}
							], 'trx-addons/blogger', props ), props )
						),
						'additional_params': el(
							'div', {},
							// Query params
							trx_addons_gutenberg_add_param_query( props ),
							// Filters params
							trx_addons_gutenberg_add_param_filters( props ),
							// Details params
							trx_addons_gutenberg_add_param_sc_blogger_details( props ),
							// Title params
							trx_addons_gutenberg_add_param_title( props, true ),
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
			},
		},
		'trx-addons/blogger'
	) );

	// Return details params
	//-------------------------------------------
	function trx_addons_gutenberg_add_param_sc_blogger_details(props) {
		var el     = window.wp.element.createElement;
		var i18n   = window.wp.i18n;
		var params = [
				// Image position
				{
					'name': 'image_position',
					'title': i18n.__( 'Image position' ),
					'type': 'select',
					'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_blogger_image_positions'] ),
					'dependency': {
						'type': [ 'default', 'wide', 'list', 'news' ]
					}
				},
				// Image width
				{
					'name': 'image_width',
					'title': i18n.__( 'Image width (in %)' ),
					'type': 'number',
					'min': 10,
					'max': 90,
					'dependency': {
						'type': [ 'default', 'wide', 'list', 'news' ],
						'image_position': ['left', 'right', 'alter']
					}
				},
				// Image ratio
				{
					'name': 'image_ratio',
					'title': i18n.__( 'Image ratio' ),
					'type': 'select',
					'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_blogger_image_ratio'] ),
					'dependency': {
						'type': [ 'default', 'wide', 'list', 'news', 'cards' ]
					}
				},
				// Thumb size
				{
					'name': 'thumb_size',
					'title': i18n.__( 'Image size' ),
					'descr': i18n.__( "Leave 'Default' to use default size defined in the shortcode template or any registered size to override thumbnail size with the selected value." ),
					'type': 'select',
					'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_blogger_thumb_sizes'] ),
					'dependency': {
						'type': [ '^news' ]
					}
				},
				// Image hover
				{
					'name': 'hover',
					'title': i18n.__( 'Image hover' ),
					'type': 'select',
					'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_blogger_image_hover'] )
				},
				// Meta parts
				{
					'name': 'meta_parts',
					'title': i18n.__( 'Choose meta parts' ),
					'type': 'select',
					'multiple': true,
					'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['meta_parts'] ),
					'dependency': {
						'type': [ 'default', 'wide', 'list', 'news' ]
					}
				},
				// Hide excerpt
				{
					'name': 'hide_excerpt',
					'title': i18n.__( 'Hide excerpt' ),
					'type': 'boolean'
				},
				// Text length
				{
					'name': 'excerpt_length',
					'title': i18n.__( "Text length (in words)" ),
					'type': 'text',
					'dependency': {
						'hide_excerpt': [ false ]
					}
				},
				// Open full post
				{
					'name': 'full_post',
					'title': i18n.__( 'Open full post' ),
					'type': 'boolean',
					'dependency': {
						'type': [ '^cards' ],
						'hide_excerpt': [ true ]
					}
				},
				// Remove margin
				{
					'name': 'no_margin',
					'title': i18n.__( "Remove margin" ),
					'descr': i18n.__( "Check if you want remove spaces between columns" ),
					'type': 'boolean',
				},
				// Disable links
				{
					'name': 'no_links',
					'title': i18n.__( 'Disable links' ),
					'type': 'boolean',
					'dependency': {
						'full_post': [false]
					}
				},
				// Show 'More' button
				{
					'name': 'more_button',
					'title': i18n.__( "Show 'More' button" ),
					'type': 'boolean',
					'dependency': {
						'no_links': [false],
						'full_post': [false]
					}
				},
				// 'More' text
				{
					'name': 'more_text',
					'title': i18n.__( "'More' text" ),
					'type': 'text',
					'dependency': {
						'more_button': [true],
						'no_links': [false]
					}
				},
				// Text alignment
				{
					'name': 'text_align',
					'title': i18n.__( 'Text alignment' ),
					'type': 'select',
					'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] ),
					'dependency': {
						'type': [ 'default', 'wide', 'list', 'news', 'cards' ]
					}
				},
				// On plate
				{
					'name': 'on_plate',
					'title': i18n.__( 'On plate' ),
					'type': 'boolean',
					'dependency': {
						'type': [ 'default', 'wide', 'list', 'news' ]
					}
				},
				// Video in the popup
				{
					'name': 'video_in_popup',
					'title': i18n.__( 'Video in the popup' ),
					'descr': i18n.__( "Open video in the popup window or insert it instead the cover image" ),
					'type': 'boolean',
				},
				// Show numbers
				{
					'name': 'numbers',
					'title': i18n.__( 'Show numbers' ),
					'type': 'boolean',
					'dependency': {
						'type': [ 'list' ]
					}
				},
				// Date format
				{
					'name': 'date_format',
					'title': i18n.__( "Date format" ),
					'descr': i18n.__( 'See available formats %s' ).replace( '%s', i18n.__( 'here:' ) + ' ' + '//wordpress.org/support/article/formatting-date-and-time/' ),
					'type': 'text',
					'dependency': {
						'type': [ 'default', 'wide', 'list', 'news', 'cards' ]
					}
				}
			];

		// Add templates
		for (var l in TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_blogger']) {
			if (l == 'length' || ! TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_blogger_template_'+l]) continue;
			var opts = TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_blogger_template_'+l];
			if (!opts) continue;
			params.unshift(
				{
					'name': 'template_' + l,
					'title': i18n.__( 'Template' ),
					'type': 'select',
					'options': trx_addons_gutenberg_get_lists( opts ),
					'dependency': {
						'type': [ l ]
					}
				}
			);
		}

		return el(
			wp.element.Fragment,
			null,
			el(
				wp.editor.InspectorControls,
				{ key: 'inspector' },
				el(
					wp.components.PanelBody,
					{ title: i18n.__( "Details" ) },
					trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', params, 'trx-addons/blogger-details', props ), props )
				)
			)
		);
	}
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );