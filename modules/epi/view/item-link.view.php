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
	<a href="#" class= "action-attribute epi-item-link-edit"
		data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
		data-action="edit_epi"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'edit_epi' ) ); ?>">
		<?php esc_html_e( 'Edit', 'theepi' ); ?>
	</a>
	 |

	<a href="#" class="wpeo-modal-event epi-item-link-control"
		data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
		data-action="control_epi"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'control_epi' ) ); ?>">
		<?php esc_html_e( 'Perform a control', 'theepi' ); ?>

	</a>
 |

	<a href="#" class="action-attribute epi-item-link-delete"
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
