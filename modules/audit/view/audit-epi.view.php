<?php
/**
 * le mode édition qui permet de modifier la tache
 *
 * @author Nicolas Domenech <dev@eoxia.com>
 * @since 0.5.0
 * @version 0.5.0
 * @copyright 2019 Eoxia
 * @package theepi
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="tm-audit tm_audit_item_<?php echo esc_html( $audit->data[ 'id' ] ); ?>" data-id="<?= $audit->data[ 'id' ] ?>">

<?php if( ! empty( $audit->data[ 'info' ] ) ): ?>
	<div class="audit-progress">
		<div class="progress-bar" style="width:<?= $audit->data[ 'info' ][ 'percent_uncompleted_points' ] . '%' ?>; background-color :<?=  $audit->data[ 'info' ][ 'color' ] ?>;"></div>
		<span class="progress-text"><?= ( $audit->data[ 'info' ][ 'percent_uncompleted_points' ] > 5 ) ? $audit->data[ 'info' ][ 'count_completed_points' ] . ' /' . ( $audit->data[ 'info' ][ 'count_uncompleted_points' ] + $audit->data[ 'info' ][ 'count_completed_points' ] . ' (' . $audit->data[ 'info' ][ 'percent_uncompleted_points' ] . '%) ' ) : '' ?></span>
	</div>
<?php endif; ?>


	<div class="audit-container">
		<div class="audit-header">
			<ul class="audit-summary" style="display: flex">
				<li>
				<span class="button-display-audit action-attribute"
					data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
					data-action="display_all_audits"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_all_audits' ) ); ?>">
					<i class="fas fa-chevron-right"></i>
				</span>
				</li>
				<li class="audit-summary-id" style="color: grey; margin-right: 15px"><i class="fas fa-hashtag"></i> <?= $audit->data[ 'id' ] ?></li>
				<li class="audit-summary-author-id" style="color: grey"><i class="fas fa-user"></i> <?php echo esc_attr( $user->data->display_name ); ?>
				</li>
			</ul>

			<div class="audit-title "
				data-id="<?php echo esc_attr( $audit->data[ 'id' ] ); ?>"
				style="font-size: 24px;">
				<?= ! empty( $audit->data[ 'title' ] ) ? $audit->data[ 'title' ] : esc_html_e( 'No name Audit', 'task-manager' );  ?>
			</div>
			<div class="button-modal-footer">

			<div class="wpeo-modal-event wpeo-button button-main button-square-40 action-attribute"
				data-epi-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
				data-audit-id="<?php echo esc_attr( $audit->data['id'] ); ?>"
				data-action="display_control_epi"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_control_epi' ) ); ?>"> <i class="far fa-eye"></i>
			</div>

			<div class="wpeo-button button-main button-square-40 action-attribute"
				data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
				data-action="export_epi_odt"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'export_epi_odt' ) ); ?>"> <i class="fas fa-download"></i>
			</div>

		</div>
		</div>
	</div>
</div>

<style>

.button-modal-footer {

	float : right;
	position : relative;
	bottom: 50px;
	right: 50px;
}

</style>
