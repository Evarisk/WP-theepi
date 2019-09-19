window.eoxiaJS.theEPI.comment = {};

window.eoxiaJS.theEPI.comment.init = function() {
	window.eoxiaJS.theEPI.comment.event();
};

window.eoxiaJS.theEPI.comment.event = function() {};

window.eoxiaJS.theEPI.comment.delete_success = function( element, response ) {
	jQuery( element ).closest( 'li' ).fadeOut();
};

window.eoxiaJS.theEPI.comment.saved_comment_success = function( element, response ) {
	element.closest( '.comment-container' ).replaceWith( response.data.view );
};
