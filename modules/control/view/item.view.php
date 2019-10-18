<?php
/**
 * La vue principale pour le contrôle.
 *
 * @package   TheEPI
 * @author    Evarisk <dev@evarisk.com>
 * @copyright 2019 Evarisk
 * @since     0.7.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<div class="table-row epi-control-row view" data-id="<?php echo esc_attr( $control->data['id'] ); ?>">
	<div class="table-cell table-75" data-title="<?php echo esc_attr_e( 'ID', 'theepi' ); ?>">
		<i class="fas fa-hashtag"></i> <?php echo esc_attr( $control->data['id'] ); ?>
	</div>

	<div class="table-cell table-75" data-title="<?php echo esc_attr_e( 'Avatar', 'theepi' ); ?>">
		<?php echo do_shortcode( '[theepi_avatar ids="' . $control->data['author_id'] . '" size="50"]' ); ?>
	</div>

	<div class="table-cell table-125" data-title="<?php echo esc_attr_e( 'Date', 'theepi' ); ?>">
		<i class="fas fa-calendar-alt"></i> <?php echo esc_attr( $control->data['date']['rendered']['date'] ); ?>
	</div>

	<div class="table-cell" data-title="<?php echo esc_attr_e( 'Comment', 'theepi' ); ?>">
		<?php echo esc_attr( $control->data['comment'] ); ?>
	</div>

	<div class="table-cell table-200 wpeo-form control-link" data-title="<?php echo esc_attr_e( 'URL', 'theepi' ); ?>">
		<div class="form-element">
			<label class="form-field-container">
				<input type="text" class="form-field" readonly value="<?php echo esc_attr( $control->data['url'] ); ?>" />
				<span class="form-field-label-next">
					<a class="wpeo-button wpeo-tooltip-event button-grey button-square-40 <?php echo ( $control->data['url'] == "No url" ) ? 'button-disable' : ''; ?>"
						href="<?php echo esc_attr( $control->data['url'] ); ?>"
						target="_blank"
						aria-label="<?php esc_html_e( 'Display Url File', 'theepi' ); ?>">
						<i class="fas fa-copy"></i>
					</a>
				</span>
			</label>
		</div>

		<!-- <?php if ( esc_attr( $control->data['url'] ) != "No url" ): ?>
			<?php echo esc_attr( $control->data['url'] ); ?>
			<a class="wpeo-button wpeo-tooltip-event button-grey button-square-30 button-rounded"
				href="<?php echo esc_attr( $control->data['url'] ); ?>"
				target="_blank"
				aria-label="<?php esc_html_e( 'Display Url File', 'theepi' ); ?>">
				<i class="fas fa-copy"></i>
			</a>
		<?php else: ?>
			<?php echo esc_attr( $control->data['url'] ); ?>
		<?php endif; ?> -->
	</div>

	<div class="table-cell table-75" data-title="<?php echo esc_attr_e( 'Attached File', 'theepi' ); ?>">
		<?php echo Control_Class::g()->get_media( $control->data['id'] ) ?>
	</div>

	<div class="table-cell table-75" data-title="<?php echo esc_attr_e( 'Status', 'theepi' ); ?>">
		<span class="epi-status-icon fas <?php echo esc_attr( $control->data['status_control'] ); ?>"></span>
	</div>

	<div class="table-cell table-125 table-end action-end" data-title="<?php esc_attr_e( 'Actions', 'theepi' ); ?>">
		<?php if ( $frontend == false ): ?>
			<?php if ( user_can( get_current_user_id(), 'update_theepi' ) ): ?>
				<div class="wpeo-button wpeo-tooltip-event button-transparent button-square-50 action-input"
					aria-label="<?php esc_html_e( 'Edit Control', 'theepi' ); ?>"
					data-parent_id="<?php echo esc_attr( $control->data['parent_id'] ); ?>"
					data-id="<?php echo esc_attr( $control->data['id'] ); ?>"
					data-message = "<?php esc_html_e( 'Do you want to exit edit mode', 'theepi' ); ?>"
					data-action="edit_control_epi"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'edit_control_epi' ) ); ?>">
					<i class="fas fa-pencil-alt"></i>
				</div>
			<?php endif; ?>

			<?php if ( user_can( get_current_user_id(), 'delete_theepi' ) ): ?>
				<div class="dropdown-item wpeo-button wpeo-tooltip-event button-transparent button-square-50 action-delete"
					aria-label="<?php esc_html_e( 'Delete Control', 'theepi' ); ?>"
					data-id="<?php echo esc_attr( $control->data['id'] ); ?>"
					data-action="delete_control_epi"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_control_epi' ) ); ?>"
					data-message-delete="<?php echo esc_attr_e( 'Are you sure you want to remove this Control ?', 'theepi' ); ?>"
					data-loader="wpeo-table">
					<i class="fas fa-trash-alt"></i>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>
