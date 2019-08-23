<?php
/**
 * La vue principale de la page "EPI"
 *
 * @package   TheEPI
 * @author    Evarisk <dev@evarisk.com>
 * @copyright 2018 Evarisk
 * @since     0.1.0
 * @version   0.4.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="table-row epi-row view <?php echo esc_attr( ( ! empty( $new ) && true === $new ) ? 'new' : '' ); ?>" data-id="<?php echo esc_attr( $epi->data['id'] ); ?>">
	<div class="table-cell table-100">
		<?php echo do_shortcode( '[wpeo_upload id="' . $epi->data['id'] . '" model_name="/theepi/EPI_Class" single="false" field_name="image" ]' ); ?>
	</div>

	<div class="table-cell table-150 table-padding-0" data-title="<?php echo esc_attr_e( 'Control', 'theepi' ); ?>">
		<?php
			\eoxia\View_Util::exec(
				'theepi', 'epi', 'item-control', array(
					'epi'         => $epi,
					'number_days' => EPI_Class::g()->get_days( $epi ),
				)
			);
		?>
	</div>

	<div class="table-cell table-300" data-title="<?php echo esc_attr_e( 'Title', 'theepi' ); ?>">
		<span style="color: grey"><i class="fas fa-hashtag"></i> <?php echo esc_attr( $epi->data['id'] ); ?></span></br>
		<span style="font-size: 25px"><?php echo esc_html( $epi->data['title'] ); ?></span>
		<?php
			\eoxia\View_Util::exec(
				'theepi', 'epi', 'item-link', array(
					'epi' => $epi,
				)
			);
		?>
	</div>

	<div class="table-cell table-200" style="text-align : center" data-title="<?php echo esc_attr_e( 'Serial Number', 'theepi' ); ?>"><?php echo esc_html( $epi->data['serial_number'] ); ?></div>

	<div class="table-cell table-250" style="text-align : center" data-title="<?php echo esc_attr_e( 'Commissioning Date', 'theepi' ); ?>"><?php echo esc_html( $epi->data['commissioning_date']['rendered']['date'] ); ?></div>

	<div  class="table-cell control_audit" data-title="<?php echo esc_attr_e( 'Control', 'theepi' ); ?>">
		<?php EPI_Class::g()->display_audit_epi( $epi->data['id'] ); ?>
	</div>

	<div class="table-cell" style="text-align : center" data-title="<?php echo esc_attr_e( 'Status', 'theepi' ); ?>">
		<?php if ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( Audit_Class::g()->get_status( $epi ) == "OK" ) ) : ?>
			<i class="fas fa-check-circle fa-3x" style="color: mediumspringgreen;"></i>
		<?php elseif ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( Audit_Class::g()->get_status( $epi ) == "rebut" ) ) : ?>
			<i class="fas fa-trash fa-3x" style="color: blue;"></i>
		<?php else : ?>
			<i class="fas fa-exclamation-circle fa-3x" style="color: red;"></i>
		<?php endif; ?>
	</div>

	<div class="table-cell table-end" style="text-align : center" data-title="<?php esc_attr_e( 'Life Sheet', 'theepi' ); ?>">
		<div class="wpeo-button button-main button-square-40 action-attribute"
			data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
			data-action="export_epi_odt"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'export_epi_odt' ) ); ?>"> <i class="fas fa-download"></i>
		</div>
	</div>

</div>
