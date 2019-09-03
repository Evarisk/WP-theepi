<?php
/**
 * Handle Service.
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.6.0
 * @version   0.6.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle Service.
 */
class Service_Class extends \eoxia\Post_Class {


	/**
	 * Le nom du modèle.
	 *
	 * @var string
	 */
	protected $model_name = '\theepi\EPI_Model';

	/**
	 * Le post type.
	 *
	 * @var string
	 */
	protected $type = 'theepi-service-epi';

	/**
	 * La clé principale du modèle.
	 *
	 * @var string
	 */
	protected $meta_key = '_theepi_epi';

	/**
	 * La route pour accéder à l'objet dans la rest API.
	 *
	 * @var string
	 */
	protected $base = 'theepi/service/epi';

	/**
	 * La version de l'objet.
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
	 * La limite des EPI a affiché par page.
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
	 * Le nom pour le register post type.
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

	/**
	 * Calcul la date de fin de vie d'un EPI.
	 *
	 * @since   0.6.0
	 * @version 0.6.0
	 *
	 * @param string  $manufacture_date  La date de fabrication d'un EPI.
	 * @param string  $lifetime          La durée de vie d'un EPI.
	 *
	 * @return string $date_fin_vie      La date de fin de vie d'un EPI.
	 *
	 */
	public function calcul_date_fin_vie( $manufacture_date, $lifetime ) {

		$date_fin_vie = '';
		$duree_de_vie = $lifetime;
		$manufacture_date = $this->convert_date_to_sql( $manufacture_date );

		if( strtotime( $manufacture_date ) > 0 ){ // Date de fabrication définie
			$date_fabrication = strtotime( $manufacture_date ); // seconde
			$date_fin_vie = strtotime( '+' . $duree_de_vie . ' years', $date_fabrication );
			$date_fin_vie = date( 'd/m/Y',  $date_fin_vie );
		}

		return $date_fin_vie;
	}

	/**
	 * Calcul la date de controle d'un EPI.
	 *
	 * @since   0.6.0
	 * @version 0.6.0
	 *
	 * @param string  $purchase_date       La date d'achat d'un EPI.
	 * @param string  $end_life_date       La date de fin de vie d'un EPI.
	 * @param string  $commissioning_date  La date de mise en service d'un EPI.
	 * @param integer $periodicity         La férquence de controle d'un EPI.
	 *
	 * @return string $date_control        La date de controle d'un EPI.
	 *
	 */
	public function calcul_date_control( $purchase_date, $end_life_date, $commissioning_date, $periodicity ) {
		$date_control = "";
		$purchase_date = $this->convert_date_to_sql( $purchase_date );
		$end_life_date = $this->convert_date_to_sql( $end_life_date );
		$commissioning_date = $this->convert_date_to_sql( $commissioning_date );

		if ( strtotime( $purchase_date ) <=  strtotime( $end_life_date ) &&  strtotime( $commissioning_date ) <=  strtotime( $end_life_date ) ) {
			$date_control = strtotime( '+' . $periodicity . ' days', strtotime( $commissioning_date ) );
			$date_control = date( 'd/m/Y', $date_control);
			} else {
			$status_epi = $epi->data['status_epi'] = "rebut";
		}
		return $date_control;
	}

	/**
	 * Calcul la date de mise au rebut d'un EPI.
	 *
	 * @since   0.6.0
	 * @version 0.6.0
	 *
	 * @param string  $end_life_date    La date de fin de vie d'un EPI.
	 *
	 * @return string $date_mise_rebut  La date de mise au rebut d'un EPI.
	 *
	 */
	public function calcul_date_mise_rebut( $end_life_date ) {
		$date_mise_rebut = $end_life_date;
		return $date_mise_rebut;
	}

	/**
	 * Convertie la date au format français dd/mm/yy en format SQL.
	 *
	 * @since   0.6.0
	 * @version 0.6.0
	 *
	 * @param  string $date La date au format dd/mm/aaaa.
	 * @return string       la date au format SQL.
	 *
	 */
	 public function convert_date_to_sql( $date ) {
		if ( !empty( $date ) && $date != "" ) {
			return date( 'Y-m-d', strtotime( str_replace( '/', '-', $date ) ) );
		}
		return "";
	}

	/**
	 * Vérifie si les champs dates, lifetime et peridicity sont remplies et valides.
	 *
	 * @since   0.6.0
	 * @version 0.6.0
	 *
	 * @param object $data_epi les données d'un EPI.
	 *
	 * @return array ['success'] (bool)  True si le champ est valide.
	 *               ['error']   (array) le message d'erreur.
	 *               ['element'] (array) le champ invalide.
	 *
	 */
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

		if ( ( $data_epi['periodicity'] == 0 ) || ( $data_epi['periodicity'] == '') ) {
			$data['success'] = false;
			array_push( $data['error'], esc_html__( 'This field Periodicity is empty or invalid', 'theepi' ) );
			array_push( $data['element'], 'periodicity' );
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

		if ( ( $date_achat > $date_mise_service ) ||  ( $date_mise_service > $date_fin_vie ) || ( $data_epi['commissioning_date'] == 0 ) || ( $data_epi['commissioning_date'] == '') ) {
			$data['success'] = false;
			array_push( $data['error'], esc_html__( 'This field Commissioning Date is empty or invalid', 'theepi' ) );
			array_push( $data['element'], 'commissioning-date' );
		}

		return $data;

	}

	/**
	 * Calcul la date de fabrication d'un EPI.
	 *
	 * @since   0.6.0
	 * @version 0.6.0
	 *
	 * @param string  $commissioning_date      La date de mise en service d'un EPI.
	 * @param integer $manufacture_date_valued Le nombre d'année à retirer.
	 *
	 * @return string $date_fabrication        La date de fabrication d'un EPI.
	 *
	 */
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
