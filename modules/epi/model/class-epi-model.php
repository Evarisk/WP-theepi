<?php
/**
 * Define EPI Model.
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
 * Define EPI Model.
 */
class EPI_Model extends \eoxia\Post_Model {

	/**
	 * Construct
	 *
	 * @since 0.1.0
	 * @version 0.2.0
	 *
	 * @param mixed $object The model object.
	 */
	public function __construct( $object ) {
		$this->model['unique_key'] = array(
			'type'        => 'string',
			'meta_type'   => 'single',
			'field'       => '_theepi_unique_key',
			'description' => 'Is the ID of this object. Ex: 1 or 10 or 99',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->model['unique_identifier'] = array(
			'type'        => 'string',
			'meta_type'   => 'single',
			'field'       => '_theepi_unique_identifier',
			'description' => 'Is the Unique identifier + Unique key of this object. Ex: EPI1 or EPI10 or EPI99',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->model['associated_document_id'] = array(
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

		$this->model['serial_number'] = array(
			'type'        => 'string',
			'meta_type'   => 'single',
			'field'       => '_serial_number',
			'required'    => true,
			'description' => 'Is the serial number of the EPI.',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->model['production_date'] = array(
			'type'        => 'string',
			'meta_type'   => 'multiple',
			'description' => 'Is the production date of the EPI.',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->model['frequency_control'] = array(
			'type'        => 'string',
			'meta_type'   => 'multiple',
			'required'    => true,
			'description' => 'Is the frequency control of the EPI.',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->model['control_date'] = array(
			'type'        => 'wpeo_date',
			'meta_type'   => 'multiple',
			'description' => 'Is the control date of the EPI.',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->model['compiled_remaining_time'] = array(
			'type'        => 'string',
			'meta_type'   => 'field',
			'field'       => '_compiled_remaining_time',
			'bydefault'   => '',
			'description' => 'Is compiled time remaining before the EPI is broken.',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->model['state'] = array(
			'type'        => 'string',
			'meta_type'   => 'field',
			'field'       => '_state',
			'bydefault'   => '',
			'description' => 'Is the state of the EPI. Broken or not. Value can be "OK" or "KO".',
			'since'       => '0.1.0',
			'version'     => '0.1.0',
		);

		$this->model['title']['required'] = true;

		parent::__construct( $object );
	}

}
