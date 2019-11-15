/**
 * Initialise l'objet "EPI" + "service" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 0.1.0
 * @version 0.6.0
 */
window.eoxiaJS.theEPI.service = {};

window.eoxiaJS.theEPI.service.init = function() {
	window.eoxiaJS.theEPI.service.event();
};

window.eoxiaJS.theEPI.service.event = function() {
	jQuery( document ).on( 'click', '.row-advanced.service .advanced-service.date .button-toggle', window.eoxiaJS.theEPI.service.buttonToggle );
	jQuery( document ).on( 'change', '.advanced-service.date .update-end-life-date-epi', window.eoxiaJS.theEPI.service.updateEndLifeDateEPI );
	jQuery( document ).on( 'change', '.advanced-service.life-sheet .update-control-date-epi', window.eoxiaJS.theEPI.service.updateControlDateEPI );
	jQuery( document ).on( 'change', '.advanced-service.life-sheet .update-purchase-date-epi', window.eoxiaJS.theEPI.service.updatePurchaseDateEPI );
	jQuery( document ).on( 'change', '.row-advanced.service.main .update-manufacture-date-epi', window.eoxiaJS.theEPI.service.updateManufactureDateEPI );
	jQuery( document ).on( 'mouseenter', '.row-advanced.service.main .empty-date-epi', window.eoxiaJS.theEPI.service.addEmptyOptionDateEPI );
	jQuery( document ).on( 'mouseleave', '.row-advanced.service.main .empty-date-epi', window.eoxiaJS.theEPI.service.removeEmptyOptionDateEPI );
	jQuery( document ).on( 'click', '.row-advanced.service.main .empty-date-epi .form-field-label-next', window.eoxiaJS.theEPI.service.actionEmptyOptionDateEPI );
	jQuery( document ).on( 'keyup', '.row-advanced.service.main .empty-date-epi', window.eoxiaJS.theEPI.service.actionKeybordEmptyOptionDateEPI );

};

