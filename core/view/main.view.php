<?php
/**
 * La vue principale de la page "EPI"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.0.0.1
 * @version 0.0.0.1
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
				<th><?php _e( 'ID', 'digirisk' ); ?></th>
				<th><?php _e( 'Nom', 'digirisk' ); ?></th>
				<th><?php _e('N° serie', 'digirisk' ); ?></th>
				<th><?php _e('Périod. de contrôle', 'digirisk'); ?></th>
				<th><?php _e('Date de dernier contrôle', 'digirisk'); ?></th>
				<th><?php _e('Reste', 'digirisk'); ?></th>
				<th class="w50"></th>
			</tr>
		</thead>

		<tbody>
			<?php EPI_Class::g()->display_epi_list(); ?>
		</tbody>

		<tfooter>
			<?php View_Util::exec( 'epi', 'item-edit', array( 'epi' => $epi_schema ) ); ?>
		</tfooter>
	</table>
</div>
