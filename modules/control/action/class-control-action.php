<?php
/**
 * Handle Contrôle EPI : Actions - Display, Edit, Save, Delete etc.
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.7.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères toutes les actions des Contrôle d'un EPI.
 */
class Control_Action {


	/**
	 * Le constructeur.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_display_control', array( $this, 'callback_display_control' ) );
		add_action( 'wp_ajax_edit_control_epi', array( $this, 'callback_edit_control_epi' ) );
		add_action( 'wp_ajax_save_control_epi', array( $this, 'callback_save_control_epi' ) );
		add_action( 'wp_ajax_cancel_edit_control_epi', array( $this, 'callback_cancel_edit_control_epi' ) );
		add_action( 'wp_ajax_delete_control_epi', array( $this, 'callback_delete_control_epi' ) );


	}

	/**
	 * Affiche la liste des contrôles d'un EPI.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	public function callback_display_control() {
		check_ajax_referer( 'display_control' );
		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$epi = EPI_Class::g()->get( array( 'id' => $id ), true );
		$frontend = ( isset( $_POST['frontend'] ) && ( $_POST['frontend']  == "true" ) ) ? $_POST['frontend'] == true : false;

		ob_start();
		\eoxia\View_Util::exec(
			'theepi',
			'control',
			'modal',
			array(
				'epi' => $epi,
				'frontend' => $frontend,
			)
		);
		$view = ob_get_clean();

		$namespace = Control_Class::g()->frontend( $frontend );

		wp_send_json_success(
			array(
				'namespace'          => $namespace,
				'module'             => 'control',
				'callback_success'   => 'displayControlSuccess',
				'view'               => $view
			)
		);

	}

	/**
	 * Affiche la vue Edition d'un contrôle.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	public function callback_edit_control_epi() {
		check_ajax_referer('edit_control_epi');

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$parent_id = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;

		if( ! $parent_id && ! $id ){
			wp_send_json_error();
		}

		if ( $id == 0 ) {
			$control = Control_Class::g()->get( array( 'schema' => true ), true );
			$callback = 'createdControlSuccess';
			$edit_mode = false;
		}else {
			$control =  Control_Class::g()->get( array( 'id' => $id ), true );
			$callback = 'editedControlSuccess';
			$edit_mode = true;
		}

		$epi = EPI_Class::g()->get( array( 'id' => $parent_id ), true );

		ob_start();
		\eoxia\View_Util::exec(
			'theepi', 'control', 'item-edit', array(
				'epi' => $epi,
				'control' => $control,
				'edit_mode' => $edit_mode
			)
		);
		$view = ob_get_clean();

		wp_send_json_success(
			array(
				'namespace'          => 'theEPI',
				'module'             => 'control',
				'callback_success'   => $callback,
				'view'               => $view,

			)
		);
	}

	/**
	 * Sauvegarde les données du contrôle.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	public function callback_save_control_epi() {
		check_ajax_referer('save_control_epi');

		$id             = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$parent_id      = ! empty( $_POST['parent-id'] ) ? (int) $_POST['parent-id'] : 0;
		$control_date   = ! empty( $_POST['control-date'] ) ? sanitize_text_field( $_POST['control-date'] ) : esc_html__( '', 'theepi' );
		$comment        = ! empty( $_POST['comment'] ) ? sanitize_text_field( $_POST['comment'] ) : esc_html__( 'No comment', 'theepi' );
		$url            = ! empty( $_POST['url'] ) ? sanitize_text_field( $_POST['url'] ) : 'No url';
		$attached_file  = ! empty( $_POST['attached-file'] ) ? sanitize_text_field( $_POST['attached-file'] ) : esc_html__( 'No attached file', 'theepi' );
		$status_control = ! empty( $_POST['status-control'] ) ? sanitize_text_field( $_POST['status-control'] ) : '';

		$control = Control_Class::g()->get( array( 'id' => $id ), true );

		unset( $control->data['author_id'] );

		$update_control = array(
			'control_date'   => $control_date,
			'comment'        => $comment,
			'url'            => $url,
			'attached_file'  => $attached_file,
			'parent_id'      => $parent_id

		);

		if ( $status_control != "" ) {
			$update_control['status_control'] = $status_control;
		}

		$control->data = wp_parse_args( $update_control, $control->data );
		$control = Control_Class::g()->update( $control->data );
		$epi = EPI_Class::g()->get( array( 'id' => $control->data[ 'parent_id' ] ) , true );

		ob_start();
		Control_Class::g()->display_modal_content( $epi, $frontend = false );
		$view = ob_get_clean();

		$view_epi = EPI_Class::g()->reload_single_epi( $epi );

		wp_send_json_success(
			array(
				'namespace'         => 'theEPI',
				'module'            => 'control',
				'callback_success'  => 'savedControlSuccess',
				'parent_id'         => $parent_id,
				'view'     		    => $view,
				'view_epi'          => $view_epi,
			)
		);

	}

	/**
	 * Annule le mode édition d'un contrôle.
	 *
	 * @return void
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 */
	public function callback_cancel_edit_control_epi() {
		check_ajax_referer( 'cancel_edit_control_epi' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		if ( empty( $id ) ) {
			$control = array();
		} else {
			$control = Control_Class::g()->get( array( 'id' => $id ), true );

			ob_start();
			\eoxia\View_Util::exec(
				'theepi', 'control', 'item', array(
					'control' => $control,
					'frontend' => false,
				)
			);
		}

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'control',
				'callback_success' => 'canceledEditControlEpiSuccess',
				'view'             => ob_get_clean(),
			)
		);
	}

	/**
	 * Supprime un contrôle.
	 *
	 * @return void
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 */
	public function callback_delete_control_epi() {
		check_ajax_referer( 'delete_control_epi' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : '';

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$epi = Control_Class::g()->delete( $id );

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'control',
				'callback_success' => 'deletedControlEpiSuccess',
			)
		);

		// ob_start();
		// Control_Class::g()->display_modal_content( $epi, $frontend = false );
		// $view = ob_get_clean();
		//
		// wp_send_json_success(
		// 	array(
		// 		'namespace'         => 'theEPI',
		// 		'module'            => 'control',
		// 		'callback_success'  => 'savedControlSuccess',
		// 		'view'     		    => $view,
		// 	)
		// );

	}
}

new Control_Action();
