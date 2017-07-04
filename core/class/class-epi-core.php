<?php
/**
 * La classe principale de l'application.
 *
 * @package Evarisk\Plugin
 *
 * @since 1.0.0.0
 * @version 1.0.0.0
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Appelle la vue permettant d'afficher la navigation
 */
class EPI_Core_Class extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 1.0.0.0
	 * @version 1.0.0.0
	 */
	protected function construct() {}

	/**
	 * La méthode qui permet d'afficher la page
	 *
	 * @return void
	 *
	 * @since 1.0.0.0
	 * @version 1.0.0.0
	 */
	public function display() {
		$epi_schema = EPI_Class::g()->get( array(
			'schema' => true,
		) );

		$epi_schema = $epi_schema[0];

		require( PLUGIN_DIGIRISK_EPI_PATH . '/core/view/main.view.php' );
	}
}

new EPI_Core_Class();
