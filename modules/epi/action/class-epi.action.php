<?php
/**
 * Gères toutes les actions des EPI.
 *
 * @package Evarisk\Plugin
 *
 * @since 0.0.0.1
 * @version 0.0.0.1
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

/**
 * Gères toutes les actions des EPI.
 */
class EPI_Action {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_action( 'wp_ajax_save_epi', array( $this, 'ajax_save_epi' ) );
		add_action( 'wp_ajax_delete_epi', array( $this, 'ajax_delete_epi' ) );
		add_action( 'wp_ajax_load_epi', array( $this, 'ajax_load_epi' ) );
	}

	/**
	 * Sauvegardes un EPI
	 *
	 * @return void
	 *
	 * @since 0.0.0.1
	 * @version 0.0.0.1
	 */
	public function ajax_save_epi() {
		check_ajax_referer( 'save_epi' );

		EPI_Class::g()->update( $_POST );

		ob_start();
		EPI_Class::g()->display_epi_list();
		wp_send_json_success( array(
			'module' => 'epi',
			'callback_success' => 'savedEpiSuccess',
			'template' => ob_get_clean(),
		) );
	}

	/**
	 * Supprimes un EPI
	 *
	 * @return void
	 *
	 * @since 0.0.0.1
	 * @version 0.0.0.1
	 */
	public function ajax_delete_epi() {
		check_ajax_referer( 'delete_epi' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : '';

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$epi = EPI_Class::g()->get( array(
			'id' => $id,
		) );

		$epi = $epi[0];
		$epi->status = 'trash';

		EPI_Class::g()->update( $epi );

		wp_send_json_success( array(
			'module' => 'epi',
			'callback_success' => 'deletedEpiSuccess',
		) );
	}

	/**
	 * Charges les données d'un EPI
	 *
	 * @return void
	 *
	 * @since 0.0.0.1
	 * @version 0.0.0.1
	 */
	public function ajax_load_epi() {
		check_ajax_referer( 'load_epi' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$epi = EPI_Class::g()->get( array(
			'include' => $id,
		) );

		$epi = $epi[0];

		ob_start();

		View_Util::exec( 'epi', 'item-edit', array(
			'epi' => $epi,
		) );

		wp_send_json_success( array(
			'module' => 'epi',
			'callback_success' => 'loadedEpiSuccess',
			'template' => ob_get_clean(),
		) );
	}
}

new EPI_Action();
