<?php
/**
 * Handle EPI Filter.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 0.2.0
 * @version 0.4.0
 * @copyright 2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle EPI Filter.
 */
class EPI_Filter {

	/**
	 * Le constructeur
	 *
	 * @since 0.1.0
	 * @version 0.4.0
	 */
	public function __construct() {
		add_filter( 'set-screen-option', array( $this, 'callback_set_screen_option' ), 10, 3 );

		$current_type = EPI_Class::g()->get_type();
		add_filter( "eo_model_{$current_type}_before_post", '\theepi\construct_identifier', 10, 2 );
		add_filter( "eo_model_{$current_type}_after_get", array( $this, 'update_remaining_time' ), 10, 2 );
	}

	/**
	 * Sauvegardes les options de l'écran.
	 *
	 * @since 0.2.0
	 * @version 0.3.0
	 *
	 * @param mixed  $status J'sais pas.
	 * @param string $option Le nom de l'option.
	 * @param string $value  La valeur de l'option.
	 *
	 * @return mixed $status J'sais pas.
	 */
	public function callback_set_screen_option( $status, $option, $value ) {
		if ( EPI_Class::g()->option_name_per_page === $option ) {
			return $value;
		}

		return $status;
	}



	/**
	 * Met à jour le temps restant avant la date de hors d'état.
	 *
	 * @param  Comment_Model $object Les données du commentaires.
	 * @param  array         $args   Les arguments lors du GET.
	 *
	 * @since 0.1.0
	 * @version 0.4.0
	 *
	 * @return Comment_Model
	 */
	public function update_remaining_time( $object, $args ) {
		if ( ! empty( $object->data['id'] ) && ! empty( $object->data['frequency_control'] ) && ! empty( $object->data['control_date'] ) ) {
			$control_date = \DateTime::createFromFormat( 'd/m/y', $object->data['control_date']['rendered']['date'] );
			$control_date->modify( '+' . $object->data['frequency_control'] . ' day' );
			
			$date_now = \DateTime::createFromFormat( 'd/m/y', current_time( 'd/m/y' ) );
			$interval = $date_now->diff( $control_date );

			$result = '';

			if ( $interval->format( '%R' ) === '+' ) {
				$result  = '<span class=\'time-ok\'><i class=\'far fa-calendar-plus\' aria-hidden=\'true\'></i> ';
				$result .= $interval->format( '%a days' );
				$result .= '</span>';
			} else {
				if ( 'KO' === $object->data['state'] ) {
					$result  = '<span class=\'time-past\'><i class=\'far fa-calendar-times\' aria-hidden=\'true\'></i> ';
					$result .= $interval->format( '%a days' );
					$result .= '</span>';
				} else {
					$result  = '<span class=\'time-past\'><i class=\'far fa-calendar-times\' aria-hidden=\'true\'></i> ';
					$result .= $interval->format( '%a days' );
					$result .= '</span>';

					$object->data['state'] = 'NA';
				}
			}

			$object->data['compiled_remaining_time'] = $result;
		}

		return $object;
	}

}

new EPI_Filter();
