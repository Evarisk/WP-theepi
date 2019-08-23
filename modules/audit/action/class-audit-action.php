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
class Audit_Action {


	/**
	 * Le constructeur
	 *
	 * @since   0.1.0
	 * @version 0.5.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_control_epi', array( $this, 'callback_control_epi' ) );
		add_action( 'wp_ajax_display_control_epi', array( $this, 'callback_display_control_epi' ) );
		add_action( 'wp_ajax_display_all_audits', array( $this, 'callback_display_all_audits' ) );
		add_action( 'wp_ajax_create_task_audit', array( $this, 'callback_create_task_audit' ) );
		add_action( 'wp_ajax_import_task_audit', array( $this, 'callback_import_task_audit' ) );
		add_action( 'wp_ajax_valid_audit', array( $this, 'callback_valid_audit' ) );
		add_action( 'wp_ajax_get_text_from_url_audit', array( $this, 'callback_get_text_from_url_audit' ) );
		add_action( 'wp_ajax_valid_statut_audit', array( $this, 'callback_valid_statut_audit' ) );

	}

	public function callback_control_epi() {
		check_ajax_referer( 'control_epi' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		if ( empty( $id ) ) {
			wp_send_json_error( 'id undefined' );
		}

		if ( class_exists( '\task_manager\Audit_Class' ) ) {
			$audit = \task_manager\Audit_Class::g()->get( array( 'post_parent' => $id ), true );
		} else {
			wp_send_json_error( 'TASK MANAGER NOT ACTIVATE' );
		}

		$audit_args = array(
			'title'       => sprintf( 'CONTRÔLE EPI' , 'theepi' ),
			'post_parent' => $id,
		);

		$audit = \task_manager\Audit_Class::g()->create( $audit_args, true );
		$task_args = array(
			'title'       => __( 'New task', 'task-manager' ),
			'post_parent' => $audit->data['id'],
			'status'      => 'inherit',
		);

		$task  = \task_manager\Task_Class::g()->create( $task_args, true );
		$tasks = array( $task );

		$epi = EPI_Class::g()->get( array( 'id' => $id ), true );

		ob_start();
		\eoxia\View_Util::exec(
			'theepi',
			'audit',
			'modal-template',
			array(
				'tasks'        => $tasks,
				'with_wrapper' => '',
				'audit'        => $audit,
				'epi'          => $epi,
			)
		);
		$modal_template = ob_get_clean();

		$user = get_user_by( 'id', $audit->data['author_id'] );
		ob_start();
		\eoxia\View_Util::exec(
			'theepi', 'audit', 'audit-epi', array(
				'epi'   => $epi,
				'audit' => $audit,
				'user'  => $user,
			)
		);
		$view_item = ob_get_clean();

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'Audit',
				'callback_success' => 'ControlEPISuccess',
				'modal_template'   => $modal_template,
				'view_item'        => $view_item,
			)
		);
	}

	public function callback_display_control_epi() {
		check_ajax_referer( 'display_control_epi' );

		$epi_id   = ! empty( $_POST['epi_id'] ) ? (int) $_POST['epi_id'] : 0;
		$audit_id = ! empty( $_POST['audit_id'] ) ? (int) $_POST['audit_id'] : 0;

		if ( ! class_exists( '\task_manager\Audit_Class' ) ) {
			wp_send_json_error( 'TASK MANAGER NOT ACTIVATE' );
		}

		$epi    = EPI_Class::g()->get( array( 'id' => $epi_id ), true );
		$audits = \task_manager\Audit_Class::g()->get( array( 'id' => $audit_id ) );
		$tasks  = \task_manager\Task_Class::g()->get( array( 'post_parent' => $audit_id ) );
		$audit  = EPI_Class::g()->last_control_audit( $audits );

		ob_start();
		\eoxia\View_Util::exec(
			'theepi',
			'audit',
			'modal-template',
			array(
				'tasks'        => $tasks,
				'with_wrapper' => '',
				'audit'        => $audit,
				'epi'          => $epi,
			)
		);
		$modal_template = ob_get_clean();

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'Audit',
				'callback_success' => 'DisplayControlEPISuccess',
				'modal_template'   => $modal_template,
			)
		);
	}

	public function callback_display_all_audits() {
		check_ajax_referer( 'display_all_audits' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		$epi    = EPI_Class::g()->get( array( 'id' => $id ), true );
		$audits = \task_manager\Audit_Class::g()->get( array( 'post_parent' => $id ) );

		$single_audit = EPI_Class::g()->last_control_audit( $audits );

		ob_start();
		foreach ( $audits as $key => $audit ) {
			if ( ! empty( $audit ) ) {
				$user = get_user_by( 'id', $audit->data['author_id'] );
				\eoxia\View_Util::exec(
					'theepi',
					'audit',
					'audit-epi',
					array(
						'epi'   => $epi,
						'audit' => $audit,
						'user'  => $user,
					)
				);
			}
		}
		$view = ob_get_clean();

		ob_start();
		$user = get_user_by( 'id', $single_audit->data['author_id'] );
		\eoxia\View_Util::exec(
			'theepi',
			'audit',
			'audit-epi',
			array(
				'epi'   => $epi,
				'audit' => $single_audit,
				'user'  => $user,
			)
		);
		$single_view_audit = ob_get_clean();

		wp_send_json_success(
			array(
				'namespace'         => 'theEPI',
				'module'            => 'Audit',
				'callback_success'  => 'DisplayAllAuditSuccess',
				'id'                => $id,
				'view'              => $view,
				'single_view_audit' => $single_view_audit,
			)
		);
	}

	public function callback_create_task_audit() {
		check_ajax_referer( 'create_task_audit' );

		if ( ! isset( $audit ) ) {
			$audit = \task_manager\Audit_Class::g()->get( array( 'id' => $_POST['parent_id'] ), true );
		}

		$task_args = array(
			'title'       => __( 'New task', 'task-manager' ),
			'post_parent' => $audit->data['id'],
			'status'      => 'publish',
		);

		$task = \task_manager\Task_Class::g()->create( $task_args, true );

		ob_start();
		\eoxia\View_Util::exec(
			'task-manager',
			'task',
			'backend/task',
			array(
				'task'         => $task,
				'hide_footer' => true,
				'with_wrapper' => '',
			)
		);
		$view = ob_get_clean();

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'Audit',
				'callback_success' => 'createdTaskAuditSuccess',
				'view'             => $view,

			)
		);

	}

	public function callback_import_task_audit() {
		check_ajax_referer( 'import_task_audit' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		if ( ! isset( $tags ) ) {
			$tags = \task_manager\Tag_Class::g()->get();
		}

		ob_start();
		\eoxia\View_Util::exec(
			'theepi',
			'audit',
			'modal-box-import',
			array(
				'tags'      => $tags,
				'parent_id' => $id,
			)
		);
		$view = ob_get_clean();

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'Audit',
				'callback_success' => 'ImportedTaskAuditSuccess',
				'view'             => $view,
			)
		);
	}

	public function callback_valid_audit() {
		check_ajax_referer( 'valid_audit' );

		$id         = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$status_epi = ! empty( $_POST['status_epi'] ) ? sanitize_text_field( $_POST['status_epi'] ) : '';

		if ( ! $id || ! $status_epi ) {
			wp_send_json_error( 'id or status_epi undefined' );
		}

		$status_epi = $status_epi == 'OK' ? 'OK' : 'KO';

		$epi = EPI_Class::g()->get( array( 'id' => $id ), true );

		$epi->data['status_epi'] = $status_epi;

		$epi_ = EPI_Class::g()->update( $epi->data );

		ob_start();
		\eoxia\View_Util::exec(
			'theepi', 'epi', 'item', array(
				'epi' => $epi,
			)
		);
		$view = ob_get_clean();

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'Audit',
				'callback_success' => 'ValidAuditSuccess',
				'id'               => $id,
				'view'             => $view,
			)
		);
	}

	public function callback_get_text_from_url_audit() {
		check_ajax_referer( 'get_text_from_url_audit' );
		$link    = ! empty( $_POST ) && ! empty( $_POST['github'] ) ? trim( $_POST['github'] ) : null;
		$content = file_get_contents( $link );

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'Audit',
				'callback_success' => 'GetContentFromUrlAuditSuccess',
				'content'          => $content,
				'link'             => $link,
			)
		);
	}

	public function callback_valid_statut_audit() {
		check_ajax_referer( 'valid_statut_audit' );

		$id         = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$status_audit = ! empty( $_POST['next_step'] ) ? sanitize_text_field( $_POST['next_step'] ) : '';

		 if (!$id || !$status_audit) {
			wp_send_json_error( 'id or next_step undefined' );
		}
		$audit = \task_manager\Audit_Class::g()->get( array( 'id' => $id ), true );
	  $audit->data['status_audit'] = $status_audit;
		$audit = \task_manager\Audit_Class::g()->update( $audit->data, true );
		wp_send_json_success();

	}



}

new Audit_Action();
