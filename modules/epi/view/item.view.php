<?php
/**
 * La vue d'une ligne de la page "EPI".
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
	<div class="table-cell table-75 id" data-title="<?php echo esc_attr_e( 'ID', 'theepi' ); ?>">
		<i class="fas fa-hashtag"></i> <?php echo esc_attr( $epi->data['unique_identifier'] ); ?>
	</div>

	<div class="table-cell table-75 thumbnail">
		<?php echo do_shortcode( '[wpeo_upload id="' . $epi->data['id'] . '" model_name="/theepi/EPI_Class" single="false" field_name="image" mode="view" ]' ); ?>
	</div>

	<div class="table-cell table-75 quantity" data-title="<?php echo esc_attr_e( 'Quantity', 'theepi' ); ?>"><?php echo esc_html( $epi->data['quantity'] ); ?></div>

	<div class="table-cell table-75 code-qr" data-title="<?php echo esc_attr_e( 'Code QrCode', 'theepi' ); ?>">
		<div class="wpeo-button wpeo-tooltip-event button-grey button-square-30 button-size-small button-rounded qrcode action-attribute"
			aria-label="<?php esc_html_e( 'Click to enlarge the QrCode', 'theepi' ); ?>"
			data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
			data-action="open_qrcode"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'open_qrcode' ) ); ?>"
			data-url="<?php echo esc_attr( get_option( 'siteurl' ) . '/?p=' . $epi->data['id'] ) ?>">
			<i class="fas fa-qrcode"></i>
		</div>
		<?php do_shortcode( '[qrcode text="' . esc_attr( get_option( 'siteurl' ) . '/?p=' . $epi->data['id'] ) . '" id="'. $epi->data['id'] .'" height=500 width=500 transparency=1]' ); ?>
	</div>

	<div class="table-cell table-150 serial-number" data-title="<?php echo esc_attr_e( 'Serial Number', 'theepi' ); ?>"><?php echo esc_html( $epi->data['serial_number'] ); ?></div>

	<div class="table-cell title" data-title="<?php echo esc_attr_e( 'Title', 'theepi' ); ?>">
		<strong><?php echo esc_html( $epi->data['title'] ); ?></strong>
	</div>

	<div class="table-cell table-150 last-control" data-title="<?php echo esc_attr_e( 'Last Control', 'theepi' ); ?>">
		<span class="epi-last-control-date" name="control-date">
			<?php if ( EPI_Class::g()->get_last_control_date( $epi ) != "" ): ?>
				<i class="fas fa-calendar-alt"></i> <?php echo esc_attr( date( 'd/m/Y' , strtotime( EPI_Class::g()->get_last_control_date( $epi ) ) ) ); ?>
			<?php endif; ?>
		</span>
		<div class="wpeo-button wpeo-tooltip-event button-grey button-square-30 button-rounded action-attribute"
			aria-label="<?php esc_html_e( 'Control', 'theepi' ); ?>"
			data-id="<?php echo esc_attr( $epi->data['id'] ) ?>"
			data-frontend="fasle"
			data-action="display_control"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_control' ) ); ?>">
			<i class="fas fa-eye"></i>
		</div>
	</div>

	<div class="table-cell table-75 next-control" data-title="<?php echo esc_attr_e( 'Next Control', 'theepi' ) ?>">
		<?php
		\eoxia\View_Util::exec(
			'theepi', 'epi', 'item-control', array(
				'epi'         => $epi,
				'number_days' => EPI_Class::g()->get_days( $epi ),
			)
		);
		?>
	</div>

	<div class="table-cell table-75 status" data-title="<?php echo esc_attr_e( 'Status EPI', 'theepi' ); ?>">
		<span class="epi-status-icon fas <?php echo esc_attr( EPI_Class::g()->get_status( $epi ) ); ?>"></span>
	</div>

	<!-- <div class="table-cell table-75" data-title="<?php echo esc_attr_e( 'Status EPI', 'theepi' ); ?>">
		<?php if ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( EPI_Class::g()->get_status( $epi ) == "OK" ) ) : ?>
			<i class="fas fa-check-circle fa-4x" style="color: mediumspringgreen;"></i>
		<?php elseif ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( EPI_Class::g()->get_status( $epi ) == "repair" ) ) : ?>
			<i class="fas fa-tools fa-4x" style="color: orange;"></i>
		<?php elseif ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( EPI_Class::g()->get_status( $epi ) == "trash" ) ) : ?>
			<i class="fas fa-trash fa-4x" style="color: black;"></i>
		<?php else : ?>
			<i class="fas fa-exclamation-circle fa-4x" style="color: red;"></i>
		<?php endif; ?>
	</div> -->

	<div class="table-cell table-100 action-end table-end table-padding-0" data-title="<?php esc_attr_e( 'Actions', 'theepi' ); ?>">
		<?php if ( ( user_can( get_current_user_id(), 'manage_theepi' ) ) || ( user_can( get_current_user_id(), 'update_theepi' ) ) ): ?>
			<div class="wpeo-button wpeo-tooltip-event button-transparent button-square-50 action-request-edit-epi epi-item-link-edit"
				aria-label="<?php esc_html_e( 'Edit PPE', 'theepi' ); ?>"
				data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
				data-message = "<?php esc_html_e( 'Do you want to exit edit mode', 'theepi' ); ?>"
				data-action="edit_epi"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'edit_epi' ) ); ?>">
				<i class="fas fa-pencil-alt"></i>
			</div>
		<?php endif; ?>
		<div class="wpeo-dropdown dropdown-right dropdown-small">
			<div class="dropdown-toggle wpeo-button button-square-50 button-transparent"><i class="fas fa-ellipsis-v"></i></div>
			<ul class="dropdown-content">
				<?php if ( ( user_can( get_current_user_id(), 'manage_theepi' ) ) || ( user_can( get_current_user_id(), 'read_theepi' ) ) ): ?>
					<li class="dropdown-item wpeo-tooltip-event wpeo-button button-transparent action-attribute"
						data-direction="left"
						aria-label="<?php esc_html_e( 'Download PPE Life Sheet', 'theepi' ); ?>"
						data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
						data-action="export_epi_odt"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'export_epi_odt' ) ); ?>">

						<i class="fas fa-download"></i>
					</li>
				<?php endif; ?>
				<?php if ( ( user_can( get_current_user_id(), 'manage_theepi' ) ) || ( user_can( get_current_user_id(), 'delete_theepi' ) ) ): ?>
					<li class="dropdown-item wpeo-tooltip-event wpeo-button button-transparent action-delete"
						data-direction="left"
						aria-label="<?php esc_html_e( 'Delete PPE', 'theepi' ); ?>"
						data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
						data-action="delete_epi"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_epi' ) ); ?>"
						data-message-delete="<?php echo esc_attr_e( 'Are you sure you want to remove this PPE ?', 'theepi' ); ?>"
						data-loader="wpeo-table">

						<i class="fas fa-trash-alt"></i>
					</li>
			<?php endif; ?>
			</ul>
		</div>
	</div>

</div>
