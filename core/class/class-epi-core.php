<?php
/**
 * Classe principale du plugin.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 0.2.0
 * @copyright 2017 Evarisk
 * @package Digirisk_EPI
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe principale du plugin.
 */
class EPI_Core_Class extends \eoxia\Singleton_Util {

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
		) );

		$epi_schema = $epi_schema[0];

		require PLUGIN_DIGIRISK_EPI_PATH . '/core/view/main.view.php';
	}
}

new EPI_Core_Class();
