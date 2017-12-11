<?php
/**
 * La vue principale de la page "EPI"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 0.2.0
 * @copyright 2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="digirisk-wrap digirisk-epi">

	<h1><?php esc_html_e( 'TheEPI', 'theepi' ); ?></h1>
	<a href="#" class="create-mass-epi"><?php esc_html_e( 'Create mass from image', 'theepi' ); ?></a>

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
			<?php EPI_Class::g()->display_epi_list(); ?>
		</tbody>

		<tfoot>
			<?php \eoxia\View_Util::exec( 'theepi', 'epi', 'item-edit', array( 'epi' => $epi_schema ) ); ?>
		</tfoot>
	</table>
</div>
