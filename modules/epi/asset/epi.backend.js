window.eoxiaJS.digiriskEPI.epi = {};

window.eoxiaJS.digiriskEPI.epi.init = function() {
	window.eoxiaJS.digiriskEPI.epi.event();
};

window.eoxiaJS.digiriskEPI.epi.event = function() {
	jQuery( document ).on( 'keyup', '.table.epi .epi-row input[name="frequency_control"]', window.eoxiaJS.digiriskEPI.epi.activeSaveButton );
};

/**
 * Vérifie si le format du champ est bien numérique.
 * Si c'est le cas, rend le bouton "+" active.
 *
 * @since 0.1.0
 * @version 0.1.0
 *
 * @param  {KeyboardEvent} event L'état du clavier.
 * @return {void}
 */
window.eoxiaJS.digiriskEPI.epi.activeSaveButton = function( event ) {
	jQuery( this ).closest( '.epi-row' ).find( '.action-input.add' ).removeClass( 'blue' ).addClass( 'disable' );

	if ( Number.isInteger( parseInt( jQuery( this ).val() ) ) ) {
		jQuery( this ).closest( '.epi-row' ).find( '.action-input.add' ).removeClass( 'disable' ).addClass( 'blue' );
	}
};

/**
 * Le callback en cas de réussite à la requête Ajax "save_epi".
 * Remplaces le contenu de <tbody> du tableau "epi".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.1.0
 * @version 0.1.0
 */
window.eoxiaJS.digiriskEPI.epi.savedEpiSuccess = function( element, response ) {
  jQuery( '.digirisk-wrap' ).replaceWith( response.data.template );
};

/**
 * Le callback en cas de réussite à la requête Ajax "load_epi".
 * Remplaces la ligne courante du tableau "epi"
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.1.0
 * @version 0.1.0
 */
window.eoxiaJS.digiriskEPI.epi.loadedEpiSuccess = function( element, response ) {
  jQuery( element ).closest( 'tr' ).replaceWith( response.data.template );
};

/**
 * Le callback en cas de réussite à la requête Ajax "delete_epi".
 * Supprimes la ligne courante du tableau "epi"
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.1.0
 * @version 0.1.0
 */
window.eoxiaJS.digiriskEPI.epi.deletedEpiSuccess = function( element, response ) {
  jQuery( element ).closest( 'tr' ).fadeOut();
};

/**
 * Vérifie si le champ période de controle est bien un nombre pour continuer le formulaire d'ajout d'un EPI.
 *
 * @param  {HTMLDivElement} element Le bouton pour ajouter un EPI
 * @return {boolean}
 *
 * @since 0.1.0
 * @version 0.1.0
 */
window.eoxiaJS.digiriskEPI.epi.checkData = function( element ) {
	if ( isNaN( jQuery( element ).closest( '.epi-row' ).find( 'input[name="frequency_control"]' ).val() ) || '' == jQuery( element ).closest( '.epi-row' ).find( 'input[name="frequency_control"]' ).val() ) {
		jQuery( element ).closest( '.epi-row' ).find( 'td.tooltip' ).addClass( 'active' );
		return false;
	}

	jQuery( element ).closest( '.epi-row' ).find( 'td.tooltip.active' ).removeClass( 'active' );

	return true;
};
