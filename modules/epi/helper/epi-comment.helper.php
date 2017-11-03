<?php

namespace evarisk_epi;

/**
 * Met à jour la date de contrôle et le status de l'EPI selon le dernier commentaire.
 *
 * @param array $data Les données du commentaire.
 *
 * @return array $data
 *
 * @since 1.0.0
 * @version 1.0.1
 */
function update_control_date( $data ) {
	$epi = EPI_Class::g()->get( array(
		'id' => $data->post_id,
	), true );

	$last_comment = ! empty( $_POST['list_comment'] ) ? max ( $_POST['list_comment'] ) : array();

	if ( ! empty( $last_comment ) ) {
		$epi->control_date = $last_comment['date'];
		$epi->state = $last_comment['state'];
	}

	EPI_Class::g()->update( $epi );

	return $data;
}

?>
