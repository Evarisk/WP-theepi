var expect  = require('chai').expect;
var fs      = require("fs");
var epiData = fs.readFileSync("./test/module/epi.json");
var epiData = JSON.parse(epiData);

module.exports.init = function(nightmare, cb) {
	describe('EPI', () => {
		it('Create', (done) => {
			this.create(nightmare, done);
			cb();
		});
	});
}

/**
 * Create test data from epi.json.
 *
 * @since 0.2.0
 * @version 0.2.0
 *
 * @param  {Object}   nightmare NightmareJS object.
 * @param  {Function} done      Result func.
 *
 * @return {void}
 */
module.exports.create = function(nightmare, done) {
	for ( var key in epiData.create ) {
		nightmare
			.type( ".epi-row input[name='title']", epiData.create[key].title )
			.type( ".epi-row input[name='serial_number']", epiData.create[key].serial_number )
			.type( ".epi-row input[name='frequency_control']", epiData.create[key].frequency_control )
			.type( ".epi-row textarea[name='list_comment[0][content]']", epiData.create[key].content );

		if ( epiData.create[key].mysql_date ) {
			nightmare.type( ".epi-row .mysql-date", '' );
			nightmare.type( ".epi-row .mysql-date", epiData.create[key].mysql_date );
		}

		nightmare
			.click( ".epi-row .action-input" )
			.wait(function() {
				if (window.currentResponse['savedEpiSuccess']) {
					return true;
				}
			})
			.evaluate(() => {
				var response = window.currentResponse['savedEpiSuccess'];
				delete window.currentResponse['savedEpiSuccess'];

				var success = true;
				var errors = [];

				if ( ! document.body.contains( document.querySelector( 'tr[data-id="' + response.data.object.id + '"]' ) ) ) {
					response.success = false;
				}

				// if ( '')

				response.data.errors = errors;

				if ( response.data.errors.length ) {
					response.success = false;
				}

				window.epiDataCreateResponse.push( response );
				return window.epiDataCreateResponse;
			})
	}

	nightmare.then((response) => {
		for ( var i = 0; i < response.length; i++ ) {
			expect(response[i].data.callback_success).to.equal('savedEpiSuccess');
			expect(response[i].success).to.equal(true);
		}

	})
	.then(done, done);
}
