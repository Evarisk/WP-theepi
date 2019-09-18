window.eoxiaJS.EPI.comment = {};

window.eoxiaJS.EPI.comment.init = function() {
	window.eoxiaJS.EPI.comment.event();
};

window.eoxiaJS.EPI.comment.event = function() {};

window.eoxiaJS.EPI.comment.delete_success = function( element, response ) {
	jQuery( element ).closest( 'li' ).fadeOut();
};

window.eoxiaJS.EPI.comment.saved_comment_success = function( element, response ) {
	element.closest( '.comment-container' ).replaceWith( response.data.view );
};
