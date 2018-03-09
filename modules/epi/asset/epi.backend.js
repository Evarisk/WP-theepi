/**
 * Initialise l'objet "EPI" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 0.1.0
 * @version 0.4.0
 */
window.eoxiaJS.theEPI.EPI = {};

window.eoxiaJS.theEPI.EPI.init = function() {
	window.eoxiaJS.theEPI.EPI.event();
};

window.eoxiaJS.theEPI.EPI.event = function() {
	jQuery( document ).on( 'keyup', '.wrap-theepi .wpeo-table.epi .epi-row input[name="frequency_control"]', window.eoxiaJS.theEPI.EPI.activeSaveButton );
	jQuery( document ).on( 'click', '.wrap-theepi .scroll-top', window.eoxiaJS.theEPI.EPI.scrollTop );

};

/**
 * Vérifie si le format du champ est bien numérique.
 * Si c'est le cas:
 * -Et que la popover est ouverte, la supprimes.
 * -Et rend le bouton ".add" active.
 *
 * @since 0.1.0
 * @version 0.4.0
 *
 * @param  {KeyboardEvent} event L'état du clavier.
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.activeSaveButton = function( event ) {
	jQuery( this ).closest( '.epi-row' ).find( '.action-input.add' ).addClass( 'button-disable' );

	if ( Number.isInteger( parseInt( jQuery( this ).val() ) ) ) {
		jQuery( this ).closest( '.epi-row' ).find( '.action-input.add' ).removeClass( 'button-disable' );
		window.eoxiaJS.popover.remove( jQuery( this ).closest( '.epi-row' ).find( 'input.wpeo-popover-event' ) );
	}
};

/**
 * Remontes tout en haut de la page.
 *
 * @since 0.4.0
 * @version 0.4.0
 *
 * @param  {ClickEvent} event L'état du clavier.
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.scrollTop = function( event ) {
	jQuery( 'html, body' ).animate( {
		scrollTop: jQuery( '.wrap-theepi' ).offset().top
	}, 500) ;
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
 * @version 0.4.0
 */
window.eoxiaJS.theEPI.EPI.savedEpiSuccess = function( triggeredElement, response ) {
	var epiView = jQuery( response.data.epi_view );

	if ( response.data.new_epi ) {
		window.eoxiaJS.theEPI.EPI.refreshTextLoadMore( 1, 1 );
		triggeredElement.closest( '.epi-row' ).find( '.action-input.add' ).addClass( 'button-disable' );

		window.eoxiaJS.form.reset( triggeredElement.closest( '.epi-row' ) );
		jQuery( '.wrap-theepi .wpeo-table.epi tbody .epi-row' ).after( epiView );
		setTimeout( function() {
			epiView.addClass( 'animate' );
		}, 10 );
	} else {
		triggeredElement.closest( 'tr' ).replaceWith( epiView );
	}
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
 * @version 0.4.0
 */
window.eoxiaJS.theEPI.EPI.loadedEpiSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( 'tr' ).replaceWith( response.data.template );
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
 * @version 0.4.0
 */
window.eoxiaJS.theEPI.EPI.deletedEpiSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( 'tr' ).fadeOut();
};

/**
 * Le callback en cas de réussite à la requête Ajax "load_more_epi".
 * Ajoutes des entrées à la fin du <tbody> du tableau .wpeo-table.epi.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.4.0
 * @version 0.4.0
 */
window.eoxiaJS.theEPI.EPI.loadedMoreEPISuccess = function( triggeredElement, response ) {
	var element   = jQuery( response.data.view );
	var countMore = response.data.count_more ? response.data.count_more : parseInt( jQuery( '#epi_per_page' ).val() );

	jQuery( '.wrap-theepi .wpeo-table.epi tbody' ).append( element );

	window.eoxiaJS.theEPI.EPI.refreshTextLoadMore( countMore, 0 );

	setTimeout( function() {
		element.addClass( 'fadeInUp animate-on' );

		jQuery( 'html, body' ).animate( {
			scrollTop: jQuery( '.load-more' ).offset().top
		}, 1000 );
	}, 10 )
};

