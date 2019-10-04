<?php
/**
 * Classe gérant les configurations de TheEPI.
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.2.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les configurations de TheEPI.
 *
 * @return void
 */
class Setting_Class extends \eoxia\Singleton_Util {


	/**
	 * La limite des utilisateurs de la page "theepi-setting".
	 *
	 * @var integer
	 */
	private $limit_user = 10;

	/**
	 * L'option pour enregistrer les nombre d'utilisateur par page.
	 *
	 * @var string
	 */
	public $option_name = 'user_per_page';


	public $capabilities = array();


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
	 * Récupère le role "subscriber" et appel la vue "capability/has-cap".
	 *
	 * @since   0.2.0
	 * @version 0.2.0
	 *
	 * @return void
	 */
	public function display_role_has_cap() {
		$role_subscriber = get_role( 'subscriber' );

		\eoxia\View_Util::exec(
			'theepi', 'setting', 'capability/has-cap', array(
				'role_subscriber' => $role_subscriber,
			)
		);
	}

	/**
	 * Récupères la liste des utilisateurs pour les afficher dans la vue "capability/list".
	 *
	 * @since   0.2.0
	 * @version 0.7.0
	 *
	 * @param array $list_user_id La liste des utilisateurs à afficher. Peut être vide pour récupérer tous les utilisateurs.
	 *
	 * @return void
	 * @todo:  13/12/2017: nonce
	 */
	public function display_user_list_capacity( $list_user_id = array() ) {
		$current_page = ! empty( $_POST['next_page'] ) ? (int) $_POST['next_page'] : 1;

		$per_page = get_user_meta( get_current_user_id(), $this->option_name, true );

		if ( empty( $per_page ) || $per_page < 1 ) {
			$per_page = $this->limit_user;
		}

		$args_user = array(
			'exclude' => array( 1 ),
			'offset'  => ( $current_page - 1 ) * $per_page,
			'number'  => $per_page,
		);

		if ( ! empty( $list_user_id ) ) {
			$args_user['include'] = $list_user_id;
		}

		$users = \eoxia\User_Class::g()->get( $args_user );

		unset( $args_user['offset'] );
		unset( $args_user['number'] );
		unset( $args_user['include'] );
		$args_user['fields'] = array( 'ID' );

		$count_user  = count( \eoxia\User_Class::g()->get( $args_user ) );
		$number_page = ceil( $count_user / $per_page );

		$role_subscriber      = get_role( 'subscriber' );
		$has_capacity_in_role = ! empty( $role_subscriber->capabilities['read_theepi'] ) ? true : false;

		if ( ! empty( $users ) ) {
			foreach ( $users as &$user ) {
				$user->wordpress_user = new \WP_User( $user->data['id'] );
			}
		}

		\eoxia\View_Util::exec(
			'theepi', 'setting', 'capability/list', array(
				'users'                => $users,
				'has_capacity_in_role' => $has_capacity_in_role,
			)
		);
	}

	/**
	 * Initialise les options d'écrans.
	 *
	 * @since   0.2.0
	 * @version 0.2.0
	 *
	 * @return void
	 */
	public function callback_add_screen_option() {
		add_screen_option(
			'per_page',
			array(
				'label'   => __( 'User per page', 'theepi' ),
				'default' => self::g()->limit_user,
				'option'  => self::g()->option_name,
			)
		);
	}

	/**
	 * Enregistres les données par défaut.
	 *
	 * @since   0.3.0
	 * @version 0.6.0
	 *
	 * @param integer $default_periodicity La périodicité de contrôle d'un EPI par défaut.
	 * @param integer $default_lifetime    La durée de vie d'un EPI par défaut.
	 *
	 * @return bool  True si tout s'est bien passé.
	 */
	public function save_default_data( $default_periodicity, $default_lifetime ) {

		// Seulement pour garder une trace dans les LOG.
		$old_data_periodicity = get_option( EPI_Class::g()->option_name_default_data_periodicity );
		$old_data_lifetime = get_option( EPI_Class::g()->option_name_default_data_lifetime );

		update_option( EPI_Class::g()->option_name_default_data_periodicity, $default_periodicity );
		update_option( EPI_Class::g()->option_name_default_data_lifetime, $default_lifetime );

		\eoxia\LOG_Util::g()->log( sprintf( 'Update option "%s" with the data "%s", old data periodicity %s', "theepi-default-data-periodicity", EPI_Class::g()->default_data_periodicity , $old_data_periodicity ), 'theepi' );
		\eoxia\LOG_Util::g()->log( sprintf( 'Update option "%s" with the data "%s", old data lifetime %s', "theepi-default-data-lifetime", EPI_Class::g()->default_data_lifetime , $old_data_lifetime ), 'theepi' );

		return true;
	}

	/**
	 * Enregistres les données par défaut de la gestion des dates.
	 *
	 * @since   0.3.0
	 * @version 0.6.0
	 *
	 * @param bool    $default_purchase_date    La date d'achat d'un EPI par défaut.
	 * @param integer $default_manufacture_date La date de fabrication d'un EPI par défaut.
	 *
	 * @return bool  True si tout s'est bien passé.
	 */
	public function save_date_management( $default_purchase_date, $default_manufacture_date ) {
		// Seulement pour garder une trace dans les LOG.
		$old_data_purchase_date = get_option( EPI_Class::g()->option_name_date_management_purchase_date );
		$old_data_manufacture_date = get_option( EPI_Class::g()->option_name_date_management_manufacture_date );

		update_option( EPI_Class::g()->option_name_date_management_purchase_date, $default_purchase_date );
		update_option( EPI_Class::g()->option_name_date_management_manufacture_date, $default_manufacture_date );

		\eoxia\LOG_Util::g()->log( sprintf( 'Update option "%s" with the data "%s", old data purchase_date %s', "theepi_date_management_purchase_date", EPI_Class::g()->default_data_purchase_date , $old_data_purchase_date ), 'theepi' );
		\eoxia\LOG_Util::g()->log( sprintf( 'Update option "%s" with the data "%s", old data manufacture_date %s', "theepi_date_management_manufacture_date", EPI_Class::g()->default_data_manufacture_date , $old_data_manufacture_date ), 'theepi' );

		return true;
	}

	/**
	 * Enregistres les données par défaut de la gestion des capacités.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @return bool  True si tout s'est bien passé.
	 */
	public function save_capability() {

        if ( ! empty( $_POST['users'] ) ) {
            foreach ( $_POST['users'] as $user_id => $data ) {
                $user = new \WP_User( $user_id );

                if ( 'true' == $data['capability'] ) {
                    $user->add_cap( 'manage_digirisk' );
                } else {
                    $user->remove_cap( 'manage_digirisk' );
                }
            }
        }

		return true;
    }
}

Setting_Class::g();
