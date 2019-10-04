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
	<div class="table-cell table-100" style="text-align: center;" data-title="<?php echo esc_attr_e( 'ID', 'theepi' ); ?>">
		<span style="color: grey;"><i class="fas fa-hashtag"></i> <?php echo esc_attr( $control->data['id'] ); ?></span></br>
	</div>

	<div class="table-cell table-100" data-title="<?php echo esc_attr_e( 'Avatar', 'theepi' ); ?>"> </br>
		<?php echo do_shortcode( '[theepi_avatar ids="' . $control->data['author_id'] . '" size="40"]' ); ?>
	</div>

	<div class="table-cell table-150" data-title="<?php echo esc_attr_e( 'Date', 'theepi' ); ?>">
		<i class="fas fa-calendar-alt"></i> <?php echo esc_attr( $control->data['date']['rendered']['date'] ); ?>
	</div>

	<div class="table-cell table-300" data-title="<?php echo esc_attr_e( 'Comment', 'theepi' ); ?>">
		<?php echo esc_attr( $control->data['comment'] ); ?>
	</div>

	<div class="table-cell table-300" data-title="<?php echo esc_attr_e( 'URL', 'theepi' ); ?>">
		<?php if ( esc_attr( $control->data['url'] ) != "No url" ): ?>
			<?php echo esc_attr( $control->data['url'] ); ?>
			<a class="wpeo-button wpeo-tooltip-event button-grey button-square-50 button-rounded"
				href="<?php echo esc_attr( $control->data['url'] ); ?>"
				target="_blank"
				aria-label="<?php esc_html_e( 'Display Url File', 'theepi' ); ?>">
				<i class="fas fa-copy"></i>
			</a>
		<?php else: ?>
			<?php echo esc_attr( $control->data['url'] ); ?>
		<?php endif; ?>
	</div>

	<div class="table-cell table-100" data-title="<?php echo esc_attr_e( 'Attached File', 'theepi' ); ?>"> </br>
		<?php echo Control_Class::g()->get_media( $control->data['id'] ) ?>
	</div>

	<div class="table-cell table-100" style="text-align : center" data-title="<?php esc_attr_e( 'Status', 'theepi' ); ?>">
		<?php if ( esc_attr( $control->data['status_control'] ) == 'OK' ):  ?>
			<div class="wpeo-button button-green button-square-50">
				<i class="fas fa-check"></i>
			</div>
		<?php elseif ( esc_attr( $control->data['status_control'] ) == 'KO' ): ?>
			<div class="wpeo-button button-red button-square-50">
				<i class="fas fa-exclamation"></i>
			</div>
		<?php elseif ( esc_attr( $control->data['status_control'] ) == 'repair' ): ?>
			<div class="wpeo-button button-square-50" style="background-color : orange; border-color : orange;">
				<i class="fas fa-tools"></i>
			</div>
		<?php elseif ( esc_attr( $control->data['status_control'] ) == 'trash' ): ?>
			<div class="wpeo-button button-square-50" style="background-color : black; border-color : black;">
				<i class="fas fa-trash-alt"></i>
			</div>
		<?php endif; ?>
	</div>


	<div class="table-cell table-end" style="text-align : center" data-title="<?php esc_attr_e( 'Actions', 'theepi' ); ?>">
		<?php if ( $frontend == false ): ?>
			<div class="wpeo-button wpeo-tooltip-event button-transparent button-square-50 action-input"
				aria-label="<?php esc_html_e( 'Edit Control', 'theepi' ); ?>"
				data-parent_id="<?php echo esc_attr( $control->data['parent_id'] ); ?>"
				data-id="<?php echo esc_attr( $control->data['id'] ); ?>"
				data-message = "<?php esc_html_e( 'Do you want to exit edit mode', 'theepi' ); ?>"
				data-action="edit_control_epi"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'edit_control_epi' ) ); ?>">
				<i class="fas fa-pencil-alt"></i>
			</div>

			<div class="dropdown-item wpeo-button wpeo-tooltip-event button-transparent button-square-50 action-delete"
				aria-label="<?php esc_html_e( 'Delete Control', 'theepi' ); ?>"
				data-id="<?php echo esc_attr( $control->data['id'] ); ?>"
				data-action="delete_control_epi"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_control_epi' ) ); ?>"
				data-message-delete="<?php echo esc_attr_e( 'Are you sure you want to remove this Control ?', 'theepi' ); ?>"
				data-loader="wpeo-table">
				<i class="fas fa-times"></i>
			</div>
		<?php endif; ?>
	</div>
</div>
