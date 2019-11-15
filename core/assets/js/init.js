window.eoxiaJS.theEPI = {};

window.eoxiaJS.theEPIFrontEnd = {};

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
  var action = {
    action: 'theepi_have_patch_note',
  };

  jQuery.post( ajaxurl, action, function ( response ) {
    if ( response.data.status ) {
      jQuery( '.wrap-theepi' ).append( response.data.view );
    }
  } );
};

window.eoxiaJS.theEPI.core.event = function() {
	jQuery( document ).on( 'click', '.wrap-theepi .create-mass-epi', window.eoxiaJS.theEPI.core.openMedia );
  jQuery( document ).on( 'click', '.wrap-theepi .wpeo-notification.patch-note.notification-active', window.eoxiaJS.theEPI.core.openPopup );
  jQuery( document ).on( 'click', '.wrap-theepi .wpeo-notification.patch-note .notification-close', window.eoxiaJS.theEPI.core.closeNotification );
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

	window.eoxiaJS.loader.display( window.eoxiaJS.theEPI.core.currentButton );
	jQuery.post( window.ajaxurl, data, function( response ) {
		var epiView = jQuery( response );
		window.eoxiaJS.loader.remove( window.eoxiaJS.theEPI.core.currentButton );

		window.eoxiaJS.theEPI.core.currentButton = undefined;
		window.eoxiaJS.theEPI.core.selectedInfos = [];
		window.eoxiaJS.theEPI.core.mediaFrame = undefined;

		jQuery( '.wrap-theepi .wpeo-table.epi .tab-container' ).prepend( epiView );
		setTimeout( function() {
			epiView.addClass( 'animate' );
		}, 100 );
	} );
};

/**
 * Ajoutes la classe 'active' dans l'élement 'popup.path-note'.
 *
 * @since 6.3.0
 * @version 6.3.0
 *
 * @param  {MouseEvent} event Les attributs de l'évènement.
 * @return {void}
 */
window.eoxiaJS.theEPI.core.openPopup = function( event ) {
  event.stopPropagation();
  event.preventDefault();
  jQuery( '.wrap-theepi .wpeo-modal.patch-note' ).addClass( 'modal-active' );
};

/**
 * Ajoutes la classe 'active' dans l'élement 'popup.path-note'.
 *
 * @since 6.3.0
 * @version 6.3.0
 *
 * @param  {MouseEvent} event Les attributs de l'évènement.
 * @return {void}
 */
window.eoxiaJS.theEPI.core.closeNotification = function( event ) {
  event.stopPropagation();
  jQuery( this ).closest( '.wpeo-notification' ).removeClass( 'notification-active' );
};
