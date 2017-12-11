<?php
/**
 * Les actions relatives aux réglages de TheEPI.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.2.0
 * @version 0.2.0
 * @copyright 2015-2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives aux réglages de TheEPI.
 */
class Setting_Action {

	/**
	 * Le constructeur
	 *
	 * @since 0.2.0
	 * @version 0.2.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'wp_ajax_save_capability_theepi', array( $this, 'callback_save_capability_theepi' ) );

		add_action( 'display_setting_user_theepi', array( $this, 'callback_display_setting_user_theepi' ), 10, 2 );
		add_action( 'wp_ajax_paginate_setting_theepi_page_user', array( $this, 'callback_paginate_setting_theepi_page_user' ) );
	}

	/**
	 * La fonction de callback de l'action admin_menu de WordPress
	 *
	 * @return void
	 *
	 * @since 0.2.0
	 * @version 0.2.0
	 */
	public function admin_menu() {
		$hook = add_options_page( __( 'TheEPI', 'theepi' ), __( 'TheEPI', 'theepi' ), 'manage_theepi', 'theepi-setting', array( $this, 'add_option_page' ) );
		add_action( 'load-' . $hook, array( Setting_Class::g(), 'callback_add_screen_option' ) );
	}

	/**
	 * Appelle la vue main du module setting avec la liste des accronymes
	 * et la liste des catégories de risque prédéfinies.
	 *
	 * @since 0.2.0
	 * @version 0.2.0
	 */
	public function add_option_page() {
		$default_tab = ! empty( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'digi-capability';

		\eoxia\View_Util::exec( 'theepi', 'setting', 'main', array(
			'default_tab' => $default_tab,
		) );
	}

	/**
	 * Rajoutes la capacité "manage_theepi" à tous les utilisateurs ou $have_capability est à true.
	 *
	 * @since 0.2.0
	 * @version 0.2.0
	 *
	 * @return void
	 */
	public function callback_save_capability_theepi() {
		check_ajax_referer( 'save_capability_theepi' );

		if ( ! empty( $_POST['users'] ) ) {
			foreach ( $_POST['users'] as $user_id => $data ) {
				$user = new \WP_User( $user_id );

				if ( 'true' == $data['capability'] ) {
					$user->add_cap( 'manage_theepi' );
				} else {
					$user->remove_cap( 'manage_theepi' );
				}
			}
		}

		wp_send_json_success( array(
			'namespace'        => 'theEPI',
			'module'           => 'setting',
			'callback_success' => 'savedCapability',
		) );
	}

	/**
	 * Méthode appelé par le champs de recherche dans la page "digirisk-epi"
	 *
	 * @param  integer $id           L'ID de la société.
	 * @param  array   $list_user_id Le tableau des ID des évaluateurs trouvés par la recherche.
	 * @return void
	 *
	 * @since 0.2.0
	 * @version 0.2.0
	 */
	public function callback_display_setting_user_theepi( $id, $list_user_id ) {
		ob_start();
		Setting_Class::g()->display_user_list_capacity( $list_user_id );

		wp_send_json_success( array(
			'template' => ob_get_clean(),
		) );
	}

	/**
	 * Gestion de la pagination
	 *
	 * @since 0.2.0
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
