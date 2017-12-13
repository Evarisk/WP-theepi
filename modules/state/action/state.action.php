<?php
/**
 * Les actions relatives aux status.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.3.0
 * @version 0.3.0
 * @copyright 2015-2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives aux status.
 */
class State_Action {

	/**
	 * Le constructeur
	 *
	 * @since 0.3.0
	 * @version 0.3.0
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'callback_admin_init' ) );
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 99 );
	}

	/**
	 * Installes les données par défaut.
	 *
	 * @since 0.3.0
	 * @version 0.3.0
	 *
	 * @return void
	 */
	public function callback_admin_init() {
		$core_option = get_option( \eoxia\Config_Util::$init['theepi']->core_option, array(
			'db_version' => '',
		) );

		if ( empty( $core_option['db_version'] ) ) {

			$file_content = file_get_contents( \eoxia\Config_Util::$init['theepi']->state->path . 'asset/json/default.json' );
			$data         = json_decode( $file_content, true );

			if ( ! empty( $data ) ) {
				foreach ( $data as $category_title ) {
					$category = array(
						'name' => $category_title,
					);

					$category_slug = sanitize_title( $category_title );

					$tax = get_term_by( 'slug', $category_slug, State_Class::g()->get_taxonomy(), ARRAY_A );

					if ( ! empty( $tax['term_id'] ) && is_int( $tax['term_id'] ) ) {
						$category['id'] = $tax['term_id'];
					}

					$category['slug'] = $category_slug;

					State_Class::g()->update( $category );
				}
			}

			$core_option['db_version'] = str_replace( '.', '', \eoxia\Config_Util::$init['theepi']->version );
			update_option( \eoxia\Config_Util::$init['theepi']->core_option, $core_option );
		}
	}

	/**
	 * Initialise le menu pour gérer les status
	 *
	 * @since 0.3.0
	 * @version 0.3.0
	 *
	 * @return void
	 */
	public function callback_admin_menu() {
		add_submenu_page( 'theepi', __( 'State', 'theepi' ), __( 'State', 'theepi' ), 'manage_theepi', 'edit-tags.php?taxonomy=' . State_Class::g()->get_taxonomy() );
	}
}

new State_Action();
