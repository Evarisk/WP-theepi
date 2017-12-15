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
			<th class="w50"></th>
			<th class="w50 padding" data-title="<?php esc_attr_e( 'ID', 'theepi' ); ?>"><span><?php esc_html_e( 'ID', 'theepi' ); ?></span></th>
			<th class="wm130 padding" data-title="<?php esc_attr_e( 'Name', 'theepi' ); ?>"><span><?php esc_html_e( 'Name', 'theepi' ); ?></span></th>
			<th class="padding" data-title="<?php esc_attr_e( 'Serial number', 'theepi' ); ?>"><span><?php esc_html_e( 'Serial number', 'theepi' ); ?></span></th>
			<th class="padding" data-title="<?php esc_attr_e( 'Period of control', 'theepi' ); ?>"><span><?php esc_html_e( 'Period of control', 'theepi' ); ?></span></th>
			<th class="w50"></th>
			<th class="padding" data-title="<?php esc_attr_e( 'Date of last check and comment', 'theepi' ); ?>"><span><?php esc_html_e( 'Date of last check and comment', 'theepi' ); ?></span></th>
			<th class="padding" data-title="<?php esc_attr_e( 'State', 'theepi' ); ?>"><span><?php esc_html_e( 'State', 'theepi' ); ?></span></th>
			<th class="padding" data-title="<?php esc_attr_e( 'Remaining time', 'theepi' ); ?>"><span><?php esc_html_e( 'Remaining time', 'theepi' ); ?></span></th>
			<th class="wpeo-grid grid-2"></th>
		</tr>
	</thead>

	<tbody>
		<?php \eoxia\View_Util::exec( 'theepi', 'epi', 'item-edit', array( 'epi' => $epi_schema ) ); ?>
		<?php EPI_Class::g()->display_epi_list( $epis ); ?>
	</tbody>
</table>

<div 	class="wpeo-button button-progress button-main action-attribute button-size-large load-more <?php echo esc_attr( ( ( $offset + $per_page ) >= $count_epi ) ? 'button-disable' : '' ); ?>"
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
