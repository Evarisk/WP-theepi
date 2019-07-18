<?php
/**
 * Handle EPI Actions like save, delete, create_mass_epi.
 *
 * @author Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @since 0.1.0
 * @version 0.5.0
 * @copyright 2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères toutes les actions des EPI.
 */
class EPI_ODT_Action {

	/**
	 * Le constructeur
	 *
	 * @since 0.5.0
	 * @version 0.5.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_export_epi_odt', array( $this, 'callback_export_epi_odt' ) );
	}


	public function callback_export_epi_odt() {
		check_ajax_referer( 'export_epi_odt');
		$upload_dir = wp_upload_dir();

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : '';

		$epi = EPI_Class::g()->get( array ( 'id' => $id ), true );
		$status_epi = Audit_Class::g()->get_status( $epi ) ? "OK" : "KO";
		$control = EPI_Class::g()->get_days( $epi );
		$args = array( 'parent' => $epi );
		$picture = array();

		$document_data = array(
			'title'             => 'test.odt',
			'guid'              => str_replace( '\\', '/', $upload_dir['baseurl'] ) . '/theepi/' . $epi->data['type'] . '/' . $epi->data['id'] . '/' . 'test' . '.odt',
			'path'              => str_replace( '\\', '/', $upload_dir['basedir'] ) . '/theepi/' . $epi->data['type'] . '/' . $epi->data['id'] . '/' . 'test' . '.odt',
			'_wp_attached_file' => '/theepi/' . $epi->data['type'] . '/' . $epi->data['id'] . '/' . 'test' . '.odt'
		);

		$picture_definition = wp_get_attachment_image_src( $epi->data['thumbnail_id'], 'medium' );
		if ( !empty( $picture_definition ) ) {
			$picture_final_path = str_replace( '\\', '/', str_replace( site_url( '/', 'http' ), ABSPATH, $picture_definition[0] ) );
			$picture_final_path = str_replace( '\\', '/', str_replace( site_url( '/', 'https' ), ABSPATH, $picture_final_path ) );

			$picture = array(
					'type'		=> 'picture',
					'value'		=> $picture_final_path,
					'option'	=> array(
						'size'	=> 9,
					),
				);
		}

		$document_meta = array(
			'photo'=> $picture,
			'reference' => $epi->data['reference'],
			'periodicity' => $epi->data['periodicity'],
			'status' => $status_epi,
			'control' => $control,
			'audits' => array( 'type' => 'segment', 'value' => array() )
		);


		$document_meta['audits']['value'][] = array( 'date_control' => 'salut', 'status' => 'aurevoir' );
		$document_meta['audits']['value'][] = array( 'date_control' => 'bonjour', 'status' => 'ok' );

		$response = EPI_ODT_Class::g()->save_document_data( $id , $document_meta, $args );

		$response['document']->data['title'] = 'test.odt';
		$response['document']->data['guid']  = str_replace( '\\', '/', $upload_dir['baseurl'] ) . '/theepi/' . $epi->data['type'] . '/' . $epi->data['id'] . '/' . 'test' . '.odt';
		$response['document']->data['path'] = str_replace( '\\', '/', $upload_dir['basedir'] ) . '/theepi/' . $epi->data['type'] . '/' . $epi->data['id'] . '/' . 'test' . '.odt';
		$response['document']->data['_wp_attached_file'] = '/theepi/' . $epi->data['type'] . '/' . $epi->data['id'] . '/' . 'test' . '.odt';


		EPI_ODT_Class::g()->update( $response['document']->data );

		$response = EPI_ODT_Class::g()->create_document( $response['document']->data['id'] );
	}

}

new EPI_ODT_Action();
