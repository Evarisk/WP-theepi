<?php
/**
 * Define EPI Model.
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
 * Define EPI Model.
 */
class EPI_Model extends \eoxia\Post_Model {

	/**
	 * Construct
	 *
	 * @since 0.1.0
	 * @version 0.4.0
	 *
	 * @param EPI_Class $object     Les données du commentaire de l'epi.
	 * @param string    $req_method La méthode de la requête.
	 */
	public function __construct( $object, $req_method = null ) {
		$this->schema['unique_key'] = array(
			'type'        => 'integer',
			'meta_type'   => 'single',
			'field'       => '_theepi_unique_key',
			'description' => 'Is the ID of this object. Ex: 1 or 10 or 99',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->schema['unique_identifier'] = array(
			'type'        => 'string',
			'meta_type'   => 'single',
			'field'       => '_theepi_unique_identifier',
			'description' => 'Is the Unique identifier + Unique key of this object. Ex: EPI1 or EPI10 or EPI99',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->schema['associated_document_id'] = array(
			'type'        => 'array',
			'meta_type'   => 'multiple',
			'child'       => array(
				'image' => array(
					'type'      => 'array',
					'meta_type' => 'multiple',
				),
			),
			'description' => 'Is an array of media ID.',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->schema['serial_number'] = array(
			'type'        => 'string',
			'meta_type'   => 'single',
			'field'       => '_serial_number',
			'description' => 'Is the serial number of the EPI.',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->schema['production_date'] = array(
			'type'        => 'wpeo_date',
			'context'     => array( 'GET' ),
			'meta_type'   => 'multiple',
			'description' => 'Is the production date of the EPI.',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->schema['frequency_control'] = array(
			'type'        => 'integer',
			'meta_type'   => 'multiple',
			'required'    => true,
			'description' => 'Is the frequency control of the EPI.',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->schema['control_date'] = array(
			'type'        => 'wpeo_date',
			'context'     => array( 'GET' ),
			'meta_type'   => 'multiple',
			'description' => 'Is the control date of the EPI.',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->schema['compiled_remaining_time'] = array(
			'type'        => 'string',
			'meta_type'   => 'field',
			'field'       => '_compiled_remaining_time',
			'default'     => '',
			'description' => 'Is compiled time remaining before the EPI is broken.',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->schema['state'] = array(
			'type'        => 'string',
			'meta_type'   => 'field',
			'field'       => '_state',
			'default'     => '',
			'description' => 'Is the state of the EPI. Broken or not. Value can be "OK" or "KO".',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		parent::__construct( $object, $req_method );
	}

}
