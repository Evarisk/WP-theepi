<?php
/**
 * Gestion des shortcodes des avatars.
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.7.0
 * @version   0.7.0
 */

namespace theepi;

use eoxia\View_Util;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des avatars.
 */
class Avatar_Shortcode {

	/**
	 * Déclaration des shortcodes pour les avatars des utilisateurs.
	 */
	public function __construct() {
		add_shortcode( 'theepi_avatar', array( $this, 'callback_theepi_avatar' ) );
	}

	/**
	 * Définition du callback pour l'affichage des avatars des utilisateurs.
	 *
	 * @param  array $param Les paramètres passés au shortcode.
	 *
	 * @return string  L'affichage de l'avater correspondant aux paramètres demandés.
	 */
	public function callback_theepi_avatar( $param ) {
		$param = shortcode_atts(
			array(
				'size' => 50,
				'ids'  => '',
			),
			$param,
			'theepi_avatar'
		);

		$users = Avatar_Class::g()->get_avatars( $param );

		ob_start();
		View_Util::exec(
			'theepi',
			'avatar',
			'avatar',
			array(
				'users' => $users,
				'size'  => $param['size'],
			)
		);

		return ob_get_clean();
	}
}

new Avatar_Shortcode();
