<?php
/**
 * Classe principale du plugin.
 *
 * @author    Jimmy Latour <jimmy@evarisk.com>
 * @since     0.1.0
 * @version   0.2.0
 * @copyright 2017 Evarisk
 * @package   TheEPI
 */

namespace theepi;

use eoxia\Singleton_Util;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe principale du plugin.
 */
class Class_TheEPI_Core extends Singleton_Util {


	/**
	 * Le constructeur
	 *
	 * @since   0.1.0
	 * @version 0.1.0
	 */
	protected function construct() {
	}

	/**
	 * La méthode qui permet d'afficher la page
	 *
	 * @since   0.1.0
	 * @version 0.2.0
	 *
	 * @return void
	 */
	public function display() {
		include PLUGIN_THEEPI_PATH . '/core/view/main.view.php';
	}
}

Class_TheEPI_Core::g();
