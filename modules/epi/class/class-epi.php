<?php
/**
 * Handle EPI.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 0.3.0
 * @copyright 2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle EPI
 */
class EPI_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\theepi\EPI_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type = 'theepi-epi';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_theepi_epi';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'theepi/epi';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_post_function = array( '\theepi\construct_identifier' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\theepi\get_identifier', '\theepi\update_remaining_time' );

	/**
	 * Le préfixe de l'objet dans TheEPI.
	 *
	 * @var string
	 */
	public $element_prefix = 'EPI';

	/**
	 * La limite des risques a affiché par page
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
	 * Le nom pour le register post type
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
	 * Appel la vue principale pour afficher le tableau HTML contenant les EPI.
	 *
	 * @since 0.2.0
	 * @version 0.3.0
	 *
	 * @param integer $current_page The current page.
	 *
	 * @return void
	 */
	public function display( $current_page = 1 ) {
		$epi_schema = self::g()->get( array(
			'schema' => true,
		), true );

		$count_epi = count( self::g()->get( array(
			'fields' => array( 'ID' ),
		) ) );

		$per_page = get_user_meta( get_current_user_id(), $this->option_name_per_page, true );

		if ( empty( $per_page ) || $per_page < 1 ) {
			$per_page = $this->limit_epi;
		}

		$number_page = ceil( $count_epi / $per_page );

		\eoxia\View_Util::exec( 'theepi', 'epi', 'main', array(
			'count_epi'    => $count_epi,
			'number_page'  => $number_page,
			'current_page' => $current_page,
			'epi_schema'   => $epi_schema,
		) );
	}

	/**
	 * Initialise les options d'écrans.
	 *
	 * @since 0.2.0
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
	 * Charges et affiches la liste des EPI
	 *
	 * @since 0.1.0
	 * @version 0.3.0
	 *
	 * @param integer $current_page The current page.
	 *
	 * @return void
	 */
	public function display_epi_list( $current_page = 1 ) {
		$per_page = get_user_meta( get_current_user_id(), $this->option_name_per_page, true );

		if ( empty( $per_page ) || $per_page < 1 ) {
			$per_page = $this->limit_epi;
		}

		$args = array(
			'offset'         => ( $current_page - 1 ) * $per_page,
			'posts_per_page' => $per_page,
		);

		$epi_list = self::g()->get( $args );

		\eoxia\View_Util::exec( 'theepi', 'epi', 'list', array(
			'epi_list' => $epi_list,

		) );
	}

	/**
	 * Enregistres un EPI.
	 *
	 * @since 0.3.0
	 * @version 0.3.0
	 *
	 * ['id']                integer L'ID de l'EPI.
	 * ['image']             integer L'ID de l'image téléversé. #doublon avec $image_id.
	 * ['title']             string  Le titre de l'EPI
	 * ['serial_number']     string  Le numéro de série de l'EPI.
	 * ['frequency_control'] integer Le nombre de jour avant le prochain contrôle.
	 * @param  array   $data     (See above).
	 * @param  integer $image_id L'ID de l'image téléversé.
	 *
	 * ['post_id'] integer L'ID de l'EPI. (Ce n'est pas un doublon avec $data['id']).
	 * ['id']      integer L'ID du commentaire.
	 * ['date']    string  La date du commentaire au format MySQL.
	 * ['content'] string  Le contenu du commentaire.
	 * ['state']   string  Le status de l'EPI. Peut être OK ou KO.
	 * @param  array   $comments (See above).
	 *
	 * @return EPI_Model Retourne l'objet EPI créé.
	 */
	public function save( array $data, $image_id, array $comments ) {
		$epi = self::g()->update( $data );
		\eoxia\LOG_Util::g()->log( sprintf( 'Update EPI "%d" with the data %s', $epi->id, wp_json_encode( $data ) ), 'theepi' );

		if ( ! empty( $image_id ) ) {
			$args_media = array(
				'id'         => $epi->id,
				'file_id'    => $image_id,
				'model_name' => '\theepi\EPI_Class',
			);

			\eoxia\WPEO_Upload_Class::g()->set_thumbnail( $args_media );
			$args_media['field_name'] = 'image';
			\eoxia\WPEO_Upload_Class::g()->associate_file( $args_media );

			\eoxia\LOG_Util::g()->log( sprintf( 'Add media on EPI "%d", media ID "%d"', $epi->id, $image_id ), 'theepi' );
		}

		EPI_Comment_Class::g()->save_comments( $epi->id, $comments );

		return $epi;
	}

	/**
	 * Supprimes un EPI.
	 *
	 * @since 0.3.0
	 * @version 0.3.0
	 *
	 * @param  integer $id L'ID de l'EPI.
	 *
	 * @return bool        True si tout s'est bien passé.
	 */
	public function delete( $id ) {
		$epi = self::g()->get( array(
			'id' => $id,
		), true );

		$epi->status = 'trash';

		self::g()->update( $epi );
		\eoxia\LOG_Util::g()->log( sprintf( ' EPI "%d" is now trashed, EPI data %s', $epi->id, wp_json_encode( $epi ) ), 'theepi' );

		return true;
	}

	/**
	 * Pour chaque ID de fichier reçu, créer un EPI.
	 *
	 * @since 0.3.0
	 * @version 0.3.0
	 *
	 * @param array $files_id Un tableau d'ID.
	 *
	 * @return bool           True si tout s'est bien passé.
	 */
	public function create_mass_epi( array $files_id ) {
		if ( ! empty( $files_id ) ) {
			foreach ( $files_id as $file_id ) {
				$epi = self::g()->update( array() );

				\eoxia\WPEO_Upload_Class::g()->set_thumbnail( array(
					'id'         => $epi->id,
					'file_id'    => $file_id,
					'model_name' => '\theepi\EPI_Class',
				) );

				\eoxia\WPEO_Upload_Class::g()->associate_file( array(
					'id'         => $epi->id,
					'file_id'    => $file_id,
					'model_name' => '\theepi\EPI_Class',
					'field_name' => 'image',
				) );

				\eoxia\LOG_Util::g()->log( sprintf( 'Create EPI "%d" from media id "%d", saved EPI %s', $epi->id, $file_id, wp_json_encode( $epi ) ), 'theepi' );
			}
		}

		return true;
	}
}

EPI_Class::g();
