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
	jQuery( document ).on( 'click', '.wrap-theepi .wpeo-table .button-save-epi', window.eoxiaJS.theEPI.EPI.saveEPIAjax );
	jQuery( document ).on( 'click', '.wrap-theepi .action-request-edit-epi', window.eoxiaJS.theEPI.EPI.requestEpiEdit );
	jQuery( document ).on( 'keyup', 'body', window.eoxiaJS.theEPI.EPI.addEpiWithKeybord );
	//jQuery( document ).on( 'keyup', 'body', window.eoxiaJS.theEPI.EPI.cancelEpiWithKeybord );

};

/**
 * Ajout d'un EPI en appuyant sur ctrl + enter.
 *
 * @since 0.7.0
 * @version 0.7.0
 *
 * @param  {KeyboardEvent} event L'état du clavier [ctrl+enter].
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.addEpiWithKeybord = function( event ) {
	if ( event.ctrlKey && 13 === event.keyCode ) {
		jQuery( this ).find( '.wrap-theepi' ).find( '.event-keybord' ).click();
	}
};

// /**
//  * Annule la création ou la modification d'un EPI en appuyant sur la touche echap.
//  *
//  * @since 0.7.0
//  * @version 0.7.0
//  *
//  * @param  {KeyboardEvent} event L'état du clavier [echap].
//  *
//  * @return {void}
//  */
// window.eoxiaJS.theEPI.EPI.cancelEpiWithKeybord = function( event ) {
// 	console.log('zdzdz');
// 	if ( 27 === event.keyCode ) {
// 		var text = jQuery( this ).find( '.advanced-service.footer' ).find( '.event-keybord-cancel' ).attr( 'data-message' );
// 		if ( confirm( text ) ) {
// 			jQuery( this ).find( '.advanced-service.footer' ).find( '.event-keybord-cancel' ).click();
// 		}
// 	}
// };

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

	var rowContent = jQuery( '<div>', {
		class: 'table-row epi-row edit',
		html: response.data.view_edit_epi + response.data.view_edit_service
	});
	rowContent.attr( 'data-id', response.data.epi_id );

	jQuery( '.wpeo-table.epi .tab-container' ).prepend( rowContent );
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
 * @version 0.7.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.savedEpiSuccess = function( triggeredElement, response ) {
	var id = triggeredElement.attr( 'data-id' );
	triggeredElement.closest( '.tab-container' ).find( '.table-row[ data-id="' + id + '"]' ).replaceWith( response.data.view );
	jQuery( '.wpeo-table.epi .epi-row.service' ).remove();
};

