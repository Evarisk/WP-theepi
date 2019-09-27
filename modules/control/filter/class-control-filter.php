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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle EPI Filter.
 */
class Control_Filter {


	/**
	 * Le constructeur.
	 *
	 * @since   0.1.0
	 * @version 0.7.0
	 */
	public function __construct() {

		add_filter( "wpeo_upload_view_list_item", array( $this, 'custom_wpeo_upload_view_list_item'), 10, 2 );

	}

	public function custom_wpeo_upload_view_list_item( $view ) {

		//$control = Control_Class::g()->get( array( 'id' => $view['post_id'] ), true );
		//
		// $data_media = array(
		// 	'filename_only' => '',
		// 	'fileurl_only' => '',
		// 	'field_name' => '',
		// 	'file_id' => ''
		// );
		//
		// $data_media['filename_only'] = $view['filename_only'];
		// $data_media['fileurl_only'] = $view['fileurl_only'];
		// $data_media['field_name'] = $view['field_name'];
		// $data_media['file_id'] = $view['file_id'];
		// $control->data['associated_document_id']['media'] = $data_media;
		//
		// $control = Control_Class::g()->update( $control->data );

		$view['view'] = PLUGIN_THEEPI_PATH . 'modules/control/view/attached-file.view.php';
		return $view['view'];
	}
}

new Control_Filter();
