<?php
/**
 * le mode édition qui permet de modifier la tache.
 *
 * @package   theepi
 * @author    Nicolas Domenech <dev@eoxia.com>
 * @copyright 2019 Eoxia
 * @since     0.5.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="tm-audit tm_audit_item_<?php echo esc_html( $audit->data['id'] ); ?>" data-id="<?php echo $audit->data['id']; ?>">
	<div class="audit-container">
		<div class="audit-header">
			<ul class="audit-summary" style="display: flex">
				<?php if( $audit->data["status_audit"] == 'OK' ): ?>
				<div class="audit-content" style="display: flex; background-color: white; padding: 8px; border-bottom: 3px solid mediumspringgreen; border-left: 3px solid mediumspringgreen">
				<?php else: ?>
				<div class="audit-content" style="display: flex; background-color: white; padding: 8px; border-bottom: 3px solid red; border-left: 3px solid red">
				<?php endif ?>
					<li class="audit-summary-author-id">
						<?php echo do_shortcode( '[task_avatar ids="' . $audit->data['author_id'] . '" size="40"]' ); ?>
					</li>

					<li>
						<i class="fas fa-calendar-alt" style="color: grey; font-weight: bold;"></i>
					</li>

					<li class="audit-summary-date" style="color: grey; font-weight: bold;">
						<?php echo date( 'd/m/Y', strtotime( $audit->data['date']['rendered']['mysql'] ) ); ?></span>
					</li>

					<?php if ( ( user_can( get_current_user_id(), 'manage_theepi' ) ) || ( user_can( get_current_user_id(), 'update_theepi' ) ) ): ?>
						<li class="wpeo-modal-event wpeo-tooltip-event wpeo-button button-blue button-square-40 action-attribute" style="margin-right : 0px"
							aria-label="<?php esc_html_e( 'Edit PPE check', 'theepi' ); ?>"
							data-epi-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
							data-audit-id="<?php echo esc_attr( $audit->data['id'] ); ?>"
							data-action="display_control_epi"
							data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_control_epi' ) ); ?>"> <i class="fas fa-pencil-alt" style="color: white"></i>
						</li>
					<?php endif; ?>
				</div>
			</ul>
		</div>
	</div>
</div>

<!-- <?php if( $edit_audit ): ?>
	<a href="#" class="action-attribute epi-item-link-control"
	data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
	data-action="control_epi"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'control_epi' ) ); ?>">
	<?php esc_html_e( 'Perform a control', 'theepi' ); ?>
	</a>
<?php endif; ?> -->
