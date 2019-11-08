<?php
/**
 * Les actions relatives aux réglages de TheEPI.
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.2.0
 * @version   0.6.0
 */

namespace theepi;

use eoxia\Custom_Menu_Handler as CMH;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives aux réglages de TheEPI.
 */
class Setting_Action {


	/**
	 * Le constructeur.
	 *
	 * @since   0.2.0
	 * @version 0.7.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 20 );
		add_action( 'wp_ajax_save_capability_theepi', array( $this, 'callback_save_capability_theepi' ) );
		add_action( 'wp_ajax_save_default_data', array( $this, 'callback_save_default_data' ) );
		add_action( 'wp_ajax_save_date_management', array( $this, 'callback_save_date_management' ) );
		add_action( 'wp_ajax_save_acronym', array( $this, 'callback_save_acronym' ) );

		add_action( 'display_setting_user_theepi', array( $this, 'callback_display_setting_user_theepi' ), 10, 2 );
		add_action( 'wp_ajax_paginate_setting_theepi_page_user', array( $this, 'callback_paginate_setting_theepi_page_user' ) );
	}

	/**
	 * La fonction de callback de l'action admin_menu de WordPress.
	 *
	 * @since   0.2.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	public function admin_menu() {
		CMH::register_menu( 'theepi', __( 'Setting', 'theepi' ), __( 'Setting', 'theepi' ), 'manage_theepi', 'theepi-setting', array( $this, 'add_option_page' ), 'fas fa-cog' );
		//add_action( 'load-' . $hook, array( Setting_Class::g(), 'callback_add_screen_option' ) );
	}

	/**
	 * Appelle la vue main du module setting.
	 *
	 * @since   0.2.0
	 * @version 0.7.0
	 *
	 * @return void
	 * @todo:  nonce
	 */
	public function add_option_page() {
		$page = ! empty( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'capability';

		// default-data.
		$default_periodicity = get_option( EPI_Class::g()->option_name_default_data_periodicity );
		$default_lifetime    = get_option( EPI_Class::g()->option_name_default_data_lifetime );

		// date-management.
		$default_purchase_date    = get_option( EPI_Class::g()->option_name_date_management_purchase_date );
		$default_manufacture_date = get_option( EPI_Class::g()->option_name_date_management_manufacture_date );

		// acronym.
		$default_acronym_site    = get_option( EPI_Class::g()->option_name_acronym_site );
		$default_acronym_epi     = get_option( EPI_Class::g()->option_name_acronym_epi );
		$default_acronym_control = get_option( Control_Class::g()->option_name_acronym_control );


		\eoxia\View_Util::exec(
			'theepi',
			'setting',
			'main',
			array(
				'page'                     => $page,
				'default_periodicity'      => $default_periodicity,
				'default_lifetime'         => $default_lifetime,
				'default_purchase_date'    => $default_purchase_date,
				'default_manufacture_date' => $default_manufacture_date,
				'default_acronym_site'     => $default_acronym_site,
				'default_acronym_epi'      => $default_acronym_epi,
				'default_acronym_control'  => $default_acronym_control,
			)
		);
	}

	/**
	 * Rajoutes la capacité "manage_theepi" à tous les utilisateurs ou $have_capability est à true.
	 *
	 * @since   0.2.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	public function callback_save_capability_theepi() {
		check_ajax_referer( 'save_capability_theepi' );

		if ( ! empty( $_POST['users'] ) ) {
			foreach ( $_POST['users'] as $user_id => $data ) {
				$user = new \WP_User( $user_id );

				$capabilities = array( 'create_theepi', 'read_theepi', 'update_theepi', 'delete_theepi' );

				foreach ( $capabilities as $value ) {
					if ( 'true' === $data[ $value ] ) {
						$user->add_cap( $value );
					} else {
						$user->remove_cap( $value );
					}
				}
			}
		}

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'setting',
				'callback_success' => 'savedCapability',
			)
		);
	}

	/**
	 * Enregistres les données par défaut.
	 *
	 * @since   0.2.0
	 * @version 0.6.0
	 *
	 * @return void
	 */
	public function callback_save_default_data() {
		check_ajax_referer( 'save_default_data' );

		$default_periodicity = ! empty( $_POST['default-periodicity'] ) ? sanitize_text_field( wp_unslash( $_POST['default-periodicity'] ) ) : '';
		$default_lifetime    = ! empty( $_POST['default-lifetime'] ) ? sanitize_text_field( wp_unslash( $_POST['default-lifetime'] ) ) : '';

		Setting_Class::g()->save_default_data( $default_periodicity, $default_lifetime );

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'setting',
				'callback_success' => 'savedDefaultData',
			)
		);
	}

	/**
	 * Enregistres les données par défaut de la gestion des dates.
	 *
	 * @since   0.2.0
	 * @version 0.6.0
	 *
	 * @return void
	 */
	public function callback_save_date_management() {
		check_ajax_referer( 'save_date_management' );

		$default_purchase_date    = ! empty( $_POST['checkbox-purchase-date'] && $_POST['checkbox-purchase-date'] === "true" ) ? true : false;
		$default_manufacture_date = ! empty( $_POST['default-manufacture-date'] ) ? sanitize_text_field( wp_unslash( $_POST['default-manufacture-date'] ) ): '';

		Setting_Class::g()->save_date_management( $default_purchase_date, $default_manufacture_date );

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'setting',
				'callback_success' => 'savedDateManagement',
			)
		);
	}

	/**
	 * Enregistres les données par défaut de la gestion des acronymes.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	public function callback_save_acronym() {
		check_ajax_referer( 'save_acronym' );

		$default_acronym_site    = ! empty( $_POST['default-acronym-site'] ) ? sanitize_text_field( wp_unslash( $_POST['default-acronym-site'] ) ) : '';
		$default_acronym_epi     = ! empty( $_POST['default-acronym-epi'] ) ? sanitize_text_field( wp_unslash( $_POST['default-acronym-epi'] ) ) : '';
		$default_acronym_control = ! empty( $_POST['default-acronym-control'] ) ? sanitize_text_field( wp_unslash( $_POST['default-acronym-control'] ) ) : '';

		update_option( EPI_Class::g()->option_name_acronym_site, $default_acronym_site );
		update_option( EPI_Class::g()->option_name_acronym_epi, $default_acronym_epi );
		update_option( Control_Class::g()->option_name_acronym_control, $default_acronym_control );

		wp_send_json_success(
			array(
				'namespace'        => 'theEPI',
				'module'           => 'setting',
				'callback_success' => 'savedAcronym',
			)
		);
	}


	/**
	 * Méthode appelé par le champs de recherche dans la page "theepi".
	 *
	 * @param  integer $id           L'ID de la société.
	 * @param  array   $list_user_id Le tableau des ID des évaluateurs trouvés par la recherche.
	 * @return void
	 *
	 * @since   0.2.0
	 * @version 0.2.0
	 */
	public function callback_display_setting_user_theepi( $id, $list_user_id ) {
		ob_start();

		Setting_Class::g()->display_user_list_capacity( $list_user_id );

		wp_send_json_success(
			array(
				'template' => ob_get_clean(),
			)
		);
	}

	/**
	 * Gestion de la pagination.
	 *
	 * @since   0.2.0
	 * @version 0.2.0
	 *
	 * @return void
	 */
	public function callback_paginate_setting_theepi_page_user() {
		Setting_Class::g()->display_user_list_capacity();
		wp_die();
	}
}

new Setting_Action();
