<?php
/**
 * Handle Service.
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.5.0
 * @version   0.5.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle Service
 */
class Service_Class extends \eoxia\Post_Class {


	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\theepi\EPI_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'theepi-service-epi';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_theepi_epi';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'theepi/service/epi';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Le préfixe de l'objet dans TheEPI.
	 *
	 * @var string
	 */
	public $element_prefix = 'EPI';

	/**
	 * La limite des EPI a affiché par page
	 *
	 * @var integer
	 */
	protected $limit_epi = 10;

	/**
	 * L'option pour enregistrer le commentaire par défault.
	 *
	 * @var string
	 */
	public $option_name_per_page = 'epi_per_page';

	/**
	 * Le nom pour le register post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Personal protective equipment';

	/**
	 * La taxonomie à attacher.
	 *
	 * @var string
	 */
	protected $attached_taxonomy_type = '_theepi_state';

	public function calcul_date_fin_vie( $epi ) {

		$date_fin_vie = "";
		$duree_de_vie = $epi->data['lifetime_epi'];

		if( strtotime( $epi->data['manufacture_date']['rendered']['mysql'] ) > 0 ){ // Date de fabrication définie
			$date_fabrication = strtotime( $epi->data['manufacture_date']['rendered']['mysql'] ); // seconde
			$date_fin_vie = strtotime( '+' . $duree_de_vie . ' years', $date_fabrication );
			$date_fin_vie = date( 'd/m/Y',  $date_fin_vie );
		}

		return $date_fin_vie;
	}

	public function calcul_date_control( $epi ) {
		$date_fin_vie = strtotime( $epi->data['end_life_date']['rendered']['mysql'] );
		$date_achat = strtotime( $epi->data['purchase_date']['rendered']['mysql'] );
		$date_mise_service = strtotime( $epi->data['commissioning_date']['rendered']['mysql'] );
		$periodicity = $epi->data['periodicity'];
		$date_control = "";

		if ( $date_achat <= $date_fin_vie && $date_mise_service <= $date_fin_vie) {
			$date_control = strtotime( '+' . $periodicity . ' days', $date_mise_service );
			$date_control = date( 'd/m/Y', $date_control);
			} else {
			$status_epi = $epi->data['status_epi'] = "Rebut";
		}

		return $date_control;
	}

	public function calcul_date_mise_rebut( $epi ) {
		$date_fin_vie = $this->calcul_date_fin_vie( $epi );
		$date_mise_rebut = $date_fin_vie;
		return $date_mise_rebut;
	}

	/**
	 * Convertie la date au format français dd/mm/yy en format SQL
	 *
	 * @param  object $date Les donnnées du modèle.
	 * @return object       Les donnnées du modèle avec la date au format SQL
	 *
	 * @since 1.0.0.0
	 * @version 1.3.6.0
	 */
	 public function convert_date_to_sql( $date ) {
		if ( !empty( $date ) && $date != "" ) {
			return date( 'Y-m-d', strtotime( str_replace( '/', '-', 	$date ) ) );
		}
		return "";
	}

	public function check_date_epi ( $data_epi ) {
		$data = array(
			'success' => true,
			'error'   => array(),
			'element' => array()
		);

		$date_fabrication = strtotime( $data_epi['manufacture_date'] );
		$date_fin_vie = strtotime( $data_epi['end_life_date'] );
		$date_achat = strtotime( $data_epi['purchase_date'] );
		$date_mise_service = strtotime( $data_epi['commissioning_date'] );

		if ( ( $data_epi['lifetime_epi'] == 0 ) || ( $data_epi['lifetime_epi'] == '') ) {
			$data['success'] = false;
			array_push( $data['error'], esc_html__( 'This field Lifetime is empty or invalid', 'theepi' ) );
			array_push( $data['element'], 'lifetime' );
		}

		if ( ( $data_epi['manufacture_date'] == 0 ) || ( $data_epi['manufacture_date'] == '') ) {
			$data['success'] = false;
			array_push( $data['error'], esc_html__( 'This field Manufacture Date is empty or invalid', 'theepi' ) );
			array_push( $data['element'], 'manufacture-date' );
		}

		if ( ( $date_fabrication > $date_achat ) || ( $date_achat > $date_fin_vie ) || ( $data_epi['purchase_date'] == 0 ) || ( $data_epi['purchase_date'] == '') ) {
			$data['success'] = false;
			array_push( $data['error'], esc_html__( 'This field Purchase Date is empty or invalid', 'theepi' ) );
			array_push( $data['element'], 'purchase-date' );
		}

		// echo '<pre>'; print_r( $date_achat ); echo '</pre>';
		// echo '<pre>'; print_r(  $date_mise_service ); echo '</pre>';
		// echo '<pre>'; print_r( $date_fin_vie ); echo '</pre>';

		if ( ( $date_achat > $date_mise_service ) ||  ( $date_mise_service > $date_fin_vie ) || ( $data_epi['commissioning_date'] == 0 ) || ( $data_epi['commissioning_date'] == '') ) {
			$data['success'] = false;
			array_push( $data['error'], esc_html__( 'This field Commissioning Date is empty or invalid', 'theepi' ) );
			array_push( $data['element'], 'commissioning-date' );
		}

		return $data;

	}

	public function calcul_date_fabrication( $commissioning_date , $manufacture_date_valued ) {

		$date_fabrication = "";
		$commissioning_date = str_replace( '/', '-', 	$commissioning_date );
		$date_mise_service = strtotime( $commissioning_date );
		$date_fabrication = strtotime( '-' . $manufacture_date_valued . ' years', $date_mise_service );
		$date_fabrication = date( 'd/m/Y',  $date_fabrication );
		return $date_fabrication;
	}

}

Service_Class::g();
