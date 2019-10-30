<?php
/**
 * Handle Control Filter.
 *
 * @package   TheEPI
 * @author    Evarisk <dev@evarisk.com>
 * @copyright 2019 Evarisk
 * @since     0.7.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle Control Filter.
 */
class Control_Filter {


	/**
	 * Le constructeur.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 */
	public function __construct() {

		$current_type = Control_Class::g()->get_type();
		add_filter( "eo_model_{$current_type}_before_post", '\theepi\construct_identifier', 10, 2 );
		add_filter( "wpeo_upload_view_list_item", array( $this, 'custom_wpeo_upload_view_list_item'), 10, 2 );

	}

	/**
	 * Le filtre pour utilisé une vue personnalisé pour les médias.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @param view  $view La vue de base du framework.
	 *
	 * @return view $view['view'] La vue modifié.
	 */
	public function custom_wpeo_upload_view_list_item( $view ) {
		$view['view'] = PLUGIN_THEEPI_PATH . 'modules/control/view/attached-file.view.php';
		return $view['view'];
	}
}

new Control_Filter();
