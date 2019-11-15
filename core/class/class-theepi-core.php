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

use eoxia\Config_Util;
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

	/**
	 * Récupères le patch note pour la version actuelle.
	 *
	 * @since 6.3.0
	 *
	 * @return array
	 */
	public function get_patch_note() {
		$patch_note_url = 'https://www.evarisk.com/wp-json/eoxia/v1/change_log/' . Config_Util::$init['theepi']->version;

		$json = wp_remote_get( $patch_note_url, array(
			'headers' => array(
				'Content-Type' => 'application/json',
			),
			'verify_ssl' => false,
		) );


		$result = __( 'No update notes for this version.', 'theepi' );

		if ( ! is_wp_error( $json ) && ! empty( $json ) && ! empty( $json['body'] ) ) {
			$result = json_decode( $json['body'] );
		}

		return array(
			'status'  => is_wp_error( $json ) ? false : true,
			'content' => $result,
		);
	}

}

Class_TheEPI_Core::g();
