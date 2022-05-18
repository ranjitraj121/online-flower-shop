/**
 * Shortcode Yandex map
 *
 * @package ThemeREX Addons
 * @since v1.6.51
 */

/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

(function() {

	"use strict";

	var yandexmap = {
		'inited': false,
		'init_attempts': 0,
		'count': 0,
		'maps': []
	};
	var timer = null, ymaps_ready = false;

	jQuery(document).ready(function() {
		if (typeof ymaps !== 'undefined') {
			ymaps.ready(function() {
				ymaps_ready = true;
			});
		}
	});

	jQuery(document).on( 'action.init_hidden_elements', function(e, container) {
		if (container === undefined) container = jQuery('body');
		var ymap = container.find('.sc_yandexmap:not(.inited)');
		if (ymap.length > 0) {
			if (timer !== null) clearTimeout(timer);
			// Init Yandex map after all other elements (i.e. slider)
			timer = setTimeout(function() {
					trx_addons_sc_yandexmap_init(e, container);
					}, ymap.parents('.elementor-element-editable,.gutenberg__editor').length > 0 ? 500 : 0);
		}
	});

	function trx_addons_sc_yandexmap_init(e, container) {
		if ( ! ymaps_ready ) {
			if ( timer !== null ) clearTimeout(timer);
			yandexmap.init_attempts++;
			if ( yandexmap.init_attempts < 100 ) {
				timer = setTimeout(function() {
					trx_addons_sc_yandexmap_init(e, container);
				}, 100);
			}
			return;
		}

		if (container === undefined) container = jQuery('body');

		var ymap = container.find('.sc_yandexmap:not(.inited)');
		if (ymap.length > 0) {
			ymap.each(function () {
				if (jQuery(this).parents('div:hidden,article:hidden').length > 0) return;
				var map 		= jQuery(this).addClass('inited'),
					map_id		= map.attr('id'),
					map_zoom	= map.data('zoom'),
					map_style	= map.data('style'),
					map_center  = map.data('center'),
					map_editable= map.data('editable')=='1',
					map_cluster_icon = map.data('cluster-icon'),
					map_markers = [],
					map_objects = [];
				map.find('.sc_yandexmap_marker').each(function() {
					var marker = jQuery(this),
						address = marker.data('address');
					if ( !address ) return;
					var latlng = address.split(',').map(parseFloat);
					map_markers.push({
						icon:			marker.data('icon'),
						icon_retina:	marker.data('icon_retina'),
						icon_width:		marker.data('icon_width'),
						icon_height:	marker.data('icon_height'),
						address:		latlng.length == 2 && !isNaN(latlng[0]) && !isNaN(latlng[1]) ? '' : address,
						latlng:			latlng.length != 2 || isNaN(latlng[0]) || isNaN(latlng[1]) ? '' : latlng,
						description:	marker.data('description'),
						title:			marker.data('title')
					});
					map_objects.push(null);
				});
				trx_addons_sc_yandexmap_create( map, {
					style: map_style,
					zoom: map_zoom,
					center: map_center,
					editable: map_editable,
					cluster_icon: map_cluster_icon,
					markers: map_markers,
					objects: map_objects
					}
				);
			});
		}
	}

	function trx_addons_sc_yandexmap_create(map, coords) {
		if (!yandexmap.inited) trx_addons_sc_yandexmap_init_styles();
//		try {
			var id = map.attr('id');
			yandexmap.count++;
			// Change id if already exists on this page
			if (typeof yandexmap.maps[id] !== 'undefined') {
				id += '_copy' + yandexmap.count;
				map.attr('id', id);
			}
			var center = [];
			if (coords.center) {
				center = (''+coords.center).split(',').map(parseFloat);
			}
			yandexmap.maps[id] = {
				markers_inited: 0,
				markers: coords.markers,
				objects: coords.objects,
				geocoder_request: false,
				clusterIcon: coords.cluster_icon,
				objectsManager: null,
				clusterer: null,
				editable: coords.editable,
				fit_to_bounds: false,
				bounds: [ [-999, -999], [-999, -999] ],
				styles: TRX_ADDONS_STORAGE['yandexmap_styles'][coords.style ? coords.style : 'default'],
				opt: {
					zoom: coords.zoom && coords.markers.length == 1 && center.length === 0
							? parseInt(coords.zoom, 10)
							: 0,
					center: center
				}
			};
			trx_addons_sc_yandexmap_build(id);
//		} catch (e) {
//			console.log(TRX_ADDONS_STORAGE['msg_sc_yandexmap_not_avail']);
//		};
	}

	function trx_addons_sc_yandexmap_refresh() {
		for (id in yandexmap.maps) {
			// Remove objects
			if (yandexmap.maps[id].clusterer !== null) {
				yandexmap.maps[id].clusterer.removeAll();
			} else if (yandexmap.maps[id].objectsManager !== null) {
				yandexmap.maps[id].objectsManager.objects.removeAll();
			}
			// Build map
			trx_addons_sc_yandexmap_build(id);
		}
	}

	// Add resize listener
	jQuery(document).on('action.resize_trx_addons', function() {
		for (id in yandexmap.maps) {
			if (   yandexmap.maps[id].map
				&& jQuery('#'+id).parent().hasClass('ready')
				&& yandexmap.maps[id].window_width != jQuery( window ).width()
			) {
				if ( yandexmap.maps[id].opt['center'] ) {
					yandexmap.maps[id].map.setCenter(yandexmap.maps[id].opt['center']);
				}
				if ( yandexmap.maps[id].markers_inited == yandexmap.maps[id].markers.length && yandexmap.maps[id].fit_to_bounds ) {
					yandexmap.maps[id].map.setBounds(trx_addons_sc_yandexmap_get_bounds(id), {
						checkZoomRange: true
					});
				}
			}
		}
	});

	function trx_addons_sc_yandexmap_build(id) {
		var i = 0;
		// Save window width
		yandexmap.maps[id].window_width = jQuery( window ).width();

		// Create map
		yandexmap.maps[id].map = new ymaps.Map(id, yandexmap.maps[id].opt, {
			searchControlProvider: 'yandex#search'
		});

		// Apply style
		if ( yandexmap.maps[id].styles.length > 0 ) {
			var css = '';
			for (i=0; i<yandexmap.maps[id].styles.length; i++) {
				css += '#' + id + ' ' + yandexmap.maps[id].styles[i].selector.replace(/,/g, ',#' + id + ' ') 
					+  '{' + yandexmap.maps[id].styles[i].css + '}';
			}
			if ( css !== '' ) {
				var css_tag = jQuery('#'+id+'_css');
				if (css_tag.length === 0) {
					jQuery('#'+id).prepend('<style id="'+id+'_css" type="text/css">' + css + '</style>');
				} else {
					css_tag.html(css);
				}
			}
		}

		// Create objects (markers) manager
		var omInit = {
			//clusterize: true,
			gridSize: 64,
			clusterDisableClickZoom: false
		};
		if (yandexmap.maps[id].clusterIcon) {
			omInit.clusterIcons = [{
				href: yandexmap.maps[id].clusterIcon,
				size: [32, 32],
				offset: [-16, -32]
			}];
		}

		if (yandexmap.maps[id].markers.length > 1 && !yandexmap.maps[id].editable) {
			if (false) {
				yandexmap.maps[id].objectsManager = new ymaps.ObjectManager(omInit);
			} else {
				yandexmap.maps[id].clusterer = new ymaps.Clusterer(omInit);
			}
		}

		// Prepare maps bounds
		yandexmap.maps[id].fit_to_bounds = yandexmap.maps[id].opt['zoom'] < 1 && ( yandexmap.maps[id].opt['center'].length > 0 || yandexmap.maps[id].markers.length > 1 );
		if (yandexmap.maps[id].opt['center'].length > 0) {
			trx_addons_sc_yandexmap_add_bounds(id, yandexmap.maps[id].opt['center']);
		}

		// Add markers
		for (i=0; i < yandexmap.maps[id].markers.length; i++) {
			yandexmap.maps[id].markers[i].inited = false;
		}
		trx_addons_sc_yandexmap_add_markers(id);
	}

	function trx_addons_sc_yandexmap_add_markers(id) {

		for (var i=0; i < yandexmap.maps[id].markers.length; i++) {
			
			if (yandexmap.maps[id].markers[i].inited) {
				continue;
			}

			var geocache = false,
				address = yandexmap.maps[id].markers[i].address,
				tm = (new Date).getTime();

			// First try get latlng from cache with previous geocoding data
			if ( ! yandexmap.maps[id].markers[i].latlng ) {
				geocache = trx_addons_get_storage('trx_addons_geocache_yandexmap');
				if ( geocache && geocache.charAt(0) == '{' ) {
					geocache = JSON.parse(geocache);
				} else {
					geocache = {};
				}
				if ( typeof geocache[address] == 'object' ) {
					if ( geocache[address].expired < tm ) {
						yandexmap.maps[id].markers[i].latlng = geocache[address].latlng;
					} else {
						delete geocache[address];
					}
				}
			}

			// Start geocoding (get lat,lng from the address)
			if ( ! yandexmap.maps[id].markers[i].latlng ) {

				if (yandexmap.maps[id].geocoder_request !== false) continue;

				if ( ! address ) {
					yandexmap.maps[id].markers[i].inited = true;
					continue;
				}

				yandexmap.maps[id].geocoder_request = i;

				ymaps.geocode(yandexmap.maps[id].markers[i].address).then(
					function(res) {
						var idx = yandexmap.maps[id].geocoder_request,
							coords = false;
						try {
							coords = res.geoObjects.properties.get('metaDataProperty').GeocoderResponseMetaData.Point.coordinates;
							yandexmap.maps[id].markers[idx].latlng = [ coords[1], coords[0] ];
							// Put geocoding result to the cache
							geocache[ yandexmap.maps[id].markers[idx].address ] = {
								latlng: yandexmap.maps[id].markers[idx].latlng,
								expired: (new Date()).getTime() + 24 * 60 * 60
							};
							trx_addons_set_storage('trx_addons_geocache_yandexmap', JSON.stringify(geocache));
							// Resume adding markers
							setTimeout(function() { 
								trx_addons_sc_yandexmap_add_markers(id); 
							}, 200 );
						} catch (e) {
							// Do nothing
							console.log('Error detect coords for '+yandexmap.maps[id].geocoder_request);
						}
						// Release Geocoder
						yandexmap.maps[id].geocoder_request = false;
					},
					function (err) {
						console.log(TRX_ADDONS_STORAGE['msg_sc_yandexmap_geocoder_error']);
						console.log(err);
						yandexmap.maps[id].geocoder_request = false;
					}
				);

			} else {

				// Prepare marker object
				var markerInit = {
						type: 'Feature',
						id: i,
						geometry: {
							type: 'Point',
							coordinates: yandexmap.maps[id].markers[i].latlng
						},
						properties: {
							hintContent: yandexmap.maps[id].markers[i].title,
							balloonContentHeader: yandexmap.maps[id].markers[i].title,
							balloonContentBody: yandexmap.maps[id].markers[i].description,
							draggable: yandexmap.maps[id].editable
						},
						options: {}
					};
				if (yandexmap.maps[id].markers[i].icon) {
					if (yandexmap.maps[id].markers[i].icon_width === 0) yandexmap.maps[id].markers[i].icon_width = 32;
					if (yandexmap.maps[id].markers[i].icon_height === 0) yandexmap.maps[id].markers[i].icon_height = 32;
					markerInit.options = {
						iconLayout: 'default#image',
						iconImageHref: yandexmap.maps[id].markers[i].icon,
						iconImageSize: [yandexmap.maps[id].markers[i].icon_width, yandexmap.maps[id].markers[i].icon_height],
						iconImageOffset: [-yandexmap.maps[id].markers[i].icon_width/2, -yandexmap.maps[id].markers[i].icon_height]
					};
				}
				if (yandexmap.maps[id].objectsManager !== null) {
					yandexmap.maps[id].objectsManager.add(markerInit);
				} else {
					yandexmap.maps[id].objects[i] = new ymaps.Placemark(yandexmap.maps[id].markers[i].latlng, markerInit.properties, markerInit.options);
					if (yandexmap.maps[id].clusterer !== null) {
						yandexmap.maps[id].clusterer.add(yandexmap.maps[id].objects[i]);
					} else {
						yandexmap.maps[id].map.geoObjects.add(yandexmap.maps[id].objects[i]);
					}
				}
				trx_addons_sc_yandexmap_add_bounds(id, yandexmap.maps[id].markers[i].latlng);
				// Set Map center
				if (yandexmap.maps[id].opt['center'].length < 2 && yandexmap.maps[id].markers.length == 1) {
					yandexmap.maps[id].opt['center'] = yandexmap.maps[id].markers[i].latlng;
					yandexmap.maps[id].map.setCenter(yandexmap.maps[id].opt['center'], yandexmap.maps[id].opt['zoom']);
				}
				yandexmap.maps[id].markers[i].inited = true;
				yandexmap.maps[id].markers_inited++;
			}
		}

		// If all markers inited
		if (yandexmap.maps[id].markers_inited == yandexmap.maps[id].markers.length) {
			// Fit Bounds (need before 'Objects Manager' or 'Clusterer' is added)
			if (yandexmap.maps[id].opt['zoom'] < 1 || yandexmap.maps[id].fit_to_bounds) {
				yandexmap.maps[id].map.setBounds(trx_addons_sc_yandexmap_get_bounds(id), {
					checkZoomRange: true
				});
			}
			var fit_bounds = false;
			// Add 'Objects Manager' or 'Clusterer' to the map
			if (yandexmap.maps[id].objectsManager !== null) {
				yandexmap.maps[id].map.geoObjects.add(yandexmap.maps[id].objectsManager);
				fit_bounds = true;
			} else if (yandexmap.maps[id].clusterer !== null) {
				yandexmap.maps[id].map.geoObjects.add(yandexmap.maps[id].clusterer);
				fit_bounds = true;
			}
			/*
			// And 'refresh' map after all objects are added
			if (fit_bounds) {
				yandexmap.maps[id].map.setBounds(yandexmap.maps[id].map.getBounds(), {
					checkZoomRange: true
				});
			}
			*/
			// Display map
			setTimeout(function() {
				jQuery('#'+id).parent().addClass('ready');
			}, 100);
		}
	}

	function trx_addons_sc_yandexmap_add_bounds(id, latlng) {
		if (yandexmap.maps[id].bounds[0][0] == -999 || yandexmap.maps[id].bounds[0][0] > latlng[0]) yandexmap.maps[id].bounds[0][0] = latlng[0];
		if (yandexmap.maps[id].bounds[0][1] == -999 || yandexmap.maps[id].bounds[0][1] > latlng[1]) yandexmap.maps[id].bounds[0][1] = latlng[1];
		if (yandexmap.maps[id].bounds[1][0] == -999 || yandexmap.maps[id].bounds[1][0] < latlng[0]) yandexmap.maps[id].bounds[1][0] = latlng[0];
		if (yandexmap.maps[id].bounds[1][1] == -999 || yandexmap.maps[id].bounds[1][1] < latlng[1]) yandexmap.maps[id].bounds[1][1] = latlng[1];
	}

	function trx_addons_sc_yandexmap_get_bounds(id) {
		return yandexmap.maps[id].bounds;
		/*
		return yandexmap.maps[id].objectsManager != null
				? yandexmap.maps[id].objectsManager.getBounds()
				: (yandexmap.maps[id].clusterer != null
					? yandexmap.maps[id].clusterer.getBounds()
					: yandexmap.maps[id].bounds
					);
		*/
	}

	// Add styles for Yandex map
	function trx_addons_sc_yandexmap_init_styles() {
		TRX_ADDONS_STORAGE['yandexmap_styles'] = {
			'default': [],
			'greyscale': [
				{
					"selector": '[class$="ground-pane"]',
					"css": 'filter: grayscale(100%);'
				}
			],
			'inverse': [
				{
					"selector": '[class$="ground-pane"]',
					"css": 'filter: invert(100%);'
				}
			]
		};
		jQuery(document).trigger('action.add_yandexmap_styles');
		yandexmap.inited = true;
	}

})();