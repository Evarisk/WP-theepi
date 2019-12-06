<?php
/**
 * Handle EPI.
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.1.0
 * @version   0.7.0
 */

namespace theepi;

use eoxia\Post_Class;
use eoxia\View_Util;
use eoxia\WPEO_Upload_Class;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle EPI.
 */
class EPI_Class extends Post_Class {


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
	protected $type = 'theepi-epi';

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
	protected $base = 'theepi/epi';

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
	public $limit_epi = 10;

	/**
	 * Le nom de l'option pour enregistrer le nombre d'epi par page (défault).
	 *
	 * @var string
	 */
	public $option_name_per_page = 'epi_per_page';

	/**
	 * Le nom de l'option pour enregistrer la périodicité d'un epi (défault).
	 *
	 * @var string
	 */
	public $option_name_default_data_periodicity = 'theepi_default_data_periodicity';

	/**
	 * Le nom de l'option pour enregistrer la durée de vie d'un epi (défault).
	 *
	 * @var string
	 */
	public $option_name_default_data_lifetime = 'theepi_default_data_lifetime';


	/**
	 * Le nom de l'option pour enregistrer la date d'achat d'un epi (défault).
	 *
	 * @var string
	 */
	public $option_name_date_management_purchase_date = 'theepi_date_management_purchase_date';

	/**
	 * Le nom de l'option pour enregistrer la date de fabrication d'un epi (défault).
	 *
	 * @var string
	 */
	public $option_name_date_management_manufacture_date = 'theepi_date_management_manufacture_date';

	/**
	 * Le nom de l'option pour enregistrer l'acronym du site (défault).
	 *
	 * @var string
	 */
	public $option_name_acronym_site = 'theepi_acronym_site';

	/**
	 * Le nom de l'option pour enregistrer l'acronym d'un epi (défault).
	 *
	 * @var string
	 */
	public $option_name_acronym_epi = 'theepi_acronym_epi';

	/**
	 * La donnée par défaut de la périodicité.
	 * Initialisé dans le constructeur.
	 *
	 * @var integer
	 */
	public $default_data_periodicity;

	/**
	 * La donnée par défaut de la durée de vie.
	 * Initialisé dans le constructeur.
	 *
	 * @var integer
	 */
	public $default_data_lifetime;

	/**
	 * La donnée par défaut de la date d'achat.
	 * Initialisé dans le constructeur.
	 *
	 * @var bool
	 */
	public $default_data_purchase_date;

	/**
	 * La donnée par défaut de la date de fabrication.
	 * Initialisé dans le constructeur.
	 *
	 * @var integer
	 */
	public $default_data_manufacture_date;

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

	public $screen_options_array = array(
		'id_screen_option_name'            => 'id_screen_option',
		'id_screen_option'                 => true,
		'image_screen_option_name'         => 'image_screen_option',
		'image_screen_option'              => true,
		'quantity_screen_option_name'      => 'quantity_screen_option',
		'quantity_screen_option'           => true,
		'qrcode_screen_option_name'        => 'qrcode_screen_option',
		'qrcode_screen_option'             => true,
		'serial_number_screen_option_name' => 'serial_number_screen_option',
		'serial_number_screen_option'      => true,
		'title_screen_option_name'         => 'title_screen_option',
		'title_screen_option'              => true,
		'manager_screen_option_name'       => 'manager_screen_option',
		'manager_screen_option'            => true,
		'last_control_screen_option_name'  => 'last_control_screen_option',
		'last_control_screen_option'       => true,
		'add_control_screen_option_name'   => 'add_control_screen_option',
		'add_control_screen_option'        => true,
		'next_control_screen_option_name'  => 'next_control_screen_option',
		'next_control_screen_option'       => true,
		'status_screen_option_name'        => 'status_screen_option',
		'status_screen_option'             => true,
		'actions_screen_option_name'       => 'actions_screen_option',
		'actions_screen_option'            => true,
);


