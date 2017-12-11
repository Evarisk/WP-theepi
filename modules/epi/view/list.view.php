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

<?php
if ( ! empty( $epi_list ) ) :
	foreach ( $epi_list as $epi ) :
		\eoxia\View_Util::exec( 'theepi', 'epi', 'item', array(
			'epi' => $epi,
		) );
	endforeach;
endif;
