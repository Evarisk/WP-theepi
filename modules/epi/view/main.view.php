<?php
/**
 * La vue déclarant le tableau HTML des EPI.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.2.0
 * @version 0.2.0
 * @copyright 2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<table class="table epi">
	<thead>
		<tr>
			<th class="w50"></th>
			<th class="w50 padding"><span><?php esc_html_e( 'ID', 'theepi' ); ?></span></th>
			<th class="wm130 padding"><span><?php esc_html_e( 'Name', 'theepi' ); ?></span></th>
			<th class="padding"><span><?php esc_html_e( 'Serial number', 'theepi' ); ?></span></th>
			<th class="padding"><span><?php esc_html_e( 'Period of control', 'theepi' ); ?></span></th>
			<th class="w50"></th>
			<th class="padding"><span><?php esc_html_e( 'Date of last check', 'theepi' ); ?></span></th>
			<th class="padding"><span><?php esc_html_e( 'State', 'theepi' ); ?></span></th>
			<th class="padding"><span><?php esc_html_e( 'Remaining time', 'theepi' ); ?></span></th>
			<th class="w50"></th>
		</tr>
	</thead>

	<tbody>
		<?php EPI_Class::g()->display_epi_list( $current_page ); ?>
	</tbody>

	<tfoot>
		<?php \eoxia\View_Util::exec( 'theepi', 'epi', 'item-edit', array( 'epi' => $epi_schema ) ); ?>
	</tfoot>
</table>

<!-- Pagination -->
<?php if ( ! empty( $current_page ) && ! empty( $number_page ) ) : ?>
	<div class="wp-digi-pagination">
		<?php
		echo paginate_links( array(
			'base'               => admin_url( 'admin-ajax.php?action=theepi-setting&current_page=%_%' ),
			'format'             => '%#%',
			'current'            => $current_page,
			'total'              => $number_page,
			'before_page_number' => '<span class="screen-reader-text">' . __( 'Page', 'theepi' ) . ' </span>',
			'type'               => 'plain',
			'next_text'          => '<i class="dashicons dashicons-arrow-right"></i>',
			'prev_text'          => '<i class="dashicons dashicons-arrow-left"></i>',
		) );
		?>
	</div>
<?php endif; ?>
