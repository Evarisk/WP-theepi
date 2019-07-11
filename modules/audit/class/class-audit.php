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
	public function create_task() {

		$parent_id         = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;
		$tag_slug_selected = ! empty( $_POST['tag'] ) ? sanitize_text_field( $_POST['tag'] ) : 0;

		$task_args = array(
			'title'     => __( 'New task', 'task-manager' ),
			'parent_id' => $parent_id,
			'status'    => 'publish',
		);

		if ( ! empty( $tag_slug_selected ) ) {
			$tag = get_term_by( 'slug', $tag_slug_selected, 'wpeo_tag', 'ARRAY_A' );

			if ( empty( $tag ) ) {
				$tag = wp_create_term( $tag_slug_selected, 'wpeo_tag' );
			}

			$task_args['taxonomy'] = array(
				Tag_Class::g()->get_type() => array(
					$tag['term_id'],
				),
			);
		}

		$task = Task_Class::g()->create( $task_args, true );

	}

}

Audit_Class::g();
