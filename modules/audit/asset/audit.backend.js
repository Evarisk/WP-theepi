/**
 * Initialise l'objet "audit" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 0.5.0
 * @version 0.5.0
 */

window.eoxiaJS.theEPI.Audit = {};

window.eoxiaJS.theEPI.Audit.init = function() {
	window.eoxiaJS.theEPI.Audit.event();
};

window.eoxiaJS.theEPI.Audit.event = function() {
	jQuery( document ).on( 'click', '.modal-header .button-toggle', window.eoxiaJS.theEPI.Audit.buttonToggle );

};

window.eoxiaJS.theEPI.Audit.buttonToggle = function( event ) {

	var toggleON = jQuery( this ).hasClass( 'fa-toggle-on' );
	var nextStep = '';
	if (toggleON) {

		nextStep = 'KO';
		jQuery( this ).removeClass( "fa-toggle-on" ).addClass( "fa-toggle-off" );
		jQuery( this ).closest( '.modal-container' ).find( '.modal-footer' ).find( '.wpeo-button' ).attr('data-status-epi', 'KO' );
		jQuery( this ).closest( ".button-toggle-modal-headear" ).find( '.button-toggle-OK' ).attr({ 'style' : 'color : grey; font-weight : auto' });
		jQuery( this ).closest( ".button-toggle-modal-headear" ).find( '.button-toggle-KO' ).attr({ 'style' : 'color : black; font-weight : bold' });

	} else {

		nextStep = 'OK';
		jQuery( this ).removeClass( "fa-toggle-off" ).addClass( "fa-toggle-on" );
		jQuery( this ).closest( '.modal-container' ).find( '.modal-footer' ).find( '.wpeo-button' ).attr('data-status-epi', 'OK' );
		jQuery( this ).closest( ".button-toggle-modal-headear" ).find( '.button-toggle-OK' ).attr({ 'style' : 'color : black; font-weight : bold' });
		jQuery( this ).closest( ".button-toggle-modal-headear" ).find( '.button-toggle-KO' ).attr({ 'style' : 'color : grey; font-weight : auto' });

	}

	var id = jQuery( this ).closest( '.button-toggle-modal-headear' ).attr( 'data-id' );
	var action = jQuery( this ).closest( '.button-toggle-modal-headear' ).attr( 'data-action' );
	var nonce = jQuery( this ).closest( '.button-toggle-modal-headear' ).attr( 'data-nonce' );
	var data = {
		action: action,
		_wpnonce: nonce,
		id: id,
		next_step: nextStep
	};

	window.eoxiaJS.loader.display( jQuery( this ).closest( '.button-toggle-modal-headear' ) );
	window.eoxiaJS.request.send( jQuery( this ), data );

};

/**
 * Le callback en cas de réussite à la requête Ajax "create_task_audit".
 * Remplaces la ligne courante du tableau "epi"
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.5.0
 * @version 0.5.0
 */
window.eoxiaJS.theEPI.Audit.createdTaskAuditSuccess = function( triggeredElement, response ) {
	console.log( 'OK ');
	console.log( response.data.view  );
	var element = triggeredElement.closest( '.modal-container' ).find( '.modal-content' );
	var content = element.html();
	element.html( response.data.view + content );
};

/**
 * Le callback en cas de réussite à la requête Ajax "create_task_audit".
 * Remplaces la ligne courante du tableau "epi"
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.5.0
 * @version 0.5.0
 */
window.eoxiaJS.theEPI.Audit.ImportedTaskAuditSuccess = function( triggeredElement, response ) {
	console.log( 'OK ');
	console.log( response.data.view  );
	var element = triggeredElement.closest( '.wpeo-modal' );
	element .replaceWith( response.data.view );

};

/**
 * Le callback en cas de réussite à la requête Ajax "create_task_audit".
 * Remplaces la ligne courante du tableau "epi"
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.5.0
 * @version 0.5.0
 */
window.eoxiaJS.theEPI.Audit.ImportedButtonTaskAuditSuccess = function( triggeredElement, response ) {
	var header = triggeredElement.closest( '.wpeo-modal' ).find( '.modal-header' ).find('.modal-title-header');
	header.html( response.data.modal_title );
	var content = triggeredElement.closest( '.wpeo-modal' ).find( '.modal-content' );
	content.html( response.data.view );
	var footer = triggeredElement.closest( '.wpeo-modal' ).find( '.modal-footer' );
	footer.html( response.data.buttons_view);

};

window.eoxiaJS.theEPI.Audit.ControlEPISuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.epi-row' ).find( '.control_audit' ).html( response.data.view_item );
	triggeredElement.parent().append( response.data.modal_template );
};

window.eoxiaJS.theEPI.Audit.DisplayControlEPISuccess = function( triggeredElement, response ) {
	triggeredElement.parent().append( response.data.modal_template );
};







/**
 * Le callback en cas de réussite à la requête Ajax "create_task_audit".
 * Remplaces la ligne courante du tableau "epi"
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.5.0
 * @version 0.5.0
 */
window.eoxiaJS.theEPI.Audit.ValidAuditSuccess = function( triggeredElement, response ) {
	jQuery( '.wrap .container-content .epi .epi-row[ data-id="' + response.data.id + '"]' ).replaceWith( response.data.view );
};

window.eoxiaJS.theEPI.Audit.GetContentFromUrlAuditSuccess = function( triggeredElement, response ){
    if( response.data.content != "" ){
        triggeredElement.closest( '.modal-content' ).find( 'textarea[ name="content"]' ).html( response.data.content );
    }
}

window.eoxiaJS.theEPI.Audit.DisplayAllAuditSuccess = function( triggeredElement, response ) {
	var toggleChevron = triggeredElement.find( '.icon' ).hasClass( 'fa-chevron-right' );

	if (toggleChevron) {
		triggeredElement.closest( '.control_audit').html( response.data.view ).find( '.icon' ).removeClass( "fa-chevron-right" ).addClass( "fa-chevron-down" );
		triggeredElement.closest( '.control_audit').html( response.data.view );
	} else {
		triggeredElement.closest( '.control_audit').html( response.data.view ).find( '.icon' ).removeClass( "fa-chevron-down" ).addClass( "fa-chevron-right" );
		jQuery( '.wrap .container-content .epi .epi-row[ data-id="' + response.data.id + '"]' ).find( '.control_audit').html( response.data.single_view_audit );

	}
};