	/**
	 * Constructeur.
	 *
	 * @since   0.6.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	protected function construct() {
		parent::construct();
		$this->default_data_periodicity      = 365;
		$this->default_data_lifetime         = 365;
		$this->default_data_purchase_date    = true;
		$this->default_data_manufacture_date = 1;
	}

	/**
	 * Appel la vue principale pour afficher le tableau HTML contenant les EPI.
	 *
	 * @since   0.2.0
	 * @version 0.7.0
	 *
	 * @param string $term Terme de la recherche. Défault ''.
	 *
	 * @return void
	 */
	public function display( $term = '' ) {
		$page = isset ( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : "all";
		if ( $page != "all" && $page != "ok" && $page != "ko" && $page != "repair" && $page != "trash" ) {
			$page = 'all';
		}

		$epi_schema = self::g()->get( array( 'schema' => true ), true );

		$pagination_data = $this->get_pagination_data( 0, $term );

		$data_epis = $this->get_epis( $pagination_data, $term, $page );
		$epis      = $data_epis['epis'];

		View_Util::exec(
			'theepi',
			'epi',
			'main',
			array(
				'offset'     => $pagination_data['offset'],
				'count_epi'  => $pagination_data['count_epi'],
				'per_page'   => $pagination_data['per_page'],
				'epis'       => $epis,
				'epi_schema' => $epi_schema,
				'term'       => $term,
				'page'       => $page,
			)
		);
	}

	/**
	 * Récupères la liste des EPI.
	 *
	 * @since   0.4.0
	 * @version 0.7.0
	 *
	 * @param array  $data  Les données de la pagination.
	 *
	 * @param string $term Terme de la recherche. Défault ''.
	 * @param string $page La page de l'EPI.
	 *
	 * @return array $data_epis Les EPIS en fonction de la page.
	 */
	public function get_epis( $data, $term = '', $page ) {
		$status = mb_strtoupper( $page );
		switch ( $status ) {
			case 'OK':
				$meta_value = 'OK';
				break;
			case 'KO':
				$meta_value = 'KO';
				break;
			case 'REPAIR':
				$meta_value = 'repair';
				break;
			case 'TRASH':
				$meta_value = 'trash';
				break;
			default:
				$meta_value = '';
				break;
		}
		$epis = self::g()->get(
			array(
				'offset'         => $data['offset'],
				'posts_per_page' => (int)$data['per_page'],
				's'              => $term,
				'meta_key'       => '_theepi_status_epi',
				'meta_value'     => $meta_value,
				'post_status'    => 'publish',
			)
		);

		usort(
			$epis,
			function( $a, $b ) {
				if ( $a->data['unique_key'] === $b->data['unique_key'] ) {
					return 0;
				}
					return ( $a->data['unique_key'] < $b->data['unique_key'] ) ? 1 : -1;
			}
		);

		$nbr_epis  = $this->get_nb_epis( $meta_value );
		$data_epis = array(
			'epis'     => $epis,
			'nbr_epis' => $nbr_epis,
		);

		return $data_epis;
	}

	/**
	 * Appel la vue pour afficher le formulaire de recherche.
	 *
	 * @since   0.4.0
	 * @version 0.4.0
	 *
	 * @return void
	 */
	public function display_search() {
		View_Util::exec( 'theepi', 'epi', 'search' );
	}

	/**
	 * Appel la vue pour afficher les filtres des EPI.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	public function display_filters( $page ) {
		$filter_options = array(
			'all'    => __( 'All', 'theepi' ),
			'ok'     => __( 'OK', 'theepi' ),
			'ko'     => __( 'KO', 'theepi' ),
			'repair' => __( 'To fix', 'theepi' ),
			'trash'  => __( 'Trashed', 'theepi' ),
		);

		View_Util::exec(
			'theepi',
			'epi',
			'filters',
			array(
				'page'           => $page,
				'filter_options' => $filter_options,
			)
		);
	}

	/**
	 * Récupères les données liée à la pagination des EPI.
	 *
	 * @since   0.4.0
	 * @version 0.6.0
	 *
	 * @param integer $offset Le nombre de post à sauté. Défault 0.
	 * @param string  $term   Terme de la recherche. Défault ''.
	 *
	 * @return array ['offset']    (integer) Le nombre d'EPI à sauter.
	 *               ['count_epi'] (integer) le nombre d'EPI en base de donnée.
	 *               ['per_page']  (integer) Le nombre d'EPI par page.
	 */
	public function get_pagination_data( $offset = 0, $term = '' ) {

		$count_epi = count(
			self::g()->get(
				array(
					'fields'      => array( 'ID' ),
					's'           => $term,
					'post_status' => 'publish',
				)
			)
		);

		$per_page = get_user_meta( get_current_user_id(), $this->option_name_per_page, true );

		if ( empty( $per_page ) || $per_page < 1 ) {
			$per_page = $this->limit_epi;
		}

		return array(
			'offset'    => $offset,
			'count_epi' => $count_epi,
			'per_page'  => $per_page,
		);
	}

	/**
	 * Initialise les options d'écrans.
	 *
	 * @since   0.2.0
	 * @version 0.3.0
	 *
	 * @return void
	 */
	public function callback_add_screen_option() {
		add_screen_option(
			'per_page',
			array(
				'label'   => __( 'EPI per page', 'theepi' ),
				'default' => self::g()->limit_epi,
				'option'  => self::g()->option_name_per_page,
			)
		);
	}

	/**
	 * Affiches la liste des EPI.
	 *
	 * @since   0.1.0
	 * @version 0.7.0
	 *
	 * @param array  $epis La liste des EPI.
	 * @param bool   $new  L'état de l'EPI - nouvel EPI = true.
	 * @param string $page La page de l'EPI.
	 *
	 * @return void
	 */
	public function display_epi_list( $epis, $new = false , $page ) {

		/** VERSION 2
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active('task-manager/task-manager.php') ) {
			$task_manager = true;
		} else {
			$task_manager = false;
		} */

		View_Util::exec(
			'theepi',
			'epi',
			'list',
			array(
				'epis' => $epis,
				'new'  => $new,
				// "'task_manager' => $task_manager,."
			)
		);
	}

	/**
	 * Affiches la vue pagination des EPI.
	 *
	 * @since   0.6.0
	 * @version 0.7.0
	 *
	 * @param integer $offset     Le nombre d'EPI à sauter.
	 * @param string  $page       La page de l'EPI.
	 * @param integer $pagination Le numéro de la page (défault page 1).
	 *
	 * @return void
	 */
	public function display_epi_pagination( $offset, $page, $pagination = 1 ) {

		$pagination_data = $this->get_pagination_data( $offset );
		$data_epis       = $this->get_epis( $pagination_data, '', $page );
		$epis            = $data_epis['epis'];
		$nbr_epis        = $data_epis['nbr_epis'];

		if ( 'all' === $page ) {
			$count_epi = $pagination_data['count_epi'];
		} else {
			$count_epi = $nbr_epis;
		}

		$per_page = $pagination_data['per_page'];

		// Calcul le nombre de page.
		if ( $count_epi > 0 ) {
			$number_pages = intval( $count_epi / $per_page );
			if ( intval( $count_epi % $per_page ) > 0 ) {
				$number_pages++;
			}
		} else {
			$number_pages = 0;
		}

		View_Util::exec(
			'theepi',
			'epi',
			'pagination',
			array(
				'offset'       => $pagination_data['offset'],
				'count_epi'    => $pagination_data['count_epi'],
				'per_page'     => $pagination_data['per_page'],
				'pagination'   => $pagination,
				'number_pages' => $number_pages,
				'page'         => $page,
			)
		);
	}

	/**
	 * Supprimes un EPI.
	 *
	 * @since   0.3.0
	 * @version 0.7.0
	 *
	 * @param integer $id L'ID de l'EPI.
	 *
	 * @return bool  True si tout s'est bien passé.
	 */
	public function delete( $id ) {
		$epi = self::g()->get( array( 'id' => $id ), true );

		$epi->data['status'] = 'trash';

		self::g()->update( $epi->data );
		\eoxia\LOG_Util::g()->log( sprintf( ' EPI "%d" is now trashed, EPI data %s', $epi->data['id'], wp_json_encode( $epi ) ), 'theepi' );

		return true;
	}

	/**
	 * Pour chaque ID de fichier reçu, créer un EPI.
	 *
	 * @since   0.3.0
	 * @version 0.7.0
	 *
	 * @param array $files_id  Un tableau d'ID.
	 *
	 * @return array Les données des EPIS.
	 */
	public function create_mass_epi( array $files_id ) {
		$epis = array();

		if ( ! empty( $files_id ) ) {
			foreach ( $files_id as $file_id ) {
				$file_id = (int) $file_id;

				$epi = $this->create_epi();

				$epi->data['status_epi']  = 'KO';
				$epi->data['post_status'] = 'publish';

				$epi = $this->update( $epi->data );

				WPEO_Upload_Class::g()->set_thumbnail(
					array(
						'id'         => $epi->data['id'],
						'file_id'    => $file_id,
						'model_name' => '\theepi\EPI_Class',
					)
				);

				WPEO_Upload_Class::g()->associate_file(
					array(
						'id'         => $epi->data['id'],
						'file_id'    => $file_id,
						'model_name' => '\theepi\EPI_Class',
						'field_name' => 'image',
					)
				);

				$epis[] = $epi;

				\eoxia\LOG_Util::g()->log( sprintf( 'Create EPI "%d" from media id "%d", saved EPI %s', $epi->data['id'], $file_id, wp_json_encode( $epi->data ) ), 'theepi' );
			}
		}

		return $epis;
	}

	/**
	 * Récupère le nombre de jour restant avant le prochain contrôle de l'EPI.
	 *
	 * @since   0.5.0
	 * @version 0.7.0
	 *
	 * @param EPI_Model $epi      Les données de l'EPI.
	 *
	 * @return integer $day_rest  retourne le nombre de jour.
	 */
	public function get_days( $epi ) {

		$now      = date( 'Y-m-d' );

		$periodicity       = $epi->data['periodicity'];
		$control_date_epi  = $epi->data['control_date']['rendered']['mysql'];
		$last_control_date = $this->get_last_control_date( $epi );

		if ( ! empty( $last_control_date ) ) {
			$control_date_timestamp = strtotime( $last_control_date );
			$last_control_date      = date( 'Y-m-d', strtotime( '+' . $periodicity . ' days', $control_date_timestamp ) );
			$time                   = strtotime( $last_control_date ) - strtotime( $now ); // seconde.
		} else {
			if ( $control_date_epi != '1970-01-01' ) {
				$time = strtotime( $control_date_epi ) - strtotime( $now ); // seconde.
			} else {
				$time = 0;
			}
		}

		if ( $time > 0 ) {
			$day_rest = floor( ( ( $time / 24 ) / 3600 ) );
		} elseif ( $time < 0 ) {
			$day_rest = floor( ( ( $time / 24 ) / 3600 ) );
		} elseif ( $time == 0 ) {
			$day_rest = 0;
		}
		return $day_rest;
	}

	/*
	 * SI TASK MANAGER ACTIVEE.
	// /**
	//  * Affiche les données des audits lié à un EPI.
	//  *
	//  * @since   0.5.0
	//  * @version 0.6.0
	//  *
	//  * @param integer $id  L'id de l'EPI.
	//  *
	//  * @return bool   True si tout s'est bien passé.
	//  */
	//
	// public function display_audit_epi( $id = 0 , $edit_audit = false ) {
	// 	if ( $id == 0 ) {
	// 		return false;
	// 	}
	//
	// 	if ( class_exists( '\task_manager\Audit_Class' ) ) {
	// 		$audits = \task_manager\Audit_Class::g()->get( array( 'post_parent' => $id ) );
	// 	} else {
	// 	}
	//
	// 	$audit = $this->last_control_audit( $audits );
	//
	// 	$epi = EPI_Class::g()->get( array( 'id' => $id ), true );
	// 	if ( ! empty( $audit ) ) {
	//
	// 		$user = get_user_by( 'id', $audit->data['author_id'] );
	// 		\eoxia\View_Util::exec(
	// 			'theepi',
	// 			'audit',
	// 			'audit-epi',
	// 			array(
	// 				'epi'        => $epi,
	// 				'audit'      => $audit,
	// 				'user'       => $user,
	// 				'edit_audit' => $edit_audit,
	// 			)
	// 		);
	// 		return true;
	// 	} else {
	// 		return false;
	// 	}
	// }
	//
	// /**
	//  * Récupère le dernier audit lié à un EPI.
	//  *
	//  * @since   0.5.0
	//  * @version 0.5.0
	//  *
	//  * @param array  $audits       Les données des audits.
	//  *
	//  * @return array $audits[key]  retourne l'audit le plus récent.
	//  */
	//
	// public function last_control_audit( $audits ) {
	//
	// 	if ( empty( $audits ) ) {
	// 		return array();
	// 	}
	//
	// 	$date_start        = 0;
	// 	$date_last_control = 0;
	// 	$key_last_control  = 0;
	// 	foreach ( $audits as $key => $audit ) {
	// 		$date_start = strtotime( $audit->data['date']['rendered']['mysql'] );
	// 		if ( $date_last_control < $date_start ) {
	// 			$date_last_control = $date_start;
	// 			$key_last_control  = $key;
	// 		}
	// 	}
	// 	return $audits[ $key_last_control ];
	// }*/

	/**
	 * Recharge un EPI.
	 *
	 * @since   0.6.0
	 * @version 0.6.0
	 *
	 * @param EPI_Model $epi  Les données de l'EPI.
	 *
	 * @return view  $view    La vue d'un EPI.
	 */
	public function reload_single_epi( $epi ) {
		ob_start();
		View_Util::exec(
			'theepi',
			'epi',
			'item',
			array(
				'epi' => $epi,
			)
		);
		return ob_get_clean();
	}

	/**
	 * Vérifie les capacitées des utilisateurs.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @param string $capabilities  la capacitée à vérifié.
	 *
	 * @return bool  True si l'utilisateur possède la capacitée.
	 */
	public function check_capabilities( $capabilities ) {
		if ( user_can( get_current_user_id(), $capabilities ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Récupère le statut d'un EPI.
	 *
	 * @since   0.5.0
	 * @version 0.7.0
	 *
	 * @param EPI_Model $epi Les donnée d'un EPI.
	 *
	 * @return string $status_epi le statut de l'EPI.
	 */
	public function get_status( $epi ) {
		$status_epi = '';
		if ( $epi->data['id'] != 0 ) {
			if ( $epi->data['disposal_date']['raw'] == '1970-01-01' ) {
				$controls = Control_Class::g()->get_controls( $epi );
				if ( empty( $controls ) ) {
					$status_epi = $epi->data['status_epi'];
				} else {
					$last_control = Control_Class::g()->last_control_epi( $controls );
					if ( ! empty( $last_control ) ) {
						$epi->data['status_epi']          = $last_control->data['status_control'];
						$epi->data['control_date']['raw'] = date( 'Y-m-d', Service_Class::g()->calcul_control_date( strtotime( $last_control->data['control_date']['raw'] ), $epi->data['periodicity'] ) );
						$this->update( $epi->data );
						$status_epi = $last_control->data['status_control'];
					}
				}
			} else {
				$epi->data['status_epi'] = 'trash';

				$epi        = $this->update( $epi->data );
				$status_epi = $epi->data['status_epi'];
			}

			if ( strtotime( $epi->data['control_date']['raw'] ) < ( strtotime( 'now' ) ) ) {
				$epi->data['status_epi'] = 'KO';

				$epi        = $this->update( $epi->data );
				$status_epi = $epi->data['status_epi'];
			}
		}
		return $status_epi;
	}

	/**
	 * Récupère la dernière date de contrôle d'un EPI.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @param EPI_Model $epi Les donnée d'un EPI.
	 *
	 * @return array ['control_date] La date de contrôle.
	 */
	public function get_last_control_date( $epi ) {

		$controls = Control_Class::g()->get_controls( $epi );
		if ( ! empty( $controls ) ) {
			$last_control      = Control_Class::g()->last_control_epi( $controls );
			$last_control_date = date( 'Y-m-d', strtotime( $last_control->data['control_date']['rendered']['mysql'] ) );
		} else {
			$last_control_date = '';
		}
		return $last_control_date;
	}

	/**
	 * Crée un post en status draft.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @return Object $post les données du post.
	 */
	public function draft() {
		$post = $this->get( array( 'schema' => true ), true );

		$post->data['post_status'] = 'draft';

		$post = $this->update( $post->data );
		return $post;
	}

	/**
	 * Crée un ID unique personnalisé pour les EPIS.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @param integer $id L'ID d'un EPI.
	 *
	 * @return string $epi->data['unique_identifier'] L'ID unique personnalisé de l'EPI.
	 */
	public function unique_identifier( $id ) {
		$prefix_site = ! empty( get_option( $this->option_name_acronym_site ) ) ? get_option( $this->option_name_acronym_site ) : 'S';
		$prefix_epi  = ! empty( get_option( $this->option_name_acronym_epi ) ) ? get_option( $this->option_name_acronym_epi ) : 'EPI';

		$epis    = $this->get(
			array(
				'post_type'   => 'theepi-epi',
				'post_status' => array(
					'publish',
					'draft',
					'trash',
				),
			)
		);
		$nb_epis = count( $epis );
		$epi     = $this->get( array( 'id' => $id ), true );

		$epi->data['unique_identifier'] = $prefix_site . get_current_blog_id() . ' - ' . $prefix_epi . $nb_epis;

		$epi = $this->update( $epi->data );

		return $epi->data['unique_identifier'];
	}

	/**
	 * Crée un EPI avec des données par défaut.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @return Object $epi les donées d'un EPI.
	 */
	public function create_epi() {

		$epi = $this->draft();

		$epi->data['periodicity']          = intval( get_option( $this->option_name_default_data_periodicity ) );
		$epi->data['lifetime_epi']         = intval( get_option( $this->option_name_default_data_lifetime ) );
		$epi->data['disposal_date']['raw'] = '1970-01-01';
		$epi->data['unique_identifier']    = $this->unique_identifier( $epi->data['id'] );
		$epi->data['author_id']            = get_current_user_id();

		$epi = $this->update( $epi->data );

		return $epi;
	}

	/**
	 * Récupère le nombre EPIS en fonction du status.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @param string $meta_value Le statut de l'EPI.
	 *
	 * @return integer $nb_epis  Le nombre d'EPI.
	 */
	public function get_nb_epis( $meta_value ) {
		$epis = self::g()->get(
			array(
				'meta_key'    => '_theepi_status_epi',
				'meta_value'  => $meta_value,
				'post_status' => 'publish',
			)
		);

		$nb_epis = count( $epis );
		return $nb_epis;
	}

	public function visible( $option ) {
		$user   = get_current_user_id();
		$visible = get_user_option( $option, $user );
		if ( $visible ) {
			return true;
		} else {
			return false;
		}
	}
}

EPI_Class::g();
