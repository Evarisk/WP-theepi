<?php

namespace evarisk_epi;

/**
 * [update_control_date description]
 * @return array $data
 */
function update_control_date( $data ) {

	$epi = EPI_Class::g()->get( array(
		'include' => array(
			$data->post_id,
		),
	) );

	$epi = $epi[0];

	$last_comment = ! empty( $_POST['list_comment'] ) ? max ( $_POST['list_comment'] ) : array();

	if ( ! empty( $last_comment ) ) {
		$epi->control_date = $last_comment['date'];
		$epi->state = $last_comment['state'];
	}

	EPI_Class::g()->update( $epi );

	return $data;
}

?>
