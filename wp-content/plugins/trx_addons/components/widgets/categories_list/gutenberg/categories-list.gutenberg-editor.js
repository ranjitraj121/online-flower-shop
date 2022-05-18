(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Categories List
	blocks.registerBlockType(
		'trx-addons/categories-list',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Widget: Categories List' ),
			description: i18n.__( "Insert categories list with icons or images" ),
			icon: 'editor-ul',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					title: {
						type: 'string',
						default: i18n.__( 'Categories List' )
					},
					style: {
						type: 'string',
						default: '1'
					},
					number: {
						type: 'number',
						default: 5
					},
					columns: {
						type: 'number',
						default: 5
					},
					show_thumbs: {
						type: 'boolean',
						default: true
					},
					show_posts: {
						type: 'boolean',
						default: true
					},
					show_children: {
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
					cat_list: {
						type: 'string',
						default: ''
					}
				},
				trx_addons_gutenberg_get_param_slider(),
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/categories-list' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Title
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'type': 'text',
								},
								// Style
								{
									'name': 'style',
									'title': i18n.__( 'Style' ),
									'descr': i18n.__( "Select the style to display a categories list" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_categories_list'] )
								},
								// Post type
								{
									'name': 'post_type',
									'title': i18n.__( 'Post type' ),
									'descr': i18n.__( "Select the post type to get featured images from the posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['posts_types'] )
								},
								// Taxonomy
								{
									'name': 'taxonomy',
									'title': i18n.__( 'Taxonomy' ),
									'descr': i18n.__( "Select the taxonomy to get featured images from the posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['taxonomies'][props.attributes.post_type], true ),
								},
								// List of the terms
								{
									'name': 'cat_list',
									'title': i18n.__( 'List of the terms' ),
									'descr': i18n.__( "The comma separated list of the term's slugs to show. If empty - show 'number' terms (see the field below)" ),
									'type': 'text',
								},
								// Number of categories to show
								{
									'name': 'number',
									'title': i18n.__( 'Number of categories to show' ),
									'descr': i18n.__( "How many categories display in widget?" ),
									'type': 'number',
									'min': 1
								},
								// Columns number to show
								{
									'name': 'columns',
									'title': i18n.__( 'Columns number to show' ),
									'descr': i18n.__( "How many columns use to display categories list?" ),
									'type': 'number',
									'min': 1
								},
								// Show thumbs
								{
									'name': 'show_thumbs',
									'title': i18n.__( 'Show thumbs' ),
									'descr': i18n.__( "Do you want display term's thumbnails (if exists)?" ),
									'type': 'boolean',
								},
								// Show posts number
								{
									'name': 'show_posts',
									'title': i18n.__( 'Show posts number' ),
									'descr': i18n.__( "Do you want display posts number?" ),
									'type': 'boolean',
								},
								// Show children
								{
									'name': 'show_children',
									'title': i18n.__( 'Show children' ),
									'descr': i18n.__( "Show only children of the current category" ),
									'type': 'boolean',
								}
							], 'trx-addons/categories-list', props ), props )
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
		'trx-addons/categories-list'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
