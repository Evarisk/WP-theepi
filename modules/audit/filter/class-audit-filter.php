<?php
/**
 * Handle EPI Actions like save, delete, create_mass_epi.
 *
 * @author    Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @since     0.1.0
 * @version   0.5.0
 * @copyright 2019 Evarisk
 * @package   TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères toutes les actions des AUDIT lié à un EPI.
 */
class Audit_Filter {


	/**
	 * Le constructeur
	 *
	 * @since   0.1.0
	 * @version 0.5.0
	 */
	public function __construct() {
		add_filter( 'tm_audit_import_tasks_and_points_return', array( $this, 'callback_tm_audit_import_tasks_and_points_return' ), 10, 2 );
	}

	public function callback_tm_audit_import_tasks_and_points_return( $data_array_import, $id ) {

		$audit = \task_manager\Audit_Class::g()->get( array( 'id' => $id ), true );
		$tasks = \task_manager\Task_Class::g()->get( array( 'post_parent' => $audit->data['id'] ) );
		$epi   = EPI_Class::g()->get( array( 'id' => $audit->data['parent_id'] ), true );

		ob_start();
		\eoxia\View_Util::exec(
			'task-manager',
			'task',
			'backend/tasks',
			array(
				'tasks'        => $tasks,
				'with_wrapper' => '',
			)
		);
		$task_view = ob_get_clean();

		ob_start();
		\eoxia\View_Util::exec(
			'theepi', 'audit', 'modal-header', array(
				'audit' => $audit,
				'epi'   => $epi,
			)
		);
		$modal_header = ob_get_clean();

		ob_start();
		\eoxia\View_Util::exec(
			'theepi', 'audit', 'modal-footer', array(
				'audit' => $audit,
				'epi'   => $epi,
			)
		);
		$modal_footer = ob_get_clean();

		$data_array_import_replace = array(
			'namespace'        => 'theEPI',
			'module'           => 'Audit',
			'callback_success' => 'ImportedButtonTaskAuditSuccess',
			'view'             => $task_view,
			'modal_title'      => $modal_header,
			'buttons_view'     => $modal_footer,
		);

		$data_array_return = array_replace( $data_array_import, $data_array_import_replace );

		return $data_array_return;
	}
}

new Audit_Filter();
