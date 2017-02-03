window.digirisk_epi.toggle = {};

window.digirisk_epi.toggle.init = function() {
	window.digirisk_epi.toggle.event();
};

window.digirisk_epi.toggle.event = function() {
  jQuery( document ).on( 'click', '.toggle:not(.disabled), .toggle:not(.disabled) i', window.digirisk_epi.toggle.open );
  jQuery( document ).on( 'click', 'body', window.digirisk_epi.toggle.close );
};

window.digirisk_epi.toggle.open = function( event ) {
	var target = undefined;
	var elementToggle = jQuery( this );

	if ( elementToggle.is( 'i' ) ) {
		elementToggle = elementToggle.parents( '.toggle' );
	}

	jQuery( '.toggle .content.active' ).removeClass( 'active' );

	if ( elementToggle.data( 'parent' ) ) {
		target = elementToggle.closest( '.' + elementToggle.data( 'parent' ) ).find( '.' + elementToggle.data( 'target' ) );
	} else {
		target = jQuery( '.' + elementToggle.data( 'target' ) );
	}

	if ( target ) {
	  target.toggleClass( 'active' );
	  event.stopPropagation();
	}
};

window.digirisk_epi.toggle.close = function( event ) {
	jQuery( '.toggle .content' ).removeClass( 'active' );
	event.stopPropagation();
};
