/**
 * Initialise l'objet "media" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 1.0
 * @version 6.2.5.0
 */
window.digirisk_epi.media = {
	file_frame: undefined,
	element_id: undefined,
	have_thumbnail: undefined,
	object_name: undefined,
	_wpnonce: undefined,
	element: undefined
};

/**
 * Appel la méthode "event"
 *
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.5.0
 */
window.digirisk_epi.media.init = function() {
  window.digirisk_epi.media.event();
};

window.digirisk_epi.media.event = function() {
  jQuery( document ).on( 'click', '.media:not(.loading), .upload-model', window.digirisk_epi.media.open_popup );
};

window.digirisk_epi.media.open_popup = function( event ) {
	var element = jQuery( this );

  event.preventDefault();

  window.digirisk_epi.media.element = jQuery( this );
  window.digirisk_epi.media.element_id = element.data( 'id' );
  window.digirisk_epi.media._wpnonce = element.data( 'nonce' );
  window.digirisk_epi.media.title = element.data( 'title' );
  window.digirisk_epi.media.object_name = element.data( 'object-name' );
  window.digirisk_epi.media.type = element.data( 'type' );
  window.digirisk_epi.media.namespace = element.data( 'namespace' );
  window.digirisk_epi.media.action = element.data( 'action' );
  window.digirisk_epi.media.have_thumbnail = element.hasClass( 'wp-digi-element-thumbnail' ) ? true : false;
  window.wp.media.model.settings.post.id = element.data( 'id' );

  if ( 0 === element.find( '.wp-digi-element-thumbnail' ).length ) {
    window.digirisk_epi.media.load_media_upload( element, element.data( 'id' )  );
  } else {
    window.digirisk_epi.gallery.open( element, element.data( 'id' ), element.data( 'type' ), element.data( 'namespace' ) );
  }
};

window.digirisk_epi.media.load_media_upload = function( element, post_id ) {
  if ( !window.digirisk_epi.media.file_frame ) {
    window.digirisk_epi.media.file_frame = new window.wp.media.view.MediaFrame.Post( {
      title: jQuery( element ).data( 'uploader_title' ),
      button: {
        text: jQuery( element ).data( 'uploader_button_text' ),
      },
      multiple: false
    } );
    window.digirisk_epi.media.file_frame.el.className += ' digi-upload-' + post_id;
    window.digirisk_epi.media.file_frame.on( "insert", function() { window.digirisk_epi.media.selected_file( element ); } );
  }

  window.digirisk_epi.media.open_media_upload();
};

window.digirisk_epi.media.open_media_upload = function() {
  window.digirisk_epi.media.file_frame.open();
  return;
};

window.digirisk_epi.media.selected_file = function( element ) {
  var selected_file = window.digirisk_epi.media.file_frame.state().get( 'selection' );
  var selected_JSON;
  var selected_file_id;
  selected_file.map( function( attachment ) {
    selected_JSON = attachment.toJSON();
    selected_file_id = attachment.id;
  } );

  if ( window.digirisk_epi.media.element_id === 0 && window.digirisk_epi.media.action != 'eo_set_model' ) {
    window.digirisk_epi.media.display_attachment( selected_JSON, element );
  } else {
    window.digirisk_epi.media.associate_file( selected_file_id );
  }
};

window.digirisk_epi.media.display_attachment = function( selected_JSON, element ) {
  window.digirisk_epi.media.element.find( 'img' ).attr( 'src', selected_JSON.url ).show();
  window.digirisk_epi.media.element.find( 'i' ).hide();
  window.digirisk_epi.media.element.find( 'input.input-file-image' ).val( selected_JSON.id );
};

window.digirisk_epi.media.associate_file = function( selectedFileId ) {
	if ( 'eo_set_model' === window.digirisk_epi.media.action ) {
		jQuery( '.upload-model[data-type="' + window.digirisk_epi.media.type + '"]' ).addClass( 'loading' );
	} else {
		jQuery( 'span.media[data-id="' + window.digirisk_epi.media.element_id + '"]' ).addClass( 'loading' );
	}

  var data = {
    action: window.digirisk_epi.media.action,
    file_id: selectedFileId,
    _wpnonce: window.digirisk_epi.media._wpnonce,
    title: window.digirisk_epi.media.title,
    type: window.digirisk_epi.media.type,
    namespace: window.digirisk_epi.media.namespace,
    element_id: window.digirisk_epi.media.element_id,
    object_name: window.digirisk_epi.media.object_name,
    thumbnail: window.digirisk_epi.media.have_thumbnail,
  };

  jQuery.post( window.ajaxurl, data, function( response ) {
    if ( response.data.type == 'set_model' ) {
      jQuery( '#digi-handle-model' ).html( response.data.template );
    }
    else {
      jQuery( 'span.media[data-id="'+ window.digirisk_epi.media.element_id + '"]' ).replaceWith( response.data.template );
			jQuery( '.gallery' ).remove();
    }
  });
};
