<?php
/**
* Handle Audit.
*
* @author Nicolas Domenech <nicolas@eoxia.com>
* @since 0.5.0
* @version 0.5.0
* @copyright 2019 Evarisk
* @package TheEPI
*/

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Handle Audit
*/
class Audit_Class extends \eoxia\Post_Class {

	/**
	* Le nom du modèle
	*
	* @var string
	*/
	protected $model_name = '\theepi\Audit_Model';

	/**
	* Le post type
	*
	* @var string
	*/
	protected $type = 'theepi-audit';

	/**
	* La clé principale du modèle
	*
	* @var string
	*/
	protected $meta_key = '_theepi_audit';

	/**
	* La route pour accéder à l'objet dans la rest API
	*
	* @var string
	*/
	protected $base = 'theepi/audit';

	/**
	* La version de l'objet
	*
	* @var string
	*/
	protected $version = '0.1';

	/**
	* Le préfixe de l'objet dans TheEPI.
	*
	* @var string
	*/
	public $element_prefix = 'EPI';

/*
	* Le nom pour le register post type
	*
	* @var string
	*/
	protected $post_type_name = 'Audit Personal protective equipment';

	/**
	* La taxonomie à attacher.
	*
	* @var string
	*/
	protected $attached_taxonomy_type = '_theepi_state';

	/**
	* Crée une tâche dans l'audit.
	*
	* @since 0.5.0
	* @version 0.5.0
	*
	* @return void
	*/
	public function get_status( $epi ) {
		if ( $epi->data['status_epi'] == 'OK') {
			return true;
		}

		return false;
	}

}

Audit_Class::g();
