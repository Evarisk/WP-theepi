<?php
/**
 * Modèles des commentaires des EPI.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 0.4.0
 * @copyright 2015-2018 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Modèles des commentaires des EPI.
 */
class EPI_Comment_Model extends \eoxia\Comment_Model {

	/**
	 * Le constructeur
	 *
	 * @since 0.1.0
	 * @version 0.4.0
	 *
	 * @param EPI_Comment_Class $object     Les données du commentaire de l'epi.
	 * @param string            $req_method La méthode de la requête.
	 */
	public function __construct( $object, $req_method = null ) {
		$this->schema['state'] = array(
			'type'      => 'string',
			'meta_type' => 'field',
			'field'     => '_state',
		);

		parent::__construct( $object, $req_method );
	}

}
