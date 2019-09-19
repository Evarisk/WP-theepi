<?php
/**
 * La vue Edition du module EPI.
 *
 * @package   TheEPI
 * @author    Evarisk <dev@evarisk.com>
 * @copyright 2019 Evarisk
 * @since     0.1.0
 * @version   0.6.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="table-row epi-row edit" data-id="<?php echo esc_attr( $epi->data['id'] ); ?>">
	<div class="table-cell table-100" style="text-align: center;" data-title="<?php echo esc_attr_e( 'ID', 'theepi' ); ?>">
		<span style="color: grey;"><i class="fas fa-hashtag"></i> <?php echo esc_attr( $epi->data['id'] ); ?></span></br>
	</div>

	<div class="table-cell table-100">
		<?php echo do_shortcode( '[wpeo_upload id="' . $epi->data['id'] . '" model_name="/theepi/EPI_Class" single="false" field_name="image" ]' ); ?>
	</div>

	<div class="table-cell table-250" data-title="<?php echo esc_attr_e( 'Title', 'theepi' ); ?>"> </br>
		<div class="wpeo-form" style="margin-bottom: 20px;">
			<div class="form-element">
				<label class="form-field-container">
					<input class="form-field" type="text" name="title" value="<?php echo esc_attr( $epi->data['title'] ); ?>" />
				</label>
			</div>
		</div>
	</div>

	<div class="table-cell table-200" data-title="<?php echo esc_attr_e( 'Serial Number', 'theepi' ); ?>">
		<div class="wpeo-form">
			<div class="form-element">
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-barcode"></i></span>
					<input class="form-field" type="text" name="serial_number" value="<?php echo esc_attr( $epi->data['serial_number'] ); ?>" />
				</label>
			</div>
		</div>
	</div>

	<div class="table-cell table-50"></div>

	<div class="table-cell table-150"></div>

	<div class="table-cell table-250"></div>

	<div class="table-cell table-100"></div>

	<div class="table-cell table-150" style="text-align : center" data-title="<?php echo esc_attr_e( 'Status EPI', 'theepi' ); ?>">
		<?php if ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( Audit_Class::g()->get_status( $epi ) == "OK" ) ) : ?>
			<i class="fas fa-check-circle fa-4x" style="color: mediumspringgreen;"></i>
		<?php elseif ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( Audit_Class::g()->get_status( $epi ) == "rebut" ) ) : ?>
			<i class="fas fa-trash fa-4x" style="color: blue;"></i>
		<?php else : ?>
			<i class="fas fa-exclamation-circle fa-4x" style="color: red;"></i>
		<?php endif; ?>
	</div>

	<div class="table-cell table-150"></div>

	<div class="table-cell table-150"></div>

	<div class="table-cell table-end">
		<div class="wpeo-button wpeo-tooltip-event button-green button-progress button-square-50 edit button-save-epi"
			aria-label="<?php esc_html_e( 'Save EPI', 'theepi' ); ?>"
			data-parent="epi-row"
			data-action="save_epi"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'save_epi' ) ); ?>"
			data-id="<?php echo esc_attr( $epi->data['id'] ); ?>">
			<span class="button-icon fas fa-save"></span>
		</div>

		<div class="wpeo-button wpeo-tooltip-event button-grey button-square-50 epi-item-link-cancel action-attribute"
			aria-label="<?php esc_html_e( 'Cancel EPI', 'theepi' ); ?>"
			data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
			data-action="cancel_edit_epi"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'cancel_edit_epi' ) ); ?>">
			<i class="fas fa-undo-alt"></i>
	  	</div>
	</div>
</div>
