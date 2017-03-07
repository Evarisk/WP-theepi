<?php
/**
 * La vue principale de la page "EPI"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0.0.0
 * @version 1.0.0.0
 * @copyright 2017 Evarisk
 * @package epi
 * @subpackage view
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="digirisk-wrap">

	<table class="table epi">
		<thead>
			<tr>
				<th class="w50"></th>
				<th class="w50 padding"><span><?php esc_html_e( 'ID', 'digirisk' ); ?></span></th>
				<th class="wm130 padding"><span><?php esc_html_e( 'Nom', 'digirisk' ); ?></span></th>
				<th class="padding"><span><?php esc_html_e( 'N° serie', 'digirisk' ); ?></span></th>
				<th class="padding"><span><?php esc_html_e( 'Périod. de contrôle', 'digirisk' ); ?></span></th>
				<th class="w50"></th>
				<th class="padding"><span><?php esc_html_e( 'Date de dernier contrôle', 'digirisk' ); ?></span></th>
				<th class="padding"><span>État</span></th>
				<th class="padding"><span><?php esc_html_e( 'Reste', 'digirisk' ); ?></span></th>
				<th class="w50"></th>
			</tr>
		</thead>

		<tbody>
			<?php EPI_Class::g()->display_epi_list(); ?>
		</tbody>

		<tfoot>
			<?php View_Util::exec( 'epi', 'item-edit', array( 'epi' => $epi_schema ) ); ?>
		</tfoot>
	</table>
</div>
