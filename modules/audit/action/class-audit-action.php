<?php
/**
 * Handle EPI Actions like save, delete, create_mass_epi.
 *
 * @author Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @since 0.1.0
 * @version 0.5.0
 * @copyright 2019 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères toutes les actions des AUDIT lié à un EPI.
 */
class Audit_Action {

	/**
	 * Le constructeur
	 *
	 * @since 0.1.0
	 * @version 0.5.0
	 */
	public function __construct() {
		//\task_manager\Audit_Class::g(
		add_action( 'wp_ajax_control_epi', array( $this, 'callback_control_epi' ) );
		add_action( 'wp_ajax_create_task_audit', array( $this, 'callback_create_task_audit' ) );

	}

	public function callback_control_epi () {
		check_ajax_referer( 'control_epi' );

		$id = ! empty ( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		if ( empty( $id ) ) {
			wp_send_json_error( "id undefined" );
		}

		if ( class_exists( '\task_manager\Audit_Class' ) ) {
			$audit = \task_manager\Audit_Class::g()->get( array( 'post_parent' => $id ), true);
		} else {
			wp_send_json_error( "TASK MANAGER NOT ACTIVATE" );
		}

		if ( empty( $audit ) ) {
			$audit = \task_manager\Audit_Class::g()->create( array ( 'post_parent' => $id ));
			$task_args = array(
				'title'     => __( 'New task', 'task-manager' ),
				'post_parent' => $audit->data['id'],
				'status'    => 'publish',
			);
			$task = \task_manager\Task_Class::g()->create( $task_args, true );
			$tasks = (array) $task;
		}else {
			$tasks = \task_manager\Task_Class::g()->get( array ( 'post_parent' => $audit->data['id'] ) );
		}


		ob_start();
		\eoxia\View_Util::exec(
			'task-manager',
			'task',
			'backend/tasks',
			array(
				'tasks'         => $tasks,
				'with_wrapper' => '',
			)
		);
		$task_view = ob_get_clean();

		ob_start();
		\eoxia\View_Util::exec( 'theepi', 'audit', 'modal-header', array(
		'audit' => $audit ));
		 $modal_header = ob_get_clean();

		ob_start();
 		\eoxia\View_Util::exec( 'theepi', 'audit', 'modal-footer', array(
		'audit' => $audit ));
 		$modal_footer = ob_get_clean();

		wp_send_json_success( array(
			'view'            => $task_view,
			'modal_title'			=> $modal_header,
			'buttons_view'		=> $modal_footer
		) );
	}

	public function callback_create_task_audit() {
		check_ajax_referer( 'create_task_audit' );


		if (!isset( $audit )) {
			$audit = \task_manager\Audit_Class::g()->get( array( 'id' => $_POST['parent_id'] ), true);
		}

		$task_args = array(
			'title'     => __( 'New task', 'task-manager' ),
			'post_parent' => $audit->data['id'],
			'status'    => 'publish',
		);

		$task = \task_manager\Task_Class::g()->create( $task_args, true );

		ob_start();
		\eoxia\View_Util::exec(
			'task-manager',
			'task',
			'backend/task',
			array(
				'task'         => $task,
				'with_wrapper' => '',
			) );
			 $view = ob_get_clean();

			wp_send_json_success( array(
				'namespace'        => 'theEPI',
				'module'           => 'Audit',
				'callback_success' => 'createdTaskAuditSuccess',
				'view'             => $view,

			) );

	}

}

new Audit_Action();
