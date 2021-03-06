(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Calendar
	blocks.registerBlockType(
		'trx-addons/calendar',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Widget: Calendar' ),
			description: i18n.__( "Insert standard WP Calendar, but allow user select week day's captions" ),
			icon: 'calendar-alt',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					title: {
						type: 'string',
						default: i18n.__( 'Calendar' )
					},
					weekdays: {
						type: 'string',
						default: "short"
					}
				},
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/calendar' ),
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
								// Week days
								{
									'name': 'weekdays',
									'title': i18n.__( 'Week days' ),
									'descr': i18n.__( "Show captions for the week days as three letters (Sun, Mon, etc.) or as one initial letter (S, M, etc.)" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists({
										'short': i18n.__( 'Short' ),
										'initial': i18n.__( 'Initial' ),
									} )
								}
							], 'trx-addons/calendar', props ), props )
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
		'trx-addons/calendar'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
