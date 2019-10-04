<?php
/**
 * Gestion des avatars.
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.7.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des avatars.
 */
class Avatar_Class extends \eoxia\Singleton_Util {

	/**
	 * Obligatoire pour Singleton_Util.
	 *
	 * @since    0.7.0
	 * @version  0.7.0
	 *
	 * @return void
	 */
	protected function construct() {}

	/**
	 * Récupères l'url de l'avatar.
	 *
	 * @since    0.7.0
	 * @version  0.7.0
	 *
	 * @param  array $param.
	 *
	 * @return array
	 */
	public function get_avatars( $param ) {
		$users = array();
		if ( ! empty( $param['ids'] ) ) {
			$users = \eoxia\User_Class::g()->get(
				array(
					'include' => $param['ids'],
				)
			);
		}

		if ( ! empty( $users ) ) {
			foreach ( $users as $user ) {
				$user->data['avatar_url'] = get_avatar_url(
					$user->data['id'],
					array(
						'size'    => $param['size'],
						'default' => 'blank',
					)
				);
			}
		}

		return $users;
	}
}

Avatar_Class::g();
