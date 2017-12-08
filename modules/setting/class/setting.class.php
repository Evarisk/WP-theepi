<?php
/**
 * Classe gérant les configurations de DigiRisk.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.2.0
 * @version 0.2.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk_EPI
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les configurations de DigiRisk.
 *
 * @return void
 */
class Setting_Class extends \eoxia\Singleton_Util {

	/**
	 * La limite des utilisateurs de la page ="digirisk-setting"
	 *
	 * @var integer
	 */
	private $limit_user = 1;

	/**
	 * Le constructeur
	 *
	 * @return void
	 *
	 * @since 0.2.0
	 * @version 0.2.0
	 */
	protected function construct() {}

	/**
	 * Récupère le role "subscriber" et appel la vue "capability/has-cap".
	 *
	 * @since 0.2.0
	 * @version 0.2.0
	 *
	 * @return void
	 */
	public function display_role_has_cap() {
		$role_subscriber = get_role( 'subscriber' );

		\eoxia\View_Util::exec( 'digirisk-epi', 'setting', 'capability/has-cap', array(
			'role_subscriber' => $role_subscriber,
		) );
	}

	/**
	 * Récupères la liste des utilisateurs pour les afficher dans la vue "capability/list".
	 *
	 * @since 0.2.0
	 * @version 0.2.0
	 *
	 * @param array $list_user_id La liste des utilisateurs à afficher. Peut être vide pour récupérer tous les utilisateurs.
	 *
	 * @return void
	 */
	public function display_user_list_capacity( $list_user_id = array() ) {
		$current_page = ! empty( $_POST['next_page'] ) ? (int) $_POST['next_page'] : 1;
		$args_user = array(
			'exclude' => array( 1 ),
			'offset' => ( $current_page - 1 ) * $this->limit_user,
			'number' => $this->limit_user,
		);

		if ( ! empty( $list_user_id ) ) {
			$args_user['include'] = $list_user_id;
		}

		$users = \digi\User_Digi_Class::g()->get( $args_user );

		unset( $args_user['offset'] );
		unset( $args_user['number'] );
		unset( $args_user['include'] );
		$args_user['fields'] = array( 'ID' );

		$count_user = count( \digi\User_Digi_Class::g()->get( $args_user ) );
		$number_page = ceil( $count_user / $this->limit_user );

		$role_subscriber = get_role( 'subscriber' );
		$has_capacity_in_role = ! empty( $role_subscriber->capabilities['manage_digirisk_epi'] ) ? true : false;

		if ( ! empty( $users ) ) {
			foreach ( $users as &$user ) {
				$user->wordpress_user = new \WP_User( $user->id );
			}
		}

		\eoxia\View_Util::exec( 'digirisk-epi', 'setting', 'capability/list', array(
			'users' => $users,
			'has_capacity_in_role' => $has_capacity_in_role,
			'number_page' => $number_page,
			'count_user' => $count_user,
			'current_page' => $current_page,
		) );
	}
}

Setting_Class::g();
