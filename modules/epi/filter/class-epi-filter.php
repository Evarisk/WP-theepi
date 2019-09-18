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
class EPI_Filter {


	/**
	 * Le constructeur.
	 *
	 * @since   0.1.0
	 * @version 0.7.0
	 */
	public function __construct() {
		add_filter( 'set-screen-option', array( $this, 'callback_set_screen_option' ), 10, 3 );

		$current_type = EPI_Class::g()->get_type();
		add_filter( "eo_model_{$current_type}_before_post", '\theepi\construct_identifier', 10, 2 );
		add_filter( "eo_model_{$current_type}_after_get", array( $this, 'update_remaining_time' ), 10, 2 );
		add_filter( 'the_content', array( $this, 'callback_display_epi' ), 10, 2 );
		add_filter( "eo_model_{$current_type}_register_post_type_args", array( $this, 'custom_init_post_type'), 20, 2 );

	}

	/**
	 * Sauvegardes les options de l'écran.
	 *
	 * @since   0.2.0
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
	 * Sauvegardes les options de l'écran.
	 *
	 * @since   0.2.0
	 * @version 0.3.0
	 *
	 * @param mixed  $status J'sais pas.
	 * @param string $option Le nom de l'option.
	 * @param string $value  La valeur de l'option.
	 *
	 * @return mixed $status J'sais pas.
	 */
	public function callback_display_epi( $content ) {

		global $post;
		if ( $post->post_type == 'theepi-epi'){
			$id = $post->ID;
			ob_start();
			$epi = EPI_Class::g()->get( array( 'id' => $id ), true );
			\eoxia\View_Util::exec(
				'theepi', 'epi', 'frontend/main', array(
					'epi'    => $epi,
				)
			);
			$content = ob_get_clean();
		}
		return $content;
	}

	/**
	 * Met à jour le temps restant avant la date de hors d'état.
	 *
	 * @param Comment_Model $object Les données du commentaires.
	 * @param array         $args   Les arguments lors du GET.
	 *
	 * @since   0.1.0
	 * @version 0.4.0
	 *
	 * @return Comment_Model
	 */
	public function update_remaining_time( $object, $args ) {
		if ( ! empty( $object->data['id'] ) && ! empty( $object->data['frequency_control'] ) && ! empty( $object->data['control_date'] ) ) {
			$control_date = \DateTime::createFromFormat( 'd/m/Y', $object->data['control_date']['rendered']['date'] );
			$control_date->modify( '+' . $object->data['frequency_control'] . ' day' );

			$date_now = \DateTime::createFromFormat( 'd/m/Y', current_time( 'd/m/Y' ) );
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

	public function custom_init_post_type( $args ) {
		$current_type = EPI_Class::g()->get_type();
		$new_args = array( 'public' => true, 'show_in_menu' => false );
		$args = wp_parse_args( $new_args, $args );
		$return = register_post_type( $current_type , $args );

		return $return;
	}

}

new EPI_Filter();
