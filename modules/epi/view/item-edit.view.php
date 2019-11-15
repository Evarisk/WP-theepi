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

use eoxia\View_Util;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Documentation des variables utilisées dans la vue.
*
* @var EPI_Model $epi       Les données d'un EPI.
* @var boolean   $edit_mode True si il s'agit de la vue édition d'un EPI.
*/
?>

<div class="row-resume wpeo-form">
	<div class="table-cell table-100 id" data-title="<?php echo esc_attr_e( 'ID', 'theepi' ); ?>">
		<?php if ( $edit_mode ) : ?>
			<a href="<?php echo esc_html( get_option( 'siteurl' ) . '/?p=' . $epi->data['id'] ); ?>" target="_blank"><?php echo esc_attr( $epi->data['unique_identifier'] ); ?></a>
		<?php else : ?>
			<?php echo esc_attr( $epi->data['unique_identifier'] ); ?>
		<?php endif; ?>
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
		<?php if ( $edit_mode ) : ?>
			<div class="wpeo-button wpeo-tooltip-event button-grey button-square-30 button-size-small button-rounded qrcode action-attribute"
				aria-label="<?php esc_html_e( 'Click to enlarge the QrCode', 'theepi' ); ?>"
				data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
				data-action="open_qrcode"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'open_qrcode' ) ); ?>"
				data-url="<?php echo esc_attr( get_option( 'siteurl' ) . '/?p=' . $epi->data['id'] ); ?>">
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

	<div class="table-cell table-100 responsable" data-title="<?php echo esc_attr_e( 'Manager', 'theepi' ); ?>">
		<?php if ( 0 === $epi->data['manager'] ) : ?>
			<?php echo do_shortcode( '[theepi_avatar ids="' . $epi->data['author_id'] . '" size="50"]' ); ?>
		<?php else : ?>
			<?php echo do_shortcode( '[theepi_avatar ids="' . $epi->data['manager'] . '" size="50"]' ); ?>
		<?php endif; ?>
	</div>

	<div class="table-cell table-150 last-control" data-title="<?php echo esc_attr_e( 'Last Control', 'theepi' ); ?>">
		<?php if ( $edit_mode ) : ?>
			<?php if ( ! empty( EPI_Class::g()->get_last_control_date( $epi ) ) ) : ?>
				<span class="epi-last-control-date" name="control-date" value="<?php echo esc_attr( EPI_Class::g()->get_last_control_date( $epi ) ); ?>">
				<i class="fas fa-calendar-alt"></i> <?php echo esc_attr( date( 'd/m/Y', strtotime( EPI_Class::g()->get_last_control_date( $epi ) ) ) ); ?>
			</span>
				<div class="wpeo-button wpeo-tooltip-event button-grey button-square-30 button-rounded action-attribute"
					aria-label="<?php esc_html_e( 'See All Control', 'theepi' ); ?>"
					data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
					data-frontend="fasle"
					data-action="display_control"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_control' ) ); ?>"
					data-type="see_control" >
					<i class="fas fa-eye"></i>
				</div>
			<?php else : ?>
				<span class="epi-last-control-date" name="control-date">
				<?php esc_html_e( 'No Control Yet', 'theepi' ); ?>
			</span>
			<?php endif; ?>
		<?php endif; ?>
	</div>

	<div class="table-cell table-75 add-control" data-title="<?php echo esc_attr_e( 'Add control', 'theepi' ); ?>"></div>

	<div class="table-cell table-75 next-control" data-title="<?php echo esc_attr_e( 'Next Control', 'theepi' ); ?>">
		<?php if ( $edit_mode ) : ?>
			<?php
			View_Util::exec(
				'theepi',
				'epi',
				'item-control',
				array(
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
