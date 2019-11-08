<?php
/**
 * Define EPI Model.
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.1.0
 * @version   0.7.0
 */

namespace theepi;

use eoxia\Post_Model;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define EPI Model.
 */
class EPI_Model extends Post_Model {

	/**
	 * Construct
	 *
	 * @since   0.1.0
	 * @version 0.7.0
	 *
	 * @param EPI_Class $object     Les données  de l'epi.
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

		$this->schema['reference'] = array(
			'type'        => 'string',
			'meta_type'   => 'single',
			'field'       => '_theepi_reference',
			'description' => 'Is the reference of the EPI.',
			'since'       => '0.4.0',
			'version'     => '0.6.0',
		);

		$this->schema['periodicity'] = array(
			'type'        => 'integer',
			'meta_type'   => 'single',
			'field'       => '_theepi_periodicity',
			'description' => 'Is the periodicity of the EPI.',
			'since'       => '0.4.0',
			'version'     => '0.6.0',
		);

		$this->schema['serial_number'] = array(
			'type'        => 'string',
			'meta_type'   => 'single',
			'field'       => '_theepi_serial_number',
			'description' => 'Is the serial number of the EPI.',
			'since'       => '0.6.0',
			'version'     => '0.6.0',
		);

		$this->schema['maker'] = array(
			'type'        => 'string',
			'meta_type'   => 'single',
			'field'       => '_theepi_maker',
			'description' => 'Is the maker of the EPI.',
			'since'       => '0.6.0',
			'version'     => '0.6.0',
		);

		$this->schema['seller'] = array(
			'type'        => 'string',
			'meta_type'   => 'single',
			'field'       => '_theepi_seller',
			'description' => 'Is the seller of the EPI.',
			'since'       => '0.6.0',
			'version'     => '0.6.0',
		);

		$this->schema['manager'] = array(
			'type'        => 'integer',
			'meta_type'   => 'single',
			'field'       => '_theepi_manager',
			'description' => 'Is the manager of the EPI.',
			'since'       => '0.6.0',
			'version'     => '0.6.0',
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

		$this->schema['manufacture_date'] = array(
			'type'        => 'wpeo_date',
			'context'     => array( 'GET' ),
			'meta_type'   => 'single',
			'field'       => '_theepi_manufacture_date',
			'description' => 'Is the manufacture date of the EPI.',
			'since'       => '0.6.0',
			'version'     => '0.6.0',
		);

		$this->schema['manufacture_date_valid'] = array(
			'type'        => 'integer',
			'meta_type'   => 'single',
			'field'       => '_theepi_manufacture_date_valid',
			'description' => 'Check if manufacture date is update',
			'since'       => '0.6.0',
			'version'     => '0.6.0',
			'default'     => 0,
		);

		$this->schema['purchase_date'] = array(
			'type'        => 'wpeo_date',
			'context'     => array( 'GET' ),
			'meta_type'   => 'single',
			'field'       => '_theepi_purchase_date',
			'description' => 'Is the purchase date of the EPI.',
			'since'       => '0.6.0',
			'version'     => '0.6.0',
		);

		$this->schema['purchase_date_valid'] = array(
			'type'        => 'integer',
			'meta_type'   => 'single',
			'field'       => '_theepi_purchase_date_valid',
			'description' => 'Check if purchase date is update',
			'since'       => '0.6.0',
			'version'     => '0.6.0',
			'default'     => 0,
		);

		$this->schema['end_life_date'] = array(
			'type'        => 'wpeo_date',
			'context'     => array( 'GET' ),
			'meta_type'   => 'single',
			'field'       => '_theepi_end_life_date',
			'description' => 'Is the end life date of the EPI.',
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

		$this->schema['qrcode'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(
				'filename'         => array(
					'type' => 'string',
				),
				'path'             => array(
					'type' => 'string',
				),
				'guid'             => array(
					'type' => 'string',
				),
				'wp_attached_file' => array(
					'type' => 'string',
				),
			),
		);

		$this->schema['url_notice'] = array(
			'type'        => 'string',
			'meta_type'   => 'single',
			'field'       => '_theepi_url_notice',
			'description' => 'Is the url notice of the EPI.',
			'since'       => '0.7.0',
			'version'     => '0.7.0',
		);

		$this->schema['toggle_lifetime'] = array(
			'type'        => 'string',
			'meta_type'   => 'single',
			'field'       => '_theepi_toggle_lifetime',
			'description' => 'Is the toggle button lifetime of the EPI. Value can be "YES" or "NO".',
			'since'       => '0.7.0',
			'version'     => '0.7.0',
			'default'     => 'YES',
		);

		$this->schema['quantity'] = array(
			'type'        => 'integer',
			'meta_type'   => 'single',
			'field'       => '_theepi_quantity',
			'description' => 'Is the quantity of the EPI.',
			'since'       => '0.7.0',
			'version'     => '0.7.0',
			'default'     => 1,
		);

		parent::__construct( $object, $req_method );
	}

}
