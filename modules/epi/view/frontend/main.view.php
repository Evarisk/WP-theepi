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

<div class="table-cell table-200" style="text-align : center;" data-title="<?php echo esc_attr_e( 'Status', 'theepi' ); ?>">
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

<div class="table-cell table-250" data-title="<?php echo esc_attr_e( 'Control', 'theepi' ); ?>">
	<?php if( $epi->data['commissioning_date_valid'] ): ?>
		<span class="form-label" name="control-date" value="<?php echo esc_attr( EPI_Class::g()->get_last_control_date( $epi ) ); ?>"><i class="fas fa-calendar-alt"></i> <?php echo esc_attr( date( 'd/m/Y' , strtotime( EPI_Class::g()->get_last_control_date( $epi ) ) ) ); ?></span>
	<?php else: ?>
		<span class="form-label" name="control-date" value=""><i class="fas fa-calendar-alt"></i> </span>
	<?php endif; ?>
	<div class="wpeo-button wpeo-tooltip-event button-grey button-square-50 button-rounded action-attribute"
		aria-label="<?php esc_html_e( 'Control', 'theepi' ); ?>"
		data-id="<?php echo esc_attr( $epi->data['id'] ) ?>"
		data-frontend="true"
		data-action="display_control"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_control' ) ); ?>"
		>
		<i class="fas fa-eye"></i>
	</div>
</div>
