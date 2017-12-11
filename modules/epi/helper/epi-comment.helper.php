<?php
/**
 * Helper EPI Comment model.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 0.2.0
 * @copyright 2015-2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Met à jour la date de contrôle et le status de l'EPI selon le dernier commentaire.
 *
 * @since 0.1.0
 * @version 0.2.0
 *
 * @param array $data Les données du commentaire.
 *
 * @return array $data
 */
function update_control_date( $data ) {
	$epi = EPI_Class::g()->get( array(
		'id' => $data->post_id,
	), true );

	$last_comment = ! empty( $_POST['list_comment'] ) ? end( $_POST['list_comment'] ) : array(); // WPCS: CSRF ok.

	if ( ! empty( $last_comment ) ) {
		$epi->control_date = $last_comment['date'];
		$epi->state        = $last_comment['state'];
	}

	EPI_Class::g()->update( $epi );

	return $data;
}
