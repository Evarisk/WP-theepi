window.digirisk_epi.tab = {};

window.digirisk_epi.tab.init = function() {
	window.digirisk_epi.tab.event();
};

window.digirisk_epi.tab.event = function() {
  jQuery( document ).on( 'click', '.tab-element', window.digirisk_epi.tab.load );
};

window.digirisk_epi.tab.load = function( event ) {
	var tabTriggered = jQuery( this );
	var data = {};

  event.preventDefault();
	event.stopPropagation();

	tabTriggered.closest( '.content' ).removeClass( 'active' );

	if ( ! tabTriggered.hasClass( 'no-tab' ) && tabTriggered.data( 'action' ) ) {
		jQuery( '.tab .tab-element.active' ).removeClass( 'active' );
		tabTriggered.addClass( 'active' );

		data = {
			action: 'load_tab_content',
			_wpnonce: tabTriggered.data( 'nonce' ),
			tab_to_display: tabTriggered.data( 'action' ),
			title: tabTriggered.data( 'title' ),
			element_id: tabTriggered.data( 'id' )
	  };

		jQuery( '.' + tabTriggered.data( 'target' ) ).addClass( 'loading' );

		jQuery.post( window.ajaxurl, data, function( response ) {
			jQuery( '.' + tabTriggered.data( 'target' ) ).replaceWith( response.data.template );

			window.digirisk_epi.tab.callTabChanged();
		} );

	}

};

window.digirisk_epi.tab.callTabChanged = function() {
	var key = undefined;
	for ( key in window.digirisk_epi ) {
		if ( window.digirisk_epi[key].tabChanged ) {
			window.digirisk_epi[key].tabChanged();
		}
	}
};
