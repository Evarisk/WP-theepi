<?php
/**
 * Initialise les actions princiaples de Digirisk EPI
 *
 * @package Evarisk\Plugin
 *
 * @since 0.0.0.1
 * @version 0.0.0.1
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

/**
 * Initialise les actions princiaples de Digirisk EPI
 */
class EPI_Core_Action {

	/**
	 * Le constructeur ajoutes les actions WordPress suivantes:
	 * admin_enqueue_scripts (Pour appeller les scripts JS et CSS dans l'admin)
	 * admin_print_scripts (Pour appeler les scripts JS en bas du footer)
	 * plugins_loaded (Pour appeler le domaine de traduction)
	 *
	 * @since 0.0.0.1
	 * @version 0.0.0.1
	 */
	public function __construct() {
		// Initialises ses actions que si nous sommes sur une des pages réglés dans le fichier digirisk.config.json dans la clé "insert_scripts_pages".
		$page = ( ! empty( $_REQUEST['page'] ) ) ? sanitize_text_field( $_REQUEST['page'] ) : ''; // WPCS: CSRF ok.

		if ( in_array( $page, Config_Util::$init['digirisk-epi']->insert_scripts_pages_css, true ) ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_before_admin_enqueue_scripts_css' ), 10 );
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_enqueue_scripts_css' ), 11 );
		}

		if ( in_array( $page, Config_Util::$init['digirisk-epi']->insert_scripts_pages_js, true ) ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_before_admin_enqueue_scripts_js' ), 10 );
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_enqueue_scripts_js' ), 11 );
			add_action( 'admin_print_scripts', array( $this, 'callback_admin_print_scripts_js' ) );
		}

		add_action( 'init', array( $this, 'callback_plugins_loaded' ) );
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 20 );
	}

	/**
	 * Initialise les fichiers CSS inclus dans WordPress (jQuery, wp.media et thickbox)
	 *
	 * @return void nothing
	 *
	 * @since 0.0.0.1
	 * @version 0.0.0.1
	 */
	public function callback_before_admin_enqueue_scripts_css() {}

	/**
	 * Initialise le fichier style.min.css du plugin Digirisk-EPI.
	 *
	 * @return void nothing
	 *
	 * @since 0.0.0.1
	 * @version 0.0.0.1
	 */
	public function callback_admin_enqueue_scripts_css() {}

	/**
	 * Initialise les fichiers JS inclus dans WordPress (jQuery, wp.media et thickbox)
	 *
	 * @return void nothing
	 *
	 * @since 0.0.0.1
	 * @version 0.0.0.1
	 */
	public function callback_before_admin_enqueue_scripts_js() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-form' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
	}

	/**
	 * Initialise le fichier backend.min.js du plugin Digirisk-EPI.
	 *
	 * @return void nothing
	 *
	 * @since 0.0.0.1
	 * @version 0.0.0.1
	 */
	public function callback_admin_enqueue_scripts_js() {
		wp_enqueue_script( 'digi-epi-script', PLUGIN_DIGIRISK_EPI_URL . 'core/assets/js/backend.min.js', array(), Config_Util::$init['digirisk-epi']->version, false );
	}

	/**
	 * Initialise en php le fichier permettant la traduction des variables string JavaScript.
	 *
	 * @return void nothing
	 *
	 * @since 0.0.0.1
	 * @version 0.0.0.1
	 */
	public function callback_admin_print_scripts_js() {}

	/**
	 * Initialise le fichier MO du plugin
	 *
	 * @since 0.0.0.1
	 * @version 0.0.0.1
	 */
	public function callback_plugins_loaded() {
	}

	/**
	 * Initialise le sous menu "EPI" dans le menu Digirisk.
	 *
	 * @return void
	 * @since 0.0.0.1
	 * @version 0.0.0.1
	 */
	public function callback_admin_menu() {
		add_submenu_page( 'digirisk-simple-risk-evaluation', __( 'EPI', 'digirisk' ), __( 'EPI', 'digirisk' ), 'manage_options', 'digirisk-epi', array( EPI_Core_Class::g(), 'display' ) );
	}
}

new EPI_Core_Action();
