<?php
/**
 * La classe principale de l'application.
 *
 * @package Evarisk\Plugin
 *
 * @since 0.0.0.1
 * @version 0.0.0.1
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Appelle la vue permettant d'afficher la navigation
 */
class EPI_Core_Class extends Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 0.0.0.1
	 * @version 0.0.0.1
	 */
	protected function construct() {}

	/**
	 * La méthode qui permet d'afficher la page
	 *
	 * @return void
	 *
	 * @since 0.0.0.1
	 * @version 0.0.0.1
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
