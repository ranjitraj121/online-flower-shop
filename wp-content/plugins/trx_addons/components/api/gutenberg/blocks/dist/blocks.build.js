// Return query params
//-------------------------------------------
function trx_addons_gutenberg_get_param_query( add_params ) {

	"use strict";

	if ( add_params === undefined ) {
		add_params = {};
	}

	var params = trx_addons_apply_filters(
					'trx_addons_gb_map_get_params',
					{
						// Query attributes
						ids: {
							'type': 'string',
							'default': ''
						},
						count: {
							'type': 'number',
							'default': 2
						},
						columns: {
							'type': 'number',
							'default': 2
						},
						offset: {
							'type': 'number',
							'default': 0
						},
						orderby: {
							'type': 'string',
							'default': 'none'
						},
						order: {
							'type': 'string',
							'default': 'asc'
						}
					},
					'common/query'
				);
	for (var prop in add_params) {
		if ( add_params.hasOwnProperty(prop) ) {
			if ( add_params[prop] === false ) {
				if ( params.hasOwnProperty(prop) ) {
					delete params[prop];
				}
			} else {
				params[prop] = add_params[prop];
			}
		}
	}	
	return params;
}

function trx_addons_gutenberg_add_param_query(props, add_params) {

	"use strict";

	if ( add_params === undefined ) {
		add_params = {};
	}

	var el     = window.wp.element.createElement;
	var i18n   = window.wp.i18n;
	var params = trx_addons_apply_filters(
					'trx_addons_gb_map_add_params',
					[
						// IDs to show
						{
							'name': 'ids',
							'title': i18n.__( "IDs to show" ),
							'descr': i18n.__( "Comma separated list of IDs to display. If not empty, parameters 'cat', 'offset' and 'count' are ignored!" ),
							'type': 'text'
						},
						// Count
						{
							'name': 'count',
							'title': i18n.__( "Count" ),
							'descr': i18n.__( "The number of displayed posts. If IDs are used, this parameter is ignored." ),
							'type': 'number',
							'min': 1,
							'dependency': {
								'ids': ['']
							}
						},
						// Columns
						add_params.hasOwnProperty( 'columns' ) && add_params['columns'] === false
							? null
							: {
								'name': 'columns',
								'title': i18n.__( "Columns" ),
								'descr': i18n.__( "Specify the number of columns. If left empty or assigned the value '0' - auto detect by the number of items." ),
								'type': 'number',
								'min': 1,
								'max': 6
								},
						// Offset
						{
							'name': 'offset',
							'title': i18n.__( "Offset" ),
							'descr': i18n.__( "Specify the number of items to be skipped before the displayed items." ),
							'type': 'number',
							'min': 0,
							'dependency': {
								'ids': ['']
							}
						},
						// Order by
						{
							'name': 'orderby',
							'title': i18n.__( "Order by" ),
							'descr': i18n.__( "Select how to sort the posts" ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_query_orderby'] )
						},
						// Order
						{
							'name': 'order',
							'title': i18n.__( "Order" ),
							'descr': i18n.__( "Select sort order" ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_query_orders'] )
						}
					],
					'common/query',
					props
				);
	return el( wp.element.Fragment, {},
				el( wp.editor.InspectorControls, {},
					el( wp.components.PanelBody, { title: i18n.__( "Query" ) },
						el( 'div', {},
							trx_addons_gutenberg_add_params( params, props )
						)
					)
				)
			);
}



// Return filters params
//-------------------------------------------
function trx_addons_gutenberg_get_param_filters() {

	"use strict";

	var i18n   = window.wp.i18n;

	return trx_addons_apply_filters(
			'trx_addons_gb_map_get_params',
			{
				// Filters
				show_filters: {
					'type': 'boolean',
					'default': false
				},
				filters_tabs_position: {
					'type': 'string',
					'default': 'top'
				},
				filters_tabs_on_hover: {
					'type': 'boolean',
					'default': false
				},
				filters_title: {
					'type': 'string',
					'default': ''
				},
				filters_subtitle: {
					'type': 'string',
					'default': ''
				},
				filters_title_align: {
					'type': 'string',
					'default': 'left'
				},
				filters_taxonomy: {
					'type': 'string',
					'default': 'category'
				},
				filters_ids: {
					'type': 'string',
					'default': ''
				},
				filters_all: {
					'type': 'boolean',
					'default': true
				},
				filters_all_text: {
					'type': 'string',
					'default': i18n.__( 'All' )
				},
				filters_more_text: {
					'type': 'string',
					'default': i18n.__( 'More posts' )
				}
			},
			'common/filters'
		);
}

function trx_addons_gutenberg_add_param_filters(props) {
	
	"use strict";
	
	if ( ! TRX_ADDONS_STORAGE['gutenberg_sc_params']['taxonomies'][props.attributes.post_type].hasOwnProperty( props.attributes.filters_taxonomy ) ) {
		props.attributes.filters_taxonomy = 0;
	}
	
	var el     = window.wp.element.createElement;
	var i18n   = window.wp.i18n;
	var params = trx_addons_apply_filters(
					'trx_addons_gb_map_add_params',
					[
						// Filters title
						{
							'name': 'filters_title',
							'title': i18n.__( 'Filters area title' ),
							'descr': '',
							'type': 'text'
						},
						// Filters subtitle
						{
							'name': 'filters_subtitle',
							'title': i18n.__( 'Filters area subtitle' ),
							'descr': '',
							'type': 'text'
						},
						// Filters alignment
						{
							'name': 'filters_title_align',
							'title': i18n.__( 'Filters titles position' ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns_short'] )
						},
						// Show filters
						{
							'name': 'show_filters',
							'title': i18n.__( 'Show filters tabs' ),
							'type': 'boolean'
						},
						// Filters tabs position
						{
							'name': 'filters_tabs_position',
							'title': i18n.__( 'Filters tabs position' ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_blogger_tabs_positions'] ),
							'dependency': {
								'show_filters': [true]
							}
						},
						// Open tabs on hover
						{
							'name': 'filters_tabs_on_hover',
							'title': i18n.__( 'Open tabs on hover' ),
							'type': 'boolean',
							'dependency': {
								'show_filters': [true]
							}
						},
						// Filters taxonomy
						{
							'name': 'filters_taxonomy',
							'title': i18n.__( 'Filters taxonomy' ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['taxonomies'][props.attributes.post_type], true ),
							'dependency': {
								'show_filters': [true]
							}
						},
						// Filters taxonomy to show
						{
							'name': 'filters_ids',
							'title': i18n.__( 'Filters taxonomy to show' ),
							'descr': i18n.__( "Comma separated list with term IDs or term names to show as filters. If empty - show all terms from filters taxonomy above" ),
							'type': 'text',
							'dependency': {
								'show_filters': [true]
							}
						},
						// Display the "All Filters" tab
						{
							'name': 'filters_all',
							'title': i18n.__( 'Show the "All" tab' ),
							'type': 'boolean',
							'dependency': {
								'show_filters': [true]
							}
						},
						// "All Filters" tab text
						{
							'name': 'filters_all_text',
							'title': i18n.__( '"All" tab text' ),
							'type': 'text',
							'dependency': {
								'show_filters': [true]
							}
						},
						// 'More posts' text
						{
							'name': 'filters_more_text',
							'title': i18n.__( "'More posts' text" ),
							'type': 'text',
							'dependency': {
								'show_filters': [false]
							}
						}
					],
					'common/filters',
					props
				);

	return el( wp.element.Fragment, {},
				el( wp.editor.InspectorControls, {},
					el( wp.components.PanelBody, { title: i18n.__( "Filters" ) },
						el( 'div', {},
							trx_addons_gutenberg_add_params( params, props )
						)
					)
				)
			);
}



// Return slider params
//-------------------------------------------
function trx_addons_gutenberg_get_param_slider() {

	"use strict";

	return trx_addons_apply_filters(
			'trx_addons_gb_map_get_params',
			{
				// Slider attributes
				slider: {
					'type': 'boolean',
					'default': false
				},
				slides_space: {
					'type': 'number',
					'default': 0
				},
				slides_centered: {
					'type': 'boolean',
					'default': false
				},
				slides_overflow: {
					'type': 'boolean',
					'default': false
				},
				slider_mouse_wheel: {
					'type': 'boolean',
					'default': false
				},
				slider_autoplay: {
					'type': 'boolean',
					'default': true
				},
				slider_free_mode: {
					'type': 'boolean',
					'default': false
				},
				slider_loop: {
					'type': 'boolean',
					'default': true
				},
				slider_controls: {
					'type': 'string',
					'default': 'none'
				},
				slider_pagination: {
					'type': 'string',
					'default': 'none'
				},
				slider_pagination_type: {
					'type': 'string',
					'default': 'bullets'
				}
			},
			'common/slider'
		);
}

function trx_addons_gutenberg_add_param_slider(props) {

	"use strict";

	var el     = window.wp.element.createElement;
	var i18n   = window.wp.i18n;
	var params = trx_addons_apply_filters(
					'trx_addons_gb_map_add_params',
					[
						// Slider
						{
							'name': 'slider',
							'title': i18n.__( "Slider" ),
							'descr': i18n.__( "Show items as slider" ),
							'type': 'boolean'
						},
						// Space
						{
							'name': 'slides_space',
							'title': i18n.__( "Space" ),
							'descr': i18n.__( "Space between slides" ),
							'type': 'number',
							'min': 0,
							'max': 50,
							'dependency': {
								'slider': [true]
							}
						},
						// Slides centered
						{
							'name': 'slides_centered',
							'title': i18n.__( "Slides centered" ),
							'descr': i18n.__( "Center active slide" ),
							'type': 'boolean',
							'dependency': {
								'slider': [true]
							}
						},
						// Slides overflow visible
						{
							'name': 'slides_overflow',
							'title': i18n.__( "Slides overflow visible" ),
							'descr': i18n.__( "Don't hide slides outside the borders of the viewport" ),
							'type': 'boolean',
							'dependency': {
								'slider': [true]
							}
						},
						// Enable mouse wheel
						{
							'name': 'slider_mouse_wheel',
							'title': i18n.__( "Enable mouse wheel" ),
							'descr': i18n.__( "Enable mouse wheel to control slides" ),
							'type': 'boolean',
							'dependency': {
								'slider': [true]
							}
						},
						// Enable autoplay
						{
							'name': 'slider_autoplay',
							'title': i18n.__( "Enable autoplay" ),
							'descr': i18n.__( "Enable autoplay for this slider" ),
							'type': 'boolean',
							'dependency': {
								'slider': [true]
							}
						},
						// Enable free mode
						{
							'name': 'slider_free_mode',
							'title': i18n.__( "Enable free mode" ),
							'descr': i18n.__( "Free mode - slides will not have fixed positions" ),
							'type': 'boolean',
							'dependency': {
								'slider': [true]
							}
						},
						// Slider loop
						{
							'name': 'slider_loop',
							'title': i18n.__( "Loop" ),
							'descr': i18n.__( "Enable slider loop" ),
							'type': 'boolean',
							'dependency': {
								'slider': [true],
								'slides_overflow': [false]
							}
						},
						// Slider controls
						{
							'name': 'slider_controls',
							'title': i18n.__( "Slider controls" ),
							'descr': i18n.__( "Show arrows in the slider" ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_controls'] ),
							'dependency': {
								'slider': [true]
							}
						},
						// Slider pagination
						{
							'name': 'slider_pagination',
							'title': i18n.__( "Slider pagination" ),
							'descr': i18n.__( "Show pagination in the slider" ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_paginations'] ),
							'dependency': {
								'slider': [true]
							}
						},
						// Slider pagination type
						{
							'name': 'slider_pagination_type',
							'title': i18n.__( "Slider pagination type" ),
							'descr': i18n.__( "Select type of the pagination in the slider" ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_paginations_types'] ),
							'dependency': {
								'slider': [true],
								'slider_pagination': ['^none']
							}
						}
					],
					'common/slider',
					props
				);

	return el( wp.element.Fragment, {},
				el( wp.editor.InspectorControls, {},
					el( wp.components.PanelBody, { title: i18n.__( "Slider" ) },
						el( 'div', {},
							trx_addons_gutenberg_add_params( params, props )
						)
					)
				)
			);
}



// Return button params
//-------------------------------------------
function trx_addons_gutenberg_get_param_button() {

	"use strict";

	return trx_addons_apply_filters(
			'trx_addons_gb_map_get_params',
			{
				// Button attributes
				link: {
					'type': 'string',
					'default': ''
				},
				link_text: {
					'type': 'string',
					'default': ''
				},
				link_style: {
					'type': 'string',
					'default': ''
				},
				link_image: {
					'type': 'number',
					'default': 0
				},
				link_image_url: {
					'type': 'string',
					'default': ''
				}
			},
			'common/button'
		);
}

function trx_addons_gutenberg_add_param_button(props, return_args) {

	"use strict";

	var el   = window.wp.element.createElement;
	var i18n = window.wp.i18n;
	var attr = props.attributes;
	var params = trx_addons_apply_filters(
					'trx_addons_gb_map_add_params',
					[
						// Button's URL
						{
							'name': 'link',
							'title': i18n.__( "Button's URL" ),
							'descr': i18n.__( "Link URL for the button at the bottom of the block" ),
							'type': 'text'
						},
						// Button's text
						{
							'name': 'link_text',
							'title': i18n.__( "Button's text" ),
							'descr': i18n.__( "Caption for the button at the bottom of the block" ),
							'type': 'text'
						},
						// Button's style
						{
							'name': 'link_style',
							'title': i18n.__( "Button's style" ),
							'descr': i18n.__( "Select the style (layout) of the button" ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_button'] )
						},
						// Button's image
						{
							'name': 'link_image',
							'name_url': 'link_image_url',
							'title': i18n.__( "Button's image" ),
							'descr': i18n.__( "Select the promo image from the library for this button" ),
							'type': 'image'
						}
					],
					'common/button',
					props
				);
	return return_args
				? params
				: el( 'div', {},
						el( 'div', {},
							trx_addons_gutenberg_add_params( params, props )
						)
					);
}



// Return button 2 params
//-------------------------------------------
function trx_addons_gutenberg_get_param_button2() {

	"use strict";

	return trx_addons_apply_filters(
			'trx_addons_gb_map_get_params',
			{
				// Button attributes
				link2: {
					'type': 'string',
					'default': ''
				},
				link2_text: {
					'type': 'string',
					'default': ''
				},
				link2_style: {
					'type': 'string',
					'default': ''
				}
			},
			'common/button2'
		);
}

function trx_addons_gutenberg_add_param_button2( props, return_args ) {

	"use strict";

	var el   = window.wp.element.createElement;
	var i18n = window.wp.i18n;
	var attr = props.attributes;
	var params = trx_addons_apply_filters(
					'trx_addons_gb_map_add_params',
					[
						// Button 2 URL
						{
							'name': 'link2',
							'title': i18n.__( 'Button 2 URL' ),
							'descr': i18n.__( "URL for the second button (at the side of the image)" ),
							'type': 'text',
							'dependency': {
								'type': ['modern']
							}
						},
						// Button 2 text
						{
							'name': 'link2_text',
							'title': i18n.__( 'Button 2 text' ),
							'descr': i18n.__( "Caption for the second button (at the side of the image)" ),
							'type': 'text',
							'dependency': {
								'type': ['modern']
							}
						},
						// Button 2 style
						{
							'name': 'link2_style',
							'title': i18n.__( 'Button 2 style' ),
							'descr': i18n.__( "Select the style (layout) of the second button" ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_button'] ),
							'dependency': {
								'type': ['modern']
							}
						}
					],
					'common/button2',
					props
				);
	return return_args
				? params
				: el( 'div', {},
						el( 'div', {},
							trx_addons_gutenberg_add_params( params, props )
						)
					);
}



// Return title params
//-------------------------------------------
function trx_addons_gutenberg_get_param_title() {

	"use strict";

	return trx_addons_apply_filters(
			'trx_addons_gb_map_get_params',
			{
				// Title attributes
				title_style: {
					'type': 'string',
					'default': ''
				},
				title_tag: {
					'type': 'string',
					'default': ''
				},
				title_align: {
					'type': 'string',
					'default': ''
				},
				title: {
					'type': 'string',
					'default': ''
				},
				title_color: {
					'type': 'string',
					'default': ''
				},
				title_color2: {
					'type': 'string',
					'default': ''
				},
				gradient_direction: {
					'type': 'number',
					'default': 0
				},
				title_border_color: {
					'type': 'string',
					'default': ''
				},
				title_border_width: {
					'type': 'string',
					'default': ''
				},
				title_bg_image: {
					type: 'number',
					default: 0
				},
				title_bg_image_url: {
					type: 'string',
					default: ''
				},
				title2: {
					'type': 'string',
					'default': ''
				},
				title2_color: {
					'type': 'string',
					'default': ''
				},
				title2_border_color: {
					'type': 'string',
					'default': ''
				},
				title2_border_width: {
					'type': 'string',
					'default': ''
				},
				title2_bg_image: {
					type: 'number',
					default: 0
				},
				title2_bg_image_url: {
					type: 'string',
					default: ''
				},
				subtitle: {
					'type': 'string',
					'default': ''
				},
				subtitle_align: {
					'type': 'string',
					'default': 'none'
				},
				subtitle_position: {
					'type': 'string',
					'default': TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_subtitle_position']
				},
				description: {
					'type': 'string',
					'default': ''
				},
				mouse_helper_highlight: {
					'type': 'boolean',
					'default': false
				},
				typed: {
					'type': 'boolean',
					'default': false
				},
				typed_loop: {
					'type': 'boolean',
					'default': true
				},
				typed_cursor: {
					'type': 'boolean',
					'default': true
				},
				typed_strings: {
					'type': 'string',
					'default': ''
				},
				typed_color: {
					'type': 'string',
					'default': ''
				},
				typed_speed: {
					'type': 'number',
					'default': 6
				},
				typed_delay: {
					'type': 'number',
					'default': 1
				}
			},
			'common/title'
		);
}

function trx_addons_gutenberg_add_param_title(props, button, button2) {

	"use strict";

	var el     = window.wp.element.createElement;
	var i18n   = window.wp.i18n;
	var attr   = props.attributes;
	var params = [
						// Title style
						{
							'name': 'title_style',
							'title': i18n.__( 'Title style' ),
							'descr': i18n.__( "Select style of the title and subtitle" ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_title'] )
						},
						// Title tag
						{
							'name': 'title_tag',
							'title': i18n.__( 'Title tag' ),
							'descr': i18n.__( "Select tag (level) of the title" ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_title_tags'] )
						},
						// Title alignment
						{
							'name': 'title_align',
							'title': i18n.__( 'Title alignment' ),
							'descr': i18n.__( "Select alignment of the title, subtitle and description" ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] )
						},
						// Title
						{
							'name': 'title',
							'title': i18n.__( 'Title' ),
							'descr': i18n.__( "Title of the block. Enclose any words in {{ and }} to make them italic or in (( and )) to make them bold. If title style is 'accent' - bolded element styled as shadow, italic - as a filled circle" ),
							'type': 'text'
						},
						// Color
						{
							'name': 'title_color',
							'title': i18n.__( 'Color' ),
							'descr': i18n.__( "Title custom color" ),
							'type': 'color'
						},
						// Color 2
						{
							'name': 'title_color2',
							'title': i18n.__( 'Color 2' ),
							'descr': i18n.__( "Used for gradient." ),
							'type': 'color',
							'dependency': {
								'title_style': ['gradient']
							}
						},
						// Gradient direction
						{
							'name': 'gradient_direction',
							'title': i18n.__( 'Gradient direction' ),
							'descr': i18n.__( "Gradient direction in degress (0 - 360)" ),
							'type': 'number',
							'min': 0,
							'max': 360,
							'step': 1,
							'dependency': {
								'title_style': ['gradient']
							}
						},
						// Border Color
						{
							'name': 'title_border_color',
							'title': i18n.__( 'Border Color' ),
							'descr': i18n.__( "Title border color" ),
							'type': 'color'
						},
						// Border width
						{
							'name': 'title_border_width',
							'title': i18n.__( 'Border width' ),
							'descr': i18n.__( "Title border width (in px)" ),
							'type': 'number',
							'min': 0,
							'max': 10,
							'step': 1
						},
						// Image
						{
							'name': 'title_bg_image',
							'name_url': 'title_bg_image_url',
							'title': i18n.__( 'Background image' ),
							'type': 'image'
						},
						// Title 2
						{
							'name': 'title2',
							'title': i18n.__( 'Title part 2' ),
							'descr': i18n.__( "Use this parameter if you want to separate title parts with different color, border or background" ),
							'type': 'text'
						},
						// Title 2 Color
						{
							'name': 'title2_color',
							'title': i18n.__( 'Color' ),
							'descr': i18n.__( "Title 2 custom color" ),
							'type': 'color'
						},
						// Title 2 Border Color
						{
							'name': 'title2_border_color',
							'title': i18n.__( 'Border color' ),
							'descr': i18n.__( "Title 2 border color" ),
							'type': 'color'
						},
						// Title 2 Border width
						{
							'name': 'title2_border_width',
							'title': i18n.__( 'Border width' ),
							'descr': i18n.__( "Title 2 border width (in px)" ),
							'type': 'number',
							'min': 0,
							'max': 10,
							'step': 1
						},
						// Title 2 Image
						{
							'name': 'title2_bg_image',
							'name_url': 'title2_bg_image_url',
							'title': i18n.__( 'Background image' ),
							'type': 'image'
						},
						// Highlight on mouse hover
						{
							'name': 'mouse_helper_highlight',
							'title': i18n.__( 'Highlight on mouse hover' ),
							'descr': i18n.__( 'Used only if option "Mouse helper" is on in the Theme Panel - ThemeREX Addons settings' ),
							'type': 'boolean'
						},
						// Autotype
						{
							'name': 'typed',
							'title': i18n.__( 'Use autotype' ),
							'descr': '',
							'type': 'boolean'
						},
						// Autotype loop
						{
							'name': 'typed_loop',
							'title': i18n.__( 'Autotype loop' ),
							'descr': '',
							'dependency': {
								'typed': [true]
							},
							'type': 'boolean'
						},
						// Autotype cursor
						{
							'name': 'typed_cursor',
							'title': i18n.__( 'Autotype cursor' ),
							'descr': '',
							'dependency': {
								'typed': [true]
							},
							'type': 'boolean'
						},
						// Autotype strings
						{
							'name': 'typed_strings',
							'title': i18n.__( 'Alternative strings' ),
							'descr': i18n.__( "Alternative strings to type. Attention! First string must be equal of the part of the title." ),
							'dependency': {
								'typed': [true]
							},
							'rows': 5,
							'type': 'textarea'
						},
						// Color
						{
							'name': 'typed_color',
							'title': i18n.__( 'Autotype color' ),
							'descr': '',
							'dependency': {
								'typed': [true]
							},
							'type': 'color'
						},
						// Autotype speed
						{
							'name': 'typed_speed',
							'title': i18n.__( "Autotype speed" ),
							'descr': i18n.__( "Typing speed from 1 (min) to 10 (max)" ),
							'type': 'number',
							'min': 1,
							'max': 10,
							'step': 0.5,
							'dependency': {
								'typed': [true]
							}
						},
						// Autotype delay
						{
							'name': 'typed_delay',
							'title': i18n.__( "Autotype delay" ),
							'descr': i18n.__( "Delay before erase text" ),
							'type': 'number',
							'min': 0,
							'max': 10,
							'step': 0.5,
							'dependency': {
								'typed': [true]
							}
						},
						// Subtitle
						{
							'name': 'subtitle',
							'title': i18n.__( 'Subtitle' ),
							'descr': i18n.__( "Subtitle of the block" ),
							'type': 'text'
						},
						// Subtitle alignment
						{
							'name': 'subtitle_align',
							'title': i18n.__( 'Subtitle alignment' ),
							'descr': i18n.__( "Select alignment of the subtitle" ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] )
						},
						// Subtitle position
						{
							'name': 'subtitle_position',
							'title': i18n.__( 'Subtitle position' ),
							'descr': i18n.__( "Select position of the subtitle" ),
							'type': 'select',
							'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_subtitle_positions'] )
						},
						// Description
						{
							'name': 'description',
							'title': i18n.__( 'Description' ),
							'descr': i18n.__( "Description of the block" ),
							'type': 'textarea'
						}
					];

	// Add Button
	if ( button ) params = params.concat( trx_addons_gutenberg_add_param_button( props, true ) );
	// Button 2
	if ( button2 ) params = params.concat( trx_addons_gutenberg_add_param_button2( props, true ) );

	params = trx_addons_apply_filters( 'trx_addons_gb_map_add_params', params, 'common/title', props );

	return el( wp.element.Fragment, {},
				el( wp.editor.InspectorControls, {},
					el( wp.components.PanelBody, { title: i18n.__( "Title" ) },
						el( 'div', {},
							trx_addons_gutenberg_add_params( params, props )
						)
					)
				)
			);
}



// Hide on devices params
//-------------------------------------------
function trx_addons_gutenberg_get_param_hide(frontpage) {

	"use strict";

	return trx_addons_apply_filters(
				'trx_addons_gb_map_get_params',
				trx_addons_object_merge(
					{
						// Hide on devices attributes
						hide_on_wide: {
							'type': 'boolean',
							'default': false
						},
						hide_on_desktop: {
							'type': 'boolean',
							'default': false
						},
						hide_on_notebook: {
							'type': 'boolean',
							'default': false
						},
						hide_on_tablet: {
							'type': 'boolean',
							'default': false
						},
						hide_on_mobile: {
							'type': 'boolean',
							'default': false
						}
					},
					! frontpage ? {} : {
						hide_on_frontpage: {
							'type': 'boolean',
							'default': false
						},
						hide_on_singular: {
							'type': 'boolean',
							'default': false
						},
						hide_on_other: {
							'type': 'boolean',
							'default': false
						}			
					}
				),
				'common/hide'
			);
}

function trx_addons_gutenberg_add_param_hide(props, hide_on_frontpage) {

	"use strict";

	var el     = window.wp.element.createElement;
	var i18n   = window.wp.i18n;
	var params = trx_addons_apply_filters(
					'trx_addons_gb_map_add_params',
					[
						// Hide on wide
						{
							'name': 'hide_on_wide',
							'title': i18n.__( 'Hide on wide' ),
							'descr': i18n.__( "Hide this item on wide screens" ),
							'type': 'boolean'
						},
						// Hide on desktops
						{
							'name': 'hide_on_desktop',
							'title': i18n.__( 'Hide on desktops' ),
							'descr': i18n.__( "Hide this item on desktops" ),
							'type': 'boolean'
						},
						// Hide on notebooks
						{
							'name': 'hide_on_notebook',
							'title': i18n.__( 'Hide on notebooks' ),
							'descr': i18n.__( "Hide this item on notebooks" ),
							'type': 'boolean'
						},
						// Hide on tablets
						{
							'name': 'hide_on_tablet',
							'title': i18n.__( 'Hide on tablets' ),
							'descr': i18n.__( "Hide this item on tablets" ),
							'type': 'boolean'
						},
						// Hide on mobile devices
						{
							'name': 'hide_on_mobile',
							'title': i18n.__( 'Hide on mobile devices' ),
							'descr': i18n.__( "Hide this item on mobile devices" ),
							'type': 'boolean'
						},
						// Hide on frontpage
						! hide_on_frontpage ? null : {
							'name': 'hide_on_frontpage',
							'title': i18n.__( 'Hide on Frontpage' ),
							'descr': i18n.__( "Hide this item on the Frontpage" ),
							'type': 'boolean'
						},
						// Hide on single posts
						! hide_on_frontpage ? null : {
							'name': 'hide_on_singular',
							'title': i18n.__( 'Hide on single posts and pages' ),
							'descr': i18n.__( "Hide this item on single posts and pages" ),
							'type': 'boolean'
						},
						// Hide on other pages
						! hide_on_frontpage ? null : {
							'name': 'hide_on_other',
							'title': i18n.__( 'Hide on other pages' ),
							'descr': i18n.__( "Hide this item on other pages (posts archive, category or taxonomy posts, author's posts, etc.)" ),
							'type': 'boolean'
						}
					],
					'common/hide',
					props
				);

	return el( wp.element.Fragment, {},
				el( wp.editor.InspectorControls, {},
					el( wp.components.PanelBody, { title: i18n.__( "Hide on devices" ) },
						el( 'div', {},
							trx_addons_gutenberg_add_params( params, props )
						)
					)
				)
			);
}



// Return ID, Class, CSS params
//-------------------------------------------
function trx_addons_gutenberg_get_param_id() {

	"use strict";

	return trx_addons_apply_filters(
			'trx_addons_gb_map_get_params',
			{
				// ID, Class, CSS attributes
				'id': {
					'type': 'string',
					'default': ''
				},
				'class': {
					'type': 'string',
					'default': ''
				},
				'className': {
					'type': 'string',
					'default': ''
				},
				'css': {
					'type': 'string',
					'default': ''
				}
			},
			'common/id'
		);
}

function trx_addons_gutenberg_add_param_id(props, id_name) {

	"use strict";

	var el     = window.wp.element.createElement;
	var i18n   = window.wp.i18n;
	if (id_name === undefined) id_name = 'id';
	var params = trx_addons_apply_filters(
					'trx_addons_gb_map_add_params',
					[
						// Element ID
						{
							'name': id_name,
							'title': i18n.__( 'Element ID' ),
							'descr': i18n.__( "ID for current element" ),
							'type': 'text'
						},
						// Element CSS class
						{
							'name': 'class',
							'title': i18n.__( 'Element CSS class' ),
							'descr': i18n.__( "CSS class for current element" ),
							'type': 'text'
						},
						// CSS box
						{
							'name': 'css',
							'title': i18n.__( 'CSS box' ),
							'descr': i18n.__( "Design Options" ),
							'type': 'textarea'
						}
					],
					'common/id',
					props
				);

	return el( wp.element.Fragment, {},
				el( wp.editor.InspectorControls, {},
					el( wp.components.PanelBody, { title: i18n.__( "ID & Class" ) },
						el( 'div', {},
							trx_addons_gutenberg_add_params( params, props )
						)
					)
				)
			);
}





//
//
//
// ADD PARAMETERS
// Parameters constructor
//-------------------------------------------
function trx_addons_gutenberg_block_params(args, props){

	"use strict";

	var blocks = window.wp.blocks;
	var el     = window.wp.element.createElement;
	var i18n   = window.wp.i18n;

	return [
			// Title
			args['title']
				? el( 'div', { className: 'editor-block-params' },
						el( 'span', {},
							args['title']
						)
					)
				: '',

			// General params
			args['general_params']
				? el( wp.element.Fragment, {},
						el( wp.editor.InspectorControls, {},
							el( wp.components.PanelBody, { title: i18n.__( "General" ) },
								args['general_params']
							)
						)
					)
				: '',

			// Additional params
			args['additional_params']
				? args['additional_params']
				: '',

			// Block render
			args['render']
				? el( wp.components.ServerSideRender, {
						block: props.name,
						attributes: props.attributes
						}
					)
				: '',

			// Block "reload" button
			args['render_button']
				? el( wp.components.Button,
						{
							className: 'button wp-block-reload trx_addons_gb_reload',// + (!args['parent'] ? ' hide' : ''),
							onClick: function(x) {
								var block = wp.data.select("core/editor").getBlock(props.clientId);
								var block_type = blocks.getBlockType( props.name );

								// If block have inner blocks - update their attributes in the parent block
								if ( block && typeof block.innerBlocks == 'object' && block.innerBlocks.length > 0 && typeof block_type.save != 'undefined' ) {
									block_type.save(block);
									props.setAttributes( block.attributes );
								}

								// Change attribute 'reload' to get new layout from server
								var upd_attr = {
									'reload': Math.floor( Math.random() * 100 )
								};
								props.setAttributes( upd_attr );

								// Reload hidden elements like sliders
								trx_addons_gutenberg_reload_hidden_elements( props );
							}
						},
						''	//i18n.__( "Reload" )
					)
				: '',

			// Block items
			args['parent']
				? el( wp.components.PanelBody,
						{
							title: i18n.__( "Inner blocks" ),
							className: 'wp-inner-blocks trx_addons_gb_inner_blocks'	//remove 'wp-block-columns'
						},
						el( wp.editor.InnerBlocks,
							{
								allowedBlocks: args['allowedblocks']
													? args['allowedblocks']
													: [ 'core/paragraph' ]
							}
						)
					)
				: ''
		];
}

// Add multiple parameters from array
//-------------------------------------------
function trx_addons_gutenberg_add_params( args, props ) {

	"use strict";

	var params = [];
	for ( var i = 0; i < args.length; i++ ) {
		if ( args[i] ) {
			params.push( trx_addons_gutenberg_add_param( args[i], props ) );
		}
	}
	return params;
}

// Add single parameter by type
//-------------------------------------------
function trx_addons_gutenberg_add_param( args, props ) {

	"use strict";

	var el   = window.wp.element.createElement;
	var i18n = window.wp.i18n;

	// Set variables
	var param_name     	= args['name'] ? args['name'] : '';
	var param_name_url 	= args['name_url'] ? args['name_url'] : '';
	var param_title    	= args['title'] ? args['title'] : '';
	var param_descr    	= args['descr'] ? args['descr'] : '';
	var param_options  	= args['options'] ? args['options'] : '';
	var param_value    	= param_name ? props.attributes[param_name] : '';
	var param_url_value	= param_name_url ? props.attributes[param_name_url] : '';
	var upd_attr       	= {};

	// Set onChange functions
	var param_change     = function(x) {
								upd_attr[param_name] = x;
								props.setAttributes( upd_attr );
								// Reload hidden elements like sliders
								trx_addons_gutenberg_reload_hidden_elements( props, param_name, x );
	};
	var param_change_img = function(x) {
								upd_attr[param_name]     = x.id;
								upd_attr[param_name_url] = x.url;
								props.setAttributes( upd_attr );
								// Reload hidden elements like sliders
								trx_addons_gutenberg_reload_hidden_elements( props, param_name, x );
	};

	// Parameters dependency
	var dep_all = 0, dep_cnt = 0;
	if ( args['dependency'] ) {
		for (var i in args['dependency']) { 
			// Convert value to an array (if specified as string or number)
			if ( typeof args['dependency'][i] != 'object' ) {
				args['dependency'][i] = [ args['dependency'][i] ];
			}
			// Total dependencies count
			dep_all++;
			for (var t in args['dependency'][i]) {
				if ( props.attributes[i] === args['dependency'][i][t] 
						|| ( (''+args['dependency'][i][t]).charAt(0) == '^' && props.attributes[i] !== args['dependency'][i][t].substr(1) )
						|| ( args['dependency'][i][t] == 'not_empty' && props.attributes[i] !== '' )
				) {
					// Valid dependencies count
					dep_cnt++;
					break;
				}
			}
		}
	}
	// Return parameters options
	if ( dep_all == dep_cnt ) {
		if (args['type'] === 'text') {
			return el( 'div', {},
						el( 'h3', { className: "components-base-control-title" }, param_title ),
						el( wp.components.TextControl, {
							label: param_descr,
							value: param_value,
							onChange: param_change
							}
						)
					);
		}
		if (args['type'] === 'textarea') {
			return el( 'div', {},
						el( 'h3', { className: "components-base-control-title" }, param_title ),
						el( wp.components.TextareaControl, {
							label: param_descr,
							value: param_value,
							rows: args['rows'] ? args['rows'] : 6,
							onChange: param_change
							}
						)
					);
		}
		if (args['type'] === 'boolean') {
			return el( 'div', {},
						el( 'h3', { className: "components-base-control-title" }, param_title ),
						el(	wp.components.ToggleControl, {
							label: param_descr,
							checked: param_value,
							onChange: param_change
							}
						)
					);
		}
		if (args['type'] === 'radio') {
			return el( 'div', {},
						el( 'h3', { className: "components-base-control-title" }, param_title ),
						el(	wp.components.RadioControl, {
							label: param_descr,
							selected: param_value,
							onChange: param_change,
							options: param_options
							}
						)
					);
		}
		if (args['type'] === 'select') {
			if (args['multiple']) {
				param_value = param_value.split( ',' );
			}
			return el( 'div', {},
						el( 'h3', { className: "components-base-control-title" }, param_title ),
						el( wp.components.SelectControl, {
							multiple: args['multiple'] ? 1 : 0,
							size: args['multiple'] ? 9 : 1,
							label: param_descr,
							value: param_value,
							onChange: function(x) {
								if (args['multiple']) {
									var y = '';
									for (var i = 0; i < x.length; i++) {
										y = y + (y ? ',' : '') + x[i];
									}
									upd_attr[param_name] = y;
								} else {
									upd_attr[param_name] = x;
								}
								props.setAttributes( upd_attr );
								// Reload hidden elements like sliders
								trx_addons_gutenberg_reload_hidden_elements( props, param_name, x );
							},
							options: param_options
							}
						)
					);
		}
		if (args['type'] === 'number') {
			return el( 'div', {},
						el( 'h3', { className: "components-base-control-title" }, param_title ),
						el( wp.components.RangeControl, {
							label: param_descr,
							value: param_value,
							onChange: param_change,
							min: args['min'],
							max: args['max'],
							step: args['step']
							}
						)
					);
		}
		if (args['type'] === 'color') {
			return el( 'div', { style: { position: 'relative' } },
						el( 'h3', { className: "components-base-control-title" }, param_title ),
						el( 'p', {}, param_descr ),
						el( wp.components.ColorPalette, {
								value: param_value,
								colors: TRX_ADDONS_STORAGE['gutenberg_sc_params']['theme_colors'],
								onChange: param_change
								}
							),
						el( 'div', {
								className: "components-color-palette-preview",
								style: {backgroundColor: param_value}
								}
							)
						);
		}
		if (args['type'] === 'image') {
			return el( 'div', {},
						el( 'h3', { className: "components-base-control-title" }, param_title ),
						el( 'p', {}, param_descr ),
						el( wp.editor.MediaUpload, {
								onSelect: param_change_img,
								type: 'image',
								value: param_value,
								render: function(obj) {
									return el( 'div', {},
												el( wp.components.Button,
													{
														className: param_value ? 'image-button-1' : 'components-button button button-large button-one',
														onClick: obj.open
													},
													param_value
														? el( 'img', { src: param_url_value } )
														: i18n.__( 'Select Image' )
												),
												param_value
													? el( wp.components.Button,
															{
																className: 'components-button button button-large button-one',
																onClick: function(x) {
																	upd_attr[param_name]     = 0;
																	upd_attr[param_name_url] = 0;
																	props.setAttributes( upd_attr );
																}
															},
															i18n.__( 'Remove Image' )
														)
													: ''
												);
								}
							}
						)
					);
		}
	}
}

// Rewrite array with options for gutenberg
//-------------------------------------------
function trx_addons_gutenberg_get_lists(list, none) {

	"use strict";

	var i18n   = window.wp.i18n;
	var output = [];
	if (list != '') {
		jQuery.each(
			list, function(key, value) {
				output.push(
					{
						value: key,
						label: value
					}
				);
			}
		);
	}
	if (none) {
		output[output.length] = {
			value: '0', 
			label: i18n.__( '-' )
		};
	}
	return output;
}

// Return iconed classes list
//-------------------------------------------
function trx_addons_gutenberg_get_option_icons_classes() {

	"use strict";

	var output = [];
	var icons  = TRX_ADDONS_STORAGE['gutenberg_sc_params']['icons_classes'];
	if (icons != '') {
		jQuery.each(
			icons, function(key, value) {
				output.push(
					{
						key: value,
						value: value,
						label: value
					}
				);
			}
		);
	}
	return output;
}

// Get child block values of attributes
//-------------------------------------------
function trx_addons_gutenberg_get_child_attr(props) {

	"use strict";

	var i = 0, S = 0, N = props.innerBlocks.length, items = {};
	if (N > 0) {
		while (i < N) {
			if (props.innerBlocks[i].name && props.innerBlocks[i].name.indexOf('core/') == -1){ 
				items[i] = props.innerBlocks[i].attributes;
				S++;
			}
			i++;
		} 
		if (S > 0) {
			return JSON.stringify( items );
		} else {
			return '';
		}
	} else {
		return '';
	}
}


// Reload blocks after page loading
//-------------------------------------------
jQuery( window ).on( 'load', function() {

	"use strict";

	trx_addons_gutenberg_first_init();

	// Create the observer to reinit visual editor after switch from code editor to visual editor
	if ( typeof window.MutationObserver !== 'undefined' ) {
		trx_addons_create_observer( 'check_visual_editor', jQuery('.block-editor,#edit-site-editor').eq(0), function( mutationsList ) {
			var gutenberg_editor = trx_addons_gutenberg_editor_object();
			if ( gutenberg_editor.length > 0 ) {
				trx_addons_gutenberg_first_init( gutenberg_editor );
			}
		} );
	}

	// Return Gutenberg editor object
	function trx_addons_gutenberg_editor_object() {
		// Get Post Editor
		var gutenberg_editor = jQuery( '.edit-post-visual-editor:not(.trx_addons_inited)' ).eq( 0 );
		if ( ! gutenberg_editor.length ) {
			// Check if Full Site Editor exists
			var editor_frame = jQuery( 'iframe[name="editor-canvas"]' );
			if ( editor_frame.length ) {
				editor_frame = jQuery( editor_frame.get(0).contentDocument.body );
				if ( editor_frame.hasClass('editor-styles-wrapper') && ! editor_frame.hasClass('trx_addons_inited') ) {
					gutenberg_editor = editor_frame;
				}
			}
		}
		return gutenberg_editor;
	}

	// Init on page load
	function trx_addons_gutenberg_first_init( gutenberg_editor ) {

		// Get Gutenberg editor object
		if ( ! gutenberg_editor ) {
			gutenberg_editor = trx_addons_gutenberg_editor_object();
			if ( ! gutenberg_editor.length ) {
				return;
			}
		}

		var old_GB = gutenberg_editor.hasClass( 'editor-styles-wrapper' ) && gutenberg_editor.hasClass( 'edit-post-visual-editor' ),
			styles_wrapper  = old_GB || gutenberg_editor.hasClass( 'editor-styles-wrapper' )
								? gutenberg_editor
								: gutenberg_editor.find( '.editor-styles-wrapper' ),
			writing_flow    = gutenberg_editor.find( '.block-editor-writing-flow' );


		trx_addons_remove_observer( 'check_visual_editor' );

		// Add class with post-type to the visual editor wrapper
		var pt_class = jQuery('body').attr('class').match(/post\-type\-[^ ]*/);
		if (pt_class && typeof pt_class[0] !== 'undefined') {
			styles_wrapper.addClass(pt_class[0]);
		}

		// Create the observer to assign 'Blog item' position to the parent block
		if (typeof window.MutationObserver !== 'undefined' && ! gutenberg_editor.data( 'trx-addons-mutation-observer-added' ) ) {
			gutenberg_editor.data( 'trx-addons-mutation-observer-added', 1 );
			trx_addons_create_observer( 'blog-item-position', gutenberg_editor, function(mutationsList) {
				for (var mutation of mutationsList) {
					if (mutation.type == 'childList') {
						gutenberg_editor.find('[data-type="trx-addons/layouts-blog-item"]').each(function() {
							var item = jQuery(this),
								item_position = item.find('[data-blog-item-position]').data('blog-item-position');
							if ( item_position !== undefined && !item.hasClass('sc_layouts_blog_item_position_'+item_position)) {
								var classes = item.attr('class').split(' '),
									classes_new = '';
								for (var i=0; i<classes.length; i++) {
									if (classes[i].indexOf('sc_layouts_blog_item_position_') < 0) {
										classes_new += (classes_new != '' ? ' ' : '') + classes[i];
									}
								}
								classes_new += (classes_new != '' ? ' ' : '') + 'sc_layouts_blog_item_position_' + item_position;
								item.attr('class', classes_new);
							}
						});
						break;
					}
				}
			} );
		}

		// Reload dynamic blocks on post editor is loaded
		if (wp && wp.data) {
			wp.data.select( 'core/editor' ).getEditedPostContent();
			writing_flow.find( '.components-button.wp-block-reload' ).trigger( 'click' );
		}

		// Init hidden elements after each 2s until first ajax request finished
		jQuery( document ).trigger( 'action.init_hidden_elements', [gutenberg_editor] );

		var init_hidden_timer = setInterval( function() {
			jQuery( document ).trigger( 'action.init_hidden_elements', [gutenberg_editor] );
		}, 2000 );

		// Stop init hidden elements after first ajax query
		jQuery( document ).on( 'ajaxComplete', function() {
			if ( init_hidden_timer ) {
				clearInterval( init_hidden_timer );
				init_hidden_timer = null;
			}
		} );

		// Init core
		jQuery( document ).trigger( 'action.init_gutenberg', [gutenberg_editor] );

		gutenberg_editor.addClass('trx_addons_inited');
	}
} );


// Init hidden elements when loaded
var trx_addons_gutenberg_block_reload_started = {};
function trx_addons_gutenberg_reload_hidden_elements(props, param_name, x){

	"use strict";

	if (props) {
		trx_addons_gutenberg_block_reload_started[props.clientId] = typeof trx_addons_gutenberg_block_reload_started[props.clientId] == 'undefined' ? 1 : trx_addons_gutenberg_block_reload_started[props.clientId] + 1;
		var block = jQuery( '[data-block="' + props.clientId + '"]' );
		block.addClass( 'reload_mask' );
		// Catch when block is loaded and init hidden element
		var rez = false;
		if (typeof window.MutationObserver !== 'undefined' && ! block.data( 'trx-addons-mutation-observer-added' ) ) {
			block.data( 'trx-addons-mutation-observer-added', 1 );
			// Create an observer instance to catch when block is loaded
			rez = trx_addons_create_observer( props.clientId, block, function(mutationsList) {
				for (var mutation of mutationsList) {
					if (mutation.type == 'childList' || mutation.type == 'subtree' ) {
						if ( trx_addons_gutenberg_block_reload_started.hasOwnProperty(props.clientId)
							&& trx_addons_gutenberg_block_reload_started[props.clientId] > 0
							&& block.find('> div [class*="sc_"]').length > 0
						) {
							trx_addons_gutenberg_block_reload_started[props.clientId] = Math.max(0, trx_addons_gutenberg_block_reload_started[props.clientId] - 1);
							block.removeClass( 'reload_mask' );
							jQuery(document).trigger( 'action.init_hidden_elements', [ block ] );
						}
						break;
					}
				}
			} );
		}
		// If MutationObserver is not supported - wait 5 sec and init hidden elements
		// Otherwise - wait 10 sec
		setTimeout(
			function(){
				trx_addons_gutenberg_block_reload_started[props.clientId] = Math.max(0, trx_addons_gutenberg_block_reload_started[props.clientId] - 1);
				block.removeClass( 'reload_mask' );
				jQuery( document ).trigger( 'action.init_hidden_elements', [ block ] );
				trx_addons_gutenberg_hide_inner_blocks( block );
			}, !rez ? 5000 : 10000
		);
	}
}


// Decorate inner blocks - hide it to the button
function trx_addons_gutenberg_hide_inner_blocks( block ) {

	"use strict";

	block.find('.trx_addons_gb_inner_blocks.is-opened').each(function() {
		if (jQuery(this).css('position') == 'absolute') {
			jQuery(this).find('> .components-panel__body-title > .components-panel__body-toggle').trigger('click');
		}
	});
}


// Modify core blocks
//-------------------------------------------
( function(blocks, editor, i18n, element, components, hooks) {

	"use strict";

	if ( ! TRX_ADDONS_STORAGE['modify_gutenberg_blocks'] ) {
		return;
	}

	var el = wp.element.createElement;

	// Add new attribute to the blocks
	function TrxAddonsCoreBlockAddAttribute( settings, name ) {
		if ( name == 'core/spacer' || name == 'core/separator' ) {
			settings.attributes['alter_height'] = {
				type: 'string',
				default: 'none'
			};
		}
		return settings;
	}
	
	hooks.addFilter( 'blocks.registerBlockType', 'trx-addons/core/block', TrxAddonsCoreBlockAddAttribute );

	// Edit block: Add classes to the block wrapper
	var TrxAddonsCoreBlockList = wp.compose.createHigherOrderComponent( function( BlockListBlock ) {
		return function( props ) {
			var change = false;
			if ( props.name == 'core/spacer' || props.name == 'core/separator' ) {
				if ( props.attributes.alter_height && props.attributes.alter_height != 'none' ) {
					change = true;
					var newProps = lodash.assign(
						{
							//key: 'trx_addons-' + props.name
						},
						props,
						{
							className: ( props.className ? props.className + ' ' : '' )
											+ 'sc_height_' + props.attributes.alter_height
						}
					);
				}
			}
			return el(
					BlockListBlock,
					change ? newProps : props
					);
		};
	}, 'TrxAddonsCoreBlockList' );

	hooks.addFilter( 'editor.BlockListBlock', 'trx-addons/core/block', TrxAddonsCoreBlockList );


	// Edit block: Add fields to the Inspector panel
	var TrxAddonsCoreBlockEdit = wp.compose.createHigherOrderComponent( function( BlockEdit ) {
		return function( props ) {
			if ( props.name == 'core/spacer' || props.name == 'core/separator' ) {
				return el( wp.element.Fragment, {},
							el( BlockEdit, props ),
							el( wp.editor.InspectorControls, {},
								el( 'div', { className: "components-panel__body is-opened" },
									el( 'label', { className: "components-base-control-label" },
										i18n.__( 'Alter height' )
									),
									el( components.SelectControl,
										{
											className: props.name.replace('core/', '') + '_alter_height',
											value: props.attributes.alter_height ? props.attributes.alter_height : 'none',
											options: trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['list_spacer_heights'] ),
											onChange: function( value ) {
												props.setAttributes( { alter_height: value } );
											}
										}
									)
								)
							)
						);
			} else {
				return el( wp.element.Fragment, {},
							el( BlockEdit, props )
						);
			}
		};
	}, 'TrxAddonsCoreBlockEdit' );

	hooks.addFilter( 'editor.BlockEdit', 'trx-addons/core/block', TrxAddonsCoreBlockEdit );

	// Save block
	var TrxAddonsCoreBlockSave = function( element, blockType, attributes ) {
		if ( blockType.name == 'core/spacer' || blockType.name == 'core/separator' ) {
			if ( ! trx_addons_is_off( attributes.alter_height ) ) {
				return lodash.assign(
							{},
							element,
							{ props: lodash.assign(
											{},
											element.props,
											{
												className: element.props.className + ' sc_height_' + attributes.alter_height
											}
										)
							}
						);
			}
		}
		return element;
	};

	hooks.addFilter( 'blocks.getSaveElement', 'trx-addons/core/block', TrxAddonsCoreBlockSave );

} )( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element, window.wp.components, window.wp.hooks );




// Fixes for compatibility with latest Gutenberg updates
// ( since WordPress 5.8+ )
//--------------------------------------------------------

jQuery( window ).on( 'load', function() {

	"use strict";

	if ( typeof window.MutationObserver !== 'undefined' ) {
		
		// Create an observer to add a form for create custom widget areas to the new Widgets editor
		var $widgets_sidebar = jQuery('#widgets-editor .edit-widgets-sidebar .components-panel').eq(0);
		if ( $widgets_sidebar.length ) {
			// Function to add form layout
			var add_custom_widget_areas_form = function() {
				var $customize_link = $widgets_sidebar.find( 'a.components-button[href*="customize.php?autofocus"]' );
				var $form_wrap = $widgets_sidebar.find( '.trx_addons_widgets_form_wrap' );
				if ( $customize_link.length ) {
					if ( $form_wrap.length === 0 ) {
						var $wrap = $customize_link.parents( '.edit-widgets-widget-areas' );
						if ( $wrap.length ) {
							$wrap.append(
								'<div class="edit-widgets-widget-areas__top-container">'
									+ '<span class="block-editor-block-icon"></span>'
									+ '<div class="trx_addons_widgets_form_wrap">'
										+ '<p class="trx_addons_widgets_form_title">' + window.wp.i18n.__( 'Add custom widgets area' ) + '</p>'
										+ '<form class="trx_addons_widgets_form" method="post">'
											+ '<input name="trx_addons_widgets_area_nonce" value="' + TRX_ADDONS_STORAGE['ajax_nonce'] + '" type="hidden">'
											+ '<div class="trx_addons_widgets_area_name">'
												+ '<div class="trx_addons_widgets_area_label">' + window.wp.i18n.__( 'Name (required):' ) + '</div>'
												+ '<div class="trx_addons_widgets_area_field"><input name="trx_addons_widgets_area_name" value="" type="text"></div>'
											+ '</div>'
											+ '<div class="trx_addons_widgets_area_description">'
												+ '<div class="trx_addons_widgets_area_label">' + window.wp.i18n.__( 'Description:' ) + '</div>'
												+ '<div class="trx_addons_widgets_area_field"><input name="trx_addons_widgets_area_description" value="" type="text"></div>'
											+ '</div>'
											+ '<div class="trx_addons_widgets_area_submit">'
												+ '<div class="trx_addons_widgets_area_field">'
													+ '<input type="submit" value="' + window.wp.i18n.__( 'Add' ) + '" name="trx_addons_widgets_area_add" class="trx_addons_widgets_area_button trx_addons_widgets_area_add button-primary" title="' + window.wp.i18n.__( 'To create new widgets area specify it name (required) and description (optional) and press this button' ) + '">'
													+ '<input type="submit" value="' + window.wp.i18n.__( 'Delete' ) + '" name="trx_addons_widgets_area_delete" class="trx_addons_widgets_area_button trx_addons_widgets_area_delete button" title="' + window.wp.i18n.__( 'To delete custom widgets area specify it name (required) and press this button' ) + '">'
												+ '</div>'
											+ '</div>'
										+ '</form>'
									+ '</div>'
								+ '</div>'
							);
						}
					}
				} else {
					$form_wrap.parents( '.edit-widgets-widget-areas__top-container' ).remove();
				}
			};
			// Manual call on page loaded
			add_custom_widget_areas_form();
			// Add observer to call function on tab Widget areas clicked (opened)
			trx_addons_create_observer( 'add_form_with_custom_widget_areas', $widgets_sidebar, function( mutationsList ) {
				for ( var mutation of mutationsList ) {
					if ( mutation.type == 'childList' ) {
						add_custom_widget_areas_form();
					}
				}
			} );
		}

		// Create an observer to add class 'editor-page-attributes__template' to the field's wrap
		// contains a select with templates ( only for pages )
		if ( jQuery('body').hasClass( 'post-type-page' ) ) {
			var add_sidebar_observer = function() {
				// Function to add a class to the template selector
				var add_class_to_template_selector = function() {
					var $option = $page_sidebar.find( 'option[value="blog.php"]' );
					if ( $option.length && $option.parents( '.editor-page-attributes__template' ).length === 0 ) {
						$option.parent().parent().addClass( 'editor-page-attributes__template' );
					}
				};
				// Manual call on page loaded
				add_class_to_template_selector();
				// Add observer to call function on tab clicked (opened)
				trx_addons_create_observer( 'add_class_to_template_selector', $page_sidebar, function( mutationsList ) {
					for ( var mutation of mutationsList ) {
						if ( mutation.type == 'childList' ) {
							add_class_to_template_selector();
						}
					}
				} );
			};
			var $editor = jQuery('#editor').eq(0);
			if ( $editor.length ) {
				var $page_sidebar = $editor.find('.edit-post-sidebar .components-panel').eq(0);
				if ( $page_sidebar.length ) {
					add_sidebar_observer();
				} else {
					trx_addons_create_observer( 'check_for_sidebar_created', $editor, function( mutationsList ) {
						for ( var mutation of mutationsList ) {
							if ( mutation.type == 'childList' ) {
								$page_sidebar = $editor.find('.edit-post-sidebar .components-panel').eq(0);
								if ( $page_sidebar.length ) {
									trx_addons_remove_observer( 'check_for_sidebar_created' );
									add_sidebar_observer();
									break;
								}
							}
						}
					} );
				}
			}
		}
	}

} );
