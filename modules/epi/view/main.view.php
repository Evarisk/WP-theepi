<?php
/**
 * La vue déclarant le tableau HTML des EPI.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.2.0
 * @version 0.4.0
 * @copyright 2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<table class="wpeo-table epi">
	<thead>
		<tr>
			<th class="w50 padding" data-title="<?php esc_attr_e( 'Image', 'theepi' ); ?>"><span><?php esc_html_e( 'Image', 'theepi' ); ?></span></th>
			<th class="wm130 padding" data-title="<?php esc_attr_e( 'Control', 'theepi' ); ?>"><span><?php esc_html_e( 'Control', 'theepi' ); ?></span></th>
			<th class="padding" data-title="<?php esc_attr_e( 'Title', 'theepi' ); ?>"><span><?php esc_html_e( 'Title', 'theepi' ); ?></span></th>
			<th class="padding w50" data-title="<?php esc_attr_e( 'Reference', 'theepi' ); ?>"><i class="fas fa-barcode"></i> <?php esc_html_e( 'Reference', 'theepi' ); ?></span></th>
			<th class="padding" data-title="<?php esc_attr_e( 'Periodicity', 'theepi' ); ?>"><span><?php esc_html_e( 'Periodicity', 'theepi' ); ?></span></th>
			<th class="padding" data-title="<?php esc_attr_e( 'Last Control', 'theepi' ); ?>"><span><?php esc_html_e( 'Last Control', 'theepi' ); ?></span></th>
			<th class="padding" data-title="<?php esc_attr_e( 'Status', 'theepi' ); ?>"><span><?php esc_html_e( 'Status', 'theepi' ); ?></span></th>
		</tr>
	</thead>

	<tbody>
		<?php EPI_Class::g()->display_epi_list( $epis, false ); ?>
	</tbody>
</table>

<div 	class="wpeo-button button-main action-attribute button-size-large epi-load-more <?php echo esc_attr( ( ( $offset + $per_page ) >= $count_epi ) ? 'button-disable' : '' ); ?>"
			data-action="load_more_epi"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_more_epi' ) ); ?>"
			data-offset="<?php echo esc_attr( $offset + $per_page ); ?>"
			data-term="">
	<span>
		<span><?php esc_html_e( 'Load more', 'theepi' ); ?></span>
		&nbsp;
		(<span class="number-epi"><?php echo esc_attr( $offset + $per_page ); ?></span>/<span class="total-number-epi"><?php echo esc_attr( $count_epi ); ?></span>)
	</span>
</div>

<div class="wpeo-button button-light scroll-top"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i></div>
