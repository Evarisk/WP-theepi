<?php
/**
 * Le formulaire pour éditer.
 *
 * @package   TheEPI
 * @author    Evarisk <dev@evarisk.com>
 * @copyright 2018 Evarisk
 * @since     0.1.0
 * @version   0.4.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="table-row epi-row edit" data-id="<?php echo esc_attr( $epi->data['id'] ); ?>">
	<div class="table-cell  table-100 padding">
		<?php echo do_shortcode( '[wpeo_upload id="' . $epi->data['id'] . '" model_name="/theepi/EPI_Class" single="false" field_name="image" ]' ); ?>
	</div>

	<div class="table-cell table-150 padding"></div>

	<div class="table-cell table-300" data-title="<?php echo esc_attr_e( 'Title', 'theepi' ); ?>"> </br>
		<div class="wpeo-form">
			<div class="form-element">
				<label class="form-field-container">
					<input class="form-field" type="text" name="title" value="<?php echo esc_attr( $epi->data['title'] ); ?>" />
				</label>
			</div>
		</div>

		<?php
			\eoxia\View_Util::exec(
			'theepi', 'epi', 'item-link-edit', array(
			'epi' => $epi,
			) );
		?>
	</div>

	<div class="table-cell table-200" data-title="<?php echo esc_attr_e( 'Serial Number', 'theepi' ); ?>">
		<div class="wpeo-form" style="margin-left : 35px">
			<div class="form-element">
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-barcode"></i></span>
					<input class="form-field" type="text" name="serial_number" value="<?php echo esc_attr( $epi->data['serial_number'] ); ?>" />
				</label>
			</div>
		</div>
	</div>

	<div class="table-cell table-250" data-title="<?php echo esc_attr_e( 'Commissioning Date', 'theepi' ); ?>">
		<div class="wpeo-form" style="margin-left : 35px">
			<div class="form-element form-element-required group-date">
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
						<input type="hidden" class="mysql-date" name="commissioning-date" />
						<?php if( $epi->data['commissioning_date_valid'] ): ?>
							<input class="form-field date" type="text" name="commissioning-date"
							value="<?php echo esc_attr( $epi->data['commissioning_date']['rendered']['date'] ); ?>"/>
						<?php else: ?>
							<input class="form-field date" type="text" name="commissioning-date"
							value=""/>
						<?php endif; ?>
				</label>
			</div>
		</div>
		<!-- <div class="wpeo-form">
			<div class="form-element">
				<label class="form-field-container">
					<input class="wpeo-popover-event form-field"
					aria-label="<?php esc_attr_e( 'This field must be in numeric format and better than 0', 'theepi' ); ?>"
					data-color="red"
					data-before-method="checkData"
					type="text"
					name="periodicity"
					value="<?php echo esc_attr( $epi->data['periodicity'] ); ?>" />
					<span class="form-field-label-next"><?php esc_html_e( 'days', 'theepi' ); ?></span>
				</label>
			</div>
		</div> -->
	</div>
	<div class="table-cell">

	</div>

	<div class="table-cell table-200" style="text-align : center" data-title="<?php echo esc_attr_e( 'Status', 'theepi' ); ?>">
		<?php if ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( Audit_Class::g()->get_status( $epi ) == "OK" ) ) : ?>
			<i class="fas fa-check-circle fa-3x" style="color: mediumspringgreen;"></i>
		<?php elseif ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( Audit_Class::g()->get_status( $epi ) == "rebut" ) ) : ?>
			<i class="fas fa-trash fa-3x" style="color: blue;"></i>
		<?php else : ?>
			<i class="fas fa-exclamation-circle fa-3x" style="color: red;"></i>
		<?php endif; ?>
	</div>

	<div class="table-cell table-75 table-end">
		<div
			data-parent="epi-row"
			data-action="save_epi"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'save_epi' ) ); ?>"
			data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
			class="wpeo-button button-green button-progress button-square-50 edit button-save-epi"><span class="button-icon fas fa-save"></span>
		</div>
	</div>
</div>
