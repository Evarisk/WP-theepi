<?php
/**
 * Handle Mise en Service
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.5.0
 * @version   0.5.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères toutes les actions lié au menu mise en service d'un EPI.
 */
class Service_Menu_Action {


	/**
	 * Le constructeur
	 *
	 * @since   0.5.0
	 * @version 0.5.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ) , 21);
	}

	public function callback_admin_menu() {
		add_submenu_page( 'theepi', __( 'Mise en Service', 'theepi' ), __( 'Mise en Service', 'theepi' ), 'manage_theepi', 'theepi-s  rvice', array( Service_Menu_Class::g(), 'display' ) );
	}

}

new Service_Menu_Action();
