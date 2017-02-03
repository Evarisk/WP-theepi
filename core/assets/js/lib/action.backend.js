window.digirisk_epi.action = {};

window.digirisk_epi.action.init = function() {
	window.digirisk_epi.action.event();
};

window.digirisk_epi.action.event = function() {
	jQuery( document ).on( 'click', '.action-input:not(.no-action)', window.digirisk_epi.action.execInput );
	jQuery( document ).on( 'click', '.action-attribute:not(.no-action)', window.digirisk_epi.action.execAttribute );
	jQuery( document ).on( 'click', '.action-delete:not(.no-action)', window.digirisk_epi.action.execDelete );
};

window.digirisk_epi.action.execInput = function( event ) {
	var element = jQuery( this );
	var parentElement = element;
	var loaderElement = element;
	var listInput = undefined;
	var data = {};
	var i = 0;
	var doAction = true;
	var key = undefined;

	if ( element.data( 'loader' ) ) {
		loaderElement = element.closest( '.' + element.data( 'loader' ) );
	}

	if ( element.data( 'parent' ) ) {
		parentElement = element.closest( '.' + element.data( 'parent' ) );
	}

	/** Méthode appelée avant l'action */
	if ( element.data( 'module' ) && element.data( 'before-method' ) ) {
		doAction = false;
		doAction = window.digirisk_epi[element.data( 'module' )][element.data( 'before-method' )]( element );
	}

	if ( doAction ) {
		loaderElement.addClass( 'loading' );

		listInput = window.eoxiaJS.arrayForm.getInput( parentElement );
		for ( i = 0; i < listInput.length; i++ ) {
			if ( listInput[i].name ) {
				data[listInput[i].name] = listInput[i].value;
			}
		}

		element.get_data( function( attrData ) {
			for ( key in attrData ) {
				data[key] = attrData[key];
			}

			window.digirisk_epi.request.send( element, data );
		} );
	}
};

window.digirisk_epi.action.execAttribute = function( event ) {
  var element = jQuery( this );
	var doAction = true;
	var loaderElement = element;

	if ( element.data( 'loader' ) ) {
		loaderElement = element.closest( '.' + element.data( 'loader' ) );
	}

	/** Méthode appelée avant l'action */
	if ( element.data( 'module' ) && element.data( 'before-method' ) ) {
		doAction = false;
		doAction = window.digirisk_epi[element.data( 'module' )][element.data( 'before-method' )]( element );
	}

	if ( doAction ) {
		if ( jQuery( this ).data( 'confirm' ) ) {
			if ( window.confirm( jQuery( this ).data( 'confirm' ) ) ) {
				element.get_data( function( data ) {
					loaderElement.addClass( 'loading' );
					window.digirisk_epi.request.send( element, data );
				} );
			}
		} else {
			element.get_data( function( data ) {
				loaderElement.addClass( 'loading' );
				window.digirisk_epi.request.send( element, data );
			} );
		}
	}
};

window.digirisk_epi.action.execDelete = function( event ) {
  var element = jQuery( this );
	var doAction = true;
	var loaderElement = element;

	if ( element.data( 'loader' ) ) {
		loaderElement = element.closest( '.' + element.data( 'loader' ) );
	}

	/** Méthode appelée avant l'action */
	if ( element.data( 'module' ) && element.data( 'before-method' ) ) {
		doAction = false;
		doAction = window.digirisk_epi[element.data( 'module' )][element.data( 'before-method' )]( element );
	}

	if ( doAction ) {
		if ( window.confirm( window.digi_confirm_delete ) ) {
			element.get_data( function( data ) {
				loaderElement.addClass( 'loading' );
				window.digirisk_epi.request.send( element, data );
			} );
		}
	}
};
