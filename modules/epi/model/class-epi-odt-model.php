<?php
/**
 * Définition des champs d'un document EPI_ODT.
 *
 * @package   TheEPI
 * @author    Evarisk <dev@evarisk.com>
 * @copyright 2019 Evarisk.
 * @since     0.5.0
 * @version   0.5.0
 */

namespace theepi;

use eoxia\ODT_Model;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'un document EPI_ODT.
 */
class EPI_ODT_Model extends ODT_Model {


	/**
	 * Définition des champs.
	 *
	 * @since   0.5.0
	 * @version 0.5.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['zip_path'] = array(
			'since'     => '6.2.1',
			'version'   => '6.2.1',
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => 'zip_path',
		);

		$this->schema['document_meta'] = array(
			'type'      => 'array',
			'meta_type' => 'single',
			'field'     => 'document_meta',
		);

		parent::__construct( $data, $req_method );
	}
}
