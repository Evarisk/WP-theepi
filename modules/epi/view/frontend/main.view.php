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

use eoxia\View_Util;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Documentation des variables utilisées dans la vue.
*
* @var EPI_Model $epi Les données d'un EPI.
*/
?>

<div class="">
	<div class="title" data-title="<?php echo esc_attr_e( 'Title', 'theepi' ); ?>">
		<span class=""><?php echo esc_html( $epi->data['title'] ); ?><span>
	</div>

	<div class="thumbnail">
		<?php echo do_shortcode( '[wpeo_upload id="' . $epi->data['id'] . '" model_name="/theepi/EPI_Class" single="false" field_name="image" ]' ); ?>
	</div>

	<div class="serial-number" data-title="<?php echo esc_attr_e( 'Serial Number', 'theepi' ); ?>">
		<span class=""><i class="fas fa-barcode"></i></span>
		<span class=""><?php echo esc_html_e( 'Serial Number :', 'theepi' ); ?></span>
		<span class=""><?php echo esc_html( $epi->data['serial_number'] ); ?><span>
	</div>

	<div class="last-control" data-title="<?php echo esc_attr_e( 'Last Control', 'theepi' ); ?>">
		<?php if ( ! empty( EPI_Class::g()->get_last_control_date( $epi ) ) ) : ?>
			<span class="epi-last-control-date">
				<i class="fas fa-calendar-alt"></i> <?php echo esc_attr( date( 'd/m/Y', strtotime( EPI_Class::g()->get_last_control_date( $epi ) ) ) ); ?>
			</span>
			<div class="wpeo-button wpeo-tooltip-event button-grey button-square-30 button-rounded action-attribute"
				aria-label="<?php esc_html_e( 'See All Control', 'theepi' ); ?>"
				data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
				data-frontend="fasle"
				data-action="display_control"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_control' ) ); ?>"
				data-type="see_control">
				<i class="fas fa-eye"></i>
			</div>
		<?php else : ?>
			<span class="epi-last-control-date">
				<?php esc_html_e( 'No Control Yet', 'theepi' ); ?>
			</span>
		<?php endif; ?>
	</div>

	<div class="next-control" data-title="<?php echo esc_attr_e( 'Next Control', 'theepi' ); ?>">
		<span class=""><?php echo esc_html_e( 'Next Control :', 'theepi' ); ?>
			<?php
			View_Util::exec(
				'theepi',
				'epi',
				'item-control',
				array(
					'epi'         => $epi,
					'number_days' => EPI_Class::g()->get_days( $epi ),
				)
			);
			?>
		<span>
	</div>

	<div class="status" data-title="<?php echo esc_attr_e( 'Status EPI', 'theepi' ); ?>">
		<span class=""><?php echo esc_html_e( 'PPE Status :', 'theepi' ); ?></span>
		<span class="epi-status-icon fas <?php echo esc_attr( EPI_Class::g()->get_status( $epi ) ); ?>"></span>
	</div>
</div>
