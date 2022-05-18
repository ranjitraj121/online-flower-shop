(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Slider
	blocks.registerBlockType(
		'trx-addons/slider',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Widget: Slider' ),
			description: i18n.__( "Insert slider " ),
			icon: 'images-alt',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', trx_addons_object_merge(
				{
					title: {
						type: 'string',
						default: ''
					},
					engine: {
						type: 'string',
						default: 'swiper'
					},
					slider_id: {
						type: 'string',
						default: ''
					},
					slider_style: {
						type: 'string',
						default: 'default'
					},
					slides_per_view: {
						type: 'number',
						default: 1
					},
					slides_space: {
						type: 'number',
						default: 0
					},
					slides_type: {
						type: 'string',
						default: 'bg'
					},
					slides_ratio: {
						type: 'string',
						default: '16:9'
					},
					slides_centered: {
						type: 'boolean',
						default: false
					},
					slides_overflow: {
						type: 'boolean',
						default: false
					},
					autoplay: {
						type: 'boolean',
						default: true
					},
					loop: {
						type: 'boolean',
						default: true
					},
					mouse_wheel: {
						type: 'boolean',
						default: false
					},
					free_mode: {
						type: 'boolean',
						default: false
					},
					noswipe: {
						type: 'boolean',
						default: false
					},
					noresize: {
						type: 'boolean',
						default: false
					},
					effect: {
						type: 'string',
						default: 'slide'
					},
					height: {
						type: 'string',
						default: ''
					},
					alias: {
						type: 'string',
						default: ''
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
						default: '0'
					},
					posts: {
						type: 'number',
						default: 5
					},
					speed: {
						type: 'number',
						default: 600
					},
					interval: {
						type: 'number',
						default: 7000
					},
					titles: {
						type: 'string',
						default: 'center'
					},
					large: {
						type: 'boolean',
						default: false
					},
					controls: {
						type: 'boolean',
						default: false
					},
					controls_pos: {
						type: 'string',
						default: 'side'
					},
					label_prev: {
						type: 'string',
						default: i18n.__( 'Prev|PHOTO' )
					},
					label_next: {
						type: 'string',
						default: i18n.__( 'Next|PHOTO' )
					},
					pagination: {
						type: 'boolean',
						default: false
					},
					pagination_type: {
						type: 'string',
						default: 'bullets'
					},
					pagination_pos: {
						type: 'string',
						default: 'bottom'
					},
					direction: {
						type: 'string',
						default: 'horizontal'
					},
					slides: {
						type: 'string',
						default: ''
					},
					// Controller (TOC)
					controller: {
						type: 'boolean',
						default: false
					},
					controller_style: {
						type: 'string',
						default: 'default'
					},
					controller_pos: {
						type: 'string',
						default: 'right'
					},
					controller_controls: {
						type: 'boolean',
						default: false
					},
/*
					controller_effect: {
						type: 'string',
						default: 'slide'
					},
*/
					controller_per_view: {
						type: 'number',
						default: 3
					},
					controller_space: {
						type: 'number',
						default: 0
					},
					controller_height: {
						type: 'string',
						default: ''
					},
					// Reload block - hidden option
					reload: {
						type: 'string'
					}
				},
				trx_addons_gutenberg_get_param_id()
			), 'trx-addons/slider' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'render_button': true,
						'parent': true,
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Widget title
								{
									'name': 'title',
									'title': i18n.__( 'Widget title' ),
									'type': 'text'
								},
								// Slider engine
								{
									'name': 'engine',
									'title': i18n.__( 'Slider engine' ),
									'descr': i18n.__( "Select engine to show slider" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sliders_list'] )
								},
								// RevSlider alias
								{
									'name': 'alias',
									'title': i18n.__( 'RevSlider alias' ),
									'descr': i18n.__( "Select previously created Revolution slider" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['list_revsliders'] ),
									'dependency': {
										'engine': ['revo']
									}
								},
								// Swiper style
								{
									'name': 'slider_style',
									'title': i18n.__( 'Swiper style' ),
									'descr': i18n.__( "Select style of the Swiper slider" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_slider'] ),
									'dependency': {
										'engine': ['swiper']
									}
								},
								// Slider height
								{
									'name': 'height',
									'title': i18n.__( "Slider height" ),
									'descr': i18n.__( "Initial height of the slider. If empty - calculate from width and aspect ratio" ),
									'type': 'text',
									'dependency': {
										'noresize': [true]
									}
								},
								// Swiper effect
								{
									'name': 'effect',
									'title': i18n.__( 'Swiper effect' ),
									'descr': i18n.__( "Select slides effect of the Swiper slider" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_effects'] ),
									'dependency': {
										'engine': ['swiper']
									}
								},
								// Direction
								{
									'name': 'direction',
									'title': i18n.__( 'Direction' ),
									'descr': i18n.__( "Select direction to change slides" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_directions'] ),
									'dependency': {
										'engine': ['swiper'],
										'effect': ['slide']
									}
								},
								// Slides per view in the Swiper
								{
									'name': 'slides_per_view',
									'title': i18n.__( 'Slides per view in the Swiper' ),
									'descr': i18n.__( "Specify slides per view in the Swiper" ),
									'type': 'number',
									'min': 1,
									'max': 6,
									'dependency': {
										'engine': ['swiper'],
										'effect': ['slide', 'coverflow', 'swap']
									}
								},
								// Space between slides in the Swiper
								{
									'name': 'slides_space',
									'title': i18n.__( 'Space between slides in the Swiper' ),
									'type': 'number',
									'min': 0,
									'max': 100,
									'dependency': {
										'engine': ['swiper'],
										'effect': ['slide', 'coverflow', 'swap']
									}
								},

								// Post type
								{
									'name': 'post_type',
									'title': i18n.__( 'Post type' ),
									'descr': i18n.__( "Select post type to get featured images from the posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['posts_types'] ),
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								},
								// Taxonomy
								{
									'name': 'taxonomy',
									'title': i18n.__( 'Taxonomy' ),
									'descr': i18n.__( "Select taxonomy to get featured images from the posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['taxonomies'][props.attributes.post_type], true ),
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								},
								// Category
								{
									'name': 'category',
									'title': i18n.__( 'Category' ),
									'descr': i18n.__( "Select category to get featured images from the posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['categories'][props.attributes.taxonomy] ),
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								},
								// Posts number
								{
									'name': 'posts',
									'title': i18n.__( 'Posts number' ),
									'descr': i18n.__( "Number of posts or comma separated post's IDs to show images" ),
									'type': 'number',
									'min': 1,
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								},

								// Controls
								{
									'name': 'controls',
									'title': i18n.__( 'Controls' ),
									'descr': i18n.__( "Do you want to show arrows to change slides?" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								},
								// Controls position
								{
									'name': 'controls_pos',
									'title': i18n.__( 'Controls position' ),
									'descr': i18n.__( "Select controls position" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_controls'] ),
									'dependency': {
										'engine': ['swiper'],
										'controls': [true]
									}
								},
								// Prev Slide
								{
									'name': 'label_prev',
									'title': i18n.__( 'Prev Slide' ),
									'descr': i18n.__( "Label of the 'Prev Slide' button in the Swiper (Modern style). Use '|' to break line" ),
									'type': 'text',
									'dependency': {
										'slider_style': ['modern'],
										'controls': [true]
									}
								},
								// Next Slide
								{
									'name': 'label_next',
									'title': i18n.__( 'Next Slide' ),
									'descr': i18n.__( "Label of the 'Next Slide' button in the Swiper (Modern style). Use '|' to break line" ),
									'type': 'text',
									'dependency': {
										'slider_style': ['modern'],
										'controls': [true]
									}
								},

								// Pagination
								{
									'name': 'pagination',
									'title': i18n.__( 'Pagination' ),
									'descr': i18n.__( "Do you want to show bullets to change slides?" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper']
									}
								},
								// Pagination type
								{
									'name': 'pagination_type',
									'title': i18n.__( 'Pagination type' ),
									'descr': i18n.__( "Select type of the pagination" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_paginations_types'] ),
									'dependency': {
										'pagination': [true]
									}
								},
								// Pagination position
								{
									'name': 'pagination_pos',
									'title': i18n.__( 'Pagination position' ),
									'descr': i18n.__( "Select pagination position" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_paginations'] ),
									'dependency': {
										'pagination': [true]
									}
								},

								// Disable swipe
								{
									'name': 'noswipe',
									'title': i18n.__( 'Disable swipe' ),
									'descr': i18n.__( "Disable swipe guestures" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper']
									}
								},

								// Enable mouse wheel
								{
									'name': 'mouse_wheel',
									'title': i18n.__( 'Enable mouse wheel' ),
									'descr': i18n.__( "Enable mouse wheel to control slidest" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper']
									}
								},

								// Enable free mode
								{
									'name': 'free_mode',
									'title': i18n.__( 'Enable free mode' ),
									'descr': i18n.__( "Free mode - slides will not have fixed positions" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper']
									}
								},

								// Enable loop
								{
									'name': 'loop',
									'title': i18n.__( 'Enable loop mode' ),
									'descr': i18n.__( "Enable loop mode for this slider" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper']
									}
								},

								// Enable autoplay
								{
									'name': 'autoplay',
									'title': i18n.__( 'Enable autoplay' ),
									'descr': i18n.__( "Enable autoplay for this slider" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper']
									}
								},
								// Slides change speed in the Swiper
								{
									'name': 'speed',
									'title': i18n.__( 'Slides change speed' ),
									'descr': i18n.__( "Specify slides change speed in the Swiper" ),
									'type': 'number',
									'min': 300,
									'max': 3000,
									'dependency': {
										'engine': ['swiper']
									}
								},
								// Interval between slides in the Swiper
								{
									'name': 'interval',
									'title': i18n.__( 'Interval between slides in the Swiper' ),
									'descr': i18n.__( "Specify interval between slides change in the Swiper" ),
									'type': 'number',
									'min': 0,
									'max': 10000,
									'dependency': {
										'engine': ['swiper']
									}
								},

								// No resize slide's content
								{
									'name': 'noresize',
									'title': i18n.__( "No resize slide's content" ),
									'descr': i18n.__( "Disable resize slide's content, stretch images to cover slide" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								},

								// Type of the slides content
								{
									'name': 'slides_type',
									'title': i18n.__( 'Type of the slides content' ),
									'descr': i18n.__( "Use images from slides as background (default) or insert it as tag inside each slide" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['slides_type'] ),
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								},
								// Slides ratio
								{
									'name': 'slides_ratio',
									'title': i18n.__( "Slides ratio" ),
									'descr': i18n.__( "Ratio to resize slides on tabs and mobile. If empty - 16:9" ),
									'type': 'text',
									'dependency': {
										'noresize': [false]
									}
								},
								// Slides centered
								{
									'name': 'slides_centered',
									'title': i18n.__( 'Slides centered' ),
									'descr': i18n.__( "Center active slide" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper']
									}
								},
								// Slides overflow visible
								{
									'name': 'slides_overflow',
									'title': i18n.__( 'Slides overflow visible' ),
									'descr': i18n.__( "Don't hide slides outside the borders of the viewport" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper']
									}
								},
								// Titles in the Swiper
								{
									'name': 'titles',
									'title': i18n.__( 'Titles in the slides' ),
									'descr': i18n.__( "Show post's titles and categories on the slides" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_titles'] ),
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								},
								// Large titles
								{
									'name': 'large',
									'title': i18n.__( 'Large titles' ),
									'descr': i18n.__( "Do you want use large titles?" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								},

								// Controller (TOC)
								{
									'name': 'controller',
									'title': i18n.__( 'Table of contents' ),
									'descr': '',
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper']
									}
								},
								{
									'name': 'controller_style',
									'title': i18n.__( 'Style of the TOC' ),
									'descr': '',
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_toc_styles'] ),
									'dependency': {
										'controller': [true]
									}
								},
								{
									'name': 'controller_pos',
									'title': i18n.__( 'Position of the TOC' ),
									'descr': '',
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_toc_positions'] ),
									'dependency': {
										'controller': [true]
									}
								},
								{
									'name': 'controller_controls',
									'title': i18n.__( 'Show arrows' ),
									'descr': '',
									'type': 'boolean',
									'dependency': {
										'controller': [true]
									}
								},
								{
									'name': 'controller_effect',
									'title': i18n.__( 'Effect for change items' ),
									'descr': '',
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_slider_effects'] ),
									'dependency': {
										'controller': [true]
									}
								},
								{
									'name': 'controller_per_view',
									'title': i18n.__( 'Items per view' ),
									'descr': '',
									'type': 'number',
									'min': 1,
									'max': 10,
									'dependency': {
										'controller': [true],
										'controller_effect': ['slide','coverflow', 'swap']
									}
								},
								{
									'name': 'controller_space',
									'title': i18n.__( 'Space between items' ),
									'type': 'number',
									'min': 0,
									'max': 100,
									'dependency': {
										'controller': [true]
									}
								},
								{
									'name': 'controller_height',
									'title': i18n.__( "Height of the TOC" ),
									'descr': '',
									'type': 'text',
									'dependency': {
										'controller': [true],
										'controller_pos': ['bottom']
									}
								}
							], 'trx-addons/slider', props ), props )
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
				props.attributes.slides = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
			},
		},
		'trx-addons/slider'
	) );

	// Register block Slider Item
	blocks.registerBlockType(
		'trx-addons/slider-item',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Slide' ),
			description: i18n.__( "Select icons, specify title and/or description for each item" ),
			icon: 'images-alt',
			category: 'trx-addons-widgets',
			parent: ['trx-addons/slider'],
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', {
				title: {
					type: 'string',
					default: ''
				},
				subtitle: {
					type: 'string',
					default: ''
				},
				link: {
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
				video_url: {
					type: 'string',
					default: ''
				},
				video_embed: {
					type: 'string',
					default: ''
				},
				className: {
					type: 'string',
					default: ''
				}
			}, 'trx-addons/slider-item' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'title': i18n.__( 'Slide' ) + (props.attributes.title ? ': ' + props.attributes.title : ''),
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Title
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'descr': i18n.__( "Enter title of the item" ),
									'type': 'text'
								},
								// Subtitle
								{
									'name': 'subtitle',
									'title': i18n.__( 'Subtitle' ),
									'descr': i18n.__( "Enter subtitle of the item" ),
									'type': 'text'
								},
								// Link
								{
									'name': 'link',
									'title': i18n.__( 'Link' ),
									'descr': i18n.__( "URL to link this item" ),
									'type': 'text'
								},
								// Image
								{
									'name': 'image',
									'name_url': 'image_url',
									'title': i18n.__( 'Image' ),
									'descr': i18n.__( "Select or upload image or specify URL from other site to use it as icon" ),
									'type': 'image'
								},
								// Video URL
								{
									'name': 'video_url',
									'title': i18n.__( 'Video URL' ),
									'descr': i18n.__( "Enter link to the video (Note: read more about available formats at WordPress Codex page)" ),
									'type': 'text'
								},
								// Video embed code
								{
									'name': 'video_embed',
									'title': i18n.__( 'Video embed code' ),
									'descr': i18n.__( "or paste the HTML code to embed video in this slide" ),
									'type': 'textarea'
								}
							], 'trx-addons/slider-item', props ), props )
						)
					}, props
				);
			},
			save: function(props) {
				return el( '', null );
			}
		},
		'trx-addons/slider-item'
	) );

	// Register Block - Slider Controller
	blocks.registerBlockType(
		'trx-addons/slider-controller',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Slider Controller' ),
			description: i18n.__( "Insert slider controller" ),
			icon: 'images-alt',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', {
				slider_id: {
					type: 'string',
					default: ''
				},
				height: {
					type: 'string',
					default: ''
				},
				controls: {
					type: 'boolean',
					default: false
				},
				controller_style: {
					type: 'string',
					default: 'thumbs'
				},
				effect: {
					type: 'string',
					default: 'slide'
				},
				direction: {
					type: 'string',
					default: 'horizontal'
				},
				slides_per_view: {
					type: 'number',
					default: 1
				},
				slides_space: {
					type: 'number',
					default: 0
				},
				interval: {
					type: 'number',
					default: 7000
				},
				// ID, Class, CSS attributes
				id: {
					type: 'string',
					default: ''
				},
				class: {
					type: 'string',
					default: ''
				},
				className: {
					type: 'string',
					default: ''
				},
				css: {
					type: 'string',
					default: ''
				}
			}, 'trx-addons/slider-controller' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Controlled Slider ID
								{
									'name': 'slider_id',
									'title': i18n.__( 'Slave slider ID' ),
									'descr': i18n.__( "ID of the controlled slider" ),
									'type': 'text'
								},
								// Slider height
								{
									'name': 'height',
									'title': i18n.__( "Slider height" ),
									'descr': i18n.__( "Initial height of the slider. If empty - calculate from width and aspect ratio" ),
									'type': 'text'
								},
								// Controls
								{
									'name': 'controls',
									'title': i18n.__( 'Controls' ),
									'descr': i18n.__( "Do you want to show arrows to change slides?" ),
									'type': 'boolean'
								},
								// Controller style
								{
									'name': 'controller_style',
									'title': i18n.__( 'Style' ),
									'descr': i18n.__( "Select style of the Controller" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_controller_styles'] )
								},
								// Swiper effect
								{
									'name': 'effect',
									'title': i18n.__( 'Effect' ),
									'descr': i18n.__( "Select slides effect of the controller slider" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_effects'] )
								},
								// Direction
								{
									'name': 'direction',
									'title': i18n.__( 'Direction' ),
									'descr': i18n.__( "Select direction to change slides" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_directions'] ),
									'dependency': {
										'effect': ['slide']
									}
								},
								// Slides per view in the Swiper
								{
									'name': 'slides_per_view',
									'title': i18n.__( 'Slides per view' ),
									'descr': i18n.__( "Specify slides per view in the Swiper" ),
									'type': 'number',
									'min': 1,
									'max': 6,
									'dependency': {
										'effect': ['slide', 'coverflow']
									}
								},
								// Space between slides in the Swiper
								{
									'name': 'slides_space',
									'title': i18n.__( 'Space between slides' ),
									'type': 'number',
									'min': 0,
									'max': 100,
									'dependency': {
										'effect': ['slide', 'coverflow']
									}
								},
								// Interval between slides in the Swiper
								{
									'name': 'interval',
									'title': i18n.__( 'Interval between slides change' ),
									'descr': i18n.__( "Specify interval between slides change" ),
									'type': 'number',
									'min': 0,
									'min': 10000
								}
							], 'trx-addons/slider-controller', props ), props )
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
			},
		},
		'trx-addons/slider-controller'
	) );

	// Register Block - Slider Controls
	blocks.registerBlockType(
		'trx-addons/slider-controls',
		trx_addons_apply_filters( 'trx_addons_gb_map', {
			title: i18n.__( 'Slider Controls' ),
			description: i18n.__( "Insert slider controls" ),
			icon: 'images-alt',
			category: 'trx-addons-widgets',
			attributes: trx_addons_apply_filters( 'trx_addons_gb_map_get_params', {
				slider_id: {
					type: 'string',
					default: ''
				},
				controls_style: {
					type: 'string',
					default: 'default'
				},
				align: {
					type: 'string',
					default: 'left'
				},
				hide_prev: {
					type: 'boolean',
					default: false
				},
				title_prev: {
					type: 'string',
					default: ''
				},
				hide_next: {
					type: 'boolean',
					default: false
				},
				title_next: {
					type: 'string',
					default: ''
				},
				pagination_style: {
					type: 'string',
					default: 'none'
				},
				// ID, Class, CSS attributes
				id: {
					type: 'string',
					default: ''
				},
				class: {
					type: 'string',
					default: ''
				},
				className: {
					type: 'string',
					default: ''
				},
				css: {
					type: 'string',
					default: ''
				}
			}, 'trx-addons/slider-controls' ),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'general_params': el(
							'div', {}, trx_addons_gutenberg_add_params( trx_addons_apply_filters( 'trx_addons_gb_map_add_params', [
								// Controlled Slider ID
								{
									'name': 'slider_id',
									'title': i18n.__( 'Slave slider ID' ),
									'descr': i18n.__( "ID of the controlled slider" ),
									'type': 'text'
								},
								// Controls style
								{
									'name': 'controls_style',
									'title': i18n.__( 'Style' ),
									'descr': i18n.__( "Select style of the Controls" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_controls_styles'] )
								},
								// Alignment
								{
									'name': 'align',
									'title': i18n.__( 'Alignment' ),
									'descr': i18n.__( "Select alignment of the arrows" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns_short'] )
								},
								// Hide 'Prev'
								{
									'name': 'hide_prev',
									'title': i18n.__( "Hide 'Prev'" ),
									'descr': i18n.__( "Hide the button 'Prev'" ),
									'type': 'boolean'
								},
								// Title 'Prev'
								{
									'name': 'title_prev',
									'title': i18n.__( "Title 'Prev'" ),
									'descr': i18n.__( "Title of the button 'Prev'" ),
									'type': 'text'
								},
								// Hide 'Next'
								{
									'name': 'hide_next',
									'title': i18n.__( "Hide 'Next'" ),
									'descr': i18n.__( "Hide the button 'Next'" ),
									'type': 'boolean'
								},
								// Title 'Next'
								{
									'name': 'title_next',
									'title': i18n.__( "Title 'Next'" ),
									'descr': i18n.__( "Title of the button 'Next'" ),
									'type': 'text'
								},
								// Pagination
								{
									'name': 'pagination_style',
									'title': i18n.__( 'Show pagination' ),
									'descr': i18n.__( "Select pagination style of the controls" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_controls_paginations_types'] )
								}
							], 'trx-addons/slider-controls', props ), props )
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
			},
		},
		'trx-addons/slider-controls'
	) );
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
