/**
 * Initialise l'objet "setting" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 0.2.0
 * @version 0.2.0
 */
window.eoxiaJS.digiriskEPI.setting = {};

window.eoxiaJS.digiriskEPI.setting.init = function() {
	window.eoxiaJS.digiriskEPI.setting.event();
};

window.eoxiaJS.digiriskEPI.setting.event = function() {
	jQuery( document ).on( 'click', '.settings_page_digirisk-epi-setting .list-users .wp-digi-pagination a', window.eoxiaJS.digiriskEPI.setting.pagination );
};

/**
 * Gestion de la pagination des utilisateurs.
 *
 * @param  {ClickEvent} event [description]
 * @return {void}
 *
 * @since 0.2.0
 * @version 0.2.0
 */
window.eoxiaJS.digiriskEPI.setting.pagination = function( event ) {
	var href = jQuery( this ).attr( 'href' ).split( '&' );
	var nextPage = href[1].replace( 'current_page=', '' );

	jQuery( '.list-users' ).addClass( 'loading' );

	var data = {
		action: 'paginate_setting_epi_page_user',
		next_page: nextPage
	};

	event.preventDefault();

	jQuery.post( window.ajaxurl, data, function( view ) {
		jQuery( '.list-users' ).replaceWith( view );
		window.eoxiaJS.digirisk.search.renderChanged();
	} );
};

/**
 * Le callback en cas de réussite à la requête Ajax "save_capacity".
 * Affiches le message de "success".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.2.0
 * @version 0.2.0
 */
window.eoxiaJS.digiriskEPI.setting.savedCapability = function( triggeredElement, response ) {
};
