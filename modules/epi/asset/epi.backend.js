"use strict";

window.digirisk_epi.epi = {};

window.digirisk_epi.epi.init = function() {
	window.digirisk_epi.epi.event();
};

window.digirisk_epi.epi.event = function() {};

window.digirisk_epi.epi.save_epi_success = function( element, response ) {
  jQuery( '.wp-digi-epi' ).replaceWith( response.data.template );
}

window.digirisk_epi.epi.load_epi_success = function( element, response ) {
  jQuery( element ).closest( 'li' ).replaceWith( response.data.template );
}

window.digirisk_epi.epi.delete_epi_success = function( element, response ) {
  jQuery( element ).closest( 'li' ).fadeOut();
}
