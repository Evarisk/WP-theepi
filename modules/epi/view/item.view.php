<?php
/**
 * La vue principale de la page "EPI"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0.0
 * @version 1.0.1
 * @copyright 2017 Evarisk
 * @package Digirisk_EPI
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr>
	<td class="w50">
		<?php do_shortcode( '[wpeo_upload id="' . $epi->id . '" model_name="/evarisk_epi/' . $epi->get_class() . '" single="false" field_name="image" ]' ); ?>
	</td>
	<td class="w50 padding"><?php echo esc_html( $epi->unique_identifier ); ?></td>
	<td class="padding"><?php echo esc_html( $epi->title ); ?></td>
	<td class="padding"><?php echo esc_html( $epi->serial_number ); ?></td>
	<td class="w100 padding"><?php echo esc_html( $epi->frequency_control ); ?></td>
	<td></td>
	<td class=""><?php EPI_Comment_Class::g()->display( $epi ); ?></td>
	<td><?php echo esc_html( $epi->state ); ?></td>
	<td class="padding"><?php echo $epi->compiled_remaining_time; // WPCS: XSS is ok. ?></td>

	<td>
		<div class="action grid-layout w2">
			<div 	class="button w50 edit light action-attribute"
						data-id="<?php echo esc_attr( $epi->id ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_epi' ) ); ?>"
						data-action="load_epi"
						data-loader="table">
				<i class="icon fa fa-pencil"></i>
			</div>

			<div 	class="button w50 delete light action-delete"
						data-id="<?php echo esc_attr( $epi->id ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_epi' ) ); ?>"
						data-action="delete_epi"
						data-loader="table">
				<i class="icon fa fa-times"></i>
			</div>
		</div>
	</td>
</tr>
