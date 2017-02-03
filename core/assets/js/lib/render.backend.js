window.digirisk_epi.render = {};

window.digirisk_epi.render.init = function() {
	window.digirisk_epi.render.event();
};

window.digirisk_epi.render.event = function() {};

window.digirisk_epi.render.callRenderChanged = function() {
	var key = undefined;

	for ( key in window.digirisk_epi ) {
		if ( window.digirisk_epi[key].renderChanged ) {
			window.digirisk_epi[key].renderChanged();
		}
	}
};
