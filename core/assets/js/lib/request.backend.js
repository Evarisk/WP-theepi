window.digirisk_epi.request = {};

window.digirisk_epi.request.init = function() {};

window.digirisk_epi.request.send = function( element, data ) {
	jQuery.post( window.ajaxurl, data, function( response ) {
		element.closest( '.loading' ).removeClass( 'loading' );

		if ( response && response.success ) {
			if ( response.data.module && response.data.callback_success ) {
				window.digirisk_epi[response.data.module][response.data.callback_success]( element, response );
			}
		} else {
			if ( response.data.module && response.data.callback_error ) {
				window.digirisk_epi[response.data.module][response.data.callback_error]( element, response );
			}
		}
	}, 'json' );
};

window.digirisk_epi.request.get = function( url, data ) {
	jQuery.get( url, data, function( response ) {
		if ( response && response.success ) {
			if ( response.data.module && response.data.callback_success ) {
				window.digirisk_epi[response.data.module][response.data.callback_success]( response );
			}
		} else {
			if ( response.data.module && response.data.callback_error ) {
				window.digirisk_epi[response.data.module][response.data.callback_error]( response );
			}
		}
	}, 'json' );
};
