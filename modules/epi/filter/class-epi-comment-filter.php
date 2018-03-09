<?php
/**
 * Handle EPI Filter.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 0.4.0
 * @version 0.4.0
 * @copyright 2018 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle EPI Filter.
 */
class EPI_Comment_Filter {

	/**
	 * Le constructeur
	 *
	 * @since 0.1.0
	 * @version 0.4.0
	 */
	public function __construct() {
		$current_type = EPI_Comment_Class::g()->get_type();
		add_filter( "eo_model_{$current_type}_before_post", array( $this, 'update_control_data' ), 10, 2 );
		add_filter( "eo_model_{$current_type}_before_put", array( $this, 'update_control_data' ), 10, 2 );
	}

	/**
	 * Met à jour la date de contrôle et le status de l'EPI selon le dernier commentaire.
	 *
	 * @since 0.1.0
	 * @version 0.4.0
	 *
	 * @param array $data Les données du commentaire.
	 * @param array $args    Les données de la requête.
	 *
	 * @return array $data
	 */
	public function update_control_data( $data, $args ) {
		$epi = EPI_Class::g()->get( array(
			'id' => $data['post_id'],
		), true );

		$last_comment = ! empty( $_POST['list_comment'] ) ? end( $_POST['list_comment'] ) : array(); // WPCS: CSRF ok.

		if ( ! empty( $last_comment ) ) {
			$epi->data['control_date'] = $last_comment['date'];
			$epi->data['state']        = $last_comment['state'];
		}

		EPI_Class::g()->update( $epi->data );

		return $data;
	}

}

new EPI_Comment_Filter();
