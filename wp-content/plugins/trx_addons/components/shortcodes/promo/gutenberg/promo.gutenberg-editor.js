(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Promo
	blocks.registerBlockType(
		'trx-addons/promo',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Promo' ),
			description: i18n.__( "Insert promo block" ),
			icon: 'format-image',
			category: 'trx-addons-blocks',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					icon: {
						type: 'string',
						default: ''
					},
					icon_color: {
						type: 'string',
						default: ''
					},				
					text_bg_color: {
						type: 'string',
						default: ''
					},				
					image: {
						type: 'number',
						default: 0
					},
					image_url: {
						type: 'string',
						default: ''
					},
					image_bg_color: {
						type: 'string',
						default: ''
					},
					image_cover: {
						type: 'boolean',
						default: true
					},
					image_position: {
						type: 'string',
						default: 'left'
					},
					image_width: {
						type: 'string',
						default: '50%'
					},
					video_url: {
						type: 'string',
						default: ''
					},
					video_embed: {
						type: 'string',
						default: ''
					},
					video_in_popup: {
						type: 'boolean',
						default: false
					},
					size: {
						type: 'string',
						default: 'normal'
					},
					full_height: {
						type: 'boolean',
						default: false
					},
					text_width: {
						type: 'string',
						default: 'none'
					},
					text_float: {
						type: 'string',
						default: 'none'
					},
					text_align: {
						type: 'string',
						default: 'none'
					},
					text_paddings: {
						type: 'boolean',
						default: false
					},
					text_margins: {
						type: 'string',
						default: ''
					},
					gap: {
						type: 'string',
						default: ''
					}
				},
				trx_addons_gutenberg_get_param_title(),
				trx_addons_gutenberg_get_param_button(),
				trx_addons_gutenberg_get_param_button2(),
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/promo' ),
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
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_promo'] )
								},
								// Icon
								{
									'name': 'icon',
									'title': i18n.__( 'Icon' ),
									'descr': i18n.__( "Select icon from library" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_option_icons_classes()
								},
								// Icon color
								{
									'name': 'icon_color',
									'title': i18n.__( 'Icon color' ),
									'descr': i18n.__( "Select icon color" ),
									'type': 'color'
								},
								// Text bg color
								{
									'name': 'text_bg_color',
									'title': i18n.__( 'Text bg color' ),
									'descr': i18n.__( "Select custom color, used as background of the text area" ),
									'type': 'color'
								},
								// Image
								{
									'name': 'image',
									'name_url': 'image_url',
									'title': i18n.__( 'Image' ),
									'descr': i18n.__( "Select the promo image from the library for this section. Show slider if you select 2+ images" ),
									'type': 'image'
								},
								// Image bg color
								{
									'name': 'image_bg_color',
									'title': i18n.__( 'Image bg color' ),
									'descr': i18n.__( "Select custom color, used as background of the image" ),
									'type': 'color'
								},
								// Image cover area
								{
									'name': 'image_cover',
									'title': i18n.__( 'Image cover area' ),
									'descr': i18n.__( "Fit an image into the area or cover it." ),
									'type': 'boolean',
								},
								// Image position
								{
									'name': 'image_position',
									'title': i18n.__( 'Image position' ),
									'descr': i18n.__( "Place the image to the left or to the right from the text block" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_promo_positions'] ),
								},
								// Image width
								{
									'name': 'image_width',
									'title': i18n.__( 'Image width' ),
									'descr': i18n.__( "Specify width of the image. If left empty or assigned the value '0', the columns will be equal." ),
									'type': 'text',
								},
								// Video URL
								{
									'name': 'video_url',
									'title': i18n.__( 'Video URL' ),
									'descr': i18n.__( "Enter link to the video (Note: read more about available formats at WordPress Codex page)" ),
									'type': 'text',
								},
								// Video embed code
								{
									'name': 'video_embed',
									'title': i18n.__( 'Video embed code' ),
									'descr': i18n.__( "or paste the HTML code to embed video in this block" ),
									'type': 'text',
								},
								// Video in the popup
								{
									'name': 'video_in_popup',
									'title': i18n.__( 'Video in the popup' ),
									'descr': i18n.__( "Open video in the popup window or insert it instead the cover image" ),
									'type': 'boolean',
								},
								// Size
								{
									'name': 'size',
									'title': i18n.__( 'Size' ),
									'descr': i18n.__( "Size of the promo block: normal - one in the row, tiny - only image and title, small - insize two or greater columns, large - fullscreen height" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_promo_sizes'] ),
								},
								// Full height
								{
									'name': 'full_height',
									'title': i18n.__( 'Full height' ),
									'descr': i18n.__( "Stretch the height of the element to the full screen's height" ),
									'type': 'boolean',
								},
								// Text width
								{
									'name': 'text_width',
									'title': i18n.__( 'Text width' ),
									'descr': i18n.__( "Select width of the text block" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_promo_widths'] ),
								},
								// Text block floating
								{
									'name': 'text_float',
									'title': i18n.__( 'Text block floating' ),
									'descr': i18n.__( "Select alignment (floating position) of the text block" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] ),
								},
								// Text alignment
								{
									'name': 'text_align',
									'title': i18n.__( 'Text alignment' ),
									'descr': i18n.__( "Align text to the left or to the right side inside the block" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] ),
								},
								// Text paddings
								{
									'name': 'text_paddings',
									'title': i18n.__( 'Text paddings' ),
									'descr': i18n.__( "Add horizontal paddings from the text block" ),
									'type': 'boolean',
								},
								// Text margins
								{
									'name': 'text_margins',
									'title': i18n.__( 'Text margins' ),
									'descr': i18n.__( "Margins for the all sides of the text block (Example: 30px 10px 40px 30px = top right botton left OR 30px = equal for all sides)" ),
									'type': 'text',
								},
								// Gap
								{
									'name': 'gap',
									'title': i18n.__( 'Gaps' ),
									'descr': i18n.__( "Gap between text and image (in percent)" ),
									'type': 'text',
								}
							], 'trx-addons/promo', props ), props )
						),
						'additional_params': el(
							'div', {},
							// Title params
							trx_addons_gutenberg_add_param_title( props, true, true ),
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
		'trx-addons/promo'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );