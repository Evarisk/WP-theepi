/**
 * Initialise l'objet "EPI" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 0.1.0
 * @version 0.6.0
 */
window.eoxiaJS.theEPI.EPI = {};

window.eoxiaJS.theEPI.EPI.init = function() {
	window.eoxiaJS.theEPI.EPI.event();
};

window.eoxiaJS.theEPI.EPI.event = function() {
	jQuery( document ).on( 'keyup', '.wrap-theepi .wpeo-table.epi .epi-row input[name="periodicity"]', window.eoxiaJS.theEPI.EPI.activeSaveButton );
	jQuery( document ).on( 'click', '.wrap-theepi .wpeo-table .edit .button-save-epi', window.eoxiaJS.theEPI.EPI.saveEPIAjax );
	jQuery( document ).on( 'click', '.wrap-theepi .wpeo-tab.epi .tab-redirect .tab-element', window.eoxiaJS.theEPI.EPI.tabRedirect );
	jQuery( document ).on( 'click', '.wrap-theepi .action-request-edit-epi', window.eoxiaJS.theEPI.EPI.requestEpiEdit );

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
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.activeSaveButton = function( event ) {

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
window.eoxiaJS.theEPI.EPI.CreatedEpiSuccess = function( triggeredElement, response ) {

	jQuery( '.wpeo-table.epi .epi-row.edit[data-id="' + response.data.close_epi_id + '"]' ).replaceWith( response.data.view_close );
	jQuery( '.wpeo-table.epi .epi-row.service[data-id="' + response.data.close_epi_id + '"]' ).remove();
	jQuery( '.wpeo-table.epi .tab-container' ).prepend( response.data.view_edit_epi );
	jQuery( '.wpeo-table.epi .table-row.epi-row.edit' ).after( response.data.view_edit_service );

};

/**
 * Le callback en cas de réussite à la requête Ajax "load_epi".
 * Remplaces la ligne courante du tableau "epi".
 *
 * @since 0.1.0
 * @version 0.4.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.loadedEpiSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.table-row' ).replaceWith( response.data.template );
};


/**
 * Le callback en cas de réussite à la requête Ajax "save_epi".
 * Enregistre les données d'un EPI.
 *
 * @since 0.1.0
 * @version 0.6.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.savedEpiSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.table-row' ).replaceWith( response.data.view );
	jQuery( '.wpeo-table.epi .epi-row.service' ).remove();
};

/**
 * Le callback en cas de d'erreur à la requête Ajax "save_epi".
 * Affiche l'erreur sur le champ en mode Edition.
 *
 * @since 0.1.0
 * @version 0.6.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.savedEpiError = function( triggeredElement, response ) {
	var parent_element = triggeredElement.closest( '.wpeo-table' ).find( '.service' );
	var parent_element_edit = triggeredElement.closest( '.wpeo-table' ).find( '.edit' );
	// for ( i = 0; i < response.data.error.length; ++i ) {
	// 	var input_element = parent_element.find( '.form-field[name="' + response.data.error.[i] + '"]');
	// 	input_element.closest( '.form-element' ).find( '.error' ).html( response.data.error.error[i] );
	// 	var input_element_edit = parent_element_edit.find( '.form-field[name="' + response.data.error.element[i] + '"]');
	// 	input_element_edit.closest( '.table-cell' ).find( '.error' ).html( response.data.error.error[i] );
	// }
	//
	jQuery.each( response.data.error, function( key, value ) {
		var input_element = parent_element.find( '.form-field[name="' + value.element + '"]');
	  	input_element.closest( '.form-element' ).find( '.error' ).html( value.error);
	  	var input_element_edit = parent_element_edit.find( '.form-field[name="' + value.element + '"]');
	  	input_element_edit.closest( '.table-cell' ).find( '.error' ).html( value.error );
	});

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
window.eoxiaJS.theEPI.EPI.deletedEpiSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.table-row' ).fadeOut();
};

/**
 * Le callback en cas de réussite à la requête Ajax "edit_epi".
 * Edition d'un "epi".
 *
 * @since 0.1.0
 * @version 0.5.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.editedEpiSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.tab-container').find( '.epi-row.service' ).remove();

	if( response.data.close_epi_id == 0 ){
		triggeredElement.closest( '.wrap-theepi' ).find( '.wpeo-table.epi .epi-row[data-id="0"]' ).remove();
	}else{
		triggeredElement.closest( '.wrap-theepi' ).find( '.wpeo-table.epi .epi-row[data-id="' + response.data.close_epi_id + '"]' ).replaceWith( response.data.view_close );
	}

	triggeredElement.closest( '.epi-row' ).after( response.data.view_edit_service );
	triggeredElement.closest( '.epi-row' ).before( response.data.view_edit_epi );
	triggeredElement.closest( '.epi-row' ).remove();
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
window.eoxiaJS.theEPI.EPI.canceledEditEpiSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.tab-container' ).find( '.epi-row.edit' ).replaceWith( response.data.view );
	triggeredElement.closest('.wpeo-table').find('.service').remove();
};

/**
 * Le callback en cas de réussite à la requête Ajax "load_more_epi".
 * Charge les autres EPIS en fonction de la page et de la pagination.
 *
 * @since 0.4.0
 * @version 0.4.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.loadedMoreEPISuccess = function( triggeredElement, response ) {
	var element   = jQuery( response.data.view );
	jQuery( '.wrap-theepi .wpeo-table.table-flex.epi .tab-container' ).html(element);
	var page = triggeredElement.closest( '.wpeo-pagination.epi' ).replaceWith( response.data.view_pagination );

};

/**
 * Le callback en cas de réussite à la requête Ajax "search_epi".
 * Efface le contenue de la recherche.
 *
 * @since 0.4.0
 * @version 0.4.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.searchedEPISuccess = function( triggeredElement, response ) {
	jQuery( '.wrap-theepi .container-content' ).html( response.data.view );

	if ( ! response.data.clear ) {
		jQuery( '.wrap-theepi .box-search .action-attribute' ).removeClass( 'button-disable' );
		jQuery( '.wrap-theepi .epi-load-more' ).attr( 'data-term', jQuery( '.wrap-theepi .box-search input[type="text"]' ).val() );
	} else {
		jQuery( '.wrap-theepi .box-search input[type="text"]' ).val( '' );
		jQuery( '.wrap-theepi .box-search .action-attribute' ).addClass( 'button-disable' );
		jQuery( '.wrap-theepi .epi-load-more' ).attr( 'data-term', '' );
	}
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

	currentNumberEPI  = parseInt( jQuery( '.wrap-theepi .epi-load-more .number-epi' ).text() );
	currentNumberEPI += addNumberEPI;

	totalNumberEPI  = parseInt( jQuery( '.wrap-theepi .epi-load-more .total-number-epi' ).text() );
	totalNumberEPI += addTotalNumberEPI;

	if ( currentNumberEPI >= totalNumberEPI ) {
		currentNumberEPI = totalNumberEPI;
		jQuery( '.wrap-theepi .epi-load-more' ).addClass( 'button-disable' );
	} else {
		jQuery( '.wrap-theepi .epi-load-more' ).removeClass( 'button-disable' );
	}

	jQuery( '.wrap-theepi .epi-load-more .number-epi' ).text( currentNumberEPI );


	jQuery( '.wrap-theepi .epi-load-more .total-number-epi' ).text( totalNumberEPI );

	currentOffset = parseInt( jQuery( '.wrap-theepi .epi-load-more' ).attr( 'data-offset' ) );
	currentOffset += addNumberEPI;
	jQuery( '.wrap-theepi .epi-load-more' ).attr( 'data-offset', currentOffset );

};

/**
 * Le callback en cas de réussite à la requête Ajax "export_epi".
 * Exporte la fiche de vie d'un EPI au format ODT.
 *
 * @since 0.5.0
 * @version 0.5.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.exportedEPISuccess = function ( triggeredElement, response ) {
	var element = document.createElement('a');
	console.log( response.data );
  element.setAttribute('href', response.data.link );
  element.setAttribute('download', response.data.filename);

  element.style.display = 'none';
  document.body.appendChild(element);

  element.click();

  document.body.removeChild(element);
};

/**
 * Récupère les données d'un EPI et déclenche l'action AJAX save_epi.
 *
 * @since 0.6.0
 * @version 0.6.0
 *
 * @param  {ClickEvent} event [save]
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.saveEPIAjax = function ( event ) {
	var id = jQuery( this ).attr( 'data-id' );
	var fieldset_element    = jQuery( this ).closest( '.wpeo-table' ).find( '.service[ data-id="' + id + '"]' );
	var action              = jQuery( this ).attr( 'data-action' );
	var nonce               = jQuery( this ).attr( 'data-nonce' );

	var title               = jQuery( this ).closest( '.table-row' ).find( '.form-field[name="title"]' ).val();
	var serial_number       = jQuery( this ).closest( '.table-row' ).find( '.form-field[name="serial_number"]' ).val();

	var commissioning_date  = fieldset_element.find( '.mysql-date[name="commissioning-date"]' ).val();
	var maker               = fieldset_element.find( '.form-field[name="maker"]' ).val();
	var seller              = fieldset_element.find( '.form-field[name="seller"]' ).val();
	var manager             = fieldset_element.find( '.form-field[name="manager"]' ).val();
	var reference           = fieldset_element.find( '.form-field[name="reference"]' ).val();
	var lifetime            = fieldset_element.find( '.form-field[name="lifetime"]' ).val();
	var periodicity         = fieldset_element.find( '.form-field[name="periodicity"]' ).val();
	var manufacture_date    = fieldset_element.find( '.mysql-date[name="manufacture-date"]' ).val();
	var purchase_date       = fieldset_element.find( '.mysql-date[name="purchase-date"]' ).val();
	var control_date        = fieldset_element.find( '.form-label[name="control-date"]' ).attr( 'value' );
	var end_life_date       = fieldset_element.find( '.form-label[name="end-life-date"]' ).attr( 'value' );
	var disposal_date       = fieldset_element.find( '.form-label[name="disposal-date"]' ).attr( 'value' );


	var data = {
		action: action,
		_wpnonce: nonce,
		id: id,

		title: title,
		serial_number: serial_number,
		commissioning_date: commissioning_date,

		maker: maker,
		seller: seller,
		manager: manager,
		reference: reference,
		lifetime: lifetime,
		periodicity: periodicity,
		manufacture_date: manufacture_date,
		purchase_date: purchase_date,
		control_date: control_date,
		end_life_date: end_life_date,
		disposal_date: disposal_date

	};

	window.eoxiaJS.loader.display( jQuery( this ).closest( '.table-row' ) );
	window.eoxiaJS.request.send( jQuery( this ), data );
};

/**
 * change l'onglet.
 *
 * @since 0.6.0
 * @version 0.6.0
 *
 * @param  {ClickEvent} event [tab]
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.tabRedirect = function( event ){
    var url = jQuery( this ).attr( 'data-url' );
    window.location.href = url;
};

/**
 * Verifie si la vue EDITION est ouverte
 *
 * @since 0.6.0
 * @version 0.6.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 *
 * @return {integer} id  La vue edition à fermer.
 */
window.eoxiaJS.theEPI.EPI.checkEditMode = function( triggeredElement ){
	var element = triggeredElement.closest( '.wrap-theepi' ).find( '.wpeo-table.epi' );
  var text = triggeredElement.attr( 'data-message' );
	if ( element.find( '.tab-container').find( '.table-row.epi-row.edit' ).length > 0 ) {
		if( confirm( text ) ){
			var id = element.find( '.tab-container').find( '.table-row.epi-row.edit' ).attr( 'data-id' );
			return id;
		}else{
			return -1;
		}
	}
	return 0;
};

/**
 * Récupère la vue Edition à fermer et déclenche l'action AJAX edit_epi.
 *
 * @since 0.6.0
 * @version 0.6.0
 *
 * @param  {ClickEvent} event [edit]
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.requestEpiEdit = function( event ){
	var id = window.eoxiaJS.theEPI.EPI.checkEditMode( jQuery( this ) );

	if( id != -1 ){

		var data = {};
		data.id = jQuery( this ).attr( 'data-id' );
		data.action = jQuery( this ).attr( 'data-action' );
		data._wpnonce = jQuery( this ).attr( 'data-nonce' );
		data.closeepi = id;

		window.eoxiaJS.loader.display( jQuery( this ) );
		window.eoxiaJS.request.send( jQuery( this ), data );
	}
};

/**
 * Ouvre le QrCode en grand
 *
 * @since 0.7.0
 * @version 0.7.0
 *
 * @param  {ClickEvent} event [qrcode]
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.openQrCode = function( triggeredElement, response ){
	triggeredElement.closest( '.table-row' ).append( response.data.view );

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
window.eoxiaJS.theEPI.control.buttonToggle = function( event ) {

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
