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
class EPI_Action {


	/**
	 * Le constructeur.
	 *
	 * @since   0.1.0
	 * @version 0.7.0
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
		add_action( 'wp_ajax_filter_epi', array( $this, 'callback_filter_epi' ) );


		add_action( 'wp_ajax_create_mass_epi', array( $this, 'callback_create_mass_epi' ) );

		add_action( 'wp_ajax_open_qrcode', array( $this, 'callback_open_qrcode' ) );
		add_action( 'wp_ajax_search_users', array( $this, 'callback_search_users' ) );
		//add_action( 'wp_ajax_control_epi_without_task_manager', array( $this, 'callback_control_epi_without_task_manager' ) );

	}

	/**
	 * Affiche un EPI lors de sa création.
	 *
	 * @since   0.5.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	public function callback_create_epi() {
		check_ajax_referer('create_epi');

		if ( ! EPI_Class::g()->check_capabilities( 'create_theepi' ) ) {
			wp_send_json_error();
		}

		$close_epi_id = ! empty( $_POST['closeepi'] ) ? (int) $_POST['closeepi'] : 0;

		if( $close_epi_id ){
			$close_epi = EPI_Class::g()->get( array( 'id' => $close_epi_id ), true );
			$close_view_epi = EPI_Class::g()->reload_single_epi( $close_epi );
		}else{
			$close_view_epi = "";
		}

		$epi = EPI_Class::g()->draft();
		$epi->data['periodicity'] = intval(get_option( EPI_Class::g()->option_name_default_data_periodicity ) );
		$epi->data['lifetime_epi'] = intval( get_option( EPI_Class::g()->option_name_default_data_lifetime ) );
		$epi->data['disposal_date']['raw'] = '1970-01-01';
		$epi->data['unique_identifier'] = EPI_Class::g()->unique_identifier( $epi->data['id'] );
		$epi = EPI_Class::g()->update( $epi->data );

		$checked_purchase_date = get_option( EPI_Class::g()->option_name_date_management_purchase_date );
		$manufacture_date_valued = get_option( EPI_Class::g()->option_name_date_management_manufacture_date );

		ob_start();
		\eoxia\View_Util::exec(
			'theepi', 'epi', 'item-edit', array(
				'epi' => $epi,
				'edit_mode' => false
			)
		);
		$view_edit_epi = ob_get_clean();

		ob_start();
		\eoxia\View_Util::exec(
			'theepi', 'service', 'main', array(
				'epi' => $epi,
				'edit_mode' => false,
				'control' => "",
				'checked_purchase_date'   => $checked_purchase_date,
				'manufacture_date_valued' => $manufacture_date_valued
			)
		);
		$view_edit_service = ob_get_clean();

		wp_send_json_success(
			array(
				'namespace'          => 'theEPI',
				'module'             => 'EPI',
				'callback_success'   => 'CreatedEpiSuccess',
				'epi_id'             => $epi->data['id'],
				'view_edit_epi'      => $view_edit_epi,
				'view_edit_service'  => $view_edit_service,
				'view_close'         => $close_view_epi,
				'close_epi_id'       => $close_epi_id

			)
		);
	}

	/**
	 * Sauvegardes un EPI.
	 *
	 * @since   0.1.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	public function callback_save_epi() {
		check_ajax_referer( 'save_epi' );

		//DONNEES EPI
		$id                 = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$image_id           = ! empty( $_POST['image'] ) ? (int) $_POST['image'] : 0;
		$quantity         	= ! empty( $_POST['quantity'] ) ? (int) $_POST['quantity'] : 1;
		$title              = ! empty( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : esc_html__( 'New PPE', 'theepi' );
		$serial_number      = ! empty( $_POST['serial_number'] ) ? sanitize_text_field( $_POST['serial_number'] ) : '';
		//$last_control       = ! empty( $_POST['last_control'] ) ? sanitize_text_field( $_POST['last_control'] ) : esc_html__( 'No control', 'theepi' );
		$status_epi         = ! empty( $_POST['status_epi'] ) ? sanitize_text_field( $_POST['status_epi'] ) : 'OK';

		//DONNEES DATES EPI
		$toggle_lifetime    = ! empty( $_POST['toggle_lifetime'] ) ? sanitize_text_field( $_POST['toggle_lifetime'] ) : 'YES';
		$manufacture_date   = ! empty( $_POST['manufacture_date'] ) ? sanitize_text_field( $_POST['manufacture_date'] ) : '';
		$lifetime           = ! empty( $_POST['lifetime'] ) ? (int)( $_POST['lifetime'] ) : get_option( EPI_Class::g()->option_name_default_data_lifetime );
		$end_life_date      = ! empty( $_POST['end_life_date'] ) ? sanitize_text_field( $_POST['end_life_date'] ) : '';
		$disposal_date      = ! empty( $_POST['disposal_date'] ) ? sanitize_text_field( $_POST['disposal_date'] ) : '';

		//DONNEES FICHE DE VIE EPI
		$purchase_date      = ! empty( $_POST['purchase_date'] ) ? sanitize_text_field( $_POST['purchase_date'] ) : '';
		$commissioning_date = ! empty( $_POST['commissioning_date'] ) ? sanitize_text_field( $_POST['commissioning_date'] ) : '';
		$periodicity        = ! empty( $_POST['periodicity'] ) ? (int)( $_POST['periodicity'] ) : get_option( EPI_Class::g()->option_name_default_data_periodicity );
		$control_date       = ! empty( $_POST['control_date'] ) ? sanitize_text_field( $_POST['control_date'] ) : '';

		//DONNEES ADDITIONNELLES
		$maker              = ! empty( $_POST['maker'] ) ? sanitize_text_field( $_POST['maker'] ) : '';
		$seller             = ! empty( $_POST['seller'] ) ? sanitize_text_field( $_POST['seller'] ) : '';
		$manager            = ! empty( $_POST['manager'] ) ? (int) ( $_POST['manager'] ) : 0;
		$reference          = ! empty( $_POST['reference'] ) ? sanitize_text_field( $_POST['reference'] ) : '';
		$url_notice         = ! empty( $_POST['url_notice'] ) ? sanitize_text_field( $_POST['url_notice'] ) : '';

		if ( empty( get_option( EPI_Class::g()->option_name_default_data_lifetime ) ) && empty( $lifetime ) ) {
			$lifetime = 0;
		}

		if ( empty( get_option( EPI_Class::g()->option_name_default_data_periodicity ) ) && empty( $periodicity ) ) {
			$periodicity = 0;
		}

		$checked_purchase_date = get_option( EPI_Class::g()->option_name_date_management_purchase_date );
		$manufacture_date_valued = get_option( EPI_Class::g()->option_name_date_management_manufacture_date );

		$manufacture_date = Service_Class::g()->check_date_if_empty( $manufacture_date );
		$purchase_date = Service_Class::g()->check_date_if_empty( $purchase_date );
		$commissioning_date = Service_Class::g()->check_date_if_empty( $commissioning_date );

		if( $checked_purchase_date == 1 && empty( $purchase_date ) ) {
			$purchase_date = $commissioning_date;
		}

		if( $manufacture_date_valued != "" && empty ( $manufacture_date ) ) {
			$manufacture_date = Service_Class::g()->calcul_manufacture_date( $commissioning_date , $manufacture_date_valued );
		}

		$end_life_date = Service_Class::g()->calcul_end_life_date( $manufacture_date, $lifetime );
		$control_date = Service_Class::g()->calcul_control_date( $commissioning_date, $periodicity );
		//$disposal_date = Service_Class::g()->calcul_disposal_date( $end_life_date );

		$epi = EPI_Class::g()->get( array( 'id' => $id ), true );
		unset( $epi->data['author_id'] );

		$update_epi = array(
			'post_status'              => 'publish',
			'author_id'                => get_current_user_id(),

			'title'                    => $title,
			'quantity'                 => $quantity,
			'serial_number'            => $serial_number,
			//'last_control'             => $last_control,
			'status_epi'               => $status_epi,

			'toggle_lifetime'          => $toggle_lifetime,
			'manufacture_date'         => date ( 'Y-m-d' , $manufacture_date ),
			'manufacture_date_valid'   => $manufacture_date != "" ? 1 : 0,
			'lifetime_epi'             => $lifetime,
			'end_life_date'            => date ( 'Y-m-d' , $end_life_date ),

			'purchase_date'            => date ( 'Y-m-d' , $purchase_date ),
			'purchase_date_valid'      => $purchase_date != "" ? 1 : 0,
			'commissioning_date'       => date ( 'Y-m-d' , $commissioning_date ),
			'commissioning_date_valid' => $commissioning_date != "" ? 1 : 0,
			'periodicity'              => $periodicity,
			'control_date'             => date ( 'Y-m-d' , $control_date ),

			'maker'                    => $maker,
			'seller'                   => $seller,
			'manager'                  => $manager,
			'reference'                => $reference,
			'url_notice'               => $url_notice,
		);

		if ( ! empty( $disposal_date ) || $disposal_date != "" ) {
			$update_epi['disposal_date'] = $disposal_date;
		}else {
			$update_epi['disposal_date'] = date( 'Y-m-d', strtotime( 0 ) );
		}

		if ( $toggle_lifetime == 'NO') {
			unset( $update_epi['lifetime_epi'] );
			unset( $update_epi['end_life_date'] );
			$date_valid['success'] = true;
		} else {
			$date_valid = Service_Class::g()->check_date_epi( $update_epi );
		}

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
				'error'             => ! empty( $date_valid[ 'error' ] ) ? $date_valid[ 'error' ] : ''
			)
		);
	}

	/**
	 * Supprimes un EPI et ses audits.
	 *
	 * @return void
	 *
	 * @since   0.1.0
	 * @version 0.7.0
	 */
	public function callback_delete_epi() {
		check_ajax_referer( 'delete_epi' );

		if ( ! EPI_Class::g()->check_capabilities( 'delete_theepi' ) ) {
			wp_send_json_error();
		}

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : '';

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		EPI_Class::g()->delete( $id );

		//Version 2
		// $audits = \task_manager\Audit_Class::g()->get( array( 'post_parent' => $id ) );
		// foreach ( $audits as $audit ) {
		// 	\task_manager\Audit_Class::g()->update(
		// 		array(
		// 			'id'     => $audit->data['id'],
		// 			'status' => 'trash',
		// 		)
		// 	);
		// }

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
	 * @version 0.7.0
	 */
	public function callback_edit_epi() {
		check_ajax_referer( 'edit_epi' );

		if ( ! EPI_Class::g()->check_capabilities( 'update_theepi' ) ) {
			wp_send_json_error();
		}

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

		$controls = Control_Class::g()->get( array( 'post_parent' => $id ) );
		$control = Control_Class::g()->last_control_epi( $controls );

		ob_start();
		\eoxia\View_Util::exec(
			'theepi', 'epi', 'item-edit', array(
				'epi' => $epi,
				'edit_mode' => true
			)
		);
		$view_edit_epi = ob_get_clean();

		ob_start();
		\eoxia\View_Util::exec(
			'theepi', 'service', 'main', array(
				'epi'                     => $epi,
				'edit_mode' => true,
				'control' => $control,
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
			if ( $epi->data['status'] == 'draft' ) {
				EPI_Class::g()->delete( $id );
				$callback = 'deletedEpiSuccess';
				$view = "";
			}else {
				ob_start();
				\eoxia\View_Util::exec(
					'theepi', 'epi', 'item', array(
						'epi' => $epi,
					)
				);
				$view = ob_get_clean();
				$callback = 'canceledEditEpiSuccess';
			}
		}

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'EPI',
				'callback_success' => $callback,
				'view'             => $view,
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
				'edit_mode' => true,
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
		EPI_Class::g()->display_epi_list( $epis, false,  $page );
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
	 * Filtre les EPIS en fonction du statut.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	public function callback_filter_epi() {
		check_ajax_referer( 'filter_epi' );

		$filters = ! empty( $_POST['filters'] ) ? sanitize_text_field( $_POST['filters'] ) : 'all';
		$url = admin_url( 'admin.php?page=theepi&tab='. $filters );

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'EPI',
				'callback_success' => 'filterEPISuccess',
				'url'              => $url,
				'filters'          => $filters,
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

		if ( ! EPI_Class::g()->check_capabilities( 'create_theepi' ) ) {
			wp_send_json_error();
		}

		$files_id = ! empty( $_POST['files_id'] ) ? (array) $_POST['files_id'] : array();

		if ( empty( $files_id ) ) {
			wp_send_json_error();
		}

		$epis = EPI_Class::g()->create_mass_epi( $files_id );

		EPI_Class::g()->display_epi_list( $epis, false, '');
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

	/**
	 * Affiche la vue modal du qrcode.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	public function callback_open_qrcode() {
		check_ajax_referer( 'open_qrcode' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$url = ! empty( $_POST['url'] ) ? sanitize_text_field( $_POST['url'] ) : "";

		$epi = EPI_Class::g()->get( array( 'id' => $id ) , true );

		ob_start();
		\eoxia\View_Util::exec(
			'theepi', 'epi', 'modal', array(
				'epi' => $epi,
				'url' => $url
			)
		);
		$view = ob_get_clean();

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'EPI',
				'callback_success' => 'openQrCode',
				'view'             => $view
			)
		);
	}

	/**
	 * Cherche dans la BDD tous les users.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	public function callback_search_users() {
		$term = ! empty( $_POST['term'] ) ? sanitize_text_field( $_POST['term'] ) : '';
        if ( empty( $term ) ) {
            wp_send_json_error();
        }
        $user_query = new \WP_User_Query( array(
            'role'           => '',
            'search'         => '' . $s . '',
            'search_columns' => array(
                'user_login',
                'user_nicename',
                'user_email',
            ),
        ) );
        $users = $user_query->results;

        ob_start();
        foreach ( $users as $user ) :
            ?>
            <li data-id="<?php echo esc_attr( $user->ID ); ?>" data-result="<?php echo esc_html( $user->display_name ); ?>" class="autocomplete-result">
                <?php echo get_avatar( $user->ID, 32, '', '', array( 'class' => 'autocomplete-result-image autocomplete-image-rounded' ) ); ?>
                <div class="autocomplete-result-container">
                    <span class="autocomplete-result-title"><?php echo esc_html( $user->display_name ); ?></span>
                    <span class="autocomplete-result-subtitle"><?php echo esc_html( $user->user_email ); ?></span>
                </div>
            </li>
            <?php
        endforeach;
        wp_send_json_success( array(
            'view' => ob_get_clean(),
        ) );
	}

	//VERSION 2 TASK-MANAGER
	// public function callback_control_epi_without_task_manager() {
	// 	check_ajax_referer( 'control_epi_without_task_manager' );
	//
	// 	$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
	// 	$epi = EPI_Class::g()->get( array( 'id' => $id ) , true );
	//
	// 	do_shortcode( '[theepi_comment id="' . $epi->data['id'] . '" namespace="theepi" type="EPI_Comment" display="view"]' );
	// }

}

new EPI_Action();
