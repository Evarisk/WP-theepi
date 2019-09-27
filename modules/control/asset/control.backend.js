/**
 * Initialise l'objet "EPI" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 0.1.0
 * @version 0.6.0
 */
window.eoxiaJS.theEPI.control = {};

window.eoxiaJS.theEPI.control.init = function() {
	window.eoxiaJS.theEPI.control.event();
};

window.eoxiaJS.theEPI.control.event = function() {
	jQuery( document ).on( 'click', 'body .table-status-control .dropdown-item',  window.eoxiaJS.theEPI.control.updateStatusControl );
};

/**
 * Le callback en cas de réussite à la requête Ajax "control_epi".
 * Affiche le modal template pour effecter le contrôle.
 *
 * @since 0.5.0
 * @version 0.5.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.control.displayControlSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.table-row' ).append( response.data.view );
};

/**
 * Le callback en cas de réussite à la requête Ajax "create_epi".
 * Affiche la vue Edition et Service d'un EPI pour la création.
 *
 * @since 0.1.0
 * @version 0.6.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.control.createdControlSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.modal-control-epi' ).find( '.tab-container .new-row-control-epi' ).html( response.data.view );

};

/**
 * Le callback en cas de réussite à la requête Ajax "create_epi".
 * Affiche la vue Edition et Service d'un EPI pour la création.
 *
 * @since 0.1.0
 * @version 0.6.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.control.editedControlSuccess = function( triggeredElement, response ) {
	var id = triggeredElement.attr( 'data-id' );
	triggeredElement.closest( '.modal-control-epi' ).find( '.table-row.epi-control-row.view[data-id="' + id + '"]' ).replaceWith( response.data.view);

};

/**
 * Le callback en cas de réussite à la requête Ajax "create_epi".
 * Affiche la vue Edition et Service d'un EPI pour la création.
 *
 * @since 0.1.0
 * @version 0.6.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.control.savedControlSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.modal-content' ).html( response.data.view );
};
 
window.eoxiaJS.theEPI.control.updateStatusControl = function ( event ) {
	var status = jQuery( this ).attr( 'data-status' );
	var parent_element = jQuery( this ).closest( '.table-status-control' );
	parent_element.find( 'input[name="status-control"]' ).val( status );

	var this_html = jQuery( this ).html();
	parent_element.find( '.dropdown-toggle' ).html( this_html );

};

/**
 * Le callback en cas de réussite à la requête Ajax "cancel_edit_epi".
 * Annule le mode édition d'un "epi".
 *
 * @since 0.1.0
 * @version 0.5.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.control.canceledEditControlEpiSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.table-row' ).replaceWith( response.data.view );
};

/**
 * Le callback en cas de réussite à la requête Ajax "delete_epi".
 * Supprimes la ligne courante du tableau "epi".
 *
 * @since 0.1.0
 * @version 0.4.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.control.deletedControlEpiSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.table-row' ).fadeOut();
};
