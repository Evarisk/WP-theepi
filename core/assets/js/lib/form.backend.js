window.digirisk_epi.form = {};

window.digirisk_epi.form.init = function() {
    window.digirisk_epi.form.event();
};
window.digirisk_epi.form.event = function() {
    jQuery( document ).on( 'click', '.submit-form', window.digirisk_epi.form.submitForm );
};

window.digirisk_epi.form.submitForm = function( event ) {
	var element = jQuery( this );

	element.closest( 'form' ).addClass( 'loading' );

	event.preventDefault();
	element.closest( 'form' ).ajaxSubmit( {
		success: function( response ) {
			element.closest( 'form' ).removeClass( 'loading' );

			if ( response && response.success ) {
				if ( response.data.module && response.data.callback_success ) {
					window.digirisk_epi[response.data.module][response.data.callback_success]( element, response );
				}
			} else {
				if ( response.data.module && response.data.callback_error ) {
					window.digirisk_epi[response.data.module][response.data.callback_error]( element, response );
				}
			}
		}
	} );
};
