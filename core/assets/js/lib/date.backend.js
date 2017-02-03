window.digirisk_epi.date = {};

window.digirisk_epi.date.init = function() {
	jQuery( document ).on( 'click', '.date', function( e ) {
		jQuery( this ).datepicker( {
			dateFormat: 'dd/mm/yy'
		} );

		jQuery( this ).datepicker( 'show' );
	} );
};
