(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Rrecent Posts
	blocks.registerBlockType(
		'trx-addons/recent-posts',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Widget: Recent Posts' ),
			description: i18n.__( "Insert recent posts list with thumbs, post's meta and category" ),
			icon: 'list-view',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{				
					title: {
						type: 'string',
						default: ''
					},
					number: {
						type: 'number',
						default: 4
					},
					show_date: {
						type: 'boolean',
						default: true
					},
					show_image: {
						type: 'boolean',
						default: true
					},
					show_author: {
						type: 'boolean',
						default: true
					},
					show_counters: {
						type: 'boolean',
						default: true
					},
					show_categories: {
						type: 'boolean',
						default: true
					}
				},
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/recent-posts' ),
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
								// Number posts to show
								{
									'name': 'number',
									'title': i18n.__( 'Number of posts to display' ),
									'descr': i18n.__( "How many posts display in the widget?" ),
									'type': 'number',
									'min': 1
								},
								// Show post's image
								{
									'name': 'show_image',
									'title': i18n.__( "Show post's image" ),
									'descr': i18n.__( "Do you want display post's featured image?" ),
									'type': 'boolean'
								},
								// Show post's date
								{
									'name': 'show_date',
									'title': i18n.__( "Show post's date" ),
									'descr': i18n.__( "Do you want display post's publish date?" ),
									'type': 'boolean'
								},
								// Show post's author
								{
									'name': 'show_author',
									'title': i18n.__( "Show post's author" ),
									'descr': i18n.__( "Do you want display post's author?" ),
									'type': 'boolean'
								},
								// Show post's counters
								{
									'name': 'show_counters',
									'title': i18n.__( "Show post's counters" ),
									'descr': i18n.__( "Do you want display post's counters?" ),
									'type': 'boolean'
								},
								// Show post's categories
								{
									'name': 'show_categories',
									'title': i18n.__( "Show post's categories" ),
									'descr': i18n.__( "Do you want display post's categories?" ),
									'type': 'boolean'
								}
							], 'trx-addons/recent-posts', props ), props )
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
		'trx-addons/recent-posts'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
