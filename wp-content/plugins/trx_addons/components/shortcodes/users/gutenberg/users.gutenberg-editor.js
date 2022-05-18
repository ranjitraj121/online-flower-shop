(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Rrecent Posts
	blocks.registerBlockType(
		'trx-addons/users',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Widget: Users list' ),
			description: i18n.__( "List of registered users" ),
			icon: 'list-view',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{				
					title: {
						type: 'string',
						default: ''
					},
					type: {
						type: 'string',
						default: 'default'
					},
					roles: {
						type: 'string',
						default: 'author'
					},
					number: {
						type: 'number',
						default: 3
					},
					columns: {
						type: 'number',
						default: 0
					}
				},
				trx_addons_gutenberg_get_param_slider(),
				trx_addons_gutenberg_get_param_title(),
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/users' ),
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
								// Style
								{
									'name': 'type',
									'title': i18n.__( 'Style' ),
									'descr': i18n.__( "Select the style to display a users list" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_users'] )
								},
								// Roles
								{
									'name': 'roles',
									'title': i18n.__( 'Roles to display' ),
									'descr': i18n.__( "Roles to display" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_users_roles'] )
								},
								// Number posts to show
								{
									'name': 'number',
									'title': i18n.__( 'Number of posts to display' ),
									'descr': i18n.__( "How many posts display in the widget?" ),
									'type': 'number',
									'min': 1
								},
								// Columns number
								{
									'name': 'columns',
									'title': i18n.__( 'Columns' ),
									'descr': i18n.__( "Specify the number of columns. If left empty or assigned the value '0' - auto detect by the number of items." ),
									'type': 'number',
									'min': 0
								}
							], 'trx-addons/users', props ), props )
						),
						'additional_params': el(
							'div', {},
							// Slider params
							trx_addons_gutenberg_add_param_slider( props ),
							// Title params
							trx_addons_gutenberg_add_param_title( props, true ),
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
		'trx-addons/users'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
