<?php
/**
 * Modèles des commentaires des EPI.
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
 * Modèles des commentaires des EPI.
 */
class EPI_Comment_Model extends \eoxia\comment_model {

	/**
	 * Le constructeur
	 *
	 * @since 0.1.0
	 * @version 0.2.0
	 *
	 * @param EPI_Comment_Class $object les données du commentaire de l'epi.
	 */
	public function __construct( $object ) {
		$this->model['state'] = array(
			'type'      => 'string',
			'meta_type' => 'field',
			'field'     => '_state',
		);

		parent::__construct( $object );
	}

}
