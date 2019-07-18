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

		$audits = \task_manager\Audit_Class::g()->get( array( 'post_parent' => $id ) );

		$picture = array();
		$title  = current_time( 'Ymd' ) . '_';
		$title .= sanitize_title( $epi->data['title'] ) . '_';
		$title .= \eoxia\ODT_Class::g()->get_revision( $epi->data['type'], $epi->data['id'] );
		$title  = str_replace( '-', '_', $title );

		$document_data = array(
			'title'             => $title,
			'guid'              => str_replace( '\\', '/', $upload_dir['baseurl'] ) . '/theepi/' . $epi->data['type'] . '/' . $epi->data['id'] . '/' . sanitize_title( $epi->data['title'] )  . '.odt',
			'path'              => str_replace( '\\', '/', $upload_dir['basedir'] ) . '/theepi/' . $epi->data['type'] . '/' . $epi->data['id'] . '/' . sanitize_title( $epi->data['title'] )  . '.odt',
			'_wp_attached_file' => '/theepi/' . $epi->data['type'] . '/' . $epi->data['id'] . '/' . sanitize_title( $epi->data['title'] )  . '.odt'
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

		foreach ($audits as $key => $audit) {
			$document_meta['audits']['value'][] = array(
				'date_control' => date( 'd/m/Y', strtotime( $audit->data['date']['rendered']['mysql'] ) ),
				'status' => 'a finir'
			);
		}

		$response = EPI_ODT_Class::g()->save_document_data( $id , $document_meta, $args );

		$response['document']->data['title']  = current_time( 'Ymd' ) . '_';
		$response['document']->data['title'] .= sanitize_title( $epi->data['title'] ) . '_';
		$response['document']->data['title'] .= \eoxia\ODT_Class::g()->get_revision( $epi->data['type'], $epi->data['id'] );
		$response['document']->data['title']  = str_replace( '-', '_', $response['document']->data['title'] );
		$response['document']->data['guid']  = str_replace( '\\', '/', $upload_dir['baseurl'] ) . '/theepi/' . $epi->data['type'] . '/' . $epi->data['id'] . '/' . $response['document']->data['title'] . '.odt';
		$response['document']->data['path'] = str_replace( '\\', '/', $upload_dir['basedir'] ) . '/theepi/' . $epi->data['type'] . '/' . $epi->data['id'] . '/' . $response['document']->data['title'] . '.odt';
		$response['document']->data['_wp_attached_file'] = '/theepi/' . $epi->data['type'] . '/' . $epi->data['id'] . '/' . $response['document']->data['title'] . '.odt';

		$link = $response['document']->data['guid'];

		EPI_ODT_Class::g()->update( $response['document']->data );
		$response = EPI_ODT_Class::g()->create_document( $response['document']->data['id'] );

		$filename = $response['document']->data['title'] . '.odt';

		wp_send_json_success( array(
			'namespace'        => 'theEPI',
			'module'           => 'EPI',
			'callback_success' => 'exportedEPISuccess',
			'filename'         => $filename,
			'link' => $link
		) );

	}

}

new EPI_ODT_Action();
