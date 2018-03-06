<?php
/**
 * Le formulaire pour éditer ou ajouter un EPI.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 0.1.0
 * @version 0.4.0
 * @copyright 2018 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="epi-row">
	<input type="hidden" name="action" value="save_epi" />
	<?php wp_nonce_field( 'save_epi' ); ?>
	<input type="hidden" name="id" value="<?php echo esc_attr( $epi->data['id'] ); ?>" />

	<td class="w50">
		<?php do_shortcode( '[wpeo_upload id="' . $epi->data['id'] . '" model_name="/theepi/EPI_Class" single="false" field_name="image" ]' ); ?>
	</td>
	<td class="w50" data-title="<?php echo esc_attr_e( 'ID', 'theepi' ); ?>"><?php echo esc_html( $epi->data['unique_identifier'] ); ?></td>
	<td class="padding w150" data-title="<?php echo esc_attr_e( 'Name', 'theepi' ); ?>"><input type="text" name="title" value="<?php echo esc_attr( $epi->data['title'] ); ?>" /></td>
	<td class="padding w150" data-title="<?php echo esc_attr_e( 'Serial number', 'theepi' ); ?>"><input type="text" name="serial_number" value="<?php echo esc_attr( $epi->data['serial_number'] ); ?>" /></td>
	<td class="padding" data-title="<?php echo esc_attr_e( 'Period of control', 'theepi' ); ?>">
		<input 	class="wpeo-popover-event"
						aria-label="<?php esc_attr_e( 'This field must be in numeric format', 'theepi' ); ?>"
						data-color="red"
						type="text"
						name="frequency_control"
						value="<?php echo esc_attr( $epi->data['frequency_control'] ); ?>" /></td>
	<td><?php esc_html_e( 'days', 'theepi' ); ?></td>
	<td data-title="<?php echo esc_attr_e( 'Date of last check and comment', 'theepi' ); ?>"><?php EPI_Comment_Class::g()->display_edit( $epi ); ?></td>
	<td data-title="<?php echo esc_attr_e( 'State', 'theepi' ); ?>"><?php echo esc_html( $epi->data['state'] ); ?></td>
	<td data-title="<?php echo esc_attr_e( 'Remaining time', 'theepi' ); ?>"><?php echo $epi->data['compiled_remaining_time']; // WPCS: XSS is ok. ?></td>
	<td>
		<div class="wpeo-grid grid-2">
			<?php if ( 0 !== $epi->data['id'] ) : ?>
				<div	data-parent="epi-row"
							data-namespace="theEPI"
							data-module="EPI"
							data-before-method="checkData"
							class="wpeo-button button-green button-progress button-square-50 action-input edit"><span class="icon fal fa-floppy-o"></span></div>
			<?php else : ?>
				<div 	wpeo-before-cb="theEPI/EPI/checkData"
							data-parent="epi-row"
							class="wpeo-button button-progress button-square-50 button-disable button-blue button-event action-input add"><span class="icon fal fa-plus"></span></div>
			<?php endif; ?>
		</div>
	</td>
</tr>