/**
 * Le callback en cas de d'erreur à la requête Ajax "save_epi".
 * Affiche l'erreur sur le champ en mode Edition.
 *
 * @since 0.1.0
 * @version 0.7.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.savedEpiError = function( triggeredElement, response ) {
	let id = triggeredElement.attr( 'data-id' );
	//var parent_element_edit = triggeredElement.closest( '.tab-container' ).find( '.table-row[ data-id="' + id + '"]' );
	let parent_element = triggeredElement.closest( '.tab-container' ).find( '.service[ data-id="' + id + '"]' );

	jQuery.each( response.data.error, function( key, value ) {
		let input_element = parent_element.find( '.form-field[name="' + value.element + '"]');
	  	input_element.closest( '.form-element' ).find( '.form-error' ).html( value.error);
	  	// var input_element_edit = parent_element_edit.find( '.form-field[name="' + value.element + '"]');
	  	// input_element_edit.closest( '.table-cell' ).find( '.error' ).html( value.error );
	});

	window.eoxiaJS.loader.remove( triggeredElement.closest( '.tab-container' ).find( '.table-row[ data-id="' + id + '"]' ) );

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
	triggeredElement.closest( '.table-row' ).remove();
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
	var idElement = triggeredElement.attr( 'data-id' );

	if( response.data.close_epi_id == 0 ){
		triggeredElement.closest( '.wrap-theepi' ).find( '.wpeo-table.epi .epi-row[data-id="0"]' ).remove();
	}else{
		triggeredElement.closest( '.wrap-theepi' ).find( '.wpeo-table.epi .epi-row[data-id="' + response.data.close_epi_id + '"]' ).replaceWith( response.data.view_close );
	}

	var rowContent = jQuery( '<div>', {
		class: 'table-row epi-row edit',
		html: response.data.view_edit_epi + response.data.view_edit_service
	});
	rowContent.attr( 'data-id', idElement );

	triggeredElement.closest( '.epi-row' ).before( rowContent );
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
 * @version 0.7.0
 *
 * @param  {ClickEvent} event [save]
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.saveEPIAjax = function ( event ) {
	var id = jQuery( this ).attr( 'data-id' );

	var service_element     = jQuery( this ).closest( '.wpeo-table' ).find( '.service[ data-id="' + id + '"]' );
	var edit_element        = jQuery( this ).closest( '.tab-container' ).find( '.table-row[ data-id="' + id + '"]' );
	var action              = jQuery( this ).attr( 'data-action' );
	var nonce               = jQuery( this ).attr( 'data-nonce' );

	var quantity            = edit_element.find( '.form-field[name="quantity"]' ).val();
	var serial_number       = edit_element.find( '.form-field[name="serial_number"]' ).val();
	var title               = edit_element.find( '.form-field[name="title"]' ).val();

	var toggle_lifetime     = service_element.find( '.button-toggle-lifetime' ).attr( 'data-value' );
	var manufacture_date    = service_element.find( '.mysql-date[name="manufacture-date"]' ).val();
	var lifetime            = service_element.find( '.form-field[name="lifetime"]' ).val();
	var end_life_date       = service_element.find( '.mysql-date[name="end-life-date"]' ).val();
	var disposal_date       = service_element.find( '.mysql-date[name="disposal-date"]' ).val();

	var purchase_date       = service_element.find( '.mysql-date[name="purchase-date"]' ).val();
	var commissioning_date  = service_element.find( '.mysql-date[name="commissioning-date"]' ).val();
	var periodicity         = service_element.find( '.form-field[name="periodicity"]' ).val();
	var control_date        = service_element.find( '.mysql-date[name="control-date"]' ).val();

	var maker               = service_element.find( '.form-field[name="maker"]' ).val();
	var seller              = service_element.find( '.form-field[name="seller"]' ).val();
	var manager             = service_element.find( '.eo-search-value[name="manager"]' ).val();
	var reference           = service_element.find( '.form-field[name="reference"]' ).val();
	var url_notice          = service_element.find( '.form-field[name="url-notice"]' ).val();

	var data = {
		action: action,
		_wpnonce: nonce,
		id: id,

		quantity: quantity,
		serial_number: serial_number,
		title: title,

		toggle_lifetime: toggle_lifetime,
		manufacture_date: manufacture_date,
		lifetime: lifetime,
		end_life_date: end_life_date,
		disposal_date: disposal_date,

		purchase_date: purchase_date,
		commissioning_date: commissioning_date,
		periodicity: periodicity,
		control_date: control_date,

		maker: maker,
		seller: seller,
		manager: manager,
		reference: reference,
		url_notice: url_notice,

	};

	window.eoxiaJS.loader.display( jQuery( this ).closest( '.tab-container' ).find( '.table-row[ data-id="' + id + '"]' ) );

	window.eoxiaJS.request.send( jQuery( this ), data );

};

/**
 * Verifie si la vue EDITION est ouverte.
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
 * Ouvre le QrCode en grand.
 *
 * @since 0.7.0
 * @version 0.7.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.openQrCode = function( triggeredElement, response ){
	triggeredElement.closest( '.table-row' ).append( response.data.view );
};

/**
 *  Filtre pour les EPIS.
 *
 * @since 0.7.0
 * @version 0.7.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.filterEPISuccess = function( triggeredElement, response ){
	window.location.assign(response.data.url);
	console.log('eerere');
	setTimeout(function(){
		var filter = response.data.filters;
		console.log(filter);
		console.log(response.data.url);
	}, 10000);

	// var element = triggeredElement.closest( '.wrap-theepi' ).find( '.epi-filter-bar' ).find( 'option[value="' + filter + '"]' );
	// element.attr( 'selected', 'selected' );

};