/**
 * Récupère l'état du bouton toggle.
 *
 * @since 0.7.0
 * @version 0.7.0
 *
 * @param  {ClickEvent} event [t]
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.service.buttonToggle = function( event ) {

	var toggleON = jQuery( this ).hasClass( 'fa-toggle-on' );
	var nextStep = '';
	if (toggleON) {
		nextStep = 'NO';
		jQuery( this ).removeClass( "fa-toggle-on" ).addClass( "fa-toggle-off" );
		jQuery( this ).closest( ".advanced-service.date" ).find( '.button-toggle-lifetime-display' ).addClass( 'hidden' );
	} else {
	nextStep = 'YES';
		jQuery( this ).removeClass( "fa-toggle-off" ).addClass( "fa-toggle-on" );
		jQuery( this ).closest( ".advanced-service.date" ).find( '.button-toggle-lifetime-display' ).removeClass( 'hidden' );
	}
	jQuery( this ).closest( '.advanced-service.date' ).find( '.button-toggle-lifetime' ).attr( 'data-value' , nextStep );
};

/**
 * Cacul le champ Date de fin de vie instantanément et l'affiche.
 *
 * @since 0.7.0
 * @version 0.7.0
 *
 * @param  {ClickEvent} event [champ Date de fin de vie]
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.service.updateEndLifeDateEPI = function( event ) {
	let parent_element       = jQuery( this ).closest( ".advanced-service.date" );
	let manufacture_date_old = parent_element.find( '.mysql-date[name="manufacture-date"]' ).val();
	let lifetime_old         = parent_element.find( '.form-field[name="lifetime"]' ).val();

	let end_life_date_element_sql = parent_element.find( '.mysql-date[name="end-life-date"]' );
	let end_life_date_element     = parent_element.find( '.form-field[name="end-life-date"]' );

	let end_life_date = new Date( manufacture_date_old );
	end_life_date.setDate( end_life_date.getDate() + parseInt(lifetime_old) );
	month = end_life_date.getMonth() + 1;
	month   = month < 10 ? '0' + month : month;
	day     = end_life_date.getDate()  < 10 ? '0' + end_life_date.getDate()  : end_life_date.getDate();
	end_life_date_sql = end_life_date.getFullYear() + '-' + month + '-' + day;
	end_life_date_display = day + '/' + month + '/' + end_life_date.getFullYear();

	if ( end_life_date_sql !== 'NaN/NaN/NaN' && end_life_date_display !== 'NaN/NaN/NaN') {
		end_life_date_element_sql.val( end_life_date_sql );
		end_life_date_element.val(end_life_date_display);
	}
};

/**
 * Cacul le champ Date de Contrôle instantanément et l'affiche.
 *
 * @since 0.7.0
 * @version 0.7.0
 *
 * @param  {ClickEvent} event [champ Date de Contrôle]
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.service.updateControlDateEPI = function( event ) {
	var parent_element = jQuery( this ).closest( ".advanced-service.life-sheet" );
	var commissioning_date_old = parent_element.find( '.mysql-date[name="commissioning-date"]' ).val();
	var periodicity_old = parent_element.find( '.form-field[name="periodicity"]' ).val();

	var control_date_element_sql = parent_element.find( '.mysql-date[name="control-date"]');
	var control_date_element = parent_element.find( '.form-field[name="control-date"]');

	var control_date = new Date( commissioning_date_old );
	control_date.setDate( control_date.getDate() + parseInt(periodicity_old) );
	month = control_date.getMonth() + 1;
	month   = month < 10 ? '0' + month : month;
	day     = control_date.getDate()  < 10 ? '0' + control_date.getDate()  : control_date.getDate();
	control_date_sql = control_date.getFullYear() + '-' + month + '-' + day;
	control_date_display = day + '/' + month + '/' + control_date.getFullYear();

 	if ( control_date_sql != 'NaN/NaN/NaN' && control_date_display != 'NaN/NaN/NaN') {
		control_date_element_sql.val( control_date_sql );
		control_date_element.val(control_date_display);
	}
};

/**
 * Cacul le champ Date d'Achat instantanément et l'affiche.
 *
 * @since 0.7.0
 * @version 0.7.0
 *
 * @param  {ClickEvent} event [champ Date d'Achat]
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.service.updatePurchaseDateEPI = function( event ) {
	var parent_element = jQuery( this ).closest( ".advanced-service.life-sheet" );
	var commissioning_date = parent_element.find( '.mysql-date[name="commissioning-date"]' ).val();

	var purchase_date_element_sql = parent_element.find( '.mysql-date[name="purchase-date"]');
	var purchase_date_element = parent_element.find( '.form-field[name="purchase-date"]');

	var purchase_date = new Date( commissioning_date );
	month = purchase_date.getMonth() + 1;
	month   = month < 10 ? '0' + month : month;
	day     = purchase_date.getDate()  < 10 ? '0' + purchase_date.getDate()  : purchase_date.getDate();
	purchase_date_display = day + '/' + month + '/' + purchase_date.getFullYear();

	purchase_date_element_sql.val( commissioning_date );
	purchase_date_element.val( purchase_date_display );
};

/**
 * Cacul le champ Date de fabrication instantanément et l'affiche.
 *
 * @since 0.7.0
 * @version 0.7.0
 *
 * @param  {ClickEvent} event [champ Date de fabrication]
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.service.updateManufactureDateEPI = function( event ) {
	var parent_element = jQuery( this ).closest( ".row-advanced.service.main" );
	var commissioning_date = parent_element.find( '.mysql-date[name="commissioning-date"]' ).val();
	var manufacture_date_valued = parent_element.find( '.manufacture-date-valued[name="manufacture-date-valued"]' ).val();

	var manufacture_date_element_sql = parent_element.find( '.mysql-date[name="manufacture-date"]');
	var manufacture_date_element = parent_element.find( '.form-field[name="manufacture-date"]');

	var manufacture_date = new Date( commissioning_date );
	manufacture_date.setDate( manufacture_date.getDate() - parseInt(manufacture_date_valued) );
	month = manufacture_date.getMonth() + 1;
	month   = month < 10 ? '0' + month : month;
	day     = manufacture_date.getDate()  < 10 ? '0' + manufacture_date.getDate()  : manufacture_date.getDate();
	manufacture_date_sql = manufacture_date.getFullYear() + '-' + month + '-' + day;
	manufacture_date_display = day + '/' + month + '/' + manufacture_date.getFullYear();

	manufacture_date_element_sql.val( manufacture_date_sql );
	manufacture_date_element.val( manufacture_date_display );

	var manufacture_date_old = parent_element.find( '.mysql-date[name="manufacture-date"]' ).val();
	var lifetime_old = parent_element.find( '.form-field[name="lifetime"]' ).val();

	var end_life_date_element_sql = parent_element.find( '.mysql-date[name="end-life-date"]');
	var end_life_date_element = parent_element.find( '.form-field[name="end-life-date"]');

	var end_life_date = new Date( manufacture_date_old );
	end_life_date.setDate( end_life_date.getDate() + parseInt(lifetime_old) );
	month = end_life_date.getMonth() + 1;
	month   = month < 10 ? '0' + month : month;
	day     = end_life_date.getDate()  < 10 ? '0' + end_life_date.getDate()  : end_life_date.getDate();
	end_life_date_sql = end_life_date.getFullYear() + '-' + month + '-' + day;
	end_life_date_display = day + '/' + month + '/' + end_life_date.getFullYear();

	end_life_date_element_sql.val( end_life_date_sql );
	end_life_date_element.val(end_life_date_display);

};

/**
 * Ajoute au survol une croix.
 *
 * @since 0.7.0
 * @version 0.7.0
 *
 * @param  {MouseEvent} event [champ Date]
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.service.addEmptyOptionDateEPI  = function( event ) {
	var parent_element = jQuery( this ).closest( ".row-advanced.service.main" );
	var myqsl_element = parent_element.find( '.empty-date-epi').find( '.mysql-date').val();
	var date_element = parent_element.find( '.empty-date-epi').find( '.form-field.date' ).val();
	if ( myqsl_element != '' && date_element != '' ) {
		var delete_icon = '<span class="form-field-label-next"><i class="fas fa-times"></i></span>';
		parent_element.find( '.empty-date-epi').append( delete_icon );
	}

};

/**
 * Enlève la croix lorsque qu'on quitte le survol du champ date.
 *
 * @since 0.7.0
 * @version 0.7.0
 *
 * @param  {MouseEvent} event [champ Date]
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.service.removeEmptyOptionDateEPI  = function( event ) {
	var parent_element = jQuery( this ).closest( ".row-advanced.service.main" );
	parent_element.find( '.empty-date-epi').find( '.form-field-label-next' ).remove();

};

/**
 * Vide le champ date en cliquant sur la croix.
 *
 * @since 0.7.0
 * @version 0.7.0
 *
 * @param  {ClickEvent} event [champ Date]
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.service.actionEmptyOptionDateEPI  = function( event ) {
	var parent_element = jQuery( this ).closest( ".row-advanced.service.main" );
	parent_element.find( '.empty-date-epi').find( '.mysql-date').val( '' );
	parent_element.find( '.empty-date-epi').find( '.form-field.date' ).val( '' );

};

/**
 * Vide le champ date en appuyant sur la touche effacé.
 *
 * @since 0.7.0
 * @version 0.7.0
 *
 * @param  {KeyboardEvent} event L'état du clavier [effacer].
 *
 * @return {void}
 */
window.eoxiaJS.theEPI.service.actionKeybordEmptyOptionDateEPI = function( event ) {
	if ( 8 === event.keyCode ) {
		var parent_element = jQuery( this ).closest( ".row-advanced.service.main" );
		parent_element.find( '.empty-date-epi').find( '.mysql-date').val( '' );
		parent_element.find( '.empty-date-epi').find( '.form-field.date' ).val( '' );
	}
};
