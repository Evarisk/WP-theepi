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
	 * Le shortcode pour afficher le qrcode
	 *
	 * @since 0.7.0
	 * @version 0.7.0
	 *
	 * @param  array $param Les paramètres du shortcode.
	 *
	 * @return string Le code HTML permettant d'afficher un qrcode.
	 */
	public function callback_qrcode( $param ) {
		$uploads = wp_upload_dir();

		$param = shortcode_atts(
			array(
				'id'           => '',
				'text'         => '',
				'eclevel'      => 3,
				'height'       => 120,
				'width'        => 120,
				'transparency' => 1,
			),
			$param,
			'qrcode'
		);

		$epi      = EPI_Class::g()->get( array( 'id' => $param['id'] ), true );
		$filename = sha1( $param['text'] . $param['eclevel'] . $param['height'] . $param['width'] . $param['transparency'] ) . '.png';

		$path             = $uploads['basedir'] . '/theepi/' . $epi->data['type'] . '/' . $epi->data['id'] . '/' . $filename;
		$guid             = $uploads['baseurl'] . '/theepi/' . $epi->data['type'] . '/' . $epi->data['id'] . '/' . $filename;
		$wp_attached_file = '/theepi/' . $epi->data['type'] . '/' . $epi->data['id'] . '/' . $filename;

		$epi->data['qrcode']['filename']         = $filename;
		$epi->data['qrcode']['path']             = $path;
		$epi->data['qrcode']['guid']             = $guid;
		$epi->data['qrcode']['wp_attached_file'] = $wp_attached_file;

		EPI_Class::g()->update( $epi->data );

		if ( ! is_dir( dirname( $path ) ) ) {
			wp_mkdir_p( dirname( $path ) );
		}

		if ( file_exists( $path ) ) {
			return '<img src="' . esc_attr( $guid ) . '" style="height:' . esc_attr( $param['height'] ) . 'px; width:' . esc_attr( $param['width'] ) . 'px" alt="' . esc_attr( $param['text'] ) . '" />';
		}

		require_once PLUGIN_THEEPI_PATH . '/core/external/phpqrcode/phpqrcode.php';

		\QRcode::png( $param['text'], $path, 3, 12, 4, false, 0xFFFFFF, 0x000000, $param['height'], $param['width'], $param['transparency'] );

		return '<img src="' . esc_attr( $guid ) . '" style="height:' . esc_attr( $param['height'] ) . 'px; width:' . esc_attr( $param['width'] ) . 'px" alt="' . esc_attr( $param['text'] ) . '" />';
	}
}

new Qrcode_Shortcode();
