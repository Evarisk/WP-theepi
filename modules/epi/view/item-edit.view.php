<?php
/**
 * Le formulaire pour éditer.
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

<tr class="epi-row edit"
	data-id="<?php echo esc_attr( $epi->data['id'] ); ?>">
	<td class="w50">
		<?php echo do_shortcode( '[wpeo_upload id="' . $epi->data['id'] . '" model_name="/theepi/EPI_Class" single="false" field_name="image" ]' ); ?>
	</td>
	<td class="padding"></td>
	<td class="padding" data-title="<?php echo esc_attr_e( 'Title', 'theepi' ); ?>"><input type="text" name="title" value="<?php echo esc_attr( $epi->data['title'] ); ?>" />
	<?php
	\eoxia\View_Util::exec( 'theepi', 'epi', 'item-link-edit', array(
		'epi'            => $epi
	) );
	 ?>
 </td>
	<td class="padding" data-title="<?php echo esc_attr_e( 'Reference', 'theepi' ); ?>"><input type="text" name="reference" value="<?php echo esc_attr( $epi->data['reference'] ); ?>" /></td>
	<td class="padding" data-title="<?php echo esc_attr_e( 'periodicity', 'theepi' ); ?>">
		<input 	class="wpeo-popover-event"
						aria-label="<?php esc_attr_e( 'This field must be in numeric format and better than 0', 'theepi' ); ?>"
						data-color="red"
						type="text"
						name="periodicity"
						value="<?php echo esc_attr( $epi->data['periodicity'] ); ?>" /></td>
	<td><?php esc_html_e( 'days', 'theepi' ); ?></td>
	<td>
		<div>
				<div	data-parent="epi-row"
							data-namespace="theEPI"
							data-module="EPI"
							data-before-method="checkData"
							data-loader="wpeo-table"
							data-action="save_epi"
							data-nonce="<?php echo esc_attr( wp_create_nonce( 'save_epi' ) ); ?>"
							data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
							class="wpeo-button button-green button-progress button-square-50 action-input edit"><span class="button-icon fas fa-save"></span></div>

		</div>
	</td>
</tr>
