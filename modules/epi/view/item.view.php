<?php
/**
 * La vue principale de la page "EPI"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.0.0.1
 * @version 0.0.0.1
 * @copyright 2017 Evarisk
 * @package epi
 * @subpackage view
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php namespace evarisk_epi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<tr>
	<td></td>
	<td><?php echo $epi->unique_identifier; ?></td>
	<td><?php echo $epi->title; ?></td>
	<td><?php echo $epi->serial_number; ?></td>
	<td><?php echo $epi->frequency_control; ?></td>
	<td><?php echo $epi->control_date; ?></td>
	<td><?php echo $epi->compiled_remaining_time; ?></td>

	<td>
		<a href="#"
			data-id="<?php echo $epi->id; ?>"
			data-nonce="<?php echo wp_create_nonce( 'ajax_load_epi_' . $epi->id ); ?>"
			data-action="load_epi"
			class="wp-digi-action wp-digi-action-load action-attribute dashicons dashicons-edit" ></a>

		<a href="#"
			data-id="<?php echo $epi->id; ?>"
			data-nonce="<?php echo wp_create_nonce( 'ajax_delete_epi_' . $epi->id ); ?>"
			data-action="delete_epi"
			class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a>
	</td>
</tr>
