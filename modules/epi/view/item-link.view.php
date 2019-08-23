<?php
/**
 * La vue des liens d'un item de la page "EPI"
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.1.0
 * @version   0.5.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

</br>

<span>
	<a href="#" class= "action-request-edit-epi epi-item-link-edit"
		data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
		data-message = "<?php esc_html_e( 'Do you want to exit edit mode', 'theepi' ); ?>"
		data-action="edit_epi"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'edit_epi' ) ); ?>">
		<?php esc_html_e( 'Edit', 'theepi' ); ?>
	</a>
	 |

	<a href="#" class="action-attribute epi-item-link-control"
		data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
		data-action="control_epi"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'control_epi' ) ); ?>">
	 <?php esc_html_e( 'Perform a control', 'theepi' ); ?>
	</a>
 |

	<a href="#" class="action-delete epi-item-link-delete"
		data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
		data-action="delete_epi"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_epi' ) ); ?>"
		data-message-delete="<?php echo esc_attr_e( 'Are you sure you want to remove this PPE ?', 'theepi' ); ?>"
		data-loader="wpeo-table">
	  <?php esc_html_e( 'Delete', 'theepi' ); ?>
	</a>
</span>

<style>

.epi-item-link-edit, .epi-item-link-control, .epi-item-link-delete {
	text-decoration: none;
}

.epi-item-link-delete {
	color : red;
}

</style>
