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

<div class="post-epi">
	<ul class="epi-list-data">
		<li class="epi-data-item status">
			<span class="data-label"><?php echo esc_html_e( 'PPE Status :', 'theepi' ); ?></span>
			<span class="data-value"><span class="epi-status-icon fas <?php echo esc_attr( EPI_Class::g()->get_status( $epi ) ); ?>"></span></span>
		</li>
		<?php if ( ! empty( $epi->data['serial_number'] ) ) : ?>
			<li class="epi-data-item serial-number">
				<span class="data-label"><?php echo esc_html_e( 'Serial Number', 'theepi' ); ?> :</span>
				<span class="data-value"><?php echo esc_html( $epi->data['serial_number'] ); ?></span>
			</li>
		<?php endif; ?>
		<li class="epi-data-item last-control">
			<span class="data-label"><?php echo esc_html_e( 'Last Control', 'theepi' ); ?> :</span>
			<span class="data-value">
					<?php if ( ! empty( EPI_Class::g()->get_last_control_date( $epi ) ) ) : ?>
						<span class="epi-last-control-date"><i class="fas fa-calendar-alt"></i> <?php echo esc_attr( date( 'd/m/Y', strtotime( EPI_Class::g()->get_last_control_date( $epi ) ) ) ); ?></span>
						<div class="wpeo-button wpeo-tooltip-event button-grey button-square-30 button-rounded action-attribute"
							aria-label="<?php esc_html_e( 'See All Control', 'theepi' ); ?>"
							data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
							data-frontend="true"
							data-action="display_control"
							data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_control' ) ); ?>">
							<i class="fas fa-eye"></i>
						</div>
					<?php else : ?>
						<span class="epi-last-control-date"><?php esc_html_e( 'No Control Yet', 'theepi' ); ?></span>
					<?php endif; ?>
				</span>
		</li>
		<li class="epi-data-item next-control">
			<span class="data-label"><?php echo esc_attr_e( 'Next Control', 'theepi' ); ?> :</span>
			<span class="data-value">
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
				</span>
		</li>
	</ul>
</div><!-- .post-epi -->
