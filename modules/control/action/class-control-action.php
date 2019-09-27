<?php
/**
 * Handle EPI Actions like save, delete, create_mass_epi.
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.1.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères toutes les actions des EPI.
 */
class Control_Action {


	/**
	 * Le constructeur.
	 *
	 * @since   0.1.0
	 * @version 0.7.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_display_control', array( $this, 'callback_display_control' ) );
		add_action( 'wp_ajax_edit_control_epi', array( $this, 'callback_edit_control_epi' ) );
		add_action( 'wp_ajax_save_control_epi', array( $this, 'callback_save_control_epi' ) );
		add_action( 'wp_ajax_cancel_edit_control_epi', array( $this, 'callback_cancel_edit_control_epi' ) );
		add_action( 'wp_ajax_delete_control_epi', array( $this, 'callback_delete_control_epi' ) );


	}

	public function callback_display_control() {
		check_ajax_referer( 'display_control' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$epi = EPI_Class::g()->get( array( 'id' => $id ), true );

		ob_start();
		\eoxia\View_Util::exec(
			'theepi',
			'control',
			'modal',
			array(
				'epi' => $epi,
			)
		);
		$view = ob_get_clean();

		wp_send_json_success(
			array(
				'namespace'          => 'theEPI',
				'module'             => 'control',
				'callback_success'   => 'displayControlSuccess',
				'view'               => $view
			)
		);

	}

	/**
	 * Affiche un EPI lors de sa création.
	 *
	 * @since   0.5.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	public function callback_edit_control_epi() {
		check_ajax_referer('edit_control_epi');

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$parent_id = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;

		if( ! $parent_id && ! $id ){
			wp_send_json_error( 'Nico la vie de ma mere tu pues la mort ' );
		}

		if ( $id == 0 ) {
			$control = Control_Class::g()->get( array( 'schema' => true ), true );
			$callback = 'createdControlSuccess';
		}else {
			$control =  Control_Class::g()->get( array( 'id' => $id ), true );
			$callback = 'editedControlSuccess';
		}

		$epi = EPI_Class::g()->get( array( 'id' => $parent_id ), true );

		ob_start();
		\eoxia\View_Util::exec(
			'theepi', 'control', 'item-edit', array(
				'epi' => $epi,
				'control' => $control,
				'edit_mode' => false
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

	public function callback_save_control_epi() {
		check_ajax_referer('save_control_epi');

		$id             = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$parent_id      = ! empty( $_POST['parent-id'] ) ? (int) $_POST['parent-id'] : 0;
		$media_id       = ! empty( $_POST['thumbnail_id'] ) ? (int) $_POST['thumbnail_id'] : 0;
		$control_date   = ! empty( $_POST['control-date'] ) ? sanitize_text_field( $_POST['control-date'] ) : esc_html__( '', 'theepi' );
		$comment        = ! empty( $_POST['comment'] ) ? sanitize_text_field( $_POST['comment'] ) : esc_html__( 'No comment', 'theepi' );
		$url            = ! empty( $_POST['url'] ) ? sanitize_text_field( $_POST['url'] ) : 'No url';
		$attached_file  = ! empty( $_POST['attached-file'] ) ? sanitize_text_field( $_POST['attached-file'] ) : esc_html__( 'No attached file', 'theepi' );
		$status_control = ! empty( $_POST['status-control'] ) ? sanitize_text_field( $_POST['status-control'] ) : esc_html__( 'OK', 'theepi' );

		$control = Control_Class::g()->get( array( 'id' => $id ), true );

		unset( $control->data['author_id'] );

		$update_control = array(
			'control_date'   => $control_date,
			'comment'        => $comment,
			'url'            => $url,
			'attached_file'  => $attached_file,
			'status_control' => $status_control,
			'parent_id'      => $parent_id

		);

		//$date_valid = Service_Class::g()->check_date_epi( $update_control );
		$view = "";
		$control->data[ 'associated_document_id' ][ 'media' ][] = $media_id;
		$control->data = wp_parse_args( $update_control, $control->data );
		$control = Control_Class::g()->update( $control->data );

		$epi = EPI_Class::g()->get( array( 'id' => $control->data[ 'parent_id' ] ) , true );

		ob_start();
		Control_Class::g()->display_modal_content( $epi );
		$view = ob_get_clean();

		wp_send_json_success(
			array(
				'namespace'         => 'theEPI',
				'module'            => 'control',
				'callback_success'  => 'savedControlSuccess',
				'view'     		    => $view,
			)
		);

	}

	/**
	 * Annule le mode édition d'un EPI.
	 *
	 * @return void
	 *
	 * @since   0.1.0
	 * @version 0.5.0
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

	public function callback_delete_control_epi() {
		check_ajax_referer( 'delete_control_epi' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : '';

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$epi = Control_Class::g()->delete( $id );

		// wp_send_json_success(
		// 	array(
		// 		'namespace'        => 'theEPI',
		// 		'module'           => 'control',
		// 		'callback_success' => 'deletedControlEpiSuccess',
		// 	)
		// );


		ob_start();
		Control_Class::g()->display_modal_content( $epi );
		$view = ob_get_clean();

		wp_send_json_success(
			array(
				'namespace'         => 'theEPI',
				'module'            => 'control',
				'callback_success'  => 'savedControlSuccess',
				'view'     		    => $view,
			)
		);

	}
}

new Control_Action();
