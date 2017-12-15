<?php
/**
 * La vue principale de la page "EPI"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 0.4.0
 * @copyright 2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="wpeo-animate <?php echo esc_attr( ( ! empty( $new ) && true === $new ) ? 'new' : '' ); ?>" data-id="<?php echo esc_attr( $epi->id ); ?>">
	<td class="w50">
		<?php do_shortcode( '[wpeo_upload id="' . $epi->id . '" model_name="/theepi/' . $epi->get_class() . '" single="false" field_name="image" ]' ); ?>
	</td>
	<td class="w50 padding" data-title="<?php echo esc_attr_e( 'ID', 'theepi' ); ?>"><?php echo esc_html( $epi->unique_identifier ); ?></td>
	<td class="padding" data-title="<?php echo esc_attr_e( 'Name', 'theepi' ); ?>"><?php echo esc_html( $epi->title ); ?></td>
	<td class="padding" data-title="<?php echo esc_attr_e( 'Serial number', 'theepi' ); ?>"><?php echo esc_html( $epi->serial_number ); ?></td>
	<td class="w100 padding" data-title="<?php echo esc_attr_e( 'Period of control', 'theepi' ); ?>"><?php echo esc_html( $epi->frequency_control ); ?></td>
	<td></td>
	<td data-title="<?php echo esc_attr_e( 'Date of last check and comment', 'theepi' ); ?>"><?php EPI_Comment_Class::g()->display( $epi ); ?></td>
	<td data-title="<?php echo esc_attr_e( 'State', 'theepi' ); ?>"><?php echo esc_html( $epi->state ); ?></td>
	<td class="padding" data-title="<?php echo esc_attr_e( 'Remaining time', 'theepi' ); ?>"><?php echo $epi->compiled_remaining_time; // WPCS: XSS is ok. ?></td>

	<td>
		<div class="wpeo-grid grid-2">
			<div 	class="wpeo-button button-square-50 button-progress action-attribute"
						data-id="<?php echo esc_attr( $epi->id ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_epi' ) ); ?>"
						data-action="load_epi"
						data-loader="table">
				<span class="icon fa fa-pencil"></span>
			</div>

			<div 	class="wpeo-button button-red button-square-50 button-progress action-delete"
						data-id="<?php echo esc_attr( $epi->id ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_epi' ) ); ?>"
						data-action="delete_epi"
						data-loader="table">
				<span class="icon fa fa-times"></span>
			</div>
		</div>
	</td>
</tr>
