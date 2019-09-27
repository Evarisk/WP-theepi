/**
 * Initialise l'objet "EPI" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 0.1.0
 * @version 0.6.0
 */
window.eoxiaJS.theEPI.service = {};

window.eoxiaJS.theEPI.service.init = function() {
	window.eoxiaJS.theEPI.service.event();
};

window.eoxiaJS.theEPI.service.event = function() {
	jQuery( document ).on( 'click', '.epi-row.service.date .button-toggle', window.eoxiaJS.theEPI.service.buttonToggle );

};

/**
 * Récupère l'état du bouton toggle.
 *
 * @since 0.5.0
 * @version 0.5.0
 *
 * @param  {ClickEvent} event [t]
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.service.buttonToggle = function( event ) {

	var toggleON = jQuery( this ).hasClass( 'fa-toggle-on' );
	var nextStep = '';
	if (toggleON) {

		nextStep = 'NO';
		jQuery( this ).removeClass( "fa-toggle-on" ).addClass( "fa-toggle-off" );
		jQuery( this ).closest( '.epi-row.service.date' ).find( '.modal-footer' ).find( '.wpeo-button' ).attr('data-status-epi', 'NO' );
		jQuery( this ).closest( ".button-toggle" ).find( '.button-toggle-OK' ).attr({ 'style' : 'color : grey; font-weight : auto' });
		jQuery( this ).closest( ".button-toggle" ).find( '.button-toggle-KO' ).attr({ 'style' : 'color : black; font-weight : bold' });
		jQuery( this ).closest( ".epi-row.service.date" ).find( '.lifetime' ).hide();
		jQuery( this ).closest( ".epi-row.service.date" ).find( '.end-life-date' ).hide();

	} else {

		nextStep = 'YES';
		jQuery( this ).removeClass( "fa-toggle-off" ).addClass( "fa-toggle-on" );
		jQuery( this ).closest( '.epi-row.service.date' ).find( '.modal-footer' ).find( '.wpeo-button' ).attr('data-status-epi', 'YES' );
		jQuery( this ).closest( ".button-toggle" ).find( '.button-toggle-OK' ).attr({ 'style' : 'color : black; font-weight : bold' });
		jQuery( this ).closest( ".button-toggle" ).find( '.button-toggle-KO' ).attr({ 'style' : 'color : grey; font-weight : auto' });
		jQuery( this ).closest( ".epi-row.service.date" ).find( '.lifetime' ).show();
		jQuery( this ).closest( ".epi-row.service.date" ).find( '.end-life-date' ).show();


	}

	var id = jQuery( this ).closest( '.button-toggle' ).attr( 'data-id' );
	var action = jQuery( this ).closest( '.button-toggle' ).attr( 'data-action' );
	var nonce = jQuery( this ).closest( '.button-toggle' ).attr( 'data-nonce' );
	var data = {
		action: action,
		_wpnonce: nonce,
		id: id,
		next_step: nextStep
	};

	window.eoxiaJS.loader.display( jQuery( this ).closest( '.button-toggle' ) );
	window.eoxiaJS.request.send( jQuery( this ), data );

};
