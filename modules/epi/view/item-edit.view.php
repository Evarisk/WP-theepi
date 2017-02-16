<?php
/**
 * Le formulaire pour éditer ou ajouter un EPI.
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
	<?php wp_nonce_field( 'save_epi' ); ?>
	<input type="hidden" name="id" value="<?php echo esc_attr( $epi->id ); ?>" />

	<td class="w50"><?php do_shortcode( '[eo_upload_button id="' . $epi->id . '" namespace="evarisk_epi" type="epi"]' ); ?></td>
	<td class="w50"><?php echo esc_html( $epi->unique_identifier ); ?></td>
	<td class="padding w150"><input type="text" name="title" value="<?php echo esc_attr( $epi->title ); ?>" placeholder="Nom" /></td>
	<td class="padding w150"><input type="text" name="serial_number" value="<?php echo esc_attr( $epi->serial_number ); ?>" placeholder="Numéro de série" /></td>
	<td class="padding tooltip red" aria-label="<?php esc_attr_e( 'Le champ doit être au format numérique', 'digirisk' ); ?>"><input type="text" name="frequency_control" value="<?php echo esc_attr( $epi->frequency_control ); ?>" placeholder="10" /></td>
	<td>jours</td>
	<td><?php do_shortcode( '[digi_comment id="' . $epi->id . '" namespace="evarisk_epi" type="epi_comment" display="edit"]' ); ?></td>
	<td><select name="test">
		<option>OK</option>
		<option>KO</option>
	</select></td>
	<td><?php echo $epi->compiled_remaining_time; // WPCS: XSS is ok. ?></td>
	<td>
		<div class="action grid-layout w2">
			<?php if ( 0 !== $epi->id ) : ?>
				<div data-parent="epi-row" data-module="epi" data-before-method="checkData" data-loader="table" class="button w50 green save action-input"><i class="icon fa fa-floppy-o"></i></div>
			<?php else : ?>
				<div data-module="epi" data-before-method="checkData" data-loader="table" data-parent="epi-row" class="button w50 blue add action-input progress"><i class="icon fa fa-plus"></i></div>
			<?php endif; ?>
		</div>
	</td>
</tr>
