<?php
/**
 * La vue principale déclarant le modal contrôle.
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.7.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

	<!-- Structure -->
	<div class="wpeo-modal modal-control-epi modal-active">
		<div class="modal-container">

			<!-- Entête -->
			<div class="modal-header">
				<h2 class="modal-title">
					<?php esc_html_e( 'Controls lists PPE', 'theepi' ); ?>
					<span> <?php echo esc_attr( $epi->data['unique_identifier'] ); ?></span>
					<span> <?php echo esc_attr( $epi->data['title'] ); ?></span>
				</h2>
				<?php if ( $frontend == false && ( user_can( get_current_user_id(), 'create_theepi' ) ) && $type == 'add_control' ): ?>
					<div class="wpeo-button button-blue button-radius-3 button-size-small action-attribute"
						data-message = "<?php esc_html_e( 'Do you want to exit edit mode', 'theepi' ); ?>"
						data-parent_id="<?php echo esc_attr( $epi->data['id'] ); ?>"
						data-action="edit_control_epi"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'edit_control_epi' ) ); ?>">
						<span><?php esc_html_e('New', 'theepi'); ?></span>
					</div>
				<?php endif; ?>
				<div class="modal-close"><i class="fas fa-times"></i></div>
			</div>

			<!-- Corps -->
			<div class="modal-content">
				<?php Control_Class::g()->display_modal_content( $epi, $frontend ); ?>
			</div>

			<!-- Footer -->
			<div class="modal-footer">
				<a class="wpeo-button button-grey button-uppercase modal-close"><span><?php esc_html_e( 'Close', 'theepi' ); ?></span></a>
			</div>
		</div>
	</div>
