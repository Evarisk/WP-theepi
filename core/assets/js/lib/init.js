'use strict';

window.eoxiaJS = {};
window.digirisk_epi = {};

window.eoxiaJS.init = function() {
	window.eoxiaJS.loadScripts();
	window.eoxiaJS.initArrayForm();
};

window.eoxiaJS.loadScripts = function() {
	var key;
	for ( key in window.digirisk_epi ) {
		window.digirisk_epi[key].init();
	}
};

window.eoxiaJS.initArrayForm = function() {
	 window.eoxiaJS.arrayForm.init();
};

jQuery( document ).ready( window.eoxiaJS.init );
