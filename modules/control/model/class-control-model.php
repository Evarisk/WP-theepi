<?php
/**
 * Define EPI Model.
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com> && Laurent Magnin <laurent@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.1.0
 * @version   0.6.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define EPI Model.
 */
class Control_Model extends \eoxia\Post_Model {


	/**
	 * Construct
	 *
	 * @since   0.1.0
	 * @version 0.6.0
	 *
	 * @param EPI_Class $object     Les données du controle de l'EPI.
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


		$this->schema['status_epi'] = array(
			'type'        => 'string',
			'meta_type'   => 'single',
			'field'       => '_theepi_status_epi',
			'description' => 'Is the status of the EPI. Value can be "OK" or "KO" or "REPAIR" or "TRASH".',
			'since'       => '0.5.0',
			'version'     => '0.5.0',
		);


		$this->schema['control_date'] = array(
			'type'        => 'wpeo_date',
			'context'     => array( 'GET' ),
			'meta_type'   => 'multiple',
			'description' => 'Is the control date of the EPI.',
			'since'       => '0.6.0',
			'version'     => '0.6.0',
		);

		$this->schema['commissioning_date'] = array(
			'type'        => 'wpeo_date',
			'context'     => array( 'GET' ),
			'meta_type'   => 'single',
			'field'       => '_theepi_commissioning_date',
			'description' => 'Is the commissioning date of the EPI.',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->schema['commissioning_date_valid'] = array(
			'type'        => 'integer',
			'meta_type'   => 'single',
			'field'       => '_theepi_commissioning_date_valid',
			'description' => 'Check if commissioning date is update',
			'since'       => '0.6.0',
			'version'     => '0.6.0',
			'default'     => 0,
		);

		$this->schema['disposal_date'] = array(
			'type'        => 'wpeo_date',
			'context'     => array( 'GET' ),
			'meta_type'   => 'single',
			'field'       => '_theepi_disposal_date',
			'description' => 'Is the disposal date of the EPI.',
			'since'       => '0.6.0',
			'version'     => '0.6.0',
		);

		$this->schema['lifetime_epi'] = array(
			'type'        => 'integer',
			'meta_type'   => 'single',
			'field'       => '_theepi_lifetime_epi',
			'description' => 'Is the lifetime of the EPI.',
			'since'       => '0.6.0',
			'version'     => '0.6.0',
		);

		parent::__construct( $object, $req_method );
	}

}