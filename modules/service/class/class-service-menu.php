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
class Service_Menu_Class extends \eoxia\Singleton_Util {


	/**
	 * Le constructeur
	 *
	 * @since   0.5.0
	 * @version 0.5.0
	 */
	public function construct() {
	}

	/**
	 * La méthode qui permet d'afficher la page
	 *
	 * @since   0.5.0
	 * @version 0.5.0
	 *
	 * @return void
	 */
	public function display() {
		//$fabricant = get_posts( array( 'post_type' => 'fabricant' ));
		include PLUGIN_THEEPI_PATH . '/modules/service/view/main.view.php';
	}

}

new Service_Menu_Class();
