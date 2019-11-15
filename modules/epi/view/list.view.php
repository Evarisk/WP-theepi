<?php
/**
 * La vue pour lister les "EPI".
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com>
 * @copyright 2017 Evarisk
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
 * @var EPI_Model $new Un nouvel EPI.
 */


if ( ! empty( $epis ) ) :
	foreach ( $epis as $epi ) :
		View_Util::exec(
			'theepi',
			'epi',
			'item',
			array(
				'epi' => $epi,
				'new' => $new,
			)
		);
	endforeach;
endif;
