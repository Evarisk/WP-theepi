var Nightmare = require('nightmare');
var path = require('path');

var nightmare = Nightmare({
	show: true,
	typeInterval: 150,
	width: 1300,
	height: 1000,
	waitTimeout: 200 * 1000,
	webPreferences: {
		preload: path.resolve("./xhr.js")
	}
});

var navigate = require('./core/navigate');

navigate.goToLogin(nightmare, function() {
	navigate.goToApp(nightmare, function() {
		nightmare.end();
	});
});
