<?php
/**
 * Gestion des shortcodes en relation des qrcodes.
 *
 * @package TheEPI
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2019 Eoxia
 * @since 0.7.0
 * @version 0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des shortcodes en relation des qrcodes.
 */
class Qrcode_Shortcode {

	/**
	 * Constructeur.
	 *
	 * @since 0.7.0
	 * @version 0.7.0
	 */
	public function __construct() {
		add_shortcode( 'qrcode', array( $this, 'callback_qrcode' ) );
	}

	/**
	 * Le shortcode pour afficher les tâches
	 *
	 * @since 0.7.0
	 * @version 0.7.0
	 *
	 * @param  array $param Les paramètres du shortcode.
	 *
	 * @return HTML Le code HTML permettant d'afficher une tâche.
	 */
	public function callback_qrcode( $param ) {
		$uploads = wp_upload_dir();

		extract ( shortcode_atts( array(
			'id'       => '',
			'text'     => '',
			'eclevel'  => 3,
			'height'   => 60,
			'width'    => 60,
			'transparency' => 1,
		), $param ) );

		if ( empty( $text ) ) {
			return;
		}

		$epi = EPI_Class::g()->get( array( 'id' => $id ), true );

		$filename = sha1( $text.$eclevel.$height.$width.$transparency ).'.png';
		$path = $uploads['basedir']. '/theepi/'. $epi->data['type'] . '/' . $epi->data['id'] . '/' . $filename;
		$guid = $uploads['baseurl']. '/theepi/'. $epi->data['type'] . '/' . $epi->data['id'] . '/' . $filename;
		$wp_attached_file = '/theepi/'. $epi->data['type'] . '/' . $epi->data['id'] . '/' . $filename;

		$epi->data['qrcode']['filename'] = $filename;
	 	$epi->data['qrcode']['path'] = $path;
		$epi->data['qrcode']['guid'] = $guid;
		$epi->data['qrcode']['wp_attached_file'] = $wp_attached_file;

		$epi = EPI_Class::g()->update( $epi->data );

		if ( ! is_dir( dirname( $path ) ) ) {
			wp_mkdir_p( dirname( $path ) );
		}

		if ( file_exists( $path ) ) {
			return '<img src="'.esc_attr($guid).'" style="height:'.esc_attr($height).'px; width:'.esc_attr($width).'px" alt="'.esc_attr($text).'" />';
		}

		require_once PLUGIN_THEEPI_PATH . "/core/external/phpqrcode/phpqrcode.php";

		\QRcode::png( $text, $path, 3, 3, 4, false, 0xFFFFFF, 0x000000, $height, $width, $transparency );

		return '<img src="'.esc_attr($guid).'" style="height:'.esc_attr($height).'px; width:'.esc_attr($width).'px" alt="'.esc_attr($text).'" />';
	}
}

new Qrcode_Shortcode();
