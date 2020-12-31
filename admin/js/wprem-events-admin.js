(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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

	 $( window ).load(function() {
	 	$( "select#wp_eventview_id" ).change(function () {
	    var str = "";
	    var selected = "";
	    selected = $( "select#wp_eventview_id option:selected" ).text();
	    if (selected != 'Calendar'){
	    	$( "#for-list" ).show();	
	    }
	    else{
	    	$( "#for-list" ).hide();		
	    }
	    
	  }).change();
	 });

	 

	 $(document).on("click","#event-insert", function(){
	 	event_container();
	 });

	 function event_container(){
		var id = $('#wp_event_id').val() ? ' id='+$('#wp_event_id').val() : '';
		var view = $('#wp_eventview_id').val() ? ' view="'+$('#wp_eventview_id').val()+'"' : '';
		var display = $('#wp_eventshow').val() ? ' display="'+$('#wp_eventshow').val()+'"' : '';
		var order = $('#wp_eventorder').val() ? ' order="'+$('#wp_eventorder').val()+'"' : '';
		//var service = $('#wp_allservices_id').val() ? ' service="'+$('#wp_allservices_id').val()+'"' : '';

		window.send_to_editor("[wp_events"+id+view+display+order+"]");		
	 }


})( jQuery );
