<?php
/**
 * La vue des liens d'un item de la page "EPI"
 *
 * @author Nicolas Domenech <nicolas@eoxia.com>
 * @since 0.1.0
 * @version 0.5.0
 * @copyright 2019 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
</br>
<span>
	<a href="#" class="epi-item-link-cancel action-attribute"
		data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
		data-action="cancel_edit_epi"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'cancel_edit_epi' ) ); ?>">
		<?php esc_html_e( 'Cancel', 'theepi' ); ?>
	</a>

	 |

	<a href="#" class="epi-item-link-save action-input"
				data-parent="epi-row"
				data-namespace="theEPI"
				data-module="EPI"
				data-before-method="checkData"
				data-loader="wpeo-table"
				data-action="save_epi"
				data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'save_epi' ) ); ?>">
		<?php esc_html_e( 'Save', 'theepi' ); ?>

	</a>

</span>

<style>

.epi-item-link-cancel, .epi-item-link-save {
	text-decoration: none;
}

.epi-item-link-cancel{
	color: gray;
}

.epi-item-link-save{
	color: mediumspringgreen;
}

</style>
