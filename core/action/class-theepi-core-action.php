<?php
/**
 * Handle main actions.
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
 * Handle main actions.
 */
class TheEPI_Core_Action {

	/**
	 * Le constructeur
	 *
	 * @since 0.1.0
	 * @version 0.1.0
	 */
	public function __construct() {
		// Initialises ses actions que si nous sommes sur une des pages réglés dans le fichier digirisk.config.json dans la clé "insert_scripts_pages".
		$page = ( ! empty( $_REQUEST['page'] ) ) ? sanitize_text_field( $_REQUEST['page'] ) : ''; // WPCS: CSRF ok.

		if ( in_array( $page, \eoxia\Config_Util::$init['theepi']->insert_scripts_pages_css, true ) ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_enqueue_scripts_css' ), 11 );
		}

		if ( in_array( $page, \eoxia\Config_Util::$init['theepi']->insert_scripts_pages_js, true ) ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_before_admin_enqueue_scripts_js' ), 10 );
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_enqueue_scripts_js' ), 11 );
		}

		add_action( 'init', array( $this, 'callback_plugins_loaded' ) );
		add_action( 'admin_init', array( $this, 'callback_admin_init' ) );
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 20 );
	}

	/**
	 * Initialise le fichier style.min.css du plugin Digirisk-EPI.
	 *
	 * @since 0.1.0
	 * @version 0.2.0
	 *
	 * @return void
	 */
	public function callback_admin_enqueue_scripts_css() {
		wp_register_style( 'theepi-style', PLUGIN_THEEPI_URL . 'core/assets/css/style.min.css', array(), \eoxia\Config_Util::$init['theepi']->version );
		wp_enqueue_style( 'theepi-style' );
		wp_enqueue_style( 'theepi-datepicker', PLUGIN_THEEPI_URL . 'core/assets/css/jquery.datetimepicker.css', array(), \eoxia\Config_Util::$init['theepi']->version );
	}

	/**
	 * Initialise les fichiers JS inclus dans WordPress (jQuery, wp.media et thickbox)
	 *
	 * @since 0.1.0
	 * @version 0.1.0
	 *
	 * @return void
	 */
	public function callback_before_admin_enqueue_scripts_js() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-form' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_media();
	}

	/**
	 * Initialise le fichier backend.min.js du plugin.
	 *
	 * @since 0.1.0
	 * @version 0.1.0
	 *
	 * @return void
	 */
	public function callback_admin_enqueue_scripts_js() {
		wp_enqueue_script( 'digi-epi-datetimepicker-script', PLUGIN_THEEPI_URL . 'core/assets/js/jquery.datetimepicker.full.js', array(), \eoxia\Config_Util::$init['theepi']->version );
		wp_enqueue_script( 'digi-epi-script', PLUGIN_THEEPI_URL . 'core/assets/js/backend.min.js', array(), \eoxia\Config_Util::$init['theepi']->version, false );
	}

	/**
	 * Initialise le fichier MO du plugin et les capacitées.
	 *
	 * @since 0.1.0
	 * @version 0.2.0
	 *
	 * @return void
	 */
	public function callback_plugins_loaded() {
	}

	/**
	 * Initialise les capacitées
	 *
	 * @since 0.1.0
	 * @version 0.1.0
	 *
	 * @return void
	 */
	public function callback_admin_init() {
		/** Set capability to subscriber by default */
		$subscriber_role = get_role( 'subscriber' );
		if ( ! $subscriber_role->has_cap( 'manage_theepi' ) ) {
			$subscriber_role->add_cap( 'manage_theepi', false );
		}

		/** Set capability to administrator by default */
		$administrator_role = get_role( 'administrator' );
		if ( ! $administrator_role->has_cap( 'manage_theepi' ) ) {
			$administrator_role->add_cap( 'manage_theepi', true );
		}
	}

	/**
	 * Initialise le sous menu "TheEPI" dans le menu WordPress.
	 *
	 * @since 0.1.0
	 * @version 0.2.0
	 *
	 * @return void
	 */
	public function callback_admin_menu() {
		add_menu_page( __( 'TheEPI', 'theepi' ), __( 'TheEPI', 'theepi' ), 'manage_theepi', 'theepi', array( Class_TheEPI_Core::g(), 'display' ), 'dashicons-admin-tools' );
	}
}

new TheEPI_Core_Action();
