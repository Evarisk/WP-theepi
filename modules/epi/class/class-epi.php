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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle EPI.
 */
class EPI_Class extends \eoxia\Post_Class {


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
	protected $limit_epi = 10;

	/**
	 * le nom de l'option pour enregistrer le nombre d'epi par page (défault).
	 *
	 * @var string
	 */
	public $option_name_per_page = 'epi_per_page';

	/**
	 * le nom de l'option pour enregistrer la périodicité d'un epi (défault).
	 *
	 * @var string
	 */
	public $option_name_default_data_periodicity = 'theepi_default_data_periodicity';

	/**
	 * le nom de l'option pour enregistrer la durée de vie d'un epi (défault).
	 *
	 * @var string
	 */
	public $option_name_default_data_lifetime = 'theepi_default_data_lifetime';


	/**
	 * le nom de l'option pour enregistrer la date d'achat d'un epi (défault).
	 *
	 * @var string
	 */
	public $option_name_date_management_purchase_date = 'theepi_date_management_purchase_date';

	/**
	 * le nom de l'option pour enregistrer la date de fabrication d'un epi (défault).
	 *
	 * @var string
	 */
	public $option_name_date_management_manufacture_date = 'theepi_date_management_manufacture_date';

	/**
	 * le nom de l'option pour enregistrer l'acronym du site (défault).
	 *
	 * @var string
	 */
	public $option_name_acronym_site = 'theepi_acronym_site';

	/**
	 * le nom de l'option pour enregistrer l'acronym d'un epi (défault).
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
		$this->default_data_periodicity = 365;
		$this->default_data_lifetime = 365;
		$this->default_data_purchase_date = true;
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
		if( $page != "all" && $page != "ok" && $page != "ko" && $page != "repair" && $page != "trash" ){
			$page = "all";
		}

		$epi_schema = self::g()->get(
			array(
				'schema' => true,
			), true
		);

		$pagination_data = $this->get_pagination_data( 0, $term );

		$data_epis = $this->get_epis( $pagination_data, $term, $page );
		$epis = $data_epis['epis'];

		\eoxia\View_Util::exec(
			'theepi', 'epi', 'main', array(
				'offset'     => $pagination_data['offset'],
				'count_epi'  => $pagination_data['count_epi'],
				'per_page'   => $pagination_data['per_page'],
				'epis'       => $epis,
				'epi_schema' => $epi_schema,
				'term'       => $term,
				'page'       => $page
			)
		);
	}

	/**
	 * Récupères la liste des EPI.
	 *
	 * @since   0.4.0
	 * @version 0.7.0
	 *
	 * @param array  ['offset']    		(integer) Le nombre d'EPI à sauter.
	 * 				 ['posts_per_page'] (integer) le nombre d'EPI par page.
	 *
	 * @param string $term Terme de la recherche. Défault ''.
	 * @param string $page La page de l'EPI.
	 *
	 * @return array ['epis']     (array)   Les EPIS en fonction de la page.
	 * 				 ['nbr_epis'] (integer) le nombre d'EPI en fonction de la page.
	 */
	public function get_epis( $data, $term = '', $page ) {
		$args = array(
			'offset'         => $data['offset'],
			'posts_per_page' => $data['per_page'],
			's'              => $term,
		);

		$status    = mb_strtoupper( $page );
		switch ( $status ) {
			case 'OK':
			$temp_args = array(
				'meta_key' => '_theepi_status_epi',
				'meta_value' => 'OK'
			);
			break;
			case 'KO':
			$temp_args = array(
				'meta_key' => '_theepi_status_epi',
				'meta_value' => 'KO'
			);
			break;
			case 'REPAIR':
			$temp_args = array(
				'meta_key' => '_theepi_status_epi',
				'meta_value' => 'repair'
			);
			break;
			case 'TRASH':
			$temp_args = array(
				'meta_key' => '_theepi_status_epi',
				'meta_value' => 'trash'
			);
			break;
			default:
				$temp_args = array();
				break;

		}
		$args = wp_parse_args( $temp_args, $args );

		$epis = self::g()->get( $args );
		$nbr_epis = count( self::g()->get( $temp_args ) );
		$data_epis = array( 'epis' => $epis, 'nbr_epis' => $nbr_epis );

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
		\eoxia\View_Util::exec( 'theepi', 'epi', 'search' );
	}

