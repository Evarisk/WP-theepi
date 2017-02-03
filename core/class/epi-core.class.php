<?php
/**
 * Appelle la vue principale de l'application
 *
 * @package Evarisk\Plugin
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Appelle la vue permettant d'afficher la navigation
 */
class EPI_Core_Class extends Singleton_Util {

	/**
	 * Le constructeur
	 */
	protected function construct() {
		/**	Création d'une taille d'image dédiée pour les images principales des groupements et unités de travail / Create a deddicated picture size for groups and word unit pictures	*/
		add_image_size( 'digirisk-element-thumbnail', 200, 150, true );
		/**	Création d'une taille d'image dédiée pour les images principales des groupements et unités de travail / Create a deddicated picture size for groups and word unit pictures	*/
		add_image_size( 'digirisk-element-miniature', 50, 50, true );
	}

	/**
	 * La méthode qui permet d'afficher la page
	 *
	 * @return void
	 */
	public function display() {
		$epi_schema = EPI_Class::g()->get( array( 'schema' => true ) );
		$epi_schema = $epi_schema[0];
		require( PLUGIN_DIGIRISK_EPI_PATH . '/core/view/main.view.php' );
	}
}

new EPI_Core_Class();
