<?php
/**
 * Handle Setting Filter.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.2.0
 * @version 0.2.0
 * @copyright 2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle Setting Filter.
 */
class Setting_Filter {

	/**
	 * Le constructeur
	 *
	 * @since 0.1.0
	 * @version 0.2.0
	 */
	public function __construct() {
		add_filter( 'set-screen-option', array( $this, 'callback_set_screen_option' ), 10, 3 );
	}

	/**
	 * Sauvegardes les options de l'écran.
	 *
	 * @since 0.2.0
	 * @version 0.2.0
	 *
	 * @param mixed  $status J'sais pas.
	 * @param string $option Le nom de l'option.
	 * @param string $value  La valeur de l'option.
	 *
	 * @return mixed $status J'sais pas.
	 */
	public function callback_set_screen_option( $status, $option, $value ) {
		if ( Setting_Class::g()->option_name === $option ) {
			return $value;
		}

		return $status;
	}
}

new Setting_Filter();
