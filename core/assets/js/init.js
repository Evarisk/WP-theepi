window.eoxiaJS.digiriskEPI = {};

window.eoxiaJS.digiriskEPI.core = {};

/**
 * Keep the button in memory.
 *
 * @type {Object}
 */
window.eoxiaJS.digiriskEPI.core.currentButton;

/**
 * Keep the media frame in memory.
 * @type {Object}
 */
window.eoxiaJS.digiriskEPI.core.mediaFrame;

/**
 * Keep the selected media in memory.
 * @type {Object}
 */
window.eoxiaJS.digiriskEPI.core.selectedInfos = [];

window.eoxiaJS.digiriskEPI.core.init = function() {
	window.eoxiaJS.digiriskEPI.core.event();
};

window.eoxiaJS.digiriskEPI.core.event = function() {
	jQuery( document ).on( 'click', '.digirisk-epi .create-mass-epi', window.eoxiaJS.digiriskEPI.core.openMedia );
};

window.eoxiaJS.digiriskEPI.core.openMedia = function( event ) {
	window.eoxiaJS.digiriskEPI.core.currentButton = jQuery( this );
	event.preventDefault();

	window.eoxiaJS.digiriskEPI.core.mediaFrame = new window.wp.media.view.MediaFrame.Post({}).open();
	window.eoxiaJS.digiriskEPI.core.mediaFrame.on( 'insert', function() { window.eoxiaJS.digiriskEPI.core.selectedFile(); } );
};

window.eoxiaJS.digiriskEPI.core.selectedFile = function() {
	window.eoxiaJS.digiriskEPI.core.mediaFrame.state().get( 'selection' ).map( function( attachment ) {
		window.eoxiaJS.digiriskEPI.core.selectedInfos.push( attachment.id );
	} );

	var data = {
		action: 'create_mass_epi',
		files_id: window.eoxiaJS.digiriskEPI.core.selectedInfos
	};

	window.eoxiaJS.digiriskEPI.core.currentButton.addClass( 'loading' );
	jQuery.post( window.ajaxurl, data, function( response ) {
		window.eoxiaJS.digiriskEPI.core.currentButton.removeClass( 'loading' );

		window.eoxiaJS.digiriskEPI.core.currentButton = undefined;
		window.eoxiaJS.digiriskEPI.core.selectedInfos = [];
		window.eoxiaJS.digiriskEPI.core.mediaFrame = undefined;

		jQuery( '.digirisk-epi table tbody' ).html( response );
	} );
};
