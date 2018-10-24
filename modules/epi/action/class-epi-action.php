<?php
/**
 * Handle EPI Actions like save, delete, create_mass_epi.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 0.4.0
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
		add_action( 'wp_ajax_load_more_epi', array( $this, 'ajax_load_more_epi' ) );

		add_action( 'wp_ajax_search_epi', array( $this, 'ajax_search_epi' ) );
		add_action( 'wp_ajax_clear_search_epi', array( $this, 'ajax_clear_search_epi' ) );

		add_action( 'wp_ajax_create_mass_epi', array( $this, 'ajax_create_mass_epi' ) );
	}

	/**
	 * Sauvegardes un EPI
	 *
	 * @since 0.1.0
	 * @version 0.4.0
	 *
	 * @return void
	 * @todo: 13/12/2017: Faire que les données de l'EPI soit dans $_POST['epi'].
	 */
	public function ajax_save_epi() {
		check_ajax_referer( 'save_epi' );

		$data     = ! empty( $_POST ) ? (array) $_POST : array();
		$image_id = ! empty( $_POST['image'] ) ? (int) $_POST['image'] : 0;
		$comments = ! empty( $_POST['list_comment'] ) ? (array) $_POST['list_comment'] : array();
		$new_epi  = empty( $data['id'] ) ? true : false;

		$epi = EPI_Class::g()->get( array( 'id' => $data['id'] ), true );

		if ( empty( $data['id'] ) ) {
			$epi = EPI_Class::g()->get( array( 'schema' => true ), true );
		
			ob_start();
			echo do_shortcode( '[wpeo_upload id="' . $epi->data['id'] . '" model_name="/theepi/EPI_Class" single="false" field_name="image" ]' );
			$epi_upload_view = ob_get_clean();
		}

		$epi->data['title']             = sanitize_text_field( $data['title'] );
		$epi->data['serial_number']     = sanitize_text_field( $data['serial_number'] );
		$epi->data['frequency_control'] = (int) $data['frequency_control'];

		$epi = EPI_Class::g()->save( $epi, $image_id, $comments );
		ob_start();
		\eoxia\View_Util::exec( 'theepi', 'epi', 'item', array(
			'epi' => $epi,
			'new' => $new_epi,
		) );
		$epi_view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'theEPI',
			'module'           => 'EPI',
			'callback_success' => 'savedEpiSuccess',
			'object'           => $epi,
			'epi_view'         => $epi_view,
			'new_epi'          => $new_epi,
			'epi_upload_view'  => $epi_upload_view,
		) );
	}

	/**
	 * Supprimes un EPI
	 *
	 * @return void
	 *
	 * @since 0.1.0
	 * @version 0.4.0
	 */
	public function ajax_delete_epi() {
		check_ajax_referer( 'delete_epi' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : '';

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		EPI_Class::g()->delete( $id );

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
	 * Gestion du chargement supplémentaire des EPI.
	 *
	 * @since 0.2.0
	 * @version 0.4.0
	 *
	 * @return void
	 */
	public function ajax_load_more_epi() {
		check_ajax_referer( 'load_more_epi' );

		$offset = ! empty( $_POST['offset'] ) ? (int) $_POST['offset'] : 1;
		$term   = ! empty( $_POST['term'] ) ? sanitize_text_field( $_POST['term'] ) : '';

		$pagination_data = EPI_Class::g()->get_pagination_data( $offset, $term );

		$epis = EPI_Class::g()->get_epis( $pagination_data, $term );

		ob_start();
		EPI_Class::g()->display_epi_list( $epis );
		wp_send_json_success( array(
			'namespace'        => 'theEPI',
			'module'           => 'EPI',
			'callback_success' => 'loadedMoreEPISuccess',
			'view'             => ob_get_clean(),
		) );
	}

	/**
	 * Recherches tous les EPI
	 *
	 * @since 0.4.0
	 * @version 0.4.0
	 *
	 * @return void
	 */
	public function ajax_search_epi() {
		check_ajax_referer( 'search_epi' );

		$term = ! empty( $_POST['term'] ) ? sanitize_text_field( $_POST['term'] ) : '';

		ob_start();
		EPI_Class::g()->display( $term );
		wp_send_json_success( array(
			'namespace'        => 'theEPI',
			'module'           => 'EPI',
			'callback_success' => 'searchedEPISuccess',
			'clear'            => false,
			'view'             => ob_get_clean(),
		) );
	}

	/**
	 * Met la recherche à 0
	 *
	 * @since 0.4.0
	 * @version 0.4.0
	 *
	 * @return void
	 */
	public function ajax_clear_search_epi() {
		check_ajax_referer( 'clear_search_epi' );

		ob_start();
		EPI_Class::g()->display();
		wp_send_json_success( array(
			'namespace'        => 'theEPI',
			'module'           => 'EPI',
			'callback_success' => 'searchedEPISuccess',
			'clear'            => true,
			'view'             => ob_get_clean(),
		) );
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

		$epis = EPI_Class::g()->create_mass_epi( $files_id );

		EPI_Class::g()->display_epi_list( $epis, true );
		wp_die();
	}
}

new EPI_Action();
