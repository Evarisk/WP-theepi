<?php
/**
 * Affichage pour gérer les données par défaut.
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com>
 * @copyright 2015-2017 Evarisk
 * @since     0.3.0
 * @version   0.3.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<form class="wpeo-form date-management">
	<input type="hidden" name="action" value="save_date_management" />
	<?php wp_nonce_field( 'save_date_management' ); ?>

	<h3><?php esc_html_e( 'Handle date management', 'theepi' ); ?></h3>

	<div class="form-element">
		<span class="form-label"><?php esc_html_e( 'Purchase Date Valued', 'theepi' ); ?></span>
		<span class="form-sublabel"><?php echo esc_html_e( "Please indicate if you want your Purchase Date and your Commissioning Date to be equal" ,'theepi' ); ?> </span>
		<label class="form-field-container">
			<?php if( $default_purchase_date ): ?>
				<input type="checkbox" class="form-field" name="checkbox-purchase-date" id="checkbox-purchase-date" checked>
			<?php else: ?>
				<input type="checkbox" class="form-field" name="checkbox-purchase-date" id="checkbox-purchase-date">
			<?php endif; ?>
			<label for="checkbox-purchase-date"><?php echo esc_html_e("Purchase Date = Commissioning Date", 'theepi' ) ?></label>
		</label>
	</div>

	<div class="form-element" style="width : 20%">
		<span class="form-label"><?php esc_html_e( 'Manufacture Date Valued', 'theepi' ); ?></span>
		<span class="form-sublabel"><?php echo esc_html_e( "Please indicate the number of years between Manufacture Date valued and Commissioning Date of your PPE" ,'theepi' ); ?> </span>
		<label class="form-field-container">
			<input type="number" class="form-field" name="default-manufacture-date" value="<?php echo esc_attr( $default_manufacture_date ); ?>"/>
			<span class="form-field-label-next"><?php echo esc_html_e( 'years', 'theepi' ); ?></span>
		</label>
	</div>

	<div class="wpeo-button button-green button-progress action-input" data-parent="wpeo-form" style="margin-top : 20px">
		<span class="button-icon fas fa-save"></span>
	</div>
</form>
