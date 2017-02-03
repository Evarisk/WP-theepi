window.digirisk_epi.popup = {};

window.digirisk_epi.popup.init = function() {
	window.digirisk_epi.popup.event();
};

window.digirisk_epi.popup.event = function() {
	jQuery( document ).on( 'keyup', window.digirisk_epi.popup.keyup );
  jQuery( document ).on( 'click', '.open-popup, .open-popup i', window.digirisk_epi.popup.open );
  jQuery( document ).on( 'click', '.open-popup-ajax', window.digirisk_epi.popup.openAjax );
  jQuery( document ).on( 'click', '.popup .container, .digi-popup-propagation', window.digirisk_epi.popup.stop );
  jQuery( document ).on( 'click', '.popup .container .button.green', window.digirisk_epi.popup.confirm );
  jQuery( document ).on( 'click', '.popup .close', window.digirisk_epi.popup.close );
  jQuery( document ).on( 'click', 'body', window.digirisk_epi.popup.close );
};

window.digirisk_epi.popup.keyup = function( event ) {
	if ( 27 === event.keyCode ) {
		jQuery( '.popup .close' ).click();
	}
};

window.digirisk_epi.popup.open = function( event ) {
	var triggeredElement = jQuery( this );

	if ( triggeredElement.is( 'i' ) ) {
		triggeredElement = triggeredElement.parents( '.open-popup' );
	}

	var target = triggeredElement.closest(  '.' + triggeredElement.data( 'parent' ) ).find( '.' + triggeredElement.data( 'target' ) );
	var cbObject, cbFunc = undefined;
	target.addClass( 'active' );

	if ( target.is( ':visible' ) && triggeredElement.data( 'cb-object' ) && triggeredElement.data( 'cb-func' ) ) {
		cbObject = triggeredElement.data( 'cb-object' );
		cbFunc = triggeredElement.data( 'cb-func' );

		// On récupères les "data" sur l'élement en tant qu'args.
		triggeredElement.get_data( function( data ) {
			window.digirisk_epi[cbObject][cbFunc]( triggeredElement, target, event, data );
		} );
	}

  event.stopPropagation();
};

/**
 * Ouvre la popup en envoyant une requête AJAX.
 * Les paramètres de la requête doivent être configurer directement sur l'élement
 * Ex: data-action="load-workunit" data-id="190"
 *
 * @param  {[type]} event [description]
 * @return {[type]}       [description]
 */
window.digirisk_epi.popup.openAjax = function( event ) {
	var element = jQuery( this );
	var target = jQuery( this ).closest(  '.' + jQuery( this ).data( 'parent' ) ).find( '.' + jQuery( this ).data( 'target' ) );
	target.addClass( 'active' );

	jQuery( this ).get_data( function( data ) {
		delete data.parent;
		delete data.target;
		window.digirisk_epi.request.send( element, data );
	});

	event.stopPropagation();
};

window.digirisk_epi.popup.confirm = function( event ) {
	var triggeredElement = jQuery( this );
	var cbObject, cbFunc = undefined;

	if ( ! jQuery( '.popup' ).hasClass( 'no-close' ) ) {
		jQuery( '.popup' ).removeClass( 'active' );

		if ( triggeredElement.attr( 'data-cb-object' ) && triggeredElement.attr( 'data-cb-func' ) ) {
			cbObject = triggeredElement.attr( 'data-cb-object' );
			cbFunc = triggeredElement.attr( 'data-cb-func' );

			// On récupères les "data" sur l'élement en tant qu'args.
			triggeredElement.get_data( function( data ) {
				window.digirisk_epi[cbObject][cbFunc]( triggeredElement, event, data );
			} );
		}
	}
};

window.digirisk_epi.popup.stop = function( event ) {
	event.stopPropagation();
};

window.digirisk_epi.popup.close = function( event ) {
	jQuery( '.popup:not(.no-close)' ).removeClass( 'active' );
	jQuery( '.digi-popup:not(.no-close)' ).removeClass( 'active' );
};
