<?php
/**
 * Handle Service.
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.6.0
 * @version   0.7.0
 */

namespace theepi;

use eoxia\Singleton_Util;
use eoxia\View_Util;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle Service.
 */
class Service_Class extends Singleton_Util {

	/**
	 * Le constructeur.
	 *
	 * @return void
	 *
	 * @since   0.2.0
	 * @version 0.2.0
	 */
	protected function construct() {
	}

	/**
	 * Calcul la date de fin de vie d'un EPI.
	 *
	 * @since   0.6.0
	 * @version 0.7.0
	 *
	 * @param string $manufacture_date  La date de fabrication d'un EPI.
	 * @param string $lifetime          La durée de vie d'un EPI.
	 *
	 * @return string $end_life_date      La date de fin de vie d'un EPI.
	 */
	public function calcul_end_life_date( $manufacture_date, $lifetime ) {
		$end_life_date = 0;

		if ( $manufacture_date > 0 && $lifetime > 0 ) {
			$end_life_date = strtotime( '+' . $lifetime . ' days', $manufacture_date );
		}

		return $end_life_date;
	}

	/**
	 * Calcul la date de controle d'un EPI.
	 *
	 * @since   0.6.0
	 * @version 0.7.0
	 *
	 * @param string  $commissioning_date  La date de mise en service d'un EPI.
	 * @param integer $periodicity         La férquence de controle d'un EPI.
	 *
	 * @return string $control_date        La date de controle d'un EPI.
	 */
	public function calcul_control_date( $commissioning_date, $periodicity ) {
		$control_date = 0;

		if ( $commissioning_date > 0 && $periodicity > 0 ) {
			$control_date = strtotime( '+' . $periodicity . ' days', $commissioning_date );
		}

		return $control_date;
	}

	/**
	 * Calcul la date de mise au rebut d'un EPI.
	 *
	 * @since   0.6.0
	 * @version 0.7.0
	 *
	 * @param string $end_life_date    La date de fin de vie d'un EPI.
	 *
	 * @return string $disposal_date  La date de mise au rebut d'un EPI.
	 */
	public function calcul_disposal_date( $end_life_date ) {

		$disposal_date = 0;

		if ( $end_life_date > 0 ) {
			$disposal_date = $end_life_date;
		}

		return $disposal_date;
	}

	/**
	 * Vérifie si les champs dates, lifetime et peridicity sont corrects.
	 *
	 * @since   0.6.0
	 * @version 0.7.0
	 *
	 * @param object $data_epi les données d'un EPI.
	 *
	 * @return array ['success'] (bool)  True si le champ est valide.
	 *               ['error']   (array) le message d'erreur.
	 *               ['element'] (array) le champ invalide.
	 */
	public function check_date_epi( $data_epi ) {
		$data = array(
			'success' => true,
			'error'   => array(),
		);

		$temp_error = array();

		$periodicity = $data_epi['periodicity'];
		$lifetime    = $data_epi['lifetime_epi'];

		$temp_error = $this->check_error( strtotime( $data_epi['manufacture_date'] ),'manufacture-date', $temp_error );
		$temp_error = $this->check_error( strtotime( $data_epi['purchase_date'] ),'purchase-date', $temp_error );
		$temp_error = $this->check_error( strtotime( $data_epi['commissioning_date'] ),'commissioning-date', $temp_error );
		$temp_error = $this->check_error( $lifetime, 'lifetime', $temp_error );
		$temp_error = $this->check_error( $periodicity, 'periodicity', $temp_error );

		switch ( $data_epi['purchase_date'] ) {
			case $data_epi['manufacture_date'] > $data_epi['purchase_date']:
				$temp_error['purchase-date']['error']   = esc_html__( 'Le champ Date de Fabrication est plus grand que le champ Date d\'Achat', 'theepi' );
				$temp_error['purchase-date']['element'] = 'purchase-date';
				break;
			case $data_epi['purchase_date'] > strtotime( $data_epi['end_life_date'] ):
				$temp_error['purchase-date']['error']   = esc_html__( 'Le champ Date d\'Achat est plus grand que le champ Date de Fin de Vie', 'theepi' );
				$temp_error['purchase-date']['element'] = 'purchase-date';
				break;
		}

		switch ( $data_epi['commissioning_date'] ) {
			case $data_epi['purchase_date'] > $data_epi['commissioning_date']:
				$temp_error['commissioning-date']['error']   = esc_html__( 'Le champ Date d\'Achat est plus grand que le champ Date de Mise en Service', 'theepi' );
				$temp_error['commissioning-date']['element'] = 'commissioning-date';
				break;
			case $data_epi['commissioning_date'] > strtotime( $data_epi['end_life_date'] ):
				$temp_error['commissioning-date']['error']   = esc_html__( 'Le champ Date de Mise en Service est plus grand que le champ Date de Fin de Vie', 'theepi' );
				$temp_error['commissioning-date']['element'] = 'commissioning-date';
				break;
		}

		$data['error'] = $temp_error;
		foreach ( $data['error'] as $key['error'] => $value ) {
			if ( ! empty( $value['error'] ) ) {
				$data['success'] = false;
			}
		}

		return $data;
	}

