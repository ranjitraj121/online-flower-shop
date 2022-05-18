(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Courses
	blocks.registerBlockType(
		'trx-addons/courses',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Courses' ),
			icon: 'welcome-learn-more',
			category: 'trx-addons-cpt',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					pagination: {
						type: 'string',
						default: 'none'
					},
					no_margin: {
						type: 'boolean',
						default: false
					},
					more_text: {
						type: 'string',
						default: i18n.__( 'Read more' ),
					},
					past: {
						type: 'boolean',
						default: false
					},
					cat: {
						type: 'string',
						default: '0'
					}
				},
				trx_addons_gutenberg_get_param_query(),
				trx_addons_gutenberg_get_param_slider(),
				trx_addons_gutenberg_get_param_title(),
				trx_addons_gutenberg_get_param_button(),
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/courses' ),
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
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['trx_sc_courses'] )
								},
								// Remove margin
								{
									'name': 'no_margin',
									'title': i18n.__( "Remove margin" ),
									'descr': i18n.__( "Check if you want remove spaces between columns" ),
									'type': 'boolean',
								},
								// Pagination
								{
									'name': 'pagination',
									'title': i18n.__( 'Pagination' ),
									'descr': i18n.__( "Add pagination links after posts. Attention! Pagination is not allowed if the slider layout is used." ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_paginations'] )
								},
								// 'More' text
								{
									'name': 'more_text',
									'title': i18n.__( "'More' text" ),
									'descr': i18n.__( "Specify caption of the 'Read more' button. If empty - hide button" ),
									'type': 'text',
								},
								// Past courses
								{
									'name': 'past',
									'title': i18n.__( "Past courses" ),
									'descr': i18n.__( "Show the past courses if checked, otherwise - show upcoming courses." ),
									'type': 'boolean',
								},
								// Group
								{
									'name': 'cat',
									'title': i18n.__( "Group" ),
									'descr': i18n.__( "Courses group" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_courses_cat'] )
								}
							], 'trx-addons/courses', props ), props )
						),
						'additional_params': el(
							'div', {},
							// Query params
							trx_addons_gutenberg_add_param_query( props ),
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
			}
		},
		'trx-addons/courses'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
