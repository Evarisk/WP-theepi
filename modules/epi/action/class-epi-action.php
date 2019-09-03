<?php
/**
 * Handle EPI Actions like save, delete, create_mass_epi.
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.1.0
 * @version   0.6.0
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
	 * Le constructeur.
	 *
	 * @since   0.1.0
	 * @version 0.5.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_create_epi', array( $this, 'callback_create_epi' ) );
		add_action( 'wp_ajax_save_epi', array( $this, 'callback_save_epi' ) );
		add_action( 'wp_ajax_delete_epi', array( $this, 'callback_delete_epi' ) );
		add_action( 'wp_ajax_edit_epi', array( $this, 'callback_edit_epi' ) );
		add_action( 'wp_ajax_cancel_edit_epi', array( $this, 'callback_cancel_edit_epi' ) );
		add_action( 'wp_ajax_load_epi', array( $this, 'callback_load_epi' ) );
		add_action( 'wp_ajax_load_more_epi', array( $this, 'callback_load_more_epi' ) );

		add_action( 'wp_ajax_search_epi', array( $this, 'callback_search_epi' ) );
		add_action( 'wp_ajax_clear_search_epi', array( $this, 'callback_clear_search_epi' ) );

		add_action( 'wp_ajax_create_mass_epi', array( $this, 'callback_create_mass_epi' ) );
	}


	/**
	 * Affiche un EPI lors de sa création.
	 *
	 * @since   0.5.0
	 * @version 0.6.0
	 *
	 * @return void
	 */
	public function callback_create_epi() {
		check_ajax_referer('create_epi');

		$close_epi_id = ! empty( $_POST['closeepi'] ) ? (int) $_POST['closeepi'] : 0;

		if( $close_epi_id ){
			$close_epi = EPI_Class::g()->get( array( 'id' => $close_epi_id ), true );
			$close_view_epi = EPI_Class::g()->reload_single_epi( $close_epi );
		}else{
			$close_view_epi = "";
		}

		$epi = EPI_Class::g()->get( array( 'schema' => true ), true );

		$epi->data['periodicity'] = get_option( EPI_Class::g()->option_name_default_data_periodicity );
		$epi->data['lifetime_epi'] = get_option( EPI_Class::g()->option_name_default_data_lifetime );

		$checked_purchase_date = get_option( EPI_Class::g()->option_name_date_management_purchase_date );
		$manufacture_date_valued = get_option( EPI_Class::g()->option_name_date_management_manufacture_date );

		ob_start();
		\eoxia\View_Util::exec(
			'theepi', 'epi', 'item-edit', array(
				'epi' => $epi,
			)
		);
		$view_edit_epi = ob_get_clean();

		ob_start();
		\eoxia\View_Util::exec(
			'theepi', 'service', 'main', array(
				'epi' => $epi,
				'checked_purchase_date' => $checked_purchase_date,
				'manufacture_date_valued' => $manufacture_date_valued
			)
		);
		$view_edit_service = ob_get_clean();

		wp_send_json_success(
			array(
				'namespace'          => 'theEPI',
				'module'             => 'EPI',
				'callback_success'   => 'CreatedEpiSuccess',
				'view_edit_epi'      => $view_edit_epi,
				'view_edit_service'  => $view_edit_service,
				'view_close'        => $close_view_epi,
				'close_epi_id'      => $close_epi_id

			)
		);
	}

	/**
	 * Sauvegardes un EPI.
	 *
	 * @since   0.1.0
	 * @version 0.6.0
	 *
	 * @return void
	 */
	public function callback_save_epi() {
		check_ajax_referer( 'save_epi' );

		//DONNEE EPI
		$id                 = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$image_id           = ! empty( $_POST['image'] ) ? (int) $_POST['image'] : 0;
		$title              = ! empty( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : esc_html__( 'New PPE', 'theepi' );
		$serial_number      = ! empty( $_POST['serial_number'] ) ? sanitize_text_field( $_POST['serial_number'] ) : esc_html__( 'undefined', 'theepi' );
		$commissioning_date = ! empty( $_POST['commissioning_date'] ) ? sanitize_text_field( $_POST['commissioning_date'] ) : esc_html__( '', 'theepi' );
		$last_control       = ! empty( $_POST['last_control'] ) ? sanitize_text_field( $_POST['last_control'] ) : esc_html__( 'No control', 'theepi' );
		$status_epi         = ! empty( $_POST['status_epi'] ) ? sanitize_text_field( $_POST['status_epi'] ) : esc_html__( 'OK', 'theepi' );

		//DONNEE MISE EN SERVICE EPI
		$maker              = ! empty( $_POST['maker'] ) ? sanitize_text_field( $_POST['maker'] ) : esc_html__( 'undefined', 'theepi' );
		$seller             = ! empty( $_POST['seller'] ) ? sanitize_text_field( $_POST['seller'] ) : esc_html__( 'undefined', 'theepi' );
		$manager            = ! empty( $_POST['manager'] ) ? sanitize_text_field( $_POST['manager'] ) : esc_html__( 'undefined', 'theepi' );
		$reference          = ! empty( $_POST['reference'] ) ? sanitize_text_field( $_POST['reference'] ) : esc_html__( 'undefined', 'theepi' );
		$lifetime           = ! empty( $_POST['lifetime'] ) ? (int)( $_POST['lifetime'] ) : get_option( EPI_Class::g()->option_name_default_data_lifetime );
		$periodicity        = ! empty( $_POST['periodicity'] ) ? (int)( $_POST['periodicity'] ) : get_option( EPI_Class::g()->option_name_default_data_periodicity );
		$manufacture_date   = ! empty( $_POST['manufacture_date'] ) ? sanitize_text_field( $_POST['manufacture_date'] ) : '';
		$purchase_date      = ! empty( $_POST['purchase_date'] ) ? sanitize_text_field( $_POST['purchase_date'] ) : '';
		$control_date       = ! empty( $_POST['control_date'] ) ? sanitize_text_field( $_POST['control_date'] ) : '';
		$end_life_date      = ! empty( $_POST['end_life_date'] ) ? sanitize_text_field( $_POST['end_life_date'] ) : '';
		$disposal_date      = ! empty( $_POST['disposal_date'] ) ? sanitize_text_field( $_POST['disposal_date'] ) : '';

		$checked_purchase_date = get_option( EPI_Class::g()->option_name_date_management_purchase_date );
		$manufacture_date_valued = get_option( EPI_Class::g()->option_name_date_management_manufacture_date );

		if( $checked_purchase_date == 1 ) {
			$purchase_date = $commissioning_date;
		}

		if( $manufacture_date_valued != "" ) {
			$manufacture_date = Service_Class::g()->calcul_date_fabrication( $commissioning_date , $manufacture_date_valued );
		}

		$end_life_date = Service_Class::g()->calcul_date_fin_vie( $manufacture_date, $lifetime );
		$control_date = Service_Class::g()->calcul_date_control( $purchase_date, $end_life_date, $commissioning_date, $periodicity );
		$disposal_date = Service_Class::g()->calcul_date_mise_rebut( $end_life_date );

		$epi = EPI_Class::g()->get( array( 'id' => $id ), true );

		$update_epi = array(
			'image_id'                 => $image_id,
			'title'                    => $title,
			'serial_number'            => $serial_number,
			'commissioning_date'       => Service_Class::g()->convert_date_to_sql( $commissioning_date ),
			'commissioning_date_valid' => $commissioning_date != "" ? 1 : 0,
			'last_control'             => $last_control,
			'status_epi'               => $status_epi,

			'maker'                    => $maker,
			'seller'                   => $seller,
			'manager'                  => $manager,
			'reference'                => $reference,
			'lifetime_epi'             => $lifetime,
			'periodicity'              => $periodicity,
			'manufacture_date'         => Service_Class::g()->convert_date_to_sql( $manufacture_date ),
			'manufacture_date_valid'   => $manufacture_date != "" ? 1 : 0,
			'purchase_date'            => Service_Class::g()->convert_date_to_sql( $purchase_date ),
			'purchase_date_valid'      => $purchase_date != "" ? 1 : 0,
			'control_date'             => Service_Class::g()->convert_date_to_sql( $control_date ),
			'end_life_date'            => Service_Class::g()->convert_date_to_sql( $end_life_date ),
			'disposal_date'            => Service_Class::g()->convert_date_to_sql( $disposal_date )
		);

		$date_valid = Service_Class::g()->check_date_epi( $update_epi );
		$view = "";

		if( $date_valid['success'] ){
			$callback_js = 'savedEpiSuccess';
			$epi->data = wp_parse_args( $update_epi, $epi->data );
			$epi = EPI_Class::g()->update( $epi->data );
			$view = EPI_Class::g()->reload_single_epi( $epi );
		}else{
			$callback_js = 'savedEpiError';
		}

		wp_send_json_success(
			array(
				'namespace'         => 'theEPI',
				'module'            => 'EPI',
				'callback_success'  => $callback_js,
				'view'     		    => $view,
				'error'             => $date_valid
			)
		);
	}

	/**
	 * Supprimes un EPI et ses audits.
	 *
	 * @return void
	 *
	 * @since   0.1.0
	 * @version 0.5.0
	 */
	public function callback_delete_epi() {
		check_ajax_referer( 'delete_epi' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : '';

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		EPI_Class::g()->delete( $id );
		$audits = \task_manager\Audit_Class::g()->get( array( 'post_parent' => $id ) );
		foreach ( $audits as $audit ) {
			\task_manager\Audit_Class::g()->update(
				array(
					'id'     => $audit->data['id'],
					'status' => 'trash',
				)
			);
		}

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'EPI',
				'callback_success' => 'deletedEpiSuccess',
			)
		);
	}

	/**
	 * Editer un EPI (mode édition).
	 *
	 * @return void
	 *
	 * @since   0.1.0
	 * @version 0.6.0
	 */
	public function callback_edit_epi() {
		check_ajax_referer( 'edit_epi' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : '';
		$close_epi_id = ! empty( $_POST['closeepi'] ) ? (int) $_POST['closeepi'] : 0;

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		if( $close_epi_id ){
			$close_epi = EPI_Class::g()->get( array( 'id' => $close_epi_id ), true );
			$close_view_epi = EPI_Class::g()->reload_single_epi( $close_epi );
		}else{
			$close_view_epi = "";
		}

		$epi = EPI_Class::g()->get( array( 'id' => $id ), true );

		$checked_purchase_date = get_option( EPI_Class::g()->option_name_date_management_purchase_date );
		$manufacture_date_valued = get_option( EPI_Class::g()->option_name_date_management_manufacture_date );

		ob_start();
		\eoxia\View_Util::exec(
			'theepi', 'epi', 'item-edit', array(
				'epi' => $epi,
			)
		);
		$view_edit_epi = ob_get_clean();

		ob_start();
		\eoxia\View_Util::exec(
			'theepi', 'service', 'main', array(
				'epi'                     => $epi,
				'checked_purchase_date'   => $checked_purchase_date,
				'manufacture_date_valued' => $manufacture_date_valued
			)
		);
		$view_edit_service = ob_get_clean();

		wp_send_json_success(
			array(
				'namespace'         => 'theEPI',
				'module'            => 'EPI',
				'callback_success'  => 'editedEpiSuccess',
				'view_edit_epi'     => $view_edit_epi,
				'view_edit_service' => $view_edit_service,
				'view_close'        => $close_view_epi,
				'close_epi_id'      => $close_epi_id

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
	public function callback_cancel_edit_epi() {
		check_ajax_referer( 'cancel_edit_epi' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		if ( empty( $id ) ) {
			$epi = array();
		} else {
			$epi = EPI_Class::g()->get( array( 'id' => $id ), true );

			ob_start();
			\eoxia\View_Util::exec(
				'theepi', 'epi', 'item', array(
					'epi' => $epi,
				)
			);
		}

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'EPI',
				'callback_success' => 'canceledEditEpiSuccess',
				'view'             => ob_get_clean(),
			)
		);
	}

	/**
	 * Charges les données d'un EPI.
	 *
	 * @since   0.1.0
	 * @version 0.2.0
	 *
	 * @return void
	 */
	public function callback_load_epi() {
		check_ajax_referer( 'load_epi' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$epi = EPI_Class::g()->get(
			array(
				'id' => $id,
			), true
		);

		ob_start();
		\eoxia\View_Util::exec(
			'theepi', 'epi', 'item-edit', array(
				'epi' => $epi,
			)
		);

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'EPI',
				'callback_success' => 'loadedEpiSuccess',
				'template'         => ob_get_clean(),
			)
		);
	}

	/**
	 * Gestion du chargement supplémentaire des EPI.
	 *
	 * @since   0.2.0
	 * @version 0.6.0
	 *
	 * @return void
	 */
	public function callback_load_more_epi() {
		check_ajax_referer( 'load_more_epi' );

		$pagination = ! empty( $_POST['pagination'] ) ? (int) $_POST['pagination'] : 1;
		$page       = ! empty( $_POST['page'] ) ? sanitize_text_field ( $_POST['page'] ) : "";
		$offset     = ! empty( $_POST['offset'] ) ? (int) $_POST['offset'] : 0;
		$term       = ! empty( $_POST['term'] ) ? sanitize_text_field( $_POST['term'] ) : '';

		$pagination_data = EPI_Class::g()->get_pagination_data( $offset, $term );

		$data_epis = EPI_Class::g()->get_epis( $pagination_data, $term , $page);
		$epis = $data_epis['epis'];

		ob_start();
		EPI_Class::g()->display_epi_list( $epis );
		$view = ob_get_clean();

		ob_start();
		EPI_Class::g()->display_epi_pagination( $offset, $page, $pagination );
		$view_pagination = ob_get_clean();

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'EPI',
				'callback_success' => 'loadedMoreEPISuccess',
				'pagination'       => $pagination,
				'view'             => $view,
				'view_pagination'  => $view_pagination
			)
		);
	}

	/**
	 * Recherches tous les EPI.
	 *
	 * @since   0.4.0
	 * @version 0.4.0
	 *
	 * @return void
	 */
	public function callback_search_epi() {
		check_ajax_referer( 'search_epi' );

		$term = ! empty( $_POST['term'] ) ? sanitize_text_field( $_POST['term'] ) : '';

		ob_start();
		EPI_Class::g()->display( $term );
		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'EPI',
				'callback_success' => 'searchedEPISuccess',
				'clear'            => false,
				'view'             => ob_get_clean(),
			)
		);
	}

	/**
	 * Met la recherche à 0.
	 *
	 * @since   0.4.0
	 * @version 0.4.0
	 *
	 * @return void
	 */
	public function callback_clear_search_epi() {
		check_ajax_referer( 'clear_search_epi' );

		ob_start();
		EPI_Class::g()->display();
		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'EPI',
				'callback_success' => 'searchedEPISuccess',
				'clear'            => true,
				'view'             => ob_get_clean(),
			)
		);
	}

	/**
	 * Pour chaque ID de fichier reçu, créer un EPI.
	 *
	 * @since   0.1.0
	 * @version 0.3.0
	 *
	 * @return void
	 * @todo:  nonce
	 */
	public function callback_create_mass_epi() {
		$files_id = ! empty( $_POST['files_id'] ) ? (array) $_POST['files_id'] : array();

		if ( empty( $files_id ) ) {
			wp_send_json_error();
		}

		$epis = EPI_Class::g()->create_mass_epi( $files_id );

		EPI_Class::g()->display_epi_list( $epis );
		wp_die();
	}

	/**
	 * Recharge un EPI.
	 *
	 * @since   0.1.0
	 * @version 0.6.0
	 *
	 * @return object view La vue à recharger.
	 */
	public function reload_epis() {

		$pagination_data = EPI_Class::g()->get_pagination_data( 0, '' );

		$data_epis = EPI_Class::g()->get_epis( $pagination_data, '' );
		$epis = $data_epis['epis'];
		ob_start();
		EPI_Class::g()->display_epi_list( $epis );
		return ob_get_clean();
	}

}

new EPI_Action();
