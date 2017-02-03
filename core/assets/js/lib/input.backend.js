window.digirisk_epi.input = {};

window.digirisk_epi.input.init = function() {
	window.digirisk_epi.input.event();
};

window.digirisk_epi.input.event = function() {
  jQuery( document ).on( 'keyup', '.digirisk-wrap .form-element input, .digirisk-wrap .form-element textarea', window.digirisk_epi.input.keyUp );
};

window.digirisk_epi.input.keyUp = function( event ) {
	if ( 0 < jQuery( this ).val().length ) {
		jQuery( this ).closest( '.form-element' ).addClass( 'active' );
	} else {
		jQuery( this ).closest( '.form-element' ).removeClass( 'active' );
	}
};