	/**
	 * Vérifie si les champs dates, lifetime et peridicity sont remplies et valides.
	 *
	 * @since   0.6.0
	 * @version 0.7.0
	 *
	 * @param object $data       la valeur du champ.
	 * @param string $type       le champ en erreur.
	 * @param array  $temp_error le taableu contenant l'erreur + le champ.
	 *
	 * @return array ['error']   (array) le message d'erreur.
	 *               ['element'] (array) le champ invalide.
	 */
	public function check_error( $data, $type, $temp_error ) {
		if( $data == "" ){
			$error = esc_html__( 'Le champ ' . $type . ' est vide ', 'theepi' );
		} elseif( $data == 0 ){
			$error = esc_html__( 'Le champ ' . $type . ' est invalide parce que 0 est interdit', 'theepi' );
		} else {
			$error = '';
		}

		$temp_error[$type]['error']   = $error;
		$temp_error[$type]['element'] = $type;

		return $temp_error;
	}

	/**
	 * Vérifie si une date est vide.
	 *
	 * @since   0.6.0
	 * @version 0.7.0
	 *
	 * @param object $date la date à vérifié.
	 *
	 * @return array ['date'] la date vérifié.
	 */
	public function check_date_if_empty( $date ) {

		if ( empty( $date ) ) {
			$date = 0;
		} else {
			$date = strtotime( $date );
		}

		return $date;
	}

	/**
	 * Calcul la date de fabrication d'un EPI.
	 *
	 * @since   0.6.0
	 * @version 0.7.0
	 *
	 * @param string  $commissioning_date      La date de mise en service d'un EPI.
	 * @param integer $manufacture_date_valued Le nombre d'année à retirer.
	 *
	 * @return string $manufacture_date        La date de fabrication d'un EPI.
	 */
	public function calcul_manufacture_date( $commissioning_date, $manufacture_date_valued ) {

		$manufacture_date = 0;

		if ( $commissioning_date > 0 ) {
			$manufacture_date = strtotime( '-' . $manufacture_date_valued . ' days', $commissioning_date );
		}

		return $manufacture_date;
	}

	/**
	 * Calcul la date de fabrication d'un EPI.
	 *
	 * @since   0.6.0
	 * @version 0.7.0
	 *
	 * @param object $epi  les données d'un EPI.
	 *
	 * @return void
	 */
	public function display_autocomplete_manager( $epi ) {
		global $eo_search;

		$user_info = get_user_by( 'id', $epi->data['manager'] );

		$eo_search->register_search(
			'theepi',
			array(
				'label'        => 'Responsable',
				'icon'         => 'fa-user-tie',
				'type'         => 'user',
				'name'         => 'manager',
				'value'        => ! empty( $user_info->data->ID ) ? $user_info->data->display_name : '',
				'hidden_value' => ! empty( $user_info->data->ID ) ? $user_info->data->ID : 0,
			)
		);

		View_Util::exec(
			'theepi',
			'service',
			'autocomplete-manager',
			array(
				'epi' => $epi,
			)
		);
	}

}

Service_Class::g();
