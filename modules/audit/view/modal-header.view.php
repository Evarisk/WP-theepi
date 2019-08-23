<?php
/**
 * La vue déclarant le modal audit.
 *
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @since     0.5.0
 * @version   0.5.0
 * @copyright 2019 Evarisk
 * @package   TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<span class="modal-header-title"><?php echo esc_attr( $audit->data['title'] ); ?></span>

<div class="wpeo-button button-main button-radius-2 button-square-40 action-attribute"
	data-parent-id="<?php echo esc_attr( $audit->data['id'] ); ?>"
	data-action="create_task_audit"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'create_task_audit' ) ); ?>">
	<span><i class="fas fa-plus "></i></span>
</div>

<div class="wpeo-button button-main button-radius-2 button-square-40 action-attribute"
	data-id="<?php echo esc_attr( $audit->data['id'] ); ?>"
	data-action="import_task_audit"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'import_task_audit' ) ); ?>">
	<span><i class="fas fa-download"></i></span>
</div>

<span class="button-toggle-modal-headear"
	data-id="<?php echo esc_attr( $audit->data['id'] ); ?>"
	data-action = "valid_statut_audit"
	data-nonce = "<?php echo esc_attr( wp_create_nonce( 'valid_statut_audit' ) ); ?>">
	<?php if ( $audit->data['status_audit'] == "OK" ) : // Audit_Class::g()->get_status( $epi ) ?>

		<span class="button-toggle-KO" style="color : grey; font-weight: auto"><?php esc_html_e( 'KO', 'theepi' ); ?></span>
		<span><i class="button-toggle fas fa-toggle-on"></i></span>
		<span class="button-toggle-OK" style="color : black; font-weight: bold"><?php esc_html_e( 'OK', 'theepi' ); ?></span>
	<?php else : ?>
		<span class="button-toggle-KO" style="color : black; font-weight: bold"><?php esc_html_e( 'KO', 'theepi' ); ?></span>
		<span><i class="button-toggle fas fa-toggle-off"></i></span>
		<span class="button-toggle-OK" style="color : grey; font-weight: auto"><?php esc_html_e( 'OK', 'theepi' ); ?></span>
	<?php endif; ?>
</span>

<style>

.button-toggle-modal-headear {

	position: relative;
	left: 300px;
	font-size: 20px;

}

.modal-header-title {
	font-size: uppercase;
	font-weight: bold;
	border: thick double black;
	padding: 3px;
}
</style>
