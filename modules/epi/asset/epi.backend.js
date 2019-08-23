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
	jQuery( document ).on( 'keyup', '.wrap-theepi .wpeo-table.epi .epi-row input[name="periodicity"]', window.eoxiaJS.theEPI.EPI.activeSaveButton );
	jQuery( document ).on( 'click', '.wrap-theepi .scroll-top', window.eoxiaJS.theEPI.EPI.scrollTop );
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
 * @return {void}
 */
window.eoxiaJS.theEPI.EPI.activeSaveButton = function( event ) {
	jQuery( this ).closest( '.epi-row' ).find( '.action-input.add' ).addClass( 'button-disabled' );

	if ( Number.isInteger( parseInt( jQuery( this ).val() ) ) ) {
		jQuery( this ).closest( '.epi-row' ).find( '.action-input.add' ).removeClass( 'button-disabled' );
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
	}, 500);
};

/**
 * Le callback en cas de réussite à la requête Ajax "create_epi".
 * Remplaces le contenu de <tbody> du tableau "epi".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.1.0
 * @version 0.5.0
 */
window.eoxiaJS.theEPI.EPI.CreatedEpiSuccess = function( triggeredElement, response ) {

	jQuery( '.wpeo-table.epi .epi-row.edit[data-id="' + response.data.close_epi_id + '"]' ).replaceWith( response.data.view_close );
	jQuery( '.wpeo-table.epi .epi-row.service[data-id="' + response.data.close_epi_id + '"]' ).remove();
	jQuery( '.wpeo-table.epi .tab-container' ).prepend( response.data.view_edit_epi );
	jQuery( '.wpeo-table.epi .table-row.epi-row.edit' ).after( response.data.view_edit_service );

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
	triggeredElement.closest( '.table-row' ).replaceWith( response.data.template );
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
window.eoxiaJS.theEPI.EPI.savedEpiSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.table-row' ).replaceWith( response.data.view );
	jQuery( '.wpeo-table.epi .epi-row.service' ).remove();
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
window.eoxiaJS.theEPI.EPI.savedEpiError = function( triggeredElement, response ) {
	var parent_element = triggeredElement.closest( '.wpeo-table' ).find( '.service' );
	for ( i = 0; i < response.data.error.element.length; ++i ) {
		var input_element = parent_element.find( '.form-field[name="' + response.data.error.element[i] + '"]');
		/*window.eoxiaJS.popover.remove( input_element.find( '.wpeo-popover-event' ) );
		console.log( 	window.eoxiaJS.popover.remove( input_element.find( '.wpeo-popover-event' ) ) );
		input_element.attr( 'aria-label' , response.data.error.error[i] );
		window.eoxiaJS.popover.toggle( input_element.find( '.wpeo-popover-event' ) );*/
		input_element.closest( '.form-element' ).find( '.error' ).html( response.data.error.error[i] );

	}
	//window.eoxiaJS.popover.remove( input_element.find( '.wpeo-popover-event' ) );
};


/**
 * Le callback en cas de réussite à la requête Ajax "delete_epi".
 * Supprimes la ligne courante du tableau "epi"
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
	triggeredElement.closest( '.table-row' ).fadeOut();
};

/**
 * Le callback en cas de réussite à la requête Ajax "edit_epi".
 * Edition d'un "epi"
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.1.0
 * @version 0.5.0
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
 * Annule le mode édition d'un "epi"
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.1.0
 * @version 0.5.0
 */
window.eoxiaJS.theEPI.EPI.canceledEditEpiSuccess = function( triggeredElement, response ) {
	triggeredElement.closest('.wpeo-table').find('.service').remove();
	triggeredElement.closest( '.epi-row' ).replaceWith( response.data.view );
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
			scrollTop: jQuery( '.epi-load-more' ).offset().top
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

window.eoxiaJS.theEPI.EPI.exportedEPISuccess = function ( triggeredElement, response ) {
	/*var element = document.createElement('a');
	console.log( response.data );
  element.setAttribute('href', response.data.link );
  element.setAttribute('download', response.data.filename);

  element.style.display = 'none';
  document.body.appendChild(element);

  element.click();

  document.body.removeChild(element);*/


	/*fetch(response.data.link)
  .then(resp => resp.blob())
  .then(blob => {
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.style.display = 'none';
    a.href = url;
    // the filename you want
    a.download = response.data.filename;
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
    alert('your file has downloaded!'); // or you know, something with better UX...
  })
  .catch(() => alert('oh no!'));*/

};


window.eoxiaJS.theEPI.EPI.saveEPIAjax = function ( event ) {
	var id = jQuery( this ).attr( 'data-id' );
	var fieldset_element    = jQuery( this ).closest( '.wpeo-table' ).find( '.service[ data-id="' + id + '"]' );
	var action              = jQuery( this ).attr( 'data-action' );
	var nonce               = jQuery( this ).attr( 'data-nonce' );

	var title               = jQuery( this ).closest( '.table-row' ).find( '.form-field[name="title"]' ).val();
	var serial_number       = jQuery( this ).closest( '.table-row' ).find( '.form-field[name="serial_number"]' ).val();
	var commissioning_date  = jQuery( this ).closest( '.table-row' ).find( '.form-field[name="commissioning-date"]' ).val();

	var maker               = fieldset_element.find( '.form-field[name="maker"]' ).val();
	var seller              = fieldset_element.find( '.form-field[name="seller"]' ).val();
	var manager             = fieldset_element.find( '.form-field[name="manager"]' ).val();
	var reference           = fieldset_element.find( '.form-field[name="reference"]' ).val();
	var lifetime            = fieldset_element.find( '.form-field[name="lifetime"]' ).val();
	var periodicity         = fieldset_element.find( '.form-field[name="periodicity"]' ).val();
	var manufacture_date    = fieldset_element.find( '.form-field[name="manufacture-date"]' ).val();
	var purchase_date       = fieldset_element.find( '.form-field[name="purchase-date"]' ).val();
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

//	var data_valid = window.eoxiaJS.theEPI.EPI.checkData( data ) ;
	//if ( data_valid[ 'success' ] ) {
		console.log(data);
		window.eoxiaJS.loader.display( jQuery( this ).closest( '.table-row' ) );
		window.eoxiaJS.request.send( jQuery( this ), data );
/*	}else {
		alert('ok');
	}*/
}

/**
 * Vérifie si le champ période de controle est bien un nombre pour continuer le formulaire d'ajout d'un EPI.
 *
 * @param  {HTMLDivElement} element Le bouton pour ajouter un EPI
 * @return {boolean}
 *
 * @since 0.1.0
 * @version 0.4.0
 */
window.eoxiaJS.theEPI.EPI.checkData = function( data ) {
	/*window.eoxiaJS.popover.remove( element.closest( '.epi-row' ).find( 'input.wpeo-popover-event' ) );

	if ( isNaN( element.closest( '.epi-row' ).find( 'input[name="periodicity"]' ).val() ) || '' == element.closest( '.epi-row' ).find( 'input[name="periodicity"]' ).val() ||
		( element.closest( '.epi-row' ).find( 'input[name="periodicity"]' ).val() && '0' == element.closest( '.epi-row' ).find( 'input[name="periodicity"]' ).val() ) ) {
		window.eoxiaJS.popover.toggle( element.closest( '.epi-row' ).find( 'input.wpeo-popover-event' ) );
		return false;
	}

	window.eoxiaJS.popover.remove( element.closest( '.epi-row' ).find( 'input.wpeo-popover-event' ) );

	return true;*/
/*	var data_return = {};
	data_return.success = true;
	data_return.error = "";
	console.log(data.purchase_date);

	if( data.purchase_date == "" || Date.parse(test)/1000 <=  Date.parse(data.manufacture_date)/1000 ) {
		console.log((Date.parse(test)/1000 ));
		data_return.success = false;
		data_return.error = "Purchase date not valid";
	}


	return data_return;*/
};

window.eoxiaJS.theEPI.EPI.tabRedirect = function( event ){
    var url = jQuery( this ).attr( 'data-url' );
    window.location.href = url;
}

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
}

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
}
