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

<tr class="epi-row">
	<input type="hidden" name="action" value="save_epi" />
	<input type="hidden" name="id" value="<?php echo esc_attr( $epi->id ); ?>" />
	<td></td>
	<td><?php echo esc_html( $epi->unique_identifier ); ?></td>
	<td><input type="text" name="title" value="<?php echo esc_attr( $epi->title ); ?>" placeholder="Nom" /></td>
	<td><input type="text" name="serial_number" value="<?php echo esc_attr( $epi->serial_number ); ?>" placeholder="Numéro de série" /></td>
	<td><input type="text" name="frequency_control" value="<?php echo esc_attr( $epi->frequency_control ); ?>" placeholder="10" /> jours</td>
	<td><input type="text" class="date" name="control_date" value="<?php echo esc_attr( $epi->control_date ); ?>" placeholder="Date de contrôle" /></td>
	<td><?php echo esc_html( $epi->compiled_remaining_time ); ?></td>
	<td class="w50">
		<?php if ( 0 !== $epi->id ) : ?>
			<div class="action grid-layout w3">
				<div data-parent="epi-row" data-loader="table" class="button w50 green save action-input"><i class="icon fa fa-floppy-o"></i></div>
			</div>
		<?php else : ?>
			<div class="action grid-layout w3">
				<div data-module="risk" data-loader="table" data-parent="epi-row" class="button w50 blue add action-input progress"><i class="icon fa fa-plus"></i></div>
			</div>
		<?php endif; ?>
	</td>
</tr>
