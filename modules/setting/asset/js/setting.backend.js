/**
 * Initialise l'objet "setting" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 0.2.0
 * @version 0.3.0
 */
window.eoxiaJS.theEPI.setting = {};

window.eoxiaJS.theEPI.setting.init = function() {
	window.eoxiaJS.theEPI.setting.event();
};

window.eoxiaJS.theEPI.setting.event = function() {
	jQuery( document ).on( 'click', '.settings_page_theepi-setting .list-users .wp-digi-pagination a', window.eoxiaJS.theEPI.setting.pagination );
	jQuery( document ).on( 'click', '.wpeo-tab.setting .tab-redirect .tab-element', window.eoxiaJS.theEPI.EPI.tabRedirect );
};

/**
 * Changes d'onglet lors du clic.
 *
 * @since 0.3.0
 * @version 0.3.0
 *
 * @param  {ClickEvent} event L'état de la souris lors du clic.
 * @return {void}
 */

window.eoxiaJS.theEPI.EPI.tabRedirect = function( event ){
    var url = jQuery( this ).attr( 'data-url' );
    window.location.href = url;
}

/**
 * Gestion de la pagination des utilisateurs.
 *
 * @since 0.2.0
 * @version 0.2.0
 *
 * @param  {ClickEvent} event [description]
 * @return {void}
 */
window.eoxiaJS.theEPI.setting.pagination = function( event ) {
	var href = jQuery( this ).attr( 'href' ).split( '&' );
	var nextPage = href[1].replace( 'current_page=', '' );

	jQuery( '.list-users' ).addClass( 'loading' );

	var data = {
		action: 'paginate_setting_theepi_page_user',
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
 * @since 0.2.0
 * @version 0.2.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 */
window.eoxiaJS.theEPI.setting.savedCapability = function( triggeredElement, response ) {
};

/**
 * Le callback en cas de réussite à la requête Ajax "save_default_data".
 * Affiches le message de "success".
 *
 * @since 0.3.0
 * @version 0.3.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 */
window.eoxiaJS.theEPI.setting.savedDefaultData = function( triggeredElement, response ) {
	triggeredElement.addClass( 'button-success' );
	setTimeout( function() {
		triggeredElement.removeClass( 'button-success' );
	}, 1000 );
};

/**
 * Le callback en cas de réussite à la requête Ajax "save_date_management".
 * Affiches le message de "success".
 *
 * @since 0.5.0
 * @version 0.5.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 */
window.eoxiaJS.theEPI.setting.savedDateManagement = function( triggeredElement, response ) {
	triggeredElement.addClass( 'button-success' );
	setTimeout( function() {
		triggeredElement.removeClass( 'button-success' );
	}, 1000 );
};
