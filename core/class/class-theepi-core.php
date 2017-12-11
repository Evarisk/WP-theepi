<?php
/**
 * Classe principale du plugin.
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
 * Classe principale du plugin.
 */
class Class_TheEPI_Core extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 0.1.0
	 * @version 0.1.0
	 */
	protected function construct() {}

	/**
	 * La méthode qui permet d'afficher la page
	 *
	 * @return void
	 *
	 * @since 0.1.0
	 * @version 0.2.0
	 */
	public function display() {
		$epi_schema = EPI_Class::g()->get( array(
			'schema' => true,
		), true );

		require PLUGIN_THEEPI_PATH . '/core/view/main.view.php';
	}
}

new Class_TheEPI_Core();
