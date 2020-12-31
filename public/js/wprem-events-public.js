(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 var wpfc_loaded = false;
var wpfc_counts = {};
/*jQuery(document).ready( function($){	
	
	if( WPFC.wpfc_locale ){
		$.extend(fullcalendar_args, WPFC.wpfc_locale);
	}
	$(document).trigger('wpfc_fullcalendar_args', [fullcalendar_args]);
	$('.wpfc-calendar').first().fullCalendar(fullcalendar_args);
});*/

	$( window ).load(function() {
	 	initMap();
	 });

	 window.initMap = function() {
		//var map = L.map('div.wprem_map').setView([51.5, -0.09], 13);
		
		
		$(".wprem_map").each(function(index) {
			
			var lat = parseFloat($(this).attr('data-lat'));
			var lng = parseFloat($(this).attr('data-lng'));

			var container = L.DomUtil.get(this.id);
			if(container != null){
				container._leaflet_id = null;
			}

			var map = L.map(this.id).setView([lat, lng], 15);

			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map);

			var LeafIcon = L.Icon.extend({
				options: {
					shadowUrl: 'leaf-shadow.png',
					iconSize:     [38, 95],
					shadowSize:   [50, 64],
					iconAnchor:   [22, 94],
					shadowAnchor: [4, 62],
					popupAnchor:  [-3, -76]
				}
			});

			//var greenIcon = new LeafIcon({iconUrl: 'leaf-green.png'});

			L.marker([lat, lng]).addTo(map);
			
			/*var marker = new google.maps.LatLng(lat,lng);
			var map = new google.maps.Map(this, {
				center: {
					lat: lat,
					lng: lng
				},
				scrollwheel: false,
				zoom: 15
			});
			// map.setOptions({styles: defaultMapStyle});
			var newMarker = new google.maps.Marker({
				position: marker,
				//icon: image,
				shadow: 'none'
			});

			newMarker.setMap(map);*/
		});
	}

	/*window.checkGoogleMap = function(){
		if(!window.google||!window.google.maps){
			var script = document.createElement('script');
			script.type = 'text/javascript';
			script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCE7fG5qBcm7SQQp5cMsKnySXDVYOA3SMs&' +
			    'callback=initMap';
			document.body.appendChild(script);
		}
		else{
			initMap();
		}		
	}*/

	//checkGoogleMap();

// 	$("body").append('<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCE7fG5qBcm7SQQp5cMsKnySXDVYOA3SMs&callback=initMap"></script>');

jQuery(document).ready(function($) {
	
	//$(window).load(function() {
//$("body").append('<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCE7fG5qBcm7SQQp5cMsKnySXDVYOA3SMs&callback=initMap"></script>');


	$('.pagination a').on('click', function(e){
		e.preventDefault();
		var link = $(this).attr('href');
		//$('#events-list').fadeOut(500);
		//$('#events-list #event-wrap .page').html('Loading...');
		$('#events-list').load(link+ ' #event-wrap', function() {
			
			initMap();
			
            });

	});
	
	/*var ajax_url = event_obj.ajaxurl; // so we access our ajax_url through the ajax_params object
    var data = {
        'action': 'Event_ajax_callback',
        
    };
    *///alert(event_obj.data);
	//console.log(event_obj);
	if ($('#calendar').length > 0) {
		var event_calendar_args = {
			timeFormat: '',//event_obj.timeFormat,
			defaultView: event_obj.defaultView,
			weekends: event_obj.weekends,
			header: {
				left: event_obj.header.left,
				center: event_obj.header.center,
				right: event_obj.header.right
			},
			month: event_obj.month,
			year: event_obj.year,
			theme: event_obj.wpfc_theme,
			firstDay: event_obj.firstDay,
			editable: false,
			eventSources: [{
					url : event_obj.ajaxurl,
					data : { action : event_obj.data, view : event_obj.view },
					type: 'GET',
					success: function(result){
        						console.log('successfully loaded');
    						},
				//ignoreTimezone: true,
					allDayDefault: true,
					//backgroundColor: 'yellow',   // a non-ajax option
					//textColor: 'black'
					error: function(xhr, status, error) {
  						console.log(xhr.responseText);
  						//alert(xhr.responseText);
					}
			}],
			eventRender: function(event, element) {
			if( event.post_id > 0 && event_obj.wpfc_qtips == 1 ){
				var event_data = { action : 'wpfc_qtip_content', post_id : event.post_id, event_id:event.event_id };
				element.qtip({
					content:{
						text : 'Loading...',
						ajax : {
							url : event_obj.ajaxurl,
							type : "POST",
							data : event_data
						}
					},
					position : {
						my: event_obj.wpfc_qtips_my,
						at: event_obj.wpfc_qtips_at
					},
					style : { classes:event_obj.wpfc_qtips_classes },
					hide: {
                		fixed: true,
                		delay: 300
            		}
				});
			}
	    },
		loading: function(bool) {
			if (bool) {
				$(this).parent().find('.wpfc-loading').show();
			}else {
				$(this).parent().find('.wpfc-loading').hide();
			}
		},
		viewRender: function(view, element) {
			if( !wpfc_loaded ){
				console.log("render "+event_obj.data);
				var container = $(element).parents('.wpfc-calendar-wrapper');
				container.find('.fc-toolbar').after(container.next('.wpfc-calendar-search').show());
				//catchall selectmenu handle
			    $.widget( "custom.wpfc_selectmenu", $.ui.selectmenu, {
			        _renderItem: function( ul, item ) {
			        	var li = $( "<li>", { html: item.label.replace(/#([a-zA-Z0-9]{3}[a-zA-Z0-9]{3}?) - /g, '<span class="wpfc-cat-icon" style="background-color:#$1"></span>') } );
			        	if ( item.disabled ) {
			        		li.addClass( "ui-state-disabled" );
			        	}
			        	return li.appendTo( ul );
			        }
			    });
				$('select.wpfc-taxonomy').wpfc_selectmenu({
					format: function(text){
						//replace the color hexes with color boxes
						return text.replace(/#([a-zA-Z0-9]{3}[a-zA-Z0-9]{3}?) - /g, '<span class="wpfc-cat-icon" style="background-color:#$1"></span>');
					},
					select: function( event, ui ){
						var calendar = $('.wpfc-calendar');
						menu_name = $(this).attr('name');
						$( '#' + menu_name + '-button .ui-selectmenu-text' ).html( ui.item.label.replace(/#([a-zA-Z0-9]{3}[a-zA-Z0-9]{3}?) - /g, '<span class="wpfc-cat-icon" style="background-color:#$1"></span>') );
						event_obj.data[menu_name] = ui.item.value;
						calendar.fullCalendar('removeEventSource', event_obj.ajaxurl);
						calendar.fullCalendar('addEventSource', {url : event_obj.ajaxurl, allDayDefault:false, ignoreTimezone: true, data : event_obj.data});
					}
				})
			}
			wpfc_loaded = true;
	    }
		};
		$('#calendar').fullCalendar(event_calendar_args);
	}
		
		function bah(view){
			console.log("done"+view);
		}
    

    /*	 eventSources: [

        // your event source
        {
            url: '/wp-json/wp/v2/events/',
            data: {date: 'venue._data_sdate'},
            dataType: 'json',
            method: 'GET',
            error: function() {
                alert('there was an error while fetching events!');
            },
            color: 'yellow',   // a non-ajax option
            textColor: 'black' // a non-ajax option
        }
    ]*/

  
//});

});

})( jQuery );
