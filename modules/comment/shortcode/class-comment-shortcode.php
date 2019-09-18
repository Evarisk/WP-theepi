<?php
/**
 * Ajoutes un shortcode permettant d'afficher un commentaire d'un post n'importe ou.
 *
 * @package TheEPI
 * @author Evarisk <dev@evarisk.com>
 * @copyright 2015-2019 Evarisk
 * @since 0.7.0
 * @version 0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes un shortcode permettant d'afficher un commentaire d'un post n'importe ou.
 */
class Comment_Shortcode {

	/**
	 * Le constructeur
	 *
	 * @since 0.7.0
	 * @version 0.7.0
	 */
	public function __construct() {
		add_shortcode( 'theepi_comment', array( $this, 'callback_theepi_comment' ) );
	}

	/**
	 * Appelle la méthode display de Comment_Class
	 *
	 * @param  array $param  Les paramètres du shortcode.
	 * @return void
	 *
	 * @since 0.7.0
	 * @version 0.7.0
	 */
	public function callback_theepi_comment( $param ) {
		Comment_Class::g()->display( $param );
	}
}

new Comment_Shortcode();
