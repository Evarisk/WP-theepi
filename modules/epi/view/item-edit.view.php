<?php
/**
 * La vue Edition du module EPI.
 *
 * @package   TheEPI
 * @author    Evarisk <dev@evarisk.com>
 * @copyright 2019 Evarisk
 * @since     0.1.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="row-resume wpeo-form">
	<div class="table-cell table-100 id" data-title="<?php echo esc_attr_e( 'ID', 'theepi' ); ?>">
		<?php echo esc_attr( $epi->data['unique_identifier'] ); ?>
		<?php echo esc_attr( $epi->data['id'] ); ?>
	</div>

	<div class="table-cell table-75 thumbnail">
		<?php echo do_shortcode( '[wpeo_upload id="' . $epi->data['id'] . '" model_name="/theepi/EPI_Class" single="false" field_name="image" ]' ); ?>
	</div>

	<div class="table-cell table-75 quantity" data-title="<?php echo esc_attr_e( 'Quantity', 'theepi' ); ?>">
		<div class="form-element">
			<label class="form-field-container">
				<input class="form-field" type="number" name="quantity" value="<?php echo esc_attr( $epi->data['quantity'] ); ?>" />
			</label>
		</div>
	</div>

	<div class="table-cell table-75 code-qr" data-title="<?php echo esc_attr_e( 'Code QrCode', 'theepi' ); ?>">
		<?php if ( $edit_mode ): ?>
			<div class="wpeo-button wpeo-tooltip-event button-grey button-square-30 button-size-small button-rounded qrcode action-attribute"
				aria-label="<?php esc_html_e( 'Click to enlarge the QrCode', 'theepi' ); ?>"
				data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
				data-action="open_qrcode"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'open_qrcode' ) ); ?>"
				data-url="<?php echo esc_attr( get_option( 'siteurl' ) . '/?p=' . $epi->data['id'] ) ?>">
				<i class="fas fa-qrcode"></i>
			</div>
		<?php endif; ?>
	</div>

	<div class="table-cell table-150 serial-number" data-title="<?php echo esc_attr_e( 'Serial Number', 'theepi' ); ?>">
		<div class="form-element">
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-barcode"></i></span>
				<input class="form-field" type="text" name="serial_number" value="<?php echo esc_attr( $epi->data['serial_number'] ); ?>" />
			</label>
		</div>
	</div>

	<div class="table-cell title" data-title="<?php echo esc_attr_e( 'Title', 'theepi' ); ?>">
		<div class="form-element">
			<label class="form-field-container">
				<input class="form-field" type="text" name="title" value="<?php echo esc_attr( $epi->data['title'] ); ?>" />
			</label>
		</div>
	</div>

	<div class="table-cell table-100 responsable" data-title="<?php echo esc_attr_e( 'Manager', 'theepi' ); ?>"></div>

	<div class="table-cell table-150 last-control" data-title="<?php echo esc_attr_e( 'Last Control', 'theepi' ); ?>">
		<?php if ( $edit_mode ): ?>
			<?php if ( EPI_Class::g()->get_last_control_date( $epi ) != "" ): ?>
				<span class="form-label" name="control-date" value="<?php echo esc_attr( EPI_Class::g()->get_last_control_date( $epi ) ); ?>">
					<i class="fas fa-calendar-alt"></i> <?php echo esc_attr( date( 'd/m/Y' , strtotime( EPI_Class::g()->get_last_control_date( $epi ) ) ) ); ?>
				</span>
			<?php endif; ?>
		<?php endif; ?>
	</div>

	<div class="table-cell table-75 add-control" data-title="<?php echo esc_attr_e( 'Add control', 'theepi' ); ?>"></div>

	<div class="table-cell table-75 next-control" data-title="<?php echo esc_attr_e( 'Next Control', 'theepi' ) ?>">
		<?php if ( $edit_mode ): ?>
			<?php
			\eoxia\View_Util::exec(
				'theepi', 'epi', 'item-control', array(
					'epi'         => $epi,
					'number_days' => EPI_Class::g()->get_days( $epi ),
				)
			);
			?>
		<?php endif; ?>
	</div>

	<div class="table-cell table-75 status" data-title="<?php echo esc_attr_e( 'Status EPI', 'theepi' ); ?>">
		<span class="epi-status-icon fas <?php echo esc_attr( EPI_Class::g()->get_status( $epi ) ); ?>"></span>
	</div>

	<div class="table-cell table-100 table-end action-end" data-title="<?php esc_attr_e( 'Actions', 'theepi' ); ?>">
		<div class="wpeo-button wpeo-tooltip-event button-green button-progress button-square-50 edit button-save-epi"
			aria-label="<?php esc_html_e( 'Save EPI', 'theepi' ); ?>"
			data-parent="epi-row"
			data-action="save_epi"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'save_epi' ) ); ?>"
			data-id="<?php echo esc_attr( $epi->data['id'] ); ?>">
			<span class="button-icon fas fa-save"></span>
		</div>
	</div>
</div>
