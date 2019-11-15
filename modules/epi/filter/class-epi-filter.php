<?php
/**
 * Handle EPI Filter.
 *
 * @package   TheEPI
 * @author    Evarisk <dev@evarisk.com>
 * @copyright 2019 Evarisk
 * @since     0.2.0
 * @version   0.7.0
 */

namespace theepi;

use eoxia\View_Util;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle EPI Filter.
 */
class EPI_Filter {

	/**
	 * Le constructeur.
	 *
	 * @since   0.1.0
	 * @version 0.7.0
	 */
	public function __construct() {
		add_filter( 'set-screen-option', array( $this, 'callback_set_screen_option' ), 10, 3 );

		$current_type = EPI_Class::g()->get_type();
		add_filter( "eo_model_{$current_type}_before_post", '\theepi\construct_identifier', 10, 2 );
		add_filter( 'the_content', array( $this, 'callback_display_epi' ), 10, 2 );
		add_filter( "eo_model_{$current_type}_register_post_type_args", array( $this, 'custom_init_post_type' ), 20, 2 );
	}

	/**
	 * Sauvegardes les options de l'écran.
	 *
	 * @since   0.2.0
	 * @version 0.3.0
	 *
	 * @param mixed  $status J'sais pas.
	 * @param string $option Le nom de l'option.
	 * @param string $value  La valeur de l'option.
	 *
	 * @return mixed $status J'sais pas.
	 */
	public function callback_set_screen_option( $status, $option, $value ) {
		if ( EPI_Class::g()->option_name_per_page === $option ) {
			return $value;
		}

		return $status;
	}

	/**
	 * Sauvegardes les options de l'écran.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @param view $content Le contenu da la page en frontend.
	 *
	 * @return view $content Le nouveau contenu da la page en frontend.
	 */
	public function callback_display_epi( $content ) {
		global $post;
		if ( 'theepi-epi' === $post->post_type ) {
			$id = $post->ID;
			ob_start();
			$epi = EPI_Class::g()->get( array( 'id' => $id ), true );
			View_Util::exec(
				'theepi',
				'epi',
				'frontend/main',
				array(
					'epi' => $epi,
				)
			);
			$content = ob_get_clean();
		}
		return $content;
	}

	/**
	 * Filtre pour accéder au post de l'EPI grâce au qrcode.
	 *
	 * @since   0.6.0
	 * @version 0.6.0
	 *
	 * @param array $args les données d'un Post.
	 *
	 * @return array $return Les données du Post EPI modifié.
	 */
	public function custom_init_post_type( $args ) {
		$current_type = EPI_Class::g()->get_type();
		$new_args     = array(
			'public'       => true,
			'show_in_menu' => false,
		);
		$args         = wp_parse_args( $new_args, $args );
		$return       = register_post_type( $current_type, $args );

		return $return;
	}

}

new EPI_Filter();
