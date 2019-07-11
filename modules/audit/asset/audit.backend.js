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
	if (toggleON) {
		jQuery( this ).removeClass( "fa-toggle-on" ).addClass( "fa-toggle-off" );
	} else {
		jQuery( this ).removeClass( "fa-toggle-off" ).addClass( "fa-toggle-on" );
	}
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
