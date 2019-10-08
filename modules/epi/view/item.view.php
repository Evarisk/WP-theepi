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
	<div class="table-cell table-75" style="text-align: center;" data-title="<?php echo esc_attr_e( 'ID', 'theepi' ); ?>">
		<span style="color: grey;"><i class="fas fa-hashtag"></i> <?php echo esc_attr( $epi->data['id'] ); ?></span></br>
	</div>

	<div class="table-cell table-100" style="text-align : center;">
		<?php echo do_shortcode( '[wpeo_upload id="' . $epi->data['id'] . '" model_name="/theepi/EPI_Class" single="false" field_name="image" mode="view" ]' ); ?>
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

	<div class="table-cell table-75" style="text-align : center" data-title="<?php echo esc_attr_e( 'Quantity', 'theepi' ); ?>"><?php echo esc_html( $epi->data['quantity'] ); ?></div>

	<div class="table-cell table-200" style="text-align : center" data-title="<?php echo esc_attr_e( 'Serial Number', 'theepi' ); ?>"><?php echo esc_html( $epi->data['serial_number'] ); ?></div>

	<div class="table-cell table-75" style="text-align : center" data-title="<?php echo esc_attr_e( 'Code QrCode', 'theepi' ); ?>">
		<div class="wpeo-button wpeo-tooltip-event button-grey button-square-50 button-rounded qrcode action-attribute"
			aria-label="<?php esc_html_e( 'Click to enlarge the QrCode', 'theepi' ); ?>"
			data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
			data-action="open_qrcode"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'open_qrcode' ) ); ?>"
			data-url="<?php echo esc_attr( get_option( 'siteurl' ) . '/?p=' . $epi->data['id'] ) ?>">
			<i class="fas fa-qrcode"></i>
		</div>
	</div>

	<div class="table-cell" style="max-width: 375px;" data-title="<?php echo esc_attr_e( 'Title', 'theepi' ); ?>">
		<span style="font-size: 25px"><?php echo esc_html( $epi->data['title'] ); ?></span>
	</div>

	<div class="table-cell table-200" data-title="<?php echo esc_attr_e( 'Last Control', 'theepi' ); ?>">
		<?php if( $epi->data['commissioning_date_valid'] ): ?>
			<span class="form-label" name="control-date" value="<?php echo esc_attr( EPI_Class::g()->get_last_control_date( $epi ) ); ?>"><i class="fas fa-calendar-alt"></i> <?php echo esc_attr( date( 'd/m/Y' , strtotime( EPI_Class::g()->get_last_control_date( $epi ) ) ) ); ?></span>
		<?php else: ?>
			<span class="form-label" name="control-date" value=""><i class="fas fa-calendar-alt"></i> </span>
		<?php endif; ?>
		<div class="wpeo-button wpeo-tooltip-event button-grey button-square-50 button-rounded action-attribute"
			aria-label="<?php esc_html_e( 'Control', 'theepi' ); ?>"
			data-id="<?php echo esc_attr( $epi->data['id'] ) ?>"
			data-frontend="fasle"
			data-action="display_control"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_control' ) ); ?>">
			<i class="fas fa-eye"></i>
		</div>
	</div>

	<div class="table-cell table-150" data-title="<?php echo esc_attr_e( 'Next Control', 'theepi' ) ?>">
		<?php
		\eoxia\View_Util::exec(
			'theepi', 'epi', 'item-control', array(
				'epi'         => $epi,
				'number_days' => EPI_Class::g()->get_days( $epi ),
			)
		);
		?>
	</div>

	<div class="table-cell table-150" style="text-align : center;" data-title="<?php echo esc_attr_e( 'Status EPI', 'theepi' ); ?>">
		<?php if ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( EPI_Class::g()->get_status( $epi ) == "OK" ) ) : ?>
			<i class="fas fa-check-circle fa-4x" style="color: mediumspringgreen;"></i>
		<?php elseif ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( EPI_Class::g()->get_status( $epi ) == "repair" ) ) : ?>
			<i class="fas fa-tools fa-4x" style="color: orange;"></i>
		<?php elseif ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( EPI_Class::g()->get_status( $epi ) == "trash" ) ) : ?>
			<i class="fas fa-trash fa-4x" style="color: black;"></i>
		<?php else : ?>
			<i class="fas fa-exclamation-circle fa-4x" style="color: red;"></i>
		<?php endif; ?>
	</div>

	<div class="table-cell table-end" style="text-align : center" data-title="<?php esc_attr_e( 'Actions', 'theepi' ); ?>">
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
		<div class="wpeo-dropdown">
			<div class="dropdown-toggle wpeo-button button-transparent"><i class="fas fa-ellipsis-v"></i></div>
			<ul class="dropdown-content" style="width : auto;">
				<?php if ( ( user_can( get_current_user_id(), 'manage_theepi' ) ) || ( user_can( get_current_user_id(), 'read_theepi' ) ) ): ?>
					<li class="dropdown-item wpeo-button wpeo-tooltip-event button-transparent button-square-20 action-attribute"
						aria-label="<?php esc_html_e( 'Download PPE Life Sheet', 'theepi' ); ?>"
						data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
						data-action="export_epi_odt"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'export_epi_odt' ) ); ?>"> <i class="fas fa-download"></i>
					</li>
				<?php endif; ?>

				<?php if ( ( user_can( get_current_user_id(), 'manage_theepi' ) ) || ( user_can( get_current_user_id(), 'delete_theepi' ) ) ): ?>
					<li class="dropdown-item wpeo-button wpeo-tooltip-event button-transparent button-square-20 action-delete"
						aria-label="<?php esc_html_e( 'Delete PPE', 'theepi' ); ?>"
						data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
						data-action="delete_epi"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_epi' ) ); ?>"
						data-message-delete="<?php echo esc_attr_e( 'Are you sure you want to remove this PPE ?', 'theepi' ); ?>"
						data-loader="wpeo-table">
						<i class="fas fa-times"></i>
					</li>
			<?php endif; ?>
			</ul>
		</div>
	</div>

</div>