/**
 * Le callback en cas de réussite à la requête Ajax "search_epi".
 * Remplaces tout le tableau avec la bouton "load_more".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.4.0
 * @version 0.4.0
 */
window.eoxiaJS.theEPI.EPI.searchedEPISuccess = function( triggeredElement, response ) {
	jQuery( '.wrap-theepi .container-content' ).html( response.data.view );

	if ( ! response.data.clear ) {
		jQuery( '.wrap-theepi .box-search .action-attribute' ).removeClass( 'button-disable' );
		jQuery( '.wrap-theepi .load-more' ).attr( 'data-term', jQuery( '.wrap-theepi .box-search input[type="text"]' ).val() );
	} else {
		jQuery( '.wrap-theepi .box-search input[type="text"]' ).val( '' );
		jQuery( '.wrap-theepi .box-search .action-attribute' ).addClass( 'button-disable' );
		jQuery( '.wrap-theepi .load-more' ).attr( 'data-term', '' );
	}
};

/**
 * Vérifie si le champ période de controle est bien un nombre pour continuer le formulaire d'ajout d'un EPI.
 *
 * @param  {HTMLDivElement} element Le bouton pour ajouter un EPI
 * @return {boolean}
 *
 * @since 0.1.0
 * @version 0.4.0
 */
window.eoxiaJS.theEPI.EPI.checkData = function( element ) {
	window.eoxiaJS.popover.remove( element.closest( '.epi-row' ).find( 'input.wpeo-popover-event' ) );

	if ( isNaN( element.closest( '.epi-row' ).find( 'input[name="frequency_control"]' ).val() ) || '' == element.closest( '.epi-row' ).find( 'input[name="frequency_control"]' ).val() ||
		( element.closest( '.epi-row' ).find( 'input[name="frequency_control"]' ).val() && '0' == element.closest( '.epi-row' ).find( 'input[name="frequency_control"]' ).val() ) ) {
		window.eoxiaJS.popover.toggle( element.closest( '.epi-row' ).find( 'input.wpeo-popover-event' ) );
		return false;
	}

	window.eoxiaJS.popover.remove( element.closest( '.epi-row' ).find( 'input.wpeo-popover-event' ) );

	return true;
};

/**
 * Met à jour l'affichage du bouton "Load More" en bas de la page.
 *
 * @since 0.4.0
 * @version 0.4.0
 *
 * @param  {number} addNumberEPI      Le nombre d'EPI affiché dans le tableau.
 * @param  {number} addTotalNumberEPI Le nombre total d'EPI dans la base de donnée.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.refreshTextLoadMore = function( addNumberEPI, addTotalNumberEPI ) {
	var currentOffset =  currentNumberEPI = totalNumberEPI = 0;

	currentNumberEPI  = parseInt( jQuery( '.wrap-theepi .load-more .number-epi' ).text() );
	currentNumberEPI += addNumberEPI;

	totalNumberEPI  = parseInt( jQuery( '.wrap-theepi .load-more .total-number-epi' ).text() );
	totalNumberEPI += addTotalNumberEPI;

	if ( currentNumberEPI >= totalNumberEPI ) {
		currentNumberEPI = totalNumberEPI;
		jQuery( '.wrap-theepi .load-more' ).addClass( 'button-disable' );
	} else {
		jQuery( '.wrap-theepi .load-more' ).removeClass( 'button-disable' );
	}

	jQuery( '.wrap-theepi .load-more .number-epi' ).text( currentNumberEPI );


	jQuery( '.wrap-theepi .load-more .total-number-epi' ).text( totalNumberEPI );

	currentOffset = parseInt( jQuery( '.wrap-theepi .load-more' ).attr( 'data-offset' ) );
	currentOffset += addNumberEPI;
	jQuery( '.wrap-theepi .load-more' ).attr( 'data-offset', currentOffset );

}
