<?php
/**
 * le mode édition qui permet de modifier la tache
 *
 * @author    Nicolas Domenech <dev@eoxia.com>
 * @since     0.5.0
 * @version   0.5.0
 * @copyright 2019 Eoxia
 * @package   theepi
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="tm-audit tm_audit_item_<?php echo esc_html( $audit->data['id'] ); ?>" data-id="<?php echo $audit->data['id']; ?>">
	<div class="audit-container">
		<div class="audit-header">
			<ul class="audit-summary" style="display: flex">
				<li>
					<span class="button-display-audit action-attribute"
						data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
						data-action="display_all_audits"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_all_audits' ) ); ?>">
						<i class="icon fas fa-chevron-right "></i>
					</span>
				</li>

				<li class="wpeo-modal-event wpeo-button button-main button-square-40 action-attribute"
					data-epi-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
					data-audit-id="<?php echo esc_attr( $audit->data['id'] ); ?>"
					data-action="display_control_epi"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_control_epi' ) ); ?>"> <i class="fas fa-tasks" style="color: white"></i>
				</li>

				<li>
					<i class="fas fa-calendar-alt" style="color: grey; font-weight: bold;"></i>
				</li>

				<li class="audit-summary-date" style="color: grey; font-weight: bold;">
					<?php echo date( 'd/m/Y', strtotime($audit->data['date']['rendered']['mysql'] ) ); ?></span>
				</li>

				<li class="audit-summary-author-id">
					<?php echo do_shortcode( '[task_avatar ids="' .  $audit->data['author_id'] . '" size="40"]' ); ?>
				</li>

				<li class="wpeo-modal-event wpeo-button button-main button-square-40 action-attribute"
					data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
					data-action="control_epi"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'control_epi' ) ); ?>"> <i class="fas fa-plus" style="color: white"></i>
				</li>
			</ul>
		</div>
	</div>
</div>
