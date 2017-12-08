<?php
/**
 * Helper du modèle commentaire des EPI
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 0.1.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk_EPI
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Met à jour le temps restant avant la date de hors d'état.
 *
 * @param  Comment_Model $data Les données du commentaires.
 *
 * @return Comment_Model
 *
 * @since 0.1.0
 * @version 0.1.0
 */
function update_remaining_time( $data ) {
	if ( ! empty( $data->id ) && ! empty( $data->frequency_control ) && ! empty( $data->control_date ) ) {
		$control_date = \DateTime::createFromFormat( 'd/m/Y', $data->control_date['date_input']['fr_FR']['date'] );
		$control_date->modify( '+' . $data->frequency_control . ' day' );

		$date_now = \DateTime::createFromFormat( 'd/m/Y', current_time( 'd/m/Y' ) );
		$interval = $date_now->diff( $control_date );

		$result = '';

		if ( $interval->format( '%R' ) === '+' ) {
			$result = '<span class=\'time-ok\'><i class=\'fa fa-calendar-o\' aria-hidden=\'true\'></i> ';
			$result .= $interval->format( '%a jours' );
			$result .= '</span>';
		} else {
			$result = '<span class=\'time-past\'><i class=\'fa fa-calendar-times-o\' aria-hidden=\'true\'></i> ';
			$result .= $interval->format( '%a jours' );
			$result .= '</span>';

			$data->state = 'KO';
		}


		$data->compiled_remaining_time = $result;
	}

	return $data;
}
