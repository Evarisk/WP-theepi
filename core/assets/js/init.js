window.eoxiaJS.theEPI = {};

window.eoxiaJS.theEPI.core = {};

/**
 * Keep the button in memory.
 *
 * @type {Object}
 */
window.eoxiaJS.theEPI.core.currentButton;

/**
 * Keep the media frame in memory.
 * @type {Object}
 */
window.eoxiaJS.theEPI.core.mediaFrame;

/**
 * Keep the selected media in memory.
 * @type {Object}
 */
window.eoxiaJS.theEPI.core.selectedInfos = [];

window.eoxiaJS.theEPI.core.init = function() {
	window.eoxiaJS.theEPI.core.event();
};

window.eoxiaJS.theEPI.core.event = function() {
	jQuery( document ).on( 'click', '.digirisk-epi .create-mass-epi', window.eoxiaJS.theEPI.core.openMedia );
};

window.eoxiaJS.theEPI.core.openMedia = function( event ) {
	window.eoxiaJS.theEPI.core.currentButton = jQuery( this );
	event.preventDefault();

	window.eoxiaJS.theEPI.core.mediaFrame = new window.wp.media.view.MediaFrame.Post({}).open();
	window.eoxiaJS.theEPI.core.mediaFrame.on( 'insert', function() { window.eoxiaJS.theEPI.core.selectedFile(); } );
};

window.eoxiaJS.theEPI.core.selectedFile = function() {
	window.eoxiaJS.theEPI.core.mediaFrame.state().get( 'selection' ).map( function( attachment ) {
		window.eoxiaJS.theEPI.core.selectedInfos.push( attachment.id );
	} );

	var data = {
		action: 'create_mass_epi',
		files_id: window.eoxiaJS.theEPI.core.selectedInfos
	};

	window.eoxiaJS.theEPI.core.currentButton.addClass( 'loading' );
	jQuery.post( window.ajaxurl, data, function( response ) {
		window.eoxiaJS.theEPI.core.currentButton.removeClass( 'loading' );

		window.eoxiaJS.theEPI.core.currentButton = undefined;
		window.eoxiaJS.theEPI.core.selectedInfos = [];
		window.eoxiaJS.theEPI.core.mediaFrame = undefined;

		jQuery( '.digirisk-epi table tbody' ).html( response );
	} );
};
