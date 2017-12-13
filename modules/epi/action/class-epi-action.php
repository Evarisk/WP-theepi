<?php
/**
 * Handle EPI Actions like save, delete, create_mass_epi.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 0.2.0
 * @copyright 2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères toutes les actions des EPI.
 */
class EPI_Action {

	/**
	 * Le constructeur
	 *
	 * @since 0.1.0
	 * @version 0.2.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_save_epi', array( $this, 'ajax_save_epi' ) );
		add_action( 'wp_ajax_delete_epi', array( $this, 'ajax_delete_epi' ) );
		add_action( 'wp_ajax_load_epi', array( $this, 'ajax_load_epi' ) );

		add_action( 'wp_ajax_paginate_epi', array( $this, 'ajax_paginate_epi' ) );

		add_action( 'wp_ajax_create_mass_epi', array( $this, 'ajax_create_mass_epi' ) );
	}

	/**
	 * Sauvegardes un EPI
	 *
	 * @since 0.1.0
	 * @version 0.3.0
	 *
	 * @return void
	 * @todo: 13/12/2017: Faire que les données de l'EPI soit dans $_POST['epi'].
	 *        13/12/2017: Sanitize toutes les entrées.
	 */
	public function ajax_save_epi() {
		check_ajax_referer( 'save_epi' );

		$data     = ! empty( $_POST ) ? (array) $_POST : array();
		$image_id = ! empty( $_POST['image'] ) ? (int) $_POST['image'] : 0;
		$comments = ! empty( $_POST['list_comment'] ) ? (array) $_POST['list_comment'] : array();

		$epi = EPI_Class::g()->save( $data, $image_id, $comments );

		ob_start();
		Class_TheEPI_Core::g()->display();
		wp_send_json_success( array(
			'namespace'        => 'theEPI',
			'module'           => 'EPI',
			'callback_success' => 'savedEpiSuccess',
			'object'           => $epi,
			'template'         => ob_get_clean(),
		) );
	}

	/**
	 * Supprimes un EPI
	 *
	 * @return void
	 *
	 * @since 0.1.0
	 * @version 0.2.0
	 */
	public function ajax_delete_epi() {
		check_ajax_referer( 'delete_epi' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : '';

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		EPI_Class::g()->delete( 'id' );

		wp_send_json_success( array(
			'namespace'        => 'theEPI',
			'module'           => 'EPI',
			'callback_success' => 'deletedEpiSuccess',
		) );
	}

	/**
	 * Charges les données d'un EPI
	 *
	 * @since 0.1.0
	 * @version 0.2.0
	 *
	 * @return void
	 */
	public function ajax_load_epi() {
		check_ajax_referer( 'load_epi' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$epi = EPI_Class::g()->get( array(
			'id' => $id,
		), true );

		ob_start();
		\eoxia\View_Util::exec( 'theepi', 'epi', 'item-edit', array(
			'epi' => $epi,
		) );

		wp_send_json_success( array(
			'namespace'        => 'theEPI',
			'module'           => 'EPI',
			'callback_success' => 'loadedEpiSuccess',
			'template'         => ob_get_clean(),
		) );
	}

	/**
	 * Gestion de la pagination des EPI.
	 *
	 * @since 0.2.0
	 * @version 0.2.0
	 *
	 * @return void
	 * @todo: nonce
	 */
	public function ajax_paginate_epi() {
		$current_page = ! empty( $_POST['current_page'] ) ? (int) $_POST['current_page'] : 1;

		EPI_Class::g()->display( $current_page );
		wp_die();
	}

	/**
	 * Pour chaque ID de fichier reçu, créer un EPI.
	 *
	 * @since 0.1.0
	 * @version 0.3.0
	 *
	 * @return void
	 * @todo: nonce
	 */
	public function ajax_create_mass_epi() {
		$files_id = ! empty( $_POST['files_id'] ) ? (array) $_POST['files_id'] : array();

		if ( empty( $files_id ) ) {
			wp_send_json_error();
		}

		EPI_Class::g()->create_mass_epi( $files_id );

		EPI_Class::g()->display_epi_list();
		wp_die();
	}
}

new EPI_Action();
