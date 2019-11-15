/**
* JS Lié au Frontend de l'objet contrôle.
 *
 * Initialise l'objet "contrôle" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 0.1.0
 * @version 0.6.0
 */
window.eoxiaJS.theEPIFrontEnd.control = {};

window.eoxiaJS.theEPIFrontEnd.control.init = function() {
	window.eoxiaJS.theEPIFrontEnd.control.event();
};

window.eoxiaJS.theEPIFrontEnd.control.event = function() {
};

/**
 * Le callback en cas de réussite à la requête Ajax "display_control".
 * Affiche le modal de contrôle d'un EPI et la liste des contrôles déjà effectués.
 *
 * @since 0.7.0
 * @version 0.7.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPIFrontEnd.control.displayControlSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.entry-content' ).append( response.data.view );
};
