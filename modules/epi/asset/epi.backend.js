/**
 * Initialise l'objet "EPI" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 0.1.0
 * @version 0.2.0
 */
window.eoxiaJS.theEPI.EPI = {};

window.eoxiaJS.theEPI.EPI.init = function() {
	window.eoxiaJS.theEPI.EPI.event();
};

window.eoxiaJS.theEPI.EPI.event = function() {
	jQuery( document ).on( 'keyup', '.table.epi .epi-row input[name="frequency_control"]', window.eoxiaJS.theEPI.EPI.activeSaveButton );

	jQuery( document ).on( 'click', '.digirisk-epi .wp-digi-pagination a', window.eoxiaJS.theEPI.EPI.pagination );
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
window.eoxiaJS.theEPI.EPI.activeSaveButton = function( event ) {
	jQuery( this ).closest( '.epi-row' ).find( '.action-input.add' ).removeClass( 'blue' ).addClass( 'disable' );

	if ( Number.isInteger( parseInt( jQuery( this ).val() ) ) ) {
		jQuery( this ).closest( '.epi-row' ).find( '.action-input.add' ).removeClass( 'disable' ).addClass( 'blue' );
	}
};

/**
 * Gestion de la pagination des EPI.
 *
 * @param  {ClickEvent} event [description]
 * @return {void}
 *
 * @since 0.2.0
 * @version 0.2.0
 */
window.eoxiaJS.theEPI.EPI.pagination = function( event ) {
	var href = jQuery( this ).attr( 'href' ).split( '&' );
	var currentPage = href[1].replace( 'current_page=', '' );

	window.eoxiaJS.loader.display( jQuery( '.digirisk-epi' ) );

	var data = {
		action: 'paginate_epi',
		current_page: currentPage
	};

	event.preventDefault();

	jQuery.post( window.ajaxurl, data, function( view ) {
		window.eoxiaJS.loader.remove( jQuery( '.digirisk-epi' ) );
		jQuery( '.digirisk-epi .container-content' ).html( view );
	} );
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
window.eoxiaJS.theEPI.EPI.savedEpiSuccess = function( element, response ) {
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
window.eoxiaJS.theEPI.EPI.loadedEpiSuccess = function( element, response ) {
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
window.eoxiaJS.theEPI.EPI.deletedEpiSuccess = function( element, response ) {
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
window.eoxiaJS.theEPI.EPI.checkData = function( element ) {
	if ( isNaN( jQuery( element ).closest( '.epi-row' ).find( 'input[name="frequency_control"]' ).val() ) || '' == jQuery( element ).closest( '.epi-row' ).find( 'input[name="frequency_control"]' ).val() ) {
		jQuery( element ).closest( '.epi-row' ).find( 'td.tooltip' ).addClass( 'active' );
		return false;
	}

	jQuery( element ).closest( '.epi-row' ).find( 'td.tooltip.active' ).removeClass( 'active' );

	return true;
};
