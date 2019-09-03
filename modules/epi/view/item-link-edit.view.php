<?php
/**
 * La vue des liens d'un item de la page Edition d'un EPI.
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.1.0
 * @version   0.6.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<span>
	<a href="#" class="epi-item-link-cancel action-attribute"
		data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
		data-action="cancel_edit_epi"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'cancel_edit_epi' ) ); ?>">
	  <?php esc_html_e( 'Cancel', 'theepi' ); ?>
	</a>

	 |

	<a href="#" class="epi-item-link-save edit button-save-epi"
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
