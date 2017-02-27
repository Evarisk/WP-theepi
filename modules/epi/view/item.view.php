<?php
/**
 * La vue principale de la page "EPI"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0.0.0
 * @version 1.0.0.0
 * @copyright 2017 Evarisk
 * @package epi
 * @subpackage view
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<tr>
	<td class="w50"><?php do_shortcode( '[eo_upload_button id="' . $epi->id . '" namespace="evarisk_epi" type="epi"]' ); ?></td>
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
