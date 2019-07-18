<?php
/**
 * La vue principale de la page "EPI"
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 0.1.0
 * @version 0.4.0
 * @copyright 2018 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="epi-row view <?php echo esc_attr( ( ! empty( $new ) && true === $new ) ? 'new' : '' ); ?>" data-id="<?php echo esc_attr( $epi->data['id'] ); ?>">
	<td class="w50">
		<?php echo do_shortcode( '[wpeo_upload id="' . $epi->data['id'] . '" model_name="/theepi/EPI_Class" single="false" field_name="image" ]' ); ?>
	</td>
	<td class="padding" data-title="<?php echo esc_attr_e( 'Control', 'theepi' ); ?>">
		<?php
		\eoxia\View_Util::exec( 'theepi', 'epi', 'item-control', array(
			'epi'            => $epi,
			'number_days' => EPI_Class::g()->get_days( $epi )
		) );
		 ?>

	</td>
	<td class="padding" data-title="<?php echo esc_attr_e( 'Title', 'theepi' ); ?>">
		<span style="color: grey"><i class="fas fa-hashtag"></i> <?php echo esc_attr( $epi->data['id'] ); ?></span></br>
		<span style="font-size: 25px"><?php echo esc_html( $epi->data['title'] ); ?></span>
		<?php
		\eoxia\View_Util::exec( 'theepi', 'epi', 'item-link', array(
			'epi'            => $epi
		) );
		 ?>

	</td>
	<td class="padding" data-title="<?php echo esc_attr_e( 'Reference', 'theepi' ); ?>"><?php echo esc_html( $epi->data['reference'] ); ?></td>
	<td class="padding" data-title="<?php echo esc_attr_e( 'Periodicity', 'theepi' ); ?>"><?php echo esc_html( $epi->data['periodicity'] ); echo esc_html( ' jours', 'theepi' ); ?></td>
	<td  class="control_audit" data-title="<?php echo esc_attr_e( 'Last Control', 'theepi' ); ?>">
		<?php  EPI_Class::g()->display_audit_epi( $epi->data['id'] ); ?>
	</td>
	<td data-title="<?php echo esc_attr_e( 'Status', 'theepi' ); ?>">
		<?php if ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( Audit_Class::g()->get_status( $epi ) ) ) : ?>
		<i class="fas fa-check-circle fa-3x" style="color: mediumspringgreen;"></i>
	<?php else : ?>
		<i class="fas fa-exclamation-circle fa-3x" style="color: red;"></i>
	<?php endif; ?>
	</td>
</tr>
