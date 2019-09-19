<?php
/**
 * La vue principale de la page "EPI".
 *
 * @package   TheEPI
 * @author    Evarisk <dev@evarisk.com>
 * @copyright 2019 Evarisk
 * @since     0.1.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="table-row epi-row view <?php echo esc_attr( ( ! empty( $new ) && true === $new ) ? 'new' : '' ); ?>" data-id="<?php echo esc_attr( $epi->data['id'] ); ?>">
	<div class="table-cell table-100" style="text-align: center;" data-title="<?php echo esc_attr_e( 'ID', 'theepi' ); ?>">
		<span style="color: grey;"><i class="fas fa-hashtag"></i> <?php echo esc_attr( $epi->data['id'] ); ?></span></br>
	</div>

	<div class="table-cell table-100" style="text-align : center;">
		<?php echo do_shortcode( '[wpeo_upload id="' . $epi->data['id'] . '" model_name="/theepi/EPI_Class" single="false" field_name="image" ]' ); ?>
		<style>
		.media {
			width: 80px;
			height: 80px;
		}
		.default-icon-container {
			height: 80px;
		}
		.default-image{
			margin-top: 25px;
			font-size: 25px;
		}
		</style>
	</div>

	<div class="table-cell table-250" data-title="<?php echo esc_attr_e( 'Title', 'theepi' ); ?>">
		<span style="font-size: 25px"><?php echo esc_html( $epi->data['title'] ); ?></span>
	</div>

	<div class="table-cell table-200" style="text-align : center" data-title="<?php echo esc_attr_e( 'Serial Number', 'theepi' ); ?>"><?php echo esc_html( $epi->data['serial_number'] ); ?></div>

	<div class="table-cell table-150" data-title="<?php echo esc_attr_e( 'Next Control', 'theepi' ); ?>">
		<?php
		\eoxia\View_Util::exec(
			'theepi', 'epi', 'item-control', array(
				'epi'         => $epi,
				'number_days' => EPI_Class::g()->get_days( $epi ),
			)
		);
		?>
	</div>

	<div class="table-cell table-50 display_all_audit" style="color: grey; text-align: right; margin-top: 10px">
		<?php if ( $task_manager ): ?>
			<?php if ( Audit_Class::g()->get_numbers_audits( $epi->data['id'] ) != 0 ): ?>
				<span style="font-size: 20px; font-weight: bold;"> <?php echo ( Audit_Class::g()->get_numbers_audits( $epi->data['id'] ) ); ?> </span></br>
				<span class="button-display-audit action-attribute"
					data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
					data-action="display_all_audits"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_all_audits' ) ); ?>">
					<i class="icon fas fa-chevron-right "></i>
				</span>
			<?php endif; ?>
		<?php endif; ?>
	</div>

	<div class="table-cell table-250 control_audit" style="text-align: center" data-title="<?php echo esc_attr_e( 'Control', 'theepi' ); ?>">
		<?php if ( $task_manager ): ?>
			<?php if ( ! EPI_Class::g()->display_audit_epi( $epi->data['id'], false ) ): ?>
				<span style="color: grey; font-style: italic"> <?php esc_html_e( 'No Control Yet', 'theepi' ); ?> </span>
			<?php endif; ?>
		<?php else: ?>
			<?php do_shortcode( '[theepi_comment id="' . $epi->data['id'] . '" namespace="theepi" type="EPI_Comment" display="edit"]' ); ?>
		<?php endif; ?>
	</div>

	<div class="table-cell table-100">
		<?php if ( $task_manager ): ?>
			<?php if ( ( user_can( get_current_user_id(), 'manage_theepi' ) ) || ( user_can( get_current_user_id(), 'create_theepi' ) ) ): ?>
				<div class="wpeo-button wpeo-tooltip-event button-blue button-square-50  action-attribute epi-item-link-control"
					aria-label="<?php esc_html_e( 'Perform a PPE Check', 'theepi' ); ?>"
					data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
					data-action="control_epi"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'control_epi' ) ); ?>">
					<i class="fas fa-plus"></i>
				</div>
			<?php endif; ?>
		<?php else: ?>
			<?php if ( ( user_can( get_current_user_id(), 'manage_theepi' ) ) || ( user_can( get_current_user_id(), 'create_theepi' ) ) ): ?>
				<div class="wpeo-button wpeo-tooltip-event button-blue button-square-50 action-attribute epi-item-link-control"
					aria-label="<?php esc_html_e( 'Perform PPE Check', 'theepi' ); ?>"
					data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
					data-action="control_epi_without_task_manager"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'control_epi_without_task_manager' ) ); ?>">
					<i class="fas fa-plus"></i>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>


	<div class="table-cell table-150" style="text-align : center;" data-title="<?php echo esc_attr_e( 'Status EPI', 'theepi' ); ?>">
		<?php if ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( Audit_Class::g()->get_status( $epi ) == "OK" ) ) : ?>
			<i class="fas fa-check-circle fa-4x" style="color: mediumspringgreen;"></i>
		<?php elseif ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( Audit_Class::g()->get_status( $epi ) == "rebut" ) ) : ?>
			<i class="fas fa-trash fa-4x" style="color: black;"></i>
		<?php else : ?>
			<i class="fas fa-exclamation-circle fa-4x" style="color: red;"></i>
		<?php endif; ?>
	</div>

	<div class="table-cell table-150" style="text-align : center" data-title="<?php echo esc_attr_e( 'QrCode', 'theepi' ); ?>">
		<span class="wpeo-tooltip-event qrcode action-attribute"
			aria-label="<?php esc_html_e( 'Click to enlarge the QrCode', 'theepi' ); ?>"
			data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
			data-action="open_qrcode"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'open_qrcode' ) ); ?>"
			data-url="<?php echo esc_attr( $epi->data['link'] ) ?>">
			<?php  echo do_shortcode( '[qrcode id="'. $epi->data['id'] .'" text="' . $epi->data['link']  . '" eclevel=0  height=80 width=80 transparency=1]' ); ?>
		</span>
	</div>

	<div class="table-cell table-150" style="text-align : center" data-title="<?php esc_attr_e( 'Life Sheet', 'theepi' ); ?>">
		<?php if ( ( user_can( get_current_user_id(), 'manage_theepi' ) ) || ( user_can( get_current_user_id(), 'read_theepi' ) ) ): ?>
			<div class="wpeo-button wpeo-tooltip-event button-blue button-square-50 action-attribute"
				aria-label="<?php esc_html_e( 'Download PPE Life Sheet', 'theepi' ); ?>"
				data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
				data-action="export_epi_odt"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'export_epi_odt' ) ); ?>"> <i class="fas fa-download"></i>
			</div>
		<?php endif; ?>
	</div>

	<div class="table-cell table-end">
		<?php if ( ( user_can( get_current_user_id(), 'manage_theepi' ) ) || ( user_can( get_current_user_id(), 'update_theepi' ) ) ): ?>
			<div class="wpeo-button wpeo-tooltip-event button-blue button-square-50 action-request-edit-epi epi-item-link-edit"
				aria-label="<?php esc_html_e( 'Edit PPE', 'theepi' ); ?>"
				data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
				data-message = "<?php esc_html_e( 'Do you want to exit edit mode', 'theepi' ); ?>"
				data-action="edit_epi"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'edit_epi' ) ); ?>">
				<i class="fas fa-pencil-alt"></i>
			</div>
		<?php endif; ?>

		<?php if ( ( user_can( get_current_user_id(), 'manage_theepi' ) ) || ( user_can( get_current_user_id(), 'delete_theepi' ) ) ): ?>
			<div class="wpeo-button wpeo-tooltip-event button-grey button-square-50 action-delete epi-item-link-delete"
				aria-label="<?php esc_html_e( 'Delete PPE', 'theepi' ); ?>"
				data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
				data-action="delete_epi"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_epi' ) ); ?>"
				data-message-delete="<?php echo esc_attr_e( 'Are you sure you want to remove this PPE ?', 'theepi' ); ?>"
				data-loader="wpeo-table">
				<i class="fas fa-times"></i>
		  </div>
		<?php endif; ?>
	</div>

</div>