	/**
	 * Appel la vue pour afficher les filtres des EPI
	 *
	 * @since   0.4.0
	 * @version 0.4.0
	 *
	 * @return void
	 */
	public function display_filters() {
		\eoxia\View_Util::exec( 'theepi', 'epi', 'filters' );
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
	 * 				 ['count_epi'] (integer) le nombre d'EPI en base de donnée.
	 * 				 ['per_page']  (integer) Le nombre d'EPI par page.
	 */
	public function get_pagination_data( $offset = 0, $term = '' ) {

		$count_epi = count(
			self::g()->get(
				array(
					'fields' => array( 'ID' ),
					's'      => $term,
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

		//VERSION 2
		// include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		//  if ( is_plugin_active('task-manager/task-manager.php') ) {
		// 	$task_manager = true;
		// } else {
		// 	$task_manager = false;
		// }

		\eoxia\View_Util::exec(
			'theepi', 'epi', 'list', array(
				'epis' => $epis,
				'new'  => $new,
				//'task_manager' => $task_manager
			)
		);
	}

	/**
	 * Affiches la vue pagination des EPI.
	 *
	 * @since   0.6.0
	 * @version 0.7.0
	 *
	 * @param integer  $offset     Le nombre d'EPI à sauter.
	 * @param string   $page       La page de l'EPI.
	 * @param integer  $pagination Le numéro de la page (défault page 1).
	 *
	 * @return void
	 */
	public function display_epi_pagination( $offset, $page, $pagination = 1 ) {

		$pagination_data = $this->get_pagination_data( $offset );
		$data_epis = $this->get_epis( $pagination_data, '', $page );
		$epis = $data_epis['epis'];
		$nbr_epis = $data_epis['nbr_epis'];

		if ( ( $page == 'ok') || ( $page == 'ko') || ( $page == 'trash' ) || ( $page == 'repair' ) ) {
			$count_epi = $nbr_epis;
		}else {
			$count_epi = $pagination_data['count_epi'];
		}

		$per_page = $pagination_data['per_page'];

		//Calcul le nombre de page
		if( $count_epi > 0 ) {
			$number_pages = intval( $count_epi / $per_page );
			if( intval( $count_epi % $per_page ) > 0 ) {
				$number_pages++;
			}
		}else {
			$number_pages = 0;
		}

		\eoxia\View_Util::exec(
			'theepi', 'epi', 'pagination', array(
				'offset'       => $pagination_data['offset'],
				'count_epi'    => $pagination_data['count_epi'],
				'per_page'     => $pagination_data['per_page'],
				'pagination'   => $pagination,
  				'number_pages' => $number_pages,
				'page'         => $page

			)
		);
	}

	/**
	 * Enregistres un EPI.
	 *
	 * @since   0.3.0
	 * @version 0.3.0
	 *
	 * @param EPI_Model $epi      Les données de l'EPI.
	 * @param integer   $image_id L'ID de l'image téléversé.
	 *
	 *  ['post_id'] integer L'ID de l'EPI. (Ce n'est pas un doublon avec $data['id']).
	 *  ['id']      integer L'ID du commentaire.
	 *  ['date']    string  La date du commentaire au format MySQL.
	 *  ['content'] string  Le contenu du commentaire.
	 *  ['state']   string  Le status de l'EPI. Peut être OK ou KO.
	 *
	 * @param array     $comments (See above).
	 *
	 * @return EPI_Model Retourne l'objet EPI créé ou mise à jour.
	 */
	public function save( $epi, $image_id, $comments ) {
		$epi = self::g()->update( $epi->data );
		\eoxia\LOG_Util::g()->log( sprintf( 'Update EPI "%d" with the data %s', $epi->data['id'], wp_json_encode( $epi->data ) ), 'theepi' );

		if ( ! empty( $image_id ) ) {
			$args_media = array(
				'id'         => $epi->data['id'],
				'file_id'    => $image_id,
				'model_name' => '\theepi\EPI_Class',
			);

			\eoxia\WPEO_Upload_Class::g()->set_thumbnail( $args_media );
			$args_media['field_name'] = 'image';
			\eoxia\WPEO_Upload_Class::g()->associate_file( $args_media );

			\eoxia\LOG_Util::g()->log( sprintf( 'Add media on EPI "%d", media ID "%d"', $epi->data['id'], $image_id ), 'theepi' );
		}

		// Obliger de get à nouveau pour récupérer control_date, et state.
		$epi = self::get( array( 'id' => $epi->data['id'] ), true );

		return $epi;
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
	 * @param array  $files_id  Un tableau d'ID.
	 *
	 * @return bool True si tout s'est bien passé.
	 */
	public function create_mass_epi( array $files_id ) {
		$epis = array();

		if ( get_option( $this->option_name_default_data_periodicity ) != "" ){
			$periodicity =  (int) get_option( $this->option_name_default_data_periodicity );
		}else {
			$periodicity = $this->default_data_periodicity;
		}

		if ( get_option( $this->option_name_default_data_lifetime ) != "" ){
			$lifetime =  (int) get_option( $this->option_name_default_data_lifetime );
		}else {
			$lifetime = $this->default_data_lifetime;
		}

		if ( ! empty( $files_id ) ) {
			foreach ( $files_id as $file_id ) {
				$file_id = (int) $file_id;
				$epi   = self::g()->create(
					array(
						'periodicity'  => $periodicity,
						'lifetime_epi' => $lifetime,
						'status_epi'   => 'KO',
						'disposal_date' => '1970-01-01'
					)
				);

				\eoxia\WPEO_Upload_Class::g()->set_thumbnail(
					array(
						'id'         => $epi->data['id'],
						'file_id'    => $file_id,
						'model_name' => '\theepi\EPI_Class',
					)
				);

				\eoxia\WPEO_Upload_Class::g()->associate_file(
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
	 * @param array    $epi        Les données de l'EPI.
	 *
	 * @return integer $day_rest   retourne le nombre de jour.
	 */
	public function get_days( $epi ) {

		$day_rest      = 0;
		$now = date( 'Y-m-d' );
		$periodicity = $epi->data['periodicity'];
		$control_date_epi = $epi->data['control_date']['rendered']['mysql'];
		$last_control_date = $this->get_last_control_date( $epi );

		if ( $last_control_date != "" ) {
			$control_date_timestamp = strtotime( $last_control_date );
			$last_control_date = date( 'Y-m-d',  strtotime( '+' . $periodicity . ' days' , $control_date_timestamp ));
			$time = strtotime( $last_control_date ) - strtotime( $now ); // seconde
		}else {
			$time = strtotime( $control_date_epi ) - strtotime( $now ); // seconde
		}

		if ( $time > 0 ) {
			$day_rest = floor( ( ( $time / 24 ) / 3600 ) );
			return $day_rest;

		} else {
			$day_rest = floor( ( ( $time / 24 ) / 3600 ) );
			return $day_rest;
		}
		return $day_rest;
	}

	//SI TASK MANAGER ACTIVEE.
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
	// }

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
		\eoxia\View_Util::exec(
			'theepi', 'epi', 'item', array(
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
	 * @param object $epi Les donnée d'un EPI.
	 *
	 * @return array ['status_epi] le statut de l'EPI.
	 */
	public function get_status( $epi ) {
		if ( $epi->data['id'] != 0 ) {
			if ( $epi->data['disposal_date']['raw'] == '1970-01-01' ) {
				$controls = Control_Class::g()->get_controls( $epi );
				$last_control = Control_Class::g()->last_control_epi( $controls );
				if ( ! empty( $last_control ) ) {
					$epi->data['status_epi'] = $last_control->data['status_control'];
					$epi = $this->update( $epi->data );
					return $last_control->data['status_control'];
				}
				return $epi->data['status_epi'];
			}else {
				$epi->data['status_epi'] = 'trash';
				$epi = $this->update( $epi->data );
				return $epi->data['status_epi'];
			}
		}
	}

	/**
	 * Récupère la dernière date de contrôle d'un EPI.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @param object $epi Les donnée d'un EPI.
	 *
	 * @return array ['control_date] La date de contrôle.
	 */
	public function get_last_control_date( $epi ) {

		$controls = Control_Class::g()->get_controls( $epi );
		if ( ! empty( $controls ) ) {
			$last_control = Control_Class::g()->last_control_epi( $controls );
			$last_control_date = date( 'Y-m-d' , strtotime( $last_control->data['date']['rendered']['mysql'] ));
		}else {
			$last_control_date = "";
		}
		return $last_control_date;
	}

	/**
	 * Crée un post en status draft.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @return POST $post les données du post.
	 */
	public function draft() {
		$post = $this->get( array( 'post_status' => 'draft' ), true );
		if ( ! empty ( $post ) ) {
			$post = $this->delete( $post->data['id'] );
		}
		$post = $this->get( array( 'schema' => true ), true );
		$post->data['post_status'] = 'draft';
		$post = $this->update( $post->data );
		$post = $this->get( array( 'post_status' => 'draft' ), true );
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
		$prefix_site = get_option( $this->option_name_acronym_site );
		$prefix_epi = get_option( $this->option_name_acronym_epi );
		$epi = $this->get( array( 'id' => $id ), true );
		$epi->data['unique_identifier'] = $prefix_site . get_current_blog_id() . ' - ' . $prefix_epi . $epi->data['unique_key'];
		$epi = $this->update( $epi->data );
		return $epi->data['unique_identifier'];
	}

}

EPI_Class::g();
