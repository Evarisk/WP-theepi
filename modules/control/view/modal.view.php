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
		<div class="modal-container" style="width : 1600px; height: 800px; max-width: 1600px; max-height: 800px">

			<!-- Entête -->
			<div class="modal-header">
				<h2 class="modal-title"><span> <?php esc_html_e( 'Controls lists PPE', 'theepi' ); ?></span></h2>

				<ul style="display : flex">
					<li>
							<i class="fas fa-link" style="color : LightSlateGrey"></i>
					</li>

					<li>
						<span> #<?php echo esc_attr( $epi->data['id'] ); ?></span> </br>
						<span style="color : gray"> <i class="fas fa-plug" style="color : gray"></i> EPI </span>
					</li>

					<li>
						<span> <?php echo do_shortcode( '[wpeo_upload id="' . $epi->data['id'] . '" model_name="/theepi/EPI_Class" single="false" field_name="image" mode="view" ]' ); ?></span>
					</li>

					<li>
						<span style="color : rgb(0,132,255)"> <?php echo esc_attr( $epi->data['title'] ); ?></span> </br>
						<span style="color : gray"> <i class="fas fa-barcode"></i> <?php echo esc_attr( $epi->data['reference'] ); ?></span>
					</li>

					<li>
						<span>
							<?php if ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( EPI_Class::g()->get_status( $epi ) == "OK" ) ) : ?>
								<i class="fas fa-check-circle fa-4x" style="color: mediumspringgreen;"></i>
							<?php elseif ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( EPI_Class::g()->get_status( $epi ) == "repair" ) ) : ?>
								<i class="fas fa-tools fa-4x" style="color: orange;"></i>
							<?php elseif ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( EPI_Class::g()->get_status( $epi ) == "trash" ) ) : ?>
								<i class="fas fa-trash fa-4x" style="color: black;"></i>
							<?php else : ?>
								<i class="fas fa-exclamation-circle fa-4x" style="color: red;"></i>
							<?php endif; ?>
						</span>
					</li>
				</ul>

				<?php if ( $frontend == false ): ?>
			        <div class="wpeo-button button-blue button-radius-3 action-attribute" style="margin-left : 15px"
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
