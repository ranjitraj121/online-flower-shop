(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Form
	blocks.registerBlockType(
		'trx-addons/form',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Form' ),
			description: i18n.__( "Insert simple or detailed form" ),
			icon: 'email-alt',
			category: 'trx-addons-blocks',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					style: {
						type: 'string',
						default: 'inherit'
					},
					align: {
						type: 'string',
						default: 'default'
					},
					email: {
						type: 'string',
						default: ''
					},
					phone: {
						type: 'string',
						default: ''
					},
					address: {
						type: 'string',
						default: ''
					},
					button_caption: {
						type: 'string',
						default: ''
					},
					labels: {
						type: 'boolean',
						default: false
					}
				},
				trx_addons_gutenberg_get_param_title(),
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/form' ),
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
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_form'] )
								},
								// Style
								{
									'name': 'style',
									'title': i18n.__( 'Style' ),
									'descr': i18n.__( "Select input's style" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['input_hover'] )
								},
								// Fields alignment
								{
									'name': 'align',
									'title': i18n.__( 'Fields alignment' ),
									'descr': i18n.__( "Select alignment of the field's text" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] )
								},
								// Your E-mail
								{
									'name': 'email',
									'title': i18n.__( 'Your E-mail' ),
									'descr': i18n.__( "Specify your E-mail for the detailed form. This address will be used to send you filled form data. If empty - admin e-mail will be used" ),
									'type': 'text'
								},
								// Your phone
								{
									'name': 'phone',
									'title': i18n.__( 'Your phone' ),
									'descr': i18n.__( "Specify your phone for the detailed form" ),
									'type': 'text',
									'dependency': {
										'type': ['modern', 'detailed']
									}
								},
								// Your address
								{
									'name': 'address',
									'title': i18n.__( 'Your address' ),
									'descr': i18n.__( "Specify your address for the detailed form" ),
									'type': 'text',
									'dependency': {
										'type1': ['modern', 'detailed']
									}
								},
								// Button caption
								{
									'name': 'button_caption',
									'title': i18n.__( 'Button caption' ),
									'descr': i18n.__( 'Caption of the "Send" button' ),
									'type': 'text'
								},
								// Field labels
								{
									'name': 'labels',
									'title': i18n.__( 'Field labels' ),
									'descr': i18n.__( "Show field's labels" ),
									'type': 'boolean'
								}
							], 'trx-addons/form', props ), props )
						),
						'additional_params': el(
							'div', {},
							// Title params
							trx_addons_gutenberg_add_param_title( props, false ),
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
		'trx-addons/form'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
